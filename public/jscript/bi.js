var maiden_trigger_gender;
var maiden_trigger_status;
var check_box_event = '';

var table_general;
var title_general = [];
var general_count = 0;

var table_pending;
var title_pending = [];
var pending_count = 0;

var table_return;
var title_return = [];
var return_count = 0;

var table_finished;
var title_finished_h = [];
var title_finished_counts = 0;

var activeAcc = 'tab_a';
var bi_client_gen = true;
var bi_client_pen = false;
var bi_client_fin = false;
var bi_client_ret = false;
var bi_client_cancel = false;
var bi_client_hold = false;

var countSendBI = false;

var activeBiSide = 'bi_client_endorse';
var bi_side_en = true;
var bi_side_table = false;

var countclickNotif = 0;
var table_cancel;
var table_hold;
var title_cancel = [];
var title_cancel_counts = 0;
var title_hold = [];
var title_hold_counts = 0;
var statusForReturn;
var globalIDReturn;
var warningFile = 'Cannot upload file that is greater than 25mb';

var what_to_submit = '';
var required_fieldBool = false;

var pdrn_count_coob_ = false;
var pdrn_count_coob_array = [];

var provIdAdditionalAdd;
var muniIdAdditionalAdd;
var arrayPackageToBulk = [];

var applyBulkBool = false;

var tableExcelBool = false;
var arrayBulkPackagesCheckLoop = [];
// var storeCurrentPackage;

var boolCollapsePackCheck = false;
var bulkEndorseBool = false;
var tabtabtab2 = false;
var cancelled_applicants_table = '';
var pending_applicants_table;
var tabtab3 = false;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(document).on('click', '.during_endorsementRemove', function()
{
    var button_id = $(this).attr("href");
    duringEndClick = duringEndClick -1;
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.removeAttachfileeee', function()
{
    var button_id = $(this).attr('href');
    var name_row = $(this).attr('name');
    // console.log(button_id);
    $('#rowRemove-'+name_row+'-'+button_id+'').remove();
});


function refTables()
{
    if(bi_client_gen == true)
    {
        table_general.ajax.reload(null, false);
    }
    if(bi_client_pen == true)
    {
        table_pending.ajax.reload(null, false);
    }
    if(bi_client_fin == true)
    {
        table_finished.ajax.reload(null, false);
    }
    if(bi_client_ret == true)
    {
        table_return.ajax.reload(null, false);
    }
    if(bi_client_cancel == true)
    {
        table_cancel.ajax.reload(null, false);
    }
    if(bi_client_hold == true)
    {
        table_hold.ajax.reload(null, false);
    }
}

$('#BtnBulkEndorseSubmitExcel').hide();
$('#BtnClearBulk').hide();
$('#btnTestClientBulk').hide();
$('#BtnSaveEdit').hide();

$(document).ready(function ()
{

    $.ajax({

        url: 'bi_check_user',
        type: 'get',
        success: function (data) {

            console.log(data);
            // console.log('user grant: '+data);

            if(data[0] == 'cc_bank')
            {
                $('#upload_endorsement_tab').remove();

                $('#cc_span_bi').remove();
                $('#cc_span_pnb').show();
                $('#btn_bi_submit_endorsement').hide();
                console.log('user grant: '+data[0]);
                what_to_submit = 'cc_bank';
                // fetchTemp();
            }
            else if(data[0] == 'tat_selector')
            {
                $('#cc_span_bi').show();
                $('#cc_span_pnb').remove();
                console.log('user grant: '+data[0]);
                what_to_submit = 'cc_bi_sitel';
            }
            else
            {
                $('#cc_span_bi').show();
                $('#cc_span_pnb').remove();
                console.log('user grant: '+data[0]);
                what_to_submit = 'cc_bi';

            }
            if(data[1] == 'direct_enc')
            {
                required_fieldBool = true;
            }

        },
        error: function () {
            alert('Error loading of resources');
        }

    });

    $('#notifReturned').hide();
    $('#notifFinished').hide();

    var opt_year = '<option value="-">-</option>';
    for(var year = 2019; year>1900; year--)
    {
        opt_year+='<option value="'+year+'">'+year+'</option>'
    }
    $('#acct_birthdate_year').html(opt_year);

    $.ajax({

        url : 'bi_get_bi_account_name',
        type : 'get',
        success : function (data)
        {


            if(data[0] == 'none')
            {
                $('#span_bi_account').html('No selected account');
            }
            else
            {
                $('#span_bi_account').html('Account: '+data[0][0].bi_account_name +' '+data[0][0].account_location);
                $('#bi_account').val(data[0][0].bi_account_name +' '+data[0][0].account_location);
                $('#bi_account').attr('name',data[0][0].bi_id);

                var select = '';
                var select2 = '';
                var select3 = '';
                var select4 = '';
                var check = '';
                var check2 = '';
                var check3 = '';
                var check4 = '';



                var package_name = [];
                var package_id = [];

                $.each(data[0], function(i, data_chunks){
                    if($.inArray(data_chunks.package, package_name) === -1) package_name.push(data_chunks.package);
                    if($.inArray(data_chunks.package_id, package_id) === -1) package_id.push(data_chunks.package_id);
                });

                for(var ctr = 0; ctr<package_name.length; ctr++)
                {
                    select +='<option name="'+package_name[ctr]+'" value = "'+package_id[ctr]+'">'+package_name[ctr]+'</option>';
                    select2 +='<option name="'+package_name[ctr]+'" value = "'+package_id[ctr]+'">'+package_name[ctr]+'</option>';
                    select3 +='<option name="'+package_name[ctr]+'" value = "'+package_id[ctr]+'">'+package_name[ctr]+'</option>';
                    select4 +='<option name="'+package_name[ctr]+'" value = "'+package_id[ctr]+'">'+package_name[ctr]+'</option>';
                }

                var checking_name = [];
                $.each(data[0], function(i, data_chunks)
                {
                    if($.inArray(data_chunks.checking, checking_name) === -1) checking_name.push(data_chunks.checking);
                });

                var information_name = [];
                $.each(data[0], function(i, data_chunks)
                {
                    if($.inArray(data_chunks.information, information_name) === -1) information_name.push(data_chunks.information);
                });


                for(var i = 0; i<checking_name.length; i++)
                {
                    check += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking minimal-red" value="'+checking_name[i]+'" name = "alacarte"><strong> '+checking_name[i]+'</strong><span data-toggle="tooltip" title="'+information_name[i]+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check2 += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_pending minimal-red" value="'+checking_name[i]+'" name = "alacarte"><strong> '+checking_name[i]+'</strong><span data-toggle="tooltip" title="'+information_name[i]+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check3 += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_excel minimal-red" value="'+checking_name[i]+'" name = "alacarte"><strong> '+checking_name[i]+'</strong><span data-toggle="tooltip" title="'+information_name[i]+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check4 += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_loop_bulk minimal-red" value="'+checking_name[i]+'" name = "alacarte"><strong> '+checking_name[i]+'</strong><span data-toggle="tooltip" title="'+information_name[i]+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                }

                for(var p = 0; p<data[1].length; p++)
                {
                    check += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking minimal-red" value="'+data[1][p].other_check+'" name = "alacarte"><strong> '+data[1][p].other_check+'</strong><span data-toggle="tooltip" title="'+data[1][p].information+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check2 += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_pending minimal-red" value="'+data[1][p].other_check+'" name = "alacarte"><strong> '+data[1][p].other_check+'</strong><span data-toggle="tooltip" title="'+data[1][p].information+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check3 += '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_excel minimal-red" value="'+data[1][p].other_check+'" name = "alacarte"><strong> '+data[1][p].other_check+'</strong><span data-toggle="tooltip" title="'+data[1][p].information+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';

                    check4 +=  '          <div class = "row">\n' +
                        '               <div class = "form-group col-md-12">\n' +
                        '                   <input type = "checkbox" class = "check_list_checking_loop_bulk minimal-red" value="'+data[1][p].other_check+'" name = "alacarte"><strong> '+data[1][p].other_check+'</strong><span data-toggle="tooltip" title="'+data[1][p].information+'" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>' +
                        '               </div>\n' +
                        '          </div>';
                }

                // console.log(uniqueNames);

                $('#bi_package_pending').html('<select class="form-control" id="type_package_pending"><option name="-" value = "-">-</option>'+select2+'</select>');
                $('#bi_package').html('<select class="form-control" id="type_package"><option name="-" value = "-">-</option>'+select+'</select>');
                $('#span_check_box_for_checkings').html(check);
                $('#span_check_box_for_checkings2').html(check2);

                $('#packagesForBulk').html('<select class="form-control" id="type_package_excel"><option name="-" value = "-">-</option>'+select3+'</select>');
                $('#checkingForBulk').html(check3);

                $('.multiplePackagesLoop').html('<select class="form-control packageBulkIndiv" id=""><option name="-" value = "-">-</option>'+select4+'</select>');
                $('.multipleCheckingsLoop').html(check4);


                func_package();
                func_package1();
                func_package2();
            }

        }
    });
});


function get_general_table()
{
    $('#bi_client_general_table thead th').each(function()
    {
        title_general[general_count] = $(this).text();
        general_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_general = $('#bi_client_general_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        // "ajax" : 'bi_client_get_general_table',
        "ajax":
            {
                url: "bi_client_get_general_table",
                data: function (d)
                {
                    d.min_date_endorsed = $('#gen_client_min').val();
                    d.max_date_endorsed = $('#gen_client_max').val();
                    d.search_methodd = $('input[name="general_client_rad"]:checked').val();
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
                                        return title_general[(idx)];
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
                // {
                //     extend: 'colvis',
                //     text: 'Show/Hide Column',
                //     columnText: function (dt, idx, title)
                //     {
                //         return title_general[(idx)];
                //     }
                // }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},  
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'party_num', name: 'bi_endorsements.party_num'},
                {data: 'contract_num', name: 'bi_endorsements.contract_num'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.date_time_due'},
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Refused to be interviewed')
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
                        else if(data.tele_stat == 'Verified')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Verified')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            } 
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Unverified')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Unverified')
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
                    'orderable' : false,
                    'visible' : false
                },
                {
                    data : function action(data)
                    {
                        var addCancel = '';

                        if(data.cancel_status == '' || data.cancel_status == null)
                        {
                            if(data.status == 10 || data.status == 4)
                            {
                                addCancel = '';
                            }
                            else
                            {
                                addCancel = '<button class="btn btn-xs btn-danger btn-block client_req_cancel" id="'+data.endorse_id+'" data-toggle="modal" data-target="#modal-bi-cancel-request" name="req_cancel"><i class="glyphicon glyphicon-ban-circle"></i> Request Account Cancellation</button>';
                            }
                        }
                        else if(data.cancel_status == 'Cancelled' || data.cancel_status == 'Pending')
                        {
                            addCancel = '<button class="btn btn-xs btn-danger btn-block client_revoke_cancel" id="'+data.endorse_id+'" data-toggle="modal" data-target="#modal-bi-cancel-request" name="req_revoke"><i class="glyphicon glyphicon-ban-circle"></i> Revoke Cancellation</button>' ;
                        }
                        else if(data.cancel_status == 'Pending Cancelled' || data.cancel_status == 'Pending Revoke')
                        {
                            addCancel = '';
                        }

                        return addCancel + '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'action',
                    'searchable' : false
                }
            ],

        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        // "deferRender": true,
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

            if(what_to_submit =='cc_bank')
            {
                // table_general.column(1).visible(true);
                table_general.column(6).visible(false);
                // table_general.column(7).visible(true);
                table_general.column(9).visible(false);
                table_general.column(8).visible(false);
                table_general.column(13).visible(true);
            }
            else
            {
                // table_general.column(1).visible(false);
                table_general.column(4).visible(false);
                table_general.column(6).visible(true);
                // table_general.column(7).visible(true);
                table_general.column(8).visible(true);
                table_general.column(13).visible(false);
            }
        }
    })

    $('#bi_client_general_table_filter input').unbind();
    $('#bi_client_general_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_general.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_general.search($(this).val()).draw();
                }
            }
        }
    });

}

function get_pending_table() {

    $('#bi_client_pending_table thead th').each(function() {
        title_pending[pending_count] = $(this).text();
        pending_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_pending = $('#bi_client_pending_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'bi_client_get_pending_table',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
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
                                        return title_general[(idx)];
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
                {data: 'party_num', name: 'bi_endorsements.party_num'},
                {data: 'dealer_num', name: 'bi_endorsements.dealer_num'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.due'},
                {
                    data : function action(data) {
                        return '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        // {
        //     if ( aData.endorsement_status_external == "TAT" )
        //     {
        //         $('td', nRow).css('background-color', '#66ff66');
        //     }
        //     else if(aData.endorsement_status_external == "OVERDUE")
        //     {
        //         $('td', nRow).css('background-color', '#ff9980');
        //     }
        // },
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

            if(what_to_submit =='cc_bank')
            {
                table_pending.column(1).visible(false);
                table_pending.column(2).visible(true);
                table_pending.column(6).visible(false);
                table_pending.column(7).visible(false);
            }
            else
            {
                table_pending.column(1).visible(true);
                table_pending.column(2).visible(false);
                table_pending.column(6).visible(true);
                table_pending.column(7).visible(true);
            }
        }
    });


    $('#bi_client_pending_table_filter input').unbind();
    $('#bi_client_pending_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_pending.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_pending.search($(this).val()).draw();
                }
            }
        }
    });

}

function get_return_table() {

    $('#bi_client_return_table thead th').each(function() {
        title_return[return_count] = $(this).text();
        return_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_return = $('#bi_client_return_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'bi_client_get_return_table',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
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
                                        return title_general[(idx)];
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
                {data: 'party_num', name: 'bi_endorsements.party_num'},
                {data: 'dealer_num', name: 'bi_endorsements.dealer_num'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {
                    data : function action(data) {

                        if(data.status == 20)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                        }
                        else if(data.status == 22)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                        }
                        else if(data.status == 23)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }
                        else if(data.status == 25)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }
                        else if (data.status == 21)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Returned Enodrsement</a>';
                        }
                        else if(data.status == 24)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }

                    },
                    'name' : 'bi_endorsements.status',
                },
                {
                    data : function action(data) {

                        return '<a class="btn_re_endorse_edit btn btn-xs btn-warning btn-block" id="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-plus"></i> Add/Remove Attachment</a>' +
                            '<a class="btn_re_endorse btn btn-xs btn-warning btn-block" style="display: none;" id="'+data.endorse_id+'" data-toggle="modal" data-target="" name="'+data.status+'"><i class="glyphicon glyphicon-refresh"></i> Re Endorse / Upload</a>' +
                            '<a class="btn btn-xs btn-danger btn-block btn_viewReason"data-toggle="modal" data-target="" name ="'+data.endorse_id+'"><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                            '<a class="btn_re_endorse_edit_cancel btn btn-xs btn-danger btn-block" style="display: none;" id="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-remove"></i> Cancel</a>' +
                            '<br><a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        // {
        //     if ( aData.endorsement_status_external == "TAT" )
        //     {
        //         $('td', nRow).css('background-color', '#66ff66');
        //     }
        //     else if(aData.endorsement_status_external == "OVERDUE")
        //     {
        //         $('td', nRow).css('background-color', '#ff9980');
        //     }
        // },
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

            if(what_to_submit =='cc_bank')
            {
                table_return.column(1).visible(false);
                table_return.column(6).visible(false);
                table_return.column(7).visible(false);
            }
            else
            {
                table_return.column(1).visible(true);
                table_return.column(2).visible(false);
                table_return.column(6).visible(true);
                table_return.column(7).visible(true);
            }
        }
    });

    $('#bi_client_return_table_filter input').unbind();
    $('#bi_client_return_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_return.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_return.search($(this).val()).draw();
                }
            }
        }
    });

}

$('#bi_check_same_address').on('change',function(e)
{

    if($(this).is(":checked"))
    {
        check_box_event = e.target;

        console.log('checked');

        $('#bi_permanent_address').val($('#bi_present_address').val());
        $('#bi_permanent_municipality').val($('#bi_present_municipality').val());
        $('#bi_permanent_idProvince').val($('#bi_present_idProvince').val());
        $('#bi_permanent_idMunicipality').val($('#bi_present_idMunicipality').val());

        $('#bi_permanent_address').attr('disabled','disabled');
        $('#bi_permanent_municipality').attr('disabled','disabled');
        // $('#bi_permanent_province').attr('disabled','disabled');

        fetch_permanent_Prov();
    }
    else
    {
        console.log('unchecked');

        $('#bi_permanent_address').val('');
        $('#bi_permanent_municipality').val('');
        $('#bi_permanent_idProvince').val('');
        $('#bi_permanent_idMunicipality').val('');
        $('#bi_permanent_province').val('');

        $('#bi_permanent_address').removeAttr('disabled');
        $('#bi_permanent_municipality').removeAttr('disabled');
        // $('#bi_permanent_province').removeAttr('disabled');
    }
});

// $('#bi_check_same_address').click(function () {
//
//
//
//
// });


function func_package1()
{
    $('#type_package').change(function ()
    {
        var id = $(this).val();
        console.log($(this).find('option:selected').attr("name"));

        $('.check_list_checking').each(function () {
            $(this).prop('checked',false);
            $(this).removeAttr('name');

        });

        setTimeout(function () {
            $.ajax({

                url : 'bi_get_change_package_check',
                type : 'get',
                data : {
                    'package_id' : id
                },
                success : function(data){

                    console.log(data);
                    // $('#check-'+data[ctr].checking+'').attr('checking','checked');
                    $('.check_list_checking').each(function () {

                        var same = false;

                        for (var ctr = 0; ctr<data.length; ctr++)
                        {
                            if($(this).val() == data[ctr].checking)
                            {
                                same = true;
                                ctr = data.length + 1;
                                // $("#myCheck").;
                            }
                            else
                            {
                                same = false;
                            }
                        }

                        if(same)
                        {
                            $(this).prop('checked',true);
                            $(this).attr('name','package');
                            // console.log($(this).val()+' : package');

                        }
                        else
                        {
                            $(this).attr('name','alacarte');
                            // console.log($(this).val()+' : alacarte');

                        }


                    });

                },
                error : function () {
                    console.log('error');
                }

            });
        },500);

    });
}
function func_package()
{
    $('#type_package_pending').change(function () {
        var id = $(this).val();
        console.log($(this).find('option:selected').attr("name"));

        $('.check_list_checking_pending').each(function () {
            $(this).prop('checked',false);
            $(this).removeAttr('name');

        });

        setTimeout(function () {
            $.ajax({

                url : 'bi_get_change_package_check',
                type : 'get',
                data : {
                    'package_id' : id
                },
                success : function(data){

                    console.log(data);
                    // $('#check-'+data[ctr].checking+'').attr('checking','checked');
                    $('.check_list_checking_pending').each(function () {

                        var same = false;

                        for (var ctr = 0; ctr<data.length; ctr++)
                        {
                            if($(this).val() == data[ctr].checking)
                            {
                                same = true;
                                ctr = data.length + 1;
                                // $("#myCheck").;
                            }
                            else
                            {
                                same = false;
                            }
                        }

                        if(same)
                        {
                            $(this).prop('checked',true);
                            $(this).attr('name','package');
                            console.log($(this).val()+' : package');

                        }
                        else
                        {
                            $(this).attr('name','alacarte');
                            console.log($(this).val()+' : alacarte');

                        }


                    });

                },
                error : function () {
                    console.log('error');
                }

            });
        },500);

    });
}

function func_package2()
{
    $('#type_package_excel').change(function () {
        var id = $(this).val();

        $('.check_list_checking_excel').each(function () {
            $(this).prop('checked', false);
            $(this).attr('disabled', false);
            $(this).removeAttr('name');

        });

        setTimeout(function () {
            $.ajax({

                url: 'bi_get_change_package_check',
                type: 'get',
                data: {
                    'package_id': id
                },
                success: function (data)
                {

                    console.log(data);
                    // $('#check-'+data[ctr].checking+'').attr('checking','checked');
                    $('.check_list_checking_excel').each(function () {

                        var same = false;

                        for (var ctr = 0; ctr < data.length; ctr++) {
                            if ($(this).val() == data[ctr].checking) {
                                same = true;
                                ctr = data.length + 1;
                                // $("#myCheck").;
                            }
                            else {
                                same = false;
                            }
                        }

                        if (same) {
                            $(this).prop('checked', true);
                            $(this).attr('name', 'package');
                            $(this).attr('disabled', true);
                            // console.log($(this).val() + ' : package');

                        }
                        else {
                            $(this).attr('name', 'alacarte');
                            // console.log($(this).val() + ' : alacarte');

                        }


                    });

                },
                error: function () {
                    console.log('error');
                }

            });
        }, 500);

    });
}

var present_muniID = '';
var present_originalMuniID = '';
var permenant_muniID = '';
var permanent_originalMuniID = '';



$('#bi_present_municipality').autocomplete
({
    source: '/fetch-city-muni',
    minLength: 1,
    select: function (event, ui)
    {
        $('#bi_present_idProvince').val('');
        $('#bi_present_idMunicipality').val('');
        $('#bi_present_idProvince').val(ui.item.muniID);
        $('#bi_present_idMunicipality').val(ui.item.originalMuniID);
        var clearTime = setInterval(function ()
        {
            fetch_present_Prov();
            clearInterval(clearTime);
        },10)
    }
});

