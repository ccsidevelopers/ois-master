var check_permanent = false;
var employeeList, tableExplist,tableEduclist,tableReflist, tableEmployeeList, tableAssigned,
    tableProfLogs, tableMotorList, tableAtmList, tableOimsList, tablePromotionList, tablePresentEmployees,
    tablePastEmployees, tableContractStat, tableGeneralForms, tablePendingEmployees, tablePendingRecEmployees, tableOverallMonitoring;
var b = 0;
var c = 0;
var d = 0;
var activeTab = '#tab_Info1';
var hr_create_prof = true;
var hr_add_exp = false;
var hr_add_educ = false;
var hr_add_ref = false;
var p = 0;
var table = [];
var table_exp = [];
var r = 0;
var activeExp = '#tab_Show1';
var hr_show_exp = false;
var hr_show_educ = false;
var hr_show_ref = false;
var hr_show_eq = false;
var hr_show_exp_aldy = false;
var hr_show_educ_aldy = false;
var hr_show_ref_aldy = false;
var hr_show_eq_aldy = false;
var empIDshow;
var countExp = 0;
var selectedNameID;
var viewExpID;
var viewEducID;
var viewCharID;
var activeStat = '#tab_stat1';
var hr_status_uno = true;
var hr_status_dos = false;
var hr_status_tres = false;
var hr_status_kwatro = false;
var activeMain = '#tab_mainEmp1';
var hr_main_add = true;
var hr_main_stat = false;
var selectedContract;
var activeLeft = '#human_resources_dashboard';
var hr_left_prof = true;
var hr_left_emp = false;
var hr_left_motor = false;
var hr_left_eq = false;
var BranchList;
var submitCounter = false;
var l = 0;
var table_items = [];
var statusCounter = false;
var table_educ= [];
var table_char = [];
var q = 0;
var s = 0;
var prof_logs = 0;
var tableLogs = [];
var tableMotor= [];
var h = 0;
var editMotorId;
var delMotor;
var hr_motor_list = true;
var activeMotor = '#tab_motor1';
var editAtmId;
var tableAtm = [];
var x = 0;
var get_date_on_update = [];
var positionIdChange;
var oldPos;
var oimsGetId;
var tableOims = [];
var oims_table = 0;
var tablePromotion = [];
var promotion_list = 0;
var counterPromo = false;
var tablePresent = [];
var pqwe = 0;
var activeEmp = '#tab_a';
var hr_general_emp = true;
var hr_present_emp = false;
var hr_past_emp = false;
var hr_pending_emp = false;
var hr_pending_emp_rec = false;
var hr_pending_emp_rey = false;
var hr_over_mon = false;
var tablePast = [];
var poiyu = 0;
var table_constat = [];
var tablecon = 0;
var submitContractRefresh = false;
var tablePending = [];
var poiyu1 = 0;
var approveCounter = false;
var partialCounter = false;
var partialID;
var tablePendingRec = [];
var poiyu2 = 0;
var submitRequested = false;
var countHrFiles = 0;
var tablePendingRecRey = [];
var poiyu4 = 0;
var tablePendingRecEmployeesRey = [];
var emp_remarks;
var tableOverallMon = [];
var poiyu5 = 0;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$(document).ready(function()
{
    $.ajax
    ({
        type: 'get',
        url: 'admin-staff-auth-view',
        success: function (data)
        {
            if(data[0].authrequest == 'Senior')
            {
                $('#tabChecklist').show();
                $('#tabEmpGen4').show();
                $('#tabEmpGen5').hide();
                $('#tabEmpGen6').hide();
                $('#tabEmpGen7').show();
            }
            else if(data[0].authrequest == 'R-Approver')
            {
                $('#tabChecklist').show();
                $('#tabEmpGen4').hide();
                $('#tabEmpGen5').hide();
                $('#tabEmpGen6').show();
                $('#tabEmpGen7').hide();
            }
            else
            {
                $('#tabChecklist').show();
                $('#tabEmpGen4').hide();
                $('#tabEmpGen5').show();
                $('#tabEmpGen6').hide();
                $('#tabEmpGen7').hide();
            }
        }
    });

    function dashData()
    {
        $.ajax
        ({
            type : 'get',
            url: 'human_resources-dash-data',
            success: function(data)
            {
                $('#empCount').html(data[0]);
                $('#empRegular').html(data[1]);
                $('#empProbi').html(data[2]);
                $('#empRes').html(data[3]);
            }
        })
    }
    $('#submitExperience').hide();
    $('#submitEducation').hide();
    $('#submitReference').hide();
    $('#update_Profile').hide();
    $('#add_work_experience').attr("disabled", true);
    $('#add_education_record').attr("disabled", true);
    $('#add_reference').attr("disabled", true);
    $('#update_status').attr("disabled", true);
    $('#ciInfo').hide();
    $('#outDiv').hide();
    $('#ciShow').hide();
    $('#btnAtm').attr("disabled", true);
    profLogs();
    $('#btnOIMS').attr("disabled", true);
    $('#btnUpdateMotor').hide();
    $('#btnMotorCancel').hide();
    $('#ciMotorReq').hide();
    $('#officeChecklist').hide();
    $('#ciChecklist').hide();
    $('#officeChecklistView').hide();
    $('#ciChecklistView').hide();
    $('#ciMotorReqView').hide();
    $('#tabChecklist').hide();
    $('#tabEmpGen4').hide();

    $('#add_work_experience').click(function()
    {
        b++;
        $('#tblExp').append(
            '<tr id="row'+b+'">' +
            '<td><input type="text" class="form-control" name = "test_name[]" required="required"></td>' +
            '<td><input type="text" class="form-control"  name = "test_add[]" required="required"></td>' +
            '<td><input type="text" class="form-control"   name = "test_pos[]" required="required" ></td>' +
            '<td><input type="date" class="form-control"   name = "test_start[]" required="required"></td>' +
            '<td><input type="date" class="form-control"   name = "test_end[]" required="required"></td>'+
            '<td><input type="text" class="form-control" name = "test_num[]" required="required"></td>'+
            '<td><button name="remove" id="'+b+'" class="btn btn-danger btn-sm form-control btnRemoveItem">Remove</button></td>' +
            '</tr>');
        $('#submitExperience').show();
    });

    $('#add_education_record').click(function()
    {
        c++;
        $('#tblEduc').append(
            '<tr id="row'+c+'">' +
            '<td><select class="form-control select2" style="width: 100%;" name = "selectedLevel[]">\n' +
            '<option value = "Elementary">Elementary</option>\n' +
            '<option value = "Highschool">High School</option>\n' +
            '<option value = "College">College</option>\n' +
            '<option value = "Graduate school">Graduate School</option>\n' +
            '<option value = "Others">Others</option>\n' +
            '</select></td>' +
            '<td><input type="text" class="form-control" name = "school_name[]" required="required"></td>' +
            '<td><input type="text" class="form-control" name = "school_address[]" required= "required"></td>' +
            '<td><input type="text" class="form-control" name = "school_year[]" required = "required"></td>' +
            '<td><input type="text" class="form-control" name = "school_course[]" required="required"></td>'+
            '<td><button name="remove" id="'+c+'" class="btn btn-danger btn-sm form-control btnRemoveItem">Remove</button></td>' +
            '</tr>');
        $('#submitEducation').show();
    });
    $('#add_reference').click(function()
    {
        $('#tblRef').show();
        d++;
        $('#tblRef').append(
            '<tr id="row'+d+'">' +
            '<td><input type="text" class="form-control" name = "char_name[]" required="required"></td>' +
            '<td><input type="text" class="form-control" name = "char_position[]" required="required"></td>' +
            '<td><input type="text" class="form-control" name = "char_company[]" required="required" ></td>' +
            '<td><input type="text" class="form-control" name = "char_contact[]" required="required"></td>' +
            '<td><button name="remove" id="'+d+'" class="btn btn-danger btn-sm form-control btnRemoveItem">Remove</button></td>' +
            '</tr>');
        $('#submitReference').show();
    });
    $('#submitExperience').click(function()
    {
        $("#submitExperience").attr("disabled", true);
        var AddExperience = 'id%5B%5D=' + viewExpID +'&'+ $('#itemExp').serialize();
        $.ajax
        ({
            type: 'post',
            url: 'human-resources-add-work-exp',
            data: AddExperience,
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitExperience").attr("disabled", false);

                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);
                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitExperience").attr("disabled", false);

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-sentsuccessexp').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-sentsuccessexp').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#submitExperience').hide();
                    $('#expSelectedId1').val('');
                    showExpSel();
                    tableProfLogs.ajax.reload(null, false);
                }
            }
        });
    });
    $('#submitEducation').click(function()
    {
        $("#submitEducation").attr("disabled", true);
        console.log(viewEducID);
        var AddEducation = 'id%5B%5D=' + viewEducID  +'&'+ $('#itemEduc').serialize();
        $.ajax
        ({
            type: 'post',
            url: 'human-resources-add-educ',
            data: AddEducation,
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitEducation").attr("disabled", false);

                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);
                }
                else if(data.success == 'success')
                {

                    $('#modal-sendingrequest').modal('hide');
                    $("#submitEducation").attr("disabled", false);
                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-sentsuccesseduc').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-sentsuccesseduc').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#submitEducation').hide();
                    showEducSel();
                    $('#expSelectedId2').val('');
                    tableProfLogs.ajax.reload(null, false);
                }
            }
        });
    });
    $('#submitReference').click(function()
    {
        $("#submitReference").attr("disabled", true);
        console.log(viewCharID);
        var AddCharacter = 'id%5B%5D=' + viewCharID +'&'+ $('#itemRef').serialize();
        $.ajax
        ({
            type: 'post',
            url: 'human-resources-add-ref',
            data: AddCharacter,
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitReference").attr("disabled", false);
                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);
                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#submitReference").attr("disabled", false);

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-sentsuccessref').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-sentsuccessref').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#submitReference').hide();
                    showCharSel();
                    $('#expSelectedId3').val('');
                    tableProfLogs.ajax.reload(null, false);
                }
            }
        });
    });
    $('#present_is_permanent').click(function()
    {
        if(check_permanent == false)
        {
            var permanentAddressDisable = '<textarea class="form-control" rows = "2" id="emp_permanent_address" disabled></textarea>';
            $('#disablePermanent').html(permanentAddressDisable);
            check_permanent = true;
        }
        else if(check_permanent ==true)
        {
            var permanentAddress = '<textarea class="form-control" rows = "2" id="emp_permanent_address" placeholder = "Permanent Address"></textarea>';
            $('#disablePermanent').html(permanentAddress);
            check_permanent = false;
        }
    });


    // $("#modal-sendingrequest_hr").modal('show');


    $('#submitProfile').click(function()
    {
       $("#submitProfile").attr("disabled", true);

        var empBranch = $('#emp_branch').val();
        var empPosition = $('#emp_position').val();
        var empDateHire = $('#emp_date_hired').val();
        var empAge = $('#emp_age').val();
        var empFirst = $('#emp_first_name').val();
        var empMid = $('#emp_mid_name').val();
        var empLast = $('#emp_last_name').val();
        var empReligion = $('#emp_religion').val();
        var empContactNumber = $('#emp_contact_number').val();
        var empEmail = $('#emp_email_add').val();
        var empGender = $('#emp_gender').val();
        var empBirth = $('#emp_birth_date').val();
        var empMaritalStatus = $('#emp_marital_status').val();
        var empSss = $('#emp_sss').val();
        var empPhilhealth = $('#emp_philhealth').val();
        var empPagibig = $('#emp_pagibig').val();
        var empTin = $('#emp_tin').val();
        var empPresentAddress = $('#emp_present_address').val();
        var empPermanentAddress = $('#emp_permanent_address').val();
        var empSalary = $('#emp_salary').val();
        var empDependents = $('#emp_dependents').val();
        var empImage = $('#emp_profile_pic')[0].files[0];
        var empInMon = $('#emp_in1').val();
        var empOutMon = $('#emp_out1').val();
        var empInTues = $('#emp_in2').val();
        var empOutTues = $('#emp_out2').val();
        var empInWed = $('#emp_in3').val();
        var empOutWed = $('#emp_out3').val();
        var empInThurs = $('#emp_in4').val();
        var empOutThurs = $('#emp_out4').val();
        var empInFri = $('#emp_in5').val();
        var empOutFri = $('#emp_out5').val();
        var empInSat = $('#emp_in6').val();
        var empOutSat = $('#emp_out6').val();
        var empInSun = $('#emp_in7').val();
        var empOutSun = $('#emp_out7').val();
        var ciMuni = $('#ciMuni').val();
        var ciProv = $('#ciProv').val();
        var ccType = $('#ccType').val();
        var empRate = $('#empRate').val();
        var empWage = $('#empWage').val();
        var empState = $('#emp_state').val();
        var noDays = $('#noDays').val();
        var empFile = $('#req_submit').prop('files')[0];
        var empAllowances = $('#emp_allowances').val();
        var empFixed = $('#emp_fixed_sched').val();
        var empSchedRemarks = $('#emp_sched_remarks').val();

        var formData = new FormData();
        formData.append('empBranch', empBranch);
        formData.append('empPosition', empPosition);
        formData.append('empDateHire', empDateHire);
        formData.append('empAge', empAge);
        formData.append('empFirst', empFirst);
        formData.append('empMid', empMid);
        formData.append('empLast', empLast);
        formData.append('empReligion', empReligion);
        formData.append('empContactNumber', empContactNumber);
        formData.append('empEmail', empEmail);
        formData.append('empGender', empGender);
        formData.append('empBirth', empBirth);
        formData.append('empMaritalStatus', empMaritalStatus);
        formData.append('empSss', empSss);
        formData.append('empPhilhealth', empPhilhealth);
        formData.append('empPagibig', empPagibig);
        formData.append('empTin', empTin);
        formData.append('empPresentAddress', empPresentAddress);
        formData.append('empPermanentAddress', empPermanentAddress);
        formData.append('empSalary', empSalary);
        formData.append('empDependents', empDependents);
        formData.append('emp_profile_pic', empImage);
        formData.append('empFile', empFile);
        formData.append('empInMon', empInMon);
        formData.append('empOutMon', empOutMon);
        formData.append('empInTues', empInTues);
        formData.append('empOutTues', empOutTues);
        formData.append('empInWed', empInWed);
        formData.append('empOutWed', empOutWed);
        formData.append('empInThurs', empInThurs);
        formData.append('empOutThurs', empOutThurs);
        formData.append('empInFri', empInFri);
        formData.append('empOutFri', empOutFri);
        formData.append('empInSat', empInSat);
        formData.append('empOutSat', empOutSat);
        formData.append('empInSun', empInSun);
        formData.append('empOutSun', empOutSun);
        formData.append('ciMuni', ciMuni);
        formData.append('ciProv', ciProv);
        formData.append('empRate', empRate);
        formData.append('empWage', empWage);
        formData.append('empState', empState);
        formData.append('noDays', noDays);
        formData.append('ccType', ccType);
        formData.append('empAllowances', empAllowances);
        formData.append('empFixed', empFixed);
        formData.append('empSchedRemarks', empSchedRemarks);

        // if( $('#req_submit').val().length >= 1)
        // {
            createProf(formData);
        // }
        // else
        //     {
        //         $("#submitProfile").attr("disabled", false);
        //         alert('Please upload 201 ZIP File!');
        //     }
    });

    function createProf(form)
    {
        $.ajax
        ({
            xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#ulPercentage_new_emp').html('');
                        $('#ulPercentage_new_emp').show();
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_new_emp').append(Math.floor(percentComplete*100));
                        $('#progressbar_new_emp').show();
                        $('#progressbar_new_emp').progressbar
                        (
                            {
                                value: percentComplete * 100
                            }
                        )
                    }
                }, false);
                //Download progress
                xhr.addEventListener("progress", function(evt)
                    {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with download progress
                            console.log(percentComplete);
                        }
                    },
                    false
                );
                return xhr;
            },
            type: 'post',
            url: 'human-resources-create-profile',
            contentType: false,
            processData: false,
            async : true,
            data: form,
            beforeSend: function ()
            {
                $('#modal-sendingrequest_hr').modal('show');
            },
            success: function(data)
            {
                if(data.type == 'type')
                {
                    $('#modal-sendingrequest_hr').modal('hide');
                    $("#submitProfile").attr("disabled", false);

                    $('#modal-invalidtype').modal('show');

                    $('#req_submit').val('');
                }
                else if(data.error == 'required')
                {
                    $('#modal-sendingrequest_hr').modal('hide');
                    $("#submitProfile").attr("disabled", false);

                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);
                }
                else if(data.exist == 'exist')
                {
                    $('#modal-sendingrequest_hr').modal('hide');
                    $("#submitProfile").attr("disabled", false);

                    var timerExist = setInterval(function ()
                    {
                        $('#modal-existingprofile').modal('show');
                        clearInterval(timerExist);
                    }, 1000);
                }
                else if(data.success == 'success')
                {
                    var myData = {};
                    var checkVal = '';

                    $('.emp_checklist').each(function()
                    {
                        if($(this).is(":checked"))
                        {
                            checkVal = $(this).val();
                            myData[checkVal] = checkVal;
                        }
                    });

                    $.ajax
                    ({
                        type : 'post',
                        url : 'human-resources-emp-req-checklist',
                        data :
                           {
                               myData : myData,
                               'id' : data[0]
                           },
                        success : function()
                        {
                            $('#modal-sendingrequest_hr').modal('hide');
                            $("#submitProfile").attr("disabled", false);

                            var timerSuccess = setInterval(function ()
                            {
                                $('#modal-sentsuccessprofile').modal('show');

                                var timerSuccessHide = setInterval(function ()
                                {
                                    $('#modal-sentsuccessprofile').modal('hide');
                                    clearInterval(timerSuccessHide);
                                },5000);
                                clearInterval(timerSuccess);
                            },1000);
                            $('#emp_position').val('');
                            $('#emp_date_hired').val('');
                            $('#emp_age').val('');
                            $('#emp_first_name').val('');
                            $('#emp_mid_name').val('');
                            $('#emp_last_name').val('');
                            $('#emp_religion').val('');
                            $('#emp_dependents').val('');
                            $('#emp_contact_number').val('');
                            $('#emp_email_add').val('');
                            $('#emp_birth_date').val('');
                            $('#emp_sss').val('');
                            $('#emp_philhealth').val('');
                            $('#emp_pagibig').val('');
                            $('#emp_tin').val('');
                            $('#emp_present_address').val('');
                            $('#emp_permanent_address').val('');
                            $('#emp_salary').val('');
                            $('#emp_profile_pic').val('');
                            $('#req_submit').val('');
                            $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
                            $('#emp_in1').val('');
                            $('#emp_out1').val('');
                            $('#emp_in2').val('');
                            $('#emp_out2').val('');
                            $('#emp_in3').val('');
                            $('#emp_out3').val('');
                            $('#emp_in4').val('');
                            $('#emp_out4').val('');
                            $('#emp_in5').val('');
                            $('#emp_out5').val('');
                            $('#emp_in6').val('');
                            $('#emp_out6').val('');
                            $('#emp_in7').val('');
                            $('#emp_out7').val('');
                            $('#ciMuni').val('');
                            $('#ciProv').val('');
                            $('#ccType').val('');
                            $('#empRate').val('Daily');
                            $('#empWage').val('');
                            $('#emp_state').val('');
                            $('#ciInfo').hide();
                            $('#emp_allowances').val('');
                            $('#emp_fixed_sched').val('');
                            $('#emp_sched_remarks').val('');
                            $('.emp_checklist').attr('checked', false);
                            employeeFetchall();
                            submitCounter = true;
                            tableProfLogs.ajax.reload(null, false);
                            submitRequested = true;
                        }
                    });
                }
            }
        })
    }
    $("#emp_profile_pic").change(function()
    {
        readURL(this);
    });
    function readURL(input)
    {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function(e)
            {
                $('#emp_profile_pic_display').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#cancelImg').click(function()
    {
        $('#emp_profile_pic').val('');
        $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
    });
    $('.human_resources_tab_info_class').click(function()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if(gethref == '#tab_Info1')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeTab = '#tab_Info1';
            }
            else if (hr_create_prof)
            {
                console.log('already loaded');
                activeTab = '#tab_Info1';
            }
            else if (hr_create_prof == false)
            {
                hr_create_prof = true;
                activeTab = '#tab_Info1';
            }
        }
        else if(gethref == '#tab_Info2')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeTab = '#tab_Info2';
            }
            else if (hr_add_exp)
            {
                console.log('already loaded');
                activeTab = '#tab_Info2';
            }
            else if (hr_add_exp == false)
            {
                hr_add_exp = true;
                activeTab = '#tab_Info2';
                employeeFetchtab1();
            }
        }
        else if(gethref == '#tab_Info3')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeTab = '#tab_Info3';
            }
            else if (hr_add_educ)
            {
                console.log('already loaded');
                activeTab = '#tab_Info3';
            }
            else if (hr_add_educ == false)
            {
                hr_add_educ = true;
                activeTab = '#tab_Info3';
                employeeFetchtab2();
            }
        }
        else if(gethref == '#tab_Info4')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeTab = '#tab_Info4';
            }
            else if (hr_add_ref)
            {
                console.log('already loaded');
                activeTab = '#tab_Info4';

            }
            else if (hr_add_ref == false)
            {
                hr_add_ref = true;
                activeTab = '#tab_Info4';
                employeeFetchtab3();
            }
        }
    });
    function employeeFetchtab1()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees-active',
            success: function (data)
            {
                var j;
                console.log(data);
                employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#expSelectedId1').html(employeeList);
                $('#expSelectedId1').val('');

                $('#expSelectedId1').change(function()
                {
                    viewExpID  = $(this).find(':selected').val();
                    $('#add_work_experience').attr("disabled", false);
                    $('#submitExperience').hide();
                    showExpSel();
                });
            }
        });
    }
    function showExpSel()
    {
        $('#tblExp').html(                                   '<thead>\n' +
            '                                                   <tr>\n' +
            '                                                     <th>Company Name</th>\n' +
            '                                                     <th>Company Address</th>\n' +
            '                                                     <th>Position</th>\n' +
            '                                                     <th>Start Date</th>\n' +
            '                                                     <th>End Date</th>\n' +
            '                                                        <th>Contact Number</th>\n' +
            '                                                     <th>Action</th>\n' +
            '                                                    </tr>\n' +
            '                                                 </thead>');
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-edit-exp',
            data:
                {
                    'viewEmpID' : viewExpID
                },
            success : function(data)
            {
                var k;
                var ExpList = '';
                for (k = 0; k < data.length; k++)
                {
                    ExpList += '<tr id = "'+data[k].id+'">' +
                        '<td><input type="text" class="form-control" value = "'+data[k].company_name+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[k].company_address+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[k].company_position+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[k].start_date+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[k].end_date+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[k].contact_no+'" disabled></td>' +
                        '<td><button type = "button" value = "'+data[k].id+'" class = "removeExp btn btn-block btn-danger btn-sm form-control">Remove</button></td>' +
                        '</tr>';
                }
                $('#tblExp').append(ExpList);
                $('.removeExp').click(function(){
                    var expBye = $(this).val();
                    if(confirm('Are you sure to delete this Experience?'))
                        $.ajax
                        ({
                            type: 'get',
                            url: 'human-resources-delete-exp',
                            data:
                                {
                                    'expBye' : expBye
                                },
                            success: function () {

                                alert('Successfully Deleted!');
                                showExpSel();
                                tableProfLogs.ajax.reload(null, false);
                            }
                        })
                })
            }
        })
    }
    function employeeFetchtab2()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees-active',
            success: function (data)
            {
                var j;
                employeeList = '';
                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#expSelectedId2').html(employeeList);
                $('#expSelectedId2').val('');

                $('#expSelectedId2').change(function()
                {
                    viewEducID  = $(this).find(':selected').val();
                    $('#add_education_record').attr("disabled", false);
                    $('#submitEducation').hide();
                    showEducSel();
                });
            }
        });
    }
    function showEducSel()
    {
        $('#tblEduc').html('                                <thead>\n' +
            '                                                 <tr>\n' +
            '                                                     <th>Level</th>\n' +
            '                                                     <th>School Name</th>\n' +
            '                                                     <th>School Address</th>\n' +
            '                                                     <th>Year Graduated</th>\n' +
            '                                                     <th>Course<small style = "color:red">(if applicable)</small></th>\n' +
            '                                                     <th>Action</th>\n' +
            '                                                 </tr>\n' +
            '                                                 </thead>')
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-edit-educ',
            data:
                {
                    'viewEducID' : viewEducID
                },
            success: function(data)
            {
                var l;
                var EducList = '';

                for (l = 0; l < data.length; l++)
                {
                    EducList += '<tr id = "'+data[l].id+'">' +
                        '<td><input type="text" class="form-control" value = "'+data[l].educ_level+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[l].school_name+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[l].school_address+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[l].year_graduated+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[l].educ_course+'" disabled></td>' +
                        '<td><button type = "button" value = "'+data[l].id+'" class = "removeEduc btn btn-block btn-danger btn-sm form-control">Remove</button></td>' +
                        '</tr>';
                }
                $('#tblEduc').append(EducList);
                $('.removeEduc').click(function()
                {
                    var educBye = $(this).val();
                    if(confirm('Are you sure to delete this record?'))
                        $.ajax
                        ({
                            type: 'get',
                            url : 'human-resources-delete-educ',
                            data:
                                {
                                    'educBye' : educBye
                                },
                            success: function ()
                            {
                                alert('Successfully Deleted!');
                                showEducSel();
                                tableProfLogs.ajax.reload(null, false);
                            }
                        })
                });
            }
        })
    }
    function employeeFetchtab3()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees-active',
            success: function (data)
            {
                var j;
                employeeList = '';
                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#expSelectedId3').html(employeeList);
                $('#expSelectedId3').val('');

                $('#expSelectedId3').change(function()
                {
                    viewCharID  = $(this).find(':selected').val();
                    $('#add_reference').attr("disabled", false);
                    $('#submitReference').hide();
                    showCharSel();

                });
            }
        });
    }
    function showCharSel()
    {
        $('#tblRef').html('                                   <thead>\n' +
            '                                                 <tr>\n' +
            '                                                     <th>Name</th>\n' +
            '                                                     <th>Position</th>\n' +
            '                                                     <th>Company Name</th>\n' +
            '                                                     <th>Contact Number</th>\n' +
            '                                                     <th>Action</th>\n' +
            '                                                 </tr>\n' +
            '                                                 </thead>');
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-edit-ref',
            data:
                {
                    'viewCharID' : viewCharID
                },
            success: function(data)
            {
                var m;
                var CharList = '';
                for (m = 0; m < data.length; m++)
                {
                    CharList += '<tr id = "'+data[m].id+'">' +
                        '<td><input type="text" class="form-control" value = "'+data[m].char_name+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[m].char_position+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[m].char_company_name+'" disabled></td>' +
                        '<td><input type="text" class="form-control" value = "'+data[m].char_contact+'" disabled></td>' +
                        '<td><button type = "button" value = "'+data[m].id+'" class = "removeChar btn btn-block btn-danger btn-sm form-control">Remove</button></td>' +
                        '</tr>';
                }
                $('#tblRef').append(CharList);

                $('.removeChar').click(function()
                {
                    var charBye = $(this).val();
                    console.log(charBye);
                    if(confirm('Are you sure to delete this record?'))
                        $.ajax
                        ({
                            type: 'get',
                            url : 'human-resources-delete-char',
                            data:
                                {
                                    'charBye' : charBye
                                },
                            success: function () {

                                alert('Successfully Deleted');
                                showCharSel();
                                tableProfLogs.ajax.reload(null, false);
                            }
                        })
                });
            }
        })
    }
    function employeeFetchall()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#expSelectedId1').html(employeeList);
                $('#expSelectedId2').html(employeeList);
                $('#expSelectedId3').html(employeeList);
                $('#empStatusId').html(employeeList);
                $('#empAtmId').html(employeeList);
                $('#selectIdforOIMS').html(employeeList);
            }
        });
    }
    employee_list_table();
    function employee_list_table()
    {
        $('#human-resources-employee-list thead th').each(function ()
        {
            table[p] = $(this).text();
            p++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        tableEmployeeList = $('#human-resources-employee-list').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'General Employee List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'General Employee List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                var loop = 0;
                                $('row', sheet).each(function () {

                                    $(this).find("c").attr('s', '25');
                                    $('row:first c', sheet).attr('s', '51');
                                    loop++;
                                });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'General Employee List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table[(idx)];
                                        }
                                    }
                            },

                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return table[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-employee-table",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'birth', name: 'users_profile.emp_date_birth'},
                    {data: 'gender', name: 'users_profile.emp_gender'},
                    {data: 'marital', name: 'users_profile.emp_marital_status'},
                    {data: 'con_status', name: 'users_profile.emp_status'},
                    {data: 'emp_status', name: 'users_profile.emp_process_status'},
                    {data: 'hired', name: 'users_profile.emp_date_hired'},
                    {data: 'end' , name: 'users_profile.emp_end_date'},
                    {
                        data: function action(data)
                        {
                            if(data.approval == 'Approved' && data.con_status == 'Off-Boarding')
                            {
                                return '<span><button class="btn btn-md btn-danger" name="" value="' + data.id + '" style="width: 100%" disabled><i class = "fa fa-fw fa-sign-out"></i>Inactive</button></span>';
                            }
                            else if(data.approval == 'Partial' && data.con_status != 'Off-Boarding')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i>View Profile</button></span>' +
                                    '<span><button class="btnPartialRemarks btn btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-spinner"></i>Partial Remarks</button></span>';
                            }
                            else if(data.approval == 'Approved' && data.con_status != 'Off-Boarding')
                            {
                                return '<span id="empInfo-' + data.id + '"><button class="btnViewEmpInfo btn btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i>View Profile</button></span>';
                            }

                        },
                        "name": 'users_profile.emp_end_date',
                        "searchable" : false
                    }
                ],
            "fnRowCallback": function( nRow, aData)
            {
                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(aData.hired , aData.end);
                var test1 = date_diff_indays(aData.hired , now);
                var diff = contactdiff - test1;

                console.log(diff + ' days from end of contract');

                allOption(nRow, diff);
                yellowOption(nRow, diff);
                redOption(nRow, diff);

                if(diff <= 30 ) {
                    $('td', nRow).css('background-color', '#FEA4A4s');
                }
                else if(diff <= 60 )
                {
                    $('td', nRow).css('background-color', '#F5FA5D');
                }

            }
            ,
            "order": [[0, 'asc']],
            "pageLength": 100,
            "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
            "pagingType": "full_numbers",
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-employee-list_filter input').unbind();
        $('#human-resources-employee-list_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableEmployeeList.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableEmployeeList.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#human-resources-employee-list').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();


        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                   if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }

                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });

            }
        });
    });
    function employee_exp_table()
    {
        $('#human-resources-show-exp thead th').each(function ()
        {
            table_exp[q] = $(this).text();
            q++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableExplist = $('#human-resources-show-exp').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    type: 'get',
                    url: "/human-resources-employee-show-exp",
                    data: function (d)
                    {
                        d.emp_id = empIDshow;
                    }
                },
            "columns":
                [
                    {data: 'company_name', name: 'company_name'},
                    {data: 'company_address', name: 'company_address'},
                    {data: 'company_position', name: 'company_position'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'contact_no', name: 'contact_no'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
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
        $('#human-resources-show-exp_filter input').unbind();
        $('#human-resources-show-exp_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableExplist.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '')
                    {
                        tableExplist.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function employee_educ_table()
    {
        $('#human-resource-show-educ thead th').each(function () {
            table_educ[r] = $(this).text();
            r++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableEduclist = $('#human-resource-show-educ').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            //   "ajax": "/human-resources-employee-show-exp",
            "ajax":
                {
                    type: 'get',
                    url: "/human-resources-employee-show-educ",
                    data: function (d)
                    {
                        d.emp_id = empIDshow;
                    }
                },
            "columns":
                [
                    {data: 'educ_level', name: 'educ_level'},
                    {data: 'school_name', name: 'school_name'},
                    {data: 'school_address', name: 'school_address'},
                    {data: 'year_graduated', name: 'year_graduated'},
                    {data: 'educ_course', name: 'educ_course'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
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
        $('#human-resource-show-educ_filter input').unbind();
        $('#human-resource-show-educ_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableEduclist.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '')
                    {
                        tableEduclist.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function employee_ref_table()
    {
        $('#human-resources-show-ref thead th').each(function ()
        {
            table_char[s] = $(this).text();
            s++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableReflist = $('#human-resources-show-ref').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            //   "ajax": "/human-resources-employee-show-exp",
            "ajax":
                {
                    type: 'get',
                    url: "/human-resources-employee-show-char",
                    data: function (d)
                    {
                        d.emp_id = empIDshow;
                    }
                },
            "columns":
                [
                    {data: 'char_name', name: 'char_name'},
                    {data: 'char_position', name: 'char_position'},
                    {data: 'char_company_name', name: 'char_company_name'},
                    {data: 'char_contact', name: 'char_contact'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function()
            {
                var api = this.api();

                // Apply the search
                api.columns().every(function()
                {
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
        $('#human-resources-show-ref_filter input').unbind();
        $('#human-resources-show-ref_filter input').bind('keyup change', function (e) {
            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    tableReflist.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        tableReflist.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function showExtraEmp()
    {
        if($('#tabTest1').attr('class') == 'active')
        {
            if(countExp >= 2) {
                tableExplist.ajax.reload(null, false);
                hr_show_exp = true;
                hr_show_educ = false;
                hr_show_ref = false;
                hr_show_eq = false;
            }
            else {
                employee_exp_table();
                hr_show_exp_aldy = true;
                hr_show_exp = true;
                hr_show_educ = false;
                hr_show_ref = false;
                hr_show_eq = false;
            }
        }
        else if($('#tabTest2').attr('class') == 'active')
        {
            if(countExp >= 2) {
                tableEduclist.ajax.reload(null, false);
                hr_show_exp = false;
                hr_show_educ = true;
                hr_show_ref = false;
                hr_show_eq = false;
            }
            else {
                employee_educ_table();
                hr_show_educ_aldy = true;
                hr_show_exp = false;
                hr_show_educ = true;
                hr_show_ref = false;
                hr_show_eq = false;
            }
        }
        else if($('#tabTest3').attr('class') == 'active')
        {
            if(countExp >= 2) {
                tableReflist.ajax.reload(null, false);
                hr_show_exp = false;
                hr_show_educ = false;
                hr_show_ref = true;
                hr_show_eq = false;
            }
            else
            {
                employee_ref_table();
                hr_show_ref_aldy = true;
                hr_show_exp = false;
                hr_show_educ = false;
                hr_show_ref = true;
                hr_show_eq = false;
            }
        }
        else if($('#tabTest4').attr('class') == 'active')
        {
            if(countExp >= 2) {
                tableAssigned.ajax.reload(null, false);
                hr_show_exp = false;
                hr_show_educ = false;
                hr_show_ref = false;
                hr_show_eq = true;
            }
            else
            {
                employee_assigned_items();
                hr_show_eq_aldy = true;
                hr_show_exp = false;
                hr_show_educ = false;
                hr_show_ref = false;
                hr_show_eq = true;
            }
        }
    }


        $('.human_resources_tab_show_class').click(function() {
            var gethref = $(this).attr('href');
            console.log(gethref);

            if (gethref == '#tab_Show1') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeExp = '#tab_Show1';
                }
                else if (hr_show_exp) {
                    console.log('already loaded');
                    activeExp = '#tab_Show1';
                }
                else if (hr_show_exp == false) {
                    console.log('Table load');
                    hr_show_exp = true;
                    activeExp = '#tab_Show1';

                    if(hr_show_exp_aldy)
                    {
                        tableExplist.ajax.reload(null, false);
                    }
                    else
                    {
                        hr_show_exp_aldy = true;
                        employee_exp_table();
                    }
                }
            }
            else if (gethref == '#tab_Show2') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeExp = '#tab_Show2';
                }
                else if (hr_show_educ) {
                    console.log('already loaded');
                    activeExp = '#tab_Show2';
                }
                else if (hr_show_educ == false) {
                    console.log('Table load');
                    hr_show_educ = true;
                    activeExp = '#tab_Show2';

                    if(hr_show_educ_aldy)
                    {
                        tableEduclist.ajax.reload(null, false);
                    }
                    else
                    {
                        hr_show_educ_aldy = true;
                        employee_educ_table();
                    }
                }
            }
            else if (gethref == '#tab_Show3') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeExp = '#tab_Show3';
                }
                else if (hr_show_ref) {
                    console.log('already loaded');
                    activeExp = '#tab_Show3';
                }
                else if (hr_show_ref == false) {
                    console.log('Table load');
                    hr_show_ref = true;
                    activeExp = '#tab_Show3';


                    if(hr_show_ref_aldy)
                    {
                        tableReflist.ajax.reload(null, false);
                    }
                    else
                    {
                        hr_show_ref_aldy = true;
                        employee_ref_table();
                    }
                }
            }
            else if (gethref == '#tab_Show4') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeExp = '#tab_Show4';
                }
                else if (hr_show_eq) {
                    console.log('already loaded');
                    activeExp = '#tab_Show4';
                }
                else if (hr_show_eq == false) {
                    console.log('Table load');
                    hr_show_eq = true;
                    activeExp = '#tab_Show3';



                    if(hr_show_eq_aldy)
                    {
                        tableAssigned.ajax.reload(null, false);
                    }
                    else
                    {
                        hr_show_eq_aldy =true;
                        employee_assigned_items();
                    }
                }
            }
        });

    $('#optionProfile2').click(function()
    {
        $('#check_show').hide();
        $('#ciInfo').hide();
        $('#emp_profile_pic').val('');
        $('#supportingDocu').html('*SUPPORTING DOCUMENTS SHOULD BE ADDED IF CHANGED');
        $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
        $('#profileEdit').show();
        getEmpName();
        $('#submitProfile').hide();
        $('#update_Profile').show();
        $('#emp_position').val('');
        $('#allowanceRemove').hide();
        $('#emp_fixed_sched').val('');
        $('#emp_sched_remarks').val('');
        $('.emp_checklist').prop('checked', false);



        var up = 'Update 201 File: <small style = "color:red">*please upload zip file</small>';
        $('#update201').html(up);

    });
    function getEmpName() {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                employeeList = '';
                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#expSelectedIdProf').html(employeeList);
                $('#expSelectedIdProf').val('');
                $('#update_Profile').attr("disabled", true);

                $('#expSelectedIdProf').change(function(){
                    selectedNameID  = $(this).find(':selected').val();
                    getUpdate();
                    $('#update_Profile').attr("disabled", false);
                });
            }
        });
    }

    $('#optionProfile1').click(function()
    {
        $('#expSelectedIdProf').hide();
        $('#supportingDocu').html('*Required fields');
        $('#profileEdit').hide();
        $('#update_Profile').hide();
        $('#submitProfile').show();
        $('#check_show').show();
        $('#emp_position').val('');
        $('#emp_date_hired').val('');
        $('#emp_age').val('');
        $('#emp_first_name').val('');
        $('#emp_mid_name').val('');
        $('#emp_last_name').val('');
        $('#emp_religion').val('');
        $('#emp_dependents').val('');
        $('#emp_contact_number').val('');
        $('#emp_email_add').val('');
        $('#emp_birth_date').val('');
        $('#emp_sss').val('');
        $('#emp_philhealth').val('');
        $('#emp_pagibig').val('');
        $('#emp_tin').val('');
        $('#emp_present_address').val('');
        $('#emp_permanent_address').val('');
        $('#emp_salary').val('');
        $('#emp_profile_pic').val('');
        $('#req_submit').val('');
        $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
        $('#emp_in1').val('');
        $('#emp_out1').val('');
        $('#emp_in2').val('');
        $('#emp_out2').val('');
        $('#emp_in3').val('');
        $('#emp_out3').val('');
        $('#emp_in4').val('');
        $('#emp_out4').val('');
        $('#emp_in5').val('');
        $('#emp_out5').val('');
        $('#emp_in6').val('');
        $('#emp_out6').val('');
        $('#emp_in7').val('');
        $('#emp_out7').val('');
        $('#ciMuni').val('');
        $('#ciProv').val('');
        $('#ccType').val('');
        $('#empRate').val('Daily');
        $('#empWage').val('');
        $('#emp_state').val('Applicant');
        $('#ciInfo').hide();
        $('#allowanceRemove').show();
        $('#emp_allowances').val('');
        $('#emp_fixed_sched').val('');
        $('#emp_sched_remarks').val('');
        $('.emp_checklist').prop('checked', false);

        var he = 'Employee 201 File: <small style = "color : red">*please upload zip file</small>';
        $('#update201').html(he);
    });
    function getUpdate()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_update_profile',
            data:
                {
                    'selectedNameID' : selectedNameID
                },
            success : function(data)
            {
                get_date_on_update = data;
                 if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciInfo').show();
                    $('#ciMuni').val(data[0][0].muni);
                    $('#ciProv').val(data[0][0].prov);
                    $('#ccType').val(data[0][0].cc);
                    $('#ciMotorReq').show();
                    $('#officeChecklist').hide();
                    $('#ciChecklist').show();
                    $('#reqName').html('CI - 201 FILE CHECKLIST');

                }
                else {
                    $('#ciInfo').hide();
                    $('#ciMotorReq').hide();
                    $('#officeChecklist').show();
                    $('#ciChecklist').hide();
                    $('#reqName').html('OFFICE BASED - 201 FILE CHECKLIST');
                }
                var monIn;
                if(data[5][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[5][0].emp_in;
                }
                var monOut;
                if(data[5][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[5][0].emp_out;
                }
                var tuesIn;
                if(data[6][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[6][0].emp_in;
                }
                var tuesOut;
                if(data[6][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[6][0].emp_out
                }
                var wedIn;
                if(data[7][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[7][0].emp_in ;
                }
                var wedOut;
                if(data[7][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[7][0].emp_out;
                }
                var thursIn;
                if(data[8][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[8][0].emp_in;
                }
                var thursOut;
                if(data[8][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[8][0].emp_out;
                }
                var friIn;
                if(data[9][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[9][0].emp_in;
                }
                var friOut;
                if(data[9][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[9][0].emp_out;
                }
                var satIn;
                if(data[10][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[10][0].emp_in;
                }
                var satOut;
                if(data[10][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[10][0].emp_out;
                }
                var sunIn;
                if(data[11][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[11][0].emp_in;
                }
                var sunOut;
                if(data[11][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[11][0].emp_out;
                }
                var pic;
                if(data[0][0].profile_pic == "")
                {
                    pic = 'user_profile_pictures/default3.jpg'
                }
                else {
                    pic = data[0][0].profile_pic;
                }
                $('#emp_profile_pic_display').attr('src', ''+ pic+'');
                $('#emp_first_name').val(data[0][0].first_name);
                $('#emp_mid_name').val(data[0][0].middle_name);
                $('#emp_last_name').val(data[0][0].last_name);
                $('#emp_age').val(data[0][0].age);
                $('#emp_present_address').val(data[1][0].emp_address);
                $('#emp_permanent_address').val(data[2][0].emp_address);
                $('#emp_birth_date').val(data[0][0].date_birth);
                $('#emp_marital_status').val(data[0][0].marital_status);
                $('#emp_religion').val(data[0][0].religion);
                $('#emp_contact_number').val(data[3][0].emp_contact_info);
                $('#emp_email_add').val(data[4][0].emp_contact_info);
                $('#emp_dependents').val(data[0][0].dependents);
                $('#emp_branch').val(data[0][0].branch_name);
                $('#emp_position').val(data[0][0].position);
                $('#emp_date_hired').val(data[0][0].hired);
                $('#emp_salary').val(data[0][0].salary);
                $('#emp_sss').val(data[0][0].sss);
                $('#emp_pagibig').val(data[0][0].pagibig);
                $('#emp_philhealth').val(data[0][0].philhealth);
                $('#emp_tin').val(data[0][0].tin);
                $('#emp_gender').val(data[0][0].gender);
                $('#emp_profile_pic').val('');
                $('#emp_in1').val(monIn);
                $('#emp_out1').val(monOut);
                $('#emp_in2').val(tuesIn);
                $('#emp_out2').val(tuesOut);
                $('#emp_in3').val(wedIn);
                $('#emp_out3').val(wedOut);
                $('#emp_in4').val(thursIn);
                $('#emp_out4').val(thursOut);
                $('#emp_in5').val(friIn);
                $('#emp_out5').val(friOut);
                $('#emp_in6').val(satIn);
                $('#emp_out6').val(satOut);
                $('#emp_in7').val(sunIn);
                $('#emp_out7').val(sunOut);
                $('#empRate').val(data[0][0].rate);
                $('#empWage').val(data[0][0].wage);
                $('#emp_state').val(data[0][0].stat);
                $('#noDays').val(data[0][0].days);
                $('#emp_fixed_sched').val(data[12][0].emp_fixed_sched);
                $('#emp_sched_remarks').val(data[12][0].emp_sched_remarks);


                var i;
                var check;

                $('.emp_checklist').prop('checked', false);

                $('.emp_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });


            }
        });
    }

    $('#update_Profile').click(function()
    {
        $("#update_Profile").attr("disabled", true);

        var empBranch = $('#emp_branch').val();
        var empPosition = $('#emp_position').val();
        var empDateHire = $('#emp_date_hired').val();
        var empAge = $('#emp_age').val();
        var empFirst = $('#emp_first_name').val();
        var empMid = $('#emp_mid_name').val();
        var empLast = $('#emp_last_name').val();
        var empReligion = $('#emp_religion').val();
        var empContactNumber = $('#emp_contact_number').val();
        var empEmail = $('#emp_email_add').val();
        var empGender = $('#emp_gender').val();
        var empBirth = $('#emp_birth_date').val();
        var empMaritalStatus = $('#emp_marital_status').val();
        var empSss = $('#emp_sss').val();
        var empPhilhealth = $('#emp_philhealth').val();
        var empPagibig = $('#emp_pagibig').val();
        var empTin = $('#emp_tin').val();
        var empPresentAddress = $('#emp_present_address').val();
        var empPermanentAddress = $('#emp_permanent_address').val();
        var empSalary = $('#emp_salary').val();
        var empDependents = $('#emp_dependents').val();
        var empImage = $('#emp_profile_pic')[0].files[0];
        var empInMon;
        var empOutMon;
        var empInTues;
        var empOutTues;
        var empInWed;
        var empOutWed;
        var empInThurs;
        var empOutThurs;
        var empInFri;
        var empOutFri;
        var empInSat;
        var empOutSat;
        var empInSun;
        var empOutSun;
        var ciMuni = $('#ciMuni').val();
        var ciProv = $('#ciProv').val();
        var ccType = $('#ccType').val();
        var empRate = $('#empRate').val();
        var empWage = $('#empWage').val();
        var empState = $('#emp_state').val();
        var noDays = $('#noDays').val();
        var empFile = $('#req_submit').prop('files')[0];
        var empFixed =  $('#emp_fixed_sched').val();
        var empSchedRemarks =  $('#emp_sched_remarks').val()

        if($('#emp_in1').val() == "")
        {
            empInMon = '00:00:00';
        }
        else
        {
            empInMon = $('#emp_in1').val();
        }
        if( $('#emp_out1').val() == "")
        {
            empOutMon = '00:00:00';
        }
        else
        {
            empOutMon = $('#emp_out1').val();
        }
        if($('#emp_in2').val() == "")
        {
            empInTues = '00:00:00';
        }
        else
        {
            empInTues = $('#emp_in2').val();
        }
        if($('#emp_out2').val() == "")
        {
            empOutTues = '00:00:00'
        }
        else
        {
            empOutTues = $('#emp_out2').val();
        }
        if($('#emp_in3').val() == ""){
            empInWed = '00:00:00'
        }
        else
        {
            empInWed = $('#emp_in3').val();
        }
        if($('#emp_out3').val() == "") {
            empOutWed = '00:00:00'
        }
        else
        {
            empOutWed = $('#emp_out3').val();
        }
        if($('#emp_in4').val() == "")
        {
            empInThurs = '00:00:00';
        }
        else
        {
            empInThurs = $('#emp_in4').val();
        }
        if($('#emp_out4').val() == "")
        {
            empOutThurs = '00:00:00';
        }
        else
        {
            empOutThurs = $('#emp_out4').val();
        }
        if($('#emp_in5').val() == "")
        {
            empInFri = '00:00:00';
        }
        else
        {
            empInFri = $('#emp_in5').val();
        }
        if($('#emp_out5').val() == "")
        {
            empOutFri = '00:00:00';
        }
        else
        {
            empOutFri = $('#emp_out5').val()
        }
        if($('#emp_in6').val() == "")
        {
            empInSat = '00:00:00';
        }
        else
        {
            empInSat = $('#emp_in6').val();
        }
        if($('#emp_out6').val() == "")
        {
            empOutSat = '00:00:00';
        }
        else
        {
            empOutSat = $('#emp_out6').val();
        }
        if($('#emp_in7').val() == "")
        {
            empInSun = '00:00:00';
        }
        else
        {
            empInSun = $('#emp_in7').val();
        }
        if($('#emp_out7').val() == "")
        {
            empOutSun =  '00:00:00';
        }
        else
        {
            empOutSun = $('#emp_out7').val();
        }


        var formData = new FormData();
        formData.append('empBranch', empBranch);
        formData.append('empPosition', empPosition);
        formData.append('empDateHire', empDateHire);
        formData.append('empAge', empAge);
        formData.append('empFirst', empFirst);
        formData.append('empMid', empMid);
        formData.append('empLast', empLast);
        formData.append('empReligion', empReligion);
        formData.append('empContactNumber', empContactNumber);
        formData.append('empEmail', empEmail);
        formData.append('empGender', empGender);
        formData.append('empBirth', empBirth);
        formData.append('empMaritalStatus', empMaritalStatus);
        formData.append('empSss', empSss);
        formData.append('empPhilhealth', empPhilhealth);
        formData.append('empPagibig', empPagibig);
        formData.append('empTin', empTin);
        formData.append('empPresentAddress', empPresentAddress);
        formData.append('empPermanentAddress', empPermanentAddress);
        formData.append('empSalary', empSalary);
        formData.append('empDependents', empDependents);
        formData.append('emp_profile_pic', empImage);
        formData.append('empFile', empFile);
        formData.append('empInMon', empInMon);
        formData.append('empOutMon', empOutMon);
        formData.append('empInTues', empInTues);
        formData.append('empOutTues', empOutTues);
        formData.append('empInWed', empInWed);
        formData.append('empOutWed', empOutWed);
        formData.append('empInThurs', empInThurs);
        formData.append('empOutThurs', empOutThurs);
        formData.append('empInFri', empInFri);
        formData.append('empOutFri', empOutFri);
        formData.append('empInSat', empInSat);
        formData.append('empOutSat', empOutSat);
        formData.append('empInSun', empInSun);
        formData.append('empOutSun', empOutSun);
        formData.append('ciMuni', ciMuni);
        formData.append('ciProv', ciProv);
        formData.append('empRate', empRate);
        formData.append('empWage', empWage);
        formData.append('empState', empState);
        formData.append('noDays', noDays);
        formData.append('ccType', ccType);
        formData.append('selectedNameID', selectedNameID);
        formData.append('empFixed', empFixed);
        formData.append('empSchedRemarks', empSchedRemarks);

        if( $('#req_submit').val().length >= 1)
        {
            empUpdatefunc(formData);
        }
        else
            {
                if(confirm('There is no attachment to be uploaded. Do you wish to continue?'))
                {
                    empUpdatefunc(formData);
                }
            else
                {
                    $("#update_Profile").attr("disabled", false);
                }
            }
    });
    function empUpdatefunc(form)
    {
        $.ajax
        ({
            type: 'post',
            url: 'human-resources-update-profile',
            contentType: false,
            processData: false,
            async : true,
            data: form,
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function(data)
            {
                positionIdChange = data[2];
                oldPos = data[0];
                var myData1 = {};
                var checkVal1 = '';
                if(data.type == 'type')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#update_Profile").attr("disabled", false);
                    $('#modal-invalidtype').modal('show');
                    $('#req_submit').val('');
                }
                else if(data.error == 'required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#update_Profile").attr("disabled", false);
                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        clearInterval(timerError);
                    }, 1000);
                }
                else if(data[0] != data[1])
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('.emp_checklist').each(function()
                    {
                        if($(this).is(":checked"))
                        {
                            checkVal1 = $(this).val();
                            myData1[checkVal1] = checkVal1;
                        }
                    });

                    $.ajax
                    ({
                        type: 'post',
                        url: 'human-resources-update-check-emp',
                        data:
                            {
                                myData1: myData1,
                                'id': selectedNameID
                            },
                        success: function () {
                            $('#modal-pos').modal({backdrop: "static"});
                            $('#posChangeRemarks').val('');
                            $('#type_change').val('');
                            $('#pos_file').val('');
                            $('#pos_from').val(data[0]);
                            $('#pos_to').val(data[1]);
                            $('#nameBox').html(data[3]);
                            $('#pos_change').val(data[0] + ' to ' + data[1]);
                            $('#allowance_change').val(data[4]);
                        }
                    });
                }
                else if(data.success == 'success')
                {

                    $('.emp_checklist').each(function()
                    {
                        if($(this).is(":checked"))
                        {
                            checkVal1 = $(this).val();
                            myData1[checkVal1] = checkVal1;
                        }
                    });

                    $.ajax
                    ({
                        type : 'post',
                        url : 'human-resources-update-check-emp',
                        data :
                            {
                                myData1 : myData1,
                                'id' : selectedNameID
                            },
                        success : function()
                        {
                            $('#modal-sendingrequest').modal('hide');
                            $("#update_Profile").attr("disabled", true);

                            var timerSuccess = setInterval(function ()
                            {
                                $('#modal-updatesuccessprofile').modal('show');

                                var timerSuccessHide = setInterval(function ()
                                {
                                    $('#modal-updatesuccessprofile').modal('hide');
                                    clearInterval(timerSuccessHide);
                                },5000);
                                clearInterval(timerSuccess);
                            },1000);
                            $('#emp_position').val('');
                            $('#emp_date_hired').val('');
                            $('#emp_age').val('');
                            $('#emp_first_name').val('');
                            $('#emp_mid_name').val('');
                            $('#emp_last_name').val('');
                            $('#emp_religion').val('');
                            $('#emp_dependents').val('');
                            $('#emp_contact_number').val('');
                            $('#emp_email_add').val('');
                            $('#emp_birth_date').val('');
                            $('#emp_sss').val('');
                            $('#emp_philhealth').val('');
                            $('#emp_pagibig').val('');
                            $('#emp_tin').val('');
                            $('#emp_present_address').val('');
                            $('#emp_permanent_address').val('');
                            $('#emp_salary').val('');
                            $('#emp_profile_pic').val('');
                            $('#req_submit').val('');
                            $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
                            $('#emp_in1').val('');
                            $('#emp_out1').val('');
                            $('#emp_in2').val('');
                            $('#emp_out2').val('');
                            $('#emp_in3').val('');
                            $('#emp_out3').val('');
                            $('#emp_in4').val('');
                            $('#emp_out4').val('');
                            $('#emp_in5').val('');
                            $('#emp_out5').val('');
                            $('#emp_in6').val('');
                            $('#emp_out6').val('');
                            $('#emp_in7').val('');
                            $('#emp_out7').val('');
                            $('#ciMuni').val('');
                            $('#ciProv').val('');
                            $('#ccType').val('');
                            $('#empRate').val('');
                            $('#empWage').val('');
                            $('#emp_state').val('');
                            $('#ciInfo').hide();
                            $('#emp_fixed_sched').val('');
                            $('#emp_sched_remarks').val('');
                            $('.emp_checklist').prop('checked', false);
                            getEmpName();
                            employeeFetchall();
                            tableProfLogs.ajax.reload(null, false);
                            submitCounter = true;
                            submitContractRefresh = true;
                        }
                    });
                }
            }
        })
    }

    function employeeFetchStatus()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                var employeeList = '';

                console.log(data);

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#empStatusId').html(employeeList);
                $('#empStatusId').val('');

                $('#empStatusId').change(function()
                {

                    selectedContract  = $(this).find(':selected').val();
                    console.log(selectedContract);
                    $('#update_status').attr("disabled", false);
                    showConStat();
                });
            }
        });
    }
    function showConStat()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-contract',
            data:
                {
                    'selectedContract' : selectedContract
                },
            success : function(data) {
                if (data[0].emp_status == 'Off-Boarding') {
                    $('#outDiv').show();

                } else {
                    $('#outDiv').hide();
                }
                if(data[0].contract_file_path != '')
                {
                    $('#showContractLaman').html('<p style = "font-family: Georgia,serif; border-left: 5px solid red;\n' +
                        '  background-color: lightgrey;">Contract Uploaded</p>');
                    $('#showContractLaman').show();
                }
                else
                {
                    $('#showContractLaman').html('<p style = "font-family: Georgia,serif; border-left: 5px solid red;\n' +
                        '  background-color: lightgrey;">No Contract Uploaded</p>');
                    $('#showContractLaman').show();
                }

                $('#pos_status').val(data[0].emp_position);
                $('#hired_status').val(data[0].emp_date_hired);
                $('#start_date').val(data[0].emp_date_hired);
                $('#end_date').val(data[0].emp_end_date);
                $('#contract_status').val(data[0].emp_status);
                $('#out_status').val(data[0].emp_outgoing);
                $('#statusRed').html('<small>*end of contract</small>')
            }
        });
    }
    $('.human_resources_employee_class').click(function()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_mainEmp1') {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeMain = '#tab_mainEmp1';
            }
            else if (hr_main_add)
            {
                console.log('already loaded');
                activeMain = '#tab_mainEmp1';
            }
            else if (hr_main_add == false)
            {
                hr_main_add = true;
                activeMain = '#tab_mainEmp1';
            }
        }
        else if (gethref == '#tab_mainEmp2')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeMain = '#tab_mainEmp2';
            }
            else if (hr_main_stat)
            {
                console.log(submitContractRefresh);
                if(submitContractRefresh == true)
                {
                    tableContractStat.ajax.reload(null, false);
                    submitContractRefresh = false;
                }
                else
                {
                    console.log('already loaded');
                }

                activeMain = '#tab_mainEmp2';
            }
            else if (hr_main_stat == false)
            {
                hr_main_stat = true;
                activeMain = '#tab_mainEmp2';
                employeeFetchStatus();
                showContract();
            }
        }
    });

    $('.human_resources_status_class').click(function()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_stat1') {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeStat = '#tab_stat1';
            }
            else if (hr_status_uno)
            {
                console.log('already loaded');
                activeStat = '#tab_stat1';
            }
            else if (hr_status_uno == false) {
                hr_status_uno = true;
                activeStat = '#tab_stat1';
            }
        }
        else if (gethref == '#tab_stat2') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeStat = '#tab_stat2';
            }
            else if (hr_status_dos) {

                console.log('already loaded');
                activeStat = '#tab_stat2';
            }
            else if (hr_status_dos == false) {
                hr_status_dos = true;
                activeStat = '#tab_stat2';
                employeeFetchAtm();
                atmUni();
            }
        }
        else if (gethref == '#tab_stat3') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeStat = '#tab_stat3';
            }
            else if (hr_status_tres) {

                console.log('already loaded');
                activeStat = '#tab_stat3';
            }
            else if (hr_status_tres == false) {
                hr_status_tres = true;
                activeStat = '#tab_stat3';
                employeeFetchOims();
                showOims();
            }
        }
        else if (gethref == '#tab_stat4') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeStat = '#tab_stat4';
            }
            else if (hr_status_kwatro)
            {
                if(counterPromo == true)
                {
                    tablePromotionList.ajax.reload(null, false);
                    counterPromo = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeStat = '#tab_stat4';
            }
            else if (hr_status_kwatro == false) {
                hr_status_kwatro = true;
                activeStat = '#tab_stat4';
                showPromotion();
            }
        }
    });
    $('#update_status').click(function()
    {
        $(this).attr("disabled", true);
        var end_date = $('#end_date').val();
        var con_stat = $('#contract_status').val();
        var out_status = $('#out_status').val();
        var con_file = $('#contract_file').prop('files')[0];

        var formData = new FormData();
        formData.append('end_date', end_date);
        formData.append('con_stat', con_stat);
        formData.append('out_status', out_status);
        formData.append('con_file', con_file);
        formData.append('selectedContract', selectedContract);

        // if(con_file != null)
        // {
            $.ajax
            ({
                type : 'post',
                url: 'human-resources-update-con-stat',
                contentType: false,
                processData: false,
                async: true,
                data: formData,
                beforeSend: function ()
                {
                    $('#modal-sendingrequest').modal('show');
                },
                success: function(data)
                {

                    if(data.change == 'change')
                    {
                        $('#modal-sendingrequest').modal('hide');
                        $('#update_status').attr("disabled", false);

                        var timerChange = setInterval(function ()
                        {
                            $('#modal-changestat').modal('show');
                            clearInterval(timerChange);
                        }, 1000);
                    }
                    else if(data.error == 'required')
                    {
                        $('#modal-sendingrequest').modal('hide');
                        $('#update_status').attr("disabled", false);

                        var timerError = setInterval(function ()
                        {
                            $('#modal-filluperror').modal('show');
                            clearInterval(timerError);
                        }, 1000);
                    }
                    else {
                        $('#modal-sendingrequest').modal('hide');
                        $('#update_status').attr("disabled", true);
                        var timerSuccess = setInterval(function ()
                        {
                            $('#modal-updatecontract').modal('show');
                            var timerSuccessHide = setInterval(function ()
                            {
                                $('#modal-updatecontract').modal('hide');
                                clearInterval(timerSuccessHide);
                            },5000);
                            clearInterval(timerSuccess);
                        },1000);
                        $('#pos_status').val('');
                        $('#hired_status').val('');
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $('#contract_status').val('Probationary');
                        $('#out_status').val('Resigned');
                        $('#outDiv').hide();
                        $('#contract_file').val('');

                        dashData();
                        statusCounter = true;
                        tableProfLogs.ajax.reload(null, false);
                        employeeFetchStatus();
                        tableContractStat.ajax.reload(null, false);
                        $('#showContractLaman').hide();
                    }
                }
            })
        // }
        // else
        // {
        //     $(this).attr("disabled", false);
        //     alert('Please upload Contract Softcopy!');
        // }

    });
    dashData();
    $('.human_resources_leftside_class').click(function()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#human_resources_dashboard')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeLeft = '#human_resources_dashboard';
            }
            else if (hr_left_prof)
            {
                $('#tabEmpList1').click();
                if(submitCounter == true || statusCounter == true)
                {
                    tableEmployeeList.ajax.reload(null, false);
                    dashData();
                }
                else
                    {
                        console.log('already loaded');
                    }
                activeLeft = '#human_resources_dashboard';
            }
            else if (hr_left_prof == false)
            {
                hr_left_prof = true;
                activeLeft = '#human_resources_dashboard';

            }
        }
        else if (gethref == '#human_resources_employee')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeLeft = '#human_resources_employee';
            }
            else if (hr_left_emp)
            {
                console.log('already loaded');
                activeLeft = '#human_resources_employee';
            }
            else if (hr_left_emp == false)
            {
                hr_left_emp = true;
                activeLeft = '#human_resources_employee';
                getBranchesSched();
                positionEmp();
            }
        }
        else if (gethref == '#human_resources_motor')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeLeft = '#human_resources_motor';
            }
            else if (hr_left_motor)
            {
                console.log('already loaded');
                activeLeft = '#human_resources_motor';
            }
            else if (hr_left_motor == false)
            {
                hr_left_motor = true;
                activeLeft = '#human_resources_motor';
                ciNames();
                motor_list_table();


            }
        }
        else if (gethref == '#human_resources_equip')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                activeLeft = '#human_resources_equip';
            }
            else if (hr_left_eq)
            {
                console.log('already loaded');
                activeLeft = '#human_resources_equip';
            }
            else if (hr_left_eq == false)
            {
                hr_left_eq = true;
                activeLeft = '#human_resources_equip';
            }
        }
    });
    function getBranchesSched()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_get_branch_sched',
            success : function(data)
            {
                var y;
                BranchList = '';
                for (y = 0; y < data[0].length; y++)
                {
                    BranchList += '<option value="' + data[0][y].branch_name + '">' + data[0][y].branch_name + '</option>';
                }
                $('#emp_branch').html(BranchList + '<option value = "On-Site">On-Site</option>');
            }
        })
    }
    function employee_assigned_items()
    {

        $('#human-resource-assigned-items thead th').each(function () {
            table_items[l] = $(this).text();
            l++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableAssigned = $('#human-resource-assigned-items').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            // "ajax": "/human-resources-employee-items",
            "ajax":
                {
                    type: 'get',
                    url: "/human-resources-employee-items",
                    data: function (d)
                    {
                        console.log(empIDshow);
                        d.emp_id = empIDshow;
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'item_profile.id'},
                    {data: 'category', name: 'item_profile.item_category'},
                    {data: 'model', name: 'item_profile.item_brand_model'},
                    {data: 'color', name: 'item_profile.item_color'},
                    {data: 'remarks', name: 'item_profile.item_remarks'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
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
        $('#human-resource-assigned-items_filter input').unbind();
        $('#human-resource-assigned-items_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableAssigned.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '')
                    {
                        tableAssigned.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function positionEmp()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-position',
            success: function(data)
            {
                var posList = '';
                var hh;
                for (hh = 0; hh < data.length; hh++)
                {
                    posList += '<option value="' + data[hh].position_name + '">' + data[hh].position_name + '</option>';
                }
                $('#emp_position').html(posList);
                $('#emp_position').val('');
            }
        })

    }
    $('#emp_position').change(function()
    {
        var ci = $(this).find(':selected').val();

       if(ci == 'FV Supervisor' || ci == 'FV Level I' || ci == 'FV Level II' || ci == 'School Verifier'  || ci == 'FV PER ACCOUNT' )
        {
            $.ajax
            ({
                type: 'get',
                url: 'human-resources-get-prov',
                success: function(data)
                {
                    var provList = '';
                    var qw;
                    for (qw = 0; qw < data.length; qw++)
                    {
                        provList += '<option value="' + data[qw].name + '">' + data[qw].name + '</option>';
                    }
                $('#ci_assign').html(provList);
                    $('#ciInfo').show();
                }
            })
            $('#reqName').html('FIELD VERIFIER - 201 FILE CHECKLIST');
            $('#ciMotorReq').show();
            $('#officeChecklist').hide();
            $('#ciChecklist').show();

        }
        else
            {
                $('#ci_assign').val('');
                $('#ciInfo').hide();
                $('#reqName').html('OFFICE BASED - 201 FILE CHECKLIST');
                $('#ciMotorReq').hide();
                $('#officeChecklist').show();
                $('#ciChecklist').hide();

            }
    });
    $('#btnDownloadEmp').click(function()
    {
        var id_encode = btoa(empIDshow);
        var q = '<form action="/human-resources-file-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_form_download">'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#down').html(q);
        $('#button_form_download').click();
    });



    $('#ciMuni').focusout(function ()
    {
        if($('#ciMuni').val() === '')
        {
            $('#ciProv').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' : $('#ciMuni').val()
                    },
                success: function (data)
                {
                    console.log(data[0].id);
                    $('#idProvince').val(data[0].province_id);
                    $('#idMunicipality').val(data[0].id);
                    fetchProv();

                    setTimeout(function ()
                    {
                        $('#ciMuni').val(data[0].muni_name);
                    },1000);
                }
            });
        }
    });

    $('#ciMuni').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('idProvince').val('');
            $('idMunicipality').val('');
            $('#idProvince').val(ui.item.muniID);
            $('#idMunicipality').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv();
                clearInterval(clearTime);
            },10)
        }
    });
    function fetchProv()
    {
        muniID = $('#idProvince').val();
        originalMuniID = $('#idMunicipality').val();
        $.ajax
        ({
            method: 'get',
            url: 'fetch-prov',
            data:
                {
                    'muniID': muniID,
                    'originalMuniID': originalMuniID
                },
            beforeSend: function ()
            {
                $('#loadingProv').append('<img src= "dist/img/loading.gif" width="3%">');
            },
            success: function (data)
            {
                $('#loadingProv').html('');
                $('#ciProv').val('');
                $('#ciProv').val(data[0][0].name);
            }
        });
    }
    $('#contract_status').change(function()
    {
        var rs = $(this).find(':selected').val();

        if(rs == 'Off-Boarding')
        {
            $('#outDiv').show();
        }
        else
            {
                $('#outDiv').hide();
            }
    });
    function profLogs()
    {
        $('#human_resources_general_logs thead th').each(function ()
        {
            tableLogs[prof_logs] = $(this).text();
            prof_logs++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableProfLogs = $('#human_resources_general_logs').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableLogs[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'HUMAN RESOURCES LOGS',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableLogs[(idx)];
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
                        extend: 'print',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableLogs[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "human-resources-logs",
            "columns":
                [
                    {data: 'user', name: 'users.name' },
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'activities', name: 'profile_log.activities'},
                    {data: 'date', name : 'profile_log.created_at'}
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human_resources_general_logs_filter').find('input').unbind();
        $('#human_resources_general_logs_filter').find('input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableProfLogs.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '')
                    {
                        tableProfLogs.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#btnMotor').click(function()
    {
        $("#btnMotor").attr("disabled", true);

        var ciID = $('#motor_ci_name').find(':selected').val();
        var model = $('#motor_model').val();
        var orcr = $('#motor_orcr').val();
        var cc = $('#motor_cc').val();
        var plate = $('#motor_plate').val();
        var renew = $('#motor_renew').val();
        var kilo = $('#motor_kmpl').val();
        var name = $('#motor_name').val();
        var gas = $('#motor_gas').val();
        var file = $('#motor_file').prop('files')[0];

        var formData = new FormData();
        formData.append('ci_id', ciID);
        formData.append('model', model);
        formData.append('orcr', orcr);
        formData.append('cc', cc);
        formData.append('plate', plate);
        formData.append('renew', renew);
        formData.append('kilo', kilo);
        formData.append('name', name);
        formData.append('gas', gas);
        formData.append('file', file);

        if(file != null)
        {
            $.ajax
            ({
                type : 'post',
                url : 'human-resources-motor',
                contentType: false,
                processData: false,
                async: true,
                data: formData,
                beforeSend: function ()
                {
                    $('#modal-sendingrequest').modal('show');
                },
                success: function(data)
                {
                    if(data.error == 'required')
                    {
                        $('#modal-sendingrequest').modal('hide');
                        $("#btnMotor").attr("disabled", false);

                        var timerError = setInterval(function ()
                        {
                            $('#modal-filluperror').modal('show');
                            clearInterval(timerError);
                        }, 1000);
                    }
                    else
                    {
                        $('#modal-sendingrequest').modal('hide');
                        $("#btnMotor").attr("disabled", false);

                        var timerSuccess = setInterval(function ()
                        {
                            $('#modal-motoradd').modal('show');
                            var timerSuccessHide = setInterval(function ()
                            {
                                $('#modal-motoradd').modal('hide');
                                clearInterval(timerSuccessHide);
                            },5000);
                            clearInterval(timerSuccess);
                        },1000);
                        $('#motor_model').val('');
                        $('#motor_orcr').val('Yes');
                        $('#motor_cc').val('');
                        $('#motor_plate').val('');
                        $('#motor_renew').val('January');
                        $('#motor_kmpl').val('');
                        $('#motor_name').val('');
                        $('#motor_gas').val('');
                        $('#motor_file').val('');
                        $('#motor_ci_name').val('');
                        tableProfLogs.ajax.reload(null, false);
                        tableMotorList.ajax.reload(null, false);
                    }

                }
            })
        }
        else
        {
            $("#btnMotor").attr("disabled", false);
            alert('Please upload Motorcycle Reference!');
        }

    });
    function motor_list_table()
    {
        $('#human-resources-motor-list thead th').each(function ()
        {
            tableMotor[h] = $(this).text();
            h++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableMotorList = $('#human-resources-motor-list').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        title : 'Motoryle Monitoring List',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableMotor[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Motorcyle Monitoring List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableMotor[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                            // var col = $('col', sheet);
                            //
                            // $(col[1]).attr('width', 50);
                            // $(col[2]).attr('width', 50);

                    },
                    {
                        extend: 'print',
                        title : 'Motoryle Monitoring List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tableMotor[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tableMotor[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-motor-list",
            "columns":
                [
                    {data: 'id', name: 'motor_list.id'},
                    {data: 'ci', name: 'users.name'},
                    {data: 'motor_model', name: 'motor_list.motor_model'},
                    {data: 'motor_cc', name: 'motor_list.motor_cc'},
                    {data: 'motor_renew', name: 'motor_list.motor_renew'},
                    {data: 'register_name', name: 'motor_list.register_name'},
                    {data: 'motor_orcr', name: 'motor_list.motor_orcr'},
                    {data: 'plate_number' , name: 'motor_list.plate_number'},
                    {data: 'motor_kmpl' , name: 'motor_list.motor_kmpl'},
                    {data: 'motor_gas' , name: 'motor_list.motor_gas'},
                    {
                        data: function action(data)
                        {
                            if(data.motor_file != '')
                            {
                                return '<span id="motorEdit-' + data.id + '"><button class="btn btn-xs btn-info" id="btnEditMotor" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-wrench"></i>Edit</button></span>' +
                                    '<span id="motorDelete-' + data.id + '"><button class="btn btn-xs btn-danger" id="btnDeleteMotor" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-remove"></i>Delete</button></span>' +
                                    '<span id="motorDl-' + data.id + '"><button class="btn btn-xs btn-success" id="btnDlMotor" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download" style = "color : black;"></i></button></span>' +
                                    '<span id = "downMotor"></span>';
                            }
                            else
                            {
                                return '<span id="motorEdit-' + data.id + '"><button class="btn btn-xs btn-info" id="btnEditMotor" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-wrench"></i>Edit</button></span>' +
                                    '<span id="motorDelete-' + data.id + '"><button class="btn btn-xs btn-danger" id="btnDeleteMotor" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-remove"></i>Delete</button></span>';
                            }

                        },
                        "name": 'motor_gas',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-motor-list_filter input').unbind();
        $('#human-resources-motor-list_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableMotorList.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableMotorList.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    $('#human-resources-motor-list').on('click', '#btnEditMotor', function()
    {
        editMotorId = $(this).val();

        $('#btnUpdateMotor').show();
        $('#btnMotorCancel').show();
        $('#btnMotor').hide();
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-motor-edit',
            data :
                {
                    'editMotorId' :  editMotorId
                },
            success: function(data) {

                $('#motor_model').val(data[0].motor_model);
                $('#motor_orcr').val(data[0].motor_orcr);
                $('#motor_cc').val(data[0].motor_cc);
                $('#motor_plate').val(data[0].plate_number);
                $('#motor_renew').val(data[0].motor_renew);
                $('#motor_kmpl').val(data[0].motor_kmpl);
                $('#motor_name').val(data[0].register_name);
                $('#motor_gas').val(data[0].motor_gas);
                $('#motor_ci_name').val(data[0].ci);
            }
        });
    });
    $('#btnMotorCancel').click(function()
    {
        $('#btnUpdateMotor').hide();
        $('#btnMotorCancel').hide();
        $('#btnMotor').show();
        $('#motor_model').val('');
        $('#motor_orcr').val('Yes');
        $('#motor_cc').val('');
        $('#motor_plate').val('');
        $('#motor_renew').val('January');
        $('#motor_kmpl').val('');
        $('#motor_name').val('');
        $('#motor_gas').val('')
        $('#motor_ci_name').val('');
    });

    $('#btnUpdateMotor').click(function()
    {
        $('#btnUpdateMotor').attr('disabled', true);

        var editCI = $('#motor_ci_name').find(':selected').val();
        var editModel = $('#motor_model').val();
        var editORCR = $('#motor_orcr').val();
        var editCc =  $('#motor_cc').val();
        var editPlate = $('#motor_plate').val();
        var editRenew =  $('#motor_renew').val();
        var editKmpl = $('#motor_kmpl').val();
        var editName =  $('#motor_name').val();
        var editGas = $('#motor_gas').val();
        var editFile = $('#motor_file').prop('files')[0];

        var formData = new FormData();
        formData.append('editModel', editModel);
        formData.append('editORCR', editORCR);
        formData.append('editCc', editCc);
        formData.append('editPlate', editPlate);
        formData.append('editRenew', editRenew);
        formData.append('editKmpl', editKmpl);
        formData.append('editName', editName);
        formData.append('editGas', editGas);
        formData.append('editFile', editFile);
        formData.append('editMotorId', editMotorId);
        formData.append('editCI', editCI);

        $.ajax
        ({
            type : 'post',
            url : 'human-resources-update-motor',
            contentType: false,
            processData: false,
            async: true,
            data: formData,
            beforeSend : function() {
                $('#modal-sendingrequest').modal('show');
            },
            success : function(data)
            {
                if(data.change == 'change')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#btnUpdateMotor').attr('disabled', false);

                    var timerFail = setInterval(function ()
                    {
                        $('#modal-changestat').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-changestat').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerFail);
                    },1000);
                }
                else if(data.success == 'success')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $('#btnUpdateMotor').attr('disabled', false);

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-motorUpdate').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-motorUpdate').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);

                    $('#btnUpdateMotor').hide();
                    $('#btnMotorCancel').hide();
                    $('#btnMotor').show();
                    $('#motor_model').val('');
                    $('#motor_orcr').val('Yes');
                    $('#motor_cc').val('');
                    $('#motor_plate').val('');
                    $('#motor_renew').val('January');
                    $('#motor_kmpl').val('');
                    $('#motor_name').val('');
                    $('#motor_gas').val('')
                    $('#modal-editMotor').modal('hide');
                    $('#motor_file').val('');
                    $('#motor_ci_name').val('');
                    tableMotorList.ajax.reload(null, false);
                    tableProfLogs.ajax.reload(null, false);
                }
            }
        })
    });

    $('#human-resources-motor-list').on('click', '#btnDeleteMotor', function()
    {
        delMotor = $(this).val();
        console.log(delMotor);
        if(confirm('Are you sure to delete?'))
            $.ajax
            ({
                type : 'get',
                url : 'human-resources-motor-delete',
                data :
                    {
                        'delMotor' :  delMotor
                    },
                success: function() {
                    alert('Successfully Deleted!!');
                    tableMotorList.ajax.reload(null, false);
                    tableProfLogs.ajax.reload(null, false);
                    $('#btnMotorCancel').click();
                }
            });
    });

    $('.human_resources_motor_class').click(function() {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_motor1') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeMotor = '#tab_motor1';
            }
            else if (hr_motor_list) {
                console.log('already loaded');
                activeMotor = '#tab_motor1';
            }
            else if (hr_motor_list == false) {
                hr_motor_list = true;
                activeMotor = '#tab_motor1';
            }
        }
    });

    function employeeFetchAtm()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#empAtmId').html(employeeList);
                $('#empAtmId').val('');

                $('#empAtmId').change(function()
                {
                    editAtmId  = $(this).find(':selected').val();
                    $('#btnAtm').attr("disabled", false);
                    getUniIDform();
                });
            }
        });
    }
    function getUniIDform()
    {
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-get-atm',
            data:
                {
                    'editAtmId' : editAtmId
                },
            success : function(data)
            {
                $('#emp_id_card').val(data[0].emp_id_card);
                $('#emp_id_no').val(data[0].emp_id_no);
                $('#emp_uniform').val(data[0].emp_uniform);
                $('#emp_bank').val(data[0].emp_bank);
                $('#emp_health_card').val(data[0].emp_health_card);
                $('#emp_accident').val(data[0].emp_accident);
                $('#emp_phone_number').val(data[0].emp_phone_number);
                $('#emp_phone_price').val(data[0].emp_phone_price);
                $('#emp_phone_desc').val(data[0].emp_phone_desc);
            }
        })
    }

    $('#btnAtm').click(function()
    {
        $('#btnAtm').attr("disabled", true);

        var idIf =  $('#emp_id_card').val();
        var idNo =  $('#emp_id_no').val();
        var empUni =  $('#emp_uniform').val();
        var empBank = $('#emp_bank').val();
        var empHealth = $('#emp_health_card').val();
        var empAcc = $('#emp_accident').val();
        var empPhNume = $('#emp_phone_number').val();
        var empPhonePirice = $('#emp_phone_price').val();
        var empPhoneDesc = $('#emp_phone_desc').val();

        $.ajax
        ({
            type : 'get',
            url : 'human-resources-update-atm',
            data:
                {
                    'editAtmId' : editAtmId,
                    'idIf' : idIf,
                    'idNo' : idNo,
                    'empUni' : empUni,
                    'empBank' : empBank,
                    'empHealth' : empHealth,
                    'empAcc' : empAcc,
                    'empPhNume' : empPhNume,
                    'empPhonePirice' : empPhonePirice,
                    'empPhoneDesc' : empPhoneDesc
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                if(data.change == "change")
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnAtm").attr("disabled", false);

                    var timerChange = setInterval(function ()
                    {
                        $('#modal-change-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-change-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerChange);
                    },500);
                }
                else
                    {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnAtm").attr("disabled", false);

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                        employeeFetchAtm();
                        $('#emp_id_card').val('With ID');
                        $('#emp_id_no').val('');
                        $('#emp_uniform').val('');
                        $('#emp_bank').val('None');
                        $('#emp_health_card').val('');
                        $('#emp_accident').val('Not Insured');
                        $('#emp_phone_number').val('');
                        $('#emp_phone_price').val(0);
                        $('#emp_phone_desc').val('');

                    tableProfLogs.ajax.reload(null, false);
                    tableAtmList.ajax.reload(null, false);
                }

            }
        })
    })



    $('#btnChangePos').click(function()
    {

        var posTrans = $('#pos_change').val();
        var posType = $('#type_change').val();
        var posFile = $('#pos_file').prop('files')[0];
        var oldPos = $('#pos_from').val();
        var newPos = $('#pos_to').val();
        var posFile2 =  $('#pos_file').val();
        var changeAllowance = $('#allowance_change').val();
        var remarks  = $('#posChangeRemarks').val();

        var formData = new FormData();
        formData.append('posTrans', posTrans);
        formData.append('posType', posType);
        formData.append('posFile', posFile);
        formData.append('oldPos', oldPos);
        formData.append('newPos', newPos);
        formData.append('positionIdChange', positionIdChange);
        formData.append('posFile2', posFile2);
        formData.append('changeAllowance', changeAllowance);
        formData.append('remarks', remarks);

        if(posType == "")
        {
            alert('Choose Type of Change!');
        }
        else
        {
            if(posFile2 == '')
            {
                if(remarks == '')
                {
                    alert('Please insert remarks!');
                }
                else
                {
                    $.ajax
                    ({
                        type : 'post',
                        url  : 'human-resources-supp-doc-desc',
                        contentType: false,
                        processData: false,
                        async : true,
                        data : formData,
                        success : function(data)
                        {
                            if(data.error == 'required') {
                                alert('Please upload Supporting Document.');
                            }
                            else {
                                $('#modal-pos').modal('hide');
                                var timerSuccess = setInterval(function ()
                                {
                                    $('#modal-updatesuccessprofile').modal('show');

                                    var timerSuccessHide = setInterval(function ()
                                    {
                                        $('#modal-updatesuccessprofile').modal('hide');
                                        clearInterval(timerSuccessHide);
                                    },5000);
                                    clearInterval(timerSuccess);
                                },1000);
                                $('#emp_position').val('');
                                $('#emp_date_hired').val('');
                                $('#emp_age').val('');
                                $('#emp_first_name').val('');
                                $('#emp_mid_name').val('');
                                $('#emp_last_name').val('');
                                $('#emp_religion').val('');
                                $('#emp_dependents').val('');
                                $('#emp_contact_number').val('');
                                $('#emp_email_add').val('');
                                $('#emp_birth_date').val('');
                                $('#emp_sss').val('');
                                $('#emp_philhealth').val('');
                                $('#emp_pagibig').val('');
                                $('#emp_tin').val('');
                                $('#emp_present_address').val('');
                                $('#emp_permanent_address').val('');
                                $('#emp_salary').val('');
                                $('#emp_profile_pic').val('');
                                $('#req_submit').val('');
                                $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
                                $('#emp_in1').val('');
                                $('#emp_out1').val('');
                                $('#emp_in2').val('');
                                $('#emp_out2').val('');
                                $('#emp_in3').val('');
                                $('#emp_out3').val('');
                                $('#emp_in4').val('');
                                $('#emp_out4').val('');
                                $('#emp_in5').val('');
                                $('#emp_out5').val('');
                                $('#emp_in6').val('');
                                $('#emp_out6').val('');
                                $('#emp_in7').val('');
                                $('#emp_out7').val('');
                                $('#ciMuni').val('');
                                $('#ciProv').val('');
                                $('#ccType').val('');
                                $('#empRate').val('');
                                $('#empWage').val('');
                                $('#emp_state').val('');
                                $('#noDays').val('5');
                                $('#ciInfo').hide();
                                $('.emp_checklist').prop('checked', false);
                                getEmpName();
                                employeeFetchall();
                                submitCounter = true;
                                counterPromo = true;
                                tableProfLogs.ajax.reload(null, false);
                                submitContractRefresh = true;

                            }
                        }
                    })
                }
            }
            else
            {
                $.ajax
                ({
                    type : 'post',
                    url  : 'human-resources-supp-doc-desc',
                    contentType: false,
                    processData: false,
                    async : true,
                    data : formData,
                    success : function(data)
                    {
                        if(data.error == 'required') {
                            alert('Please upload Supporting Document.');
                        }
                        else {
                            $('#modal-pos').modal('hide');
                            var timerSuccess = setInterval(function ()
                            {
                                $('#modal-updatesuccessprofile').modal('show');

                                var timerSuccessHide = setInterval(function ()
                                {
                                    $('#modal-updatesuccessprofile').modal('hide');
                                    clearInterval(timerSuccessHide);
                                },5000);
                                clearInterval(timerSuccess);
                            },1000);
                            $('#emp_position').val('');
                            $('#emp_date_hired').val('');
                            $('#emp_age').val('');
                            $('#emp_first_name').val('');
                            $('#emp_mid_name').val('');
                            $('#emp_last_name').val('');
                            $('#emp_religion').val('');
                            $('#emp_dependents').val('');
                            $('#emp_contact_number').val('');
                            $('#emp_email_add').val('');
                            $('#emp_birth_date').val('');
                            $('#emp_sss').val('');
                            $('#emp_philhealth').val('');
                            $('#emp_pagibig').val('');
                            $('#emp_tin').val('');
                            $('#emp_present_address').val('');
                            $('#emp_permanent_address').val('');
                            $('#emp_salary').val('');
                            $('#emp_profile_pic').val('');
                            $('#req_submit').val('');
                            $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
                            $('#emp_in1').val('');
                            $('#emp_out1').val('');
                            $('#emp_in2').val('');
                            $('#emp_out2').val('');
                            $('#emp_in3').val('');
                            $('#emp_out3').val('');
                            $('#emp_in4').val('');
                            $('#emp_out4').val('');
                            $('#emp_in5').val('');
                            $('#emp_out5').val('');
                            $('#emp_in6').val('');
                            $('#emp_out6').val('');
                            $('#emp_in7').val('');
                            $('#emp_out7').val('');
                            $('#ciMuni').val('');
                            $('#ciProv').val('');
                            $('#ccType').val('');
                            $('#empRate').val('');
                            $('#empWage').val('');
                            $('#emp_state').val('');
                            $('#noDays').val('5');
                            $('#ciInfo').hide();
                            $('.emp_checklist').prop('checked', false);
                            getEmpName();
                            employeeFetchall();
                            submitCounter = true;
                            counterPromo = true;
                            tableProfLogs.ajax.reload(null, false);
                            submitContractRefresh = true;

                            // tablePromotionList.ajax.reload(null, false);
                        }
                    }
                })
            }
        }
    });

    $('#btnBackPos').click(function()
    {
        if(confirm('Are you sure to cancel updating position?'))
        {
            $('#modal-pos').modal('hide');
            var timerSuccess = setInterval(function ()
            {
                $('#modal-updatesuccessprofile').modal('show');

                var timerSuccessHide = setInterval(function ()
                {
                    $('#modal-updatesuccessprofile').modal('hide');
                    clearInterval(timerSuccessHide);
                },5000);
                clearInterval(timerSuccess);
            },1000);
            $('#emp_position').val('');
            $('#emp_date_hired').val('');
            $('#emp_age').val('');
            $('#emp_first_name').val('');
            $('#emp_mid_name').val('');
            $('#emp_last_name').val('');
            $('#emp_religion').val('');
            $('#emp_dependents').val('');
            $('#emp_contact_number').val('');
            $('#emp_email_add').val('');
            $('#emp_birth_date').val('');
            $('#emp_sss').val('');
            $('#emp_philhealth').val('');
            $('#emp_pagibig').val('');
            $('#emp_tin').val('');
            $('#emp_present_address').val('');
            $('#emp_permanent_address').val('');
            $('#emp_salary').val('');
            $('#emp_profile_pic').val('');
            $('#req_submit').val('');
            $('#emp_profile_pic_display').attr('src', 'user_profile_pictures/default3.jpg');
            $('#emp_in1').val('');
            $('#emp_out1').val('');
            $('#emp_in2').val('');
            $('#emp_out2').val('');
            $('#emp_in3').val('');
            $('#emp_out3').val('');
            $('#emp_in4').val('');
            $('#emp_out4').val('');
            $('#emp_in5').val('');
            $('#emp_out5').val('');
            $('#emp_in6').val('');
            $('#emp_out6').val('');
            $('#emp_in7').val('');
            $('#emp_out7').val('');
            $('#ciMuni').val('');
            $('#ciProv').val('');
            $('#ccType').val('');
            $('#empRate').val('');
            $('#empWage').val('');
            $('#emp_state').val('');
            $('#noDays').val('5');
            $('#ciInfo').hide();
            $('.emp_checklist').prop('checked', false);
            getEmpName();
            employeeFetchall();
            submitCounter = true;
            tableProfLogs.ajax.reload(null, false);
            submitContractRefresh = true;
        } else {

        }

    });

    function employeeFetchOims()
    {
        $.ajax
        ({
            type: 'get',
            url: 'human-resources-get-employees',
            success: function (data)
            {
                var j;
                employeeList = '';

                for (j = 0; j < data.length; j++)
                {
                    employeeList += '<option value="' + data[j].id + '">' + data[j].name + '_' + data[j].branch + '</option>';
                }
                $('#selectIdforOIMS').html(employeeList);
                $('#selectIdforOIMS').val('');

                $('#selectIdforOIMS').change(function()
                {
                    oimsGetId  = $(this).find(':selected').val();
                    console.log(oimsGetId);
                    $('#btnOIMS').attr("disabled", false);
                    getOims();
                });
            }
        });
    }
    function getOims()
    {
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-get-oims',
            data:
                {
                    'oimsGetId' : oimsGetId
                },
            success : function(data)
            {
                $('#oims_emp').val(data[0].emp_oims);
                $('#gmail_emp').val(data[0].emp_corporate_gmail);
            }
        })
    }
    $('#btnOIMS').click(function()
    {
        $('#btnOIMS').attr('disabled', true);
        var empOims = $('#oims_emp').val();
        var empGmail = $('#gmail_emp').val();

        $.ajax
        ({
            type : 'get',
            url : 'human-resources-update-access',
            data :
                {
                    'oimsGetId' : oimsGetId,
                    'empOims' : empOims,
                    'empGmail' : empGmail
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success : function(data)
            {
                if(data.change == "change")
                {
                    $('#modal-sendingrequest').modal('hide');
                    var timerFail = setInterval(function ()
                    {
                        $('#modal-change-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('modal-change-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerFail);
                    },500);
                    $('#btnOIMS').attr('disabled', false);
                }
                else
                {
                    $('#modal-sendingrequest').modal('hide');

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-atm').modal('show');
                        var timerSuccessHide = setInterval(function ()
                        {
                            $('modal-atm').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);
                        clearInterval(timerSuccess);
                    },1000);
                    $('#oims_emp').val('');
                    $('#gmail_emp').val('');
                    employeeFetchOims();
                    tableOimsList.ajax.reload(null,false);
                    tableProfLogs.ajax.reload(null, false);
                }
            }
        })
    });
    function showOims()
    {
        $('#human-resources-show-oims thead th').each(function ()
        {
            tableOims[oims_table] = $(this).text();
            oims_table++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableOimsList = $('#human-resources-show-oims').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'OIMS and Corporate Gmail Access',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableOims[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'OIMS and Corporate Gmail Access',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableOims[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'OIMS and Corporate Gmail Access',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return  tableOims[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tableAtm[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-oims-table",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'oims', name: 'emp_oims_gmail.emp_oims'},
                    {data: 'gmail', name: 'emp_oims_gmail.emp_corporate_gmail'}
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-show-oims_filter input').unbind();
        $('#human-resources-show-oims_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tableOimsList.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tableOimsList.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    function showPromotion()
    {
        $('#human-resources-show-promotion thead th').each(function ()
        {
            tablePromotion[promotion_list] = $(this).text();
            promotion_list++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tablePromotionList = $('#human-resources-show-promotion').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Promotion/Demotion List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePromotion[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Promotion/Demotion List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePromotion[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'Promotion/Demotion List',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePromotion[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tablePromotion[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-table-promotion",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'change', name: 'emp_position_supp.type_change'},
                    {data: 'pos_trans', name: 'emp_position_supp.position_transition'},
                    {data: 'allowance', name: 'emp_position_supp.allowance_transition'},
                    {
                        data: function action(data)
                        {
                            var a;

                            if(data.path != '')
                            {
                                if(data.rem != '')
                                {
                                    a = '<button class = "btn btn-block btn-xs btn-primary btnGetPromRem" name="' + data.id + '" style = "width : 100%"><i class="fa fa-fw fa-eye"></i>View Remarks</button>' +
                                        '<button class="btn-block btn btn-xs btn-success" id="btnDownloadDocu" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download Document</button>' +
                                        '                                <span id = "downPos"></span>';
                                }
                                else
                                {
                                    a =             '<button class="btn btn-xs btn-success btn-block" id="btnDownloadDocu" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download Document</button>' +
                                        '                                <span id = "downPos"></span>';
                                }
                            }
                            else
                            {
                                a =  '<button class = "btn btn-block btn-xs btn-primary btnGetPromRem" style = "width : 100%" name="' + data.id + '"><i class="fa fa-fw fa-eye"></i>View Remarks</button>';
                            }

                            return a;
                        },
                        "name": 'emp_position_supp.allowance_transition',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-show-promotion_filter input').unbind();
        $('#human-resources-show-promotion_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tablePromotionList.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tablePromotionList.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#human-resources-show-promotion').on('click', '#btnDownloadDocu', function()
    {
        var promId = $(this).val();
        var id_encode = btoa(promId);
        var q = '<form action="/human-resources-pos-doc-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_pos_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downPos').html(q);
        $('#button_pos_download').click();
        $('#downPos').hide();
    });
    function presentEmpTable()
    {
        $('#human-resources-present-employees thead th').each(function ()
        {
            tablePresent[pqwe] = $(this).text();
            pqwe++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tablePresentEmployees = $('#human-resources-present-employees').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Present Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePresent[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Present Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePresent[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'Present Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePresent[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tablePresent[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-employee-present",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'birth', name: 'users_profile.emp_date_birth'},
                    {data: 'gender', name: 'users_profile.emp_gender'},
                    {data: 'marital', name: 'users_profile.emp_marital_status'},
                    {data: 'con_status', name: 'users_profile.emp_status'},
                    {data: 'emp_status', name: 'users_profile.emp_process_status'},
                    {data: 'hired', name: 'users_profile.emp_date_hired'},
                    {data: 'end' , name: 'users_profile.emp_end_date'},
                    {
                        data: function action(data)
                        {
                            if(data.approval == 'Partial')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i>View Profile</button></span>' +
                                    '<span><button class="btnPartialRemarks btn btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-spinner"></i>Partial Remarks</button></span>';
                            }
                            else
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i>View Profile</button></span>';
                            }
                        },
                        "name": 'users_profile.emp_end_date',
                        "searchable" : false
                    }
                ],
            "fnRowCallback": function( nRow, aData)
            {
                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(aData.hired , aData.end);
                var test1 = date_diff_indays(aData.hired , now);
                var diff = contactdiff - test1 ;

                console.log(diff + ' days from end of contract');

                allOption(nRow, diff);
                yellowOption(nRow, diff);
                redOption(nRow, diff);
                if(diff <= 30 ) {
                    $('td', nRow).css('background-color', '#FEA4A4s');
                }
                else if(diff <= 60 )
                {
                    $('td', nRow).css('background-color', '#F5FA5D');
                }
            }
            ,
            "order": [[0, 'asc']],
            "pageLength": 100,
            "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-present-employees_filter input').unbind();
        $('#human-resources-present-employees_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tablePresentEmployees.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tablePresentEmployees.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function pastEmp()
    {
        $('#human-resources-past-employees thead th').each(function ()
        {
            tablePast[poiyu] = $(this).text();
            poiyu++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tablePastEmployees = $('#human-resources-past-employees').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Past Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePast[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Past Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePast[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'Past Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePast[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tablePast[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-employee-past",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'birth', name: 'users_profile.emp_date_birth'},
                    {data: 'gender', name: 'users_profile.emp_gender'},
                    {data: 'marital', name: 'users_profile.emp_marital_status'},
                    {data: 'con_status', name: 'users_profile.emp_status'},
                    {data: 'emp_status', name: 'users_profile.emp_process_status'},
                    {data: 'hired', name: 'users_profile.emp_date_hired'},
                    {data: 'end' , name: 'users_profile.emp_end_date'},
                    {
                        data: function action(data)
                        {
                            return '<span><button class="btn btn-md btn-danger" name="" value="' + data.id + '" style="width: 100%" disabled><i class = "fa fa-fw fa-sign-out"></i>Inactive</button></span>';
                        },
                        "name": 'users_profile.emp_end_date',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 100,
            "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-past-employees_filter input').unbind();
        $('#human-resources-past-employees_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tablePastEmployees.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tablePastEmployees.search($(this).val()).draw();
                    }
                }
            }
        });
    }


    $('.human_resources_employee_a_class').click(function()
    {
        var gethref = $(this).attr('href');
        console.log(gethref);
        if (gethref == '#tab_a') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_a';
            }
            else if (hr_general_emp) {
                if(approveCounter == true || partialCounter == true )
                {
                    tableEmployeeList.ajax.reload(null, false);
                    approveCounter = false;
                    partialCounter = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeEmp = '#tab_a';
                $('.due_contract_all').click();
            }
            else if (hr_general_emp == false) {
                hr_general_emp = true;
                activeEmp = '#tab_a';
                $('.due_contract_all').click();
            }
        }
        else if (gethref == '#tab_b') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_b';
            }
            else if (hr_present_emp) {
                if(submitCounter == true || statusCounter == true)
                {
                    tablePresentEmployees.ajax.reload(null, false);
                }
                else
                {
                    console.log('already loaded');
                }
                $('.due_contract_all').click();
                activeEmp = '#tab_b';
            }
            else if (hr_present_emp == false) {
                hr_present_emp = true;
                activeEmp = '#tab_b';
                presentEmpTable();
                $('.due_contract_all').click();
            }
        }
        else if (gethref == '#tab_c') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_c';
            }
            else if (hr_past_emp) {
                if(submitCounter == true || statusCounter == true)
                {
                    tablePastEmployees.ajax.reload(null, false);
                    submitCounter = false;
                    statusCounter = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeEmp = '#tab_c';
            }
            else if (hr_past_emp == false) {
                hr_past_emp = true;
                activeEmp = '#tab_c';
                pastEmp();
            }
        }
        else if (gethref == '#tab_d') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_d';
            }
            else if (hr_pending_emp) {
                if(submitRequested == true)
                {
                    tablePendingEmployees.ajax.reload(null, false);
                    submitRequested = false;
                }
                else
                {
                    console.log('already loaded');
                }

                activeEmp = '#tab_d';
            }
            else if (hr_pending_emp == false) {
                hr_pending_emp = true;
                activeEmp = '#tab_d';
                pendingEmp();
            }
        }
        else if (gethref == '#tab_e') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_e';
            }
            else if (hr_pending_emp_rec) {
                if(submitRequested == true)
                {
                    tablePendingRecEmployees.ajax.reload(null, false);
                    submitRequested = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeEmp = '#tab_e';
            }
            else if (hr_pending_emp_rec == false) {
                hr_pending_emp_rec = true;
                activeEmp = '#tab_e';
                pendEmp();
            }
        }
        else if (gethref == '#tab_f') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_f';
            }
            else if (hr_pending_emp_rey) {
                if(submitRequested == true)
                {
                    tablePendingRecEmployeesRey.ajax.reload(null, false);
                    submitRequested = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeEmp = '#tab_f';
            }
            else if (hr_pending_emp_rey == false) {
                hr_pending_emp_rey = true;
                activeEmp = '#tab_f';
                reyAccessProfiles();
            }
        }
        else if (gethref == '#tab_g') {
            if ($('' + gethref + '').hasClass('active')) {
                console.log('do nothing');
                activeEmp = '#tab_g';
            }
            else if (hr_over_mon) {
                if(submitRequested == true)
                {
                    tableOverallMonitoring.ajax.reload(null, false);
                    hr_over_mon = false;
                }
                else
                {
                    console.log('already loaded');
                }
                activeEmp = '#tab_g';
            }
            else if (hr_over_mon == false) {
                hr_over_mon = true;
                activeEmp = '#tab_g';
                overallEmp();
            }
        }
    });

    $('#human-resources-present-employees').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }
                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });
            }
        });
    });

    function showContract()
    {
        $('#human-resources-contract-status thead th').each(function () {
            table_constat[tablecon] = $(this).text();
            tablecon++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableContractStat = $('#human-resources-contract-status').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table_constat[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table_constat[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'print',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return table_constat[(idx)];
                                        }
                                    }
                            }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-con-stat-table",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'stat', name: 'users_profile.emp_status'},
                    {data: 'out', name: 'users_profile.emp_outgoing'},
                    {
                        data: function action(data)
                        {
                            if(data.path != '')
                            {
                                return '<span><button class="btn btn-xs btn-info" id="btnDownloadContract" name="" value="' + data.id + '" style="width: 75%" ><i class = "fa fa-fw fa-download"></i>Download</button></span>' +
                                    '<span id = "downContract"></span> ';
                            }
                            else
                            {
                                return '<p style  = "color: red"> NO UPLOADED CONTRACT</p>';
                            }


                        },
                        searchable : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-contract-status_filter input').unbind();
        $('#human-resources-contract-status_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableContractStat.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableContractStat.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    function yellowOption(row, diff)
    {
        $('.due_contract_60').click(function()
        {
            if(diff <= 60 && diff >= 30)
            {
                $('td', row).show();
                $('td', row).css('background-color', '#F5FA5D');
            }
            else
            {
                $('td', row).hide();
            }
        });
    }
    function redOption(row, diff)
    {
        $('.due_contract_30').click(function()
        {
            if(diff <= 30)
            {
                $('td', row).show();
                $('td', row).css('background-color', '#FEA4A4s');
            }
            else
            {
                $('td', row).hide();
            }
        });
    }
    function allOption(row, diff)
    {
        $('.due_contract_all').click(function()
        {
            if(diff <= 30 ) {
                $('td', row).show();
                $('td', row).css('background-color', '#FEA4A4s');
            }
            else if(diff <= 60 )
            {
                $('td', row).show();
                $('td', row).css('background-color', '#F5FA5D');
            }
            else
            {
                $('td', row).show();
            }

        });
    }
    $('#cancelDocUp').click(function()
    {
        $('#doc_upload_file').val('');
    });
    function generalForms()
    {
        $('#human-resources-file-format thead th').each(function () {
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tableGeneralForms = $('#human-resources-file-format').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-file-format-table",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'file_title', name: 'file_title'},
                    {data: 'file_desc', name: 'file_desc'},
                    {
                        data: function action(data)
                        {
                            return '<span><button class="btn btn-xs btn-success" id="btnDownloadFormat" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-download"></i>Download</button></span>' +
                                '<span id = "downForm"></span> ';

                        },
                        name :  'file_desc',
                        searchable : false
                    }
                ],
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();

                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-file-format_filter input').unbind();
        $('#human-resources-file-format_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    tableGeneralForms.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        tableGeneralForms.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#docuLoad').click(function()
    {
        $.ajax
        ({
            type: 'get',
            url : 'admin-staff-auth-view',
            success : function(data)
            {
                if(data[0].authrequest == 'Senior')
                {
                    var test = ' <div class = "col-md-4">\n' +
                        '                            <div class = "box box-danger">\n' +
                        '                                <center>\n' +
                        '                                    <h4 style = "font-family: Georgia,serif;">File Uploading</h4>\n' +
                        '                                </center>\n' +
                        '                                <div class = "row" style = "padding-top : 20px;">\n' +
                        '                                    <div class = "col-md-8">\n' +
                        '                                        <label for="">Document Title: <small style = "color: red;">*required field</small></label>\n' +
                        '                                        <input type="text" id = "doc_upload_title" class = "form-control">\n' +
                        '                                    </div>\n' +
                        '                                    <div class = "col-md-4"></div>\n' +
                        '                                </div>\n' +
                        '                                <div class = "row" style = "padding-top : 10px;">\n' +
                        '                                    <div class = "col-md-12">\n' +
                        '                                        <label for="">Description: <small style = "color: orange;">*optional</small></label>\n' +
                        '                                        <textarea id="doc_upload_desc" rows="5" class = "form-control"></textarea>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                <div class = "row" style = "padding-top : 10px; padding-bottom : 10px;">\n' +
                        '                                    <div class = "col-md-12" style = "padding-top: 10px;">\n' +
                        '                                        <label for="">File/s to be uploaded: <small style = "color: red;">*required field</small> </label>' +
                        '                                        <div class = "row" id = "addFilesHr"></div><div class "row" style = "padding-top : 15px;">' +
                        '                                           <div class = "col-md-5">' +
                        '                                           </div>' +
                        '                                           <div class = "col-md-2"><button class = "btn btn-block btn-primary btn-xs btn_general_add_file"><i class = "glyphicon glyphicon-plus"></i></button></div>' +
                        '                                           <div class = "col-md-5"></div>' +
                        '                                        </div> ' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                                   <div class = "row" style = "padding-top : 20px;">\n' +
                        '                                                <div class = "col-md-12">\n' +
                        '                                                    <span id="ulPercentage_hr_files" hidden>--</span>\n' +
                        '                                                    <div id="progressbar_hr_files" hidden></div>\n' +
                        '                                                </div>\n' +
                        '                                            </div>' +
                        '                                <div class = "" style = "margin-top : 20px;">\n' +
                        '                                    <button type = "button" id ="submitUpFile" class = "btn btn-success pull-right">Upload Document</button>\n' +
                        '                                </div>\n' +
                        '                            </div>\n' +
                        '                        </div>';
                    $('#changeFormSize').attr('class', 'col-md-8');
                    $('#formUpload').html(test);
                    $('#editSizeModal').css('width', '70%');

                    $('.btn_general_add_file').click(function()
                    {
                        countHrFiles++;

                        var b = '                           <div class ="row" style = "padding-top : 25px;">' +
                            '                               <div class ="col-md-12">' +
                            '                                  <h5 style = "text-align: center"><b>File '+countHrFiles+'</b></h5>' +
                            '                               </div>' +
                            '                               <div class = "row" style = "padding-top : 25px;">' +
                            '                                   <div class = "col-md-3"></div>' +
                            '                                   <div class = "col-md-6"><input type="file" class = "hrFilesTobeUploadedBulk"></div>' +
                            '                                   <div class = "col-md-3"></div></div>' +
                            '                               </div>';

                        $('#addFilesHr').append(b);

                    });

                    $('#submitUpFile').click(function()
                    {
                        var btn = $(this);
                        btn.attr('disabled', true);

                        var countFiles = 0;
                        var docTitle = $('#doc_upload_title').val();
                        var docDesc = $('#doc_upload_desc').val();

                        var formData = new FormData();

                        if(docTitle != '')
                        {
                            $('.hrFilesTobeUploadedBulk').each(function()
                            {
                                if($(this).val() != '')
                                {
                                    formData.append('file-'+countFiles+'', $(this).prop('files')[0]);

                                    countFiles++;
                                }
                            });

                            formData.append('docTitle', docTitle);
                            formData.append('docDesc', docDesc);
                            formData.append('countFiles', countFiles);

                            if(countFiles > 0)
                            {
                                $.ajax
                                ({
                                    xhr: function()
                                    {
                                        var xhr = new window.XMLHttpRequest();
                                        //Upload progress
                                        xhr.upload.addEventListener("progress", function(evt)
                                        {
                                            if (evt.lengthComputable) {
                                                var percentComplete = evt.loaded / evt.total;
                                                //Do something with upload progress
                                                $('#ulPercentage_hr_files').html('');
                                                $('#ulPercentage_hr_files').show();
                                                // $('#ulPercentage').append(percentComplete*100);
                                                $('#ulPercentage_hr_files').append(Math.floor(percentComplete*100));
                                                $('#progressbar_hr_files').show();
                                                $('#progressbar_hr_files').progressbar
                                                (
                                                    {
                                                        value: percentComplete * 100
                                                    }
                                                )
                                            }
                                        }, false);
                                        //Download progress
                                        xhr.addEventListener("progress", function(evt)
                                            {
                                                if (evt.lengthComputable) {
                                                    var percentComplete = evt.loaded / evt.total;
                                                    //Do something with download progress
                                                    console.log(percentComplete);
                                                }
                                            },
                                            false
                                        );
                                        return xhr;
                                    },
                                    type : 'post',
                                    url : 'human-resources-upload-form-format',
                                    contentType: false,
                                    processData: false,
                                    async : true,
                                    data : formData,
                                    success : function()
                                    {
                                        $('#doc_upload_title').val('');
                                        $('#doc_upload_desc').val('');
                                    },
                                    complete : function()
                                    {
                                        btn.attr('disabled', false);
                                        $('#addFilesHr').html('');
                                        countFiles = 0;
                                        tableGeneralForms.ajax.reload(null, false);
                                        alert('Successfully Uploaded!');
                                        $('#ulPercentage_hr_files').hide();
                                        $('#progressbar_hr_files').hide();
                                    }
                                });
                            }
                            else
                            {
                                alert('Please select atleast 1 file!');
                            }
                        }
                        else
                        {
                            alert('Please select document title.');
                        }
                    });
                }
            }
        });
        generalForms();
    });
    $('#human-resources-file-format').on('click', '#btnDownloadFormat', function()
    {
        var docId = $(this).val();
        var id_encode = btoa(docId);
        var q = '<form action="/human-resources-format-doc-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_pos_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downForm').html(q);
        $('#button_pos_download').click();
        $('#downForm').hide();
    });
    $('#human-resources-contract-status').on('click', '#btnDownloadContract', function()
    {
        var conID = $(this).val();
        var id_encode = btoa(conID);
        var q = '<form action="/human-resources-contract-emp-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_pos_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downContract').html(q);
        $('#button_pos_download').click();
        $('#downContract').hide();
    });
    $('#human-resources-motor-list').on('click', '#btnDlMotor', function()
    {
        var conID = $(this).val();
        var id_encode = btoa(conID);
        var q = '<form action="/human-resources-motor-download" target="_blank" method="get">'+
            '<div class="input-group">'+
            '<input type="text" hidden value="'+id_encode+'" name="id">'+
            '<button type="submit" hidden id="button_pos_download" >'+
            '</button>'+
            '</span>'+
            '</div>'+
            '</form>';

        $('#downMotor').html(q);
        $('#button_pos_download').click();
        $('#downMotor').hide();
    });
    function pendingEmp()
    {
        $('#human-resources-pending-employees thead th').each(function ()
        {
            tablePending[poiyu1] = $(this).text();
            poiyu1++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });
        tablePendingEmployees = $('#human-resources-pending-employees').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tablePending[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-employee-pending",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'birth', name: 'users_profile.emp_date_birth'},
                    {data: 'gender', name: 'users_profile.emp_gender'},
                    {data: 'marital', name: 'users_profile.emp_marital_status'},
                    {data: 'con_status', name: 'users_profile.emp_status'},
                    {data: 'emp_status', name: 'users_profile.emp_process_status'},
                    {data: 'hired', name: 'users_profile.emp_date_hired'},
                    {data: 'end' , name: 'users_profile.emp_end_date'},
                    {
                        data: function action(data)
                        {

                            var b;
                            var c;


                            if(data.tag  == 'Incomplete')
                            {
                                c = '<span><button class="btnViewIncomRem btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-eye"></i> View Incomplete Remarks</button></span><br>';
                            }
                            else
                            {
                                c = '';
                            }


                            if(data.approval == 'R-Approved')
                            {
                                b = '<span><button class="btnApprove btn btn-block btn-md btn-success" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-check-circle"></i> Approve</button></span><br>' +
                                    '<span><button class="btnDecline btn btn-md btn-block btn-danger" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-times-circle"></i> Decline</button></span>';
                            }

                            return  '<span><button class="btnViewEmpInfo btn-block  btn btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>'+ c + b;

                        },
                        "name": 'users_profile.emp_end_date',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 100,
            "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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
        $('#human-resources-pending-employees_filter input').unbind();
        $('#human-resources-pending-employees_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tablePendingEmployees.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tablePendingEmployees.search($(this).val()).draw();
                    }
                }
            }
        });
    }
    $('#human-resources-pending-employees').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }
                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });
            }
        });
    });

    $('#human-resources-pending-employees').on('click', '.btnApprove', function()
    {
        var id = $(this).val();
        if(confirm('Are you sure to approve the employee? \nNote: Please check the Requirements Checklist of the Employee'))
        {
            $.ajax
            ({
                type : 'get',
                url : 'human-resources-approve-emp',
                data :
                    {
                        'id' : id
                    },
                success : function()
                {
                    alert('Employee Approved!');
                    tablePendingEmployees.ajax.reload(null, false);
                    approveCounter = true;
                    tableProfLogs.ajax.reload(null, false);
                }
            });
        }
        else
        {

        }
    });
    $('#human-resources-pending-employees').on('click', '.btnPartial', function()
    {
        $('#modal-partial-update').modal('show');
        partialID = $(this).val();
    });


    $('#human-resources-pending-employees').on('click', '.btnDecline', function()
    {
        var id = $(this).val();

        var btn = $(this);
        btn.attr('disabled', true);

        var remarks = prompt("Are you sure to decline? \nThe application will be re-evaluated by HR associates \n \n Remarks:", "N/A");

        if(remarks == '' || remarks == null)
        {
            btn.attr('disabled', false);
        }
        else
        {
            $.ajax
            ({
                type : 'get',
                url : 'human-resources-deny-emp',
                data :
                    {
                        'id' : id,
                        'remarks' : remarks
                    },
                success : function()
                {
                    alert('Employee Returned for Re-evaluation!');
                    tablePendingEmployees.ajax.reload(null, false);
                    tableProfLogs.ajax.reload(null, false);
                    btn.attr('disabled', false);
                }
            });
        }



    });
    $('#human-resources-employee-list').on('click', '.btnPartialRemarks', function()
    {
        var idGetPartial = $(this).val();
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-get-partial',
            data :
                {
                    'id' : idGetPartial
                },
            success : function(data)
            {
                console.log(data);
                $('#modal-partial-show').modal('show');
                $('#show_partial').val(data)
            }
        })
    });
    $('#human-resources-present-employees').on('click', '.btnPartialRemarks', function()
    {
        var idGetPartial = $(this).val();
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-get-partial',
            data :
                {
                    'id' : idGetPartial
                },
            success : function(data)
            {
                console.log(data);
                $('#modal-partial-show').modal('show');
                $('#show_partial').val(data)
            }
        })
    });

    $('#btnPartialUpdate').click(function()
    {
        var partialRem = $('#emp_partial').val();
        var btn = $(this);

        btn.attr('disabled', true);
        if(partialRem != '')
        {
            if(confirm('Are you sure to partially approve?'))
            {
                $.ajax
                ({
                    type : 'get',
                    url : 'human-resources-partial-emp',
                    data :
                        {
                            'id' : partialID,
                            'partialRem' : partialRem
                        },
                    success : function()
                    {
                        alert('Employee is partially approved! \nNote: Complete requirements to be approved!');
                        tablePendingEmployees.ajax.reload(null, false);
                        partialCounter = true;
                        $('#modal-partial-update').modal('hide');
                        $('#emp_partial').val('');
                        btn.attr('disabled', false);
                        tableProfLogs.ajax.reload(null, false);
                    }

                });
            }
            else
            {
                btn.attr('disabled', false);
            }
        }
        else
        {
            alert('Please input partial remarks.');
            btn.attr('disabled', false);
        }
    });

    function pendEmp()
    {
        $('#human-resources-pending-employees_rec thead th').each(function ()
        {
            tablePendingRec[poiyu2] = $(this).text();
            poiyu2++;
            title = $(this).text();
            $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        tablePendingRecEmployees = $('#human-resources-pending-employees_rec').DataTable
        ({
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'excel',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx )
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '25');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title : 'Pending Employees',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return tablePending[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return tablePending[(idx)];
                        }
                    },
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/human-resources-employee-pending-rec",
            "columns":
                [
                    {data: 'id', name: 'users_profile.id'},
                    {data: 'name', name: 'users_profile.emp_full_name'},
                    {data: 'position', name: 'users_profile.emp_position'},
                    {data: 'branch', name: 'branch_list.branch_name'},
                    {data: 'birth', name: 'users_profile.emp_date_birth'},
                    {data: 'gender', name: 'users_profile.emp_gender'},
                    {data: 'marital', name: 'users_profile.emp_marital_status'},
                    {data: 'con_status', name: 'users_profile.emp_status'},
                    {data: 'emp_status', name: 'users_profile.emp_process_status'},
                    {data: 'hired', name: 'users_profile.emp_date_hired'},
                    {data: 'end' , name: 'users_profile.emp_end_date'},
                    {
                        data: function action(data)
                        {
                            if(data.tag == 'Incomplete')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<span><button class="btn btn-md bg-olive-active btn-block" name="" value="' + data.id + '" style="width: 100%" disabled><i class = "fa fa-fw fa-send"></i> Requested</button></span><br>' +
                                    '<span><button class="btnViewIncomRem btn btn-md btn-danger btn-block" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-fw fa-commenting-o"></i> View Incomplete Remarks</button></span><br>';
                            }
                            else if(data.approval == 'Returned')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<span><button class="btn btn-md bg-olive-active btn-block" name="" value="' + data.id + '" style="width: 100%" disabled><i class = "fa fa-fw fa-send"></i> Requested</button></span><br>' +
                                    '<span><button class="btnViewReturn btn btn-md btn-danger btn-block" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-fw fa-commenting-o"></i> View Return Remarks</button></span><br>';
                            }
                            else
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<span><button class="btn btn-md btn-success bg-olive-active" name="" value="' + data.id + '" style="width: 100%" disabled><i class = "fa fa-fw fa-send"></i> Requested</button></span><br>';
                            }


                        },
                        "name": 'users_profile.emp_end_date',
                        "searchable" : false
                    }
                ],
            "order": [[0, 'desc']],
            "fnRowCallback": function(nRow, aData)
            {
                if(aData.tag == 'Incomplete')
                {
                    $(nRow).css('background-color', '#ffcc80');
                }
                else if(aData.approval == 'Returned')
                {
                    $(nRow).css('background-color', '#ffb3b3');
                }
            },
            "pageLength": 100,
            "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function () {
                var api = this.api();
                // Apply the search
                api.columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function (e) {
                        if ($(this).is(':focus')) {
                            if (e.keyCode === 13) {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8) {
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

        $('#human-resources-pending-employees_rec_filter input').unbind();
        $('#human-resources-pending-employees_rec_filter input').bind('keyup change', function (e)
        {
            if ($(this).is(':focus'))
            {
                if (e.keyCode == 13)
                {
                    tablePendingRecEmployees.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '')
                    {
                        tablePendingRecEmployees.search($(this).val()).draw();
                    }
                }
            }
        });
    }

    $('#human-resources-pending-employees_rec').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }
                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });
            }
        });
    });

    $('#btndl201Excel').click(function()
    {
        if(confirm('Are you sure to generate and download?' ))
        {
            var q = '<form action="/human-resources-employee-excel-dl" target="_blank" method="get">'+
                '<div class="input-group">'+
                '<input type="text" hidden name="">'+
                '<button type="submit" hidden id="button_ex_download">'+
                '</button>'+
                '</span>'+
                '</div>'+
                '</form>';
            $('#downExcel').html(q);
            $('#button_ex_download').click();
            $('#downExcel').hide();
        }
        else
        {

        }

    });

    $('#human-resources-pending-employees_rey').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();
        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                 if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }
                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });
            }
        });
    });

    $('#human-resources-pending-employees_rey').on('click', '.btnApprove', function()
    {
        var id = $(this).val();

        if(confirm('Are you sure to approve the employee? \nNote: Please check the Requirements Checklist of the Employee'))
        {
            $.ajax
            ({
                type : 'get',
                url : 'human-resources-pre-approve-prof',
                data :
                    {
                        'id': id
                    },
                success : function()
                {
                    alert('Employee now ready to be approved by Mam Den!');
                    tablePendingRecEmployeesRey.ajax.reload(null, false);
                    approveCounter = true;
                    tableProfLogs.ajax.reload(null, false);
                    submitRequested = true;
                }
            })
        }
    });

    $('#human-resources-pending-employees_rey').on('click', '.btnDeny', function()
    {
        var id = $(this).val();
        var btn = $(this);
        btn.attr('disabled', true);

        emp_remarks = prompt("Are you sure to reject the application \nNote: Doing this means the person will no longer be connected to CCSI. \n\nRemarks:",'N/A');

        if (emp_remarks == null || emp_remarks == "")
        {
            btn.attr('disabled', false);
        }
        else
        {
            $.ajax
            ({
                type : 'get',
                url : 'human-resources-deny-emp-rey',
                data :
                    {
                        'id' : id,
                        'emp_remarks' : emp_remarks
                    },
                success : function()
                {
                    alert('Employee Denied!');
                    btn.attr('disabled', false);
                    tablePendingRecEmployeesRey.ajax.reload(null, false);
                    tableProfLogs.ajax.reload(null, false);
                    submitRequested = true
                }
            });
        }
    });

    $('#human-resources-overall-monitoring').on('click', '.btnViewEmpInfo', function()
    {
        empIDshow = $(this).val();
        countExp += 1 ;
        showExtraEmp();


        $.ajax
        ({
            type: 'get',
            url: 'human_resources_show_profile',
            data:
                {
                    'empIDshow' : empIDshow
                },
            success: function(data)
            {
                console.log(data);
                $('#modal-emp-profile-view').modal('show');
                 if(data[0][0].position == 'FV Supervisor' || data[0][0].position == 'FV Level I' || data[0][0].position == 'FV Level II' || data[0][0].position == 'School Verifier'  || data[0][0].position == 'FV PER ACCOUNT' )
                {
                    $('#ciMotorReqView').show();
                    $('#officeChecklistView').hide();
                    $('#ciChecklistView').show();
                    $('#ciShow').show();
                }
                else
                {
                    $('#ciMotorReqView').hide();
                    $('#officeChecklistView').show();
                    $('#ciChecklistView').hide();
                    $('#ciShow').hide();
                }
                var out;

                if(data[0][0].outgoing == "")
                {
                    out = "N/A";
                }
                else
                {
                    out = data[0][0].outgoing;
                }

                function date_diff_indays(date1, date2) {
                    var dt1 = new Date(date1);
                    var dt2 = new Date(date2);
                    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                }
                var now = new Date();
                var contactdiff = date_diff_indays(data[0][0].hired , data[0][0].end);
                var test1 = date_diff_indays(data[0][0].hired , now);
                var diff = contactdiff - test1 ;
                var showDiff;
                if(diff <= -1)
                {
                    showDiff = 'CONTRACT EXPIRED'
                } else {
                    showDiff = diff + ' days'
                }
                var pic;
                if(data[0][0].profile_pic == '')
                {
                    pic = 'user_profile_pictures/default3.jpg';
                }
                else
                {
                    pic = data[0][0].profile_pic;
                }

                var allowance;
                if(data[0][0].allowance == '')
                {
                    allowance = 'None';
                }
                else
                {
                    allowance = data[0][0].allowance
                }

                var monIn;
                if(data[6][0].emp_in == '00:00:00'){
                    monIn = null;
                } else {
                    monIn = data[6][0].emp_in;
                }
                var monOut;
                if(data[6][0].emp_out == '00:00:00'){
                    monOut = null;
                } else {
                    monOut = data[6][0].emp_out;
                }
                var tuesIn;
                if(data[7][0].emp_in == '00:00:00'){
                    tuesIn = null;
                } else {
                    tuesIn = data[7][0].emp_in;
                }
                var tuesOut;
                if(data[7][0].emp_out == '00:00:00'){
                    tuesOut = null;
                } else {
                    tuesOut = data[7][0].emp_out
                }
                var wedIn;
                if(data[8][0].emp_in == '00:00:00'){
                    wedIn = null;
                } else {
                    wedIn = data[8][0].emp_in ;
                }
                var wedOut;
                if(data[8][0].emp_out == '00:00:00'){
                    wedOut = null;
                } else {
                    wedOut = data[8][0].emp_out;
                }
                var thursIn;
                if(data[9][0].emp_in == '00:00:00'){
                    thursIn = null;
                } else {
                    thursIn = data[9][0].emp_in;
                }
                var thursOut;
                if(data[9][0].emp_out == '00:00:00'){
                    thursOut = null;
                } else {
                    thursOut = data[9][0].emp_out;
                }
                var friIn;
                if(data[10][0].emp_in == '00:00:00'){
                    friIn = null;
                } else {
                    friIn = data[10][0].emp_in;
                }
                var friOut;
                if(data[10][0].emp_out == '00:00:00'){
                    friOut = null;
                } else {
                    friOut = data[10][0].emp_out;
                }
                var satIn;
                if(data[11][0].emp_in == '00:00:00'){
                    satIn = null;
                } else {
                    satIn = data[11][0].emp_in;
                }
                var satOut;
                if(data[11][0].emp_out == '00:00:00'){
                    satOut = null;
                } else {
                    satOut = data[11][0].emp_out;
                }
                var sunIn;
                if(data[12][0].emp_in == '00:00:00'){
                    sunIn = null;
                } else {
                    sunIn = data[12][0].emp_in;
                }
                var sunOut;
                if(data[12][0].emp_out == '00:00:00'){
                    sunOut = null;
                } else {
                    sunOut = data[12][0].emp_out;
                }

                $('#nameStorage').html('<h1 style = "text-align: center;font-family: Georgia,serif;">'+data[0][0].name+'</h1>');
                $('#positionStorage').html('<h4 style = "text-align: center;font-family: Georgia,serif; ">'+data[0][0].position+' | '+data[0][0].gender+' | Date Hired: '+data[0][0].hired+' </h4>');
                $('#emp_show_pic_me').attr('src',  pic);
                $('#emp_show_salary').val( '₱ ' + data[0][0].salary);
                $('#emp_show_age').val(data[0][0].age);
                $('#emp_show_religion').val(data[0][0].religion);
                $('#emp_show_date_birth').val(data[0][0].date_birth);
                $('#emp_show_branch').val(data[0][0].branch);
                $('#emp_show_marital_status').val(data[0][0].marital_status);
                $('#emp_show_dependents').val(data[0][0].dependents);
                $('#emp_show_permanent').val(data[1][0].emp_address);
                $('#emp_show_present').val(data[2][0].emp_address);
                $('#emp_show_mobile').val(data[3][0].emp_contact_info);
                $('#emp_show_email').val(data[4][0].emp_contact_info);
                $('#emp_show_ss').val(data[0][0].sss);
                $('#emp_show_philhealth').val(data[0][0].philhealth);
                $('#emp_show_pagibig').val(data[0][0].pagibig);
                $('#emp_show_tin').val(data[0][0].tin);
                $('#emp_show_area').val(data[0][0].muni);
                $('#emp_show_cc').val(data[0][0].type);
                $('#emp_show_con_stat').val(data[0][0].con_stat);
                $('#emp_show_emp_status').val(data[0][0].emp_stat);
                $('#emp_show_outgoing').val(out);
                $('#emp_show_rate').val(data[0][0].rate);
                $('#emp_show_days').val(data[0][0].days + ' days');
                $('#emp_show_remaining').val(showDiff);
                $('#emp_show_allowances').val('₱ ' + allowance);
                $('#emp_show_fixed').val(data[5][0].emp_fixed_sched);
                $('#view_in1').val(monIn);
                $('#view_out1').val(monOut);
                $('#view_in2').val(tuesIn);
                $('#view_out2').val(tuesOut);
                $('#view_in3').val(wedIn);
                $('#view_out3').val(wedOut);
                $('#view_in4').val(thursIn);
                $('#view_out4').val(thursOut);
                $('#view_in5').val(friIn);
                $('#view_out5').val(friOut);
                $('#view_in6').val(satIn);
                $('#view_out6').val(satOut);
                $('#view_in7').val(sunIn);
                $('#view_out7').val(sunOut);
                $('#view_sched_remarks').val(data[14][0].emp_sched_remarks);
                $('#emp_id_stat_view').html(data[0][0].id_card);
                $('#emp_id_no_view').html(data[0][0].id_no);
                $('#emp_uni_view').html(data[0][0].uni);
                $('#emp_bank_name_view').html(data[0][0].bank_name);
                $('#emp_health_card_view').html(data[0][0].health);
                $('#emp_accident_view').html(data[0][0].accident);
                $('#emp_phone_number_view').html(data[0][0].phone_no);
                $('#emp_unit_price_view').html('₱ ' + data[0][0].price);
                $('#emp_phone_desc_view').html(data[0][0].phone_desc);
                $('#emp_oims_view').html(data[0][0].oims);
                $('#emp_gmail_view').html(data[0][0].gmail);
                $('#emp_fb_view').html(data[0][0].fb);
                $('#emp_computer_view').html(data[0][0].com);
                $('#emp_gmail_password').html(data[0][0].pass);

                var i;
                var check;

                $('.view_checklist').prop('checked', false);

                $('.view_checklist').each(function()
                {
                    check = $(this).val();
                    for(i = 0; i < data[13][0].length; i++)
                    {
                        if(data[13][0][i].check_name == check)
                        {
                            $(this).prop('checked', true);
                        }
                    }
                });

            }
        });
    });



});

