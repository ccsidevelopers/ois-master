<?php

namespace App\Http\Controllers;

use App\Generals\AuditFundQueries;
use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\Municipality;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\handler;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;

class DirectEncodeController extends Controller
{
    public function direct_encode_inputs(Request $request)
    {
        $arrayInputs = json_decode($request->arrayToSend);
        $arrayPlus = json_decode($request->plusArrays);
        $benefitsArr = json_decode($request->benefitsArray);

        $persoal_email_address = $request->personal_email;

        $CurDate = Carbon::now('Asia/Manila');
        $date_time = explode(' ', $CurDate);
        $date = explode('-', $date_time[0]);
        $time = explode(':', $date_time[1]);
        $randoString = $date[0].$date[1].$date[2].'-'.strtoupper(Str::random(5)).'-'.$time[0].$time[1].$time[2] . '-' . strtoupper($arrayInputs[0]);


        $getBIid = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->select([
                'bi_account_to_users.bi_account_id as bi_id'
            ])
            ->where('users.id', $request->site_id_new)
            ->where('bi_account_to_users.to_display', 'display')
            ->get();

        $getId = DB::table('bi_direct_applicant_endorsement')
            ->insertGetId
            ([
                'direct_personal_email' => $persoal_email_address,
                'direct_last_name' => $arrayInputs[0],
                'direct_first_name' => $arrayInputs[1],
                'direct_middle_name' => $arrayInputs[2],
                'direct_suffix_name' => $arrayInputs[3],
                'direct_birthdate' => $arrayInputs[4],
                'direct_age' => $arrayInputs[5],
                'direct_gender' => $arrayInputs[6],
                'direct_marital_status' => $arrayInputs[7],
                'direct_maiden_last' => $arrayInputs[8],
                'direct_maiden_first' => $arrayInputs[9],
                'direct_maiden_middle' => $arrayInputs[10],
                'direct_sss' => $arrayInputs[11],
                'direct_tel_cp' => $arrayInputs[12],
                'direct_present_muni' => $arrayInputs[14],
                'direct_present_prov' => $arrayInputs[13],
                'direct_present_address' => $arrayInputs[15],
                'direct_perma_muni' => $arrayInputs[17],
                'direct_perma_prov' => $arrayInputs[16],
                'direct_perma_address' => $arrayInputs[18],
                'direct_spouse_name' => $arrayInputs[19],
                'direct_spouse_tel_cp' => $arrayInputs[20],
                'direct_father_name' => $arrayInputs[21],
                'direct_father_age' => $arrayInputs[22],
                'direct_father_occupation' => $arrayInputs[23],
                'direct_father_tel' => $arrayInputs[24],
                'direct_mother_name' => $arrayInputs[25],
                'direct_mother_age' => $arrayInputs[26],
                'direct_mother_occupation' => $arrayInputs[27],
                'direct_mother_tel' => $arrayInputs[28],
                'direct_secondary_school' => $arrayInputs[29],
                'direct_secondary_location' => $arrayInputs[30],
                'direct_secondary_inclusive' => $arrayInputs[31],
                'direct_secondary_year_graduated' => $arrayInputs[32],
                'direct_college_school' => $arrayInputs[33],
                'direct_college_location' => $arrayInputs[34],
                'direct_college_inclusive' => $arrayInputs[35],
                'direct_college_year_graduated' => $arrayInputs[36],
                // 'direct_course_taken' => $request->direct_course_taken,
                // 'direct_stopped_graduated_rem' => $request->direct_stopped_graduated_rem,
                'direct_other_schools' => $arrayInputs[37],
                'direct_civil_service' => $arrayInputs[38],
                'direct_dismissed' => $arrayInputs[39],
                'direct_dismissed_reason' => $arrayInputs[40],
                'generated_code' => $randoString,
                'applicant_status' => 'Pending',
                'created_at' => Carbon::now('Asia/Manila'),
            ]);

        if($request->qualCheck == 'yes')
        {
            DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getId)
                ->update
                ([
                    'direct_tin' => $benefitsArr[0],
                    'direct_philhealth' => $benefitsArr[1],
                    'direct_pagibig' => $benefitsArr[1],
                ]);
        }



