var table_acknowledge_tele;
var title_acknowledge = [];
var title_acknowledge_counts = 0;

var table_finished_table;
var title_finished = [];
var title_finished_counts = 0;

var table_general_search;
var title_general_search = [];
var title_general_search_counts = 0;

var activeSide = 'cc_tele_accounts';
var tele_side_dash = false;
var tele_side_acct = true;
var tele_side_search = false;

var accID;
var endorseID;

var activeTab = 'cc_tele_assigned';
var cc_tele_assigned = true;
var cc_tele_finished = false;

var addCharReference, addEmployment;
var charRefArray = [];
charRefArray.push(0);
var addEmploymentArray = [];
addEmploymentArray.push(0);

var cMc = 0;
var cSoiEVR = 0;
var cSoiBVR = 0;
var cRecent = 0;
var cobSoiEVR = 0;
var cobSoiBVR = 0;

var arrayCom  = [];
var bSoiComEVR = [];
var bSoiComBVR = [];
var recentAddArr = [];

var cobArrayContents = [];

var table_logs_cc_bank_encoded = [];
var countCCencode = 0;
var table_cc_bank_encoded_list;
var bankInc = 0;
var arrayAddressToCopy = [];

var addressBool = [];

var browserType;
var existingInc = 0;

var checkifYesBorPresent = false;
var contentBorPresent = [];

var addressBoolPresent = [];

var presentAddressesCOB = [];

var comDependensArray = [];

var currentAcctName;

var comShowHideArr = [];

var randomIDsCob = [];

$('.save_dataa').each(function()
{
    $('input').val('')

    $("select").val('-');

    $('textarea').val('');
});

var dependentCount = 0;
var checkboxTriggerBool = false;

var encoding_autosave_bool = false;
var autoSave_id = '';
var sessionName = '';

getDash();
function getDash()
{
    $.ajax
    ({
        type : 'get',
        url : 'cc-tele-get-dash',
        success : function(data)
        {
            console.log(data);
            $('#gen_endorse_count').html(data[0]);
            $('#pending_account_count').html(data[1]);
            $('#finished_count').html(data[2]);
            $('#hold_cancelled_count').html(0);
            $('#returned_account_count').html(data[3]);
            $('#doneByName').val(data[4]);
            $('#doneByCompany').val('CCSI');
        }
    });
}

detectBrowser();
function detectBrowser()
{
    $.ajax
    ({
        type : 'get',
        url : 'cc-tele-get-browser-info',
        success : function(data)
        {
            browserType = data;
        }
    });
}

$.ajax
({
    type: 'get',
    url: 'cc-tele-get-client-type',
    success: function (data)
    {
        if (data == 'cc_bank')
        {
            clientTypeAuth = 'bank';
        }
        else
        {
            clientTypeAuth = 'cc';
        }

        console.log(clientTypeAuth);

        $('.cc_tele_accounts_tab').click(function()
        {
            var gethref = $(this).attr('href');
            // console.log(gethref);

            if(gethref == '#cc_tele_assigned') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do_nothing');
                    activeTab = 'cc_tele_assigned';
                }
                else if (cc_tele_assigned) {
                    console.log('already loaded');
                    activeTab = 'cc_tele_assigned';
                }
                else if (cc_tele_assigned == false) {
                    cc_tele_assigned = true;
                    activeTab = 'cc_tele_assigned';
                    getAckTable();
                }
            }
            else if(gethref == '#cc_tele_finished') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do_nothing');
                    activeTab = 'cc_tele_finished';
                }
                else if (cc_tele_finished) {
                    console.log('already loaded');
                    activeTab = 'cc_tele_finished';
                }
                else if (cc_tele_finished == false) {
                    cc_tele_finished = true;
                    activeTab = 'cc_tele_finished';
                    getFinishedTable();
                }
            }
        });

        getAckTable();

        $('.cc_tele_side_class').click(function ()
        {
            var gethref = $(this).attr('href');
            // console.log(gethref);

            if(gethref == '#cc_tele_accounts')
            {
                if($(''+gethref+'').hasClass('active'))
                {
                    console.log('do_nothing');
                    activeSide = 'tele_side_acct';
                }
                else if(tele_side_acct)
                {
                    console.log('already loaded');
                    activeSide = 'tele_side_acct';
                }
                else if(tele_side_acct == false)
                {
                    tele_side_acct = true;
                    activeSide = 'tele_side_acct';
                    getAckTable();
                }
            }
            else if(gethref == '#cc_tele_dash')
            {
                if($(''+gethref+'').hasClass('active'))
                {
                    console.log('do_nothing');
                    activeSide = 'tele_side_dash';
                }
                else if(tele_side_search)
                {
                    console.log('already_loaded');
                    activeSide = 'tele_side_dash';
                }
                else if(tele_side_search == false)
                {
                    tele_side_dash = true;
                    activeSide = 'tele_side_dash';
                }
            }
            else if(gethref == '#cc_tele_general_search')
            {
                if($(''+gethref+'').hasClass('active'))
                {
                    console.log('do_nothing');
                    activeSide = 'tele_side_search';
                }
                else if(tele_side_search)
                {
                    console.log('already_loaded');
                    activeSide = 'tele_side_search';
                }
                else if(tele_side_search == false)
                {
                    tele_side_search = true;
                    activeSide = 'cc_tele_search';
                    getGeneralsearch();
                }
            }
            else if(gethref == '#comp_cont_num_table')
            {
                if($(''+gethref+'').hasClass('active'))
                {
                    console.log('do_nothing');
                    activeSide = 'comp_cont_num_table';
                }
                else if(tele_side_search)
                {
                    console.log('already_loaded');
                    activeSide = 'comp_cont_num_table';
                }
                else if(tele_side_search == false)
                {
                    tele_contact_numbers = true;
                    activeSide = 'comp_cont_num_table';
                    getContactNumbers();
                }
            }
        });

        $('#cc_tele_accounts_table').on('click', '.btn_upload_files_report', function()
        {
            accID = $(this).attr('id');
            $('#tele-acc-stat').val('-');
            $('#tele-acc-stat').change();
            $('#contactedSelect').hide();
            $('#uncontactedSelect').hide();
            console.log(accID);

            $('#modal-upload-attach-file').modal('show');
        });

        if(clientTypeAuth == 'bank')
        {
            $('.ccOps').remove();
        }
        else if(clientTypeAuth == 'cc')
        {
            $('.bankOps').remove();
        }


        $('#cc_tele_accounts_table').on('click', '.btn_encode', function()
        {
            sessionName = $('#nameHolderMainPage').attr('name') + '_' + $(this).attr('id');
            if(clientTypeAuth == 'cc')
            {
                $('.checkboxChecker ').prop('checked', true);
                addEmployment = 0;
                addCharReference = 0;
                charRefArray = [];
                charRefArray.push(0);
                addEmploymentArray = [];
                addEmploymentArray.push(0);
                $('#reports_logs_cc tr td').remove();
                $('#tableCheck1 tr td').children('input').val('');
                $('#tableCheck1 tr td').children('textarea').val('');
                $('.academicTable tr td').children('input').val('');
                $('.empHis_0 tr td').children('input').val('');
                $('.residentialTable tr td').children('input').val('');
                $('.residentialTable tr td').children('textarea').val('');
                $('.bi_reportTable tr td').children('input').val('');
                $('.id_crim_table tr td').children('input').val('');
                $('.cmapTable tr td').children('input').val('');
                $('.cmapTable tr td').children('select').val('-');
                $('.charRefTable_0 tr td').children('input').val('');
                $('.hiddenThing').hide();
                $('.toShowThis').hide();
                $('#emplohistSpan').html('');
                $('#forspantablee').html('');
                $('.check-label-class').prop('checked', false);
                endorseID = $(this).attr('id');

                $('#modal-view-encode-data').modal({backdrop: 'static', keyboard: true});
                // $('.hiddenThing').show();
                var paliit1 = $('#check1-label').text();
                var check1 = paliit1.toLowerCase();

                var paliit2 = $('#check2-label').text();
                var check2 = paliit2.toLowerCase();

                var paliit3 = $('#check3-label').text();
                var check3 = paliit3.toLowerCase();

                var paliit4 = $('#check4-label').text();
                var check4 = paliit4.toLowerCase();

                var paliit5 = $('#check5-label').text();
                var check5 = paliit5.toLowerCase();

                var paliit6 = $('#check6-label').text();
                var check6 = paliit6.toLowerCase();

                var paliit7 = $('#check7-label').text();
                var check7 = paliit7.toLowerCase();

                var paliit8 = $('#check8-label').text();
                var check8 = paliit8.toLowerCase();

                $.ajax
                ({
                    type: 'get',
                    url: 'cc_tele_get_account_checking',
                    data:
                        {
                            'id' : endorseID
                        },
                    success: function (data)
                    {
                        console.log(data);
                        var i = 0;
                        var paliitin;
                        var accnt_checking_name;
                        $('#acc_dob').val(data[1]);
                        $('#bi_account_report').val(data[0][0].endorsed_name);
                        $('#acc_address').val(data[2]);
                        for(i = 0; i < data[0].length; i++)
                        {
                            paliitin = data[0][i].checking_name;
                            accnt_checking_name = paliitin.toLowerCase();

                            // console.log(accnt_checking_name);
                            if(accnt_checking_name == check1)
                            {
                                $('#checkrow1').show();
                                $('#tableCheck1').show();
                                $('#check1').prop('checked', true);
                            }
                            else if(accnt_checking_name == check2)
                            {
                                $('#checkrow2').show();
                                $('#tableCheck2').show();
                                $('#check2').prop('checked', true);
                            }
                            // else if(accnt_checking_name == check3)
                            // {
                            //     $('#checkrow3').show();
                            //     $('#tableCheck3').show();
                            //     $('#check3').prop('checked', true);
                            // }
                            else if(accnt_checking_name == check4)
                            {
                                $('#checkrow4').show();
                                $('#tableCheck4').show();
                                $('#check4').prop('checked', true);
                            }
                            else if(accnt_checking_name == check5)
                            {
                                $('#checkrow5').show();
                                $('#tableCheck5').show();
                                $('#check5').prop('checked', true);
                            }
                            else if(accnt_checking_name == check6)
                            {
                                $('#checkrow6').show();
                                $('#tableCheck6').show();
                                $('#check6').prop('checked', true);
                            }
                            else if(accnt_checking_name == check7)
                            {
                                $('#checkrow7').show();
                                $('#tableCheck7').show();
                                $('#check7').prop('checked', true);
                            }
                            else if(accnt_checking_name == check8)
                            {
                                $('#checkrow8').show();
                                $('#tableCheck8').show();
                                $('#check8').prop('checked', true);
                            }

                            if(accnt_checking_name == 'Employment Check (for all listed employer in the last 10 year' || accnt_checking_name == 'Employment Check (for all listed employer in the last 7 years)')
                            {
                                $('#checkrow3').show();
                                $('#tableCheck3').show();
                                $('#check3').prop('checked', true);
                            }
                        }

                        if(data[3] == '')
                        {
                            $('#reports_logs_cc').append('<tr><td>No records found</td></tr>');
                            $('#splitterTest').css('overflow-y', '');
                        }
                        else
                        {
                            var huy;
                            for(huy = 0; huy < data[3].length; huy++)
                            {
                                $('#reports_logs_cc').append('<tr>' +
                                    '<td><a style="text-decoration: underline; color: black; cursor: pointer" class="getLogsData" id="'+data[3][huy].report_log_id+'">'+data[3][huy].report_log_id+'</a>/'+data[3][huy].created_at+'</td>' +
                                    '</tr>');
                            }

                            if(data[3].length > 5)
                            {
                                $('#splitterTest').css('overflow-y', 'scroll');
                            }
                            else
                            {
                                $('#splitterTest').css('overflow-y', '');
                            }
                        }
                    }
                });
            }
            else if(clientTypeAuth == 'bank')
            {
                $('#modal-view-bank-encoding').modal('show');
                $('#sendCCbankTele').attr('name', btoa($(this).attr('id')));
                // clearCCbankFields();
                $('.showHideBorOFWSea').hide();
                $('.showHideBorBarang').hide();

                if(!checkboxTriggerBool)
                {
                    $('.add-check-test tr').each(function()
                    {
                        if($(this).attr('class') != 'thisRem')
                        {
                            var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';
                            // console.log($(this).children('td:first-child').children());
                            $(this).children('td:first-child').prepend(appendTest);
                        }
                    });

                    checkboxTriggerBool = true;
                }


                checkPrintNot();
                encodedSaveLogs();

                setTimeout(function()
                {
                    if(sessionStorage.getItem(sessionName) != '')
                    {
                        var gatheredData = JSON.parse(sessionStorage.getItem(sessionName));

                        if(gatheredData != null)
                        {
                            if(Object.keys(gatheredData).length > 0)
                            {
                                var countHold = '';
                                if(confirm('Do you want to load the last auto-saved encoded data?'))
                                {
                                    $.each(gatheredData, function(key, value)
                                    {
                                        countHold = value;
                                        $.each(countHold, function(last_key, last_val)
                                        {
                                            $('#'+last_key+'').val(last_val);
                                        });
                                    });
                                    sessionStorage.setItem(sessionName, '');
                                }
                            }
                            else
                            {
                                console.log('no save');
                            }
                        }
                        else
                        {
                            console.log('no save');
                        }
                    }
                }, 1000);
                currentAcctName = $(this).attr('name');
            }
        });

        $(document).keydown(function(e)
        {
            if(e.keyCode == 80 && e.ctrlKey)
            {
                if(clientTypeAuth == 'bank')
                {
                    e.preventDefault();
                    PrintPreview();
                    // alert('no shit!')
                }
                else
                {

                }
            }
        });
    }
});
function checkPrintNot()
{
    $('.select-hide-rows').unbind();
    $('.select-hide-rows').click(function()
    {
        var $this = $(this);

        if($(this).closest('td')[0].attributes[1].value == 'background-color: black; color : white;')
        {
            if($(this).closest('table').closest('tr').hasClass('removeThisButtons'))
            {
                $(this).closest('table').closest('tr').removeClass('removeThisButtons');

                var addCheckiiiii = $(this).closest('table').children('tbody');

                addCheckiiiii.children('tr').each(function()
                {
                    $(this).children('td').children('input').prop('checked', true);
                });

                $this.attr('title', 'Uncheck to hide upon printing');
            }
            else
            {
                $(this).closest('table').closest('tr').addClass('removeThisButtons');
                var testasdasd = $(this).closest('table').children('tbody');

                testasdasd.children('tr').each(function()
                {
                    $(this).children('td').children('input').removeAttr('checked')
                });
                $this.attr('title', 'Check to show upon printing');
            }
        }
        else
        {
            if($(this).closest('tr').hasClass('removeThisButtons'))
            {
                $(this).closest('tr').removeClass('removeThisButtons');
                $this.attr('title', 'Uncheck to hide upon printing');
            }
            else
            {
                $(this).closest('tr').addClass('removeThisButtons');
                $this.attr('title', 'Check to show upon printing');
            }
        }
    });

}

function getAckTable()
{
    $('#cc_tele_accounts_table thead th').each(function()
    {
        title_acknowledge[title_acknowledge_counts] = $(this).text();
        title_acknowledge_counts++;
        var title = $(this).text();
        if(title != 'ACTION')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
    });

    table_acknowledge_tele = $('#cc_tele_accounts_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc-tele-encoder-table-acknowledged',
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
                                        return title_acknowledge[(idx)];
                                    },
                                    body: function (data,row,column) {
                                        // Strip $ from salary column to make it numeric
                                        if(column <= 7)
                                        {
                                            return data.replace( /<br\s*\/?>/ig, "\r\n");
                                        }
                                        else
                                        {
                                            // return data;
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
                        return title_acknowledge[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'due', 'searchable' : false, 'orderable' : false},
                {
                    data : function action(data)
                    {
                        var dl;

                        if(data.status == 23)
                        {
                            if(data.file_path != '')
                            {
                                dl ='<a  id="'+data.endorse_id+'" class="btn_encode_v2 btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-pencil"></i> Encode</a>' +
                                    '<a class="btn_upload_files_report btn btn-xs btn-primary btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="fa fa-fw fa-upload"></i> Update Attachment</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btnDlSaoRep btn btn-xs btn-danger btn-block" data-toggle="modal" name="'+data.file_path+'"><i class="fa fa-fw fa-download"></i> Download SAO/AO Report</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_reasonDelay btn btn-xs btn-danger btn-block" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-eye-open"></i> View Remarks/Reason</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downRep"></span>';
                            }
                            else if(data.file_path == '')
                            {
                                dl ='<a  id="'+data.endorse_id+'" class="btn_encode_v2 btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-pencil"></i> Encode</a>' +
                                    '<a class="btn_upload_files_report btn btn-xs btn-primary btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="fa fa-fw fa-upload"></i> Update Attachment</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_reasonDelay btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Remarks/Reason</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downRep"></span>';
                            }
                        }
                        else
                        {
                            if(data.file_path != '')
                            {
                                dl ='<a  id="'+data.endorse_id+'" class="btn_encode btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-pencil"></i> Encode</a>' +
                                    '<a class="btn_upload_files_report btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="fa fa-fw fa-upload"></i>Upload Attachment</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btnDlSaoRep btn btn-xs btn-danger btn-block" data-toggle="modal" name="'+data.file_path+'"><i class="fa fa-fw fa-download"></i> Download SAO/AO Report</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_reasonDelay btn btn-xs btn-danger btn-block" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-eye-open"></i> View Remarks/Reason</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downRep"></span>';
                            }
                            else
                            {
                                dl ='<a  id="'+data.endorse_id+'" name = "'+data.account_name+'" class="btn_encode btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-pencil "></i> Encode</a>' +
                                    '<a class="btn_upload_files_report btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="fa fa-fw fa-upload"></i>Upload Attachment</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_reasonDelay btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Remarks/Reason</a>' +
                                    '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                    '<span id = "downRep"></span>';
                            }
                        }


                        return dl;
                    },
                    'name' : 'bi_endorsements.status',
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

    $('#cc_tele_accounts_table_filter input').unbind();
    $('#cc_tele_accounts_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_acknowledge_tele.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_acknowledge_tele.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_acknowledge_tele.column(2).visible(true);
        table_acknowledge_tele.column(1).visible(false);
        table_acknowledge_tele.column(6).visible(false);
        table_acknowledge_tele.column(7).visible(false);

    }
    else if(clientTypeAuth == 'cc')
    {
        table_acknowledge_tele.column(2).visible(false);
        table_acknowledge_tele.column(1).visible(true);
        table_acknowledge_tele.column(6).visible(true);
        table_acknowledge_tele.column(7).visible(true);

    }

}

// $('#btnSendtoSao').click(function()
// {
//     $.ajax({
//         type: 'post',
//         url: 'cc-tele-send-rep-sao',
//         success : function(data)
//         {
//             console.log(data);
//         }
//     })
// });

$('#btnSendtoSao').click(function()
{
    var btn = $(this);

    var id_endode = btoa(accID);
    var toSendSaoFile = $('#tele-upload-attach').prop('files')[0];
    var veriStat = $('#tele-acc-stat').find(':selected').val();
    var remarks = $('#tele-acc-remarks-upload').val();
    var contacted_details = $('#contacted-details').val();
    var un_contacted_details = $('#un-contacted-details').val();
    var check_tick = '';

    var formData = new FormData();

    formData.append('file', toSendSaoFile);
    formData.append('stat', veriStat);
    formData.append('id', id_endode);
    formData.append('remarks', remarks);

    if(veriStat == 'Contacted')
    {
        formData.append('contacted_details', contacted_details);
        
        check_tick = contacted_details;
    }
    else if(veriStat == 'Uncontacted')
    {
        formData.append('contacted_details', un_contacted_details);
        check_tick = un_contacted_details;
    }
    else
    {
        formData.append('contacted_details', veriStat);
        check_tick = veriStat;
    }


    if(veriStat != '-' &&  check_tick != '-')
    {
        btn.attr("disabled", true);
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
                        $('#ulPercentage_tele').html('');
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_tele').append(Math.floor(percentComplete*100));
                        $('#progressbar_tele').show();
                        $('#ulPercentage_tele').show();
                        $('#progressbar_tele').progressbar
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
            type : 'post',
            url : 'cc-tele-send-rep-sao',
            contentType: false,
            processData: false,
            async : true,
            data: formData,
            success: function(data)
            {
                console.log(data);
                if(data == 'ok')
                {
                    $.ajax({
                        type: 'post',
                        url : 'cc_tele_encoder_copy_for_level_2',
                        contentType: false,
                        processData: false,
                        async : true,
                        data: formData,
                        success: function(data)
                        {
                            if(data == 'up')
                            {
                                alert('Successfully Sent Report!');
                            }
                            else
                            {
                                alert('Successfully Sent Report to SAO!');
                            }
                            $('#modal-upload-attach-file').modal('hide');
                            $('#tele-upload-attach').val('');
                            $('#tele-acc-stat').val('');
                            $('#tele-acc-remarks-upload').val('');
                        }
                    });
                }
                else if(data == 'need')
                {
                    alert('Attach report files.');
                }
                else
                {
                    alert('Account already sent to A.O see logs');
                }
                btn.attr("disabled", false);
            },
            complete: function()
            {
                $('#progressbar_tele').hide();
                $('#ulPercentage_tele').hide();
                table_acknowledge_tele.ajax.reload(null, false);
            }
        });
    }
    else
    {
        alert('Please select Verification Status!');
        btn.attr("disabled", false);
    }

});

$('#cc_tele_accounts_table').on('click', '.btnDlSaoRep', function()
{
    accID = $(this).attr('id');
    var dl = btoa($(this).attr('name'));

    console.log(accID);
    var id_encode = btoa(accID);
    var q = '<form action="/cc-tele-dl-sao-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<input type="text" hidden value="'+dl+'" name="dl">'+
        '<button type="submit" hidden id="button_tele_rep_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#downRep').html(q);
    $('#button_tele_rep_download').click();
    $('#downRep').hide();
});