function ciNames()
{
    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-ci',
        success : function(data)
        {
            var h;
            var optionCiData ='';

            for(h = 0; h < data.length; h++)
            {
                optionCiData += '<option value = "'+data[h].id+'">'+data[h].name+'</option>'
            }
            $('#motor_ci_name').html('<option value = "">--</option>' + optionCiData);
        }
    })


}

function reyAccessProfiles()
{
    $('#human-resources-pending-employees_rey thead th').each(function ()
    {
        tablePendingRecRey[poiyu4] = $(this).text();
        poiyu4++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tablePendingRecEmployeesRey = $('#human-resources-pending-employees_rey').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'Pending Employees',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tablePending[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'Pending Employees',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tablePending[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx )
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '25');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'print',
                    title : 'Pending Employees',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tablePending[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return tablePending[(idx)];
                    }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/human-resources-employee-pending-rey",
        "columns":
            [
                {data: 'id', name: 'users_profile.id'},
                {data: 'name', name: 'users_profile.emp_full_name'},
                {data: 'position', name: 'users_profile.emp_position'},
                {data: 'branch', name: 'branch_list.branch_name'},
                {data: 'birth', name: 'users_profile.emp_date_birth'},
                {data: 'gender', name: 'users_profile.emp_gender'},
                {data: 'marital', name: 'users_profile.emp_marital_status'},
                {data: 'con_status', name: 'users_profile.emp_status'},
                {data: 'emp_status', name: 'users_profile.emp_process_status'},
                {data: 'hired', name: 'users_profile.emp_date_hired'},
                {data: 'end' , name: 'users_profile.emp_end_date'},
                {
                    data: function action(data)
                    {
                        if(data.tag != 'Incomplete')
                        {
                            if(data.approval == 'R-Approved')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<button class = "btn  btn-block btn-md bg-olive-active" style="width: 100%; " disabled >  <i class = "fa fa-fw fa-check-circle-o"></i> Profile to be reviewed by Head</button>'
                            }
                            else if(data.approval == 'Returned')
                            {
                                return '<span><button class="btnViewEmpInfo btn  btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<span><button class="btnRetunRem btn btn-block btn-md btn-primary" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-commenting"></i> View Return Remarks</button></span><br>' +
                                    '<span><button class="btnSubmitType btn btn-block btn-md btn-success" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-check-circle"></i> Submit</button></span><br>' +
                                    '<span><button class="btnIncom btn  btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-spinner"></i> Incomplete</button></span><br>' +
                                    '<span ><button class="btnDeny btn  btn-block btn-md btn-danger" name="" value="' + data.id + '" style="width: 100%; " ><i class = "fa fa-fw fa-times-circle"></i> Reject</button></span>';
                            }
                            else if(data.approval == 'Requested')
                            {
                                return '<span><button class="btnViewEmpInfo btn  btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile </button></span><br>' +
                                    '<span><button class="btnSubmitType btn btn-block btn-md btn-success" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-check-circle"></i> Submit</button></span><br>' +
                                    '<span><button class="btnIncom btn  btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-spinner"></i> Incomplete</button></span><br>' +
                                    '<span ><button class="btnDeny btn  btn-block btn-md btn-danger" name="" value="' + data.id + '" style="width: 100%; " ><i class = "fa fa-fw fa-times-circle"></i> Reject</button></span>';
                            }
                        }
                        else if(data.tag == 'Incomplete')
                        {
                            if(data.approval == 'R-Approved')
                            {
                                return '<span><button class="btnViewEmpInfo btn btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<button class = "btn  btn-block btn-md bg-olive-active" style="width: 100%; " disabled >  <i class = "fa fa-fw fa-check-circle-o"></i> Profile to be reviewed by Head</button>'
                            }
                            else if(data.approval == 'Requested')
                            {
                                return '<span><button class="btnViewEmpInfo btn  btn-block btn-md btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button></span><br>' +
                                    '<span><button class="btnViewIncom btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-commenting"></i> View Incomplete Remarks</button></span><br>' +
                                    '<span><button class="btnSubmitType btn btn-block btn-md btn-success" name="" value="' + data.id + '" style="width: 100%;" ><i class = "fa fa-fw fa-check-circle"></i> Submit</button></span><br>' +
                                    '<span ><button class="btnDeny btn  btn-block btn-md btn-danger" name="" value="' + data.id + '" style="width: 100%; " ><i class = "fa fa-fw fa-times-circle"></i> Reject</button></span>';
                            }
                        }

                    },
                    "name": 'users_profile.emp_end_date',
                    "searchable" : false
                }
            ],
        "order": [[0, 'desc']],
        "fnRowCallback": function(nRow, aData)
        {
            if(aData.approval == 'Returned')
            {
                $(nRow).css('background-color', '#ffb3b3');
                // $(nRow).css('color', 'white');
            }
            else if(aData.approval != 'R-Approved')
            {
                if(aData.tag == 'Incomplete')
                {
                    $(nRow).css('background-color', '#ffcc80');
                    // $(nRow).css('color', 'white');
                }
            }

        },
        "pageLength": 100,
        "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();
            // Apply the search
            api.columns().every(function () {
                var that = this;

                $('input', this.header()).on('keyup change', function (e) {
                    if ($(this).is(':focus')) {
                        if (e.keyCode === 13) {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8) {
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

    $('#human-resources-pending-employees_rey_filter input').unbind();
    $('#human-resources-pending-employees_rey_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tablePendingRecEmployeesRey.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '')
                {
                    tablePendingRecEmployeesRey.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#human-resources-pending-employees').on('click', '.brnRDeniedRem', function()
{
    var btn = $(this);

    var id = btn.val();

    $('#modal-denial-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-view-denial-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            $('#show_denial_remarks').val(data[0].deny_remarks);
        }
    });
});


$('#human-resources-pending-employees_rey').on('click', '.btnSubmitType', function()
{
    var id = $(this).val();

    $('#modal-submit-type-pre-approve').modal('show');

    $('.btnSubmittoHead').val(id);
});

$('.btnSubmittoHead').click(function()
{
    var id = $(this).val();
    var type = $(this).attr('name');
    var btn = $(this);

    btn.attr('disabled', true);

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-submit-to-head',
        data :
            {
                'id' : id,
                'type' : type
            },
        success : function()
        {
            alert('Successfully Submitted for Approval!');
            tablePendingRecEmployeesRey.ajax.reload(null, false);
            btn.attr('disabled', false);
            $('#modal-submit-type-pre-approve').modal('hide');
            submitRequested = true;
        }
    });

});

$('#human-resources-pending-employees_rey').on('click', '.btnIncom', function()
{
    var btn = $(this);
    var id = btn.val();

    btn.attr('disabled', true);

    var remarks = prompt("Are you sure to tag the application as incomplete? \n\nRemarks:",'N/A');

    if (remarks == null || remarks == "")
    {
        btn.attr('disabled', false);
    }
    else
    {
        $.ajax
        ({
            type : 'get',
            url : 'human-resources-tag-incomplete',
            data :
                {
                    'id' : id,
                    'remarks' : remarks
                },
            success : function()
            {
                alert('Application tagged as Incomplete!');
                tablePendingRecEmployeesRey.ajax.reload(null, false);
                btn.attr('disabled', false);
                $('#modal-submit-type-pre-approve').modal('hide');
                submitRequested = true;
            }
        });
    }
});

$('#human-resources-pending-employees_rec').on('click', '.btnViewIncomRem', function()
{
    var id = $(this).val();
    $('#show_incom_remarks').val('');

    $('#modal-incomplete-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-incomplete-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_incom_remarks').val(data[0].incomplete_remarks);
        }
    })
});

$('#human-resources-pending-employees').on('click', '.btnViewIncomRem', function()
{
    var id =  $(this).val();

    $('#show_incom_remarks').val('');

    $('#modal-incomplete-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-incomplete-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_incom_remarks').val(data[0].incomplete_remarks);
        }
    })
});

