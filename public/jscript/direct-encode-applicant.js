var maiden_trigger_gender = false;
var maiden_trigger_status = false;
var muniID;
var originalMuniID;
var muniID2;
var originalMuniID2;
var addressBool = false;
var stepCheck = 0;
var trackingBool = false;
// var table_children_data;
// var table_sibs_data;
var table_residences;
var table_work_exp;
var table_charac;
var table_orgs;
var table_trainings;
var table_creds;

// var table_children_data_view;
// var table_sibs_data_view;
var table_residences_view;
var table_work_exp_view;
var table_charac_view;
var table_orgs_view;
var table_trainings_view;
var table_creds_view;
var check_true_false_next = false;
var qualfoBool = false; //eto

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

if($('#checkIfQualfon').val() == 'yes')
{
    qualfoBool = true;
}

$(window).load(function()
{
    $('#modal-click-here').modal('show');
});

$(document).ready(function()
{
    $.ajax
    ({
        type : 'get',
        url : '../direct_applicant_get_user_list',
        data :
            {
                'id' : $('#idToSite').val()
            },
        success : function(data)
        {
            console.log(data);

            var toOption = '';

            for (var i = 0; i < data.length; i++)
            {
                toOption += '<option value="'+data[i].id+'" name="'+data[i].name+' '+data[i].loc+'">'+data[i].name+' '+data[i].loc+'</option>'
            }

            $('#locationToSendApply').html('<option value="">-</option>' + toOption);
        },
        error : function()
        {
            alert('Something went wrong.')
        }
    });



    // if(window.matchMedia("(max-width: 767px)").matches){
    //     // The viewport is less than 768 pixels wide
    //     alert("This is a mobile device.");
    // } else{
    //     // The viewport is at least 768 pixels wide
    //     alert("This is a tablet or desktop.");
    // }

    // table_children_data = $('#childrenDatatable').on("draw.dt", function ()
    // {
    //     $(this).find(".dataTables_empty").parents('tbody').empty();
    // }).
    // DataTable
    // ({
    //     responsive : true,
    //     "autoWidth": true,
    //     sDom: 'lrtip',
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bFilter": true,
    //     "bInfo": false,
    //     "bAutoWidth": true,
    //     'columnDefs': [
    //         {
    //             'targets': [0, 1, 2, 3],
    //             "searchable": false,
    //             "orderable": false,
    //             "visible": true,
    //             'render': function(data, type, row, meta)
    //             {
    //                 if(type === 'display')
    //                 {
    //                     var api = new $.fn.dataTable.Api(meta.settings);
    //
    //                     var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());
    //
    //                     var $html = $(data).wrap('<div></div>').parent();
    //
    //                     if($el.prop('tagName') === 'INPUT')
    //                     {
    //
    //                         $('input', $html).attr('value', $el.val());
    //                         if($el.prop('checked'))
    //                         {
    //                             $('input', $html).attr('checked', 'checked');
    //                         }
    //                     }
    //                     else if ($el.prop('tagName') === 'TEXTAREA')
    //                     {
    //                         $('textarea', $html).html($el.val());
    //
    //                     }
    //                     else if ($el.prop('tagName') === 'SELECT')
    //                     {
    //                         console.log('select')
    //                         $('option:selected', $html).removeAttr('selected');
    //                         $('option', $html).filter(function(){
    //                             return ($(this).attr('value') === $el.val());
    //                         }).attr('selected', 'selected');
    //                     }
    //                     else
    //                     {
    //
    //                     }
    //
    //                     data = $html.html();
    //                 }
    //
    //                 return data;
    //             }
    //         }
    //     ]
    // });
    //
    // table_sibs_data = $('#siblingsnDatatable').on("draw.dt", function ()
    // {
    //     $(this).find(".dataTables_empty").parents('tbody').empty();
    // }).
    // DataTable
    // ({
    //     responsive : true,
    //     "autoWidth": true,
    //     sDom: 'lrtip',
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bFilter": true,
    //     "bInfo": false,
    //     "bAutoWidth": true,
    //     'columnDefs': [
    //         {
    //             'targets': [0, 1, 2, 3, 4],
    //             "searchable": false,
    //             "orderable": false,
    //             "visible": true,
    //             'render': function(data, type, row, meta)
    //             {
    //                 if(type === 'display')
    //                 {
    //                     var api = new $.fn.dataTable.Api(meta.settings);
    //
    //                     var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());
    //
    //                     var $html = $(data).wrap('<div></div>').parent();
    //
    //                     if($el.prop('tagName') === 'INPUT')
    //                     {
    //                         $('input', $html).attr('value', $el.val());
    //                         if($el.prop('checked'))
    //                         {
    //                             $('input', $html).attr('checked', 'checked');
    //                         }
    //                     }
    //                     else if ($el.prop('tagName') === 'TEXTAREA')
    //                     {
    //                         $('textarea', $html).html($el.val());
    //                     }
    //                     else if ($el.prop('tagName') === 'SELECT')
    //                     {
    //                         console.log('select')
    //                         $('option:selected', $html).removeAttr('selected');
    //                         $('option', $html).filter(function(){
    //                             return ($(this).attr('value') === $el.val());
    //                         }).attr('selected', 'selected');
    //                     }
    //                     else
    //                     {
    //
    //                     }
    //
    //                     data = $html.html();
    //                 }
    //
    //                 return data;
    //             }
    //         }
    //     ]
    // });

    table_residences = $('#residencesDatatable').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {
                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());
                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    table_work_exp = $('#workExpDatatable').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {

                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());

                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    table_charac = $('#characDatatable').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3, 4, 5],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {

                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());

                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    table_orgs = $('#orgsDatatable').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {

                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());

                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    table_trainings = $('#trainingsDatatables').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {

                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());

                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    table_creds = $('#credsDatatables').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3, 4],
                "searchable": false,
                "orderable": false,
                "visible": true,
                'render': function(data, type, row, meta)
                {
                    if(type === 'display')
                    {
                        var api = new $.fn.dataTable.Api(meta.settings);

                        var $el = $('input, select, textarea, button', api.cell({ row: meta.row, column: meta.col }).node());

                        var $html = $(data).wrap('<div></div>').parent();

                        if($el.prop('tagName') === 'INPUT')
                        {

                            $('input', $html).attr('value', $el.val());
                            if($el.prop('checked'))
                            {
                                $('input', $html).attr('checked', 'checked');
                            }
                        }
                        else if ($el.prop('tagName') === 'TEXTAREA')
                        {
                            $('textarea', $html).html($el.val());

                        }
                        else if ($el.prop('tagName') === 'SELECT')
                        {
                            console.log('select')
                            $('option:selected', $html).removeAttr('selected');
                            $('option', $html).filter(function(){
                                return ($(this).attr('value') === $el.val());
                            }).attr('selected', 'selected');
                        }
                        else
                        {

                        }

                        data = $html.html();
                    }

                    return data;
                }
            }
        ]
    });

    //view


    // table_children_data_view = $('#chidrenTableView').on("draw.dt", function ()
    // {
    //     $(this).find(".dataTables_empty").parents('tbody').empty();
    // }).
    // DataTable
    // ({
    //     responsive : true,
    //     "autoWidth": true,
    //     sDom: 'lrtip',
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bFilter": true,
    //     "bInfo": false,
    //     "bAutoWidth": true,
    //     'columnDefs': [
    //         {
    //             'targets': [0, 1, 2],
    //             "searchable": false,
    //             "orderable": false,
    //             "visible": true,
    //         }
    //     ]
    // });

    // table_sibs_data_view = $('#sibsTableView').on("draw.dt", function ()
    // {
    //     $(this).find(".dataTables_empty").parents('tbody').empty();
    // }).
    // DataTable
    // ({
    //     responsive : true,
    //     "autoWidth": true,
    //     sDom: 'lrtip',
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bFilter": true,
    //     "bInfo": false,
    //     "bAutoWidth": true,
    //     'columnDefs': [
    //         {
    //             'targets': [0, 1, 2, 3],
    //             "searchable": false,
    //             "orderable": false,
    //             "visible": true,
    //         }
    //     ]
    // });

    table_residences_view = $('#residenceTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });

    table_work_exp_view = $('#workTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });

    table_charac_view = $('#charTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3, 4],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });

    table_orgs_view = $('#orgTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });

    table_trainings_view = $('#trainTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });

    table_creds_view = $('#credsTableView').on("draw.dt", function ()
    {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).
    DataTable
    ({
        responsive : true,
        "autoWidth": true,
        sDom: 'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        'columnDefs': [
            {
                'targets': [0, 1, 2, 3],
                "searchable": false,
                "orderable": false,
                "visible": true,
            }
        ]
    });


    $('#childrenDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_children_data.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#siblingsnDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_sibs_data.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#residencesDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_residences.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#workExpDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_work_exp.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#characDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_charac.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#orgsDatatable tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_orgs.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#trainingsDatatables tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_trainings.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });

    $('#credsDatatables tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = table_creds.cell({ row: rowIdx, column: colIdx }).node();
        $('input, select, textarea', cell).val($el.val());
        if($el.is(':checked')){
            $('input', cell).prop('checked', true);
        } else {
            $('input', cell).removeProp('checked');
        }
    });


    $('#smartwizard').smartWizard
    ({
        selected: 0,
        darkMode:false,
        enableURLhash: false,
        theme: 'arrows',
        autoAdjustHeight:false,
        toolbarSettings: {
            toolbarButtonPosition: 'right',
            showNextButton: false,
            showPreviousButton: false
        },
        anchorSettings: {
            anchorClickable: false
        },
        keyboardSettings: {
            keyNavigation: false,
        }
    });


    $(window).load(function()
    {

        function clearAllWizard()
        {
            $('#smartwizard').smartWizard("reset");

            $('.save_this_data').each(function()
            {
                $(this).val('');
            });

            $('#uploadedImgView').attr('src', '../user_profile_pictures/default3.jpg');
            $('.toDash').val('-');
            $('.toEnableAdd').attr('disabled', false);
            // $('.tableClearAll').html('');
            $('#if_married_check').hide();
            $('#bi_check_same_address').removeAttr('checked');
            $('.cityMuniProvClass').val('');
            $('.btnnextTab').attr('disabled', false);
            $('.btnnextTab').show();
            $('.btnpreviousTab').attr('disabled', true);
            // $('#cancelImgUploaded').val('');
            $('.acct_attached_file').val('');
            $('#divToFillAdditionalAttach').html('');
            $('#divMaritalHistoryShow').hide();
            $('.hideRedwarnings').hide();
            $('.auth_letter_change_input').val('');

            $('#showHideButtonGreenSig').show();
            $('#showInputDec1').hide();
            $('#hideShowCLoseSig1').hide();
            $('#dec1Signature').val('');
            $('#hideShowSignature').hide();
            $('.insertNameHereToPDF').html('');
            $('#inpuntWarningToPhTinPagibig').html('');
            $('.save_benefits').val('');

            // table_children_data.clear().draw();
            // table_sibs_data.clear().draw();
            table_residences.clear().draw();
            table_work_exp.clear().draw();
            table_charac.clear().draw();
            table_orgs.clear().draw();
            table_trainings.clear().draw();
            table_creds.clear().draw();

            $('#personal_email').val('');

            addressBool = false;
            stepCheck = 0;
        }

        $('.btnnextTab').click(function()
        {
            check_true_false_next = false;

            if(stepCheck == 0)
            {
                $('#inpuntWarningToPhTinPagibig').html('');
                $('.toRed').removeAttr('style');
                var arrayToRed = [];
                var checkSSRed = false;
                var checkInputRed = false;
                var checkEmailRed = false;


                if(qualfoBool == true)
                {
                    if($('#acct_tin').val() != '')
                    {
                        var tinlength = $('#acct_tin').val().length;

                        if(tinlength != 12)
                        {
                            // arrayToRed.push($('#acct_tin').attr('id'));
                            $('#inpuntWarningToPhTinPagibig').append(' <p style="color : red" >*Please enter valid TIN number</p>')
                        }
                    }

                    if($('#acct_philhealth').val() != '')
                    {
                        var phealthLength = $('#acct_philhealth').val().length;


                        if(phealthLength != 12)
                        {
                            // arrayToRed.push($('#acct_philhealth').attr('id'));
                            $('#inpuntWarningToPhTinPagibig').append(' <p style="color : red" >*Please enter valid Philhealth number</p>')
                        }
                    }

                    if($('#acct_pagibig').val() != '')
                    {
                        var pagibiglength = $('#acct_pagibig').val().length;


                        if(pagibiglength != 12)
                        {
                            // arrayToRed.push($('#acct_pagibig').attr('id'));
                            $('#inpuntWarningToPhTinPagibig').append(' <p style="color : red" >*Please enter valid Pagibig number</p>')
                        }
                    }

                    var telno = $('#acct_tel_cp').val().length;

                    if(telno != 11)
                    {
                        arrayToRed.push($('#acct_tel_cp').attr('id'));
                    }

                    console.log([telno, arrayToRed]);
                }
                else
                {
                    if($('#acct_sss').val() != '')
                    {
                        var sssLength = $('#acct_sss').val().length;


                        if(sssLength != 10)
                        {
                            arrayToRed.push($('#acct_sss').attr('id'));
                            checkSSRed = true;
                        }
                    }
                }

                $('.required_personal').each(function()
                {

                    if($(this).attr('name') == 'acct_gender')
                    {
                        if($(this).find(':selected').val() == '-')
                        {
                            arrayToRed.push($(this).attr('id'));
                            checkInputRed = true;
                        }
                    }
                    else
                    {
                        if($(this).val().length != 0)
                        {

                            if (!$(this).val().replace(/\s/g, '').length)
                            {
                                arrayToRed.push($(this).attr('id'));
                                checkInputRed = true;
                            }

                            if($(this).attr('name') == 'personal_email')
                            {
                                if( /(.+)@(.+){2,}\.(.+){2,}/.test($(this).val()) )
                                {

                                }
                                else
                                {
                                    arrayToRed.push($(this).attr('id'));
                                    checkEmailRed = true;
                                }
                            }
                        }
                        else if($(this).val().length == 0)
                        {

                            if($(this).attr('id') == 'acct_present_address_muniID' || $(this).attr('id') == 'acct_present_address_provID' ||
                                $(this).attr('id') == 'acct_perma_address_provID' || $(this).attr('id') == 'acct_perma_address_muniID')
                            {
                                arrayToRed.push($(this).attr('muniVal'));
                            }
                            else
                            {
                                arrayToRed.push($(this).attr('id'));
                            }

                            checkInputRed = true;

                        }
                    }

                });

                if(arrayToRed.length > 0)
                {
                    $('.toRed').each(function()
                    {
                        for(var i = 0; i < arrayToRed.length; i++)
                        {
                            if($(this).attr('id') == arrayToRed[i])
                            {
                                $(this).css('border-color', 'red');

                                if(arrayToRed[i] == 'acct_tel_cp')
                                {
                                    alert('Please Enter a valid 11 digit phone number');
                                }
                            }
                        }
                    });

                    if(checkInputRed == true && checkSSRed == true && checkEmailRed == true)
                    {
                        $('#redToShowNecessary').show();
                        $('#redToShowSSS').show();
                        $('#redToShowEmail').show();
                    }
                    else if(checkInputRed == false && checkSSRed == true && checkEmailRed == true)
                    {
                        $('#redToShowNecessary').hide();
                        $('#redToShowSSS').show();
                        $('#redToShowEmail').show();
                    }
                    else if(checkInputRed == true && checkSSRed == false && checkEmailRed == true)
                    {
                        $('#redToShowNecessary').show();
                        $('#redToShowSSS').hide();
                        $('#redToShowEmail').show();
                    }
                    else if(checkInputRed == true && checkSSRed == true && checkEmailRed == false)
                    {
                        $('#redToShowNecessary').show();
                        $('#redToShowSSS').show();
                        $('#redToShowEmail').hide();
                    }
                    else if(checkInputRed == true && checkSSRed == false && checkEmailRed == false)
                    {
                        $('#redToShowNecessary').show();
                        $('#redToShowSSS').hide();
                        $('#redToShowEmail').hide();
                    }
                    else if(checkInputRed == false && checkSSRed == true && checkEmailRed == false)
                    {
                        $('#redToShowNecessary').hide();
                        $('#redToShowSSS').show();
                        $('#redToShowEmail').hide();
                    }
                    else if(checkInputRed == false && checkSSRed == false && checkEmailRed == true)
                    {
                        $('#redToShowNecessary').hide();
                        $('#redToShowSSS').hide();
                        $('#redToShowEmail').show();
                    }
                    else if(checkInputRed == false && checkSSRed == false && checkEmailRed == false)
                    {
                        $('#redToShowNecessary').hide();
                        $('#redToShowSSS').hide();
                        $('#redToShowEmail').hide();
                    }

                    scrollToTop();
                }
                else if(arrayToRed.length == 0)
                {
                    $('#redToShowNecessary').hide();
                    $('#redToShowSSS').hide();
                    $('.toRed').removeAttr('style');

                    check_true_false_next = true;
                }
            }
            else if(stepCheck == 1)
            {
                check_true_false_next = true;
            }
            else if(stepCheck == 2)
            {
                var countRows = 0;
                var checkIFGo = false;
                var countInputs = false;
                var countAllInputs;

                $('#characDatatable tr').each(function ()
                {
                    countRows++
                });

                if(countRows > 1)
                {
                    countAllInputs = (countRows-1) * 4;
                }

                $('.charcCheckINput').each(function()
                {
                    if($(this).val() != '')
                    {
                        if (!$(this).val().replace(/\s/g, '').length)
                        {
                            countInputs = true;
                        }
                        else
                        {

                        }
                    }
                    else
                    {
                        countInputs = true;
                    }

                });


                if(countRows >= 6)
                {
                    if(countInputs == false)
                    {
                        check_true_false_next = true;
                    }
                    else
                    {
                        alert('Please fill up necessary fields');
                    }

                }
                else if(countRows < 6 && countRows >= 1)
                {
                    alert('Please input 5 Professional Character References');
                }

            }
            else if(stepCheck == 3)
            {
                // if(qualfoBool == true)
                // {
                //     check_true_false_next = true;
                // }
                // else
                // {
                    $('#modal_upload_sig_for_dec').modal('show');
                    $('.insertNameHereToPDF').html(($('#acct_first').val() + ' '+ $('#acct_last').val()).toUpperCase() );
                // }

            }
            else if(stepCheck == 4)
            {
                // if(qualfoBool == true)
                // {
                //
                // }
                // else
                // {

                    check_true_false_next = true;
                // }

            }

            if(check_true_false_next == true)
            {
                $('#smartwizard').smartWizard("next");
                stepCheck++;

                nextPrevCheck(qualfoBool);
            }

        });


        $('#proceedWithsignature').click(function()
        {
            var fileCheck = $('#dec1Signature').val();
            var fileValidation = $('#dec1Signature').prop('files')[0];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];


            if(fileCheck != '')
            {

                if(confirm('Are you sure to attach this signature for declaration?'))
                {
                    check_true_false_next = true;
                    $('#smartwizard').smartWizard("next");
                    stepCheck++;

                    nextPrevCheck();

                    $('#modal_upload_sig_for_dec').modal('hide');
                }

            }
            else
            {
                alert('Please select an image')
            }
        });

        $('.btnpreviousTab').click(function()
        {
            $('#smartwizard').smartWizard("prev");
            stepCheck--;

            nextPrevCheck(qualfoBool);
        });

        function nextPrevCheck(checkQualfon)
        {

            if(stepCheck > 0)
            {
                $('.btnpreviousTab').attr('disabled', false)
            }
            else if(stepCheck == 0)
            {
                $('.btnpreviousTab').attr('disabled', true)
            }

            // if(checkQualfon == true)
            // {
            //     if(stepCheck == 3)
            //     {
            //         $('.btnnextTab').attr('disabled', true);
            //     }
            //     else if(stepCheck < 3)
            //     {
            //         $('.btnnextTab').attr('disabled', false);
            //     }
            // }
            // else
            // {
                if(stepCheck == 4)
                {
                    $('.btnnextTab').attr('disabled', false);
                }
                else if(stepCheck < 4)
                {
                    $('.btnnextTab').attr('disabled', false);
                }
            // }

        }



        $('.submitAllConfirmed').click(function()
        {
            if(confirm('Are you sure to submit the application?  Make sure to review all details.'))
            {
                var submitContinue = false;

                if(qualfoBool == false)
                {
                    if($('#locationToSendApply').find(':selected').val() == '')
                    {
                        alert('Please select a location at the bottom of the confirmation of details panel.');
                    }
                    else
                    {
                        if(confirm('Are you sure to submit the application to ' +  $('#locationToSendApply').find(':selected').attr('name') + '?'))
                        {
                            submitContinue = true;
                        }

                    }
                }
                else
                {
                    submitContinue = true;
                }

                if(submitContinue == true) {
                    var arrayToSend = [];
                    var dataResident = [];
                    var ResBool = true;
                    var resCt = 0;
                    var innerResCt = 0;
                    var dataExp = [];
                    var expBool = true;
                    var expCt = 0;
                    var innerExsCt = 0;
                    var dataCharac = [];
                    var charBool = true;
                    var charCt = 0;
                    var innerCharCt = 0;
                    var dataOrg = [];
                    var orgBool = true;
                    var corgCt = 0;
                    var innerOrgCt = 0;
                    var dataTrain = [];
                    var trainBool = true;
                    var trainCt = 0;
                    var innertrainCt = 0;
                    var benefitsArray = [];

                    $('.save_this_data').each(function () {
                        var val = $(this).val();

                        arrayToSend.push(val);
                    });

                    $('.acct_residence_class').each(function () {
                        if (ResBool == false) {
                            dataResident[resCt][innerResCt] = $(this).val();
                            innerResCt++;

                            if (innerResCt == 2) {
                                innerResCt = 0;
                                resCt++;
                                ResBool = true;
                            }
                        }
                        else {
                            dataResident[resCt] = [];
                            dataResident[resCt][innerResCt] = $(this).val();
                            innerResCt++;
                            ResBool = false;
                        }
                    });

                    $('.acct_work_exp_class').each(function () {
                        if (expBool == false) {
                            dataExp[expCt][innerExsCt] = $(this).val();
                            innerExsCt++;

                            if (innerExsCt == 11) {
                                innerExsCt = 0;
                                expCt++;
                                expBool = true;
                            }
                        }
                        else {
                            dataExp[expCt] = [];
                            dataExp[expCt][innerExsCt] = $(this).val();
                            innerExsCt++;
                            expBool = false;
                        }
                    });

                    $('.acct_character_class').each(function () {
                        if (charBool == false) {
                            dataCharac[charCt][innerCharCt] = $(this).val();
                            innerCharCt++;

                            if (innerCharCt == 5) {
                                innerCharCt = 0;
                                charCt++;
                                charBool = true;
                            }
                        }
                        else {
                            dataCharac[charCt] = [];
                            dataCharac[charCt][innerCharCt] = $(this).val();
                            innerCharCt++;
                            charBool = false;
                        }
                    });

                    $('.acct_org_class').each(function () {
                        if (orgBool == false) {
                            dataOrg[corgCt][innerOrgCt] = $(this).val();
                            innerOrgCt++;

                            if (innerOrgCt == 3) {
                                innerOrgCt = 0;
                                corgCt++;
                                orgBool = true;
                            }
                        }
                        else {
                            dataOrg[corgCt] = [];
                            dataOrg[corgCt][innerOrgCt] = $(this).val();
                            innerOrgCt++;
                            orgBool = false;
                        }
                    });

                    $('.acct_training_class').each(function () {
                        if (trainBool == false) {
                            dataTrain[trainCt][innertrainCt] = $(this).val();
                            innertrainCt++;

                            if (innertrainCt == 3) {
                                innertrainCt = 0;
                                trainCt++;
                                trainBool = true;
                            }
                        }
                        else {
                            dataTrain[trainCt] = [];
                            dataTrain[trainCt][innertrainCt] = $(this).val();
                            innertrainCt++;
                            trainBool = false;
                        }
                    });

                    var count_additional_files = 0;

                    var plusArrays = [dataResident, dataExp, dataCharac, dataOrg, dataTrain];


                    var array1 = JSON.stringify(arrayToSend);
                    var array2 = JSON.stringify(plusArrays);
                    var form = new FormData;
                    var per_mail = $('#personal_email').val();

                    $('.acct_additional_files').each(function () {
                        if ($(this).val() != '') {
                            form.append('additionalfile-' + count_additional_files + '', $(this).prop('files')[0]);

                            count_additional_files++;
                        }
                    });


                    var qualCheck = '';

                    if (qualfoBool == true)
                    {

                        $('.save_benefits').each(function ()
                        {
                            var val = $(this).val();

                            benefitsArray.push(val);
                        });

                        var array3 = JSON.stringify(benefitsArray);


                        form.append('benefitsArray', array3);
                        // form.append('site_id_new', $('#idToSite').val());

                        var htmlElementsEmp = $('#auth_letter_body_employment').html();
                        var htmlAll = '';

                        if($('#auth_letter_body_school').length == 0)
                        {
                            htmlAll = htmlElementsEmp;
                        }
                        else
                        {
                            var htmlElementsSchool = $('#auth_letter_body_school').html();
                            htmlAll = htmlElementsSchool + htmlElementsEmp;

                        }


                        // qualCheck = 'no';

                        form.append('htmlElements', htmlAll);


                        qualCheck = 'yes';
                    }
                    else
                    {
                        var htmlElementsEmp = $('#auth_letter_body_employment').html();
                        var htmlAll = '';

                        if($('#auth_letter_body_school').length == 0)
                        {
                            htmlAll = htmlElementsEmp;
                        }
                        else
                        {
                            var htmlElementsSchool = $('#auth_letter_body_school').html();
                            htmlAll = htmlElementsSchool + htmlElementsEmp;

                        }


                        qualCheck = 'no';

                        form.append('htmlElements', htmlAll);
                    }

                    form.append('site_id_new', $('#idToSite').val());
                    form.append('arrayToSend', array1);
                    form.append('plusArrays', array2);
                    form.append('direct_course_taken', $('#acct_college_course').val());
                    form.append('direct_stopped_graduated_rem', $('#acct_college_graduated_stopped').val());
                    form.append('personal_email', per_mail);
                    form.append('site_id', $('#locationToSendApply').find(':selected').val());
                    form.append('file_1',$('#attach1').prop('files')[0]);
                    form.append('file_2',$('#attach2').prop('files')[0]);
                    form.append('file_3',$('#attach3').prop('files')[0]);
                    form.append('file_4',$('#attach4').prop('files')[0]);
                    form.append('count_additional_files', count_additional_files);
                    form.append('qualCheck', qualCheck);

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
                                    $('#ulPercentage_direct_en').html('');
                                    $('#ulPercentage_direct_en').show();
                                    // $('#ulPercentage').append(percentComplete*100);
                                    $('#ulPercentage_direct_en').append(Math.floor(percentComplete*100));
                                    $('#progressbar_direct_en').show();
                                    $('#progressbar_direct_en').progressbar
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
                        url : '../direct_encode_inputs',
                        contentType: false,
                        processData: false,
                        async : true,
                        data :form,
                        beforeSend : function()
                        {
                            $('#modal-review-endorse-direct').modal('hide');
                            $('#modal-loading-direct-endorse').modal({backdrop : 'static'})
                        },
                        success : function(data)
                        {
                            $('#trackDirectId').html(data)
                        },
                        error : function () {
                            alert('Oops, something went wrong. Please try again.');
                        },
                        complete : function()
                        {
                            $('#modal-loading-direct-endorse').modal('hide');
                            setTimeout(function()
                            {
                                $('#modal-success-direct').modal({backdrop : "static"});
                            },1000);
                        }
                    });
                }
                else
                {

                }


            }
            else
            {

            }
        });

        $('#btnCloseModalClear').click(function()
        {
            if(confirm('Are you sure to close? Make sure to save the Tracking No. for employment process monitoring'))
            {
                clearAllWizard();
                $('#modal-success-direct').modal('hide');
            }
            else
            {

            }
        });

        $('.submitDataInfo').click(function()
        {
            var file_count = 0;
            var citymuniArr = [];

            $('.acct_attached_file').each(function()
            {
                if($(this).val() != '')
                {
                    file_count++;
                }
            });

            var arrayToSend = [];

            // var dataChild = [];
            // var childBool = true;
            // var childCt = 0;
            // var innerCt = 0;
            //
            // var dataSibs = [];
            // var sibsBool = true;
            // var sibsCt = 0;
            // var innerSibsCt = 0;


            var dataResident= [];
            var ResBool = true;
            var resCt = 0;
            var innerResCt = 0;

            var dataExp= [];
            var expBool = true;
            var expCt = 0;
            var innerExsCt = 0;

            var dataCharac= [];
            var charBool = true;
            var charCt = 0;
            var innerCharCt = 0;

            var dataOrg = [];
            var orgBool = true;
            var corgCt = 0;
            var innerOrgCt = 0;

            var dataTrain = [];
            var trainBool = true;
            var trainCt = 0;
            var innertrainCt = 0;

            var dataCred = [];
            var credBool = true;
            var credCt = 0;
            var innercredCt = 0;
            var arrayToSendOcc = [];


            // table_children_data_view.clear();
            // table_sibs_data_view.clear();
            table_residences_view.clear();
            table_work_exp_view.clear();
            table_charac_view.clear();
            table_orgs_view.clear();
            table_trainings_view.clear();
            table_creds_view.clear();


            var personal_email = $('#personal_email').val();
            var benefitsArray = [];


            $('.save_this_data').each(function()
            {
                var val = $(this).val();

                arrayToSend.push(val);
            });

            if(qualfoBool == true)
            {
                $('.save_benefits').each(function()
                {
                    var val = $(this).val();

                    benefitsArray.push(val);
                })
            }
            // console.log(arrayToSend);


            // $('.acct_child_class').each(function()
            // {
            //     if(childBool == false)
            //     {
            //         dataChild[childCt][innerCt] = $(this).val();
            //         innerCt++;
            //
            //         if(innerCt == 3)
            //         {
            //             innerCt = 0;
            //             childCt++;
            //             childBool = true;
            //         }
            //     }
            //     else
            //     {
            //         dataChild[childCt] = [];
            //         dataChild[childCt][innerCt] = $(this).val();
            //         innerCt++;
            //         childBool = false;
            //     }
            // });
            //
            // $('.acct_siblings_class').each(function()
            // {
            //     if(sibsBool == false)
            //     {
            //         dataSibs[sibsCt][innerSibsCt] = $(this).val();
            //         innerSibsCt++;
            //
            //         if(innerSibsCt == 4)
            //         {
            //             innerSibsCt = 0;
            //             sibsCt++;
            //             sibsBool = true;
            //         }
            //     }
            //     else
            //     {
            //         dataSibs[sibsCt] = [];
            //         dataSibs[sibsCt][innerSibsCt] = $(this).val();
            //         innerSibsCt++;
            //         sibsBool = false;
            //     }
            // });


            $('.acct_residence_class').each(function()
            {
                if(ResBool == false)
                {
                    dataResident[resCt][innerResCt] = $(this).val();
                    innerResCt++;

                    if(innerResCt == 2)
                    {
                        innerResCt = 0;
                        resCt++;
                        ResBool = true;
                    }
                }
                else
                {
                    dataResident[resCt] = [];
                    dataResident[resCt][innerResCt] = $(this).val();
                    innerResCt++;
                    ResBool = false;
                }
            });




            $('.acct_work_exp_class').each(function()
            {
                if(expBool == false)
                {
                    dataExp[expCt][innerExsCt] = $(this).val();
                    innerExsCt++;

                    if(innerExsCt == 11)
                    {
                        innerExsCt = 0;
                        expCt++;
                        expBool = true;
                    }
                }
                else
                {
                    dataExp[expCt] = [];
                    dataExp[expCt][innerExsCt] = $(this).val();
                    innerExsCt++;
                    expBool = false;
                }
            });

            $('.acct_character_class').each(function()
            {
                if(charBool == false)
                {
                    dataCharac[charCt][innerCharCt] = $(this).val();
                    innerCharCt++;

                    if(innerCharCt == 5)
                    {
                        innerCharCt = 0;
                        charCt++;
                        charBool = true;
                    }
                }
                else
                {
                    dataCharac[charCt] = [];
                    dataCharac[charCt][innerCharCt] = $(this).val();
                    innerCharCt++;
                    charBool = false;
                }
            });

            $('.acct_org_class').each(function()
            {
                if(orgBool == false)
                {
                    dataOrg[corgCt][innerOrgCt] = $(this).val();
                    innerOrgCt++;

                    if(innerOrgCt == 3)
                    {
                        innerOrgCt = 0;
                        corgCt++;
                        orgBool = true;
                    }
                }
                else
                {
                    dataOrg[corgCt] = [];
                    dataOrg[corgCt][innerOrgCt] = $(this).val();
                    innerOrgCt++;
                    orgBool = false;
                }
            });

            $('.acct_training_class').each(function()
            {
                if(trainBool == false)
                {
                    dataTrain[trainCt][innertrainCt] = $(this).val();
                    innertrainCt++;

                    if(innertrainCt == 3)
                    {
                        innertrainCt = 0;
                        trainCt++;
                        trainBool = true;
                    }
                }
                else
                {
                    dataTrain[trainCt] = [];
                    dataTrain[trainCt][innertrainCt] = $(this).val();
                    innertrainCt++;
                    trainBool = false;
                }
            });

            // $('.acct_credit_class').each(function()
            // {
            //     if(credBool == false)
            //     {
            //         dataCred[credCt][innercredCt] = $(this).val();
            //         innercredCt++;
            //
            //         if(innercredCt == 4)
            //         {
            //             innercredCt = 0;
            //             credCt++;
            //             credBool = true;
            //         }
            //     }
            //     else
            //     {
            //         dataCred[credCt] = [];
            //         dataCred[credCt][innercredCt] = $(this).val();
            //         innercredCt++;
            //         credBool = false;
            //     }
            // });

            // var plusArrays = [dataChild, dataSibs, dataResident, dataExp, dataCharac,dataOrg, dataTrain, dataCred];
            var plusArrays = [dataResident, dataExp, dataCharac,dataOrg, dataTrain];

            $('.cityMuniProvClass').each(function()
            {
                citymuniArr.push($(this).val());
            });

            console.log(arrayToSend);

            if(arrayToSend[6] == 'Female' && arrayToSend[7] == 'Married')
            {
                $('.showIdMarriedFemale').show();
            }

            if(arrayToSend[7] == 'Married')
            {
                $('.showIfMarried').show();
            }

            if(qualfoBool == true)
            {

                $('.showBenefits').show();

                $('#tinView').html(benefitsArray[0]);
                $('#philhealthView').html(benefitsArray[1]);
                $('#pagibigView').html(benefitsArray[2]);

                $('.hideQualcom').hide();

            }

            $('#personal_email_view').html(personal_email);
            $('#lastnameView').html(arrayToSend[0]);
            $('#firstameView').html(arrayToSend[1]);
            $('#midnameView').html(arrayToSend[2]);
            $('#suffixnameView').html(arrayToSend[3]);
            $('#birthdateView').html(arrayToSend[4]);
            $('#ageView').html(arrayToSend[5]);
            $('#genderView').html(arrayToSend[6]);
            $('#maritalStatView').html(arrayToSend[7]);
            $('#maidenLastnameView').html(arrayToSend[8]);
            $('#maidenFirstnameView').html(arrayToSend[9]);
            $('#maidenMidnameView').html(arrayToSend[10]);
            $('#sssView').html(arrayToSend[11]);
            $('#telCpView').html(arrayToSend[12]);
            $('#presentAddressView').html(arrayToSend[15]);
            $('#permaAddressView').html(arrayToSend[18]);
            $('#spouseNameView').html(arrayToSend[19]);
            $('#spouseContactView').html(arrayToSend[20]);
            $('#FatherFullView').html(arrayToSend[21]);
            $('#FatherAgeView').html(arrayToSend[22]);
            $('#FatherOccupation').html(arrayToSend[23]);
            $('#FatherCPView').html(arrayToSend[24]);
            $('#MotherFullView').html(arrayToSend[25]);
            $('#MotherAgelView').html(arrayToSend[26]);
            $('#MotherOccupation').html(arrayToSend[27]);
            $('#MotherCPView').html(arrayToSend[28]);
            $('#secondaryNameView').html(arrayToSend[29]);
            $('#secondartLocationView').html(arrayToSend[30]);
            $('#secondaryInclusiveView').html(arrayToSend[31]);
            $('#secondaryYearGradView').html(arrayToSend[32]);
            $('#collegeNameView').html(arrayToSend[33]);
            $('#collegeLocationView').html(arrayToSend[34]);
            $('#collegeInclusiveView').html(arrayToSend[35]);
            $('#collegeYearGradView').html(arrayToSend[36]);
            $('#otherSchoolsView').html(arrayToSend[37]);
            $('#civilServiceView').html(arrayToSend[38]);
            $('#forceResignView').html(arrayToSend[39]);
            $('#forceResignReasonView').html(arrayToSend[40]);
            $('#presentCityView').html(citymuniArr[0]);
            $('#presentProvinceView').html(citymuniArr[1]);
            $('#permaCityView').html(citymuniArr[2]);
            $('#permaProvinceView').html(citymuniArr[3]);
            $('#collegeCourseTaken').html($('#acct_college_course').val());
            $('#collegeGradorStopped').html($('#acct_college_graduated_stopped').find(":selected").val());


            // if(dataChild.length > 0)
            // {
            //     var toAppend1 = '';
            //
            //     for(var a = 0; a < dataChild.length; a++)
            //     {
            //        table_children_data_view.row.add
            //         ([
            //            ''+dataChild[a][0]+'',
            //            ''+dataChild[a][1]+'',
            //            ''+dataChild[a][2]+'',
            //
            //         ]).draw(false);
            //     }
            // }
            //
            // if(dataSibs.length > 0)
            // {
            //     var toAppend2 = '';
            //
            //     for(var b = 0; b < dataSibs.length; b++)
            //     {
            //         table_sibs_data_view.row.add
            //         ([
            //             ''+dataSibs[b][0]+'',
            //             ''+dataSibs[b][1]+'',
            //             ''+dataSibs[b][2]+'',
            //             ''+dataSibs[b][3]+''
            //         ]).draw(false);
            //     }
            // }

            if(dataResident.length > 0)
            {
                var toAppend3 = '';

                for(var c = 0; c < dataResident.length; c++)
                {
                    table_residences_view.row.add
                    ([
                        ''+dataResident[c][0]+'',
                        ''+dataResident[c][1]+''

                    ]).draw(false);
                }
            }

            if(dataExp.length > 0)
            {
                var toAppend4 = '';

                for(var d = 0; d < dataExp.length; d++)
                {
                    table_work_exp_view.row.add
                    ([
                        ''+dataExp[d][0]+'',
                        ''+dataExp[d][1]+'',
                        ''+dataExp[d][2]+'',
                        ''+dataExp[d][3]+'',
                        ''+dataExp[d][4]+'',
                        ''+dataExp[d][5]+'',
                        ''+dataExp[d][6]+'',
                        ''+dataExp[d][7]+'',
                        ''+dataExp[d][8]+'',
                        ''+dataExp[d][9]+'',
                        ''+dataExp[d][10]+'',
                    ]).draw(false);
                }

            }

            if(dataCharac.length > 0)
            {
                var toAppend5 = '';

                for(var e = 0; e < dataCharac.length; e++)
                {
                    table_charac_view.row.add
                    ([
                        ''+dataCharac[e][0]+'',
                        ''+dataCharac[e][1]+'',
                        ''+dataCharac[e][2]+'',
                        ''+dataCharac[e][3]+'',
                        ''+dataCharac[e][4]+''
                    ]).draw(false);


                    toAppend5 += '<tr>' +
                        '<td colspan="1">'+dataCharac[e][0]+'</td>' +
                        '<td colspan="1">'+dataCharac[e][1]+'</td>' +
                        '<td colspan="2">'+dataCharac[e][2]+'</td>' +
                        '<td colspan="1">'+dataCharac[e][3]+'</td>' +
                        '<td colspan="1">'+dataCharac[e][4]+'</td>' +
                        '</tr>';
                }

            }

            if(dataOrg.length > 0)
            {
                var toAppend6 = '';

                for(var f = 0; f < dataOrg.length; f++)
                {
                    table_orgs_view.row.add
                    ([
                        ''+dataOrg[f][0]+'',
                        ''+dataOrg[f][1]+'',
                        ''+dataOrg[f][2]+''
                    ]).draw(false);
                }
            }

            if(dataTrain.length > 0)
            {
                var toAppend7 = '';

                for(var g = 0; g < dataTrain.length; g++)
                {
                    table_trainings_view.row.add
                    ([
                        ''+dataTrain[g][0]+'',
                        ''+dataTrain[g][1]+'',
                        ''+dataTrain[g][2]+'',

                    ]).draw(false);
                }
            }

            // if(dataCred.length > 0)
            // {
            //     var toAppend8 = '';
            //
            //     for(var h = 0; h < dataCred.length; h++)
            //     {
            //         table_creds_view.row.add
            //         ([
            //             ''+dataCred[h][0]+'',
            //             ''+dataCred[h][1]+'',
            //             ''+dataCred[h][2]+'',
            //             ''+dataCred[h][3]+'',
            //
            //         ]).draw(false);
            //     }
            // }

            $('#modal-review-endorse-direct').modal('show')
        });


    });




    var opt_year = '<option value="-">-</option>';
    for(var year = 2019; year>1900; year--)
    {
        opt_year+='<option value="'+year+'">'+year+'</option>'
    }
    $('#acct_birthdate_year').html(opt_year);

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

            $('#divMaritalHistoryShow').show();

        }
        else
        {

            $('#divMaritalHistoryShow').hide();
            $('.clearMaritalInputs').val('')
            $('#if_married_check').hide();
            $('#acct_maiden_last_name').val('');
            $('#acct_maiden_first_name').val('');
            $('#acct_maiden_middle_name').val('');
            maiden_trigger_status = false;
        }
    });

    function calculate_age(date)
    {
        var diff_ms = Date.now() - date.getTime();
        var age_dt = new Date(diff_ms);

        return Math.abs(age_dt.getUTCFullYear() - 1970);
    }

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

    $('#acct_present_muni').focusout(function ()
    {
        if($(this).val() === '')
        {
            $('#acct_present_province').val('');
            $('#acct_present_address_muniID').val('');
            $('#acct_present_address_provID').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#acct_present_muni').val()
                    },
                success: function (data)
                {
                    console.log(data[0].id);
                    $('#acct_present_address_provID').val(data[0].province_id);
                    $('#acct_present_address_muniID').val(data[0].id);
                    fetchProv();

                    setTimeout(function ()
                    {
                        $('#acct_present_muni').val(data[0].muni_name);
                    },1000);
                }
            });
        }
    });

    $('#acct_present_muni').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('acct_present_address_provID').val('');
            $('acct_present_address_muniID').val('');
            $('#acct_present_address_provID').val(ui.item.muniID);
            $('#acct_present_address_muniID').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv();
                clearInterval(clearTime);
            },10)
        }

    });
    function fetchProv()
    {
        muniID = $('#acct_present_address_provID').val();
        originalMuniID = $('#acct_present_address_muniID').val();
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
                $('#loading_present_Prov').append('<img src= "../dist/img/loading.gif" width="3%">');
            },
            success: function (data)
            {
                $('#loading_present_Prov').html('');
                $('#acct_present_province').val('');
                $('#acct_present_province').val(data[0][0].name);
            }
        });
    }

    $('#acct_perma_muni').focusout(function ()
    {
        if($(this).val() === '')
        {
            $('#acct_perma_province').val('');
            $('#acct_perma_address_provID').val('');
            $('#acct_perma_address_muniID').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#acct_perma_muni').val()
                    },
                success: function (data)
                {
                    console.log(data[0].id);
                    $('#acct_perma_address_provID').val(data[0].province_id);
                    $('#acct_perma_address_muniID').val(data[0].id);
                    fetchProv2();

                    setTimeout(function ()
                    {
                        $('#acct_perma_muni').val(data[0].muni_name);
                    },1000);
                }
            });
        }
    });

    $('#acct_perma_muni').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('acct_perma_address_provID').val('');
            $('acct_perma_address_muniID').val('');
            $('#acct_perma_address_provID').val(ui.item.muniID);
            $('#acct_perma_address_muniID').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv2();
                clearInterval(clearTime);
            },10)
        }

    });
    function fetchProv2()
    {
        muniID2 = $('#acct_perma_address_provID').val();
        originalMuniID2 = $('#acct_perma_address_muniID').val();
        $.ajax
        ({
            method: 'get',
            url: 'fetch-prov',
            data:
                {
                    'muniID': muniID2,
                    'originalMuniID': originalMuniID2
                },
            beforeSend: function ()
            {
                $('#loading_permanent_Prov').append('<img src= "../dist/img/loading.gif" width="3%">');
            },
            success: function (data)
            {
                $('#loading_permanent_Prov').html('');
                $('#acct_perma_province').val('');
                $('#acct_perma_province').val(data[0][0].name);
            }
        });
    }



    $('#btnAddAcctChildren').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd = table_children_data.row.add
        ([
            '<input type="text" class="acct_child_class" >',
            '<input type="date" class="acct_child_class">',
            '<input type="text" class="acct_child_class"  name="children" >',
            '<button class="btn btn-xs btn-block btn-danger btndeleteChildren" name="'+rand+'"><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'childrenTab-' + rand);
    });

    $('#childrenDatatable tbody').on( 'click', '.btndeleteChildren', function ()
    {
        var name = $(this).attr('name');
        table_children_data.row( $('#childrenTab-'+name+'') ).remove().draw();
    });

    $('#btnAddSiblings').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd = table_sibs_data.row.add
        ([
            '<input type="text" class="acct_siblings_class">',
            '<input type="number" class="acct_siblings_class">',
            '<textarea class="acct_siblings_class" rows="1"></textarea>',
            '<textarea class="acct_siblings_class" rows="1"></textarea>',
            '<button class="btn btn-xs btn-block btn-danger btndeleteSiblings" name="'+rand+'" ><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'siblingTab-' + rand);
    });

    $('#siblingsnDatatable tbody').on( 'click', '.btndeleteSiblings', function ()
    {
        var name = $(this).attr('name');
        table_sibs_data.row( $('#siblingTab-'+name+'') ).remove().draw();
    });

    $('#btnAddResidences').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_residences.row.add
        ([
            '<input type="text" class="acct_residence_class">',
            '<textarea class="acct_residence_class" rows="3" cols=30></textarea>',
            '<button class="btn btn-xs btn-danger btn-block btndeleteResidence" name="'+rand+'"><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'resTab-' + rand);
    });

    $('#residencesDatatable tbody').on( 'click', '.btndeleteResidence', function ()
    {
        var name = $(this).attr('name');
        table_residences.row( $('#resTab-'+name+'') ).remove().draw();
    });



    $('#btnAddWorkExp').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_work_exp.row.add
        ([
            '<input type="date" class="acct_work_exp_class">',
            '<input type="date" class="acct_work_exp_class" id="workExp-'+rand+'">',
            '<select id="" class="toPresentWorkExp acct_work_exp_class"><option value="-" name="'+rand+'">-</option><option value="Present" name="'+rand+'">Present</option></select>',
            '<input type="text" class="acct_work_exp_class">',
            '<input type="text" class="acct_work_exp_class">',
            '<input type="text" class="acct_work_exp_class">',
            '<textarea class="acct_work_exp_class" rows="3"></textarea>',
            '<input type="text" class="acct_work_exp_class">',
            '<input type="text" class="acct_work_exp_class">',
            '<input type="text" class="acct_work_exp_class">',
            '<textarea class="acct_work_exp_class" rows="3" ></textarea>',
            '<button class="btn btn-xs btn-danger btn-block btndeleteWork" name="'+rand+'"><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'workexpTab-' + rand);
    });

    $('#workExpDatatable tbody').on( 'click', '.btndeleteWork', function ()
    {
        var name = $(this).attr('name');
        table_work_exp.row( $('#workexpTab-'+name+'') ).remove().draw();
    });

    $('#workExpDatatable tbody').on( 'click', '.toPresentWorkExp', function ()
    {
        var selThis = $(this).find(':selected');
        var id = selThis.attr('name');

        if(selThis.val() == 'Present')
        {
            $('#workExp-'+id+'').val('').attr('disabled', true);
        }
        else if(selThis.val() == '-')
        {
            $('#workExp-'+id+'').attr('disabled', false);
        }
    });

    $('#btnAddCharacter').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_charac.row.add
        ([
            '<input type="text" class="acct_character_class charcCheckINput" >',
            '<input type="text" class="acct_character_class charcCheckINput" >',
            '<textarea class="acct_character_class charcCheckINput" rows="3" > </textarea>',
            '<input type="text" class="acct_character_class" >',
            '<input type="number" class="acct_character_class charcCheckINput" >',
            '<button class="btn btn-xs btn-danger btn-block btndeleteCharacter" name="'+rand+'"><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'characTab-' + rand);
    });

    $('#characDatatable tbody').on( 'click', '.btndeleteCharacter', function ()
    {
        var name = $(this).attr('name');
        table_charac.row( $('#characTab-'+name+'') ).remove().draw();
    });

    $('#btnAddOrg').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_orgs.row.add
        ([
            '<input type="text" class="acct_org_class">',
            '<input type="date" class="acct_org_class">',
            '<textarea class="acct_org_class" rows="1" >',
            '<button class="btn btn-xs btn-danger btn-block btndeleteOrg" name="'+rand+'"><i class="fa fa-close"></i></button>'

        ]).draw(false).node();

        $(rowsAdd).attr("id", 'orgsTaab-' + rand);
    });

    $('#orgsDatatable tbody').on( 'click', '.btndeleteOrg', function ()
    {
        var name = $(this).attr('name');
        table_orgs.row( $('#orgsTaab-'+name+'') ).remove().draw();
    });


    $('#btnAddTraining').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_trainings.row.add
        ([
            '<input type="text" class="acct_training_class">',
            '<input type="text" class="acct_training_class">',
            '<input type="text" class="acct_training_class">',
            '<button class="btn btn-xs btn-danger btn-block btndeleteTraining" name="'+rand+'"><i class="fa fa-close"></i></button>'


        ]).draw(false).node();

        $(rowsAdd).attr("id", 'trainsTaab-' + rand);
    });

    $('#trainingsDatatables tbody').on( 'click', '.btndeleteTraining', function ()
    {
        var name = $(this).attr('name');
        table_trainings.row( $('#trainsTaab-'+name+'') ).remove().draw();
    });
