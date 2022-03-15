<?php

namespace App\Http\Controllers;

use App\Generals\AuditFundQueries;
use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\SmsNotification;
use App\Generals\Trimmer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_IOFactory;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;

class FinanceController extends Controller
{
    public function getFinanceDashboard()
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
            } elseif (Auth::user()->hasRole('Finance')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('finance.finance-dashboard', compact('timeStamp'))->with(["page" => "finance-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getFinancePanel()
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
            } elseif (Auth::user()->hasRole('Finance')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

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


                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                $banks_billing = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 6)
                    ->where('users.archive', 'False')
                    ->where('users.client_check', 'client_branch')
                    ->get();

                $bi_client = DB::table('bi_account_to_users')
                    ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                    ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
                    ->groupBy('bi_account_to_users.bi_account_id')
                    ->orderBy('bi_account_to_users.id', 'desc')
                    ->where(function($query)
                    {
                        return $query->orwhere('users.client_check', '=', 'tat_selector')
                            ->orwhere('users.client_check', '=', '')
                            ->orwhere('users.client_check', '=', null)
                            ->where('users.client_check', '!=', 'cc_bank');
                    })
                    ->where('bi_account_to_users.to_display', '=', 'display')
                    // ->where('users.client_check', '!=', 'cc_bank')
                    ->select([
                        'bi_account_to_users.bi_account_id',
                        DB::raw('CONCAT(bi_account_list.bi_account_name, " ", bi_account_list.account_location) AS site_name'),
                        'users.client_check as client_check'
                    ])
                    ->get();

                $bi_client_bank = DB::table('bi_account_to_users')
                    ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                    ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
                    ->where('users.client_check', '=', 'cc_bank')
                    ->groupBy('bi_account_to_users.bi_account_id')
                    ->orderBy('bi_account_to_users.id', 'desc')
                    ->select([
                        'bi_account_to_users.bi_account_id',
                        DB::raw('CONCAT(bi_account_list.bi_account_name, " ", bi_account_list.account_location) AS site_name'),
                        'users.client_check as client_check'
                    ])
                    ->get();

                return view('finance.finance-master', compact('timeStamp','ciLists','javs','banks_billing', 'bi_client', 'bi_client_bank'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getFinanceReport()
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
            } elseif (Auth::user()->hasRole('Finance')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];



                return view('finance.finance-report', compact('timeStamp'))->with(["page" => "finance-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function tableGetFinanceReportTable(Request $request)
    {
        $client_id = $request->client_id;
        $max_endorse_date = $request->max_date_endorsed;
        $min_endorse_date = $request->min_date_endorsed;

        $reportTable = DB::table('endorsements')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->leftJoin('endorsement_user','endorsement_user.endorsement_id','=','endorsements.id')
//            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.account_name',
                    'endorsements.address',
                    'municipalities.muni_name',
                    'endorsements.provinces',
                    'endorsements.type_of_request',
                    'endorsements.type_of_request as tor',
                    'endorsements.client_name',
                    'endorsements.endorsement_status_external',
                    'endorsements.picture_status',
                    'endorsements.rate',
                    'endorsements.re_ci',
                    'endorsements.date_forwarded_to_client',
                    'endorsements.time_forwarded_to_client',
                    'endorsements.bill',
                    'endorsements.appliedrule',
                    'endorsement_user.client_id as client_id'
//                    'employers.employer_name as evr_name',
//                    'businesses.business_name as bvr_name',
                ]
            )
            ->where('endorsement_user.client_id', $client_id)
            ->where('endorsements.date_endorsed', '<=', $max_endorse_date)
            ->where('endorsements.date_endorsed', '>=',$min_endorse_date);

        return DataTables::of($reportTable)
            ->editColumn('type_of_request', function ($query)
            {
                if($query->type_of_request == 'PDRN')
                {
                    return '<span id = "multi_tor-'.$query->id.'"><b>PDRN</b></span>';
                }
                else if($query->type_of_request == 'BVR')
                {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<span id = "multi_tor-'.$query->id.'"><b>BVR:<br></b>'.$getinfo[0]->business_name.'</br></span>';

                }
                else if($query->type_of_request == 'EVR')
                {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<span id = "multi_tor-'.$query->id.'"><b>EVR:<br></b>'.$getinfo[0]->employer_name.'</br></span>';
                }
                else
                {
                    return '';
                }
            })
            ->rawColumns(['type_of_request'])
            ->make(true);
    }

    public function getFinanceCIFund()
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
            } elseif (Auth::user()->hasRole('Finance')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('finance.finance-ci-fund-request', compact('timeStamp'))->with(["page" => "finance-ci-fund-request"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function financeGetViewAtmMngt()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
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
            elseif (Auth::user()->hasRole('Finance'))
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

                return view('finance.finance-ci-atm-management',compact('ciLists'))->with(["page" => "finance-ci-atm-management"]);
            }
            return redirect()->route('privilege-error');
        }
    }


    public function getCiFundRequest()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->join('users as sao_id','sao_id.id','=','fund_requests.sao_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select(
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'sao_id.name as name_sao',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as dispatcher_remarks',
                    'fund_requests.sao_remarks as sao_remarks',
                    'fund_requests.dispatcher_request_date as dispatcher_request_date',
                    'fund_requests.sao_approved_date as sao_approved_date',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where('fund_requests.dispatcher_status','ON-PROCESS')
            ->where('fund_requests.sao_status','APPROVED')
            ->where('fund_requests.finance_status','');

        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('finance_pending_fund_details_endorsements/' . $b->id);
            })
            ->make(true);
    }

    public function getCiFundRequestApproved()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
//            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
            ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
            ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
            ->select(
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'sao_id.name as name_sao',
                    'manage_approved_id.name as manage_name',
//                    'finance_id.name as name_finance',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as dispatcher_remarks',
                    'fund_requests.sao_remarks as sao_remarks',
                    'fund_requests.finance_remarks as finance_remarks',
                    'fund_requests.date_time_remarks as date_time_remarks',
                    'fund_requests.dispatcher_request_date as dispatcher_request_date',
                    'fund_requests.sao_approved_date as sao_approved_date',
                    'fund_requests.finance_approved_date as finance_approved_date',
                    'fund_requests.delivered_date as delivered_date',
                    'fund_requests.type_of_fund_request',
                    'fund_requests.ci_id as ci_id',
                    'ci_atms.bank_name as shell_card',
                    'ci_shell_card_info.shell_card as get_shell',
                    'ci_atms.account_number as account_number',
                    'ci_atms.id as shell_card_id',
                    'remittance.receive_status as receive_status',
                    'remittance.branch_name as branch_name',
                    'remittance.remittance_info as remittance_info',
                    'remittance.code as code',
                    'ci_atm_fund.receive_status as receive_status_atm',
                    'ci_shell_include_fund.receive_status as receive_status_shell',
                    'ci_shell_include_fund.with_or_without as with_or_without',
                    'ci_fund_remittances.remittance_id as check_remittance',
                    'ci_fund_remittances.ci_shell_card_id as check_shell_card',
                    'ci_fund_remittances.ci_atm_fund_id as check_atm',
                    'count.type as type',
                    'fund_requests.management_remarks_approved as rem_manage'
                ]
            )
            ->groupBy('count.fund_id')
