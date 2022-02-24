var tableCiLogTrailing;
var coltittle3 = [];
var col_count3 = 0;
var ci_id;
var openTable = false;

$("#show_login_trail").hide();

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$('#btnNewPassword').click(function () {
    var cp = $('#txtCurrentPass').val();
    var np = $('#txtNewPass').val();
    var vp = $('#txtVerifyPass').val();

    if($('#txtCurrentPass').val()==='' || $('#txtNewPass').val()==='' || $('#txtVerifyPass').val()==='')
    {
        alert('Please indicate password.');
    }
    else if (np !== vp)
    {
        alert('Password not match.');
    }
    else
    {

        var strings = np;
        var character='';
        var rule_okay_upper = false;
        var rule_okay_numeric = false;

        if(strings.length < 6)
        {
            alert('Password required atleast 6 characters.');
        }
        else
        {
            for (var i=0; i < strings.length; i++){
                character = strings.charAt(i);
                if(/[A-Z]/.test(character))
                {
                    rule_okay_upper = true;
                }
                else if(/[0-9]/.test(character))
                {
                    rule_okay_numeric = true;
                }
            }

            if(rule_okay_upper && rule_okay_numeric)
            {
                console.log('Password is acceptable.');
                $.ajax
                ({
                    method: 'post',
                    url: 'gen-change-pass',
                    data:
                        {
                            'cp': cp,
                            'np': np
                        },
                    success: function (data)
                    {
                        if(data=='success')
                        {
                            alert('Successfully changed password!');
                            window.location.reload(true)
                        }
                        else if(data == 'mismatch')
                        {
                            alert('Incorrect Current Password');
                        }
                        else {
                            alert('Password is already use recently. Please choose another password.');
                        }
                    }
                })
            }
            else
            {
                alert('Password should contain numeric and upper case character');
            }
        }



    }
});


$('#btnTriggerCIdirectory').click(function () {

    $('#locationviewer').attr('style','display: none');
    $('#login_trail').attr('style','display: none');

    $('#span_ci_directory_main').html('');
    $('#span_ci_directory_other').html('');
    $("#table_login_trail_body").html('');
    $('#show_login_trail').hide();

    $.ajax({
        type: 'get',
        url: '/gen-get-ci-directory',
        data: {

            'id' : '1'
        },
        dataType: 'json',
        success: function(data)
        {
            var forthesakeofloop ='';


            for(var ctr=0; ctr < data.length; ctr++){

                forthesakeofloop += '<option value="'+data[ctr].id+'">'+data[ctr].name+'</option>\n';
            }

            $('#ciIDinfo').html('<select> <option></option>'+forthesakeofloop+'<select/>');


            // console.log(forthesakeofloop);


        },
        error: function()
        {
            console.log('error');

        }
    });

});


