<?php

namespace App\Http\Controllers;

use App\Endorsement;
use App\Generals\DashboardQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\ScriptTrimmer;
use App\Generals\TatController;
use App\Generals\Trimmer;
use App\handler;
use App\User;
use Carbon\Carbon;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic;
use App\Generals\EmailQueries;
use Illuminate\Support\Str;


class CreditInvestigatorController extends Controller
{
    public function var_session()
    {
        return $ses = Session();
    }

    public function getCiDashboard()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
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

                return view('bank_dept.ci.ci-dashboard', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount','javs'))->with(["page" => "ci-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiEndorse()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
           if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
//                $dateNow = Carbon::now('Asia/Manila');
//                $time = date("H:i", strtotime($dateNow));

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('bank_dept.ci.ci-endorse', compact('javs'))->with(["page" => "ci-endorse"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiFundReceive()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('bank_dept.ci.ci-fund-receive', compact('dateNow', 'time','javs'))->with(["page" => "ci-fund-receive"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiBiReport()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('bank_dept.ci.ci-bi-report', compact('dateNow', 'time','javs'))->with(["page" => "ci-bi-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiExpensesReport()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('bank_dept.ci.ci-expense-report', compact('dateNow', 'time','javs'))->with(["page" => "ci-expense-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getTableCiFund()
    {
        $funds =  DB::table('ci_fund_remittances')
            ->leftjoin('remittance','remittance.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('fund_requests','fund_requests.id','=','ci_fund_remittances.fund_id')
            ->select([
                'ci_fund_remittances.id as id',
                'ci_fund_remittances.remittance_id as remittance_id',
                'ci_fund_remittances.ci_shell_card_id as ci_shell_card_id',
                'ci_fund_remittances.ci_atm_fund_id as ci_atm_fund_id',
                'remittance.id as remit_id',
//                'remittance.receiver as remit_receiver',
//                'remittance.sender as remit_sender',
//                'remittance.code as remit_code',
                'remittance.amount as remit_amount',
                'remittance.remittance_info as remittance_info',
                'remittance.remarks as remit_remarks',
                'remittance.date_of_send as remit_date_of_send',
                'remittance.receive_status_date_time as remit_status_date_time',
                'remittance.receive_status as remit_status',

                'ci_atm_fund.id as atm_id',
                'ci_atm_fund.amount as atm_amount',
                'ci_atms.bank_name as atm_bank_name',
                'ci_atms.account_number as atm_account_number',
                'ci_atm_fund.remarks as atm_remarks',
                'ci_atm_fund.date_of_send as atm_date_of_send',
                'ci_atm_fund.receive_status_date_time as atm_status_date_time',
                'ci_atm_fund.receive_status as atm_status',

                'ci_shell_include_fund.id as shell_id',
                'ci_shell_include_fund.with_or_without as shell_with_or_without',
                'ci_shell_include_fund.date_of_send as shell_date_of_send',
                'ci_shell_include_fund.receive_status_date_time as shell_status_date_time',
                'ci_shell_include_fund.receive_status as shell_status',

                'fund_requests.finance_remarks as finance_remarks',
                'fund_requests.date_time_remarks as date_time_remarks',
                'fund_requests.id as fund_id',
                'fund_requests.fund_amount as fund_amount'
            ])
            ->where(function ($query)
            {
                return $query->orwhere('remittance.receive_status','')
                    ->orwhere('ci_atm_fund.receive_status','')
                    ->orwhere('ci_shell_include_fund.receive_status','');
            })
            ->where('ci_fund_remittances.user_id',Auth::user()->id)
            ->where('fund_requests.approved_request_done', 'Pending')

        ;



        return DataTables::of($funds)
            ->editColumn('remit_info', function ($data)
            {
                $remittance_check = $data->remittance_id;
                $atm_check = $data->ci_atm_fund_id;
                $shell_check = $data->ci_shell_card_id;
                $remittance_info = $data->remittance_info;

                $code = '';

                if($remittance_check != 0)
                {
                    $code = $remittance_info;
                }
                else if($atm_check != 0)
                {
                    $code = '-';

                }
                else if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    $code = '-';

                }
                return $code;

            })
            ->editColumn('stats', function ($data)
            {
                $finance_remarks = $data->finance_remarks;
                $finance_date_time_remarks = $data->date_time_remarks;

                $to_return = $finance_remarks.'<br><br><br>Last Update: '.$finance_date_time_remarks;

                return $to_return;
            })
            ->rawColumns(['remit_info','stats'])
            ->make(true);
    }

    public function getTableCiFundAccept()
    {
        $funds =  DB::table('ci_fund_remittances')
            ->leftjoin('remittance','remittance.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('fund_requests','fund_requests.id','=','ci_fund_remittances.fund_id')
            ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
            ->select([
                'ci_fund_remittances.id as id',
                'ci_fund_remittances.remittance_id as remittance_id',
                'ci_fund_remittances.ci_shell_card_id as ci_shell_card_id',
                'ci_fund_remittances.ci_atm_fund_id as ci_atm_fund_id',
                'ci_fund_remittances.confirm_date_time as confirm_fund',

                'remittance.id as remit_id',
                'remittance.amount as remit_amount',
                'remittance.remittance_info as remittance_info',
                'remittance.remarks as remit_remarks',
                'remittance.date_of_send as remit_date_of_send',
                'remittance.receive_status_date_time as remit_status_date_time',
                'remittance.receive_status as remit_status',

                'ci_atm_fund.id as atm_id',
                'ci_atm_fund.amount as atm_amount',
                'ci_atms.bank_name as atm_bank_name',
                'ci_atms.account_number as atm_account_number',
                'ci_atm_fund.remarks as atm_remarks',
                'ci_atm_fund.date_of_send as atm_date_of_send',
                'ci_atm_fund.receive_status_date_time as atm_status_date_time',
                'ci_atm_fund.receive_status as atm_status',

                'ci_shell_include_fund.id as shell_id',
                'ci_shell_include_fund.with_or_without as shell_with_or_without',
                'ci_shell_include_fund.date_of_send as shell_date_of_send',
                'ci_shell_include_fund.receive_status_date_time as shell_status_date_time',
                'ci_shell_include_fund.receive_status as shell_status',

                'fund_requests.finance_remarks as finance_remarks',
                'fund_requests.date_time_remarks as date_time_remarks',
                'fund_requests.id as fund_id',
                'fund_requests.liquidated_amount as liq',
                'fund_requests.unliquidated_amount as unliq',
                'fund_requests.fund_amount as fund_amount',
                'fund_requests.type_of_fund_request as tor',
                'dispatcher_id.name as name_disp',
                'sao_id.name as name_sao',
                'manage_approved_id.name as manage_name',
                'fund_requests.management_remarks_approved as rem_manage',
                'fund_requests.dispatcher_remarks as dispatcher_remarks',
                'fund_requests.sao_remarks as sao_remarks',
                'fund_requests.ci_id as ci_id',
            ])
            ->where(function ($query)
            {
                return $query->orwhere('remittance.receive_status','received')
                    ->orwhere('ci_atm_fund.receive_status','received')
                    ->orwhere('ci_shell_include_fund.receive_status','received')
                    ->orwhere('ci_fund_remittances.remarks_fund', 'assign');
            })
            ->where('ci_fund_remittances.user_id',Auth::user()->id)
            ->where(function ($query)
            {
                return $query->orwhere('fund_requests.approved_request_done', 'Done')
                    ->orwhere('fund_requests.approved_request_done', 'Assigned')
                    ->orwhere('fund_requests.approved_request_done', 'New');
            })
            ->where(function ($query)
            {
                return $query->orwhere('fund_requests.success_hold_cancel', '')
                    ->orwhere('fund_requests.success_hold_cancel', 'Override');
            })
            ->where('fund_requests.liquidation_status', '!=', 'liquidated');

        return DataTables::of($funds)
            ->editColumn('remit_info', function ($data)
            {

                $remittance_check = $data->remittance_id;
                $atm_check = $data->ci_atm_fund_id;
                $shell_check = $data->ci_shell_card_id;
                $remittance_info = $data->remittance_info;

                $code = '';

                if($remittance_check == 0 && $atm_check== 0)
                {
                    $code = '-';
                }
                else if($remittance_check != 0)
                {
                    $code = $remittance_info;
                }
                else if($atm_check != 0)
                {
                    $code = '-';

                }
                else if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    $code = '-';

                }
                return $code;

            })
            ->editColumn('stats', function ($data)
            {
                $finance_remarks = $data->finance_remarks;
                $finance_date_time_remarks = $data->date_time_remarks;

                $to_return = $finance_remarks.'<br><br><br>Last Update: '.$finance_date_time_remarks;

                return $to_return;
            })
            ->rawColumns(['remit_info','stats'])
            ->make(true);
    }

    public function getCiTemplate()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Credit Investigator')) {
                return view('bank_dept.ci.ci-template')->with(["page" => "ci-template"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiNewEndorsement(Request $request)
    {
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
                    'endorsements.time_dispatched as tim_disp'
                    // 'reports.endorsement_report as endorsement_report'

                ]
            )
            ->orderby('endorsements.date_dispatched','desc')
            ->where('endorsement_user.user_id',Auth::user()->id)
            ->where('endorsements.acct_status','=',1)
            ->where('endorsement_user.position_id','=',4)
            ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
            ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'));

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

    public function getFinishEndorsement(Request $request)
    {

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
                    'endorsements.fund_request as fund_request',
                    'endorsements.time_ci_forwarded as time_fwd'
                ]
            )
            ->orderBy('endorsements.date_ci_forwarded', 'desc')
            ->where('endorsement_user.user_id',Auth::user()->id)
            ->where('endorsements.acct_status','!=',1)
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
            ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'));



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

    public function attachReportFile(Request $request)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $certified = DB::table('certifieds')
            ->where('user_id',Auth::user()->id)
            ->select('cert')
            ->first();

        $getend = DB::table('endorsements')
            ->select('account_name', 'acct_status')
            ->where('id', $request->acctID)
            ->get();

//        DB::table('audits')
//            ->insert
//            (
//                [
//                    'endorsement_id' => $request->acctID,
//                    'name' => strtoupper(Auth::user()->name),
//                    'position' => strtoupper( $this->var_session()->get('role')),
//                    'branch' => strtoupper( $this->var_session()->get('userBranch')),
//                    'activities' => strtoupper('Forwarded Report of '. $getend[0]->account_name.' (File success ('.$request->countsuccess.'): '.$request->successfile.') (File failed ('.$request->counterror.'): '.$request->errorfile.')'),
//                    'date_occured' => $date,
//                    'time_occured' => $time
//                ]
//            );


        if($request->countsuccess != 0)
        {

            if($certified->cert!='NC')
            {

                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $request->acctID,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper( $this->var_session()->get('role')),
                            'branch' => strtoupper( $this->var_session()->get('userBranch')),
                            'activities' => strtoupper('Forwarded Report of '. $getend[0]->account_name.' (File success ('.$request->countsuccess.'): '.$request->successfile.') (File failed ('.$request->counterror.'): '.$request->errorfile.') to Client'),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );

                $emailSend = new EmailQueries();
                $emailSend->AOSendReport(
                    $request->acctID,
                    '',
                    '',
                    '',
                    ''
                );

                DB::table('endorsements')
                    ->where('id', $request->acctID)
                    ->update
                    (
                        [
                            'acct_status' => 3
                        ]
                    );
            }
            else
            {
                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $request->acctID,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper( $this->var_session()->get('role')),
                            'branch' => strtoupper( $this->var_session()->get('userBranch')),
                            'activities' => strtoupper('Forwarded Report of '. $getend[0]->account_name.' (File success ('.$request->countsuccess.'): '.$request->successfile.') (File failed ('.$request->counterror.'): '.$request->errorfile.')'),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );

                if($getend[0]->acct_status == 3)
                {
                    return 'already finished';
                }
                DB::table('endorsements')
                    ->where('id', $request->acctID)
                    ->update
                    (
                        [
                            'acct_status' => 2
                        ]
                    );
            }

                $date_time = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ",$date_time);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];


                $users = User::find(Auth::user()->id);
                foreach ($users->roles as $user)
                {
                    $role = $user->name;
                    $this->var_session()->put('role', $role);
                }
                foreach ($users->provinces as $branch)
                {
                    $userBranch = $branch->name;
                    $this->var_session()->put('userBranch', $userBranch);
                }

                //      TOTAL TIME LOSS
                $timeStampNoww = Carbon::now('Asia/Manila');
                $dateEndorsed = Endorsement::find($request->acctID);
                $dateEndo = $dateEndorsed->date_dispatched;
                $timeEndorsed = Endorsement::find($request->acctID);
                $timeEndo = $timeEndorsed->time_dispatched;
                $dateTimeLoss = $timeStampNoww->diffForHumans(Carbon::parse($dateEndo.' '.$timeEndo));
                DB::table('timestamps')
                    ->where('endorsement_id',$request->acctID)
                    ->update(['time_ci'=>$dateTimeLoss]);
                //      END





            DB::table('endorsements')
                ->where('id',$request->acctID)
                ->update
                (
                    [
                        'date_ci_forwarded' => $date,
                        'time_ci_forwarded' => $time
                    ]
                );


//            if($certified->cert!='NC')
//            {
//
//                $emailSend = new EmailQueries();
//                $emailSend->AOSendReport(
//                    $request->acctID,
//                    '',
//                    '',
//                    '',
//                    ''
//                );
//            }

            return \Response::json(array('success' => true));
        }
        else
        {
            return 'error';
        }

    }

    public function getEndorsementInfo($acct_id)
    {
        $add = DB::table('endorsements')
            ->where('id', $acct_id)
            ->select(['address'])
            ->get();
        return response()->json(['success'=>true, 'add' => $add]);
    }

    public function ItemViewing(Request $request)
    {

        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($request->AcctIDid);

        $trimnames = [];


        $storage_path = storage_path();

        $certified = DB::table('certifieds')
            ->where('user_id',Auth::user()->id)
            ->select('cert')
            ->first();

        if($certified->cert=='NC')
        {
            foreach(glob(storage_path('/account/'.$paths).'/*.*') as $filename)
            {
                $trimnames[] = str_replace(storage_path('/account/'.$paths.'/'), '', $filename);
            }

            if($request->status==='3')
            {
                $endorsementFile = Endorsement::find($request->AcctIDid);
                $endorsementFile->acct_status = '3';
                $endorsementFile->save();
            }

            return response()->json([$trimnames,$certified,$paths,$storage_path]);
        }
        else
        {
            foreach(glob(storage_path('/account_client/'.$paths).'/*.*') as $filename)
            {
                $trimnames[] = str_replace(storage_path('/account_client/'.$paths.'/'), '', $filename);
            }

            if($request->status==='3')
            {
                $endorsementFile = Endorsement::find($request->AcctIDid);
                $endorsementFile->acct_status = '3';
                $endorsementFile->save();
            }

            return response()->json([$trimnames,$certified,$paths,$storage_path]);
        }


    }

    public function updateDateTimeVisit(Request $request)
    {
        $acc='';

        $timeStamp = Carbon::parse($request->dateVisit. ' ' .$request->timeVisit);
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        DB::table('endorsements')
            ->where('id',$request->acctID)
            ->update
            (
                [
                    'date_ci_visit' => $date,
                    'time_ci_visit' => date("H:i", strtotime($time))
                ]
            );

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $datee = $splitDateTime[0];
        $timee = $splitDateTime[1];

        $accountName = DB::table('endorsements')
            ->where('id',$request->acctID)
            ->get();

        foreach ($accountName as $acctName)
        {
            $acc = $acctName->account_name;
        }

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $this->var_session()->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $this->var_session()->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper( $this->var_session()->get('role')),
                    'branch' => strtoupper( $this->var_session()->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acc.' UPDATE DATE AND TIME VISIT'),
                    'date_occured' => $datee,
                    'time_occured' => $timee
                ]
            );
        //      END OF AUDIT TRAILING
    }

    public function PassDataLatLong(Request $request){
        //save to database

        $ciid = Auth::user()->id;
        $ciname = Auth::user()->name;
        $lat = $request->latitude;
        $long = $request->longitude;
//        $address = $request->address;

        $timedate = Carbon::now('Asia/Manila');
        $timelimit = Carbon::now('Asia/Manila')->addMinutes(5);
        $checkex = DB::table('lat_longs')->select('CI_ID')->where('CI_ID',$ciid)->count();
//

        $url = urlencode ("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY&latlng=".$lat.",".$long."&sensor=false");

        $json = json_decode($url, true);

//        dd($json);


        if($checkex >= 1)
        {
            DB::table('lat_longs')
                ->where('CI_ID', $ciid)
                ->update
                (
                    [
                        'CI_Name' => $ciname,
                        'Lat' => $lat,
                        'Long' => $long,
                        'Address' => $json,
                        'Status' => 'Online',
                        'Last_Update' =>$timedate,
                        'Time_Limit' =>$timelimit

                    ]
                );
            return 'update done';
        }
        else
        {
            DB::table('lat_longs')
                ->insert
                (
                    [
                        'CI_ID' => $ciid,
                        'CI_Name' => $ciname,
                        'Lat' => $lat,
                        'Long' => $long,
                        'Address' => $json,
                        'Status' => 'Online',
                        'Last_Update' => $timedate,
                        'Time_Limit' =>$timelimit

                    ]
                );
            return 'insert done';
        }
    }

    public function getOtherInfo(Request $request)
    {
        $cobInfo = DB::table('endorsements')
            ->join('coborrowers','coborrowers.endorsement_id','=','endorsements.id')
            ->select
            (
                [
                    'coborrowers.coborrower_name',
                    'coborrowers.coborrower_address',
                    'coborrowers.coborrower_municipality',
                    'coborrowers.coborrower_province',
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();

        $empInfo = DB::table('endorsements')
            ->join('employers','employers.endorsement_id','=','endorsements.id')
            ->select
            (
                [
                    'employers.employer_name',
                    'employers.employer_address',
                    'employers.employer_municipality',
                    'employers.employer_province',
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();

        $busInfo = DB::table('endorsements')
            ->join('businesses','businesses.endorsement_id','=','endorsements.id')
            ->select
            (
                [
                    'businesses.business_name',
                    'businesses.business_address',
                    'businesses.business_municipality',
                    'businesses.business_province',
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();


        return response()->json([$cobInfo,$empInfo,$busInfo]);
    }

    public function getInfoAttach(Request $request)
    {
        $infos = DB::table('endorsements')
            ->select('date_due','time_due','account_name','address','city_muni','provinces','type_of_request', 'acct_status')
            ->where('id',$request->acctID)
            ->get();

        return response()->json($infos);

    }

    public function saveReport(Request $request)
    {
        DB::table('reports')
            ->insert
            (
                [
                    'endorsement_id'=>$request->acctID,
                    'endorsement_report'=>$request->txtReport
                ]
            );

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $datee = $splitDateTime[0];
        $timee = $splitDateTime[1];

        $accountName = Endorsement::find($request->acctID)->account_name;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $this->var_session()->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $this->var_session()->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper( $this->var_session()->get('role')),
                    'branch' => strtoupper( $this->var_session()->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$accountName.' SUBMIT REPORT BY '.Auth::user()->name),
                    'date_occured' => $datee,
                    'time_occured' => $timee
                ]
            );
        //      END OF AUDIT TRAILING

        return \response()->json('success');
    }

    public function updateReport(Request $request)
    {
        DB::table('reports')
            ->where('endorsement_id',$request->acctID)
            ->update
            (
                [
                    'endorsement_report'=>$request->txtReport
                ]
            );

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $datee = $splitDateTime[0];
        $timee = $splitDateTime[1];

        $accountName = Endorsement::find($request->acctID)->account_name;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $this->var_session()->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $this->var_session()->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper( $this->var_session()->get('role')),
                    'branch' => strtoupper( $this->var_session()->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$accountName.' UPDATE REPORT BY '.Auth::user()->name),
                    'date_occured' => $datee,
                    'time_occured' => $timee
                ]
            );
        //      END OF AUDIT TRAILING

        return \response()->json('success');
    }

    public function getReport(Request $request)
    {
        $note = DB::table('reports')
            ->where('endorsement_id',$request->acctID)
            ->select('endorsement_report')
            ->get();

        return \response()->json($note);
    }

    public function uploadFine(Request $request,$accountID)
    {
        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($accountID);

        $certified = DB::table('certifieds')
            ->where('user_id',Auth::user()->id)
            ->select('cert')
            ->first();

        $uploader = new handler();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method =$uploader->ismethod();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST")
        {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done


            if (isset($_GET["done"]))
            {
                $result = $uploader->combineChunks(storage_path('account/'.$paths));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if($certified->cert==='NC')
                {
                    if(File::isDirectory(storage_path('account/'.$paths)))
                    {
//
                    }
                    else
                    {
                        File::makeDirectory(storage_path('account/'.$paths));
                    }


                    $date_time_endorsed_get = DB::table('endorsements')
                        ->select(['date_endorsed','time_endorsed','city_muni','id','date_due','time_due'])
                        ->where('id',$accountID)
                        ->get()[0];

                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed_get->date_due.' '.$date_time_endorsed_get->time_due);
                    $date->subHours(2);

//                    $get_internal_tat = new TatController();
//
//                    $internal_tat_ci = $get_internal_tat->DatTimeDue_internal_ci(
//                        $date_time_endorsed_get->city_muni,
//                        $date_time_endorsed_get->id,
//                        $date_time_endorsed_get->date_endorsed.' '.$date_time_endorsed_get->time_endorsed
//                    );

                    $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
                    $now_date_time = $now;

                    $difference_hours = $now_date_time->diffInHours($date,false);
                    $difference_mins = $now_date_time->diffInMinutes($date,false);


                    if ($difference_mins <= -1) {
                        $status = "OVERDUE";
                    } else if ($difference_mins >= 0) {
                        $status = "TAT";
                    };

//                    }
//                    else {
//
//                        $time_endorsed_add_hours = $date_time_endorsed->addHour($get_ci_tat[0]->fw_Tat);
//                        $now_date_time = $now;
//                        $difference_hours = $now_date_time->diffInHours($time_endorsed_add_hours, false);
//                        $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);
//
//                        if ($difference_mins <= -1) {
//                            $status = "OVERDUE";
//                        } else if ($difference_mins >= 0) {
//                            $status = "TAT";
//                        };
//
//                    }

                    //updating external status
                    DB::table('endorsements')
                        ->where('id', $accountID)
                        ->update
                        ([

                            'ci_cert' => 'NC',
                            'ci_internal_status' => $date,
                            'endorsement_status_internal' => strtoupper($status),
                        ]);

                    $result = $uploader->handleUpload(storage_path('account/'.$paths));
                }
                else
                {
                    if(File::isDirectory(storage_path('account_client/'.$paths)))
                    {

                    }
                    else
                    {
                        File::makeDirectory(storage_path('account_client/'.$paths));
                    }

                    $timeStamp = Carbon::now('Asia/Manila');
                    $splitDateTime = explode(" ",$timeStamp);
                    $dateN = $splitDateTime[0];
                    $timeN = $splitDateTime[1];


                    $date_time_endorsed_get = DB::table('endorsements')
                        ->select(['date_endorsed','time_endorsed','date_due','time_due','city_muni','id'])
                        ->where('id',$accountID)
                        ->get()[0];

                    $date_time_due = Carbon::createFromFormat('Y-m-d H:i:s',$date_time_endorsed_get->date_due.' '.$date_time_endorsed_get->time_due);

                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed_get->date_due.' '.$date_time_endorsed_get->time_due);
                    $date->subHours(2);
//                    $get_internal_tat = new TatController();
//
//                    $internal_tat_ci = $get_internal_tat->DatTimeDue_internal_ci(
//                        $date_time_endorsed_get->city_muni,
//                        $date_time_endorsed_get->id,
//                        $date_time_endorsed_get->date_endorsed.' '.$date_time_endorsed_get->time_endorsed
//                    );

                    $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
                    $now_date_time = $now;

                    $difference_hours = $now_date_time->diffInHours($date,false);
                    $difference_mins_internal = $now_date_time->diffInMinutes($date,false);
                    $difference_mins_external = $now_date_time->diffInMinutes($date_time_due,false);


                    if ($difference_mins_internal <= -1) {
                        $status = "OVERDUE";
                    } else if ($difference_mins_internal >= 0) {
                        $status = "TAT";
                    };


                    if ($difference_mins_external <= -1) {
                        $status_external = "OVERDUE";
                    } else if ($difference_mins_external >= 0) {
                        $status_external = "TAT";
                    };

//                    }
//                    else {
//
//                        $now_date_time = $now;
//                        $time_endorsed_add_hours = $date_time_endorsed->addHour($get_ci_tat[0]->fw_tat);
//
//                        $difference_mins_external = $now_date_time->diffInMinutes($date_time_due, false);
//                        $difference_mins = $now_date_time->diffInMinutes($time_endorsed_add_hours, false);
//
//                        if ($difference_mins <= -1) {
//                            $status = "OVERDUE";
//                        } else if ($difference_mins >= 0) {
//                            $status = "TAT";
//                        };
//
//                        if ($difference_mins_external <= -1) {
//                            $status_external = "OVERDUE";
//                        } else if ($difference_mins_external >= 0) {
//                            $status_external = "TAT";
//                        };
//
//                    }

                    //updating external status
                    $token = Str::random(25).Carbon::now('Asia/Manila');
                    $dmk = hash('sha256', $token);

                    DB::table('endorsements')
                        ->where('id', $accountID)
                        ->update
                        ([

                            'date_forwarded_to_client' => $dateN,
                            'time_forwarded_to_client' => $timeN,
                            'dl_link' => $request->root().'/api/download_account_link?dl='.base64_encode($accountID).'&dll='.base64_encode($paths).'',
                            'acct_status' => 3,
                            'ci_internal_status' => $date,
                            'down_email_key' => $dmk,
                            'endorsement_status_internal' => strtoupper($status),
                            'endorsement_status_external' => $status_external,
                            'ci_cert' => 'C'
                        ]);

                    $result = $uploader->handleUpload(storage_path('account_client/'.$paths));
                }

                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            echo json_encode($result);
        }
        // for delete file requests
        else if ($method == "DELETE")
        {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        }
        else
        {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function getDownloadables(Request $request)
    {
        $trimnames = [];

        foreach(glob(storage_path('/DownloadableForms/*.*')) as $filename)
        {
            $trimnames[] = str_replace(storage_path('/DownloadableForms/'), '', $filename);
        }

        return response()->json($trimnames);

    }

    public function uploadReceiptExpenses(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $dateN = $splitDateTime[0];
        $timeN = $splitDateTime[1];

        $endorse_id = $request->endorsement_id;

        if(File::isDirectory(public_path('ci_expenses/'.Auth::user()->id)))
        {

        }
        else
        {
            File::makeDirectory(public_path('ci_expenses/'.Auth::user()->id));
        }

        $label = $request->label;
        $amount = $request->amount;
        $loopid = $request->loopid;
        $note = $request->CInote;
        $shell_include = $request->shell_include;


        $checkifexist = DB::table('ci_expenses')
            ->where('ci_id', Auth::user()->id)
            ->where('endorsement_id',$endorse_id)
            ->count();



        if($checkifexist == 0)
        {
            DB::table('ci_expenses')
                ->insertGetId([
                    'ci_id' => Auth::user()->id,
                    'endorsement_id' => $endorse_id,
                    'note' => $note,
                    'date_time_modified' => Carbon::now('Asia/Manila')
                ]);
        }
        else
        {
            DB::table('ci_expenses')
                ->where('ci_id', Auth::user()->id)
                ->where('endorsement_id',$endorse_id)
                ->update([
                    'ci_id' => Auth::user()->id,
                    'endorsement_id' => $endorse_id,
                    'note' => $removeScript->scripttrim($note),
                    'date_time_modified' => Carbon::now('Asia/Manila')
                ]);
        }


        $get_ci_exp_id = DB::table('ci_expenses')
            ->where('ci_id',Auth::user()->id)
            ->where('endorsement_id', $endorse_id)
            ->select('id')
            ->get()[0]->id;


        $checkid = $request->checkid;
        $type = $request->type;

        if($checkid == 'none')
        {
            //insert
            if ($request->file != 'no attachment')
            {
                $file = $request->file('file');

                $file->move(public_path() . '/ci_expenses/'.Auth::user()->id.'/'.$endorse_id.'/','('.$label.')'.$file->getClientOriginalName());


                DB::table('expenses')
                    ->insert([
                        'ci_expenses_id' => $get_ci_exp_id,
                        'label' => $removeScript->scripttrim($label),
                        'amount' => $amount,
                        'type' => $type,
                        'attachment' => '('.$label.')'.$file->getClientOriginalName()
                    ]);

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>Auth::user()->id,
                        'activity_id' => $endorse_id,
                        'activity' => '(INSERTED To : '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$removeScript->scripttrim($label).', AMOUNT: '.$amount.' WITH ATTACHMENT'.', ('.$type.').',
                        'type' => 'ci_logs',
                        'datetime' => $timeStamp
                    ]);

                return response()->json(['success',$loopid]);
            }
            else
            {

                DB::table('expenses')
                    ->insert([
                        'ci_expenses_id' => $get_ci_exp_id,
                        'label' => $removeScript->scripttrim($label),
                        'amount' => $amount,
                        'type' => $type,
                        'attachment' => 'none'
                    ]);

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>Auth::user()->id,
                        'activity_id' => $endorse_id,
                        'activity' => '(INSERTED To  '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$removeScript->scripttrim($label).', AMOUNT: '.$amount.' WITH NO ATTACHMENT'.', ('.$type.').',
                        'type' => 'ci_logs',
                        'datetime' => $timeStamp
                    ]);

                return response()->json(['success-no-attach',$loopid]);
            }
        }
        else
        {
            //update
            if ($request->file != 'no attachment')
            {
                $file = $request->file('file');
                $file->move(public_path() . '/ci_expenses/'.Auth::user()->id.'/'.$endorse_id.'/','('.$label.')'.$file->getClientOriginalName());

                if($request->checkifupdate == 'to update')
                {
                    DB::table('expenses')
                        ->where('id', $checkid)
                        ->update([
                            'label' => $removeScript->scripttrim($label),
                            'amount' => $amount,
                            'type' => $type,
                            'attachment' => '('.$label.')'.$file->getClientOriginalName()
                        ]);

                    DB::table('ci_logs_expenses')
                        ->insert([
                            'user_id'=>Auth::user()->id,
                            'activity_id' => $endorse_id,
                            'activity' => '(UPDATED To  '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$label.', AMOUNT: '.$amount.' WITH ATTACHMENT'.', ('.$type.').',
                            'type' => 'ci_logs',
                            'datetime' => $timeStamp
                        ]);

                    return response()->json(['success',$loopid]);
                }
                else
                {
                    return response()->json(['success',$loopid]);
                }
            }
            else
            {

                if($request->checkifupdate == 'to update')
                {
                    DB::table('expenses')
                        ->where('id', $checkid)
                        ->update([
                            'label' => $removeScript->scripttrim($label),
                            'amount' => $amount,
                            'type' => $type,
                            'attachment' => 'none'
                        ]);


                    DB::table('ci_logs_expenses')
                        ->insert([
                            'user_id'=>Auth::user()->id,
                            'activity_id' => $endorse_id,
                            'activity' => '(UPDATED To  '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$removeScript->scripttrim($label).', AMOUNT: '.$amount.' WITH NO ATTACHMENT'.', ('.$type.').',
                            'type' => 'ci_logs',
                            'datetime' => $timeStamp
                        ]);

                    return response()->json(['success-no-attach',$loopid]);

                }
                else
                {
                    return response()->json(['success-no-attach',$loopid]);

                }

            }
        }
    }

    public function ci_logs_for_shell(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $endorsement_id = $request->endorse_id;
        $shell_include = $request->shell_include;
        $note = $request->note;
        $timeStamp = Carbon::now('Asia/Manila');

        $exp_id = DB::table('ci_expenses')
            ->where('ci_id', Auth::user()->id)
            ->where('endorsement_id',$endorsement_id)
            ->get();

//        $get_ci_exp_id='';


        if(count($exp_id) == 0)

        {
            DB::table('ci_expenses')
                ->insert([
                    'ci_id' => Auth::user()->id,
                    'endorsement_id' => $endorsement_id,
                    'note' => $removeScript->scripttrim($note),
                    'shell_include' => $shell_include,
                    'date_time_modified' => Carbon::now('Asia/Manila')
                ]);

        }
        else
        {
            $get_ci_exp_id = $exp_id[0]->id;

            DB::table('ci_expenses')
                ->where('id',$get_ci_exp_id)
                ->update([
                    'note' => $removeScript->scripttrim($note),
                    'shell_include' => $shell_include,
                    'date_time_modified' => Carbon::now('Asia/Manila')
                ]);
        }


        DB::table('ci_logs_expenses')
            ->insert([
                'user_id'=>Auth::user()->id,
                'activity_id' => $endorsement_id,
                'activity' => '(UPDATES EXPENSES TO: '.Endorsement::find($endorsement_id)->account_name.') Shell Include : '.$shell_include.')',
                'type' => 'ci_logs',
                'datetime' => $timeStamp
            ]);

        return response()->json($shell_include);

    }

    public function ci_check_expenses(Request $request)
    {

        $endorse_id = $request->endorsement_id;

        $check = DB::table('ci_expenses')
            ->where('ci_id',Auth::user()->id)
            ->where('endorsement_id',$endorse_id)
            ->select('id','note','shell_include')
            ->get();

        if(sizeof($check) != 0)
        {

            $getexpenses = DB::table('expenses')
                ->where('ci_expenses_id',$check[0]->id)
                ->get();

            return response()->json(['result',$getexpenses,Auth::user()->id.'/'.$endorse_id,$check[0]->note,$check[0]->shell_include]);
        }
        else
        {
            return response()->json('no result');
        }

    }

    public function ci_expense_delete_last_row(Request $request)
    {
        $id = $request->id;
        $endorse_id = $request->endorsement_id;
        $nameoffile = $request->attach;

        $getinfo = DB::table('expenses')
            ->where('id',$id)
            ->get();

        if($nameoffile == 'no attach')
        {

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'activity_id' => $endorse_id,
                    'activity' => '(DELETES From :  '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$getinfo[0]->label.', AMOUNT: '.$getinfo[0]->amount.' WITH NO ATTACHEMENT, ('.$getinfo[0]->type.').',
                    'type' => 'ci_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);


            DB::table('expenses')
                ->where('id',$id)
                ->delete();

        }
        else
        {

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'activity_id' => $endorse_id,
                    'activity' => '(DELETES From :  '.Endorsement::find($endorse_id)->account_name.') LABEL: '.$getinfo[0]->label.', AMOUNT: '.$getinfo[0]->amount.' WITH ATTACHEMENT : '.$getinfo[0]->attachment.', ('.$getinfo[0]->type.').',
                    'type' => 'ci_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

            DB::table('expenses')
                ->where('id',$id)
                ->delete();

            File::delete(glob('ci_expenses/' . Auth::user()->id . '/' . $endorse_id . '/' .$nameoffile));

        }


        return response()->json('success');
    }

    public function ci_expense_delete_row(Request $request)
    {
        $expense_id = $request->id;

        $get_things = DB::table('expenses')
            ->join('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
            ->select([
                'ci_expenses.endorsement_id as end_id',
                'expenses.attachment as attach',
                'expenses.label as label',
                'expenses.amount as amount',
                'expenses.type as type',
                'expenses.id as id'
            ])
            ->where('expenses.id',$expense_id)
            ->get();

        File::delete(glob('ci_expenses/' . Auth::user()->id . '/' . $get_things[0]->end_id . '/' .$get_things[0]->attach));

        $ifnone = '';

        if($get_things[0]->attach == 'none')
        {
            $ifnone = 'WITH NO ATTACHMENT';
        }
        else
        {
            $ifnone = 'WITH ATTACHEMENT : '.$get_things[0]->attach;
        }
        DB::table('ci_logs_expenses')
            ->insert([
                'user_id'=>Auth::user()->id,
                'activity_id' => $get_things[0]->end_id,
                'activity' => '(DELETES From :  '.Endorsement::find($get_things[0]->end_id)->account_name.') LABEL: '.$get_things[0]->label.', AMOUNT: '.$get_things[0]->amount.' '.$ifnone.', ('.$get_things[0]->type.').',
                'type' => 'ci_logs',
                'datetime' => Carbon::now('Asia/Manila')
            ]);

        DB::table('expenses')
            ->where('id',$expense_id)
            ->delete();

        return response()->json($get_things[0]->end_id);
    }

    public function ci_get_table_fund_accept_accounts(Request $request)
    {
        $id = $request->id;
        $LiqAmountArray = [];
        $audit_LiqAmountArray = [];
        $heyaa = '';
        $to_go = 0;
        $togo2 = '';
        $getAuditRemarksfinal = '';

        $get_fund_id = DB::table('ci_fund_remittances')
            ->where('id',$id)
            ->select('fund_id')
            ->get();

        $get_accounts = DB::table('fund_request_endorsements')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_request_endorsements.fund_id')
//            ->join('fund_request_liquidate', 'fund_request_liquidate.fund_id', '=', 'fund_requests.id')
            ->where('fund_request_endorsements.fund_id',$get_fund_id[0]->fund_id)
            ->select([
                'endorsement_id as id',
                'endorsements.account_name as name',
                'endorsements.type_of_request as tor',
//                'fund_request_liquidate.liquidate_amount as liq'
            ])
            ->get();

        $getFund = DB::table('fund_requests')
            ->select('fund_amount', 'liquidated_amount', 'ci_liq_rem', 'unliquidated_amount', 'audit_review_status', 'finance_liq_rem')
            ->where('id', $get_fund_id[0]->fund_id)
            ->get();

        $get_liq = DB::table('fund_request_liquidate')
            ->select('liquidate_amount', 'audit_liquidate_amount')
            ->where('fund_id', $get_fund_id[0]->fund_id)
            ->get();

        for($i = 0; $i < count($get_liq); $i++)
        {
            array_push($LiqAmountArray,$get_liq[$i]->liquidate_amount);
            array_push($audit_LiqAmountArray,$get_liq[$i]->audit_liquidate_amount);
        }
        if($getFund[0]->audit_review_status != 1)
        {
            $to_go = array_sum($LiqAmountArray);
            $togo2 = $LiqAmountArray;
        }
        else
        {
            $to_go = array_sum($audit_LiqAmountArray);
            $togo2 = $audit_LiqAmountArray;
        }

        $sumFund = (int)$getFund[0]->liquidated_amount+(int)$getFund[0]->unliquidated_amount;


        $getPath = DB::table('fund_request_liquidate')
            ->where('fund_id', $get_fund_id[0]->fund_id)
            ->select('receipt_attachment')
            ->get();

        $getRem = DB::table('fund_request_liquidate')
            ->where('fund_id', $get_fund_id[0]->fund_id)
            ->select('indiv_remarks', 'endorse_id')
            ->get();

        if(array_sum($LiqAmountArray) != array_sum($audit_LiqAmountArray))
        {
            $heyaa = 'Modified liquidated amount from ' . array_sum($LiqAmountArray) . ' to ' . array_sum($audit_LiqAmountArray);
        }
        else
        {
            $heyaa = 'No changes made';
        }

        $getAuditRemarks = DB::table('audit_reviewed_ci_liquidation_remarks')
            ->where('fund_id', $get_fund_id[0]->fund_id)
            ->select('audit_remarks')
            ->get();


        if(count($getAuditRemarks) > 0)
        {
            $getAuditRemarksfinal = $getAuditRemarks[0]->audit_remarks;
        }
        else
        {
            $getAuditRemarksfinal = 'No indicated remarks';
        }



        return response()->json([$get_accounts, $sumFund, $get_fund_id[0]->fund_id, $togo2, $to_go, $getPath, $getFund[0]->ci_liq_rem, $getRem, $getFund[0]->audit_review_status, $heyaa, $getAuditRemarksfinal, $getFund[0]->finance_liq_rem]);
    }

    public function ci_get_table_fund_pending_accounts(Request $request)
    {
        $id = $request->id;

        $get_fund_id = DB::table('ci_fund_remittances')
            ->where('id',$id)
            ->select('fund_id')
            ->get();

        $get_accounts = DB::table('fund_request_endorsements')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_request_endorsements.fund_id')
            ->where('fund_id',$get_fund_id[0]->fund_id)
            ->select([
                'endorsement_id as id',
                'endorsements.account_name as name',
                'endorsements.type_of_request as tor',
            ])
            ->get();

        return response()->json($get_accounts);
    }

    public function ci_check_if_has_shell_include_and_if_asso(Request $request)
    {
        $id = $request->id;

        $count = DB::table('ci_fund_remittances')
            ->join('fund_request_endorsements','fund_request_endorsements.fund_id','=','ci_fund_remittances.fund_id')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->select('endorsements.id as id','ci_fund_remittances.ci_shell_card_id as shell','ci_fund_remittances.id as idd')
            ->where('endorsements.id',$id)
            ->where('fund_request_endorsements.type','Success')
            ->where('ci_fund_remittances.ci_shell_card_id','!=','0')
            ->count();
        $count_to_pass = '';
        if($count >= 1)
        {
            $count_to_pass = 'meron';
        }
        else
        {
            $count_to_pass = 'wala';

        }

        $check_if_coob_asso = DB::table('asso_expenses')
            ->join('endorsements','endorsements.id','=','asso_expenses.subject_id')
            ->select('asso_expenses.subject_id as subject_id','endorsements.account_name as account_name')
            ->where('coob_id',$id)
            ->get();

        $get_it_bois = '';
        $getname = '';

        $yes_coob = 'false';

        if(count($check_if_coob_asso) > 0)
        {
            $yes_coob = 'true';
            $get_it_bois = $check_if_coob_asso[0]->subject_id;
            $getname = $check_if_coob_asso[0]->account_name;
        }
        else
        {
            $get_it_bois = $id;
        }


        return response()->json([$count_to_pass,$get_it_bois,$yes_coob,$getname]);

    }

    public function ci_get_coob_for_asso(Request $request)
    {
        $getCoobs = DB::table('subjects')
            ->join('endorsements','endorsements.id','=','subjects.endorsement_id')
            ->join('endorsement_user','endorsement_user.endorsement_id','=','subjects.endorsement_id')
            ->select([
                'endorsements.id as id',
                'endorsements.account_name as account_name',
                'endorsements.address as address'
            ])
            ->where('endorsement_user.user_id',Auth::user()->id)
//            ->where('endorsements.acct_status',2)
            ->where('subjects.subject_name','!=','NONE')
            ->get();

        $getAssos = DB::table('asso_expenses')
            ->join('endorsements','endorsements.id','=','asso_expenses.coob_id')
            ->select([
                'endorsements.id as id',
                'endorsements.account_name as account_name',
                'endorsements.address as address'
            ])
            ->where('asso_expenses.subject_id',$request->id)
            ->get();

        return response()->json([$getCoobs,$getAssos]);
    }

    public function ci_asso_saves_expenses(Request $request)
    {
        $ids = $request->ids;
        $list_of_ngangers = '';
        $istrue = 'false';
        foreach ($ids as $id)
        {
            $check = DB::table('asso_expenses')
                ->join('endorsements','endorsements.id','=','asso_expenses.coob_id')
                ->select('asso_expenses.coob_id as coob_id','endorsements.account_name as account_name')
                ->where('coob_id',$id)
                ->get();


            if(count($check) < 1)
            {
                DB::table('asso_expenses')
                    ->insert([
                        'subject_id' => $request->main_id,
                        'coob_id' => $id
                    ]);

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>Auth::user()->id,
                        'activity_id' => $request->main_id,
                        'activity' => '(ACCOUNT:  '.Endorsement::find($id)->account_name.' (Co-Borrower) ASSOCIATES TO ACCOUNT:'.Endorsement::find($request->main_id)->account_name.' (Main Subject))',
                        'type' => 'ci_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);

            }
            else
            {
                $istrue = 'true';
                $list_of_ngangers .= $check[0]->account_name.', ';
            }
        }

        return response()->json([$list_of_ngangers,$istrue]);

    }

    public function ci_account_remove_select_asso(Request $request)
    {

        $get_endo_id = $request->endorse_id;
        $get_asso_id = $request->asso_id;

        $check = DB::table('asso_expenses')
            ->where('subject_id',$get_endo_id)
            ->where('coob_id',$get_asso_id)
            ->count();

        if($check >= 1)
        {
            DB::table('asso_expenses')
                ->where('subject_id',$get_endo_id)
                ->where('coob_id',$get_asso_id)
                ->delete();

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'activity_id' => $get_asso_id,
                    'activity' => '(ACCOUNT:  '.Endorsement::find($get_asso_id)->account_name.' (Co-Borrower) REMOVE ASSOCIATE TO ACCOUNT:'.Endorsement::find($get_endo_id)->account_name.' (Main Subject))',
                    'type' => 'ci_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

        }
    }

    public function get_message_info(Request $request)
    {
        $to_return = DB::table('message_info')
            ->where('to_user_id', Auth::user()->id)
            ->select('message','to_view','date_time')
            ->orderBy('id','desc')
            ->get();

        $from_return = DB::table('message_info')
            ->where('from_user_id', Auth::user()->id)
            ->select('message','from_view','date_time')
            ->orderBy('id','desc')
            ->get();

        return response()->json([$from_return,$to_return]);
    }

    public function del_message_view_count(Request $request)
    {
        DB::table('message_info')
            ->where('to_user_id', Auth::user()->id)
            ->update(['to_view'=>'true']);

        DB::table('message_info')
            ->where('from_user_id', Auth::user()->id)
            ->update(['from_view'=>'true']);
    }


    public function ci_fund_checker_receiving(Request $request)
    {

        DB::table('ci_fund_remittances')
            ->where('user_id',Auth::user()->id)
            ->where('check','')
            ->where('confirm_date_time','!=','0000-00-00 00:00:00')
            ->update([
                'check' => 'check'
            ]);

    }

    public function ci_get_finish_accounts_for_expenses()
    {

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $dateN = $splitDateTime[0];
        $timeN = $splitDateTime[1];

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.acct_status',
                    'endorsements.date_ci_forwarded',
                    'endorsements.address',
                    'municipalities.muni_name as city_muni',
                    'endorsements.provinces',

                ]
            )
            ->orderBy('id','desc')
            ->where('user_id',Auth::user()->id)
            ->where('endorsements.acct_status','!=',1)
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where('endorsements.date_ci_forwarded','=',$dateN)
            ->get();

        return response()->json([$endorsements,$dateN]);
    }

