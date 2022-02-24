var table1 = [];
var table2 = [];
var table3 = [];
var table4 = [];
var table5 = [];
var table8 = [];
var table9 = [];
var table10 = [];
var table12 = [];
var table13 = [];
var table14 = [];
var table15 = [];
var table16 = [];
var table17 = [];
var table18 = [];
var table19 = [];
var u = 0;
var v = 0;
var w =0;
var x= 0;
var y= 0;
var ab = 0;
var abc = 0;
var tableAdminStaff, tableAdminStaffSubmitted, tableAdminStaffHold, tableAdminStaffCancel,
    tableAdminSupplier, tableItemAssign, tableArView, tableItemHistory,
    tableAdminAssignLogs, tableEmpItemAssign, tableFundList, tableGeneralItem,
    tableGeneralAr, tableGeneralRequest, tableGeneralFund, tableGeneralOut, tableGenSupplier,
    tableEditGeneralItem, tableGeneralPo, tableEmployeeListAdmin, tableEmployeeApproveListAdmin;
var which_is_active = 'admin-staff-monitoring_tab';
var admin_staff_general_tab_bool = true;
var admin_staff_request_tab_bool = false;
var admin_staff_profile_tab_bool = false;
var admin_staff_fund_tab_bool = false;
var admin_staff_inventory_tab_bool = false;
var admin_staff_emp_list_bool = false;
var admin_staff_requi_monit = false;
var admin_staff_accred_sup = false;
var admin_staff_eq_process_bool = false;
var admin_staff_eq_gen_requi = false
var admin_staff_incident_tab = false;
var acctID;
var countSubmit = false;
var countHold = false;
var countCancel = false;
var activeSupply = 'tab_Add';
var admin_staff_add_supply = true;
var admin_staff_info_supply = false;
var optionExisting = false;
var optionNew = false;
var submitTab = false;
var activeRequest = 'tab_a';
var admin_staff_ongoing_request = true;
var admin_staff_submitted_request = false;
var admin_staff_hold_request = false;
var admin_staff_cancelled_request =false;
var activeEq = 'tab_eq1';
var admin_staff_show = false;
var admin_staff_assign_tab = false;
var admin_staff_ar = false;
var k = 0;
var tableItem = [];
var p = 0;
var countItem = false;
var viewExpID;
var counterAssign = false;
var counterRemove = false;
var ar_selected_id;
var ar_remarks = [];
var ar_date_time  = [];
var ar_path  = [];
var h = 0;
var showItemId;
var yu = 0;
var ty = 0;
var counterAr = 0;
var ar_info_id;
var tableFund = [];
var fund_table = 0;
var activeFund = '#tab_fund1';
var admin_fund_show = true;
var admin_fund_add = false;
var counterFund = false;
var fundUpdateId;
var table_ar = [];
var counterOutgoing = false;
var btntoHide = false;
var remAss;
var poi = 0;
var counterGeneralView = 0;
var poi2 = 0;
var counterGeneralAr = 0;
var poi3 = 0;
var poi4= 0;
var poi5 = 0;
var poi6 = 0;
var poi7 = 0;
var poi8 = 0;
var activeGeneral = '#tab_gen1';
var admin_general1 = true;
var admin_general2 = false;
var admin_general3 = false;
var admin_general4  = false;
var admin_general5  = false;
var admin_general6  = false;
var admin_general7  = false;
var itemIdEdit;
var countUpdateItem = false;
var counterArforTable = false;
var reqSupp = false;
var item_remarks;
var countAdminFiles = 0;
var tableEmp = [];
var tableEmpCountHead = 0;
var empIDshow;
var countExp = 0;
var hr_show_exp = false;
var hr_show_educ = false;
var hr_show_ref = false;
var hr_show_eq = false;
var hr_show_exp_aldy = false;
var hr_show_educ_aldy = false;
var hr_show_ref_aldy = false;
var hr_show_eq_aldy = false;
var activeExp = 'tab_Show1';
var table_exp = [];
var expC = 0;
var tableExplist;
var table_educ = [];
var educC  = 0;
var tableEduclist;
var table_char = [];
var charC = 0;
var tableReflist;
var table_items = [];
var assignedC = 0;
var tableAssigned;
var tableAtm = [];
var atmC = 0;
var tableAtmList;
var activeEmpNeed = 'tab_main1';
var emp_list_bool = true;
var emp_need_bool = false;
var activeGmail = 'tab_stat1';
var emp_need_tab_bool = true;
var emp_oims_gmail_bool = false;
var tableOims = [];
var oims_table = 0;
var tableOimsList;
var editAtmId;
var oimsGetId;
var tableEmpApproved = [];
var tableEmpAppCountHead = 0;
var tableArchivedGeneralForms;
var table_general_archived = false;
var tableGeneralForms_bool = true;
var counterAdd = 0;
var tableAssetsNationwide;
var admin_staff_assets_tab_bool = false;
var assetSearch;
var invent = [];
var inventCount = 0;
var selected_branch = '';
var selected_item = '';
var tableQuantity;
var quantTitle = [];
var quantTitlectr = 0;
var tableAvailConditio;
var availCondititle = [];
var availCondititlectr = 0;
var assetCurretnStatus = '';
var assetAvailability = '';
var brandInc = 0;
var brand2Inc = 0;
var tableMonitRequi;
var requi_table = [];
var r_1 = 0;
var activeMain = 'tabRequi_1';
var requi_monit_bool_1 = true;
var requi_monit_bool_2 = false;
var requi_monit_bool_3 = false;
var requi_table_2 = [];
var r_2 = 0;
var tableMonitRequi2;
var requi_table_3 = [];
var r_3 = 0;
var tableMonitRequi3;
var accr_files_count = 0;
var titleAccSup = [];
var sup_count = 0;
var tableAccSup;
var tab2Moniq = false;
var tab3Moniq = false;
var eq_process_table = [];
var eq_pr = 0;
var tableProcssEq;
var tabProcEqLeft = false;
var termsSupCount = 0;
var brandInc1 = 0;
var poBool = false;
var eq_process_table_2 = [];
var eq_pr_2 = 0;
var tableProcssEq_2;
var eq_po_to_fin_1 = true;
var eq_po_to_fin_2 = false;
var eq_po_to_fin_3 = false;
var  activeProcMon = '#tabProc_1';
var gen_requi_arr = [];
var gen_requi_count = 0;
var tableGenRequi;
var tableProcssEqDone;
var eq_process_done_table = [];
var eq_pr_done = 0;
var procGenRequiBool = false;
var titleAccSupForComp;
var titleforComp = [];
var for_comp = 0;
var arraySupSelected = [];
var arraySupInforSelected = [];
var titleMonitApprovalManage;
var title_monit_ap = [];
var title_app_monit_count = 0;
var sup_app_tabs_1_bool = true;
var sup_app_tabs_2_bool = false;
var sup_appden_tabs_1_bool = true;
var sup_appden_tabs_2_bool = false;
var sup_monitManage_tabs_1_bool = true;
var sup_monitManage_tabs_2_bool = false;
var titleAccSup2 = [];
var sup_count_2 = 0;
var tableAccSup2;
var checkSupOpen1 = false;
var checkmonitApp = false;
var tableIncidentRepPending;
var inc_rep_pen = [];
var inc_rep_pen_count = 0;
var tableIncidentRepDone;
var inc_rep_done = [];
var inc_rep_done_count = 0;
var incidentBool = false;

