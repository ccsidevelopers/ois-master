<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Added imports
use DB;
use Carbon\Carbon;

class LoanFormController extends Controller
{
    public function kiosk_create(Request $request) {
        $kiosk_create = DB::table('kiosk_loan_applicants')
            ->insert([
                'type_of_loan' => $request->type_of_loan,
                'applicant_lname' => $request->applicant_lname,
                'applicant_fname' => $request->applicant_fname,
                'applicant_mname' => $request->applicant_mname,
                'applicant_suffix' => $request->applicant_suffix,
                'personal_mobile_number' => $request->personal_mobile_number,
                'personal_email_address' => $request->personal_email_address,
                'home_landline_number' => $request->home_landline_number,
                'pre_unit_number_bld_st_subd_brgy' => $request->pre_unit_number_bld_st_subd_brgy,
                'pre_city_municipality' => $request->pre_city_municipality,
                'pre_province' => $request->pre_province,
                'per_unit_number_bld_st_subd_brgy' => $request->per_unit_number_bld_st_subd_brgy,
                'per_city_municipality' => $request->per_city_municipality,
                'per_province' => $request->per_province,
                'work_email_address' => $request->work_email_address,
                'work_landline_number' => $request->work_landline_number,
                'work_unit_number_bld_st_subd_brgy' => $request->work_unit_number_bld_st_subd_brgy,
                'work_city_municipality' => $request->work_city_municipality,
                'work_province' => $request->work_province,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'citizenship' => $request->citizenship,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'home_ownership' => $request->home_ownership,
                'sss_gsis_number' => $request->sss_gsis_number,
                'tin_number' => $request->tin_number,
                'spouse_lname' => $request->spouse_lname,
                'spouse_fname' => $request->spouse_fname,
                'spouse_mname' => $request->spouse_mname,
                'spouse_suffix' => $request->spouse_suffix,
                'mothers_maiden_lname' => $request->mothers_maiden_lname,
                'mothers_maiden_fname' => $request->mothers_maiden_fname,
                'mothers_maiden_mname' => $request->mothers_maiden_mname,
                'source_of_income' => $request->source_of_income,
                'employment_status' => $request->employment_status,
                'mothers_maiden_lname' => $request->mothers_maiden_lname,
                'for_employed' => $request->for_employed,
                'for_self_employed' => $request->for_self_employed,
                'name_of_employer_business' => $request->name_of_employer_business,
                'job_title_position' => $request->job_title_position,
                'nature_of_business' => $request->nature_of_business,
                'gross_annual_income' => $request->gross_annual_income,
                'years_with_employer_in_business' => $request->years_with_employer_in_business,
                'months_with_employer_in_business' => $request->months_with_employer_in_business,
                'created_at' => Carbon::now('Asia/Manila'),
            ]);
    }
}
