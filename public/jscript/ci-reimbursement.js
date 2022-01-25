var reimbursementTable = '';
var reimbursementTableTitle = [];
var reimbursementTableTitleCtr = 0;

var reimbursementTableTab2 = '';
var reimbursementTableTitleTab2 = [];
var reimbursementTableTitleCtrTab2 = 0;

var reimbursementTableTab3 = '';
var reimbursementTableTitleTab3 = [];
var reimbursementTableTitleCtrTab3 = 0;

var reimbursement_tab_1 = true;
var reimbursement_tab_2 = false;
var reimbursement_tab_3 = false;

function reimbursement_table()
{
    $('#ci_reimbursement_glob_table_id thead th').each(function()
    {
        var title = $(this).text();
        if(title == 'ACTION')
        {

        }
        else
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
        reimbursementTableTitle[reimbursementTableTitleCtr] = title;
        reimbursementTableTitleCtr++;
    });

    reimbursementTable = $('#ci_reimbursement_glob_table_id').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':not(:last-child)',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return reimbursementTableTitle[(idx)];
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
                            return reimbursementTableTitle[(idx)];
                        }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "get_ci_reimbursement_table",
            "columns":
                [
                    {data: 'id', name: 'fund_requests_fund_to_reimburse.reimburse_id'},
                    {data: 'ci_name', name: 'users.name'},
                    {data: 'amount', name: 'fund_requests_fund_to_reimburse.id', orderable: false, searcheable: false},
                    {data: 'remarks', name: 'fund_main.dispatcher_remarks' , orderable: false, searcheable: false},
                    {data: 'created_at', name: 'fund_requests_fund_to_reimburse.created_at'},
                    {
                        data: function action (data)
                        {
                            return '<button type="button" class="btn_view_ci_liq btn btn-sm btn-primary btn-block" name="'+data.main_id+'"><i class="fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                                // '<button class="btn btn-sm btn-success btn-block approve_reimbursement" href="'+data.id+'"><i class="glyphicon glyphicon-ok"></i> Approve Request</button>' +
                                '<button class="btn btn-sm btn-success btn-block approve_disap_reimbursement" href="'+data.id+'" data-toggle="modal" data-target="#modal-view-reimburse-appro-disapp" what="Approved"><i class="glyphicon glyphicon-ok"></i> Approve Request</button>' +
                                // '<button class="btn btn-sm btn-danger btn-block disapprove_reimbursement" href="'+data.id+'"><i class="glyphicon glyphicon-remove"></i> Dissapprove Request</button>\'';
                                '<button class="btn btn-sm btn-danger btn-block approve_disap_reimbursement" href="'+data.id+'" data-toggle="modal" data-target="#modal-view-reimburse-appro-disapp" what="Disapproved"><i class="glyphicon glyphicon-remove"></i> Dissapprove Request</button>\'';
                        },
                        'name' : 'main.id',
                        searchable : false,
                        orderable : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
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

    $('#ci_reimbursement_glob_table_id_filter input').unbind();
    $('#ci_reimbursement_glob_table_id_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                reimbursementTable.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    reimbursementTable.search($(this).val()).draw();
                }
            }
        }
    });
}

function reimbursement_table_tab2()
{
    $('#ci_reimbursement_glob_table_id_approved thead th').each(function()
    {
        var title = $(this).text();
        if(title == 'ACTION')
        {

        }
        else
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
        reimbursementTableTitleTab2[reimbursementTableTitleCtrTab2] = title;
        reimbursementTableTitleCtrTab2++;
    });

    reimbursementTableTab2 = $('#ci_reimbursement_glob_table_id_approved').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':not(:last-child)',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return reimbursementTableTitleTab2[(idx)];
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
                            return reimbursementTableTitleTab2[(idx)];
                        }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "get_ci_reimbursement_table_approved",
            "columns":
                [
                    {data: 'id', name: 'fund_requests_fund_to_reimburse.reimburse_id'},
                    {data: 'ci_name', name: 'users.name'},
                    {data: 'amount', name: 'fund_requests_fund_to_reimburse.id', orderable: false, searcheable: false},
                    {data: 'remarks', name: 'fund_main.dispatcher_remarks' , orderable: false, searcheable: false},
                    {data: 'created_at', name: 'fund_requests_fund_to_reimburse.created_at'},
                    {
                        data: function action (data)
                        {
                            return '<button type="button" class="btn_view_ci_liq btn btn-sm btn-primary btn-block" name="'+data.main_id+'"><i class="fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                                '<button class="btn btn-sm btn-success btn-block" disabled  href="'+data.id+'"><i class="glyphicon glyphicon-ok"></i> Approved Request</button>' ;
                        },
                        'name' : 'main.id',
                        searchable : false,
                        orderable : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
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

    $('#ci_reimbursement_glob_table_id_approved_filter input').unbind();
    $('#ci_reimbursement_glob_table_id_approved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                reimbursementTableTab2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    reimbursementTableTab2.search($(this).val()).draw();
                }
            }
        }
    });
}