$(document).ready(function()
{
    assetSearch = '';
    inventoryNationWide();

    $.ajax
    ({
        type: 'get',
        url : 'admin-staff-auth-view',
        success : function(data)
        {
            if(data[0].authrequest == 'View')
            {
                btntoHide = true;
                $('#removeViewProfile').remove();
                $('#removeViewRequest').remove();
                $('#removeViewFund').remove();
                $('#removeViewOutgoing').remove();
                $('#removeViewSupp').remove();
                $('#removeViewQr').remove();
            }
        }
    });

    generalItem();
    $('#showItemAssign').hide();
    $('#down').hide();
    $('#editPo').hide();
    $('#UpdateItem').hide();
    $('#cancelUpdate').hide();
    $('#btnUpdateFund').hide();
    $('#btnCancelFund').hide();
    $('#btnAddSupplier').hide();

    $('.admin_staff_a_class').click(function ()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#admin-staff-monitoring_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-monitoring_tab';
            }
            else if (admin_staff_general_tab_bool)
            {
                if($('#checkActive1').attr('class') == 'active')
                {
                    if(countItem == true || countUpdateItem == true || counterAssign == true || counterRemove == true)
                    {
                        tableGeneralItem.ajax.reload(null, false);
                        countItem = false;
                        countUpdateItem = false;
                        counterAssign = false;
                        counterRemove = false;
                    }
                }
                else if($('#checkActive2').attr('class') == 'active')
                {
                    if(counterArforTable == true)
                    {
                        tableGeneralAr.ajax.reload(null, false)
                        counterArforTable = false;
                    }
                }
                else if($('#checkActive3').attr('class') == 'active')
                {
                    if(countSubmit == true || countHold == true || countCancel == true)
                    {
                        tableGeneralRequest.ajax.reload(null, false);
                    }
                }
                else if($('#checkActive4').attr('class') == 'active')
                {
                    if(counterFund == true)
                    {
                        tableGeneralFund.ajax.reload(null, false);
                        counterFund = false;
                    }
                }
                else if($('#checkActive5').attr('class') == 'active')
                {
                    if(counterOutgoing == true)
                    {
                        tableGeneralOut.ajax.reload(null, false);
                        counterOutgoing = false;
                    }
                }
                if($('#checkActive7').attr('class') == 'active')
                {
                    if(countItem == true || countUpdateItem == true)
                    {
                        tableGeneralPo.ajax.reload(null, false);
                        countItem = false;
                        countUpdateItem = false;
                    }
                }
                else
                {
                    console.log('already loaded');
                }
                which_is_active = 'admin-staff-monitoring_tab';
            }
            else if (admin_staff_general_tab_bool == false)
            {
                admin_staff_general_tab_bool = true;
                which_is_active = 'admin-staff-monitoring_tab';
            }
        }
        else if (gethref == '#admin-staff-profile_tab')
        {

            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-profile_tab';
            }
            else if (admin_staff_profile_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-profile_tab';
            }
            else if (admin_staff_profile_tab_bool == false)
            {
                admin_staff_profile_tab_bool = true;
                which_is_active = 'admin-staff-profile_tab';
                // editItemTable();
                admin_staff_view_ar_table();
            }
        }
        else if (gethref == '#admin-staff-request_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-request_tab';
            }
            else if (admin_staff_request_tab_bool)
            {
                if(reqSupp == true)
                {
                    tableAdminStaff.ajax.reload(null, false);
                    reqSupp = false;
                }
                console.log('already loaded');
                which_is_active = 'admin-staff-request_tab';
            }
            else if (admin_staff_request_tab_bool == false)
            {
                admin_staff_request_tab_bool = true;
                which_is_active = 'admin-staff-request_tab';
                admin_staff_table_reports();
            }
        }
        else if (gethref == '#admin-staff-fund_tab')
        {

            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-fund_tab';
            }
            else if (admin_staff_fund_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-fund_tab';
            }
            else if (admin_staff_fund_tab_bool == false)
            {
                admin_staff_fund_tab_bool = true;
                which_is_active = 'admin-staff-fund_tab';
                showFundRequest();
                getBranches();
                totalReq();
            }
        }
        else if (gethref == '#admin-staff-inventory_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-inventory_tab';
            }
            else if (admin_staff_inventory_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-inventory_tab';
            }
            else if (admin_staff_inventory_tab_bool == false)
            {
                admin_staff_inventory_tab_bool = true;
                which_is_active = 'admin-staff-inventory_tab';
            }
        }
        else if (gethref == '#admin-staff-emp-status-tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-emp-status-tab';
            }
            else if (admin_staff_emp_list_bool)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-emp-status-tab';
            }
            else if (admin_staff_emp_list_bool == false)
            {
                admin_staff_emp_list_bool = true;
                which_is_active = 'admin-staff-emp-status-tab';
                employee_list_table_view();
            }
        }
        else if (gethref == '#admin-staff-monitoring_tab_new')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-monitoring_tab_new';
            }
            else if (admin_staff_assets_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-monitoring_tab_new';
            }
            else if (admin_staff_profile_tab_bool == false)
            {
                admin_staff_assets_tab_bool = true;
                which_is_active = 'admin-staff-monitoring_tab_new';
                inventoryNationWide();
            }
        }
        else if (gethref == '#admin-staff-requisition-approval-tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-requisition-approval-tab';
            }
            else if (admin_staff_requi_monit)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-requisition-approval-tab';
            }
            else if (admin_staff_requi_monit == false)
            {
                admin_staff_requi_monit = true;
                which_is_active = 'admin-staff-requisition-approval-tab';
                eqMonitReqTable();
            }
        }
        else if (gethref == '#admin-staff-accredit-supplier')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-accredit-supplier';
            }
            else if (admin_staff_accred_sup)
            {
                console.log('already loaded');
                which_is_active = 'admin-staff-accredit-supplier';
            }
            else if (admin_staff_accred_sup == false)
            {
                admin_staff_accred_sup = true;
                which_is_active = 'admin-staff-accredit-supplier';
                accSuppTable();
                checkCategory();
                contentCateg();
            }
        }
        else if (gethref == '#admin-staff-equipment-processing-tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-equipment-processing-tab';
            }
            else if (admin_staff_eq_process_bool)
            {
                if(tabProcEqLeft == true)
                {
                    tableProcssEq.ajax.reload(null, false);
                    tabProcEqLeft = false;
                }
                else
                {
                    console.log('already loaded');
                }
                which_is_active = 'admin-staff-equipment-processing-tab';
            }
            else if (admin_staff_eq_process_bool == false)
            {
                admin_staff_eq_process_bool = true;
                which_is_active = 'admin-staff-equipment-processing-tab';
                eqProcessTable();
                suppListToPO();
                getUserName('po');
            }
        }
        else if (gethref == '#admin-staff-equipment-gen')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-equipment-gen';
            }
            else if (admin_staff_eq_gen_requi)
            {
                if(procGenRequiBool == true)
                {
                    tableGenRequi.ajax.reload(null, false);
                    procGenRequiBool = false;
                }
                else
                {
                    console.log('already loaded');
                }
                which_is_active = 'admin-staff-equipment-gen';
            }
            else if (admin_staff_eq_gen_requi == false)
            {
                admin_staff_eq_gen_requi = true;
                which_is_active = 'admin-staff-equipment-gen';
                genRequiTable();
            }
        }
        else if (gethref == '#admin-staff-incident-report-tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'admin-staff-incident-report-tab';
            }
            else if (admin_staff_incident_tab)
            {
                if(incidentBool == true)
                {
                    tableIncidentRepPending.ajax.reload(null, false);
                    incidentBool = false;
                }
                else
                {
                    console.log('already loaded');
                }
                which_is_active = 'admin-staff-incident-report-tab';
            }
            else if (admin_staff_incident_tab == false)
            {
                admin_staff_incident_tab = true;
                which_is_active = 'admin-staff-incident-report-tab';
                incidentPendingReview();
            }
        }


    });



    $('#btn_deleteall').click(function () {
        $.ajax({
            type: 'get',
            url: '/admin-delete-all-endorse-test',
            data: {

                'id' : '1'
            },
            success: function(data)
            {
                console.log(data);
                alert('ALL ENDORSEMENTS ARE DELETED');
                location.reload();
            },
            error: function()
            {
                console.log("error");
            }
        });

    });

    $('#btnBackUpFile').on('click', function () {
        $.ajax
        ({
            method: 'get',
            url: 'back-up-file',
            success: function (data)
            {
                var link = btoa('account_backup');

                window.location = 'download_storage/'+link+'/'+data;
                table.ajax.reload(null, false);
                tableAoFinishReport.ajax.reload(null, false);
            }
        });
    });

    $('.admin_staff_request_a_class').click(function () {
        console.log();
        var gethref = $(this).attr('href');
        console.log(gethref);

        if(gethref == '#tab_a')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeRequest = 'tab_a';
            }
            else if (admin_staff_ongoing_request)
            {
                console.log('already loaded');
                activeRequest = 'tab_a';
            }
            else if (admin_staff_ongoing_request == false)
            {
                admin_staff_ongoing_request = true;
                activeRequest = 'tab_a';
            }
        }
        else if (gethref == '#tab_b')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeRequest = 'tab_b';
            }
            else if (admin_staff_submitted_request)
            {
                if(countSubmit ==  true)
                {
                    tableAdminStaffSubmitted.ajax.reload(null, false);
                    countSubmit = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeRequest = 'tab_b';
            }
            else if (admin_staff_submitted_request == false)
            {
                admin_staff_submitted_request = true;
                activeRequest = 'tab_b';
                admin_staff_table_submitted()
            }
        }
        else if (gethref == '#tab_c')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeRequest = 'tab_c';
            }
            else if (admin_staff_hold_request)
            {
                if(countHold ==  true)
                {
                    tableAdminStaffHold.ajax.reload(null, false);
                    countHold = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeRequest = 'tab_c';
            }
            else if (admin_staff_hold_request == false)
            {
                admin_staff_hold_request = true;
                activeRequest = 'tab_c';
                admin_staff_table_hold();
            }
        }
        else if (gethref == '#tab_d')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeRequest = 'tab_d'
            }
            else if (admin_staff_cancelled_request)
            {
                if(countCancel ==  true)
                {
                    tableAdminStaffCancel.ajax.reload(null, false);
                    countCancel = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeRequest = 'tab_d'
            }
            else if (admin_staff_cancelled_request == false)
            {
                admin_staff_cancelled_request = true;
                activeRequest = 'tab_d';
                admin_staff_table_cancel();
            }
        }
    });

    function admin_staff_table_reports() {
        $('#admin-staff-table-reports thead th').each(function () {
            table1[v] = $(this).text();
            v++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableAdminStaff = $('#admin-staff-table-reports').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Equipment Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table1[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Equipment Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table1[(idx)];
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
                        extend: 'print',
                        title : 'Equipment Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table1[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table1[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-table-reports",
            "columns":
                [
                    {data: 'req_id', name: 'request_listitem.id'},
                    {data: 'date', name: 'item_requests.itmreq_datetime'},
                    {data: 'department', name: 'item_requests.itmreq_dept'},
                    {data: 'branch', name: 'item_requests.itmreq_branch'},
                    {data: 'requestor', name: 'item_requests.itmreq_requestor'},
                    {data: 'receiver', name: 'item_requests.itmreq_receiver'},
                    {data: 'name', name: 'request_listitem.item_name'},
                    {data: 'description', name: 'request_listitem.item_desc'},
                    {data: 'purpose', name: 'request_listitem.item_purp'},
                    {data: 'quantity', name: 'request_listitem.item_qty'},
                    {data: 'supplier_list', name: 'supplier_list',  "searchable" : false},
                    {
                        data: function actions(data)
                        {
                            if(btntoHide == false)
                            {
                                return '<span id="submit-' + data.req_id + '"><button class="btn btn-xs btn-info" id="btnSubmitRequest" name="" value="' + data.req_id + '" style="width: 100%" > <i class="fa fa-fw fa-check"></i> Submit</button></span>' +
                                    '<span id="hold-' + data.req_id + '"><button class="btn btn-block btn-warning btn-xs" id="btnHoldRequest" name="" value="' + data.req_id + '" style="width: 100%"> <i class="fa fa-fw fa-hand-stop-o"></i> Hold</button></span>' +
                                    '<span id="cancel-' + data.req_id + '"><button class="btn btn-block btn-danger btn-xs" id="btnCancelRequest" name="" value="' + data.req_id + '" style="width: 100%"><i class="fa fa-fw fa-remove"></i> Cancel</button></span>';
                            }
                            else
                            {
                                return 'Not Available';
                            }


                        },
                        "name": 'supplier_list',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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

        $('#admin-staff-table-reports_filter input').unbind();
        $('#admin-staff-table-reports_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableAdminStaff.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableAdminStaff.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function admin_staff_table_submitted() {

        $('#admin-staff-table-submitted thead th').each(function () {
            table2[w] = $(this).text();
            w++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableAdminStaffSubmitted = $('#admin-staff-table-submitted').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Submitted Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table2[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Submitted Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table2[(idx)];
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
                        extend: 'print',
                        title : 'Submitted Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table2[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table2[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-table-submitted-status",
            "columns":
                [
                    {data: 'req_id', name: 'request_listitem.id'},
                    {data: 'date', name: 'item_requests.itmreq_datetime'},
                    {data: 'department', name: 'item_requests.itmreq_dept'},
                    {data: 'branch', name: 'item_requests.itmreq_branch'},
                    {data: 'requestor', name: 'item_requests.itmreq_requestor'},
                    {data: 'receiver', name: 'item_requests.itmreq_receiver'},
                    {data: 'name', name: 'request_listitem.item_name'},
                    {data: 'description', name: 'request_listitem.item_desc'},
                    {data: 'purpose', name: 'request_listitem.item_purp'},
                    {data: 'quantity', name: 'request_listitem.item_qty'},
                    {data: 'supplier', name: 'supplier_list.supp_name'},
                    {
                        data: function status(data) {

                            return '<span id="submitted-' + data.req_id + '"><button class="btn btn-xs btn-info disabled" id="btnSubmittedRequest" name="" value="' + data.req_id + '" style="width: 100%" ><i class = "fa fa-fw fa-check-square"></i>Submitted</button></span>';
                        },
                        "name": 'supplier_list.supp_name',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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
        $('#admin-staff-table-submitted_filter input').unbind();
        $('#admin-staff-table-submitted_filter input').bind('keyup change', function (e) {
            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    tableAdminStaffSubmitted.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        tableAdminStaffSubmitted.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function admin_staff_table_hold() {
        $('#admin-staff-table-hold thead th').each(function () {
            table3[x] = $(this).text();
            x++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        tableAdminStaffHold = $('#admin-staff-table-hold').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'On-hold Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table3[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'On-hold Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table3[(idx)];
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
                        extend: 'print',
                        title : 'On-hold Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table3[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table3[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-table-hold-status",
            "columns":
                [
                    {data: 'req_id', name: 'request_listitem.id'},
                    {data: 'date', name: 'item_requests.itmreq_datetime'},
                    {data: 'department', name: 'item_requests.itmreq_dept'},
                    {data: 'branch', name: 'item_requests.itmreq_branch'},
                    {data: 'requestor', name: 'item_requests.itmreq_requestor'},
                    {data: 'receiver', name: 'item_requests.itmreq_receiver'},
                    {data: 'name', name: 'request_listitem.item_name'},
                    {data: 'description', name: 'request_listitem.item_desc'},
                    {data: 'purpose', name: 'request_listitem.item_purp'},
                    {data: 'quantity', name: 'request_listitem.item_qty'},
                    {data: 'supplier', name: 'supplier_list.supp_name'},
                    {
                        data: function status(data) {

                            return '<span id="holdrequest-' + data.req_id + '"><button class="btn btn-block btn-warning btn-xs disabled" id="btnHoldRequest" name="" value="' + data.req_id + '" style="width: 100%" ><i class = "fa fa-fw fa-exclamation"></i>On-Hold</button></span>';
                        },
                        "name": 'supplier_list.supp_name',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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
        $('#admin-staff-table-hold_filter input').unbind();
        $('#admin-staff-table-hold_filter input').bind('keyup change', function (e) {

            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    tableAdminStaffHold.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        tableAdminStaffHold.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function admin_staff_table_cancel() {
        $('#admin-staff-table-cancel thead th').each(function () {
            table4[y] = $(this).text();
            y++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableAdminStaffCancel = $('#admin-staff-table-cancel').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Cancelled Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table4[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Cancelled Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table4[(idx)];
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
                        extend: 'print',
                        title : 'Cancelled Requests',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table4[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table4[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-table-cancel-status",
            "columns":
                [
                    {data: 'req_id', name: 'request_listitem.id'},
                    {data: 'date', name: 'item_requests.itmreq_datetime'},
                    {data: 'department', name: 'item_requests.itmreq_dept'},
                    {data: 'branch', name: 'item_requests.itmreq_branch'},
                    {data: 'requestor', name: 'item_requests.itmreq_requestor'},
                    {data: 'receiver', name: 'item_requests.itmreq_receiver'},
                    {data: 'name', name: 'request_listitem.item_name'},
                    {data: 'description', name: 'request_listitem.item_desc'},
                    {data: 'purpose', name: 'request_listitem.item_purp'},
                    {data: 'quantity', name: 'request_listitem.item_qty'},
                    {data: 'supplier', name: 'supplier_list.supp_name'},
                    {
                        data: function status(data)
                        {

                            return '<span id="cancelrequest-'+data.req_id+'"><button class="btn btn-block btn-danger btn-xs disabled" id="CancelRequest" name="" value="'+data.req_id+'" style="width: 100%" ><i class = "fa fa-fw fa-ban"></i>Cancelled</button></span>';
                        },
                        "name": 'supplier_list.supp_name',
                        "searchable" : false,
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-table-cancel_filter input').unbind();
        $('#admin-staff-table-cancel_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableAdminStaffCancel.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableAdminStaffCancel.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function admin_staff_supplier() {
        $('#admin-staff-supplier thead th').each(function () {
            table5[u] = $(this).text();
            u++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableAdminSupplier = $('#admin-staff-supplier').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table5[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table1[(idx)];
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
                        extend: 'print',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table5[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": false,
            "ajax": "/admin-staff-supplier-table",
            "columns":
                [
                    {data: 'id', name: 'supplier_list.id'},
                    {data: 'name', name: 'supplier_list.supp_name'},
                    {data: 'since' , name: 'supplier_list.supplier_since'},
                    {data: 'contact_phone', name: 'supplier_list.supp_contact_phone'},
                    {data: 'contact_mobile', name: 'supplier_list.supp_contact_mobile'},
                    {data: 'email', name: 'supplier_list.supp_email'},
                    {data: 'address', name: 'supplier_list.supp_address'},
                    {data: 'contact_person', name: 'supplier_list.supp_contact_person'},
                    {data: 'category', name: 'category_list.category_name'},
                    {
                        data: function action(data) {

                            return '<span id="supp-' + data.id + '"><button class="btn btn-xs btn-info" id= "dlSupp" value="' + data.id + '" style="width: 100%" ><i style = "color: black" class = "fa fa-fw fa-download"></i>Download B.I Result</button></span>' +
                                '<span id = "downSupp"></span>';
                        },
                        "name": 'category_list.category_name',
                        "searchable" : false
                    },
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-supplier_filter input').unbind();
        $('#admin-staff-supplier_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableAdminSupplier.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableAdminSupplier.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function admin_staff_view_ar_table() {

        $('#admin-staff-ar-table thead th').each(function () {
            table_ar[abc] = $(this).text();
            abc++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        tableArView= $('#admin-staff-ar-table').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Acknowledgement Receipt Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table_ar[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Acknowledgement Receipt Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table_ar[(idx)];
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
                        extend: 'print',
                        title : 'Acknowledgement Receipt Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table_ar[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table_ar[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-ar-table",
            "columns":
                [
                    {data: 'id', name: 'ar_to_employee.id'},
                    {data: 'first_name', name: 'users_profile.emp_first_name'},
                    {data: 'middle_name', name: 'users_profile.emp_middle_name'},
                    {data: 'last_name', name: 'users_profile.emp_last_name'},
                    {data: 'description', name: 'ar_info.ar_description'},
                    {data: 'remarks', name: 'ar_info.ar_remarks'},
                    {data: 'time_created', name: 'ar_to_employee.created_at'},
                    {
                        data: function action(data) {


                            return '<a href="/view_ar/'+btoa(data.path)+'" target="_blank"><button class="btn_view_ar btn btn-xs btn-info"  id="" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-eye"></i> View PDF</button></a>' +
                                '<button class="btn_view_assigned btn btn-xs btn-info"  id="" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-list"></i> View Assigned</button>' +
                                '<button class="btn_delete_ar btn btn-xs btn-danger" id="" name="'+btoa(data.path)+'" value="' + data.id + '" style="width: 100%"><i class = "fa fa-trash"></i> Remove</button>';
                        },
                        "name": 'ar_to_employee.created_at',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-ar-table_filter input').unbind();
        $('#admin-staff-ar-table_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableArView.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableArView.search($(this).val()).draw();
                    }
                }
            }
        });

    }

    $('#admin-staff-table-reports').on('click','#btnSubmitRequest',function () {
        acctID = $(this).val();
        var suppID = get_supp_id(acctID);
        // submit_click +=1;
        if(confirm('Are you sure to submit?'))
        {
            $.ajax
            ({
                type: 'get',
                url: 'admin-staff-submit-request',
                data:
                    {
                        'acctID' : acctID,
                        'suppID' : suppID
                    },
                success : function(data)
                {
                    if(data=='success')
                    {
                        var timerSuccess = setInterval(function ()
                        {
                            $('#modal-submitsuccess').modal('show');
                            tableAdminStaff.ajax.reload(null, false);

                            var timerSuccessHide = setInterval(function ()
                            {
                                $('#modal-submitsuccess').modal('hide');
                                clearInterval(timerSuccessHide);
                            },3000);
                            clearInterval(timerSuccess);
                        },1000);
                    }
                    countSubmit = true;
                }
            });
        }
        else
        {

        }
    });
    $('#admin-staff-table-reports').on('click','#btnHoldRequest',function ()
    {
        acctID= $(this).val();
        var suppID  = get_supp_id(acctID);
        // hold_click += 1;
        if(confirm('Are you sure to Hold?')){
            $.ajax
            ({
                type: 'get',
                url: 'admin-staff-hold-request',
                data:
                    {
                        'acctID': acctID,
                        'suppID': suppID
                    },
                success: function (data) {
                    if (data == 'success')
                    {
                        var timerSuccess = setInterval(function ()
                        {
                            $('#modal-hold').modal('show');
                            tableAdminStaff.ajax.reload(null, false);

                            var timerSuccessHide = setInterval(function ()
                            {
                                $('#modal-hold').modal('hide');
                                clearInterval(timerSuccessHide);
                            },3000);
                            clearInterval(timerSuccess);
                        },1000);
                        countHold = true;
                    }
                }
            });
        } else {

        }
    });
    $('#admin-staff-table-reports').on('click','#btnCancelRequest',function () {
        acctID= $(this).val();
        var suppID  = get_supp_id(acctID);
        // cancel_click += 1;
        if(confirm('Are you sure to Cancel?')) {
            $.ajax
            ({
                type: 'get',
                url: 'admin-staff-cancel-request',
                data:
                    {
                        'acctID': acctID,
                        'suppID': suppID
                    },
                success: function (data)
                {
                    if (data == 'success')
                    {
                        var timerSuccess = setInterval(function ()
                        {
                            $('#modal-cancel').modal('show');
                            tableAdminStaff.ajax.reload(null, false);

                            var timerSuccessHide = setInterval(function ()
                            {
                                $('#modal-cancel').modal('hide');
                                clearInterval(timerSuccessHide);
                            },3000);
                            clearInterval(timerSuccess);
                        },1000);
                        countCancel = true;
                    }
                }
            });
        }
        else
        {

        }
    });

    function get_supp_id(id) {
        return $('#supplier_class-'+id+'').children("option:selected").val();
    }

    $('#existingCategory').click(function()
    {
        $('#showSelectCateg').show();
        $('#showInputCateg').hide();
        // optionExisting = true;
        // optionNew = false;
        // $.ajax
        // ({
        //     type: 'get',
        //     url: 'admin-staff-get-category',
        //     success: function(data) {
        //         console.log(data);
        //         var i ;
        //         var existingCategory = '';
        //
        //         for (i = 0; i < data.length; i++) {
        //             existingCategory += '<option value="' + data[i].category_name + '">' + data[i].category_name + '</option>';
        //         }
        //         var existing = '<label>Select Category:</label><br><select id = "selectedCategory" class = "form-control">'+existingCategory+'</select>';
        //         $('#formCategory').html(existing);
        //         $('#btnAddSupplier').show();
        //     }
        // });
    });

    $('#newCategory').click(function()
    {
        $('#showSelectCateg').hide();
        $('#showInputCateg').show();

        // optionNew = true;
        // optionExisting = false;
        //
        // $('#formCategory').html('<label>Add a category:</label><small style = "color : red">(Required field)</small><input type="text" class="form-control" id = "newInputCategory"> <span id="categoryValidation"></span>');
        // checkCategory();
        // $('#btnAddSupplier').show();
    });


    $('#btnAddSupplier').click(function ()
    {
        var suppName = $('#suppName').val();
        var suppDate = $('#suppDate').val();
        var suppPhone = $('#suppPhone').val();
        var suppMobile = $('#suppMobile').val();
        var suppEmail = $('#suppEmail').val();
        var suppAddress = $('#suppAddress').val();
        var suppPerson = $('#suppPerson').val();
        var suppFile = $('#supp_bi').prop('files')[0];

        if(suppFile != null)
        {
            if (optionExisting == true) {

                var selectedCategory = $('#selectedCategory').val();

                var formData1 = new FormData();
                formData1.append('selectedCategory' , selectedCategory);
                formData1.append('suppName' , suppName);
                formData1.append('suppDate' , suppDate);
                formData1.append('suppPhone' , suppPhone);
                formData1.append('suppMobile' , suppMobile);
                formData1.append('suppEmail' , suppEmail);
                formData1.append('suppAddress' , suppAddress);
                formData1.append('suppPerson' , suppPerson);
                formData1.append('suppFile' , suppFile);

                $.ajax
                ({
                    type: 'post',
                    url: 'admin-staff-add-supplier-existing-category',
                    contentType: false,
                    processData: false,
                    async: true,
                    data: formData1,
                    success: function (data) {
                        console.log(data.error);

                        if (data.error == 'required') {

                            $("#btnAddSupplier").attr("disabled", false);

                            alert('Please fill up all required fields!');

                            $('#suppName').val();
                            $('#suppDate').val();
                            $('#suppPhone').val();
                            $('#suppMobile').val();
                            $('#suppEmail').val();
                            $('#suppAddress').val();
                            $('#suppPerson').val();
                        }
                        else if (data.exist == 'exist')
                        {
                            $("#btnAddSupplier").attr("disabled", false);

                            $('#suppName').val();
                            $('#suppDate').val();
                            $('#suppPhone').val();
                            $('#suppMobile').val();
                            $('#suppEmail').val();
                            $('#suppAddress').val();
                            $('#suppPerson').val();

                            alert('Existing Supplier!');
                        }
                        else
                        {
                            $("#btnAddSupplier").attr("disabled", false);
                            if($('#removeViewRequest').attr('class') == 'active')
                            {
                                tableAdminStaff.ajax.reload(null, false);
                            }
                            if($('#checkActive6').attr('class') == 'active')
                            {
                                tableGenSupplier.ajax.reload(null, false);
                            }
                            $('#suppName').val('');
                            $('#suppDate').val('');
                            $('#suppPhone').val('');
                            $('#suppMobile').val('');
                            $('#suppEmail').val('');
                            $('#suppAddress').val('');
                            $('#suppPerson').val('');
                            $('#supp_bi').val('')
                            alert('Successfully Added Profile!');
                            submitTab = true;
                            reqSupp = true;
                        }
                    }
                });
            }
            else if (optionNew == true)
            {
                var newInput = $('#newInputCategory').val();

                var formData2 = new FormData();
                formData2.append('newInput' , newInput);
                formData2.append('suppName' , suppName);
                formData2.append('suppDate' , suppDate);
                formData2.append('suppPhone' , suppPhone);
                formData2.append('suppMobile' , suppMobile);
                formData2.append('suppEmail' , suppEmail);
                formData2.append('suppAddress' , suppAddress);
                formData2.append('suppPerson' , suppPerson);
                formData2.append('suppFile' , suppFile);

                $.ajax
                ({
                    type: 'post',
                    url: 'admin-staff-add-supplier-new-category',
                    contentType: false,
                    processData: false,
                    async: true,
                    data: formData2,
                    success: function (data)
                    {
                        console.log(data.error);
                        if (data.error == 'required')
                        {
                            $("#btnAddSupplier").attr("disabled", false);
                            alert('Please fill up all required fields!');

                            $('#suppName').val();
                            $('#suppDate').val();
                            $('#suppPhone').val();
                            $('#suppMobile').val();
                            $('#suppEmail').val();
                            $('#suppAddress').val();
                            $('#suppPerson').val();
                        }
                        else if (data.exist == 'exist')
                        {
                            $("#btnAddSupplier").attr("disabled", false);

                            $('#suppName').val();
                            $('#suppDate').val();
                            $('#suppPhone').val();
                            $('#suppMobile').val();
                            $('#suppEmail').val();
                            $('#suppAddress').val();
                            $('#suppPerson').val();

                            alert('Existing Supplier!');
                        }
                        else if (data.existCategory == 'existCategory')
                        {
                            $("#btnAddSupplier").attr("disabled", false);

                            $('#suppName').val();
                            $('#suppDate').val();
                            $('#suppPhone').val();
                            $('#suppMobile').val();
                            $('#suppEmail').val();
                            $('#suppAddress').val();
                            $('#suppPerson').val();

                            alert('Existing Category!')
                        }
                        else
                        {
                            $("#btnAddSupplier").attr("disabled", false);

                            if($('#removeViewRequest').attr('class', 'active'))
                            {
                                tableAdminStaff.ajax.reload(null, false);
                            }
                            $('#newInputCategory').val('');
                            $('#suppDate').val('');
                            $('#suppName').val('');
                            $('#suppPhone').val('');
                            $('#suppMobile').val('');
                            $('#suppEmail').val('');
                            $('#suppAddress').val('');
                            $('#suppPerson').val('');
                            alert('Successfully Added Supplier!');
                            $('#supp_bi').val('');
                            submitTab = true;
                            $('#categoryValidation').html('');
                            reqSupp = true;
                        }
                    }
                });
            }
        }
        else
        {
            $("#btnAddSupplier").attr("disabled", false);
            alert('Please choose B.I Result File.');
        }

    });

    function checkCategory() {
        $('#newInputCategory').keyup(function(e){

            clearTimeout($.data(this, 'timer'));
            if (e.keyCode === 13)
            {
                search(true);
            }
            else
            {
                $('#categoryValidation').html('');
                $('#btnAddSupplier').attr('disabled', 'disabled');
                $(this).data('timer', setTimeout(search, 500));
            }
        });
    }
    function search(force) {
        var existingString = $("#newInputCategory").val();

        if (!force && existingString.length < 3)
        {

        }
        else
        {
            $.ajax({
                type: 'get',
                url: 'admin-staff-check-existing',
                data:
                    {
                        'checkcategory': existingString
                    },
                dataType: 'json',
                success: function (data)
                {
                    console.log(data);
                    if (data === 1)
                    {
                        $('#categoryValidation').html('<p style="color: red"> Category exists. Please select from existing categories.</p>');
                        $('#btnAddSupplier').attr('disabled', 'disabled');
                    }
                    else
                    {
                        $('#categoryValidation').html('<p style="color: green"> Category is ready to be stored.</p>');
                        $('#btnAddSupplier').removeAttr('disabled');
                    }

                }
            });
        }
    }

    $('.admin_supplier_class').click(function () {
        console.log(submitTab);
        var gethref = $(this).attr('href');
        console.log(gethref);

        if(gethref == '#tab_Add')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeSupply = 'tab_Add';
            }
            else if (admin_staff_add_supply)
            {
                console.log('already loaded');
                activeSupply = 'tab_Add';
            }
            else if (admin_staff_add_supply == false)
            {
                admin_staff_add_supply = true;
                activeSupply = 'tab_Add';
            }
        }
        else if (gethref == '#tab_Info')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeSupply = 'tab_Info';
            }
            else if (admin_staff_info_supply)
            {
                if(submitTab ==  true)
                {
                    tableAdminSupplier.ajax.reload(null, false);
                    submitTab = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeSupply = 'tab_Info';
            }
            else if (admin_staff_info_supply == false)
            {
                admin_staff_info_supply = true;
                activeSupply = 'tab_Info';
                admin_staff_supplier();
            }
        }
    });

    $("#item_profile_pic").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function(e)
            {
                $('#item_profile_pic_display').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#cancelImg').click(function() {
        $('#item_profile_pic').val('');
        $('#item_profile_pic_display').attr('src', 'item_pic/items.jpg');
    });

    $('#submitItem').click(function() {
        $(this).attr("disabled" , true);

        var itemType = $('#item_type').val();
        var itemModel = $('#item_model').val();
        var itemDate = $('#item_date').val();
        var itemPO = $('#item_purchase_no').val();
        var itemAmount = $('#item_amount').val();
        var itemColor = $('#item_color').val();
        var itemRemarks = $('#item_remarks').val();
        var itemImage = $('#item_profile_pic')[0].files[0];
        var itemFile = $('#item_po_file').prop('files')[0];
        var itemSpec = $('#item_specs_status').val();
        var itemWarranty = $('#item_warranty').val();
        var itemQuotation =  $('#item_quotation').prop('files')[0];

        var formData = new FormData();
        formData.append('itemType', itemType);
        formData.append('itemModel', itemModel);
        formData.append('itemDate', itemDate);
        formData.append('itemPO', itemPO);
        formData.append('itemFile', itemFile);
        formData.append('itemAmount', itemAmount);
        formData.append('itemColor', itemColor);
        formData.append('itemRemarks', itemRemarks);
        formData.append('itemImage', itemImage);
        formData.append('itemSpec', itemSpec);
        formData.append('itemWarranty', itemWarranty);
        formData.append('itemQuotation', itemQuotation);


        $.ajax
        ({
            type: 'post',
            url: 'admin-staff-create-item-profile',
            contentType: false,
            processData: false,
            async: true,
            data: formData,
            beforeSend: function () {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitItem").attr("disabled", false);

                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);

                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitItem").attr("disabled", false);
                    countItem = true;
                    $('#item_type').val('');
                    $('#item_model').val('');
                    $('#item_date').val('');
                    $('#item_purchase_no').val('');
                    $('#item_amount').val('');
                    $('#item_color').val('');
                    $('#item_remarks').val('');
                    $('#item_profile_pic').val('');
                    $('#item_po_file').val('');
                    $('#item_warranty').val('');
                    $('#item_quotation').val('');

                    $('#item_profile_pic_display').attr('src', 'item_pic/items.jpg');
                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-successitem').modal('show');

                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-successitem').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    tableAdminAssignLogs.ajax.reload(null, false);
                    tableEditGeneralItem.ajax.reload(null, false);
                    $('#hideRequired').show();
                }
            }
        })
    });

    $('.admin_staff_eq_class').click(function () {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_eq2') {

            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEq = 'tab_eq2';
            }
            else if (admin_staff_show) {
                console.log('already loaded');
                activeEq = 'tab_eq2';
            }
            else if (admin_staff_show == false) {
                admin_staff_show = true;
                activeEq = 'tab_eq2';
                editItemTable();
            }
        }
        else if (gethref == '#tab_eq3') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEq = 'tab_eq3';
            }
            else if (admin_staff_assign_tab) {
                if(countItem ==true) {
                    tableItemAssign.ajax.reload(null, false);
                    countItem = false;
                }
                else
                {
                    console.log('already loaded');
                    activeEq = 'tab_eq3';
                }
            }
            else if (admin_staff_assign_tab == false) {
                admin_staff_assign_tab = true;
                activeEq = 'tab_eq3';
                admin_staff_assign();
                employeeFetch();
            }
        }
        else if (gethref == '#tab_eq4') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEq = 'tab_eq4';
            }
            else if (admin_staff_ar) {
                if(countItem ==true) {
                    // tableItemAssign.ajax.reload(null, false);
                    countItem = false;
                }
                else
                {
                    console.log('already loaded');
                    activeEq = 'tab_eq4';
                }
            }
            else if (admin_staff_ar == false) {
                admin_staff_ar = true;
                activeEq = 'tab_eq4';
                employeeFetch_ar();
            }
        }
    });

    function admin_staff_assign() {
        $('#admin_staff_assign_item thead th').each(function () {
            tableItem[x] = $(this).text();
            x++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableItemAssign = $('#admin_staff_assign_item').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-available-item",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'item_category', name: 'item_category'},
                    {data: 'item_brand_model', name: 'item_brand_model'},
                    {
                        data: function status(data) {

                            return '<span id="item-' + data.id + '"><button class="btn btn-xs btn-success btnAssignItem" id="" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-arrows-alt"></i>Assign Item</button></span>';
                        },
                        "name": 'item_brand_model',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10,25, 50,100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin_staff_assign_item_filter input').unbind();
        $('#admin_staff_assign_item_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableItemAssign.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableItemAssign.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    function employeeFetch_ar() {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                var employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '</option>';
                }
                $('#ar_employee_list').html(employeeList);
                $('#ar_employee_list').val('');

                $('#ar_employee_list').change(function()
                {
                    // viewExpID  = $(this).find(':selected').val();
                });
            }
        });
    }

    function employeeFetch() {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                console.log(data);
                var j;
                var employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '</option>';
                }
                $('#assignItemSelected').html(employeeList);
                $('#assignItemSelected').val('');

                $('#assignItemSelected').change(function()
                {
                    viewExpID  = $(this).find(':selected').val();
                    // showEmpSel(viewExpID);
                    console.log(viewExpID);
                    ar_selected_id = null;
                    showEmpSel();
                    ar_fetch(viewExpID);
                });

            }
        });
    }

    function ar_fetch(emp_id) {

        $.ajax
        ({
            type: 'get',
            url: 'admin_get_ar_description',
            data:{
                'emp_id' :   emp_id
            },
            success: function (data)
            {
                if(data.length == 0)
                {
                    $('#ar_hidden').hide();
                    $('#ar_dd').hide();
                }
                else
                {
                    $('#ar_hidden').show();
                    $('#ar_dd').hide();
                    var j;
                    var ar_list = '';


                    for (j = 0; j < data.length; j++)
                    {
                        ar_list += '<option name="'+j+'" value="' + data[j].id + '">' + data[j].ar_description + '</option>';
                        ar_remarks[j] = data[j].ar_remarks;
                        ar_date_time[j] = data[j].created_at;
                        ar_path[j] = data[j].file_path;
                    }
                    $('#ar_selected').html(ar_list);
                    $('#ar_selected').val('');
                }
            }
        });
    }


    $('#ar_selected').change(function()
    {
        $('#ar_dd').show();
        var index = $(this).find(':selected').attr('name');

        $('#dd_ar_remarks').html(ar_remarks[index]);
        $('#dd_ar_date_time').html(ar_date_time[index]);
        $('#dd_a_href').attr('href','/view_ar/'+btoa(ar_path[index]));
        // viewExpID  = $(this).find(':selected').val();
        ar_selected_id = $(this).find(':selected').val();
        console.log(ar_selected_id);
        showEmpSel($(this).find(':selected').val());

    });

    function showEmpSel(ar_id) {

        $('#admin-staff-employee-list').html('<thead>\n' +
            '                                            <tr>\n' +
            '                                                <th>ID</th>\n' +
            '                                                <th>Category</th>\n' +
            '                                                <th>Brand/Model Name</th>\n' +
            '                                                <th>Color</th>\n' +
            '                                                <th>Remarks</th>\n' +
            '                                                <th>Action</th>\n' +
            '                                            </tr>\n' +
            '                                            </thead>');
        $.ajax
        ({
            type: 'get',
            url: 'admin-staff-emp-item',
            data:
                {
                    'ar_id': ar_id
                },
            success: function (data) {
                var k;
                var ExpList = '';
                for (k = 0; k < data.length; k++) {
                    ExpList += '<tr id = "' + data[k].id + '">' +
                        '<td>' + data[k].id + '</td>' +
                        '<td>' + data[k].item_category + '</td>' +
                        '<td>' + data[k].item_brand_model + '</td>' +
                        '<td>' + data[k].item_color + ' </td>' +
                        '<td>' + data[k].item_remarks + '</td>' +
                        '<td><button type = "button" value = "' + data[k].id + '" class = "removeAssign btn btn-block btn-danger btn-sm form-control">Remove Assigned item</button></td>' +
                        '</tr>';
                }
                $('#admin-staff-employee-list').append(ExpList);

                $('.removeAssign').click(function()
                {
                    var thisBtn = $(this);
                    thisBtn.attr("disabled", "disabled");
                    remAss = $(this).val();


                    item_remarks = prompt("Your Remarks:",'N/A');

                    if (item_remarks == null || item_remarks == "")
                    {
                        thisBtn.removeAttr("disabled");
                    }
                    else
                    {
                        $.ajax
                        ({
                            type : 'get',
                            url: 'admin-staff-remove-assigned',
                            data:
                                {
                                    'remAss' : remAss
                                },
                            success: function(data)
                            {
                                console.log(data);
                                $('#spectUpdateName').html(data[1] + ' with ID of    ' + data[2]);
                                $('#show_specs_status').val(data[0]);
                                $('#modal-item-status-change').modal({backdrop: "static"});

                            }
                        })
                    }
                })
            }
        });
    }

    $('#admin_staff_assign_item').on('click', '.btnAssignItem', function() {
        var thisBtn = $(this);
        thisBtn.attr("disabled", "disabled");
        var empIdAssign = $(this).val();

        if(viewExpID == null || ar_selected_id == null)
        {
            thisBtn.removeAttr("disabled");
            alert('Please Select Employee/A.R !')
        }
        else
        {

            var remarks = prompt("Assigning Remarks:",'N/A');
            if (remarks == null || remarks == "")
            {
                thisBtn.removeAttr("disabled");
            }
            else
            {
                $.ajax
                ({
                    type: 'get',
                    url: 'admin_staff_assign_to_emp',
                    data:
                        {
                            'viewExpID' : $(this).val(),
                            'empIdAssign' : empIdAssign,
                            'ar_employee_id' : $('#ar_selected').val(),
                            'remarks' : remarks
                        },
                    success: function()
                    {
                        thisBtn.removeAttr("disabled");
                        alert('Successfully assigned!');
                        tableItemAssign.ajax.reload(null, false);
                        showEmpSel(ar_selected_id);
                        counterAssign = true;
                        tableAdminAssignLogs.ajax.reload(null, false);
                        counterOutgoing = true;

                    }
                })
            }


        }
    });


    // $("#webcam").webcam({
    //     width: 320,
    //     height: 240,
    //     mode: "callback",
    //     swffile: "/jscript/jQuery-webcam-master/jscam_canvas_only.swf",
    //     onTick: function() {},
    //     onSave: function() {},
    //     onCapture: function() {},
    //     debug: function() {},
    //     onLoad: function() {}
    // });

    $('#btn_upload_ar').click(function () {

        var emp = $('#ar_employee_list').val();
        var description = $('#ar_description').val();
        var file = $('#emp_ar_file');
        var remarks = $('#ar_remarks').val();


        if(emp == null || description == '' || file.get(0).files.length == 0)
        {
            console.log('employee is null');
            alert('Please complete the required field.');
        }
        else
        {
            console.log('employee is not null');

            var ar_data = new FormData();
            ar_data.append('emp_id',emp);
            ar_data.append('desc',description);
            ar_data.append('ar_file',file.prop('files')[0]);
            ar_data.append('remarks',remarks);

            $.ajax({

                url     :   'admin_staff_ar_upload',
                type    :   'post',
                data    :   ar_data,
                contentType: false,
                processData: false,
                async: true,
                success : function (data) {

                    if(data == 'not pdf' )
                    {
                        alert('Please upload only .pdf.')
                    }
                    else if(data == 'select file')
                    {
                        alert('Please select file.')
                    }
                    else if(data == 'success')
                    {
                        alert('Success.');
                        // $('#ar_employee_list').val('');
                        $('#ar_description').val('');
                        $('#ar_remarks').val('');
                        file.val('');
                        tableArView.ajax.reload(null,false);
                        tableAdminAssignLogs.ajax.reload(null, false);
                        ar_fetch_success();
                        counterOutgoing = true;
                        counterArforTable = true;
                    }
                },
                error : function () {
                    console.log('error');
                }


            });
        }
    });

    // $('#admin-staff-ar-table').on('click','.btn_view_ar', function () {
    //     var id = $(this).attr('value');
    //     console.log(id);
    //
    // });

    function item_logs_table() {
        // tableItemHistory.draw();

        $('#admin-staff-item-history thead th').each(function () {
            table8[h] = $(this).text();
            h++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableItemHistory = $('#admin-staff-item-history').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Item History',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table8[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Item History',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table8[(idx)];
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
                        extend: 'print',
                        title : 'Item History',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table8[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            // "ajax": "/admin-staff-item-history",
            "ajax":
                {
                    type: 'get',
                    url: "/admin-staff-item-history",
                    data: function (d) {
                        console.log(showItemId)
                        d.emp_id = showItemId;
                    }
                },
            "columns":
                [
                    {data: 'name', name: 'users.name as name'},
                    {data: 'activities', name: 'item_logs.activities'},
                    {data: 'activity_remarks', name: 'item_logs.activity_remarks'},
                    {data: 'date', name: 'item_logs.created_at'},
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-item-history_filter input').unbind();
        $('#admin-staff-item-history_filter input').bind('keyup change', function (e) {

            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    tableItemHistory.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        tableItemHistory.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    $('#admin-staff-logs thead th').each(function () {
        table9[yu] = $(this).text();
        yu++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableAdminAssignLogs = $('#admin-staff-logs').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Admin Staff General Logs',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table9[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Admin Staff General Logs',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table9[(idx)];
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
                    extend: 'print',
                    title : 'Admin Staff General Logs',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return table9[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-staff-ar-logs",
        "columns":
            [
                {data: 'username', name: 'users.name'},
                {data: 'name' , name: 'users_profile.emp_full_name'},
                {data: 'activities', name: 'assign_logs.activities'},
                {data: 'remarks', name: 'assign_logs.remarks'},
                {data: 'time', name: 'assign_logs.created_at'}
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();

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
    $('#admin-staff-logs_filter input').unbind();
    $('#admin-staff-logs_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAdminAssignLogs.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAdminAssignLogs.search($(this).val()).draw();
                }
            }
        }
    });

    $('#btnDownloadPo').click(function()
    {
        console.log(showItemId);
        var id_encode = btoa(showItemId);
        var q = '<form action="/admin-staff-file-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#down').html(q);
        $('#button_form_download').click();
    });
    $('#cancelPoDocument').click(function()
    {
        $('#item_po_file').val('')
    });

    $('#admin-staff-ar-table').on('click', '.btn_view_assigned', function()
    {
        counterAr += 1;
        ar_info_id = $(this).val();
        console.log(ar_info_id);

        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-view-ar-assigned',
            data :
                {
                    'ar_info_id' : ar_info_id
                },
            success : function(data)
            {
                console.log(data);
                if(counterAr == 1)
                {
                    arItems();
                }
                else if(counterAr >= 2)
                {
                    tableEmpItemAssign.ajax.reload(null, false);
                }
                console.log(data);
                $('#modal-ar_assigned').modal('show');
                $('#ar_title').html('<p>A.R ID: ' + data[0].ar_id + ' , Description: ' + data[0].desc + '  </p>')
                $('#show_emp_image').attr('src', data[0].emp_pic);
                $('#emp_name').html('<center><h3 style = "font-family: Georgia,serif;">' + data[0].fullname + '</h3></center> ')
                $('#emp_details').html('<center><h3 style = "font-family: Georgia,serif; padding-bottom : 20px;">' + data[0].position+ ' | ' + data[0].branch + '</h3></center>')
            }
        });
    });
    function arItems(id)
    {
        $('#admin-staff-item-ar thead th').each(function () {
            table10[ty] = $(this).text();
            ty++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableEmpItemAssign = $('#admin-staff-item-ar').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Available(Unassigned) Items',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table10[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Available(Unassigned) Items',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table10[(idx)];
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
                        extend: 'print',
                        title : 'Available(Unassigned) Items',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table10[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    type: 'get',
                    url: "/admin-staff-assign-to-ar",
                    data: function (d)
                    {
                        d.emp_id = ar_info_id;
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'item_profile.id'},
                    {data: 'category' , name: 'item_profile.item_category'},
                    {data: 'model', name: 'item_profile.item_brand_model'},
                    {data: 'amount', name: 'item_profile.item_amount'},
                    {data: 'color', name: 'item_profile.item_color'},
                    {data: 'remarks', name: 'item_profile.item_remarks'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-item-ar_filter input').unbind();
        $('#admin-staff-item-ar_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableEmpItemAssign.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableEmpItemAssign.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#admin-staff-ar-table').on('click','.btn_delete_ar', function () {
        var id = $(this).attr('value');
        var path = $(this).attr('name');

        var test = atob(path);
        console.log(id);
        console.log(path);
        console.log(test);
    });

    function ar_fetch_success() {

        $.ajax
        ({
            type: 'get',
            url: 'admin_get_ar_description',
            data:{
                'emp_id' :   viewExpID
            },
            success: function (data)
            {
                var j;
                var ar_list = '';


                for (j = 0; j < data.length; j++)
                {
                    ar_list += '<option name="'+j+'" value="' + data[j].id + '">' + data[j].ar_description + '</option>';

                }
                $('#ar_selected').html(ar_list);
            }

        });
    }

    $('#btnSubmitFund').click(function()
    {
        $('#btnSubmitFund').attr('disabled', true);
        var fundMonth = $('#fund_month').val();
        var fundBranch = $('#fund_branch').val();
        var fundAmount = $('#fund_amount').val();
        var fundParticular = $('#fund_particular').val();
        var fundAccount = $('#fund_number').val();
        var fundStatement = $('#fund_date_statement').val();
        var fundDue = $('#fund_date_due').val();
        var fundRequestDate = $('#fund_date_requested').val();
        var fundRequestor = $('#fund_requestor').val();

        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-fund-request',
            data :
                {
                    'fundMonth' : fundMonth,
                    'fundBranch' : fundBranch,
                    'fundAmount' : fundAmount,
                    'fundParticular' : fundParticular,
                    'fundAccount' : fundAccount,
                    'fundStatement' : fundStatement,
                    'fundDue' : fundDue,
                    'fundRequestDate' : fundRequestDate,
                    'fundRequestor' : fundRequestor
                },
            beforeSend : function() {
                $('#modal-sendingrequest').modal('show');
            },
            success : function(data)
            {
                if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#btnSubmitFund').attr('disabled', false);

                    var timerFail = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-filluperror').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerFail);
                    },500);
                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#btnSubmitFund').attr('disabled', false);
                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-successrequest').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-successrequest').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#fund_month').val('January');
                    $('#fund_branch').val('');
                    $('#fund_amount').val('');
                    $('#fund_particular').val('');
                    $('#fund_number').val('');
                    $('#fund_date_statement').val('');
                    $('#fund_date_due').val('');
                    $('#fund_date_requested').val('');
                    $('#fund_requestor').val('');
                    counterFund = true;
                    tableAdminAssignLogs.ajax.reload(null, false);
                    tableFundList.ajax.reload(null, false);
                    totalReq();
                }
            }
        })
    });
    function showFundRequest()
    {
        $('#admin-staff-fund-monitor thead th').each(function ()
        {
            tableFund[fund_table] = $(this).text();
            fund_table++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableFundList = $('#admin-staff-fund-monitor').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Fund Requests List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableFund[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Fund Requests List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableFund[(idx)];
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
                        extend: 'print',
                        title : 'Fund Requests List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableFund[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tableFund[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-fund-table",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'request_month', name: 'request_month'},
                    {data: 'request_branch', name: 'request_branch'},
                    {data: 'request_amount', name: 'request_amount'},
                    {data: 'request_particular', name: 'request_particular'},
                    {data: 'request_account', name: 'request_account'},
                    {data: 'statement_date', name: 'statement_date'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'date_requested', name: 'date_requested'},
                    {data: 'requested_processed', name: 'requested_processed'},
                    {
                        data: function action(data)
                        {
                            if(btntoHide == false)
                            {
                                return '<span class = "viewFundAuth" ><span id="fundEdit-' + data.id + '"><button class = "btnEditFund btn btn-xs btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-wrench"></i>Edit</button></span>' +
                                    '<span id="fundDelete-' + data.id + '"><button class = "btnDeleteFund btn btn-xs btn-danger" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-remove"></i>Remove</button></span></span>';
                            }
                            else
                            {
                                return 'Not Available';
                            }

                        },
                        "name": 'requested_processed',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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
        $('#admin-staff-fund-monitor_filter input').unbind();
        $('#admin-staff-fund-monitor_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableFundList.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableFundList.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    function getBranches()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_get_branch_sched',
            success : function(data)
            {
                var y;
                var BranchList = '';
                for (y = 0; y < data[0].length; y++)
                {
                    BranchList += '<option value="' + data[0][y].branch_name + '">' + data[0][y].branch_name + '</option>';
                }
                $('#fund_branch').html(BranchList);
            }
        })
    }
    $('.admin_staff_fund_class').click(function() {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_fund1') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeFund = '#tab_fund1';
            }
            else if (admin_fund_show) {
                if (counterFund == true) {
                    tableFundList.ajax.reload(null, false);
                    counterFund = false;
                } else {
                    console.log('already loaded');
                }
                activeFund = '#tab_fund1';

            }
            else if (admin_fund_show == false) {
                admin_fund_show = true;
                activeFund = '#tab_fund1';
            }
        }
        else if (gethref == '#tab_fund2') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeFund = '#tab_fund2';
            }
            else if (admin_fund_add) {
                console.log('already loaded');
                activeFund = '#tab_fund2';
            }
            else if (admin_fund_add == false) {
                admin_fund_add = true;
                activeFund = '#tab_fund2';
                getBranches();
            }
        }
    });

    $('#admin-staff-fund-monitor').on('click', '.btnEditFund', function()
    {
        fundUpdateId = $(this).val();
        // $('#modal-fund-edit').modal('show');
        $('#btnUpdateFund').show();
        $('#btnCancelFund').show();
        $('#btnSubmitFund').hide();
        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-get-fund',
            data :
                {
                    'id' : fundUpdateId
                },
            success : function(data)
            {
                console.log(data);
                $('#fund_month').val(data[0].request_month);
                $('#fund_branch').val(data[0].request_branch);
                $('#fund_amount').val(data[0].request_amount);
                $('#fund_particular').val(data[0].request_particular);
                $('#fund_number').val(data[0].request_account);
                $('#fund_date_statement').val(data[0].statement_date);
                $('#fund_date_due').val(data[0].due_date);
                $('#fund_date_requested').val(data[0].date_requested);
                $('#fund_requestor').val(data[0].requested_processed);
            }
        });
    });
    $('#btnCancelFund').click(function()
    {
        $('#btnUpdateFund').hide();
        $('#btnCancelFund').hide();
        $('#btnSubmitFund').show();
        $('#fund_month').val('January');
        $('#fund_branch').val('Cavite');
        $('#fund_amount').val('');
        $('#fund_particular').val('');
        $('#fund_number').val('');
        $('#fund_date_statement').val('');
        $('#fund_date_due').val('');
        $('#fund_date_requested').val('');
        $('#fund_requestor').val('');
    });

    $('#btnUpdateFund').click(function()
    {
        $('#btnUpdateFund').attr('disabled', true);

        var newFundMonth = $('#fund_month').val();
        var newFundBranch = $('#fund_branch').val();
        var newFundAmount = $('#fund_amount').val();
        var newFundParticular = $('#fund_particular').val();
        var newFundAccount = $('#fund_number').val();
        var newFundStatement = $('#fund_date_statement').val();
        var newDueDate =  $('#fund_date_due').val();
        var newDateRequested = $('#fund_date_requested').val();
        var newFundRequestor =  $('#fund_requestor').val();

        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-update-fund',
            data :
                {
                    'fundUpdateId' : fundUpdateId,
                    'newFundMonth' : newFundMonth,
                    'newFundBranch' : newFundBranch,
                    'newFundAmount' : newFundAmount,
                    'newFundParticular' : newFundParticular,
                    'newFundAccount' : newFundAccount,
                    'newFundStatement' : newFundStatement,
                    'newDueDate' : newDueDate,
                    'newDateRequested' : newDateRequested,
                    'newFundRequestor' : newFundRequestor
                },
            beforeSend: function () {
                $('#modal-sendingrequest').modal('show');
            },
            success : function(data)
            {
                if(data.error == 'required')
                {
                    $('#btnUpdateFund').attr('disabled', false);
                    $('#modal-sendingrequest').modal('hide');
                    var timerFail = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-filluperror').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerFail);
                    },500);
                }
                else
                {
                    $('#btnUpdateFund').attr('disabled', false);
                    $('#modal-sendingrequest').modal('hide');

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-fund-edit-success').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-fund-edit-success').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },500);

                    $('#btnUpdateFund').hide();
                    $('#btnCancelFund').hide();
                    $('#btnSubmitFund').show();
                    $('#fund_month').val('January');
                    $('#fund_branch').val('Cavite');
                    $('#fund_amount').val('');
                    $('#fund_particular').val('');
                    $('#fund_number').val('');
                    $('#fund_date_statement').val('');
                    $('#fund_date_due').val('');
                    $('#fund_date_requested').val('');
                    $('#fund_requestor').val('');
                    tableFundList.ajax.reload(null, false);
                    tableAdminAssignLogs.ajax.reload(null, false);
                    counterFund = true;
                }
            }
        })
    });
    $('#admin-staff-fund-monitor').on('click', '.btnDeleteFund', function()
    {
        fundUpdateId = $(this).val();
        console.log(fundUpdateId);
        if(confirm('Are you sure to remove the fund request?')) {
            $.ajax
            ({
                type : 'get',
                url : 'admin-staff-delete-fund',
                data :
                    {
                        'fundUpdateId' : fundUpdateId
                    },
                success : function()
                {
                    alert('Successfully Removed!');
                    tableFundList.ajax.reload(null, false);
                    tableAdminAssignLogs.ajax.reload(null, false);
                    counterFund = true;
                }
            });
        }
        else {

        }

    });
    $('#btnUpdateSpecStatus').click(function()
    {
        var showSpecStat = $('#show_specs_status').val();
        var clearanceForm = $('#clearance_offboarding').prop('files')[0];
        var selectedAr = $('#ar_selected').val();

        var formData = new FormData();
        formData.append('viewExpID', viewExpID);
        formData.append('remAss', remAss);
        formData.append('showSpecStat', showSpecStat);
        formData.append('clearanceForm', clearanceForm);
        formData.append('ar_employee_id', selectedAr);
        formData.append('remarks', item_remarks);

        if(clearanceForm != null)
        {
            $.ajax
            ({
                type : 'post',
                url : 'admin-staff-update-specs-stat',
                contentType: false,
                processData: false,
                async: true,
                data: formData,
                success : function()
                {
                    alert('Successfully Unassigned and Updated Status!');
                    $('#clearance_offboarding').val('');
                    $('#modal-item-status-change').modal('hide');
                    tableItemAssign.ajax.reload(null, false);
                    showEmpSel(ar_selected_id);
                    counterRemove = true;
                    tableAdminAssignLogs.ajax.reload(null, false);
                    counterOutgoing = true;
                }
            });
        }
        else
        {
            if(confirm('There is no clearance form. In this case, do you wish to forward this to finance for salary deduction?'))
            {
                // insert future codes here
                //temporary codes bypass
                $.ajax
                ({
                    type : 'post',
                    url : 'admin-staff-update-specs-stat',
                    contentType: false,
                    processData: false,
                    async: true,
                    data: formData,
                    success : function()
                    {
                        alert('Successfully Unassigned and Updated Status!');
                        $('#clearance_offboarding').val('');
                        $('#modal-item-status-change').modal('hide');
                        tableItemAssign.ajax.reload(null, false);
                        showEmpSel(ar_selected_id);
                        counterRemove = true;
                        tableAdminAssignLogs.ajax.reload(null, false);
                        counterOutgoing = true;
                    }
                });
            }
            else
            {

            }
        }

    });


    //general tables

    function generalItem()
    {
        $('#admin-staff-general-item thead th').each(function () {
            table12[poi] = $(this).text();
            poi++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralItem = $('#admin-staff-general-item').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'General Item List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table12[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'General Item List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table12[(idx)];
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
                        extend: 'print',
                        title : 'General Item List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table12[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table12[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-item-profile",
            "columns":
                [
                    {data: 'id', name: 'item_profile.id'},
                    {data: 'purchased', name: 'item_profile.item_date_purchased'},
                    {data: 'category', name: 'item_profile.item_category'},
                    {data: 'model', name: 'item_profile.item_brand_model'},
                    {data: 'amount', name: 'item_profile.item_amount'},
                    {data: 'color', name: 'item_profile.item_color'},
                    {data: 'remarks', name: 'item_profile.item_remarks'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'specs_stat' , name : 'item_profile.item_specs_status'},
                    {
                        data: function action(data) {

                            return '<span id="item-' + data.id + '"><button class="btnShowItem btn btn-xs btn-info" id="" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-arrows-alt"></i>Show Item Profile</button></span>';
                        },
                        "name": 'users_profile.emp_full_name',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-general-item_filter input').unbind();
        $('#admin-staff-general-item_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralItem.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralItem.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#admin-staff-general-item').on('click', '.btnShowItem', function()
    {
        counterGeneralView += 1;
        showItemId = $(this).val();

        $('#item_user').val('');
        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-fetch-item',
            data:
                {
                    'showItemId' : showItemId
                },
            success: function(data)
            {
                console.log(data);
                if(data[0][0].path == "")
                {
                    $('#btnDownloadPo').hide();
                    $('#noPo').show();
                    $('#noPo').html('<p style = "font-family: Georgia,serif; border-left: 5px solid red;\n' +
                        '  background-color: lightgrey;">No Available P.O File</p>');

                }
                else
                {
                    $('#noPo').hide();
                    $('#btnDownloadPo').show();
                }

                if(data[0][0].quotation == "")
                {
                    $('#dlQuotation').hide();
                    $('#noQou').show();
                    $('#noQou').html('<p style = "font-family: Georgia,serif; border-left: 5px solid red;\n' +
                        '  background-color: lightgrey;">No Uploaded Quotation</p>');
                }
                else
                {
                    $('#noQou').hide();
                    $('#dlQuotation').show();
                }

                $('#modal-itemProfile').modal('show');


                if(counterGeneralView == 1)
                {
                    item_logs_table(showItemId);
                }
                else if(counterGeneralView >= 2)
                {
                    tableItemHistory.ajax.reload(null, false);
                }
                var pic;
                if(data[0][0].picture == '')
                {
                    pic = 'item_pic/items.jpg'
                }
                else
                {
                    pic = data[0][0].picture
                }
                $('#insertItemName').html(data[0][0].model);
                $('#show_item_categ').val(data[0][0].category);
                $('#show_item_po').val(data[0][0].po);
                $('#show_id_item').val(data[0][0].item_id);
                $('#show_item_date').val(data[0][0].date);
                $('#show_item_amount').val(data[0][0].amount);
                $('#show_item_color').val(data[0][0].color);
                $('#show_item_remarks').val(data[0][0].remarks);
                $('#item_pic').attr('src', pic);
                $('#show_item_warranty').val(data[0][0].warranty)
                if(data[0][0].full_name == null) {
                    $('#item_user').val('Unassigned Equipment/Item');
                }
                else
                {
                    $('#item_user').val(data[0][0].full_name);
                }
            }
        })
    });
    function generalAr()
    {
        $('#admin-staff-general-ar thead th').each(function () {
            table13[poi2] = $(this).text();
            poi2++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        tableGeneralAr = $('#admin-staff-general-ar').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'A.R List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table13[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'A.R List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table13[(idx)];
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
                        extend: 'print',
                        title : 'A.R List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table13[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table13 [(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-ar-table",
            "columns":
                [
                    {data: 'id', name: 'ar_to_employee.id'},
                    {data: 'first_name', name: 'users_profile.emp_first_name'},
                    {data: 'middle_name', name: 'users_profile.emp_middle_name'},
                    {data: 'last_name', name: 'users_profile.emp_last_name'},
                    {data: 'description', name: 'ar_info.ar_description'},
                    {data: 'remarks', name: 'ar_info.ar_remarks'},
                    {data: 'time_created', name: 'ar_to_employee.created_at'},
                    {
                        data: function action(data)
                        {
                            return '<a href="/view_ar/'+btoa(data.path)+'" target="_blank"><button class="btn_view_ar btn btn-xs btn-success"  id="" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-eye"></i> View PDF</button></a>' +
                                '<button class="btn_view_assigned btn btn-xs btn-info"  id="" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-list"></i> View Assigned</button>';
                        },
                        "name": 'ar_to_employee.created_at',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-general-ar_filter input').unbind();
        $('#admin-staff-general-ar_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralAr.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralAr.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#admin-staff-general-ar').on('click', '.btn_view_assigned', function()
    {
        counterGeneralAr += 1;
        ar_info_id = $(this).val();
        console.log(ar_info_id);

        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-view-ar-assigned',
            data :
                {
                    'ar_info_id' : ar_info_id
                },
            success : function(data)
            {
                if(counterGeneralAr == 1)
                {
                    arItems();
                }
                else if(counterGeneralAr >= 2)
                {
                    tableEmpItemAssign.ajax.reload(null, false);
                }
                console.log(data);
                $('#modal-ar_assigned').modal('show');
                $('#ar_title').html('<p>A.R ID: ' + data[0].ar_id + ' , Description: ' + data[0].desc + '  </p>')
                $('#show_emp_image').attr('src', data[0].emp_pic);
                $('#emp_name').html('<center><h3 style = "font-family: Georgia,serif;">' + data[0].fullname + '</h3></center> ')
                $('#emp_details').html('<center><h3 style = "font-family: Georgia,serif; padding-bottom : 20px;">' + data[0].position+ ' | ' + data[0].branch + '</h3></center>')
            }
        });
    });
    function generalReq()
    {
        $('#admin-staff-general-ongoing thead th').each(function () {
            table14[poi3] = $(this).text();
            poi3++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralRequest = $('#admin-staff-general-ongoing').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Equipment Request Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table14[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Equipment Request Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table14[(idx)];
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
                        extend: 'print',
                        title : 'Equipment Request Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table14[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table14[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-general-request",
            "columns":
                [
                    {data: 'req_id', name: 'request_listitem.id'},
                    {data: 'date', name: 'item_requests.itmreq_datetime'},
                    {data: 'department', name: 'item_requests.itmreq_dept'},
                    {data: 'branch', name: 'item_requests.itmreq_branch'},
                    {data: 'requestor', name: 'item_requests.itmreq_requestor'},
                    {data: 'receiver', name: 'item_requests.itmreq_receiver'},
                    {data: 'name', name: 'request_listitem.item_name'},
                    {data: 'description', name: 'request_listitem.item_desc'},
                    {data: 'purpose', name: 'request_listitem.item_purp'},
                    {data: 'quantity', name: 'request_listitem.item_qty'}
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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

        $('#admin-staff-general-ongoing_filter input').unbind();
        $('#admin-staff-general-ongoing_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralRequest.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralRequest.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function generalFund()
    {
        $('#admin-staff-general-fund thead th').each(function ()
        {
            table15[poi4] = $(this).text();
            poi4++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralFund = $('#admin-staff-general-fund').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'General Fund Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table15[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'General Fund Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table15[(idx)];
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
                        extend: 'print',
                        title : 'General Fund Monitoring',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table15[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table15[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-fund-table",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'request_month', name: 'request_month'},
                    {data: 'request_branch', name: 'request_branch'},
                    {data: 'request_amount', name: 'request_amount'},
                    {data: 'request_particular', name: 'request_particular'},
                    {data: 'request_account', name: 'request_account'},
                    {data: 'statement_date', name: 'statement_date'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'date_requested', name: 'date_requested'},
                    {data: 'requested_processed', name: 'requested_processed'},
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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
        $('#admin-staff-general-fund_filter input').unbind();
        $('#admin-staff-general-fund_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableGeneralFund.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableGeneralFund.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function generalOut()
    {
        $('#admin-staff-general-outgoing thead th').each(function () {
            table16[poi5] = $(this).text();
            poi5++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralOut = $('#admin-staff-general-outgoing').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Outgoing Resigned Employees(Item to Return',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table16[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Outgoing Resigned Employees(Item to Return',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table16[(idx)];
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
                        extend: 'print',
                        title : 'Outgoing Resigned Employees(Item to Return',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table16[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table16[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-outgoing-emp",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'ar_list', name: 'ar_list', searchable : false},
                    {data: 'item_list', name: 'item_list', searchable : false}
                ],
            "fnRowCallback": function( nRow, aData)
            {
                if(aData.item_list == '')
                {
                    $('td', nRow).attr('hidden', 'true');
                }
            },
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-general-outgoing_filter input').unbind();
        $('#admin-staff-general-outgoing_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralOut.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralOut.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function generalSupplier()
    {
        $('#admin-staff-general-supplier thead th').each(function () {
            table17[poi6] = $(this).text();
            poi6++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGenSupplier = $('#admin-staff-general-supplier').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table17[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table17[(idx)];
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
                        extend: 'print',
                        title : 'Supplier List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table17[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-supplier-table",
            "columns":
                [
                    {data: 'id', name: 'supplier_list.id'},
                    {data: 'name', name: 'supplier_list.supp_name'},
                    {data: 'since' , name: 'supplier_list.supplier_since'},
                    {data: 'contact_phone', name: 'supplier_list.supp_contact_phone'},
                    {data: 'contact_mobile', name: 'supplier_list.supp_contact_mobile'},
                    {data: 'email', name: 'supplier_list.supp_email'},
                    {data: 'address', name: 'supplier_list.supp_address'},
                    {data: 'contact_person', name: 'supplier_list.supp_contact_person'},
                    {data: 'category', name: 'category_list.category_name'},
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-general-supplier_filter input').unbind();
        $('#admin-staff-general-supplier_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGenSupplier.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGenSupplier.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('.admin_staff_general_class').click(function() {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_gen1') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen1';
            }
            else if (admin_general1) {
                if(countItem == true || countUpdateItem == true || counterAssign == true || counterRemove == true)
                {
                    tableGeneralItem.ajax.reload(null, false);
                    countItem = false;
                    countUpdateItem = false;
                    counterAssign = false;
                    counterRemove = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen1';
            }
            else if (admin_general1 == false) {
                admin_general1 = true;
                activeGeneral = '#tab_gen1';
            }
        }
        else if (gethref == '#tab_gen2') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen2';
            }
            else if (admin_general2) {
                if(counterArforTable == true)
                {
                    tableGeneralAr.ajax.reload(null, false)
                    counterArforTable = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen2';
            }
            else if (admin_general2 == false) {
                admin_general2 = true;
                activeGeneral = '#tab_gen2';
                generalAr();
            }
        }
        else if (gethref == '#tab_gen3') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen3';
            }
            else if (admin_general3) {
                if(countSubmit == true || countHold == true || countCancel == true)
                {
                    tableGeneralRequest.ajax.reload(null, false);
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen3';
            }
            else if (admin_general3 == false) {
                admin_general3 = true;
                activeGeneral = '#tab_gen3';
                generalReq();
            }
        }
        else if (gethref == '#tab_gen4') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen4';
            }
            else if (admin_general4) {
                if(counterFund == true)
                {
                    tableGeneralFund.ajax.reload(null, false);
                    counterFund = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen4';
            }
            else if (admin_general4 == false) {
                admin_general4 = true;
                activeGeneral = '#tab_gen4';
                generalFund();
            }
        }
        else if (gethref == '#tab_gen5') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen5';
            }
            else if (admin_general5) {
                if(counterOutgoing == true)
                {
                    tableGeneralOut.ajax.reload(null, false);
                    counterOutgoing = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen5';
            }
            else if (admin_general5 == false) {
                admin_general5 = true;
                activeGeneral = '#tab_gen5';
                generalOut();
            }
        }
        else if (gethref == '#tab_gen6') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen6';
            }
            else if (admin_general6) {
                console.log('already loaded');
                activeGeneral = '#tab_gen6';
            }
            else if (admin_general6 == false) {
                admin_general6 = true;
                activeGeneral = '#tab_gen6';
                generalSupplier();
            }
        }
        else if (gethref == '#tab_gen7') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeGeneral = '#tab_gen7';
            }
            else if (admin_general7) {
                if(countItem == true || countUpdateItem == true)
                {
                    tableGeneralPo.ajax.reload(null, false);
                    countItem = false;
                    countUpdateItem = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeGeneral = '#tab_gen7';
            }
            else if (admin_general7 == false) {
                admin_general7 = true;
                activeGeneral = '#tab_gen7';
                generalPo();
            }
        }
    });
    function editItemTable()
    {
        $('#admin-staff-edit-item-table thead th').each(function () {
            table18[poi7] = $(this).text();
            poi7++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableEditGeneralItem = $('#admin-staff-edit-item-table').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table12[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return table12[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'print',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table12[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table12[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-item-profile",
            "columns":
                [
                    {data: 'id', name: 'item_profile.id'},
                    {data: 'purchased', name: 'item_profile.item_date_purchased'},
                    {data: 'category', name: 'item_profile.item_category'},
                    {data: 'model', name: 'item_profile.item_brand_model'},
                    {data: 'amount', name: 'item_profile.item_amount'},
                    {data: 'color', name: 'item_profile.item_color'},
                    {data: 'po', name: 'purchase_order.po_number'},
                    {data: 'remarks', name: 'item_profile.item_remarks'},
                    {
                        data: function action(data) {


                            return'<button class="btn_edit_item btn btn-xs btn-info"  id="" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-fw fa-edit"></i>Edit Item</button>';
                        },
                        "name": 'item_profile.item_remarks',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#admin-staff-edit-item-table_filter input').unbind();
        $('#admin-staff-edit-item-table_filter input').bind('keyup change',function (e) {
            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableEditGeneralItem.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableEditGeneralItem.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#admin-staff-edit-item-table').on('click', '.btn_edit_item', function()
    {
        itemIdEdit = $(this).val();
        $('#hideSpecStat').hide();
        $('#UpdateItem').show();
        $('#item_date').attr('type', 'text');
        $('#submitItem').hide();
        $('#cancelUpdate').show();
        $('#replaceQuot').html('Replace or Add Quotation:');
        $('#hideRequired').hide();
        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-get-details-item',
            data :
                {
                    'itemIdEdit' : itemIdEdit
                },
            success : function(data)
            {
                console.log(data);
                var pic = '';
                if(data[0].photo == '')
                {
                    pic = 'item_pic/items.jpg';
                }
                else
                {
                    pic = data[0].photo;
                }
                $('#item_profile_pic_display').attr('src', pic);
                $('#item_type').val(data[0].category);
                $('#item_model').val(data[0].model);
                $('#item_date').val(data[0].date);
                $('#item_purchase_no').val(data[0].po);
                $('#item_amount').val(data[0].amount);
                $('#item_color').val(data[0].color);
                $('#item_remarks').val(data[0].remarks);
                $('#item_warranty').val(data[0].warranty);

            }
        });
    });
    $('#UpdateItem').click(function()
    {
        $('#UpdateItem').attr('disabled', true);
        var itemType = $('#item_type').val();
        var itemModel = $('#item_model').val();
        var itemDate = $('#item_date').val();
        var itemPO = $('#item_purchase_no').val();
        var itemAmount = $('#item_amount').val();
        var itemColor = $('#item_color').val();
        var itemRemarks = $('#item_remarks').val();
        var itemImage = $('#item_profile_pic')[0].files[0];
        var itemFile = $('#item_po_file').prop('files')[0];
        var itemWarranty = $('#item_warranty').val();
        var itemQuotation =  $('#item_quotation').prop('files')[0];

        var formData = new FormData();
        formData.append('itemType', itemType);
        formData.append('itemModel', itemModel);
        formData.append('itemDate', itemDate);
        formData.append('itemPO', itemPO);
        formData.append('itemFile', itemFile);
        formData.append('itemAmount', itemAmount);
        formData.append('itemColor', itemColor);
        formData.append('itemRemarks', itemRemarks);
        formData.append('itemImage', itemImage);
        formData.append('itemIdEdit', itemIdEdit);
        formData.append('itemWarranty', itemWarranty);
        formData.append('itemQuotation', itemQuotation);
        $.ajax
        ({
            type: 'post',
            url: 'admin-staff-update-item-profile',
            contentType: false,
            processData: false,
            async: true,
            data: formData,
            beforeSend: function () {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                console.log(data);
                if(data.change == 'change')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#UpdateItem').attr('disabled', false);
                    var timerChange = setInterval(function ()
                    {
                        $('#modal-changeitem').modal('show');

                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-changeitem').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerChange);
                    },1000);
                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#UpdateItem').attr('disabled', false);
                    $('#UpdateItem').hide();
                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-updateitem').modal('show');

                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-updateitem').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#item_type').val('');
                    $('#item_model').val('');
                    $('#item_date').val('');
                    $('#item_purchase_no').val('');
                    $('#item_amount').val('');
                    $('#item_color').val('');
                    $('#item_remarks').val('');
                    $('#item_profile_pic').val('');
                    $('#item_po_file').val('');
                    $('#item_profile_pic_display').attr('src', 'item_pic/items.jpg');
                    $('#hideSpecStat').show();
                    $('#replaceQuot').html('Quotation:  <small style = "color : red">*required</small>');
                    $('#item_warranty').val('');
                    $('#item_quotation').val('');
                    tableEditGeneralItem.ajax.reload(null, false);
                    $('#UpdateItem').hide();
                    $('#submitItem').show();
                    $('#cancelUpdate').hide();
                    countUpdateItem = true;
                    $('#item_date').attr('type', 'date');
                    tableAdminAssignLogs.ajax.reload(null, false);
                    $('#hideRequired').show();
                }
            }
        });
    });
    $('#cancelUpdate').click(function()
    {
        $('#item_date').attr('type', 'date');
        $('#item_type').val('');
        $('#item_model').val('');
        $('#item_date').val('');
        $('#item_purchase_no').val('');
        $('#item_amount').val('');
        $('#item_color').val('');
        $('#item_remarks').val('');
        $('#item_profile_pic').val('');
        $('#item_po_file').val('');
        $('#item_profile_pic_display').attr('src', 'item_pic/items.jpg');
        $('#hideSpecStat').show();
        $('#UpdateItem').hide();
        $('#submitItem').show();
        $('#cancelUpdate').hide();
        $('#item_date').attr('type', 'date');
        $('#replaceQuot').html('Quotation: ');
        $('#item_warranty').val('');
        $('#hideRequired').show();
    });

    function generalPo()
    {
        $('#admin-staff-general-po thead th').each(function ()
        {
            table19[poi8] = $(this).text();
            poi8++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralPo = $('#admin-staff-general-po').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Purchase Order List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table19[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Purchase Order List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table19[(idx)];
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
                        extend: 'print',
                        title : 'Purchase Order List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  table19[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table19[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-staff-po-view",
            "columns":
                [
                    {data: 'po', name: 'purchase_order.po_number'},
                    {
                        data: function status(data)
                        {
                            if(data.path != '')
                            {
                                return'<span><button class="btn btn-xs btn-info btnDlPo" id="" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download Document</button></span>';
                            }
                            else
                            {
                                return 'Not Available';
                            }


                        },
                        "name": 'purchase_order.po_number',
                        "searchable" : false
                    }

                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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
        $('#admin-staff-general-po_filter input').unbind();
        $('#admin-staff-general-po_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableGeneralPo.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableGeneralPo.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#admin-staff-general-po').on('click', '.btnDlPo', function()
    {
        var poId = $(this).val();
        console.log('test');
        var id_encode = btoa(poId);
        var q = '<form action="/admin-staff-file-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#down').html(q);
        $('#button_form_download').click();
    });
    $('#cancelQuot').click(function()
    {
        $('#item_quotation').val('');
    });
    $('#dlQuotation').click(function()
    {
        var id_encode = btoa(showItemId);
        var q = '<form action="/admin-staff-quot-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_quot_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downQoutation').html(q);
        $('#button_quot_download').click();
    });
    $('#admin-staff-supplier').on('click', '#dlSupp' , function()
    {
        console.log('12312312')
        var suppId = $(this).val();
        var id_encode = btoa(suppId);
        var q = '<form action="/admin-staff-supp-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_supp_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downSupp').html(q);
        $('#button_supp_download').click();
    });

    function totalReq()
    {
        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-total-req',
            success : function(data)
            {
                console.log(data);
                var sum = 0;
                for(var i = 0; i < data.length; i++)
                {
                    sum += parseInt(data[i].request_amount);
                }

                $('#show_total_req').val('₱ ' + sum);
            }
        })
    }
    function generalForms()
    {

        $('#human-resources-file-format thead th').each(function () {
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralForms = $('#human-resources-file-format').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-file-format-table",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'file_title', name: 'file_title'},
                    {data: 'file_desc', name: 'file_desc'},
                    {
                        data: function action(data)
                        {
                            return '<span><button class="btn btn-xs btn-success btn-block" id="btnDownloadFormat" name="" value="' + data.id + '" ><i class = "fa fa-fw fa-download"></i>Download</button></span>' +
                                '<span id = "downForm"></span><button class="btn btn-primary btn-xs btn-block archive_file_data" style="margin-top: 1%;" id="'+data.id+'"><i class="glyphicon glyphicon-folder-open"></i>Archive</button> ';

                        },
                        searchable : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

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
        $('#human-resources-file-format_filter input').unbind();
        $('#human-resources-file-format_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralForms.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralForms.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    $('#docuLoad').click(function()
    {
        $.ajax
        ({
            type: 'get',
            url: 'admin-staff-auth-view',
            success: function (data)
            {
                if(data[0].authrequest == 'Uploader')
                {
                    var a = ' <div class = "col-md-4">\n' +
                        '                            <div class = "box box-danger">\n' +
                        '                                <center>\n' +
                        '                                    <h4 style = "font-family: Georgia,serif;">File Uploading</h4>\n' +
                        '                                </center>\n' +
                        '                                <div class = "row" style = "padding-top : 20px;">\n' +
                        '                                    <div class = "col-md-8">\n' +
                        '                                        <label for="">Document Title: <small style = "color: red;">*required field</small></label>\n' +
                        '                                        <input type="text" id = "doc_upload_title_admin" class = "form-control">\n' +
                        '                                    </div>\n' +
                        '                                    <div class = "col-md-4"></div>\n' +
                        '                                </div>\n' +
                        '                                <div class = "row" style = "padding-top : 10px;">\n' +
                        '                                    <div class = "col-md-12">\n' +
                        '                                        <label for="">Description: <small style = "color: orange;">*optional</small></label>\n' +
                        '                                        <textarea id="doc_upload_desc_admin" rows="5" class = "form-control"></textarea>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class = "row" style = "padding-top : 10px; padding-bottom : 10px;">\n' +
                        '                                    <div class = "col-md-12" style = "padding-top: 10px;">\n' +
                        '                                        <label for="">File/s to be uploaded: <small style = "color: red;">*required field</small> </label>' +
                        '                                        <div class = "row" id = "addFilesAdmin"></div><div class "row" style = "padding-top : 15px;">' +
                        '                                           <div class = "col-md-5">' +
                        '                                           </div>' +
                        '                                           <div class = "col-md-2"><button class = "btn btn-block  btn-primary btn-xs btn_general_add_file" style = "width : 100%"><i class = "glyphicon glyphicon-plus"></i></button></div>' +
                        '                                           <div class = "col-md-5"></div>' +
                        '                                        </div> ' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                   <div class = "row" style = "padding-top : 20px;">\n' +
                        '                                                <div class = "col-md-12">\n' +
                        '                                                    <span id="ulPercentage_admin_files" hidden>--</span>\n' +
                        '                                                    <div id="progressbar_admin_files" hidden></div>\n' +
                        '                                                </div>\n' +
                        '                                            </div>' +
                        '                                <div class = "" style = "margin-top : 20px;">\n' +
                        '                                    <button type = "button" id ="submitFilesGenerals" class = "btn btn-success pull-right">Upload Document</button>\n' +
                        '                                </div>\n' +
                        '                            </div>\n' +
                        '                        </div>';

                    $('#changeFormSizeAdmin').attr('class', 'col-md-8');
                    $('#formUploadAdmin').html(a);
                    $('#editSizeModalAdmin').css('width', '70%');

                    $('.btn_general_add_file').click(function()
                    {

                        $('.adminFilesTobeUploadedBulk').each(function()
                        {
                            counterAdd++;
                        });

                        if(counterAdd <= 0)
                        {
                            countAdminFiles = 0;
                        }

                        countAdminFiles++;

                        var b = '                          <span id="row_'+countAdminFiles+'"><div class ="row" style = "padding-top : 25px;">' +
                            '                               <div class ="col-md-12">' +
                            '                                  <h5 style = "text-align: center"><b>File '+countAdminFiles+'</b></h5>' +
                            '                               </div>' +
                            '                               <div class = "row" style = "padding-top : 25px;">' +
                            '                                   <div class = "col-md-3"></div>' +
                            '                                   <div class = "col-md-6"><input type="file" class = "adminFilesTobeUploadedBulk"></div>' +
                            '                                   <div class = "col-md-3"><button class="btn btn-sm btn-danger removeFileUpload" id="'+countAdminFiles+'" title="Remove File"><i class="glyphicon glyphicon-minus"></i></button></div></div>' +
                            '                               </div></span>';

                        $('#addFilesAdmin').append(b);

                    });

                    $('#submitFilesGenerals').click(function()
                    {
                        var btn = $(this);
                        btn.attr('disabled', true);

                        var countFiles = 0;
                        var docTitle = $('#doc_upload_title_admin').val();
                        var docDesc = $('#doc_upload_desc_admin').val();

                        var formData = new FormData();

                        if(docTitle != '')
                        {
                            $('.adminFilesTobeUploadedBulk').each(function()
                            {
                                if($(this).val() != '')
                                {
                                    formData.append('file-'+countFiles+'', $(this).prop('files')[0]);

                                    countFiles++;
                                }
                            });

                            formData.append('docTitle', docTitle);
                            formData.append('docDesc', docDesc);
                            formData.append('countFiles', countFiles);

                            if(countFiles > 0)
                            {
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
                                                $('#ulPercentage_admin_files').html('');
                                                $('#ulPercentage_admin_files').show();
                                                // $('#ulPercentage').append(percentComplete*100);
                                                $('#ulPercentage_admin_files').append(Math.floor(percentComplete*100));
                                                $('#progressbar_admin_files').show();
                                                $('#progressbar_admin_files').progressbar
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
                                    url : 'admin-staff-general-upload-mult',
                                    contentType: false,
                                    processData: false,
                                    async : true,
                                    data : formData,
                                    success : function()
                                    {
                                        $('#doc_upload_title_admin').val('');
                                        $('#doc_upload_desc_admin').val('');
                                        tableAdminAssignLogs.ajax.reload(null, false);

                                    },
                                    complete : function()
                                    {
                                        btn.attr('disabled', false);
                                        $('#addFilesAdmin').html('');
                                        countAdminFiles = 0;
                                        tableGeneralForms.ajax.reload(null, false);
                                        alert('Successfully Uploaded!');
                                        $('#ulPercentage_admin_files').hide();
                                        $('#progressbar_admin_files').hide();
                                    }
                                });
                            }
                            else
                            {
                                alert('Please select atleast 1 file!');
                                btn.attr('disabled', false);
                            }
                        }
                        else
                        {
                            alert('Please select document title.');
                            btn.attr('disabled', false);
                        }
                    })

                }
            }
        });

        generalForms();
    });

    $('#human-resources-file-format').on('click', '#btnDownloadFormat', function()
    {
        var docId = $(this).val();
        var id_encode = btoa(docId);
        var q = '<form action="/admin-staff-doc-format" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_doc_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downForm').html(q);
        $('#button_doc_download').click();
        $('#downForm').hide();
    });

    $('#human-resources-file-format-archived').on('click', '#btnDownloadFormat', function()
    {
        var docId = $(this).val();
        var id_encode = btoa(docId);
        var q = '<form action="/admin-staff-doc-format" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_doc_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downForm').html(q);
        $('#button_doc_download').click();
        $('#downForm').hide();
    });

    function employee_list_table_view()
    {
        $('#admin-staff-employee-list-view thead th').each(function ()
        {
            tableEmp[tableEmpCountHead] = $(this).text();
            tableEmpCountHead++;
            var title = $(this).text();
            $(this).html(title);
        });

        tableEmployeeListAdmin = $('#admin-staff-employee-list-view').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'colvis',
                        columnText: function (dt, idx, title)
                        {
                            return tableEmp[(idx)];
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'On-Process Employee List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return tableEmp[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'print',
                        title: 'On-Process Employee List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return tableEmp[(idx)];
                                        }
                                    }
                            }
                    }
                ],
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "ajax": "admin-staff-employee-table",
            "columns":
                [
                    {data : 'id', name : 'users_profile.id'},
                    {data : 'name', name : 'users_profile.emp_full_name'},
                    {data : 'position', name : 'users_profile.emp_position'},
                    {data : 'branch', name : 'branch_list.branch_name'},
                    {data : 'birth', name : 'users_profile.emp_date_birth'},
                    {data : 'gender', name : 'users_profile.emp_gender'},
                    {data : 'marital', name : 'users_profile.emp_marital_status'},
                    {data : 'con_status', name : 'users_profile.emp_status'},
                    {data : 'emp_status', name : 'users_profile.emp_process_status'},
                    {data : 'hired', name : 'users_profile.emp_date_hired'},
                    {data : 'end', name : 'users_profile.emp_end_date'},
                    {
                        data : function action(data)
                        {
                            var a;

                            if(data.approval == 'R-Approved')
                            {
                                if(data.tag == 'Incomplete')
                                {
                                    a =  '<button class="btn btn-block btn-primary" disabled> <i class="fa fa-fw fa-check-circle-o"></i> For Final Approval(With Incomplete Requirements)</button>' +
                                        '<button class="btnViewIncomRem btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-eye"></i> View Incomplete Remarks</button>';
                                }
                                else
                                {
                                    a =  '<button class="btn btn-block btn-primary" disabled> <i class="fa fa-fw fa-check-circle-o"></i> For Final Approval</button>';
                                }
                            }
                            else if(data.approval == 'Returned')
                            {
                                a =  '<button class="btn btn-block bg-red-gradient" disabled> <i class="fa fa-fw fa-reply"></i> Returned to Associates</button>' +
                                    '<button class="btnViewReturn btn btn-md btn-danger btn-block" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-fw fa-commenting-o"></i> View Return Remarks</button>';
                            }
                            else if(data.approval == 'Requested')
                            {
                                if(data.tag ==  'Incomplete')
                                {
                                    a =  '<button class="btn btn-block bg-olive-active" disabled> <i class="fa fa-fw fa-send"></i> Requested(Tagged as Incomplete)</button>' +
                                        '<button class="btnViewIncomRem btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-eye"></i> View Incomplete Remarks</button>';
                                }
                                else
                                {
                                    a =  '<button class="btn btn-block btn-md bg-olive-active" disabled> <i class="fa fa-fw fa-send"></i> Requested</button>';
                                }
                            }

                            return '<button class = "btnViewProfile btn btn-block btn-sm btn-info" value = "'+data.id+'"><i class = "fa fa-fw fa-info-circle"></i> View Profile</button>' + a;
                        },
                        'searchable' : false,
                        'orderable' : false
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

        $('#admin-staff-employee-list-view_filter input').unbind();
        $('#admin-staff-employee-list-view_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableEmployeeListAdmin.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableEmployeeListAdmin.search($(this).val()).draw();
                    }
                }
            }
        });
    }
});

$('#admin-staff-employee-list-view-approved').on('click', '.btnViewProfile', function()
{
    empIDshow = $(this).val();
    countExp += 1 ;
    showExtraEmp();
    $.ajax
    ({
        type: 'get',
        url: 'human_resources_show_profile',
        data:
            {
                'empIDshow' : empIDshow
            },
        success: function(data)
        {
            console.log(data);
            $('#modal-emp-profile-view').modal('show');

            if(data[0][0].position == 'Field Verifier')
            {
                $('#ciMotorReqView').show();
                $('#officeChecklistView').hide();
                $('#ciChecklistView').show();
                $('#ciShow').show();
            }
            else
            {
                $('#ciMotorReqView').hide();
                $('#officeChecklistView').show();
                $('#ciChecklistView').hide();
                $('#ciShow').hide();
            }
            var out;

            if(data[0][0].outgoing == "")
            {
                out = "N/A";
            }
            else
            {
                out = data[0][0].outgoing;
            }

            function date_diff_indays(date1, date2) {
                var dt1 = new Date(date1);
                var dt2 = new Date(date2);
                return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
            }
            var now = new Date();
            var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
            var test1 = date_diff_indays(data[0][0].hired , now);
            var diff = contactdiff - test1 ;
            var showDiff;
            if(diff <= -1)
            {
                showDiff = 'CONTRACT EXPIRED'
            } else {
                showDiff = diff + ' days'
            }
            var pic;


            var allowance;
            if(data[0][0].allowance == '')
            {
                allowance = 'None';
            }
            else
            {
                allowance = data[0][0].allowance
            }
            var monIn;
            if(data[6][0].emp_in == '00:00:00'){
                monIn = null;
            } else {
                monIn = data[6][0].emp_in;
            }
            var monOut;
            if(data[6][0].emp_out == '00:00:00'){
                monOut = null;
            } else {
                monOut = data[6][0].emp_out;
            }
            var tuesIn;
            if(data[7][0].emp_in == '00:00:00'){
                tuesIn = null;
            } else {
                tuesIn = data[7][0].emp_in;
            }
            var tuesOut;
            if(data[7][0].emp_out == '00:00:00'){
                tuesOut = null;
            } else {
                tuesOut = data[7][0].emp_out
            }
            var wedIn;
            if(data[8][0].emp_in == '00:00:00'){
                wedIn = null;
            } else {
                wedIn = data[8][0].emp_in ;
            }
            var wedOut;
            if(data[8][0].emp_out == '00:00:00'){
                wedOut = null;
            } else {
                wedOut = data[8][0].emp_out;
            }
            var thursIn;
            if(data[9][0].emp_in == '00:00:00'){
                thursIn = null;
            } else {
                thursIn = data[9][0].emp_in;
            }
            var thursOut;
            if(data[9][0].emp_out == '00:00:00'){
                thursOut = null;
            } else {
                thursOut = data[9][0].emp_out;
            }
            var friIn;
            if(data[10][0].emp_in == '00:00:00'){
                friIn = null;
            } else {
                friIn = data[10][0].emp_in;
            }
            var friOut;
            if(data[10][0].emp_out == '00:00:00'){
                friOut = null;
            } else {
                friOut = data[10][0].emp_out;
            }
            var satIn;
            if(data[11][0].emp_in == '00:00:00'){
                satIn = null;
            } else {
                satIn = data[11][0].emp_in;
            }
            var satOut;
            if(data[11][0].emp_out == '00:00:00'){
                satOut = null;
            } else {
                satOut = data[11][0].emp_out;
            }
            var sunIn;
            if(data[12][0].emp_in == '00:00:00'){
                sunIn = null;
            } else {
                sunIn = data[12][0].emp_in;
            }
            var sunOut;
            if(data[12][0].emp_out == '00:00:00'){
                sunOut = null;
            } else {
                sunOut = data[12][0].emp_out;
            }

            $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
            $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
            $('#emp_show_pic_me').attr('src',  pic);
            $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
            $('#emp_show_age').val(data[0][0].age);
            $('#emp_show_religion').val(data[0][0].religion);
            $('#emp_show_date_birth').val(data[0][0].date_birth);
            $('#emp_show_branch').val(data[0][0].branch);
            $('#emp_show_marital_status').val(data[0][0].marital_status);
            $('#emp_show_dependents').val(data[0][0].dependents);
            $('#emp_show_permanent').val(data[1][0].emp_address);
            $('#emp_show_present').val(data[2][0].emp_address);
            $('#emp_show_mobile').val(data[3][0].emp_contact_info);
            $('#emp_show_email').val(data[4][0].emp_contact_info);
            $('#emp_show_ss').val(data[0][0].sss);
            $('#emp_show_philhealth').val(data[0][0].philhealth);
            $('#emp_show_pagibig').val(data[0][0].pagibig);
            $('#emp_show_tin').val(data[0][0].tin);
            $('#emp_show_area').val(data[0][0].muni);
            $('#emp_show_cc').val(data[0][0].type);
            $('#emp_show_con_stat').val(data[0][0].con_stat);
            $('#emp_show_emp_status').val(data[0][0].emp_stat);
            $('#emp_show_outgoing').val(out);
            $('#emp_show_rate').val(data[0][0].rate);
            $('#emp_show_days').val(data[0][0].days + ' days');
            $('#emp_show_remaining').val(showDiff);
            $('#emp_show_allowances').val('₱ ' + allowance);
            $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
            $('#view_in1').val(monIn);
            $('#view_out1').val(monOut);
            $('#view_in2').val(tuesIn);
            $('#view_out2').val(tuesOut);
            $('#view_in3').val(wedIn);
            $('#view_out3').val(wedOut);
            $('#view_in4').val(thursIn);
            $('#view_out4').val(thursOut);
            $('#view_in5').val(friIn);
            $('#view_out5').val(friOut);
            $('#view_in6').val(satIn);
            $('#view_out6').val(satOut);
            $('#view_in7').val(sunIn);
            $('#view_out7').val(sunOut);
            $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
            $('#emp_id_stat_view').html(data[0][0].id_card);
            $('#emp_id_no_view').html(data[0][0].id_no);
            $('#emp_uni_view').html(data[0][0].uni);
            $('#emp_bank_name_view').html(data[0][0].bank_name);
            $('#emp_health_card_view').html(data[0][0].health);
            $('#emp_accident_view').html(data[0][0].accident);
            $('#emp_phone_number_view').html(data[0][0].phone_no);
            $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
            $('#emp_phone_desc_view').html(data[0][0].phone_desc);
            $('#emp_oims_view').html(data[0][0].oims);
            $('#emp_gmail_view').html(data[0][0].gmail);
            $('#emp_fb_view_me').html(data[0][0].fb);
            $('#emp_computer_view_me').html(data[0][0].com);
            $('#emp_gmail_password_me').html(data[0][0].pass);

            var i;
            var check;

            $('.view_checklist').prop('checked', false);

            $('.view_checklist').each(function()
            {
                check = $(this).val();
                for(i = 0; i < data[13][0].length; i++)
                {
                    if(data[13][0][i].check_name == check)
                    {
                        $(this).prop('checked', true);
                    }
                }
            });
        }
    });
});

function employee_exp_table()
{
    $('#human-resources-show-exp thead th').each(function ()
    {
        table_exp[expC] = $(this).text();
        expC++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableExplist = $('#human-resources-show-exp').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                type: 'get',
                url: "/human-resources-employee-show-exp",
                data: function (d)
                {
                    d.emp_id = empIDshow;
                }
            },
        "columns":
            [
                {data: 'company_name', name: 'company_name'},
                {data: 'company_address', name: 'company_address'},
                {data: 'company_position', name: 'company_position'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'contact_no', name: 'contact_no'}
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
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
                            if (that.search() !== this.value)
                            {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '')
                            {
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
    $('#human-resources-show-exp_filter input').unbind();
    $('#human-resources-show-exp_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableExplist.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableExplist.search($(this).val()).draw();
                }
            }
        }
    });
}
function employee_educ_table()
{
    $('#human-resource-show-educ thead th').each(function () {
        table_educ[educC] = $(this).text();
        educC++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableEduclist = $('#human-resource-show-educ').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        //   "ajax": "/human-resources-employee-show-exp",
        "ajax":
            {
                type: 'get',
                url: "/human-resources-employee-show-educ",
                data: function (d)
                {
                    d.emp_id = empIDshow;
                }
            },
        "columns":
            [
                {data: 'educ_level', name: 'educ_level'},
                {data: 'school_name', name: 'school_name'},
                {data: 'school_address', name: 'school_address'},
                {data: 'year_graduated', name: 'year_graduated'},
                {data: 'educ_course', name: 'educ_course'}
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
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
    $('#human-resource-show-educ_filter input').unbind();
    $('#human-resource-show-educ_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableEduclist.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableEduclist.search($(this).val()).draw();
                }
            }
        }
    });
}
function employee_ref_table()
{
    $('#human-resources-show-ref thead th').each(function ()
    {
        table_char[charC] = $(this).text();
        charC++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableReflist = $('#human-resources-show-ref').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        //   "ajax": "/human-resources-employee-show-exp",
        "ajax":
            {
                type: 'get',
                url: "/human-resources-employee-show-char",
                data: function (d)
                {
                    d.emp_id = empIDshow;
                }
            },
        "columns":
            [
                {data: 'char_name', name: 'char_name'},
                {data: 'char_position', name: 'char_position'},
                {data: 'char_company_name', name: 'char_company_name'},
                {data: 'char_contact', name: 'char_contact'}
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
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
                            if (that.search() !== this.value)
                            {
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
    $('#human-resources-show-ref_filter input').unbind();
    $('#human-resources-show-ref_filter input').bind('keyup change', function (e) {
        if ($(this).is(':focus')) {
            if (e.keyCode == 13) {
                tableReflist.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '') {
                    tableReflist.search($(this).val()).draw();
                }
            }
        }
    });
}
function employee_assigned_items()
{

    $('#human-resource-assigned-items-view thead th').each(function () {
        table_items[assignedC] = $(this).text();
        assignedC++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableAssigned = $('#human-resource-assigned-items-view').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        // "ajax": "/human-resources-employee-items",
        "ajax":
            {
                type: 'get',
                url: "/human-resources-employee-items",
                data: function (d)
                {
                    console.log(empIDshow);
                    d.emp_id = empIDshow;
                }
            },
        "columns":
            [
                {data: 'id', name: 'item_profile.id'},
                {data: 'category', name: 'item_profile.item_category'},
                {data: 'model', name: 'item_profile.item_brand_model'},
                {data: 'color', name: 'item_profile.item_color'},
                {data: 'remarks', name: 'item_profile.item_remarks'}
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
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
    $('#human-resource-assigned-items-view_filter input').unbind();
    $('#human-resource-assigned-items-view_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableAssigned.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableAssigned.search($(this).val()).draw();
                }
            }
        }
    });
}

function showExtraEmp()
{
    if($('#tabTest1').attr('class') == 'active')
    {
        if(countExp >= 2) {
            tableExplist.ajax.reload(null, false);
            hr_show_exp = true;
            hr_show_educ = false;
            hr_show_ref = false;
            hr_show_eq = false;
        }
        else {
            employee_exp_table();
            hr_show_exp_aldy = true;
            hr_show_exp = true;
            hr_show_educ = false;
            hr_show_ref = false;
            hr_show_eq = false;
        }
    }
    else if($('#tabTest2').attr('class') == 'active')
    {
        if(countExp >= 2) {
            tableEduclist.ajax.reload(null, false);
            hr_show_exp = false;
            hr_show_educ = true;
            hr_show_ref = false;
            hr_show_eq = false;
        }
        else {
            employee_educ_table();
            hr_show_educ_aldy = true;
            hr_show_exp = false;
            hr_show_educ = true;
            hr_show_ref = false;
            hr_show_eq = false;
        }
    }
    else if($('#tabTest3').attr('class') == 'active')
    {
        if(countExp >= 2) {
            tableReflist.ajax.reload(null, false);
            hr_show_exp = false;
            hr_show_educ = false;
            hr_show_ref = true;
            hr_show_eq = false;
        }
        else
        {
            employee_ref_table();
            hr_show_ref_aldy = true;
            hr_show_exp = false;
            hr_show_educ = false;
            hr_show_ref = true;
            hr_show_eq = false;
        }
    }
    else if($('#tabTest4').attr('class') == 'active')
    {
        if(countExp >= 2) {
            tableAssigned.ajax.reload(null, false);
            hr_show_exp = false;
            hr_show_educ = false;
            hr_show_ref = false;
            hr_show_eq = true;
        }
        else
        {
            employee_assigned_items();
            hr_show_eq_aldy = true;
            hr_show_exp = false;
            hr_show_educ = false;
            hr_show_ref = false;
            hr_show_eq = true;
        }
    }
}

$('.human_resources_tab_show_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tab_Show1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeExp = '#tab_Show1';
        }
        else if (hr_show_exp) {
            console.log('already loaded');
            activeExp = '#tab_Show1';
        }
        else if (hr_show_exp == false) {
            console.log('Table load');
            hr_show_exp = true;
            activeExp = '#tab_Show1';

            if(hr_show_exp_aldy)
            {
                tableExplist.ajax.reload(null, false);
            }
            else
            {
                hr_show_exp_aldy = true;
                employee_exp_table();
            }
        }
    }
    else if (gethref == '#tab_Show2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeExp = '#tab_Show2';
        }
        else if (hr_show_educ) {
            console.log('already loaded');
            activeExp = '#tab_Show2';
        }
        else if (hr_show_educ == false) {
            console.log('Table load');
            hr_show_educ = true;
            activeExp = '#tab_Show2';

            if(hr_show_educ_aldy)
            {
                tableEduclist.ajax.reload(null, false);
            }
            else
            {
                hr_show_educ_aldy = true;
                employee_educ_table();
            }
        }
    }
    else if (gethref == '#tab_Show3') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeExp = '#tab_Show3';
        }
        else if (hr_show_ref) {
            console.log('already loaded');
            activeExp = '#tab_Show3';
        }
        else if (hr_show_ref == false) {
            console.log('Table load');
            hr_show_ref = true;
            activeExp = '#tab_Show3';


            if(hr_show_ref_aldy)
            {
                tableReflist.ajax.reload(null, false);
            }
            else
            {
                hr_show_ref_aldy = true;
                employee_ref_table();
            }
        }
    }
    else if (gethref == '#tab_Show4') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeExp = '#tab_Show4';
        }
        else if (hr_show_eq) {
            console.log('already loaded');
            activeExp = '#tab_Show4';
        }
        else if (hr_show_eq == false) {
            console.log('Table load');
            hr_show_eq = true;
            activeExp = '#tab_Show3';



            if(hr_show_eq_aldy)
            {
                tableAssigned.ajax.reload(null, false);
            }
            else
            {
                hr_show_eq_aldy =true;
                employee_assigned_items();
            }
        }
    }
});

function atmUni()
{
    $('#admin-staff-atm-uni thead th').each(function ()
    {
        tableAtm[atmC] = $(this).text();
        atmC++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableAtmList = $('#admin-staff-atm-uni').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Bank, Uniforms, ID and Health(Employees)',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableAtm[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Bank, Uniforms, ID and Health(Employees)',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableAtm[(idx)];
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
                    extend: 'print',
                    title : 'Bank, Uniforms, ID and Health(Employees)',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableAtm[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return tableAtm[(idx)];
                    }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/human-resources-atm-table",
        "columns":
            [
                {data: 'id', name: 'users_profile.id'},
                {data: 'name', name: 'users_profile.emp_full_name'},
                {data: 'branch', name: 'branch_list.branch_name'},
                {data: 'position', name: 'users_profile.emp_position'},
                {
                    data : function a(data)
                    {
                        return '<button class = "btn btn-block btn-info viewReq" name = "'+data.id+'" style = "width : 100%" ><i class = "fa fa-fw fa-info-circle"></i> View Request Info</button>';
                    },
                    name : 'users_profile.id',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
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
    $('#admin-staff-atm-uni_filter input').unbind();
    $('#admin-staff-atm-uni_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableAtmList.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '')
                {
                    tableAtmList.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.admin_staff_employee_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tab_main1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeEmpNeed = 'tab_main1';
        }
        else if (emp_list_bool) {
            console.log('already loaded');
            activeEmpNeed = 'tab_main1';
        }
        else if (emp_list_bool == false) {
            emp_list_bool = true;
            activeEmpNeed = 'tab_main1';
        }
    }
    else  if (gethref == '#tab_main2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeEmpNeed = 'tab_main2';
        }
        else if (emp_need_bool) {
            console.log('already loaded');
            activeEmpNeed = 'tab_main2';
        }
        else if (emp_need_bool == false) {
            emp_need_bool = true;
            activeEmpNeed = 'tab_main2';
            atmUni();
            employeeFetchAtm();
        }
    }
});

$('.admin_staff_status_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tab_stat1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeGmail = 'tab_stat1';
        }
        else if (emp_need_tab_bool) {
            console.log('already loaded');
            activeGmail = 'tab_stat1';
        }
        else if (emp_need_tab_bool == false) {
            emp_need_tab_bool = true;
            activeGmail = 'tab_stat1';
        }
    }
    else  if (gethref == '#tab_stat2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeGmail = 'tab_stat2';
        }
        else if (emp_oims_gmail_bool) {
            console.log('already loaded');
            activeGmail = 'tab_stat2';
        }
        else if (emp_oims_gmail_bool == false) {
            emp_oims_gmail_bool = true;
            activeGmail = 'tab_stat2';
            showOims();
            employeeFetchOims()
        }
    }
});

function showOims()
{
    $('#admin-staff-show-oims thead th').each(function ()
    {
        tableOims[oims_table] = $(this).text();
        oims_table++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableOimsList = $('#admin-staff-show-oims').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'OIMS and Corporate Gmail Access',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return  tableOims[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'OIMS and Corporate Gmail Access',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return  tableOims[(idx)];
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
                    extend: 'print',
                    title : 'OIMS and Corporate Gmail Access',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return  tableOims[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return tableAtm[(idx)];
                    }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/human-resources-oims-table",
        "columns":
            [
                {data: 'id', name: 'users_profile.id'},
                {data: 'name', name: 'users_profile.emp_full_name'},
                {data: 'branch', name: 'branch_list.branch_name'},
                {data: 'position', name: 'users_profile.emp_position'},
                {data: 'oims', name: 'emp_oims_gmail.emp_oims'},
                {data: 'gmail', name: 'emp_oims_gmail.emp_corporate_gmail'}
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
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

    $('#admin-staff-show-oims_filter input').unbind();
    $('#admin-staff-show-oims_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableOimsList.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '')
                {
                    tableOimsList.search($(this).val()).draw();
                }
            }
        }
    });
}



function employeeFetchAtm()
{
    $.ajax
    ({
        type: 'get',
        url: 'admin-staff-get-employees-not-approve',
        success: function (data)
        {
            var j;
            employeeList = '';

            for (j = 0; j < data.length; j++)
            {
                employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
            }
            $('#empAtmId').html(employeeList);
            $('#empAtmId').val('');

            $('#empAtmId').change(function()
            {
                editAtmId  = $(this).find(':selected').val();
                $('#btnAtm').attr("disabled", false);
                getUniIDform();
            });
        }
    });
}
function getUniIDform()
{
    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-atm',
        data:
            {
                'editAtmId' : editAtmId
            },
        success : function(data)
        {
            console.log(data);

            $('#emp_id_card').val(data[0][0].emp_id_card);
            $('#emp_id_no').val(data[0][0].emp_id_no);
            $('#emp_uniform').val(data[0][0].emp_uniform);
            $('#emp_bank').val(data[0][0].emp_bank);
            $('#emp_health_card').val(data[0][0].emp_health_card);
            $('#emp_accident').val(data[0][0].emp_accident);
            $('#emp_phone_number').val(data[0][0].emp_phone_number);
            $('#emp_phone_price').val(data[0][0].emp_phone_price);
            $('#emp_phone_desc').val(data[0][0].emp_phone_desc);
            $('#fb_emp').val(data[0][0].fb_info);
            $('#computer_emp').val(data[0][0].computer_info);
            $('#gmail_emp').val(data[1][0].emp_corporate_gmail);
            $('#oims_emp').val(data[1][0].emp_oims);
            $('#gmail_pass').val(data[1][0].gmail_password);


        }
    })
}

function employeeFetchOims()
{
    $.ajax
    ({
        type: 'get',
        url: 'admin-staff-get-employees-not-approve',
        success: function (data)
        {
            var j;
            employeeList = '';

            for (j = 0; j < data.length; j++)
            {
                employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
            }
            $('#selectIdforOIMS').html(employeeList);
            $('#selectIdforOIMS').val('');

            $('#selectIdforOIMS').change(function()
            {
                oimsGetId  = $(this).find(':selected').val();
                console.log(oimsGetId);
                $('#btnOIMS').attr("disabled", false);
                getOims();
            });
        }
    });
}
function getOims()
{
    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-oims',
        data:
            {
                'oimsGetId' : oimsGetId
            },
        success : function(data)
        {
            $('#oims_emp').val(data[0].emp_oims);
            $('#gmail_emp').val(data[0].emp_corporate_gmail);
        }
    })
}


$('#btnAtm').click(function()
{
    $('#btnAtm').attr("disabled", true);

    var idIf =  $('#emp_id_card').val();
    var idNo =  $('#emp_id_no').val();
    var empUni =  $('#emp_uniform').val();
    var empBank = $('#emp_bank').val();
    var empHealth = $('#emp_health_card').val();
    var empAcc = $('#emp_accident').val();
    var empPhNume = $('#emp_phone_number').val();
    var empPhonePirice = $('#emp_phone_price').val();
    var empPhoneDesc = $('#emp_phone_desc').val();
    var gmail_emp  = $('#gmail_emp').val();
    var oims_emp = $('#oims_emp').val();
    var fb = $('#fb_emp').val();
    var comp = $('#computer_emp').val();
    var pass = $('#gmail_pass').val();


    if(editAtmId != '' && editAtmId != null)
    {
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-update-atm',
            data:
                {
                    'editAtmId' : editAtmId,
                    'idIf' : idIf,
                    'idNo' : idNo,
                    'empUni' : empUni,
                    'empBank' : empBank,
                    'empHealth' : empHealth,
                    'empAcc' : empAcc,
                    'empPhNume' : empPhNume,
                    'empPhonePirice' : empPhonePirice,
                    'empPhoneDesc' : empPhoneDesc,
                    'gmail_emp' : gmail_emp,
                    'oims_emp' : oims_emp,
                    'fb' : fb,
                    'comp' : comp,
                    'pass' : pass
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.change == "change")
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnAtm").attr("disabled", false);

                    var timerChange = setInterval(function ()
                    {
                        $('#modal-change-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-change-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerChange);
                    },500);
                }
                else
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnAtm").attr("disabled", false);

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    employeeFetchAtm();
                    $('#emp_id_card').val('With ID');
                    $('#emp_id_no').val('');
                    $('#emp_uniform').val('');
                    $('#emp_bank').val('None');
                    $('#emp_health_card').val('');
                    $('#emp_accident').val('Not Insured');
                    $('#emp_phone_number').val('');
                    $('#emp_phone_price').val(0);
                    $('#emp_phone_desc').val('');
                    $('#fb_emp').val('');
                    $('#computer_emp').val('');
                    $('#gmail_pass').val('');
                    $('#gmail_emp').val('');
                    $('#oims_emp').val('');


                    tableAtmList.ajax.reload(null, false);
                }
            }
        })
    }
    else
    {
        alert('Please select an applicant');
        $('#btnAtm').attr("disabled", false);
    }


});

$('#btnOIMS').click(function()
{
    console.log(oimsGetId);

    $('#btnOIMS').attr('disabled', true);
    var empOims = $('#oims_emp').val();
    var empGmail = $('#gmail_emp').val();

    if(oimsGetId != '' && oimsGetId != null)
    {
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-update-access',
            data :
                {
                    'oimsGetId' : oimsGetId,
                    'empOims' : empOims,
                    'empGmail' : empGmail
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success : function(data)
            {
                if(data.change == "change")
                {
                    $('#modal-sendingrequest').modal('hide');
                    var timerFail = setInterval(function ()
                    {
                        $('#modal-change-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('modal-change-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerFail);
                    },500);
                    $('#btnOIMS').attr('disabled', false);
                }
                else
                {
                    $('#modal-sendingrequest').modal('hide');

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('modal-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#oims_emp').val('');
                    $('#gmail_emp').val('');
                    employeeFetchOims();
                    tableOimsList.ajax.reload(null,false);
                }
            }
        })
    }
    else
    {
        alert('Please select an applicant');
        $('#btnOIMS').attr('disabled', false);

    }


});

$('#admin-staff-employee-list-view').on('click', '.brnRDeniedRem', function()
{
    var btn = $(this);

    var id = btn.val();

    $('#modal-denial-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-view-denial-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            $('#show_denial_remarks').val(data[0].deny_remarks);
        }
    });
});

var activeEmp;
var emp_on_process = true;
var emp_approved = false;


$('.admin_staff_employee_option').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tab_mainEmp1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeEmp = '#tab_mainEmp1';
        }
        else if (emp_on_process) {
            console.log('already loaded');
            activeEmp = '#tab_mainEmp1';
        }
        else if (emp_on_process == false) {
            emp_on_process = true;
            activeEmp = '#tab_mainEmp1';
        }
    }
    else if (gethref == '#tab_mainEmp2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeEmp = '#tab_mainEmp2';
        }
        else if (emp_approved) {

            console.log('already loaded');
            activeEmp = '#tab_mainEmp2';
        }
        else if (emp_approved == false) {
            emp_approved = true;
            activeEmp = '#tab_mainEmp2';
            empApproveList();

        }
    }
});




function empApproveList()
{
    $('#admin-staff-employee-list-view-approved thead th').each(function ()
    {
        tableEmpApproved[tableEmpAppCountHead] = $(this).text();
        tableEmpAppCountHead++;
        var title = $(this).text();
        $(this).html(title);
    });

    tableEmployeeApproveListAdmin = $('#admin-staff-employee-list-view-approved').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return tableEmp[(idx)];
                    }
                },
                {
                    extend: 'excel',
                    title: 'Approve Employee List',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableEmp[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Approve Employee List',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableEmp[(idx)];
                                    }
                                }
                        }
                }
            ],
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax": "admin-staff-employee-appprove-table",
        "columns":
            [
                {data : 'id', name : 'users_profile.id'},
                {data : 'name', name : 'users_profile.emp_full_name'},
                {data : 'position', name : 'users_profile.emp_position'},
                {data : 'branch', name : 'branch_list.branch_name'},
                {data : 'birth', name : 'users_profile.emp_date_birth'},
                {data : 'gender', name : 'users_profile.emp_gender'},
                {data : 'marital', name : 'users_profile.emp_marital_status'},
                {data : 'con_status', name : 'users_profile.emp_status'},
                {data : 'emp_status', name : 'users_profile.emp_process_status'},
                {data : 'hired', name : 'users_profile.emp_date_hired'},
                {data : 'end', name : 'users_profile.emp_end_date'},
                {
                    data : function action(data)
                    {
                        return '<button class = "btnViewProfile btn btn-block btn-sm btn-info" value = "'+data.id+'"><i class = "fa fa-fw fa-info-circle"></i> View Profile</button>' +
                            '<button class="btn btn-block btn-success" disabled> <i class="fa fa-fw fa-check-circle"></i> Approved</button>';
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

    $('#admin-staff-employee-list-view-approved_filter input').unbind();
    $('#admin-staff-employee-list-view-approved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableEmployeeApproveListAdmin.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableEmployeeApproveListAdmin.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin-staff-employee-list-view').on('click', '.btnViewIncomRem', function()
{
    var id = $(this).val();
    $('#show_incom_remarks').val('');

    $('#modal-incomplete-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-incomplete-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_incom_remarks').val(data[0].incomplete_remarks);
        }
    })
});

$('#admin-staff-employee-list-view').on('click', '.btnViewReturn', function()
{
    var id =  $(this).val();

    $('#show_return_remarks').val('');

    $('#modal-return-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-return-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_return_remarks').val(data[0].return_remarks);
        }
    });
});