//            ->where('fund_requests.finance_id',Auth::user()->id)
            ->where('fund_requests.sao_status','APPROVED')
            ->where('fund_requests.approved_request_done', '=', '');


        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('finance_app_fund_details_endorsements/' . $b->id);
            })
            ->editColumn('remittances_info', function ($data)
            {
//                $ci_id = $data->ci_id;
                $fund_id = $data->id;

                $get_remit_info = DB::table('remittance')
                    ->select()
                    ->where('fund_id',$fund_id)
                    ->get();


                if(count($get_remit_info)==0)
                {
                    $get_remit_info = '';

                    return $get_remit_info;
                }
                else
                {

                    $branch_name = $get_remit_info[0]->branch_name;
                    $receiver = $get_remit_info[0]->receiver;
                    $sender = $get_remit_info[0]->sender;
                    $code = $get_remit_info[0]->code;
                    $amount = 'PHP '.base64_decode($get_remit_info[0]->amount);
                    $remarks = $get_remit_info[0]->remarks;

                    return $branch_name.'<br>/<br>'.$receiver.'<br>/<br>'.$sender.'<br>/<br>'.$code.'<br>/<br>'.$amount.'<br>/<br>'.$remarks;
                }
            })
            ->editColumn('bank_info', function ($data)
            {
                $fund_id = $data->id;

                $get_bank_info = DB::table('ci_atm_fund')
                    ->join('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                    ->select([
                        'ci_atms.bank_name as bank_name',
                        'ci_atms.account_number as account_number',
                        'ci_atm_fund.amount as amount'
                    ])
                    ->where('ci_atm_fund.fund_id',$fund_id)
                    ->get();

                if(count($get_bank_info)==0)
                {
                    $get_bank_info = '';

                    return $get_bank_info;
                }
                else
                {
                    $bank_name = $get_bank_info[0]->bank_name;
                    $account_number = $get_bank_info[0]->account_number;
                    $amount = $get_bank_info[0]->amount;

                    return $bank_name.'<br>/<br>'.$account_number.'<br>/<br>PHP '.$amount;
                }
            })
            ->editColumn('shell_info', function ($data)
            {
                $fund_id = $data->id;

                $get_shell_info = DB::table('ci_shell_include_fund')
                    ->join('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
                    ->join('ci_atms','ci_atms.id','=','ci_shell_include_fund.shell_id')
                    ->select([
                        'ci_atms.bank_name as bank_name',
                        'ci_atms.account_number as account_number',
                    ])
                    ->where('ci_shell_include_fund.fund_id',$fund_id)
                    ->get();

                if(count($get_shell_info)==0)
                {
                    $get_shell_info = '';

                    return $get_shell_info;
                }
                else
                {
                    $bank_name = $get_shell_info[0]->bank_name;
                    $account_number = $get_shell_info[0]->account_number;

                    return $bank_name.'<br>/<br>'.$account_number;
                }

            })
            ->editColumn('action', function ($data)
            {
                $check_if_shell = DB::table('ci_atms')
                    ->select(['bank_name','id'])
                    ->where('ci_id',$data->ci_id)
                    ->where('bank_name','SHELL CARD')
                    ->get();
                $check_atms = DB::table('ci_atms')
                    ->select('bank_name', 'id')
                    ->where('ci_id',$data->ci_id)
                    ->where('bank_name', '!=','SHELL CARD')
                    ->get();
                $count_atms =  DB::table('ci_atms')
                    ->select('bank_name')
                    ->where('ci_id',$data->ci_id)
                    ->where('bank_name', '!=','SHELL CARD')
                    ->count();
                $dropAtm = '';

                $reqrem = '';


                if($data->type_of_fund_request == 'NORMAL REQUEST')
                {
                    $reqrem = $data->dispatcher_remarks.'||==||'.$data->name_disp;
                }
                else if($data->type_of_fund_request == 'EMERGENCY FUND')
                {
                    $reqrem = $data->sao_remarks.'||==||'.$data->name_sao;
                }

                if($count_atms >= 1)
                {
                    for($i = 0 ; $i < count($check_atms); $i++)
                    {
                        $dropAtm .= '<option value="'. $check_atms[$i]->id .'">'. $check_atms[$i]->bank_name .'</option><br>';
                    }
                    $selectAtm = '<select id = "BtnciATMOptions-'.$data->id.'" class = "BtnciATMOptions form-control" name = "'.$data->id.'"  style = "width: 100%"> <option value = "-">---------SELECT BANK---------</option><br>'.$dropAtm.'</select>';
                }
                else
                {
                    $selectAtm = '';
                }

                $url = 'dist/img/loading.gif';

                $req = '';

                if($data->type_of_fund_request == 'NORMAL REQUEST')
                {
                    $req = '<button class="btn btn-xs btn-danger btn-block fundReq_cancel" idd="'.base64_encode($data->id).'">CANCEL FUND REQUEST</button>';
                }
                else if($data->type_of_fund_request == 'EMERGENCY FUND')
                {
                    $req = '<button class="btnViewManagementRem btn btn-block btn-xs btn-danger" style="width : 100%" name = "'.$data->rem_manage.'||==||'.$data->manage_name.'">VIEW MANAGEMENT REMARKS</button>
                    <button class="btn btn-xs btn-danger btn-block fundReq_cancel" idd="'.base64_encode($data->id).'">CANCEL FUND REQUEST</button>';
                }



                if($data->type_of_fund_request == 'NORMAL REQUEST' || $data->type_of_fund_request == 'EMERGENCY FUND')
                {
                    if ($data->delivered_date === '0000-00-00 00:00:00' || $data->delivered_date === null) {

                        return '<button class="BtnDeliverFund btn btn-xs btn-info btn-block"  id = "BtnDeliverFund-' . $data->id . '" value = "' . $data->id . '"  style="width: 100%">REMITTANCE</button>' . '<br>'.
                            $selectAtm . '<br>'.
                            '<br><button type = "button" class =  "btnSubmitFundReqInfo btn btn-xs btn-warning btn-block" id = "btnSubmitFundReqInfo-' . $data->id . '" value = "' . $data->id . '" style = "width : 100%;" name="' . $data->ci_id . '"">SUBMIT <span id = "loadingSendSubmit-'.$data->id.'" style = "position: absolute; padding-right : 5px;" hidden><img src= "'. $url  .'"  style = "width: 17%"></span></button><br>
                            <button class = "btnShowRemarksRequestor btn-xs btn-primary btn-block"  style="width: 100%" name = "'.$reqrem.'" >VIEW REQUESTOR REMARKS</button><br>' . $req;
                    }
                }

            })
            ->editColumn('stats', function ($data)
            {
                $status = '';

                if ($data->receive_status === 'received')
                {
                    $status = 'DELIVERED';
                }
                else if($data->receive_status_atm === 'received')
                {
                    $status = 'DELIVERED';
                }
//                else if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
//                {
//                    $status = 'DELIVERED';
//                }
                else
                {
                    $status = 'ON PROCESS';
                }

                return $status;
            })
            ->editColumn('remit_info', function ($data)
            {
                if($data->type_of_fund_request == 'NORMAL REQUEST' || $data->type_of_fund_request == 'EMERGENCY FUND')
                {
                    $aa = '<span id = "spanPrem-'.$data->id.'"><textarea id="remittance_approve-'.$data->id.'" class = "form-control" style= "width : 100%" rows = "5" placeholder="Remittance Name: / Ref No: / Sender:"></textarea></span>
                <span id = "span2Rem-'.$data->id.'" class = "span2Rem"></span>';
                    if($data->remittance_info != '')
                    {
                        if($data->remittance_info != null)
                        {
                            $aa = $data->remittance_info;
                        }
                    }
                    if($data->receive_status === 'received')
                    {
                        $aa = $data->remittance_info;
                    }
                    if($data->receive_status_atm === 'received')
                    {
                        $aa = 'THROUGH ATM';
                    }
                    if ($data->receive_status === '' || $data->receive_status_atm === '')
                    {
                        if ($data->check_atm != 0)
                        {
                            $aa = 'THROUGH ATM';
                        }
                    }
//                    if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
//                    {
//                        $aa = 'THROUGH ATM';
//                    }
                    $remittance_check = $data->check_remittance;
                    $atm_check = $data->check_atm;
                    $shell_check = $data->check_shell_card;

                    if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                    {
                        $aa = "SHELL CARD ONLY";
                    }
                    return '<span id="remit_col-'.$data->id.'">'.$aa.'</span>';
                }
                else if($data->type_of_fund_request == 'SHELL CARD REQUEST')
                {
                    return 'N/A';
                }

            })
            ->rawColumns(['remittances_info','bank_info','shell_info','stats','action','remit_info'])
            ->make(true);
    }
    public function getCiFundRequestDeclined()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->join('users as sao_id','sao_id.id','=','fund_requests.sao_id')
            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select(
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'sao_id.name as name_sao',
                    'finance_id.name as name_finance',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as dispatcher_remarks',
                    'fund_requests.sao_remarks as sao_remarks',
                    'fund_requests.finance_remarks as finance_remarks',
                    'fund_requests.dispatcher_request_date as dispatcher_request_date',
                    'fund_requests.sao_approved_date as sao_approved_date',
                    'fund_requests.finance_approved_date as finance_approved_date',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where('fund_requests.finance_id',Auth::user()->id)
            ->where('fund_requests.finance_status','DISAPPROVED');

        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('finance_dec_fund_details_endorsements/' . $b->id);
            })->make(true);
    }

    public function FinanceApprovedReq(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $id = $request->id;
        $remarks = $request->remarks;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$id)
            ->update([
                'finance_approved_date' => $timeStamp,
                'finance_remarks' => $removeScript->scripttrim(strtoupper($remarks)),
                'finance_status' => 'APPROVED',
                'finance_id' => Auth::user()->id
            ]);

        $ci_id = DB::table('fund_requests')
            ->select
            (
                'ci_id'
            )
            ->where('id',$id)
            ->first();

        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id->ci_id);
        $fund_audit->fund_logs('APPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

        return response()->json('success');
    }

    public function FinanceDeclinedReq(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $id = $request->id;
        $remarks = $request->remarks;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$id)
            ->update([
                'finance_approved_date' => $timeStamp,
                'finance_remarks' => $removeScript->scripttrim(strtoupper($remarks)),
                'finance_status' => 'DISAPPROVED',
                'dispatcher_status' => 'DISAPPROVED',
                'finance_id' => Auth::user()->id
            ]);


        $get_endorsements_id = DB::table('fund_request_endorsements')
            ->where('fund_id',$id)
            ->where('type','Processing')
            ->get();

        foreach ($get_endorsements_id as $ids)
        {

            DB::table('endorsements')
                ->where('id', $ids->endorsement_id)
                ->update
                ([
                    'fund_request' => ''
                ]);
        }


        DB::table('fund_request_endorsements')
            ->where('fund_id',$id)
            ->update
            (
                [
                    'type'=>'Disapproved'
                ]
            );


        $ci_id = DB::table('fund_requests')
            ->select
            (
                'ci_id'
            )
            ->where('id',$id)
            ->first();

        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id->ci_id);
        $fund_audit->fund_logs('DISAPPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

        return response()->json('success');

    }

    public function FinanceDeliverRemitReq(Request $request)
    {
        $fund_id = $request->id;
        $remittance_info = $request->remittance_info;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$fund_id)
            ->update([
                'delivered_date' => $timeStamp
            ]);

        $ci_id = DB::table('fund_requests')
            ->where('id',$fund_id)
            ->select('ci_id','fund_amount')->get();


        DB::table('remittance')
            ->insert([
                'fund_id' => $fund_id,
                'remittance_info' => $remittance_info,
                'amount' => $ci_id[0]->fund_amount,
                'date_of_send' => $timeStamp
            ]);

        $remittance_id = DB::table('remittance')
            ->where('fund_id',$fund_id)
            ->select('id','amount')->get();

        $check = DB::table('ci_fund_remittances')
            ->where('fund_id',$fund_id)
            ->count();

        if($check>0)
        {
            //update
            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update([
                    'finance_sent' => Auth::user()->id,
                    'user_id' => $ci_id[0]->ci_id,
                    'remittance_id' => $remittance_id[0]->id,
                    'remittance_send_date_time' => $timeStamp
                ]);
        }
        else
        {
            //insert
            DB::table('ci_fund_remittances')
                ->insert([
                    'finance_sent' => Auth::user()->id,
                    'user_id' => $ci_id[0]->ci_id,
                    'fund_id' => $fund_id,
                    'remittance_id' => $remittance_id[0]->id,
                    'remittance_send_date_time' => $timeStamp
                ]);
        }
        DB::table('fund_request_endorsements')
            ->where('fund_id',$fund_id)
            ->update
            (
                [
                    'type'=>'Success'
                ]
            );

        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id[0]->ci_id);
        $fund_audit->fund_logs('REMITTANCE SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$request->amount_remit.'',$fund_id);

        return response()->json('success');

    }

    public function finance_get_remiitance_view(Request $request)
    {

        $view = DB::table('remittance')
            ->where('fund_id',$request->id)
            ->get();

        return response()->json($view);

    }

    public function finance_update_remittance(Request $request)
    {
        $fund_id = $request->id;
        $branch_name = $request->branch_name;
        $remarks_remit = strtoupper($request->remarks_remit);
        $receiver_remit = $request->receiver_remit;
        $remit_code = $request->remit_code;
        $amount_remit = base64_encode($request->amount_remit);
        $sender_remit = $request->sender_remit;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$fund_id)
            ->update([
                'delivered_date' => $timeStamp
            ]);

        $before_data = DB::table('remittance')
            ->join('fund_requests','fund_requests.id','=','remittance.fund_id')
            ->select([
                'remittance.branch_name as branch_name',
                'remittance.receiver as receiver',
                'remittance.sender as sender',
                'remittance.code as code',
                'remittance.amount as amount',
                'remittance.remarks as remarks',
                'fund_requests.ci_id as ci_id'
            ])
            ->where('remittance.fund_id',$fund_id)
            ->get()[0];

        $before_remit_branch_name = $before_data->branch_name;
        $before_remit_receiver = $before_data->receiver;
        $before_remit_sender = $before_data->sender;
        $before_remit_code = $before_data->code;
        $before_remit_amount = $before_data->amount;
        $before_remit_remarks = $before_data->remarks;

        DB::table('remittance')
            ->where('fund_id',$fund_id)
            ->update([
                'branch_name' => $branch_name,
                'receiver' => $receiver_remit,
                'sender' => $sender_remit,
                'code' => $remit_code,
                'amount' => $amount_remit,
                'remarks' => $remarks_remit,
                'date_of_send' => $timeStamp
            ]);

        $get_name = User::find($before_data->ci_id)->name;

        $fund_audit = new AuditFundQueries();
        $fund_audit->fund_logs('FUND REQUEST REMITTANCE UPDATE: BRANCH: '.$before_remit_branch_name. ' RECEIVER NAME FROM '.$before_remit_receiver. ' TO '.$receiver_remit.', CODE FROM '.$before_remit_code.' TO '.$remit_code.', AMOUNT FROM '.base64_decode($before_remit_amount).' TO '.base64_decode($amount_remit).', SENDER FROM '.$before_remit_sender.' TO '.$sender_remit.', REMARKS FROM '.$before_remit_remarks.' TO '.$remarks_remit.' OF FCI : '.$get_name.'',$fund_id);


        return response()->json('success');

    }

    public function BtnAddFundToCI(Request $request)
    {

        $with_shell_logs = '';

        if($request->ifshell == 'have_shell')
        {
            DB::table('ci_shell_include_fund')
                ->where('fund_id',$request->id)
                ->update([

                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')

                ]);

            $with_shell_logs = 'WITH SHELL FUND INCLUDED.';
        }
        else if($request->ifshell == 'shell_only')
        {
            DB::table('ci_shell_include_fund')
                ->where('fund_id',$request->id)
                ->update([
                    'with_or_without' => 'without',
                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')

                ]);

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>$request->ci_id,
                    'activity_id' => $request->id,
                    'activity' => '(RECEIVES) SHELL FUND, FROM: '.Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($request->ci_id)->name;
            $fund_audit->fund_logs('SHELL FUND ADDED TO '.$get_name.'',$request->id);
        }

        if($request->what == 'remittance')
        {
            DB::table('remittance')
                ->where('fund_id',$request->id)
                ->update([

                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')

                ]);

            $getfund = DB::table('remittance')
                ->where('fund_id', $request->id)
                ->where('receive_status','received')
                ->select('amount','sender')
                ->get();

            $getfunddecoded = base64_decode($getfund[0]->amount);


            if($request->ifshell == 'have_shell')
            {
                DB::table('ci_shell_include_fund')
                    ->where('fund_id',$request->id)
                    ->update([
                        'with_or_without' => 'with',
                    ]);

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>$request->ci_id,
                        'activity_id' => $request->id,
                        'activity' => '(RECEIVES REMITTANCE WITH SHELL) FUND: '.$getfunddecoded.', FROM: '.Auth::user()->name,
                        'type' => 'ci_receive_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>$request->ci_id,
                        'activity_id' => $request->id,
                        'activity' => '(RECEIVES REMITTANCE) FUND: '.$getfunddecoded.', FROM: '.Auth::user()->name,
                        'type' => 'ci_receive_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }



            $fund_audit = new AuditFundQueries();
            $get_name = User::find($request->ci_id)->name;
            $fund_audit->fund_logs('FUND ADDED TO '.$get_name.' VIA REMITTANCE '.$with_shell_logs.'',$request->id); //$with_shell_logs = it can be '' or with shell

            $checkfund = DB::table('ci_fund_realtime_amount')
                ->where('user_id', $request->ci_id)
                ->count();

            if($checkfund == 0)
            {

                DB::table('ci_fund_realtime_amount')
                    ->insert([
                        'user_id' => $request->ci_id,
                        'fund' => $getfunddecoded
                    ]);
            }
            else
            {
                $fundgetter = DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$request->ci_id)
                    ->select('fund')
                    ->get()[0]->fund;


                DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$request->ci_id)
                    ->update([
                        'fund' =>  ($getfunddecoded+$fundgetter)
                    ]);
            }

        }
        else if ($request->what == 'atm')
        {
            DB::table('ci_atm_fund')
                ->where('fund_id',$request->id)
                ->update([

                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')

                ]);

            $getfund = DB::table('ci_atm_fund')
                ->where('fund_id', $request->id)
                ->where('receive_status','received')
                ->select('amount')
                ->get();

            $getfunddecoded = $getfund[0]->amount;

            $checkfund = DB::table('ci_fund_realtime_amount')
                ->where('user_id', $request->ci_id)
                ->count();


            if($request->ifshell == 'have_shell')
            {
                DB::table('ci_shell_include_fund')
                    ->where('fund_id',$request->id)
                    ->update([
                        'with_or_without' => 'with',
                    ]);


                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>$request->ci_id,
                        'activity_id' => $request->id,
                        'activity' => '(RECEIVES ATM WITH SHELL) FUND: '.$getfunddecoded.', FROM: '.Auth::user()->name,
                        'type' => 'ci_receive_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {
                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>$request->ci_id,
                        'activity_id' => $request->id,
                        'activity' => '(RECEIVES ATM) FUND: '.$getfunddecoded.', FROM: '.Auth::user()->name,
                        'type' => 'ci_receive_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
            }


            $fund_audit = new AuditFundQueries();
            $get_name = User::find($request->ci_id)->name;
            $fund_audit->fund_logs('FUND ADDED TO '.$get_name.' VIA ATM '.$with_shell_logs.'',$request->id); //$with_shell_logs = it can be '' or with shell


            if($checkfund == 0)
            {

                DB::table('ci_fund_realtime_amount')
                    ->insert([
                        'user_id' => $request->ci_id,
                        'fund' => $getfunddecoded
                    ]);
            }
            else
            {
                $fundgetter = DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$request->ci_id)
                    ->select('fund')
                    ->get()[0]->fund;


                DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$request->ci_id)
                    ->update([
                        'fund' =>  ($getfunddecoded+$fundgetter)
                    ]);
            }
        }


        $check = DB::table('ci_fund_realtime_amount')
            ->where('user_id',$request->ci_id)
            ->select('fund')
            ->count();

        $getminus = 0;

        if($check == 0)
        {
            $realtimefund = 0;
        }
        else
        {
            $realtimefund = DB::table('ci_fund_realtime_amount')
                ->where('user_id',$request->ci_id)
                ->select('fund')
                ->get()[0]->fund;

            $getminus = DB::table('expenses')
                ->join('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                ->where('ci_expenses.ci_id',$request->ci_id)
                ->where('expenses.type','Fund')
                ->select('expenses.amount')
                ->get();
        }

        $getall = 0;
        $real = 0;

        if (is_array($getminus) || is_object($getminus)) {

            foreach ($getminus as $getminuses) {

                $getall += $getminuses->amount;

            }
        }

        $real = ($realtimefund-$getall);

        DB::table('ci_fund_realtime_amount')
            ->where('user_id',$request->ci_id)
            ->update([
                'fund_realtime' => $real
            ]);

        DB::table('fund_request_endorsements')
            ->where('fund_id',$request->id)
            ->update
            (
                [
                    'type'=>'Success'
                ]
            );

        DB::table('ci_fund_remittances')
            ->where('fund_id',$request->id)
            ->update([
                'confirm_date_time' => Carbon::now('Asia/Manila')
            ]);

        $get_endorsements_id = DB::table('fund_request_endorsements')
            ->where('fund_id',$request->id)
            ->get();

        foreach ($get_endorsements_id as $ids)
        {
            DB::table('endorsements')
                ->where('id', $ids->endorsement_id)
                ->update([
                    'fund_request' => 'fund_uploaded'
                ]);

        }


        return response()->json('success');

    }

    public function financeGetATMInfo()
    {
        $atm = DB::table('ci_atms')
            ->join('users','users.id','ci_atms.ci_id')
            ->join('role_user','role_user.user_id','ci_atms.ci_id')
            ->select
            (
                [
                    'ci_atms.id',
                    'users.name',
                    'ci_atms.bank_name',
                    'ci_atms.account_number'
                ]
            )
            ->where('users.archive','False')
            ->where('role_user.role_id',4);

        return DataTables::of($atm)->make(true);
    }

    public function financeInsertATMInfo(Request $request)
    {
        $bank_name = strtoupper($request->txtBankName);

        if($request->type == 'ATM')
        {
            $validator = Validator::make($request->all(),
                [
                    'selFCIName' => 'required',
                    'txtBankName' => 'required',
                    'txtAcctNum' => 'required'
                ]);

            $checkduplicate = DB::table('ci_atms')
                ->where('bank_name', $bank_name)
                ->where('ci_id', $request->selFCIName)
                ->count();

            if($checkduplicate >= 1)
            {
                return response()->json('duplicated');
            }
            else
            {
                if($validator->fails())
                {
                    return response()->json('filluperror');
                }
                else
                {
                    DB::table('ci_atms')
                        ->insert
                        (
                            [
                                'ci_id' => $request->selFCIName,
                                'bank_name' => strtoupper($request->txtBankName),
                                'account_number' => strtoupper($request->txtAcctNum)
                            ]
                        );

                    return response()->json('success');
                }
            }
        }
        else if($request->type == 'Shell Card')
        {
            $checkduplicate = DB::table('ci_atms')
                ->where('bank_name', 'SHELL CARD')
                ->where('ci_id', $request->selFCIName)
                ->count();

            if($checkduplicate >= 1)
            {
                return response()->json('duplicated');
            }
            else
            {
                $atm_id =  DB::table('ci_atms')
                    ->insertGetId
                    (
                        [
                            'ci_id' => $request->selFCIName,
                            'bank_name' => 'SHELL CARD',
                            'account_number' => strtoupper($request->txtAcctNum)
                        ]
                    );

                DB::table('ci_shell_card_info')
                    ->insert(
                        [
                            'atm_id' => $atm_id,
                            'shell_card' => 'SHELL CARD',
                        ]
                    );
                return response()->json('success');
            }
        }

        return response()->json('error');
    }

    public function financeGetModalATMInfo(Request $request)
    {
        $getUpdateAtmInfo = DB::table('ci_atms')
            ->join('users','users.id','ci_atms.ci_id')
            ->select
            (
                'users.id',
                'ci_atms.bank_name',
                'ci_atms.account_number'
            )
            ->where('ci_atms.id',$request->atmID)
            ->get();

        return response()->json($getUpdateAtmInfo);
    }

    public function financeUpdateModalATMInfo(Request $request)
    {

        if($request->txtBankNameUpd == 'SHELL CARD')
        {
            $validator = Validator::make($request->all(),
                [
                    'txtBankNameUpd' => 'required'
                ]);
        }
        else
        {
            $validator = Validator::make($request->all(),
                [
                    'txtBankNameUpd' => 'required',
                    'txtAcctNumUpd' => 'required'
                ]);
        }

        if($validator->fails())
        {
            return response()->json('filluperror');
        }
        else
        {
            DB::table('ci_atms')
                ->where('id',$request->atmIDUpd)
                ->update
                (
                    [
                        'ci_id' => $request->selFCINameUpd,
                        'bank_name' => strtoupper($request->txtBankNameUpd),
                        'account_number' => strtoupper($request->txtAcctNumUpd)
                    ]
                );

            return response()->json('success');
        }
    }

    public function financeDeleteModalATMInfo(Request $request)
    {

        DB::table('ci_shell_card_info')
            ->where('atm_id',$request->atmID)
            ->delete();

        DB::table('ci_atms')
            ->where('id',$request->atmID)
            ->delete();

        return response()->json('success');
    }

    public function finance_pending_fund_details_endorsements(Request $request)
    {
        $details = DB::table('fund_request_endorsements')
            ->join('fund_requests','fund_requests.id','=','fund_request_endorsements.fund_id')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select([
                'fund_request_endorsements.endorsement_id as id',
                'endorsements.account_name as name',
                'endorsements.address as address',
                'endorsements.type_of_request as tor',
                'endorsements.date_endorsed as date',
                'municipalities.muni_name as city_muni',
                'endorsements.provinces as provinces',
            ])
            ->where('fund_request_endorsements.fund_id',$request->id)
            ->where('fund_request_endorsements.type_label','')
            ->where('fund_request_endorsements.type','Processing')
            ->where('fund_requests.dispatcher_status','ON-PROCESS')
            ->where('fund_requests.sao_status','APPROVED')
            ->where('fund_requests.finance_status','');

        return DataTables::of($details)
            ->make(true);
    }

    public function finance_app_fund_details_endorsements(Request $request)
    {
        $details = DB::table('fund_request_endorsements')
            ->join('fund_requests','fund_requests.id','=','fund_request_endorsements.fund_id')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select([
                'fund_request_endorsements.endorsement_id as id',
                'endorsements.account_name as name',
                'endorsements.address as address',
                'endorsements.type_of_request as tor',
                'endorsements.date_endorsed as date',
                'municipalities.muni_name as city_muni',
                'endorsements.provinces as provinces',
            ])
            ->where('fund_request_endorsements.fund_id',$request->id);

        return DataTables::of($details)
            ->make(true);
    }

    public function finance_dec_fund_details_endorsements(Request $request)
    {
        $details = DB::table('fund_request_endorsements')
            ->join('fund_requests','fund_requests.id','=','fund_request_endorsements.fund_id')
            ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
            ->leftjoin('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select([
                'fund_request_endorsements.endorsement_id as id',
                'endorsements.account_name as name',
                'endorsements.address as address',
                'endorsements.type_of_request as tor',
                'endorsements.date_endorsed as date',
                'municipalities.muni_name as city_muni',
                'endorsements.provinces as provinces',
                'fund_request_endorsements.type as type'
            ])
            ->where(function ($query)
            {
                return $query->where('fund_request_endorsements.type','Disapproved')
                    ->orWhere('fund_request_endorsements.type','Transferred');
            })
            ->where('fund_request_endorsements.fund_id',$request->id)
            ->where('fund_request_endorsements.type_label','')
            ->where('fund_requests.finance_status','DISAPPROVED');


        return DataTables::of($details)
            ->make(true);
    }

    public function finance_get_atm_list(Request $request)
    {
        $id = $request->id;

        $data = DB::table('ci_atms')
            ->join('fund_requests','fund_requests.ci_id','=','ci_atms.ci_id')
            ->where('fund_requests.id',$id)
            ->select([

                'ci_atms.bank_name as name',
                'ci_atms.id as id'

            ])
            ->get();

        $view = DB::table('ci_atm_fund')
            ->where('fund_id',$request->id)
            ->get();

        return response()->json([$data,$view]);

    }

    public function finance_send_atm_fund(Request $request)
    {

        $fund_id = $request->id;

        $atm_id = $request->atm_id;

        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$fund_id)
            ->update([
                'delivered_date' => $timeStamp
            ]);


        $ci_id = DB::table('fund_requests')
            ->where('id',$fund_id)
            ->select('ci_id','fund_amount')->get();

        $amount = base64_decode($ci_id[0]->fund_amount);

        $ci_atm_fund_id =  DB::table('ci_atm_fund')
            ->insertGetId([
                'fund_id' => $fund_id,
                'ci_atm_id' => $atm_id,
                'amount' => $amount,
//                'remarks' => $remarks,
                'date_of_send' => $timeStamp
            ]);


        $check = DB::table('ci_fund_remittances')
            ->where('fund_id',$fund_id)
            ->count();

        if($check>0)
        {
            //update
            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update([
                    'finance_sent' => Auth::user()->id,
                    'user_id' => $ci_id[0]->ci_id,
                    'ci_atm_fund_id' => $ci_atm_fund_id,
                    'atm_send_date_time' => $timeStamp
                ]);
        }
        else
        {
            //insert
            DB::table('ci_fund_remittances')
                ->insert([
                    'finance_sent' => Auth::user()->id,
                    'user_id' => $ci_id[0]->ci_id,
                    'fund_id' => $fund_id,
                    'ci_atm_fund_id' => $ci_atm_fund_id,
                    'atm_send_date_time' => $timeStamp
                ]);
        }

        DB::table('fund_request_endorsements')
            ->where('fund_id',$fund_id)
            ->update
            (
                [
                    'type'=>'Success'
                ]
            );

        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id[0]->ci_id);
        $fund_audit->fund_logs('ATM SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$amount.'',$fund_id);

    }

    public function finance_get_atm_view(Request $request)
    {
        $view = DB::table('ci_atm_fund')
            ->where('fund_id',$request->id)
            ->get();

        return response()->json($view);
    }

    public function finance_atm_update_fund(Request $request)
    {
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$request->fund_id)
            ->update([
                'delivered_date' => $timeStamp
            ]);

        $get_data_before = DB::table('ci_atm_fund')
            ->join('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
            ->select([
//                'ci_atm_fund.ci_atm_id as id',
                'ci_atm_fund.amount as amount',
                'ci_atm_fund.remarks as remarks',
                'ci_atm_fund.date_of_send as date_send',
                'ci_atms.bank_name as bank_name',
                'ci_atms.ci_id as ci_id'
            ])
            ->where('ci_atm_fund.fund_id',$request->fund_id)
            ->get();

        if(count($get_data_before)==0)
        {
            $before_bank_name = '';
            $before_amount = '';
            $before_remarks = '';
            $ci_id = '';
        }
        else
        {

            $before_bank_name = $get_data_before[0]->bank_name;
            $before_amount = $get_data_before[0]->amount;
            $before_remarks = $get_data_before[0]->remarks;
            $ci_id = $get_data_before[0]->ci_id;

        }


        DB::table('ci_atm_fund')
            ->where('fund_id',$request->fund_id)
            ->update([
                'ci_atm_id' => $request->atm,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                'date_of_send' => $timeStamp
            ]);


        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id)->name;
        $fund_audit->fund_logs('FUND REQUEST ATM UPDATE: ATM NAME FROM '.$before_bank_name.' TO '.$request->atm_name_before.', AMOUNT FROM '.$before_amount.' TO '.$request->amount.', REMARKS FROM '.$before_remarks.' TO '.$request->remarks.' OF FCI : '.$get_name.'',$request->fund_id);

        return 'success';

    }

    public function finance_shell_card_include(Request $request)
    {
        $fund_id = $request->fund_id;
        $shell_id = $request->shell_card_id;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id',$fund_id)
            ->update([
                'delivered_date' => $timeStamp
            ]);

        $ci_shell_fund_id =  DB::table('ci_shell_include_fund')
            ->insertGetId([
                'fund_id' => $fund_id,
                'shell_id' => $shell_id,
                'date_of_send' => $timeStamp
            ]);


        $ci_id = DB::table('fund_requests')
            ->where('id',$fund_id)
            ->select('ci_id')->get()[0]->ci_id;

        $check = DB::table('ci_fund_remittances')
            ->where('fund_id',$fund_id)
            ->count();

        if($check>0)
        {
            //update
            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update([
                    'finance_sent' => Auth::user()->id,
                    'ci_shell_card_id' => $ci_shell_fund_id,
                    'shell_send_date_time' =>$timeStamp
                ]);
        }
        else
        {
            //insert
            DB::table('ci_fund_remittances')
                ->insert([
                    'finance_sent' => Auth::user()->id,
                    'ci_shell_card_id' => $ci_shell_fund_id,
                    'shell_send_date_time' =>$timeStamp,
                    'user_id' => $ci_id,
                    'fund_id' => $fund_id
                ]);
        }
        $fund_audit = new AuditFundQueries();
        $get_name = User::find($ci_id);
        $fund_audit->fund_logs('SHELL CARD INCLUDED TO: '.$get_name->name.'',$fund_id);

        return 'success';

    }

    public function finance_update_remittance_info(Request $request)
    {

        $id = $request->id;
        $remit_info = $request->new_remittance;

        DB::table('remittance')
            ->where('fund_id',$id)
            ->update([
                'remittance_info' => $remit_info
            ]);

    }

    public function finance_update_realtime_remarks(Request $request)
    {
        $id = $request->fund_id;
        $remarks_fund = $request->remarks_fund;
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        DB::table('fund_requests')
            ->where('id',$id)
            ->update([
                'finance_remarks' => $remarks_fund,
                'date_time_remarks' =>$timeStamp
            ]);

        return response()->json([$id,$remarks_fund,$date.' '.$time]);
    }
    public function insertCiBank(Request $request)
    {
        $trimmer = new Trimmer();
        if($request->shellAccount != null)
        {
            $getData  = DB::table('ci_atms')
                ->insertGetId
                ([
                    'ci_id' => $request->ciId,
                    'bank_name' => 'SHELL CARD',
                    'account_number' => $request->shellAccount
                ]);

            DB::table('ci_shell_card_info')
                ->insert
                ([
                    'atm_id' => $getData,
                    'shell_card' => 'SHELL CARD',
                    'shell_gas_limit' => $request->gasLimit
                ]);
        }
        $values = $request->myData;

        if($request->myData != null)
        {
            foreach($values as $key => $value)
            {
                DB::table('ci_atms')
                    ->insert
                    ([
                        'ci_id' => $request->ciId,
                        'bank_name' => $trimmer->trims($key),
                        'account_number' => $value
                    ]);
            }
        }
    }
    public function getCiList()
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
    public function ciBankTable()
    {
        $getData = DB::table('ci_atms')
            ->leftjoin('ci_shell_card_info', 'ci_shell_card_info.atm_id', '=', 'ci_atms.id')
            ->join('users', 'users.id', '=', 'ci_atms.ci_id')
            ->select
            ([
                'users.id as id',
                'users.name as name',
                'ci_atms.bank_name as bank',
                'ci_atms.account_number as acct',
                'ci_shell_card_info.shell_gas_limit as gas',
                'ci_atms.id as atm_id'
            ]);
        return DataTables::of($getData)
            ->make(true);
    }

    public function table_for_online_upload(Request $request){
        $b = '';
        if($request->statQue == 1)
        {
            $b = DB::table('fund_requests')
                ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
                ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
                ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
                ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
                ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
                ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                ->join('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
                ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
                ->leftJoin('ci_atms as if_shell','if_shell.id','=','ci_shell_card_info.atm_id')
                ->leftjoin('users as for_sao', 'for_sao.id', '=',  'fund_requests.sao_id')
                ->leftjoin('users as for_disp', 'for_disp.id', '=', 'fund_requests.dispatcher_id')
                ->select
                (
                    [
                        'fund_requests.id as id',
                        'ci_id.name as name_ci',
                        'fund_requests.fund_amount as amount',
                        'fund_requests.dispatcher_request_date as dispatcher_request_date',
                        'remittance.receive_status as receive_status',
                        'remittance.remittance_info as remittance_info',
                        'ci_atm_fund.receive_status as receive_status_atm',
                        'ci_shell_include_fund.receive_status as receive_status_shell',
                        'ci_shell_include_fund.with_or_without as with_or_without',
                        'ci_fund_remittances.remittance_id as check_remittance',
                        'ci_fund_remittances.ci_shell_card_id as check_shell_card',
                        'ci_fund_remittances.ci_atm_fund_id as check_atm',
                        'ci_atms.bank_name as atm_bank_name',
                        'ci_atms.account_number as atm_account_number',
                        'if_shell.account_number as shell_number',
                        'ci_atm_fund.amount as atm_amount',
                        'remittance.amount as remit_amount',
                        'fund_requests.sao_approved_date as sao_date',
                        'for_sao.name as sao_name',
                        'for_disp.name as disp_name',
                        'fund_requests.type_of_fund_request as type_fund'
                    ]
                )
                ->groupBy('count.fund_id')
                ->where('fund_requests.sao_status','APPROVED')
                ->where($request->data, '!=', 0)
                ->where('fund_requests.approved_request_done', 'Pending');
        }
        else if($request->statQue == 2)
        {
            $b = DB::table('fund_requests')
                ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
                ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
                ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
                ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
                ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
                ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                ->leftjoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
                ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
                ->leftJoin('ci_atms as if_shell','if_shell.id','=','ci_shell_card_info.atm_id')
                ->leftjoin('users as for_sao', 'for_sao.id', '=',  'fund_requests.sao_id')
                ->leftjoin('users as for_disp', 'for_disp.id', '=', 'fund_requests.dispatcher_id')
                ->select(
                    [
                        'fund_requests.id as id',
                        'ci_id.name as name_ci',
                        'fund_requests.fund_amount as amount',
                        'fund_requests.dispatcher_request_date as dispatcher_request_date',
                        'remittance.receive_status as receive_status',
                        'remittance.remittance_info as remittance_info',
                        'ci_atm_fund.receive_status as receive_status_atm',
                        'ci_shell_include_fund.receive_status as receive_status_shell',
                        'ci_shell_include_fund.with_or_without as with_or_without',
                        'ci_fund_remittances.remittance_id as check_remittance',
                        'ci_fund_remittances.ci_shell_card_id as check_shell_card',
                        'ci_fund_remittances.ci_atm_fund_id as check_atm',
                        'ci_atms.bank_name as atm_bank_name',
                        'ci_atms.account_number as atm_account_number',
                        'if_shell.account_number as shell_number',
                        'ci_atm_fund.amount as atm_amount',
                        'remittance.amount as remit_amount',
                        'fund_requests.sao_approved_date as sao_date',
                        'for_sao.name as sao_name',
                        'for_disp.name as disp_name',
                        'fund_requests.type_of_fund_request as type_fund'
                    ]
                )
                ->groupBy('count.fund_id')
                ->where('fund_requests.sao_status','APPROVED')
                ->where($request->data, '!=', 0)
                ->where('ci_atms.bank_name', $request->whereAm)
                ->where('fund_requests.approved_request_done', 'Pending')
            ;

        }
        return DataTables::of($b)
            ->editColumn('remit_info', function ($data)//4
            {
                $remittance_info = $data->remittance_info;

                return $remittance_info;
            })
            ->editColumn('bank_info', function ($data)//5
            {
                $remittance_check = $data->check_remittance;
                $atm_check = $data->check_atm;
                $shell_check = $data->check_shell_card;
                if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    return $data->shell_number;
                }
                else
                {
                    return $data->atm_account_number;

                }
            })
            ->editColumn('what_action', function ($data)//3
            {
                $remittance_check = $data->check_remittance;
                $atm_check = $data->check_atm;
                $shell_check = $data->check_shell_card;

                $aa ='';

                if($data->remittance_info != '')
                {
                    if($data->remittance_info != null)
                    {
                        $aa = 'REMITTANCE';
                    }
                }
                if($data->receive_status === 'received')
                {
                    $aa = 'REMITTANCE';
                }

                if($data->receive_status_atm === 'received')
                {
                    $aa = $data->atm_bank_name;

                }
                if ($data->receive_status === '' || $data->receive_status_atm === '')
                {
                    if ($data->check_atm != 0)
                    {
                        $aa = $data->atm_bank_name;
                    }
                }

                if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
                {
                    $aa = $data->atm_bank_name;
                }

                if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    $aa = "SHELL CARD ONLY";
                }

                return $aa;
            })
            ->editColumn('fund_amount', function ($data)//6
            {

                $remittance_check = $data->check_remittance;
                $atm_check = $data->check_atm;
                $shell_check = $data->check_shell_card;

                $amount = '';

                if($remittance_check != 0)
                {
                    $amount = base64_decode($data->remit_amount);
                }
                else if($atm_check != 0)
                {
                    $amount = $data->atm_amount;
                }
                else if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
                {
                    $amount = base64_decode($data->amount);
                }
                return $amount;

            })
            ->rawColumns(['remit_info','bank_info','what_action','fund_amount'])
            ->make(true);
    }

    public function finance_get_expenses_report_table()
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
                 'ci_daily_expenses_date.ci_id as ci_id',

                 'ci_daily_expenses.label as label',
                 'ci_daily_expenses.amount as amount',
                 'ci_daily_expenses.from as from',
                 'ci_daily_expenses.or_attachment as or_attachment',
                 'ci_daily_expenses.remarks as remarks',

                 'endorsements.type_of_request as type_of_request',
            ])
            ->groupBy('ci_daily_expenses_date.id');

        return DataTables::of($catch_them_all)
            ->editColumn('label_edit', function ($data){

                $get_label = DB::table('ci_daily_expenses')
                    ->select('label')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_label = '';
                $count = 1;
                if(count($get_label) != 0)
                {
                    foreach ($get_label as $label)
                    {
                        $ret_label .= $count.'. '.$label->label.' <br>';
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

                $ret_amount = '';
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
                        if($amount->from == 'Revolving')
                        {
                            $total_expenses = $total_expenses + (int)$amount->amount;
                        }

                    }

                }

                $ret_amount = 'Total Expenses: '.$total_expenses.'<br>Total Revolving Expenses: '.$total_reimbursement.' Php';
                return $ret_amount;

            })
            ->editColumn('from_edit', function ($data){

                $get_from = DB::table('ci_daily_expenses')
                    ->select('from')
                    ->where('daily_id',$data->id)
                    ->get();

                $ret_from = '';
                $count = 1;
                if(count($get_from) != 0)
                {
                    foreach ($get_from as $from)
                    {
                        $ret_from .= $count.'. '.$from->from.' <br>';
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

                $ret_or = '';
                $count = 1;
                if(count($get_or) != 0)
                {
                    foreach ($get_or as $or)
                    {
                        $ret_or .= $count.'. '.$or->or_attachment.' <br>';
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

                $ret_remark = '';
                $count = 1;
                if(count($get_remarks) != 0)
                {
                    foreach ($get_remarks as $remark)
                    {
                        $ret_remark .= $count.'. '.$remark->remarks.' <br>';
                        $count++;
                    }
                }

                return $ret_remark;

            })
            ->editColumn('account_edit', function ($data){

                // $getEndoAccount = DB::table('ci_daily_expenses_pivot_endorsement')
                //     ->where('daily_id', $data->id)
                //     ->select('endorsement_id')
                //     ->get();

                $account_info = DB::table('endorsements')
                    ->join('ci_daily_expenses_pivot_endorsement', 'ci_daily_expenses_pivot_endorsement.endorsement_id', '=', 'endorsements.id')
                    ->join('municipalities','municipalities.id','=','endorsements.city_muni')
                    ->where('ci_daily_expenses_pivot_endorsement.daily_id', $data->id)
                    ->select([
                        'endorsements.account_name as account_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.address',
                        'municipalities.muni_name as city_muni',
                        'endorsements.provinces',
                    ])
                    ->get();

//                $account_info = DB::table('ci_daily_expenses_date')
////                    ->leftjoin('ci_daily_expenses_pivot_endorsement','ci_daily_expenses_pivot_endorsement.daily_id','=','ci_daily_expenses_date.id')
//                    ->join('endorsements','endorsements.id','=','ci_daily_expenses_pivot_endorsement.endorsement_id')
//                    ->join('municipalities','municipalities.id','=','endorsements.city_muni')
//                    ->select([
//                        'ci_daily_expenses_date.id as id',
//                        'endorsements.account_name as account_name',
//                        'endorsements.type_of_request as type_of_request',
//                        'endorsements.address',
//                        'municipalities.muni_name as city_muni',
//                        'endorsements.provinces',
//                    ])
//                    ->where('ci_daily_expenses_date.id',$data->id)
//                    ->get();

                $ret_infos = '';
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
            ->rawColumns([
                'label_edit',
                'amount_edit',
                'amount_total_edit',
                'from_edit',
                'or_edit',
                'remarks_edit',
                'account_edit'
            ])
            ->make(true);
    }

    public function finance_btn_delete_this_atm(Request $request)
    {
        $id = $request->id;

        $getCiId = DB::table('ci_atms')
            ->select('ci_id')
            ->where('id',$id)
            ->get();
        DB::table('ci_atms')
            ->where('id',$id)
            ->delete();

        DB::table('ci_shell_card_info')
            ->where('atm_id',$id)
            ->delete();

        $countShell = DB::table('ci_atms')
            ->where('bank_name', 'SHELL CARD')
            ->where('ci_id', $getCiId[0]->ci_id)
            ->get();

        return response()->json([count($countShell), $getCiId[0]->ci_id]);

    }


    public function finance_download_file_expenses(Request $request)
    {
        $id = base64_decode($request->id);
        $ci_id = base64_decode($request->ci_id);
        $ci_name = base64_decode($request->ci_name);
        $date_time = base64_decode($request->date_time);

        if(Auth::user()->hasRole('Finance'))
        {
            if(file_exists(storage_path('ci_expenses/'.$ci_id.'/'.$id)))
            {
                Zip::create(storage_path('ci_expenses/'.$id.'-'.$ci_name.'-'.$date_time.'.zip'), true)
                    ->add(storage_path('ci_expenses/'.$ci_id.'/'.$id), true)
                    ->setPath(storage_path('ci_expenses'))
                    ->close();
                return response()->download(storage_path('ci_expenses/'.$id.'-'.$ci_name.'-'.$date_time.'.zip'));

            }
            else
            {
                echo'<script>alert(\'No uploaded file.\'); window.close();</script>';
            }
        }
        else
        {
            return 'yow....';
        }
    }
    public function finance_check_shell_ci(Request $request)
    {

        $getData = DB::table('ci_atms')
            ->where('ci_id', $request->ciId)
            ->where('bank_name', 'SHELL CARD')
            ->count();

        return response()->json($getData);
    }

    public function finance_overall_fund_rem_atm(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $fund_id = $request->id;
        $timeStamp = Carbon::now('Asia/Manila');
        $with_shell_logs = '';

        if($request->atm != "" || $request->atm != null)
        {
            DB::table('fund_requests')
                ->where('id',$fund_id)
                ->update([
//                    'delivered_date' => $timeStamp,
                    'approved_request_done' => 'Pending'
                ]);
            $ci_id = DB::table('fund_requests')
                ->where('id',$fund_id)
                ->select('ci_id','fund_amount')
                ->get();

            $amount = base64_decode($ci_id[0]->fund_amount);

            $ci_atm_fund_id =  DB::table('ci_atm_fund')
                ->insertGetId
                ([
                    'fund_id' => $fund_id,
                    'ci_atm_id' => $request->atm,
                    'amount' => $amount,
//                'remarks' => $remarks,
//                    'date_of_send' => $timeStamp
                ]);

            $check = DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->count();
            if($check>0)
            {
                //update
                DB::table('ci_fund_remittances')
                    ->where('fund_id',$fund_id)
                    ->update([
                        'finance_sent' => Auth::user()->id,
                        'user_id' => $ci_id[0]->ci_id,
                        'ci_atm_fund_id' => $ci_atm_fund_id,
//                        'atm_send_date_time' => $timeStamp
                    ]);
            }
            else
            {
                //insert
                DB::table('ci_fund_remittances')
                    ->insert
                    ([
                        'finance_sent' => Auth::user()->id,
                        'user_id' => $ci_id[0]->ci_id,
                        'fund_id' => $fund_id,
                        'ci_atm_fund_id' => $ci_atm_fund_id,
//                        'atm_send_date_time' => $timeStamp
                    ]);
            }

            DB::table('fund_request_endorsements')
                ->where('fund_id',$fund_id)
                ->update
                (
                    [
                        'type'=>'Processing'
                    ]
                );
//            $fund_audit = new AuditFundQueries();
//            $get_name = User::find($ci_id[0]->ci_id);
//            $fund_audit->fund_logs('ATM SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$amount.'',$fund_id);
        }
        else if($request->rem != '' || $request->rem != null)
        {
            DB::table('fund_requests')
                ->where('id',$fund_id)
                ->update([
//                    'delivered_date' => $timeStamp,
                    'approved_request_done' => 'Pending'
                ]);

            $ci_id = DB::table('fund_requests')
                ->where('id',$fund_id)
                ->select('ci_id','fund_amount')->get();

            DB::table('remittance')
                ->insert
                ([
                    'fund_id' => $fund_id,
                    'remittance_info' => $request->rem,
                    'amount' => $ci_id[0]->fund_amount,
//                    'date_of_send' => $timeStamp
                ]);

            $remittance_id = DB::table('remittance')
                ->where('fund_id',$fund_id)
                ->select('id','amount')->get();

            $check = DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->count();

            if($check>0)
            {
                //update
                DB::table('ci_fund_remittances')
                    ->where('fund_id',$fund_id)
                    ->update([
                        'finance_sent' => Auth::user()->id,
                        'user_id' => $ci_id[0]->ci_id,
                        'remittance_id' => $remittance_id[0]->id,
//                        'remittance_send_date_time' => $timeStamp
                    ]);
            }
            else
            {
                //insert
                DB::table('ci_fund_remittances')
                    ->insert([
                        'finance_sent' => Auth::user()->id,
                        'user_id' => $ci_id[0]->ci_id,
                        'fund_id' => $fund_id,
                        'remittance_id' => $remittance_id[0]->id,
//                        'remittance_send_date_time' => $timeStamp
                    ]);
            }
            DB::table('fund_request_endorsements')
                ->where('fund_id',$fund_id)
                ->update
                (
                    [
                        'type'=>'Processing'
                    ]
                );
        }
        $get_endorsements_id = DB::table('fund_request_endorsements')
            ->where('fund_id',$request->id)
            ->get();

        foreach ($get_endorsements_id as $ids)
        {
            DB::table('endorsements')
                ->where('id', $ids->endorsement_id)
                ->update([
                    'fund_request' => 'fund_uploaded'
                ]);
        }
        $getData = DB::table('fund_requests')
            ->select('fund_amount')
            ->where('id', $request->id)
            ->get();

        $amountUnliq = base64_decode($getData[0]->fund_amount);

        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'liquidated_amount' => 0,
                'unliquidated_amount' => $amountUnliq,
            ]);
    }

    public function finance_get_all_bank()
    {
        $ci_atm = DB::table('ci_atms')
            ->select('bank_name')
            ->where('bank_name', '!=', 'SHELL CARD')
            ->get();

        return response()->json($ci_atm);
    }

    public function finance_get_access()
    {
        $getData = DB::table('users')
            ->select('authrequest')
            ->where('id',  Auth::user()->id)
            ->get();
        return response()->json($getData[0]->authrequest);
    }


    public function getFundSuccessReq(Request $request)
    {

        $start = Carbon::parse($request->start_q);
        $end = Carbon::parse($request->end_q);
        $type = $request->type_q;

        if($type == 'date_range')
        {
            $b = DB::table('fund_requests')
                ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
//            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
//            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
//            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
                //            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
                ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
//            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
//            ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
//            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
//            ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
                ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

                ->select(
                    [
                        'fund_requests.id as id',
                        'ci_id.name as name_ci',
//                    'dispatcher_id.name as name_disp',
//                    'sao_id.name as name_sao',
//                    'finance_id.name as name_finance',
                        'fund_requests.fund_amount as amount',
                        'fund_requests.dispatcher_remarks as dispatcher_remarks',
                        'fund_requests.sao_remarks as sao_remarks',
                        'fund_requests.finance_remarks as finance_remarks',
                        'fund_requests.date_time_remarks as date_time_remarks',
                        'fund_requests.dispatcher_request_date as dispatcher_request_date',
                        'fund_requests.sao_approved_date as sao_approved_date',
                        'fund_requests.finance_approved_date as finance_approved_date',
                        'fund_requests.delivered_date as delivered_date',
                        'fund_requests.type_of_fund_request',
                        'fund_requests.ci_id as ci_id',
//                    'ci_atms.bank_name as shell_card',
//                    'ci_shell_card_info.shell_card as get_shell',
//                    'ci_atms.account_number as account_number',
//                    'ci_atms.id as shell_card_id',
//                    'remittance.receive_status as receive_status',
//                    'remittance.branch_name as branch_name',
//                    'remittance.remittance_info as remittance_info',
//                    'remittance.code as code',
//                    'ci_atm_fund.receive_status as receive_status_atm',
//                    'ci_shell_include_fund.receive_status as receive_status_shell',

//                    'ci_shell_include_fund.with_or_without as with_or_without',
                        'ci_fund_remittances.remittance_id as check_remittance',
                        'ci_fund_remittances.ci_shell_card_id as check_shell_card',
                        'ci_fund_remittances.ci_atm_fund_id as check_atm',
//                    'ci_fund_remittances.date_time_remarks as date_time_remarks',
//                    'count.type as type',
                        'fund_requests.approved_incident_remarks as incident',
                        'fund_requests.approved_request_done as done',
                        'fund_requests.success_hold_cancel as hold_cancel',
                        'fund_requests.liquidation_status as liq',
                        'fund_requests.delivered_date as date_of_send'
                    ]
                )
//            ->groupBy('count.fund_id')
//            ->where('fund_requests.finance_id',Auth::user()->id)
                ->where('fund_requests.sao_status','APPROVED')
                ->whereDate('fund_requests.delivered_date', '>=', $start)
                ->whereDate('fund_requests.delivered_date', '<=', $end)
                ->where(function ($query)
                {
                    return $query->orwhere('fund_requests.approved_request_done','Done')
                        ->orwhere('fund_requests.approved_request_done','New');
                });
        }
        else
        {
            $b = DB::table('fund_requests')
                ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
//            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
//            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
//            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
                //            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
                ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
//            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
//            ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
//            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
//            ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
                ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

                ->select(
                    [
                        'fund_requests.id as id',
                        'ci_id.name as name_ci',
//                    'dispatcher_id.name as name_disp',
//                    'sao_id.name as name_sao',
//                    'finance_id.name as name_finance',
                        'fund_requests.fund_amount as amount',
                        'fund_requests.dispatcher_remarks as dispatcher_remarks',
                        'fund_requests.sao_remarks as sao_remarks',
                        'fund_requests.finance_remarks as finance_remarks',
                        'fund_requests.date_time_remarks as date_time_remarks',
                        'fund_requests.dispatcher_request_date as dispatcher_request_date',
                        'fund_requests.sao_approved_date as sao_approved_date',
                        'fund_requests.finance_approved_date as finance_approved_date',
                        'fund_requests.delivered_date as delivered_date',
                        'fund_requests.type_of_fund_request',
                        'fund_requests.ci_id as ci_id',
//                    'ci_atms.bank_name as shell_card',
//                    'ci_shell_card_info.shell_card as get_shell',
//                    'ci_atms.account_number as account_number',
//                    'ci_atms.id as shell_card_id',
//                    'remittance.receive_status as receive_status',
//                    'remittance.branch_name as branch_name',
//                    'remittance.remittance_info as remittance_info',
//                    'remittance.code as code',
//                    'ci_atm_fund.receive_status as receive_status_atm',
//                    'ci_shell_include_fund.receive_status as receive_status_shell',

//                    'ci_shell_include_fund.with_or_without as with_or_without',
                        'ci_fund_remittances.remittance_id as check_remittance',
                        'ci_fund_remittances.ci_shell_card_id as check_shell_card',
                        'ci_fund_remittances.ci_atm_fund_id as check_atm',
//                    'ci_fund_remittances.date_time_remarks as date_time_remarks',
//                    'count.type as type',
                        'fund_requests.approved_incident_remarks as incident',
                        'fund_requests.approved_request_done as done',
                        'fund_requests.success_hold_cancel as hold_cancel',
                        'fund_requests.liquidation_status as liq',
                        'fund_requests.delivered_date as date_of_send'
                    ]
                )
//            ->groupBy('count.fund_id')
//            ->where('fund_requests.finance_id',Auth::user()->id)
                ->where('fund_requests.sao_status','APPROVED')
                ->where(function ($query)
                {
                    return $query->orwhere('fund_requests.approved_request_done','Done')
                        ->orwhere('fund_requests.approved_request_done','New');
                });
        }


        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('finance_app_fund_details_endorsements/' . $b->id);
            })
            ->editColumn('bank_info', function ($data)
            {
                $fund_id = $data->id;

                $get_bank_info = DB::table('ci_atm_fund')
                    ->join('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                    ->select([
                        'ci_atms.bank_name as bank_name',
                        'ci_atms.account_number as account_number',
                        'ci_atm_fund.amount as amount'
                    ])
                    ->where('ci_atm_fund.fund_id',$fund_id)
                    ->get();

                if(count($get_bank_info)==0)
                {
                    $get_bank_info = '';

                    return $get_bank_info;
                }
                else
                {
                    $bank_name = $get_bank_info[0]->bank_name;
                    $account_number = $get_bank_info[0]->account_number;
                    $amount = $get_bank_info[0]->amount;

                    return $bank_name.'<br>/<br>'.$account_number.'<br>/<br>PHP '.$amount;
                }
            })
//            ->editColumn('shell_info', function ($data)
//            {
//                $fund_id = $data->id;
//
//                $get_shell_info = DB::table('ci_shell_include_fund')
//                    ->join('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
//                    ->join('ci_atms','ci_atms.id','=','ci_shell_include_fund.shell_id')
//                    ->select([
//                        'ci_atms.bank_name as bank_name',
//                        'ci_atms.account_number as account_number',
//                    ])
//                    ->where('ci_shell_include_fund.fund_id',$fund_id)
//                    ->get();
//
//                if(count($get_shell_info)==0)
//                {
//                    $get_shell_info = '';
//
//                    return $get_shell_info;
//                }
//                else
//                {
//                    $bank_name = $get_shell_info[0]->bank_name;
//                    $account_number = $get_shell_info[0]->account_number;
//
//                    return $bank_name.'<br>/<br>'.$account_number;
//                }
//
//            })
            ->editColumn('action', function ($data)
            {
//                $check_if_shell = DB::table('ci_atms')
//                    ->select(['bank_name','id'])
//                    ->where('ci_id',$data->ci_id)
//                    ->where('bank_name','SHELL CARD')
//                    ->get();
//                $check_atms = DB::table('ci_atms')
//                    ->select('bank_name', 'id')
//                    ->where('ci_id',$data->ci_id)
//                    ->where('bank_name', '!=','SHELL CARD')
//                    ->get();
//                $count_atms =  DB::table('ci_atms')
//                    ->select('bank_name')
//                    ->where('ci_id',$data->ci_id)
//                    ->where('bank_name', '!=','SHELL CARD')
//                    ->count();
//                if(count($check_if_shell) == 0)
//                {
//                    $check_if_shell = '';
//                    $shell_id_card = '';
//                }
//                else
//                {
//                    $shell_id_card = $check_if_shell[0]->id;
//                    $check_if_shell = $check_if_shell[0]->bank_name;
//                }
//
//                $dropAtm = '';
//                if($count_atms >= 1)
//                {
//                    for($i = 0 ; $i < count($check_atms); $i++)
//                    {
//                        $dropAtm .= '<option value="'. $check_atms[$i]->id .'">'. $check_atms[$i]->bank_name .'</option><br>';
//                    }
//                    $selectAtm = '<br><select id = "BtnciATMOptions-'.$data->id.'" class = "BtnciATMOptions form-control" name = "'.$data->id.'"  style = "width: 100%"> <option value = "-">-</option><br>'.$dropAtm.'</select><br>';
//                }
//                else
//                {
//                    $selectAtm = '';
//                }

//                if($data->receive_status === 'received' || $data->receive_status_atm === 'received')
//                {
//                    $shell_card = $data->check_shell_card;
//                    $remittance = $data->check_remittance;
//                    $atm = $data->check_atm;
//                    $view = '';

                return 'hehehe';
//                }
//                else if($data->check_shell_card > 0 && $data->check_remittance == 0 &&  $data->check_atm == 0)
//                {
//                    return '<button type = "button" class = "btn btn-xs btn-danger" style = "width : 100%" disabled >SHELL CARD ONLY INCLUDED</button>';
//                }
            })
            ->editColumn('stats', function ($data)
            {
                $status = '';
                if($data->incident != null || $data->incident != '')
                {
                    $status = 'DELIVERED (WITH INCIDENT): ' . $data->date_of_send;
                }
//                else if ($data->receive_status === 'received')
//                {
//                    $status = 'DELIVERED';
//                }
//                else if($data->receive_status_atm === 'received')
//                {
//                    $status = 'DELIVERED';
//                }
//                else if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
//                {
//                    $status = 'DELIVERED';
//                }
//                else if($data->check_shell_card > 0 && $data->check_remittance == 0 &&  $data->check_atm == 0)
//                {
//                    $status = 'DELIVERED(SHELL CARD ONLY)';
//                }
                else
                {
                    $status = 'DELIVERED: ' . $data->date_of_send;
                }

                return $status;
            })
            ->editColumn('remit_info', function ($fund_data)
            {
                $removeScript = new ScriptTrimmer();
//                $aa = '<span id = "spanPrem-'.$data->id.'"><textarea id="remittance_approve-'.$data->id.'" style="width: 100%; height: 100px; margin: 0px;" placeholder="Remittance Name: / Ref No: / Sender:"></textarea></span>
//                <span id = "span2Rem-'.$data->id.'" class = "span2Rem"></span>';

                //            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

//                'remittance.receive_status as receive_status',
//                    'remittance.branch_name as branch_name',
//                    'remittance.remittance_info as remittance_info',
//                    'remittance.code as code',
//                    'ci_atm_fund.receive_status as receive_status_atm',

                $remittance_check = $fund_data->check_remittance;
                $atm_check = $fund_data->check_atm;
                $shell_check = $fund_data->check_shell_card;

                if($shell_check == 0 && $remittance_check != 0 && $atm_check == 0)
                {
                    //remittance

                    $data = DB::table('remittance')
                        ->select([
                            'remittance_info'
                        ])
                        ->where('fund_id',$fund_data->id)
                        ->get();


                    $aa = $data[0]->remittance_info;

                }
                else if($shell_check == 0 && $remittance_check == 0 && $atm_check != 0)
                {
                    $aa = 'THROUGH ATM';

                }



//                if($data->remittance_info != '')
//                {
//                    if($data->remittance_info != null)
//                    {
//                    }
//                }
//                if($data->receive_status === 'received')
//                {
//                    $aa = $data->remittance_info;
//                }
//                if($data->receive_status_atm === 'received')
//                {
//                }
//                if ($data->receive_status === '' || $data->receive_status_atm === '')
//                {
//                    if ($data->check_atm != 0)
//                    {
//                        $aa = 'THROUGH ATM';
//                    }
//                }
//                if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
//                {
//                    $aa = 'THROUGH ATM';
//                }


//                if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
//                {
//                    $aa = "SHELL CARD ONLY";
//                }
//                return '<span id="remit_col-'.$data->id.'">'.$aa.'</span>';
                return $aa;
            })
            ->rawColumns(['bank_info','stats','action','remit_info'])
            ->make(true);
    }


