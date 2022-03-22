var tableManage;
var tableFundManage;
var tableExpensesManage;
var tableExpensesManageSort;
var title_header1=[];
var title_header2=[];
var title_header3=[];
var title_header4=[]; // floyd bago
var title1;
var title2;
var title3;
var i1 = 0;
var i2 = 0;
var i3 = 0;
var i4 = 0;
var search_where_option_fund;
var which_is_active ='audit_report_tab';
var audit_dashboard_tab_bool = false;
var audit_report_tab_bool = true;
var audit_fund_tab_bool = false;
var audit_expense_tab_bool = false;
var audit_rep_mon_bool = false;
var endorse_id;
var acct_ci_dl_id;
var what_to_submit_Tab6 = 'oims_id';
var what_logs = 'audit_report_form';
var general_audit_logs_table;
var general_audit_logs_table_title = [];
var general_audit_logs_table_counts = 0;
var tab6uploadBool;
var tableAuditRepMoni; // floyd bago
var checkAuditLogComp = false;
var partial_audit_logs_table_title = [];
var partial_audit_logs_table_counts = 0;
var partial_audit_logs_table;
var audit_rep_bool = true;
var audit_moni_bool = false;
var openHrefAudit  = 'tab_log1';
var audit_submitted_bool = true;
var audit_partial_bool = false;
var openStatBool = 'tab_submitted';
var submitCounter = false;
var saveCounter = false;
var saveSubmitTypeArf;
var saveSubmitPf;
var saveSubmitCssf;

var discrep_fine_bool = false;
var discrep_fine_array = [];
var discrep_fine_checker = false;

var ciRep_fine_array = [];
var ciRep_fine_checker = false;

var field_fine_array = [];
var field_fine_checker = false;

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

function format (d)
{
    return 'Full name: '+d.account_name;
}

// zoom();
function zoom() {
    document.body.style.zoom = "70%"
}


$(document).ready(function ()
{
    showHead();
    $('#viewAttachSavedArf').hide();
    $('#viewAttachmentPhoneField').hide();
    $('#viewAttachmentCssf').hide();

    function showHead()
    {
        $.ajax
        ({
            type : 'get',
            url : 'audit-get-access-show',
            success : function(data)
            {
                if(data ==  'Head')
                {
                    $('#showToAuditHead').show();
                }
                else
                {

                }
            }
        });
    }

    $('#btnSaveIncentDed').hide();
    $('#afterClickRepCi').hide();
    
    // $( ".gen_mon_date_range_dates" ).datepicker({orientation: "bottom"});
    // $( ".gen_mon_date_range_dates_cc" ).datepicker({orientation: "bottom"});

    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
    $( "#datepickermax" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});

    $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
    $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});


    var today = new Date();
    var yearmonth;
    var date;

    $('.date_range_conts').css('display','none');
    $('#min').val('2015-01-01');
    $('#max').val('6000-01-01');

    $('.date_range_conts_report').css('display','none');
    $('#min_report').val('2015-01-01');
    $('#max_report').val('6000-01-01');

    audit_report_table();

    $('.audit_a_class').click(function ()
    {
        var gethref = $(this).attr('href');

        if(gethref == '#audit_log_report_tab')
        {
            getLogsFunction(what_logs);
            // if(!discrep_fine_bool)
            // {
            //     // get_uploader_discrepancy();
            //
            //     $('#trigger-fine-discrep').click(function()
            //     {
            //         $('#qq-audit-discrepancy-form-fine-holder').fineUploader('uploadStoredFiles');
            //
            //     });
            //
            //     discrep_fine_bool = true;
            // }
            checkReturnNotif();
        }

        console.log(gethref);


        if(gethref == '#audit_dashboard_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_dashboard_tab';

            }
            else if(audit_dashboard_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'audit_dashboard_tab';

            }
            else if(audit_dashboard_tab_bool == false)
            {
                audit_dashboard_tab_bool = true;
                which_is_active = 'audit_dashboard_tab';
            }
        }
        else if(gethref == '#audit_report_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_report_tab';

            }
            else if(audit_report_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'audit_report_tab';

            }
            else if(audit_report_tab_bool == false)
            {
                audit_report_tab_bool = true;
                which_is_active = 'audit_report_tab';
                audit_report_table();

            }
        }
        else if(gethref == '#audit_fund_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_fund_tab';

            }
            else if(audit_fund_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'audit_fund_tab';

            }
            else if(audit_fund_tab_bool == false)
            {
                audit_fund_tab_bool = true;
                which_is_active = 'audit_fund_tab';
                fund_request_report_table();
            }
        }
        //floyd bago
        else if(gethref == '#audit_reports_monitoring')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_reports_monitoring';

            }
            else if(audit_rep_mon_bool)
            {
                if(checkAuditLogComp == true)
                {
                    tableAuditRepMoni.ajax.reload(null, false);
                    checkAuditLogComp = false;
                }
                else
                {
                    console.log('already loaded');
                }
                which_is_active = 'audit_reports_monitoring';

            }
            else if(audit_rep_mon_bool == false)
            {
                audit_rep_mon_bool = true;
                which_is_active = 'audit_reports_monitoring';
                audit_report_mon_table();
            }
        }
        //
        else if(gethref == '#audit_expense_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_expense_tab';

            }
            else if(audit_expense_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'audit_expense_tab';

            }
            else if(audit_expense_tab_bool == false)
            {
                audit_expense_tab_bool = true;
                which_is_active = 'audit_expense_tab';
                faTablesCi();
            }
        }
        else if(gethref == '#audit_cc_rep')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'audit_cc_rep';

            }
            else if(tele_ci_gen_table_bool)
            {
                console.log('already loaded');
                which_is_active = 'audit_cc_rep';

            }
            else if(tele_ci_gen_table_bool == false)
            {
                tele_ci_gen_table_bool = true;
                which_is_active = 'audit_cc_rep';
                get_general_mon_table();
            }
        }

        // $('#qq-audit-discrepancy-form-fine').html();

    });

    $('.viewable').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable#rad_all_fin').prop('checked',true);
                $('.viewable#rad_all_pends').prop('checked',true);

                $('.date_range_conts').css('display','none');

                $('#min').val('2015-01-01');
                $('#max').val('6000-01-01');
                search_where_option_fund = 'fund_requests.dispatcher_request_date';

                tableFundManage.draw();
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable#rad_daterange_fin').prop('checked',true);
                $('.viewable#rad_daterange_pends').prop('checked',true);

                $('.date_range_conts').css('display','');

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

                $('#datepicker').val(month+dateyear);
                $('#datepickermax').val(month+dateyear);

                $('#min').val(yearmonth+date);
                $('#max').val(yearmonth+date);

                // tableFundManage.draw();

                //pending

            }
        }
    });

    $('.viewable_report').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable_report#rad_all_report').prop('checked',true);
                // $('.viewable_report#rad_all_pends').prop('checked',true);

                $('.date_range_conts_report').css('display','none');

                $('#min_report').val('2015-01-01');
                $('#max_report').val('6000-01-01');
                // search_where_option_fund = 'fund_requests.dispatcher_request_date';

                tableManage.draw();
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable_report#rad_daterange_report').prop('checked',true);
                // $('.viewable_report#rad_daterange_pends').prop('checked',true);

                $('.date_range_conts_report').css('display','');

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

                $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker_report').val(month+dateyear);
                $('#datepickermax_report').val(month+dateyear);

                $('#min_report').val(yearmonth+date);
                $('#max_report').val(yearmonth+date);

                tableManage.draw();

                //pending

            }
        }
    });

    $('#select_search_option').change(function () {

        console.log($(this).val());

        if($(this).val() == 'dispatcher_request')
        {
            search_where_option_fund = 'fund_requests.dispatcher_request_date';
        }
        else if($(this).val() == 'sao_approved_date')
        {
            search_where_option_fund = 'fund_requests.sao_approved_date';
        }
        else if($(this).val() == 'finance_approved_date')
        {
            search_where_option_fund = 'fund_requests.finance_approved_date';
        }
        else if($(this).val() == 'finance_sent_date')
        {
            search_where_option_fund = 'fund_requests.delivered_date';
        }
        else if($(this).val() == 'finance_confirm_date')
        {
            search_where_option_fund = 'ci_fund_remittances.confirm_date_time'
        }

        tableFundManage.draw();
    });

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
        tableFundManage.draw();
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
        tableFundManage.draw();
    });

    $('#datepicker_report').change( function() {
        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report').datepicker('getDate'));
        console.log(min);
        $('#min_report').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report').datepicker('getDate'));
        console.log(max);

        if(max === '')
        {
            $('#max_report').val(yearmonth+date);

        }
        else {
            $('#max_report').val(max);
        }
        tableManage.draw();
    });
    $('#datepickermax_report').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report').datepicker('getDate'));
        console.log(min);
        $('#min_report').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report').datepicker('getDate'));
        console.log(max);
        if(max === '')
        {
            $('#max_report').val(yearmonth+date);

        }
        else {
            $('#max_report').val(max);
        }
        tableManage.draw();
    });

    $('.viewable#rad_all_fin').prop('checked',true);
    $('.viewable#rad_all_pends').prop('checked',true);

    $('.viewable_report#rad_all_report').prop('checked',true);


    oims_bank_ids();

    $('#search_oims_bank_id').click(function ()
    {
        $('.messenger_type').attr('disabled', true);

        var get_id = $('#autoComId').val();

        if(get_id == '')
        {
            alert('Please enter a valid ID.');
        }
        else
        {
            $.ajax
            ({
                url: 'audit_get_oims_bank_info',
                type: 'get',
                data:{
                    'id' : get_id
                },
                success: function (data)
                {
                    if(data.length == 0)
                    {
                        alert('Invalid OIMS ID!');
                    }
                    else if(data.length > 0)
                    {
                        console.log(data);
                        var busName;
                        var empName;

                        if(data[0].busname == null)
                        {
                            busName = '';
                        }
                        else
                        {
                            busName = data[0].busname;
                        }
                        if(data[0].emp_name == null)
                        {
                            empName = '';
                        }
                        else
                        {
                            empName = data[0].emp_name;
                        }

                        $('#full_name_company').val(data[0].account_name);
                        $('#business_name').val(busName+empName);
                        $('#full_address').val(data[0].address+' '+data[0].muni);
                        $('#special_instruction').val(data[0].remarks);
                        $('#client_name').val(data[0].client_name);
                        $('#type_of_request').val(data[0].tor);
                        $('#endorsement_date').val(data[0].date_endorsed);
                        $('#submission_date').val(data[0].submission_date);
                        $('#internal_tat').val(data[0].internal_status);
                        $('#external_tat').val(data[0].external_status);
                        $('#type_of_checking').val(data[0].type_of_check)

                        $('#dlAttachmentCiReport').attr('href', get_id);
                        $('.date_change').attr('type' , 'text');
                    }
                },
                error: function () {
                    alert('Cannot find match for this ID.');
                }
            });
        }
    });

});

function get_uploader_discrepancy(id)
{
    $('#qq-audit-discrepancy-form-fine-holder').html('');

    $('#qq-audit-discrepancy-form-fine-holder').fineUploader
    ({
        template: 'qq-audit-discrepancy-form-fine/' + id,
        request:
            {
                endpoint: 'audit_discrepancy_fine_uploader',
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                // itemLimit: 3,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'wmv', 'mp3', 'mov', 'mkv', '3gp', 'txt']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        discrep_fine_array.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        discrep_fine_array.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    submittedFilesArray = [];
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}


function oims_bank_ids()
{

    $.ajax({
        url: 'audit_get_oims_bank_id_list',
        type: 'get',
        success: function (data) {

            var ids = '';

            for(var ctr = 0; ctr<data.length; ctr++)
            {
                ids += '<option value="'+data[ctr].id+'">'+data[ctr].id+'</option>';
            }


            $('#inputOimsIdAuditRep').html('<option value="-">-</option>'+ids);

        },
        error: function () {
            console.log('error');
        }

    });
}

function audit_report_table()
{

    $('#audit-table-reports thead th').each(function()
    {
        title_header1[i1] = $(this).text();
        i1++;
        title1 = $(this).text();
        $(this).html(title1+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    tableManage = $('#audit-table-reports').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header1[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header1[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header1[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header1[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/audit-table-report",
                data: function (d)
                {
                    d.min_date_endorsed = $('#min_report').val();
                    d.max_date_endorsed = $('#max_report').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'bank', name: 'endorsements.client_name'},
                {data: 'date', name: 'endorsements.date_endorsed'},
                {
                    data : function dt(data)
                    {
                        return data.date_visit + ' ' + data.time_visit;
                    },
                    name : 'endorsements.date_ci_visit',
                    visible : false
                },
                {
                    data: function acctname(data)
                    {
                        return '<button type = "button" style = "text-decoration: underline; background:none ; border:none; " value = "' + data.id + '" id = "hyperlink_name"> <strong>'+ data.account +'</strong>  </button>';
                    },
                    name: 'endorsements.account_name',

                },
                {data: 'address', name: 'endorsements.address'},
                {data: 'city_muni', name: 'municipalities.muni_name'},
                {data: 'achipelago', name: 'archipelagos.archipelago_name'},
                // {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'tor_with_name', name: 'endorsements.type_of_request'},
                {data: 'dispatcher', name: 'endorsements.handled_by_dispatcher'},
                {data: 'ci', name: 'endorsements.handled_by_credit_investigator'},
                {data: 'ao', name: 'endorsements.handled_by_account_officer'},
                {data: 'srao', name: 'endorsements.assigned_by_srao'},
                {
                    data : function incentdeduct(data)
                    {
                        var incent;
                        var deduct;

                        if(data.incentives == null)
                        {
                            incent = 0;
                        }
                        else
                        {
                            incent = data.incentives;
                        }

                        if(data.deduction == null)
                        {
                            deduct = 0;
                        }
                        else
                        {
                            deduct = data.deduction;
                        }

                        var laman = 'Incentives : ₱ ' + incent + '<br><br>' +
                            'Deduction : ₱ ' + deduct;

                        return laman;
                    },
                    "searchable" : false
                },
                {
                    data : function action(data)
                    {
                        var acct_stat;

                        if(data.status == '1')
                        {
                            acct_stat =  '<span><button type = "button" class = "btn btn-sm btn-info" disabled style="width: 100%" ><i class = "fa fa-fw fa-location-arrow"></i>New Endorsement</button></span><br>';
                        }
                        else if(data.status = '2')
                        {
                            acct_stat = '<span><button type = "button" class = "btn btn-sm btn-warning" disabled style="width: 100%"><i class = "fa fa-fw fa-spinner"></i>On Process</button></span><br>';
                        }
                        else if(data.status = '3')
                        {
                            acct_stat = '<span><button type = "button" class = "btn btn-sm btn-success" disabled style="width: 100%" ><i class = "fa fa-fw fa-location-arrow"></i>finished</button></span><br>';
                        }

                        if(data.ci_cert == 'C')
                        {
                            return acct_stat +
                                '<span><button class="btn btn-md btn-info" id="btnChooseFileDlCi" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download CI Report</button></span><br>' +
                                '<button class="btn btn-md btn-primary btn-block audit_view_note" value="'+data.id+'" name="'+data.account+'" data-toggle="modal" data-target="#modal-ci-note"><i class="glyphicon glyphicon-file"></i> View C.I Note</button>';
                        }
                        else
                        {
                            return acct_stat +
                                '<span><button class="btn btn-md btn-info" id="btnChooseFileDlCi" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download CI Report</button></span><br>' +
                                '<span><button class="btn btn-md btn-danger" id="btnDlAoReport" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download AO Report</button><span id = "downAo"></span></span>' +
                                '<button class="btn btn-md btn-primary btn-block audit_view_note" value="'+data.id+'" name="'+data.account+'" data-toggle="modal" data-target="#modal-ci-note"><i class="glyphicon glyphicon-file"></i> View C.I Note</button>';
                        }
                    },
                    "searchable" : false
                }


            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#audit-table-reports_filter input').unbind();
    $('#audit-table-reports_filter input').bind('keyup change',function (e) {

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

    search_where_option_fund = 'fund_requests.dispatcher_request_date';

}

function fund_request_report_table() {

    $('#fund-audit-table-reports thead th').each(function()
    {
        title_header2[i2] = $(this).text();
        i2++;
        title2 = $(this).text();
        $(this).html(title2);
    });
    tableFundManage = $('#fund-audit-table-reports').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header2[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header2[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header2[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header2[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,audit-fund-table-report
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/audit-fund-table-report",
                data: function (d)
                {
                    d.min_date_endorsed = $('#min').val();
                    d.max_date_endorsed = $('#max').val();
                    d.search_option = search_where_option_fund;
                }
            },
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
                {
                    data: function fund_req_by(data)
                    {
                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            return data.sao_name;
                        }
                        else
                        {
                            return data.dispatch_name;
                        }
                    },
                    'name': 'fund_requests.id'
                },
                {data: 'ci_id', name: 'sao_name.name'},
                {data: 'id_names', name: 'ci_name_table.name'},
                {data: 'id_count', name: 'ci_id'},
                {
                    data: function requestor_remarks(data)
                    {
                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            return '<button class="btn btn-xs btn-primary btn-req-rem-view-fund" name ="'+data.sao_remarks+'" data-toggle="modal" data-target="#modal-view-fund-req-rems">View Requestor Remarks</button>';
                        }
                        else
                        {
                            return '<button class="btn btn-xs btn-primary btn-req-rem-view-fund" name ="'+data.disp_remarks+'" data-toggle="modal" data-target="#modal-view-fund-req-rems">View Requestor Remarks</button>';
                        }
                    },
                    'name': 'fund_requests.id'
                },
                {
                    data: function fund_req_by(data)
                    {
                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            return data.sao_req;
                        }
                        else
                        {
                            return data.disp_date;
                        }
                    },
                    'name': 'fund_requests.id'
                },
                {data: 'type_of', name: 'fund_requests.type_of_fund_request'},
                {
                    data: function orig_amount(data)
                    {
                        return atob(data.orig_amount);
                    },
                    'name': 'fund_requests.id'
                },
                {
                    data: function approver_name (data)
                    {
                        var name = '';

                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            if(data.manage_name != null)
                            {
                                name = data.manage_name;
                            }
                            else
                            {
                                name = 'NO APPROVER YET'
                            }
                        }
                        else if(data.type_of == 'NORMAL REQUEST')
                        {
                            if(data.sao_name != null)
                            {
                                name = data.sao_name;
                            }
                            else
                            {
                                name = 'NO APPROVER YET'
                            }
                        }

                        return name;
                    },
                    'name' : 'fund_requests.id',
                    'orderable' : false
                },
                {
                    data: function rem_approver(data)
                    {
                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            return data.sao_remarks;
                        }
                        else
                        {
                            return data.management_remarks_approved;
                        }
                    },
                    'name': 'fund_requests.id'
                },
                {
                    data: function date_time_approved(data)
                    {
                        if(data.type_of == 'EMERGENCY FUND')
                        {
                            return data.management_approved_date;
                        }
                        else
                        {
                            return data.sao_approved_date;
                        }
                    },
                    'name': 'fund_requests.id'
                },
                {
                    data: function amount(data)
                    {
                        return atob(data.orig_amount);
                    },
                    'name': 'fund_requests.id'
                },
                {data: 'uploader_name', name: 'uploader_name.name'},
                {data: 'remittance_or_atm', name: 'fund_requests.id'},
                {
                    data: function amount(data)
                    {
                        return atob(data.amount);
                    },
                    'name': 'fund_requests.id'
                },
                {data: 'remittance_info', name: 'remittance.remittance_info'},
                {data: 'remittance_branch', name: 'remittance.branch_name'},
                {data: 'date_of_send', name: 'remittance.date_of_send'},
                {data: 'fund_status', name: 'fund_requests.id'}
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#fund-audit-table-reports_filter input').unbind();
    $('#fund-audit-table-reports_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundManage.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundManage.search($(this).val()).draw();
                }
            }
        }
    });


}

function ci_expenses_report_table() {

    $('#ci-expense-table-reports thead th').each(function()
    {
        title_header3[i3] = $(this).text();
        i3++;
        title3 = $(this).text();
        $(this).html(title3);
    });
    tableExpensesManage = $('#ci-expense-table-reports').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header3[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,audit-fund-table-report
        "processing": true,
        "serverSide": true,
        "ajax": "/audit-ci-expenses-table-report",
        // {
        //     url: "/audit-fund-table-report",
        //     data: function (d)
        //     {
        //         d.min_date_endorsed = $('#min').val();
        //         d.max_date_endorsed = $('#max').val();
        //         d.search_option = search_where_option_fund;
        //     }
        // },
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'ci_name', name: 'ci_name'},
                {data: 'endo_id', name: 'endo_id'},
                {data: 'account_name', name: 'account_name'},
                {data: 'declared', name: 'id'},
                {data: 'amount', name: 'amount'},
                {data: 'shell', name: 'shell'},
                {data: 'date_time', name: 'date_time'},
                {data: 'note', name: 'note'},
                {
                    data : function deta(data) {
                        return '<a style="margin-bottom: 5px" name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-primary" id="btn_down_receipt"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD RECEIPT/S</a>'+
                            '<a name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-block btn-info" data-toggle="modal" data-target="#modal-view-expenses-logs" id="btn_view_expense_logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                    }
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#ci-expense-table-reports_filter input').unbind();
    $('#ci-expense-table-reports_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableExpensesManage.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableExpensesManage.search($(this).val()).draw();
                }
            }
        }
    });
}
function ci_expenses_report_table_sort() {

    $('#ci-expense-table-reports thead th').each(function()
    {
        title_header3[i4] = $(this).text();
        i4++;
        title3 = $(this).text();
        $(this).html(title3);
    });
    tableExpensesManageSort = $('#ci-expense-table-reports-sort').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header3[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header3[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,audit-fund-table-report
        "processing": true,
        "serverSide": true,
        "ajax": "/audit-ci-expenses-table-report-sort",
        // {
        //     url: "/audit-fund-table-report",
        //     data: function (d)
        //     {
        //         d.min_date_endorsed = $('#min').val();
        //         d.max_date_endorsed = $('#max').val();
        //         d.search_option = search_where_option_fund;
        //     }
        // },
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'muni_name', name: 'muni_name'},
                {data: 'provinces', name: 'provinces'},
                {data: 'ci_name', name: 'ci_name'},
                {data: 'endo_id', name: 'endo_id'},
                {data: 'account_name', name: 'account_name'},
                {data: 'declared', name: 'id'},
                {data: 'amount', name: 'amount'},
                {data: 'shell', name: 'shell'},
                {data: 'date_time', name: 'date_time'},
                {data: 'note', name: 'note'},
                {
                    data : function deta(data) {
                        return '<a style="margin-bottom: 5px" name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-primary" id="btn_down_receipt"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD RECEIPT/S</a>'+
                            '<a name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-block btn-info" data-toggle="modal" data-target="#modal-view-expenses-logs" id="btn_view_expense_logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                    }
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#ci-expense-table-reports-sort_filter input').unbind();
    $('#ci-expense-table-reports-sort_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableExpensesManageSort.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableExpensesManageSort.search($(this).val()).draw();
                }
            }
        }
    });
}


$('#fund-audit-table-reports tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
    }
    else {
        tableFundManage.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
} );

$('#fund-audit-table-reports').on('click','#btn_view_logs_fund',function () {

    var get_id = $(this).attr('name');

    $('#history_fund').html
    (
        '<tr style="background-color: brown; color: white">' +
        '<th style=\'text-align: center;\'>NAME</th>' +
        '<th style=\'text-align: center;\'>POSITION</th>' +
        '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
        '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
        '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
        '</tr>'
    );

    $.ajax({
        url : 'audit_get_fund_logs',
        type : 'get',
        data : {
            'fund_id' : get_id
        },
        success : function (data) {

            console.log(data);

            for(ctrr = 0;ctrr <= (data.length)-1;ctrr++)
            {
                $('#history_fund').append
                (
                    '<tr>' +
                    '<td style="padding: 3px;">' +data[ctrr].name + '</td>' +
                    '<td style="padding: 3px;">' +data[ctrr].position + '</td>' +
                    '<td style="padding: 3px;">' +data[ctrr].activities + '</td>' +
                    '<td style="padding: 3px;">' +data[ctrr].date_occured + '</td>' +
                    '<td style="padding: 3px;">' +data[ctrr].time_occured + '</td>' +
                    '</tr>'
                );
            }

        },
        error : function () {

        }
    });

    console.log($(this).attr('name'));

});

$('#ci-expense-table-reports,#ci-expense-table-reports-sort').on('click','#btn_down_receipt', function () {

    var get_name = $(this).attr('name').split(':');
    var get_id = get_name[0];
    var get_endo_id = get_name[1];

    $.ajax({

        url : 'audit_download_receipt',
        get : 'get',
        data : {
            'ci_id' : get_id,
            'endo_id' : get_endo_id
        },
        success : function (data) {

            if(data == 'no uploaded')
            {
                alert('No uploaded file.');
            }
            else
            {
                window.location = data;
                // table.ajax.reload(null, false);
                // tableAoFinishReport.ajax.reload(null, false);
            }

        },
        error : function () {
            console.log('error');
        },
        complete : function () {

            // Pace.on('done',function(){
            setTimeout(function () {
                console.log('AAAAAAAAA');

                $.ajax({

                    url : 'audit_after_download_delete_expense_zip',
                    get : 'get',
                    data : {
                        'ci_id' : get_id,
                        'endo_id' : get_endo_id
                    },
                    success : function (data) {

                        console.log(data);
                        // location.reload();

                    },
                    error : function () {
                        console.log('error');
                    }

                });

            },3000);
        }

    });

});

$('#ci-expense-table-reports,#ci-expense-table-reports-sort').on('click','#btn_view_expense_logs',function () {

    var get_name = $(this).attr('name').split(':');
    var get_id = get_name[0];
    var get_endo_id = get_name[1];

    // console.log(get_id);

    $('#history_expenses').html
    (
        '<tr style="background-color: brown; color: white">' +
        '<th style=\'text-align: center;\'>NAME</th>' +
        '<th style=\'text-align: center;\'>POSITION</th>' +
        '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
        '<th style=\'text-align: center;\'>DATE/TIME OCCURED</th>' +
        '</tr>'
    );

    $.ajax({
        url : 'audit_get_expenses_logs',
        type : 'get',
        data : {
            'ci_id' : get_id,
            'endo_id' : get_endo_id
        },
        success : function (data) {

            console.log(data);

            for(ctrr = 0;ctrr <= (data[0].length)-1;ctrr++)
            {
                $('#history_expenses').append
                (
                    '<tr>' +
                    '<td style="padding: 3px;">' +data[1] + '</td>' +
                    '<td style="padding: 3px;">' +data[2] + '</td>' +
                    '<td style="padding: 3px;">' +data[0][ctrr].activity + '</td>' +
                    '<td style="padding: 3px;">' +data[0][ctrr].datetime + '</td>' +
                    '</tr>'
                );
            }

        },
        error : function () {

        }
    });

    console.log($(this).attr('name'));

});


//    download button for finish report
$('#audit-table-reports').on('click','.btnAuditDownload', function ()
{
    var acctID = $(this).attr('value');
    var type = $(this).attr('name');

    // console.log(type);

    // $.ajax
    // ({
    //     method: 'get',
    //     url: 'audit-download-report',
    //     data:
    //         {
    //             'acctID': acctID,
    //             'type': type
    //         },
    //     success: function (data)
    //     {
    //         if(data=='errorDownload')
    //         {
    //             alert('Report Not Available!');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             tableManage.ajax.reload(null, false);
    //             // tableAoFinishReport.ajax.reload(null, false);
    //         }
    //     }
    // });

    download_report(acctID,type);
});


function download_report(id,typ) {

    var q = '<form action="/audit-download-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id+'" name="acctID">'+
        '<input type="text" hidden value="'+typ+'" name="type">'+
        '<button type="submit" id="button_form_download_report">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#span_download_report').html(q);
    $('#button_form_download_report').click();
    // window.location = '/ao-panel';
}

$('#submitAuditLogRep').click(function()
{
    var empID = $('#emp_id_audit').val();
    var acctDetails = $('#account_details_audit').val();
    var repChecklist = $('#report_checklist_audit').val();
    var empLast = $('#emp_last_name').val();
    var endoDate = $('#endo_date_audit').val();
    var completeNess = $('#completeness_audit').val();
    var empFirst = $('#first_name_audit').val();
    var acctName = $('#acoount_name_audit').val();
    var gpsComp = $('#gps_comp_audit').val();
    var empdateHired = $('#emp_date_hired').val();
    var visitDate = $('#visit_date_audit').val();
    var informantValid = $('#informants_validity_audit').val();
    var areaAudit = $('#area_audit').val();
    var requestType = $('#request_type_audit').val();
    var encodeAcc = $('#encode_acc_audit').val();
    var auditorName = $('#auditor_name_audit').val();
    var handlingType = $('#handling_type_audit').val();
    var selfieUni = $('#selfie_uni_id').val();
    var branchHead = $('#branch_head').val();
    var sourceAudit = $('#source_audit').val();
    var tatComp = $('#tat_comp_audit').val();
    var regionHead = $('#region_head').val();
    var oimsId = $('#oims_id_audit').val();
    var attachmentLog = $('#audit_log_attachment').prop('files')[0];
    var seniorAccount = $('#srao_audit_log').val();
    var remarksLog = $('#remarks_audit_log').val();
});

$('#audit-table-reports').on('click', '#hyperlink_name', function()
{
    endorse_id = $(this).val();
    console.log(endorse_id);
    $('#audit-show-ci-files').html('');
    $('#afterClickRepCi').hide();
    $('#receipts_logs').val(endorse_id);


    $('#modal-emp-audit').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'audit-get-edo-acc-details',
        data :
            {
                'endorse_id' : endorse_id
            },
        success : function(data)
        {
            console.log(data);

            $('#account_show_id').html(data[0][0].id);
            $('#account_show_bank').html(data[0][0].client_name);
            $('#account_show_date_endorsed').html(data[0][0].date_endorsed);
            $('#account_show_time_endorsed').html(data[0][0].time_endorsed);
            $('#account_show_date_due').html(data[0][0].date_due);
            $('#account_show_time_due').html(data[0][0].time_due);
            $('#account_show_ci_due').html(data[2]);
            $('#account_show_requestor').html(data[0][0].requestor_name);
            $('#account_show_account_name').html(data[0][0].account_name);
            $('#account_show_address').html(data[0][0].address);
            $('#account_show_city_muni').html(data[0][0].city_muni);
            $('#account_show_province').html(data[0][0].provinces);
            $('#account_show_tor').html(data[0][0].type_of_request);
            $('#account_show_verify').html(data[0][0].verify_through);
            $('#account_show_dispatcher_name').html(data[0][0].handled_by_dispatcher);
            $('#account_show_sao_name').html(data[0][0].assigned_by_srao);
            $('#account_show_ao_name').html(data[0][0].handled_by_account_officer);
            $('#account_show_ci_name').html(data[0][0].handled_by_credit_investigator);

            var cert;
            if(data[0][0].ci_cert == "")
            {
                cert = 'N/A';
            }
            else
            {
                cert = data[0][0].ci_cert;
            }
            $('#account_show_certified').html(cert);
            $('#account_show_date_time_dispatched_ci').html(data[0][0].date_dispatched + ' ' + data[0][0].time_dispatched);
            $('#account_show_date_time_assigned_ao').html(data[0][0].date_srao_assigned + ' ' + data[0][0].time_srao_assigned);
            $('#account_show_date_time_ci_reported').html(data[0][0].date_ci_forwarded + ' ' + data[0][0].time_ci_forwarded);
            $('#account_show_ao_date_to_client').html(data[0][0].date_forwarded_to_client + ' ' + data[0][0].time_forwarded_to_client);
            $('#account_show_date_time_ci_visit').html(data[0][0].date_ci_visit + ' ' + data[0][0].time_ci_visit);

            var external;
            if(data[0][0].endorsement_status_external == "")
            {
                external = 'N/A';
            }
            else
            {
                external = data[0][0].endorsement_status_external;
            }
            $('#account_show_external_status').html(external);
            $('#account_show_internal_stat_field').html(data[0][0].endorsement_status_internal);
            $('#account_show_internal_stat_office').html(data[0][0].endorsement_status_internal_2);
            $('#account_show_dispatched_handling').html(data[0][0].time_dispatcher);
            $('#account_show_sao_handling').html(data[0][0].time_srao);
            $('#account_show_ci_handling').html(data[0][0].time_ci);
            $('#account_show_ao_handling').html(data[0][0].time_ao);
            $('#account_incentives').val(data[0][0].account_incentives);
            $('#account_deduction').val(data[0][0].account_deduction);

            if(data[0][0].link_path != "")
            {
                $('#checkCiReportAudit').html('<button class=" btn btn-xs btn-success" id = "btnDlCiReport" ><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button>' +
                    '<button class=" btn btn-xs btn-danger" id = "cancelDlCiReport" ><i class="fa fa-fw fa-close"></i> CANCEL</button>');
            }
            else
            {
                $('#checkCiReportAudit').html('<button class= "btn btn-xs btn-danger" disabled><i class = "fa fa-fw fa-exclamation-circle"></i>No Available C.I Report</button>')
            }

            if(data[0][0].account_incentives == null || data[0][0].account_incentives == "")
            {
                $('#account_incentives').attr('disabled', false);
            }
            else if(data[0][0].account_incentives != null || data[0][0].account_incentives != "")
            {
                $('#account_incentives').attr('disabled', true);
            }

            if(data[0][0].account_deduction == null || data[0][0].account_deduction == "")
            {
                $('#account_deduction').attr('disabled', false);
            }
            else if(data[0][0].account_deduction != null || data[0][0].account_deduction != "")
            {
                $('#account_deduction').attr('disabled', true);
            }

            if((data[0][0].account_deduction == null || data[0][0].account_deduction == "") || (data[0][0].account_incentives == null || data[0][0].account_incentives == ""))
            {
                $('#btnSaveIncentDed').show();
            }
            else if((data[0][0].account_deduction != null || data[0][0].account_deduction != "") || (data[0][0].account_incentives != null || data[0][0].account_incentives != ""))
            {
                $('#btnSaveIncentDed').hide();
            }
        }
    })
});
$('#btnSaveIncentDed').click(function()
{
    var auditIncent = $('#account_incentives').val();
    var auditDeduc = $('#account_deduction').val();

    $.ajax
    ({
        type : 'get',
        url : 'audit-update-incent-deduct',
        data :
            {
                'auditIncent' : auditIncent,
                'auditDeduc' : auditDeduc,
                'id' : endorse_id
            },
        success : function(data)
        {
            console.log(data);
            if(data[0].account_incentives == "")
            {
                $('#account_incentives').attr('disabled', false);
            }
            else if(data[0].account_incentives != "")
            {
                $('#account_incentives').attr('disabled', true);
            }

            if(data[0].account_deduction == "")
            {
                $('#account_deduction').attr('disabled', false);
            }
            else if(data[0].account_deduction != "")
            {
                $('#account_deduction').attr('disabled', true);
            }

            if(data[0].account_deduction == "" || data[0].account_incentives == "")
            {
                $('#btnSaveIncentDed').show();
            }
            else if(data[0].account_deduction != "" || data[0].account_incentives != "")
            {
                $('#btnSaveIncentDed').hide();
            }
            tableManage.ajax.reload(null, false);
            totalaccInt();

            alert('Successfully Added!');
        }
    });
});

