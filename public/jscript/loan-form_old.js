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


$('.chbEmploymentStatus').click(function(){
    $('.chbEmploymentStatus').each(function(){
        $(this).prop('checked', false); 
    }); 
    $(this).prop('checked', true);

    //Checks if 'Other' option are checked and enable input field
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


//Reusable function for toggling other input field
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

//Use this syntax below to reuse the function other input above
$('#inputLoanIncomeOthers').click(applied(myFunction, [$('#inputLoanIncomeOthers'), $('#inputLoanIncomeOthersEnter')]));


$('#inputLoanAgreeChb').click(function() {
    if ($(this).is(':checked')) {
        $('#submitKioskLoanBtn').prop('disabled', false);

        // Get multiple checkbox value
        var TOLSelector = [];

        $('.TOLSelect').each(function() {
            if($(this).is(':checked')) {
                TOLSelector.push($(this).val());
            }
        });
        $('#TOLTempStorage').val(TOLSelector);


        var SOISelector = [];

        var getSourceOfIncomeOtherVal = $('#inputLoanIncomeOthersEnter').val();
        $('#inputLoanIncomeOthers').val(getSourceOfIncomeOtherVal);

        $('.SOISelect').each(function() {
            if($(this).is(':checked')) {
                SOISelector.push($(this).val());
            }
        });
        $('#SOITempStorage').val(SOISelector);
        

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
            
            
            //Working on - start
            var formData = new FormData();
            var type_of_loan_data = $('#TOLTempStorage').val();
            var applicant_lname_data = $('#inputLoanLName').val();
            var applicant_fname_data = $('#inputLoanFName').val();
            var applicant_mname_data = $('#inputLoanMName').val();
            var applicant_suffix_data = $('#inputLoanSName').val();
            var personal_mobile_number_data = $('#inputLoanMobileNumber').val();
            var personal_email_address_data = $('#inputLoanEmailAddress').val();
            var home_landline_number_data = $('#inputLoanHomeNumber').val();
            var pre_unit_number_bld_st_subd_brgy_data = $('#inputLoanPresentAddress1').val();
            var pre_city_municipality_data = $('#inputLoanPresentAddress2').val();
            var pre_province_data = $('#inputLoanPresentAddress3').val();
            var per_unit_number_bld_st_subd_brgy_data = $('#inputLoanPermanentAddress1').val();
            var per_city_municipality_data = $('#inputLoanPermanentAddress2').val();
            var per_province_data = $('#inputLoanPermanentAddress3').val();
            var work_email_address_data = $('#inputLoanWorkEmailAddress').val();
            var work_landline_number_data = $('#inputLoanWorkLandlineNumber').val();
            var work_unit_number_bld_st_subd_brgy_data = $('#inputLoanWorkAddress1').val();
            var work_city_municipality_data = $('#inputLoanWorkAddress2').val();
            var work_province_data = $('#inputLoanWorkAddress3').val();
            var birth_date_data = $('#inputLoanBirthdate').val();
            var birth_place_data = $('#inputLoanBirthPlace').val();
            var citizenship_data = $('input[name="citizenship"]:checked').val();
            var gender_data = $('input[name="gender"]:checked').val();
            var civil_status_data = $('#inputLoanCivilStatus').val();
            var home_ownership_data = $('#inputLoanHomeOwnership').val();
            var sss_gsis_number_data = $('#inputLoanSssGsisNumber').val();
            var tin_number_data = $('#inputLoanTinNumber').val();
            var spouse_lname_data = $('#inputLoanSpouseLName').val();
            var spouse_fname_data = $('#inputLoanSpouseFName').val();
            var spouse_mname_data = $('#inputLoanSpouseMName').val();
            var spouse_suffix_data = $('#inputLoanSpouseSName').val();
            var mothers_maiden_lname_data = $('#inputLoanMothersMaidenLName').val();
            var mothers_maiden_fname_data = $('#inputLoanMothersMaidenFName').val();
            var mothers_maiden_mname_data = $('#inputLoanMothersMaidenMName').val();
            var source_of_income_data = $('#SOITempStorage').val();
            var employment_status_data = $('input[name="employmentStatus"]:checked').val();
            var for_employed_data = $('input[name="forEmployed"]:checked').val();
            var for_self_employed_data = $('input[name="forSelfEmployed"]:checked').val();
            var name_of_employer_business_data = $('#inputLoanEmpBusinessName').val();
            var job_title_position_data = $('#inputLoanJobPositionName').val();
            var nature_of_business_data = $('#inputLoanNatureOfBusiness').val();
            var gross_annual_income_data = $('#inputLoanGAIncome').val();
            var years_with_employer_in_business_data = $('#inputLoanYearsWithEmployer').val();
            var months_with_employer_in_business_data = $('#inputLoanMonthsWithEmployer').val();

            formData.append('type_of_loan', type_of_loan_data);
            formData.append('applicant_lname', applicant_lname_data);
            formData.append('applicant_fname', applicant_fname_data);
            formData.append('applicant_mname', applicant_mname_data);
            formData.append('applicant_suffix', applicant_suffix_data);
            formData.append('personal_mobile_number', personal_mobile_number_data);
            formData.append('personal_email_address', personal_email_address_data);
            formData.append('home_landline_number', home_landline_number_data);
            formData.append('pre_unit_number_bld_st_subd_brgy', pre_unit_number_bld_st_subd_brgy_data);
            formData.append('pre_city_municipality', pre_city_municipality_data);
            formData.append('pre_province', pre_province_data);
            formData.append('per_unit_number_bld_st_subd_brgy', per_unit_number_bld_st_subd_brgy_data);
            formData.append('per_city_municipality', per_city_municipality_data);
            formData.append('per_province', per_province_data);
            formData.append('work_email_address', work_email_address_data);
            formData.append('work_landline_number', work_landline_number_data);
            formData.append('work_unit_number_bld_st_subd_brgy', work_unit_number_bld_st_subd_brgy_data);
            formData.append('work_city_municipality', work_city_municipality_data);
            formData.append('work_province', work_province_data);
            formData.append('birth_date', birth_date_data);
            formData.append('birth_place', birth_place_data);
            formData.append('citizenship', citizenship_data);
            formData.append('gender', gender_data);
            formData.append('civil_status', civil_status_data);
            formData.append('home_ownership', home_ownership_data);
            formData.append('sss_gsis_number', sss_gsis_number_data);
            formData.append('tin_number', tin_number_data);
            formData.append('spouse_lname', spouse_lname_data);
            formData.append('spouse_fname', spouse_fname_data);
            formData.append('spouse_mname', spouse_mname_data);
            formData.append('spouse_suffix', spouse_suffix_data);
            formData.append('mothers_maiden_lname', mothers_maiden_lname_data);
            formData.append('mothers_maiden_fname', mothers_maiden_fname_data);
            formData.append('mothers_maiden_mname', mothers_maiden_mname_data);
            formData.append('source_of_income_datasource_of_income', source_of_income_data);
            formData.append('employment_status', employment_status_data);
            formData.append('for_employed', for_employed_data);
            formData.append('for_self_employed', for_self_employed_data);
            formData.append('name_of_employer_business', name_of_employer_business_data);
            formData.append('job_title_position', job_title_position_data);
            formData.append('nature_of_business', nature_of_business_data);
            formData.append('gross_annual_income', gross_annual_income_data);
            formData.append('years_with_employer_in_business', years_with_employer_in_business_data);
            formData.append('months_with_employer_in_business', months_with_employer_in_business_data);
            
            //Working on - end


            if(confirm('Submit this info now?')) {
                $.ajax({
                    url: 'kiosk_create',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        console.log('Data successfully submitted!');
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
    var preAddress1 = $('#inputLoanPresentAddress1').val();
    var preAddress2 = $('#inputLoanPresentAddress2').val();
    var preAddress3 = $('#inputLoanPresentAddress3').val();

    if($(this).is(':checked')) {
        $('#inputLoanPermanentAddress1').val(preAddress1);
        $('#inputLoanPermanentAddress2').val(preAddress2);
        $('#inputLoanPermanentAddress3').val(preAddress3);
    } else {
        $('#inputLoanPermanentAddress1').val('');
        $('#inputLoanPermanentAddress2').val('');
        $('#inputLoanPermanentAddress3').val('');
    }
});