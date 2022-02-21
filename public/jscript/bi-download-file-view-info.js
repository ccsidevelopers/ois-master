$('.tableendorse').each(function () {
    var table_id = $(this).attr('id');

    $('#'+table_id+'').on('click','.btn_download_bi_files', function () {
        // console.log($(this).attr('id'));
        // console.log($(this).attr('name'));
        var id = $(this).attr('id');
        var name = $(this).attr('name');

        download_bi_files_123123123(id,name);
    });


    //Chano
    $('#'+table_id+'').on('click','.btn_view_information_bi', function () {
        console.log($(this).attr('id'));
        var id = $(this).attr('id');
        var counterShowHide = 0;

        $('#modal-view-info-bi-universal').modal('show');

        $('#view_info_details').html('');
        $('#view_info_account_logs').html('');
        $('#hide_this').html('');
        $('#view_direct_logs').html('');
        // $('#show_hide_authorization_letter').hide();


        function clear_direct_application() {

            $('#personal_email_view').html('');
            $('#lastnameView').html('');
            $('#firstameView').html('');
            $('#midnameView').html('');
            $('#suffixnameView').html('');
            $('#birthdateView').html('');
            $('#ageView').html('');
            $('#genderView').html('');
            $('#maritalStatView').html('');
            $('#maidenLastnameView').html('');
            $('#maidenFirstnameView').html('');
            $('#maidenMidnameView').html('');
            $('#birthplaceView').html('');
            $('#religionView').html('');
            $('#telCpView').html('');
            $('#sssView').html('');
            $('#presentAddressView').html('');
            $('#permaAddressView').html('');
            $('#spouseNameView').html('');
            $('#spouseContactView').html('');
            $('#FatherFullView').html('');
            $('#FatherAgeView').html('');
            $('#FatherCPView').html('');
            $('#MotherFullView').html('');
            $('#MotherAgelView').html('');
            $('#MotherCPView').html('');
            $('#secondaryNameView').html('');
            $('#secondartLocationView').html('');
            $('#secondaryInclusiveView').html('');
            $('#secondaryYearGradView').html('');
            $('#collegeNameView').html('');
            $('#collegeLocationView').html('');
            $('#collegeInclusiveView').html('');
            $('#collegeYearGradView').html('');
            $('#otherSchoolsView').html('');
            $('#civilServiceView').html('');
            $('#forceResignView').html('');
            $('#forceResignReasonView').html('');
            $('#presentCityView').html('');
            $('#presentProvinceView').html('');
            $('#permaCityView').html('');
            $('#permaProvinceView').html('');
            $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
            $('#acct_table_children_view').html('');
            $('#acct_table_siblings_view').html('');
            $('#acct_table_residences_view').html('');
            $('#acct_table_work_exp_view').html('');
            $('#acct_table_character_view').html('');
            $('#acct_table_org_view').html('');
            $('#acct_training_table_view').html('');
            $('#acct_credit_table_view').html('');
            $('#tinView').html('');
            $('#philhealthView').html('');
            $('#pagibigView').html('');
            $('.showBenefits').hide();
        }


        $.ajax({

            url : 'bi_get_view_information',
            type : 'get',
            data : {
                'id' : id,
                'check' : $(this).attr('name')
            },
            success : function (data)
            {
                if(data[0] == 'direct_applicant')
                {
                    console.log(data[8][0][0].declaration_path);

                    if(data[8][0][0].declaration_path != '')
                    {
                        $('.btnDLALViewInfoNow').attr('href', "/dlALDirectApply/" +btoa(id)+ "/");
                    }
                    console.log(data);
                    clear_direct_application();

                    $('#row_1_unversal').hide();
                    $('#row_2_unversal').hide();
                    $('#row_3_unversal').hide();
                    $('#row_4_unversal').hide();
                    $('#row_5_unversal').show();
                    $('#row_direct_logs').show();

                    $('#view_direct_logs').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '<th style="text-align: center;">USER</th>' +
                        '<th style="text-align: center;">ACTIVITIES</th>' +
                        '<th style="text-align: center;">REMARKS</th>' +
                        '<th style="text-align: center;">DATE/TIME OCCURED</th>' +
                        '</tr>'
                    );


                    for(var uy = 0;uy < data[9].length;uy++)
                    {
                        $('#view_direct_logs').append
                        (
                            '<tr>' +
                            '<td style="padding: 3px;">' +data[9][uy].name + '</td>' +
                            '<td style="padding: 3px;">' +data[9][uy].activity + '</td>' +
                            '<td style="padding: 3px;">' +data[9][uy].remarks + '</td>' +
                            '<td style="padding: 3px;">' +data[9][uy].created_at + '</td>' +
                            '</tr>'
                        )
                    }

                    $('#showHideViewAdditionalInfo').show();

                    $('#personal_email_view').html(data[8][0][0].direct_personal_email);
                    $('#lastnameView').html(data[8][0][0].direct_last_name);
                    $('#firstameView').html(data[8][0][0].direct_first_name);
                    $('#midnameView').html(data[8][0][0].direct_middle_name);
                    $('#suffixnameView').html(data[8][0][0].direct_suffix_name);
                    $('#birthdateView').html(data[8][0][0].direct_birthdate);
                    $('#ageView').html(data[8][0][0].direct_age);
                    $('#genderView').html(data[8][0][0].direct_gender);
                    $('#maritalStatView').html(data[8][0][0].direct_marital_status);
                    $('#maidenLastnameView').html(data[8][0][0].direct_maiden_last);
                    $('#maidenFirstnameView').html(data[8][0][0].direct_maiden_first);
                    $('#maidenMidnameView').html(data[8][0][0].direct_maiden_middle);
                    $('#birthplaceView').html(data[8][0][0].direct_birth_place);
                    $('#religionView').html(data[8][0][0].direct_religion);
                    $('#telCpView').html(data[8][0][0].direct_tel_cp);
                    $('#sssView').html(data[8][0][0].direct_sss);
                    $('#presentAddressView').html(data[8][0][0].direct_present_address);
                    $('#permaAddressView').html(data[8][0][0].direct_perma_address);
                    $('#spouseNameView').html(data[8][0][0].direct_spouse_name);
                    $('#spouseContactView').html(data[8][0][0].direct_spouse_tel_cp);
                    $('#FatherFullView').html(data[8][0][0].direct_father_name);
                    $('#FatherAgeView').html(data[8][0][0].direct_father_age);
                    $('#FatherCPView').html(data[8][0][0].direct_father_tel);
                    $('#MotherFullView').html(data[8][0][0].direct_mother_name);
                    $('#MotherAgelView').html(data[8][0][0].direct_mother_age);
                    $('#MotherCPView').html(data[8][0][0].direct_mother_tel);
                    $('#secondaryNameView').html(data[8][0][0].direct_secondary_school);
                    $('#secondartLocationView').html(data[8][0][0].direct_secondary_location);
                    $('#secondaryInclusiveView').html(data[8][0][0].direct_secondary_inclusive);
                    $('#secondaryYearGradView').html(data[8][0][0].direct_secondary_year_graduated);
                    $('#collegeNameView').html(data[8][0][0].direct_college_school);
                    $('#collegeLocationView').html(data[8][0][0].direct_college_location);
                    $('#collegeCourseTaken').html(data[11][0].direct_course_taken);
                    $('#collegeGradorStopped').html(data[11][0].direct_stopped_graduated_rem);
                    $('#collegeInclusiveView').html(data[8][0][0].direct_college_inclusive);
                    $('#collegeYearGradView').html(data[8][0][0].direct_college_year_graduated);
                    $('#otherSchoolsView').html(data[8][0][0].direct_other_schools);
                    $('#civilServiceView').html(data[8][0][0].direct_civil_service);
                    $('#forceResignView').html(data[8][0][0].direct_dismissed);
                    $('#forceResignReasonView').html(data[8][0][0].direct_dismissed_reason);


                    $('#presentCityView').html(data['pre_muni']);
                    $('#presentProvinceView').html(data['pre_prov']);

                    $('#permaCityView').html(data['per_muni']);
                    $('#permaProvinceView').html(data['per_prov']);

                    if(data[8][0][0].direct_profile_pic == '')
                    {
                        $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
                    }
                    else
                    {
                        $('#uploadedImgModalView').attr('src', '/getuploadedDirectApply/'+ btoa(data[8][0][0].direct_to_get_id));
                    }

                    if(data[10].length > 0)
                    {
                        if(data[10][0].bi_account_name == 'Qualfon')
                        {
                            $('.showBenefits').show();

                            $('#tinView').html(data[8][0][0].direct_tin);
                            $('#philhealthView').html(data[8][0][0].direct_philhealth);
                            $('#pagibigView').html(data[8][0][0].direct_pagibig);
                        }
                    }




                    if(data[8][1].length > 0)
                    {
                        var toAppend1 = '';

                        for(var a = 0; a < data[8][1].length; a++)
                        {
                            toAppend1 += '<tr>' +
                                '<td>'+data[8][1][a].children_name+'</td>' +
                                '<td>'+data[8][1][a].children_birthdate+'</td>' +
                                '<td>'+data[8][1][a].children_birthplace+'</td>' +
                                '</tr>';
                        }

                        $('#acct_table_children_view').html(toAppend1);
                    }

                    if(data[8][2].length > 0)
                    {
                        var toAppend2 = '';

                        for(var b = 0; b < data[8][2].length; b++)
                        {
                            toAppend2 += '<tr>' +
                                '<td colspan="1">'+data[8][2][b].sibs_name+'</td>' +
                                '<td colspan="1">'+data[8][2][b].sibs_age+'</td>' +
                                '<td colspan="2">'+data[8][2][b].sibs_address+'</td>' +
                                '<td colspan="1">'+data[8][2][b].sibs_occupation+'</td>' +
                                '</tr>';
                        }

                        $('#acct_table_siblings_view').html(toAppend2);
                    }

                    if(data[8][3].length > 0)
                    {
                        var toAppend3 = '';

                        for(var c = 0; c < data[8][3].length; c++)
                        {
                            toAppend3 += '<tr>' +
                                '<td colspan="1">'+data[8][3][c].inclusive_dates+'</td>' +
                                '<td colspan="2">'+data[8][3][c].address+'</td>' +
                                '</tr>';
                        }

                        $('#acct_table_residences_view').html(toAppend3);
                    }

                    if(data[8][4].length > 0)
                    {
                        var toAppend4 = '';

                        for(var d = 0; d < data[8][4].length; d++)
                        {
                            toAppend4 += '<tr>' +
                                '<td colspan="1">'+data[8][4][d].date_started+'</td>' +
                                '<td colspan="1">'+data[8][4][d].date_ended+'</td>' +
                                '<td colspan="1">'+data[8][4][d].date_ended_present+'</td>' +
                                '<td colspan="1">'+data[8][4][d].employer_name+'</td>' +
                                '<td colspan="1">'+data[8][4][d].position+'</td>' +
                                '<td colspan="1">'+data[8][4][d].emp_no+'</td>' +
                                '<td colspan="2">'+data[8][4][d].emp_address+'</td>' +
                                '<td colspan="1">'+data[8][4][d].emp_contact_no+'</td>' +
                                '<td colspan="1">'+data[8][4][d].supervisor_name+'</td>' +
                                '<td colspan="1">'+data[8][4][d].supervisor_number+'</td>' +
                                '<td colspan="2">'+data[8][4][d].reason_leaving+'</td>' +
                                '</tr>';

                        }

                        $('#acct_table_work_exp_view').html(toAppend4);
                    }

                    if(data[8][5].length > 0)
                    {
                        var toAppend5 = '';

                        for(var e = 0; e < data[8][5].length; e++)
                        {
                            toAppend5 += '<tr>' +
                                '<td colspan="1">'+data[8][5][e].charac_name+'</td>' +
                                '<td colspan="1">'+data[8][5][e].charac_position+'</td>' +
                                '<td colspan="2">'+data[8][5][e].charac_address+'</td>' +
                                '<td colspan="1">'+data[8][5][e].charac_email+'</td>' +
                                '<td colspan="1">'+data[8][5][e].charac_contact+'</td>' +
                                '</tr>';
                        }

                        $('#acct_table_character_view').html(toAppend5);
                    }

                    if(data[8][6].length > 0)
                    {
                        var toAppend6 = '';

                        for(var f = 0; f < data[8][6].length; f++)
                        {
                            toAppend6 += '<tr>' +
                                '<td>'+data[8][6][f].org_name+'</td>' +
                                '<td>'+data[8][6][f].org_date+'</td>' +
                                '<td>'+data[8][6][f].org_pos+'</td>' +
                                '</tr>';
                        }

                        $('#acct_table_org_view').html(toAppend6);
                    }

                    if(data[8][7].length > 0)
                    {
                        var toAppend7 = '';

                        for(var g = 0; g < data[8][7].length; g++)
                        {
                            toAppend7 += '<tr>' +
                                '<td>'+data[8][7][g].train_title+'</td>' +
                                '<td>'+data[8][7][g].train_conducted+'</td>' +
                                '<td>'+data[8][7][g].train_year+'</td>' +
                                '</tr>';
                        }

                        $('#acct_training_table_view').html(toAppend7);
                    }

                    if(data[8][8].length > 0)
                    {
                        var toAppend8 = '';

                        for(var h = 0; h < data[8][8].length; h++)
                        {
                            toAppend8 += '<tr>' +
                                '<td>'+data[8][8][h].credit_name+'</td>' +
                                '<td>'+data[8][8][h].credit_number+'</td>' +
                                '<td>'+data[8][8][h].credit_limit+'</td>' +
                                '<td>'+data[8][8][h].credit_expiry+'</td>' +
                                '</tr>';
                        }

                        $('#acct_credit_table_view').html(toAppend8);
                    }

                }
                else
                {
                    $('#row_1_unversal').show();
                    $('#row_2_unversal').show();
                    $('#row_3_unversal').show();
                    $('#row_4_unversal').show();
                    $('#row_5_unversal').hide();
                    $('#row_direct_logs').hide();

                    console.log(data);
                    var status = '';
                    var checking = '';
                    var additional = '';
                    var additional1 = '';
                    var tabletoShow = '';
                    var required_show = '';
                    $('#this_is_up').hide();

                    if(data[6] > 0)
                    {
                        required_show = '<div><center><small style="color: red; font-weight: bold">* REQUIRED DOCUMENTS REQUESTED</small><br><button id="toggleSeeRemarks" class="btn btn-xs btn-success" title="Click to show/hide remarks"><span id="this_isSpan"><i class="glyphicon glyphicon-chevron-down"></i></span></button><p id="thisisRemarks" hidden>'+data[7][0].remarks+'</p></center></div>';
                    }
                    else
                    {
                        required_show = '';
                    }


                    if(data[0][0].status == 0)
                    {
                        status = 'New Endorsement';
                    }
                    else if(data[0][0].status == 20)
                    {
                        status = 'Returned Account';
                    }
                    else if(data[0][0].status == 21)
                    {
                        status = 'Re endorsed Account';
                    }

                    var checkings = '';
                    var check_alacarte = false;
                    var get_alacarte_check = '';

                    if(data[1].length == 1)
                    {
                        if(data[1][0].type_of_check == 'N/A')
                        {
                            checkings += 'N/A';
                        }
                        else if(data[1][0].type_of_check != 'N/A')
                        {
                            for(var ctr = 0; ctr<data[1].length; ctr++)
                            {
                                // checking += '*'+data[1][ctr].checking_name+'.<br>';

                                if(data[1][ctr].type_check == 'package')
                                {
                                    checkings+= '* '+data[1][ctr].checking_name+'. <br>';
                                }
                                else if(data[1][ctr].type_check == '')
                                {
                                    checkings+= '* '+data[1][ctr].checking_name+'. <br>';
                                }
                                else if(data[1][ctr].type_check == 'alacarte')
                                {
                                    get_alacarte_check+= '* '+data[1][ctr].checking_name+'. <br>';
                                    check_alacarte = true;
                                }
                                else if(data[1][ctr].type_check == 'N/A')
                                {
                                    checkings+= ' <center>'+data[1][ctr].checking_name+'</center>';
                                    // check_alacarte = true;
                                }

                            }
                        }
                    }
                    else
                    {
                        for(var ctr = 0; ctr<data[1].length; ctr++)
                        {
                            // checking += '*'+data[1][ctr].checking_name+'.<br>';

                            if(data[1][ctr].type_check == 'package')
                            {
                                checkings+= '* '+data[1][ctr].checking_name+'. <br>';
                            }
                            else if(data[1][ctr].type_check == '')
                            {
                                checkings+= '* '+data[1][ctr].checking_name+'. <br>';
                            }
                            else if(data[1][ctr].type_check == 'alacarte')
                            {
                                get_alacarte_check+= '* '+data[1][ctr].checking_name+'. <br>';
                                check_alacarte = true;
                            }
                            else if(data[1][ctr].type_check == 'N/A')
                            {
                                checkings+= ' <center>'+data[1][ctr].checking_name+'</center>';
                                // check_alacarte = true;
                            }

                        }
                    }

                    if(check_alacarte)
                    {
                        checkings += '<br>---( Additional Check )--- <br>';
                    }

                    checking = checkings+get_alacarte_check;

                    var other_addresses = '';

                    if(data[3] != '-')
                    {
                        for(var ctr = 0; ctr<data[3].length; ctr++)
                        {
                            other_addresses +='Other Address: '+(ctr+1)+'<br>' +
                                'Address: '+data[3][ctr].address+'<br>' +
                                'Municipality: '+data[3][ctr].muni_name+'<br>' +
                                'Province: '+data[3][ctr].prov_name+'<br><br>';

                        }
                    }
                    else
                    {
                        other_addresses = data[3];
                    }

                    if(data[4].length > 0)
                    {

                        for(var loper = 0; loper < data[4].length; loper++)
                        {
                            // var splitingTeknik = splitPath[loper].split('/');

                            var openinghead = '' +
                                '                <div class="row">\n' +
                                '                    <div class="col-md-12">\n' +
                                '                        <table class="table-condensed table-hover" width="100%">';

                            var closingtable = '' +
                                '</table>\n' +
                                '                    </div>\n' +
                                '                </div>';

                            var headertableadd = '' +
                                '                            <tr>\n' +
                                '                                <th>FILE NAME</th>\n' +
                                '                                <th>REMARKS</th>\n' +
                                '                                <th>DATE TIME OF UPLOAD</th>\n' +
                                '                                <th>ACTION</th>\n' +
                                '                            </tr>';

                            var tye_ret = '';
                            if(data[4][loper].type_return == 'add')
                            {
                                tye_ret = 'Additional attachment';
                            }
                            else if(data[4][loper].type_return == 'off')
                            {
                                tye_ret = 'Close Account';
                            }
                            else if(data[4][loper].type_return == 'any')
                            {
                                tye_ret = data[4][loper].rem;
                            }

                            additional1 += '' +
                                '                            <tr>\n' +
                                '                                <td>'+data[4][loper].file+'</td>\n' +
                                '                                <td>'+tye_ret+'</td>\n' +
                                '                                <td>'+data[4][loper].date_time+'</td>\n' +
                                '                                <td><button class="btn btn-xs btn-success download_additional_bi_file" id="'+data[0][0].id+'" name="'+data[4][loper].file+'"><i class="glyphicon glyphicon-download-alt"></i> Download</button></td>\n' +
                                '<span id="dlfile"></span>' +
                                '                            </tr>';
                        }

                        var fileAdd;

                        if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder' || data[5][0].name == 'Quality Analyst')
                        {
                            fileAdd = '';
                        }
                        else if(data[5][0].name == 'B.I Client')
                        {
                            fileAdd = '<span id="check_requested">'+required_show+'</span><div class = "row" style = "padding-top : 15px; ">' +
                                '<div class = "hideShowFac col-md-4" hidden></div>' +
                                '<div class = "hideShowFac col-md-2" hidden>' +
                                '<button class= "btn btn-xs btn-info" style = "width : 100%;" id = "clicktoChooseAdditional">' +
                                '<i class = "glyphicon glyphicon-paperclip"></i> <span id = "fileStat">Choose a file</span> </button><input type="file" id = "chooseFileAdditionalBIFIle" style = "display : none">' +
                                '</div>' +
                                '<div class = "hideShowFac col-md-2" hidden>' +
                                '<button class = "btn btn-xs btn-success" style = "width: 100%" id = "submitAdditionalFile" name = "'+id+'" disabled><i class = "glyphicon glyphicon-ok" ></i> Submit</button>' +
                                '</div>' +
                                '</div>' +
                                '<div class = "hideBtntoAdd col-md-5"></div>' +
                                '<div class = "hideBtntoAdd col-md-2"><buttton class = "btn btn-xs btn-primary" id = "showAddFac"><i class = "glyphicon glyphicon-plus"></i></buttton></div>' +
                                '<div class = "hideBtntoAdd col-md-5"></div>' +
                                '</div>' +
                                '' +
                                '<div class = "row" style = "padding-top : 10px; padding-bottom : 15px;" id = "loadingBarShow" hidden>\n' +
                                '                                                <div class = "col-md-4"></div>\n' +
                                '                                                <div class = "col-md-4">\n' +
                                '                                                    <span id="ulPercentage_addFile">--</span>\n' +
                                '                                                    <div id="progressbar_addFile" hidden></div>\n' +
                                '                                                </div>\n' +
                                '                                                <div class = "col-md-4"></div>\n' +
                                '                                            </div>' +
                                '';
                        }


                        tabletoShow = openinghead+headertableadd+additional1+closingtable+fileAdd;
                    }
                    else
                    {
                        if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder' || data[5][0].name == 'Quality Analyst')
                        {   

                            //chano
                            tabletoShow = '<b>-----( NO ADDITIONAL FILE/S )-----</b>';
                            

                        }
                        else if(data[5][0].name == 'B.I Client')
                        {

                            tabletoShow = '<span id="check_requested">'+required_show+'</span><div class = "row" style = "padding-top : 15px; ">' +
                                '<div class = "hideShowFac col-md-4" hidden></div>' +
                                '<div class = "hideShowFac col-md-2" hidden>' +
                                '<button class= "btn btn-xs btn-info" style = "width : 100%;" id = "clicktoChooseAdditional">' +
                                '<i class = "glyphicon glyphicon-paperclip"></i> <span id = "fileStat">Choose a file</span> </button><input type="file" id = "chooseFileAdditionalBIFIle" style = "display : none">' +
                                '</div>' +
                                '<div class = "hideShowFac col-md-2" hidden>' +
                                '<button class = "btn btn-xs btn-success" style = "width: 100%" id = "submitAdditionalFile" name = "'+id+'" disabled><i class = "glyphicon glyphicon-ok" ></i> Submit</button>' +
                                '</div>' +
                                '</div>' +
                                '<div class = "hideBtntoAdd col-md-5"></div>' +
                                '<div class = "hideBtntoAdd col-md-2"><buttton class = "btn btn-xs btn-primary" id = "showAddFac"><i class = "glyphicon glyphicon-plus"></i></buttton></div>' +
                                '<div class = "hideBtntoAdd col-md-5"></div>' +
                                '</div>' +
                                '' +
                                '<div class = "row" style = "padding-top : 10px;" id = "loadingBarShow" hidden>\n' +
                                '                                                <div class = "col-md-4"></div>\n' +
                                '                                                <div class = "col-md-4">\n' +
                                '                                                    <span id="ulPercentage_addFile">--</span>\n' +
                                '                                                    <div id="progressbar_addFile" hidden></div>\n' +
                                '                                                </div>\n' +
                                '                                                <div class = "col-md-4"></div>\n' +
                                '                                            </div>' +
                                '';
                        }
                    }


                    var co_borrower = '';
                    var business =  '';
                    var employer = '';

                    if(data['tor_data'].length != 0)
                    {
                        if(data['tor'] == 'PDRN')
                        {
                            co_borrower+='                <tr class="bank_co_borrower" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">COBORROWER/S</td>\n' +
                                '                </tr>\n' +
                                '                <tr class="bank_co_borrower">\n' +
                                '                  <td style="padding: 3px;">' +
                                '                       <span class="badge bg-red">Name</span>' +
                                '                  </td>\n' +
                                '                  <td style="padding: 3px;">' +
                                '                       <span class="badge bg-red">Relationship to Borrower</span>' +
                                '                  </td>\n' +
                                '                  <td style="padding: 3px;">' +
                                '                       <span class="badge bg-red">Present Address</span>' +
                                '                  </td>\n' +
                                '                  <td style="padding: 3px;">' +
                                '                       <span class="badge bg-red">Permanent Address</span>' +
                                '                  </td>\n' +
                                '                </tr>\n';

                            for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
                            {
                                co_borrower+=                            '                <tr class="bank_co_borrower">\n' +
                                    '                  <td style="padding: 3px;">' +
                                    data['tor_data'][ctr].first_name +' '+ data['tor_data'][ctr].middle_name +' '+ data['tor_data'][ctr].last_name +
                                    '                  </td>\n' +
                                    '                  <td style="padding: 3px;">' +
                                    data['tor_data'][ctr].relation + data['tor_data'][ctr].other_relation+
                                    '                  </td>\n' +
                                    '                  <td style="padding: 3px;">' +
                                    data['tor_data'][ctr].pre_address +' '+data['tor_data'][ctr].pre_muni +' '+data['tor_data'][ctr].pre_prov +
                                    '                  </td>\n' +
                                    '                  <td style="padding: 3px;">' +
                                    data['tor_data'][ctr].perma_address +' '+data['tor_data'][ctr].perma_muni +' '+data['tor_data'][ctr].perma_prov +
                                    '                  </td>\n' +
                                    '                </tr>\n';
                            }
                        }
                        else if(data['tor'] == 'BVR')
                        {
                            business += '                <tr class="bank_businesses" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">BUSINESS/ES</td>\n' +
                                '                </tr>\n' +
                                '                <tr class="bank_businesses">\n' +
                                '                  <td style="padding: 3px;" colspan="2">' +
                                '                       <span class="badge bg-red">Business Name</span>' +
                                '                  </td>\n' +
                                '                  <td style="padding: 3px;" colspan="2">' +
                                '                       <span class="badge bg-red">Business Address</span>' +
                                '                  </td>\n' +
                                '                </tr>\n';

                            for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
                            {
                                business+= '                <tr class="bank_businesses">\n' +
                                    '                  <td style="padding: 3px;" colspan="2">' +
                                    data['tor_data'][ctr].name +
                                    '                  </td>\n' +
                                    '                  <td style="padding: 3px;" colspan="2">' +
                                    data['tor_data'][ctr].address +' '+data['tor_data'][ctr].muni +' '+data['tor_data'][ctr].prov +
                                    '                  </td>\n' +
                                    '                </tr>\n';
                            }
                        }
                        else if(data['tor'] == 'EVR')
                        {
                            employer +=                 '                <tr class="bank_employer" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">EMPLOYER</td>\n' +
                                '                </tr>\n' +
                                '                <tr class="bank_employer">\n' +
                                '                  <td style="padding: 3px;" colspan="2">' +
                                '                       <span class="badge bg-red">Employer Name</span>' +
                                '                  </td>\n' +
                                '                  <td style="padding: 3px;" colspan="2">' +
                                '                       <span class="badge bg-red">Employer Address</span>' +
                                '                  </td>\n' +
                                '                </tr>\n';

                            for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
                            {
                                employer+= '                <tr class="bank_employer">\n' +
                                    '                  <td style="padding: 3px;" colspan="2">' +
                                    data['tor_data'][ctr].name +
                                    '                  </td>\n' +
                                    '                  <td style="padding: 3px;" colspan="2">' +
                                    data['tor_data'][ctr].address +' '+data['tor_data'][ctr].muni +' '+data['tor_data'][ctr].prov +
                                    '                  </td>\n' +
                                    '                </tr>\n';
                            }
                        }
                    }

                    if(data[0][0].type_of_request == null)
                    {
                        if(data[0][0].direct_apply == 'direct')
                        {
                            $('#view_info_details').html
                            (
                                '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                                '                <tr>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +



                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+status+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][9][0].muni_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][10][0].muni_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][9][0].prov_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][10][0].prov_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
                                '                </tr>\n' +



                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
                                '                </tr>\n' +




                                '                <tr class="hide_this" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                                '                </tr>\n' +
                                co_borrower+
                                business+
                                employer+
                                '              </table>'
                            );
                        }
                        else
                        {
                            $('#view_info_details').html
                            (
                                '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                                '                <tr>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +



                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+status+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_muni+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_muni+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_province+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_province+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
                                '                </tr>\n' +



                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
                                '                </tr>\n' +




                                '                <tr class="hide_this" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                                '                </tr>\n' +
                                co_borrower+
                                business+
                                employer+
                                '              </table>'
                            );
                        }

                    }
                    else if(data[0][0].type_of_request == '')
                    {
                        if(data[0][0].direct_apply == 'direct')
                        {
                            $('#view_info_details').html
                            (
                                '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                                '                <tr>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +



                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+status+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][9][0].muni_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][10][0].muni_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][9][0].prov_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[8][10][0].prov_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
                                '                </tr>\n' +



                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
                                '                </tr>\n' +




                                '                <tr class="hide_this" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                                '                </tr>\n' +
                                co_borrower+
                                business+
                                employer+
                                '              </table>'
                            );
                        }
                        else
                        {
                            $('#view_info_details').html
                            (
                                '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                                '                <tr>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                                '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +



                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+status+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_muni+'</td>\n' +

                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_muni+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].present_province+'</td>\n' +


                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].permanent_province+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
                                '                </tr>\n' +



                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
                                '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
                                '                </tr>\n' +

                                '                <tr class="for_bank">\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
                                '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
                                '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
                                '                </tr>\n' +




                                '                <tr class="hide_this" style="">\n' +
                                '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                                '                </tr>\n' +

                                '                <tr>\n' +
                                '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                                '                </tr>\n' +
                                co_borrower+
                                business+
                                employer+
                                '              </table>'
                            );
                        }
                    }
                    else if(data[0][0].type_of_request != '')
                    {
                        $('#view_info_details').html
                        (
                            '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                            '                <tr>' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                            '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                            '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">PARTY #:</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].party_num+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">CONTRACT #:</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].contract_num+'</td>\n' +
                            '                </tr>\n'+

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                            '                  <td style="padding: 3px;">'+status+'</td>\n' +
                            '                </tr>\n' +
                            '                <tr class="for_bank">\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                            '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                            '                </tr>\n' +
                                                //chano
                                            '<tr>\n' +
                                                '<td style="padding: 3px; background-color: brown; color: white" colspan="12">REMARKS</span></td>\n' +
                                            '</tr>' +
                                            '<tr>' +
                                            '<td style="padding: 10px; text-transform: uppercase;" colspan="12" >'+'<strong>'+data[0][0].client_remarks_bank+'<strong>'+'</td>\n' +
                                            '</tr>' +
                            '                <tr class="hide_this" style="">\n' +
                            '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                            '                </tr>\n' +
                                            
                                            

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                            '                </tr>\n' +
                            co_borrower+
                            business+
                            employer+
                            '              </table>'
                        );
                    }
                    else if(data[0][0].type_of_request != null)
                    {
                        $('#view_info_details').html
                        (
                            '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                            '                <tr>' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
                            '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
                            '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">PARTY #:</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].party_num+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">CONTRACT #:</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].contract_num+'</td>\n' +
                            '                </tr>\n'+

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
                            '                  <td style="padding: 3px;">'+status+'</td>\n' +
                            '                </tr>\n' +
                            '                <tr class="for_bank">\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                            '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                            '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
                            '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
                            '                </tr>\n' +

                            '                <tr class="hide_this" style="">\n' +
                            '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
                            '                </tr>\n' +

                            '                <tr>\n' +
                            '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
                            '                </tr>\n' +
                            co_borrower+
                            business+
                            employer+
                            '              </table>'
                        );
                    }


                    $('#view_info_account_logs').html
                    (   
                        '<tr style="color: black;">' +
                        '<th style=\'text-align: center;\'>USER</th>' +
                        '<th style=\'text-align: center;\'>POSITION</th>' +
                        '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                        '<th style=\'text-align: center;\'>REMARKS</th>' +
                        '<th style=\'text-align: center;\'>DATE/TIME OCCURED</th>' +
                        '</tr>'
                    );

                    for(var qq = 0;qq <= (data[2].length)-1;qq++)
                    {
                        if(data[2][qq].position_name === 'OIMS Auto Generated')
                        {
                            $('#view_info_account_logs').append
                            (
                                '<tr>' +
                                '<td style="padding: 3px;">OIMS Notification</td>' +
                                '<td style="padding: 3px;">' + data[2][qq].position_name + '</td>' +
                                '<td style="padding: 3px;">' + data[2][qq].activity + '</td>' +
                                '<td style="padding: 3px;">' + data[2][qq].remarks + '</td>' +
                                '<td style="padding: 3px;">' + data[2][qq].date_time + '</td>' +
                                '</tr>'
                            )
                        }
                        else
                        {
                            $('#view_info_account_logs').append
                            (
                                '<tr>' +
                                '<td style="padding: 3px;">' +data[2][qq].user_name + '</td>' +
                                '<td style="padding: 3px;">' +data[2][qq].position_name + '</td>' +
                                '<td style="padding: 3px;">' +data[2][qq].activity + '</td>' +
                                '<td style="padding: 3px;">' +data[2][qq].remarks + '</td>' +
                                '<td style="padding: 3px;">' +data[2][qq].date_time + '</td>' +
                                '</tr>'
                            );
                        }
                    }

                    if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder' || data[5][0].name == 'Quality Analyst')
                    {
                        if(data[0][0].direct_apply == 'direct')
                        {
                            clear_direct_application();

                            $('#row_5_unversal').show();
                            $('#row_direct_logs').hide();
                            $('#showHideViewAdditionalInfo').show();
                            $('#personal_email_view').html(data[8][0][0].direct_personal_email);
                            $('#lastnameView').html(data[8][0][0].direct_last_name);
                            $('#firstameView').html(data[8][0][0].direct_first_name);
                            $('#midnameView').html(data[8][0][0].direct_middle_name);
                            $('#suffixnameView').html(data[8][0][0].direct_suffix_name);
                            $('#birthdateView').html(data[8][0][0].direct_birthdate);
                            $('#ageView').html(data[8][0][0].direct_age);
                            $('#genderView').html(data[8][0][0].direct_gender);
                            $('#maritalStatView').html(data[8][0][0].direct_marital_status);
                            $('#maidenLastnameView').html(data[8][0][0].direct_maiden_last);
                            $('#maidenFirstnameView').html(data[8][0][0].direct_maiden_first);
                            $('#maidenMidnameView').html(data[8][0][0].direct_maiden_middle);
                            $('#birthplaceView').html(data[8][0][0].direct_birth_place);
                            $('#religionView').html(data[8][0][0].direct_religion);
                            $('#telCpView').html(data[8][0][0].direct_tel_cp);
                            $('#sssView').html(data[8][0][0].direct_sss);
                            $('#presentAddressView').html(data[8][0][0].direct_present_address);
                            $('#permaAddressView').html(data[8][0][0].direct_perma_address);
                            $('#spouseNameView').html(data[8][0][0].direct_spouse_name);
                            $('#spouseContactView').html(data[8][0][0].direct_spouse_tel_cp);
                            $('#FatherFullView').html(data[8][0][0].direct_father_name);
                            $('#FatherAgeView').html(data[8][0][0].direct_father_age);
                            $('#FatherCPView').html(data[8][0][0].direct_father_tel);
                            $('#MotherFullView').html(data[8][0][0].direct_mother_name);
                            $('#MotherAgelView').html(data[8][0][0].direct_mother_age);
                            $('#MotherCPView').html(data[8][0][0].direct_mother_tel);
                            $('#secondaryNameView').html(data[8][0][0].direct_secondary_school);
                            $('#secondartLocationView').html(data[8][0][0].direct_secondary_location);
                            $('#secondaryInclusiveView').html(data[8][0][0].direct_secondary_inclusive);
                            $('#secondaryYearGradView').html(data[8][0][0].direct_secondary_year_graduated);
                            $('#collegeNameView').html(data[8][0][0].direct_college_school);
                            $('#collegeLocationView').html(data[8][0][0].direct_college_location);
                            $('#collegeCourseTaken').html(data[10][0].direct_course_taken);
                            $('#collegeGradorStopped').html(data[10][0].direct_stopped_graduated_rem);
                            $('#collegeInclusiveView').html(data[8][0][0].direct_college_inclusive);
                            $('#collegeYearGradView').html(data[8][0][0].direct_college_year_graduated);
                            $('#otherSchoolsView').html(data[8][0][0].direct_other_schools);
                            $('#civilServiceView').html(data[8][0][0].direct_civil_service);
                            $('#forceResignView').html(data[8][0][0].direct_dismissed);
                            $('#forceResignReasonView').html(data[8][0][0].direct_dismissed_reason);

                            $('#presentCityView').html(data[8][9][0].muni_name);
                            $('#presentProvinceView').html(data[8][9][0].prov_name);
                            $('#permaCityView').html(data[8][10][0].muni_name);
                            $('#permaProvinceView').html(data[8][10][0].prov_name);

                            if(data[8][0][0].declaration_path != '')
                            {
                                $('.btnDLALViewInfoNow').attr('href', "/dlALDirectApply/" +btoa(id)+ "/");

                                $('#show_hide_authorization_letter').show();
                            }

                            if(data[8][0][0].direct_profile_pic == '')
                            {
                                $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
                            }
                            else
                            {
                                $('#uploadedImgModalView').attr('src', '/getuploadedDirectApply/'+ btoa(data[8][0][0].direct_to_get_id));
                            }

                            if(data[9].length > 0)
                            {
                                if(data[9][0].bi_account_name == 'Qualfon')
                                {
                                    $('.showBenefits').show();

                                    $('#tinView').html(data[8][0][0].direct_tin);
                                    $('#philhealthView').html(data[8][0][0].direct_philhealth);
                                    $('#pagibigView').html(data[8][0][0].direct_pagibig);
                                }

                            }

                            if(data[8][1].length > 0)
                            {
                                var toAppend1 = '';

                                for(var a = 0; a < data[8][1].length; a++)
                                {
                                    toAppend1 += '<tr>' +
                                        '<td>'+data[8][1][a].children_name+'</td>' +
                                        '<td>'+data[8][1][a].children_birthdate+'</td>' +
                                        '<td>'+data[8][1][a].children_birthplace+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_table_children_view').html(toAppend1);
                            }

                            if(data[8][2].length > 0)
                            {
                                var toAppend2 = '';

                                for(var b = 0; b < data[8][2].length; b++)
                                {
                                    toAppend2 += '<tr>' +
                                        '<td colspan="1">'+data[8][2][b].sibs_name+'</td>' +
                                        '<td colspan="1">'+data[8][2][b].sibs_age+'</td>' +
                                        '<td colspan="2">'+data[8][2][b].sibs_address+'</td>' +
                                        '<td colspan="1">'+data[8][2][b].sibs_occupation+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_table_siblings_view').html(toAppend2);
                            }

                            if(data[8][3].length > 0)
                            {
                                var toAppend3 = '';

                                for(var c = 0; c < data[8][3].length; c++)
                                {
                                    toAppend3 += '<tr>' +
                                        '<td colspan="1">'+data[8][3][c].inclusive_dates+'</td>' +
                                        '<td colspan="2">'+data[8][3][c].address+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_table_residences_view').html(toAppend3);
                            }

                            if(data[8][4].length > 0)
                            {
                                var toAppend4 = '';

                                for(var d = 0; d < data[8][4].length; d++)
                                {
                                    toAppend4 += '<tr>' +
                                        '<td colspan="1">'+data[8][4][d].date_started+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].date_ended+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].date_ended_present+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].employer_name+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].position+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].emp_no+'</td>' +
                                        '<td colspan="2">'+data[8][4][d].emp_address+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].emp_contact_no+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].supervisor_name+'</td>' +
                                        '<td colspan="1">'+data[8][4][d].supervisor_number+'</td>' +
                                        '<td colspan="2">'+data[8][4][d].reason_leaving+'</td>' +
                                        '</tr>';

                                }

                                $('#acct_table_work_exp_view').html(toAppend4);
                            }

                            if(data[8][5].length > 0)
                            {
                                var toAppend5 = '';

                                for(var e = 0; e < data[8][5].length; e++)
                                {
                                    toAppend5 += '<tr>' +
                                        '<td colspan="1">'+data[8][5][e].charac_name+'</td>' +
                                        '<td colspan="1">'+data[8][5][e].charac_position+'</td>' +
                                        '<td colspan="2">'+data[8][5][e].charac_address+'</td>' +
                                        '<td colspan="1">'+data[8][5][e].charac_email+'</td>' +
                                        '<td colspan="1">'+data[8][5][e].charac_contact+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_table_character_view').html(toAppend5);
                            }

                            if(data[8][6].length > 0)
                            {
                                var toAppend6 = '';

                                for(var f = 0; f < data[8][6].length; f++)
                                {
                                    toAppend6 += '<tr>' +
                                        '<td>'+data[8][6][f].org_name+'</td>' +
                                        '<td>'+data[8][6][f].org_date+'</td>' +
                                        '<td>'+data[8][6][f].org_pos+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_table_org_view').html(toAppend6);
                            }

                            if(data[8][7].length > 0)
                            {
                                var toAppend7 = '';

                                for(var g = 0; g < data[8][7].length; g++)
                                {
                                    toAppend7 += '<tr>' +
                                        '<td>'+data[8][7][g].train_title+'</td>' +
                                        '<td>'+data[8][7][g].train_conducted+'</td>' +
                                        '<td>'+data[8][7][g].train_year+'</td>' +
                                        '</tr>';
                                }

                                $('#acct_training_table_view').html(toAppend7);
                            }

                            // if(data[8][8].length > 0)
                            // {
                            //     var toAppend8 = '';
                            //
                            //     for(var h = 0; h < data[8][8].length; h++)
                            //     {
                            //         toAppend8 += '<tr>' +
                            //             '<td>'+data[8][8][h].credit_name+'</td>' +
                            //             '<td>'+data[8][8][h].credit_number+'</td>' +
                            //             '<td>'+data[8][8][h].credit_limit+'</td>' +
                            //             '<td>'+data[8][8][h].credit_expiry+'</td>' +
                            //             '</tr>';
                            //     }
                            //
                            //     $('#acct_credit_table_view').html(toAppend8);
                            // }
                        }
                        else
                        {
                            $('#row_5_unversal').hide();
                            $('#row_direct_logs').hide();
                            $('#showHideViewAdditionalInfo').hide();
                        }
                    }
                    else if(data[5][0].name == 'B.I Client')
                    {
                        if(data['auth_req'] == 'direct_enc')
                        {
                            clear_direct_application();
                            if(data[0][0].direct_apply == 'direct')
                            {
                                $('#row_5_unversal').show();
                                $('#showHideViewAdditionalInfo').show();

                                $('#personal_email_view').html(data[8][0][0].direct_personal_email);
                                $('#lastnameView').html(data[8][0][0].direct_last_name);
                                $('#firstameView').html(data[8][0][0].direct_first_name);
                                $('#midnameView').html(data[8][0][0].direct_middle_name);
                                $('#suffixnameView').html(data[8][0][0].direct_suffix_name);
                                $('#birthdateView').html(data[8][0][0].direct_birthdate);
                                $('#ageView').html(data[8][0][0].direct_age);
                                $('#genderView').html(data[8][0][0].direct_gender);
                                $('#maritalStatView').html(data[8][0][0].direct_marital_status);
                                $('#maidenLastnameView').html(data[8][0][0].direct_maiden_last);
                                $('#maidenFirstnameView').html(data[8][0][0].direct_maiden_first);
                                $('#maidenMidnameView').html(data[8][0][0].direct_maiden_middle);
                                $('#birthplaceView').html(data[8][0][0].direct_birth_place);
                                $('#religionView').html(data[8][0][0].direct_religion);
                                $('#telCpView').html(data[8][0][0].direct_tel_cp);
                                $('#sssView').html(data[8][0][0].direct_sss);
                                $('#presentAddressView').html(data[8][0][0].direct_present_address);
                                $('#permaAddressView').html(data[8][0][0].direct_perma_address);
                                $('#spouseNameView').html(data[8][0][0].direct_spouse_name);
                                $('#spouseContactView').html(data[8][0][0].direct_spouse_tel_cp);
                                $('#FatherFullView').html(data[8][0][0].direct_father_name);
                                $('#FatherAgeView').html(data[8][0][0].direct_father_age);
                                $('#FatherCPView').html(data[8][0][0].direct_father_tel);
                                $('#MotherFullView').html(data[8][0][0].direct_mother_name);
                                $('#MotherAgelView').html(data[8][0][0].direct_mother_age);
                                $('#MotherCPView').html(data[8][0][0].direct_mother_tel);
                                $('#secondaryNameView').html(data[8][0][0].direct_secondary_school);
                                $('#secondartLocationView').html(data[8][0][0].direct_secondary_location);
                                $('#secondaryInclusiveView').html(data[8][0][0].direct_secondary_inclusive);
                                $('#secondaryYearGradView').html(data[8][0][0].direct_secondary_year_graduated);
                                $('#collegeNameView').html(data[8][0][0].direct_college_school);
                                $('#collegeLocationView').html(data[8][0][0].direct_college_location);
                                $('#collegeCourseTaken').html(data[11].direct_course_taken);
                                $('#collegeGradorStopped').html(data[11].direct_stopped_graduated_rem);
                                $('#collegeInclusiveView').html(data[8][0][0].direct_college_inclusive);
                                $('#collegeYearGradView').html(data[8][0][0].direct_college_year_graduated);
                                $('#otherSchoolsView').html(data[8][0][0].direct_other_schools);
                                $('#civilServiceView').html(data[8][0][0].direct_civil_service);
                                $('#forceResignView').html(data[8][0][0].direct_dismissed);
                                $('#forceResignReasonView').html(data[8][0][0].direct_dismissed_reason);
                                $('#presentCityView').html(data[8][9][0].muni_name);
                                $('#presentProvinceView').html(data[8][9][0].prov_name);
                                $('#permaCityView').html(data[8][10][0].muni_name);
                                $('#permaProvinceView').html(data[8][10][0].prov_name);

                                if(data[8][0][0].direct_profile_pic == '')
                                {
                                    $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
                                }
                                else
                                {
                                    $('#uploadedImgModalView').attr('src', '/getuploadedDirectApply/'+ btoa(data[8][0][0].direct_to_get_id));
                                }


                                if(data[9].length > 0 )
                                {
                                    if(data[9][0].bi_account_name == 'Qualfon')
                                    {
                                        $('.showBenefits').show();

                                        $('#tinView').html(data[8][0][0].direct_tin);
                                        $('#philhealthView').html(data[8][0][0].direct_philhealth);
                                        $('#pagibigView').html(data[8][0][0].direct_pagibig);
                                    }
                                }


                                if(data[8][1].length > 0)
                                {
                                    var toAppend1 = '';

                                    for(var a = 0; a < data[8][1].length; a++)
                                    {
                                        toAppend1 += '<tr>' +
                                            '<td>'+data[8][1][a].children_name+'</td>' +
                                            '<td>'+data[8][1][a].children_birthdate+'</td>' +
                                            '<td>'+data[8][1][a].children_birthplace+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_table_children_view').html(toAppend1);
                                }

                                if(data[8][2].length > 0)
                                {
                                    var toAppend2 = '';

                                    for(var b = 0; b < data[8][2].length; b++)
                                    {
                                        toAppend2 += '<tr>' +
                                            '<td colspan="1">'+data[8][2][b].sibs_name+'</td>' +
                                            '<td colspan="1">'+data[8][2][b].sibs_age+'</td>' +
                                            '<td colspan="2">'+data[8][2][b].sibs_address+'</td>' +
                                            '<td colspan="1">'+data[8][2][b].sibs_occupation+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_table_siblings_view').html(toAppend2);
                                }

                                if(data[8][3].length > 0)
                                {
                                    var toAppend3 = '';

                                    for(var c = 0; c < data[8][3].length; c++)
                                    {
                                        toAppend3 += '<tr>' +
                                            '<td colspan="1">'+data[8][3][c].inclusive_dates+'</td>' +
                                            '<td colspan="2">'+data[8][3][c].address+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_table_residences_view').html(toAppend3);
                                }

                                if(data[8][4].length > 0)
                                {
                                    var toAppend4 = '';

                                    for(var d = 0; d < data[8][4].length; d++)
                                    {
                                        toAppend4 += '<tr>' +
                                            '<td colspan="1">'+data[8][4][d].date_started+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].date_ended+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].date_ended_present+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].employer_name+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].position+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].emp_no+'</td>' +
                                            '<td colspan="2">'+data[8][4][d].emp_address+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].emp_contact_no+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].supervisor_name+'</td>' +
                                            '<td colspan="1">'+data[8][4][d].supervisor_number+'</td>' +
                                            '<td colspan="2">'+data[8][4][d].reason_leaving+'</td>' +
                                            '</tr>';

                                    }

                                    $('#acct_table_work_exp_view').html(toAppend4);
                                }

                                if(data[8][5].length > 0)
                                {
                                    var toAppend5 = '';

                                    for(var e = 0; e < data[8][5].length; e++)
                                    {
                                        toAppend5 += '<tr>' +
                                            '<td colspan="1">'+data[8][5][e].charac_name+'</td>' +
                                            '<td colspan="1">'+data[8][5][e].charac_position+'</td>' +
                                            '<td colspan="2">'+data[8][5][e].charac_address+'</td>' +
                                            '<td colspan="1">'+data[8][5][e].charac_email+'</td>' +
                                            '<td colspan="1">'+data[8][5][e].charac_contact+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_table_character_view').html(toAppend5);
                                }

                                if(data[8][6].length > 0)
                                {
                                    var toAppend6 = '';

                                    for(var f = 0; f < data[8][6].length; f++)
                                    {
                                        toAppend6 += '<tr>' +
                                            '<td>'+data[8][6][f].org_name+'</td>' +
                                            '<td>'+data[8][6][f].org_date+'</td>' +
                                            '<td>'+data[8][6][f].org_pos+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_table_org_view').html(toAppend6);
                                }

                                if(data[8][7].length > 0)
                                {
                                    var toAppend7 = '';

                                    for(var g = 0; g < data[8][7].length; g++)
                                    {
                                        toAppend7 += '<tr>' +
                                            '<td>'+data[8][7][g].train_title+'</td>' +
                                            '<td>'+data[8][7][g].train_conducted+'</td>' +
                                            '<td>'+data[8][7][g].train_year+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_training_table_view').html(toAppend7);
                                }

                                if(data[8][8].length > 0)
                                {
                                    var toAppend8 = '';

                                    for(var h = 0; h < data[8][8].length; h++)
                                    {
                                        toAppend8 += '<tr>' +
                                            '<td>'+data[8][8][h].credit_name+'</td>' +
                                            '<td>'+data[8][8][h].credit_number+'</td>' +
                                            '<td>'+data[8][8][h].credit_limit+'</td>' +
                                            '<td>'+data[8][8][h].credit_expiry+'</td>' +
                                            '</tr>';
                                    }

                                    $('#acct_credit_table_view').html(toAppend8);
                                }
                            }
                            else
                            {
                                $('#row_5_unversal').hide();
                                $('#row_direct_logs').hide();
                                $('#showHideViewAdditionalInfo').hide();
                            }
                        }
                        else
                        {
                            $('#row_5_unversal').hide();
                            $('#row_direct_logs').hide();
                            $('#showHideViewAdditionalInfo').hide();
                        }
                    }
                }
            },
            complete: function()
            {
                $('.download_additional_bi_file').click(function()
                {
                    var dl_id = $(this).attr('id');
                    var path = $(this).attr('name');

                    var id_encode = btoa(dl_id);
                    var path_encode = btoa(path);
                    var q = '<form action="/bi-view-info-dl" target="_blank" method="get">'+
                        '<div class="input-group">'+
                        '<input type="text" hidden value="'+id_encode+'|'+path_encode+'" name="id">'+
                        '<button type="submit" hidden id="button_bi_attached_dl" >'+
                        '</button>'+
                        '</span>'+
                        '</div>'+
                        '</form>';

                    $('#dlfile').html(q);
                    $('#button_bi_attached_dl').click();
                    $('#dlfile').hide();
                });

                $('#toggleSeeRemarks').click(function()
                {
                    $('#thisisRemarks').toggle(200);
                    if(counterShowHide %2 == 0)
                    {
                        $('#this_isSpan').html('<i class="glyphicon glyphicon-chevron-up"></i>');
                    }
                    else
                    {
                        $('#this_isSpan').html('<i class="glyphicon glyphicon-chevron-down"></i>')
                    }

                    counterShowHide++;
                });
            },
            error : function (e) {
                console.log(e);
            }

        });
        // download_bi_files_123123123(id,name);
    })



});


