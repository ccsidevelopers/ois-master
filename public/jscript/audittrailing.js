/**
 * Created by aa on 9/21/2017.
 */
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});

document.getElementById("email").focus();


$('#individual_client_href').on('click',function (e)
{
    $('#modal-click-here').modal('show');

});

function submit_form() {
    if($('#check_agreement').is(':checked')) {
        return true;
    } else {
        alert("To proceed you must accept the terms.");
        return false;
    }
}