$('#bi_present_municipality').focusout(function ()
{
    if($('#bi_present_municipality').val() === '')
    {
        $('#bi_present_province').val('');
    }
    else
    {
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#bi_present_municipality').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#bi_present_idProvince').val(data[0].province_id);
                $('#bi_present_idMunicipality').val(data[0].id);
                fetch_present_Prov();

                setTimeout(function ()
                {
                    $('#bi_present_municipality').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

function fetch_present_Prov()
{
    present_muniID = $('#bi_present_idProvince').val();
    present_originalMuniID = $('#bi_present_idMunicipality').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': present_muniID,
                'originalMuniID': present_originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_present_Prov').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_present_Prov').html('');
            $('#bi_present_province').val('');
            $('#bi_present_province').val(data[0][0].name);
        }
    });
}

$('#bi_permanent_municipality').autocomplete
({
    source: '/fetch-city-muni',
    minLength: 1,
    select: function (event, ui)
    {
        $('#bi_permanent_idProvince').val('');
        $('#bi_permanent_idMunicipality').val('');
        $('#bi_permanent_idProvince').val(ui.item.muniID);
        $('#bi_permanent_idMunicipality').val(ui.item.originalMuniID);
        var clearTime = setInterval(function ()
        {
            fetch_permanent_Prov();
            clearInterval(clearTime);
        },10)
    }
});

$('#bi_permanent_municipality').focusout(function ()
{
    if($('#bi_permanent_municipality').val() === '')
    {
        $('#bi_permanent_province').val('');
    }
    else
    {
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#bi_permanent_municipality').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#bi_permanent_idProvince').val(data[0].province_id);
                $('#bi_permanent_idMunicipality').val(data[0].id);
                fetch_permanent_Prov();

                setTimeout(function ()
                {
                    $('#bi_permanent_municipality').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

function fetch_permanent_Prov()
{
    permenant_muniID = $('#bi_permanent_idProvince').val();
    permanent_originalMuniID = $('#bi_permanent_idMunicipality').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': permenant_muniID,
                'originalMuniID': permanent_originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_permanent_Prov').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_permanent_Prov').html('');
            $('#bi_permanent_province').val('');
            $('#bi_permanent_province').val(data[0][0].name);
        }
    });
}
maiden_trigger_gender = false;
maiden_trigger_status = false;

func_gender_marital();
function func_gender_marital() {

    $('.acct_gender').change(function () {
        var value = $(this).val();
        // var count = $(this).attr('name');

        if(value == 'Female')
        {
            maiden_trigger_gender = true;
            if(maiden_trigger_status)
            {
                $('#if_married_check').show();
            }
        }
        else
        {
            $('#if_married_check').hide();
            $('#acct_maiden_last_name').val('');
            $('#acct_maiden_first_name').val('');
            $('#acct_maiden_middle_name').val('');
            maiden_trigger_gender = false;
        }

    });

    $('.acct_marital_status').change(function () {
        var value = $(this).val();
        // var count = $(this).attr('name');

        if(value == 'Married')
        {
            if(maiden_trigger_gender)
            {
                $('#if_married_check').show();
            }
            maiden_trigger_status=true;
        }
        else
        {
            $('#if_married_check').hide();
            $('#acct_maiden_last_name').val('');
            $('#acct_maiden_first_name').val('');
            $('#acct_maiden_middle_name').val('');
            maiden_trigger_status = false;
        }
    });
}
var cob_array = [];

$('#btn_bi_submit_endorsement').click(function ()
{

    var if_direct = $(this).attr('typee');
    var accountAge = $('#acct_birthdate_age').val();
    var this_button = $(this);
    var if_no_attachment = 0;
    var type_cc_bank = $(this).attr('name');
    var type_endo = '';
    var accnt_sss = '';
    var accnt_philhealth = '';
    var accnt_pag_ibig = '';
    var accnt_tin = '';

    if(if_direct == 'direct')
    {
        accnt_sss = $('#accnt_sss_num').val();
        accnt_philhealth = $('#accnt_philhealth_num').val();
        accnt_pag_ibig = $('#accnt_pag_ibig_number').val();
        accnt_tin = $('#accnt_tin_number').val();
    }
    else
    {
        accnt_sss = '';
        accnt_philhealth = '';
        accnt_pag_ibig = '';
        accnt_tin = '';
    }

    $('.type_of_endo_main').each(function()
    {
        if($(this).is(':checked'))
        {
            console.log($(this).val());
            type_endo = $(this).val();
        }
    });

    $('.bi_attached_file').each(function () {

        if($(this).val() != '')
        {
            if_no_attachment++;
        }
    });


    if(accountAge < 18)
    {
        var warningAge = confirm('Subject does not meet the age requirements or field is empty/null, are you sure to submit the endorsement');

        if(warningAge == true)
        {
            checkingIfSameFileName();
        }
        else
        {
            console.log('do nothing');
        }
    }
    else
    {
        checkingIfSameFileName();
    }

    function endorseAccountFunc()
    {
        var addittionaAddressArray = [];
        var addittionaMuniArray = [];
        var addittionaProvinceArray = [];
        var other_address_to_pass = [];
        var required_field = '';

        if(!required_fieldBool)
        {
            required_field = if_no_check === 0 || $('#acct_last').val() == '' || $('#acct_first').val() == '' || $('#acct_endorsedby').val() == '' || $('#bi_present_address').val() == '' || $('#bi_present_municipality').val() == '' || $('#bi_permanent_address').val() == '' || $('#bi_permanent_municipality').val() == '' ||
                $('#bi_permanent_municipality').val() == '' || $('#acct_birthdate_day').val() == '-' || $('#acct_birthdate_month').val() == '-' || $('#acct_birthdate_year').val() == '-';
        }
        else {
            required_field = if_no_check === 0 || $('#acct_last').val() == '' || $('#acct_first').val() == '' || $('#acct_endorsedby').val() == '' || $('#acct_birthdate_day').val() == '-' || $('#acct_birthdate_month').val() == '-' || $('#acct_birthdate_year').val() == '-';
        }

        if(what_to_submit == 'cc_bi')
        {

            var if_no_check = 0;

            var checkin_array = [];
            var checkin_array_kind = [];
            var j;


            $('.check_list_checking').each(function ()
            {
                if($(this).is(":checked"))
                {
                    checkin_array[if_no_check] = $(this).val();
                    checkin_array_kind[if_no_check] = $(this).attr('name');
                    if_no_check++
                }
            });

            var count_address1 = 0;

            $('.additionalAddressBi').each(function ()
            {
                count_address1++;
            });

            if(count_address1 != 0)
            {
                for(j = 0; j < count_address1; j++)
                {
                    addittionaAddressArray[j] = $('#bi_other_address-'+(j+1)+'').val();
                    addittionaMuniArray[j] = $('#bi_other_idMunicipality-'+(j+1)+'').val();
                    addittionaProvinceArray[j] = $('#bi_other_idProvince-'+(j+1)+'').val();
                }

                other_address_to_pass = 'qq';
            }
            else
            {
                other_address_to_pass = ['no_other_address']
            }




            if(if_no_check === 0 || if_no_attachment === 0 || $('#acct_last').val() == '' || $('#acct_first').val() == '' || $('#acct_endorsedby').val() == '' || $('#bi_present_address').val() == '' || $('#bi_present_municipality').val() == '' || $('#bi_permanent_address').val() == '' || $('#bi_permanent_municipality').val() == '' || $('#acct_birthdate_day').val() == '-' || $('#acct_birthdate_month').val() == '-' || $('#acct_birthdate_year').val() == '-')
            {
                $('#modal_inc').modal('show');
            }
            else
            {
                this_button.attr('disabled','disabled');

                var fname = $('#acct_first').val();
                var mname = $('#acct_middle').val();
                var lname = $('#acct_last').val();

                fname = fname.replace(/[^a-zA-Z ]/g, "");
                mname = mname.replace(/[^a-zA-Z ]/g, "");
                lname = lname.replace(/[^a-zA-Z ]/g, "");

                console.log(fname +  ', ' + mname + ', ' + lname);

                $.ajax
                ({

                    url : 'bi_submit_endorsement',
                    type : 'post',
                    data : {
                        'bi_account' : $('#bi_account').val(),
                        'bi_id' : $('#bi_account').attr('name'),
                        'bi_project_name' : $('#project_name').val(),
                        'bi_account_lob' : $('#bi_account_lob').val(),
                        'type_package' : $('#type_package').find('option:selected').attr("name"),
                        'acct_last' : lname,
                        'acct_first' : fname,
                        'acct_middle' : mname,
                        'acct_suffix' : $('#acct_suffix').val(),
                        'acct_gender' : $('#acct_gender').val(),
                        'acct_marital_status' : $('#acct_marital_status').val(),
                        'acct_birthdate_day' : $('#acct_birthdate_day').val(),
                        'acct_birthdate_month' : $('#acct_birthdate_month').val(),
                        'acct_birthdate_year' : $('#acct_birthdate_year').val(),
                        'acct_birthdate_age' : $('#acct_birthdate_age').val(),
                        'acct_citizenship' : $('#acct_citizenship').val(),
                        'acct_maiden_last_name' : $('#acct_maiden_last_name').val(),
                        'acct_maiden_first_name' : $('#acct_maiden_first_name').val(),
                        'acct_maiden_middle_name' : $('#acct_maiden_middle_name').val(),
                        'bi_present_address' : $('#bi_present_address').val(),
                        'bi_present_idProvince' : $('#bi_present_idProvince').val(),
                        'bi_present_idMunicipality' : $('#bi_present_idMunicipality').val(),
                        'bi_permanent_address' : $('#bi_permanent_address').val(),
                        'bi_permanent_idProvince' : $('#bi_permanent_idProvince').val(),
                        'bi_permanent_idMunicipality' : $('#bi_permanent_idMunicipality').val(),
                        'acct_endorsedby' : $('#acct_endorsedby').val(),
                        'checking_array' : checkin_array,
                        'checkin_array_kind' : checkin_array_kind,
                        'tat_type' : '-',
                        'other_address' : other_address_to_pass,
                        'other_address_add' : addittionaAddressArray,
                        'other_muni_add' : addittionaMuniArray,
                        'other_prov_add' : addittionaProvinceArray,
                        'type_endo' : '',
                        'if_direct' : if_direct,
                        'accnt_sss' : accnt_sss,
                        'accnt_philhealth' : accnt_philhealth,
                        'accnt_pag_ibig' : accnt_pag_ibig,
                        'accnt_tin' : accnt_tin,
                        'accnt_dealership': '',
                        'accnt_number' : ''
                    },
                    beforeSend : function () {
                        $('#modal_loading').modal('show');
                    },
                    success : function (data)
                    {
                        console.log(data);
                        if(data == 'double')
                        {
                            this_button.removeAttr('disabled');
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            },500);
                            var timerError = setInterval(function ()
                            {
                                $('#modal-double-endorse').modal('show');
                                clearInterval(timerError);
                            }, 1000);

                        }
                        else if (data[0] == 'proceed_to_upload')
                        {
                            var formdata = new FormData();

                            formdata.append('file_1',$('#attach1').prop('files')[0]);
                            formdata.append('file_2',$('#attach2').prop('files')[0]);
                            formdata.append('file_3',$('#attach3').prop('files')[0]);
                            formdata.append('file_4',$('#attach4').prop('files')[0]);
                            formdata.append('endorse_id',data[1]);

                            uploadAttachEndo(formdata);
                        }
                        this_button.removeAttr('disabled');
                    },
                    error : function ()
                    {
                        this_button.removeAttr('disabled');
                        setTimeout(function () {
                            $('#modal_loading').modal('hide');
                        },500);
                        setTimeout(function () {
                            $('#modal_error').modal('show');
                        },1000);
                    }
                });
            }
        }
        else if(what_to_submit == 'cc_bi_sitel')
        {
            var if_no_check = 0;

            var checkin_array = [];
            var checkin_array_kind = [];

            $('.check_list_checking').each(function ()
            {
                if($(this).is(":checked"))
                {
                    checkin_array[if_no_check] = $(this).val();
                    checkin_array_kind[if_no_check] = $(this).attr('name');
                    if_no_check++
                }
            });

            var count_address = 0;

            $('.additionalAddressBi').each(function () {
                count_address++;
            });

            if(count_address != 0)
            {
                for(j = 0; j < count_address; j++)
                {
                    addittionaAddressArray[j] = $('#bi_other_address-'+(j+1)+'').val();
                    addittionaMuniArray[j] = $('#bi_other_idMunicipality-'+(j+1)+'').val();
                    addittionaProvinceArray[j] = $('#bi_other_idProvince-'+(j+1)+'').val();
                }

                other_address_to_pass = 'qq';
            }
            else
            {
                other_address_to_pass = ['no_other_address']
            }


            if(required_field)
            {
                $('#modal_inc').modal('show');
            }
            else
            {
                this_button.attr('disabled','disabled');

                var fname2 = $('#acct_first').val();
                var mname2 = $('#acct_middle').val();
                var lname2 = $('#acct_last').val();

                fname2.replace(/[^a-zA-Z ]/g, "");
                mname2.replace(/[^a-zA-Z]/g, "");
                lname2.replace(/[^a-zA-Z]/g, "");

                $.ajax
                ({

                    url : 'bi_submit_endorsement',
                    type : 'post',
                    data : {
                        'bi_account' : $('#bi_account').val(),
                        'bi_id' : $('#bi_account').attr('name'),
                        'bi_project_name' : $('#project_name').val(),
                        'bi_account_lob' : $('#bi_account_lob').val(),
                        'type_package' : $('#type_package').find('option:selected').attr("name"),
                        'acct_last' : lname2,
                        'acct_first' : fname2,
                        'acct_middle' : mname2,
                        'acct_suffix' : $('#acct_suffix').val(),
                        'acct_gender' : $('#acct_gender').val(),
                        'acct_marital_status' : $('#acct_marital_status').val(),
                        'acct_birthdate_day' : $('#acct_birthdate_day').val(),
                        'acct_birthdate_month' : $('#acct_birthdate_month').val(),
                        'acct_birthdate_year' : $('#acct_birthdate_year').val(),
                        'acct_birthdate_age' : $('#acct_birthdate_age').val(),
                        'acct_citizenship' : $('#acct_citizenship').val(),
                        'acct_maiden_last_name' : $('#acct_maiden_last_name').val(),
                        'acct_maiden_first_name' : $('#acct_maiden_first_name').val(),
                        'acct_maiden_middle_name' : $('#acct_maiden_middle_name').val(),
                        'bi_present_address' : $('#bi_present_address').val(),
                        'bi_present_idProvince' : $('#bi_present_idProvince').val(),
                        'bi_present_idMunicipality' : $('#bi_present_idMunicipality').val(),
                        'bi_permanent_address' : $('#bi_permanent_address').val(),
                        'bi_permanent_idProvince' : $('#bi_permanent_idProvince').val(),
                        'bi_permanent_idMunicipality' : $('#bi_permanent_idMunicipality').val(),
                        'acct_endorsedby' : $('#acct_endorsedby').val(),
                        'checking_array' : checkin_array,
                        'checkin_array_kind' : checkin_array_kind,
                        'tat_type' : $('#bi_account_tat').find(':selected').val(),
                        'other_address' : other_address_to_pass,
                        'other_address_add' : addittionaAddressArray,
                        'other_muni_add' : addittionaMuniArray,
                        'other_prov_add' : addittionaProvinceArray,
                        'type_endo' : '',
                        'if_direct' : if_direct,
                        'accnt_dealership': '',
                        'accnt_number' : ''

                    },
                    beforeSend : function () {
                        $('#modal_loading').modal('show');
                    },
                    success : function (data)
                    {
                        console.log(data);

                        if(data == 'double')
                        {
                            this_button.removeAttr('disabled');
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            },500);
                            var timerError = setInterval(function ()
                            {
                                $('#modal-double-endorse').modal('show');
                                clearInterval(timerError);
                            }, 1000);
                        }
                        else if (data[0] == 'proceed_to_upload')
                        {
                            var formdata1 = new FormData();

                            formdata1.append('file_1',$('#attach1').prop('files')[0]);
                            formdata1.append('file_2',$('#attach2').prop('files')[0]);
                            formdata1.append('file_3',$('#attach3').prop('files')[0]);
                            formdata1.append('file_4',$('#attach4').prop('files')[0]);
                            formdata1.append('endorse_id',data[1]);

                            uploadAttachEndo(formdata1);
                        }
                    },
                    error : function ()
                    {
                        this_button.removeAttr('disabled');
                        setTimeout(function () {
                            $('#modal_loading').modal('hide');
                        },500);
                        setTimeout(function () {
                            $('#modal_error').modal('show');
                        },1000);
                    }
                });
            }
        }
        else if(what_to_submit == 'cc_bank')
        {
            if(type_cc_bank == 'PDRN')
            {
                if(if_no_check === 0 || if_no_attachment === 0 || $('#acct_last_pdrn').val() == '' || $('#acct_first_pdrn').val() == '')
                {
                    $('#modal_inc').modal('show');
                }
                else
                {
                    var count_cob = $('#btn_bi_submit_endorsement').attr('href');
                    var countIndex;

                    // console.log('before if else: '+count_cob);

                    if(count_cob >= 1)
                    {
                        for(i = 0; i < count_cob ; i++)
                        {
                            cob_array[i] = [];
                            countIndex = 0;
                            $('.cobEachPDRN-'+ i +'').each(function()
                            {
                                cob_array[i][countIndex] = $(this).val();
                                countIndex++;
                            });
                        }
                        // console.log('this is array for pdrn: '+cob_array);
                    }
                }

                $.ajax
                ({
                    type : 'post',
                    url : 'bi-pdrn-endorse-submit',
                    data :
                        {
                            'party_num' : $('#party_num').val(),
                            'contract_num' : $('#contract_num').val(),
                            'id_present_muni' : $('#idPresentMuni').val(),
                            'id_present_prov' : $('#idPresentProv').val(),
                            'id_perma_muni' : $('#idPermaMuni').val(),
                            'id_prema_prov' : $('#idPermaProv').val(),
                            'acct_last' : $('#acct_last_pdrn').val(),
                            'acct_first' : $('#acct_first_pdrn').val(),
                            'acct_middle' : $('#acct_middle_pdrn').val(),
                            'acct_suffix' : $('#acct_suffix_pdrn').val(),
                            'acct_gender' : $('#acct_gender_pdrn').val(),
                            'acct_marital_status' : $('#acct_marital_status_pdrn').val(),
                            'acct_birthdate_day' : $('#acct_birthdate_day_pdrn').val(),
                            'acct_birthdate_month' : $('#acct_birthdate_month_pdrn').val(),
                            'acct_birthdate_year' : $('#acct_birthdate_year_pdrn').val(),
                            'acct_birthdate_age' : $('#acct_birthdate_age_pdrn').val(),
                            'acct_citizenship' : $('#acct_citizenship_pdrn').val(),
                            'acct_maiden_last_name' : $('#acct_maiden_last_name_pdrn').val(),
                            'acct_maiden_first_name' : $('#acct_maiden_first_name_pdrn').val(),
                            'acct_maiden_middle_name' : $('#acct_maiden_middle_name_pdrn').val(),
                            'acct_endorsedby' : $('#acct_endorsedby_pdrn').val(),
                            'present_address' : $('#bi_present_address_pdrn').val(),
                            'perma_address' : $('#bi_permanent_address_pdrn').val(),
                            'load_type' : $('#loanType_pdrn').val(),
                            'priority_type' : $('#txtPrioritize_pdrn').val(),
                            'verify_through' : $('#txtVerifyThrough_pdrn').val(),
                            'client_remarks' : $('#txtClientRemarks_pdrn').val(),
                            'tat_type' : '-',
                            'cob_array' : cob_array,
                            'type_endo' : type_endo,
                            'accnt_dealership' : $('#accnt_dealership').val(),
                            'accnt_number' : $('#accnt_acntNumber').val()
                        },
                    beforeSend : function () {
                        $('#modal_loading').modal('show');
                    },
                    success : function (data)
                    {
                        console.log('return of pdrn'+data);
                        if (data[0] == 'proceed_to_upload')
                        {
                            var formdata = new FormData();

                            formdata.append('file_1',$('#attach1').prop('files')[0]);
                            formdata.append('file_2',$('#attach2').prop('files')[0]);
                            formdata.append('file_3',$('#attach3').prop('files')[0]);
                            formdata.append('file_4',$('#attach4').prop('files')[0]);
                            formdata.append('endorse_id',data[1]);

                            uploadAttachEndo(formdata);
                        }
                    },
                    error : function ()
                    {
                        this_button.removeAttr('disabled');
                        setTimeout(function () {
                            $('#modal_loading').modal('hide');
                        },500);
                        setTimeout(function () {
                            $('#modal_error').modal('show');
                        },1000);
                    }
                });
            }
            else if(type_cc_bank == 'BVR')
            {
                var count_bus = $('#btn_bi_submit_endorsement').attr('href');
                if(if_no_attachment === 0 || $('#acctFNameBVR').val() == '' || $('#acctMNameBVR').val() == '' || $('#acctLNameBVR').val() == '' ||  $('#requestorNameBVR') == '' ||  count_bus == null)
                {
                    $('#modal_inc').modal('show');
                }
                else
                {
                    var countIndexBVR = 0;

                    if(count_bus != null)
                    {
                        for (var i = 0; i < count_bus; i++) {
                            cob_array[i] = [];
                            countIndexBVR = 0;
                            $('.busNameEach-' + i + '').each(function () {
                                cob_array[i][countIndexBVR] = $(this).val();
                                countIndexBVR++;
                            })
                        }
                    }
                    else
                    {

                    }
                    console.log(cob_array);

                    $.ajax
                    ({
                        type : 'post',
                        url : 'bi-client-bvr-endorse-submit',
                        data :
                            {   'party_num' : $('#party_num').val(),
                                'contract_num' : $('#contract_num').val(),
                                'acct_fname' : $('#acctFNameBVR').val(),
                                'acct_mname' : $('#acctMNameBVR').val(),
                                'acct_lname' : $('#acctLNameBVR').val(),
                                'present_address' : $('#bi_present_address_bvr').val(),
                                'present_muni' : $('#idPresentMuniBvr').val(),
                                'present_prov' : $('#idPresentProvBvr').val(),
                                'perma_address' : $('#bi_permanent_address_bvr').val(),
                                'perma_muni' : $('#idPermaMuniBvr').val(),
                                'perma_prov' : $('#idPermaProvBvr').val(),
                                'loan_type' : $('#loanTypeBVR').val(),
                                'prio_type' : $('#txtPrioritizeBVR').val(),
                                'verify_through' : $('#txtVerifyThroughBVR').val(),
                                'client_rem'  : $('#txtClientRemarksBVR').val(),
                                'requestor_name' : $('#requestorNameBVR').val(),
                                'cob_array' : cob_array,
                                'type_endo' : type_endo,
                                'accnt_dealership' : $('#accnt_dealership').val(),
                                'accnt_number' : $('#accnt_acntNumber').val()
                            },
                        beforeSend : function () {
                            $('#modal_loading').modal('show');
                        },
                        success : function (data)
                        {
                            console.log(data);

                            if (data[0] == 'proceed_to_upload')
                            {
                                var formdata = new FormData();

                                formdata.append('file_1',$('#attach1').prop('files')[0]);
                                formdata.append('file_2',$('#attach2').prop('files')[0]);
                                formdata.append('file_3',$('#attach3').prop('files')[0]);
                                formdata.append('file_4',$('#attach4').prop('files')[0]);
                                formdata.append('endorse_id',data[1]);

                                uploadAttachEndo(formdata);
                            }
                        },
                        error : function ()
                        {
                            this_button.removeAttr('disabled');
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            },500);
                            setTimeout(function () {
                                $('#modal_error').modal('show');
                            },1000);
                        }
                    });
                }
            }
            else if(type_cc_bank == 'EVR')
            {
                var count_emp = $('#btn_bi_submit_endorsement').attr('href');

                if(if_no_attachment === 0 || $('#acctFNameEVR').val() == '' || $('#acctMNameEVR').val() == '' || $('#acctLNameEVR').val() == '' ||  $('#requestorNameEVR') == '' || count_emp == null)
                {
                    $('#modal_inc').modal('show');
                }
                else
                {
                    var countIndexEVR = 0;

                    if(count_emp != null)
                    {
                        for(var i = 0; i < count_emp ; i++)
                        {
                            cob_array[i] = [];
                            countIndexEVR = 0;
                            $('.evr_emp-'+i+'').each(function()
                            {
                                cob_array[i][countIndexEVR] = $(this).val();
                                countIndexEVR++;
                            });
                        }
                    }
                    else
                    {

                    }
                    console.log(cob_array);

                    $.ajax
                    ({
                        type : 'post',
                        url : 'bi-client-evr-submit-endorse',
                        data :
                            {   'party_num' : $('#party_num').val(),
                                'contract_num' : $('#contract_num').val(),
                                'acct_fname' : $('#acctFNameEVR').val(),
                                'acct_mname' : $('#acctMNameEVR').val(),
                                'acct_lname' : $('#acctLNameEVR').val(),
                                'present_address' : $('#bi_present_address_evr').val(),
                                'present_muni' : $('#idPresentMuniEvr').val(),
                                'present_prov' : $('#idPresentProvEvr').val(),
                                'perma_address' : $('#bi_permanent_address_evr').val(),
                                'perma_muni' : $('#idPermaMuniEvr').val(),
                                'perma_prov' : $('#idPermaProvEvr').val(),
                                'loan_type' : $('#loanTypeEVR').val(),
                                'prio_type' : $('#txtPrioritizeEVR').val(),
                                'verify_through' : $('#txtVerifyThroughEVR').val(),
                                'client_rem'  : $('#txtClientRemarksEVR').val(),
                                'requestor_name' : $('#requestorNameEVR').val(),
                                'cob_array' : cob_array,
                                'type_endo' : type_endo,
                                'accnt_dealership' : $('#accnt_dealership').val(),
                                'accnt_number' : $('#accnt_acntNumber').val()
                            },
                        beforeSend : function ()
                        {
                            $('#modal_loading').modal('show');
                        },
                        success : function (data)
                        {
                            console.log(data);

                            if (data[0] == 'proceed_to_upload')
                            {
                                var formdata = new FormData();

                                formdata.append('file_1',$('#attach1').prop('files')[0]);
                                formdata.append('file_2',$('#attach2').prop('files')[0]);
                                formdata.append('file_3',$('#attach3').prop('files')[0]);
                                formdata.append('file_4',$('#attach4').prop('files')[0]);
                                formdata.append('endorse_id',data[1]);

                                uploadAttachEndo(formdata);
                            }
                        }

                    });
                }
            }
        }
    }

    function checkingIfSameFileName()
    {
        var attachfile1 = $('#attach1').val();
        var attachfile2 = $('#attach2').val();
        var attachfile3 = $('#attach3').val();
        var attachfile4 = $('#attach4').val();
        var attach_1_has_file = false;
        var attach_2_has_file = false;
        var attach_3_has_file = false;
        var attach_4_has_file = false;
        var has_same_file = false;



        // if(attachfile1 == '' || attachfile2 == '' || attachfile3 == '' || attachfile4 == '')
        // {
        //     alert('Please upload a file');
        // }
        // else

        if(attachfile1 != '')
        {
            attach_1_has_file = true;

            if(attachfile2 == attachfile1)
            {
                has_same_file = true;
            }

            if(attachfile3 == attachfile1)
            {
                has_same_file = true;
            }

            if(attachfile4 == attachfile1)
            {
                has_same_file = true;
            }
        }
        if(attachfile2 != '')
        {
            attach_2_has_file = true;

            if(attachfile1 == attachfile2)
            {
                has_same_file = true;
            }

            if(attachfile3 == attachfile2)
            {
                has_same_file = true;
            }

            if(attachfile4 == attachfile2)
            {
                has_same_file = true;
            }
        }
        if(attachfile3 != '')
        {
            attach_3_has_file = true;

            if(attachfile2 == attachfile3)
            {
                has_same_file = true;
            }

            if(attachfile1 == attachfile3)
            {
                has_same_file = true;
            }

            if(attachfile4 == attachfile3)
            {
                has_same_file = true;
            }
        }
        if(attachfile4 != '')
        {
            attach_4_has_file = true;

            if(attachfile2 == attachfile4)
            {
                has_same_file = true;
            }

            if(attachfile3 == attachfile4)
            {
                has_same_file = true;
            }

            if(attachfile1 == attachfile4)
            {
                has_same_file = true;
            }
        }


        if(attach_1_has_file || attach_2_has_file || attach_3_has_file || attach_4_has_file)
        {

            if(has_same_file == false)
            {
                endorseAccountFunc();
            }
            else
            {

                alert('Some file has the same name please check the files for upload');

                // console.log('do nothing di mageendorse');
            }
        }
        else
        {
            // alert('Please upload a file');
            endorseAccountFunc();
            // console.log('do nothing di mageendorse');
        }
    }
});

function uploadAttachEndo(form)
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
                    $('#ulPercentage_attachment').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_attachment').append(Math.floor(percentComplete*100));
                    $('#progressbar_attachment').show();

                    $('#progressbar_attachment').progressbar
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
            }, false);
            return xhr;
        },
        url: 'bi_submit_endorsement_files',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        success: function (data)
        {
            // this_button.removeAttr('disabled');
            $('#ulPercentage_attachment').html('');
            $('#progressbar_attachment').hide();

            console.log(data);

            clear(data[0].type_of_endorsement_bank);
            setTimeout(function () {
                $('#modal_loading').modal('hide');
            },1000);
            setTimeout(function () {
                $('#modal_success').modal('show');
            },1500);
            getDash();
            countSendBI = true;
            cob_array = [];
            $('#addAdditionalAddressBi').html('');
        },
        error: function () {
            $('#btn_bi_submit_endorsement').removeAttr('disabled');
            setTimeout(function () {
                $('#modal_loading').modal('hide');
            },500);
            setTimeout(function () {
                $('#modal_error').modal('show');
            },1000);
        }
    });
}

function clear(type) {

    $('#party_num').val('');
    $('#contract_num').val('');
    $('#type_package').val('-');
    $('#type_package').trigger('change');
    // $('#bi_account').val('');
    $('#project_name').val('');
    $('#bi_account_lob').val('-');
    $('#acct_last').val('');
    $('#acct_first').val('');
    $('#acct_middle').val('');
    $('#acct_suffix').val('');
    $('#acct_gender').val('-');
    $('#acct_marital_status').val('-');
    $('#acct_marital_status').trigger('change');
    $('#acct_birthdate_day').val('-');
    $('#acct_birthdate_month').val('-');
    $('#acct_birthdate_year').val('-');
    $('#acct_birthdate_age').val('');
    $('#acct_citizenship').val('');
    $('#acct_maiden_last_name').val('');
    $('#acct_maiden_first_name').val('');
    $('#acct_maiden_middle_name').val('');
    $('#bi_present_address').val('');
    $('#bi_present_idProvince').val('');
    $('#bi_present_province').val('');
    $('#bi_present_idMunicipality').val('');
    $('#bi_present_municipality').val('');
    $('#bi_permanent_address').val('');
    $('#bi_permanent_idProvince').val('');
    $('#bi_permanent_province').val('');
    $('#bi_permanent_idMunicipality').val('');
    $('#bi_permanent_municipality').val('');
    $('#acct_endorsedby').val('');
    $('#attach1').val('');
    $('#attach2').val('');
    $('#attach3').val('');
    $('#attach4').val('');
    $('#bi_check_same_address').prop('checked',false);
    $('#bi_check_same_address').trigger('change');

    $('#idPresentMuni').val('');
    $('#idPresentProv').val('');
    $('#idPermaMuni').val('');
    $('#idPermaProv').val('');
    $('#acct_last_pdrn').val('');
    $('#acct_first_pdrn').val('');
    $('#acct_middle_pdrn').val('');
    $('#acct_suffix_pdrn').val();
    $('#acct_gender_pdrn').val();
    $('#acct_marital_status_pdrn').val('-');
    $('#acct_birthdate_day_pdrn').val('-');
    $('#acct_birthdate_month_pdrn').val('-');
    $('#acct_birthdate_year_pdrn').val('-');
    $('#acct_birthdate_age_pdrn').val('-');
    $('#acct_citizenship_pdrn').val('');
    $('#acct_maiden_last_name_pdrn').val('');
    $('#acct_maiden_first_name_pdrn').val('');
    $('#acct_maiden_middle_name_pdrn').val('');
    $('#acct_endorsedby_pdrn').val('');
    $('#bi_present_address_pdrn').val('');
    $('#bi_permanent_address_pdrn').val('');
    $('#loanType_pdrn').val('----(Undefined)');
    $('#txtPrioritize_pdrn').val('Regular');
    $('#txtVerifyThrough_pdrn').val('Non Discreet');
    $('#txtClientRemarks_pdrn').val('');
    $('#bi_present_municipality_pdrn').val('');
    $('#bi_present_province_pdrn').val('');
    $('#bi_permanent_municipality_pdrn').val('');
    $('#bi_permanent_province_pdrn').val('');
    $('#bi_present_municipality_pdrn').removeAttr('disabled');
    $('#bi_permanent_municipality_pdrn').removeAttr('disabled');
    $('#bi_pdrn_coborrower_count').val('0');
    $('#bi_check_same_address_pdrn').prop("checked", false);
    $('#bi_permanent_address_pdrn').removeAttr('disabled');
    $('#acctFNameBVR').val('');
    $('#acctMNameBVR').val('');
    $('#acctLNameBVR').val('');
    $('#acct_suffix_pdrn').val('');
    $('#acct_gender_pdrn').val('');
    $('#bi_present_address_bvr').val('');
    $('#bi_present_municipality_bvr').val();
    $('#bi_present_province_bvr').val('');
    $('#bi_check_same_address_bvr').prop("checked", false);
    $('#bi_permanent_address_bvr').val('');
    $('#bi_permanent_municipality_bvr').val('');
    $('#bi_permanent_province_bvr').val('');
    $('#busName-0').val('');
    $('#addressBus-0').val('');
    $('#municipalityBus-0').val('');
    $('#provinceBus-0').val('');
    $('#loanTypeBVR').val('----(Undefined)');
    $('#txtPrioritizeBVR').val('Regular');
    $('#txtVerifyThroughBVR').val('Non Discreet');
    $('#txtClientRemarksBVR').val('');
    $('#requestorNameBVR').val('');
    $('#acctFNameEVR').val('');
    $('#acctMNameEVR').val('');
    $('#acctLNameEVR').val('');
    $('#bi_present_address_evr').val('');
    $('#bi_present_municipality_evr').val('');
    $('#bi_present_province_evr').val('');
    $('#bi_check_same_address_evr').prop("checked", false);
    $('#bi_permanent_address_evr').val('');
    $('#bi_permanent_municipality_evr').val('');
    $('#bi_permanent_province_evr').val('');
    $('#bi_permanent_address_evr').removeAttr('disabled');
    $('#bi_permanent_municipality_evr').removeAttr('disabled');
    $('#evrEmpName-0').val('');
    $('#addressEmp-0').val('');
    $('#municipalityEmp-0').val('');
    $('#provinceEmp-0').val('');
    $('#loanTypeEVR').val('----(Undefined)');
    $('#txtPrioritizeEVR').val('Regular');
    $('#txtVerifyThroughEVR').val('Non Discreet');
    $('#txtClientRemarksEVR').val('');
    $('#requestorNameEVR').val('');
    $('#bi_present_municipality_bvr').val('');
    $('#bi_permanent_address_bvr').val('');
    $('#bi_permanent_municipality_bvr').val('')

    if(type == 'PDRN')
    {
        $('#bi_addCob_pdrn').html('');
    }

    $('#btn_bi_submit_endorsement').removeAttr('disabled');

}