$('#audit-show-ci-files').on('click', '.dl_ci_rep', function()
{
    var fileName = $(this).attr('name');
    console.log(fileName);


    var id_encode = btoa(acct_ci_dl_id);
    var q = '<form action="/audit-dl-ci-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<input type="text" hidden value="'+fileName+'" name="name">'+
        '<button type="submit" hidden id="button_ci_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#downCiDl').html(q);
    $('#button_ci_download').click();
    $('#downCiDl').hide();
});


$('#area_audit').focusout(function ()
{
    $.ajax
    ({
        method: 'get',
        url: '/fetch-city-muniv2',
        data:
            {
                'muniname' : $('area_audit').val()
            },
        success: function (data)
        {
            console.log(data[0].id);
            $('#idProvince').val(data[0].province_id);
            $('#idMunicipality').val(data[0].id);

            // setTimeout(function ()
            // {
            //     $('#area_audit').val(data[0].muni_name);
            // },1000);
        }
    });
});

$('#area_audit').autocomplete
({
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
            clearInterval(clearTime);
        },10)
    }
});
totalaccInt();
function totalaccInt()
{
    $.ajax
    ({
        type : 'get',
        url : 'audit-check-total-acc',
        success : function(data)
        {
            console.log(data);

            var incent = 0;

            for(var i = 0; i < data[1].length; i++)
            {
                incent += data[1][i].account_incentives;
            }
            console.log(incent);
            $('#audit_tot_acc').val(data[0]);
            $('#audit_tot_inc').val('₱ ' + incent);
        }
    });
}
$('#audit-table-reports').on('click', '#btnChooseFileDlCi', function()
{
    acct_ci_dl_id = $(this).val();
    console.log(acct_ci_dl_id);

    $('#modal-ci-dl-report').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'audit-get-files-ci',
        data :
            {
                'id' : acct_ci_dl_id
            },
        success : function(data)
        {
            console.log(data);

            var v = '';

            for(var ctr = 0; ctr < data[0].length ; ctr++)
            {
                var num = ctr + 1;
                v += '<tr>\n' +
                    '                                                     <td style="font-weight:bold; background-color: silver">'+ num +'</td>\n' +
                    '                                                     <td style = "word-wrap:break-word;">' +
                    '                                                     <button type = "button" style = "color: blue; text-decoration: underline; background:none ; border:none; " name = "' + data[0][ctr] + '" class = "dl_ci_rep"> ' +
                    '                                                     '+ data[0][ctr] +' </button></td>\n' +
                    '</tr>'
            }

            var t = '  <tr>\n' +
                '                                                     <td>NO AVAILABLE REPORT FILE</strong></td>\n' +
                '                                                 </tr>';
            if(data[0] == "")
            {
                $('#audit-show-ci-files').html(t);
            }
            else
            {
                $('#audit-show-ci-files').html(v);
            }
            $('#acct_name_dl_ci').html(data[1]);
        }
    });
});
$('#audit-table-reports').on('click', '#btnDlAoReport', function()
{
    acct_ci_dl_id = $(this).val();
    console.log(acct_ci_dl_id);

    var id_encode = btoa(acct_ci_dl_id);
    var q = '<form action="/audit-ao-file-dl" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<button type="submit" hidden id="button_ao_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#downAo').html(q);
    $('#button_ao_download').click();
    $('#downAo').hide();

});


$('#test').click(function(){
    $('#input1').attr('disabled', false);
});





// RANYLLLLLL TEST AUDIT



$('#ci_grade_completeness').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_gps').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_informantsValidity').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_encodingAccu').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_selfie').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_tatCompliance').change(function(){
    ci_gradeComputation();
});

$('#ci_grade_attachedDocs').change(function(){
    ci_gradeComputation();
});

function ci_gradeComputation()
{
    var ci_tatCompliance_grade = 0;
    var ci_comp_grade_raw = $('#ci_grade_completeness').children("option:selected").val();
    var ci_comp_grade = parseInt(ci_comp_grade_raw);
    var ci_gps_grade_raw = $('#ci_grade_gps').children("option:selected").val();
    var ci_gps_grade = parseInt(ci_gps_grade_raw);
    var ci_informantsValidity_grade_raw = $('#ci_grade_informantsValidity').children("option:selected").val();
    var ci_informantsValidity_grade = parseInt(ci_informantsValidity_grade_raw);
    var ci_encodingAccu_grade_raw = $('#ci_grade_encodingAccu').children("option:selected").val();
    var ci_encodingAccu_grade = parseInt(ci_encodingAccu_grade_raw);
    var ci_selfie_grade_raw = $('#ci_grade_selfie').children("option:selected").val();
    var ci_selfie_grade = parseInt(ci_selfie_grade_raw);
    var ci_tatCompliance_grade_raw = $('#ci_grade_tatCompliance').children("option:selected").val();
    ci_tatCompliance_grade = parseInt(ci_tatCompliance_grade_raw);
    var ci_attachedDocs_grade_raw = $('#ci_grade_attachedDocs').children("option:selected").val();
    var ci_attachedDocs_grade = parseInt(ci_attachedDocs_grade_raw);

    if($('#ci_grade_tatCompliance').val() == '-')
    {
        ci_tatCompliance_grade = 0;
    }

    var total_ci_grade = ci_gps_grade + ci_comp_grade + ci_informantsValidity_grade + ci_encodingAccu_grade + ci_selfie_grade + ci_tatCompliance_grade + ci_attachedDocs_grade;

    var total_grade_ci = $('#ci_grade_total').val(total_ci_grade + "%");
}

$('#audit_report_form_messenger').click(function()
{
    console.log('teset');

    $('.messenger_type').attr('disabled', false);
    $('.messenger_type').val('');
    $('.date_change').attr('type' , 'date');
    $('#autoComId').attr('disabled', false);
    // $('.messenger_type_idisable').attr('disabled', true);
});
$('#inputOimsIdAuditRep').change(function()
{
    $('.messenger_type').attr('disabled', true);
});

var fund_id = '';
var ci_nameGlob = '';

$('#table-finance-expenses-report').on('click', '.btn_view_ci_liq', function()
{
    var bool_to_hide = '';
    console.log(bool_to_hide);
    ci_nameGlob = $(this).val();
    $('.cancelMod').hide();
    $('#insertCiImgLiq').html('');
    $('#requiredAmount').val('');
    $('.modAmount').attr('disabled', true);
    $('#liquidation_rem_audit').val('');

    fund_id = $(this).attr('name');
    $('#modal-view-ci-liq-img').modal({backdrop: 'static'});

    if(bool_to_hide == false)
    {
        $('#tryOnly').html('<div class="col-md-2"></div>\n' +
            '                                                        <div class="col-md-4">\n' +
            '                                                            <label for="">Fund Requested:</label>\n' +
            '                                                            <input type="text" disabled class="form-control" id="requiredAmount" style="font-size: 15px;">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="col-md-2"><button class="btn-block btn-primary form-control" id="modAccount" style="margin-top: 20%;">Modify</button></div>\n' +
            '                                                        <div class="col-md-2 cancelMod" hidden><button class="btn-block btn-warning form-control" id="cancelMod" style="margin-top: 20%;">Cancel</button></div><div class="col-md-2"></div>');

        // $('#hideThis').attr('display', 'block');
        $('#doneAudit').attr('display', 'block');
    }
    else if(bool_to_hide == true)
    {
        $('#tryOnly').html('');


        // $('#hideThis').hide();
        $('#doneAudit').hide();
    }

    $.ajax(
        {
            type : 'get',
            url : 'audit-get-liq-img',
            data : {
                'id': fund_id
            },
            success: function(data)
            {
                console.log(data);
                var i;
                var imdDiv = '';
                var u;
                var m;
                var outImgdiv = '';
                var indivRemarks = '';

                if(data  != 0)
                {
                    $('#removeHehe').html('<button type="button" class="btn pull-right btn-success" id="doneAudit">Done</button>');
                    bool_to_hide = false;
                    var decodedAmount = data[4];

                    $('#requiredAmount').val('₱ '+decodedAmount);

                    for (u = 0; u < data[3].length; u++)
                    {
                        var pathToLoop = data[3][u].split('|');
                        
                        for(m = 0; m < (pathToLoop.length -1); m++)
                        {
                            extensionCheck = pathToLoop[m].split('.');
                            var extHolder = extensionCheck.pop();
                            var pathtoLook = btoa(pathToLoop[m]);
                            if(extHolder == 'jpg' || extHolder == 'jpeg' || extHolder == 'png')
                            {
                                imdDiv +=
                                    '                                                <div class = "col-md-3" style = "border: 1px solid; padding-left : 8px; padding-right : 5px; padding-bottom : 5px; padding-top : 5px;">\n' +
                                    '                                                    <a href="getuploaded/' + data[0][m] + '/ '+pathtoLook+'" target="_blank">' +
                                    '                                                    <img src = "getuploaded/' + data[0][m] + '/'+pathtoLook+'" style = "height: 200px; width : 200px; border : solid black 1px; ">' +
                                    '                                                    </a>' +
                                    '                                               </div>\n';
                            }
                            else
                            {
                                imdDiv +=
                                    '                                                <div class = "col-md-3" style = "border: 1px solid; padding-left : 8px; padding-right : 5px; padding-bottom : 5px; padding-top : 5px;">\n' +
                                    '                                                    <a href="getuploaded-2/' + data[0][m] + '/ '+pathtoLook+'" target="_blank">' +
                                    '                                                    <img src = "dist/img/downloadIconnn (2).png" style = "height: 200px; width : 200px; border : solid black 1px; ">' +
                                    '                                                    </a>' +
                                    '                                               </div>\n';
                            }
                        }

                        indivRemarks = '<div class = "row" style = "padding-bottom : 20px;">' +
                            '<div class = "col-md-1"></div>' +
                            '<div class = "col-md-10">' +
                            '<label for="">Account Remarks</label>' +
                            '<textarea id="" class = "form-control" rows="2" placeholder= "No Remarks" disabled>' +
                            '' + data[1][u][1] + '</textarea>' +
                            '<div class="row"><div class="col-md-12"><label for="">Expenses:</label>' +
                            '<input type="number" class="form-control modAmount amountToModi" name="'+data[6][u]+'" disabled value="'+atob(data[5][u])+'"></div></div></div>' +
                            '<div class = "col-md-1"></div>' +
                            '</div>';

                        outImgdiv += '<div class = "row" style = "padding-bottom : 20px;">' +
                            '<div class = "col-md-12">' +
                            '<div class = "box box-warning">' +
                            '<h5 style = "text-align: center; color: midnightblue">ENDORSE ACCOUNT NAME: </h5>' +
                            '<h5 style = "text-align: center">' + data[1][u][2] + '</h5>' +
                            '<div class = "row" style = "padding-bottom : 20px;">' +
                            '<div class = "col-md-12">' +
                            ''+ imdDiv +' </div>' +
                            '</div>'+indivRemarks+'</div></div></div>';

                        $('#insertCiImgLiq').append(outImgdiv);

                        imdDiv = '';
                        outImgdiv = '';
                    }

                    if(data != '')
                    {
                        for (i = 0; i < data[0].length; i++)
                        {

                        }

                    }
                    if(data[2] != '')
                    {
                        $('#insertCILiqRemarks').val(data[2]);
                    }
                    else
                    {
                        $('#insertCILiqRemarks').val('');
                        $('#insertCILiqRemarks').attr('placeholder', 'NO INDICATED REMARKS.....');
                    }

                }
                else if(data == 0)
                {
                    bool_to_hide = true;
                    $('#tryOnly').html('');
                    $('#removeHehe').html('');
                    $('#insertCILiqRemarks').val('');
                    $('#insertCILiqRemarks').attr('placeholder', 'NO INDICATED REMARKS.....');
                    $('#doneAudit').hide();
                }
            },
            complete: function()
            {
                SubmitReviewedLiq();

                $('#modAccount').click(function()
                {
                    $('.cancelMod').fadeIn();
                    $('#cancelMod').addClass('modified');
                    $('#modAccount').fadeOut();
                    $('.amountToModi').attr('disabled', false);
                });

                $('#cancelMod').click(function()
                {
                    $('.cancelMod').fadeOut();
                    $('#cancelMod').removeClass('modified');
                    $('#modAccount').fadeIn();
                    $('.amountToModi').attr('disabled', true);
                    $('#liquidation_rem_audit').val('');
                });
            }
        }
    );
});


function SubmitReviewedLiq()
{
    $('#doneAudit').click(function()
    {
        var btn = $(this);
        btn.attr('disabled', true);
        var fundIdArray = [];
        var newAmountArray = [];
        var coutirrr = 0;
        var ctrMod = 0;
        var raw = $('#requiredAmount').val();
        var remarks = '';
        var realAmount = raw.split(" ");
        var realAmountvar = parseInt(realAmount[1]);

        $('.amountToModi').each(function()
        {
            var rawww = $(this).val();
            var rawID = $(this).attr('name');
            newAmountArray[coutirrr] = parseInt(rawww);
            fundIdArray[coutirrr] = rawID;
            ctrMod = parseInt(rawww) + ctrMod;
            coutirrr++;
        });

        if($('#cancelMod').hasClass('modified'))
        {
            remarks = $('#liquidation_rem_audit').val();
        }
        else
        {
            remarks = '-';
        }

        $.ajax
        ({
            type: 'post',
            url: 'audit_liquidation_checking',
            data: {
                'ci_name': ci_nameGlob,
                'fund_id' : fund_id,
                'fundIdArray': fundIdArray,
                'newAmountArray' : newAmountArray,
                'remarks': remarks
            },
            beforeSend: function()
            {
                $('#modal-loading-sms-sending').modal({backdrop:'static'});

                setTimeout(function()
                {
                    $('#modal-loading-sms-sending').modal('hide');
                }, 2000);
            },
            success: function(data)
            {
                console.log(data);
                alert(data);
                $('#modal-view-ci-liq-img').modal('hide');
                tableFundFa.ajax.reload(null,false);
                btn.attr('disabled', false);
            }
        });

        // if(ctrMod <= realAmountvar)
        // {
        //     alert('Please check inputted amount');
        // }
        // else
        // {
        //     if($('#cancelMod').hasClass('modified'))
        //     {
        //         remarks = $('#liquidation_rem_audit').val();
        //     }
        //     else
        //     {
        //         remarks = '-';
        //     }
        //
        //     $.ajax
        //     ({
        //         type: 'post',
        //         url: 'audit_liquidation_checking',
        //         data: {
        //             'ci_name': ci_nameGlob,
        //             'fund_id' : fund_id,
        //             'fundIdArray': fundIdArray,
        //             'newAmountArray' : newAmountArray,
        //             'remarks': remarks
        //         },
        //         success: function(data)
        //         {
        //             alert(data);
        //             $('#modal-view-ci-liq-img').modal('hide');
        //             tableFundFa.ajax.reload(null,false);
        //             btn.attr('disabled', false);
        //         }
        //     });
        // }
    });
}

$('#table-finance-expenses-report').on('click', '.btn_ci_liq_view_remarks', function()
{
    $('#view_remarksSpan').html('');
    var id = $(this).attr('name');
    viewAuditRemarks(id);
});

