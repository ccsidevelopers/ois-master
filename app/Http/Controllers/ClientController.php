<?php

namespace App\Http\Controllers;

use App\Business;
use App\Coborrower;
use App\Employer;
use App\Endorsement;
use App\Generals\AuditQueries;
use App\Generals\DashboardQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\TatController;
use App\Generals\Trimmer;
use App\Municipality;
use App\Province;
use App\TypeOfLoan;
use App\TypeOfRequest;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\_caseless_remove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_IOFactory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;

class ClientController extends Controller
{


    public function var_session()
    {
        return $ses = Session();
    }

    public function getClientDashboard()
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
            } elseif (Auth::user()->hasRole('Client')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueriesClient();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                $tatAccounts = $dataDashboard[4];
                //            END


                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('client.client-dashboard', compact
                (
                    'endorsement',
                    'timeStamp',
                    'dueAccount',
                    'overdueAccount',
                    'tatAccounts',
                    'javs'
                ))
                    ->with(["page" => "clientdashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getClientPanel()
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
            } elseif (Auth::user()->hasRole('Client')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueriesClient();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                $tatAccounts = $dataDashboard[4];
                //            END
                
                //Added $provinces variable
                $provinces = Province::all();
                $tors = TypeOfRequest::all();
                $tols = TypeOfLoan::all();
                // $provinces = Province::all(); ADDED ON LIVE FEB 14,2022

                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('client.client-master', compact
                (
                    'endorsement',
                    'timeStamp',
                    'dueAccount',
                    'overdueAccount',
                    'tatAccounts',
                    'javs',
                    'provinces',
                    'tors',
                    'tols'
                ));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getEndorseAccount()
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
            } elseif (Auth::user()->hasRole('Client')) {
                $tors = TypeOfRequest::all();
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;
                return view('client.client-endorse-account', compact('provinces', 'tors','javs'))->with(["page" => "clientendorse", "datenow" => Carbon::now()]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getHistoryEndorsement()
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
            } elseif (Auth::user()->hasRole('Client')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;
                return view('client.client-history-endorsement',compact('javs'))->with(["page" => "client-history", "datenow" => Carbon::now()]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getListProvince()
    {
        $provinces = Province::all();
        $TOL = TypeOfLoan::all();

        $getClient = DB::table('user_client')
            ->select('user_branch')
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json([$provinces,$TOL,$getClient]);
    }

    public function getHistory(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                    'endorsements.dealer_name',
                    'endorsements.contract_number',
                    'endorsements.requestor_name',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->groupBy('endorsements.id')
            ->where('endorsement_user.client_id',$authing)
            ->where('endorsements.acct_status','!=',3)
            ->where('endorsements.acct_status','!=',4)
            ->where('endorsements.acct_status','!=',5)
            ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);


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

    public function getFinishAccount(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = [];

        if($request->max_date_endorsed == '6000-01-01' && $request->min_date_endorsed == '2015-01-01')
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',
                        'municipalities.muni_name as muni_name',
                        'provinces.name',
                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal'
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where(function($query)
                {
                    return $query->where('endorsements.client_status', '=', null)
                        ->orwhere('endorsements.client_status', '=', '');
                })
                ->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
//            ->where('endorsements.revised','')

        }
        else
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',

                        'municipalities.muni_name as muni_name',
                        'provinces.name',

                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal'
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where(function($query)
                {
                    return $query->where('endorsements.client_status', '=', null)
                        ->orwhere('endorsements.client_status', '=', '');
                })
//            ->where('endorsements.revised','')
                ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
                ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);
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

    public function getHoldAccount(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                    'endorsements.requestor_name',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsement_user.client_id',$authing)
            ->where('endorsements.acct_status',4)
            ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);


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

    public function getCancelAccount(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                    'endorsements.requestor_name',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsement_user.client_id',$authing)
            ->where('endorsements.acct_status',5)
            ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);


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

    public function getRevisedAccount(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                    'endorsements.requestor_name',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsement_user.client_id',$authing)
            ->where('endorsements.acct_status',3)
            ->where('endorsements.revised','true')
            ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
            ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);


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

    public function addEndorsement(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $validator = Validator::make($request->all(),
            [
                'acctFName' => 'required',
                'acctLName' => 'required',
                'address' => 'required',
                'municipality' => 'required',
                'clientName' => 'required',
                'requestorName' => 'required',
                'loanType' => 'required',
                'requestType' => 'required'
            ]);

        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        else
        {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ",$timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $endorse = new Endorsement;
            $endorse->date_endorsed = $date;
            $endorse->time_endorsed = $time;

            $for_excep_names = '';
            $for_excep_if_same_address_checker = '';

            $getStrMuni = DB::table('municipalities')
                ->select
                (
                    [
                        'muni_name',
                    ]
                )
                ->where('id',$request->municipality)
                ->first();

            $getProvID = DB::table('provinces')
                ->join('municipalities','municipalities.province_id','provinces.id')
                ->select(['provinces.id as provID'])
                ->where('municipalities.id',$request->municipality)
                ->first();

            // Store a piece of data in the session...
            session
            (
                [
                    'FName'=>$removeScript->scripttrim($request->acctFName),
                    'MName'=> $removeScript->scripttrim($request->acctMName),
                    'LName'=> $removeScript->scripttrim($request->acctLName),
                    'TOL'=>$removeScript->scripttrim($request->loanType),
                    'TOR'=>$removeScript->scripttrim($request->requestType),
                    'TOV'=>$removeScript->scripttrim($request->verifythrough),
                    'Address'=> $removeScript->scripttrim($request->address),
                    'Muni'=>$getStrMuni->muni_name,
                    'MuniID'=>$request->municipality,
                    'ProvID'=>$getProvID->provID,
                    'SubjectName'=>$removeScript->scripttrim($request->subjectName),
                    'DealerName'=>$removeScript->scripttrim($request->dealer_name),
                    'ContractNumber'=>$removeScript->scripttrim($request->contract_number),
                ]
            );



            //account
            $endorse->account_name = ($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName));
            $for_excep_names = $trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName);
            //address
            $endorse->address = ($trimmer->trims($request->address));

            $endorse->city_muni = strtoupper($request->municipality);
            $endorse->provinces = strtoupper($request->provinceName);

            $for_excep_if_same_address_checker = $trimmer->trims($request->address).' '.strtoupper($request->municipality).' '.strtoupper($request->provinceName);
            $endorse->client_name = strtoupper($request->clientName);

            //date_due and time_due
//            $get_due = new TatController();
//            $endorse->date_due = $get_due->DateTimeDue_Tat($request->municipality,'date');
//            $endorse->time_due = $get_due->DateTimeDue_Tat($request->municipality,'time');

            //requestor name
            $endorse->requestor_name =  ($trimmer->trims($request->requestorName));

            $endorse->type_of_loan = strtoupper($request->loanType);
            $endorse->type_of_request = strtoupper($request->requestType);

            //remarks
            $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));

            $endorse->verify_through = strtoupper($request->verifythrough);
            $endorse->prioritize = strtoupper($request->prioritize);
            $endorse->re_ci = strtoupper($request->ReCi);
            $endorse->acct_branch = Auth::user()->provinces()->first()->id;

            //internal
            $endorse->dealer_name = strtoupper($request->dealer_name);
            $endorse->contract_number = strtoupper($request->contract_number);

            if($request->paypal_tr_id != '')
            {
                $endorse->paypal_tr_id = $request->paypal_tr_id;
            }
            if($request->etar === '')
            {
                $endorse->rate = 'No Rate at this Address';
            }
            else
            {
                $endorse->rate = $request->etar;

            }
            $endorse->save();

            DB::table('paypal_requestor_info')
                ->where('tr_id', $request->paypal_tr_id)
                ->update([
                    'endorsement_id' => $endorse->id,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            $checkifclient = DB::table('user_client')
                ->where('user_id',Auth::user()->id)
                ->get();

            $authing = '';

            if(sizeof($checkifclient) <= 0)
            {
                $authing = Auth::user()->id;
            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }

            $user = User::find(Auth::user()->id);
            $user->endorsements()->attach($endorse->id,
                [
                    'position_id'   =>  $user->roles->first()->id,
                    'province_id'   =>  $user->provinces->first()->id,
                    'client_id'=>$authing
                ]
            );

            $endorseID = $endorse->id;
            $id_enodrse_iwan = $endorse->id;
            //INSERT TIMESTAMP ID
            DB::table('timestamps')
                ->insert
                ([
                    'endorsement_id' => $endorseID
                ]);
            //END OF TIMESTAMP ID

            // INSERT TYPE OF SUBJECT AND SUBJECT NAME
            DB::table('type_of_subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'type_of_subject_name' => strtoupper($request->tos)
                    ]
                );

            if($request->subjectName!='')
            {
                DB::table('subjects')
                    ->insert
                    (
                        [
                            'endorsement_id' => $endorseID,
                            'subject_name' => strtoupper($request->subjectName)
                        ]
                    );
//                subjectID

                $get_get_muni = Municipality::find($endorse->city_muni);

                DB::table('coborrowers')
                    ->insert([
                        'endorsement_id'            =>  $request->subjectID,
                        'coborrower_name'           =>  $endorse->account_name,
                        'coborrower_address'        =>  $endorse->address,
                        'coborrower_municipality'   =>  $get_get_muni->muni_name,
                        'coborrower_province'       =>  $endorse->provinces
                    ]);
            }
            else
            {
                DB::table('subjects')
                    ->insert
                    (
                        [
                            'endorsement_id' => $endorseID,
                            'subject_name' => 'NONE'
                        ]
                    );
            }

            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->endorseAccount($endorseID,$request);
            //END OF AUDIT

            $check_if_client = DB::table('user_client')
                ->where('user_id',Auth::user()->id)
                ->get();

            $get_client_id = '';

            if(sizeof($check_if_client) <= 0)
            {
                $get_client_id = Auth::user()->id;
            }
            else
            {
                $get_client_id = $check_if_client[0]->user_branch;
            }

            $exep = DB::table('client_exception')
                ->where('client_id',$get_client_id)
                ->select('first_exception','second_exception')
                ->get();



            //      COBORROWER
            $acctEndorse = Endorsement::find($endorse->id);

            if($request->countcoob > 0)
            {
                for($b=0;$b<=$request->countcoob-1;$b++)
                {
                    //EXCEPTION START HERE
                    if(count($exep) > 0)
                    {
                        if($exep[0]->second_exception == 'same address')
                        {
                            //                    $id_enodrse_iwan
                            if($for_excep_if_same_address_checker == $trimmer->trims($request->coborInfo[$b][1]).' '.strtoupper($request->coborInfo[$b][5]).' '.strtoupper($request->coborInfo[$b][3]))
                            {
                                $for_excep_names .= ' / '.$trimmer->trims($request->coborInfo[$b][0]);
                            }
                            else
                            {

                                $endorse = new Endorsement;
                                $endorse->date_endorsed = $date;
                                $endorse->time_endorsed = $time;
                                //account
                                $endorse->account_name = ($trimmer->trims($request->coborInfo[$b][0]));

                                //address
                                $endorse->address = ($trimmer->trims($request->coborInfo[$b][1]));

                                $endorse->city_muni = strtoupper($trimmer->trims($request->coborInfo[$b][5]));
                                $endorse->provinces = strtoupper($request->coborInfo[$b][3]);
                                $endorse->client_name = strtoupper($request->clientName);

                                //date_due and time_due
//                                $get_due = new TatController();
//                                $endorse->date_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'date');
//                                $endorse->time_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'time');

                                //requestor name
                                $endorse->requestor_name =  ($trimmer->trims($request->requestorName));

                                $endorse->type_of_loan = strtoupper($request->loanType);
                                $endorse->type_of_request = strtoupper($request->requestType);

                                //remarks
                                $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));

                                $endorse->verify_through = strtoupper($request->verifythrough);
                                $endorse->prioritize = strtoupper($request->prioritize);
                                $endorse->re_ci = strtoupper($request->ReCi);
                                $endorse->acct_branch = Auth::user()->provinces()->first()->id;
                                if($request->coborInfo[$b][4] === '')
                                {
                                    $endorse->rate = 'No Rate at this Address';
                                }
                                else
                                {
                                    $endorse->rate = $request->coborInfo[$b][4];

                                }
                                $endorse->save();


                                $checkifclient = DB::table('user_client')
                                    ->where('user_id',Auth::user()->id)
                                    ->get();

                                $authing = '';

                                if(sizeof($checkifclient) <= 0)
                                {
                                    $authing = Auth::user()->id;
                                }
                                else
                                {
                                    $authing = $checkifclient[0]->user_branch;
                                }

                                $user = User::find(Auth::user()->id);
                                $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                                $endorseID = $endorse->id;


                                //INSERT TIMESTAMP ID
                                DB::table('timestamps')
                                    ->insert
                                    ([
                                        'endorsement_id' => $endorseID
                                    ]);
                                //END OF TIMESTAMP ID
//
//                    // INSERT TYPE OF SUBJECT AND SUBJECT NAME
                                DB::table('type_of_subjects')
                                    ->insert
                                    (
                                        [
                                            'endorsement_id' => $endorseID,
                                            'type_of_subject_name' => strtoupper('COBORROWER')
                                        ]
                                    );
//
//                    if($request->subjectName!='')
//                    {
                                DB::table('subjects')
                                    ->insert
                                    (
                                        [
                                            'endorsement_id' => $endorseID,
                                            'subject_name' => strtoupper($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName))
                                        ]
                                    );
//                    }
//                    else
//                    {
//                        DB::table('subjects')
//                            ->insert
//                            (

//                                [
//                                    'endorsement_id' => $endorseID,
//                                    'subject_name' => 'NONE'
//                                ]
//                            );
//                    }

                                //AUDIT START HERE
                                $auditRemove = new AuditQueries();
                                $auditRemove->endorseAccount($endorseID,$request);
                                //END OF AUDIT
                            }

                            $coborArr = new Coborrower
                            (
                                [
                                    'coborrower_name'=> ($trimmer->trims($request->coborInfo[$b][0])),
                                    'coborrower_address'=> ($trimmer->trims($request->coborInfo[$b][1])),
                                    'coborrower_municipality'=> ($trimmer->trims($request->coborInfo[$b][2])),
                                    'coborrower_province'=>strtoupper($request->coborInfo[$b][3]),
                                ]
                            );
                            $acctEndorse->coborrowers()->save($coborArr);
                        }
                        else
                        {
                            $coborArr = new Coborrower
                            (
                                [
                                    'coborrower_name'=> ($trimmer->trims($request->coborInfo[$b][0])),
                                    'coborrower_address'=> ($trimmer->trims($request->coborInfo[$b][1])),
                                    'coborrower_municipality'=> ($trimmer->trims($request->coborInfo[$b][2])),
                                    'coborrower_province'=>strtoupper($request->coborInfo[$b][3]),
                                ]
                            );

                            $acctEndorse->coborrowers()->save($coborArr);

                            $endorse = new Endorsement;
                            $endorse->date_endorsed = $date;
                            $endorse->time_endorsed = $time;
                            //account
                            $endorse->account_name = ($trimmer->trims($request->coborInfo[$b][0]));

                            //address
                            $endorse->address = ($trimmer->trims($request->coborInfo[$b][1]));

                            $endorse->city_muni = strtoupper($trimmer->trims($request->coborInfo[$b][5]));
                            $endorse->provinces = strtoupper($request->coborInfo[$b][3]);
                            $endorse->client_name = strtoupper($request->clientName);

                            //date_due and time_due
//                            $get_due = new TatController();
//                            $endorse->date_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'date');
//                            $endorse->time_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'time');

                            //requestor name
                            $endorse->requestor_name =  ($trimmer->trims($request->requestorName));

                            $endorse->type_of_loan = strtoupper($request->loanType);
                            $endorse->type_of_request = strtoupper($request->requestType);

                            //remarks
                            $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));

                            $endorse->verify_through = strtoupper($request->verifythrough);
                            $endorse->prioritize = strtoupper($request->prioritize);
                            $endorse->re_ci = strtoupper($request->ReCi);
                            $endorse->acct_branch = Auth::user()->provinces()->first()->id;
                            if($request->coborInfo[$b][4] === '')
                            {
                                $endorse->rate = 'No Rate at this Address';
                            }
                            else
                            {
                                $endorse->rate = $request->coborInfo[$b][4];

                            }
                            $endorse->save();


                            $checkifclient = DB::table('user_client')
                                ->where('user_id',Auth::user()->id)
                                ->get();

                            $authing = '';

                            if(sizeof($checkifclient) <= 0)
                            {
                                $authing = Auth::user()->id;
                            }
                            else
                            {
                                $authing = $checkifclient[0]->user_branch;
                            }

                            $user = User::find(Auth::user()->id);
                            $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                            $endorseID = $endorse->id;

                            //INSERT TIMESTAMP ID
                            DB::table('timestamps')
                                ->insert
                                ([
                                    'endorsement_id' => $endorseID
                                ]);
                            //END OF TIMESTAMP ID
//
//                    // INSERT TYPE OF SUBJECT AND SUBJECT NAME
                            DB::table('type_of_subjects')
                                ->insert
                                (
                                    [
                                        'endorsement_id' => $endorseID,
                                        'type_of_subject_name' => strtoupper('COBORROWER')
                                    ]
                                );
//
//                    if($request->subjectName!='')
//                    {
                            DB::table('subjects')
                                ->insert
                                (
                                    [
                                        'endorsement_id' => $endorseID,
                                        'subject_name' => strtoupper($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName))
                                    ]
                                );
//                    }
//                    else
//                    {
//                        DB::table('subjects')
//                            ->insert
//                            (
//                                [
//                                    'endorsement_id' => $endorseID,
//                                    'subject_name' => 'NONE'
//                                ]
//                            );
//                    }

                            //AUDIT START HERE
                            $auditRemove = new AuditQueries();
                            $auditRemove->endorseAccount($endorseID,$request);
                            //END OF AUDIT
                        }
                    }
                    else
                    {
                        $coborArr = new Coborrower
                        (
                            [
                                'coborrower_name'=> ($trimmer->trims($request->coborInfo[$b][0])),
                                'coborrower_address'=> ($trimmer->trims($request->coborInfo[$b][1])),
                                'coborrower_municipality'=> ($trimmer->trims($request->coborInfo[$b][2])),
                                'coborrower_province'=>strtoupper($request->coborInfo[$b][3]),
                            ]
                        );

                        $acctEndorse->coborrowers()->save($coborArr);

                        $endorse = new Endorsement;
                        $endorse->date_endorsed = $date;
                        $endorse->time_endorsed = $time;
                        //account
                        $endorse->account_name = ($trimmer->trims($request->coborInfo[$b][0]));

                        //address
                        $endorse->address = ($trimmer->trims($request->coborInfo[$b][1]));

                        $endorse->city_muni = strtoupper($trimmer->trims($request->coborInfo[$b][5]));
                        $endorse->provinces = strtoupper($request->coborInfo[$b][3]);
                        $endorse->client_name = strtoupper($request->clientName);

                        //date_due and time_due
//                        $get_due = new TatController();
//                        $endorse->date_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'date');
//                        $endorse->time_due = $get_due->DateTimeDue_Tat($request->coborInfo[$b][5],'time');

                        //requestor name
                        $endorse->requestor_name =  ($trimmer->trims($request->requestorName));

                        $endorse->type_of_loan = strtoupper($request->loanType);
                        $endorse->type_of_request = strtoupper($request->requestType);

                        //remarks
                        $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));

                        $endorse->verify_through = strtoupper($request->verifythrough);
                        $endorse->prioritize = strtoupper($request->prioritize);
                        $endorse->re_ci = strtoupper($request->ReCi);
                        $endorse->acct_branch = Auth::user()->provinces()->first()->id;
                        if($request->coborInfo[$b][4] === '')
                        {
                            $endorse->rate = 'No Rate at this Address';
                        }
                        else
                        {
                            $endorse->rate = $request->coborInfo[$b][4];

                        }
                        $endorse->save();


                        $checkifclient = DB::table('user_client')
                            ->where('user_id',Auth::user()->id)
                            ->get();

                        $authing = '';

                        if(sizeof($checkifclient) <= 0)
                        {
                            $authing = Auth::user()->id;
                        }
                        else
                        {
                            $authing = $checkifclient[0]->user_branch;
                        }

                        $user = User::find(Auth::user()->id);
                        $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                        $endorseID = $endorse->id;

                        //INSERT TIMESTAMP ID
                        DB::table('timestamps')
                            ->insert
                            ([
                                'endorsement_id' => $endorseID
                            ]);
                        //END OF TIMESTAMP ID