//     public function getFundSuccessReq(Request $request)
//     {

//         $start = $request->start_q;
//         $end = $request->end_q;
//         $type = $request->type_q;

//         if($type == 'date_range')
//         {
//             $b = DB::table('fund_requests')
//                 ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
// //            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
// //            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
// //            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
//                 //            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
//                 ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
// //            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
// //            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
// //            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
// //            ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
// //            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
// //            ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
//                 ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

//                 ->select(
//                     [
//                         'fund_requests.id as id',
//                         'ci_id.name as name_ci',
// //                    'dispatcher_id.name as name_disp',
// //                    'sao_id.name as name_sao',
// //                    'finance_id.name as name_finance',
//                         'fund_requests.fund_amount as amount',
//                         'fund_requests.dispatcher_remarks as dispatcher_remarks',
//                         'fund_requests.sao_remarks as sao_remarks',
//                         'fund_requests.finance_remarks as finance_remarks',
//                         'fund_requests.date_time_remarks as date_time_remarks',
//                         'fund_requests.dispatcher_request_date as dispatcher_request_date',
//                         'fund_requests.sao_approved_date as sao_approved_date',
//                         'fund_requests.finance_approved_date as finance_approved_date',
//                         'fund_requests.delivered_date as delivered_date',
//                         'fund_requests.type_of_fund_request',
//                         'fund_requests.ci_id as ci_id',
// //                    'ci_atms.bank_name as shell_card',
// //                    'ci_shell_card_info.shell_card as get_shell',
// //                    'ci_atms.account_number as account_number',
// //                    'ci_atms.id as shell_card_id',
// //                    'remittance.receive_status as receive_status',
// //                    'remittance.branch_name as branch_name',
// //                    'remittance.remittance_info as remittance_info',
// //                    'remittance.code as code',
// //                    'ci_atm_fund.receive_status as receive_status_atm',
// //                    'ci_shell_include_fund.receive_status as receive_status_shell',

