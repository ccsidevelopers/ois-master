<?php

namespace App\Http\Controllers;

use App\Endorsement;
use App\Generals\DashboardQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;

class AccountOfficerController extends Controller
{

    public function var_session()
    {
        return $ses = Session();
    }

    public function getAOpanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Account Officer')) {

                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                //            END

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i:s", strtotime($dateNow));

                return view('bank_dept.account_officer.ao-master', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount','dateNow', 'time','javs'));
            }

            return redirect()->route('privilege-error');
        }
    }

    public function getAoAccountProcess()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Account Officer')) {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i:s", strtotime($dateNow));
                return view('bank_dept.account_officer.ao-account-process', compact('dateNow', 'time'))->with(["page" => "ao-account-process"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getAoDashboard()
    {

        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Account Officer')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                //            END

                return view('bank_dept.account_officer.ao-dashboard', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount'))->with(["page" => "ao-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getAoEndorsement()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Account Officer')) {
                return view('bank_dept.account_officer.ao-endorsement')->with(["page" => "ao-endorsement"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function accountUpdateInfo(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.ci_internal_status',
                    'endorsements.endorsement_status_internal',
                    'endorsements.city_muni',
                ]
            )
            ->where('endorsements.id', $request->acctID)
            ->get()[0];

        $date_time_endorsed = Carbon::createFromFormat('Y-m-d H:i:s',$endorsements->date_endorsed.' '.$endorsements->time_endorsed);
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
        $date_time_due = Carbon::createFromFormat('Y-m-d H:i:s',$endorsements->date_due.' '.$endorsements->time_due);
        $date_time_due_ci = Carbon::createFromFormat('Y-m-d H:i:s',$endorsements->ci_internal_status);

        $get_client = DB::table('endorsement_user')
            ->select('client_id')
            ->where('endorsement_id',$request->acctID)
            ->where('position_id',6)
            ->get();

        $get_ao_tat = DB::table('tat_management')
            ->select('obw_tat')
            ->where('client_id',$get_client[0]->client_id)
            ->where('muni_id',$endorsements->city_muni)
            ->get();

        $status = '';
        $time_endorsed_add_hours = '';

        if(count($get_ao_tat) == 0)
        {
            //$status = "UNDECLARED";

            $time_endorsed_add_hours = $date_time_due_ci->addHour(1);
            $now_date_time = $now;

            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours, false);
            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);

//            if($endorsements->endorsement_status_internal == 'TAT')
//            {
                if ($difference_mins <= -1) {
                    $status = "OVERDUE";
                } else if ($difference_mins >= 0) {
                    $status = "TAT";
                };
//            }
//            else
//            {
//                $status = "OVERDUE";
//            }

        }
        else
            {

            $time_endorsed_add_hours = $date_time_due_ci->addHour($get_ao_tat[0]->obw_tat);
            $now_date_time = $now;

            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours, false);
            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);

//            if($endorsements->endorsement_status_internal == 'TAT')
//            {
                if ($difference_mins <= -1) {
                    $status = "OVERDUE";
                } else if ($difference_mins >= 0) {
                    $status = "TAT";
                };
//            }
//            else
//            {
//                $status = "OVERDUE";
//            }

        }


        DB::table('endorsements')
            ->where('id', $request->acctID)
            ->update
            ([
                'ao_internal_status' => $time_endorsed_add_hours,
                'endorsement_status_internal_2' => strtoupper($status),
                'picture_status' => strtoupper($request->txtPictureStatus),
                'type_of_sending_report' => strtoupper($request->txtTOSR),
                'add_verification' => strtoupper($request->txtVerAdd),
                'remarks' => $removeScript->scripttrim(strtoupper($request->txtRemarks))
            ]);

        //      TOTAL TIME LOSS
        $timeStampNoww = Carbon::parse($request->txtDateDue . ' ' . date("H:i", strtotime($request->txtTimeDue)));

        $dateEndorsed = Endorsement::find($request->acctID);
        $dateEndo = $dateEndorsed->date_ci_forwarded;
        $timeEndorsed = Endorsement::find($request->acctID);
        $timeEndo = $timeEndorsed->time_ci_forwarded;

        $dateTimeLoss = $timeStampNoww->diffForHumans(Carbon::parse($dateEndo . ' ' . $timeEndo));

        DB::table('timestamps')
            ->where('endorsement_id', $request->acctID)
            ->update(['time_ao' => $dateTimeLoss]);
        //      END

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user) {
            $role = $user->name;
            $this->var_session()->put('role', $role);
        }
        foreach ($users->provinces as $branch) {
            $userBranch = $branch->name;
            $this->var_session()->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($this->var_session()->get('role')),
                    'branch' => strtoupper($this->var_session()->get('userBranch')),
                    'activities' => strtoupper('UPDATED REPORT OF ' . $request->acctName),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );

        return response()->json('success');
    }

    public function getAoNewEndorsement(Request $request)
    {

        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;

        if($request->min_date_endorsed == '1111-01-01')
        {
            $min = Carbon::now('Asia/Manila')->subDays(30);
        }

        if($request->max_date_endorsed == '1111-01-01')
        {
            $max = Carbon::now('Asia/Manila');
        }


        $endorsementsss = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.provinces',
                    'endorsements.client_remarks',
                    'endorsements.requestor_name',
                    'endorsements.re_ci',
                    'endorsements.acct_status',
                    'endorsements.type_of_sending_report',
                    'endorsements.ci_cert',
                    'endorsements.city_muni',
                    'endorsements.address',
                    'endorsements.ci_internal_status',
                    'endorsements.endorsement_status_internal',
                    'municipalities.muni_name',
                    'notes.endorsement_note as nononote'
                ]
            )
            ->where('endorsement_user.user_id', Auth::user()->id)
            ->where('endorsements.type_of_sending_report', '')
            ->where('endorsements.ci_cert', '!=', 'C')
            ->where('endorsements.date_endorsed', '>=',$min)
            ->where('endorsements.date_endorsed', '<=',$max);

        return DataTables::of($endorsementsss)
            ->editColumn('time_due', function ($endorsements) {

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->date_due . ' ' . $endorsements->time_due);
                $date->subHours(1);
                $splitDateTime = explode(" ", $date);
                $dates = $splitDateTime[0];
                $time = $splitDateTime[1];

                return $time;



            })
            ->editColumn('tat', function ($endorsements) {

                $date_time_due = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->date_due . ' ' . $endorsements->time_due);
                $date_time_endorsed = Carbon::createFromFormat('Y-m-d H:i:s',$endorsements->date_endorsed.' '.$endorsements->time_endorsed);
                $date_time_ci_due = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->ci_internal_status);

                $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));

                $get_client = DB::table('endorsement_user')
                    ->select('client_id')
                    ->where('endorsement_id',$endorsements->id)
                    ->where('position_id',6)
                    ->get();

                $get_ao_tat = DB::table('tat_management')
                    ->select('obw_tat')
                    ->where('client_id',$get_client[0]->client_id)
                    ->where('muni_id',$endorsements->city_muni)
                    ->get();



                if($endorsements->acct_status != 1 && $endorsements->acct_status != 2 && $endorsements->acct_status != 3)
                {
                    return '...';
                }
                else
                {

                    if($endorsements->endorsement_status_internal == 'TAT')
                    {
                        if(count($get_ao_tat) == 0)
                        {
                            //default
                            $time_endorsed_add_hours = $date_time_ci_due->addHour(1);

                            $now_date_time = $now;


                            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours,false);
                            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours,false);

                            if($difference_mins <= -1)
                            {
                                return $time_endorsed_add_hours.' <small class="label bg-black">late</small>';
                            }
                            else if ($difference_mins <= 10)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 10mins left</small>';
                            }
                            else if ($difference_mins <= 20)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 20mins left</small>';
                            }
                            else if ($difference_mins <= 30)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 30mins left</small>';
                            }
                            else if ($difference_mins <= 60)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 1hr left</small>';
                            }
                            elseif ($difference_mins <= 120)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-yellow">< 2hrs left</small>';
                            }
                            elseif ($difference_mins <= 180)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-orange">< 3hrs left</small>';
                            }
                            elseif ($difference_mins <= 240)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-light-blue">< 4hrs left</small>';
                            }
                            elseif ($difference_mins <= 1439)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-green">> 4hrs left</small>';
                            }
                            elseif ($difference_mins >= 1440)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-green">> 1 day</small>';
                            }

                        }
                        else
                        {
                            $time_endorsed_add_hours = $date_time_ci_due->addHour($get_ao_tat[0]->obw_tat);

                            $now_date_time = $now;
                            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours,false);
                            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours,false);

                            if($difference_mins <= -1)
                            {
                                return $time_endorsed_add_hours.' <small class="label bg-black">late</small>';
                            }
                            else if ($difference_mins <= 10)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 10mins left</small>';
                            }
                            else if ($difference_mins <= 20)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 20mins left</small>';
                            }
                            else if ($difference_mins <= 30)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 30mins left</small>';
                            }
                            else if ($difference_mins <= 60)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-red">< 1hr left</small>';
                            }
                            elseif ($difference_mins <= 120)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-yellow">< 2hrs left</small>';
                            }
                            elseif ($difference_mins <= 180)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-orange">< 3hrs left</small>';
                            }
                            elseif ($difference_mins <= 240)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-light-blue">< 4hrs left</small>';
                            }
                            elseif ($difference_mins <= 1439)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-green">> 4hrs left</small>';
                            }
                            elseif ($difference_mins >= 1440)
                            {
                                return $time_endorsed_add_hours . ' <small class="label bg-green">> 1 day</small>';
                            }

                        }
                    }
                    else
                    {
                        if(count($get_ao_tat) == 0)
                        {

                            if($endorsements->acct_status != 1)
                            {

                                $time_endorsed_add_hours = $date_time_ci_due->addHour(1);

                                return $time_endorsed_add_hours.' <small class="label bg-black">late (template from C.I)</small>';
                            }
                            else
                            {
                                return '....';
                            }


                        }
                        else
                        {

                            if($endorsements->acct_status != 1)
                            {
                                $time_endorsed_add_hours = $date_time_ci_due->addHour($get_ao_tat[0]->obw_tat);
                                return $time_endorsed_add_hours.' <small class="label bg-black">late (template from C.I)</small>';
                            }
                            else
                            {
                                return '....';
                            }

                        }

                    }

                }




