<?php

namespace App\Http\Controllers;


use App\CiLoginTrail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CIcheckerOffline extends Controller
{

    public function getview()
    {
        return view('layouts.offlinechecker');
    }

    public function getview_address_checker(Request $req)
    {
        $lat = $req->lat;
        $long = $req->long;
        $ci_id = Auth::user()->id;

        return view('layouts.address_check_ci', compact('lat', 'long', 'ci_id'));
    }

    public function offlinechecker(Request $request)
    {


        $timelimitegetter = DB::table('lat_longs')
            ->get();

        $timenow = Carbon::now('Asia/Manila');


        return [$timelimitegetter, $timenow];
    }

    public function offlineupdater(Request $request)
    {

        DB::table('lat_longs')
            ->where('CI_ID', $request->id)
            ->update(['Status' => 'Offline']);

        return $request->id;
    }

    public function addressupdater(Request $request)
    {

        if($request->id == "check")
        {
            $id = Auth::user()->id;
        }
        else
        {
            $id = $request->id;
        }

        $address = $request->address;
        $lat = $request->lat;
        $long = $request->long;

        if($address != 'no address found')
        {
            DB::table('lat_longs')
                ->where('CI_ID', $id)
                ->update(['Address' => $address]);
        }


//        $now = Carbon::now('Asia/Manila');
//
//        $eks = explode(' ', $now);
//
//        $checkIfYes = DB::table('ci_login_trails')
//            ->select('id')
//            ->where('ci_id', Auth::user()->id)
//            ->where('type', 'Attendance')
//            ->where(function($query)
//            {
//                return $query->where('lat', '=', '0')
//                    ->orwhere('lat', '=', null);
//            })
//            ->where(function($query)
//            {
//                return $query->where('long', '=', '0')
//                    ->orwhere('long', '=', null);
//            })
////            ->where('lat', null)
////            ->where('long', null)
//
//            ->where('created_at','like', '%'.$eks[0].'%')
//            ->orderBy('created_at' ,'desc')
//            ->get();
//
//        if(count($checkIfYes) > 0)
//        {
//            DB::table('ci_login_trails')
//                ->where('id', $checkIfYes[0]->id)
//                ->update
//                ([
//                    'lat' => $lat,
//                    'long' => $long,
//                    'address_location' => $address,
//                    'updated_at' => $now
//                ]);
//        }
//        else
//        {
            $save_trail = new CiLoginTrail();
            $save_trail->ci_id = Auth::user()->id;
            $save_trail->lat = $lat;
            $save_trail->long = $long;
            $save_trail->address_location = $address;
            $save_trail->user_agent = $request->userAgent();
            $save_trail->user_ip = $request->ip();
            $save_trail->save();
//        }


        return response()->json($request->id . ' success');
    }

    public function getNotifSraoDispatcher()
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];

        $getEndorse = '';
        $user = 0;
        $getFinishAO = '';


        $notif_for_fund_req = 0;
        $notif_for_fund_req_finance_approved = 0;
        $funds = 0;
        $realtimefund = 0;
        $getminus = 0;
        $logs_check = '';
        $unliqVal = 0;
        $shellVal = 0;
        $holdFund= 0;
        $unliqtot = 0;
        $unliqFund = 0;

        if (Auth::user()->hasRole('Dispatcher'))
        {
            $user = 1;
            $getEndorse = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
                ->leftjoin('notes', 'notes.endorsement_id', '=', 'endorsement_user.endorsement_id')
                ->select('endorsements.client_name as client_name', 'endorsements.account_name as account_name', 'endorsements.id as id')
                ->orderBy('endorsements.id', 'desc')
                ->where('endorsements.handled_by_credit_investigator', '')
                ->where('endorsements.acct_status', '!=', 4)
                ->where('endorsements.acct_status', '!=', 5)
                ->where('endorsement_user.position_id', 6)
                ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(10))
                ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
                ->get();
        }
        else if (Auth::user()->hasRole('Senior Account Officer'))
        {
            $user = 2;
            $getEndorse = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities','municipalities.id','=','endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->join('regions','regions.id','=','provinces.region_id')
                ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
                ->select('endorsements.client_name as client_name', 'endorsements.account_name as account_name', 'endorsements.id as id')
                ->where('endorsements.acct_status','!=',4)
                ->where('endorsements.acct_status','!=',5)
                ->where('endorsement_user.position_id',6)
                ->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(10))
                ->where('date_endorsed','<=',Carbon::now('Asia/Manila'))
                ->orderBy('endorsements.id', 'desc')
                ->get();

            $notif_for_fund_req = DB::table('fund_requests')
                ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
                ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
                ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
                ->groupBy('count.fund_id')
