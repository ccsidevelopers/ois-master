// Invoke function names
$(function() {
    submitData();
    isAgreementChecked();
    isAddressTheSame();
    isOtherInputChecked();
    getTypeOfLoan();
});

function submitData() {
    $('#submitKioskLoanBtn').click(function() {
        
        // Get the value of other input
        var getCitizenshipOtherVal = $('#inputLoanCitizenshipOthersEnter').val();
        $('#inputLoanCitizenshipOthers').val(getCitizenshipOtherVal);

        var getEmploymentStatusVal = $('#inputLoanStatusOthersEnter').val();
        $('#inputLoanStatusOthers').val(getEmploymentStatusVal);

        var getSourceOfIncomeVal = $('#inputLoanIncomeOthersEnter').val();
        $('#inputLoanIncomeOthers').val(getSourceOfIncomeVal);
    });
}

function isAgreementChecked() {
    $('#inputLoanAgreeChb').click(function() {
        if ($(this).is(':checked')) {
            $('#submitKioskLoanBtn').prop('disabled', false);   
        } else {
            $('#submitKioskLoanBtn').prop('disabled', true);
        }
    });
}

function isAddressTheSame() {
    $('#inputLoanSameAddressCheck').click(function() {
        if ($(this).is(':checked')) {
            var preAddress1 = $('#inputLoanPresentAddress1').val();
            var preAddress2 = $('#inputLoanPresentAddress2').val();
            var preAddress3 = $('#inputLoanPresentAddress3').val();

            $('#inputLoanPermanentAddress1').val(preAddress1);
            $('#inputLoanPermanentAddress2').val(preAddress2);
            $('#inputLoanPermanentAddress3').val(preAddress3);
        } else {
            $('#inputLoanPermanentAddress1').val('');
            $('#inputLoanPermanentAddress2').val('');
            $('#inputLoanPermanentAddress3').val('');
        }

    });
}

function isOtherInputChecked() {

    // Citizenship other input
    $('.radioCitizenship').click(function() {
        $('.radioCitizenship').each(function() {
            $(this).prop('checked', false); 
        }); 
        $(this).prop('checked', true);
    
        // Checks if 'Other' option are checked and enable input field
        if ($('#inputLoanCitizenshipOthers').is(':checked')) {
            $('#inputLoanCitizenshipOthersEnter').prop('disabled', false);
        } else {
            $('#inputLoanCitizenshipOthersEnter').prop('disabled', true);
            $('#inputLoanCitizenshipOthersEnter').val('');
        }
    });

    // Source of income other input
    $('.radioSOI').click(function() {
        $('.radioSOI').each(function() {
            $(this).prop('checked', false);
        });
        $(this).prop('checked', true);

        //Checks if 'Other' option are checked enable input field
        if ($('#inputLoanIncomeOthers').is(':checked')) {
            $('#inputLoanIncomeOthersEnter').prop('disabled', false);
        } else {
            $('#inputLoanIncomeOthersEnter').prop('disabled', true);
            $('#inputLoanIncomeOthersEnter').val('');
        }
    });

    // Employment status other input
    $('.radioEmploymentStatus').click(function() {
        $('.radioEmploymentStatus').each(function() {
            $(this).prop('checked', false);
        });
        $(this).prop('checked', true);

        // Checks if 'Other' option are checked enable input field
        if ($('#inputLoanStatusOthers').is(':checked')) {
            $('#inputLoanStatusOthersEnter').prop('disabled', false);
        } else {
            $('#inputLoanStatusOthersEnter').prop('disabled', true);
            $('#inputLoanStatusOthersEnter').val('');
        }
    });
}

function getTypeOfLoan() {

    // Reusable function for Type of loan repetitive code
    function isTOLChecked(typeOfLoanID){
        typeOfLoanID.click(function() {
            var isCheck = $(this).is(':checked');
            isCheck ? typeOfLoanID.val(true) : false;
        });
    }
        
    // Reuse the function here
    $('#inputLoanMotorcycleLoan').click(isTOLChecked($('#inputLoanMotorcycleLoan')));
    $('#inputLoanAutoLoan').click(isTOLChecked($('#inputLoanAutoLoan')));
    $('#inputLoanPersonalLoan').click(isTOLChecked($('#inputLoanPersonalLoan')));
    $('#inputLoanHomeLoan').click(isTOLChecked($('#inputLoanHomeLoan')));
}