//yow

    $('#btnAddCredit').on('click', function ()
    {
        var rand = Math.floor(Math.random() * 1000000000000);

        var rowsAdd =  table_creds.row.add
        ([
            '<input type="text" class="acct_credit_class" >',
            '<input type="text" class="acct_credit_class" >',
            '<input type="text" class="acct_credit_class" >',
            '<input type="text" class="acct_credit_class" >',
            '<button class="btn btn-xs btn-danger btn-block btndeleteCredit" name="'+rand+'"><i class="fa fa-close"></i></button>'
        ]).draw(false).node();

        $(rowsAdd).attr("id", 'credsTab-' + rand);
    });

    $('#credsDatatables tbody').on( 'click', '.btndeleteCredit', function ()
    {
        var name = $(this).attr('name');
        table_creds.row( $('#credsTab-'+name+'') ).remove().draw();
    });




    $('#bi_check_same_address').click(function()
    {
        if(addressBool == false)
        {
            console.log('yes');

            $('.toDisable').attr('disabled', true).val('');
            $('.toClear').val('');

            $('#acct_perma_address').val($('#acct_present_address').val());
            $('#acct_perma_muni').val($('#acct_present_muni').val());
            $('#acct_perma_province').val($('#acct_present_province').val())


            $('#acct_perma_address_provID').val($('#acct_present_address_provID').val());
            $('#acct_perma_address_muniID').val($('#acct_present_address_muniID').val());


            addressBool = true;
        }
        else
        {
            $('.toDisable').attr('disabled', false).val('');
            $('.toClear').val('');

            $('#acct_perma_address').val('');
            $('#acct_perma_muni').val('')
            $('#acct_perma_address_provID').val('');
            $('#acct_perma_address_muniID').val('');
            $('#acct_perma_province').val('');
            addressBool = false;
            console.log('no');
        }
    });

    $('#cancelImgUploaded').change(function()
    {
        readURL(this);
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#uploadedImgView').attr('src', e.target.result);
                // $('#uploadedImgModalView').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#cancelImgUploaded').val('');
            $('#uploadedImgView').attr('src', '../user_profile_pictures/default3.jpg');
            // $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
        }
    }

    $('#cancelImg').click(function()
    {
        $('#cancelImgUploaded').val('');
        $('#uploadedImgView').attr('src', '../user_profile_pictures/default3.jpg');
        // $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
    });