$('#bi_client_return_table').on('click','.btn_upload_return', function () {

    var id = $(this).attr('id');
    var attach_number = $(this).attr('name');
    var button = $(this);

    $('#upload-'+id+'-'+attach_number+'').click();
    $('#upload-'+id+'-'+attach_number+'').change(function () {
        if($(this).val().length >= 1)
        {
            button.html($(this)[0].files[0].name);

        }
        else
        {
            button.html('Attach File');
        }

    });

});

$('#bi_client_return_table').on('click','.btn_upload_remove', function () {

    var id = $(this).attr('id');
    var remove_number = $(this).attr('name');
    var button = $(this);

    var get_attachment = $('#p-'+id+'-'+remove_number+'').html();

    var conform_remove = prompt("Are you sure to remove this attached file? Please indicate your reason.",'-');
    if (conform_remove == null || conform_remove == "")
    {

    }
    else
    {
        $.ajax
        ({
            url: 'bi_remove_attachment_logs',
            type: 'post',
            data: {
                'id' : id,
                'get_attachment' : get_attachment,
                'remarks': conform_remove,
                'pang_ilang_attachment' : remove_number
            },
            success : function (data) {

                $('#span-'+id+'-'+remove_number+'').html('' +
                    remove_number+'. none<br><a class="btn_upload_return btn btn-xs btn-info btn-block" data-toggle="modal" style="display: ;" id="'+id+'" name="'+remove_number+'" data-target="">' +
                    '<i class="glyphicon glyphicon-upload-alt"></i> Attach File</a>'+
                    '<input type="file" name="" id="upload-'+id+'-'+remove_number+'" style="display: none;">');

                $('#upload-'+id+'-'+remove_number+'').val('');

                $('#p-'+id+'-'+remove_number+'').remove();
                button.remove();
            },
            error: function () {
                console.log('errer');
            }
        });
        // console.log(get_attachment);
    }

});

$('#bi_client_return_table').on('click','.btn_re_endorse_edit',function () {

    var id = $(this).attr('id');

    $(this).css('display','none');

    $('.btn_upload_return').each(function () {

        if(id == $(this).attr('id'))
            (
                $(this).css('display','')
            )

    });

    $('.btn_upload_remove').each(function () {

        if(id == $(this).attr('id'))
            (
                $(this).css('display','')
            )

    });

    $('.btn_re_endorse').each(function () {
        if(id == $(this).attr('id'))
            (
                $(this).css('display','')
            )
    });
    $('.btn_re_endorse_edit_cancel').each(function () {
        if(id == $(this).attr('id'))
            (
                $(this).css('display','')
            )
    });
});

$('#bi_client_return_table').on('click','.btn_re_endorse_edit_cancel', function () {

    var id = $(this).attr('id');
    $(this).css('display','none');
    $('.btn_re_endorse_edit').each(function () {
        if(id == $(this).attr('id'))
            (
                $(this).css('display','')
            )
    });
    $('.btn_re_endorse').each(function () {
        if(id == $(this).attr('id'))
            (
                $(this).css('display','none')
            )
    });
    $('.btn_upload_return').each(function () {

        if(id == $(this).attr('id'))
            (
                $(this).css('display','none')
            )

    });
});

$('#bi_client_return_table').on('click','.btn_re_endorse',function () {

    var id = $(this).attr('id');
    console.log(id);
    var formdata_files;

    formdata_files = new FormData();


    // var temp = table_return.row(0).data();
    // temp[0] = 'Tom';
    // table_return.row(0).data(temp).invalidate();

    var remarks = prompt("Your Remarks:",'-');
    if (remarks == null || remarks == "")
    {

    }
    else
    {
        formdata_files.append('file_1',$('#upload-'+id+'-1').prop('files')[0]);
        formdata_files.append('file_2',$('#upload-'+id+'-2').prop('files')[0]);
        formdata_files.append('file_3',$('#upload-'+id+'-3').prop('files')[0]);
        formdata_files.append('file_4',$('#upload-'+id+'-4').prop('files')[0]);
        formdata_files.append('id',id);
        formdata_files.append('remarks',remarks);

        $.ajax({

            xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {

                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#ulPercentage_reupload-'+id+'').html('');
                        $('#ulPercentage_reupload-'+id+'').show();
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_reupload-'+id+'').append(Math.floor(percentComplete*100));
                        $('#progressbar_reupload-'+id+'').show();

                        $('#progressbar_reupload-'+id+'').progressbar
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
                }, false);
                return xhr;
            },
            url : 'bi_client_re_endorse',
            type : 'post',
            data : formdata_files,
            contentType: false,
            processData: false,
            success : function (data) {

                $('#progressbar_reupload-'+id+'').hide();
                $('#progressbar_reupload-'+id+'').html('');
                $('#ulPercentage_reupload-'+id+'').hide();
                $('#ulPercentage_reupload-'+id+'').html('');
                if(data == 'ok')
                {
                    alert('Done.');

                    table_return.ajax.reload();
                    table_general.ajax.reload();
                }
                else if(data == 'already')
                {
                    alert('Already re endorsed by someone. Please see logs.');
                    table_return.ajax.reload();
                    table_general.ajax.reload();
                }
            },
            error : function () {
                console.log('error');
            }
        });
    }
});

function bi_finish()
{
    $('#bi_client_finished_table thead th').each(function() {
        title_finished_h[title_finished_counts] = $(this).text();
        title_finished_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_finished = $('#bi_client_finished_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        // "ajax" : 'bi-client-table-finished',
        "ajax":
            {
                url: "bi-client-table-finished",
                data: function (d)
                {
                    d.min_date_endorsed = $('#fin_client_min').val();
                    d.max_date_endorsed = $('#fin_client_max').val();
                    d.search_methodd = $('input[name="finished_client_rad"]:checked').val();
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
                                        return title_general[(idx)];
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
                {data: 'party_num', name: 'bi_endorsements.party_num'},
                {data: 'contract_num', name: 'bi_endorsements.contract_num'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {
                    data : function tat(data)
                    {
                        if(data.status_report == 'Contacted' || data.status_report == 'Complete')
                        {
                            return '<a  id="'+data.endorse_id+'" class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i>'+data.status_report+'</a>';
                        }
                        else if(data.status_report == 'Uncontacted' || data.status_report == 'Partial')
                        {
                            return '<a  id="'+data.endorse_id+'" class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i>'+data.status_report+'</a>';
                        }
                        else if(data.status_report == 'Verified')
                        {
                            return '<a  id="'+data.endorse_id+'" class="btn btn-xs btn-success btn-block" disabled><i class="fa fa-fw fa-check-square"></i>'+data.status_report+'</a>';
                        }
                        else if(data.status_report == 'Unverified')
                        {
                            return '<a  id="'+data.endorse_id+'" class="btn btn-xs btn-danger btn-block" disabled><i class="fa fa-fw fa-check-square"></i>'+data.status_report+'</a>';
                        }
                    },
                    'name' : 'tat',
                    'searchable' : false,
                    'orderable' : false

                },
                {data : 'status' , name : 'bi_endorsements.date_time_finished', 'orderable' : false},
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return data.contact_details;
                            }
                        }
                        else if(data.tele_stat == 'Verified')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return data.contact_details;
                            }
                        }
                        else if(data.tele_stat == 'Unverified')
                        {
                            if(data.contact_details == null)
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return data.contact_details;
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
                    data : function action(data)
                    {
                        var viewFile_button = '<a class="btn_view_report_file btn btn-xs btn-primary btn-block" href="bi_client_view_finished_file?id='+btoa(data.endorse_id)+'" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View Report File</a>';
                        if(data.type_user == 'cc_bank')
                        {
                            if(data.status_report == 'Contacted')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                            else if(data.status_report == 'Uncontacted')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return for Update</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                            else if(data.status_report == 'Verified')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                            else if(data.status_report == 'Unverified')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                        }
                        else
                        {
                            if(data.status_report == 'Complete')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                            else if(data.status_report == 'Partial')
                            {
                                var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_return_after btn btn-xs btn-danger btn-block" name="'+data.status1+'"><i class="fa fa-fw fa-repeat"></i> Return for Update</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downReport"></span>';
                            }
                        }

                        return viewFile_button + act;
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

            if(what_to_submit =='cc_bank')
            {
                table_finished.column(1).visible(false);
                table_finished.column(6).visible(false);
                table_finished.column(7).visible(false);
                table_finished.column(12).visible(true);
            }
            else
            {
                table_finished.column(1).visible(true);
                table_finished.column(2).visible(false);
                table_finished.column(6).visible(true);
                table_finished.column(7).visible(true);
                table_finished.column(12).visible(false);
            }
        }
    });


    $('#bi_client_finished_table tbody').on('click', 'tr', function ()
    {
        var target1 = $(event.target);

        if($(this).hasClass('selected'))
        {
            if (target1.is('a'))
            {
                console.log('away')
            }
            else
            {
                $(this).removeClass('selected');
                var cntLaman = $.map(table_finished.rows('.selected').data(),function (item) {
                    return item.endorse_id
                });

                if(cntLaman.length > 1)
                {
                    $('#dlCountFinished').html(cntLaman.length);
                    $('#hideShowDlReports').fadeIn();
                }
                else
                {
                    $('#hideShowDlReports').fadeOut();
                }
            }
        }
        else
        {
            if (target1.is('a'))
            {
                console.log('away')
            }
            else
            {
                $(this).addClass('selected');

                var cntLaman = $.map(table_finished.rows('.selected').data(),function (item) {
                    // console.log(item);
                    return item.endorse_id
                });

                if(cntLaman.length > 1)
                {
                    $('#dlCountFinished').html(cntLaman.length);
                    $('#hideShowDlReports').fadeIn();
                }
                else
                {
                    $('#hideShowDlReports').fadeOut();
                }
            }
        }

    });


    $('#bi_client_finished_table_filter input').unbind();
    $('#bi_client_finished_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_finished.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_finished.search($(this).val()).draw();
                }
            }
        }
    });
}


$('#bi_client_finished_table').on('click', '.btn_view_report_remarks', function()
{
    var id = $(this).attr('id');
    $.ajax
    ({
        type : 'get',
        url : 'cc-sao-view-remarks',
        data:
            {
                'id' : id
            },
        success : function(data)
        {
            $('#bi_client_view_report_remarks').val(data);
            $('#modal-bi-view-report').modal('show');
        }
    });
});
$('#bi_client_finished_table').on('click', '.btn_down_report', function()
{
    var id = $(this).attr('id');

    var id_encode = btoa(id);
    var q = '<form action="/bi-client-dl-report-file" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<button type="submit" hidden id="button_rep_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#downReport').html(q);
    $('#button_rep_download').click();
    $('#downReport').hide();
});

$('.bi-client-dash-class').click(function () {
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tab_a') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_a';
        }
        else if (bi_client_gen) {
            console.log('already loaded');
            activeAcc = 'tab_a';
        }
        else if (bi_client_gen == false) {
            bi_client_gen = true;
            activeAcc = 'tab_a';
        }
    }
    else if (gethref == '#tab_b') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_b';
        }
        else if (bi_client_pen) {
            console.log('already loaded');
            activeAcc = 'tab_b';

        }
        else if (bi_client_pen == false) {
            bi_client_pen = true;
            activeAcc = 'tab_b';
            get_pending_table();
        }
    }
    else if (gethref == '#tab_c') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_c';
        }
        else if (bi_client_fin) {
            console.log('already loaded');
            activeAcc = 'tab_c';

        }
        else if (bi_client_fin == false) {
            bi_client_fin = true;
            activeAcc = 'tab_c';
            $.ajax
            ({
                type : 'get',
                url : 'bi-client-update-finished-stat',
                success : function()
                {
                    $('#notifFinished').hide();
                }
            });
            bi_finish();
        }
    }
    else if (gethref == '#tab_d') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_d';
        }
        else if (bi_client_ret) {
            console.log('already loaded');
            activeAcc = 'tab_d';
        }
        else if (bi_client_ret == false) {
            bi_client_ret = true;
            activeAcc = 'tab_d';
            $.ajax
            ({
                type : 'get',
                url : 'bi-client-update-return-stat',
                success : function()
                {
                    $('#notifReturned').hide();
                }
            });
            get_return_table();
        }
    }
    else if (gethref == '#tab_e') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_e';
        }
        else if (bi_client_cancel) {
            console.log('already loaded');
            activeAcc = 'tab_e';
        }
        else if (bi_client_cancel == false) {
            bi_client_cancel = true;
            activeAcc = 'tab_e';
            cancelTable();
        }
    }
    else if (gethref == '#tab_f') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeAcc = 'tab_f';
        }
        else if (bi_client_hold) {
            console.log('already loaded');
            activeAcc = 'tab_f';
        }
        else if (bi_client_hold == false) {
            bi_client_hold = true;
            activeAcc = 'tab_f';
            holdTable();
        }
    }
});

$('.bi_client_side_class').click(function () {
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#bi_client_endorse') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBiSide = 'bi_client_endorse';
        }
        else if (bi_side_en) {
            console.log('already loaded');
            activeBiSide = 'bi_client_endorse';
        }
        else if (bi_side_en == false) {
            bi_side_en = true;
            activeBiSide = 'bi_client_endorse';
        }
    }
    else if (gethref == '#bi_client_dash') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBiSide = 'bi_client_dash';
        }
        else if (bi_side_table) {
            $('#tabGeneralMon').click();
            if (countSendBI == true) {
                table_general.ajax.reload(null, false);
                countSendBI = false;
            }
            else {
                console.log('already loaded');
                activeBiSide = 'bi_client_dash';
            }
        }
        else if (bi_side_table == false) {
            bi_side_table = true;
            activeBiSide = 'bi_client_dash';
            $.ajax
            ({
                type: 'get',
                url: 'bi-client-return-notif',
                success: function (data) {
                    console.log(data);
                    if (data[0].finished_stat == 1) {
                        $('#notifFinished').show();
                    }
                    else {
                        $('#notifFinished').hide();
                    }

                    if (data[0].return_stat == 1) {
                        $('#notifReturned').show();
                    }
                    else {
                        $('#notifReturned').hide();
                    }
                }
            });
            getDash();
            get_general_table();
        }
    }
    else if (gethref == '#bi_client_billing') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeBiSide = 'bi_client_billing';
        }
        else if (billing_cc_bool) {
            console.log('already loaded');
            activeBiSide = 'bi_client_billing';
        }
        else if (billing_cc_bool == false) {
            bi_side_en = true;
            activeBiSide = 'bi_client_billing';
            getBillingTable();
        }
    }
});


$('#acct_birthdate_day').change(function()
{
    var endorse_day = $(this).val();
    var endorse_month = $('#acct_birthdate_month').val();
    var endorse_year = $('#acct_birthdate_year').val();

    if(endorse_month == '-' || endorse_year == '-')
    {
        console.log('Select complete date.');
    }
    else
    {
        $('#acct_birthdate_age').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
    }
});

$('#acct_birthdate_month').change(function()
{
    var endorse_month = $(this).val();
    var endorse_day = $('#acct_birthdate_day').val();
    var endorse_year = $('#acct_birthdate_year').val();

    if(endorse_day == '-' || endorse_year == '-')
    {
        console.log('Select complete date.');
    }
    else
    {
        $('#acct_birthdate_age').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
    }
});

$('#acct_birthdate_year').change(function()
{
    var endorse_year = $(this).val();
    var endorse_month = $('#acct_birthdate_month').val();
    var endorse_day = $('#acct_birthdate_day').val();

    if(endorse_month == '-' || endorse_day == '-')
    {
        console.log('Select complete date');
    }
    else
    {
        $('#acct_birthdate_age').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
    }
});

function calculate_age(date) {
    var diff_ms = Date.now() - date.getTime();
    var age_dt = new Date(diff_ms);

    return Math.abs(age_dt.getUTCFullYear() - 1970);
}
message_notif();
function message_notif()
{
    $.ajax
    ({
        type : 'get',
        url : 'bi-client-get-message-notif',
        success : function(data)
        {
            console.log(data);
            var mes = '';
            var count = 0;

            for(var ctr = 0; ctr<data[0].length; ctr++)
            {
                if(data[0][ctr].notif == 1)
                {
                    count++;
                }
                mes += '                              <li>' +
                    '                                    <a href="#" style="white-space: normal" >' +
                    '                                        <div class="pull-left">' +
                    '                                            <img src="dist/img/ccsi-icon.ico" class="img-circle">' +
                    '                                        </div>' +
                    '                                        <h4>' +
                    '                                            Account Officer' +
                    '                                           <small><i class="fa fa-clock-o"></i>'+data[0][ctr].created_at+'</small>'+
                    '                                        </h4>' +
                    '                                        <p>'+data[0][ctr].message+'</p>' +
                    '                                    </a>' +
                    '                                </li>';
            }
            $('#messages_bi').html(mes);

            if(data[1] == 1)
            {
                $('#count_all_message').html('You have '+count+' new messages.');
                $('#notifcount_message').html(count)
            }
            else
            {
                $('#count_all_message').html('You have 0 new messages.');
                $('#notifcount_message').html(0)
            }
        }
    });
}
$('#dropdownBiNotif').click(function()
{
    countclickNotif++;
    if(countclickNotif == 1)
    {
        if( $('#notifcount_message').html() != 0)
        {
            console.log('test1');
            $.ajax
            ({
                type : 'get',
                url : 'bi-client-del-notif',
                success : function(data)
                {
                    console.log(data);

                    $('#notifcount_message').html(0);

                    var checkMess = false;

                    for(var i = 0;i < data.length; i++)
                    {
                        if(data[i].message_notif == 1)
                        {
                            checkMess = true;
                        }
                    }
                    console.log(checkMess);
                    if(checkMess == false)
                    {
                        changeStatMessage();
                    }
                }
            });
        }
        else
        {

        }
    }
    else
    {
        $('#count_all_message').html('You have 0 new messages.');
    }
});
function changeStatMessage()
{
    $.ajax
    ({
        type : 'get',
        url : 'bi-client-change-mess-notif',
        success : function()
        {
            console.log('success');
        }
    })
}
function getDash()
{
    $.ajax
    ({
        type : 'get',
        url : 'bi-client-get-dash',
        success : function(data)
        {
            console.log(data);
            $('#gen_endorse_count').html(data[0]);
            $('#pending_account_count').html(data[1]);
            $('#finished_count').html(data[2]);
            $('#returned_account_count').html(data[3]);
            $('#hold_cancelled_count').html(data[4]);
        }
    });
}

$('#BtnuploadExcelBiBulk').click(function()
{
    var uploadExcel = $('#bulk_endorsement_excel').prop('files')[0];

    var formData = new FormData();
    formData.append('excel', uploadExcel);

    if(uploadExcel != null)
    {
        $.ajax
        ({
            type: 'post',
            url: 'bi-client-upload-bulk-excel',
            contentType: false,
            processData: false,
            async : true,
            data: formData,
            success : function(data)
            {

                arrayPackageToBulk = [];
                arrayBulkPackagesCheckLoop = [];

                applyBulkBool = false;
                $('#alert_show').hide();
                $('#alert_text').html('');


                if(boolCollapsePackCheck == true)
                {
                    $('#closeOpenPackCheck').click();
                }
                else
                {

                }

                console.log(data);

                var detailsBulk = data[0];

                for(var q = 0; q < data[2]; q++)
                {
                    if (q == 0)
                    {
                        detailsBulk[q].splice(2, 0, null, null, null, null, null, null, null, null);
                    }
                    else if (q == 1)
                    {
                        // detailsBulk[q].splice(0, 0, "ACTION");
                        detailsBulk[q].splice(2, 0, "ACCOUNT LAST NAME", "ACCOUNT FIRST NAME", 'ACCOUNT MIDDLE NAME');
                        detailsBulk[q].splice(8, 0, "MAIDEN LAST NAME", "MAIDEN FIRST NAME", 'MAIDEN MIDDLE NAME');
                        detailsBulk[q].splice(12, 0, "AGE");
                        detailsBulk[q].splice(15, 0, "PRESENT MUNICIPALITY", "PRESENT PROVINCE");
                        detailsBulk[q].splice(18, 0, "PERMANENT MUNICIPALITY", "PERMANENT PROVINCE");
                        detailsBulk[q].splice(22, 0, "PACKAGES", "CHECKINGS");
                        detailsBulk[q].splice(24, 0, "ATTACHMENT 1");
                        detailsBulk[q].splice(25, 0, "ATTACHMENT 2");
                        detailsBulk[q].splice(26, 0, "ATTACHMENT 3");
                        detailsBulk[q].splice(27, 0, "ATTACHMENT 4");
                    }
                    else
                    {
                        if(detailsBulk[q][4] != null)
                        {

                        }
                        else
                        {
                            detailsBulk[q][4] = '';
                        }
                        detailsBulk[q].splice(2, 0, '', '', '');
                        detailsBulk[q].splice(8, 0, '', '', '');

                        var dateNow = detailsBulk[q][11].date;

                        var newDAte1 = dateNow.split(' ');

                        var dateToget = newDAte1[0].split('-');

                        detailsBulk[q].splice(12, 0, calculate_age(new Date(dateToget[0], dateToget[1], dateToget[2])));
                        detailsBulk[q].splice(15, 0, "", "");
                        detailsBulk[q].splice(18, 0, "", "");
                        detailsBulk[q].splice(22, 0, "PACKAGES", "CHECKINGS");
                        detailsBulk[q].splice(24, 0, "ATTACHMENT");
                        detailsBulk[q].splice(25, 0, "ATTACHMENT");
                        detailsBulk[q].splice(26, 0, "ATTACHMENT");
                        detailsBulk[q].splice(27, 0, "ATTACHMENT");
                        // detailsBulk[q].splice(0, 0, "ACTION");

                        lnameM = '';
                        fnameM = '';
                        mnameM = '';
                    }
                }

                console.log(detailsBulk);


                $('#showHideExcelTable').show();
                $('#testExcelTable').html('');

                var i;
                var table1 = '';
                var table2 = '';
                var j;
                var test2;
                var countI = 0;

                for(i = data[1]; i < data[1] +1; i++)
                {
                    for(j = 0; j < 28; j++)
                    {
                        test2 = detailsBulk[i][j];
                        table1 += '<th class = "excelLoopHeader" href="'+i+'" style="font-weight:bold; ">'+test2+'</th>'
                    }

                    table2 += '<tr>'+ table1 +'</tr>';

                    $('#testExcelTable').append(table2);

                    table1 = '';
                    table2 = '';
                }

                var loopCount = 0;
                var loopAttachment = 0;


                for(i = data[1]+ 1; i < data[2]; i++)
                {
                    loopAttachment = 0;

                    for(j = 0; j < 28; j++)
                    {
                        if(data[0][i][j] != null && data[0][i][j] != 'ATTACHMENT')
                        {
                            if(j == 1)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop acctNames" name = "'+ countI +'"  style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 2)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop LastNameCheck" name = "'+ countI +'"  style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 3)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop FirstNameCheck" name = "'+ countI +'"  style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 5)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop acctGender" name = "'+ countI +'"  style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 7)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop maidenNames" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 11)
                            {
                                var date = detailsBulk[i][j].date;

                                var newDAte = date.split(' ');

                                test2 = '<textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop birthdayCheck" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3" disabled>'+ newDAte[0] +'</textarea>';
                            }
                            else if(j == 22)
                            {
                                if(data[0][i][j] == "PACKAGES")
                                {
                                    test2 = '<button class = "btn btn-block btn-success btn-sm bulkButtonPackage" name = "'+loopCount+'" id = "packageBulk-'+loopCount+'"><i class = "fa fa-fw fa-paper-plane-o" ></i> Select Package</button>';
                                }
                            }
                            else if(j == 14)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop presentAdd" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 15)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop presentMuniCheck" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 16)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop presentProvCheck" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 17)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop permaAdd" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 18)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop permaMuniCheck" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 19)
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop permaProvCheck" name = "'+ countI +'"   style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                            else if(j == 23)
                            {
                                if(data[0][i][j] == "CHECKINGS")
                                {
                                    test2 = '<span><button class = "btn btn-block btn-info btn-sm bulkButtonCheck" name = "'+loopCount+'" id = "checkingBulk-'+loopCount+'"><i class = "fa fa-fw fa-paper-plane-o"></i> Select Checking</button></span>';
                                }
                            }
                            else
                            {
                                test2 = '<span><textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop" name = "'+ countI +'"  style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3"  disabled>'+ detailsBulk[i][j] +'</textarea></span>';
                            }
                        }
                        else if(data[0][i][j] == 'ATTACHMENT')
                        {
                            test2 = '<span id = "spanFileBullk-'+ countI + '_'+loopAttachment+'" ">' +
                                '<button class="btn btn-sm btn-primary addFileBulkNow"  name = "'+countI+'" href = "'+loopAttachment+'"><i class = "glyphicon glyphicon-paperclip" ></i> <span id = "attach_stat-'+ countI + '_' +loopAttachment+'">Choose a file</span></button>' +
                                '<input type = "file" class = "filesBulk" id = "attachtoBulk-'+ countI + '_' +loopAttachment+ '" style = "display : none" name = "'+countI+'" href = "'+loopAttachment+'"> ' +
                                '</span>'+
                                '<br>' ;

                            loopAttachment++;
                        }
                        else if(data[0][i][j] == null)
                        {
                            test2 = '<textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop" name = "'+ countI +'" style = "background-color: white; font-weight: bold; font-size: 14px" rows = "3" disabled>-</textarea>';
                        }

                        table1 += '<td class = "excelCol" name = "excelData-'+ countI + '_' + j +'">'+test2+'</td>'

                        // if(j != 0)
                        // {
                        // }
                        // else
                        // {
                        //     if(j == 0)
                        //     {
                        //         test2 = '<button class="btn btn-danger btn-md removeToBulkEndo" id="'+countI+'" value ="'+detailsBulk[i][j]+'">REMOVE</button>';
                        //     }
                        //
                        //     table1 += '<td>'+test2+'</td>'
                        // }
                    }
                    table2 += '<tr id="BulkremoveCtr-'+loopCount+'" class="bulkCount" name="'+loopCount+'" old="'+loopCount+'">'+ table1 +'</tr>';
                    $('#testExcelTable').append(table2);
                    table1 = '';
                    table2 = '';
                    countI++;

                    arrayBulkPackagesCheckLoop.push([]);

                    loopCount++
                }

                $('#BtnBulkEndorseSubmitExcel').show();
                $('#BtnClearBulk').show();
                loopCount = 0;

                tableExcelBool = true;

            },
            complete : function ()
            {
                bulkExcelRed();
                var test_prep = 0;
                $('#testExcelTable tbody tr').each(function()
                {
                    if(test_prep == 0)
                    {
                        $(this).prepend('<th><center>ACTION</center></th>');
                    }
                    else
                    {
                        $(this).prepend('<td><center><button class="btn removeToBulkEndo btn-md btn-block btn-danger" id="'+(test_prep - 1)+'" style="">REMOVE</button></center></td>');
                    }
                    test_prep++;
                });
                // console.log(test_prep);
            }
        });
    }
    else
    {
        alert('Please select an excel file!');
    }
});

function nameCheckComp(nameVal)
{
    var getName2 = nameVal.split(', ');
    var getName = nameVal.split(' ');

    var lastName = getName2[0];
    var searchName = getName2[1];

    var midName = '';
    var firstName = '';

    if(getName.length > 2)
    {
        midName = (getName[getName.length - 1]).trim();
        firstName = searchName.replace(midName, "");
    }
    else if(getName.length <= 2)
    {
        midName = '';
        firstName = searchName;
    }

    var lname = lastName.trim();
    var fname = firstName.trim();
    var mname = midName;

    return [lname, fname, mname];
}

