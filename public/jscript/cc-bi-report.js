$(document).on('click', '.class_bi_reports', function()
{
    getBiReports();

    function getBiReports()
    {
        $('#bi-report-table thead th').each(function()
        {
            var title = $(this).text();
            if(title == 'ACTION')
            {

            }
            else
            {
                $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
            }
        });

        tableBiReports = $('#bi-report-table').DataTable(
            {
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": "get_bi_reports_table",
                "columns":
                    [
                        {data: 'id', name: 'bi_ci_report.id'},
                        {data: 'name', name: 'users.name'},
                        {data: 'client_name', name: 'bi_ci_report.client_name'},
                        {data: 'subj_name', name: 'bi_ci_report.subj_name'},
                        {data: 'created_at', name: 'bi_ci_report.created_at'},
                        {
                            data: function action (data)
                            {
                                return '<button class="btn btn-sm btn-success btn-block edit_bi_note" href="'+data.id+'"><i class="glyphicon glyphicon-eye-open"></i> View B.I Report</button>' +
                                    '<button class="btn btn-sm btn-info btn-block view_bi_rep_logs" href="'+data.id+'"><i class="glyphicon glyphicon-film"></i> Logs</button>';
                            },
                            'name' : 'bi_ci_report.ci_note',
                            // searchable : false,
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

        $('#bi-report-table_filter input').unbind();
        $('#bi-report-table_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableBiReports.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableBiReports.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    $('.bi_report_logs').each(function()
    {
        var table_id = $(this).attr('id');
        $('#'+table_id+'').on('click', '.view_bi_rep_logs', function()
        {
            $('#for_bi_logs_table').html('');

            $('#modal_bi_note_logs').modal('show');
            $.ajax({
                type: 'get',
                url: 'ci_bi_note_view_logs',
                data: {
                    'id' : $(this).attr('href')
                },
                success:function(data)
                {
                    var head = '<table width="100%" class="table-condensed table-hover">\n' +
                        '    <tr style="background-color: brown; color: white">\n' +
                        '        <th>USER</th>\n' +
                        '        <th>POSITION</th>\n' +
                        '        <th>ACTIVITIES</th>\n' +
                        '        <th>DATE/TIME OCCURED</th>\n' +
                        '    </tr>';
                    var to_append = '';

                    if(data[0].length > 0)
                    {
                        for(var i = 0;i < data[0].length; i++)
                        {
                            to_append += '<tr>\n' +
                                '    <td>'+data[0][i].name+'</td>\n' +
                                '    <td>'+data[0][i].position+'</td>\n' +
                                '    <td>'+data[0][i].activities+'</td>\n' +
                                '    <td>'+data[0][i].datetime+'</td>\n' +
                                '</tr>';
                        }
                    }
                    else
                    {
                        to_append += '<tr>\n' +
                            '    <td colspan="4">NO RECORD FOUND</td>\n' +
                            '</tr>';
                    }

                    $('#for_bi_logs_table').html(head + to_append + '</table>');

                },
                error: function(e)
                {
                    alert('Error occured contact the web admin for assistance. Thank you');
                }
            });
        });
    });

    $('#bi-report-table').on('click', '.edit_bi_note', function()
    {
        $this = $(this);
        $('#update_bi_note').val('');
        $('#download_ci_bi').attr('href', '');
        $.ajax({
            type: 'get',
            url: 'get_current_bi_note',
            data: {
                'id' : $(this).attr('href')
            },
            success: function(data)
            {
                // console.log(data);
                $('#download_ci_bi').attr('href', 'download-ci-bi-attachments?id='+ btoa($this.attr('href')));
                $('#modal_ci_update_bi_note').modal('show');
                $('#update_bi_note').val(data[0].ci_note);
            },
            error: function(e)
            {
                alert('Error occured contact the web admin for assistance. Thank you');
            }
        });
    });
});