//                if ($now->diffInMinutes($date, false) >= 0 && $now->diffInMinutes($date, false) <= 60) {
//                    return $time . ' <small class="label bg-red">< 1hr left</small>';
//                } elseif ($now->diffInMinutes($date, false) >= 0 && $now->diffInMinutes($date, false) <= 120) {
//                    return $time . ' <small class="label bg-yellow">< 2hrs left</small>';
//                } elseif ($now->diffInMinutes($date, false) >= 0 && $now->diffInMinutes($date, false) <= 180) {
//                    return $time . ' <small class="label bg-orange">< 3hrs left</small>';
//                } elseif ($now->diffInMinutes($date, false) >= 0 && $now->diffInMinutes($date, false) <= 240) {
//                    return $time . ' <small class="label bg-light-blue">< 4hrs left</small>';
//                } elseif ($now->diffInMinutes($date, false) > 240) {
//                    return $time . ' <small class="label bg-green">> 4hrs left</small>';
//                } elseif ($now->diffInMinutes($date, false) > 1440) {
//                    return $time . ' <small class="label bg-green">> 1 day</small>';
//                } else {
//                    return $time;
//                }
            })
            ->editColumn('type_of_request', function ($query)
            {
                if($query->type_of_request == 'PDRN')
                {
                    return '<b>PDRN</b>';
                }
                else if($query->type_of_request == 'BVR')
                {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>BVR:<br></b>'.$getinfo[0]->business_name.'</br>';

                }
                else if($query->type_of_request == 'EVR')
                {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>EVR:<br></b>'.$getinfo[0]->employer_name.'</br>';
                }
                else
                {
                    return '';
                }
            })
            ->rawColumns(['time_due','tat','type_of_request'])
            ->make(true);
    }

    public function getAoFinishEndorsement(Request $request)
    {
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;

        if($request->min_date_endorsed == '1111-01-01')
        {
            $min = Carbon::now('Asia/Manila')->subDays(30);
        }

        if($request->max_date_endorsed == '1111-01-01')
        {
            $max = Carbon::now('Asia/Manila');
        }

        $endorsementsss = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.ao_internal_status',
                    'endorsements.endorsement_status_internal_2',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.type_of_sending_report',
                    'endorsements.provinces',
                    'endorsements.client_remarks',
                    'endorsements.requestor_name',
                    'endorsements.re_ci',
                    'endorsements.acct_status',
                    'endorsements.ci_cert',
                    'endorsements.link_path',
                    'municipalities.muni_name',
                    'notes.endorsement_note as nononote'
                ]
            )
            ->where('endorsement_user.user_id', Auth::user()->id)
            ->where('endorsements.type_of_sending_report', '!=', '')
            ->where('endorsements.date_endorsed', '>=', $min)
            ->where('endorsements.date_endorsed', '<=', $max);

        return DataTables::of($endorsementsss)
            ->editColumn('type_of_request', function ($query)
            {
                if($query->type_of_request == 'PDRN')
                {
                    return '<b>PDRN</b>';
                }
                else if($query->type_of_request == 'BVR')
                {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>BVR:<br></b>'.$getinfo[0]->business_name.'</br>';

                }
                else if($query->type_of_request == 'EVR')
                {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>EVR:<br></b>'.$getinfo[0]->employer_name.'</br>';
                }
                else
                {
                    return '';
                }
            })
            ->rawColumns(['type_of_request'])
            ->make(true);
    }

    public function downloadFile(Request $request)
    {
        $id = base64_decode($request->id);
        $account_name = base64_decode($request->acctName);
        $token_dec = base64_decode($request->token);

        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($id);


        if(Auth::user()->hasRole('Account Officer'))
        {
            $endoCert = DB::table('endorsements')
                ->where('id', $id)
                ->select('ci_cert')
                ->first();

            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $users = User::find(Auth::user()->id);
            foreach ($users->roles as $user) {
                $role = $user->name;
                $this->var_session()->put('role', $role);
            }
            foreach ($users->provinces as $branch) {
                $userBranch = $branch->name;
                $this->var_session()->put('userBranch', $userBranch);
            }

            DB::table('audits')
                ->insert
                (
                    [
                        'endorsement_id' =>$id,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper( $this->var_session()->get('role')),
                        'branch' => strtoupper( $this->var_session()->get('userBranch')),
                        'activities' => strtoupper('Downloaded Report of ' . $account_name),
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );

            DB::table('endorsements')
                ->where('id', $id)
                ->update
                (
                    [
                        'date_ao_download' => $date,
                        'time_ao_download' => $time,
                    ]
                );

//        $headers = [ 'Content-Type' => 'application/zip' ];

            if ($endoCert->ci_cert == "NC")
            {
                if (File::isDirectory(storage_path('account/' . $paths)))
                {
                    Zip::create(storage_path('account_zip/' . $paths . '.zip'), true)
                        ->add(storage_path('account/' . $paths), true)
                        ->setPath(storage_path('account_zip'))
                        ->close();

                    return response()->download(storage_path("account_zip/" . $paths . ".zip"));
                }
                else
                {
                    echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                }


            } else if ($endoCert->ci_cert == "C")
            {
                if (File::isDirectory(storage_path('account_client/' . $paths)))
                {
                    Zip::create(storage_path('account_zip/' . $paths . '.zip'), true)
                        ->add(storage_path('account_client/' . $paths), true)
                        ->setPath(storage_path('account_zip'))
                        ->close();

                    return response()->download(storage_path("account_zip/" . $paths . ".zip"));
                }
                else
                {
                    echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';

                }

            }
        }
        else
        {
            return response('');
        }
    }

    public function viewFullInfo(Request $request)
    {
        $datas = DB::table('endorsements')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->select('endorsements.*', 'municipalities.*')
            ->where('endorsements.id', $request->acctID)
            ->get();

        $audit = DB::table('audits')
            ->where('endorsement_id', $request->acctID)
            ->get();

        $cobInfo = DB::table('endorsements')
            ->join('coborrowers', 'coborrowers.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'coborrowers.coborrower_name',
                    'coborrowers.coborrower_address',
                    'coborrowers.coborrower_municipality',
                    'coborrowers.coborrower_province',
                ]
            )
            ->where('endorsements.id', $request->acctID)
            ->get();

        $empInfo = DB::table('endorsements')
            ->join('employers', 'employers.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'employers.employer_name',
                    'employers.employer_address',
                    'employers.employer_municipality',
                    'employers.employer_province',
                ]
            )
            ->where('endorsements.id', $request->acctID)
            ->get();

        $busInfo = DB::table('endorsements')
            ->join('businesses', 'businesses.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'businesses.business_name',
                    'businesses.business_address',
                    'businesses.business_municipality',
                    'businesses.business_province',
                ]
            )
            ->where('endorsements.id', $request->acctID)
            ->get();

        $notes = DB::table('endorsements')
            ->join('notes', 'notes.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'notes.endorsement_note as nonotes'
                ]
            )
            ->where('endorsements.id', $request->acctID)
            ->get();

        return response()->json([$datas, $audit, $cobInfo, $empInfo, $busInfo, $notes]);
    }

