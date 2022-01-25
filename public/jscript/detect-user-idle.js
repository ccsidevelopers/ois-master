/**
 * Created by aa on 10/19/2017.
 */
var userID = $('#user-id').val();

// $(document).idle({
//     onIdle: function()
//     {
//         console.log('idle');
//
//         $.ajax({
//             type: 'get',
//             url: 'idle',
//             data:
//                 {
//                     'userID': userID
//                 },
//             success: function (data)
//             {
//                 // console.log(userID);
//                 // var t = "";
//                 // $.each(data, function(i, v)
//                 // {
//                 //     t += v.online+"<br/>";
//                 //     $('#onlineUsers').append(t);
//                 // });
//                 //console.log(t);
//             },
//             error: function (datae) {
//                 console.log('error: '+userID);
//             }
//         });
//
//
//     },
//     onActive: function()
//     {
//         console.log('not-idle');
//
//         $.ajax({
//             type: 'get',
//             url: 'not-idle',
//             data:
//                 {
//                     'userID': userID
//                 },
//             success: function (data)
//             {
//                 console.log(userID);
//
//                 var t = "";
//                 $.each(data, function(i, v)
//                 {
//                     t += v.online+"<br/>";
//                     $('#onlineUsers').append(t);
//                 });
//                 console.log(t);
//
//             },
//             error: function (data) {
//                 console.log('error: '+userID);
//             }
//         })
//     },
//     idle: 180000
// });