// //                    'ci_shell_include_fund.with_or_without as with_or_without',
//                         'ci_fund_remittances.remittance_id as check_remittance',
//                         'ci_fund_remittances.ci_shell_card_id as check_shell_card',
//                         'ci_fund_remittances.ci_atm_fund_id as check_atm',
// //                    'ci_fund_remittances.date_time_remarks as date_time_remarks',
// //                    'count.type as type',
//                         'fund_requests.approved_incident_remarks as incident',
//                         'fund_requests.approved_request_done as done',
//                         'fund_requests.success_hold_cancel as hold_cancel',
//                         'fund_requests.liquidation_status as liq',
//                         'fund_requests.delivered_date as date_of_send'
//                     ]
//                 )
// //            ->groupBy('count.fund_id')
// //            ->where('fund_requests.finance_id',Auth::user()->id)
//                 ->where('fund_requests.sao_status','APPROVED')
//                 ->whereDate('fund_requests.delivered_date', '>=', $start . ' 00:00:00')
//                 ->whereDate('fund_requests.delivered_date', '<=', $end . ' 23:59:59')
//                 ->where(function ($query)
//                 {
//                     return $query->orwhere('fund_requests.approved_request_done','Done')
//                         ->orwhere('fund_requests.approved_request_done','New');
//                 });
//         }
//         else
//         {
//             $b = DB::table('fund_requests')
//                 ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
// //            ->join('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
// //            ->leftjoin('users as sao_id','sao_id.id','=','fund_requests.sao_id')
// //            ->leftjoin('users as manage_approved_id','manage_approved_id.id','=','fund_requests.manage_approved_id')
//                 //            ->join('users as finance_id','finance_id.id','=','fund_requests.finance_id')
//                 ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
// //            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
// //            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
// //            ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
// //            ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
// //            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
// //            ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
//                 ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

//                 ->select(
//                     [
//                         'fund_requests.id as id',
//                         'ci_id.name as name_ci',
// //                    'dispatcher_id.name as name_disp',
// //                    'sao_id.name as name_sao',
// //                    'finance_id.name as name_finance',
//                         'fund_requests.fund_amount as amount',
//                         'fund_requests.dispatcher_remarks as dispatcher_remarks',
//                         'fund_requests.sao_remarks as sao_remarks',
//                         'fund_requests.finance_remarks as finance_remarks',
//                         'fund_requests.date_time_remarks as date_time_remarks',
//                         'fund_requests.dispatcher_request_date as dispatcher_request_date',
//                         'fund_requests.sao_approved_date as sao_approved_date',
//                         'fund_requests.finance_approved_date as finance_approved_date',
//                         'fund_requests.delivered_date as delivered_date',
//                         'fund_requests.type_of_fund_request',
//                         'fund_requests.ci_id as ci_id',
// //                    'ci_atms.bank_name as shell_card',
// //                    'ci_shell_card_info.shell_card as get_shell',
// //                    'ci_atms.account_number as account_number',
// //                    'ci_atms.id as shell_card_id',
// //                    'remittance.receive_status as receive_status',
// //                    'remittance.branch_name as branch_name',
// //                    'remittance.remittance_info as remittance_info',
// //                    'remittance.code as code',
// //                    'ci_atm_fund.receive_status as receive_status_atm',
// //                    'ci_shell_include_fund.receive_status as receive_status_shell',

// //                    'ci_shell_include_fund.with_or_without as with_or_without',
//                         'ci_fund_remittances.remittance_id as check_remittance',
//                         'ci_fund_remittances.ci_shell_card_id as check_shell_card',
//                         'ci_fund_remittances.ci_atm_fund_id as check_atm',
// //                    'ci_fund_remittances.date_time_remarks as date_time_remarks',
// //                    'count.type as type',
//                         'fund_requests.approved_incident_remarks as incident',
//                         'fund_requests.approved_request_done as done',
//                         'fund_requests.success_hold_cancel as hold_cancel',
//                         'fund_requests.liquidation_status as liq',
//                         'fund_requests.delivered_date as date_of_send'
//                     ]
//                 )
// //            ->groupBy('count.fund_id')
// //            ->where('fund_requests.finance_id',Auth::user()->id)
//                 ->where('fund_requests.sao_status','APPROVED')
//                 ->where(function ($query)
//                 {
//                     return $query->orwhere('fund_requests.approved_request_done','Done')
//                         ->orwhere('fund_requests.approved_request_done','New');
//                 });
//         }


//         return DataTables::of($b)
//             ->addColumn('details_url', function($b) {
//                 return url('finance_app_fund_details_endorsements/' . $b->id);
//             })
//             ->editColumn('bank_info', function ($data)
//             {
//                 $fund_id = $data->id;

