$.ajaxSetup
({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#SuggestionSubmit').click(function () {

    var getmessage = $('#textareasuggestion').val();
    var gettitle = $('#TitleSuggestion').val();
    var idofclient = $('#report_issue').attr('name');


    $.ajax({
        url: '/gen-savesuggestion',
        type: 'get',
        data:
            {
                'getmessage': getmessage,
                'gettitle': gettitle,
                'id': idofclient
            },
        dataType: 'json',
        beforeSend: function () {
            $('#SuggestionSubmit').html('Please Wait...');
            $('#SuggestionSubmit').attr('disabled', 'disabled');
        },
        success: function (data) {

            alert("Suggestion/Reports Saved! Thank You for you cooperation.");
            // console.log('Suggestion/Reports saved');
            $('#TitleSuggestion').val('');
            $('#closesuggestion').click();
        },
        error: function (data) {
            // console.log('error');
        },
        complete: function () {
            $('#SuggestionSubmit').html('Submit');
            $('#SuggestionSubmit').removeAttr('disabled');
        }
    });

});
//

$(document).ready(function () {
    // var seedfunction = false;
    // getgetpolls();


});

// function getgetpolls() {
//
//     $('#getpolls').html('');
//
//     var getpollid = 0;
//     var yourvotes = 0;
//     var maxvotes = 0;
//     $.ajax({
//         url: '/gen-getpolls',
//         type: 'get',
//         data:
//             {
//                 'id': 1
//             },
//         dataType: 'json',
//         success: function (data) {
//             var getquestions = '';
//
//             // console.log(data);
//             for (var ctr = 0; ctr < data[0].length; ctr++) {
//
//
//                 if (data[0][ctr].isClosed === 0) {
//                     maxvotes = data[0][ctr].maxCheck;
//                     getpollid = data[0][ctr].id;
//                     var gettiigpolls = '';
//                     var iii = 1000;
//
//                     for (var i = 0; i < data[1].length; i++) {
//                         if (data[2].length === 0) {
//                             if (data[0][ctr].id === data[1][i].poll_id) {
//                                 gettiigpolls += '                            <li class="list-group-item">\n' +
//                                     '                                    <div class="checkbox">\n' +
//                                     '                                        <label>\n' +
//                                     '                                            <input  name="checkbox" type="checkbox" value="' + data[1][i].name + '">\n' +
//                                     data[1][i].name +
//                                     '                                        </label>\n' +
//                                     '                                    </div>\n' +
//                                     '                                </li>';
//                             }
//                         }
//                         else {
//                             if (data[0][ctr].id === data[1][i].poll_id) {
//
//                                 for (var ii = 0; ii < data[2].length; ii++) {
//                                     if (data[1][i].id === data[2][ii].option_id) {
//                                         gettiigpolls += '                            <li class="list-group-item">\n' +
//                                             '                                    <div class="checkbox">\n' +
//                                             '                                        <label>\n' +
//                                             '                                            <input disabled checked name="checkboxx" type="checkbox" value="' + data[1][i].name + '">\n' +
//                                             data[1][i].name +
//                                             '                                        </label>\n' +
//                                             '                                    </div>\n';
//                                         iii = i;
//                                     }
//                                 }
//                                 // console.log(i);
//                                 // console.log(iii);
//                                 if (iii === 1000) {
//                                     gettiigpolls += '                            <li class="list-group-item">\n' +
//                                         '                                    <div class="checkbox">\n' +
//                                         '                                        <label>\n' +
//                                         '                                            <input  name="checkbox" type="checkbox" value="' + data[1][i].name + '">\n' +
//                                         data[1][i].name +
//                                         '                                        </label>\n' +
//                                         '                                    </div>\n' +
//                                         '                                </li>';
//                                 }
//                                 else if (i === iii) {
//                                     // console.log('nothing to do');
//                                     // console.log('check i:'+i);
//
//                                 }
//                                 else {
//                                     gettiigpolls += '                            <li class="list-group-item">\n' +
//                                         '                                    <div class="checkbox">\n' +
//                                         '                                        <label>\n' +
//                                         '                                            <input  name="checkbox" type="checkbox" value="' + data[1][i].name + '">\n' +
//                                         data[1][i].name +
//                                         '                                        </label>\n' +
//                                         '                                    </div>\n' +
//                                         '                                </li>';
//                                 }
//                             }
//                         }
//
//                     }
//                     // console.log('i:' + i);
//
//
//                     //checkifvoteisexisted
//                     $.ajax({
//                         url: '/gen-getexistvotes',
//                         type: 'get',
//                         data:
//                             {
//                                 'poll_id': data[0][ctr].id
//                             },
//                         success: function (dataa) {
//
//                             // console.log(dataa);
//                             yourvotes = dataa;
//
//
//                         },
//                         error: function (dataa) {
//                             // console.log('error');
//                         }
//                     });
//
//
//                     // console.log(yourvotes);
//                     getquestions += '     <div class="panel panel-primary">\n' +
//                         '                        <div class="panel-heading">\n' +
//                         '                            <h3 class="panel-title">\n' +
//                         '                                <span class="glyphicon glyphicon-hand-right"></span> ' + data[0][ctr].question + ' (Maximum vote/s : ' + (maxvotes) + ')</span></h3>\n' +
//                         '                        </div>\n' +
//                         '                        <div class="panel-body">\n' +
//                         '                            <ul class="list-group">\n' + gettiigpolls +
//                         '                            </ul>\n' +
//                         '                            <div class="input-group input-group-sm">\n' +
//                         '                                <input type="text" id="txtNewpoll" class="form-control">\n' +
//                         '                                <span class="input-group-btn">\n' +
//                         '                      <button type="button" id="btnNewpoll" class="btn btn-info btn-flat">Add Poll</button>\n' +
//                         '                    </span>\n' +
//                         '                            </div>\n' +
//                         '                        </div>\n' +
//                         '                        <div class="panel-footer text-center">\n' +
//                         '                            <button type="button" id="btnSubmit" class="btn btn-primary btn-block btn-sm">\n' +
//                         '                                Vote</button>\n' +
//                         '                            <a href="#" class="small">View Result</a></div>\n' +
//                         '                    </div>';
//
//                     $('#getpolls').append(getquestions);
//                     // console.log(getquestions);
//
//                     $('#btnSubmit').click(function () {
//
//
//                         if (yourvotes >= maxvotes) {
//                             alert("You already consumed all of your vote.");
//                         }
//                         else {
//                             vote(getpollid, maxvotes);
//
//                         }
//
//                     });
//                     $('#btnNewpoll').click(function () {
//
//                         // console.log($('#txtNewpoll').val());
//
//                         if (yourvotes >= maxvotes) {
//                             alert("You already consumed all of your vote.");
//                         }
//                         else {
//                             var str_newPoll = $('#txtNewpoll').val();
//                             if ((jQuery.trim(str_newPoll)).length === 0) {
//                                 alert("No text is detected.");
//
//                             }
//                             else {
//                                 if (confirm('Are you sure you want to add \"' + str_newPoll + '\" to the poll?')) {
//
//                                     // console.log("voted");
//
//                                     //gen-addpolls
//                                     $.ajax({
//                                         url: '/gen-addpolls',
//                                         type: 'get',
//                                         data:
//                                             {
//                                                 'newPoll': str_newPoll,
//                                                 'poll_id': getpollid
//                                             },
//                                         success: function (data) {
//
//                                             getgetpolls();
//
//                                         },
//                                         error: function (data) {
//                                             // console.log('error');
//                                         }
//                                     });
//
//                                 } else {
//                                     // console.log("You pressed Cancel!");
//                                 }
//                             }
//                         }
//
//                     });
//                 }
//                 else {
//                     getquestions += ' ';
//
//                 }
//             }
//         },
//         error: function (data) {
//             // console.log('error');
//         }
//     });
//
// }

