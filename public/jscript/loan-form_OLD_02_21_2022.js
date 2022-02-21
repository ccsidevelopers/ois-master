

// Code for citizenship checkboxes to behave like a radio button
$('.chbCitizenship').click(function(){
    $('.chbCitizenship').each(function(){
        $(this).prop('checked', false); 
    }); 
    $(this).prop('checked', true);

    //Checks if 'Other' option are checked and enable input field
    if ($('#inputLoanCitizenshipOthers').is(':checked')) {
        $('#inputLoanCitizenshipOthersEnter').prop('disabled', false);
    } else {
        $('#inputLoanCitizenshipOthersEnter').prop('disabled', true);
        $('#inputLoanCitizenshipOthersEnter').val('');
    }
    
});


// $('.chbEmploymentStatus').click(function(){
//     $('.chbEmploymentStatus').each(function(){
//         $(this).prop('checked', false); 
//     }); 
//     $(this).prop('checked', true);

//     //Checks if 'Other' option are checked and enable input field
//     if ($('#inputLoanStatusOthers').is(':checked')) {
//         $('#inputLoanStatusOthersEnter').prop('disabled', false);
//     } else {
//         $('#inputLoanStatusOthersEnter').prop('disabled', true);
//         $('#inputLoanStatusOthersEnter').val('');
//     }

// });

// function chbRadio(chb)

// function applied(func, args) {
//     return function() {
//       func.apply(null, args);
//     }
//   }



// $('#inputLoanIncomeOthers').click(function() {
//     if ($(this).is(':checked')) {
//         $('#inputLoanIncomeOthersEnter').prop('disabled', false);
//     } else {
//         $('#inputLoanIncomeOthersEnter').prop('disabled', true);
//         $('#inputLoanIncomeOthersEnter').val('');
//     }
// });


//Reusable function for toggling other input field
function myFunction(chbOthers, ChbOthersEnter) {
    ChbOthersEnter.prop('disabled', false);
    chbOthers.click(function() {
        if ($(this).is(':checked')) {
            ChbOthersEnter.prop('disabled', false);
            alert(sampleBurat)
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


//Use this syntax below to reuse the function other input above
$('#inputLoanIncomeOthers').click(applied(myFunction, [$('#inputLoanIncomeOthers'), $('#inputLoanIncomeOthersEnter')]));
$('#inputLoanStatusOthers').click(applied(myFunction, [$('#inputLoanStatusOthers'), $('#inputLoanStatusOthersEnter')]));


$('#inputLoanAgreeChb').click(function() {
    if ($(this).is(':checked')) {
        $('#submitKioskLoanBtn').prop('disabled', false);

        var getValue = $('#inputLoanCitizenshipOthers').val();
        $('#inputLoanCitizenshipOthers').val(getValue);

        // var civilStatus = $('#inputLoanCivilStatus').find(":selected").text();

        //Submit data to LoanFormController to DB
        $('#submitKioskLoanBtn').click(function() {

            //get the value of 'others' input in citizenship
            var getCitizenshipOtherVal = $('#inputLoanCitizenshipOthersEnter').val();
            $('#inputLoanCitizenshipOthers').val(getCitizenshipOtherVal);

            //get the value of selected option of civil status
            $('select.civilStatus').change(function() {
                var selectedCivilStatus = $(this).children('option:selected').val();
                $('#inputLoanCivilStatus').val(selectedCivilStatus);
            });
    
            if(confirm('Submit this info now?')) {
                $.ajax({
                    url: 'kiosk_create',
                    type: 'get',
                    data: {
                        // 'type_of_loan': $('input[name="typeOfLoan"]:checked'),
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
                        // 'source_of_income': $('input[name=""]').val(),
                        'employment_status': $('#inputLoanFName').val(),
                        'for_employed': $('#inputLoanFName').val(),
                        'for_self_employed': $('#inputLoanFName').val(),
                        'name_of_employer_business': $('#inputLoanFName').val(),
                        'job_title_position': $('#inputLoanFName').val(),
                        'nature_of_business': $('#inputLoanFName').val(),
                        'gross_annual_income': $('#inputLoanFName').val(),
                        'years_with_employer_in_business': $('#inputLoanFName').val(),
                        'months_with_employer_in_business': $('#inputLoanFName').val(),
                    },
                    success: function(data) {
                        console.log(data);s
                    }
                });
            }
        });

    } else {
        $('#submitKioskLoanBtn').prop('disabled', true);
    }
});