//     public function getAddress(Request $request)
//     {
//         $date_time = Carbon::now('Asia/Manila');

// //        $get_acct = DB::table('endorsements')
// //            ->where('id', $request->acctID)
// //            ->select(['address', 'city_muni', 'provinces', 'add_verification','ci_cert','account_name','type_of_request'])
// //            ->get();

//         $get_acct =  DB::table('endorsement_user')
//             ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
//             ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
//             ->join('provinces','provinces.id','=','municipalities.province_id')
//             ->join('users','users.id','=','endorsement_user.user_id')
//             ->select
//             (
//                 [
//                     'endorsements.account_name',
//                     'endorsements.type_of_request',
// //                    'municipalities.muni_name as muni_name',
//                     'endorsements.address',
// //                    'endorsements.provinces',
// //                    'endorsements.dl_link',
// //                    'endorsements.down_email_key',
// //                    'endorsements.remarks as remarks',
//                     'endorsements.address as address',
//                     'endorsements.city_muni as city_muni',
//                     'endorsements.provinces as provinces',
//                     'endorsements.add_verification as add_verification',
//                     'endorsements.ci_cert as ci_cert',
//                     'users.name',
//                     'endorsement_user.position_id',
//                     'users.email',

//                 ]
//             )
//             ->where('endorsements.id',$request->acctID)
//             ->where(function ($query)
//             {
//                 return $query->where('endorsement_user.position_id',3)
//                     ->orwhere('endorsement_user.position_id',7)
//                     ->orwhere('endorsement_user.position_id',6);

