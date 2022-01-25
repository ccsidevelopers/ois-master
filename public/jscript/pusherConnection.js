// /**
//  * Created by aa on 9/11/2017.
//  */
//
// var privateChannel;
// var message;
// var countnewmess = 0;
// var repeatcount = false;
//
// $(document).ready(function () {
//     getMessages();
//
//     $('#grouptextarea ul li').remove();
//
//     var publicNotifChannel = pusher.subscribe('publicNotificationChannel');
//     publicNotifChannel.bind('App\\Events\\DispatchPusherEvent', function(data)
//     {
//         toastr["success"]("PUBLIC NOTIFICATION");
//         toastr.options =
//             {
//                 "closeButton": true,
//                 "debug": true,
//                 "newestOnTop": true,
//                 "progressBar": false,
//                 "positionClass": "toast-top-center",
//                 "preventDuplicates": false,
//                 "showDuration": "300",
//                 "hideDuration": "1000",
//                 "timeOut": "5000",
//                 "extendedTimeOut": "1000",
//                 "showEasing": "swing",
//                 "hideEasing": "linear",
//                 "showMethod": "fadeIn",
//                 "hideMethod": "fadeOut"
//             };
//     });
//
//
//     privateChannel = pusher.subscribe('publicChannel');
//     privateChannel.bind('App\\Events\\SAOdispatchChat', function (datum) {
//         countnewmess += 1;
//         $('.newmessagetogs').html(countnewmess.toString());
//         getMessages();
//     });
//
//
//     function getMessages() {
//         $.ajax
//         ({
//             type: 'get',
//             url: '/broadcast',
//             success: function (data) {
//                 $('#messageNotif').html('');
//
//                 var countall;
//                 var ctr;
//                 for (ctr = 0; ctr < data[1].length; ctr++) {
//
//                     countall = ctr;
//
//
//                     if (data[0] === parseInt(data[1][ctr].user_id)) {
//                         if (ctr > 0) {
//                             if (parseInt(data[1][ctr].user_id) === parseInt(data[1][ctr - 1].user_id)) {
//                                 //same user
//
//                                 if (data[1][ctr].date + ' ' + data[1][ctr].time.substring(0, data[1][ctr].time.length - 3) === data[1][ctr - 1].date + ' ' + data[1][ctr - 1].time.substring(0, data[1][ctr - 1].time.length - 3)) {
//                                     $('#messageNotif').append
//                                     (
//                                         '<div class="direct-chat-msg right">' +
//                                         '   <div class="direct-chat-info clearfix">' +
//                                         // '       <span class="direct-chat-name pull-left">'+data[1][ctr].user_name+'</span>' +
//                                         // '       <span class="direct-chat-timestamp pull-left">'+data[1][ctr].date+' '+data[1][ctr].time+'</span>' +
//                                         '   </div>' +
//                                         // '       <img class="direct-chat-img" src="'+data[1][ctr].pix_path+'">' +
//                                         '   <div class="direct-chat-text right" style="width: 100%;white-space:normal;">' +
//                                         data[1][ctr].message +
//                                         '</div>' +
//                                         '</div>'
//                                     );
//                                 } else {
//                                     $('#messageNotif').append
//                                     (
//                                         '<div class="direct-chat-msg right">' +
//                                         '   <div class="direct-chat-info clearfix">' +
//                                         // '       <span class="direct-chat-name pull-left">'+data[1][ctr].user_name+'</span>' +
//                                         '       <span class="direct-chat-timestamp pull-left">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                         '   </div>' +
//                                         // '       <img class="direct-chat-img" src="'+data[1][ctr].pix_path+'">' +
//                                         '   <div class="direct-chat-text right" style="width: 100%;white-space:normal;">' +
//                                         data[1][ctr].message +
//                                         '</div>' +
//                                         '</div>'
//                                     );
//                                 }
//                             }
//                             else {
//                                 $('#messageNotif').append
//                                 (
//                                     '<div class="direct-chat-msg right">' +
//                                     '   <div class="direct-chat-info clearfix">' +
//                                     '       <span class="direct-chat-name pull-left">' + data[1][ctr].user_name + '</span>' +
//                                     '           <span data-toggle="tooltip" title="' + '(Branch: ' + data[1][ctr].branch + ') (Position: ' + data[1][ctr].posistion + ')' + '" class="badge bg-blue">' +
//                                     '             <i class="fa fa-info"></i></span>' +
//                                     '       <span class="direct-chat-timestamp pull-right">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                     '   </div>' +
//                                     '       <img class="direct-chat-img" src="' + data[1][ctr].pix_path + '">' +
//                                     '   <div class="direct-chat-text right" style="white-space:normal;" >' +
//                                     data[1][ctr].message +
//                                     '   </div>' +
//                                     '</div>'
//                                 );
//                             }
//                         }
//                         else {
//                             //user if first
//
//                             $('#messageNotif').append
//                             (
//                                 '<div class="direct-chat-msg right">' +
//                                 '   <div class="direct-chat-info clearfix">' +
//                                 '       <span class="direct-chat-name pull-left">' + data[1][ctr].user_name + '</span>' +
//                                 '           <span data-toggle="tooltip" title="' + '(Branch: ' + data[1][ctr].branch + ') (Position: ' + data[1][ctr].posistion + ')' + '" class="badge bg-blue">' +
//                                 '             <i class="fa fa-info"></i></span>' +
//                                 '       <span class="direct-chat-timestamp pull-right">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                 '   </div>' +
//                                 '       <img class="direct-chat-img" src="' + data[1][ctr].pix_path + '">' +
//                                 '   <div class="direct-chat-text right" style="white-space:normal;" >' +
//                                 data[1][ctr].message +
//                                 '   </div>' +
//                                 '</div>'
//                             );
//                         }
//
//                     }
//                     else {
//
//                         //new person
//
//                         if (ctr > 0) {
//                             if (parseInt(data[1][ctr].user_id) === parseInt(data[1][ctr - 1].user_id)) {
//                                 //same user
//
//                                 if (data[1][ctr].date + ' ' + data[1][ctr].time.substring(0, data[1][ctr].time.length - 3) === data[1][ctr - 1].date + ' ' + data[1][ctr - 1].time.substring(0, data[1][ctr - 1].time.length - 3)) {
//
//
//                                     $('#messageNotif').append
//                                     (
//                                         '<div class="direct-chat-msg left">' +
//                                         '   <div class="direct-chat-info clearfix">' +
//                                         // '       <span class="direct-chat-name pull-left">'+data[1][ctr].user_name+'</span>' +
//                                         // '       <span class="direct-chat-timestamp pull-right">'+data[1][ctr].date+' '+data[1][ctr].time+'</span>' +
//                                         '   </div>' +
//                                         // '       <img class="direct-chat-img" src="'+data[1][ctr].pix_path+'">' +
//                                         '   <div class="direct-chat-text left" style="width: 100%; margin-left: -1%; white-space:normal;"> ' +
//                                         data[1][ctr].message +
//                                         '   </div>' +
//                                         '</div>'
//                                     );
//
//                                 } else {
//
//                                     $('#messageNotif').append
//                                     (
//                                         '<div class="direct-chat-msg left">' +
//                                         '   <div class="direct-chat-info clearfix">' +
//                                         // '       <span class="direct-chat-name pull-left">'+data[1][ctr].user_name+'</span>' +
//                                         '       <span class="direct-chat-timestamp pull-right">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                         '   </div>' +
//                                         // '       <img class="direct-chat-img" src="'+data[1][ctr].pix_path+'">' +
//                                         '   <div class="direct-chat-text left" style="width: 100%; margin-left: -1%; white-space:normal;"> ' +
//                                         data[1][ctr].message +
//                                         '   </div>' +
//                                         '</div>'
//                                     );
//                                 }
//
//                             }
//                             else {
//                                 //new user
//
//                                 $('#messageNotif').append
//                                 (
//                                     '<div class="direct-chat-msg">' +
//                                     '   <div class="direct-chat-info clearfix">' +
//                                     '       <span class="direct-chat-name pull-left">' + data[1][ctr].user_name + '</span>' +
//                                     '           <span data-toggle="tooltip" title="' + '(Branch: ' + data[1][ctr].branch + ') (Position: ' + data[1][ctr].posistion + ')' + '" class="badge bg-blue">' +
//                                     '             <i class="fa fa-info"></i></span>' +
//                                     '       <span class="direct-chat-timestamp pull-right">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                     '   </div>' +
//                                     '       <img class="direct-chat-img" src="' + data[1][ctr].pix_path + '">' +
//                                     '   <div class="direct-chat-text left" style="white-space:normal;">' +
//                                     data[1][ctr].message +
//                                     '   </div>' +
//                                     '</div>'
//                                 );
//                             }
//                         }
//                         else {
//                             //new user if first
//
//                             $('#messageNotif').append
//                             (
//                                 '<div class="direct-chat-msg">' +
//                                 '   <div class="direct-chat-info clearfix">' +
//                                 '       <span class="direct-chat-name pull-left">' + data[1][ctr].user_name + '</span>' +
//                                 '           <span data-toggle="tooltip" title="' + '(Branch: ' + data[1][ctr].branch + ') (Position: ' + data[1][ctr].posistion + ')' + '" class="badge bg-blue">' +
//                                 '             <i class="fa fa-info"></i></span>' +
//                                 '       <span class="direct-chat-timestamp pull-right">' + data[1][ctr].date + ' ' + data[1][ctr].time + '</span>' +
//                                 '   </div>' +
//                                 '       <img class="direct-chat-img" src="' + data[1][ctr].pix_path + '">' +
//                                 '   <div class="direct-chat-text left" style="white-space:normal;" >' +
//                                 data[1][ctr].message +
//                                 '   </div>' +
//                                 '</div>'
//                             );
//                         }
//
//                     }
//                 }
//
//                 if (repeatcount === false) {
//                     countnewmess = countall + 1;
//                     $('.newmessagetogs').html(countnewmess.toString());
//                     repeatcount = true;
//                 }
//
//                 var objDiv = document.getElementById("messageBody");
//                 objDiv.scrollTop = objDiv.scrollHeight;
//             }
//         });
//
//
//         var messageBody = document.querySelector('#messageBody');
//         messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
//     }
//
//
//     pusher.connection.bind('connected', function (states) {
//         $('#statusConnection').html('');
//         toastr["success"]("Successfully connected to the server!");
//         toastr.options = {
//             "closeButton": false,
//             "debug": false,
//             "newestOnTop": false,
//             "progressBar": true,
//             "positionClass": "toast-top-right",
//             "preventDuplicates": true,
//             "onclick": null,
//             "showDuration": "300",
//             "hideDuration": "1000",
//             "timeOut": "10000",
//             "extendedTimeOut": "1000",
//             "showEasing": "swing",
//             "hideEasing": "linear",
//             "showMethod": "fadeIn",
//             "hideMethod": "fadeOut"
//         };
//         $('#statusConnection').html('<a href="#"><i class="fa fa-circle text-success"></i> connected</a>');
//     });
//
//     pusher.connection.bind('unavailable', function (states) {
//         $('#statusConnection').html('');
//         toastr["error"]("Disconnected! Waiting for connection...");
//         toastr.options = {
//             "closeButton": false,
//             "debug": false,
//             "newestOnTop": false,
//             "progressBar": true,
//             "positionClass": "toast-top-right",
//             "preventDuplicates": true,
//             "onclick": null,
//             "showDuration": "300",
//             "hideDuration": "1000",
//             "timeOut": "10000",
//             "extendedTimeOut": "1000",
//             "showEasing": "swing",
//             "hideEasing": "linear",
//             "showMethod": "fadeIn",
//             "hideMethod": "fadeOut"
//         };
//         $('#statusConnection').html('<a href="#"><i class="fa fa-circle text-danger"></i> disconnected</a>')
//     });
// });
//
// $('#txtMessage').focus();
//
// $('#btnPusher').click(function () {
//     var message = $('#txtMessage').html();
//
//     console.log(message);
//
//     if (message === '') {
//
//     } else {
//
//         $('#txtMessage').attr('disabled', 'disabled');
//         $('#btnPusher').attr('disabled', 'disabled');
//         $('#chatloading').html('          <div class="overlay">\n' +
//             '                                    <i class="fa fa-refresh fa-spin"></i>\n' +
//             '                                </div>'
//         );
//
//         $.ajax
//         ({
//             type: 'get',
//             url: '/pusher',
//             data:
//                 {
//                     message: message
//                 },
//             success: function (data) {
//                 countnewmess = 0;
//                 $('.newmessagetogs').html(countnewmess.toString());
//                 $('#chatloading').html('');
//                 $('#txtMessage').val('');
//                 $('#txtMessage').html('');
//
//                 $('.emotion-area').empty();
//                 $('.emotion-area').removeClass('ShowImotion');
//
//                 $('#txtMessage').removeAttr('disabled');
//                 $('#btnPusher').removeAttr('disabled');
//                 // var objDiv = document.getElementById("messageBody");
//                 // objDiv.scrollTop = objDiv.scrollHeight;
//             }
//         });
//     }
//
// });
//
//
// var loading = false;
//
// $('#txtMessage').bind('keydown', function (e) {
//
//     sendenter(e);
//
// });
//
// $('.emotion-area').bind('keydown', function (e) {
//
//     sendenter(e);
//
// });
//
// $('#txtMessage').click(function () {
//
//     $('.emotion-area').empty();
//     $('.emotion-area').removeClass('ShowImotion');
//
// });
//
// function sendenter(e) {
//
//     var key = e.which;
//     if (key === 13)  // the enter key code
//     {
//         var find = '<div><br></div>';
//         var re = new RegExp(find, 'g');
//
//         var message = $('#txtMessage').html().replace(re,'');
//
//         if (key === 13 && e.shiftKey) {
//
//             // console.log('shift + enter');
//
//         }
//         else if (message === '')
//         {
//
//         }
//         else
//         {
//
//             if (loading)
//             {
//                 // console.log('wait for loading');
//             }
//             else
//             {
//                 // console.log('message to send: '+message.replace(re,''));
//
//                 $.ajax
//                 ({
//                     type: 'get',
//                     url: '/pusher',
//                     data:
//                         {
//                             message:message
//                         },
//                     beforeSend: function () {
//                         $('#txtMessage').attr('disabled', 'disabled');
//                         $('#btnPusher').attr('disabled', 'disabled');
//                         $('#chatloading').html('          <div class="overlay">\n' +
//                             '                                    <i class="fa fa-refresh fa-spin"></i>\n' +
//                             '                                </div>'
//                         );
//
//                         loading = true;
//                     },
//                     success: function (data) {
//                         countnewmess = 0;
//                         $('.newmessagetogs').html(countnewmess.toString());
//                         $('#chatloading').html('');
//                         $('#txtMessage').val('');
//                         $('#txtMessage').html('');
//
//                         $('.emotion-area').empty();
//                         $('.emotion-area').removeClass('ShowImotion');
//
//                         $('#txtMessage').removeAttr('disabled');
//                         $('#btnPusher').removeAttr('disabled');
//                         loading = false;
//                         // var objDiv = document.getElementById("messageBody");
//                         // objDiv.scrollTop = objDiv.scrollHeight;
//                     }
//                 });
//             }
//
//         }
//     }
//
// }
//
//
// $('#txtMessage').click(function () {
//
//     countnewmess = 0;
//     $('.newmessagetogs').html(countnewmess.toString());
//
// });
