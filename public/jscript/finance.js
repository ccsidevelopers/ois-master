var tableFinance;
var tableCiFundApproved;
var tableCiFundDeclined;
var tableFinanceExpensesReport;
var table_for_upload_online;
var title;
var i = 0;
var i_online = 0;
var i_expenses = 0;
var titleee_online  = [];
var titleee_expenses = [];
var fund_id;
var view_fund_id;
var tableATMMngt;
var atmID;
var which_is_active = 'finance_report_tab';
var finance_dashboard_tab_bool = false;
var finance_report_tab_bool = true;
var ci_fund_tab_bool = false;
// var finance_atm_tab_bool = false;
var finance_billing_manage_bool = false;
var finance_admin_requi_bool = false;
var countadd = 0;
var tableBankCiTable;
var table_bank = [];
var poiyu1 = 0;
var ciId;
var activeCiFund = 'tab_1';
var ci_fund_approved = true;
var ci_fund_online = false;
var ci_fund_success = false;
var title_billing_rep = [];
var billing_r_count = 0;
var tableBillingReport;
var tableBillingInfo;
var titleee_finance_report = [];
var titleee_finance_report_count = 0;
var global_finance_rem_atm = [];
var dataRemitance = [];
var dataATM = [];
var shellCardStat = [];
var global_finance_shell = [];
var checkifshell = false;
var checkatm = 0;
var refreshCiFund = false;
var checkifLoaded = 0;
var valWhere;
var atmWhere = '';
var statWhere;
var activeExpenses = 'tab_1';
var fa_fund_online = true;
var fa_ci_daily = false;
var activeBilling = 'tab_report';
var billing_rep = true;
var bi_info = false;
var bi_rate_andBank = false;
var counterReReq = false;
var fundIdReq;
var counterDone = false;
var fundIDliq;
var hidecolumnRem = 3;
var hidecolumnRem2 = 2;
var hidecolumnAtm = 4;
var hidecolumnShell = 5;
var checkRemOpen = false;
var checkAtmOpen = false;
var checkShellOpen = false;
var checkSelectBankOpen = false;
var checkifTableLoadOnline = false;
var counterSubmit = false;
var financeOnlineId;
var shellCounter = false;
var checkFArefresh = false;
var managementList = '';
var eq_process_table_1 = [];
var eq_pr_1 = 0;
var tableProcssEq1;
var requi_instruction_count = 0;
var activeProcMonFin = '#tabFinProc_1';
var eq_po_to_fin_1 = true;
var eq_po_to_fin_2 = false;
var eq_process_table_2 = [];
var eq_pr_2 = 0;
var tableProcssEq2;
var finrequiBool = false;
var cc_billing_rep = false;
var cc_bank_billing_rep = false;
var cc_billing_report_table = '';
var cc_bank_billing_report_table = '';
var cc_billing_table = '';
var tab_report_cc_table = false;
var cc_bank_billing_table =''
var tab_report_cc_bank_table = false;