$('#human-resources-pending-employees_rey').on('click', '.btnRetunRem', function()
{
    var id =  $(this).val();

    $('#show_return_remarks').val('');

    $('#modal-return-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-return-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_return_remarks').val(data[0].return_remarks);
        }
    });
});

$('#human-resources-pending-employees_rec').on('click', '.btnViewReturn', function()
{
    var id =  $(this).val();

    $('#show_return_remarks').val('');

    $('#modal-return-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-return-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_return_remarks').val(data[0].return_remarks);
        }
    });
});



function overallEmp()
{
    $('#human-resources-overall-monitoring thead th').each(function ()
    {
        tableOverallMon[poiyu5] = $(this).text();
        poiyu5++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableOverallMonitoring = $('#human-resources-overall-monitoring').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title : 'General Monitoring',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableOverallMon[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title : 'General Monitoring',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableOverallMon[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx )
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '25');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'print',
                    title : 'General Monitoring',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header: function (dt, idx) {
                                        return tableOverallMon[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx) {
                        return tableOverallMon[(idx)];
                    }
                },
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/human-resources-overall-monitoring",
        "columns":
            [
                {data: 'id', name: 'users_profile.id'},
                {data: 'name', name: 'users_profile.emp_full_name'},
                {data: 'position', name: 'users_profile.emp_position'},
                {data: 'branch', name: 'branch_list.branch_name'},
                {data: 'birth', name: 'users_profile.emp_date_birth'},
                {data: 'gender', name: 'users_profile.emp_gender'},
                {data: 'marital', name: 'users_profile.emp_marital_status'},
                {data: 'con_status', name: 'users_profile.emp_status'},
                {data: 'emp_status', name: 'users_profile.emp_process_status'},
                {data: 'hired', name: 'users_profile.emp_date_hired'},
                {data: 'end' , name: 'users_profile.emp_end_date'},
                {
                    data: function action(data)
                    {
                        console.log(data.approval);

                        var a = '';

                            if(data.approval == 'R-Approved')
                            {
                                if(data.tag == 'Incomplete')
                                {
                                    a =  '<button class="btn btn-block btn-primary" disabled> <i class="fa fa-fw fa-check-circle-o"></i> For Final Approval(With Incomplete Requirements)</button>' +
                                        '<button class="btnViewIncomRem btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-eye"></i> View Incomplete Remarks</button>';
                                }
                                else
                                {
                                    a =  '<button class="btn btn-block btn-primary" disabled> <i class="fa fa-fw fa-check-circle-o"></i> For Final Approval</button>';
                                }
                            }
                            else if(data.approval == 'Approved')
                            {
                                a =  '<button class="btn btn-block btn-success" disabled> <i class="fa fa-fw fa-check-circle"></i> Approved</button>';
                            }
                            else if(data.approval == 'Returned')
                            {
                                a =  '<button class="btn btn-block bg-red-gradient" disabled> <i class="fa fa-fw fa-reply"></i> Returned to Associates</button>' +
                                    '<button class="btnViewReturn btn btn-md btn-danger btn-block" name="" value="' + data.id + '" style="width: 100%"><i class = "fa fa-fw fa-commenting-o"></i> View Return Remarks</button>';
                            }
                            else if(data.approval == 'Requested')
                            {
                                if(data.tag ==  'Incomplete')
                                {
                                    a =  '<button class="btn btn-block bg-olive-active" disabled> <i class="fa fa-fw fa-send"></i> Requested(Tagged as Incomplete)</button>' +
                                        '<button class="btnViewIncomRem btn btn-block btn-md btn-warning" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-eye"></i> View Incomplete Remarks</button>';
                                }
                                else
                                {
                                    a =  '<button class="btn btn-block btn-md bg-olive-active" disabled> <i class="fa fa-fw fa-send"></i> Requested</button>';
                                }
                        }


                        return '<button class="btnViewEmpInfo btn btn-block btn-info" name="" value="' + data.id + '" style="width: 100%" ><i class = "fa fa-fw fa-info"></i> View Profile</button>' + a;

                    },
                    "name": 'users_profile.id',
                    "searchable" : false
                }
            ],
        "order": [[0, 'DESC']],
        "pageLength": 100,
        "lengthMenu": [[100, -1], ['100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();
            // Apply the search
            api.columns().every(function () {
                var that = this;

                $('input', this.header()).on('keyup change', function (e) {
                    if ($(this).is(':focus')) {
                        if (e.keyCode === 13) {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8) {
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

    $('#human-resources-overall-monitoring_filter input').unbind();
    $('#human-resources-overall-monitoring_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableOverallMonitoring.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '')
                {
                    tableOverallMonitoring.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#human-resources-overall-monitoring').on('click', '.btnViewIncomRem', function()
{
    var id = $(this).val();
    $('#show_incom_remarks').val('');

    $('#modal-incomplete-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-incomplete-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_incom_remarks').val(data[0].incomplete_remarks);
        }
    })
});

$('#human-resources-overall-monitoring').on('click', '.btnViewReturn', function()
{
    var id =  $(this).val();

    $('#show_return_remarks').val('');

    $('#modal-return-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-return-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_return_remarks').val(data[0].return_remarks);
        }
    });
});

$('#human-resources-overall-monitoring').on('click', '.btnViewReject', function()
{
    var id =  $(this).val();

    $('#show_reject_remarks').val('');

    $('#modal-reject-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-reject-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_reject_remarks').val(data[0].deny_remarks);
        }
    });
});


$('#human-resources-pending-employees_rey').on('click', '.btnViewIncom', function()
{
    var id = $(this).val();
    $('#show_incom_remarks').val('');

    $('#modal-incomplete-remarks').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'human-resources-get-incomplete-remarks',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#show_incom_remarks').val(data[0].incomplete_remarks);
        }
    })
});