// $('#modal-review-endorse-direct').modal('show')

    $('#btnSearchTrackNow').click(function()
    {
        trackingBool = true;

        var btn = $(this);

        btn.attr('disabled', true);

        $.ajax
        ({
            type : 'get',
            url : '../direct_applicant_search_application_tracking',
            data :
                {
                    'track_id' : $('#trackIdInfo').val()
                },
            success : function(data)
            {
                console.log(data);
                if(data == '')
                {
                    alert('No result found');
                    btn.attr('disabled', false);
                }
                else
                {
                    var muni_province = (data[0].muni).split(' - ');

                    $('#direct_status_view').html((data[0].status).toUpperCase());
                    $('#direct_name').html((data[0].lname + ', ' + data[0].fname + ' ' + data[0].mname + ' ' + data[0].sname).toUpperCase());
                    $('#direct_address').html((data[0].address));
                    $('#direct_muni').html(muni_province[0]);
                    $('#direct_province').html(muni_province[1]);
                    $('#tr_id_view').html($('#trackIdInfo').val())

                    btn.attr('disabled', false);

                    $('.showThisFalseBoolTrack').hide();
                    $('.showThisTrueBoolTrack').show();

                    if(data[0].status == 'Returned')
                    {
                        $('.update_info_class').show();
                        $('#ff_upload').attr('name', btoa(data[0].id));
                        $('#ff_upload').attr('href', btoa(data[0].site_id));

                        $.each(data[0], function(objKey, dataChunks)
                        {
                            $('.return_validation_clear[name='+objKey+']').val(dataChunks);
                        });
                    }
                    else
                    {
                        $('.update_info_class').hide();
                    }
                }

            }

        });
    });

    $('#btnsearchNewTrack').click(function()
    {
        trackingBool = false;

        $('.classViewTransac').html('');
        $('.ff_file').val('');

        $('.showThisTrueBoolTrack').hide();
        $('.update_info_class').hide();
        $('.showThisFalseBoolTrack').show();
    });

    $('#seeOnlineAppModal').click(function()
    {
        if(trackingBool == false)
        {
            $('.showThisFalseBoolTrack').show();
            $('.showThisTrueBoolTrack').hide();
        }
        else
        {
            $('.showThisFalseBoolTrack').hide();
            $('.showThisTrueBoolTrack').show();
        }

        $('#modal-see-online-transaction').modal('show');
    });


    $('#acct_birthdate_full').change(function()
    {
        var diff_ms = Date.now() - (new Date($(this).val())).getTime();
        var age_dt = new Date(diff_ms);

        console.log('test')

        $('#acct_age').val(Math.abs(age_dt.getUTCFullYear() - 1970))
    });

    function scrollToTop()
    {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }

    $('#clicktoAddAdditionalAttach').click(function()
    {
        $('#divToFillAdditionalAttach').append
        (
            ' <div class="form-group col-md-6" >\n' +
            '                                                                <label>Additional Attachment: <button class="btn btn-danger btn-xs btnDeleteAdditional" ><i class="fa fa-close"></i></button></label>\n' +
            '                                                                <input class="acct_additional_files" type="file" id="">\n' +
            '                                                            </div>'
        );

        $('.btnDeleteAdditional').click(function()
        {
            $(this).closest('div').remove();
        });




    });

});