//
//                    // INSERT TYPE OF SUBJECT AND SUBJECT NAME
                        DB::table('type_of_subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'type_of_subject_name' => strtoupper('COBORROWER')
                                ]
                            );
//
//                    if($request->subjectName!='')
//                    {
                        DB::table('subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'subject_name' => strtoupper($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName))
                                ]
                            );
//                    }
//                    else
//                    {
//                        DB::table('subjects')
//                            ->insert
//                            (
//                                [
//                                    'endorsement_id' => $endorseID,
//                                    'subject_name' => 'NONE'
//                                ]
//                            );
//                    }

                        //AUDIT START HERE
                        $auditRemove = new AuditQueries();
                        $auditRemove->endorseAccount($endorseID,$request);
                        //END OF AUDIT
                    }

                }


                if(count($exep) > 0)
                {
                    if($exep[0]->second_exception == 'same address')
                    {
                        DB::table('endorsements')
                            ->where('id',$id_enodrse_iwan)
                            ->update([
                                'account_name' => $for_excep_names
                            ]);
                    }
                }
            }

//            $checkqqq = ;

            if($request->it_is_direct == 'true')
            {
                $tracking_number = '';
                function generateRandomString($length = 5) {
                    return substr(str_shuffle(str_repeat($x='ABCDEFGHIJKLMNOPQRSTUVWXYZ',ceil($length/strlen($x)))),1,$length);
                }
                function generateRandomNumber($length = 5) {
                    return substr(str_shuffle(str_repeat($x='1234567890',ceil($length/strlen($x)))),1,$length);
                }

                $now = Carbon::now('Asia/Manila');
                $date_time = explode(" ",$now);
                $dateexplose = explode("-",$date_time[0]);
                $timeexplode = explode(":", $date_time[1]);
                $yearexplode = $dateexplose[0]; //year
                $monthexplde = $dateexplose[1]; //month
                $dayexplode = $dateexplose[2]; //day
                $hoursnow = $timeexplode[0]; //time
                $minutesnow = $timeexplode[1]; //minutes
                $secondsexplode = $timeexplode[2]; //seconds

                $tracking_number = generateRandomString().'-'.$yearexplode.$monthexplde.$dayexplode.'-'.$hoursnow.$minutesnow.$secondsexplode.'-'.generateRandomNumber();

                DB::table('endorsements_transaction_tracking')
                    ->insert([
                        'endorsement_id' => $endorseID,
                        'transaction_id' => $tracking_number,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                $emailSend = new EmailQueries();
                $emailSend->Send_Email_Individual_Client($endorseID);
            }
//            //COBORROWER END
            //END OF TYPE OF SUBJECT

            //link path
//            DB::table('endorsements')
//                ->where('id',$endorse->id)
//                ->update([
//                    'link_path' => '(Report of '.$endorse->account_name.')-'.Str::random(64).$endorse->id
//                ]);



            // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila
//812 - ctbc manila

//            $check_if_client = DB::table('user_client')
//                ->where('user_id',Auth::user()->id)
//                ->where(function ($query)
//                {
//                    return $query->orwhere('user_branch',423)
//                        ->orwhere('user_branch',486)
//                        ->orwhere('user_branch',345)
//                        ->orwhere('user_branch',411)
//                        ->orwhere('user_branch',356)
//                        ->orwhere('user_branch',812)
//                        ->orwhere('user_branch',388);
//                })
//                ->count();
//
//            if($check_if_client > 0)
//            {
            $emailSend = new EmailQueries();
            $emailSend->sendEmail($request);
//            }
            // $emailSend = new EmailQueries();
            $emailSend->sendEmail_for_admin($request);
            // END OF EMAIL

            return Response::json(['success' => true]);
        }
    }

    public function addEndorsementEvr(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $endorseID = '';
        $trimmer = new Trimmer();
        $validator = Validator::make($request->all(),
            [
                'acctFName' => 'required',
                'acctLName' => 'required',
                'clientName' => 'required',
                'empInfo' => 'required',
                'requestorName' => 'required',
                'loanType' => 'required',
                'requestType' => 'required'
            ]);

        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        else
        {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ",$timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            // Store a piece of data in the session...
            session
            (
                [
                    'FName'=>$removeScript->scripttrim($request->acctFName),
                    'MName'=>$removeScript->scripttrim($request->acctMName),
                    'LName'=>$removeScript->scripttrim($request->acctLName),
                    'TOL'=>$removeScript->scripttrim($request->loanType),
                    'TOR'=>$removeScript->scripttrim($request->requestType),
                    'TOV'=>$removeScript->scripttrim($request->verifythrough)
                ]
            );


            if($request->empInfo[0][1]!='')
            {
                for ($b = 0; $b <= count($request->empInfo) - 1; $b++)
                {



//                    INSERT MAIN ENDORSEMENT DATA
                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    //account name
                    $endorse->account_name =  ($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName));

                    //addresses
                    $endorse->address =  ($trimmer->trims($request->empInfo[$b][1]));

                    $endorse->city_muni =  strtoupper($request->empInfo[$b][2]);
                    $endorse->provinces = strtoupper($request->empInfo[$b][3]);
                    $endorse->client_name = strtoupper($request->clientName);

                    //date_due and time_due
//                    $get_due = new TatController();
//                    $endorse->date_due = $get_due->DateTimeDue_Tat($request->empInfo[$b][2],'date');
//                    $endorse->time_due = $get_due->DateTimeDue_Tat($request->empInfo[$b][2],'time');;


                    //requestor name
                    $endorse->requestor_name =  ($trimmer->trims($request->requestorName));
                    $endorse->type_of_loan = strtoupper($request->loanType);
                    $endorse->type_of_request = strtoupper($request->requestType);

                    //remarks
                    $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));
                    $endorse->verify_through = strtoupper($request->verifythrough);
                    $endorse->prioritize = strtoupper($request->prioritize);
                    $endorse->re_ci = strtoupper($request->ReCi);
                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    //internal
                    $endorse->dealer_name = strtoupper($request->dealer_name);
                    $endorse->contract_number = strtoupper($request->contract_number);

                    if($request->empInfo[$b][4] === '')
                    {
                        $endorse->rate = 'No Rate at this Address';
                    }
                    else{
                        $endorse->rate = $request->empInfo[$b][4];

                    }
                    $endorse->save();

                    //link path
//                    DB::table('endorsements')
//                        ->where('id',$endorse->id)
//                        ->update([
//                            'link_path' => '(Report of '.$endorse->account_name.')-'.Str::random(64).$endorse->id
//                        ]);

                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);