$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(document).ready(function ()
{
    showFundCount();
    checkAccess();
    function checkAccess()
    {
        $.ajax
        ({
            type : 'get',
            url : 'finance-get-access',
            success : function(data)
            {
                console.log(data);
                if(data == 'Uploader')
                {
                    $('#clickUploadertoAccess').click();
                    $('#hideFaAccess').remove();
                    $('#hideBillingAccess').remove();
                }
                else if(data == 'FA')
                {
                    $('#clickFAToAccess').click();
                    $('#hideUploadertoAccess').remove();
                    $('#hideBillingAccess').remove();
                }
                else if(data == 'Billing')
                {
                    $('#clickBillingToAccess').click();
                    $('#hideFaAccess').remove();
                    $('#hideUploadertoAccess').remove();
                }
                else if(data == 'Head')
                {
                    $('#clickUploadertoAccess').click();
                }
                else
                {
                    $('#clickUploadertoAccess').click();
                }
            }
        });
    }

    $('.span2Rem').hide();
    $('#showHideBank').hide();
    $('#hideshowTable').hide();
    // finance_report_table();
    fund_request_approved_table();
    manageList();
    // finance_expenses_report_table();
    $('#arrayforDoneAll').hide();

    $('.finance_a_class').click(function ()
    {
        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#ci_fund_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'finance_dashboard_tab';

            }
            else if(finance_dashboard_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'finance_dashboard_tab';

            }
            else if(finance_dashboard_tab_bool == false)
            {
                finance_dashboard_tab_bool = true;
                which_is_active = 'finance_dashboard_tab';
            }
        }
        else if(gethref == '#finance_report_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'finance_report_tab';

            }
            else if(finance_report_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'finance_report_tab';
            }
            else if(finance_report_tab_bool == false)
            {
                finance_report_tab_bool = true;
                which_is_active = 'finance_report_tab';

            }
        }
        else if(gethref == '#fa_monitoring_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'fa_monitoring_tab';

            }
            else if(ci_fund_tab_bool)
            {
                if(checkFArefresh == true)
                {
                    tableFundFa.ajax.reload(null, false);
                    checkFArefresh = false;
                }
                else
                {
                    console.log('already loaded');
                }

                // }
                which_is_active = 'fa_monitoring_tab';

            }
            else if(ci_fund_tab_bool == false)
            {
                ci_fund_tab_bool = true;
                which_is_active = 'fa_monitoring_tab';
                // finance_expenses_report_table();
                faTablesCi();
            }
        }
        else if(gethref == '#billing_manage_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'billing_manage_tab';

            }
            else if(finance_billing_manage_bool)
            {
                console.log('already loaded');
                which_is_active = 'billing_manage_tab';

            }
            else if(finance_billing_manage_bool == false)
            {
                finance_billing_manage_bool = true;
                which_is_active = 'billing_manage_tab';
                billing_report_table();
            }
        }
        else if(gethref == '#finance_admin_requi')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'finance_admin_requi';

            }
            else if(finance_admin_requi_bool)
            {
                console.log('already loaded');
                which_is_active = 'finance_admin_requi';

            }
            else if(finance_admin_requi_bool == false)
            {
                finance_admin_requi_bool = true;
                which_is_active = 'finance_admin_requi';
                eqProcessTablePending();
            }
        }
    });



    $('#sendRemit').click(function () {
        $('#sendRemit').attr('disabled, disabled');
        var r = confirm("Are you sure want to send Remittance to C.I?");
        if (r == true) {
            $.ajax({
                method: 'get',
                url: '/finance-deliver-remit-req',
                data:
                    {
                        'id' : fund_id,
                        'branch_name' :  $('#Branch_name_remit_id').val(),
                        'receiver_remit': $('#Receiver_remit_id').val(),
                        'remit_code': $('#Remit_code_id').val(),
                        'amount_remit' : $('#Amount_remit_id').val(),
                        'sender_remit' : $('#Sender_remit_id').val(),
                        'remarks_remit' : $('#Remarks_remit_id').val()
                    },
                beforeSend: function (  data) {

                    $('#sendRemit').attr('disabled, disabled');
                    // $('#BtnDeliverFund').attr('disabled', 'disabled');

                },
                success: function (data)
                {
                    console.log('success');
                    // alert('Request declined.');
                    // tableCiFund.ajax.reload(null, false);
                    tableCiFundApproved.ajax.reload(null, false);
                    // tableCiFundDeclined.ajax.reload(null, false);
                },
                complete : function (data) {
                    $('#sendRemit').removeAttr('disabled');
                    // $('#BtnDeliverFund').removeAttr('disabled');
                },
                error : function (data) {
                    console.log('error')
                }


            });
        } else {
            alert('Deliver Cancelled');
        }
    });

    var options = [];
    // var oo = 0;


    select_type_func($('#selecttyp').val());

    $('#selecttyp').change(function () {
        select_type_func($(this).val());
    });

    $('#EditRemittance').click(function () {

        $('#view_Branch_name_remit_id').removeAttr('disabled');
        $('#view_Receiver_remit_id').removeAttr('disabled');
        $('#view_Remit_code_id').removeAttr('disabled');
        $('#view_Amount_remit_id').removeAttr('disabled');
        $('#view_Sender_remit_id').removeAttr('disabled');
        $('#view_Remarks_remit_id').removeAttr('disabled');
        $('#UpdateRemittance').removeAttr('disabled');

    });

    $('#UpdateRemittance').click(function () {

        $.ajax
        ({

            url : 'finance_update_remittance',
            type : 'get',
            data : {

                'id' : view_fund_id,
                'branch_name' : $('#view_Branch_name_remit_id').val(),
                'receiver_remit': $('#view_Receiver_remit_id').val(),
                'remit_code': $('#view_Remit_code_id').val(),
                'amount_remit' : $('#view_Amount_remit_id').val(),
                'sender_remit' : $('#view_Sender_remit_id').val(),
                'remarks_remit' : $('#view_Remarks_remit_id').val()

            },
            success : function (data) {

                alert('Update remittance success');
                $('#view_Branch_name_remit_id').attr('disabled','disabled');
                $('#view_Receiver_remit_id').attr('disabled','disabled');
                $('#view_Remit_code_id').attr('disabled','disabled');
                $('#view_Amount_remit_id').attr('disabled','disabled');
                $('#view_Sender_remit_id').attr('disabled','disabled');
                $('#view_Remarks_remit_id').attr('disabled','disabled');
                $('#UpdateRemittance').attr('disabled','disabled');
            }
        });

    });

    $('#btn_edi_atm_view').click(function () {
        $('#atm_Remarks_view').removeAttr('disabled');
        $('#Atm_amount_view').removeAttr('disabled');
        $('#atmselect').removeAttr('disabled');
        $('#btn_update_atm_view').removeAttr('disabled');
    });

    $('#btn_update_atm_view').click(function () {
        var id = view_fund_id;
        var atmselect =  $('#atmselect');
        var atmselect_option =  $('#atmselect option:selected');

        if(atmselect.val() == 'Select ATM')
        {
            alert('Please select ATM.')
        }
        else
        {
            $.ajax({
                url : 'finance_atm_update_fund',
                type : 'get',
                data : {
                    'fund_id' : id,
                    'amount' :  $('#Atm_amount_view').val(),
                    'atm' : atmselect.val(),
                    'atm_name_before' : atmselect_option.text(),
                    'remarks' : $('#atm_Remarks_view').val()
                },
                success : function (data) {
                    alert('Update atm success');

                    $('#atm_Remarks_view').attr('disabled','disabled');
                    $('#Atm_amount_view').attr('disabled','disabled');
                    $('#atmselect').attr('disabled','disabled');
                    $('#btn_update_atm_view').attr('disabled','disabled');
                }
            });
        }
    });

    $('#min').keyup( function() { tableFinance.draw(); } );
    $('#max').keyup( function() { tableFinance.draw(); } );
    $('#min').change( function() { tableFinance.draw(); } );
    $('#max').change( function() { tableFinance.draw(); } );

    $('#min').keyup( function() { tableFinance.draw(); } );
    $('#max').keyup( function() { tableFinance.draw(); } );
    $('#min').change( function() { tableFinance.draw(); } );
    $('#max').change( function() { tableFinance.draw(); } );

    $('#btnSaveAtmInfo').click(function ()
    {
        $('#btnSaveAtmInfo').attr('disabled',true);

        var selFCIName = $('#selFCIName').val();
        var txtBankName = $('#txtBankName').val();
        var txtAcctNum = $('#txtAcctNum').val();
        var txttype = $('#selecttyp').val();

        txtBankName = txtBankName.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"");
        txtAcctNum = txtAcctNum.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"");

        var form_data = new FormData();
        form_data.append('selFCIName',selFCIName);
        form_data.append('txtBankName',txtBankName);
        form_data.append('txtAcctNum',txtAcctNum);
        form_data.append('type',txttype);

        $.ajax
        ({
            url : 'finance-insert-ci-atm-info',
            type : 'post',
            processData: false,
            contentType: false,
            data: form_data,
            success : function (data)
            {
                if(data=='success')
                {
                    $('#btnSaveAtmInfo').attr('disabled',false);
                    alert('Successfully Save!');
                    tableATMMngt.ajax.reload(null,false);

                    $('#txtBankName').val('');
                    $('#txtAcctNum').val('');
                }
                else if(data=='filluperror')
                {
                    $('#btnSaveAtmInfo').attr('disabled',false);
                    alert('Please fill up all empty box!');
                    tableATMMngt.ajax.reload(null,false);
                }
                else if(data=='duplicated')
                {
                    $('#btnSaveAtmInfo').attr('disabled',false);
                    alert('Duplicated information. Please try again.');
                    tableATMMngt.ajax.reload(null,false);
                }
                else
                {
                    $('#btnSaveAtmInfo').attr('disabled',false);
                    alert('There was an error while saving the ATM Info, please try again!');
                    tableATMMngt.ajax.reload(null,false);
                }
            },
            error: function ()
            {
                $('#btnSaveAtmInfo').attr('disabled',false);
                alert('There was an error while saving the ATM Info, please try again!');
                tableATMMngt.ajax.reload(null,false);
            }
        });
    });

    $('#btnUpdAtmInfos').click(function ()
    {
        $('#btnUpdAtmInfos').attr('disabled',true);

        var selFCINameUpd = $('#selFCINameUpd').val();
        var txtBankNameUpd = $('#txtBankNameUpd').val();
        var txtAcctNumUpd = $('#txtAcctNumUpd').val();

        txtBankNameUpd = txtBankNameUpd.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"");
        txtAcctNumUpd = txtAcctNumUpd.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"");

        var form_data = new FormData();
        form_data.append('selFCINameUpd',selFCINameUpd);
        form_data.append('txtBankNameUpd',txtBankNameUpd);
        form_data.append('txtAcctNumUpd',txtAcctNumUpd);
        form_data.append('atmIDUpd',atmID);

        $.ajax
        ({
            url : 'finance-update-ci-atm-info',
            type : 'post',
            processData: false,
            contentType: false,
            data: form_data,
            success : function (data)
            {
                if(data == 'success')
                {
                    $('#btnUpdAtmInfos').attr('disabled',false);
                    alert('Successfully Updated!');
                    tableATMMngt.ajax.reload(null,false);

                    $('#selFCINameUpd').val('');
                    $('#txtBankNameUpd').val('');
                    $('#txtAcctNumUpd').val('');
                    $('#modal-finance-update-atm-info').modal('hide');
                }
                else if(data == 'filluperror')
                {
                    $('#btnUpdAtmInfos').attr('disabled',false);
                    alert('Please fill up all empty box!');
                    tableATMMngt.ajax.reload(null,false);
                }
                else
                {
                    $('#btnUpdAtmInfos').attr('disabled',false);
                    alert('There was an error while saving the ATM Info, please try again!');
                    tableATMMngt.ajax.reload(null,false);
                    $('#modal-finance-update-atm-info').modal('hide');
                }
            },
            error: function ()
            {
                $('#btnUpdAtmInfos').attr('disabled',false);
                alert('There was an error while saving the ATM Info, please try again!');
                tableATMMngt.ajax.reload(null,false);
                $('#modal-finance-update-atm-info').modal('hide');
            }
        });
    });

    $('#btnEditAtmInfos').click(function ()
    {
        if($('#txtBankNameUpd').val() == 'SHELL CARD')
        {
            $('#selFCINameUpd').removeAttr('disabled');
        }
        else
        {
            $('#selFCINameUpd').removeAttr('disabled');
            $('#txtBankNameUpd').removeAttr('disabled');
            $('#txtAcctNumUpd').removeAttr('disabled');
        }

    });


    // $(window).focus(function () {
    //
    //     console.log('focus');
    //     interval = true;
    // });

    // setInterval(function ()
    // {
    //     if(interval)
    //     {
    //         if(which_is_active == 'finance_report_tab')
    //         {
    //             tableFinance.ajax.reload(null, false);
    //
    //         }
    //         else if(which_is_active == 'ci_fund_tab')
    //         {
    //             // tableCiFund.ajax.reload(null, false);
    //
    //         }
    //     }
    // },60000);

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

                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                        tableBillingReport.ajax.reload(null, false);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('error');
                    }
                });

            }
            else if (ui.cmd === 'Unbill') {
                console.log('unbill');

                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                        tableBillingReport.ajax.reload(null, false);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
                // console.log(ids);
                tableBillingReport.ajax.reload(null, false);
            }
            else if(ui.cmd === 'Rule: #1')
            {
                var idrule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var stats = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var rates = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate
                });


                var appliedrule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                                tableBillingReport.ajax.reload(null, false);
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

                var idrule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var stats = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var rates = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var appliedrule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                                tableBillingReport.ajax.reload(null, false);
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
                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate - 100
                });

                var status = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var appliedrule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                                tableBillingReport.ajax.reload(null, false);
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
                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var status = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                                tableBillingReport.ajax.reload(null, false);
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
                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var status = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                                tableBillingReport.ajax.reload(null, false);
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
                var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var rate = $.map(tableBillingReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var rule = $.map(tableBillingReport.rows('.selected').data(), function (item) {
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
                        tableBillingReport.ajax.reload(null, false);
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

$('#table_fund_req_finance').on('click', '#BtnApproved', function (e) {
    // console.log('approved : '+$(this).attr('href'))

    var id = $(this).attr('href');
    var textareabtn = $('#textarea-'+$(this).attr('href')+'');
    var textarea = textareabtn.val();

    var r = confirm("Approve the request?");
    if (r == true) {
        $.ajax
        ({
            method: 'get',
            url: '/finance-apporoved-req',
            data:
                {
                    'id' : id,
                    'remarks' : textarea
                },
            beforeSend: function (data) {

                textareabtn.attr('disabled, disabled');
                $('#BtnApproved').attr('disabled', 'disabled');

            },
            success: function (data)
            {
                console.log('success');
                // alert('Request approved.');
                alert('Request Approved! Please proceed to "Approved Request Tab" for sending of remittance to C.I.');
                // tableCiFund.ajax.reload(null, false);
                tableCiFundApproved.ajax.reload(null, false);
                // tableCiFundDeclined.ajax.reload(null, false);
            },
            complete : function (data) {
                textareabtn.removeAttr('disabled');
                $('#BtnApproved').removeAttr('disabled');

            },
            error : function (data) {
                console.log('error')
            }
        });
    } else {
        alert('Approving request cancelled.');
    }




});

$('#table_fund_req_finance').on('click', '#BtnDeclined', function (e) {
    // console.log('declined : '+$(this).attr('href'))
    var id = $(this).attr('href');
    var textareabtn = $('#textarea-'+$(this).attr('href')+'');
    var textarea = textareabtn.val();

    var r = confirm("Disapprove the request?");
    if (r == true) {
        $.ajax
        ({
            method: 'get',
            url: '/finance-declined-req',
            data:
                {
                    'id' : id,
                    'remarks' : textarea
                },
            beforeSend: function (data) {

                textareabtn.attr('disabled, disabled');
                $('#BtnDeclined').attr('disabled', 'disabled');

            },
            success: function (data)
            {
                console.log('success');
                // alert('Request declined.');
                // tableCiFund.ajax.reload(null, false);
                // tableCiFundApproved.ajax.reload(null, false);
                tableCiFundDeclined.ajax.reload(null, false);
            },
            complete : function (data) {
                textareabtn.removeAttr('disabled');
                $('#BtnDeclined').removeAttr('disabled');
            },
            error : function (data) {
                console.log('error')
            }
        });
    } else {
        alert('Disapproving request cancelled.');
    }



});

// var pause_approved = false;
// $('#click_tab_approved').click(function () {
//
//     if(pause_approved == false)
//     {
//         pause_approved = true;
//         tableCiFundApproved.ajax.reload(null, false);
//         setTimeout(function () {
//             pause_approved = false;
//         },5000);
//     }
//
// });

$('#table_fund_req_approved_finance').on('click', '.BtnDeliverFund', function () {

    var ci_id_rem = $(this).val();

    if(global_finance_rem_atm[ci_id_rem] == 'true')
    {
        global_finance_rem_atm[ci_id_rem] = 'false';

        $(this).attr('class', "BtnDeliverFund btn btn-xs btn-info");
        $('#BtnciATMOptions-' + ci_id_rem +' ').show();

        $('#spanPrem-' + ci_id_rem +' ').show();
        // $('#remittance_approve-' + ci_id_rem +' ').val();
        $(this).html('Remittance');

        $('#span2Rem-' + ci_id_rem +' ').html('');
        $('#span2Rem-' + ci_id_rem +' ').hide();

        dataRemitance[ci_id_rem] = '';
        // checkatm--;
    }
    else
    {
        if($('#remittance_approve-' + ci_id_rem +'').val() == '' || $('#remittance_approve-' + ci_id_rem +'').val() == null)
        {
            alert('Please insert Remittance Information')
        }
        else if($('#remittance_approve-' + ci_id_rem +'').val() != '' || $('#remittance_approve-' + ci_id_rem +'').val() != null)
        {
            global_finance_rem_atm[ci_id_rem] = 'true';

            $(this).attr('class', "BtnDeliverFund btn btn-xs btn-success");
            $('#BtnciATMOptions-' + ci_id_rem +' ').hide();
            dataRemitance[ci_id_rem] = $('#remittance_approve-' + ci_id_rem +'').val().replace(/\n/g, "<br>");
            $('#spanPrem-' + ci_id_rem +' ').hide();
            $(this).html('Remittance On-Queue')

            $('#span2Rem-' + ci_id_rem +' ').html(dataRemitance[ci_id_rem]);
            $('#span2Rem-' + ci_id_rem +' ').show();

            checkatm++;
        }
        dataATM[ci_id_rem] = '';
    }



    // fund_id = $(this).attr('href');
    //
    // $('#modal_sent_remiitance_affirmative').modal('show');
    //
    // var get_remittance = $('#remittance_approve-'+fund_id+'').val().replace(/\n/g, "<br>");
    //
    //
    // $('#get_remittance_on_textarea').html(get_remittance);
});

$('#table_fund_req_approved_finance').on('change', '.BtnciATMOptions', function ()
{
    var selectId = $(this).attr('name');
    dataATM[selectId] = $(this).find(':selected').val();
    console.log(dataATM[selectId])
    if(dataATM[selectId] == '-')
    {
        $('#BtnDeliverFund-' + selectId +'').show();
        $('#remittance_approve-' + selectId +' ').attr('disabled', false);
        checkatm --;
    }
    else
    {
        $('#BtnDeliverFund-' + selectId +'').hide();
        $('#remittance_approve-' + selectId +' ').val('');
        $('#remittance_approve-' + selectId +' ').attr('disabled', true);
        checkatm++;
    }
});


$('#table_fund_req_approved_finance').on('click', '#btnAddFundToCi', function () {

    // alert('Process stops here because this module is still on development.');

    var fund_id = $(this).attr('href');
    var bashing = $(this).attr('name').split(':');
    var ci_id = bashing[0];
    var what = bashing[1];
    var ifshell = bashing[2];


    console.log(bashing);

    // // comment only because this is not done

    var r = confirm('Send this Fund to Credit Investigator?');
    if (r == true) {

        $.ajax
        ({
            type: 'get',
            url: '/finance-ci-receive-fund',
            data:
                {
                    'id' : fund_id,
                    'ci_id' : ci_id,
                    'what' : what,
                    'ifshell' : ifshell
                },
            success: function (data) {
                alert('Transaction Complete.');
                tableCiFundApproved.ajax.reload(null, false);
            },
            error: function (data) {
                console.log("fail");
            }
        });


    }
    else {
        alert('Cancelled');
    }


});

var remittance_edit_bool = [] ;
var get_remit_gloval = [];
var thisisit = [];
$('#table_fund_req_approved_finance').on('click', '#btn_view_remittance', function (e) {

    view_fund_id = $(this).attr('href');
    thisisit[view_fund_id] = $(this);
    // $('#view_Remarks_remit_id').html('');
    // $('#view_Branch_name_remit_id').attr('disabled','disabled');
    // $('#view_Receiver_remit_id').attr('disabled','disabled');
    // $('#view_Remit_code_id').attr('disabled','disabled');
    // $('#view_Amount_remit_id').attr('disabled','disabled');
    // $('#view_Sender_remit_id').attr('disabled','disabled');
    // $('#view_Remarks_remit_id').attr('disabled','disabled');
    // $('#UpdateRemittance').attr('disabled','disabled');

    // console.log('0000');

    //
    if(remittance_edit_bool[view_fund_id] == 'true')
    {
        // console.log('error ito?:'+$('#remittance_approve-'+view_fund_id+'').val());
        thisisit[view_fund_id].attr('disabled','disabled');
        var getthatbaby = $('#remittance_approve-'+view_fund_id+'').val().replace(/\n/g, "<br>");
        $.ajax({

            url : 'finance_update_remittance_info',
            type : 'get',
            data : {
                'id' : view_fund_id,
                'new_remittance' : getthatbaby
            },
            success :function (data) {
                thisisit[view_fund_id].removeAttr('disabled');
                $('#remit_col-'+view_fund_id+'').html('');
                $('#span_cancel_update-'+view_fund_id+'').html('');
                $('#remit_col-'+view_fund_id+'').html(getthatbaby);
                // console.log(getthatbaby);
                $('.btnAddFundToCi_class-'+view_fund_id+'').show();
                thisisit[view_fund_id].html('EDIT REMITTANCE');
                $('.shell_card_btn_class-'+view_fund_id+'').show();
                remittance_edit_bool[view_fund_id] = 'false';

            },
            error : function () {
                thisisit[view_fund_id].removeAttr('disabled');
                remittance_edit_bool[view_fund_id] = 'true';
            }

        });

    }
    else
    {
        get_remit_gloval[view_fund_id] = $('#remit_col-'+view_fund_id+'').html();
        console.log(get_remit_gloval);
        $('#remit_col-'+view_fund_id+'').html('<textarea id="remittance_approve-'+view_fund_id+'" style="width: 100%; height: 100px; margin: 0px;" placeholder="Remittance"></textarea>');
        $('#remittance_approve-'+view_fund_id+'').val(get_remit_gloval[view_fund_id].replace(/<br>/g, "\n"));
        $('.btnAddFundToCi_class-'+view_fund_id+'').hide();
        $('.shell_card_btn_class-'+view_fund_id+'').hide();
        thisisit[view_fund_id].html('UPDATE REMITTANCE INFO');
        remittance_edit_bool[view_fund_id] = 'true';
        $('#span_cancel_update-'+view_fund_id+'').html('<a href="'+view_fund_id+'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="" id="cancel_remit_update" style="width: 100%">CANCEL</a><br>');
    }





    // $.ajax({
    //
    //     url: 'finance_get_remiitance_view',
    //     type: 'get',
    //     data: {
    //         'id':view_fund_id
    //     },
    //     success:function (data) {
    //
    //         console.log(data[0].receiver);
    //
    //         $('#view_Branch_name_remit_id').val(data[0].branch_name);
    //         $('#view_Receiver_remit_id').val(data[0].receiver);
    //         $('#view_Remit_code_id').val(data[0].code);
    //         $('#view_Amount_remit_id').val(atob(data[0].amount));
    //         $('#view_Sender_remit_id').val(data[0].sender);
    //         $('#view_Remarks_remit_id').val(data[0].remarks);
    //
    //         if(data[0].receive_status == 'received')
    //         {
    //             $('#EditRemittance').css('display','none');
    //             $('#UpdateRemittance').css('display','none');
    //         }
    //         else
    //         {
    //             $('#EditRemittance').css('display','');
    //             $('#UpdateRemittance').css('display','');
    //         }
    //     },
    //     error:function (data) {
    //
    //     }
    // });

});

$('#table_fund_req_approved_finance').on('click', '#cancel_remit_update', function (e) {

    view_fund_id = $(this).attr('href');

    // console.log(thisisit[view_fund_id]);

    // thisisit[view_fund_id].removeAttr('disabled');
    $('#remit_col-'+view_fund_id+'').html('');
    $('#span_cancel_update-'+view_fund_id+'').html('');
    $('#remit_col-'+view_fund_id+'').html(get_remit_gloval[view_fund_id]);
    // console.log(getthatbaby);
    $('.btnAddFundToCi_class-'+view_fund_id+'').show();
    thisisit[view_fund_id].html('EDIT REMITTANCE');
    $('.shell_card_btn_class-'+view_fund_id+'').show();
    remittance_edit_bool[view_fund_id] = 'false';

});

$('#table_fund_req_approved_finance').on('click', '#BtnDeliverFund_ATM', function (e) {

    fund_id = $(this).attr('href');
    var options = '';
    // oo = 0;
    $('#atmselect_span').html('');
    $('#atmselect_span_view').html('');

    $.ajax({

        url : 'finance_get_atm_list',
        type : 'get',
        data : {
            'id' : fund_id
        },
        success : function (data) {
            for(var ctr=0; ctr<data[0].length; ctr++)
            {

                if(data[0][ctr].name != "SHELL CARD")
                {
                    options += '<option value="'+data[0][ctr].id+'">'+data[0][ctr].name+'</option>'
                }
                // get_options += options[ctr];
            }

            // console.log(data);
            $('#atmselect_span').html('<select id="atmselect" class="atmselect form-control" style="width: 100%"><option id="no selection" value="Select ATM" style="color: grey">(Select ATM)</option>'+options+'</select>');

            // console.log('success');


        },
        error : function () {
            console.log('error');
        }

    });
});

$('#table_fund_req_approved_finance').on('click', '#btn_view_atm', function (e) {

    view_fund_id = $(this).attr('href');
    $('#btn_update_atm_view').attr('disabled','disabled');
    // $('#Atm_amount_view').attr('disabled','disabled');
    // $('#atm_Remarks_view').attr('disabled','disabled');

    fund_id = $(this).attr('href');
    options = '';
    // oo = 0;

    $('#atmselect_span').html('');
    $('#atmselect_span_view').html('');

    $.ajax({

        url : 'finance_get_atm_list',
        type : 'get',
        data : {
            'id' : fund_id
        },
        success : function (data) {

            for(var ctr=0; ctr<data[0].length; ctr++)
            {
                if(data[0][ctr].name != "SHELL CARD")
                {
                    options += '<option value="'+data[0][ctr].id+'">'+data[0][ctr].name+'</option>'
                }
            }

            $('#atmselect_span_view').html('<select id="atmselect" class="atmselect form-control" style="width: 100%"><option id="no selection" value="Select ATM" style="color: grey">(Select ATM)</option>'+options+'</select>');


            $('#atmselect').val(data[1][0].ci_atm_id);
            $('#atmselect').attr('disabled','disabled');
            if(data[1][0].receive_status == 'received')
            {
                $('#btn_edi_atm_view').css('display','none');
                $('#btn_update_atm_view').css('display','none');
            }
            else
            {
                $('#btn_edi_atm_view').css('display','');
                $('#btn_update_atm_view').css('display','');
            }

        },
        error : function () {
            console.log('error');
        }
        // complete : function () {
        //     $.ajax({
        //
        //         url: 'finance_get_atm_view',
        //         type: 'get',
        //         data: {
        //
        //             'id':view_fund_id
        //         },
        //         success:function (data) {
        //
        //             // $('#atm_Remarks_view').val(data[0].remarks);
        //             // $('#Atm_amount_view').val(data[0].amount);
        //             // $('#atmselect').val(data[0].ci_atm_id);
        //
        //         },
        //         error:function (data) {
        //
        //         }
        //     });
        // }
    });
});

$('#table_fund_req_approved_finance').on('click', '#btn_show_modal_shell', function ()
{
    var shell = $(this).attr('name');
    var id_fund = $(this).attr('href');


    if(global_finance_shell[id_fund] == 'true')
    {
        global_finance_shell[id_fund] = 'false';
        shellCardStat[id_fund] = '';
        $(this).html('INCLUDE SHELL CARD');
        checkifshell = false;
    }
    else
    {
        global_finance_shell[id_fund] = 'true';
        shellCardStat[id_fund] = shell;

        $(this).html('SHELL INCLUSION ON-QUEUE');
        checkifshell = true;
    }

});

$('#finance-table-ci-atm-management').on('click','#btnUpdateAtm', function () {
    atmID = $(this).attr('value');
    $('#selFCINameUpd').attr('disabled',true);
    $('#txtBankNameUpd').attr('disabled',true);
    $('#txtAcctNumUpd').attr('disabled',true);

    $.ajax
    ({
        url : 'finance-modal-get-ci-atm-info',
        type : 'get',
        data:
            {
                'atmID': atmID
            },
        success : function (data)
        {
            $('#selFCINameUpd').val('');
            $('#txtBankNameUpd').val('');
            $('#txtAcctNumUpd').val('');

            if(data[0].bank_name == 'SHELL CARD')
            {
                $('#txtAcctNumUpd').css('display','none');
                $('#label_txtAcctNumUpd').css('display','none');
            }
            else
            {
                $('#txtAcctNumUpd').css('display','');
                $('#label_txtAcctNumUpd').css('display','');

            }

            $('#selFCINameUpd').val(data[0].id).change();
            $('#txtBankNameUpd').val(data[0].bank_name);
            $('#txtAcctNumUpd').val(data[0].account_number);
        }
    });
});

$('#finance-table-ci-atm-management').on('click','#btnRemoveAtm', function () {
    $('#finance-table-ci-atm-management').attr('disabled','#btnRemoveAtm',true);
    atmID = $(this).attr('value');

    if(confirm('Do you want to remove this ATM?'))
    {
        $.ajax
        ({
            url : 'finance-delete-ci-atm-info',
            type : 'post',
            data:
                {
                    'atmID': atmID
                },
            success : function (data)
            {
                if(data=='success')
                {
                    $('#btnRemoveAtm').attr('disabled',false);
                    alert('ATM Successfully Removed from CI');
                    tableATMMngt.ajax.reload(null,false);
                }
            }
        });
    }
});

function finance_expenses_report_table() {

    $('#table-finance-expenses-report thead th').each(function()
    {
        titleee_expenses[i_expenses] = $(this).text();
        i_expenses++;
        title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });
    tableFinanceExpensesReport = $('#table-finance-expenses-report').DataTable({
        dom: 'Bfrtip',
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
                                        return titleee_expenses[(idx)];
                                    },
                                    body: function (data,row,column) {
                                        // Strip $ from salary column to make it numeric
                                        if(column <= 9)
                                        {
                                            return data.replace( /<br\s*\/?>/ig, "\r\n");
                                        }
                                        // data;
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
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee_expenses[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": 'finance_get_expenses_report_table',

        "ajax" : {
            "url" : 'finance_get_expenses_report_table',
            "type" : 'post'
        },
        "columns":
            [
                {data: 'id', name: 'ci_daily_expenses_date.id'},
                {data: 'ci_name', name: 'users.name'},
                {data: 'date', name: 'ci_daily_expenses_date.date'},
                {data: 'label_edit', name: 'ci_daily_expenses.label'},
                {data: 'amount_edit', name: 'ci_daily_expenses.amount'},
                {data: 'from_edit', name: 'ci_daily_expenses.from'},
                {data: 'amount_total_edit', name: 'ci_daily_expenses.amount'},
                {data: 'or_edit', name: 'ci_daily_expenses.or_attachment'},
                {data: 'remarks_edit', name: 'ci_daily_expenses.remarks'},
                {data: 'account_edit', name: 'endorsements.type_of_request'},
                {
                    data: function (data) {
                        return '<button type="button" id="btn_download_or" name="'+data.id+'" value="'+data.ci_id+'" data-target="'+data.ci_name+'" data="'+data.date+'" class="btn btn-info btn-xs btn-block">Download O.R </button>' +
                            '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Remarks</button>' +
                            '<button class="btn btn-info">View Logs</button>';
                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'ci_daily_expenses.remarks'

                }
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
                tableFinanceExpensesReport.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFinanceExpensesReport.search($(this).val()).draw();
                }
            }
        }
    });

    $('#table-finance-expenses-report').on('click','#btn_download_or', function () {

        var id = $(this).attr('name');
        var ci_id = $(this).attr('value');
        var ci_name = $(this).attr('data-target');
        var date_time = $(this).attr('data');

        // console.log(id+' '+ci_id+' '+ci_name+' '+date_time);

        download_file_expenses_func(id,ci_id,ci_name,date_time);

    });

}

function download_file_expenses_func(id, ci_id,ci_name,date_time) {

    var id = btoa(id);
    var ci_id = btoa(ci_id);
    var ci_name = btoa(ci_name);
    var date_time = btoa(date_time);

    var q = '<form action="/finance_download_file_expenses" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id+'" name="id">'+
        '<input type="text" hidden value="'+ci_id+'" name="ci_id">'+
        '<input type="text" hidden value="'+ci_name+'" name="ci_name">'+
        '<input type="text" hidden value="'+date_time+'" name="date_time">'+
        '<button type="submit" id="button_form_download">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#download_expense_file').html(q);

    $('#button_form_download').click();

}

function finance_report_table() {

    $('#finance-table-reports thead th').each(function()
    {
        titleee_finance_report[titleee_finance_report_count] = $(this).text();
        titleee_finance_report_count++;
        title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });
    tableFinance = $('#finance-table-reports').DataTable({
        dom: 'Bfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    title: 'Finance Report',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'excel',
                    title: 'Finance Report',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'print',
                    title: 'Finance Report',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee_finance_report[(idx)];
                    }
                }
            ],
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "autoWidth": true,
        "ajax":
            {
                url: "/finance-table-report",
                data: function (d)
                {
                    d.min_date_endorsed = $('#min').val();
                    d.max_date_endorsed = $('#max').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'client_name', name: 'client_name'},
                {data: 'date_endorsed', name: 'date_endorsed'},
                {data: 'time_endorsed', name: 'time_endorsed'},
                {data: 'account_name', name: 'account_name'},
                {data: 'address', name: 'address'},
                {data: 'city_muni', name: 'city_muni'},
                {data: 'provinces', name: 'provinces'},
                {data: 'type_of_request', name: 'type_of_request'},
                {data: 'handled_by_account_officer', name: 'handled_by_account_officer'},
                {data: 'handled_by_credit_investigator', name: 'handled_by_credit_investigator'},
                {
                    data: function dateTimeAOReported(data)
                    {
                        return data.date_forwarded_to_client+' '+data.time_forwarded_to_client;
                    },
                    "name": 'date_forwarded_to_client'
                },
                {data: 'endorsement_status_external', name: 'endorsement_status_external'}
            ],
        "order": [[1, 'desc']],
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

    $('#finance-table-reports_filter input').unbind();
    $('#finance-table-reports_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFinance.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFinance.search($(this).val()).draw();
                }
            }
        }
    });

}

