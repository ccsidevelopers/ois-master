// var eq_id = 'dodong';
var item_barcode = $('#barcode').attr('value');
var item_det_type;
var emp_id;
var emp_pos;
var item_brand;
var item_branch;
var item_desc;
var item_invoice;
var item_war;
var item_price;
var what_type = '';
var item_status;
var submittedFilesArray = [];
var updatevalidatorbool = false;
var what = '';

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


$(document).ready(function()
{
    $('#fine-uploader-manual-trigger').html();

    get_uploader();

    $('#trigger-upload').click(function ()
    {
        $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
    });

    $(window).load(function ()
    {
        if($('#latest_pic').length)
        {
            $.ajax({
                type: 'get',
                url: 'admin_get_all_latest_item_pic',
                data: {
                    'id' : $('#id_holder').val()
                },
                beforeSend: function() {
                    $('#wait-loading').modal({backdrop: 'static'});
                },
                success : function (data)
                {
                    var imagessss = '';

                    if(data[1].length <= 0)
                    {

                    }
                    else
                    {
                        for(var i = 0; i < data[1].length; i++)
                        {
                            imagessss += '<a style="cursor: pointer" data-toggle="modal" data-target="#modal-view-pic" class="view-resize-img" id="barcode_get_latest_pic/'+btoa($('#id_holder').val())+'/'+btoa(data[1][i])+'"><img src="barcode_get_latest_pic/'+btoa($('#id_holder').val())+'/'+btoa(data[1][i])+'" alt="" class="img-thumbnail" style="width: 30%;"></a>'
                        }

                        $('#latest_pic').html(imagessss);
                    }

                },
                complete: function()
                {
                    $('#wait-loading').modal('hide');
                }
            })
        }
    });
});


