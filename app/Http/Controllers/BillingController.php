<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BillingController extends Controller
{
    public function getBillingDashboard()
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
            } elseif (Auth::user()->hasRole('Billing')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('billing.billing-dashboard', compact('timeStamp'))->with(["page" => "billing-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getBillingPanel()
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
            } elseif (Auth::user()->hasRole('Billing')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('billing.billing-master', compact('timeStamp','javs'))->with(["page" => "billing-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getBillingRate()
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
            } elseif (Auth::user()->hasRole('Billing')) {
                return view('billing.billing-rate')->with(["page" => "billing-rate"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function tableGetReport()
    {
        $reportTable = DB::table('endorsements')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
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
                    'endorsements.client_name',
                    'endorsements.endorsement_status_external',
                    'endorsements.picture_status',
                    'endorsements.rate',
                    'endorsements.re_ci',
                    'endorsements.date_forwarded_to_client',
                    'endorsements.time_forwarded_to_client',
                    'endorsements.bill',
                    'endorsements.appliedrule',
//                    'employers.employer_name as evr_name',
//                    'businesses.business_name as bvr_name',
                ]
            );

        return DataTables::of($reportTable)
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

    public function manageBilling()
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
                return redirect()->route('login');
            } elseif (Auth::user()->hasRole('Billing')) {
                return view('billing.billing-manage')->with(["page" => "billing-manage"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function BilledUnbill(Request $request)
    {
        $getids = $request->arrayid;
        foreach ($getids as $getid)
        {
            DB::table('endorsements')
                ->where('id', $getid)
                ->update([
                    'bill' => $request->type
                ]);
        }
        return 'success';
    }

    public function BilledRuleThreeTFS(Request $request)
    {
        $getids = $request->arrayid;
        $gg = $request->ratededuc;

        for($ctr = 0; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => $gg[$ctr],
                    'appliedrule' => 'Penalty (-100 PHP)'
                ]);
        }

        return 'success';
    }


    public function BilledRuleUndo(Request $request)
    {
        $getids = $request->arrayid;
        $gg = $request->ratededuc;


        for($ctr = 0; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => $gg[$ctr],
                    'appliedrule' => ''
                ]);
        }

        return 'success';
    }


    public function BilledRuleOneTFS(Request $request)
    {
        $getids = $request->arrayid;

        DB::table('endorsements')
            ->where('id', $getids[0])
            ->update([
                'appliedrule' => 'Same City/Municipalities'
            ]);

        for($ctr = 1; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => '-',
                    'appliedrule' => 'Same City/Municipalities'
                ]);
        }

        return 'success';
    }

    public function BilledRuleTwoTFS(Request $request)
    {
        $getids = $request->arrayid;

        DB::table('endorsements')
            ->where('id', $getids[0])
            ->update([
                'appliedrule' => 'Accounts with same address & same date endorsed.'
            ]);

        for($ctr = 1; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => '-',
                    'appliedrule' => 'Accounts with same address & same date endorsed.'
                ]);
        }

        return 'success';
    }

    public function BilledRuleFourManila(Request $request)
    {
        $getids = $request->arrayid;
        $gg = $request->ratededuc;

        for($ctr = 0; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => $gg[$ctr],
                    'appliedrule' => 'Additional for Metro Manila (+65 PHP)'
                ]);
        }

        return 'success';
    }

    public function BilledRuleFourProvince(Request $request)
    {
        $getids = $request->arrayid;
        $gg = $request->ratededuc;

        for($ctr = 0; $ctr<count($getids); $ctr++)
        {
            DB::table('endorsements')
                ->where('id', $getids[$ctr])
                ->update([
                    'rate' => $gg[$ctr],
                    'appliedrule' => 'Additional for Province (+100 PHP)'
                ]);
        }

        return 'success';
    }

}
