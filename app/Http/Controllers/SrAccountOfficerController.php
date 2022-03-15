<?php

namespace App\Http\Controllers;

use App\Endorsement;
use App\Events\DispatchPusherEvent;
use App\Events\SaoPusherEvent;
use App\Events\TransferPusherEvent;
use App\Generals\AuditFundQueries;
use App\Generals\AuditQueries;
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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;

class SrAccountOfficerController extends Controller
{

    public function var_session()
    {
        return $ses = Session();
    }

    public function getSaoMaster()
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
            } elseif (Auth::user()->hasRole('Senior Account Officer')) {

//                $dateNow = Carbon::now('Asia/Manila');
//                $time = date("H:i:s", strtotime($dateNow));

                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];


                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('bank_dept.senior_account_officer.sao-master', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount','javs'));

            }
            return redirect()->route('privilege-error');
        }
    }

    public function getSaoDashboard()
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
            } elseif (Auth::user()->hasRole('Senior Account Officer')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                //            END

                return view('bank_dept.senior_account_officer.sao-dashboard', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount'))->with(["page" => "sao-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getSaoAssignAccount()
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
            } elseif (Auth::user()->hasRole('Senior Account Officer')) {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i:s", strtotime($dateNow));
                return view('bank_dept.senior_account_officer.sao-assign-account', compact('dateNow', 'time'))->with(["page" => "sao-assign-account"]);

            }
            return redirect()->route('privilege-error');
        }
    }

    public function ciFundRequest()
    {
        if (Auth::user() == null) {
            return redirect()->route('/');
        } elseif (Auth::user()->hasRole('Senior Account Officer')) {
            $dateNow = Carbon::now('Asia/Manila');
            $time = date("H:i:s", strtotime($dateNow));
            return view('bank_dept.senior_account_officer.sao-ci-fund-request', compact('dateNow', 'time'))->with(["page" => "sao-ci-fund-request"]);

        }
        return redirect()->route('privilege-error');
    }

    public function assignToAo(Request $request)
    {
        if(Auth::user()->hasRole('Senior Account Officer'))
        {
            $ses = Session();
            $userID = $request->aoID;
            $message = $request->aim;
//            \event(new DispatchPusherEvent($message,$userID));
//            \event(new SaoPusherEvent());

            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ",$timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $verifyAccount = DB::table('endorsements')
                ->where('id',$request->accountID)
                ->where('handled_by_account_officer','!=','')
                ->count();

            $verifyHold = DB::table('endorsements')
                ->where('id',$request->accountID)
                ->where('acct_status','4')
                ->count();

            $verifyCancel = DB::table('endorsements')
                ->where('id',$request->accountID)
                ->where('acct_status','5')
                ->count();

            if($verifyAccount==1)
            {
                return response()->json(['errorDispatch'=>500]);
            }
            elseif ($verifyHold==1)
            {
                return response()->json(['errorDispatch'=>600]);
            }
            elseif($verifyCancel==1)
            {
                return response()->json(['errorDispatch'=>600]);
            }
            else
            {
                //        PROCESS ASSIGNING TO AO
                DB::table('endorsements')
                    ->where('id', $request->accountID)
                    ->update
                    ([
                        'assigned_by_srao' => strtoupper(Auth::user()->name),
                        'handled_by_account_officer' => strtoupper($request->aoName),
                        'date_srao_assigned' => $date,
                        'time_srao_assigned' => $time,
                    ]);

                $userCi = User::find($request->aoID);
                $userCi->endorsements()->attach($request->accountID, ['position_id' => $userCi->roles->first()->id, 'province_id' => $userCi->provinces->first()->id]);

                $userCi = User::find(Auth::user()->id);
                $userCi->endorsements()->attach($request->accountID, ['position_id' => $userCi->roles->first()->id, 'province_id' => $userCi->provinces->first()->id]);
                //        END PROCESS ASSIGNING


                //        AUDIT TRAILING

                $users = User::find(Auth::user()->id);
                foreach ($users->roles as $user) {
                    $role = $user->name;
                    $ses->put('role', $role);
                }
                foreach ($users->provinces as $branch) {
                    $userBranch = $branch->name;
                    $ses->put('userBranch', $userBranch);
                }

                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $request->accountID,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper($ses->get('role')),
                            'branch' => strtoupper($ses->get('userBranch')),
                            'activities' => strtoupper($request->accountName . ' Assigned Account to ' . $request->aoName),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );
                //        END OF AUDIT TRAILING

                //      TOTAL TIME LOSS
                $timeStampNoww = Carbon::now('Asia/Manila');

                $dateEndorsed = Endorsement::find($request->accountID);
                $dateEndo = $dateEndorsed->date_endorsed;
                $timeEndorsed = Endorsement::find($request->accountID);
                $timeEndo = $timeEndorsed->time_endorsed;

                $dateTimeLoss = $timeStampNoww->diffForHumans(Carbon::parse($dateEndo . ' ' . $timeEndo));

                DB::table('timestamps')
                    ->where('endorsement_id', $request->accountID)
                    ->update(['time_srao' => $dateTimeLoss]);


               // $emailSend = new EmailQueries();
              //  $emailSend->SaoAssignToAo($request);

                //      END
            }
        }
        else
        {
            return redirect()->route('privilege-error');
        }
    }

    public function tableViewManipulation(Request $request)
    {
        $what = $request->search_methodd;
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;
        
        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->join('regions','regions.id','=','provinces.region_id')
            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
            ->select
            (
                [
                    'endorsements.requestor_name',
                    'endorsements.client_name',
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.type_of_loan',
                    'endorsements.handled_by_account_officer',
                    'user_id', 'users.name',
                    'users.email','users.pix_path',
                    'endorsements.endorsement_status_external',
                    'endorsements.type_of_sending_report',
                    'municipalities.muni_name as muni_name',
                    'provinces.name',
                    'regions.region_name as region_name',
                    'archipelagos.archipelago_name as archipelago_name',


//                    'endorsements.id',
//                    'endorsements.date_endorsed',
//                    'endorsements.time_endorsed',
//                    'endorsements.account_name',
//                    'endorsements.type_of_request',
//                    'endorsements.client_name',
//                    'municipalities.muni_name as muni_name',
//                    'provinces.name',
//                    'regions.region_name as region_name',
//                    'archipelagos.archipelago_name as archipelago_name',
//                    'endorsements.requestor_name',
//                    'endorsements.acct_status',
//                    'endorsements.re_ci',
//                    'endorsements.handled_by_account_officer',
                ]
            )
//            ->where('endorsements.handled_by_account_officer','')
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where('endorsement_user.position_id',6)
            ->where(function($q) use($what, $min, $max)
            {
                if($what == 'all')
                {
                    return $q->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                    ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
                }
                else if($what == 'date_range')
                {
                    return $q->where('date_endorsed','>=',$max)
                        ->where('date_endorsed','<=',$min);
                }
                else
                {
                    return $q->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                        ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
                }
            });

        return DataTables::of($endorsements)
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

    public function aoListAccount(Request $request)
    {
        $what = $request->search_methodd;
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;
        
        if ($request->ajax())
        {
            $endorsements = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities','municipalities.id','=','endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->join('regions','regions.id','=','provinces.region_id')
                ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
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
                        'endorsements.type_of_loan',
                        'endorsements.re_ci',
                        'endorsements.client_name',
                        'user_id',
                        'users.name as aoname',
                        'users.email',
                        'users.pix_path',
                        'endorsements.endorsement_status_external',
                        'endorsements.type_of_sending_report',
                        'municipalities.muni_name as muni_name',
                        'provinces.name',
                        'regions.region_name as region_name',
                        'archipelagos.archipelago_name as archipelago_name',
                    ]
                )
                ->where('endorsement_user.position_id', 3)
//                ->where('endorsement_user.province_id', Auth::user()->provinces->first()->id)
//                ->where('endorsements.assigned_by_srao', Auth::user()->name)
                ->where(function($q) use($what, $min, $max)
                {
                    if($what == 'all')
                    {
                        return $q->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                        ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
                    }
                    else if($what == 'date_range')
                    {
                        return $q->where('date_endorsed','>=',$max)
                            ->where('date_endorsed','<=',$min);
                    }
                    else
                    {
                        return $q->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                        ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
                    }
                });


            return DataTables::of($endorsements)
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
    }

    public function aoTransfer(Request $request)
    {
        $ses = Session();
        $userID = $request->aoID;
        $message = $request->aim;
//        \event(new DispatchPusherEvent($message,$userID));
//        \event(new TransferPusherEvent());
//        \event(new SaoPusherEvent());
        $validate = DB::table('endorsements')
            ->where('id', $request->acctID)
            ->select('acct_status')
            ->get();

        if($validate[0]->acct_status == 3)
        {
            return 'already finished';
        }
        else
        {
            $aoName = User::find($request->aoID)->name;

            $aoNameTransfer = User::find($request->aoIDToTransfer)->name;

            $acctName = Endorsement::find($request->acctID)->account_name;

            User::find($request->aoID)
                ->endorsements()
                ->wherePivot('endorsement_id', $request->acctID)
                ->detach();

            $aoUserTransfer = User::find($request->aoIDToTransfer);
            $aoUserTransfer->endorsements()
                ->attach($request->acctID,['position_id'=>$aoUserTransfer->roles->first()->id,'province_id'=>$aoUserTransfer->provinces->first()->id]);

            DB::table('endorsements')
                ->where('id', $request->acctID)
                ->update
                ([
                    'handled_by_account_officer' => strtoupper($aoNameTransfer),
                    'assigned_by_srao' => strtoupper(Auth::user()->name)
                ]);



//      AUDIT TRAILING
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ",$timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $users = User::find(Auth::user()->id);
            foreach ($users->roles as $user)
            {
                $role = $user->name;
                $ses->put('role', $role);
            }
            foreach ($users->provinces as $branch)
            {
                $userBranch = $branch->name;
                $ses->put('userBranch', $userBranch);
            }

            DB::table('audits')
                ->insert
                (
                    [
                        'endorsement_id' => $request->acctID,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper($ses->get('role')),
                        'branch' => strtoupper($ses->get('userBranch')),
                        'activities' => strtoupper('ACCOUNT '.$acctName.' Transferred From '. $aoName.' To '. $aoNameTransfer),
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );

            return 'success';
        }



        //$emailSend = new EmailQueries();
       //
        // $emailSend->SaoTransferToAo($request,$aoName,$aoNameTransfer);
    }

    public function cancelAccount(Request $request)
    {
        $ses = Session();
        $verifyCancel = DB::table('endorsements')
            ->where('id',$request->accountID)
            ->where('acct_status','!=','')
            ->count();

        if($verifyCancel==1)
        {
            return response()->json(['errorDispatch'=>600]);
        }
        else
        {
            DB::table('endorsements')
                ->where('id',$request->accountID)
                ->update
                ([
                    'acct_status' => 5,
                    'bill' => strtoupper('CANCELLED')
                ]);
        }

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $acctName = Endorsement::find($request->accountID)->account_name;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->accountID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acctName.' HAS BEEN CANCELLED WITH REMARKS:<b>' . $request->remarks. '</b>'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
        //        END OF AUDIT TRAILING
    }

    public function holdAccount(Request $request)
    {
        $ses = Session();
        $verifyHold = DB::table('endorsements')
            ->where('id',$request->accountID)
            ->where('acct_status','!=','')
            ->count();

        if($verifyHold==1)
        {
            return response()->json(['errorDispatch'=>600]);
        }
        else
        {
            DB::table('endorsements')
                ->where('id',$request->accountID)
                ->update
                ([
                    'acct_status' => 4,
                    'bill' => strtoupper('HOLD')
                ]);
        }


        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $acctName = Endorsement::find($request->accountID)->account_name;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->accountID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acctName.' HAS BEEN HOLD'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
        //      END OF AUDIT TRAILING
    }

    public function uncancelholdAccount(Request $request)
    {
        $ses = Session();
        DB::table('endorsements')
            ->where('id',$request->accountID)
            ->update
            ([
                'acct_status' => '',
                'bill' => ''
            ]);

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $acctName = Endorsement::find($request->accountID)->account_name;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->accountID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acctName.' REMOVED FROM CANCELLED OR HOLD STATE'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
        //      END OF AUDIT TRAILING
    }

    public function tableViewManipulationMnge()
    {
        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->select(
                [
                    'endorsements.id as id',
                    'endorsements.date_endorsed as date_endorsed',
                    'endorsements.time_endorsed as time_endorsed',
                    'endorsements.date_due as date_due',
                    'endorsements.time_due as time_due',
                    'endorsements.re_ci as re_ci',
                    'endorsements.account_name as account_name',
                    'endorsements.address as address',
                    'endorsements.type_of_request as type_of_request',
                    'endorsements.client_name as client_name',
                    'endorsements.type_of_loan as type_of_loan',
                    'endorsements.provinces as provinces',
                    'endorsements.requestor_name as requestor_name',
                    'endorsements.acct_status as acct_status'
                ]
            )
            ->where(function ($query)
            {
                return $query ->orWhere('acct_status','4')
                    ->orWhere('acct_status','5')
                    ->orWhere('acct_status','');
            })
            ->where('position_id',6);

        return DataTables::of($endorsements)
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

    public function getSaoEndorsement()
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
            } elseif (Auth::user()->hasRole('Senior Account Officer')) {
                return view('bank_dept.senior_account_officer.sao-endorsement')->with(["page" => "sao-endorsement"]);
            }
            return redirect()->route('privilege-error');
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


    public function getAOcounts()
    {

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $account_officers = DB::table('role_user')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(['users.id','users.name'])
            ->where('role_id', 3)
            ->where('users.archive', 'False')
            ->get();

        $ao_counts = array();
        $ao_id = array();
//            $ctr = 0;
//
//            $message = $account_officers[0]->name;
//            echo "<script type='text/javascript'>alert('$message');</script>";

        for($ctr = 0; $ctr<count($account_officers);$ctr++){

            $getao = $account_officers[$ctr]->name;
            $ao_id[$ctr] = $account_officers[$ctr]->id;

            $counted  = DB::table('endorsements')
                ->where('handled_by_account_officer','=',$getao)
                ->where('acct_status','!=',3)
                ->where('date_due', $date)
                ->count();

            $ao_counts[$ctr] = strtoupper($getao)." --- (ACCOUNTS ON PROCCESS TODAY:".$counted.")";
        }


        return response()->json([$ao_counts,$ao_id,$ctr]);
    }

    public function getUpdatedInfo(Request $request)
    {
        $updateInfo = DB::table('endorsements')
            ->select
            (
                [
                    'date_forwarded_to_client',
                    'time_forwarded_to_client',
                    'address',
                    'city_muni',
                    'provinces',
                    'endorsement_status_internal',
                    'endorsement_status_external',
                    'picture_status',
                    'type_of_sending_report',
                    'acct_status',
                    'add_verification',
                    'remarks'
                ]
            )
            ->where('id',$request->acctID)
            ->get();

        return response()->json($updateInfo);
    }

    public function updateAOInfo(Request $request)
    {
        $ses = Session();
        $date = '';
        $time = '';
        $tatOverdue = '';

        $dateDues = DB::table('endorsements')
            ->select(['date_due','time_due'])
            ->where('id',$request->acctID)
            ->get();

        foreach($dateDues as $dateDue)
        {
            $date = $dateDue->date_due;
            $time = $dateDue->time_due;
        }

        if($request->txtDateForward.' '.date("H:i", strtotime($request->txtTimeForward))>$date.' '.$time)
        {
            $tatOverdue = 'OVERDUE';
        }
        else
        {
            $tatOverdue = 'TAT';
        }


        DB::table('endorsements')
            ->where('id',$request->acctID)
            ->update
            (
                [
                    'date_forwarded_to_client' => strtoupper($request->txtDateForward),
                    'time_forwarded_to_client' => strtoupper($request->txtTimeForward),
                    'endorsement_status_external' => strtoupper($tatOverdue),
                    'endorsement_status_internal' => strtoupper($request->txtInternalStatus),
                    'picture_status' => strtoupper($request->txtPictureStatus),
                    'type_of_sending_report' => strtoupper($request->txtTOSR),
                    'add_verification' => strtoupper($request->txtVerAdd),
                    'remarks' => strtoupper($request->txtRemarks)
                ]
            );

        //      AUDIT TRAILING
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $acctName = Endorsement::find($request->acctID)->account_name;
        $aoName = Endorsement::find($request->acctID)->handled_by_account_officer;

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acctName.' UPDATE INFORMATION SUBMITTED BY '.$aoName),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
        //        END OF AUDIT TRAILING

        return response()->json('success');
    }


    public function ci_fund_table_get()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as remarks',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