function viewAuditRemarks(id)
{
    $.ajax({
        type: 'get',
        url: 'audit_get_audit_remarks',
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
// inseting audit report form - floyd

$('.log_checker').click(function()
{
    if($('#optionAudit').is(':checked'))
    {
        what_logs = 'audit_report_form';
        getLogsFunction(what_logs);
        clearAuditFormValAttr();
        $('#dlAttachmentCiReport').removeAttr('href');
        $('#btn_edit_arf_details').attr('disabled', true);
        $('#btn_save_arf').removeAttr('href');
        $('#btn_send_arf').attr('name', 'without');
        $('#btn_send_arf').removeAttr('href');
        $('#viewAttachSavedArf').removeAttr('href');
        $('#viewAttachSavedArf').hide();
        $('#audit_report_form_messenger').attr('disabled', false);
    }
    else if($('#optionDesc').is(':checked'))
    {
        what_logs = 'audit_discrepancy_form';
        getLogsFunction(what_logs);
        clearAuditFormValAttr();
        $('#dlAttachmentCiReport').removeAttr('href');
        $('#btn_edit_arf_details').attr('disabled', true);
        $('#btn_save_arf').removeAttr('href');
        $('#btn_send_arf').attr('name', 'without');
        $('#btn_send_arf').removeAttr('href');
        $('#viewAttachSavedArf').removeAttr('href');
        $('#viewAttachSavedArf').hide();
        $('#audit_report_form_messenger').attr('disabled', false);
    }

    $('#uploaded_holder').html('')
    $('#thisisUploadedDiscrep').hide();
    discrep_fine_array = [];
});

$('.log_checker2').click(function()
{
    $('#newFormPf').click();

    if($('#optionField').is(':checked'))
    {
        what_logs = 'audit_field_checking';
        getLogsFunction(what_logs);
        clearPhoneField();
        $('#btn_download_ci_rep_pf').removeAttr('href');
        $('#btn_edit_phone_field').attr('disabled', true);
        $('#btn_save_phone_field').removeAttr('href');
        $('#btn_submit_phone_field').attr('name', 'without');
        $('#btn_submit_phone_field').removeAttr('href');
        $('#viewAttachmentPhoneField').removeAttr('href');
        $('#viewAttachmentPhoneField').hide();
        $('#removeValandDis').attr('disabled', false);
    }
    else if($('#optionPhone').is(':checked'))
    {
        what_logs = 'audit_phone_checking';
        getLogsFunction(what_logs);
        clearPhoneField();
        $('#btn_download_ci_rep_pf').removeAttr('href');
        $('#btn_edit_phone_field').attr('disabled', true);
        $('#btn_save_phone_field').removeAttr('href');
        $('#btn_submit_phone_field').attr('name', 'without');
        $('#btn_submit_phone_field').removeAttr('href');
        $('#viewAttachmentPhoneField').removeAttr('href');
        $('#viewAttachmentPhoneField').hide();
        $('#removeValandDis').attr('disabled', false);
    }
});


$('#btn_send_arf').click(function()
{
    // getLogsFunction(what_logs);

    var btn = $(this);

    btn.attr('disabled', true);

    saveSubmitTypeArf = 'send';

    // var arfFile = $('#upload_arf').prop('files')[0];

    var typeRet;
    var chosenForm;

    if($('#optionAudit').is(':checked'))
    {
        chosenForm = 'audit';
        what_logs = 'audit_report_form';
        // getLogsFunction(what_logs);
    }
    else if($('#optionDesc').is(':checked'))
    {
        chosenForm = 'desc';
        what_logs = 'audit_discrepancy_form';
        // getLogsFunction(what_logs);
    }

    if($(this).attr('href') == null)
    {
        typeRet = 'new';

        if($('#last_name_arf').val() != '' &&  $('#f_name_arf').val() != '')
        {
            sendNowArf(chosenForm, typeRet , btn, saveSubmitTypeArf, 'without', $('#show_uploader_discrep').attr('log'));
        }
        else if($('#last_name_arf').val() == '' &&  $('#f_name_arf').val() == '')
        {
            alert('Please enter full name');
            btn.attr('disabled', false);
        }
    }
    else
    {
        typeRet = atob($(this).attr('href'));

        if(btn.attr( 'name') == 'with')
        {
            if($(this).attr('check') != 'saved' || $(this).attr('check') != 'returned')
            {
                if ($('#last_name_arf').val() != '' && $('#f_name_arf').val() != '')
                {
                    sendNowArf(chosenForm, typeRet, btn, saveSubmitTypeArf, 'new', $('#show_uploader_discrep').attr('log'));
                }
                else if ($('#last_name_arf').val() == '' && $('#f_name_arf').val() == '')
                {
                    alert('Please enter full name');
                    btn.attr('disabled', false);
                }
            }

            //
            // if(arfFile != null)
            // {
            //     if(arfFile.type == 'application/pdf')
            //     {
            //         if ($('#last_name_arf').val() != '' && $('#f_name_arf').val() != '')
            //         {
            //             sendNowArf(chosenForm, typeRet, btn, saveSubmitTypeArf, 'new', $('#show_uploader_discrep').attr('log'));
            //         }
            //         else if ($('#last_name_arf').val() == '' && $('#f_name_arf').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     if($(this).attr('check') == 'saved' || $(this).attr('check') == 'returned')
            //     {
            //         if($('#last_name_arf').val() != '' && $('#f_name_arf').val() != '')
            //         {
            //             sendNowArf(chosenForm, typeRet, btn, saveSubmitTypeArf, btn.attr('name'), $('#show_uploader_discrep').attr('log'));
            //         }
            //         else if ($('#last_name_arf').val() == '' && $('#f_name_arf').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please attach a new file.');
            //         btn.attr('disabled', false);
            //     }
            // }
        }
        else if(btn.attr('name') == 'without')
        {
            if($('#last_name_arf').val() != '' &&  $('#f_name_arf').val() != '')
            {
                sendNowArf(chosenForm, typeRet , btn, saveSubmitTypeArf, btn.attr('name'), $('#show_uploader_discrep').attr('log'));
            }
            else if($('#last_name_arf').val() == '' &&  $('#f_name_arf').val() == '')
            {
                alert('Please enter full name');
                btn.attr('disabled', false);
            }

            // if(arfFile != null)
            // {
            //     if(arfFile.type == 'application/pdf')
            //     {
            //         if($('#last_name_arf').val() != '' &&  $('#f_name_arf').val() != '')
            //         {
            //             sendNowArf(chosenForm, typeRet , btn, saveSubmitTypeArf, btn.attr('name'), $('#show_uploader_discrep').attr('log'));
            //         }
            //         else if($('#last_name_arf').val() == '' &&  $('#f_name_arf').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     alert('Please attach a file.');
            //     btn.attr('disabled', false);
            // }
        }
    }
});

function sendNowArf(form, logid , btn, type, filestat, log_id_glob)
{
    var oimsID = $('#autoComId').val();
    var client_name = $('#client_name').val();
    var nameComp = $('#full_name_company').val();
    var tor = $('#type_of_request').val();
    var endor_date = $('#endorsement_date').val();
    var sub_date = $('#submission_date').val();
    var internalTat = $('#internal_tat').val();
    var exTat = $('#external_tat').val();
    var specialInst = $('#special_instruction').val();
    var tochecking = $('#type_of_checking').val();
    var l_name = $('#last_name_arf').val();
    var f_name = $('#f_name_arf').val();
    var emp_id = $('#emp_id_arf').val();
    var department = $('#dept_arf').val();
    var jobTit = $('#job_title_arf').val();
    var dateHired = $('#date_hired_arf').val();
    var findings = $('#findings_arf').val();
    var investig = $('#investigation_arf').val();
    var validRes = $('#valid_res_arf').val();
    var states = $('#statements_arf').val();
    var observe = $('#obs_arf').val();
    var recom = $('#recom_arf').val();
    var bus_name = $('#business_name').val();
    var address = $('#full_address').val();
    // var arfFile = $('#upload_arf').prop('files')[0];
    if(discrep_fine_array.length > 0 || logid != 'new')
    {
        $.ajax
        ({
            type : 'get',
            url : 'audit-insert-arf-data',
            data :
                {
                    'chose' : form,
                    'oimsID' : oimsID,
                    'client_name' : client_name,
                    'nameComp' : nameComp,
                    'bus_name' : bus_name,
                    'address' : address,
                    'tor' : tor,
                    'endor_date' : endor_date,
                    'sub_date' : sub_date,
                    'internalTat' : internalTat,
                    'exTat' : exTat,
                    'specialInst' : specialInst,
                    'tochecking' : tochecking,
                    'l_name' : l_name,
                    'f_name' : f_name,
                    'emp_id' : emp_id,
                    'department' : department,
                    'jobTit' : jobTit,
                    'dateHired' : dateHired,
                    'findings' : findings,
                    'investig' : investig,
                    'validRes' : validRes,
                    'states' : states,
                    'observe' : observe,
                    'recom' : recom,
                    'id' : logid,
                    'logID' : log_id_glob
                },
            beforeSend : function()
            {
                $('#modal-loading-arf-files').modal('show');
            },
            success : function(data)
            {
                if(discrep_fine_array.length > 0)
                {
                    $('#qq-audit-discrepancy-form-fine-holder').fineUploader('uploadStoredFiles');
                }
                else
                {
                    $('#modal-loading-arf-files').modal('hide');
                    $('#btn_send_arf').attr('disabled', false);
                }

                $('#btn_edit_arf_details').attr('disabled', false);
                checkAuditLogComp = true;
                submitCounter = true;
                $('#btn_save_arf').attr('href', btoa(data[2]));
                $('#btn_send_arf').attr('href', btoa(data[2]));
                $('#btn_send_arf').attr('name', 'with');

                disableArfAttr();
                $('#btn_edit_arf_details').attr('disabled', false);
                getLogsFunction(what_logs);

                // if(filestat == 'with')
                // {
                //     $('#modal-loading-arf-files').modal('hide');
                //
                //     var timerSuccess = setInterval(function ()
                //     {
                //         $('#modal-success-arf-send').modal('show');
                //         var timerSuccessHide = setInterval(function ()
                //         {
                //             $('#modal-success-arf-send').modal('hide');
                //             clearInterval(timerSuccessHide);
                //         },5000);
                //         clearInterval(timerSuccess);
                //     },1000);
                //
                //     checkAuditLogComp = true;
                //     submitCounter = true;
                //     $('#btn_send_arf').attr('disabled', false);
                //     getLogsFunction(what_logs);
                //
                //     console.log(data);
                //
                //     $('#btn_save_arf').attr('href', btoa(data[2]));
                //     $('#btn_send_arf').attr('href', btoa(data[2]));
                //     $('#btn_send_arf').attr('name', 'with');
                //
                //     disableArfAttr();
                //     $('#btn_edit_arf_details').attr('disabled', false);
                // }
                // else if(filestat == 'without')
                // {
                //     $('#trigger-fine-discrep').click();
                //     $('#btn_edit_arf_details').attr('disabled', false);
                // }
                // else if(filestat == 'new')
                // {
                //     $('#trigger-fine-discrep').click();
                //     $('#btn_edit_arf_details').attr('disabled', false);
                // }
                // console.log(discrep_fine_array);
            },
            error : function()
            {
                alert('There was a problem in inserting data!');
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        alert('No Attached file.');
        btn.attr('disabled', false);
    }

}

function sendFilesARF(data1, data2, file, type)
{
    var formData = new FormData;

    formData.append('id', data1);
    formData.append('type', data2);
    formData.append('file', file);

    $.ajax
    ({
        xhr: function()
        {
            var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt)
            {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    $('#ulPercentage_ArfFile').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_ArfFile').append(Math.floor(percentComplete*100));
                    $('#progressbar_ArfFile').show();
                    $('#progressbar_ArfFile').progressbar
                    (
                        {
                            value: percentComplete * 100
                        }
                    )
                }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with download progress
                        console.log(percentComplete);
                    }
                },
                false
            );
            return xhr;
        },
        type : 'post',
        url : 'audit-upload-arf',
        contentType: false,
        processData: false,
        async: true,
        data : formData,
        success : function(data)
        {
            $('#upload_arf').val('');
            $('#toUploadStatArf').html('Upload Attachment');
            $('#viewAttachSavedArf').attr('href', '/view_report_form/' + btoa(data[0]));
            $('#viewAttachSavedArf').show();

            $('#btn_save_arf').attr('href', btoa(data[1]));
            $('#btn_send_arf').attr('href', btoa(data[1]));
            $('#btn_send_arf').attr('name', 'with');
            disableArfAttr();
            $('#btn_edit_arf_details').attr('disabled', false);
        },
        complete : function()
        {
            $('#modal-loading-arf-files').modal('hide');

            var timerSuccess = setInterval(function ()
            {
                $('#modal-success-arf-send').modal('show');
                var timerSuccessHide = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('hide');
                    clearInterval(timerSuccessHide);
                },5000);
                clearInterval(timerSuccess);
            },1000);

            if(type == 'send')
            {
                checkAuditLogComp = true;
                submitCounter = true;
                $('#btn_send_arf').attr('disabled', false);
            }
            else if(type == 'save')
            {
                saveCounter = true;
                $('#btn_save_arf').attr('disabled', false);
            }

            getLogsFunction(what_logs);
        }
    });
}

$('#btn_delete_arf').click(function()
{
    clearAuditFormValAttr();
    $('#btn_edit_arf_details').attr('disabled', true);
    $('#dlAttachmentCiReport').removeAttr('href');
    $('#btn_save_arf').removeAttr('href');
    $('#viewAttachSavedArf').removeAttr('href');
    $('#viewAttachSavedArf').hide();
    $('#btn_send_arf').attr('name', 'without');
    $('#btn_send_arf').removeAttr('href');
    $('#audit_report_form_messenger').attr('disabled', false);
});

function clearAuditFormValOnly()
{
    $('#autoComId').val('');
    $('#client_name').val('');
    $('#full_name_company').val('');
    $('#type_of_request').val('');
    $('#endorsement_date').val('');
    $('#submission_date').val('');
    $('#internal_tat').val('');
    $('#external_tat').val('');
    $('#special_instruction').val('');
    $('#type_of_checking').val('');
    $('#last_name_arf').val('');
    $('#f_name_arf').val('');
    $('#emp_id_arf').val('');
    $('#dept_arf').val('');
    $('#job_title_arf').val('');
    $('#date_hired_arf').val('');
    $('#findings_arf').val('');
    $('#investigation_arf').val('');
    $('#valid_res_arf').val('');
    $('#statements_arf').val('');
    $('#obs_arf').val('');
    $('#recom_arf').val('');
    $('#business_name').val('');
    $('#full_address').val('');
}

function clearAuditFormValAttr()
{
    $('#autoComId').val('').attr('disabled', false);
    $('#client_name').val('').attr('disabled', true);
    $('#full_name_company').val('').attr('disabled', true);
    $('#type_of_request').val('').attr('disabled', true);
    $('#endorsement_date').val('').attr('disabled', true);
    $('#submission_date').val('').attr('disabled', true);
    $('#internal_tat').val('').attr('disabled', true);
    $('#external_tat').val('').attr('disabled', true);
    $('#special_instruction').val('').attr('disabled', true);
    $('#type_of_checking').val('').attr('disabled', true);
    $('#last_name_arf').val('').attr('disabled', false);
    $('#f_name_arf').val('').attr('disabled', false);
    $('#emp_id_arf').val('').attr('disabled', false);
    $('#dept_arf').val('').attr('disabled', false);
    $('#job_title_arf').val('').attr('disabled', false);
    $('#date_hired_arf').val('').attr('disabled', false);
    $('#findings_arf').val('').attr('disabled', false);
    $('#investigation_arf').val('').attr('disabled', false);
    $('#valid_res_arf').val('').attr('disabled', false);
    $('#statements_arf').val('').attr('disabled', false);
    $('#obs_arf').val('').attr('disabled', false);
    $('#recom_arf').val('').attr('disabled', false);
    $('#business_name').val('').attr('disabled', true);
    $('#full_address').val('').attr('disabled', true);

    $('.date_change').attr('type', 'text');
}

function clearAuditFormAttr()
{
    $('#autoComId').attr('disabled', false);
    $('#client_name').attr('disabled', true);
    $('#full_name_company').attr('disabled', true);
    $('#type_of_request').attr('disabled', true);
    $('#endorsement_date').attr('disabled', true);
    $('#submission_date').attr('disabled', true);
    $('#internal_tat').attr('disabled', true);
    $('#external_tat').attr('disabled', true);
    $('#special_instruction').attr('disabled', true);
    $('#type_of_checking').attr('disabled', true);
    $('#last_name_arf').attr('disabled', false);
    $('#f_name_arf').attr('disabled', false);
    $('#emp_id_arf').attr('disabled', false);
    $('#dept_arf').attr('disabled', false);
    $('#job_title_arf').attr('disabled', false);
    $('#date_hired_arf').attr('disabled', false);
    $('#findings_arf').attr('disabled', false);
    $('#investigation_arf').attr('disabled', false);
    $('#valid_res_arf').attr('disabled', false);
    $('#statements_arf').attr('disabled', false);
    $('#obs_arf').attr('disabled', false);
    $('#recom_arf').attr('disabled', false);
    $('#business_name').attr('disabled', true);
    $('#full_address').attr('disabled', true);

    // $('.date_change').attr('type', 'date');
}

function disableArfAttr()
{
    $('#autoComId').attr('disabled', true);
    $('#client_name').attr('disabled', true);
    $('#full_name_company').attr('disabled', true);
    $('#type_of_request').attr('disabled', true);
    $('#endorsement_date').attr('disabled', true);
    $('#submission_date').attr('disabled', true);
    $('#internal_tat').attr('disabled', true);
    $('#external_tat').attr('disabled', true);
    $('#special_instruction').attr('disabled', true);
    $('#type_of_checking').attr('disabled', true);
    $('#last_name_arf').attr('disabled', true);
    $('#f_name_arf').attr('disabled', true);
    $('#emp_id_arf').attr('disabled', true);
    $('#dept_arf').attr('disabled', true);
    $('#job_title_arf').attr('disabled', true);
    $('#date_hired_arf').attr('disabled', true);
    $('#findings_arf').attr('disabled', true);
    $('#investigation_arf').attr('disabled', true);
    $('#valid_res_arf').attr('disabled', true);
    $('#statements_arf').attr('disabled', true);
    $('#obs_arf').attr('disabled', true);
    $('#recom_arf').attr('disabled', true);
    $('#business_name').attr('disabled', true);
    $('#full_address').attr('disabled', true);
}

$('#dlAttachmentCiReport').click(function()
{
    if($(this).attr('href') != null)
    {
        console.log('yes');

        var id_encode = btoa($(this).attr('href'));
        var q = '<form action="/audit-download-ci-report-arf" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download">'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downSpanAuditForm').html(q);
        $('#button_form_download').click();
    }
    else
    {
        alert('Please select OIMS ID to download');
    }
});

$('#audit_form_print').click(function()
{
    window.print();
});

$('#autoComId').autocomplete
({
    source: '/audit-fetch-suggest-endo-id',
    minLength: 1,
    select: function (event, ui)
    {
        var clearTime = setInterval(function ()
        {
            clearInterval(clearTime);
        },10)
    }
});

$('#oimsIdPhoneField').autocomplete
({
    source: '/audit-fetch-suggest-endo-id',
    minLength: 1,
    select: function (event, ui)
    {
        var clearTime = setInterval(function ()
        {
            clearInterval(clearTime);
        },10)
    }
});

$('#search_oims_bank_field_phone').click(function()
{
    var idCheck = $('#oimsIdPhoneField').val();

    if(idCheck == '')
    {
        alert('Please enter OIMS ID!');
    }
    else
    {
        $.ajax
        ({
            type : 'get',
            url : 'audit-get-info-id-phone-field',
            data :
                {
                    'id' : idCheck
                },
            success : function(data)
            {
                console.log(data);
                if(data[0].length == 0 )
                {
                    alert('Invalid OIMS number!');
                }
                else if(data[0].length > 0)
                {
                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date+' '+time;

                    var busName;
                    var empName;

                    if(data[0][0].busname == null)
                    {
                        busName = '';
                    }
                    else
                    {
                        busName = data[0][0].busname;
                    }
                    if(data[0][0].emp_name == null)
                    {
                        empName = '';
                    }
                    else
                    {
                        empName = data[0][0].emp_name;
                    }

                    $('#fieldPhoneComNameSubj').val(data[0][0].account_name).attr('disabled', true);
                    $('#client_name_phone_field').val(data[0][0].client_name).attr('disabled', true);
                    $('#busName_ph_field').val(busName+empName).attr('disabled', true);
                    $('#tor_field_phone').val(data[0][0].tor).attr('disabled', true);
                    $('#date_endorsed_phone_field').val(data[0][0].date_endorsed).attr('disabled', true);
                    $('#address_phone_field').val(data[0][0].address).attr('disabled', true);
                    $('#ci_visit_ph_field').val(data[0][0].ci_visit).attr('disabled', true);
                    $('#spec_ins_phone_field').val(data[0][0].remarks).attr('disabled', true);
                    $('#toc_phone_field').val(data[0][0].type_of_check).attr('disabled', true);
                    $('#log_time_ph_field').val(dateTime).attr('disabled', true);
                    $('#name_auditor_phone_field').val(data[1]).attr('disabled', true);

                    $('#btn_download_ci_rep_pf').attr('href', idCheck);

                    $('#date_endorsed_phone_field').attr('type', 'text');
                    $('#ci_visit_ph_field').attr('type', 'text');
                }
            }
        });
    }
});

$('#removeValandDis').click(function()
{
    $('#fieldPhoneComNameSubj').val('').attr('disabled', false);
    $('#client_name_phone_field').val('').attr('disabled', false);
    $('#busName_ph_field').val('').attr('disabled', false);
    $('#tor_field_phone').val('').attr('disabled', false);
    $('#date_endorsed_phone_field').val('').attr('disabled', false);
    $('#address_phone_field').val('').attr('disabled', false);
    $('#ci_visit_ph_field').val('').attr('disabled', false);
    $('#spec_ins_phone_field').val('').attr('disabled', false);
    $('#toc_phone_field').val('').attr('disabled', false);
    $('#log_time_ph_field').val('').attr('disabled', false);
    $('#name_auditor_phone_field').val('').attr('disabled', false);
    $('#remCompliance').attr('disabled', false);
    $('#doneThruPhoneField').attr('disabled', false);

    $('#date_endorsed_phone_field').attr('type', 'date');
    $('#ci_visit_ph_field').attr('type', 'date');

    $('#oimsIdPhoneField').attr('disabled', false);
});


$('#btn_submit_phone_field').click(function()
{
    var btn = $(this);
    var fileChecker_phone_field =  '';

    if(field_fine_array.length > 0)
    {
        fileChecker_phone_field = 'with';
    }
    else if(field_fine_array.length <= 0)
    {
        fileChecker_phone_field = 'wtihout';
    }

    btn.attr('disabled', true);

    saveSubmitPf = 'send';

    var saveType;

    var checkPhoneField;

    // var fileUpload = $('#uploadFilePf').prop('files')[0];

    if($('#optionField').is(':checked'))
    {
        checkPhoneField = 'field';
    }
    else if($('#optionPhone').is(':checked'))
    {
        checkPhoneField = 'phone';
    }

    if($(this).attr('href') == null)
    {
        saveType = 'new';

        if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
        {
            sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, fileChecker_phone_field, $('#clickToFilePf').attr('log'));
        }
        else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
        {
            alert('Please enter full name');
            btn.attr('disabled', false);
        }

        // if(fileUpload != null)
        // {
        //     if(fileUpload.type == 'application/pdf')
        //     {
        //         if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
        //         {
        //             sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, 'without');
        //         }
        //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
        //         {
        //             alert('Please enter full name');
        //             btn.attr('disabled', false);
        //         }
        //     }
        //     else
        //     {
        //         alert('Please select a PDF file!');
        //         btn.attr('disabled', false);
        //     }
        // }
        // else
        // {
        //     alert('Please select a file!');
        //     btn.attr('disabled', false);
        // }
    }
    else
    {
        saveType = atob($(this).attr('href'));

        if(btn.attr('name') == 'with')
        {
            if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
            {
                sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, 'new', $('#clickToFilePf').attr('log'));
            }
            else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            {
                alert('Please enter full name');
                btn.attr('disabled', false);
            }


            // if(fileUpload != null)
            // {
            //     if(fileUpload.type == 'application/pdf')
            //     {
            //         if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
            //         {
            //             sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, 'new', $('#clickToFilePf').attr('log'));
            //         }
            //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     if($(this).attr('check') == 'saved' || $(this).attr('check') == 'returned')
            //     {
            //         if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
            //         {
            //             sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, btn.attr('name'), $('#clickToFilePf').attr('log'));
            //         }
            //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please attach a new file.');
            //         btn.attr('disabled', false);
            //     }
            // }

        }
        else if(btn.attr('name') == 'without')
        {
            if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
            {
                sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, btn.attr('name'), $('#clickToFilePf').attr('log'));
            }
            else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            {
                alert('Please enter full name');
                btn.attr('disabled', false);
            }

            // if(fileUpload != null)
            // {
            //     if(fileUpload.type == 'application/pdf')
            //     {
            //         if($('#emp_last_name').val() != '' &&  $('#emp_first_name').val() != '')
            //         {
            //             sendNowPhoneField(checkPhoneField, saveType, btn, saveSubmitPf, btn.attr('name'), $('#clickToFilePf').attr('log'));
            //         }
            //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     alert('Please attach a file.');
            //     btn.attr('disabled', false);
            // }
        }
    }

});

function sendNowPhoneField(form, id, btn, saveOsend, fileStat, log_id)
{
    var oimsId = $('#oimsIdPhoneField').val();
    var subjName = $('#fieldPhoneComNameSubj').val();
    var busName = $('#busName_ph_field').val();
    var addRess = $('#address_phone_field').val();
    var dateLogged = $('#log_time_ph_field').val();
    var auditName = $('#name_auditor_phone_field').val();
    var findings = $('#remCompliance').val();
    var doneThru = $('#doneThruPhoneField').val();
    var clientName = $('#client_name_phone_field').val();
    var tor = $('#tor_field_phone').val();
    var dateEndorsed = $('#date_endorsed_phone_field').val();
    var ciVisit = $('#ci_visit_ph_field').val();
    var spec = $('#spec_ins_phone_field').val();
    var toc = $('#toc_phone_field').val();
    var emp_last_name = $('#emp_last_name').val();
    var emp_first_name = $('#emp_first_name').val();
    var emp_id = $('#emp_id').val();
    var emp_dept = $('#emp_dept_ph_field').val();
    var jobTitle = $('#title_job_phone_field').val();
    var dateHired = $('#date_hired_ph_field').val();
    var sum_rep = $('#summarty_report_field_phone').val();
    // var fileUpload = $('#uploadFilePf').prop('files')[0];
    var compliance_answer = [];
    var informant_validation = [];
    var new_informants_gathered = [];
    var i;
    var j;
    var countValid = 0;
    var countNew = 0;
    var countComp = 0;


    $('.ans_compliance').each(function()
    {
        compliance_answer[countComp] = ($(this).val());
        countComp++;

    });

    for(i = 0; i < 5; i++)
    {
        informant_validation[i] = [];

        $('.inform_valid_' + i + '').each(function()
        {
            informant_validation[i][countValid] = $(this).val();
            countValid++
        });
        countValid = 0;
    }

    for(j = 0; j < 3; j++)
    {
        new_informants_gathered[j] = [];

        $('.new_informant_' + j + '').each(function()
        {
            new_informants_gathered[j][countNew] = $(this).val();
            countNew++
        });
        countNew = 0;
    }

    $.ajax
    ({
        type : 'post',
        url : 'audit-insert-phone-field-log',
        data :
            {
                informant_validation : informant_validation,
                new_informants_gathered : new_informants_gathered,
                compliance_answer :  compliance_answer,
                'oimsId' : oimsId,
                'subjName' : subjName,
                'busName' : busName,
                'addRess' : addRess,
                'dateLogged' : dateLogged,
                'auditName' : auditName,
                'findings' : findings,
                'doneThru' : doneThru,
                'clientName' : clientName,
                'tor' : tor,
                'dateEndorsed' : dateEndorsed,
                'ciVisit' : ciVisit,
                'spec' : spec,
                'toc' : toc,
                'emp_last_name' : emp_last_name,
                'emp_first_name' : emp_first_name,
                'emp_id' : emp_id,
                'emp_dept' : emp_dept,
                'jobTitle' : jobTitle,
                'dateHired' : dateHired,
                'sum_rep' : sum_rep,
                'checkPhoneField' : form,
                'id' : id,
                'log_id' : log_id
            },
        beforeSend : function()
        {
            $('#modal-loading-arf-files').modal('show');
        },
        success : function(data)
        {
            // if(fileStat == 'with')
            // {
            if(field_fine_array.length > 0)
            {
                $('#fieldUploaderDiv').fineUploader('uploadStoredFiles');
            }
                $('#modal-loading-arf-files').modal('hide');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('show');
                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-success-arf-send').modal('hide');
                        clearInterval(timerSuccessHide);
                    },5000);
                    clearInterval(timerSuccess);
                },1000);

                saveCounter = true;
                getLogsFunction(what_logs);
                btn.attr('disabled', false);

                disPfALl();

                $('#btn_save_phone_field').attr('href', btoa(data[2]));
                $('#btn_submit_phone_field').attr('href', btoa(data[2]));
                $('#btn_submit_phone_field').attr('name', 'without');

                $('#btn_edit_phone_field').attr('disabled', false);
            // }
            // else if(fileStat == 'without' || fileStat == 'new')
            // {
                // sendFilesPhoneField(data[0], data[1], fileUpload, saveOsend)
            // }
        },
        error : function()
        {
            alert('There was a problem in inserting to our database!');
            btn.attr('disabled', false);
        }
    });
}