// function vote(pollid, getmax) {
//
//     var arrayvotes = [];
//     var arrayvotesx = [];
//     var checkboxes = document.querySelectorAll('input[name=checkbox]:checked');
//     var checkboxesx = document.querySelectorAll('input[name=checkboxx]:checked');
//
//     for (var a = 0; a < checkboxes.length; a++) {
//         arrayvotes.push(checkboxes[a].value)
//     }
//     for (var b = 0; b < checkboxesx.length; b++) {
//         arrayvotesx.push(checkboxesx[b].value)
//     }
//     var getalreadyvote = arrayvotesx.length;
//     //votepolls
//
//     // console.log(arrayvotes);
//
//     if (arrayvotes.length + getalreadyvote > getmax) {
//         alert('You have only ' + getmax + ' votes.');
//
//     }
//     else {
//         $.ajax({
//             url: '/gen-votepolls',
//             type: 'get',
//             data:
//                 {
//                     'votePoll': arrayvotes,
//                     'poll_id': pollid
//                 },
//             success: function (data) {
//
//                 getgetpolls();
//
//             },
//             error: function (data) {
//                 // console.log('error');
//             }
//         });
//     }
//
//     // console.log(arrayvotes);
//
// }

function notifs()
{
    $.ajax({
        type: 'post',
        url: 'user-notification-srao-dispatcher',
        data:
            {
                'id': '1'
            },
        success: function (data)
        {
            // $('#notifcount_notif').html("10");
            var info_notif = '';
            var countnotif = 0;
            // console.log(data);
            if (data[1] === 1) {
                //if dispatcher
                var plus = '';
                // console.log(data);
                for (var ctr = 0; ctr < data[0].length; ctr++) {

                    // console.log(data[ctr]);

                    if(ctr < 1000)
                    {
                        countnotif++;
                        info_notif += '' +

                            '                                <li title="' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name + '" >' +
                            '                                    <a id="' + data[0][ctr].id + '" name="' + data[0][ctr].account_name + '" href="#">' +
                            '                                        <i class="fa fa-warning text-yellow" style="white-space:normal;"></i>' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name +
                            '                                    </a>' +
                            '                                </li>';

                    }
                    else if(ctr == 1000)
                    {
                        plus = '+';
                    }
                    else
                    {
                        break;
                    }

                }

                var ids = [];
                var incre = 0;
                $('#table-advance-fund-checker tr td span#realtimefund_disp').each(function () {

                    ids[incre] = $(this).attr('name');

                    incre++;
                });
                // console.log('allids: '+ids);

                $.ajax({
                    'url': '/dispatcher-get-realtime-fund-ci',
                    'type': 'get',
                    'data':
                        {
                            'ids': ids
                        },
                    'dataType': 'json',
                    success : function (data) {

                        // console.log(data);
                        for(ctr = 0; ctr<data.length; ctr++) {

                            for(i = 0; i<data[ctr].length; i++){

                                if(data[ctr][i].fund_realtime != '')
                                {
                                    $('#table-advance-fund-checker tr td span#realtimefund_disp').each(function () {

                                        if($(this).attr('name') == data[ctr][i].user_id)
                                        {
                                            $(this).html(data[ctr][i].fund_realtime);
                                        }

                                    });
                                }
                            }
                        }

                    },
                    error : function (data) {
                        console.log('error');
                    }
                });

                $('#notifcount_notif').html(countnotif+plus);
                $('#notifcount_notif_label').html(' There are ' + countnotif+plus + ' endorsements to dispatch!');
                $('#notifcount_notif_info').html(info_notif);
                $('#viewallhref').attr('href','/dispatcher-dispatch-account')

            }
            else if (data[1] === 2)
            {
                //if srao
                var plus = '';
                for (var ctr = 0; ctr < data[0].length; ctr++) {

                    if(ctr < 1000) {
                        countnotif++;
                        info_notif += '' +

                            '                                <li title="' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name + '" >' +
                            '                                    <a id="' + data[0][ctr].id + '" name="' + data[0][ctr].account_name + '" href="#">' +
                            '                                        <i class="fa fa-warning text-yellow" style="white-space:normal;"></i>' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name +
                            '                                    </a>' +
                            '                                </li>';
                    }
                    else if(ctr == 1000)
                    {
                        plus = '+';
                    }
                    else
                    {
                         break;
                    }
                }

                console.log(data[3]);
                $('#srao_fund_req_notif').html('<span class="label label-warning pull-right">'+data[3]+'</span>');
                $('#notifcount_notif').html(countnotif+plus);
                $('#notifcount_notif_label').html(' There are ' + countnotif+plus + ' endorsements to assign!');
                $('#notifcount_notif_info').html(info_notif);
                $('#viewallhref').attr('href','/sao-assign-account')


            }
            else if (data[1] === 3)
            {
                //if ao
                var plus = '';
                for (var ctr = 0; ctr < data[0].length; ctr++)
                {


                    if(ctr < 1000) {
                        countnotif++;
                        info_notif += '' +

                            '                                <li title="' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name + '" >' +
                            '                                    <a id="' + data[0][ctr].id + '" name="' + data[0][ctr].date_endorsed + '" href="#">' +
                            '                                        <i class="fa fa-warning text-yellow" style="white-space:normal;"></i>' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name +
                            '                                    </a>' +
                            '                                </li>';
                    }
                    else if(ctr == 1000)
                    {
                        plus = '+';
                    }
                    else
                    {
                        break;
                    }

                }

                for (var ctr1 = 0; ctr1 < data[2].length; ctr1++)
                {
                    if (data[2][ctr1].acct_status == 3 && data[2][ctr1].ci_cert == 'NC')
                    {

                        info_notif += '' +

                            '                                <li title="' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name + '" >' +
                            '                                    <a id="' + data[2][ctr1].id + '" name="' + data[2][ctr1].date_endorsed + '" href="#tab_2">' +
                            '                                        <i class="fa fa-check-square text-green" style="white-space:normal;"></i>' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name +
                            '                                    </a>' +
                            '                                </li>';

                    }
                    else if (data[2][ctr1].ci_cert == 'NC')
                    {
                        countnotif++;
                        info_notif += '' +

                            '                                <li title="' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name + '" >' +
                            '                                    <a id="' + data[2][ctr1].id + '" name="' + data[2][ctr1].date_endorsed + '" href="#tab_2">' +
                            '                                        <i class="fa fa-file text-blue" style="white-space:normal;"></i>' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name +
                            '                                    </a>' +
                            '                                </li>';
                    }
                    else if (data[2][ctr1].acct_status == 3 && data[2][ctr1].ci_cert == 'C')
                    {
                        info_notif += '' +

                            '                                <li title="' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name + '" >' +
                            '                                    <a id="' + data[2][ctr1].id + '" name="' + data[2][ctr1].date_endorsed + '" href="#tab_2">' +
                            '                                        <i class="fa fa-check-square text-green" style="white-space:normal;"></i>' + data[2][ctr1].client_name + ' : ' + data[2][ctr1].account_name +
                            '                                    </a>' +
                            '                                </li>';
                    }
                }

                $('#notifcount_notif').html(countnotif+plus);
                $('#notifcount_notif_label').html(' There are ' + countnotif+plus + ' endorsements to submit!');
                $('#notifcount_notif_info').html(info_notif);
            }
            else if (data[1] === 4)
            {
                var plus = '';
                //if ci
                // console.log(data);

                for (var ctr = 0; ctr < data[0].length; ctr++) {

                    if(ctr < 1000)
                    {
                        countnotif++;
                        info_notif += '' +

                            '                                <li title="' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name + '" >' +
                            '                                    <a id="' + data[0][ctr].id + '" name="' + data[0][ctr].account_name + '" href="#">' +
                            '                                        <i class="fa fa-warning text-yellow" style="white-space:normal;"></i>' + data[0][ctr].client_name + ' : ' + data[0][ctr].account_name +
                            '                                    </a>' +
                            '                                </li>';
                    }
                    else if(ctr == 1000)
                    {
                        plus = '+';
                    }
                    else
                    {
                        break;
                    }
                }

                // var tominus = 0;
                //
                // for(var q = 0; q < data[7].length; q++)
                // {
                //     tominus = (tominus+parseInt(data[7][q].liquidated_amount));
                // }
                // console.log('tominus : '+tominus);
                $('#realtimefund').html('Current Fund: ₱ '+(data[11]));
                $('#realtimefund').attr('name',(data[11]));
                $('#notifcount_notif').html(countnotif+plus);
                $('#notifcount_notif_label').html(' There are ' + countnotif+plus + ' endorsements to investigate!');
                $('#notifcount_notif_info').html(info_notif);
                $('#viewallhref').attr('href','/ci-endorse');

                var getlogs = '';
                for(var t = 0; t < data[8].length; t++)
                {
                    getlogs += '<tr style="white-space: normal"><th>'+data[8][t].datetime+'</th>' +
                        '<th>'+data[8][t].activity+'</th></tr>';
                }

                var topFund = '<h5>Total Fund : ₱ '+data[6]+'</h5>' +
                    '<h5>Current Fund : ₱ ' + data[11] +'</h5>' +
                    '<h5>On-Hold Fund : ₱ ' + data[10] + '</h5>' +
                    '<h5>Unliquidated Fund : ₱ ' +data[12]+ '</h5>' ;

                $('#ci_fund_logs_table').html('' +
                    topFund +
                    '                    <table style="font-size: 13px" width="100%">\n' +
                    '                        <thead>\n' +
                    '                        <tr>\n' +
                    '                            <th>Date:</th>\n' +
                    '                            <th>Logs:</th>\n' +
                    '                        </tr>\n' +
                    getlogs +
                    '                        </thead>\n' +
                    '                    </table>' +
                    '');
            }
            else
                {
                $('#notifcount_notif').html(0);
                $('#notifcount_notif_label').html('No notification available');
                $('#notifcount_notif_info').html(
                    '                                <li title="No notification available" >' +
                    '                                    <a href="#">' +
                    '                                        <i class="fa fa-envelope" style="white-space:normal;"></i>No notification available' +
                    '                                    </a>' +
                    '                                </li>');
            }
            if(data[5] !== 0)
            {
                if(window.location.href.indexOf("ci-fund-receive") > -1)
                {
                    $('#notifcount_fund_ci_tab').html('<span class="label label-warning pull-right">!</span>');
                }
                else
                {
                    $('#notifcount_fund_ci_header').html('<span class="label label-warning pull-right">!</span>');
                    $('#notifcount_fund_ci_leftsidebar').html('<span class="label label-warning pull-right">!</span>');
                }
            }
            // }

            $('#finance_fund_req_notif').html('<small class="label label-info pull-right">'+data[4]);
            // $('#finance_fund_req_notif_doubs').html('<span class="label label-warning pull-right">'+data[3]+'</span>');
            $('#finance_fund_req_notif_approved_doubs').html('<span class="label label-info pull-right">'+data[4]+'</span>');
            // console.log(data[5]);


        },
        error: function () {
            // console.log('error');
        },
        complete: function (data) {


            // console.log(data.responseJSON);
            for (var ctr = 0; ctr < data.responseJSON[0].length; ctr++) {
                $('#' + data.responseJSON[0][ctr].id + '').click(function () {

                    // console.log($(this).attr('id'));

                    var tosearch = $(this).attr('id');
                    var tosearchname = $(this).attr('name');
                    // $('#SearchingID').val(tosearch);


                    $('#clicktab1').click();

                    $('#endorsement-table').DataTable().search(tosearch).draw();
                    $('#endorsement-tablee').DataTable().search(tosearch).draw();

                    $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
                    $("#datepickermax").datepicker({dateFormat: 'yy-mm-dd'});

                    $('#datepicker').val(tosearchname);
                    $('#datepickermax').val(tosearchname);


                    $('#min').val(tosearchname);
                    $('#max').val(tosearchname);
                    // $('#ao-finish-endorsement').DataTable().search(tosearch).draw();

                    $('#ao-new-endorsement').DataTable().search(tosearch).draw();

                    $('#ci-table').DataTable().search(tosearch).draw();
                });
            }

            for (var ctr1 = 0; ctr1 < data.responseJSON[2].length; ctr1++) {
                $('#' + data.responseJSON[2][ctr1].id + '').click(function () {

                    // console.log($(this).attr('id'));

                    var tosearch = $(this).attr('id');
                    var tosearchname = $(this).attr('name');
                    // $('#SearchingID').val(tosearch);

                    $('#clicktab2').click();


                    $("#datepickerminFinish").datepicker({dateFormat: 'yy-mm-dd'});
                    $("#datepickermaxFinish").datepicker({dateFormat: 'yy-mm-dd'});

                    $('#datepickerminFinish').val(tosearchname);
                    $('#datepickermaxFinish').val(tosearchname);

                    $('#minFinish').val(tosearchname);
                    $('#maxFinish').val(tosearchname);

                    $('#ao-finish-endorsement').DataTable().search(tosearch).draw();

                });
            }

        }
    });
    // clearConsole();
}
// function clearConsole() {
//     if(window.console || window.console.firebug) {
//         console.clear();
//     }
// }
function checkifoffline()
{
    $.ajax
    ({
        type: 'get',
        url: 'general-checkifoffline',
        success: function (data)
        {
            if(data=='offline')
            {
                // window.location.href = "http://www.ccsi-oims.com";
                window.location.href = "/";
            }
        }
    })
}


var onetime = false;
$('#colls_minus').click(function () {
    if(onetime == false)
    {
        setTimeout(function () {
            var objDiv = document.getElementById("messageBody");
            objDiv.scrollTop = objDiv.scrollHeight;
            onetime = true;
        },1);
    }
    // console.log('minus');

});

notifs();
// checkifoffline();

// setInterval(function () {
//
//     if(interval)
//     {
//         notifs();
//         checkifoffline();
//     }
//
// }, 60000);