$('#check_agreement').change(function()
{
    if($(this).is(':checked'))
    {
        $('#btn-agree').attr('disabled', false);
    }
    else
    {
        $('#btn-agree').attr('disabled', true);
    }
});

$('#btn-agree').click(function()
{
    if(!$('#check_agreement').is(':checked'))
    {
        alert('You need to accept the terms showed in agreement to continue.');
    }
    else
    {
        $('#modal-click-here').hide();
        $('.modal-backdrop').remove();
        $('.skin-red').removeClass('modal-open');
    }
});

$('#ff_upload').click(function()
{
    var FileData = new FormData();
    var btn = $(this);
    var to_go = false;
    var fileCounter = 0;
    $('.ff_file').each(function()
    {
        if($(this).val() != '')
        {
            FileData.append('file_'+ $(this).attr('name'), $(this).prop('files')[0]);
            fileCounter++;
        }
        else
        {
            FileData.append('file_'+ $(this).attr('name'), null);
        }
    });

    $('.return_validation_clear').each(function()
    {
        if($(this).val() != '' )
        {
            to_go = true;
        }
        else
        {
            to_go = false;
            alert('Fill-up the required fields. Thank you');
            return false
        }
    });

    FileData.append('bi_direct_id', atob($(this).attr('name')));
    FileData.append('site_id', atob($(this).attr('href')));
    FileData.append('direct_secondary_school', $('#direct_secondary_school').val());
    FileData.append('direct_secondary_location', $('#direct_secondary_location').val());
    FileData.append('direct_secondary_inclusive', $('#direct_secondary_inclusive').val());
    FileData.append('direct_secondary_year_graduated', $('#direct_secondary_year_graduated').val());
    FileData.append('direct_college_school', $('#direct_college_school').val());
    FileData.append('direct_college_location', $('#direct_college_location').val());
    FileData.append('direct_college_inclusive', $('#direct_college_inclusive').val());
    FileData.append('direct_college_year_graduated', $('#direct_college_year_graduated').val());
    FileData.append('direct_other_schools', $('#direct_other_schools').val());
    FileData.append('direct_civil_service', $('#direct_civil_service').val());

    if(to_go)
    {
        btn.attr('disabled', true);
        $.ajax({
            type: 'post',
            url: '../bi_direct_upload_additional_from_return',
            contentType: false,
            processData: false,
            async : true,
            data :FileData,
            success: function(data)
            {
                if(data == 'success')
                {
                    $('.ff_file').val('');
                    $('.update_info_class').hide();
                    $('.return_validation_clear').val('');

                    alert('Updating Information Success');
                }
                btn.attr('disabled', false);

            }
        });
    }
});