// $('.tableendorse').each(function () {
//     var table_id = $(this).attr('id');
//
//     $('#'+table_id+'').on('click','.btn_download_bi_files', function () {
//         // console.log($(this).attr('id'));
//         // console.log($(this).attr('name'));
//         var id = $(this).attr('id');
//         var name = $(this).attr('name');
//
//         download_bi_files_123123123(id,name);
//     });
//
//     $('#'+table_id+'').on('click','.btn_view_information_bi', function () {
//         console.log($(this).attr('id'));
//         var id = $(this).attr('id');
//         var counterShowHide = 0;
//
//         $('#modal-view-info-bi-universal').modal('show');
//
//         $('#view_info_details').html('');
//         $('#view_info_account_logs').html('');
//         $('#hide_this').html('');
//
//
//         function clear_direct_application() {
//
//             $('#personal_email_view').html('');
//             $('#lastnameView').html('');
//             $('#firstameView').html('');
//             $('#midnameView').html('');
//             $('#suffixnameView').html('');
//             $('#birthdateView').html('');
//             $('#ageView').html('');
//             $('#genderView').html('');
//             $('#maritalStatView').html('');
//             $('#maidenLastnameView').html('');
//             $('#maidenFirstnameView').html('');
//             $('#maidenMidnameView').html('');
//             $('#birthplaceView').html('');
//             $('#religionView').html('');
//             $('#telCpView').html('');
//             $('#sssView').html('');
//             $('#presentAddressView').html('');
//             $('#permaAddressView').html('');
//             $('#spouseNameView').html('');
//             $('#spouseContactView').html('');
//             $('#FatherFullView').html('');
//             $('#FatherAgeView').html('');
//             $('#FatherCPView').html('');
//             $('#MotherFullView').html('');
//             $('#MotherAgelView').html('');
//             $('#MotherCPView').html('');
//             $('#secondaryNameView').html('');
//             $('#secondartLocationView').html('');
//             $('#secondaryInclusiveView').html('');
//             $('#secondaryYearGradView').html('');
//             $('#collegeNameView').html('');
//             $('#collegeLocationView').html('');
//             $('#collegeInclusiveView').html('');
//             $('#collegeYearGradView').html('');
//             $('#otherSchoolsView').html('');
//             $('#civilServiceView').html('');
//             $('#forceResignView').html('');
//             $('#forceResignReasonView').html('');
//             $('#presentCityView').html('');
//             $('#presentProvinceView').html('');
//             $('#permaCityView').html('');
//             $('#permaProvinceView').html('');
//             $('#uploadedImgModalView').attr('src', '../user_profile_pictures/default3.jpg');
//             $('#acct_table_children_view').html('');
//             $('#acct_table_siblings_view').html('');
//             $('#acct_table_residences_view').html('');
//             $('#acct_table_work_exp_view').html('');
//             $('#acct_table_character_view').html('');
//             $('#acct_table_org_view').html('');
//             $('#acct_training_table_view').html('');
//             $('#acct_credit_table_view').html('');
//         }
//
//
//         $.ajax({
//
//             url : 'bi_get_view_information',
//             type : 'get',
//             data : {
//                 'id' : id,
//                 'direct' : $(this).attr('name')
//             },
//             success : function (data)
//             {
//                 console.log(data)
//                 if(data[0][0].direct_apply == 'direct')
//                 {
//                     clear_direct_application();
//
//                     if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder' )
//                     {
//                         $('#row_1_unversal').show();
//                         $('#row_2_unversal').show();
//                         $('#row_3_unversal').show();
//                         $('#row_4_unversal').show();
//                         $('#row_5_unversal').show();
//                     }
//                     else if(data[5][0].name == 'B.I Client')
//                     {
//                         $('#row_1_unversal').hide();
//                         $('#row_2_unversal').hide();
//                         $('#row_3_unversal').hide();
//                         $('#row_4_unversal').hide();
//                         $('#row_5_unversal').show();
//                     }
//
//                     $('#personal_email_view').html(data[8][0][0].direct_personal_email);
//                     $('#lastnameView').html(data[8][0][0].direct_last_name);
//                     $('#firstameView').html(data[8][0][0].direct_first_name);
//                     $('#midnameView').html(data[8][0][0].direct_middle_name);
//                     $('#suffixnameView').html(data[8][0][0].direct_suffix_name);
//                     $('#birthdateView').html(data[8][0][0].direct_birthdate);
//                     $('#ageView').html(data[8][0][0].direct_age);
//                     $('#genderView').html(data[8][0][0].direct_gender);
//                     $('#maritalStatView').html(data[8][0][0].direct_marital_status);
//                     $('#maidenLastnameView').html(data[8][0][0].direct_maiden_last);
//                     $('#maidenFirstnameView').html(data[8][0][0].direct_maiden_first);
//                     $('#maidenMidnameView').html(data[8][0][0].direct_maiden_middle);
//                     $('#birthplaceView').html(data[8][0][0].direct_birth_place);
//                     $('#religionView').html(data[8][0][0].direct_religion);
//                     $('#telCpView').html(data[8][0][0].direct_tel_cp);
//                     $('#sssView').html(data[8][0][0].direct_sss);
//                     $('#presentAddressView').html(data[8][0][0].direct_present_address);
//                     $('#permaAddressView').html(data[8][0][0].direct_perma_address);
//                     $('#spouseNameView').html(data[8][0][0].direct_spouse_name);
//                     $('#spouseContactView').html(data[8][0][0].direct_spouse_tel_cp);
//                     $('#FatherFullView').html(data[8][0][0].direct_father_name);
//                     $('#FatherAgeView').html(data[8][0][0].direct_father_age);
//                     $('#FatherCPView').html(data[8][0][0].direct_father_tel);
//                     $('#MotherFullView').html(data[8][0][0].direct_mother_name);
//                     $('#MotherAgelView').html(data[8][0][0].direct_mother_age);
//                     $('#MotherCPView').html(data[8][0][0].direct_mother_tel);
//                     $('#secondaryNameView').html(data[8][0][0].direct_secondary_school);
//                     $('#secondartLocationView').html(data[8][0][0].direct_secondary_location);
//                     $('#secondaryInclusiveView').html(data[8][0][0].direct_secondary_inclusive);
//                     $('#secondaryYearGradView').html(data[8][0][0].direct_secondary_year_graduated);
//                     $('#collegeNameView').html(data[8][0][0].direct_college_school);
//                     $('#collegeLocationView').html(data[8][0][0].direct_college_location);
//                     $('#collegeInclusiveView').html(data[8][0][0].direct_college_inclusive);
//                     $('#collegeYearGradView').html(data[8][0][0].direct_college_year_graduated);
//                     $('#otherSchoolsView').html(data[8][0][0].direct_other_schools);
//                     $('#civilServiceView').html(data[8][0][0].direct_civil_service);
//                     $('#forceResignView').html(data[8][0][0].direct_dismissed);
//                     $('#forceResignReasonView').html(data[8][0][0].direct_dismissed_reason);
//
//                     $('#presentCityView').html(data[0][0].present_muni);
//                     $('#presentProvinceView').html(data[0][0].present_province);
//                     $('#permaCityView').html(data[0][0].permanent_muni);
//                     $('#permaProvinceView').html(data[0][0].permanent_province);
//
//                     if(data[8][1].length > 0)
//                     {
//                         var toAppend1 = '';
//
//                         for(var a = 0; a < data[8][1].length; a++)
//                         {
//                             toAppend1 += '<tr>' +
//                                 '<td>'+data[8][1][a].children_name+'</td>' +
//                                 '<td>'+data[8][1][a].children_birthdate+'</td>' +
//                                 '<td>'+data[8][1][a].children_birthplace+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_table_children_view').html(toAppend1);
//                     }
//
//                     if(data[8][2].length > 0)
//                     {
//                         var toAppend2 = '';
//
//                         for(var b = 0; b < data[8][2].length; b++)
//                         {
//                             toAppend2 += '<tr>' +
//                                 '<td colspan="1">'+data[8][2][b].sibs_name+'</td>' +
//                                 '<td colspan="1">'+data[8][2][b].sibs_age+'</td>' +
//                                 '<td colspan="2">'+data[8][2][b].sibs_address+'</td>' +
//                                 '<td colspan="1">'+data[8][2][b].sibs_occupation+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_table_siblings_view').html(toAppend2);
//                     }
//
//                     if(data[8][3].length > 0)
//                     {
//                         var toAppend3 = '';
//
//                         for(var c = 0; c < data[8][3].length; c++)
//                         {
//                             toAppend3 += '<tr>' +
//                                 '<td colspan="1">'+data[8][3][c].inclusive_dates+'</td>' +
//                                 '<td colspan="2">'+data[8][3][c].address+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_table_residences_view').html(toAppend3);
//                     }
//
//                     if(data[8][4].length > 0)
//                     {
//                         var toAppend4 = '';
//
//                         for(var d = 0; d < data[8][4].length; d++)
//                         {
//                             toAppend4 += '<tr>' +
//                                 '<td colspan="1">'+data[8][4][d].date_started+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].date_ended+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].date_ended_present+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].position+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].emp_no+'</td>' +
//                                 '<td colspan="2">'+data[8][4][d].emp_address+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].emp_contact_no+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].supervisor_name+'</td>' +
//                                 '<td colspan="1">'+data[8][4][d].supervisor_name+'</td>' +
//                                 '<td colspan="2">'+data[8][4][d].reason_leaving+'</td>' +
//                                 '</tr>';
//
//                         }
//
//                         $('#acct_table_work_exp_view').html(toAppend4);
//                     }
//
//                     if(data[8][5].length > 0)
//                     {
//                         var toAppend5 = '';
//
//                         for(var e = 0; e < data[8][5].length; e++)
//                         {
//                             toAppend5 += '<tr>' +
//                                 '<td colspan="1">'+data[8][5][e].charac_name+'</td>' +
//                                 '<td colspan="1">'+data[8][5][e].charac_position+'</td>' +
//                                 '<td colspan="2">'+data[8][5][e].charac_address+'</td>' +
//                                 '<td colspan="1">'+data[8][5][e].charac_email+'</td>' +
//                                 '<td colspan="1">'+data[8][5][e].charac_contact+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_table_character_view').html(toAppend5);
//                     }
//
//                     if(data[8][6].length > 0)
//                     {
//                         var toAppend6 = '';
//
//                         for(var f = 0; f < data[8][6].length; f++)
//                         {
//                             toAppend6 += '<tr>' +
//                                 '<td>'+data[8][6][f].org_name+'</td>' +
//                                 '<td>'+data[8][6][f].org_date+'</td>' +
//                                 '<td>'+data[8][6][f].org_pos+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_table_org_view').html(toAppend6);
//                     }
//
//                     if(data[8][7].length > 0)
//                     {
//                         var toAppend7 = '';
//
//                         for(var g = 0; g < data[8][7].length; g++)
//                         {
//                             toAppend7 += '<tr>' +
//                                 '<td>'+data[8][7][g].train_title+'</td>' +
//                                 '<td>'+data[8][7][g].train_conducted+'</td>' +
//                                 '<td>'+data[8][7][g].train_year+'</td>' +
//                                 '</tr>';
//                         }
//
//                         $('#acct_training_table_view').html(toAppend7);
//                     }
//
//                 }
//                 else
//                 {
//                     $('#row_1_unversal').show();
//                     $('#row_2_unversal').show();
//                     $('#row_3_unversal').show();
//                     $('#row_4_unversal').show();
//                     $('#row_5_unversal').hide();
//                 }
//
//
//
//
//                 var status = '';
//                 var checking = '';
//                 var additional = '';
//                 var additional1 = '';
//                 var tabletoShow = '';
//                 var required_show = '';
//                 $('#this_is_up').hide();
//
//                 if(data[6] > 0)
//                 {
//                     required_show = '<div><center><small style="color: red; font-weight: bold">* REQUIRED DOCUMENTS REQUESTED</small><br><button id="toggleSeeRemarks" class="btn btn-xs btn-success" title="Click to show/hide remarks"><span id="this_isSpan"><i class="glyphicon glyphicon-chevron-down"></i></span></button><p id="thisisRemarks" hidden>'+data[7][0].remarks+'</p></center></div>';
//                 }
//                 else
//                 {
//                     required_show = '';
//                 }
//
//
//                 if(data[0][0].status == 0)
//                 {
//                     status = 'New Endorsement';
//                 }
//                 else if(data[0][0].status == 20)
//                 {
//                     status = 'Returned Account';
//                 }
//                 else if(data[0][0].status == 21)
//                 {
//                     status = 'Re endorsed Account';
//                 }
//
//                 var checkings = '';
//                 var check_alacarte = false;
//                 var get_alacarte_check = '';
//
//                 if(data[1].length == 1)
//                 {
//                     if(data[1][0].type_of_check == 'N/A')
//                     {
//                         checkings += 'N/A';
//                     }
//                     else if(data[1][0].type_of_check != 'N/A')
//                     {
//                         for(var ctr = 0; ctr<data[1].length; ctr++)
//                         {
//                             // checking += '*'+data[1][ctr].checking_name+'.<br>';
//
//                             if(data[1][ctr].type_check == 'package')
//                             {
//                                 checkings+= '* '+data[1][ctr].checking_name+'. <br>';
//                             }
//                             else if(data[1][ctr].type_check == '')
//                             {
//                                 checkings+= '* '+data[1][ctr].checking_name+'. <br>';
//                             }
//                             else if(data[1][ctr].type_check == 'alacarte')
//                             {
//                                 get_alacarte_check+= '* '+data[1][ctr].checking_name+'. <br>';
//                                 check_alacarte = true;
//                             }
//                             else if(data[1][ctr].type_check == 'N/A')
//                             {
//                                 checkings+= ' <center>'+data[1][ctr].checking_name+'</center>';
//                                 // check_alacarte = true;
//                             }
//
//                         }
//                     }
//                 }
//                 else
//                 {
//                     for(var ctr = 0; ctr<data[1].length; ctr++)
//                     {
//                         // checking += '*'+data[1][ctr].checking_name+'.<br>';
//
//                         if(data[1][ctr].type_check == 'package')
//                         {
//                             checkings+= '* '+data[1][ctr].checking_name+'. <br>';
//                         }
//                         else if(data[1][ctr].type_check == '')
//                         {
//                             checkings+= '* '+data[1][ctr].checking_name+'. <br>';
//                         }
//                         else if(data[1][ctr].type_check == 'alacarte')
//                         {
//                             get_alacarte_check+= '* '+data[1][ctr].checking_name+'. <br>';
//                             check_alacarte = true;
//                         }
//                         else if(data[1][ctr].type_check == 'N/A')
//                         {
//                             checkings+= ' <center>'+data[1][ctr].checking_name+'</center>';
//                             // check_alacarte = true;
//                         }
//
//                     }
//                 }
//
//                 if(check_alacarte)
//                 {
//                     checkings += '<br>---( Additional Check )--- <br>';
//                 }
//
//                 checking = checkings+get_alacarte_check;
//
//                 var other_addresses = '';
//
//                 if(data[3] != '-')
//                 {
//                     for(var ctr = 0; ctr<data[3].length; ctr++)
//                     {
//                         other_addresses +='Other Address: '+(ctr+1)+'<br>' +
//                             'Address: '+data[3][ctr].address+'<br>' +
//                             'Municipality: '+data[3][ctr].muni_name+'<br>' +
//                             'Province: '+data[3][ctr].prov_name+'<br><br>';
//
//                     }
//                 }
//                 else
//                 {
//                     other_addresses = data[3];
//                 }
//
//                 if(data[4].length > 0)
//                 {
//
//                     for(var loper = 0; loper < data[4].length; loper++)
//                     {
//                         // var splitingTeknik = splitPath[loper].split('/');
//
//                         var openinghead = '' +
//                             '                <div class="row">\n' +
//                             '                    <div class="col-md-12">\n' +
//                             '                        <table class="table-condensed table-hover" width="100%">';
//
//                         var closingtable = '' +
//                             '</table>\n' +
//                             '                    </div>\n' +
//                             '                </div>';
//
//                         var headertableadd = '' +
//                             '                            <tr>\n' +
//                             '                                <th>FILE NAME</th>\n' +
//                             '                                <th>REMARKS</th>\n' +
//                             '                                <th>DATE TIME OF UPLOAD</th>\n' +
//                             '                                <th>ACTION</th>\n' +
//                             '                            </tr>';
//
//                         var tye_ret = '';
//                         if(data[4][loper].type_return == 'add')
//                         {
//                             tye_ret = 'Additional attachment';
//                         }
//                         else if(data[4][loper].type_return == 'off')
//                         {
//                             tye_ret = 'Close Account';
//                         }
//                         else if(data[4][loper].type_return == 'any')
//                         {
//                             tye_ret = data[4][loper].rem;
//                         }
//
//                         additional1 += '' +
//                             '                            <tr>\n' +
//                             '                                <td>'+data[4][loper].file+'</td>\n' +
//                             '                                <td>'+tye_ret+'</td>\n' +
//                             '                                <td>'+data[4][loper].date_time+'</td>\n' +
//                             '                                <td><button class="btn btn-xs btn-success download_additional_bi_file" id="'+data[0][0].id+'" name="'+data[4][loper].file+'"><i class="glyphicon glyphicon-download-alt"></i> Download</button></td>\n' +
//                             '<span id="dlfile"></span>' +
//                             '                            </tr>';
//                     }
//
//                     var fileAdd;
//
//                     if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder' )
//                     {
//                         fileAdd = '';
//                     }
//                     else if(data[5][0].name == 'B.I Client')
//                     {
//                         fileAdd = '<span id="check_requested">'+required_show+'</span><div class = "row" style = "padding-top : 15px; ">' +
//                             '<div class = "hideShowFac col-md-4" hidden></div>' +
//                             '<div class = "hideShowFac col-md-2" hidden>' +
//                             '<button class= "btn btn-xs btn-info" style = "width : 100%;" id = "clicktoChooseAdditional">' +
//                             '<i class = "glyphicon glyphicon-paperclip"></i> <span id = "fileStat">Choose a file</span> </button><input type="file" id = "chooseFileAdditionalBIFIle" style = "display : none">' +
//                             '</div>' +
//                             '<div class = "hideShowFac col-md-2" hidden>' +
//                             '<button class = "btn btn-xs btn-success" style = "width: 100%" id = "submitAdditionalFile" name = "'+id+'" disabled><i class = "glyphicon glyphicon-ok" ></i> Submit</button>' +
//                             '</div>' +
//                             '</div>' +
//                             '<div class = "hideBtntoAdd col-md-5"></div>' +
//                             '<div class = "hideBtntoAdd col-md-2"><buttton class = "btn btn-xs btn-primary" id = "showAddFac"><i class = "glyphicon glyphicon-plus"></i></buttton></div>' +
//                             '<div class = "hideBtntoAdd col-md-5"></div>' +
//                             '</div>' +
//                             '' +
//                             '<div class = "row" style = "padding-top : 10px; padding-bottom : 15px;" id = "loadingBarShow" hidden>\n' +
//                             '                                                <div class = "col-md-4"></div>\n' +
//                             '                                                <div class = "col-md-4">\n' +
//                             '                                                    <span id="ulPercentage_addFile">--</span>\n' +
//                             '                                                    <div id="progressbar_addFile" hidden></div>\n' +
//                             '                                                </div>\n' +
//                             '                                                <div class = "col-md-4"></div>\n' +
//                             '                                            </div>' +
//                             '';
//                     }
//
//
//                     tabletoShow = openinghead+headertableadd+additional1+closingtable+fileAdd;
//                 }
//                 else
//                 {
//                     if(data[5][0].name == 'CC Senior Account Officer' || data[5][0].name == 'CC Account Officer' || data[5][0].name == 'CC Tele Encoder')
//                     {
//                         tabletoShow = '<b>-----( NO ADDITIONAL FILE/S )-----</b>';
//                     }
//                     else if(data[5][0].name == 'B.I Client')
//                     {
//                         tabletoShow = '<span id="check_requested">'+required_show+'</span><div class = "row" style = "padding-top : 15px; ">' +
//                             '<div class = "hideShowFac col-md-4" hidden></div>' +
//                             '<div class = "hideShowFac col-md-2" hidden>' +
//                             '<button class= "btn btn-xs btn-info" style = "width : 100%;" id = "clicktoChooseAdditional">' +
//                             '<i class = "glyphicon glyphicon-paperclip"></i> <span id = "fileStat">Choose a file</span> </button><input type="file" id = "chooseFileAdditionalBIFIle" style = "display : none">' +
//                             '</div>' +
//                             '<div class = "hideShowFac col-md-2" hidden>' +
//                             '<button class = "btn btn-xs btn-success" style = "width: 100%" id = "submitAdditionalFile" name = "'+id+'" disabled><i class = "glyphicon glyphicon-ok" ></i> Submit</button>' +
//                             '</div>' +
//                             '</div>' +
//                             '<div class = "hideBtntoAdd col-md-5"></div>' +
//                             '<div class = "hideBtntoAdd col-md-2"><buttton class = "btn btn-xs btn-primary" id = "showAddFac"><i class = "glyphicon glyphicon-plus"></i></buttton></div>' +
//                             '<div class = "hideBtntoAdd col-md-5"></div>' +
//                             '</div>' +
//                             '' +
//                             '<div class = "row" style = "padding-top : 10px;" id = "loadingBarShow" hidden>\n' +
//                             '                                                <div class = "col-md-4"></div>\n' +
//                             '                                                <div class = "col-md-4">\n' +
//                             '                                                    <span id="ulPercentage_addFile">--</span>\n' +
//                             '                                                    <div id="progressbar_addFile" hidden></div>\n' +
//                             '                                                </div>\n' +
//                             '                                                <div class = "col-md-4"></div>\n' +
//                             '                                            </div>' +
//                             '';
//                     }
//                 }
//
//
//                 var co_borrower = '';
//                 var business =  '';
//                 var employer = '';
//
//                 if(data['tor_data'].length != 0)
//                 {
//                     if(data['tor'] == 'PDRN')
//                     {
//                         co_borrower+='                <tr class="bank_co_borrower" style="">\n' +
//                             '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">COBORROWER/S</td>\n' +
//                             '                </tr>\n' +
//                             '                <tr class="bank_co_borrower">\n' +
//                             '                  <td style="padding: 3px;">' +
//                             '                       <span class="badge bg-red">Name</span>' +
//                             '                  </td>\n' +
//                             '                  <td style="padding: 3px;">' +
//                             '                       <span class="badge bg-red">Relationship to Borrower</span>' +
//                             '                  </td>\n' +
//                             '                  <td style="padding: 3px;">' +
//                             '                       <span class="badge bg-red">Present Address</span>' +
//                             '                  </td>\n' +
//                             '                  <td style="padding: 3px;">' +
//                             '                       <span class="badge bg-red">Permanent Address</span>' +
//                             '                  </td>\n' +
//                             '                </tr>\n';
//
//                         for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
//                         {
//                             co_borrower+=                            '                <tr class="bank_co_borrower">\n' +
//                                 '                  <td style="padding: 3px;">' +
//                                 data['tor_data'][ctr].first_name +' '+ data['tor_data'][ctr].middle_name +' '+ data['tor_data'][ctr].last_name +
//                                 '                  </td>\n' +
//                                 '                  <td style="padding: 3px;">' +
//                                 data['tor_data'][ctr].relation + data['tor_data'][ctr].other_relation+
//                                 '                  </td>\n' +
//                                 '                  <td style="padding: 3px;">' +
//                                 data['tor_data'][ctr].pre_address +' '+data['tor_data'][ctr].pre_muni +' '+data['tor_data'][ctr].pre_prov +
//                                 '                  </td>\n' +
//                                 '                  <td style="padding: 3px;">' +
//                                 data['tor_data'][ctr].perma_address +' '+data['tor_data'][ctr].perma_muni +' '+data['tor_data'][ctr].perma_prov +
//                                 '                  </td>\n' +
//                                 '                </tr>\n';
//                         }
//                     }
//                     else if(data['tor'] == 'BVR')
//                     {
//                         business += '                <tr class="bank_businesses" style="">\n' +
//                             '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">BUSINESS/ES</td>\n' +
//                             '                </tr>\n' +
//                             '                <tr class="bank_businesses">\n' +
//                             '                  <td style="padding: 3px;" colspan="2">' +
//                             '                       <span class="badge bg-red">Business Name</span>' +
//                             '                  </td>\n' +
//                             '                  <td style="padding: 3px;" colspan="2">' +
//                             '                       <span class="badge bg-red">Business Address</span>' +
//                             '                  </td>\n' +
//                             '                </tr>\n';
//
//                         for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
//                         {
//                             business+= '                <tr class="bank_businesses">\n' +
//                                 '                  <td style="padding: 3px;" colspan="2">' +
//                                 data['tor_data'][ctr].name +
//                                 '                  </td>\n' +
//                                 '                  <td style="padding: 3px;" colspan="2">' +
//                                 data['tor_data'][ctr].address +' '+data['tor_data'][ctr].muni +' '+data['tor_data'][ctr].prov +
//                                 '                  </td>\n' +
//                                 '                </tr>\n';
//                         }
//                     }
//                     else if(data['tor'] == 'EVR')
//                     {
//                         employer +=                 '                <tr class="bank_employer" style="">\n' +
//                             '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">EMPLOYER</td>\n' +
//                             '                </tr>\n' +
//                             '                <tr class="bank_employer">\n' +
//                             '                  <td style="padding: 3px;" colspan="2">' +
//                             '                       <span class="badge bg-red">Employer Name</span>' +
//                             '                  </td>\n' +
//                             '                  <td style="padding: 3px;" colspan="2">' +
//                             '                       <span class="badge bg-red">Employer Address</span>' +
//                             '                  </td>\n' +
//                             '                </tr>\n';
//
//                         for(var ctr = 0; ctr<data['tor_data'].length; ctr++)
//                         {
//                             employer+= '                <tr class="bank_employer">\n' +
//                                 '                  <td style="padding: 3px;" colspan="2">' +
//                                 data['tor_data'][ctr].name +
//                                 '                  </td>\n' +
//                                 '                  <td style="padding: 3px;" colspan="2">' +
//                                 data['tor_data'][ctr].address +' '+data['tor_data'][ctr].muni +' '+data['tor_data'][ctr].prov +
//                                 '                  </td>\n' +
//                                 '                </tr>\n';
//                         }
//                     }
//                 }
//
//                 if(data[0][0].type_of_request == null)
//                 {
//                     $('#view_info_details').html
//                     (
//                         '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                         '                <tr>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +
//
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+status+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_muni+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_muni+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_province+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_province+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
//                         '                </tr>\n' +
//
//
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
//                         '                </tr>\n' +
//
//
//
//
//                         '                <tr class="hide_this" style="">\n' +
//                         '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
//                         '                </tr>\n' +
//                         co_borrower+
//                         business+
//                         employer+
//                         '              </table>'
//                     );
//                 }
//                 else if(data[0][0].type_of_request == '')
//                 {
//                     $('#view_info_details').html
//                     (
//                         '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                         '                <tr>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +
//                         '                </tr>\n' +
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +
//                         '                </tr>\n' +
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +
//
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+status+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_muni+'</td>\n' +
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_muni+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].present_province+'</td>\n' +
//
//
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].permanent_province+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
//                         '                </tr>\n' +
//
//
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF TAT</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_tat+'</td>\n' +
//                         '                </tr>\n' +
//
//
//
//
//                         '                <tr class="hide_this" style="">\n' +
//                         '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
//                         '                </tr>\n' +
//                         co_borrower+
//                         business+
//                         employer+
//                         '              </table>'
//                     );
//                 }
//                 else if(data[0][0].type_of_request != '')
//                 {
//                     $('#view_info_details').html
//                     (
//                         '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                         '                <tr>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PARTY #:</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].party_num+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">CONTRACT #:</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].contract_num+'</td>\n' +
//                         '                </tr>\n'+
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+status+'</td>\n' +
//                         '                </tr>\n' +
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="hide_this" style="">\n' +
//                         '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
//                         '                </tr>\n' +
//                         co_borrower+
//                         business+
//                         employer+
//                         '              </table>'
//                     );
//                 }
//                 else if(data[0][0].type_of_request != null)
//                 {
//                     $('#view_info_details').html
//                     (
//                         '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                         '                <tr>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
//                         '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">PARTY #:</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].party_num+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">CONTRACT #:</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].contract_num+'</td>\n' +
//                         '                </tr>\n'+
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+status+'</td>\n' +
//                         '                </tr>\n' +
//                         '                <tr class="for_bank">\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                         '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
//                         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr class="hide_this" style="">\n' +
//                         '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
//                         '                </tr>\n' +
//
//                         '                <tr>\n' +
//                         '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
//                         '                </tr>\n' +
//                         co_borrower+
//                         business+
//                         employer+
//                         '              </table>'
//                     );
//                 }
//                 // else if(data[0][0].type_of_request == null)
//                 // {
//                 //     $('#view_info_details').html
//                 //     (
//                 //         '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                 //         '                <tr>' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME ENDORSED</span></td>' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].date_time_endorsed+'</td>' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">DATE/TIME DUE</span></td>' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].date_time_due+'</td>' +
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">SITE NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].bi_account_name+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT FULL NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PROJECT/ACCOUNT/S</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].project+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">LAST NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].l_name+'</td>\n' +
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PACKAGE</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].package+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">FIRST NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].f_name+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">CHECKING/S</span></td>\n' +
//                 //         '                  <td style="padding: 3px;text-align: left;">'+checking+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">MIDDLE NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].m_name+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">LOB</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].lob+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">SUFFIX</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].suffix+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 1</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].attach_1+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">GENDER</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].gender+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 2</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].attach_2+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">MARITAL STATUS</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].marital_status+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 3</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].attach_3+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">BIRTHDAY(mm-dd-yyyy)</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].birth_month+'-'+data[0][0].birth_day+'-'+data[0][0].birth_year+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ATTACH 4</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].attach_4+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">AGE</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].age+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR/POC</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].endorser_poc+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">MAIDEN NAME</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].maiden_name+'</td>\n' +
//                 //
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+status+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT ADDRESS</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].present_address+'</td>\n' +
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT ADDRESS</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].permanent_address+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT MUNICIPALITY</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].present_muni+'</td>\n' +
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT MUNICIPALITY</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].permanent_muni+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PRESENT PROVINCE</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].present_province+'</td>\n' +
//                 //
//                 //
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">PERMANENT PROVINCE</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].permanent_province+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">OTHER ADDRESS/ES</span></td>\n' +
//                 //         '                  <td style="padding: 3px;text-align: left;">'+other_addresses+'</td>\n' +
//                 //         '                </tr>\n' +
//                 //
//                 //
//                 //
//                 //         '                <tr class="for_bank">\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF ENDORSEMENT</span></td>\n' +
//                 //         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].cc_bank_endorsement_type+'</td>\n' +
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr class="for_bank">\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].loan_type_bank+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">ENDORSEMENT TYPE</span></td>\n' +
//                 //         '                  <td style="padding: 3px;text-align: center;">'+data[0][0].type_of_endo+'</td>\n' +
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr class="for_bank">\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF VERIFICATION</span></td>\n' +
//                 //         '                  <td style="padding: 3px;">'+data[0][0].verify_through_bank+'</td>\n' +
//                 //         '                  <td style="padding: 3px;"><span class="badge bg-red">(AVAILABLE SLOT)</span></td>\n' +
//                 //         '                  <td style="padding: 3px;"></td>\n' +
//                 //         '                </tr>\n' +
//                 //
//                 //
//                 //
//                 //
//                 //         '                <tr class="hide_this" style="">\n' +
//                 //         '                  <td style="padding: 3px; background-color: brown; color: white" colspan="12">ADDITIONAL ATTACHMENT/S</td>\n' +
//                 //         '                </tr>\n' +
//                 //
//                 //         '                <tr>\n' +
//                 //         '                  <td style="padding: 3px;" colspan="12"><span id ="hide_this">'+tabletoShow+'</span></td>\n' +
//                 //         '                </tr>\n' +
//                 //         co_borrower+
//                 //         business+
//                 //         employer+
//                 //         '              </table>'
//                 //     );
//                 // }
//
//
//
//                 // if(data[0][0].type_of_request == '')
//                 // {
//                 //     $('.for_bank').remove();
//                 // }
//
//                  
                // $('#view_info_account_logs').html
                // (
                //     '<tr style="background-color: brown; color: white">' +
                //     '<th style=\'text-align: center;\'>USER</th>' +
                //     '<th style=\'text-align: center;\'>POSITION</th>' +
                //     '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                //     '<th style=\'text-align: center;\'>REMARKS</th>' +
                //     '<th style=\'text-align: center;\'>DATE/TIME OCCURED</th>' +
                //     '</tr>'
                // );