$('#admin-staff-employee-list-view').on('click', '.btnViewProfile', function()
{
    empIDshow = $(this).val();
    countExp += 1 ;
    showExtraEmp();
    $.ajax
    ({
        type: 'get',
        url: 'human_resources_show_profile',
        data:
            {
                'empIDshow' : empIDshow
            },
        success: function(data)
        {
            console.log(data);
            $('#modal-emp-profile-view').modal('show');

            if(data[0][0].position == 'Field Verifier')
            {
                $('#ciMotorReqView').show();
                $('#officeChecklistView').hide();
                $('#ciChecklistView').show();
                $('#ciShow').show();
            }
            else
            {
                $('#ciMotorReqView').hide();
                $('#officeChecklistView').show();
                $('#ciChecklistView').hide();
                $('#ciShow').hide();
            }
            var out;

            if(data[0][0].outgoing == "")
            {
                out = "N/A";
            }
            else
            {
                out = data[0][0].outgoing;
            }

            function date_diff_indays(date1, date2) {
                var dt1 = new Date(date1);
                var dt2 = new Date(date2);
                return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
            }
            var now = new Date();
            var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
            var test1 = date_diff_indays(data[0][0].hired , now);
            var diff = contactdiff - test1 ;
            var showDiff;
            if(diff <= -1)
            {
                showDiff = 'CONTRACT EXPIRED'
            } else {
                showDiff = diff + ' days'
            }
            var pic;
            if(data[0][0].profile_pic == '')
            {
                pic = 'user_profile_pictures/default3.jpg';
            }
            else
            {
                pic = data[0][0].profile_pic;
            }

            var allowance;
            if(data[0][0].allowance == '')
            {
                allowance = 'None';
            }
            else
            {
                allowance = data[0][0].allowance
            }
            var monIn;
            if(data[6][0].emp_in == '00:00:00'){
                monIn = null;
            } else {
                monIn = data[6][0].emp_in;
            }
            var monOut;
            if(data[6][0].emp_out == '00:00:00'){
                monOut = null;
            } else {
                monOut = data[6][0].emp_out;
            }
            var tuesIn;
            if(data[7][0].emp_in == '00:00:00'){
                tuesIn = null;
            } else {
                tuesIn = data[7][0].emp_in;
            }
            var tuesOut;
            if(data[7][0].emp_out == '00:00:00'){
                tuesOut = null;
            } else {
                tuesOut = data[7][0].emp_out
            }
            var wedIn;
            if(data[8][0].emp_in == '00:00:00'){
                wedIn = null;
            } else {
                wedIn = data[8][0].emp_in ;
            }
            var wedOut;
            if(data[8][0].emp_out == '00:00:00'){
                wedOut = null;
            } else {
                wedOut = data[8][0].emp_out;
            }
            var thursIn;
            if(data[9][0].emp_in == '00:00:00'){
                thursIn = null;
            } else {
                thursIn = data[9][0].emp_in;
            }
            var thursOut;
            if(data[9][0].emp_out == '00:00:00'){
                thursOut = null;
            } else {
                thursOut = data[9][0].emp_out;
            }
            var friIn;
            if(data[10][0].emp_in == '00:00:00'){
                friIn = null;
            } else {
                friIn = data[10][0].emp_in;
            }
            var friOut;
            if(data[10][0].emp_out == '00:00:00'){
                friOut = null;
            } else {
                friOut = data[10][0].emp_out;
            }
            var satIn;
            if(data[11][0].emp_in == '00:00:00'){
                satIn = null;
            } else {
                satIn = data[11][0].emp_in;
            }
            var satOut;
            if(data[11][0].emp_out == '00:00:00'){
                satOut = null;
            } else {
                satOut = data[11][0].emp_out;
            }
            var sunIn;
            if(data[12][0].emp_in == '00:00:00'){
                sunIn = null;
            } else {
                sunIn = data[12][0].emp_in;
            }
            var sunOut;
            if(data[12][0].emp_out == '00:00:00'){
                sunOut = null;
            } else {
                sunOut = data[12][0].emp_out;
            }

            $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
            $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
            $('#emp_show_pic_me').attr('src',  pic);
            $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
            $('#emp_show_age').val(data[0][0].age);
            $('#emp_show_religion').val(data[0][0].religion);
            $('#emp_show_date_birth').val(data[0][0].date_birth);
            $('#emp_show_branch').val(data[0][0].branch);
            $('#emp_show_marital_status').val(data[0][0].marital_status);
            $('#emp_show_dependents').val(data[0][0].dependents);
            $('#emp_show_permanent').val(data[1][0].emp_address);
            $('#emp_show_present').val(data[2][0].emp_address);
            $('#emp_show_mobile').val(data[3][0].emp_contact_info);
            $('#emp_show_email').val(data[4][0].emp_contact_info);
            $('#emp_show_ss').val(data[0][0].sss);
            $('#emp_show_philhealth').val(data[0][0].philhealth);
            $('#emp_show_pagibig').val(data[0][0].pagibig);
            $('#emp_show_tin').val(data[0][0].tin);
            $('#emp_show_area').val(data[0][0].muni);
            $('#emp_show_cc').val(data[0][0].type);
            $('#emp_show_con_stat').val(data[0][0].con_stat);
            $('#emp_show_emp_status').val(data[0][0].emp_stat);
            $('#emp_show_outgoing').val(out);
            $('#emp_show_rate').val(data[0][0].rate);
            $('#emp_show_days').val(data[0][0].days + ' days');
            $('#emp_show_remaining').val(showDiff);
            $('#emp_show_allowances').val('₱ ' + allowance);
            $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
            $('#view_in1').val(monIn);
            $('#view_out1').val(monOut);
            $('#view_in2').val(tuesIn);
            $('#view_out2').val(tuesOut);
            $('#view_in3').val(wedIn);
            $('#view_out3').val(wedOut);
            $('#view_in4').val(thursIn);
            $('#view_out4').val(thursOut);
            $('#view_in5').val(friIn);
            $('#view_out5').val(friOut);
            $('#view_in6').val(satIn);
            $('#view_out6').val(satOut);
            $('#view_in7').val(sunIn);
            $('#view_out7').val(sunOut);
            $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
            $('#emp_id_stat_view').html(data[0][0].id_card);
            $('#emp_id_no_view').html(data[0][0].id_no);
            $('#emp_uni_view').html(data[0][0].uni);
            $('#emp_bank_name_view').html(data[0][0].bank_name);
            $('#emp_health_card_view').html(data[0][0].health);
            $('#emp_accident_view').html(data[0][0].accident);
            $('#emp_fb_view_me').html(data[0][0].fb);
            $('#emp_computer_view_me').html(data[0][0].com);
            $('#emp_phone_number_view').html(data[0][0].phone_no);
            $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
            $('#emp_phone_desc_view').html(data[0][0].phone_desc);
            $('#emp_oims_view').html(data[0][0].oims);
            $('#emp_gmail_view').html(data[0][0].gmail);
            $('#emp_gmail_password_view_me').html(data[0][0].gmail);
            $('#emp_fb_view').html(data[0][0].fb);
            $('#emp_computer_view').html(data[0][0].com);
            $('#emp_gmail_password').html(data[0][0].pass);

            var i;
            var check;

            $('.view_checklist').prop('checked', false);

            $('.view_checklist').each(function()
            {
                check = $(this).val();
                for(i = 0; i < data[13][0].length; i++)
                {
                    if(data[13][0][i].check_name == check)
                    {
                        $(this).prop('checked', true);
                    }
                }
            });
        }
    });
});