//             })
//             ->get();

//         foreach ($get_acct as $get)
//         {
//             if($get->position_id == 3)
//             {
// //                $getao = $get->name;
//                 $getao_email = $get->email;;
//             }
//             else if($get->position_id == 7)
//             {
// //                $getsao = $get->name;
//                 $getsao_email = $get->email;;
//             }
//             else if($get->position_id == 6)
//             {
//                 $client_email = $get->email;;
//             }
//             $get_account_name = $get->account_name;
// //            $get_address = $get->address.', '.strtoupper($get->muni_name).', '.$get->provinces;
//             $get_tor = $get->type_of_request;
// //            $filepath = $get->dl_link;
// //            $remarks = $get->remarks;
// //            $dmk = $get->down_email_key;
//         }


//         $subject_send = 'CCSI OIMS - REPORT OF: ('.$get_account_name.')'.'/('.$get_tor.')'.'/('.$date_time.')';


//         $getReciList = DB::table('ao_recipient')
//             ->select([
//                 'list_name as name',
//                 'id as id'
//             ])
//             ->where('user_id',Auth::user()->id)
//             ->get();

//         return response()->json([$get_acct,$getReciList,$subject_send,$getao_email,$getsao_email,$client_email]);
//     }

    public function getAddress(Request $request)
    {
        $date_time = Carbon::now('Asia/Manila');

//        $get_acct = DB::table('endorsements')
//            ->where('id', $request->acctID)
//            ->select(['address', 'city_muni', 'provinces', 'add_verification','ci_cert','account_name','type_of_request'])
//            ->get();

        $get_acct =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->join('users','users.id','=','endorsement_user.user_id')
            ->select
            (
                [
                    'endorsements.account_name',
                    'endorsements.type_of_request',
//                    'municipalities.muni_name as muni_name',
                    'endorsements.address',
//                    'endorsements.provinces',
//                    'endorsements.dl_link',
//                    'endorsements.down_email_key',
//                    'endorsements.remarks as remarks',
                    'endorsements.address as address',
                    'endorsements.city_muni as city_muni',
                    'endorsements.provinces as provinces',
                    'endorsements.add_verification as add_verification',
                    'endorsements.ci_cert as ci_cert',
                    'users.name',
                    'endorsement_user.position_id',
                    'users.email',
                    'endorsement_user.user_id'
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->where(function ($query)
            {
                return $query->where('endorsement_user.position_id',3)
                    ->orwhere('endorsement_user.position_id',7)
                    ->orwhere('endorsement_user.position_id',6);

            })
            ->get();

        foreach ($get_acct as $get)
        {
            if($get->position_id == 3)
            {
//                $getao = $get->name;
                $getao_email = $get->email;;
            }
            else if($get->position_id == 7)
            {
//                $getsao = $get->name;
                $getsao_email = $get->email;;
            }
            else if($get->position_id == 6)
            {
                $client_email = $get->email;;
            }
            $get_account_name = $get->account_name;
//            $get_address = $get->address.', '.strtoupper($get->muni_name).', '.$get->provinces;
            $get_tor = $get->type_of_request;
//            $filepath = $get->dl_link;
//            $remarks = $get->remarks;
//            $dmk = $get->down_email_key;
        }


        $subject_send = 'CCSI OIMS - REPORT OF: ('.$get_account_name.')'.'/('.$get_tor.')'.'/('.$date_time.')';


        $getReciList = DB::table('ao_recipient')
            ->select([
                'list_name as name',
                'id as id'
            ])
            ->where('user_id',Auth::user()->id)
            ->get();

        $get_acct_2 =  DB::table('endorsement_user')
            ->select('client_id')
            ->where('position_id', 6)
            ->where('endorsement_id', $request->acctID)
            ->get();

        $getBool = DB::table('email_dist_client')
            ->select('applicable_bool')
            ->where('client_branch_id', $get_acct_2[0]->client_id)
            ->get();

        $getBoolEmail = [];
        $emailTo = [];

        if(count($getBool) > 0)
        {
            $getBoolEmail = $getBool[0]->applicable_bool;

            if($getBool[0]->applicable_bool == 'true')
            {
                $getLuzon = DB::table('email_dist_client_to_users')
                    ->select('user_email')
                    ->where('client_branch_id', $get_acct_2[0]->client_id)
                    ->where('type', 'LUZON')
                    ->get();

                $getVIs = DB::table('email_dist_client_to_users')
                    ->select('user_email')
                    ->where('client_branch_id', $get_acct_2[0]->client_id)
                    ->where('type', 'VISAYAS')
                    ->get();

                $getMind = DB::table('email_dist_client_to_users')
                    ->select('user_email')
                    ->where('client_branch_id', $get_acct_2[0]->client_id)
                    ->where('type', 'MINDANAO')
                    ->get();

                array_push($emailTo, [$getLuzon, $getVIs, $getMind]);
            }
            else if($getBool[0]->applicable_bool == 'false')
            {
                $getEmailsNot = DB::table('email_dist_client_to_users')
                    ->select('user_email')
                    ->where('client_branch_id', $get_acct_2[0]->client_id)
                    ->get();

                array_push($emailTo, $getEmailsNot);

            }
        }
        else if(count($getBool) == 0)
        {
            $getBoolEmail = 'none';

        }

        return response()->json([$get_acct,$getReciList,$subject_send,$getao_email,$getsao_email,$client_email, $getBoolEmail, $emailTo ]);
    }

    public function uploadReportFile(Request $request)
    {

        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($request->acctID);

        $date = '';
        $time = '';
        $tatOverdue = '';
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $dateN = $splitDateTime[0];
        $timeN = $splitDateTime[1];

        $dateDues = DB::table('endorsements')
            ->select(['date_due','date_endorsed','time_endorsed','time_due','city_muni','ci_internal_status','endorsement_status_internal'])
            ->where('id', $request->acctID)
            ->get()[0];

        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
        $date_time_due = Carbon::createFromFormat('Y-m-d H:i:s',$dateDues->date_due.' '.$dateDues->time_due);
        $date_time_endorsed = Carbon::createFromFormat('Y-m-d H:i:s',$dateDues->date_endorsed.' '.$dateDues->time_endorsed);
        $date_time_due_ci = Carbon::createFromFormat('Y-m-d H:i:s',$dateDues->ci_internal_status);

        $get_client = DB::table('endorsement_user')
            ->select('client_id')
            ->where('endorsement_id',$request->acctID)
            ->where('position_id',6)
            ->get();

        $get_ao_tat = DB::table('tat_management')
            ->select('obw_tat')
            ->where('client_id',$get_client[0]->client_id)
            ->where('muni_id',$dateDues->city_muni)
            ->get();


        $status_external = '';

        if(count($get_ao_tat) == 0)
        {
            //$status = "UNDECLARED";

            $time_endorsed_add_hours = $date_time_due_ci->addHour(1);
            $now_date_time = $now;

            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours, false);
            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);

            if($dateDues->endorsement_status_internal == 'TAT')
            {
                if ($difference_mins <= -1) {
                    $status = "OVERDUE";
                } else if ($difference_mins >= 0) {
                    $status = "TAT";
                };
            }
            else
            {
                $status = "OVERDUE";
            }

        }
        else {

            $time_endorsed_add_hours = $date_time_due_ci->addHour($get_ao_tat[0]->obw_tat);
            $now_date_time = $now;

            $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours, false);
            $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);

            if($dateDues->endorsement_status_internal == 'TAT')
            {
                if ($difference_mins <= -1) {
                    $status = "OVERDUE";
                } else if ($difference_mins >= 0) {
                    $status = "TAT";
                };
            }
            else
            {
                $status = "OVERDUE";
            }

        }

        if (Input::hasFile('file'))
        {
            $file = $request->file('file');

            //you also need to keep file extension as well
            $name = $paths . '.' . $file->getClientOriginalExtension();

            if($file->getClientOriginalExtension() != 'zip')
            {
                return response()->json('error');
            }
            else
            {
                //for email
                $token = Str::random(25).Carbon::now('Asia/Manila');
                $dmk = hash('sha256', $token);

                //using array instead of object
                $file->move(storage_path('/account_report/'), $name);

                //updating external status
                DB::table('endorsements')
                    ->where('id', $request->acctID)
                    ->update
                    ([
                        'date_forwarded_to_client' => $dateN,
                        'time_forwarded_to_client' => $timeN,
                        'dl_link' => $request->root().'/api/download_account_link?dl='.base64_encode($request->acctID).'&dll='.base64_encode($paths).'',
                        'down_email_key' => $dmk,
                        'acct_status' => 3,
                        'endorsement_status_external' => strtoupper($status),
                    ]);

                //insert audit date and time forwarded to client
                $users = User::find(Auth::user()->id);
                foreach ($users->roles as $user) {
                    $role = $user->name;
                    $this->var_session()->put('role', $role);
                }
                foreach ($users->provinces as $branch) {
                    $userBranch = $branch->name;
                    $this->var_session()->put('userBranch', $userBranch);
                }

                $getName = DB::table('endorsements')
                    ->select('account_name')
                    ->where('id', $request->acctID)
                    ->first();

                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $request->acctID,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper( $this->var_session()->get('role')),
                            'branch' => strtoupper( $this->var_session()->get('userBranch')),
                            'activities' => strtoupper('ACCOUNT ' . $getName->account_name . ' WAS FORWARDED TO CLIENT'),
                            'date_occured' => $dateN,
                            'time_occured' => $timeN
                        ]
                    );

                $emailSend = new EmailQueries();
                $emailSend->AOSendReport(
                    $request->acctID,
                    $request->subject,
                    json_decode($request->array_to),
                    json_decode($request->array_cc),
                    $request->remarks
                );

                return response()->json('success');
            }
        }
        return response()->json('error');
    }

    public function ao_send_email_report_to_client(Request $request)
    {



    }

    public function ao_save_recipient_list(Request $request)
    {
        $get_name = $request->recipient_name;
        $get_to_name = $request->to_name;
        $get_cc_name = $request->cc_name;
        $get_to_val = $request->to_val;
        $get_cc_val = $request->cc_val;
        $to_count = $request->to_count;
        $cc_count = $request->cc_count;

        $get_id_inserted = DB::table('ao_recipient')
            ->insertGetId([
                'user_id' => Auth::user()->id,
                'list_name' => $get_name,
                'date_time' => Carbon::now('Asia/Manila')
            ]);

        for($ctr = 0; $ctr < $to_count; $ctr++)
        {
            DB::table('recipient_list')
                ->insert([
                    'recip_id' => $get_id_inserted,
                    'value' => $get_to_val[$ctr],
                    'html' => $get_to_name[$ctr],
                    'type' => 'to'
                ]);
        }

        for($ctr_v2 = 0; $ctr_v2 < $cc_count; $ctr_v2++)
        {
            DB::table('recipient_list')
                ->insert([
                    'recip_id' => $get_id_inserted,
                    'value' => $get_cc_val[$ctr_v2],
                    'html' => $get_cc_name[$ctr_v2],
                    'type' => 'cc'
                ]);
        }
    }

    public function ao_get_recip_list_table()
    {
        $tab = DB::table('ao_recipient')
            ->select([
                'list_name as name',
                'id as id'
            ])
            ->where('user_id',Auth::user()->id);

        return DataTables::of($tab)
            ->make(true);
    }

    public function ao_delete_recip_list(Request $request)
    {
        DB::table('ao_recipient')
            ->where('id',$request->id)
            ->delete();

        DB::table('recipient_list')
            ->where('recip_id',$request->id)
            ->delete();

    }

    public function ao_view_recip_list(Request $request)
    {
        $get = DB::table('ao_recipient')
            ->join('recipient_list','recipient_list.recip_id','=','ao_recipient.id')
            ->select([
                'ao_recipient.list_name as name',
                'recipient_list.value as val',
                'recipient_list.html as email',
                'recipient_list.type as type'
            ])
            ->where('ao_recipient.id',$request->id)
            ->get();

        return response()->json($get);
    }

    public function ao_update_recip_list(Request $request)
    {
        $get_name = $request->recipient_name;
        $get_to_name = $request->to_name;
        $get_cc_name = $request->cc_name;
        $get_to_val = $request->to_val;
        $get_cc_val = $request->cc_val;
        $to_count = $request->to_count;
        $cc_count = $request->cc_count;
        $id = $request->id;

        DB::table('ao_recipient')
            ->where('id',$id)
            ->update([
//                'user_id' => Auth::user()->id,
                'list_name' => $get_name,
                'date_time' => Carbon::now('Asia/Manila')
            ]);

        DB::table('recipient_list')
            ->where('recip_id',$id)
            ->delete();

        for($ctr = 0; $ctr < $to_count; $ctr++)
        {
            DB::table('recipient_list')
                ->insert([
                    'recip_id' => $id,
                    'value' => $get_to_val[$ctr],
                    'html' => $get_to_name[$ctr],
                    'type' => 'to'
                ]);
        }

        for($ctr_v2 = 0; $ctr_v2 < $cc_count; $ctr_v2++)
        {
            DB::table('recipient_list')
                ->insert([
                    'recip_id' => $id,
                    'value' => $get_cc_val[$ctr_v2],
                    'html' => $get_cc_name[$ctr_v2],
                    'type' => 'cc'
                ]);
        }
    }

    public function ao_trigger_to_get_list_recipients(Request $request)
    {
        $id = $request->id;

        $get = DB::table('recipient_list')
            ->select([
                'value',
                'html',
                'type'
            ])
            ->where('recip_id',$id)
            ->get();

        return response()->json($get);
    }
}