//
//                 for(var qq = 0;qq <= (data[2].length)-1;qq++)
//                 {
//                     if(data[2][qq].position_name === 'OIMS Auto Generated')
//                     {
//                         $('#view_info_account_logs').append
//                         (
//                             '<tr>' +
//                             '<td style="padding: 3px;">OIMS Notification</td>' +
//                             '<td style="padding: 3px;">' + data[2][qq].position_name + '</td>' +
//                             '<td style="padding: 3px;">' + data[2][qq].activity + '</td>' +
//                             '<td style="padding: 3px;">' + data[2][qq].remarks + '</td>' +
//                             '<td style="padding: 3px;">' + data[2][qq].date_time + '</td>' +
//                             '</tr>'
//                         )
//                     }
//                     else
//                     {
//                         $('#view_info_account_logs').append
//                         (
//                             '<tr>' +
//                             '<td style="padding: 3px;">' +data[2][qq].user_name + '</td>' +
//                             '<td style="padding: 3px;">' +data[2][qq].position_name + '</td>' +
//                             '<td style="padding: 3px;">' +data[2][qq].activity + '</td>' +
//                             '<td style="padding: 3px;">' +data[2][qq].remarks + '</td>' +
//                             '<td style="padding: 3px;">' +data[2][qq].date_time + '</td>' +
//                             '</tr>'
//                         );
//                     }
//
//                 }
//             },
//             complete: function()
//             {
//                 $('.download_additional_bi_file').click(function()
//                 {
//                     var dl_id = $(this).attr('id');
//                     var path = $(this).attr('name');
//
//                     var id_encode = btoa(dl_id);
//                     var path_encode = btoa(path);
//                     var q = '<form action="/bi-view-info-dl" target="_blank" method="get">'+
//                         '<div class="input-group">'+
//                         '<input type="text" hidden value="'+id_encode+'|'+path_encode+'" name="id">'+
//                         '<button type="submit" hidden id="button_bi_attached_dl" >'+
//                         '</button>'+
//                         '</span>'+
//                         '</div>'+
//                         '</form>';
//
//                     $('#dlfile').html(q);
//                     $('#button_bi_attached_dl').click();
//                     $('#dlfile').hide();
//                 });
//
//                 $('#toggleSeeRemarks').click(function()
//                 {
//                     $('#thisisRemarks').toggle(200);
//                     if(counterShowHide %2 == 0)
//                     {
//                         $('#this_isSpan').html('<i class="glyphicon glyphicon-chevron-up"></i>');
//                     }
//                     else
//                     {
//                         $('#this_isSpan').html('<i class="glyphicon glyphicon-chevron-down"></i>')
//                     }
//
//                     counterShowHide++;
//                 });
//             },
//             error : function (e) {
//                 console.log(e);
//             }
//
//         });
//         // download_bi_files_123123123(id,name);
//     })
//
//
//
// });

// $(document).on('click', '.download_additional_bi_file', function()
// {
//     var button_id = $(this).attr("name");
//     $('#row_other_check'+button_id+'').remove();
//
// });



function download_bi_files_123123123(id, name) {

    var id = btoa(id);
    var name = btoa(name);
    // var token_token = btoa(token);

    var q = '<form action="/bi_download_files_universal" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id+'" name="id">'+
        '<input type="text" hidden value="'+name+'" name="name">'+
        // '<input type="text" hidden value="'+token_token+'" name="token">'+
        '<button type="submit" id="button_form_download_123123123123123">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#download_bi_files_123123123123').html(q);
    // $('#button_form_download').click(function (e) {
    //     e.preventDefault();
    // });
    $('#button_form_download_123123123123123').click();
    // window.open('/ao-download-file', '_blank');
    // window.location = '/ao-panel';
}



