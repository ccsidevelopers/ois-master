var emergency_contact_count = 0;
var emergency_contact_array = [];
emergency_contact_array.push(0);

var character_reference_count = 0;
var character_reference_array = [];
character_reference_array.push(0);

var employment_hist_count = 0;
var employment_his_array = [];
employment_his_array.push(0);

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$(document).ready(function()
{
    $(window).unload(function()
    {
        $.ajax(
            {
                url: '/logout'
            }
        );
    });

    $('#skectch_cur_add').change(function()
    {
        if($(this).val() != '')
        {
            $('#skectch_cur_add_label').text('File is ready to upload');
        }
        else
        {
            $('#skectch_cur_add_label').text('Click to upload sketch');
        }
    });

    $('.if_married').change(function()
    {
        if($('#accnt_civil_status').val() == 'Married' && $('#accnt_gender').val() == 'Female')
        {
            $('#if_married').fadeIn();
        }
        else
        {
            $('#if_married').fadeOut();
        }
    });


    var testing = '0';
    fetchingAutocomplete(testing);

});

function fetchingAutocomplete(employment_hist_count)
{
    $('#employment_mun_'+employment_hist_count+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#employment_mun_id'+employment_hist_count+'').val(ui.item.muniID);
        }
    });

    $('#employment_mun_'+employment_hist_count+'').focusout(function()
    {
        if($(this).val() != '')
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#employment_mun_'+employment_hist_count+'').val()
                    },
                success: function (data)
                {
                    $('#employment_mun_id_'+employment_hist_count+'').val(data[0].province_id);
                    $('#employment_prov_id_'+employment_hist_count+'').val(data[0].id);
                    fetch_present_Pro();

                    setTimeout(function ()
                    {
                        $('#employment_mun_'+employment_hist_count+'').val(data[0].muni_name);
                    },10);
                }
            });
        }
        else
        {
            $('#employment_prov_'+employment_hist_count+'').val('');
        }
    });

    function fetch_present_Pro()
    {
        present_muniID = $('#employment_mun_id_'+employment_hist_count+'').val();
        present_originalMuniID = $('#employment_prov_id_'+employment_hist_count+'').val();
        $.ajax
        ({
            method: 'get',
            url: 'fetch-prov',
            data:
                {
                    'muniID': present_muniID,
                    'originalMuniID': present_originalMuniID
                },
            success: function (data)
            {
                $('#employment_prov_'+employment_hist_count+'').val('');
                $('#employment_prov_'+employment_hist_count+'').val(data[0][0].name);
            }
        });
    }
}

$('#print_endor').click(function()
{
    window.print();
});

$('#accnt_bdate').focusout(function()
{
    var dateInputed = new Date($(this).val()).getTime();
    var now = new Date().getTime();
    var fomulaTime = Math.round((now - dateInputed) / 60000 / 525600);

    $('#accnt_age').val(fomulaTime);
});


$('.add_emergency_contact').click(function()
{
    emergency_contact_count++;
    var add_contact = '<div class="row" id="contact_'+emergency_contact_count+'">\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Name of Reference: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emergency_contact_input_'+emergency_contact_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Relationship: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emergency_contact_input_'+emergency_contact_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Contact Number: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emergency_contact_input_'+emergency_contact_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-12">\n' +
        '                                                        <center>\n' +
        '                                                            <button class="btn btn-sm btn-danger remove_contact" id="remove_contact-'+emergency_contact_count+'" name="'+emergency_contact_count+'" title="Click to remove" style="margin: 7px;"><i class="glyphicon glyphicon-minus"></i></button>\n' +
        '                                                        </center>\n' +
        '                                                    </div>\n' +
        '                                                </div>';

    $('#additional_emergency_contact').append(add_contact);
    emergency_contact_array.push(emergency_contact_count);
});

$('#additional_emergency_contact').on('click', '.remove_contact', function()
{
    var id = parseInt($(this).attr('name'));
    var toRemove = $('#contact_' + id);

    for(var i = 0; i < emergency_contact_array.length; i++)
    {
        if ( emergency_contact_array[i] === id) {
            emergency_contact_array.splice(i, 1);
        }
    }

    toRemove.fadeOut(function()
    {
        toRemove.remove();
    });
});




