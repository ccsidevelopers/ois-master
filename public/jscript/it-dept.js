var tableMonit;
var check_monit_arr = [];
var c_m = 0;
var checkingStat = 'All';
var it_tabs_1 = true;
var it_tabs_2 = false;
var it_tabs_3 = false;
var submitChecks = false;
var tableArchiveUsers;
var title_to_archive = [];
var title_to_archive_count = 0;


$.ajax
({
    type : 'get',
    url : 'it-dept-get-access',
    success : function (data)
    {
        var auth = data[0].authrequest;
        var branch = data[0].branch;

        if(auth == 'Associate' || auth == '')
        {
            if(branch == 1)
            {
                $('.showManila').attr('style', '');
                $('#showManila').click();
            }
            else if(branch == 25)
            {
                $('.showCavite').attr('style', '');
                $('#showCavite').click();
            }
            else if(branch == 26)
            {
                $('.showCebu').attr('style', '');
                $('#showCebu').click();
            }
            else if(branch == 29 || branch == 30 || branch == 31)
            {
                $('.showDavao').attr('style', '');
                $('#showDavao').click();
            }

            $('.btnSubmitCheckingFields').attr('pos', 'asso')
        }
        else if(auth == 'Head')
        {
            $('.showMeall').attr('style', '');
            $('.btnSubmitCheckingFields').attr('pos', 'head');
            $('#showManila').click();
            $('#archiveHideShow').show();

            tableCiListArchive();
        }
    }
});

