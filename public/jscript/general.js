var i,j,k;
var b = 0;
var listItemPurp,ccsiDept,ccsiBranch = [];
var interval = true;
var brandInc = 0;
var boolOpenReq = false;
var tableBiReports;
var table_productivity_arr = [];
var prod_count_head = 0;
var tableProdEmp;
var boolTableProduc = false;
var table_cc_prod_arr = [];
var cc_prod_count = 0;
var tableCCprodEmp;
var boolTableCC = false;
var accUndrEmpArr = [];
var countUnder = 0;
var table_acc_under_prod;
var boolacctsUnder = false;

var accUndrEmpArrCC = [];
var countUnderCC = 0;
var table_acc_under_prod_cc;
var boolacctsUnderCC = false;
var checkPosCC;
var attendance_sched = true;



// $("#overlay").show();
// ;(function(){
//     function id(v){return document.getElementById(v); }
//     function loadbar() {
//         var ovrl = id("overlay"),
//             prog = id("progress"),
//             stat = id("progstat"),
//             img = document.images,
//             c = 0;
//         tot = img.length;
//
//         function imgLoaded(){
//             c += 1;
//             var perc = ((100/tot*c) << 0) +"%";
//             prog.style.width = perc;
//             stat.innerHTML = "Loading "+ perc;
//             if(c===tot) return doneLoading();
//         }
//         function doneLoading(){
//             ovrl.style.opacity = 0;
//             setTimeout(function(){
//                 ovrl.style.display = "none";
//             }, 1200);
//         }
//         for(var i=0; i<tot; i++) {
//             var tImg     = new Image();
//             tImg.onload  = imgLoaded;
//             tImg.onerror = imgLoaded;
//             tImg.src     = img[i].src;
//         }
//     }
//     document.addEventListener('DOMContentLoaded', loadbar, false);
// }());

$(window).load(function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");
});

$(document).ready(function ()
{
    // $("#overlay").hide();
    $('#btnAddItem').click(function()
    {
        $.ajax
        ({
            type: 'get',
            url: 'general-get-req-list-info',
            success: function (data)
            {
                $('#itmList').html('');

                listItemPurp ='';

                for (i = 0; i < data[0].length-1; i++)
                {
                    listItemPurp += '<option value="' + data[0][i].item_purpose + '">' + data[0][i].item_purpose + '</option>';
                }
            }
        });

        b++;
        $('#tblItemList').append(
            '<tr id="row'+b+'">' +
            '<td><input type="text" class="form-control" name="txtItemName[]" required="required"></td>' +
            '<td><input type="text" class="form-control" name="txtItemDesc[]" required="required"></td>' +
            '<td><select class="form-control" name="selItemPurp[]">'+listItemPurp+'</select></td>' +
            '<td style="width: 10%"><input type="number" class="form-control" name="txtItemQty[]" required="required"></td>' +
            '<td><button name="remove" id="'+b+'" class="btn btn-danger btn-sm form-control btnRemoveItem">Remove</button></td>' +
            '</tr>');
    });

    $('#btnSendReq').click(function ()
    {
        var selCcsiDept = $('#selCcsiDept').val();
        var selCcsiBranch = $('#selCcsiBranch').val();
        var txtReqBy = $('#txtReqBy').val();
        var txtItemReceiver = $('#txtItemReceiver').val();

        var form_data = new FormData();
        form_data.append('serialize',$('#frmArrItem').serialize());

        var formData = JSON.stringify(jQuery('#frmArrItem').serializeArray());

        $.ajax
        ({
            type: 'post',
            url: 'general-send-req-item-re-rep',
            traditional: true,
            data:
                {
                    'selCcsiDept': selCcsiDept,
                    'selCcsiBranch': selCcsiBranch,
                    'txtReqBy': txtReqBy,
                    'txtItemReceiver': txtItemReceiver,
                    'form_data': formData
                },
            success: function (data)
            {
                console.log(data);
                if($.isNumeric(data))
                {
                    var addVal = 'id%5B%5D=' + data +'&'+ $('#frmArrItem').serialize();
                    $.ajax
                    ({
                        type: 'post',
                        url: 'general-send-req-item-list',
                        data:addVal,
                        success: function (data)
                        {
                            console.log(data);
                            if(data=='Success')
                            {
                                $('#txtItemReceiver').val('');
                                $('#modal-request-panel').modal('hide');
                                alert('Successfully Added!');
                            }
                            else
                            {
                                alert('Please fill up all necessary field/s or add item/s');
                            }
                        }
                    });
                }
                else
                {
                    alert('Please fill up all necessary field/s or add item/s');
                }
            }
        });
    });

    $('#btnReqPanelItem').click(function ()
    {
        $.ajax
        ({
            type: 'get',
            url: 'general-get-req-list-info',
            success: function (data)
            {
                console.log('asdfasdfadsf:'+data);

                $('#itmList').html('');
                $('#ccsiDept').html('');
                $('#ccsiBranch').html('');
                listItemPurp ='';
                ccsiBranch='';
                ccsiDept='';

                for (i = 0; i < data[0].length; i++)
                {
                    listItemPurp += '<option value="' + data[0][i].item_purpose + '">' + data[0][i].item_purpose + '</option>';
                }

                for (j = 0; j < data[1].length; j++)
                {
                    ccsiDept += '<option value="' + data[1][j].dept_name + '">' + data[1][j].dept_name + '</option>';
                }

                for (k = 0; k < data[2].length; k++)
                {
                    ccsiBranch += '<option value="' + data[2][k].branch_name + '">' + data[2][k].branch_name + '</option>';
                }

                $('#itmList').append
                (
                    '<select class="form-control" id="selItemPurpose">' +
                    listItemPurp +
                    '</select>'
                );

                $('#ccsiDept').append
                (
                    '<select class="form-control" id="selCcsiDept">' +
                    ccsiDept +
                    '</select>'
                );

                $('#ccsiBranch').append
                (
                    '<select class="form-control" id="selCcsiBranch">' +
                    ccsiBranch +
                    '</select>'
                );

                $('#txtReqBy').val(data[3]);
                $('#tblItemList tbody').empty();
            }
        });
    });

    // function stopint() {
    //
    //     for(var ctr=0; ctr<999999; ctr++)
    //     {
    //         window.clearInterval(ctr);
    //     }
    //
    // }
    //
    // setInterval(function () {
    //
    // },1000);


    var change_chat_box_notif = false;
    $('#change_chat_notif_chat_box').hide();
    $('#show_hide_chat_box_href').click(function () {

        // console.log('asdasdasd');

        if(change_chat_box_notif == false)
        {
            $('#show_hide_chat_box_icon').attr('class','');
            $('#show_hide_chat_box_icon').attr('class','glyphicon glyphicon-minus');
            $('#span_chat_box_hide_show').html('' +
                'Hide Chat Box'
            );

            $('#change_chat_notif_side').hide();
            $('#change_chat_notif_chat_box').show();
            $('#id_chat').show();
            change_chat_box_notif = true;
        }
        else
        {
            $('#show_hide_chat_box_icon').attr('class','');
            $('#show_hide_chat_box_icon').attr('class','glyphicon glyphicon-plus');
            $('#span_chat_box_hide_show').html('' +
                'Show Chat Box'
            );

            $('#change_chat_notif_chat_box').hide();
            $('#change_chat_notif_side').show();
            $('#id_chat').hide();
            change_chat_box_notif = false;
        }
    });
});




// function setup() {
//     this.addEventListener("mousemove", logout_cliet_stop, false);
//     this.addEventListener("mousedown", logout_cliet_stop, false);
//     this.addEventListener("keypress", logout_cliet_stop, false);
//     this.addEventListener("DOMMouseScroll", logout_cliet_stop, false);
//     this.addEventListener("mousewheel", logout_cliet_stop, false);
//     this.addEventListener("touchmove", logout_cliet_stop, false);
//     this.addEventListener("MSPointerMove", logout_cliet_stop, false);
//     this.addEventListener("mouseout", logout_client, false);
// }