//                    END OF INSERT TO MAIN ENDORSEMENT DATA

//                    GATHER ACCT ID
                    $endorseID = $endorse->id;
//                    END OF GATHER ID

                    //INSERT TIMESTAMP ID
                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);
                    //END OF TIMESTAMP ID

                    //      INSERT EMPLOYER NAME
                    $acctEndorse = Endorsement::find($endorseID);


                    $empArr = new Employer
                    (
                        [
                            'employer_name'=> $removeScript->scripttrim($trimmer->trims($request->empInfo[$b][0])),
                        ]
                    );
                    $acctEndorse->employers()->save($empArr);
                    //      EMPLOYER END

                    //      COBORROWER
//                    $acctEndorse = Endorsement::find($endorseID);
//                    if($request->coborInfo[0][1]!='')
//                    {
//                        for($x=0;$x<=count($request->coborInfo)-1;$x++)
//                        {
//                            $coborArr = new Coborrower
//                            (
//                                [
//                                    'coborrower_name'=> ($trimmer->trims($request->coborInfo[$b][0])),
//                                    'coborrower_address'=> ($trimmer->trims($request->coborInfo[$b][1])),
//                                    'coborrower_municipality'=> ($trimmer->trims($request->coborInfo[$b][2])),
//                                    'coborrower_province'=>strtoupper($request->coborInfo[$x][3]),
//                                ]
//                            );
//                            $acctEndorse->coborrowers()->save($coborArr);
//                        }
//                    }
//                    //      COBORROWER END

                    // INSERT TYPE OF SUBJECT AND SUBJECT NAME
                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => $removeScript->scripttrim(strtoupper($request->tos))
                            ]
                        );

                    if($request->subjectName!='')
                    {
                        DB::table('subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'subject_name' => $removeScript->scripttrim(strtoupper($request->subjectName))
                                ]
                            );

                        $get_get_muni = Municipality::find($endorse->city_muni);

                        DB::table('coborrowers')
                            ->insert([
                                'endorsement_id'            =>  $request->subjectID,
                                'coborrower_name'           =>  $endorse->account_name,
                                'coborrower_address'        =>  $endorse->address,
                                'coborrower_municipality'   =>  $get_get_muni->muni_name,
                                'coborrower_province'       =>  $endorse->provinces
                            ]);
                    }
                    else
                    {
                        DB::table('subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'subject_name' => 'NONE'
                                ]
                            );
                    }
                    //END INSERT TYPE OF SUBJECT AND SUBJECT NAME
                }

                //AUDIT START HERE
                $auditRemove = new AuditQueries();
                $auditRemove->endorseAccount($endorseID,$request);
                //END OF AUDIT

                if($request->it_is_direct == 'true')
                {
                    $tracking_number = '';
                    function generateRandomString($length = 5) {
                        return substr(str_shuffle(str_repeat($x='ABCDEFGHIJKLMNOPQRSTUVWXYZ',ceil($length/strlen($x)))),1,$length);
                    }
                    function generateRandomNumber($length = 5) {
                        return substr(str_shuffle(str_repeat($x='1234567890',ceil($length/strlen($x)))),1,$length);
                    }

                    $now = Carbon::now('Asia/Manila');
                    $date_time = explode(" ",$now);
                    $dateexplose = explode("-",$date_time[0]);
                    $timeexplode = explode(":", $date_time[1]);
                    $yearexplode = $dateexplose[0]; //year
                    $monthexplde = $dateexplose[1]; //month
                    $dayexplode = $dateexplose[2]; //day
                    $hoursnow = $timeexplode[0]; //time
                    $minutesnow = $timeexplode[1]; //minutes
                    $secondsexplode = $timeexplode[2]; //seconds

                    $tracking_number = generateRandomString().'-'.$yearexplode.$monthexplde.$dayexplode.'-'.$hoursnow.$minutesnow.$secondsexplode.'-'.generateRandomNumber();

                    DB::table('endorsements_transaction_tracking')
                        ->insert([
                            'endorsement_id' => $endorseID,
                            'transaction_id' => $tracking_number,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    $emailSend = new EmailQueries();
                    $emailSend->Send_Email_Individual_Client($endorseID);
                }


                // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila
//812 - ctbc manila

//                $check_if_client = DB::table('user_client')
//                    ->where('user_id',Auth::user()->id)
//                    ->where(function ($query)
//                    {
//                        return $query->orwhere('user_branch',423)
//                            ->orwhere('user_branch',486)
//                            ->orwhere('user_branch',345)
//                            ->orwhere('user_branch',411)
//                            ->orwhere('user_branch',356)
//                            ->orwhere('user_branch',812)
//                            ->orwhere('user_branch',388);
//                    })
//                    ->count();
//
//                if($check_if_client > 0)
//                {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail($request);
//                }
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_for_admin($request);
                // END OF EMAIL

                return Response::json(['success' => true]);
            }
        }
    }

    public function addEndorsementBvr(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $endorseID = '';
        $validator = '';
        $trimmer = new Trimmer();
        if($request->corp == 'corp')
        {
            $validator = Validator::make($request->all(),
                [

                    'busInfo' => 'required',
                    'clientName' => 'required',
                    'requestorName' => 'required',
                    'loanType' => 'required',
                    'requestType' => 'required'
                ]);
        }
        else
        {
            $validator = Validator::make($request->all(),
                [

                    'acctFName' => 'required',
                    'acctLName' => 'required',
                    'busInfo' => 'required',
                    'clientName' => 'required',
                    'requestorName' => 'required',
                    'loanType' => 'required',
                    'requestType' => 'required'
                ]);
        }


        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        else
        {


            // Store a piece of data in the session...
            session
            (
                [
                    'FName'=>$removeScript->scripttrim($request->acctFName),
                    'MName'=>$removeScript->scripttrim($request->acctMName),
                    'LName'=>$removeScript->scripttrim($request->acctLName),
                    'TOL'=>$removeScript->scripttrim($request->loanType),
                    'TOR'=>$removeScript->scripttrim($request->requestType),
                    'TOV'=>$removeScript->scripttrim($request->verifythrough)
                ]
            );

            if($request->busInfo[0][1]!='')
            {
                for ($b = 0; $b <= count($request->busInfo) - 1; $b++)
                {


                    //          INSERT MAIN ENDORSEMENT DATA
                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;

                    if($request->corp == 'corp')
                    {
                        //account name
                        $endorse->account_name =  ($trimmer->trims($request->busInfo[$b][0]));
                    }
                    else
                    {
                        //account name
                        $endorse->account_name =  ($trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName));
                    }

                    //addresses
                    $endorse->address =  ($trimmer->trims($request->busInfo[$b][1]));

                    $endorse->city_muni = strtoupper($request->busInfo[$b][2]);
                    $endorse->provinces = strtoupper($request->busInfo[$b][3]);
                    $endorse->client_name = strtoupper($request->clientName);

                    //date_due and time_due
                    //date_due and time_due
//                    $get_due = new TatController();
//                    $endorse->date_due = $get_due->DateTimeDue_Tat($request->busInfo[$b][2],'date');
//                    $endorse->time_due = $get_due->DateTimeDue_Tat($request->busInfo[$b][2],'time');;

                    //requestor name
                    $endorse->requestor_name =  ($trimmer->trims($request->requestorName));

                    $endorse->type_of_loan = strtoupper($request->loanType);
                    $endorse->type_of_request = strtoupper($request->requestType);

                    //remarks
                    $endorse->client_remarks =  ($trimmer->trims($request->txtClientRemarks));

                    $endorse->verify_through = strtoupper($request->verifythrough);
                    $endorse->prioritize = strtoupper($request->prioritize);
                    $endorse->re_ci = strtoupper($request->ReCi);
                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    //internal
                    $endorse->dealer_name = strtoupper($request->dealer_name);
                    $endorse->contract_number = strtoupper($request->contract_number);

                    if($request->busInfo[$b][4] === '')
                    {
                        $endorse->rate = 'No Rate at this Address';
                    }
                    else
                    {
                        $endorse->rate = $request->busInfo[$b][4];

                    }
                    $endorse->save();

                    //link path
//                    DB::table('endorsements')
//                        ->where('id',$endorse->id)
//                        ->update([
//                            'link_path' => '(Report of '.$endorse->account_name.')-'.Str::random(64).$endorse->id
//                        ]);

                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);
                    //          END OF INSERT BVR TO MAIN TABLE

                    $endorseID = $endorse->id;

                    //INSERT TIMESTAMP ID
                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);
                    //END OF TIMESTAMP ID

                    //      INSERT RELATIONSHIP BUSINESS NAME
                    $acctEndorse = Endorsement::find($endorseID);

                    //business info
                    $busArr = new Business
                    (
                        [
                            'business_name'=> $removeScript->scripttrim($trimmer->trims($request->busInfo[$b][0]))
                        ]
                    );
                    $acctEndorse->businesses()->save($busArr);
                    //      BUSINESS END

//                    //      COBORROWER
//                    $acctEndorse = Endorsement::find($endorseID);
//                    if($request->coborInfo[0][1]!='')
//                    {
//                        for($x=0;$x<=count($request->coborInfo)-1;$x++)
//                        {
//                            $coborArr = new Coborrower
//                            (
//                                [
//                                    'coborrower_name'=> ($trimmer->trims($request->coborInfo[$x][0])),
//                                    'coborrower_address'=> ($trimmer->trims($request->coborInfo[$x][1])),
//                                    'coborrower_municipality'=> ($trimmer->trims($request->coborInfo[$x][2])),
//                                    'coborrower_province'=>strtoupper($request->coborInfo[$x][3]),
//                                ]
//                            );
//                            $acctEndorse->coborrowers()->save($coborArr);
//                        }
//                    }
//                    //      COBORROWER END

                    // INSERT TYPE OF SUBJECT AND SUBJECT NAME
                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => $removeScript->scripttrim(strtoupper($request->tos))
                            ]
                        );

                    if($request->subjectName!='')
                    {
                        DB::table('subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'subject_name' => $removeScript->scripttrim(strtoupper($request->subjectName))
                                ]
                            );

                        $get_get_muni = Municipality::find($endorse->city_muni);

                        DB::table('coborrowers')
                            ->insert([
                                'endorsement_id'            =>  $request->subjectID,
                                'coborrower_name'           =>  $endorse->account_name,
                                'coborrower_address'        =>  $endorse->address,
                                'coborrower_municipality'   =>  $get_get_muni->muni_name,
                                'coborrower_province'       =>  $endorse->provinces
                            ]);
                    }
                    else
                    {
                        DB::table('subjects')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $endorseID,
                                    'subject_name' => 'NONE'
                                ]
                            );
                    }
                    //END INSERT TYPE OF SUBJECT AND SUBJECT NAME
                }
                //AUDIT START HERE
                $auditRemove = new AuditQueries();
                $auditRemove->endorseAccount($endorseID,$request);
                //END OF AUDIT

                if($request->it_is_direct == 'true')
                {
                    $tracking_number = '';
                    function generateRandomString($length = 5) {
                        return substr(str_shuffle(str_repeat($x='ABCDEFGHIJKLMNOPQRSTUVWXYZ',ceil($length/strlen($x)))),1,$length);
                    }
                    function generateRandomNumber($length = 5) {
                        return substr(str_shuffle(str_repeat($x='1234567890',ceil($length/strlen($x)))),1,$length);
                    }

                    $now = Carbon::now('Asia/Manila');
                    $date_time = explode(" ",$now);
                    $dateexplose = explode("-",$date_time[0]);
                    $timeexplode = explode(":", $date_time[1]);
                    $yearexplode = $dateexplose[0]; //year
                    $monthexplde = $dateexplose[1]; //month
                    $dayexplode = $dateexplose[2]; //day
                    $hoursnow = $timeexplode[0]; //time
                    $minutesnow = $timeexplode[1]; //minutes
                    $secondsexplode = $timeexplode[2]; //seconds

                    $tracking_number = generateRandomString().'-'.$yearexplode.$monthexplde.$dayexplode.'-'.$hoursnow.$minutesnow.$secondsexplode.'-'.generateRandomNumber();

                    DB::table('endorsements_transaction_tracking')
                        ->insert([
                            'endorsement_id' => $endorseID,
                            'transaction_id' => $tracking_number,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    $emailSend = new EmailQueries();
                    $emailSend->Send_Email_Individual_Client($endorseID);
                }


                // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila
//812 - ctbc manila

//                $check_if_client = DB::table('user_client')
//                    ->where('user_id',Auth::user()->id)
//                    ->where(function ($query)
//                    {
//                        return $query->orwhere('user_branch',423)
//                            ->orwhere('user_branch',486)
//                            ->orwhere('user_branch',345)
//                            ->orwhere('user_branch',411)
//                            ->orwhere('user_branch',356)
//                            ->orwhere('user_branch',812)
//                            ->orwhere('user_branch',388);
//                    })
//                    ->count();
//
//                if($check_if_client > 0)
//                {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail($request);
//                }
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_for_admin($request);
                // END OF EMAIL

                return Response::json(['success' => true]);
            }
        }
    }

    public function doubleEndorseChecker(Request $request)
    {
        $trimmer = new Trimmer();
        $fullname = ($trimmer->trims($request->accountNameCheck));
        $typeofloan = ($trimmer->trims($request->typeOfLoanCheck));
        $typeofrequest = strtoupper($request->typeOfRequestCheck);


        $getUserPrivilege = DB::table('user_client')
            ->select(['user_id','user_branch'])
            ->where('user_id',Auth::user()->id)
            ->count();


        if($getUserPrivilege==1)
        {
            $getUserClient = DB::table('user_client')
                ->select(['user_id','user_branch'])
                ->where('user_id',Auth::user()->id)
                ->first();

            $acctStatHold = DB::table('endorsement_user')
                ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                ->select
                (
                    [
                        'endorsements.account_name',
                        'endorsements.type_of_request',
                        'endorsements.type_of_loan',
                        'endorsements.acct_status',
                        'endorsement_user.user_id',
                        'endorsement_user.client_id',
                    ]
                )
                ->where('endorsements.account_name', $fullname)
                ->where('endorsements.type_of_request', $typeofrequest)
                ->where('endorsements.type_of_loan', $typeofloan)
                ->where('endorsements.acct_status', 4)
                ->where('endorsement_user.client_id', $getUserClient->user_branch)
                ->count();

            $acctStatCancel = DB::table('endorsement_user')
                ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                ->select
                (
                    [
                        'endorsements.account_name',
                        'endorsements.type_of_request',
                        'endorsements.type_of_loan',
                        'endorsements.acct_status',
                        'endorsement_user.user_id',
                        'endorsement_user.client_id',
                    ]
                )
                ->where('endorsements.account_name', $fullname)
                ->where('endorsements.type_of_request', $typeofrequest)
                ->where('endorsements.type_of_loan', $typeofloan)
                ->where('endorsements.acct_status', 5)
                ->where('endorsement_user.client_id', $getUserClient->user_branch)
                ->count();


            if($request->cobromakerchecker == 'cobromaker')
            {
                $checkendorse = DB::table('endorsement_user')
                    ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                    ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsement_user.endorsement_id')
                    ->join('subjects','subjects.endorsement_id','=','endorsement_user.endorsement_id')
                    ->select
                    (
                        [
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.type_of_loan',
                            'endorsements.acct_status',
                            'endorsement_user.user_id',
                            'endorsement_user.client_id',
                        ]
                    )
                    ->where('endorsements.account_name', $fullname)
                    ->where('endorsements.type_of_request', $typeofrequest)
                    ->where('endorsement_user.client_id', $getUserClient->user_branch)
                    ->where('type_of_subjects.type_of_subject_name', 'COBORROWER')
                    ->where('subjects.subject_name', $request->subj)
                    ->count();
            }
            else if($request->accountNameCheck == 'corporate')
            {
                $checkendorse=0;
                $checkifdoublebvr =  DB::table('businesses')
                    ->join('endorsement_user','endorsement_user.endorsement_id','=','businesses.endorsement_id')
                    ->select('businesses.business_name as names')
                    ->where('endorsement_user.client_id',$getUserClient->user_branch)
                    ->get();

                for($ctr = 0; $ctr<count($request->busInfo); $ctr++)
                {
                    foreach ($checkifdoublebvr as $checkifdoublebvrs)
                    {
                        if($checkifdoublebvrs->names == $trimmer->trims($request->busInfo[$ctr][0]))
                        {
                            $checkendorse += 1;
                        }
                    }
                }
            }
            else
            {
                $checkendorse = DB::table('endorsement_user')
                    ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                    ->select
                    (
                        [
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.type_of_loan',
                            'endorsements.acct_status',
                            'endorsement_user.user_id',
                            'endorsement_user.client_id',
                        ]
                    )
                    ->where('endorsements.account_name', $fullname)
                    ->where('endorsements.type_of_request', $typeofrequest)
                    ->where('endorsements.type_of_loan', $typeofloan)
                    ->where('endorsement_user.client_id', $getUserClient->user_branch)
                    ->count();
            }

            if($acctStatHold>=1)
            {
                return response()->json('holdacct');
            }
            elseif($acctStatCancel >= 1)
            {
                return response()->json('cancelacct');
            }
            elseif($checkendorse >= 1)
            {
                return response()->json('fail');
            }
            else
            {
                return response()->json('success');
            }
        }
        else
        {
            $acctStatHold = DB::table('endorsement_user')
                ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                ->select
                (
                    [
                        'endorsements.account_name',
                        'endorsements.type_of_request',
                        'endorsements.type_of_loan',
                        'endorsements.acct_status',
                        'endorsement_user.user_id',
                        'endorsement_user.client_id',
                    ]
                )
                ->where('endorsements.account_name', $fullname)
                ->where('endorsements.type_of_request', $typeofrequest)
                ->where('endorsements.type_of_loan', $typeofloan)
                ->where('endorsements.acct_status', 4)
                ->where('endorsement_user.client_id', Auth::user()->id)
                ->count();

            $acctStatCancel = DB::table('endorsement_user')
                ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                ->select
                (
                    [
                        'endorsements.account_name',
                        'endorsements.type_of_request',
                        'endorsements.type_of_loan',
                        'endorsements.acct_status',
                        'endorsement_user.user_id',
                        'endorsement_user.client_id',
                    ]
                )
                ->where('endorsements.account_name', $fullname)
                ->where('endorsements.type_of_request', $typeofrequest)
                ->where('endorsements.type_of_loan', $typeofloan)
                ->where('endorsements.acct_status', 5)
                ->where('endorsement_user.client_id', Auth::user()->id)
                ->count();

            if($request->cobromakerchecker == 'cobromaker')
            {
                $checkendorse = DB::table('endorsement_user')
                    ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                    ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsement_user.endorsement_id')
                    ->join('subjects','subjects.endorsement_id','=','endorsement_user.endorsement_id')
                    ->select
                    (
                        [
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.type_of_loan',
                            'endorsements.acct_status',
                            'endorsement_user.user_id',
                            'endorsement_user.client_id',
                        ]
                    )
                    ->where('endorsements.account_name', $fullname)
                    ->where('endorsements.type_of_request', $typeofrequest)
                    ->where('endorsement_user.client_id', Auth::user()->id)
                    ->where('type_of_subjects.type_of_subject_name', 'COBORROWER')
                    ->where('subjects.subject_name', $request->subj)
                    ->count();
            }
            else if($request->accountNameCheck == 'corporate')
            {
                $checkendorse=0;
                $checkifdoublebvr =  DB::table('businesses')
                    ->join('endorsement_user','endorsement_user.endorsement_id','=','businesses.endorsement_id')
                    ->select('businesses.business_name as names')
                    ->where('endorsement_user.client_id',Auth::user()->id)
                    ->get();

                for($ctr = 0; $ctr<count($request->busInfo); $ctr++)
                {
                    foreach ($checkifdoublebvr as $checkifdoublebvrs)
                    {
                        if($checkifdoublebvrs->names == $trimmer->trims($request->busInfo[$ctr][0]))
                        {
                            $checkendorse += 1;
                        }
                    }
                }
            }
            else
            {
                $checkendorse = DB::table('endorsement_user')
                    ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                    ->select
                    (
                        [
                            'endorsements.account_name',
                            'endorsements.type_of_request',
                            'endorsements.type_of_loan',
                            'endorsements.acct_status',
                            'endorsement_user.user_id',
                            'endorsement_user.client_id',
                        ]
                    )
                    ->where('endorsements.account_name', $fullname)
                    ->where('endorsements.type_of_request', $typeofrequest)
                    ->where('endorsements.type_of_loan', $typeofloan)
                    ->where('endorsement_user.client_id', Auth::user()->id)
                    ->count();
            }

            if($acctStatHold>=1)
            {
                return response()->json('holdacct');
            }
            elseif($acctStatCancel >= 1)
            {
                return response()->json('cancelacct');
            }
            elseif($checkendorse >= 1)
            {
                return response()->json('fail');
            }
            else
            {
                return response()->json('success');
            }
        }
    }

    public function saveNote(Request $request)
    {
        DB::table('notes')
            ->insert
            (
                [
                    'endorsement_id'=>$request->acctID,
                    'endorsement_note'=>$request->txtNote
                ]
            );

        return \response()->json('success');
    }

    public function updateNote(Request $request)
    {
        DB::table('notes')
            ->where('endorsement_id',$request->acctID)
            ->update
            (
                [
                    'endorsement_note'=>$request->txtNote
                ]
            );

        return \response()->json('success');
    }

    public function getNote(Request $request)
    {
        $note = DB::table('notes')
            ->where('endorsement_id',$request->acctID)
            ->select(['endorsement_note'])
            ->get();

        return \response()->json($note);
    }

    public function auditDownloadReport(Request $request)
    {
        $account_id = base64_decode($request->id);

        $acctName = DB::table('endorsements')
            ->join('endorsement_user','endorsement_user.endorsement_id','=','endorsements.id')
            ->select('endorsements.account_name as account_name',
                'endorsements.link_path as link_path',
                'endorsement_user.client_id as client_id',
                'endorsements.revised as revise')
            ->where('endorsements.id', $account_id)
            ->where('endorsement_user.position_id', 6)
            ->first();

        if(Auth::user()->hasRole('Client'))
        {

            $checkifclient = DB::table('user_client')
                ->where('user_id',Auth::user()->id)
                ->select('user_branch','id')
                ->get();
            $authing = '';

            if(sizeof($checkifclient) <= 0)
            {
                $authing = Auth::user()->id;

            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }

            if($acctName->client_id == $authing)
            {
                $path_link = new DownloadZipLogic();
                $paths = $path_link->path_link($account_id);

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

                if($acctName->revise == 'true')
                {
                    if(File::exists(storage_path("/account_revised/".$paths.".zip")))
                    {
                        DB::table('audits')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $account_id,
                                    'name' => strtoupper(Auth::user()->name),
                                    'position' => strtoupper($this->var_session()->get('role')),
                                    'branch' => strtoupper($this->var_session()->get('userBranch')),
                                    'activities' => strtoupper('Downloaded Revised Report of '. $acctName->account_name),
                                    'date_occured' => $date,
                                    'time_occured' => $time
                                ]
                            );

                        return response()->download(storage_path("/account_revised/".$paths.".zip"));
                    }
                    else
                    {
                        echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                    }
                }
                else
                {
                    if(File::exists(storage_path('/account_client/'.$paths)))
                    {
                        if (File::isDirectory(storage_path('account_client/' . $paths)))
                        {
                            Zip::create(storage_path('/account_report/'.$paths.'.zip'), true)
                                ->add(storage_path('/account_client/'.$paths), true)
                                ->setPath(storage_path('/account_report'))
                                ->close();
                        };
//            File::deleteDirectory(public_path('account_client/'.$request->id));

                        DB::table('audits')
                            ->insert
                            (
                                [
                                    'endorsement_id' => $account_id,
                                    'name' => strtoupper(Auth::user()->name),
                                    'position' => strtoupper($this->var_session()->get('role')),
                                    'branch' => strtoupper($this->var_session()->get('userBranch')),
                                    'activities' => strtoupper('Downloaded Report of '. $acctName->account_name),
                                    'date_occured' => $date,
                                    'time_occured' => $time
                                ]
                            );

                        DB::table('endorsements')
                            ->where('id', $account_id)
                            ->update([
                                'client_status' => 'Downloaded'
                            ]);

                        return response()->download(storage_path("/account_report/".$paths.".zip"));

                    }
                    else if(File::exists(storage_path('/account_report/'.$paths.'.zip')))
                    {
                        DB::table('audits')
                            ->insert
                            (
                                [
                                    'endorsement_id' =>$account_id,
                                    'name' => strtoupper(Auth::user()->name),
                                    'position' => strtoupper($this->var_session()->get('role')),
                                    'branch' => strtoupper($this->var_session()->get('userBranch')),
                                    'activities' => strtoupper('Downloaded Report of '. $acctName->account_name),
                                    'date_occured' => $date,
                                    'time_occured' => $time
                                ]
                            );

                        DB::table('endorsements')
                            ->where('id', $account_id)
                            ->update([
                                'client_status' => 'Downloaded'
                            ]);

                        return response()->download(storage_path("/account_report/".$paths.".zip"));
                    }
                    else
                    {
                        echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                    }
                }

            }
            else
            {
                return 'oopsieee...........';

            }
        }
        else
        {
            return 'oops...........';
        }

    }

    public function client_audit_download_report_revision(Request $request)
    {

        $account_id = base64_decode($request->id);

        $acctName = DB::table('endorsements')
            ->join('endorsement_user','endorsement_user.endorsement_id','=','endorsements.id')
            ->select('endorsements.account_name as account_name','endorsements.link_path as link_path','endorsement_user.client_id as client_id')
            ->where('endorsements.id', $account_id)
            ->where('endorsement_user.position_id', 6)
            ->first();


        if(Auth::user()->hasRole('Client'))
        {

            $checkifclient = DB::table('user_client')
                ->where('user_id',Auth::user()->id)
                ->select('user_branch','id')
                ->get();
            $authing = '';

            if(sizeof($checkifclient) <= 0)
            {
                $authing = Auth::user()->id;

            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }

            if($acctName->client_id == $authing)
            {
                $path_link = new DownloadZipLogic();
                $paths = $path_link->path_link($account_id);

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

                if(File::exists(storage_path("/account_revised/".$paths.".zip")))
                {
                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $account_id,
                                'name' => strtoupper(Auth::user()->name),
                                'position' => strtoupper($this->var_session()->get('role')),
                                'branch' => strtoupper($this->var_session()->get('userBranch')),
                                'activities' => strtoupper('Downloaded Revised Report of '. $acctName->account_name),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    return response()->download(storage_path("/account_revised/".$paths.".zip"));
                }
                else
                {
                    echo'<script>alert(\'Report Not Available at this momment.\'); window.close();</script>';
                }
            }
            else
            {
                return 'oopsieee...........';

            }
        }
        else
        {
            return 'oops...........';
        }
    }

    public function RequestorChecker(Request $request)
    {
        $name = Auth::user()->name;
        return \response()->json($name);
    }

    public function client_upload_bulk_excel(Request $request)
    {
        $file = $request->file('excel');
        if ($file != null) {
            $name = 'Bulk Endorsement-B.I Client.' . $file->getClientOriginalExtension();
            if ($file->getClientOriginalExtension() == 'xlsx' || $file->getClientOriginalExtension() == 'xls' || $file->getClientOriginalExtension() == 'xlsm')
            {
                $alph = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I' , 'J', 'K', 'L', 'M', 'N', '0', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                $file->move(storage_path('/bulk_excel_bi/'), $name);
                $excel = Excel::load(storage_path('/bulk_excel_bi/' . $name), function ($reader) {
                    $reader->toArray();
                    $reader->noHeading();
                    $reader->getSheet(0);
                })->get();

                $objPHPExcel = PHPExcel_IOFactory::load(storage_path('/bulk_excel_bi/' . $name));
                $sheet = $objPHPExcel->getActiveSheet();

                $testnum = [];
                $num = 0;
                foreach ($sheet->getMergeCells() as $cells)
                {
                    $testnum[$num] = $cells;
                    $num++;
                }
                $newArray = [];
                $endVal = '';
                $testVal = 0;
                $start = '';
                $startSide = '';

                for($i = 0; $i < count($excel); $i++)
                {
                    for($j = 0; $j < 15; $j++)
                    {
                        $start = $i;
                        $startSide = $j;

                        $newArray[$i][$testVal] = $excel[$i][$j];
                        $testVal++;
                    }

                    $testVal = 0;
                }

                $porma2 ='';
                $pormamo = '';
                $startporma ='';
                $array = (array) $newArray;
                $dodongVal = '';
                $pormamo2 = '';

                for($u = 0;$u < count($testnum); $u++)
                {
                    $rangetest = explode(':', $testnum[$u]);

                    $valSplit1 = str_split($rangetest[0]);
                    $valSplit2 = str_split($rangetest[1]);

                    for($x = $start; $x < count($array) + $start;$x++ )
                    {
                        for($z = 0; $z < count($array[$x]); $z++)
                        {
                            $addx = $x + 1;
                            if($rangetest[0] == $alph[$z + $startSide].$addx)
                            {
                                $dodongVal = $array[$x][$z];
                                $pormamo = $z;
                                $startporma = $x;
                            }
                            if($rangetest[1] == $alph[$z + $startSide].$addx)
                            {
                                $pormamo2 = $z;
                                $porma2 = $x;
                            }
                        }
                    }
                    if($valSplit1[0][0] == $valSplit2[0][0])
                    {
                        for ($q = $startporma; $q <= $porma2; $q++) {
                            $array[$q][$pormamo] = $dodongVal;
                        }
                    }
                    else
                    {
                        for($t = $pormamo; $t <= $pormamo2 ; $t++)
                        {
                            $array[$startporma][$t] = $dodongVal;
                        }
                    }
                }
//                return response()->json($excel);
                return response()->json([$array, 1, count($array)]);
            }
            else if ($file->getClientOriginalExtension() != 'xlsx' || $file->getClientOriginalExtension() != 'xls'|| $file->getClientOriginalExtension() != 'xlsm')
            {
                return \response()->json(['type' => 'type']);
            }
        }
        else
        {
            echo 'hehe';
        }
    }

    public function client_bulk_endorsement_submit(Request $request)
    {
        $data = $request->bulkData;
        $indexPdrn = [];
        $indexBvr = [];
        $indexEvr = [];
        $trimmer = new Trimmer();
        $removeScript = new ScriptTrimmer();

        $newPdrn = [];
        $newBvr = [];
        $newEvr = [];

//        $countPDRN = 0;
//        $countBVR = 0;
//        $countEVR = 0;

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $checkPDRN = false;
        $checkEVR = false;
        $checkBVR = false;

        $ctrPDRNmain = 0;
        $ctrBVRmain = 0;
        $ctrEVTmain = 0;

        foreach($data as $toLoop)
        {
            foreach ($toLoop as $key => $value)
            {
                if($key == 'TYPE OF REQUEST' && $value == 'PDRN')
                {
                    $checkPDRN = true;
                    $checkEVR = false;
                    $checkBVR = false;
                }
                else if($key == 'TYPE OF REQUEST' && $value == 'BVR')
                {
                    $checkPDRN = false;
                    $checkEVR = true;
                    $checkBVR = false;
                }
                else if($key == 'TYPE OF REQUEST' && $value == 'EVR')
                {
                    $checkPDRN = false;
                    $checkEVR = false;
                    $checkBVR = true;
                }
            }

            if($checkPDRN == true)
            {
                $newPdrn[$ctrPDRNmain] = [];
                $countPDRN = 0;

                foreach ($toLoop as $key => $value)
                {
                    $newPdrn[$ctrPDRNmain][$countPDRN] = $value;
                    $countPDRN++;
                }

                $ctrPDRNmain++;
            }
            else if($checkEVR == true)
            {
                $newBvr[$ctrBVRmain] = [];
                $countBVR = 0;

                foreach($toLoop as $key => $value)
                {
                    $newBvr[$ctrBVRmain][$countBVR] = $value;
                    $countBVR++;
                }

                $ctrBVRmain++;
            }
            else if($checkBVR == true)
            {
                $newEvr[$ctrEVTmain] = [];
                $countEVR = 0;

                foreach($toLoop as $key => $value)
                {
                    $newEvr[$ctrEVTmain][$countEVR] = $value;
                    $countEVR++;
                }

                $ctrEVTmain++;
            }

            $checkPDRN = false;
            $checkEVR = false;
            $checkBVR = false;

        }

        if(count($newPdrn) > 0)
        {
            for($d = 0 ; $d < count($newPdrn); $d++)
            {
                $name1 = '';

                if($newPdrn[$d][7] == '')
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }
                else
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][7]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }

                if(strtoupper($newPdrn[$d][3]) == 'PRINCIPAL BORROWER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newPdrn[$d][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    $endorse->account_name = $name1;
                    $endorse->address = ($trimmer->trims($newPdrn[$d][10]));
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = strtoupper($newPdrn[$d][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newPdrn[$d][1]);
                    $endorse->type_of_loan = $trimmer->trims($newPdrn[$d][2]);
                    $endorse->type_of_request = $trimmer->trims($newPdrn[$d][0]);
                    $endorse->client_remarks =  $trimmer->trims($newPdrn[$d][13]);
                    $endorse->verify_through = $trimmer->trims($newPdrn[$d][15]);
                    $endorse->prioritize = $trimmer->trims($newPdrn[$d][14]);

                    if($newPdrn[$d][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newPdrn[$d][17]);
                    }

                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }
                    $endorse->save();

                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;


                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);

                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'SUBJECT'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' => 'NONE'
                            ]
                        );
                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newPdrn[$d]);
                }
                else
                {

                }
            }
        }

        if(count($newBvr) > 0)
        {
            for($j = 0; $j < count($newBvr); $j++)
            {
                $name2 = '';

                if($newBvr[$j][7] == '')
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) .''. $trimmer->trims($newBvr[$j][8]);
                }
                else
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) . ' ' . $trimmer->trims($newBvr[$j][7]) . ' '. $trimmer->trims($newBvr[$j][8]);
                }

                if(strtoupper($newBvr[$j][3])  == 'PRINCIPAL BORROWER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newBvr[$j][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();

                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;

                    $endorse->account_name = $name2;
                    $endorse->address = $trimmer->trims($newBvr[$j][10]);
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = $trimmer->trims($newBvr[$j][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newBvr[$j][1]);
                    $endorse->type_of_loan = $trimmer->trims($newBvr[$j][2]);
                    $endorse->type_of_request = $trimmer->trims($newBvr[$j][0]);
                    $endorse->client_remarks =  $trimmer->trims($newBvr[$j][13]);
                    $endorse->verify_through = $trimmer->trims($newBvr[$j][15]);
                    $endorse->prioritize = $trimmer->trims($newBvr[$j][14]);

                    if($newBvr[$j][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newBvr[$j][17]);
                    }

                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }
                    $endorse->save();


                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;

                    //INSERT TIMESTAMP ID
                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);

                    $acctEndorse = Endorsement::find($endorseID);

                    //business info
                    $busArr = new Business
                    (
                        [
                            'business_name'=> $removeScript->scripttrim($trimmer->trims($newBvr[$j][9]))
                        ]
                    );
                    $acctEndorse->businesses()->save($busArr);


                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'SUBJECT'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' => 'NONE'
                            ]
                        );

                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newBvr[$j]);
                }
            }
        }

        if(count($newEvr) > 0)
        {
            for($k = 0 ; $k < count($newEvr); $k++)
            {
                $name3 = '';

                if($newEvr[$k][7] == '')
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }
                else
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][7]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }
                if(strtoupper($newEvr[$k][3]) == 'PRINCIPAL BORROWER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newEvr[$k][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();

                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    $endorse->account_name = $name3;
                    $endorse->address = $trimmer->trims($newEvr[$k][10]);
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = $trimmer->trims($newEvr[$k][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newEvr[$k][1]);
                    $endorse->type_of_loan = $trimmer->trims($newEvr[$k][2]);
                    $endorse->type_of_request = $trimmer->trims($newEvr[$k][0]);
                    $endorse->client_remarks =  $trimmer->trims($newEvr[$k][13]);
                    $endorse->verify_through = $trimmer->trims($newEvr[$k][15]);
                    $endorse->prioritize = $trimmer->trims($newEvr[$k][14]);

                    if($newEvr[$k][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newEvr[$k][17]);
                    }
                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }
                    $endorse->save();


                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;

                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);

                    $acctEndorse = Endorsement::find($endorseID);
                    $empArr = new Employer
                    (
                        [
                            'employer_name'=> $removeScript->scripttrim($trimmer->trims($newEvr[$k][9])),
                        ]
                    );
                    $acctEndorse->employers()->save($empArr);

                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'SUBJECT'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' => 'NONE'
                            ]
                        );

                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newEvr[$k]);
                }




            }
        }


        //cob
        if(count($newPdrn) > 0)
        {
            for($d = 0 ; $d < count($newPdrn); $d++)
            {

                $name1 = '';

                if($newPdrn[$d][7] == '')
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }
                else
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][7]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }

                if(strtoupper($newPdrn[$d][3]) == 'CO-BORROWER' ||strtoupper($newPdrn[$d][3]) == 'CO-MAKER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newPdrn[$d][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();

                    $acctEndorse = DB::table('endorsements')
                        ->select('id')
                        ->where('account_name', 'like', '%'. $trimmer->trims($newPdrn[$d][4]).'%')
                        ->take(1)
                        ->get()[0]->id;

                    DB::table('coborrowers')
                        ->insert
                        ([
                            'endorsement_id' => $acctEndorse,
                            'coborrower_name'=> $name1,
                            'coborrower_address'=> ($trimmer->trims($newPdrn[$d][10])),
                            'coborrower_municipality'=> ($trimmer->trims($getMuniFetched[0]->muni_name)),
                            'coborrower_province'=>strtoupper($newPdrn[$d][12]),
                        ]);

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    $endorse->account_name = $name1;
                    $endorse->address = ($trimmer->trims($newPdrn[$d][10]));
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = strtoupper($newPdrn[$d][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newPdrn[$d][1]);
                    $endorse->type_of_loan = $trimmer->trims($newPdrn[$d][2]);
                    $endorse->type_of_request = $trimmer->trims($newPdrn[$d][0]);
                    $endorse->client_remarks =  $trimmer->trims($newPdrn[$d][13]);
                    $endorse->verify_through = $trimmer->trims($newPdrn[$d][15]);
                    $endorse->prioritize = $trimmer->trims($newPdrn[$d][14]);

                    if($newPdrn[$d][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newPdrn[$d][17]);
                    }

                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }

                    $endorse->save();


                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;

                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);

                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'COBORROWER'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' => $name1
                            ]
                        );

                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newPdrn[$d]);
                }
            }
        }

        if(count($newBvr) > 0)
        {
            for($j = 0; $j < count($newBvr); $j++)
            {
                $name2 = '';

                if($newBvr[$j][7] == '')
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) .''. $trimmer->trims($newBvr[$j][8]);
                }
                else
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) . ' ' . $trimmer->trims($newBvr[$j][7]) . ' '. $trimmer->trims($newBvr[$j][8]);
                }

                if(strtoupper($newBvr[$j][3]) == 'CO-BORROWER' || strtoupper($newBvr[$j][3]) == 'CO-MAKER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newBvr[$j][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();

                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $acctEndorsePrin = DB::table('endorsements')
                        ->select('id')
                        ->where('account_name', 'like', '%'.$trimmer->trims($newBvr[$j][4]).'%')
                        ->take(1)
                        ->get()[0]->id;

                    DB::table('coborrowers')
                        ->insert
                        ([
                            'endorsement_id' => $acctEndorsePrin,
                            'coborrower_name'=> $name2,
                            'coborrower_address'=> ($trimmer->trims($newBvr[$j][10])),
                            'coborrower_municipality'=> ($trimmer->trims($getMuniFetched[0]->muni_name)),
                            'coborrower_province'=>strtoupper($newBvr[$j][12]),
                        ]);

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    $endorse->account_name = $name2;
                    $endorse->address = $trimmer->trims($newBvr[$j][10]);
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = $trimmer->trims($newBvr[$j][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newBvr[$j][1]);
                    $endorse->type_of_loan = $trimmer->trims($newBvr[$j][2]);
                    $endorse->type_of_request = $trimmer->trims($newBvr[$j][0]);
                    $endorse->client_remarks =  $trimmer->trims($newBvr[$j][13]);
                    $endorse->verify_through = $trimmer->trims($newBvr[$j][15]);
                    $endorse->prioritize = $trimmer->trims($newBvr[$j][14]);

                    if($newBvr[$j][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newBvr[$j][17]);
                    }


//                    $endorse->re_ci = $trimmer->trims($newBvr[$j][3]);


                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }
                    $endorse->save();


                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;

                    //INSERT TIMESTAMP ID
                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);
                    //END OF TIMESTAMP ID

                    //      INSERT RELATIONSHIP BUSINESS NAME
                    $acctEndorse = Endorsement::find($endorseID);

                    //business info
                    $busArr = new Business
                    (
                        [
                            'business_name'=> $removeScript->scripttrim($trimmer->trims($newBvr[$j][9]))
                        ]
                    );

                    $acctEndorse->businesses()->save($busArr);

                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'COBORROWER'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' => $name2
                            ]
                        );

                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newBvr[$j]);
                }
            }
        }

        if(count($newEvr) > 0)
        {
            for($k = 0 ; $k < count($newEvr); $k++)
            {
                $name3 = '';

                if($newEvr[$k][7] == '')
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }
                else
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][7]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }

                if(strtoupper($newEvr[$k][3]) == 'CO-BORROWER' || strtoupper($newEvr[$k][3]) == 'CO-MAKER')
                {
                    $muniID = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$newEvr[$k][11].'%')
                        ->take(1)
                        ->get();

                    $getProvID = DB::table('provinces')
                        ->join('municipalities','municipalities.province_id','provinces.id')
                        ->select
                        ([
                            'provinces.id as provID',
                        ])
                        ->where('municipalities.id', $muniID[0]->id)
                        ->get();

                    $getRates = DB::table('rates')
                        ->select('rate')
                        ->where('municipality_id', $muniID[0]->id)
                        ->where('province_id', $getProvID[0]->provID)
                        ->get();


                    $getMuniFetched = DB::table('municipalities')
                        ->select('muni_name')
                        ->where('id', $muniID[0]->id)
                        ->get();

                    $acctEndorsePrin = DB::table('endorsements')
                        ->select('id')
                        ->where('account_name', 'like', '%'.$trimmer->trims($newEvr[$k][4]).'%')
                        ->take(1)
                        ->get()[0]->id;

                    DB::table('coborrowers')
                        ->insert
                        ([
                            'endorsement_id' => $acctEndorsePrin,
                            'coborrower_name'=> $name3,
                            'coborrower_address'=> ($trimmer->trims($newEvr[$k][10])),
                            'coborrower_municipality'=> ($trimmer->trims($getMuniFetched[0]->muni_name)),
                            'coborrower_province'=>strtoupper($newEvr[$k][12]),
                        ]);

                    $endorse = new Endorsement;
                    $endorse->date_endorsed = $date;
                    $endorse->time_endorsed = $time;
                    $endorse->account_name = $name3;
                    $endorse->address = $trimmer->trims($newEvr[$k][10]);
                    $endorse->city_muni = $muniID[0]->id;
                    $endorse->provinces = $trimmer->trims($newEvr[$k][12]);
                    $endorse->client_name = $trimmer->trims($request->clientName);
                    $endorse->requestor_name = $trimmer->trims($newEvr[$k][1]);
                    $endorse->type_of_loan = $trimmer->trims($newEvr[$k][2]);
                    $endorse->type_of_request = $trimmer->trims($newEvr[$k][0]);
                    $endorse->client_remarks =  $trimmer->trims($newEvr[$k][13]);
                    $endorse->verify_through = $trimmer->trims($newEvr[$k][15]);
                    $endorse->prioritize = $trimmer->trims($newEvr[$k][14]);


                    if($newEvr[$k][17] == '')
                    {
                        $endorse->re_ci = 'NEW ENDORSEMENT';
                    }
                    else
                    {
                        $endorse->re_ci = $trimmer->trims($newEvr[$k][17]);
                    }