function get_uploader() {

    fineupload = new $('#fine-uploader-manual-trigger').fineUploader
    ({
        template: 'qq-template-manual-trigger',
        request:
            {
                endpoint: '/admin_staff_upload_pictures_fine/'+item_barcode,
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
                itemLimit: 3,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp']
                // allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        submittedFilesArray.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        submittedFilesArray.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    setTimeout(function()
                    {
                        $('#wait-loading').modal('hide');
                        submittedFilesArray = [];
                    }, 500);

                    alert('Encoded Successfully');

                    setTimeout(function()
                    {
                        window.location.reload();
                    }, 1000);
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

$('#select-type').on('change', function()
{
    var selected = $(this).children('option:selected').val();

    if(selected == '')
    {
        $('#employee_contents').fadeOut();
        $('#office_contents').fadeOut();
        $('.button-to-submit').fadeOut().attr('name', 'none');
    }
    else if(selected == 'emp')
    {
        $('#employee_contents').fadeIn();
        $('#office_contents').hide();
        $('.button-to-submit').show().attr('name', 'emp');
    }
    else if(selected == 'branch')
    {
        $('#office_contents').fadeIn();
        $('#employee_contents').hide();
        $('.button-to-submit').show().attr('name', 'branch');
    }
});

$('#submit_item').click(function()
{
    var inputvalidatorbool = false;

    if($('#select-type').children('option:selected').val() === 'emp')
    {
        $('.empInput').each(function ()
        {
            if($(this).val() != '')
            {
                inputvalidatorbool = true;
            }
            else
            {
                inputvalidatorbool = false;
                alert('Fill-up the required fields');
                return false;
            }
        });
    }
    else if($('#select-type').children('option:selected').val() === 'branch')
    {
        $('.branchInput').each(function ()
        {
            if($(this).val() != '')
            {
                inputvalidatorbool = true;
            }
            else
            {
                inputvalidatorbool = false;
                alert('Fill-up the required fields');
                return false;
            }
        });
    }

    if(inputvalidatorbool)
    {
        $.ajax({
            url: 'barcode_get_auth_user',
            type: 'get',
            success : function (data)
            {

                if(data == 'need to login')
                {
                    $('#modal-submit-to-login').modal('show');
                }
                else
                {
                    insertItemToIventory();
                }
            }
        });
    }
});

$('#encode_pass').on('keypress', function(e)
{
    if($('#complete_encode').length)
    {
        if(e.keyCode === 13)
        {
            $('#complete_encode').click();
        }
    }
    else if($('#update_item_encode').length)
    {
        if(e.keyCode === 13)
        {
            $('#update_item_encode').click();
        }
    }

});

$('#complete_encode').on('click', function()
{
    $(this).attr('disabled', true);
    var inputvalidatorbool = false;
    var email = $('#encode_email').val();
    var password = $('#encode_pass').val();
    var go_login = false;

    if($('#select-type').children('option:selected').val() == 'emp')
    {
        $('.empInput').each(function ()
        {
            if($(this).val() != '')
            {
                inputvalidatorbool = true;
            }
            else
            {
                inputvalidatorbool = false;
                alert('Fill-up the required fields');
                return false;
            }
        });
    }
    else if($('#select-type').children('option:selected').val() == 'branch')
    {
        $('.branchInput').each(function ()
        {
            if($(this).val() != '')
            {
                inputvalidatorbool = true;
            }
            else
            {
                inputvalidatorbool = false;
                alert('Fill-up the required fields');
                return false;
            }
        });
    }

    $('.validate').each(function()
    {
        if($(this).val() != '')
        {
            go_login = true;
        }
        else
        {
            go_login = false;

            $('#error').fadeIn();

            setTimeout(function()
            {
                $('#error').fadeOut();
            },2000);
            return false;
        }
    });


    if(inputvalidatorbool)
    {
        if(go_login)
        {
            $.ajax({
                type: 'get',
                url: 'admin_staff_encode_item_login',
                data: {
                    'email' : email,
                    'password' : password
                },
                success : function (data)
                {
                    if(data == 'error')
                    {
                        $('#error').fadeIn();

                        setTimeout(function()
                        {
                            $('#error').fadeOut();
                        },2000);
                    }
                    else if(data == 'not admin staff')
                    {
                        $('#Autherror').fadeIn();

                        setTimeout(function()
                        {
                            $('#Autherror').fadeOut();
                        },2000);
                    }
                    else
                    {
                        console.log(data);
                        insertItemToIventory();
                    }
                }
            });
        }
    }
});

function insertItemToIventory()
{
    if($('#select-type').children('option:selected').val() == 'emp')
    {
        item_det_type = $('#select-item-type-emp').children('option:selected').val();
        emp_id = $('#item-emp-id').val();
        emp_pos = $('#item-emp-position').val();
        item_brand = $('#item-emp-brand').val();
        item_branch = $('#item-emp-branch').val();
        item_desc = $('#item-emp-desc').val();
        item_invoice = $('#item-emp-invoice').val();
        item_war = $('#item-emp-war').val();
        item_price= $('#item-emp-price').val();
        what_type = 'Employee Equipment';
    }
    else if($('#select-type').children('option:selected').val() == 'branch')
    {
        item_det_type = $('#select-item-off-type').children('option:selected').val();
        item_brand = $('#item-brand').val();
        item_branch = $('#item-branch').val();
        item_desc = $('#item-desc').val();
        item_invoice = $('#item-emp-invoice').val();
        item_war = $('#item-war').val();
        item_price= $('#item-price').val();
        what_type = 'Branch Asset';
    }

    var attachmentBool = false;

    if(submittedFilesArray.length === 0)
    {
        attachmentBool = !!confirm('Are you sure to submit the item without attachments?');
    }

    $.ajax({
        url: 'admin_staff_submit_item_to_inventory',
        type: 'get',
        data: {
            'barcode' : item_barcode,
            'item_det_type' : item_det_type,
            'emp_id' : emp_id,
            'emp_pos' : emp_pos,
            'item_brand' : item_brand,
            'item_branch' : item_branch,
            'item_desc' : item_desc,
            'item_invoice' : item_invoice,
            'item_war' : item_war,
            'item_price' : item_price,
            'what_type' : what_type,
            'item_status' : $('#emp-item-status').val(),
            'item_condition' : $('#emp-item-condition').val(),
            'emp_loc' : $("#item-emp-loc").val()
        },
        success : function(data)
        {
            // console.log(data);
            if(!attachmentBool)
            {
                $('#trigger-upload').click();
            }
            else
            {
                $('#wait-loading').modal('hide');
            }
        },
        complete: function()
        {
            $('#wait-loading').modal({backdrop: 'static'});
            $('#modal-submit-to-login').modal('hide');
        }
    });
}

$('#button-edit-emp-id').click(function()
{
    if($('#item-emp-id').attr('disabled') == 'disabled')
    {
        $('#item-emp-id').attr('disabled', false);
        $('#item-emp-position').attr('disabled', false);
    }
    else
    {
        $('#item-emp-id').attr('disabled', true);
        $('#item-emp-position').attr('disabled', true);
    }
});

$('#update_inventory').click(function()
{
    $('.full_view_info').show();
    $('.info_viw').hide();
});

$('.view_history').on('click', function()
{
    var eq_id = atob($(this).val());
    $('#user_history_table_span').html('');

    // console.log(eq_id);

    $.ajax({
        type: 'get',
        url: 'admin_staff_get_item_history',
        data: {
            'eq_id' : eq_id
        },
        success : function(data)
        {
            // console.log(data);
            var tabledata = '';
            var tableHead = '<table class="table-hover table-condensed display tableendorse" width="100%" border="1" style="text-align: center;">\n' +
                '                                            <thead>\n' +
                '                                            <tr style="background-color: black; color: white">\n' +
                '                                                <th>Employee ID</th>\n' +
                '                                                <th>Handled By</th>\n' +
                '                                                <th>Date Time Issued</th>\n' +
                '                                                <th>Date Time Return/Vacent</th>\n' +
                '                                            </tr>\n' +
                '                                            </thead>' +
            '                                                <tbody>';
            for(var i = 0; i < data.length; i++)
            {
                if(data[i].status == 'Issued')
                {
                    tabledata += '<tr>' +
                        '         <td>'+data[i].emp_id+'</td>' +
                        '         <td>'+data[i].name+'</td>' +
                        '         <td>'+data[i].datetime_added+'</td>' +
                        '         <td>-</td>' +
                        '         </tr>';
                }
                else
                {
                    tabledata += '<tr>' +
                        '         <td>'+data[i].emp_id+'</td>' +
                        '         <td>'+data[i].name+'</td>' +
                        '         <td>-</td>' +
                        '         <td>'+data[i].datetime_added+'</td>' +
                        '         </tr>';
                }

            }

            $('#user_history_table_span').html(tableHead + tabledata + '</tbody></table>');
        }
    });
});

$('#update_item').click(function ()
{
    var id = $(this).val();
    var emp_id = $('#item-emp-id').val();

    if($('#cat').val() == 'Employee Equipment')
    {

        $('.req_field').each(function()
        {
            if($(this).val() != '')
            {
                updatevalidatorbool = true;
                what = 'emp';
            }
            else
            {
                alert('Fill-up the required fields');
                updatevalidatorbool = false;
                return false;
            }
        });
    }
    else if($('#cat').val() == 'Branch Asset')
    {
        $('.req_field').each(function()
        {
            if($(this).val() != '')
            {
                updatevalidatorbool = true;
                what = 'branch';
            }
            else
            {
                alert('Fill-up the required fields');
                updatevalidatorbool = false;
                return false;
            }
        });
    }

    var attachmentBool = false;

    if(updatevalidatorbool)
    {
        if(submittedFilesArray.length === 0)
        {
            if(confirm('Are you sure to submit the item without attachments?'))
            {
                attachmentBool = true;
            }
        }

        $.ajax({
            url: 'barcode_get_auth_user',
            type: 'get',
            success : function (data)
            {
                if(data == 'need to login')
                {
                    $('#modal-submit-to-login').modal('show');
                }
                else
                {
                    console.log(data);

                    $.ajax({
                        type :'get',
                        url: 'admin_staff_update_item_to_inventory',
                        data: {
                            'id' : id,
                            'emp_id' : emp_id,
                            'item_status' : $('#update-item-status').val(),
                            'item_condition' : $('#update-item-condition').val(),
                            'branch' : $('#item-branch').attr('name'),
                            'remarks' : $('#update-item-remarks').val(),
                            'what' :  what
                        },
                        success : function (data)
                        {
                            // console.log(data);
                            if(!attachmentBool)
                            {
                                $('#trigger-upload').click();
                            }
                            else
                            {
                                $('#wait-loading').modal('hide');
                            }

                            alert('Info successfully encoded');
                        }
                    });

                    // if($('#cat').val() == 'Employee Equipment')
                    // {
                    //     console.log('This is Employee Equipment');
                    //
                    //     var emp_id = $('#item-emp-id').val();
                    //
                    //     $('.req_field').each(function()
                    //     {
                    //         if($(this).val() != '')
                    //         {
                    //             checkerbool = true;
                    //         }
                    //         else
                    //         {
                    //             alert('Fill-up the required fields');
                    //             checkerbool = false;
                    //             return false;
                    //         }
                    //     });
                    //
                    //     if(checkerbool)
                    //     {
                    //         $.ajax({
                    //             type :'get',
                    //             url: 'admin_staff_update_item_to_inventory',
                    //             data: {
                    //                 'id' : id,
                    //                 'emp_id' : emp_id,
                    //                 'item_status' : item_status,
                    //                 'what' : 'emp'
                    //             },
                    //             success : function (data)
                    //             {
                    //                 console.log(data);
                    //             }
                    //         });
                    //     }
                    // }
                    // else if($('#cat').val() == 'Branch Asset')
                    // {
                    //     $('.req_field').each(function()
                    //     {
                    //         if($(this).val() != '')
                    //         {
                    //             checkerbool = true;
                    //         }
                    //         else
                    //         {
                    //             alert('Fill-up the required fields');
                    //             checkerbool = false;
                    //             return false;
                    //         }
                    //     });
                    //
                    //     if(checkerbool)
                    //     {
                    //         $.ajax({
                    //             type :'get',
                    //             url: 'admin_staff_update_item_to_inventory',
                    //             data: {
                    //                 'id' : id,
                    //                 'item_status' : item_status,
                    //                 'what' : 'branch'
                    //             },
                    //             success : function (data)
                    //             {
                    //                 console.log(data);
                    //             }
                    //         });
                    //     }
                    // }
                }
            }
        });
    }

});

$('#update_item_encode').on('click', function()
{
    var id = $('#update_item').val();
    var emp_id = $('#item-emp-id').val();
    var email = $('#encode_email').val();
    var password = $('#encode_pass').val();
    var go_login = false;

    $('.validate').each(function()
    {
        if($(this).val() != '')
        {
            go_login = true;
        }
        else
        {
            go_login = false;

            $('#error').fadeIn();

            setTimeout(function()
            {
                $('#error').fadeOut();
            },2000);
            return false;
        }
    });

    var attachmentBool = false;

    if(go_login)
    {
        if(submittedFilesArray.length === 0)
        {
            if(confirm('Are you sure to submit the item without attachments?'))
            {
                attachmentBool = true;
            }
        }

        $('#update_item_encode').attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_staff_encode_item_login',
            data: {
                'email' : email,
                'password' : password
            },
            success : function (data)
            {
                if(data == 'error')
                {
                    $('#update_item_encode').attr('disabled', false);
                    $('#error').fadeIn();

                    setTimeout(function()
                    {
                        $('#error').fadeOut();
                    },2000);
                }
                else if(data == 'not admin staff')
                {
                    $('#update_item_encode').attr('disabled', false);
                    $('#Autherror').fadeIn();

                    setTimeout(function()
                    {
                        $('#Autherror').fadeOut();
                    },2000);
                }
                else
                {
                    $('#update_item_encode').attr('disabled', false);
                    console.log(data);

                    $.ajax({
                        type :'get',
                        url: 'admin_staff_update_item_to_inventory',
                        data: {
                            'id' : id,
                            'emp_id' : emp_id,
                            'item_status' : $('#update-item-status').val(),
                            'item_condition' : $('#update-item-condition').val(),
                            'branch' : $('#item-branch').attr('name'),
                            'remarks' : $('#update-item-remarks').val(),
                            'what' :  what
                        },
                        success : function (data)
                        {
                            alert('Info successfully encoded');
                            console.log(data);

                            if(!attachmentBool)
                            {
                                $('#trigger-upload').click();
                            }
                            else
                            {
                                $('#wait-loading').modal('hide');
                            }
                        },
                        complete: function ()
                        {
                            $('#modal-submit-to-login').modal('hide');
                        }
                    });
                }
            }
        });
    }
});

$('#item-emp-branch').on('change', function ()
{
    var value = $(this).children('option:selected').text();
    $('#item-emp-loc').html('');
    $.ajax({
        type: 'get',
        url: 'admin_staff_getProv',
        data: {
            'prov_name' : value
        },
        success: function(data)
        {
            var muni_holder = '<option value=""><--- SELECT PROVINCE ---></option>';

            for(var i = 0; i < data.length; i++)
            {
                muni_holder +='<option value="'+data[i].id+'">'+data[i].muni_name+'</option>'
            }

            $('#item-emp-loc').html(muni_holder);
        }
    })
});

$('#latest_pic').on('click', '.view-resize-img', function()
{
    $('#view-pic-click').attr('src', $(this).attr('id'));
});

// $('#update-item-status').change(function()
// {
//     var val = $(this).children('option:selected').val();
//
//     if(val == 'Vacant' || val == 'Return')
//     {
//         $('#item-emp-id').val('N/A');
//     }
//     else
//     {
//         $('#item-emp-id').val('');
//     }
// });

$('#select-type').change(function()
{
    var val = $(this).children('option:selected').text();

    console.log(val);

    $('#select-item-type-emp > option').each(function()
    {
        if($(this).attr('name') == val || $(this).attr('name') == 'Others')
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });

    $('#select-item-off-type > option').each(function()
    {
        if($(this).attr('name') == val || $(this).attr('name') == 'Others')
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });
});