//                 $get_bank_info = DB::table('ci_atm_fund')
//                     ->join('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
//                     ->select([
//                         'ci_atms.bank_name as bank_name',
//                         'ci_atms.account_number as account_number',
//                         'ci_atm_fund.amount as amount'
//                     ])
//                     ->where('ci_atm_fund.fund_id',$fund_id)
//                     ->get();

//                 if(count($get_bank_info)==0)
//                 {
//                     $get_bank_info = '';

//                     return $get_bank_info;
//                 }
//                 else
//                 {
//                     $bank_name = $get_bank_info[0]->bank_name;
//                     $account_number = $get_bank_info[0]->account_number;
//                     $amount = $get_bank_info[0]->amount;

//                     return $bank_name.'<br>/<br>'.$account_number.'<br>/<br>PHP '.$amount;
//                 }
//             })
// //            ->editColumn('shell_info', function ($data)
// //            {
// //                $fund_id = $data->id;
// //
// //                $get_shell_info = DB::table('ci_shell_include_fund')
// //                    ->join('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
// //                    ->join('ci_atms','ci_atms.id','=','ci_shell_include_fund.shell_id')
// //                    ->select([
// //                        'ci_atms.bank_name as bank_name',
// //                        'ci_atms.account_number as account_number',
// //                    ])
// //                    ->where('ci_shell_include_fund.fund_id',$fund_id)
// //                    ->get();
// //
// //                if(count($get_shell_info)==0)
// //                {
// //                    $get_shell_info = '';
// //
// //                    return $get_shell_info;
// //                }
// //                else
// //                {
// //                    $bank_name = $get_shell_info[0]->bank_name;
// //                    $account_number = $get_shell_info[0]->account_number;
// //
// //                    return $bank_name.'<br>/<br>'.$account_number;
// //                }
// //
// //            })
//             ->editColumn('action', function ($data)
//             {
// //                $check_if_shell = DB::table('ci_atms')
// //                    ->select(['bank_name','id'])
// //                    ->where('ci_id',$data->ci_id)
// //                    ->where('bank_name','SHELL CARD')
// //                    ->get();
// //                $check_atms = DB::table('ci_atms')
// //                    ->select('bank_name', 'id')
// //                    ->where('ci_id',$data->ci_id)
// //                    ->where('bank_name', '!=','SHELL CARD')
// //                    ->get();
// //                $count_atms =  DB::table('ci_atms')
// //                    ->select('bank_name')
// //                    ->where('ci_id',$data->ci_id)
// //                    ->where('bank_name', '!=','SHELL CARD')
// //                    ->count();
// //                if(count($check_if_shell) == 0)
// //                {
// //                    $check_if_shell = '';
// //                    $shell_id_card = '';
// //                }
// //                else
// //                {
// //                    $shell_id_card = $check_if_shell[0]->id;
// //                    $check_if_shell = $check_if_shell[0]->bank_name;
// //                }
// //
// //                $dropAtm = '';
// //                if($count_atms >= 1)
// //                {
// //                    for($i = 0 ; $i < count($check_atms); $i++)
// //                    {
// //                        $dropAtm .= '<option value="'. $check_atms[$i]->id .'">'. $check_atms[$i]->bank_name .'</option><br>';
// //                    }
// //                    $selectAtm = '<br><select id = "BtnciATMOptions-'.$data->id.'" class = "BtnciATMOptions form-control" name = "'.$data->id.'"  style = "width: 100%"> <option value = "-">-</option><br>'.$dropAtm.'</select><br>';
// //                }
// //                else
// //                {
// //                    $selectAtm = '';
// //                }

// //                if($data->receive_status === 'received' || $data->receive_status_atm === 'received')
// //                {
// //                    $shell_card = $data->check_shell_card;
// //                    $remittance = $data->check_remittance;
// //                    $atm = $data->check_atm;
// //                    $view = '';

//                     return 'hehehe';
// //                }
// //                else if($data->check_shell_card > 0 && $data->check_remittance == 0 &&  $data->check_atm == 0)
// //                {
// //                    return '<button type = "button" class = "btn btn-xs btn-danger" style = "width : 100%" disabled >SHELL CARD ONLY INCLUDED</button>';
// //                }
//             })
//             ->editColumn('stats', function ($data)
//             {
//                 $status = '';
//                 if($data->incident != null || $data->incident != '')
//                 {
//                     $status = 'DELIVERED (WITH INCIDENT) <br>DATE TIME DELIVER: ' . $data->date_of_send;
//                 }
// //                else if ($data->receive_status === 'received')
// //                {
// //                    $status = 'DELIVERED';
// //                }
// //                else if($data->receive_status_atm === 'received')
// //                {
// //                    $status = 'DELIVERED';
// //                }
// //                else if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
// //                {
// //                    $status = 'DELIVERED';
// //                }
// //                else if($data->check_shell_card > 0 && $data->check_remittance == 0 &&  $data->check_atm == 0)
// //                {
// //                    $status = 'DELIVERED(SHELL CARD ONLY)';
// //                }
//                 else
//                 {
//                     $status = 'DELIVERED <br>DATE TIME DELIVER: ' . $data->date_of_send;
//                 }

//                 return $status;
//             })
//             ->editColumn('remit_info', function ($fund_data)
//             {
//                 $removeScript = new ScriptTrimmer();
// //                $aa = '<span id = "spanPrem-'.$data->id.'"><textarea id="remittance_approve-'.$data->id.'" style="width: 100%; height: 100px; margin: 0px;" placeholder="Remittance Name: / Ref No: / Sender:"></textarea></span>
// //                <span id = "span2Rem-'.$data->id.'" class = "span2Rem"></span>';

//                 //            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
// //            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')

// //                'remittance.receive_status as receive_status',
// //                    'remittance.branch_name as branch_name',
// //                    'remittance.remittance_info as remittance_info',
// //                    'remittance.code as code',
// //                    'ci_atm_fund.receive_status as receive_status_atm',

//                 $remittance_check = $fund_data->check_remittance;
//                 $atm_check = $fund_data->check_atm;
//                 $shell_check = $fund_data->check_shell_card;

//                 if($shell_check == 0 && $remittance_check != 0 && $atm_check == 0)
//                 {
//                     //remittance

//                     $data = DB::table('remittance')
//                         ->select([
//                             'remittance_info'
//                         ])
//                         ->where('fund_id',$fund_data->id)
//                         ->get();


//                     $aa = $data[0]->remittance_info;

//                 }
//                 else if($shell_check == 0 && $remittance_check == 0 && $atm_check != 0)
//                 {
//                     $aa = 'THROUGH ATM';

//                 }



// //                if($data->remittance_info != '')
// //                {
// //                    if($data->remittance_info != null)
// //                    {
// //                    }
// //                }
// //                if($data->receive_status === 'received')
// //                {
// //                    $aa = $data->remittance_info;
// //                }
// //                if($data->receive_status_atm === 'received')
// //                {
// //                }
// //                if ($data->receive_status === '' || $data->receive_status_atm === '')
// //                {
// //                    if ($data->check_atm != 0)
// //                    {
// //                        $aa = 'THROUGH ATM';
// //                    }
// //                }
// //                if($data->receive_status_shell === 'received' && $data->with_or_without === 'without')
// //                {
// //                    $aa = 'THROUGH ATM';
// //                }


// //                if($shell_check != 0 && $remittance_check == 0 && $atm_check == 0)
// //                {
// //                    $aa = "SHELL CARD ONLY";
// //                }
// //                return '<span id="remit_col-'.$data->id.'">'.$aa.'</span>';
//                 return $aa;
//             })
//             ->rawColumns(['bank_info','stats','action','remit_info'])
//             ->make(true);
//     }

    public function finance_set_done_approve_req(Request $request)
    {
        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'finance_status' => 'INCIDENT',
                'approved_request_done' => 'Done'
            ]);
    }


    public function finance_get_incident_rem(Request $request)
    {
        $getData = DB::table('fund_requests')
            ->select('finance_remarks')
            ->where('id', $request->id)
            ->get();
        return response()->json($getData[0]->finance_remarks);
    }

    public function finance_send_re_approve_req(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $getData = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select
            (
                'dispatcher_id',
                'ci_id',
                'sao_id',
                'dispatcher_request_date',
                'sao_approved_date',
                'delivered_date',
                'dispatcher_remarks',
                'sao_remarks',
                'finance_remarks',
                'dispatcher_status',
                'sao_status',
                'type_of_fund_request',
                'fund_original_amount'
            )
            ->get();

        $getId = DB::table('fund_requests')
            ->insertGetId
            ([
                'dispatcher_id' => $getData[0]->dispatcher_id,
                'ci_id' => $getData[0]->ci_id,
                'sao_id' => $getData[0]->sao_id,
                'fund_amount' => $request->amount,
                'fund_original_amount' => $getData[0]->fund_original_amount,
                'dispatcher_request_date' => $getData[0]->dispatcher_request_date,
                'sao_approved_date' => $getData[0]->sao_approved_date,
                'finance_approved_date' => null,
                'dispatcher_remarks' => $getData[0]->dispatcher_remarks,
                'sao_remarks' => $removeScript->scripttrim($getData[0]->sao_remarks),
                'dispatcher_status' => $getData[0]->dispatcher_status,
                'sao_status' => $getData[0]->sao_status,
                'type_of_fund_request' => $getData[0]->type_of_fund_request,

            ]);

        $getCheckIds = DB::table('fund_request_endorsements')
            ->select('endorsement_id')
            ->where('fund_id', $request->id)
            ->get();

        for($i = 0; $i < count($getCheckIds);$i++ )
        {
            DB::table('fund_request_endorsements')
                ->insert([
                    'fund_id' => $getId,
                    'endorsement_id' => $getCheckIds[$i]->endorsement_id,
                    'type' => 'Processing'
                ]);

            DB::table('endorsements')
                ->where('id', $getCheckIds[$i]->endorsement_id)
                ->update([
                    'fund_request' => 'fund_requested'
                ]);
        }

        DB::table('fund_request_endorsements')
            ->where('fund_id', $request->id)
            ->where(function ($query)
            {
                return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                    ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
            })
            ->delete();

        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'approved_request_done' => 'New',
                'finance_remarks' => $removeScript->scripttrim($request->rem),
                'date_time_remarks' => Carbon::now('Asia/Manila')
            ]);
    }

    public function finance_ci_fund_request_table_fa(Request $request)
    {
        $b = [];
        $archipelago_id = $request->archipelago_id_holder;

        if(Auth::user()->hasRole('Senior Account Officer') || Auth::user()->hasRole('Management') || Auth::user()->hasRole('C.I Supervisor'))
        {

            if($request->start_q == "" && $request->end_q == "")
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
//                        'count.fund_id as fund_id',
                        'fund_requests.approved_incident_remarks as incident',
                        'fund_requests.approved_request_done as done',
                        'fund_requests.liquidated_amount as liq',
                        'fund_requests.unliquidated_amount as unliq',
                        'fund_requests.audit_remarks as audit_remarks',
                        'fund_requests.sao_emergency_req_date_time as sao_date',
                        'archipelagos.archipelago_name as archi',
                        'manage_approved_id.name as manage_name',
                        'fund_requests.management_remarks_approved as rem_manage'
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
                    ->where(function($query) use($archipelago_id)
                    {
                        if(Auth::user()->hasRole('Dispatcher') || Auth::user()->hasRole('Management'))
                        {
                            if($archipelago_id != '')
                            {
                                return $query->where('archipelagos.id', '=', $archipelago_id);
                            }
                        }
                    })
                    ->where(function ($query)
                    {
                        return $query ->orWhere('fund_requests.success_hold_cancel', '')
                            ->orWhere('fund_requests.success_hold_cancel', 'Override');
                    });
            }
            else
            {

                $startArray = explode("/",$request->start_q);
                $endArray = explode("/",$request->end_q);

                $dayStart = '';
                $dayEnd = '';
                $monthStart = '';
                $monthEnd = '';
                $dayStart = $startArray[1];
                $dayEnd = $endArray[1];
                $monthStart = $startArray[0];
                $monthEnd = $endArray[0];
//
                $start =  $startArray[2] .'-'. $monthStart . '-' . $dayStart. ' 00:00:00';
                $end =  $endArray[2] . '-' . $monthEnd . '-' . $dayEnd . ' 23:59:59';

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
//                        'count.fund_id as fund_id',
                        'fund_requests.approved_incident_remarks as incident',
                        'fund_requests.approved_request_done as done',
                        'fund_requests.liquidated_amount as liq',
                        'fund_requests.unliquidated_amount as unliq',
                        'fund_requests.audit_remarks as audit_remarks',
                        'fund_requests.sao_emergency_req_date_time as sao_date',
                        'archipelagos.archipelago_name as archi',
                        'manage_approved_id.name as manage_name',
                        'fund_requests.management_remarks_approved as rem_manage'
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
                    ->where(function($query) use($archipelago_id)
                    {
                        if(Auth::user()->hasRole('Dispatcher') || Auth::user()->hasRole('Management'))
                        {
                            if($archipelago_id != '')
                            {
                                return $query->where('archipelagos.id', '=', $archipelago_id);
                            }
                        }
                    })
                    ->where(function ($query)
                    {
                        return $query ->orWhere('fund_requests.success_hold_cancel', '')
                            ->orWhere('fund_requests.success_hold_cancel', 'Override');
                    })
                    ->where('fund_requests.created_at', '>=', $start)
                    ->where('fund_requests.created_at', '<=', $end);


            }
        }
        else
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
                ->where(function($query) use($archipelago_id)
                {
                    if(Auth::user()->hasRole('Dispatcher') || Auth::user()->hasRole('Management'))
                    {
                        if($archipelago_id != '')
                        {
                            return $query->where('archipelagos.id', '=', $archipelago_id);
                        }
                    }
                })
                ->where(function ($query)
                {
                    return $query ->orWhere('fund_requests.success_hold_cancel', '')
                        ->orWhere('fund_requests.success_hold_cancel', 'Override');
                });
        }

        return DataTables::of($b)
            ->editColumn('address_edit', function($query)
            {
                $to_return = '';
                $getEndo = DB::table('fund_request_endorsements')
                    ->join('endorsements', 'endorsements.id', '=' , 'fund_request_endorsements.endorsement_id')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->where('fund_request_endorsements.fund_id', $query->id)
                    ->select([
                        'endorsements.address as address',
                        'municipalities.muni_name as muni'
                    ])
                    ->get();

                if(count($getEndo) >= 2)
                {
                    $to_return = '';
                    for($i = 0; $i < count($getEndo); $i++)
                    {
                        $to_return .= $getEndo[$i]->address . ' ' .$getEndo[$i]->muni . ' / ';
                    }
                    $to_return = substr($to_return, 0, -2);

                }
                else
                {
                    $to_return .= $getEndo[0]->address;
                }

                return strtoupper($to_return);
            })
            ->rawColumns([
                'address_edit'
            ])
            ->make(true);
    }
  
    public function finance_get_img_liq_fund(Request $request)
    {
        $getReview = DB::table('fund_requests')
            ->join('audit_reviewed_ci_liquidation_remarks', 'audit_reviewed_ci_liquidation_remarks.fund_id', '=', 'fund_requests.id')
            ->join('users', 'users.id', '=', 'audit_reviewed_ci_liquidation_remarks.users_id')
            ->where('fund_requests.id', $request->id)
            ->select(
                [
                    'users.name as audit_name',
                    'fund_requests.liquidated_amount as LiqAmoung',
                    'fund_requests.unliquidated_amount as UnliqAmoung',
                    'fund_requests.audit_review_status as audit_review'
                ]
            )
            ->get();

        $getPaths = DB::table('fund_request_liquidate')
            ->join('endorsements', 'endorsements.id', 'fund_request_liquidate.endorse_id')
            ->where('fund_request_liquidate.fund_id', $request->id)
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

        $getRem = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select('ci_liq_rem', 'liquidated_amount', 'unliquidated_amount', 'audit_review_status')
            ->get();


        $total_amount = 0;

        if(count($getRem) != 0)
        {
            $total_amount = (int)$getRem[0]->liquidated_amount + (int)$getRem[0]->unliquidated_amount;
        }
        else
        {
            $total_amount = 0;
        }

        $arrayImg = [];
        $arrayName = [];
        $arrayPath = [];
        $arrayOldAmount = [];
        $arrayNewAmount = [];
        $arrayAmount = [];
        $arrayId = [];

        $counti = 0;
        $showDate = '';

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

            array_push($arrayOldAmount, $getPaths[$i]->liquidate_amount);

            array_push($arrayNewAmount, $getPaths[$i]->audit_liquidate_amount);

            array_push($arrayPath, $getPaths[$i]->receipt_attachment);

            if($getRem[0]->audit_review_status != 1)
            {
                array_push($arrayAmount, base64_encode($getPaths[$i]->liquidate_amount));
            }
            else
            {
                array_push($arrayAmount, base64_encode($getPaths[$i]->audit_liquidate_amount));
            }
            array_push($arrayId, $getPaths[$i]->id);


        }

        $getDateLog = DB::table('ci_logs_expenses')
            ->select('datetime')
            ->where('id', $request->id)
            ->count();



        if($getDateLog > 0)
        {
            $getDateLog = DB::table('ci_logs_expenses')
                ->select('datetime')
                ->where('activity_id', $request->id)
                ->orderBy('id', 'desc')
                ->first();

            $showDate = $getDateLog;
        }
        else if($getDateLog == 0)
        {
            $showDate = 'N/A';
        }

        return response()->json([$arrayImg, $arrayName, $getRem[0]->ci_liq_rem, $arrayPath, $getReview, array_sum($arrayOldAmount), array_sum($arrayNewAmount), $showDate, $arrayAmount, $total_amount, $arrayId]);
    }

    public function finance_done_online_fund(Request $request)
    {
        $sino_ang_gagamitin = '';
        $removeScript = new ScriptTrimmer();
        $fund_id = $request->id;
        $timeStamp = Carbon::now('Asia/Manila');

        DB::table('fund_requests')
            ->where('id', $fund_id)
            ->update
            ([
                'approved_request_done' => 'Done'
            ]);

        $fundCi = DB::table('ci_fund_remittances')
            ->select('remittance_id', 'ci_shell_card_id', 'ci_atm_fund_id')
            ->where('fund_id', $fund_id)
            ->get();

        $ciId = DB::table('fund_requests')
            ->select('ci_id')
            ->where('id', $fund_id)
            ->get();

        if($fundCi[0]->ci_atm_fund_id != 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id == 0)
        {
            $sino_ang_gagamitin = 'atm';

            DB::table('fund_requests')
                ->where('id',$fund_id)
                ->update([
                    'delivered_date' => $timeStamp,
                ]);

            $ci_id = DB::table('fund_requests')
                ->where('id',$fund_id)
                ->select('ci_id','fund_amount')
                ->get();

            $amount = base64_decode($ci_id[0]->fund_amount);

            $ci_atm_fund_id = DB::table('ci_atm_fund')
                ->select('id')
                ->where('fund_id', $fund_id)
                ->get();

            DB::table('ci_atm_fund')
                ->where('id', $ci_atm_fund_id[0]->id)
                ->update
                ([
                    'date_of_send' => $timeStamp
                ]);

            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update([
                    'atm_send_date_time' => $timeStamp
                ]);

            DB::table('ci_atm_fund')
                ->where('fund_id',$fund_id)
                ->update
                ([
                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')

                ]);

            DB::table('fund_request_endorsements')
                ->where('fund_id',$fund_id)
                ->update
                (
                    [
                        'type'=>'Success'
                    ]
                );

            $getfund = DB::table('ci_atm_fund')
                ->where('fund_id', $fund_id)
                ->where('receive_status','received')
                ->select('amount')
                ->get();

            $getfunddecoded = $getfund[0]->amount;

            $checkfund = DB::table('ci_fund_realtime_amount')
                ->where('user_id', $ci_id[0]->ci_id)
                ->count();

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($ci_id[0]->ci_id);
            $fund_audit->fund_logs('ATM SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$amount.'',$fund_id);

            if($checkfund == 0)
            {
                DB::table('ci_fund_realtime_amount')
                    ->insert([
                        'user_id' => $ci_id[0]->ci_id,
                        'fund' => $getfunddecoded
                    ]);
            }
            else
            {
                $fundgetter = DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$ci_id[0]->ci_id)
                    ->select('fund')
                    ->get()[0]->fund;


                DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$ci_id[0]->ci_id)
                    ->update([
                        'fund' =>  ($getfunddecoded+$fundgetter)
                    ]);
            }

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>$ci_id[0]->ci_id,
                    'activity_id' => $fund_id,
                    'activity' => '(RECEIVES) ATM FUND TRANSFER ; AMOUNT OF ' .$amount. ' , FROM: '.Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);
        }
        else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id != 0 && $fundCi[0]->ci_shell_card_id == 0)
        {
            $sino_ang_gagamitin = 'remittance';

            $ci_id = DB::table('fund_requests')
                ->where('id',$fund_id)
                ->select('ci_id','fund_amount')
                ->get();

            DB::table('fund_requests')
                ->where('id', $fund_id)
                ->update
                ([
                    'delivered_date' => $timeStamp
                ]);

            DB::table('remittance')
                ->where('fund_id', $fund_id)
                ->update
                ([
                    'date_of_send' => $timeStamp
                ]);

            $remittance_id = DB::table('remittance')
                ->where('fund_id',$fund_id)
                ->select('id','amount')
                ->get();

            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update
                ([
                    'remittance_send_date_time' => $timeStamp
                ]);
            $fund_audit = new AuditFundQueries();
            $get_name = User::find($ci_id[0]->ci_id);
            $fund_audit->fund_logs('REMITTANCE SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.base64_decode($remittance_id[0]->amount).'',$fund_id);

            DB::table('remittance')
                ->where('fund_id',$fund_id)
                ->update
                ([
                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')
                ]);

            DB::table('fund_request_endorsements')
                ->where('fund_id',$fund_id)
                ->update
                (
                    [
                        'type'=>'Success'
                    ]
                );

            $getfund = DB::table('remittance')
                ->where('fund_id', $fund_id)
                ->where('receive_status','received')
                ->select('amount','sender')
                ->get();

            $getfunddecoded = base64_decode($getfund[0]->amount);

            $checkfund = DB::table('ci_fund_realtime_amount')
                ->where('user_id', $ci_id[0]->ci_id)
                ->count();

            if($checkfund == 0)
            {
                DB::table('ci_fund_realtime_amount')
                    ->insert([
                        'user_id' => $ci_id[0]->ci_id,
                        'fund' => $getfunddecoded
                    ]);
            }
            else
            {
                $fundgetter = DB::table('ci_fund_realtime_amount')
                    ->where('user_id', $ci_id[0]->ci_id)
                    ->select('fund')
                    ->get()[0]->fund;


                DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$ci_id[0]->ci_id)
                    ->update([
                        'fund' =>  ($getfunddecoded+$fundgetter)
                    ]);
            }

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>$ci_id[0]->ci_id,
                    'activity_id' => $fund_id,
                    'activity' => '(RECEIVES) REMITTANCE ; AMOUNT OF ' .base64_decode($remittance_id[0]->amount).' , FROM: '.Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);
        }
        else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id != 0)
        {
            DB::table('fund_requests')
                ->where('id',$fund_id)
                ->update([
                    'delivered_date' => $timeStamp,
                ]);

            DB::table('ci_shell_include_fund')
                ->where('fund_id', $fund_id)
                ->update
                ([
                    'date_of_send' => $timeStamp
                ]);

            $ci_id = DB::table('fund_requests')
                ->where('id',$fund_id)
                ->select('ci_id')
                ->get()[0]->ci_id;

            DB::table('fund_request_endorsements')
                ->where('fund_id',$fund_id)
                ->update
                (
                    [
                        'type'=>'Success'
                    ]
                );

            DB::table('ci_fund_remittances')
                ->where('fund_id',$fund_id)
                ->update([
                    'shell_send_date_time' =>$timeStamp
                ]);

            $getfund = DB::table('fund_requests')
                ->select('fund_amount')
                ->where('id', $fund_id)
                ->get();

            $getfunddecoded = base64_decode($getfund[0]->fund_amount);

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($ci_id);
            $fund_audit->fund_logs('SHELL CARD WITH AN AMOUNT OF'  . $getfunddecoded .'INCLUDED TO: '.$get_name->name.'',$fund_id);

            DB::table('ci_shell_include_fund')
                ->where('fund_id',$fund_id)
                ->update
                ([
                    'receive_status' => 'received',
                    'receive_status_date_time' => Carbon::now('Asia/Manila')
                ]);

            $checkfund = DB::table('ci_fund_realtime_amount')
                ->where('user_id',$ci_id)
                ->count();

            if($checkfund == 0)
            {
                DB::table('ci_fund_realtime_amount')
                    ->insert([
                        'user_id' => $ci_id,
                        'fund' => $getfunddecoded
                    ]);
            }
            else
            {
                $fundgetter = DB::table('ci_fund_realtime_amount')
                    ->where('user_id', $ci_id)
                    ->select('fund')
                    ->get()[0]->fund;


                DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$ci_id)
                    ->update([
                        'fund' =>  ($getfunddecoded+$fundgetter)
                    ]);
            }

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>$ci_id,
                    'activity_id' => $fund_id,
                    'activity' => '(RECEIVES) SHELL FUND WITH THE AMOUNT OF ' .$getfunddecoded  .', FROM: '.Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);
        }

        $check = DB::table('ci_fund_realtime_amount')
            ->where('user_id',$ciId[0]->ci_id)
            ->select('fund')
            ->count();

        $getminus = 0;

        if($check == 0)
        {
            $realtimefund = 0;
        }
        else
        {
            $realtimefund = DB::table('ci_fund_realtime_amount')
                ->where('user_id',$ciId[0]->ci_id)
                ->select('fund')
                ->get()[0]->fund;

//            $getminus = DB::table('expenses')
//                ->join('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
//                ->where('ci_expenses.ci_id',$ciId[0]->ci_id)
//                ->where('expenses.type','Fund')
//                ->select('expenses.amount')
//                ->get();

            $getminus = DB::table('fund_requests')
                ->select('liquidated_amount')
                ->where('ci_id', Auth::user()->id)
                ->where('liquidated_amount', '!=', '')
                ->get();
        }

        $getall = 0;
        $real = 0;

        if (is_array($getminus) || is_object($getminus))
        {
            foreach ($getminus as $getminuses)
            {
//                $getall += $getminuses->amount;

                $getall += $getminuses->liquidated_amount;
            }
        }
        $real = ($realtimefund-$getall);

        DB::table('ci_fund_realtime_amount')
            ->where('user_id',$ciId[0]->ci_id)
            ->update([
                'fund_realtime' => $real
            ]);

        DB::table('ci_fund_remittances')
            ->where('fund_id',$fund_id)
            ->update([
                'confirm_date_time' => Carbon::now('Asia/Manila')
            ]);


        $getUserEmailSao = DB::table('fund_requests')
            ->select('sao_id')
            ->where('id', $fund_id)
            ->get();

        $finance_sms_notif = new SmsNotification();
        $finance_sms_notif->FundUploadedNotif($ciId[0]->ci_id,$sino_ang_gagamitin,$fund_id);

        $email = new EmailQueries();
        $email->CIReceiveFund($ciId[0]->ci_id,$sino_ang_gagamitin,$fund_id);
        $email->SentNotifSaoDis($ciId[0]->ci_id, $sino_ang_gagamitin, $fund_id, $getUserEmailSao[0]->sao_id);

    }