function finance_for_online_upload_table()
{
    $('#table_fund_for_online_upload thead th').each(function()
    {
        titleee_online[i_online] = $(this).text();
        i_online++;
        title = $(this).text();
        $(this).html(title);

    });

    var kuku = 0; //column
    var col_counter = 'wala pa to';

    table_for_upload_online = $('#table_fund_for_online_upload').DataTable
    ({
        dom: 'Bfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Approved Requests',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx)
                                    {
                                        if (dt == 'Action')
                                        {
                                            return ''
                                        }
                                        else
                                        {
                                            return titleee_online[(idx)];
                                        }
                                    },
                                    body: function(data, column)
                                    {

                                        if(column != col_counter)
                                        {
                                            col_counter = column;
                                            kuku = 0;
                                        }
                                        else
                                        {
                                            kuku++;
                                        }

                                        console.log(data+' : '+column+' : '+kuku);

                                        if(data.indexOf('btnDoneFundRequest') > 0)
                                        {
                                            // console.log('i got action');
                                            return '';
                                        }
                                        else
                                        {
                                            if ($('#btnSortCiApproved').val() == 'ATM')
                                            {
                                                if(kuku <= 3)
                                                {
                                                    var get_dat = data.replace( /<br\s*\/?>/ig, "\r\n");
                                                    return '\0'+get_dat;
                                                }
                                                else if(kuku == 4)
                                                {
                                                    return parseInt(data);
                                                }
                                                else
                                                {
                                                    return data;
                                                }
                                            }
                                            else if ($('#btnSortCiApproved').val() == 'REMITTANCE')
                                            {
                                                if(kuku <= 2)
                                                {
                                                    var get_dat = data.replace( /<br\s*\/?>/ig, "\r\n");
                                                    return '\0'+get_dat;
                                                }
                                                else if(kuku == 4)
                                                {
                                                    return parseInt(data);
                                                }
                                                else
                                                {
                                                    return data;
                                                }
                                            }

                                        }
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

                        if($('#btnSortCiApproved').val() == 'ATM')
                        {
                            console.log('ATM');
                            $('row c[r^="E"]', sheet).attr('s','63');
                            // $('row c[r^="F"]', sheet).text('');
                        }
                        else if($('#btnSortCiApproved').val() == 'REMITTANCE')
                        {
                            console.log('REMITTANCE');
                            $('row c[r^="D"]', sheet).attr('s','63');
                            // $('row c[r^="E"]', sheet).text('');
                        }
                        kuku = 0;
                    }
                },
                // {
                //     extend: 'colvis',
                //     text: 'Show/Hide Column',
                //     columnText: function (dt, idx, title)
                //     {
                //         return titleee_online[(idx)];
                //     }
                // },

            ],

        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": 'table_for_online_upload',

        "ajax":
            {
                type: 'get',
                url: "/table_for_online_upload",
                data: function (d)
                {
                    d.data = valWhere;
                    d.whereAm = atmWhere;
                    d.statQue = statWhere;
                }
            },
        "columns":
            [
                {data: 'sao_date', name: 'fund_requests.sao_approved_date'},
                {data: 'name_ci', name: 'ci_id.name'},
                {data: 'what_action', name: 'ci_atms.bank_name'},
                {data: 'remit_info', name: 'remittance.remittance_info'},
                {data: 'bank_info', name: 'ci_atms.account_number'},
                {data: 'fund_amount', name: 'action', "orderable": false, "searchable": false},
                {
                    data : function action(data)
                    {
                        var tor = '';

                        if(data.type_fund == 'NORMAL REQUEST')
                        {
                            tor = 'normal';
                        }
                        else if(data.type_fund == 'EMERGENCY FUND')
                        {
                            tor = 'emergency';
                        }

                        return '<span class ="idsTODone" name = "'+data.id+'" href = "'+data.name_ci+ '|' + data.sao_name + '|' + data.disp_name+'" id = "'+tor+'" ></span>' +
                            '<button  id = "done-'+data.id+'" class = "btnDoneFundRequest btn btn-block btn-xs btn-primary" name = "'+data.id+'" style = "margin-bottom: 10px;">Done</button>' +
                            '<button class = "btnReviseFundRequest btn btn-block btn-xs btn-warning" name = "'+data.id+'"  style = "margin-bottom: 10px;" id = "rev-'+data.id+'">Revise</button>' +
                            '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Remarks</button>';


                    },
                    name : '',
                    "orderable": false, "searchable": false
                },
                {data : 'employee', name : 'fund_requests.id', visible: false},
            ],
        "order": [[0, 'desc']],
        "pageLength": -1,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        // "aoColumnDefs": [{ "bVisible": false, "aTargets": [6] }],
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

    $('#table_fund_for_online_upload_filter input').unbind();
    $('#table_fund_for_online_upload_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_for_upload_online.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '')
                {
                    table_for_upload_online.search($(this).val()).draw();
                }
            }
        }
    });


}



// function ci_fund_request_table() {
//     $('#finance-table-ci-atm-management thead th').each(function()
//     {
//         titleee[i] = $(this).text();
//         i++;
//         titl = $(this).text();
//         $(this).html(titl+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
//
//     });
//     tableATMMngt = $('#finance-table-ci-atm-management').DataTable({
//
//         dom: 'Blfrtip',
//         buttons:
//             [
//                 {
//                     extend: 'pdf',
//                     orientation: 'landscape',
//                     pageSize: 'LEGAL',
//                     exportOptions:
//                         {
//                             columns: ':visible',
//                             format:
//                                 {
//                                     header:  function (dt, idx, title)
//                                     {
//                                         return titleee[(idx)];
//                                     }
//                                 }
//                         }
//                 },
//                 {
//                     extend: 'excel',
//                     exportOptions:
//                         {
//                             columns: ':visible',
//                             format:
//                                 {
//                                     header:  function (dt, idx, title)
//                                     {
//                                         return titleee[(idx)];
//                                     }
//                                 }
//                         }
//                 },
//                 {
//                     extend: 'print',
//                     exportOptions:
//                         {
//                             columns: ':visible',
//                             format:
//                                 {
//                                     header:  function (dt, idx, title)
//                                     {
//                                         return titleee[(idx)];
//                                     }
//                                 }
//                         }
//                 },
//                 {
//                     extend: 'colvis',
//                     text: 'Show/Hide Column',
//                     columnText: function (dt, idx, title)
//                     {
//                         return titleee[(idx)];
//                     }
//                 }
//             ],
//         "processing": true,
//         "serverSide": true,
//         "autoWidth": true,
//         "ajax": "/finance-get-ci-atm-info",
//         "columns":
//             [
//                 {data: 'id', name: 'id'},
//                 {data: 'name', name: 'name'},
//                 {data: 'bank_name', name: 'bank_name'},
//                 {data: 'account_number', name: 'account_number'},
//                 {
//                     data: function actions(data)
//                     {
//
//                         return '<div class="btn-group">'+
//                             '<button type="button" class="btn btn-info" value="'+data.id+'" id="btnUpdateAtm" data-toggle="modal" data-target="#modal-finance-update-atm-info">Update</button>'+
//                             '<button type="button" class="btn btn-danger" value="'+data.id+'" id="btnRemoveAtm">Remove</button>'+
//                             '</div>';
//
//                     },
//                     "orderable": false,
//                     "searchable": false,
//                     "name": 'action'
//                 }
//
//             ],
//         "order": [[0, 'desc']],
//         "pageLength": 10,
//         "bSortClasses": false,
//         initComplete: function()
//         {
//             var api = this.api();
//
//             // Apply the search
//             api.columns().every(function() {
//                 var that = this;
//
//                 $('input', this.header()).on('keyup change', function(e)
//                 {
//                     if($(this).is(':focus'))
//                     {
//                         if(e.keyCode === 13)
//                         {
//                             if (that.search() !== this.value) {
//                                 that
//                                     .search(this.value)
//                                     .draw();
//                             }
//                         }
//                         else if (e.keyCode === 8)
//                         {
//                             if (this.value == '') {
//                                 that
//                                     .search(this.value)
//                                     .draw();
//                             }
//                         }
//                     }
//                 });
//             });
//         }
//
//     });
//
//     $('#finance-table-ci-atm-management_filter input').unbind();
//     $('#finance-table-ci-atm-management_filter input').bind('keyup change',function (e) {
//
//         if($(this).is(':focus'))
//         {
//             if (e.keyCode == 13) {
//                 tableATMMngt.search($(this).val()).draw();
//             }
//             else if (e.keyCode === 8)
//             {
//                 if ($(this).val() == '') {
//                     tableATMMngt.search($(this).val()).draw();
//                 }
//             }
//         }
//     });
//
// }

function select_type_func(opop) {
    console.log(opop);

    if(opop == 'ATM')
    {
        $('#label_bank_name').removeAttr('hidden');
        $('#txtBankName').css('display','');

        $('#label_bank_accountNo').removeAttr('hidden');
        $('#txtAcctNum').css('display','');
    }
    else if(opop == 'Shell Card')
    {
        $('#label_bank_name').attr('hidden','hidden');
        $('#txtBankName').css('display','none');

        // $('#label_bank_accountNo').attr('hidden','hidden');
        $('#txtAcctNum').css('display','block');
    }
}

var this_update = [];
var this_update_text = [];

$('#table_fund_req_approved_finance').on('click','#update_fund_remarks',function () {

    var fund_id = $(this).attr('name');
    this_update[fund_id] = $(this);
    this_update_text[fund_id] = $('#updated_fund_remarks_span-'+fund_id+'').html().replace(/<br>/g, "\n");
    if($(this).attr('value') == 'edit')
    {
        $('#update_fund_remarks_span-'+fund_id+'').html('<textarea id="remarks_approve-'+fund_id+'" style="width: 100%; height: 100px; margin: 0px;" placeholder="Enter Remarks Here."></textarea>');
        $('#remarks_approve-'+fund_id+'').val(this_update_text[fund_id]);
        $('#updated_fund_remarks_span-'+fund_id+'').hide();
        $(this).html('Update Remarks');
        $(this).attr('value','update');
        $('.cancel_fund_remarks').each(function () {

            if($(this).attr('name') == fund_id)
            {
                $(this).show();
            }

        });
    }
    else if($(this).attr('value') == 'update')
    {
        var get_updated = $('#remarks_approve-'+fund_id+'').val().replace(/\n/g, "<br>");
        $('#update_fund_remarks_span-'+fund_id+'').html('');
        $('#updated_fund_remarks_span-'+fund_id+'').show();
        $(this).html('Edit Remarks');
        $(this).attr('value','edit');
        $('.cancel_fund_remarks').each(function () {

            if($(this).attr('name') == fund_id)
            {
                $(this).hide();
            }

        });

        $.ajax({

            url : 'finance_update_realtime_remarks',
            type : 'get',
            data : {
                'fund_id' : fund_id,
                'remarks_fund' : get_updated
            },
            beforeSend : function () {
                $('.btn_edit_remarks_qq').each(function () {
                    $(this).attr('disabled','disabled');
                });
            },
            success : function (data) {

                console.log(data);
                $('#date_time_remarks_update_span-'+data[0]+'').html(data[2]);
                $('#updated_fund_remarks_span-'+data[0]+'').html(data[1]);
            },
            error : function () {
                console.log('error');
            },
            complete : function () {
                $('.btn_edit_remarks_qq').each(function () {
                    $(this).removeAttr('disabled');
                });
            }

        });
    }

});

$('#table_fund_req_approved_finance').on('click','#cancel_fund_remarks',function () {

    var fund_id = $(this).attr('name');

    $('#update_fund_remarks_span-'+fund_id+'').html('');
    this_update[fund_id].html('Edit Remarks');
    this_update[fund_id].attr('value','edit');
    $('#updated_fund_remarks_span-'+fund_id+'').show();
    $(this).hide();


});


$('#add_bank_ci').click(function(e)
{
    countadd ++;
    e.preventDefault();
    var addInput = ' <div class = "row" style = "padding-top: 20px; padding-bottom: 20px;" >\n' +
        '                                <div class = "col-md-5">\n' +
        '                                    <label for="">Bank Name:</label>\n' +
        '                                    <input type="text" name="'+countadd+'" class = "ci_bank_name form-control">\n' +
        '                                 </div>\n' +
        '                                <div class = "col-md-1"></div>\n' +
        '                                <div class = "col-md-5">\n' +
        '                                    <label for="">Account Number:</label>\n' +
        '                                    <input type="text" id="b_a-'+countadd+'" class = "ci_bank_acct form-control">\n' +
        '                                </div>\n' +
        // '                                <div class = "col-md-1">\n' +
        '                                    <button type = "button" class = "btn btn-danger" id = "removeItem-'+countadd+'" ><i class = "fa fa-fw fa-minus"></i></button>\n' +
        // '                                </div>\n' +
        '\n' +
        '                            </div>';
    $('#addDetailsBank').append(addInput);
    $('#removeItem-'+countadd+'').click(function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });
});
$('#selFCIName').change(function()
{
    $('#ci_id_no_form').val($(this).val());
    ciId = $('#selFCIName').val();
    checkShell();
});
function checkShell()
{

    $.ajax
    ({
        type : 'get',
        url : 'finance-check-shell-ci',
        data :
            {
                'ciId' : ciId
            },
        success : function(data)
        {
            console.log(data);

            if(data > 0)
            {
                $('#showShell').html('')
                shellCounter = false;
            }
            else
            {
                var shellshow = '<h4 style = "font-family: Georgia,serif; text-align: center">Shellcard</h4>\n' +
                    '                            <div class = "row" style = "padding-top : 10px; padding-bottom : 20px;">\n' +
                    '                                <div class = "col-md-5">\n' +
                    '                                    <label for="">Account number:</label>\n' +
                    '                                    <input type="text" id = "ci_shell_account" class = "form-control">\n' +
                    '                                </div>\n' +
                    '                                <div class = "col-md-2"></div>\n' +
                    '                                <div class = "col-md-5">\n' +
                    '                                    <label for="">Gasoline Limit <small style = "color : red">*required field</small></label>\n' +
                    '                                    <input type="number" class = "form-control" id = "ci_gas_limit">\n' +
                    '                                </div>\n' +
                    '                            </div>';
                $('#showShell').html(shellshow)
                shellCounter = true;
            }
        }
    });
}
$('#btnSaveCiAtmRem').click(function()
{
    var myData = {};
    var btn = $(this);
    btn.attr('disabled', true);

    console.log(ciId);
    console.log(shellCounter);
    var shellAccount = $('#ci_shell_account').val();
    var gasLimit = $('#ci_gas_limit').val();
    var bankNames = '';
    var bankAccounts = '';

    $('.ci_bank_name').each(function ()
    {
        bankNames = $(this).val();
        var countable = $(this).attr('name');

        bankAccounts = $('#b_a-'+countable+'').val();

        myData[bankNames] = bankAccounts;
    });
    console.log(shellAccount);

    if(shellCounter == false)
    {
        if(ciId != null)
        {
            $.ajax
            ({
                type : 'post',
                url : 'finance-insert-ci-bank-shell',
                data :
                    {
                        myData : myData,
                        'ciId' : ciId,
                        'shellAccount' : shellAccount,
                        'gasLimit' : gasLimit
                    },
                success : function(data)
                {
                    console.log(data);
                    // alert('Successfully Added!');
                    $('#selFCIName').val('');
                    $('#ci_shell_account').val('');
                    $('#ci_gas_limit').val('');
                    $('.ci_bank_name').val('');
                    $('.ci_bank_acct').val('');
                    $('#addDetailsBank').html('');
                    checkShell();
                    tableBankCiTable.ajax.reload(null, false);
                    btn.attr('disabled', false);
                    refreshCiFund = true;
                }
            })
        }
        else
        {
            alert('Please select FCI.');
            btn.attr('disabled', false);
        }
    }
    else if(shellCounter == true)
    {
        if(shellAccount != '')
        {
            if(gasLimit == '')
            {
                alert('Please indicate gas limit for ShellCard');
                btn.attr('disabled', false);
            }
            else
            {
                if(ciId != null)
                {
                    $.ajax
                    ({
                        type : 'post',
                        url : 'finance-insert-ci-bank-shell',
                        data :
                            {
                                myData : myData,
                                'ciId' : ciId,
                                'shellAccount' : shellAccount,
                                'gasLimit' : gasLimit
                            },
                        success : function(data)
                        {
                            console.log(data);
                            // alert('Successfully Added!');
                            $('#selFCIName').val('');
                            $('#ci_shell_account').val('');
                            $('#ci_gas_limit').val('');
                            $('.ci_bank_name').val('');
                            $('.ci_bank_acct').val('');
                            $('#addDetailsBank').html('');
                            checkShell();
                            tableBankCiTable.ajax.reload(null, false);
                            btn.attr('disabled', false);
                            refreshCiFund = true;
                        }
                    })
                }
                else
                {
                    alert('Please select FCI.');
                    btn.attr('disabled', false);
                }
            }
        }
        else
        {
            if(ciId != null)
            {
                $.ajax
                ({
                    type : 'post',
                    url : 'finance-insert-ci-bank-shell',
                    data :
                        {
                            myData : myData,
                            'ciId' : ciId,
                            'shellAccount' : shellAccount,
                            'gasLimit' : gasLimit
                        },
                    success : function(data)
                    {
                        console.log(data);
                        // alert('Successfully Added!');
                        $('#selFCIName').val('');
                        $('#ci_shell_account').val('');
                        $('#ci_gas_limit').val('');
                        $('.ci_bank_name').val('');
                        $('.ci_bank_acct').val('');
                        $('#addDetailsBank').html('');
                        checkShell();
                        tableBankCiTable.ajax.reload(null, false);
                        btn.attr('disabled', false);
                        refreshCiFund = true;
                    }
                })
            }
            else
            {
                alert('Please select FCI.');
                btn.attr('disabled', false);
            }
        }

    }





});
function ciInfofill()
{
    $.ajax
    ({
        type : 'get',
        url : 'finance-get-ci-list',
        success : function(data)
        {
            var j;
            var ciList = '';
            for (j = 0; j < data.length; j++)
            {
                ciList += '<option value="' + data[j].id + '">' + data[j].name + '</option>';
            }
            $('#selFCIName').html(ciList);
            $('#selFCIName').val('');
        }
    });
}
function bankCItable() {
    $('#finance-ci-bank-table thead th').each(function () {
        table_bank[poiyu1] = $(this).text();
        poiyu1++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableBankCiTable = $('#finance-ci-bank-table').DataTable
    ({

        dom: 'Blfrtip',

        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'Bank Information for CI',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table_bank[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Bank Information for CI',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table_bank[(idx)];
                                    }
                                }
                        },
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'print',
                    title: 'Bank Information for CI',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table_bank[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "finance-table-ci-bank",
        "columns":
            [
                {data: 'id', name: 'users.id'},
                {data: 'name', name: 'users.name'},
                {data: 'bank', name: 'ci_atms.bank_name'},
                {data: 'acct', name: 'ci_atms.account_number'},
                {
                    data: function gas(data) {
                        // console.log(data);
                        if (data.gas != '') {
                            return data.gas;
                        }
                        else {
                            return 'N/A';
                        }
                    },
                    "name": 'ci_shell_card_info.shell_gas_limit',

                },
                {
                    data: function act(data) {

                        return '<button type="button" id="btn_delete_this_atm" name="'+data.atm_id+'" class="btn btn-danger btn-xs btn-block">Delete</button>';

                    },
                    "name": 'ci_shell_card_info.shell_gas_limit',
                    'searchable' : false,
                    'orderable' : false,

                }
            ],
        "columnDefs":[{"className": "dt-center", "targets": "_all"}],
        "order": [[0, 'asc']],
        "pageLength": 25,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        'rowsGroup': [0, 1, 2, 3, 4],

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
    $('#finance-ci-bank-table_filter').find('input').unbind();
    $('#finance-ci-bank-table_filter').find('input').bind('keyup change', function (e) {
        if ($(this).is(':focus')) {
            if (e.keyCode == 13) {
                tableBankCiTable.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '') {
                    tableBankCiTable.search($(this).val()).draw();
                }
            }
        }
    });

    $('#finance-ci-bank-table').on('click','#btn_delete_this_atm', function () {

        var id = $(this).attr('name');
        var btn = $(this);
        btn.attr('disabled', true);

        $.ajax({

            url : 'finance_btn_delete_this_atm',
            type : 'post',
            data : {
                'id': id
            },
            success : function (data)
            {
                btn.attr('disabled', false);
                tableBankCiTable.ajax.reload();
                console.log(data);
                if(ciId != null)
                {
                    if(data[1] == ciId)
                    {
                        if(data[0] == 0)
                        {
                            var shellshow = '<h4 style = "font-family: Georgia,serif; text-align: center">Shellcard</h4>\n' +
                                '                            <div class = "row" style = "padding-top : 10px; padding-bottom : 20px;">\n' +
                                '                                <div class = "col-md-5">\n' +
                                '                                    <label for="">Account number:</label>\n' +
                                '                                    <input type="text" id = "ci_shell_account" class = "form-control">\n' +
                                '                                </div>\n' +
                                '                                <div class = "col-md-2"></div>\n' +
                                '                                <div class = "col-md-5">\n' +
                                '                                    <label for="">Gasoline Limit <small style = "color : red"></small></label>\n' +
                                '                                    <input type="number" class = "form-control" id = "ci_gas_limit">\n' +
                                '                                </div>\n' +
                                '                            </div>';
                            $('#showShell').html(shellshow);
                            shellCounter = true;
                        }
                        else
                        {
                            $('#showShell').html('');
                            shellCounter = false;
                        }
                    }
                    else if(data[1] != ciId)
                    {

                    }
                }
                else
                {

                }
            },
            error: function () {
                console.log('error');
            }

        });

    });
}
$('.finance_ci_fund_class').click(function ()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tab_1')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeCiFund = 'tab_1';
        }
        else if (ci_fund_approved)
        {
            console.log(counterReReq);
            if(counterReReq == true)
            {
                tableCiFundApproved.ajax.reload(null, false);
                counterReReq = false;
            }
            else
            {
                console.log('already loaded');
            }

            activeCiFund = 'tab_1';
        }
        else if (ci_fund_approved == false)
        {
            ci_fund_approved = true;
            activeCiFund = 'tab_1';
        }
    }
    else if (gethref == '#tab_2')
    {
        if(counterSubmit == true)
        {
            if(checkifTableLoadOnline == true)
            {
                table_for_upload_online.ajax.reload(null, false);
            }
            else
            {
                console.log('do nothing');
            }
        }

    }
    else if (gethref == '#tab_b')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeCiFund = 'tab_b';
        }
        else if (ci_fund_success)
        {
            console.log(counterDone);
            if(counterDone == true)
            {
                tableCiFundSuccess.ajax.reload(null, false);
                counterDone = false;
            }
            else
            {
                console.log('already loaded');
            }
            activeCiFund = 'tab_b';
        }
        else if (ci_fund_success == false)
        {
            ci_fund_success = true;
            activeCiFund = 'tab_b';
            getSuccessTable();
        }
    }
    else if (gethref == '#tab_3')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeCiFund = 'tab_3';
        }
        else if (ci_fund_online) {
            console.log('already loaded');
            activeCiFund = 'tab_3';
        }
        else if (ci_fund_online == false)
        {
            ci_fund_online = true;
            activeCiFund = 'tab_3';
            ciInfofill();
            bankCItable();
        }
    }

});

