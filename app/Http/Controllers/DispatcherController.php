<?php

namespace App\Http\Controllers;

use App\Endorsement;
use App\Events\DispatcherPusherEvent;
use App\Events\DispatchPusherEvent;
use App\Generals\AuditFundQueries;
use App\Generals\EmailQueries;
use App\Generals\MessageInformation;
use App\Generals\ScriptTrimmer;
use App\Generals\SmsNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use Yajra\DataTables\DataTables;
use App\Generals\AuditQueries;
use App\Generals\DashboardQueries;
use App\Timestamp;

class DispatcherController extends Controller
{

    public function var_session()
    {
        return $ses = Session();
    }


    public function getDispatcherPanel()
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
            } elseif (Auth::user()->hasRole('Dispatcher')) {

                // GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                // END

                $credit_investigators = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(['users.id', 'users.name'])
                    ->where('users.archive', 'False')
                    ->where('role_id', 4)
                    ->get();


                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                $fcis = DB::table('role_user')
                    ->join('users','users.id','=','role_user.user_id')
                    ->select
                    (
                        [
                            'users.name',
                            'users.id'
                        ]
                    )
                    ->where('role_user.role_id',4)
                    ->where('users.archive', 'False')
                    ->get();

                $saos = DB::table('role_user')
                    ->join('users','users.id','=','role_user.user_id')
                    ->select
                    (
                        [
                            'users.name',
                            'users.id'
                        ]
                    )
                    ->where('role_user.role_id',7)
                    ->where('users.archive', 'False')
                    ->where('users.branch',Auth::user()->branch)
                    ->get();

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                $dateNow = Carbon::now();
                $dn = $dateNow->toDateString();
                $dateNowasd = Carbon::now('Asia/Manila');
//                $time = date("H:i", strtotime($dateNow));

                $all_muni = DB::table('municipalities')
                    ->select('muni_name', 'id')
                    ->get();

                return view('bank_dept.dispatcher.dispatcher-master', compact('all_muni','endorsement', 'timeStamp', 'dueAccount', 'overdueAccount','credit_investigators', 'dateNow', 'time','fcis','saos','dn','dateNowasd','javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getDispatcherDashboard()
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
            } elseif (Auth::user()->hasRole('Dispatcher')) {
                // GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                // END


                return view('bank_dept.dispatcher.dispatcher-dashboard', compact('endorsement', 'timeStamp', 'dueAccount', 'overdueAccount'))->with(["page" => "dispatcher-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getDispatcherEndorsement()
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
            } elseif (Auth::user()->hasRole('Dispatcher')) {
                return view('bank_dept.dispatcher.dispatcher-endorsement')->with(["page" => "dispatcher-endorsement"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getDispatcherDispatchAccount()
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
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Dispatcher')) {
//            $credit_investigators = User::whereHas('roles', function($q)
//            {
//                $q->where('name', 'Credit Investigator');
//            })->get();

                $credit_investigators = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(['users.id', 'users.name'])
                    ->where('users.archive', 'False')
                    ->where('role_id', 4)
                    ->get();


                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                return view('bank_dept.dispatcher.dispatcher-dispatch-account', compact('credit_investigators', 'dateNow', 'time'))->with(["page" => "dispatcher-dispatch-account"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getFundRequest()
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
            elseif (Auth::user()->hasRole('Dispatcher'))
            {
                $dateNow = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                $fcis = DB::table('role_user')
                    ->join('users','users.id','=','role_user.user_id')
                    ->select
                    (
                        [
                            'users.name',
                            'users.id'
                        ]
                    )
                    ->where('role_user.role_id',4)
                    ->where('users.archive', 'False')
                    ->get();

                $saos = DB::table('role_user')
                    ->join('users','users.id','=','role_user.user_id')
                    ->select
                    (
                        [
                            'users.name',
                            'users.id'
                        ]
                    )
                    ->where('role_user.role_id',7)
                    ->where('users.archive', 'False')
                    ->where('users.branch',Auth::user()->branch)
                    ->get();

                return view('bank_dept.dispatcher.dispatcher-fund-request', compact('fcis','saos'))->with(["page" => "dispatcher-fund-request"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getDispatcherCiManagement()
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
            } elseif (Auth::user()->hasRole('Dispatcher')) {
                $credit_investigators = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 4)
                    ->get();

                $dateNow = Carbon::now();
                $dn = $dateNow->toDateString();
                $dateNowasd = Carbon::now('Asia/Manila');
                $time = date("H:i", strtotime($dateNow));

                return view('bank_dept.dispatcher.dispatcher-ci-management', compact('credit_investigators', 'dn', 'dateNow', 'dateNowasd', 'time'))->with(["page" => "dispatcher-ci-management"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function dispatchToCI(Request $request)
    {

        $users = User::find($request->ciID);
        $userID = $request->ciID;
        $message = 'dispacct';
//        \event(new DispatchPusherEvent($message,$userID));

        $timeStampNow = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStampNow);
        $dateNow = $splitDateTime[0];
        $timeNow = $splitDateTime[1];

//        $timeStamp = Carbon::parse($request->dateTime);
//        $splitDateTime = explode(" ",$timeStamp);
        $date = $request->date_due;
        $time = $request->time_due;



        $verifyAccount = DB::table('endorsements')
            ->where('id',$request->accountID)
            ->where('handled_by_credit_investigator','!=','')
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
            //        PROCESS FOR DISPATCHING ACCOUNT, MODIFIED MAIN TABLE AND ATTACH ACCOUNT TO DISPATCHER AND CI
            DB::table('endorsements')
                ->where('id', $request->accountID)
                ->update
                ([
                    'acct_status' => 1,
                    'handled_by_dispatcher' => strtoupper(Auth::user()->name),
                    'handled_by_credit_investigator' => strtoupper($request->ciName),
                    'date_due' => $date,
                    'time_due' => date("H:i", strtotime($time)),
                    'date_dispatched' => $dateNow,
                    'time_dispatched' => $timeNow
                ]);

            $acctProvince = Auth::user()->provinces->first()->id;

            $userCi = User::find($request->ciID);
            $userCi->endorsements()->attach($request->accountID,['position_id'=>$userCi->roles->first()->id,'province_id'=>$acctProvince]);

            $userDis = User::find(Auth::user()->id);
            $userDis->endorsements()->attach($request->accountID,['position_id'=>$userDis->roles->first()->id,'province_id'=>$userDis->provinces->first()->id]);
            //        END OF DISPATCHING PROCESS

            //      TOTAL TIME LOSS
            $timeStampNoww = Carbon::now('Asia/Manila');
            $dateEndorsed = Endorsement::find($request->accountID);
            $dateEndo = $dateEndorsed->date_endorsed;
            $timeEndorsed = Endorsement::find($request->accountID);
            $timeEndo = $timeEndorsed->time_endorsed;
            $dateTimeLoss = $timeStampNoww->diffForHumans(Carbon::parse($dateEndo . ' ' . $timeEndo));

            DB::table('timestamps')
                ->where('endorsement_id', $request->accountID)
                ->update(['time_dispatcher' => $dateTimeLoss]);
            //      END


            $message = $request->aim;
            $userID = $request->ciID;
//            \event(new DispatchPusherEvent($message, $userID));


            //        AUDIT TRAILING
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
                        'endorsement_id' => $request->accountID,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper($this->var_session()->get('role')),
                        'branch' => strtoupper($this->var_session()->get('userBranch')),
                        'activities' => strtoupper($request->accountName.' Dispatched to '.$request->ciName),
                        'date_occured' => $dateNow,
                        'time_occured' => $timeNow
                    ]
                );
            //        END OF AUDIT TRAILING

//            START OF SMS NOTIFICATION

            $ciNum = DB::table('ci_contacts')
                ->select
                (
                    [
                        'contact_number'
                    ]
                )
                ->where('ci_id',$request->ciID)
                ->first();

            $number = $ciNum->contact_number;

            $endoInfo = DB::table('endorsements')
                ->select
                (
                    [
                        'account_name',
                        'type_of_request',
                        'verify_through',
                        'date_due',
                        'time_due',
                        'client_remarks'
                    ]
                )
                ->where('id',$request->accountID)
                ->first();

            $message =  "ACCT NAME: ".$endoInfo->account_name.
                "\nTYPE OF REQUEST: ".$endoInfo->type_of_request.
                "\nTYPE OF CHECK: ".$endoInfo->verify_through.
                "\n".
                "\nPlease check OIMS for full details.";

            $apicode = 'PR-COMPR617657_F7ELA';

            $dispSmsNotif = new SmsNotification();
            $dispSmsNotif->DispatchSmsNotif($number,$message,$apicode);

            //   $emailSend = new EmailQueries();
            //   $emailSend->DispatcherDispatchedToCI($request);

//            END OF SMS NOTIFICATION
        }
    }

    public function tableViewManipulation(Request $request)
    {
        $search_potion = $request->search_option;

        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->join('regions','regions.id','=','provinces.region_id')
            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
//            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                    'endorsements.acct_status as status',
                    'endorsements.type_of_request',
                    'endorsements.type_of_loan',
                    'endorsements.client_name',
                    'endorsements.client_remarks',
                    'endorsements.requestor_name',
                    'endorsements.disp_auto as auto',
                    'endorsements.time_dispatched',
                    'endorsements.date_dispatched',
                    'municipalities.muni_name as muni_name',
                    'provinces.name',
                    'regions.region_name as region_name',
                    'archipelagos.archipelago_name as archipelago_name',

//                    'notes.endorsement_note',
                ]
            )
            ->orderBy('endorsements.date_dispatched', 'asc')
//            ->where('endorsements.handled_by_credit_investigator','')
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where(function ($query) {
                $query->orwhere('endorsements.acct_status', 1)
                    ->orwhere('endorsements.acct_status', '')
                    ->orwhere('endorsements.acct_status', 2)
                    ->orwhere('endorsements.acct_status', 3);
            })
            ->where(function($query) use ($search_potion)
            {
                if($search_potion != '')
                {
                    return $query->where('archipelagos.id', '=',$search_potion);
                }
            })
            ->where('endorsement_user.position_id',6)
            ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
            ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'));

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

    public function ciListAccount(Request $request)
    {
        $endorsements = [];

        if($request->searchall == 'all')
        {
            if($request->disp_if == 'Show all')
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
                            'endorsements.re_ci',
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.client_name',
                            'endorsements.handled_by_credit_investigator',
                            'endorsements.address',
                            'users.id as ci_id',
                            'municipalities.muni_name as muni_name',
                            'provinces.name as name',
                            'regions.region_name as region_name',
                            'archipelagos.archipelago_name as archipelago_name',
                        ]
                    )
                    ->where(function($query)
                    {
                        return $query->orwhere('endorsements.acct_status','!=',3)
                            ->orwhere('endorsements.acct_status','!=', 2);

                    })
                    ->where('endorsement_user.position_id','=',4)
                    ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                    ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
                    ->groupBy('endorsement_user.endorsement_id');

            }
            else if($request->disp_if == 'Show only me')
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
                            'endorsements.re_ci',
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.client_name',
                            'endorsements.handled_by_credit_investigator',
                            'endorsements.address',
                            'users.id as ci_id',
                            'municipalities.muni_name as muni_name',
                            'provinces.name as name',
                            'regions.region_name as region_name',
                            'archipelagos.archipelago_name as archipelago_name',
                        ]
                    )
                    ->where(function($query)
                    {
                        return $query->orwhere('endorsements.acct_status','!=',3)
                            ->orwhere('endorsements.acct_status','!=', 2);
                    })
                    ->groupBy('endorsement_user.endorsement_id')
                    ->where('endorsement_user.user_id', Auth::user()->id)
                    ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                    ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'));
            }
        }
        else
        {
            // return [$request->date_start,  $request->date_end];
            if($request->disp_if == 'Show all')
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
                            'endorsements.re_ci',
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.client_name',
                            'endorsements.handled_by_credit_investigator',
                            'endorsements.address',
                            'users.id as ci_id',
                            'municipalities.muni_name as muni_name',
                            'provinces.name as name',
                            'regions.region_name as region_name',
                            'archipelagos.archipelago_name as archipelago_name',
                        ]
                    )
                    ->where(function($query)
                    {
                        return $query->orwhere('endorsements.acct_status','!=',3)
                            ->orwhere('endorsements.acct_status','!=', 2);

                    })
                    ->where('endorsement_user.position_id',4)
                    ->where('endorsements.date_endorsed', '>=', $request->date_start_qq)
                    ->where('endorsements.date_endorsed', '<=', $request->date_end_qq)
                    ->groupBy('endorsement_user.endorsement_id');
            }
            else if($request->disp_if == 'Show only me')
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
                            'endorsements.re_ci',
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.client_name',
                            'endorsements.handled_by_credit_investigator',
                            'endorsements.address',
                            'users.id as ci_id',
                            'municipalities.muni_name as muni_name',
                            'provinces.name as name',
                            'regions.region_name as region_name',
                            'archipelagos.archipelago_name as archipelago_name',
                        ]
                    )
                    ->where(function($query)
                    {
                        return $query->orwhere('endorsements.acct_status','!=',3)
                            ->orwhere('endorsements.acct_status','!=', 2);

                    })
                    ->where('endorsement_user.user_id', Auth::user()->id)
                    ->where('endorsements.date_endorsed', '>=', $request->date_start_qq)
                    ->where('endorsements.date_endorsed', '<=', $request->date_end_qq)
                    ->groupBy('endorsement_user.endorsement_id');
            }

        }

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

    public function ciTransfer(Request $request)
    {

        $check = DB::table('endorsements')
            ->where('id',$request->acctID)
            ->where('fund_request','!=','fund_requested')
            ->select('acct_status')
            ->get();

        if(count($check) > 0)
        {
            if($check[0]->acct_status == 3)
            {
                return 'finish';
            }
            else if($check[0]->acct_status == 2)
            {
                return 'uploaded';
            }
            else
            {
                $ciName = User::find($request->ciID)->name;
                $ciNameTransfer = User::find($request->ciIDToTransfer)->name;
                $acctName = Endorsement::find($request->acctID)->account_name;

                User::find($request->ciID)
                    ->endorsements()
                    ->wherePivot('endorsement_id', $request->acctID)
                    ->detach();

//        $acctProvince = Endorsement::find($request->acctID)->acct_branch;
                $acctProvince = Auth::user()->provinces->first()->id;

                $ciUserTransfer = User::find($request->ciIDToTransfer);
                $ciUserTransfer->endorsements()
                    ->attach($request->acctID,['position_id'=>$ciUserTransfer->roles->first()->id,'province_id'=>$acctProvince]);

                DB::table('endorsements')
                    ->where('id', $request->acctID)
                    ->update
                    ([
                        'handled_by_credit_investigator' => strtoupper($ciNameTransfer),
                        'handled_by_dispatcher' => strtoupper(Auth::user()->name),
                        'fund_request' => 'Transferred'
                    ]);

                DB::table('fund_request_endorsements')
                    ->where('endorsement_id',$request->acctID)
                    ->where('type_label','')
                    ->update
                    (
                        [
                            'type'=>'Transferred',
                        ]
                    );


//      AUDIT TRAILING
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ",$timeStamp);
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

                DB::table('audits')
                    ->insert
                    (
                        [
                            'endorsement_id' => $request->acctID,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper($this->var_session()->get('role')),
                            'branch' => strtoupper($this->var_session()->get('userBranch')),
                            'activities' => strtoupper('ACCOUNT '.$acctName.' Transferred From '. $ciName.' To '. $ciNameTransfer),
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );


                $transfer_message = 'Account of '.$acctName.' Has been transferred from '.$ciName.' to '. $ciNameTransfer;


                $notif_message_transffered = new MessageInformation();
                $notif_message_transffered->SentMessage($transfer_message,$request->ciID,$request->ciIDToTransfer);



                //            START OF SMS NOTIFICATION
                $ciNum = DB::table('ci_contacts')
                    ->select
                    (
                        [
                            'contact_number'
                        ]
                    )
                    ->where('ci_id',$request->ciIDToTransfer)
                    ->get();

                if(count($ciNum) != 0)
                {
                    $number = $ciNum[0]->contact_number;
                }


                $endoInfo = DB::table('endorsements')
                    ->select
                    (
                        [
                            'account_name',
                            'type_of_request',
                            'verify_through',
                            'date_due',
                            'time_due',
                            'client_remarks'
                        ]
                    )
                    ->where('id',$request->acctID)
                    ->first();

                $message =  "ACCT NAME: ".$endoInfo->account_name.
                    "\nTYPE OF REQUEST: ".$endoInfo->type_of_request.
                    "\nTYPE OF CHECK: ".$endoInfo->verify_through.
                    "\n(TRANSFERRED ACCOUNT)".
                    "\n".
                    "\nPlease check OIMS for full details.";

                $apicode = 'PR-COMPR617657_F7ELA';


                $dispSmsNotif = new SmsNotification();
                $dispSmsNotif->DispatchSmsNotif($number,$message,$apicode);



                //   $emailSend = new EmailQueries();
                //   $emailSend->DispatcherTransferredToCI($request,$ciName,$ciNameTransfer);

                return 'success';
            }
        }
        else
        {
            return 'failed';
        }
//        END OF AUDIT TRAILING
    }

    public function getCiListAccount(Request $request)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];

        $ciAccount = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('endorsements.date_due',$date)
            ->where('user_id',$request->ciID)
            ->count();

        $ciName = User::find($request->ciID)->name;
        $ciPosition = User::find($request->ciID);
        $ciPositionName = $ciPosition->roles->first()->name;

        $ciPix = User::find($request->ciID);
        $ciPixPath = $ciPix->pix_path;

        $ciTAT = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('endorsements.endorsement_status_internal','TAT')
            ->where('user_id',$request->ciID)
            ->count();

        $ciOverdue = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('endorsements.endorsement_status_internal','OVERDUE')
            ->where('user_id',$request->ciID)
            ->count();

        $ciTotalAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('user_id',$request->ciID)
            ->count();


        return response()->json
        ([
            'ciName'=>$ciName,
            'ciCountAccount'=>$ciAccount,
            'ciPositionName'=>$ciPositionName,
            'ciPixPath'=>$ciPixPath,
            'ciTAT'=>$ciTAT,
            'ciOverdue'=>$ciOverdue,
            'ciTotalAccounts'=>$ciTotalAccounts,
            'dateToday'=> $date
        ]);
    }

    public function removeAccount(Request $request)
    {
        DB::table('endorsements')
            ->where('endorsements.id',$request->acctID)
            ->update
            ([
                'endorsements.date_due' => '',
                'endorsements.time_due' => '',
                'endorsements.type_of_sending_report' => '',
                'endorsements.endorsement_status_internal' => '',
                'endorsements.endorsement_status_external' => '',
                'endorsements.picture_status' => '',
                'endorsements.handled_by_dispatcher' => '',
                'endorsements.assigned_by_srao' => '',
                'endorsements.handled_by_account_officer' => '',
                'endorsements.handled_by_credit_investigator' => '',
                'endorsements.acct_status' => '',
                'endorsements.remarks' => '',

//                CLEARED INFORMATION TIMESTAMPS

                'endorsements.date_dispatched' => '',
                'endorsements.time_dispatched' => '',
                'endorsements.date_srao_assigned' => '',
                'endorsements.time_srao_assigned' => '',
                'endorsements.date_ci_visit' => '',
                'endorsements.time_ci_visit' => '',
                'endorsements.date_ci_forwarded' => '',
                'endorsements.time_ci_forwarded' => '',
                'endorsements.date_ao_download' => '',
                'endorsements.time_ao_download' => '',
                'endorsements.date_forwarded_to_client' => '',
                'endorsements.time_forwarded_to_client' => '',
            ]);

        DB::table('timestamps')
            ->where('endorsement_id',$request->acctID)
            ->update
            ([
                'time_dispatcher' => '',
                'time_srao' => '',
                'time_ci' => '',
                'time_ao' => ''
            ]);

        User::find($request->ciID)
            ->endorsements()
            ->wherePivot('endorsement_id', $request->acctID)
            ->detach();

        User::find(Auth::user()->id)
            ->endorsements()
            ->wherePivot('endorsement_id', $request->acctID)
            ->detach();

        DB::table('endorsement_user')
            ->where('position_id',3)
            ->where('endorsement_id', $request->acctID)
            ->delete();

        DB::table('endorsement_user')
            ->where('position_id',7)
            ->where('endorsement_id', $request->acctID)
            ->delete();

        $auditRemove = new AuditQueries();
        $auditRemove->auditRemove($request);

    }

    public function getGenerateReport(Request $request)
    {
//        $dateNow = Carbon::now();
//        $dn = $dateNow->toDateString();

        $report = DB::table('endorsements')
            ->select(['account_name','address'])
            ->where('date_due','2017-12-29');
        return DataTables::of($report)
            ->make(true);

    }

    public function getOtherInfo(Request $request)
    {
        $pdrnInfo = DB::table('endorsements')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->leftjoin('notes', 'notes.endorsement_id', '=', 'endorsements.id')
            ->select
            (
                [
                    'endorsements.account_name',
                    'endorsements.address',
                    'endorsements.city_muni',
                    'endorsements.provinces',
                    'endorsements.type_of_request',
                    'municipalities.muni_name',
                    'notes.endorsement_note as note'
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();

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

        $clientNotesRemarks = DB::table('endorsements')
            ->select
            (
                [
                    'client_remarks',
                    'date_due',
                    'time_due'
                ]
            )
            ->where('id',$request->acctID)
            ->get();

        $clientNotes = DB::table('notes')
            ->select
            (
                [
                    'endorsement_note',
                ]
            )
            ->where('endorsement_id',$request->acctID)
            ->get();


        return response()->json([$cobInfo,$empInfo,$busInfo,$pdrnInfo,$clientNotesRemarks,$clientNotes]);
    }

    public function getTimeDue(Request $request)
    {

        $timedue = DB::table('endorsements')
            ->select('time_due','date_due')
            ->where('id',$request->acctID)
            ->get();


        return response()->json($timedue);
    }

    public function UpdateGetTimeDue(Request $request)
    {

        $timeStamp = Carbon::parse($request->dateTime);
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $acctName = Endorsement::find($request->acctID)->account_name;

        DB::table('endorsements')
            ->where('id', $request->acctID)
            ->update([
                'date_due' => $date,
                'time_due' => date("H:i", strtotime($time))
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
                    'position' => strtoupper($this->var_session()->get('role')),
                    'branch' => strtoupper($this->var_session()->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT '.$acctName.' UPDATED DATE AND TIME DUE'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
        //    END OF AUDIT TRAILING

        return response()->json('success');
    }

    public function getTableFundRequest()
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
                    'CiName.id as fci_id',
//                    'SaoName.name as sao',
                    'fund_requests.sao_status',
                    'fund_requests.finance_status',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.type_of_fund_request',
                    'count.type as type',
                    \DB::raw('count(count.fund_id) as count'),
                ]
            )
            ->groupBy('count.fund_id')
            ->where('count.type','Processing','Transferred')
            ->where('delivered_date',null,'0000-00-00')
            ->where('dispatcher_status','ON-PROCESS')
            ->where('type_of_fund_request', 'NORMAL REQUEST');

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('pending_fund_details_endorsements/' . $fundRequestTable->id);
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

    public function getTableFundHistory(Request $request)
    {
        $fundRequestTable = DB::table('fund_requests')
            ->join('users as CiName','CiName.id','=','fund_requests.ci_id')
            ->join('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->join('endorsements','endorsements.id','=','count.endorsement_id')
            ->select
            (
                [
                    'fund_requests.id',
                    'CiName.name as fci',
                    'CiName.id as fci_id',
                    'fund_requests.fund_amount',
                    'fund_requests.dispatcher_request_date',
                    'fund_requests.type_of_fund_request',
                    \DB::raw('count(count.fund_id) as count'),
                    'endorsements.address'
                ]
            )
            ->groupBy('count.fund_id')
            ->where('endorsements.city_muni', $request->muni_id)
            ->where(function ($query) {
                $query->where('count.type', '=', 'Success')
                    ->orWhere('count.type', '=', 'Transferred');
            })
            ->where('fund_requests.delivered_date','!=','0000-00-00');

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('success_fund_details_endorsements/' . $fundRequestTable->id);
            })
            ->editColumn('address_edit', function($query)
            {
                $addressHolder = '';
                $dataHolder = DB::table('fund_request_endorsements')
                    ->join('endorsements','endorsements.id','=','fund_request_endorsements.endorsement_id')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->select([
                        'endorsements.address',
                        'municipalities.muni_name',
                    ])
                    ->where('fund_request_endorsements.fund_id', $query->id)
                    ->get();

                if(count($dataHolder) > 0)
                {
                    foreach ($dataHolder as $chunk_data)
                    {
                        $addressHolder .= $chunk_data->address . ' ' . strtoupper($chunk_data->muni_name) . ' / ';
                    }
                }
                else
                {
                    $addressHolder = 'NONE';
                }

                return $addressHolder;


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
                'address_edit',
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

        return DataTables::of($fundRequestTable)
            ->addColumn('details_url', function($fundRequestTable) {
                return url('pending_cancel_details_endorsements/' . $fundRequestTable->id);
            })
            ->make(true);
    }

    public function getTableFundChecker()
    {
        $fundTable = DB::table('ci_fund_realtime_amount')
            ->join('users','users.id','=','ci_fund_realtime_amount.user_id')
            ->select
            (
                [
                    'users.id as id',
                    'users.name',
                    'ci_fund_realtime_amount.fund',
                    'ci_fund_realtime_amount.fund_realtime'
                ]
            );

        return DataTables::of($fundTable)
            ->make(true);
    }

    public function sendFund(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $id = DB::table('fund_requests')
            ->insertGetId
            (
                [
                    'dispatcher_id'=>Auth::user()->id,
                    'ci_id'=>$request->selFciName,
                    'sao_id'=>$request->selSaoName,
                    'fund_amount'=>base64_encode($request->txtFundAmount),
                    'fund_original_amount' => base64_encode($request->txtFundAmount),
                    'dispatcher_request_date'=>Carbon::now('Asia/Manila'),
                    'dispatcher_remarks'=> $removeScript->scripttrim(strtoupper($request->txtFundRemarks)),
                    'dispatcher_status'=>strtoupper('ON-PROCESS'),
                    'type_of_fund_request'=>'NORMAL REQUEST',
                    'created_at' => Carbon::now('Asia/Manila')
                ]
            );

        $array_id = explode(',',$request->id_array);

        for($ctr = 0; $ctr<sizeof($array_id); $ctr++)
        {
            $countFund = DB::table('fund_request_endorsements')
                ->where('endorsement_id', $array_id[$ctr])
                ->where(function ($query)
                {
                    return $query->where('fund_request_endorsements.type', '!=','Disapproved')
                        ->orWhere('fund_request_endorsements.type', '!=', 'Transferred');
                })
                ->count();

            if($countFund > 1)
            {
                DB::table('fund_request_endorsements')
                    ->where('endorsement_id', $array_id[$ctr])
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
                ->insert([
                    'fund_id' => $id,
                    'endorsement_id' => $array_id[$ctr],
                    'type' => 'Processing'
                ]);

            DB::table('endorsements')
                ->where('id',$array_id[$ctr])
                ->update([
                    'fund_request' => 'fund_requested'
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



        $fund_audit->fund_logs('FUND REQUEST FOR: '.$get_name->name.'. FOR THE AMOUNT OF: '.$request->txtFundAmount.'',$id);

        $email = new EmailQueries();

        if(((int) $request->txtFundAmount) >= 2500)
        {
            $email->NotifToManagement(Auth::user()->name, $get_name->name, $request->txtFundAmount, $request->txtFundRemarks, $getCINInfo[0]->archi, 'Dispatcher');
        }
        else if(((int) $request->txtFundAmount) < 2500)
        {

        }



        return response()->json('success');
//        }
    }

    public function dispatcher_send_request_add_fund(Request $request)
    {
        $id = DB::table('fund_requests')
            ->insertGetId
            (
                [
                    'dispatcher_id'=>Auth::user()->id,
                    'ci_id'=> $request->selFciName,
                    'sao_id'=> 0,
                    'fund_amount'=>base64_encode($request->txtFundAmount),
                    'fund_original_amount' => base64_encode($request->txtFundAmount),
                    'dispatcher_request_date'=>Carbon::now('Asia/Manila'),
                    'dispatcher_remarks'=>strtoupper($request->txtFundRemarks),
                    'dispatcher_status'=>strtoupper('ON-PROCESS'),
                    'type_of_fund_request'=>'NORMAL REQUEST',
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
        $fund_audit->fund_logs('ADDITIONAL FUND REQUEST FOR: '.$get_name->name.'. FOR THE AMOUNT OF: '.$request->txtFundAmount.'',$id);

        $email = new EmailQueries();

        if(((int) $request->txtFundAmount) >= 2500)
        {
            $email->NotifToManagement(Auth::user()->name, $get_name->name, $request->txtFundAmount, $request->txtFundRemarks, $getCINInfo[0]->archi, 'Dispatcher');
        }
        else if(((int) $request->txtFundAmount) < 2500)
        {

        }

        return response()->json('success');
    }

    public function cancelFund(Request $request)
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

    public function dispatcher_get_realtime_fund_ci(Request $request)
    {
        $query = [];
        $array = $request->ids;

        for( $count = 0; $count<count($array); $count++)
        {

            $query[$count] = DB::table('ci_fund_realtime_amount')
                ->where('user_id','=',$array[$count])
                ->get();
        }

        return response()->json($query);

    }

    public function dispatcher_ci_check_endorsement_process_fund_request(Request $request)
    {
        $ci_id = $request->ci_id;
        $timeStampNow = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStampNow);
//        $dateNow = $splitDateTime[0];
//        $timeNow = $splitDateTime[1];

        if($request->min_date_endorsed == '2015-01-01')
        {
            $min_date = Carbon::now('Asia/Manila')->subDays(30);
        }
        else
        {
            $min_date = $request->min_date_endorsed;
        }
        
        
       $table = DB::table('endorsement_user')
            ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
            ->join('municipalities','municipalities.id','=','endorsements.city_muni')
//            ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsement_user.endorsement_id')
//            ->join('subjects','subjects.endorsement_id','=','endorsement_user.endorsement_id')
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
            ])
            ->orderBy('endorsements.id', 'desc')
            ->where('endorsement_user.user_id',$ci_id)
            ->where('endorsement_user.position_id',4)
            ->where('endorsements.fund_request','!=','fund_requested')
            ->where('endorsements.fund_request','!=','fund_uploaded')
            ->where('endorsements.date_endorsed','>=',$min_date)
            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed)
//            ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
//            ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila'))
            ->where('endorsements.acct_status','!=',3);

        return DataTables::of($table)
            ->editColumn('subjnames', function ($endorsements) {

                $subject = DB::table('subjects')
                    ->select(
                        [
                            'subject_name'
                        ]
                    )
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                return $subject[0]->subject_name;

            })
            ->editColumn('subjcoob', function ($endorsements) {

                $subject_type = DB::table('type_of_subjects')
                    ->select(
                        [
                            'type_of_subject_name'
                        ]
                    )
                    ->where('endorsement_id',$endorsements->id)
                    ->get();

                return $subject_type[0]->type_of_subject_name;

            })
            ->rawColumns(['subjnames','subjcoob'])
            ->make(true);
    }

    public function dispatcher_get_real_time_and_pending(Request $request)
    {
        $ci_id = $request->id;

        $pending =  DB::table('fund_requests')
            ->select([
                'fund_requests.fund_amount as fund_amount',
            ])
            ->where(function ($query) {
                $query->where('fund_requests.delivered_date', '=',null)
                    ->orWhere('fund_requests.delivered_date', '=', '0000-00-00');
            })
            ->where('fund_requests.dispatcher_status','ON-PROCESS')
            ->where('fund_requests.ci_id',$ci_id)
            ->get();

        $onhand = DB::table('ci_fund_realtime_amount')
            ->where('user_id',$ci_id)
            ->get();

        $remittancecheck = DB::table('fund_requests')
            ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
            ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
            ->select([
                'remittance.amount as amount',
                'ci_atm_fund.amount as amount_atm',
                'remittance.receive_status as status',
                'ci_atm_fund.receive_status as status_atm'
            ])
            ->where('fund_requests.ci_id',$ci_id)
            ->where(function ($query) {
                $query->where('remittance.receive_status','')
                    ->orWhere('ci_atm_fund.receive_status','');
            })
            ->get();

        $getname = User::find($ci_id)->name;

        $getCheckShell = DB::table('ci_atms')
            ->where('ci_id', $ci_id)
            ->where('bank_name', 'SHELL CARD')
            ->count();

        $getGasLimit = DB::table('ci_atms')
            ->join('ci_shell_card_info', 'ci_shell_card_info.atm_id', '=', 'ci_atms.id')
            ->select('ci_shell_card_info.shell_gas_limit as limit')
            ->where('ci_id', $ci_id)
            ->get();

        $getBanks = DB::table('ci_atms')
            ->select('bank_name')
            ->where('bank_name', '!=', 'SHELL CARD')
            ->where('ci_id', $ci_id)
            ->get();

        $unliqTotal = DB::table('fund_requests')
            ->where('type_of_fund_request', 'SHELL CARD REQUEST')
            ->where('approved_request_done', 'Done')
            ->where('ci_id', $ci_id)
            ->select('unliquidated_amount')
            ->get();

        $totalUnliq = 0;

        if(count($unliqTotal) > 0)
        {
            for($i = 0; $i < count($unliqTotal); $i++)
            {
                $totalUnliq += (int)$unliqTotal[$i]->unliquidated_amount;
            }
        }
        else
        {
            $totalUnliq = 0;
        }

        return response()->json([$pending,$onhand,$remittancecheck,$getname, $getCheckShell, $getGasLimit, $getBanks, $totalUnliq]);

    }

    public function pending_fund_details_endorsements(Request $request)
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
            ->where('fund_request_endorsements.type','Processing');

        return DataTables::of($details)
            ->make(true);
    }

    public function pending_success_details_endorsements(Request $request)
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
            ->where(function ($query) {
                $query->where('fund_request_endorsements.type', '=', 'Success')
                    ->orWhere('fund_request_endorsements.type', '=', 'Transferred');
            })
            ->where('fund_request_endorsements.fund_id',$request->id)
            ->where('fund_request_endorsements.type_label','');


        return DataTables::of($details)
            ->make(true);
    }

    public function pending_disapproved_details_endorsements(Request $request)
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
            ->where(function ($query) {
                $query->where('fund_request_endorsements.type', '=', 'Disapproved')
                    ->orWhere('fund_request_endorsements.type', '=', 'Transferred');
            })
            ->where('fund_request_endorsements.fund_id',$request->id)
            ->where('fund_request_endorsements.type_label','');

        return DataTables::of($details)
            ->make(true);
    }

    public function pending_cancel_details_endorsements(Request $request)
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
            ->where(function ($query) {
                $query->where('fund_request_endorsements.type', '=', 'Cancelled')
                    ->orWhere('fund_request_endorsements.type', '=', 'Transferred');
            })
            ->where('fund_request_endorsements.fund_id',$request->id)
            ->where('fund_request_endorsements.type_label','cancel_fund');

        return DataTables::of($details)
            ->make(true);
    }


    public function dispatcher_fund_general_logs()
    {
        $getTable = DB::table('fund_requests')
            ->join('users', 'users.id', '=', 'fund_requests.ci_id')
            ->leftjoin('users as user_sao_approve', 'user_sao_approve.id', '=', 'fund_requests.sao_id')
            ->leftjoin('users as user_manage_approve', 'user_manage_approve.id', '=', 'fund_requests.manage_approved_id')
            ->select
            ([
                'fund_requests.id as id',
                'fund_requests.dispatcher_request_date as date_time',
                'users.name as ci',
                'fund_requests.approved_request_done as apd',
                'fund_requests.success_hold_cancel as shc',
                'fund_requests.liquidation_status as stat',
                'fund_requests.fund_amount as amount',
                'fund_requests.delivered_date as sent',
                'fund_requests.fund_original_amount as orig',
                'fund_requests.dispatcher_status as disp',
                'fund_requests.finance_status as finance',
                'fund_requests.sao_status as sao_stat',
                'fund_requests.sao_approved_date as sao_app',
                'fund_requests.management_approved_date as manage_date',
                'user_sao_approve.name as sao_name',
                'user_manage_approve.name as manage_name',
                'fund_requests.type_of_fund_request as tor',
                'fund_requests.sao_id as sao'
            ])
            ->where('fund_requests.type_of_fund_request', 'NORMAL REQUEST')
            ->where('fund_requests.approved_request_done', '!=' , 'Assigned');

        return DataTables::of($getTable)
            ->make(true);
    }

    public function dispatcher_get_ci_contact_number_to_text(Request $request)
    {
        $number = DB::table('ci_contacts')
            ->select('contact_number')
            ->where('ci_id', $request->ci_id)
            ->get();

        return response()->json([$number]);
    }


    public function dispatcher_send_message_to_ci(Request $request)
    {
        $scriptTrim = new ScriptTrimmer();
        $splitMessage = str_split($scriptTrim->scripttrim($request->message), 479);
        $text = new SmsNotification();
        $status = '';

        if(Auth::user()->hasRole('Dispatcher'))
        {
            if(count($splitMessage) > 1)
            {
                $texting = '';
                for($i = 0; $i < count($splitMessage); $i++)
                {

                    $texting = $text->DispatcherSendMessageToCI($request, $splitMessage[$i]);

                    if($texting == '0')
                    {
                        $status = 'Success';

                        DB::table('dispatcher_text_logs')
                            ->insert([
                                'user_id' => Auth::user()->id,
                                'ci_id' => $request->ci_to_text_id,
                                'contact_number' => $request->contact_number,
                                'char_count' => $request->char_count,
                                'credit_count' => $request->credit,
                                'message_sent' => $scriptTrim->scripttrim($splitMessage[$i]),
                                'status' => $status,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                    else
                    {
                        $status = 'Failed';

                        DB::table('dispatcher_text_logs')
                            ->insert([
                                'user_id' => Auth::user()->id,
                                'ci_id' => $request->ci_to_text_id,
                                'contact_number' => $request->contact_number,
                                'char_count' => 0,
                                'credit_count' => 0,
                                'message_sent' => $scriptTrim->scripttrim($splitMessage[$i]),
                                'status' => $status,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                }
                return response()->json(['ok', $texting]);
            }
            else
            {
                $texting = $text->DispatcherSendMessageToCI($request, $splitMessage[0]);
                $credit = 0;

                if($texting == '0')
                {
                    $status = 'Success';
                    $credit = $request->credits_count;
                }
                else
                {
                    $status = 'Failed';
                }

                DB::table('dispatcher_text_logs')
                    ->insert([
                        'user_id' => Auth::user()->id,
                        'ci_id' => $request->ci_to_text_id,
                        'contact_number' => $request->contact_number,
                        'char_count' => $request->char_count,
                        'credit_count' => $credit,
                        'message_sent' => $scriptTrim->scripttrim($splitMessage[0]),
                        'status' => $status,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                return response()->json(['ok', $texting]);
            }
        }
        else
        {
            return 'role_error';
        }
    }

    public function dispatcher_get_messages_logs()
    {
        $now = Carbon::now('Asia/Manila');
        $messages = DB::table('dispatcher_text_logs')
            ->leftjoin('users as ci_name', 'ci_name.id', '=', 'dispatcher_text_logs.ci_id')
            ->join('users as sender', 'sender.id', '=', 'dispatcher_text_logs.user_id')
            ->select([
                'dispatcher_text_logs.id as id',
                'ci_name.name as ci_name',
                'sender.name as sender',
                'dispatcher_text_logs.credit_count as credit',
                'dispatcher_text_logs.message_sent as message',
                'dispatcher_text_logs.created_at as date_time',
                'dispatcher_text_logs.contact_number as contact_number',
                'dispatcher_text_logs.status as status'
            ])
            ->where('dispatcher_text_logs.created_at','>=',$now->subDays(30))
//            ->where('dispatcher_text_logs.created_at','<=',$now)
            ->orderByDesc('dispatcher_text_logs.id');

        return DataTables::of($messages)
            ->make(true);
    }

    public function dispatcher_resend_failed_message(Request $req)
    {
        $getText = DB::table('dispatcher_text_logs')
            ->where('id', $req->id)
            ->select([
                'dispatcher_text_logs.contact_number as number',
                'dispatcher_text_logs.message_sent as message',
                'dispatcher_text_logs.char_count as char',
                'dispatcher_text_logs.credit_count as cred',
            ])
            ->get();

        return $getText;
    }

    public function dispatcher_update_ci_contact_number(Request $request)
    {
        $checker = DB::table('ci_contacts')
            ->select('contact_number')
            ->where('ci_id', $request->ci_id)
            ->get();

        if(count($checker) == 0)
        {
            DB::table('ci_contacts')
                ->insert([
                    'ci_id' => $request->ci_id,
                    'contact_number' => $request->number_to_save,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else
        {
            if($checker[0]->contact_number != $request->number_to_save)
            {
                DB::table('ci_contacts')
                    ->where('ci_id', $request->ci_id)
                    ->update([
                        'contact_number' => $request->number_to_save,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('ci_contacts_update_history')
                    ->insert([
                        'user_id' => Auth::user()->id,
                        'ci_id' => $request->ci_id,
                        'old_num' => $checker[0]->contact_number,
                        'new_num' => $request->number_to_save,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {
                return 'already';
            }
        }
    }
}