//    public function finance_done_all_fund_selected(Request $request)
//    {
//        $arrayDone = $request->arrayToDoneAll;
//
//        if($request->statWhere == 1)
//        {
//            if(count($arrayDone) >= 1)
//            {
//                for($i = 0; $i < count($arrayDone); $i++)
//                {
//                    $fund_id = $arrayDone[$i];
//                    $timeStamp = Carbon::now('Asia/Manila');
//
//                    $type = '';
//
//                    DB::table('fund_requests')
//                        ->where('id', $fund_id)
//                        ->update
//                        ([
//                            'approved_request_done' => 'Done'
//                        ]);
//
//                    $fundCi = DB::table('ci_fund_remittances')
//                        ->select('remittance_id', 'ci_shell_card_id', 'ci_atm_fund_id')
//                        ->where('fund_id', $fund_id)
//                        ->get();
//
//                    $ciId = DB::table('fund_requests')
//                        ->select('ci_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    if($fundCi[0]->ci_atm_fund_id != 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id == 0)
//                    {
//
//                        $type = 'atm';
//
//                        DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->update([
//                                'delivered_date' => $timeStamp,
//                            ]);
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id','fund_amount')
//                            ->get();
//
//                        $amount = base64_decode($ci_id[0]->fund_amount);
//
//                        $ci_atm_fund_id = DB::table('ci_atm_fund')
//                            ->select('id')
//                            ->where('fund_id', $fund_id)
//                            ->get();
//
//                        DB::table('ci_atm_fund')
//                            ->where('id', $ci_atm_fund_id[0]->id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update([
//                                'atm_send_date_time' => $timeStamp
//                            ]);
//
//                        DB::table('ci_atm_fund')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//
//                            ]);
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//
//                        $getfund = DB::table('ci_atm_fund')
//                            ->where('fund_id', $fund_id)
//                            ->where('receive_status','received')
//                            ->select('amount')
//                            ->get();
//
//                        $getfunddecoded = $getfund[0]->amount;
//
//                        $checkfund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id', $ci_id[0]->ci_id)
//                            ->count();
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id[0]->ci_id);
//                        $fund_audit->fund_logs('ATM SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$amount.'',$fund_id);
//
//                        if($checkfund == 0)
//                        {
//                            DB::table('ci_fund_realtime_amount')
//                                ->insert([
//                                    'user_id' => $ci_id[0]->ci_id,
//                                    'fund' => $getfunddecoded
//                                ]);
//                        }
//                        else
//                        {
//                            $fundgetter = DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->select('fund')
//                                ->get()[0]->fund;
//
//
//                            DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->update([
//                                    'fund' =>  ($getfunddecoded+$fundgetter)
//                                ]);
//                        }
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id[0]->ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) ATM FUND TRANSFER ; AMOUNT OF ' .$amount. ' , FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//                    else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id != 0 && $fundCi[0]->ci_shell_card_id == 0)
//                    {
//
//                        $type = 'remittance';
//
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id','fund_amount')
//                            ->get();
//
//                        DB::table('fund_requests')
//                            ->where('id', $fund_id)
//                            ->update
//                            ([
//                                'delivered_date' => $timeStamp
//                            ]);
//
//                        DB::table('remittance')
//                            ->where('fund_id', $fund_id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        $remittance_id = DB::table('remittance')
//                            ->where('fund_id',$fund_id)
//                            ->select('id','amount')
//                            ->get();
//
//
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'remittance_send_date_time' => $timeStamp
//                            ]);
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id[0]->ci_id);
//                        $fund_audit->fund_logs('REMITTANCE SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.base64_decode($remittance_id[0]->amount).'',$fund_id);
//
//                        DB::table('remittance')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//                            ]);
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//
//                        $getfund = DB::table('remittance')
//                            ->where('fund_id', $fund_id)
//                            ->where('receive_status','received')
//                            ->select('amount','sender')
//                            ->get();
//
//                        $getfunddecoded = base64_decode($getfund[0]->amount);
//
//                        $checkfund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id', $ci_id[0]->ci_id)
//                            ->count();
//
//                        if($checkfund == 0)
//                        {
//                            DB::table('ci_fund_realtime_amount')
//                                ->insert([
//                                    'user_id' => $ci_id[0]->ci_id,
//                                    'fund' => $getfunddecoded
//                                ]);
//                        }
//                        else
//                        {
//                            $fundgetter = DB::table('ci_fund_realtime_amount')
//                                ->where('user_id', $ci_id[0]->ci_id)
//                                ->select('fund')
//                                ->get()[0]->fund;
//
//
//                            DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->update([
//                                    'fund' =>  ($getfunddecoded+$fundgetter)
//                                ]);
//                        }
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id[0]->ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) REMITTANCE; AMOUNT OF ' .base64_decode($remittance_id[0]->amount).', FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//                    else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id != 0)
//                    {
//                        $type = 'shell card';
//
//                        DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->update([
//                                'delivered_date' => $timeStamp,
//                            ]);
//
//                        DB::table('ci_shell_include_fund')
//                            ->where('fund_id', $fund_id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id')
//                            ->get()[0]->ci_id;
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//                        //update
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update([
//                                'shell_send_date_time' =>$timeStamp
//                            ]);
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id);
//                        $fund_audit->fund_logs('SHELL CARD INCLUDED TO: '.$get_name->name.'',$fund_id);
//
//                        DB::table('ci_shell_include_fund')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//                            ]);
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) SHELL FUND, FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//
//                    $check = DB::table('ci_fund_realtime_amount')
//                        ->where('user_id',$ciId[0]->ci_id)
//                        ->select('fund')
//                        ->count();
//
//                    $getminus = 0;
//
//                    if($check == 0)
//                    {
//                        $realtimefund = 0;
//                    }
//                    else
//                    {
//                        $realtimefund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id',$ciId[0]->ci_id)
//                            ->select('fund')
//                            ->get()[0]->fund;
//
//
//                    }
//
//                    $getunliqTotal = DB::table('fund_requests')
//                        ->select('unliquidated_amount')
//                        ->where('success_hold_cancel', '')
//                        ->where('liquidation_status', '')
//                        ->get();
//
//                    $getall = 0;
//                    $real = 0;
//
//                    $unliqtot = 0;
//
//                    if(count($getunliqTotal) > 0)
//                    {
//                        for($h = 0; $h < count($getunliqTotal);$h++)
//                        {
//                            $unliqtot += (int)$getunliqTotal[$h]->unliquidated_amount;
//                        }
//                    }
//
//
//                    DB::table('ci_fund_realtime_amount')
//                        ->where('user_id',$ciId[0]->ci_id)
//                        ->update([
//                            'fund_realtime' => $unliqtot
//                        ]);
//                    DB::table('ci_fund_remittances')
//                        ->where('fund_id',$fund_id)
//                        ->update([
//                            'confirm_date_time' => Carbon::now('Asia/Manila')
//                        ]);
//
//                    $getUserEmailDisp = DB::table('fund_requests')
//                        ->select('dispatcher_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    $getUserEmailSao = DB::table('fund_requests')
//                        ->select('sao_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    $finance_sms_notif = new SmsNotification();
//                    $finance_sms_notif->FundUploadedNotif($ciId[0]->ci_id,'remittance',$fund_id);
//
//                    $email = new EmailQueries();
//                    $email->CIReceiveFund($ciId[0]->ci_id,'remittance',$fund_id);
//                    $email->SentNotifSaoDis($ciId[0]->ci_id, $type, $fund_id, $getUserEmailDisp[0]->dispatcher_id, $getUserEmailSao[0]->sao_id);
//                }
//                return response()->json('yes');
//            }
//            else
//            {
//                return response()->json('nope');
//            }
//        }
//        else if($request->statWhere == 2)
//        {
//            if(count($arrayDone) >= 1)
//            {
//                for($i = 0; $i < count($arrayDone); $i++)
//                {
//                    $fund_id = $arrayDone[$i];
//                    $timeStamp = Carbon::now('Asia/Manila');
//                    $type = '';
//
//                    DB::table('fund_requests')
//                        ->where('id', $fund_id)
//                        ->update
//                        ([
//                            'approved_request_done' => 'Done'
//                        ]);
//
//                    $fundCi = DB::table('ci_fund_remittances')
//                        ->select('remittance_id', 'ci_shell_card_id', 'ci_atm_fund_id')
//                        ->where('fund_id', $fund_id)
//                        ->get();
//
//                    $ciId = DB::table('fund_requests')
//                        ->select('ci_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    if($fundCi[0]->ci_atm_fund_id != 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id == 0)
//                    {
//                        $type = 'atm';
//
//                        DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->update([
//                                'delivered_date' => $timeStamp,
//                            ]);
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id','fund_amount')
//                            ->get();
//
//                        $amount = base64_decode($ci_id[0]->fund_amount);
//
//                        $ci_atm_fund_id = DB::table('ci_atm_fund')
//                            ->select('id')
//                            ->where('fund_id', $fund_id)
//                            ->get();
//
//                        DB::table('ci_atm_fund')
//                            ->where('id', $ci_atm_fund_id[0]->id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update([
//                                'atm_send_date_time' => $timeStamp
//                            ]);
//
//                        DB::table('ci_atm_fund')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//
//                            ]);
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//
//                        $getfund = DB::table('ci_atm_fund')
//                            ->where('fund_id', $fund_id)
//                            ->where('receive_status','received')
//                            ->select('amount')
//                            ->get();
//
//                        $getfunddecoded = $getfund[0]->amount;
//
//                        $checkfund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id', $ci_id[0]->ci_id)
//                            ->count();
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id[0]->ci_id);
//                        $fund_audit->fund_logs('ATM SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.$amount.'',$fund_id);
//
//                        if($checkfund == 0)
//                        {
//                            DB::table('ci_fund_realtime_amount')
//                                ->insert([
//                                    'user_id' => $ci_id[0]->ci_id,
//                                    'fund' => $getfunddecoded
//                                ]);
//                        }
//                        else
//                        {
//                            $fundgetter = DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->select('fund')
//                                ->get()[0]->fund;
//
//
//                            DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->update([
//                                    'fund' =>  ($getfunddecoded+$fundgetter)
//                                ]);
//                        }
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id[0]->ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) ATM FUND TRANSFER ; AMOUNT OF ' .$amount. ' , FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//                    else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id != 0 && $fundCi[0]->ci_shell_card_id == 0)
//                    {
//                        $type = 'remittance';
//
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id','fund_amount')
//                            ->get();
//
//                        DB::table('fund_requests')
//                            ->where('id', $fund_id)
//                            ->update
//                            ([
//                                'delivered_date' => $timeStamp
//                            ]);
//
//                        DB::table('remittance')
//                            ->where('fund_id', $fund_id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        $remittance_id = DB::table('remittance')
//                            ->where('fund_id',$fund_id)
//                            ->select('id','amount')
//                            ->get();
//
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'remittance_send_date_time' => $timeStamp
//                            ]);
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id[0]->ci_id);
//                        $fund_audit->fund_logs('REMITTANCE SENT TO: '.$get_name->name.'. IN THE AMOUNT OF: '.base64_decode($remittance_id[0]->amount).'',$fund_id);
//
//                        DB::table('remittance')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//                            ]);
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//
//                        $getfund = DB::table('remittance')
//                            ->where('fund_id', $fund_id)
//                            ->where('receive_status','received')
//                            ->select('amount','sender')
//                            ->get();
//
//                        $getfunddecoded = base64_decode($getfund[0]->amount);
//
//                        $checkfund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id', $ci_id[0]->ci_id)
//                            ->count();
//
//                        if($checkfund == 0)
//                        {
//                            DB::table('ci_fund_realtime_amount')
//                                ->insert([
//                                    'user_id' => $ci_id[0]->ci_id,
//                                    'fund' => $getfunddecoded
//                                ]);
//                        }
//                        else
//                        {
//                            $fundgetter = DB::table('ci_fund_realtime_amount')
//                                ->where('user_id', $ci_id[0]->ci_id)
//                                ->select('fund')
//                                ->get()[0]->fund;
//
//
//                            DB::table('ci_fund_realtime_amount')
//                                ->where('user_id',$ci_id[0]->ci_id)
//                                ->update([
//                                    'fund' =>  ($getfunddecoded+$fundgetter)
//                                ]);
//                        }
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id[0]->ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) REMITTANCE; AMOUNT OF ' .base64_decode($remittance_id[0]->amount).', FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//                    else if($fundCi[0]->ci_atm_fund_id == 0 && $fundCi[0]->remittance_id == 0 && $fundCi[0]->ci_shell_card_id != 0)
//                    {
//                        $type = 'shell_card';
//
//                        DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->update([
//                                'delivered_date' => $timeStamp,
//                            ]);
//                        DB::table('ci_shell_include_fund')
//                            ->where('fund_id', $fund_id)
//                            ->update
//                            ([
//                                'date_of_send' => $timeStamp
//                            ]);
//
//                        $ci_id = DB::table('fund_requests')
//                            ->where('id',$fund_id)
//                            ->select('ci_id')
//                            ->get()[0]->ci_id;
//
//                        DB::table('fund_request_endorsements')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            (
//                                [
//                                    'type'=>'Success'
//                                ]
//                            );
//                        //update
//                        DB::table('ci_fund_remittances')
//                            ->where('fund_id',$fund_id)
//                            ->update([
//                                'shell_send_date_time' =>$timeStamp
//                            ]);
//
//                        $fund_audit = new AuditFundQueries();
//                        $get_name = User::find($ci_id);
//                        $fund_audit->fund_logs('SHELL CARD INCLUDED TO: '.$get_name->name.'',$fund_id);
//
//
//                        DB::table('ci_shell_include_fund')
//                            ->where('fund_id',$fund_id)
//                            ->update
//                            ([
//                                'receive_status' => 'received',
//                                'receive_status_date_time' => Carbon::now('Asia/Manila')
//                            ]);
//
//                        DB::table('ci_logs_expenses')
//                            ->insert([
//                                'user_id'=>$ci_id,
//                                'activity_id' => $fund_id,
//                                'activity' => '(RECEIVES) SHELL FUND, FROM: '.Auth::user()->name,
//                                'type' => 'ci_receive_logs',
//                                'datetime' => Carbon::now('Asia/Manila')
//                            ]);
//                    }
//
//                    $check = DB::table('ci_fund_realtime_amount')
//                        ->where('user_id',$ciId[0]->ci_id)
//                        ->select('fund')
//                        ->count();
//
//                    $getminus = 0;
//
//                    if($check == 0)
//                    {
//                        $realtimefund = 0;
//                    }
//                    else
//                    {
//                        $realtimefund = DB::table('ci_fund_realtime_amount')
//                            ->where('user_id',$ciId[0]->ci_id)
//                            ->select('fund')
//                            ->get()[0]->fund;
//
//                    }
//
//
//
//                    $getunliqTotal = DB::table('fund_requests')
//                        ->select('unliquidated_amount')
//                        ->where('success_hold_cancel', '')
//                        ->where('liquidation_status', '')
//                        ->get();
//
//                    $getall = 0;
//                    $real = 0;
//
//                    $unliqtot = 0;
//
//                    if(count($getunliqTotal) > 0)
//                    {
//                        for($h = 0; $h < count($getunliqTotal);$h++)
//                        {
//                            $unliqtot += (int)$getunliqTotal[$h]->unliquidated_amount;
//                        }
//                    }
//
//
//                    DB::table('ci_fund_realtime_amount')
//                        ->where('user_id',$ciId[0]->ci_id)
//                        ->update([
//                            'fund_realtime' => $unliqtot
//                        ]);
//
//
//                    DB::table('ci_fund_remittances')
//                        ->where('fund_id',$fund_id)
//                        ->update([
//                            'confirm_date_time' => Carbon::now('Asia/Manila')
//                        ]);
//
//                    $getUserEmailDisp = DB::table('fund_requests')
//                        ->select('dispatcher_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    $getUserEmailSao = DB::table('fund_requests')
//                        ->select('sao_id')
//                        ->where('id', $fund_id)
//                        ->get();
//
//                    $finance_sms_notif = new SmsNotification();
//                    $finance_sms_notif->FundUploadedNotif($ciId[0]->ci_id,'atm',$fund_id);
//
//                    $email = new EmailQueries();
//                    $email->CIReceiveFund($ciId[0]->ci_id,'atm',$fund_id);
//                    $email->SentNotifSaoDis($ciId[0]->ci_id, $type, $fund_id, $getUserEmailDisp[0]->dispatcher_id, $getUserEmailSao[0]->sao_id);
//                }
//                return response()->json('yes');
//            }
//            else
//            {
//                return response()->json('nope');
//            }
//        }
//    }

    public function finance_get_fund_count()
    {
        $getNewRequest = DB::table('fund_requests')
            ->where('approved_request_done', '')
            ->where('sao_status', 'APPROVED')
            ->count();

        $getDoneRequest = DB::table('fund_requests')
            ->where(function ($query)
            {
                return $query->where('approved_request_done', 'Done')
                    ->orWhere('approved_request_done', 'Assigned');
            })
            ->where(function ($query)
            {
                return $query->where('success_hold_cancel', '')
                    ->orWhere('success_hold_cancel', 'Override');
            })
            ->where('sao_status', 'APPROVED')
            ->count();

        $getPendingRequest = DB::table('fund_requests')
            ->where('approved_request_done', 'Pending')
            ->where('sao_status', 'APPROVED')
            ->count();

        $getHoldRequest = DB::table('fund_requests')
            ->where('success_hold_cancel', 'Hold')
            ->where('sao_status', 'APPROVED')
            ->count();

        $getCanRequest = DB::table('fund_requests')
            ->where('success_hold_cancel', 'Cancel')
            ->where('sao_status', 'APPROVED')
            ->count();

        $getUnliNew = DB::table('fund_requests')
            ->where('approved_request_done', 'Assigned')
            ->where('sao_status', 'APPROVED')
            ->count();

        return response()->json([$getNewRequest,$getDoneRequest,$getPendingRequest, $getHoldRequest, $getCanRequest, $getUnliNew]);
    }

    public function finance_upload_bulk_excel(Request $request)
    {
        $file = $request->file('excel');
        if ($file != null)
        {

            $name = 'Finance Attendance.' . $file->getClientOriginalExtension();
            $alph = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I' , 'J', 'K', 'L', 'M', 'N', '0', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $file->move(storage_path('/bulk_excel_bi/'), $name);
            $excel = Excel::load(storage_path('/bulk_excel_bi/' . $name), function ($reader) {
                $reader->toArray();
                $reader->noHeading();
                $reader->getSheet(0);
            })->get();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('/bulk_excel_bi/' . $name));
            $sheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $start = 0;
            $newArray_emp_name = [];
            $newArray_date_yest = [];
            $newArray_in_yest= [];
            $newArray_date = [];
            $splitNameEmp = '';

            if($excel[0][0] != 'Daily Time Record')
            {

                for($i = 0; $i < count($excel); $i++)
                {
                    for($j = 0; $j < count($excel[$i]); $j++) {


                        if(preg_match('/(Employee:)/', $excel[$i][$j]))
                        {
                            $start++;
                            $empwithColon = explode(':', $excel[$i][$j]);
                            $valSplit1 = $empwithColon[1];
                            $splitNameEmp = explode('(', $empwithColon[1]);
                            $empName = $splitNameEmp[0];

                            $newArray_emp_name[$start] = $empName;
                        }


                        if (preg_match('/(Date)/', $excel[$i][$j])) {

                            //date
                            if ($i + 2 >= count($excel))
                            {

                            }
                            else
                            {
                                $newArray_date_yest[$start] = $excel[$i+2];
                                $newArray_date[$start] = $excel[$i+3];
                            }
                        }
                    }

                }
                //                return $excel[0][0];
                return response()->json([$newArray_emp_name,$newArray_date_yest,$newArray_date, count($newArray_emp_name), 1]);
            }
            else
            {

                $newVal_array = [];
                $newVal_date = [];
                $newVal_date_second = [];
                $newarray4Timein = [];
                $newarray4Timeout = [];
                $newarray4Timeout_final = [];
                $newarray4Timein2nd = [];
                $newarray4Timeout2nd = [];
                $seconddate = [];
                $winnerOut = [];

                $s = 0;
                for($i = 0; $i < count($excel); $i++)
                {
                    for($j = 0; $j < count($excel[$i]); $j++)
                    {
                        if(is_string($excel[$i][$j]))
                        {
                            if($excel[$i][$j] == 'Daily Time Record' || $excel[$i][$j] == 'Start Date' || $excel[$i][$j] == 'End Date' || $excel[$i][$j] == 'IN' || $excel[$i][$j] == 'OUT')
                            {

                            }
                            else
                            {

                                //time checker
                                $exp = explode(':',$excel[$i][$j]);
                                if(count($exp) == 1)
                                {
                                    //date checker
                                    $exp_q = explode('/',$excel[$i][$j]);
                                    if(count($exp_q) == 1)
                                    {
                                        $datenowforloop = explode(' ', $excel[$i+1][$j]);
                                        $newVal_array[$s][0] = $excel[$i][$j];
                                        $newVal_array[$s][1] = $datenowforloop[0];
                                        $newVal_array[$s][2] = $excel[$i+1][$j+1];

                                        $get_span_loop = 1;


                                        for($ctr = 2; $ctr<10; $ctr++)
                                        {
                                            $get_span_loop++;
                                            $exp_check_date_second = explode('/',$excel[$i+$ctr][$j]);
                                            $newVal_array[$s][4] = $excel[$i+$ctr][$j+1];
                                            if(count($exp_check_date_second) >= 2)
                                            {
                                                $seconddate = explode(' ', $excel[$i+$ctr][$j]);
                                                $newVal_date_second[$s] = $seconddate[0];
                                                $ctr = 10;
                                            }
                                        }

                                        $get_timeout_compa_1 = [];
                                        $get_timeout_compa_2 = [];
                                        $get_timeout_compa_3 = [];
                                        $counter_1 = 0;
                                        $counter_2 = 0;
                                        $counter_3 = 0;

                                        for($i_i = 1 ; $i_i < $get_span_loop; $i_i++)
                                        {

                                            if($excel[$i+$i_i][$j+2] != null)
                                            {
                                                $get_timeout_compa_1[$counter_1] = $excel[$i+$i_i][$j+2];
                                                $counter_1++;
                                            }
                                            else
                                            {
                                                $get_timeout_compa_1[$counter_1] = null;
                                                $counter_1++;
                                            }

                                            if($excel[$i+$i_i][$j+4] != null)
                                            {
                                                $get_timeout_compa_2[$counter_2] = $excel[$i+$i_i][$j+4];
                                                $counter_2++;
                                            }
                                            else
                                            {
                                                $get_timeout_compa_2[$counter_2] = null;
                                                $counter_2++;
                                            }

                                            if($excel[$i+$i_i][$j+6] != null)
                                            {
                                                $get_timeout_compa_3[$counter_3] = $excel[$i+$i_i][$j+6];
                                                $counter_3++;
                                            }
                                            else
                                            {
                                                $get_timeout_compa_3[$counter_3] = null;
                                                $counter_3++;
                                            }
                                        }
                                        $newarray4Timeout[$s][0] = $get_timeout_compa_1;
                                        $newarray4Timeout[$s][1] = $get_timeout_compa_2;
                                        $newarray4Timeout[$s][2] = $get_timeout_compa_3;

                                        $rotation = 'up';


                                        for($qw = 0; $qw < 3; $qw++)
                                        {
                                            //first_up_down
                                            //second_down_uo
                                            //third_up_down

                                            if($rotation == 'up')
                                            {

                                                for($www = count($newarray4Timeout[$s][$qw])-1; $www>0; $www--)
                                                {
                                                    if($newarray4Timeout[$s][$qw][$www] != null)
                                                    {
                                                        $newarray4Timeout_final[$s] = $newarray4Timeout[$s][$qw][$www];
                                                        break;
                                                    }
                                                    else
                                                    {
                                                        $newarray4Timeout_final[$s] = $newarray4Timeout[$s][$qw][$www];
                                                    }
                                                }

                                                $rotation = 'down';
                                            }
                                            else if($rotation == 'down')
                                            {

                                                for($ww = 0; $ww < count($newarray4Timeout[$s][$qw]); $ww++)
                                                {
                                                    if($newarray4Timeout[$s][$qw][$ww] != null)
                                                    {
                                                        $newarray4Timeout_final[$s] = $newarray4Timeout[$s][$qw][$ww];
                                                        break;
                                                    }
                                                    else
                                                    {
                                                        $newarray4Timeout_final[$s] = $newarray4Timeout[$s][$qw][$ww];
                                                    }
                                                }

                                                $rotation = 'up';

                                            }

                                        }
                                        //get_first_day_out
                                        $newVal_array[$s][3] = $newarray4Timeout_final[$s];

                                        $s++;
                                    }
                                }

                            }
                        }
                    }
                }

                return response()->json([$newVal_array,$newVal_date_second,2]);
            }
        }
        else
        {
            echo 'hehe';
        }
    }

    public function finance_hold_ci_fund(Request $request)
    {
        $holdFund = 0;

        $getData = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select('ci_id', 'success_hold_cancel', 'fund_amount')
            ->get();

        if($getData[0]->success_hold_cancel == '')
        {
            DB::table('fund_requests')
                ->where('id', $request->id)
                ->update
                ([
                    'success_hold_cancel' => 'Hold',
                    'hold_date_time' => Carbon::now('Asia/Manila')
                ]);

            $check = DB::table('ci_fund_realtime_amount')
                ->where('user_id',$getData[0]->ci_id)
                ->select('fund')
                ->count();

            $getUnliqAmount = DB::table('fund_requests')
                ->select('unliquidated_amount')
                ->where('id', $request->id)
                ->get();

            if($check == 0)
            {
                $realtimefund = 0;
            }
            else
            {
                $realtimefund = DB::table('ci_fund_realtime_amount')
                    ->where('user_id',$getData[0]->ci_id)
                    ->select('fund_realtime', 'hold_fund')
                    ->get();
            }

            $deductAmt = (int)$getUnliqAmount[0]->unliquidated_amount;

            $deductNow = ($realtimefund[0]->fund_realtime)-$deductAmt;

            $addtoHold = ($realtimefund[0]->hold_fund)+$deductAmt;


            DB::table('ci_fund_realtime_amount')
                ->where('user_id',$getData[0]->ci_id)
                ->update
                ([
                    'fund_realtime' => $deductNow,
                    'hold_fund' => $addtoHold
                ]);

            $getEndorsement = DB::table('fund_request_endorsements')
                ->select('endorsement_id')
                ->where('fund_id', $request->id)
                ->where(function ($query)
                {
                    return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                        ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                })
                ->get();

            for($v = 0; $v < count($getEndorsement); $v++)
            {
                DB::table('endorsements')
                    ->where('id', $getEndorsement[$v]->endorsement_id)
                    ->update
                    ([
                        'fund_request' => 'fund_hold'
                    ]);
            }

//            DB::table('fund_request_endorsements')
//                ->where('fund_id', $request->id)
//                ->delete();

            DB::table('ci_logs_expenses')
                ->insert([
                    'user_id'=>$getData[0]->ci_id,
                    'activity_id' => $request->id,
                    'activity' => 'FUND REQUEST ID : ' . $request->id . ' WITH AMOUNT OF ₱ ' . base64_decode($getData[0]->fund_amount) . ' NOW ON-HOLD : ' .Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);


            return 'ok';
        }
        else if($getData[0]->success_hold_cancel == 'Hold')
        {
            return 'no';
        }
    }

    public function finance_cancel_ci_fund(Request $request)
    {
        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'success_hold_cancel' => 'Cancel'
            ]);

        $getEndorsement = DB::table('fund_request_endorsements')
            ->select('endorsement_id')
            ->where('fund_id', $request->id)
            ->where(function ($query)
            {
                return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                    ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
            })
            ->get();

        for($g = 0; $g < count($getEndorsement); $g++)
        {
            DB::table('endorsements')
                ->where('id', $getEndorsement[$g]->endorsement_id)
                ->update
                ([
                    'fund_request' => ''
                ]);
        }

        DB::table('fund_request_endorsements')
            ->where('fund_id', $request->id)
            ->where(function ($query)
            {
                return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                    ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
            })
            ->delete();

        $getData = DB::table('fund_requests')
            ->where('id', $request->id)
            ->select('ci_id', 'fund_amount')
            ->get();

        $realtimefund = 0;

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
                ->select('fund', 'fund_realtime')
                ->get();
        }

        $getUnliqAmount = DB::table('fund_requests')
            ->select('unliquidated_amount')
            ->where('id', $request->id)
            ->get();

        $deductAmt = (int)$getUnliqAmount[0]->unliquidated_amount;
        $real = (($realtimefund[0]->fund)-$deductAmt);
        $real2 = (($realtimefund[0]->fund_realtime)-$deductAmt);

        DB::table('ci_fund_realtime_amount')
            ->where('user_id',$getData[0]->ci_id)
            ->update([
                'fund_realtime' => $real,
                'fund' => $real2
            ]);

        DB::table('ci_logs_expenses')
            ->insert([
                'user_id'=>$getData[0]->ci_id,
                'activity_id' => $request->id,
                'activity' => 'FUND REQUESTED : '. $request->id . ' WITH AMOUNT OF ₱ ' . base64_decode($getData[0]->fund_amount) .' CANCELLED : ' .Auth::user()->name,
                'type' => 'ci_receive_logs',
                'datetime' => Carbon::now('Asia/Manila')
            ]);
    }

    public function finance_unhold_ci_fund(Request $request)
    {
        $checkHold = DB::table('fund_requests')
            ->select('success_hold_cancel', 'ci_id', 'fund_amount')
            ->where('id', $request->id)
            ->get();

        $getEndoDelete = DB::table('fund_request_endorsements')
            ->where('fund_id', $request->id)
            ->count();

        if($checkHold[0]->success_hold_cancel == 'Hold')
        {
            if($getEndoDelete > 0)
            {
                DB::table('fund_requests')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'success_hold_cancel' => '',
                        'hold_date_time' => null
                    ]);

                $getAccs = DB::table('fund_request_endorsements')
                    ->select('endorsement_id')
                    ->where('fund_id', $request->id)
                    ->where(function ($query)
                    {
                        return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                            ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                    })
                    ->get();

                for($h = 0; $h < count($getAccs); $h++)
                {
                    DB::table('endorsements')
                        ->where('id', $getAccs[$h]->endorsement_id)
                        ->update
                        ([
                            'fund_request' => 'fund_uploaded'
                        ]);
                }

                DB::table('ci_logs_expenses')
                    ->insert([
                        'user_id'=>$checkHold[0]->ci_id,
                        'activity_id' => $request->id,
                        'activity' => 'FUND REQUEST ID : ' . $request->id . ' WITH AMOUNT OF ₱ ' . base64_decode($checkHold[0]->fund_amount) . ' REMOVED FROM ON-HOLD STATUS : ' .Auth::user()->name,
                        'type' => 'ci_receive_logs',
                        'datetime' => Carbon::now('Asia/Manila')
                    ]);
                return 'ok';
            }
            else if($getEndoDelete == 0)
            {
                return 'cant';
            }
        }
        else if($checkHold[0]->success_hold_cancel == '')
        {
            return 'no';
        }
    }

    public function finance_revise_fund_request(Request $request)
    {
        DB::table('fund_requests')
            ->where('id', $request->id)
            ->update
            ([
                'delivered_date' => '',
                'approved_request_done' => '',
                'liquidated_amount' => '',
                'unliquidated_amount' => ''
            ]);

        $countRem = DB::table('ci_atm_fund')
            ->where('fund_id', $request->id)
            ->count();

        if($countRem > 0)
        {
            DB::table('ci_atm_fund')
                ->where('fund_id', $request->id)
                ->delete();
        }
        else
        {

        }


        $countAtm = DB::table('remittance')
            ->where('fund_id', $request->id)
            ->count();

        if($countAtm > 0)
        {
            DB::table('remittance')
                ->where('fund_id', $request->id)
                ->delete();
        }
        else
        {

        }

        $check = DB::table('ci_fund_remittances')
            ->where('fund_id',$request->id)
            ->count();

        if($check>0)
        {
            //update
            DB::table('ci_fund_remittances')
                ->where('fund_id',$request->id)
                ->delete();
        }
        else
        {

        }

        $get_endorsements_id = DB::table('fund_request_endorsements')
            ->where('fund_id',$request->id)
            ->get();

        foreach ($get_endorsements_id as $ids)
        {
            DB::table('endorsements')
                ->where('id', $ids->endorsement_id)
                ->update([
                    'fund_request' => 'fund_requested'
                ]);
        }
    }

    public function finance_billing_coborrower_same_add_checker(Request $request)
    {
        $get_array_accounts = $request->array_accounts;

        $get_coob_array = [];
        $get_coob_array_count = [];

        $cout_q = 0;

        $checkifCob = false;

        for($ctr = 0; $ctr < count($get_array_accounts); $ctr++)
        {
            $cout = 0;
            $bool_for_cout_q = false;
            $get_coob_array_count[$ctr] = [];
            $checkifCob = false;

            for($i = 0; $i < count($get_array_accounts[$ctr]); $i++)
            {
                $id = $get_array_accounts[$ctr][$i];

//                $check_type = DB::table()

                $get_count = DB::table('coborrowers')
                    ->select
                    (
                        'coborrower_name',
                        'coborrower_address',
                        'coborrower_province'
                    )
                    ->where('endorsement_id',$id)
                    ->get();

                $getAccount = DB::table('endorsements')
                    ->select('account_name', 'type_of_request')
                    ->where('id', $id)
                    ->get();

//                $get_coob_array_count[$ctr][$i] =  count($get_count);

                if(count($get_count) > 0)
                {
                    $checkifCob = true;

                    $get_coob_array[$cout_q][0] = $getAccount[0]->account_name.'||--:--||'.$id.'||--:--||'.'<b>'.$getAccount[0]->type_of_request.'</b>';

                    for($ii = $i-1; $ii >= 0; $ii--)
                    {
                        $ider = $get_array_accounts[$ctr][$ii];

                        $etcTor = '';

                        $get_count_er = DB::table('endorsements')
                            ->select('account_name', 'address', 'provinces', 'type_of_request')
                            ->where('id',$ider)
                            ->get();

                        if($get_count_er[0]->type_of_request == 'BVR')
                        {
                            $getBusName = DB::table('businesses')
                                ->select('business_name')
                                ->where('endorsement_id', $ider)
                                ->get()[0]->business_name;

                            $etcTor = '<b>BVR</b> : ' .$getBusName;

                        }
                        else if($get_count_er[0]->type_of_request == 'EVR')
                        {
                            $getEmpName = DB::table('employers')
                                ->select('employer_name')
                                ->where('endorsement_id', $ider)
                                ->get()[0]->employer_name;

                            $etcTor = '<b>EVR</b> : ' .$getEmpName;
                        }
                        else
                        {
                            $etcTor = '<b>PDRN</b>';
                        }

                        if($get_count[0]->coborrower_address == $get_count_er[0]->address && $get_count[0]->coborrower_province == $get_count_er[0]->provinces)
                        {
                            $cout++;
                            $get_coob_array[$cout_q][$cout] = $get_count_er[0]->account_name.'||--:--||'.$ider.'||--:--||'.$etcTor.'';
                        }
                    }

                    if($bool_for_cout_q == false)
                    {
                        $cout_q++;
                        $bool_for_cout_q = true;
                    }
                }
            }

            if($checkifCob == false)
            {
                for($i = count($get_array_accounts[$ctr]); $i > 0; $i--)
                {
                    $id = $get_array_accounts[$ctr][$i-1];

                    $etcTor = '';

                    $getAcctName = DB::table('endorsements')
                        ->select('account_name', 'address', 'provinces', 'type_of_request')
                        ->where('id', $id)
                        ->get();

                    if($getAcctName[0]->type_of_request == 'BVR')
                    {
                        $getBusName = DB::table('businesses')
                            ->select('business_name')
                            ->where('endorsement_id', $id)
                            ->get()[0]->business_name;

                        $etcTor = '<b>BVR</b> : ' .$getBusName;

                    }
                    else if($getAcctName[0]->type_of_request == 'EVR')
                    {
                        $getEmpName = DB::table('employers')
                            ->select('employer_name')
                            ->where('endorsement_id', $id)
                            ->get()[0]->employer_name;

                        $etcTor = '<b>EVR</b> : ' .$getEmpName;
                    }
                    else
                    {
                        $etcTor = '<b>PDRN</b>';
                    }

                    $get_coob_array[$cout_q][$cout] = $getAcctName[0]->account_name.'||--:--||'.$id.'||--:--||'.$etcTor.'';

                    $cout++;
                }

                if($bool_for_cout_q == false)
                {
                    $cout_q++;
                    $bool_for_cout_q = true;
                }
            }
        }

//        return response()->json([$get_coob_array_count, $get_coob_array]);
        return response()->json($get_coob_array);
    }

    public function finance_get_manage_list()
    {
        $getManagementList = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.name as  name')
            ->where('role_user.role_id', 5)
            ->get();

        return response()->json($getManagementList);
    }

    public function finance_fund_get_requestor_remarks(Request $request)
    {
        $fund_id = $request->id;

        $get_remarks_view = DB::table('fund_requests')
            ->join('users as sao_name', 'sao_name.id', '=', 'fund_requests.sao_id')
            ->leftjoin('users as dispatcher_name', 'dispatcher_name.id', '=', 'fund_requests.dispatcher_id')
            ->select(
                [
                    'fund_requests.manage_approved_id as manage_id',
                    'fund_requests.dispatcher_remarks as disp_remarks',
                    'fund_requests.sao_remarks as sao_remarks',
                    'sao_name.name as sao_name',
                    'dispatcher_name.name as disp_name',
                ]
            )
            ->where('fund_requests.id', $fund_id)
            ->get();

        return response()->json($get_remarks_view);
    }

    public function finance_edit_ci_expenses(Request $request)
    {
        $sms = new SmsNotification();
        $fundIdArray = $request->aray_editted_id;
        $edittedFund = $request->aray_editted;
        $oldFund = $request->old_array_sum;
        $newFund = $request->array_sum;
        $remarks = $request->finance_remarks;
        $timestamp = Carbon::now('Asia/Manila');
        $forRemarks = '';
        $newUnLiqAmount = (int)$oldFund - (int)$newFund;
        $valueChecker = '';

        $check_if_already_have = DB::table('audit_reviewed_ci_liquidation_remarks')
            ->where('fund_id', $request->fund_id)
            ->get();

        $getOrig = DB::table('fund_requests')
            ->where('id', $request->fund_id)
            ->select('fund_original_amount')
            ->get();

        $valueChecker = DB::table('fund_requests')
            ->where('id', $request->fund_id)
            ->select([
                'liquidated_amount'
            ])
            ->get()[0]->liquidated_amount;

        for($i = 0; $i < count($fundIdArray); $i++)
        {
            DB::table('fund_request_liquidate')
                ->where('id', $fundIdArray[$i])
                ->update([
                    'audit_liquidate_amount' => $edittedFund[$i],
                    'updated_at' => $timestamp
                ]);
        }

        if((int)$valueChecker == (int)$newFund)
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
            $forRemarks = 'Modified liquidated amount from ' . $oldFund . ' to ' . $newFund . ' with a remarks: '. $remarks;
        }

        if(count($check_if_already_have) > 0)
        {
            DB::table('fund_requests')
                ->where('id', $request->fund_id)
                ->update([
                    'unliquidated_amount' => $newUnLiqAmount,
                    'liquidated_amount' => $newFund,
                    'finance_liq_rem' => $remarks,
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
                    'liquidated_amount' => $newFund,
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

    public function finance_cancel_fund_request(Request $request)
    {
        $saoStatus = DB::table('fund_requests')
            ->select
            (
                'sao_status',
                'ci_id'
            )
            ->where('id',base64_decode($request->id))
            ->first();

//        return response()->json($saoStatus);

        if($saoStatus->sao_status=='APPROVED')
        {
//            return response()->json('error');

            DB::table('fund_requests')
                ->where('id',base64_decode($request->id))
                ->update
                (
                    [
                        'dispatcher_status'=>strtoupper('CANCELLED'),
                        'finance_status'=>strtoupper('CANCELLED'),
                        'sao_status'=> ''
                    ]
                );


            DB::table('fund_request_endorsements')
                ->where('fund_id',base64_decode($request->id))
                ->where(function ($query)
                {
                    return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                        ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                })
                ->update
                (
                    [
                        'type'=>'Cancelled',
                        'type_label'=>'cancel_fund',
                    ]
                );

            $get_endorsements_id = DB::table('fund_request_endorsements')
                ->where('fund_id',base64_decode($request->id))
                ->get();

            foreach ($get_endorsements_id as $ids)
            {

                DB::table('endorsements')
                    ->where('id', $ids->endorsement_id)
                    ->update([
                        'fund_request' => ''
                    ]);

            }

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($saoStatus->ci_id);
            $fund_audit->fund_logs('FUND REQUEST CANCELLED FOR: '.$get_name->name.'',base64_decode($request->id));
            return response()->json('success');
        }
        else if($saoStatus->sao_status=='DISAPPROVED')
        {
            return response()->json('disapproved');
        }
    }

    public function finance_get_audit_remarks(Request $request)
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

    public function finance_eq_proc_pending_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.requestor_name as name',
                'admin_requisition.date_request as date',
                'admin_requisition_categ.req_tor as tor',
                'admin_requisition_categ.req_categ as categ',
                'admin_requisition_categ.req_type_1 as type_1',
                'admin_requisition_categ.req_type_2 as type_2',
                'admin_requisition_categ.req_others as others'
            ])
            ->where('admin_requisition.out_status', 'Approved')
            ->where('admin_requisition.request_status', 'Approved')
            ->where('admin_requisition.finance_status', 'Finance Process');

        return DataTables::of($getData)
            ->make(true);
    }

    public function finance_get_po_details(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_purchase_order', 'admin_purchase_order.requi_id', '=', 'admin_requisition.id')
            ->join('admin_accredited_suppliers', 'admin_accredited_suppliers.id', '=', 'admin_purchase_order.supplier_id')
            ->join('admin_accredited_suppliers_terms', 'admin_accredited_suppliers_terms.id', '=', 'admin_purchase_order.term_payment')
            ->join('users', 'users.id', '=', 'admin_purchase_order.prepared_by')
            ->select
            ([
                'admin_purchase_order.id as id',
                'admin_purchase_order.po_no as po_no',
                'admin_purchase_order.po_date as po_date',
                'admin_accredited_suppliers.supp_name as supp_name',
                'admin_accredited_suppliers.contact_person as contact_person',
                'admin_accredited_suppliers.supp_address as supp_address',
                'admin_accredited_suppliers.con_num as con_num',
                'admin_accredited_suppliers.sup_email as sup_email',
                'admin_accredited_suppliers.created_at as date_accred',
                'admin_accredited_suppliers_terms.supp_term as supp_term',
                'admin_purchase_order.delivery_date as delivery_date',
                'admin_purchase_order.total_amount as amount',
                'admin_purchase_order.twelve_vat as twelve',
                'admin_purchase_order.grand_total as grand_total',
                'users.name as name'
            ])
            ->where('admin_requisition.id', $request->id)
            ->get();

        $getData2 = DB::table('admin_purchase_order_items')
            ->where('po_id', $getData[0]->id)
            ->get();

        $getData3 = DB::table('admin_purchase_order_notes')
            ->where('po_id', $getData[0]->id)
            ->get();

        return response()->json([$getData, $getData2, $getData3 ]);

    }

    public function finance_requisition_add_instruction(Request $request)
    {
        $count = $request->count;

        $getData = DB::table('admin_requisition')
            ->select('requestor_name', 'requested_for_id', 'office_loc_dep_pos', 'user_id', 'admin_approver_id')
            ->where('id', $request->id)
            ->get();

        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'finance_status' => 'Finance Done',
                'finance_remarks' => $request->remarks,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $remVar = '';


        if($count > 0)
        {
            for($i = 0; $i < $count; $i++)
            {
                $file = $request->file('file-' . $i . '');

                if($file != null)
                {
                    $name = $file->getClientOriginalName();

                    $file->move(storage_path('/admin_requi_finance_files/' . $request->id . '/'), $name);
//

                    DB::table('admin_requisition_finance_files')
                        ->insert
                        ([
                            'requi_id' => $request->id,
                            'file_name' => $name,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }

            $remVar = 'and attachments';

        }

        $logs = new AuditQueries();

        $logs->assign_items('Added remarks '.$remVar.' for requisition no: '.$request->id.'', '','',Auth::user()->id, $request->remarks);
    }

    public function finance_eq_proc_done_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.requestor_name as name',
                'admin_requisition.date_request as date',
                'admin_requisition_categ.req_tor as tor',
                'admin_requisition_categ.req_categ as categ',
                'admin_requisition_categ.req_type_1 as type_1',
                'admin_requisition_categ.req_type_2 as type_2',
                'admin_requisition_categ.req_others as others',
                'admin_requisition.request_status as req_stat',
                'admin_requisition.done_remarks as done_rem'
            ])
            ->where('admin_requisition.out_status', 'Approved')
            ->where(function ($query) {
                return $query->where('admin_requisition.request_status', '=', 'Approved')
                    ->orwhere('admin_requisition.request_status', '=', 'Done');
            })
            ->where('admin_requisition.finance_status', 'Finance Done');

        return DataTables::of($getData)
            ->make(true);
    }
    
    public function tableGetBillingManage()
    {
        $rateTable = DB::table('rates')
            ->join('municipalities','municipalities.id','=','rates.municipality_id')
            ->join('provinces','provinces.id','=','rates.province_id')
            ->join('users','users.id','=','rates.user_id')
            ->select(['municipalities.muni_name','provinces.name as prov_name','users.name','rates.rate']);

        return DataTables::of($rateTable)
            ->make(true);
    }
    
    public function cc_billing_report_table(Request $request)
    {
        $max = $request->q_max;
        $min = $request->q_min;

        $getAccnt = DB::table('bi_endorsements')
            ->join('municipalities', 'municipalities.id', '=', 'bi_endorsements.present_muni')
            ->join('provinces', 'provinces.id', '=', 'bi_endorsements.present_province')
            ->where('bi_endorsements.bi_id', '=', $request->search_option)
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.status', '!=', 4)
                    ->orwhere('bi_endorsements.status', '!=', 199)
                    ->orwhere('bi_endorsements.cancel_bool', '!=', 'Cancelled');
            })
            ->whereDate('bi_endorsements.created_at', '<=', $max)
            ->whereDate('bi_endorsements.created_at', '>=', $min)
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.billing_status', '=', null)
                    ->orwhere('bi_endorsements.billing_status', '=', '');
            })
            ->select([
                'bi_endorsements.id as id',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.created_at as date_time_endorse',
                'bi_endorsements.present_address as address',
                'municipalities.muni_name as muni_name',
                'provinces.name as prov_name',
                'bi_endorsements.date_time_finished as time_sent',
                'bi_endorsements.status as status',
                'bi_endorsements.status as status2'
            ]);
        return DataTables::of($getAccnt)
            ->editcolumn('status', function($query)
            {
                if($query->status == 0)
                {
                    return 'New Endorsement';
                }
                else if($query->status == 10)
                {
                    return 'Finished Account';
                }
                else
                {
                    return 'Processing';
                }
            })
            ->rawColumns([
                'status'
            ])
            ->make(true);
    }

    public function cc_bank_billing_report_table(Request $request)
    {
        $max = $request->q_max;
        $min = $request->q_min;

        $getAccnt = DB::table('bi_endorsements')
            ->where('bi_endorsements.bi_id', '=', $request->search_option)
            ->whereDate('bi_endorsements.created_at', '<=', $max)
            ->whereDate('bi_endorsements.created_at', '>=', $min)
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.status', '!=', 4)
                    ->orwhere('bi_endorsements.status', '!=', 199)
                    ->orwhere('bi_endorsements.cancel_bool', '!=', 'Cancelled');
            })
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.billing_status', '=', null)
                    ->orwhere('bi_endorsements.billing_status', '=', '');
            })
            ->select([
                'bi_endorsements.id as id',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.created_at as date_time_endorse',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.date_time_finished as time_sent',
                'bi_endorsements.status as status',
                'bi_endorsements.status as status2'
            ]);
        return DataTables::of($getAccnt)
            ->editcolumn('status', function($query)
            {
                if($query->status == 0)
                {
                    return 'New Endorsement';
                }
                else if($query->status == 10)
                {
                    return 'Finished Account';
                }
                else
                {
                    return 'Processing';
                }
            })
            ->rawColumns([
                'status'
            ])
            ->make(true);
    }

    public function finance_create_billing_invoice(Request $request)
    {
        $manuallyAccnt = $request->inputted_array;
        $id_holder = $request->id_array;
        $invoice_id = '';
        $chunk_it = '';

        $invoice_id = DB::table('billing_invoice')
            ->insertGetId([
                'bi_id' => $request->client_id,
                'invoice_status' => 'New',
                'invoice_type' => $request->invoice_type,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        if($id_holder > 0 || sizeof($manuallyAccnt) > 0)
        {
            if($id_holder > 0)
            {
                foreach($id_holder as $chunk_id)
                {
                    $chunk_it = explode('|-|-|', $chunk_id);

                    DB::table('bi_endorsements')
                        ->where('id', '=', $chunk_it[0])
                        ->update([
                            'billing_status' => 'New'
                        ]);

                    DB::table('billing_invoice_to_account')
                        ->insert([
                            'invoice_id' => $invoice_id,
                            'endorsement_id' => $chunk_it[0],
                            'amount' => $chunk_it[1],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }


            if(sizeof($manuallyAccnt) > 0)
            {
                for($i = 0; $i < sizeof($manuallyAccnt); $i++)
                {
                    DB::table('billing_invoice_to_account_manual')
                        ->insert([
                            'invoice_id' => $invoice_id,
                            'account_name' => $manuallyAccnt[$i]['accnt_name'],
                            'account_address' => $manuallyAccnt[$i]['accnt_add'],
                            'type_of_request' => $manuallyAccnt[$i]['type_of_request'],
                            'amount' => $manuallyAccnt[$i]['amount'],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }


            DB::table('billing_invoice_logs')
                ->insert([
                    'invoice_id' => $invoice_id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'INVOICE CREATED',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'success';
        }
        else
        {
            return 'no selected account';
        }
    }
}