function bulkExcelRed()
{
    var newID = 0;
    var newIDv2 = 0;
    var newIDPack = 0;
    var newIDcheck = 0;
    var checkIfDoub = [];
    var rowToRed = [];
    var forBool = [];
    var itemHolder = '';
    var iii = 0;

    $('.bulkCount').each(function()
    {
        var oldID = $(this).attr('old');
        $(this).attr('name', newID);
        $(this).attr('id', 'BulkremoveCtr-'+newID+'');

        // console.log(oldID);

        $('.filesBulk').each(function()
        {
            if($(this).attr('id') == 'attachtoBulk-'+oldID+'_'+$(this).attr('href')+'')
            {
                $(this).attr('name', newID);
            }
        });
        newID++;
    });

    $('.bulkButtonPackage').each(function()
    {
        $(this).attr('name', newIDPack);
        $(this).attr('id', 'packageBulk-'+newIDPack+'');
        newIDPack++;
    });

    $('.bulkButtonCheck').each(function()
    {
        $(this).attr('name', newIDcheck);
        $(this).attr('id', 'checkingBulk-'+newIDcheck+'');
        newIDcheck++;
    });

    $('.removeToBulkEndo').each(function()
    {
        $(this).attr('id', newIDv2);
        newIDv2++;
    });

    $('.excelLoop').each(function()
    {
        var oldHref = $(this).attr('href');
        var second_index = oldHref.split('_');
        var getNewId = $(this).closest('tr').attr('name');
        if($(this).hasClass('acctNames'))
        {
            $(this).attr('id', 'excelData-'+getNewId+'_1');
            $(this).attr('href', +getNewId+'_1');
            $(this).attr('name', getNewId);
            itemHolder += $(this).val() + ', ';

        }
        else if($(this).hasClass('birthdayCheck'))
        {
            $(this).attr('id', 'excelData-'+getNewId+'_11');
            $(this).attr('href', +getNewId+'_11');
            $(this).attr('name', getNewId);
            itemHolder += $(this).val() + ',|-|-|';
        }
        else
        {
            $(this).attr('id', 'excelData-'+getNewId+'_' + second_index[1]);
            $(this).attr('href', +getNewId+'_' + second_index[1]);
            $(this).attr('name', getNewId);
        }
    });

    checkIfDoub = itemHolder.split(',|-|-|');
    rowToRed = [];

    $('.bulkCount').each(function()
    {
        var getNewId = $(this).attr('name');
        rowToRed[iii] = [];
        for(var ii = 0; ii < checkIfDoub.length; ii++)
        {
            // console.log(checkIfDoub[ii])
            if(checkIfDoub[ii] == $('#excelData-'+getNewId+'_1').val() + ', ' + $('#excelData-'+getNewId+'_11').val())
            {
                rowToRed[iii].push(ii);
            }
        }
        iii++;
    });

    for(var redNow = 0; redNow < rowToRed.length; redNow++)
    {
        if(rowToRed[redNow].length > 1)
        {
            $('#excelData-'+redNow+'_1').closest('tr').css({"background-color": "rgb(255, 161, 161)"});
            forBool.push(redNow);
        }
        else
        {
            $('#excelData-'+redNow+'_1').closest('tr').css({"background-color": ""});
        }
    }

    if(forBool.length > 0)
    {
        bulkEndorseBool = false;
    }
    else
    {
        bulkEndorseBool = true;
    }

    $('.acctNames').each(function()
    {
        var main = $(this).attr('name');

            if($(this).val() != '')
            {
                if($(this).val().includes(', '))
                {
                    var namesRes = nameCheckComp($(this).val());

                    $('#excelData-'+ main + '_2').val(namesRes[0]);
                    $('#excelData-'+ main + '_3').val(namesRes[1]);
                    $('#excelData-'+ main + '_4').val(namesRes[2]);

                    if($(this).attr('style').includes('background-color: #ffb3b3')) //red
                    {
                        var color = $(this).attr('style');

                        var newColor = color.replace('background-color: #ffb3b3', 'background-color: white'); //white

                        $(this).attr('style', newColor);
                    }
                    else if($(this).attr('style').includes('background-color: white'))
                    {

                    }
                }
                else
                {
                    $('#excelData-'+ main + '_2').val('');
                    $('#excelData-'+ main + '_3').val('');
                    $('#excelData-'+ main + '_4').val('');

                    if($(this).attr('style').includes('background-color: white'))
                    {
                        var color2 = $(this).attr('style');

                        var newColor2 = color2.replace('background-color: white', 'background-color: #ffb3b3');

                        $(this).attr('style', newColor2);
                    }
                    else if($(this).attr('style').includes('background-color: #ffb3b3'))
                    {

                    }
                }
            }
            else
            {
                $('#excelData-'+ main + '_2').val('');
                $('#excelData-'+ main + '_3').val('');
                $('#excelData-'+ main + '_4').val('');

                if($(this).attr('style').includes('background-color: white'))
                {
                    var color3 = $(this).attr('style');

                    var newColor3 = color3.replace('background-color: white', 'background-color: #ffb3b3');

                    $(this).attr('style', newColor3);
                }
                else if($(this).attr('style').includes('background-color: #ffb3b3'))
                {

                }
            }
    });

    $('.maidenNames').each(function()
    {
        var bool_check_possible = false;

        var main = $(this).attr('name');

        if($('#excelData-'+ main + '_5').val().toUpperCase() == 'MALE')
        {
            bool_check_possible = false;
        }
        else if($('#excelData-'+ main + '_5').val().toUpperCase() == 'FEMALE')
        {
            if($('#excelData-'+ main + '_6').val().toUpperCase() == 'MARRIED')
            {
                bool_check_possible = true;
            }
            else if($('#excelData-'+ main + '_6').val().toUpperCase() != 'MARRIED')
            {
                bool_check_possible = false;
            }
        }

        if(bool_check_possible)
        {
            if($(this).val() != '')
            {

                if($(this).val().includes(', '))
                {
                    var namesRes = nameCheckComp($(this).val());

                    $('#excelData-'+ main + '_8').val(namesRes[0]);
                    $('#excelData-'+ main + '_9').val(namesRes[1]);
                    $('#excelData-'+ main + '_10').val(namesRes[2]);

                    if($(this).attr('style').includes('background-color: #ffb3b3'))
                    {
                        var color = $(this).attr('style');

                        var newColor = color.replace('background-color: #ffb3b3', 'background-color: white'); //white

                        $(this).attr('style', newColor);
                    }

                }
                else
                {
                    $('#excelData-'+ main + '_8').val('');
                    $('#excelData-'+ main + '_9').val('');
                    $('#excelData-'+ main + '_10').val('');

                    if($(this).attr('style').includes('background-color: white'))
                    {
                        var color2 = $(this).attr('style');

                        var newColor2 = color2.replace('background-color: white', 'background-color: #ffb3b3');

                        $(this).attr('style', newColor2);
                    }
                }

            }
            else
            {
                $('#excelData-'+ main + '_8').val('');
                $('#excelData-'+ main + '_9').val('');
                $('#excelData-'+ main + '_10').val('');

                if($(this).attr('style').includes('background-color: white'))
                {
                    var color3 = $(this).attr('style');

                    var newColor3 = color3.replace('background-color: white', 'background-color: #ffb3b3');

                    $(this).attr('style', newColor3);
                }
            }

        }
        else
        {
            $(this).val('');
            $('#excelData-'+ main + '_8').val('');
            $('#excelData-'+ main + '_9').val('');
            $('#excelData-'+ main + '_10').val('');
            $(this).css('background-color','white');

        }

    });

    $('.presentAdd').each(function()
    {
        var pres = $(this).val();
        var main = $(this).attr('name');

        if(pres == '')
        {
            $(this).css('background-color', '#dd4b39');
            $('#excelData-'+ main + '_15').val('');
            $('#excelData-'+ main + '_16').val('');
        }
        else
        {
            if(pres.includes(','))
            {
                var num_matches = pres.match(/,/gi).length;

                if(num_matches >= 2)
                {
                    var presentAdd = pres.split(',');

                    var getPresentProv = presentAdd[presentAdd.length - 1];

                    presentAdd.pop();

                    var getPresentMuni = presentAdd[presentAdd.length - 1];

                    $('#excelData-'+ main + '_15').val(getPresentMuni.trim());
                    $('#excelData-'+ main + '_16').val(getPresentProv.trim());

                    $(this).css('background-color', 'white');
                    $(this).attr('checkCol', '');
                }
                else
                {
                    $(this).css('background-color', '#ffb3b3');
                }
            }
            else
            {
                alert('Wrong Identification of address.');
            }

        }


    });

    $('.permaAdd').each(function()
    {
        var pres = $(this).val();
        var main = $(this).attr('name');


        if(pres == '')
        {
            $(this).css('background-color', '#dd4b39');
            $('#excelData-'+ main + '_18').val('');
            $('#excelData-'+ main + '_19').val('');
        }
        else
        {   if(pres.includes(','))
            {
                var num_matches = pres.match(/,/gi).length;

                if(num_matches >= 2)
                {
                    var permaAdd = pres.split(',');

                    var getPermaProv = permaAdd[permaAdd.length - 1];

                    permaAdd.pop();

                    var getPermaMuni = permaAdd[permaAdd.length - 1];

                    $('#excelData-'+ main + '_18').val(getPermaMuni.trim());
                    $('#excelData-'+ main + '_19').val(getPermaProv.trim());

                    $(this).css('background-color', 'white');
                    $(this).attr('checkCol', '');
                }
                else
                {
                    $(this).css('background-color', '#ffb3b3');
                }
            }
            else
            {
                alert('Wrong Identification of address.');
            }
        }

    });
}

$('#testExcelTable').on('dblclick', '.excelCol', function()
{
    var target1 = $(event.target);

    if (target1.is("textarea"))
    {
        var id = $(this).attr('name');
        $('#'+ id +'').attr('disabled', false);
        $('#BtnSaveEdit').show();
    }
    else
    {

    }
});