function billing_report_table()
{
    $('#billing-table-rate thead th').each(function ()
    {
        title_billing_rep[billing_r_count] = $(this).text();
        billing_r_count++;
        title = $(this).text();
        $(this).html('<b>'+title+'</b>');
    });

    tableBillingReport = $('#billing-table-rate').DataTable
    ({
        // "responsive": true,
        "processing": true,
        // "autoWidth": true,
        "serverSide": true,
        // "ajax": "/billing-table-report",
        "ajax":
            {
                url: "/finance-table-report",
                data: function (d)
                {
                    d.client_id = $('#select_bank_billing').val();
                    d.min_date_endorsed = $('#min').val();
                    d.max_date_endorsed = $('#max').val();
                    // d.max_date_endorsed = $('#max_report').val();
                }
            },
        "columns":
            [
                // {data: 'id', name: 'endorsements.id'},
                {
                    data: function (data)
                    {
                        return '<span id="id_same_address-'+data.id+'">'+data.id+'</span>';
                    },
                    "name": 'endorsements.id'
                },
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                {data: 'date_due', name: 'endorsements.date_due'},
                {data: 'time_due', name: 'endorsements.time_due'},
                {
                    data: function (data) {
                        return '<span id="account_name_same_address-'+data.id+'">'+data.account_name+'</span>';
                    },
                    "name": 'endorsements.account_name'
                },
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'client_name', name: 'endorsements.client_name'},
                {
                    data: function qq(data) {
                        if (data.endorsement_status_external === '')
                        {
                            return '<p style="color: orange">Account still on Proccess</p>';
                            // if(data.client_name == 'TFS')
                            // {
                            //     return 'ito ay tfs';
                            // }
                            // else
                            // {
                            //     return 'not tfs';
                            // }
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


                        if (data.rate === "" || data.rate === "No Rate at this Address" || data.rate === null)
                        {
                            return '<p style="color: red">No rate at this address.</p>';
                        }
                        else
                        {
                            var n = atob(data.rate);

                            if(data.client_name == 'TFS')
                            {
                                if(data.endorsement_status_external == 'OVERDUE')
                                {

                                    n = n - 100;

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );

                                    return convertedRate + ' Php';
                                }
                                else if(data.endorsement_status_external == 'TAT'){

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );

                                    return convertedRate + ' Php';
                                }
                                else
                                {

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }

                            }

                            else if(data.client_name == 'CTBC')
                            {

                            }
                            else if(data.client_name == 'STERLING')
                            {

                            }

                            else if(data.client_name == 'USB')
                            {
                                if(data.endorsement_status_external == 'OVERDUE')
                                {


                                    n = n - 100;

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                                else if(data.endorsement_status_external == 'TAT')
                                {


                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );

                                    return convertedRate + ' Php';
                                }
                                else
                                {

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                            }

                            else if(data.client_name == 'UCPB')
                            {

                            }

                            else if(data.client_name == 'PNB')
                            {

                            }

                            else if(data.client_name == 'BDO')
                            {

                            }

                            else if(data.client_name == 'MAYBANK')
                            {
                                if(data.endorsement_status_external == 'OVERDUE')
                                {


                                    n = n - (n * 0.10);

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                                else if(data.endorsement_status_external == 'TAT'){



                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );

                                    return convertedRate + ' Php';
                                }
                                else
                                {

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                            }

                            else if(data.client_name == 'CBS')
                            {

                            }

                            else if(data.client_name == 'EASTWEST')
                            {

                            }

                            else if(data.client_name == 'PBCOM')
                            {

                            }

                            else if(data.client_name == 'MITSUBISHI')
                            {
                                if(data.endorsement_status_external == 'OVERDUE')
                                {

                                    n = n - 100;

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                                else if(data.endorsement_status_external == 'TAT'){



                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );

                                    return convertedRate + ' Php';
                                }
                                else
                                {

                                    convertedRate = n.toLocaleString
                                    (
                                        undefined, // leave undefined to use the browser's locale,
                                        // or use a string like 'en-US' to override it.
                                        {minimumFractionDigits: 2}
                                    );
                                    return convertedRate + ' Php';
                                }
                            }

                            else if(data.client_name == 'INSULAR')
                            {

                            }

                            else
                            {

                                convertedRate = n.toLocaleString
                                (
                                    undefined, // leave undefined to use the browser's locale,
                                    // or use a string like 'en-US' to override it.
                                    {minimumFractionDigits: 2}
                                );
                                return convertedRate + ' Php';
                            }
                        }

                    },
                    "name": 'endorsements.rate'
                },
                {data: 're_ci', name: 're_ci'},
                {data: 'date_forwarded_to_client', name: 'endorsements.date_forwarded_to_client'},
                {data: 'time_forwarded_to_client', name: 'endorsements.time_forwarded_to_client'},
                // {data: 'ao_remarks_sent', name: 'endorsements.ao_remarks_sent'},
                {
                    data: function ao_sent(data)
                    {
                        return '<span id="account_multi_remarks-'+data.id+'"><b>'+data.ao_remarks_sent+'</b></span>';
                    },
                    name: 'ao_remarks_sent'
                },
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
            // if (aData.appliedrule === 'Same City/Municipalities')
            // {
            //     $('td', nRow).css('border-color', '#b3ffb3');
            // }
            // else if (aData.appliedrule === 'Penalty (-100 PHP)')
            // {
            //     $('td', nRow).css('border-color', '#ff6060');
            // }
            // else if (aData.appliedrule === 'Accounts with same address & same date endorsed.')
            // {
            //     $('td', nRow).css('border-color', '#4af9cb');
            // }
            // else if(aData.appliedrule === 'Additional for Metro Manila (+65 PHP)')
            // {
            //     $('td', nRow).css('border-color', '#425cf4');
            //
            // }
            // else if(aData.appliedrule === 'Additional for Province (+100 PHP)')
            // {
            //     $('td', nRow).css('border-color', '#8f41f4');
            // }
            //
            // if(aData.address == '4605')
            // {
            //

            var tor;

            $(nRow).attr('name', aData.address+'|-|'+aData.muni_name+'|-|'+aData.provinces+'|-|'+aData.date_endorsed);
            $(nRow).attr('id', aData.id);
            $(nRow).attr('class', 'billing_rule');
            $(nRow).attr('href', aData.tor);
            // }

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
                {
                    text: 'Export to Excel',
                    action: function ()
                    {
                        export_to_excel();
                    }

                },
                // {
                //     extend: 'excel',
                //     title : 'Billing',
                //     exportOptions:
                //         {
                //             // columns: [0, 1, 2, 3, 4, 7],
                //             format:
                //                 {
                //                     header: function (dt, idx) {
                //                         return title_billing_rep[(idx)];
                //                     }
                //                 }
                //         },
                //     customize: function ( xlsx )
                //     {
                //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //
                //         var loop = 0;
                //         $('row', sheet).each(function () {
                //
                //             $(this).find("c").attr('s', '25');
                //             $('row:first c', sheet).attr('s', '51');
                //             loop++;
                //         });
                //     }
                // },
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_billing_rep[(idx)];
                    }
                }
            ],
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function()
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

        },
        "drawCallback": function()
        {
            var check_same_address = [];
            var check_id = [];
            var counter_checking = 0;
            var store_the_same_address_here = [];

            $('#billing-table-rate .billing_rule').each(function ()
            {
                var get_address = $(this).attr('name');
                var get_id = $(this).attr('id');
                // var get_type = $(this).attr('href');
                check_same_address[counter_checking] = get_address;
                check_id[counter_checking] = get_id;
                counter_checking++;
            });

            var aw = 0;

            for(var ctr = 0; ctr < check_same_address.length; ctr++)
            {
                var bool_check = false;
                store_the_same_address_here[aw] = [];
                var awe = 0;

                for (var ctrr = 0; ctrr < check_same_address.length; ctrr++)
                {
                    if(ctr != ctrr)
                    {
                        if (check_same_address[ctr] == check_same_address[ctrr])
                        {
                            if(bool_check == false)
                            {
                                var good_to_go = true;

                                for(var i = 0; i < store_the_same_address_here.length; i++)
                                {
                                    for(var ii = 0; ii < store_the_same_address_here[i].length; ii++)
                                    {
                                        if(store_the_same_address_here[i][ii] == check_id[ctr])
                                        {
                                            good_to_go = false;
                                        }
                                    }
                                }

                                if(good_to_go)
                                {
                                    store_the_same_address_here[aw][awe] = check_id[ctr];
                                    awe++;
                                    bool_check = true;
                                }
                            }

                            if(good_to_go)
                            {
                                store_the_same_address_here[aw][awe] = check_id[ctrr];
                                awe++;
                            }
                        }
                    }
                }
                if (awe > 0)
                {
                    aw++;
                }
            }

            console.log(store_the_same_address_here);

            var store_new = [];

            for(var store = 0; store < store_the_same_address_here.length; store++)
            {
                for(var store1 = 0; store1 < store_the_same_address_here[store].length; store1++)
                {

                }
            }

            if(store_the_same_address_here.length > 0)
            {
                $.ajax
                ({
                    url: 'finance_billing_coborrower_same_add_checker',
                    type: 'get',
                    data:
                        {
                            'array_accounts': store_the_same_address_here
                        },
                    beforeSend: function ()
                    {
                        //loading here
                    },
                    success: function(data)
                    {
                        console.log(data);

                        var checkName = false;
                        var checkuliName = false;
                        var checkTor = false;
                        var checkuliTor = false;
                        var nameVal = '';
                        var torVal = '';

                        for(var ctr = 0; ctr < data.length; ctr++)
                        {
                            var bool_if_meron = false;
                            var get_main_id = '';
                            var get_main_name = '';
                            var get_cobs_id = '';
                            var get_cobs_name = '';
                            var get_cobs_type = '';
                            var get_remarks = '';
                            nameVal = '';
                            checkName = false;
                            checkuliName = false;
                            checkTor = false;
                            checkuliTor = false;

                            var nameCheck = data[ctr][0].split('||--:--||')[0];
                            var torCheck = data[ctr][0].split('||--:--||')[2];

                            for(var i = 0; i < data[ctr].length; i++)
                            {
                                if(i == 0)
                                {
                                    bool_if_meron = true;
                                    var spliteed_main = data[ctr][0].split('||--:--||');
                                    get_main_id = spliteed_main[1];

                                }
                                else if(i <= 2 && i !== 0)
                                {
                                    var spliteed_cob = data[ctr][i].split('||--:--||');
                                    $('#'+spliteed_cob[1]+'').remove();
                                    get_cobs_id += '/'+spliteed_cob[1];
                                    get_cobs_name += '/'+spliteed_cob[0];
                                    get_cobs_type += '/'+spliteed_cob[2];
                                    get_remarks += '/ <b>'+spliteed_cob[3]+'</b>';

                                    if(i >= 1)
                                    {
                                        if(spliteed_cob[0] == nameCheck)
                                        {
                                            checkName = true;
                                            nameVal = nameCheck;
                                        }
                                        else if(spliteed_cob[0] != nameCheck)
                                        {
                                            checkName = false;
                                            checkuliName = true;
                                        }

                                        if(spliteed_cob[2] == torCheck)
                                        {
                                            checkTor = true;
                                            torVal = torCheck;
                                        }
                                        else if(spliteed_cob[2] != torCheck)
                                        {
                                            checkTor = false;
                                            checkuliTor = true;
                                        }
                                    }
                                }
                            }

                            if(bool_if_meron)
                            {
                                if(checkName == true && checkuliName == false)
                                {
                                    $('#id_same_address-'+get_main_id+'').append(get_cobs_id);
                                    $('#account_name_same_address-'+get_main_id+'').html(nameVal);
                                    if(get_remarks.split("/").join().replace(/,/g, "") != '')
                                    {
                                        $('#account_multi_remarks-'+get_main_id+'').append(get_remarks);
                                    }
                                }
                                else
                                {
                                    $('#id_same_address-'+get_main_id+'').append(get_cobs_id);
                                    $('#account_name_same_address-'+get_main_id+'').append(get_cobs_name);
                                }


                                if(checkTor == true && checkuliTor == false)
                                {
                                    $('#multi_tor-'+get_main_id+'').html(torVal);
                                }
                                else
                                {
                                    $('#multi_tor-'+get_main_id+'').append(get_cobs_type);
                                }
                            }
                        }

                    },
                    error: function()
                    {

                    },
                    complete: function()
                    {

                    }

                });
            }




        }
    });

    $('#billing-table-rate_filter input').unbind();
    $('#billing-table-rate_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableBillingReport.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableBillingReport.search($(this).val()).draw();
                }
            }
        }
    });
    $('#billing-table-rate tbody').on('click', 'tr', function ()
    {
        $(this).toggleClass('selected');
    });


}

function export_to_excel(){

    $("#billing-table-rate").table2excel({
        filename: "Billing Report "+ new Date().toISOString().replace(/[\-\:\.]/g, "") +".xls",
        fileext: ".xls",
        name: "Billing Report"
    });

}
function billing_rule_func() {

    // setTimeout(function () {



    // },2000)


}

function billing_information_table() {

    $('#billing-manage tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    tableBillingInfo = $('#billing-manage').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/finance-billing-management",
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
                tableBillingInfo.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableBillingInfo.search($(this).val()).draw();
                }
            }
        }
    });

}

function selall() {
    tableBillingReport.rows().select();
    var ids = $.map(tableBillingReport.rows('.selected').data(), function (item) {
        return item
    });

}

function desall() {
    // tableReport.rows().deselect();
    tableBillingReport.ajax.reload(null, false);

}

// test

$('#table_fund_req_approved_finance').on('click', '.btnSubmitFundReqInfo', function()
{
    var id_fund = $(this).val();
    var ci_id = $(this).attr('name');

    var btn = $(this);

    btn.attr('disabled', true);

    var atmStat;
    var shellStat;
    var remStat;

    var statusShell;

    if(dataRemitance[id_fund] == '' || dataRemitance[id_fund] == null)
    {
        remStat = "";
    }
    else
    {
        remStat = dataRemitance[id_fund];
    }
    if(dataATM[id_fund] == '' || dataATM[id_fund] == null)
    {
        atmStat = "";
    }
    else
    {
        atmStat = dataATM[id_fund];
    }

    if(shellCardStat[id_fund] == '' || shellCardStat[id_fund] == null)
    {
        shellStat = ""
    }
    else
    {
        shellStat = shellCardStat[id_fund];
    }

    // if(checkatm > 0 && checkifshell > 0)
    // {
    //     statusShell = 'have_shell';
    //         $.ajax
    //         ({
    //             type : 'get',
    //             url : 'finance-overall-fund-rem-atm',
    //             data :
    //                 {
    //                     'id' : id_fund,
    //                     'ci_id' : ci_id,
    //                     'rem' : remStat,
    //                     'atm' : atmStat,
    //                     'shell' : shellStat,
    //                     'statusShell' : statusShell
    //                 },
    //             success : function(data)
    //             {
    //                 console.log(data);
    //                 counterSubmit = true;
    //                 btn.attr('disabled', false);
    //                 tableCiFundApproved.ajax.reload(null, false);
    //                 showFundCount();
    //             }
    //         });
    // }
    // else if(checkatm == 0 && checkifshell > 0)
    // {
    //     statusShell = 'shell_only';
    //     $.ajax
    //     ({
    //         type : 'get',
    //         url : 'finance-overall-fund-rem-atm',
    //         data :
    //             {
    //                 'id' : id_fund,
    //                 'ci_id' : ci_id,
    //                 'rem' : remStat,
    //                 'atm' : atmStat,
    //                 'shell' : shellStat,
    //                 'statusShell' : statusShell
    //             },
    //         success : function(data)
    //         {
    //             console.log(data);
    //             counterSubmit = true;
    //             btn.attr('disabled', false);
    //             tableCiFundApproved.ajax.reload(null, false);
    //             showFundCount();
    //         }
    //     });
    // }
    // else if(checkatm > 0 && checkifshell == 0)
    // {
    //     statusShell = 'no_shell';
    //     $.ajax
    //     ({
    //         type : 'get',
    //         url : 'finance-overall-fund-rem-atm',
    //         data :
    //             {
    //                 'id' : id_fund,
    //                 'ci_id' : ci_id,
    //                 'rem' : remStat,
    //                 'atm' : atmStat,
    //                 'shell' : shellStat,
    //                 'statusShell' : statusShell
    //             },
    //         success : function(data)
    //         {
    //             console.log(data);
    //             counterSubmit = true;
    //             btn.attr('disabled', false);
    //             tableCiFundApproved.ajax.reload(null, false);
    //             showFundCount();
    //         }
    //     });
    //
    // }
    if(checkatm > 0 || checkifshell > 0)
    {
        $.ajax
        ({
            type : 'get',
            url : 'finance-overall-fund-rem-atm',
            data :
                {
                    'id' : id_fund,
                    'ci_id' : ci_id,
                    'rem' : remStat,
                    'atm' : atmStat,
                    'shell' : shellStat,
                    // 'statusShell' : statusShell
                },
            success : function(data)
            {
                console.log(data);
                counterSubmit = true;
                btn.attr('disabled', false);
                // tableCiFundApproved.ajax.reload(null, false);
                // var $row = $(this).closest("tr");
                $('#btnSubmitFundReqInfo-'+id_fund+'').closest("tr").remove();
                showFundCount();
                checkatm--;
                checkifshell = 0;
            }
        });
    }
    else
    {
        alert('Please select mode of sending!');
        btn.attr('disabled', false);
    }

    console.log(statusShell);
});