function reimbursement_table_tab3()
{
    $('#ci_reimbursement_glob_table_id_disapprove thead th').each(function()
    {
        var title = $(this).text();
        if(title == 'ACTION')
        {

        }
        else
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
        reimbursementTableTitleTab3[reimbursementTableTitleCtrTab3] = title;
        reimbursementTableTitleCtrTab3++;
    });

    reimbursementTableTab3 = $('#ci_reimbursement_glob_table_id_disapprove').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':not(:last-child)',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return reimbursementTableTitleTab3[(idx)];
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
                            return reimbursementTableTitleTab3[(idx)];
                        }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "get_ci_reimbursement_table_disapproved",
            "columns":
                [
                    {data: 'id', name: 'fund_requests_fund_to_reimburse.reimburse_id'},
                    {data: 'ci_name', name: 'users.name'},
                    {data: 'amount', name: 'fund_requests_fund_to_reimburse.id', orderable: false, searcheable: false},
                    {data: 'remarks', name: 'fund_main.dispatcher_remarks' , orderable: false, searcheable: false},
                    {data: 'created_at', name: 'fund_requests_fund_to_reimburse.created_at'},
                    {
                        data: function action (data)
                        {
                            return '<button type="button" class="btn_view_ci_liq btn btn-sm btn-primary btn-block" name="'+data.main_id+'"><i class="fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                                '<button class="btn btn-sm btn-danger btn-block" disabled href="'+data.id+'"><i class="glyphicon glyphicon-remove"></i> Disapproved Request</button>';
                        },
                        'name' : 'main.id',
                        searchable : false,
                        orderable : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
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

    $('#ci_reimbursement_glob_table_id_disapprove_filter input').unbind();
    $('#ci_reimbursement_glob_table_id_disapprove_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                reimbursementTableTab3.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    reimbursementTableTab3.search($(this).val()).draw();
                }
            }
        }
    });
}

$(document).on('click', '.ci_reimbursement_trigger', function()
{
    reimbursement_table();
});

$('#ci_reimbursement_glob_table_id').on('click', '.approve_reimbursement', function()
{
    var id = $(this).attr('href');
    var btn = $(this);

    if(confirm('Are you sure to approve this reimbursement request?'))
    {
        btn.attr('disabled', true);
        $.ajax({
            type: 'get',
            url: 'ci_reimbursement_approve_fund',
            data: {
                'fund_id' : id
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Reimbursement Successfully Approved!');
                    reimbursementTable.draw();
                    btn.attr('disabled', false);
                }
                console.log(data);
            },
            error: function()
            {
                alert('Error occured. Please contact the web developers for assistance. Thank you');
                btn.attr('disabled', false);
            }
        });
    }
});

$('#ci_reimbursement_glob_table_id').on('click', '.disapprove_reimbursement', function()
{
    var id = $(this).attr('href');

    if(confirm('Are you sure to dissapprove this reimbursement request?'))
    {
        $.ajax({
            type: 'get',
            url: 'ci_reimbursement_disapprove_fund',
            data: {
                'fund_id' : id
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Reimbursement Disapproved');
                    reimbursementTableTab3.draw();
                    btn.attr('disabled', false);
                }
                console.log(data);
            },
            error: function(e)
            {
                alert('Error occured. Please contact the web developers for assistance. Thank you');
                btn.attr('disabled', false);
            }
        });
    }
});

$('.reimbursement_tabs_class').click(function()
{
    var gethref = $(this).attr('href');


    if(gethref =='#reimbursement_tab_1')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if(reimbursement_tab_1)
        {
            console.log('already loaded');
        }
        else if(reimbursement_tab_1 == false)
        {
            reimbursement_tab_1 = true;
            reimbursement_table();
        }
    }
    else if(gethref =='#reimbursement_tab_2')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if(reimbursement_tab_2)
        {
            console.log('already loaded');
        }
        else if(reimbursement_tab_2 == false)
        {
            reimbursement_tab_2 = true;
            reimbursement_table_tab2();
        }
    }
    else if(gethref =='#reimbursement_tab_3')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if(reimbursement_tab_3)
        {
            console.log('already loaded');
        }
        else if(reimbursement_tab_3 == false)
        {
            reimbursement_tab_3 = true;
            reimbursement_table_tab3();
        }
    }

});

$('#ci_reimbursement_glob_table_id, #ci_reimbursement_glob_table_id_disapprove, #ci_reimbursement_glob_table_id_approved').on('click', '.btn_view_ci_liq', function()
{
    $('#insertCiImgLiq').html('');
    $('.clicked_modify').hide();
    $('.hidemuna').hide();
    $('#finance_ci_liq_remssss').val('');
    $('.show_modify').show();
    var fundIDliq1 = $(this).attr('name');
    // console.log(fundIDliq);

    $('#modal-view-ci-liq-img').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'finance-get-img-liq-fund',
        data :
            {
                'id'  : fundIDliq1
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

$('#ci_reimbursement_glob_table_id').on('click', '.approve_disap_reimbursement', function()
{
    $('#submit_reimbursement_remarks').attr('what', '');
    $('#submit_reimbursement_remarks').attr('href', '');
    var what_type = $(this).attr('what');
    $('#submit_reimbursement_remarks').attr('what', what_type);
    $('#submit_reimbursement_remarks').attr('href', $(this).attr('href'));
});

$('#submit_reimbursement_remarks').click(function()
{
    var id = $(this).attr('href');
    var what_type = $(this).attr('what');


    if($('#reimbursement_remarks').val() != '')
    {
        // console.log([id, what_type]);
        $('#submit_reimbursement_remarks').attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'ci_reimbursement_approve_fund',
            data: {
                'fund_id' : id,
                'what' : what_type,
                'remarks' : $('#reimbursement_remarks').val()
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Reimbursement '+what_type+'!');
                    reimbursementTable.draw();
                    $('#submit_reimbursement_remarks').attr('disabled', false);
                    $('#modal-view-reimburse-appro-disapp').modal('hide');
                    $('#reimbursement_remarks').val('')
                }
                console.log(data);
            },
            error: function()
            {
                alert('Error occured. Please contact the web developers for assistance. Thank you');
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        alert('Required field is empty fill the required field to continue');
        console.log('do nothing');
    }
});