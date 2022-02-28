var dataHolder = {};

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$(window).ready(function()
{
    if($('#token_holder').length > 0)
    {
        var formDataaa = new FormData();
        var _token = $('#token_holder').attr('token');
        formDataaa.append('token', _token);
        $(window).on('load', function()
        {
            setTimeout(function(){
                $.ajax({
                    type: 'post',
                    url: 'paypal-token-redirect',
                    data: formDataaa,
                    processData: false,
                    contentType: false,
                    success: function(data)
                    {
                        if(data[0] == 'success')
                        {
                            console.log(data);
                            $('#token_button').click();
                        }
                        else
                        {
                            alert('Page cannot load token is invalid');
                        }
                    }
                });
            },3000);
        });
    }
    else {
        $('.select2').select2();
    }
});

$('#proceed').click(function()
{
    var validated = true;
    var toShow = '';

    $('.infos').each(function()
    {
        dataHolder[$(this).attr('name')] = $(this).val();

        if($(this).attr('type') != 'email')
        {
            if($(this).attr('name') == 'phonenumber')
            {
                var valval = $(this).val();
                if(valval.length < 11)
                {
                    toShow += 'Entered Mobile number is invalid. ';
                    validated = false;
                    $(this).attr('style', 'border-color: #fa89a6;');
                    return false;
                }
                else
                {
                    validated = true;
                    $(this).removeAttr('style');
                    return true;
                }
            }
            else
            {
                if($(this).val() != '')
                {
                    validated = true;
                    return true;
                }
                else if($(this).val() == '')
                {
                    validated = false;
                    toShow += 'Fill-up all fields. ';
                    $(this).attr('style', 'border-color: #fa89a6;');
                    return false;
                }
            }
        }
        else
        {
            if($(this).attr('type') == 'email')
            {
                if( /(.+)@(.+){2,}\.(.+){2,}/.test($(this).val()) ){
                    validated = true;
                    return true;
                }
                else
                {
                    validated = false;
                    toShow += 'Email entered is not valid. ';
                    return false;
                }
            }
        }
    });

    if(!validated)
    {
        $('#toShowError').html(toShow);
        $('#modal-error').modal('show');
    }
    else
    {
        $('#paypal-button').html('');
        // PAYPAL PROCESS
        paypal.Buttons({
            style: {
                size: 'responsive',
                shape: 'pill',
                label:  'pay',
                layout: 'horizontal',
                fundingicons: 'false',
                tagline: 'true'
            },
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: dataHolder["amount"]
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {

                    if (details.error === 'INSTRUMENT_DECLINED') {
                        return actions.restart();
                    }
                    else {

                        var infoHoder = details;
                        var timestamps = infoHoder.create_time[0];
                        var amount = dataHolder["amount"];
                        var tr_id = infoHoder.purchase_units[0].payments.captures[0].id;
                        var name = dataHolder["name"];
                        var address = dataHolder["address"];
                        var email = dataHolder["email"];
                        var payment_desc = dataHolder["payment_desc"];
                        var country = dataHolder["country"];

                        $.ajax({
                            type: 'get',
                            url: '../paypal-success-payment-func',
                            data: {
                                'amount_paid' : amount,
                                'payee_name' : name,
                                'payee_address' : address,
                                'timestamp' : timestamps,
                                'payee_email' : email,
                                'payee_payment_desc' : payment_desc,
                                'country' : country,
                                'transaction_id' : tr_id
                            },
                            success: function(data)
                            {
                                if(data == 'success')
                                {
                                    $('#modal-payment-thru-paypal').modal('hide');
                                    $('#paypal-button').html('');
                                    $('#infos').slideUp('slow');
                                    $('.infos').val('');
                                    $('#modal-success-payment').modal('show');
                                    $('#transaction_id').html(tr_id);
                                }

                            },
                            error: function(e)
                            {
                                alert('Error occurred. Please contact website administrator for assistance. Thank you!');
                            }
                        });
                        // This function shows a transaction success message to your buyer.
                        // alert('Transaction completed by ' + details.payer.name.given_name);
                    }
                });
            }
        }).render('#paypal-button').then(function()
        {
            $('#modal-payment-thru-paypal').modal('show');
        });

        // PAYPAL PROCESS END
    }
});