$('#btnSortCiApproved').change(function()
{
    var sortFinanceData = $(this).find(':selected').val();

    console.log(sortFinanceData);


    if(sortFinanceData == 'REMITTANCE')
    {
        valWhere = 'ci_fund_remittances.remittance_id';
        statWhere = 1;

        checkRemOpen = true;

        if(checkSelectBankOpen == true || checkShellOpen == true)
        {
            table_for_upload_online.column(hidecolumnRem).visible(true);
            table_for_upload_online.column(hidecolumnRem2).visible(false);
            table_for_upload_online.column(hidecolumnAtm).visible(false);
            // table_for_upload_online.column(hidecolumnShell).visible(true);
            table_for_upload_online.ajax.reload(null, false);
        }
        else if(checkRemOpen == true &&  checkSelectBankOpen == false && checkShellOpen == true)
        {
            table_for_upload_online.column(hidecolumnRem).visible(true);
            table_for_upload_online.column(hidecolumnRem2).visible(false);
            table_for_upload_online.column(hidecolumnAtm).visible(false);
            // table_for_upload_online.column(hidecolumnShell).visible(true);
            table_for_upload_online.ajax.reload(null, false);
        }
        else if(checkRemOpen == true &&  checkSelectBankOpen == false && checkShellOpen == false)
        {
            finance_for_online_upload_table();
            table_for_upload_online.column(hidecolumnRem).visible(true);
            table_for_upload_online.column(hidecolumnRem2).visible(false);
            table_for_upload_online.column(hidecolumnAtm).visible(false);
            // table_for_upload_online.column(hidecolumnShell).visible(true);
        }
        else(checkSelectBankOpen == false && checkShellOpen == false)
        {
            finance_for_online_upload_table();
            table_for_upload_online.column(hidecolumnRem).visible(true);
            table_for_upload_online.column(hidecolumnAtm).visible(false);
            // table_for_upload_online.column(hidecolumnShell).visible(true);
        }
        checkifTableLoadOnline = true;
        $('#hideshowTable').show();
        $('#showHideBank').hide();
        $('#arrayforDoneAll').show();
    }
    else if(sortFinanceData == 'ATM')
    {
        valWhere = 'ci_fund_remittances.ci_atm_fund_id';
        statWhere = 2;

        checkAtmOpen = true;

        $('#hideshowTable').hide();
        $('#showHideBank').show();
        $('#arrayforDoneAll').hide();

        showAllBank();
    }
    else if(sortFinanceData == '-')
    {
        checkifTableLoadOnline = false;
        $('#hideshowTable').hide();
        $('#showHideBank').hide();
        $('#arrayforDoneAll').hide();
    }
});

function showAllBank()
{
    $.ajax
    ({
        type : 'get',
        url : 'finance-get-all-bank',
        success : function(data)
        {
            var BankNames = '';
            var i;
            var test = [];

            for(i = 0; i < data.length; i++)
            {
                test.push(data[i].bank_name);
            }
            var uniqueNames = [];
            $.each(test, function(i, el){
                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
            });

            for(i = 0; i < uniqueNames.length; i++)
            {
                BankNames += '<option value = "'+ uniqueNames[i] +'">'+ uniqueNames[i] +'</option>'
            }
            $('#btnSortCiBank').html('<option value="-">-</option>' +BankNames);
        }
    });
}

$('#btnSortCiBank').change(function()
{
    atmWhere = $(this).find(':selected').val();
    hidecolumnRem = 3;
    hidecolumnAtm = 4;


    if(atmWhere == '-')
    {
        checkSelectBankOpen = true;
        $('#hideshowTable').hide();
    }
    else if(checkRemOpen == true || checkShellOpen == true && checkSelectBankOpen == true)
    {
        table_for_upload_online.column(hidecolumnRem).visible(false);
        table_for_upload_online.column(hidecolumnRem2).visible(true);
        table_for_upload_online.column(hidecolumnAtm).visible(true);
        // table_for_upload_online.column(hidecolumnShell).visible(true);
        table_for_upload_online.ajax.reload(null, false);
        checkSelectBankOpen = true;
        $('#hideshowTable').show();
    }
    else if(checkRemOpen == false && checkSelectBankOpen == true && checkShellOpen == false)
    {
        table_for_upload_online.column(hidecolumnRem).visible(false);
        table_for_upload_online.column(hidecolumnAtm).visible(true);
        table_for_upload_online.column(hidecolumnRem2).visible(true);
        // table_for_upload_online.column(hidecolumnShell).visible(true);
        table_for_upload_online.ajax.reload(null, false);
        checkSelectBankOpen = true;
        $('#hideshowTable').show();
    }
    else if(checkRemOpen == false && checkSelectBankOpen == false && checkShellOpen == true)
    {
        table_for_upload_online.column(hidecolumnRem).visible(false);
        table_for_upload_online.column(hidecolumnAtm).visible(true);
        table_for_upload_online.column(hidecolumnRem2).visible(true);
        // table_for_upload_online.column(hidecolumnShell).visible(true);
        table_for_upload_online.ajax.reload(null, false);
        checkSelectBankOpen = true;
        $('#hideshowTable').show();
    }
    else if(checkRemOpen == false && checkSelectBankOpen == false && checkShellOpen == false)
    {
        finance_for_online_upload_table();
        table_for_upload_online.column(hidecolumnRem).visible(false);
        table_for_upload_online.column(hidecolumnAtm).visible(true);
        table_for_upload_online.column(hidecolumnRem2).visible(true);
        // table_for_upload_online.column(hidecolumnShell).visible(true);
        checkSelectBankOpen = true;
        $('#hideshowTable').show();

    }

    console.log(checkRemOpen + ',' + checkSelectBankOpen + ',' + checkShellOpen);
    checkifTableLoadOnline = true;

    $('#arrayforDoneAll').show();

});

$('.fa_billing_class').click(function () {
    var gethref = $(this).attr('href');
    // console.log(gethref);
    if (gethref == '#tab_report')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBilling = 'tab_report';
        }
        else if (billing_rep) {
            console.log('already loaded');
            activeBilling = 'tab_report';
        }
        else if (billing_rep == false) {
            billing_rep = true;
            activeBilling = 'tab_report';
        }
    }
    else if (gethref == '#tab_bil_rep')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBilling = 'tab_bil_rep';
        }
        else if (bi_info) {
            console.log('already loaded');
            activeBilling = 'tab_bil_rep';
        }
        else if (bi_info == false) {
            bi_info = true;
            activeBilling = 'tab_bil_rep';
            billing_information_table();
        }
    }
    else if (gethref == '#tab_report_cc')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBilling = 'tab_report_cc';
        }
        else if (bi_rate_andBank) {
            console.log('already loaded');
            activeBilling = 'tab_report_cc';
        }
        else if (bi_rate_andBank == false) {
            bi_rate_andBank = true;
            activeBilling = 'tab_report_cc';
            if(!cc_billing_rep)
            {
                cc_billing_rep_table();

                $('#add-manually-acc').attr('disabled', true);
                cc_billing_rep = true;
            }
        }
    }
    else if (gethref == '#tab_report_cc_table')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBilling = 'tab_report_cc_table';
        }
        else if (tab_report_cc_table) {
            console.log('already loaded');
            activeBilling = 'tab_report_cc_table';
        }
        else if (tab_report_cc_table == false) {
            tab_report_cc_table = true;
            activeBilling = 'tab_report_cc_table';
            cc_billing_table_func();
        }
    }
    else if (gethref == '#tab_report_cc_table_bank')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBilling = 'tab_report_cc_table_bank';
        }
        else if (tab_report_cc_bank_table) {
            console.log('already loaded');
            activeBilling = 'tab_report_cc_table_bank';
        }
        else if (tab_report_cc_bank_table == false) {
            tab_report_cc_bank_table = true;
            activeBilling = 'tab_report_cc_bank_table';
            cc_bank_billing_table_func();
        }
    }
});

$('#table_fund_req_approved_finance').on('click', '.btn_done_approved', function()
{
    fundIdReq = $(this).attr('name');
    console.log(fundIdReq);

    if(confirm('Are you sure to proceed?'))
    {
        $.ajax
        ({
            type : 'get',
            url : 'finance-set-done-approve-req',
            data :
                {
                    'id' : fundIdReq
                },
            success : function()
            {
                alert('Successfully Done!');
                counterDone = true;
                tableCiFundApproved.ajax.reload(null, false);
            }
        })
    }
    else
    {

    }
});
var financeIdSuc;
$('#table_success_req_finance').on('click', '.btn_edit_approve', function()
{
    financeIdSuc = $(this).attr('name');
    var amount = atob($(this).attr('href'))

    $('#request_re_id').val(amount);

    $('#modal-edit-approved-req').modal('show');
    $('#app_incident_rem').val('');
});
$('#table_success_req_finance').on('click', '.btn_incident_rem', function()
{
    financeIdSuc = $(this).attr('name');

    $('#modal-incident-approved-req').modal('show');
});
$('#table_success_req_finance').on('click', '.btn_incident_view', function()
{
    financeIdSuc = $(this).attr('name');

    $.ajax
    ({
        type : 'get',
        url : 'finance-get-incident-rem',
        data :
            {
                'id' : financeIdSuc
            },
        success : function(data)
        {
            console.log(data);
            $('#app_incident_rem_view').val(data);
        }

    });

    $('#modal-incident-approved-view').modal('show');
});



$('#btnSubmitReRequest').click(function()
{
    var amount = $('#request_re_id').val();

    var amoundSend = btoa(amount);

    var btn = $(this);

    btn.attr('disabled', true);

    if( $('#app_incident_rem').val() != "")
    {
        $.ajax
        ({
            type : 'get',
            url : 'finance-send-re-approve-req',
            data :
                {
                    'id' : financeIdSuc,
                    'amount' : amoundSend,
                    'rem' : $('#app_incident_rem').val()
                },
            success : function()
            {
                btn.attr('disabled', false);
                counterReReq = true;
                $('#modal-edit-approved-req').modal('hide');
                tableCiFundSuccess.ajax.reload(null, false);
                showFundCount();
                checkFArefresh = true;
            }
        });
    }
    else
    {
        alert('Please indicate remarks for C.I');
        btn.attr('disabled', false);
    }

});
var checkAmtSame = true;
$('#checkSameAmount').click(function()
{
    if(checkAmtSame == false)
    {
        $('#request_re_id').attr('disabled', true);
        checkAmtSame = true;
    }
    else
    {
        $('#request_re_id').attr('disabled', false);
        checkAmtSame = false;
    }
});

$('#table-finance-expenses-report').on('click', '.btn_view_ci_liq', function()
{
    $('#insertCiImgLiq').html('');
    $('.clicked_modify').hide();
    $('.hidemuna').hide();
    $('#finance_ci_liq_remssss').val('');
    $('.show_modify').show();
    fundIDliq = $(this).attr('name');
    // console.log(fundIDliq);

    $('#modal-view-ci-liq-img').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'finance-get-img-liq-fund',
        data :
            {
                'id'  : fundIDliq
            },
        success : function(data)
        {
            console.log(data);
            var i;
            var imdDiv = '';
            var remIndicate = '';
            var u;
            var m;
            var outImgdiv = '';
            var indivRemarks = '';
            $('#ci_req_amount').val('₱ '+data[9]);
            $('#ci_req_amount_check').val(data[9]);

            for (u = 0; u < data[3].length; u++)
            {
                var pathToLoop = data[3][u].split('|');
                var extensionCheck = '';
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
                    '<label for="">Expenses</label>' +
                    '<input type="number" class="form-control clicked_modify_val" value="'+atob(data[8][u])+'" name="'+data[10][u]+'" disabled></div>' +
                    '<div class = "col-md-1"></div></div>';

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

            $('#liq_date_rev').html(data[7].datetime);
            // $('#insertCiImgLiq').

            if(data != '')
            {
                for (i = 0; i < data[0].length; i++)
                {

                }

            }
            if(data[2] != '')
            {
                $('#insertCILiqRemarks').val(data[2]);
                $('.hidemuna').show();
            }
            else
            {
                $('.hidemuna').hide();
                $('#insertCILiqRemarks').val('');
                $('#insertCILiqRemarks').attr('placeholder', 'NO INDICATED REMARKS.....');
            }
        }
    })
});

$('#table_fund_for_online_upload').on('click', '.btnDoneFundRequest', function()
{
    financeOnlineId = $(this).attr('name');

    var btn = $(this);

    btn.attr('disabled', true);

    $('#rev-'+financeOnlineId+'').attr('disabled', false);

    $.ajax
    ({
        type : 'get',
        url : 'finance-done-online-fund',
        data :
            {
                'id' : financeOnlineId
            },
        beforeSend : function()
        {
            $('#modal-loading-done-only').modal({backdrop : "static"});
        },
        success : function(data)
        {

        },
        complete : function()
        {
            $('#modal-loading-done-only').modal('hide');
            btn.attr('disabled', false);
            table_for_upload_online.ajax.reload(null, false);
            counterDone = true;
            showFundCount();
        }
    });
});

$('.arrayforDoneAll').click(function()
{
    var arrayToDoneAll = [];
    var arrayToDoneNames = [];
    var insertCtrNames = 0;
    var emergencyInsert = [];




    $('.idsTODone').each(function()
    {
        var names = $(this).attr('href');

        var splitNames = names.split('|');

        var ci_name = splitNames[0];
        var srao_name = splitNames[1];
        var disp_name = splitNames[2];

        arrayToDoneNames[insertCtrNames] = [];

        arrayToDoneNames[insertCtrNames][0] = ci_name;
        arrayToDoneNames[insertCtrNames][1] = srao_name;
        arrayToDoneNames[insertCtrNames][2] = disp_name;

        arrayToDoneAll.push($(this).attr('name'));
        emergencyInsert.push($(this).attr('id'));


        insertCtrNames++;
    });

    var ctrToDone = 0;

    $('#modal-loading-done-all').modal({backdrop: "static"});

    if(arrayToDoneAll.length > 0)
    {

        if(emergencyInsert[ctrToDone] == 'normal')
        {
            $('#showMag').hide();

            var disp = ''

            if(arrayToDoneNames[ctrToDone][2] == 'null')
            {
                $('#showDis').hide();
            }
            else
            {
                $('#dispatcher_name_done').html(arrayToDoneNames[ctrToDone][2]);
                $('#showDis').show();
            }
        }
        else if(emergencyInsert[ctrToDone] == 'emergency')
        {
            $('#showDis').hide();
            $('#showMag').show();

            var str = managementList.slice(0, -2);

            $('#management_list_done').html(str)
        }

        $('#currentSendLoop').html((ctrToDone+1));
        $('#totalSend').html(arrayToDoneAll.length);
        $('#ci_name_done').html(arrayToDoneNames[ctrToDone][0]);
        $('#sao_name_done').html(arrayToDoneNames[ctrToDone][1]);


        doneFundtoAll(ctrToDone, arrayToDoneAll, arrayToDoneNames, emergencyInsert);
    }
    else
    {
        alert('No current fund request to send');
    }
});

function doneFundtoAll(id, array, arrayNames, torArray)
{

    $.ajax
    ({
        type : 'get',
        url : 'finance-done-online-fund',
        data :
            {
                'id' : array[id]
            },
        success : function(data)
        {

        },
        complete : function()
        {
            if(id != ((array.length)-1))
            {
                id++;

                if(torArray[id] == 'normal')
                {
                    $('#showMag').hide();

                    var disp = ''

                    if(arrayNames[id][2] == 'null')
                    {
                        $('#showDis').hide();
                    }
                    else
                    {
                        $('#dispatcher_name_done').html(arrayNames[id][2]);
                        $('#showDis').show();
                    }
                }
                else if(torArray[id] == 'emergency')
                {
                    $('#showDis').hide();
                    $('#showMag').show();

                    var str = managementList.slice(0, -2);

                    $('#management_list_done').html(str)
                }

                $('#currentSendLoop').html((id+1));
                $('#ci_name_done').html(arrayNames[id][0]);
                $('#sao_name_done').html(arrayNames[id][1]);


                doneFundtoAll(id, array, arrayNames, torArray);
            }
            else
            {
                $('#modal-loading-done-all').modal('hide');
                table_for_upload_online.ajax.reload(null, false);
                counterDone = true;
                showFundCount();
            }
        },
        error : function()
        {
            $('#modal-loading-done-all').modal('hide')
            table_for_upload_online.ajax.reload(null, false);
            counterDone = true;
            showFundCount();
            alert('An error accured while sending SMS and Email Notification');
        }
    });
}

function showFundCount()
{
    $.ajax
    ({
        type : 'get',
        url : 'finance-get-fund-count',
        success : function(data)
        {
            $('#showFundReqCount').html(data[0]);
            $('#showFundDoneCount').html(data[1]);
            $('#showFundPendingeCount').html(data[2]);
            $('#showFundHoldCount').html(data[3]);
            $('#showFundCancelCount').html(data[4]);
            $('#showFundUnliqNewCount').html(data[5]);
        }
    })
}

