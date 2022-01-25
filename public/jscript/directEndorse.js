$(window).unload(function()
{
    $.ajax(
        {
            url: '/logout'
        }
    );
});

$('#btn_transaction_view').click(function()
{
    $('#btnLink').html('');
    var what_show = '';
    $('#direct_accnt_name').text('');
    $('#type_of_request').text('');
    $('#type_of_loan').text('');
    $('#accnt_name').text('');
    $('#accnt_address').text('');
    $('#tr_id').text('');
    var trnum = $('#transaction_number').val();

    $.ajax(
        {
            type: 'get',
            url: 'view_account_transaction',
            data: {
                'tn' : trnum
            },
            success : function(data)
            {
                if(data == '')
                {
                    $('#error').fadeIn();

                    setTimeout(function()
                    {
                        $('#error').fadeOut();
                    }, 3000);
                }
                else
                {
                    if(data[2] == 'bi')
                    {
                        what_show = 'bi';
                        $('#for_bank').attr('display', 'none');
                        console.log(what_show);
                        $('#for_bank').hide();

                        if(data[0][0].status != 10)
                        {
                            $('#direct_status').text('Pending / On-Process');
                        }
                        else
                        {
                            $('#direct_status').text('Completed');
                            $('#btnLink').html('<div class="row">\n' +
                                '                                    <div class="col-md-12">\n' +
                                '                                        <div class="col-md-4"></div>\n' +
                                '                                        <div class="col-md-4">\n' +
                                '                                            <a href="dl-rep?code='+data[1]+'&code2=bi" target="_blank" class="btn btn-success btn-block" style="margin: 10px;">Download Report</a>\n' +
                                '                                        </div>\n' +
                                '                                        <div class="col-md-4"></div>\n' +
                                '                                    </div>\n' +
                                '                                </div>');
                        }

                        $('#direct_accnt_name').text(', '+ data[0][0].account_name);
                        $('#type_of_request').text( data[0][0].type_of_request);
                        $('#type_of_loan').text(data[0][0].type_of_loan);
                        $('#accnt_name').text(data[0][0].account_name);
                        $('#accnt_address').text(data[0][0].address + ', ' + (data[0][0].muni_name).toUpperCase());
                        $('#tr_id').text(data[0][0].paypal_tr_id);
                    }
                    else if(data[2] == 'bank')
                    {
                        $('.for_bank').show();
                        what_show = 'bank';
                        console.log(what_show);
                        $('#for_bank').attr('display', 'block');
                        $('#for_bank').show();



                        if(data[0][0].date_forwarded_to_client == '0000-00-00')
                        {
                            $('#direct_status').text('Pending / On-Process');
                        }
                        else
                        {
                            $('#direct_status').text('Completed');
                            $('#btnLink').html('<div class="row">\n' +
                                '                                    <div class="col-md-12">\n' +
                                '                                        <div class="col-md-4"></div>\n' +
                                '                                        <div class="col-md-4">\n' +
                                '                                            <a href="dl-rep?code='+data[1]+'&code2=bank" target="_blank" class="btn btn-success btn-block" style="margin: 10px;">Download Report</a>\n' +
                                '                                        </div>\n' +
                                '                                        <div class="col-md-4"></div>\n' +
                                '                                    </div>\n' +
                                '                                </div>');
                        }

                        $('#direct_accnt_name').text(', '+ data[0][0].account_name);
                        $('#type_of_request').text( data[0].type_of_request);
                        $('#type_of_loan').text(data[0][0].type_of_loan);
                        $('#accnt_name').text(data[0][0].account_name);
                        $('#accnt_address').text(data[0][0].address + ', ' + (data[0][0].muni_name).toUpperCase());
                        // $('#accnt_address').text(data[0].address + ', ' + (data[0].muni_name).toUpperCase());
                        $('#tr_id').text(data[0][0].paypal_tr_id);
                    }
                    $('#modal-transact').modal('show');
                }
            },
            error : function()
            {
                $('#error').fadeIn();

                setTimeout(function()
                {
                    $('#error').fadeOut();
                }, 3000);
            }
        }
    );
});