$('#human-resources-show-promotion').on('click', '.btnGetPromRem', function()
{
    var id = $(this).attr('name');

    $('#show_promotion_remarks').val('');

    $.ajax
    ({
        type : 'get',
        url  : 'human-resources-get-prom-rem',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            $('#modal-promotion-remarks').modal('show');

            $('#show_promotion_remarks').val(data[0].pos_remarks);

        }
    })
});

$('#generate_attendance_click').click(function()
{
    if($('#all_employee_tab').hasClass('active')) {
        if($('#date_to_generate').val() != '')
        {
            if(confirm('Are you sure to generate the employee\'s attendance?'))
            {
                window.open('human-resources-generate-employee-attendance?added_date=' + $('#date_to_generate').val());
            }
        }
        else
        {
            alert('Specify the date to generate');
        }
    }
    else if($('#specific_employee_tab').hasClass('active'))
    {
        if($('#specific_date_generate').val() != '' && $('#from_date_picker').val() != '' && $('#to_date_picker').val() != '')
        {
            if(confirm('Are you sure to generate the employee\'s attendance?'))
            {
                window.open('get_user_attendance?id=' + $('#specific_date_generate').val() + '&' +'from='+ $('#from_date_picker').val() + '&' + 'to=' + $('#to_date_picker').val());
            }
        }
        else
        {
            alert('Fill out the the required fields');
        }

    }

});