$('#btnViewAtt').click(function()
{
    $('#testExcelTable').html('');
    var btn = $(this);

    var uploadExcel = $('#fileDTR').prop('files')[0];

    var formData = new FormData();
    formData.append('excel', uploadExcel);

    if(uploadExcel != null)
    {
        btn.attr("disabled", true);
        $.ajax
        ({
            type: 'post',
            url: 'finance-upload-bulk-excel',
            contentType: false,
            processData: false,
            async : true,
            data: formData,
            beforeSend: function()
            {
                $('#modal-loading').modal('show');
            },
            success : function(data)
            {

                if(data[4] == 1)
                {
                    $('#table4excelAtt').html('');
                    var event1 = new Date(data[1][1][0].date);
                    var dateYest = event1.toDateString();

                    var event2 = new Date(data[2][1][0].date);
                    var dateNow = event2.toDateString();

                    var i;
                    var dateIn = [];
                    var dateOut = [];
                    var dateOutNow = [];
                    var dateInNow = [];

                    var tableheader = '<div class="row">' +
                        '<div class="col-md-2"></div>' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-2">' +
                        '<input type="text" placeholder="Search..." id="AttSearchPayroll" class="form-control input-md">' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<table class="tableendorse table-condensed table-hover" width="100%" style="font-weight: bold" id="table4excelAtt">\n' +
                        '<tr>' +
                        '<th style="background-color:black; color:white;" colspan="1" rowspan="2"><h3>Employee Name</h3></th>' +
                        '<th style="background-color:black; color:white;" colspan="2"><h5>'+dateYest+'</h5></th>' +
                        '<th style="background-color:black; color:white;" colspan="2"><h5>'+dateNow+'</h5></th>' +
                        '</tr>' +
                        '<tr>\n' +
                        '<th style="background-color:black; color:white;" colspan="1">Time In</th>\n' +
                        '<th style="background-color:black; color:white;" colspan="1">Time Out</th>\n' +
                        '<th style="background-color:black; color:white;" colspan="1">Time In</th>\n' +
                        '<th style="background-color:black; color:white;" colspan="1">Time Out</th>\n' +
                        '                                    </tr>' +
                        '</div>'+
                        '</div>';
                    var tabledatas = '';

                    for(i = 1; i < data[3]+1; i++)
                    {
                        if(data[1][i][2] != null)
                        {
                            var dateIntimeSplitYest = data[1][i][2].date;
                            var dateInn = dateIntimeSplitYest.split(" ");
                            dateIn = dateInn[1].split(".");

                            var get_hour_now_in = dateIn[0].split(':');

                            if(parseInt(get_hour_now_in[0]) == 12)
                            {
                                dateIn[0] = get_hour_now_in[0]+':' + get_hour_now_in[1] + ' PM';
                            }
                            else if(parseInt(get_hour_now_in[0]) > 12)
                            {
                                dateIn[0] = (parseInt(get_hour_now_in[0]) - 12) +':' + get_hour_now_in[1] + ' PM';
                            }
                            else {
                                dateIn[0] = get_hour_now_in[0]+':' + get_hour_now_in[1] + ' AM';
                            }

                        }
                        else
                        {
                            dateIn = ['-', null];
                        }

                        if(data[1][i][3] != null)
                        {
                            var dateOuttimeSplitYest = data[1][i][3].date;
                            var dateOutt = dateOuttimeSplitYest.split(" ");
                            dateOut = dateOutt[1].split(".");
                            var get_hour_now_out = dateOut[0].split(':');


                            if(parseInt(get_hour_now_out[0]) == 12)
                            {
                                dateOut[0] = get_hour_now_out[0]+':' + get_hour_now_out[1] + ' PM';
                            }
                            else if(parseInt(get_hour_now_out[0]) > 12)
                            {
                                dateOut[0] = (parseInt(get_hour_now_out[0]) - 12) +':' + get_hour_now_out[1] + ' PM';
                            }
                            else {
                                dateOut[0] = get_hour_now_out[0]+':' + get_hour_now_out[1] + ' AM';
                            }
                        }
                        else
                        {
                            dateOut = ['-', null];
                        }

                        if(data[2][i][0] == 'Total:')
                        {
                            tabledatas += '<tr>\n' +
                                '                                        <td>'+data[0][i]+'</td>\n' +
                                '                                        <td>'+dateIn[0]+'</td>\n' +
                                '                                        <td>'+dateOut[0]+'</td>\n' +
                                '                                        <td>-</td>\n' +
                                '                                        <td>-</td>\n' +
                                '                                    </tr>';
                        }
                        else
                        {
                            if(data[2][i][2] != null && data[2][i][3] != null)
                            {
                                var dateTimeInNow = data[2][i][2].date;
                                var dateNoww = dateTimeInNow.split(" ");
                                dateInNow = dateNoww[1].split(".");
                                var get_hour = dateInNow[0].split(':');

                                if(parseInt(get_hour[0]) == 12)
                                {
                                    dateInNow[0] = get_hour[0]+':' + get_hour[1] + ' PM';
                                }
                                else if(parseInt(get_hour[0]) > 12)
                                {
                                    dateInNow[0] = (parseInt(get_hour[0]) - 12) +':' + get_hour[1] + ' PM';
                                }
                                else {
                                    dateInNow[0] = get_hour[0]+':' + get_hour[1] + ' AM';
                                }




                                var dateTimeOutNow = data[2][i][3].date;
                                var dateNowww = dateTimeOutNow.split(" ");
                                dateOutNow = dateNowww[1].split(".");
                                var get_hour_out = dateOutNow[0].split(':');


                                if(parseInt(get_hour_out[0]) == 12)
                                {
                                    dateOutNow[0] = get_hour_out[0]+':' + get_hour_out[1] + ' PM';
                                }
                                else if(parseInt(get_hour_out[0]) > 12)
                                {
                                    dateOutNow[0] = (parseInt(get_hour_out[0]) - 12) +':' + get_hour_out[1] + ' PM';
                                }
                                else {
                                    dateOutNow[0] = get_hour_out[0]+':' + get_hour_out[1] + ' AM';
                                }

                                tabledatas += '<tr>\n' +
                                    '                                        <td>'+data[0][i]+'</td>\n' +
                                    '                                        <td>'+dateIn[0]+'</td>\n' +
                                    '                                        <td>'+dateOut[0]+'</td>\n' +
                                    '                                        <td>'+dateInNow[0]+'</td>\n' +
                                    '                                        <td>'+dateOutNow[0]+'</td>\n' +
                                    '                                    </tr>';
                            }
                            else if(data[2][i][2] == null && data[2][i][3] == null)
                            {
                                tabledatas += '<tr>\n' +
                                    '                                        <td>'+data[0][i]+'</td>\n' +
                                    '                                        <td>'+dateIn[0]+'</td>\n' +
                                    '                                        <td>'+dateOut[0]+'</td>\n' +
                                    '                                        <td>-</td>\n' +
                                    '                                        <td>-</td>\n' +
                                    '                                    </tr>';
                            }
                            else if(data[2][i][2] == null)
                            {


                                tabledatas += '<tr>\n' +
                                    '                                        <td>'+data[0][i]+'</td>\n' +
                                    '                                        <td>'+dateIn[0]+'</td>\n' +
                                    '                                        <td>'+dateOut[0]+'</td>\n' +
                                    '                                        <td>'+dateInNow[0]+'</td>\n' +
                                    '                                        <td>-</td>\n' +
                                    '                                    </tr>';
                            }
                            else if(data[2][i][3] == null)
                            {
                                tabledatas += '<tr>\n' +
                                    '                                        <td>'+data[0][i]+'</td>\n' +
                                    '                                        <td>'+dateIn[0]+'</td>\n' +
                                    '                                        <td>'+dateOut[0]+'</td>\n' +
                                    '                                        <td>-</td>\n' +
                                    '                                        <td>'+dateOutNow[0]+'</td>\n' +
                                    '                                    </tr>';
                            }
                        }
                    }

                    $('#testExcelTable').html(tableheader + tabledatas + '</table>');

                    console.log(data);
                }
                else if(data[2] == 2)
                {
                    $('#testExcelTable').html('');

                    var event3 = new Date(data[0][0][1]);
                    var dateYest1 = event3.toDateString();

                    var event4 = new Date(data[1][0]);
                    var dateYest2 = event4.toDateString();
                    var tabledatas1 = '';


                    for(i = 0; i < data[0].length; i++)
                    {
                        if(data[0][i][2] == null)
                        {
                            var nullto = '-';
                        }
                        else
                        {
                            nullto = data[0][i][2];
                        }

                        if(data[0][i][3] == null)
                        {
                            var nullto1 = '-';
                        }
                        else
                        {
                            nullto1 = data[0][i][3];
                        }

                        if(data[0][i][4] == null)
                        {
                            var nullto2 = '-';
                        }
                        else
                        {
                            nullto2 = data[0][i][4];
                        }

                        var tableheader1 = '<div class="row">' +
                            '<div class="col-md-2"></div>' +
                            '<div class="col-md-8"></div>' +
                            '<div class="col-md-2">' +
                            '<input type="text" placeholder="Search..." id="AttSearchPayroll" class="form-control input-md">' +
                            '</div>' +
                            '</div><br>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<table class="tableendorse table-condensed table-hover" width="100%" style="font-weight: bold" id="table4excelAtt">\n' +
                            '<tr>' +
                            '<th style="background-color:black; color:white;" colspan="1" rowspan="2"><h3>Employee Name</h3></th>' +
                            '<th style="background-color:black; color:white;" colspan="2"><h5>'+dateYest1+'</h5></th>' +
                            '<th style="background-color:black; color:white;" colspan="2"><h5>'+dateYest2+'</h5></th>' +
                            '</tr>' +
                            '<tr>\n' +
                            '<th style="background-color:black; color:white;" colspan="1">Time In</th>\n' +
                            '<th style="background-color:black; color:white;" colspan="1">Time Out</th>\n' +
                            '<th style="background-color:black; color:white;" colspan="1">Time In</th>\n' +
                            '<th style="background-color:black; color:white;" colspan="1">Time Out</th>\n' +
                            '</tr>' +
                            '</div>' +
                            '</div>';

                        tabledatas1 += '<tr>\n' +
                            '                                        <td>'+data[0][i][0]+'</td>\n' +
                            '                                        <td>'+nullto+'</td>\n' +
                            '                                        <td>'+nullto1+'</td>\n' +
                            '                                        <td>'+nullto2+'</td>\n' +
                            '                                        <td>-</td>\n' +
                            '                                    </tr>';

                    }

                    $('#testExcelTable').html(tableheader1 + tabledatas1 + '</table>');

                    console.log(data);
                }
            },
            complete: function ()
            {
                btn.attr("disabled", false);
                $('#modal-loading').modal('hide');
                searchToAttDtr();
            }
        });
    }
    else
    {
        alert('Please select an excel file!');
        btn.attr("disabled", false);
    }
});

$('#testExcelTable').on('dblclick', '.excelCol', function()
{
    var id = $(this).attr('name');
    $('#'+ id +'').attr('disabled', false);
    $('#'+ id +'').css('background-color', 'white');
});


function searchToAttDtr(){
    $('#AttSearchPayroll').keyup(function()
    {
        var input,filter,table,tr,t,i, txtValue;
        input = document.getElementById("AttSearchPayroll");
        filter = input.value.toUpperCase();
        table = document.getElementById("table4excelAtt");
        tr = table.getElementsByTagName("tr");
        for(i = 0; i < tr.length; i++)
        {
            td = tr[i].getElementsByTagName("td")[0];
            if(td)
            {
                txtValue = td.textContent || td.innerText;
                if(txtValue.toUpperCase().indexOf(filter) > -1)
                {
                    tr[i].style.display = "";
                }
                else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
}

$('#table_success_req_finance').on('click', '.btn_hold_fund_ci', function()
{
    var id = $(this).attr('name');

    $.ajax
    ({
        type : 'get',
        url : 'finance-hold-ci-fund',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            if(data == 'ok')
            {
                tableCiFundSuccess.ajax.reload(null,false);
            }
            else if(data == 'no')
            {
                alert('Other user already hold the account.')
                tableCiFundSuccess.ajax.reload(null,false);
            }
            showFundCount();
            checkFArefresh = true;

        }
    });
});

$('#table_success_req_finance').on('click', '.btn_cancel_fund_ci', function()
{
    var btn = $(this);

    var id = btn.attr('name');

    btn.attr('disabled', true);

    if(confirm('Are you sure to cancel the fund request? \n Note : This cannot be revoked'))
    {
        $.ajax
        ({
            type : 'get',
            url : 'finance-cancel-ci-fund',
            data :
                {
                    'id' : id
                },
            success : function()
            {
                tableCiFundSuccess.ajax.reload(null,false);
                showFundCount();
                checkFArefresh = true;
            }
        });
    }
    else
    {
        btn.attr('disabled', false);
    }
});

$('#table_success_req_finance').on('click', '.btn_unhold_fund', function()
{
    var id = $(this).attr('name');

    $.ajax
    ({
        type : 'get',
        url : 'finance-unhold-ci-fund',
        data :
            {
                'id' : id
            },
        success : function(data) {
            if (data == 'ok') {
                tableCiFundSuccess.ajax.reload(null, false);
                checkFArefresh = true;
            }
            else if (data == 'no') {
                alert('Other user remove the hold status of request.')
                tableCiFundSuccess.ajax.reload(null, false);
                checkFArefresh = true;
            }
            else if (data == 'cant')
            {
                alert('Cannot un-hold. The request has no assigned account/s.')
            }
            showFundCount();

        }
    });
});

$('#select_bank_billing').change(function ()
{
    tableBillingReport.draw();
    // billing_rule_func();
});

// $('.datepicks').datepicker({
//     dateFormat: 'yyyy-mm-dd',
//     orientation: "bottom"
// });

$(document).on('click', '.viewable', function()
{
    console.log($('#min').val());
    console.log($('#max').val());
    var today = new Date();

    if($(this).is(":checked"))
    {
        if($(this).val() == 'All')
        {
            $('.viewable#rad_all_fin').prop('checked',true);
            $('.viewable#rad_all_pends').prop('checked',true);

            $('.date_range_conts').css('display','none');

            $('#min').val('2015-01-01');
            $('#max').val('6000-01-01');

            tableBillingReport.draw();
            // billing_rule_func();
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

            // $( "#datepickermin" ).datepicker({ dateFormat: 'yy-mm-dd' });
            // $( "#datepickermax" ).datepicker({ dateFormat: 'yy-mm-dd' });

            $('.datepicks').datepicker({
                dateFormat: 'yy-mm-dd',
                orientation: "bottom"
            });


            $('#datepickermin').val(month+dateyear);
            $('#datepickermax').val(month+dateyear);

            $('#min').val(yearmonth+date);
            $('#max').val(yearmonth+date);



            tableBillingReport.draw();
            // billing_rule_func();
        }
    }
});

$('#datepickermin').change( function() {

    var min = $.datepicker.formatDate('yy-mm-dd', $('#datepickermin').datepicker('getDate'));
    $('#min').val(min);

    var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax').datepicker('getDate'));

    if(max === '')
    {
        $('#max').val(yearmonth+date);

    }
    else {
        $('#max').val(max);
    }
    tableBillingReport.draw();
    // billing_rule_func();
});

$('#datepickermax').change( function() {

    var min = $.datepicker.formatDate('yy-mm-dd', $('#datepickermin').datepicker('getDate'));
    $('#min').val(min);

    var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax').datepicker('getDate'));

    if(max === '')
    {
        $('#max').val(yearmonth+date);

    }
    else {
        $('#max').val(max);
    }
    tableBillingReport.draw();
    // billing_rule_func();
});


$('#table_fund_for_online_upload').on('click', '.btnReviseFundRequest', function()
{
    var btn = $(this);

    var id = btn.attr('name');

    $('#done-'+id+'').attr('disabled', true);

    $.ajax
    ({
        type : 'get',
        url : 'finance-revise-fund-request',
        data :
            {
                'id' : id
            },
        success : function()
        {
            table_for_upload_online.ajax.reload(null, false);
            counterReReq = true;
        }
    });
});

function manageList()
{
    $.ajax
    ({
        type : 'get',
        url : 'finance-get-manage-list',
        success : function(data)
        {
            for(var i = 0; i < data.length ; i++)
            {
                managementList += data[i].name + ', ';
            }

            console.log(managementList);
        }
    });
}

$('#table_fund_req_approved_finance').on('click', '.btnShowRemarksRequestor', function()
{
    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#dispatcher_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks').val(get_rem_name[0]);
});

$('#table_fund_req_approved_finance').on('click', '.btnViewManagementRem', function()
{
    $('#req_rem_remarks_manage').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem-manage').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#manage_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks_manage').val(get_rem_name[0]);

});

$('#table_fund_for_online_upload').on('click','#check_remarks_requestor',function () {

    //for online upload success

    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var id = $(this).attr('name');

    // console.log(id);

    $.ajax({
        url : 'finance_fund_get_requestor_remarks',
        type : 'get',
        data : {
            'id' : id
        },
        success : function(data)
        {

            console.log(data);

            var get_remarks_text = '';
            var get_remarks_name = '';

            if(data[0].manage_id == 0 || data[0].manage_id == null) //normal request
            {
                get_remarks_text = data[0].disp_remarks;
                get_remarks_name = data[0].disp_name;
            }
            else
            {
                get_remarks_text = data[0].sao_remarks;
                get_remarks_name = data[0].sao_name;
            }

            $('#dispatcher_req_name').text(get_remarks_name);
            $('#req_rem_remarks').val(get_remarks_text);
        },
        error : function () {
            console.log('error');
        }
    });


});

$('#table_success_req_finance').on('click','#check_remarks_requestor',function () {

    //for online upload success

    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var id = $(this).attr('name');

    // console.log(id);

    $.ajax({
        url : 'finance_fund_get_requestor_remarks',
        type : 'get',
        data : {
            'id' : id
        },
        success : function(data)
        {

            console.log(data);

            var get_remarks_text = '';
            var get_remarks_name = '';

            if(data[0].manage_id == 0 || data[0].manage_id == null) //normal request
            {
                get_remarks_text = data[0].disp_remarks;
                get_remarks_name = data[0].disp_name;
            }
            else
            {
                get_remarks_text = data[0].sao_remarks;
                get_remarks_name = data[0].sao_name;
            }

            $('#dispatcher_req_name').text(get_remarks_name);
            $('#req_rem_remarks').val(get_remarks_text);
        },
        error : function () {
            console.log('error');
        }
    });


});

$('#table-finance-expenses-report').on('click','#check_remarks_requestor',function () {

    //for online upload success

    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var id = $(this).attr('name');

    // console.log(id);

    $.ajax({
        url : 'finance_fund_get_requestor_remarks',
        type : 'get',
        data : {
            'id' : id
        },
        success : function(data)
        {

            console.log(data);

            var get_remarks_text = '';
            var get_remarks_name = '';

            if(data[0].manage_id == 0 || data[0].manage_id == null) //normal request
            {
                get_remarks_text = data[0].disp_remarks;
                get_remarks_name = data[0].disp_name;
            }
            else
            {
                get_remarks_text = data[0].sao_remarks;
                get_remarks_name = data[0].sao_name;
            }

            $('#dispatcher_req_name').text(get_remarks_name);
            $('#req_rem_remarks').val(get_remarks_text);
        },
        error : function () {
            console.log('error');
        }
    });
});

$('#show_modify').click(function()
{
    $('.show_modify').hide();
    $('.clicked_modify').show();
    $('.clicked_modify_val').attr('disabled', false);
});

$('#hide_modify').click(function()
{
    $('.show_modify').show();
    $('.clicked_modify').hide();
    $('.clicked_modify_val').attr('disabled', true);
});

$('#financeExpenseEdit').click(function()
{
    var btn = $(this);
    var aray_editted_id = [];
    var aray_editted = [];
    var array_sum = 0;
    var to_go = false;

    $('.clicked_modify_val').each(function()
    {
        if($(this).val() != '')
        {
            aray_editted.push($(this).val());
            aray_editted_id.push($(this).attr('name'));
            array_sum = parseInt($(this).val()) + array_sum;
            to_go = true;
        }
        else
        {
            alert('Fill-up all expenses fields');
            to_go = false;
            return false;
        }
    });

    if(to_go)
    {
        if(array_sum <= parseInt($('#ci_req_amount_check').val()))
        {
            btn.attr('disabled', true);
            $.ajax({
                type: 'get',
                url: 'finance_edit_ci_expenses',
                data: {
                    'fund_id' : fundIDliq,
                    'aray_editted' : aray_editted,
                    'aray_editted_id' : aray_editted_id,
                    'array_sum' : array_sum,
                    'old_array_sum' : parseInt($('#ci_req_amount_check').val()),
                    'finance_remarks' : $('#finance_ci_liq_remssss').val()
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
                },
                complete: function()
                {
                    btn.attr('disabled', false);
                    $('#finance_ci_liq_remssss').val('');
                    $('#modal-view-ci-liq-img').modal('hide');
                }
            });
        }
        else
        {
            alert('Edited amount exceeded the requested fund');
        }
    }

});

$('#table_fund_req_approved_finance').on('click', '.fundReq_cancel', function()
{
    var fund_id = $(this).attr('idd');
    var btn = $(this);
    if(confirm('Are you sure to cancel fund request with fund id ' + atob(fund_id) + '? \n Note: This cannot be revoked'))
    {
        btn.attr('disabled', true);
        $.ajax({
            type: 'get',
            url: 'finance_cancel_fund_request',
            data: {
                'id' : fund_id
            },
            success: function(data)
            {
                console.log(data);
                if(data == 'success')
                {
                    btn.attr('disabled', false);
                    tableCiFundApproved.draw();
                    alert('Fund Request SUccessfully Cancelled');
                }
                console.log(data);
            },
            error: function(e)
            {
                btn.attr('disabled', false);
                alert('Error occured. Please contact administrator');
                console.log('error: '+ e);
            }
        });
    }
});


function eqProcessTablePending()
{
    $('#finance_eq_process_pending thead th').each(function()
    {
        eq_process_table_1[eq_pr_1] = $(this).text();
        eq_pr_1++;
    });
    tableProcssEq1 = $('#finance_eq_process_pending').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Equipment Process Monitoring',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return eq_process_table_1[(idx)];
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
                        return eq_process_table_1[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/finance_eq_proc_pending_table",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'name', name : 'admin_requisition.requestor_name'},
                {data: 'date', name : 'admin_requisition.date_request'},
                {data : 'tor', name : 'admin_requisition_categ.req_tor'},
                {data : 'categ', name : 'admin_requisition_categ.req_categ'},
                {data : 'type_1', name : 'admin_requisition_categ.req_type_1'},
                {
                    data : function type(data)
                    {
                        if(data.type_2 == 'Others')
                        {
                            return data.others;
                        }
                        else
                        {
                            return data.type_2;
                        }
                    },
                    name : 'admin_requisition_categ.req_type_2'
                },
                {
                    data : function act(data)
                    {
                        return '<button class="btn btn-md btn-block btn-primary btnViewInfoEqProcFin" name = "'+btoa(data.id)+'"> View Info</button>' +
                            '<button class="btn btn-md btn-block btn-info btnViewPOEqProcFin" name = "'+btoa(data.id)+'"> View P.O</button>' +
                            '<button class="btn btn-md btn-block btn-warning btnViewAddInstructFin" name = "'+btoa(data.id)+'"> Remarks/Attachments</button>';
                    }
                },
                {data : 'others', name : 'admin_requisition_categ.req_others', visible : false}

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

    $('#finance_eq_process_pending_filter input').unbind();
    $('#finance_eq_process_pending_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProcssEq1.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProcssEq1.search($(this).val()).draw();
                }
            }
        }
    });
}


