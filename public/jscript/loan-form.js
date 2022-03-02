// Code for citizenship checkboxes to behave like a radio button
$('.chbCitizenship').click(function(){
    $('.chbCitizenship').each(function(){
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


$('.chbEmploymentStatus').click(function(){
    $('.chbEmploymentStatus').each(function(){
        $(this).prop('checked', false); 
    }); 
    $(this).prop('checked', true);

    // Checks if 'Other' option are checked and enable input field
    if ($('#inputLoanStatusOthers').is(':checked')) {
        $('#inputLoanStatusOthersEnter').prop('disabled', false);
    } else {
        $('#inputLoanStatusOthersEnter').prop('disabled', true);
        $('#inputLoanStatusOthersEnter').val('');
    }
});


$('.chbForEmployed').click(function(){
    $('.chbForEmployed').each(function(){
        $(this).prop('checked', false); 
    }); 
    $(this).prop('checked', true);
});


$('.chbForSelfEmployed').click(function(){
    $('.chbForSelfEmployed').each(function(){
        $(this).prop('checked', false); 
    }); 
    $(this).prop('checked', true);
});


// Reusable function for toggling other input field
function myFunction(chbOthers, ChbOthersEnter) {
    ChbOthersEnter.prop('disabled', false);
    chbOthers.click(function() {
        if ($(this).is(':checked')) {
            ChbOthersEnter.prop('disabled', false);
        } else {
            ChbOthersEnter.prop('disabled', true);
            ChbOthersEnter.val('');
        }
    });
}

function applied(func, args) {
  return function() {
    func.apply(null, args);
  }
}

// Use this syntax below to reuse the function other input above
$('#inputLoanIncomeOthers').click(applied(myFunction, [$('#inputLoanIncomeOthers'), $('#inputLoanIncomeOthersEnter')]));


$('#inputLoanAgreeChb').click(function() {

    const TOLselector = [];
    const SOIselector = [];

    $('.TOLselect').each(function() {
        if($(this).is(':checked')) {
            TOLselector.push($(this).val());
        }
    });
    // Type Of Loan Temporary storage
    $('#TOLTempStorage').val(TOLselector);

    var getIncomeOthersVal = $('#inputLoanIncomeOthersEnter').val();
    $('#inputLoanIncomeOthers').val(getIncomeOthersVal);

    $('.SOIselect').each(function() {
        if($(this).is(':checked')) {
            SOIselector.push($(this).val());
        }
    });
    // Source Of Income Temporary storage
    $('#SOITempStorage').val(SOIselector);


    if ($(this).is(':checked')) {
        $('#submitKioskLoanBtn').prop('disabled', false);

        $('#submitKioskLoanBtn').click(function() {

            // Get the value of 'others' input in citizenship
            var getCitizenshipOtherVal = $('#inputLoanCitizenshipOthersEnter').val();
            $('#inputLoanCitizenshipOthers').val(getCitizenshipOtherVal);

            var getEmploymentStatusVal = $('#inputLoanStatusOthersEnter').val();
            $('#inputLoanStatusOthers').val(getEmploymentStatusVal);

            // Get the value of selected option of civil status
            $('select.civilStatus').change(function() {
                var selectedCivilStatus = $(this).children('option:selected').val();
                $('#inputLoanCivilStatus').val(selectedCivilStatus);
            });   
    
            if(confirm('Submit this info now?')) {
                $.ajax({
                    url: 'kiosk_create',
                    type: 'get',
                    data: {
                        'type_of_loan': $('#TOLTempStorage').val(),
                        'applicant_lname': $('#inputLoanLName').val(),
                        'applicant_fname': $('#inputLoanFName').val(),
                        'applicant_mname': $('#inputLoanMName').val(),
                        'applicant_suffix': $('#inputLoanSName').val(),
                        'personal_mobile_number': $('#inputLoanMobileNumber').val(),
                        'personal_email_address': $('#inputLoanEmailAddress').val(),
                        'home_landline_number': $('#inputLoanHomeNumber').val(),
                        'pre_unit_number_bld_st_subd_brgy': $('#inputLoanPresentAddress1').val(),
                        'pre_city_municipality': $('#inputLoanPresentAddress2').val(),
                        'pre_province': $('#inputLoanPresentAddress3').val(),
                        'per_unit_number_bld_st_subd_brgy': $('#inputLoanPermanentAddress1').val(),
                        'per_city_municipality': $('#inputLoanPermanentAddress2').val(),
                        'per_province': $('#inputLoanPermanentAddress3').val(),
                        'work_email_address': $('#inputLoanWorkEmailAddress').val(),
                        'work_landline_number': $('#inputLoanWorkLandlineNumber').val(),
                        'work_unit_number_bld_st_subd_brgy': $('#inputLoanWorkAddress1').val(),
                        'work_city_municipality': $('#inputLoanWorkAddress2').val(),
                        'work_province': $('#inputLoanWorkAddress3').val(),
                        'birth_date': $('#inputLoanBirthdate').val(),
                        'birth_place': $('#inputLoanBirthPlace').val(),
                        'citizenship': $('input[name="citizenship"]:checked').val(),
                        'gender': $('input[name="gender"]:checked').val(),
                        'civil_status': $('#inputLoanCivilStatus').val(),
                        'home_ownership': $('#inputLoanHomeOwnership').val(),
                        'sss_gsis_number': $('#inputLoanSssGsisNumber').val(),
                        'tin_number': $('#inputLoanTinNumber').val(),
                        'spouse_lname': $('#inputLoanSpouseLName').val(),
                        'spouse_fname': $('#inputLoanSpouseFName').val(),
                        'spouse_mname': $('#inputLoanSpouseMName').val(),
                        'spouse_suffix': $('#inputLoanSpouseSName').val(),
                        'mothers_maiden_lname': $('#inputLoanMothersMaidenLName').val(),
                        'mothers_maiden_fname': $('#inputLoanMothersMaidenFName').val(),
                        'mothers_maiden_mname': $('#inputLoanMothersMaidenMName').val(),
                        'source_of_income': $('#SOITempStorage').val(),
                        'employment_status': $('input[name="employmentStatus"]:checked').val(),
                        'for_employed': $('input[name="forEmployed"]:checked').val(),
                        'for_self_employed': $('input[name="forSelfEmployed"]:checked').val(),
                        'name_of_employer_business': $('#inputLoanEmpBusinessName').val(),
                        'job_title_position': $('#inputLoanJobPositionName').val(),
                        'nature_of_business': $('#inputLoanNatureOfBusiness').val(),
                        'gross_annual_income': $('#inputLoanGAIncome').val(),
                        'years_with_employer_in_business': $('#inputLoanYearsWithEmployer').val(),
                        'months_with_employer_in_business': $('#inputLoanMonthsWithEmployer').val(),
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            }
        }); 
    
    } else {
        $('#submitKioskLoanBtn').prop('disabled', true);
    }
});


// If Present and Permanent address are the same
$('#inputLoanSameAddressCheck').click(function() {
    var presentAddress1 = $('#inputLoanPresentAddress1').val();
    var presentAddress2 = $('#inputLoanPresentAddress2').val();
    var presentAddress3 = $('#inputLoanPresentAddress3').val();

    if($(this).is(':checked')) {
        $('#inputLoanPermanentAddress1').val(presentAddress1);
        $('#inputLoanPermanentAddress2').val(presentAddress2);
        $('#inputLoanPermanentAddress3').val(presentAddress3);
    } else {
        $('#inputLoanPermanentAddress1').val('');
        $('#inputLoanPermanentAddress2').val('');
        $('#inputLoanPermanentAddress3').val('');
    } 
});