$('.auth_letter_change_input').on('keyup keypress',function()
{
    var mainClassi = $(this).attr('classification');
    var mainVal = $(this).val();
    $('.auth_letter_change').each(function()
    {
        if($(this).attr('classification') == mainClassi)
        {
            $(this).html(mainVal);
        }
    });

    $('#auth_letter_body_employment .auth_letter_change').each(function()
    {
        if($(this).attr('classification') == mainClassi)
        {
            $(this).html(mainVal);
        }
    });

});

$('#dec1Signature').change(function()
{
    readURLSignature(this);
});

function readURLSignature(input)
{

    var fileValidation = input.files[0];
    var fileType = fileValidation["type"];
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];


    if ($.inArray(fileType, validImageTypes) < 0)
    {
        alert('Invalid file type. Select an image');
        $('#dec1Signature').val('');
    }
    else
    {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#hideShowSignature').show();
                $('.signatureDeclarationDisplay').attr('src', e.target.result);
                $('#signatureDeclarationToSave').attr('src', e.target.result);
                // $('#uploadedImgModalView').attr('src', e.target.result);
                $('#showInputDec1').hide();
                $('#hideShowCLoseSig1').show();


            };

            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#hideShowSignature').hide();
            $('#dec1Signature').val('');
            // $('#uploadedImgView').attr('src', '../user_profile_pictures/default3.jpg');
            // $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
        }
    }


}