// setup();
//
// var mytimout;
// var mytimoutinterval;
// var mytimout_log = false;
// var role = '';
// var counting;
//
// function logout_client() {
//     mytimout_log = true;
//     // console.log('to logout');
//     counting = 0;
//     clearTimeout(mytimout);
//     clearInterval(mytimoutinterval);
//
//     mytimoutinterval = setInterval(function () {
//         mytimout_log = true;
//         console.log(counting);
//         counting++;
//         if(counting > 59)
//         {
//             $.ajax({
//                 type: 'get',
//                 url: 'general_check_role_logout',
//                 success:function ($data) {
//                     role = $data.role;
//                     if(role)
//                     {
//                         if(mytimout_log)
//                         {
//                             window.location.href = '/logout';
//                         }
//                     }
//                 }
//             });
//         }
//     },1000);
//
//     mytimout = setTimeout(function()
//     {
//
//         $.ajax({
//             type: 'get',
//             url: 'general_check_role_logout',
//             success:function ($data) {
//                 role = $data.role;
//                 if(role)
//                 {
//                     if(mytimout_log)
//                     {
//                         window.location.href = '/logout';
//                     }
//                 }
//             }
//         });
//
//     }, 60000);
//
// }
//
// function logout_cliet_stop() {
//     mytimout_log = false;
//     clearTimeout(mytimout);
//     clearInterval(mytimoutinterval);
// }

$(window).blur(function () {
    // stopint();

    // logout_client();
    console.log('blur');

    interval = false;
});


$(document).on('click', '.btnRemoveItem', function()
{
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove();

});

$('.change_dp').click(function()
{
    $('#modal-change-dp').modal('show');
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.show_dp_uploaded').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$("#change_dp_image").change(function() {
    readURL(this);
});

$('#change_dp_save').click(function()
{

    var imageVar = $('#show_dp_uploaded').attr("src");
    var btn = $(this);
    var uploadedimage = $('#change_dp_image').prop('files')[0];
    var formData = new FormData();
    formData.append('file',uploadedimage);

    // console.log(imageVar);

    if($('#change_dp_image').prop('files')[0] != null || $('#change_dp_image').prop('files')[0] != '')
    {
        btn.attr("disabled", true);
        $.ajax
        (
            {
                type: 'post',
                url: 'change-dp',
                contentType: false,
                processData: false,
                async : true,
                data: formData,
                success: function(data)
                {
                    console.log(data);
                    if(data == 'ok')
                    {
                        alert('Change of Display Icon/Image Successful');
                        $('#modal-change-dp').modal('hide');
                    }
                    else if(data == 'no')
                    {
                        alert('Failed to Change Display Icon/Image');
                    }
                    else if(data == 'not match')
                    {
                        alert('File is not a JPEG/PNG/JPG');
                    }
                    else if(data == 'no file')
                    {
                        alert('Please upload a image');
                    }

                    $('.afterUpload').attr("src", imageVar);
                    $('#afterUpload').attr("src", imageVar);
                    btn.attr("disabled", false);
                }

            }
        );
    }
    else
    {
        alert('Please upload an image type file');
    }
});

$('#brandItemsTable').on('click', '.btnToAddBrand', function()
{
    brandInc++;

   $('#appBrand').append('<tr id = "removeBrand-'+brandInc+'">\n' +
       '                                <td colspan="1"> <textarea class = "form-control toLoopBrandDetails" rows ="2"></textarea></td>\n' +
       '                                <td colspan="1"><input type="number" class="form-control toLoopBrandDetails"></td>\n' +
       '                                <td colspan="1"><input type="number" class="form-control toLoopBrandDetails"></td>\n' +
       '                                <td colspan="1">   <div class="input-group input-group-sm"><input type="number" class="form-control toLoopBrandDetails amntToSum" >\n' +
       '                                        <span class="input-group-btn">\n' +
       '                                            <button type="button" class="btn btn-danger btn-sm btnRemoveRow" name="'+brandInc+'">\n' +
       '                                            <i class = "fa fa-fw fa-minus"></i></button>\n' +
       '                                        </span>\n' +
       '                                    </div>\n' +
       '                                </td>\n' +
       '                            </tr>');
});

$('#brandItemsTable').on('click', '.btnRemoveRow', function()
{
    var id = $(this).attr('name');

    $('#removeBrand-'+id+'').remove();
});

// $('#tableRequisitionAdmin').on('keyup', '.autoFillChecks', function()
// {
//     var toChange = $(this).attr('name');
//
//     $('#'+toChange+'').val( $(this).val());
// });

$('#brandItemsTable').on('keyup', '.amntToSum', function()
{
    summationRequi();
});