        if(count($arrayPlus[0]) > 0)
        {
            for($c = 0; $c < count($arrayPlus[0]); $c++)
            {
                DB::table('bi_direct_applicant_addresses')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'inclusive_dates' => $arrayPlus[0][$c][0],
                        'address' => $arrayPlus[0][$c][1],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        if(count($arrayPlus[1]) > 0)
        {
            for($d = 0; $d < count($arrayPlus[1]); $d++)
            {
                $started = '';
                $ended = '';

                if($arrayPlus[1][$d][0] == '')
                {
                    $started = '';
                }
                else
                {
                    $started = $arrayPlus[1][$d][0];
                }

                if($arrayPlus[1][$d][1] == '')
                {
                    $ended = '';
                }
                else
                {
                    $ended = $arrayPlus[1][$d][1];
                }


                DB::table('bi_direct_applicant_experience')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'date_started' => $started,
                        'date_ended' => $ended,
                        'date_ended_present' => $arrayPlus[1][$d][2],
                        'employer_name' => $arrayPlus[1][$d][3],
                        'position' => $arrayPlus[1][$d][4],
                        'emp_no' => $arrayPlus[1][$d][5],
                        'emp_address' => $arrayPlus[1][$d][6],
                        'emp_contact_no' => $arrayPlus[1][$d][7],
                        'supervisor_name' => $arrayPlus[1][$d][8],
                        'supervisor_number' => $arrayPlus[1][$d][9],
                        'reason_leaving' => $arrayPlus[1][$d][10],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        if(count($arrayPlus[2]) > 0)
        {
            for($e = 0; $e < count($arrayPlus[2]); $e++)
            {
                DB::table('bi_direct_applicant_character')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'charac_name' => $arrayPlus[2][$e][0],
                        'charac_position' => $arrayPlus[2][$e][1],
                        'charac_address' => $arrayPlus[2][$e][2],
                        'charac_email' => $arrayPlus[2][$e][3],
                        'charac_contact' => $arrayPlus[2][$e][4],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        if(count($arrayPlus[3]) > 0)
        {
            for($f = 0; $f < count($arrayPlus[3]); $f++)
            {
                DB::table('bi_direct_applicant_organizations')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'org_name' => $arrayPlus[3][$f][0],
                        'org_date' => $arrayPlus[3][$f][1],
                        'org_pos' => $arrayPlus[3][$f][2],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        if(count($arrayPlus[4]) > 0)
        {
            for($g = 0; $g < count($arrayPlus[4]); $g++)
            {
                DB::table('bi_direct_applicant_trainings')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'train_title' => $arrayPlus[4][$g][0],
                        'train_conducted' => $arrayPlus[4][$g][1],
                        'train_year' => $arrayPlus[4][$g][2],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

//        if(count($arrayPlus[5]) > 0)
//        {
//            for($h = 0; $h < count($arrayPlus[5]); $h++)
//            {
//                DB::table('bi_direct_applicant_credit_card')
//                    ->insert
//                    ([
//                        'direct_id' => $getId,
//                        'credit_name' => $arrayPlus[5][$h][0],
//                        'credit_number' => $arrayPlus[5][$h][1],
//                        'credit_limit' => $arrayPlus[5][$h][2],
//                        'credit_expiry' => $arrayPlus[5][$h][3],
//                        'created_at' => Carbon::now('Asia/Manila')
//                    ]);
//            }
//        }

        $file1 = $request->file('file_1');
        $file2 = $request->file('file_2');
        $file3 = $request->file('file_3');
        $file4 = $request->file('file_4');
//        $img = $request->file('image_file');


        $getData = DB::table('bi_direct_applicant_endorsement')
            ->where('id', $getId)
            ->select('direct_attach_1','direct_attach_2','direct_attach_3','direct_attach_4')
            ->get();

        $count = 1;
        if($file1 != null)
        {
            $file_name1 = $file1->getClientOriginalName();

            if($file_name1 == $getData[0]->direct_attach_2)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $getData[0]->direct_attach_3)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $getData[0]->direct_attach_4)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            $file1->move(storage_path('direct_bi_attachment/' .$getBIid[0]->bi_id .'/' .$getId.'/'),$file_name1);

            DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getId)
                ->update
                ([
                    'direct_attach_1' => $file_name1
                ]);

        }

        if($file2 != null)
        {
            $file_name2 = $file2->getClientOriginalName();

            if($file_name2 == $getData[0]->direct_attach_1)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $getData[0]->direct_attach_3)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $getData[0]->direct_attach_4)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            $file2->move(storage_path('direct_bi_attachment/' . $getBIid[0]->bi_id . '/' .$getId.'/'),$file_name2);

            DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getId)
                ->update
                ([
                    'direct_attach_2' => $file_name2
                ]);
        }

        if($file3 != null)
        {
            $file_name3 = $file3->getClientOriginalName();

            if($file_name3 == $getData[0]->direct_attach_1)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $getData[0]->direct_attach_2)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $getData[0]->direct_attach_4)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            $file3->move(storage_path('direct_bi_attachment/'  .$getBIid[0]->bi_id . '/' .$getId.'/'),$file_name3);

            DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getId)
                ->update
                ([
                    'direct_attach_3' => $file_name3
                ]);
        }

        if($file4 != null)
        {
            $file_name4 = $file4->getClientOriginalName();

            if($file_name4 == $getData[0]->direct_attach_1)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $getData[0]->direct_attach_2)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $getData[0]->direct_attach_4)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            $file4->move(storage_path('direct_bi_attachment/' . $getBIid[0]->bi_id . '/' .$getId.'/'),$file_name4);

            DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getId)
                ->update
                ([
                    'direct_attach_4' => $file_name4
                ]);
        }

//        if($img != null)
//        {
//            $prof_data =  $getBIid[0]->bi_id . '/' .$getId.'/' . $img->getClientOriginalName();
//
//
//            $img->move(storage_path('direct_applicant_prof_pic/' . $getBIid[0]->bi_id . '/' .$getId.'/'), $img->getClientOriginalName());
//
//            DB::table('bi_direct_applicant_endorsement')
//                ->where('id', $getId)
//                ->update
//                ([
//                    'direct_profile_pic' => $prof_data
//                ]);
//        }

        $fileCount = $request->count_additional_files;

        if($fileCount > 0)
        {
            for ($i = 0; $i < $fileCount; $i++)
            {
                $file = $request->file('additionalfile-' . $i . '');

                $name = $file->getClientOriginalName();
                $file->move(storage_path('/direct_additional_files/' . $getBIid[0]->bi_id . '/' . $getId), $name);
                $path = '/direct_additional_files/' . $getBIid[0]->bi_id . '/'. $getId . '/' . $name;

                DB::table('bi_direct_applicant_additional_files')
                    ->insert
                    ([
                        'direct_id' => $getId,
                        'file_path' => $path,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }

        }

        $getPivotID = DB::table('bi_direct_pivot')
            ->insertGetId
            ([
                'direct_to_get_id' => $getId,
                'direct_name' => strtoupper($arrayInputs[0] . ', '. $arrayInputs[1] . ' ' . $arrayInputs[2]),
                'direct_type' => 'direct_applicant',
                'direct_status' => '0',
                'application_status' => 'Pending',
                'direct_course_taken' => $request->direct_course_taken,
                'direct_stopped_graduated_rem' => $request->direct_stopped_graduated_rem,
                'created_at' => Carbon::now('Asia/Manila')
            ]);


        if($request->qualCheck == 'yes')
        {
            $dateShuffle = str_replace([' ',':','-'], '', Carbon::now('Asia/Manila')) . '-Auth-' . strtoupper($arrayInputs[0]);

            $data = ['content' => $request->htmlElements];

            $pdf = PDF::loadView('DirectApplicantAuthorizationLetterToPDF', $data)->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])->setPaper('letter', 'portrait');

            if(!File::exists(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id)))
            {
                File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id));

                if(!File::exists(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id. '/'. $getPivotID)))
                {
                    File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id. '/'. $getPivotID));
                    $pdf->save(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id.'/'. $getPivotID. '/'.$dateShuffle.'.pdf'));
                }
            }
            else
            {
                if(!File::exists(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id. '/'. $getPivotID)))
                {
                    File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id. '/'. $getPivotID));
                    $pdf->save(storage_path('direct_applicant_auth_letter/'.$getBIid[0]->bi_id.'/'. $getPivotID. '/'.$dateShuffle.'.pdf'));
                }
            }

            DB::table('bi_direct_pivot')
                ->where('id', $getPivotID)
                ->update
                ([
                    'bi_id' => $getBIid[0]->bi_id,
                    'declaration_path' => '/'.$dateShuffle.'.pdf'
                ]);
        }
        else if($request->qualCheck == 'no')
        {
                $dateShuffle = str_replace([' ',':','-'], '', Carbon::now('Asia/Manila')) . '-Auth-' . strtoupper($arrayInputs[0]);

                $data = ['content' => $request->htmlElements];

                $pdf = PDF::loadView('DirectApplicantAuthorizationLetterToPDF', $data)->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])->setPaper('letter', 'portrait');

                if(!File::exists(storage_path('direct_applicant_auth_letter/'.$request->site_id)))
                {
                    File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$request->site_id));

                    if(!File::exists(storage_path('direct_applicant_auth_letter/'.$request->site_id. '/'. $getPivotID)))
                    {
                        File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$request->site_id. '/'. $getPivotID));
                        $pdf->save(storage_path('direct_applicant_auth_letter/'.$request->site_id.'/'. $getPivotID. '/'.$dateShuffle.'.pdf'));
                    }
                }
                else
                {
                    if(!File::exists(storage_path('direct_applicant_auth_letter/'.$request->site_id. '/'. $getPivotID)))
                    {
                        File::makeDirectory(storage_path('direct_applicant_auth_letter/'.$request->site_id. '/'. $getPivotID));
                        $pdf->save(storage_path('direct_applicant_auth_letter/'.$request->site_id.'/'. $getPivotID. '/'.$dateShuffle.'.pdf'));
                    }
                }

                DB::table('bi_direct_pivot')
                    ->where('id', $getPivotID)
                    ->update
                    ([
                        'bi_id' => $request->site_id,
                        'declaration_path' => '/'.$dateShuffle.'.pdf'
                    ]);
        }

        DB::table('bi_direct_application_logs')
            ->insert
            ([
                'direct_piv_id' => $getPivotID,
                'user_id' => strtoupper($arrayInputs[1] . ' '. $arrayInputs[0]),
                'activity' => 'SUBMITTED THE APPLICATION',
                'remarks' => '-',
                'created_at' => Carbon::now('Asia/Manila')
            ]);


        $email = new EmailQueries();


        $email->sendEmailToClientForNewDirect
        (
            $getBIid[0]->bi_id,
            strtoupper($arrayInputs[0] . ', '. $arrayInputs[1] . ' ' . $arrayInputs[2]),
            $arrayInputs[5],
            $arrayInputs[6],
            $arrayInputs[7],
            $arrayInputs[15],
            $arrayInputs[17],
            $persoal_email_address,
            $randoString
            );

        $email->sendEmailToApplicantForNewDirect
        (
            $arrayInputs[1] . ' '. $arrayInputs[0],
            $persoal_email_address,
            $randoString,
            $request->site_id_new
        );


        return $randoString;
    }

    public function direct_applicant_search_application_tracking(Request $request)
    
    {

        $getData = DB::table('bi_direct_pivot')
            ->join('bi_direct_applicant_endorsement', 'bi_direct_applicant_endorsement.id', '=', 'bi_direct_pivot.direct_to_get_id')
            ->join('municipalities', 'municipalities.id', '=', 'bi_direct_applicant_endorsement.direct_present_muni')
            ->select
            ([
                'bi_direct_pivot.application_status as status',
                'bi_direct_pivot.bi_id as site_id',
                'bi_direct_applicant_endorsement.id as id',
                'bi_direct_applicant_endorsement.direct_last_name as lname',
                'bi_direct_applicant_endorsement.direct_first_name as fname',
                'bi_direct_applicant_endorsement.direct_middle_name as mname',
                'bi_direct_applicant_endorsement.direct_suffix_name as sname',
                'bi_direct_applicant_endorsement.direct_present_address as address',
                'bi_direct_applicant_endorsement.direct_secondary_school as direct_secondary_school',
                'bi_direct_applicant_endorsement.direct_secondary_location as direct_secondary_location',
                'bi_direct_applicant_endorsement.direct_secondary_inclusive as direct_secondary_inclusive',
                'bi_direct_applicant_endorsement.direct_secondary_year_graduated as direct_secondary_year_graduated',
                'bi_direct_applicant_endorsement.direct_college_school as direct_college_school',
                'bi_direct_applicant_endorsement.direct_college_location as direct_college_location',
                'bi_direct_applicant_endorsement.direct_college_inclusive as direct_college_inclusive',
                'bi_direct_applicant_endorsement.direct_college_year_graduated as direct_college_year_graduated',
                'bi_direct_applicant_endorsement.direct_other_schools as direct_other_schools',
                'bi_direct_applicant_endorsement.direct_civil_service as direct_civil_service',
                'municipalities.muni_name as muni'
            ])
            ->where('bi_direct_applicant_endorsement.generated_code', strtoupper($request->track_id))
            ->get();

//        $getData = DB::table('bi_direct_applicant_endorsement')
//            ->join('municipalities', 'municipalities.id', '=', 'bi_direct_applicant_endorsement.direct_present_muni')
//            ->select
//            ([
//                'bi_direct_applicant_endorsement.applicant_status as status',
//                'bi_direct_applicant_endorsement.direct_last_name as lname',
//                'bi_direct_applicant_endorsement.direct_first_name as fname',
//                'bi_direct_applicant_endorsement.direct_middle_name as mname',
//                'bi_direct_applicant_endorsement.direct_suffix_name as sname',
//                'bi_direct_applicant_endorsement.direct_present_address as address',
//                'municipalities.muni_name as muni'
//            ])
//            ->where('bi_direct_applicant_endorsement.generated_code', strtoupper($request->track_id))
//            ->get();

        return response()->json($getData);
    }

    public function direct_applicant_get_user_list(Request $request)
    {
        $getInfoList = DB::table('bi_users_under_location')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_users_under_location.bi_site')
            ->select
            ([
                'bi_account_list.id as id',
                'bi_account_list.bi_account_name as name',
                'bi_account_list.account_location as loc',
            ])
            ->where('bi_users_under_location.bi_id', $request->id)
            ->get();

        return response()->json($getInfoList);


    }
    
    public function bi_direct_upload_additional_from_return(Request $request)
    {
        for($i = 1; $i <= 4; $i++)
        {
            $file = $request->file('file_' . $i);
            if($file != null)
            {
                $name = $file->getClientOriginalName();
                $file->move(storage_path('/direct_additional_files/' . $request->site_id . '/' . $request->bi_direct_id), str_replace("Ñ","N",$name));
                $path = '/direct_additional_files/' . $request->site_id . '/'. $request->bi_direct_id . '/' . str_replace("Ñ","N",$name);

                DB::table('bi_direct_applicant_additional_files')
                    ->insert
                    ([
                        'direct_id' => $request->bi_direct_id,
                        'file_path' => $path,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        DB::table('bi_direct_pivot')
            ->where('direct_to_get_id', '=', $request->bi_direct_id)
            ->update([
                'application_status' => 'Returned Pending'
            ]);

        DB::table('bi_direct_applicant_endorsement')
            ->where('id', $request->bi_direct_id)
            ->update([
                'direct_secondary_school' => $request->direct_secondary_school,
                'direct_secondary_location' => $request->direct_secondary_location,
                'direct_secondary_inclusive' => $request->direct_secondary_inclusive,
                'direct_secondary_year_graduated' => $request->direct_secondary_year_graduated,
                'direct_college_school' => $request->direct_college_school,
                'direct_college_location' => $request->direct_college_location,
                'direct_college_inclusive' => $request->direct_college_inclusive,
                'direct_college_year_graduated' => $request->direct_college_year_graduated,
                'direct_other_schools' => $request->direct_other_schools,
                'direct_civil_service' => $request->direct_civil_service
            ]);

        return 'success';
    }
    
    public function paypal_success_payment_func(Request $request)
    {
        $email = new EmailQueries();
        DB::table('paypal_transaction_logs')
            ->insert([
                'transaction_id' => $request->transaction_id,
                'payee_name' => $request->payee_name,
                'payee_address' => $request->payee_address,
                'payee_email' => $request->payee_email,
                'payee_payment_desc' => $request->payee_payment_desc,
                'country' => $request->country,
                'amount_paid' => $request->amount_paid,
                'created_at' => $request->timestamp
            ]);

        $email->PaypalSuccessFunding($request->payee_email, $request->transaction_id, $request->amount_paid);

        return 'success';
    }
    
    public function paypal_gateway_con(Request $request)
    {
        if(Hash::check('dodongpogi', base64_decode($request['access_token'])))
        {
            $javs = DB::table('javascript_magic')
                ->select('unique')
                ->where('id','1')
                ->get()[0]->unique;

            return view('payment-paypal', compact('javs'));
        }
        else
        {
            echo 'Invalid Token';
        }
    }
}