function sendFilesPhoneField(data1, data2, file, type)
{
    var formData = new FormData;

    formData.append('id', data1);
    formData.append('type', data2);
    formData.append('file', file);

    $.ajax
    ({
        xhr: function()
        {
            var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt)
            {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    $('#ulPercentage_ArfFile').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_ArfFile').append(Math.floor(percentComplete*100));
                    $('#progressbar_ArfFile').show();
                    $('#progressbar_ArfFile').progressbar
                    (
                        {
                            value: percentComplete * 100
                        }
                    )
                }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with download progress
                        console.log(percentComplete);
                    }
                },
                false
            );
            return xhr;
        },
        type : 'post',
        url : 'audit-insert-file-pf',
        contentType: false,
        processData: false,
        async: true,
        data : formData,
        success : function(data)
        {
            $('#uploadFilePf').val('');
            $('#statFilePf').html('Upload Attachment');

            // $('#viewAttachmentPhoneField').attr('href', '/view_report_form/'+ btoa(data[0]));
            $('#viewAttachmentPhoneField').show();

            disPfALl();

            $('#btn_save_phone_field').attr('href', btoa(data[1]));
            $('#btn_submit_phone_field').attr('href', btoa(data[1]));
            $('#btn_submit_phone_field').attr('name', 'with');

            $('#btn_edit_phone_field').attr('disabled', false);
        },
        complete : function ()
        {
            $('#modal-loading-arf-files').modal('hide');

            var timerSuccess = setInterval(function ()
            {
                $('#modal-success-arf-send').modal('show');
                var timerSuccessHide = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('hide');
                    clearInterval(timerSuccessHide);
                },5000);
                clearInterval(timerSuccess);
            },1000);

            if(type == 'send')
            {
                checkAuditLogComp = true;
                submitCounter = true;
                $('#btn_submit_phone_field').attr('disabled', false);
            }
            else if(type == 'save')
            {
                $('#btn_save_phone_field').attr('disabled', false);
                saveCounter = true;
            }

            getLogsFunction(what_logs);
        }
    });
}



$('#btn_clear_phone_field').click(function()
{
    $('#newFormPf').click();

    // clearPhoneField();
    // $('#btn_download_ci_rep_pf').removeAttr('href');
    // $('#btn_edit_phone_field').attr('disabled', true);
    // $('#btn_save_phone_field').removeAttr('href');
    // $('#removeValandDis').attr('disabled', false);
    // $('#viewAttachmentPhoneField').removeAttr('href');
    // $('#viewAttachmentPhoneField').hide();
    // $('#btn_submit_phone_field').attr('name', 'without');
    // $('#btn_submit_phone_field').removeAttr('href');
    // $('#removeValandDis').attr('disabled', false);
});

function clearPhoneField()
{
    $('#oimsIdPhoneField').val('').attr('disabled', false);
    $('#fieldPhoneComNameSubj').val('').attr('disabled', true);
    $('#busName_ph_field').val('').attr('disabled', true);
    $('#address_phone_field').val('').attr('disabled', true);
    $('#log_time_ph_field').val('').attr('disabled', true);
    $('#name_auditor_phone_field').val('').attr('disabled', true);
    $('#remCompliance').val('').attr('disabled', false);
    $('#doneThruPhoneField').val('').attr('disabled', false);
    $('#client_name_phone_field').val('').attr('disabled', true);
    $('#tor_field_phone').val('').attr('disabled', true);
    $('#date_endorsed_phone_field').val('').attr('disabled', true);
    $('#ci_visit_ph_field').val('').attr('disabled', true);
    $('#spec_ins_phone_field').val('').attr('disabled', true);
    $('#toc_phone_field').val('').attr('disabled', true);
    $('#emp_last_name').val('').attr('disabled', false);
    $('#emp_first_name').val('').attr('disabled', false);
    $('#emp_id').val('').attr('disabled', false);
    $('#emp_dept_ph_field').val('').attr('disabled', false);
    $('#title_job_phone_field').val('').attr('disabled', false);
    $('#date_hired_ph_field').val('').attr('disabled', false);
    $('#summarty_report_field_phone').val('').attr('disabled', false);
    $('.ans_compliance').val('---').attr('disabled', false);
    $('.informant_clear').val('').attr('disabled', false);
    $('.informant_clear_select').val('---').attr('disabled', false);

    $('#date_endorsed_phone_field').attr('type', 'text');
    $('#ci_visit_ph_field').attr('type', 'text');
    $('#log_time_ph_field').attr('type', 'text');


}

function clearfieldsOnlyFalseDin()
{
    $('#oimsIdPhoneField').attr('disabled', false);
    $('#fieldPhoneComNameSubj').attr('disabled', true);
    $('#busName_ph_field').attr('disabled', true);
    $('#address_phone_field').attr('disabled', true);
    $('#remCompliance').attr('disabled', false);
    $('#doneThruPhoneField').attr('disabled', false);
    $('#client_name_phone_field').attr('disabled', true);
    $('#tor_field_phone').attr('disabled', true);
    $('#date_endorsed_phone_field').attr('disabled', true);
    $('#ci_visit_ph_field').attr('disabled', true);
    $('#spec_ins_phone_field').attr('disabled', true);
    $('#toc_phone_field').attr('disabled', true);
    $('#emp_last_name').attr('disabled', false);
    $('#emp_first_name').attr('disabled', false);
    $('#emp_id').attr('disabled', false);
    $('#emp_dept_ph_field').attr('disabled', false);
    $('#title_job_phone_field').attr('disabled', false);
    $('#date_hired_ph_field').attr('disabled', false);
    $('#summarty_report_field_phone').attr('disabled', false);
    $('.ans_compliance').attr('disabled', false);
    $('.informant_clear').attr('disabled', false);
    $('.informant_clear_select').attr('disabled', false)
}

function disPfALl()
{
    $('#oimsIdPhoneField').attr('disabled', true);
    $('#fieldPhoneComNameSubj').attr('disabled', true);
    $('#busName_ph_field').attr('disabled', true);
    $('#address_phone_field').attr('disabled', true);
    $('#remCompliance').attr('disabled', true);
    $('#doneThruPhoneField').attr('disabled', true);
    $('#client_name_phone_field').attr('disabled', true);
    $('#tor_field_phone').attr('disabled', true);
    $('#date_endorsed_phone_field').attr('disabled', true);
    $('#ci_visit_ph_field').attr('disabled', true);
    $('#spec_ins_phone_field').attr('disabled', true);
    $('#toc_phone_field').attr('disabled', true);
    $('#emp_last_name').attr('disabled', true);
    $('#emp_first_name').attr('disabled', true);
    $('#emp_id').attr('disabled', true);
    $('#emp_dept_ph_field').attr('disabled', true);
    $('#title_job_phone_field').attr('disabled', true);
    $('#date_hired_ph_field').attr('disabled', true);
    $('#summarty_report_field_phone').attr('disabled', true);
    $('.ans_compliance').attr('disabled', true);
    $('.informant_clear').attr('disabled', true);
    $('.informant_clear_select').attr('disabled', true)
}

$('#btn_print_phone_field').click(function()
{
    window.print();
});

$('#btn_download_ci_rep_pf').click(function()
{
    if($(this).attr('href') != null)
    {
        console.log('yes');

        var id_encode = btoa($(this).attr('href'));
        var q = '<form action="/audit-download-ci-report-arf" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download_pf">'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#dwnSpanPhoneFiled').html(q);
        $('#button_form_download_pf').click();
    }
    else
    {
        alert('Please select OIMS ID to download');
    }
});

$('#submitCiReportChecking').click(function()
{
    var btn = $(this);
    btn.attr('disabled', true);

    saveSubmitCssf = 'send';

    // var tab6_file = $('#tab6_upload').prop('files')[0];
    // var checkFile = $('#tab6_upload').val();

    var saveType;

    if($(this).attr('href') == null)
    {
        saveType = 'new';

        if(ciRep_fine_array.length > 0)
        {
            if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
            {
                sendNowCssf(saveType, btn, saveSubmitCssf, 'without', $('#tab_6_upload_label').attr('log'));
            }
            else if($('#employee_last_name').val() == '' &&  $('#employee_first_name').val() == '')
            {
                alert('Please enter full name');
                btn.attr('disabled', false);
            }
        }
        else
        {
            alert('Please select a file!');
            btn.attr('disabled', false);
        }

        // if(checkFile != '')
        // {
        //     if(tab6_file.type == 'application/pdf')
        //     {
        //         if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
        //         {
        //             sendNowCssf(saveType, btn, saveSubmitCssf, 'without');
        //         }
        //         else if($('#employee_last_name').val() == '' &&  $('#employee_first_name').val() == '')
        //         {
        //             alert('Please enter full name');
        //             btn.attr('disabled', false);
        //         }
        //     }
        //     else
        //     {
        //         alert('Please select a PDF file!');
        //         btn.attr('disabled', false);
        //     }
        // }
        // else
        // {
        //     alert('Please select a file!');
        //     btn.attr('disabled', false);
        // }
    }
    else
    {
        saveType = atob($(this).attr('href'));

        if(btn.attr('name') == 'with')
        {
            if(ciRep_fine_array.length > 0)
            {
                if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
                {
                    sendNowCssf(saveType, btn, saveSubmitCssf, 'new', $('#tab_6_upload_label').attr('log'));
                }
                else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
                {
                    alert('Please enter full name');
                    btn.attr('disabled', false);
                }
            }
            else
            {
                alert('Please select a new file!');
                btn.attr('disabled', false);
            }

            // if(checkFile != '')
            // {
            //     if(tab6_file.type == 'application/pdf')
            //     {
            //         if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
            //         {
            //             sendNowCssf(saveType, btn, saveSubmitCssf, 'new');
            //         }
            //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     if($(this).attr('check') == 'saved' || $(this).attr('check') == 'returned')
            //     {
            //         if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
            //         {
            //             sendNowCssf(saveType, btn, saveSubmitCssf, btn.attr('name'));
            //         }
            //         else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a new file!');
            //         btn.attr('disabled', false);
            //     }
            // }
        }
        else if(btn.attr('name') == 'without')
        {
            if(ciRep_fine_array.length > 0)
            {
                if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
                {
                    sendNowCssf(saveType, btn, saveSubmitCssf, 'without', $('#tab_6_upload_label').attr('log'));
                }
                else if($('#employee_last_name').val() == '' &&  $('#employee_first_name').val() == '')
                {
                    alert('Please enter full name');
                    btn.attr('disabled', false);
                }
            }
            else
            {
                alert('Please select a file!');
                btn.attr('disabled', false);
            }

            // if(tab6_file != null)
            // {
            //     if(tab6_file.type == 'application/pdf')
            //     {
            //         if($('#employee_last_name').val() != '' &&  $('#employee_first_name').val() != '')
            //         {
            //             sendNowCssf(saveType, btn, saveSubmitCssf, btn.attr('name'));
            //         }
            //         else if($('#employee_last_name').val() == '' &&  $('#employee_first_name').val() == '')
            //         {
            //             alert('Please enter full name');
            //             btn.attr('disabled', false);
            //         }
            //     }
            //     else
            //     {
            //         alert('Please select a PDF file!');
            //         btn.attr('disabled', false);
            //     }
            // }
            // else
            // {
            //     alert('Please select a file!');
            //     btn.attr('disabled', false);
            // }
        }
    }

});

function sendNowCssf(id, btn, type, filestat, log_id)
{
    var ci_emp_id = $('#ci_employee_id').val();
    var ci_last_name = $('#employee_last_name').val();
    var ci_first_name = $('#employee_first_name').val();
    var ci_job_title = $('#employee_job_title_cssf').val();
    var ci_date_hired = $('#ci_date_hired').val();
    var ci_area = $('#ci_area').val();
    var ci_branch_head = $('#ci_branch_head').val();
    var ci_reg_branch_head = $('#ci_reg_branch_head').val();
    var ci_sao = $('#ci_sao').val();
    var ci_sup = $('#ci_sup').val();
    var ci_grade_completeness = $('#ci_grade_completeness').val();
    var ci_grade_gps = $('#ci_grade_gps').val();
    var ci_grade_informantsValidity = $('#ci_grade_informantsValidity').val();
    var ci_grade_encodingAccu = $('#ci_grade_encodingAccu').val();
    var ci_grade_selfie = $('#ci_grade_selfie').val();
    var ci_grade_tatCompliance = $('#ci_grade_tatCompliance').val();
    var ci_grade_attachedDocs = $('#ci_grade_attachedDocs').val();
    var ci_grade_completeness_rem = $('#ci_grade_completeness_rem').val();
    var ci_grade_gps_rem = $('#ci_grade_gps_rem').val();
    var ci_grade_informantsValidity_rem = $('#ci_grade_informantsValidity_rem').val();
    var ci_grade_encodingAccu_rem = $('#ci_grade_encodingAccu_rem').val();
    var ci_grade_selfie_rem = $('#ci_grade_selfie_rem').val();
    var ci_grade_tatCompliance_rem = $('#ci_grade_tatCompliance_rem').val();
    var ci_grade_attachedDocs_rem = $('#ci_grade_attachedDocs_rem').val();

    //ACCOUNT DETAILS

    var messenger_endorse_id = $('#account_messenger_id').val();
    var oims_endorse_id = $('#ci_account_oims_id').val();
    var account_bank_name =$('#account_bank_name').val();
    var account_date_endorse = $('#account_date_endorse').val();
    var account_name = $('#account_name').val();
    var ci_date_visited = $('#ci_date_visited').val();
    var account_tor = $('#account_tor').val();
    var accnt_handling_type = $('#accnt_handling_type').val();
    var accnt_source = $('#accnt_source').val();
    // var tab6_file = $('#tab6_upload').prop('files')[0];

    if(ciRep_fine_array.length > 0)
    {
        $.ajax
        ({
            type: 'get',
            url: 'audit_ci_report_checking_form',
            data:
                {
                    'emp_id' : ci_emp_id,
                    'ci_last_name' : ci_last_name,
                    'ci_first_name' : ci_first_name,
                    'ci_job_title' : ci_job_title,
                    'ci_date_hired' : ci_date_hired,
                    'ci_area' : ci_area,
                    'ci_branch_head' : ci_branch_head,
                    'ci_regional_head' : ci_reg_branch_head,
                    'ci_senior_account_officer' : ci_sao,
                    'ci_supervisor' : ci_sup,
                    'oims_endorse_id': oims_endorse_id,
                    'messenger_endorse_id': messenger_endorse_id,
                    'account_name' : account_name,
                    'bank_name' : account_bank_name,
                    'endorse_date' : account_date_endorse,
                    'date_visited' : ci_date_visited,
                    'account_tor' : account_tor,
                    'handling_type' : accnt_handling_type,
                    'account_source' : accnt_source,
                    'completeness' : ci_grade_completeness,
                    'completeness_remarks' : ci_grade_completeness_rem,
                    'gps_attachment' : ci_grade_gps,
                    'gps_attachment_remarks' : ci_grade_gps_rem,
                    'informants_validity': ci_grade_informantsValidity,
                    'informants_validity_remarks' : ci_grade_informantsValidity_rem,
                    'encoding_accuracy' : ci_grade_encodingAccu,
                    'encoding_accuracy_remarks' : ci_grade_encodingAccu_rem,
                    'selfie_uniform_id' : ci_grade_selfie,
                    'selfie_uniform_id_remarks' : ci_grade_selfie_rem,
                    'tat_compliance' : ci_grade_tatCompliance,
                    'tat_compliance_remarks' : ci_grade_tatCompliance_rem,
                    'attached_documents' : ci_grade_attachedDocs,
                    'attached_documents_remarks' : ci_grade_attachedDocs_rem,
                    'report_summary' : $('#ci_account_summary').val(),
                    'cause_of_delay' : $('#cause_of_delay_rem').val(),
                    'id' : id,
                    'log_id' : log_id
                },
            beforeSend : function()
            {
                $('#modal-loading-arf-files').modal('show');
            },
            success: function(data)
            {
                console.log(data);
                if(ciRep_fine_array.length > 0)
                {
                    $('#qq-audit-ciRep-form-fine-holder').fineUploader('uploadStoredFiles');
                }
                // if(filestat == 'with')
                // {
                $('#modal-loading-arf-files').modal('hide');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('show');
                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-success-arf-send').modal('hide');
                        clearInterval(timerSuccessHide);
                    }, 5000);
                    clearInterval(timerSuccess);
                }, 1000);

                checkAuditLogComp = true;
                submitCounter = true;
                getLogsFunction(what_logs);
                btn.attr('disabled', false);

                disCssfAll();

                $('#btn_save_cssf').attr('href', btoa(data));
                $('#submitCiReportChecking').attr('href', btoa(data));
                $('#submitCiReportChecking').attr('name', 'without');

                $('#editTab6').attr('disabled', false);
                // }
                // else if (filestat == 'without' || filestat == 'new')
                // {
                //     sendFilesCssf(tab6_file, data, type);
                // }
            }
        });
    }
    else {
        alert('No Attachment');
    }
}

function sendFilesCssf(file, log ,type)
{
    var formData = new FormData();
    formData.append('file6', file);
    formData.append('log_id', log);

    $.ajax
    ({
        xhr: function()
        {
            var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt)
            {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    $('#ulPercentage_ArfFile').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_ArfFile').append(Math.floor(percentComplete*100));
                    $('#progressbar_ArfFile').show();
                    $('#progressbar_ArfFile').progressbar
                    (
                        {
                            value: percentComplete * 100
                        }
                    )
                }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with download progress
                        console.log(percentComplete);
                    }
                },
                false
            );
            return xhr;
        },
        type: 'post',
        url: 'audit_tab6_upload',
        data: formData,
        contentType: false,
        processData: false,
        async : true,
        success: function(data)
        {
            $('#tab_6_upload_label').html('Upload Attachment');

            $('#viewAttachmentCssf').attr('href', '/view_report_form/'+ btoa(data[0]));
            $('#viewAttachmentCssf').show();

            disCssfAll();

            $('#btn_save_cssf').attr('href', btoa(data[1]));
            $('#submitCiReportChecking').attr('href', btoa(data[1]));
            $('#submitCiReportChecking').attr('name', 'with');

            $('#editTab6').attr('disabled', false);
        },
        complete: function()
        {
            $('#modal-loading-arf-files').modal('hide');

            var timerSuccess = setInterval(function ()
            {
                $('#modal-success-arf-send').modal('show');
                var timerSuccessHide = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('hide');
                    clearInterval(timerSuccessHide);
                },5000);
                clearInterval(timerSuccess);
            },1000);

            if(type == 'send')
            {
                checkAuditLogComp = true;
                submitCounter = true;
                $('#submitCiReportChecking').attr('disabled', false);
            }
            else if(type == 'save')
            {
                $('#btn_save_cssf').attr('disabled', false);
                saveCounter = true;
            }
            getLogsFunction(what_logs);
        }
    });
}

$('#ci_grade_tatCompliance').change(function(){
    ci_gradeComputation();
    if($(this).val() != 0)
    {
        $('#cause_of_delay_rem').attr('disabled', true);
        $('#cause_of_delay_rem').val('');
    }
    else
    {
        $('#cause_of_delay_rem').attr('disabled', false);
    }
});

function ci_gradeComputation()
{
    var ci_tatCompliance_grade = 0;
    var ci_comp_grade_raw = $('#ci_grade_completeness').children("option:selected").val();
    var ci_comp_grade = parseInt(ci_comp_grade_raw);
    var ci_gps_grade_raw = $('#ci_grade_gps').children("option:selected").val();
    var ci_gps_grade = parseInt(ci_gps_grade_raw);
    var ci_informantsValidity_grade_raw = $('#ci_grade_informantsValidity').children("option:selected").val();
    var ci_informantsValidity_grade = parseInt(ci_informantsValidity_grade_raw);
    var ci_encodingAccu_grade_raw = $('#ci_grade_encodingAccu').children("option:selected").val();
    var ci_encodingAccu_grade = parseInt(ci_encodingAccu_grade_raw);
    var ci_selfie_grade_raw = $('#ci_grade_selfie').children("option:selected").val();
    var ci_selfie_grade = parseInt(ci_selfie_grade_raw);
    var ci_tatCompliance_grade_raw = $('#ci_grade_tatCompliance').children("option:selected").val();
    ci_tatCompliance_grade = parseInt(ci_tatCompliance_grade_raw);
    var ci_attachedDocs_grade_raw = $('#ci_grade_attachedDocs').children("option:selected").val();
    var ci_attachedDocs_grade = parseInt(ci_attachedDocs_grade_raw);

    if($('#ci_grade_tatCompliance').val() == '-')
    {
        ci_tatCompliance_grade = 0;
    }

    var total_ci_grade = ci_gps_grade + ci_comp_grade + ci_informantsValidity_grade + ci_encodingAccu_grade + ci_selfie_grade + ci_tatCompliance_grade + ci_attachedDocs_grade;

    var total_grade_ci = $('#ci_grade_total').val(total_ci_grade + "%");
}

$('#ci_messenger_account').click(function()
{
    $('#account_messenger_id').val('');
    $('#ci_account_oims_id').val('');
    $('#account_bank_name').val('');
    $('#account_date_endorse').val('');
    $('#account_name').val('');
    $('#ci_date_visited').val('');
    $('#account_tor').val('');
    $('#accnt_handling_type').val('');
    $('#accnt_source').val('');

    if($('#account_messenger_id').prop('disabled'))
    {
        $('#account_messenger_id').attr('disabled', false);
        $('#ci_account_oims_id').attr('disabled', true);
        what_to_submit_Tab6 = 'messenger_id';
        $('#account_bank_name').attr('disabled', false);
        $('#account_date_endorse').attr('disabled', false);
        $('#account_name').attr('disabled', false);
        $('#ci_date_visited').attr('disabled', false);
        $('#account_tor').attr('disabled', false);
        $('#accnt_handling_type').attr('disabled', false);
        $('#accnt_source').attr('disabled', false);
    }
    else
    {
        $('#account_messenger_id').attr('disabled', true);
        $('#ci_account_oims_id').attr('disabled', false);
        what_to_submit_Tab6 = 'oims_id';
        $('#account_bank_name').attr('disabled', true);
        $('#account_date_endorse').attr('disabled', true);
        $('#account_name').attr('disabled', true);
        $('#ci_date_visited').attr('disabled', true);
        $('#account_tor').attr('disabled', true);
        $('#accnt_handling_type').attr('disabled', true);
        $('#accnt_source').attr('disabled', true);
    }
});

function ClearallFieldsTab6()
{
    $('#ci_employee_id').val('');
    $('#employee_last_name').val('');
    $('#employee_first_name').val('');
    $('#employee_job_title_cssf').val('');
    $('#ci_date_hired').val('');
    $('#ci_area').val('');
    $('#ci_branch_head').val('');
    $('#ci_reg_branch_head').val('');
    $('#ci_sao').val('');
    $('#ci_sup').val('');
    $('#ci_grade_completeness').val(0);
    $('#ci_grade_gps').val(0);
    $('#ci_grade_informantsValidity').val(0);
    $('#ci_grade_encodingAccu').val(0);
    $('#ci_grade_selfie').val(0);
    $('#ci_grade_tatCompliance').val('-');
    $('#ci_grade_attachedDocs').val(0);
    $('#ci_grade_completeness_rem').val('');
    $('#ci_grade_gps_rem').val('');
    $('#ci_grade_informantsValidity_rem').val('');
    $('#ci_grade_encodingAccu_rem').val('');
    $('#ci_grade_selfie_rem').val('');
    $('#ci_grade_tatCompliance_rem').val('');
    $('#ci_grade_attachedDocs_rem').val('');
    $('#account_messenger_id').val('');
    $('#ci_account_oims_id').val('');
    $('#account_bank_name').val('');
    $('#account_date_endorse').val('');
    $('#account_name').val('');
    $('#ci_date_visited').val('');
    $('#account_tor').val('');
    $('#accnt_handling_type').val('');
    $('#accnt_source').val('');
    $('#ci_account_summary').val('');
    $('#cause_of_delay_rem').val('');
    $('#ci_grade_total').val('0%');
}

// function disableFieldstab6()
// {
//     $('#ci_employee_id').attr('disabled', false);
//     $('#employee_name').attr('disabled', false);
//     $('#ci_date_hired').attr('disabled', false);
//     $('#ci_area').attr('disabled', false);
//     $('#ci_branch_head').attr('disabled', false);
//     $('#ci_reg_branch_head').attr('disabled', false);
//     $('#ci_sao').attr('disabled', false);
//     $('#ci_sup').attr('disabled', false);
//     $('#ci_grade_completeness').attr('disabled', false);
//     $('#ci_grade_gps').attr('disabled', false);
//     $('#ci_grade_informantsValidity').attr('disabled', false);
//     $('#ci_grade_encodingAccu').attr('disabled', false);
//     $('#ci_grade_selfie').attr('disabled', false);
//     $('#ci_grade_tatCompliance').attr('disabled', false);
//     $('#ci_grade_attachedDocs').attr('disabled', false);
//     $('#ci_grade_completeness_rem').attr('disabled', false);
//     $('#ci_grade_gps_rem').attr('disabled', false);
//     $('#ci_grade_informantsValidity_rem').attr('disabled', false);
//     $('#ci_grade_encodingAccu_rem').attr('disabled', false);
//     $('#ci_grade_selfie_rem').attr('disabled', false);
//     $('#ci_grade_tatCompliance_rem').attr('disabled', false);
//     $('#ci_grade_attachedDocs_rem').attr('disabled', false);
// }