$(document).on('click', '.removeFileUpload', function()
{
    var id = $(this).attr('id');
    console.log(id);
    $('#row_'+id+'').remove();
});

$('#human-resources-file-format').on('click' , '.archive_file_data', function()
{
    var id = $(this).attr('id');
    var btn = $(this);
    // console.log(id);

    if(confirm('Are you sure to archive this list of uploaded files?'))
    {
        console.log(id);
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_staff_archive_general_files',
            data: {
                'id' : id
            },
            success : function(data)
            {
                console.log(data);
                if(data == 'ok')
                {
                    alert('Action successfully executed');
                    tableGeneralForms.draw();
                    tableArchivedGeneralForms.draw();
                }
            },
            complete: function()
            {
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        btn.attr('disabled', false);
    }
});

function archivedForms()
{
    $('#human-resources-file-format-archived thead th').each(function () {
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    tableArchivedGeneralForms = $('#human-resources-file-format-archived').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "admin_staff_archieved_general_forms_table",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'file_title', name: 'file_title'},
                {data: 'file_desc', name: 'file_desc'},
                {
                    data: function action(data)
                    {
                        return '<span><button class="btn btn-xs btn-danger btn-block" id="btnDownloadFormat" name="" value="' + data.id + '" ><i class = "fa fa-fw fa-download"></i>Download</button></span>' ;
                    },
                    searchable : false
                }
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();

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
    $('#human-resources-file-format-archived_filter input').unbind();
    $('#human-resources-file-format-archived_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableArchivedGeneralForms.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableArchivedGeneralForms.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.generalforms_tab').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);

    if(gethref == '#general_forms_tab1')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (tableGeneralForms_bool)
        {
            console.log('already loaded');
        }
        else if (tableGeneralForms_bool == false)
        {
            tableGeneralForms_bool = true;
        }
    }
    else if(gethref == '#general_forms_tab2')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (table_general_archived)
        {
            console.log('already loaded');
        }
        else if (table_general_archived == false)
        {
            table_general_archived = true;
            archivedForms();
        }
    }
});