    public function ci_submit_daily_expenses(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $total_count = $request->total_count;
        $endorsement_count = $request->endorsement_count;

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $dateN = $splitDateTime[0];
        $timeN = $splitDateTime[1];
        $ci_id = Auth::user()->id;
//
        $get_daily_id = DB::table('ci_daily_expenses_date')
            ->insertGetId([
                'ci_id' => $ci_id,
                'date' => $dateN,
                'time' => $timeN,
                'created_at' => $timeStamp
            ]);


        if($endorsement_count != 0)
        {
            for($ctr = 0; $ctr<$endorsement_count; $ctr++)
            {
                DB::table('ci_daily_expenses_pivot_endorsement')
                    ->insert([
                        'daily_id' => $get_daily_id,
                        'endorsement_id' => $request->endorsements_array_id[$ctr]
                    ]);
            }
        }

        $if_attachment = false;
        if($total_count != 0)
        {
            for($ctr = 0; $ctr<$total_count; $ctr++)
            {
                if($request->get($ctr.'-checker') != 'deleted')
                {
                    if($request->get($ctr.'-file_to_upload') == 'No uploaded file')
                    {
                        $file_name = 'No uploaded file';
                    }
                    else
                    {
                        $check_file = $request->file($ctr.'-file_to_upload');
                        $file_name = $check_file->getClientOriginalName();
                        $check_file->move(storage_path('ci_expenses/'.$ci_id.'/'.$get_daily_id.'/'),$file_name);
                        $if_attachment = true;
                    }

                    DB::table('ci_daily_expenses')
                        ->insert([
                            'daily_id' => $get_daily_id,
                            'label' => $removeScript->scripttrim($request->get($ctr.'-label')),
                            'amount' => $request->get($ctr.'-amount'),
                            'from' => $request->get($ctr.'-from'),
                            'or' => $request->get($ctr.'-or_label'),
                            'or_attachment' => $file_name,
                            'remarks' => $request->get($ctr.'-remarks'),
                            'created_at' => $timeStamp,
                        ]);
                }
            }
            //logs here

            $attachie = 'no attachment';

            if($if_attachment)
            {
                $attachie = 'attachment';
            }

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'activity_id' => $get_daily_id,
                    'activity' => '(Declared Expenses with '.$attachie.') Total Expenses: '.$request->get('total_expenses').', Total Reimbursement: '.$request->get('total_reimbursement'),
                    'type' => 'ci_logs',
                    'datetime' => $timeStamp
                ]);

        }
        return 'success';
    }

    public function ci_get_expenses_report_table()
    {
        $catch_them_all = DB::table('ci_daily_expenses_date')
            ->join('users','users.id','=','ci_daily_expenses_date.ci_id')
            ->leftjoin('ci_daily_expenses','ci_daily_expenses.daily_id','=','ci_daily_expenses_date.id')
            ->leftjoin('ci_daily_expenses_pivot_endorsement','ci_daily_expenses_pivot_endorsement.daily_id','=','ci_daily_expenses_date.id')
            ->leftjoin('endorsements','endorsements.id','=','ci_daily_expenses_pivot_endorsement.endorsement_id')
            ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select([
                'ci_daily_expenses_date.id as id',
                'ci_daily_expenses_date.date as date',
                'ci_daily_expenses_date.time as time',

                'users.name as ci_name',

                'ci_daily_expenses.label as label',
                'ci_daily_expenses.amount as amount',
                'ci_daily_expenses.from as from',
                'ci_daily_expenses.or_attachment as or_attachment',
                'ci_daily_expenses.remarks as remarks',

                'endorsements.type_of_request as type_of_request',
            ])
            ->groupBy('id')
            ->where('users.id',Auth::user()->id);

        return DataTables::of($catch_them_all)
            ->editColumn('label_edit', function ($data){

                $get_label = DB::table('ci_daily_expenses')
                    ->select('label')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_label = '<br>';
                $count = 1;
                if(count($get_label) != 0)
                {
                    foreach ($get_label as $label)
                    {
                        $ret_label .= $count.'. '.$label->label.'<br>';
                        $count++;
                    }
                }

                return $ret_label;

            })
            ->editColumn('amount_edit', function ($data){

                $get_amount = DB::table('ci_daily_expenses')
                    ->select('amount')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_amount = '<br>';
                $count = 1;
                if(count($get_amount) != 0)
                {
                    foreach ($get_amount as $amount)
                    {
                        $ret_amount .= $count.'. '.$amount->amount.' Php <br>';
                        $count++;
                    }
                }

                return $ret_amount;

            })
            ->editColumn('amount_total_edit', function ($data){

                $get_amount = DB::table('ci_daily_expenses')
                    ->select('amount','from')
                    ->where('daily_id',$data->id)
                    ->get();

                $total_expenses = 0;
                $total_reimbursement = 0;

                if(count($get_amount) != 0)
                {
                    foreach ($get_amount as $amount)
                    {
                        if($amount->from == 'Fund')
                        {
                            $total_expenses = $total_expenses + (int)$amount->amount;
                        }
                        else if($amount->from == 'Personal')
                        {
                            $total_reimbursement = $total_reimbursement + (int)$amount->amount;
                        }
                        else if($amount->from == 'Revolving')
                        {
                            $total_expenses = $total_expenses + (int)$amount->amount;
                        }


                    }

                }

                $ret_amount = '<br>Total Expenses: '.$total_expenses.' Php<br>Total Reimbursement: '.$total_reimbursement.' Php';

                return $ret_amount;

            })
            ->editColumn('from_edit', function ($data){

                $get_from = DB::table('ci_daily_expenses')
                    ->select('from')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_from = '<br>';
                $count = 1;
                if(count($get_from) != 0)
                {
                    foreach ($get_from as $from)
                    {
                        $ret_from .= $count.'. '.$from->from.'<br>';
                        $count++;
                    }
                }

                return $ret_from;

            })
            ->editColumn('or_edit', function ($data){

                $get_or = DB::table('ci_daily_expenses')
                    ->select('or_attachment')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_or = '<br>';
                $count = 1;
                if(count($get_or) != 0)
                {
                    foreach ($get_or as $or)
                    {
                        $ret_or .= $count.'. '.$or->or_attachment.'<br>';
                        $count++;
                    }
                }

                return $ret_or;

            })
            ->editColumn('remarks_edit', function ($data){

                $get_remarks = DB::table('ci_daily_expenses')
                    ->select('remarks')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_remark = '<br>';
                $count = 1;
                if(count($get_remarks) != 0)
                {
                    foreach ($get_remarks as $remark)
                    {
                        $ret_remark .= $count.'. '.$remark->remarks.'<br>';
                        $count++;
                    }
                }

                return $ret_remark;

            })
            ->editColumn('account_edit', function ($data){

                $account_info = DB::table('ci_daily_expenses_date')
                    ->leftjoin('ci_daily_expenses_pivot_endorsement','ci_daily_expenses_pivot_endorsement.daily_id','=','ci_daily_expenses_date.id')
                    ->leftjoin('endorsements','endorsements.id','=','ci_daily_expenses_pivot_endorsement.endorsement_id')
                    ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
                    ->select([
                        'ci_daily_expenses_date.id as id',
                        'endorsements.account_name as account_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.address',
                        'municipalities.muni_name as city_muni',
                        'endorsements.provinces',
                    ])
                    ->where('ci_daily_expenses_date.id',$data->id)
                    ->get();

                $ret_infos = '<br>';
                $count = 1;
                if(count($account_info) != 0)
                {
                    foreach ($account_info as $info)
                    {
                        $ret_infos .= $count.'. '.$info->type_of_request.' / '.$info->account_name.' / '.$info->address.' '.$info->city_muni.' '.$info->provinces.'<br>';
                        $count++;
                    }
                }

                return $ret_infos;

            })
            ->rawColumns(['label_edit','amount_edit','amount_total_edit','from_edit','or_edit','remarks_edit','account_edit'])
            ->make(true);

    }

    public function ci_liquidate_fund_amount(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $stat = $request->status;
        $removeScript = new ScriptTrimmer();

        $getSome = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select('fund_amount')
            ->get();

        $liqamount = base64_decode($getSome[0]->fund_amount);

        $unliq = $liqamount - $request->liqamount;

        $values = json_decode($request->declareArray);

        $idfiles = json_decode($request->idFiles);

        $imgCount = $request->countImage;

        $counterInsert = json_decode($request->countArrayofFiles);

        $remArray = json_decode($request->fundRemarksIndiv);

        $getCi = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select('ci_id')
            ->get();

        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'liquidated_amount' => $request->liqamount,
                'unliquidated_amount' => $unliq,
                'ci_liq_rem' => $removeScript->scripttrim($request->liqRem)
            ]);

        if($stat == 'pending')
        {
            if($request->declareArray != null)
            {
                foreach($values as $value)
                {
                    DB::table('fund_request_liquidate')
                        ->insert
                        ([
                            'fund_id' => $request->id,
                            'endorse_id'=> $value[0],
                            'liquidate_amount' => $value[1],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
                if($imgCount >= 1)
                {
                    $checkImageLogs = ' With Attachment/s';
                }
                else
                {
                    $checkImageLogs = ' Without Attachment/s';
                }

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>Auth::user()->id,
                        'activity_id' => $request->id,
                        'activity' => '{LIQUIDATED FROM APPROVED ₱ ' . $liqamount .  ' FUND REQUESTS) ' . 'Liquidated Amount : ₱ ' . $removeScript->scripttrim($request->liqamount) . ', Unliquidataed Amount : ₱ ' . $unliq . ', '. $checkImageLogs,
                        'type' => 'ci_fund_request_liquidate',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }
            $path1 = '';
            if($imgCount >= 1)
            {
                for($u = 0; $u < count($counterInsert); $u++)
                {
                    if($idfiles[$u] != null)
                    {
                        $getData = DB::table('endorsements')
                            ->select('account_name', 'type_of_request', 'id')
                            ->where('id', $idfiles[$u])
                            ->get();
                        for($r = 0; $r < $counterInsert[$u]; $r++)
                        {
                            $file = Input::file('image_' . $u . '-' . $r);

                            if($file != null)
                            {
                                $name = $getData[0]->account_name . '_' . $idfiles[$u] . '_' . $getData[0]->type_of_request . '_OR_' .  ($r + 1) . '.' . $file->getClientOriginalExtension();

                                $file->move(storage_path('ci_liquidated_img/' . $getCi[0]->ci_id . '/' . $request->id . '/' . $idfiles[$u]), $name);

                                $path1 .= 'ci_liquidated_img/' . $getCi[0]->ci_id . '/' . $request->id . '/' . $idfiles[$u] . '/' . $name . '|';
                            }
                        }
                    }
                    DB::table('fund_request_liquidate')
                        ->where('endorse_id', $idfiles[$u])
                        ->where('fund_id', $request->id)
                        ->update
                        ([
                            'receipt_attachment' => $path1
                        ]);
                    $path1 = '';
                }
            }
            else
            {

            }

            $getData = DB::table('fund_requests')
                ->where('id', $request->id)
                ->select
                (
                    'ci_id'
                )
                ->get();

            $realtimeNow = 0;

            $check = DB::table('ci_fund_realtime_amount')
                ->where('user_id',$getData[0]->ci_id)
                ->select('fund')
                ->count();

            if($check == 0)
            {
                $realtimefund = 0;
            }
            else
            {
                $realtimefund = DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$getData[0]->ci_id)
                    ->select('fund_realtime', 'unliq_fund')
                    ->get();
            }
            DB::table('fund_requests')
                ->where('id', $request->id)
                ->update
                ([
                    'liquidation_status' => 'liquidated'
                ]);
        }
        else if($stat == 'done')
        {
            if($request->declareArray != null)
            {
                foreach($values as $value)
                {
                    $getLiqCheck = DB::table('fund_request_liquidate')
                        ->where('endorse_id', $value[0])
                        ->select('liquidate_amount')
                        ->get();

                    if($getLiqCheck[0]->liquidate_amount != $value[1])
                    {
                        DB::table('fund_request_liquidate')
                            ->where('endorse_id', $value[0])
                            ->update
                            ([
                                'liquidate_amount' => $value[1],
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                }

                if($imgCount >= 1)
                {
                    $checkImageLogs = ' With Attachment/s';
                }
                else
                {
                    $checkImageLogs = ' Without Attachment/s';
                }

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>Auth::user()->id,
                        'activity_id' => $request->id,
                        'activity' => '{UPDATED LIQUIDATED AMOUNT FROM APPROVED ₱ ' . $liqamount .  ' FUND REQUESTS) ' . 'Liquidated Amount : ' . $request->liqamount . ', Unliquidataed Amount : ' . $unliq . $checkImageLogs,
                        'type' => 'ci_fund_request_liquidate',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }
            $path2 = '';
            if($imgCount >= 1)
            {
                for ($u = 0; $u < count($counterInsert); $u++) {
                    if ($idfiles[$u] != null) {
                        $getData = DB::table('endorsements')
                            ->select('account_name', 'type_of_request', 'id')
                            ->where('id', $idfiles[$u])
                            ->get();

                        $getPathExist = DB::table('fund_request_liquidate')
                            ->select('receipt_attachment')
                            ->where('endorse_id', $idfiles[$u])
                            ->where('fund_id', $request->id)
                            ->get();

                        $testdagdag = $getPathExist[0]->receipt_attachment;
                        $namePath = explode("|", $testdagdag);
                        $countfiles = count($namePath);

                        for ($r = 0; $r < $counterInsert[$u]; $r++) {
                            $file = Input::file('image_' . $u . '-' . $r);

                            if ($file != null)
                            {
                                $name = $getData[0]->account_name . '_' . $idfiles[$u] . '_' . $getData[0]->type_of_request . '_OR_' . ($countfiles) . '.' . $file->getClientOriginalExtension();

                                $file->move(storage_path('ci_liquidated_img/' . $getCi[0]->ci_id . '/' . $request->id . '/' . $idfiles[$u]), $name);


                                $path2 .= 'ci_liquidated_img/' . $getCi[0]->ci_id . '/' . $request->id . '/' . $idfiles[$u] . '/' . $name . '|';

                                $countfiles++;
                            }
                        }
                        $newPath = $testdagdag . $path2;

                        DB::table('fund_request_liquidate')
                            ->where('endorse_id', $idfiles[$u])
                            ->where('fund_id', $request->id)
                            ->update
                            ([
                                'receipt_attachment' => $newPath,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                        $path2 = '';
                    }
                }
            }
            else
            {

            }

            DB::table('fund_requests')
                ->where('id', $request->id)
                ->update
                ([
                    'liquidation_status' => 'liquidated'
                ]);
        }


        foreach($remArray as $rem)
        {
            DB::table('fund_request_liquidate')
                ->where('fund_id', $request->id)
                ->where('endorse_id', $rem[1])
                ->update
                ([
                    'indiv_remarks' => $removeScript->scripttrim($rem[0])
                ]);
        }

    }

    public function ci_fund_done_liq_table()
    {
        $funds =  DB::table('ci_fund_remittances')
            ->leftjoin('remittance','remittance.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','ci_fund_remittances.fund_id')
            ->leftjoin('fund_requests','fund_requests.id','=','ci_fund_remittances.fund_id')
            ->select([
                'ci_fund_remittances.id as id',
                'ci_fund_remittances.remittance_id as remittance_id',
                'ci_fund_remittances.ci_shell_card_id as ci_shell_card_id',
                'ci_fund_remittances.ci_atm_fund_id as ci_atm_fund_id',
                'ci_fund_remittances.confirm_date_time as confirm_fund',

                'remittance.id as remit_id',
                'remittance.amount as remit_amount',
                'remittance.remittance_info as remittance_info',
                'remittance.remarks as remit_remarks',
                'remittance.date_of_send as remit_date_of_send',
                'remittance.receive_status_date_time as remit_status_date_time',
                'remittance.receive_status as remit_status',

                'ci_atm_fund.id as atm_id',
                'ci_atm_fund.amount as atm_amount',
                'ci_atms.bank_name as atm_bank_name',
                'ci_atms.account_number as atm_account_number',
                'ci_atm_fund.remarks as atm_remarks',
                'ci_atm_fund.date_of_send as atm_date_of_send',
                'ci_atm_fund.receive_status_date_time as atm_status_date_time',
                'ci_atm_fund.receive_status as atm_status',

                'ci_shell_include_fund.id as shell_id',
                'ci_shell_include_fund.with_or_without as shell_with_or_without',
                'ci_shell_include_fund.date_of_send as shell_date_of_send',
                'ci_shell_include_fund.receive_status_date_time as shell_status_date_time',
                'ci_shell_include_fund.receive_status as shell_status',

                'fund_requests.finance_remarks as finance_remarks',
                'fund_requests.date_time_remarks as date_time_remarks',
                'fund_requests.id as fund_id',
                'fund_requests.liquidated_amount as liq',
                'fund_requests.unliquidated_amount as unliq',
                'fund_requests.fund_amount as fund_amount'
            ])
            ->where(function ($query)
            {
                return $query->orwhere('remittance.receive_status','received')
                    ->orwhere('ci_atm_fund.receive_status','received')
                    ->orwhere('ci_shell_include_fund.receive_status','received')
                    ->orwhere('ci_fund_remittances.remarks_fund', 'assign');
            })
            ->where('ci_fund_remittances.user_id',Auth::user()->id)
            ->where(function ($query)
            {
                return $query->orwhere('fund_requests.approved_request_done', 'Done')
                    ->orwhere('fund_requests.approved_request_done', 'Assigned')
                    ->orwhere('fund_requests.approved_request_done', 'New');
            })
            ->where(function ($query)
            {
                return $query->orwhere('fund_requests.success_hold_cancel', '')
                    ->orwhere('fund_requests.success_hold_cancel', 'Override');
            })
            ->where('fund_requests.liquidation_status', '=', 'liquidated');

        return DataTables::of($funds)
            ->editColumn('remit_info', function ($data)
            {

                $remittance_check = $data->remittance_id;
                $atm_check = $data->ci_atm_fund_id;
                $shell_check = $data->ci_shell_card_id;
                $remittance_info = $data->remittance_info;

                $code = '';

                if($remittance_check == 0 && $atm_check== 0)
                {
                    $code = '-';
                }
                else if($remittance_check != 0)
                {
                    $code = $remittance_info;
                }
                else if($atm_check != 0)
                {
                    $code = '-';

                }
                else if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    $code = '-';

                }
                return $code;

            })
            ->editColumn('stats', function ($data)
            {
                $finance_remarks = $data->finance_remarks;
                $finance_date_time_remarks = $data->date_time_remarks;

                $to_return = $finance_remarks.'<br><br><br>Last Update: '.$finance_date_time_remarks;

                return $to_return;
            })
            ->rawColumns(['remit_info','stats'])
            ->make(true);
    }

    public function ci_check_login()
    {
        $now = Carbon::now('Asia/Manila');

        $eks = explode(' ', $now);

        $checkAtt = DB::table('ci_login_trails')
            ->where('ci_id', Auth::user()->id)
            ->where('type', 'Attendance')
            ->where('created_at','like', '%'.$eks[0].'%')
            ->count();

        return response()->json($checkAtt);
    }

    public function ci_upload_pic_daily(Request $request)
    {
        $file = $request->file;
        $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
        $code_date = explode('-',$code_date_time[0]);
        $code_time = explode(':',$code_date_time[1]);


        if($file != null)
        {
            $name = Auth::user()->id .'-'.$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2] . '.' .  $file->getClientOriginalExtension();
            $file->move(storage_path('/ci_daily_photo_attendance/' . Auth::user()->id  . '/'), $name);
            $path = '/ci_daily_photo_attendance/' . Auth::user()->id . '/' . $name;

            DB::table('ci_login_trails')
                ->insert
                ([
                    'ci_id' => Auth::user()->id,
                    'lat'     => '0',
                    'long' => '0',
                    'address_location' => "cannot detect gps",
                    'created_at' => Carbon::now('Asia/Manila'),
                    'updated_at' => Carbon::now('Asia/Manila'),
                    'type' => 'Attendance',
                    'photo_path' => $path
                ]);
        }
        else
        {
            $path = '';
        }
    }

    public function ci_save_data_encode(Request $request)
    {
        $data = $request->data_encoded;
        $account_id = $request->account_id;
        $temp_id = $request->temp_id;
        $type = $request->type;

        $date_time = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$date_time);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $encode_only = false;

        if($type != 'download_instead')
        {
            $encode_only = true;
            $check =  DB::table('ci_save_data_encoded')
                ->select('endorsements_id','ci_id')
                ->where('endorsements_id',$account_id)
                ->where('ci_id',Auth::user()->id)
                ->get();

            if(count($check) > 0)
            {
                DB::table('ci_save_data_encoded')
                    ->where('endorsements_id', $account_id)
                    ->where('ci_id', Auth::user()->id)
                    ->update([
                        'encoded' => $data,
                        'created_at' => $date_time,
                        'temp_id' => $temp_id
                    ]);
            }
            else
            {
                DB::table('ci_save_data_encoded')
                    ->insert([
                        'endorsements_id' => $account_id,
                        'ci_id' => Auth::user()->id,
                        'encoded' => $data,
                        'created_at' => $date_time,
                        'temp_id' => $temp_id
                    ]);
            }

            $get_template_encoded =  DB::table('ci_encode_form_info')
                ->select(
                    [
                        'id as temp_id',
                        'temp_name',
                        'temp_name_file',
                        'sheet_name_template',
                        'temp_col_count',
                        'sheet_name_validation',
                        'validation_col_start',
                        'validation_col_end',
                    ])
                ->where('id',$temp_id)
                ->get();

            if(count($get_template_encoded) != 0)
            {

            }
            else
            {
                return 'no template';
            }
        }

        if($encode_only)
        {
            if($type == 'save_final')
            {
//                $json = $json['data'][0]['id'];
                $path_link = new DownloadZipLogic();
                $paths = $path_link->path_link($account_id);

                $certified = DB::table('certifieds')
                    ->where('user_id',Auth::user()->id)
                    ->select('cert')
                    ->first();
                

                if ($certified->cert == 'NC')
                {
                    $stor_path = '/account/'.$paths;;
                }
                else
                {
                    $stor_path = '/account_client/'.$paths;;
                }


                Excel::load(storage_path().'/EncodableFormForCI/'.$get_template_encoded[0]->temp_name_file, function($reader) use ($get_template_encoded, $data) {
                    $json = json_decode($data,true);
//
//                    $reader->getSheet(0);
//                    $reader->toArray();
//                    $reader->noHeading();
//                    $reader->getDefaultStyle();

                    $reader->sheet($get_template_encoded[0]->sheet_name_template,function($sheet) use ($json) {

                        for($ctr = 0; $ctr<count($json['data']); $ctr++)
                        {
                            $sheet->cell($json['data'][$ctr]['id'], function($cell) use ($ctr, $json) {

                                // $cell->setValue($json['data'][$ctr]['value']);
                                $cell->setValue(preg_replace("<br>", "\r", $json['data'][$ctr]['value']));

                            });
                        }

                        for($ctr = 0; $ctr<count($json['data_label']); $ctr++)
                        {
                            $sheet->cell($json['data_label'][$ctr]['id'], function($cell) use ($ctr, $json) {

                                // $cell->setValue($json['data_label'][$ctr]['value']);
                                $cell->setValue(preg_replace("<br>", "\r", $json['data_label'][$ctr]['value']));

                            });

                        }

                    });
                })
                    ->setFilename($get_template_encoded[0]->temp_name.' (OIMS Generated)')
                    ->store('xlsx', storage_path($stor_path));

                DB::table('endorsements')
                    ->where('id',$account_id)
                    ->update
                    ([
                        'encoded_template_name' => $get_template_encoded[0]->temp_name_file,
                        'encoded_template_date_time' => $date_time,
                    ]);


                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $account_id,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper( $this->var_session()->get('role')),
                            'branch' => strtoupper( $this->var_session()->get('userBranch')),
                            'activities' => strtoupper('Account report save and attached ( '.$get_template_encoded[0]->temp_name_file.' ) successfully.'),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );


                return 'success saving final';
            }
            else if($type == 'save_only')
            {
                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $account_id,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper( $this->var_session()->get('role')),
                            'branch' => strtoupper( $this->var_session()->get('userBranch')),
                            'activities' => strtoupper('Account report saved (Only) successfully.'),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );
                return 'success saving';
            }
        }
        else
        {
            DB::table('endorsements')
                ->where('id',$account_id)
                ->update
                ([
                    'encoded_template_name' => 'Through downloaded attachment',
                    'encoded_template_date_time' => $date_time,
                ]);


            DB::table('audits')
                ->insert
                (
                    [
                        'endorsement_id' => $account_id,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper( $this->var_session()->get('role')),
                        'branch' => strtoupper( $this->var_session()->get('userBranch')),
                        'activities' => strtoupper('Report of account through downloaded attachment.'),
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );
            return 'download instead';
        }
    }

    public function get_save_data_encoded(Request $request)
    {
        $account_id = $request->account_id;

        $get =  DB::table('ci_save_data_encoded')
            ->select('endorsements_id','ci_id','encoded')
            ->where('endorsements_id',$account_id)
            ->where('ci_id',Auth::user()->id)
            ->get();

        if(count($get) != 0)
        {
            $to_oass = $get[0]->encoded;
        }
        else
        {
            $to_oass = 'none';
        }

        return response()->json($to_oass);
    }

    public function ci_get_select_encode_template(Request $request)
    {
        $account_id = $request->account_id;

        $get =  DB::table('ci_encode_form_info')
            ->select(
                [
                    'id as temp_id',
                    'temp_name',
                    'temp_name_file',
                    'sheet_name_template',
                    'temp_col_count',
                    'sheet_name_validation',
                    'validation_col_start',
                    'validation_col_end',
                ])
            ->orderBy('temp_name','asc')
            ->get();

        $check_encoded = DB::table('ci_save_data_encoded')
            ->select([
                'temp_id',
                'endorsements_id',
                'ci_id'
            ])
            ->where('endorsements_id',$account_id)
            ->where('ci_id',Auth::user()->id)
            ->get();

        if(count($check_encoded) == 0)
        {
            $default = 'select';

        }
        else
        {
            $default = 'auto';
        }

        return response()->json([$get,$default,$check_encoded]);
    }

    public function ci_check_validation_en_attach_visit(Request $request)
    {

        $account_id = $request->acctID;
        $where = $request->where;

        $check = DB::table('endorsements')
            ->select(
                'encoded_template_name',
                'encoded_template_date_time',
                'date_ci_forwarded',
                'time_ci_forwarded',
                'date_ci_visit',
                'time_Ci_visit',
                'ci_cert',
                'acct_status')
            ->where('id',$account_id)
            ->get();


        $encode_name = $check[0]->encoded_template_name;
        $encode_date_time = $check[0]->encoded_template_date_time;

        $attach_date = $check[0]->date_ci_forwarded;
        $attach_time = $check[0]->time_ci_forwarded;

        $visit_date = $check[0]->date_ci_visit;
        $visit_time = $check[0]->time_Ci_visit;

        $check_encode = false;
        $check_attach = false;
        $check_visit = false;

        $account_status = $check[0]->acct_status;

        if($encode_name != null && $encode_date_time != null)
        {
            $check_encode = true;
        }

        if($attach_date != null && $attach_time != '00:00:00')
        {
            $check_attach = true;
        }

        if($visit_date != null && $visit_time != '00:00:00')
        {
            $check_visit = true;
        }


        if($check_encode == true && $check_attach == true)
        {
            if($where == 'need_to_refresh')
            {
                if($account_status == 1)
                {
                    DB::table('endorsements')
                        ->where('id', $account_id)
                        ->update
                        (
                            [
                                'acct_status' => 2
                            ]
                        );
                }
                else if($account_status == 3 && $check->ci_cert == 'NC')
                {
                    return response()->json([
                        'stat'      =>  'upload_not_avail',
                        'encode'    =>  $check_encode,
                        'attach'    =>  $check_attach,
                        'visit'     =>  $check_visit
                    ]);
                }

                $date_time = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ",$date_time);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];


                $users = User::find(Auth::user()->id);
                foreach ($users->roles as $user)
                {
                    $role = $user->name;
                    $this->var_session()->put('role', $role);
                }
                foreach ($users->provinces as $branch)
                {
                    $userBranch = $branch->name;
                    $this->var_session()->put('userBranch', $userBranch);
                }

                //      TOTAL TIME LOSS
                $timeStampNoww = Carbon::now('Asia/Manila');
                $dateEndorsed = Endorsement::find($account_id);
                $dateEndo = $dateEndorsed->date_dispatched;
                $timeEndorsed = Endorsement::find($account_id);
                $timeEndo = $timeEndorsed->time_dispatched;
                $dateTimeLoss = $timeStampNoww->diffForHumans(Carbon::parse($dateEndo.' '.$timeEndo));
                DB::table('timestamps')
                    ->where('endorsement_id',$account_id)
                    ->update(['time_ci'=>$dateTimeLoss]);
                //      END
            }

            return response()->json([
                'stat'      =>  'good_to_go',
                'encode'    =>  $check_encode,
                'attach'    =>  $check_attach,
                'visit'     =>  $check_visit
            ]);
        }
        else
        {
            return response()->json([
                'stat'      =>  'not_good_to_go',
                'encode'    =>  $check_encode,
                'attach'    =>  $check_attach,
                'visit'     =>  $check_visit
            ]);
        }
    }
  
    public function ci_upload_pic_daily_fineuploader(Request $request, $folderDateTime)
    {
        $dateToday = Carbon::now('Asia/Manila');
        $splitDatev1 = explode(' ', $dateToday);
        $splitFolder1 = explode('-', $splitDatev1[0]);
        $splitDatev2 = preg_split('/[:, -]/', $dateToday);

        $uploader = new handler();

//        $id = $uploader->id;

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $uploader->ismethod();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST")
        {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done


            if (isset($_GET["done"]))
            {
                $result = $uploader->combineChunks(('ci_daily_photo_attendance/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('ci_daily_photo_attendance/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime)));
                {
                    File::makeDirectory(storage_path('/ci_daily_photo_attendance/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime),$mode = 0777, true, true);
                }
                $result = $uploader->handleUpload(storage_path('ci_daily_photo_attendance/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime));
                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            echo json_encode($result);
        }
        // for delete file requests
        else if ($method == "DELETE")
        {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        }
        else
        {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function ci_update_attendace_photo(Request $request)
    {
        $dateToday = Carbon::now('Asia/Manila');

        DB::table('ci_login_trails')
            ->insert
            ([
                'ci_id' => Auth::user()->id,
                'lat'     => '0',
                'long' => '0',
                'address_location' => "cannot detect gps",
                'user_agent' => $request->userAgent(),
                'user_ip' => $request->ip(),
                'created_at' => $dateToday,
                'updated_at' => $dateToday,
                'type' => 'Attendance',
                'photo_path' => 'ci_daily_photo_attendance/'. Auth::user()->id . '/' . $request->unang_folder . '/' . $request->pangalawang_folder
            ]);
    }

    public function ci_get_attendancePhotos(Request $request)
    {
        $file_name_array = [];
        $file_path = [];
        $getRecord = DB::table('ci_login_trails')
            ->where('id', $request->id)
            ->select('photo_path')
            ->get();

        $directory = storage_path($getRecord[0]->photo_path);
        $filecount = glob("$directory/*");

        for($ctr = 0; $ctr<count($filecount); $ctr++)
        {
            $file_name_array[$ctr] = explode($getRecord[0]->photo_path.'/',$filecount[$ctr])[1];
            $file_path[$ctr] = $filecount[$ctr];
        }

        return response()->json([$file_name_array, $request->id]);
    }

    public function ci_bi_reports_table()
    {
        $getNotes = DB::table('bi_ci_report')
            ->where('ci_id', Auth::user()->id)
            ->where('created_at','>=',Carbon::now('Asia/Manila')->subDays(30))
            ->where('created_at','<=',Carbon::now('Asia/Manila'));

        return DataTables::of($getNotes)
            ->make(true);
    }

    public function ci_add_bi_note(Request $request)
    {
        $verify = DB::table('bi_ci_report')
            ->where('ci_id', $request->verifier)
            ->select('id')
            ->get();

        $getId = $verify[0]->id;

        DB::table('bi_ci_report')
            ->where('ci_id', $request->verifier)
            ->update([
                    'ci_id' => Auth::user()->id,
                    'client_name' => $request->client_name,
                    'subj_name' => $request->subj_name,
                    'ci_note' => $request->note,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

        DB::table('bi_ci_report_logs')
            ->insert([
                'user_id' => Auth::user()->id,
                'bi_report_id' => $getId,
                'activity' => 'ADDED THE REPORT OF '. strtoupper($request->subj_name),
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        return response()->json(['ok', $getId]);
    }

    public function ci_edit_bi_note(Request $request)
    {
        $id = base64_decode($request->id);

        DB::table('bi_ci_report')
            ->where('id', $id)
            ->update([
                'ci_id' => Auth::user()->id,
                'client_name' => $request->client_name,
                'subj_name' => $request->subj_name,
                'ci_note' => $request->note,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        DB::table('bi_ci_report_logs')
            ->insert([
                'user_id' => Auth::user()->id,
                'bi_report_id' => $id,
                'activity' => 'UPDATED THE REPORT OF '. strtoupper($request->subj_name),
                'created_at' => Carbon::now('Asia/Manila')
            ]);

            return 'ok';
    }

    public function ci_bi_note_view_logs(Request $request)
    {
        $getRec = DB::table('bi_ci_report_logs')
            ->join('users', 'users.id', '=', 'bi_ci_report_logs.user_id')
            ->join('role_user', 'role_user.user_id', '=', 'bi_ci_report_logs.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('bi_ci_report_logs.bi_report_id', $request->id)
            ->select([
                'users.name as name',
                'roles.name as position',
                'bi_ci_report_logs.activity as activities',
                'bi_ci_report_logs.created_at as datetime',
            ])
            ->get();

        return response()->json([$getRec]);
    }

    public function ci_upload_bi_report_fineuploader(Request $request, $verifier)
    {
        $getiD = '';
        $verify = DB::table('bi_ci_report')
            ->where('ci_id', $verifier)
            ->select('id')
            ->get();

        if(count($verify) <= 0)
        {
            $getiD = DB::table('bi_ci_report')
                ->insertGetId([
                    'ci_id' => $verifier
                ]);
        }
        else
        {
            $getiD = $verify[0]->id;
        }

        $uploader = new handler();

//        $id = $uploader->id;

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $uploader->ismethod();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST")
        {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done


            if (isset($_GET["done"]))
            {
                $result = $uploader->combineChunks(('ci_bi_report/'. Auth::user()->id . '/' . $getiD));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('ci_bi_report/'. Auth::user()->id . '/' . $getiD)));
                {
                    File::makeDirectory(storage_path('/ci_bi_report/'. Auth::user()->id . '/' . $getiD),$mode = 0777, true, true);
                }
                $result = $uploader->handleUpload(storage_path('ci_bi_report/'. Auth::user()->id . '/' . $getiD));
                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            echo json_encode($result);
        }
        // for delete file requests
        else if ($method == "DELETE")
        {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        }
        else
        {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function ci_upload_bi_report_fineuploader_edit(Request $request, $repo_id)
    {
        $getiD = $repo_id;

        $uploader = new handler();

//        $id = $uploader->id;

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $uploader->ismethod();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST")
        {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done


            if (isset($_GET["done"]))
            {
                $result = $uploader->combineChunks(('ci_bi_report/'. Auth::user()->id . '/' . $getiD));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('ci_bi_report/'. Auth::user()->id . '/' . $getiD)));
                {
                    File::makeDirectory(storage_path('/ci_bi_report/'. Auth::user()->id . '/' . $getiD),$mode = 0777, true, true);
                }
                $result = $uploader->handleUpload(storage_path('ci_bi_report/'. Auth::user()->id . '/' . $getiD));
                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            echo json_encode($result);
        }
        // for delete file requests
        else if ($method == "DELETE")
        {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        }
        else
        {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function ci_get_update_time_details(Request $request)
    {
        $getUdt = DB::table('endorsements')
            ->select('date_ci_visit', 'time_ci_visit')
            ->where('id', $request->id)
            ->get();

        $data = DB::table('users')
            ->select('ci_update_date_permission as stat')
            ->where('id', Auth::user()->id)
            ->get();

        return response()->json([$getUdt, $data]);
    }
}