$('#sendRequisitionToAdmin').click(function()
{
    var btn = $(this);

    btn.attr('disabled', true);

    var myData = [];
    var dataBrand = [];
    var checkVal = '';
    var ctr = 0;
    var ctrBrand = 0;
    var ctrInnerBrand = 0;
    var brandBool = true;
    var dateRequested = $('#dateOfRequestAdmin').val();
    var reqName = $('#requestedRequi').val();
    var officeLoc = $('#officeLocRequi').val();
    var dateNeeded = $('#dateNeededRequi').val();
    var approvedBy = $('#approvedByRequi').val();
    var approvalDate = $('#approvalDateRequi').val();
    var totalAmountRequi = $('#totalAmountRequi').val();
    var reqRemarksReason = $('#req_reason_remarks').val();
    var requestedRequiFor = $('#requestedRequiFor').val();
    var requestedRequiForID = $('#requestedRequiForID').val();
    var otherCheck1 = $('#otherCheck-0').val();
    var otherCheck2 = $('#otherCheck-1').val();
    var otherCheck3 = $('#otherCheck-2').val();

    var radioCheck = '';

    if($('#newReq').is(':checked'))
    {
        radioCheck = 'New Request';
    }
    else if($('#replaceRequi').is(':checked'))
    {
        radioCheck = 'Replacement';
    }

    $('.requiList').each(function()
    {
        if($(this).is(":checked"))
        {
            checkVal = $(this).val();
            myData[ctr] = checkVal;
            ctr++;
        }
    });

    $('.toLoopBrandDetails').each(function()
    {
        if(brandBool == false)
        {
            dataBrand[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;

            if(ctrInnerBrand == 4)
            {
                ctrInnerBrand = 0;
                ctrBrand++;
                brandBool = true;
            }
        }
        else
        {
            dataBrand[ctrBrand] = [];
            dataBrand[ctrBrand][ctrInnerBrand] = $(this).val();
            ctrInnerBrand++;
            brandBool = false;
        }
    });

    if(requestedRequiFor != '')
    {
        if(requestedRequiForID == '' || requestedRequiForID.toUpperCase() == 'NONE' || requestedRequiForID.toUpperCase() == 'NO RECORD')
        {
            alert('Please enter applicable ID');
            btn.attr('disabled', false);
        }
        else
        {
            $('#loadingSpanSendReq').show();

            $.ajax
            ({
                type : 'post',
                url : 'general-send-requisition-to-admin',
                data :
                    {
                        myData : myData,
                        dataBrand : dataBrand,
                        'dateRequested' : dateRequested,
                        'reqName' : reqName,
                        'officeLoc' : officeLoc,
                        'dateNeeded' : dateNeeded,
                        'approvedBy' : approvedBy,
                        'approvalDate' : approvalDate,
                        'totalAmountRequi' : totalAmountRequi,
                        'radioCheck' : radioCheck,
                        'reqRemarksReason' : reqRemarksReason,
                        'otherCheck1' : otherCheck1,
                        'otherCheck2' : otherCheck2,
                        'otherCheck3' : otherCheck3,
                        'requestedRequiFor' : requestedRequiFor,
                        'requestedRequiForID' : requestedRequiForID
                    },
                success : function()
                {

                },
                complete : function()
                {
                    alert('Successfully Requested Items/Equipments to Admin.');
                    $('.toClear').val('');
                    $('.requiList').removeAttr('checked');
                    $('.toLoopBrandDetails').val('');
                    $('.autoFillChecks').val('');
                    $('#modal-requisition_form').modal('hide');
                    $('#loadingSpanSendReq').hide();
                    btn.attr('disabled', false);
                }
            });


        }
    }
    else if(requestedRequiFor == '' || requestedRequiFor.toUpperCase() == 'NONE' || requestedRequiFor.toUpperCase() == 'NO RECORD')
    {
        alert('Please enter valid employee name');
        btn.attr('disabled', false);
    }

});

function summationRequi()
{
    var sumInput = 0;

    $('.amntToSum').each(function()
    {
        var toAdd = $(this).val();

        if(toAdd != '')
        {
            sumInput += parseInt(toAdd);
        }
        else
        {

        }

    });

    $('#totalAmountRequi').val(sumInput);
}



function getUserName(stat)
{
    $.ajax
    ({
        'type' : 'get',
        'url' : 'general-get-user-name',
        success : function(data)
        {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            if(stat == 'app')
            {
                $('#requestedRequi').val(data);
                $('#dateOfRequestAdmin').val(today)
            }
            else if(stat == 'po')
            {
                $('#preparedByPO').val(data)
                $('#poDate').val(today)
            }
        }
    })
}


 // $('#requestedRequiFor').focusout(function ()
 //    {
 //        if($('#ciMuni').val() === '')
 //        {
 //            $('#ciProv').val('');
 //        }
 //        else
 //        {
 //            $.ajax
 //            ({
 //                method: 'get',
 //                url: '/fetch-city-muniv2',
 //                data:
 //                    {
 //                        'muniname' : $('#ciMuni').val()
 //                    },
 //                success: function (data)
 //                {
 //                    console.log(data[0].id);
 //                    $('#idProvince').val(data[0].province_id);
 //                    $('#idMunicipality').val(data[0].id);
 //                    fetchProv();
 //
 //                    setTimeout(function ()
 //                    {
 //                        $('#ciMuni').val(data[0].muni_name);
 //                    },1000);
 //                }
 //            });
 //        }
 //    });

$('#requestedRequiFor').autocomplete
({
    source: '/fetch-hr-names',
    minLength: 1,
    select: function (event,ui,label)
    {
        $('#requestedRequiForID').val(ui.item.id);

        var clearTime = setInterval(function ()
        {
            clearInterval(clearTime);
        },10)
    }
});

$('#requestedRequiForID').autocomplete
({
    source: '/fetch-hr-id',
    minLength: 1,
    select: function (event,ui,label)
    {
        $('#requestedRequiFor').val(ui.item.name);

    }
});

$('#requi_approval_btn').click(function()
{
   $('#modal_requisition_approval').modal('show');
});

$('#passRequi').click(function()
{
    $('.toClear').each(function()
    {
        if($(this).attr('id') == 'totalAmountRequi')
        {
            $(this).attr('disabled', true);
        }
        else
        {
            $(this).attr('disabled', false);
        }
        $(this).val('');
    });

    $('.requiList').attr('disabled', false).prop('checked', false);

    $('.toDisable').attr('disabled', false);

    $('#appBrand').html('<tr>\n' +
        '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
        '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
        '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
        '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span><span class = "pull-right"><button class = "btn btn-sm btn-success btnToAddBrand"  >\n' +
        '                                            <i class = "fa fa-fw fa-plus"></i></button></span></th>\n' +
        '                            </tr>\n' +
        '                            <tr id = "removeBrand-0">\n' +
        '                                <td colspan="1"><textarea class = "form-control toLoopBrandDetails" rows ="2"></textarea></td>\n' +
        '                                <td colspan="1"><input type="number" class="form-control toLoopBrandDetails"></td>\n' +
        '                                <td colspan="1"><input type="number" class="form-control toLoopBrandDetails"></td>\n' +
        '                                <td colspan="1">   <div class="input-group input-group-sm"><input type="number" class="form-control toLoopBrandDetails amntToSum">\n' +
        '                                        <span class="input-group-btn">\n' +
        '                                            <button type="button" class="btn btn-danger btn-sm btnRemoveRow" name = "0">\n' +
        '                                            <i class = "fa fa-fw fa-minus"></i></button>\n' +
        '                                        </span>\n' +
        '                                    </div>\n' +
        '                                </td>\n' +
        '                            </tr>\n');

    $('#showHideSendRequestRequi').show();
    $('#modal-requisition_form').modal({backdrop: "static"});

    getUserName('app');
});

$('.attendance_date_range').click(function()
{
    var today = new Date();
    var todayv2 = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + '';
    if($(this).val() == 'Today')
    {
    //     $('#generate_attendance_allCi').attr('href', 'generate-excel-attendace-ci?start=' + todayv2 + '&' + 'end=' + todayv2);
    //     $('#generate_attendance_allCi').attr('target', '_blank');
        // $('#generate_attendance_allCi').show();

        $('#attendance_date_rangePicker_holder').hide();
    }
    else
    {
        $('#generate_attendance_allCi').removeAttr('href');
        $('#generate_attendance_allCi').removeAttr('target');
        // $('#generate_attendance_allCi').hide();

        $('#attendance_date_rangePicker_holder').show();
    }
});

$('#attendanceStart').datepicker();
$('#attendanceEnd').datepicker();

$('#generate_attendance_allCi').click(function()
{
    var $this = $(this);
    var today = new Date();
    var todayv2 = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + '';
    var selected = '';
    var startRaw1 = $('#attendanceStart').val().split('/');
    var EndRaw = $('#attendanceEnd').val().split('/');
    var start = startRaw1[2] + '-' + startRaw1[0] + '-' + startRaw1[1];
    var end = EndRaw[2] + '-' + EndRaw[0] + '-' + EndRaw[1];

    $('.attendance_date_range').each(function()
    {
        if($(this).is(':checked'))
        {
            selected = $(this).val();
        }
    });

    if(selected == 'Today')
    {
        $this.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'generate-excel-attendance-ci',
            data: {
                'start' : todayv2,
                'end' : todayv2
            },
            success: function(data)
            {
                if(data == 'go')
                {
                    window.open('generate-excel-attendance-ci-2?start=' + todayv2 + '&' + 'end=' + todayv2);
                    $this.attr('disabled', false);
                }
            },
            error: function(e)
            {
                alert('Error pccured contact web admin for assistance');
                console.log(e);
                $this.attr('disabled', false);
            }
        });
    }
    else
    {
        if($('#attendanceStart').val() != '' && $('#attendanceEnd').val() != '')
        {
            if($('#attendanceStart').val() > $('#attendanceEnd').val())
            {
                $this.attr('disabled', false);

                alert('Start date must be the previous date and end date should be greater than the start date.');
            }
            else
            {
                $this.attr('disabled', true);

                $.ajax({
                    type: 'get',
                    url: 'generate-excel-attendance-ci',
                    data: {
                        'start' : start,
                        'end' : end
                    },
                    success: function(data)
                    {
                        if(data == 'go')
                        {
                            window.open('generate-excel-attendance-ci-2?start=' + start + '&' + 'end=' + end);
                            $this.attr('disabled', false);
                        }
                    },
                    error: function(e)
                    {
                        alert('Error occured contact web admin for assistance');
                        console.log(e);
                        $this.attr('disabled', false);
                    }
                });
            }
        }
        else
        {
            alert('Date Range is not specify please fill up the date range.');
        }
    }
});


$('#positionProductivity').change(function()
{
    if($(this).find(':selected').val() == 'Account Officer')
    {
        $('#showAOListProd').show();
        $('#showCIListProd').hide();
        $('#showTimeStampProd').show();

        if($('#aoProductivityNames').find(':selected').val() != '-')
        {

            if(boolTableProduc == true)
            {
                tableProdEmp.ajax.reload(null, false);

            }
            else
            {
                saoProductivityTable()
            }

            $('#showHideProductivityTable').show();
        }
        else
        {
            $('#showHideProductivityTable').hide();
        }
    }
    else if($(this).find(':selected').val() == 'Field Verifier')
    {
        $('#showAOListProd').hide();
        $('#showCIListProd').show();
        $('#showTimeStampProd').show();


        if($('#ciProductivityNames').find(':selected').val() != '-')
        {
            if(boolTableProduc == true)
            {
                tableProdEmp.ajax.reload(null, false);

            }
            else
            {
                saoProductivityTable()
            }

            $('#showHideProductivityTable').show();
        }
        else
        {
            $('#showHideProductivityTable').hide();
        }
    }
    else if($(this).find(':selected').val() == '-')
    {
        $('#showAOListProd').hide();
        $('#showCIListProd').hide();
        $('#showTimeStampProd').hide();
        $('#showHideProductivityTable').hide();
    }
});

$('#ciProductivityNames').change(function()
{
    if($(this).find(':selected').val() == '-')
    {
        $('#showHideProductivityTable').hide();
    }
    else
    {
        if(boolTableProduc == true)
        {
            tableProdEmp.ajax.reload(null, false);
        }
        else
        {
            saoProductivityTable()
        }

        $('#showHideProductivityTable').show();
    }

});

$('#aoProductivityNames').change(function()
{
    if($(this).find(':selected').val() == '-')
    {
        $('#showHideProductivityTable').hide();
    }
    else
    {
        if(boolTableProduc == true)
        {
            tableProdEmp.ajax.reload(null, false);
        }
        else
        {
            saoProductivityTable()
        }

        $('#showHideProductivityTable').show();
    }
});

$('#sortByProd').change(function()
{
    if(boolTableProduc == true)
    {
        tableProdEmp.ajax.reload(null, false);
    }
    else
    {
        saoProductivityTable()
    }
});