function enabledAllFieldTab6()
{
    $('#ci_employee_id').attr('disabled', false);
    $('#employee_last_name').attr('disabled', false);
    $('#employee_first_name').attr('disabled', false);
    $('#employee_job_title_cssf').attr('disabled', false);
    $('#ci_date_hired').attr('disabled', false);
    $('#ci_area').attr('disabled', false);
    $('#ci_branch_head').attr('disabled', false);
    $('#ci_reg_branch_head').attr('disabled', false);
    $('#ci_sao').attr('disabled', false);
    $('#ci_sup').attr('disabled', false);
    $('#ci_grade_completeness').attr('disabled', false);
    $('#ci_grade_gps').attr('disabled', false);
    $('#ci_grade_informantsValidity').attr('disabled', false);
    $('#ci_grade_encodingAccu').attr('disabled', false);
    $('#ci_grade_selfie').attr('disabled', false);
    $('#ci_grade_tatCompliance').attr('disabled', false);
    $('#ci_grade_attachedDocs').attr('disabled', false);
    $('#ci_grade_completeness_rem').attr('disabled', false);
    $('#ci_grade_gps_rem').attr('disabled', false);
    $('#ci_grade_informantsValidity_rem').attr('disabled', false);
    $('#ci_grade_encodingAccu_rem').attr('disabled', false);
    $('#ci_grade_selfie_rem').attr('disabled', false);
    $('#ci_grade_tatCompliance_rem').attr('disabled', false);
    $('#ci_grade_attachedDocs_rem').attr('disabled', false);

    $('#account_messenger_id').attr('disabled', true);
    $('#ci_account_oims_id').attr('disabled', false);
    $('#account_bank_name').attr('disabled', true);
    $('#account_date_endorse').attr('disabled', true);
    $('#account_name').attr('disabled', true);
    $('#ci_date_visited').attr('disabled', true);
    $('#account_tor').attr('disabled', true);
    $('#accnt_handling_type').attr('disabled', true);
    $('#accnt_source').attr('disabled', true);
    $('#ci_account_summary').attr('disabled', false);
    $('#cause_of_delay_rem').attr('disabled', true);
    $('#ci_messenger_account').attr('disabled', false);
}

function disCssfAll()
{
    $('#ci_employee_id').attr('disabled', true);
    $('#employee_last_name').attr('disabled', true);
    $('#employee_first_name').attr('disabled', true);
    $('#employee_job_title_cssf').attr('disabled', true);
    $('#ci_date_hired').attr('disabled', true);
    $('#ci_area').attr('disabled', true);
    $('#ci_branch_head').attr('disabled', true);
    $('#ci_reg_branch_head').attr('disabled', true);
    $('#ci_sao').attr('disabled', true);
    $('#ci_sup').attr('disabled', true);
    $('#ci_grade_completeness').attr('disabled', true);
    $('#ci_grade_gps').attr('disabled', true);
    $('#ci_grade_informantsValidity').attr('disabled', true);
    $('#ci_grade_encodingAccu').attr('disabled', true);
    $('#ci_grade_selfie').attr('disabled', true);
    $('#ci_grade_tatCompliance').attr('disabled', true);
    $('#ci_grade_attachedDocs').attr('disabled', true);
    $('#ci_grade_completeness_rem').attr('disabled', true);
    $('#ci_grade_gps_rem').attr('disabled', true);
    $('#ci_grade_informantsValidity_rem').attr('disabled', true);
    $('#ci_grade_encodingAccu_rem').attr('disabled', true);
    $('#ci_grade_selfie_rem').attr('disabled', true);
    $('#ci_grade_tatCompliance_rem').attr('disabled', true);
    $('#ci_grade_attachedDocs_rem').attr('disabled', true);

    $('#account_messenger_id').attr('disabled', true);
    $('#ci_account_oims_id').attr('disabled', true);
    $('#account_bank_name').attr('disabled', true);
    $('#account_date_endorse').attr('disabled', true);
    $('#account_name').attr('disabled', true);
    $('#ci_date_visited').attr('disabled', true);
    $('#account_tor').attr('disabled', true);
    $('#accnt_handling_type').attr('disabled', true);
    $('#accnt_source').attr('disabled', true);
    $('#ci_account_summary').attr('disabled', false);
    $('#cause_of_delay_rem').attr('disabled', true);
    $('#ci_messenger_account').attr('disabled', true);
}

$('#tab6Print').on('click', function()
{
    window.print();
});

function searchtab6(id)
{
    $.ajax({
        type: 'get',
        url: 'audit_get_account_info_and_details',
        data: {
            'id' : id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '' || data == null)
            {
                console.log('No data');
                $('#account_bank_name').attr('disabled', true);
                $('#account_date_endorse').attr('disabled', true);
                $('#account_name').attr('disabled', true);
                $('#ci_date_visited').attr('disabled', true);
                $('#account_tor').attr('disabled', true);
                $('#accnt_handling_type').attr('disabled', true);
                $('#accnt_source').attr('disabled', true);

                $('#account_bank_name').val('');
                $('#account_date_endorse').val('');
                $('#account_name').val('');
                $('#ci_date_visited').val('');
                $('#account_tor').val('');
                $('#accnt_handling_type').val('');
                $('#accnt_source').val('');
            }
            else
            {
                $('#account_bank_name').attr('disabled', true);
                $('#account_date_endorse').attr('disabled', true);
                $('#account_name').attr('disabled', true);
                $('#ci_date_visited').attr('disabled', true);
                $('#account_tor').attr('disabled', true);
                $('#accnt_handling_type').attr('disabled', true);
                $('#accnt_source').attr('disabled', true);

                $('#account_bank_name').val(data[0][0].client_name);
                $('#account_date_endorse').val(data[0][0].date_endorsed);
                $('#account_name').val(data[0][0].account_name);
                $('#ci_date_visited').val(data[0][0].date_ci_visit);
                $('#account_tor').val(data[0][0].type_of_request);
                // $('#accnt_handling_type').val(data[0][0].verify_through);
                // $('#accnt_source').val(data[0][0].type_of_sending_report);

                $('#dwn_attachment_ci_endorse_ccsf').attr('href', id);
            }
        }
    });
}

function getLogsFunction(what_logs)
{
    $.ajax({
        type: 'get',
        url: 'audit_get_logs',
        data:{
            'what_type' : what_logs
        },
        success: function(data)
        {
            console.log(data);
            var tableData = '';
            var type;
            var check;
            var tableHead = '<table style="table-layout: auto;word-wrap: break-word; width: 100%;" class="table-hover">\n' +
                '<tr style="background-color: black; color: white;">\n' +
                '<th>Activity Logs</th>\n' +
                '</tr>';

            if(data[0].length > 0)
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    if(data[0][i].save == 1)
                    {
                        if(data[0][i].stat == 1)
                        {
                            type = "background-color: #b3ffb3;"
                            check = 'approved';
                        }
                        else if(data[0][i].stat == 2)
                        {
                            type = "background-color: #ffb3b3;"
                            check = 'returned';
                        }
                        else if(data[0][i].stat == 0)
                        {
                            type = "background-color : #a2fdea";
                            check = 'review';
                        }
                    }
                    else if (data[0][i].save == 2)
                    {
                        type = "";
                        check = "saved";

                    }
                    tableData += '<tr class="get_logs_info" value="'+data[0][i].id+'" href = "'+data[0][i].type+'" style="cursor: pointer; " title="Click to retrieve data." for="logs_ito" check = "'+check+'">\n' +
                        '<td style = "'+type+'" >'+data[0][i].id+' / '+data[0][i].name+' / '+data[0][i].activity+' / '+data[0][i].date_time+'</td>\n' +
                        '</tr>';
                }
            }
            else
            {
                tableData += '<tr><td colspan="4">No Records Available</td></tr>'
            }

            $('.audits_log_table').html(tableHead + tableData + '</table>');
        }
    });
}

$(document).on('click', '.get_logs_info', function()
{
    var target1 = $(event.target);
    $('#thisisUploadedDiscrep').hide();

    if(target1.is("button"))
    {

    }
    // else if($(this).attr('id') == 'approved' || $(this).attr('id') == 'review')
    // {
    //     alert('Report cannot be updated!');
    // }
    else
    {
        var type_click = $(this).attr('for');
        var rad_button = $(this).attr('rad');
        var tab_form = $(this).attr('tab');
        var log_id;
        var type;
        var checkType = $(this).attr('check');
        $('#FieldUploadedAttachments').hide();


        if(type_click == 'monitoring')
        {
            $('#tabA').click();
            $(tab_form).click();

            if(rad_button != 'none')
            {
                $(rad_button).prop('checked', true);
                $(rad_button).click();

                log_id = $(this).attr('id');
                type = $(this).attr('typee');
            }
            else
            {
                log_id = $(this).attr('id');
                type = $(this).attr('typee');
            }
        }
        else if(type_click == 'logs_ito')
        {
            log_id = $(this).attr('value');
            type = $(this).attr('href');
        }

        // console.log(log_id);
        $.ajax
        ({
            type: 'get',
            url: 'audit_get_logs_value_tab6',
            data: {
                'id' : log_id,
                'type' : type
            },
            success: function(data)
            {
                if(type == 'ci_report_checking')
                {
                    console.log(data);

                    $('#tab_6_upload_label').attr('log', data[0][0][0].log_id);
                    var name3 = data[0][0][0].emp_name;

                    var fullname3 = name3.split(", ");

                    var lname3 = capitalize_Words(fullname3[0]);
                    var fname3 = capitalize_Words(fullname3[1]);

                    $('#ci_employee_id').val(data[0][0][0].emp_id).attr('disabled', true);
                    $('#employee_last_name').val(lname3).attr('disabled', true);
                    $('#employee_first_name').val(fname3).attr('disabled', true);
                    $('#employee_job_title_cssf').val(data[0][0][0].emp_job).attr('disabled', true);
                    $('#ci_date_hired').val(data[0][0][0].emp_date_hired).attr('disabled', true);
                    $('#ci_area').val(data[0][0][0].ci_area).attr('disabled', true);
                    $('#ci_branch_head').val(data[0][0][0].ci_branch_head).attr('disabled', true);
                    $('#ci_reg_branch_head').val(data[0][0][0].ci_regional_head).attr('disabled', true);
                    $('#ci_sao').val(data[0][0][0].ci_senior_account_officer).attr('disabled', true);
                    $('#ci_sup').val(data[0][0][0].ci_supervisor).attr('disabled', true);
                    $('#ci_grade_completeness').val(data[0][0][0].completeness).attr('disabled', true);
                    $('#ci_grade_gps').val(data[0][0][0].gps_attachment).attr('disabled', true);
                    $('#ci_grade_informantsValidity').val(data[0][0][0].informants_validity).attr('disabled', true);
                    $('#ci_grade_encodingAccu').val(data[0][0][0].encoding_accuracy).attr('disabled', true);
                    $('#ci_grade_selfie').val(data[0][0][0].selfie_uniform_id).attr('disabled', true);
                    $('#ci_grade_tatCompliance').val(data[0][0][0].tat_compliance).attr('disabled', true);
                    $('#ci_grade_attachedDocs').val(data[0][0][0].attached_documents).attr('disabled', true);
                    $('#ci_grade_completeness_rem').val(data[0][0][0].completeness_remarks).attr('disabled', true);
                    $('#ci_grade_gps_rem').val(data[0][0][0].gps_attachment_remarks).attr('disabled', true);
                    $('#ci_grade_informantsValidity_rem').val(data[0][0][0].informants_validity_remarks).attr('disabled', true);
                    $('#ci_grade_encodingAccu_rem').val(data[0][0][0].encoding_accuracy_remarks).attr('disabled', true);
                    $('#ci_grade_selfie_rem').val(data[0][0][0].selfie_uniform_id_remarks).attr('disabled', true);
                    $('#ci_grade_tatCompliance_rem').val(data[0][0][0].tat_compliance_remarks).attr('disabled', true);
                    $('#ci_grade_attachedDocs_rem').val(data[0][0][0].attached_documents_remarks).attr('disabled', true);
                    $('#ci_grade_total').val(data[0][0][0].total_score + '%');

                    $('#account_messenger_id').val(data[0][0][0].messenger_endorse_id).attr('disabled', true);
                    $('#ci_account_oims_id').val(data[0][0][0].oims_endorse_id).attr('disabled', true);
                    $('#account_bank_name').val(data[0][0][0].bank_name).attr('disabled', true);
                    $('#account_date_endorse').val(data[0][0][0].endorse_date).attr('disabled', true);
                    $('#account_name').val(data[0][0][0].account_name).attr('disabled', true);
                    $('#ci_date_visited').val(data[0][0][0].date_visited).attr('disabled', true);
                    $('#account_tor').val(data[0][0][0].account_tor).attr('disabled', true);
                    $('#accnt_handling_type').val(data[0][0][0].handling_type).attr('disabled', true);
                    $('#accnt_source').val(data[0][0][0].account_source).attr('disabled', true);
                    $('#ci_account_summary').val(data[0][0][0].report_summary).attr('disabled', true);
                    $('#cause_of_delay_rem').val(data[0][0][0].cause_of_delay).attr('disabled', true);
                    $('#ci_messenger_account').attr('disabled', true);


                    $('#dwn_attachment_ci_endorse_ccsf').attr('href', data[0][0][0].oims_endorse_id);
                    $('#editTab6').attr('disabled', false);
                    $('#btn_save_cssf').attr('href', btoa(log_id));
                    $('#submitCiReportChecking').attr('href', btoa(log_id));
                    $('#submitCiReportChecking').attr('check', checkType);
                    $('#btn_save_cssf').attr('check', checkType);


                    if(data[0][1].length > 0)
                    {
                        var ciRepctr = 0;
                        var tableHeadciRep = '<div class="col-md-12">\n' +
                            '<center><label>Attached File/s</label></center>\n' +
                            '<div class="row">\n' +
                            '<table class="table-condensed table-hover" width="100%">';
                        var tableDatasciRep = '';
                        var tableFooterCiRep = '</table></div></div>';
                        // $('#viewAttachmentCssf').attr('href', '/view_report_form/' + btoa(data[0][0][0].file_path));
                        $('#viewAttachmentCssf').show();
                        $('#viewAttachmentCssf').unbind();
                        $('#viewAttachmentCssf').click(function()
                        {
                            $('#thisisUploadedCIRep').toggle();
                            if($('#thisisUploaderCIRep').is(':visible'))
                            {
                                $('#thisisUploaderCIRep').hide();
                                $('#thisisUploadedCIRep').show();
                                $('#tab_6_upload_label_cancel').hide();
                                $('#tab_6_upload_label').show();
                            }
                        });
                        $('#submitCiReportChecking').attr('name', 'with');

                        for(ciRepctr = 0; ciRepctr < data[0][1].length; ciRepctr++)
                        {
                            var splitterStrciRep = [];
                            var array_ciRep = [];

                            splitterStrciRep = data[0][1][ciRepctr].split('.');
                            array_ciRep[ciRepctr] = splitterStrciRep.pop();

                            if(array_ciRep[ciRepctr] == 'pdf')
                            {
                                tableHeadciRep += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-ci-rep/' +btoa(data[0][0][0].log_id) +'/'+ btoa(data[0][1][ciRepctr]) + '" target="_blank" title="Click to view preview"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-ci-rep/' +btoa(data[0][0][0].log_id) +'/'+ btoa(data[0][1][ciRepctr]) +'" target="_blank">'+data[0][1][ciRepctr]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else if(array_ciRep[ciRepctr] == 'jpg' || array_ciRep[ciRepctr] == 'JPG' || array_ciRep[ciRepctr] == 'png' || array_ciRep[ciRepctr] == 'PNG')
                            {
                                tableHeadciRep += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-ci-rep/'+btoa(data[0][0][0].log_id)+'/'+btoa(data[0][1][ciRepctr])+'" target="_blank" title="Click to enlarge image"><img src="audit-view-attached-ci-rep/'+btoa(data[0][0][0].log_id)+'/'+btoa(data[0][1][ciRepctr])+'" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-ci-rep/'+btoa(data[0][0][0].log_id)+'/'+btoa(data[0][1][ciRepctr])+'" target="_blank">'+data[0][1][ciRepctr]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else
                            {
                                tableHeadciRep += '<tr>\n' +
                                    '<td>\n' +
                                    '<a title="No Preview available" style="cursor: pointer;"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    ''+data[0][1][ciRepctr]+'\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                        }
                        // console.log(tableHeadciRep + tableDatasciRep + tableFooterCiRep);

                        $('#uploaded_holder_ci_rep').html(tableHeadciRep + tableDatasciRep + tableFooterCiRep);
                    }
                    else
                    {
                        $('#viewAttachmentCssf').hide();
                        $('#submitCiReportChecking').attr('name', 'without');
                    }
                    $('#thisisUploadedCIRep').hide();
                    $('#thisisUploaderCIRep').hide();
                    $('#tab_6_upload_label_cancel').hide();
                    $('#tab_6_upload_label').show();
                }
                else if(type == 'audit_report_form' || type == 'audit_discrepancy_form')
                {
                    console.log(data);
                    var array_test = [];

                    var name = data[0][0][0].emp_name;

                    var fullname = name.split(", ");

                    var lname = capitalize_Words(fullname[0]);
                    var fname = capitalize_Words(fullname[1]);

                    // $('.date_change').attr('type', 'date');
                    $('#autoComId').val(data[0][0][0].user_id).attr('disabled', true);
                    $('#client_name').val(data[0][0][0].client_name).attr('disabled', true);
                    $('#full_name_company').val(data[0][0][0].company_name).attr('disabled', true);
                    $('#type_of_request').val(data[0][0][0].type_of_request).attr('disabled', true);
                    $('#endorsement_date').val(data[0][0][0].endorsement_date).attr('disabled', true);
                    $('#submission_date').val(data[0][0][0].submission_date).attr('disabled', true);
                    $('#internal_tat').val(data[0][0][0].internal_tat).attr('disabled', true);
                    $('#external_tat').val(data[0][0][0].external_tat).attr('disabled', true);
                    $('#special_instruction').val(data[0][0][0].special_instruction).attr('disabled', true);
                    $('#type_of_checking').val(data[0][0][0].type_of_checking).attr('disabled', true);
                    $('#last_name_arf').val(lname).attr('disabled', true);
                    $('#f_name_arf').val(fname).attr('disabled', true);
                    $('#emp_id_arf').val(data[0][0][0].emp_id).attr('disabled', true);
                    $('#dept_arf').val(data[0][0][0].emp_dept).attr('disabled', true);
                    $('#job_title_arf').val(data[0][0][0].emp_job).attr('disabled', true);
                    $('#date_hired_arf').val(data[0][0][0].emp_date_hired).attr('disabled', true);
                    $('#findings_arf').val(data[0][0][0].findings).attr('disabled', true);
                    $('#investigation_arf').val(data[0][0][0].investigation).attr('disabled', true);
                    $('#valid_res_arf').val(data[0][0][0].valid_res).attr('disabled', true);
                    $('#statements_arf').val(data[0][0][0].statements).attr('disabled', true);
                    $('#obs_arf').val(data[0][0][0].observations).attr('disabled', true);
                    $('#recom_arf').val(data[0][0][0].recom).attr('disabled', true);
                    $('#business_name').val(data[0][0][0].busi_name).attr('disabled', true);
                    $('#full_address').val(data[0][0][0].busi_address).attr('disabled', true);
                    $('#audit_report_form_messenger').attr('disabled', true);


                    $('#dlAttachmentCiReport').attr('href', data[0][0][0].user_id);
                    $('#btn_edit_arf_details').attr('disabled', false);
                    $('#audit_report_form_messenger').attr('disabled', true);
                    $('#btn_save_arf').attr('href', btoa(log_id));
                    $('#show_uploader_discrep').attr('log', log_id);
                    $('#btn_send_arf').attr('check', checkType);
                    $('#btn_save_arf').attr('check', checkType);


                    // if(data[0][1].length > 0)
                    // {
                    //     // $('#thisisUploadedDiscrep').show();
                    //     // $('#viewAttachSavedArf').attr('href', '/view_report_form/' + btoa(data[0][0].file_path));
                    //     $('#viewAttachSavedArf').show();
                    //     $('#viewAttachSavedArf').unbind();
                    //     $('#viewAttachSavedArf').click(function()
                    //     {
                    //         $('#thisisUploadedDiscrep').toggle();
                    //         if($('#thisisUploaderDiscrep').is(':visible'))
                    //         {
                    //             $('#thisisUploaderDiscrep').hide();
                    //             $('#hide_uploader_discrep').hide();
                    //             $('#show_uploader_discrep').show();
                    //             $(this).show();
                    //         }
                    //     });
                    //     $('#btn_send_arf').attr('name', 'with');
                    // }
                    // else
                    // {
                    //     $('#viewAttachSavedArf').hide();
                    //     $('#btn_send_arf').attr('name', 'without');
                    // }

                    var tableHead = '<div class="col-md-12">\n' +
                        '<center><label>Attached File/s</label></center>\n' +
                        '<div class="row">\n' +
                        '<table class="table-condensed table-hover" width="100%">';
                    var tableDatas = '';
                    var tableFooter = '</table></div></div>';

                    if(data[0][1].length > 0)
                    {
                        $('#viewAttachSavedArf').show();
                        $('#viewAttachSavedArf').unbind();
                        $('#viewAttachSavedArf').click(function()
                        {
                            $('#thisisUploadedDiscrep').toggle();
                            if($('#thisisUploaderDiscrep').is(':visible'))
                            {
                                $('#thisisUploaderDiscrep').hide(); // tr container
                                $('#hide_uploader_discrep').hide(); // close uploader button
                                $('#show_uploader_discrep').show(); // div holder for attachments
                                $(this).show();
                            }
                        });
                        $('#btn_send_arf').attr('name', 'with');

                        for(var loopir = 0; loopir < data[0][1].length; loopir++)
                        {
                            var splitterStr = [];

                            splitterStr = data[0][1][loopir].split('.');
                            array_test[loopir] = splitterStr.pop();

                            if(array_test[loopir] == 'pdf')
                            {
                                tableDatas += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][1][loopir])+'" target="_blank" title="Click to view preview"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][1][loopir])+'" target="_blank">'+data[0][1][loopir]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else if(array_test[loopir] == 'jpg' || array_test[loopir] == 'JPG' || array_test[loopir] == 'png' || array_test[loopir] == 'PNG')
                            {
                                tableDatas += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][1][loopir])+'" target="_blank" title="Click to enlarge image"><img src="audit-view-attached/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][1][loopir])+'" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][1][loopir])+'" target="_blank">'+data[0][1][loopir]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else
                            {
                                tableDatas += '<tr>\n' +
                                    '<td>\n' +
                                    '<a title="No Preview available" style="cursor: pointer;"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    ''+data[0][1][loopir]+'\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                        }
                        $('#uploaded_holder').html(tableHead + tableDatas + tableFooter);
                    }
                    else
                    {
                        $('#viewAttachSavedArf').hide();
                        $('#btn_send_arf').attr('name', 'without');
                    }
                }
                else if(type == 'audit_field_checking' || type == 'audit_phone_checking')
                {
                    console.log(data);
                    var name2 = data[0][0][0].emp_name;

                    var fullname2 = name2.split(", ");

                    var lname2 = capitalize_Words(fullname2[0]);
                    var fname2 = capitalize_Words(fullname2[1]);

                    $('#oimsIdPhoneField').val(data[0][0][0].oims_id).attr('disabled', true).attr('disabled', true);
                    $('#fieldPhoneComNameSubj').val(data[0][0][0].subj_name).attr('disabled', true);
                    $('#busName_ph_field').val(data[0][0][0].busi_name).attr('disabled', true);
                    $('#address_phone_field').val(data[0][0][0].subj_bus_name).attr('disabled', true);
                    $('#log_time_ph_field').val(data[0][0][0].audit_logged).attr('disabled', true);
                    $('#name_auditor_phone_field').val(data[0][0][0].auditor_name).attr('disabled', true);
                    $('#remCompliance').val(data[0][0][0].findings).attr('disabled', true);
                    $('#doneThruPhoneField').val(data[0][0][0].done_thru).attr('disabled', true);
                    $('#client_name_phone_field').val(data[0][0][0].client_name).attr('disabled', true);
                    $('#tor_field_phone').val(data[0][0][0].type_of_request).attr('disabled', true);
                    $('#date_endorsed_phone_field').val(data[0][0][0].endorsement_date).attr('disabled', true);
                    $('#ci_visit_ph_field').val(data[0][0][0].ci_date_visit).attr('disabled', true);
                    $('#spec_ins_phone_field').val(data[0][0][0].spec_ins).attr('disabled', true);
                    $('#toc_phone_field').val(data[0][0][0].type_of_checking).attr('disabled', true);
                    $('#emp_last_name').val(lname2).attr('disabled', true);
                    $('#emp_first_name').val(fname2).attr('disabled', true);
                    $('#emp_id').val(data[0][0][0].emp_id).attr('disabled', true);
                    $('#emp_dept_ph_field').val(data[0][0][0].emp_dept).attr('disabled', true);
                    $('#title_job_phone_field').val(data[0][0][0].emp_job).attr('disabled', true);
                    $('#date_hired_ph_field').val(data[0][0][0].emp_date_hired).attr('disabled', true);
                    $('#summarty_report_field_phone').val(data[0][0][0].summary_report).attr('disabled', true);
                    $('.ans_compliance').attr('disabled', true);
                    $('.informant_clear').attr('disabled', true);
                    $('.informant_clear_select').attr('disabled', true);
                    $('#removeValandDis').attr('disabled', true);

                    var countAns = 0;

                    if(data[0][1].length > 0)
                    {
                        $('.ans_compliance').each(function()
                        {
                            $(this).val(data[0][1][countAns].compliance_ans);
                            countAns++
                        });
                    }


                    var i = 0;
                    var j = 0;

                    for(i = 0; i < data[0][2].length; i++)
                    {
                        $('#informant_name_' +i+'').val(data[0][2][i].informant_name);
                        $('#relation_' +i+'').val(data[0][2][i].relation_subject);
                        $('#address_'+i+'').val(data[0][2][i].informant_address);
                        $('#existence_'+i+'').val(data[0][2][i].informant_existance);
                        $('#remarks_'+i+'').val(data[0][2][i].informant_remarks);
                    }
                    for(j = 0; j < data[0][3].length; j++)
                    {
                        $('#new_inf_name_'+j+'').val(data[0][3][j].informants_name);
                        $('#new_relation_'+j+'').val(data[0][3][j].relation_subject);
                        $('#new_add_'+j+'').val(data[0][3][j].address);
                        $('#new_rem_'+j+'').val(data[0][3][j].remarks);
                    }

                    $('#btn_download_ci_rep_pf').attr('href', data[0][0][0].oims_id);
                    $('#btn_edit_phone_field').attr('disabled', false);
                    $('#btn_save_phone_field').attr('href', btoa(log_id));
                    $('#clickToFilePf').attr('log', log_id);
                    $('#btn_submit_phone_field').attr('href', btoa(log_id));
                    $('#btn_submit_phone_field').attr('check', checkType);
                    $('#btn_save_phone_field').attr('check', checkType);

                    if(data[0][4].length > 0)
                    {

                        $('#viewAttachmentPhoneField').unbind();
                        $('#viewAttachmentPhoneField').click(function()
                        {
                            $('#FieldUploadedAttachments').toggle();

                            if($('#FieldUploader').is(':visible'))
                            {
                                $('#FieldUploader').hide();
                                $('#clickToFilePf-cancel').hide();
                                $('#clickToFilePf').show();
                            }
                        });
                        var tableHeadField = '<div class="col-md-12">\n' +
                            '<center><label>Attached File/s</label></center>\n' +
                            '<div class="row">\n' +
                            '<table class="table-condensed table-hover" width="100%">';
                        var tableDatasField = '';
                        var tableFooterField = '</table></div></div>';

                        var array_field = [];
                        for(var fieldCtr = 0; fieldCtr < data[0][4].length; fieldCtr++)
                        {
                            var splitterStrField = [];

                            splitterStrField = data[0][4][fieldCtr].split('.');
                            array_field[fieldCtr] = splitterStrField.pop();

                            if(array_field[fieldCtr] == 'pdf')
                            {
                                tableDatasField += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-field/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][4][fieldCtr])+'" target="_blank" title="Click to view preview"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-field/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][4][fieldCtr])+'" target="_blank">'+data[0][4][fieldCtr]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else if(array_field[fieldCtr] == 'jpg' || array_field[fieldCtr] == 'JPG' || array_field[fieldCtr] == 'png' || array_field[fieldCtr] == 'PNG')
                            {
                                tableDatasField += '<tr>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-field/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][4][fieldCtr])+'" target="_blank" title="Click to enlarge image"><img src="audit-view-attached-field/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][4][fieldCtr])+'" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    '<a href="audit-view-attached-field/'+btoa(data[0][0][0].audit_log_id)+'/'+btoa(data[0][4][fieldCtr])+'" target="_blank">'+data[0][4][fieldCtr]+'</a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                            else
                            {
                                tableDatasField += '<tr>\n' +
                                    '<td>\n' +
                                    '<a title="No Preview available" style="cursor: pointer;"><img src="fine-uploader/placeholders/not_available-generic.png" alt="" width="150" height="150"></a>\n' +
                                    '</td>\n' +
                                    '<td>\n' +
                                    ''+data[0][4][fieldCtr]+'\n' +
                                    '</td>\n' +
                                    '</tr>';
                            }
                        }

                        $("#fieldUploadedHolder").html(tableHeadField + tableDatasField + tableFooterField);

                        // $('#viewAttachmentPhoneField').attr('href', '/view_report_form/' + btoa(data[0][0][0].file_path));
                        $('#viewAttachmentPhoneField').show();
                        $('#btn_submit_phone_field').attr('name', 'with');
                    }
                    else
                    {
                        $('#viewAttachmentPhoneField').hide();
                        $('#btn_submit_phone_field').attr('name', 'without');
                    }

                }
            }
        });
    }
});