$('#admin-staff-atm-uni').on('click', '.viewReq', function()
{
    empIDshow = $(this).attr('name');
    countExp += 1 ;
    showExtraEmp();
    $.ajax
    ({
        type: 'get',
        url: 'human_resources_show_profile',
        data:
            {
                'empIDshow' : empIDshow
            },
        success: function(data)
        {
            console.log(data);
            $('#modal-emp-profile-view-req').modal('show');

            if(data[0][0].profile_pic == '')
            {
                pic = 'user_profile_pictures/default3.jpg';
            }
            else
            {
                pic = data[0][0].profile_pic;
            }

            $('#nameStorage_req').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
            $('#positionStorage_req').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
            $('#emp_show_pic_me_req').attr('src',  pic);
            $('#emp_id_stat_view_req').html(data[0][0].id_card);
            $('#emp_id_no_view_req').html(data[0][0].id_no);
            $('#emp_uni_view_req').html(data[0][0].uni);
            $('#emp_bank_name_view_req').html(data[0][0].bank_name);
            $('#emp_health_card_view_req').html(data[0][0].health);
            $('#emp_accident_view_req').html(data[0][0].accident);
            $('#emp_phone_number_view_req').html(data[0][0].phone_no);
            $('#emp_unit_price_view_req').html('₱ ' + data[0][0].price);
            $('#emp_phone_desc_view_req').html(data[0][0].phone_desc);
            $('#emp_oims_view_req').html(data[0][0].oims);
            $('#emp_gmail_view_req').html(data[0][0].gmail);
            $('#emp_fb_view_req').html(data[0][0].fb);
            $('#emp_computer_view_req').html(data[0][0].com);
            $('#emp_gmail_password_req').html(data[0][0].pass);


            var i;
            var check;

            $('.view_checklist').prop('checked', false);

            $('.view_checklist').each(function()
            {
                check = $(this).val();
                for(i = 0; i < data[13][0].length; i++)
                {
                    if(data[13][0][i].check_name == check)
                    {
                        $(this).prop('checked', true);
                    }
                }
            });
        }
    });
});

function inventoryNationWide()
{
    $('#admin-staff-assets-table thead th').each(function () {
        invent[inventCount] = $(this).text();
        inventCount++;
        if($(this).text() == 'BARCODE')
        {
            $(this).html($(this).text() + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
    });

    tableAssetsNationwide = $('#admin-staff-assets-table').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return invent[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return invent[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return invent[(idx)];
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
                    extend: 'print',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return invent[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "admin_staff_nation_wide_inventory",
                data: function (d)
                {
                    d.search = assetSearch;
                    d.branchTosearch = selected_branch;
                    d.itemTosearch = selected_item;
                }
            },
        "columns":
            [
                {data: 'id', name: 'equipments.id', 'visible': false},
                {data: 'barcode', name: 'equipments.barcode', 'orderable': false},
                {data: 'eq_det', name: 'equipments.item_details_type'},
                {data: 'eq_specs', name: 'equipments.type'},
                {data: 'eq_price', name: 'equipments.item_price', 'visible': false},
                {data: 'cur_status', name: 'equipments.current_status', 'visible': false},
                {data: 'datetime', name: 'equipments.created_at'},
                {
                    data: function action(data)
                    {
                        // return '<button class="btn btn-xs btn-primary btn-block item_click_update" id="'+btoa(data.id)+'"><i class="glyphicon glyphicon-pencil" ></i>Update Status</button>' +
                           return '<button class="btn btn-xs btn-success btn-block view_item_latest_img" id="'+btoa(data.id)+'" name="'+btoa(data.barcode)+'"><i class="glyphicon glyphicon-info-sign"></i>View Full Information</button>' +
                               '<button class="btn btn-xs btn-info btn-block view_item_logs" data-toggle="modal" data-target="#modal-inventory-logs" id="'+btoa(data.id)+'"><i class="glyphicon glyphicon-list-alt"></i>View Logs</button>'
                    },
                    name: 'equipments.updated_at',
                    searchable : false
                }
            ],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {

            var api = this.api();

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

    $('#admin-staff-assets-table_filter label').hide();
    $('#admin-staff-assets-table_filter input').hide();
    $('#admin-staff-assets-table_filter input').unbind();
    $('#admin-staff-assets-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAssetsNationwide.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAssetsNationwide.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.category_assets_class').on('click', function()
{
    assetSearch = $(this).val();

    $('.nationwideInventTab').each(function()
    {
        if($(this).parent().hasClass('active'))
        {
            if($(this).attr('href') == '#inventory_tab1')
            {
                tableAssetsNationwide.draw();
            }
            else if($(this).attr('href') == '#inventory_tab2')
            {
                tableQuantity.draw();
            }
            else if($(this).attr('href') == '#inventory_tab3')
            {
                if(assetSearch == 'Branch Asset')
                {
                    $('#inventory-employee-pos').val('').trigger('change').attr('disabled', true);
                }
                else
                {
                    $('#inventory-employee-pos').attr('disabled', false);
                }
                tableAvailConditio.draw();
            }
        }
    });

    $('#eq_mon_item > option').each(function()
    {
        if(assetSearch == '')
        {
            $(this).show();
        }
        else
        {
            if($(this).attr('name') == assetSearch || $(this).attr('name') == 'Others')
            {
                $(this).show();
            }
            else
            {
                $(this).hide();
            }
        }
    });

    $('.clearThis').html('');
    $('#update_item_div').hide();
});

$('#admin-staff-assets-table, #admin-staff-availability-table').on('click', '.view_item_latest_img', function()
{
    var eqid = atob($(this).attr('id'));
    var eqbarcode = atob($(this).attr('name'));
    $('#item_update_status').attr('name', $(this).attr('id'));
    $('#update_item_div').show();
    $('#latest_pic').html('');
    $('#item-overlay').show();

    $.ajax({
        type : 'get',
        url : 'admin_get_all_latest_item_pic',
        data: {
            'id' : eqid,
            'barcode' : eqbarcode
        },
        success : function (data)
        {
            // console.log(data);
            var imagessss = '';

            if(data[1].length <= 0)
            {
                $('#latest_pic').html('<h3>NO ATTACHED PHOTOS</h3>');
            }
            else
            {
                for(var i = 0; i < data[1].length; i++)
                {
                    imagessss += '<a style="cursor: pointer" href="barcode_get_latest_pic/'+btoa(eqid)+'/'+btoa(data[1][i])+'" target="_blank" title="Click to enlarge image"><img src="barcode_get_latest_pic/'+btoa(eqid)+'/'+btoa(data[1][i])+'" alt="" class="img-thumbnail" style="width: 33%;"></a>';
                }

                $('#latest_pic').html(imagessss);
            }

            if(data[2].length <= 0)
            {

            }
            else
            {
                if(data[2][0].type == 'Employee Equipment')
                {
                    $('#item-cat').html(data[2][0].type);
                    $('#emp-id').html(data[2][0].employee_id);
                    $('#emp-position').html(data[2][0].position);
                    $('#emp-name').html(data[2][0].emp_fName);
                    $('#item-brand').html(data[2][0].item_brand);
                    $('#eq-branch').html(data[2][0].emp_branch);
                    $('#eq-price').html(data[2][0].item_price);
                    $('#eq-desc').html(data[2][0].item_description);
                    $('#eq-invoice').html(data[2][0].item_invoice_number);
                    $('#eq-cond').html(data[2][0].current_status);
                    $('#eq-status').html(data[2][0].status);
                    $('#eq-rem').html(data[2][0].remarks);
                }
                else
                {
                    $('#item-cat').html(data[2][0].type);
                    $('#emp-id').html('N/A');
                    $('#emp-position').html('N/A');
                    $('#emp-name').html('N/A');
                    $('#item-brand').html(data[2][0].item_brand);
                    $('#eq-branch').html(data[2][0].branch);
                    $('#eq-price').html(data[2][0].item_price);
                    $('#eq-desc').html(data[2][0].item_description);
                    $('#eq-invoice').html(data[2][0].item_invoice_number);
                    $('#eq-cond').html(data[2][0].current_status);
                    $('#eq-status').html(data[2][0].status);
                    $('#eq-rem').html(data[2][0].remarks);
                }

            }

        },
        complete: function(){
            $('#item-overlay').hide();
        }
    });
});

$('#item_update_status').click(function()
{
    var btn = $(this);
    var formData =  new FormData();
    var id = atob($(this).attr('name'));
    var new_status = $('#item-status').children('option:selected').val();
    var added_rem = $('#update-item-remarks').val();
    var validation = false;
    var disposer = 0;

    $('.updateVali').each(function()
    {
        if($(this).val() == '')
        {
            alert('Fill-up the required fields');
            validation = false;
            return false;
        }
        else
        {
            validation = true;
        }
    });

    $('.disposeFilesTobeUploadBulk').each(function ()
    {
        if($(this).val() != '')
        {
            formData.append('file_'+disposer+'', $(this).prop('files')[0]);
            disposer++;
        }
        else
        {
            alert('Check all the attachment if all filled');
            validation = false;
            return false;
        }
    });


    formData.append('id', id);
    formData.append('new_status', new_status);
    formData.append('added_rem', added_rem);
    formData.append('file_count', disposer);

    // console.log(formData)


    if(validation)
    {

        if(confirm('Are you sure you want to submit?'))
        {
            btn.attr('disabled', true);

            $.ajax({
                type: 'post',
                url: 'admin_staff_update_item_status',
                data: formData,
                contentType: false,
                processData: false,
                // data: {
                //     'id' : id,
                //     'new_status' : new_status,
                //     'added_rem' : added_rem
                // },
                success: function (data) {
                    console.log(data);
                },
                complete: function () {
                    btn.attr('disabled', false);
                    tableAssetsNationwide.draw();
                    $('#item-status').val('');
                    $('#update-item-remarks').val('');
                    $('#eq-rem').val(added_rem);
                    $('#eq-cond').html(new_status);
                    $('.putgreed').hide();
                    $('#dispose_attachment').hide();
                    $('.disposeFilesTobeUploadBulk').val('');
                }
            })
          }
        }
});

$('#admin-staff-assets-table, #admin-staff-availability-table').on('click', '.view_item_logs', function() {
    var id = atob($(this).attr('id'));
    $("#invent-logs").html('');
    $.ajax({
        type: 'get',
        url: 'admin_staff_get_logs_invent',
        data: {
            'id': id
        },
        success: function (data) {
            var tableData = '';
            var tablehead = '<table class="table-condensed table-hover" width="100%">\n' +
                '                            <tr style="background-color: black; color: white">\n' +
                '                                <th>USER</th>\n' +
                '                                <th>ACTIVITY</th>\n' +
                '                                <th>DATE/TIME OCCURED</th>\n' +
                '                            </tr>';

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    tableData += '<tr>' +
                        '<td>' + data[i].name + '</td>' +
                        '<td>' + data[i].act + '</td>' +
                        '<td>' + data[i].datetime + '</td>' +
                        '</tr>'
                }

                $('#invent-logs').html(tablehead + tableData + '</table>');
            }
            else {
                $('#invent-logs').html(tablehead + '<tr><td colspan="3">NO RECORDS</td></tr>' + '</table>');
            }
        }
    });
});

var testhehe = 0;
$('#btn_generate_barcodes').click(function()
{
    var to_generate = parseInt($('#barcode_count').val());

    if(!isNaN(to_generate))
    {
        if(to_generate > 60)
        {
            alert('Enter 1-60 only to generate');
        }
        else
        {
            $.ajax(
                {
                    type: 'post',
                    url: 'monitoring_generate_barcodes',
                    data: {
                        'count' : to_generate
                    },
                    beforeSend: function () {
                        $('#modal-loading').modal('show');
                    },
                    success : function (data)
                    {
                        var to_show = '';
                        for(var i = 0; i < data.length; i++)
                        {
                            to_show += '<div class="col-md-2 form-group printThis" style="float: left;">\n' +
                                '      <div style="border: 1px solid black; height: 230px; width: 210px; padding: 5px;">\n' +
                                // '      <div style="border: 1px solid black; text-align: center; padding: 5px;">\n' +
                                // '      <img src="qr-code/'+data[i]+'" width="100%" style="border: 1px solid black" id="">\n' +
                                // '      <img src="qr-code/'+data[i]+'" width="220" height="220" style="border: 1px solid black" id="">\n' +
                                '      <img src="qr-code/'+data[i]+'" width="200" height="200" style="border: 1px solid black; cursor: pointer;" class="img_barcode">\n' +
                                '      <center><small class="barcode_label">'+data[i]+'</small></center>\n' +
                                '      </div>\n' +
                                '      </div>';
                        }

                        $('#barcode_container').html(to_show);


                    },
                    complete: function ()
                    {
                        $('#modal-loading').modal('hide');
                        $('#showGeneratedQrs').show();
                        $('#showPrintQr').show();
                        testhehe = 0;
                    }
                }
            );
        }
    }
    else
    {
        alert('Check the inputted value');
    }
});

$('#barcode_count').keypress(function(event)
{
    if(event.charCode === 13)
    {
        $('#btn_generate_barcodes').click();
    }
});



$('#btn_print_barcode').click(function()
{
    window.print();
});

$('#generate_new').click(function()
{
    $('#barcode_container').html('');
    $('#showGeneratedQrs').hide();
    $('#showPrintQr').hide();
    $('#barcode_count').val('');
    testhehe = 0;
});

$('#eq_mon_branch').change(function()
{
    selected_branch = $(this).children('option:selected').val();

    $('.nationwideInventTab').each(function()
    {
        if($(this).parent().hasClass('active'))
        {
            if($(this).attr('href') == '#inventory_tab1')
            {
                tableAssetsNationwide.draw();
            }
            else if($(this).attr('href') == '#inventory_tab2')
            {
                tableQuantity.draw();
            }
            else if($(this).attr('href') == '#inventory_tab3')
            {
                tableAvailConditio.draw();
            }
        }
    });

});

$('#eq_mon_item').change(function()
{
    selected_item = $(this).children('option:selected').val();

    $('.nationwideInventTab').each(function()
    {
        if($(this).parent().hasClass('active'))
        {
            if($(this).attr('href') == '#inventory_tab1')
            {
                tableAssetsNationwide.draw();
            }
            else if($(this).attr('href') == '#inventory_tab2')
            {
                tableQuantity.draw();
            }
            else if($(this).attr('href') == '#inventory_tab3')
            {
                tableAvailConditio.draw();
            }
        }
    });

});

var inventory_bool_tab1 = true;
var inventory_bool_tab2 = false;
var inventory_bool_tab3 = false;

$('.nationwideInventTab').click(function()
{
    var gethref = $(this).attr('href');

    if (gethref == '#inventory_tab1')
    {

        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            which_is_active = 'inventory_tab1';
        }
        else if (inventory_bool_tab1)
        {
            console.log('already loaded');
            which_is_active = 'inventory_tab1';
        }
        else if (inventory_bool_tab1 == false)
        {
            inventory_bool_tab1 = true;
            which_is_active = 'inventory_tab1';
            inventoryNationWide();
        }
    }
    else if (gethref == '#inventory_tab2')
    {

        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            which_is_active = 'inventory_tab2';
        }
        else if (inventory_bool_tab2)
        {
            console.log('already loaded');
            which_is_active = 'inventory_tab2';
        }
        else if (inventory_bool_tab2 == false)
        {
            inventory_bool_tab2 = true;
            which_is_active = 'inventory_tab2';
            inventoryQuantity();
        }
    }
    else if (gethref == '#inventory_tab3')
    {

        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            which_is_active = 'inventory_tab3';
        }
        else if (inventory_bool_tab3)
        {
            console.log('already loaded');
            which_is_active = 'inventory_tab3';
        }
        else if (inventory_bool_tab3 == false)
        {
            inventory_bool_tab3 = true;
            which_is_active = 'inventory_tab3';
            availConditionTable();
        }
    }
});


function inventoryQuantity()
{
    $('#admin-staff-quantity-table thead th').each(function () {
        quantTitle[quantTitlectr] = $(this).text();
        quantTitlectr++;
    });

    tableQuantity = $('#admin-staff-quantity-table').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return invent[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return quantTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return quantTitle[(idx)];
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
                    extend: 'print',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return quantTitle[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "admin_staff_quantity_mon_table",
                data: function (d)
                {
                    d.search = assetSearch;
                    d.branch = selected_branch;
                    d.item = selected_item;
                }
            },
        "columns":
            [
                {data: 'item', name: 'equipments.item_details_type'},
                {data: 'branch', name: 'equipments.id'},
                {data: 'count', name: 'equipments.id'}
            ],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {

            $('#admin-staff-quantity-table thead th').each(function () {
                $(this).unbind();
                var asset = $(this).text();
                if(asset != 'ACTION')
                {
                    $(this).html(asset + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
            });

            var api = this.api();

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

    $('#admin-staff-quantity-table_filter label').hide();
    $('#admin-staff-quantity-table_filter input').hide();
    $('#admin-staff-quantity-table_filter input').unbind();
    $('#admin-staff-quantity-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableQuantity.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableQuantity.search($(this).val()).draw();
                }
            }
        }
    });
}


function availConditionTable()
{
    $('#admin-staff-availability-table thead th').each(function () {
        availCondititle[availCondititlectr] = $(this).text();
        availCondititlectr++;
    });

    tableAvailConditio = $('#admin-staff-availability-table').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return invent[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return availCondititle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return availCondititle[(idx)];
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
                    extend: 'print',
                    title : 'Nationwide Inventory',
                    exportOptions:
                        {
                            columns: 'th:not(:last-child)',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return availCondititle[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "admin_staff_availability_mon_table",
                data: function (d)
                {
                    d.search = assetSearch;
                    d.branch = selected_branch;
                    d.item = selected_item;
                    d.position = $('#inventory-employee-pos').children('option:selected').val();
                    d.current_status = assetCurretnStatus;
                    d.availability = assetAvailability;
                }
            },
        "columns":
            [
                {data: 'barcode', name: 'equipments.barcode'},
                {data: 'avail_status', name: 'equipment_to_user.status'},
                {data: 'current_status1', name: 'equipments.current_status'},
                {data: 'branch', name: 'emp_branch.archipelago_name'},
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-xs btn-success btn-block view_item_latest_img" id="'+btoa(data.id)+'" name="'+btoa(data.barcode)+'"><i class="glyphicon glyphicon-info-sign"></i>View Full Information</button>' +
                            '<button class="btn btn-xs btn-info btn-block view_item_logs" data-toggle="modal" data-target="#modal-inventory-logs" id="'+btoa(data.id)+'"><i class="glyphicon glyphicon-list-alt"></i>View Logs</button>';
                    }
                }
            ],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {

            $('#admin-staff-availability-table thead th').each(function () {
                $(this).unbind();
                var asset = $(this).text();
                if(asset != 'ACTION')
                {
                    $(this).html(asset + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
            });

            var api = this.api();

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

    $('#admin-staff-availability-table_filter label').hide();
    $('#admin-staff-availability-table_filter input').hide();
    $('#admin-staff-availability-table input').unbind();
    $('#admin-staff-availability-table input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAvailConditio.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAvailConditio.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#inventory-employee-pos, #inventory-current-status, #inventory-availability').change(function()
{
    assetCurretnStatus = $('#inventory-current-status').val();
    assetAvailability =$('#inventory-availability').val();


    console.log(assetCurretnStatus);


    tableAvailConditio.draw();
});

var table_item_add_and_remove;

getItemsTableToRemoveAndAdd();

function getItemsTableToRemoveAndAdd()
{
    $('#remove-item-table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    table_item_add_and_remove = $('#remove-item-table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'admin_staff_view_items_to_remove_table',
        "columns":
            [
                {data: 'item_name', name: 'item_details_admin_inventory.item_type'},
                {data: 'type', name: 'item_details_admin_inventory.type'},
                {data: 'datetime', name: 'item_details_admin_inventory.created_at'},
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-danger btn-remove-item-admin-staff" id="'+data.id+'">Remove</button>';
                    },
                    name: 'item_details_admin_inventory.id',
                    searchable:false,
                    orderable: false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 5,
        "lengthMenu" : [[5, 10, 20, -1], ['5 rows', '10 rows', '20 rows', 'Show all']]
    });

    $('#remove-item-table_filter input').unbind();
    $('#remove-item-table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                table_item_add_and_remove.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_item_add_and_remove.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#remove-item-table').on('click', '.btn-remove-item-admin-staff', function()
{
    var id = $(this).attr('id');
    var btn = $(this);

    if(confirm('Are you sure want to delete this item?'))
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_staff_delete_item_name',
            data: {
                'id' : id
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Item Successfully Deleted');
                    table_item_add_and_remove.draw();
                }
            },
            complete: function()
            {
                btn.attr('disabled', false);
            }
        });
    }
});

$('#add-this-item-to-table').click(function()
{
    var item_spec = $('#item-spec-to-add').val();
    var item_name = $('#item-name-to-add').val();
    var boolValidation = false;
    var btn = $(this);

    $('.validation-to-add').each(function()
    {
        if($(this).val() != '')
        {
            boolValidation = true;
        }
        else
        {
            boolValidation = false;
            alert('Fill-up the fields');
            return false;
        }
    });

    if(boolValidation)
    {
        if(confirm('Are you sure to add ' + item_name + ' in ' + item_spec + '?'))
        {
            btn.attr('disabled', true);

            $.ajax({
                type: 'get',
                url: 'admin_staff_add_item_to_nationwide_names',
                data: {
                    'item_spec' : item_spec,
                    'item_name' : item_name
                },
                success : function(data)
                {
                    console.log(data);
                    if(data == 'ok')
                    {
                        alert('Item Successfully Added');
                        $('#item-spec-to-add').val('');
                        $('#item-name-to-add').val('');
                        table_item_add_and_remove.draw();
                    }
                    else
                    {
                        alert('Item is already added.');
                    }
                },
                complete: function()
                {
                    btn.attr('disabled', false);
                }
            });
        }
    }
});




$('#brandItemsTable2').on('click', '.btnToAddBrand', function()
{
    brandInc1++;

    $('#addBrandTablePO').append('<tr id = "removeBrand1-'+brandInc1+'">\n' +
        '                                <td colspan="1"> <textarea class = "form-control loopPoItems" rows ="2" ></textarea></td>\n' +
        '                                <td colspan="1"><input type="number" class="form-control loopPoItems"></td>\n' +
        '                                <td colspan="1"><input type="number" class="form-control loopPoItems"></td>\n' +
        '                                <td colspan="1">   <div class="input-group input-group-sm"><input type="number" class="form-control loopPoItems">\n' +
        '                                        <span class="input-group-btn">\n' +
        '                                            <button type="button" class="btn btn-danger btn-sm btnRemoveRow" name="'+brandInc1+'">\n' +
        '                                            <i class = "fa fa-fw fa-minus"></i></button>\n' +
        '                                        </span>\n' +
        '                                    </div>\n' +
        '                                </td>\n' +
        '                            </tr>');

});

$('#brandItemsTable2').on('click', '.btnRemoveRow', function()
{
    var id = $(this).attr('name');

    $('#removeBrand1-'+id+'').remove();
});

var brand2Inc1 = 1;

$('#brandItemsTable3').on('click', '.btnToAddBrand2', function()
{
    brand2Inc++;
    brand2Inc1++;

    $('#addBrandTable2').append('<tr id = "removeBrand2-'+brand2Inc+'" name="'+brand2Inc1+'">\n' +
        '                                    <td colspan="1"><input type="number" class="form-control ToLoopAcno ar_inputs" href="'+brandInc+'" name="item_quantity"></td>\n' +
        '                                    <td colspan="1"><textarea class = "form-control ToLoopAcno ar_inputs" rows ="2" href="'+brandInc+'" name="brand_desc"></textarea></td>\n' +
        '                                    <td colspan="1"><div class="input-group input-group-sm"><input type="text" class="form-control ToLoopAcno ar_inputs" href="'+brandInc+'" name="warranty_period">\n' +
        '                                            <span class="input-group-btn">\n' +
        '                                                <button type="button" class="btn btn-danger btn-sm btnRemoveAr" name = "'+brand2Inc+'">\n' +
        '                                                <i class = "fa fa-fw fa-minus"></i></button></span></div>\n' +
        '                                    </td>\n' +
        '                                </tr>')
});

$('#brandItemsTable3').on('click', '.btnRemoveAr', function()
{
    var id = $(this).attr('name');

    $('#removeBrand2-'+id+'').remove();
});



function eqMonitReqTable()
{
    $('#admin_staff_requisition_monit thead th').each(function()
    {
        requi_table[r_1] = $(this).text();
        r_1++;
    });
    tableMonitRequi = $('#admin_staff_requisition_monit').DataTable({

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
                                        return requi_table[(idx)];
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
                        return requi_table[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-requi-table",
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
                        return '<button class = "btn btn-md btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button>';
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

    $('#admin_staff_requisition_monit_filter input').unbind();
    $('#admin_staff_requisition_monit_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi.search($(this).val()).draw();
                }
            }
        }
    });
}