$('#date_to_generate').change(function()
{
    console.log($(this).val());
});
$('#from_date_picker').change(function()
{
    console.log($(this).val());
});
$('#to_date_picker').change(function()
{
    console.log($(this).val());
});$('#specific_date_generate').change(function()
{
    console.log($(this).val());
});



var originPageIssuance = 'sent';
var utilityOnCompose = false;

$('.btnUtilityIssuance').click(function()
{

    var name = $(this).attr('name');

    if(utilityOnCompose == false)
    {
        $(this).html('Back to Monitoring');


        $('#showSentIssuance').hide();
        $('#showComposeIssuance').show();
        $('#whatIsActiveIssuance').html('Compose');

        utilityOnCompose = true;
    }
    else
    {

        $(this).html('Compose');

        $('#whatIsActiveIssuance').html('Sent');
        $('#showSentIssuance').show();

        utilityOnCompose = false;


        $('#showComposeIssuance').hide();

    }
});

funcIssuanceSent();

$('.issuance_left_class').click(function()
{
    var geth = $(this).attr('href');

    $('.btnUtilityIssuance').html('Compose');

    if(geth == '#sent_issuance_tab')
    {
        $('#whatIsActiveIssuance').html('Sent');
        $('#showSentIssuance').show();
        $('#showComposeIssuance').hide();


        $('.btnUtilityIssuance').attr('name', 'sent')
    }

    utilityOnCompose = false
});


