<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KioskEndorsement;
use App\KioskEndorsementAddress;
use App\KioskEndorsementLoanType;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class KioskEndorsementController extends Controller
{
    public function index() {
        $kiosk_endorsements = KioskEndorsement::all();

        return view('kiosk_loan.loan-form');
    }

    public function store(Request $req)
    {   
        
        // $validated = $req->validate([
        //     'applicant_lname' => 'required|max:255',
        //     'applicant_fname' => 'required|max:255',
        //     'applicant_mname' => 'required|max:255',
        //     'applicant_suffix' => 'required|max:255',
        //     'personal_mobile_number' => 'required|max:255',
        //     'personal_email_address' => 'required|max:255',
        //     'home_landline_number' => 'required|max:255',
        //     'work_email_address' => 'required|max:255',
        //     'work_landline_number' => 'required|max:255',
        //     'birth_date' => 'required|max:255',
        //     'birth_place' => 'required|max:255',
        //     'citizenship' => 'required|max:255',
        //     'gender' => 'required',
        //     'civil_status' => 'required|max:255',
        //     'home_ownership' => 'required|max:255',
        //     'sss_gsis_number' => 'required|max:255|unique:endorsements|integer',
        //     'tin_number' => 'required|max:255|unique:endorsements|integer',
        //     'spouse_lname' => 'max:255',
        //     'spouse_fname' => 'max:255',
        //     'spouse_mname' => 'max:255',
        //     'spouse_suffix' => 'max:255',
        //     'mothers_maiden_lname' => 'required|max:255',
        //     'mothers_maiden_fname' => 'required|max:255',
        //     'mothers_maiden_mname' => 'required|max:255',
        //     'source_of_income' => 'required|max:255',
        //     'employment_status' => 'required|max:255',
        //     'for_employed' => 'required|max:255',
        //     'for_self_employed' => 'required|max:255',
        //     'name_of_employer_business' => 'required|max:255',
        //     'job_title_position' => 'required|max:255',
        //     'nature_of_business' => 'required|max:255',
        //     'gross_annual_income' => 'required|max:255',
        //     'years_with_employer_in_business' => 'required|max:255|integer',
        //     'months_with_employer_in_business' => 'required|max:255|integer'
        // ]);

        $kiosk_endorsements = new KioskEndorsement;
        $kiosk_endorsements->applicant_lname = $req->applicant_lname;
        $kiosk_endorsements->applicant_fname = $req->applicant_fname;
        $kiosk_endorsements->applicant_mname = $req->applicant_mname;
        $kiosk_endorsements->applicant_suffix = $req->applicant_suffix;
        $kiosk_endorsements->personal_mobile_number = $req->personal_mobile_number;
        $kiosk_endorsements->personal_email_address = $req->personal_email_address;
        $kiosk_endorsements->home_landline_number = $req->home_landline_number;
        $kiosk_endorsements->work_email_address = $req->work_email_address;
        $kiosk_endorsements->work_landline_number = $req->work_landline_number;
        $kiosk_endorsements->birth_date = $req->birth_date;
        $kiosk_endorsements->birth_place = $req->birth_place;
        $kiosk_endorsements->citizenship = $req->citizenship;
        $kiosk_endorsements->gender = $req->gender;
        $kiosk_endorsements->civil_status = $req->civil_status;
        $kiosk_endorsements->home_ownership = $req->home_ownership;
        $kiosk_endorsements->sss_gsis_number = $req->sss_gsis_number;
        $kiosk_endorsements->tin_number = $req->tin_number;
        $kiosk_endorsements->spouse_lname = $req->spouse_lname;
        $kiosk_endorsements->spouse_fname = $req->spouse_fname;
        $kiosk_endorsements->spouse_mname = $req->spouse_mname;
        $kiosk_endorsements->spouse_suffix = $req->spouse_suffix;
        $kiosk_endorsements->mothers_maiden_lname = $req->mothers_maiden_lname;
        $kiosk_endorsements->mothers_maiden_fname = $req->mothers_maiden_fname;
        $kiosk_endorsements->mothers_maiden_mname = $req->mothers_maiden_mname;
        $kiosk_endorsements->source_of_income = $req->source_of_income;
        $kiosk_endorsements->employment_status = $req->employment_status;
        $kiosk_endorsements->for_employed = $req->for_employed;
        $kiosk_endorsements->for_self_employed = $req->for_self_employed;
        $kiosk_endorsements->name_of_employer_business = $req->name_of_employer_business;
        $kiosk_endorsements->job_title_position = $req->job_title_position;
        $kiosk_endorsements->nature_of_business = $req->nature_of_business;
        $kiosk_endorsements->gross_annual_income = $req->gross_annual_income;
        $kiosk_endorsements->years_with_employer_in_business = $req->years_with_employer_in_business;
        $kiosk_endorsements->months_with_employer_in_business = $req->months_with_employer_in_business;
        $kiosk_endorsements->uploaded_file_path = 'public/images/';
        $kiosk_endorsements->save();

        if ($req->hasFile('file')) {
            $fileUploaded = request()->file('file');
            $fileDate = Carbon::now()->format('y-m-d-h-m');
            $fileName = $kiosk_endorsements->id . '-' . $fileUploaded->getClientOriginalName();
            $filePath = public_path('/images');
            $fileUploaded->move(storage_path('images'), $fileName);
        }

        $kiosk_endorsements->uploaded_file_path = 'public/images/' . $fileName;
        $kiosk_endorsements->save();

        // Get different address type inputs
        $kiosk_endorsements_address = new KioskEndorsementAddress;
        $kiosk_endorsements_address->kiosk_endorsement_id = $kiosk_endorsements->id;
        $kiosk_endorsements_address->unit_number_bld_st_subd_brgy = $req->present_address_1;
        $kiosk_endorsements_address->city_municipality = $req->present_address_2;
        $kiosk_endorsements_address->province = $req->present_address_3;
        $kiosk_endorsements_address->address_type = 'present';
        $kiosk_endorsements_address->save();

        $kiosk_endorsements_address = new KioskEndorsementAddress;
        $kiosk_endorsements_address->kiosk_endorsement_id = $kiosk_endorsements->id;
        $kiosk_endorsements_address->unit_number_bld_st_subd_brgy = $req->permanent_address_1;
        $kiosk_endorsements_address->city_municipality = $req->permanent_address_2;
        $kiosk_endorsements_address->province = $req->permanent_address_3;
        $kiosk_endorsements_address->address_type = 'permanent';
        $kiosk_endorsements_address->save();

        $kiosk_endorsements_address = new KioskEndorsementAddress;
        $kiosk_endorsements_address->kiosk_endorsement_id = $kiosk_endorsements->id;
        $kiosk_endorsements_address->unit_number_bld_st_subd_brgy = $req->work_address_1;
        $kiosk_endorsements_address->city_municipality = $req->work_address_2;
        $kiosk_endorsements_address->province = $req->work_address_3;
        $kiosk_endorsements_address->address_type = 'work';
        $kiosk_endorsements_address->save();

        // Get type of loan selected inputs
        $kiosk_endorsements_type_of_loans = new KioskEndorsementLoanType;
        $kiosk_endorsements_type_of_loans->kiosk_endorsement_id = $kiosk_endorsements->id;
        $kiosk_endorsements_type_of_loans->motorcycle_loan = $req->motorcycle_loan;
        $kiosk_endorsements_type_of_loans->personal_salary_loan = $req->personal_salary_loan;
        $kiosk_endorsements_type_of_loans->auto_loan = $req->auto_loan;
        $kiosk_endorsements_type_of_loans->home_house_loan = $req->home_house_loan;
        $kiosk_endorsements_type_of_loans->save();

        return redirect('/loan-form');
    }

    public function destroy($id)
    {
        // $endorsements = Endorsement::find($id)->delete();

        // return redirect('/home');
    }

    public function show()
    {
        // $endorsements = Endorsement::find($id)->get();

        // return view('show');
    }

    public function approve($id)
    {
        // $endorsements = Endorsement::find($id)->get();

        // Take all data from kiosk endorsements DB
        // return DB::table('endorsements')
        // ->get()
        // ->where('id', $id);

        // Take all data from ois endorsements DB
        // return DB::connection('mysql_oims')
        // ->table('endorsements')
        // ->take(5)
        // ->get()
        // ->insert([
        //     ['id' => $endorsements->id]
        // ]);
    }
}