$('#ci_directory_btn_view').click(function ()
{
    ci_id = $('#ciIDinfo').val();

    if (ci_id != '')
    {
        $.ajax
        ({
            type: 'get',
            url: '/gen-get-ci-directory-info',
            data: {

                'id' : ci_id
            },
            dataType: 'json',
            success: function(data)
            {
                var nums =  '';
                console.log(data);


                if(data[2].length === 0)
                {
                    $('#span_ci_directory_main').html('                                <div class="box box-widget widget-user-2">\n' +
                        '                                                    <div class="widget-user-header bg-yellow">\n' +
                        '                                                        <div class="widget-user-image">\n' +
                        '                                                            <img class="img-circle" src="'+data[0][0].ci_pics+'">\n' +
                        '                                                        </div>\n' +
                        '                                                        <h3 class="widget-user-username">'+data[0][0].ci_name+'\n' +
                        '                                                        <h5 class="widget-user-desc">Email: '+data[0][0].ci_email+'</h5>\n' +
                        '                                                        <h5 class="widget-user-desc">Branch: '+data[0][0].branch_name+'</h5>\n' +
                        '<h5 class="widget-user-desc">Contact #: No number registered in the system.</h5>\n'+
                        '                                                    </div>\n' +
                        '                                                </div>'
                    );
                }
                else{

                    for(var ii = 0; ii<data[2].length; ii++)
                    {
                        console.log();

                        nums += data[2][ii].contact_number+'<br>';
                    }
                    $('#span_ci_directory_main').html('                                <div class="box box-widget widget-user-2">\n' +
                        '                                                    <div class="widget-user-header bg-yellow">\n' +
                        '                                                        <div class="widget-user-image">\n' +
                        '                                                            <img class="img-circle" src="'+data[0][0].ci_pics+'">\n' +
                        '                                                        </div>\n' +
                        '                                                        <h3 class="widget-user-username">'+data[0][0].ci_name+'\n' +
                        '                                                        <h5 class="widget-user-desc">Email: '+data[0][0].ci_email+'</h5>\n' +
                        '                                                        <h5 class="widget-user-desc">Branch: '+data[0][0].branch_name+'</h5>\n' +
                        '<h5 class="widget-user-desc">Contact #: '+nums+'</h5>\n'+
                        '</div>\n' +
                        '                                                </div>'
                    );

                }
                    $('#locationviewer').removeAttr('style');
                    $('#login_trail').removeAttr('style');
                    if(data[1].length > 0)
                    {
                        $('#locationviewer').attr('name', 'latlong:'+data[1][0].Lat+':'+data[1][0].Long+'');
                        $('#locationviewer').attr('href', "https://www.google.com/maps/place/"+data[1][0].Lat+" "+data[1][0].Long+"");
                        $('#span_ci_directory_other').html('<h3>MAP INFORMATION</h3>'+
                            '<b>Latitude:</b> ' +data[1][0].Lat+
                            '<br><b>Longitude:</b> '+ data[1][0].Long
                            // '<br><b>Approximate Address from GPS:</b> '+data[1][0].Address+
                            // '<br><b>Satus:</b> '+data[1][0].Status
                            // '<br><b>Last Update:</b> '+data[1][0].Last_Update
                        );
                    }
                    else
                    {
                        $('#locationviewer').attr('name', '');
                        $('#locationviewer').attr('href', '');
                        $('#span_ci_directory_other').html('<h3>MAP INFORMATION</h3>'+
                            '<b>Latitude:</b> 0' +
                            '<br><b>Longitude:</b> 0'
                        );
                    }

                    // $('#locationviewer').attr('target', "https://www.google.com/maps/place/"+data[1][0].Lat+" "+data[1][0].Long+"");



                    $("#table_login_trail_body").html('');
                    $("#show_login_trail").hide();
                // }

            },
            error: function()
            {
                console.log('error');

            }
        });
    }
    else
    {
        alert('Please select a FCI');
    }
});

$('#login_trail').on('click',function ()
{

    if(openTable == false)
    {
        logTrail();
        openTable = true;
    }
    else
    {
        tableCiLogTrailing.ajax.reload(null, false);
    }

    $("#show_login_trail").show();
    // $.ajax({
    //     url: 'get_ci_login_trail',
    //     type: 'get',
    //     data: {
    //         'ci_id' : $('#ciIDinfo').val()
    //     },
    //     success: function (data) {
    //         $("#table_login_trail_body").html('');
    //         $("#show_login_trail").show();
    //
    //         var value = '';
    //
    //         for(var ctr = 0; ctr<data.length; ctr++)
    //         {
    //             value +=    '<tr>' +
    //                         '<td> <a target="_blank" href= "https://www.google.com/maps/place/'+data[ctr].lat+' '+data[ctr].long+'">'+data[ctr].lat+' | '+data[ctr].long+'</td></a>' +
    //                         '<td>'+data[ctr].address_location+'</td>' +
    //                         '<td>'+data[ctr].created_at+'</td>' +
    //                         '</tr>';
    //         }
    //
    //         $("#table_login_trail_body").append(value);
    //
    //     },
    //     error: function () {
    //         console.log('error');
    //     }
    //
    // });
});