$('#btnAddAttachmentsIssuance').click(function()
{
    $('#fillUpAdditionalFilesIssuance').append
    (
        '<div class="col-md-3" style="padding-bottom : 15px;">' +
        '<label>Attachment: <button class="btn btn-xs btn-danger btnDeleteAttachIssuanceFile"><i class="fa fa-close"></i></button></label>' +
        '<input type="file" class="filesToSendIssuance">' +
        '</div>'
    );

    $('.btnDeleteAttachIssuanceFile').click(function()
    {
        $(this).closest('div').remove();
    });
});

var tableSentIssuance;

function funcIssuanceSent()
{
    tableSentIssuance = $('#table_sent_issuance_mail').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": 'human_resources_sent_monit_issuance',
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

                },
                {
                    data : function action(data)
                    {
                        return '<button class="btn bg-navy btn-xs btn-block btnViewInfoIssuance" name="'+btoa(data.id)+'"><i class="fa fa-eye"></i>View Issuance</button>'
                    },
                    name : 'hr_issuance_main.id',
                    'orderable' : false,
                    'searchable' : false
                }

            ],
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

    $('#table_sent_issuance_mail_filter input').unbind();
    $('#table_sent_issuance_mail_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableSentIssuance.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableSentIssuance.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table_sent_issuance_mail').on('click', '.btnViewInfoIssuance', function()
{
    var id = $(this).attr('name');

    $.ajax
    ({
        type : 'get',
        url : 'human_resources_get_info_iss',
        data :
            {
                'id' : id
            },
        beforeSend : function()
        {
            $('#subjStorage').html('');
            $('#messageVIew').html('');
            $('#loopFilesIssuance').html('');
        },
        success : function(data)
        {
            $('#subjStorage').html(data[0][0].issuance_subject);
            $('#messageVIew').html(data[0][0].issuance_content);

            if(data[1].length > 0)
            {
                for(var t = 0; t < data[1].length; t++)
                {
                    $('#loopFilesIssuance').append
                    (
                        '                                        <li>\n' +
                        '                                            <span class="mailbox-attachment-icon"><i class="fa fa-fw fa-file"></i></span>\n' +
                        '\n' +
                        '                                            <div class="mailbox-attachment-info" style="">\n' +
                        '                                                <a class="mailbox-attachment-name" href="/getHrIssuanceFiles/'+id+'/'+btoa(data[1][t].id)+'" target="_blank" > '+data[1][t].file_name+'</a>\n' +
                        '                                            </div>\n' +
                        '                                        </li>'
                    )
                }
            }
        },
        complete : function()
        {
            $('#modal-show-issuance-info').modal('show');
        },
        error : function()
        {
            alert('An error has occured. Please contact the developers.')
        }

    });





});