function saoProductivityTable()
{
    $('#sao_productivity_table thead th').each(function()
    {
        table_productivity_arr[prod_count_head] = $(this).text();
        prod_count_head++;
    });
    tableProdEmp = $('#sao_productivity_table').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Productivity',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx, title) {
                                        return table_productivity_arr[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return table_productivity_arr[(idx)];
                    }
                },

            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": "/sao_productivity_table",
        "ajax":
            {
                type: 'get',
                url: "/gen_productivity_table",
                data: function (d) {
                    var pos;
                    var idName;

                    if($('#positionProductivity').find(':selected').val() == 'Account Officer')
                    {
                        pos = 'ao';
                        idName = $('#aoProductivityNames').find(':selected').val();
                    }
                    else if($('#positionProductivity').find(':selected').val() == 'Field Verifier')
                    {
                        pos = 'ci';
                        idName = $('#ciProductivityNames').find(':selected').val();
                    }

                    d.position_prod = pos;
                    d.id_to_select = idName;
                    d.sort_by_date = $('#sortByProd').find(':selected').val();
                }
            },
        "columns":
            [
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                {data: 'dispatched_count', name: 'endorsements.date_endorsed', "searchable": false, "orderable" : false},
                {data: 'pending_count', name: 'endorsements.date_endorsed', "searchable": false, "orderable" : false},
                {data: 'on_tat', name: 'endorsements.date_endorsed', "searchable": false, "orderable" : false},
                {data: 'out_tat', name: 'endorsements.date_endorsed', "searchable": false, "orderable" : false},
                {data: 'action', name: 'endorsements.date_endorsed', "searchable": false, "orderable" : false}

            ],
        "order": [[0, 'desc']],
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

    // $('#admin-staff-acc-sup-table tbody').on('click', 'tr', function ()
    // {
    //     $(this).toggleClass('selected');
    // });

    $('#sao_productivity_table_filter input').unbind();
    $('#sao_productivity_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableProdEmp.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableProdEmp.search($(this).val()).draw();
                }
            }
        }
    });

    boolTableProduc = true;
}

ciListGenra();
function ciListGenra()
{
    $.ajax
    ({
        type : 'get',
        url : 'sao-get-ci-list',
        success : function(data)
        {
            console.log(data)
            var h;

            var optionCiData2 = '';
            var optionAOData = '';
            var optionCCtele = '';
            var optionTeleTFS = '';

            for(h = 0; h < data[0].length; h++)
            {
                optionCiData2 += '<option value = "'+data[0][h].name+'" >'+data[0][h].name+'</option>';
            }

            for(var g = 0; g < data[1].length; g++)
            {
                optionAOData += '<option value = "'+data[1][g].name+'" >'+data[1][g].name+'</option>'
            }

            for(var v = 0; v < data[2].length; v++)
            {
                optionCCtele += '<option value = "'+data[2][v].id+'" >'+data[2][v].name+'</option>';
            }

            for(var x = 0; x < data[3].length; x++)
            {
                optionTeleTFS += '<option value = "'+data[3][x].id+'">'+data[3][x].name+'</option>';
            }

            $('#ciProductivityNames').html('<option value = "-">-</option>' + optionCiData2);
            $('#aoProductivityNames').html('<option value = "-">-</option>' + optionAOData)
            $('#ccteleList').html('<option value = "-">-</option>' + optionCCtele)
            $('#teleTFSList').html('<option value = "-">-</option>' + optionTeleTFS);

        }
    })
}

checkAccessforProd();
function checkAccessforProd()
{
    $.ajax
    ({
        type : 'get',
        url : 'gen_check_user_productivity',
        success : function(data)
        {
            console.log(data);
            if(data[0].dept != '' && data[0].dept != null)
            {
                $('#showAccessForDepartment').show();
            }
            else
            {
                if(data[0].role == 14 || data[0].role == 15 || data[0].role == 16 || data[0].role == 17)
                {
                    var store = ''
                    $('#showFoCCProduc').show();

                    if(data[0].client_check == 'cc_bank')
                    {
                        $('#showForTeleTFS').show();
                        $('.ccBankStat').show();
                        store = 'teletfs'
                    }
                    else
                    {
                        console.log('test')
                        $('#showForCCBank').show();
                        $('.ccStat').show();
                        store = 'cc'
                    }

                    $('#currentAccess').val(store);

                }
                else
                {
                    $('#showForBankProduc').show();
                }
            }
        },
        error : function()
        {
            alert('Error in loading');
        }
    });
}

$('#ccteleList').change(function()
{
    if($(this).find(':selected').val() == '-')
    {
        $('#showTimeStampProdCC').hide();
        $('#showHideProductivityCC').hide();
    }
    else
    {
        $('#showTimeStampProdCC').show();

        if(boolTableCC == false)
        {
            productivityTableCcGen()
        }
        else
        {
            tableCCprodEmp.ajax.reload(null, false);
        }

        $('.ccBankStat').hide();
        $('.ccStat').show();
        $('#showHideProductivityCC').show();
    }
});

$('#teleTFSList').change(function()
{
    if($(this).find(':selected').val() == '-')
    {
        $('#showTimeStampProdCC').hide();
        $('#showHideProductivityCC').hide();
    }
    else
    {
        $('#showTimeStampProdCC').show();

        if(boolTableCC == false)
        {
            productivityTableCcGen();
        }
        else
        {
            tableCCprodEmp.ajax.reload(null, false);
        }
        $('.ccBankStat').show();
        $('.ccStat').hide();
        $('#showHideProductivityCC').show();
    }
});

$('#sortByProdCC').change(function()
{
    if(boolTableCC == false)
    {
        productivityTableCcGen()
    }
    else
    {
        tableCCprodEmp.ajax.reload(null, false);
    }

});


function productivityTableCcGen()
{
    $('#cc_productivity_table thead th').each(function()
    {
        table_cc_prod_arr[cc_prod_count] = $(this).text();
        cc_prod_count++;
    });
    tableCCprodEmp = $('#cc_productivity_table').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Productivity',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx, title) {
                                        return table_cc_prod_arr[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return table_cc_prod_arr[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": "/sao_productivity_table",
        "ajax":
            {
                type: 'get',
                url: "/gen_productivity_table_cc",
                data: function (d)
                {
                    var idName;

                    if($('#currentAccess').val() == 'teletfs')
                    {
                        idName = $('#teleTFSList').find(':selected').val();
                    }
                    else if($('#currentAccess').val() == 'cc')
                    {
                        idName = $('#ccteleList').find(':selected').val();
                    }
                    d.check_access = $('#currentAccess').val();
                    d.id_to_select_cc = idName;
                    d.sort_by_date_cc = $('#sortByProdCC').find(':selected').val();
                }
            },
        "columns":
            [
                {data: 'date_assigned_tele', name: 'bi_endorsements_users.updated_at'},
                {data: 'dispatched_count', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'pending_count', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'on_tat', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'out_tat', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'contacted', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'uncontacted', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'call_duration', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false},
                {data: 'action', name: 'bi_endorsements_users.updated_at', "searchable": false, "orderable" : false}
            ],
        "order": [[0, 'desc']],
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

    // $('#admin-staff-acc-sup-table tbody').on('click', 'tr', function ()
    // {
    //     $(this).toggleClass('selected');
    // });

    $('#cc_productivity_table_filter input').unbind();
    $('#cc_productivity_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableCCprodEmp.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableCCprodEmp.search($(this).val()).draw();
                }
            }
        }
    });

    boolTableCC = true;
}

