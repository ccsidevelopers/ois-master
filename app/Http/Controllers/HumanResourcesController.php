<?php

namespace App\Http\Controllers;

use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use Carbon\Carbon;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Generals\Trimmer;
use PHPExcel_Style_Border;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
//use Excel;

class HumanResourcesController extends Controller
{
    public function humanResourcesPanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else
        {
            if (Auth::user() == null)
            {
                return redirect()->route('/');
            }

            else if (Auth::user()->hasRole('Human Resources'))
            {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;
                    
                    $get_employee_id = DB::table('users')
                    ->join('role_user', 'role_user.user_id','=','users.id')
                    ->join('roles','roles.id','=','role_user.role_id')
                    ->where('users.archive','False')
                    ->where(function($query){

                        return $query->where('roles.id','!=',4)
                            ->where('roles.id','!=',6)
                            ->where('roles.id','!=',14);
                    })
                    ->select([
                        'users.name as emp_name',
                        'users.id as emp_id'
                    ])
                    ->get();
                    
                return view('human_resources.human-resources-master', compact('javs','get_employee_id'));
            }
            return redirect()->route('privilege-error');
        }
    }
    public function createProfile(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $trimmer = new Trimmer();
//        if($request->empPosition == 'Field Verifier')
//        {
//            $validator = Validator::make($request->all(),
//                [
//                    'empPosition' => 'required',
//                    'empDateHire' => 'required',
//                    'empAge' => 'required',
//                    'empFirst' => 'required',
//                    'empMid' => 'required',
//                    'empLast' => 'required',
//                    'empEmail' => 'required',
//                    'empBirth' => 'required',
//                    'empContactNumber' => 'required',
//                    'empPresentAddress' => 'required',
//                    'empSalary' => 'required',
//                    'ciMuni' => 'required',
//                    'ccType' => 'required'
//                ]);
//        }
//        else
//        {
//            $validator = Validator::make($request->all(),
//                [
//                    'empPosition' => 'required',
//                    'empDateHire' => 'required',
//                    'empAge' => 'required',
//                    'empFirst' => 'required',
//                    'empMid' => 'required',
//                    'empLast' => 'required',
//                    'empEmail' => 'required',
//                    'empBirth' => 'required',
//                    'empContactNumber' => 'required',
//                    'empPresentAddress' => 'required',
//                    'empSalary' => 'required'
//                ]);
//        }

        $first = ($trimmer->trims($request->empFirst));
        $mid = ($trimmer->trims($request->empMid));
        $last = ($trimmer->trims($request->empLast));

        $existing = DB::table('users_profile')
            ->where('emp_first_name', $first)
            ->where('emp_last_name', $last)
            ->where('emp_middle_name', $mid)
            ->count();

//        if ($validator->fails())
//        {
//            return \response()->json(['error' => 'required']);
//        }
//        else
//            {
            if ($existing > 0)
            {
                return \response()->json(['exist' => 'exist']);
            }
            else

            {
                if ($request->empPermanentAddress == null)
                {
                    $nullPermanent = ($trimmer->trims($request->empPresentAddress));
                }
                else
                {
                    $nullPermanent = ($trimmer->trims($request->empPermanentAddress));
                }

                if ($request->empSss == null)
                {
                    $nullSss = 'TO BE FOLLOWED';
                } else {
                    $nullSss = $request->empSss;
                }

                if ($request->empPhilhealth == null)
                {
                    $nullPhilhealth = 'TO BE FOLLOWED';
                }
                else
                {
                    $nullPhilhealth = $request->empPhilhealth;
                }

                if ($request->empPagibig == null)
                {
                    $nullPagibig = 'TO BE FOLLOWED';
                }
                else
                {
                    $nullPagibig = $request->empPagibig;
                }

                if ($request->empTin == null)
                {
                    $nullTin = 'TO BE FOLLOWED';
                }
                else
                {
                    $nullTin = $request->empTin;
                }

                if($request->empDependents == null)
                {
                    $nullDep = 'None';
                }
                else
                {
                    $nullDep = $request->empDependents;
                }

                $fullName = $first . ' ' . $mid . ' ' . $last;
                $file = $request->file('emp_profile_pic');


                if ($file != null)
                {
                    $name = $first . '-' . $last . '.' . $file->getClientOriginalExtension();
                    Image::make(file_get_contents($file) . ($file->getClientOriginalName()))->resize(215, 215)->save(public_path('user_profile_pictures/' . $name));
                    $linkName = 'user_profile_pictures/' . $name;
                }
                else
                {
                    $linkName = '';
                }

                $branchGet = DB::table('branch_list')
                    ->select('id')
                    ->where('branch_name',  $request->empBranch)
                    ->get();

                if (Input::hasFile('empFile'))
                {
                    $file2 = $request->file('empFile');
                    $name2 =  $first . '-' . $mid . '-' . $last . '.' . $file2->getClientOriginalExtension();
                    $path = '/hr_files/'.$name2;

                    if ($file2->getClientOriginalExtension() != 'zip')
                    {
                        return \response()->json(['type' => 'type']);
                    }
                    else
                    {
                        $file2->move(storage_path('/hr_files/'), $name2);
                    }
                }
                else
                {
                    $path = null;
                }

                $getID = DB::table('users_profile')
                    ->insertGetId
                    ([
                        'branch_id' => $branchGet[0]->id,
                        'emp_position' => $removeScript->scripttrim($request->empPosition) ,
                        'emp_date_hired' => ($trimmer->trims($request->empDateHire)),
                        'emp_age' => ($trimmer->trims($request->empAge)),
                        'emp_first_name' => $removeScript->scripttrim(($trimmer->trims($request->empFirst))),
                        'emp_middle_name' => $removeScript->scripttrim(($trimmer->trims($request->empMid))) ,
                        'emp_last_name' => $removeScript->scripttrim(($trimmer->trims($request->empLast))) ,
                        'emp_full_name' => $removeScript->scripttrim(($trimmer->trims($fullName))) ,
                        'emp_religion' => $removeScript->scripttrim(($trimmer->trims($request->empReligion))) ,
                        'emp_gender' => $removeScript->scripttrim(($trimmer->trims($request->empGender))) ,
                        'emp_date_birth' => ($trimmer->trims($request->empBirth)),
                        'emp_marital_status' => ($trimmer->trims($request->empMaritalStatus)),
                        'emp_profile_pic' => $linkName,
                        'emp_salary' => $removeScript->scripttrim($request->empSalary) ,
                        'emp_dependents' => $nullDep,
                        'emp_status' => 'Probationary',
                        'emp_file_path' => $path,
                        'emp_no_days' => $removeScript->scripttrim($request->noDays) ,
                        'ci_area_muni' => $removeScript->scripttrim($request->ciMuni) ,
                        'ci_area_prov' => $removeScript->scripttrim($request->ciProv) ,
                        'commuter_type' => $removeScript->scripttrim($request->ccType) ,
                        'emp_rate' => $removeScript->scripttrim($request->empRate) ,
                        'emp_wage' => $removeScript->scripttrim($request->empWage) ,
                        'emp_allowances' => $removeScript->scripttrim($request->empAllowances) ,
                        'emp_process_status' => $removeScript->scripttrim($request->empState) ,
                        'emp_approval' => 'Requested',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_contact_details')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'contact_category' => 'mobile number',
                        'emp_contact_info' => $removeScript->scripttrim($request->empContactNumber) ,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_contact_details')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'contact_category' => 'email address',
                        'emp_contact_info' => $removeScript->scripttrim($request->empEmail) ,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_benefits')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sss' => $nullSss,
                        'emp_philhealth' => $nullPhilhealth,
                        'emp_pagibig' => $nullPagibig,
                        'emp_tin' => $nullTin,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_address')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'address_category' => 'present',
                        'emp_address' => $removeScript->scripttrim(($trimmer->trims($request->empPresentAddress))) ,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_address')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'address_category' => 'permanent address',
                        'emp_address' => $nullPermanent,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'days' => 'Fixed',
                        'emp_fixed_sched' => $removeScript->scripttrim($request->empFixed) ,
                        'emp_sched_remarks' => $request->empSchedRemarks,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $removeScript->scripttrim($request->empInMon)  . ' - ' . $removeScript->scripttrim($request->empOutMon) ,
                        'emp_in' => $removeScript->scripttrim($request->empInMon) ,
                        'emp_out' => $removeScript->scripttrim($request->empOutMon) ,
                        'days' => 'Monday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $removeScript->scripttrim($request->empInTues)  . ' - ' . $removeScript->scripttrim($request->empOutTues) ,
                        'emp_in' => $removeScript->scripttrim($request->empInTues) ,
                        'emp_out' => $removeScript->scripttrim($request->empOutTues) ,
                        'days' => 'Tuesday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $removeScript->scripttrim($request->empInWed)  . ' - ' . $removeScript->scripttrim($request->empOutWed)  ,
                        'emp_in' => $removeScript->scripttrim($request->empInWed) ,
                        'emp_out' => $removeScript->scripttrim($request->empOutWed) ,
                        'days' => 'Wednesday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $removeScript->scripttrim($request->empInThurs)  . ' - ' .  $request->empOutThurs,
                        'emp_in' => $request->empInThurs,
                        'emp_out' => $request->empOutThurs,
                        'days' => 'Thursday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $request->empInFri . ' - ' .  $request->empOutFri,
                        'emp_in' => $request->empInFri,
                        'emp_out' => $request->empOutFri,
                        'days' => 'Friday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $request->empInSat . ' - ' .  $request->empOutSat,
                        'emp_in' => $request->empInSat,
                        'emp_out' => $request->empOutSat,
                        'days' => 'Saturday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_sched' => $request->empInSun . ' - ' .  $request->empOutSun,
                        'emp_in' => $request->empInSun,
                        'emp_out' => $request->empOutSun,
                        'days' => 'Sunday',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_atm')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_id_card' => 'Without ID',
                        'emp_id_no' => 'None',
                        'emp_uniform' => 'None',
                        'emp_bank' => 'None',
                        'emp_health_card' => 'None',
                        'emp_accident' => 'Not Insured',
                        'emp_phone_number' => '',
                        'emp_phone_price' => 0,
                        'emp_phone_desc' => '',
                        'fb_info' => '',
                        'computer_info' => '',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('emp_oims_gmail')
                    ->insert
                    ([
                        'user_id' => $getID,
                        'emp_oims' => 'No access',
                        'emp_corporate_gmail' => 'No access',
                        'gmail_password' => '',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);


                $logs = new AuditQueries();

                $logs->create_profile_log('CREATE PROFILE FOR '. $fullName . '('. $trimmer->trims($request->empBranch) . ' Branch) TO BE APPROVED AND EVALUATED'  , $getID ,Auth::user()->id );

                return \response()->json(['success' => 'success', $getID]);
            }
//        }
    }

    public function getEmployees()
    {
        $getEmp = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->orderBy('users_profile.id', 'DESC')
            ->get();

        return response()->json($getEmp);
    }
    public function addExperience(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $arrItemLst = count($request->test_name);
        if ($arrItemLst > 0) {
            for ($b = 0; $b < $arrItemLst; $b++)
            {
                if(($request->test_name[$b]) == null || ($request->test_add[$b]) == null || ($request->test_pos[$b]) == null || ($request->test_start[$b])== null || ($request->test_end[$b])== null || ($request->test_num[$b])== null)
                {
                    return \response()->json(['error' => 'required']);
                }
                else
                {
                    DB::table('users_work_experience')
                        ->insert
                        ([
                            'user_id' => $request->id[0],
                            'company_name' => $removeScript->scripttrim(($trimmer->trims($request->test_name[$b]))) ,
                            'company_address' => $removeScript->scripttrim(($trimmer->trims($request->test_add[$b]))) ,
                            'company_position' => $removeScript->scripttrim(($trimmer->trims($request->test_pos[$b]))) ,
                            'start_date' => $request->test_start[$b],
                            'end_date' => $request->test_end[$b],
                            'contact_no' => $request->test_num[$b],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }

            $getsome = DB::table('users_profile')
                ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
                ->select
                ([
                    'users_profile.emp_full_name as name',
                    'branch_list.branch_name as branch'
                ])
                ->where('users_profile.id', $request->id[0])
                ->get();

            $logs = new AuditQueries();

            $logs->create_profile_log('ADDED ' . $arrItemLst. ' WORK HISTORY FOR '. $getsome[0]->name. '(' . $trimmer->trims($getsome[0]->branch). ' BRANCH)'  , $request->id[0] ,Auth::user()->id );

            return \response()->json(['success' => 'success']);
        }
    }
    public function AddEduc(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $arrItemLst = count($request->selectedLevel);
        if ($arrItemLst > 0) {
            for ($b = 0; $b < $arrItemLst; $b++)
            {
                if(($request->selectedLevel[$b]) == null || ($request->school_name[$b]) == null || ($request->school_address[$b]) == null || ($request->school_year[$b])== null)
                {
                    return \response()->json(['error' => 'required']);
                }
                else
                {
                    $course = '';
                    if($request->school_course[$b] != null)
                    {
                        $course = $request->school_course[$b];
                    }
                    else
                    {
                        $course = 'N/A';
                    }
                    DB::table('user_education')
                        ->insert
                        ([
                            'user_id' => $request->id[0],
                            'educ_level' => ($trimmer->trims($request->selectedLevel[$b])),
                            'school_name' => $removeScript->scripttrim(($trimmer->trims($request->school_name[$b]))) ,
                            'school_address' => $removeScript->scripttrim(($trimmer->trims($request->school_address[$b]))),
                            'year_graduated' => $removeScript->scripttrim($request->school_year[$b]) ,
                            'educ_course' => $removeScript->scripttrim(($trimmer->trims($course))) ,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }
            $getsome = DB::table('users_profile')
                ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
                ->select
                ([
                    'users_profile.emp_full_name as name',
                    'branch_list.branch_name as branch'
                ])
                ->where('users_profile.id', $request->id[0])
                ->get();

            $logs = new AuditQueries();

            $logs->create_profile_log('ADDED ' . $arrItemLst. ' EDUCATION HISTORY FOR '. $getsome[0]->name. '(' . $trimmer->trims($getsome[0]->branch). ' BRANCH)'  , $request->id[0] ,Auth::user()->id );

            return \response()->json(['success' => 'success']);
        }
    }
    public function AddRef(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $arrItemLst = count($request->char_name);
        if ($arrItemLst > 0)
        {
            for ($b = 0; $b < $arrItemLst; $b++)
            {
                if(($request->char_name[$b]) == null || ($request->char_position[$b]) == null || ($request->char_company[$b]) == null || ($request->char_contact[$b])== null)
                {
                    return \response()->json(['error' => 'required']);
                }
                else
                {
                    DB::table('user_character_reference')
                        ->insert
                        ([
                            'user_id' => $request->id[0],
                            'char_name' => $removeScript->scripttrim(($trimmer->trims($request->char_name[$b]))) ,
                            'char_position' => $removeScript->scripttrim(($trimmer->trims($request->char_position[$b]))) ,
                            'char_company_name' => $removeScript->scripttrim(($trimmer->trims($request->char_company[$b]))) ,
                            'char_contact' => $removeScript->scripttrim($request->char_contact[$b]),
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }
            $getsome = DB::table('users_profile')
                ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
                ->select
                ([
                    'users_profile.emp_full_name as name',
                    'branch_list.branch_name as branch'
                ])
                ->where('users_profile.id', $request->id[0])
                ->get();

            $logs = new AuditQueries();

            $logs->create_profile_log('ADDED ' . $arrItemLst. ' CHARACTER REFERENCE FOR '. $getsome[0]->name. '(' . $trimmer->trims($getsome[0]->branch) . ' branch)'  , $request->id[0] ,Auth::user()->id );
            return \response()->json(['success' => 'success']);
        }
    }

    public function showEmployee()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_approval as approval'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Approved')
                    ->orWhere('users_profile.emp_approval', 'Partial');
            });
        return DataTables::of($getEmployees)
            ->make(true);
    }
    public function showProfile(Request $request)
    {
        $getdetails = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->join('user_sched', 'user_sched.user_id', '=', 'users_profile.id')
            ->join('emp_oims_gmail', 'emp_oims_gmail.user_id', '=', 'users_profile.id')
            ->join('users_atm', 'users_atm.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.emp_first_name as fname',
                'users_profile.emp_last_name as lname',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_age as age',
                'users_profile.emp_religion as religion',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as date_birth',
                'users_profile.emp_marital_status as marital_status',
                'users_profile.emp_salary as salary',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_profile_pic as profile_pic',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.ci_area_muni as muni',
                'users_profile.commuter_type as type',
                'users_profile.emp_status as con_stat',
                'users_profile.emp_process_status as emp_stat',
                'users_profile.emp_outgoing as outgoing',
                'users_profile.emp_rate as rate',
                'users_profile.emp_no_days as days',
                'users_profile.emp_end_date as end',
                'users_profile.emp_allowances as allowance',
                'users_atm.emp_id_card as id_card',
                'users_atm.emp_id_no as id_no',
                'users_atm.emp_uniform as uni',
                'users_atm.emp_bank as bank_name',
                'users_atm.emp_health_card as health',
                'users_atm.emp_accident as accident',
                'users_atm.emp_phone_number as phone_no',
                'users_atm.emp_phone_price as price',
                'users_atm.emp_phone_desc as phone_desc',
                'emp_oims_gmail.emp_oims as oims',
                'emp_oims_gmail.emp_corporate_gmail as gmail',
                'emp_oims_gmail.gmail_password as pass',
                'users_atm.fb_info as fb',
                'users_atm.computer_info as com'
            ])
            ->where('users_profile.id', $request->empIDshow)
            ->get();

        $getpresentaddress = DB::table('users_address')
            ->select('emp_address')
            ->where('user_id', $request->empIDshow)
            ->where('address_category', 'present')
            ->get();

        $getpermanentaddress = DB::table('users_address')
            ->select('emp_address')
            ->where('user_id', $request->empIDshow)
            ->where('address_category', 'permanent address')
            ->get();

        $getmobile = DB::table('users_contact_details')
            ->select('emp_contact_info')
            ->where('user_id', $request->empIDshow)
            ->where('contact_category', 'mobile number')
            ->get();

        $getemail = DB::table('users_contact_details')
            ->select('emp_contact_info')
            ->where('user_id', $request->empIDshow)
            ->where('contact_category', 'email address')
            ->get();

        $getSched = DB::table('user_sched')
            ->select('emp_fixed_sched')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Fixed')
            ->get();

        $getSchedMon = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Monday')
            ->get();

        $getSchedTues = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Tuesday')
            ->get();

        $getSchedWed = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Wednesday')
            ->get();

        $getSchedThurs = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Thursday')
            ->get();

        $getSchedFri = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Friday')
            ->get();

        $getSchedSat = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Saturday')
            ->get();

        $getSchedSun = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Sunday')
            ->get();

        $getCheck[] = DB::table('emp_checklist')
            ->select('check_name')
            ->where('user_id', $request->empIDshow)
            ->get();

        $getRemarks = DB::table('user_sched')
            ->select('emp_sched_remarks')
            ->where('user_id', $request->empIDshow)
            ->where('days', 'Fixed')
            ->get();

        return \response()->json([$getdetails, $getpresentaddress,$getpermanentaddress, $getmobile,
            $getemail, $getSched, $getSchedMon, $getSchedTues, $getSchedWed, $getSchedThurs,
            $getSchedFri, $getSchedSat, $getSchedSun, $getCheck, $getRemarks]);
    }
    public function showExp(Request $request)
    {
        $id = $request->emp_id;
        $dataExp = DB::table('users_work_experience')
            ->select('id', 'company_name', 'company_address', 'company_position',  'start_date', 'end_date', 'contact_no')
            ->where('user_id', $id);
        return DataTables::of($dataExp)
            ->make(true);
    }
    public function showEduc(Request $request)
    {
        $id = $request->emp_id;
        $dataEduc = DB::table('user_education')
            ->select('id', 'educ_level', 'school_name', 'school_address',  'year_graduated', 'educ_course')
            ->where('user_id', $id);
        return DataTables::of($dataEduc)
            ->make(true);
    }
    public function showChar(Request $request)
    {
        $id = $request->emp_id;
        $dataChar = DB::table('user_character_reference')
            ->select('id', 'char_name', 'char_position', 'char_company_name', 'char_contact')
            ->where('user_id', $id);
        return DataTables::of($dataChar)
            ->make(true);
    }
    public function deleteExp(Request $request)
    {
        $trimmer = new Trimmer();

        $getId = DB::table('users_work_experience')
            ->select('user_id')
            ->where('id', $request->expBye)
            ->get();

        $getsome = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->where('users_profile.id', $getId[0]->user_id)
            ->get();
        $logs = new AuditQueries();

        $logs->create_profile_log('DELETED A WORK EXPERIENCE OF '. $getsome[0]->name . '(' . $trimmer->trims($getsome[0]->branch). ' BRANCH)'  , $getId[0]->user_id ,Auth::user()->id );

        DB::table('users_work_experience')
            ->where('id', $request->expBye)
            ->delete();
    }
    public function deleteEduc(Request $request)
    {
        $trimmer = new Trimmer();

        $getId = DB::table('user_education')
            ->select('user_id')
            ->where('id', $request->educBye)
            ->get();

        $getsome = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->where('users_profile.id', $getId[0]->user_id)
            ->get();

        $logs = new AuditQueries();

        $logs->create_profile_log('DELETED AN EDUCATION HISTORY OF '. $getsome[0]->name. '(' . $trimmer->trims($getsome[0]->branch). ' BRANCH)'  , $getId[0]->user_id ,Auth::user()->id );

        DB::table('user_education')
            ->where('id', $request->educBye)
            ->delete();
    }
    public function deleteChar(Request $request)
    {
        $trimmer = new Trimmer();

        $getId = DB::table('user_character_reference')
            ->select('user_id')
            ->where('id', $request->charBye)
            ->get();

        $getsome = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->where('users_profile.id', $getId[0]->user_id)
            ->get();

        $logs = new AuditQueries();

        $logs->create_profile_log('DELETED A CHARACTER REFERENCE OF '. $getsome[0]->name. '(' . $trimmer->trims($getsome[0]->branch). ' BRANCH)'  , $getId[0]->user_id  ,Auth::user()->id );

        DB::table('user_character_reference')
            ->where('id', $request->charBye)
            ->delete();
    }
    public function UpdateShow(Request $request) {

        $getprof = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select([
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch_name',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_age as age',
                'users_profile.emp_religion as religion',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as date_birth',
                'users_profile.emp_marital_status as marital_status',
                'users_profile.emp_salary as salary',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_profile_pic as profile_pic',
                'users_profile.emp_first_name as first_name',
                'users_profile.emp_middle_name as middle_name',
                'users_profile.emp_last_name as last_name',
                'users_profile.emp_no_days as days',
                'users_profile.ci_area_muni as muni',
                'users_profile.ci_area_prov as prov',
                'users_profile.commuter_type as cc',
                'users_profile.emp_rate as rate',
                'users_profile.emp_wage as wage',
                'users_profile.emp_process_status as stat',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin'
            ])
            ->where('users_profile.id', $request->selectedNameID)
            ->get();

        $getpresent = DB::table('users_address')
            ->select('emp_address')
            ->where('user_id', $request->selectedNameID)
            ->where('address_category', 'present')
            ->get();

        $getpermanent = DB::table('users_address')
            ->select('emp_address')
            ->where('user_id', $request->selectedNameID)
            ->where('address_category', 'permanent address')
            ->get();

        $getmob = DB::table('users_contact_details')
            ->select('emp_contact_info')
            ->where('user_id', $request->selectedNameID)
            ->where('contact_category', 'mobile number')
            ->get();

        $getemailadd = DB::table('users_contact_details')
            ->select('emp_contact_info')
            ->where('user_id', $request->selectedNameID)
            ->where('contact_category', 'email address')
            ->get();

        $getSchedMon = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Monday')
            ->get();
        $getSchedTues = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Tuesday')
            ->get();
        $getSchedWed = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Wednesday')
            ->get();
        $getSchedThurs = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Thursday')
            ->get();
        $getSchedFri = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Friday')
            ->get();
        $getSchedSat = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Saturday')
            ->get();
        $getSchedSun = DB::table('user_sched')
            ->select('emp_in', 'emp_out')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Sunday')
            ->get();
        $getSchedFixed = DB::table('user_sched')
            ->select('emp_fixed_sched', 'emp_sched_remarks')
            ->where('user_id', $request->selectedNameID)
            ->where('days', 'Fixed')
            ->get();
        $getCheck[] = DB::table('emp_checklist')
            ->select('check_name')
            ->where('user_id', $request->selectedNameID)
            ->get();


        return \response()->json([$getprof, $getpresent,$getpermanent, $getmob, $getemailadd, $getSchedMon,
            $getSchedTues, $getSchedWed, $getSchedThurs, $getSchedFri, $getSchedSat, $getSchedSun, $getSchedFixed, $getCheck]);
    }
    public function updateProfile(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
//        if($request->empPosition == 'Field Verifier')
//        {
//            $validator = Validator::make($request->all(),
//                [
//                    'empPosition' => 'required',
//                    'empDateHire' => 'required',
//                    'empAge' => 'required',
//                    'empFirst' => 'required',
//                    'empMid' => 'required',
//                    'empLast' => 'required',
//                    'empEmail' => 'required',
//                    'empBirth' => 'required',
//                    'empContactNumber' => 'required',
//                    'empPresentAddress' => 'required',
//                    'empSalary' => 'required',
//                    'ciMuni' => 'required',
//                    'ccType' => 'required'
//                ]);
//        }
//        else
//        {
//            $validator = Validator::make($request->all(),
//                [
//                    'empPosition' => 'required',
//                    'empDateHire' => 'required',
//                    'empAge' => 'required',
//                    'empFirst' => 'required',
//                    'empMid' => 'required',
//                    'empLast' => 'required',
//                    'empEmail' => 'required',
//                    'empBirth' => 'required',
//                    'empContactNumber' => 'required',
//                    'empPresentAddress' => 'required',
//                    'empSalary' => 'required'
//                ]);
//        }

//        if ($validator->fails())
//        {
//            return \response()->json(['error' => 'required']);
//        }
//        else
//        {
            $getData = DB::table('users_profile')
                ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
                ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
                ->select
                ([
                    'branch_list.branch_name as branch',
                    'users_profile.emp_position as position',
                    'users_profile.emp_date_hired as hired',
                    'users_profile.emp_age as age',
                    'users_profile.emp_full_name as fullname',
                    'users_profile.emp_first_name as first_name',
                    'users_profile.emp_middle_name as middle_name',
                    'users_profile.emp_last_name as last_name',
                    'users_profile.emp_religion as religion',
                    'users_profile.emp_gender as gender',
                    'users_profile.emp_date_birth as birth',
                    'users_profile.emp_marital_status as marital',
                    'user_benefits.emp_sss as sss',
                    'user_benefits.emp_philhealth as philhealth',
                    'user_benefits.emp_pagibig as pagibig',
                    'user_benefits.emp_tin as tin',
                    'users_profile.emp_salary as salary',
                    'users_profile.emp_dependents as dependents',
                    'users_profile.ci_area_muni as muni',
                    'users_profile.emp_rate as rate',
                    'users_profile.emp_wage as wage',
                    'users_profile.emp_process_status as status',
                    'users_profile.emp_no_days as days',
                    'users_profile.commuter_type as cc',
                    'users_profile.emp_allowances as allowance'
                ])
                ->where('users_profile.id', $request->selectedNameID)
                ->get();

            $getContactNum = DB::table('users_contact_details')
                ->select('emp_contact_info')
                ->where('contact_category', 'mobile number')
                ->where('user_id', $request->selectedNameID)
                ->get();

            $getEmail = DB::table('users_contact_details')
                ->select('emp_contact_info')
                ->where('contact_category', 'email address')
                ->where('user_id', $request->selectedNameID)
                ->get();
            $getPresent =  DB::table('users_address')
                ->select('emp_address')
                ->where('user_id', $request->selectedNameID)
                ->where('address_category', 'present')
                ->get();
            $getPerm = DB::table('users_address')
                ->select('emp_address')
                ->where('user_id', $request->selectedNameID)
                ->where('address_category' ,'permanent address')
                ->get();

            $getMonday = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Monday')
                ->get();

            $getTuesday = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Tuesday')
                ->get();

            $getWed = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Wednesday')
                ->get();

            $getThurs = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Thursday')
                ->get();

            $getFri  = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Friday')
                ->get();

            $getSat =  DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Saturday')
                ->get();

            $getSun = DB::table('user_sched')
                ->select('emp_in', 'emp_out')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Sunday')
                ->get();

            $getFixed = DB::table('user_sched')
                ->select('emp_fixed_sched', 'emp_sched_remarks')
                ->where('user_id', $request->selectedNameID)
                ->where('days', 'Fixed')
                ->get();

            $array1 = array( 'POSITION' => $getData[0]->position, 'BRANCH' => $getData[0]->branch,  'DATE HIRED' => $getData[0]->hired, 'AGE' => $getData[0]->age,
                'FIRST NAME' => $getData[0]->first_name, 'MIDDLE NAME' => $getData[0]->middle_name, 'LAST NAME' => $getData[0]->last_name,
                'RELIGION' => $getData[0]->religion, 'CONTACT NUMBER' => $getContactNum[0]->emp_contact_info, 'EMAIL ADDRESS' => $getEmail[0]->emp_contact_info, 'GENDER' => $getData[0]->gender,
                'BIRTH DATE' =>$getData[0]->birth, 'MARITAL STATUS' => $getData[0]->marital, 'SSS NO.' => $getData[0]->sss, 'PHILHEALTH NO.' => $getData[0]->philhealth,
                'PAGIBIG NO.' => $getData[0]->pagibig, 'TIN NO.' => $getData[0]->tin, 'PRESENT ADDRESS' => $getPresent[0]->emp_address, 'PERMANENT ADDRESS' => $getPerm[0]->emp_address,
                'SALARY OFFER' => $getData[0]->salary, 'DEPENDENTS' =>$getData[0]->dependents, 'MONDAY TIME-IN' => $getMonday[0]->emp_in, 'MONDAY TIME-OUT' =>$getMonday[0]->emp_out,
                'TUESDAY TIME-IN' => $getTuesday[0]->emp_in, 'TUESDAY TIME-OUT' => $getTuesday[0]->emp_out, 'WEDNESDAY TIME-IN' => $getWed[0]->emp_in, 'WEDNESDAY TIME-OUT' => $getWed[0]->emp_out,
                'THURSDAY TIME-IN' => $getThurs[0]->emp_in, 'THURSDAY TIME-OUT' => $getThurs[0]->emp_out, 'FRIDAY TIME-IN' => $getFri[0]->emp_in, 'FRIDAY TIME-OUT' => $getFri[0]->emp_out,
                'SATURDAY TIME-IN' => $getSat[0]->emp_in, 'SATURDAY TIME-OUT' => $getSat[0]->emp_out , 'SUNDAY TIME-IN ' => $getSun[0]->emp_in, 'SUNDAY TIME-OUT' => $getSun[0]->emp_out,
                'CI AREA OF ASSIGNMENT' => $getData[0]->muni, 'TYPE OF RATE' => $getData[0]->rate, 'MINIMUM WAGE ON LOCATION' =>$getData[0]->wage, 'EMPLOYMENT STATUS' =>$getData[0]->status,
                'MANDATED NO. OF WORKING DAYS' => $getData[0]->days, 'TYPE OF MOTORCYCLE CC' => $getData[0]->cc, 'FIXED SCHEDULE' => $getFixed[0]->emp_fixed_sched, 'SCHEDULE REMARKS' => $getFixed[0]->emp_sched_remarks);

            $array2 = array('POSITION' => $removeScript->scripttrim($request->empPosition) , 'BRANCH' => $removeScript->scripttrim($request->empBranch) , 'DATE HIRED' => $removeScript->scripttrim($request->empDateHire) , 'AGE' => $removeScript->scripttrim($request->empAge) ,
                'FIRST NAME' => $removeScript->scripttrim($request->empFirst) , 'MIDDLE NAME' => $removeScript->scripttrim($request->empMid) ,'LAST NAME' => $removeScript->scripttrim($request->empLast) ,
                'RELIGION' => $removeScript->scripttrim($request->empReligion) ,'CONTACT NUMBER' => $removeScript->scripttrim($request->empContactNumber) , 'EMAIL ADDRESS' => $removeScript->scripttrim($request->empEmail) , 'GENDER' => $removeScript->scripttrim($request->empGender) ,
                'BIRTH DATE' => $removeScript->scripttrim($request->empBirth) , 'MARITAL STATUS' => $request->empMaritalStatus, 'SSS NO.' => $removeScript->scripttrim($request->empSss) , 'PHILHEALTH NO.' => $removeScript->scripttrim($request->empPhilhealth) ,
                'PAGIBIG NO.' => $removeScript->scripttrim($request->empPagibig) , 'TIN NO.' => $removeScript->scripttrim($request->empTin) , 'PRESENT ADDRESS' => $removeScript->scripttrim($request->empPresentAddress) ,'PERMANENT ADDRESS' => $removeScript->scripttrim($request->empPermanentAddress) ,
                'SALARY OFFER' => $removeScript->scripttrim($request->empSalary) , 'DEPENDENTS' => $removeScript->scripttrim($request->empDependents) , 'MONDAY TIME-IN' => $removeScript->scripttrim($request->empInMon) , 'MONDAY TIME-OUT' => $removeScript->scripttrim($request->empOutMon) ,
                'TUESDAY TIME-IN' => $removeScript->scripttrim($request->empInTues) , 'TUESDAY TIME-OUT' => $removeScript->scripttrim($request->empOutTues) , 'WEDNESDAY TIME-IN' => $removeScript->scripttrim($request->empInWed) , 'WEDNESDAY TIME-OUT' => $removeScript->scripttrim($request->empOutWed) ,
                'THURSDAY TIME-IN' => $removeScript->scripttrim($request->empInThurs) ,  'THURSDAY TIME-OUT' => $removeScript->scripttrim($request->empOutThurs) , 'FRIDAY TIME-IN ' => $removeScript->scripttrim($request->empInFri) , 'FRIDAY TIME-OUT' => $removeScript->scripttrim($request->empOutFri) ,
                'SATURDAY TIME-IN' => $removeScript->scripttrim($request->empInSat) , 'SATURDAY TIME-OUT' => $removeScript->scripttrim($request->empOutSat) , 'SUNDAY TIME-IN ' => $removeScript->scripttrim($request->empInSun) , 'SUNDAY TIME-OUT' => $removeScript->scripttrim($request->empOutSun) ,
                'CI AREA OF ASSIGNMENT' => $removeScript->scripttrim($request->ciMuni)  , 'TYPE OF RATE' => $removeScript->scripttrim($request->empRate) , 'MINIMUM WAGE ON LOCATION' => $removeScript->scripttrim($request->empWage) , 'EMPLOYMENT STATUS' => $removeScript->scripttrim($request->empState) ,
                'MANDATED NO. OF WORKING DAYS' => $removeScript->scripttrim($request->noDays) , 'TYPE OF MOTORCYCLE CC' => $removeScript->scripttrim($request->ccType)  , 'FIXED SCHEDULE' => $removeScript->scripttrim($request->empFixed) , 'SCHEDULE REMARKS' => $removeScript->scripttrim($request->empSchedRemarks) );

            if($array1 != $array2)
            {
                $emplogs = '';
                for($i = 1 ; $i < count($array1) ; $i++)
                {
                    $allKeys1 = array_keys($array1);
                    $allKeys2 = array_keys($array2);
                    if($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]])
                    {
                        $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ' ;
                    }
                }
                if($emplogs != '') {
                    $logs = new AuditQueries();
                    $logs->create_profile_log('UPDATED ' . $trimmer->trims($emplogs) .' FROM THE FROFILE OF ' . $getData[0]->fullname , $request->selectedNameID ,Auth::user()->id );
                }

//                    return response()->json([$array1, $array2]);
                if ($request->empSss == null) {
                    $nullSss = 'TO BE FOLLOWED';
                } else {
                    $nullSss = $removeScript->scripttrim($request->empSss) ;
                }
                if ($request->empPhilhealth == null) {
                    $nullPhilhealth = 'TO BE FOLLOWED';
                } else {
                    $nullPhilhealth = $removeScript->scripttrim($request->empPhilhealth) ;
                }
                if ($request->empPagibig == null) {
                    $nullPagibig = 'TO BE FOLLOWED';
                } else {
                    $nullPagibig = $removeScript->scripttrim($request->empPagibig) ;
                }
                if ($request->empTin == null) {
                    $nullTin = 'TO BE FOLLOWED';
                } else {
                    $nullTin = $removeScript->scripttrim($request->empTin) ;
                }
                if($request->empDependents == null) {
                    $nullDep = 'None';
                } else {
                    $nullDep = $removeScript->scripttrim($request->empDependents) ;
                }
                $first = $removeScript->scripttrim(($trimmer->trims($request->empFirst)));
                $mid = $removeScript->scripttrim(($trimmer->trims($request->empMid)));
                $last = $removeScript->scripttrim(($trimmer->trims($request->empLast)));
                $fullName = $first . ' ' . $mid . ' ' . $last;

                $file = $request->file('emp_profile_pic');

                $getpic = DB::table('users_profile')
                    ->select('emp_profile_pic')
                    ->where('id', $request->selectedNameID)
                    ->get();
                $linkName = '';

                if(count($getpic) > 0)
                {
                    if ($file != null)
                    {
                        $image_path = $getpic[0]->emp_profile_pic;
                        if(File::exists($image_path))
                        {
                            File::delete($image_path);
                        }
                        $name = $first . '-' . $last . '.' . $file->getClientOriginalExtension();
                        Image::make(file_get_contents($file) . ($file->getClientOriginalName()))->resize(215, 215)->save(public_path('user_profile_pictures/' . $name));
                        $linkName = 'user_profile_pictures/' . $name;
                        $logs = new AuditQueries();
                        $logs->create_profile_log('UPDATED THE PROFILE PICTURE FROM THE FROFILE OF ' . $getData[0]->fullname , $request->selectedNameID ,Auth::user()->id );
                    }
                    else
                    {
                        $linkName = $getpic[0]->emp_profile_pic;
                    }
                }
                else
                {

                }


                $fileX = $request->file('empFile');

                if ($fileX != null)
                {
                    $extension = $fileX->getClientOriginalExtension();
                    $paths = $first . '-' . $mid  . '-' .  $last . '.' . $extension ;
                    $fullPath = '/hr_files/'. $paths;

                    if ($fileX->getClientOriginalExtension() != 'zip')
                    {
                        return \response()->json(['type' => 'type']);
                    }

                    {
                        $fileX->move(storage_path('hr_files/'), $paths);

                        DB::table('users_profile')
                            ->where('id', $request->selectedNameID)
                            ->update
                            ([
                                'emp_file_path' => $fullPath
                            ]);
                        $logs = new AuditQueries();
                        $logs->create_profile_log('UPDATED THE 201 ATTACHED FILE FROM THE FROFILE OF ' . $getData[0]->fullname , $request->selectedNameID ,Auth::user()->id );
                    }
                }
                else
                {

                }

                if($request->empPosition != 'Field Verifier')
                {
                    $muni = '';
                    $prov = '';
                    $type = '';
                }
                else
                {
                    $muni =  $request->ciMuni;
                    $prov = $request->ciProv;
                    $type = $request->ccType;

                }
                $branchGet = DB::table('branch_list')
                    ->select('id')
                    ->where('branch_name', $request->empBranch)
                    ->get();

                DB::table('users_profile')
                    ->where('id', $request->selectedNameID)
                    ->update
                    ([
                        'branch_id' => $branchGet[0]->id,
                        'emp_date_hired' => ($trimmer->trims($request->empDateHire)),
                        'emp_age' => ($trimmer->trims($request->empAge)),
                        'emp_first_name' => ($trimmer->trims($request->empFirst)),
                        'emp_middle_name' => ($trimmer->trims($request->empMid)),
                        'emp_last_name' => ($trimmer->trims($request->empLast)),
                        'emp_full_name' => ($trimmer->trims($fullName)),
                        'emp_religion' => ($trimmer->trims($request->empReligion)),
                        'emp_gender' => ($trimmer->trims($request->empGender)),
                        'emp_date_birth' => ($trimmer->trims($request->empBirth)),
                        'emp_marital_status' => ($trimmer->trims($request->empMaritalStatus)),
                        'emp_profile_pic' => $linkName,
                        'emp_salary' => $request->empSalary,
                        'emp_dependents' => $nullDep,
                        'emp_no_days' => $request->noDays,
                        'ci_area_muni' => $muni,
                        'ci_area_prov' => $prov,
                        'commuter_type' => $type,
                        'emp_rate' => $request->empRate,
                        'emp_wage' => $request->empWage,
                        'emp_process_status' => $removeScript->scripttrim($request->empState),
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_contact_details')
                    ->where('user_id', $request->selectedNameID)
                    ->where('contact_category', 'mobile number')
                    ->update
                    ([
                        'emp_contact_info' => $request->empContactNumber,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_contact_details')
                    ->where('user_id', $request->selectedNameID)
                    ->where('contact_category', 'email address')
                    ->update
                    ([
                        'emp_contact_info' => $request->empEmail,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_benefits')
                    ->where('user_id', $request->selectedNameID)
                    ->update([
                        'emp_sss' => $nullSss,
                        'emp_philhealth' => $nullPhilhealth,
                        'emp_pagibig' => $nullPagibig,
                        'emp_tin' => $nullTin,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('users_address')
                    ->where('user_id', $request->selectedNameID)
                    ->where('address_category', 'present')
                    ->update
                    ([
                        'emp_address' => $removeScript->scripttrim(($trimmer->trims($request->empPresentAddress))),
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('users_address')
                    ->where('user_id', $request->selectedNameID)
                    ->where('address_category' ,'permanent address')
                    ->update([
                        'emp_address' => $removeScript->scripttrim(($trimmer->trims($request->empPermanentAddress))),
                        'updated_at' => Carbon::now('Asia/Manila')

                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Monday')
                    ->update
                    ([
                        'emp_sched' => $request->empInMon . ' - ' .  $request->empOutMon,
                        'emp_in' => $request->empInMon,
                        'emp_out' => $request->empOutMon,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Tuesday')
                    ->update
                    ([
                        'emp_sched' => $request->empInTues . ' - ' .  $request->empOutTues,
                        'emp_in' => $request->empInTues,
                        'emp_out' => $request->empOutTues,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Wednesday')
                    ->update
                    ([
                        'emp_sched' => $request->empInWed . ' - ' .  $request->empOutWed,
                        'emp_in' => $request->empInWed,
                        'emp_out' => $request->empOutWed,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Thursday')
                    ->update
                    ([
                        'emp_sched' => $request->empInThurs . ' - ' .  $request->empOutThurs,
                        'emp_in' => $request->empInThurs,
                        'emp_out' => $request->empOutThurs,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Friday')
                    ->update
                    ([
                        'emp_sched' => $request->empInFri . ' - ' .  $request->empOutFri,
                        'emp_in' => $request->empInFri,
                        'emp_out' => $request->empOutFri,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Saturday')
                    ->update
                    ([
                        'emp_sched' => $request->empInSat . ' - ' .  $request->empOutSat,
                        'emp_in' => $request->empInSat,
                        'emp_out' => $request->empOutSat,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Sunday')
                    ->update
                    ([
                        'emp_sched' => $request->empInSun . ' - ' .  $request->empOutSun,
                        'emp_in' => $request->empInSun,
                        'emp_out' => $request->empOutSun,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                DB::table('user_sched')
                    ->where('user_id', $request->selectedNameID)
                    ->where('days', 'Fixed')
                    ->update
                    ([
                        'emp_fixed_sched' => $removeScript->scripttrim($request->empFixed),
                        'emp_sched_remarks' => $removeScript->scripttrim($request->empSchedRemarks),
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                return \response()->json(['success' => 'success', $array1['POSITION'], $array2['POSITION'], $request->selectedNameID, $getData[0]->fullname, $getData[0]->allowance]);
            }
            else {

            }
//        }
    }
    public function updateExp(Request $request)
    {
        $id = $request->viewEmpID;
        $dataExp = DB::table('users_work_experience')
            ->select('id', 'company_name', 'company_address', 'company_position',  'start_date', 'end_date', 'contact_no')
            ->where('user_id', $id)
            ->get();
        return \response()->json($dataExp);
    }

    public function updateEduc(Request $request)
    {
        $id = $request->viewEducID;
        $dataEduc = DB::table('user_education')
            ->select('id', 'educ_level', 'school_name', 'school_address',  'year_graduated', 'educ_course')
            ->where('user_id', $id)
            ->get();
        return \response()->json($dataEduc);
    }

    public function updateRef(Request $request)
    {
        $id = $request->viewCharID;
        $dataChar = DB::table('user_character_reference')
            ->select('id', 'char_name', 'char_position', 'char_company_name', 'char_contact')
            ->where('user_id', $id)
            ->get();
        return \response()->json($dataChar);
    }

    public function getContract(Request $request)
    {
        $getCon = DB::table('users_profile')
            ->select('emp_date_hired', 'emp_end_date', 'emp_position' , 'emp_status', 'emp_outgoing', 'contract_file_path')
            ->where('id', $request->selectedContract)
            ->get();

        return response()->json($getCon);
    }
    public function contractStat(Request $request)
    {
        $trimmer = new Trimmer();

        $getSome = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_end_date as end',
                'users_profile.emp_status as status',
                'users_profile.emp_outgoing as out',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch',
                'users_profile.contract_file_path as path'
            ])
            ->where('users_profile.id', $request->selectedContract)
            ->get();

        $getPath = DB::table('users_profile')
            ->select('contract_file_path')
            ->where('id', $request->selectedContract)
            ->count();


        $stat = $request->con_stat;

        if($stat != 'Off-Boarding') {
            $con = '';
        }
        else
        {
            $validator2 = Validator::make($request->all(),
                [
                    'out_status' => 'required'
                ]);

            if ($validator2->fails())
            {
                return \response()->json(['error' => 'required']);
            }
            $con = $request->out_status;
            DB::table('users_profile')
                ->where('users_profile.id', $request->selectedContract)
                ->update
                ([
                    'emp_process_status' => 'Inactive Employee'
                ]);
        }


        if($getSome[0]->end == '0000-00-00')
        {
            $endcase = '';
        }
        else
        {
            $endcase = $getSome[0]->end;
        }

//        if($getSome[0]->out != '')
//        {
//            $outcase = $getSome[0]->out;
//        }
//        else
//        {
//            $outcase = 'NULL';
//        }
//
        if($request->out_status == null)
        {
            $outsend = '';
        }
        else
        {
            $outsend = $request->out_status;
        }

        $array1 = array('END OF CONTRACT' => $endcase, 'CONTRACT STATUS' => $getSome[0]->status, 'OFF-BOARDING STATUS' => $getSome[0]->out);
        $array2 = array('END OF CONTRACT' => $request->end_date, 'CONTRACT STATUS' => $request->con_stat, 'OFF-BOARDING STATUS' => $outsend);

        $emplogs = '';
        for ($i = 0; $i < count($array1); $i++) {
            $allKeys1 = array_keys($array1);
            $allKeys2 = array_keys($array2);
            if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]])
            {
                $emplogs .= $allKeys2[$i] . '(FROM ' . $trimmer->trims($array1[$allKeys1[$i]]) . ' TO ' . $trimmer->trims($array2[$allKeys2[$i]]) . '), ';
            }
        }
        $logs = new AuditQueries();
        if($emplogs != '') {
            $logs->create_profile_log('UPDATED ' . $emplogs  . ' OF ' . $getSome[0]->name . '(' . $trimmer->trims($getSome[0]->branch) . ' BRANCH)',  $request->selectedContract, Auth::user()->id);
        }

        $file2 = $request->file('con_file');
        if($getPath > 0)
        {
            if ($file2 != null)
            {
                if(File::exists($getSome[0]->path))
                {
                    File::delete($getSome[0]->path);
                }
                $name2 =  $getSome[0]->name . ' - CONTRACT'  . '.' . $file2->getClientOriginalExtension();
                $file2->move(storage_path('/contract_files/'), $name2);
                $path = '/contract_files/'.$name2;
                $logs->create_profile_log('UPDATED CONTRACT SOFTCOPY OF ' . $getSome[0]->name . '(' . $getSome[0]->branch . ' branch)',  $request->selectedContract, Auth::user()->id);
            }
            else
            {
                $path = $getSome[0]->path;
            }
        }
//        else
//        {
//            if ($file2 != null)
//            {
//                $name2 = $getSome[0]->name . ' - CONTRACT'  . '.' . $file2->getClientOriginalExtension();
//                $file2->move(storage_path('/contract_files/'), $name2);
//                $path = '/contract_files/'.$name2;
//                $logs->create_profile_log('UPLOADED CONTRACT SOFTCOPY OF ' . $getSome[0]->name . '(' . $getSome[0]->branch . ' branch)',  $request->selectedContract, Auth::user()->id);
//            }
//            else
//            {
//                $path = '';
//            }
//        }

        DB::table('users_profile')
            ->where('id', $request->selectedContract)
            ->update
            ([
                'emp_end_date' => $request->end_date,
                'emp_status' => $request->con_stat,
                'emp_outgoing' => $con,
                'contract_file_path' => $path
            ]);

    }
    public function getSchedBranch() {
        $getBranches = DB::table('branch_list')
            ->select('branch_name')
            ->get();

        return response()->json([$getBranches]);
    }
    public function fileDownload(Request $request)
    {
        $id = base64_decode($request->id);
        $getNames = DB::table('users_profile')
            ->select('emp_file_path')
            ->where('id', $id)
            ->get();

        if(Auth::user()->hasRole('Human Resources'))
        {
            if($getNames[0]->emp_file_path == null)
            {
                return response("File not Available. Upload to profile.");
            }
            else
            {
                return response()->download(storage_path($getNames[0]->emp_file_path));
            }
        }
        else
        {
            return response('');
        }
    }
    public function dashData()
    {
        $empNo = DB::table('users_profile')
            ->where('emp_approval', '!=', 'Denied')
            ->count();
        $RegEmp = DB::table('users_profile')
            ->where('emp_approval', '!=', 'Denied')
            ->where('emp_status', '=', 'Regular')
            ->count();
        $ProbEmp = DB::table('users_profile')
            ->where('emp_approval', '!=', 'Denied')
            ->where('emp_status', '=', 'Probationary')
            ->count();
        $ResEmp = DB::table('users_profile')
            ->where('emp_approval', '!=', 'Denied')
            ->where('emp_status', '=', 'Off-Boarding')
            ->count();


        return response()->json([$empNo, $RegEmp, $ProbEmp, $ResEmp]);
    }
    public function assignedItems(Request $request)
    {
        $id = $request->emp_id;

        $getSome = DB::table('users_profile')
            ->join('ar_to_employee','ar_to_employee.emp_id', '=', 'users_profile.id')
            ->join('item_to_ar', 'item_to_ar.ar_to_employee_id', '=', 'ar_to_employee.id')
            ->join('item_profile', 'item_profile.id', '=', 'item_to_ar.item_id')
            ->select
            ([
                'item_profile.id as id',
                'item_profile.item_category as category',
                'item_profile.item_brand_model as model',
                'item_profile.item_color as color',
                'item_profile.item_remarks as remarks'
            ])
            ->where('users_profile.id', $id);

        return DataTables::of($getSome)
            ->make(true);
    }
    public function getPos()
    {
        $getPos = DB::table('emp_position')
            ->select('position_name')
            ->get();
        return response()->json($getPos);
    }
    public function getProv()
    {
        $getProv = DB::table('provinces')
            ->select('name')
            ->get();
        return response()->json($getProv);
    }
    public function profLogs()
    {
        $getSome = DB::table('profile_log')
            ->leftjoin('users_profile', 'users_profile.id', '=', 'profile_log.emp_id')
            ->leftjoin('users', 'users.id', '=', 'profile_log.user_id')
            ->select
            ([
                'users.name as user',
                'users_profile.emp_full_name as name',
                'profile_log.activities as activities',
                'profile_log.created_at as date'
            ])
            ->orderBy('profile_log.id', 'desc')
        ;

        return DataTables::of($getSome)
            ->make(true);
    }
    public function motorAdd(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $validator = Validator::make($request->all(),
            [
                'ci_id' => 'required',
                'model' => 'required',
                'name' => 'required',
                'plate' => 'required',
            ]);

        if($validator->fails())
        {
            return \response()->json(['error' => 'required']);
        }
        else
        {
            $file2 = $request->file('file');
            if ($file2 != null)
            {
                $name2 =  $file2->getClientOriginalName();
                $file2->move(storage_path('/motor_reference/' . $request->plate), $name2);
                $path = '/motor_reference/'. $request->plate . '/'.$name2;
            }
            else
            {
                $path = '';
            }
            DB::table('motor_list')
                ->insert
                ([
                    'ci_id' => $request->ci_id,
                    'motor_model' => $removeScript->scripttrim($request->model) ,
                    'motor_cc' => $removeScript->scripttrim($request->cc) ,
                    'motor_renew' => $removeScript->scripttrim($request->renew) ,
                    'register_name' => $removeScript->scripttrim($request->name) ,
                    'motor_orcr' => $removeScript->scripttrim($request->orcr) ,
                    'plate_number' => $removeScript->scripttrim($request->plate) ,
                    'motor_kmpl' => $removeScript->scripttrim($request->kilo) ,
                    'motor_gas' => $removeScript->scripttrim($request->gas) ,
                    'motor_file' => $path,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $getCiName = DB::table('users')
                ->select('name')
                ->where('id', $request->ci_id)
                ->get()[0]->name;

            $logs = new AuditQueries();

            $logs->create_profile_log('ADDED MOTORCYCLE MODEL ' . $removeScript->scripttrim($request->model)  . ' WITH PLATE NUMBER '  . $removeScript->scripttrim($request->plate) . ' FOR CI : ' . $getCiName   ,  '',Auth::user()->id );
        }
    }
    public function motorList()
    {
        $getSome = DB::table('motor_list')
            ->join('users', 'users.id', '=', 'motor_list.ci_id')
            ->select
            ([
                'motor_list.id as id',
                'motor_list.motor_model as motor_model',
                'motor_list.motor_cc as motor_cc',
                'motor_list.motor_renew as motor_renew',
                'motor_list.register_name as register_name',
                'motor_list.motor_orcr as motor_orcr',
                'motor_list.plate_number as plate_number',
                'motor_list.motor_kmpl as motor_kmpl',
                'motor_list.motor_gas as motor_gas',
                'motor_list.motor_file as motor_file',
                'users.name as ci'
            ]);

        return DataTables::of($getSome)
            ->make(true);
    }
    public function motorEdit(Request $request)
    {
        $getSome = DB::table('motor_list')
            ->join('users', 'users.id', '=', 'motor_list.ci_id')
            ->select
            ([
                'motor_list.motor_model as motor_model',
                'motor_list.motor_cc as motor_cc',
                'motor_list.motor_renew as motor_renew',
                'motor_list.register_name as register_name',
                'motor_list.motor_orcr as motor_orcr',
                'motor_list.plate_number as plate_number',
                'motor_list.motor_kmpl as motor_kmpl',
                'motor_list.motor_gas as motor_gas',
                'motor_list.motor_file as motor_file',
                'users.id as ci'
            ])
            ->where('motor_list.id', $request->editMotorId)
            ->get();
        return response()->json($getSome);
    }
    public function motorUpdate(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getData1 = DB::table('motor_list')
            ->select('motor_model', 'motor_cc', 'motor_renew', 'register_name', 'motor_orcr', 'plate_number', 'motor_kmpl', 'motor_gas', 'motor_file', 'ci_id')
            ->where('id', $request->editMotorId)
            ->get();

        $array1 = array('MOTORCYCLE MODEL' => $getData1[0]->motor_model, 'MOTORCYCLE CC' => $getData1[0]->motor_cc, 'LATEST RENEWAL MONTH' => $getData1[0]->motor_renew,
            'REGISTERED NAME' => $getData1[0]->register_name, 'MOTOR OR/CR' => $getData1[0]->motor_orcr, 'PLATE NUMBER' => $getData1[0]->plate_number,
            'KILOMETERS PER LITER' => $getData1[0]->motor_kmpl, 'GAS TANK CAPACITY' =>  $getData1[0]->motor_gas);

        $array2 = array('MOTORCYCLE MODEL' => $removeScript->scripttrim($request->editModel) , 'MOTORCYCLE CC' => $removeScript->scripttrim($request->editCc) , 'LATEST RENEWAL MONTH' => $removeScript->scripttrim($request->editRenew) ,
            'REGISTERED NAME' => $removeScript->scripttrim($request->editName) , 'MOTOR OR/CR' => $removeScript->scripttrim($request->editORCR) , 'PLATE NUMBER' => $removeScript->scripttrim($request->editPlate) ,
            'KILOMETERS PER LITER' => $removeScript->scripttrim($request->editKmpl) , 'GAS TANK CAPACITY' => $removeScript->scripttrim($request->editGas) );



        $emplogs = '';
        for ($i = 0; $i < count($array1); $i++) {
            $allKeys1 = array_keys($array1);
            $allKeys2 = array_keys($array2);
            if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]]) {
                $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ' ;
            }
        }
        $logs = new AuditQueries();
        if($emplogs != '')
        {
            $logs->create_profile_log('UPDATED ' . $trimmer->trims($emplogs) . ' FROM THE MOTORCYCLE WITH ID :  ' . $request->editMotorId, $request->editMotorId, Auth::user()->id);
        }

        $file2 = $request->file('editFile');
        if ($file2 != null)
        {
            if(File::exists($getData1[0]->motor_file))
            {
                File::delete($getData1[0]->motor_file);
            }
            $name2 = $request->editPlate . ' - MOTOR REFERENCE'  . '.' . $file2->getClientOriginalExtension();
            $file2->move(storage_path('/motor_reference/' . $getData1[0]->plate_number), $name2);
            $path = '/motor_reference/' . $getData1[0]->plate_number . '/' .$name2;
            $logs->create_profile_log('UPDATED REFERENCE OF MOTORCYCLE ID : ' . $request->editMotorId, '', Auth::user()->id);
        }
        else
        {
            $path = $getData1[0]->motor_file;
        }

        DB::table('motor_list')
            ->where('id', $request->editMotorId)
            ->update
            ([
                'ci_id' => $request->editCI,
                'motor_model' => $removeScript->scripttrim($request->editModel) ,
                'motor_cc' => $removeScript->scripttrim($request->editCc) ,
                'motor_renew' => $removeScript->scripttrim($request->editRenew) ,
                'register_name' => $removeScript->scripttrim($request->editName) ,
                'motor_orcr' => $removeScript->scripttrim($request->editORCR) ,
                'plate_number' => $removeScript->scripttrim($request->editPlate) ,
                'motor_kmpl' => $removeScript->scripttrim($request->editKmpl) ,
                'motor_gas' => $removeScript->scripttrim($request->editGas) ,
                'motor_file' => $path,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
        return response()->json(['success' => 'success']);
    }
    public function motorDelete(Request $request)
    {
        $getSome = DB::table('motor_list')
            ->select('motor_model', 'plate_number')
            ->where('id', $request->delMotor)
            ->get();
        $logs = new AuditQueries();

        $logs->create_profile_log('DELETED MOTORCYCLE MODEL ' . $getSome[0]->motor_model . ' WITH PLATE NUMBER '  . $getSome[0]->plate_number ,  0,Auth::user()->id );
        DB::table('motor_list')
            ->where('id', $request->delMotor)
            ->delete();
    }
    public function atmGet(Request $request)
    {
        $getSome = DB::table('users_atm')
            ->select
            ([
                'emp_id_card',
                'emp_id_no',
                'emp_uniform',
                'emp_bank',
                'emp_health_card',
                'emp_accident',
                'emp_phone_number',
                'emp_phone_price',
                'emp_phone_desc',
                'fb_info',
                'computer_info'
            ])
            ->where('user_id', $request->editAtmId)
            ->get();

        $getSome2 = DB::table('emp_oims_gmail')
            ->select
            ([
                'gmail_password',
                'emp_oims',
                'emp_corporate_gmail'
            ])
            ->where('user_id', $request->editAtmId)
            ->get();

        return response()->json([$getSome, $getSome2]);
    }
    public function atmUpdate(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getData = DB::table('users_atm')
            ->select('emp_id_card', 'emp_id_no', 'emp_uniform', 'emp_bank', 'emp_health_card', 'emp_accident', 'emp_phone_number', 'emp_phone_price', 'emp_phone_desc')
            ->where('user_id', $request->editAtmId)
            ->get();
        $getName = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->editAtmId)
            ->get();
        $array1 = array('ID ISSUANCE' => $getData[0]->emp_id_card, 'ID NUMBER' => $getData[0]->emp_id_no, 'UNIFORM ISSUANCE' => $getData[0]->emp_uniform,
            'BANK' => $getData[0]->emp_bank, 'HEALTH CARD' => $getData[0]->emp_health_card, 'ACCIDENT INSURANCE' => $getData[0]->emp_accident, 'PHONE NUMBER' => $getData[0]->emp_phone_number,
            'PHONE PRICE' => $getData[0]->emp_phone_price, 'PHONE DESCRIPTION'=> $getData[0]->emp_phone_desc);

        $array2 = array('ID ISSUANCE' => $removeScript->scripttrim($request->idIf) , 'ID NUMBER' => $removeScript->scripttrim($request->idNo) , 'UNIFORM ISSUANCE' => $removeScript->scripttrim($request->empUni) ,
            'BANK' => $removeScript->scripttrim($request->empBank) , 'HEALTH CARD' => $removeScript->scripttrim($request->empHealth) , 'ACCIDENT INSURANCE' => $removeScript->scripttrim($request->empAcc),
            'PHONE NUMBER' => $removeScript->scripttrim($request->empPhNume), 'PHONE PRICE' =>  $removeScript->scripttrim($request->empPhonePirice), 'PHONE DESCRIPTION'=> $removeScript->scripttrim($request->empPhoneDesc));

            $emplogs = '';
            for ($i = 0; $i < count($array1); $i++) {
                $allKeys1 = array_keys($array1);
                $allKeys2 = array_keys($array2);
                if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]]) {
                    $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ' ;
                }
            }
            $logs = new AuditQueries();
            $logs->create_profile_log('UPDATED ' . $trimmer->trims($emplogs) . ' FROM THE FROFILE OF ' . $getName[0]->emp_full_name, $removeScript->scripttrim($request->editAtmId), Auth::user()->id);
            DB::table('users_atm')
                ->where('user_id', $request->editAtmId)
                ->update
                ([
                    'emp_id_card' => $removeScript->scripttrim($request->idIf) ,
                    'emp_id_no' => $removeScript->scripttrim($request->idNo) ,
                    'emp_uniform' => $removeScript->scripttrim($request->empUni) ,
                    'emp_bank' => $removeScript->scripttrim($request->empBank) ,
                    'emp_health_card' => $removeScript->scripttrim($request->empHealth) ,
                    'emp_accident' => $removeScript->scripttrim($request->empAcc),
                    'emp_phone_number' => $removeScript->scripttrim($request->empPhNume),
                    'emp_phone_price' => $removeScript->scripttrim($request->empPhonePirice),
                    'emp_phone_desc' => $removeScript->scripttrim($request->empPhoneDesc),
                    'fb_info' => $removeScript->scripttrim($request->fb),
                    'computer_info' => $removeScript->scripttrim($request->comp)
                ]);

            DB::table('emp_oims_gmail')
                ->where('user_id', $request->editAtmId)
                ->update
                ([
                    'emp_oims' =>  $removeScript->scripttrim($request->oims_emp),
                    'emp_corporate_gmail' =>  $removeScript->scripttrim($request->gmail_emp),
                    'gmail_password' =>  $removeScript->scripttrim($request->pass),
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            return \response()->json(['success' => 'success']);

    }
    public function atmTable()
    {
        $getSome = DB::table('users_profile')
            ->join('users_atm', 'users_atm.user_id', '=', 'users_profile.id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch',
                'users_profile.emp_position as position',
                'users_atm.emp_id_card as id_card',
                'users_atm.emp_id_no as id_no',
                'users_atm.emp_uniform as uniform',
                'users_atm.emp_bank as bank',
                'users_atm.emp_health_card as health',
                'users_atm.emp_accident as accident',
                'users_atm.emp_phone_number as number',
                'users_atm.emp_phone_price as price',
                'users_atm.emp_phone_desc as desc'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Requested')
                    ->orWhere('users_profile.emp_approval', 'R-Approved');
            });
        return DataTables::of($getSome)
            ->make(true);
    }
    public function posDocDesc(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $getData = DB::table('users_profile')
            ->select('emp_full_name', 'emp_allowances')
            ->where('id', $request->positionIdChange)
            ->get();
        if($getData[0]->emp_allowances == '')
        {
            $allow = 'NONE';
        }
        else
        {
            $allow = $getData[0]->emp_allowances;
        }

        $file2 = $request->file('posFile');
        if ($file2 != null)
        {
            $encodedName = base64_encode($request->posTrans);
            $name2 =  $request->positionIdChange . '-'. $encodedName  . '.' .  $file2->getClientOriginalExtension();
            $path = '/position_change_files/' . $request->positionIdChange . '/' . $name2;
            $file2->move(storage_path('/position_change_files/' . $request->positionIdChange . '/'), $name2);
        }
        else
        {
            $path = '';
        }
        $logs = new AuditQueries();

        if($getData[0]->emp_allowances != $request->changeAllowance)
        {
            DB::table('users_profile')
                ->where('id', $request->positionIdChange)
                ->update
                ([
                    'emp_allowances' => $request->changeAllowance
                ]);
            $logs->create_profile_log('UPDATED ALLOWANCE FROM (' . $allow . ' TO ' . $request->changeAllowance . ') FROM THE PROFILE OF ' .  $getData[0]->emp_full_name , $request->positionIdChange ,Auth::user()->id );
        }

        DB::table('users_profile')
            ->where('id', $request->positionIdChange)
            ->update
            ([
                'emp_position' => $request->newPos
            ]);

        DB::table('emp_position_supp')
            ->insert
            ([
                'user_id' => $removeScript->scripttrim($request->positionIdChange) ,
                'type_change' => $removeScript->scripttrim($request->posType) ,
                'position_transition' => $removeScript->scripttrim($request->posTrans) ,
                'position_old' => $removeScript->scripttrim($request->oldPos) ,
                'position_new' => $removeScript->scripttrim($request->newPos) ,
                'supp_docu_path' => $path,
                'allowance_transition' => $allow . ' TO ' . $removeScript->scripttrim($request->changeAllowance) ,
                'pos_remarks' =>  $removeScript->scripttrim($request->remarks),
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        $logs->create_profile_log('UPDATED POSITION FROM (' . $trimmer->trims($request->oldPos) . ' TO ' . $removeScript->scripttrim($trimmer->trims($request->newPos))  .  ') WITH SUPPORTING DOCUMENTS FOR THE FROFILE OF ' . $getData[0]->emp_full_name , $removeScript->scripttrim($request->positionIdChange)  ,Auth::user()->id );
    }
    public function getOims(Request $request)
    {
        $getData = DB::table('emp_oims_gmail')
            ->select('emp_oims', 'emp_corporate_gmail')
            ->where('user_id', $request->oimsGetId)
            ->get();

        return response()->json($getData);
    }
    public function updateOims(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $getData = DB::table('users_profile')
            ->join('emp_oims_gmail', 'emp_oims_gmail.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'emp_oims_gmail.emp_oims as oims',
                'emp_oims_gmail.emp_corporate_gmail as gmail'
            ])
            ->where('users_profile.id', $request->oimsGetId)
            ->get();

        DB::table('emp_oims_gmail')
            ->where('user_id', $request->oimsGetId)
            ->update
            ([
                'emp_oims' => $removeScript->scripttrim($request->empOims) ,
                'emp_corporate_gmail' => $removeScript->scripttrim($request->empGmail) ,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $array1 = array('OIMS ACCESS' => $getData[0]->oims, 'CORPORATE GMAIL ACCESS' => $getData[0]->gmail);
        $array2 = array('OIMS ACCESS' => $removeScript->scripttrim($request->empOims) , 'CORPORATE GMAIL ACCESS' => $removeScript->scripttrim($request->empGmail) );

        if ($array1 != $array2) {
            $emplogs = '';
            for ($i = 0; $i < count($array1); $i++) {
                $allKeys1 = array_keys($array1);
                $allKeys2 = array_keys($array2);
                if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]])
                {
                    $emplogs .= $allKeys1[$i] . ' WITH EMAIL ADDRESS(' . $array2[$allKeys2[$i]] . '), ';
                }
            }
            if($emplogs != '') {
                $logs = new AuditQueries();
                $logs->create_profile_log('GAVE ' . $emplogs . ' TO ' . $getData[0]->name, $request->oimsGetId, Auth::user()->id);
            }
        }
        else  if ($array1 == $array2)
        {
            return response()->json(["change" => "change"]);
        }
    }
    public function showOims()
    {
        $getData = DB::table('users_profile')
            ->join('emp_oims_gmail', 'emp_oims_gmail.user_id', '=', 'users_profile.id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch',
                'users_profile.emp_position as position',
                'emp_oims_gmail.emp_oims as oims',
                'emp_oims_gmail.emp_corporate_gmail as gmail'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Requested')
                    ->orWhere('users_profile.emp_approval', 'R-Approved');
            });
        return DataTables::of($getData)
            ->make(true);
    }
    public function showPromotion()
    {
        $getData = DB::table('emp_position_supp')
            ->join('users_profile', 'users_profile.id', '=', 'emp_position_supp.user_id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'emp_position_supp.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch',
                'emp_position_supp.type_change as change',
                'emp_position_supp.position_transition as pos_trans',
                'emp_position_supp.allowance_transition as allowance',
                'emp_position_supp.pos_remarks as rem',
                'emp_position_supp.supp_docu_path as path'
            ])
        ->orderBy('id', 'DESC');
        return DataTables::of($getData)
            ->make(true);
    }
    public function downloadPromotion(Request $request)
    {
        $id = base64_decode($request->id);
        $getNames = DB::table('emp_position_supp')
            ->join('users_profile', 'users_profile.id', '=', 'emp_position_supp.user_id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'emp_position_supp.supp_docu_path as file',
                'emp_position_supp.position_transition as pos'
            ])
            ->where('emp_position_supp.id', $id)
            ->get();

        $ext = explode('.' , ($getNames[0]->file))[1];
        $dlName = $getNames[0]->name . '-' . $getNames[0]->pos . '.' . $ext;

        if(Auth::user()->hasRole('Human Resources'))
        {
            return response()->download(storage_path($getNames[0]->file), $dlName);
        }
        else
        {
            return response('Wrong move.');
        }
    }
    public function getPresentEmp()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.emp_approval as approval'
            ])
            ->where('users_profile.emp_process_status', '!=', 'Inactive Employee')
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Approved')
                    ->orWhere('users_profile.emp_approval', 'Partial');
            });
        return DataTables::of($getEmployees)
            ->make(true);
    }
    public function getPastEmp()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin'
            ])
            ->where('users_profile.emp_process_status', 'Inactive Employee')
            ->where('emp_approval', 'Approved');
        return DataTables::of($getEmployees)
            ->make(true);
    }
    public function tableContract()
    {
        $getData = DB::table('users_profile')
            ->leftjoin('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as stat',
                'users_profile.emp_outgoing as out',
                'users_profile.contract_file_path as path'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Approved')
                    ->orWhere('users_profile.emp_approval', 'Partial');
            });
        return DataTables::of($getData)
            ->make(true);
    }
    public function uploadFormFile(Request $request)
    {
        $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
        $code_date = explode('-',$code_date_time[0]);
        $code_time = explode(':',$code_date_time[1]);

        $fileCount = $request->countFiles;
        $path = '';

        $getId = DB::table('hr_forms')
            ->insertGetId
            ([
                'file_title' => $request->docTitle,
                'file_desc' => $request->docDesc,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        for($i = 0; $i < $fileCount; $i++)
        {
            $file = $request->file('file-'.$i.'');

            $name =  $request->docTitle . '-'. $i. '-' .$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2].'.' .$file->getClientOriginalExtension();
            $file->move(storage_path('/hr_general_forms/'.$getId.'/'), $name);
            $path = '/hr_general_forms/' . $getId. '/' . $name;

            DB::table('hr_forms_files')
                ->insert
                ([
                    'upload_id' => $getId,
                    'under_file_path' => $path,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        $logs = new AuditQueries();
        $logs->assign_items(''.$fileCount.' file/s uploaded with Title: ' . $request->docTitle.  ', Description : ' . $request->docDesc , '', '', Auth::user()->id, '');
        $logs->create_profile_log(''.$fileCount.' file/s uploaded with Title: ' . $request->docTitle.  ', Description : ' . $request->docDesc, '', Auth::user()->id);
    }
    public function tableGeneralForms()
    {
        $getData = DB::table('hr_forms')
            ->select('id', 'file_title', 'file_desc')
            ->where(function($query)
            {
               return $query->where('status', '')
                   ->orwhere('status', null);
            })
            ->orderByDesc('id');

        return DataTables::of($getData)
            ->make(true);
    }
    public function dlFormat(Request $request)
    {
        $id = base64_decode($request->id);

        $headers = ["Content-Type"=>"application/zip"];

        $getPath = DB::table('hr_forms_files')
            ->select('under_file_path')
            ->where('upload_id', $id)
            ->get();

        $getTitle = DB::table('hr_forms')
            ->select('file_title', 'created_at')
            ->where('id', $id)
            ->get();

        $code_date_time = explode(' ', $getTitle[0]->created_at);
        $code_date = explode('-',$code_date_time[0]);
        $code_time = explode(':',$code_date_time[1]);

        $fileName = $getTitle[0]->file_title . '_'.$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2]. ".zip";

        if(Auth::user()->hasRole('Human Resources'))
        {
            foreach($getPath as $path)
            {
                Zipper::make(storage_path('/hr_general_forms/'.$id. '/' .$fileName))
                    ->add(storage_path().$path->under_file_path)
                    ->close();
            }

            return response()
                ->download(storage_path('/hr_general_forms/'.$id. '/' .$fileName),$fileName, $headers)
                ->deleteFileAfterSend(true);
        }
        else
        {
            return response('');
        }
    }
    public function dlContract(Request $request)
    {
        $id = base64_decode($request->id);
        $getPath = DB::table('users_profile')
            ->select('contract_file_path')
            ->where('id', $id)
            ->get();
        if(Auth::user()->hasRole('Human Resources'))
        {
            if($getPath[0]->contract_file_path == null)
            {
                return response("File not Available. Upload to profile.");
            }
            else
            {
                return response()->download(storage_path($getPath[0]->contract_file_path));
            }
        }
        else
        {
            return response('Wrong Window');
        }
    }
    public function dlMotor(Request $request)
    {
        $id = base64_decode($request->id);
        $getPath = DB::table('motor_list')
            ->select('motor_file')
            ->where('id', $id)
            ->get();

        if(Auth::user()->hasRole('Human Resources'))
        {
            if($getPath[0]->motor_file == null)
            {
                return response("File not Available. Upload to profile.");
            }
            else
            {
                return response()->download(storage_path($getPath[0]->motor_file));
            }
        }
        else
        {
            return response('Wrong Window');
        }
    }
    public function insertEmpReqCheck(Request $request)
    {
        $checks = $request->myData;
        $id = $request->id;

        if($request->myData != '')
        {
            foreach ($checks as $check)
            {
                DB::table('emp_checklist')
                    ->insert
                    ([
                        'user_id' => $id,
                        'check_name' => $check
                    ]);
            }
        }
        else
        {

        }

    }
    public function updateEmpReqCheck(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $checks = $request->myData1;
        $id = $request->id;

        DB::table('emp_checklist')
            ->where('user_id', $id)
            ->delete();

        if($checks != '')
        {
            foreach ($checks as $check)
            {
                DB::table('emp_checklist')
                    ->insert
                    ([
                        'user_id' => $id,
                        'check_name' => $removeScript->scripttrim($check)
                    ]);
            }

            $getSome = DB::table('users_profile')
                ->select('emp_full_name')
                ->where('id', $id)
                ->get();

            $logs = new AuditQueries();
            $logs->create_profile_log('UPDATED REQUIREMENT CHECKLIST CHECKS OF ' . $getSome[0]->emp_full_name, $id, Auth::user()->id);
        }
        else
        {

        }

    }
    public function tablePendingEmp()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where('users_profile.emp_approval', 'R-Approved');

        return DataTables::of($getEmployees)
            ->make(true);
    }
    public function empApprove(Request $request)
    {
        $getSome = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->id)
            ->get();

        DB::table('users_profile')
            ->where('id' , $request->id)
            ->update
            ([
                'emp_approval' => 'Approved'
            ]);
        $logs = new AuditQueries();
        $logs->create_profile_log( $getSome[0]->emp_full_name . ' IS APPROVED AND ACTIVE', $request->id, Auth::user()->id);
    }
    public function empPartial(Request $request)
    {
        $getSome = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->id)
            ->get();
        DB::table('users_profile')
            ->where('id' , $request->id)
            ->update
            ([
                'emp_approval' => 'Partial',
                'partial_remarks' => $request->partialRem
            ]);
        $logs = new AuditQueries();
        $logs->create_profile_log($getSome[0]->emp_full_name . ' IS PARTIALLY APPROVED WITH INCOMPLETE REQUIREMENTS AND REMARKS', $request->id, Auth::user()->id);
    }

    public function empDenyRey(Request $request)
    {
        $trimmer = new Trimmer();

        $getSome = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->id)
            ->get();

        DB::table('users_profile')
            ->where('id' , $request->id)
            ->update
            ([
                'emp_approval' => 'R-Denied',
                'deny_remarks' => $request->emp_remarks,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs = new AuditQueries();
        $logs->create_profile_log($getSome[0]->emp_full_name . ' IS REJECTED AND NO LONGER CONNECTED TO CCSI WITH REMARKS: ' . $trimmer->trims($request->emp_remarks) , $request->id, Auth::user()->id);
    }

    public function empDeny(Request $request)
    {
        $trimmer = new Trimmer();

        $getSome = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->id)
            ->get();

        DB::table('users_profile')
            ->where('id' , $request->id)
            ->update
            ([
                'emp_approval' => 'Returned',
                'emp_status_tagging' => '',
                'incomplete_remarks' => '',
                'return_remarks' => $request->remarks,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs = new AuditQueries();
        $logs->create_profile_log('Application of '  .$getSome[0]->emp_full_name . ' RETURNED FOR EVALUATION WITH REMARKS : ' . $trimmer->trims($request->remarks), $request->id, Auth::user()->id);
    }
    public function getPartial(Request $request)
    {
        $getdata = DB::table('users_profile')
            ->select('partial_remarks')
            ->where('id', $request->id)
            ->get();

        return response()->json([$getdata[0]->partial_remarks]);
    }
    public function getReqRec()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status  as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', 'Requested')
                    ->orWhere('users_profile.emp_approval', 'R-Approved')
                    ->orWhere('users_profile.emp_approval', 'Returned');
            });

        return DataTables::of($getEmployees)
            ->make(true);
    }
    public function downloadEmpExcel()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->join('users_atm', 'users_atm.user_id', '=', 'users_profile.id')
            ->join('emp_oims_gmail', 'emp_oims_gmail.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as emp_id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_age as age',
                'users_profile.emp_religion as religion',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_atm.emp_id_card as id',
                'users_atm.emp_id_no as idno',
                'users_atm.emp_uniform as uniform',
                'users_atm.emp_health_card as health',
                'users_atm.emp_accident as accident',
                'users_atm.emp_bank as bank',
                'emp_oims_gmail.emp_oims as oims',
                'emp_oims_gmail.emp_corporate_gmail as gmail',
                'users_profile.created_at as encoded',
                'users_profile.ci_area_muni as area',
                'users_profile.commuter_type as cc'
            ])
            ->where('users_profile.emp_approval', 'Approved')
            ->get();

        if(Auth::user()->hasRole('Human Resources'))
        {
            Excel::create('General Employee List', function($excel) use ($getEmployees)
            {
                $excel->setTitle('General Employees');
                $excel->sheet('General Employee List', function($sheet) use ($getEmployees)
                {
                    $range1 = "A2:L2";
                    $sheet->cells($range1, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range2 = "N2:T2";
                    $sheet->cells($range2, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range3 = "V2:Y2";
                    $sheet->cells($range3, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range4 = "AC2:AD2";
                    $sheet->cells($range4, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range5 = "AF2:AG2";
                    $sheet->cells($range5, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range6 = "AI2:AL2";
                    $sheet->cells($range6, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });
                    $range7 = "AN2:AO2";
                    $sheet->cells($range7, function($cells) {
                        $cells->setBorder('thick', 'thick', 'thick', 'thick');
                    });

                    $sheet->mergeCells('A1:L1');
                    $sheet->mergeCells('N1:T1');
                    $sheet->mergeCells('V1:Y1');
                    $sheet->mergeCells('AC1:AD1');
                    $sheet->mergeCells('AF1:AG1');
                    $sheet->mergeCells('AI1:AL1');
                    $sheet->mergeCells('AN1:AO1');

                    $sheet->cell('A2', function($cell)
                    {
                        $cell->setValue('EMPLOYEE NAME');
                    });
                    $sheet->cell('B2', function($cell)
                    {
                        $cell->setValue('GENDER');
                    });
                    $sheet->cell('C2', function($cell)
                    {
                        $cell->setValue('MARITAL STATUS');
                    });
                    $sheet->cell('D2', function($cell)
                    {
                        $cell->setValue('DEPENDENTS');
                    });
                    $sheet->cell('E2', function($cell)
                    {
                        $cell->setValue('BIRTH DATE');
                    });
                    $sheet->cell('F2', function($cell)
                    {
                        $cell->setValue('AGE');
                    });
                    $sheet->cell('G2', function($cell)
                    {
                        $cell->setValue('RELIGION');
                    });
                    $sheet->cell('H2', function($cell)
                    {
                        $cell->setValue('PRIMARY CONTACT NUMBER');
                    });
                    $sheet->cell('I2', function($cell)
                    {
                        $cell->setValue('PRIMARY EMAIL ADDRESS');
                    });
                    $sheet->cell('J2', function($cell)
                    {
                        $cell->setValue('PRESENT ADDRESS');
                    });
                    $sheet->cell('K2', function($cell)
                    {
                        $cell->setValue('WORK EXPERIENCE');
                    });
                    $sheet->cell('L2', function($cell)
                    {
                        $cell->setValue('EDUCATIONAL BACKGROUND');
                    });

                    $sheet->cell('N2', function($cell)
                    {
                        $cell->setValue('POSITION');
                    });
                    $sheet->cell('O2', function($cell)
                    {
                        $cell->setValue('DATE HIRED');
                    });
                    $sheet->cell('P2', function($cell)
                    {
                        $cell->setValue('AREA OF ASSIGNMENT(FIELD VERIFIER)');
                    });
                    $sheet->cell('Q2', function($cell)
                    {
                        $cell->setValue('MOTORCYCLE TYPE(FIELD VERIFIER)');
                    });
                    $sheet->cell('R2', function($cell)
                    {
                        $cell->setValue('CONTRACT DURATION');
                    });
                    $sheet->cell('S2', function($cell)
                    {
                        $cell->setValue('CONTRACT STATUS');
                    });
                    $sheet->cell('T2', function($cell)
                    {
                        $cell->setValue('BRANCH');
                    });

                    $sheet->cell('V2', function($cell)
                    {
                        $cell->setValue('SSS');
                    });
                    $sheet->cell('W2', function($cell)
                    {
                        $cell->setValue('PHILHEALTH');
                    });
                    $sheet->cell('X2', function($cell)
                    {
                        $cell->setValue('PAGIBIG');
                    });
                    $sheet->cell('Y2', function($cell)
                    {
                        $cell->setValue('TIN');
                    });
                    $sheet->cell('AA2', function($cell)
                    {
                        $cell->setBorder('thick', 'thick', 'thick', 'thick');
                        $cell->setValue('FIXED SCHEDULE');
                    });
                    $sheet->cell('AC2', function($cell)
                    {
                        $cell->setValue('HEALTH CARD(INSURANCE)');
                    });
                    $sheet->cell('AD2', function($cell)
                    {
                        $cell->setValue('ACCIDENT INSURANCE');
                    });
                    $sheet->cell('AF2', function($cell)
                    {
                        $cell->setValue('CCSI GMAIL');
                    });
                    $sheet->cell('AG2', function($cell)
                    {
                        $cell->setValue('OIMS EMAIL');
                    });
                    $sheet->cell('AI2', function($cell)
                    {
                        $cell->setValue('ATM');
                    });
                    $sheet->cell('AJ2', function($cell)
                    {
                        $cell->setValue('ID ISSUANCE');
                    });
                    $sheet->cell('AK2', function($cell)
                    {
                        $cell->setValue('ID NO.');
                    });
                    $sheet->cell('AL2', function($cell)
                    {
                        $cell->setValue('UNIFORM');
                    });
                    $sheet->cell('AN2', function($cell)
                    {
                        $cell->setValue('DATE AND TIME ENCODED TO OIMS');
                    });
                    $sheet->cell('AO2', function($cell)
                    {
                        $cell->setValue('DATE AND TIME APPROVED');
                    });
                    if (!empty($getEmployees))
                    {
                        foreach ($getEmployees as $key => $value)
                        {
                            $i= $key+3;
                            $sheet->cell('A'.$i, $value->name);
                            $sheet->cell('B'.$i, $value->gender);
                            $sheet->cell('C'.$i, $value->marital);
                            $sheet->cell('D'.$i, $value->dependents);
                            $sheet->cell('E'.$i, $value->birth);
                            $sheet->cell('F'.$i, $value->age);
                            $sheet->cell('G'.$i, $value->religion);

                            $getcontactno = DB::table('users_contact_details')
                                ->select('emp_contact_info')
                                ->where('user_id', $value->emp_id)
                                ->where('contact_category', 'mobile number')
                                ->get();

                            $sheet->cell('H'.$i, $getcontactno[0]->emp_contact_info);

                            $getemailadd = DB::table('users_contact_details')
                                ->select('emp_contact_info')
                                ->where('contact_category', 'email address')
                                ->where('user_id', $value->emp_id)
                                ->get();

                            $sheet->cell('I'.$i, $getemailadd[0]->emp_contact_info);

                            $getpresentadd = DB::table('users_address')
                                ->select('emp_address')
                                ->where('address_category', 'present')
                                ->where('user_id', $value->emp_id)
                                ->get();

                            $sheet->cell('J'.$i, $getpresentadd[0]->emp_address);

                            $getWork = DB::table('users_work_experience')
                                ->select('company_name', 'company_position')
                                ->where('user_id', $value->emp_id)
                                ->get();

                            $workLoop = '';

                            foreach ($getWork as $work)
                            {
                                $workLoop .= $work->company_position . ' / ' . $work->company_name . ', ' ;
                            }
                            $sheet->cell('K'.$i, $workLoop);
                            $getEduc = DB::table('user_education')
                                ->select('educ_course', 'school_name', 'educ_level')
                                ->where('user_id', $value->emp_id)
                                ->get();

                            $educloop = '';

                            foreach ($getEduc as $educ)
                            {
                                $educloop .= $educ->educ_course . ' / ' . $educ->school_name . '(' . $educ->educ_level . '),' ;
                            }
                            $sheet->cell('L'.$i, $educloop);
                            $sheet->cell('N'.$i, $value->position);
                            $sheet->cell('O'.$i, $value->hired);
                            $sheet->cell('P'.$i, $value->area);
                            $sheet->cell('Q'.$i, $value->cc);
                            $sheet->cell('R'.$i, $value->hired . ' - ' . $value->end);
                            $sheet->cell('S'.$i, $value->con_status);
                            $sheet->cell('T'.$i, $value->branch);
                            $sheet->cell('V'.$i, $value->sss);
                            $sheet->cell('W'.$i, $value->philhealth);
                            $sheet->cell('X'.$i, $value->pagibig);
                            $sheet->cell('Y'.$i, $value->tin);

                            $getshed = DB::table('user_sched')
                                ->select('emp_fixed_sched')
                                ->where('days', 'Fixed')
                                ->where('user_id', $value->emp_id)
                                ->get();

                            $sheet->cell('AA'.$i, $getshed[0]->emp_fixed_sched);
                            $sheet->cell('AC'.$i, $value->health);
                            $sheet->cell('AD'.$i, $value->accident);
                            $sheet->cell('AF'.$i, $value->gmail);
                            $sheet->cell('AG'.$i, $value->oims);
                            $sheet->cell('AI'.$i, $value->bank);
                            $sheet->cell('AJ'.$i, $value->id);
                            $sheet->cell('AK'.$i, $value->idno);
                            $sheet->cell('AL'.$i, $value->uniform);
                            $sheet->cell('AN'.$i, $value->encoded);

                            $getApp = DB::table('profile_log')
                                ->select('created_at')
                                ->where('emp_id', $value->emp_id)
                                ->where('activities', 'like', '%APPROVED%')
                                ->get();
                            $sheet->cell('AO'.$i, $getApp[0]->created_at);
                        }
                    }
                });
            })->download('xlsx');
        }
        else
        {
            return 'Wrong Way :D!';
        }

    }

    public function human_resources_get_ci()
    {
        $ciLists = DB::table('users')
            ->join('role_user','role_user.user_id','users.id')
            ->select
            (
                [
                    'users.id',
                    'users.name'
                ]
            )
            ->where('role_user.role_id',4)
            ->where('users.archive','False')
            ->get();

        return response()->json($ciLists);
    }

    public function human_resources_employee_pending_rey()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where(function($query)
            {
                $query->where('users_profile.emp_approval', 'Requested')
                    ->orWhere('users_profile.emp_approval', 'R-Approved')
                    ->orWhere('users_profile.emp_approval', 'Returned');
            });
        return DataTables::of($getEmployees)
            ->make(true);
    }

    public function human_resources_pre_approve_prof(Request $request)
    {
        DB::table('users_profile')
            ->where('id', $request->id)
            ->update
            ([
                'emp_approval' => 'R-Approved'
            ]);
    }

    public function human_resources_get_employees_active()
    {

        $getEmp = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->where(function($query) {
                $query->where('users_profile.emp_approval', '!=', 'Denied')
                    ->orWhere('users_profile.emp_approval', '!=', 'R-Denied');
            })
            ->orderBy('users_profile.id', 'DESC')
            ->get();

        return response()->json($getEmp);
    }

    public function human_resources_view_denial_remarks(Request $request)
    {
        $getData = DB::table('users_profile')
            ->select('deny_remarks')
            ->where('id', $request->id)
            ->get();

        return response()->json($getData);
    }

    public function human_resources_submit_to_head(Request $request)
    {
        $getStat = DB::table('users_profile')
            ->select('emp_status_tagging', 'emp_full_name')
            ->where('id', $request->id)
            ->get();

        $logs = new AuditQueries();

        if($getStat[0]->emp_status_tagging != 'Incomplete')
        {
            DB::table('users_profile')
                ->where('id', $request->id)
                ->update
                ([
                    'emp_status_tagging' => 'Complete',
                    'emp_approval' => 'R-Approved',
                    'return_remarks' => '',
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else
        {
            DB::table('users_profile')
                ->where('id', $request->id)
                ->update
                ([
                    'emp_approval' => 'R-Approved',
                    'return_remarks' => '',
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);
        }

        $logs->create_profile_log('Application of '  .$getStat[0]->emp_full_name . ' IS PRE-APPROVED AND WILL BE REVIEWED BY HEAD', $request->id, Auth::user()->id);
    }

    public function human_resources_tag_incomplete(Request $request)
    {
        $logs = new AuditQueries();

        $getName = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->id)
            ->get();

        DB::table('users_profile')
            ->where('id', $request->id)
            ->update
            ([
                'emp_status_tagging' => 'Incomplete',
                'return_remarks' => '',
                'emp_approval' => 'Requested',
                'incomplete_remarks' => $request->remarks,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs->create_profile_log('Application of '  .$getName[0]->emp_full_name . ' TAGGED AS INCOMPLETE' , $request->id, Auth::user()->id);
    }

    public function human_resources_get_incomplete_remarks(Request $request)
    {
        $getData = DB::table('users_profile')
            ->select('incomplete_remarks')
            ->where('id', $request->id)
            ->get();

        return response()->json($getData);
    }

    public function human_resources_get_return_remarks(Request $request)
    {
        $getdata = DB::table('users_profile')
            ->select('return_remarks')
            ->where('id', $request->id)
            ->get();

        return response()->json($getdata);
    }

    public function human_resources_overall_monitoring()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'user_benefits.emp_sss as sss',
                'user_benefits.emp_philhealth as philhealth',
                'user_benefits.emp_pagibig as pagibig',
                'user_benefits.emp_tin as tin',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where('users_profile.emp_approval', '!=', 'R-Denied');

        return DataTables::of($getEmployees)
            ->make(true);
    }

    public function human_resources_get_reject_remarks(Request $request)
    {
        $getData = DB::table('users_profile')
            ->select('deny_remarks')
            ->where('id', $request->id)
            ->get();
        return response()->json($getData);
    }

    public function human_resources_get_prom_rem(Request $request)
    {
        $getData = DB::table('emp_position_supp')
            ->select('pos_remarks')
            ->where('id', $request->id)
            ->get();

        return response()->json($getData);
    }
    
    public function human_resources_generate_employee_attendance(Request $request)
    {
        if(Auth::user() != null)
        {
            if($request->added_date != '')
            {
//                $now = explode(' ', Carbon::parse('2020-03-20 16:10:00'))[0];
                $now = $request->added_date;
                $time = explode(' ', Carbon::now('Asia/Manila'))[1];
                $dataHolder = [];
                $dataHolderCtr = 0;
                $dataHolder[$dataHolderCtr] = [];
                $valChecker = [];
                $mainCtr = 0;
                $InOutNote = '';


                $getUsers = DB::table('users')
                    ->join('role_user' , 'role_user.user_id', '=', 'users.id')
                    ->join('roles' , 'roles.id', '=', 'role_user.role_id')
                    ->join('provinces', 'provinces.id', '=', 'users.branch')
                    ->join('regions', 'regions.id', '=', 'provinces.region_id')
                    ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
                    ->where(function($query)
                    {
//                        return $query->where('role_user.role_id', '!=', 1)
                            return $query->where('role_user.role_id', '!=', 4)
                            ->where('role_user.role_id', '!=', 6)
                            ->where('role_user.role_id', '!=', 14)
                            ->where('role_user.role_id', '!=', 999);
                    })
                    ->where('users.archive', '!=' , 'True')
                    ->select([
                        'users.id as id',
                        'users.name as name',
                        'provinces.name as branch',
                        'regions.region_name as region',
                        'provinces.name as archi',
                        'roles.name as position'
                    ])
                    ->orderBy('users.branch')
                    ->orderBy('users.name')
                    ->orderBy('roles.name')
                    ->get();

                if(count($getUsers) > 0)
                {
                    for($i =0; $i < count($getUsers); $i++)
                    {
                        $getAttendance = DB::table('attendance_all_employee')
                            ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
                            ->whereDate('attendance_all_employee.created_at' , '<=', Carbon::parse($now))
                            ->whereDate('attendance_all_employee.created_at' , '>', Carbon::parse($now)->subDay(1))
                            ->where('attendance_all_employee.user_id', $getUsers[$i]->id)
                            ->select([
                                'users.id as id',
                                'users.name as name',
                                'users.work_start as work_start',
                                'users.work_end as work_end',
                                'attendance_all_employee.time_in as time_in',
                                'attendance_all_employee.type as type',
                                'attendance_all_employee.ip_address as ip',
                            ])
                            ->orderBy('attendance_all_employee.id', 'asc')
                            ->get();

                        $dataHolder[$dataHolderCtr] = [];

                        if(count($getAttendance) > 0)
                        {
                            $testCtr = 0;
                            $InOutNote = '';
                            for($ii = 0; $ii < count($getAttendance); $ii++)
                            {
                                $testVal = $getAttendance[$ii]->type;
                                if(!array_key_exists($testVal, $dataHolder[$dataHolderCtr]))
                                {
                                    $dataHolder[$dataHolderCtr]["sched_in"] = $now . ' ' . date("H:i", strtotime($getAttendance[$ii]->work_start));
                                    $dataHolder[$dataHolderCtr]["sched_out"] = $now . ' ' . date("H:i", strtotime($getAttendance[$ii]->work_end));
                                    $dataHolder[$dataHolderCtr]["name"] = $getUsers[$i]->name;
                                    if($getUsers[$i]->position != 'Administrator')
                                    {
                                        $dataHolder[$dataHolderCtr]["position"] = $getUsers[$i]->position;
                                    }
                                    else
                                    {
                                        $dataHolder[$dataHolderCtr]["position"] = 'Software Developer';
                                    }
                                    $dataHolder[$dataHolderCtr]["remarks"] = 'WITH RECORD';
                                    $dataHolder[$dataHolderCtr]["archipelago"] = $getUsers[$i]->archi;
                                    $dataHolder[$dataHolderCtr]["ip_address"] = $getAttendance[$ii]->ip;
                                    $dataHolder[$dataHolderCtr][$testVal] = $getAttendance[$ii]->time_in;
                                }
                                else
                                {
                                    if($testVal == 'TIME-OUT')
                                    {
                                        $dataHolder[$dataHolderCtr][$testVal] = $getAttendance[$ii]->time_in;
                                    }
                                    else if($testVal == 'BREAKTIME-OUT')
                                    {
                                        $dataHolder[$dataHolderCtr][$testVal] = $getAttendance[$ii]->time_in;
                                    }
                                }

                                $testCtr++;
                            }
                        }
                        else
                        {
                            $dataHolder[$dataHolderCtr]["name"] = $getUsers[$i]->name;
                            if($getUsers[$i]->position != 'Administrator')
                            {
                                $dataHolder[$dataHolderCtr]["position"] = $getUsers[$i]->position;
                            }
                            else
                            {
                                $dataHolder[$dataHolderCtr]["position"] = 'Software Developer';
                            }
                            $dataHolder[$dataHolderCtr]["remarks"] = 'NO RECORD FOUND';
                            $dataHolder[$dataHolderCtr]["archipelago"] = $getUsers[$i]->archi;
                        }

                        $dataHolderCtr++;
                    }
                }

                Excel::load(storage_path().'/Generated Attendance Form.xlsx', function($doc) use($now, $time, $dataHolder, $mainCtr) {
                    $sheet = $doc->setActiveSheetIndex(0);
//                    $sheet->setCellValue('A1', 'GENERATED DATE/TIME:  ' .explode(' ', Carbon::now('Asia/Manila'))[0]. ' ' . date('g:i A', strtotime($time)));
                    $sheet->setCellValue('A1', 'GENERATED DATE:  ' .$now);

                    $remarks = '';
                    $sched = '';
                    for($iii = 4; $iii < (count($dataHolder) + 4); $iii++)
                    {
                        $remarks = '';
                        $sheet->setCellValue('A'.$iii, $dataHolder[$mainCtr]["name"]);
                        $sheet->setCellValue('B'.$iii, $dataHolder[$mainCtr]["position"]);

                        if($dataHolder[$mainCtr]["remarks"] != 'NO RECORD FOUND')
                        {
                            if(array_key_exists('TIME-IN', $dataHolder[$mainCtr]))
                            {
                                $sheet->setCellValue('C'.$iii,  date( 'g:i A', strtotime( $dataHolder[$mainCtr]["TIME-IN"] ) ));
                                $sched = date( 'g:i A', strtotime($dataHolder[$mainCtr]["sched_in"])) . ' - ' . date( 'g:i A', strtotime($dataHolder[$mainCtr]["sched_out"]));
                                $time_in = Carbon::parse($dataHolder[$mainCtr]["sched_in"])->addMinutes(15);
                                if(Carbon::parse($dataHolder[$mainCtr]["TIME-IN"]) > $time_in)
                                {
                                    $remarks = 'LATE ';

                                }
                            }
                            else
                            {
                                $sheet->setCellValue('C'.$iii, '-');
                            }


                            if(array_key_exists('BREAKTIME-IN', $dataHolder[$mainCtr]))
                            {
                                $sheet->setCellValue('E'.$iii, date( 'g:i A', strtotime( $dataHolder[$mainCtr]["BREAKTIME-IN"] ) ));
                            }
                            else
                            {
                                $sheet->setCellValue('E'.$iii, '-');
                            }

                            if(array_key_exists('BREAKTIME-OUT', $dataHolder[$mainCtr]))
                            {
                                $sheet->setCellValue('F'.$iii, date( 'g:i A', strtotime( $dataHolder[$mainCtr]["BREAKTIME-OUT"] ) ));
                            }
                            else
                            {
                                $sheet->setCellValue('F'.$iii, '-');
                            }

                            $sheet->setCellValue('G'.$iii, $dataHolder[$mainCtr]["ip_address"]);
                            $sheet->setCellValue('H'.$iii, $dataHolder[$mainCtr]["archipelago"]);

                            if(array_key_exists('TIME-OUT', $dataHolder[$mainCtr]))
                            {
                                $sheet->setCellValue('D'.$iii, date( 'g:i A', strtotime($dataHolder[$mainCtr]["TIME-OUT"])));
                                if(Carbon::parse($dataHolder[$mainCtr]["TIME-OUT"]) < Carbon::parse($dataHolder[$mainCtr]["sched_out"]))
                                {
                                    $remarks .= ' / EARLY OUT / ';
                                }
                                else
                                {
                                    substr($remarks, 0, -5);
                                }
                            }
                            else
                            {
                                substr($remarks, 0, -5);
                                $sheet->setCellValue('D'.$iii, '-');
                                $remarks .= ' / NO TIME-OUT /';
                            }


                            $sheet->setCellValue('I'.$iii, $sched);
                            $sheet->setCellValue('J'.$iii, $remarks);
                        }
                        else
                        {
                            $sheet->setCellValue('C'.$iii, '-');
                            $sheet->setCellValue('D'.$iii, '-');
                            $sheet->setCellValue('E'.$iii, '-');
                            $sheet->setCellValue('F'.$iii, '-');
                            $sheet->setCellValue('H'.$iii, $dataHolder[$mainCtr]["archipelago"]);
                            $sheet->setCellValue('I'.$iii, '-');
                            $sheet->setCellValue('J'.$iii, '-');
//                            $sheet->setCellValue('I'.$iii, '-');
                        }


                        $mainCtr++;
                    }

                })
                ->setFilename('Employee Attendance Dated '. $now)
                ->store('xlsx', storage_path('attendance/'.Auth::user()->id.'/' . $now));

                return response()->download(storage_path('attendance/'.Auth::user()->id.'/' . $now. '/'. 'Employee Attendance Dated '. $now. '.xlsx'));
            }
            else
            {
                return abort(404);
            }
        }
        else
        {
            return abort(404);
        }
    }
    
        public function human_resources_submit_issuance(Request $request)
    {

        $email = new EmailQueries();

        $email->hrIssuanceSend($request);

        $getId = DB::table('hr_issuance_main')
            ->insertGetId
            ([
                'issuance_to' => $request->receiver,
                'issuance_subject' => $request->subj,
                'issuance_content' => $request->content_iss,
                'issuance_sender' => Auth::user()->id,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        if($request->files_count > 0)
        {
            for($i = 0; $i < $request->files_count; $i++)
            {
                $file =  $request->file('file-' . $i . '');

                $name = $file->getClientOriginalName();
                $file->move(storage_path('/hr_issuance_files/' . $getId), $name);
                $path = '/hr_issuance_files/' . $getId . '/'. $name;

                DB::table('hr_issuance_files')
                    ->insert
                    ([
                        'issuance_id' => $getId,
                        'file_path' => $path,
                        'created_at' => Carbon::now('Asia/Manila'),
                        'file_name' => $name
                    ]);
            }
        }
    }

    public function human_resources_sent_monit_issuance()
    {
        $getData = DB::table('hr_issuance_main')
            ->join('users', 'users.id', '=', 'hr_issuance_main.issuance_sender')
            ->select
            ([
                'users.name as name_sender',
                'hr_issuance_main.created_at as date',
                'hr_issuance_main.issuance_to as  to',
                'hr_issuance_main.issuance_subject as subj',
                'hr_issuance_main.id as id'
            ]);

        return DataTables::of($getData)
            ->make(true);
    }

    public function human_resources_delete_sent_issuance(Request $request)
    {
        $data = $request->list_id;

         for($i=0; $i < count($data); $i++)
         {
             $getFIlePaths =  DB::table('hr_issuance_files')
                 ->select('file_path')
                 ->where('issuance_id', $data[$i])
                 ->get();

             if(count($getFIlePaths) > 0)
             {
                 for($v=0; $v < count($getFIlePaths); $v++)
                 {
                     unlink(storage_path($getFIlePaths[$v]->file_path));
                 }
             }

             DB::table('hr_issuance_main')
                 ->where('id', $data[$i])
                 ->delete();

             DB::table('hr_issuance_files')
                 ->where('issuance_id', $data[$i])
                 ->delete();
         }
    }

    public function human_resources_drafts_monit_issuance()
    {
        $getData = DB::table('hr_issuance_drafts')
            ->join('users', 'users.id', '=', 'hr_issuance_drafts.issuance_sender')
            ->select
            ([
                'users.name as name_sender',
                'hr_issuance_drafts.created_at as date',
                'hr_issuance_drafts.issuance_to as  to',
                'hr_issuance_drafts.issuance_subject as subj',
                'hr_issuance_drafts.id as id'
            ]);

        return DataTables::of($getData)
            ->make(true);
    }

    public function human_resources_get_info_iss(Request $request)
    {
        $id = base64_decode($request->id);

        $getInfo = DB::table('hr_issuance_main')
            ->select('issuance_subject', 'issuance_content')
            ->where('id', $id)
            ->get();

        $getFiles = DB::table('hr_issuance_files')
            ->select('id', 'file_name')
            ->where('issuance_id', $id)
            ->get();

        return response()->json([$getInfo, $getFiles]);
    }
}
