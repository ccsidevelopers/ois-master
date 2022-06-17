<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KioskEndorsement extends Model
{
    protected $table = 'kiosk_endorsements';
    protected $fillable = [
        'applicant_lname',
        'applicant_fname',
        'applicant_mname',
        'applicant_suffix',
        'personal_mobile_number',
        'personal_email_address',
        'home_landline_number',
        'work_email_address',
        'work_landline_number',
        'birth_date',
        'birth_place',
        'citizenship',
        'gender',
        'civil_status',
        'home_ownership',
        'sss_gsis_number',
        'tin_number',
        'spouse_lname',
        'spouse_fname',
        'spouse_mname',
        'spouse_suffix',
        'mothers_maiden_lname',
        'mothers_maiden_fname',
        'mothers_maiden_mname',
        'source_of_income',
        'employment_status',
        'for_employed',
        'for_self_employed',
        'name_of_employer_business',
        'job_title_position',
        'nature_of_business',
        'gross_annual_income',
        'years_with_employer_in_business',
        'months_with_employer_in_business',
        'uploaded_file_path',
    ];
}