$('#departmentSelectProd').change(function()
{
    if($(this).find(':selected').val() == 'Bank')
    {
        $('#selectInternalCC').hide();
        $('#showFoCCProduc').hide();
        $('#showForBankProduc').show();

        if($('#positionProductivity').val() == '-')
        {
            $('#showCIListProd').hide();
            $('#showAOListProd').hide();
            $('#showTimeStampProd').hide();
        }
        else if($('#positionProductivity').val() == 'Account Officer')
        {
            if($('#aoProductivityNames').val() == '-')
            {
                $('#showHideProductivityTable').hide();
            }
            else if($('#aoProductivityNames').val() != '-')
            {
                $('#showHideProductivityTable').show();
            }
        }
        else if($('#positionProductivity').val() == 'Field Verifier')
        {
            if($('#ciProductivityNames').val() == '-')
            {
                $('#showHideProductivityTable').hide();
            }
            else if($('#ciProductivityNames').val() != '-')
            {
                $('#showHideProductivityTable').show();
            }
        }
    }
    else if($(this).find(':selected').val() == 'Tele-Verifier')
    {
        $('#selectInternalCC').show();
        $('#showHideProductivityTable').hide();
        $('#showForBankProduc').hide();

        if($('#internalCCSelect').val() == '-')
        {
            $('#showFoCCProduc').hide();
            $('#showHideProductivityCC').hide();
        }
        else if($('#internalCCSelect').val() == 'Call Center')
        {
            $('#showFoCCProduc').show();
            $('#currentAccess').val('teletfs');
            $('#showForCCBank').show();

            if($('#ccteleList').val() == '-')
            {
                $('#showTimeStampProdCC').hide();
                $('#showHideProductivityCC').hide();
            }
            else if($('#ccteleList').val() != '-')
            {
                $('#showTimeStampProdCC').show();
                $('#showHideProductivityCC').show();
            }
            //
            $('#showForTeleTFS').hide();

            console.log('cc')
        }
        else if($('#internalCCSelect').val() == 'Tele-TFS')
        {
            $('#showFoCCProduc').show();
            $('#currentAccess').val('cc');
            $('#showForCCBank').hide();
            if($('#teleTFSList').val() == '-')
            {
                $('#showTimeStampProdCC').hide();
                $('#showHideProductivityCC').hide();
            }
            else if($('#teleTFSList').val() != '-')
            {
                $('#showTimeStampProdCC').show();
                $('#showHideProductivityCC').show();
            }
            //
            $('#showForTeleTFS').show();

            console.log('tfs')
        }
    }
    else if($(this).find(':selected').val() == '-')
    {
        $('#selectInternalCC').hide();
        $('#showFoCCProduc').hide();
        $('#showForBankProduc').hide();
        $('#showHideProductivityTable').hide();
        $('#showHideProductivityCC').hide();
    }

});

$('#internalCCSelect').change(function()
{
    if($(this).find(':selected').val() == 'Call Center')
    {
        $('#showFoCCProduc').show();
        $('#currentAccess').val('cc');

        if($('#ccteleList').find(':selected').val() != '-')
        {
            if(boolTableCC == false)
            {
                productivityTableCcGen();
            }
            else
            {
                tableCCprodEmp.ajax.reload(null, false);
            }

            $('#showTimeStampProdCC').show();
            $('.ccBankStat').hide();
            $('.ccStat').show();
            $('#showHideProductivityCC').show();
        }
        else if($('#ccteleList').find(':selected').val() == '-')
        {
            $('#showTimeStampProdCC').hide();
            $('#showHideProductivityCC').hide();
        }

        $('#showForCCBank').show();
        $('#showForTeleTFS').hide();
    }
    else if($(this).find(':selected').val() == 'Tele-TFS')
    {
        $('#showFoCCProduc').show();
        $('#currentAccess').val('teletfs');

        if($('#teleTFSList').find(':selected').val() != '-')
        {
            if(boolTableCC == false)
            {
                productivityTableCcGen();
            }
            else
            {
                tableCCprodEmp.ajax.reload(null, false);
            }

            $('#showTimeStampProdCC').show();
            $('.ccBankStat').show();
            $('.ccStat').hide();
            $('#showHideProductivityCC').show();
        }
        else if($('#teleTFSList').find(':selected').val() == '-')
        {
            $('#showTimeStampProdCC').hide();
            $('#showHideProductivityCC').hide();
        }

        $('#showForCCBank').hide();
        $('#showForTeleTFS').show();
    }
    else if($(this).find(':selected').val() == '-')
    {
        $('#showFoCCProduc').hide();
        $('#currentAccess').val('');
        $('#showForCCBank').hide();
        $('#showForTeleTFS').hide();
    }
});

$('#sao_productivity_table').on('click', '.showAccountsEmpProd', function()
{
    $('#sortByToTable').val($(this).attr('name'));
    $('#userToLookTable').val($(this).attr('idselect'));
    $('#dateToLookTable').val($(this).attr('info'));
    $('#posToLookTable').val($(this).attr('pos'));

    if(boolacctsUnder == true)
    {
        table_acc_under_prod.ajax.reload(null, false);
    }
    else
    {
        accUnderEmpTable();
    }



    $('#modal-prod-accts-emp').modal('show');
});


function accUnderEmpTable()
{
    $('#accounts_under_emp_productivity thead th').each(function()
    {
        accUndrEmpArr[countUnder] = $(this).text();
        countUnder++;
        title_endo = $(this).text();
        $(this).html(title_endo+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    table_acc_under_prod = $('#accounts_under_emp_productivity').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'colvis',
                        columnText: function (dt, idx, title)
                        {
                            return accUndrEmpArr[(idx)];
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return accUndrEmpArr[(idx)];
                                        }
                                    }
                            }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    type: 'get',
                    url: "/gen_accts_under_emp_date_table",
                    data: function (d)
                    {
                        d.sort_by_to_table = $('#sortByToTable').val();
                        d.user_to_where = $('#userToLookTable').val();
                        d.info_to_where = $('#dateToLookTable').val();
                        d.pos_to_table = $('#posToLookTable').val();
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'address', name: 'endorsements.address'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {data: 'muni_name', name: 'municipalities.muni_name'},
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'acct_status_view', name: 'endorsements.acct_status'}
                ],
            "order": [ [0, 'desc'] ],
            "pageLength": 10,
            "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
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

    $('#accounts_under_emp_productivity_filter input').unbind();
    $('#accounts_under_emp_productivity_filter input').bind('keyup change',function (e) {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_acc_under_prod.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_acc_under_prod.search($(this).val()).draw();
                }
            }
        }
    });

    boolacctsUnder = true;
}

function acc_under_emp_cc_table()
{
    $('#accounts_under_emp_productivity_cc thead th').each(function ()
    {
        accUndrEmpArrCC[countUnderCC] = $(this).text();
        countUnderCC++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_acc_under_prod_cc = $('#accounts_under_emp_productivity_cc').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                type: 'get',
                url: "/gen_accts_under_emp_date_table_cc",
                data: function (d)
                {
                    d.sort_by_to_table_cc = $('#sortByToTableCC').val();
                    d.user_to_where_cc = $('#userToLookTableCC').val();
                    d.info_to_where_cc = $('#dateToLookTableCC').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return accUndrEmpArrCC[(idx)];
                    }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return accUndrEmpArrCC[(idx)];
                                    }
                                }
                        }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'},
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        var countDownDate = new Date(data.date_time_due1);
                        var now = new Date();
                        var distance = countDownDate - now;

                        if(data.cancel_status == 'Cancelled')
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                        }
                        else if(data.cancel_status == 'Pending')
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Cancellation</a>';
                        }
                        else
                        {
                            if(data.status == 0)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                            }
                            else if (data.status == 20)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                            }
                            else if(data.status == 22)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                            }
                            else if(data.status == 23)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                            }
                            else if(data.status == 24)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                            }
                            else if(data.status == 25)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                            }
                            else if (data.status == 21)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Returned Enodrsement</a>';
                            }
                            else if (data.status == 5)
                            {
                                return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> On-Hold Account</a>';
                            }
                            else if (data.status == 4)
                            {
                                return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                            }
                            else if (data.status == 1)
                            {
                                if(distance > 1)
                                {
                                    return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                                        '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-wrench"></i> Ongoing </a>';

                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                                        '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> Late </a>';
                                }
                            }
                            else if (data.status == 10)
                            {
                                if(data.type_user == 'cc_bank')
                                {
                                    if(data.status_report == 'Contacted')
                                    {
                                        return '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                                    }
                                    else
                                    {
                                        return '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                                    }
                                }
                                else
                                {
                                    if(data.status_report == 'Complete')
                                    {
                                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                                            '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                                    }
                                    else {
                                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                                            '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                                    }
                                }

                            }
                            else if(data.status == 2)
                            {
                                return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned</a>';
                            }
                            else if(data.status == 3)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';
                            }
                        }
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                },
            ],

        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
        initComplete : function ()
        {
            var api = this.api();

            //Apply the search
            api.column().every(function()
            {
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

    $('#accounts_under_emp_productivity_cc_filter input').unbind();
    $('#accounts_under_emp_productivity_cc_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_acc_under_prod_cc.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_acc_under_prod_cc.search($(this).val()).draw();
                }
            }
        }
    });

    boolacctsUnderCC = true;


}