//            ->where('fund_requests.sao_id',Auth::user()->id)
            ->where('count.type','Processing','Transferred')
            ->where('fund_requests.sao_approved_date',null)
            ->where('fund_requests.dispatcher_status','ON-PROCESS')
            ->where('fund_requests.sao_status','')
            ->where('type_of_fund_request', 'NORMAL REQUEST');

//        $b[0]->amount;

        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('sao_pending_fund_details_endorsements/' . $b->id);
            })
            ->make(true);
    }

    public function ci_fund_table_get_approved()
    {
        $b = DB::table('fund_requests')
            ->leftjoin('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as remarks',
                    'fund_requests.sao_remarks as sao_remarks',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
//            ->where('count.type','Processing','Transferred')
            ->where('fund_requests.sao_id',Auth::user()->id)
            ->where('fund_requests.sao_status','APPROVED')
            ->where('approved_request_done', '!=', 'Assigned');

        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('sao_app_fund_details_endorsements/' . $b->id);
            })
            ->make(true);
    }

    public function ci_fund_table_get_declined()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'dispatcher_id.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.dispatcher_remarks as remarks',
                    'fund_requests.disapprove_remarks as dis_remarks',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
//            ->where(function ($query)
//            {
//                return $query->where('count.type','Disapproved')
//                ->orWhere('count.type','Transferred');
//            })
//            ->where('fund_requests.sao_id',Auth::user()->id)
            ->where('fund_requests.sao_status','DISAPPROVED');



        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('sao_dec_fund_details_endorsements/' . $b->id);
            })
            ->make(true);
    }

    public function ApprovedReq(Request $request)
    {
        $id = $request->id;
        $remarks = $request->remarks;
        $timeStamp = Carbon::now('Asia/Manila');

        $dispStatus = DB::table('fund_requests')
            ->select
            (
                'dispatcher_status',
                'ci_id',
                'type_of_fund_request'
            )
            ->where('id',$id)
            ->first();

        if($dispStatus->dispatcher_status=='CANCELLED')
        {
            return response()->json('errorCancelled');
        }
        else
        {
            DB::table('fund_requests')
                ->where('id',$id)
                ->update([
                    'sao_approved_date' => $timeStamp,
                    'sao_remarks' => strtoupper($remarks),
                    'sao_status' => 'APPROVED',
                    'sao_id' => Auth::user()->id,
                    'fund_amount' => base64_encode($request->amt),
                    'created_at' => $timeStamp
                ]);

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($dispStatus->ci_id);
            $fund_audit->fund_logs('APPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

            return response()->json('success');
        }
    }

    public function DeclinedReq(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $id = $request->id;
        $timeStamp = Carbon::now('Asia/Manila');

        $dispStatus = DB::table('fund_requests')
            ->select
            (
                'dispatcher_status',
                'ci_id'
            )
            ->where('id',$id)
            ->first();
        if($dispStatus->dispatcher_status=='CANCELLED')
        {
            return response()->json('errorCancelled');
        }
        else
        {
            DB::table('fund_requests')
                ->where('id', $id)
                ->update
                ([
                    'sao_approved_date' => $timeStamp,
                    'sao_status' => 'DISAPPROVED',
                    'dispatcher_status' => 'DISAPPROVED',
                    'disapprove_remarks' => $removeScript->scripttrim($request->rem)
                ]);


            $get_endorsements_id = DB::table('fund_request_endorsements')
                ->where('fund_id',$id)
                ->where('type','Processing')
                ->get();

            foreach ($get_endorsements_id as $ids)
            {

                DB::table('endorsements')
                    ->where('id', $ids->endorsement_id)
                    ->update([
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

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($dispStatus->ci_id);
            $fund_audit->fund_logs('DISAPPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

            return response()->json('success');
        }
    }

    public function sao_pending_fund_details_endorsements(Request $request)
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
            ->where(function($query)
            {
                return $query->orwhere('fund_request_endorsements.type', '=', 'Processing')
                    ->orwhere('fund_request_endorsements.type', '=', 'Transferred');
            });

        return DataTables::of($details)
            ->make(true);
    }

    public function sao_app_fund_details_endorsements(Request $request)
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
            ->where(function ($query)
            {
                return $query->orwhere('fund_request_endorsements.type','Processing')
                    ->orwhere('fund_request_endorsements.type','Success');
            })
        ;

        return DataTables::of($details)
            ->make(true);
    }

    public function sao_dec_fund_details_endorsements(Request $request)
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
            ->where('fund_request_endorsements.type_label','');

        return DataTables::of($details)
            ->make(true);
    }

    public function saoGetTableRev(Request $request)
    {
        if ($request->ajax())
        {
            $endorseRev = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities','municipalities.id','=','endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->join('regions','regions.id','=','provinces.region_id')
                ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
                ->select
                (
                    [
                        'endorsements.id',
                        'endorsements.date_endorsed',
                        'endorsements.time_endorsed',
                        'endorsements.date_due',
                        'endorsements.time_due',
                        'endorsements.re_ci',
                        'endorsements.account_name',
                        'endorsements.type_of_request',
                        'endorsements.type_of_loan',
                        'endorsements.client_name',
                        'endorsements.acct_status',
                        'user_id',
                        'users.name as ao_name',
                        'users.email',
                        'users.pix_path',
                        'endorsements.endorsement_status_external',
                        'endorsements.type_of_sending_report',
                        'municipalities.muni_name as muni_name',
                        'provinces.name',
                        'regions.region_name as region_name',
                        'archipelagos.archipelago_name as archipelago_name',
                        'endorsement_user.position_id',
                        'endorsement_user.user_id'
                    ]
                )
                ->where('endorsements.acct_status',3)
                ->where('endorsement_user.user_id', Auth::user()->id)
                ->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));


            return DataTables::of($endorseRev)
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
    }

    public function sraoDownloadRev(Request $request)
    {

        if(Auth::user()->hasRole('Senior Account Officer'))
        {
            $down_dec = base64_decode($request->downRevID);
            $getPathLink = DB::table('endorsements')
                ->select(['link_path'])
                ->where('id',$down_dec)
                ->get();

            if($request->todo == 'download_ao')
            {
                if(file_exists(storage_path("account_report/" . $getPathLink[0]->link_path . ".zip")))
                {
                    return response()->download(storage_path("account_report/" . $getPathLink[0]->link_path . ".zip"));
                }
                else
                {
//                echo '<script> alert(\'No Available Report for this Account!\'); window.location = \'/sao-panel\';  </script>';
                    echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';

                }

            }
            else if($request->todo == 'redownload')
            {
                return  response()->download(storage_path("/account_revised/".$getPathLink[0]->link_path .".zip"));
            }
        }
        else
        {
            echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';

        }
    }
    public function uploadReportFile_revision(Request $request)
    {

        $path_link = new DownloadZipLogic();
        $paths = $path_link->path_link($request->acctID);


        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $dateN = $splitDateTime[0];
        $timeN = $splitDateTime[1];

        if (Input::hasFile('file')) {
            $file = $request->file('file');

            //you also need to keep file extension as well
            $name = $paths . '.' . $file->getClientOriginalExtension();

            if($file->getClientOriginalExtension() != 'zip')
            {
                return response()->json('error');
            }
            else
            {
                //using array instead of object
                $file->move(storage_path('/account_revised/'), $name);

                //updating external status
                DB::table('endorsements')
                    ->where('id', $request->acctID)
                    ->update
                    ([
                        'revised' => 'true',
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
                            'activities' => strtoupper('REVISED ACCOUNT ' . $getName->account_name . ' WAS FORWARDED TO CLIENT'),
                            'date_occured' => $dateN,
                            'time_occured' => $timeN
                        ]
                    );
                return response()->json('success');
            }
        }
        return response()->json('error');
    }


    public function srao_check_revision_availability(Request $request)
    {
        $getPathLink = DB::table('endorsements')
            ->select(['revised','link_path'])
            ->where('id',$request->id)
            ->first();

        if($getPathLink->revised == 'true')
        {
            return response()->json(["ok",$getPathLink->link_path]);

        }
        else
        {
            return response()->json("not ok");
        }
    }

    public function sao_get_info_for_assign(Request $request)
    {
        $id = $request->id;

        $get_data = DB::table('endorsements')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsements.id')
            ->select([
                'endorsements.date_endorsed as date',
                'endorsements.time_endorsed as time',
                'municipalities.muni_name as muni_name',
                'provinces.name as provi_name',
                'endorsements.account_name as acct_name',
                'endorsements.type_of_request as tor',
                'endorsements.type_of_loan as loan',
                'notes.endorsement_note as note'
            ])
            ->where('endorsements.id',$id)
            ->get();

        return response()->json($get_data);
    }

    public function sao_table_ci_account_reports(Request $request)
    {
        $what_to_where = $request->search_option;
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

        $ci_reports = DB::table('endorsements')
            ->join('timestamps','timestamps.endorsement_id','=','endorsements.id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.client_name',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.requestor_name',
                    'endorsements.account_name',
                    'endorsements.address',
                    'municipalities.muni_name as city_muni',
                    'endorsements.provinces',
                    'endorsements.type_of_request',
                    'endorsements.endorsement_status_external',
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
            ->where($what_to_where, '>=', $seatrch_min)
            ->where($what_to_where, '<=', $seatrch_max);

        return DataTables::of($ci_reports)
            ->make(true);
    }

    public function sao_ci_account_download_report(Request $request)
    {

        if(Auth::user()->hasRole('Senior Account Officer'))
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

    function sao_audit_download(Request $request)
    {
        if(Auth::user()->hasRole('Senior Account Officer') || Auth::user()->hasRole('Management') || Auth::user()->hasRole('C.I Supervisor'))
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

    public function sao_get_ci_list()
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
            ->where('users.archive', 'false')
            ->get();

        $getAOList = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select
            ([
                'users.name as name',
                'users.id as id'
            ])
            ->where('roles.id', 3)
            ->where('users.archive', 'false')
            ->get();

        $getCCTeleList = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select
            ([
                'users.name as name',
                'users.id as id'
            ])
            ->where('roles.id', 17)
            ->where('users.archive', 'false')
            ->where('client_check', '!=', 'cc_bank')
            ->get();

        $getTeleTfs = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select
            ([
                'users.name as name',
                'users.id as id'
            ])
            ->where('roles.id', 17)
            ->where('users.archive', 'false')
            ->where('client_check', '=', 'cc_bank')
            ->get();

        return response()->json([$getCiList, $getAOList, $getCCTeleList, $getTeleTfs]);
    }

    public function sao_get_ci_endorse_no_fund(Request $request)
    {
        $unliqFund = 0;
        $holdFund = 0;

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
            ->where('ci_id', $request->id)
            ->get();

        if(count($getunliqTotal2) > 0)
        {
            for($y = 0 ; $y < count($getunliqTotal2); $y++)
            {
                $unliqFund += (int) $getunliqTotal2[$y]->unliquidated_amount;
            }

        }
        else
        {
            $unliqFund = 0;
        }

        $onHoldAmts = DB::table('fund_requests')
            ->select('unliquidated_amount')
            ->where('ci_id', $request->id)
            ->where('success_hold_cancel', 'Hold')
            ->where('approved_request_done', '!=', '')
            ->get();

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

        $getCiName = DB::table('users')
            ->select('name')
            ->where('id', $request->id)
            ->get();

        $getSHellCount = DB::table('ci_atms')
            ->where('ci_id', $request->id)
            ->where('bank_name', 'SHELL CARD')
            ->count();

        return response()->json([$getCiName[0]->name, $unliqFund, $holdFund, $getSHellCount]);
    }

    public function sao_table_for_no_fund_accounts(Request $request)
    {
        $table = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->leftjoin('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
//            ->leftjoin('type_of_subjects', 'type_of_subjects.endorsement_id', '=', 'endorsement_user.endorsement_id')
//            ->leftjoin('subjects', 'subjects.endorsement_id', '=', 'endorsement_user.endorsement_id')
            ->leftjoin('fund_request_endorsements', 'fund_request_endorsements.endorsement_id', '=', 'endorsements.id')
            ->leftjoin('fund_requests', 'fund_requests.id', '=', 'fund_request_endorsements.fund_id')
            ->select([
                'endorsements.id as id',
                'endorsements.date_endorsed as date_endorsed',
                'endorsements.account_name as account_name',
                'endorsements.type_of_request as tor',
                'endorsements.address as address',
//                'type_of_subjects.type_of_subject_name as subjcoob',
//                'subjects.subject_name as subjnames',
                'municipalities.muni_name as city_muni',
                'endorsements.provinces as provinces',
                'endorsements.fund_request as fund_request',
                'fund_requests.fund_amount as amount'
            ])
//            ->orderBy('endorsements.id', 'desc')
            ->where('endorsement_user.user_id', $request->id)
            ->where('endorsement_user.position_id', 4)
            ->where('endorsements.fund_request', '!=', 'fund_requested')
            ->where('endorsements.fund_request', '!=', 'fund_uploaded')
//            ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
//            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed)
            ->where('date_endorsed', '>=', Carbon::now('Asia/Manila')->subDays(30))
            ->where('date_endorsed', '<=', Carbon::now('Asia/Manila'))
            ->where('endorsements.acct_status', '!=', 3);

        return DataTables::of($table)
            ->editColumn('type_of_subjects',function($query)
            {
                $toREturnData = '';
                $retuThis = DB::table('endorsements')
                    ->join('type_of_subjects', 'type_of_subjects.endorsement_id', '=', 'endorsements.id')
                    ->join('subjects', 'subjects.endorsement_id', '=', 'endorsements.id')
                    ->where('endorsements.id', $query->id)
                    ->select([
                        'type_of_subjects.type_of_subject_name as subjcoob',
                        'subjects.subject_name as subjnames',
                    ])
                    ->get();

                if($retuThis[0]->subjnames == 'NONE')
                {
                    $toREturnData = $retuThis[0]->subjcoob;
                }
                else
                {
                    $toREturnData = $retuThis[0]->subjcoob . '<br><b>(' . $retuThis[0]->subjnames . ')</b>';
                }

                return $toREturnData;
            })
            ->rawColumns([
                'type_of_subjects'
            ])
            ->make(true);
    }

    public function sao_submit_unliq_hold_amount(Request $request)
    {
        $type = $request->toa;
        $amountGather = 0;
        $amounttoAssign  = $request->amount;
        $fundid = $request->fund;
        $acctNew = $request->ids;
        $test = '';

        if($type == 'Unliquidated Fund')
        {
            $getAllUnliq = DB::table('fund_requests')
                ->select('unliquidated_amount', 'id')
                ->where('ci_id', $request->id)
                ->where(function ($query)
                {
                    return $query->where('success_hold_cancel', '')
                        ->orWhere('success_hold_cancel', 'Override');
                })
                ->where('unliquidated_amount', '>', 0)
                ->where('liquidation_status', 'liquidated')
                ->where(function ($query)
                {
                    return $query->where('approved_request_done', 'Done')
                        ->orWhere('approved_request_done', 'Assigned');
                })
                ->get();

            for ($i = (count($getAllUnliq))-1 ; $i >= 0 ; $i--)
            {
                $amountGather += (int)$getAllUnliq[$i]->unliquidated_amount;
                $amountNew = $amounttoAssign;

                if ($amountGather >= $amounttoAssign)
                {
                    for($j = (count($getAllUnliq))-1; $j >= $i; $j--)
                    {
                        $amountNew = $amountNew-(int)$getAllUnliq[$j]->unliquidated_amount;

                        if($amountNew >= 0)
                        {
                            DB::table('fund_requests')
                                ->where('id', $getAllUnliq[$j]->id)
                                ->update
                                ([
                                    'unliquidated_amount' => 0
                                ]);
                        }
                        else if($amountNew < 0)
                        {
                            DB::table('fund_requests')
                                ->where('id', $getAllUnliq[$j]->id)
                                ->update
                                ([
                                    'unliquidated_amount' => abs($amountNew)
                                ]);
                        }
                    }

                    $getFundId = DB::table('fund_requests')
                        ->insertGetId
                        ([
                            'dispatcher_id' => 0,
                            'ci_id' => $request->id,
                            'sao_id' => Auth::user()->id,
                            'finance_id' => 0,
                            'fund_amount' => base64_encode($amounttoAssign),
                            'fund_original_amount' => base64_encode($amounttoAssign),
                            'dispatcher_request_date' => Carbon::now('Asia/Manila'),
                            'sao_approved_date' => Carbon::now('Asia/Manila'),
                            'delivered_date' => Carbon::now('Asia/Manila'),
                            'finance_remarks' => 'SAO assign from Unliquidated Fund',
                            'date_time_remarks' => Carbon::now('Asia/Manila'),
                            'dispatcher_status' => 'ON-PROCESS',
                            'type_of_fund_request' => 'NORMAL REQUEST',
                            'sao_status' => 'APPROVED',
                            'approved_request_done' => 'Assigned',
                            'liquidated_amount' => 0,
                            'unliquidated_amount' => $amounttoAssign,
                            'sao_logs_date_time' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('ci_fund_remittances')
                        ->insert
                        ([
                            'finance_sent' => 0,
                            'user_id' => $request->id,
                            'fund_id' => $getFundId,
                            'remittance_id' => 0,
                            'ci_shell_card_id' => 0,
                            'ci_atm_fund_id' => 0,
                            'remittance_send_date_time' => Carbon::now('Asia/Manila'),
                            'atm_send_date_time' => Carbon::now('Asia/Manila'),
                            'confirm_date_time' => Carbon::now('Asia/Manila'),
                            'check' => 'check',
                            'remarks_fund'=> 'assign'
                        ]);

                    for($g = 0; $g < count($acctNew); $g++)
                    {
                        DB::table('fund_request_endorsements')
                            ->where('endorsement_id', $acctNew[$g])
                            ->where(function ($query)
                            {
                                return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                                    ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                            })
                            ->delete();

                        DB::table('fund_request_endorsements')
                            ->insert
                            ([
                                'fund_id' => $getFundId,
                                'endorsement_id' => $acctNew[$g],
                                'type' => 'Success'
                            ]);

                        DB::table('endorsements')
                            ->where('id', $acctNew[$g])
                            ->update
                            ([
                                'fund_request' => 'fund_uploaded'
                            ]);
                    }
                    DB::table('ci_logs_expenses')
                        ->insert
                        ([
                            'user_id'=>$request->id,
                            'activity_id' => $getFundId,
                            'activity' => 'FUND REQUEST ID : ' . $getFundId  . ' WITH AMOUNT OF ₱ ' . $amounttoAssign . ' ASSIGNED TO NEW ACCOUNTS FROM LIQUIDATED FUND : ' .Auth::user()->name,
                            'type' => 'ci_receive_logs',
                            'datetime' => Carbon::now('Asia/Manila')
                        ]);

                    break;
                }
                else if($amountGather <= $amounttoAssign)
                {

                }
            }
            return 'unliq';
        }
        else if($type == 'On-Hold Fund')
        {
            $getEndorse = DB::table('fund_request_endorsements')
                ->select('endorsement_id')
                ->where('fund_id', $fundid[0])
                ->get();

            for($r = 0; $r < count($getEndorse); $r++)
            {
                DB::table('endorsements')
                    ->where('id', $getEndorse[$r]->endorsement_id)
                    ->update
                    ([
                        'fund_request' => ''
                    ]);
            }

            DB::table('fund_request_endorsements')
                ->where('fund_id', $fundid[0])
                ->where(function ($query)
                {
                    return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                        ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                })
                ->delete();

            for($t = 0; $t < count($acctNew); $t++)
            {
                DB::table('fund_request_endorsements')
                    ->insert
                    ([
                        'fund_id' => $fundid[0],
                        'endorsement_id' => $acctNew[$t],
                        'type' => 'Success'
                    ]);

                DB::table('endorsements')
                    ->where('id', $acctNew[$t])
                    ->update
                    ([
                        'fund_request' => 'fund_uploaded'
                    ]);
            }

            DB::table('fund_requests')
                ->where('id', $fundid[0])
                ->update
                ([
                    'success_hold_cancel' => 'Override',
                    'date_time_remarks' => Carbon::now('Asia/Manila'),
                    'sao_logs_date_time' => Carbon::now('Asia/Manila')
                ]);

            $getCIAMount = DB::table('fund_requests')
                ->where('id', $fundid[0])
                ->select('ci_id', 'fund_amount')
                ->get();

            DB::table('ci_logs_expenses')
                ->insert
                ([
                    'user_id'=>$fundid[0],
                    'activity_id' => $getCIAMount[0]->ci_id,
                    'activity' => 'FUND REQUEST ID : ' . $fundid[0]  . ' WITH AMOUNT OF ₱ ' .  base64_decode($getCIAMount[0]->fund_amount) . ' RE-ASSIGNED WITH NEW ACCOUNTS - SAO OVERRIDE : ' .Auth::user()->name,
                    'type' => 'ci_receive_logs',
                    'datetime' => Carbon::now('Asia/Manila')
                ]);

            return 'hold';
        }
    }
    public function sao_table_unliq_fund_list_ci(Request $request)
    {
        $table = DB::table('fund_requests')
            ->select('id', 'dispatcher_request_date', 'fund_amount')
            ->where('ci_id', $request->id)
            ->where('success_hold_cancel', 'hold');

        return DataTables::of($table)
            ->make(true);

    }

    public function sao_get_all_info_fund_hold(Request $request)
    {
        $getDataAll = DB::table('fund_requests')
            ->select('dispatcher_request_date', 'delivered_date', 'hold_date_time', 'fund_amount')
            ->where('id', $request->id)
            ->get();

        $getAccounts = DB::table('endorsements')
            ->leftjoin('type_of_subjects', 'type_of_subjects.endorsement_id', '=', 'endorsements.id')
            ->leftjoin('subjects', 'subjects.endorsement_id', '=', 'endorsements.id')
            ->leftjoin('fund_request_endorsements', 'fund_request_endorsements.endorsement_id', '=', 'endorsements.id')
            ->leftjoin('fund_requests', 'fund_requests.id', '=', 'fund_request_endorsements.fund_id')
            ->select
            ([
                'endorsements.account_name as account_name',
                'type_of_subjects.type_of_subject_name as subjcoob',
                'subjects.subject_name as subjnames',
            ])
            ->where('fund_request_endorsements.fund_id', $request->id)
            ->get();

        return response()->json([$getDataAll, $getAccounts]);
    }

    public function sao_send_emergency_req(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $loopids = $request->idsAssign; //array
        $amount = $request->amount;
        $id = $request->id;

        $fund_id = DB::table('fund_requests')
            ->insertGetId
            (
                [
                    'dispatcher_id'=> 0,
                    'ci_id'=> $id,
                    'sao_id'=> Auth::user()->id,
                    'fund_amount'=>base64_encode($amount),
                    'fund_original_amount' => base64_encode($amount),
//                    'dispatcher_request_date'=> Carbon::now('Asia/Manila'),
                    'type_of_fund_request'=>'EMERGENCY FUND',
                    'dispatcher_status' => 'ON-PROCESS',
                    'sao_remarks' => $removeScript->scripttrim($request->saoRemarks),
                    'sao_status' => '',
                    'approved_request_done' => '',
                    'sao_logs_date_time' => Carbon::now('Asia/Manila'),
                    'sao_emergency_req_date_time' => Carbon::now('Asia/Manila')
                ]
            );

        for($i = 0; $i < count($loopids); $i++)
        {
            $countFund = DB::table('fund_request_endorsements')
                ->where('endorsement_id', $loopids[$i])
                ->where(function ($query)
                {
                    return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                        ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                })
                ->count();

            if($countFund > 1)
            {
                DB::table('fund_request_endorsements')
                    ->where('endorsement_id', $loopids[$i])
                    ->where(function ($query)
                    {
                        return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                            ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                    })
                    ->delete();
            }
            else
            {

            }

            DB::table('fund_request_endorsements')
                ->insert
                ([
                    'fund_id' => $fund_id,
                    'endorsement_id' => $loopids[$i],
                    'type' => 'Processing'
                ]);

            DB::table('endorsements')
                ->where('id', $loopids[$i])
                ->update
                ([
                    'fund_request' => 'fund_requested'
                ]);
        }

        $getSaoName = DB::table('users')
            ->select('name')
            ->where('id', Auth::user()->id)
            ->get()[0]->name;

        $getCINInfo = DB::table('users')
//            ->join('municipalities', 'municipalities.id', '=', 'users.branch')
            ->join('provinces', 'provinces.id', '=', 'users.branch')
            ->join('regions', 'regions.id', '=', 'provinces.region_id')
            ->select
            ([
                'users.name as name',
                'regions.archipelago_id as archi'
            ])
            ->where('users.id', $id)
            ->get();

        $fund_audit = new AuditFundQueries();
        $email = new EmailQueries();

        $email->NotifToManagement($getSaoName, $getCINInfo[0]->name, $amount, $request->saoRemarks, $getCINInfo[0]->archi, 'SAO');

        $get_name = User::find($id);

        $fund_audit->fund_logs('EMERGENCY FUND REQUEST FOR: '.$get_name->name.'. FOR THE AMOUNT OF: '.$amount.'',$fund_id);

    }

    public function srao_get_fund_amount_to_approve(Request $request)
    {
        $getData = DB::table('fund_requests')
            ->select('fund_amount', 'ci_id')
            ->where('id', $request->id)
            ->get();

        $amt = base64_decode($getData[0]->fund_amount);

        return response()->json($amt);
    }

    public function srao_fund_override_logs()
    {
        $getTable = DB::table('fund_requests')
            ->join('users', 'users.id', '=', 'fund_requests.ci_id')
            ->join('users as user_2', 'user_2.id', '=', 'fund_requests.sao_id')
            ->select
            ([
                'fund_requests.id as id',
                'fund_requests.sao_logs_date_time as date_time',
                'users.name as ci',
                'fund_requests.type_of_fund_request as tor',
                'fund_requests.approved_request_done as apd',
                'fund_requests.success_hold_cancel as shc',
                'fund_requests.liquidation_status as stat',
                'fund_requests.fund_amount as amount',
                'fund_requests.delivered_date as sent',
                'fund_requests.management_approved_date as manage',
                'fund_requests.sao_status as sao_stat',
                'fund_requests.fund_original_amount as orig_amount',
                'user_2.name as sao_name',
                'fund_requests.management_remarks_approved as manage_rem'
//                'fund_requests'
            ])
            ->orderBy('fund_requests.id', 'DESC')
            ->where(function($query) {
                $query->where('fund_requests.type_of_fund_request', 'EMERGENCY FUND')
                    ->orWhere('fund_requests.approved_request_done', 'Assigned')
                    ->orWhere('fund_requests.success_hold_cancel', 'Override');
            });

        return DataTables::of($getTable)
//            ->editColumn('sao_name', function ($query)
//            {
//                $getSaoName = DB::table('fund_requests')
//                    ->joi)
//            })
//            ->rawColumns(['sao_name'])
            ->make(true);
    }

    public function getTableFundRequest()
    {
        $fundRequestTable = DB::table('fund_requests')
            ->join('users as CiName','CiName.id','=','fund_requests.ci_id')
            ->join('users as SaoName','SaoName.id','=','fund_requests.sao_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id',
                    'CiName.name as fci',
                    'CiName.id as fci_id',
//                    'SaoName.name as sao',
                    'fund_requests.sao_status',
                    'fund_requests.finance_status',
                    'fund_requests.hold_date_time',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.sao_logs_date_time',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where(function($query)
            {
                return $query->where('count.type', 'Processing')
                    ->orwhere('count.type', 'Transferred');
            })
            ->where(function($data){
                return $data->where('dispatcher_status', 'ON-PROCESS')
                    ->orwhere('sao_status', 'ON-PROCESS');
            })
//            ->where('dispatcher_status','ON-PROCESS')
            ->where(function($query)
            {
                return $query->where('type_of_fund_request', 'NORMAL REQUEST')
                    ->orwhere('type_of_fund_request', 'EMERGENCY FUND');
            });

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('sao_pending_fund_details_endorsements/' . $fundRequestTable->id);
            })
            ->make(true);
    }

    public function getTableFundSuccess()
    {
        $fundRequestTable = DB::table('fund_requests')
            ->join('users as CiName','CiName.id','=','fund_requests.ci_id')
//            ->join('users as SaoName','SaoName.id','=','fund_requests.sao_id')
//            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
//            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
            ->join('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id',
                    'CiName.name as fci',
                    'CiName.id as fci_id',
//                    'SaoName.name as sao',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.sao_logs_date_time',
//                    'remittance.receive_status as status',
//                    'ci_atm_fund.receive_status as status_atm',
                    'fund_requests.type_of_fund_request',
//                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where(function ($query) {
                $query->where('count.type', '=', 'Success')
                    ->orWhere('count.type', '=', 'Transferred');
            })
            ->where('fund_requests.delivered_date','!=','0000-00-00');

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('success_fund_details_endorsements/' . $fundRequestTable->id);
            })
            ->editColumn('status_button', function($query)
            {
                $what = '';
                $returnThis = '';
                $remittance = DB::table('remittance')
                    ->where('remittance.fund_id', $query->id)
                    ->select([
                        'remittance.receive_status'
                    ])
                    ->get();

                $ci_atm = DB::table('ci_atm_fund')
                    ->where('ci_atm_fund.fund_id', $query->id)
                    ->select([
                        'ci_atm_fund.receive_status'
                    ])
                    ->get();

                if(count($remittance) > 0)
                {
                    $what = $remittance[0]->receive_status;
                }
                else if(count($ci_atm) > 0)
                {
                    $what = $ci_atm[0]->receive_status;
                }

                if($what != '')
                {
                    return '<button class="btn btn-xs btn-success btn-block">UPLOADED</button>
                        <button class="btn btn-xs btn-info btn-block" name="'.$query->fci.':'.$query->fci_id.'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="'.$query->id.'">ADDITIONAL REQUEST</button>';
                }
                else
                {
                    return '<button class="btn btn-xs btn-warning btn-block">WAITING FOR RECEIVER</button>
                        <button class="btn btn-xs btn-info btn-block" name="'.$query->fci.':'.$query->fci_id.'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="\'+data.id+\'">ADDITIONAL REQUEST</button>';
                }
            })
            ->rawColumns([
                'status_button'
            ])
            ->make(true);
    }

    public function getTableFundDisapproved()
    {
        $fundRequestTable = DB::table('fund_requests')
            ->join('users as CiName','CiName.id','=','fund_requests.ci_id')
//            ->join('users as SaoName','SaoName.id','=','fund_requests.sao_id')
//            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id',
                    'CiName.name as fci',
//                    'SaoName.name as sao',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.sao_logs_date_time',
                    'fund_requests.sao_status',
                    'fund_requests.finance_status',
                    'fund_requests.type_of_fund_request',
//                    'count.type as type',
//                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
//            ->where('count.type','Disapproved')
            ->where(function($query)
            {
                return $query->orwhere('sao_status','DISAPPROVED')
                    ->orwhere('dispatcher_status','DISAPPROVED');
            });

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('pending_disapproved_details_endorsements/' . $fundRequestTable->id);
            })
            ->editColumn('count', function($query)
            {
                $getInfo = DB::table('fund_request_endorsements')
                    ->where('fund_id', $query->id)
                    ->where('type', 'Disapproved')
                    ->get();
                return count($getInfo);
            })
            ->rawColumns([
                'count'
            ])
            ->make(true);
    }

    public function getTableFundCancelled()
    {
        $fundRequestTable = DB::table('fund_requests')
            ->join('users as CiName','CiName.id','=','fund_requests.ci_id')
//            ->join('users as SaoName','SaoName.id','=','fund_requests.sao_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id',
                    'CiName.name as fci',
//                    'SaoName.name as sao',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.sao_logs_date_time',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where('count.type','Cancelled')
            ->where('dispatcher_status','CANCELLED');
//            ->where('sao_id',Auth::user()->id);

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('pending_cancel_details_endorsements/' . $fundRequestTable->id);
            })
            ->make(true);
    }

    public function sao_cancel_fund(Request $request)
    {
        $saoStatus = DB::table('fund_requests')
            ->select
            (
                'sao_status',
                'ci_id'
            )
            ->where('id',base64_decode($request->fundHash))
            ->first();

        if($saoStatus->sao_status=='APPROVED')
        {
            return response()->json('error');
        }
        else if($saoStatus->sao_status=='DISAPPROVED')
        {
            return response()->json('disapproved');
        }
        else
        {
            DB::table('fund_requests')
                ->where('id',base64_decode($request->fundHash))
                ->update
                (
                    [
                        'dispatcher_status'=>strtoupper('CANCELLED')
                    ]
                );


            DB::table('fund_request_endorsements')
                ->where('fund_id',base64_decode($request->fundHash))
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
                ->where('fund_id',base64_decode($request->fundHash))
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
            $fund_audit->fund_logs('FUND REQUEST CANCELLED FOR: '.$get_name->name.'',base64_decode($request->fundHash));
            return response()->json('success');
        }
    }

    public function sao_send_request_add_fund(Request $request)
    {
        $id = DB::table('fund_requests')
            ->insertGetId
            (
                [
                    'dispatcher_id'=> 0,
                    'ci_id'=> $request->selFciName,
                    'sao_id'=> Auth::user()->id,
                    'fund_amount'=>base64_encode($request->txtFundAmount),
                    'fund_original_amount' => base64_encode($request->txtFundAmount),
//                    'dispatcher_request_date'=>Carbon::now('Asia/Manila'),
                    'sao_remarks'=>strtoupper($request->txtFundRemarks),
//                    'sao_status'=>strtoupper('ON-PROCESS'),
                    'dispatcher_status'=>strtoupper('ON-PROCESS'),
                    'type_of_fund_request'=>'EMERGENCY FUND',
                    'sao_logs_date_time' => Carbon::now('Asia/Manila'),
                    'sao_emergency_req_date_time' => Carbon::now('Asia/Manila'),
                    'created_at' => Carbon::now('Asia/Manila')
                ]
            );

        $get_fund_endorsements = DB::table('fund_request_endorsements')
            ->where(function ($query)
            {
                return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                    ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
            })
            ->where('fund_id',$request->fund_id)
            ->get();

        foreach ($get_fund_endorsements as $endorsement)
        {
            DB::table('fund_request_endorsements')
                ->insert([
                    'fund_id' => $id,
                    'endorsement_id' => $endorsement->endorsement_id,
                    'type' => 'Processing'
                ]);
        }

        $getCINInfo = DB::table('users')
            ->join('municipalities', 'municipalities.id', '=', 'users.branch')
            ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
            ->join('regions', 'regions.id', '=', 'provinces.region_id')
            ->select
            ([
                'regions.archipelago_id as archi'
            ])
            ->where('users.id', $request->selFciName)
            ->get();

        $fund_audit = new AuditFundQueries();
        $get_name = User::find($request->selFciName);
        $email = new EmailQueries();

        $fund_audit->fund_logs('ADDITIONAL FUND REQUEST FOR: '.$get_name->name.'. FOR THE AMOUNT OF: '.$request->txtFundAmount.'',$id);

//        $email->NotifToManagement(Auth::user()->name, $get_name->name, $request->txtFundAmount, $request->txtFundRemarks, $getCINInfo[0]->archi, 'SAO');

        return response()->json('success');
    }


}