function eqMonitReqTable2()
{
    $('#admin_staff_requisition_monit_approved thead th').each(function()
    {
        requi_table_2[r_2] = $(this).text();
        r_2++;
    });
    tableMonitRequi2 = $('#admin_staff_requisition_monit_approved').DataTable({

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
                                        return requi_table_2[(idx)];
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
                        return requi_table_2[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-requi-table-approved",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'send_name', name: 'users.name'},
                {data: 'dor', name: 'admin_requisition.date_request'},
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {data: 'admin_name', name: 'admin_id.name'},
                {
                    data: function btn(data)
                    {
                        return '<button class = "btn btn-md btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button>';
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

    $('#admin_staff_requisition_monit_approved_filter input').unbind();
    $('#admin_staff_requisition_monit_approved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi2.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin_staff_requisition_monit_denied').on('click', '.btnDenyRemarks', function()
{
    $('#view_admin_date_rem_requi').val('');
    $('#view_admin_denial_remarks').val('');

    var rem = $(this).attr('rem')
    var dt = $(this).attr('dt');

    $('#view_admin_date_rem_requi').val(dt);
    $('#view_admin_denial_remarks').val(rem);

    $('#modal_view_denial_requi_rem').modal('show');

});

function eqMonitReqTable3()
{
    $('#admin_staff_requisition_monit_denied thead th').each(function()
    {
        requi_table_3[r_3] = $(this).text();
        r_3++;
    });
    tableMonitRequi3 = $('#admin_staff_requisition_monit_denied').DataTable({

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
                                        return requi_table_3[(idx)];
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
                        return requi_table_3[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-requi-table-denied",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'send_name', name: 'users.name'},
                {data: 'dor', name: 'admin_requisition.date_request'},
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {data: 'admin_name', name: 'admin_id.name'},
                {
                    data: function btn(data)
                    {
                        return '<button class = "btn btn-md btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button>' +
                            '<button class = "btn btn-md btn-warning btn-block btnDenyRemarks" name = "'+data.id+'" rem = "'+data.rem+'" dt = "'+data.dtDenied+'"><i class="fa fa-fw fa-sticky-note"></i> View Remarks</button>';
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

    $('#admin_staff_requisition_monit_denied_filter input').unbind();
    $('#admin_staff_requisition_monit_denied_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi3.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi3.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin_staff_requisition_monit').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');


    $('.toClear').val('');
    $('.requiListview').removeAttr('checked');
    $('#showApprovedReject').show();


    viewReqModal(id, 'app')
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

$('#approveRequestReq').click(function()
{
    $('#approveNowRequisition').attr('name', btoa($(this).attr('name')));
    $('#modal-approve-requi-capex-opex').modal('show');
});

$('.admin_staff_requi_monit_class').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tabRequi_1') {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain = '#tabRequi_1';
        }
        else if (requi_monit_bool_1)
        {
            console.log('already loaded');
            activeMain = '#tabRequi_1';
        }
        else if (requi_monit_bool_1 == false)
        {
            requi_monit_bool_1 = true;
            activeMain = '#tabRequi_1';
        }
    }
    else if (gethref == '#tabRequi_2')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain = '#tabRequi_2';
        }
        else if (requi_monit_bool_2)
        {

            if(tab2Moniq == true)
            {
                tableMonitRequi2.ajax.reload(null, false);
                tab2Moniq = false;
            }
            else
            {
                console.log('already loaded');
            }
            activeMain = '#tabRequi_2';
        }
        else if (requi_monit_bool_2 == false)
        {
            requi_monit_bool_2 = true;
            activeMain = '#tabRequi_2';
            eqMonitReqTable2();
        }
    }
    else if (gethref == '#tabRequi_3')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain = '#tabRequi_3';
        }
        else if (requi_monit_bool_3)
        {
            if(tab3Moniq == true)
            {
                tableMonitRequi3.ajax.reload(null, false);
                tab3Moniq = false;
            }
            else
            {
                console.log('already loaded');
            }
            activeMain = '#tabRequi_3';
        }
        else if (requi_monit_bool_3 == false)
        {
            requi_monit_bool_3 = true;
            activeMain = '#tabRequi_3';
            eqMonitReqTable3()
        }
    }
});

$('#admin_staff_requisition_monit_approved').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');

    $('.toClear').val('');
    $('.requiListview').removeAttr('checked');
    $('#showApprovedReject').hide();

    viewReqModal(id , 'app');
});

$('#admin_staff_requisition_monit_denied').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');

    $('.toClear').val('');
    $('.requiListview').removeAttr('checked');
    $('#showApprovedReject').hide();

    viewReqModal(id, 'app');
});

$('#rejectRequestReq').click(function()
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
        $.ajax
        ({
            'type' : 'get',
            'url' : 'admin-staff-deny-requi',
            data :
                {
                    'id' : id,
                    'remarks' : remarks
                },
            success : function()
            {
                alert('Successfully denied the request!');
                $('.toClear').val('');
                $('.requiListview').removeAttr('checked');
                $('#showApprovedReject').hide();
                tableMonitRequi.ajax.reload(null, false);

                $('#appBrandview').html(' <tr>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
                    '                                            </th>\n' +
                    '                            </tr>');

                btn.attr('disabled', false);
                tab3Moniq = true;
                procGenRequiBool = true;
            }
        });
    }
});



$('#addAttachAccred').click(function()
{
    $('#storageOfFileSup').append('<div class = "row" style = "padding-top : 10px;" id = "rowtoRemoveFile-'+accr_files_count+'">\n' +
        '                                            <div class="col-md-6">\n' +
        '                                                <span><input type="file" class ="file_accred_sup"></span>\n' +
        '                                            </div> ' +
        '                                            <div class="col-md-6"><button class="btn btn-danger btn-xs removeRowFileAccred " name = "'+accr_files_count+'"><i class="fa fa-fw fa-close"></i></button></div>\n' +
        '                                        </div>');

    accr_files_count++;

    deleteAccredRow();
});

function deleteAccredRow()
{
    $('.removeRowFileAccred').click(function()
    {
        var id = $(this).attr('name');
        $('#rowtoRemoveFile-'+id+'').remove();
    });
}

$('#saveAccreditedSupplier').click(function()
{
    var btn = $(this);

    var accred_supp_name = $('#accred_supp_name').val();
    var accred_supp_con_num = $('#accred_supp_con_num').val();
    var accred_supp_address = $('#accred_supp_address').val();
    var accred_sup_contact_person = $('#accred_sup_contact_person').val();
    var accred_sup_email = $('#accred_sup_email').val();
    var accred_sup_email_subj = $('#accred_sup_email_subj').val();
    var accred_sup_date_bi = $('#accred_sup_date_bi').val();
    var accred_sup_bir = $('#accred_sup_bir').val();
    var accred_sup_tin = $('#accred_sup_tin').val();
    var accred_sup_tor = $('#accred_sup_tor').find(':selected').val();
    var accred_sup_categorization = $('#accred_sup_categorization').find(':selected').val();
    var accred_sup_descrip = $('#accred_sup_descrip').val();
    // var accred_sup_terms = $('#accred_sup_terms').val();
    var accred_sup_proposal = $('#accred_sup_proposal').val();
    var accred_sup_results = $('#accred_sup_results').val();
    var countFiles = 0;
    var formdata = new FormData;
    var checkifNewCateg;
    var checkSaveEdit;
    var storeTerms = [];
    var requestEncode = $('#encodingTypeSup').find(':selected').val();
    var accred_sup_discounts = $('#accred_sup_discounts').val();

    btn.attr('disabled', true);

    if($('#existingCategory').is(':checked'))
    {
        supplierCat = $('#selectedCategory').find(':selected').val();
        checkifNewCateg = 'old';
    }
    else if($('#newCategory').is(':checked'))
    {
        supplierCat = $('#newInputCategory').val();
        checkifNewCateg = 'new';
    }
    else
    {
        supplierCat = 'x';
    }

    if(typeof($('#saveAccreditedSupplier').attr('self')) === 'string')
    {
        checkSaveEdit = atob(btn.attr('self').split('|-|-|')[0]);
    }
    else
    {
        checkSaveEdit = 'new';
    }

    countFiles = 0;

    $('.tOpaymentSup').each(function()
    {
        storeTerms.push($(this).val());
    });

    var stringiTerms = JSON.stringify(storeTerms);




    if(supplierCat == 'x')
    {
        alert('Please select type of category');
        btn.attr('disabled', false);
    }
    else
    {
        formdata.append('id', checkSaveEdit);
        formdata.append('supplierCat', supplierCat);
        formdata.append('accred_supp_name', accred_supp_name);
        formdata.append('accred_supp_con_num', accred_supp_con_num);
        formdata.append('accred_supp_address', accred_supp_address);
        formdata.append('accred_sup_contact_person', accred_sup_contact_person);
        formdata.append('accred_sup_email', accred_sup_email);
        formdata.append('accred_sup_email_subj', accred_sup_email_subj);
        formdata.append('accred_sup_date_bi', accred_sup_date_bi);
        formdata.append('accred_sup_bir', accred_sup_bir);
        formdata.append('accred_sup_tin', accred_sup_tin);
        formdata.append('accred_sup_tor', accred_sup_tor);
        formdata.append('accred_sup_categorization', accred_sup_categorization);
        formdata.append('accred_sup_descrip', accred_sup_descrip);
        formdata.append('accred_sup_proposal', accred_sup_proposal);
        formdata.append('accred_sup_results', accred_sup_results);
        formdata.append('checkifNewCateg', checkifNewCateg);
        formdata.append('storeTerms', stringiTerms);
        formdata.append('requestEncode', requestEncode);
        formdata.append('accred_sup_discounts', accred_sup_discounts);

        $('.file_accred_sup').each(function()
        {
            if($(this).val() != '')
            {
                formdata.append('file-'+countFiles+'', $(this).prop('files')[0]);
                countFiles++;
            }
        });

        if(checkSaveEdit == 'new')
        {
            if(storeTerms.length > 0)
            {
                if(countFiles > 0)
                {
                    formdata.append('countFiles', countFiles);
                    insertEditAccredSup(formdata, btn);
                }
                else
                {
                    alert('Please select file/s');
                    btn.attr('disabled', false);
                }
            }
            else if(storeTerms.length = 0)
            {
                alert('Please add terms of payment.');
                btn.attr('disabled', false);
            }
        }
        else
        {
            formdata.append('countFiles', countFiles);
            insertEditAccredSup(formdata, btn);
        }
    }
});

function insertEditAccredSup(form, btn)
{
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
                    $('#ulPercentage_acc_supp').html('');
                    $('#ulPercentage_acc_supp').show();
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_acc_supp').append(Math.floor(percentComplete*100));
                    $('#progressbar_acc_supp').show();
                    $('#progressbar_acc_supp').progressbar
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
        url : 'admin-staff-submit-accred-sup',
        contentType: false,
        processData: false,
        async : true,
        data : form,
        beforeSend : function()
        {
            $('#modal-loading-accredited-supplier').modal({backdrop: "static"});
        },
        success : function()
        {
            $('#accredited_sup_file_table_holder').hide();
            $('#editAccreditedSupplier').hide();
        },
        complete : function()
        {
            $('#modal-loading-accredited-supplier').modal('hide');

            setTimeout(function()
            {
                $('#modal-success-accredited').modal('show');
            }, 1000);

            accr_files_count = 0;
            $('#storageOfFileSup').html('');
            $('.categoryChooseclass').removeAttr('checked');
            // $('#formCategory').html('');
            $('.toClearSup').val('');
            btn.attr('disabled', false);
            tableAccSup.ajax.reload(null, false);
            $('#showInputCateg').hide();
            $('#showSelectCateg').hide();
            $('#termPaymentsupSpan').html('');
            $('#encodingTypeSup').attr('disabled', false);
            btn.removeAttr('self');
            termsSupCount = 0;
            contentCateg();
            checkSupOpen1 = true;
        }
    })
}

function accSuppTable()
{
    $('#admin-staff-acc-sup-table thead th').each(function()
    {
        titleAccSup[sup_count] = $(this).text();
        sup_count++;
    });
    tableAccSup = $('#admin-staff-acc-sup-table').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleAccSup[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-accred-sup-table",
        "columns":
            [
                {data: 'id', name: 'admin_accredited_suppliers.id'},
                {data: 'created_at', name: 'admin_accredited_suppliers.created_at'},
                {data: 'category', name: 'admin_accredited_suppliers.category'},
                {data: 'supp_name', name: 'admin_accredited_suppliers.supp_name'},
                {data: 'contact_person', name: 'admin_accredited_suppliers.contact_person'},
                {

                    data : function act(data)
                    {
                        return '<button class = "btn btn-xs btn-info btn-block viewInforAccred" name = "'+data.id+'"><i class = "fa fa-fw fa-info"></i> View Info</button>' ;
                            // '<button class = "btn btn-xs btn-danger btn-block deleteAccredSup" name = "'+data.id+'"><i class = "fa fa-fw fa-trash-o"></i> Archive</button>'
                    },
                    name : 'admin_accredited_suppliers.id',
                    'searchable' : false,
                    'orderable' : false
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

    // $('#admin-staff-acc-sup-table tbody').on('click', 'tr', function ()
    // {
    //     $(this).toggleClass('selected');
    // });

    $('#admin-staff-acc-sup-table_filter input').unbind();
    $('#admin-staff-acc-sup-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAccSup.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAccSup.search($(this).val()).draw();
                }
            }
        }
    });
}



$('#admin-staff-acc-sup-table').on('click', '.viewInforAccred', function()
{
    var id = $(this).attr('name');
    $('#editAccreditedSupplier').text('Edit');
    $('#editAccreditedSupplier').removeClass('btn-danger');
    $('#editAccreditedSupplier').addClass('btn-warning');
    $('#showInputCateg').hide();
    $('#newCategory').prop('checked', false);
    $('#showSelectCateg').show();
    $('#existingCategory').prop('checked', false);
    $('.categoryChooseclass').attr('disabled', true)
    $('#hideSubmitIfNotEdit').hide();
    getAccredDataIndiv(id);
    $('#saveAccreditedSupplier').attr('self', btoa(id) + '|-|-|edit');
});

function getAccredDataIndiv(id)
{
    $.ajax
    ({
        'type' : 'get',
        'url' : 'admin-staff-get-indiv-accred',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            var tableHead = '<tr style="background-color: black; color:white">' +
                '<td>File Name/s</td>' +
                '</tr>';
            $('#accredited_sup_file_table').html('');

            $('#selectedCategory').val((data[0][0].category).toUpperCase());
            $('#accred_supp_name').val(data[0][0].supp_name);
            $('#accred_supp_con_num').val(data[0][0].con_num);
            $('#accred_supp_address').val(data[0][0].supp_address);
            $('#accred_sup_contact_person').val(data[0][0].contact_person);
            $('#accred_sup_email').val(data[0][0].sup_email);
            $('#accred_sup_email_subj').val(data[0][0].email_subj);
            $('#accred_sup_date_bi').val(data[0][0].date_bi);
            $('#accred_sup_bir').val(data[0][0].sup_bir);
            $('#accred_sup_tin').val(data[0][0].sup_tin);
            $('#accred_sup_tor').val(data[0][0].sup_tor);
            $('#accred_sup_categorization').val(data[0][0].sup_categorization);
            $('#accred_sup_descrip').val(data[0][0].sup_descrip);
            $('#accred_sup_proposal').val(data[0][0].sup_proposal);
            $('#accred_sup_results').val(data[0][0].sup_results);
            $('#accred_sup_discounts').val(data[0][0].other_info_sup);

            if(data[0][0].approval_status != 'Pending')
            {
                $('#encodingTypeSup').val('Existing').attr('disabled', true)
            }
            else if(data[0][0].approval_status == 'Pending')
            {
                $('#encodingTypeSup').val('New').attr('disabled', true)
            }


            console.log(data);

            if(data[1].length > 0)
            {
                for(var file = 0; file < data[1].length; file++)
                {
                    tableHead += '<tr>' +
                        '<td><a target="_blank" href="view-accredited-sup-file?id='+btoa(data[1][file].supplier_id)+'&n='+btoa(data[1][file].file_name)+'" name="'+data[1][file].supplier_id+'" title="Click the file name to download">'+data[1][file].file_name+'</a></td>' +
                        '</tr>';
                }
            }
            else
            {
                tableHead += '<tr>' +
                    '<td><b>No Uploaded File.</b></td>' +
                    '</tr>';
            }

            termsSupCount = 0;

            $('#multipTermsSup').hide();
            $('#termPaymentsupSpan').html('');

            if(data[2].length > 0)
            {
                for(var o = 0; o < data[2].length; o++)
                {
                    $('#termPaymentsupSpan').append(' <div class ="row"  style = "padding-top : 10px;" id = "removeRowSupTerm-'+termsSupCount+'">\n' +
                    '                                                            <div class = "col-md-10">\n' +
                    '                                                                <input type="text" class = "form-control toClearSup tOpaymentSup" value ="'+data[2][o].supp_term+'" disabled>\n' +
                    '                                                            </div>\n' +
                    '                                                            <div class="col-md-2">\n' +
                    '                                                                <span class = "showHideTerms" hidden><button class="btn btn-danger btn-xs pull-left deleteSupTerms"  style="margin-top : 5px;" name = "'+termsSupCount+'" ><i class="fa fa-fw fa-close"></i></button></span>\n' +
                    '                                                            </div>\n' +
                    '                                                        </div>');

                    termsSupCount++;
                }
            }

            $('#accredited_sup_file_table_holder').show();
            $('#addAttachmentSupHolder').hide();
            $('#accredited_sup_file_table').append(tableHead);
            $('#editAccreditedSupplier').show();

            $('.deleteSupTerms').click(function()
            {
                var id = $(this).attr('name');

                $('#removeRowSupTerm-'+id+'').remove();
            });
        },
        complete: function()
        {
            $('.toClearSup').attr('disabled', true);
            $('.toDisSelect').attr('disabled', true);

        }
    })
}

function contentCateg()
{
    $.ajax
    ({
        type: 'get',
        url: 'admin-staff-get-category',
        success: function(data)
        {
            console.log(data);
            var i ;
            var existingCategory = '';

            for (i = 0; i < data.length; i++)
            {
                existingCategory += '<option value="' + data[i].category_name + '">' + data[i].category_name + '</option>';
            }
            $('#selectedCategory').html(existingCategory);

        }
    });
}

// $('.categoryChooseclass').click(function()
// {
//     var currentSelected = '';
//     $(this).each(function()
//     {
//         if($(this).is(':checked'))
//         {
//             currentSelected = $(this).val();
//         }
//     });
//
//     if(currentSelected == 'newCategory')
//     {
//         $('.toClear').attr('disabled', false);
//         $('.toClear').val('');
//         $('#editAccreditedSupplier').hide();
//         $('#accredited_sup_file_table').html('');
//         $('#addAttachmentSupHolder').show();
//         $('#accredited_sup_file_table_holder').hide();
//         $('#saveAccreditedSupplier').removeAttr('self');
//     }
// });