function capitalize_Words(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}




$('#ci_account_oims_id').on('keyup change focusout', function(e)
{
    if($(this).is(':focus'))
    {
        if(e.keyCode == 13 || e.keyCode == 8)
        {
            searchtab6($(this).val());
        }
    }
});

$('#ci_account_oims_id').autocomplete
({
    source: 'audit_tab6_autocomplete',
    minLength: 1,
    select: function(event, ui)
    {
        $('#ci_account_oims_id').val(ui.item.id);


        var clearTime = setInterval(function(){
            clearInterval(clearTime);
        },10)
        searchtab6(ui.item.id);

        return false;
    }
});

var loaded_table_tab1 = false;
var loaded_table_tab2 = false;
var loaded_table_tab6 = false;

$('.audit_all_form_class').click(function()
{
    $('.audits_log_table').html('');
    var thiss = $(this);
    var gethref = thiss.attr('href');
    console.log(loaded_table_tab1);
    console.log(gethref);

    if(gethref == '#tab_form1')
    {
        if(loaded_table_tab1 == false)
        {
            what_logs = 'audit_report_form';
            getLogsFunction(what_logs);
            loaded_table_tab1 = true;
        }
        else if(gethref == '#tab_form1')
        {
            console.log('do nothing');
            if($('#optionAudit').is(':checked'))
            {
                what_logs = 'audit_report_form';
                getLogsFunction(what_logs);
            }
            else if($('#optionDesc').is(':checked'))
            {
                what_logs = 'audit_discrepancy_form';
                getLogsFunction(what_logs);
            }
        }
        else if(loaded_table_tab1)
        {
            if($('#optionAudit').is(':checked'))
            {
                what_logs = 'audit_report_form';
                getLogsFunction(what_logs);
            }
            else if($('#optionDesc').is(':checked'))
            {
                what_logs = 'audit_discrepancy_form';
                getLogsFunction(what_logs);
            }
            loaded_table_tab1 = false;
        }
    }
    else if(gethref == '#tab_form2')
    {
        if(loaded_table_tab2 == false)
        {
            what_logs = 'audit_field_checking';
            getLogsFunction(what_logs);
            loaded_table_tab2 = true;
        }
        else if(gethref == '#tab_form2')
        {
            console.log('do nothing');
            if($('#optionField').is(':checked'))
            {
                what_logs = 'audit_field_checking';
                getLogsFunction(what_logs);
            }
            else if($('#optionPhone').is(':checked'))
            {
                what_logs = 'audit_phone_checking';
                getLogsFunction(what_logs);
            }
        }
        else if(loaded_table_tab2)
        {
            if($('#optionField').is(':checked'))
            {
                what_logs = 'audit_field_checking';
                getLogsFunction(what_logs);
            }
            else if($('#optionPhone').is(':checked'))
            {
                what_logs = 'audit_phone_checking';
                getLogsFunction(what_logs);
            }
            loaded_table_tab2 = false;
        }
    }
    else if(gethref == '#tab_form6')
    {
        if(loaded_table_tab6 == false)
        {
            what_logs = 'ci_report_checking';
            getLogsFunction(what_logs);
            // loaded_table_tab6 = true;
        }
        else if(loaded_table_tab6)
        {
            console.log('do nothing');
        }
    }
});

$('#clearFieldsTab6').click(function()
{
    ClearallFieldsTab6();
    enabledAllFieldTab6();
    $('#dwn_attachment_ci_endorse_ccsf').removeAttr('href');
    $('#btn_save_cssf').removeAttr('href');
    $('#submitCiReportChecking').removeAttr('href');
    $('#submitCiReportChecking').attr('name', 'without');
    $('#viewAttachmentCssf').removeAttr('href');
    $('#viewAttachmentCssf').hide();

});

$('#editTab6').click(function()
{
    enabledAllFieldTab6();
});

$('#btn_edit_arf_details').click(function()
{
    clearAuditFormAttr();
    $('#audit_report_form_messenger').attr('disabled', false);
});

$('#btn_edit_phone_field').click(function()
{
    clearfieldsOnlyFalseDin();
    $('#removeValandDis').attr('disabled', false);
});

$('#dwn_attachment_ci_endorse_ccsf').click(function()
{
    if($(this).attr('href') != null)
    {
        console.log('yes');

        var id_encode = btoa($(this).attr('href'));
        var q = '<form action="/audit-download-ci-report-arf" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download_cssf">'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#dwnCssf').html(q);
        $('#button_form_download_cssf').click();
    }
    else
    {
        alert('Please select OIMS ID to download');
    }
});


function audit_report_mon_table()
{
    $('#table_audit_rep thead th').each(function ()
    {
        title_header4[i4] = $(this).text();
        i4++;
        var title = $(this).text();
        // $(this).css('color', 'gray');
        $(this).css('background-color', 'gray');
        $(this).html(title);
    });

    tableAuditRepMoni = $('#table_audit_rep').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header4[(idx)];
                    }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header4[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header4[(idx)];
                                    }
                                }
                        }
                }
            ],
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax": "audit-report-monitoring-table",
        "columns":
            [
                // {data: 'audit_id', name: 'audits_log.log_id'},
                {
                    data : function auditId(data)
                    {
                        return '<button style="text-decoration: underline; background:none ; border:none;" id = "btn_show_log" name = "'+data.activ+'" href = "'+data.audit_id+'">'+data.audit_id+'</button>'
                    },
                    name :  'audits_log.log_id'
                },
                {data: 'user', name: 'users.name'},
                {data: 'date', name: 'audits_log.created_at'},
                {
                    data : function mod(data)
                    {
                        if(data.mod != '0000-00-00 00:00:00')
                        {
                            return data.mod;
                        }
                        else
                        {
                            return '-';
                        }

                    },
                    name : 'audits_log.last_modified_date_time'
                },
                {data : 'activ', name : 'audits_log.activity'},
                {data : 'branch', name : 'provinces.name'},
                {data : 'employee', name : 'emp_1.emp_name'},
                {data : 'employee', name : 'emp_2.emp_name', visible: false},
                {data : 'employee', name : 'emp_3.emp_name', visible: false},
                {data : 'employee', name : 'emp_4.emp_name', visible: false},
                {data : 'employee', name : 'emp_5.emp_name', visible: false},
                {data: 'status', name: 'audits_log.reviewer_id'},
                {
                    data : function escStat(data)
                    {

                        return 'Escalation Stat'
                    },
                    name : 'audits_log.log_id'
                }
            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.a_status == 1)
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', 'white');
            }
            else if(aData.a_status == 2)
            {
                $(nRow).css('background-color', '#ffb3b3');
                // $(nRow).css('color', 'white');
            }
        },
        "pageLength": 10,
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

    $('#table_audit_rep_filter input').unbind();
    $('#table_audit_rep_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAuditRepMoni.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAuditRepMoni.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table_audit_rep').on('click', '#btn_show_log', function()
{
    console.log($(this).attr('name') + ', ' + $(this).attr('href'));

    $('#modal-show-all-log').modal('show');

    showAllLogs( $(this).attr('href'), $(this).attr('name'));

    $('#approveAudit').attr('href', btoa($(this).attr('href')));
    $('#returnAudit').attr('href', btoa($(this).attr('href')));
});


function showAllLogs(id, type)
{
    $.ajax
    ({
        type: 'get',
        url: 'audit-get-all-audit-log-info',
        data:
            {
                'id': id,
                'type': type
            },
        success: function (data)
        {
            console.log(data);

            var empName;
            if(type == 'Saved Audit Report' || type == 'Saved Discrepancy Report')
            {
                $('#showAuditDescForm').show();
                $('#showPhoneFieldForm').hide();
                $('#showCssForm').hide();

                empName = data[0][0].emp_name;

                var newName = empName.split(', ');

                var lname = capitalize_Words(newName[0]);
                var fname = capitalize_Words(newName[1]);

                $('#showEndoIdf').text(data[0][0].user_id);
                $('#showClientArf').text(data[0][0].client_name);
                $('#showSubjNameArf').text(data[0][0].company_name);
                $('#showTORArf').text(data[0][0].type_of_request);
                $('#showBusnameArf').text(data[0][0].busi_name);
                $('#showEndoDateArf').text(data[0][0].endorsement_date);
                $('#showAddArf').text(data[0][0].busi_address);
                $('#showSubArf').text(data[0][0].submission_date);
                $('#showSpecInsArf').text(data[0][0].special_instruction);
                $('#showInternalTatArf').text(data[0][0].internal_tat);
                $('#showToCArf').text(data[0][0].type_of_checking);
                $('#showExtTatArf').text(data[0][0].external_tat);
                $('#showempIDArf').text( data[0][0].emp_id);
                $('#showDateHiredArf').text(data[0][0].emp_date_hired);
                $('#showEmpNameArf').text(lname +  ', ' + fname);
                $('#showDeptArf').text(data[0][0].emp_dept);
                $('#showJobTitleArf').text(data[0][0].emp_job);
                $('#showFindingsArf').text(data[0][0].findings);
                $('#showInvestArf').text(data[0][0].investigation);
                $('#showValidResArf').text(data[0][0].valid_res);
                $('#showStatementsArf').text(data[0][0].statements);
                $('#showObserveArf').text(data[0][0].observations);
                $('#showRecomArf').text(data[0][0].recom);

                $('#showPdfPrintLogs').attr('href', '/view_report_form/' + btoa('audit_arf_files')+ '/' + btoa(data[0][0].audit_log_id));
            }
            else if(type == 'Saved Audit Field Checking' || type == 'Saved Audit Phone Checking')
            {
                $('#showAuditDescForm').hide();
                $('#showPhoneFieldForm').show();
                $('#showCssForm').hide();

                empName = data[0][0][0].emp_name;

                var newName2 = empName.split(', ');

                var lname2 = capitalize_Words(newName2[0]);
                var fname2 = capitalize_Words(newName2[1]);


                $('#showEndoPf').text(data[0][0][0].oims_id);
                $('#showAuditorPf').text(data[0][0][0].auditor_name);
                $('#showSubjPf').text(data[0][0][0].subj_name);
                $('#showClientNamePf').text(data[0][0][0].client_name);
                $('#showBusinamePf').text(data[0][0][0].busi_name);
                $('#showTorPf').text(data[0][0][0].type_of_request);
                $('#showAddressPf').text(data[0][0][0].subj_bus_name);
                $('#showEndoDatePf').text(data[0][0][0].endorsement_date);
                $('#showTOCpF').text(data[0][0][0].type_of_checking);
                $('#showDateVisitPf').text(data[0][0][0].ci_date_visit);
                $('#showFindingsPf').text(data[0][0][0].findings);
                $('#showDoneThruPf').text(data[0][0][0].done_thru);
                $('#showSpecialPf').text(data[0][0][0].spec_ins);
                $('#showempIDAPf').text(data[0][0][0].emp_id);
                $('#showDateHiredPf').text(data[0][0][0].emp_date_hired);
                $('#showEmpNamePf').text(lname2 +  ', ' + fname2);
                $('#showDeptPf').text(data[0][0][0].emp_dept);
                $('#showJobTitlePF').text(data[0][0][0].emp_job);
                $('#summary_rep_pf').text(data[0][0][0].summary_report);

                var countAns = 0;

                $('.ans_comp').each(function()
                {
                    $(this).text(data[0][1][countAns].compliance_ans);
                    countAns++
                });

                var i = 0;
                var j = 0;


                for(i = 0; i < data[0][2].length; i++)
                {
                    var inf;
                    var rel;
                    var add;
                    var exist;
                    var rem;

                    if (data[0][2][i].informant_name != '')
                    {
                        inf = data[0][2][i].informant_name;
                    }
                    else {
                        inf = 'None';
                    }

                    if (data[0][2][i].relation_subject != '')
                    {
                        rel = data[0][2][i].relation_subject;
                    }
                    else
                    {
                        rel = 'None';
                    }

                    if (data[0][2][i].informant_address != '')
                    {
                        add = data[0][2][i].informant_address;
                    }
                    else
                    {
                        add = 'None';
                    }

                    if(data[0][2][i].informant_existance != '---')
                    {
                        exist = data[0][2][i].informant_existance;
                    }
                    else
                    {
                        exist = 'None'
                    }

                    if(data[0][2][i].informant_remarks != '')
                    {
                        rem = data[0][2][i].informant_remarks;
                    }
                    else
                    {
                        rem = 'None';
                    }

                    $('#inf_name_' + i + '').html(inf);
                    $('#relationship_view_' + i + '').html(rel);
                    $('#address_view_' + i + '').html(add);
                    $('#exist_view_' + i + '').html(exist);
                    $('#rem_view_' + i + '').html(rem);


                }
                for(j = 0; j < data[0][3].length; j++)
                {
                    var newInf;
                    var newRel;
                    var newAdd;
                    var newRem;

                    if(data[0][3][j].informants_name != '')
                    {
                        newInf = data[0][3][j].informants_name;
                    }
                    else
                    {
                        newInf = 'None'
                    }

                    if(data[0][3][j].relation_subject != '')
                    {
                        newRel = data[0][3][j].relation_subject;
                    }
                    else
                    {
                        newRel = 'None';
                    }

                    if(data[0][3][j].address != '')
                    {
                        newAdd = data[0][3][j].address;
                    }
                    else
                    {
                        newAdd = 'None';
                    }

                    if(data[0][3][j].remarks != '')
                    {
                        newRem = data[0][3][j].remarks;
                    }
                    else
                    {
                        newRem = 'None';
                    }

                    $('#new_info_name_view_'+j+'').html(newInf);
                    $('#new_relationship_'+j+'').html(newRel);
                    $('#new_address_view_'+j+'').html(newAdd);
                    $('#new_remarks_view_'+j+'').html(newRem);
                }

                $('#showPdfPrintLogs').attr('href', '/view_report_form/'+btoa('audit_field_files') + '/' + btoa(data[0][0][0].audit_log_id));

            }
            else if(type == 'Saved CI Report Checking')
            {
                $('#showAuditDescForm').hide();
                $('#showPhoneFieldForm').hide();
                $('#showCssForm').show();

                empName = data[0][0].emp_name;

                var newName3 = empName.split(', ');

                var lname3 = capitalize_Words(newName3[0]);
                var fname3 = capitalize_Words(newName3[1]);

                $('#showIDcssf').text(data[0][0].oims_endorse_id);
                $('#showBankcssf').text(data[0][0].bank_name);
                $('#showAcctNamecssf').text(data[0][0].account_name);
                $('#showEndorseDateCssf').text(data[0][0].endorse_date);
                $('#showGrade1').text(data[0][0].completeness + '%');
                $('#showGradeRemarks1').text(data[0][0].completeness_remarks);
                $('#showGrade2').text(data[0][0].gps_attachment + '%');
                $('#showGradeRemarks2').text(data[0][0].gps_attachment_remarks);
                $('#showGrade3').text(data[0][0].informants_validity + '%');
                $('#showGradeRemarks3').text(data[0][0].informants_validity_remarks);
                $('#showGrade4').text(data[0][0].encoding_accuracy + '%');
                $('#showGradeRemarks4').text(data[0][0].encoding_accuracy_remarks);
                $('#showGrade5').text(data[0][0].selfie_uniform_id + '%');
                $('#showGradeRemarks5').text(data[0][0].selfie_uniform_id_remarks);
                $('#showGrade6').text(data[0][0].tat_compliance + '%');
                $('#showGradeRemarks6').text(data[0][0].tat_compliance_remarks);
                $('#showGrade7').text(data[0][0].attached_documents + '%');
                $('#showGradeRemarks7').text(data[0][0].attached_documents_remarks);
                $('#showTotalGrade').text(data[0][0].total_score + '%');
                $('#showEmpIDCssf').text(data[0][0].emp_id);
                $('#showEmpHiredDateCssf').text(data[0][0].emp_date_hired);
                $('#showEmpNameCssf').text(lname3 +  ', ' + fname3);
                $('#showAreaCssf').text(data[0][0].ci_area);
                $('#showRegBranchCssf').text(data[0][0].ci_regional_head);
                $('#showBranchCssf').text(data[0][0].ci_branch_head);
                $('#showSaoCssf').text(data[0][0].ci_senior_account_officer);
                $('#showCiSupCssf').text(data[0][0].ci_supervisor);
                $('#showSummaryCssf').text(data[0][0].report_summary);
                $('#showCoDCssf').text(data[0][0].cause_of_delay);
                $('#showEmpJobCssf').text(data[0][0].emp_job);

                $('#showPdfPrintLogs').attr('href', '/view_report_form/' + btoa('audit_ci_report_checking') + '/' + data[0][0].log_id);
            }

            if(data[1][0].audit_status == 0)
            {
                $('#showToConfirm').show();
                $('#showAlready').hide();
            }
            else if(data[1][0].audit_status != 0)
            {
                $('#showToConfirm').hide();
                $('#showAlready').show();
            }


        }
    });
}

$('.toggleOnOff').click(function()
{
    var num = $(this).attr('name');

    if($(this).html() == '<i style="color :green" class="fa fa-fw fa-chevron-circle-down"></i>')
    {
        $(this).html('<i style = "color :green" class = "fa fa-fw fa-chevron-circle-up"></i>');
    }
    else if($(this).html() == '<i style="color :green" class="fa fa-fw fa-chevron-circle-up"></i>')
    {
        $(this).html('<i style="color :green" class="fa fa-fw fa-chevron-circle-down"></i>');
    }

    $('#showInformant-' +num+ '').toggle(300);
});

$('#approveAudit').click(function()
{
    var id = atob($(this).attr('href'));



    if(confirm('Are you sure to approve?'))
    {
        $.ajax
        ({
            type : 'get',
            url : 'audit-approve-return-log',
            data :
                {
                    'id' : id,
                    'stat' : 'approve'
                },
            success : function()
            {
                alert('Successfully Approved Log!');
                $('#modal-show-all-log').modal('hide');
                tableAuditRepMoni.ajax.reload(null, false);
                submitCounter = false;
            }
        });
    }
    else
    {

    }

});

$('#returnAudit').click(function()
{
    var id = atob($(this).attr('href'));

    $('#audit_remarks_log').val('');
    $('#audit_remarks_log').attr('disabled', false);

    $('#return_now_log_au').show();
    $('#show_date_return').val('');

    $('#showRemRetAudit').hide();

    $('#modal-audit-return-logs').modal('show');
    $('#return_now_log_au').attr('href', btoa(id));

});

$('#return_now_log_au').click(function()
{

    if($('#audit_remarks_log').val() != '')
    {
        var id = atob($(this).attr('href'));

        $.ajax
        ({
            type : 'get',
            url : 'audit-approve-return-log',
            data :
                {
                    'id' : id,
                    'stat' : 'return',
                    'rem' : $('#audit_remarks_log').val()
                },
            success : function()
            {
                alert('Audit log returned!');
                $('#modal-show-all-log').modal('hide');
                $('#modal-audit-return-logs').modal('hide');
                tableAuditRepMoni.ajax.reload(null, false);
                submitCounter = true;
            }
        });
    }
    else
    {
        alert('Please insert remarks.');
    }

});

function auditGeneralLogs()
{
    $('#general_audit_logs_table thead th').each(function () {
        general_audit_logs_table_title[general_audit_logs_table_counts] = $(this).text();
        $(this).css('background-color', 'gray');
        general_audit_logs_table_counts++;
        var title = $(this).text();
        $(this).html(title)
    });

    general_audit_logs_table = $('#general_audit_logs_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'audit_general_logs_table',
        "columns":
            [
                {data: 'id', name: 'audits_log.log_id'},
                {data: 'date_time', name: 'audits_log.created_at'},
                {data: 'activity', name: 'audits_log.activity'},
                {data : 'employee', name : 'emp_1.emp_name'},
                {data : 'employee', name : 'emp_2.emp_name', visible : false},
                {data : 'employee', name : 'emp_3.emp_name', visible : false},
                {data : 'employee', name : 'emp_4.emp_name', visible : false},
                {data : 'employee', name : 'emp_5.emp_name', visible : false},
                {data: 'status', name: 'audits_log.audit_status'}
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
        "fnRowCallback": function(nRow, aData)
        {
            $(nRow).attr('class','get_logs_info');
            $(nRow).css('cursor', 'pointer');
            $(nRow).attr('title', 'Click to view full info');
            $(nRow).attr('for', 'monitoring');
            $(nRow).attr('id', aData.id);

            var check = '';

            if(aData.save_type == 1)
            {
                if(aData.status2 == 1)
                {
                    check = 'approved';
                }
                else if(aData.status2 == 2)
                {
                    check = 'returned';
                }
                else if(aData.status2 == 0)
                {
                    check = 'review';
                }
            }
            else if (aData.save_type == 2)
            {
                check = "saved" ;
            }

            // console.log(check);

            if(aData.type == 'ci_report_checking')
            {
                $(nRow).attr('tab', '#tabForms6');
                $(nRow).attr('typee', 'ci_report_checking');
                $(nRow).attr('rad', 'none');
                $(nRow).attr('check', check)

            }
            else if(aData.type == 'audit_report_form')
            {
                $(nRow).attr('tab', '#tabForms1');
                $(nRow).attr('rad', '#optionAudit');
                $(nRow).attr('typee', 'audit_report_form');
                $(nRow).attr('check', check)
            }
            else if(aData.type == 'audit_discrepancy_form')
            {
                $(nRow).attr('tab', '#tabForms1');
                $(nRow).attr('rad', '#optionDesc');
                $(nRow).attr('typee', 'audit_discrepancy_form');
                $(nRow).attr('check', check)
            }
            else if(aData.type == 'audit_field_checking')
            {
                $(nRow).attr('tab', '#tabForms2');
                $(nRow).attr('rad', '#optionField');
                $(nRow).attr('typee', 'audit_field_checking');
                $(nRow).attr('check', check)
            }
            else if(aData.type == 'audit_phone_checking')
            {
                $(nRow).attr('tab', '#tabForms2');
                $(nRow).attr('rad', '#optionPhone');
                $(nRow).attr('typee', 'audit_phone_checking');
                $(nRow).attr('check', check)
            }

            if(aData.status2 == 1)
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', ' black');
            }
            else if(aData.status2 == 2)
            {
                $(nRow).css('background-color', '#ffb3b3');
                // $(nRow).css('color', 'black');
            }
        },
        initComplete : function ()
        {
            var api = this.api();

            //Apply the search
            api.column().every(function()
            {
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
    $('#general_audit_logs_table_filter input').unbind();
    $('#general_audit_logs_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                general_audit_logs_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    general_audit_logs_table.search($(this).val()).draw();
                }
            }
        }
    });
}