$('#finance_eq_process_pending').on('click', '.btnViewInfoEqProcFin', function()
{
    var id = atob($(this).attr('name'));
    $('.toClear').val('').attr('disabled', true);
    $('.toDisable').attr('disabled', true);
    $('.requiList').attr('disabled', true);

    $('#showHideSendRequestRequi').hide();

    viewReqModal(id, 'proc');

    $('#modal-requisition_form').modal('show');
});

$('#finance_eq_process_pending').on('click', '.btnViewPOEqProcFin', function()
{
    var id = atob($(this).attr('name'));

    clearPOAll();

    viewPOInfo(id)
});

function viewReqModal(id, ty)
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

            console.log(data)

            if(ty == 'app')
            {
                $('#dateOfRequestAdmin_view').val(data[0][0].date_request);
                $('#requestedRequi_view').val(data[0][0].requestor_name);
                $('#officeLocRequi_view').val(data[0][0].office_loc_dep_pos);
                $('#dateNeededRequi_view').val(data[0][0].date_needed);
                $('#approvedByRequi_view').val(data[0][0].approved_by);
                $('#approvalDateRequi_view').val(data[0][0].approval_date);
                $('#totalAmountRequi_view').val(data[0][0].items_grand_total);
                $('#req_reason_remarks_view').val(data[0][0].req_reason_remarks);
                $('#otherCheck-0_view').val(data[0][0].other_check_0);
                $('#otherCheck-1_view').val(data[0][0].other_check_1);
                $('#otherCheck-2_view').val(data[0][0].other_check_2);
                $('#approveRequestReq').attr('name', data[0][0].id);
                $('#rejectRequestReq').attr('name', data[0][0].id);
                $('#requestedRequiFor_view').val(data[0][0].requested_for);
                $('#requestedRequiForID_view').val(data[0][0].requested_for_id);

                if(data[0][0].req_reason == 'New Request')
                {
                    $('#clickNew').attr('checked', true)
                }
                else
                {
                    $('#clickReplacement').attr('checked', true)
                }

                $('.requiListview').each(function()
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

                $('#appBrandview').html(' <tr>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Unit Price</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Total Amount\n' +
                    '                                            </th>\n' +
                    '                            </tr>');

                for(var t = 0; t < data[2].length ; t++)
                {
                    $('#appBrandview').append('<tr">\n' +
                        '                                <td colspan="1"> <textarea class = "form-control" rows ="2" disabled>'+data[2][t].brand_item_desc+'</textarea></td>\n' +
                        '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_quantity+'" disabled></td>\n' +
                        '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_unit_price+'" disabled></td>\n' +
                        '                                <td colspan="1">   <input type="number" class="form-control" value = "'+data[2][t].total_amount+'" disabled>\n' +
                        '                                </td>\n' +
                        '                            </tr>');
                }
            }
            else if(ty == 'proc')
            {
                $('#dateOfRequestAdmin').val(data[0][0].date_request);
                $('#requestedRequi').val(data[0][0].requestor_name);
                $('#officeLocRequi').val(data[0][0].office_loc_dep_pos);
                $('#dateNeededRequi').val(data[0][0].date_needed);
                $('#approvedByRequi').val(data[0][0].approved_by);
                $('#approvalDateRequi').val(data[0][0].approval_date);
                $('#totalAmountRequi').val(data[0][0].items_grand_total);
                $('#req_reason_remarks').val(data[0][0].req_reason_remarks);
                $('#otherCheck-0').val(data[0][0].other_check_0);
                $('#otherCheck-1').val(data[0][0].other_check_1);
                $('#otherCheck-2').val(data[0][0].other_check_2);
                $('#requestedRequiFor').val(data[0][0].requested_for);
                $('#requestedRequiForID').val(data[0][0].requested_for_id)

                if(data[0][0].req_reason == 'New Request')
                {
                    $('#newReq').attr('checked', true).attr('disabled', true);
                }
                else
                {
                    $('#replaceRequi').attr('checked', true).attr('disabled', true);
                }

                $('.requiList').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[1].length; i++)
                    {
                        if(data[1][i].check_name == check)
                        {
                            $(this).prop('checked', true).attr('disabled', true);;
                        }
                    }
                });

                $('#appBrand').html(' <tr>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Unit Price</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Total Amount\n' +
                    '                                            </th>\n' +
                    '                            </tr>');

                for(var t = 0; t < data[2].length ; t++)
                {
                    $('#appBrand').append('<tr">\n' +
                        '                                <td colspan="1"> <textarea class = "form-control" rows ="2" disabled>'+data[2][t].brand_item_desc+'</textarea></td>\n' +
                        '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_quantity+'" disabled></td>\n' +
                        '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_unit_price+'" disabled></td>\n' +
                        '                                <td colspan="1">   <input type="number" class="form-control" value = "'+data[2][t].total_amount+'" disabled>\n' +
                        '                                </td>\n' +
                        '                            </tr>');
                }

            }




        }
    })
}

function viewPOInfo(id)
{
    $.ajax
    ({
        type : 'get',
        url : 'finance_get_po_details',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            var date = (data[0][0].date_accred).split(' ');

            $('#poNumberFin').val(data[0][0].po_no);
            $('#poDateFin').val(data[0][0].po_date);
            $('#selectSupForPOFin').val(data[0][0].supp_name);
            $('#contactPersonPOFin').val(data[0][0].contact_person);
            $('#addressInfoPOFin').val(data[0][0].supp_address);
            $('#contactInfoPOFin').val(data[0][0].con_num + '/' + data[0][0].sup_email);
            $('#dateAccredPOFibn').val(date[0]);
            $('#termsSupForPOFin').val(data[0][0].supp_term);
            $('#dateDeliverPOFin').val(data[0][0].delivery_date);
            $('#totalAmtPOFin').val(data[0][0].amount);
            $('#twelveVatPOFin').val(data[0][0].twelve);
            $('#grandTotalPOFin').val(data[0][0].grand_total);
            $('#preparedByPOFin').val(data[0][0].name);


            if(data[1].length > 0)
            {
                for(var y = 0; y < data[1].length; y++)
                {
                    $('#addBrandTablePOFin').append('<tr>\n' +
                        '                                        <td colspan="1"><textarea class = "form-control " rows ="2" disabled>'+data[1][y].brand_item_desc+'</textarea></td>\n' +
                        '                                        <td colspan="1"><input type="number" class="form-control" value = "'+data[1][y].quantity+'" disabled></td>\n' +
                        '                                        <td colspan="1"><input type="number" class="form-control" value = "'+data[1][y].unit_price+'" disabled></td>\n' +
                        '                                        <td colspan="1"><input type="number" class="form-control"  value = "'+data[1][y].total_amount+'" disabled>'+
                        '                                        </td>\n' +
                        '                                    </tr>');
                }
            }

            if(data[2].length > 0 )
            {
                for(var t = 0; t < data[2].length; t++)
                {
                    $('#additionalNotesTablePOFin').append('<tr>\n' +
                        '                                        <td colspan="1" ><textarea class = "form-control" rows ="2" disabled>'+data[2][t].additional_notes+'</textarea></td>\n' +
                        '                                    </tr>')
                }
            }



        }
    });

}

function clearPOAll()
{
    $('#addBrandTablePOFin').html('<tr>\n' +
        '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>\n' +
        '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>\n' +
        '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; ">Unit Price</th>\n' +
        '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span style = " padding-top : 10px;">Total Amount</span></th>\n' +
        '                                    </tr>');

    $('#additionalNotesTablePOFin').html('   <tr>\n' +
        '                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Additional Notes</th>\n' +
        '                                    </tr>');

    $('.clearPOFieldsFin').val('');
}

$('#clearFieldsPOFin').click(function()
{
    clearPOAll();
});

$('#finance_eq_process_pending').on('click', '.btnViewAddInstructFin', function()
{
    var id = $(this).attr('name');

    $('#btnSummitFinRequi').attr('name', id);

    $('#modal-admin-requi-instructions').modal('show');
});



$('.btnAddAttachInstruction').click(function()
{
    $('#storageInstruct').append('<div class = "row" style = "padding-top : 10px;" id = "rowtoRemoveFileFinRequi-'+requi_instruction_count+'"><div class="col-md-1"></div>\n' +
        '                                            <div class="col-md-6">\n' +
        '                                                <span><input type="file" class ="file_instruct_requi"></span>\n' +
        '                                            </div> ' +
        '                                            <div class="col-md-5"><button class="btn btn-danger btn-xs removeRowFileFinRequi" name = "'+requi_instruction_count+'"><i class="fa fa-fw fa-close"></i></button></div>\n' +
        '                                        </div>');

    requi_instruction_count++;

    deleteFileRequi();
});

function deleteFileRequi()
{
    $('.removeRowFileFinRequi').click(function()
    {
        var id = $(this).attr('name');
        $('#rowtoRemoveFileFinRequi-'+id+'').remove();
    });
}

$('#btnSummitFinRequi').click(function()
{
    var id = atob($(this).attr('name'));
    var rem = $('#addInstructFin').val();
    var fileCount = 0;
    var formdata = new FormData;

    formdata.append('id', id);
    formdata.append('remarks', rem);

    $('.file_instruct_requi').each(function()
    {
        formdata.append('file-'+fileCount+'', $(this).prop('files')[0]);

        fileCount++;
    });

    formdata.append('count', fileCount);

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
                    $('#ulPercentage_requi_fin').html('');
                    $('#ulPercentage_requi_fin').show();
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_requi_fin').append(Math.floor(percentComplete*100));
                    $('#progressbar_requi_fin').show();
                    $('#progressbar_requi_fin').progressbar
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
        url : 'finance_requisition_add_instruction',
        contentType: false,
        processData: false,
        async : true,
        data : formdata,
        success : function()
        {

        },
        complete : function()
        {
            alert('Successfully submitted!');

            $('#btnSummitFinRequi').removeAttr('name');
            requi_instruction_count = 0;
            clearPOAll();
            $('#addInstructFin').val('');
            $('#storageInstruct').html('');
            $('#modal-admin-requi-instructions').modal('hide');
            tableProcssEq1.ajax.reload(null, false);

            $('#progressbar_requi_fin').hide();
            $('#ulPercentage_requi_fin').html('');

            finrequiBool = true;
        }
    });
});



$('.finance_admin_req_info_class').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tabFinProc_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeProcMonFin = '#tabFinProc_1';
        }
        else if (eq_po_to_fin_1) {
            console.log('already loaded');
            activeProcMonFin = '#tabFinProc_1';
        }
        else if (eq_po_to_fin_1 == false) {
            eq_po_to_fin_1 = true;
            activeProcMonFin = '#tabFinProc_1';
        }
    }
    else if (gethref == '#tabFinProc_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeProcMonFin = '#tabFinProc_2';
        }
        else if (eq_po_to_fin_2) {
            if(finrequiBool == true)
            {
                tableProcssEq2.ajax.reload(null, false);
                finrequiBool = false;
            }
            else
            {
                console.log('already loaded');
            }

            activeProcMonFin = '#tabFinProc_2';
        }
        else if (eq_po_to_fin_2 == false) {
            eq_po_to_fin_2 = true;
            activeProcMonFin = '#tabFinProc_2';
            eqProcessTablePending2()
        }
    }
});


function eqProcessTablePending2()
{
    $('#finance_eq_process_pending thead th').each(function()
    {
        eq_process_table_2[eq_pr_2] = $(this).text();
        eq_pr_2++;
    });
    tableProcssEq2 = $('#finance_eq_process_done').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Equipment Process Monitoring',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return eq_process_table_2[(idx)];
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
                        return eq_process_table_2[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/finance_eq_proc_done_table",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'name', name : 'admin_requisition.requestor_name'},
                {data: 'date', name : 'admin_requisition.date_request'},
                {data : 'tor', name : 'admin_requisition_categ.req_tor'},
                {data : 'categ', name : 'admin_requisition_categ.req_categ'},
                {data : 'type_1', name : 'admin_requisition_categ.req_type_1'},
                {
                    data : function type(data)
                    {
                        if(data.type_2 == 'Others')
                        {
                            return data.others;
                        }
                        else
                        {
                            return data.type_2;
                        }
                    },
                    name : 'admin_requisition_categ.req_type_2'
                },
                {
                    data : function act(data)
                    {
                        var addRem = '';

                        if(data.req_stat == 'Done')
                        {
                            addRem = '<button class = "btn btn-md btn-success btn-block btnViewRemDone" name = "'+btoa(data.id)+'" rem ="'+data.done_rem+'">Done Remarks</button>';
                        }



                        return '<button class="btn btn-md btn-block btn-primary btnViewInfoEqProcFin" name = "'+btoa(data.id)+'"> View Info</button>' +
                            '<button class="btn btn-md btn-block btn-info btnViewPOEqProcFin" name = "'+btoa(data.id)+'"> View P.O</button>' +
                            '<button class = "btn btn-md btn-warning btn-block btnViewRemAttachFin" name = "'+btoa(data.id)+'">View Remarks/Attachments</button> ' +
                            addRem;
                    }
                },
                {data : 'others', name : 'admin_requisition_categ.req_others', visible : false}

            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.req_stat == 'Done')
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', 'white');
            }
            else
            {
                $(nRow).css('background-color', 'white');
            }
        },
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

    $('#finance_eq_process_done_filter input').unbind();
    $('#finance_eq_process_done_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProcssEq2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProcssEq2.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#finance_eq_process_done').on('click', '.btnViewInfoEqProcFin', function()
{
    var id = atob($(this).attr('name'));
    $('.toClear').val('').attr('disabled', true);
    $('.toDisable').attr('disabled', true);
    $('.requiList').attr('disabled', true);

    $('#showHideSendRequestRequi').hide();

    viewReqModal(id, 'proc');

    $('#modal-requisition_form').modal('show');
});

$('#finance_eq_process_done').on('click', '.btnViewPOEqProcFin', function()
{
    var id = atob($(this).attr('name'));

    clearPOAll();

    viewPOInfo(id)
});

$('#finance_eq_process_done').on('click', '.btnViewRemAttachFin', function()
{
    var id = atob($(this).attr('name'));

    getRequiFinFiles(id);
});

function getRequiFinFiles(id)
{
    $.ajax
    ({
        type : 'get',
        url : 'admin_staff_get_attach_rem_fin',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            $('#addInstructFinView').val('');
            $('#po_fin_requi_files_table').html('');

            var tableHead = '<tr style="background-color: black; color:white">' +
                '<td>File Name/s</td>' +
                '</tr>';

            if(data[1].length > 0)
            {
                for(var j = 0; j < data[1].length; j++)
                {
                    tableHead += '<tr>' +
                        '<td><a target="_blank" href="view-requi-file?id='+btoa(id)+'&n='+btoa(data[1][j].file_name)+'" name="'+id+'" title="Click the file name to download">'+data[1][j].file_name+'</a></td>' +
                        '</tr>';
                }
            }
            else
            {
                tableHead += '<tr>' +
                    '<td><b>No Uploaded File.</b></td>' +
                    '</tr>';
            }

            $('#addInstructFinView').val(data[0][0].finance_remarks);
            $('#po_fin_requi_files_table').html(tableHead);

            $('#modal-view-rem-attach-requi-finance').modal('show');
        }
    });


}

$('#finance_eq_process_done').on('click', '.btnViewRemDone', function()
{
    $('#view_admin_approve_requi_done_remarks').val('');
    $('#modal_view_approver_rem_requi_done').modal('show');
    $('#view_admin_approve_requi_done_remarks').val($(this).attr('rem'));
});