$('#addSignatureToDeclaration').click(function()
{
    $('#showHideButtonGreenSig').hide();
    $('#showInputDec1').show();
});

$('#removeSignature1').click(function()
{
    $('#showHideButtonGreenSig').show();
    $('#showInputDec1').hide();
    $('#hideShowCLoseSig1').hide();
    $('#dec1Signature').val('');
    $('.signatureDeclarationDisplay').removeAttr('src');
    $('#signatureDeclarationToSave').removeAttr('src');
    $('#hideShowSignature').hide();
});

$('#acct_birthdate_full').change(function()
{
    if($(this).attr('client') == 'qualfon')
    {
        if($(this).val() != '')
        {
            dateToWords($(this).val(), $('#dateWordsHolder'), $(this));
        }

        $('#dateWordsHolder').show();
    }

});

$('#dateWordsHolder').click(function()
{
    if($(this).attr('client') == 'qualfon')
    {
        $(this).hide();
        $('#acct_birthdate_full').show();
        $('#acct_age').val('');
        $('#acct_birthdate_full').val('');
        $('#acct_birthdate_full').datepicker('show');
    }
});

function dateToWords(valToGet, ToChangeElement, toHideElement)
{
    var dateSelected = new Date(valToGet);
    var monthString = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    ToChangeElement.val(monthString[dateSelected.getMonth()] + ' ' + dateSelected.getDate() + ', ' + dateSelected.getFullYear());
    if(toHideElement.val() != '')
    {
        toHideElement.hide();
    }
    else
    {
        toHideElement.show();
    }
}