function getGeneralsearch()
{
    var now = new Date();
    var dd = now.getDate();
    var mm = now.getMonth()+1; //January is 0!
    var yyyy = now.getFullYear();
    var today = yyyy + '-' + mm + '-' + dd;
    var minutes = now.getMinutes();
    var hours = now.getHours();
    var seconds = now.getSeconds();
    var timenow = hours+':'+minutes+':'+seconds;
    var test = today + ' ' + timenow;

    $('#cc_tele_generaltbl thead th').each(function ()
    {
        title_general_search[title_general_search_counts] = $(this).text();
        title_general_search_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_general_search = $('#cc_tele_generaltbl').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'cc_tele_generaltbl_search',

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
                                        return title_general_search[(idx)];
                                    },
                                    body: function (data, row, column)
                                    {
                                        if(column <= 7)
                                        {
                                            return data.replace(/<br\s*\/?>/ig, "\r\n")
                                        }
                                        else
                                        {

                                        }
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
                        return title_general_search[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        var countDownDate = new Date(data.date_time_due1);
                        var now = new Date();
                        var distance = countDownDate - now;


                        if(data.status == 0)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                        }
                        else if (data.status == 20)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                        }
                        else if(data.status == 22)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                        }
                        else if(data.status == 23)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }
                        else if(data.status == 24)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }
                        else if(data.status == 25)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                        }
                        else if (data.status == 21)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Returned Enodrsement</a>';
                        }
                        else if (data.status == 5)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> On-Hold Account</a>';
                        }
                        else if (data.status == 4)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                        }
                        else if (data.status == 1)
                        {
                            if(distance > 1)
                            {
                                return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                                    '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-wrench"></i> Ongoing </a>';

                            }
                            else
                            {
                                return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                                    '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> Late </a>';
                            }
                        }
                        else if (data.status == 10)
                        {
                            if(data.type_user == 'cc_bank')
                            {
                                if(data.status_report == 'Contacted')
                                {
                                    return '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                                }
                            }
                            else
                            {
                                if(data.status_report == 'Complete')
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                                        '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                                        '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                                }
                            }
                        }
                        else if(data.status == 2)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned</a>';
                        }
                        else if(data.status == 3)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';
                        }
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                },
                {
                    data: function(data)
                    {
                        return '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
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

    $('#cc_tele_generaltbl_filter input').unbind();
    $('#cc_tele_generaltbl_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_general_search.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_general_search.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_general_search.column(2).visible(true);
        table_general_search.column(1).visible(false);
        table_general_search.column(6).visible(false);
        table_general_search.column(7).visible(false);

    }
    else if(clientTypeAuth == 'cc')
    {
        table_general_search.column(2).visible(false);
        table_general_search.column(1).visible(true);
        table_general_search.column(6).visible(true);
        table_general_search.column(7).visible(true);

    }
}

$('#cc_tele_accounts_table').on('click', '.btn_view_reasonDelay', function()
{
    endorseID = $(this).attr("id");

    $('#modal-view-reasonToTele').modal("show");

    $.ajax
    (
        {
            type: 'get',
            url: 'cc-tele-view-reason',
            data: {
                'id' : endorseID
            },
            success: function(data)
            {
                $('#reasonOfDelay').html(data[0].remarks);
            },
            complete: function()
            {
                table_acknowledge_tele.ajax.reload(null, false);
            }
        }
    );
});



$('.check4BI').click(function()
{
    if($('#check1').is(':checked'))
    {
        $('#tableCheck1').show();
    }
    else
    {
        $('#tableCheck1').hide();
    }

    if($('#check2').is(':checked'))
    {
        $('#tableCheck2').show();
    }
    else
    {
        $('#tableCheck2').hide();
    }

    if($('#check3').is(':checked'))
    {
        $('#tableCheck3').show();
    }
    else
    {
        $('#tableCheck3').hide();
    }

    if($('#check4').is(':checked'))
    {
        $('#tableCheck4').show();
    }
    else
    {
        $('#tableCheck4').hide();
    }

    if($('#check5').is(':checked'))
    {
        $('#tableCheck5').show();
    }
    else
    {
        $('#tableCheck5').hide();
    }

    if($('#check6').is(':checked'))
    {
        $('#tableCheck6').show();
    }
    else
    {
        $('#tableCheck6').hide();
    }

    if($('#check7').is(':checked'))
    {
        $('#tableCheck7').show();
    }
    else
    {
        $('#tableCheck7').hide();
    }

    if($('#check8').is(':checked'))
    {
        $('#tableCheck8').show();
    }
    else
    {
        $('#tableCheck8').hide();
    }
});

// function fixDiv() {
//     var $cache = $('#getFixed');
//     if ($('.modal-body').scrollTop() > 50)
//     {
//         $cache.css({
//             'position': 'fixed',
//             'top': '0px',
//             'left': '25px',
//             'width': '600px'
//         });
//     }
//     else
//         $cache.css({
//             'position': 'relative',
//             'top': 'auto',
//             'left': '10px'
//         });
// }
// $('.modal-body').scroll(fixDiv);
// fixDiv();
//
// //
// $('#modal-view-encode-data').on('scroll',function () {
//
//     var header_fixed = document.getElementById("fixed_on_scroll");
//     var sticky_fixed = header_fixed.offsetTop;
//
//     myFunction(sticky_fixed,header_fixed);
//
// });
//
// // window.onscroll = function () {
// //     var header_fixed = document.getElementById("fixed_on_scroll");
// //     var sticky_fixed = header_fixed.offsetTop;
// //
// //     myFunction(sticky_fixed,header_fixed);
// // };
//
//
// function myFunction(sticky_fixed,header_fixed) {
//
//     // var page = 16;
//     var page = window.pageYOffset;
//
//     console.log(page+' scroll ' +sticky_fixed);
//
//     if (page > sticky_fixed)
//     {
//         header_fixed.classList.add("sticky");
//     }
//     else
//     {
//         header_fixed.classList.remove("sticky");
//     }
// }
addCharReference = 0;

$('#addCharRef').click(function(e)
{

    addCharReference++;
    e.preventDefault();

    var addCharRef = '<tr class="row'+addCharReference+' dontloop">\n' +
        '                                                <td colspan="12" style="background-color: black; color: white;">\n' +
        '                                                    <input type="checkbox" checked class="pull-left checkboxChecker">\n' +
        '                                                    CHARACTER REFERENCE\n' +
        '                                                </td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Name of Reference:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Contact Number:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Position:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Company:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Business Address:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addCharReference+'">\n' +
        '                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Remarks:</td>\n' +
        '                                                <td colspan="10" class="charRefData_'+addCharReference+'"><input type="text" class="form-control charRefData_'+addCharReference+'"></td>\n' +
        '                                            </tr>' +
        '                                            <tr class="row'+addCharReference+'delete dontloop">\n' +
        '                                                <td colspan="12"><button class="btn btn-danger form-control removeCharRef rowHide" id="'+addCharReference+'"><span class="glyphicon glyphicon-remove"></span></button></td>\n' +
        '                                            </tr>';

    $('#forspantablee').append('<table class="table-hover table-condensed toShowThis charRefTable_'+addCharReference+' row'+addCharReference+'delete" style="margin-top: 15px; font-weight: bold;" width="100%">'+ addCharRef + '</table>');

    charRefArray.push(addCharReference);
});

$(document).on('click', '.removeCharRef', function()
{
    var button_id = $(this).attr("id");
    $('.row'+button_id+'').remove();
    $('.row'+button_id+'delete').remove();
    var parsed = parseInt(button_id);

    for(var i = 0; i < charRefArray.length; i++){
        if ( charRefArray[i] === parsed) {
            charRefArray.splice(i, 1);
        }
    }

    console.log(charRefArray);

});

addEmployment = 0;

$('#addEmployment').click(function(e)
{
    addEmployment++;
    e.preventDefault();

    var addEmp = '' +
        '<tr class="row'+addEmployment+' dontloop">\n' +
        '                                                <td colspan="12" style="background-color: black; color: white;">\n' +
        '                                                    <input type="checkbox" checked class="pull-left checkboxChecker">\n' +
        '                                                    EMPLOYMENT HISTORY\n' +
        '                                                </td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+' dontloop">\n' +
        '                                                <td colspan="12">\n' +
        '                                                    <input type="checkbox" checked class="pull-left checkboxChecker">\n' +
        '                                                    EMPLOYMENT\n' +
        '                                                </td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+' dontloop">\n' +
        '                                                <td colspan="3"><input type="checkbox" checked class="pull-left checkboxChecker">Details</td>\n' +
        '                                                <td colspan="3">Subject Declared</td>\n' +
        '                                                <td colspan="3">Verified Information</td>\n' +
        '                                                <td colspan="3">CCSI Remarks</td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Employer</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Address</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Industry</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Job Title Reported</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Dates of Service Reported</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Employee Status</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Reason for Departure</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Eligible for Rehire</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Clearance</td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                                <td colspan="3" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Other comments</td>\n' +
        '                                                <td colspan="9" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'">\n' +
        '                                                <td colspan="3" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Contact Name/Position/Number</td>\n' +
        '                                                <td colspan="9" class="inputteddata_'+addEmployment+'"><input type="text" placeholder="Please indicate..." class="form-control"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr class="row'+addEmployment+'delete dontloop">\n' +
        '                                                <td colspan="12"><button class="btn btn-danger form-control removeEmployment rowHide" id="'+addEmployment+'"><span class="glyphicon glyphicon-remove"></span></button></td>\n' +
        '                                            </tr>';

    $('#emplohistSpan').append('<table class="table-hover table-condensed col-md-12 toShowThis empHis_'+addEmployment+' row'+addEmployment+'delete" style="margin-top: 15px; font-weight: bold;" width="100%">'+ addEmp+ '</table>');
    addEmploymentArray.push(addEmployment);

});

$(document).on('click', '.removeEmployment', function()
{
    var button_id = $(this).attr("id");
    $('.row'+button_id+'').remove();
    $('.row'+button_id+'delete').remove();
    var parsed = parseInt(button_id);

    for(var i = 0; i < addEmploymentArray.length; i++){
        if ( addEmploymentArray[i] === parsed) {
            addEmploymentArray.splice(i, 1);
        }
    }

    // console.log(addEmploymentArray);
});

function getFinishedTable()
{
    $('#cc_tele_finished_accounts thead th').each(function()
    {
        title_finished[title_finished_counts] = $(this).text();
        title_finished_counts++;
        var title = $(this).text();
        if(title != 'ACTION')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
    });

    table_finished_table = $('#cc_tele_finished_accounts').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc-tele-finished-accounts',
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
                                        return title_finished[(idx)];
                                    },
                                    body: function (data,row,column) {
                                        // Strip $ from salary column to make it numeric
                                        if(column <= 7)
                                        {
                                            return data.replace( /<br\s*\/?>/ig, "\r\n");
                                        }
                                        else
                                        {
                                            // return data;
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
                        return title_finished[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'due', 'searchable' : false, 'orderable' : false},
                {
                    data : function action(data)
                    {
                        return '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
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

    $('#cc_tele_finished_accounts_filter input').unbind();
    $('#cc_tele_finished_accounts_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_finished_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_finished_table.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_finished_table.column(2).visible(true);
        table_finished_table.column(1).visible(false);
        table_finished_table.column(6).visible(false);
        table_finished_table.column(7).visible(false);
        table_finished_table.column(9).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_finished_table.column(2).visible(false);
        table_finished_table.column(1).visible(true);
        table_finished_table.column(6).visible(true);
        table_finished_table.column(7).visible(true);
        table_finished_table.column(9).visible(true);
    }
}

function insert_account_info()
{
    var account_info_raw = '{ "account_info" : [' +
        '{ "contact_number":"'+$('#acc_contact_number').val()+'"},' +
        '{ "accnt_bday":"'+ $('#acc_dob').val()+'"},' +
        '{ "accnt_address":"'+ $('#acc_address').val()+'"},' +
        '{ "accnt_sss_num":"'+$('#acc_ss_number').val()+'"} ]}';

    var account_info = JSON.parse(account_info_raw);
}

function insert_charRef(id)
{
    var labelArray = [];
    var labelctr = 0;
    var inputtedArray = [];
    var inputtedctr = 0;

    console.log(charRefArray.length);
    if(charRefArray.length  == 1)
    {

        $('.charRefTable_0 tr').each(function()
        {
            var thiss = $(this);

            if(thiss.hasClass('dontloop'))
            {

            }
            else
            {
                thiss.children('td').each(function()
                {
                    if($(this).hasClass('charRefData_0'))
                    {
                        inputtedArray[inputtedctr] = $(this).children('input').val();
                        inputtedctr++;
                    }
                });

                labelArray[labelctr] = thiss.children(':first').text();
                labelctr++;
            }
        });

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : id,
                'dataLabel' : labelArray,
                'dataInputtedd' : inputtedArray,
                'checking_type' : 'Character Reference'
            },
            success: function(data)
            {
                console.log(data);
            }
        });


        console.log([inputtedArray, labelArray]);
    }
    else if(charRefArray.length >= 2)
    {



        var i;
        for(i = 0; i < charRefArray.length; i++)
        {
            labelArray = [];
            labelctr = 0;
            inputtedArray = [];
            inputtedctr = 0;

            $('.charRefTable_'+i+' tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('charRefData_'+i+''))
                        {
                            inputtedArray[inputtedctr] = $(this).children('input').val();
                            inputtedctr++;
                        }
                    });

                    labelArray[labelctr] = thiss.children(':first').text();
                    labelctr++;
                }
            });

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : id,
                    'dataLabel' : labelArray,
                    'dataInputtedd' : inputtedArray,
                    'checking_type' : 'Character Reference'
                },
                success: function(data)
                {
                    console.log(data);
                }
            });

            console.log([inputtedArray, labelArray]);
        }
    }
}

function insert_employmentHistory(id)
{
    var labelArray = [];
    var labelctr = 0;
    var inputtedArray = [];
    var inputtedctr = 0;

    if(addEmploymentArray.length <= 1)
    {
        $('.empHis_0 tr').each(function()
        {
            var thiss = $(this);

            if(thiss.hasClass('dontloop'))
            {

            }
            else
            {
                var countthis = $(this).children('td').length;
                if(countthis <= 2)
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('labelonly'))
                        {
                            labelArray[labelctr] = $(this).text();
                            labelctr++;
                        }
                        else if($(this).hasClass('inputteddata'))
                        {
                            inputtedArray[inputtedctr] = $(this).children('input').val();
                            inputtedctr++;
                        }
                    });
                }
                else if(countthis > 2)
                {
                    var inputtedToArray = '';

                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('inputteddata'))
                        {
                            inputtedToArray += $(this).children('input').val() + '|';
                        }
                    });
                    labelArray[labelctr] = thiss.children(':first').text();
                    labelctr++;
                    inputtedArray[inputtedctr] = inputtedToArray;
                    inputtedctr++;
                }
            }
        });

        console.log([inputtedArray, labelArray]);

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : id,
                'dataLabel' : labelArray,
                'dataInputtedd' : inputtedArray,
                'checking_type' : 'Employment History'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }
    else if(addEmploymentArray.length >= 2)
    {
        var i;
        for(i = 0; i < addEmploymentArray.length; i++)
        {
            labelArray = [];
            labelctr = 0;
            inputtedArray = [];
            inputtedctr = 0;

            $('.empHis_'+i+' tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    var countthis = $(this).children('td').length;

                    if(countthis <= 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('labelonly'))
                            {
                                labelArray[labelctr] = $(this).text();
                                labelctr++;
                            }
                            else if($(this).hasClass('inputteddata'))
                            {
                                inputtedArray[inputtedctr] = $(this).children('input').val();
                                inputtedctr++;
                            }
                        });
                    }
                    else if(countthis > 2)
                    {
                        var inputtedToArray = '';

                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                inputtedToArray += $(this).children('input').val() + '|';
                            }
                        });
                        labelArray[labelctr] = thiss.children(':first').text();
                        labelctr++;
                        inputtedArray[inputtedctr] = inputtedToArray;
                        inputtedctr++;
                    }
                }
            });

            console.log([labelArray, inputtedArray]);

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : id,
                    'dataLabel' : labelArray,
                    'dataInputtedd' : inputtedArray,
                    'checking_type' : 'Employment History'
                },
                success: function(data)
                {
                    console.log(data);
                }
            });
        }
    }
}

