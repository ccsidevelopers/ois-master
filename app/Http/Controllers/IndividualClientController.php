<?php

namespace App\Http\Controllers;

use App\Generals\DashboardQueries;
use App\TypeOfRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndividualClientController extends Controller
{
    //
    public function getIndiClientPanel()
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
//            $generalDashboard = new DashboardQueries();
//            $dataDashboard = $generalDashboard->dashboardQueriesClient();
//            $endorsement = $dataDashboard[0];
//            $dueAccount = $dataDashboard[1];
//            $overdueAccount = $dataDashboard[2];
//            $timeStamp = $dataDashboard[3];
//            $tatAccounts = $dataDashboard[4];
            //            END
            $tors = TypeOfRequest::all();

            $javs = DB::table('javascript_magic')
                ->select('unique')
                ->where('id','1')
                ->get()[0]->unique;

            return view('individual_client.indi-client-master', compact
            (
//                'endorsement',
//                'timeStamp',
//                'dueAccount',
//                'overdueAccount',
//                'tatAccounts',
                'javs',
                'provinces',
                'tors'
            ));
        }
//        return redirect()->route('privilege-error');

    }

    public function paypal_pay_confirm(Request $request)
    {
        DB::table('paypal_requestor_info')
            ->insert([
                'tr_id' => $request->tr_id,
                'email' => $request->requestor_email,
                'name' => $request->requestor_info_name,
                'country' => $request->requestor_info_country,
                'created_at' => Carbon::now('Asia/Manila')
            ]);



        DB::table('paypal_payment_info')
            ->insert([
                'user_ip' => $request->ip(),
                'payer_id' => $request->payer_id,
                'tr_id' => $request->tr_id,
                'amount' => $request->amount,
                'email_address' => $request->email_address,
                'country_code' => $request->country_code,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        return response()->json(['paid', $request->tr_id]);
    }
}