$(document).ready(function()
{
    if($('#acct_birthdate_full').attr('client') == 'qualfon')
    {
        $('#acct_birthdate_full').datepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            yearRange: "-100:+0",
            orientation: "bottom auto",
            dateFormat: 'yy-mm-dd'
        });
    }
});

$('.upload_expand_btn').click(function()
{
    var holderId = '#'+$(this).attr('name');
    $(''+holderId+'').slideToggle('slow');

    if($(this).children('i')[0].className == 'fa fa-plus')
    {
        $(this).children('i').removeClass();
        $(this).children('i').addClass('fa fa-minus');
    }
    else
    {
        $(this).children('i').removeClass();
        $(this).children('i').addClass('fa fa-plus');
    }
});

$('#convert_auth_to_pdf').click(function()
{
    var htmlElementsEmp = $('#auth_letter_body_employment').html();
    var htmlAll = '';

    if($('#auth_letter_body_school').length == 0)
    {
        htmlAll = htmlElementsEmp;
    }
    else
    {
        var htmlElementsSchool = $('#auth_letter_body_school').html();
        htmlAll = htmlElementsSchool + htmlElementsEmp;

    }

    $.ajax({
        type: 'post',
        url: '../direct_applicant_authorization_letter_to_pdf',
        data: {
            'htmlElements' : htmlAll
        },
        success: function(data)
        {
            console.log(data);
        }
    });
});

$('#ff_signature').change(function()
{
    var defaultResources = window.location.origin + '/fine-uploader/placeholders/not_available-generic.png';
    if($(this).val() != '')
    {
        // $("#signatureHolder").attr('src', '');
        readURL(this);

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#signatureHolder').attr('src', e.target.result);
                    // $('#uploadedImgModalView').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    else
    {
        $("#signatureHolder").attr('src', defaultResources);
    }
});