//                    $endorse->re_ci = $trimmer->trims($newEvr[$k][3]);
                    $endorse->acct_branch = Auth::user()->provinces()->first()->id;

                    if(count($getRates) > 0)
                    {
                        $endorse->rate = $getRates[0]->rate;
                    }
                    else
                    {
                        $endorse->rate = 'No Rate at this Address';

                    }
                    $endorse->save();


                    $checkifclient = DB::table('user_client')
                        ->where('user_id',Auth::user()->id)
                        ->get();

                    $authing = '';

                    if(sizeof($checkifclient) <= 0)
                    {
                        $authing = Auth::user()->id;
                    }
                    else
                    {
                        $authing = $checkifclient[0]->user_branch;
                    }

                    $user = User::find(Auth::user()->id);
                    $user->endorsements()->attach($endorse->id,['position_id'=>$user->roles->first()->id,'province_id'=>$user->provinces->first()->id,'client_id'=>$authing]);

                    $endorseID = $endorse->id;

                    DB::table('timestamps')
                        ->insert
                        ([
                            'endorsement_id' => $endorseID
                        ]);

                    $acctEndorse = Endorsement::find($endorseID);
                    $empArr = new Employer
                    (
                        [
                            'employer_name'=> $removeScript->scripttrim($trimmer->trims($newEvr[$k][9]))
                        ]
                    );
                    $acctEndorse->employers()->save($empArr);

                    DB::table('type_of_subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'type_of_subject_name' => 'COBORROWER'
                            ]
                        );

                    DB::table('subjects')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorseID,
                                'subject_name' =>  $name3
                            ]
                        );

                    $auditRemove = new AuditQueries();
                    $auditRemove->endorseAccountBulk($endorseID,$newEvr[$k]);
                }



            }
        }