function logTrail()
{
    $('#table_login_trail thead th').each(function()
    {
        var title = $(this).text();
        coltittle3[col_count3] = $(this).text();
        if(title != 'Lat | Long')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        }
        col_count3++;
    });
    tableCiLogTrailing = $('#table_login_trail').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'CI Login Trail',
                    exportOptions:
                        {
                            columns: [0, 1, 2],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return coltittle3[(idx)];
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
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": "/ci-directory-trail-monit",
        "ajax":
            {
                type: 'get',
                url: "/get_ci_login_trail",
                data: function (d)
                {
                    d.ci_id = ci_id;
                }
            },
        "columns":
            [
                {
                    data : function lats(data)
                    {
                        var toShow = '';

                        if((data.lat == '0' && data.long == '0') || (data.lat == null && data.long == null))
                        {
                            toShow = 'Cannot Detect GPS';
                        }
                        else
                        {
                            toShow = ''+data.lat+' | '+data.long+'';
                        }
                        return '<a target="_blank" href= "https://www.google.com/maps/place/'+data.lat+' '+data.long+'">'+toShow+'</a>';
                    },
                    name : 'ci_login_trails.lat',
                    'orderable': false
                },
                {
                    data : function view(data)
                    {
                        if(data.type == 'Attendance')
                        {
                            var idToShow = btoa(data.id);
                            var photo_sort = data.photo_path.split('');

                            if(photo_sort[0] == '/')
                            {
                                return '<span>Attendance</span><br><br><a target="_blank" href = "/ci-show-attendance-pic/'+idToShow+'" >View Photo</a>';
                            }
                            else if(photo_sort[0] == 'c')
                            {
                                return '<span>Attendance</span><br><br><a class="showExpand" name="'+data.id+'" style="cursor: pointer" title="Click to show uploaded photo/s">View Photo</a>' +
                                    '<div id="showwww-'+data.id+'" class="expanderChecker" name="'+data.id+'" style="border: solid 1px black" hidden><div id="appendHere-'+data.id+'"></div></div>';
                            }
                        }
                        else if(data.address_location == 'no address found')
                        {
                            return 'Location Update';
                        }
                        else
                        {
                            return 'No GPS'
                        }
                    },
                    name : 'ci_login_trails.type',
                    'orderable': false
                },
                {
                    data: function(data)
                    {
                        if(data.user_ip != null)
                        {
                            return data.user_ip;
                        }
                        else if(data.user_ip != '')
                        {
                            return data.user_ip;
                        }
                        else if(data.user_ip == '')
                        {
                            return 'None';
                        }
                        else if(data.user_ip == null)
                        {
                            return 'None';
                        }
                        else
                        {
                            return 'None';
                        }
                    },
                    name: 'ci_login_trails.user_ip',
                    'orderable': false
                },
                {
                    data: function(data)
                    {
                        if(data.user_agent != null)
                        {
                            return data.user_agent;
                        }
                        else if(data.user_agent != '')
                        {
                            return data.user_agent;
                        }
                        else if(data.user_agent == '')
                        {
                            return 'None';
                        }
                        else if(data.user_agent == null)
                        {
                            return 'None';
                        }
                        else
                        {
                            return 'None';
                        }
                    },
                    name: 'ci_login_trails.user_agent',
                    'orderable': false
                },
                {data : 'created_at' , name : 'ci_login_trails.created_at'}
            ],
        "order": [[4, 'desc']],
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

    $('#table_login_trail_filter input').unbind();
    $('#table_login_trail_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableCiLogTrailing.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableCiLogTrailing.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table_login_trail').on('click', '.showExpand', function()
{
    var idCount = $(this).attr('name');
    var id = $('#showwww-'+idCount+'').attr('name');
    $('.expanderChecker').each(function()
    {
        if($(this).attr('name') != idCount)
        {
            $(this).hide();
            $(this).html('');
        }
    });

    $('#showwww-'+idCount+'').toggle();

    if($('.expanderChecker').is(':visible'))
    {
        $.ajax({
            type: 'get',
            url: 'ci_get_attendancePhotos',
            data: {
                'id' : id
            },
            success: function(data)
            {
                if(data.length > 0)
                {
                    var tableData = '<tr>' +
                        '<td><b>Uploaded Photo/s</b></td>' +
                        '</tr>';
                    for(var i = 0; i < data[0].length; i++)
                    {
                        tableData += '<tr>' +
                            '<td>' +
                            // '<a style="cursor: pointer" target="_blank" href="ci_attendance_bulk_pic/'+btoa(data[1])+'/'+btoa(data[0][i])+'" title="Click to view photo">'+data[0][i]+'</a></td>' +
                            '<a style="cursor: pointer" target="_blank" href="ci_attendance_bulk_pic/'+btoa(data[1])+'/'+btoa(data[0][i])+'" title="Click to view photo">' +
                            '<img src="ci_attendance_bulk_pic/'+btoa(data[1])+'/'+btoa(data[0][i])+'" alt="" width="100%">' +
                            '</a></td>' +
                            '</tr>'
                    }

                    var table = '<table width="100%" class="table-condensed table-hover">'+tableData+'</table>';

                    $('#showwww-'+idCount+'').html(table);
                }
            }
        });
    }
});