var lamanTrashSent = [];

$('#table_sent_issuance_mail tbody').on('click', 'tr', function ()
{
    var target1 = $(event.target);

    if($(this).hasClass('selected'))
    {
        if (target1.is('button'))
        {
            console.log('nope')
        }
        else
        {
            $(this).removeClass('selected');
               lamanTrashSent = $.map(tableSentIssuance.rows('.selected').data(),function (item) {
                return item.id
            });

            if(lamanTrashSent.length > 0)
            {
                $('#sentTrashbtn').css('border-color', 'red')
            }
            else
            {
                $('#sentTrashbtn').removeAttr('style');
            }
        }
    }
    else
    {
        if (target1.is('button'))
        {
            console.log('away')
        }
        else
        {
            $(this).addClass('selected');

            lamanTrashSent = $.map(tableSentIssuance.rows('.selected').data(),function (item) {
                return item.id
            });

            if(lamanTrashSent.length > 0)
            {
                $('#sentTrashbtn').css('border-color', 'red')
            }
            else
            {
                $('#sentTrashbtn').removeAttr('style');
            }
        }
    }
});

$('#refreshSentIssuanceTable').click(function()
{
    tableSentIssuance.ajax.reload(null, false);
});

$('#sentTrashbtn').click(function()
{
    if(lamanTrashSent.length > 0)
    {
        if(confirm('Are you sure to delete selected record?'))
        {
            $.ajax
            ({
                type : 'get',
                url : 'human_resources_delete_sent_issuance',
                data :
                    {
                        'list_id' : lamanTrashSent
                    },
                success : function()
                {
                    $('#sentTrashbtn').removeAttr('style');
                    tableSentIssuance.ajax.reload(null, false);

                },
                error : function()
                {
                    alert('Something went wrong.')
                }

            });
        }
        else
        {

        }
    }
    else
    {
        alert('Please select a record to continue.');
    }
});

