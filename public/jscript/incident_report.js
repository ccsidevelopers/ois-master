var itemCounterIncident = [];


console.log('test');

incidentFine();
function incidentFine()
{

    var datenow = new Date();
    var month = (parseInt(datenow.getMonth()) + 1);
    var day = datenow.getDate();
    if(month < 10)
    {
        month = '0' + month;
    }

    if(day < 10)
    {
        day = '0' + day;
    }

    var dateNow = datenow.getFullYear() + '' + month + '' + day + '' + datenow.getHours() + '' + datenow.getMinutes() + '' + datenow.getSeconds() + '' + datenow.getMilliseconds();
    var dateNowAjax = datenow.getFullYear() + '' + month + '' + day;

    $('#incident-fine').html('');

    fineupload = new $('#incident-fine').fineUploader
    ({
        template: 'qq-incident-template-manual-trigger',
        request:
            {
                endpoint: 'incident_report_fineuploader/' + dateNow,
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
                itemLimit: 5,
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
                        itemCounterIncident.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        itemCounterIncident.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    $('#btn_send_incident').attr('disabled', false);

                    itemCounterIncident = [];

                    $.ajax
                    ({
                        type: 'get',
                        url: 'incident_report_info',
                        data:
                            {
                                'unang_folder' : dateNowAjax,
                                'pangalawang_folder' : dateNow,
                                'rem' : $('#incident_rep_rem').val()
                            },
                        success: function(data)
                        {
                            $('#modal-incident-report').modal('hide');
                            alert('Successfully submitted the report.');
                        },
                        error: function(e)
                        {
                            console.log(e);
                            alert('Incident report failed to upload. Contact administrator for assistance');
                        }
                    });

                    incidentFine();
                    // setTimeout(function()
                    // {
                    //     $('#wait-loading').modal('hide');
                    //     submittedFilesArray = [];
                    // }, 500);
                    //
                    // alert('Encoded Successfully');
                    //
                    // setTimeout(function()
                    // {
                    //     window.location.reload();
                    // }, 1000);
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

$('#btn_send_incident').click(function()
{
    var rem = $('#incident_rep_rem').val();
    var btn = $(this);

    if(rem != '')
    {
        if(itemCounterIncident.length > 0)
        {
            btn.attr('disabled', true);
            $('#incident-fine').fineUploader('uploadStoredFiles');
        }
        else
        {
            alert('Please select photo regarding the incident remarks.')
        }
    }
    else
    {
        alert('Please add report remarks!');
    }
});