$('#submit_encoded_data').click(function()
{
    var labelArray = [];
    var labelctr = 0;
    var inputtedArray = [];
    var inputtedctr = 0;

    var account_info = [];
    account_info[0] = [];

    account_info[0][0] = $('#acc_contact_number').val();
    account_info[0][1] = $('#acc_dob').val();
    account_info[0][2] = $('#acc_address').val();
    account_info[0][3] = $('#acc_ss_number').val();

    if($('#check1').is(':checked'))
    {
        var dataLabel = [];
        var labelCtr = 0;
        var dataInputtedd = [];
        var datactr = 0;

        $('.labelinputted').each(function()
        {
            dataLabel[labelCtr] = $(this).text();
            labelCtr++;
        });

        $('.datainputtedinput').each(function()
        {
            dataInputtedd[datactr] = $(this).val();
            datactr++;
        });

        // console.log([dataLabel, dataInputtedd]);

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : dataLabel,
                'dataInputtedd' : dataInputtedd,
                'checking_type' : 'Pre-Employment Background Check'
            },
            success: function(data)
            {
                console.log(data);
            }
        });

    }

    if($('#check2').is(':checked'))
    {
        // insert_academic_history(endorseID);

        var acalabelArray = [];
        var acalabelctr = 0;
        var acainputtedArray = [];
        var acainputtedctr = 0;

        $('.academicTable tr').each(function()
        {
            var thiss = $(this);

            if(thiss.hasClass('dontloop'))
            {

            }
            else
            {
                var countthis = $(this).children('td').length;

                if(countthis <= 2)
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('labelonly'))
                        {
                            acalabelArray[acalabelctr] = $(this).text();
                            acalabelctr++;
                        }
                        else if($(this).hasClass('inputteddata'))
                        {
                            acainputtedArray[acainputtedctr] = $(this).children('input').val();
                            acainputtedctr++;
                        }
                    });
                }
                else if(countthis > 2)
                {
                    var inputtedToArray = '';

                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('inputteddata'))
                        {
                            inputtedToArray += $(this).children('input').val() + '|-|-|';
                        }
                    });
                    acalabelArray[acalabelctr] = thiss.children(':first').text();
                    acalabelctr++;
                    acainputtedArray[acainputtedctr] = inputtedToArray;
                    acainputtedctr++;
                }
            }
        });
        console.log([acalabelArray, acainputtedArray]);

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : acalabelArray,
                'dataInputtedd' : acainputtedArray,
                'checking_type' : 'Academic History'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }

    if($('#check3').is(':checked'))
    {
        if(addEmploymentArray.length <= 1)
        {
            $('.empHis_0 tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    var countthis = $(this).children('td').length;
                    if(countthis <= 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('labelonly'))
                            {
                                labelArray[labelctr] = $(this).text();
                                labelctr++;
                            }
                            else if($(this).hasClass('inputteddata'))
                            {
                                inputtedArray[inputtedctr] = $(this).children('input').val();
                                inputtedctr++;
                            }
                        });
                    }
                    else if(countthis > 2)
                    {
                        var inputtedToArray = '';

                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                inputtedToArray += $(this).children('input').val() + '|-|-|';
                            }
                        });
                        labelArray[labelctr] = thiss.children(':first').text();
                        labelctr++;
                        inputtedArray[inputtedctr] = inputtedToArray;
                        inputtedctr++;
                    }
                }
            });

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : endorseID,
                    'dataLabel' : labelArray,
                    'dataInputtedd' : inputtedArray,
                    'checking_type' : 'Employment History'
                },
                success: function(data)
                {
                    // console.log(data);
                }
            });
        }
        else if(addEmploymentArray.length >= 2)
        {
            var i;
            labelArray = [];
            labelctr = 0;
            inputtedArray = [];
            inputtedctr = 0;
            for(i = 0; i < addEmploymentArray.length; i++)
            {


                $('.empHis_'+i+' tr').each(function()
                {
                    var thiss = $(this);

                    if(thiss.hasClass('dontloop'))
                    {

                    }
                    else
                    {
                        var countthis = $(this).children('td').length;

                        if(countthis <= 2)
                        {
                            thiss.children('td').each(function()
                            {
                                if($(this).hasClass('labelonly'))
                                {
                                    labelArray[labelctr] = $(this).text();
                                    labelctr++;
                                }
                                else if($(this).hasClass('inputteddata_'+i+''))
                                {
                                    inputtedArray[inputtedctr] = $(this).children('input').val();
                                    inputtedctr++;
                                }
                            });
                        }
                        else if(countthis > 2)
                        {
                            var inputtedToArray = '';

                            thiss.children('td').each(function()
                            {
                                if($(this).hasClass('inputteddata_'+i+''))
                                {
                                    inputtedToArray += $(this).children('input').val() + '|-|-|';
                                }
                            });
                            labelArray[labelctr] = thiss.children(':first').text();
                            labelctr++;
                            inputtedArray[inputtedctr] = inputtedToArray;
                            inputtedctr++;
                        }
                    }
                });

            }

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : endorseID,
                    'dataLabel' : labelArray,
                    'dataInputtedd' : inputtedArray,
                    'checking_type' : 'Employment History'
                },
                success: function(data)
                {
                    // console.log(data);
                }
            });
        }
    }

    if($('#check4').is(':checked'))
    {
        var residentialArrayData = [];
        var ctrData = 0;
        var residentialArrayLabel = [];
        var ctrLabel = 0;

        $('.residentialTable tr').each(function()
        {
            var thiss = $(this);

            if(thiss.hasClass('dontloop'))
            {

            }
            else
            {
                var counthis = $(this).children('td').length;

                if(counthis == 1)
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('dataLabel'))
                        {
                            residentialArrayLabel[ctrData] = $(this).text();
                            ctrLabel++;
                        }
                        else if($(this).hasClass('dataInputt'))
                        {
                            residentialArrayData[ctrData] = $(this).children('input').val();
                            ctrData++;
                        }
                    });
                }
                else if(counthis == 2)
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('dataLabel'))
                        {

                            residentialArrayLabel[ctrData] = $(this).text();
                            ctrLabel++;
                        }
                        else if($(this).hasClass('dataInputt'))
                        {
                            if($($(this).children()[0]).attr('name') == 'textArea')
                            {
                                residentialArrayData[ctrData] = $(this).children('textarea').val();
                                ctrData++;
                            }
                            else
                            {
                                residentialArrayData[ctrData] = $(this).children('input').val();
                                ctrData++;
                            }
                        }
                    });
                }
            }
        });

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : residentialArrayLabel,
                'dataInputtedd' : residentialArrayData,
                'checking_type' : 'Address Check - with occular inspection all addresses for the last 10 years'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }

    if($('#check6').is(':checked'))
    {
        // insert_bi_report(endorseID);

        var bi_array = [];
        var bi_array_label = [];

        bi_array[0] = $('#bi_account_report').val();
        bi_array[1] = $('#bi_account_reference_code').val();
        bi_array[2] = $('#bi_account_dateReq').val();
        bi_array[3] = $('#bi_account_dateDue').val();
        bi_array[4] = $('#bi_account_dateClosed').val();
        bi_array[5] = $('#bi_account_candidateName').val();
        bi_array[6] = $('#bi_account_candidateDOB').val();
        bi_array[7] = $('#bi_account_candidate_add').val();
        bi_array[8] = $('#bi_account_candidate_contact_num').val();
        bi_array[9] = $('#bi_account_candidate_email').val();

        bi_array_label[0] = 'ACCOUNT';
        bi_array_label[1] = 'REFERENCE CODE';
        bi_array_label[2] = 'DATE REQUESTED';
        bi_array_label[3] = 'DATE DUE';
        bi_array_label[4] = 'DATE CLOSED';
        bi_array_label[5] = 'CANDIDATE NAME';
        bi_array_label[6] = 'DATE OF BIRTH';
        bi_array_label[7] = 'CURRENT ADDRESS';
        bi_array_label[8] = 'CONTACT NUMBER';
        bi_array_label[9] = 'E-MAIL ADDRESS';

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : bi_array_label,
                'dataInputtedd' : bi_array,
                'checking_type' : 'Background Investigation Report'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }

    if($('#check7').is(':checked'))
    {
        bi_crim_rec = [];
        bi_crim_label = [];

        bi_crim_label[0] = 'IDENTITY CHECK';
        bi_crim_label[1] = 'CRIMINAL CHECK';

        bi_crim_rec[0] = $('#acc_check').val();
        bi_crim_rec[1] = $('#acc_crim_check').val();



        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : bi_crim_label,
                'dataInputtedd' : bi_crim_rec,
                'checking_type' : 'Identity & Criminal Record Verification'
            },
            success: function(data)
            {

            }
        });
    }

    if($('#check8').is(':checked'))
    {
        labelArray = [];
        labelctr = 0;
        inputtedArray = [];
        inputtedctr = 0;

        $('.cmapTable tr').each(function()
        {
            var thiss = $(this);
            var countthis = $(this).children('td').length;

            if(thiss.hasClass('dontloop'))
            {

            }
            else
            {
                if(countthis <= 2)
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('labelonly'))
                        {
                            labelArray[labelctr] = $(this).text();
                            labelctr++;
                        }
                        else if($(this).hasClass('inputteddata'))
                        {
                            inputtedArray[inputtedctr] = $(this).children('input').val();
                            inputtedctr++;
                        }
                    });
                }
                else if(countthis > 2)
                {
                    var inputtedToArray = '';
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('inputteddata'))
                        {
                            if($(this).attr('what') == 'select')
                            {
                                inputtedToArray += $(this).children('select').val() + '|-|-|';
                            }
                            else
                            {
                                inputtedToArray += $(this).children('input').val() + '|-|-|';
                            }
                        }
                    });
                    labelArray[labelctr] = thiss.children(':first').text();
                    labelctr++;
                    inputtedArray[inputtedctr] = inputtedToArray;
                    inputtedctr++;
                }
            }
        });

        $.ajax({
            type: 'post',
            url: 'insert_tele_encoded_data',
            data: {
                'endorsement_id' : endorseID,
                'dataLabel' : labelArray,
                'dataInputtedd' : inputtedArray,
                'checking_type' : 'Financial & Court Case Records Verification (CMAP)'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }

    if($('#check5').is(':checked'))
    {
        // insert_charRef(endorseID);

        var creflabelArray = [];
        var creflabelctr = 0;
        var crefinputtedArray = [];
        var crfinputtedctr = 0;

        // console.log(charRefArray.length);
        if(charRefArray.length  == 1)
        {

            creflabelArray = [];
            creflabelctr = 0;
            crefinputtedArray = [];
            crfinputtedctr = 0;

            $('.charRefTable_0 tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('charRefData_0'))
                        {
                            crefinputtedArray[crfinputtedctr] = $(this).children('input').val();
                            crfinputtedctr++;
                        }
                    });

                    creflabelArray[creflabelctr] = thiss.children(':first').text();
                    creflabelctr++;
                }
            });

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : endorseID,
                    'dataLabel' : creflabelArray,
                    'dataInputtedd' : crefinputtedArray,
                    'checking_type' : 'Character Reference'
                },
                success: function(data)
                {
                    console.log(data);
                }
            });
        }
        else if(charRefArray.length >= 2)
        {
            var i;
            for(i = 0; i < charRefArray.length; i++)
            {
                // creflabelArray = [];
                // creflabelctr = 0;
                // crefinputtedArray = [];
                // crfinputtedctr = 0;

                $('.charRefTable_'+i+' tr').each(function()
                {
                    var thiss = $(this);

                    if(thiss.hasClass('dontloop'))
                    {

                    }
                    else
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('charRefData_'+i+''))
                            {
                                crefinputtedArray[crfinputtedctr] = $(this).children('input').val();
                                crfinputtedctr++;
                            }
                            else if($(this).hasClass('labelonly'))
                            {
                                // console.log($(this).children().context.firstChild.data);
                                creflabelArray[creflabelctr] = $(this).children().context.firstChild.data;
                                creflabelctr++;
                            }
                        });
                    }
                });
            }
            // console.log([crefinputtedArray, creflabelArray]);

            $.ajax({
                type: 'post',
                url: 'insert_tele_encoded_data',
                data: {
                    'endorsement_id' : endorseID,
                    'dataLabel' : creflabelArray,
                    'dataInputtedd' : crefinputtedArray,
                    'checking_type' : 'Character Reference'
                },
                success: function(data)
                {
                    console.log(data);
                }
            });
        }
    }


});


$(document).on('click', '.getLogsData', function()
{
    var thiss = $(this);
    var log_id = $(this).attr('id');
    var btn = $(this).attr('click');


    if(btn == 'true')
    {
        console.log('naclick na');
    }
    else
    {
        thiss.attr('click');
        thiss.attr('click', 'true');
        $.ajax({
            type: 'get',
            url: 'cc_tele_logs_data',
            data: {
                'log_id' : log_id
            },
            success: function(data)
            {
                var i;
                for(i = 0; i < data[0].length; i++)
                {
                    if($('#check2').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'Education Check')
                        {
                            getAcademicHistoryData(log_id);
                        }
                    }

                    if($('#check8').is(':checked'))
                    {
                        if (data[0][i].checking_name == 'CMAP CHECK')
                        {
                            getFinancialCMAPData(log_id);
                        }
                    }

                    if($('#check1').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'Pre-Employment Background Check')
                        {
                            getPreEmpData(log_id);
                        }
                    }

                    if($('#check4').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'ADDRESS CHECK - WITH OCCULAR INSPECTION ALL ADDRESSES FOR THE LAST 10 YEARS')
                        {
                            getResidentialData(log_id);
                        }
                    }

                    if($('#check6').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'Background Investigation Report')
                        {
                            getBI_reportData(log_id);
                        }
                    }

                    if($('#check7').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'CRIMINAL RECORDS CHECK')
                        {
                            getIdCrimCheckReportData(log_id);
                        }
                    }

                    if($('#check3').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'EMPLOYMENT CHECK (FOR ALL LISTED EMPLOYER IN THE LAST 10 YEAR)' || data[0][i].checking_name == 'Employment Check (for all listed employer in the last 7 years)')
                        {
                            getEmploymentHistData(log_id);
                        }
                    }

                    if($('#check5').is(':checked'))
                    {
                        if(data[0][i].checking_name == 'Character Reference')
                        {
                            getCharRefData(log_id);
                        }
                    }

                }
            },
            complete: function()
            {
                $('#tableCheck1 tr td').children('input').val('');
                $('#tableCheck1 tr td').children('textarea').val('');
                $('.academicTable tr td').children('input').val('');
                $('.empHis_0 tr td').children('input').val('');
                $('.residentialTable tr td').children('input').val('');
                $('.residentialTable tr td').children('textarea').val('');
                $('.bi_reportTable tr td').children('input').val('');
                $('.id_crim_table tr td').children('input').val('');
                $('.cmapTable tr td').children('input').val('');
                $('.cmapTable tr td').children('select').val('-');
                $('.charRefTable_0 tr td').children('input').val('');
            }
        });

        console.log('nope');
    }
});

function getAcademicHistoryData(log_id)
{
    $.ajax({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Academic History'

        },
        success: function (data)
        {
            var ctr = 3;
            var ctrall = 0;
            var d = 0;
            var ccttrr = 0;
            var splitData = [];
            var rev = 0;

            for(rev = 0; rev < data[0].length; rev++)
            {
                splitData[d] = data[0][rev].inputted.split('|-|-|');
                d++;
            }

            $('.academicTable tr').each(function()
            {
                ctrall = 0;
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    var countthis = $(this).children('td').length;

                    if(countthis <= 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                $(this).children('input').val(splitData[ctr][0]);
                                ctr++;
                            }
                        });
                    }
                    else if(countthis > 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                $(this).children('input').val(splitData[ccttrr][ctrall]);
                                ctrall++;
                            }
                        });
                        ccttrr++
                    }
                }
            });
        }
    });
}

function getFinancialCMAPData(log_id)
{
    $.ajax
    ({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Financial & Court Case Records Verification (CMAP)'

        },
        success: function (data)
        {
            var ctr = 0;
            var d = 0;
            var ctrall = 4;
            var ccttrr = 0;
            var splitData = [];
            var rev = 0;

            for(rev = 0; rev < data[0].length; rev++)
            {
                splitData[d] = data[0][rev].inputted.split('|-|-|');
                d++;
            }

            $('.cmapTable tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {
                    var countthis = $(this).children('td').length;

                    if(countthis <= 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                $(this).children('input').val(splitData[ctr][0]);
                                ctr++;
                            }
                        });
                    }
                    else if(countthis > 2)
                    {
                        ccttrr = 0;

                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('inputteddata'))
                            {
                                if($(this).attr('what') == 'select')
                                {
                                    $(this).children('select').val(splitData[ctrall][ccttrr]);
                                    ccttrr++;
                                }
                                else
                                {
                                    $(this).children('input').val(splitData[ctrall][ccttrr]);
                                    ccttrr++;
                                }
                            }
                        });
                        ctrall++;
                    }
                }
            });
        }
    });
}

function getPreEmpData(log_id)
{
    $.ajax({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Pre-Employment Background Check'

        },
        success: function (data)
        {
            var ctr = 0;

            $('.pre-employmentTable tr').each(function()
            {
                var thiss = $(this);

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {

                    thiss.children('td').each(function()
                    {
                        if($(this).hasClass('datainputted'))
                        {
                            if($($(this).children()[0]).attr('name') == 'txtArea')
                            {
                                $(this).children('textarea').val(data[0][ctr].inputted);
                                ctr++;
                            }
                            else if($($(this).children()[0]).attr('name') == 'inputType')
                            {
                                $(this).children('input').val(data[0][ctr].inputted);
                                ctr++;
                            }
                        }
                    });

                }
            });
        }
    });
}

function getResidentialData(log_id)
{
    $.ajax
    ({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Residential History'

        },
        success: function(data)
        {
            var ctr = 0;
            var ctr1 = 0;
            $('.residentialTable tr').each(function()
            {
                ctr = 0;
                var thiss = $(this);

                if(thiss.hasClass('dontlooop'))
                {

                }
                else
                {
                    var counthis = $(this).children('td').length;

                    if(counthis == 1)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('dataLabel'))
                            {

                            }
                            else if($(this).hasClass('dataInputt'))
                            {
                                $(this).children('input').val(data[0][ctr1].inputted);
                                ctr1++;
                            }
                        });
                    }
                    else if(counthis == 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('dataLabel'))
                            {

                            }
                            else if($(this).hasClass('dataInputt'))
                            {
                                if($($(this).children()[0]).attr('name') == 'textArea')
                                {
                                    $(this).children('textarea').val(data[0][3].inputted);
                                }
                                else
                                {
                                    $(this).children('input').val(data[0][ctr1].inputted);
                                    ctr1++
                                }
                            }
                        });
                    }
                }

            });
        }
    });
}

function getBI_reportData(log_id)
{
    $.ajax
    ({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Background Investigation Report'

        },
        success: function(data)
        {
            var ctr = 0;
            $('.bi_reportTable tr').each(function()
            {
                var thiss = $(this);
                var counthis = $(this).children('td').length;

                if(thiss.hasClass('dontloop'))
                {

                }
                else
                {

                    if(counthis == 4)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('biLabel'))
                            {

                            }
                            else if($(this).hasClass('bi_data'))
                            {
                                $(this).children('input').val(data[0][ctr].inputted);
                                ctr++;
                            }
                            else if($(this).hasClass('bi_data_textarea'))
                            {
                                $(this).children('textarea').val(data[0][ctr].inputted);
                                ctr++;
                            }
                        });
                    }
                    else if (counthis == 2)
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('biLabel'))
                            {

                            }
                            else if($(this).hasClass('bi_data'))
                            {
                                $(this).children('input').val(data[0][ctr].inputted);
                                ctr++;
                            }
                            else if($(this).hasClass('bi_data_textarea'))
                            {
                                $(this).children('textarea').val(data[0][ctr].inputted);
                                ctr++;
                            }
                        });
                    }
                }
            });
        }
    });
}

function getIdCrimCheckReportData(log_id)
{
    $.ajax({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data:
            {
                'id' :log_id,
                'type' : 'Identity & Criminal Record Verification'

            },
        success: function(data)
        {
            $('#acc_check').val(data[0][0].inputted);
            $('#acc_crim_check').val(data[0][1].inputted);
        }
    });
}

function getCharRefData(log_id)
{
    $.ajax({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Character Reference'

        },
        success: function(data)
        {
            // console.log(data);

            var i;
            var ctr = 0;

            for(i = 0; i < data[1]; i++)
            {

                if(i > 0)
                {
                    $('#addCharRef').click();
                }

                $('.charRefTable_'+i+' tr').each(function()
                {
                    var thiss = $(this);

                    if(thiss.hasClass('dontloop'))
                    {

                    }
                    else
                    {
                        thiss.children('td').each(function()
                        {
                            if($(this).hasClass('charRefData_'+i+''))
                            {
                                $(this).children('input').val(data[0][ctr].inputted);
                                ctr++;
                            }
                            else if($(this).hasClass('labelonly'))
                            {

                            }
                        });
                    }
                });


            }
        }
    });
}

function getEmploymentHistData(log_id)
{
    $.ajax({
        type: 'get',
        url: 'tele_get_log_checkcing',
        data: {
            'id' :log_id,
            'type' : 'Employment History'

        },
        success: function(data)
        {
            // console.log(data);

            var i;
            var ctr = 0;
            var splitData = [];
            var d = 0;
            var indexu = 0;

            for(d = d; d < data[0].length; d++)
            {
                splitData[d] = data[0][d].inputted.split('|-|-|');
            }

            // console.log(splitData);

            for(i = 0; i < data[1]; i++)
            {
                if(i > 0)
                {
                    $('#addEmployment').click();
                }

                $('.empHis_'+i+' tr').each(function()
                {
                    var thiss = $(this);
                    var countings = $(this).children('td').length;

                    if(thiss.hasClass('dontloop'))
                    {

                    }
                    else
                    {
                        if(countings == 4)
                        {
                            thiss.children('td').each(function()
                            {
                                if($(this).hasClass('inputteddata_'+i))
                                {
                                    $(this).children('input').val(splitData[indexu][ctr]);
                                    ctr++
                                }
                                else
                                {
                                    ctr = 0;
                                }

                            });

                        }
                        else if(countings == 2)
                        {
                            thiss.children('td').each(function()
                            {
                                if($(this).hasClass('inputteddata_'+i))
                                {
                                    $(this).children('input').val(splitData[indexu][ctr]);
                                    ctr++
                                }
                                else
                                {
                                    ctr = 0;
                                }

                            });
                        }
                        indexu++;
                    }
                });
            }
        }
    });
}

$('.checkboxChecker').click(function()
{
    console.log($(this).closest('tr'));
});

$('#btnTelePrint').click(function()
{
    $('.checkboxChecker').each(function()
    {
        var thiss = $(this);

        if(thiss.prop('checked') == false)
        {
            thiss.closest('tr').addClass('rowHide');
        }
        else
        {
            thiss.closest('tr').removeClass('rowHide');
        }
    });


    $('.checkboxChecker').hide();

    var domClone = document.getElementById("printThis").cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
    // window.close();
    domClone.parentNode.removeChild(domClone);
    $('.checkboxChecker').show();
    $('.rowHide').show();
});

function GetteleLogs()
{
    $.ajax({
        type: 'get',
        url: 'get_cc_tele_report_logs',
        success: function(data)
        {
            if(data[0] == '')
            {
                $('#reports_logs_cc').append('<tr><td>No records found</td></tr>');
                $('#splitterTest').css('overflow-y', '');
            }
            else
            {
                var datas = '<tr style="background-color: black; color: white;">\n' +
                    '                                                    <th>REPORT LOGS</th>\n' +
                    '                                                </tr>';
                var huy;
                var inputteddata ='';
                for(huy = 0; huy < data.length; huy++)
                {
                    inputteddata +='<tr>' +
                        '<td><a style="text-decoration: underline; color: black; cursor: pointer" class="getLogsData" id="'+data[0][huy].report_log_id+'">'+data[0][huy].report_log_id+'</a>/'+data[0][huy].created_at+'</td>' +
                        '</tr>';
                }

                $('#reports_logs_cc').html('<table class="table-hover table-condensed" width="100%" border="0" id="reports_logs_cc">'+datas+inputteddata+'</table>');

                if(data[0].length > 5)
                {
                    $('#splitterTest').css('overflow-y', 'scroll');
                }
                else
                {
                    $('#splitterTest').css('overflow-y', '');
                }
            }
        }
    });
}

$('#testPrintBank').click(function()
{
    $(this).attr('disabled', true);

    PrintPreview();

});

var checkCivilCCBank = false;

$('#borCivilStat').change(function()
{
    if($(this).find(':selected').val() == 'Married')
    {
        checkCivilCCBank = true;

        $('#cBankAddCob').click();
    }

    $('#borCivilStatToPrint').val($(this).find(':selected').val());
});