$('#submitIssuance').click(function() {
    var btn = $(this);
    var receiver = $('#selectWhereSendEmpIssuance').find(':selected').val();
    var subj = $('#subjIssuance').val();
    var content = $('#IssuanceMessageToPass').val();
    var files_count = 0;

    if (receiver != '-' && subj != '' && content != '')
    {
        var form = new FormData;

        $('.filesToSendIssuance').each(function()
        {
            if($(this).val() != '')
            {
                form.append('file-'+files_count+'', $(this).prop('files')[0]);

                files_count++;
            }
        });

        form.append('receiver', receiver);
        form.append('subj', subj);
        form.append('content_iss', content);
        form.append('files_count', files_count);

        //
        // console.log(files_count)


        $.ajax
        ({
            xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#ulPercentage_issuance').html('');
                        $('#ulPercentage_issuance').show();
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_issuance').append(Math.floor(percentComplete*100));
                        $('#progressbar_issuance').show();
                        $('#progressbar_issuance').progressbar
                        (
                            {
                                value: percentComplete * 100
                            }
                        )
                    }
                }, false);
                //Download progress
                xhr.addEventListener("progress", function(evt)
                    {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with download progress
                            console.log(percentComplete);
                        }
                    },
                    false
                );
                return xhr;
            },
            type : 'post',
            url : '/human_resources_submit_issuance',
            contentType: false,
            processData: false,
            async : true,
            data :form,
            beforeSend : function()
            {
                btn.attr('disabled', true);
                $('#modal-hr-send-now-issuance').modal({backdrop : 'static'});
            },
            success : function()
            {
                btn.attr('disabled', false);
            },
            complete : function()
            {
                $('#modal-hr-send-now-issuance').modal('hide');

                setTimeout(function()
                {
                    $('#modal-success-send-issuance').modal('show');
                }, 1000);

                $('#selectWhereSendEmpIssuance').val('-');
                $('#subjIssuance').val('');
                $('#IssuanceMessageToPass').val('');
                $('#fillUpAdditionalFilesIssuance').html('');
                clearIssuance();
                $('#sentTrashbtn').removeAttr('style');
                lamanTrashSent = [];
                $('#showComposeIssuance').hide();
                $('#showSentIssuance').show();
                $('.btnUtilityIssuance').attr('name', 'sent').html('Compose');

                tableSentIssuance.ajax.reload(null, false);


            },
            error : function()
            {
                alert('Something went wrong. Please contact the developers');
                btn.attr('disabled', false);
            }
        });
    }
    else
    {
        alert('Please fill up all fields');
    }
});

$('#clearFieldsIssuance').click(function()
{
    if(confirm('Are you sure to clear fields?'))
    {
        clearIssuance();
    }
    else
    {

    }

});


function clearIssuance()
{
    var content = $('#IssuanceMessageToPass');
    var contentPar = content.parent()
    contentPar.find('.wysihtml5-toolbar').remove()
    contentPar.find('iframe').remove()
    contentPar.find('input[name*="wysihtml5"]').remove()
    content.show();
    $('#IssuanceMessageToPass').val('');
    $("#IssuanceMessageToPass").wysihtml5();

    scrollToTop();
}

function scrollToTop()
{
    $("html, body").animate({ scrollTop: 0 }, "fast");
}

var memo_monitoring_bool = false;
var memo_monitoring_bool2 = false;
var issuance_monitoring_bool = false;

$('.memo_monit1').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if(gethref == '#memo_monitoring_tab')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeTab = '#memo_monitoring_tab';
        }
        else if (memo_monitoring_bool)
        {
            console.log('already loaded');
            activeTab = '#memo_monitoring_tab';
        }
        else if (memo_monitoring_bool == false)
        {
            memo_monitoring_bool = true;
            activeTab = '#memo_monitoring_tab';
            // fetchMemoAcknowledgement();
            fetchAvailableMemo();
        }
    }
    else if(gethref == '#issuance_tab_compose')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeTab = '#issuance_tab_compose';
        }
        else if (issuance_monitoring_bool)
        {
            console.log('already loaded');
            activeTab = '#issuance_tab_compose';
        }
        else if (issuance_monitoring_bool == false)
        {
            issuance_monitoring_bool = true;
            activeTab = '#issuance_tab_compose';
            funcIssuanceSent();
        }
    }
});

var memo_acknowledge_table = '';
var show_all_memo = '';

function fetchMemoAcknowledgement()
{
    memo_acknowledge_table = $('#table_monitor_issuance_mail').DataTable
    ({
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="fa fa-refresh"></i>',
                action: function ( e, dt, node, config ) {
                    memo_acknowledge_table.draw();
                }
            },
            'excel'
        ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "hr_show_users",
                data: function (d)
                {
                    d.memo_id = $('#memo_id_holder').val();
                }
            },
        "columns":
            [
                {data: 'name', name: 'users.name'},
                {
                    data: function status(data)
                    {
                        if(data.check_if_acknowledge <= 0)
                        {
                            return 'PENDING ACKNOWLEDGE';
                        }
                        else
                        {
                            return 'ACKNOWLEDGE';
                        }
                    },
                    name: 'users.id'
                }

            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "pagingType": "simple",
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
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if(aData.check_if_acknowledge <= 0)
            {
                $('td', nRow).css('background-color', '#FFE599 ');
                $('td', nRow).css('font-size', '15px');
            }
            else
            {
                $('td', nRow).css('background-color', '#B6D7A8');
                $('td', nRow).css('font-size', '15px');
            }
        }
    });

    $('#table_monitor_issuance_mail_filter input').unbind();
    $('#table_monitor_issuance_mail_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                memo_acknowledge_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    memo_acknowledge_table.search($(this).val()).draw();
                }
            }
        }
    });
}

function fetchAvailableMemo()
{
    show_all_memo = $('#memo_rand_dum').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "hr_monitor_feedback",
                data: function (d)
                {
                    d.memo_id = $('#memo_id_holder').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'hr_issuance_main.id'},
                {
                    data: function subject(data)
                    {
                        return 'Memorandum: '+ data.subj + ' ' + '('+data.date+')';
                    },
                    name: 'hr_issuance_main.issuance_subject'
                }

            ],
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
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            $(nRow).css('cursor', 'pointer');
            $(nRow).addClass('get_memo_info');
            $(nRow).attr('href', btoa(aData.id));
        }
    });

    $('#memo_rand_dum_filter input').unbind();
    $('#memo_rand_dum_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                show_all_memo.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    show_all_memo.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#memo_rand_dum').on('click', '.get_memo_info', function()
{
    var get_id = atob($(this).attr('href'));

    console.log(get_id);

        if($(this).hasClass('selected'))
        {
            $(this).removeClass('selected');
        }
        else
        {
            show_all_memo.rows('.selected').deselect();
            $(this).addClass('selected');
            $('#memo_id_holder').val(get_id);
            if(!memo_monitoring_bool2)
            {
                fetchMemoAcknowledgement();
                memo_monitoring_bool2 = true;
            }
            else
            {
                memo_acknowledge_table.draw();
            }
        }
});
// MANPOWER REQUEST
// HR
$('#manpower_approved_request_trigger').click(function(){
    get_manpower_approved_request();
    $('.manpower_action_btns').hide();
});

function get_manpower_approved_request()
{
    manpower_approved_request_table = $('#manpower_approve_request_table').DataTable
    ({
        dom: 'Bfrtip',
        buttons:[
            {
                text: '<i class="fa fa-refresh"></i>',
                action: function ( e, dt, node, config ) {
                    manpower_approved_request_table.draw();
                    manpower_to_clear();
                }
            }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": 'get_manpower_approved_request',
        "columns":
            [
                {data: 'manpower_id', name: 'manpower_request.id'},
                {
                    data: function reason_vacancy_cb(data)
                    {

                        if(data.manpower_request_status =='Approved')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;" class="text-uppercase pull-right label bg-green color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }
                        }

                        else if(data.manpower_request_status =='Approved_Senior')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;" class="text-uppercase pull-right label bg-green color-palette">Approved</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }
                        }

                        else if(data.manpower_request_status =='Endorse')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%;  font-weight:400; font-size:13px; padding:4%;"  class="text-uppercase pull-right label bg-yellow color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }
                        }

                    }, name: 'manpower_request.reason_vacancy_cb'
                },
                {
                    data:function actions(data)
                    {
                        return'<a value="'+data.hold_status+'" what="'+data.manpower_request_status+'" id="'+data.manpower_id+'" class="btn bg-purple btn-block btn-sm manpower_activities manpower_view_info"  name=""><i class = "fa fa-fw fa-eye"></i> View Info</a>'+
                            '<a id="manpower_view_logs" class="btn bg-navy btn-sm btn-block manpower_activities" data-toggle="modal" data-target="#manpower_logs" name="'+data.manpower_id+'"><i class = "fa fa-edit"></i> View Logs</a>'
                    }, name:'manpower_request.id',"orderable":false,"searchable":false,
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "fnRowCallback":function(nRow, aData)
        {
            $('td', nRow).css({"cursor":"pointer","letter-spacing":"2px","border":"none"});
            $('.manpower_action_btns').hide();

        },
        initComplete:function()
        {
            $('#manpower_approve_request_table_length').hide();
            $('#manpower_approve_request_table_wrapper .dt-buttons').addClass('pull-right');
            $('#manpower_approve_request_table_filter').css({"margin-bottom":"5%", "width": "100%"});
            $('#manpower_approve_request_table_filter label').css({"text-align": "left", "width":"100%"});
            $('#manpower_approve_request_table_wrapper .col-sm-5').css({"width": "100%"});
            $('#manpower_approve_request_table_wrapper .col-sm-6').css({"width": "100%"});
            $('#manpower_approve_request_table_wrapper .col-sm-7').css({"width": "100%"});
            $('#manpower_approve_request_table_filter input').css({"width": "100%", "margin": "0","border-radius":"8px","padding":"17px"});
            $('#manpower_approve_request_table th').css({"border":"0"});
            $('.overlay').hide();
        }
    })

    $('#manpower_approve_request_table_filter input').unbind();
    $('#manpower_approve_request_table_filter input').bind('keyup change', function (e) {
        if ($(this).is(':focus')) {
            if (e.keyCode === 13) {
                manpower_approved_request_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '') {
                    manpower_approved_request_table.search($(this).val()).draw();
                }
            }
        }
    });
}
//endorse button
$('#manpower_approve_request_table').on('click', '.manpower_view_info',function () {
var approved_request_id = $(this).attr('id');

    $('.manpower_action_btns').show();
    var selected_data =$(this).attr('what');
    var selected_hold_status =$(this).attr('value');

    if(selected_data == 'Approved')
    {
        $('#endorse_manpower_btn').attr('disabled',false);
    }

    else if(selected_data == 'Endorse')
    {
        $('#endorse_manpower_btn').attr('disabled',true);
        $('#approve_senior_manpower_btn').attr('disabled',true);
    }
    else if(selected_data == 'Approved_Senior')
    {
        $('#approve_senior_manpower_btn').attr('disabled',false);
        $('#endorse_manpower_btn').attr('disabled',true);
    }

    if(selected_hold_status == 'true')
    {
        $('#approve_senior_manpower_btn').attr('disabled',true);
    }

$('#endorse_manpower_btn').attr('name',approved_request_id);
$('#approve_senior_manpower_btn').attr('name',approved_request_id);
$('#approve_senior_manpower_btn').attr('what2',selected_hold_status);
$('#endorse_manpower_btn').attr('what2',selected_hold_status);

    if($(this).closest('tr').hasClass('selected'))
    {
        $('#endorse_manpower_btn').attr('name','');
        $('#approve_senior_manpower_btn').attr('name','');
        $('.manpower_action_btns').hide();
        manpower_approved_request_table.rows('.selected').deselect();
        manpower_to_clear();
    }
    else
        {
            manpower_approved_request_table.rows('.selected').deselect();
            $(this).closest('tr').addClass('selected');

            $.ajax({
                url: 'manpower_request_selected',
                type: 'get',
                data:
                    {
                        'manpower_id': approved_request_id
                    },
                success: function (data) {
                    console.log(data)
                    $('.manpower_management_toclear').val('');
                    $('.manpower_management_toclear').prop('checked',false);

                    var split_holder = data[0].cb_data;
                    var split_holder_checkbox = split_holder.split('||-||');
                    split_holder_checkbox.pop();

                    var get_requested_date = data[0].created_at.split(" ");
                    var get_requested_duedate = data[0].due_date.split(" ");
                    $('#manpower_dateofrequest').val(get_requested_date[0]);
                    $('#manpower_requestedby').val(data[0].manpower_requestor);
                    $('#manpower_office_loc').val(data[0].off_loc_dept_pos);
                    $('#reason_vacancy_text_area').val(data[0].reason_remarks);
                    $('#manpower_location_dept_pos').val(data[0].job_details_loc_dept_pos);
                    $('#manpower_no_candidate').val(data[0].no_of_candidates);
                    $('#manpower_quali_required_desired').val(data[0].qualification);
                    $('#job_offer_salary').val(data[0].job_offer_salary);
                    $('#manpower_duedate').val(get_requested_duedate[0]);

                    $('.manpower_checkbox_grp_1 ').each(function()
                    {
                        var val = $(this).attr('name');
                        if(val === data[0].reason_vacancy_cb)
                        {
                            $(this).prop('checked', true);
                        }
                        else
                        {
                            $(this).prop('checked', false);
                        }
                    });

                    for (var a=0; a < split_holder_checkbox.length; a++){
                        if(split_holder_checkbox[a] == 'true')
                        {
                            $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', true);
                        }
                        else if(split_holder_checkbox[a] == 'false') {
                            $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', false);
                        }
                        else
                        {
                            $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', true);
                            $($('.manpower_checkbox_grp_2[name="'+a+'"]').attr('what')).val(split_holder_checkbox[a]);
                        }
                    }
                }
            })
        }
});

$('#endorse_manpower_btn').on('click',function () {
    var approved_request_id = $(this).attr('name');
    var $this = $(this);
    if(confirm('Endorse to Admin ?'))
    {
        $.ajax({
            url: 'get_manpower_request_endorse',
            type: 'get',
            data:
                {
                    'manpower_id':approved_request_id,
                    'manpower_request_status':"Endorse",
                    'table_status' : $this.attr('what2')
            },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function (data) {
                if(data == 'APPROVED_HR')
                {
                    manpower_scrollToTop();
                    manpower_approved_request_table.draw();
                    manpower_to_clear();
                    $this.attr('disabled',false);
                    $('.overlay').hide();
                    $('.manpower_action_btns').hide();
                    alert('Endorse Success');
                }
                else if(data == 'REFRESH')
                {
                    alert('Failed to Approve request. Please refresh the table to continue');
                    $('.overlay').hide();
                }
            },

        });
    }
});

$('#approve_senior_manpower_btn').on('click',function () {
    var approved_request_id = $(this).attr('name');
    var $this = $(this);

    if(confirm('Endorse to Hr Staff ?'))
    {
        $.ajax({
            url: 'get_manpower_request_endorse',
            type: 'get',
            data:
                {
                    'manpower_id':approved_request_id,
                    'manpower_request_status':"Approved",
                    'table_status' : $this.attr('what2')
                },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function (data) {
                if(data == 'APPROVED_HR')
                {
                    manpower_scrollToTop();
                    manpower_approved_request_table.ajax.reload(null, false);
                    manpower_to_clear();
                    $this.attr('disabled',false);
                    $('.overlay').hide();
                    $('.manpower_action_btns').hide();
                    alert('Approve Success');
                }
                else if(data == 'REFRESH')
                {
                    alert('Failed to Approve request. Please refresh the table to continue');
                    $('.overlay').hide();
                }
            }
        });
    }
});

function manpower_to_clear()
{
    $('.manpower_management_toclear').each(function()
    {
        if ($(this).val() != '')
        {
            $(this).val('');
            $('.manpower_management_toclear').prop('checked', false);
            $('#manpower_request_monit_table_filter input.form-control.input-sm').val('');
        }
        else
        {

        }
    });
}
function manpower_scrollToTop()
{
    $('html, body').animate({ scrollTop: 0 }, 300 ,"swing");
}
$('#manpower_close_clear').click(function ()
{
    manpower_to_clear();
});

$('#manpower_approve_request_table').on('click','.manpower_activities',function () {
    var activity_log_id = $(this).attr('name');

    $('#manpower_activity_logs_table tbody tr').each(function()
    {
        $(this).remove();
    });

    $.ajax({
        url:'manpower_activity_logs',
        type:'get',
        data:{
            'manpower_id':activity_log_id
        },
        success:function(data){
            console.log(data);

            var act_logs_append ='';

            if(data.length > 0)
            {
                for(var i = 0;i < data.length; i++)
                {
                    act_logs_append +=  '<tr>' +
                        '<td>'+data[i].user_name+'</td>' +
                        '<td>'+data[i].manpower_request_status+'</td>' +
                        '<td>'+data[i].created_at+'</td>' +
                        +'</tr>'
                }
            }
            else
            {
                act_logs_append =  '<tr>' +
                    '<td colspan="3">No Records Found</td>' +
                    +'</tr>';
            }

            $('#manpower_activity_logs_table tbody').append(act_logs_append);
        }
    })
});