$('#cc_productivity_table').on('click', '.showAccountsEmpProdCC', function()
{
    $('#sortByToTableCC').val($(this).attr('name'));
    $('#userToLookTableCC').val($(this).attr('idselect'));
    $('#dateToLookTableCC').val($(this).attr('info'));

    checkPosCC = $(this).attr('pos');

    if (boolacctsUnderCC == true)
    {
        table_acc_under_prod_cc.ajax.reload(null, false);
    }
    else
    {
        acc_under_emp_cc_table();
    }

    if(checkPosCC == 'cc')
    {
        table_acc_under_prod_cc.column(1).visible(false);
    }
    else if(checkPosCC == 'teletfs')
    {
        table_acc_under_prod_cc.column(1).visible(true);
    }

    $('#modal-prod-accts-emp-cc').modal('show')
});

function DisplayCurrentTime(testDateTime) {
    var date = new Date(testDateTime);
    var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
    var am_pm = date.getHours() >= 12 ? "PM" : "AM";
    hours = hours < 10 ? "0" + hours : hours;
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    time = hours + ":" + minutes + ":" + seconds + " " + am_pm;

    return time;
}

function getAttendanceInfoGeneral()
{
    $('.general_attendance_logs tr').each(function()
    {
        if($(this).attr('style') != 'background-color: black; color:white;')
        {
            $(this).remove();
        }
    });
    $.ajax({
        type: 'get',
        url: 'gen_attendance_in_out_check',
        data: {
            'date_inputted' : null
        },
        success: function (data)
        {
            var to_append = '';
            // console.log(data);
            if(data[0].length > 0)
            {
                var dateFormater = '';
                var timeFormater = '';
                for(var i = 0; i < data[0].length; i++)
                {
                    dateFormater = new Date(data[0][i].created_at).toDateString();
                    to_append += '<tr>\n' +
                        '<td>'+dateFormater+'</td>\n' +
                        '<td>'+DisplayCurrentTime(data[0][i].time_in)+'</t>\n' +
                        '<td>'+data[0][i].type+'</td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="3">NO RECORDS FOUND</td>\n' +
                    '</tr>'
            }

            if(data[2] == false)
            {
                $('.attendance_all_click').attr('disabled', true);
            }
            else
            {
                $('.attendance_all_click').attr('disabled', false);
            }

            if(data[1][0].work_start != null && data[1][0].work_end != null || data[1][0].work_start != '' && data[1][0].work_end != '')
            {
                // console.log(data[1][0].work_start);
                // console.log(data[1][0].work_end);
                var $timeIN = data[1][0].work_start.split(':');
                var $timeIN2 = data[1][0].work_start.split(':');
                var $timeAmPM = data[1][0].work_start.split(' ');

                var $timeOUT = data[1][0].work_end.split(':');
                var $timeOUT2 = data[1][0].work_end.split(':');
                var $timeAmPMOUT = data[1][0].work_end.split(' ');

                $('.time_in_class_val[name="0"]').val($timeIN[0]);
                $('.time_in_class_val[name="1"]').val($timeIN2[1].split(' ')[0]);
                $('.time_in_class_val[name="2"]').val($timeAmPM[1]);

                $('.time_out_class_val[name="0"]').val($timeOUT[0]);
                $('.time_out_class_val[name="1"]').val($timeOUT2[1].split(' ')[0]);
                $('.time_out_class_val[name="2"]').val($timeAmPMOUT[1]);

                // $('.time_out_class_val[name="0"]').val(data[1][0].work_end.split(':')[0]);
                // $('.time_out_class_val[name="1"]').val(data[1][0].work_end.split(':')[1]);
                // $('.time_out_class_val[name="2"]').val(data[1][0].work_end.split(' ')[1]);

                $('#attendance_work_start').val(data[1][0].work_start);
                $('#attendance_work_end').val(data[1][0].work_end);
            }
            else
            {
                $('.time_in_class_val[name="0"]').val(0);
                $('.time_in_class_val[name="1"]').val(1);
                // $('.time_in_class_val[name="2"]').val($timeAmPM[1]);

                $('.time_out_class_val[name="0"]').val(0);
                $('.time_out_class_val[name="1"]').val(0);
                // $('.time_out_class_val[name="2"]').val($timeAmPMOUT[1]);
            }



            $('.general_attendance_logs').append(to_append);
        }
    });

}

$(document).on('click', '.attendance_general_modal', function()
{
    $('#modal-attendance-general').modal('show');
    $('.attendance_all_click').attr('disabled', true);
    getAttendanceInfoGeneral();
});

$('.attendance_all_click').click(function()
{
    var $type = $(this).attr('what');
    var btn = $(this);

    if($('#attendance_work_start').val() != '' && $('#attendance_work_end').val() != '')
    {
        if(confirm('Are you sure to ' + $type + ' ?'))
        {
            btn.attr('disabled', true);
            $.ajax({
                type: 'get',
                url: 'gen_emp_time_in_and_time_out',
                data: {
                    'type' : $type
                },
                success: function(data)
                {
                    console.log(data);
                    if(data == 'success')
                    {
                        alert($type + ' Captured');
                        getAttendanceInfoGeneral();
                    }
                    else if(data == 'no sched')
                    {
                        alert('Time Failed to Captured Check if the Daily Schedule is already saved then try again.');
                    }
                    btn.attr('disabled', false);
                },
                error: function(e)
                {
                    btn.attr('disabled', false);
                    alert('Error occured contact web dev for assistance. Thank you.');
                }
            });
        }
    }
    else
    {
        alert('Specify your schedule in the fields above. Thank you');
    }
});

$('#save_attendance_schedule').click(function()
{
    var btn = $(this);
    var InChecker = parseInt($('.time_in_class_val[name = "0"]').val());
    var OutChecker = parseInt($('.time_out_class_val[name = "0"]').val());

    if(InChecker != 0 && OutChecker != 0)
    {
        if($('#attendance_work_start').val() != '' && $('#attendance_work_end').val() != '')
        {
            if(confirm('Are you sure to update your daily schedule?'))
            {
                btn.attr('disabled', true);
                $.ajax({
                    type: 'get',
                    url: 'gen_save_daily_work_sched',
                    data:{
                        'work_start' :$('#attendance_work_start').val(),
                        'work_end' :$('#attendance_work_end').val()
                    },
                    success: function(data)
                    {
                        console.log(data);
                        alert('Daily Schedule Updated Successfully');
                        btn.attr('disabled', false);
                    },
                    error: function(e)
                    {
                        btn.attr('disabled', false);
                        alert('Error occured contact web dev for assistance. Thank you.');
                    }
                });
            }
        }
        else
        {
            alert('Fill the required fields');
        }
    }
    else
    {
        alert('Invalid Inputted Time');
    }


});

$('.time_in_class_val').change(function()
{
    var timeVal = '';
    var timeVal1 = parseInt($('.time_in_class_val[name = "0"]').val());
    var timeVal2 = parseInt($('.time_in_class_val[name = "1"]').val());
    var timeVal3 = $('.time_in_class_val[name = "2"]').val();

    if(timeVal1 > 0)
    {
        if(timeVal1 <= 9)
        {
            timeVal1 = '0'+timeVal1;
        }
        else if(timeVal1 > 12)
        {
            alert('Invalid Inputted Hour');
            timeVal1 = '08'
        }
    }
    else
    {
        alert('Invalid Inputted Hour');
    }


    if(timeVal2 <= 9)
    {
        timeVal2 = '0'+timeVal2;
    }

    $('.time_in_class_val[name = "0"]').val(timeVal1);
    $('.time_in_class_val[name = "1"]').val(timeVal2);
    $('.time_in_class_val[name = "2"]').val(timeVal3);

    timeVal = timeVal1 + ':' + timeVal2 + ' ' + timeVal3;

    $('#attendance_work_start').val(timeVal);
    // console.log(timeVal);
});

$('.time_out_class_val').change(function()
{
    var timeVal = '';
    var timeVal1 = parseInt($('.time_out_class_val[name = "0"]').val());
    var timeVal2 = parseInt($('.time_out_class_val[name = "1"]').val());
    var timeVal3 = $('.time_out_class_val[name = "2"]').val();

    if(timeVal1 > 0)
    {
        if(timeVal1 <= 9)
        {
            timeVal1 = '0'+timeVal1;
        }
        else if(timeVal1 > 12)
        {
            alert('Invalid Inputted Hour');
            timeVal1 = '08'
        }
    }
    else
    {
        alert('Invalid Inputted Hour');

    }

    if(timeVal2 <= 9)
    {
        timeVal2 = '0'+timeVal2;
    }

    $('.time_out_class_val[name = "0"]').val(timeVal1);
    $('.time_out_class_val[name = "1"]').val(timeVal2);
    $('.time_out_class_val[name = "2"]').val(timeVal3);

    timeVal = timeVal1 + ':' + timeVal2 + ' ' + timeVal3;

    $('#attendance_work_end').val(timeVal);
    // console.log(timeVal);
});

$('.gen_att_tabs').click(function()
{
    var id = $(this).attr('href');
    var check = $(this).attr('loaded');

    if(id == '#gen_att_tab2')
    {
        $('.attendance_all_click').hide();
        // getAttendanceInfoGeneralAll();
    }
    else
    {
        $('.attendance_all_click').show();
    }
    console.log(id);
});

function getAttendanceInfoGeneralAll()
{
    $('.general_attendance_logs_all tr').each(function()
    {
        if($(this).attr('style') != 'background-color: black; color:white;')
        {
            $(this).remove();
        }
    });

    $.ajax({
        type: 'get',
        url: 'gen_attendance_in_out_check',
        data: {
          'date_inputted' : $('#attendance_log_all_input').val()
        },
        success: function (data)
        {
            var to_append = '';
            // console.log(data);
            if(data[0].length > 0)
            {
                var dateFormater = '';
                var timeFormater = '';
                for(var i = 0; i < data[0].length; i++)
                {
                    dateFormater = new Date(data[0][i].created_at).toDateString();
                    to_append += '<tr>\n' +
                        '<td>'+dateFormater+'</td>\n' +
                        '<td>'+DisplayCurrentTime(data[0][i].time_in)+'</t>\n' +
                        '<td>'+data[0][i].type+'</td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="3">NO RECORDS FOUND</td>\n' +
                    '</tr>'
            }

            $('.general_attendance_logs_all').append(to_append);
        }
    });
}

$('#refresh_atten_logs').click(function()
{
    getAttendanceInfoGeneralAll();
});

var tableGenIssuance;

$('#loadMemoGenTable').click(function()
{
    funcIssuanceGenMonit()
});

$('.hideMeFromCI').show();

function funcIssuanceGenMonit()
{
    tableGenIssuance = $('#gen_sent_issuance_mail').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": 'gen_monit_issuance_table',
        "columns":
            [
                {data: 'date', name: 'hr_issuance_main.created_at'},
                {data: 'name_sender', name: 'users.name'},
                {data: 'to', name: 'hr_issuance_main.issuance_to'},
                {
                    data : function sub(data)
                    {
                        return '<b>' + data.subj + '</b>';
                    },
                    name: 'hr_issuance_main.issuance_subject'

                }
            ],
        "fnRowCallback": function(nRow, aData)
        {
            $(nRow).attr('name', btoa(aData.id));
        },
        "order": [[0, 'desc']],
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
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
                            if (that.search() !== this.value)
                            {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '')
                            {
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

    $('#gen_sent_issuance_mail_filter input').unbind();
    $('#gen_sent_issuance_mail_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableGenIssuance.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableGenIssuance.search($(this).val()).draw();
                }
            }
        }
    });
}