//            ->where('fund_requests.sao_id',Auth::user()->id)
                ->where('count.type','Processing','Transferred')
                ->where('fund_requests.sao_approved_date',null)
                ->where('fund_requests.dispatcher_status','ON-PROCESS')
                ->where('fund_requests.sao_status','')
                ->where('type_of_fund_request', 'NORMAL REQUEST')
                ->get();

            $notif_for_fund_req = sizeof($notif_for_fund_req);
        }
        else if (Auth::user()->hasRole('Account Officer'))
        {
            $user = 3;
            $getEndorse = DB::table('endorsements')
                ->join('endorsement_user', 'endorsement_user.endorsement_id', '=', 'endorsements.id')
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
                        'endorsements.client_name',
                    ]
                )
                ->where('endorsement_user.user_id', Auth::user()->id)
                ->where('endorsements.type_of_sending_report', '')
                ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
                ->orderBy('endorsements.id', 'desc')
                ->get();

            $getFinishAO = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->select
                (
                    [
                        'endorsements.id',
                        'endorsements.date_endorsed',
                        'endorsements.client_name',
                        'endorsements.account_name',
                        'endorsements.ci_cert',
                        'endorsements.acct_status',

                    ]
                )
                ->where('endorsement_user.user_id', Auth::user()->id)
                ->where('endorsements.type_of_sending_report', '!=', '')
                ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
                ->get();


        }
        else if (Auth::user()->hasRole('Credit Investigator'))
        {
            $user = 4;
            $getEndorse = DB::table('endorsements')
                ->join('endorsement_user','endorsement_user.endorsement_id','=','endorsements.id')
                ->select
                (
                    'endorsements.id as id',
                    'endorsements.account_name as account_name',
                    'endorsements.client_name as client_name'
                )
                ->where('endorsement_user.user_id', Auth::user()->id)
                ->where('endorsements.acct_status', '=', 1)
                ->where('endorsement_user.position_id', '=', 4)
                ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
                ->orderBy('endorsements.id', 'desc')
                ->get();

            $funds = 0;

            $funds = DB::table('ci_fund_remittances')
                ->where('check','')
                ->where('user_id',Auth::user()->id)
                ->where('confirm_date_time','!=','0000-00-00 00:00:00')
                ->count();

            $check = DB::table('ci_fund_realtime_amount')
                ->where('user_id',Auth::user()->id)
                ->select('fund')
                ->count();

            if($check == 0)
            {
                $realtimefund = 0;
            }
            else
            {
                $getTotalFUND = DB::table('fund_requests')
                    ->select('fund_amount')
                    ->where('ci_id', Auth::user()->id)
                    ->where('sao_status', 'APPROVED')
                    ->where(function ($query)
                    {
                        return $query->where('approved_request_done', 'Done')
                            ->orWhere('approved_request_done', 'New')
                            ->orWhere('approved_request_done', 'Assigned');
                    })
                    ->get();

                if(count($getTotalFUND) > 0)
                {
                    for($j = 0; $j < count($getTotalFUND); $j++ )
                    {
                        $realtimefund += (int)base64_decode($getTotalFUND[$j]->fund_amount);
                    }
                }
                else
                {
                    $realtimefund = 0;
                }


//                $getminus = DB::table('ci_daily_expenses')
//                    ->join('ci_daily_expenses_date','ci_daily_expenses_date.id','=','ci_daily_expenses.daily_id')
//                    ->where('ci_daily_expenses_date.ci_id',Auth::user()->id)
//                    ->where('ci_daily_expenses.from','Fund')
//                    ->select('ci_daily_expenses.amount')
//                    ->get();
//                $getminus = DB::table('fund_requests')
//                    ->select('liquidated_amount')
//                    ->where('ci_id', Auth::user()->id)
//                    ->where('liquidated_amount', '!=', '')
//                    ->where('approved_request_done', 'Done')
//                    ->get();
            }

            $logs_check = DB::table('ci_logs_expenses')
                ->leftjoin('fund_requests','fund_requests.id','=','ci_logs_expenses.activity_id')
                ->where('fund_requests.ci_id',Auth::user()->id)
                ->orderBy('ci_logs_expenses.id', 'desc')
                ->take(10)
                ->get();

            $getall = 0;
            $real = 0;

//
//            if (is_array($getminus) || is_object($getminus))
//            {
//                foreach ($getminus as $getminuses)
//                {
////                    $getall += $getminuses->amount;
//
//                    $getall += $getminuses->liquidated_amount;
//                }
//            }
//
//            $real = ($realtimefund-$getall);

            $getunliqTotal = DB::table('fund_requests')
                ->select('unliquidated_amount')
                ->where('liquidation_status','')
                ->where(function ($query)
                {
                    return $query->where('approved_request_done', 'Done')
                        ->orWhere('approved_request_done', 'Assigned')
                        ->orWhere('approved_request_done', 'New');
                })
                ->where(function ($query)
                {
                    return $query->where('success_hold_cancel', '')
                        ->orWhere('success_hold_cancel', 'Override');

                })
                ->where('ci_id', Auth::user()->id)
                ->get();

//            $getall = 0;
//            $real = 0;

            $getunliqTotal2 = DB::table('fund_requests')
                ->select('unliquidated_amount')
                ->where(function ($query)
                {
                    return $query->where('success_hold_cancel', '')
                        ->orWhere('success_hold_cancel', 'Override');
                })
                ->where('liquidation_status', 'liquidated')
                ->where(function ($query)
                {
                    return $query->where('approved_request_done', 'Done')
                        ->orWhere('approved_request_done', 'Assigned')
                        ->orWhere('approved_request_done', 'New');


                })
                ->where('ci_id', Auth::user()->id)
                ->get();

            if(count($getunliqTotal2) > 0)
            {
                for($y = 0 ; $y < count($getunliqTotal2); $y++)
                {
                    $unliqFund += (int) $getunliqTotal2[$y]->unliquidated_amount;
                }

            }

            if(count($getunliqTotal) > 0)
            {
                for($h = 0; $h < count($getunliqTotal);$h++)
                {
                    $unliqtot += (int)$getunliqTotal[$h]->unliquidated_amount;
                }
            }


            $getUnliq = DB::table('fund_requests')
                ->select('unliquidated_amount')
                ->where('ci_id', Auth::user()->id)
                ->where('approved_request_done', 'Done')
                ->where(function ($query)
                {
                    return $query->where('success_hold_cancel', '')
                        ->orWhere('success_hold_cancel', 'Override');
                })
                ->where('liquidation_status', '')
                ->get();

            $onHoldAmts = DB::table('fund_requests')
                ->select('unliquidated_amount')
                ->where('ci_id', Auth::user()->id)
                ->where('success_hold_cancel', 'Hold')
                ->where('approved_request_done', '!=', '')
                ->get();


            if(count($getUnliq) > 0)
            {
                for($i = 0; $i < count($getUnliq); $i++)
                {
                    $unliqVal += (int)$getUnliq[$i]->unliquidated_amount;
                }
            }
            else
            {
                $unliqVal = 0;
            }

            if(count($onHoldAmts) > 0)
            {
                for($j = 0; $j < count($onHoldAmts); $j++)
                {
                    $holdFund += (int)$onHoldAmts[$j]->unliquidated_amount;
                }
            }
            else
            {
                $holdFund = 0;
            }

            DB::table('ci_fund_realtime_amount')
                ->where('user_id',Auth::user()->id)
                ->update
                ([
                    'fund_realtime' => $unliqtot,
                    'unliq_fund' => $unliqFund,
                    'hold_fund' => $holdFund
                ]);
        }
        else if (Auth::user()->hasRole('Finance'))
        {
            $user = 5;
            $notif_for_fund_req_finance_approved = DB::table('fund_requests')
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
//                ->select(
//                    [
//                        'fund_requests.id as id',
//                        'ci_id.name as name_ci',
//                        'dispatcher_id.name as name_disp',
//                        'sao_id.name as name_sao',
//                        'manage_approved_id.name as manage_name',
////                    'finance_id.name as name_finance',
//                        'fund_requests.fund_amount as amount',
//                        'fund_requests.dispatcher_remarks as dispatcher_remarks',
//                        'fund_requests.sao_remarks as sao_remarks',
//                        'fund_requests.finance_remarks as finance_remarks',
//                        'fund_requests.date_time_remarks as date_time_remarks',
//                        'fund_requests.dispatcher_request_date as dispatcher_request_date',
//                        'fund_requests.sao_approved_date as sao_approved_date',
//                        'fund_requests.finance_approved_date as finance_approved_date',
//                        'fund_requests.delivered_date as delivered_date',
//                        'fund_requests.type_of_fund_request',
//                        'fund_requests.ci_id as ci_id',
//                        'ci_atms.bank_name as shell_card',
//                        'ci_shell_card_info.shell_card as get_shell',
//                        'ci_atms.account_number as account_number',
//                        'ci_atms.id as shell_card_id',
//                        'remittance.receive_status as receive_status',
//                        'remittance.branch_name as branch_name',
//                        'remittance.remittance_info as remittance_info',
//                        'remittance.code as code',
//                        'ci_atm_fund.receive_status as receive_status_atm',
//                        'ci_shell_include_fund.receive_status as receive_status_shell',
//                        'ci_shell_include_fund.with_or_without as with_or_without',
//                        'ci_fund_remittances.remittance_id as check_remittance',
//                        'ci_fund_remittances.ci_shell_card_id as check_shell_card',
//                        'ci_fund_remittances.ci_atm_fund_id as check_atm',
//                        'count.type as type',
//                        'fund_requests.management_remarks_approved as rem_manage'
//                    ]
//                )
                ->groupBy('count.fund_id')
//            ->where('fund_requests.finance_id',Auth::user()->id)
                ->where('fund_requests.sao_status','APPROVED')
                ->where('fund_requests.approved_request_done', '=', '')
                ->get();

            $notif_for_fund_req_finance_approved = sizeof($notif_for_fund_req_finance_approved);
        }

        if (Auth::user() === null)
        {
            return redirect()->route('/');
        }




        return response()->json([$getEndorse, $user, $getFinishAO,$notif_for_fund_req,$notif_for_fund_req_finance_approved,$funds,$realtimefund,$getminus,$logs_check, $unliqVal, $holdFund, $unliqtot, $unliqFund]);
    }

}