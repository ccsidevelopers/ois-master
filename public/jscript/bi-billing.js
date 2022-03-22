var billing_cc = '';
var billing_cc_bool = false;

function getBillingTable()
{
    $('#cc_billing_information_table thead tr th').each(function()
    {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    billing_cc = $('#cc_billing_information_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'bi_client_billing_information_table',
        "columns":
            [
                {data: 'invoice_number', name: 'billing_invoice.id', ordering: false},
                {data: 'amount', name: 'billing_invoice.id', searchable: false, ordering: false},
                {data: 'billing_period', name: 'billing_invoice.id', ordering: false},
                {data: 'status', name: 'billing_invoice.invoice_status', ordering: false},
                {
                    data: function action(data)
                    {
                        if(data.status == 'UNPAID')
                        {
                            return '<button class="btn btn-info cc_billing_pay_btn" id="'+data.invoice_number+'" href="'+btoa(data.amount)+'"><i class="fa fa-paypal"></i> Pay Now</button>';
                        }
                        else
                        {
                            return '<button class="btn btn-success" disabled><i class="fa fa-paypal"></i> PAID</button>';
                        }
                    },
                    searchable: false,
                    ordering: false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
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

    $('#cc_billing_information_table_filter input').unbind();
    $('#cc_billing_information_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                billing_cc.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    billing_cc.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#cc_billing_information_table').on('click', '.cc_billing_pay_btn',function(e)
{
    var btn = $(this);
    var invoice_id = $(this).attr('id');
    var amount = atob($(this).attr('href')).split(' ')[0];
    btn.attr('disabled', true);
    $('#payment-holder-div').html('');
    $('#client_account_view_holder tbody tr').each(function()
    {
        $(this).remove();
    });

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
                        value: amount
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

                    var dataHolder = details;
                    var timestamps = dataHolder.create_time[0];
                    var tr_id = dataHolder.purchase_units[0].payments.captures[0].id;

                    $.ajax({
                        type: 'get',
                        url: 'bi_client_billing_success_payment',
                        data: {
                            'invoice_id' : invoice_id,
                            'timestamp' : timestamps,
                            'transaction_id' : tr_id
                        },
                        success: function(data)
                        {
                            if(data == 'success')
                            {
                                $('#modal-bi-paynow').modal('hide');
                                alert('Payment Successfully Processed. Thank you');
                                billing_cc.draw();
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
    }).render('#payment-holder-div').then(function()
    {
        $('#modal-bi-paynow').modal('show');
        btn.attr('disabled', false);

        $.ajax({
            type: 'get',
            url: 'bi_client_billing_selected_accounts',
            data: {
                'invoice_id' : invoice_id
            },
            success: function(data)
            {
                var toAppendData = '';
                if(data[1].length > 0)
                {
                    if(data[1][0].invoice_type != 'cc')
                    {
                        if(data[1].length > 0)
                        {
                            $('#client_billing_num').text(data[1][0].invoice_id);
                            $('#client_billing_period').text(data[0]);
                            $('#client_billing_total').text(data[2]);
                            for(var i =0; i < data[1].length; i++)
                            {
                                toAppendData += '<tr>\n' +
                                    '                                    <td>'+data[1][i].account_name+'</td>\n' +
                                    '                                    <td>'+data[1][i].tor+'</td>\n' +
                                    '                                    <td>'+data[1][i].amount+' PHP</td>\n' +
                                    '                                    <td>Endorse via OIMS</td>\n' +
                                    '                                </tr>';
                            }
                        }
                    }
                    else
                    {
                        if(data[1].length > 0)
                        {
                            $('#client_billing_num').text(data[1][0].invoice_id);
                            $('#client_billing_period').text(data[0]);
                            $('#client_billing_total').text(data[2]);
                            for(var j =0; j < data[1].length; j++)
                            {
                                toAppendData += '<tr>\n' +
                                    '                                    <td>'+data[1][j].account_name+'</td>\n' +
                                    '                                    <td>'+data[1][j].address+'</td>\n' +
                                    '                                    <td>'+data[1][j].amount+' PHP</td>\n' +
                                    '                                    <td>Endorse via OIMS</td>\n' +
                                    '                                </tr>';
                            }
                        }
                    }
                }

                if(data[3].length > 0)
                {
                    $('#client_billing_num').text(data[3][0].invoice_id);
                    $('#client_billing_period').text(data[0]);
                    $('#client_billing_total').text(data[2] + ' PHP');

                    if(data[3][0].account_name != null)
                    {
                        var holderVar = '';
                        for(var k =0; k < data[3].length; k++)
                        {
                            if(data[3][k].address == 'N/A')
                            {
                                holderVar = data[3][k].type_of_request;
                            }
                            else {
                                holderVar = data[3][k].address;

                            }

                            toAppendData += '<tr>\n' +
                                '                                    <td>'+data[3][k].account_name+'</td>\n' +
                                '                                    <td>'+holderVar+'</td>\n' +
                                '                                    <td>'+data[3][k].amount+' PHP</td>\n' +
                                '                                    <td>Endorse via Email</td>\n' +
                                '                                </tr>';
                        }
                    }
                }

                $('#client_account_view_holder tbody').append(toAppendData);

            },
            error: function(e)
            {
                alert('Error occurred. Contact web administrator for assistance. Thank you');
            }
        });
    });

});