$('#gen_sent_issuance_mail tbody').on('click', 'tr', function ()
{
    var id = $(this).attr('name');

    $.ajax
    ({
        type : 'get',
        url : 'gen_fetch_issuance_indiv',
        data :
            {
                'id' : id
            },
        beforeSend : function()
        {
            $('#placeSubGenIssuance').html('');
            $('#placeMessageGenIssuance').html('');
            $('#placeSenderGenIssuance').html('');
            $('#loopAllFilesPlaceIssuance').html('');
        },
        success : function(data)
        {
            console.log(data)
            $('#placeSubGenIssuance').html(data[0][0].issuance_subject);
            $('#placeMessageGenIssuance').html(data[0][0].issuance_content);
            $('#placeSenderGenIssuance').html(data[0][0].name);


            if(data[1].length > 0)
            {
                for(var t = 0; t < data[1].length; t++)
                {
                    $('#loopAllFilesPlaceIssuance').append
                    (
                        '                                        <li>\n' +
                        '                                            <span class="mailbox-attachment-icon"><i class="fa fa-fw fa-file"></i></span>\n' +
                        '\n' +
                        '                                            <div class="mailbox-attachment-info" style="">\n' +
                        '                                                <a class="mailbox-attachment-name" href="/getHrIssuanceFilesGeneral/'+id+'/'+btoa(data[1][t].id)+'" target="_blank" > '+data[1][t].file_name+'</a>\n' +
                        '                                            </div>\n' +
                        '                                        </li>'
                    )
                }
            }


            $('#showSentIssuanceGen').hide();
            $('#showMessageGenIssuance').show();

        },
        error : function()
        {
            alert('An error has occured. Please contact the developers.')
        }
    })
});
//
$('#gen_sent_issuance_mail tbody').on('mouseover', 'tr', function ()
{
    $(this).css("background-color", "lightblue");
    $(this).css('cursor', 'pointer');
    $(this).attr('title', 'Please click to view details.');
});

$('#gen_sent_issuance_mail tbody').on('mouseout', 'tr', function ()
{
    $(this).removeAttr('style');
    $(this).css('cursor', 'default');
    $(this).removeAttr('title');
});

$('#refreshGenIssuanceTab').click(function()
{
    $('#showSentIssuanceGen').show();
    $('#showMessageGenIssuance').hide();
});

$('#btnRefreshTableIssuance').click(function()
{
    tableGenIssuance.ajax.reload(null, false);
});

$('.Acno_ref').click(function()
{
    $.ajax({
        url: 'fetch-admin-sendAcno',
        type: "get",
        data: {
            'id': $(this).attr('href')
        },
        success: function (data) {
            
            $("#tbl_acnoo li").each(function ()
            {
                if($(this).attr('id') == 'acno_header'){
    
                }
                else
                {
                    $(this).remove();
                }
            });
            
            var i;
            for (i=0; i < data.length; i++)
            {
                if(data[i].status != 'Acknowledge')
                {
                    $('#tbl_acnoo').append(
                        $('<li class="Acknowledge_Viewer" name="'+btoa(data[i].id)+'" style="cursor: pointer; background-color: #ffc107"></li>').append(
                        $('<a  style="text-align: center"></a>').html('Acknowledge Receipt Dated:' + ' ' + data[i].created_at))
                    );
                }
                else {
                    $('#tbl_acnoo').append(
                        $('<li class="Acknowledge_Viewer" name="'+btoa(data[i].id)+'" style="cursor: pointer; background-color: #28a745"></li>').append(
                        $('<a  style="text-align: center"></a>').html('Acknowledge Receipt Dated:' + ' ' + data[i].created_at))
                    );
                }
            }
        }
    });
});


$('#tbl_acnoo').on('click', '.Acknowledge_Viewer', function ()
    {
        var id = atob($(this).attr('name'));
        $('.ar_InputsView').val('');


    $.ajax({
        url: 'fetch-admin-viewAcknow',
        type: 'get',
        data:{
            'id': id
        },
        success: function (data) {



            $('#acknowledge-lister tr').each(function ()
            {
                if ($(this).attr('name') == 0) {

                }
                else {
                    $(this).remove();
                }
            });

            var attachment_boolHolder = (data[0][0].attachment_bool);
            var attachment_bool = attachment_boolHolder.split("||");
            attachment_bool.pop();
            $('#Ar_btnTable').show();

            if(data[0][0].status != 'Acknowledge')
                {
                    $('#btnArToAcknowledge').prop('disabled', false);
                    $('#btnArToAcknowledge').attr('href', btoa(data[0][0].id));

                }
                else
                {
                    $('#btnArToAcknowledge').prop('disabled', true);
                }

            $('#ar_name_view').val(data[0][0].Employee_name);
            $('#ar_loc_dept_view').val(data[0][0].office_loc_dep_pos);
            $('#ar_cont_email_view').val(data[0][0].cnum_email);
            $('#ar_lbc_branch_view').val(data[0][0].LBC_Branch);


            console.log(data);
            for(var i=0; i < data[1].data.length; i++){
                $('#acknowledge-lister').append(
                    $('<tr></tr>').append(
                        $('<td></td>').html('<input type="number" class="form-control ar_InputsView" value="'+data[1].data[i].item_quantity+'" disabled>'),
                        $('<td></td>').append($('<textarea class="form-control ar_inputsView" disabled></textarea>').val(data[1].data[i].brand_desc)),
                        $('<td></td>').html('<input type="text" class="form-control ar_inputsView" value="'+data[1].data[i].warranty_period+'" disabled>')
                    )
                )
            }
             for (var j=0; j < attachment_bool.length; j++){
                if(attachment_bool[j] == 'true')
                {
                    $('.Check_arView[name="'+j+'"]').prop('checked', true);
                }
                else {
                    $('.Check_arView[name="'+j+'"]').prop('checked', false);
                }
             }
       }
   })
});

    $('#btnArToAcknowledge').on('click', function ()
        {
            $('#btnArToAcknowledge').prop('disabled', true);
            $.ajax({
                url: '/acknowledge-form-status',
                type: 'get',
                data: {
                    'id': atob($(this).attr('href'))
                },
                success: function (data) {
                    $('.Acno_ref').click();
                    $('#btnArToAcknowledge').prop('disabled', true);
                    alert('AR Successfully Acknowledge');
                    console.log(data);
                }
            })
    });
    
    