$('#add_character_reference').click(function()
{
    character_reference_count++;
    var add_reference = '<div class="row" id="ref_'+character_reference_count+'">\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">Name of Reference: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control charactec_ref_input_'+character_reference_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">Relationship: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control charactec_ref_input_'+character_reference_count+'">\n' +
        '                                                    </div>\n' +
        '\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">Company and Position: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control charactec_ref_input_'+character_reference_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">Contact Details: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control charactec_ref_input_'+character_reference_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-12">\n' +
        '                                                        <center>\n' +
        '                                                            <button class="btn btn-sm btn-danger remove_reference" name="'+character_reference_count+'" style="margin: 7px;" title="Click to remove"><i class="glyphicon glyphicon-minus"></i></button>\n' +
        '                                                        </center>\n' +
        '                                                    </div>\n' +
        '                                                </div>';

    $('#additional_char_ref').append(add_reference);
    character_reference_array.push(character_reference_count);
});

$('#additional_char_ref').on('click', '.remove_reference', function()
{
    var id = parseInt($(this).attr('name'));
    var toRemove = $('#ref_' + id);

    for(var i = 0; i < character_reference_array.length; i++)
    {
        if ( character_reference_array[i] === id) {
            character_reference_array.splice(i, 1);
        }
    }

    toRemove.fadeOut(function()
    {
        toRemove.remove();
    });
});

$('#add_emp_hist').click(function()
{
    employment_hist_count++;
    var add_emp_hist = '<div class="row emp_hist_'+employment_hist_count+'">\n' +
        '                                                    <div class="col-md-12">\n' +
        '                                                        <label for="">NAME OF ORGANIZATION: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">Unit #, Bldg/Street, Subd/Brgy.: <small style="color: red;">* Required field</small></label>\n' +
        '                                                        <textarea name="" id="" rows="4" class="form-control emp_input_'+employment_hist_count+'" style="resize: none"></textarea>\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-6">\n' +
        '                                                        <label for="">City/Municipality: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emp_input_'+employment_hist_count+'" id="employment_mun_'+employment_hist_count+'">\n' +
        '                                                        <input type="hidden" id="employment_mun_id_'+employment_hist_count+'">\n' +
        '                                                        <input type="hidden" id="" class="form-control">\n' +
        '                                                        <label for="">Province: <small style="color: orange">* Auto Generated</small></label>\n' +
        '                                                        <input type="text" class="form-control emp_input_'+employment_hist_count+'" id="employment_prov_'+employment_hist_count+'" disabled>\n' +
        '                                                        <input type="hidden" id="employment_prov_id_'+employment_hist_count+'" disabled>\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-12">\n' +
        '                                                    </div>\n' +
        '\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Position (Upon hiring): <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="date" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Position (Upon leaving): <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="date" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Nature of Employment: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <select name="" id="" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                            <option value="-">-</option>\n' +
        '                                                            <option value="Full-Time">Full-Time</option>\n' +
        '                                                            <option value="Part-Time">Part-Time</option>\n' +
        '                                                            <option value="Self-Employed">Self-Employed</option>\n' +
        '                                                            <option value="Internship">Internship</option>\n' +
        '                                                        </select>\n' +
        '                                                    </div>\n' +
        '\n' +
        '                                                    <div class="col-md-5">\n' +
        '                                                        <label for="">Immediate Supervisor: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-3">\n' +
        '                                                        <label for="">Contact Number: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <input type="text" class="form-control emp_input_'+employment_hist_count+'">\n' +
        '                                                    </div>\n' +
        '                                                </div>\n' +
        '                                                <div class="row emp_hist_'+employment_hist_count+'"">\n' +
        '                                                    <div class="col-md-8">\n' +
        '                                                        <label for="">Reason for Leaving: <small style="color: red">* Required field</small></label>\n' +
        '                                                        <textarea name="" id="" rows="4" class="form-control emp_input_'+employment_hist_count+'" style="resize: none;"></textarea>\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-4">\n' +
        '                                                        <label for="">Recuiter Remarks (R/O): <small style="color: red">* Required field</small></label>\n' +
        '                                                        <textarea name="" id="" rows="4" class="form-control emp_input_'+employment_hist_count+'" style="resize: none;"></textarea>\n' +
        '                                                    </div>\n' +
        '                                                    <div class="col-md-12">\n' +
        '                                                        <center>\n' +
        '                                                            <button class="btn btn-sm btn-danger remove_emp_hist" name="'+employment_hist_count+'" style="margin: 7px;"><i class="glyphicon glyphicon-minus"></i></button>\n' +
        '                                                        </center>\n' +
        '                                                    </div>\n' +
        '                                                </div>';

    $('#additional_emp_hist').append(add_emp_hist);
    employment_his_array.push(employment_hist_count);

    fetchingAutocomplete(employment_hist_count);


});

