<?php

namespace App\Http\Controllers;

use App\bi_endorsement;
use App\bi_log;
use App\Generals\AuditFundQueries;
use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\Municipality;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_IOFactory;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;
use App\handler;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use App\SiteApplicationLink;

class GeneralController extends Controller
{
    public function endorsementList()
    {
        $endorsements = '';
//        if (Auth::user()->roles->first()->id === 7 || Auth::user()->roles->first()->id === 2 || Auth::user()->roles->first()->id === 3 || Auth::user()->roles->first()->id === 5)
//        {
        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
//            ->join('regions','regions.id','=','provinces.region_id')
//            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
//            ->leftjoin('users as ao_id', 'ao_id.name', '=', 'endorsements.handled_by_account_officer')
//            ->leftjoin('users as ci_id', 'ci_id.name', '=', 'endorsements.handled_by_credit_investigator')
//            ->leftjoin('employers','employers.endorsement_id','=','endorsement_user.endorsement_id')
//            ->leftjoin('businesses','businesses.endorsement_id','=','endorsement_user.endorsement_id')
//            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            ([
                'endorsements.id as id',
                'endorsements.date_endorsed as date_endorsed',
                'endorsements.time_endorsed as time_endorsed',
                'endorsements.account_name as account_name',
                'endorsements.requestor_name as requestor_name',
                'endorsements.type_of_request as type_of_request',
                'endorsements.provinces as provinces',
                'municipalities.muni_name as muni_name',
                'endorsements.client_name as client_name',
                'endorsements.acct_status as acct_status',
                'endorsements.date_due as date_due',
                'endorsements.time_due as time_due',
                'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                'endorsements.handled_by_account_officer as handled_by_account_officer',
                'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                'endorsements.re_ci as re_ci',
                'endorsements.ci_cert as ci_cert',
                'endorsements.address as address',
//                'archipelagos.archipelago_name as archipelago_name',
//                    'users.pix_path as pic_path',
//                    'ao_id.pix_path as ao_pic_path',
//                    'ci_id.pix_path as ci_pic_path',php at
//                    'employers.employer_name as evr_name',
//                    'businesses.business_name as bvr_name',
//                'notes.endorsement_note as nononote'
            ])
            ->where('position_id', 6)
            ->where('date_endorsed', '>=', Carbon::now('Asia/Manila')->subDays(30))
            ->where('date_endorsed', '<=', Carbon::now('Asia/Manila'));