function auditPartialLogs()
{
    $('#partial_audit_logs_table thead th').each(function ()
    {
        partial_audit_logs_table_title[partial_audit_logs_table_counts] = $(this).text();
        $(this).css('background-color', 'gray');
        partial_audit_logs_table_counts++;
        var title = $(this).text();
        $(this).html(title)
    });

    partial_audit_logs_table = $('#partial_audit_logs_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'audit_partial_logs_table',
        "columns":
            [
                {data: 'id', name: 'audits_log.log_id'},
                {data: 'date_time', name: 'audits_log.created_at'},
                {data: 'activity', name: 'audits_log.activity'},
                {data : 'employee', name : 'emp_1.emp_name'},
                {data : 'employee', name : 'emp_2.emp_name', visible : false},
                {data : 'employee', name : 'emp_3.emp_name', visible : false},
                {data : 'employee', name : 'emp_4.emp_name', visible : false},
                {data : 'employee', name : 'emp_5.emp_name', visible : false},
                {data: 'status', name: 'audits_log.audit_status'}
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
        "fnRowCallback": function(nRow, aData)
        {
            $(nRow).attr('class','get_logs_info');
            $(nRow).css('cursor', 'pointer');
            $(nRow).attr('title', 'Click to view full info');
            $(nRow).attr('for', 'monitoring');
            $(nRow).attr('id', aData.id);

            var check;

            if(aData.save_type == 1)
            {
                if(aData.status2 == 1)
                {
                    check = 'approved';
                }
                else if(aData.status2 == 2)
                {
                    check = 'returned';
                }
                else if(aData.status2 == 0)
                {
                    check = 'review';
                }
            }
            else if (aData.save_type == 2)
            {
                check = "saved";
            }

            console.log(check);

            if(aData.type == 'ci_report_checking')
            {
                $(nRow).attr('tab', '#tabForms6');
                $(nRow).attr('typee', 'ci_report_checking');
                $(nRow).attr('rad', 'none');
                $(nRow).attr('check', check);

            }
            else if(aData.type == 'audit_report_form')
            {
                $(nRow).attr('tab', '#tabForms1');
                $(nRow).attr('rad', '#optionAudit');
                $(nRow).attr('typee', 'audit_report_form');
                $(nRow).attr('check', check);
            }
            else if(aData.type == 'audit_discrepancy_form')
            {
                $(nRow).attr('tab', '#tabForms1');
                $(nRow).attr('rad', '#optionDesc');
                $(nRow).attr('typee', 'audit_discrepancy_form');
                $(nRow).attr('check', check);
            }
            else if(aData.type == 'audit_field_checking')
            {
                $(nRow).attr('tab', '#tabForms2');
                $(nRow).attr('rad', '#optionField');
                $(nRow).attr('typee', 'audit_field_checking');
                $(nRow).attr('check', check);
            }
            else if(aData.type == 'audit_phone_checking')
            {
                $(nRow).attr('tab', '#tabForms2');
                $(nRow).attr('rad', '#optionPhone');
                $(nRow).attr('typee', 'audit_phone_checking');
                $(nRow).attr('check', check);
            }

            // if(aData.status2 == 1)
            // {
            //     $(nRow).css('background-color', '#b3ffb3');
            //     // $(nRow).css('color', ' black');
            // }
            // else if(aData.status2 == 2)
            // {
            //     $(nRow).css('background-color', '#ffb3b3');
            //     // $(nRow).css('color', 'black');
            // }
        },
        initComplete : function ()
        {
            var api = this.api();

            //Apply the search
            api.column().every(function()
            {
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
    $('#partial_audit_logs_table_filter input').unbind();
    $('#partial_audit_logs_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                partial_audit_logs_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    partial_audit_logs_table.search($(this).val()).draw();
                }
            }
        }
    });

}

$('#btn_save_arf').click(function()
{
    var saveType;
    var btn = $(this);

    if($('#last_name_arf').val() != '' && $('#f_name_arf').val() != '')
    {
        if($(this).attr('href') == null)
        {
            btn.attr('disabled', true);

            saveType = 'new';

            arfInsertSave(saveType, btn, $('#show_uploader_discrep').attr('log'));
        }
        else
        {
            saveType = atob($(this).attr('href'));

            $('#modal-ask-save-update').modal('show');

            $('#btnArfUpdateLog').attr('href', btoa(saveType));
            $('#btnArfUpdateLog').attr('name', what_logs);
            $('#btnArfSaveNew').attr('name', what_logs);

            $('#btnArfSaveNew').attr('disabled', false);

            if($(this).attr('check') == 'saved')
            {
                $('#btnArfUpdateLog').attr('disabled', false);
            }
            else
            {
                $('#btnArfUpdateLog').attr('disabled', true);
            }

        }
    }
    else if($('#last_name_arf').val() == '' && $('#f_name_arf').val() == '')
    {
        alert('Please enter employee full name');
    }
});

$('#btn_save_phone_field').click(function()
{
    var saveType;
    var btn = $(this);

    if($('#emp_last_name').val() != '' && $('#emp_first_name').val() != '')
    {
        if($(this).attr('href') == null)
        {
            saveType = 'new';

            btn.attr('disabled', true);

            phoneFieldSave(saveType, btn, $('#clickToFilePf').attr('log'));
        }
        else
        {
            saveType = atob($(this).attr('href'));

            $('#modal-ask-save-update').modal('show');

            $('#btnArfSaveNew').attr('name', what_logs);
            $('#btnArfUpdateLog').attr('href', btoa(saveType));
            $('#btnArfUpdateLog').attr('name', what_logs);

            if($(this).attr('check') == 'saved')
            {
                $('#btnArfUpdateLog').attr('disabled', false);
            }
            else
            {
                $('#btnArfUpdateLog').attr('disabled', true);
            }
        }
    }
    else if($('#emp_last_name').val() == '' && $('#emp_first_name').val() == '')
    {
        alert('Please enter employee full name');
    }
});

$('#btn_save_cssf').click(function()
{
    var saveType;
    var btn = $(this);

    if($('#employee_last_name').val() != '' && $('#employee_first_name').val() != '')
    {
        if($(this).attr('href') == null)
        {
            saveType = 'new';

            btn.attr('disabled', true);

            cssfSave(saveType, btn, $('#tab_6_upload_label').attr('log'));
        }
        else
        {
            saveType = atob($(this).attr('href'));

            $('#modal-ask-save-update').modal('show');

            $('#btnArfSaveNew').attr('name', what_logs);
            $('#btnArfUpdateLog').attr('name', what_logs);
            $('#btnArfUpdateLog').attr('href', btoa(saveType));

            $('#btnArfSaveNew').attr('disabled', false);

            if($(this).attr('check') == 'saved')
            {
                $('#btnArfUpdateLog').attr('disabled', false);
            }
            else
            {
                $('#btnArfUpdateLog').attr('disabled', true);
            }
        }
    }
    else if($('#employee_last_name').val() == '' && $('#employee_first_name').val() == '')
    {
        alert('Please enter employee full name');
    }
});

$('#btnArfSaveNew').click(function()
{
    $('#modal-ask-save-update').modal('hide');
    var btn = $(this);

    btn.attr('disabled', true);
    $('#btnArfUpdateLog').attr('disabled', true);

    var saveType = 'new';

    var type = $(this).attr('name');

    if(type == 'audit_report_form' || type == 'audit_discrepancy_form')
    {
        arfInsertSave(saveType, btn, $('#show_uploader_discrep').attr('log'));
    }
    else if(type == 'audit_field_checking' || type == 'audit_phone_checking')
    {
        phoneFieldSave(saveType, $('#btn_save_phone_field'), $('#clickToFilePf').attr('log'));
    }
    else if(type == 'ci_report_checking')
    {
        cssfSave(saveType, $('#btn_save_cssf'), $('#tab_6_upload_label').attr('log'));
    }
});

$('#btnArfUpdateLog').click(function()
{
    var btn = $(this);
    $('#modal-ask-save-update').modal('hide');

    btn.attr('disabled', true);
    $('#btnArfSaveNew').attr('disabled', true);

    var saveType = atob($(this).attr('href'));
    var type = $(this).attr('name');

    if(type == 'audit_report_form' || type == 'audit_discrepancy_form')
    {
        arfInsertSave(saveType, $('#btn_save_phone_field'), $('#show_uploader_discrep').attr('log'));
    }
    else if(type == 'audit_field_checking' || type == 'audit_phone_checking')
    {
        phoneFieldSave(saveType, $('#btn_save_phone_field'), $('#clickToFilePf').attr('log'));
    }
    else if(type == 'ci_report_checking')
    {
        cssfSave(saveType, $('#btn_save_cssf'), $('#tab_6_upload_label').attr('log'));
    }
});

function arfInsertSave(save, btn, log_id)
{
    saveSubmitTypeArf = 'save';

    var oimsID = $('#autoComId').val();
    var client_name = $('#client_name').val();
    var nameComp = $('#full_name_company').val();
    var tor = $('#type_of_request').val();
    var endor_date = $('#endorsement_date').val();
    var sub_date = $('#submission_date').val();
    var internalTat = $('#internal_tat').val();
    var exTat = $('#external_tat').val();
    var specialInst = $('#special_instruction').val();
    var tochecking = $('#type_of_checking').val();
    var l_name = $('#last_name_arf').val();
    var f_name = $('#f_name_arf').val();
    var emp_id = $('#emp_id_arf').val();
    var department = $('#dept_arf').val();
    var jobTit = $('#job_title_arf').val();
    var dateHired = $('#date_hired_arf').val();
    var findings = $('#findings_arf').val();
    var investig = $('#investigation_arf').val();
    var validRes = $('#valid_res_arf').val();
    var states = $('#statements_arf').val();
    var observe = $('#obs_arf').val();
    var recom = $('#recom_arf').val();
    var bus_name = $('#business_name').val();
    var address = $('#full_address').val()
    var chosenForm;
    // var saveArfFile = $('#upload_arf').prop('files')[0];
    // var checkFile = $('#upload_arf').val();

    if($('#optionAudit').is(':checked'))
    {
        chosenForm = 'audit';
        what_logs = 'audit_report_form';
        // getLogsFunction(what_logs)
    }
    else if($('#optionDesc').is(':checked'))
    {
        chosenForm = 'desc';
        what_logs = 'audit_discrepancy_form';
        // getLogsFunction(what_logs)
    }

    $.ajax
    ({
        type : 'get',
        url : 'audit-save-update-data',
        data :
            {
                'chose' : chosenForm,
                'oimsID' : oimsID,
                'client_name' : client_name,
                'nameComp' : nameComp,
                'bus_name' : bus_name,
                'address' : address,
                'tor' : tor,
                'endor_date' : endor_date,
                'sub_date' : sub_date,
                'internalTat' : internalTat,
                'exTat' : exTat,
                'specialInst' : specialInst,
                'tochecking' : tochecking,
                'l_name' : l_name,
                'f_name' : f_name,
                'emp_id' : emp_id,
                'department' : department,
                'jobTit' : jobTit,
                'dateHired' : dateHired,
                'findings' : findings,
                'investig' : investig,
                'validRes' : validRes,
                'states' : states,
                'observe' : observe,
                'recom' : recom,
                'id' : save,
                'log_id' : log_id
            },
        beforeSend : function()
        {
            $('#modal-loading-arf-files').modal('show');
        },
        success : function(data)
        {
            if(discrep_fine_array.length > 0)
            {
                $('#qq-audit-discrepancy-form-fine-holder').fineUploader('uploadStoredFiles');
                btn.attr('disabled', false);
            }
            else
            {
                $('#modal-loading-arf-files').modal('hide');
                btn.attr('disabled', false);
            }
            getLogsFunction(what_logs);
            disableArfAttr();
            $('#btn_edit_arf_details').attr('disabled', false);
            // sendFilesARF(data[0], data[1], saveArfFile, saveSubmitTypeArf)
        },
        error : function()
        {
            btn.attr('disabled', false);
            alert('There was a problem in inserting data!');
        }
    });

    // if(discrep_fine_array.length > 0)
    // {
    //     $.ajax
    //     ({
    //         type : 'get',
    //         url : 'audit-save-update-data',
    //         data :
    //             {
    //                 'chose' : chosenForm,
    //                 'oimsID' : oimsID,
    //                 'client_name' : client_name,
    //                 'nameComp' : nameComp,
    //                 'bus_name' : bus_name,
    //                 'address' : address,
    //                 'tor' : tor,
    //                 'endor_date' : endor_date,
    //                 'sub_date' : sub_date,
    //                 'internalTat' : internalTat,
    //                 'exTat' : exTat,
    //                 'specialInst' : specialInst,
    //                 'tochecking' : tochecking,
    //                 'l_name' : l_name,
    //                 'f_name' : f_name,
    //                 'emp_id' : emp_id,
    //                 'department' : department,
    //                 'jobTit' : jobTit,
    //                 'dateHired' : dateHired,
    //                 'findings' : findings,
    //                 'investig' : investig,
    //                 'validRes' : validRes,
    //                 'states' : states,
    //                 'observe' : observe,
    //                 'recom' : recom,
    //                 'id' : save,
    //                 'log_id' : log_id
    //             },
    //         beforeSend : function()
    //         {
    //             $('#modal-loading-arf-files').modal('show');
    //         },
    //         success : function(data)
    //         {
    //             if(discrep_fine_array.length > 0)
    //             {
    //                 $('#qq-audit-discrepancy-form-fine-holder').fineUploader('uploadStoredFiles');
    //                 btn.attr('disabled', false);
    //             }
    //             else
    //             {
    //                 btn.attr('disabled', false);
    //             }
    //             // sendFilesARF(data[0], data[1], saveArfFile, saveSubmitTypeArf)
    //         },
    //         error : function()
    //         {
    //             btn.attr('disabled', false);
    //             alert('There was a problem in inserting data!');
    //         }
    //     });
    // }
    // else
    // {
    //     alert('Please select a file.');
    //     btn.attr('disabled', false);
    // }



    // if(checkFile != '')
    // {
    //     if(saveArfFile.type == 'application/pdf')
    //     {
    //         $.ajax
    //         ({
    //             type : 'get',
    //             url : 'audit-save-update-data',
    //             data :
    //                 {
    //                     'chose' : chosenForm,
    //                     'oimsID' : oimsID,
    //                     'client_name' : client_name,
    //                     'nameComp' : nameComp,
    //                     'bus_name' : bus_name,
    //                     'address' : address,
    //                     'tor' : tor,
    //                     'endor_date' : endor_date,
    //                     'sub_date' : sub_date,
    //                     'internalTat' : internalTat,
    //                     'exTat' : exTat,
    //                     'specialInst' : specialInst,
    //                     'tochecking' : tochecking,
    //                     'l_name' : l_name,
    //                     'f_name' : f_name,
    //                     'emp_id' : emp_id,
    //                     'department' : department,
    //                     'jobTit' : jobTit,
    //                     'dateHired' : dateHired,
    //                     'findings' : findings,
    //                     'investig' : investig,
    //                     'validRes' : validRes,
    //                     'states' : states,
    //                     'observe' : observe,
    //                     'recom' : recom,
    //                     'id' : save
    //                 },
    //             beforeSend : function()
    //             {
    //                 $('#modal-loading-arf-files').modal('show');
    //             },
    //             success : function(data)
    //             {
    //                 sendFilesARF(data[0], data[1], saveArfFile, saveSubmitTypeArf)
    //             },
    //             error : function()
    //             {
    //                 alert('There was a problem in inserting data!');
    //             }
    //         });
    //     }
    //     else if(saveArfFile.type != 'application/pdf')
    //     {
    //         alert('Please select a PDF File.');
    //         btn.attr('disabled', false);
    //     }
    // }
    // else
    // {
    //     $.ajax
    //     ({
    //         type : 'get',
    //         url : 'audit-save-update-data',
    //         data :
    //             {
    //                 'chose' : chosenForm,
    //                 'oimsID' : oimsID,
    //                 'client_name' : client_name,
    //                 'nameComp' : nameComp,
    //                 'bus_name' : bus_name,
    //                 'address' : address,
    //                 'tor' : tor,
    //                 'endor_date' : endor_date,
    //                 'sub_date' : sub_date,
    //                 'internalTat' : internalTat,
    //                 'exTat' : exTat,
    //                 'specialInst' : specialInst,
    //                 'tochecking' : tochecking,
    //                 'l_name' : l_name,
    //                 'f_name' : f_name,
    //                 'emp_id' : emp_id,
    //                 'department' : department,
    //                 'jobTit' : jobTit,
    //                 'dateHired' : dateHired,
    //                 'findings' : findings,
    //                 'investig' : investig,
    //                 'validRes' : validRes,
    //                 'states' : states,
    //                 'observe' : observe,
    //                 'recom' : recom,
    //                 'id' : save
    //             },
    //         beforeSend : function()
    //         {
    //             $('#modal-loading-arf-files').modal('show');
    //         },
    //         success : function(data)
    //         {
    //             $('#modal-loading-arf-files').modal('hide');
    //
    //             var timerSuccess = setInterval(function ()
    //             {
    //                 $('#modal-success-arf-send').modal('show');
    //                 var timerSuccessHide = setInterval(function ()
    //                 {
    //                     $('#modal-success-arf-send').modal('hide');
    //                     clearInterval(timerSuccessHide);
    //                 },5000);
    //                 clearInterval(timerSuccess);
    //             },1000);
    //
    //             saveCounter = true;
    //             getLogsFunction(what_logs);
    //             disableArfAttr();
    //             btn.attr('disabled', false);
    //
    //             $('#btn_save_arf').attr('href', btoa(data[2]));
    //             $('#btn_send_arf').attr('href', btoa(data[2]));
    //             $('#btn_send_arf').attr('name', 'without');
    //
    //             $('#btn_edit_arf_details').attr('disabled', false);
    //         },
    //         error : function()
    //         {
    //             alert('There was a problem in inserting data!');
    //             btn.attr('disabled', false);
    //         }
    //     });
    // }
}

function phoneFieldSave(save, btn, log_id)
{
    saveSubmitPf = 'save';

    $('#modal-ask-save-update').modal('hide');

    var oimsId = $('#oimsIdPhoneField').val();
    var subjName = $('#fieldPhoneComNameSubj').val();
    var busName = $('#busName_ph_field').val();
    var addRess = $('#address_phone_field').val();
    var dateLogged = $('#log_time_ph_field').val();
    var auditName = $('#name_auditor_phone_field').val();
    var findings = $('#remCompliance').val();
    var doneThru = $('#doneThruPhoneField').val();
    var clientName = $('#client_name_phone_field').val();
    var tor = $('#tor_field_phone').val();
    var dateEndorsed = $('#date_endorsed_phone_field').val();
    var ciVisit = $('#ci_visit_ph_field').val();
    var spec = $('#spec_ins_phone_field').val();
    var toc = $('#toc_phone_field').val();
    var emp_last_name = $('#emp_last_name').val();
    var emp_first_name = $('#emp_first_name').val();
    var emp_id = $('#emp_id').val();
    var emp_dept = $('#emp_dept_ph_field').val();
    var jobTitle = $('#title_job_phone_field').val();
    var dateHired = $('#date_hired_ph_field').val();
    var sum_rep = $('#summarty_report_field_phone').val();
    // var filePf = $('#uploadFilePf').prop('files')[0];
    // var checkfilePf = $('#uploadFilePf').val();


    var checkPhoneField;

    if ($('#optionField').is(':checked'))
    {
        checkPhoneField = 'field';
    }
    else if ($('#optionPhone').is(':checked'))
    {
        checkPhoneField = 'phone';
    }

    var compliance_answer = [];
    var informant_validation = [];
    var new_informants_gathered = [];
    var i;
    var j;
    var countValid = 0;
    var countNew = 0;
    var countComp = 0;

    $('.ans_compliance').each(function ()
    {
        compliance_answer[countComp] = ($(this).val());
        countComp++;
    });

    for (i = 0; i < 5; i++)
    {
        informant_validation[i] = [];

        $('.inform_valid_' + i + '').each(function () {
            informant_validation[i][countValid] = $(this).val();
            countValid++
        });
        countValid = 0;
    }

    for (j = 0; j < 3; j++)
    {
        new_informants_gathered[j] = [];

        $('.new_informant_' + j + '').each(function () {
            new_informants_gathered[j][countNew] = $(this).val();
            countNew++
        });
        countNew = 0;
    }

    $.ajax
    ({
        type : 'post',
        url : 'audit-save-update-phone-field-log',
        data :
            {
                informant_validation : informant_validation,
                new_informants_gathered : new_informants_gathered,
                compliance_answer :  compliance_answer,
                'oimsId' : oimsId,
                'subjName' : subjName,
                'busName' : busName,
                'addRess' : addRess,
                'dateLogged' : dateLogged,
                'auditName' : auditName,
                'findings' : findings,
                'doneThru' : doneThru,
                'clientName' : clientName,
                'tor' : tor,
                'dateEndorsed' : dateEndorsed,
                'ciVisit' : ciVisit,
                'spec' : spec,
                'toc' : toc,
                'emp_last_name' : emp_last_name,
                'emp_first_name' : emp_first_name,
                'emp_id' : emp_id,
                'emp_dept' : emp_dept,
                'jobTitle' : jobTitle,
                'dateHired' : dateHired,
                'sum_rep' : sum_rep,
                'checkPhoneField' : checkPhoneField,
                'id' : save,
                'log_id' : log_id
            },
        beforeSend : function()
        {
            $('#modal-loading-arf-files').modal('show');
        },
        success : function(data)
        {
            if(field_fine_array.length > 0)
            {
                $('#fieldUploaderDiv').fineUploader('uploadStoredFiles');
                btn.attr('disabled', false);
            }
            else
            {
                $('#modal-loading-arf-files').modal('hide');
                btn.attr('disabled', false);
            }
            $('#modal-loading-arf-files').modal('hide');

            field_fine_checker = false;
            getLogsFunction(what_logs);
            disPfALl();
            $('#btn_edit_phone_field').attr('disabled', false);
            // sendFilesPhoneField(data[0], data[1], filePf, saveSubmitPf);
        },
        error : function()
        {
            alert('There was a problem in inserting data!');
        }
    });

    // if(checkfilePf != '')
    // {
    //     if(filePf.type == 'application/pdf')
    //     {
    //         $.ajax
    //         ({
    //             type : 'post',
    //             url : 'audit-save-update-phone-field-log',
    //             data :
    //                 {
    //                     informant_validation : informant_validation,
    //                     new_informants_gathered : new_informants_gathered,
    //                     compliance_answer :  compliance_answer,
    //                     'oimsId' : oimsId,
    //                     'subjName' : subjName,
    //                     'busName' : busName,
    //                     'addRess' : addRess,
    //                     'dateLogged' : dateLogged,
    //                     'auditName' : auditName,
    //                     'findings' : findings,
    //                     'doneThru' : doneThru,
    //                     'clientName' : clientName,
    //                     'tor' : tor,
    //                     'dateEndorsed' : dateEndorsed,
    //                     'ciVisit' : ciVisit,
    //                     'spec' : spec,
    //                     'toc' : toc,
    //                     'emp_last_name' : emp_last_name,
    //                     'emp_first_name' : emp_first_name,
    //                     'emp_id' : emp_id,
    //                     'emp_dept' : emp_dept,
    //                     'jobTitle' : jobTitle,
    //                     'dateHired' : dateHired,
    //                     'sum_rep' : sum_rep,
    //                     'checkPhoneField' : checkPhoneField,
    //                     'id' : save
    //                 },
    //             beforeSend : function()
    //             {
    //                 $('#modal-loading-arf-files').modal('show');
    //             },
    //             success : function(data)
    //             {
    //                 // sendFilesPhoneField(data[0], data[1], filePf, saveSubmitPf);
    //             },
    //             error : function()
    //             {
    //                 alert('There was a problem in inserting data!');
    //             }
    //         });
    //     }
    //     else if(filePf.type != 'application/pdf')
    //     {
    //         alert('Please select a PDF File.');
    //         btn.attr('disabled', false);
    //     }
    // }
    // else
    // {
    //     $.ajax
    //     ({
    //         type : 'post',
    //         url : 'audit-save-update-phone-field-log',
    //         data :
    //             {
    //                 informant_validation : informant_validation,
    //                 new_informants_gathered : new_informants_gathered,
    //                 compliance_answer :  compliance_answer,
    //                 'oimsId' : oimsId,
    //                 'subjName' : subjName,
    //                 'busName' : busName,
    //                 'addRess' : addRess,
    //                 'dateLogged' : dateLogged,
    //                 'auditName' : auditName,
    //                 'findings' : findings,
    //                 'doneThru' : doneThru,
    //                 'clientName' : clientName,
    //                 'tor' : tor,
    //                 'dateEndorsed' : dateEndorsed,
    //                 'ciVisit' : ciVisit,
    //                 'spec' : spec,
    //                 'toc' : toc,
    //                 'emp_last_name' : emp_last_name,
    //                 'emp_first_name' : emp_first_name,
    //                 'emp_id' : emp_id,
    //                 'emp_dept' : emp_dept,
    //                 'jobTitle' : jobTitle,
    //                 'dateHired' : dateHired,
    //                 'sum_rep' : sum_rep,
    //                 'checkPhoneField' : checkPhoneField,
    //                 'id' : save
    //             },
    //         beforeSend : function()
    //         {
    //             $('#modal-loading-arf-files').modal('show');
    //         },
    //         success : function(data)
    //         {
    //             $('#modal-loading-arf-files').modal('hide');
    //
    //             var timerSuccess = setInterval(function ()
    //             {
    //                 $('#modal-success-arf-send').modal('show');
    //                 var timerSuccessHide = setInterval(function ()
    //                 {
    //                     $('#modal-success-arf-send').modal('hide');
    //                     clearInterval(timerSuccessHide);
    //                 },5000);
    //                 clearInterval(timerSuccess);
    //             },1000);
    //
    //             saveCounter = true;
    //             getLogsFunction(what_logs);
    //             disPfALl();
    //             btn.attr('disabled', false);
    //
    //             $('#btn_save_phone_field').attr('href', btoa(data[2]));
    //             $('#btn_submit_phone_field').attr('href', btoa(data[2]));
    //             $('#btn_submit_phone_field').attr('name', 'without');
    //
    //             $('#btn_edit_phone_field').attr('disabled', false);
    //         },
    //         error : function()
    //         {
    //             alert('There was a problem in inserting data!');
    //             btn.attr('disabled', false);
    //         }
    //     });
    // }
}

function cssfSave(save, btn, log_id)
{
    saveSubmitCssf = 'save';

    var ci_emp_id = $('#ci_employee_id').val();
    var ci_l_name = $('#employee_last_name').val();
    var ci_f_name = $('#employee_first_name').val();
    var ci_job_title = $('#employee_job_title_cssf').val();
    var ci_date_hired = $('#ci_date_hired').val();
    var ci_area = $('#ci_area').val();
    var ci_branch_head = $('#ci_branch_head').val();
    var ci_reg_branch_head = $('#ci_reg_branch_head').val();
    var ci_sao = $('#ci_sao').val();
    var ci_sup = $('#ci_sup').val();
    var ci_grade_completeness = $('#ci_grade_completeness').val();
    var ci_grade_gps = $('#ci_grade_gps').val();
    var ci_grade_informantsValidity = $('#ci_grade_informantsValidity').val();
    var ci_grade_encodingAccu = $('#ci_grade_encodingAccu').val();
    var ci_grade_selfie = $('#ci_grade_selfie').val();
    var ci_grade_tatCompliance = $('#ci_grade_tatCompliance').val();
    var ci_grade_attachedDocs = $('#ci_grade_attachedDocs').val();
    var ci_grade_completeness_rem = $('#ci_grade_completeness_rem').val();
    var ci_grade_gps_rem = $('#ci_grade_gps_rem').val();
    var ci_grade_informantsValidity_rem = $('#ci_grade_informantsValidity_rem').val();
    var ci_grade_encodingAccu_rem = $('#ci_grade_encodingAccu_rem').val();
    var ci_grade_selfie_rem = $('#ci_grade_selfie_rem').val();
    var ci_grade_tatCompliance_rem = $('#ci_grade_tatCompliance_rem').val();
    var ci_grade_attachedDocs_rem = $('#ci_grade_attachedDocs_rem').val();

    //ACCOUNT DETAILS

    var messenger_endorse_id = $('#account_messenger_id').val();
    var oims_endorse_id = $('#ci_account_oims_id').val();
    var account_bank_name =$('#account_bank_name').val();
    var account_date_endorse = $('#account_date_endorse').val();
    var account_name = $('#account_name').val();
    var ci_date_visited = $('#ci_date_visited').val();
    var account_tor = $('#account_tor').val();
    var accnt_handling_type = $('#accnt_handling_type').val();
    var accnt_source = $('#accnt_source').val();

    // var cssfFile = $('#tab6_upload').prop('files')[0];
    // var checkFIle =$('#tab6_upload').val();

    if(ciRep_fine_array.length > 0 || save != 'new')
    {
        $.ajax
        ({
            type: 'get',
            url: 'audit-save-update-cssf',
            data:
                {
                    'emp_id' : ci_emp_id,
                    'ci_l_name' : ci_l_name,
                    'ci_f_name' : ci_f_name,
                    'ci_job_title' : ci_job_title,
                    'ci_date_hired' : ci_date_hired,
                    'ci_area' : ci_area,
                    'ci_branch_head' : ci_branch_head,
                    'ci_regional_head' : ci_reg_branch_head,
                    'ci_senior_account_officer' : ci_sao,
                    'ci_supervisor' : ci_sup,
                    'oims_endorse_id': oims_endorse_id,
                    'messenger_endorse_id': messenger_endorse_id,
                    'account_name' : account_name,
                    'bank_name' : account_bank_name,
                    'endorse_date' : account_date_endorse,
                    'date_visited' : ci_date_visited,
                    'account_tor' : account_tor,
                    'handling_type' : accnt_handling_type,
                    'account_source' : accnt_source,
                    'completeness' : ci_grade_completeness,
                    'completeness_remarks' : ci_grade_completeness_rem,
                    'gps_attachment' : ci_grade_gps,
                    'gps_attachment_remarks' : ci_grade_gps_rem,
                    'informants_validity': ci_grade_informantsValidity,
                    'informants_validity_remarks' : ci_grade_informantsValidity_rem,
                    'encoding_accuracy' : ci_grade_encodingAccu,
                    'encoding_accuracy_remarks' : ci_grade_encodingAccu_rem,
                    'selfie_uniform_id' : ci_grade_selfie,
                    'selfie_uniform_id_remarks' : ci_grade_selfie_rem,
                    'tat_compliance' : ci_grade_tatCompliance,
                    'tat_compliance_remarks' : ci_grade_tatCompliance_rem,
                    'attached_documents' : ci_grade_attachedDocs,
                    'attached_documents_remarks' : ci_grade_attachedDocs_rem,
                    'report_summary' : $('#ci_account_summary').val(),
                    'cause_of_delay' : $('#cause_of_delay_rem').val(),
                    'id' : save,
                    'log_id' : log_id
                },
            beforeSend : function()
            {
                $('#modal-loading-arf-files').modal('show');
            },
            success: function(data)
            {

                if(ciRep_fine_array.length > 0)
                {
                    $('#qq-audit-ciRep-form-fine-holder').fineUploader('uploadStoredFiles');
                }

                $('#modal-loading-arf-files').modal('hide');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-success-arf-send').modal('show');
                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-success-arf-send').modal('hide');
                        clearInterval(timerSuccessHide);
                    },5000);
                    clearInterval(timerSuccess);
                },1000);

                saveCounter = true;
                getLogsFunction(what_logs);
                btn.attr('disabled', false);

                disCssfAll();

                $('#btn_save_cssf').attr('href', btoa(data));
                $('#submitCiReportChecking').attr('href', btoa(data));
                $('#submitCiReportChecking').attr('name', 'without');

                $('#editTab6').attr('disabled', false);
            },
            error : function()
            {
                alert('There was a problem in inserting data!');
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        alert('No Attachment');
    }


    // if(checkFIle != '')
    // {
    //     if(cssfFile.type == 'application/pdf')
    //     {
    //         $.ajax
    //         ({
    //             type: 'get',
    //             url: 'audit-save-update-cssf',
    //             data:
    //                 {
    //                     'emp_id' : ci_emp_id,
    //                     'ci_l_name' : ci_l_name,
    //                     'ci_f_name' : ci_f_name,
    //                     'ci_job_title' : ci_job_title,
    //                     'ci_date_hired' : ci_date_hired,
    //                     'ci_area' : ci_area,
    //                     'ci_branch_head' : ci_branch_head,
    //                     'ci_regional_head' : ci_reg_branch_head,
    //                     'ci_senior_account_officer' : ci_sao,
    //                     'ci_supervisor' : ci_sup,
    //                     'oims_endorse_id': oims_endorse_id,
    //                     'messenger_endorse_id': messenger_endorse_id,
    //                     'account_name' : account_name,
    //                     'bank_name' : account_bank_name,
    //                     'endorse_date' : account_date_endorse,
    //                     'date_visited' : ci_date_visited,
    //                     'account_tor' : account_tor,
    //                     'handling_type' : accnt_handling_type,
    //                     'account_source' : accnt_source,
    //                     'completeness' : ci_grade_completeness,
    //                     'completeness_remarks' : ci_grade_completeness_rem,
    //                     'gps_attachment' : ci_grade_gps,
    //                     'gps_attachment_remarks' : ci_grade_gps_rem,
    //                     'informants_validity': ci_grade_informantsValidity,
    //                     'informants_validity_remarks' : ci_grade_informantsValidity_rem,
    //                     'encoding_accuracy' : ci_grade_encodingAccu,
    //                     'encoding_accuracy_remarks' : ci_grade_encodingAccu_rem,
    //                     'selfie_uniform_id' : ci_grade_selfie,
    //                     'selfie_uniform_id_remarks' : ci_grade_selfie_rem,
    //                     'tat_compliance' : ci_grade_tatCompliance,
    //                     'tat_compliance_remarks' : ci_grade_tatCompliance_rem,
    //                     'attached_documents' : ci_grade_attachedDocs,
    //                     'attached_documents_remarks' : ci_grade_attachedDocs_rem,
    //                     'report_summary' : $('#ci_account_summary').val(),
    //                     'cause_of_delay' : $('#cause_of_delay_rem').val(),
    //                     'id' : save
    //                 },
    //             beforeSend : function()
    //             {
    //                 $('#modal-loading-arf-files').modal('show');
    //             },
    //             success: function(data)
    //             {
    //                 sendFilesCssf(cssfFile, data, saveSubmitCssf);
    //             },
    //             error : function()
    //             {
    //                 alert('There was a problem in inserting data!');
    //             }
    //         });
    //     }
    //     else if(cssfFile.type != 'application/pdf')
    //     {
    //         alert('Please select a PDF File.');
    //         btn.attr('disabled', false);
    //     }
    // }
    // else
    // {
    //     $.ajax
    //     ({
    //         type: 'get',
    //         url: 'audit-save-update-cssf',
    //         data:
    //             {
    //                 'emp_id' : ci_emp_id,
    //                 'ci_l_name' : ci_l_name,
    //                 'ci_f_name' : ci_f_name,
    //                 'ci_job_title' : ci_job_title,
    //                 'ci_date_hired' : ci_date_hired,
    //                 'ci_area' : ci_area,
    //                 'ci_branch_head' : ci_branch_head,
    //                 'ci_regional_head' : ci_reg_branch_head,
    //                 'ci_senior_account_officer' : ci_sao,
    //                 'ci_supervisor' : ci_sup,
    //                 'oims_endorse_id': oims_endorse_id,
    //                 'messenger_endorse_id': messenger_endorse_id,
    //                 'account_name' : account_name,
    //                 'bank_name' : account_bank_name,
    //                 'endorse_date' : account_date_endorse,
    //                 'date_visited' : ci_date_visited,
    //                 'account_tor' : account_tor,
    //                 'handling_type' : accnt_handling_type,
    //                 'account_source' : accnt_source,
    //                 'completeness' : ci_grade_completeness,
    //                 'completeness_remarks' : ci_grade_completeness_rem,
    //                 'gps_attachment' : ci_grade_gps,
    //                 'gps_attachment_remarks' : ci_grade_gps_rem,
    //                 'informants_validity': ci_grade_informantsValidity,
    //                 'informants_validity_remarks' : ci_grade_informantsValidity_rem,
    //                 'encoding_accuracy' : ci_grade_encodingAccu,
    //                 'encoding_accuracy_remarks' : ci_grade_encodingAccu_rem,
    //                 'selfie_uniform_id' : ci_grade_selfie,
    //                 'selfie_uniform_id_remarks' : ci_grade_selfie_rem,
    //                 'tat_compliance' : ci_grade_tatCompliance,
    //                 'tat_compliance_remarks' : ci_grade_tatCompliance_rem,
    //                 'attached_documents' : ci_grade_attachedDocs,
    //                 'attached_documents_remarks' : ci_grade_attachedDocs_rem,
    //                 'report_summary' : $('#ci_account_summary').val(),
    //                 'cause_of_delay' : $('#cause_of_delay_rem').val(),
    //                 'id' : save
    //             },
    //         beforeSend : function()
    //         {
    //             $('#modal-loading-arf-files').modal('show');
    //         },
    //         success: function(data)
    //         {
    //             $('#modal-loading-arf-files').modal('hide');
    //
    //             var timerSuccess = setInterval(function ()
    //             {
    //                 $('#modal-success-arf-send').modal('show');
    //                 var timerSuccessHide = setInterval(function ()
    //                 {
    //                     $('#modal-success-arf-send').modal('hide');
    //                     clearInterval(timerSuccessHide);
    //                 },5000);
    //                 clearInterval(timerSuccess);
    //             },1000);
    //
    //             saveCounter = true;
    //             getLogsFunction(what_logs);
    //             btn.attr('disabled', false);
    //
    //             disCssfAll();
    //
    //             $('#btn_save_cssf').attr('href', btoa(data));
    //             $('#submitCiReportChecking').attr('href', btoa(data));
    //             $('#submitCiReportChecking').attr('name', 'without');
    //
    //             $('#editTab6').attr('disabled', false);
    //         },
    //         error : function()
    //         {
    //             alert('There was a problem in inserting data!');
    //             btn.attr('disabled', false);
    //         }
    //     });
    // }
}