//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila

//        $check_if_client = DB::table('user_client')
//            ->where('user_id',Auth::user()->id)
//            ->where(function ($query)
//            {
//                return $query->orwhere('user_branch',423)
//                    ->orwhere('user_branch',486)
//                    ->orwhere('user_branch',345)
//                    ->orwhere('user_branch',411)
//                    ->orwhere('user_branch',356)
//                    ->orwhere('user_branch',388);
//
//            })
//            ->count();
//
//        if($check_if_client > 0)
//        {
//        $emailSend = new EmailQueries();
//        $emailSend->sendEmailBulk($data);
//        }

        $emailSend = new EmailQueries();
        $emailSend->sendEmail_for_admin_bulk($data);

        return [$newPdrn, $newBvr, $newEvr];
    }

    public function client_dl_bulk_template()
    {
        if(Auth::user() != null)
        {
            if(Auth::user()->hasRole('Client'))
            {
                return response()->download(storage_path('/client_bulk_template/Client bulk template.xlsm'));
            }
            else
            {
                return response('You are not allowed to download');
            }
        }
        else
        {
            return response('Session Expired Please Login Again To Continue');
        }
    }

    public function client_get_finish_account_read(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = [];

        if($request->max_date_endorsed == '6000-01-01' && $request->min_date_endorsed == '2015-01-01')
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',

                        'municipalities.muni_name as muni_name',
                        'provinces.name',

                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal'
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where('endorsements.client_status', '=', 'Read')
//            ->where('endorsements.revised','')
                ->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
        }
        else
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',

                        'municipalities.muni_name as muni_name',
                        'provinces.name',

                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal'
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where('endorsements.client_status', '=', 'Read')
//            ->where('endorsements.revised','')
                ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
                ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);
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

    public function client_get_finish_account_downloaded(Request $request)
    {
        $checkifclient = DB::table('user_client')
            ->where('user_id',Auth::user()->id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = Auth::user()->id;

        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }

        $endorsements = [];

        if($request->max_date_endorsed == '6000-01-01' && $request->min_date_endorsed == '2015-01-01')
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',
                        'endorsements.date_forwarded_to_client as date_forward',
                        'endorsements.time_forwarded_to_client as time_forward',

                        'municipalities.muni_name as muni_name',
                        'provinces.name',

                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal',
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where('endorsements.client_status', '=', 'Downloaded')
//            ->where('endorsements.revised','')
                ->where('date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30))
                ->where('date_endorsed','<=',Carbon::now('Asia/Manila'));
        }
        else
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
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
                        'endorsements.requestor_name',
                        'endorsements.date_forwarded_to_client as date_forward',
                        'endorsements.time_forwarded_to_client as time_forward',

                        'municipalities.muni_name as muni_name',
                        'provinces.name',

                        'endorsements.address',
                        'endorsements.client_remarks',
                        'endorsements.provinces',
                        'endorsements.acct_status',
                        'notes.endorsement_note as nonotes',
                        'endorsement_status_external',
                        'endorsement_status_internal',
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.acct_status',3)
                ->where('endorsements.client_status', '=', 'Downloaded')
//            ->where('endorsements.revised','')
                ->where('endorsements.date_endorsed','>=',$request->min_date_endorsed)
                ->where('endorsements.date_endorsed','<=',$request->max_date_endorsed);
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

    public function client_bulk_check_double_endorse(Request $request)
    {
        $data = $request->bulkData;
        $muniData = $request->muniChecking;
        $trimmer = new Trimmer();

        $newPdrn = [];
        $newBvr = [];
        $newEvr = [];

        $checkPDRN = false;
        $checkEVR = false;
        $checkBVR = false;

        $ctrPDRNmain = 0;
        $ctrBVRmain = 0;
        $ctrEVTmain = 0;

        $doubleEndorse = [];

        $checkMuniAcc = [];

        for($x = 0; $x < count($muniData); $x++)
        {
            $muniID = DB::table('municipalities')
                ->select('id')
                ->where('muni_name','like', '%'.$muniData[$x].'%')
                ->count();

            if($muniID < 1)
            {
                array_push($checkMuniAcc, $muniData[$x]);
            }
        }

        foreach($data as $toLoop)
        {
            foreach ($toLoop as $key => $value)
            {
                if($key == 'TYPE OF REQUEST' && $value == 'PDRN')
                {
                    $checkPDRN = true;
                    $checkEVR = false;
                    $checkBVR = false;
                }
                else if($key == 'TYPE OF REQUEST' && $value == 'BVR')
                {
                    $checkPDRN = false;
                    $checkEVR = true;
                    $checkBVR = false;
                }
                else if($key == 'TYPE OF REQUEST' && $value == 'EVR')
                {
                    $checkPDRN = false;
                    $checkEVR = false;
                    $checkBVR = true;
                }
            }

            if($checkPDRN == true)
            {
                $newPdrn[$ctrPDRNmain] = [];
                $countPDRN = 0;

                foreach ($toLoop as $key => $value)
                {
                    $newPdrn[$ctrPDRNmain][$countPDRN] = $value;
                    $countPDRN++;
                }

                $ctrPDRNmain++;
            }
            else if($checkEVR == true)
            {
                $newBvr[$ctrBVRmain] = [];
                $countBVR = 0;

                foreach($toLoop as $key => $value)
                {
                    $newBvr[$ctrBVRmain][$countBVR] = $value;
                    $countBVR++;
                }

                $ctrBVRmain++;
            }
            else if($checkBVR == true)
            {
                $newEvr[$ctrEVTmain] = [];
                $countEVR = 0;

                foreach($toLoop as $key => $value)
                {
                    $newEvr[$ctrEVTmain][$countEVR] = $value;
                    $countEVR++;
                }

                $ctrEVTmain++;
            }

            $checkPDRN = false;
            $checkEVR = false;
            $checkBVR = true;
        }

        if(count($newPdrn) > 0)
        {
            for ($d = 0; $d < count($newPdrn); $d++)
            {
                $name1 = '';

                if($newPdrn[$d][7] == '')
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }
                else
                {
                    $name1 = $trimmer->trims($newPdrn[$d][6]) . ' ' . $trimmer->trims($newPdrn[$d][7]) . ' ' . $trimmer->trims($newPdrn[$d][8]);
                }


                $reCi = '';

                if($newPdrn[$d][17] == '')
                {
                    $reCi = 'NEW ENDORSEMENT';
                }
                else
                {
                    $reCi = $trimmer->trims($newPdrn[$d][17]);
                }


                $endorseCount1 = DB::table('endorsements')
                    ->where('account_name', $name1)
                    ->where('address', $trimmer->trims($newPdrn[$d][10]))
                    ->where('type_of_loan', $trimmer->trims($newPdrn[$d][2]))
                    ->where('re_ci', $reCi)
                    ->count();

                if($endorseCount1 > 0)
                {
                    array_push($doubleEndorse, [$newPdrn[$d][2], $newPdrn[$d][5], $newPdrn[$d][10], $newPdrn[$d][17]]);
                }
                else
                {

                }

            }
        }

        if(count($newBvr) > 0)
        {
            for($j = 0; $j < count($newBvr); $j++)
            {
                $name2 = '';

                if($newBvr[$j][7] == '')
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) .''. $trimmer->trims($newBvr[$j][8]);
                }
                else
                {
                    $name2 = $trimmer->trims($newBvr[$j][6]) . ' ' . $trimmer->trims($newBvr[$j][7]) . ' '. $trimmer->trims($newBvr[$j][8]);
                }

                $reCi = '';

                if($newBvr[$j][17] == '')
                {
                    $reCi = 'NEW ENDORSEMENT';
                }
                else
                {
                    $reCi = $trimmer->trims($newBvr[$j][17]);
                }

                $endorseCount1 = DB::table('endorsements')
                    ->where('account_name', $name2)
                    ->where('address', $trimmer->trims($newBvr[$j][10]))
                    ->where('type_of_loan', $trimmer->trims($newBvr[$j][2]))
                    ->where('re_ci', $reCi)
                    ->count();

                if($endorseCount1 > 0)
                {
                    array_push($doubleEndorse, [$newBvr[$j][2], $newBvr[$j][5], $newBvr[$j][10], $newBvr[$j][17]] );
                }
                else
                {

                }
            }
        }

        if(count($newEvr) > 0)
        {
            for($k = 0 ; $k < count($newEvr); $k++)
            {
                $name3 = '';

                if($newEvr[$k][7] == '')
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }
                else
                {
                    $name3 = $trimmer->trims($newEvr[$k][6]) . ' ' . $trimmer->trims($newEvr[$k][7]) . ' ' . $trimmer->trims($newEvr[$k][8]);
                }

                $reCi = '';

                if($newEvr[$k][17] == '')
                {
                    $reCi = 'NEW ENDORSEMENT';
                }
                else
                {
                    $reCi = $trimmer->trims($newEvr[$k][17]);
                }

                $endorseCount1 = DB::table('endorsements')
                    ->where('account_name', $name3)
                    ->where('address', $trimmer->trims($newEvr[$k][10]))
                    ->where('type_of_loan', $trimmer->trims($newEvr[$k][2]))
                    ->where('re_ci', $reCi)
                    ->count();

                if($endorseCount1 > 0)
                {
                    array_push($doubleEndorse, [$newEvr[$k][2], $newEvr[$k][5], $newEvr[$k][10], $newEvr[$k][17]]);
                }
                else
                {

                }
            }
        }

        if(count($doubleEndorse) > 0 || count($checkMuniAcc) > 0)
        {
            return response()->json([$doubleEndorse, $checkMuniAcc]);
        }
        else
        {
            return 'ok';
        }