$('#cBankAddCob').click(function()
{
    $('#showToAddCob').show();

    cobArrayContents.push([[], []]);

    var checkCiv = '';
    var a = ' <tr class = "coMakerid-'+cMc+'">\n' +
        '                                                            <td colspan="4">\n' +
        '                                                                <table class = "table-condensed check-cob-main-lagay" style = "width : 100%; table-layout:fixed "   name="'+cMc+'">\n' +
        '                                                                    <tr class = "dontMinimize">\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;"> CO-MAKER INFORMATION\n' +
        '                                                                            <button type="button" class = "btn btn-danger btn-md pull-right" id= "removeCoM" name = "'+cMc+'" tabIndex="-1"><i class="fa fa-fw fa-close"></i></button>\n' +
        '                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  name = "'+cMc+'" tabIndex="-1"><i class="fa fa-fw fa-minus"></i></button>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Last Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-0"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">First Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-2"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Middle Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-4"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Birthdate :</td>\n' +
        '                                                                        <td colspan="2"><input type="date" class = "form-control save_dataa" id="CoMakers-'+cMc+'-1"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Place of Birth :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-3"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Civil Status :</td>\n' +
        '                                                                        <td colspan="2">\n' +
        '                                                                            <select class = "form-control save_dataa select_type_loop relCivSelect-'+cMc+' rowHide notToPrintSelect" id="CoMakers-'+cMc+'-5" >\n' +
        '                                                                                <option name = "'+cMc+'" value="-">-</option>\n' +
        '                                                                                <option name = "'+cMc+'" value="Single">Single</option>\n' +
        '                                                                                <option name = "'+cMc+'" value="Single with Live in Partner">Single with Live in Partner</option>\n' +
        '                                                                                <option name = "'+cMc+'" value="Single with Common Law">Single with Common Law</option>\n' +
        '                                                                                <option name = "'+cMc+'" value="Married">Married</option>\n' +
        '                                                                                <option name = "'+cMc+'" value="Married but not Legally Separated">Married but not Legally Separated</option>\n' +
        '                                                                                <option name = "'+cMc+ '" value="Legally Separated">Legally Separated</option>\n' +
        '                                                                            </select>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Relationship to Borrower :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control relCiv-'+cMc+' save_dataa" id="CoMakers-'+cMc+'-8"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Mother\'s Maiden Name : </td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-6"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Dependent/s :</td>\n' +
        '                                                                        <td colspan="2" id = "COMdependentstoAdd-'+cMc+'" class = "paddingBotAdjust">\n' +
        '                                                                            <input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-35" name = "depToPrint">\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">KYC: TIN # :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-7"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">KYC: SSS# :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-9"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Additional Remarks : </td>\n' +
        '                                                                        <td colspan="2"><textarea id="CoMakers-'+cMc+'-10" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                </table>\n' +
        '                                                            </td>\n' +
        '                                                        </tr>' +

        '                                               <tr class = "coMakerid-'+cMc+'">\n' +
        '                                                 <td colspan="4">\n' +
        '                                                   <table class = "table-condensed check-cob-main-lagay" style = "width : 100%; table-layout:fixed " name="'+cMc+'">\n' +
        '                                                     <tr>\n' +
        '                                                       <td colspan="4" style = "background-color: black; color : white;"> <span style = "text-align: center">CO-MAKER\'S SPOUSE  <small style = "color : orange">*if applicable</small></span>\n' +
        '                                                        <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px;"  name = "'+cMc+'" tabIndex="-1">\n' +
        '                                                          <i class="fa fa-fw fa-minus"></i></button>\n' +
        '                                                       </td>\n' +
        '                                                    </tr>\n' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Last Name :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-45"></td>' +
        '                                                </tr>' +
        '                                                 <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">First Name :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-21"></td>' +
        '                                                </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Middle Name :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-22"></td>' +
        '                                                </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Birthdate :</td>' +
        '                                                    <td colspan="2"><input type="date" class = "form-control save_dataa" id="CoMakers-'+cMc+'-23"></td>' +
        '                                                </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Place of Birth :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-24"></td>' +
        '                                                </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">KYC: TIN # :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-25"></td>' +
        '                                                </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">KYC: SSS# :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CoMakers-'+cMc+'-26"></td>' +
        '                                                </tr>' +
        '                                                <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Additional Remarks : </td>\n' +
        '                                                    <td colspan="2"><textarea id="CoMakers-'+cMc+'-27" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                                </tr>' +
        '                                              </table>\n' +
        '                                             </td>\n' +
        '                                           </tr>' +

        '                                           <tr class = "coMakerid-'+cMc+'">' +
        '                                              <td colspan="4">' +
        '                                               <table class = "table-condensed check-cob-main-lagay" style = "width : 100%; table-layout:fixed " name="'+cMc+'">' +
        '                                            <tr>' +
        '                                                <td colspan="4" style = "background-color: black; color : white;"> <span class = "moveMe" style = "padding-left: 250px">CO-MAKER\'S PRESENT ADDRESS</span>' +
        '                                                   <span class = "rowHide hidetoPDF pull-right"><input type="checkbox" tabIndex="-1" id = "checktoAdd-'+cMc+'" name = "'+cMc+'" class= "checktoAdd">Same as borrower\'s address information' +
        '                                                               <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px;"  name = "'+cMc+'" tabIndex="-1">' +
        '                                                                     <i class="fa fa-fw fa-minus"></i></button>'+
        '                                                       </span> ' +
        '</td>' +
        '                                            </tr>' +
        '                                            <tr class = "addedAddress" >' +
        '                                                <td colspan="2" style="font-weight:bold;">Complete Address :</td>' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa address-'+cMc+'-0 addressesCob-'+cMc+' presentAddressCopyMe-'+cMc+' textAreatoInputCob hidePdf"  name = "'+cMc+'" href = "1" id="CoMakers-'+cMc+'-13" placeholder = "Insert adress here...."></textarea>' +
        // '                                               <p class = "showPdf address-'+cMc+'-0 save_dataa addressesCob-'+cMc+' presentAddressCopyMe-'+cMc+'" id = "passedFromTextAreaCob-'+cMc+'-1" name = "hideMe" hidden></p>' +
        '</td>' +
        '                                            </tr>' +
        '                                            <tr>' +
        '                                                <td colspan="2" style="font-weight:bold;">Length of Stay :</td>' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-1 addressesCob-'+cMc+' presentAddressCopyMe-'+cMc+'" id="CoMakers-'+cMc+'-14"></td>' +
        '                                            </tr>' +
        '                                            <tr>' +
        '                                                <td colspan="2" style="font-weight:bold;">House Ownership :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-2 addressesCob-'+cMc+' presentAddressCopyMe-'+cMc+'" id="CoMakers-'+cMc+'-15 "></td>' +
        '                                            </tr>' +
        '                                            <t>' +
        '                                                <td colspan="2" style="font-weight:bold;word-wrap:break-word">Proof of Billing :</td>' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-3 addressesCob-'+cMc+' presentAddressCopyMe-'+cMc+'" id="CoMakers-'+cMc+'-16" "></td>' +
        '                                            </tr>' +
        '                                                <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Additional Remarks : </td>\n' +
        '                                                    <td colspan="2"><textarea id="CoMakers-'+cMc+'-28" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                                </tr>' +
        '                                              </table>' +
        '                                             </td>' +
        '                                            </tr>' +

        '                                               <tr class = "coMakerid-'+cMc+'">' +
        '                                                 <td colspan="4">' +
        '                                                <table class = "table-condensed check-cob-main-lagay" style = "width : 100%; table-layout:fixed " name="'+cMc+'">' +
        '                                              <tr>' +
        '                                                  <td colspan="4" style = "background-color: black; color : white;"><span class = "moveMeToPresent" style = "padding-left : 134px">CO-MAKER\'S PERMANENT/PROVINCIAL/ANCESTRAL ADDRESS</span> <span class = "rowHide hidetoPDF pull-right" ><input type="checkbox" tabIndex="-1" id = "checktoSametoPresent-'+cMc+'" name = "'+cMc+'" class= "checktoSametoPresentCOB uncheckThis">Same as present address' +
        '                                                               <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px;"  name = "'+cMc+'" tabIndex="-1">' +
        '                                                                     <i class="fa fa-fw fa-minus"></i></button>'+
        '</span>' +

        '</td>' +
        '                                             </tr>' +
        '                                              <tr>' +
        '                                                  <td colspan="2" style="font-weight:bold;">Complete Address :</td>' +
        '                                                    <td colspan="2"><textarea class = "form-control save_dataa address-'+cMc+'-4 addressesCob-'+cMc+' textAreatoInputCob hidePdf presentAddressStorage-'+cMc+'"  name = "'+cMc+'" href = "2" id="CoMakers-'+cMc+'-17" placeholder = "Insert address here....."></textarea>' +
        // '                                                    <input type = "text" class = "form-control showPdf address-'+cMc+'-4 save_dataa" style = "display: none" id = "passedFromTextAreaCob-'+cMc+'-2" name = "hideMe"></td>' +
        // '                                                    <p class = "showPdf address-'+cMc+'-4 save_dataa addressesCob-'+cMc+' presentAddressStorage-'+cMc+'" id = "passedFromTextAreaCob-'+cMc+'-2" name = "hideMe" hidden></p>' +
        '</td>' +
        '                                               </tr>' +
        '                                               <tr>' +
        '                                                  <td colspan="2" style="font-weight:bold;">Length of Stay :</td>' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-5 addressesCob-'+cMc+' presentAddressStorage-'+cMc+'" id="CoMakers-'+cMc+'-18"></td>' +
        '                                              </tr>' +
        '                                                <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">House Ownership :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-6 addressesCob-'+cMc+' presentAddressStorage-'+cMc+'" id="CoMakers-'+cMc+'-19"></td>' +
        '                                             </tr>' +
        '                                             <tr>' +
        '                                                <td colspan="2" style="font-weight:bold; word-wrap:break-word">Proof of Billing :</td>' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa address-'+cMc+'-7 addressesCob-'+cMc+' presentAddressStorage-'+cMc+'" id="CoMakers-'+cMc+'-20"></td>' +
        '                                            </tr>' +
        '                                                <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Additional Remarks : </td>\n' +
        '                                                    <td colspan="2"><textarea id="CoMakers-'+cMc+'-29" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                                </tr>' +
        '                                           </table>' +
        '                                           </td>' +
        '                                          </tr>' +
        '                                            <tr class = "cobStorage coMakerid-'+cMc+' " >' +
        '                                                <td colspan="4" id = "containerSoiCob-'+cMc+'" class = "tableForTextInput">' +
        '                                                </td>' +
        '                                            </tr>' +
        '                                           <tr class = "coMakerid-'+cMc+' rowHide removeThisButtons comTohide-'+cMc+'">' +
        '                                                <td colspan = "2"><button type="button" class = "btn btn-block btn-warning btn-md" id = "cCoborrowerAddSoIEVR" name = "'+btoa(cMc)+'" tabIndex="-1"><i class="glyphicon glyphicon-plus" ></i> ADD COMAKER\'S SOURCE OF INCOME(EVR)</button></td>' +
        '                                                <td colspan = "2"><button type="button" class = "btn btn-block btn-success btn-md" id = "cCoborrowerAddSoIBVR" name = "'+btoa(cMc)+'" tabIndex="-1"><i class="glyphicon glyphicon-plus" ></i> ADD COMAKER\'S SOURCE OF INCOME(BVR)</button></td>' +
        '                                            </tr>';


    $(a).hide().appendTo("#addComakerTable").show();

    // $('.cobStorage').hide();


    $('.relCivSelect-'+cMc+'').change(function()
    {
        var id = $(this).find(':selected').attr('name');
        $('#borCivilStatToPrint-'+id+'').val($(this).find(':selected').val());
    });



    if(checkCivilCCBank == true)
    {
        $('.relCiv-'+cMc+'').attr('disabled', true).val('Spouse');
        $('.relCivSelect-'+cMc+'').attr('disabled', true).val('Married');
        $('#borCivilStatToPrint-'+cMc+'').val('Married');

        checkCivilCCBank = false;
    }
    else
    {
        $('.relCiv-'+cMc+'').attr('disabled', false).val('');
        $('.relCivSelect-'+cMc+'').attr('disabled', false);
    }


    $('.check-cob-main-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1" >';

        if($(this).children('td:first-child').closest('table').attr('name') == cMc)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();

    arrayCom.push(cMc);
    addressBool.push(false);
    addressBoolPresent.push(false);
    presentAddressesCOB.push([]);
    comDependensArray.push(0);

    comShowHideArr.push(false);

    cMc++;
});

$('#addComakerTable').on('click', '#removeCoM', function()
{
    var id = $(this).attr('name');

    $('.coMakerid-'+id+'').remove();

    $('.coMakerNormal-'+id+'').hide(function()
    {
        $(this).remove();
    });

    var parsed = parseInt(id);


    var indexOfCOmbo = arrayCom.indexOf(parsed);

    if (indexOfCOmbo > -1)
    {
        cobArrayContents.splice(indexOfCOmbo, 1)
    }

    for(var i = 0; i < arrayCom.length; i++)
    {
        if ( arrayCom[i] === parsed)
        {
            arrayCom.splice(i, 1);
            addressBool.splice(i, 1);
            addressBoolPresent.splice(i, 1);
            presentAddressesCOB.splice(i, 1);
            comDependensArray.splice(i, 1);
        }
    }
    if(arrayCom == '')
    {
        $('#showToAddCob').hide();
        cobArrayContents = [];
    }

});


$('#addComakerTable').on('click', '.minimizeCom', function()
{
    var thisBut = $(this);

    callMini(thisBut);
});


$('#cBorrowerAddSoIEVR').click(function()
{
    $('#showBorSoi').show();

    var b = '     ' +
        '                                        <tr class = "soiBorEVR-'+cSoiEVR+'" >\n' +
        '                                          <td colspan="4">\n' +
        '                                            <table class = "table-condensed check-to-evr-lagay" style = "width : 100%; table-layout:fixed " name = "'+cSoiEVR+'">' +
        '                                                    <tr class = "soiBorEVR-'+cSoiEVR+'">\n' +
        '                                                <td colspan="4" style = "background-color: black; color : white;">BORROWER\'S SOURCE OF INCOME(EVR)' +
        '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiBorEVR" name = "'+cSoiEVR+'" tabIndex="-1">' +
        '                                                            <i class="fa fa-fw fa-close"></i></button>' +
        '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
        '                                                </td> ' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Name :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-6"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Employer\'s name :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-0"></td>\n' +
        '                                            </tr>\n' +
        '<tr>' +
        '                                                <td colspan="2" style="font-weight:bold;">Position/Rank :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-2"></td>\n' +
        '</tr>' +
        '<tr>' +
        '                                                <td colspan="2" style="font-weight:bold;">Employment Status :</td>\n' +
        // '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-2"></td>\n' +
        '                                                <td colspan="2"><select class="form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-5">' +
        '                                                       <option value="">-</option><option value="Regular">Regular</option><option value="Probationary">Probationary</option><option value="Contractual">Contractual</option></select></td>\n' +
        '</tr>' +
        '                                            <tr >\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Monthly Salary :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-3"></td>\n' +
        '                                            </tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Tenure :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiEVR-'+cSoiEVR+'-1"></td>\n' +
        '</tr>' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Employer Address :</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textAreatoInputBorEVR hidePdf"  name = "'+cSoiEVR+'" href = "1" id="BorSoiEVR-'+cSoiEVR+'-4" placeholder="Insert Address here...."></textarea>' +
        // '                                                <input type = "text" class =
        // "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaborEVR-'+cSoiEVR+'-1" name = "hideMe"></td>\n' +
        // '                                                <p class = "showPdf save_dataa" id = "passedFromTextAreaborEVR-'+cSoiEVR+'-1" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                            </tr>' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Additional Remarks :</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textAreatoInputBorEVR showPdf" id="BorSoiEVR-'+cSoiEVR+'-5 " name = "'+cSoiEVR+'" href = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
        // '                                               <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaborEVR-'+cSoiEVR+'-2" name = "hideMe"></td>\n' +
        // '                                               <p class = "hidePdf save_dataa" id = "passedFromTextAreaborEVR-'+cSoiEVR+'-2" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                            </tr>' +
        '</table>' +
        '</td>' +
        '</tr>';


    $(b).hide().appendTo("#addSoiTableBor").show();


    $('.check-to-evr-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == cSoiEVR)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });






    // boolChecks[0] = true;

    checkPrintNot();

    bSoiComEVR.push(cSoiEVR);

    cSoiEVR++;
});

$('#addSoiTableBor').on('click', '.minimizeCom', function()
// $('.minimizeCom').click(function()
{
    var clickMini = $(this);

    callMini(clickMini)
});


$('#cBorrowerAddSoIBVR').click(function()
{
    $('#showBorSoi').show();

    var d =           '                                        <tr class = "soiBorBVR-'+cSoiBVR+'" >\n' +
        '                                          <td colspan="4">\n' +
        '                                            <table class = "table-condensed check-bor-bvr-lagay" style = "width : 100%; table-layout:fixed" name ="'+cSoiBVR+'">' +
        '                                  <tr > ' +
        '                                           <td colspan="4" style = "background-color: black; color : white;">BORROWER\'S SOURCE OF INCOME(BVR)' +
        '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiBorBVR" name = "'+cSoiBVR+'" tabIndex="-1">' +
        '                                                            <i class="fa fa-fw fa-close"></i></button>' +
        '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
        '                                                       </td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;"> Name :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-11"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Business Name :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-0"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Industry of Business :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-2"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Ownership :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-8"></td>\n' +
        '                                            </tr>' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Length of Stay :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-10"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Business Operation :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-1"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold ;word-wrap:break-word ">Monthly Income :' +
        '                                                </td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-5"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Registration :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-3"></td>\n' +
        '                                            </tr>\n' +
        // '                                            <tr>\n' +
        // '                                                <td colspan="2" style= "font-weight:bold;">Number of Employees :</td>\n' +
        // '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-4"></td>\n' +
        // '                                            </tr>\n' +
        '                                            <tr> \n' +
        '                                                <td colspan="2" style="font-weight:bold;">Business address :</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textAreatoInputBorBVR showPdf" name = "'+cSoiBVR+'" href = "1" id="BorSoiBVR-'+cSoiBVR+'-6" placeholder = "Insert Business Adress...."></textarea>' +
        // '                                                       <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaborBVR-'+cSoiBVR+'-1" name = "hideMe"></td>\n' +
        // '                                                       <p class = "hidePdf save_dataa" id = "passedFromTextAreaborBVR-'+cSoiBVR+'-1" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                            </tr>\n' +
        // '                                            <tr>\n' +
        // '                                                <td colspan="2" style="font-weight:bold;">Length of Stay :</td>\n' +
        // '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="BorSoiBVR-'+cSoiBVR+'-7"></td>\n' +
        // '                                            </tr>' +
        '                                            </tr>' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Additional Remarks :</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textAreatoInputBorBVR hidePdf" id="BorSoiBVR-'+cSoiBVR+'-9 " name = "'+cSoiBVR+'" href = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
        // '                                               <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaborBVR-'+cSoiBVR+'-2" name = "hideMe"></td>\n' +
        // '                                               <p class = "showPdf save_dataa" id = "passedFromTextAreaborBVR-'+cSoiBVR+'-2" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                            </tr>' +
        '</table>' +
        '</td>' +
        '</tr>' ;

    $(d).hide().appendTo("#addSoiTableBor").show();


    $('.check-bor-bvr-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == cSoiBVR)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });


    checkPrintNot();



    bSoiComBVR.push(cSoiBVR);

    cSoiBVR++;

});

$('#addSoiTableBor').on('click', '#removeSoiBorEVR', function()
{
    var id = $(this).attr('name');


    $('.soiBorEVR-'+id+'').remove();


    var parsed = parseInt(id);

    for(var i = 0; i < bSoiComEVR.length; i++)
    {
        if ( bSoiComEVR[i] === parsed)
        {
            bSoiComEVR.splice(i, 1);
        }
    }

    console.log(bSoiComEVR);

    if(bSoiComEVR == '' && bSoiComBVR == '')
    {
        $('#showBorSoi').hide();
    }
});

$('#addSoiTableBor').on('click', '#removeSoiBorBVR', function()
{
    var id = $(this).attr('name');


    $('.soiBorBVR-'+id+'').remove();


    var parsed = parseInt(id);

    for(var i = 0; i < bSoiComBVR.length; i++)
    {
        if ( bSoiComBVR[i] === parsed)
        {
            bSoiComBVR.splice(i, 1);
        }
    }

    console.log(bSoiComBVR);

    if(bSoiComEVR == '' && bSoiComBVR == '')
    {
        $('#showBorSoi').hide();
    }
});

$('#cBankAddRecentAddress').click(function()
{
    $('#trRecent').show();

    var c = '            ' +
        '     <tr class = "recentAdd-'+cRecent+'">\n' +
        '                                                            <td colspan="4">' +
        '                                                                <table class = "table-condensed check-to-recent-lagay" style = "width : 100%; table-layout:fixed;  border-collapse:collapse " name="'+cRecent+'">' +
        '                           <tr>' +
        '                                                <td colspan="4" style = "background-color: black; color : white;">BORROWER\'S RECENT ADDRESS' +
        '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id="removeSoiBor" name = "'+cRecent+'" tabIndex="-1">' +
        '                                                            <i class="fa fa-fw fa-close"></i></button>' +
        '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
        '                                                </td>' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Complete Address :</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textareaToInputRecent hidePdf" id="recAdd-'+cRecent+'-0"  name = "'+cRecent+'" placeholder="Insert address here......"></textarea>' +
        // '                                               <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaborRecent-'+cRecent+'" name = "hideMe"></td>\n' +
        // '                                               <p class = "showPdf save_dataa" id = "passedFromTextAreaborRecent-'+cRecent+'" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Length of Stay :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="recAdd-'+cRecent+'-1"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">House Ownership :</td>\n' +
        '                                                <td colspan="2"><input type = "text" class = "form-control save_dataa" id="recAdd-'+cRecent+'-2"></td>\n' +
        '                                            </tr>\n' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Proof of Billing :</td>\n' +
        '                                                <td colspan="2"><input type="text" class = "form-control save_dataa" id="recAdd-'+cRecent+'-3"></td>\n' +
        '                                            </tr>' +
        '                                            <tr>\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Additional Remarks : </td>\n' +
        '                                                <td colspan="2"><textarea id="recAdd-'+cRecent+'-4" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                            </tr>' +
        '</table>' +
        '</td>' +
        '</tr>';


    $(c).hide().appendTo("#containerRecentAdd").show();

    $('.check-to-recent-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == cRecent)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();


    recentAddArr.push(cRecent);

    cRecent++;
});

$('#containerRecentAdd').on('click', '#removeSoiBor', function()
{
    var id = $(this).attr('name');


    $('.recentAdd-'+id+'').remove();


    var parsed = parseInt(id);

    for(var i = 0; i < recentAddArr.length; i++)
    {
        if (recentAddArr[i] === parsed)
        {
            recentAddArr.splice(i, 1);
        }
    }

    console.log(recentAddArr);

    if(recentAddArr == '')
    {
        $('#trRecent').hide();
    }
});

$('#containerRecentAdd').on('click', '.minimizeCom', function()
{
    var thisBut = $(this);

    callMini(thisBut)
});


$('#addComakerTable').on('click', '#cCoborrowerAddSoIEVR', function()
{
    var idCom = atob($(this).attr('name'));

    $('#containerSoiCob-'+idCom+'').show();
    $('.cobStorage').show();

    var indexOfCOmbo = arrayCom.indexOf(parseInt(idCom));

    cobArrayContents[indexOfCOmbo][0].push(cobSoiEVR);

    console.log(cobArrayContents);

    var f = '                                        <tr class = "soiCoBorEVR-'+cobSoiEVR+' comTohide-'+idCom+'" >' +
        '                                              <td colspan="4">' +
        '                                                 <table class = "table-condensed check-to-cobEvr-lagay" style = "width : 100%; table-layout:fixed ;" name = "'+cobSoiEVR+'">' +
        '                                                    <tr>' +
        '                                                       <td colspan="4" style = "background-color: black; color : white;">CO-MAKER \'S SOURCE OF INCOME(EVR)' +
        '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiCoBorEVR" name = "'+cobSoiEVR+'" href = "'+idCom+'" tabIndex="-1">' +
        '                                                            <i class="fa fa-fw fa-close"></i></button>' +
        '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
        '                                                       </td> ' +
        '                                                    </tr>\n' +
        '                                                   <tr>\n' +
        '                                                       <td colspan="2" style="font-weight:bold;">Name :</td>\n' +
        '                                                       <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-6"></td>\n' +
        '                                                   </tr>\n' +
        '                                                   <tr>\n' +
        '                                                       <td colspan="2" style="font-weight:bold;">Employer\'s name :</td>\n' +
        '                                                       <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-0"></td>\n' +
        '                                                   </tr>\n' +
        '                                                   <tr>\n' +
        '                                                      <td colspan="2" style="font-weight:bold;">Position/Rank :</td>\n' +
        '                                                      <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-2"></td>\n' +
        '                                                   </tr>\n' +
        '                                                   <tr>\n' +
        '                                                     <td colspan="2" style="font-weight:bold;">Monthly Salary :</td>\n' +
        '                                                     <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-3"></td>\n' +
        '                                                   </tr>\n' +
        '                                                  <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Tenure :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-1"></td>\n' +
        '                                                 </tr>\n' +
        '                                                 <tr>\n' +
        '                                                   <td colspan="2" style="font-weight:bold;">Employer Address :</td>\n' +
        '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobEVR showPdf"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-4 " name = "'+idCom+'" href = "'+cobSoiEVR+'" num = "1" placeholder="Insert address here....."></textarea>' +
        // '                                                       <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-1" name = "hideMe"></td>\n' +
        // '                                                       <p class = "hidePdf save_dataa"  id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-1" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                                 </tr>' +
        '                                                 <tr>\n' +
        '                                                   <td colspan="2" style="font-weight:bold;">Additional Remarks :</td>\n' +
        '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobEVR showPdf"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-5 " name = "'+idCom+'" href = "'+cobSoiEVR+'" num = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
        // '                                                   <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-2" name = "hideMe"></td>\n' +
        // '                                                   <p class = "hidePdf save_dataa" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-2" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                                </tr>' +
        '                                              </table>' +
        '                                             </td>' +
        '                                           </tr>';


    $(f).hide().appendTo('#containerSoiCob-'+idCom+'').show();

    $('.check-to-cobEvr-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == cobSoiEVR)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();

    cobSoiEVR++;
});


$('#addComakerTable').on('click', '#cCoborrowerAddSoIBVR', function()
{
    var idCom = atob($(this).attr('name'));
    $('#containerSoiCob-'+idCom+'').show();
    $('.cobStorage').show();

    var indexOfCOmbo = arrayCom.indexOf(parseInt(idCom));

    cobArrayContents[indexOfCOmbo][1].push(cobSoiBVR);

    console.log(cobArrayContents);

    var g =   '                                     <tr class = "soiCoBorBVR-'+cobSoiBVR+' comTohide-'+idCom+'">' +
        '                                             <td colspan="4">\n' +
        '                                                <table class = "table-condensed check-to-cobBvr-lagay" style = "width : 100%; table-layout:fixed ;" name = "'+cobSoiBVR+'">' +
        '                                                  <tr>' +
        '                                                    <td colspan="4" style = "background-color: black; color : white;">CO-MAKER \'S SOURCE OF INCOME(BVR)' +
        '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiCoBorBVR" name = "'+cobSoiBVR+'" href = "'+idCom+'" tabIndex="-1">' +
        '                                                            <i class="fa fa-fw fa-close"></i></button>' +
        '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
        '                                                       </td>\n' +
        '                                                  </tr>\n' +
        '                                                  <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Name :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-10"></td>\n' +
        '                                                  </tr>' +
        '                                                  <tr>' +
        '                                                    <td colspan="2" style="font-weight:bold;">Business Name :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-0"></td>\n' +
        '                                                  </tr>' +
        '                                                  <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Industry of Business :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-2"></td>\n' +
        '                                                  </tr>\n' +
        '                                                  <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Ownership :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-8"></td>\n' +
        '                                                  </tr>' +
        '                                                 <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Length of Stay :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-7"></td>\n' +
        '                                                 </tr>\n' +
        '                                                 <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Business Operation :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-1"></td>\n' +
        '                                                 </tr>\n' +
        '                                                 <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold ;word-wrap:break-word ">Monthly Income :</td>' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-5"></td>\n' +
        '                                                 </tr>\n' +
        '                                                 <tr>\n' +
        '                                                    <td colspan="2" style="font-weight:bold;">Registration :</td>\n' +
        '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-3"></td>\n' +
        '                                                </tr>\n' +
        // '                                                  <tr>\n' +
        // '                                                   <td colspan="2" style= "font-weight:bold;">Number of Employees :</td>\n' +
        // '                                                   <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-4"></td>\n' +
        // '                                                 </tr>\n' +
        '                                                 <tr> \n' +
        '                                                   <td colspan="2" style="font-weight:bold;">Business address :</td>\n' +
        '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobBVR hidePdf" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-6 "  name = "'+idCom+'" href = "'+cobSoiBVR+'" num = "1"  placeholder="Enter address here....."></textarea>' +
        // '                                                       <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-1" name = "hideMe"></td>\n' +
        // '                                                       <p class = "showPdf save_dataa" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-1" name = "hideMe" hidden></p>' +
        '</td>\n' +
        '                                                </tr>\n' +
        '                                            <tr class = "soiCoBorBVR-'+cobSoiBVR+'">\n' +
        '                                                <td colspan="2" style="font-weight:bold;">Additonal Remarks</td>\n' +
        '                                                <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobBVR hidePdf" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-9 "  name = "'+idCom+'" href = "'+cobSoiBVR+'" num = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
        // '                                                   <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-2" name = "hideMe">' +
        // '                                                   <p class = "showPdf save_dataa" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-2" name = "hideMe" hidden></p>' +
        '                                                   </td>\n' +
        '                                            </tr>' +
        '                                          </table>' +
        '                                        </td>' +
        '                                     </tr>';

    $(g).hide().appendTo('#containerSoiCob-'+idCom+'').show();

    $('.check-to-cobBvr-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == cobSoiBVR)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();

    cobSoiBVR++;
});

$('#addComakerTable').on('click', '#removeSoiCoBorEVR', function()
{
    var id = $(this).attr('name');
    var idCom = $(this).attr('href');

    $('.soiCoBorEVR-'+id+'').remove();


    var parsed = parseInt(idCom);
    var indexOfCOmbo = arrayCom.indexOf(parsed);
    var indexofSoi = cobArrayContents[indexOfCOmbo][0].indexOf(parseInt(id));

    if (indexofSoi > -1)
    {
        cobArrayContents[indexOfCOmbo][0].splice(indexofSoi, 1)
    }

    if(cobArrayContents[indexOfCOmbo][0] == '' && cobArrayContents[indexOfCOmbo][1] == '')
    {
        $('#containerSoiCob-'+idCom+'').hide();
    }

});

$('#addComakerTable').on('click', '#removeSoiCoBorBVR', function()
{
    var id = $(this).attr('name');
    var idCom = $(this).attr('href');


    $('.soiCoBorBVR-'+id+'').remove();


    var parsed = parseInt(idCom);

    var indexOfCOmbo = arrayCom.indexOf(parsed);
    var indexofSoi = cobArrayContents[indexOfCOmbo][1].indexOf(parseInt(id));

    if (indexofSoi > -1)
    {
        cobArrayContents[indexOfCOmbo][1].splice(indexofSoi, 1)
    }

    if(cobArrayContents[indexOfCOmbo][0] == '' && cobArrayContents[indexOfCOmbo][1] == '')
    {
        $('#containerSoiCob-'+idCom+'').hide();
    }
});

$('#sendCCbankTele').click(function()
{
    var btn = $(this);
    var save_file = prompt('Please enter save name for encoded data', '');

    if(save_file == '' || save_file == 'N/A' || save_file == null)
    {
        alert('Please enter a valid save name!');
        btn.attr('disabled', false);
    }
    else
    {

        var dancing = '{ "data" : [';

        $('.save_dataa').each(function(){

            // if($(this).is('p'))
            // {
            //     dancing += '{ "id" : "' + $(this).attr('id') + '" , "value" : "' + $(this).html() + '"},'
            // }
            // else
            // {
            dancing += '{ "id" : "' + $(this).attr('id') + '" , "value" : "' + $(this).val() + '"},'
            // }
        });

        var new_dancing = dancing.slice(0, -1);

        new_dancing += ']}';

        // var dancing_is_wh    at_to_do = JSON.parse(new_dancing);

        $.ajax
        ({
            type : 'post',
            url : 'cc-tele-submit-cc-bank-encoding-pdrn',
            data :
                {
                    'save_file' : save_file,
                    'dancing' : new_dancing,
                    'random' : randomIDsCob
                },
            success : function(data)
            {
                if(data == 'success')
                {
                    alert('Successfully Encoded!');
                    // $('#modal-view-bank-encoding').modal('hide');
                    // clearCCbankFields();
                    btn.attr('disabled', false);
                    table_cc_bank_encoded_list.ajax.reload(null, false);
                }
            },
            complete: function()
            {
                sessionStorage.setItem(sessionName, '');
            },
            error : function()
            {
                console.log('error!');
            }

        })

    }


    //
    // btn.attr('disabled', true);
    //
    // var confirmedUnit = $('#confirmedUnitForLoanCB').val();
    // var bankForExisting = $('#bankForLoanExisting').val();
    // var dpLoanCB = $('#dpForLoanCB').val();
    // var typeOfLoanExisting = $('#typeOfLoanExisting').find(':selected').val();
    // var loanTermCB = $('#loanTermCB').val();
    // var loanTermExisting = $('#loanTermExisting').val();
    // var firstTimeCB = $('#firstTimeCB').val();
    // var monthInstallExisting = $('#monthInstallExisting').val();
    // var borLastName = $('#borLastName').val();
    // var borBday = $('#borBday').val();
    // var borFirstName = $('#borFirstName').val();
    // var borPofBirth = $('#borPofBirth').val();
    // var borMidName = $('#borMidName').val();
    // var borCivilStat = $('#borCivilStat').find(':selected').val();
    // var borMaidenName = $('#borMaidenName').val();
    // var borKYC = $('#borKYCTIN').val();
    // var borPresentAdd = $('#borPresentAdd').val();
    // var borPresentLength = $('#borPresentLength').val();
    // var borPresentOwnership = $('#borPresentOwnership').val();
    // var borPresentProofofB = $('#borPresentProofofB').val();
    // var borPermaAdd = $('#borPermaAdd').val();
    // var borPermaLength = $('#borPermaLength').val();
    // var permaOwnership = $('#permaOwnership').val();
    // var permaProofofB = $('#permaProofofB').val();
    // var bankameCB = $('#bankNameCB').val();
    // var typeofAccBC = $('#typeofAccBC').val();
    // var bankBranchCB = $('#bankBranchCB').val();
    // var accountNoCB = $('#accountNoCB').val();
    // var informantCB = $('#informantCB').val();
    // var contactedThruCB = $('#contactedThruCB').val();
    // var barangay = $('#borBarangayInfo').val();
    // var seaman = $('#borSeaOFWInfo').val();
    // var kyc_sss = $('#borKYCSSS').val();

    // var genRem = $('#ccBankEncodeGeneralRemarks').val();
    // var sendSoiEVRbor = [];
    // var sendSoiBVRbor = [];
    // var sendRecent = [];
    // var cobAllInfo = [];
    // var sendComs = [];
    // var cobEVR = [];
    // var cobBVR = [];
    // // var countCom = 0;
    //
    // if(arrayCom.length > 0)
    // {
    //     for(var q = 0; q < arrayCom.length; q++)
    //     {
    //         cobAllInfo[q] = [];
    //         sendComs = [];
    //         cobEVR = [];
    //         cobBVR = [];
    //
    //         $('.CoMakers-'+arrayCom[q]+'').each(function()
    //         {
    //             sendComs.push($(this).val());
    //         });
    //
    //         if(cobArrayContents[q][0].length > 0)
    //         {
    //             for(h = 0; h < cobArrayContents[q][0].length; h++)
    //             {
    //                 cobEVR[h] = [];
    //
    //                 $('.CobSoiEVRval-'+arrayCom[q]+'-'+cobArrayContents[q][0][h]+'').each(function()
    //                 {
    //                     cobEVR[h].push($(this).val());
    //                 });
    //             }
    //         }
    //
    //         if(cobArrayContents[q][1].length > 0)
    //         {
    //             for(y = 0; y < cobArrayContents[q][1].length; y++)
    //             {
    //                 cobBVR[y] = [];
    //
    //                 $('.CobSoiBVRval-'+arrayCom[q]+'-'+cobArrayContents[q][1][y]+'').each(function()
    //                 {
    //                     cobBVR[y].push($(this).val());
    //                 });
    //             }
    //         }
    //
    //         cobAllInfo[q].push(sendComs);
    //         cobAllInfo[q].push(cobEVR);
    //         cobAllInfo[q].push(cobBVR);
    //     }
    // }
    //
    // if(bSoiComEVR.length > 0)
    // {
    //     for(var w = 0; w < bSoiComEVR.length; w++)
    //     {
    //         sendSoiEVRbor[w] = [];
    //
    //         $('.BorSoiEVR-'+bSoiComEVR[w]+'').each(function()
    //         {
    //             sendSoiEVRbor[w].push($(this).val());
    //
    //         });
    //     }
    // }
    //
    // if(bSoiComBVR.length > 0)
    // {
    //     for(var s = 0; s < bSoiComBVR.length; s++)
    //     {
    //         sendSoiBVRbor[s] = [];
    //
    //         $('.BorSoiBVR-'+bSoiComBVR[s]+'').each(function()
    //         {
    //             sendSoiBVRbor[s].push($(this).val());
    //
    //         });
    //     }
    // }
    //
    // var SoiBorrowersAll = [sendSoiEVRbor, sendSoiBVRbor];
    //
    // // console.log(SoiBorrowersAll);
    // //
    // if(recentAddArr.length > 0)
    // {
    //     for(var t = 0; t < recentAddArr.length; t++)
    //     {
    //         sendRecent[t] = [];
    //
    //         $('.recAdd-'+recentAddArr[t]+'').each(function()
    //         {
    //             sendRecent[t].push($(this).val());
    //         });
    //     }
    // }
    //
    // if(save_file == '' || save_file == 'N/A' || save_file == null)
    // {
    //     alert('Please enter a valid save name!');
    //     btn.attr('disabled', false);
    // }
    // else
    // {
    //     $.ajax
    //     ({
    //         type : 'post',
    //         url : 'cc-tele-submit-cc-bank-encoding-pdrn',
    //         data :
    //             {
    //                 'cobAllInfo' : cobAllInfo,
    //                 'SoiBorrowersAll' : SoiBorrowersAll,
    //                 'sendRecent' : sendRecent,
    //                 'confirmedUnit' : confirmedUnit,
    //                 'bankForExisting' : bankForExisting,
    //                 'dpLoanCB' : dpLoanCB,
    //                 'typeOfLoanExisting' : typeOfLoanExisting,
    //                 'loanTermCB' : loanTermCB,
    //                 'loanTermExisting' : loanTermExisting,
    //                 'firstTimeCB' : firstTimeCB,
    //                 'monthInstallExisting' : monthInstallExisting,
    //                 'borLastName' : borLastName,
    //                 'borBday' : borBday,
    //                 'borFirstName' : borFirstName,
    //                 'borPofBirth' : borPofBirth,
    //                 'borMidName' : borMidName,
    //                 'borCivilStat' : borCivilStat,
    //                 'borMaidenName' : borMaidenName,
    //                 'borKYC' : borKYC,
    //                 'borPresentAdd' : borPresentAdd,
    //                 'borPresentLength' : borPresentLength,
    //                 'borPresentOwnership' : borPresentOwnership,
    //                 'borPresentProofofB' : borPresentProofofB,
    //                 'borPermaAdd' : borPermaAdd,
    //                 'borPermaLength' : borPermaLength,
    //                 'permaOwnership' : permaOwnership,
    //                 'permaProofofB' : permaProofofB,
    //                 'bankameCB' : bankameCB,
    //                 'typeofAccBC' : typeofAccBC,
    //                 'bankBranchCB' : bankBranchCB,
    //                 'accountNoCB' : accountNoCB,
    //                 'informantCB' : informantCB,
    //                 'contactedThruCB' : contactedThruCB,
    //                 'bi_id' : atob($(this).attr('name')),
    //                 'barangay' : barangay,
    //                 'seaman' : seaman,
    //                 'kyc_sss' : kyc_sss,
    //                 'save_file' : save_file,
    //                  'genRem' : genRem
    //             },
    //         success : function(data)
    //         {
    //             if(data == 'success')
    //             {
    //                 alert('Successfully Encoded!');
    //                 // $('#modal-view-bank-encoding').modal('hide');
    //                 // clearCCbankFields();
    //                 btn.attr('disabled', false);
    //             }
    //         },
    //         error : function()
    //         {
    //             console.log('error!');
    //         }
    //
    //     })
    // }


});

function clearCCbankFields()
{
    $('#typeOfLoanExisting').val('-');
    $('#borCivilStat').val('-');

    $('input').each(function()
    {
        if($(this).attr('name') != 'dont')
        {
            $(this).val('');
        }
    });
    $('textarea').val('');
    $('textarea').val('');
    $('#addComakerTable').html('');
    $('#containerRecentAdd').html(''); // ok
    $("#addSoiTableBor").html(''); // ok


    $('#showBorSoi').css('display', 'none'); // ok
    $('#trRecent').css('display', 'none'); // ok
    $('#showToAddCob').css('display', 'none');
    $('#addBankTable').html('');
    $('#addExistingLoan').html('');

    $('p').html('');
    $('.dependentsMinuses').remove();

    cMc = 0;
    cSoiEVR = 0;
    cSoiBVR = 0;
    cRecent = 0;
    cobSoiEVR = 0;
    cobSoiBVR = 0;
    arrayCom  = [];
    bSoiComEVR = [];
    bSoiComBVR = [];
    recentAddArr = [];
    cobArrayContents = [];
    addressBool = [];
    addressBoolPresent = [];
    presentAddressesCOB = [];
    bankInc = 0;
    existingInc = 0;
    dependentCount = 0;
    comDependensArray = [];
    randomIDsCob = [];

    $('#btnAddCobFinal').attr('disabled', false);
    $('#tdToFillCobs').html('');



}

function getContactNumbers()
{
    $('#comp_cont_num_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    table_contact_numbers = $('#comp_cont_num_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'cc_tele_contact_numbers',
        "columns":
            [
                {data: 'contact_name', name: 'company_contact_numbers.contact_name', width: '30%'},
                {data: 'contact_add', name: 'company_contact_numbers.contact_add', width: '30%'},
                {data: 'contact_num', name: 'company_contact_numbers.contact_num', width: '10%'},
                {data: 'contact_person', name: 'company_contact_numbers.contact_person', width: '10%'},
                {data: 'date_time', name : 'company_contact_numbers.id', width: '10%'},
                {
                    data:function action(data)
                    {
                        return'' +
                            '<button class="btn btn-info btn-block btn-xs update_contact_cc" id="'+data.id+'" data-target="#modal-edit-contacts" data-toggle="modal" name="'+btoa(data.contact_name)+'" add="'+btoa(data.contact_add)+'" details="'+btoa(data.contact_num)+'" cp="'+btoa(data.contact_person)+'">Update</button>' +
                            '<button class="btn btn-danger btn-block btn-xs delete_contact_cc" id="'+data.id+'">Delete</button>';
                    },
                    'name' : 'company_contact_numbers.id',
                    searchable : false,
                    orderable : false,
                    'width' : '10%'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#comp_cont_num_table_filter input').unbind();
    $('#comp_cont_num_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                table_contact_numbers.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_contact_numbers.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#comp_cont_num_table').on('click', '.update_contact_cc', function()
{
    var testingArray = [];
    var ctr = 0;
    var id = $(this).attr('id');
    $('.update_contact_text').val('');
    $('#edit_contactButton').attr('temp', btoa(id));
    testingArray[0] = atob($(this).attr('name'));
    testingArray[1] = atob($(this).attr('add'));
    testingArray[2] = atob($(this).attr('details'));
    testingArray[3] = atob($(this).attr('cp'));

    $('#modal-view-contacts').modal('hide');
    // $('#modal-edit-contacts').modal('show');

    $('.update_contact_text').each(function()
    {
        $(this).val(testingArray[ctr]);
        ctr++;
    });
});

$('#comp_cont_num_table').on('click', '.delete_contact_cc', function()
{
    var id = $(this).attr('id');
    var btn = $(this);
    btn.attr('disabled', true);

    // console.log(id);

    if(confirm('Are you sure to delete this record?'))
    {
        console.log('yes');
        $.ajax({
            type: 'get',
            url : 'delete_comp_contact_details',
            data : {
                'id' : id
            },
            success : function(data)
            {
                console.log(data);
                if(data == 'ok')
                {
                    alert('Record Successfully deleted');
                    table_contact_numbers.draw();
                }
                else
                {
                    alert('Failed to delete record');
                }
            }
        });
    }
    else
    {
        btn.attr('disabled', false);
    }
});

$('#edit_contactButton').click(function()
{
    var raw_id = $(this).attr('temp');
    var id = atob(raw_id);
    var update_array = [];
    var ctr = 0;
    $('.update_contact_text').each(function()
    {
        update_array[ctr] = $(this).val();
        ctr++;
    });

    // console.log(update_array);

    $.ajax({
        type: 'get',
        url: 'update_comp_contact_details',
        data: {
            'id': id,
            'update_array' : update_array
        },
        success: function(data)
        {
            console.log(data);
            if(data == 'ok')
            {
                alert('Contact Successfully Updated');
                table_contact_numbers.ajax.reload(null, false);
            }
            else
            {
                alert('Contact Failed to Updated');
            }

            $('#modal-edit-contacts').modal('hide');
            $('#modal-view-contacts').modal('show');
        }
    });
});

$('#add_comp_contact').click(function()
{
    var inputted_array = [];
    var ctr = 0;
    inputted_array[0] = [];

    $('.comp_cont').each(function()
    {
        inputted_array[0][ctr] = $(this).val();
        ctr++;
    });

    console.log(inputted_array);

    $.ajax({
        type: 'post',
        url: 'add_contact_number',
        data:{
            inputted_array : inputted_array
        },
        success: function(data)
        {
            console.log(data);

            if(data == 'ok')
            {
                alert('Contact Successfully Added');
                table_contact_numbers.ajax.reload(null, false);
                $('.comp_cont').val('');
            }
            else
            {
                alert('Contact Failed to Add');
            }
        }
    });
});

$.ajax
({
        type: 'get',
        url: 'tele_get_contacts',
        success: function(data)
        {
            // console.log(data);

            if(data == 'No Data')
            {
                $('#cc_contacts_list').remove();
            }
            else if(data == 'deny')
            {
                $('#cc_contacts_list').remove();
            }
            else if(data == 'grant')
            {
                console.log('show');
            }
        }
    }
);

$('#change_modal_contact').click(function()
{
    $('#modal-edit-contacts').modal('hide');
    $('#modal-view-contacts').modal('show');
});

// var barangayCounter = false;
// var sesamanCounter = false;


$('#mainTableCcBankEncode').on('click', '#cBorrowerAddBarangay', function()
{
    $(this).attr('disabled', true);
    $('.showHideBorBarang').show();
});

$('#mainTableCcBankEncode').on('click', '#removeBarangarBor', function()
{
    $('#cBorrowerAddBarangay').attr('disabled', false);
    $('.showHideBorBarang').hide();
});

$('#mainTableCcBankEncode').on('click', '#cBorrowerAddSeamanOFW', function()
{
    $(this).attr('disabled', true);
    $('.showHideBorOFWSea').show();
});

$('#mainTableCcBankEncode').on('click', '#removeSeamanBor', function()
{
    $('#cBorrowerAddSeamanOFW').attr('disabled', false);
    $('.showHideBorOFWSea').hide();
});

$('#addComakerTable').on('click', '#cCoborrowerAddBarangay', function()
{
    $(this).attr('disabled', true);

    var id = atob($(this).attr('name'));

    $('.barShow-'+id+'').show();
});

$('#addComakerTable').on('click', '#barHideBtn', function()
{
    var id = $(this).attr('name');

    $('.cobBarangay-'+id+'').attr('disabled', false);

    $('.barShow-'+id+'').hide();
});

$('#addComakerTable').on('click', '#cCoborrowerAddSeamanOFW', function()
{
    $(this).attr('disabled', true);

    var id = atob($(this).attr('name'));

    $('.seaShow-'+id+'').show();
});

$('#addComakerTable').on('click', '#barSeaHide', function()
{
    var id = $(this).attr('name');

    $('.cobSea-'+id+'').attr('disabled', false);

    $('.seaShow-'+id+'').hide();
});

function encodedSaveLogs()
{
    $('#cc-bank-encoded-list thead th').each(function()
    {
        table_logs_cc_bank_encoded[countCCencode] = $(this).text();
        countCCencode++;
        title = $(this).text();
        $(this).html(title);
    });

    table_cc_bank_encoded_list = $('#cc-bank-encoded-list').DataTable
    ({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": 'cc-tele-cc-bank-encoded-list',
        "columns":
            [
                {data : 'id', name : 'cc_bank_tele_save.id'},
                {data : 'save_name', name : 'cc_bank_tele_save.save_name'},
                {data : 'date', name : 'cc_bank_tele_save.created_at'},
                {
                    data : function action(data)
                    {
                        return '<button class="btn btn-sm btn-block btn-info" id = "view_save_data_btn" name = "'+data.id+'"> View Data</button>' +
                            '<button class="btn btn-sm btn-block btn-danger" id = "" name = "'+data.id+'"> Delete Data</button>'
                    },
                    name : 'cc_bank_tele_save.created_at',
                    'searchable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc-bank-encoded-list_filter input').unbind();
    $('#cc-bank-encoded-list_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_cc_bank_encoded_list.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    table_cc_bank_encoded_list.search($(this).val()).draw();
                }
            }
        }
    });
}

function jsonEscape(str)  {
    return str.replace(/\n/g, "<br>").replace(/\r/g, "<br>").replace(/\t/g, "<br>");
}

$('#cc-bank-encoded-list').on('click','#view_save_data_btn', function ()
{
    var get_id = $(this).attr('name');

    $('.cc_encode_tab').each(function ()
    {
        if($(this).attr('href') == '#tab_cc_bank_1')
        {
            clearCCbankFields();

            $(this).click();

            var check_same_soi_evr = '';
            var check_same_soi_bvr = '';

            var check_same_co_maker = '';
            var check_same_check_recent = '';

            var check_same_cob_evr = '';
            var check_same_cob_bvr = '';

            var check_same_bank = '';

            var check_same_loan_existing = '';

            var trigger_cob_evr = false;
            var trigger_cob_bvr = false;
            var check_dep_exist = '';
            var check_same_dependent = '';

            arrayCom = [];

            // var counterValnewInputDep = 0;
            var counterLoobDep = 0;




            // function jsonEscape(str)  {
            //     return str.replace(/\n/g, "<br>").replace(/\r/g, "<br>").replace(/\t/g, "<br>");
            // }


            $.ajax
            ({

                url: 'cc_tele_get_save_data',
                type: 'get',
                data:
                    {
                        'id' : get_id
                    },
                // beforeSend : function ()
                // {
                //
                // },
                success : function (data)
                {
                    //
                    console.log(data)

                    var get_dancing = JSON.parse(jsonEscape(data[0][0].save_data));

                    // get_dancing = br_ing(get_dancing);

                    console.log(get_dancing);


                    //buttons
                    // for(var ctr = 0; ctr<get_dancing['data'].length; ctr++)
                    // {
                    //     if(get_dancing['data'][ctr]['id'].includes('BorSoiEVR'))
                    //     {
                    //         if(check_same_soi_evr != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             cSoiEVR =  parseInt(get_dancing['data'][ctr]['id'].split('-')[1]);
                    //             check_same_soi_evr = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#cBorrowerAddSoIEVR').click();
                    //         }
                    //
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('BorSoiBVR'))
                    //     {
                    //
                    //         if(check_same_soi_bvr != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             cSoiBVR = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]);
                    //             check_same_soi_bvr = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#cBorrowerAddSoIBVR').click();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('CoMakers'))
                    //     {
                    //         if(check_same_co_maker != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             cMc = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]);
                    //             check_same_co_maker = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#cBankAddCob').click();
                    //
                    //
                    //             if(get_dancing['data'][ctr+11]['id'].split('-')[2] == '11')
                    //             {
                    //                 // console.log(get_dancing['data'][ctr+11]['id'].split('-'));
                    //
                    //                 if(get_dancing['data'][ctr+11]['value'] != '')
                    //                 {
                    //                     // $('#cCoborrowerAddBarangay').click();
                    //                     var a11 = $('.cobBarangay-'+get_dancing['data'][ctr+11]['id'].split('-')[1]+'');
                    //
                    //                     $(a11).attr('disabled', true);
                    //
                    //                     var id11 = atob($(a11).attr('name'));
                    //
                    //                     $('.barShow-'+id11+'').show();
                    //                 }
                    //             }
                    //
                    //             if(get_dancing['data'][ctr+12]['id'].split('-')[2] == '12')
                    //             {
                    //                 // console.log(get_dancing['data'][ctr+12]['id'].split('-'));
                    //
                    //                 if(get_dancing['data'][ctr+12]['value'] != '')
                    //                 {
                    //                     // cobSea
                    //                     var a12 = $('.cobSea-'+get_dancing['data'][ctr+12]['id'].split('-')[1]+'');
                    //
                    //                     $(a12).attr('disabled', true);
                    //
                    //                     var id12 = atob($(a12).attr('name'));
                    //
                    //                     $('.seaShow-'+id12+'').show();
                    //                     // $('#cCoborrowerAddSeamanOFW').click();
                    //                 }
                    //             }
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('recAdd'))
                    //     {
                    //         if(check_same_check_recent != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             cRecent = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]);
                    //             check_same_check_recent = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#cBankAddRecentAddress').click();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('BankInfo'))
                    //     {
                    //         if(check_same_bank != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             bankInc = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]) ;
                    //             check_same_bank = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#addBankInfo').click();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('existingLoan'))
                    //     {
                    //         if(check_same_loan_existing != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             existingInc = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]) ;
                    //             check_same_loan_existing = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#addExistingLoanBtn').click();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('newDependents'))
                    //     {
                    //         if(check_dep_exist != get_dancing['data'][ctr]['id'].split('-')[1])
                    //         {
                    //             dependentCount = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]) ;
                    //             check_dep_exist = get_dancing['data'][ctr]['id'].split('-')[1];
                    //
                    //             $('#addDependents').click();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('CobSoiEVRval'))
                    //     {
                    //         if(check_same_cob_evr != get_dancing['data'][ctr]['id'].split('-')[2])
                    //         {
                    //             trigger_cob_evr = true;
                    //             check_same_cob_evr = get_dancing['data'][ctr]['id'].split('-')[2];
                    //             cobSoiEVR = get_dancing['data'][ctr]['id'].split('-')[2];
                    //             var co = get_dancing['data'][ctr]['id'].split('-')[1];
                    //             var idCom = co;
                    //
                    //             $('#containerSoiCob-'+idCom+'').show();
                    //             $('.cobStorage').show();
                    //
                    //             var indexOfCOmbo = arrayCom.indexOf(parseInt(idCom));
                    //
                    //             cobArrayContents[indexOfCOmbo][0].push(cobSoiEVR);
                    //
                    //             // console.log(cobArrayContents);
                    //
                    //             var f = '                                        <tr class = "soiCoBorEVR-'+cobSoiEVR+'">' +
                    //                 '                                              <td colspan="4">' +
                    //                 '                                                 <table class = "table-condensed check-to-cobEvr-lagay" style = "width : 100%; table-layout:fixed ;" name = "'+cobSoiEVR+'">' +
                    //                 '                                                    <tr>' +
                    //                 '                                                       <td colspan="4" style = "background-color: black; color : white;">CO-MAKER \'S SOURCE OF INCOME(EVR)' +
                    //                 '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiCoBorEVR" name = "'+cobSoiEVR+'" href = "'+idCom+'" tabIndex="-1">' +
                    //                 '                                                            <i class="fa fa-fw fa-close"></i></button>' +
                    //                 '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
                    //                 '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
                    //                 '                                                       </td> ' +
                    //                 '                                                    </tr>\n' +
                    //                 '                                                   <tr>\n' +
                    //                 '                                                       <td colspan="2" style="font-weight:bold;">Name :</td>\n' +
                    //                 '                                                       <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-6"></td>\n' +
                    //                 '                                                   </tr>\n' +
                    //                 '                                                   <tr>\n' +
                    //                 '                                                       <td colspan="2" style="font-weight:bold;">Employer\'s name :</td>\n' +
                    //                 '                                                       <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-0"></td>\n' +
                    //                 '                                                   </tr>\n' +
                    //                 '                                                   <tr>\n' +
                    //                 '                                                      <td colspan="2" style="font-weight:bold;">Position/Rank :</td>\n' +
                    //                 '                                                      <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-2"></td>\n' +
                    //                 '                                                   </tr>\n' +
                    //                 '                                                   <tr>\n' +
                    //                 '                                                     <td colspan="2" style="font-weight:bold;">Monthly Salary :</td>\n' +
                    //                 '                                                     <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-3"></td>\n' +
                    //                 '                                                   </tr>\n' +
                    //                 '                                                  <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Tenure :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-1"></td>\n' +
                    //                 '                                                 </tr>\n' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                   <td colspan="2" style="font-weight:bold;">Employer Address :</td>\n' +
                    //                 '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobEVR showPdf"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-4 " name = "'+idCom+'" href = "'+cobSoiEVR+'" num = "1" placeholder="Insert address here....."></textarea>' +
                    //                 // '                                                       <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-1" name = "hideMe"></td>\n' +
                    //                 // '                                                       <p class = "hidePdf save_dataa"  id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-1" name = "hideMe" hidden></p>' +
                    //                 '</td>\n' +
                    //                 '                                                 </tr>' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                   <td colspan="2" style="font-weight:bold;">Additional Remarks :</td>\n' +
                    //                 '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobEVR showPdf"  id="CobSoiEVRval-'+idCom+'-'+cobSoiEVR+'-5 " name = "'+idCom+'" href = "'+cobSoiEVR+'" num = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
                    //                 // '                                                   <input type = "text" class = "form-control hidePdf save_dataa" style = "display: none" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-2" name = "hideMe"></td>\n' +
                    //                 // '                                                   <p class = "hidePdf save_dataa" id = "passedFromTextAreaCobEVR-'+idCom+'-'+cobSoiEVR+'-2" name = "hideMe" hidden></p>' +
                    //                 '</td>\n' +
                    //                 '                                                </tr>' +
                    //                 '                                              </table>' +
                    //                 '                                             </td>' +
                    //                 '                                           </tr>';
                    //
                    //
                    //             $(f).hide().appendTo('#containerSoiCob-'+idCom+'').show();
                    //         }
                    //     }
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('CobSoiBVRval'))
                    //     {
                    //         if(check_same_cob_bvr != get_dancing['data'][ctr]['id'].split('-')[2])
                    //         {
                    //             trigger_cob_bvr = true;
                    //             check_same_cob_bvr = get_dancing['data'][ctr]['id'].split('-')[2];
                    //             cobSoiBVR = get_dancing['data'][ctr]['id'].split('-')[2];
                    //             var co = get_dancing['data'][ctr]['id'].split('-')[1];
                    //             var idCom = co;
                    //
                    //             $('#containerSoiCob-' + idCom + '').show();
                    //             $('.cobStorage').show();
                    //
                    //             var indexOfCOmbo = arrayCom.indexOf(parseInt(idCom));
                    //
                    //             cobArrayContents[indexOfCOmbo][1].push(cobSoiBVR);
                    //
                    //             // console.log(cobArrayContents);
                    //
                    //             var g =   '                                     <tr class = "soiCoBorBVR-'+cobSoiBVR+'">' +
                    //                 '                                             <td colspan="4">\n' +
                    //                 '                                                <table class = "table-condensed check-to-cobBvr-lagay" style = "width : 100%; table-layout:fixed ;" name = "'+cobSoiBVR+'">' +
                    //                 '                                                  <tr>' +
                    //                 '                                                    <td colspan="4" style = "background-color: black; color : white;">CO-MAKER \'S SOURCE OF INCOME(BVR)' +
                    //                 '                                                        <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md" id = "removeSoiCoBorBVR" name = "'+cobSoiBVR+'" href = "'+idCom+'" tabIndex="-1">' +
                    //                 '                                                            <i class="fa fa-fw fa-close"></i></button>' +
                    //                 '                                                        </span> <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
                    //                 '                                                                                <i class="fa fa-fw fa-minus"></i></button>' +
                    //                 '                                                       </td>\n' +
                    //                 '                                                  </tr>\n' +
                    //                 '                                                  <tr>' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Name :</td>' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-10"></td>\n' +
                    //                 '                                                  </tr>' +
                    //                 '                                                  <tr>' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Business Name :</td>' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-0"></td>\n' +
                    //                 '                                                  </tr>' +
                    //                 '                                                  <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Industry of Business :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-2"></td>\n' +
                    //                 '                                                  </tr>\n' +
                    //                 '                                                  <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Ownership :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-8"></td>\n' +
                    //                 '                                                  </tr>' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Length of Stay :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-7"></td>\n' +
                    //                 '                                                 </tr>\n' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Business Operation :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-1"></td>\n' +
                    //                 '                                                 </tr>\n' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold ;word-wrap:break-word ">Monthly Income :</td>' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-5"></td>\n' +
                    //                 '                                                 </tr>\n' +
                    //                 '                                                 <tr>\n' +
                    //                 '                                                    <td colspan="2" style="font-weight:bold;">Registration :</td>\n' +
                    //                 '                                                    <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-3"></td>\n' +
                    //                 '                                                </tr>\n' +
                    //                 // '                                                  <tr>\n' +
                    //                 // '                                                   <td colspan="2" style= "font-weight:bold;">Number of Employees :</td>\n' +
                    //                 // '                                                   <td colspan="2"><input type="text" class = "form-control save_dataa" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-4"></td>\n' +
                    //                 // '                                                 </tr>\n' +
                    //                 '                                                 <tr> \n' +
                    //                 '                                                   <td colspan="2" style="font-weight:bold;">Business address :</td>\n' +
                    //                 '                                                   <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobBVR hidePdf" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-6 "  name = "'+idCom+'" href = "'+cobSoiBVR+'" num = "1"  placeholder="Enter address here....."></textarea>' +
                    //                 // '                                                       <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-1" name = "hideMe"></td>\n' +
                    //                 // '                                                       <p class = "showPdf save_dataa" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-1" name = "hideMe" hidden></p>' +
                    //                 '</td>\n' +
                    //                 '                                                </tr>\n' +
                    //                 '                                            <tr class = "soiCoBorBVR-'+cobSoiBVR+'">\n' +
                    //                 '                                                <td colspan="2" style="font-weight:bold;">Additonal Remarks</td>\n' +
                    //                 '                                                <td colspan="2"><textarea class = "form-control save_dataa textareaToInputCobBVR hidePdf" id="CobSoiBVRval-'+idCom+'-'+cobSoiBVR+'-9 "  name = "'+idCom+'" href = "'+cobSoiBVR+'" num = "2" rows = "2" placeholder="Enter remarks here....."></textarea>' +
                    //                 // '                                                   <input type = "text" class = "form-control showPdf save_dataa" style = "display: none" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-2" name = "hideMe">' +
                    //                 // '                                                   <p class = "showPdf save_dataa" id = "passedFromTextAreaCobBVR-'+idCom+'-'+cobSoiBVR+'-2" name = "hideMe" hidden></p>' +
                    //                 '                                                   </td>\n' +
                    //                 '                                            </tr>' +
                    //                 '                                          </table>' +
                    //                 '                                        </td>' +
                    //                 '                                     </tr>';
                    //
                    //             $(g).hide().appendTo('#containerSoiCob-' + idCom + '').show();
                    //
                    //             // cobSoiBVR++;
                    //             // $('#cCoborrowerAddSoIBVR').click();
                    //         }
                    //     }
                    //
                    //
                    //
                    //     if(get_dancing['data'][ctr]['id'].includes('newInputDep'))
                    //     {
                    //         var val1 = parseInt(get_dancing['data'][ctr]['id'].split('-')[1]);
                    //         var val2 = parseInt(get_dancing['data'][ctr]['id'].split('-')[2]);
                    //         var index = arrayCom.indexOf(val1);
                    //         var countOfDepCom = parseInt(comDependensArray[index]);
                    //
                    //         var comDeps = '<span class = "pull-left deleteDepNowCom-'+val1+'-'+val2+' dependentsMinuses" style = "width : 90%">' +
                    //             '         <input type="text" class = "form-control save_dataa" id = "newInputDep-'+val1+'-'+val2+'" name = "depToPrint">' +
                    //             '      </span>' +
                    //             '      <span class = "pull-right deleteDepNowCom-'+val1+'-'+val2+' dependentsMinuses" style = "width : 10%">' +
                    //             '         <button type="button" class = "btn btn-block btn-danger btn-md deleteDependentsCOM" name = "'+val1+'" counter = "'+val2+'" style ="margin-top : 3px;" tabIndex="-1">' +
                    //             '         <i class="glyphicon glyphicon-minus" ></i></button>' +
                    //             '      </span>';
                    //
                    //         $('#COMdependentstoAdd-'+val1+'').append(comDeps);
                    //
                    //         countOfDepCom++;
                    //
                    //         comDependensArray[index] = countOfDepCom;
                    //     }
                    // }
                    //
                    // if(trigger_cob_evr)
                    // {
                    //     cobSoiEVR++;
                    // }
                    // if(trigger_cob_bvr)
                    // {
                    //     cobSoiBVR++;
                    // }
                    // setTime(function () {
                    //retrieving data

                    for(var ran = 0; ran < data[1].length; ran++)
                    {
                        var toRan = parseInt(data[1][ran].array_names);

                        $('#checkPrintCob').show();

                        $('#tdToFillCobs').show();

                        $('#tdToFillCobs').append('' +
                            '<table class = "table-condensed classToShowEye-'+toRan+'" style = "width : 100%; table-layout:fixed" id="tableCoborrower-'+toRan+'">\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="4" style = "background-color: black; color : white;"><span class="styleCObRemove" style="padding-left : 95px">CO-BORROWER\'S INFORMATION</span>\n' +
                            '                                                                            <button type="button" class = "btn btn-danger btn-md pull-right closeTableCob"  name="'+toRan+'" style="margin-left : .5%" tabIndex="-1">\n' +
                            '                                                                                <i class="fa fa-fw fa-close"></i>\n' +
                            '                                                                            </button>\n' +
                            '                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimize2Cob"  tabIndex="-1" >\n' +
                            '                                                                                <i class="fa fa-fw fa-minus"></i>\n' +
                            '                                                                            </button>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Subject\'s Name:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedSubName-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Birthdate:</td>\n' +
                            '                                                                        <td colspan="2"><input type="date" class = "form-control save_dataa" id = "cobAddedBday-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Place of Birth:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedBirthPlace-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Mother\'s Maiden Name:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedMaiden-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Civil Status:</td>\n' +
                            '                                                                        <td colspan="2">\n' +
                            '                                                                            <select id="cobAddedCivil-'+toRan+'" class = "form-control save_dataa rowHide notToPrintSelect">\n' +
                            '                                                                                <option value="-">-</option>\n' +
                            '                                                                                <option value="Single">Single</option>\n' +
                            '                                                                                <option value="Single with Live in Partner">Single with Live in Partner</option>\n' +
                            '                                                                                <option value="Single with Common Law">Single with Common Law</option>\n' +
                            '                                                                                <option value="Married">Married</option>\n' +
                            '                                                                                <option value="Married but not Legally Separated">Married but not Legally Separated</option>\n' +
                            '                                                                                <option value="Legally Separated">Legally Separated</option>\n' +
                            '                                                                                <option value="Widow">Widow</option>\n' +
                            '                                                                            </select>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">KYC: TIN#:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedTin-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">KYC: SSS#:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedSSS-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Length of Marriage:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedMarriageLength-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Dependent/s:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedDependents-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Relationship of subject to Co-maker:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedRelationSub-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S PRESENT ADDRESS\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Complete Address:</td>\n' +
                            '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa "  id = "cobAddedPresentAddress-'+toRan+'" placeholder="Insert Adress here....."  ></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Length of Stay:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthStay-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">House Ownership:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedHouseOwner-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Additional Remarks: </td>\n' +
                            '                                                                        <td colspan="2"><textarea id="cobAddedAdditionalRemarks-'+toRan+'" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                   </table>' +
                            '                                                                <table class = "table-condensed classToShowEye-'+toRan+'-cobMini" style = "width : 100%; table-layout:fixed" id="eyeShowHIde-'+toRan+'-a">' +
                            '                                                                    <tr >\n' +
                            '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S SOURCE OF INCOME (EMPLOYMENT)\n' +
                            '                                                                            <button type="button" class = "btn bg-white pull-right eyeStatusCob" tabIndex="-1" title="Click to hide in printing.">\n' +
                            '                                                                                <i class="fa fa-fw fa-eye" style="color : blue"></i>\n' +
                            '                                                                            </button>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Employers Name:</td>\n' +
                            '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa"  id = "cobAddedEmployersName-'+toRan+'" placeholder="Insert Name here....."  ></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedEmploymentAddress-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Length of Service:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthServiceEmploy-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedPositionEmploy-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>\n' +
                            '                                                                        <td colspan="2"><textarea id="cobAddedGrssEmploy-'+toRan+'" class = "form-control save_dataa" placeholder="Insert Income here......"></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>\n' +
                            '                                                                        <td colspan="2"> <textarea id="cobAddedEmployRemarks-'+toRan+'" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                     </table>' +
                            '                                                                <table class = "table-condensed classToShowEye-'+toRan+'-cobMini" style = "width : 100%; table-layout:fixed" id="eyeShowHIde-'+toRan+'-b">' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S SOURCE OF INCOME (BUSINESS)' +
                            '                                                                            <button type="button" class = "btn bg-white pull-right eyeStatusCob" name="'+toRan+'"  tabIndex="-1" >\n' +
                            '                                                                                <i class="fa fa-fw fa-eye" style="color : blue"></i>\n' +
                            '                                                                            </button>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Business Name:</td>\n' +
                            '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa borSoi hidePdf"  id = "cobAddedBusinessName-'+toRan+'" placeholder="Insert Name here....."  ></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa " id = "cobAddedBusiaddress-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Length of Operation:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthOps-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedPosBusiness-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Staffs:</td>\n' +
                            '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedBusiStaffs-'+toRan+'"></td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>\n' +
                            '                                                                        <td colspan="2"><textarea id="cobAddedGrossBusi-'+toRan+'" class = "form-control borSoi save_dataa" placeholder="Insert Income here......"></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>\n' +
                            '                                                                        <td colspan="2"> <textarea id="cobAddedBusiRemarks-'+toRan+'" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......"></textarea>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                   </table>' +
                            '                                                                <table class = "table-condensed classToShowEye-'+toRan+'-cobMini" style = "width : 100%; table-layout:fixed">' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S BANK INFORMATION\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                    <tr>\n' +
                            '                                                                        <td colspan="2" style="font-weight:bold;">Bank Name / Bank Name:</td>\n' +
                            '                                                                        <td colspan="2">\n' +
                            '                                                                            <textarea id="cobAddedBankName-'+toRan+'" class = "form-control save_dataa" placeholder="Insert bank info here......"></textarea>\n' +
                            '                                                                        </td>\n' +
                            '                                                                    </tr>\n' +
                            '                                                                </table>' +
                            '                                                                ' +
                            '');
                        randomIDsCob.push(toRan);

                        var count = 0; // check no. of table

                        $('#tdToFillCobs table').each(function()
                        {
                            count++;
                            if(count == 9)
                            {
                                $(this).addClass('newPageTrigger');
                            }
                        });

                        if(count >= 12)
                        {
                            $('#btnAddCobFinal').attr('disabled', true);
                        }
                        else if(count < 12)
                        {
                            $('#btnAddCobFinal').attr('disabled', false);
                        }


                        $('#tableCoborrower-'+toRan+'').on('click', '.minimize2Cob', function()
                        {
                            var btn = $(this);

                            var getTest = $(this).closest('table').attr('class');

                            var get2nd = getTest.split(' ');

                            if(btn.html().trim() == '<i class="fa fa-fw fa-minus"></i>')
                            {
                                var rand = Math.floor(Math.random() * 1000000000);

                                var toLoop = 'toMini' + '-' + rand;

                                btn.closest('table').addClass(toLoop);

                                var test = 0;

                                $('.'+toLoop+' tr').each(function()
                                {
                                    test++;

                                    if(test != 1)
                                    {
                                        $(this).hide()
                                    }
                                });

                                $('.'+get2nd[1]+'-cobMini').hide();

                                btn.html('<i class="fa fa-fw fa-expand"></i>')
                            }
                            else if(btn.html().trim() == '<i class="fa fa-fw fa-expand"></i>')
                            {
                                var closest = btn.closest('table').attr('class');

                                var toSplit = closest.split(' ');

                                $('.'+toSplit[2]+' tr').each(function()
                                {
                                    $(this).show()
                                });

                                var balikClass = closest.replace(' '+ toSplit[2], '');

                                $('.'+get2nd[1]+'-cobMini').show();
                                btn.closest('table').attr('class', balikClass);
                                btn.html('<i class="fa fa-fw fa-minus"></i>')
                            }

                        });

                        $('#tableCoborrower-'+toRan+'').on('click', '.closeTableCob', function()
                        {
                            var btnTableToDelete = $(this);
                            var toCompareRand = btnTableToDelete.attr('name');
                            var countInside = 0;

                            if(confirm('Are you sure to remove this fields?'))
                            {
                                var getTest = $(this).closest('table').attr('class');

                                var get2nd = getTest.split(' ');

                                $('.'+get2nd[1]+'-cobMini').remove();
                                btnTableToDelete.closest('table').remove();

                                for(var i = 0; i < randomIDsCob.length; i++)
                                {
                                    if (randomIDsCob[i] == toCompareRand)
                                    {
                                        randomIDsCob.splice(i, 1);
                                    }
                                }

                                if(randomIDsCob.length == 0)
                                {
                                    $('#checkPrintCob').hide();
                                }
                                else
                                {
                                    $('#checkPrintCob').show();
                                }

                                if(countInside >= 12)
                                {
                                    $('#btnAddCobFinal').attr('disabled', true);
                                }
                                else if(countInside < 12)
                                {
                                    $('#btnAddCobFinal').attr('disabled', false);
                                }
                                else if(countInside == 0)
                                {
                                    $('#tdToFillCobs').hide();
                                    $('#tdToFillCobs').css('display', 'none');
                                }
                            }
                            else
                            {

                            }
                        });

                        $('#eyeShowHIde-'+toRan+'-a').on('click', '.eyeStatusCob', function()
                        {
                            if($(this).html().trim() == '<i class="fa fa-fw fa-eye" style="color : blue"></i>')
                            {
                                $(this).html('<i class="fa fa-fw fa-eye-slash" style="color : red"></i>');
                                $(this).attr('title', 'Click to show in printing.');
                                $(this).closest('table').addClass('disregarPrintSOI');
                            }
                            else if($(this).html().trim() == '<i class="fa fa-fw fa-eye-slash" style="color : red"></i>')
                            {
                                $(this).html('<i class="fa fa-fw fa-eye" style="color : blue"></i>');
                                $(this).attr('title', 'Click to hide in printing.');
                                $(this).closest('table').removeClass('disregarPrintSOI');
                            }
                        });

                        $('#eyeShowHIde-'+toRan+'-b').on('click', '.eyeStatusCob', function()
                        {
                            if($(this).html().trim() == '<i class="fa fa-fw fa-eye" style="color : blue"></i>')
                            {
                                $(this).html('<i class="fa fa-fw fa-eye-slash" style="color : red"></i>');
                                $(this).attr('title', 'Click to show in printing.');
                                $(this).closest('table').addClass('disregarPrintSOI');
                            }
                            else if($(this).html().trim() == '<i class="fa fa-fw fa-eye-slash" style="color : red"></i>')
                            {
                                $(this).html('<i class="fa fa-fw fa-eye" style="color : blue"></i>');
                                $(this).attr('title', 'Click to hide in printing.');
                                $(this).closest('table').removeClass('disregarPrintSOI');
                            }
                        })
                    }

                    for(var ctr = 0; ctr<get_dancing['data'].length; ctr++)
                    {
                        $('.save_dataa').each(function ()
                        {
                            if($(this).attr('id') == get_dancing['data'][ctr]['id'])
                            {
                                if($(this).is('p'))
                                {
                                    $(this).html(get_dancing['data'][ctr]['value']);
                                }
                                else if($(this).is('textarea'))
                                {
                                    $(this).val(get_dancing['data'][ctr]['value'].replace(/<br>/g, "\n"));
                                }
                                else
                                {
                                    $(this).val(get_dancing['data'][ctr]['value']);
                                }
                            }

                        });
                    }

                    checkifYesBorPresent = false;
                    contentBorPresent = [];

                    $('.uncheckThis').attr('checked', false);

                    // },500);
                    // console.log(data[0].save_data);

                },
                complete : function()
                {
                    // for(var p = 0; p<get_incremental_soi_evr; p++)
                    // {
                    //     setTimeout(function(){
                    //         $('#removeSoiBorEVR').click();
                    //     },500);
                    //     // console.log(p);
                    // }
                    //
                    // for(var p = 0; p<get_incremental_soi_bvr; p++)
                    // {
                    //     setTimeout(function(){
                    //         $('#removeSoiBorBVR').click();
                    //     },500);
                    //     // console.log(p);
                    // }
                    //
                    // for(var p = 0; p<get_incremental_brgy; p++)
                    // {
                    //     setTimeout(function(){
                    //         $('#removeBarangarBor').click();
                    //     },500);
                    //     // console.log(p);
                    // }
                    //
                    // for(var p = 0; p<get_incremental_ofw; p++)
                    // {
                    //     setTimeout(function(){
                    //         $('#removeSeamanBor').click();
                    //     },500);
                    //     // console.log(p);
                    // }
                },
                error : function () {
                    console.log('error');
                }

            });

        }
    });

});

$('#clear_cc_bank_fields').click(function ()
{
    if(confirm('Are you sure to clear input fields'))
    {
        clearCCbankFields();



    }
});



$('#mainTableCcBankEncode').on('click', '#addBankInfo', function()
{
    var banks = '                                     <tr class = "removeBankALL-'+bankInc+'">' +
        '                                             <td colspan="4">\n' +
        '                                                <table class = "table-condensed check-to-bankInfo-lagay" style = "width : 100%; table-layout:fixed ;" name="'+bankInc+'">' +
        '                                  <tr>\n' +
        '                                                                    <td colspan="4" style = "background-color: black; color : white;">BORROWER\'S BANK INFORMATION' +
        '                                                                            <span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-danger btn-md removeBank" name = "'+bankInc+'" tabIndex="-1"><i class="fa fa-fw fa-close"></i></button></span>' +
        '                                                               <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button>'+
        '</td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Bank Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id ="BankInfo-'+bankInc+'-4"></td>\n' +
        '                                                                    </tr>\n' +
        '<tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Account Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id ="BankInfo-'+bankInc+'-0"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Bank Branch :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "BankInfo-'+bankInc+'-1"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Type of Account :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "BankInfo-'+bankInc+'-2"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Account No. :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa " id = "BankInfo-'+bankInc+'-3"></td>\n' +
        '                                                                    </tr></table></td></tr>';


    $('#showToAddBank').show();
    $('#addBankTable').append(banks);

    $('.check-to-bankInfo-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == bankInc)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();

    bankInc++;
});

$('#mainTableCcBankEncode').on('click', '#addExistingLoanBtn', function()
{
    var existLoan = '                                            <tr class = "removeExistingSpan-'+existingInc+'">\n' +
        '                                                            <td colspan="4">\n' +
        '                                                                <table class = "table-condensed check-to-existing-lagay" style = "width : 100%; table-layout:fixed " name="'+existingInc+'">\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan = "4" style = "background-color: black; color : white;">EXISTING LOAN  <span class = "pull-right rowHide"><button type="button" tabIndex="-1" class = "btn btn-block btn-danger btn-md removeExistingLoan" name = "'+existingInc+'"><i class="fa fa-fw fa-close"></i></button></span></span>' +
        '                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i></button> </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Bank Name :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "existingLoan-'+existingInc+'-0" ></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Type of Loan :</td>\n' +
        '                                                                        <td colspan="2">\n' +
        '                                                                            <select  id = "existingLoan-'+existingInc+'-1" class = "form-control save_dataa rowHide notToPrintSelect onChangetoInput">\n' +
        '                                                                                <option value="-" name = "'+existingInc+'">-</option>\n' +
        '                                                                                <option value="Auto Loan" name = "'+existingInc+'">Auto Loan</option>\n' +
        '                                                                                <option value="Personal Loan" name = "'+existingInc+'">Personal Loan</option>\n' +
        '                                                                                <option value="Housing Loan" name = "'+existingInc+'">Housing Loan</option>\n' +
        '                                                                                <option value="Small Business Loan" name = "'+existingInc+'">Small Business Loan</option>\n' +
        '                                                                                <option value="Mortgage Loan" name = "'+existingInc+'">Mortgage Loan</option>\n' +
        '                                                                            </select>\n' +
        '\n' +
        // '                                                                            <input type = "text" class = "form-control inputToPrinFromSelect save_dataa" id = "typeOfLoanExistingToPrint-'+existingInc+'" value = "-" style = "display : none" name = "'+existingInc+'">\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Loan Term :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "existingLoan-'+existingInc+'-2"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Monthly Installment Payment :</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "existingLoan-'+existingInc+'-3" ></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                </table>\n' +
        '                                                            </td>\n' +
        '                                                        </tr>';

    $('#showToExistingLoans').show();
    $('#addExistingLoan').append(existLoan);

    $('.check-to-existing-lagay tr').each(function()
    {
        var appendTest = '<input type="checkbox" checked class="pull-left select-hide-rows" title="Uncheck to hide upon printing" tabindex="-1">';

        if($(this).children('td:first-child').closest('table').attr('name') == existingInc)
        {
            $(this).children('td:first-child').prepend(appendTest);
        }
    });

    checkPrintNot();

    existingInc++;

});

$('#addExistingLoan').on('click', '.removeExistingLoan', function()
{
    var idToDelete = $(this).attr('name');
    $('.removeExistingSpan-'+idToDelete+'').remove();

    existingInc--;

    if(existingInc == 0)
    {
        $('#showToExistingLoans').hide();
    }
    else
    {
        $('#showToExistingLoans').show();
    }

    // if()
});

$('#addExistingLoan').on('click', '.minimizeCom', function()
{
    var thisBut = $(this);

    callMini(thisBut)
});


$('#addBankTable').on('click', '.removeBank', function()
{
    var idToDelete = $(this).attr('name');

    $('.removeBankALL-'+idToDelete+'').remove();

    bankInc--;

    if(bankInc == 0)
    {
        $('#showToAddBank').hide();
    }
    else
    {
        $('#showToAddBank').show();
    }
});

$('#addBankTable').on('click', '.minimizeCom', function()
{
    var thisBut = $(this);

    callMini(thisBut)
});

var contentBorrowerAllContent = [];

$('#addComakerTable').on('click', '.checktoAdd', function()
{
    var checkBool = $(this).attr('name');

    var cobVal = parseInt(checkBool);

    var index = arrayCom.indexOf(cobVal);

    var iLoop = 0;



    if(addressBool[index] == true)
    {
        $('.addressesCob-'+cobVal+'').val('');

        addressBool[index] = false
    }
    else if(addressBool[index] == false)
    {
        $('.addressBor').each(function()
        {
            if($(this).is('p') )
            {
                contentBorrowerAllContent.push($(this).html());
            }
            else if($(this).is('input') || $(this).is('textarea'))
            {
                contentBorrowerAllContent.push($(this).val());
            }
        });

        $('.addressesCob-'+cobVal+'').each(function()
        {
            if($(this).is('input') || $(this).is('textarea') )
            {
                $(this).val(contentBorrowerAllContent[iLoop]);
            }
            else if($(this).is('p'))
            {
                $(this).html(contentBorrowerAllContent[iLoop]);
            }

            iLoop++;
        });

        iLoop = 0;

        addressBool[index] = true;
    }
});

$('#typeOfLoanExisting').change(function()
{
    $('#typeOfLoanExistingToPrint').val($(this).find(':selected').val());
});


function PrintPreview()
{
    $('input').attr('value', function()
    {
        return $(this).val();
    }).css('display', 'block');

    $('select').attr('value', function()
    {
        return $(this).val();
    });

    $('textarea').html(function()
    {
        return $(this).val();

    }).css('display', 'none');

    $('input').each(function()
    {
        if($(this).attr('type') == 'date')
        {
            $(this).attr('type', 'text').attr('name', 'change');
        }
    });

    $('.save_dataa').each(function ()
    {
        var val = $(this).val();

        $(this).parent().append('<p class="p_to_remove p_to_show">'+val+'</p>');
    });

    $('.notToPrintSelect').css('display', 'none');
    // $('.inputToPrinFromSelect').css('display', 'block');
    $('.save_dataa').hide();
    $('.hidetoPDF').hide();
    $('.moveMe').css('padding-left', 0);
    $('.moveMeToPresent').css('padding-left', 0);
    $('p').show();
    $('.movetoPResentBor').css('padding-left', 0);
    $('.styleCObRemove').css('padding-left', '0px');
    $('.hideCobRow').hide();

    if(randomIDsCob.length == 0)
    {
        $('#checkPrintCob').hide();
    }

    $('.disregarPrintSOI').hide();

    var content = $('#toNewWindowPrint').html();

    $.ajax
    ({
        type : 'post',
        url : 'cc-tele-html-to-pdf',
        data :
            {
                'name' : currentAcctName,
                'file' : content
            },
        success : function(data)
        {
            $('.notToPrintSelect').css('display', 'block');
            // $('.inputToPrinFromSelect').css('display', 'none');
            $('textarea').css('display', 'block');
            $('.paddingBotAdjust').css('padding-bottom', '0px');
            $('.styleCObRemove').css('padding-left', '95px');
            $('.hideCobRow').show();


            $('input').each(function()
            {
                if($(this).attr('name') == 'change')
                {
                    $(this).attr('type', 'date').attr('name', '');
                }

                if($(this).attr('name') == 'hideMe')
                {
                    $(this).css('display', 'none');
                }
            });

            $('.hidetoPDF').show();


            window.open('cc-tele-show-pdf/'+data ,'_blank');

            setTimeout(function()
            {
                $.ajax
                ({
                    type : 'get',
                    url : 'cc-tele-delete-pdf',
                    data :
                        {
                            'name' : data
                        },
                    success : function()
                    {

                    }
                });
            },30000);

            $('.moveMe').css('padding-left', 250);
            $('.moveMePerma').css('padding-left', 179);
            $('.moveMeToPresent').css('padding-left', 134);
            $('.p_to_remove').remove();
            $('.save_dataa').show();
            $('.uncheckThis').css('display','');
            $('.paddingBotAdjust').css('padding-bottom', '0px');
            $('.movetoPResentBor').css('padding-left', 140);
            $('#testPrintBank').attr('disabled', false);
            $('#checkPrintCob').show();
            $('.disregarPrintSOI').show();
            // $('.inputToPrinFromSelect').css('display', 'none');

            // $('p').hide();
        }
    })
}


string_chop =  function(str, size)
{
    if (str == null)

        return [];
    str = String(str);
    size = ~~size;
    return size > 0 ? str.match(new RegExp('.{1,' + size + '}', 'g')) : [str];
};


// $('.borPresentAdd').keyup(function()
// {
//     var toCopy = $(this).val();
//     $("#inputborPresent").html(toCopy);
// });
// $('.borPermaAdd').keyup(function()
// {
//     var toCopy = $(this).val();
//     $("#inputborPerma").html(toCopy);
//
// });
// $('.ccBankEncodeGeneralRemarks').keyup(function()
// {
//     var toCopy = $(this).val();
//     $("#toInputccBankEncodeGeneralRemarks").html(toCopy);
// });
// $('#addSoiTableBor').on('keyup', '.textAreatoInputBorEVR' ,function()
// {
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//     var hrf = $(this).attr('href');
//
//     $('#passedFromTextAreaborEVR-'+name+'-'+hrf+'').html(toCopy);
// });
// $('#addSoiTableBor').on('keyup', '.textAreatoInputBorBVR' ,function()
// {
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//     var hrf = $(this).attr('href');
//
//     $('#passedFromTextAreaborBVR-'+name+'-'+hrf+'').html(toCopy);
// });
// $('#containerRecentAdd').on('keyup', '.textareaToInputRecent' ,function()
// {
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//
//     $('#passedFromTextAreaborRecent-'+name+'').html(toCopy);
// });
// $('#addComakerTable').on('keyup', '.textAreatoInputCob' ,function()
// {
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//     var hrf = $(this).attr('href');
//
//     $('#passedFromTextAreaCob-'+name+'-'+hrf+'').html(toCopy);
// });
// $('#addComakerTable').on('keyup', '.textareaToInputCobEVR' ,function()
// {
//
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//     var hrf = $(this).attr('href');
//     var num = $(this).attr('num');
//
//     $('#passedFromTextAreaCobEVR-'+name+'-'+hrf+'-'+num+'').html(toCopy);
// });
// $('#addComakerTable').on('keyup', '.textareaToInputCobBVR' ,function()
// {
//     var toCopy = $(this).val();
//     var name = $(this).attr('name');
//     var hrf = $(this).attr('href');
//     var num = $(this).attr('num');
//
//     $('#passedFromTextAreaCobBVR-'+name+'-'+hrf+'-'+num+'').html(toCopy);
// });

$('#addExistingLoan').on('change', '.onChangetoInput', function()
{
    var id = $(this).find(':selected').attr('name');

    $('#typeOfLoanExistingToPrint-'+id+'').val($(this).find(':selected').val());
});


$('#checktoSametoPresentBor').click(function()
{
    var countAdd = 0;

    if(checkifYesBorPresent == false)
    {
        $('.sameAsBorAddress').each(function()
        {
            if($(this).is('p') )
            {
                contentBorPresent.push($(this).html());
            }
            else if($(this).is('input') || $(this).is('textarea'))
            {
                contentBorPresent.push($(this).val());
            }

        });

        $('.sameAsBorCopyTo').each(function()
        {
            if($(this).is('input') || $(this).is('textarea') )
            {
                $(this).val(contentBorPresent[countAdd]);
            }
            else if($(this).is('p'))
            {
                $(this).html(contentBorPresent[countAdd]);
            }
            countAdd++;
        });

        checkifYesBorPresent = true;
    }
    else
    {
        $('.sameAsBorCopyTo').each(function()
        {
            if($(this).is('input') || $(this).is('textarea'))
            {
                $(this).val('');
            }
            else if($(this).is('p'))
            {
                $(this).html('');
            }
        });

        checkifYesBorPresent = false;
        contentBorPresent = [];
    }

    countAdd = 0;

});

$('#addComakerTable').on('click', '.checktoSametoPresentCOB', function()
{
    var checkBool = $(this).attr('name');

    var cobVal = parseInt(checkBool);

    var index = arrayCom.indexOf(cobVal);

    var iLoop = 0;

    if(addressBoolPresent[index] == true)
    {
        $('.presentAddressStorage-'+cobVal+'').each(function()
        {
            if($(this).is('input') || $(this).is('textarea'))
            {
                $(this).val('');
            }
            else if($(this).is('p'))
            {
                $(this).html('');
            }
        });
        presentAddressesCOB[index] = [];

        addressBoolPresent[index] = false
    }
    else if(addressBoolPresent[index] == false)
    {
        $('.presentAddressCopyMe-'+cobVal+'').each(function()
        {
            if($(this).is('p') )
            {
                presentAddressesCOB[index].push($(this).html());
            }
            else if($(this).is('input') || $(this).is('textarea'))
            {
                presentAddressesCOB[index].push($(this).val());
            }
        });
        //
        $('.presentAddressStorage-'+cobVal+'').each(function()
        {
            if($(this).is('input') || $(this).is('textarea') )
            {
                $(this).val(presentAddressesCOB[index][iLoop]);
            }
            else if($(this).is('p'))
            {
                $(this).html(presentAddressesCOB[index][iLoop]);
            }

            iLoop++;
        });

        iLoop = 0;

        addressBoolPresent[index] = true;
    }
});



$('#tele-acc-stat').change(function()
{
    if($(this).find(':selected').val() == 'Contacted')
    {
        $('#contactedSelect').show();
        $('#uncontactedSelect').hide();

    }
    else if ($(this).find(':selected').val() == 'Uncontacted')
    {
        $('#contactedSelect').hide();
        $('#uncontactedSelect').show();

    }
    else
    {
        $('#contactedSelect').hide();
        $('#uncontactedSelect').hide();
    }
});

$('#mainTableCcBankEncode').on('click', '#addDependents', function()
{
    var dep = '<span class = "pull-left deleteDepNow-'+dependentCount+' dependentsMinuses" style = "width : 90%">' +
        '         <input type="text" class = "form-control save_dataa" id = "newDependents-'+dependentCount+'" name = "depToPrint">' +
        '      </span>' +
        '      <span class = "pull-right deleteDepNow-'+dependentCount+' dependentsMinuses" style = "width : 10%">' +
        '         <button type="button" class = "btn btn-block btn-danger btn-md deleteDependents" name = "'+dependentCount+'" style ="margin-top : 3px;" tabIndex="-1">' +
        '         <i class="glyphicon glyphicon-minus" ></i></button>' +
        '      </span>';

    dependentCount++;

    $('#dependentSpan').append(dep);

});

$('#mainTableCcBankEncode').on('click', '.deleteDependents', function()
{
    var id = $(this).attr('name');

    $('.deleteDepNow-'+id+'').remove();
});

$('#addComakerTable').on('click', '.btnToAddDependents', function()
{
    var checkBool = $(this).attr('name');

    var cobVal = parseInt(checkBool);

    var index = arrayCom.indexOf(cobVal);

    var countOfDepCom = parseInt(comDependensArray[index]);

    var comDeps = '<span class = "pull-left deleteDepNowCom-'+checkBool+'-'+countOfDepCom+' dependentsMinuses" style = "width : 90%">' +
        '         <input type="text" class = "form-control save_dataa" id = "newInputDep-'+checkBool+'-'+countOfDepCom+'" name = "depToPrint">' +
        '      </span>' +
        '      <span class = "pull-right deleteDepNowCom-'+checkBool+'-'+countOfDepCom+' dependentsMinuses" style = "width : 10%">' +
        '         <button type="button" class = "btn btn-block btn-danger btn-md deleteDependentsCOM" name = "'+checkBool+'" counter = "'+countOfDepCom+'" style ="margin-top : 3px;" tabIndex="-1">' +
        '         <i class="glyphicon glyphicon-minus" ></i></button>' +
        '      </span>';

    countOfDepCom++;

    comDependensArray[index] = countOfDepCom;

    $('#COMdependentstoAdd-'+checkBool+'').append(comDeps);
});

$('#addComakerTable').on('click', '.deleteDependentsCOM', function()
{
    var checkBool = $(this).attr('name');
    var checkBool2 = $(this).attr('counter');
    var cobVal = parseInt(checkBool);

    var index = arrayCom.indexOf(cobVal);

    var countOfDepCom = parseInt(comDependensArray[index]);

    $('.deleteDepNowCom-'+checkBool+'-'+checkBool2+'').remove();

    countOfDepCom--;

    comDependensArray[index] = countOfDepCom;
});



$('.minimizeCom').click(function()
{
    var thisBut = $(this);

    callMini(thisBut)
});

function callMini(id)
{
    if(id.html().trim() == '<i class="fa fa-fw fa-minus"></i>')
    {
        minimizeFunc(id);

        id.html('<i class="fa fa-fw fa-expand"></i>')
    }
    else if(id.html().trim() == '<i class="fa fa-fw fa-expand"></i>')
    {
        var closest = id.closest('table').attr('class');

        var toSplit = closest.split(' ');

        $('.'+toSplit[2]+' tr').each(function()
        {
            $(this).show()
        });

        var balikClass = closest.replace(' '+ toSplit[2], '');

        id.closest('table').attr('class', balikClass);
        id.html('<i class="fa fa-fw fa-minus"></i>')
    }
}

function minimizeFunc(eto)
{
    var rand = Math.floor(Math.random() * 1000000000);

    var toLoop = 'toMini' + '-' + rand;

    $(eto).closest('table').addClass(toLoop);

    var test = 0;

    $('.'+toLoop+' tr').each(function()
    {
        test++;

        if(test != 1)
        {
            $(this).hide()
        }
    });
}

$('#cc_tele_accounts_table').on('click', '.btn_encode_v2', function($this)
{
    var endo_id = $this.target.id;
    $('#modal-tfs-encoding').modal('show');
    var checking = '';

    $('#cc_bank_encode_tbl button').each(function()
    {
        checking = '';

        if($(this).children('i')[0].className == 'fa fa-fw fa-minus')
        {
            $(this).unbind();
            $(this).click(function()
            {
                // if()
                checking = $(this).attr('indexer');

                $('#cc_bank_encode_tbl tr td input').each(function()
                {
                    if($(this).attr('indexer') == checking)
                    {
                        $(this).closest('tr').toggle('fast');
                    }
                });

                $('#cc_bank_encode_tbl tr td select').each(function()
                {
                    if($(this).attr('indexer') == checking)
                    {
                        $(this).closest('tr').toggle('fast');
                    }
                });

                $('#cc_bank_encode_tbl tr td textarea').each(function()
                {
                    if($(this).attr('indexer') == checking)
                    {
                        $(this).closest('tr').toggle('fast');
                    }
                });
            });
        }
    });
});

$('#submit_generate_word').click(function()
{
    var gatheredData = [];
    var type_array = [];
    var validator_str = [];
    var una = false;
    var ctr = 0;
    var tesadsd = 0;
    var ctr2 = 0;

    var c_data = '';
    c_data = '{ "encode": ';

    $('.get_dataaa').each(function()
    {
        var what = $(this).attr('indexer');
        var bawasto = ctr - 1;
        type_array[ctr] = what;

        // console.log(what == type_array[bawasto]);


        if(what == type_array[bawasto])
        {
            //input fields

            c_data += '"'+$(this).val()+'",';
            // gatheredData[tesadsd][ctr2] = $(this).val();

            // console.log([tesadsd, ctr2]);
            // ctr2++;
        }
        else
        {


            //title
            // ctr2 = 0;
            //
            if(una)
            {
                // tesadsd++;
                c_data = c_data.slice(0, -1);
                c_data += '], "'+what+'" :[';

            }
            else
            {
                c_data += '{ "'+what+'" :[';
                una = true;
            }
            gatheredData.push(what);

        }

        ctr++;
    });
    c_data = c_data.slice(0, -1);
    c_data += ']}';
    c_data += '}';
    var to_send = jsonEscape(c_data);

    $.ajax({
        type: 'post',
        url:'/word-test',
        data: {
            'to_send' : to_send,
            'titles_array' : gatheredData
        },
        success: function(data)
        {
            console.log(data);
        },
        complete: function()
        {
            $.ajax({

            });
        }
    });

    console.log(c_data);
});

$('#btnAddCobFinal').click(function()
{
    var rand = Math.floor(Math.random() * 1000000000000);
    $('#checkPrintCob').show();
    $('#tdToFillCobs').show();

    $('#tdToFillCobs').append('' +
        '<table class = "table-condensed classToShowEye-'+rand+'" style = "width : 100%; table-layout:fixed" id="tableCoborrower-'+rand+'">\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;"><span class="styleCObRemove" style="padding-left : 95px">CO-BORROWER\'S INFORMATION</span>\n' +
        '                                                                            <button type="button" class = "btn btn-danger btn-md pull-right closeTableCob"  name="'+rand+'" style="margin-left : .5%" tabIndex="-1">\n' +
        '                                                                                <i class="fa fa-fw fa-close"></i>\n' +
        '                                                                            </button>\n' +
        '                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimize2Cob"  tabIndex="-1" >\n' +
        '                                                                                <i class="fa fa-fw fa-minus"></i>\n' +
        '                                                                            </button>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Subject\'s Name:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedSubName-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Birthdate:</td>\n' +
        '                                                                        <td colspan="2"><input type="date" class = "form-control save_dataa" id = "cobAddedBday-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Place of Birth:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedBirthPlace-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Mother\'s Maiden Name:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedMaiden-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Civil Status:</td>\n' +
        '                                                                        <td colspan="2">\n' +
        '                                                                            <select id="cobAddedCivil-'+rand+'" class = "form-control save_dataa rowHide notToPrintSelect">\n' +
        '                                                                                <option value="-">-</option>\n' +
        '                                                                                <option value="Single">Single</option>\n' +
        '                                                                                <option value="Single with Live in Partner">Single with Live in Partner</option>\n' +
        '                                                                                <option value="Single with Common Law">Single with Common Law</option>\n' +
        '                                                                                <option value="Married">Married</option>\n' +
        '                                                                                <option value="Married but not Legally Separated">Married but not Legally Separated</option>\n' +
        '                                                                                <option value="Legally Separated">Legally Separated</option>\n' +
        '                                                                                <option value="Widow">Widow</option>\n' +
        '                                                                            </select>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">KYC: TIN#:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedTin-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">KYC: SSS#:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedSSS-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Length of Marriage:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedMarriageLength-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Dependent/s:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedDependents-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Relationship of subject to Co-maker:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedRelationSub-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S PRESENT ADDRESS\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Complete Address:</td>\n' +
        '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa "  id = "cobAddedPresentAddress-'+rand+'" placeholder="Insert Adress here....."  ></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Length of Stay:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthStay-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">House Ownership:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedHouseOwner-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Additional Remarks: </td>\n' +
        '                                                                        <td colspan="2"><textarea id="cobAddedAdditionalRemarks-'+rand+'" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                   </table>' +
        '                                                                <table class = "table-condensed classToShowEye-'+rand+'-cobMini" style = "width : 100%; table-layout:fixed" id="eyeShowHIde-'+rand+'-a">' +
        '                                                                    <tr >\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S SOURCE OF INCOME (EMPLOYMENT)\n' +
        '                                                                            <button type="button" class = "btn bg-white pull-right eyeStatusCob" tabIndex="-1" title="Click to hide in printing.">\n' +
        '                                                                                <i class="fa fa-fw fa-eye" style="color : blue"></i>\n' +
        '                                                                            </button>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Employers Name:</td>\n' +
        '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa"  id = "cobAddedEmployersName-'+rand+'" placeholder="Insert Name here....."  ></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedEmploymentAddress-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Length of Service:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthServiceEmploy-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedPositionEmploy-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>\n' +
        '                                                                        <td colspan="2"><textarea id="cobAddedGrssEmploy-'+rand+'" class = "form-control save_dataa" placeholder="Insert Income here......"></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>\n' +
        '                                                                        <td colspan="2"> <textarea id="cobAddedEmployRemarks-'+rand+'" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea>\n' +
        '                                                                    </tr>\n' +
        '                                                                     </table>' +
        '                                                                <table class = "table-condensed classToShowEye-'+rand+'-cobMini" style = "width : 100%; table-layout:fixed" id="eyeShowHIde-'+rand+'-b">' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S SOURCE OF INCOME (BUSINESS)' +
        '                                                                            <button type="button" class = "btn bg-white pull-right eyeStatusCob" name="'+rand+'"  tabIndex="-1" >\n' +
        '                                                                                <i class="fa fa-fw fa-eye" style="color : blue"></i>\n' +
        '                                                                            </button>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Business Name:</td>\n' +
        '                                                                        <td colspan="2" ><textarea class = "form-control save_dataa borSoi hidePdf"  id = "cobAddedBusinessName-'+rand+'" placeholder="Insert Name here....."  ></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa " id = "cobAddedBusiaddress-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Length of Operation:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedLengthOps-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedPosBusiness-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Staffs:</td>\n' +
        '                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobAddedBusiStaffs-'+rand+'"></td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>\n' +
        '                                                                        <td colspan="2"><textarea id="cobAddedGrossBusi-'+rand+'" class = "form-control borSoi save_dataa" placeholder="Insert Income here......"></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>\n' +
        '                                                                        <td colspan="2"> <textarea id="cobAddedBusiRemarks-'+rand+'" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......"></textarea>\n' +
        '                                                                    </tr>\n' +
        '                                                                   </table>' +
        '                                                                <table class = "table-condensed classToShowEye-'+rand+'-cobMini" style = "width : 100%; table-layout:fixed">' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER\'S BANK INFORMATION\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
        '                                                                    <tr>\n' +
        '                                                                        <td colspan="2" style="font-weight:bold;">Bank Name / Bank Name:</td>\n' +
        '                                                                        <td colspan="2">\n' +
        '                                                                            <textarea id="cobAddedBankName-'+rand+'" class = "form-control save_dataa" placeholder="Insert bank info here......"></textarea>\n' +
        '                                                                        </td>\n' +
        '                                                                    </tr>\n' +
               '                                                                </table>' +
               '                                                                ' +
        '');

    randomIDsCob.push(rand);

    var count = 0; // check no. of table

    $('#tdToFillCobs table').each(function()
    {
        count++
    });

    if(count >= 12)
    {
        $('#btnAddCobFinal').attr('disabled', true);
    }
    else if(count < 12)
    {
        $('#btnAddCobFinal').attr('disabled', false);
    }

    $('#tableCoborrower-'+rand+'').on('click', '.minimize2Cob', function()
    {
        var btn = $(this);

        var getTest = $(this).closest('table').attr('class');

        var get2nd = getTest.split(' ');

        console.log(get2nd[1]);

        if(btn.html().trim() == '<i class="fa fa-fw fa-minus"></i>')
        {
            var rand = Math.floor(Math.random() * 1000000000);

            var toLoop = 'toMini' + '-' + rand;

            btn.closest('table').addClass(toLoop);

            var test = 0;

            $('.'+toLoop+' tr').each(function()
            {
                test++;

                if(test != 1)
                {
                    $(this).hide()
                }
            });

            $('.'+get2nd[1]+'-cobMini').hide();

            btn.html('<i class="fa fa-fw fa-expand"></i>')
        }
        else if(btn.html().trim() == '<i class="fa fa-fw fa-expand"></i>')
        {
            var closest = btn.closest('table').attr('class');

            var toSplit = closest.split(' ');

            $('.'+toSplit[2]+' tr').each(function()
            {
                $(this).show()
            });

            var balikClass = closest.replace(' '+ toSplit[2], '');

            $('.'+get2nd[1]+'-cobMini').show();
            btn.closest('table').attr('class', balikClass);
            btn.html('<i class="fa fa-fw fa-minus"></i>')
        }


    });

    $('#tableCoborrower-'+rand+'').on('click', '.closeTableCob', function()
    {
        var btnTableToDelete = $(this);
        var toCompareRand = btnTableToDelete.attr('name');
        var countInside = 0;

        if(confirm('Are you sure to remove this fields?'))
        {
            var getTest = $(this).closest('table').attr('class');

            var get2nd = getTest.split(' ');

            $('.'+get2nd[1]+'-cobMini').remove();
            btnTableToDelete.closest('table').remove();

            for(var i = 0; i < randomIDsCob.length; i++)
            {
                if (randomIDsCob[i] == toCompareRand)
                {
                    randomIDsCob.splice(i, 1);
                }

            }

            if(randomIDsCob.length == 0)
            {
                $('#checkPrintCob').hide();
            }
            else
            {
                $('#checkPrintCob').show();
            }

            if(countInside >= 12)
            {
                $('#btnAddCobFinal').attr('disabled', true);
            }
            else if(countInside < 12)
            {
                $('#btnAddCobFinal').attr('disabled', false);
            }
            else if(countInside == 0)
            {
                $('#tdToFillCobs').hide();
                $('#tdToFillCobs').css('display', 'none');
            }
        }
        else
        {

        }
    });

    $('#eyeShowHIde-'+rand+'-a').on('click', '.eyeStatusCob', function()
    {
        if($(this).html().trim() == '<i class="fa fa-fw fa-eye" style="color : blue"></i>')
        {
            $(this).html('<i class="fa fa-fw fa-eye-slash" style="color : red"></i>');
            $(this).attr('title', 'Click to show in printing.');
            $(this).closest('table').addClass('disregarPrintSOI');
        }
        else if($(this).html().trim() == '<i class="fa fa-fw fa-eye-slash" style="color : red"></i>')
        {
            $(this).html('<i class="fa fa-fw fa-eye" style="color : blue"></i>');
            $(this).attr('title', 'Click to hide in printing.');
            $(this).closest('table').removeClass('disregarPrintSOI');
        }
    });

    $('#eyeShowHIde-'+rand+'-b').on('click', '.eyeStatusCob', function()
    {
        if($(this).html().trim() == '<i class="fa fa-fw fa-eye" style="color : blue"></i>')
        {
            $(this).html('<i class="fa fa-fw fa-eye-slash" style="color : red"></i>');
            $(this).attr('title', 'Click to show in printing.');
            $(this).closest('table').addClass('disregarPrintSOI');
        }
        else if($(this).html().trim() == '<i class="fa fa-fw fa-eye-slash" style="color : red"></i>')
        {
            $(this).html('<i class="fa fa-fw fa-eye" style="color : blue"></i>');
            $(this).attr('title', 'Click to hide in printing.');
            $(this).closest('table').removeClass('disregarPrintSOI');
        }
    })
});

$('.save_dataa').change(function()
{
    encoding_autosave_bool = true;
    var jsonHolder = '{"data": {';


    $('.save_dataa').each(function()
    {
        jsonHolder += '"'+$(this).attr('id')+'":"'+$(this).val()+'",';
    });

    jsonHolder = jsonHolder.slice(0, -1);
    jsonHolder += '}}';

    sessionStorage.setItem(sessionName, jsonEscape(jsonHolder));
});