$('#general_audit_logs_table').on('click', '#btn_view_return_rem', function()
{
    $('#audit_remarks_log').val('');
    $('#audit_remarks_log').attr('disabled', true);
    $('#return_now_log_au').hide();

    if($(this).attr('href') == 'return')
    {
        $('#showRemRetAudit').show();
    }
    else if($(this).attr('href') == null)
    {
        $('#showRemRetAudit').hide();
    }

    $.ajax
    ({
        type : 'get',
        url : 'audit-get-remarks-return',
        data :
            {
                'id' : $(this).attr('name')
            },
        success : function(data)
        {
            $('#audit_remarks_log').val(data[0].return_remarks);
            $('#show_date_return').val(data[0].return_date_time);
        }

    });
});

$('#tab6_upload').change(function(e)
{
    var tab6File = e.target.files[0];

    if(tab6File != null)
    {
        $('#tab_6_upload_label').text('Ready for Upload');

        if(tab6File.type == 'application/pdf')
        {
            console.log('pdf file');
            tab6uploadBool = true;
        }
        else
        {
            console.log('not pdf');
            tab6uploadBool = false;
        }
    }
    else
    {
        $('#tab_6_upload_label').text('Upload Attachment');
    }
});

$('#clickToFileArf').click(function()
{
    $('#upload_arf').click();
});

$('#upload_arf').change(function(e)
{
    if(e.target.files[0] != null)
    {
        $('#toUploadStatArf').html('File Ready for Upload');
    }
    else
    {
        $('#toUploadStatArf').html('Upload Attachment');
    }
});

$('#uploadFilePf').change(function(e)
{
    if(e.target.files[0] != null)
    {
        $('#statFilePf').html('File Ready for Upload');
    }
    else
    {
        $('#statFilePf').html('Upload Attachment');
    }
});

$('.audit_forms_tab_class').click(function ()
{
    var gethref = $(this).attr('href');

    if (gethref == '#tab_log1')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            openHrefAudit = 'tab_log1';
        }
        else if(audit_rep_bool)
        {
            console.log('already loaded');
            openHrefAudit = 'tab_log1';

        }
        else if (audit_rep_bool == false)
        {
            audit_rep_bool = true;
            openHrefAudit = 'tab_log1';
        }
    }
    else if (gethref == '#tab_log2')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            openHrefAudit = 'tab_log2';
        }
        else if(audit_moni_bool)
        {
            if(submitCounter == true)
            {
                general_audit_logs_table.ajax.reload(null, false);
                submitCounter = false;
            }
            else
            {
                console.log('already loaded');
            }
            openHrefAudit = 'tab_log2';
            clearNotifs();
        }
        else if (audit_moni_bool == false)
        {
            audit_moni_bool = true;
            openHrefAudit = 'tab_log2';
            auditGeneralLogs();
            clearNotifs();
        }
    }
});


$('.audit_forms_submit_save_class').click(function ()
{
    var gethref = $(this).attr('href');

    if (gethref == '#tab_submitted')
    {
        if($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            openStatBool = 'tab_submitted';
        }
        else if(audit_submitted_bool)
        {
            if(submitCounter == true)
            {
                general_audit_logs_table.ajax.reload(null, false);
                submitCounter = false;
            }
            else
            {
                console.log('already loaded');
            }
            openStatBool = 'tab_submitted';
        }
        else if(audit_submitted_bool == false)
        {
            audit_submitted_bool = true;
            openStatBool = 'tab_submitted';
        }
    }
    else if (gethref == '#tab_partial')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            openStatBool = 'tab_partial';
        }
        else if(audit_partial_bool)
        {
            if(saveCounter == true)
            {
                partial_audit_logs_table.ajax.reload(null, false);
                saveCounter = false;
            }
            else
            {
                console.log('already loaded');
            }
            openStatBool = 'tab_partial';
        }
        else if (audit_partial_bool == false)
        {
            audit_partial_bool = true;
            openStatBool = 'tab_partial';
            auditPartialLogs();
        }
    }
});

$('#newFormArf').click(function()
{
    clearAuditFormValAttr();
    $('#btn_edit_arf_details').attr('disabled', true);
    $('#dlAttachmentCiReport').removeAttr('href');
    $('#btn_save_arf').removeAttr('href');
    $('#viewAttachSavedArf').removeAttr('href');
    $('#viewAttachSavedArf').hide();
    $('#btn_send_arf').attr('name', 'without');
    $('#btn_send_arf').removeAttr('href');
    $('#btn_send_arf').removeAttr('check');
    $('#btn_save_arf').removeAttr('check');
    $('#audit_report_form_messenger').attr('disabled', false);
    $('#thisisUploadedDiscrep').hide();
    $('#uploaded_holder').html('');
    $('#show_uploader_discrep').removeAttr('log');
    $('#qq-audit-discrepancy-form-fine-holder').html('');
    discrep_fine_checker = false;
});

$('#newFormPf').click(function()
{
    clearPhoneField();
    $('#btn_download_ci_rep_pf').removeAttr('href');
    $('#btn_edit_phone_field').attr('disabled', true);
    $('#btn_save_phone_field').removeAttr('href');
    $('#removeValandDis').attr('disabled', false);
    $('#viewAttachmentPhoneField').removeAttr('href');
    $('#viewAttachmentPhoneField').hide();
    $('#btn_submit_phone_field').attr('name', 'without');
    $('#btn_submit_phone_field').removeAttr('check');
    $('#btn_save_phone_field').removeAttr('check');
    $('#btn_submit_phone_field').removeAttr('href');
    $('#removeValandDis').attr('disabled', false);
    $('#clickToFilePf').removeAttr('log');
    $('#fieldUploaderDiv').html('');
    $('#fieldUploadedHolder').html('');
    $('#FieldUploadedAttachments').hide();
    $('#clickToFilePf-cancel').hide();
    $('#clickToFilePf').show();
    $('#FieldUploader').hide();
    field_fine_checker = false;
});

$('#newFormCssf').click(function()
{
    ClearallFieldsTab6();
    enabledAllFieldTab6();
    $('#dwn_attachment_ci_endorse_ccsf').removeAttr('href');
    $('#btn_save_cssf').removeAttr('href');
    $('#btn_save_cssf').removeAttr('check');
    $('#submitCiReportChecking').removeAttr('href');
    $('#submitCiReportChecking').attr('name', 'without');
    $('#viewAttachmentCssf').removeAttr('href');
    $('#viewAttachmentCssf').removeAttr('check');
    $('#viewAttachmentCssf').hide();
    $('#tab_6_upload_label_cancel').hide();
    $('#tab_6_upload_label').show();
    $('#uploaded_holder_ci_rep').html('');
    $('#qq-audit-ciRep-form-fine-holder').html('');
    $('#thisisUploadedCIRep').hide();
    $('#thisisUploaderCIRep').hide();
    $('#tab_6_upload_label').removeAttr('log');
    $('#submitCiReportChecking').removeAttr('check');
    ciRep_fine_checker = false;
});

$('#audit-table-reports').on('click', '.audit_view_note', function()
{
    var id = $(this).val();
    $('#exportReport').attr('name', $(this).attr('name'));

    $('#view_note').val('');


    $.ajax
    ({
        method: 'get',
        url: 'ci-get-report',
        data:
            {
                'acctID': id
            },
        success: function (data)
        {
            $('#view_note').val(data[0].endorsement_report);
        }
    });
});

$('#exportReport').click(function()
{
    var acctName = $(this).attr('name');
    var a = document.body.appendChild
    (
        document.createElement("a")
    );
    var textToWrite = $('#view_note').val();

    // console.log(textToWrite);
    a.download = acctName+".txt";
    textToWrite = textToWrite.replace(/\n/g, "%0D%0A");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    // console.log(textToWrite);
    a.href = "data:text/plain," + textToWrite+'%0D%0A%0D%0A%0D%0A***NOTE: All HASHTAG SYMBOL ARE REPLACE WITH * (ASTERISK) SYMBOL***';

    setTimeout(function ()
    {
        a.click();
    },1000);
});

function checkReturnNotif()
{
    $.ajax
    ({
        type : 'get',
        url : 'audit-get-return-notif-count',
        success : function(data)
        {
            $('#notifCountReturn').html(data);
        }
    });
}

function clearNotifs()
{
    $.ajax
    ({
        type : 'get',
        url : 'audit-clear-return-notif',
        success : function(data)
        {
            $('#notifCountReturn').html(data);
        }
    });
}

$('#fund-audit-table-reports').on('click', '.btn-req-rem-view-fund', function()
{
    var val = $(this).attr('name');

    $('#req-rem-fund-req-rem').val('');

    setTimeout(function(){
        $('#req-rem-fund-req-rem').val(val);
    }, 300);
});

$('#hide_uploader_discrep').click(function()
{
    $(this).hide();
    $('#show_uploader_discrep').show();
    $('#thisisUploaderDiscrep').hide();
});

$('#show_uploader_discrep').click(function()
{
    var checkButton1 =$('#btn_send_arf').attr('check');
    var checkButton2 =$('#btn_save_arf').attr('check');
    var what_to_fine = '';

    if($('#thisisUploadedDiscrep').is(':visible'))
    {
        $('#thisisUploadedDiscrep').hide();
        $(this).show();
    }

    $('.log_checker').each(function()
    {
        if($(this).is(':checked'))
        {
            if($(this).attr('id') == 'optionDesc')
            {
                what_to_fine = 'descrepancy_form_audit';
            }
            else if($(this).attr('id') == 'optionAudit')
            {
                what_to_fine = 'audit_report_form';
            }
        }
    });

    if(typeof checkButton2 === 'undefined')
    {
        if(!discrep_fine_checker)
        {
            $.ajax({
                type: 'get',
                url: 'audit_set_fine_uploader',
                data: {
                    'what' : what_to_fine
                },
                success: function(data)
                {
                    console.log(data);
                    $('#show_uploader_discrep').attr('log', data);

                    fineUploaderFunct(data);
                }
            });


            discrep_fine_checker = true;
        }
    }
    else
    {
        var toReview_logId = $(this).attr('log');

        if(checkButton2 === 'review')
        {
            // console.log(toReview_logId);
            fineUploaderFunct(toReview_logId);
            discrep_fine_checker = true;
        }
        else if(checkButton2 === 'saved')
        {
            // console.log(toReview_logId);
            fineUploaderFunct(toReview_logId);
            discrep_fine_checker = true;
        }
    }
    $(this).hide();
    $('#thisisUploaderDiscrep').show();
    $('#hide_uploader_discrep').show();
});

function fineUploaderFunct(id)
{
    $('#qq-audit-discrepancy-form-fine-holder').html('');

    $('#qq-audit-discrepancy-form-fine-holder').fineUploader
    ({
        template: 'qq-audit-discrepancy-form-fine',
        request:
            {
                endpoint: 'audit_discrepancy_fine_uploader/' + id,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                // itemLimit: 3,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'wmv', 'mp3', 'mov', 'mkv', '3gp', 'txt']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        discrep_fine_array.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        discrep_fine_array.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    discrep_fine_array = [];
                    $('#thisisUploaderDiscrep').hide();
                    $('#show_uploader_discrep').show();
                    $('#show_uploader_discrep').attr('log', '');
                    $('#hide_uploader_discrep').hide();
                    $('#modal-loading-arf-files').modal('hide');
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

$('#tab_6_upload_label').click(function()
{
    $(this).hide();
    $('#tab_6_upload_label_cancel').show();

    $('#thisisUploaderCIRep').toggle();
    if($('#thisisUploadedCIRep').is(':visible'))
    {
        $('#thisisUploaderCIRep').show();
        $('#thisisUploadedCIRep').hide();
    }

    var checkbutton1 = $('#btn_save_cssf').attr('href');
    var checkbutton2 = $('#submitCiReportChecking').attr('href');
    if(typeof checkbutton2 === 'undefined')
    {
        if(!ciRep_fine_checker)
        {
            $.ajax({
                type: 'get',
                url: 'audit_set_fine_uploader',
                data: {
                    'what' : 'audit_ci_report_checking'
                },
                success: function(data)
                {
                    $('#tab_6_upload_label').attr('log', data);

                    fineUploaderFunctCSSF(data);
                }
            });


            ciRep_fine_checker = true;
        }

    }
    else
    {
        if(!ciRep_fine_checker)
        {
            fineUploaderFunctCSSF($('#tab_6_upload_label').attr('log'));

            ciRep_fine_checker = true;
        }

    }
});

$('#tab_6_upload_label_cancel').click(function()
{
    var fineLog = $(this).attr('log');
    $('#thisisUploaderCIRep').toggle();
    $(this).hide();
    $('#tab_6_upload_label').show();
});

function fineUploaderFunctCSSF(id)
{
    $('#qq-audit-ciRep-form-fine-holder').html('');

    $('#qq-audit-ciRep-form-fine-holder').fineUploader
    ({
        template: 'qq-audit-discrepancy-form-fine',
        request:
            {
                endpoint: 'audit_cirep_fine_uploader/' + id,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                // itemLimit: 3,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'wmv', 'mp3', 'mov', 'mkv', '3gp', 'txt']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        ciRep_fine_array.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        ciRep_fine_array.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    ciRep_fine_array = [];
                    $('#thisisUploaderCIRep').hide();
                    $('#show_uploader_discrep').show();
                    $('#tab_6_upload_label').attr('log', '');
                    $('#tab_6_upload_label_cancel').hide();
                    // $('#hide_uploader_discrep').hide();
                    $('#modal-loading-arf-files').modal('hide');
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

$('#clickToFilePf').click(function()
{
    $('#FieldUploader').toggle();
    $('#clickToFilePf-cancel').show();
    $('#clickToFilePf').hide();
    var what = '';

    $('.log_checker2').each(function()
    {
        if($(this).is(':checked'))
        {
            if($(this).attr('id') == 'optionField')
            {
                what = 'audit_field_checking';
            }
            else
            {
                what = 'audit_phone_checking';
            }
            console.log(what);
        }
    });

    if($('#FieldUploadedAttachments').is(':visible'))
    {
        $('#FieldUploadedAttachments').hide();
    }



    if(!field_fine_checker)
    {
        if(typeof $('#btn_submit_phone_field').attr('href') === 'undefined')
        {
            $.ajax({
                type: 'get',
                url: 'audit_set_fine_uploader',
                data: {
                    'what' : what
                },
                success: function(data)
                {
                    $('#clickToFilePf').attr('log', data);

                    fineUploaderFunctField(data);
                }
            });
        }
        else
        {
            var varrrrrr = $('#clickToFilePf').attr('log');

            fineUploaderFunctField(varrrrrr);
        }

        field_fine_checker = true;
    }
});

$('#clickToFilePf-cancel').click(function()
{
    $('#clickToFilePf').show();
    $('#FieldUploader').hide();
    $(this).hide();


});

function fineUploaderFunctField(id)
{
    $('#fieldUploaderDiv').html('');

    $('#fieldUploaderDiv').fineUploader
    ({
        template: 'qq-audit-discrepancy-form-fine',
        request:
            {
                endpoint: 'audit_field_fine_uploader/' + id,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                // itemLimit: 3,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'wmv', 'mp3', 'mov', 'mkv', '3gp', 'txt']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        field_fine_array.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        field_fine_array.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    field_fine_array = [];
                    $('#FieldUploader').hide();
                    $('#clickToFilePf').show();
                    $('#clickToFilePf').attr('log', '');
                    $('#clickToFilePf-cancel').hide();
                    $('#modal-loading-arf-files').modal('hide');
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

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
                url: "audit_get_general_mon_table_ccbank",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min').val();
                    d.max_date_endorsed = $('#gen_mon_max').val();
                    d.ver_stats = $('#cc_bank_veri_stats').find(':selected').val();
                    d.sent_stats = $('#cc_bank_sent_status').find(':selected').val();
                    d.tele_id = $('#cc_bank_assigned_tele').find(':selected').val();
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
                {data: 'assigned_tele', name: 'bi_endorsements.id', orderable: 'false'},
                {data: 'assigned_tele_level', name: 'bi_endorsements.id', orderable: 'false'},
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
                url: "audit_get_general_mon_table_cc",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min_cc').val();
                    d.max_date_endorsed = $('#gen_mon_max_cc').val();
                    d.ver_stats = $('#cc_veri_stats').find(':selected').val();
                    d.sent_stats = $('#cc_sent_status').find(':selected').val();
                    d.tele_id = $('#cc_assigned_tele').find(':selected').val();
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
                {data: 'assigned_tele_level', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
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

$('.cc_bank_sorting').click(function()
{
    tele_ci_gen_table.draw();
});

$('.cc_sorting').click(function()
{
    tele_ci_gen_table2.draw();
});