$('.btnSubmitCheckingFields').click(function()
{
    var btn = $(this);
    var pos = btn.attr('pos');
    var loc = btn.attr('name');

    var className = '';

    var dataSend = [];
    var ctrBrand = 0;
    var ctrInnerBrand = 0;
    var brandBool = true;
    var checkEmpty = false;

    if(loc == 'Manila')
    {
        className = 'manilaFieldsCheck';
    }
    else if(loc == 'Cavite')
    {
        className = 'caviteFieldsCheck';
    }
    else if(loc == 'Cebu')
    {
        className = 'cebuFieldsCheck';
    }
    else if(loc == 'Davao')
    {
        className = 'davaoFieldsCheck';
    }

    $('.'+className+'').each(function()
    {
        if(brandBool == false)
        {
            dataSend[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;

            if(ctrInnerBrand == 2)
            {
                ctrInnerBrand = 0;
                ctrBrand++;
                brandBool = true;
            }
        }
        else
        {
            dataSend[ctrBrand] = [];
            dataSend[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;
            brandBool = false;
        }

        if($(this).val() == '-')
        {
            checkEmpty = true;
        }
    });


     if(confirm('Are you sure to submit the checklist?'))
     {
         if (checkEmpty == true)
         {
             alert('Incomplete details.')
         }
         else
         {
             btn.attr('disabled', true);

             $.ajax
             ({
                 type : 'post',
                 url : 'it-dept-send-checklist',
                 data :
                     {
                         dataSend : dataSend,
                         'pos' : pos,
                         'loc' : loc
                     },
                 success : function()
                 {
                     $('.'+className+'').each(function()
                     {
                         if($(this).is('select'))
                         {
                             $(this).val('-');
                         }
                         else if($(this).is('textarea'))
                         {
                             $(this).val('');
                         }
                     })
                 },
                 complete : function()
                 {
                     btn.attr('disabled', false);
                     alert('Successfully submitted!')
                 },
                 error : function()
                 {
                     alert('Error in encoding. Please contact the developers.');
                 }
             });
         }
     }
     else
     {

     }
});

function tableChecklistMonitoring()
{
    $('#id_dept_checlist_monit_table thead th').each(function()
    {
        check_monit_arr[c_m] = $(this).text();
        c_m++;

    });
    tableMonit = $('#id_dept_checlist_monit_table').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Checklist Monitoring',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return check_monit_arr[(idx)];
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
                        return check_monit_arr[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,

        "ajax":
            {
                type: 'get',
                url: "/it-dept-monit-table",
                data: function (d)
                {
                    d.loc = checkingStat;
                }
            },
        "columns":
            [
                {data: 'id', name: 'it_dept_checklist.id'},
                {data: 'date_time', name: 'it_dept_checklist.created_at'},
                {data: 'loc', name: 'it_dept_checklist.location_check'},
                {data: 'name', name: 'users.name'},
                {data: 'stat', name: 'it_dept_checklist.status'},
                {
                    data : function action(data)
                    {
                        return '<button class="btn btn-md btn-info" id="btnViewInforChecklist" name="'+data.id+'" loc="'+data.loc+'" ><i class="fa fa-fw fa-info" ></i> Check/View Info</button>  '
                    },
                    name : 'it_dept_checklist.id',
                    'searchable' : false,
                    'orderable' : false
                },


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

    $('#id_dept_checlist_monit_table_filter input').unbind();
    $('#id_dept_checlist_monit_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonit.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonit.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#select_choose_branch_loc_monit').change(function()
{
    checkingStat = $(this).find(':selected').val();
    tableMonit.ajax.reload(null, false);
});

$('#id_dept_checlist_monit_table').on('click', '#btnViewInforChecklist', function()
{
    var id = $(this).attr('name');
    var loc = $(this).attr('loc');

    $.ajax
    ({
        type : 'get',
        url : 'it-dept-get-checklist-info',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            for(var i = 0; i < data[0].length; i++)
            {
                $('.showDetails'+loc+'-'+i+'').each(function()
                {
                    if($(this).attr('chk') == '0')
                    {
                        $(this).html(data[0][i][0]);
                    }
                    else if($(this).attr('chk') == '1')
                    {
                        $(this).html(data[0][i][1]);
                    }
                })
            }


            if(data[2][0].authrequest == 'Associate')
            {
                if(data[1][0].status == 'Pending')
                {
                    $('#checkIfPendingCheck').hide();
                    $('#remarks_for_checklist').val('').attr('disabled', true);
                    $('#show_rev_time_checklist').hide();
                    $('#date_time_rev_checklist').val('');
                }
                else if(data[1][0].status == 'Reviewed')
                {
                    $('#checkIfPendingCheck').hide();
                    $('#remarks_for_checklist').val(data[1][0].note_remarks).attr('disabled', true);
                    $('#show_rev_time_checklist').show();
                    $('#date_time_rev_checklist').val(data[1][0].updated_at);
                }
            }
            else if(data[2][0].authrequest == 'Head')
            {
                if(data[1][0].status == 'Pending')
                {
                    $('#checkIfPendingCheck').show();
                    $('#remarks_for_checklist').val('').attr('disabled', false);
                    $('#show_rev_time_checklist').hide();
                    $('#date_time_rev_checklist').val('');
                }
                else if(data[1][0].status == 'Reviewed')
                {
                    $('#checkIfPendingCheck').hide();
                    $('#remarks_for_checklist').val(data[1][0].note_remarks).attr('disabled', true);
                    $('#show_rev_time_checklist').show();
                    $('#date_time_rev_checklist').val(data[1][0].updated_at);
                }
            }
        }
    });

    if(loc == 'Manila')
    {
        $('#showManilaView').show();
        $('#showCaviteView').hide();
        $('#showCebuView').hide();
        $('#showDavaoView').hide();
    }
    else if(loc == 'Cavite')
    {
        $('#showManilaView').hide();
        $('#showCaviteView').show();
        $('#showCebuView').hide();
        $('#showDavaoView').hide();
    }
    else if(loc == 'Cebu')
    {
        $('#showManilaView').hide();
        $('#showCaviteView').hide();
        $('#showCebuView').show();
        $('#showDavaoView').hide();
    }
    else if(loc == 'Davao')
    {
        $('#showManilaView').hide();
        $('#showCaviteView').hide();
        $('#showCebuView').hide();
        $('#showDavaoView').show();
    }

    $('#btnSubmitNoteChecklist').attr('name', id);
    $('#modal-view-it-checlist').modal('show');
});

$('#btnSubmitNoteChecklist').click(function()
{
    var btn = $(this);
    var id = btn.attr('name');
    var rem = $('#remarks_for_checklist').val();

    btn.attr('disabled', true);

    $.ajax
    ({
        type : 'get',
        url : 'it-dept-insert-remarks-checklist',
        data :
            {
                'id' : id,
                'rem' : rem
            },
        success : function()
        {
            btn.attr('disabled', false);
            alert('Successfully submitted');
            $('#modal-view-it-checlist').modal('hide');
            tableMonit.ajax.reload(null, false);
            submitChecks = true;

        }
    });
});



tableChecklistMonitoring();

$('.it_dept_leftside_class').click(function ()
{
    var gethref = $(this).attr('href');
    console.log(gethref);

    if(gethref == '#it_dept_dashboard')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (it_tabs_1)
        {
            console.log('already loaded');

        }
        else if (it_tabs_1 == false)
        {
            it_tabs_1 = true;

        }
    }
    else if (gethref == '#it_dept_monitoring')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (it_tabs_2)
        {
            if(submitChecks ==  true)
            {
                tableMonit.ajax.reload(null, false);
                submitChecks = false;
            }
            else
            {
                console.log('already loaded');
            }
        }
        else if (it_tabs_2 == false)
        {
            it_tabs_2 = true;
   
        }
    }
    else if (gethref == '#it_dept_checklist')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (it_tabs_3)
        {
            console.log('already loaded');
        }
        else if (it_tabs_3 == false)
        {
            it_tabs_3 = true;
        }
    }
});




function tableCiListArchive()
{
    $('#it-dept-ci-archive-table thead th').each(function ()
    {
        title_to_archive[title_to_archive_count] = $(this).text();
        title_to_archive_count++;
        title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableArchiveUsers = $('#it-dept-ci-archive-table').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'CI List',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return title_to_archive[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'CI List',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return title_to_archive[(idx)];
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
                    title: 'CI List',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return title_to_archive[(idx)];
                                    }
                                }
                        }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/it_dept_archive_yes_table",
        "columns":
            [
                {data: 'id_of_users', name: 'users.id'},
                {data: 'id_emp', name: 'users.Emp_ID'},
                {data: 'users_name', name: 'users.name'},
                {data: 'users_email', name: 'users.email'},
                {data : "pro_branch", name: "provinces.name"},
                {

                    data: function actions(data)
                    {
                        if (data.archive === "False")
                        {
                            return '<button name="SetArchived" class="btn btn-success btn-sm btnArchiveIT" id="'+data.id_of_users+'" data-toggle="modal">Set as Archived</button>'
                        }
                        else
                        {
                            return '<button  name="RemoveArchived" class="btn btn-danger btn-sm btnArchiveIT"  id="'+data.id_of_users+'" data-toggle="modal">Disable Archive Mode</button>'
                        }

                    },
                    "name": 'users.archive',
                    "searchable" : false,
                    "orderable" : false
                }
            ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
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

    $('#it-dept-ci-archive-table_filter input').unbind();
    $('#it-dept-ci-archive-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableArchiveUsers.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableArchiveUsers.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#it-dept-ci-archive-table').on('click', '.btnArchiveIT', function()
{
    var id = $(this).attr('id');
    var type = $(this).attr('name');

    if(confirm('Are you sure to change?'))
    {
        $.ajax
        ({
            type : 'get',
            url : 'it_dept_change_archived',
            data :
                {
                    'id' : id,
                    'type' : type
                },
            success : function()
            {
                alert('Successfully changed status!');
                tableArchiveUsers.ajax.reload(null, false);
            }

        });
    }
    else
    {

    }




});