$('#additional_emp_hist').on('click', '.remove_emp_hist', function()
{
    var id = parseInt($(this).attr('name'));
    var toRemove = $('.emp_hist_' + id);

    for(var i = 0; i < employment_his_array.length; i++)
    {
        if ( employment_his_array[i] === id) {
            employment_his_array.splice(i, 1);
        }
    }

    toRemove.fadeOut(function()
    {
        toRemove.remove();
    });
});

$('#accnt_current_orig_muni').autocomplete
({
    source: '/fetch-city-muni',
    minLength: 1,
    select: function (event, ui)
    {
        $('#accnt_current_orig_muni_id').val(ui.item.muniID);
    }
});

$('#accnt_current_orig_muni').focusout(function()
{
    if($(this).val() != '')
    {
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#accnt_current_orig_muni').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#accnt_current_muni_id').val(data[0].province_id);
                $('#accnt_current_orig_muni_id').val(data[0].id);
                fetch_present_Prov();

                setTimeout(function ()
                {
                    $('#accnt_current_orig_muni').val(data[0].muni_name);
                },10);
            }
        });
    }
    else
    {
        $('#accnt_current_muni').val('');
    }
});

function fetch_present_Prov()
{
    present_muniID = $('#accnt_current_muni_id').val();
    present_originalMuniID = $('#accnt_current_orig_muni_id').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': present_muniID,
                'originalMuniID': present_originalMuniID
            },
        success: function (data)
        {
            $('#accnt_current_muni').val('');
            $('#accnt_current_muni').val(data[0][0].name);
        }
    });
}

$('#accnt_perm_orig_muni').autocomplete
({
    source: '/fetch-city-muni',
    minLength: 1,
    select: function (event, ui)
    {
        $('#accnt_perm_orig_muni_id').val(ui.item.muniID);
    }
});

$('#accnt_perm_orig_muni').focusout(function()
{
    if($(this).val() != '')
    {
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#accnt_perm_orig_muni').val()
                },
            success: function (data)
            {
                $('#accnt_perm_muni_id').val(data[0].province_id);
                $('#accnt_perm_orig_muni_id').val(data[0].id);
                fetch_present_Pro1();

                setTimeout(function ()
                {
                    $('#accnt_perm_orig_muni').val(data[0].muni_name);
                },10);
            }
        });
    }
    else
    {
        $('#accnt_perm_muni').val('');
    }
});

function fetch_present_Pro1()
{
    present_muniID = $('#accnt_perm_muni_id').val();
    present_originalMuniID = $('#accnt_perm_orig_muni_id').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': present_muniID,
                'originalMuniID': present_originalMuniID
            },
        success: function (data)
        {
            $('#accnt_perm_muni').val('');
            $('#accnt_perm_muni').val(data[0][0].name);
        }
    });
}

$('.fileSizeCheck').each(function()
{
    var $this = $(this);

    $this.change(function()
    {
        var file_size = $this[0].files[0].size;
        if(file_size  > 26214400)
        {
            $this.val('');
            alert('Cannot upload file that is greater than 25mb');
            return false;
        }
    });
});