$('#editAccreditedSupplier').click(function()
{
    var $thisText = $(this).text();
    var prependCtr = 0;

    if($thisText == 'Edit')
    {
        $('.toClearSup').attr('disabled', false);
        $('.toDisSelect').attr('disabled', false);
        $('.categoryChooseclass').attr('disabled', false);
        $(this).text('Cancel Edit');
        $('#addAttachmentSupHolder').show();
        $(this).removeClass('btn-warning');
        $(this).addClass('btn-danger');
        $('#existingCategory').click();
        $('#multipTermsSup').show();
        $('.showHideTerms').show();
        $('#hideSubmitIfNotEdit').show();


        $('#accredited_sup_file_table tbody tr').each(function()
        {
            if(prependCtr == 0)
            {
                $(this).prepend('' +
                    '<td>' +
                    'Action' +
                    '</td>' +
                    '');
            }
            else
            {
                $(this).prepend('<td>' +
                    '<a class="btn btn-danger btn-sm deleteSupFile" id="'+$(this).children('td').children('a').attr('name')+'" name="'+$(this).children('td').children('a').text()+'" title="Click to delete this file"><i class="glyphicon glyphicon-trash"></i></a>' +
                    '</td>');
            }
            prependCtr++;
        });
    }
    else
    {
        $('.toClearSup').attr('disabled', true);
        $('.toDisSelect').attr('disabled', true);
        $('.categoryChooseclass').attr('disabled', true);
        $(this).text('Edit');
        $('#addAttachmentSupHolder').hide();
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-warning');
        $('#multipTermsSup').hide();
        $('.showHideTerms').hide();
        $('#hideSubmitIfNotEdit').hide();

        $('#accredited_sup_file_table tbody tr').each(function()
        {
            $(this).children(':first-child').remove();
        });
    }
});

$('#accredited_sup_file_table').on('click', '.deleteSupFile', (function()
{
    var btn = $(this);
    var id = $(this).attr('id');
    var name = $(this).attr('name');
    var toRemove = $(this).closest('tr');
    if(confirm('Are you sure to delete ' + name + '?'))
    {
        btn.attr('disabled', true);
        $.ajax({
            type: 'get',
            url: 'admin_staff_remove_selected_supplier_file',
            data: {
                'id' : id,
                'name' : name
            },
            success: function(data)
            {
                alert('File Successfully Deleted');
                toRemove.remove();
                btn.attr('disabled', false);
            },
            error: function(e)
            {
                console.log(e);
                alert('Error occured please seek assistance of the web devs.');
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        // console.log('do nothing');
    }
}));

$('#clearFieldsRequiApp').click(function()
{
    if(confirm('Are you sure to clear fields?'))
    {
        $('.toClear').val('');
        $('.requiListview').removeAttr('checked');
        $('#showApprovedReject').hide();
        $('#appBrandview').html(' <tr>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
            '                                            </th>\n' +
            '                            </tr>');

        $('#approveRequestReq').removeAttr('name');
        $('#rejectRequestReq').removeAttr('name');
    }
    else
    {

    }
});

$('#clearFieldsAccredSupp').click(function()
{
    if(confirm('Are you sure to clear fields?'))
    {
        accr_files_count = 0;
        $('#storageOfFileSup').html('');
        $('.categoryChooseclass').removeAttr('checked');
        // $('#formCategory').html('');
        $('.toClearSup').val('');
        $('.toClearSup').attr('disabled', false);
        $('#showInputCateg').hide();
        $('#showSelectCateg').hide();
        $('.categoryChooseclass').attr('disabled', false);
        $('.toDisSelect').attr('disabled', false);
        $('#accredited_sup_file_table_holder').hide();
        $('#accredited_sup_file_table').html('');
        $('#addAttachmentSupHolder').show();
        $('#editAccreditedSupplier').css('display', 'none');
        $('#saveAccreditedSupplier').removeAttr('self');
        $('#multipTermsSup').show();
        $('.showHideTerms').show();
        $('#termPaymentsupSpan').html('');
        $('#encodingTypeSup').attr('disabled', false);
        $('#hideSubmitIfNotEdit').show();
        termsSupCount = 0;
    }
    else
    {

    }
});

$('#categRequi').change(function()
{
    if($(this).find(':selected').val() == 'OPEX')
    {
        $('#showHideRequiring').show();
        $('#showHideCapex').hide();

    }
    else if($(this).find(':selected').val() == 'CAPEX')
    {
        $('#showHideRequiring').hide();
        $('#showHideCapex').show();
    }
    else
    {
        $('#showHideRequiring').hide();
        $('#showHideCapex').hide();
    }

    $('#showHideOthersRequi').hide();
    $('#othersInputRequi').val('');
});

$('#requiringBillsRequi').change(function()
{
    if($(this).find(':selected').val() == 'Utilities')
    {
        $('#showIfUtil').show();
        $('#showIfOffice').hide();
        $('#showIfMaintenance').hide();
    }
    else if($(this).find(':selected').val() == 'Office Supplies')
    {
        $('#showIfUtil').hide();
        $('#showIfOffice').show();
        $('#showIfMaintenance').hide();
    }
    else if($(this).find(':selected').val() == 'Maintenance')
    {
        $('#showIfUtil').hide();
        $('#showIfOffice').hide();
        $('#showIfMaintenance').show();
    }

    $('#showHideOthersRequi').hide();
    $('#othersInputRequi').val('');
});

$('#typeOfCapex').change(function()
{
    if($(this).find(':selected').val() == 'Equipment')
    {
        $('#showIfEquiqmentCapex').show();
        $('#showIfEventCapex').hide();
        $('#showIfEventOptionalCapex').hide();
    }
    else if($(this).find(':selected').val() == 'Event')
    {
        $('#showIfEquiqmentCapex').hide();
        $('#showIfEventCapex ').show();
        $('#showIfEventOptionalCapex').hide();
    }
    else if($(this).find(':selected').val() == 'Event Optional')
    {
        $('#showIfEquiqmentCapex').hide();
        $('#showIfEventCapex ').hide();
        $('#showIfEventOptionalCapex').show();
    }
    else if($(this).find(':selected').val() == 'Office Space')
    {
        $('#showIfEquiqmentCapex').hide();
        $('#showIfEventCapex ').hide();
        $('#showIfEventOptionalCapex').hide();
    }

    $('#showHideOthersRequi').hide();
    $('#othersInputRequi').val('');
});

$('.othersRequi').change(function()
{
    if($(this).find(':selected').val() == 'Others')
    {
        $('#showHideOthersRequi').show();
    }
    else
    {
        $('#showHideOthersRequi').hide();
        $('#othersInputRequi').val('');
    }
});

$('#approveNowRequisition').click(function()
{
    var btn = $(this);

    var id = atob(btn.attr('name'));
    var tor = $('#torRequi').find(':selected').val();
    var categ = $('#categRequi').find(':selected').val();
    var reqBills = $('#requiringBillsRequi').find(':selected').val();
    var reqBillsUnder1 = $('#typeOfUtilRequi').find(':selected').val();
    var reqBillsUnder2 = $('#typeOfOfficeSup').find(':selected').val();
    var reqBillsUnder3 = $('#typeOfMainten').find(':selected').val();
    var typeCap = $('#typeOfCapex').find(':selected').val();
    var typeCapUnder1 = $('#typeOfEquipCapex').find(':selected').val();
    var typeCapUnder2 = $('#typeOfEventCapex').find(':selected').val();
    var typeCapUnder3 = $('#typeOfEventOptionalCapex').find(':selected').val();
    var others = $('#othersInputRequi').val();
    var type_1;
    var type_2;
    var otherBool = false;
    var remarks = $('#remarksRequi').val();

    if(categ == '-')
    {
        alert('Please select a categorization');
    }
    else
    {
        if(categ == 'OPEX')
        {
            type_1 = reqBills;

            if(reqBills == 'Utilities')
            {
                type_2 = reqBillsUnder1;

                if(reqBillsUnder1 == 'Others')
                {
                    otherBool = true;
                }

            }
            else if(reqBills == 'Office Supplies')
            {
                type_2 = reqBillsUnder2;

                if(reqBillsUnder2 == 'Others')
                {
                    otherBool = true;
                }
            }
            else if(reqBills == 'Maintenance')
            {
                type_2 = reqBillsUnder3;

                if(reqBillsUnder3 == 'Others')
                {
                    otherBool = true;
                }
            }
        }
        else if(categ == 'CAPEX')
        {
            type_1 = typeCap;

            if(typeCap == 'Equipment')
            {
                type_2 = typeCapUnder1;

                if(typeCapUnder1 == 'Others')
                {
                    otherBool = true;
                }
            }
            else if(typeCap == 'Event')
            {
                type_2 = typeCapUnder2;

                if(typeCapUnder2 == 'Others')
                {
                    otherBool = true;
                }
            }
            else if(typeCap == 'Event Optional')
            {
                type_2 = typeCapUnder3;

                if(typeCapUnder3 == 'Others')
                {
                    otherBool = true;
                }
            }
            else if(typeCap == 'Office Space')
            {
                type_2 = '';
            }
        }

        if((otherBool == false && others == '') || (otherBool == true && others != ''))
        {
            if(confirm('Are you sure to approve the request?'))
            {
                btn.attr('disabled', true);

                $.ajax
                ({
                    'type' : 'get',
                    'url' : 'admin_staff_approve_requi',
                    data :
                        {
                            'id' : id,
                            'tor' : tor,
                            'categ' : categ,
                            'type_1' : type_1,
                            'type_2' : type_2,
                            'others' : others,
                            'remarks' : remarks
                        },
                    success : function()
                    {
                        alert('Successfully Approved Request!');
                        $('#modal-approve-requi-capex-opex').modal('hide');
                        $('.toClear').val('');
                        $('.requiListview').removeAttr('checked');
                        $('#showHideRequiring').hide();
                        $('#showHideCapex').hide();
                        $('#categRequi').find(':selected').val('-');
                        $('#othersInputRequi').val('');
                        $('#remarksRequi').val('');

                        $('#showApprovedReject').hide();
                        tableMonitRequi.ajax.reload(null, false);

                        $('#appBrandview').html(' <tr>\n' +
                            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
                            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
                            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
                            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
                            '                                            </th>\n' +
                            '                            </tr>');

                        tab2Moniq = true;
                        tabProcEqLeft = true;
                        procGenRequiBool = true;

                        tableAdminAssignLogs.ajax.reload(null, false);
                        btn.attr('disabled', false);
                    }
                })
            }
            else
            {

            }
        }
        else if(otherBool == true && others == '')
        {
            alert('Please indicate other type.');
            btn.attr('disabled', false);
        }


    }
});


$('#admin_staff_eq_process').on('click', '.btnMakePOEqProc', function()
{
    var id = atob($(this).attr('name'));

    if(poBool == false)
    {
        $('#showCreatePO-'+id+'').hide();
        $('#showCancelPO-'+id+'').show();
        poBool = true;
        $('#submitPORequi').attr('name', $(this).attr('name'));
        $('#showHideSubmitPO').show();
        $(this).closest('tr').css('background-color', 'lightblue')

        $('#showToCreatePO').show();
        $('#showToViewPO').hide();
    }
    else
    {
        alert('Ongoing creation of P.O. Please cancel first the selected requisition');
    }
});

$('#admin_staff_eq_process').on('click', '.btnCancelPOEqProc', function()
{
    var id = atob($(this).attr('name'));

    $('#showCreatePO-'+id+'').show();
    $('#showCancelPO-'+id+'').hide();

    $('#submitPORequi').attr('name', '');
    $('#showHideSubmitPO').hide();
    $(this).closest('tr').css('background-color', 'white');

    poBool = false;
});

function eqProcessTable()
{
    $('#admin_staff_eq_process thead th').each(function()
    {
        eq_process_table[eq_pr] = $(this).text();
        eq_pr++;
    });
    tableProcssEq = $('#admin_staff_eq_process').DataTable
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
                                        return eq_process_table[(idx)];
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
                        return eq_process_table[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin_staff_eq_proc_table",
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
                        return '<button class="btn btn-md btn-block btn-primary btnViewInfoEqProc" name = "'+btoa(data.id)+'"> View Info</button>' +
                            '<button class="btn btn-md btn-block btn-info btnViewApprover" name = "'+btoa(data.id)+'" rem = "'+data.rem+'"> View Remarks</button>' +
                            '<span id = "showCreatePO-'+data.id+'" class="hideAllCreate"><button class="btn btn-md btn-block btn-success btnMakePOEqProc" name = "'+btoa(data.id)+'" style = "margin-top : 5px;"> Create P.O</button></span>' +
                            '<span id = "showCancelPO-'+data.id+'" class="hideAllCancel" hidden><button class="btn btn-md btn-block btn-warning btnCancelPOEqProc" name = "'+btoa(data.id)+'" style = "margin-top : 5px;"> Cancel</button></span>'
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

    $('#admin_staff_eq_process_filter input').unbind();
    $('#admin_staff_eq_process_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProcssEq.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProcssEq.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin_staff_eq_process').on('click', '.btnViewInfoEqProc', function()
{
    var id = atob($(this).attr('name'));
    $('.toClear').val('').attr('disabled', true);
    $('.toDisable').attr('disabled', true);
    $('.requiList').attr('disabled', true);

    $('#showHideSendRequestRequi').hide();

    viewReqModal(id, 'proc');

    $('#modal-requisition_form').modal('show');
});

$('#multipTermsSup').click(function()
{
    $('#termPaymentsupSpan').append(' <div class ="row"  style = "padding-top : 10px;" id = "removeRowSupTerm-'+termsSupCount+'">\n' +
        '                                                            <div class = "col-md-10">\n' +
        '                                                                <input type="text" class = "form-control toClearSup tOpaymentSup">\n' +
        '                                                            </div>\n' +
        '                                                            <div class="col-md-2">\n' +
        '                                                                 <span class = "showHideTerms"><button class="btn btn-danger btn-xs pull-left deleteSupTerms" style="margin-top : 5px;" name = "'+termsSupCount+'" ><i class="fa fa-fw fa-close"></i></button></span>\n' +
        '                                                            </div>\n' +
        '                                                        </div>');

    termsSupCount++;

    $('.deleteSupTerms').click(function()
    {
        var id = $(this).attr('name');

        $('#removeRowSupTerm-'+id+'').remove();
    });
});

function suppListToPO()
{
    $.ajax
    ({
        type : 'get',
        url : 'admin-staff-sup-list-for-po',
        success : function(data)
        {
            var options = '<option value = "-">-</option>';

            for(var t = 0; t < data.length; t++)
            {
                options += '<option value = "'+data[t].id+'">'+data[t].supp_name+'</option>'
            }

            $('#selectSupForPO').html(options);
        }
    })
}

$('#tablePOFormFill').on('change', '#selectSupForPO', function()
{
    var id = $(this).find(':selected').val();

    if(id == '-')
    {
        $('.toClearPO').val('');
        $('#termsSupForPO').html('').attr('disabled', true);
    }
    else
    {
        $.ajax
        ({
            type : 'get',
            url : 'admin-staff-get-info-accred-to-po',
            data :
                {
                    'id' : id
                },
            success : function(data)
            {
                console.log(data);

                var date = (data[0][0].created_at).split(' ');
                var optionTerm = '';


                $('#contactPersonPO').val(data[0][0].contact_person);
                $('#addressInfoPO').val(data[0][0].supp_address);
                $('#contactInfoPO').val(data[0][0].con_num + '/' + data[0][0].sup_email);
                $('#dateAccredPO').val(date[0]);

                for(var j = 0; j < data[1].length ; j++)
                {
                    optionTerm += '<option value = "'+data[1][j].id+'">'+data[1][j].supp_term+'</option>'
                }

                $('#termsSupForPO').html(optionTerm).attr('disabled', false);



            }
        })
    }
});

$('#additionalNotesTablePO').on('click', '.btnAdditionalNotesPO', function()
{
    $('#additionalNotesTablePO').append(' <tr>\n' +
        '                                        <td colspan="1" ><textarea class = "form-control addNotesPO" rows ="2"></textarea></td>\n' +
        '                                    </tr>')
});

$('#submitPORequi').click(function()
{
    var btn = $(this);
    var id = atob(btn.attr('name'));
    var addNotesArr = [];
    var dataBrand = [];
    var ctrBrand = 0;
    var ctrInnerBrand = 0;
    var brandBool = true;
    var poNumber = $('#poNumber').val();
    var poDate = $('#poDate').val();
    var selectSupForPO = $('#selectSupForPO').find(':selected').val();
    var totalAmtPO = $('#totalAmtPO').val();
    var twelveVatPO = $('#twelveVatPO').val();
    var grandTotalPO = $('#grandTotalPO').val();
    var termsSupForPO = $('#termsSupForPO').find(':selected').val();
    var dateDeliverPO = $('#dateDeliverPO').val();

    $('.loopPoItems').each(function()
    {
        if(brandBool == false)
        {
            dataBrand[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;

            if(ctrInnerBrand == 4)
            {
                ctrInnerBrand = 0;
                ctrBrand++;
                brandBool = true;
            }
        }
        else
        {
            dataBrand[ctrBrand] = [];
            dataBrand[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;
            brandBool = false;
        }
    });

    $('.addNotesPO').each(function()
    {
        addNotesArr.push($(this).val());
    });

    if(selectSupForPO != '-')
    {
        btn.attr('disabled', true)
        $.ajax
        ({
            type : 'post',
            url : 'admin-staff-insert-po-final',
            data :
                {
                    'id' : id,
                    dataBrand  : dataBrand,
                    addNotesArr : addNotesArr,
                    'poNumber' : poNumber,
                    'poDate' : poDate,
                    'selectSupForPO' : selectSupForPO,
                    'totalAmtPO' : totalAmtPO,
                    'twelveVatPO'  : twelveVatPO,
                    'grandTotalPO' : grandTotalPO,
                    'termsSupForPO' : termsSupForPO,
                    'dateDeliverPO' : dateDeliverPO
                },
            beforeSend : function()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success : function()
            {
                $('#modal-sendingrequest').modal('hide');

                setTimeout(function()
                {
                    $('#modal-success-po').modal('show');
                },1000);

                brandInc1 = 0;

                $('#addBrandTablePO').html('<tr>\n' +
                    '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;padding-bottom: 15px;">Brand - Item - Description</th>\n' +
                    '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;padding-bottom: 15px;">Quantity</th>\n' +
                    '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;  padding-bottom: 15px;">Unit Price</th>\n' +
                    '                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span style = " padding-top : 10px;">Total Amount</span><span class = "pull-right"><button class = "btn btn-sm btn-success btnToAddBrand"  ><i class = "fa fa-fw fa-plus"></i></button></span></th>\n' +
                    '                                    </tr>\n' +
                    '                                    <tr id = "removeBrand1-0">\n' +
                    '                                        <td colspan="1"><textarea class = "form-control loopPoItems" rows ="2"></textarea></td>\n' +
                    '                                        <td colspan="1"><input type="number" class="form-control loopPoItems" ></td>\n' +
                    '                                        <td colspan="1"><input type="number" class="form-control loopPoItems"></td>\n' +
                    '                                        <td colspan="1"><div class="input-group input-group-sm"><input type="number" class="form-control loopPoItems" >\n' +
                    '                                                <span class="input-group-btn">\n' +
                    '                                            <button type="button" class="btn btn-danger btn-sm btnRemoveRow" name = "0">\n' +
                    '                                            <i class = "fa fa-fw fa-minus"></i></button></span></div>\n' +
                    '                                        </td>\n' +
                    '                                    </tr>');

                $('#additionalNotesTablePO').html('<tr>\n' +
                    '                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Additional Notes <button class = "btn btn-xs btn-success btnAdditionalNotesPO" style = "margin-left : 2%"><i class = "fa fa-fw fa-plus"></i></button></th>\n' +
                    '                                    </tr>\n' +
                    '                                    <tr>\n' +
                    '                                        <td colspan="1" ><textarea class = "form-control addNotesPO" rows ="2"></textarea></td>\n' +
                    '                                    </tr>');

                $('.clearPOFields').val('');
                $('#selectSupForPO').val('-');
                $('#termsSupForPO').html('');
                $('.toClearPO').val('').attr('disabled', true)
                $('#submitPORequi').attr('name', '');
                $('#showHideSubmitPO').hide();
                $('.hideAllCreate').show();
                $('.hideAllCancel').hide();
                btn.attr('disabled', false);

                poBool = false;
                procProcess = true;
                procGenRequiBool = true;

                tableProcssEq.ajax.reload(null, false);
                tableAdminAssignLogs.ajax.reload(null, false);
            }
        })
    }
    else
    {
        alert('Please select a recommended supplier.');
        btn.attr('disabled', false);
    }
});



function eqProcessTable2()
{
    $('#admin_staff_eq_process_finance thead th').each(function()
    {
        eq_process_table_2[eq_pr_2] = $(this).text();
        eq_pr++;
    });
    tableProcssEq_2 = $('#admin_staff_eq_process_finance').DataTable
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
        "ajax": "/admin_staff_eq_proc_table_finance",
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
                        var toAdd;

                        if(data.fin_stat == 'Finance Process')
                        {
                            toAdd = ''
                        }
                        else if(data.fin_stat == 'Finance Done')
                        {
                            toAdd = '<button class = "btn btn-md btn-warning btn-block btnViewRemAttachFin" name = "'+btoa(data.id)+'">View Remarks/Attachments</button>' +
                                '<button class = "btn btn-md btn-success btn-block btnDoneProcProcess" name = "'+btoa(data.id)+'">Done</button>'
                        }

                        return '<button class="btn btn-md btn-block btn-primary btnViewInfoEqProc" name = "'+btoa(data.id)+'"> View Info</button>' +
                           ' <button class="btn btn-md btn-block btn-info btnViewPOEqProcFin" name = "'+btoa(data.id)+'"> View P.O</button>' +
                            toAdd;
                    }
                },
                {data : 'others', name : 'admin_requisition_categ.req_others', visible : false}

            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.fin_stat == 'Finance Process')
            {
                $(nRow).css('background-color', '#ffd29e');
                // $(nRow).css('color', 'white');
            }
            else if(aData.fin_stat == 'Finance Done')
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', 'white');
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

    $('#admin_staff_eq_process_finance_filter input').unbind();
    $('#admin_staff_eq_process_finance_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProcssEq_2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProcssEq_2.search($(this).val()).draw();
                }
            }
        }
    });
}

var procProcess = false;
var procFin = false;


$('.admin_staff_eq_proc_class').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tabProc_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeProcMon = '#tabProc_1';
        }
        else if (eq_po_to_fin_1) {
            console.log('already loaded');
            activeProcMon = '#tabProc_1';
        }
        else if (eq_po_to_fin_1 == false) {
            eq_po_to_fin_1 = true;
            activeProcMon = '#tabProc_1';
        }
    }
    else if (gethref == '#tabProc_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeProcMon = '#tabProc_2';
        }
        else if (eq_po_to_fin_2) {

            if(procProcess == true)
            {
                tableProcssEq_2.ajax.reload(null, false);
                procProcess = false;
            }
            else
            {
                console.log('already loaded');
            }
            activeProcMon = '#tabProc_2';
        }
        else if (eq_po_to_fin_2 == false) {
            eq_po_to_fin_2 = true;
            activeProcMon = '#tabProc_2';
            eqProcessTable2();
        }
    }
    else if (gethref == '#tabProc_3') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeProcMon = '#tabProc_3';
        }
        else if (eq_po_to_fin_3) {
            if(procFin == true)
            {
                tableProcssEqDone.ajax.reload(null, false);
                procFin = false;
            }
            else
            {
                console.log('already loaded');
            }


            activeProcMon = '#tabProc_3';
        }
        else if (eq_po_to_fin_3 == false) {
            eq_po_to_fin_3 = true;
            activeProcMon = '#tabProc_3';
            eqProcessTableDone();
        }
    }
});

$('#admin_staff_eq_process_finance').on('click', '.btnViewInfoEqProc', function()
{
    var id = atob($(this).attr('name'));
    $('.toClear').val('').attr('disabled', true);
    $('.toDisable').attr('disabled', true);
    $('.requiList').attr('disabled', true);

    $('#showHideSendRequestRequi').hide();

    viewReqModal(id, 'proc');

    $('#modal-requisition_form').modal('show');
});

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

$('#admin_staff_eq_process_finance').on('click', '.btnViewPOEqProcFin', function()
{
    var id = atob($(this).attr('name'));

    $('.hideAllCreate').show();
    $('.hideAllCancel').hide();
    $('#showHideSubmitPO').hide();

    poBool = false;

    $('#showToCreatePO').hide();
    $('#showToViewPO').show();

    $('#admin_staff_eq_process tr').each(function()
    {
       $(this).css('background-color', 'white');
    });

    clearPOAll();

    viewPOInfo(id)
});

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

$('#admin_staff_eq_process_finance').on('click', '.btnViewRemAttachFin', function()
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


$('#admin_staff_eq_process_finance').on('click', '.btnDoneProcProcess', function()
{
    var id = atob($(this).attr('name'));

    var confirm_done = prompt("Are you sure to finish the process? Please indicate remarks.",'-');

    if (confirm_done == null || confirm_done == "" || confirm_done == "-")
    {

    }
    else
    {
        $.ajax
        ({
            type : 'get',
            url : 'admin_staff_change_to_done_requi',
            data :
                {
                    'id' : id,
                    'confirm_done' : confirm_done
                },
            success : function()
            {
                alert('Successfully finished!');
                tableProcssEq_2.ajax.reload(null, false);
                procFin = true;
                procGenRequiBool = true;
            }
        })
    }







});

function genRequiTable()
{
    $('#admin-staff-gen-mon-equi-requi thead th').each(function()
    {
        gen_requi_arr[gen_requi_count] = $(this).text();
        gen_requi_count++;
    });
    tableGenRequi = $('#admin-staff-gen-mon-equi-requi').DataTable
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
                            format:
                                {
                                    header: function (dt, idx) {
                                        return gen_requi_arr[(idx)];
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
                        return gen_requi_arr[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin_staff_gen_requi_table",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'date_req', name: 'admin_requisition.date_request'},
                {data: 'req_tor', name: 'admin_requisition_categ.req_tor'},
                {data: 'req_categ', name: 'admin_requisition_categ.req_categ'},
                {data: 'req_type_1', name: 'admin_requisition_categ.req_type_1'},
                {
                    data : function type(data)
                    {
                        if(data.req_type_2 == '' || data.req_type_2 == null)
                        {
                            return data.others;
                        }
                        else
                        {
                            return data.req_type_2;
                        }
                    },
                    name : 'admin_requisition_categ.req_type_2'
                },
                {data: 'send_name', name: 'users.name'},
                {
                    data : function emp_name(data)
                    {
                        var b;

                        if(data.emp_name == null)
                        {
                            b = data.req_emp_name;
                        }
                        else
                        {
                            b = data.emp_name;
                        }

                        return b;
                    },
                    name : "users_profile.emp_full_name"
                },
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'date_need', name: 'admin_requisition.date_needed'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {data: 'supp_name', name: 'admin_accredited_suppliers.supp_name'},
                {
                    data : function stat(data)
                    {
                        var a;

                        if(data.req_stat == 'Pending' && data.out_stat == 'Pending' && data.fin_stat == '')
                        {
                            a = '<button class="btn btn-xs btn-warning" >For Management Approval</button>';
                        }
                        else if(data.req_stat == 'Pending' && data.out_stat == 'Denied' && data.fin_stat == '')
                        {
                            a = '<button class="btn btn-xs btn-danger" >Denied by Management</button>';
                        }
                        else if(data.req_stat == 'Pending' && data.out_stat == 'Approved' && data.fin_stat == '')
                        {
                            a = '<button class="btn btn-xs btn-warning" >For Admin Approval</button>';
                        }
                        else if(data.req_stat == 'Approved' && data.out_stat == 'Approved' && data.fin_stat == '')
                        {
                            a = '<button class="btn btn-xs btn-primary"  >For P.O Creation</button>';
                        }
                        else if(data.req_stat == 'Approved' && data.out_stat == 'Approved' && data.fin_stat == 'Finance Process')
                        {
                            a = '<button class="btn btn-xs btn-primary" >For Finance Process</button>';
                        }
                        else if(data.req_stat == 'Approved' && data.out_stat == 'Approved' && data.fin_stat == 'Finance Done')
                        {
                            a = '<button class="btn btn-xs btn-primary" >Finance Process Done</button>';
                        }
                        else if(data.req_stat == 'Done' && data.out_stat == 'Approved' && data.fin_stat == 'Finance Done')
                        {
                            a = '<button class="btn btn-xs btn-success" >Process Finished</button>';
                        }

                        return a;
                    },
                    name : 'admin_requisition_categ.req_others', 'searchable' : false, 'orderable' : false
                },
                {data: 'others', name: 'admin_requisition_categ.req_others', visible : false},
                {data: 'req_emp_name', name: 'admin_requisition.requested_for', visible : false}
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

    $('#admin-staff-gen-mon-equi-requi_filter input').unbind();
    $('#admin-staff-gen-mon-equi-requi_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableGenRequi.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableGenRequi.search($(this).val()).draw();
                }
            }
        }
    });
}