//        }
        return DataTables::of($endorsements)
            ->editColumn('acct_status_view', function ($endorsements) {
                if ($endorsements->acct_status == '') {
                    return ' <small class="label bg-red fa fa-warning" style="width: 100%">NEW ACCOUNT</small>';

//                    return '<a class="btn btn-danger btn-xs" style="width: 100%">NEW ACCOUNT <i class="fa fa-warning"></i></a>';
                } elseif ($endorsements->acct_status == '5') {
                    return ' <small class="label bg-red fa fa-times-circle" style="width: 100%">CANCELLED</small>';

//                    return '<a class="btn btn-primary btn-xs" style="width: 100%">Cancelled <i class="fa fa-check"></i></a>';
                } elseif ($endorsements->acct_status == '4') {
                    return ' <small class="label bg-orange fa fa-hand-stop-o" style="width: 100%">HOLD</small>';

//                    return '<a class="btn btn-primary btn-xs" style="width: 100%">Hold<i class="fa fa-check"></i></a>';
                } elseif ($endorsements->acct_status == '3') {
                    return ' <small class="label bg-green fa fa-check" style="width: 100%">SUCCESS</small>';

//                    return '<a class="btn btn-success btn-xs" style="width: 100%">Success <i class="fa fa-check"></i></a>';
                } elseif ($endorsements->acct_status == '2') {
                    return ' <small class="label bg-light-blue fa fa-arrow-circle-right" style="width: 100%">DATA FORWARDED</small>';

//                    return '<a class="btn btn-info btn-xs" style="width: 100%">Data Forwarded <i class="fa fa-arrow-circle-right"></i></a>';
                } elseif ($endorsements->date_due . ' ' . $endorsements->time_due < Carbon::now('Asia/Manila')) {
                    return ' <small class="label bg-black fa fa-clock-o" style="width: 100%">LATE</small>';
                } elseif ($endorsements->acct_status == '1') {
                    return ' <small class="label bg-primary fa fa-motorcycle" style="width: 100%">ON FIELD</small>';
                }
                return '';
            })
            ->editColumn('type_of_request', function ($query) {
                if ($query->type_of_request == 'PDRN') {
                    return '<b>PDRN</b>';
                } else if ($query->type_of_request == 'BVR') {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>BVR:<br></b>' . $getinfo[0]->business_name . '</br>';

                } else if ($query->type_of_request == 'EVR') {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>EVR:<br></b>' . $getinfo[0]->employer_name . '</br>';
                } else {
                    return '';
                }
            })
            ->editColumn('client_name', function ($query) {

                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->client_name)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->client_name . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->client_name;
                }

            })
            ->editColumn('handled_by_account_officer', function ($query) {

                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_account_officer)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_account_officer . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_account_officer;
                }

            })
            ->editColumn('handled_by_credit_investigator', function ($query) {

                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_credit_investigator)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_credit_investigator . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_credit_investigator;
                }

            })
            ->editColumn('handled_by_dispatcher', function ($query) {

                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_dispatcher)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_dispatcher . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_dispatcher;
                }

            })
            ->rawColumns([
                'acct_status_view',
                'type_of_request',
                'client_name',
                'handled_by_account_officer',
                'handled_by_credit_investigator',
                'handled_by_dispatcher'
            ])
            ->make(true);
    }

    public function endorsementListManagement(Request $request)
    {
        $min = $request->min_date_endorsed;
        $max = $request->max_date_endorsed;
        $arch = 0;
        $endorsements = '';


        $seatrch_min = '';
        $seatrch_max = '';

        if ($min === '') {
            $seatrch_min = Carbon::now('Asia/Manila')->subDays(30)->toDateString();
        } else {
            $seatrch_min = $min;
        }

        if ($max === '') {
            $seatrch_max = Carbon::now('Asia/Manila')->toDateString();
        } else {
            $seatrch_max = $max;
        }

        if($request->arch == 'Luzon')
        {
            $arch = 1;
        }
        if($request->arch == 'Visayas')
        {
            $arch = 2;
        }
        if($request->arch == 'Mindanao')
        {
            $arch = 3;
        }

        if($request->arch == 'All')
        {
            $endorsements = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
//                ->leftjoin('users as ao_id', 'ao_id.name', '=', 'endorsements.handled_by_account_officer')
//                ->leftjoin('users as ci_id', 'ci_id.name', '=', 'endorsements.handled_by_credit_investigator')
//                ->leftjoin('employers','employers.endorsement_id','=','endorsement_user.endorsement_id')
//                ->leftjoin('businesses','businesses.endorsement_id','=','endorsement_user.endorsement_id')
//            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
                ->select
                ([
                    'endorsements.id as id',
                    'endorsements.date_endorsed as date_endorsed',
                    'endorsements.time_endorsed as time_endorsed',
                    'endorsements.account_name as account_name',
                    'endorsements.requestor_name as requestor_name',
                    'endorsements.type_of_request as type_of_request',
                    'endorsements.provinces as provinces',
                    'municipalities.muni_name as muni_name',
                    'endorsements.client_name as client_name',
                    'endorsements.acct_status as acct_status',
                    'endorsements.date_due as date_due',
                    'endorsements.time_due as time_due',
                    'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                    'endorsements.handled_by_account_officer as handled_by_account_officer',
                    'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                    'endorsements.re_ci as re_ci',
                    'endorsements.ci_cert as ci_cert',
                    'endorsements.date_forwarded_to_client as date_forwarded',
                    'endorsements.time_forwarded_to_client as time_forwarded',
                    'endorsements.date_ci_forwarded as date_ci',
                    'endorsements.time_ci_forwarded as time_ci',
                    'endorsements.address as address',
                    'archipelagos.archipelago_name as archipelago_name',
//                    'users.pix_path as pic_path',
//                    'ao_id.pix_path as ao_pic_path',
//                    'ci_id.pix_path as ci_pic_path',php at
//                    'employers.employer_name as evr_name',
//                    'businesses.business_name as bvr_name',
                    // 'notes.endorsement_note as nononote'
                ])
                ->where('endorsement_user.position_id', 6)
                ->where('endorsements.date_endorsed', '>=', $seatrch_min)
                ->where('endorsements.date_endorsed', '<=', $seatrch_max);
        }
        else if($request->archi != 'All')
        {
            $endorsements = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
//                ->leftjoin('users as ao_id', 'ao_id.name', '=', 'endorsements.handled_by_account_officer')
//                ->leftjoin('users as ci_id', 'ci_id.name', '=', 'endorsements.handled_by_credit_investigator')
//                ->leftjoin('employers','employers.endorsement_id','=','endorsement_user.endorsement_id')
//                ->leftjoin('businesses','businesses.endorsement_id','=','endorsement_user.endorsement_id')
//            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
                ->select
                ([
                    'endorsements.id as id',
                    'endorsements.date_endorsed as date_endorsed',
                    'endorsements.time_endorsed as time_endorsed',
                    'endorsements.account_name as account_name',
                    'endorsements.requestor_name as requestor_name',
                    'endorsements.type_of_request as type_of_request',
                    'endorsements.provinces as provinces',
                    'municipalities.muni_name as muni_name',
                    'endorsements.client_name as client_name',
                    'endorsements.acct_status as acct_status',
                    'endorsements.date_due as date_due',
                    'endorsements.time_due as time_due',
                    'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                    'endorsements.handled_by_account_officer as handled_by_account_officer',
                    'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                    'endorsements.re_ci as re_ci',
                    'endorsements.ci_cert as ci_cert',
                    'endorsements.date_forwarded_to_client as date_forwarded',
                    'endorsements.time_forwarded_to_client as time_forwarded',
                    'endorsements.date_ci_forwarded as date_ci',
                    'endorsements.time_ci_forwarded as time_ci',
                    'endorsements.address as address',
                    'archipelagos.archipelago_name as archipelago_name',
//                    'users.pix_path as pic_path',
//                    'ao_id.pix_path as ao_pic_path',
//                    'ci_id.pix_path as ci_pic_path',php at
//                    'employers.employer_name as evr_name',
//                    'businesses.business_name as bvr_name',
                    // 'notes.endorsement_note as nononote'
                ])
                ->where('endorsement_user.position_id', 6)
                ->where('endorsements.date_endorsed', '>=', $seatrch_min)
                ->where('endorsements.date_endorsed', '<=', $seatrch_max)
                ->where('archipelagos.id', '=', $arch);
        }







//        if (Auth::user()->roles->first()->id === 7 || Auth::user()->roles->first()->id === 2 || Auth::user()->roles->first()->id === 3 || Auth::user()->roles->first()->id === 5)
//        {

//            ->where('endorsements.date_endorsed','>=',Carbon::now('Asia/Manila')->subDays(30)->toDateString())
//            ->where('endorsements.date_endorsed','<=',Carbon::now('Asia/Manila')->toDateString());
//        }
        return DataTables::of($endorsements)
            ->editColumn('acct_status_view', function ($endorsements) {
                if ($endorsements->acct_status == '') {
                    return '<small class="label bg-red fa fa-warning" style="width: 100%">NEW ACCOUNT</small>';
                } else if ($endorsements->acct_status == '5') {
                    return '<small class="label bg-red fa fa-times-circle" style="width: 100%">CANCELLED</small>';
                } else if ($endorsements->acct_status == '4') {
                    return '<small class="label bg-orange fa fa-hand-stop-o" style="width: 100%">HOLD</small>';
                } else if ($endorsements->acct_status == '3') {
                    return '<small class="label bg-green fa fa-check" style="width: 100%">SUCCESS</small><br>';
                } else if ($endorsements->acct_status == '2') {
                    return '<small class="label bg-light-blue fa fa-arrow-circle-right" style="width: 100%">DATA FORWARDED</small>';

                } else if ($endorsements->date_due . ' ' . $endorsements->time_due < Carbon::now('Asia/Manila')) {
                    return ' <small class="label bg-black fa fa-clock-o" style="width: 100%">LATE</small>';
                } else if ($endorsements->acct_status == '1') {
                    return '<small class="label bg-primary fa fa-motorcycle" style="width: 100%">ON FIELD</small>';
                }
                return '';
            })
            ->editColumn('type_of_request', function ($query) {
                if ($query->type_of_request == 'PDRN') {
                    return '<b>PDRN</b>';
                } else if ($query->type_of_request == 'BVR') {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>BVR:<br></b>' . $getinfo[0]->business_name . '</br>';

                } else if ($query->type_of_request == 'EVR') {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>EVR:<br></b>' . $getinfo[0]->employer_name . '</br>';
                } else {
                    return '';
                }
            })
            ->editColumn('client_name', function ($query) {
                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->client_name)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->client_name . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->client_name;
                }

            })
            ->editColumn('handled_by_account_officer', function ($query) {
                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_account_officer)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_account_officer . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_account_officer;
                }

            })
            ->editColumn('handled_by_credit_investigator', function ($query) {
                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_credit_investigator)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_credit_investigator . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_credit_investigator;
                }

            })
            ->editColumn('handled_by_dispatcher', function ($query) {
                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->handled_by_dispatcher)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->handled_by_dispatcher . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->handled_by_dispatcher;
                }

            })
            ->editColumn('date_updated', function ($query) {
                if ($query->acct_status == '3') {
                    return $query->date_forwarded;
                } else if ($query->acct_status == '2') {
                    return $query->date_ci;
                } else {
                    return $query->date_endorsed;
                }
            })
            ->editColumn('time_updated', function ($query) {
                if ($query->acct_status == '3') {
                    return $query->time_forwarded;
                } else if ($query->acct_status == '2') {
                    return $query->time_ci;
                } else {
                    return $query->time_endorsed;
                }
            })
            ->rawColumns
            ([
                'acct_status_view',
                'type_of_request',
                'client_name',
                'handled_by_account_officer',
                'handled_by_credit_investigator',
                'handled_by_dispatcher',
                'date_updated',
                'time_updated'
            ])
            ->make(true);
    }

    public function notIdle(Request $request)
    {
        $userID = $request->userID;
        $userName = User::find($request->userID);
        $userN = $userName->name;

        DB::table('online_user')
            ->insert(['user_id' => $userID, 'user_name' => $userN]);

        $onlineUser = DB::table('online_user')
            ->pluck('user_name');

        $timeupdate = Carbon::now('Asia/Manila');
        $timelimit = Carbon::now('Asia/Manila')->addMinutes(5);
        if (DB::table('lat_longs')->select('CI_ID')->where('CI_ID', $userID)->count() >= 1) {

            DB::table('lat_longs')
                ->where('CI_ID', $userID)
                ->update
                (
                    [
                        'Status' => 'Online',
                        'Last_Update' => $timeupdate,
                        'Time_Limit' => $timelimit
                    ]
                );
        }

        return response()->json(array(['online' => $onlineUser]));
    }

    public function idle(Request $request)
    {
        $userID = $request->userID;

        if (DB::table('lat_longs')->select('CI_ID')->where('CI_ID', $userID)->count() >= 1) {

            DB::table('lat_longs')
                ->where('CI_ID', $userID)
                ->update
                (
                    [
                        'Status' => 'Idle'
                    ]
                );
        }

        DB::table('online_user')
            ->where('user_id', $userID)
            ->delete();

    }

    public function logout()
    {
        $ses = Session();

        if (Auth::user() == null) {
            return redirect()->route('/');
        } else {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

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
                        'endorsement_id' => Auth::user()->id,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper($ses->get('role')),
                        'branch' => strtoupper($ses->get('userBranch')),
                        'activities' => strtoupper('Logged Out'),
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );

            $userID = Auth::user()->id;

            if (DB::table('lat_longs')->select('CI_ID')->where('CI_ID', $userID)->count() >= 1) {
                DB::table('lat_longs')
                    ->where('CI_ID', $userID)
                    ->update
                    (
                        [
                            'Status' => 'Offline',
                            'Last_Update' => $timeStamp,
                            'Time_Limit' => $timeStamp
                        ]
                    );
            }

            DB::table('online_user')
                ->where('user_id', $userID)
                ->delete();


            Auth::logout();

            $ses->flush();

            return redirect()->route('/');
        }

    }

    public function privilegeError()
    {
        return redirect()->route('dashboard-redirect');
    }

    public function LatLongUpdate()
    {
        //get latlong to database
        $getbrach = Auth::user()->branch;

        $getlatlong = DB::table('lat_longs')->select('CI_ID', 'CI_Name', 'Lat', 'Long', 'Status', 'Address', 'Last_Update')->get();
        return response()->json([$getlatlong, $getbrach]);
    }

    public function SaveSuggestion(Request $request)
    {
        $getuserID = Auth::user()->id;

        DB::table('suggestions')
            ->insert([
                'user_id' => $getuserID,
                'title' => $request->gettitle,
                'message' => $request->getmessage,
                'created_at' => Carbon::now('Asia/Manila')

            ]);


        if (Auth::user()->hasRole('Client')) {
            // EMAIL SYSTEM START HERE
            $emailSend = new EmailQueries();
            $emailSend->ClientIssueReport($request);
            // END OF EMAIL
        }

        return response()->json('done');
    }

    public function fetchCityMuni(Request $request)
    {
        $searchLetter = $request->term;
        $resultQs = Municipality::where('muni_name', 'like', '%' . $searchLetter . '%')
            ->select('id', 'province_id', 'muni_name')
            ->take(50)
            ->get();

        if (count($resultQs) == 0) {
            $resultTags[] = 'NO ITEM FOUND';
        } else {
            foreach ($resultQs as $resultQ) {
                $resultTags[] =
                    [
                        'originalMuniID' => $resultQ->id,
                        'muniID' => $resultQ->province_id,
                        'label' => $resultQ->muni_name,
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function fetchCityMuniv2(Request $request)
    {
        $searchLetter = $request->muniname;
        $resultQs = Municipality::where('muni_name', 'like', '%' . $searchLetter . '%')
            ->select('id', 'province_id', 'muni_name')
            ->take(50)
            ->get();

        return response()->json($resultQs);
    }

    public function fetchProvince(Request $request)
    {
        $province = DB::table('municipalities')
            ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
            ->where('provinces.id', $request->muniID)
            ->get();

        $rate = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->join('municipalities', 'municipalities.id', '=', 'rates.municipality_id')
            ->where('user_id', Auth::user()->id)
            ->where('municipality_id', $request->originalMuniID)
            ->select('rate')
            ->get();

        return response()->json([$province, $rate]);
    }

    public function fetchProvince2(Request $request)
    {
        $province = DB::table('municipalities')
            ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
            ->where('provinces.id', $request->muniID)
            ->get();

        return response()->json([$province]);
    }

    public function GetTorOtherEVR(Request $request)
    {

        $getinfo = DB::table('employers')
            ->select('employer_name', 'endorsement_id')
            ->where('endorsement_id', $request->id)
            ->get();

        return response()->json($getinfo);

    }

    public function GetTorOtherBVR(Request $request)
    {
        $getinfo = DB::table('businesses')
            ->select('business_name', 'endorsement_id')
            ->where('endorsement_id', $request->id)
            ->get();

        return response()->json($getinfo);
    }

    public function GetCI()
    {

        $credit_investigators = DB::table('role_user')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(['users.id', 'users.name'])
            ->where('role_id', 4)
            ->where('archive', 'false')
            ->get();

        return response()->json($credit_investigators);

    }

    public function GetCI_info(Request $request)
    {

        $credit_investigators = DB::table('users')
            ->join('provinces', 'provinces.id', '=', 'users.branch')
            ->select('provinces.name as branch_name', 'users.name as ci_name', 'users.email as ci_email', 'users.pix_path as ci_pics')
            ->where('users.id', $request->id)
            ->get();

//        $latlong = DB::table('lat_longs')
//            ->where('CI_ID', $request->id)
//            ->get();

        $latlong = DB::table('ci_login_trails')
            ->where('ci_id', $request->id)
            ->select([
                'Lat',
                'Long'
            ])
            ->orderByDesc('id')
            ->get();

        $getnumber = DB::table('ci_contacts')
            ->where('ci_id', $request->id)
            ->get();


        return response()->json([$credit_investigators, $latlong, $getnumber]);

    }

    public function get_ci_login_trail(Request $request)
    {
        $id = $request->ci_id;

        $get_ci_trail = DB::table('ci_login_trails')
            ->select
            ([
                'id',
                'lat',
                'long',
                'address_location',
                'user_agent',
                'user_ip',
                'type',
                'created_at',
                'updated_at',
                'photo_path',
            ])
            ->where('ci_id', $id);

        return DataTables::of($get_ci_trail)
            ->make(true);
//            ->get();

//        return response()->json($get_ci_trail);

    }

    public function Polls(Request $request)
    {
        $getquestions = DB::table('polls')
            ->get();

        $getpolls = DB::table('options')
            ->get();

        $getvotestocheck = DB::table('votes')
            ->where('user_id', Auth::user()->id)
            ->get();


        return response()->json([$getquestions, $getpolls, $getvotestocheck]);

    }

    public function AddPolls(Request $request)
    {

        DB::table('options')
            ->insert([
                'name' => $request->newPoll,
                'user_id' => Auth::user()->id,
                'poll_id' => $request->poll_id
            ]);

        $getopsid = DB::table('options')
            ->where('name', $request->newPoll)
            ->where('user_id', Auth::user()->id)
            ->select('id')
            ->get();


        DB::table('votes')
            ->insert([
                'user_id' => Auth::user()->id,
                'option_id' => $getopsid[0]->id,
                'poll_id' => $request->poll_id
            ]);

        return 'success';

    }

    public function VotePoll(Request $request)
    {

        $getarrays = $request->votePoll;
        foreach ($getarrays as $getvotes) {

            $getopsid = DB::table('options')
                ->where('name', $getvotes)
                ->select('id')
                ->get();


            DB::table('votes')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'option_id' => $getopsid[0]->id,
                    'poll_id' => $request->poll_id
                ]);
        }

        return 'success';
    }

    public function checkVotes(Request $request)
    {
        $getvotes = DB::table('votes')
            ->join('options', 'options.id', '=', 'votes.option_id')
            ->where('options.poll_id', $request->poll_id)
            ->Where('votes.user_id', Auth::user()->id)
            ->count();

        return response()->json($getvotes);
    }

    public function changePass(Request $request)
    {
        if (Hash::check($request->cp, Auth::user()->password)) {

            $if_validates = false;

            $old_passwords = DB::table('change_password_token')
                ->select(
                    [
                        'pass',
                        'one_password',
                        'two_password',
                        'three_password',
                        'four_password'
                    ])
                ->where('user_id', Auth::user()->id)
                ->get();

            $one = '';
            $two = '';
            $three = '';
            $four = '';

            if (count($old_passwords) == 0) {
                $if_validates = false;
            } else {
                $if_validates = true;
                $one = $old_passwords[0]->pass;
                $two = $old_passwords[0]->one_password;
                $three = $old_passwords[0]->two_password;
                $four = $old_passwords[0]->three_password;

            }

            $ready_to_proceed = false;


            if ($if_validates) {
                if ($old_passwords[0]->one_password == base64_encode($request->np) || $old_passwords[0]->two_password == base64_encode($request->np) || $old_passwords[0]->three_password == base64_encode($request->np) || $old_passwords[0]->four_password == base64_encode($request->np)) {
                    $ready_to_proceed = false;

                } else {
                    $ready_to_proceed = true;
                }
            } else {
                $ready_to_proceed = true;

            }


            if ($ready_to_proceed) {

                $check_id = DB::table('change_password_token')
                    ->select('id')
                    ->where('user_id', Auth::user()->id)
                    ->count();

                if ($check_id > 0) {
                    DB::table('change_password_token')
                        ->where('user_id', Auth::user()->id)
                        ->update([
                            'one_password' => $one,
                            'two_password' => $two,
                            'three_password' => $three,
                            'four_password' => $four,
                            'pass' => base64_encode($request->np),
                            'date_of_change' => Carbon::now('Asia/Manila')
                        ]);
                } else {
                    DB::table('change_password_token')
                        ->insert([

                            'user_id' => Auth::user()->id,
                            'pass' => base64_encode($request->np),
                            'date_of_change' => Carbon::now('Asia/Manila')

                        ]);
                }


                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update
                    (
                        [
                            'password' => bcrypt($request->np)
                        ]
                    );

                $ses = Session();
                Auth::logout();
                $ses->flush();
                return response()->json('success');
            } else {
                return response()->json('pass_same_recent');
            }

        } else {
            return response()->json('mismatch');
        }
    }

    public function getSessionInfo()
    {
        // Retrieve a piece of data from the session...
        if (preg_match('/TFS/', Auth::user()->name)) {
            $Fname = session('FName');
            $MName = session('MName');
            $LName = session('LName');
            $TOL = session('TOL');
            $TOR = session('TOR');
            $TOV = session('TOV');
            $Address = session('Address');
            $Muni = session('Muni');
            $MuniID = session('MuniID');
            $ProvID = session('ProvID');
            $Subjjectname = session('SubjectName');
            $DealerrName = session('DealerName');
            $ContracctNumber = session('ContractNumber');

            return \response()->json([$Fname, $MName, $LName, $TOL, $TOR, $TOV, $Address, $Muni, $MuniID, $ProvID, $Subjjectname, $DealerrName, $ContracctNumber, 'test']);
        } else {
            $Fname = session('FName');
            $MName = session('MName');
            $LName = session('LName');
            $TOL = session('TOL');
            $TOR = session('TOR');
            $TOV = session('TOV');
            $Address = session('Address');
            $Muni = session('Muni');
            $MuniID = session('MuniID');
            $ProvID = session('ProvID');
            $Subjjectname = session('SubjectName');

            return \response()->json([$Fname, $MName, $LName, $TOL, $TOR, $TOV, $Address, $Muni, $MuniID, $ProvID, $Subjjectname]);
        }

    }

    public function getDestroySession()
    {
        if (preg_match('/TFS/', Auth::user()->name)) {
            session()->forget('FName');
            session()->forget('MName');
            session()->forget('LName');
            session()->forget('TOL');
            session()->forget('TOR');
            session()->forget('TOV');
            session()->forget('Address');
            session()->forget('Muni');
            session()->forget('MuniID');
            session()->forget('ProvID');
            session()->forget('ProvID');
            session()->forget('SubjectName');
            session()->forget('DealerName');
            session()->forget('ContractNumber');
        } else {
            session()->forget('FName');
            session()->forget('MName');
            session()->forget('LName');
            session()->forget('TOL');
            session()->forget('TOR');
            session()->forget('TOV');
            session()->forget('Address');
            session()->forget('Muni');
            session()->forget('MuniID');
            session()->forget('ProvID');
            session()->forget('ProvID');
            session()->forget('SubjectName');
        }

    }

    public function fetchSubjForCoob(Request $request)
    {

        $searchLetter = $request->term;


        $resultQs = DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('endorsements.account_name', 'like', '%' . $searchLetter . '%')
            ->where('endorsement_user.user_id', Auth::user()->id)
            ->select('endorsements.account_name as names', 'endorsements.id as ids')
            ->take(10)
            ->get();

        $resultTags[] = '';
        $ctr = 0;

        if (count($resultQs) == 0) {
            $resultTags[] = 'NO SUBJECT FOUND';
        } else {
            foreach ($resultQs as $results) {
                $resultTags[] = [

                    'id' => $results->ids,
                    'label' => $results->names

                ];
//                if($ctr > 0)
//                {
//                    if($resultTags[($ctr-1)] == $results->names)
//                    {
//                        $ctr -=1;
//                    }
//                }
//
//                $resultTags[$ctr] = $results->names;
//                $ctr +=1;
            }
        }

        return response()->json($resultTags);

    }

    public function checkIfOffline()
    {
        if (Auth::user() == null) {
            Auth::logout();
            return response()->json('offline');
        } else {
            return 'do nothing';
        }
    }

    public function reqItReRep(Request $request)
    {
        $trimmer = new Trimmer();

        $decode = json_decode($request->form_data);
        $arrItemLst = count($decode);

//        return response()->json($decode[2]);

        if ($arrItemLst > 0) {

            $reqItemId = DB::table('item_requests')
                ->insertGetId
                (
                    [
                        'itmreq_datetime' => Carbon::now('Asia/Manila'),
                        'itmreq_requestor' => strtoupper($request->txtReqBy),
                        'itmreq_receiver' => strtoupper($trimmer->trims($request->txtItemReceiver)),
                        'itmreq_dept' => strtoupper($request->selCcsiDept),
                        'itmreq_branch' => strtoupper($request->selCcsiBranch)
                    ]
                );
            return response()->json($reqItemId);
        }
    }

    public function reqItemList(Request $request)
    {
        $trimmer = new Trimmer();
        $arrItemLst = count($request->txtItemName);

//        return response()->json($request);
        if ($arrItemLst > 0) {
            for ($b = 0; $b < $arrItemLst; $b++) {
//                if($request->txtItemName[$b]==null||$request->txtItemDesc[$b]==null||$request->selitemPurp[$b]==null||$request->txtItemQty[$b]==null)
//                {
//                    return response()->json('emptyError');
//                }
//                else
//                {
                DB::table('request_listitem')
                    ->insert
                    (
                        [
                            'item_request_id' => $request->id[0],
                            'item_name' => strtoupper($trimmer->trims($request->txtItemName[$b])),
                            'item_desc' => strtoupper($trimmer->trims($request->txtItemDesc[$b])),
                            'item_purp' => strtoupper($trimmer->trims($request->selItemPurp[$b])),
                            'item_qty' => $request->txtItemQty[$b],
                            'item_status' => 'Requested'
                        ]
                    );
//                }
            }
            return response()->json('Success');
        }
    }

    public function getReqListInfo()
    {
        $itmPurp = DB::table('item_purposes')
            ->select(['item_purpose'])
            ->get();

        $ccsiDept = DB::table('ccsi_departments')
            ->select(['dept_name'])
            ->get();

        $ccsiBranches = DB::table('ccsi_branches')
            ->select(['branch_name'])
            ->get();

        $requestor = strtoupper(Auth::user()->name);

        return response()->json([$itmPurp, $ccsiDept, $ccsiBranches, $requestor]);
    }


    //floyd

    public function fetchEdit(Request $request)
    {
        $province = DB::table('municipalities')
            ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
            ->select('provinces.name as name')
            ->where('provinces.id', $request->muniID)
            ->get();


        return \ response()->json($province);
    }

    public function fetchCityMuniEdit(Request $request)
    {
        $searchLetter = $request->term;
        $resultQs = Municipality::where('muni_name', 'like', '%' . $searchLetter . '%')
            ->select('id', 'province_id', 'muni_name')
            ->take(25)
            ->get();

        if (count($resultQs) == 0) {
            $resultTags[] = 'NO ITEM FOUND';
        } else {
            foreach ($resultQs as $resultQ) {
                $resultTags[] =
                    [
                        'originalMuniID' => $resultQ->id,
                        'muniID' => $resultQ->province_id,
                        'label' => $resultQ->muni_name,
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function bi_download_files_universal(Request $request)
    {
        $get_id = base64_decode($request->id);
        $path = '';
        $account = new bi_endorsement();
        $account = $account::find($get_id);
        $get_name = base64_decode($request->name);

        $attachment_place = '';

        if ($get_name == '1') {
            $attachment_place = $account->attach_1;
        } else if ($get_name == '2') {
            $attachment_place = $account->attach_2;

        } else if ($get_name == '3') {
            $attachment_place = $account->attach_3;

        } else if ($get_name == '4') {
            $attachment_place = $account->attach_4;
        }

        $path2 = utf8_encode(storage_path("bi_attachments/" . $account->bi_id . '/' . $get_id . '/' . $attachment_place));

        

        if(Auth::user()->client_check != 'cc_bank')
        {
            if(!File::exists($path2))
            {
                $getMainId = DB::table('bi_direct_pivot')
                    ->where('endorse_id', $get_id)
                    ->select('direct_to_get_id')
                    ->get();
    
                $path = utf8_encode(storage_path('direct_bi_attachment/14/'.$getMainId[0]->direct_to_get_id.'/'. $attachment_place));
            }
            else
            {
                $path = $path2;
            }
            
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            if(explode("/" ,$type)[0] == 'image' || $type == 'application/pdf')
            {
                return $response;
            }
            else
            {
                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $get_id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'DOWNLOADED ATTACHMENT ' . $get_name . ' : ' . $attachment_place;
                $logs->remarks = '-';
                $logs->save();

                return response()->download($path);
            }
        }
        else if(Auth::user()->client_check == 'cc_bank')
        {
            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $get_id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'DOWNLOADED ATTACHMENT ' . $get_name . ' : ' . $attachment_place;
            $logs->remarks = '-';
            $logs->save();

            return response()->download(utf8_encode(storage_path("bi_attachments/" . $account->bi_id . '/' . $get_id . '/' . str_replace("Ñ","N",$attachment_place))));
        }
    }
    
    public function bi_get_view_information(Request $request)
    {
        $getSiteName = DB::table('bi_account_to_users')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->select
            ([
                'bi_account_list.bi_account_name'
            ])
            ->where('bi_account_to_users.users_id', Auth::user()->id)
            ->get();

        if($request->check == 'direct_applicant')
        {
            $otherInfoArray = [];

            $getAllPersonal = DB::table('bi_direct_applicant_endorsement')
                ->join('bi_direct_pivot', 'bi_direct_pivot.direct_to_get_id', '=', 'bi_direct_applicant_endorsement.id')
                ->join('municipalities', 'municipalities.id', '=', 'bi_direct_applicant_endorsement.direct_present_muni')
                ->where('bi_direct_applicant_endorsement.id', $request->id)
                ->get();


            $get_child = DB::table('bi_direct_applicant_children')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_sib = DB::table('bi_direct_applicant_siblings')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_address = DB::table('bi_direct_applicant_addresses')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_exp = DB::table('bi_direct_applicant_experience')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_charac = DB::table('bi_direct_applicant_character')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_org = DB::table('bi_direct_applicant_organizations')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_trainings = DB::table('bi_direct_applicant_trainings')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $get_credit = DB::table('bi_direct_applicant_credit_card')
                ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                ->get();

            $otherInfoArray = [$getAllPersonal, $get_child, $get_sib, $get_address, $get_exp, $get_charac, $get_org, $get_trainings, $get_credit];


            $get_present_muni_prov = DB::table('municipalities')
                ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                ->select
                ([
                    'municipalities.muni_name as muni_name',
                    'provinces.name as prov_name'
                ])
                ->where('municipalities.id', $getAllPersonal[0]->direct_present_muni)
                ->get();

            $get_perma_muni_prov = DB::table('municipalities')
                ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                ->select
                ([
                    'municipalities.muni_name as muni_name',
                    'provinces.name as prov_name'
                ])
                ->where('municipalities.id', $getAllPersonal[0]->direct_perma_muni)
                ->get();

            $user_info = DB::table('users')
                ->where('id',Auth::user()->id)
                ->select('authrequest')
                ->get();

            if(count($user_info) == 0)
            {
                $user_info = '';
            }


            $getPivotId = DB::table('bi_direct_pivot')
                ->select('id')
                ->where('direct_to_get_id', $request->id)
                ->get();


            $getLogsForDirect = DB::table('bi_direct_application_logs')
                ->select
                ([
                    'activity',
                    'remarks',
                    'created_at',
                    'user_id as name'
                ])
                ->where('direct_piv_id', $getPivotId[0]->id)
                ->get();

            return response()->json(
                [
                    'direct_applicant',//0
                    '',//1
                    '',//2
                    '',//3
                    '',//4
                    '',//5
                    '',//6
                    '',//7
                    'tor' => '',//8
                    'tor_data' => '',//9
                    $otherInfoArray,//10
                    'auth_req' => $user_info[0]->authrequest,//11,
                    'pre_muni' => $get_present_muni_prov[0]->muni_name,
                    'pre_prov' => $get_present_muni_prov[0]->prov_name,
                    'per_muni' => $get_perma_muni_prov[0]->muni_name,
                    'per_prov' => $get_perma_muni_prov[0]->prov_name,
                    $getLogsForDirect,
                    $getSiteName

                ]);
        }
        else
        {
                $get_endorsement = DB::table('bi_endorsements')
                    ->leftjoin('bi_account_to_users', 'bi_account_to_users.bi_account_id', '=', 'bi_endorsements.bi_id')
                    ->leftjoin('users', 'users.id', '=', 'bi_account_to_users.users_id')
                    ->leftjoin('provinces as present_province', 'present_province.id', '=', 'bi_endorsements.present_province')
                    ->leftjoin('municipalities as present_muni', 'present_muni.id', '=', 'bi_endorsements.present_muni')
                    ->leftjoin('provinces as permanent_province', 'permanent_province.id', '=', 'bi_endorsements.permanent_province')
                    ->leftjoin('municipalities as permanent_muni', 'permanent_muni.id', '=', 'bi_endorsements.permanent_muni')
//            ->leftjoin('additional_files_from_bi as additional_files','additional_files.endorsement_id','=','bi_endorsements.id')
                    ->select([

                        'bi_endorsements.party_num as party_num',
                        'bi_endorsements.contract_num as contract_num',
                        'bi_endorsements.id as id',
                        'bi_endorsements.created_at as date_time_endorsed',
                        'bi_endorsements.date_time_due as date_time_due',
                        'bi_endorsements.bi_account_name as bi_account_name',
                        'bi_endorsements.project as project',
                        'bi_endorsements.lob as lob',
                        'bi_endorsements.package as package',
                        'bi_endorsements.account_name as account_name',
                        'bi_endorsements.f_name as f_name',
                        'bi_endorsements.l_name as l_name',
                        'bi_endorsements.m_name as m_name',
                        'bi_endorsements.suffix as suffix',
                        'bi_endorsements.gender as gender',
                        'bi_endorsements.marital_status as marital_status',
                        'bi_endorsements.birth_day as birth_day',
                        'bi_endorsements.birth_month as birth_month',
                        'bi_endorsements.birth_year as birth_year',
                        'bi_endorsements.age as age',
                        'bi_endorsements.citizenship as citizenship',
                        'bi_endorsements.maiden_name as maiden_name',
                        'bi_endorsements.type_of_tat as type_of_tat',
                        'bi_endorsements.present_address as present_address',
                        'present_province.name as present_province',
                        'present_muni.muni_name as present_muni',
                        'bi_endorsements.permanent_address as permanent_address',
                        'permanent_province.name as permanent_province',
                        'permanent_muni.muni_name as permanent_muni',
                        'bi_endorsements.endorser_poc as endorser_poc',
                        'bi_endorsements.status as status',
                        'bi_endorsements.attach_1 as attach_1',
                        'bi_endorsements.attach_2 as attach_2',
                        'bi_endorsements.attach_3 as attach_3',
                        'bi_endorsements.attach_4 as attach_4',
                        'users.client_check as client_type',
//                'additional_files.file_names as other_files',
//                'additional_files.created_at as additional_files_date_time'
                        'bi_endorsements.type_of_endorsement_bank as type_of_request',
                        'bi_endorsements.priority_type_bank as type_of_endo',
                        'bi_endorsements.loan_type_bank as loan_type_bank',
                        'bi_endorsements.verify_through_bank as verify_through_bank',
                        'bi_endorsements.cc_bank_endorsement_type as cc_bank_endorsement_type',
                        'bi_endorsements.direct_apply_status as direct_apply'
                    ])
                    ->where('bi_endorsements.id', $request->id)
                    ->get();

                $get_checkings = DB::table('bi_endorsements_checkings')
                    ->select('checking_name', 'type_check')
                    ->where('bi_endorsement_id', $request->id)
                    ->get();

                $get_logs = DB::table('bi_logs')
                    ->leftjoin('bi_endorsements', 'bi_endorsements.id', '=', 'bi_logs.endorse_id')
                    ->leftjoin('users', 'users.id', '=', 'bi_logs.user_id')
                    ->leftjoin('roles', 'roles.id', '=', 'bi_logs.position_id')
                    ->select([
                        'users.name as user_name',
                        'roles.name as position_name',
                        'bi_logs.activity as activity',
                        'bi_logs.remarks as remarks',
                        'bi_logs.created_at as date_time',
                        'bi_endorsements.type_of_endorsement_bank as type_of_request',
                    ])
                    ->where('bi_endorsements.id', $request->id)
                    ->get();
                    
                if(count($get_logs) > 0)
                {
                   if ($get_logs[0]->type_of_request == 'PDRN') {
                    $get_tor = DB::table('bi_endorsement_cob_pdrn')
                        ->join('municipalities as present_m', 'present_m.id', '=', 'bi_endorsement_cob_pdrn.present_muni')
                        ->join('provinces as present_p', 'present_p.id', '=', 'bi_endorsement_cob_pdrn.present_prov')
                        ->join('municipalities as perma_m', 'perma_m.id', '=', 'bi_endorsement_cob_pdrn.present_muni')
                        ->join('provinces as perma_p', 'perma_p.id', '=', 'bi_endorsement_cob_pdrn.present_prov')
                        ->select([
                            'bi_endorsement_cob_pdrn.f_name as first_name',
                            'bi_endorsement_cob_pdrn.m_name as middle_name',
                            'bi_endorsement_cob_pdrn.l_name as last_name',
                            'bi_endorsement_cob_pdrn.present_address as pre_address',
                            'present_m.muni_name as pre_muni',
                            'present_p.name as pre_prov',
                            'bi_endorsement_cob_pdrn.perma_address as perma_address',
                            'perma_m.muni_name as perma_muni',
                            'perma_p.name as perma_prov',
                            'bi_endorsement_cob_pdrn.relationship_subject as relation',
                            'bi_endorsement_cob_pdrn.other_relationship_subject as other_relation'
                        ])
                        ->where('bi_endorsement_cob_pdrn.bi_id', $request->id)
                        ->get();
                    } else if ($get_logs[0]->type_of_request == 'BVR') {
                        $get_tor = DB::table('bi_endorsement_bvr_business')
                            ->join('municipalities', 'municipalities.id', '=', 'bi_endorsement_bvr_business.business_muni')
                            ->join('provinces', 'provinces.id', '=', 'bi_endorsement_bvr_business.business_prov')
                            ->select([
                                'bi_endorsement_bvr_business.business_name as name',
                                'bi_endorsement_bvr_business.business_address as address',
                                'municipalities.muni_name as muni',
                                'provinces.name as prov'
                            ])
                            ->where('bi_endorsement_bvr_business.bi_id', $request->id)
                            ->get();
                    } else if ($get_logs[0]->type_of_request == 'EVR') {
                        $get_tor = DB::table('bi_endorsement_evr_employer')
                            ->join('municipalities', 'municipalities.id', '=', 'bi_endorsement_evr_employer.emp_muni')
                            ->join('provinces', 'provinces.id', '=', 'bi_endorsement_evr_employer.emp_prov')
                            ->select([
                                'bi_endorsement_evr_employer.emp_name as name',
                                'bi_endorsement_evr_employer.emp_address as address',
    
                                'municipalities.muni_name as muni',
                                'provinces.name as prov'
                            ])
                            ->where('bi_endorsement_evr_employer.bi_id', $request->id)
                            ->get();
                    } else if ($get_logs[0]->type_of_request == '') {
                        $get_tor = 'none';
                    } else {
                        $get_tor = 'none';
                    } 
                }
                else
                {
                    $get_tor = 'none';
                }

                

                $get_other_address = DB::table("bi_endorsement_other_address")
                    ->leftjoin('municipalities', 'municipalities.id', '=', 'bi_endorsement_other_address.muni_id')
                    ->leftjoin('provinces', 'provinces.id', '=', 'bi_endorsement_other_address.province_id')
                    ->select([
                        'bi_endorsement_other_address.address as address',
                        'municipalities.muni_name as muni_name',
                        'provinces.name as prov_name',
                        'bi_endorsement_other_address.bi_id as bi_id'
                    ])
                    ->where('bi_id', $request->id)
                    ->get();

                $get_add_files = DB::table('additional_files_from_bi')
                    ->leftjoin('bi_endorsements', 'bi_endorsements.id', '=', 'additional_files_from_bi.endorsement_id')
                    ->select([
                        'additional_files_from_bi.id as id',
                        'additional_files_from_bi.endorsement_id as endo_id',
                        'additional_files_from_bi.type_of_return as type_return',
                        'additional_files_from_bi.bi_id as bi_id',
                        'additional_files_from_bi.file_names as file',
                        'additional_files_from_bi.created_at as date_time',
                        'additional_files_from_bi.bi_add_rem as rem'
                    ])
                    ->where('additional_files_from_bi.endorsement_id', $request->id)
                    ->get();


                if (count($get_other_address) == 0) {
                    $get_other_address = '-';
                }

                $getType = DB::table('bi_logs')
                    ->where('endorse_id', $request->id)
                    ->where('type', 'require_doc')
                    ->orderBy('id', 'desc')
                    ->get();


                $otherInfoArray = [];

                if($get_endorsement[0]->direct_apply == 'direct')
                {
                    $getAllPersonal = DB::table('bi_direct_applicant_endorsement')
                        ->join('bi_direct_pivot', 'bi_direct_pivot.direct_to_get_id', '=', 'bi_direct_applicant_endorsement.id')
                        ->where('bi_direct_pivot.endorse_id', $request->id)
                        ->get();


                    $get_child = DB::table('bi_direct_applicant_children')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_sib = DB::table('bi_direct_applicant_siblings')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_address = DB::table('bi_direct_applicant_addresses')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_exp = DB::table('bi_direct_applicant_experience')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_charac = DB::table('bi_direct_applicant_character')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_org = DB::table('bi_direct_applicant_organizations')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_trainings = DB::table('bi_direct_applicant_trainings')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();

                    $get_credit = DB::table('bi_direct_applicant_credit_card')
                        ->where('direct_id', $getAllPersonal[0]->direct_to_get_id)
                        ->get();


                    $getAddresses =  DB::table('bi_endorsements')
                        ->select('present_muni', 'present_province', 'permanent_muni', 'permanent_province')
                        ->where('id', $request->id)
                        ->get();

                     $getPresentBaliktad = DB::table('municipalities')
                         ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                         ->select
                         ([
                             'municipalities.muni_name as muni_name',
                             'provinces.name as prov_name'
                         ])
                         ->where('municipalities.id', $getAddresses[0]->present_muni)
                         ->get();

                     $getPermaBaliktad =  DB::table('municipalities')
                         ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                         ->select
                         ([
                             'municipalities.muni_name as muni_name',
                             'provinces.name as prov_name'
                         ])
                         ->where('municipalities.id', $getAddresses[0]->permanent_muni)
                         ->get();

                    $otherInfoArray = [$getAllPersonal, $get_child, $get_sib, $get_address, $get_exp, $get_charac, $get_org, $get_trainings, $get_credit, $getPresentBaliktad, $getPermaBaliktad];

                }

                $user_info = DB::table('users')
                    ->where('id',Auth::user()->id)
                    ->select('authrequest')
                    ->get();

                if(count($user_info) == 0)
                {
                    $user_info = '';
                }

                return response()->json(
                    [
                        $get_endorsement, //0
                        $get_checkings,//1
                        $get_logs,//2
                        $get_other_address,//3
                        $get_add_files,//4
                        Auth::user()->roles,//5
                        count($getType),//6
                        $getType,//7
                        'tor' => $get_tor,//8
                        'tor_data' => $get_tor,//9
                        $otherInfoArray,//10
                        'auth_req' => $user_info[0]->authrequest,
                        $getSiteName//11
                    ]);

        }
    }

    public function change_dp(Request $request)
    {
        $ses = Session();
        $file = $request->file('file');

        if ($file != null || $file != '') {
            if ($file->getClientMimeType() === 'image/jpeg' || $file->getClientMimeType() === 'image/png') {
                $now = Carbon::now('Asia/Manila');
                $now = preg_replace('/[-: ]+/', '', $now);

                $asdasd = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->select('pix_path')
                    ->get();

                if ($file != null) {
                    $file->move(public_path('/avatar/'), $now . '.' . $file->getClientOriginalExtension());
                } else {
                    return 'no file';
                }

                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(
                        [
                            'pix_path' => 'avatar/' . $now . '.' . $file->getClientOriginalExtension()
                        ]
                    );

                File::delete(public_path($asdasd[0]->pix_path));

                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

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
                            'endorsement_id' => 0,
                            'name' => strtoupper(Auth::user()->name),
                            'position' => strtoupper($ses->get('role')),
                            'branch' => strtoupper($ses->get('userBranch')),
                            'activities' => 'UPDATED HIS/HER DISPLAY ICON/IMAGE',
                            'date_occured' => $date,
                            'time_occured' => $time
                        ]
                    );

                return 'ok';
            } else {
                return 'not match';
            }
        } else {
            return 'no file';
        }
    }

    public function bi_view_info_dl(Request $request)
    {
        $trims = new Trimmer();
        $rawData = explode('|', $request->id);

        $decoded_id = base64_decode($rawData[0]);
        $path = base64_decode($rawData[1]);

        $user = User::find(Auth::user()->id);
        $logs = new bi_log();
        $logs->endorse_id = $decoded_id;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'FILE DOWNLOADED ' . $trims->trims($path);
        $logs->remarks = '-';
        $logs->save();

        return response()->download(storage_path('/additional_files_bi/' . $decoded_id . '/' . $path));

    }

    public function general_check_role_logout()
    {
        return response()->json(['role' => Auth::user()->hasRole('Admin Staff')]);
    }

    public function bi_direct_encoded_account(Request $request)
    {
        $scrippTrim = new ScriptTrimmer();
        $eme_ctr = 0;
        $char_ctr = 0;
        $emp_ctr = 0;

        $getBIid = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->select([
                'bi_account_to_users.bi_account_id as bi_id'
            ])
            ->where('users.id', Auth::user()->id)
            ->where('bi_account_to_users.to_display', 'display')
            ->get();

        $encoded_id = DB::table('bi_direct_encoded_data')
            ->insertGetId([
                'bi_id' => $getBIid[0]->bi_id,
                'accnt_fname' => $scrippTrim->scripttrim($request->accnt_fname),
                'accnt_surname' => $scrippTrim->scripttrim($request->accnt_surname),
                'accnt_mname' => $scrippTrim->scripttrim($request->accnt_mname),
                'accnt_suffix' => $scrippTrim->scripttrim($request->accnt_suffix),
                'accnt_civil_status' => $scrippTrim->scripttrim($request->accnt_civil_status),
                'accnt_gender' => $scrippTrim->scripttrim($request->accnt_gender),
                'accnt_bday' => $scrippTrim->scripttrim($request->accnt_bday),
                'accnt_age' => $scrippTrim->scripttrim($request->accnt_age),
                'accnt_present_add' => $scrippTrim->scripttrim($request->accnt_present_add),
                'accnt_present_mun_id' => $scrippTrim->scripttrim($request->accnt_present_mun_id),
                'accnt_present_prov_id' => $scrippTrim->scripttrim($request->accnt_present_prov_id),
                'accnt_permanent_add' => $scrippTrim->scripttrim($request->accnt_permanent_add),
                'accnt_permanent_mun_id' => $scrippTrim->scripttrim($request->accnt_permanent_mun_id),
                'accnt_permanent_prov_id' => $scrippTrim->scripttrim($request->accnt_permanent_prov_id),
                'status' => '0',
//                'type_of_tat' => '-',
                'created_at' => Carbon::now('Asia/Manila')
            ]);


        // EMERGENCY CONTACT PERSON

        if (count($request->eme_data) != 0) {
            for ($eme_ctr = 0; $eme_ctr < count($request->eme_data); $eme_ctr++) {
                DB::table('bi_direct_endorsement_contact_person')
                    ->insert([
                        'encode_id' => $encoded_id,
                        'data' => $request->eme_data[$eme_ctr][0],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }


        // CHARACTER REFERENCE
        if (count($request->char_data) != 0) {
            for ($char_ctr = 0; $char_ctr < count($request->char_data); $char_ctr++) {
                DB::table('bi_direct_endorsement_character_reference')
                    ->insert([
                        'encode_id' => $encoded_id,
                        'data' => $request->char_data[$char_ctr][0],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }


        // EMPLOYMENT HISTORY
        if (count($request->emp_data) != 0) {
            for ($emp_ctr = 0; $emp_ctr < count($request->emp_data); $emp_ctr++) {
                DB::table('bi_direct_endorsement_employment_history')
                    ->insert([
                        'encode_id' => $encoded_id,
                        'data' => $request->emp_data[$emp_ctr][0],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        DB::table('bi_direct_pivot')
            ->insert
            ([
                'bi_id' => $getBIid[0]->bi_id,
                'direct_to_get_id' => $encoded_id,
                'direct_name' => strtoupper($request->accnt_surname . ', ' . $request->accnt_fname . ' ' . $request->accnt_mname),
                'direct_type' => 'Concentrix',
                'direct_status' => '0',
                'created_at' => Carbon::now('Asia/Manila')
            ]);


        return response()->json(['ok', $encoded_id]);
    }

    public function bi_direct_encoded_account_upload(Request $request)
    {
        $file1 = $request->file('file_1');
        $file2 = $request->file('file_2');
        $file3 = $request->file('file_3');
        $file4 = $request->file('file_4');
        $attach1 = '';
        $attach2 = '';
        $attach3 = '';
        $attach4 = '';

        $OrigfileName = DB::table('bi_direct_encoded_data')
            ->where('id', $request->id)
            ->select([
                    'bi_direct_encoded_data.attach1 as fil1', 'bi_direct_encoded_data.attach2 as fil2', 'bi_direct_encoded_data.attach3 as fil3', 'bi_direct_encoded_data.attach4 as fil4']
            )
            ->get();

        $getBIid = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->select([
                'bi_account_to_users.bi_account_id as bi_id'
            ])
            ->where('users.id', Auth::user()->id)
            ->where('bi_account_to_users.to_display', 'display')
            ->get();


        $count = 1;

        if ($file1 != null) {
            $file_name1 = $file1->getClientOriginalName();

            if ($file_name1 == $OrigfileName[0]->fil2) {
                $count++;
                $file_name1 = explode('.', $file1->getClientOriginalName())[0] . '(' . $count . ').' . $file1->getClientOriginalExtension();
            }

            if ($file_name1 == $OrigfileName[0]->fil3) {
                $count++;
                $file_name1 = explode('.', $file1->getClientOriginalName())[0] . '(' . $count . ').' . $file1->getClientOriginalExtension();
            }

            if ($file_name1 == $OrigfileName[0]->fil4) {
                $count++;
                $file_name1 = explode('.', $file1->getClientOriginalName())[0] . '(' . $count . ').' . $file1->getClientOriginalExtension();
            }

            $file1->move(storage_path('bi_attachments_direct/' . $getBIid[0]->bi_id . '/' . $request->id . '/'), $file_name1);

            $attach1 = $file_name1;
        }

        if ($file2 != null) {
            $file_name2 = $file2->getClientOriginalName();

            if ($file_name2 == $OrigfileName[0]->fil1) {
                $count++;
                $file_name2 = explode('.', $file2->getClientOriginalName())[0] . '(' . $count . ').' . $file2->getClientOriginalExtension();
            }

            if ($file_name2 == $OrigfileName[0]->fil3) {
                $count++;
                $file_name2 = explode('.', $file2->getClientOriginalName())[0] . '(' . $count . ').' . $file2->getClientOriginalExtension();
            }

            if ($file_name2 == $OrigfileName[0]->fil4) {
                $count++;
                $file_name2 = explode('.', $file2->getClientOriginalName())[0] . '(' . $count . ').' . $file2->getClientOriginalExtension();
            }

            $file2->move(storage_path('bi_attachments_direct/' . $getBIid[0]->bi_id . '/' . $request->id . '/'), $file_name2);

            $attach2 = $file_name2;
        }

        if ($file3 != null) {
            $file_name3 = $file3->getClientOriginalName();

            if ($file_name3 == $OrigfileName[0]->fil1) {
                $count++;
                $file_name3 = explode('.', $file3->getClientOriginalName())[0] . '(' . $count . ').' . $file3->getClientOriginalExtension();
            }

            if ($file_name3 == $OrigfileName[0]->fil2) {
                $count++;
                $file_name3 = explode('.', $file3->getClientOriginalName())[0] . '(' . $count . ').' . $file3->getClientOriginalExtension();
            }

            if ($file_name3 == $OrigfileName[0]->fil4) {
                $count++;
                $file_name3 = explode('.', $file3->getClientOriginalName())[0] . '(' . $count . ').' . $file3->getClientOriginalExtension();
            }

            $file3->move(storage_path('bi_attachments_direct/' . $getBIid[0]->bi_id . '/' . $request->id . '/'), $file_name3);

            $attach3 = $file_name3;
        }

        if ($file4 != null) {
            $file_name4 = $file4->getClientOriginalName();

            if ($file_name4 == $OrigfileName[0]->fil1) {
                $count++;
                $file_name4 = explode('.', $file4->getClientOriginalName())[0] . '(' . $count . ').' . $file4->getClientOriginalExtension();
            }

            if ($file_name4 == $OrigfileName[0]->fil2) {
                $count++;
                $file_name4 = explode('.', $file4->getClientOriginalName())[0] . '(' . $count . ').' . $file4->getClientOriginalExtension();
            }

            if ($file_name4 == $OrigfileName[0]->fil3) {
                $count++;
                $file_name4 = explode('.', $file4->getClientOriginalName())[0] . '(' . $count . ').' . $file4->getClientOriginalExtension();
            }

            $file4->move(storage_path('bi_attachments_direct/' . $getBIid[0]->bi_id . '/' . $request->id . '/'), $file_name4);

            $attach3 = $file_name4;
        }

        DB::table('bi_direct_encoded_data')
            ->where('id', $request->id)
            ->update([
                'attach1' => $attach1,
                'attach2' => $attach2,
                'attach3' => $attach3,
                'attach4' => $attach4,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function view_account_transaction(Request $request)
    {
        $getEndo = DB::table('bi_endorsements')
            ->leftjoin('bi_endorsements_transaction_id', 'bi_endorsements_transaction_id.endorsement_id', '=', 'bi_endorsements.id')
            ->join('municipalities', 'municipalities.id', '=', 'bi_endorsements.present_muni')
            ->where('bi_endorsements_transaction_id.transaction_id', $request->tn)
            ->select([
                'bi_endorsements.id as id',
                'bi_endorsements.status as status',
                'bi_endorsements.account_name as account_name',
                'municipalities.muni_name as muni_name',
                'bi_endorsements.present_address as address',
//                'bi_endorsements.account_name as account_name',
            ])
            ->get();

        $getEndoBank = DB::table('endorsements')
            ->leftJoin('endorsements_transaction_tracking', 'endorsements_transaction_tracking.endorsement_id', 'endorsements.id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->where('endorsements_transaction_tracking.transaction_id', $request->tn)
            ->select([
                'endorsements.id as id',
                'endorsements.account_name as account_name',
                'endorsements.type_of_request as type_of_request',
                'endorsements.type_of_loan as type_of_loan',
                'endorsements.address as address',
                'endorsements.paypal_tr_id as paypal_tr_id',
                'municipalities.muni_name as muni_name',
                'endorsements.date_forwarded_to_client as date_forwarded_to_client'
            ])
            ->get();

        if (count($getEndo) > 0) {
            return response()->json([$getEndo, base64_encode(gzdeflate($getEndo[0]->id)), 'bi']);
        }
        if (count($getEndoBank) > 0) {
            return response()->json([$getEndoBank, base64_encode(gzdeflate($getEndoBank[0]->id)), 'bank']);
        }
    }

    public function general_send_requisition_to_admin(Request $request)
    {
        $checks = $request->myData;
        $items = $request->dataBrand;

        $getId = DB::table('admin_requisition')
            ->insertGetId
            ([
                'user_id' => Auth::user()->id,
                'req_reason' => $request->radioCheck,
                'req_reason_remarks' => $request->reqRemarksReason,
                'date_request' => $request->dateRequested,
                'requestor_name' => $request->reqName,
                'office_loc_dep_pos' => $request->officeLoc,
                'date_needed' => $request->dateNeeded,
                'approved_by' => $request->approvedBy,
                'approval_date' => $request->approvalDate,
                'other_check_0' => $request->otherCheck1,
                'other_check_1' => $request->otherCheck2,
                'other_check_2' => $request->otherCheck3,
                'items_grand_total' => $request->totalAmountRequi,
                'requested_for' => $request->requestedRequiFor,
                'requested_for_id' => $request->requestedRequiForID,
                'out_status' => 'Pending',
                'request_status' => 'Pending',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        for ($i = 0; $i < count($checks); $i++) {
            DB::table('admin_requisition_checks')
                ->insert
                ([
                    'request_id' => $getId,
                    'check_name' => $checks[$i],
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }

        for ($p = 0; $p < count($items); $p++) {
            DB::table('admin_requisition_items')
                ->insert
                ([
                    'request_id' => $getId,
                    'brand_item_desc' => $items[$p][0],
                    'item_quantity' => $items[$p][1],
                    'item_unit_price' => $items[$p][2],
                    'total_amount' => $items[$p][3],
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }

        $getSendIds = DB::table('users')
            ->select('email')
            ->where('requi_check', 'Granted')
            ->where('archive', 'false')
            ->get();

        $emailSend = new EmailQueries();
        $emailSend->sendEmailApproverManageReq($request, $getSendIds, $getId, 'toManage');
    }

    public function general_get_user_name()
    {
        return response()->json(Auth::user()->name);
    }

    public function fetchHRNames(Request $request)
    {
        $searchLetter = $request->term;

        $resultNames = DB::table('users_profile')
            ->join('users_atm', 'users_atm.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'users_atm.emp_id_no as id'
            ])
            ->where('users_profile.emp_full_name', 'like', '%' . $searchLetter . '%')
            ->take(50)
            ->get();


        if (count($resultNames) == 0) {
            $resultTags[] = 'NO RECORD';
        } else {
            foreach ($resultNames as $resultName) {
                $resultTags[] =
                    [
                        'id' => $resultName->id,
                        'label' => $resultName->name,
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function fetchHRID(Request $request)
    {
        $searchLetter = $request->term;

        $resultNames = DB::table('users_profile')
            ->join('users_atm', 'users_atm.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.emp_full_name as name',
                'users_atm.emp_id_no as id'
            ])
            ->where('users_atm.emp_id_no', 'like', '%' . $searchLetter . '%')
            ->take(50)
            ->get();


        if (count($resultNames) == 0) {
            $resultTags[] = 'NO RECORD';
        } else {
            foreach ($resultNames as $resultName) {
                $resultTags[] =
                    [
                        'label' => $resultName->id,
                        'name' => $resultName->name,
                    ];
            }
        }
        return response()->json($resultTags);
    }

    public function gen_approve_requi_approver(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->select('requestor_name', 'requested_for_id', 'office_loc_dep_pos', 'user_id', 'date_request', 'req_reason_remarks', 'date_needed', 'req_reason')
            ->where('id', $request->id)
            ->get();

        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'out_status' => 'Approved',
                'main_approver_date_approved' => Carbon::now('Asia/Manila'),
                'main_approver_id' => Auth::user()->id,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $getSendIds = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email')
            ->where('role_user.role_id', 12)
            ->where('users.archive', 'false')
            ->get();


        $logs = new AuditQueries();
//
        $logs->assign_items('Received a request from ' . $getData[0]->requestor_name . ' for an employee with ID no. ' . $getData[0]->requested_for_id . ' (' . $getData[0]->office_loc_dep_pos . ')', '', '', $getData[0]->user_id, '');

        $emailSend = new EmailQueries();
        $emailSend->sendEmailApproverManageReq($getData, $getSendIds, $request->id, 'toAdmin');
    }

    public function gen_requi_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date'
            ])
            ->where('admin_requisition.out_status', 'Pending');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_requi_table_approved()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->join('users as app_id', 'app_id.id', '=', 'admin_requisition.main_approver_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date',
                'app_id.name as app_name'
            ])
            ->where('admin_requisition.out_status', 'Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_requi_table_denied()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->join('users as app_id', 'app_id.id', '=', 'admin_requisition.main_approver_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date',
                'admin_requisition.main_approver_remarks as rem',
                'admin_requisition.main_approver_date_denied as dtDenied',
                'app_id.name as app_name'
            ])
            ->where('admin_requisition.out_status', 'Denied');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_deny_requi(Request $request)
    {
        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'out_status' => 'Denied',
                'main_approver_date_denied' => Carbon::now('Asia/Manila'),
                'main_approver_id' => Auth::user()->id,
                'main_approver_remarks' => $request->remarks,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function generate_excel_attendance_ci(Request $request)
    {
        if (Auth::user() != null) {
            $zipper = new Zipper();
            $get_path = [];
            $ci_attendance = [];
            $now = Carbon::now('Asia/Manila');
            $eks = explode(' ', $now);
            $start = $request->start;
            $end = $request->end;
            $multiVar = 0;
            $ii = 0;
            $ctrPath = 0;
            $to_rar_array = [];

            if (File::exists(storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . ''))) {
                File::deleteDirectory(storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . ''));
            }

            $users = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('provinces', 'provinces.id', '=', 'users.branch')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
                ->where('role_user.role_id', 4)
                ->where('users.archive', 'False')
                ->select([
                    'users.id as id',
                    'users.name as name',
                    'provinces.name as branch',
                    'regions.region_name as region',
                    'archipelagos.archipelago_name as archi'
                ])
                ->get();

            if (count($users) > 0) {
                for ($i = 0; $i < count($users); $i++) {
                    $ci_attendance[$i] = [];
                    $getAttendance = DB::table('ci_login_trails')
                        ->leftjoin('users', 'users.id', '=', 'ci_login_trails.ci_id')// LEFTJOIN KASI MAY MGA 0 ANG ci_id
                        ->where('ci_login_trails.type', '=', 'Attendance')
                        ->where('ci_login_trails.ci_id', $users[$i]->id)
                        ->where('ci_login_trails.created_at', '>=', $start . ' 00:00:00')
                        ->where('ci_login_trails.created_at', '<=', $end . ' 23:59:59')
                        ->select([
                            'users.name as ci_name',
                            'ci_login_trails.created_at as attendance',
                            'ci_login_trails.photo_path as path'
                        ])
                        ->orderBy('ci_login_trails.id', 'desc')
                        ->get();

                    if (count($getAttendance) >= 2) {
                        $get_path[$ctrPath] = [];


                        for($multiVar = 0; $multiVar < count($getAttendance); $multiVar++)
                        {
//                            $ci_attendance[$i][$multiVar]['id'] = $users[$i]->id;
//                            $ci_attendance[$i][$multiVar]['ci_name'] = $users[$i]->name;
//                            $ci_attendance[$i][$multiVar]['attendance'] = $getAttendance[$multiVar]->attendance;
//                            $ci_attendance[$i][$multiVar]['branch'] = $users[$i]->branch;
//                            $ci_attendance[$i][$multiVar]['region'] = $users[$i]->region;
//                            $ci_attendance[$i][$multiVar]['archipelago'] = $users[$i]->archi;
//                            $ci_attendance[$i][$multiVar]['path'] = $getAttendance[$multiVar]->path;


                            $get_path[$ctrPath][0] = $users[$i]->name;
                            $get_path[$ctrPath][1] = $getAttendance[$multiVar]->path;
                            $get_path[$ctrPath][2] = $users[$i]->id;

                            $ctrPath++;
                        }

                    }
                    else if(count($getAttendance) > 0)
                    {
//                        $ci_attendance[$i][0]['id'] = $users[$i]->id;
//                        $ci_attendance[$i][0]['ci_name'] = $users[$i]->name;
//                        $ci_attendance[$i][0]['attendance'] = $getAttendance[0]->attendance;
//                        $ci_attendance[$i][0]['branch'] = $users[$i]->branch;
//                        $ci_attendance[$i][0]['region'] = $users[$i]->region;
//                        $ci_attendance[$i][0]['archipelago'] = $users[$i]->archi;
//                        $ci_attendance[$i][0]['path'] = $getAttendance[0]->path;


                        $get_path[$ctrPath][0] = $users[$i]->name;
                        $get_path[$ctrPath][1] = $getAttendance[0]->path;
                        $get_path[$ctrPath][2] = $users[$i]->id;

                        $ctrPath++;

                    }
                    else
                    {
//                        $ci_attendance[$i][0]['id'] = $users[$i]->id;
//                        $ci_attendance[$i][0]['ci_name'] = $users[$i]->name;
//                        $ci_attendance[$i][0]['attendance'] = 'No Record';
//                        $ci_attendance[$i][0]['branch'] = $users[$i]->branch;
//                        $ci_attendance[$i][0]['region'] = $users[$i]->region;
//                        $ci_attendance[$i][0]['archipelago'] = $users[$i]->archi;
//                        $ci_attendance[$i][0]['path'] = null;

                    }

                }
            }

            if (count($get_path) > 0) {
                for ($fn = 0; $fn < count($get_path); $fn++) {
                    $path = storage_path($get_path[$fn][1]);


                    if (File::exists($path)) {
                        $filecount = glob("$path/*");

                        $zipper->make(storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . '' . '/' . $get_path[$fn][0]) . '.zip')
                            ->add($filecount);
                    }
                }
                $zipper->close();
            }


            return 'go';
        } else {
            abort(404);
        }
    }

    public function generate_excel_attendance_ci_2(Request $request)
    {
        if (Auth::user() != null) {
            $zipper = new Zipper();
            $get_path = [];
            $ci_attendance = [];
            $now = Carbon::now('Asia/Manila');
            $eks = explode(' ', $now);
            $start = $request->start;
            $end = $request->end;
            $multiVar = 0;
            $ii = 0;
            $ctrPath = 0;
            $to_rar_array = [];

            $users = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('provinces', 'provinces.id', '=', 'users.branch')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
                ->where('role_user.role_id', 4)
                ->where('users.archive', 'False')
                ->select([
                    'users.id as id',
                    'users.name as name',
                    'provinces.name as branch',
                    'regions.region_name as region',
                    'archipelagos.archipelago_name as archi'
                ])
                ->get();

            if (count($users) > 0) {
                for ($i = 0; $i < count($users); $i++) {
                    $ci_attendance[$i] = [];
                    $getAttendance = DB::table('ci_login_trails')
                        ->leftjoin('users', 'users.id', '=', 'ci_login_trails.ci_id')// LEFTJOIN KASI MAY MGA 0 ANG ci_id
                        ->where('ci_login_trails.type', '=', 'Attendance')
                        ->where('ci_login_trails.ci_id', $users[$i]->id)
                        ->where('ci_login_trails.created_at', '>=', $start . ' 00:00:00')
                        ->where('ci_login_trails.created_at', '<=', $end . ' 23:59:59')
                        ->select([
                            'users.name as ci_name',
                            'ci_login_trails.created_at as attendance',
                            'ci_login_trails.photo_path as path',
                            'ci_login_trails.created_at as date',
                        ])
                        ->orderBy('ci_login_trails.id', 'desc')
                        ->get();


//                    return response()->json([$get_check_first_report,$getAttendance]);


                    if(count($getAttendance) >= 2)
                    {
                        $get_path[$ctrPath] = [];

                        for($multiVar = 0; $multiVar < count($getAttendance); $multiVar++)
                        {

                            $get_check_first_report = DB::table('users')
                                ->join('endorsement_user','endorsement_user.user_id','=','users.id')
                                ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                                ->select([
                                    'users.name as name',
                                    'endorsements.date_ci_forwarded as date_forwarded',
                                    'endorsements.id as endo_id',
                                    'endorsements.time_ci_forwarded as time_forwarded'
                                ])
                                ->where('users.id',$users[$i]->id)
                                ->where('endorsements.acct_status','2')
                                ->where('endorsements.date_ci_forwarded',explode(' ',$getAttendance[$multiVar]->date)[0])
//                                ->where('endorsements.date_ci_forwarded','<=',$end)
                                ->orderBy('endorsements.time_ci_forwarded', 'asc')
                                ->limit(1)
                                ->get();


                            $ci_attendance[$i][$multiVar]['id'] = $users[$i]->id;
                            $ci_attendance[$i][$multiVar]['ci_name'] = $users[$i]->name;
                            $ci_attendance[$i][$multiVar]['attendance'] = $getAttendance[$multiVar]->attendance;
                            $ci_attendance[$i][$multiVar]['branch'] = $users[$i]->branch;
                            $ci_attendance[$i][$multiVar]['region'] = $users[$i]->region;
                            $ci_attendance[$i][$multiVar]['archipelago'] = $users[$i]->archi;
                            $ci_attendance[$i][$multiVar]['path'] = $getAttendance[$multiVar]->path;

                            if(count($get_check_first_report) != 0)
                            {
                                $ci_attendance[$i][$multiVar]['first_sent_report'] = $get_check_first_report[0]->date_forwarded.' '.$get_check_first_report[0]->time_forwarded;
                            }
                            else
                            {
                                $ci_attendance[$i][$multiVar]['first_sent_report'] = 'No Account';
                            }

                            $get_path[$ctrPath][0] = $users[$i]->name;
                            $get_path[$ctrPath][1] = $getAttendance[$multiVar]->path;
                            $get_path[$ctrPath][2] = $users[$i]->id;

                            $ctrPath++;
                        }

                    }
                    else if(count($getAttendance) > 0)
                    {
                        $get_check_first_report = DB::table('users')
                            ->join('endorsement_user','endorsement_user.user_id','=','users.id')
                            ->join('endorsements','endorsements.id','=','endorsement_user.endorsement_id')
                            ->select([
                                'users.name as name',
                                'endorsements.date_ci_forwarded as date_forwarded',
                                'endorsements.id as endo_id',
                                'endorsements.time_ci_forwarded as time_forwarded'
                            ])
                            ->where('users.id',$users[$i]->id)
                            ->where('endorsements.acct_status','2')
                            ->where('endorsements.date_ci_forwarded',$start)
//                                ->where('endorsements.date_ci_forwarded','<=',$end)
                            ->orderBy('endorsements.time_ci_forwarded', 'asc')
                            ->limit(1)
                            ->get();


                        $ci_attendance[$i][0]['id'] = $users[$i]->id;
                        $ci_attendance[$i][0]['ci_name'] = $users[$i]->name;
                        $ci_attendance[$i][0]['attendance'] = $getAttendance[0]->attendance;
                        $ci_attendance[$i][0]['branch'] = $users[$i]->branch;
                        $ci_attendance[$i][0]['region'] = $users[$i]->region;
                        $ci_attendance[$i][0]['archipelago'] = $users[$i]->archi;

                        $ci_attendance[$i][0]['path'] = $getAttendance[0]->path;

                        if(count($get_check_first_report) != 0)
                        {
                            $ci_attendance[$i][0]['first_sent_report'] = $get_check_first_report[0]->date_forwarded.' '.$get_check_first_report[0]->time_forwarded;
                        }
                        else
                        {
                            $ci_attendance[$i][0]['first_sent_report'] = "No Account";
                        }

                        $get_path[$ctrPath][0] = $users[$i]->name;
                        $get_path[$ctrPath][1] = $getAttendance[0]->path;
                        $get_path[$ctrPath][2] = $users[$i]->id;

                        $ctrPath++;
                    } else {
                        $ci_attendance[$i][0]['id'] = $users[$i]->id;
                        $ci_attendance[$i][0]['ci_name'] = $users[$i]->name;
                        $ci_attendance[$i][0]['attendance'] = 'No Record';
                        $ci_attendance[$i][0]['branch'] = $users[$i]->branch;
                        $ci_attendance[$i][0]['region'] = $users[$i]->region;
                        $ci_attendance[$i][0]['archipelago'] = $users[$i]->archi;
                        $ci_attendance[$i][0]['first_sent_report'] = "No Account";
                        $ci_attendance[$i][0]['path'] = null;
                    }

                }
            }

            $pathDownload = storage_path('ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end);
            $filecount = glob("$pathDownload/*");

            $zipper->make(storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . '' . '/CI Selfies') . '.zip')
                ->add($filecount);
            $zipper->close();


            Excel::load(storage_path().'/Attendance.xlsx', function($reader) use ($now, $ci_attendance, $start, $end)
            {
                $reader->sheet('Sheet1',function($sheet) use($now, $ci_attendance)
                {
                    $iii = 0;
                    $key = '';
                    $rowCtr = 4;

                    $sheet->cell('A2',function ($c) use ($now) {
                        $c->setValue('Generated on: '.$now);
                    });

                    for($ii = 2; $ii < (count($ci_attendance) + 2); $ii++)
                    {
                        $key = 'F'.$rowCtr;

                        if(count($ci_attendance[$iii]) > 1)
                        {
                            for($insert = 0; $insert < count($ci_attendance[$iii]); $insert++)
                            {

                                $sheet->row($rowCtr, array(
                                    $ci_attendance[$iii][$insert]["ci_name"],
                                    $ci_attendance[$iii][$insert]["attendance"],
                                    $ci_attendance[$iii][$insert]["branch"],
                                    $ci_attendance[$iii][$insert]["region"],
                                    $ci_attendance[$iii][$insert]["archipelago"],
                                    $ci_attendance[$iii][$insert]["first_sent_report"],
                                ));
                                $rowCtr++;
                            }
                        } else {
                            $sheet->row($rowCtr, array(
                                $ci_attendance[$iii][0]["ci_name"],
                                $ci_attendance[$iii][0]["attendance"],
                                $ci_attendance[$iii][0]["branch"],
                                $ci_attendance[$iii][0]["region"],
                                $ci_attendance[$iii][0]["archipelago"],
                                $ci_attendance[$iii][0]["first_sent_report"],
                            ));
                            $rowCtr++;
                        }
                        $iii++;
                    }
                });
            })
                ->setFilename('Attendance From ' . $start . ' to ' . ' ' . $end . '')
                ->store('xlsx', storage_path('ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . ''));


            if (count($get_path) > 0) {
                for ($fn = 0; $fn < count($get_path); $fn++) {
                    $path = storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . '' . '/' . $get_path[$fn][0]) . '.zip';

                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }

            $getFinalZip = storage_path('ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end);
            $getFinalCtr = glob("$getFinalZip/*");

            $download = $zipper->make(storage_path('/ci_attendance_rar/' . Auth::user()->id . '/CI Attendance From ' . $start . ' to ' . ' ' . $end . '' . '/CI Attendance From ' . $start . ' to ' . ' ' . $end) . '.zip')
                ->add($getFinalCtr)
                ->getFilePath();
            $zipper->close();


            return response()->download($download)->deleteFileAfterSend();


        }
        else
        {
            abort(404);
        }
    }

    public function get_current_bi_note(Request $request)
    {
        $getInfo = DB::table('bi_ci_report')
            ->where('id', $request->id)
            ->select('ci_note', 'subj_name', 'client_name')
            ->get();

        return $getInfo;
    }

    public function get_bi_reports_table()
    {
        $getNotes = DB::table('bi_ci_report')
            ->join('users', 'users.id', '=', 'bi_ci_report.ci_id')
            ->select([
                'bi_ci_report.id as id',
                'users.name as name',
                'bi_ci_report.subj_name as subj_name',
                'bi_ci_report.client_name as client_name',
                'bi_ci_report.created_at as created_at',
            ]);

        return DataTables::of($getNotes)
            ->make(true);
    }

    public function gen_productivity_table(Request $request)
    {
        $getData = [];
        $toQueryPos = '';
        $tatCheck = '';

        if ($request->position_prod == 'ci') {
            $toQueryPos = 'handled_by_credit_investigator';
            $tatCheck = 'endorsement_status_internal';
        } else if ($request->position_prod == 'ao') {
            $toQueryPos = 'handled_by_account_officer';
            $tatCheck = 'endorsement_status_internal_2';
        }

        if ($request->sort_by_date == 'Day') {
            $getData = DB::table('endorsements')
                ->select
                (
                    'date_endorsed'
                )
                ->groupBy('date_endorsed')
                ->where('' . $toQueryPos . '', $request->id_to_select);

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->where('date_endorsed', $query->date_endorsed)
                        ->count();

                    return $getCount;
                })
                ->editColumn('pending_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->where('date_endorsed', $query->date_endorsed)
                        ->where('acct_status', '!=', 3)
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->where('date_endorsed', $query->date_endorsed)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->where('date_endorsed', $query->date_endorsed)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->where('date_endorsed', $query->date_endorsed)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->where('date_endorsed', $query->date_endorsed)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('action', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProd" name="' . $request->sort_by_date . '" idSelect="' . $request->id_to_select . '" info="' . $query->date_endorsed . '" pos="' . $request->position_prod . '">View Accounts</button>';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'action'])
                ->make(true);
        } else if ($request->sort_by_date == 'Year') {
            $getData = DB::table('endorsements')
                ->select(DB::raw("YEAR(date_endorsed) as date_endorsed"))
                ->orderBy(DB::raw("date_endorsed"), 'desc')
                ->groupBy(DB::raw("date_endorsed"))
                ->where('' . $toQueryPos . '', $request->id_to_select);

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereYear('date_endorsed', $query->date_endorsed)
                        ->count();

                    return $getCount;
                })
                ->editColumn('pending_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereYear('date_endorsed', $query->date_endorsed)
                        ->where('acct_status', '!=', 3)
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->date_endorsed)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->date_endorsed)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->date_endorsed)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->date_endorsed)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('action', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProd" name="' . $request->sort_by_date . '" idSelect="' . $request->id_to_select . '" info="' . $query->date_endorsed . '" pos="' . $request->position_prod . '">View Accounts</button>';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'action'])
                ->make(true);
        } else if ($request->sort_by_date == 'Month') {
            $getData = DB::table('endorsements')
                ->select(DB::raw("DATE_FORMAT(date_endorsed, '%m-%Y') date_endorsed"), DB::raw('YEAR(date_endorsed) year, MONTH(date_endorsed) month'))
                ->groupby('year', 'month')
//                ->orderBy(DB::raw("YEAR(date_endorsed)"), 'desc')
                ->where('' . $toQueryPos . '', $request->id_to_select);

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereMonth('date_endorsed', $query->month)
                        ->whereYear('date_endorsed', $query->year)
                        ->count();

                    return $getCount;
                })
                ->editColumn('pending_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereMonth('date_endorsed', $query->month)
                        ->whereYear('date_endorsed', $query->year)
                        ->where('acct_status', '!=', 3)
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereMonth('date_endorsed', $query->month)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereMonth('date_endorsed', $query->month)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereMonth('date_endorsed', $query->month)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereMonth('date_endorsed', $query->month)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('action', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProd" name="' . $request->sort_by_date . '" idSelect="' . $request->id_to_select . '" info="' . $query->month . '|--|--|' . $query->year . '" pos="' . $request->position_prod . '"> View Accounts</button>';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'action'])
                ->make(true);
        } else if ($request->sort_by_date == 'Week') {
            $getData = DB::table('endorsements')
                ->select('date_endorsed as date_endorsed_search', DB::raw('WEEK(date_endorsed) as week'), DB::raw('YEAR(date_endorsed) year'))
//                ->orderBy(DB::raw("WEEK(date_endorsed)"), 'desc')
                ->groupBy('week', 'year')
                ->where('' . $toQueryPos . '', $request->id_to_select);

            return DataTables::of($getData)
                ->editColumn('date_endorsed', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->select('date_endorsed')
                        ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereYear('date_endorsed', $query->year)
                        ->get();

                    $toShow = '';
                    $arr = [];
                    $currentVal = '';

                    foreach ($getCount as $things) {
                        if ($currentVal != $things->date_endorsed) {
                            if (strpos($toShow, $things->date_endorsed) !== false) {

                            } else if (strpos($toShow, $things->date_endorsed) !== true) {
                                $toShow .= $things->date_endorsed . '<br>';
                                $currentVal = $things->date_endorsed;
                            }

                        } else if ($currentVal == $things->date_endorsed) {

                        }
                    }

                    return $toShow;


                })
                ->editColumn('dispatched_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereYear('date_endorsed', $query->year)
                        ->count();

                    return $getCount;
                })
                ->editColumn('pending_count', function ($query) use ($request, $toQueryPos) {
                    $getCount = DB::table('endorsements')
                        ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                        ->where('' . $toQueryPos . '', $request->id_to_select)
                        ->whereYear('date_endorsed', $query->year)
                        ->where('acct_status', '!=', 3)
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'TAT')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    $getCount = [];

                    if ($request->position_prod == 'ci') {
                        $getCount = DB::table('endorsements')
                            ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    } else if ($request->position_prod == 'ao') {
                        $getCount = DB::table('endorsements')
                            ->where(DB::raw("WEEK(date_endorsed)"), $query->week)
                            ->where('' . $toQueryPos . '', $request->id_to_select)
                            ->whereYear('date_endorsed', $query->year)
                            ->where('acct_status', '=', 3)
                            ->where('' . $tatCheck . '', 'OVERDUE')
                            ->count();
                    }

                    return $getCount;
                })
                ->editColumn('action', function ($query) use ($request, $toQueryPos, $tatCheck) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProd" name="' . $request->sort_by_date . '" idSelect="' . $request->id_to_select . '" info="' . $query->week . '|--|--|' . $query->year . '" pos="' . $request->position_prod . '"> View Accounts</button>';
                })
                ->rawColumns(['date_endorsed', 'dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'action'])
                ->make(true);
        }
    }

    public function gen_check_user_productivity()
    {
        $getAccess = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select
            ([
                'role_user.role_id as role',
                'users.client_check as client_check',
                'users.manage_prod_dept as dept'
            ])
            ->where('users.id', Auth::user()->id)
            ->get();

        return response()->json($getAccess);
    }

    public function gen_productivity_table_cc(Request $request)
    {
        if ($request->sort_by_date_cc == 'Day') {
            $getData = DB::table('bi_endorsements_users')
                ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                ->select
                ([
                    DB::raw('DATE(bi_endorsements_users.updated_at) as date_assigned_tele')
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                ->groupBy('date_assigned_tele');

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '!=', 0)
                                ->orwhere('bi_endorsements.status', '!=', 1);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
//                        ->where()
                        ->count();

                    return $getCount;

                })
                ->editColumn('pending_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 2)
                                ->orwhere('bi_endorsements.status', '=', 24)
                                ->orwhere('bi_endorsements.status', '=', 25);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '<=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        // ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 10)
                                ->orwhere('bi_endorsements.status', '=', 25);
                        })
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '>=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('contacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Contacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Complete';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        // ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 10)
                                ->orwhere('bi_endorsements.status', '=', 25);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('uncontacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Uncontacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Partial';
                    }

                    $getCount = DB::table('bi_endorsements')
                        ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereDate('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        // ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 10)
                                ->orwhere('bi_endorsements.status', '=', 25);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('action', function ($query) use ($request) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProdCC" name="' . $request->sort_by_date_cc . '" idSelect="' . $request->id_to_select_cc . '" info="' . $query->date_assigned_tele . '" pos="' . $request->check_access . '">View Accounts</button>';
                })
                ->editColumn('call_duration', function ($query) {
                    return 'N/A';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'contacted', 'uncontacted', 'call_duration', 'action'])
                ->make(true);
        } else if ($request->sort_by_date_cc == 'Year') {
            $getData = DB::table('bi_endorsements_users')
                ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                ->select
                ([
                    DB::raw('YEAR(DATE(bi_endorsements_users.updated_at)) as date_assigned_tele')
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                ->groupBy(DB::raw('YEAR(DATE(bi_endorsements_users.updated_at))'));

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '!=', 0)
                                ->orwhere('bi_endorsements.status', '!=', 1);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;

                })
                ->editColumn('pending_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 2)
                                ->orwhere('bi_endorsements.status', '=', 24);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '<=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '>=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('contacted', function ($query) use ($request) {

                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Contacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Complete';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('uncontacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Uncontacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Partial';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->date_assigned_tele)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('call_duration', function ($query) {
                    return 'N/A';
                })
                ->editColumn('action', function ($query) use ($request) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProdCC" name="' . $request->sort_by_date_cc . '" idSelect="' . $request->id_to_select_cc . '" info="' . $query->date_assigned_tele . '" pos="' . $request->check_access . '">View Accounts</button>';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'contacted', 'uncontacted', 'call_duration', 'action'])
                ->make(true);
        } else if ($request->sort_by_date_cc == 'Month') {
            $getData = DB::table('bi_endorsements_users')
                ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                ->select
                ([
                    DB::raw("DATE_FORMAT(DATE(bi_endorsements_users.updated_at), '%m-%Y') date_assigned_tele"),
                    DB::raw('YEAR(DATE(bi_endorsements_users.updated_at)) year, MONTH(DATE(bi_endorsements_users.updated_at)) month')
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                ->groupBy('year', 'month');

            return DataTables::of($getData)
                ->editColumn('dispatched_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '!=', 0)
                                ->orwhere('bi_endorsements.status', '!=', 1);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();
//
                    return $getCount;

                })
                ->editColumn('pending_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 2)
                                ->orwhere('bi_endorsements.status', '=', 24);
                        })
                        ->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '<=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '>=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('contacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Uncontacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Partial';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('uncontacted', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->whereMonth('bi_endorsements_users.updated_at', $query->month)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', 'Uncontacted')
                        ->count();

                    return $getCount;
                })
                ->editColumn('call_duration', function ($query) {
                    return 'N/A';
                })
                ->editColumn('action', function ($query) use ($request) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProdCC" name="' . $request->sort_by_date_cc . '" idSelect="' . $request->id_to_select_cc . '" info="' . $query->month . '|--|--|' . $query->year . '" pos="' . $request->check_access . '">View Accounts</button>';
                })
                ->rawColumns(['dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'contacted', 'uncontacted', 'call_duration', 'action'])
                ->make(true);
        } else if ($request->sort_by_date_cc == 'Week') {
            $getData = DB::table('bi_endorsements_users')
                ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                ->select
                ([
                    DB::raw("WEEK(DATE(bi_endorsements_users.updated_at)) week"),
                    DB::raw("DATE(bi_endorsements_users.updated_at) date_endorsed"),
                    DB::raw('YEAR(DATE(bi_endorsements_users.updated_at)) year')
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                ->groupBy('week', 'year');

            return DataTables::of($getData)
                ->editColumn('date_assigned_tele', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->select(DB::raw("DATE(bi_endorsements_users.updated_at) date_endorsed"))
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '!=', 0)
                                ->orwhere('bi_endorsements.status', '!=', 1);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->get();

                    $toShow = '';
                    $arr = [];
                    $currentVal = '';

                    foreach ($getCount as $things) {
                        if ($currentVal != $things->date_endorsed) {
                            if (strpos($toShow, $things->date_endorsed) !== false) {

                            } else if (strpos($toShow, $things->date_endorsed) !== true) {
                                $toShow .= $things->date_endorsed . '<br>';
                                $currentVal = $things->date_endorsed;
                            }

                        } else if ($currentVal == $things->date_endorsed) {

                        }
                    }

                    return $toShow;


                })
                ->editColumn('dispatched_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '!=', 0)
                                ->orwhere('bi_endorsements.status', '!=', 1);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();
//
                    return $getCount;
                })
                ->editColumn('pending_count', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.status', '=', 2)
                                ->orwhere('bi_endorsements.status', '=', 24);
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('on_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '<=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('out_tat', function ($query) use ($request) {
                    $getCount = DB::table('bi_endorsements')
                        ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            $query->where('bi_endorsements.date_time_finished', '>=', 'bi_endorsements.date_time_due');
                        })
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->count();

                    return $getCount;
                })
                ->editColumn('contacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Contacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Complete';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('uncontacted', function ($query) use ($request) {
                    $stat = '';

                    if ($request->check_access == 'teletfs') {
                        $stat = 'Uncontacted';
                    } else if ($request->check_access == 'cc') {
                        $stat = 'Partial';
                    }

                    $getCount = DB::table('bi_endorsements_users')
                        ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                        ->where('bi_endorsements_users.position_id', 17)
                        ->whereYear('bi_endorsements_users.updated_at', $query->year)
                        ->where(DB::raw("WEEK(DATE(bi_endorsements_users.updated_at))"), $query->week)
                        ->where('bi_endorsements_users.users_id', $request->id_to_select_cc)
                        ->where('bi_endorsements.status', '=', 10)
                        ->where(function ($query) {
                            return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                                ->orwhere('bi_endorsements.cancel_bool', '=', null);
                        })
                        ->where('bi_endorsements.acct_report_status', '' . $stat . '')
                        ->count();

                    return $getCount;
                })
                ->editColumn('call_duration', function ($query) {
                    return 'N/A';
                })
                ->editColumn('action', function ($query) use ($request) {
                    return '<button class="btn btn-xs btn-primary btn-block showAccountsEmpProdCC" name="' . $request->sort_by_date_cc . '" idSelect="' . $request->id_to_select_cc . '" info="' . $query->week . '|--|--|' . $query->year . '" pos="' . $request->check_access . '">View Accounts</button>';
                })
                ->rawColumns(['date_assigned_tele', 'dispatched_count', 'pending_count', 'on_tat', 'out_tat', 'contacted', 'uncontacted', 'call_duration', 'action'])
                ->make(true);
        }
    }
  
    public function gen_accts_under_emp_date_table(Request $request)
    {
        $endorsements = [];

        if ($request->sort_by_to_table == 'Day')
        {
            if ($request->pos_to_table == 'ci')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->where('endorsements.date_endorsed', $request->info_to_where)
                    ->where('endorsements.handled_by_credit_investigator', $request->user_to_where);
            }
            else if ($request->pos_to_table == 'ao')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->where('endorsements.date_endorsed', $request->info_to_where)
                    ->where('endorsements.handled_by_account_officer', $request->user_to_where)
                    ->where('endorsements.acct_status', '3');
            }
        }
        else if ($request->sort_by_to_table == 'Week')
        {
            $dates = explode('|--|--|', $request->info_to_where);

            if ($request->pos_to_table == 'ci') {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->orderBy('endorsements.date_endorsed', 'desc')
                    ->where(DB::raw("WEEK(date_endorsed)"), $dates[0])
                    ->whereYear('endorsements.date_endorsed', $dates[1])
                    ->where('endorsements.handled_by_credit_investigator', $request->user_to_where);
            } else if ($request->pos_to_table == 'ao')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->orderBy('endorsements.date_endorsed', 'desc')
                    ->where(DB::raw("WEEK(date_endorsed)"), $dates[0])
                    ->whereYear('endorsements.date_endorsed', $dates[1])
                    ->where('endorsements.handled_by_account_officer', $request->user_to_where)
                    ->where('endorsements.acct_status', '3');
            }
        } else if ($request->sort_by_to_table == 'Month')
        {
            $dates = explode('|--|--|', $request->info_to_where);

            if ($request->pos_to_table == 'ci')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->orderBy('endorsements.date_endorsed', 'desc')
                    ->whereMonth('endorsements.date_endorsed', $dates[0])
                    ->whereYear('endorsements.date_endorsed', $dates[1])
                    ->where('endorsements.handled_by_credit_investigator', $request->user_to_where);
            }
            else if ($request->pos_to_table == 'ao')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->orderBy('endorsements.date_endorsed', 'desc')
                    ->whereMonth('endorsements.date_endorsed', $dates[0])
                    ->whereYear('endorsements.date_endorsed', $dates[1])
                    ->where('endorsements.handled_by_account_officer', $request->user_to_where)
                    ->where('endorsements.acct_status', '3');
            }
        }
        else if ($request->sort_by_to_table == 'Year')
        {
            if ($request->pos_to_table == 'ci')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->whereYear('endorsements.date_endorsed', $request->info_to_where)
                    ->where('endorsements.handled_by_credit_investigator', $request->user_to_where);
            }
            else if ($request->pos_to_table == 'ao')
            {
                $endorsements = DB::table('endorsements')
                    ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                    ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
                    ->select
                    ([
                        'endorsements.id as id',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.account_name as account_name',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.provinces as provinces',
                        'municipalities.muni_name as muni_name',
                        'endorsements.client_name as client_name',
                        'endorsements.acct_status as acct_status',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.handled_by_credit_investigator as handled_by_credit_investigator',
                        'endorsements.handled_by_account_officer as handled_by_account_officer',
                        'endorsements.handled_by_dispatcher as handled_by_dispatcher',
                        'endorsements.re_ci as re_ci',
                        'endorsements.ci_cert as ci_cert',
                        'endorsements.address as address',
                    ])
                    ->whereYear('endorsements.date_endorsed', $request->info_to_where)
                    ->where('endorsements.handled_by_account_officer', $request->user_to_where)
                    ->where('endorsements.acct_status', '3');
            }
        }

        return DataTables::of($endorsements)
            ->editColumn('acct_status_view', function ($endorsements) use ($request) {
                if ($request->pos_to_table == 'ci') {
                    if ($endorsements->acct_status == '') {
                        return ' <small class="label bg-red fa fa-warning" style="width: 100%">NEW ACCOUNT</small>';
                    } else if ($endorsements->acct_status == '5') {
                        return ' <small class="label bg-red fa fa-times-circle" style="width: 100%">CANCELLED</small>';
                    } else if ($endorsements->acct_status == '4') {
                        return ' <small class="label bg-orange fa fa-hand-stop-o" style="width: 100%">HOLD</small>';
                    } else if ($endorsements->acct_status == '3') {
                        return ' <small class="label bg-green fa fa-check" style="width: 100%">SUCCESS</small>';

                    } else if ($endorsements->acct_status == '2') {
                        return ' <small class="label bg-light-blue fa fa-arrow-circle-right" style="width: 100%">DATA FORWARDED</small>';
                    } else if ($endorsements->date_due . ' ' . $endorsements->time_due < Carbon::now('Asia/Manila')) {
                        return ' <small class="label bg-black fa fa-clock-o" style="width: 100%">LATE</small>';
                    } else if ($endorsements->acct_status == '1') {
                        return ' <small class="label bg-primary fa fa-motorcycle" style="width: 100%">ON FIELD</small>';
                    }
                    return '';
                } else if ($request->pos_to_table == 'ao') {
                    if ($endorsements->acct_status == '3') {
                        return ' <small class="label bg-green fa fa-check" style="width: 100%">SUCCESS</small>';

                    }
                }

            })
            ->editColumn('type_of_request', function ($query) {
                if ($query->type_of_request == 'PDRN') {
                    return '<b>PDRN</b>';
                } else if ($query->type_of_request == 'BVR') {

                    $getinfo = DB::table('businesses')
                        ->select('business_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>BVR:<br></b>' . $getinfo[0]->business_name . '</br>';

                } else if ($query->type_of_request == 'EVR') {
                    $getinfo = DB::table('employers')
                        ->select('employer_name', 'endorsement_id')
                        ->where('endorsement_id', $query->id)
                        ->get();

                    return '<b>EVR:<br></b>' . $getinfo[0]->employer_name . '</br>';
                } else {
                    return '';
                }
            })
            ->editColumn('client_name', function ($query) {

                $getinfo = DB::table('users')
                    ->select('pix_path')
                    ->where('name', $query->client_name)
                    ->get();

                if (count($getinfo) >= 1) {
                    return $query->client_name . '<div class="image"><img src="' . $getinfo[0]->pix_path . '" class="img-circle" style="height: 25px; width: 25px"></div>';

                } else {
                    return $query->client_name;
                }

            })
            ->rawColumns([
                'acct_status_view',
                'type_of_request',
                'client_name',
            ])
            ->make(true);
    }

    public function gen_accts_under_emp_date_table_cc(Request $request)
    {
        $bi_endorsements = [];

        if($request->sort_by_to_table_cc == 'Day')
        {
            $bi_endorsements = DB::table('bi_endorsements_users')
                ->join('bi_endorsements','bi_endorsements.id','=','bi_endorsements_users.bi_endorse_id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'users.client_check as type_user'
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->whereDate('bi_endorsements_users.updated_at', $request->info_to_where_cc)
                ->where('bi_endorsements_users.users_id', $request->user_to_where_cc)
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.status', '!=', 0)
                        ->orwhere('bi_endorsements.status', '!=', 1);
                })
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                        ->orwhere('bi_endorsements.cancel_bool', '=', null);
                });
        }
        else if($request->sort_by_to_table_cc == 'Week')
        {
            $dates = explode('|--|--|', $request->info_to_where_cc);

            $bi_endorsements = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'users.client_check as type_user'
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->where(DB::raw("WEEK(bi_endorsements_users.updated_at)"), $dates[0])
                ->whereYear('bi_endorsements.created_at', $dates[1])
                ->where('bi_endorsements_users.users_id', $request->user_to_where_cc)
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.status', '!=', 0)
                        ->orwhere('bi_endorsements.status', '!=', 1);
                })
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                        ->orwhere('bi_endorsements.cancel_bool', '=', null);
                });




        }
        else if($request->sort_by_to_table_cc == 'Month')
        {
            $dates = explode('|--|--|', $request->info_to_where_cc);

            $bi_endorsements = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'users.client_check as type_user'
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->whereMonth('bi_endorsements.created_at', $dates[0])
                ->whereYear('bi_endorsements.created_at', $dates[1])
                ->where('bi_endorsements_users.users_id', $request->user_to_where_cc)
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.status', '!=', 0)
                        ->orwhere('bi_endorsements.status', '!=', 1);
                })
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                        ->orwhere('bi_endorsements.cancel_bool', '=', null);
                });

        }
        else if($request->sort_by_to_table_cc == 'Year')
        {
            $bi_endorsements = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'users.client_check as type_user'
                ])
                ->where('bi_endorsements_users.position_id', 17)
                ->whereYear('bi_endorsements.created_at', $request->info_to_where_cc)
                ->where('bi_endorsements_users.users_id', $request->user_to_where_cc)
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.status', '!=', 0)
                        ->orwhere('bi_endorsements.status', '!=', 1);
                })
                ->where(function ($query) {
                    return $query->orwhere('bi_endorsements.cancel_bool', '=', '')
                        ->orwhere('bi_endorsements.cancel_bool', '=', null);
                });
        }

        return DataTables::of($bi_endorsements)
            ->make(true);
    }

    public function gen_attendance_in_out_check(Request $request)
    {
        if($request->date_inputted == null)
        {
            $now = explode(' ', Carbon::now('Asia/Manila'))[0];
            $toGo = false;
            $userInfo = DB::table('users')
                ->where('id', Auth::user()->id)
                ->select(
                    'users.work_start',
                    'users.work_end'
                )
                ->get();

            if($userInfo[0]->work_start == '' && $userInfo[0]->work_end == '' || $userInfo[0]->work_start == null && $userInfo[0]->work_end == null)
            {
                $toGo = false;
            }
            else
            {
                $toGo = true;
            }

            $getInfo = DB::table('attendance_all_employee')
                ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
                ->where('users.id', Auth::user()->id)
                ->whereDate('attendance_all_employee.created_at' , '<=', Carbon::parse($now))
                ->whereDate('attendance_all_employee.created_at' , '>', Carbon::parse($now)->subDay(1))
                ->select([
                    'attendance_all_employee.time_in',
                    'attendance_all_employee.created_at',
                    'attendance_all_employee.type',
                    'users.work_start',
                    'users.work_end'
                ])
                ->get();

            return response()->json([$getInfo,$userInfo, $toGo]);
        }
        else if($request->date_inputted != null)
        {
            $now = $request->date_inputted;

            $userInfo = DB::table('users')
                ->where('id', Auth::user()->id)
                ->select(
                    'users.work_start',
                    'users.work_end'
                )
                ->get();
            $getInfo = DB::table('attendance_all_employee')
                ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
                ->where('users.id', Auth::user()->id)
                ->whereDate('attendance_all_employee.created_at' , '<=', Carbon::parse($now))
                ->whereDate('attendance_all_employee.created_at' , '>', Carbon::parse($now)->subDay(1))
                ->select([
                    'attendance_all_employee.time_in',
                    'attendance_all_employee.created_at',
                    'attendance_all_employee.type',
                    'users.work_start',
                    'users.work_end'
                ])
                ->get();

            return response()->json([$getInfo,$userInfo]);
        }
    }

    public function gen_emp_time_in_and_time_out(Request $request)
    {
        if(Auth::user()->work_start != '' && Auth::user()->work_end != '')
        {
            DB::table('attendance_all_employee')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'pos_id' => Auth::user()->roles->first()->id,
                    'time_in' => Carbon::now('Asia/Manila'),
                    'type' => $request->type,
                    'ip_address' => $request->ip(),
                    'created_at' => Carbon::now('Asia/Manila'),
                ]);

            return 'success';
        }
        else
        {
            return 'no sched';
        }


    }

    public function gen_save_daily_work_sched(Request $request)
    {
        $ses = Session();
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];
        $userID = Auth::user()->id;
        $userName = Auth::user()->name;

        if(Auth::user()->work_start == '' && Auth::user()->work_end == '')
        {
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'work_start' => $request->work_start,
                    'work_end' => $request->work_end,
                ]);


            DB::table('audits')
                ->insert
                (
                    [
                        'endorsement_id' => 0,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper($ses->get('role')),
                        'branch' => strtoupper($ses->get('userBranch')),
                        'activities' => strtoupper('UPDATE DAILY SCHEDULE TO '. $request->work_start . ' - ' . $request->work_end),
                        'type' => 'attendance',
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );
        }
        else
        {
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'work_start' => $request->work_start,
                    'work_end' => $request->work_end,
                ]);

            DB::table('audits')
                ->insert
                (
                    [
                        'endorsement_id' => 0,
                        'name' => strtoupper(Auth::user()->name),
                        'position' => strtoupper($ses->get('role')),
                        'branch' => strtoupper($ses->get('userBranch')),
                        'activities' => strtoupper('CHANGE DAILY SCHEDULE FROM ' . Auth::user()->work_start .' - '. Auth::user()->work_end . ' TO '. $request->work_start . ' - ' . $request->work_end),
                        'type' => 'attendance',
                        'date_occured' => $date,
                        'time_occured' => $time
                    ]
                );
        }
    }

    public function get_ci_reimbursement_table()
    {
        $getInfos = DB::table('fund_requests_fund_to_reimburse')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->join('fund_requests as fund_main', 'fund_main.id', '=', 'fund_requests_fund_to_reimburse.fund_id')
            ->join('users', 'users.id', '=', 'fund_requests.ci_id')
            ->select([
                'fund_requests_fund_to_reimburse.reimburse_id as id',
                'fund_requests_fund_to_reimburse.fund_id as main_id',
                'fund_main.id as id_main',
                'fund_requests.fund_amount as fund_amount',
                'users.name as ci_name',
                'fund_requests.dispatcher_remarks as remarks',
                'fund_main.created_at as created_at'
            ])
            ->where('fund_requests_fund_to_reimburse.status', 'PENDING');

        return DataTables::of($getInfos)
            ->editcolumn('amount', function($query)
            {
                return 'Php ' . base64_decode($query->fund_amount);
            })
            ->rawColumns([
                'amount'
            ])
            ->make(true);
    }

    public function get_ci_reimbursement_table_approved()
    {
        $getInfos = DB::table('fund_requests_fund_to_reimburse')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->join('fund_requests as fund_main', 'fund_main.id', '=', 'fund_requests_fund_to_reimburse.fund_id')
            ->join('users', 'users.id', '=', 'fund_requests.ci_id')
            ->select([
                'fund_requests_fund_to_reimburse.reimburse_id as id',
                'fund_requests_fund_to_reimburse.fund_id as main_id',
                'fund_main.id as id_main',
                'fund_requests.fund_amount as fund_amount',
                'users.name as ci_name',
                'fund_requests.dispatcher_remarks as remarks',
                'fund_main.created_at as created_at'
            ])
            ->where(function($query)
            {
                return $query->where('fund_requests_fund_to_reimburse.status', 'APPROVED')
                    ->orwhere('fund_requests_fund_to_reimburse.status', 'COMPLETED');
            });

        return DataTables::of($getInfos)
            ->editcolumn('amount', function($query)
            {
                return 'Php ' . base64_decode($query->fund_amount);
            })
            ->rawColumns([
                'amount'
            ])
            ->make(true);
    }

    public function get_ci_reimbursement_table_disapproved()
    {
        $getInfos = DB::table('fund_requests_fund_to_reimburse')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->join('fund_requests as fund_main', 'fund_main.id', '=', 'fund_requests_fund_to_reimburse.fund_id')
            ->join('users', 'users.id', '=', 'fund_requests.ci_id')
            ->select([
                'fund_requests_fund_to_reimburse.reimburse_id as id',
                'fund_requests_fund_to_reimburse.fund_id as main_id',
                'fund_main.id as id_main',
                'fund_requests.fund_amount as fund_amount',
                'users.name as ci_name',
                'fund_main.dispatcher_remarks as remarks',
                'fund_main.created_at as created_at'
            ])
            ->where('fund_requests_fund_to_reimburse.status', 'DISAPPROVED');

        return DataTables::of($getInfos)
            ->editcolumn('amount', function($query)
            {
                return 'Php ' . base64_decode($query->fund_amount);
            })
            ->rawColumns([
                'amount'
            ])
            ->make(true);
    }

    public function ci_reimbursement_approve_fund(Request $request)
    {
        $getInfo = DB::table('fund_requests_fund_to_reimburse')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->leftjoin('fund_request_endorsements', 'fund_request_endorsements.fund_id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->where('fund_requests_fund_to_reimburse.reimburse_id', $request->fund_id)
            ->select([
                'fund_requests_fund_to_reimburse.fund_id', //eto ung sa main fund na req ng reimburse
                'fund_requests_fund_to_reimburse.status as rb_status',
                'fund_requests.sao_status as sao_status',
                'fund_requests.reimburse_status as fr_status',
                'fund_request_endorsements.type as type',
            ])
            ->get();

        if($request->what == 'Approved')
        {
            if(count($getInfo) > 0)
            {
                if($getInfo[0]->sao_status == 'APPROVED' || $getInfo[0]->sao_status == 'DISAPPROVED')
                {
                    return 'do nothing';
                }
                else if($getInfo[0]->type == 'Success')
                {
                    return 'done by finance';
                }
                else
                {
                    DB::table('fund_requests')
                        ->where('id', $request->fund_id)
                        ->update([
                            'sao_status' => 'APPROVED',
                            'dispatcher_remarks' => $request->remarks,
                            'reimburse_status' => 'APPROVED'
                        ]);

                    DB::table('fund_requests')
                        ->where('id', $getInfo[0]->fund_id)
                        ->update([
                            'dispatcher_id' => Auth::user()->id,
                            'sao_approved_date' => Carbon::now('Asia/Manila'),
                            'reimburse_status' => 'APPROVED'
                        ]);

//                    DB::table('fund_request_endorsements')
//                        ->where('id', $request->fund_id)
//                        ->update([
//                            'type' => 'Disapproved'
//                        ]);

                    DB::table('fund_requests_fund_to_reimburse')
                        ->where('fund_id', $getInfo[0]->fund_id)
                        ->where('reimburse_id', $request->fund_id)
                        ->update([
                            'status' => 'APPROVED',
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    $fund_audit = new AuditFundQueries();
                    $get_name = User::find(Auth::user()->id);
                    $fund_audit->fund_logs($get_name->name.' APPROVED THE REIMBURSEMENT'  , $request->fund_id);
                    $fund_audit->fund_logs($get_name->name.' APPROVED THE REIMBURSEMENT REQUEST'  , $getInfo[0]->fund_id);

                    return 'ok';
                }
            }
        }
        else if($request->what == 'Disapproved')
        {
            if(count($getInfo) > 0)
            {
                if($getInfo[0]->sao_status == 'APPROVED' || $getInfo[0]->sao_status == 'DISAPPROVED')
                {
                    return 'do nothing';
                }
                else if($getInfo[0]->type == 'Success')
                {
                    return 'done by finance';
                }
                else
                {
                    DB::table('fund_requests')
                        ->where('id', $request->fund_id)
                        ->update([
                            'sao_status' => 'DISAPPROVED',
//                            'dispatcher_remarks' => $request->remarks,
                            'reimburse_status' => 'DISAPPROVED'
                        ]);

                    DB::table('fund_requests')
                        ->where('id', $getInfo[0]->fund_id)
                        ->update([
                            'dispatcher_id' => Auth::user()->id,
                            'sao_approved_date' => Carbon::now('Asia/Manila'),
                            'reimburse_status' => 'DISAPPROVED'
                        ]);

                    DB::table('fund_request_endorsements')
                        ->where('id', $request->fund_id)
                        ->update([
                            'type' => 'Disapproved'
                        ]);

                    DB::table('fund_requests_fund_to_reimburse')
                        ->where('fund_id', $getInfo[0]->fund_id)
                        ->where('reimburse_id', $request->fund_id)
                        ->update([
                            'status' => 'DISAPPROVED',
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    $fund_audit = new AuditFundQueries();
                    $get_name = User::find(Auth::user()->id);
                    $fund_audit->fund_logs($get_name->name.' DISAPPROVED THE REIMBURSEMENT'  , $request->fund_id);
                    $fund_audit->fund_logs($get_name->name.' DISAPPROVED THE REIMBURSEMENT REQUEST'  , $getInfo[0]->fund_id);

                    return 'ok';
                }
            }
        }
    }

    public function ci_reimbursement_disapprove_fund(Request $request)
    {
        $getInfo = DB::table('fund_requests_fund_to_reimburse')
            ->join('fund_requests', 'fund_requests.id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->leftjoin('fund_request_endorsements', 'fund_request_endorsements.fund_id', '=', 'fund_requests_fund_to_reimburse.reimburse_id')
            ->where('fund_requests_fund_to_reimburse.reimburse_id', $request->fund_id)
            ->select([
                'fund_requests_fund_to_reimburse.fund_id', //eto ung sa main fund na req ng reimburse
                'fund_requests_fund_to_reimburse.status as rb_status',
                'fund_requests.sao_status',
                'fund_requests.reimburse_status as fr_status',
                'fund_request_endorsements.type as type',
            ])
            ->get();
    }

    public function client_applicant_processing_checker(Request $request, $name_of_client)
    {
        $getAllLinks = SiteApplicationLink::all();
        $countLinks = SiteApplicationLink::count();

        for($i=0; $i <= $countLinks; $i++)
        {
            $link = $getAllLinks[$i]->link;

            if($name_of_client == $link)
            {
                $user =  $getAllLinks[$i]->user_id;

                $check_qualfon = '';

                if($link == 'qualfon-test' || $link == 'qualfon-manila' || $link == 'qualfon-cebu' || $link == 'qualfon-dumaguete' || $link == 'test' || $link == 'qualfon-admin' || $link == 'qualfon-corporate')
                {
                    $check_qualfon = 'yes';
                }
                else
                {
                    $check_qualfon = 'no';
                }

                $webStatus = DB::table('downs')
                    ->select(['web_status'])
                    ->first();

                if($webStatus->web_status ===1)
                {
                    Auth::logout();
                    return view('errors.down');
                }
                else
                {
                    $javs = DB::table('javascript_magic')
                        ->select('unique')
                        ->where('id','1')
                        ->get()[0]->unique;

                    return view('DirectEncodeApplicant', compact('check_qualfon', 'user', 'javs'));
                }
            }
        }
        
        // if($name_of_client == 'test')
        // {
        //     $user = User::find(531); // localhost RANYLL
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     return view('DirectEncodeApplicant', compact('javs'));
        // }
        // else if($name_of_client == 'sitel-test')
        // {
        //     $user = User::find(1184); // localhost RANYLL
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     return view('DirectEncodeApplicant', compact('javs'));
        // }
        // else if($name_of_client == 'sitel')
        // {
        //     $user = User::find(1204); // MAIN SITEL PLEASE WAG GAGALAWIN
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     return view('DirectEncodeApplicant', compact('javs'));
        // }
        // else if($name_of_client == 'qualfon-test')
        // {
        //     $user = User::find(1248); // QUALFON TEST
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     $validation_qualfon = 'yes';

        //     return view('DirectEncodeApplicant', compact('javs', 'validation_qualfon'));
        // }
        // else if($name_of_client == 'qualfon-manila')
        // {
        //     $user = User::find(1255); // QUALFON TEST
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     $validation_qualfon = 'yes';

        //     return view('DirectEncodeApplicant', compact('javs', 'validation_qualfon'));
        // }
        // else if($name_of_client == 'qualfon-cebu')
        // {
        //     $user = User::find(1253); // QUALFON TEST
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     $validation_qualfon = 'yes';

        //     return view('DirectEncodeApplicant', compact('javs', 'validation_qualfon'));
        // }
        // else if($name_of_client == 'qualfon-dumaguete')
        // {
        //     $user = User::find(1254); // QUALFON TEST
        //     Auth::login($user);

        //     $javs = DB::table('javascript_magic')
        //         ->select('unique')
        //         ->where('id','1')
        //         ->get()[0]->unique;

        //     $validation_qualfon = 'yes';

        //     return view('DirectEncodeApplicant', compact('javs', 'validation_qualfon'));
        // }
    }

    public function incident_report_fineuploader($folderDateTime)
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
                $result = $uploader->combineChunks(('incident_report_files/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime));
            }
            // Handles upload requests
            else
            {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if(!File::isDirectory(storage_path('incident_report_files/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime)));
                {
                    File::makeDirectory(storage_path('/incident_report_files/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime),$mode = 0777, true, true);
                }
                $result = $uploader->handleUpload(storage_path('incident_report_files/'. Auth::user()->id . '/' . implode($splitFolder1) . '/' . $folderDateTime));
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

    public function incident_report_info(Request $request)
    {
        $dateToday = Carbon::now('Asia/Manila');

        DB::table('incident_report')
            ->insert
            ([
                'user_id' => Auth::user()->id,
                'report_remarks' => $request->rem,
                'general_status' => 'New',
                'photo_file_path' => 'incident_report_files/'. Auth::user()->id . '/' . $request->unang_folder . '/' . $request->pangalawang_folder,
                'created_at' => $dateToday
            ]);
    }

    public function gen_inc_rep_review_pending_approver()
    {
        $getData = DB::table('incident_report')
            ->join('users', 'users.id', '=' ,'incident_report.user_id')
            ->select
            ([
                'incident_report.id as id',
                'users.name as name',
                'incident_report.created_at as date_time',
                'incident_report.general_status as stat'
            ])
        ->where('incident_report.general_status', 'New');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_inc_rep_review_done_approver()
    {
        $getData = DB::table('incident_report')
            ->join('users', 'users.id', '=' ,'incident_report.user_id')
            ->select
            ([
                'incident_report.id as id',
                'users.name as name',
                'incident_report.created_at as date_time',
                'incident_report.general_status as stat'
            ])
            ->where('incident_report.general_status', '!=' ,'New');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_incident_get_images(Request $request)
    {
        $file_name_array = [];
        $file_path = [];
        $getRecord = DB::table('incident_report')
            ->where('id', $request->id)
            ->select('report_remarks', 'photo_file_path', '1st_approver_remarks as rem_approver', 'admin_remarks')
            ->get();

        $directory = storage_path($getRecord[0]->photo_file_path);
        $filecount = glob("$directory/*");

        for($ctr = 0; $ctr<count($filecount); $ctr++)
        {
            $file_name_array[$ctr] = explode($getRecord[0]->photo_file_path.'/',$filecount[$ctr])[1];
            $file_path[$ctr] = $filecount[$ctr];
        }

        return response()->json([$file_name_array, $getRecord]);
    }

    public function gen_incident_approval_1st(Request $request)
    {
        $stat = '';

        if($request->stat == 'approve')
        {
            $stat = 'Management Approved';
        }
        else if($request->stat == 'reject')
        {
            $stat = 'Management Reject';
        }


        DB::table('incident_report')
            ->where('id', $request->id)
            ->update
            ([
                '1st_approver_id' => Auth::user()->id,
                '1st_approver_remarks' => $request->rem,
                'general_status' => $stat,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function gen_inc_rep_review_pending_admin()
    {
        $getData = DB::table('incident_report')
            ->join('users', 'users.id', '=' ,'incident_report.user_id')
            ->select
            ([
                'incident_report.id as id',
                'users.name as name',
                'incident_report.created_at as date_time',
                'incident_report.general_status as stat'
            ])
            ->where('incident_report.general_status', 'Management Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_inc_rep_review_done_admin()
    {
        $getData = DB::table('incident_report')
            ->join('users', 'users.id', '=' ,'incident_report.user_id')
            ->select
            ([
                'incident_report.id as id',
                'users.name as name',
                'incident_report.created_at as date_time',
                'incident_report.general_status as stat'
            ])
            ->where(function ($query)
            {
                return $query->orwhere('incident_report.general_status', '=', 'Admin Approved')
                ->orwhere('incident_report.general_status', '=',  'Admin Reject');
            });

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_incident_approval_admin(Request $request)
    {
        $stat = '';

        if($request->stat == 'approve')
        {
            $stat = 'Admin Approved';
        }
        else if($request->stat == 'reject')
        {
            $stat = 'Admin Reject';
        }


        DB::table('incident_report')
            ->where('id', $request->id)
            ->update
            ([
                'admin_approver_id' => Auth::user()->id,
                'admin_remarks' => $request->rem,
                'general_status' => $stat,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }
    
    public function gen_monit_issuance_table()
    {
        $getData = DB::table('hr_issuance_main')
            ->join('users', 'users.id', '=', 'hr_issuance_main.issuance_sender')
            ->select
            ([
                'users.name as name_sender',
                'hr_issuance_main.created_at as date',
                'hr_issuance_main.issuance_to as  to',
                'hr_issuance_main.issuance_subject as subj',
                'hr_issuance_main.id as id'
            ]);

        return DataTables::of($getData)
            ->make(true);
    }

    public function gen_fetch_issuance_indiv(Request $request)
    {
        $id = base64_decode($request->id);

        $getInfo = DB::table('hr_issuance_main')
            ->join('users', 'users.id', '=', 'hr_issuance_main.issuance_sender')
            ->select
            ([
                'hr_issuance_main.issuance_subject',
                'hr_issuance_main.issuance_content',
                'users.name'
            ])
            ->where('hr_issuance_main.id', $id)
            ->get();

        $getFiles = DB::table('hr_issuance_files')
            ->select('id', 'file_name')
            ->where('issuance_id', $id)
            ->get();

        return response()->json([$getInfo, $getFiles]);
    }
    
    public function admin_sendAcno()
    {
        $getAcknowledge = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'acknowledge_forms.id as id',
                'acknowledge_form_details.encoded_items as encoded_items',
                'acknowledge_form_details.attachment_bool as attachment_bool',
                'acknowledge_forms.office_loc_dep_pos as office_loc_dep_pos',
                'acknowledge_forms.cnum_email as cnum_email',
                'acknowledge_forms.lbc_branch as LBC_Branch',
                'acknowledge_forms.status as status',
                'acknowledge_forms.updated_at as updated_at',
                'acknowledge_forms.created_at as created_at'

            ])
            ->where('acknowledge_forms.emp_id', Auth::user()->id)

//            ->orderBy('id', 'desc')
            ->get();
            return $getAcknowledge;
    }

    public function admin_viewAcknow(Request $request)
    {
        $viewAcknowledge = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'users.name as Employee_name',
                'acknowledge_forms.id as id',
                'acknowledge_form_details.encoded_items as encoded_items',
                'acknowledge_form_details.attachment_bool as attachment_bool',
                'acknowledge_forms.office_loc_dep_pos as office_loc_dep_pos',
                'acknowledge_forms.cnum_email as cnum_email',
                'acknowledge_forms.lbc_branch as LBC_Branch',
                'acknowledge_forms.status as status',
                'acknowledge_forms.updated_at as updated_at',
                'acknowledge_forms.created_at as created_at'
            ])
            ->where('acknowledge_forms.id', $request->id)
            ->get();
        $encoded_items = json_decode($viewAcknowledge[0]->encoded_items);
        return response()->json([$viewAcknowledge, $encoded_items]);

    }

    public function acknowledge_form_status(Request $request)
    {
        $email = new EmailQueries();

        DB::table('acknowledge_forms')
            ->where('acknowledge_forms.id', $request->id)
            ->update
            ([
                'status' => 'Acknowledge',
                'updated_at' => Carbon::now('Asia/Manila')
             ]);
        $email->adminReceive_ar_notify($request->id);
    }
    
    public function get_user_archipelago(Request $request)
    {
        $archi_id = $request->arch;

        $get_user_archipelago = DB::table('users')
            ->join('role_user', 'role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->join('provinces','provinces.id','=','users.branch')
            ->join('regions','regions.id','=','provinces.region_id')
            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
            ->where('users.archive','False')
            ->where(function($query){
                return $query->where('roles.id','!=',4)
                    ->where('roles.id','!=',6)
                    ->where('roles.id','!=',14);
            })
            ->where(function($query) use($archi_id)
            {
                if($archi_id != '')
                {
                    return $query->where('archipelagos.id', $archi_id);
                }
            })
            ->select([
                'users.name as emp_name',
                'users.id as id',
                'users.work_start as work_start',
                'users.work_end as work_end',
                'regions.region_name as region',
                'archipelagos.id as archipelagos_id',
                'provinces.name as province_name',
                'archipelagos.archipelago_name as archipelago_name'
            ]);

        return DataTables::of($get_user_archipelago)
            ->make(true);
    }
    
    public function get_management_saveTime(Request $request)
    {
        $work_start_attend = date("h:i A", strtotime($request->work_start));
        $work_end_attend = date("h:i A", strtotime($request->work_end));
        $oldSched = User::find($request->id)->work_start . ' - ' . User::find($request->id)->work_end;
        $newSched = $work_start_attend . ' - ' . $work_end_attend;

        $getTIme = DB::table('users')
            ->where('id', $request->id)
            ->update([
                'work_start'=>  $work_start_attend,
                'work_end' => $work_end_attend,
            ]);

        DB::table('user_attendance_logs')
            ->insert
            ([
                'management_id' => Auth::user()->id,
                'user_id' => $request->id,
                 'activity' => 'Update Schedule from ' . $oldSched .  ' '.  'to' .' '.  $newSched,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        return $getTIme;
    }

    public function filter_archipelagos_search(Request $request)
    {
        $get_archipelagos = DB::table('users')
            ->join('role_user', 'role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->join('provinces','provinces.id','=','users.branch')
            ->join('regions','regions.id','=','provinces.region_id')
            ->join('archipelagos','archipelagos.id','=','regions.archipelago_id')
            ->where(function($query){
                return $query->where('roles.id','!=',4)
                    ->where('roles.id','!=',6)
                    ->where('roles.id','!=',14);
            })
            ->select([
                'users.name as emp_name',
                'archipelagos.archipelago_name as archipelagos.archipelago_name',
                'archipelagos.id as archipelago_id',
                'regions.region_name as region',
                'provinces.name as province_name'
            ])
            ->get();
        return $get_archipelagos;
    }
    
    public function users_management_view_logs(Request $request)
    {
        $getAccountInfo = DB::table('user_attendance_logs')
            ->join('users', 'users.id', '=', 'user_attendance_logs.management_id')
            ->join('role_user', 'role_user.user_id', '=', 'user_attendance_logs.management_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('user_attendance_logs.user_id', $request->id)
            ->select([
                'users.id as id',
                'user_attendance_logs.activity as activity',
                'user_attendance_logs.user_id as user_id',
                'users.name as name',
                'roles.name as position',
                'user_attendance_logs.management_id as management_id',
                'user_attendance_logs.created_at as created_at'
            ])
            ->get();
        return response()->json([$getAccountInfo]);
    }
}