get_user_archipelago();

function get_user_archipelago()
{
    $('#table_user_archipelago_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    table_user_archipelogo = $('#table_user_archipelago').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                url: "get_user_archipelago",
                data: function (d)
                {
                    d.arch = $('#filter_archipelagos_id').find(':selected').val();
                }
            },
        "columns":
            [
                {data: 'emp_name', name: 'users.name'},
                {data: 'province_name', name: 'provinces.name'},
                {
                    data:function work_sched(data)
                    {

                        var workEnd = data.work_end;
                        var splitAmPm,getHour,FinalOutput,workstart;

                        if(workEnd != null || workEnd != '')
                        {
                            console.log('first if');
                            console.log(workEnd);
                            if(workEnd == null)
                            {
                                FinalOutput = '';
                            }
                            else
                            {
                                splitAmPm = workEnd.split(' ');
                                FinalOutput = splitAmPm;
                            }
                          
                        }
                        else
                        {
                            FinalOutput = 'wala laman';
                        }
                
                        if(workEnd != null || workEnd != '' || workEnd != 'NaN:NaN PM')
                        {
                            
                            console.log('second if');
                            console.log(workEnd);
                            
                           if(workEnd == null)
                            {
                                FinalOutput = '';
                            }
                            else
                            {
                                splitAmPm = workEnd.split(' ');
                           
                                FinalOutput = (parseInt(splitAmPm[0].split(':')[0]) + 12) + ':' + splitAmPm[0].split(':')[1];
                            }
                            
                           
                        }


                        if(data.work_start == null)
                        {
                            var workstart = '';
                        }
                        else
                        {
                            var workstart = data.work_start.split(' ')[0];
                        }

                        return  '<div class="input-group"><input type="time" class="form-control  change_sched_input work_start_attend" value="'+workstart+'" name="'+data.id+'" id="'+data.id+'" disabled="true" style="width:47%; margin-right: 5px; margin-top: 5px">'+
                            '<input type="time" class="form-control change_sched_input work_end_attend" value="'+FinalOutput+'" name="'+data.id+'" id="'+data.id+'"  disabled="true" style="max-width:47%; margin-right: 5px; margin-top: 5px"></div>'
                    },
                    'name' : 'name',
                    searchable : false,
                    orderable : false

                },

                {
                    data:function action(data)
                    {
                        return'' +
                            '<button class="btn btn-block btn-success btn-sm save_schedule_time" disabled="true" name="'+data.id+'" href="'+btoa(data.emp_name)+'">Save</button>'+
                            '<button class="btn btn-block btn-info btn-sm logs_schedule_time" id="'+btoa(data.id)+'" data-target="#modal_users_attendance_logs" name="'+data.id+'" data-toggle="modal" href="'+btoa(data.emp_name)+'"><i class="glyphicon glyphicon-film">Logs</button>'
                    },
                    'name' : 'name',
                    searchable : true,
                    orderable : false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 5,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        initComplete: function () {

            $('#table_user_archipelago').on('dblclick', '.change_sched_input', function () {
                var identifier = $(this).attr('name');

                if ($(this).is(":disabled"))
                {
                    $('.change_sched_input').each(function () {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", false);
                        }
                    });

                    $('.save_schedule_time').each(function()
                    {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", false);
                        }
                    });

                }
                else
                {
                    $('.save_schedule_time').each(function () {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", true);
                        }
                    });

                    $('.save_schedule_time').each(function()
                    {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", true);
                        }
                    });

                }
            });

            $('#table_user_archipelago').on('click', '.save_schedule_time', function ()
            {
                var inputted_start = '';
                var inputted_end = '';
                var user_id = $(this).attr('name');
                var validatorIfNull = false;

                $('.change_sched_input').each(function () {
                    if ($(this).attr('name') == user_id) {
                        if($(this).val() != '')
                        {
                            validatorIfNull = true;
                        }
                        else
                        {
                            alert('Fill-up required fields.');
                            validatorIfNull = false;
                            return false;
                        }
                    }
                });

                if(validatorIfNull)
                {
                    if(confirm('Are you sure to update ' + atob($(this).attr('href')) + ' schedule?'))
                    {

                        $('.change_sched_input ').each(function()
                        {
                            if(!$(this).is(":disabled"))
                            {
                                if($(this).hasClass('work_start_attend'))
                                {
                                    inputted_start = $(this).val();
                                    $('.save_schedule_time').prop('disabled', true);
                                    $('.change_sched_input').prop('disabled', true);

                                }
                                else
                                {
                                    inputted_end= $(this).val();
                                }
                            }
                        });
                    }
                    else
                    {
                        console.log('do nothing');
                    }
                    $.ajax({
                        url: 'get_management_saveTime',
                        type: 'get',
                        data:{
                            'id' : $(this).attr('name'),
                            'work_start' : $('.work_start_attend').val(),
                            'work_end' : $('.work_end_attend').val()
                        },
                        success: function (data) {
                            alert ('Employee Schedule Successfully Updated');

                        }
                    });

                }
            });
        }
    });

    $('#table_user_archipelago_filter input').unbind();
    $('#table_user_archipelago_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                table_user_archipelogo.search($(this).val()).draw();

            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_user_archipelogo.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#filter_archipelagos_id').change(function()
{
    table_user_archipelogo.draw();
});


$('#table_user_archipelago').on('click', '.logs_schedule_time', function()
{
    $('#attendance_user_logs').html('');
    var id = $(this).attr('name');
    ViewAttendance_logs(id);
});

function ViewAttendance_logs(id)
{
    $.ajax({
        type: 'get',
        url: 'users_management_view_logs',
        data: {
            'id' : id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '')
            {
                $('#attendance_user_logs').html('<table class="table-hover" width="100%">\n' +
                    '<tr style="background-color: brown; color:white; text-align: left">\n' +
                    '<th>Name</th>\n' +
                    '<th>Position</th>\n' +
                    '<th>Activity</th>\n' +
                    '<th>Date Time Ocurred</th>\n' +
                    '</tr>\n' +
                    '<tr>\n' +
                    '<td colspan="5">No Available Records</td>\n' +
                    '</tr>\n' +
                    '</table>');
            }
            else
            {
                var dataTable = '';
                var tableHead = '<table class="table-hover" width="100%">\n' +
                    '                                <tr style="background-color: brown; color:white; text-align: left">\n' +
                    '                                    <th>Name</th>\n' +
                    '                                    <th>Position</th>\n' +
                    '                                    <th>Activity</th>\n' +
                    '                                    <th>Date Time Occured</th>\n' +
                    '                                </tr>';

                for(var i = 0;i < data[0].length; i++)
                {
                    dataTable += '<tr>\n' +
                        '    <td>' + data[0][i].name + '</td>\n' +
                        '    <td>' + data[0][i].position + '</td>\n' +
                        '    <td>' + data[0][i].activity + '</td>\n' +
                        '    <td>' + data[0][i].created_at + '</td>\n' +
                        '</tr>';
                }

                $('#attendance_user_logs').html(tableHead + dataTable + '</table>');
            }

        }
    });
}

$('.gen_att_tabs1 ').click(function()
{
    var gethref = $(this).attr('href');

    if(gethref == '#gen_att_tab3')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');

        }
        else if(attendance_sched)
        {
            console.log('already loaded');

        }
        else if(attendance_sched == false)
        {
            attendance_sched = true;
            get_user_archipelago();
        }
    }
});

$('.gen_att_tabs').click(function()
{
    var id = $(this).attr('href');
    var check = $(this).attr('loaded');

    if(id == '#gen_att_tab2')
    {
        $('.hide_me_attendance_btn').hide();
        $('.attendance_all_click').hide();
    }
    else if(id == '#gen_att_tab3'){
        $('.hide_me_attendance_btn').hide();
        $('.attendance_all_click').hide();
    }
    else if(id == '#gen_att_tab4'){
        $('.hide_me_attendance_btn').hide();
        $('.attendance_all_click').hide();
    }
    else
    {
        $('.hide_me_attendance_btn').show();
    }
    console.log(id);
});