$('#submit_endorsement').click(function()
{
    var btn = $(this);
    var emergency_contact_loop_count = 0;
    var eme_data = [];
    var eme_index = 0;
    for(emergency_contact_loop_count = 0; emergency_contact_loop_count < emergency_contact_array.length; emergency_contact_loop_count++)
    {
        var data1 = '';
        eme_index = 0;
        eme_data[emergency_contact_loop_count] = [];
        $('.emergency_contact_input_' + emergency_contact_array[emergency_contact_loop_count] + '').each(function ()
        {
            data1 += $(this).val() + '|-|-|';
        });
        eme_data[emergency_contact_loop_count][eme_index] = data1;
        eme_index++;

    }

    var char_ref_count = 0;
    var char_data = [];
    var char_index = 0;

    for(char_ref_count = 0; char_ref_count < character_reference_array.length; char_ref_count++)
    {
        var data2 = '';
        char_index = 0;
        char_data[char_ref_count] = [];
        $('.charactec_ref_input_'+character_reference_array[char_ref_count]+'').each(function()
        {
            data2 += $(this).val() + '|-|-|';
        });
        char_data[char_ref_count][char_index] = data2;
        char_index++;
    }


    var emp_count = 0;
    var emp_data = [];
    var emp_index = 0;
    for(emp_count = 0; emp_count < employment_his_array.length; emp_count++)
    {
        var data3 = '';
        emp_index = 0;
        emp_data[emp_count] = [];
        $('.emp_input_' +employment_his_array[emp_count]+'').each(function()
        {
            data3 += $(this).val() + '|-|-|';
        });
        emp_data[emp_count][emp_index] = data3;
        emp_index++;
    }

    // console.log([eme_data, char_data, emp_data]);
    $.ajax({
        type: 'get',
        url: 'bi_direct_encoded_account',
        data: {
            'accnt_surname' : $('#accnt_surname').val(),
            'accnt_fname' : $('#accnt_fname').val(),
            'accnt_mname' : $('#accnt_mname').val(),
            'accnt_suffix' : $('#accnt_suffix').val(),
            'accnt_civil_status' : $('#accnt_civil_status').val(),
            'accnt_gender' : $('#accnt_gender').val(),
            'accnt_maiden_lname' : $('#accnt_maiden_lname').val(),
            'accnt_maiden_fname' : $('#accnt_maiden_fname').val(),
            'accnt_maiden_mname' : $('#accnt_maiden_mname').val(),
            'accnt_bday' : $('#accnt_bdate').val(),
            'accnt_age' : $('#accnt_age').val(),
            'accnt_contact_number' : $('#accnt_contact_number').val(),
            'accnt_email_address' : $('#accnt_email_address').val(),
            'sss_num' : $('#sss_num').val(),
            'philhealth_num' : $('#philhealth_num').val(),
            'tin_num' : $('#tin_num').val(),
            'accnt_present_add' : $('#accnt_current_address').val(),
            'accnt_present_prov_id' : $('#accnt_current_orig_muni_id').val(),
            'accnt_present_mun_id' : $('#accnt_current_muni_id').val(),
            'accnt_permanent_add' : $('#accnt_perm_add').val(),
            'accnt_permanent_prov_id' : $('#accnt_perm_orig_muni_id').val(),
            'accnt_permanent_mun_id' : $('#accnt_perm_muni_id').val(),
            'eme_data' : eme_data,
            'char_data' : char_data,
            'emp_data' : emp_data
        },
        success: function(data)
        {
            if(data[0] == 'ok')
            {
                var formData = new FormData();

                formData.append('file_1',$('#attach1').prop('files')[0]);
                formData.append('file_2',$('#attach2').prop('files')[0]);
                formData.append('file_3',$('#attach3').prop('files')[0]);
                formData.append('file_4',$('#attach4').prop('files')[0]);
                formData.append('id',data[1]);
                // window.location.reload();


                uploadAttachEndo(formData);
            }
        }
    });


    // if(fields_checking == true)
    // {
    //     btn.attr('disabled', true);
    // }
    // else
    // {
    //     btn.attr('disabled', false);
    // }

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
        url: 'bi_direct_encoded_account_upload',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        beforeSend: function()
        {
            $('#modal_loading').modal('show');
        },
        success: function (data)
        {
            $('#ulPercentage_attachment').html('');
            $('#progressbar_attachment').hide();

            setTimeout(function () {
                $('#modal_loading').modal('hide');
            },1000);
            setTimeout(function () {
                $('#modal_success').modal('show');
            },1500);
            console.log(data);
        },
        error: function()
        {
            $('#submit_endorsement').attr('disabled', false);
            setTimeout(function () {
                $('#modal_loading').modal('hide');
            },500);
            setTimeout(function () {
                $('#modal_error').modal('show');
            },1000);
        }
    });
}