$('#BtnBulkEndorseSubmitExcel').click(function()
{
    var btn = $(this);
    // btn.attr('disabled', true);
    var test_loop;
    var split1;
    var split2;
    var excel_data = {};
    var indexObj = [];
    var check_loop;
    var fileArray = [];
    var checkFile;
    var countFile = 0;
    var countPerIndex = [];
    var to_alert = '';
    var file_id_array = [];
    var formData = new FormData();

    // var checkAcctName =

    btn.attr('disabled', true)

    $('.excelLoopHeader').each(function()
    {
        indexObj.push($(this).html());
    });

    $('.excelLoop').each(function()
    {
        test_loop = $(this).attr('href').split('_');

        split1 = test_loop[0];
        split2 = test_loop[1];
        var loopData = $('#excelData-'+ split1 + '_' + split2+'').val();

        if(check_loop != split1)
        {
            excel_data[split1] = {};
            check_loop = split1;
            file_id_array.push(split1);
        }
        excel_data[split1][indexObj[split2]] = loopData;
    });

    // console.log(excel_data);

    var stringObjectBulk = JSON.stringify(excel_data);
    var bulkData = JSON.parse(stringObjectBulk);


    formData.append('dataBulk', stringObjectBulk);

    $('.filesBulk').each(function()
    {
        var firstIn = $(this).attr('name');

        if(checkFile != firstIn)
        {
            fileArray[firstIn] = [];
            checkFile = firstIn;
            countFile = 0;
        }

        if($(this).val() != '')
        {
            formData.append('files_'+firstIn+'_'+countFile+'' , $(this).prop('files')[0]);
            fileArray[firstIn][countFile] = $(this).prop('files')[0];
            countFile++;
        }
        else
        {
            // fileArray[firstIn][countFile] = '';
            // countFile++;
        }
    });


    for(var g = 0; g < fileArray.length; g++)
    {
        countPerIndex.push([fileArray[g].length]);
    }

    var checkNoFile = [];
    var packagesCheck = [];

    for(var y = 0; y < countPerIndex.length; y++)
    {
        if(countPerIndex[y][0] == 0)
        {
            checkNoFile.push((y+1))
        }
    }

    for(var t = 0; t < arrayBulkPackagesCheckLoop.length; t++)
    {
        if(arrayBulkPackagesCheckLoop[t] == '')
        {
            packagesCheck.push(t+1);
        }
    }


    // if(checkNoFile != '')
    // {
    //     var x =  checkNoFile.toString();

    //     to_alert += '*Please add attachment/s on endorsement row: '+x+'<br>';

    //     // btn.attr('disabled', false)
    // }
    //
    if(packagesCheck != '')
    {
        var v = packagesCheck.toString();

        to_alert += '*Please select package/checkings on endorsement row: '+v+'<br>';

        // btn.attr('disabled', false)
    }

    var firstname_row_count = ' ';
    var firstname_alert = false;
    $('.FirstNameCheck').each(function(){
        if($(this).val() == '')
        {
            firstname_alert = true;
            firstname_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(firstname_alert)
    {
        to_alert += '*Please specify account first name on endorsement row: '+firstname_row_count+'<br>';
    }

    var lastname_row_count = ' ';
    var lastname_alert = false;
    $('.LastNameCheck').each(function(){
        if($(this).val() == '')
        {
            lastname_alert = true;
            lastname_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(lastname_alert)
    {
        to_alert += '*Please specify account last name on endorsement row: '+lastname_row_count+'<br>';
    }

    var birthdaycheck_row_count = ' ';
    var birthdaycheck_alert = false;
    $('.birthdayCheck').each(function(){
        if($(this).val() == '')
        {
            birthdaycheck_alert = true;
            birthdaycheck_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(birthdaycheck_alert)
    {
        to_alert += '*Please specify birthday on endorsement row: '+birthdaycheck_row_count+'<br>';
    }

    var present_muni_check_row_count = ' ';
    var present_muni_check_alert = false;
    $('.presentMuniCheck').each(function(){
        if($(this).val() == '')
        {
            present_muni_check_alert = false;
            // present_muni_check_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(present_muni_check_alert)
    {
        to_alert += '*Please specify present city/municipality on endorsement row: '+present_muni_check_row_count+'<br>';

    }


    var present_prov_check_row_count = ' ';
    var present_prov_check_alert = false;
    $('.presentProvCheck').each(function(){
        if($(this).val() == '')
        {
            present_prov_check_alert = false;
            // present_prov_check_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(present_muni_check_alert)
    {
        to_alert += '*Please specify present province on endorsement row: '+present_prov_check_row_count+'<br>';
    }

    var perma_muni_check_row_count = ' ';
    var perma_muni_check_alert = false;
    $('.permaMuniCheck').each(function(){
        if($(this).val() == '')
        {
            perma_muni_check_alert = false;
            // perma_muni_check_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(perma_muni_check_alert)
    {
        to_alert += '*Please specify permanent city/municipality on endorsement row: '+perma_muni_check_row_count+'<br>';

    }

    var perma_muni_check_row_count = ' ';
    var perma_muni_check_alert = false;
    $('.permaProvCheck').each(function(){
        if($(this).val() == '')
        {
            perma_muni_check_alert = false;
            // perma_muni_check_row_count += (parseInt($(this).attr('name'))+1)+', ';
        }
    });

    if(perma_muni_check_alert)
    {
        to_alert += '*Please specify permanent province on endorsement row: '+perma_muni_check_row_count+'<br>';

    }

    if(!bulkEndorseBool)
    {
        to_alert +='*Check for duplicate encodes in uploaded endorsement' + '<br>';
    }


    if(to_alert == '' && bulkEndorseBool != false)
    {
        $('#alert_show').hide();
        var insertObjPackage = {};
        insertObjPackage[0] = arrayBulkPackagesCheckLoop;
        var stringObjectPackage = JSON.stringify(insertObjPackage);
        formData.append('fileCountBulk', countPerIndex);
        formData.append('packagesChecking', stringObjectPackage);

        $.ajax
        ({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#ulPercentage_Bulk').html('');
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_Bulk').append(Math.floor(percentComplete * 100));
                        $('#progressbar_Bulk').show();
                        $('#progressbar_Bulk').progressbar
                        (
                            {
                                value: percentComplete * 100
                            }
                        )
                    }
                }, false);
                //Download progress
                xhr.addEventListener("progress", function (evt) {
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
            url: 'bi-client-send-bulk-endorse',
            contentType: false,
            processData: false,
            async: true,
            data: formData,
            beforeSend: function () {
                $('#modal-loading-bulk-endorse').modal('show');
            },
            success: function (data) {

                console.log(data);

                if(data[1] == 'double')
                {
                    $('#modal-loading-bulk-endorse').modal('hide');

                    to_alert = '*Account/s Below is already endorsed: <br>';
                    for(var dup = 0; dup < data[0].length; dup++)
                    {
                        to_alert += '<b>'+data[0][dup]+'</b><br>';
                    }

                    $('#alert_text').html(to_alert);
                    $('#alert_show').show();

                    var failed_endorsed_ctr = 0;
                    $('#testExcelTable tbody tr td span textarea').each(function()
                    {
                        if($(this).hasClass('acctNames'))
                        {
                            if($(this).text() == data[0][failed_endorsed_ctr])
                            {
                                $(this).closest('tr').css({"background-color": "rgb(255, 161, 161)"});
                                failed_endorsed_ctr++;
                            }
                            else
                            {
                                $(this).closest('tr').css({"background-color": ""});
                            }
                        }
                    });

                    btn.attr('disabled', false);
                }
                else
                {
                    $('#modal-loading-bulk-endorse').modal('hide');

                    $('#BtnSaveEdit').hide();
                    $(this).hide();
                    tableExcelBool = false;
                    $('#testExcelTable').html('');
                    $('#showHideExcelTable').hide();

                    $('#bulk_endorsement_excel').val('');

                    $('#applyToAllBulk').attr('class', 'btn btn-md btn-block btn-primary').attr('title', '');

                    $('#applyToAllBulk').html('<i class = "fa fa-fw fa-location-arrow"></i> APPLY TO ALL ENDORSEMENTS');

                    $('.bulkButtonPackage').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Package');

                    $('.bulkButtonCheck').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Checks');

                    arrayPackageToBulk = [];
                    arrayBulkPackagesCheckLoop = [];

                    applyBulkBool = false;

                    $('#BtnBulkEndorseSubmitExcel').hide();
                    $('#BtnClearBulk').hide();


                    if (boolCollapsePackCheck == true)
                    {
                        $('#closeOpenPackCheck').click();
                    }
                    else {

                    }

                    $('#modal-success-send-bulk').modal('show');
                    btn.attr('disabled', false)
                }


            },
            error: function (e)
            {
                console.log(e)
                btn.attr('disabled', false);

                $('#modal-loading-bulk-endorse').modal('hide');

                alert('Error in uploading. Please contact the administrator.')
            }
        });
    }
    else
    {
        btn.attr('disabled', false);
        $('#alert_show').show();
        $('#alert_text').html(to_alert);
    }

});

$('#BtnSaveEdit').click(function()
{
    // $('.acctNames').each(function()
    // {
    //     if($(this).attr('checkCol') == 'red')
    //     {
    //         if($(this).val().includes(', '))
    //         {
    //             var getName = $(this).val().split(' ');
    //             var getName2 = $(this).val().split(', ');
    //
    //             var lastName = getName2[0];
    //             var searchName = getName2[1];
    //             var midName = getName[getName.length - 1];
    //             var firstName = searchName.replace(midName, "");
    //
    //             var lname = lastName.trim();
    //             var fname = firstName.trim();
    //             var mname = midName.trim();
    //
    //
    //             var main = $(this).attr('name');
    //
    //             $('#excelData-'+ main + '_2').val(lname);
    //             $('#excelData-'+ main + '_3').val(fname);
    //             $('#excelData-'+ main + '_4').val(mname);
    //
    //             $(this).css('background-color', 'white')
    //             $(this).attr('checkCol', '')
    //         }
    //         else
    //         {
    //
    //         }
    //     }
    //     else
    //     {
    //
    //     }
    // });
    // $('.maidenNames').each(function()
    // {
    //     var main = $(this).attr('name');
    //
    //     if($(this).attr('checkCol') == 'red')
    //     {
    //         if($(this).attr('reason') == 'comma')
    //         {
    //             if($(this).val().includes(', '))
    //             {
    //                 var getNameMaiden = $(this).val().split(' ');
    //                 var getNameMaiden2 = $(this).val().split(', ');
    //
    //                 var lastNameM = getNameMaiden2[0];
    //                 var searchNameM = getNameMaiden2[1];
    //                 var midNameM = getNameMaiden[getNameMaiden.length - 1];
    //                 var firstNameM = searchNameM.replace(midNameM, "");
    //
    //                 var lnameM = lastNameM.trim();
    //                 var fnameM = firstNameM.trim();
    //                 var mnameM = midNameM.trim();
    //
    //                 $('#excelData-'+ main + '_8').val(lnameM);
    //                 $('#excelData-'+ main + '_9').val(fnameM);
    //                 $('#excelData-'+ main + '_10').val(mnameM);
    //
    //                 $(this).css('background-color', 'white')
    //                 $(this).attr('checkCol', '')
    //                 $(this).attr('reason', '');
    //             }
    //             else
    //             {
    //
    //             }
    //         }
    //         else if($(this).attr('reason') == 'stat')
    //         {
    //             if($(this).val() == '')
    //             {
    //                 $(this).css('background-color', 'white');
    //                 $(this).attr('reason', '');
    //             }
    //             else
    //             {
    //
    //             }
    //         }
    //         else if($(this).attr('reason') == 'empty')
    //         {
    //             if($(this).val() != '')
    //             {
    //                 if($(this).val().includes(', '))
    //                 {
    //                     var getNameMaidenEmp = $(this).val().split(' ');
    //                     var getNameMaidenEmp2 = $(this).val().split(', ');
    //
    //                     var lastNameMEmp = getNameMaidenEmp2[0];
    //                     var searchNameMEmp = getNameMaidenEmp2[1];
    //                     var midNameMEmp = getNameMaidenEmp[getNameMaidenEmp.length - 1];
    //                     var firstNameMEmp = searchNameMEmp.replace(midNameMEmp, "");
    //
    //                     var lnameMEmp = lastNameMEmp.trim();
    //                     var fnameMEmp = firstNameMEmp.trim();
    //                     var mnameMEmp = midNameMEmp.trim();
    //
    //
    //                     $('#excelData-'+ main + '_8').val(lnameMEmp);
    //                     $('#excelData-'+ main + '_9').val(fnameMEmp);
    //                     $('#excelData-'+ main + '_10').val(mnameMEmp);
    //
    //                     $(this).css('background-color', 'white')
    //                     $(this).attr('checkCol', '')
    //                     $(this).attr('reason', '');
    //                 }
    //                 else
    //                 {
    //                     $(this).attr('checkCol', 'red')
    //                     $(this).attr('reason', 'comma');
    //                 }
    //             }
    //         }
    //     }
    //
    // });

    bulkExcelRed();
    $(this).hide();
    $('.excelLoop').attr('disabled', true)
});

function cancelTable()
{
    $('#bi_client_cancel_table thead th').each(function ()
    {
        title_cancel[title_cancel_counts] = $(this).text();
        title_cancel_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_cancel = $('#bi_client_cancel_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'bi-client-cancel-table',

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
                                        return title_general[(idx)];
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
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'party_num', name: 'bi_endorsements.party_num'},
                {data: 'contract_num', name: 'bi_endorsements.contract_num'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        return  '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
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

            if(what_to_submit =='cc_bank')
            {
                table_cancel.column(1).visible(false);
                table_cancel.column(6).visible(false);
                table_cancel.column(7).visible(false);
            }
            else
            {
                table_cancel.column(1).visible(true);
                table_cancel.column(2).visible(false);
                table_cancel.column(6).visible(true);
                table_cancel.column(7).visible(true);
            }
        }

    });

    $('#bi_client_cancel_table_filter input').unbind();
    $('#bi_client_cancel_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_cancel.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_cancel.search($(this).val()).draw();
                }
            }
        }
    });
}

function holdTable()
{
    $('#bi_client_hold_table thead th').each(function () {
        title_hold[title_hold_counts] = $(this).text();
        title_hold_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_hold = $('#bi_client_hold_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : ' bi-client-hold-table',

        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: 'visible',
                            format:
                                {
                                    header: function (dt, idx, title)
                                    {
                                        return title_hold_search[(idx)];
                                    }
                                }
                        },
                    customize: function (xlsx)
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function ()
                        {
                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx,title)
                    {
                        return title_hold[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        return '<a id="'+data.endorse_id+'" class="btn_view_removeHold btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-remove"></i> Unhold</a>'+
                            '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
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

    $('#bi_client_hold_table_filter input').unbind();
    $('#bi_client_hold_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_hold.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_hold.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#btnSelectForm').change(function ()
{

    if($(this).val()=='PDRN')
    {
        $('#type_of_request_selection_bi').html('' +
            '                                            <div class="row">\n' +
            '                                            <input type="hidden" id="idPresentMuni">'+
            '                                            <input type="hidden" id="idPresentProv">' +
            '                                        <input type="hidden" id="idPermaMuni">' +
            '                                        <input type="hidden" id="idPermaProv"> '+
            // '                                            <input type="hidden" id="idEtar">'+
            '                                                <div class="col-md-12">\n' +
            '                                                    <div class="box box-danger">\n' +
            '                                                        <div class="box-header with-border">\n' +
            '                                                            <h3 class="box-title">Account Name and Address</h3>\n' +
            '                                                        </div>\n' +
            '                                                        <div class="box-body">\n' +
            '                                                                  <div class = "row">\n' +
            '                                                                        <div class = "form-group col-md-4">\n' +
            '                                                                            <label>Last Name:</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                            <input type="text" class = "form-control" id = "acct_last_pdrn">\n' +
            '                                                                        </div>\n' +
            '                                                                        <div class = "form-group col-md-4">\n' +
            '                                                                            <label>First Name:</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                            <input type="text" class = "form-control" id = "acct_first_pdrn">\n' +
            '                                                                        </div>\n' +
            '                                                                        <div class = "form-group col-md-4">\n' +
            '                                                                            <label>Middle Name:</label><small style="color: orange;"> (Optional Field)</small>\n' +
            '                                                                            <input type="text" class = "form-control" id = "acct_middle_pdrn">\n' +
            '                                                                        </div>\n' +
            // '                                                                        <div class = "form-group col-md-2">\n' +
            // '                                                                            <label>Suffix Name:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <input type="text" class = "form-control" id = "acct_suffix_pdrn">\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class="form-group col-md-2">\n' +
            // '                                                                            <label>Birth Day:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <select class="form-control" id="acct_birthdate_day_pdrn">\n' +
            // '                                                                                <option value = "-">-</option>\n' +
            // '                                                                                <option value = "01">01</option>\n' +
            // '                                                                                <option value = "02">02</option>\n' +
            // '                                                                                <option value = "03">03</option>\n' +
            // '                                                                                <option value = "04">04</option>\n' +
            // '                                                                                <option value = "05">05</option>\n' +
            // '                                                                                <option value = "06">06</option>\n' +
            // '                                                                                <option value = "07">07</option>\n' +
            // '                                                                                <option value = "08">08</option>\n' +
            // '                                                                                <option value = "09">09</option>\n' +
            // '                                                                                <option value = "10">10</option>\n' +
            // '                                                                                <option value = "11">11</option>\n' +
            // '                                                                                <option value = "12">12</option>\n' +
            // '                                                                                <option value = "13">13</option>\n' +
            // '                                                                                <option value = "14">14</option>\n' +
            // '                                                                                <option value = "15">15</option>\n' +
            // '                                                                                <option value = "16">16</option>\n' +
            // '                                                                                <option value = "17">17</option>\n' +
            // '                                                                                <option value = "18">18</option>\n' +
            // '                                                                                <option value = "19">19</option>\n' +
            // '                                                                                <option value = "20">20</option>\n' +
            // '                                                                                <option value = "21">21</option>\n' +
            // '                                                                                <option value = "22">22</option>\n' +
            // '                                                                                <option value = "23">23</option>\n' +
            // '                                                                                <option value = "24">24</option>\n' +
            // '                                                                                <option value = "25">25</option>\n' +
            // '                                                                                <option value = "26">26</option>\n' +
            // '                                                                                <option value = "27">27</option>\n' +
            // '                                                                                <option value = "28">28</option>\n' +
            // '                                                                                <option value = "29">29</option>\n' +
            // '                                                                                <option value = "30">30</option>\n' +
            // '                                                                                <option value = "31">31</option>\n' +
            // '                                                                            </select>\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class="form-group col-md-2">\n' +
            // '                                                                            <label>Age:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <input type="number" disabled class="form-control" id="acct_birthdate_age_pdrn">\n' +
            // '                                                                        </div>\n' +
            '                                                                    </div>\n' +
            // '                                                                    <div class = "row">\n' +
            // // '                                                                        <div class = "form-group col-md-6">\n' +
            // // '                                                                            <label>First Name:</label><small style="color: red;"> (Required Field)</small>\n' +
            // // '                                                                            <input type="text" class = "form-control" id = "acct_first_pdrn">\n' +
            // // '                                                                        </div>\n' +
            // '                                                                        <div class = "form-group col-md-2">\n' +
            // '                                                                            <label>Gender:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <select class="acct_gender_pdrn form-control" name="" id="acct_gender_pdrn">\n' +
            // '                                                                                <option value = "-">-</option>\n' +
            // '                                                                                <option value = "Male">Male</option>\n' +
            // '                                                                                <option value = "Female">Female</option>\n' +
            // '                                                                            </select>\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class="form-group col-md-2">\n' +
            // '                                                                            <label>Birth Month:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <select class="form-control" id="acct_birthdate_month_pdrn">\n' +
            // '                                                                                <option value = "-">-</option>\n' +
            // '                                                                                <option value = "01">January</option>\n' +
            // '                                                                                <option value = "02">February</option>\n' +
            // '                                                                                <option value = "03">March</option>\n' +
            // '                                                                                <option value = "04">April</option>\n' +
            // '                                                                                <option value = "05">May</option>\n' +
            // '                                                                                <option value = "06">June</option>\n' +
            // '                                                                                <option value = "07">July</option>\n' +
            // '                                                                                <option value = "08">August</option>\n' +
            // '                                                                                <option value = "09">September</option>\n' +
            // '                                                                                <option value = "10">October</option>\n' +
            // '                                                                                <option value = "11">November</option>\n' +
            // '                                                                                <option value = "12">December</option>\n' +
            // '                                                                            </select>\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class="form-group col-md-2">\n' +
            // '                                                                            <label>Citizenship:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <input type="text" class="form-control" id="acct_citizenship_pdrn">\n' +
            // '                                                                        </div>\n' +
            // '                                                                    </div>\n' +
            // '                                                                    <div class = "row">\n' +
            // '                                                                        <div class = "form-group col-md-6">\n' +
            // '                                                                            <label>Middle Name:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <input type="text" class = "form-control" id = "acct_middle_pdrn">\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class = "form-group col-md-2">\n' +
            // '                                                                            <label>Marital Status:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <select class="acct_marital_status_pdrn form-control" name="" id="acct_marital_status_pdrn">\n' +
            // '                                                                                <option value = "-">-</option>\n' +
            // '                                                                                <option value = "Single">Single</option>\n' +
            // '                                                                                <option value = "Married">Married</option>\n' +
            // '                                                                                <option value = "Widowed">Widowed</option>\n' +
            // '                                                                                <option value = "Divorced">Divorced</option>\n' +
            // '                                                                                <option value = "Separated">Separated</option>\n' +
            // '                                                                            </select>\n' +
            // '                                                                        </div>\n' +
            // '                                                                        <div class="form-group col-md-2">\n' +
            // '                                                                            <label>Birth Year:</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                            <select class="form-control" id="acct_birthdate_year_pdrn">\n' +
            // '                                                                            </select>\n' +
            // '                                                                        </div>\n' +
            // '                                                                    </div>\n' +
            // '                                                                    <div hidden id="if_married_check_pdrn" class="box box-danger">\n' +
            // '                                                                        <div class = "row"><div class = "col-md-12">' +
            // '                                                                        <div class="box-header with-border">IF MARRIED - Maiden Information: (This Row will only show if "Married" is selected)</div>\n' +
            // '                                                                            <div class="row">\n' +
            // '                                                                                <div class="form-group col-md-4">\n' +
            // '                                                                                    <label>Maiden Last Name:</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                    <input type="text" class = "form-control" id = "acct_maiden_last_name_pdrn">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <div class="form-group col-md-4">\n' +
            // '                                                                                    <label>Maiden First Name:</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                    <input type="text" class = "form-control" id = "acct_maiden_first_name_pdrn">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <div class="form-group col-md-4">\n' +
            // '                                                                                    <label>Maiden Middle Name:</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                    <input type="text" class = "form-control" id = "acct_maiden_middle_name_pdrn">\n' +
            // '                                                                                </div>\n' +
            // '                                                                            </div>\n' +
            // '                                                                        </div>' +
            // '                                                                       </div>' +
            // '                                                                   </div>' +
            // '                                                               <div class="box box-danger">\n' +
            // '                                                                  <div class="box-header with-border">\n' +
            // '                                                                      <div class = "box-title">Address/es</div>\n' +
            // '                                                                      </div>\n' +
            // '                                                                  <div style="margin-top: 20px">\n' +
            // '                                                                      <div class="box-header with-border">\n' +
            // '                                                                        <b>Present Address</b>\n' +
            // '                                                                       </div>\n' +
            // '                                                                              <div class = "row">\n' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                   <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control" placeholder="" id="bi_present_address_pdrn" name="bi_present_address_pdrn">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                   <label>City/Municipality</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_present_municipality_pdrn" name="bi_present_municipality_pdrn" autocomplete="off">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                  <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_Muni_pdrn"></span>\n' +
            // '                                                                                  <input type="text" class="form-control" placeholder="" id="bi_present_province_pdrn" name="bi_present_province_pdrn" disabled="">\n' +
            // '                                                                                </div>\n' +
            // '                                                                               </div>\n' +
            // '                                                                 </div>\n' +
            // '                                                                  <input type="checkbox"  id="bi_check_same_address_pdrn" value="same_address">\n' +
            // '                                                                    <strong>\n' +
            // '                                                                     Check if "Permanent Address" same as "Present Address"\n' +
            // '                                                                     </strong>\n' +
            // '                                                                        <div style="margin-top: 20px">\n' +
            // '                                                                            <div class="box-header with-border">\n' +
            // '                                                                                <b>Permanent Address</b>\n' +
            // '                                                                            </div>\n' +
            // '                                                                                    <div class = "row">\n' +
            // '                                                                                        <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_address_pdrn" name="bi_permanent_address_pdrn">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                            <label>City/Municipality</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_permanent_municipality_pdrn" name="bi_permanent_municipality_pdrn" autocomplete="off">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                        <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_Prov_pdrn"></span>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_province_pdrn" name="bi_permanent_province_pdrn" disabled="">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                    </div>\n' +
            // '                                                                        </div>\n' +
            // '                                                                    </div>' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            // '                                                    <div class="box box-danger" id="comakerDom">\n' +
            // '                                                        <div class="box-header with-border">\n' +
            // '                                                            <h3 class="box-title">Co-Borrower Name</h3><small style="color: red;">*Note: Required for accounts with Co-Borrower/s</small>\n' +
            // '                                                            <div class="form-group form-inline col-xs-3 pull-right">\n' +
            // '                                                                <label class="control-label">Number of Coborrower</label>\n' +
            // '                                                                <select class="form-control" id="bi_pdrn_coborrower_count">\n' +
            // '                                                                   <option value="0">0</option>\n' +
            // '                                                                   <option value="1">1</option>\n' +
            // '                                                                   <option value="2">2</option>\n' +
            // '                                                                   <option value="3">3</option>\n' +
            // '                                                                   <option value="4">4</option>\n' +
            // '                                                                   <option value="5">5</option>\n' +
            // '                                                                   <option value="6">6</option>\n' +
            // '                                                                   <option value="7">7</option>\n' +
            // '                                                                   <option value="8">8</option>\n' +
            // '                                                                   <option value="9">9</option>\n' +
            // '                                                                   <option value="10">10</option>\n' +
            // '                                                               </select>\n' +
            // '                                                            </div>\n' +
            // '                                                        </div>\n' +
            // '                                                    <div class="box-body">\n' +
            // '                                                        <span id="bi_addCob_pdrn"></span>\n' +
            // '                                                    </div>\n' +
            // '                                                </div>\n' +
            '                                                        <div class="box box-danger">\n' +
            '                                                            <div class="box-header with-border">\n' +
            '                                                                <div class = "box-title">Attachments</div><small style="color: red;"> (Required atleast 1 attachment)</small>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="box-body">\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 1 (Application Form)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach1">\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 2(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach2">\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 3(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach3">\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 4(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach4">\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                            </div>\n' +
            '                                                        </div>' +
            '                                                <div class="box box-danger">\n' +
            '                                                    <div class="box-header with-border">\n' +
            '                                                        <h3 class="box-title">Other Information</h3>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="box-body">\n' +
            // '                                                        <div class="row">\n' +
            // '                                                            <div class="form-group col-xs-4">\n' +
            // '                                                                <label>Type of Loan:</label>\n' +
            // '                                                                <select class="form-control select1" style="width: 100%" id="loanType_pdrn" name="loanType_pdrn">\n' +
            // '                                                                    <option value="----(Undefined)">----(Undefined)</option>\n' +
            // '                                                                    <option value="Auto Loan">Auto Loan</option>\n' +
            // '                                                                    <option value="Personal Loan">Personal Loan</option>\n' +
            // '                                                                    <option value="Housing Loan">Housing Loan</option>\n' +
            // '                                                                    <option value="Small Business Loan">Small Business Loan</option>\n' +
            // '                                                                    <option value="Mortgage Loan">Mortgage Loan</option>\n' +
            // '                                                                </select>\n' +
            // '                                                            </div>\n' +
            // '                                                            <div class="form-group col-xs-4">\n' +
            // '                                                                <label>Endorsement Type:</label>\n' +
            // '                                                                <select class="form-control select1" id="txtPrioritize_pdrn" style="width: 100%;">\n' +
            // '                                                                    <option selected="selected">Regular</option>\n' +
            // '                                                                    <option>Priority Discreet</option>\n' +
            // '                                                                </select>\n' +
            // '                                                            </div>\n' +
            // '                                                            <div class="form-group col-xs-4">\n' +
            // '                                                                <label>Type of Verification:</label>\n' +
            // '                                                                <select class="form-control select1" id="txtVerifyThrough_pdrn" style="width: 100%;">\n' +
            // '                                                                    <option selected="selected">Non Discreet</option>\n' +
            // '                                                                    <option>Discreet</option>\n' +
            // '                                                                </select>\n' +
            // '                                                            </div>\n' +
            // '                                                        </div>\n' +
            '                                                        <div class="row">\n' +
            '                                                            <div class="form-group col-xs-12">\n' +
            '                                                                <label>Remarks:</label><small style="color: orange;"> (Optional....)</small>\n' +
            '                                                                <textarea id="txtClientRemarks_pdrn" maxlength="255" class="form-control" rows="3"></textarea>\n' +
                                                                            '<span class="PDRNremainingChars">255</span><span>/255</span>' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                    <div class="box box-danger">\n' +
            '                                                        <div class="box-header with-border">\n' +
            '                                                            <h3 class="box-title">Requestor Informationssss</h3><small style="color: red;"> (Required Field)</small>\n' +
            '                                                        </div>\n' +
            '                                                        <div class="box-body">\n' +
            '                                                            <div class="row">\n' +
            '                                                                <div class="form-group col-xs-12">\n' +
            '                                                                    <label>Name of Requestor:</label>\n' +
            '                                                                    <input type="text" class="form-control" placeholder="" id="acct_endorsedby_pdrn" name="acct_endorsedby_pdrn">\n' +
            '                                                                </div>\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n'
        );
        
        // Client remarks counter PDRN -chano
        var max_length = 255;
        $('#txtClientRemarks_pdrn').keyup(function () {
            var len = max_length - $(this).val().length;
            $('.PDRNremainingChars').text(len);
        });
        
        
        $('#btn_bi_submit_endorsement').attr('name', 'PDRN');

        var opt_year = '<option value="-">-</option>';
        for(var year = 2019; year>1900; year--)
        {
            opt_year+='<option value="'+year+'">'+year+'</option>'
        }
        $('#acct_birthdate_year_pdrn').html(opt_year);

        $('.acct_gender_pdrn').change(function ()
        {
            var value = $(this).val();
            console.log(value);

            // var count = $(this).attr('name');

            if(value == 'Female')
            {
                maiden_trigger_gender = true;
                if(maiden_trigger_status)
                {
                    $('#if_married_check_pdrn').show();
                }
            }
            else
            {
                $('#if_married_check_pdrn').hide();
                $('#acct_maiden_last_name_pdrn').val('');
                $('#acct_maiden_first_name_pdrn').val('');
                $('#acct_maiden_middle_name_pdrn').val('');
                maiden_trigger_gender = false;
            }
        });
        $('#acct_birthdate_day_pdrn').change(function()
        {
            var endorse_day = $(this).val();
            var endorse_month = $('#acct_birthdate_month_pdrn').val();
            var endorse_year = $('#acct_birthdate_year_pdrn').val();

            if(endorse_month == '-' || endorse_year == '-')
            {
                console.log('Select complete date.');
            }
            else
            {
                $('#acct_birthdate_age_pdrn').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
            }
        });

        $('#acct_birthdate_month_pdrn').change(function()
        {
            var endorse_month = $(this).val();
            var endorse_day = $('#acct_birthdate_day_pdrn').val();
            var endorse_year = $('#acct_birthdate_year_pdrn').val();

            if(endorse_day == '-' || endorse_year == '-')
            {
                console.log('Select complete date.');
            }
            else
            {
                $('#acct_birthdate_age_pdrn').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
            }
        });

        $('#acct_birthdate_year_pdrn').change(function()
        {
            var endorse_year = $(this).val();
            var endorse_month = $('#acct_birthdate_month_pdrn').val();
            var endorse_day = $('#acct_birthdate_day_pdrn').val();

            if(endorse_month == '-' || endorse_day == '-')
            {
                console.log('Select complete date');
            }
            else
            {
                $('#acct_birthdate_age_pdrn').val(calculate_age(new Date(endorse_year, endorse_month, endorse_day)))
            }
        });


        $('.acct_marital_status_pdrn').change(function () {
            var value = $(this).val();
            // var count = $(this).attr('name');

            if(value == 'Married')
            {
                if(maiden_trigger_gender)
                {
                    $('#if_married_check_pdrn').show();
                }
                maiden_trigger_status=true;
            }
            else
            {
                $('#if_married_check_pdrn').hide();
                $('#acct_maiden_last_name_pdrn').val('');
                $('#acct_maiden_first_name_pdrn').val('');
                $('#acct_maiden_middle_name_pdrn').val('');
                maiden_trigger_status = false;
            }
        });

        fetchMuniPdrnPresent('');
        fetchMuniPdrnPermanent('');
        checkSamePresentPerma('');

        $('#bi_pdrn_coborrower_count').on('change',function ()
        {
            var count_cobo = $(this).val();
            var coobs = '';

            for(var i = 0; i<count_cobo; i++)
            {
                coobs +=
                    '                                                    <div class = "box box-default">' +
                    // '                                                    <input type="hidden" id="idEtar-'+i+'">'+
                    '                                                     <div style = "margin-top : 20px;"><span class="label label-danger" >Coborrower '+(i+1)+' </span><div></div> ' +
                    '                                                     <div class = "row" style = "padding-top : 20px;">' +
                    '                                                     <div class = "col-md-2">' +
                    '                                                     <label>Relationship to Subject:</label>' +
                    '                                                     <span class = "relationshipCob" name = "'+i+'"><select class = "form-control cobEachPDRN-'+ i +'" name = "'+i+'">' +
                    '                                                     <option value = "Undefined">Undefined</option>' +
                    '                                                     <option value = "Spouse">Spouse</option>' +
                    '                                                     <option value = "Father">Father</option>' +
                    '                                                     <option value = "Mother">Mother</option>' +
                    '                                                     <option value = "Sister">Sister</option>' +
                    '                                                     <option value = "Brother">Brother</option>' +
                    '                                                     <option value = "Others">Others</option>' +
                    '                                                     </select></span>' +
                    '                                                     </div>' +
                    '                                                     <div class = "col-md-10"></div>' +
                    '                                                     </div>' +
                    '                                                     <div class = "row" style = "padding-top : 20px;" id = "showRelOthers-'+i+'" hidden>' +
                    '                                                     <div class = "col-md-2">' +
                    '                                                     <label>Please Indicate:</label>' +
                    '                                                     <input type = "text" class = "form-control cobEachPDRN-'+ i +'" id = "indicateRemarksOthersRel-'+i+'">' +
                    '                                                     </div>' +
                    '                                                     <div class = "col-md-10"></div>' +
                    '                                                     </div>'+
                    '                                                    <div class="row" style = "padding-top : 20px;">\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>First Name</label>\n' +
                    '                                                            <input type="text" class="form-control cobEachPDRN-'+ i +'" placeholder="" id="coborFName-'+i+'" name="coborFName-'+i+'">\n' +
                    '                                                        </div>\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>Middle Name</label>\n' +
                    '                                                            <input type="text" class="form-control cobEachPDRN-'+ i +'" placeholder="" id="coborMName-'+i+'" name="coborMName-'+i+'">\n' +
                    '                                                        </div>\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>Last Name</label>\n' +
                    '                                                            <input type="text" class="form-control cobEachPDRN-'+ i +'" placeholder="" id="coborLName-'+i+'" name="coborLName-'+i+'">\n' +
                    '                                                        </div>\n' +
                    '                                                    </div>\n' +
                    '                                                    <div class="row">' +
                    '                                                       <div class="form-group col-xs-8">' +
                    '                                                       <label>\n' +
                    '                                                          <input id="coborCheckSameAdd-'+i+'" name="'+i+'" type="checkbox" class="checkbox_sameadd">\n' +
                    '                                                          Same Address\n' +
                    '                                                        </label><small style="color: red;"> (Check this if the co-borrower has the same address with main subject/borrower)</small>' +
                    '                                                        </div>'+
                    '                                                    </div>' +
                    '                                                                            <div class="box-header with-border">\n' +
                    '                                                                                <b>Co-borrower\'s Present Address</b>\n' +
                    '                                                                            </div>\n' +
                    '                                                                                    <div class = "row" style = "padding-top : 10px;">\n' +
                    '                                                                                        <div class="form-group col-xs-4">\n' +
                    '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional Field)</small>\n' +
                    '                                                                                            <input type="text" class="cobEachPDRN-'+ i +' form-control" placeholder="" id="bi_present_address_pdrn-'+i+'" name="address">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
                    '                                                                                            <label>City/Municipality</label><small style="color: orange;"> (Optional Field)</small>\n' +
                    '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_present_municipality_pdrn-'+i+'" name="bi_present_municipality_pdrn-'+i+'" autocomplete="off">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <input type="hidden" class = "cobEachPDRN-'+ i +'" id="idPresentMuni-'+i+'">'+
                    '                                                                                        <div class="form-group col-xs-4">\n' +
                    '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_Muni_pdrn-'+i+'"></span>\n' +
                    '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_present_province_pdrn-'+i+'" name="bi_present_province_pdrn-'+i+'" disabled="">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <input type="hidden" class = "cobEachPDRN-'+ i +'" id="idPresentProv-'+i+'">'+
                    '                                                                                    </div>\n' +
                    '                                                                        </div>\n' +
                    '\n' +
                    '                                                                        <input type="checkbox"  id="bi_check_same_address_pdrn-'+i+'" value="same_address">\n' +
                    '                                                                        <strong>\n' +
                    '                                                                            Check if "Permanent Address" same as "Present Address"\n' +
                    '                                                                        </strong>\n' +
                    '\n' +
                    '                                                                        <div style="margin-top: 20px">\n' +
                    '                                                                            <div class="box-header with-border">\n' +
                    '                                                                                <b>Co-borrower\'s Permanent Address</b>\n' +
                    '                                                                            </div>\n' +
                    '                                                                                    <div class = "row" style = "padding-top : 10px;">\n' +
                    '                                                                                        <div class="form-group col-xs-4">\n' +
                    '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional  Field)</small>\n' +
                    '                                                                                            <input type="text" class="cobEachPDRN-'+ i +' form-control" placeholder="" id="bi_permanent_address_pdrn-'+i+'" name="address">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
                    '                                                                                            <label>City/Municipality</label><small style="color: orange;"> (Optional  Field)</small>\n' +
                    '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_municipality_pdrn-'+i+'" name="bi_permanent_municipality_pdrn-'+i+'" autocomplete="off">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <input type="hidden" class = "cobEachPDRN-'+ i +'" id="idPermaMuni-'+i+'">'+
                    '                                                                                        <div class="form-group col-xs-4">\n' +
                    '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_Prov_pdrn-'+i+'"></span>\n' +
                    '                                                                                            <input type="text" class= "form-control" placeholder="" id="bi_permanent_province_pdrn-'+i+'" name="bi_permanent_province_pdrn-'+i+'" disabled="">\n' +
                    '                                                                                        </div>\n' +
                    '                                                                                        <input type="hidden" class = "cobEachPDRN-'+ i +'" id="idPermaProv-'+i+'">'+
                    '                                                                        </div></div>\n'
            };

            $('#bi_addCob_pdrn').html(coobs);
            $('#btn_bi_submit_endorsement').attr('href', count_cobo);

            for(var ctr = 0; ctr<count_cobo; ctr++)
            {
                fetchMuniPdrnPresent(ctr);
                fetchMuniPdrnPermanent(ctr);
                clickcheckbox(ctr);
                checkSamePresentPerma(ctr);
            }
            var cobId;

            $('.relationshipCob').click(function()
            {
                cobId = $(this).attr('name');

                $('.cobEachPDRN-'+ cobId +'').change(function()
                {
                    var cobVal = $(this).val();

                    if(cobVal == 'Others')
                    {
                        $('#showRelOthers-'+cobId+'').show();
                    }
                    else
                    {
                        $('#showRelOthers-'+cobId+'').hide();
                    }
                });

            });



        });
    }
    else if($(this).val()=='BVR')
    {
        $('#type_of_request_selection_bi').html('' +
            '                                            <div class="row">\n' +
            '                                                <div class="col-md-12">\n' +
            '                                                    <div class="box box-danger">\n' +
            '                                                        <div class="box-header with-border">\n' +
            '                                                            <h3 class="box-title">Account Name</h3>\n' +
            '                                                            <div id="radioCorp" class="pull-right">\n' +
            // '                                                               <div class="form-group">\n' +
            // '                                                                   <label class="radio-inline">\n' +
            // '                                                                       <input checked="" type="radio" class="flat-red" name="optradioCorp" id="personalRequest"><b>Personal Request</b>\n' +
            // '                                                                   </label>\n' +
            // '                                                                   <label class="radio-inline">\n' +
            // '                                                                       <input type="radio" class="flat-red" name="optradioCorp" id="corporateRequest"><b>Corporate Request</b>\n' +
            // '                                                                   </label>\n' +
            // '                                                               </div>\n' +
            // '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                        <div class="box-body">\n' +
            '                                                            <div class="row">\n' +
            '                                                                <div class="form-group col-xs-4">\n' +
            '                                                                    <label>Last Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                    <input id="acctLNameBVR" name="acctLName" type="text" class="form-control" placeholder="">\n' +
            '                                                                </div>\n' +
            '                                                                <div class="form-group col-xs-4">\n' +
            '                                                                    <label>First Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                    <input id="acctFNameBVR" name="acctFName" type="text" class="form-control" placeholder="">\n' +
            '                                                                </div>\n' +
            '                                                                <div class="form-group col-xs-4">\n' +
            '                                                                    <label>Middle Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                    <input id="acctMNameBVR" name="acctMName" type="text" class="form-control" placeholder="">\n' +
            '                                                                </div>\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            // '                                                               <div class="box box-danger">\n' +
            // '                                                                  <div class="box-header with-border">\n' +
            // '                                                                      <div class = "box-title">Address/es</div>\n' +
            // '                                                                      </div>\n' +
            // '                                                                  <div style="margin-top: 20px">\n' +
            // '                                                                      <div class="box-header with-border">\n' +
            // '                                                                        <b>Present Address</b>\n' +
            // '                                                                       </div>\n' +
            // '                                                                              <div class = "row">\n' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                   <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control" placeholder="" id="bi_present_address_bvr" name="bi_present_address_bvr">\n' +
            // '                                                                                </div>\n' +
            //
            // '                                                                                <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                   <label>City/Municipality</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_present_municipality_bvr" name="bi_present_municipality_bvr" autocomplete="off">\n' +
            // '                                                                                </div>\n' +
            // '                                                                    <input type = "hidden" id = "idPresentMuniBvr">' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                  <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_bvr"></span>\n' +
            // '                                                                                  <input type="text" class="form-control" placeholder="" id="bi_present_province_bvr" name="bi_present_province_bvr" disabled="">\n' +
            // '                                                                                </div>\n' +
            // '                                                                    <input type = "hidden" id = "idPresentProvBvr">' +
            // '                                                                               </div>\n' +
            // '                                                                 </div>\n' +
            // '                                                                  <input type="checkbox"  id="bi_check_same_address_bvr" value="same_address">\n' +
            // '                                                                    <strong>\n' +
            // '                                                                     Check if "Permanent Address" same as "Present Address"\n' +
            // '                                                                     </strong>\n' +
            // '                                                                        <div style="margin-top: 20px">\n' +
            // '                                                                            <div class="box-header with-border">\n' +
            // '                                                                                <b>Permanent Address</b>\n' +
            // '                                                                            </div>\n' +
            // '                                                                                    <div class = "row">\n' +
            // '                                                                                        <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_address_bvr" name="bi_permanent_address_bvr">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                            <label>City/Municipality</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_municipality_bvr" name="bi_permanent_municipality_bvr" autocomplete="off">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                            <input type = "hidden" id = "idPermaMuniBvr">' +
            // '                                                                             <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_bvr"></span>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_province_bvr" name="bi_permanent_province_bvr" disabled="">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                            <input type = "hidden" id = "idPermaProvBvr">' +
            // '                                                                                    </div>\n' +
            // '                                                                        </div>\n' +
            // '                                                                    </div>' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            // '                                                    <div class="box box-danger">\n' +
            // '                                                        <div class="box-header with-border">\n' +
            // '                                                            <h3 class="box-title">Business Name and Address</h3>\n' +
            // '                                                               <div class="form-group form-inline col-xs-3 pull-right">\n' +
            // '                                                                   <label class="control-label">Number of Business</label>\n' +
            // '                                                                   <select class="form-control" id="bi_bvr_coborrower_count">\n' +
            // '                                                                       <option value="1">1</option>\n' +
            // '                                                                       <option value="2">2</option>\n' +
            // '                                                                       <option value="3">3</option>\n' +
            // '                                                                       <option value="4">4</option>\n' +
            // '                                                                       <option value="5">5</option>\n' +
            // '                                                                       <option value="6">6</option>\n' +
            // '                                                                       <option value="7">7</option>\n' +
            // '                                                                       <option value="8">8</option>\n' +
            // '                                                                       <option value="9">9</option>\n' +
            // '                                                                       <option value="10">10</option>\n' +
            // '                                                                       <option value="11">11</option>                                                 \n' +
            // '                                                                   </select>                                      \n' +
            // '                                                               </div>\n' +
            // '                                                        </div>\n' +
            // '                                                        <div class="box-body">\n' +
            // '                                                            <span class="label label-danger">Business 1</span>      \n' +
            // '                                                            <div class="row">\n' +
            // '                                                                <div class="form-group col-xs-12">\n' +
            // '                                                                    <label>Business Name</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                    <input type="text" class="form-control busNameEach-0" placeholder="" id="busName-0" name="busName-0">\n' +
            // '                                                                </div>\n' +
            // '                                                            </div>\n' +
            // '                                                            <div class="row">\n' +
            // '                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                    <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                    <input type="text" class="form-control busNameEach-0" placeholder="" id="addressBus-0" name="addressBus-0">\n' +
            // '                                                                </div>\n' +
            // '                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                    <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                                    <input type="text" class="form-control" placeholder="" id="municipalityBus-0" name="municipalityBus-0" autocomplete="off">\n' +
            // '                                                                </div>\n' +
            // '                                                            <input type="hidden" class = "busNameEach-0" id="idMuniOriginalBus-0">    \n' +
            // '                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                    <label>Province</label><small style="color: red;"> (Required Field)</small><span id="loadingBus-0"></span>\n' +
            // '                                                                    <input type="text" class="form-control" placeholder="" id="provinceBus-0" name="provinceBus-0" disabled="">\n' +
            // '                                                                </div>\n' +
            // '                                                            <input type="hidden" class = "busNameEach-0" id="idMuniBus-0">      \n' +
            // '                                                            </div>\n' +
            // '                                                            <span id="bi_addBus"></span>      \n' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            '                                                        <div class="box box-danger">\n' +
            '                                                            <div class="box-header with-border">\n' +
            '                                                                <div class = "box-title">Attachments</div><small style="color: red;"> (Required atleast 1 attachment)</small>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="box-body">\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 1 (Application Form)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach1">\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 2(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach2">\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 3(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach3">\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 4(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach4">\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                            </div>\n' +
            '                                                        </div>' +
            '                                                    <div class="box box-danger">    \n' +
            '                                                        <div class="box-header with-border">                              \n' +
            '                                                            <h3 class="box-title">Other Information</h3>      \n' +
            '                                                        </div>                                             \n' +
            '                                                        <div class="box-body">                            \n' +
            // '                                                            <div class="row">                                  \n' +
            // '                                                                <div class="form-group col-xs-4">   \n' +
            // '                                                                    <label>Type of Loan:</label>             \n' +
            // '                                                                    <select class="form-control select1" style="width: 100%" id="loanTypeBVR" name="loanType">\n' +
            // '                                                                        <option value="----(Undefined)">----(Undefined)</option>\n' +
            // '                                                                        <option value="Auto Loan">Auto Loan</option>\n' +
            // '                                                                        <option value="Personal Loan">Personal Loan</option>\n' +
            // '                                                                        <option value="Housing Loan">Housing Loan</option>\n' +
            // '                                                                        <option value="Small Business Loan">Small Business Loan</option>\n' +
            // '                                                                        <option value="Mortgage Loan">Mortgage Loan</option>         \n' +
            // '                                                                    </select>                                                    \n' +
            // '                                                                </div>                                           \n' +
            // '                                                                <div class="form-group col-xs-4">           \n' +
            // '                                                                    <label>Endorsement Type:</label>                  \n' +
            // '                                                                    <select class="form-control select1" id="txtPrioritizeBVR" style="width: 100%;">         \n' +
            // '                                                                        <option selected="selected">Regular</option>                                 \n' +
            // '                                                                        <option>Priority Discreet</option>                                  \n' +
            // '                                                                    </select>                                         \n' +
            // '                                                                </div>                                              \n' +
            // '                                                                <div class="form-group col-xs-4">                                   \n' +
            // '                                                                    <label>Type of Verification:</label>                        \n' +
            // '                                                                    <select class="form-control select1" id="txtVerifyThroughBVR" style="width: 100%;">  \n' +
            // '                                                                        <option selected="selected">Non Discreet</option>                              \n' +
            // '                                                                        <option>Discreet</option>                                                   \n' +
            // '                                                                    </select>                                                    \n' +
            // '                                                                </div>                                           \n' +
            // '                                                            </div>                                    \n' +
            '                                                            <div class="row">                     \n' +
            '                                                                <div class="form-group col-xs-12">        \n' +
            '                                                                    <label>Remarks:</label><small style="color: orange;"> (Optional)</small>      \n' +
            '                                                                    <textarea id="txtClientRemarksBVR" maxlength="255" class="form-control" rows="3"></textarea>    \n' +
                                                                                '<span class="BVRremainingChars">255</span><span>/255</span>' +
            '                                                                </div>                                                \n' +
            '                                                            </div>                                            \n' +
            '                                                        </div>                                           \n' +
            '                                                    </div>                                       \n' +
            '                                                    <div class="box box-danger">                     \n' +
            '                                                        <div class="box-header with-border">            \n' +
            '                                                            <h3 class="box-title">Requestor Information</h3><small style="color: red;"> (Required Field)</small>  \n' +
            '                                                        </div>                                       \n' +
            '                                                        <div class="box-body">                   \n' +
            '                                                            <div class="row">                     \n' +
            '                                                                <div class="form-group col-xs-12">   \n' +
            '                                                                    <label>Name of Requestor:</label>       \n' +
            '                                                                    <input type="text" class="form-control" placeholder="" id="requestorNameBVR" name="requestorName">                \n' +
            '                                                                </div>                                       \n' +
            '                                                            </div>                                            \n' +
            '                                                        </div>                                        \n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n'
        );
        
        // Client remarks counter BVR -chano
        var max_length = 255;
        $('#txtClientRemarksBVR').keyup(function () {
            var len = max_length - $(this).val().length;
            $('.BVRremainingChars').text(len);
        });
        
        
        $('#btn_bi_submit_endorsement').attr('name', 'BVR');
        fetchMuni2(0);
        fetchMuniBVRPresent();
        fetchMuniBVRPerma();
        sameBVRPrePerma();

        $('#btn_bi_submit_endorsement').attr('href', 1);

        $("input[name=optradioCorp]:radio").change(function ()
        {
            if ($("#personalRequest").is(":checked"))
            {
                $('#acctFNameBVR').attr('disabled',false);
                $('#acctMNameBVR').attr('disabled',false);
                $('#acctLNameBVR').attr('disabled',false);
                $('#acctFNameBVR').val('');
                $('#acctMNameBVR').val('');
                $('#acctLNameBVR').val('');
            }
            else if ($("#corporateRequest").is(":checked"))
            {
                $('#acctFNameBVR').attr('disabled',true);
                $('#acctMNameBVR').attr('disabled',true);
                $('#acctLNameBVR').attr('disabled',true);
                $('#acctFNameBVR').val('Corporate Request');
                $('#acctMNameBVR').val('Corporate Request');
                $('#acctLNameBVR').val('Corporate Request');
            }
        });

        $('#bi_bvr_coborrower_count').on('change',function () {

            var bi_count = $(this).val();
            var coobs_bvr = '';

            for(var i = 1; i<bi_count; i++)
            {
                coobs_bvr +=


                    '                                                            <span class="label label-danger">Business '+(i+1)+'</span>      \n' +
                    '                                                            <div class="row">\n' +
                    '                                                                <div class="form-group col-xs-12">\n' +
                    '                                                                    <label>Business Name</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                                    <input type="text" class="form-control busNameEach-' +i+ '" placeholder="" id="busName-'+i+'" name="busName-'+i+'">\n' +
                    '                                                                </div>\n' +
                    '                                                            </div>\n' +
                    '                                                            <div class="row" style = "padding-top : 20px;">\n' +
                    '                                                                <div class="form-group col-xs-4">\n' +
                    '                                                                    <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                                    <input type="text" class="form-control busNameEach-' +i+ '" placeholder="" id="addressBus-'+i+'" name="addressBus-'+i+'">\n' +
                    '                                                                </div>\n' +
                    '                                                                <div class="form-group col-xs-4">\n' +
                    '                                                                    <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                                    <input type="text" class="form-control" placeholder="" id="municipalityBus-'+i+'" name="municipalityBus-'+i+'" autocomplete="off">\n' +
                    '                                                                </div>\n' +
                    '                                                                <input type="hidden" class = "busNameEach-' +i+ '" id="idMuniOriginalBus-'+i+'">    \n' +
                    '                                                                <div class="form-group col-xs-4" >\n' +
                    '                                                                    <label>Province</label><small style="color: red;"> (Required Field)</small><span id="loadingBus-'+i+'"></span>\n' +
                    '                                                                    <input type="text" class="form-control" placeholder="" id="provinceBus-'+i+'" name="provinceBus-'+i+'" disabled="">\n' +
                    '                                                                </div>\n' +
                    '                                                            <input type="hidden" class = " busNameEach-' +i+ '" id="idMuniBus-'+i+'">      \n' +
                    '                                                            </div>\n'
                ;
            }
            $('#bi_addBus').html(coobs_bvr);

            $('#btn_bi_submit_endorsement').attr('href', bi_count);

            for(var ctr = 1; ctr < bi_count; ctr++)
            {
                fetchMuni2(ctr);
            }
        });
    }
    else if($(this).val()=='EVR')
    {
        $('#type_of_request_selection_bi').html('' +
            '                                         <div id="bi_evr">\n' +
            '                                            <div class="box box-danger">\n' +
            '                                                <div class="box-header with-border">\n' +
            '                                                    <h3 class="box-title">Account Name</h3>\n' +
            '                                                    <div id="radioCorp" class="pull-right" style="display: none;">\n' +
            '                                                       <div class="form-group">\n' +
            '                                                       </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                <div class="box-body">\n' +
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>Last Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input id="acctLNameEVR" name="acctLNameEVR" type="text" class="form-control" placeholder="">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>First Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input id="acctFNameEVR" name="acctFNameEVR" type="text" class="form-control" placeholder="">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>Middle Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input id="acctMNameEVR" name="acctMNameEVR" type="text" class="form-control" placeholder="">\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n' +
            // '                                                               <div class="box box-danger">\n' +
            // '                                                                  <div class="box-header with-border">\n' +
            // '                                                                      <div class = "box-title">Address/es</div>\n' +
            // '                                                                      </div>\n' +
            // '                                                                  <div style="margin-top: 20px">\n' +
            // '                                                                      <div class="box-header with-border">\n' +
            // '                                                                        <b>Present Address</b>\n' +
            // '                                                                       </div>\n' +
            // '                                                                              <div class = "row">\n' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                   <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control" placeholder="" id="bi_present_address_evr" name="bi_present_address_evr">\n' +
            // '                                                                                </div>\n' +
            //
            // '                                                                                <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                   <label>City/Municipality</label><small style="color: orange;"> (Optional Field)</small>\n' +
            // '                                                                                   <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_present_municipality_evr" name="bi_present_municipality_evr" autocomplete="off">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <input type = "hidden" id = "idPresentMuniEvr">' +
            // '                                                                                <div class="form-group col-xs-4">\n' +
            // '                                                                                  <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_evr"></span>\n' +
            // '                                                                                  <input type="text" class="form-control" placeholder="" id="bi_present_province_evr" name="bi_present_province_evr" disabled="">\n' +
            // '                                                                                </div>\n' +
            // '                                                                                <input type = "hidden" id = "idPresentProvEvr">' +
            // '                                                                               </div>\n' +
            // '                                                                 </div>\n' +
            // '                                                                  <input type="checkbox"  id="bi_check_same_address_evr" value="same_address">\n' +
            // '                                                                    <strong>\n' +
            // '                                                                     Check if "Permanent Address" same as "Present Address"\n' +
            // '                                                                     </strong>\n' +
            // '                                                                        <div style="margin-top: 20px">\n' +
            // '                                                                            <div class="box-header with-border">\n' +
            // '                                                                                <b>Permanent Address</b>\n' +
            // '                                                                            </div>\n' +
            // '                                                                                    <div class = "row">\n' +
            // '                                                                                        <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_address_evr" name="bi_permanent_address_evr">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
            // '                                                                                            <label>City/Municipality</label><small style="color: orange;"> (Optional  Field)</small>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_municipality_evr" name="bi_permanent_municipality_evr" autocomplete="off">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                        <input type = "hidden" id = "idPermaMuniEvr">' +
            // '                                                                             <div class="form-group col-xs-4">\n' +
            // '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_evr"></span>\n' +
            // '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_province_evr" name="bi_permanent_province_evr" disabled="">\n' +
            // '                                                                                        </div>\n' +
            // '                                                                                       <input type = "hidden" id = "idPermaProvEvr">' +
            // '                                                                                    </div>\n' +
            // '                                                                        </div>\n' +
            // '                                                                    </div>' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            // '                                            <div class="box box-danger">\n' +
            // '                                                <div class="box-header with-border">\n' +
            // '                                                    <h3 class="box-title">Employer Name and Address</h3>\n' +
            // '                                                       <div class="form-group form-inline col-xs-3 pull-right">\n' +
            // '                                                           <label class="control-label">Number of Employer</label>\n' +
            // '                                                           <select class="form-control" id="bi_evr_coborrower">' +
            // '                                                               <option value="1">1</option>\n' +
            // '                                                               <option value="2">2</option>\n' +
            // '                                                               <option value="3">3</option>\n' +
            // '                                                               <option value="4">4</option>\n' +
            // '                                                               <option value="5">5</option>\n' +
            // '                                                               <option value="6">6</option>\n' +
            // '                                                               <option value="7">7</option>\n' +
            // '                                                               <option value="8">8</option>' +
            // '                                                               <option value="9">9</option>' +
            // '                                                               <option value="10">10</option>' +
            // '                                                               <option value="11">11</option>\n' +
            // '                                                           </select>\n' +
            // '                                                       </div>\n' +
            // '                                                </div>\n' +
            // '                                                <div class="box-body">\n' +
            // '                                                    <span class="label label-danger">Employer 1</span>\n' +
            // '                                                    <div class="row">\n' +
            // '                                                        <div class="form-group col-xs-12">\n' +
            // '                                                            <label>Employer Name</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                            <input type="text" class="evr_emp-0 form-control" placeholder="" id="evrEmpName-0" name="evrEmpName-0">\n' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            // '                                                    <div class="row">\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                            <input type="text" class="form-control evr_emp-0" placeholder="" id="addressEmp-0" name="addressEmp-0">\n' +
            // '                                                        </div>\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small><span id="loadingEmp-'+i+'"></span>\n' +
            // '                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="municipalityEmp-0" name="municipalityEmp-0" autocomplete="off">\n' +
            // '                                                        </div>\n' +
            // '                                                        <input type="hidden" class = "evr_emp-0" id="idMuniOriginalEmp-0">\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>Province</label><small style="color: red;"> (Required Field)</small>\n' +
            // '                                                            <input type="text" class="form-control" placeholder="" id="provinceEmp-0" name="provinceEmp-0" disabled="">\n' +
            // '                                                        </div>\n' +
            // '                                                        <input type="hidden" class = "evr_emp-0" id="idMuniEmp-0">\n' +
            // '                                                    </div>\n' +
            // '                                                    <span id="bi_addEmp"></span>\n' +
            // '                                                </div>\n' +
            // '                                            </div>\n' +
            '                                                        <div class="box box-danger">\n' +
            '                                                            <div class="box-header with-border">\n' +
            '                                                                <div class = "box-title">Attachments</div><small style="color: red;"> (Required atleast 1 attachment)</small>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="box-body">\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 1 (Application Form)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach1">\n' +
            '\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 2(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach2">\n' +
            '\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                                <div class="row">\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 3(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach3">\n' +
            '\n' +
            '                                                                    </div>\n' +
            '                                                                    <div class="form-group col-md-6">\n' +
            '                                                                        <label>Attachment 4(Supporting Document)</label>\n' +
            '                                                                        <input class="bi_attached_file" type="file" id="attach4">\n' +
            '\n' +
            '                                                                    </div>\n' +
            '                                                                </div>\n' +
            '                                                            </div>\n' +
            '                                                        </div>' +
            '                                            <div class="box box-danger">\n' +
            '                                                <div class="box-header with-border">\n' +
            '                                                    <h3 class="box-title">Other Information</h3>\n' +
            '                                                </div>\n' +
            '                                                <div class="box-body">\n' +
            // '                                                    <div class="row">\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>Type of Loan:</label>\n' +
            // '                                                            <select class="form-control select1" style="width: 100%" id="loanTypeEVR" name="loanTypeEVR">\n' +
            // '                                                                <option value="----(Undefined)">----(Undefined)</option>\n' +
            // '                                                                <option value="Auto Loan">Auto Loan</option>\n' +
            // '                                                                <option value="Personal Loan">Personal Loan</option>\n' +
            // '                                                                <option value="Housing Loan">Housing Loan</option>\n' +
            // '                                                                <option value="Small Business Loan">Small Business Loan</option>\n' +
            // '                                                                <option value="Mortgage Loan">Mortgage Loan</option>\n' +
            // '                                                            </select>\n' +
            // '                                                        </div>\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>Endorsement Type:</label>\n' +
            // '                                                            <select class="form-control select1" id="txtPrioritizeEVR" style="width: 100%;">\n' +
            // '                                                                <option selected="selected">Regular</option>\n' +
            // '                                                                <option>Priority Discreet</option>\n' +
            // '                                                            </select>\n' +
            // '                                                        </div>\n' +
            // '                                                        <div class="form-group col-xs-4">\n' +
            // '                                                            <label>Type of Verification:</label>\n' +
            // '                                                            <select class="form-control select1" id="txtVerifyThroughEVR" style="width: 100%;">\n' +
            // '                                                                <option selected="selected">Non Discreet</option>\n' +
            // '                                                                <option>Discreet</option>\n' +
            // '                                                            </select>\n' +
            // '                                                        </div>\n' +
            // '                                                    </div>\n' +
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-12">\n' +
            '                                                            <label>Remarks:</label><small style="color: orange;"> (Optional)</small>\n' +
            '                                                            <textarea id="txtClientRemarksEVR" maxlength="255" class="form-control" rows="3"></textarea>\n' +
                                                                        '<span class="EVRremainingChars">255</span><span>/255</span>' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n' +
            '                                            <div class="box box-danger">\n' +
            '                                                <div class="box-header with-border">\n' +
            '                                                    <h3 class="box-title">Requestor Information</h3><small style="color: red;"> (Required Field)</small>\n' +
            '                                                </div>\n' +
            '                                                <div class="box-body">\n' +
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-12">\n' +
            '                                                            <label>Name of Requestor:</label>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="requestorNameEVR" name="requestorNameEVR">\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n' +
            '                                        </div>\n'
        );
        
        // Client remarks counter EVR -chano
        var max_length = 255;
        $('#txtClientRemarksEVR').keyup(function () {
            var len = max_length - $(this).val().length;
            $('.EVRremainingChars').text(len);
        });
        
        
        $('#btn_bi_submit_endorsement').attr('name', 'EVR');
        fetchMuni3(0);
        fetchMuniEVRPresent();
        fetchMuniEVRPerma();
        sameEVRPrePerma();

        $('#btn_bi_submit_endorsement').attr('href', 1);

        $('#bi_evr_coborrower').on('change',function () {

            var evr_count = $(this).val();
            var coob_evr = '';

            for(var i = 1; i<evr_count; i++)
            {
                coob_evr +=
                    '                                                    <span class="label label-danger">Employer '+(i+1)+'</span>\n' +
                    '                                                    <div class="row">\n' +
                    '                                                        <div class="form-group col-xs-12">\n' +
                    '                                                            <label>Employer Name</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                            <input type="text" class="evr_emp-'+i+' form-control" placeholder="" id="evrEmpName-'+i+'" name="evrEmpName-'+i+'">\n' +
                    '                                                        </div>\n' +
                    '                                                    </div>\n' +
                    '                                                    <div class="row">\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                            <input type="text" class="evr_emp-'+i+' form-control" placeholder="" id="addressEmp-'+i+'" name="addressEmp-'+i+'">\n' +
                    '                                                        </div>\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="municipalityEmp-'+i+'" name="municipalityEmp-'+i+'" autocomplete="off">\n' +
                    '                                                        </div>\n' +
                    '                                                        <input type="hidden" class = "evr_emp-'+i+'" id="idMuniOriginalEmp-'+i+'">\n' +
                    '                                                        <div class="form-group col-xs-4">\n' +
                    '                                                            <label>Province</label><small style="color: red;"> (Required Field)</small>\n' +
                    '                                                            <input type="text" class="form-control" placeholder="" id="provinceEmp-'+i+'" name="provinceEmp-'+i+'" disabled="">\n' +
                    '                                                        </div>\n' +
                    '                                                        <input type="hidden" class = "evr_emp-'+i+'" id="idMuniEmp-'+i+'">\n' +
                    '                                                    </div>\n';
            }

            $('#bi_addEmp').html(coob_evr);

            $('#btn_bi_submit_endorsement').attr('href', evr_count);

            for(var ctr = 1; ctr < evr_count; ctr++)
            {
                fetchMuni3(ctr);
            }

        });
    }
    else
    {
        $('#type_of_request_selection_bi').html('');
    }
    $('#btn_bi_submit_endorsement').show();

});

function fetchMuniPdrnPresent(count)
{
    var ext = '';

    if(count === '')
    {
        ext = '';

    }
    else
    {
        ext = '-'+count;
    }

    console.log('check count:' +ext);

    $('#bi_present_municipality_pdrn'+ext+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idPresentProv'+ext+'').val(ui.item.muniID);
            $('#idPresentMuni'+ext+'').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchPresentPdrnProv(ext);
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_present_municipality_pdrn'+ext+'').on('change',function ()
    {
        setTimeout(function () {
            if($('#bi_present_municipality_pdrn'+ext+'').val() == null || $('#bi_present_municipality_pdrn'+ext+'').val() == '')
            {
                $('#bi_present_province_pdrn'+ext+'').val('');
            }
            if($('#bi_present_province_pdrn'+ext+'').val() == null || $('#bi_present_province_pdrn'+ext+'').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_present_municipality_pdrn'+ext+'').focus();
            }
        },2000);

    });

    $('#bi_present_municipality_pdrn'+ext+'').focusout(function ()
    {
        if($('#bi_present_municipality_pdrn'+ext+'').val() === '')
        {
            $('#bi_present_province_pdrn'+ext+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_present_municipality_pdrn'+ext+'').val()
                    },
                success: function (data)
                {
                    $('#idPresentProv'+ext+'').val(data[0].province_id);
                    $('#idPresentMuni'+ext+'').val(data[0].id);
                    console.log($('#idPresentProv'+ext+'').val());
                    console.log($('#idPresentMuni'+ext+'').val());
                    fetchPresentPdrnProv(ext);

                    setTimeout(function () {
                        $('#bi_present_municipality_pdrn'+ext+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchPresentPdrnProv(ext)
{
    muniID = $('#idPresentProv'+ext+'').val();
    originalMuniID = $('#idPresentMuni'+ext+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_present_Muni_pdrn'+ext+'').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            $('#loading_present_Muni_pdrn'+ext+'').html('');
            $('#bi_present_province_pdrn'+ext+'').val('');
            // $('#idEtar'+ext+'').val('');
            $('#bi_present_province_pdrn'+ext+'').val(data[0][0].name);
            // $('#idEtar'+ext+'').val(data[1][0].rate);
        }
    });
}

function fetchMuniPdrnPermanent(count)
{
    var ext = '';

    if(count === '')
    {
        ext = '';
    }
    else
    {
        ext = '-'+count;
    }

    console.log('check count:' +ext);

    $('#bi_permanent_municipality_pdrn'+ext+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            // console.log(ui.item.muniID);
            $('#idPermaProv'+ext+'').val(ui.item.muniID);
            $('#idPermaMuni'+ext+'').val(ui.item.originalMuniID);

            console.log($('#idPermaProv'+ext+'').val());
            console.log($('#idPermaMuni'+ext+'').val());

            var clearTime = setInterval(function ()
            {
                fetchPermanentPdrnProv(ext);
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_permanent_municipality_pdrn'+ext+'').on('change',function ()
    {
        setTimeout(function ()
        {
            if($('#bi_permanent_municipality_pdrn'+ext+'').val() == null || $('#bi_permanent_municipality_pdrn'+ext+'').val() == '')
            {
                $('#bi_permanent_province_pdrn'+ext+'').val('');

            }
            if($('#bi_permanent_province_pdrn'+ext+'').val() == null || $('#bi_permanent_province_pdrn'+ext+'').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_permanent_municipality_pdrn'+ext+'').focus();
            }
        },2000);

    });

    $('#bi_permanent_municipality_pdrn'+ext+'').focusout(function ()
    {
        if($('#bi_permanent_municipality_pdrn'+ext+'').val() === '')
        {
            $('#bi_permanent_province_pdrn'+ext+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_permanent_municipality_pdrn'+ext+'').val()
                    },
                success: function (data)
                {
                    $('#idPermaProv'+ext+'').val(data[0].province_id);
                    $('#idPermaMuni'+ext+'').val(data[0].id);



                    fetchPermanentPdrnProv(ext);

                    setTimeout(function () {
                        $('#bi_permanent_municipality_pdrn'+ext+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}
function fetchPermanentPdrnProv(ext)
{
    muniID = $('#idPermaProv'+ext+'').val();
    originalMuniID = $('#idPermaMuni'+ext+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_permanent_Prov_pdrn'+ext+'').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data)
            $('#loading_permanent_Prov_pdrn'+ext+'').html('');
            $('#bi_permanent_province_pdrn'+ext+'').val('');
            // $('#idEtar'+ext+'').val('');
            $('#bi_permanent_province_pdrn'+ext+'').val(data[0][0].name);
            // $('#idEtar'+ext+'').val(data[1][0].rate);
        }
    });
}

function fetchMuni2(count)
{
    var ext = '';

    if(count === '')
    {
        ext = '';

    }
    else
    {
        ext = '-'+count;
    }

    console.log('check count:' +ext);

    $('#municipalityBus'+ext+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            console.log(ui.item.muniID);
            $('#idMuniBus'+ext+'').val(ui.item.muniID);
            $('#idMuniOriginalBus'+ext+'').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv2(ext);
                clearInterval(clearTime);
            },10)
        }
    });

    $('#municipalityBus'+ext+'').on('change',function ()
    {
        console.log($('#provinceBus'+ext+'').val());
        setTimeout(function () {
            if($('#municipalityBus'+ext+'').val() < 1)
            {
                $('#provinceBus'+ext+'').val('');
            }
            if($('#provinceBus-'+ext+'').val() < 1)
            {
                alert("Please choose City/Municipality Under  Suggestion List");
                $('#municipalityBus'+ext+'').focus();
            }
        },2000);

    });

    $('#municipalityBus'+ext+'').focusout(function ()
    {
        if($('#municipalityBus'+ext+'').val() === '')
        {
            $('#provinceBus'+ext+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#municipalityBus'+ext+'').val()
                    },
                success: function (data)
                {
                    $('#idMuniBus'+ext+'').val(data[0].province_id);
                    $('#idMuniOriginalBus'+ext+'').val(data[0].id);
                    fetchProv2(ext);
                    setTimeout(function () {
                        $('#municipalityBus'+ext+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchProv2(ext)
{
    muniID = $('#idMuniBus'+ext+'').val();
    originalMuniID = $('#idMuniOriginalBus'+ext+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loadingBus'+ext+'').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data)
            $('#loadingBus'+ext+'').html('');
            $('#provinceBus'+ext+'').val('');
            $('#idEtar'+ext+'').val('');
            $('#provinceBus'+ext+'').val(data[0][0].name);
            // $('#idEtar'+ext+'').val(data[1][0].rate);
        }
    });
}

//

function fetchMuni3(count)
{
    var ext = '';

    if(count === '')
    {
        ext = '';

    }
    else
    {
        ext = '-'+count;
    }

    console.log('check count:' +ext);

    $('#municipalityEmp'+ext+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            console.log(ui.item.muniID);
            $('#idMuniEmp'+ext+'').val(ui.item.muniID);
            $('#idMuniOriginalEmp'+ext+'').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv3(ext);
                clearInterval(clearTime);
            },10)
        }
    });

    $('#municipalityEmp'+ext+'').on('change',function ()
    {
        setTimeout(function () {
            if($('#municipalityEmp'+ext+'').val() < 1)
            {
                $('#provinceEmp'+ext+'').val('');
            }
            if($('#provinceEmp'+ext+'').val() < 1)
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#municipalityEmp'+ext+'').focus();
            }
        },2000);

    });

    $('#municipalityEmp'+ext+'').focusout(function ()
    {
        if($('#municipalityEmp'+ext+'').val() === '')
        {
            $('#provinceEmp'+ext+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#municipalityEmp'+ext+'').val()
                    },
                success: function (data)
                {
                    $('#idMuniEmp'+ext+'').val(data[0].province_id);
                    $('#idMuniOriginalEmp'+ext+'').val(data[0].id);

                    console.log( $('#idMuniEmp'+ext+'').val());
                    console.log($('#idMuniOriginalEmp'+ext+'').val());

                    fetchProv3(ext);
                    setTimeout(function () {
                        $('#municipalityEmp'+ext+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}
function fetchProv3(ext)
{
    muniID = $('#idMuniEmp'+ext+'').val();
    originalMuniID = $('#idMuniOriginalEmp'+ext+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loadingEmp'+ext+'').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data)
            $('#loadingEmp'+ext+'').html('');
            $('#provinceEmp'+ext+'').val('');
            $('#idEtarEmp'+ext+'').val('');
            $('#provinceEmp'+ext+'').val(data[0][0].name);
            // $('#idEtar'+ext+'').val(data[1][0].rate);
        }
    });
}

function clickcheckbox(i)
{
    $('#coborCheckSameAdd-'+i+'').click(function()
    {

        if($(this).is(":checked"))
        {
            // console.log('check');
            $('#bi_present_municipality_pdrn-'+i+'').attr('disabled','disabled');
            $('#bi_present_address_pdrn-'+i+'').attr('disabled','disabled');
            $('#bi_permanent_municipality_pdrn-'+i+'').attr('disabled','disabled');
            $('#bi_permanent_province_pdrn-'+i+'').attr('disabled','disabled');
            $('#bi_present_province_pdrn-'+i+'').attr('disabled','disabled');
            $('#bi_permanent_address_pdrn-'+i+'').attr('disabled', 'disabled');


            // console.log($('#municipality').val());
            $('#bi_present_municipality_pdrn-'+i+'').val($('#bi_present_municipality_pdrn').val());
            $('#bi_present_address_pdrn-'+i+'').val($('#bi_present_address_pdrn').val());
            $('#bi_permanent_municipality_pdrn-'+i+'').val($('#bi_permanent_municipality_pdrn').val());
            $('#bi_permanent_address_pdrn-'+i+'').val($('#bi_permanent_address_pdrn').val());

            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' :  $('#bi_present_municipality_pdrn-'+i+'').val()
                    },
                success: function (data)
                {
                    $('#idPresentProv-'+i+'').val(data[0].province_id);
                    $('#idPresentMuni-'+i+'').val(data[0].id);
                    //
                    fetchPresentPdrnProv('-' + i);

                    console.log(data);

                    setTimeout(function ()
                    {
                        $('#bi_present_municipality_pdrn-'+i+'').val(data[0].muni_name);
                    },1000);

                    $.ajax
                    ({
                        method: 'get',
                        url: '/fetch-city-muniv2',
                        data:
                            {
                                'muniname': $('#bi_permanent_municipality_pdrn-' + i + '').val()
                            },
                        success: function (data) {
                            $('#idPermaProv-'+ i +'').val(data[0].province_id);
                            $('#idPermaMuni-'+ i +'').val(data[0].id);



                            fetchPermanentPdrnProv('-' + i);

                            setTimeout(function () {
                                $('#bi_permanent_municipality_pdrn-' + i + '').val(data[0].muni_name);
                            }, 1000);
                        }
                    });

                }
            });
        }
        else
        {
            // console.log('uncheck');
            $('#bi_present_municipality_pdrn-'+i+'').removeAttr('disabled');
            $('#bi_present_address_pdrn-'+i+'').removeAttr('disabled');
            $('#bi_permanent_municipality_pdrn-'+i+'').removeAttr('disabled');
            $('#bi_permanent_address_pdrn-'+i+'').removeAttr('disabled');

            $('#bi_present_municipality_pdrn-'+i+'').val('');
            $('#bi_present_address_pdrn-'+i+'').val('');
            $('#bi_permanent_municipality_pdrn-'+i+'').val('');
            $('#bi_permanent_province_pdrn-'+i+'').val('');
            $('#bi_present_province_pdrn-'+i+'').val('');
            $('#bi_permanent_address_pdrn-'+i+'').val('');
        }
    });
}

$('.checkbox_sameadd').click(function () {
    // console.log('click class');
    $('#coborCheckSameAdd-'+$(this).attr('name')+'').click();
});



function isEmptyOrSpaces(str)
{
    return str === null || str.match(/^ *$/) !== null;
}
$('.remarksText').hide();

var ctr4uploadBI_add = 0;
var ctr4uploadBI_off = 0;
$('#bi_client_finished_table').on('click','.btn_return_after',function () {
    $('.test1').attr('checked', false);
    $('.othersCheck').attr('checked', false);
    globalIDReturn = $(this).attr('id');
    statusForReturn = $(this).attr("name");
    $('.remarksText').hide();
    ctr4uploadBI_add = 0;
    ctr4uploadBI_off = 0;

    var upload_ng_kulang_add = '' +
        '<div class="form-group">\n' +
        '    <div class="row">\n' +
        '        <div class="col-md-4"></div>\n' +
        '            <div class="col-md-4">\n' +
        '                <label for="neededFile" style="color: red; font-weight: bold">Choose a file to upload:</label>\n' +
        '                <input type="file" class="add_attachment_get" id="neededFile-add_exampleCheck-'+globalIDReturn+'">\n' +
        '                <button class="btn btn-sm btn-success" id="add_attachment_add" style="margin-top: 10px; margin-bottom: 10px;"><i class="glyphicon glyphicon-plus"></i></button>\n' +
        '            </div>\n' +
        '        <div class="col-md-4"></div>\n' +
        '    </div>\n' +
        '    <span id="add_add"></span>\n' +
        '</div>';

    var upload_ng_kulang_off = '' +
        '<div class="form-group">\n' +
        '                        <div class="row">\n' +
        '                                <div class="col-md-12">\n' +
        '                                     <input type="checkbox" value=" HRSS" class="close_accs icheckbox_minimal-blue" id="close_account_hrss">\n' +
        '                                    <label class="form-check-label" for="close_account_hrss"> HRSS</label>\n' +
        '                                     <input type="checkbox" value=" Recruitment" class="close_accs icheckbox_minimal-blue"  id="close_account_recruitment">\n' +
        '                                    <label class="form-check-label" for="close_account_recruitment"> Recruitment</label>\n' +
        '                                     <input type="checkbox" value=" Manager" class="close_accs icheckbox_minimal-blue"  id="close_account_manager">\n' +
        '                                    <label class="form-check-label" for="close_account_manager"> Manager</label>\n' +
        '                                      <input type="checkbox" value=" OPS" class="close_accs icheckbox_minimal-blue"  id="close_account_ops">\n' +
        '                                    <label class="form-check-label" for="close_account_ops"> OPS</label>\n' +
        '                                 </div>\n' +
        '                                </div>'+
        '    <div class="row">\n' +
        '        <div class="col-md-4"></div>\n' +
        '            <div class="col-md-4">\n' +
        '                <label for="neededFile" style="color: red; font-weight: bold">Choose a file to upload:</label>\n' +
        '                <input type="file" class="off_attachment_get" id="neededFile-off_exampleCheck-'+globalIDReturn+'">\n' +
        '                <button class="btn btn-sm btn-success" id="add_attachment_off" style="margin-top: 10px; margin-bottom: 10px;"><i class="glyphicon glyphicon-plus"></i></button>\n' +
        '            </div>\n' +
        '        <div class="col-md-4"></div>\n' +
        '    </div>\n' +
        '    <span id="add_off"></span>\n' +
        '</div>';

    $.ajax
    ({
        url: 'bi-return-check-data',
        type: 'post',
        data: {
            'status': statusForReturn
        },
        beforeSend: function(){
            $('#modal-loading').show();
        },
        success: function(data)
        {
            $('#tblCheckings').html(data);

        },
        complete: function()
        {
            $('.othersCheck').click(function()
            {
                if ($('.othersCheck').is(':checked'))
                {
                    $('.remarksText').show();
                }
                else
                {
                    $('.remarksText').hide();
                }
            });

            $('.test1').click(function()
            {

                if($(this).val() == ' Additional attachment')
                {
                    var name_gago_si_ranyll = $(this).attr('id');
                    console.log('click add');

                    $('#uploadNow-'+name_gago_si_ranyll).html('');

                    $('#needFileAdditional-'+name_gago_si_ranyll).show();


                    if ($(this).is(':checked'))
                    {
                        console.log(name_gago_si_ranyll);


                        $('#needFileAdditional-'+name_gago_si_ranyll).show();


                        $('#uploadNow-'+name_gago_si_ranyll).html(upload_ng_kulang_add);


                        $('#add_attachment_add').click(function(e)
                        {
                            ctr4uploadBI_add++;
                            e.preventDefault();

                            var addAttach = '<div class="row" id="rowRemove-'+name_gago_si_ranyll+'-'+ctr4uploadBI_add+'">\n' +
                                '        <div class="col-md-4"></div>\n' +
                                '        <div class="col-md-4">\n' +
                                '            <input type="file" class="add_attachment_get" id="neededFile-'+name_gago_si_ranyll+'">\n' +
                                '            <button class="btn btn-sm btn-danger removeAttachfileeee" name="'+name_gago_si_ranyll+'" id="removeAttachAdd-'+name_gago_si_ranyll+'-'+ctr4uploadBI_add+'" href="'+ctr4uploadBI_add+'" style="margin-top: 10px; margin-bottom: 10px;"><i class="glyphicon glyphicon-minus"></i></button>\n' +
                                '        </div>\n' +
                                '        <div class="col-md-4"></div>\n' +
                                '    </div>';

                            $('#add_add').append(addAttach);
                        });
                    }
                    else
                    {
                        $('#needFileAdditional-'+name_gago_si_ranyll).hide();
                        $('#uploadNow-'+name_gago_si_ranyll).html('');
                    }
                }

                if($(this).val() == ' Close Account')
                {
                    var name_gago_si_ranyll = $(this).attr('id');
                    console.log('click off');

                    $('#uploadNow-'+name_gago_si_ranyll).html('');

                    $('#needFileAdditional-'+name_gago_si_ranyll).show();




                    if ($(this).is(':checked'))
                    {
                        $('#needFileAdditional-'+name_gago_si_ranyll).show();
                        $('#uploadNow-'+name_gago_si_ranyll).html(upload_ng_kulang_off);

                        $('#add_attachment_off').click(function(e)
                        {
                            ctr4uploadBI_off++;
                            e.preventDefault();

                            var addAttach =
                                '<div class="row" id="rowRemove-'+name_gago_si_ranyll+'-'+ctr4uploadBI_off+'">\n' +
                                '        <div class="col-md-4"></div>\n' +
                                '        <div class="col-md-4">\n' +
                                '            <input type="file" class="off_attachment_get" id="neededFile_off-'+name_gago_si_ranyll+'" >\n' +
                                '            <button class="btn btn-sm btn-danger removeAttachfileeee" name="'+name_gago_si_ranyll+'" id="removeAttachAdd_off-'+name_gago_si_ranyll+'-'+ctr4uploadBI_off+'" href="'+ctr4uploadBI_off+'" style="margin-top: 10px; margin-bottom: 10px;"><i class="glyphicon glyphicon-minus"></i></button>\n' +
                                '        </div>\n' +
                                '        <div class="col-md-4"></div>\n' +
                                '    </div>';

                            $('#add_off').append(addAttach);
                        });
                    }
                    else
                    {
                        $('#needFileAdditional-'+name_gago_si_ranyll).hide();
                        $('#uploadNow-'+name_gago_si_ranyll).html('');
                    }
                }
            });

            $('#modal-loading').hide();
        }
    });

    $('#modal-return-account').modal('show');
});

$('#bi_client_return_table').on('click','.btn_viewReason',function ()
{
    var get_endorseID = $(this).attr("name");
    $('#modal-view-reasonDelay').modal("show");

    $.ajax
    (
        {
            type: 'get',
            url: 'bi-get-reason-of-delay',
            data: {
                'id' : get_endorseID
            },
            success: function(data)
            {
                $('#reasonOfDelay').html(data[0].remarks);
            }
        }
    );
});

$('#attach1').change(function()
{
    var file_size = $('#attach1')[0].files[0].size;
    if(file_size  > 26214400)
    {
        $('#attach1').val('');
        alert(warningFile);

        return false;
    }
    return true;
});

$('#attach2').change(function()
{
    var file_size = $('#attach2')[0].files[0].size;
    if(file_size  > 26214400)
    {
        $('#attach2').val('');
        alert(warningFile);

        return false;
    }
    return true;
});

$('#attach3').change(function()
{
    var file_size = $('#attach3')[0].files[0].size;
    if(file_size  > 26214400)
    {
        $('#attach3').val('');
        alert(warningFile);

        return false;
    }
    return true;
});

$('#attach4').change(function()
{
    var file_size = $('#attach4')[0].files[0].size;
    if(file_size  > 26214400)
    {
        $('#attach4').val('');
        alert(warningFile);

        return false;
    }
    return true;
});

$('#btnReturnAccount').on('click',function(e)
{
    var ctr = 0;

    var chicking = '';
    var myData = [];
    var remtoSend ='';

    $('.test1').each(function()
    {
        if($(this).is(':checked'))
        {
            chicking = $(this).val();
            if(chicking == ' Close Account')
            {
                var close_acc = '';
                var count_close = 0;
                var checked = false;
                $('.close_accs').each(function () {
                    if($(this).is(':checked')) {
                        if(!checked)
                        {
                            checked = true;
                            close_acc = ": ";
                        }

                        if(count_close == 0)
                        {
                            close_acc += $(this).val();
                        }
                        else if(count_close > 0)
                        {
                            close_acc += '/'+$(this).val();
                        }

                        count_close++;
                    }
                });

                myData[ctr] = chicking+close_acc;
                remtoSend += '* ' + chicking +close_acc+ '<br>';
                ctr++;
            }
            else
            {
                myData[ctr] = chicking;
                remtoSend += '* ' + chicking + '<br>';
                ctr++;
            }
        }
    });


    var formData = new FormData();


    var count_add = 0;
    $('.add_attachment_get').each(function () {
        var file_name_add =  $(this).prop('files')[0];
        formData.append('uploadedFile_add_'+count_add ,file_name_add);
        count_add++;
    });

    var count_off = 0;
    $('.off_attachment_get').each(function () {
        var file_name_off =  $(this).prop('files')[0];
        formData.append('uploadedFile_off_'+count_off ,file_name_off);
        count_off++;
    });

    formData.append('id', globalIDReturn);

    var rem_remars = '';

    if($('.remarksText').val() == '')
    {
        rem_remars = remtoSend;
    }
    else
    {
        rem_remars = remtoSend + '*' + $('.remarksText').val();
    }

    formData.append('remarks',rem_remars);

    formData.append('count_add', count_add);
    formData.append('count_off', count_off);

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
                    $('#ulPercentage_bi_return').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_bi_return').append(Math.floor(percentComplete*100));
                    $('#progressbar_bi_return').show();
                    $('#ulPercentage_bi_return').show();
                    $('#progressbar_bi_return').progressbar
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
            }, false);
            return xhr;
        },
        url: 'bi-get-return-checklist-return',
        type: 'post',
        contentType: false,
        processData: false,
        async : true,
        data: formData,
        beforeSend: function(){
            $('#modal-loading').show();
        },
        success: function(data)
        {
            console.log(data);
            dataCount = 0;
            if(data == 'ok')
            {
                alert('Account Successfully Returned');
                refTables();
            }
            else if(data == 'already')
            {
                alert('Already return by someone. Please see logs.');
                refTables();
            }
        },
        complete: function()
        {
            $('#progressbar_bi_return').hide();
            $('#ulPercentage_bi_return').hide();
            $('#modal-return-account').modal('hide');
            $('.test1').attr("checked", false);
            $('#othersCheck').attr("checked", false);
            $('.remarksText').val('');
            $('#modal-loading').hide();
        }
    });
});

function checkSamePresentPerma(count)
{
    var ext = '';

    if(count === '')
    {
        ext = '';

    }
    else
    {
        ext = '-'+count;
    }

    $('#bi_check_same_address_pdrn'+ ext +'').click(function()
    {
        console.log('hehe');
        if($(this).is(":checked"))
        {
            $('#bi_permanent_address_pdrn'+ ext +'').attr('disabled', 'disabled');
            $('#bi_permanent_municipality_pdrn'+ ext +'').attr('disabled', 'disabled');

            $('#bi_permanent_address_pdrn'+ ext +'').val($('#bi_present_address_pdrn'+ ext +'').val());
            $('#bi_permanent_municipality_pdrn'+ ext +'').val($('#bi_present_municipality_pdrn'+ ext +'').val());

            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname': $('#bi_permanent_municipality_pdrn' + ext + '').val()
                    },
                success: function (data) {
                    $('#idPermaProv'+ ext +'').val(data[0].province_id);
                    $('#idPermaMuni'+ ext +'').val(data[0].id);
                    fetchPermanentPdrnProv(ext);

                    setTimeout(function () {
                        $('#bi_permanent_municipality_pdrn' + ext + '').val(data[0].muni_name);
                    }, 1000);
                }
            });

        }
        else
        {
            $('#bi_permanent_address_pdrn'+ ext +'').removeAttr('disabled');
            $('#bi_permanent_municipality_pdrn'+ ext +'').removeAttr('disabled');
        }
    });
}

function fetchMuniBVRPresent()
{
    $('#bi_present_municipality_bvr').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idPresentProvBvr').val(ui.item.muniID);
            $('#idPresentMuniBvr').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchPresentBVRProv();
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_present_municipality_bvr').on('change',function ()
    {
        console.log($('#bi_present_municipality_bvr').val());
        setTimeout(function () {
            if($('#bi_present_municipality_bvr').val() == null || $('#bi_present_municipality_bvr').val() == '')
            {
                $('#bi_present_province_bvr').val('');
            }
            if($('#bi_present_province_bvr').val() == null || $('#bi_present_province_bvr').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_present_municipality_bvr').focus();
            }
        },2000);

    });

    $('#bi_present_municipality_bvr').focusout(function ()
    {
        if($('#bi_present_municipality_bvr').val() === '')
        {
            $('#bi_present_province_bvr').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_present_municipality_bvr').val()
                    },
                success: function (data)
                {
                    $('#idPresentProvBvr').val(data[0].province_id);
                    $('#idPresentMuniBvr').val(data[0].id);

                    console.log( $('#idPresentProvBvr').val());
                    console.log ($('#idPresentMuniBvr').val());

                    fetchPresentBVRProv();

                    setTimeout(function ()
                    {
                        $('#bi_present_municipality_bvr').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchPresentBVRProv()
{
    muniID = $('#idPresentProvBvr').val();
    originalMuniID = $('#idPresentMuniBvr').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_present_bvr').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_present_bvr').html('');
            $('#bi_present_province_bvr').val('');
            $('#bi_present_province_bvr').val(data[0][0].name)
        }
    });
}


function fetchMuniBVRPerma()
{
    $('#bi_permanent_municipality_bvr').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idPermaProvBvr').val(ui.item.muniID);
            $('#idPermaMuniBvr').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchPermaBVRProv();
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_permanent_municipality_bvr').on('change',function ()
    {
        setTimeout(function () {
            if($('#bi_permanent_municipality_bvr').val() == null || $('#bi_permanent_municipality_bvr').val() == '')
            {
                $('#bi_permanent_province_bvr').val('');
            }
            if($('#bi_permanent_province_bvr').val() == null || $('#bi_permanent_province_bvr').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_permanent_municipality_bvr').focus();
            }
        },2000);

    });

    $('#bi_permanent_municipality_bvr').focusout(function ()
    {
        if($('#bi_permanent_municipality_bvr').val() === '')
        {
            $('#bi_permanent_province_bvr').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_permanent_municipality_bvr').val()
                    },
                success: function (data)
                {
                    $('#idPermaProvBvr').val(data[0].province_id);
                    $('#idPermaMuniBvr').val(data[0].id);
                    fetchPermaBVRProv();

                    setTimeout(function ()
                    {
                        $('#bi_permanent_municipality_bvr').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchPermaBVRProv()
{
    console.log( $('#idPermaProvBvr').val());
    console.log($('#idPermaMuniBvr').val());

    muniID = $('#idPermaProvBvr').val();
    originalMuniID = $('#idPermaMuniBvr').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_permanent_bvr').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_permanent_bvr').html('');
            $('#bi_permanent_province_bvr').val('');
            $('#bi_permanent_province_bvr').val(data[0][0].name)
        }
    });
}

function sameBVRPrePerma()
{
    $('#bi_check_same_address_bvr').click(function()
    {
        if($(this).is(":checked"))
        {
            $('#bi_permanent_address_bvr').attr('disabled', 'disabled');
            $('#bi_permanent_municipality_bvr').attr('disabled', 'disabled');

            $('#bi_permanent_address_bvr').val($('#bi_present_address_bvr').val());
            $('#bi_permanent_municipality_bvr').val($('#bi_present_municipality_bvr').val());

            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname': $('#bi_permanent_municipality_bvr').val()
                    },
                success: function (data) {
                    $('#idPermaProvBvr').val(data[0].province_id);
                    $('#idPermaMuniBvr').val(data[0].id);
                    fetchPermaBVRProv();

                    setTimeout(function () {
                        $('#bi_permanent_municipality_bvr').val(data[0].muni_name)
                    }, 1000);
                }
            });
        }
        else
        {
            $('#bi_permanent_address_bvr').removeAttr('disabled');
            $('#bi_permanent_municipality_bvr').removeAttr('disabled');
        }
    });
}


function fetchMuniEVRPresent()
{
    $('#bi_present_municipality_evr').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idPresentProvEvr').val(ui.item.muniID);
            $('#idPresentMuniEvr').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchPresentEVRProv();
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_present_municipality_evr').on('change',function ()
    {
        console.log($('#bi_present_municipality_evr').val());
        setTimeout(function () {
            if($('#bi_present_municipality_evr').val() == null || $('#bi_present_municipality_evr').val() == '')
            {
                $('#bi_present_province_evr').val('');
            }
            if($('#bi_present_province_evr').val() == null || $('#bi_present_province_evr').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_present_municipality_evr').focus();
            }
        },2000);

    });

    $('#bi_present_municipality_evr').focusout(function ()
    {
        if($('#bi_present_municipality_evr').val() === '')
        {
            $('#bi_present_province_evr').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_present_municipality_evr').val()
                    },
                success: function (data)
                {
                    $('#idPresentProvEvr').val(data[0].province_id);
                    $('#idPresentMuniEvr').val(data[0].id);

                    console.log( $('#idPresentProvBvr').val());
                    console.log ($('#idPresentMuniBvr').val());

                    fetchPresentEVRProv();

                    setTimeout(function ()
                    {
                        $('#bi_present_municipality_evr').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchPresentEVRProv()
{
    muniID = $('#idPresentProvEvr').val();
    originalMuniID = $('#idPresentMuniEvr').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_present_evr').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_present_evr').html('');
            $('#bi_present_province_evr').val('');
            $('#bi_present_province_evr').val(data[0][0].name)
        }
    });
}


function fetchMuniEVRPerma()
{
    $('#bi_permanent_municipality_evr').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idPermaProvEvr').val(ui.item.muniID);
            $('#idPermaMuniEvr').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchPermaEVRProv();
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_permanent_municipality_evr').on('change',function ()
    {
        setTimeout(function () {
            if($('#bi_permanent_municipality_evr').val() == null || $('#bi_permanent_municipality_evr').val() == '')
            {
                $('#bi_permanent_province_evr').val('');
            }
            if($('#bi_permanent_province_evr').val() == null || $('#bi_permanent_province_evr').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_permanent_municipality_evr').focus();
            }
        },2000);

    });

    $('#bi_permanent_municipality_evr').focusout(function ()
    {
        if($('#bi_permanent_municipality_evr').val() === '')
        {
            $('#bi_permanent_province_evr').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_permanent_municipality_evr').val()
                    },
                success: function (data)
                {
                    $('#idPermaProvEvr').val(data[0].province_id);
                    $('#idPermaMuniEvr').val(data[0].id);
                    fetchPermaEVRProv();

                    setTimeout(function ()
                    {
                        $('#bi_permanent_municipality_evr').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchPermaEVRProv()
{
    console.log( $('#idPermaProvEvr').val());
    console.log($('#idPermaMuniEvr').val());

    muniID = $('#idPermaProvEvr').val();
    originalMuniID = $('#idPermaMuniEvr').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loading_permanent_evr').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_permanent_evr').html('');
            $('#bi_permanent_province_evr').val('');
            $('#bi_permanent_province_evr').val(data[0][0].name)
        }
    });
}

function sameEVRPrePerma()
{
    $('#bi_check_same_address_evr').click(function()
    {
        if($(this).is(":checked"))
        {
            $('#bi_permanent_address_evr').attr('disabled', 'disabled');
            $('#bi_permanent_municipality_evr').attr('disabled', 'disabled');

            $('#bi_permanent_address_evr').val($('#bi_present_address_evr').val());
            $('#bi_permanent_municipality_evr').val($('#bi_present_municipality_evr').val());

            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname': $('#bi_permanent_municipality_evr').val()
                    },
                success: function (data) {
                    $('#idPermaProvEvr').val(data[0].province_id);
                    $('#idPermaMuniEvr').val(data[0].id);
                    fetchPermaEVRProv();

                    setTimeout(function () {
                        $('#bi_permanent_municipality_evr').val(data[0].muni_name)
                    }, 1000);
                }
            });
        }
        else
        {
            $('#bi_permanent_address_evr').removeAttr('disabled');
            $('#bi_permanent_municipality_evr').removeAttr('disabled');
        }
    });
}
var counterAdditionalAdd = 0;



$('#AddNewAddressBiClient').click(function()
{

    counterAdditionalAdd++;
    var newAddress = '<div class="box-header with-border row_other-'+counterAdditionalAdd+'">\n' +
        '                                                                            <div class = "box-title" >Other Address <span>'+counterAdditionalAdd+'</span></div></div>\n' +
        '                                                                        <div class="box row_other-'+counterAdditionalAdd+'">\n' +
        '                                                                            <div class="box-body">\n' +
        '                                                                                <div>\n' +
        '                                                                                    <div class = "row">\n' +
        '                                                                                        <input type="hidden" id="bi_other_idProvince-'+counterAdditionalAdd+'" class = "additionalAddressBi">\n' +
        '                                                                                        <input type="hidden" id="bi_other_idMunicipality-'+counterAdditionalAdd+'">\n' +
        '                                                                                        <div class="form-group col-xs-4">\n' +
        '                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
        '                                                                                            <input type="text" class="additionalAddressBi-'+counterAdditionalAdd+' form-control" placeholder="" id="bi_other_address-'+counterAdditionalAdd+'" name="address">\n' +
        '                                                                                        </div>\n' +
        '                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
        '                                                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
        '                                                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_other_municipality-'+counterAdditionalAdd+'" name="municipality" autocomplete="off">\n' +
        '                                                                                        </div>\n' +
        '                                                                                        <div class="form-group col-xs-4">\n' +
        '                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_other_Prov-'+counterAdditionalAdd+'"></span>\n' +
        '                                                                                            <input type="text" class="form-control" placeholder="" id="bi_other_province-'+counterAdditionalAdd+'" name="province" disabled="">\n' +
        '                                                                                        </div>\n' +
        '                                                                                    </div>\n' +
        '                                                                                </div>\n' +
        '                                                                            </div>\n' +
        '                                                                        </div>';
    $('#addAdditionalAddressBi').append(newAddress);
    var i;

    for(i = 1; i <= counterAdditionalAdd; i++)
    {
        fetchMuniotherAdd(i);
    }
    // $('#btn_bi_submit_endorsement').attr('href', counterAdditionalAdd);

    if(counterAdditionalAdd != 0)
    {
        $('#remove_div').show();
    }
});

$('#RemoveAddressBiClient').click(function()
{

    if(counterAdditionalAdd > 0)
    {
        $('.row_other-'+counterAdditionalAdd+'').remove();

        counterAdditionalAdd--;

        if(counterAdditionalAdd <= 0)
        {
            console.log('do nothing');
            $('#remove_div').hide();
        }
    }


});

function fetchMuniotherAdd(id)
{
    $('#bi_other_municipality-'+id+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#bi_other_idProvince-'+id+'').val(ui.item.muniID);
            $('#bi_other_idMunicipality-'+id+'').val(ui.item.originalMuniID);

            var clearTime = setInterval(function ()
            {
                fetchProvotherAdd(id);
                clearInterval(clearTime);
                // console.log('qqqqqqqqqqqqqqqqq')
            },10)
        }
    });

    $('#bi_other_municipality-'+id+'').on('change',function ()
    {
        setTimeout(function () {
            if($('#bi_other_municipality-'+id+'').val() == null || $('#bi_other_municipality-'+id+'').val() == '')
            {
                $('#bi_other_province-'+id+'').val('');
            }
            if($('#bi_other_municipality-'+id+'').val() == null || $('#bi_other_municipality-'+id+'').val() == '')
            {
                alert("Please choose City/Municipality Under Suggestion List");
                $('#bi_other_municipality-'+id+'').focus();
            }
        },2000);

    });

    $('#bi_other_municipality-'+id+'').focusout(function ()
    {
        if($('#bi_other_municipality-'+id+'').val() === '')
        {
            $('#bi_other_province-'+id+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#bi_other_municipality-'+id+'').val()
                    },
                success: function (data)
                {
                    $('#bi_other_idProvince-'+id+'').val(data[0].province_id);
                    $('#bi_other_idMunicipality-'+id+'').val(data[0].id);

                    console.log( $('#bi_other_idProvince-'+id+'').val());
                    console.log ($('#bi_other_idMunicipality-'+id+'').val());

                    fetchProvotherAdd(id);

                    setTimeout(function ()
                    {
                        $('#bi_other_municipality-'+id+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function fetchProvotherAdd(id)
{
    provIdAdditionalAdd = $('#bi_other_idProvince-'+id+'').val();
    muniIdAdditionalAdd = $('#bi_other_idMunicipality-'+id+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': provIdAdditionalAdd,
                'originalMuniID': muniIdAdditionalAdd
            },
        beforeSend: function ()
        {
            $('#loading_other_Prov-'+id+'').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loading_other_Prov-'+id+'').html('');
            $('#bi_other_province-'+id+'').val('');
            $('#bi_other_province-'+id+'').val(data[0][0].name)
        }
    });
}

$('#view_info_details').on('click', '#clicktoChooseAdditional', function()
{
    $('#chooseFileAdditionalBIFIle').click();
});

$('#view_info_details').on('change', '#chooseFileAdditionalBIFIle', function(e)
{
    if( e.target.files[0] != null)
    {
        $('#fileStat').html(' Ready for Upload');
        $('#submitAdditionalFile').attr('disabled', false);
    }
    else
    {
        $('#fileStat').html(' Choose a file');
        $('#submitAdditionalFile').attr('disabled', true);

    }
});

$('#view_info_details').on('click', '#showAddFac', function()
{
    $('.hideBtntoAdd').hide();
    $('.hideShowFac').fadeIn();
});

$('#view_info_details').on('click', '#submitAdditionalFile', function()
{
    var id = $(this).attr('name');
    var file = $('#chooseFileAdditionalBIFIle').prop('files')[0];

    var formData = new FormData();

    formData.append('id', id);
    formData.append('file', file)

    $('#loadingBarShow').show();

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
                    $('#ulPercentage_addFile').html('');
                    // $('#ulPercentage').append(percentComplete*100);
                    $('#ulPercentage_addFile').append(Math.floor(percentComplete*100));
                    $('#progressbar_addFile').show();
                    $('#progressbar_addFile').progressbar
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
            }, false);
            return xhr;

        },
        type: 'post',
        url: 'bi-client-additional-files-any',
        contentType: false,
        processData: false,
        async: true,
        data: formData,
        success : function(data)
        {
            var remarks = prompt('Successfully uploaded additional files, add remarks:', '');

            if(remarks != '')
            {
                $.ajax
                ({
                    type : 'get',
                    url : 'bi-client-add-rem-add-files-new',
                    data :
                        {
                            'rem' : remarks,
                            'add_id' : data[0],
                            'log_id' : data[1]
                        },
                    success : function()
                    {
                        $('#modal-view-info-bi-universal').modal('hide');
                        $('#loadingBarShow').hide();
                    }
                });
            }
            else
            {
                $('#modal-view-info-bi-universal').modal('hide');
                $('#loadingBarShow').hide();
            }
        }
    });
});

$('#downNowMultiRep').click(function()
{
    var arrayIDs = $.map(table_finished.rows('.selected').data(),function (item)
    {
        return item.endorse_id
    });

    var Ids = arrayIDs.toString();

    var q = '<form action="/bi-client-multiple-dl" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+Ids+'" name="id">'+
        '<button type="submit" hidden id="button_form_download">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#dlNowMulti').html(q);
    $('#button_form_download').click();

    table_finished.rows('.selected').deselect();
});


function getContactNumbers()
{
    $('#applicant_encoded_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    pending_applicants_table = $('#applicant_encoded_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'bi_client_get_pending_applicants',
        "columns":
            [
                {data: 'id', name: 'bi_direct_pivot.id'},
                {data: 'created_at', name: 'bi_direct_pivot.created_at'},
                {
                    data: function site_location(data)
                    {
                        return '' +data.bi_account_name +' '+ data.account_location;
                    },
                    name: 'bi_direct_pivot.created_at',
                    searchable : false,
                    orderable : false
                },
                {data: 'bi_account_name', name: 'bi_direct_pivot.created_at', visible: false},
                {data: 'account_location', name: 'bi_account_list.account_location', visible: false},
                {data: 'direct_name', name: 'bi_direct_pivot.direct_name'},
                {data: 'attachments', name: 'bi_direct_pivot.direct_name'},
                {
                    data: function(data)
                    {
                        if(data.application_status == 'Pending')
                        {
                            return '<label class="bg-yellow color-palette" style="padding: 8px; border-radius: 8px">'+data.application_status+' For Acknowledge</label>';
                        }
                        else if(data.application_status == 'Returned')
                        {
                            return '<label class="bg-yellow color-palette" style="padding: 8px; border-radius: 8px">'+data.application_status+' to Applicant</label>';
                        }
                        else
                        {
                            return '<label class="bg-yellow color-palette" style="padding: 8px; border-radius: 8px">'+data.application_status+'</label>';
                        }
                    }
                    ,name : 'bi_direct_encoded_data.id',
                    searchable : false,
                    orderable : false
                },
                {
                    data:function action(data)
                    {
                        if(data.application_status == 'Returned')
                        {
                            return ''+

                                '<a class="btn btn-block btn-sm btn-primary btn_view_information_bi" id="'+data.direct_to_get_id+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-view-all-info-encoded"><i class="glyphicon glyphicon-align-justify"></i> View ALL information</a>' +


                                '<a class="btn btn-block btn-sm btn-warning  btn_cancel_encoded_return" id="'+btoa(data.id)+'" name="'+data.direct_type+'">Cancel Return Status</a>';
                        }
                        else
                        {
                            return ''+
                                '<a class="btn btn-block btn-sm btn-primary btn_acknowledge_encoded" id="'+btoa(data.id)+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-acknowledge-encoded"><i class="glyphicon glyphicon-ok"></i> Acknowledge</a>' +

                                '<a class="btn btn-block btn-sm btn-primary btn_view_information_bi" id="'+data.direct_to_get_id+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-view-all-info-encoded"><i class="glyphicon glyphicon-align-justify"></i> View ALL information</a>' +

                                '<a class="btn btn-block btn-sm btn-warning btn_return_attach_encoded" id="'+btoa(data.id)+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-return-attach-encoded">Return (Lack of attachment)</a>' +

                                '<a class="btn btn-block btn-sm btn-danger btn_cancel_encoded" id="'+btoa(data.id)+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-cancel-encoded">Cancel</a>';
                        }



                    },
                    'name' : 'bi_direct_pivot.id',
                    searchable : false,
                    orderable : false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#applicant_encoded_table_filter input').unbind();
    $('#applicant_encoded_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                pending_applicants_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    pending_applicants_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#applicant_encoded_table').on('click', '.btn_acknowledge_encoded', function()
{
    var id = $(this).attr('id');
    var name = $(this).attr('name');
    $('#ack_encoded').attr('idtoSend', id).attr('name', name);
});

$('.client_bi_endorsement_class').click(function()
{
    var gethref = $(this).attr('href');

    if (gethref == '#tab_tab_3') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (tabtab3) {
            console.log('already loaded');
        }
        else if (tabtab3 == false) {
            tabtab3 = true;
            getContactNumbers();
        }
    }
});

$('#ack_encoded').click(function()
{
    var id = atob($(this).attr('idtoSend'));
    var type = $(this).attr('name');
    var this_button = $(this);
    var checking = [];
    var ctr = 0;
    var checking_index = 0;


    $('.check_list_checking_pending').each(function()
    {
        if($(this).prop('checked'))
        {
            checking_index++;
        }
    });

    if($('#endorser_name').val() == '' || checking_index == 0)
    {
        alert('Please input/select all required fields');
    }
    else
    {
        $('.check_list_checking_pending').each(function()
        {
            if($(this).prop('checked'))
            {
                checking[ctr] = [];

                checking[ctr][0] = $(this).val();
                checking[ctr][1] = $(this).attr('name');
                ctr++;
            }
        });

        $.ajax
        ({
            type: 'get',
            url: 'bi_endorse_encoded_account',
            data: {
                'id' : id,
                'endorser_name' : $('#endorser_name').val(),
                'accnt_lob' : $('#accnt_lob').val(),
                'accnt_project_name' : $('#accnt_project_name').val(),
                'checking' : checking,
                'package' : $('#type_package_pending').children("option:selected").attr('name'),
                'type' : type
            },
            beforeSend: function()
            {
                this_button.attr('disabled',true);
            },
            success: function(data)
            {
                if(data == 'double')
                {
                    alert('Account already existing in OIMS. Please cancel or recall on Encode Endorsement Tab');
                    $('.selectToClear').val('-');
                    $('.textToClear').val('');
                    pending_applicants_table.draw();
                }
                else if(data == 'login again')
                {
                    alert('Please login again to continue');
                }
                else
                {
                    alert('Account Successfully Endorsed to CCSI');
                    $('#modal-acknowledge-encoded').modal('hide');
                    $('.selectToClear').val('-');
                    $('.textToClear').val('');
                    pending_applicants_table.draw();
                }
                this_button.attr('disabled', false);

            },
            error: function()
            {
                $('#modal_error').modal('show');

                setTimeout(function()
                {
                    $('#modal_error').modal('hide');
                },5000);
                console.log('Error occured please try again');
            },
            complete: function()
            {
                this_button.removeAttr('disabled');
            }
        });
    }





});

$('#bi_client_general_table').on('click', '.client_req_cancel', function()
{
    var id = $(this).attr('id');
    $('#request_cancel_submit').attr('name', btoa(id));
    $('#request_cancel_submit').attr('what', 'req_cancel');
    $('#bi_client_cancel_req_reason').val('');
});


$('#bi_client_general_table').on('click', '.client_revoke_cancel', function()
{
    var id = $(this).attr('id');
    $('#request_cancel_submit').attr('name', btoa(id));
    $('#request_cancel_submit').attr('what', 'rev_cancel');
    $('#bi_client_cancel_req_reason').val('');
});

$('#request_cancel_submit').click(function()
{
    var btn = $(this);
    if(confirm('Are you sure to submit request?'))
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'bi_client_request_cancellation',
            data: {
                'id' : atob($(this).attr('name')),
                'reason' : $('#bi_client_cancel_req_reason').val(),
                'what' : $(this).attr('what')
            },
            success : function(data)
            {
                console.log(data);
                if(data == 'success')
                {
                    $('#modal-bi-cancel-request').modal('hide');
                    alert('Account cancellation request successfully sent');
                    $('#bi_client_cancel_req_reason').val('');
                }
                else if(data == 'already')
                {
                    alert('Account is already requested to cancelled');
                }
                else if(data == 'error')
                {
                    alert('Error occured please refresh the webpage');
                }
            },
            complete: function()
            {
                btn.attr('disabled', false);
                table_general.draw();
            }
        });
    }
});

// $('#testExcelTable').on('click', '.btnClickToAttachBulk', function()
// {
//     var val1 = $(this).attr('name');
//     var val2 = $(this).attr('href');
//
//     $('#spanFileBullk-'+ val1 + '_'+val2+'').fadeIn();
//
//     $(this).hide();
// });

$('#testExcelTable').on('click', '.addFileBulkNow', function()
{
    var val1 = $(this).attr('name');
    var val2 = $(this).attr('href');

    $('#attachtoBulk-'+ val1 + '_'+val2+'').click();


    $('#attachtoBulk-'+ val1 + '_'+val2+'').change(function(e)
    {
        if(e.target.files[0] != null)
        {
            var fileName = e.target.files[0].name;

            $('#attach_stat-'+ val1 + '_'+val2+'').attr('title', ''+fileName+' selected').html('File Selected');
        }
        else
        {
            $('#attach_stat-'+ val1 + '_'+val2+'').html('Choose a file');
        }
    });
});

$('#applyToAllBulk').click(function()
{
    var if_no_check = 0;
    arrayPackageToBulk = [];

    if(applyBulkBool == false)
    {
        arrayPackageToBulk[0] = [];

        $('.check_list_checking_excel').each(function ()
        {
            if($(this).is(":checked"))
            {
                arrayPackageToBulk[0][if_no_check] = $(this).val() + '|--|--|' + $(this).attr('name');
                if_no_check++;
            }
        });

        if(tableExcelBool == false)
        {
            alert('Please upload the bulk endorsement excel');
        }
        else if(tableExcelBool == true)
        {
            if(arrayPackageToBulk == '')
            {
                alert('Please select checking/s for the endorsements');
            }
            else
            {
                $('.bulkButtonPackage').html('<i class = "fa fa-fw fa-check"></i> Package Applied');

                $('.bulkButtonCheck').html('<i class = "fa fa-fw fa-check"></i> Checks Applied');

                $(this).attr('class', 'btn btn-md btn-block btn-success').attr('title', 'Click to un-apply');

                $(this).html('<i class = "fa fa-fw fa-check"></i> APPLIED TO ALL');

                applyBulkBool = true;

                if($('#type_package_excel').find(':selected').val() == '-')
                {
                    arrayPackageToBulk.push('-');
                }
                else
                {
                    arrayPackageToBulk.push($('#type_package_excel').find(':selected').val() + '|--|--|' + $('#type_package_excel').find(':selected').attr('name'));
                }

                for(var t = 0;t < arrayBulkPackagesCheckLoop.length; t++)
                {
                    arrayBulkPackagesCheckLoop[t] = arrayPackageToBulk;
                }

                console.log(arrayBulkPackagesCheckLoop)
            }
        }
    }
    else if(applyBulkBool == true)
    {
        $(this).attr('class', 'btn btn-md btn-block btn-primary').attr('title', '');

        $(this).html('<i class = "fa fa-fw fa-location-arrow"></i> APPLY TO ALL ENDORSEMENTS');

        $('.bulkButtonPackage').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Package');

        $('.bulkButtonCheck').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Checks');

        arrayPackageToBulk = [];

        for(var i = 0; i < arrayBulkPackagesCheckLoop.length; i++)
        {
            arrayBulkPackagesCheckLoop[i] = [];
        }

        applyBulkBool = false;
    }
});


$('#testExcelTable').on('click', '.bulkButtonPackage', function()
{
    var index = parseInt($(this).attr('name'));

    $('.packageBulkIndiv').val('-');

    $('#applyChangesPackages').attr('name', index);

    if(arrayBulkPackagesCheckLoop[index] != '')
    {
        if(arrayBulkPackagesCheckLoop[index][1] == '-')
        {
            $('.packageBulkIndiv').val('-');
        }
        else
        {
            var splitPackage = arrayBulkPackagesCheckLoop[index][1].split('|--|--|');

            $('.packageBulkIndiv').val(splitPackage[0]);
        }
    }
    else
    {

    }

    $('#modal-package-excel').modal('show');
});

$('#testExcelTable').on('click', '.bulkButtonCheck', function()
{
    var index = parseInt($(this).attr('name'));

    $('#applyChangesCheckings').attr('name', index);

    $('.check_list_checking_loop_bulk').prop('checked', false);
    $('.check_list_checking_loop_bulk').attr('disabled', false);

    if(arrayBulkPackagesCheckLoop[index] != '')
    {
        for(var l = 0; l < arrayBulkPackagesCheckLoop[index][0].length; l++)
        {
            $('.check_list_checking_loop_bulk').each(function()
            {
                if($(this).val() ==  arrayBulkPackagesCheckLoop[index][0][l].split('|--|--|')[0])
                {
                    $(this).prop('checked', true);

                    if(arrayBulkPackagesCheckLoop[index][0][l].split('|--|--|')[1] == 'package')
                    {
                        $(this).attr('disabled', true);
                        $(this).attr('name', 'package')
                    }
                    else if(arrayBulkPackagesCheckLoop[index][0][l].split('|--|--|')[1] == 'alacarte')
                    {
                        $(this).attr('name', 'alacarte')
                    }

                }
            });
        }
    }
    else
    {

    }



    $('#modal-checkings-excel').modal('show');
});

$('#applyChangesPackages').click(function()
{
    var toGet =  $('.packageBulkIndiv').find(':selected').val();
    var index = parseInt($(this).attr('name'));

    if(toGet == '-')
    {
        alert('Please select a package.')
    }
    else
    {
        if(arrayBulkPackagesCheckLoop[index] != '')
        {
            var pac = arrayBulkPackagesCheckLoop[index][1];

            var check = pac.split('|--|--|');

            if(toGet == check[0])
            {
                alert('Please select different package to continue');
            }
            else
            {

                func_packageBulk(toGet, index);
            }
        }
        else
        {
            func_packageBulk(toGet, index);
        }

    }
});

function func_packageBulk(id, loopindex)
{
    $.ajax
    ({
        url : 'bi_get_change_package_check',
        type : 'get',
        data :
            {
            'package_id' : id
        },
        success : function(data)
        {
            var getChecks = [];

            for(var i = 0; i < data.length; i++)
            {
                getChecks.push(data[i].checking + '|--|--|package');
            }

            arrayBulkPackagesCheckLoop[loopindex] = [];
            arrayBulkPackagesCheckLoop[loopindex].push(getChecks);
            arrayBulkPackagesCheckLoop[loopindex].push(data[0].package_id+ '|--|--|' +data[0].package);

            $('#packageBulk-'+loopindex+'').html('<i class = "fa fa-fw fa-check"></i> Package Applied');
            $('#checkingBulk-'+loopindex+'').html('<i class = "fa fa-fw fa-check"></i> Checks Applied');


            $('#modal-package-excel').modal('hide');
        },
        error : function ()
        {
            console.log('error');
        }
    });
}

$('#applyChangesCheckings').click(function()
{
    var index = $(this).attr('name') ;

    var if_no_check = 0;

    var checkIfChecked = false;

    var getPack = arrayBulkPackagesCheckLoop[index][1];
    //
    arrayBulkPackagesCheckLoop[index] = [];

    arrayBulkPackagesCheckLoop[index][0] = [];

    $('.check_list_checking_loop_bulk').each(function()
    {
        if($(this).is(":checked"))
        {
            checkIfChecked = true;
        }
    });

    if(checkIfChecked == true)
    {
        $('.check_list_checking_loop_bulk').each(function()
        {
            if($(this).is(":checked"))
            {
                arrayBulkPackagesCheckLoop[index][0][if_no_check] = $(this).val() + '|--|--|' + $(this).attr('name');
                if_no_check++;

                checkIfChecked = true;
            }
        });

        if(getPack == null)
        {
            arrayBulkPackagesCheckLoop[index][1] = '-';
        }
        else
        {
            arrayBulkPackagesCheckLoop[index][1] = getPack;
        }

        $('#checkingBulk-'+index+'').html('<i class = "fa fa-fw fa-check"></i> Checks Applied');

        console.log(arrayBulkPackagesCheckLoop)

        $('#modal-checkings-excel').modal('hide');
    }
    else
    {
        alert('Please select atleast one check');
    }
});

$('#BtnClearBulk').click(function()
{
    $('#testExcelTable').html('');
    $('#showHideExcelTable').hide();

    $('#bulk_endorsement_excel').val('');

    $('#applyToAllBulk').attr('class', 'btn btn-md btn-block btn-primary').attr('title', '');

    $('#applyToAllBulk').html('<i class = "fa fa-fw fa-location-arrow"></i> APPLY TO ALL ENDORSEMENTS');

    $('.bulkButtonPackage').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Package');

    $('.bulkButtonCheck').html('<i class = "fa fa-fw fa-paper-plane-o"></i> Select Checks');

    arrayPackageToBulk = [];
    arrayBulkPackagesCheckLoop = [];

    applyBulkBool = false;
    $('#alert_show').hide();
    $('#alert_text').html('');

    $('#BtnBulkEndorseSubmitExcel').hide();
    $(this).hide();


    if(boolCollapsePackCheck == true)
    {
        $('#closeOpenPackCheck').click();
    }
    else
    {

    }

});

$('#closeOpenPackCheck').click(function()
{
    if(boolCollapsePackCheck == false)
    {
        boolCollapsePackCheck = true;
    }
    else
    {
        boolCollapsePackCheck = false;
    }
});

$('#BtnDlBulkTemp').click(function()
{
    window.open('bi-client-dl-bulk','_blank');
});

$(document).on('click', '.removeToBulkEndo', function()
{
    var id = $(this).attr('id');
    var itemRemove = arrayBulkPackagesCheckLoop[id];
    var indexRemove = arrayBulkPackagesCheckLoop.indexOf(itemRemove);
    var trToRemove = '#BulkremoveCtr-'+id+'';
    if(confirm('Are you sure to remove this endorsement?'))
    {
        $(trToRemove).remove();
    }

    if(indexRemove > -1)
    {
        arrayBulkPackagesCheckLoop.splice(indexRemove, 1);
    }
    bulkExcelRed();
});


$('#applicant_encoded_table').on('click', '.btnShowAdditionalfilesDirect', function()
{
    var id = $(this).attr('name');

    $('#tableAddFileBody').html('');

    $.ajax
    ({
        type : 'get',
        url : 'bi_client_get_additional_files_direct',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data)
            for(var i = 0; i < data.length; i++)
            {
                var getFileName = data[i].file.split('/');
                var last = getFileName[getFileName.length-1];

                $('#tableAddFileBody').append
                (
                    '<tr>' +
                    '<td>'+last+'</td>' +
                    '<td><a class="btn btn-xs btn-block btn-info" href="/getAddFilesDl/'+id+'/'+btoa(last)+'" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> View</a></a></td>' +
                    '</tr>'
                )
            }

            $('#modal_view_additional_direct').modal('show');
        },
        error : function()
        {
            alert('Oops. Something went wrong');
        }
    })
});

//floyd
$('#applicant_encoded_table').on('click', '.btn_return_attach_encoded', function()
{
    var id = $(this).attr('id');
    $('#return_btn_email_to_applicant').attr('name', id);

    // $('#modal-return-attach-encoded').modal('show')
});

$('#return_btn_email_to_applicant').click(function()
{
   var id = $(this).attr('name');
   var message = $('#return_txtarea_application').val();

   $.ajax
   ({
      type : 'get',
      url : 'bi_client_send_return_email_application',
      data :
          {
              'id' : id,
              'message' : message
          },
       beforeSend : function()
       {
           $('#modal-return-attach-encoded').modal('hide');
           $('#modal-send-email-loading-applicant').modal({backdrop : 'static'});
       },
       success : function()
       {

       },
       complete : function()
       {
           $('#modal-send-email-loading-applicant').modal('hide');
           
           pending_applicants_table.ajax.reload(null, false);

           setTimeout(function()
           {
               $('#modal-send-email-success-applicant').modal('show');
           }, 1000);

           $('#return_txtarea_application').val('');
       },
       error : function()
       {
           $('#modal-send-email-loading-applicant').modal('hide');
           alert('Something went wrong');

       }
   });


});

//RANYLL

$('#applicant_encoded_table').on('click', '.btn_cancel_encoded', function()
{
    var encoded_id = atob($(this).attr('id'));
    $('#btn_encoded_cancel').attr('href', encoded_id);
});

$('#applicant_encoded_table').on('click', '.btn_cancel_encoded_return', function()
{
    var encoded_id = atob($(this).attr('id'));

    if(confirm('Are you sure to cancel the return status?'))
    {
        $.ajax({
            type: 'get',
            url: 'bi_cancel_direct_encode_data',
            data: {
                'pivot_id' : encoded_id
            },
            success: function(data)
            {
                pending_applicants_table.draw();
                alert('Account status change to Pending for Acknowledge');
            },
            error: function(e)
            {
                console.log(e);
                alert('Error occurred Please contact website administrator for assistance. Thank you.');
            }
        });
    }
});

$('#btn_encoded_cancel').click(function()
{
    var encoded_id = $(this).attr('href');
    var stat;

    if(confirm('Are you sure want to cancel this application?'))
    {
        $.ajax({
            type: 'get',
            url: 'bi_cancel_direct_encode_data',
            data: {
                'pivot_id' : encoded_id,
                'remarks' : $('#cancel_txtarea_application').val()
            },
            beforeSend : function()
            {
                $('#modal-cancel-encoded').modal('hide');
                $('#modal-send-email-loading-applicant').modal({backdrop : 'static'});
            },
            success: function(data)
            {
                stat = data;
                $('#cancel_txtarea_application').val('');
            },
            complete : function()
            {
                if(stat == 'ok')
                {
                    $('#modal-send-email-loading-applicant').modal('hide');


                    pending_applicants_table.draw();

                    if(tabtabtab2)
                    {
                        cancelled_applicants_table.draw()
                    }

                    setTimeout(function()
                    {
                        $('#modal-send-email-success-applicant').modal('show');
                    }, 1000);
                }
            },
            error: function(e)
            {
                console.log(e);
                alert('Error occurred Please contact website administrator for assistance. Thank you.');
            }
        });
    }
    else
    {
        console.log('do nothing');
    }
});

function getCancelledApplications()
{
    $('#cancelled_applicant_encoded_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    cancelled_applicants_table = $('#cancelled_applicant_encoded_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'bi_client_get_cancelled_applicants',
        "columns":
            [
                {data: 'id', name: 'bi_direct_pivot.id'},
                {data: 'created_at', name: 'bi_direct_pivot.created_at'},
                {
                    data: function site_location(data)
                    {
                        return '' +data.bi_account_name +' '+ data.account_location;
                    },
                    name: 'bi_direct_pivot.created_at',
                    searchable : false,
                    orderable : false
                },
                {data: 'direct_name', name: 'bi_direct_pivot.direct_name'},
                {data: 'attachments', name: 'bi_direct_pivot.direct_name'},
                {
                    data: function(data)
                    {
                        if(data.direct_status == 0)
                        {
                            return '<a class="btn bg-red-active color-palette" disabled>CANCELLED</a>';
                        }
                    }
                    ,name : 'bi_direct_encoded_data.id',
                    searchable : false,
                    orderable : false
                },
                {
                    data:function action(data)
                    {
                        return ''+
                            '<a class="btn btn-block btn-sm btn-primary btn_view_information_bi" id="'+data.direct_to_get_id+'" name="'+data.direct_type+'" data-toggle="modal" data-target="#modal-view-all-info-encoded"><i class="glyphicon glyphicon-align-justify"></i> View ALL information</a>' +
                            '<a class="btn btn-block btn-sm btn-warning btn_uncancel_encoded" id="'+btoa(data.id)+'" name="'+data.direct_type+'">Uncancel</a>';

                    },
                    'name' : 'bi_direct_pivot.id',
                    searchable : false,
                    orderable : false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#cancelled_applicant_encoded_table_filter input').unbind();
    $('#cancelled_applicant_encoded_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                cancelled_applicants_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    cancelled_applicants_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#cancelled_applicant_encoded_table').on('click', '.btn_uncancel_encoded', function()
{
    var encoded_id = atob($(this).attr('id'));
    if(confirm('Are you sure want to uncancel this application?'))
    {
        $.ajax({
            type: 'get',
            url: 'bi_uncancel_direct_encode_data',
            data: {
                'pivot_id' : encoded_id
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    cancelled_applicants_table.draw();
                    pending_applicants_table.draw();
                }
            },
            error: function(e)
            {
                console.log(e);
                alert('Error occurred Please contact website administrator for assistance. Thank you.');
            }
        });
    }
    else
    {
        console.log('do nothing');
    }
});


$('.direct_a_class').click(function()
{
    var gethref = $(this).attr('href');

    if (gethref == '#tab_2_enc') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (tabtabtab2) {
            console.log('already loaded');
        }
        else if (tabtabtab2 == false) {
            tabtabtab2 = true;
            getCancelledApplications();
        }
    }
});

$('.client_date_range_click').click(function()
{
    if($(this).val() != 'all')
    {
        $('#fin_client_date_pick_holder').show();
    }
    else
    {
        $('#fin_client_date_pick_holder').hide();
    }

    table_finished.draw();
});

$('.fin_client_date_range_dates').change(function()
{
    table_finished.draw();
});

$('.client_date_range_click-gen').click(function()
{
    if($(this).val() != 'all')
    {
        $('#gen_client_date_pick_holder').show();
    }
    else
    {
        $('#gen_client_date_pick_holder').hide();
    }

    table_general.draw();
});

$('.gen_client_date_range_dates').change(function()
{
    table_general.draw();
});