//        return [$newPdrn, $newBvr, $newEvr];
    }

    public function client_endorsement_edit_route_test(Request $request)
    {
        $getInfo = DB::table('endorsements')
            ->leftjoin('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->select([
                'endorsements.contract_number as contract_number',
                'endorsements.dealer_name as dealer_name',
                'endorsements.account_name as account_name',
                'endorsements.address as address',
                'endorsements.city_muni as city_muni_id',
                'municipalities.muni_name as city_muni',
                'endorsements.provinces',
                'endorsements.date_endorsed',
                'endorsements.time_endorsed',
                'endorsements.type_of_loan',
                'endorsements.prioritize',
                'endorsements.verify_through',
                'endorsements.client_remarks',
            ])
            ->where('endorsements.id', $request->id)
            ->get();

        return response()->json(['go', $getInfo]);
    }

    public function client_submit_endorsement_edit_details(Request $request)
    {
        $ses = Session();
        $test_array = [];
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];
        $data = json_decode($request->data, true);
        $index = $request->data_index;
        $endorse = new Endorsement();
        $endorse = $endorse::find(base64_decode($request->id));

        for($i = 0; $i < count($index); $i++)
        {
            $what = $index[$i];
            if($index[$i] == 'city_muni')
            {
                $search = $data[$what];
                $getMuni = DB::table('municipalities')
                    ->where('muni_name', $search)
                    ->select('id')
                    ->get();

                $endorse->$what = $getMuni[0]->id;
                $test_array[$i] = $getMuni[0]->id;
            }
            $test_array[$i] = strtoupper($data[$what]);
            $endorse->$what = strtoupper($data[$what]);
        }
        $endorse->save();

        $test = DB::table('audits')
            ->insertGetId([
                'endorsement_id' => $endorse->id,
                'name' => strtoupper(Auth::user()->name),
                'position' => strtoupper($ses->get('role')),
                'branch' => strtoupper($ses->get('userBranch')),
                'activities' => strtoupper('EDITED THE DETAILS OF ENDORSEMENT'),
                'date_occured' => $date,
                'time_occured' => $time
            ]);
        return 'ok';
    }
}
