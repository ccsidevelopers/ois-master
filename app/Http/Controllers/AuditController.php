<?php

namespace App\Http\Controllers;

use App\Generals\AuditFundQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\ScriptTrimmer;
use App\Generals\SmsNotification;
use App\Generals\Trimmer;
use App\handler;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Generals\AuditQueries;
use ZanySoft\Zip\Zip;

class AuditController extends Controller
{
    public function getAuditDashboard()
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
            } elseif (Auth::user()->hasRole('Audit')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('audit.audit-dashboard', compact('timeStamp'))->with(["page" => "audit-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getAuditPanel()
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
            } elseif (Auth::user()->hasRole('Audit')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;
                    
                $getCCBank = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->select([
                        'users.id as id',
                        'users.name as name'
                    ])
                    ->where('role_user.role_id', '=', 17)
                    ->where('users.client_check', '=', 'cc_bank')
                    ->where('users.archive', '!=', 'True')
                    ->get();

                $getCCTele = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->select([
                        'users.id as id',
                        'users.name as name'
                    ])
                    ->where('role_user.role_id', '=', 17)
                    ->where('users.client_check', '=', 'tat_selector')
                    ->where('users.archive', '!=', 'True')
                    ->get();

                return view('audit.audit-master', compact('timeStamp','javs', 'getCCBank', 'getCCTele'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getAuditReport()
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
            } elseif (Auth::user()->hasRole('Audit')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('audit.audit-report', compact('timeStamp'))->with(["page" => "audit-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getFundReport()
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
            } elseif (Auth::user()->hasRole('Audit')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('audit.audit-fund-report', compact('timeStamp'))->with(["page" => "audit-fund-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getCiExpenseReport()
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
            } elseif (Auth::user()->hasRole('Audit')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('audit.audit-ci-expense-report', compact('timeStamp'))->with(["page" => "audit-ci-expense-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function tableGetAuditReportTable(Request $request)
    {
        $audit = DB::table('endorsements')
            ->leftjoin('audit_incentives','audit_incentives.account_id','=','endorsements.id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->leftJoin('provinces', 'provinces.id', '=', 'municipalities.province_id')
            ->join('regions', 'regions.id', '=', 'provinces.region_id')
            ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
            ->select
            (
                [
                    'endorsements.id as id',
                    'endorsements.client_name as bank',
                    'endorsements.date_endorsed as date',
                    'endorsements.account_name as account',
                    'endorsements.address',
                    'municipalities.muni_name as city_muni',
                    'archipelagos.archipelago_name as achipelago',
                    'endorsements.type_of_request',
                    'endorsements.handled_by_dispatcher as dispatcher',
                    'endorsements.handled_by_credit_investigator as ci',
                    'endorsements.handled_by_account_officer as ao',
                    'endorsements.assigned_by_srao as srao',
                    'audit_incentives.account_incentives as incentives',
                    'audit_incentives.account_deduction as deduction',
                    'endorsements.acct_status as status',
                    'endorsements.ci_cert as ci_cert',
                    'endorsements.date_ci_visit as date_visit',
                    'endorsements.time_ci_visit as time_visit'

                ]
            )
            ->where('endorsements.date_endorsed', '>=', $request->min_date_endorsed.' 00:00:00')
            ->where('endorsements.date_endorsed', '<=', $request->max_date_endorsed.' 23:59:59');

        return DataTables::of($audit)
            ->editcolumn('tor_with_name', function($query)
            {
                if($query->type_of_request != 'PDRN')
                {
                    if($query->type_of_request == 'BVR')
                    {
                        $business_name = DB::table('businesses')
                            ->where('endorsement_id', '=', $query->id)
                            ->select('business_name')
                            ->get();

                        if(count($business_name) > 0)
                        {
                            return '<b>'.$query->type_of_request.'</b>' .'<br>' .$business_name[0]->business_name;
                        }
                        else
                        {
                            return '';
                        }

                    }
                    else
                    {
                        $employer_name = DB::table('employers')
                            ->where('endorsement_id', '=', $query->id)
                            ->select('employer_name')
                            ->get();

                        if(count($employer_name) > 0)
                        {
                            return '<b>'.$query->type_of_request.'</b>' .'<br>' .$employer_name[0]->employer_name;

                        }
                        else
                        {
                            return '';
                        }
                    }
                }
                else
                {
                    return '<b>'.$query->type_of_request.'</b>';
                }
            })
            ->rawColumns([
                'tor_with_name'
            ])
            ->make(true);
    }

    public function tableGetAuditReportTable_sao(Request $request)
    {
        $audit = DB::table('endorsements')
            ->join('timestamps','timestamps.endorsement_id','=','endorsements.id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->join('regions','regions.id','=','provinces.region_id')
            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.client_name',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.requestor_name',
                    'endorsements.account_name',
                    'endorsements.address',
                    'municipalities.muni_name as city_muni',
                    'endorsements.provinces',
                    'archipelagos.archipelago_name as archipelago_name',
                    'endorsements.type_of_request',
                    'endorsements.endorsement_status_external',
                    'endorsements.endorsement_status_internal_2',
                    'endorsements.verify_through',
                    'endorsements.handled_by_dispatcher',
                    'endorsements.assigned_by_srao',
                    'endorsements.handled_by_account_officer',
                    'endorsements.handled_by_credit_investigator',
                    'endorsements.date_dispatched',
                    'endorsements.time_dispatched',
                    'endorsements.date_srao_assigned',
                    'endorsements.time_srao_assigned',
                    'endorsements.date_ci_visit',
                    'endorsements.time_ci_visit',
                    'endorsements.date_ci_forwarded',
                    'endorsements.time_ci_forwarded',
                    'endorsements.date_forwarded_to_client',
                    'endorsements.time_forwarded_to_client',
                    'timestamps.time_dispatcher',
                    'timestamps.time_srao',
                    'timestamps.time_ci',
                    'timestamps.time_ao',
                    'endorsements.ci_cert',
                    'endorsements.acct_status',
                    'endorsements.endorsement_status_external',
                    'endorsements.endorsement_status_internal',
                ]
            )
            ->where('endorsements.date_endorsed', '>=', $request->min_date_endorsed.' 00:00:00')
            ->where('endorsements.date_endorsed', '<=', $request->max_date_endorsed.' 23:59:59');

        return DataTables::of($audit)
            ->make(true);
    }

    public function tableGetFundReportTable(Request $request)
    {
        $what_to_where = $request->search_option;
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;

        $fund_audit = DB::table('fund_requests')
            ->leftjoin('users as dispatcher_name', 'dispatcher_name.id', '=', 'fund_requests.dispatcher_id')
            ->leftjoin('users as sao_name', 'sao_name.id', '=', 'fund_requests.sao_id')
            ->leftjoin('users as manage_name', 'manage_name.id', '=', 'fund_requests.sao_id')
            ->leftjoin('users as ci_name_table', 'ci_name_table.id', '=', 'fund_requests.ci_id')
            ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
            ->join('users as uploader_name', 'uploader_name.id', '=', 'ci_fund_remittances.finance_sent')
            ->leftJoin('remittance', 'remittance.fund_id', '=', 'fund_requests.id')
            ->select([
                'fund_requests.id as id',
                'fund_requests.dispatcher_id as disp_id_get',
                'fund_requests.dispatcher_request_date as disp_date',
                'fund_requests.dispatcher_remarks as disp_remarks',
                'fund_requests.ci_id as ci_id',
                'fund_requests.sao_id as sao_id',
                'fund_requests.sao_remarks as sao_remarks',
                'fund_requests.sao_approved_date as sao_approved_date',
                'fund_requests.management_approved_date as management_approved_date',
                'fund_requests.management_remarks_approved as management_remarks_approved',
                'fund_requests.finance_id as finance_id',
                'fund_requests.finance_approved_date as finance_approved_date',
                'fund_requests.finance_remarks as finance_remarks',
                'fund_requests.type_of_fund_request as type_of',
                'fund_requests.sao_emergency_req_date_time as sao_req',
                'fund_requests.fund_amount as amount',
                'fund_requests.fund_original_amount as orig_amount',
                'fund_requests.delivered_date as delivered_date_time',
                'fund_requests.dispatcher_status as disp_status',
                'fund_requests.sao_status as sao_status',
                'fund_requests.finance_status as finance_status',
                'dispatcher_name.name as dispatch_name',
                'sao_name.name as sao_name',
                'manage_name.name as manage_name',
                'ci_fund_remittances.confirm_date_time as confirm_date',
                'uploader_name.name as uploader_name',
                'remittance.remittance_info as remittance_info',
                'remittance.branch_name as remittance_branch',
                'remittance.date_of_send as date_of_send',
                'ci_name_table.name as ci_name'
            ])
            ->where(function($query) use ($what_to_where, $min)
            {
                return $query->where($what_to_where, '>=', $min.' 00:00:00')
                    ->orwhere('fund_requests.sao_emergency_req_date_time', '>=', $min.' 00:00:00');
            })
//            ->where($what_to_where, '>=', $request->min_date_endorsed.' 00:00:00')
//            ->where($what_to_where, '<=', $request->max_date_endorsed.' 23:59:59')
            ->where(function($query) use ($what_to_where, $max)
            {
                return $query->where($what_to_where, '<=', $max.' 23:59:59')
                    ->orwhere('fund_requests.sao_emergency_req_date_time', '<=', $max.' 23:59:59');
            });

        return DataTables::of($fund_audit)
            ->editColumn('ci_id', function ($query)
            {
                return User::find($query->ci_id)->name;
            })
            ->editColumn('id_names', function ($query)
            {
                $get_account_name = DB::table('fund_request_endorsements')
                    ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
                    ->select('endorsements.account_name as names')
                    ->where('fund_id',$query->id)
                    ->where('type','!=','Cancelled')
                    ->get();
                $get_names = '';
                foreach ($get_account_name as $account_name)
                {
                    $get_names .= ''.$account_name->names.' / ';
                }
                return $get_names;
            })
            ->editColumn('id_count', function ($query)
            {
                $get_account_count = DB::table('fund_request_endorsements')
                    ->where('fund_id',$query->id)
                    ->where('type','!=','Cancelled')
                    ->get()
                    ->count();

                return $get_account_count;
            })
            ->editColumn('remittance_or_atm', function ($query)
            {
                $get_status_test = DB::table('ci_fund_remittances')
                    ->where('fund_id',$query->id)
                    ->select([
                        'remittance_id',
                        'ci_atm_fund_id'
                    ])
                    ->get();

                if(count($get_status_test))
                {
                    if($get_status_test[0]->remittance_id == 0)
                    {
                        return 'ATM';
                    }
                    else
                    {
                        return 'REMITTANCE';
                    }
                }
            })

//            ->editColumn('sao_id', function ($query)
//            {
//                if($query->sao_id == null)
//                {
//                    return '';
//                }
//                else
//                {
//                    return User::find($query->sao_id)->name;
//                }
//            })
//            ->editColumn('finance_id', function ($query)
//            {
//                if($query->finance_id == null)
//                {
//                    return '';
//                }
//                else
//                {
//                    return User::find($query->finance_id)->name;
//                }
//            })
//            ->editColumn('finance_sent_id', function ($query)
//            {
//                if($query->finance_sent_id == null)
//                {
//                    return '';
//                }
//                else
//                {
//                    return User::find($query->finance_sent_id)->name;
//                }
//            })
//            ->editColumn('fund_id_search_type', function ($query)
//            {
//                $toreturn = '';
//
//                if($query->remit_id != 0)
//                {
//                    $toreturn .= 'REMITTANCE';
//                }
//                else if($query->ci_atm_fund_id != 0)
//                {
//                    $toreturn .= 'ATM';
//                }
//
//                return $toreturn;
//            })
//            ->editColumn('fund_get_amount', function ($query)
//            {
//                $toreturn = '';
//
//                if($query->remit_id != 0)
//                {//remittance
//                    $get_amount_remittance = DB::table('remittance')
//                        ->select('amount')
//                        ->where('fund_id',$query->id)
//                        ->get()[0]->amount;
//
//                    $toreturn = base64_decode($get_amount_remittance);
//
//                }
//                else if($query->ci_atm_fund_id != 0)
//                {
//                    $get_amount_atm = DB::table('ci_atm_fund')
//                        ->select('amount')
//                        ->where('fund_id',$query->id)
//                        ->get()[0]->amount;
//
//                    $toreturn = $get_amount_atm ;
//                }
//
//                return $toreturn;
//            })
//            ->editColumn('fund_get_atm_infos', function ($query)
//            {
//                if($query->ci_atm_fund_id != 0)
//                {
//                    $get_name_atm = DB::table('ci_atm_fund')
//                        ->join('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
//                        ->select('ci_atms.bank_name as b_name')
//                        ->where('ci_atm_fund.fund_id',$query->id)
//                        ->get();
//
//                    if(count($get_name_atm) == 0)
//                    {
//                        return '';
//                    }
//                    else
//                    {
//                        return $get_name_atm[0]->b_name ;
//                    }
//                }
//                else
//                {
//                    return '';
//                }
//            })
//            ->editColumn('fund_get_remittance_receiver_infos', function ($query)
//            {
//                if($query->remit_id != 0)
//                {
//                    $get_remittance_receiver = DB::table('remittance')
//                        ->select('receiver')
//                        ->where('fund_id',$query->id)
//                        ->get();
//
//                    if(count($get_remittance_receiver) == 0)
//                    {
//                        return '';
//                    }
//                    else
//                    {
//                        return $get_remittance_receiver[0]->receiver ;
//                    }
//                }
//                else
//                {
//                    return '';
//                }
//            })
//            ->editColumn('fund_get_remittance_code_infos', function ($query)
//            {
//                if($query->remit_id != 0)
//                {
//                    $get_remittance_code = DB::table('remittance')
//                        ->select('code')
//                        ->where('fund_id',$query->id)
//                        ->get();
//
//                    if(count($get_remittance_code) == 0)
//                    {
//                        return '';
//                    }
//                    else
//                    {
//                        return $get_remittance_code[0]->code ;
//                    }
//                }
//                else
//                {
//                    return '';
//                }
//            })
//            ->editColumn('fund_get_remittance_sender_infos', function ($query)
//            {
//                if($query->remit_id != 0)
//                {
//                    $get_remittance_sender = DB::table('remittance')
//                        ->select('sender')
//                        ->where('fund_id',$query->id)
//                        ->get();
//
//                    if(count($get_remittance_sender) == 0)
//                    {
//                        return '';
//                    }
//                    else
//                    {
//                        return $get_remittance_sender[0]->sender ;
//                    }
//                }
//                else
//                {
//                    return '';
//                }
//            })
//            ->editColumn('fund_get_send_remarks', function ($query)
//            {
//                $toreturn = '';
//
//                if($query->remit_id != 0)
//                {//remittance
//                    $get_remarks_remittance = DB::table('remittance')
//                        ->select('remarks')
//                        ->where('fund_id',$query->id)
//                        ->get()[0]->remarks;
//
//                    return $get_remarks_remittance;
//
//                }
//                else if($query->ci_atm_fund_id != 0)
//                {
//                    $get_remarks_atm = DB::table('ci_atm_fund')
//                        ->select('remarks')
//                        ->where('fund_id',$query->id)
//                        ->get()[0]->remarks;
//
//                    return $get_remarks_atm;
//                }
//            })
            ->editColumn('fund_status', function ($query)
            {
                if($query->disp_status == 'ON-PROCESS')
                {
                    $toret='';

                    if($query->confirm_date != '0000-00-00 00:00:00' && $query->confirm_date != null)
                    {
                        $toret = '<a href="" class="btn btn-xs btn-block btn-success" name="" id="btnViewFullInfo" disabled="disabled">COMPLETED</a>' .
                            '<a href="" class="btn btn-xs btn-block btn-info" name="'.$query->id.'" id="btn_view_logs_fund" data-toggle="modal" data-target="#modal-view-fund-logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                    }
                    else
                    {
                        $toret = '<a href="" class="btn btn-xs btn-block btn-warning" name="" id="btnViewFullInfo" disabled="disabled">ON PROCESS</a>' .
                            '<a href="" class="btn btn-xs btn-block btn-info" name="'.$query->id.'" id="btn_view_logs_fund" data-toggle="modal" data-target="#modal-view-fund-logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                    }

                    return $toret;
                }
                else if($query->sao_status == 'DISAPPROVED' && $query->finance_status == '')
                {
                    return '<a href="" class="btn btn-xs btn-block btn-danger" name="" id="btnViewFullInfo" disabled="disabled">DISAPPROVED BY SAO</a>' .
                        '<a href="" class="btn btn-xs btn-block btn-info" name="'.$query->id.'" id="btn_view_logs_fund" data-toggle="modal" data-target="#modal-view-fund-logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                }
                else if($query->sao_status == 'APPROVED' && $query->finance_status == 'DISAPPROVED')
                {
                    return '<a href="" class="btn btn-xs btn-block btn-danger" name="" id="btnViewFullInfo" disabled="disabled">DISAPPROVED BY FINANCE</a>' .
                        '<a href="" class="btn btn-xs btn-block btn-info" name="'.$query->id.'" id="btn_view_logs_fund" data-toggle="modal" data-target="#modal-view-fund-logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';

                }else if($query->disp_status == 'CANCELLED')
                {
                    return '<a href="" class="btn btn-xs btn-block btn-danger" name="" id="btnViewFullInfo" disabled="disabled">CANCELLED BY DISPATCHER</a>' .
                        '<a href="" class="btn btn-xs btn-block btn-info" name="'.$query->id.'" id="btn_view_logs_fund" data-toggle="modal" data-target="#modal-view-fund-logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';

                }
            })
            ->rawColumns([
                'ci_id',
                'id_names',
                'id_count',
                'remittance_or_atm',
//                'sao_id',
//                'finance_id',
//                'finance_sent_id',
//                'fund_id_search_type',
//                'fund_get_amount',
//                'fund_get_atm_infos',
//                'fund_get_remittance_receiver_infos',
//                'fund_get_remittance_code_infos',
//                'fund_get_remittance_sender_infos',
//                'fund_get_send_remarks',
//                'fund_get_confirm',
                'fund_status'
            ])
            ->make(true);
    }

    public function tableGetCiExpensesReportTable(Request $request)
    {
        $ci_expenses_table = DB::table('ci_expenses')
            ->join('endorsements','endorsements.id','=','ci_expenses.endorsement_id')
            ->join('users','users.id','=','ci_expenses.ci_id')
//            ->leftjoin('expenses','expenses.ci_expenses_id','=','ci_expenses.id')
            ->select([
                'endorsements.account_name as account_name',
                'endorsements.id as endo_id',
                'endorsements.id as endo_id_main',
                'users.name as ci_name',
                'users.id as ci_id',
//                'expenses.label as label',
//                'expenses.amount as amount',
//                'expenses.attachment as attachment',
//                'expenses.type as type',
                'ci_expenses.shell_include as shell',
                'ci_expenses.date_time_modified as date_time',
                'ci_expenses.note as note',
                'ci_expenses.id as id'
            ]);
//            ->where('ci_expenses.ci_id',Auth::user()->id);

        return DataTables::of($ci_expenses_table)
            ->editColumn('endo_id', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.subject_id')
                    ->select([
                        'asso_expenses.coob_id as endo_id',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->endo_id.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->endo_id.'/';

                }

                return rtrim($string_to_add,'/ ');
            })
            ->editColumn('account_name', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.coob_id')
                    ->select([
                        'endorsements.account_name as account_name',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->account_name.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->account_name.'/';

                }

                return rtrim($string_to_add,'/ ');
            })
            ->editColumn('declared', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.label as label',
                        'expenses.amount as amount',
                        'expenses.attachment as attachment',
                        'expenses.type as type',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = '';
                $count = 1;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $count.'. '.$all_label->label.'/'.$all_label->amount.'/'.$all_label->type.'.<br> ';
                    $count++;
                }

                return $string_to_add;
            })
            ->editColumn('amount', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.amount as amount',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = 0;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add = ($string_to_add + $all_label->amount);
                }

                return $string_to_add;
            })
            ->rawColumns(['declared','endo_id,account_name','amount'])
            ->make(true);
    }

    public function tableGetCiExpensesReportTable_sort(Request $request)
    {
        $ci_expenses_table = DB::table('ci_expenses')
            ->join('endorsements','endorsements.id','=','ci_expenses.endorsement_id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->join('users','users.id','=','ci_expenses.ci_id')
//            ->leftjoin('expenses','expenses.ci_expenses_id','=','ci_expenses.id')
            ->select([
                'endorsements.account_name as account_name',
                'endorsements.id as endo_id',
                'endorsements.id as endo_id_main',
                'endorsements.provinces',
                'municipalities.muni_name',
                'users.name as ci_name',
                'users.id as ci_id',
//                'expenses.label as label',
//                'expenses.amount as amount',
//                'expenses.attachment as attachment',
//                'expenses.type as type',
                'ci_expenses.shell_include as shell',
                'ci_expenses.date_time_modified as date_time',
                'ci_expenses.note as note',
                'ci_expenses.id as id'
            ]);
//            ->where('ci_expenses.ci_id',Auth::user()->id);

        return DataTables::of($ci_expenses_table)
            ->editColumn('endo_id', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.subject_id')
                    ->select([
                        'asso_expenses.coob_id as endo_id',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->endo_id.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->endo_id.'/';

                }

                return rtrim($string_to_add,'/ ');

            })
            ->editColumn('account_name', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.coob_id')
                    ->select([
                        'endorsements.account_name as account_name',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->account_name.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->account_name.'/';

                }

                return rtrim($string_to_add,'/ ');

            })
            ->editColumn('declared', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.label as label',
                        'expenses.amount as amount',
                        'expenses.attachment as attachment',
                        'expenses.type as type',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = '';
                $count = 1;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $count.'. '.$all_label->label.'/'.$all_label->amount.'/'.$all_label->type.'.<br> ';
                    $count++;
                }

                return $string_to_add;
            })
            ->editColumn('amount', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.amount as amount',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = 0;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add = ($string_to_add + $all_label->amount);
                }

                return $string_to_add;
            })
            ->rawColumns(['declared','endo_id,account_name','amount'])
            ->make(true);
    }

    public function auditDownloadReport(Request $request)
    {
//        if($type == 'dataforwarded')
//        {
//            if ($certChecker->ci_cert == "NC")
//            {
//                if (Storage::disk('local')->has('account/' . $paths))
//                {
//                    Zip::create(public_path() . '/account_zip/' . $paths . '.zip', true)
//                        ->add(public_path('/account/' . $paths), true)
//                        ->setPath(public_path('/account_zip'))
//                        ->close();
//                    //AUDIT START HERE
//                    $auditRemove = new AuditQueries();
//                    $auditRemove->auditDownload($request);
//                    //END OF AUDIT
//                }
//                else
//                {
//                    return response()->json('errorDownload');
//                }
//            }
////            File::deleteDirectory(public_path('account/'.$request->id));
//
//                return response()->json("/account_zip/" . $paths . ".zip");
//
//        }
//        else if($type == 'finish')
//        {
//            if($certChecker->ci_cert=='NC')
//            {
//                if(File::exists(public_path('/account_report/'.$paths.".zip")))
//                {
//                    //AUDIT START HERE
//                    $auditRemove = new AuditQueries();
//                    $auditRemove->auditDownload($request);
//                    //END OF AUDIT
//
//                    return response()->json("/account_report/" . $paths . ".zip");
//                }
//                else
//                {
//                    return response()->json('errorDownload');
//                }
//            }
//        }
//        else if($type == 'finish_certified')
//        {
//            if($certChecker->ci_cert=='C')
//            {
//                //AUDIT START HERE
//                $auditRemove = new AuditQueries();
//                $auditRemove->auditDownload($request);
//                //END OF AUDIT
//
//                if (Storage::disk('local')->has('account_client/' . $paths)) {
//
//                    Zip::create(public_path() . '/account_zip/' . $paths . '.zip', true)
//                        ->add(public_path('/account_client/' . $paths), true)
//                        ->setPath(public_path('/account_zip'))
//                        ->close();
//                };
//                return response()->json("/account_zip/" . $paths . ".zip");
//            }
//        }
//        else
//        {
//            return response()->json('errorDownload');
//
//        }

        if(Auth::user()->hasRole('Audit'))
        {
            $path_link = new DownloadZipLogic();
            $paths = $path_link->path_link($request->acctID);
            $type = $request->type;

            $certChecker = DB::table('endorsements')
                ->select(['ci_cert'])
                ->where('id',$request->acctID)
                ->first();


            if($type == 'dataforwarded')
            {
                if ($certChecker->ci_cert == "NC")
                {
                    if (File::isDirectory(storage_path('account/' . $paths)))
                    {
                        Zip::create(storage_path('account_zip/' . $paths . '.zip'), true)
                            ->add(storage_path('account/' . $paths), true)
                            ->setPath(storage_path('account_zip'))
                            ->close();
                        //AUDIT START HERE
                        $auditRemove = new AuditQueries();
                        $auditRemove->auditDownload($request);
                        //END OF AUDIT
                        return response()->download(storage_path("account_zip/" . $paths . ".zip"));
                    }
                    else {
                        echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';

                    }
                }
            }
            else if($type == 'finish')
            {
                if($certChecker->ci_cert=='NC')
                {
                    if(file_exists(storage_path('/account_report/'.$paths.'.zip')))
                    {
                        //AUDIT START HERE
                        $auditRemove = new AuditQueries();
                        $auditRemove->auditDownload($request);
                        //END OF AUDIT

                        return response()->download(storage_path("/account_report/" . $paths . ".zip"));
                    }
                    else
                    {
                        echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                    }
                }
            }
            else if($type == 'finish_certified')
            {
                if($certChecker->ci_cert=='C')
                {
                    //AUDIT START HERE
                    $auditRemove = new AuditQueries();
                    $auditRemove->auditDownload($request);
                    //END OF AUDIT

                    if (File::isDirectory(storage_path('account_client/' . $paths)))
                    {
                        Zip::create(storage_path('account_zip/' . $paths . '.zip'), true)
                            ->add(storage_path('account_client/' . $paths), true)
                            ->setPath(storage_path('account_zip'))
                            ->close();
                        return response()->download(storage_path("account_zip/" . $paths . ".zip"));
                    }
                    else {
                        echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                    }
                }
            }
            else
            {
                echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';

            }
        }
        else
        {
            return 'oooppss......';
        }

    }

    public function audit_get_fund_logs(Request $request)
    {
        $get_table_fund = DB::table('audits_fund')
            ->select([
                'name',
                'position',
                'branch',
                'activities',
                'date_occured',
                'time_occured'
            ])
            ->where('fund_id',$request->fund_id)
            ->get();

        return response()->json($get_table_fund);
    }

    public function audit_get_expenses_logs(Request $request)
    {
        $get_logs_expenses = DB::table('ci_logs_expenses')
            ->select([
                'user_id',
                'activity',
                'datetime',
            ])
            ->where('activity_id',$request->endo_id)
            ->get();

//        $getuser = DB::User
        $ciName = User::find($request->ci_id);

        return response()->json([$get_logs_expenses,$ciName->name,$ciName->roles->first()->name]);
    }

    public function audit_download_receipt(Request $request)
    {
        $ci = $request->ci_id;
        $endo = $request->endo_id;

        $name = User::find($ci)->name;

        if(File::exists(public_path('/ci_expenses/'.$ci.'/'.$endo)))
        {
            File::makeDirectory(public_path('ci_expenses/'.$ci.'/fordeletion'));

            Zip::create(public_path().'/ci_expenses/'.$ci.'/fordeletion/'. $name.'-'.$endo.'.zip', true)
                ->add(public_path('/ci_expenses/'.$ci.'/'.$endo), true)
                ->setPath(public_path('/ci_expenses/'.$ci.'/fordeletion'))
                ->close();

            return response()->json('/ci_expenses/'.$ci.'/fordeletion/' . $name.'-'.$endo. '.zip');
        }
        else
        {
            return response()->json('no uploaded');
        }

    }

    public function audit_after_download_delete_expense_zip(Request $request)
    {
        $ci = $request->ci_id;
//        $endo = $request->endo_id;
//        $name = User::find($ci)->name;

        File::deleteDirectory(public_path('/ci_expenses/'.$ci.'/fordeletion'));

        return 'success';
    }

    public function audit_get_edo_acc_details(Request $request)
    {
        $audit = DB::table('endorsements')
            ->leftjoin('timestamps','timestamps.endorsement_id','=','endorsements.id')
            ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->leftjoin('audit_incentives', 'audit_incentives.account_id', '=', 'endorsements.id')
            ->leftjoin('businesses', 'businesses.endorsement_id', '=', 'endorsements.id')
            ->leftjoin('employers', 'employers.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.client_name',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.requestor_name',
                    'endorsements.account_name',
                    'endorsements.address',
                    'municipalities.muni_name as city_muni',
                    'endorsements.provinces',
                    'endorsements.type_of_request',
                    'endorsements.endorsement_status_external',
                    'endorsements.endorsement_status_internal_2',
                    'endorsements.verify_through',
                    'endorsements.handled_by_dispatcher',
                    'endorsements.assigned_by_srao',
                    'endorsements.handled_by_account_officer',
                    'endorsements.handled_by_credit_investigator',
                    'endorsements.date_dispatched',
                    'endorsements.time_dispatched',
                    'endorsements.date_srao_assigned',
                    'endorsements.time_srao_assigned',
                    'endorsements.date_ci_visit',
                    'endorsements.time_ci_visit',
                    'endorsements.date_ci_forwarded',
                    'endorsements.time_ci_forwarded',
                    'endorsements.date_forwarded_to_client',
                    'endorsements.time_forwarded_to_client',
                    'timestamps.time_dispatcher',
                    'timestamps.time_srao',
                    'timestamps.time_ci',
                    'timestamps.time_ao',
                    'endorsements.ci_cert',
                    'endorsements.acct_status',
                    'endorsements.endorsement_status_external',
                    'endorsements.endorsement_status_internal',
                    'audit_incentives.account_incentives',
                    'audit_incentives.account_deduction',
                    'endorsements.link_path',
                    'businesses.business_name',
                    'employers.employer_name'
                ]
            )
            ->where('endorsements.id', $request->endorse_id)
            ->get();


        $date = Carbon::createFromFormat('Y-m-d H:i:s', $audit[0]->date_due.' '.$audit[0]->time_due);
        $date->subHours(2);
        $splitDateTime = explode(" ",$date);
        $dates = $splitDateTime[0];
        $time = $splitDateTime[1];
        $cidue = $dates . ' ' . $time;

        return response()->json([$audit, $cidue]);
    }

    public function audit_update_incent_deduct(Request $request)
    {
        $getId = DB::table('audit_incentives')
            ->where('account_id', $request->id)
            ->first();

        if(is_null($getId))
        {
            DB::table('audit_incentives')
                ->insert
                ([
                    'account_id' => $request->id,
                    'account_incentives' => $request->auditIncent,
                    'account_deduction' => $request->auditDeduc
                ]);

            $getData = DB::table('audit_incentives')
                ->select('account_incentives', 'account_deduction')
                ->where('account_id',  $request->id)
                ->get();

            return response()->json($getData);
        }
        else
        {
            DB::table('audit_incentives')
                ->where('account_id', $request->id)
                ->update
                ([
                    'account_incentives' => $request->auditIncent,
                    'account_deduction' => $request->auditDeduc
                ]);

            $getData = DB::table('audit_incentives')
                ->select('account_incentives', 'account_deduction')
                ->where('account_id',  $request->id)
                ->get();

            return response()->json($getData);
        }
    }
    public function audit_dl_ci_report(Request $request)
    {
        $id = base64_decode($request->id);
        $getLink = DB::table('endorsements')
            ->select('link_path')
            ->where('id', $id)
            ->get();

        $link = '/account/' . $getLink[0]->link_path . '/' . $request->name;


        if(Auth::user()->hasRole('Audit'))
        {
            return response()->download(storage_path($link));
        }
        else
        {
            return response('');
        }
    }
    public function audit_check_total_acc()
    {
        $getCountAcc = DB::table('endorsements')
            ->count();

        $getCountIncent = DB::table('audit_incentives')
            ->select('account_incentives')
            ->get();

        return response()->json([$getCountAcc, $getCountIncent]);
    }
    
    public function audit_get_files_ci(Request $request)
    {
        $trimnames = [];
        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($request->id);

        $getInfo = DB::table('endorsements')
            ->where('id', $request->id)
            ->select('ci_cert')
            ->get();

        if(count($getInfo) > 0)
        {
            if($getInfo[0]->ci_cert  == 'C')
            {
                foreach(glob(storage_path('/account_client/'.$paths).'/*.*') as $filename)
                {
                    $trimnames[] = str_replace(storage_path('/account_client/'.$paths.'/'), '', $filename);
                }

                $getName = DB::table('endorsements')
                    ->select('account_name')
                    ->where('id', $request->id)
                    ->get();
            }
            else
            {
                foreach(glob(storage_path('/account/'.$paths).'/*.*') as $filename)
                {
                    $trimnames[] = str_replace(storage_path('/account/'.$paths.'/'), '', $filename);
                }

                $getName = DB::table('endorsements')
                    ->select('account_name')
                    ->where('id', $request->id)
                    ->get();
            }


            return response()->json([$trimnames, $getName[0]->account_name]);
        }
        else
        {
            return abort(404);
        }


    }
    
    public function audit_ao_file_dl(Request $request)
    {
        $id = base64_decode($request->id);
        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($id);
        $dlPath = $paths . '.zip';

        if(Auth::user()->hasRole('Audit'))
        {
            if(file_exists(storage_path('/account_report/'.$paths.'.zip')))
            {
                return response()->download(storage_path("/account_report/" . $paths . ".zip"));
            }
            else
            {
                echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
            }
        }
        else
        {
            return response('');
        }
    }

//    public function audit_get_liq_img(Request $request)
//    {
////        $getPaths = DB::table('fund_request_liquidate')
////            ->join('endorsements', 'endorsements.id', 'fund_request_liquidate.endorse_id')
////            ->where('fund_id', $request->id)
//////            ->where('receipt_attachment', '!=', '')
////            ->select
////            ([
////                'fund_request_liquidate.id as id',
////                'fund_request_liquidate.receipt_attachment as receipt_attachment',
////                'fund_request_liquidate.indiv_remarks as indiv_remarks',
////                'endorsements.account_name as name'
////            ])
////            ->get();
//
//        $getPaths = DB::table('endorsements')
//            ->join('fund_request_liquidate', 'fund_request_liquidate.endorse_id', '=', 'endorsements.id')
//            ->where('endorsements.id', $request->id)
//            ->select
//            ([
//                'fund_request_liquidate.id as id',
//                'fund_request_liquidate.receipt_attachment as receipt_attachment',
//                'fund_request_liquidate.indiv_remarks as indiv_remarks',
//                'fund_request_liquidate.fund_id as fund_id',
//                'endorsements.account_name as name'
//            ])
//            ->get();
//
//
//
//        if(count($getPaths) != 0)
//        {
//            $getRem = DB::table('fund_requests')
//                ->where('id', $getPaths[0]->fund_id)
//                ->select('ci_liq_rem', 'fund_amount')
//                ->get();
//
//
//            $arrayImg = [];
//            $arrayName = [];
//            $arrayPath = [];
//
//            $counti = 0;
//
//            for($i = 0; $i < count($getPaths) ; $i++)
//            {
//                array_push($arrayImg, base64_encode($getPaths[$i]->id));
//                $arrayName[$i] = [];
//
//                if($getPaths[$i]->receipt_attachment == '')
//                {
//                    $arrayName[$i][$counti] = '';
//                    $arrayName[$i][$counti + 1] = $getPaths[$i]->indiv_remarks;
//                }
//                else
//                {
//                    $name = explode("/", $getPaths[$i]->receipt_attachment);
//
//                    $arrayName[$i][$counti] = $name[3];
//                    $arrayName[$i][$counti + 1] = $getPaths[$i]->indiv_remarks;
//                }
//                $arrayName[$i][$counti + 2] = $getPaths[$i]->name;
//
//
//                array_push($arrayPath, $getPaths[$i]->receipt_attachment);
//            }
//
//            if(count($getRem) != 0)
//            {
//                return response()->json([$arrayImg, $arrayName, $getRem[0]->ci_liq_rem, $arrayPath, $getRem[0]->fund_amount]);
//            }
//        }
//        else
//        {
//            return 0;
//        }
//    }

    public function audit_get_liq_img(Request $request)
    {
        $getPaths = DB::table('fund_request_liquidate')
            ->join('endorsements', 'endorsements.id', 'fund_request_liquidate.endorse_id')
            ->where('fund_id', $request->id)
//            ->where('receipt_attachment', '!=', '')
            ->select
            ([
                'fund_request_liquidate.id as id',
                'fund_request_liquidate.receipt_attachment as receipt_attachment',
                'fund_request_liquidate.indiv_remarks as indiv_remarks',
                'fund_request_liquidate.liquidate_amount as liquidate_amount',
                'fund_request_liquidate.audit_liquidate_amount as audit_liquidate_amount',
                'endorsements.account_name as name'
            ])
            ->get();

        if(count($getPaths) != 0)
        {
            $getRem = DB::table('fund_requests')
                ->where('id', $request->id)
                ->select('ci_liq_rem', 'liquidated_amount', 'unliquidated_amount', 'audit_review_status')
                ->get();

            if(count($getRem) != 0)
            {
                $total_amount = (int)$getRem[0]->liquidated_amount + (int)$getRem[0]->unliquidated_amount;
            }
            else
            {
                $total_amount = 0;
            }


            $arrayId = [];
            $arrayImg = [];
            $arrayName = [];
            $arrayPath = [];
            $arrayAmount = [];

            $counti = 0;

            for($i = 0; $i < count($getPaths) ; $i++)
            {
                array_push($arrayImg, base64_encode($getPaths[$i]->id));
                $arrayName[$i] = [];

                if($getPaths[$i]->receipt_attachment == '')
                {
                    $arrayName[$i][$counti] = '';
                    $arrayName[$i][$counti + 1] = $getPaths[$i]->indiv_remarks;
                }
                else
                {
                    $name = explode("/", $getPaths[$i]->receipt_attachment);

                    $arrayName[$i][$counti] = $name[3];
                    $arrayName[$i][$counti + 1] = $getPaths[$i]->indiv_remarks;
                }
                $arrayName[$i][$counti + 2] = $getPaths[$i]->name;

                if($getRem[0]->audit_review_status != 1)
                {
                    array_push($arrayAmount, base64_encode($getPaths[$i]->liquidate_amount));
                }
                else
                {
                    array_push($arrayAmount, base64_encode($getPaths[$i]->audit_liquidate_amount));
                }

                array_push($arrayPath, $getPaths[$i]->receipt_attachment);

                array_push($arrayId, $getPaths[$i]->id);
            }

            return response()->json([$arrayImg, $arrayName, $getRem[0]->ci_liq_rem, $arrayPath, $total_amount, $arrayAmount, $arrayId]);
        }
        else
        {
            return 0;
        }
    }

    public function audit_liquidation_checking(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $sms = new SmsNotification();
        $fundIdArray = $request->fundIdArray;
        $newAmountArray = $request->newAmountArray;
        $remarks = strtoupper($removeScript->scripttrim($request->remarks));
        $i = 0;
        $total_amount = 0;
        $newLiqAmount = 0;
        $newUnLiqAmount = 0;
        $forRemarks = '';
        $oldLiqAmount = 0;

        $check_if_already_have = DB::table('audit_reviewed_ci_liquidation_remarks')
            ->where('fund_id', $request->fund_id)
            ->get();

        $getciId = DB::table('users')
            ->where('name', $request->ci_name)
            ->select('id')
            ->get();

        $getOrig = DB::table('fund_requests')
            ->where('id', $request->fund_id)
            ->select('ci_liq_rem', 'liquidated_amount', 'unliquidated_amount', 'audit_review_status', 'fund_original_amount')
            ->get();

        if(count($getOrig) != 0)
        {
            $total_amount = (int)$getOrig[0]->liquidated_amount + (int)$getOrig[0]->unliquidated_amount;
        }
        else
        {
            $total_amount = 0;
        }

        if(count($newAmountArray) > 1)
        {
            $newLiqAmount = array_sum($newAmountArray);
        }
        else
        {
            $newLiqAmount = $newAmountArray[0];
        }

        $newUnLiqAmount = $total_amount - $newLiqAmount;


        for($i = 0; $i < count($fundIdArray); $i++)
        {
            DB::table('fund_request_liquidate')
                ->where('id', $fundIdArray[$i])
                ->update([
                    'audit_liquidate_amount' => $newAmountArray[$i],
                    'updated_at' => Carbon::now('Asia/Manila'),
                ]);
        }

        if($getOrig[0]->liquidated_amount == $newLiqAmount)
        {
            if($remarks != '')
            {
                $forRemarks = 'No changes made with a remarks: ' . $remarks;
            }
            else
            {
                $forRemarks = 'No changes made.';
            }
        }
        else
        {
            $forRemarks = Auth::user()->name . ' Modified liquidated amount from ' . $total_amount . ' to ' . $newLiqAmount . ' with a remarks: ' .$remarks ;
        }

        if(count($check_if_already_have) == 0)
        {
            DB::table('fund_requests')
                ->where('id', $request->fund_id)
                ->update([
                    'unliquidated_amount' => $newUnLiqAmount,
                    'liquidated_amount' => $newLiqAmount,
                    'audit_remarks' => $remarks,
                    'audit_review_status' => 1
                ]);

            DB::table('audit_reviewed_ci_liquidation_remarks')
                ->insert([
                    'fund_id' => $request->fund_id,
                    'users_id' => Auth::user()->id,
                    'audit_remarks' => $remarks,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'activity_id' => $request->fund_id,
                    'activity' => $forRemarks,
                    'type' => 'ci_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

            $sms->AuditFinanceNotifToCI($request, $remarks, base64_decode($getOrig[0]->fund_original_amount));

            return 'Liquidation successfully reviewed';
        }
        else
        {
            DB::table('fund_requests')
                ->where('id', $request->fund_id)
                ->update([
                    'unliquidated_amount' => $newUnLiqAmount,
                    'liquidated_amount' => $newLiqAmount,
                    'audit_remarks' => $remarks
                ]);


            DB::table('audit_reviewed_ci_liquidation_remarks')
                ->where('fund_id', $request->fund_id)
                ->update([
                    'audit_remarks' => $remarks,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'activity_id' => $request->fund_id,
                    'activity' => $forRemarks,
                    'type' => 'ci_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

            $sms->AuditFinanceNotifToCI($request, $remarks, base64_decode($getOrig[0]->fund_original_amount));

            return 'Liquidation successfully updated';
        }
    }

    public function audit_ci_fund_request_table_fa()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
            // ->join('municipalities', 'municipalities.id', '=', 'ci_id.branch')
            ->join('provinces', 'provinces.id', '=', 'ci_id.branch')
            ->join('regions', 'regions.id', '=', 'provinces.region_id')
            ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
            ->join('fund_request_endorsements','fund_request_endorsements.fund_id','=','fund_requests.id')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
            ->select
            ([
                'fund_requests.id as id',
                // 'ci_id.name as name_ci',
                \DB::raw("UPPER(ci_id.name) as name_ci"),
                'sao_id.name as name_sao',
                'fund_requests.fund_amount as amount',
                'fund_requests.dispatcher_remarks as dispatcher_remarks',
                'fund_requests.sao_remarks as sao_remarks',
                'fund_requests.finance_remarks as finance_remarks',
                'fund_requests.date_time_remarks as date_time_remarks',
                'fund_requests.dispatcher_request_date as dispatcher_request_date',
                'fund_requests.sao_approved_date as sao_approved_date',
                'fund_requests.finance_approved_date as finance_approved_date',
                'fund_requests.delivered_date as delivered_date',
                'fund_requests.type_of_fund_request as tor',
                'fund_requests.ci_id as ci_id',
                'fund_requests.approved_incident_remarks as incident',
                'fund_requests.approved_request_done as done',
                'fund_requests.liquidated_amount as liq',
                'fund_requests.unliquidated_amount as unliq',
                'fund_requests.audit_remarks as audit_remarks',
                'fund_requests.sao_emergency_req_date_time as sao_date',
                'archipelagos.archipelago_name as archi',
                'manage_approved_id.name as manage_name',
                'fund_requests.management_remarks_approved as rem_manage',
                'endorsements.address as address_for_search'
            ])
            ->groupBy('fund_request_endorsements.fund_id')
            //            ->where('fund_requests.finance_id',Auth::user()->id)
            ->where('fund_requests.sao_status','APPROVED')
            ->where(function ($query)
            {
                return $query ->orWhere('fund_requests.approved_request_done', '=' , 'Done')
                    ->orWhere('fund_requests.approved_request_done', '=' , 'Assigned')
                    ->orWhere('fund_requests.approved_request_done', '=' , 'New');
            })
            ->where(function ($query)
            {
                return $query ->orWhere('fund_requests.success_hold_cancel', '')
                    ->orWhere('fund_requests.success_hold_cancel', 'Override');
            });



        return DataTables::of($b)
            ->make(true);
    }

    public function audit_get_audit_remarks(Request $request)
    {
        $getAccountInfo = DB::table('users')
            ->join('ci_logs_expenses', 'ci_logs_expenses.user_id', '=', 'users.id')
            ->where('ci_logs_expenses.activity_id', $request->id)
            ->select([
                'ci_logs_expenses.activity as activity',
                'ci_logs_expenses.datetime as date_time',
                'users.name as name'
            ])
            ->get();

        return response()->json([$getAccountInfo]);
    }

    public function audit_get_oims_bank_id_list()
    {
        $get_id = DB::table('endorsements')
            ->select('id')
            ->orderBy('id','desc')
            ->get();

        return response()->json($get_id);
    }

    public function audit_get_oims_bank_info(Request $request)
    {

        $get_info = DB::table('endorsements')
            ->leftJoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->leftJoin('businesses', 'businesses.endorsement_id', '=', 'endorsements.id')
            ->leftJoin('employers', 'employers.endorsement_id', '=', 'endorsements.id')
            ->select([
                'endorsements.address as address',
                'municipalities.muni_name as muni',
                'endorsements.provinces as provinces',
                'endorsements.account_name as account_name',
                'endorsements.client_name as client_name',
                'endorsements.type_of_request as tor',
                'endorsements.date_endorsed as date_endorsed',
                'endorsements.date_forwarded_to_client as submission_date',
                'endorsements.endorsement_status_internal_2 as internal_status',
                'endorsements.endorsement_status_external as external_status',
                'endorsements.client_remarks as remarks',
                'endorsements.verify_through as type_of_check',
                'businesses.business_name as busname',
                'employers.employer_name as emp_name'
            ])
            ->where('endorsements.id', $request->id)
            ->get();

        return response()->json($get_info);
    }

    public function audit_insert_arf_data(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_'.$now.'_'.$count;
        $getID = 0;

        $getStat = DB::table('audits_log')
            ->select('audit_status', 'type_of_save')
            ->where('log_id', $request->id)
            ->get();

        $getCount = DB::table('employee_list')
            ->where('emp_name', $trimmer->trims($request->l_name . ', ' . $request->f_name))
            ->count();

        if(count($getStat) > 0)
        {
            if($getStat[0]->audit_status == 2)
            {
                if($request->chose == 'audit')
                {
                    $getEmpID = '';

                    $getID = DB::table('audit_report_form')
                        ->select('id')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->id;

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('audit_report_form')
                            ->select('emp_id')
                            ->where('audit_log_id', $request->id)
                            ->get()[0]->emp_id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    DB::table('audit_report_form')
                        ->where('audit_log_id', $request->id)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'audit_status' => 0,
                            'last_modified_date_time' => Carbon::now('Asia/Manila')
                        ]);

                    return response()->json([$getID, 'audit', $request->id]);
                }
                else if($request->chose == 'desc')
                {
                    $getEmpID = '';

                    $getID = DB::table('descrepancy_form_audit')
                        ->select('id')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->id;

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('descrepancy_form_audit')
                            ->select('emp_id')
                            ->where('audit_log_id', $request->id)
                            ->get()[0]->emp_id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    DB::table('descrepancy_form_audit')
                        ->where('audit_log_id', $request->id)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'audit_status' => 0,
                            'last_modified_date_time' => Carbon::now('Asia/Manila')
                        ]);

                    return response()->json([$getID, 'desc', $request->id]);
                }
            }
            else if($getStat[0]->type_of_save == 2)
            {
                if($request->chose == 'audit')
                {
                    $getEmpID = '';

                    $getID = DB::table('audit_report_form')
                        ->select('id')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->id;

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('audit_report_form')
                            ->select('emp_id')
                            ->where('audit_log_id', $request->id)
                            ->get()[0]->emp_id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    DB::table('audit_report_form')
                        ->where('audit_log_id', $request->id)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1
                        ]);

                    $getPath = DB::table('audit_report_form')
                        ->select('file_path')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->file_path;


                    return response()->json([$getID, 'audit', $request->id, $getPath]);
                }
                else if($request->chose == 'desc')
                {
                    $getEmpID = '';

                    $getID = DB::table('descrepancy_form_audit')
                        ->select('id')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->id;

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('descrepancy_form_audit')
                            ->select('emp_id')
                            ->where('audit_log_id', $request->id)
                            ->get()[0]->emp_id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    DB::table('descrepancy_form_audit')
                        ->where('audit_log_id', $request->id)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1
                        ]);

                    return response()->json([$getID, 'desc', $request->id]);
                }
            }
            else
            {
                if($request->chose == 'audit')
                {
                    $getEmpID = '';

                    $getID = DB::table('audit_report_form')
                        ->select('id')
                        ->where('audit_log_id', $request->id)
                        ->get()[0]->id;

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('employee_list')
                            ->where('emp_name', $trimmer->trims($request->l_name . ', ' . $request->f_name))
                            ->get()[0]->id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    DB::table('audit_report_form')
                        ->where('audit_log_id', $request->id)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);


                    DB::table('audits_log')
                        ->insert
                        ([
                            'log_id' => $request->id,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Report',
                            'type' => 'audit_report_form',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1,
                            'audit_status' => 0
                        ]);

                    return response()->json([$getID, 'audit', $request->id]);
                }
                else if($request->chose == 'desc')
                {
                    $getEmpID = '';

                    if($getCount > 0)
                    {
                        $getEmpID = DB::table('employee_list')
                            ->where('emp_name', $trimmer->trims($request->l_name . ', ' . $request->f_name))
                            ->get()[0]->id;

                        DB::table('employee_list')
                            ->where('id', $getEmpID)
                            ->update
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $getEmpID = DB::table('employee_list')
                            ->insertGetId
                            ([
                                'emp_id' => $request->emp_id,
                                'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                                'emp_job' => $request->jobTit,
                                'emp_dept' => $request->department,
                                'emp_date_hired' => $request->dateHired,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    $getID = DB::table('descrepancy_form_audit')
                        ->insertGetId
                        ([
                            'user_id' => $request->oimsID,
                            'audit_log_id' => $logID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('audits_log')
                        ->insert
                        ([
                            'log_id' => $logID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Discrepancy Report',
                            'type' => 'audit_discrepancy_form',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1,
                            'audit_status' => 0
                        ]);

                    return response()->json([$getID, 'desc', $logID]);
                }
            }
        }
        else if($request->id == 'new')
        {
            if($request->chose == 'audit')
            {
                $getEmpID = '';

                if($getCount > 0)
                {
                    $getEmpID = DB::table('employee_list')
                        ->where('emp_name', $trimmer->trims($request->l_name . ', ' . $request->f_name))
                        ->get()[0]->id;

                    DB::table('employee_list')
                        ->where('id', $getEmpID)
                        ->update
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                            'emp_job' => $request->jobTit,
                            'emp_dept' => $request->department,
                            'emp_date_hired' => $request->dateHired,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                }
                else
                {
                    $getEmpID = DB::table('employee_list')
                        ->insertGetId
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                            'emp_job' => $request->jobTit,
                            'emp_dept' => $request->department,
                            'emp_date_hired' => $request->dateHired,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $getID = DB::table('audit_report_form')
                    ->where('audit_log_id', $request->logID)
                    ->select('id')
                    ->get();

                if(count($getID) > 0 )
                {
                    DB::table('audit_report_form')
                        ->where('audit_log_id', $request->logID)
                        ->update
                        ([
                            'user_id' => $request->oimsID,
                            'audit_log_id' => $request->logID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);


                    DB::table('audits_log')
                        ->where('log_id' , $request->logID)
                        ->update
                        ([
                            'log_id' => $request->logID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Report',
                            'type' => 'audit_report_form',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1,
                            'audit_status' => 0
                        ]);

                    return response()->json([$getID[0]->id, 'audit', $request->logID]);
                }
                else
                {
                    $getID = DB::table('audit_report_form')
                        ->insertGetId
                        ([
                            'user_id' => $request->oimsID,
                            'audit_log_id' => $logID,
                            'client_name' => $request->client_name,
                            'company_name' => $request->nameComp,
                            'busi_name' => $request->bus_name,
                            'busi_address' => $request->address,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->endor_date,
                            'submission_date' => $request->sub_date,
                            'internal_tat' => $request->internalTat,
                            'external_tat' => $request->exTat,
                            'special_instruction' => $request->specialInst,
                            'type_of_checking' => $request->tochecking,
                            'emp_id' => $getEmpID,
                            'findings' => $request->findings,
                            'investigation' => $request->investig,
                            'valid_res' => $request->validRes,
                            'statements' => $request->states,
                            'observations' => $request->observe,
                            'recom' => $request->recom,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);


                    DB::table('audits_log')
                        ->insert
                        ([
                            'log_id' => $request->logID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Report',
                            'type' => 'audit_report_form',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1,
                            'audit_status' => 0
                        ]);

                    return response()->json([$getID, 'audit', $logID]);
                }

            }
            else if($request->chose == 'desc')
            {
                $getEmpID = '';

                if($getCount > 0)
                {
                    $getEmpID = DB::table('employee_list')
                        ->where('emp_name', $trimmer->trims($request->l_name . ', ' . $request->f_name))
                        ->get()[0]->id;

                    DB::table('employee_list')
                        ->where('id', $getEmpID)
                        ->update
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                            'emp_job' => $request->jobTit,
                            'emp_dept' => $request->department,
                            'emp_date_hired' => $request->dateHired,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }
                else
                {
                    $getEmpID = DB::table('employee_list')
                        ->insertGetId
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->l_name . ', ' . $request->f_name),
                            'emp_job' => $request->jobTit,
                            'emp_dept' => $request->department,
                            'emp_date_hired' => $request->dateHired,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $getID = DB::table('descrepancy_form_audit')
                    ->where('audit_log_id', $request->logID)
                    ->select('id')
                    ->get();

                DB::table('descrepancy_form_audit')
                    ->where('audit_log_id', $request->logID)
                    ->update
                    ([
                        'user_id' => $request->oimsID,
                        'audit_log_id' => $request->logID,
                        'client_name' => $request->client_name,
                        'company_name' => $request->nameComp,
                        'busi_name' => $request->bus_name,
                        'busi_address' => $request->address,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->endor_date,
                        'submission_date' => $request->sub_date,
                        'internal_tat' => $request->internalTat,
                        'external_tat' => $request->exTat,
                        'special_instruction' => $request->specialInst,
                        'type_of_checking' => $request->tochecking,
                        'emp_id' => $getEmpID,
                        'findings' => $request->findings,
                        'investigation' => $request->investig,
                        'valid_res' => $request->validRes,
                        'statements' => $request->states,
                        'observations' => $request->observe,
                        'recom' => $request->recom,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('audits_log')
                    ->insert
                    ([
                        'log_id' => $request->logID,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved Discrepancy Report',
                        'type' => 'audit_discrepancy_form',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'type_of_save' => 1,
                        'audit_status' => 0
                    ]);

                return response()->json([$getID, 'desc', $request->logID]);
            }
        }
    }

    public function audit_download_ci_report_arf(Request $request)
    {
        $id = base64_decode($request->id);

        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($id);

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
            echo'<script>alert(\'Report Not Available at this moment.\'); window.close();</script>';
        }
    }

    public function audit_fetch_suggest_endo_id(Request $request)
    {
        $searchLetter = $request->term;

        $resultQs = DB::table('endorsements')
            ->select('id')
            ->where('id','like','%'.$searchLetter.'%')
            ->take(50)
            ->get();

        $resultTags = [];

        if(count($resultQs)==0)
        {
            $resultTags[] = 'NO ITEM FOUND';
        }
        else
        {
            foreach($resultQs as $resultQ)
            {
                $resultTags[] =
                    [
                        'label' => $resultQ->id,
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function audit_get_info_id_phone_field(Request $request)
    {
        $getData = DB::table('endorsements')
            ->leftJoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->leftJoin('businesses', 'businesses.endorsement_id', '=', 'endorsements.id')
            ->leftJoin('employers', 'employers.endorsement_id', '=', 'endorsements.id')
            ->select
            ([
                'endorsements.address as address',
                'municipalities.muni_name as muni',
                'endorsements.provinces as provinces',
                'endorsements.account_name as account_name',
                'endorsements.client_name as client_name',
                'endorsements.type_of_request as tor',
                'endorsements.date_endorsed as date_endorsed',
                'endorsements.date_forwarded_to_client as submission_date',
                'endorsements.client_remarks as remarks',
                'endorsements.verify_through as type_of_check',
                'businesses.business_name as busname',
                'endorsements.date_ci_visit as ci_visit',
                'employers.employer_name as emp_name'
            ])
            ->where('endorsements.id', $request->id)
            ->get();

        $getName = DB::table('users')
            ->select('name')
            ->where('id', Auth::user()->id)
            ->get();



        return response()->json([$getData, $getName[0]->name]);
    }

    public function audit_insert_phone_field_log(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_'.$now.'_'.$count;

        $compliance = $request->compliance_answer;
        $informants = $request->informant_validation;
        $newInformats = $request->new_informants_gathered;

        $getCount = DB::table('employee_list')
            ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name))
            ->count();

        if($request->id != 'new')
        {
            $getStat = DB::table('audits_log')
                ->select('audit_status', 'type_of_save')
                ->where('log_id', $request->log_id)
                ->get();

            if(count($getStat) > 0)
            {
                if($getStat[0]->audit_status == 2)
                {
                    if($request->checkPhoneField == 'field')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('audit_field_checking')
                                ->select('emp_id')
                                ->where('audit_log_id', $request->log_id)
                                ->get()[0]->emp_id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        $getMainId = DB::table('audit_field_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->select('id')
                            ->get()[0]->id;

                        $getdirstInformant = DB::table('audit_field_informant_validation')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        $getfirstNew = DB::table('audit_field_new_informants')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        DB::table('audit_field_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->update
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                        for($c = 0; $c < count($compliance); $c++)
                        {
                            DB::table('audit_field_compliance_answers')
                                ->where('audit_log_id', $request->log_id)
                                ->where('question_id', ($c + 1))
                                ->update
                                ([
                                    'compliance_ans' => $compliance[$c],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($f = 0; $f < count($informants); $f++)
                        {
                            DB::table('audit_field_informant_validation')
                                ->where('audit_id',  $request->log_id)
                                ->where('id', (($getdirstInformant->id)+$f))
                                ->update
                                ([
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_field_new_informants')
                                ->where('audit_id', $request->log_id)
                                ->where('id', (($getfirstNew->id)+$t))
                                ->update
                                ([
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->where('log_id', $request->log_id)
                            ->update
                            ([
                                'updated_at' => Carbon::now('Asia/Manila'),
                                'audit_status' => 0,
                                'last_modified_date_time' => Carbon::now('Asia/Manila')
                            ]);

                        return response()->json([$getMainId, 'field', $request->log_id]);
                    }
                    else if($request->checkPhoneField == 'phone')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('audit_phone_checking')
                                ->select('emp_id')
                                ->where('audit_log_id', $request->log_id)
                                ->get()[0]->emp_id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        $getMainId = DB::table('audit_phone_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->select('id')
                            ->get()[0]->id;

                        $getdirstInformant = DB::table('audit_phone_informant_validation')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        $getfirstNew = DB::table('audit_phone_new_informants')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        DB::table('audit_phone_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->update
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                        for ($c = 0; $c < count($compliance); $c++) {
                            DB::table('audit_phone_compliance_answers')
                                ->where('audit_log_id', $request->log_id)
                                ->where('question_id', ($c + 1))
                                ->update
                                ([
                                    'compliance_ans' => $compliance[$c],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for ($f = 0; $f < count($informants); $f++) {
                            DB::table('audit_phone_informant_validation')
                                ->where('audit_id', $request->log_id)
                                ->where('id', (($getdirstInformant->id) + $f))
                                ->update
                                ([
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for ($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_phone_new_informants')
                                ->where('audit_id', $request->log_id)
                                ->where('id', (($getfirstNew->id) + $t))
                                ->update
                                ([
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->where('log_id', $request->log_id)
                            ->update
                            ([
                                'updated_at' => Carbon::now('Asia/Manila'),
                                'audit_status' => 0,
                                'last_modified_date_time' => Carbon::now('Asia/Manila')
                            ]);

                        $getPath = DB::table('audit_phone_checking')
                            ->select('file_path')
                            ->where('audit_log_id', $request->log_id)
                            ->get()[0]->file_path;

                        return response()->json([$getMainId, 'phone', $request->id]);
                    }
                }
                else if($getStat[0]->type_of_save == 2)
                {
                    if($request->checkPhoneField == 'field')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('audit_field_checking')
                                ->select('emp_id')
                                ->where('audit_log_id', $request->id)
                                ->get()[0]->emp_id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        $getMainId = DB::table('audit_field_checking')
                            ->where('audit_log_id', $request->id)
                            ->select('id')
                            ->get()[0]->id;

                        $getdirstInformant = DB::table('audit_field_informant_validation')
                            ->where('audit_id', $getMainId)
                            ->select('id')  
                            ->first();

                        $getfirstNew = DB::table('audit_field_new_informants')
                            ->where('audit_id', $getMainId)
                            ->select('id')
                            ->first();

                        DB::table('audit_field_checking')
                            ->where('audit_log_id', $request->id)
                            ->update
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                        for($c = 0; $c < count($compliance); $c++)
                        {
                            DB::table('audit_field_compliance_answers')
                                ->where('audit_log_id', $getMainId)
                                ->where('question_id', ($c + 1))
                                ->update
                                ([
                                    'compliance_ans' => $compliance[$c],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($f = 0; $f < count($informants); $f++)
                        {
                            DB::table('audit_field_informant_validation')
                                ->where('audit_id',  $getMainId)
                                ->where('id', (($getdirstInformant->id)+$f))
                                ->update
                                ([
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_field_new_informants')
                                ->where('audit_id', $getMainId)
                                ->where('id', (($getfirstNew->id)+$t))
                                ->update
                                ([
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->where('log_id', $request->id)
                            ->update
                            ([
                                'updated_at' => Carbon::now('Asia/Manila'),
                                'type_of_save' => 1
                            ]);

                        return response()->json([$getMainId, 'field', $request->id]);
                    }
                    else if($request->checkPhoneField == 'phone')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('audit_phone_checking')
                                ->select('emp_id')
                                ->where('audit_log_id', $request->log_id)
                                ->get()[0]->emp_id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        $getMainId = DB::table('audit_phone_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->select('id')
                            ->get()[0]->id;

                        $getdirstInformant = DB::table('audit_phone_informant_validation')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        $getfirstNew = DB::table('audit_phone_new_informants')
                            ->where('audit_id', $request->log_id)
                            ->select('id')
                            ->first();

                        DB::table('audit_phone_checking')
                            ->where('audit_log_id', $request->log_id)
                            ->update
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                        for ($c = 0; $c < count($compliance); $c++) {
                            DB::table('audit_phone_compliance_answers')
                                ->where('audit_log_id', $request->log_id)
                                ->where('question_id', ($c + 1))
                                ->update
                                ([
                                    'compliance_ans' => $compliance[$c],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for ($f = 0; $f < count($informants); $f++) {
                            DB::table('audit_phone_informant_validation')
                                ->where('audit_id', $request->log_id)
                                ->where('id', (($getdirstInformant->id) + $f))
                                ->update
                                ([
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for ($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_phone_new_informants')
                                ->where('audit_id', $request->log_id)
                                ->where('id', (($getfirstNew->id) + $t))
                                ->update
                                ([
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->where('log_id', $request->log_id)
                            ->update
                            ([
                                'updated_at' => Carbon::now('Asia/Manila'),
                                'type_of_save' => 1
                            ]);

                        return response()->json([$request->log_id, 'phone', $request->log_id]);
                    }
                }
                else
                {
                    if($request->checkPhoneField == 'field')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('employee_list')
                                ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name))
                                ->get()[0]->id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);

                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        $getId = DB::table('audit_field_checking')
                            ->where('log_id', $request->log_id)
                            ->update
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);

                        for($c = 0; $c < count($compliance); $c++)
                        {
                            DB::table('audit_field_compliance_answers')
                                ->insert
                                ([
                                    'question_id' => ($c + 1),
                                    'audit_log_id' => $request->log_id,
                                    'compliance_ans' => $compliance[$c],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($f = 0; $f < count($informants); $f++)
                        {
                            DB::table('audit_field_informant_validation')
                                ->insert
                                ([
                                    'audit_id' => $request->log_id,
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_field_new_informants')
                                ->insert
                                ([
                                    'audit_id' => $request->log_id,
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->where('log_id', $request->log_id)
                            ->update
                            ([
                                'user_id' => Auth::user()->id,
                                'activity' => 'Saved Audit Field Checking',
                                'type' => 'audit_field_checking',
                                'created_at' => Carbon::now('Asia/Manila'),
                                'audit_status' => 0,
                                'type_of_save' => 1,
                            ]);

                        return response()->json([$request->log_id, 'field', $request->log_id]);
                    }
                    else if($request->checkPhoneField == 'phone')
                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('employee_list')
                                ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name))
                                ->get()[0]->id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);

                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                                    'emp_job' => $request->jobTitle,
                                    'emp_dept' => $request->emp_dept,
                                    'emp_date_hired' => $request->dateHired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        $getId = DB::table('audit_phone_checking')
                            ->where('audit_log_id', $request->log_id)
                            ([
                                'oims_id' => $request->oimsId,
                                'subj_name' => $request->subjName,
                                'busi_name' => $request->busName,
                                'subj_bus_name' => $request->addRess,
                                'audit_logged' => $request->dateLogged,
                                'auditor_name' => $request->auditName,
                                'findings' => $request->findings,
                                'done_thru' => $request->doneThru,
                                'client_name' => $request->clientName,
                                'type_of_request' => $request->tor,
                                'endorsement_date' => $request->dateEndorsed,
                                'ci_date_visit' => $request->spec,
                                'spec_ins' => $request->spec,
                                'type_of_checking' => $request->toc,
                                'emp_id' => $getEmpId,
                                'summary_report' => $request->sum_rep,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);

                        for($c = 0; $c < count($compliance); $c++)
                        {
                            DB::table('audit_phone_compliance_answers')
                                ->insert
                                ([
                                    'question_id' => ($c + 1),
                                    'audit_log_id' => $request->log_id,
                                    'compliance_ans' => $compliance[$c],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($f = 0; $f < count($informants); $f++)
                        {
                            DB::table('audit_phone_informant_validation')
                                ->insert
                                ([
                                    'audit_id' => $request->log_id,
                                    'informant_name' => $informants[$f][0],
                                    'relation_subject' => $informants[$f][1],
                                    'informant_address' => $informants[$f][2],
                                    'informant_existance' => $informants[$f][3],
                                    'informant_remarks' => $informants[$f][4],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        for($t = 0; $t < count($newInformats); $t++)
                        {
                            DB::table('audit_phone_new_informants')
                                ->insert
                                ([
                                    'audit_id' => $request->log_id,
                                    'informants_name' => $newInformats[$t][0],
                                    'relation_subject' => $newInformats[$t][1],
                                    'address' => $newInformats[$t][2],
                                    'remarks' => $newInformats[$t][3],
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audits_log')
                            ->insert
                            ([
                                'log_id' => $request->log_id,
                                'user_id' => Auth::user()->id,
                                'activity' => 'Saved Audit Phone Checking',
                                'type' => 'audit_phone_checking',
                                'created_at' => Carbon::now('Asia/Manila'),
                                'audit_status' => 0,
                                'type_of_save' => 1
                            ]);

                        return response()->json([$request->log_id, 'phone', $request->log_id]);
                    }
                }
            }
        }
        else if($request->id == 'new')
        {
            if($request->checkPhoneField == 'field')
            {
                $getEmpId = '';


                if($getCount > 0)
                {
                    $getEmpId = DB::table('employee_list')
                        ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name))
                        ->get()[0]->id;

                    DB::table('employee_list')
                        ->where('id', $getEmpId)
                        ->update
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                            'emp_job' => $request->jobTitle,
                            'emp_dept' => $request->emp_dept,
                            'emp_date_hired' => $request->dateHired,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                }
                else
                {
                    $getEmpId = DB::table('employee_list')
                        ->insertGetId
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                            'emp_job' => $request->jobTitle,
                            'emp_dept' => $request->emp_dept,
                            'emp_date_hired' => $request->dateHired,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $getId = DB::table('audit_field_checking')
                    ->insertGetId
                    ([
                        'audit_log_id' => $logID,
                        'oims_id' => $request->oimsId,
                        'subj_name' => $request->subjName,
                        'busi_name' => $request->busName,
                        'subj_bus_name' => $request->addRess,
                        'audit_logged' => $request->dateLogged,
                        'auditor_name' => $request->auditName,
                        'findings' => $request->findings,
                        'done_thru' => $request->doneThru,
                        'client_name' => $request->clientName,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->dateEndorsed,
                        'ci_date_visit' => $request->spec,
                        'spec_ins' => $request->spec,
                        'type_of_checking' => $request->toc,
                        'emp_id' => $getEmpId,
                        'summary_report' => $request->sum_rep,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                for($c = 0; $c < count($compliance); $c++)
                {
                    DB::table('audit_field_compliance_answers')
                        ->insert
                        ([
                            'question_id' => ($c + 1),
                            'audit_log_id' => $logID,
                            'compliance_ans' => $compliance[$c],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($f = 0; $f < count($informants); $f++)
                {
                    DB::table('audit_field_informant_validation')
                        ->insert
                        ([
                            'audit_id' => $logID,
                            'informant_name' => $informants[$f][0],
                            'relation_subject' => $informants[$f][1],
                            'informant_address' => $informants[$f][2],
                            'informant_existance' => $informants[$f][3],
                            'informant_remarks' => $informants[$f][4],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($t = 0; $t < count($newInformats); $t++)
                {
                    DB::table('audit_field_new_informants')
                        ->insert
                        ([
                            'audit_id' => $logID,
                            'informants_name' => $newInformats[$t][0],
                            'relation_subject' => $newInformats[$t][1],
                            'address' => $newInformats[$t][2],
                            'remarks' => $newInformats[$t][3],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                DB::table('audits_log')
                    ->where('log_id', $logID)
                    ->update
                    ([
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved Audit Field Checking',
                        'type' => 'audit_field_checking',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'audit_status' => 0,
                        'type_of_save' => 1,
                    ]);

                return response()->json([$getId, 'field', $logID]);
            }
            else if($request->checkPhoneField == 'phone')
            {
                $getEmpId = '';

                if($getCount > 0)
                {
                    $getEmpId = DB::table('employee_list')
                        ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name))
                        ->get()[0]->id;

                    DB::table('employee_list')
                        ->where('id', $getEmpId)
                        ->update
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                            'emp_job' => $request->jobTitle,
                            'emp_dept' => $request->emp_dept,
                            'emp_date_hired' => $request->dateHired,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                }
                else
                {
                    $getEmpId = DB::table('employee_list')
                        ->insertGetId
                        ([
                            'emp_id' => $request->emp_id,
                            'emp_name' => $trimmer->trims($request->emp_last_name . ', ' . $request->emp_first_name),
                            'emp_job' => $request->jobTitle,
                            'emp_dept' => $request->emp_dept,
                            'emp_date_hired' => $request->dateHired,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $getId = DB::table('audit_phone_checking')
                    ->insertGetId
                    ([
                        'audit_log_id' => $logID,
                        'oims_id' => $request->oimsId,
                        'subj_name' => $request->subjName,
                        'busi_name' => $request->busName,
                        'subj_bus_name' => $request->addRess,
                        'audit_logged' => $request->dateLogged,
                        'auditor_name' => $request->auditName,
                        'findings' => $request->findings,
                        'done_thru' => $request->doneThru,
                        'client_name' => $request->clientName,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->dateEndorsed,
                        'ci_date_visit' => $request->spec,
                        'spec_ins' => $request->spec,
                        'type_of_checking' => $request->toc,
                        'emp_id' => $getEmpId,
                        'summary_report' => $request->sum_rep,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                for($c = 0; $c < count($compliance); $c++)
                {
                    DB::table('audit_phone_compliance_answers')
                        ->insert
                        ([
                            'question_id' => ($c + 1),
                            'audit_log_id' => $logID,
                            'compliance_ans' => $compliance[$c],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($f = 0; $f < count($informants); $f++)
                {
                    DB::table('audit_phone_informant_validation')
                        ->insert
                        ([
                            'audit_id' => $logID,
                            'informant_name' => $informants[$f][0],
                            'relation_subject' => $informants[$f][1],
                            'informant_address' => $informants[$f][2],
                            'informant_existance' => $informants[$f][3],
                            'informant_remarks' => $informants[$f][4],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($t = 0; $t < count($newInformats); $t++)
                {
                    DB::table('audit_phone_new_informants')
                        ->insert
                        ([
                            'audit_id' => $logID,
                            'informants_name' => $newInformats[$t][0],
                            'relation_subject' => $newInformats[$t][1],
                            'address' => $newInformats[$t][2],
                            'remarks' => $newInformats[$t][3],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                DB::table('audits_log')
                    ->where('log_id', $logID)
                    ->update
                    ([
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved Audit Phone Checking',
                        'type' => 'audit_phone_checking',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'audit_status' => 0,
                        'type_of_save' => 1
                    ]);

                return response()->json([$getId, 'phone', $logID]);
            }
        }
    }

    public function audit_ci_report_checking_form(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_' . $now . '_' . $count;

        $total = ((int)$request->completeness + (int)$request->gps_attachment + (int)$request->informants_validity + (int)$request->encoding_accuracy + (int)$request->selfie_uniform_id + (int)$request->tat_compliance + (int)$request->attached_documents);

        $getCount = DB::table('employee_list')
            ->where('emp_name', $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name))
            ->count();

        if($request->id != 'new')
        {
            $getEmpId = '';

            if($getCount > 0)
            {
                $getEmpId = DB::table('audit_ci_report_checking')
                    ->select('emp_id')
                    ->where('log_id', $request->id)
                    ->get()[0]->emp_id;

                DB::table('employee_list')
                    ->where('id', $getEmpId)
                    ->update
                    ([
                        'emp_id' => $request->emp_id,
                        'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                        'emp_job' => $request->ci_job_title,
                        'emp_date_hired' => $request->ci_date_hired,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {
                $getEmpId = DB::table('employee_list')
                    ->insertGetId
                    ([
                        'emp_id' => $request->emp_id,
                        'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                        'emp_job' => $request->ci_job_title,
                        'emp_date_hired' => $request->ci_date_hired,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }

            $getStat = DB::table('audits_log')
                ->select('audit_status', 'type_of_save')
                ->where('log_id', $request->id)
                ->get();

            if(count($getStat) > 0)
            {
                if ($getStat[0]->audit_status == 2)
                {
                    DB::table('audit_ci_report_checking')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'emp_id' => $getEmpId,
                            'ci_area' => $request->ci_area,
                            'ci_branch_head' => $request->ci_branch_head,
                            'ci_regional_head' => $request->ci_regional_head,
                            'ci_senior_account_officer' => $request->ci_senior_account_officer,
                            'ci_supervisor' => $request->ci_supervisor,
                            'oims_endorse_id' => $request->oims_endorse_id,
                            'messenger_endorse_id' => $request->messenger_endorse_id,
                            'account_name' => $removeScript->scripttrim($request->account_name),
                            'bank_name' => $removeScript->scripttrim($request->bank_name),
                            'endorse_date' => $request->endorse_date,
                            'date_visited' => $request->date_visited,
                            'account_tor' => $removeScript->scripttrim($request->account_tor),
                            'handling_type' => $removeScript->scripttrim($request->handling_type),
                            'account_source' => $removeScript->scripttrim($request->account_source),
                            'completeness' => $request->completeness,
                            'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                            'gps_attachment' => $request->gps_attachment,
                            'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                            'informants_validity' => $request->informants_validity,
                            'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                            'encoding_accuracy' => $request->encoding_accuracy,
                            'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                            'selfie_uniform_id' => $request->selfie_uniform_id,
                            'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                            'tat_compliance' => $request->tat_compliance,
                            'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                            'attached_documents' => $request->attached_documents,
                            'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                            'total_score' => $total,
                            'report_summary' => $removeScript->scripttrim($request->report_summary),
                            'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);


                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'audit_status' => 0,
                            'last_modified_date_time' => Carbon::now('Asia/Manila')
                        ]);

                    return $request->id;
                }
                else if ($getStat[0]->type_of_save == 2)
                {
                    DB::table('audit_ci_report_checking')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'emp_id' => $getEmpId,
                            'ci_area' => $request->ci_area,
                            'ci_branch_head' => $request->ci_branch_head,
                            'ci_regional_head' => $request->ci_regional_head,
                            'ci_senior_account_officer' => $request->ci_senior_account_officer,
                            'ci_supervisor' => $request->ci_supervisor,
                            'oims_endorse_id' => $request->oims_endorse_id,
                            'messenger_endorse_id' => $request->messenger_endorse_id,
                            'account_name' => $removeScript->scripttrim($request->account_name),
                            'bank_name' => $removeScript->scripttrim($request->bank_name),
                            'endorse_date' => $request->endorse_date,
                            'date_visited' => $request->date_visited,
                            'account_tor' => $removeScript->scripttrim($request->account_tor),
                            'handling_type' => $removeScript->scripttrim($request->handling_type),
                            'account_source' => $removeScript->scripttrim($request->account_source),
                            'completeness' => $request->completeness,
                            'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                            'gps_attachment' => $request->gps_attachment,
                            'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                            'informants_validity' => $request->informants_validity,
                            'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                            'encoding_accuracy' => $request->encoding_accuracy,
                            'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                            'selfie_uniform_id' => $request->selfie_uniform_id,
                            'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                            'tat_compliance' => $request->tat_compliance,
                            'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                            'attached_documents' => $request->attached_documents,
                            'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                            'total_score' => $total,
                            'report_summary' => $removeScript->scripttrim($request->report_summary),
                            'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);


                    DB::table('audits_log')
                        ->where('log_id', $request->id)
                        ->update
                        ([
                            'updated_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 1
                        ]);

                    return $request->id;
                }
                else
                {

                    {
                        $getEmpId = '';

                        if($getCount > 0)
                        {
                            $getEmpId = DB::table('employee_list')
                                ->select('id')
                                ->where('emp_name', $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name))
                                ->get()[0]->id;

                            DB::table('employee_list')
                                ->where('id', $getEmpId)
                                ->update
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                                    'emp_job' => $request->ci_job_title,
                                    'emp_date_hired' => $request->ci_date_hired,
                                    'updated_at' => Carbon::now('Asia/Manila')
                                ]);
                        }
                        else
                        {
                            $getEmpId = DB::table('employee_list')
                                ->insertGetId
                                ([
                                    'emp_id' => $request->emp_id,
                                    'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                                    'emp_job' => $request->ci_job_title,
                                    'emp_date_hired' => $request->ci_date_hired,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                        }

                        DB::table('audit_ci_report_checking')
                            ->insert
                            ([
                                'emp_id' => $getEmpId,
                                'log_id' => $logID,
                                'ci_area' => $request->ci_area,
                                'ci_branch_head' => $request->ci_branch_head,
                                'ci_regional_head' => $request->ci_regional_head,
                                'ci_senior_account_officer' => $request->ci_senior_account_officer,
                                'ci_supervisor' => $request->ci_supervisor,
                                'oims_endorse_id' => $request->oims_endorse_id,
                                'messenger_endorse_id' => $request->messenger_endorse_id,
                                'account_name' => $removeScript->scripttrim($request->account_name),
                                'bank_name' => $removeScript->scripttrim($request->bank_name),
                                'endorse_date' => $request->endorse_date,
                                'date_visited' => $request->date_visited,
                                'account_tor' => $removeScript->scripttrim($request->account_tor),
                                'handling_type' => $removeScript->scripttrim($request->handling_type),
                                'account_source' => $removeScript->scripttrim($request->account_source),
                                'completeness' => $request->completeness,
                                'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                                'gps_attachment' => $request->gps_attachment,
                                'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                                'informants_validity' => $request->informants_validity,
                                'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                                'encoding_accuracy' => $request->encoding_accuracy,
                                'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                                'selfie_uniform_id' => $request->selfie_uniform_id,
                                'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                                'tat_compliance' => $request->tat_compliance,
                                'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                                'attached_documents' => $request->attached_documents,
                                'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                                'total_score' => $total,
                                'report_summary' => $removeScript->scripttrim($request->report_summary),
                                'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);


                        DB::table('audits_log')
                            ->insert([
                                'log_id' => $logID,
                                'user_id' => Auth::user()->id,
                                'activity' => 'Saved CI Report Checking',
                                'type' => 'ci_report_checking',
                                'created_at' => Carbon::now('Asia/Manila'),
                                'type_of_save' => 1,
                                'audit_status' => 0
                            ]);

                        return $logID;
                    }
                }
            }
        }
        else if($request->id == 'new')
        {
            $getEmpId = '';

            if($getCount > 0)
            {
                $getEmpId = DB::table('employee_list')
                    ->select('id')
                    ->where('emp_name', $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name))
                    ->get()[0]->id;

                DB::table('employee_list')
                    ->where('id', $getEmpId)
                    ->update
                    ([
                        'emp_id' => $request->emp_id,
                        'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                        'emp_job' => $request->ci_job_title,
                        'emp_date_hired' => $request->ci_date_hired,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {
                $getEmpId = DB::table('employee_list')
                    ->insertGetId
                    ([
                        'emp_id' => $request->emp_id,
                        'emp_name' => $trimmer->trims($request->ci_last_name . ', ' . $request->ci_first_name),
                        'emp_job' => $request->ci_job_title,
                        'emp_date_hired' => $request->ci_date_hired,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }

            DB::table('audit_ci_report_checking')
                ->where('log_id', $request->log_id)
                ->update
                ([
                    'emp_id' => $getEmpId,
                    'log_id' => $request->log_id,
                    'ci_area' => $request->ci_area,
                    'ci_branch_head' => $request->ci_branch_head,
                    'ci_regional_head' => $request->ci_regional_head,
                    'ci_senior_account_officer' => $request->ci_senior_account_officer,
                    'ci_supervisor' => $request->ci_supervisor,
                    'oims_endorse_id' => $request->oims_endorse_id,
                    'messenger_endorse_id' => $request->messenger_endorse_id,
                    'account_name' => $removeScript->scripttrim($request->account_name),
                    'bank_name' => $removeScript->scripttrim($request->bank_name),
                    'endorse_date' => $request->endorse_date,
                    'date_visited' => $request->date_visited,
                    'account_tor' => $removeScript->scripttrim($request->account_tor),
                    'handling_type' => $removeScript->scripttrim($request->handling_type),
                    'account_source' => $removeScript->scripttrim($request->account_source),
                    'completeness' => $request->completeness,
                    'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                    'gps_attachment' => $request->gps_attachment,
                    'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                    'informants_validity' => $request->informants_validity,
                    'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                    'encoding_accuracy' => $request->encoding_accuracy,
                    'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                    'selfie_uniform_id' => $request->selfie_uniform_id,
                    'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                    'tat_compliance' => $request->tat_compliance,
                    'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                    'attached_documents' => $request->attached_documents,
                    'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                    'total_score' => $total,
                    'report_summary' => $removeScript->scripttrim($request->report_summary),
                    'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
                    'created_at' => Carbon::now('Asia/Manila')
                ]);


            DB::table('audits_log')
                ->insert([
                    'log_id' => $request->log_id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Saved CI Report Checking',
                    'type' => 'ci_report_checking',
                    'created_at' => Carbon::now('Asia/Manila'),
                    'type_of_save' => 1,
                    'audit_status' => 0
                ]);

            return $request->log_id;
        }
    }

    public function audit_get_account_info_and_details(Request $request)
    {
        $getInfo = DB::table('endorsements')
            ->where('id', $request->id)
            ->get();

        return response()->json([$getInfo]);
    }

    public function audit_tab6_autocomplete(Request $request)
    {
        $resultTags = [];
        $searchLetter = $request->term;
        $resultQs = DB::table('endorsements')
            ->where('id', 'like', '%'.$searchLetter.'%')
            ->select('id')
            ->take(10)
            ->get();

        if(count($resultQs)==0)
        {
            $resultTags[] = 'NO ITEM FOUND';
        }
        else
        {
            foreach($resultQs as $resultQ)
            {
                $resultTags[] =
                    [
                        'label' => $resultQ->id,
                        'id' => $resultQ->id
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function audit_get_logs(Request $request)
    {
        $get_logs = DB::table('audits_log')
            ->join('users', 'users.id', '=', 'audits_log.user_id')
            ->select
            ([
                'audits_log.log_id as id',
                'users.name as name',
                'audits_log.activity as activity',
                'audits_log.created_at as date_time',
                'audits_log.type as type',
                'audits_log.type_of_save as save',
                'audits_log.audit_status as stat'
            ])
            ->where('user_id', Auth::user()->id)
            ->where('type', $request->what_type)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([$get_logs]);
    }

    public function audit_get_logs_value_tab6(Request $request)
    {
        $type = $request->type;

        $get_logInfo = [];

        if($type == 'audit_report_form')
        {
            $path = storage_path('audit_arf_files/' . $request->id);
            $filecount = glob("$path/*");
            $file_name_array = [];
            $ctr = 0;

            $report_form = DB::table('audit_report_form')
                ->join('employee_list', 'employee_list.id', '=', 'audit_report_form.emp_id')
                ->where('audit_report_form.audit_log_id', $request->id)
                ->get();

            if(File::exists($path))
            {
                for($ctr = 0; $ctr < count($filecount); $ctr++)
                {
                    $file_name_array[$ctr] = explode($request->id.'/',$filecount[$ctr])[1];
                }
            }


            $get_logInfo = [$report_form, $file_name_array];
        }
        else if($type == 'audit_discrepancy_form')
        {
            $path = storage_path('audit_arf_files/' . $request->id);
            $filecount = glob("$path/*");
            $file_name_array = [];
            $ctr = 0;

            $report_form = DB::table('descrepancy_form_audit')
                ->join('employee_list', 'employee_list.id', '=','descrepancy_form_audit.emp_id')
                ->where('descrepancy_form_audit.audit_log_id', $request->id)
                ->get();

            if(File::exists($path))
            {
                for($ctr = 0; $ctr < count($filecount); $ctr++)
                {
                    $file_name_array[$ctr] = explode($request->id.'/',$filecount[$ctr])[1];
                }
            }


            $get_logInfo = [$report_form, $file_name_array];
        }
        else if($type == 'audit_field_checking')
        {
            $path = storage_path('audit_field_files/' . $request->id);
            $filecount = glob("$path/*");
            $file_name_array = [];
            $ctr = 0;

            $get_logBasic = DB::table('audit_field_checking')
                ->join('employee_list', 'employee_list.id', '=', 'audit_field_checking.emp_id')
                ->where('audit_field_checking.audit_log_id', $request->id)
                ->get();

            $getId = DB::table('audit_field_checking')
                ->select('id')
                ->where('audit_log_id', $request->id)
                ->get();

            $getComplianceAns = DB::table('audit_field_compliance_answers')
                ->select('compliance_ans')
                ->where('audit_log_id', $request->id)
                ->get();

            $getInformant = DB::table('audit_field_informant_validation')
                ->select('informant_name', 'relation_subject', 'informant_address', 'informant_existance', 'informant_remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getNewInformants = DB::table('audit_field_new_informants')
                ->select('informants_name', 'relation_subject', 'address', 'remarks')
                ->where('audit_id', $request->id)
                ->get();

            if(File::exists($path))
            {
                for($ctr = 0; $ctr < count($filecount); $ctr++)
                {
                    $file_name_array[$ctr] = explode($request->id.'/',$filecount[$ctr])[1];
                }
            }

            $get_logInfo = [$get_logBasic, $getComplianceAns, $getInformant, $getNewInformants, $file_name_array];

        }
        else if($type == 'audit_phone_checking')
        {
            $path = storage_path('audit_field_files/' . $request->id);
            $filecount = glob("$path/*");
            $file_name_array = [];
            $ctr = 0;

            $get_logBasic = DB::table('audit_phone_checking')
                ->join('employee_list', 'employee_list.id', '=', 'audit_phone_checking.emp_id')
                ->where('audit_phone_checking.audit_log_id', $request->id)
                ->get();

            $getId = DB::table('audit_phone_checking')
                ->select('id')
                ->where('audit_log_id', $request->id)
                ->get();

            $getComplianceAns = DB::table('audit_phone_compliance_answers')
                ->select('compliance_ans')
                ->where('audit_log_id', $request->id)
                ->get();

            $getInformant = DB::table('audit_phone_informant_validation')
                ->select('informant_name', 'relation_subject', 'informant_address', 'informant_existance', 'informant_remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getNewInformants = DB::table('audit_phone_new_informants')
                ->select('informants_name', 'relation_subject', 'address', 'remarks')
                ->where('audit_id', $request->id)
                ->get();


            if(File::exists($path))
            {
                for($ctr = 0; $ctr < count($filecount); $ctr++)
                {
                    $file_name_array[$ctr] = explode($request->id.'/',$filecount[$ctr])[1];
                }
            }

            $get_logInfo = [$get_logBasic, $getComplianceAns, $getInformant, $getNewInformants, $file_name_array];
        }
        else if($type == 'ci_report_checking')
        {
            $path = storage_path('audit_ci_report_checking/' . $request->id);
            $filecount = glob("$path/*");
            $file_name_array = [];
            $ctr = 0;

            $ciRep = DB::table('audit_ci_report_checking')
                ->join('employee_list', 'employee_list.id','=', 'audit_ci_report_checking.emp_id')
                ->where('log_id', $request->id)
                ->get();

            if(File::exists($path))
            {
                for($ctr = 0; $ctr < count($filecount); $ctr++)
                {
                    $file_name_array[$ctr] = explode($request->id.'/',$filecount[$ctr])[1];
                }
            }

            $get_logInfo = [$ciRep, $file_name_array];
        }

        return response()->json([$get_logInfo]);
    }

    public function audit_report_monitoring_table()
    {
        $table = DB::table('audits_log')
            ->join('users', 'users.id', '=', 'audits_log.user_id')
            ->join('provinces', 'provinces.id', '=', 'users.branch')
            ->leftjoin('audit_report_form', 'audit_report_form.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('descrepancy_form_audit', 'descrepancy_form_audit.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_field_checking', 'audit_field_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_phone_checking', 'audit_phone_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_ci_report_checking', 'audit_ci_report_checking.log_id', '=', 'audits_log.log_id')
            ->leftjoin('employee_list as emp_1', 'emp_1.id', '=', 'audit_report_form.emp_id')
            ->leftjoin('employee_list as emp_2', 'emp_2.id', '=', 'descrepancy_form_audit.emp_id')
            ->leftjoin('employee_list as emp_3', 'emp_3.id', '=', 'audit_field_checking.emp_id')
            ->leftjoin('employee_list as emp_4', 'emp_4.id', '=', 'audit_phone_checking.emp_id')
            ->leftjoin('employee_list as emp_5', 'emp_5.id', '=', 'audit_ci_report_checking.emp_id')
            ->select
            ([
                'audits_log.log_id as audit_id',
                'audits_log.created_at as date',
                'audits_log.user_id as auditor_id',
                'audits_log.reviewer_id as rev_id',
                'audits_log.activity as activ',
                'provinces.name as branch',

                'audit_report_form.emp_id as emp_arf',
                'descrepancy_form_audit.emp_id as emp_desc',
                'audit_field_checking.emp_id as emp_field',
                'audit_phone_checking.emp_id as emp_phone',
                'audit_ci_report_checking.emp_id as emp_cssf',
                'users.name as user',

                'audits_log.audit_status as a_status',
                'audits_log.escalation_status as e_status',
                'emp_1.emp_name',
                'emp_2.emp_name',
                'emp_3.emp_name',
                'emp_4.emp_name',
                'emp_5.emp_name',
                'audits_log.last_modified_date_time as mod',
                'audits_log.return_date_time as ret'
            ])
            ->where('audits_log.type_of_save', 1)
        ;

        return DataTables::of($table)
            ->editcolumn('employee', function($query)
            {
                $empID = '';
                if($query->emp_arf != null)
                {
                    $empID = $query->emp_arf;
                }
                else if($query->emp_desc != null)
                {
                    $empID = $query->emp_desc;
                }
                else if($query->emp_field != null)
                {
                    $empID = $query->emp_field;
                }
                else if($query->emp_phone != null)
                {
                    $empID = $query->emp_phone;
                }
                else if($query->emp_cssf != null)
                {
                    $empID = $query->emp_cssf;
                }

                $getEmpName = DB::table('employee_list')
                    ->select('emp_name')
                    ->where('id', $empID)
                    ->get()[0]->emp_name;

                $testname = strtolower($getEmpName);

                $newName = ucwords($testname);

                return $newName;
            })
            ->editcolumn('status', function($query)
            {
                $getRev = DB::table('users')
                    ->select('name')
                    ->where('id', $query->rev_id)
                    ->get();

                if($query->a_status == 0)
                {
                    return 'For Review';
                }
                else if($query->a_status == 1)
                {
                    return 'Completed (Reviewed By <b> '. $getRev[0]->name. '</b>)';
                }
                else if($query->a_status == 2)
                {
                    return 'Returned (Reviewed By <b> '. $getRev[0]->name. '</b>)<br><br>Return timestamp: ' .$query->ret;
                }
            })
            ->rawColumns([
                'employee',
                'status',
            ])
            ->toJson();
//            ->make(true);
    }

    public function audit_get_all_audit_log_info(Request $request)
    {
        $type = $request->type;

        $getStat = DB::table('audits_log')
            ->select('audit_status')
            ->where('log_id', $request->id)
            ->get();

        $getData = [];

        if($type == 'Saved Audit Report')
        {
            $getData = DB::table('audit_report_form')
                ->join('employee_list', 'employee_list.id', '=', 'audit_report_form.emp_id')
                ->where('audit_report_form.audit_log_id', $request->id)
                ->get();
        }
        else if($type == 'Saved Discrepancy Report')
        {
            $getData = DB::table('descrepancy_form_audit')
                ->join('employee_list', 'employee_list.id', '=', 'descrepancy_form_audit.emp_id')
                ->where('descrepancy_form_audit.audit_log_id', $request->id)
                ->get();
        }
        else if($type == 'Saved Audit Field Checking')
        {
            $get_logBasic = DB::table('audit_field_checking')
                ->join('employee_list', 'employee_list.id', '=', 'audit_field_checking.emp_id')
                ->where('audit_field_checking.audit_log_id', $request->id)
                ->get();

            $getId = DB::table('audit_field_checking')
                ->select('id')
                ->where('audit_log_id', $request->id)
                ->get();

            $getComplianceAns = DB::table('audit_field_compliance_answers')
                ->select('compliance_ans')
                ->where('audit_log_id', $request->id)
                ->get();

            $getInformant = DB::table('audit_field_informant_validation')
                ->select('informant_name', 'relation_subject', 'informant_address', 'informant_existance', 'informant_remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getNewInformants = DB::table('audit_field_new_informants')
                ->select('informants_name', 'relation_subject', 'address', 'remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getData = [$get_logBasic, $getComplianceAns, $getInformant, $getNewInformants];
        }
        else if($type == 'Saved Audit Phone Checking')
        {
            $get_logBasic = DB::table('audit_phone_checking')
                ->join('employee_list', 'employee_list.id', '=', 'audit_phone_checking.emp_id')
                ->where('audit_phone_checking.audit_log_id', $request->id)
                ->get();

            $getId = DB::table('audit_phone_checking')
                ->select('id')
                ->where('audit_log_id', $request->id)
                ->get();

            $getComplianceAns = DB::table('audit_phone_compliance_answers')
                ->select('compliance_ans')
                ->where('audit_log_id', $request->id)
                ->get();

            $getInformant = DB::table('audit_phone_informant_validation')
                ->select('informant_name', 'relation_subject', 'informant_address', 'informant_existance', 'informant_remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getNewInformants = DB::table('audit_phone_new_informants')
                ->select('informants_name', 'relation_subject', 'address', 'remarks')
                ->where('audit_id', $request->id)
                ->get();

            $getData = [$get_logBasic, $getComplianceAns, $getInformant, $getNewInformants];

        }
        else if($type == 'Saved CI Report Checking')
        {
            $getData = DB::table('audit_ci_report_checking')
                ->join('employee_list', 'employee_list.id', '=', 'audit_ci_report_checking.emp_id')
                ->where('audit_ci_report_checking.log_id', $request->id)
                ->get();
        }

        return response()->json([$getData, $getStat]);
    }

    public function audit_approve_return_log(Request $request)
    {
        if($request->stat == 'approve')
        {
            DB::table('audits_log')
                ->where('log_id', $request->id)
                ->update
                ([
                    'audit_status' => 1,
                    'reviewer_id' => Auth::user()->id
                ]);
        }
        else if($request->stat == 'return')
        {
            DB::table('audits_log')
                ->where('log_id', $request->id)
                ->update
                ([
                    'audit_status' => 2,
                    'reviewer_id' => Auth::user()->id,
                    'return_remarks' => $request->rem,
                    'return_date_time' => Carbon::now('Asia/Manila'),
                    'notif_stat' => 1
                ]);
        }
    }

    public function audit_get_access_show()
    {
        $getAccess = DB::table('users')
            ->select('authrequest')
            ->where('id', Auth::user()->id)
            ->get()[0]->authrequest;

        return response()->json($getAccess);
    }

    public function audit_general_logs_table()
    {
        $getGeneralLogs = DB::table('audits_log')
            ->join('users', 'users.id', '=', 'audits_log.user_id')
            ->leftjoin('audit_report_form', 'audit_report_form.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('descrepancy_form_audit', 'descrepancy_form_audit.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_field_checking', 'audit_field_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_phone_checking', 'audit_phone_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_ci_report_checking', 'audit_ci_report_checking.log_id', '=', 'audits_log.log_id')
            ->leftjoin('employee_list as emp_1', 'emp_1.id', '=', 'audit_report_form.emp_id')
            ->leftjoin('employee_list as emp_2', 'emp_2.id', '=', 'descrepancy_form_audit.emp_id')
            ->leftjoin('employee_list as emp_3', 'emp_3.id', '=', 'audit_field_checking.emp_id')
            ->leftjoin('employee_list as emp_4', 'emp_4.id', '=', 'audit_phone_checking.emp_id')
            ->leftjoin('employee_list as emp_5', 'emp_5.id', '=', 'audit_ci_report_checking.emp_id')
            ->select([
                'audits_log.log_id as id',
                'audits_log.reviewer_id as rev_id',
                'audits_log.created_at as date_time',
//                'users.name as name',
                'audit_report_form.emp_id as emp_arf',
                'descrepancy_form_audit.emp_id as emp_desc',
                'audit_field_checking.emp_id as emp_field',
                'audit_phone_checking.emp_id as emp_phone',
                'audit_ci_report_checking.emp_id as emp_cssf',
                'audits_log.activity as activity',
                'audits_log.type as type',
                'audits_log.audit_status as status',
                'audits_log.audit_status as status2',
                'emp_1.emp_name',
                'emp_2.emp_name',
                'emp_3.emp_name',
                'emp_4.emp_name',
                'emp_5.emp_name',
                'audits_log.type_of_save as save_type'
            ])
            ->where('audits_log.user_id', Auth::user()->id)
            ->where('audits_log.type_of_save', 1);

        return DataTables::of($getGeneralLogs)
            ->editcolumn('employee', function($query)
            {
                $empID = '';
                if($query->emp_arf != null)
                {
                    $empID = $query->emp_arf;
                }
                else if($query->emp_desc != null)
                {
                    $empID = $query->emp_desc;
                }
                else if($query->emp_field != null)
                {
                    $empID = $query->emp_field;
                }
                else if($query->emp_phone != null)
                {
                    $empID = $query->emp_phone;
                }
                else if($query->emp_cssf != null)
                {
                    $empID = $query->emp_cssf;
                }

                $getEmpName = DB::table('employee_list')
                    ->select('emp_name')
                    ->where('id', $empID)
                    ->get()[0]->emp_name;

                $testname = strtolower($getEmpName);

                $newName = ucwords($testname);

                return $newName;
            })
            ->editColumn('status', function ($query)
            {
                $getRevName = DB::table('users')
                    ->where('id', $query->rev_id)
                    ->select('name')
                    ->get();

                if($query->status == 1)
                {
                    return 'Approved By '.'<b>'. $getRevName[0]->name. '</b>';
                }
                else if($query->status == 2)
                {
                    return 'Returned By '.'<b>' .$getRevName[0]->name. '</b> <br><br> 
                    <button class = "btn btn-xs btn-info" id = "btn_view_return_rem" name = "'.$query->id.'" style = "background: none; border : none; text-decoration: underline; color: black" data-toggle="modal" data-target="#modal-audit-return-logs" href = "return">
                    View Return Remarks
                    </button>';
                }
                else if($query->status == 0)
                {
                    return 'Pending / For Review';
                }
            })
            ->rawColumns
            ([
                'employee',
                'status'
            ])
            ->toJson();
    }

    public function audit_save_update_data(Request $request)
    {
        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_'.$now.'_'.$count;
        $trimmer = new Trimmer();

        $empDetails = '';

        $getEmp = DB::table('employee_list')
            ->select('id')
            ->where('emp_name', $trimmer->trims($request->l_name . ', ' .$request->f_name))
            ->get();

        if(count($getEmp) > 0)
        {
            $empDetails = $getEmp[0]->id;

            DB::table('employee_list')
                ->where('id', $empDetails)
                ->update
                ([
                    'emp_id' => $request->emp_id,
                    'emp_job' => $request->jobTit,
                    'emp_dept' => $request->department,
                    'emp_date_hired' => $request->dateHired
                ]);
        }
        else if(count($getEmp) <= 0)
        {
            $empDetails = DB::table('employee_list')
                ->insertGetId
                ([
                    'emp_id' => $request->emp_id,
                    'emp_name' => $trimmer->trims($request->l_name . ', ' .$request->f_name),
                    'emp_job' => $request->jobTit,
                    'emp_dept' => $request->department,
                    'emp_date_hired' => $request->dateHired
                ]);
        }

        if($request->id == 'new')
        {
            if($request->chose == 'audit')
            {
//                $getID = DB::table('audit_report_form')
//                    ->select('id')
//                    ->where('audit_log_id', $request->log_id)
//                    ->get()[0]->id;

               $getID = DB::table('audit_report_form')
                    ->insertGetId
                    ([
                        'user_id' => $request->oimsID,
                        'audit_log_id' => $logID,
                        'client_name' => $request->client_name,
                        'company_name' => $request->nameComp,
                        'busi_name' => $request->bus_name,
                        'busi_address' => $request->address,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->endor_date,
                        'submission_date' => $request->sub_date,
                        'internal_tat' => $request->internalTat,
                        'external_tat' => $request->exTat,
                        'special_instruction' => $request->specialInst,
                        'type_of_checking' => $request->tochecking,
                        'emp_id' => $empDetails,
                        'findings' => $request->findings,
                        'investigation' => $request->investig,
                        'valid_res' => $request->validRes,
                        'statements' => $request->states,
                        'observations' => $request->observe,
                        'recom' => $request->recom,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);


                DB::table('audits_log')
                    ->insert
                    ([
                        'log_id' => $logID,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved Audit Report',
                        'type' => 'audit_report_form',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'type_of_save' => 2
                    ]);


                return response()->json([$getID, 'audit', $logID]);
            }
            else if($request->chose == 'desc')
            {
//                $getID = DB::table('descrepancy_form_audit')
//                    ->select('id')
//                    ->where('audit_log_id', '=', $request->log_id)
//                    ->get()[0]->id;

                $getID = DB::table('descrepancy_form_audit')
                    ->insertGetId
                    ([
                        'user_id' => $request->oimsID,
                        'audit_log_id' => $logID,
                        'client_name' => $request->client_name,
                        'company_name' => $request->nameComp,
                        'busi_name' => $request->bus_name,
                        'busi_address' => $request->address,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->endor_date,
                        'submission_date' => $request->sub_date,
                        'internal_tat' => $request->internalTat,
                        'external_tat' => $request->exTat,
                        'special_instruction' => $request->specialInst,
                        'type_of_checking' => $request->tochecking,
                        'emp_id' => $empDetails,
                        'findings' => $request->findings,
                        'investigation' => $request->investig,
                        'valid_res' => $request->validRes,
                        'statements' => $request->states,
                        'observations' => $request->observe,
                        'recom' => $request->recom,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('audits_log')
                    ->insert
                    ([
                        'log_id' => $logID,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved Discrepancy Report',
                        'type' => 'audit_discrepancy_form',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'type_of_save' => 2
                    ]);

                return response()->json([$getID , 'desc', $logID]);
            }
        }
        else if($request->id != 'new')
        {
            if($request->chose == 'audit')
            {
                $getInsertID = DB::table('audit_report_form')
                    ->select('id')
                    ->where('audit_log_id', $request->log_id)
                    ->get()[0]->id;

                DB::table('audit_report_form')
                    ->where('audit_log_id', $request->log_id)
                    ->update
                    ([
                        'user_id' => $request->oimsID,
                        'client_name' => $request->client_name,
                        'company_name' => $request->nameComp,
                        'busi_name' => $request->bus_name,
                        'busi_address' => $request->address,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->endor_date,
                        'submission_date' => $request->sub_date,
                        'internal_tat' => $request->internalTat,
                        'external_tat' => $request->exTat,
                        'special_instruction' => $request->specialInst,
                        'type_of_checking' => $request->tochecking,
                        'emp_id' => $empDetails,
                        'findings' => $request->findings,
                        'investigation' => $request->investig,
                        'valid_res' => $request->validRes,
                        'statements' => $request->states,
                        'observations' => $request->observe,
                        'recom' => $request->recom,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('audits_log')
                    ->where('log_id', $request->log_id)
                    ->update
                    ([
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);

                return response()->json([$getInsertID, 'audit', $request->log_id]);
            }
            else if($request->chose == 'desc')
            {

                $getInsertID = DB::table('descrepancy_form_audit')
                    ->select('id')
                    ->where('audit_log_id', $request->log_id)
                    ->get()[0]->id;

                DB::table('descrepancy_form_audit')
                    ->where('audit_log_id', $request->log_id)
                    ->update
                    ([
                        'user_id' => $request->oimsID,
                        'client_name' => $request->client_name,
                        'company_name' => $request->nameComp,
                        'busi_name' => $request->bus_name,
                        'busi_address' => $request->address,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->endor_date,
                        'submission_date' => $request->sub_date,
                        'internal_tat' => $request->internalTat,
                        'external_tat' => $request->exTat,
                        'special_instruction' => $request->specialInst,
                        'type_of_checking' => $request->tochecking,
                        'emp_id' => $empDetails,
                        'findings' => $request->findings,
                        'investigation' => $request->investig,
                        'valid_res' => $request->validRes,
                        'statements' => $request->states,
                        'observations' => $request->observe,
                        'recom' => $request->recom,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('audits_log')
                    ->where('log_id', $request->log_id)
                    ->update
                    ([
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);

                return response()->json([$getInsertID, 'desc', $request->log_id]);
            }
        }
    }

    public function audit_save_update_phone_field_log(Request $request)
    {
        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_'.$now.'_'.$count;
        $trimmer = new Trimmer();

        $compliance = $request->compliance_answer;
        $informants = $request->informant_validation;
        $newInformats = $request->new_informants_gathered;

        $empDetails = '';

        $getEmp = DB::table('employee_list')
            ->select('id')
            ->where('emp_name', $trimmer->trims($request->emp_last_name . ', ' .$request->emp_first_name))
            ->get();

        if(count($getEmp) > 0)
        {
            $empDetails = $getEmp[0]->id;

            DB::table('employee_list')
                ->where('id', $empDetails)
                ->update
                ([
                    'emp_id' => $request->emp_id,
                    'emp_job' => $request->jobTitle,
                    'emp_dept' => $request->emp_dept,
                    'emp_date_hired' => $request->dateHired
                ]);
        }
        else if(count($getEmp) <= 0)
        {
            $empDetails = DB::table('employee_list')
                ->insertGetId
                ([
                    'emp_id' => $request->emp_id,
                    'emp_name' => $trimmer->trims($request->emp_last_name . ', ' .$request->emp_first_name),
                    'emp_job' => $request->jobTitle,
                    'emp_dept' => $request->emp_dept,
                    'emp_date_hired' => $request->dateHired
                ]);
        }

        if($request->id == 'new')
        {
            if($request->checkPhoneField == 'field')
            {
                if($request->log_id == null)
                {
//                    $getId = DB::table('audit_field_checking')
//                        ->where('audit_log_id', $request->log_id)
//                        ->select('id')
//                        ->get();

                    $getId = DB::table('audit_field_checking')
                        ->insertGetId
                        ([
                            'oims_id' => $request->oimsId,
                            'audit_log_id' => $logID,
                            'subj_name' => $request->subjName,
                            'busi_name' => $request->busName,
                            'subj_bus_name' => $request->addRess,
                            'audit_logged' => $request->dateLogged,
                            'auditor_name' => $request->auditName,
                            'findings' => $request->findings,
                            'done_thru' => $request->doneThru,
                            'client_name' => $request->clientName,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->dateEndorsed,
                            'ci_date_visit' => $request->spec,
                            'spec_ins' => $request->spec,
                            'type_of_checking' => $request->toc,
                            'emp_id' => $empDetails,
                            'summary_report' => $request->sum_rep,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    for($c = 0; $c < count($compliance); $c++)
                    {
                        DB::table('audit_field_compliance_answers')
                            ->insert
                            ([
                                'question_id' => ($c + 1),
                                'audit_log_id' => $logID,
                                'compliance_ans' => $compliance[$c],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($f = 0; $f < count($informants); $f++)
                    {
                        DB::table('audit_field_informant_validation')
                            ->insert
                            ([
                                'audit_id' => $logID,
                                'informant_name' => $informants[$f][0],
                                'relation_subject' => $informants[$f][1],
                                'informant_address' => $informants[$f][2],
                                'informant_existance' => $informants[$f][3],
                                'informant_remarks' => $informants[$f][4],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($t = 0; $t < count($newInformats); $t++)
                    {
                        DB::table('audit_field_new_informants')
                            ->insert
                            ([
                                'audit_id' => $logID,
                                'informants_name' => $newInformats[$t][0],
                                'relation_subject' => $newInformats[$t][1],
                                'address' => $newInformats[$t][2],
                                'remarks' => $newInformats[$t][3],
                                'created_at' => Carbon::now('Asia/Manila'),

                            ]);
                    }

                    DB::table('audits_log')
                        ->insert
                        ([
                            'log_id' => $logID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Field Checking',
                            'type' => 'audit_field_checking',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 2
                        ]);

                    return response()->json([$getId, 'field', $logID]);
                }
                else
                {
                    $getId = DB::table('audit_field_checking')
                        ->where('audit_log_id', $request->log_id)
                        ->select('id')
                        ->get();

                    DB::table('audit_field_checking')
                        ->where('audit_log_id', $request->log_id)
                        ->update
                        ([
                            'oims_id' => $request->oimsId,
//                            'audit_log_id' => $logID,
                            'subj_name' => $request->subjName,
                            'busi_name' => $request->busName,
                            'subj_bus_name' => $request->addRess,
                            'audit_logged' => $request->dateLogged,
                            'auditor_name' => $request->auditName,
                            'findings' => $request->findings,
                            'done_thru' => $request->doneThru,
                            'client_name' => $request->clientName,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->dateEndorsed,
                            'ci_date_visit' => $request->spec,
                            'spec_ins' => $request->spec,
                            'type_of_checking' => $request->toc,
                            'emp_id' => $empDetails,
                            'summary_report' => $request->sum_rep,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    for($c = 0; $c < count($compliance); $c++)
                    {
                        DB::table('audit_field_compliance_answers')
                            ->insert
                            ([
                                'question_id' => ($c + 1),
                                'audit_log_id' => $request->log_id,
                                'compliance_ans' => $compliance[$c],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($f = 0; $f < count($informants); $f++)
                    {
                        DB::table('audit_field_informant_validation')
                            ->insert
                            ([
                                'audit_id' => $request->log_id,
                                'informant_name' => $informants[$f][0],
                                'relation_subject' => $informants[$f][1],
                                'informant_address' => $informants[$f][2],
                                'informant_existance' => $informants[$f][3],
                                'informant_remarks' => $informants[$f][4],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($t = 0; $t < count($newInformats); $t++)
                    {
                        DB::table('audit_field_new_informants')
                            ->insert
                            ([
                                'audit_id' => $request->log_id,
                                'informants_name' => $newInformats[$t][0],
                                'relation_subject' => $newInformats[$t][1],
                                'address' => $newInformats[$t][2],
                                'remarks' => $newInformats[$t][3],
                                'created_at' => Carbon::now('Asia/Manila'),

                            ]);
                    }

                    DB::table('audits_log')
                        ->where('log_id', $request->log_id)
                        ->update
                        ([
//                            'log_id' => $request->log_id,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Field Checking',
                            'type' => 'audit_field_checking',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 2
                        ]);

                    return response()->json([$getId, 'field', $request->log_id]);
                }

            }
            else if($request->checkPhoneField == 'phone')
            {
                if($request->log_id == null)
                {
//                    $getId = DB::table('audit_field_checking')
//                        ->where('audit_log_id', $request->log_id)
//                        ->select('id')
//                        ->get();

                    $getId = DB::table('audit_phone_checking')
                        ->insertGetId
                        ([
                            'oims_id' => $request->oimsId,
                            'audit_log_id' => $logID,
                            'subj_name' => $request->subjName,
                            'busi_name' => $request->busName,
                            'subj_bus_name' => $request->addRess,
                            'audit_logged' => $request->dateLogged,
                            'auditor_name' => $request->auditName,
                            'findings' => $request->findings,
                            'done_thru' => $request->doneThru,
                            'client_name' => $request->clientName,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->dateEndorsed,
                            'ci_date_visit' => $request->spec,
                            'spec_ins' => $request->spec,
                            'type_of_checking' => $request->toc,
                            'emp_id' => $empDetails,
                            'summary_report' => $request->sum_rep,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    for($c = 0; $c < count($compliance); $c++)
                    {
                        DB::table('audit_phone_compliance_answers')
                            ->insert
                            ([
                                'question_id' => ($c + 1),
                                'audit_log_id' => $logID,
                                'compliance_ans' => $compliance[$c],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($f = 0; $f < count($informants); $f++)
                    {
                        DB::table('audit_phone_informant_validation')
                            ->insert
                            ([
                                'audit_id' => $logID,
                                'informant_name' => $informants[$f][0],
                                'relation_subject' => $informants[$f][1],
                                'informant_address' => $informants[$f][2],
                                'informant_existance' => $informants[$f][3],
                                'informant_remarks' => $informants[$f][4],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($t = 0; $t < count($newInformats); $t++)
                    {
                        DB::table('audit_phone_new_informants')
                            ->insert
                            ([
                                'audit_id' => $logID,
                                'informants_name' => $newInformats[$t][0],
                                'relation_subject' => $newInformats[$t][1],
                                'address' => $newInformats[$t][2],
                                'remarks' => $newInformats[$t][3],
                                'created_at' => Carbon::now('Asia/Manila'),

                            ]);
                    }

                    DB::table('audits_log')
                        ->insert
                        ([
                            'log_id' => $logID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Phone Checking',
                            'type' => 'audit_phone_checking',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 2
                        ]);

                    return response()->json([$getId, 'phone', $logID]);
                }
                else
                {
                    $getId = DB::table('audit_phone_checking')
                        ->where('audit_log_id', $request->log_id)
                        ->select('id')
                        ->get();

                    DB::table('audit_phone_checking')
                        ->where('audit_log_id', $request->log_id)
                        ->update
                        ([
                            'oims_id' => $request->oimsId,
//                            'audit_log_id' => $logID,
                            'subj_name' => $request->subjName,
                            'busi_name' => $request->busName,
                            'subj_bus_name' => $request->addRess,
                            'audit_logged' => $request->dateLogged,
                            'auditor_name' => $request->auditName,
                            'findings' => $request->findings,
                            'done_thru' => $request->doneThru,
                            'client_name' => $request->clientName,
                            'type_of_request' => $request->tor,
                            'endorsement_date' => $request->dateEndorsed,
                            'ci_date_visit' => $request->spec,
                            'spec_ins' => $request->spec,
                            'type_of_checking' => $request->toc,
                            'emp_id' => $empDetails,
                            'summary_report' => $request->sum_rep,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    for($c = 0; $c < count($compliance); $c++)
                    {
                        DB::table('audit_phone_compliance_answers')
                            ->insert
                            ([
                                'question_id' => ($c + 1),
                                'audit_log_id' => $request->log_id,
                                'compliance_ans' => $compliance[$c],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($f = 0; $f < count($informants); $f++)
                    {
                        DB::table('audit_phone_informant_validation')
                            ->insert
                            ([
                                'audit_id' => $request->log_id,
                                'informant_name' => $informants[$f][0],
                                'relation_subject' => $informants[$f][1],
                                'informant_address' => $informants[$f][2],
                                'informant_existance' => $informants[$f][3],
                                'informant_remarks' => $informants[$f][4],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }

                    for($t = 0; $t < count($newInformats); $t++)
                    {
                        DB::table('audit_phone_new_informants')
                            ->insert
                            ([
                                'audit_id' => $request->log_id,
                                'informants_name' => $newInformats[$t][0],
                                'relation_subject' => $newInformats[$t][1],
                                'address' => $newInformats[$t][2],
                                'remarks' => $newInformats[$t][3],
                                'created_at' => Carbon::now('Asia/Manila'),

                            ]);
                    }

                    DB::table('audits_log')
                        ->where('log_id', $request->log_id)
                        ->update
                        ([
//                            'log_id' => $request->log_id,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Saved Audit Phone Checking',
                            'type' => 'audit_phone_checking',
                            'created_at' => Carbon::now('Asia/Manila'),
                            'type_of_save' => 2
                        ]);

                    return response()->json([$getId, 'phone', $request->log_id]);
                }
            }
        }
        else if($request->id != 'new')
        {
            if($request->checkPhoneField == 'field')
            {
//                $getMainId = DB::table('audit_field_checking')
//                    ->where('audit_log_id', $request->id)
//                    ->select('id')
//                    ->get()[0]->id;

                $getdirstInformant = DB::table('audit_field_informant_validation')
                    ->where('audit_id', $request->id)
                    ->select('id')
                    ->first();

                $getfirstNew = DB::table('audit_field_new_informants')
                    ->where('audit_id', $request->id)
                    ->select('id')
                    ->first();

                DB::table('audit_field_checking')
                    ->where('audit_log_id', $request->id)
                    ->update
                    ([
                        'oims_id' => $request->oimsId,
                        'subj_name' => $request->subjName,
                        'busi_name' => $request->busName,
                        'subj_bus_name' => $request->addRess,
                        'audit_logged' => $request->dateLogged,
                        'auditor_name' => $request->auditName,
                        'findings' => $request->findings,
                        'done_thru' => $request->doneThru,
                        'client_name' => $request->clientName,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->dateEndorsed,
                        'ci_date_visit' => $request->spec,
                        'spec_ins' => $request->spec,
                        'type_of_checking' => $request->toc,
                        'emp_id' => $empDetails,
                        'summary_report' => $request->sum_rep,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                for($c = 0; $c < count($compliance); $c++)
                {
                    DB::table('audit_field_compliance_answers')
                        ->where('audit_log_id', $request->log_id)
                        ->where('question_id', ($c + 1))
                        ->update
                        ([
                            'compliance_ans' => $compliance[$c],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($f = 0; $f < count($informants); $f++)
                {
                    DB::table('audit_field_informant_validation')
                        ->where('audit_id',  $request->log_id)
                        ->where('id', (((int)$getdirstInformant->id) + $f))
                        ->update
                        ([
                            'informant_name' => $informants[$f][0],
                            'relation_subject' => $informants[$f][1],
                            'informant_address' => $informants[$f][2],
                            'informant_existance' => $informants[$f][3],
                            'informant_remarks' => $informants[$f][4],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for($t = 0; $t < count($newInformats); $t++)
                {
                    DB::table('audit_field_new_informants')
                        ->where('audit_id', $request->log_id)
                        ->where('id', (($getfirstNew->id)+$t))
                        ->update
                        ([
                            'informants_name' => $newInformats[$t][0],
                            'relation_subject' => $newInformats[$t][1],
                            'address' => $newInformats[$t][2],
                            'remarks' => $newInformats[$t][3],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                DB::table('audits_log')
                    ->where('log_id', $request->log_id)
                    ->update
                    ([
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                return response()->json([$request->log_id, 'field', $request->id]);

            }
            else if($request->checkPhoneField == 'phone')
            {
                $getMainId = DB::table('audit_phone_checking')
                    ->where('audit_log_id', $request->log_id)
                    ->select('id')
                    ->get()[0]->id;

                $getdirstInformant = DB::table('audit_phone_informant_validation')
                    ->where('audit_id', $request->log_id)
                    ->select('id')
                    ->first();

                $getfirstNew = DB::table('audit_phone_new_informants')
                    ->where('audit_id', $request->log_id)
                    ->select('id')
                    ->first();

                DB::table('audit_phone_checking')
                    ->where('audit_log_id', $request->log_id)
                    ->update
                    ([
                        'oims_id' => $request->oimsId,
                        'subj_name' => $request->subjName,
                        'busi_name' => $request->busName,
                        'subj_bus_name' => $request->addRess,
                        'audit_logged' => $request->dateLogged,
                        'auditor_name' => $request->auditName,
                        'findings' => $request->findings,
                        'done_thru' => $request->doneThru,
                        'client_name' => $request->clientName,
                        'type_of_request' => $request->tor,
                        'endorsement_date' => $request->dateEndorsed,
                        'ci_date_visit' => $request->spec,
                        'spec_ins' => $request->spec,
                        'type_of_checking' => $request->toc,
                        'emp_id' => $empDetails,
                        'summary_report' => $request->sum_rep,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                for ($c = 0; $c < count($compliance); $c++) {
                    DB::table('audit_phone_compliance_answers')
                        ->where('audit_log_id', $request->log_id)
                        ->where('question_id', ($c + 1))
                        ->update
                        ([
                            'compliance_ans' => $compliance[$c],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for ($f = 0; $f < count($informants); $f++) {
                    DB::table('audit_phone_informant_validation')
                        ->where('audit_id', $request->log_id)
                        ->where('id', (($getdirstInformant->id) + $f))
                        ->update
                        ([
                            'informant_name' => $informants[$f][0],
                            'relation_subject' => $informants[$f][1],
                            'informant_address' => $informants[$f][2],
                            'informant_existance' => $informants[$f][3],
                            'informant_remarks' => $informants[$f][4],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                for ($t = 0; $t < count($newInformats); $t++)
                {
                    DB::table('audit_phone_new_informants')
                        ->where('audit_id', $request->log_id)
                        ->where('id', (($getfirstNew->id) + $t))
                        ->update
                        ([
                            'informants_name' => $newInformats[$t][0],
                            'relation_subject' => $newInformats[$t][1],
                            'address' => $newInformats[$t][2],
                            'remarks' => $newInformats[$t][3],
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                DB::table('audits_log')
                    ->where('log_id', $request->log_id)
                    ->update
                    ([
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                return response()->json([$getMainId, 'phone', $request->log_id]);
            }
        }
    }

    public function audit_save_update_cssf(Request $request)
    {
//        $file = $request->file('file6');
//        $file->move(storage_path('/audit_ci_report_checking/'), $file->getClientOriginalName());

        $trimmer = new Trimmer();

        $removeScript = new ScriptTrimmer();

        $empDetails = '';

        $getEmp = DB::table('employee_list')
            ->select('id')
            ->where('emp_name', $trimmer->trims($request->ci_l_name . ', ' .$request->ci_f_name))
            ->get();

        if(count($getEmp) > 0)
        {
            $empDetails = $getEmp[0]->id;

            DB::table('employee_list')
                ->where('id', $empDetails)
                ->update
                ([
                    'emp_id' => $request->emp_id,
                    'emp_job' => $request->ci_job_title,
                    'emp_date_hired' => $request->ci_date_hired
                ]);
        }
        else if(count($getEmp) <= 0)
        {
            $empDetails = DB::table('employee_list')
                ->insertGetId
                ([
                    'emp_id' => $request->emp_id,
                    'emp_name' => $trimmer->trims($request->ci_l_name . ', ' .$request->ci_f_name),
                    'emp_job' => $request->ci_job_title,
                    'emp_date_hired' => $request->ci_date_hired
                ]);
        }

        if($request->id == 'new')
        {
            $getlogId = DB::table('audits_log')
                ->count();
            $count = $getlogId + 1;
            $now = Carbon::now('Asia/Manila');
            $now = preg_replace('/[-: ]+/', '', $now);
            $logID = 'audt_'.$now.'_'.$count;

            $total = ((int)$request->completeness + (int)$request->gps_attachment + (int)$request->informants_validity + (int)$request->encoding_accuracy + (int)$request->selfie_uniform_id + (int)$request->tat_compliance + (int)$request->attached_documents);

            if($request->log_id == null)
            {
                DB::table('audit_ci_report_checking')
                    ->insert
                    ([
                        'emp_id' => $empDetails,
                        'log_id' => $logID,
                        'ci_area' => $request->ci_area,
                        'ci_branch_head' => $request->ci_branch_head,
                        'ci_regional_head' => $request->ci_regional_head,
                        'ci_senior_account_officer' => $request->ci_senior_account_officer,
                        'ci_supervisor' => $request->ci_supervisor,
                        'oims_endorse_id' => $request->oims_endorse_id,
                        'messenger_endorse_id' => $request->messenger_endorse_id,
                        'account_name' => $removeScript->scripttrim($request->account_name),
                        'bank_name' => $removeScript->scripttrim($request->bank_name),
                        'endorse_date' => $request->endorse_date,
                        'date_visited' => $request->date_visited,
                        'account_tor' => $removeScript->scripttrim($request->account_tor),
                        'handling_type' => $removeScript->scripttrim($request->handling_type),
                        'account_source' => $removeScript->scripttrim($request->account_source),
                        'completeness' => $request->completeness,
                        'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                        'gps_attachment' => $request->gps_attachment,
                        'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                        'informants_validity' => $request->informants_validity,
                        'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                        'encoding_accuracy' => $request->encoding_accuracy,
                        'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                        'selfie_uniform_id' => $request->selfie_uniform_id,
                        'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                        'tat_compliance' => $request->tat_compliance,
                        'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                        'attached_documents' => $request->attached_documents,
                        'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                        'total_score' => $total,
                        'report_summary' => $removeScript->scripttrim($request->report_summary),
                        'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
//                    'file_path' => $file->getClientOriginalName(),
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);


                DB::table('audits_log')
                    ->insert
                    ([
                        'log_id' => $logID,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved CI Report Checking',
                        'type' => 'ci_report_checking',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'type_of_save' => 2
                    ]);


                return response()->json($logID);
            }
            else
            {
                DB::table('audit_ci_report_checking')
                    ->where('log_id', $request->log_id)
                    ->update
                    ([
                        'emp_id' => $empDetails,
                        'log_id' => $request->log_id,
                        'ci_area' => $request->ci_area,
                        'ci_branch_head' => $request->ci_branch_head,
                        'ci_regional_head' => $request->ci_regional_head,
                        'ci_senior_account_officer' => $request->ci_senior_account_officer,
                        'ci_supervisor' => $request->ci_supervisor,
                        'oims_endorse_id' => $request->oims_endorse_id,
                        'messenger_endorse_id' => $request->messenger_endorse_id,
                        'account_name' => $removeScript->scripttrim($request->account_name),
                        'bank_name' => $removeScript->scripttrim($request->bank_name),
                        'endorse_date' => $request->endorse_date,
                        'date_visited' => $request->date_visited,
                        'account_tor' => $removeScript->scripttrim($request->account_tor),
                        'handling_type' => $removeScript->scripttrim($request->handling_type),
                        'account_source' => $removeScript->scripttrim($request->account_source),
                        'completeness' => $request->completeness,
                        'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                        'gps_attachment' => $request->gps_attachment,
                        'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                        'informants_validity' => $request->informants_validity,
                        'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                        'encoding_accuracy' => $request->encoding_accuracy,
                        'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                        'selfie_uniform_id' => $request->selfie_uniform_id,
                        'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                        'tat_compliance' => $request->tat_compliance,
                        'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                        'attached_documents' => $request->attached_documents,
                        'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                        'total_score' => $total,
                        'report_summary' => $removeScript->scripttrim($request->report_summary),
                        'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
//                    'file_path' => $file->getClientOriginalName(),
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);


                DB::table('audits_log')
                    ->where('log_id', $request->log_id)
                    ([
                        'user_id' => Auth::user()->id,
                        'activity' => 'Saved CI Report Checking',
                        'type' => 'ci_report_checking',
                        'created_at' => Carbon::now('Asia/Manila'),
                        'type_of_save' => 2
                    ]);


                return response()->json($request->log_id);
            }


        }
        else if($request->id != 'new')
        {
            $total = ((int)$request->completeness + (int)$request->gps_attachment + (int)$request->informants_validity + (int)$request->encoding_accuracy + (int)$request->selfie_uniform_id + (int)$request->tat_compliance + (int)$request->attached_documents);

            DB::table('audit_ci_report_checking')
                ->where('log_id', $request->log_id)
                ->update
                ([
                    'emp_id' => $empDetails,
                    'ci_area' => $request->ci_area,
                    'ci_branch_head' => $request->ci_branch_head,
                    'ci_regional_head' => $request->ci_regional_head,
                    'ci_senior_account_officer' => $request->ci_senior_account_officer,
                    'ci_supervisor' => $request->ci_supervisor,
                    'oims_endorse_id' => $request->oims_endorse_id,
                    'messenger_endorse_id' => $request->messenger_endorse_id,
                    'account_name' => $removeScript->scripttrim($request->account_name),
                    'bank_name' => $removeScript->scripttrim($request->bank_name),
                    'endorse_date' => $request->endorse_date,
                    'date_visited' => $request->date_visited,
                    'account_tor' => $removeScript->scripttrim($request->account_tor),
                    'handling_type' => $removeScript->scripttrim($request->handling_type),
                    'account_source' => $removeScript->scripttrim($request->account_source),
                    'completeness' => $request->completeness,
                    'completeness_remarks' => $removeScript->scripttrim($request->completeness_remarks),
                    'gps_attachment' => $request->gps_attachment,
                    'gps_attachment_remarks' => $removeScript->scripttrim($request->gps_attachment_remarks),
                    'informants_validity' => $request->informants_validity,
                    'informants_validity_remarks' => $removeScript->scripttrim($request->informants_validity_remarks),
                    'encoding_accuracy' => $request->encoding_accuracy,
                    'encoding_accuracy_remarks' => $removeScript->scripttrim($request->encoding_accuracy_remarks),
                    'selfie_uniform_id' => $request->selfie_uniform_id,
                    'selfie_uniform_id_remarks' => $removeScript->scripttrim($request->selfie_uniform_id_remarks),
                    'tat_compliance' => $request->tat_compliance,
                    'tat_compliance_remarks' => $removeScript->scripttrim($request->tat_compliance_remarks),
                    'attached_documents' => $request->attached_documents,
                    'attached_documents_remarks' => $removeScript->scripttrim($request->attached_documents_remarks),
                    'total_score' => $total,
                    'report_summary' => $removeScript->scripttrim($request->report_summary),
                    'cause_of_delay' => $removeScript->scripttrim($request->cause_of_delay),
//                    'file_path' => $file->getClientOriginalName(),
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);


            DB::table('audits_log')
                ->where('log_id', $request->id)
                ->update
                ([
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            return $request->id;
        }
    }

    public function audit_get_remarks_return(Request $request)
    {
        $getRem = DB::table('audits_log')
            ->where('log_id', $request->id)
            ->select('return_remarks', 'return_date_time')
            ->get();

        return response()->json($getRem);
    }

    public function audit_tab6_upload(Request $request)
    {
        $file = $request->file('file6');
        $exten = $file->getClientOriginalExtension();

        if($exten == 'pdf')
        {
            $name = $request->log_id . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('/audit_ci_report_checking/' . $request->log_id . '/'), $name);
            $path = '/audit_ci_report_checking/' . $request->log_id . '/' . $name;

            DB::table('audit_ci_report_checking')
                ->where('log_id', $request->log_id)
                ->update
                ([
                    'file_path' => $path
                ]);

            return response()->json([$path, $request->log_id]);
        }
    }

    public function audit_upload_arf(Request $request)
    {
        $file = $request->file('file');

        if($request->type == 'audit')
        {
            $getLogId = DB::table('audit_report_form')
                ->select('audit_log_id')
                ->where('id', $request->id)
                ->get()[0]->audit_log_id;

            if($file != null)
            {
                $name =  $getLogId . '.' .$file->getClientOriginalExtension();
                $file->move(storage_path('/audit_arf_files/' . $getLogId . '/'), $name);
                $path = '/audit_arf_files/' . $getLogId . '/' . $name;

                DB::table('audit_report_form')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'file_path' => $path
                    ]);

                return response()->json([$path, $getLogId]);
            }
        }
        else if($request->type == 'desc')
        {
            $getLogId = DB::table('descrepancy_form_audit')
                ->select('audit_log_id')
                ->where('id', $request->id)
                ->get()[0]->audit_log_id;

            if($file != null)
            {
                $name =  $getLogId . '.' .$file->getClientOriginalExtension();
                $file->move(storage_path('/audit_descrepancy_files/' . $getLogId . '/'), $name);
                $path = '/audit_descrepancy_files/' . $getLogId . '/' . $name;

                DB::table('descrepancy_form_audit')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'file_path' => $path
                    ]);

                return response()->json([$path, $getLogId]);
            }
        }
    }

    public function audit_insert_file_pf(Request $request)
    {
        $file = $request->file('file');

        if($request->type == 'field')
        {
            $getLogID = DB::table('audit_field_checking')
                ->select('audit_log_id')
                ->where('id', $request->id)
                ->get()[0]->audit_log_id;

            if($file != null)
            {
                $name = $getLogID . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('/audit_field_files/' . $getLogID . '/'), $name);
                $path = '/audit_field_files/' . $getLogID . '/' . $name;

                DB::table('audit_field_checking')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'file_path' => $path
                    ]);

                return response()->json([$path, $getLogID]);
            }
        }
        else if($request->type == 'phone')
        {
            $getLogID = DB::table('audit_phone_checking')
                ->select('audit_log_id')
                ->where('id', $request->id)
                ->get()[0]->audit_log_id;

            if($file != null)
            {
                $name = $getLogID . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('/audit_phone_files/' . $getLogID . '/'), $name);
                $path = '/audit_phone_files/' . $getLogID . '/' . $name;

                DB::table('audit_phone_checking')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'file_path' => $path
                    ]);

                return response()->json([$path, $getLogID]);
            }
        }
    }

    public function audit_partial_logs_table()
    {
        $getGeneralLogs = DB::table('audits_log')
            ->join('users', 'users.id', '=', 'audits_log.user_id')
            ->leftjoin('audit_report_form', 'audit_report_form.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('descrepancy_form_audit', 'descrepancy_form_audit.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_field_checking', 'audit_field_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_phone_checking', 'audit_phone_checking.audit_log_id', '=', 'audits_log.log_id')
            ->leftjoin('audit_ci_report_checking', 'audit_ci_report_checking.log_id', '=', 'audits_log.log_id')
            ->leftjoin('employee_list as emp_1', 'emp_1.id', '=', 'audit_report_form.emp_id')
            ->leftjoin('employee_list as emp_2', 'emp_2.id', '=', 'descrepancy_form_audit.emp_id')
            ->leftjoin('employee_list as emp_3', 'emp_3.id', '=', 'audit_field_checking.emp_id')
            ->leftjoin('employee_list as emp_4', 'emp_4.id', '=', 'audit_phone_checking.emp_id')
            ->leftjoin('employee_list as emp_5', 'emp_5.id', '=', 'audit_ci_report_checking.emp_id')
            ->select([
                'audits_log.log_id as id',
                'audits_log.reviewer_id as rev_id',
                'audits_log.created_at as date_time',
//                'users.name as name',
                'audit_report_form.emp_id as emp_arf',
                'descrepancy_form_audit.emp_id as emp_desc',
                'audit_field_checking.emp_id as emp_field',
                'audit_phone_checking.emp_id as emp_phone',
                'audit_ci_report_checking.emp_id as emp_cssf',
                'audits_log.activity as activity',
                'audits_log.type as type',
                'audits_log.audit_status as status',
                'audits_log.audit_status as status2',
                'emp_1.emp_name',
                'emp_2.emp_name',
                'emp_3.emp_name',
                'emp_4.emp_name',
                'emp_5.emp_name',
                'audits_log.type_of_save as save_type'
            ])
            ->where('audits_log.user_id', Auth::user()->id)
            ->where('audits_log.type_of_save', 2);

        return DataTables::of($getGeneralLogs)
            ->editcolumn('employee', function($query)
            {
                $empID = '';
                if($query->emp_arf != null)
                {
                    $empID = $query->emp_arf;
                }
                else if($query->emp_desc != null)
                {
                    $empID = $query->emp_desc;
                }
                else if($query->emp_field != null)
                {
                    $empID = $query->emp_field;
                }
                else if($query->emp_phone != null)
                {
                    $empID = $query->emp_phone;
                }
                else if($query->emp_cssf != null)
                {
                    $empID = $query->emp_cssf;
                }

                $getEmpName = DB::table('employee_list')
                    ->select('emp_name')
                    ->where('id', $empID)
                    ->get()[0]->emp_name;

                $testname = strtolower($getEmpName);

                $newName = ucwords($testname);

                return $newName;
            })
            ->editColumn('status', function ($query)
            {
                $getRevName = DB::table('users')
                    ->where('id', $query->rev_id)
                    ->select('name')
                    ->get();

                if($query->status == 0)
                {
                    return 'Partial Report';
                }
            })
            ->rawColumns
            ([
                'employee',
                'status'
            ])
            ->toJson();
    }

    public function audit_get_return_notif_count()
    {
        $getNotif = DB::table('audits_log')
            ->select('notif_stat')
            ->where('user_id', Auth::user()->id)
            ->get();

        $countNotif = 0;

        if(count($getNotif) > 0)
        {
            foreach($getNotif as $notif)
            {
                $countNotif += $notif->notif_stat;
            }
        }
        else
        {
            $countNotif = 0;
        }

        return response()->json($countNotif);
    }

    public function audit_clear_return_notif()
    {
        DB::table('audits_log')
            ->where('user_id', Auth::user()->id)
            ->update
            ([
                'notif_stat' => 0
            ]);

        $getNotif = DB::table('audits_log')
            ->select('notif_stat')
            ->where('user_id', Auth::user()->id)
            ->get();

        $countNotif = 0;

        if(count($getNotif) > 0)
        {
            foreach($getNotif as $notif)
            {
                $countNotif += $notif->notif_stat;
            }
        }
        else
        {
            $countNotif = 0;
        }

        return response()->json($countNotif);
    }

    public function audit_discrepancy_fine_uploader(Request $request, $get_id)
    {
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
                    $result = $uploader->combineChunks(('audit_arf_files/'.$get_id.'/'));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('audit_arf_files/'.$get_id.'/')))
                {
                    File::makeDirectory(storage_path('audit_arf_files/'.$get_id.'/'));
                }
                $result = $uploader->handleUpload(storage_path('audit_arf_files/'.$get_id.'/'));
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

    public function audit_set_fine_uploader(Request $request)
    {
        $getlogId = DB::table('audits_log')
            ->count();
        $count = $getlogId + 1;
        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);
        $logID = 'audt_'.$now.'_'.$count;

        if($request->what == 'audit_ci_report_checking')
        {
            DB::table($request->what)
                ->insert([
                    'log_id' => $logID
                ]);
        }
        else
        {
            DB::table($request->what)
                ->insert([
                    'audit_log_id' => $logID
                ]);
        }



        DB::table('audits_log')
            ->insert([
               'log_id' => $logID
            ]);

        return $logID;
    }

    public function audit_view_attached(Request $request, $log_id  ,$file_name)
    {
        if(Auth::user() != null)
        {
            if(Auth::user()->hasRole('Audit'))
            {
                $decoded_log_id = base64_decode($log_id);
                $decoded_file_name = base64_decode($file_name);

                $path = storage_path('audit_arf_files/'.$decoded_log_id.'/'.$decoded_file_name);

                if (!File::exists($path)) {
                    abort(404);
                }

                $file = File::get($path);
                $type_a = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type_a);

                return $response;
            }
            else
            {
                abort(404);
            }
        }
        else
        {
            abort(404);
        }
    }

    public function audit_view_attached_ci_rep(Request $request, $log_id  ,$file_name)
    {
        if(Auth::user() != null)
        {
            if(Auth::user()->hasRole('Audit'))
            {
                $decoded_log_id = base64_decode($log_id);
                $decoded_file_name = base64_decode($file_name);

                $path = storage_path('audit_ci_report_checking/'.$decoded_log_id.'/'.$decoded_file_name);

                if (!File::exists($path)) {
                    abort(404);
                }

                $file = File::get($path);
                $type_a = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type_a);

                return $response;
            }
            else
            {
                abort(404);
            }
        }
        else
        {
            abort(404);
        }
    }

    public function audit_view_attached_field(Request $request, $log_id  ,$file_name)
    {
        if(Auth::user() != null)
        {
            if(Auth::user()->hasRole('Audit'))
            {
                $decoded_log_id = base64_decode($log_id);
                $decoded_file_name = base64_decode($file_name);

                $path = storage_path('audit_field_files/'.$decoded_log_id.'/'.$decoded_file_name);

                if (!File::exists($path)) {
                    abort(404);
                }

                $file = File::get($path);
                $type_a = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type_a);

                return $response;
            }
            else
            {
                abort(404);
            }
        }
        else
        {
            abort(404);
        }
    }

    public function audit_cirep_fine_uploader(Request $request, $get_id)
    {
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
                $result = $uploader->combineChunks(('audit_ci_report_checking/'.$get_id.'/'));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('audit_ci_report_checking/'.$get_id.'/')))
                {
                    File::makeDirectory(storage_path('audit_ci_report_checking/'.$get_id.'/'));
                }
                $result = $uploader->handleUpload(storage_path('audit_ci_report_checking/'.$get_id.'/'));
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

    public function audit_field_fine_uploader(Request $request, $get_id)
    {
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
                $result = $uploader->combineChunks(('audit_field_files/'.$get_id.'/'));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('audit_field_files/'.$get_id.'/')))
                {
                    File::makeDirectory(storage_path('audit_field_files/'.$get_id.'/'));
                }
                $result = $uploader->handleUpload(storage_path('audit_field_files/'.$get_id.'/'));
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
    
    public function audit_get_general_mon_table_ccbank(Request $request)
    {
        $ver_status = $request->ver_stats;
        $sent_stats = $request->sent_stats;
        $tele_id = $request->tele_id;
        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
            ->join('users as tele_name', 'tele_name.id', '=' , 'bi_endorsements_users.users_id')
            ->select([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.acct_report_status as status_report',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.date_time_finished as date_time_finished',
                'bi_endorsements.date_time_due as date_time_due',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status',
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check',
                'users.id'
            ])
            ->groupBy('bi_endorsements.id')
//            ->where('bi_endorsements_users.position_id',14)
            ->where(function($query) use($tele_id)
            {
                if($tele_id == '' || $tele_id == null)
                {
                    return $query->where('bi_endorsements_users.position_id', 14);
                }
                else
                {
                    return $query->where('bi_endorsements_users.position_id', 17)
                        ->where('tele_name.id', $tele_id);
                }
            })
            ->whereDate('bi_endorsements.created_at', '<=', $request->max_date_endorsed)
            ->whereDate('bi_endorsements.created_at', '>=', $request->min_date_endorsed)
            ->where(function($query) use($ver_status)
            {
                if($ver_status != '')
                {
                    return $query->where('bi_endorsements.acct_report_status', '=', $ver_status);
                }
            })
            ->where(function($query) use($sent_stats)
            {
                if($sent_stats != '')
                {
                    if($sent_stats == 'ON-TAT')
                    {
                        return $query->where('bi_endorsements.status', '=', '10')
                            ->whereDate('bi_endorsements.date_time_finished', '<', 'bi_endorsements.created_at');
                    }
                    else if($sent_stats == 'LATE')
                    {
                        return $query->where('bi_endorsements.status', '=', '10')
                            ->whereDate('bi_endorsements.date_time_finished', '>', 'bi_endorsements.created_at');
                    }
                }
            })
            ->where('users.client_check','=', 'cc_bank')
            ->where('bi_endorsements.type_of_endorsement_bank','!=', '')
            ->where('bi_endorsements.status', '!=', 1999);

        return DataTables::of($get_general_table)
            ->editColumn('attachments', function ($query)
            {
                $get_attachment = DB::table('bi_endorsements')
                    ->select([
                        'bi_endorsements.attach_1 as attach_1',
                        'bi_endorsements.attach_2 as attach_2',
                        'bi_endorsements.attach_3 as attach_3',
                        'bi_endorsements.attach_4 as attach_4',
                    ])
                    ->where('bi_endorsements.id',$query->endorse_id)
                    ->get();

                if(count($get_attachment) == 0)
                {
                    return 'NO ATTACHMENT';
                }
                else
                {
                    $downloads = '';

                    if($get_attachment[0]->attach_1 != '')
                    {
                        $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>1. none</p>';
                    }

                    if($get_attachment[0]->attach_2 != '')
                    {
                        $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>2. none</p>';
                    }

                    if($get_attachment[0]->attach_3 != '')
                    {
                        $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>3. none</p>';
                    }

                    if($get_attachment[0]->attach_4 != '')
                    {
                        $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>4. none</p>';
                    }
                    return $downloads;
                }
            })
            ->editColumn('due', function($get_general_table)
            {
                $thisShow = '';
                $testVal1 = $get_general_table->attach_1;
                $testVal2 = $get_general_table->attach_2;
                $testVal3 = $get_general_table->attach_3;
                $testVal4 = $get_general_table->attach_4;
                $checkDownloaded = DB::table('bi_logs')
                    ->where('endorse_id', '=', $get_general_table->endorse_id)
                    ->where('position_id', '=', 17)
                    ->where(function($query) use ($testVal1, $testVal2, $testVal3, $testVal4)
                    {
                        return $query->where('activity', '=', 'DOWNLOADED ATTACHMENT 1 : '. $testVal1)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 2 : '. $testVal2)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 3 : '. $testVal3)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 4 : '. $testVal4);
                    })
                    ->get();

                if(count($checkDownloaded) > 0)
                {
                    $thisShow = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-cloud-download"></i> Downloaded By Televerifier</a>';
                }
                else
                {
                    $thisShow = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-refresh"></i> Processing</a>';
                }

                if($get_general_table->cancel_status == 'Cancelled')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                }
                else if($get_general_table->cancel_status == 'Pending Cancel')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Cancellation Account</a>';
                }
                else if($get_general_table->cancel_status == 'Pending Revoke')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Revoke Cancellation Account</a>';
                }
                else
                {
                    if($get_general_table->status == 0)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                    }
                    else if ($get_general_table->status == 20)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>'.$thisShow;
                    }
                    else if ($get_general_table->status == 22)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>'.$thisShow;
                    }
                    else if ($get_general_table->status == 23)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>'. $thisShow;
                    }
                    else if ($get_general_table->status == 24)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>' .$thisShow;
                    }
                    else if ($get_general_table->status == 25)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>' .$thisShow;
                    }

                    else if ($get_general_table->status == 5)
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> On-Hold Account</a>';
                    }
                    else if ($get_general_table->status == 4)
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                    }
                    else if ($get_general_table->status == 21)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Re-Endorsed Account</a>';
                    }
                    else if ($get_general_table->status == 1)
                    {

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' .$thisShow ;
                    }
                    else if ($get_general_table->status == 10)
                    {

                        if($get_general_table->client_check == 'cc_bank')
                        {
                            if($get_general_table->status_report == 'Contacted')
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                           else if($get_general_table->status_report == 'Verified')
                            {
                                return  '<a class="btn btn-xs btn-success btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                           else if($get_general_table->status_report == 'Unverified')
                            {
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                            else
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>';
                            }
                        }
                        else
                        {
                            if($get_general_table->status_report == 'Complete')
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                            else {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>';
                            }
                        }


                    }
                    else if($get_general_table->status == 2)
                    {
//                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);
//
//                        $now = Carbon::now('Asia/Manila');
//                        $datenowexplode = explode(" ",$now);
//                        $hoursexplode = explode(":", $datenowexplode[1]);
//                        $arrayExpHoursnow = $hoursexplode[0];
//                        $arrayExpMinutesnow = $hoursexplode[1];
//
//                        $datenowexplode1 = explode(" ",$get_general_table->due);
//                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
//                        $arrayExpHoursdb = $hoursexplode1[0];
//                        $arrayExpMinutesdb = $hoursexplode1[1];
//
//                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
//                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;
//
//                        $getminute = 0;
//
//                        if($remaininghour < 0)
//                        {
//                            $remaininghour = $remaininghour + 24;
//                        }
//                        if($remainningmins < 0)
//                        {
//                            $getminute = $remainningmins +60;
//                        }
//
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);

                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>' . $thisShow;

                        return $assigned;
//                        if($difference_days <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                    else if($get_general_table->status == 3)
                    {
//                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);
//
//                        $now = Carbon::now('Asia/Manila');
//                        $datenowexplode = explode(" ",$now);
//                        $hoursexplode = explode(":", $datenowexplode[1]);
//                        $arrayExpHoursnow = $hoursexplode[0];
//                        $arrayExpMinutesnow = $hoursexplode[1];
//
//                        $datenowexplode1 = explode(" ",$get_general_table->due);
//                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
//                        $arrayExpHoursdb = $hoursexplode1[0];
//                        $arrayExpMinutesdb = $hoursexplode1[1];
//
//                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
//                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;
//
//                        $getminute = 0;
//
//                        if($remaininghour < 0)
//                        {
//                            $remaininghour = $remaininghour + 24;
//                        }
//                        if($remainningmins < 0)
//                        {
//                            $getminute = $remainningmins +60;
//                        }
//
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>' . $thisShow;

                        return $succveri;

//                        if($difference_days <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                }

            })
            ->editcolumn('assigned_tele', function($query)
            {
                $getTeleName = DB::table('bi_endorsements_users')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    ->select
                    ([
                        'users.name as user'
                    ])
                    ->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.bi_endorse_id', $query->endorse_id)
                    ->get();

                if(count($getTeleName) > 0)
                {
                    return $getTeleName[0]->user;
                }
                else
                {
                    return 'N/A';
                }
            })
            ->editcolumn('assigned_tele_level', function($query)
            {
                $getTeleName = DB::table('bi_endorsements_users')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    ->select
                    ([
                        'users.id as user_id'
                    ])
                    ->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.bi_endorse_id', $query->endorse_id)
                    ->get();

                if(count($getTeleName) > 0)
                {
                    $getLevel = DB::table('cc_tele_levels')
                        ->where('user_id', '=', $getTeleName[0]->user_id)
                        ->select('level')
                        ->get();

                    if(count($getLevel) > 0)
                    {
                        return 'Level '. $getLevel[0]->level;
                    }
                    else
                    {
                        return 'Level 1';
                    }
                }
                else
                {
                    return 'N/A';
                }


            })
            ->rawColumns([
                'attachments',
                'due',
                'assigned_tele_level'
            ])
            ->make(true);
    }

    public function audit_get_general_mon_table_cc(Request $request)
    {
        $ver_status = $request->ver_stats;
        $sent_stats = $request->sent_stats;
        $tele_id = $request->tele_id;
        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
            ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
            ->select([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.acct_report_status as status_report',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.date_time_finished as date_time_finished',
                'bi_endorsements.date_time_due as date_time_due',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status',
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check',
                'users.id'
            ])
            ->groupBy('bi_endorsements.id')
//            ->where('bi_endorsements_users.position_id',14)
            ->where(function($query) use($tele_id)
            {
                if($tele_id == '' || $tele_id == null)
                {
                    return $query->where('bi_endorsements_users.position_id', 14);
                }
                else
                {
                    return $query->where('bi_endorsements_users.position_id', 17)
                        ->where('bi_endorsements_users.users_id', $tele_id);
                }
            })
            ->whereDate('bi_endorsements.created_at', '<=', $request->max_date_endorsed)
            ->whereDate('bi_endorsements.created_at', '>=', $request->min_date_endorsed)
            ->where(function($query) use($ver_status)
            {
                if($ver_status != '')
                {
                    return $query->where('bi_endorsements.acct_report_status', '=', $ver_status);
                }
            })
            ->where(function($query) use($sent_stats)
            {
                if($sent_stats != '')
                {
                    if($sent_stats == 'ON-TAT')
                    {
                        return $query->where('bi_endorsements.status', '=', '10')
                            ->whereDate('bi_endorsements.date_time_finished', '<', 'bi_endorsements.created_at');
                    }
                    else if($sent_stats == 'LATE')
                    {
                        return $query->where('bi_endorsements.status', '=', '10')
                            ->whereDate('bi_endorsements.date_time_finished', '>', 'bi_endorsements.created_at');
                    }
                }
            })
            ->where('users.client_check','!=', 'cc_bank')
            ->where(function($query)
            {
                return $query->where('bi_endorsements.type_of_endorsement_bank','=', '')
                    ->orwhere('bi_endorsements.type_of_endorsement_bank','=', null);
            })
            ->where('bi_endorsements.status', '!=', 1999);

        return DataTables::of($get_general_table)
            ->editColumn('attachments', function ($query)
            {
                $get_attachment = DB::table('bi_endorsements')
                    ->select([
                        'bi_endorsements.attach_1 as attach_1',
                        'bi_endorsements.attach_2 as attach_2',
                        'bi_endorsements.attach_3 as attach_3',
                        'bi_endorsements.attach_4 as attach_4',
                    ])
                    ->where('bi_endorsements.id',$query->endorse_id)
                    ->get();

                if(count($get_attachment) == 0)
                {
                    return 'NO ATTACHMENT';
                }
                else
                {
                    $downloads = '';

                    if($get_attachment[0]->attach_1 != '')
                    {
                        $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>1. none</p>';
                    }

                    if($get_attachment[0]->attach_2 != '')
                    {
                        $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>2. none</p>';
                    }

                    if($get_attachment[0]->attach_3 != '')
                    {
                        $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>3. none</p>';
                    }

                    if($get_attachment[0]->attach_4 != '')
                    {
                        $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                    }
                    else
                    {
                        $downloads .='<p>4. none</p>';
                    }
                    return $downloads;
                }
            })
            ->editColumn('due', function($get_general_table)
            {
                $thisShow = '';
                $testVal1 = $get_general_table->attach_1;
                $testVal2 = $get_general_table->attach_2;
                $testVal3 = $get_general_table->attach_3;
                $testVal4 = $get_general_table->attach_4;
                $checkDownloaded = DB::table('bi_logs')
                    ->where('endorse_id', '=', $get_general_table->endorse_id)
                    ->where('position_id', '=', 17)
                    ->where(function($query) use ($testVal1, $testVal2, $testVal3, $testVal4)
                    {
                        return $query->where('activity', '=', 'DOWNLOADED ATTACHMENT 1 : '. $testVal1)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 2 : '. $testVal2)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 3 : '. $testVal3)
                            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 4 : '. $testVal4);
                    })
                    ->get();

                if(count($checkDownloaded) > 0)
                {
                    $thisShow = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-cloud-download"></i> Downloaded By Televerifier</a>';
                }
                else
                {
                    $thisShow = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-refresh"></i> Processing</a>';
                }

                if($get_general_table->cancel_status == 'Cancelled')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                }
                else if($get_general_table->cancel_status == 'Pending Cancel')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Cancellation Account</a>';
                }
                else if($get_general_table->cancel_status == 'Pending Revoke')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Revoke Cancellation Account</a>';
                }
                else
                {
                    if($get_general_table->status == 0)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                    }
                    else if ($get_general_table->status == 20)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>'.$thisShow;
                    }
                    else if ($get_general_table->status == 22)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>'.$thisShow;
                    }
                    else if ($get_general_table->status == 23)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>'. $thisShow;
                    }
                    else if ($get_general_table->status == 24)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>' .$thisShow;
                    }
                    else if ($get_general_table->status == 25)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>' .$thisShow;
                    }

                    else if ($get_general_table->status == 5)
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> On-Hold Account</a>';
                    }
                    else if ($get_general_table->status == 4)
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                    }
                    else if ($get_general_table->status == 21)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Re-Endorsed Account</a>';
                    }
                    else if ($get_general_table->status == 1)
                    {

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' .$thisShow ;
                    }
                    else if ($get_general_table->status == 10)
                    {

                        if($get_general_table->client_check == 'cc_bank')
                        {
                            if($get_general_table->status_report == 'Contacted')
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                            else
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>';
                            }
                        }
                        else
                        {
                            if($get_general_table->status_report == 'Complete')
                            {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
                            }
                            else {
//                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>'.
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>';
                            }
                        }


                    }
                    else if($get_general_table->status == 2)
                    {
//                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);
//
//                        $now = Carbon::now('Asia/Manila');
//                        $datenowexplode = explode(" ",$now);
//                        $hoursexplode = explode(":", $datenowexplode[1]);
//                        $arrayExpHoursnow = $hoursexplode[0];
//                        $arrayExpMinutesnow = $hoursexplode[1];
//
//                        $datenowexplode1 = explode(" ",$get_general_table->due);
//                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
//                        $arrayExpHoursdb = $hoursexplode1[0];
//                        $arrayExpMinutesdb = $hoursexplode1[1];
//
//                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
//                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;
//
//                        $getminute = 0;
//
//                        if($remaininghour < 0)
//                        {
//                            $remaininghour = $remaininghour + 24;
//                        }
//                        if($remainningmins < 0)
//                        {
//                            $getminute = $remainningmins +60;
//                        }
//
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);

                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>' . $thisShow;

                        return $assigned;
//                        if($difference_days <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                    else if($get_general_table->status == 3)
                    {
//                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);
//
//                        $now = Carbon::now('Asia/Manila');
//                        $datenowexplode = explode(" ",$now);
//                        $hoursexplode = explode(":", $datenowexplode[1]);
//                        $arrayExpHoursnow = $hoursexplode[0];
//                        $arrayExpMinutesnow = $hoursexplode[1];
//
//                        $datenowexplode1 = explode(" ",$get_general_table->due);
//                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
//                        $arrayExpHoursdb = $hoursexplode1[0];
//                        $arrayExpMinutesdb = $hoursexplode1[1];
//
//                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
//                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;
//
//                        $getminute = 0;
//
//                        if($remaininghour < 0)
//                        {
//                            $remaininghour = $remaininghour + 24;
//                        }
//                        if($remainningmins < 0)
//                        {
//                            $getminute = $remainningmins +60;
//                        }
//
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>' . $thisShow;

                        return $succveri;
//                        if($difference_days <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                }

            })
            ->editcolumn('assigned_tele', function($query)
            {
                $getTeleName = DB::table('bi_endorsements_users')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    ->select
                    ([
                        'users.name as user'
                    ])
                    ->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.bi_endorse_id', $query->endorse_id)
                    ->get();

                if(count($getTeleName) > 0)
                {
                    return $getTeleName[0]->user;
                }
                else
                {
                    return 'N/A';
                }
            })
            ->editcolumn('assigned_tele_level', function($query)
            {
                $getTeleName = DB::table('bi_endorsements_users')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    ->select
                    ([
                        'users.id as user_id'
                    ])
                    ->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.bi_endorse_id', $query->endorse_id)
                    ->get();

                if(count($getTeleName) > 0)
                {
                    $getLevel = DB::table('cc_tele_levels')
                        ->where('user_id', '=', $getTeleName[0]->user_id)
                        ->select('level')
                        ->get();

                    if(count($getLevel) > 0)
                    {
                        return 'Level '. $getLevel[0]->level;
                    }
                    else
                    {
                        return 'Level 1';
                    }
                }
                else
                {
                    return 'N/A';
                }


            })
            ->rawColumns([
                'attachments',
                'due',
                'assigned_tele',
                'assigned_tele_level'
            ])
            ->make(true);
    }
}