function cc_billing_rep_table()
{
    $('#cc_billing_report_table thead tr th').each(function()
    {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    cc_billing_report_table = $('#cc_billing_report_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
        {
            url: "cc_billing_report_table",
            data: function (d)
            {
                d.search_option = $('#select_cc_client').val();
                d.q_max =  $('#cc_billing_date_range_max').val();
                d.q_min =  $('#cc_billing_date_range_min').val();
            }
        },
        "columns":
            [
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-default cc_add_accnt_invo" href="'+data.id+'" what="'+data.id+'|-|-|'+data.account_name+'|-|-|'+data.address+' '+data.muni_name+' '+data.prov_name+'">SELECT</button>';

                    },
                    'name': 'bi_endorsements.id',
                    'orderable': false,
                    'searchable': false
                },
                {data: 'id', name: 'bi_endorsements.id'},
                {data: 'date_time_endorse', name: 'bi_endorsements.created_at'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'address', name: 'bi_endorsements.present_address'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'prov_name', name: 'provinces.name'},
                {data: 'status', name: 'bi_endorsements.id', orderable: false, searchable: false},
                {
                    data: function date_time(data)
                    {
                        if(data.status2 != 10)
                        {
                            return 'N/A';
                        }
                        else
                        {
                            return data.time_sent;
                        }
                    },
                    'name': 'bi_endorsements.date_time_finished'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "drawCallback": function()
        {
            var getIds = [];
            $('#cc_invoice_list_table tbody tr').each(function()
            {
                getIds.push($(this).attr('position'));
            });


            $('#cc_billing_report_table tbody tr td .cc_add_accnt_invo').each(function()
            {
                var mainTableButton = $(this);
                var checkIfHas = $(this).attr('href');
                $('#cc_invoice_list_table tbody tr').each(function()
                {
                    if(checkIfHas == $(this).attr('position'))
                    {
                        mainTableButton.text('UN-SELECT');
                    }
                });
            });

            if($('#cc_invoice_list_table tbody tr').length <= 0)
            {
                $('#cc_billing_total').text('');
            }
        },
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

    $('#cc_billing_report_table_filter input').unbind();
    $('#cc_billing_report_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                cc_billing_report_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    cc_billing_report_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#select_cc_client').change(function()
{
    $('#cc_invoice_list_table tbody tr').each(function()
    {
        $(this).remove();
    });

    if($('#select_cc_client').val() != '')
    {
        $('#add-manually-acc').attr('disabled', false);
    }
    else
    {
        $('#add-manually-acc').attr('disabled', true);
    }

    cc_billing_report_table.draw();
});

$('#select_cc_bank_client').change(function()
{
    $('#cc_bank_invoice_list_table tbody tr').each(function()
    {
        $(this).remove();
    });

    if($('#select_cc_bank_client').val() != '')
    {
        $('#add-manually-acc-cc-bank').attr('disabled', false);
    }
    else
    {
        $('#add-manually-acc-cc-bank').attr('disabled', true);
    }

    cc_bank_billing_report_table.draw();
});

$('.cc_billing_report_tabs').click(function()
{
    var gethref = $(this).attr('href');

    if (gethref == '#bi_rate_rep1')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (cc_billing_rep) {
            console.log('already loaded');
        }
        else if (cc_billing_rep == false) {
            cc_billing_rep = true;
        }
    }
    else if (gethref == '#bi_rate_rep2')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (cc_bank_billing_rep) {
            console.log('already loaded');
        }
        else if (cc_bank_billing_rep == false) {
            cc_bank_billing_rep = true;
            cc_bank_billing_rep_table();
            if($('#select_cc_bank_client').val() != '')
            {
                $('#add-manually-acc-cc-bank').attr('disabled', false);
            }
            else
            {
                $('#add-manually-acc-cc-bank').attr('disabled', true);
            }
        }
    }
});

function cc_bank_billing_rep_table()
{
    $('#cc_bank_billing_report_table thead tr th').each(function()
    {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    cc_bank_billing_report_table = $('#cc_bank_billing_report_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                url: "cc_bank_billing_report_table",
                data: function (d)
                {
                    d.search_option = $('#select_cc_bank_client').val();
                    d.q_max =  $('#cc_bank_billing_date_range_max').val();
                    d.q_min =  $('#cc_bank_billing_date_range_min').val();
                }
            },
        "columns":
            [
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-default cc_bank_add_accnt_invo" href="'+data.id+'" what="'+data.id+'|-|-|'+data.account_name+'|-|-|'+data.tor+'">SELECT</button>';
                    },
                    'name': 'bi_endorsements.id',
                    'orderable': false,
                    'searchable': false
                },
                {data: 'id', name: 'bi_endorsements.id'},
                {data: 'date_time_endorse', name: 'bi_endorsements.created_at'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'status', name: 'bi_endorsements.id', orderable: false, searchable: false},
                {
                    data: function date_time(data)
                    {
                        if(data.status2 != 10)
                        {
                            return 'N/A';
                        }
                        else
                        {
                            return data.time_sent;
                        }
                    },
                    'name': 'bi_endorsements.date_time_finished'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "drawCallback": function()
        {
            var getIds = [];
            $('#cc_bank_invoice_list_table tbody tr').each(function()
            {
                getIds.push($(this).attr('position'));
            });


            $('#cc_bank_billing_report_table tbody tr td .cc_bank_add_accnt_invo').each(function()
            {
                var mainTableButton = $(this);
                var checkIfHas = $(this).attr('href');
                $('#cc_bank_invoice_list_table tbody tr').each(function()
                {
                    if(checkIfHas == $(this).attr('position'))
                    {
                        mainTableButton.text('UN-SELECT');
                    }
                });
            });

            if($('#cc_bank_invoice_list_table tbody tr').length <= 0)
            {
                $('#cc_bank_billing_total').text('');
            }
        },
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

    $('#cc_bank_billing_report_table_filter input').unbind();
    $('#cc_bank_billing_report_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                cc_bank_billing_report_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    cc_bank_billing_report_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#cc_billing_report_table').on('click', '.cc_add_accnt_invo', function()
{
    var hinimay = $(this).attr('what').split('|-|-|');

    if($(this).text() == 'SELECT')
    {

        $('#cc_invoice_list_table tbody').append(
            '<tr position="'+hinimay[0]+'">' +
            '<td>'+hinimay[0]+'</td>' +
            '<td>'+hinimay[1]+'</td>' +
            '<td>'+hinimay[2]+'</td>' +
            '<td><input type="number" class="form-control cc_to_bill_account" placeholder="" position="'+hinimay[0]+'" dependent="cc"></td>' +
            '<td><button class="btn btn-sm btn-danger cc_remove_accnt_invo" position="'+hinimay[0]+'">REMOVE</button></td>' +
            '</tr>'
        );

        $('#cc_billing_report_table tbody tr td .cc_add_accnt_invo').each(function()
        {
            if($(this).attr('href') == hinimay[0])
            {
                $(this).text('UN-SELECT');
            }
        });
    }
    else
    {
        $('#cc_invoice_list_table tbody tr').each(function()
        {
            if($(this).attr('position') == hinimay[0])
            {
                $(this).remove();
                $('#cc_billing_report_table tbody tr td .cc_add_accnt_invo').each(function()
                {
                    if($(this).attr('href') == hinimay[0])
                    {
                        $(this).text('SELECT')
                    }
                });
            }
        });
    }
});

$('#cc_invoice_list_table').on('click', '.cc_remove_accnt_invo', function()
{
    var what_id = $(this).attr('position');
    var legend = $(this).attr('forremove');

    $('#cc_invoice_list_table tbody tr').each(function()
    {
        if($(this).attr('position') == 'N/A')
        {
            if($(this).attr('forremove') == legend)
            {
                $(this).remove();
            }
        }
        else if($(this).attr('position') == what_id)
        {
            $(this).remove();
            $('#cc_billing_report_table tbody tr td .cc_add_accnt_invo').each(function()
            {
                if($(this).attr('href') == what_id)
                {
                    $(this).text('SELECT')
                }
            });
        }
    });

    computeBillInput();
});

$('#cc_bank_generate_invoice').click(function(e)
{
    var getId = [];
    var manuallyArray = {};
    var ctr = 0;
    $('#cc_bank_invoice_list_table tbody tr .cc_bank_to_bill_account').each(function()
    {
        // getId.push($(this).attr('position')+ '|-|-|'+ $(this).val());

        var mainEach = $(this);
        if($(this).attr('position') == 'N/A')
        {
            mainEach.closest('tr').each(function()
            {
                var SecondEach = $(this);
                manuallyArray[ctr] = {};

                ctr2 = 0;
                SecondEach.children().each(function()
                {
                    if($(this).attr('get') == 'true')
                    {
                        if($(this).length > 0)
                        {
                            if($(this).children('input').length > 0)
                            {
                                manuallyArray[ctr][$(this).children('input').attr('what')] = $(this).children('input').val();
                            }
                            else
                            {
                                manuallyArray[ctr][$(this).children('label').attr('what')] = $(this).children('label').attr('value');
                            }
                        }
                    }
                });
                ctr++;
            });
        }
        else
        {
            getId.push($(this).attr('position') + '|-|-|' + $(this).val());
        }
    });

    invoiceGeneration(getId, e, 'cc_bank', $('#select_cc_bank_client').val(), manuallyArray);
});

$('#cc_generate_invoice').click(function(e)
{
    var manuallyArray = {};
    var ctr = 0;
    var getId = [];

    $('#cc_invoice_list_table tbody tr .cc_to_bill_account').each(function()
    {
        var mainEach = $(this);
        if($(this).attr('position') == 'N/A')
        {
            mainEach.closest('tr').each(function()
            {
                var SecondEach = $(this);
                manuallyArray[ctr] = {};

                ctr2 = 0;
                SecondEach.children().each(function()
                {
                    if($(this).attr('get') == 'true')
                    {
                        if($(this).length > 0)
                        {
                            if($(this).children('input').length > 0)
                            {
                                manuallyArray[ctr][$(this).children('input').attr('what')] = $(this).children('input').val();
                            }
                            else
                            {
                                manuallyArray[ctr][$(this).children('label').attr('what')] = $(this).children('label').attr('value');
                            }
                        }
                    }
                });
                ctr++;
            });
        }
        else
        {
            getId.push($(this).attr('position') + '|-|-|' + $(this).val());
        }
    });


    invoiceGeneration(getId, e, 'cc', $('#select_cc_client').val(), manuallyArray);
});

$('#cc_bank_billing_report_table').on('click', '.cc_bank_add_accnt_invo', function()
{
    var hinimay = $(this).attr('what').split('|-|-|');

    if($(this).text() == 'SELECT')
    {
        $('#cc_bank_invoice_list_table tbody').append(
            '<tr position="'+hinimay[0]+'">' +
            '<td>'+hinimay[0]+'</td>' +
            '<td>'+hinimay[1]+'</td>' +
            '<td>'+hinimay[2]+'</td>' +
            '<td><input type="number" class="form-control cc_bank_to_bill_account" placeholder="" position="'+hinimay[0]+'" dependent="cc_bank"></td>' +
            '<td><button class="btn btn-sm btn-danger cc_remove_accnt_invo" position="'+hinimay[0]+'">REMOVE</button></td>' +
            '</tr>'
        );

        $('#cc_bank_billing_report_table tbody tr td .cc_bank_add_accnt_invo').each(function()
        {
            if($(this).attr('href') == hinimay[0])
            {
                $(this).text('UN-SELECT');
            }
        });
    }
    else
    {
        $('#cc_bank_invoice_list_table tbody tr').each(function()
        {
            if($(this).attr('position') == hinimay[0])
            {
                $(this).remove();
                $('#cc_bank_billing_report_table tbody tr td .cc_bank_add_accnt_invo').each(function()
                {
                    if($(this).attr('href') == hinimay[0])
                    {
                        $(this).text('SELECT')
                    }
                });
            }
        });
    }
});

$('#cc_bank_invoice_list_table').on('click', '.cc_remove_accnt_invo', function()
{
    var what_id = $(this).attr('position');

    $('#cc_bank_invoice_list_table tbody tr').each(function()
    {
        if($(this).attr('position') == what_id)
        {
            $(this).remove();
            $('#cc_bank_billing_report_table tbody tr td .cc_bank_add_accnt_invo').each(function()
            {
                if($(this).attr('href') == what_id)
                {
                    $(this).text('SELECT')
                }
            });
        }
    });

    computeBillInputCCBank();
});

$('.cc_billing_date_range_func').click(function()
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
    if($(this).attr('id') == 'cc_billing_all')
    {
        $('#cc_billing_picker_holder').hide();
        $('#cc_billing_date_range_max').val('6000-01-01');
        $('#cc_billing_date_range_min').val('2015-01-01');
    }
    else
    {
        $('#cc_billing_picker_holder').show();
        $('#cc_billing_date_range_max').val(newdate);
        $('#cc_billing_date_range_min').val(newdate);
    }

    cc_billing_report_table.draw();
});

$('.cc_date_picker_class').change(function()
{
    cc_billing_report_table.draw();
});

$('.cc_bank_billing_date_range_func').click(function()
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
    if($(this).attr('id') == 'cc_bank_billing_all')
    {
        $('#cc_bank_billing_picker_holder').hide();
        $('#cc_bank_billing_date_range_max').val('6000-01-01');
        $('#cc_bank_billing_date_range_min').val('2015-01-01');
    }
    else
    {
        $('#cc_bank_billing_picker_holder').show();
        $('#cc_bank_billing_date_range_max').val(newdate);
        $('#cc_bank_billing_date_range_min').val(newdate);
    }

    cc_bank_billing_report_table.draw();
});

$('.cc_bank_date_picker_class').change(function()
{
    cc_bank_billing_report_table.draw();
});

function invoiceGeneration(id_array, event, invoice_type, client_id, inputted_array)
{
    console.log([id_array, invoice_type, client_id, inputted_array]);

    if(id_array.length > 0 || Object.keys(inputted_array).length)
    {
        $.ajax({
            type: 'get',
            url: 'finance_create_billing_invoice',
            data: {
                'id_array' : id_array,
                'invoice_type' : invoice_type,
                'client_id' : client_id,
                'inputted_array' : inputted_array

            },
            success: function(data)
            {
                console.log(data)
                alert('Invoice Successfully Created and Sent to Client Panel');
            },
            error: function(e)
            {
                alert('An error occurred. Please contact website administrator thank you');
            },
            complete: function()
            {
                if(invoice_type == 'cc')
                {
                    cc_billing_report_table.draw();
                    $('#cc_invoice_list_table tbody tr').each(function()
                    {
                        $(this).remove();
                    });
                }
                else
                {
                    cc_bank_billing_report_table.draw();
                    $('#cc_bank_invoice_list_table tbody tr').each(function()
                    {
                        $(this).remove();
                    });
                }
            }
        });
    }
    else
    {
        alert('No Selected Accounts');
    }
}

$(document).on('keyup change', '.cc_to_bill_account',function()
{
    computeBillInput();
});

$(document).on('keyup change', '.cc_bank_to_bill_account',function()
{
    computeBillInputCCBank();
});


function computeBillInput()
{
    var valueHolder = [];
    $('.cc_to_bill_account').each(function()
    {
        var vallllll = $(this).val();
        if($(this).val() != '')
        {
            valueHolder.push(parseInt(vallllll));
        }
    });

    $('#cc_billing_total').text(valueHolder.reduce(function(a, b){return a + b;}, 0));
}

function computeBillInputCCBank()
{
    var valueHolder = [];
    $('.cc_bank_to_bill_account').each(function()
    {
        var vallllll = $(this).val();
        if($(this).val() != '')
        {
            valueHolder.push(parseInt(vallllll));
        }
    });

    $('#cc_bank_billing_total').text(valueHolder.reduce(function(a, b){return a + b;}, 0));
}

$('#addAccntManually').click(function()
{
    var randomNumber = 'random-' + Math.round(Math.random() * (9999 - 1) + 1);

    $('#cc_invoice_list_table tbody').append(
        '<tr position="N/A" forremove="'+randomNumber+'">' +
        '<td get="false">MANUALLY INPUTTED</td>' +
        '<td get="true"><label value="'+$('#manualAccntName').val()+'" what="accnt_name">'+$('#manualAccntName').val()+'</label></td>' +
        '<td get="true"><label value="'+$('#manualAccntAdd').val()+'" what="accnt_add">'+$('#manualAccntAdd').val()+'</label></td>' +
        '<td get="true" hidden><label value="N/A" what="type_of_request">N/A</label></td>' +
        '<td get="true"><input type="number" class="form-control cc_to_bill_account" placeholder="" position="N/A" dependent="cc" what="amount"></td>' +
        '<td><button class="btn btn-sm btn-danger cc_remove_accnt_invo" position="N/A" forremove="'+randomNumber+'">REMOVE</button></td>' +
        '</tr>'
    );

    $('#modal-add-account-manually').modal('hide');
    $('#manualAccntName').val('');
    $('#manualAccntAdd').val('');
});

$('#addAccntManuallyBank').click(function()
{
    var randomNumber = 'random-' + Math.round(Math.random() * (9999 - 1) + 1);

    $('#cc_bank_invoice_list_table tbody').append(
        '<tr position="N/A" forremove="'+randomNumber+'">' +
        '<td get="false">MANUALLY INPUTTED</td>' +
        '<td get="true"><label value="'+$('#manualAccntNameBank').val()+'" what="accnt_name">'+$('#manualAccntNameBank').val()+'</label></td>' +
        '<td get="true" hidden><label value="N/A" what="accnt_add">N/A</label></td>' +
        '<td get="true"><label value="'+$('#manualAccntTorBank').val()+'" what="type_of_request">'+$('#manualAccntTorBank').val()+'</label></td>' +
        '<td get="true"><input type="number" class="form-control cc_bank_to_bill_account" placeholder="" position="N/A" dependent="cc" what="amount"></td>' +
        '<td><button class="btn btn-sm btn-danger cc_remove_accnt_invo" position="N/A" forremove="'+randomNumber+'">REMOVE</button></td>' +
        '</tr>'
    );

    $('#modal-add-account-manually-bank').modal('hide');
    $('#manualAccntNameBank').val('');
    $('#manualAccntTorBank').val('');
});

function cc_billing_table_func()
{
    $('#cc_billing_table thead tr th').each(function()
    {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    cc_billing_table = $('#cc_billing_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                url: "cc_billing_table",
                data: function (d)
                {
                    d.search_option = $('#select_cc_client_table').val();
                    d.q_max =  $('#billing_cc_rad_max').val();
                    d.q_min =  $('#billing_cc_rad_min').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'bi_endorsements.id'},
                {data: 'date_time_endorse', name: 'bi_endorsements.created_at'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'address', name: 'bi_endorsements.present_address'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'prov_name', name: 'provinces.name'},
                {data: 'status', name: 'bi_endorsements.id', orderable: false, searchable: false},
                {
                    data: function date_time(data)
                    {
                        if(data.status2 != 10)
                        {
                            return 'N/A';
                        }
                        else
                        {
                            return data.time_sent;
                        }
                    },
                    'name': 'bi_endorsements.date_time_finished'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if(aData.billing_status == null || aData.billing_status == '')
            {
                $('td', nRow).css('background-color', '');
            }
            else if(aData.billing_status != null || aData.billing_status != '')
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }
        },
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

    $('#cc_billing_table_filter input').unbind();
    $('#cc_billing_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                cc_billing_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    cc_billing_table.search($(this).val()).draw();
                }
            }
        }
    });

    $('.billing_cc_rad').change(function()
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
        console.log($(this).attr('id'));
        if($(this).attr('id') == 'billing_cc_rad_all')
        {
            $('#billing_cc_range_holder').hide();
            $('#billing_cc_rad_max').val('6000-01-01');
            $('#billing_cc_rad_min').val('2015-01-01');
        }
        else
        {
            $('#billing_cc_range_holder').show();
            $('#billing_cc_rad_max').val(newdate);
            $('#billing_cc_rad_min').val(newdate);
        }

        cc_billing_table.draw();
    });

    $('#select_cc_client_table').change(function()
    {
        cc_billing_table.draw();
    });

    $('.billing_cc_date').change(function()
    {
        cc_billing_table.draw();
    });
}


function cc_bank_billing_table_func()
{
    $('#cc_bank_billing_table thead tr th').each(function()
    {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    cc_bank_billing_table = $('#cc_bank_billing_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                url: "cc_bank_billing_table",
                data: function (d)
                {
                    d.search_option = $('#select_cc_bank_client_table').val();
                    d.q_max =  $('#billing_cc_bank_rad_max').val();
                    d.q_min =  $('#billing_cc_bank_rad_min').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'bi_endorsements.id'},
                {data: 'date_time_endorse', name: 'bi_endorsements.created_at'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'status', name: 'bi_endorsements.id', orderable: false, searchable: false},
                {
                    data: function date_time(data)
                    {
                        if(data.status2 != 10)
                        {
                            return 'N/A';
                        }
                        else
                        {
                            return data.time_sent;
                        }
                    },
                    'name': 'bi_endorsements.date_time_finished'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if(aData.billing_status == null || aData.billing_status == '')
            {
                $('td', nRow).css('background-color', '');
            }
            else if(aData.billing_status != null || aData.billing_status != '')
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }
        },
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

    $('#cc_bank_billing_table_filter input').unbind();
    $('#cc_bank_billing_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                cc_bank_billing_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    cc_bank_billing_table.search($(this).val()).draw();
                }
            }
        }
    });

    $('.billing_cc_bank_rad').change(function()
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
        console.log($(this).attr('id'));
        if($(this).attr('id') == 'billing_cc_bank_rad_all')
        {
            $('#billing_cc_bank_range_holder').hide();
            $('#billing_cc_bank_rad_max').val('6000-01-01');
            $('#billing_cc_bank_rad_min').val('2015-01-01');
        }
        else
        {
            $('#billing_cc_bank_range_holder').show();
            $('#billing_cc_bank_rad_max').val(newdate);
            $('#billing_cc_bank_rad_min').val(newdate);
        }

        cc_bank_billing_table.draw();
    });

    $('#select_cc_bank_client_table').change(function()
    {
        cc_bank_billing_table.draw();
    });

    $('.billing_cc_bank_date').change(function()
    {
        cc_bank_billing_table.draw();
    });
}