function eqProcessTableDone()
{
    $('#admin_staff_eq_process_done thead th').each(function()
    {
        eq_process_done_table[eq_pr_done] = $(this).text();
        eq_pr_done++;
    });
    tableProcssEqDone = $('#admin_staff_eq_process_done').DataTable
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
                                        return eq_process_done_table[(idx)];
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
                        return eq_process_done_table[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin_staff_eq_proc_done_table",
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
                        return '<button class="btn btn-md btn-block btn-primary btnViewInfoEqProc" name = "'+btoa(data.id)+'"> View Info</button>' +
                            ' <button class="btn btn-md btn-block btn-info btnViewPOEqProcFin" name = "'+btoa(data.id)+'"> View P.O</button>' +
                            '<button class = "btn btn-md btn-warning btn-block btnViewRemAttachFin" name = "'+btoa(data.id)+'">Remarks/Attachments</button>' +
                            '<button class = "btn btn-md btn-success btn-block btnViewRemDone" name = "'+btoa(data.id)+'" rem ="'+data.done_rem+'">Done Remarks</button>';
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

    $('#admin_staff_eq_process_done_filter input').unbind();
    $('#admin_staff_eq_process_done_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProcssEqDone.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProcssEqDone.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin_staff_eq_process_done').on('click', '.btnViewInfoEqProc', function()
{
    var id = atob($(this).attr('name'));
    $('.toClear').val('').attr('disabled', true);
    $('.toDisable').attr('disabled', true);
    $('.requiList').attr('disabled', true);

    $('#showHideSendRequestRequi').hide();

    viewReqModal(id, 'proc');

    $('#modal-requisition_form').modal('show');
});

$('#admin_staff_eq_process_done').on('click', '.btnViewPOEqProcFin', function()
{
    var id = atob($(this).attr('name'));

    $('.hideAllCreate').show();
    $('.hideAllCancel').hide();
    $('#showHideSubmitPO').hide();

    poBool = false;

    $('#showToCreatePO').hide();
    $('#showToViewPO').show();

    $('#admin_staff_eq_process tr').each(function()
    {
        $(this).css('background-color', 'white');
    });

    clearPOAll();

    viewPOInfo(id);
});

$('#admin_staff_eq_process_done').on('click', '.btnViewRemAttachFin', function()
{
    var id = atob($(this).attr('name'));

    getRequiFinFiles(id);
});

$('#admin_staff_eq_process').on('click', '.btnViewApprover', function()
{
    $('#view_admin_approve_requi_remarks').val('');

    $('#modal_view_approver_rem_requi_new').modal('show');

    $('#view_admin_approve_requi_remarks').val($(this).attr('rem'));
});

$('#admin_staff_eq_process_done').on('click', '.btnViewRemDone', function()
{
    $('#view_admin_approve_requi_done_remarks').val('');
    $('#modal_view_approver_rem_requi_done').modal('show');
    $('#view_admin_approve_requi_done_remarks').val($(this).attr('rem'));
});

function forComparisonTable()
{
    $('#admin-staff-acc-for-comparison thead th').each(function()
    {
        titleforComp[for_comp] = $(this).text();
        for_comp++;
    });
    titleAccSupForComp = $('#admin-staff-acc-for-comparison').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleforComp[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-accred-for-compa-table",
        "columns":
            [
                {
                    data: function select_button(data)
                    {
                        return '<button class="btn btn-normal btn_select_acc_to_compare" name = "'+data.id+'" supInfo="'+data.id+'|--|--|'+data.category+'|--|--|'+data.supp_name+'">Select</button>';
                    },
                    name: 'admin_accredited_suppliers.id'
                },
                {data: 'id', name: 'admin_accredited_suppliers.id'},
                {data: 'created_at', name: 'admin_accredited_suppliers.created_at'},
                {data: 'category', name: 'admin_accredited_suppliers.category'},
                {data: 'supp_name', name: 'admin_accredited_suppliers.supp_name'},
                {data: 'contact_person', name: 'admin_accredited_suppliers.contact_person'},
                {

                    data : function act(data)
                    {
                        return '<button class = "btn btn-xs btn-info btn-block viewInforAccred" name = "'+data.id+'" ><i class = "fa fa-fw fa-info"></i> View Info</button>' ;
                            // '<button class = "btn btn-xs btn-danger btn-block deleteAccredSup" name = "'+data.id+'"><i class = "fa fa-fw fa-trash-o"></i> Archive</button>'
                    },
                    name : 'admin_accredited_suppliers.id',
                    'searchable' : false,
                    'orderable' : false
                }


            ],
        "order": [[1, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "drawCallback": function ()
        {
            for(var t= 0; t < arraySupSelected.length; t++)
            {
                $('.btn_select_acc_to_compare').each(function()
                {
                    if ($(this).attr('name') == arraySupSelected[t])
                    {
                        $(this).html('Un-select');
                        $(this).parent().parent().toggleClass('selected');
                    }
                });
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


    $('#admin-staff-acc-for-comparison_filter input').unbind();
    $('#admin-staff-acc-for-comparison_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                titleAccSupForComp.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    titleAccSupForComp.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#admin-staff-acc-for-comparison').on('click', '.viewInforAccred', function()
{
    var id = $(this).attr('name');
    $('#editAccreditedSupplier').text('Edit');
    $('#editAccreditedSupplier').removeClass('btn-danger');
    $('#editAccreditedSupplier').addClass('btn-warning');
    $('#showInputCateg').hide();
    $('#newCategory').prop('checked', false);
    $('#showSelectCateg').show();
    $('#existingCategory').prop('checked', false);
    $('.categoryChooseclass').attr('disabled', true)
    $('#hideSubmitIfNotEdit').hide();
    getAccredDataIndiv(id);
    $('#saveAccreditedSupplier').attr('self', btoa(id) + '|-|-|edit');
});

$('#admin-staff-acc-for-comparison').on('click', '.btn_select_acc_to_compare', function()
{

    if($(this).html() == 'Select')
    {
        if(arraySupSelected.length < 3)
        {
            $(this).html('Un-select');

            arraySupSelected.push($(this).attr('name'));
            arraySupInforSelected.push($(this).attr('supInfo'));
            $(this).parent().parent().toggleClass('selected');
        }
        else if(arraySupSelected.length >= 3)
        {
            alert('Please select only 3 suppliers.')
        }
        // console.log(arraySupSelected);

    }
    else if($(this).html() == 'Un-select')
    {
        var index = arraySupSelected.indexOf($(this).attr('name'));
        var index2 = arraySupInforSelected.indexOf($(this).attr('supInfo'));

        if (index > -1)
        {
            arraySupSelected.splice(index, 1);
        }

        if (index2 > -1)
        {
            arraySupInforSelected.splice(index2, 1);
        }


        // $(this).parent().removeClass('toggleClass')

        $(this).html('Select');
        $(this).parent().parent().toggleClass('selected');

    }



    console.log(arraySupSelected);
    console.log(arraySupInforSelected);

    if(arraySupSelected.length == 3)
    {
        $('#showSubmitComparison').show();
    }
    else if(arraySupSelected.length != 3 )
    {
        $('#showSubmitComparison').hide();
    }
});

$('#openModalTOCompareAccred').click(function()
{
    var tableInsert;

    for(var i = 0; i < arraySupInforSelected.length; i++)
    {
        var split = arraySupInforSelected[i].split('|--|--|');

        tableInsert += '<tr><td colspan="1">'+split[0]+'</td><td colspan="1">'+split[1]+'</td><td colspan="1">'+split[2]+'</td></tr>';
    }

    $('#tableReviewSupplierToPass').html('<tr> <th colspan="3" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">Suppliers to be reviewed</h4></tr><tr><td colspan = "1" style= "font-weight:bold;">ID</td><td colspan = "1" style= "font-weight:bold;">Category</td><td colspan = "1" style= "font-weight:bold;">Supplier Name</td></tr>'+tableInsert+'');


    $('#modal_pass_to_manage_supplier').modal({backdrop : "static"});
});

$('#submitNowComparisan').click(function()
{
    var btn = $(this);

    var categoryToPass = $('#categoryToPass').val();
    var equipmentToBuy = $('#equipmentToBuy').val();
    var remarksComparison = $('#remarksComparison').val();

    if(confirm('Are you sure to pass this suppliers?'))
    {
        $('#loadingSpanSenRepSupManage').show();
        btn.attr('disabled', true);
        $.ajax
        ({
            type : 'post',
            url : 'admin_staff_submit_management_approval',
            data :
                {
                    arraySupSelected : arraySupSelected,
                    'categoryToPass' : categoryToPass,
                    'equipmentToBuy' : equipmentToBuy,
                    'remarksComparison' : remarksComparison
                },
            success : function()
            {
                arraySupSelected = [];
                arraySupInforSelected = [];
                btn.attr('disabled', false);
                $('#loadingSpanSenRepSupManage').hide();
                $('#modal_pass_to_manage_supplier').modal('hide');
                $('#showSubmitComparison').hide();
                $('#categoryToPass').val('');
                $('#equipmentToBuy').val('');
                $('#remarksComparison').val('');
                titleAccSupForComp.ajax.reload(null, false);
                checkmonitApp = true;
            }
        });
    }
    else
    {

    }
});

function forReviewStatusManageTable()
{
    $('#admin-staff-acc-for-approval thead th').each(function()
    {
        title_monit_ap[title_app_monit_count] = $(this).text();
        title_app_monit_count++;
    });
    titleMonitApprovalManage = $('#admin-staff-acc-for-approval').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleforComp[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin_staff_monit_sup_approval",
        "columns":
            [
                {data: 'id', name: 'admin_accredited_supplier_management_app.id'},
                {data: 'dt', name: 'admin_accredited_supplier_management_app.created_at'},
                {data: 'pass_name', name: 'users.name'},
                {data: 'categ', name: 'admin_accredited_supplier_management_app.categ_sup'},
                {data: 'equi', name: 'admin_accredited_supplier_management_app.eq_desc_sup'},
                {data: 'rem', name: 'admin_accredited_supplier_management_app.sup_rem'},
                {
                    data : function act(data)
                    {
                        return '<button class="btn btn-block btn-info btnViewInfoApproManage" name = "'+btoa(data.id)+'" ><i class="fa fa-fw fa-info-circle"></i> View Info</button>';
                    },
                    name : 'admin_accredited_supplier_management_app.id',
                    'orderable' : false,
                    'searchable'  : false
                }
            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.stat == 'Pending')
            {
                $(nRow).css('background-color', '#ffd29e');
                // $(nRow).css('color', 'white');
            }
            else if(aData.stat == 'Reviewed')
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', 'white');
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


    $('#admin-staff-acc-for-approval_filter input').unbind();
    $('#admin-staff-acc-for-approval_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                titleMonitApprovalManage.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    titleMonitApprovalManage.search($(this).val()).draw();
                }
            }
        }
    });
}




function accSuppTable2()
{
    $('#admin-staff-acc-sup-table-denied thead th').each(function()
    {
        titleAccSup2[sup_count_2] = $(this).text();
        sup_count_2++;
    });
    tableAccSup2 = $('#admin-staff-acc-sup-table-denied').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleAccSup2[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/admin-staff-accred-sup-table-denied",
        "columns":
            [
                {data: 'id', name: 'admin_accredited_suppliers.id'},
                {data: 'created_at', name: 'admin_accredited_suppliers.created_at'},
                {data: 'category', name: 'admin_accredited_suppliers.category'},
                {data: 'supp_name', name: 'admin_accredited_suppliers.supp_name'},
                {data: 'contact_person', name: 'admin_accredited_suppliers.contact_person'},
                {

                    data : function act(data)
                    {
                        return '<button class = "btn btn-xs btn-info btn-block viewInforAccred" name = "'+data.id+'"><i class = "fa fa-fw fa-info"></i> View Info</button>';
                    },
                    name : 'admin_accredited_suppliers.id',
                    'searchable' : false,
                    'orderable' : false
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

    // $('#admin-staff-acc-sup-table tbody').on('click', 'tr', function ()
    // {
    //     $(this).toggleClass('selected');
    // });

    $('#admin-staff-acc-sup-table-denied_filter input').unbind();
    $('#admin-staff-acc-sup-table-denied_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAccSup2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAccSup2.search($(this).val()).draw();
                }
            }
        }
    });
}


$('.admin_staff_accred_approval').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tabSup_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_app_tabs_1_bool)
        {
            if(checkSupOpen1 == true)
            {
                titleAccSupForComp.ajax.reload(null, false);
                checkSupOpen1 = false;
            }
            else
            {
                console.log('already loaded');
            }


        }
        else if (sup_app_tabs_1_bool == false) {
            sup_app_tabs_1_bool = true;
        }
    }
    else  if (gethref == '#tabSup_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_app_tabs_2_bool) {
            console.log('already loaded');
        }
        else if (sup_app_tabs_2_bool == false) {
            sup_app_tabs_2_bool = true;
            forComparisonTable();
        }
    }
});

$('.admin_staff_approved_denied_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tabStatSup_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_appden_tabs_1_bool) {
            console.log('already loaded');
        }
        else if (sup_appden_tabs_1_bool == false) {
            sup_appden_tabs_1_bool = true;
        }
    }
    else  if (gethref == '#tabStatSup_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_appden_tabs_2_bool) {
            console.log('already loaded');
        }
        else if (sup_appden_tabs_2_bool == false) {
            sup_appden_tabs_2_bool = true;
            accSuppTable2();
        }
    }
});



$('.admin_staff_request_sup_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tabAppr_Sup_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_monitManage_tabs_1_bool) {
            if(checkSupOpen1 == true)
            {
                titleAccSupForComp.ajax.reload(null, false);
                checkSupOpen1 = false;
            }
            else
            {
                console.log('already loaded');
            }
        }
        else if (sup_monitManage_tabs_1_bool == false) {
            sup_monitManage_tabs_1_bool = true;
        }
    }
    else  if (gethref == '#tabAppr_Sup_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_monitManage_tabs_2_bool) {

            if(checkmonitApp == true)
            {
                titleMonitApprovalManage.ajax.reload(null, false);
                checkmonitApp = false;
            }
            else
            {
                console.log('already loaded');
            }
        }
        else if (sup_monitManage_tabs_2_bool == false) {
            sup_monitManage_tabs_2_bool = true;
            forReviewStatusManageTable();
        }
    }
});

$('#admin-staff-acc-sup-table-denied').on('click', '.viewInforAccred', function()
{
    var id = $(this).attr('name');
    $('#editAccreditedSupplier').text('Edit');
    $('#editAccreditedSupplier').removeClass('btn-danger');
    $('#editAccreditedSupplier').addClass('btn-warning');
    $('#showInputCateg').hide();
    $('#newCategory').prop('checked', false);
    $('#showSelectCateg').show();
    $('#existingCategory').prop('checked', false);
    $('.categoryChooseclass').attr('disabled', true)
    $('#hideSubmitIfNotEdit').hide();
    getAccredDataIndiv(id);
    $('#saveAccreditedSupplier').attr('self', btoa(id) + '|-|-|edit');
});

$('#admin-staff-acc-for-approval').on('click', '.btnViewInfoApproManage', function()
{
    var id = atob($(this).attr('name'));

    $('.toClearViewManage').val('');




    $.ajax
    ({
        type : 'get',
        url : 'admin_staff_get_management_info_app',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            var tableInsert;

            for(var i = 0; i < data[1].length; i++)
            {
                var color;

                if(data[1][i].approval_status == 'Management Approved')
                {
                    color = 'background-color : #b3ffb3';
                }
                else if(data[1][i].approval_status == 'Management Denied')
                {
                    color = 'background-color : #ffb3b3';
                }
                else if(data[1][i].approval_status == 'Management Pending')
                {
                    color = 'background-color : white';
                }

                tableInsert += '<tr style = "'+color+'"><td colspan="1">'+data[1][i].id+'</td><td colspan="1">'+data[1][i].category+'</td><td colspan="1">'+data[1][i].supp_name+'</td></tr>';
            }

            $('#tableReviewSupplierManageView').html('<tr> <th colspan="3" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">Submitted Suppliers</tr><tr><td colspan = "1" style= "font-weight:bold;">ID</td><td colspan = "1" style= "font-weight:bold;">Category</td><td colspan = "1" style= "font-weight:bold;">Supplier Name</td></tr>'+tableInsert+'');


            if(data[0][0].stat == 'Pending')
            {
                $('#checkApprovedSupShowHide').hide();
            }
            else if(data[0][0].stat == 'Reviewed')
            {
                $('#checkApprovedSupShowHide').show();

                $('#approverNameView').val(data[0][0].name);
                $('#remarksManageView').val(data[0][0].app_rem);
            }

            $('#categoryToView').val(data[0][0].categ);
            $('#equipmentToBuyView').val(data[0][0].desc);
            $('#remarksComparisonView').val(data[0][0].rem);

            $('#modal_view_manage_info_app_sup').modal('show');
        }
    });
});

function incidentPendingReview()
{
    $('#incident-rep-table-admin-pending thead th').each(function()
    {
        inc_rep_pen[inc_rep_pen_count] = $(this).text();
        inc_rep_pen_count++;
    });
    tableIncidentRepPending = $('#incident-rep-table-admin-pending').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Incident Report(Pending)',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return inc_rep_pen[(idx)];
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
                        return inc_rep_pen[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/gen_inc_rep_review_pending_admin",
        "columns":
            [
                {data: 'id', name: 'incident_report.id'},
                {data: 'date_time', name: 'admin_requisition.date_request'},
                {data: 'name', name: 'users.name'},
                {
                    data : function action(data)
                    {
                        return '<button class="btn btn-info btn-xs btn-block btnViewInfoIncident" id="" name="'+btoa(data.id)+'" fl="'+data.stat+'"><i class="fa fa-info"></i><span style="margin-left : 3px;">View Report</span></button>'
                    },
                    name : 'incident_report.id',
                    'searchable' : false,
                    'orderable' : false
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

    $('#incident-rep-table-admin-pending_filter input').unbind();
    $('#incident-rep-table-admin-pending_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableIncidentRepPending.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableIncidentRepPending.search($(this).val()).draw();
                }
            }
        }
    });
}

function incidentDoneReview()
{
    $('#incident-rep-table-admin-reviewed thead th').each(function()
    {
        inc_rep_done[inc_rep_pen_count] = $(this).text();
        inc_rep_done_count++;
    });
    tableIncidentRepDone = $('#incident-rep-table-admin-reviewed').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Incident Report(Reviewed)',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return inc_rep_pen[(idx)];
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
                        return inc_rep_pen[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/gen_inc_rep_review_done_admin",
        "columns":
            [
                {data: 'id', name: 'incident_report.id'},
                {data: 'date_time', name: 'admin_requisition.date_request'},
                {data: 'name', name: 'users.name'},
                {
                    data : function action(data)
                    {
                        return '<button class="btn btn-info btn-xs btn-block btnViewInfoIncident" id="" name="'+btoa(data.id)+'"  fl="'+data.stat+'"><i class="fa fa-info"></i><span style="margin-left : 3px;">View Report</span></button>'
                    },
                    name : 'incident_report.id',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.stat == 'Admin Approved')
            {
                $(nRow).css('background-color', '#b3ffb3');
                // $(nRow).css('color', 'white');
            }
            else if(aData.stat == 'Admin Reject')
            {
                $(nRow).css('background-color', '#ffb3b3');
                // $(nRow).css('color', 'white');
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

    $('#incident-rep-table-admin-reviewed_filter input').unbind();
    $('#incident-rep-table-admin-reviewed_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableIncidentRepDone.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableIncidentRepDone.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#incident-rep-table-admin-pending').on('click', '.btnViewInfoIncident', function()
{
    var id = atob($(this).attr('name'));
    var stst = $(this).attr('fl');


    $('#loopIncidentImagesAdmin').html('');
    $('#incident_rep_rem_admin').val('');
    $('#incident_rep_approver_remarks_admin').val('');
    $('#incident_rep_admin_remarks_admin').val('');

    $('.btn2ndApprovalIncident').attr('name', '');

    getImageRemarksIncidentAdmin(id);

    $('#hideShowApproverRemarksAdmin').hide();

    if(stst == 'Management Approved')
    {
        $('#divHideShowIncidentButtonsAdmin').show();
        $('.btn2ndApprovalIncident').attr('name', $(this).attr('name'));
    }
    else
    {
        $('#divHideShowIncidentButtonsAdmin').hide();
    }

});

function getImageRemarksIncidentAdmin(id)
{
    $.ajax
    ({
        type : 'get',
        url : 'gen_incident_get_images',
        data :
            {
                'id': id
            },
        success : function(data)
        {
            console.log(data);

            $('#incident_rep_rem_admin').val(data[1][0].report_remarks);
            $('#incident_rep_approver_remarks_admin').val(data[1][0].rem_approver);
            $('#incident_rep_admin_remarks_admin').val(data[1][0].admin_remarks);

            for(var i=0; i <= data[0].length-1; i++)
            {
                $('#loopIncidentImagesAdmin').append
                (
                    '<div class="col-md-4" style="padding-bottom : 20px;">' +
                    '<a style="cursor: pointer" target="_blank" href="incident_view_tab/'+btoa(id)+'/'+btoa(data[0][i])+'" title="Click to view photo">' +
                    '<img src="incident_view_tab/'+btoa(id)+'/'+btoa(data[0][i])+'" alt="" width="100%" style = "height: 150px; width : 150px; border : solid black 1px; ">' +
                    '</a>' +
                    '</div>'
                )
            }
        }
    });
}

$('#incident-rep-table-admin-reviewed').on('click', '.btnViewInfoIncident', function()
{
    var id = atob($(this).attr('name'));


    $('#loopIncidentImagesAdmin').html('');
    $('#incident_rep_rem_admin').val('');
    $('#incident_rep_approver_remarks_admin').val('');
    $('#incident_rep_admin_remarks_admin').val('');

    $('.btn2ndApprovalIncident').attr('name', '');

    getImageRemarksIncidentAdmin(id);

    $('#divHideShowIncidentButtonsAdmin').hide();
    $('.btn2ndApprovalIncident').attr('name', '');
    $('#hideShowApproverRemarksAdmin').show();

});

$('.btn2ndApprovalIncident').click(function()
{
    var btn = $(this);
    var id = atob(btn.attr('name'));
    var stat = btn.attr('stat');


    var rem = prompt("Are you sure to " +stat+ " this request? Please indicate remarks.",'-');
    if (rem == null || rem == "")
    {

    }
    else
    {
        $.ajax
        ({
            type : 'get',
            url : 'gen_incident_approval_admin',
            data :
                {
                    'id' : id,
                    'rem' : rem,
                    'stat' : stat
                },
            beforeSend : function()
            {
                btn.attr('disabled', true);
            },
            success : function()
            {
                alert('Successfully submitted!')
                $('#loopIncidentImagesAdmin').html('');
                $('#incident_rep_rem_admin').val('');
                $('#incident_rep_approver_remarks_admin').val('')
                $('.btn2ndApprovalIncident').attr('name', '');
                $('#divHideShowIncidentButtonsAdmin').hide();
                $('#incident_rep_admin_remarks_admin').val('');
                tableIncidentRepPending.ajax.reload(null, false);

                incidentBool = true;

                btn.attr('disabled', false);
            }

        });
    }
});

var incident_tab_1_bool = false;
var incident_tab_2_bool = false;

$('.incident_admin_status_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#incident_view_admin_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (incident_tab_1_bool) {
            console.log('already loaded');
        }
        else if (incident_tab_1_bool == false) {
            incident_tab_1_bool = true;
        }
    }
    else  if (gethref == '#incident_view_admin_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (incident_tab_2_bool) {

            if(incidentBool == true)
            {
                tableIncidentRepDone.ajax.reload(null, false);
                incidentBool = false;
            }
            console.log('already loaded');
        }
        else if (incident_tab_2_bool == false) {
            incident_tab_2_bool = true;
            incidentDoneReview();
        }
    }
});



$('#btnArToPDFSendToEmail').click(function()
{
    $('#btnArToPDFSendToEmail').prop('disabled', true);

    var btn = $(this);
    var ar_bols = true;
    var save_dataa = '{"data" : [';
    var checker = '0';
    var count = 0;
    var NameofEmp = $('#ar_name_emp').val();
    var officeLocDept = $('#ar_loc_dept').val();
    var contNumEmail = $('#ar_cont_email').val();
    var LbcBranch = $('#ar_lbc_branch').val();
    var checkBox = '';


    $('.ToLoopAcno').each(function ()
    {
        if($(this).attr('name') == 'item_quantity')
        {
            save_dataa += '{ "'+$(this).attr('name')+'" : "'+$(this).val()+'",';
            count++;
        }
        else if($(this).attr('name') == 'warranty_period')
        {
            save_dataa += '"'+$(this).attr('name')+'" : "'+$(this).val()+'"},';
        }
        else
        {
            save_dataa += '"'+$(this).attr('name')+'" : "'+$(this).val()+'",';
        }

        checker = $(this).attr('name');

    });

    $('.acknowledge_approve').each(function()
    {
        if($(this).is(":checked"))
        {
            checkBox +=  'true'+'||';
        }
        else
        {
            checkBox +=  'false'+'||';
        }
    });



    var save_daa = save_dataa.slice(0,-1);

    save_daa += ']}';


    $('.ar_inputs').each(function ()
    {
        if($(this).val() != '')
        {
            ar_bols = true;
        }
        else
        {
            ar_bols = false;
            alert('Fill-up the required fields');
            return false;
        }
    });

    if (ar_bols) {
        $.ajax({
            type: 'post',
            url: 'admin_send_ar_notif',
            data: {
                'json_data': save_daa,
                'NameofEmp': NameofEmp,
                'officeLocDept': officeLocDept,
                'contNumEmail': contNumEmail,
                'LbcBranch': LbcBranch,
                'user_id': $('#ar_cont_email').attr('name'),
                'checkBox': checkBox
            },
            success: function (data) {
                console.log(data);
                if(data == 'success')
                {
                    $('.ar_inputs').val('');
                    $('.ar_checkbox').prop('checked', false);

                    $('#addBrandTable2 tr').each(function () {
                        if ($(this).attr('name') == 0)
                        {

                        }
                        else {
                            if ($('#addBrandTable2 tr').length == 2)
                            {

                            }
                            else
                            {
                                $(this).remove();
                            }
                        }

                    });
                    alert('Acknowledge Receipt sent to Employee');

                }
                else{
                    alert('Failed to send Acknowledge Receipt to Employee ');
                }
            },
            complete: function(){
                $('#btnArToPDFSendToEmail').prop('disabled', false);
            }
        });
     }
     else
    {
        $('#btnArToPDFSendToEmail').prop('disabled', false);
    }
});


$('#ar_name_emp').autocomplete
({
    source: '/fetch-acknowledge-names',
    minLength: 1,
       select: function (event,ui,label)
       {
        $('#ar_cont_email').val(ui.item.email);
        $('#ar_cont_email').attr('name', ui.item.id);
        console.log(ui.item.id);
       }
});

$('#item-status').change(function()
{
    var item_status =  $('#item-status').val();

    if(item_status == 'Disposal')
        {
            $('#dispose_attachment').show();

        }
        else
        {
            $('#dispose_attachment').hide();
            $('.putgreed').remove();
            $('.disposeFilesTobeUploadBulk').val('');
            $('#update-item-remarks').val('');
        }
        console.log(item_status);
});


$(".button_disposeadd").click(function()
{
    var disposer = Math.floor((Math.random() * 100) + 1);

    $("#dispose_attachment").append('' +
        '          <div id="greedy'+disposer+'" class="putgreed"> '+
        '          <input type="file" class="disposeFilesTobeUploadBulk"multiple>'+
        '          <button class="button_disposeremove btn btn-danger" id="'+disposer+'"><i class="glyphicon glyphicon-remove"></i></button>' +
        '          </div>' +
    '');
});

$(document).on("click", ".button_disposeremove", function()
{
        $('#greedy' + $(this).attr('id')+'').remove();
});


$('#btn_ar_clear').click(function ()
{
    if (confirm('are you sure you want to clear'))
    {

        $('.ar_doble').each(function ()
        {
            if($(this).val() != '')
            {
                $(this).val('');
                $('.ar_inputs').prop('checked', false);
            }
            else
            {

            }
        });


        $('#addBrandTable2 tr').each(function ()
            {
                if ($(this).attr('name') == 0) {

                }
                else {
                    if ($('#addBrandTable2 tr').length == 2) {

                    }
                    else {
                        $(this).remove();
                    }
                }
            });
    }
    else {

    }
});

//=========AR DataTable=============//

$(document).on('click', '.ar_tab_monit1', function() {
    getArReceipts();

    function getArReceipts() {

        tableArReceipts = $('#ar-monitoring-table').DataTable(
            {
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": "get_ar_monitoring_table",
                "columns":
                    [
                        {data: 'id', name: 'acknowledge_forms.id', visible: false},
                        {
                            data: function action(data)
                            {
                                return 'Acknowledge Receipt Dated ' +data.created_at+ ' to ' + data.employee_name;
                            },
                            'name': 'users.name',
                            orderable: false
                        }
                    ],
                "pageLength": 10,
                "pagingType": "simple",
                "bSortClasses": false,
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
                {
                    if(aData.status == 'Acknowledge')
                    {
                        $('td', nRow).css('background-color', '#b3ffb3');
                    }
                    else
                    {
                        $('td', nRow).css('background-color', '#ffb84d');
                    }

                    $('td', nRow).css('cursor', 'pointer');
                    $('td', nRow).addClass('get_infos');
                    $('td', nRow).attr('id', btoa(aData.id));
                }
            });

        $('#ar-monitoring-table_filter input').unbind();
        $('#ar-monitoring-table_filter input').bind('keyup change', function (e) {

            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    tableArReceipts.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        tableArReceipts.search($(this).val()).draw();
                    }
                }
            }
        });
    }
});

$('#ar-monitoring-table').on('click', '.get_infos', function()
{

    var get_id = atob($(this).attr('id'));
    $('.ar_monitsView').val('');

    console.log(get_id);


    $.ajax({
        url: 'fetch-ar-monitoring',
        type: 'get',
        data:{
                'id': get_id
        },
        success: function (data) {

            $('#ar_monitoring_brandItems tr').each(function ()
            {
                if ($(this).attr('name') == 0) {

                }
                else {
                    $(this).remove();
                }
            });

            var attachment_boolHolder = (data[0][0].attachment_bool);
            var attachment_bool = attachment_boolHolder.split("||");
            attachment_bool.pop();

            $('#ar_monit_nameEmp').val(data[0][0].Employee_name);
            $('#ar_monit_ofc_loc_dept').val(data[0][0].office_loc_dep_pos);
            $('#ar_monit_cont_email').val(data[0][0].cnum_email);
            $('#ar_monit_lbc').val(data[0][0].LBC_Branch);

            for(var i=0; i < data[1].data.length; i++)
            {
                $('#ar_monitoring_brandItems').append(
                    $('<tr></tr>').append(
                        $('<td></td>').html('<input type="number" class="form-control ar_monitsView" value="'+data[1].data[i].item_quantity+'" disabled>'),
                        $('<td></td>').append($('<textarea class="form-control ar_monitsView" disabled></textarea>').val(data[1].data[i].brand_desc)),
                        $('<td></td>').html('<input type="text" class="form-control ar_monitsView" value="'+data[1].data[i].warranty_period+'" disabled>')
                    )
                )
            }
            for (var j=0; j < attachment_bool.length; j++){
                if(attachment_bool[j] == 'true')
                {
                    $('.Check_arView[name="'+j+'"]').prop('checked', true);
                }
                else {
                    $('.Check_arView[name="'+j+'"]').prop('checked', false);
                }
            }
            console.log(data);
        }
    })
});

$(document).ready(function()
{
$("#Ar_searchViewqwe").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tbl_acnoo li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
});


// var table = $('#Ar_searchViewqwe').DataTable();

// #myInput is a <input type="text"> element
// $('#Ar_searchViewqwe').on( 'keyup', function () {
//     ar-monitoring-table.search( this.value ).draw();
// } )