//Code for citizenship checkboxes to behave like a radio button
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

// Use this syntax below to reuse the function other input above
$('#inputLoanIncomeOthers').click(applied(myFunction, [$('#inputLoanIncomeOthers'), $('#inputLoanIncomeOthersEnter')]));


//Add more file attachments
$('.file_upload_add_more').click(function() {

    var add_new = Math.floor((Math.random()*100)+1);

    $('#upload_append_id').append(''+'<div class="put_add_more" id="add_more_new_'+add_new+'" >'
        +'<div class="upload_append d-flex align-items-center" id="upload_append_id">'
        +'<input type="file" class="form-control form-control-sm expenses_class expenses_files_upload add_expenses_required" name="#expenses_input_files_label_'+add_new+'" id="expenses_input_files_id_'+add_new+'">'
        +'<span class="btn btn-danger m-2 file_upload_remove_more text-red" id="'+add_new+'"><i class="bi bi-file-excel-fill"></i></span>'
        +'</div>'
        +'</div>'
        +'');
});

//Remove added file attachment input
$(document).on("click", ".file_upload_remove_more", function() {
    $('#add_more_new_' + $(this).attr('id')+'').remove();
});


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
        
        // Working on start...
        $(document).on('change', '.expenses_files_upload', function(e)
        {
            var label_id = $(this).attr('name');
            var file_path = $(label_id).text($(this).val());
            var trim_path = file_path.text().split("fakepath",2);
            var pop_path = trim_path.pop();
            var str_path = pop_path.replace(/[^\w\s\.]/gi, '');
            var file_name = '';
            var file_size = 0;
            var split_file_name = [];

            if($(this).val() !='')
            {
                file_name = e.target.files[0].name;
                file_size = e.target.files[0].size;
                split_file_name = file_name.split('.');
                var LastIndex = split_file_name.pop();

                console.log(file_size);

                if(LastIndex =='jpg' || LastIndex =='jpeg' || LastIndex =='png' || LastIndex =='tiff' || LastIndex =='tif'|| LastIndex =='bmp' || LastIndex =='gif' || LastIndex =='pdf')
                    {
                        if(file_size <= 1.5e+7)
                        {
                            $(label_id).css({"border":"1px solid #00a65a","box-shadow":"#00a65a2e 1px 8px 4px","color":"#00a65a2e","overflow":"hidden","max-width":"60%"});
                            // $(label_id).text(str_path);
                            $(label_id).text(e.target.files[0].name);
                        }
                        else{
                            $(label_id).val('');
                            $(label_id).css({"border":"1px solid darkgrey","color":"#777","box-shadow":"1px 8px 4px #eee","overflow":"hidden","max-width":"60%"});
                            $($(label_id)).html('<i class="fa fa-paperclip"> File upload</i>');
                            alert('File size too large (maximum is 15MB only)');
                        }
                    }
                    else{
                    $(label_id).val('');
                    $(label_id).css({"border":"1px solid darkgrey","color":"#777","box-shadow":"1px 8px 4px #eee","overflow":"hidden","max-width":"60%"});
                    $($(label_id)).html('<i class="fa fa-paperclip"> File upload</i>');
                    alert('File format invalid (select only IMAGE or PDF file types only)')
                }
            }
            else
            {
                $(label_id).css({"border":"1px solid darkgrey","color":"#777","box-shadow":"1px 8px 4px #eee","overflow":"hidden","max-width":"60%"});
                $($(label_id)).html('<i class="fa fa-paperclip"> File upload</i>');
            }

        });
        // Working on end...

        // SUBMIT LOAN BUTTON
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
            
            // Working on start...

            var validation_upload = false;
            
            var formData = new FormData();

            var TOLTempStorage = $('#TOLTempStorage').val();
            var loanLName = $('#inputLoanLName').val();
            var loanFName = $('#inputLoanFName').val();
            var loanMName = $('#inputLoanMName').val();
            var loanSName = $('#inputLoanSName').val();
            var loanMobileNumber = $('#inputLoanMobileNumber').val();
            var loanEmailAddress = $('#inputLoanEmailAddress').val();
            var loanHomeNumber = $('#inputLoanHomeNumber').val();
            var loanPresentAddress1 = $('#inputLoanPresentAddress1').val();
            var loanPresentAddress2 = $('#inputLoanPresentAddress2').val();
            var loanPresentAddress3 = $('#inputLoanPresentAddress3').val();
            var loanPermanentAddress1 = $('#inputLoanPermanentAddress1').val();
            var loanPermanentAddress2 = $('#inputLoanPermanentAddress2').val();
            var loanPermanentAddress3 = $('#inputLoanPermanentAddress3').val();
            var loanWorkEmailAddress = $('#inputLoanWorkEmailAddress').val();
            var loanWorkLandlineNumber = $('#inputLoanWorkLandlineNumber').val();
            var loanWorkAddress1 = $('#inputLoanWorkAddress1').val();
            var loanWorkAddress2 = $('#inputLoanWorkAddress2').val();
            var loanWorkAddress3 = $('#inputLoanWorkAddress3').val();
            var loanBirthdate = $('#inputLoanBirthdate').val();
            var loanBirthPlace = $('#inputLoanBirthPlace').val();
            var loanCitizenship = $('input[name="citizenship"]:checked').val();
            var loanGender = $('input[name="gender"]:checked').val();
            var loanCivilStatus = $('#inputLoanCivilStatus').val();
            var loanHomeOwnership = $('#inputLoanHomeOwnership').val();
            var loanSssGsisNumber = $('#inputLoanSssGsisNumber').val();
            var loanTinNumber = $('#inputLoanTinNumber').val();
            var loanSpouseLName = $('#inputLoanSpouseLName').val();
            var loanSpouseFName = $('#inputLoanSpouseFName').val();
            var loanSpouseMName = $('#inputLoanSpouseMName').val();
            var loanSpouseSName = $('#inputLoanSpouseSName').val();
            var loanMothersMaidenLName = $('#inputLoanMothersMaidenLName').val();
            var loanMothersMaidenFName = $('#inputLoanMothersMaidenFName').val();
            var loanMothersMaidenMName = $('#inputLoanMothersMaidenMName').val();
            var SOITempStorage = $('#SOITempStorage').val();
            var loanEmploymentStatus = $('input[name="employmentStatus"]:checked').val();
            var loanForEmployed = $('input[name="forEmployed"]:checked').val();
            var loanForSelfEmployed = $('input[name="forSelfEmployed"]:checked').val();
            var loanBusinessName = $('#inputLoanEmpBusinessName').val();
            var loanJobPositionName = $('#inputLoanJobPositionName').val();
            var loanNatureOfBusiness = $('#inputLoanNatureOfBusiness').val();
            var loanGrossAnnualIncome = $('#inputLoanGAIncome').val();
            var loanYearsWithEmployer = $('#inputLoanYearsWithEmployer').val();
            var loanMonthsWithEmployer = $('#inputLoanMonthsWithEmployer').val();
            var number_of_files = 0;

            $('.expenses_files_upload').each(function(){
                if($(this).val() !='')
                {
                    formData.append('file_'+number_of_files+'', $(this).prop('files')[0]);
                    number_of_files++;
                }
                else
                {
                    alert('please check attachments');
                    validation_upload = false;
                    return false;
                }
            });
            
            //Left Table Right Variables
            formData.append('type_of_loan', TOLTempStorage);
            formData.append('applicant_lname', loanLName);
            formData.append('applicant_fname', loanFName)
            formData.append('applicant_mname', loanMName);
            formData.append('applicant_suffix', loanSName);
            formData.append('personal_mobile_number', loanMobileNumber);
            formData.append('personal_email_address', loanEmailAddress);
            formData.append('home_landline_number', loanHomeNumber);
            formData.append('pre_unit_number_bld_st_subd_brgy', loanPresentAddress1);
            formData.append('pre_city_municipality', loanPresentAddress2);
            formData.append('pre_province', loanPresentAddress3);
            formData.append('per_unit_number_bld_st_subd_brgy', loanPermanentAddress1);
            formData.append('per_city_municipality', loanPermanentAddress2);
            formData.append('per_province', loanPermanentAddress3);
            formData.append('work_email_address', loanWorkEmailAddress);
            formData.append('work_landline_number', loanWorkLandlineNumber);
            formData.append('work_unit_number_bld_st_subd_brgy', loanWorkAddress1);
            formData.append('work_city_municipality', loanWorkAddress2);
            formData.append('work_province', loanWorkAddress3);
            formData.append('birth_date', loanBirthdate);
            formData.append('birth_place', loanBirthPlace);
            formData.append('citizenship', loanCitizenship);
            formData.append('gender', loanGender);
            formData.append('civil_status', loanCivilStatus);
            formData.append('home_ownership', loanHomeOwnership);
            formData.append('sss_gsis_number', loanSssGsisNumber);
            formData.append('tin_number', loanTinNumber);
            formData.append('spouse_lname', loanSpouseLName);
            formData.append('spouse_fname', loanSpouseFName);
            formData.append('spouse_mname', loanSpouseMName);
            formData.append('spouse_suffix', loanSpouseSName);
            formData.append('mothers_maiden_lname', loanMothersMaidenLName);
            formData.append('mothers_maiden_fname', loanMothersMaidenFName);
            formData.append('mothers_maiden_mname', loanMothersMaidenMName);
            formData.append('source_of_income', SOITempStorage);
            formData.append('employment_status', loanEmploymentStatus);
            formData.append('for_employed', loanForEmployed);
            formData.append('for_self_employed', loanForSelfEmployed);
            formData.append('name_of_employer_business', loanBusinessName);
            formData.append('job_title_position', loanJobPositionName);
            formData.append('nature_of_business', loanNatureOfBusiness);
            formData.append('gross_annual_income', loanGrossAnnualIncome);
            formData.append('years_with_employer_in_business', loanYearsWithEmployer);
            formData.append('months_with_employer_in_business', loanMonthsWithEmployer);
            // formData.append('number_of_files_count', number_of_files);

            if(confirm('Submit this data?')) {
                
                $.ajax({
                    url: 'kiosk_create',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        $('.put_add_more').each(function() {
                            $(this).remove();
                        });

                        alert('Data submitted!');

                        $('.expenses_files_upload').val('');
                        $('.expenses_class ').val('');
                    }
                });
            }


            // Working on end...
            
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


var maxLength = 15;
$('textarea').keyup(function() {
  var textlen = maxLength - $(this).val().length;
  $('#rchars').text(textlen);
});