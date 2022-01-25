<?php

namespace App\Http\Controllers;

use App\bi_log;
use App\Generals\TatController;
use App\Generals\Trimmer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CISupervisorController extends Controller
{
    public function ci_sup_panel()
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
            } elseif (Auth::user()->hasRole('C.I Supervisor')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;

                return view('ci_supervisor.ci-supervisor-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiList()
    {
        $ciLists = DB::table('users')
            ->join('role_user','role_user.user_id','=', 'users.id')
            ->join('provinces', 'provinces.id', '=', 'users.branch')
            ->join('regions', 'regions.id','=', 'provinces.region_id')
            ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
            ->where('role_user.role_id',4)
            ->where('users.archive','False')
            ->select
            (
                [
                    'users.id',
                    'users.name',
                    'archipelagos.archipelago_name'
                ]
            )
            ->groupBy('users.name')
            ->orderBy('users.id', 'asc')
            ->get();

        return response()->json($ciLists);
    }

    public function getAllRealtime(Request $request)
    {
        $ci_id = $request->id;

        $user = DB::table('users')
            ->where('id', $ci_id)
            ->get();

        $onhand = DB::table('ci_fund_realtime_amount')
            ->where('user_id',$ci_id)
            ->get();

//        return 'testing';
        return response()->json([$onhand, $user]);
    }

    public function get_all_pending(Request $request)
    {
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;



        $seatrch_min = '';
        $seatrch_max = '';

        if($min === '')
        {
            $seatrch_min =  Carbon::now('Asia/Manila')->subDays(30)->toDateString();
        }
        else
        {
            $seatrch_min = $min;
        }

        if ($max === '')
        {
            $seatrch_max =  Carbon::now('Asia/Manila')->toDateString();
        }
        else
        {
            $seatrch_max = $max;
        }

        $endorsements = DB::table('endorsements')
            ->join('endorsement_user', 'endorsement_user.endorsement_id', '=', 'endorsements.id')
            // ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsements.id')
            // ->join('subjects','subjects.endorsement_id','=','endorsements.id')
            // ->leftjoin('reports','reports.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id as id',
                    'endorsements.account_name as account_name',
                    'endorsements.date_due as date_due',
                    'endorsements.time_due as time_due',
                    'endorsements.date_endorsed as date_endorsed',
                    'endorsements.time_endorsed as time_endorsed',
                    'endorsements.client_name as client_name',
                    'endorsements.type_of_request as type_of_request',
                    'endorsements.city_muni as city_muni',
                    // 'type_of_subjects.type_of_subject_name as subjcoob',
                    // 'subjects.subject_name as subjnames',
                    'endorsements.verify_through as verify_through',
                    'endorsements.client_remarks as client_remarks',
                    'endorsements.re_ci as re_ci',
                    'endorsements.acct_status as acct_status',
                    // 'reports.endorsement_report as endorsement_report'
                ]
            )
            // ->orderby('endorsements.id','desc')
            ->where('endorsement_user.user_id',$request->id)
            ->where('endorsements.acct_status','=',1)
            ->where('endorsement_user.position_id','=',4)
            ->where('endorsements.date_endorsed','>=',$seatrch_min)
            ->where('endorsements.date_endorsed','<=',$seatrch_max)
            ->limit(10);

        return DataTables::of($endorsements)
            ->editColumn('endorsement_report', function($endorsements)
            {
                $get = DB::table('reports')
                    ->select('endorsement_report')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->endorsement_report;
                }
                else
                {

                    return null;
                }
            })
            ->editColumn('subjcoob', function($endorsements)
            {
                $get = DB::table('type_of_subjects')
                    ->select('type_of_subject_name')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->type_of_subject_name;
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('subjnames', function($endorsements)
            {
                $get = DB::table('subjects')
                    ->select('subject_name')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->subject_name;
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('tat', function($endorsements)
            {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->date_due.' '.$endorsements->time_due);
                $date->subHours(2);
                $splitDateTime = explode(" ",$date);
                $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
                $now_date_time = $now;
                $difference_mins = $now_date_time->diffInMinutes($date,false);


                if($difference_mins <= -1)
                {
                    return $date.' <small class="label bg-black">late</small>';
                }
                else if ($difference_mins <= 10)
                {
                    return $date . ' <small class="label bg-red">< 10mins left</small>';
                }
                else if ($difference_mins <= 20)
                {
                    return $date . ' <small class="label bg-red">< 20mins left</small>';
                }
                else if ($difference_mins <= 30)
                {
                    return $date . ' <small class="label bg-red">< 30mins left</small>';
                }
                else if ($difference_mins <= 60)
                {
                    return $date . ' <small class="label bg-red">< 1hr left</small>';
                }
                elseif ($difference_mins <= 120)
                {
                    return $date . ' <small class="label bg-yellow">< 2hrs left</small>';
                }
                elseif ($difference_mins <= 180)
                {
                    return $date . ' <small class="label bg-orange">< 3hrs left</small>';
                }
                elseif ($difference_mins <= 240)
                {
                    return $date . ' <small class="label bg-light-blue">< 4hrs left</small>';
                }
                elseif ($difference_mins <= 1439)
                {
                    return $date . ' <small class="label bg-green">> 4hrs left</small>';
                }
                elseif ($difference_mins >= 1440)
                {
                    return $date . ' <small class="label bg-green">> 1 day</small>';
                }
            })
            ->rawColumns(['tat','subjcoob','subjnames','endorsement_report'])
            ->make(true);
    }

    public function get_all_finished(Request $request)
    {

        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;


        $seatrch_min = '';
        $seatrch_max = '';

        if($min === '')
        {
            $seatrch_min =  Carbon::now('Asia/Manila')->subDays(30)->toDateString();
        }
        else
        {
            $seatrch_min = $min;
        }

        if ($max === '')
        {
            $seatrch_max =  Carbon::now('Asia/Manila')->toDateString();
        }
        else
        {
            $seatrch_max = $max;
        }


        $endorsements = DB::table('endorsements')
            ->join('endorsement_user', 'endorsement_user.endorsement_id', '=', 'endorsements.id')
            // ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsements.id')
            // ->join('subjects','subjects.endorsement_id','=','endorsements.id')
            // ->leftjoin('reports','reports.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id as id',
                    'endorsements.account_name as account_name',
                    'endorsements.date_due as date_due',
                    'endorsements.time_due as time_due',
                    'endorsements.ci_internal_status as ci_internal_status',
                    'endorsements.endorsement_status_internal as endorsement_status_internal',
                    'endorsements.client_name as client_name',
                    'endorsements.type_of_request as type_of_request',
//                        'endorsements.type_of_loan',
                    // 'type_of_subjects.type_of_subject_name as subjcoob',
                    // 'subjects.subject_name as subjnames',
                    'endorsements.verify_through as verify_through',
                    'endorsements.client_remarks as client_remarks',
                    'endorsements.re_ci as re_ci',
                    'endorsements.acct_status as acct_status',
                    // 'reports.endorsement_report as endorsement_report',
                    'endorsements.fund_request as fund_request'
                ]
            )
            ->where('user_id',$request->id)
            ->where('endorsements.acct_status','!=',1)
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where('endorsements.date_endorsed','>=',$seatrch_min)
            ->where('endorsements.date_endorsed','<=',$seatrch_max)
            ->limit(10);



        return DataTables::of($endorsements)
            ->editColumn('endorsement_report', function($endorsements)
            {
                $get = DB::table('reports')
                    ->select('endorsement_report')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->endorsement_report;
                }
                else
                {
                    return null;
                }
            })
            ->editColumn('subjcoob', function($endorsements)
            {
                $get = DB::table('type_of_subjects')
                    ->select('type_of_subject_name')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->type_of_subject_name;
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('subjnames', function($endorsements)
            {
                $get = DB::table('subjects')
                    ->select('subject_name')
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                if(count($get) != 0)
                {
                    return $get[0]->subject_name;
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('time_due', function($endorsements)
            {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->date_due.' '.$endorsements->time_due);
                $date->subHours(2);
                $splitDateTime = explode(" ",$date);
                $dates = $splitDateTime[0];
                $time = $splitDateTime[1];

                $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));;

//                    if($endorsements->file_link != '')
//                    {
//                        return $time.' <small class="label bg-green">Success</small>';
//                    }
                if($now->diffInMinutes($date,false)>=0&&$now->diffInMinutes($date,false)<=60)
                {
                    return $time.' <small class="label bg-red">< 1hr left</small>';
                }
                elseif($now->diffInMinutes($date,false)>=0&&$now->diffInMinutes($date,false)<=120)
                {
                    return $time.' <small class="label bg-yellow">< 2hrs left</small>';
                }
                elseif($now->diffInMinutes($date,false)>=0&&$now->diffInMinutes($date,false)<=180)
                {
                    return $time.' <small class="label bg-orange">< 3hrs left</small>';
                }
                elseif($now->diffInMinutes($date,false)>=0&&$now->diffInMinutes($date,false)<=240)
                {
                    return $time.' <small class="label bg-light-blue">< 4hrs left</small>';
                }
                elseif($now->diffInMinutes($date,false)>240)
                {
                    return $time.' <small class="label bg-green">> 4hrs left</small>';
                }
                elseif($now->diffInMinutes($date,false)>1440)
                {
                    return $time.' <small class="label bg-green">> 1 day</small>';
                }
                else
                {
                    return $time;
                }
            })
            ->rawColumns(['time_due','subjcoob','subjnames','endorsement_report'])
//                ->toJson();
            ->make(true);

    }

    public function ci_sup_get_all_realtimeFund(Request $request)
    {
        $ciLists = DB::table('users')
            ->join('role_user','role_user.user_id','users.id')
            ->leftjoin('ci_fund_realtime_amount','ci_fund_realtime_amount.user_id','users.id')
            ->select
            (
                [
                    'users.id as id',
                    'users.name as name',
                    'ci_fund_realtime_amount.fund_realtime as fund_realtime'
                ]
            )
            ->where('role_user.role_id',4)
            ->where('users.archive','False')
            ->groupBy('users.id');

        return DataTables::of($ciLists)
            ->make(true);
    }

    public function ci_supp_get_ci_list()
    {
        $getCiList = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select
            ([
                'users.name as name',
                'users.id as id'
            ])
            ->where('roles.id', 4)
            ->get();

        return response()->json($getCiList);
    }
}