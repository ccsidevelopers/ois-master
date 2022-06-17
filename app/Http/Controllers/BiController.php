<?php

namespace App\Http\Controllers;

use App\bi_endorsement;
use App\bi_endorsements_checking;
use App\bi_endorsements_user;
use App\bi_log;
use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\TypeOfRequest;
use App\User;
use Carbon\Carbon;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use PHPExcel_IOFactory;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class BiController extends Controller
{
    public function BiPanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('B.I Client')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;
                    
                $getBiInfo = DB::table('bi_account_to_users')
                    ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                    ->where('bi_account_to_users.users_id', Auth::user()->id)
                    ->where('bi_account_list.bi_account_name', '=', 'Qualfon')
                    ->get();

                $tors = TypeOfRequest::all();

                return view('bi_client.bi-client-master', compact('javs','tors', 'getBiInfo'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function bi_check_user()
    {
        return response()->json([Auth::user()->client_check, Auth::user()->authrequest]);
    }

    public function bi_client_get_general_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;
            
        $search_type = $request->search_methodd;
        $from = $request->min_date_endorsed;
        $to = $request->max_date_endorsed;

        $get_general_table = [];

        if($getAuth == 'cc_bank')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '!=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '!=', '');
                })
                ->where('bi_endorsements.status', '!=' ,1999);
        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select
                ([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query) use ($search_type, $from, $to)
                {
                    if($search_type != 'all')
                    {
                        return $query->whereDate('bi_endorsements.created_at', '<=', $to)
                            ->whereDate('bi_endorsements.created_at', '>=', $from);
                    }
                })
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
                })
                ->where(function($query) use($getAuth)
                {
                    if($getAuth == 'tat_selector')
                    {
                        return $query->orwhere('users.client_check','=', $getAuth)
                            ->orwhere('users.client_check', '=', '');
                    }
                    else
                    {
                        return $query->where('users.client_check','=', '');
                    }
                })
                ->where('bi_endorsements.status', '!=' ,1999);
        }

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
                        $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>1. none</p>';
                    }

                    if($get_attachment[0]->attach_2 != '')
                    {
                        $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>2. none</p>';
                    }

                    if($get_attachment[0]->attach_3 != '')
                    {
                        $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>3. none</p>';
                    }

                    if($get_attachment[0]->attach_4 != '')
                    {
                        $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
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
                if($get_general_table->cancel_status == 'Pending' || $get_general_table->cancel_status == 'Cancelled')
                {
                    if($get_general_table->cancel_status == 'Cancelled')
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                    }
                    else if($get_general_table->cancel_status == 'Pending')
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Account</a>';
                    }
                }
                else if($get_general_table->cancel_status == 'Pending Cancel' || $get_general_table->cancel_status == 'Pending Revoke')
                {
                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> '.$get_general_table->cancel_status.'</a>';
                }
                else
                {
                    if($get_general_table->status == 0)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                    }
                    else if ($get_general_table->status == 20)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                    }
                    else if ($get_general_table->status == 22)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                    }
                    else if ($get_general_table->status == 23)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                    }
                    else if ($get_general_table->status == 24)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                    }
                    else if ($get_general_table->status == 25)
                    {
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                    }
                    else if ($get_general_table->status == 26)
                    {
                        return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-ban-circle"></i> Pending Cancellation</a>';
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
//                        $difference_days = $now->diffInDays($date. false);

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' ;
//                        '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>';
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
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);

                        $now = Carbon::now('Asia/Manila');
                        $datenowexplode = explode(" ",$now);
                        $hoursexplode = explode(":", $datenowexplode[1]);
                        $arrayExpHoursnow = $hoursexplode[0];
                        $arrayExpMinutesnow = $hoursexplode[1];

                        $datenowexplode1 = explode(" ",$get_general_table->due);
                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
                        $arrayExpHoursdb = $hoursexplode1[0];
                        $arrayExpMinutesdb = $hoursexplode1[1];

                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;

                        $getminute = 0;

                        if($remaininghour < 0)
                        {
                            $remaininghour = $remaininghour + 24;
                        }
                        if($remainningmins < 0)
                        {
                            $getminute = $remainningmins +60;
                        }

                        $difference_hours = $now->diffInHours($date, false);
                        $difference_mins = $now->diffInMinutes($date, false);

                        $difference_days = $now->diffInDays($date. false);

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned</a>';

                        if($difference_days <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                        }
                        else if($difference_days >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>';
                        }
                        else if($difference_hours <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                        }
                        else if($difference_hours >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>';
                        }
                        else if($difference_mins <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                        }
                        else if($difference_mins >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                        }
                    }
                    else if($get_general_table->status == 3)
                    {
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);

                        $now = Carbon::now('Asia/Manila');
                        $datenowexplode = explode(" ",$now);
                        $hoursexplode = explode(":", $datenowexplode[1]);
                        $arrayExpHoursnow = $hoursexplode[0];
                        $arrayExpMinutesnow = $hoursexplode[1];

                        $datenowexplode1 = explode(" ",$get_general_table->due);
                        $hoursexplode1 = explode(":", $datenowexplode1[1]);
                        $arrayExpHoursdb = $hoursexplode1[0];
                        $arrayExpMinutesdb = $hoursexplode1[1];

                        $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
                        $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;

                        $getminute = 0;

                        if($remaininghour < 0)
                        {
                            $remaininghour = $remaininghour + 24;
                        }
                        if($remainningmins < 0)
                        {
                            $getminute = $remainningmins +60;
                        }

                        $difference_hours = $now->diffInHours($date, false);
                        $difference_mins = $now->diffInMinutes($date, false);

                        $difference_days = $now->diffInDays($date. false);
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';

                        if($difference_days <= -1)
                        {
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                        }
                        else if($difference_days >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>';
                        }
                        else if($difference_hours <= -1)
                        {
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                        }
                        else if($difference_hours >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>';
                        }
                        else if($difference_mins <= -1)
                        {
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                        }
                        else if($difference_mins >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                        }
                    }
                }
            })
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->rawColumns([
                'attachments',
                'due',
                'check',
            ])
            ->make(true);
    }

    public function bi_client_get_pending_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = [];

        if($getAuth == 'cc_bank')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where(function ($query)
                {
                    return $query->orWhere('bi_endorsements.status',1)
                        ->orWhere('bi_endorsements.status', 2)
                        ->orWhere('bi_endorsements.status', 24);
                })
                ->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                ->where('bi_endorsements.type_of_endorsement_bank', '!=' , '');

        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.cancel_bool as cancel_status',
                    'bi_endorsements.type_of_endorsement_bank as tor'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where(function ($query)
                {
                    return $query->orWhere('bi_endorsements.status',1)
                        ->orWhere('bi_endorsements.status', 2)
                        ->orWhere('bi_endorsements.status', 24);
                })
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=',  null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=' , '');
                })
                ->where('bi_endorsements.cancel_bool', '!=', 'Cancelled');
        }



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
                        $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>1. none</p>';
                    }

                    if($get_attachment[0]->attach_2 != '')
                    {
                        $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>2. none</p>';
                    }

                    if($get_attachment[0]->attach_3 != '')
                    {
                        $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>3. none</p>';
                    }

                    if($get_attachment[0]->attach_4 != '')
                    {
                        $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
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
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_general_table->due);

                $now = Carbon::now('Asia/Manila');
                $datenowexplode = explode(" ",$now);
                $hoursexplode = explode(":", $datenowexplode[1]);
                $arrayExpHoursnow = $hoursexplode[0];
                $arrayExpMinutesnow = $hoursexplode[1];

                $datenowexplode1 = explode(" ",$get_general_table->due);
                $hoursexplode1 = explode(":", $datenowexplode1[1]);
                $arrayExpHoursdb = $hoursexplode1[0];
                $arrayExpMinutesdb = $hoursexplode1[1];

                $remaininghour = $arrayExpHoursdb - $arrayExpHoursnow;
                $remainningmins = $arrayExpMinutesdb - $arrayExpMinutesnow;

                $getminute = 0;

                if($remaininghour < 0)
                {
                    $remaininghour = $remaininghour + 24;
                }
                if($remainningmins < 0)
                {
                    $getminute = $remainningmins +60;
                }

                $ackhtml = '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>';
                $pendhtml = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned</a>';

                $difference_hours = $now->diffInHours($date);
                $difference_mins = $now->diffInMinutes($date);

                $difference_days = $now->diffInDays($date);

                if($difference_days >= 1) //days
                {
                    if($get_general_table->due == 1)
                    {
                        return $ackhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days</a>';
                    }
                    else if($get_general_table->due)
                    {
                        return $pendhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days</a>';
                    }
                }
                else if($difference_hours >= 1) //hours
                {
                    if($get_general_table->due == 2)
                    {
                        return $ackhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours</a>';
                    }
                    else if($get_general_table->due)
                    {
                        return $pendhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>';
                    }
                }
                else if($remainningmins >= 1) //minutes
                {
                    if($get_general_table->due == 2)
                    {
                        return $ackhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                    }
                    else if($get_general_table->due)
                    {
                        return $pendhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                    }
                }
                else
                {
                    if($get_general_table->due == 2)
                    {
                        return $ackhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                    }
                    else if($get_general_table->due)
                    {
                        return $pendhtml .'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                    }
                }
            })
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->rawColumns([
                'attachments',
                'due',
                'check',
            ])
            ->make(true);
    }

    public function bi_client_get_return_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        if($getAuth == 'cc_bank')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.type_of_endorsement_bank as tor'
                ])
//                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->groupBy('bi_endorsements.id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)

                ->where(function($query)
                {
                    return $query->orwhere('bi_endorsements.status',20)
                        ->orwhere('bi_endorsements.status',22)
                        ->orwhere('bi_endorsements.status',23);
                })
                ->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                ->where('bi_endorsements.type_of_endorsement_bank', '!=', '');
        }
        else
        {
                $get_general_table = DB::table('bi_endorsements')
                    ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                    ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    //                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                    ->select([
    //            \DB::raw('count(count.bi_endorsement_id) as count'),
                        'bi_endorsements.id as endorse_id',
                        'bi_endorsements.bi_account_name as site',
                        'bi_endorsements.party_num as party_num',
                        'bi_endorsements.contract_num as contract_num',
                        'bi_endorsements.created_at as date_time_endorsed',
                        'bi_endorsements.project as project',
                        'bi_endorsements.account_name as account_name',
                        'bi_endorsements.package as package',
    //                    'bi_endorsements_checkings.checking_name as check',
                        'bi_endorsements.endorser_poc as poc',
                        'bi_endorsements.status as status',
                        'bi_endorsements.attach_1 as attach_1',
                        'bi_endorsements.attach_2 as attach_2',
                        'bi_endorsements.attach_3 as attach_3',
                        'bi_endorsements.attach_4 as attach_4',
                        'bi_endorsements.type_of_endorsement_bank as tor',
                        'users.client_check'
                    ])
                    ->groupBy('bi_endorsements.id')
    //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                    ->where('bi_account_to_users.users_id',Auth::user()->id)
                    ->where('bi_endorsements_users.position_id', 14)
                    ->where(function($query)
                    {
                        return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                            ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
                    })
                    ->where(function($query)
                    {
                        return $query->orwhere('bi_endorsements.status',20)
                            ->orwhere('bi_endorsements.status',22)
                            ->orwhere('bi_endorsements.status',23);
                    })
                    ->where(function($query) use($getAuth)
                    {
                        if($getAuth == 'tat_selector')
                        {
                            return $query->orwhere('users.client_check','=', $getAuth)
                                ->orwhere('users.client_check', '=', '');
                        }
                        else
                        {
                            return $query->where('users.client_check','=', '');
                        }
                    });
            }

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

                    if($get_attachment[0]->attach_1 == '')
                    {
                        $downloads  .=  '1. none<br><a class="btn_upload_return btn btn-xs btn-info btn-block" data-toggle="modal" style="display: none;" id="'.$query->endorse_id.'" name="1" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Attach File</a>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-1" style="display: none;">';

                    }
                    else
                    {
                        $downloads .= '<p id="p-'.$query->endorse_id.'-1">1. '.$get_attachment[0]->attach_1.'</p>'.
                            '<a class="btn_upload_remove btn btn-xs btn-danger btn-block" data-toggle="modal" style="display: none;" id="'.$query->endorse_id.'" name="1" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Remove File</a>'.
                            '<span id="span-'.$query->endorse_id.'-1"></span>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-1" style="display: none;">';

                    }

                    if($get_attachment[0]->attach_2 == '')
                    {
                        $downloads  .=  '2. none<br><a class="btn_upload_return btn btn-xs btn-info btn-block" data-toggle="modal" id="'.$query->endorse_id.'" style="display: none;" name="2" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Attach File</a>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-2" style="display: none;">';

                    }
                    else
                    {
                        $downloads .= '<p id="p-'.$query->endorse_id.'-2">2. '.$get_attachment[0]->attach_2.'</p>'.
                            '<a class="btn_upload_remove btn btn-xs btn-danger btn-block" data-toggle="modal" style="display: none;" id="'.$query->endorse_id.'" name="2" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Remove File</a>'.
                            '<span id="span-'.$query->endorse_id.'-2"></span>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-2" style="display: none;">';
                    }

                    if($get_attachment[0]->attach_3 == '')
                    {
                        $downloads  .=  '3. none<br><a class="btn_upload_return btn btn-xs btn-info btn-block" data-toggle="modal" id="'.$query->endorse_id.'" style="display: none;" name="3" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Attach File</a>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-3" style="display: none;">';
                    }
                    else
                    {
                        $downloads .= '<p id="p-'.$query->endorse_id.'-3">3. '.$get_attachment[0]->attach_3.'</p>'.
                            '<a class="btn_upload_remove btn btn-xs btn-danger btn-block" data-toggle="modal" style="display: none;" id="'.$query->endorse_id.'" name="3" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Remove File</a>'.
                            '<span id="span-'.$query->endorse_id.'-3"></span>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-3" style="display: none;">';
                    }

                    if($get_attachment[0]->attach_4 == '')
                    {
                        $downloads  .=  '4. none<br><a class="btn_upload_return btn btn-xs btn-info btn-block" data-toggle="modal" id="'.$query->endorse_id.'" style="display: none;" name="4" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Attach File</a>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-4" style="display: none;">';
                    }
                    else
                    {
                        $downloads .= '<p id="p-'.$query->endorse_id.'-4">4. '.$get_attachment[0]->attach_4.'</p>'.
                            '<a class="btn_upload_remove btn btn-xs btn-danger btn-block" data-toggle="modal" style="display: none;" id="'.$query->endorse_id.'" name="4" data-target=""><i class="glyphicon glyphicon-upload-alt"></i> Remove File</a>'.
                            '<span id="span-'.$query->endorse_id.'-4"></span>'.
                            '<input type="file" name="" id="upload-'.$query->endorse_id.'-4" style="display: none;">';
                    }


                    return $downloads.' <span id="ulPercentage_reupload-'.$query->endorse_id.'" hidden></span>
                        <div id="progressbar_reupload-'.$query->endorse_id.'" hidden></div>';
                }
            })
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->rawColumns([
                'attachments',
                'check',
            ])
            ->make(true);
    }

    public function bi_client_table_finished(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;
            
        $search_type = $request->search_methodd;
        $from = $request->min_date_endorsed;
        $to = $request->max_date_endorsed;


        $get_general_table = [];

        if($getAuth == 'cc_bank')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select
                ([
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.status as status1',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.date_time_finished as finish',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.verify_tele_status as tele_stat',
                    'bi_endorsements.verify_tele_status_details as contact_details',
                    'users.client_check as type_user'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where('bi_endorsements.status', 10)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '!=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '!=', '');
                });
        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select
                ([
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.status as status1',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.date_time_finished as finish',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'users.client_check as type_user'
                ])
                ->groupBy('bi_endorsements.id')
//                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where('bi_endorsements.status', 10)
                ->where(function($query) use ($search_type, $from, $to)
                {
                    if($search_type != 'all')
                    {
                        return $query->whereDate('bi_endorsements.created_at', '<=', $to)
                            ->whereDate('bi_endorsements.created_at', '>=', $from);
                    }
                })
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
                });
        }

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
                        $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>1. none</p>';
                    }

                    if($get_attachment[0]->attach_2 != '')
                    {
                        $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>2. none</p>';
                    }

                    if($get_attachment[0]->attach_3 != '')
                    {
                        $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>3. none</p>';
                    }

                    if($get_attachment[0]->attach_4 != '')
                    {
                        $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                    }
                    else
                    {
                        $downloads .='<p>4. none</p>';
                    }


                    return $downloads;
                }
            })
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->editColumn('status', function ($query)
            {
                $dateDue = Carbon::createFromFormat('Y-m-d H:i:s', $query->due);
                $dateFinished = Carbon::createFromFormat('Y-m-d H:i:s', $query->finish);
                $statusTat = '';
                $difference_min = $dateFinished->diffInMinutes($dateDue, false);
                $dateTimeSent = '<br>Date and Time Sent : <br><br>'. $query->finish;

                if($difference_min >= 0)
                {
                    $statusTat = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> WITHIN TAT</a>';
                }
                else if($difference_min < 0)
                {
                    $statusTat = '<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE</a>';
                }

//                if($query->status_report == 'Complete')
//                {
//                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' .
//                        '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;

                return $statusTat . $dateTimeSent;
//                }
//                else
//                {
//                return $statusTat;

//                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' .
//                        '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$query->status_report.' </a>' . $statusTat;
//                }
            })
            ->rawColumns([
                'attachments',
                'check',
                'status'
            ])
            ->make(true);
    }

    public function bi_get_bi_account_name()
    {
//        $get_bi_account_name = DB::table('bi_account_to_users')
//            ->leftjoin('bi_account_list','bi_account_list.id','=','bi_account_to_users.bi_account_id')
//            ->select([
//                'bi_account_list.bi_account_name as bi_account_name',
//                'bi_account_list.account_location as account_location',
//                'bi_account_list.id as bi_id',
//            ])
//            ->where('bi_account_to_users.users_id',Auth::user()->id)
//            ->get();

        $get_account = DB::table('bi_account_to_users')
            ->leftjoin('bi_account_list','bi_account_list.id','=','bi_account_to_users.bi_account_id')
            ->leftjoin('package_to_account','package_to_account.bi_account_id','=','bi_account_list.id')
            ->leftjoin('package_list','package_list.id','=','package_to_account.package_id')
            ->leftjoin('checking_to_package','checking_to_package.package_to_account_id','=','package_to_account.id')
            ->leftjoin('checking_list','checking_list.id','=','checking_to_package.checking_id')
            ->select([
                'bi_account_list.bi_account_name as bi_account_name',
                'bi_account_list.id as bi_id',
                'bi_account_list.account_location as account_location',
                'package_list.package as package',
                'package_list.id as package_id',
                'checking_list.checking_name as checking',
                'checking_list.id as checking_id',
                'checking_list.information as information',
                'checking_list.ocular as ocular'
            ])
            ->where('bi_account_to_users.users_id',Auth::user()->id)
            ->where('bi_account_to_users.to_display','display')
            ->orderBy('checking_list.checking_name','asc')
            ->get();

        $get_other_package = DB::table('other_checking_list')
            ->leftjoin('bi_account_list','bi_account_list.id','=','other_checking_list.bi_account_id')
            ->select(
                [
                    'other_checking_list.checking_name as other_check',
                    'other_checking_list.information as information',
                    'other_checking_list.ocular as ocular'
                ])
            ->where('bi_account_list.id',$get_account[0]->bi_id)
            ->get();

        if(count($get_account) == 0)
        {
            return 'none';
        }
        else
        {
            if(count($get_other_package)==0)
            {
                $get_other_package='none';
            }

            return response()->json([$get_account,$get_other_package]);
        }
    }

    public function bi_get_change_package_check(Request $request)
    {
        $package_id = $request->package_id;

        $get_account = DB::table('package_to_account')
            ->leftjoin('package_list','package_list.id','=','package_to_account.package_id')
            ->leftjoin('checking_to_package','checking_to_package.package_to_account_id','=','package_to_account.id')
            ->leftjoin('checking_list','checking_list.id','=','checking_to_package.checking_id')
            ->select([
                'package_list.package as package',
                'package_list.id as package_id',
                'checking_list.checking_name as checking',
                'checking_list.id as checking_id'
            ])
            ->where('package_list.id',$package_id)
            ->get();

        if(count($get_account) == 0)
        {
            return 'none';
        }
        else
        {
            return response()->json($get_account);
        }

    }

    public function bi_submit_endorsement(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $checkSame = DB::table('bi_endorsements')
            ->where('bi_account_name', $request->bi_account)
            ->where('bi_id', $request->bi_id)
            ->where('f_name', $trimmer->trims($request->acct_first))
            ->where('m_name', $trimmer->trims($request->acct_middle))
            ->where('l_name', $trimmer->trims($request->acct_last))
            ->where('birth_day', $trimmer->trims($request->acct_birthdate_day))
            ->where('birth_month', $trimmer->trims($request->acct_birthdate_month))
            ->where('birth_year', $trimmer->trims($request->acct_birthdate_year))
            ->where('status', '!=', '1999')
            ->count();

        if($checkSame > 0)
        {
            return 'double';
        }
        else
        {
            $bi_account = $request->bi_account;
            $bi_id = $request->bi_id;
            $bi_project_name = $removeScript->scripttrim($request->bi_project_name);
            $bi_account_lob = $removeScript->scripttrim($request->bi_account_lob);
            $type_package = $removeScript->scripttrim($request->type_package);
            $acct_last = $removeScript->scripttrim($request->acct_last);
            $acct_first = $removeScript->scripttrim($request->acct_first);
            $acct_middle = $removeScript->scripttrim($request->acct_middle);
            $acct_suffix = $removeScript->scripttrim($request->acct_suffix);
            $acct_gender = $removeScript->scripttrim($request->acct_gender);
            $acct_marital_status = $removeScript->scripttrim($request->acct_marital_status);
            $acct_birthdate_day = $removeScript->scripttrim($request->acct_birthdate_day);
            $acct_birthdate_month = $removeScript->scripttrim($request->acct_birthdate_month);
            $acct_birthdate_year = $removeScript->scripttrim($request->acct_birthdate_year);
            $acct_birthdate_age = $removeScript->scripttrim($request->acct_birthdate_age);
            $acct_citizenship = $removeScript->scripttrim($request->acct_citizenship);
            $acct_maiden_last_name = $removeScript->scripttrim($request->acct_maiden_last_name);
            $acct_maiden_first_name = $removeScript->scripttrim($request->acct_maiden_first_name);
            $acct_maiden_middle_name = $removeScript->scripttrim($request->acct_maiden_middle_name);
            $bi_present_address = $removeScript->scripttrim($request->bi_present_address);
            $bi_present_idProvince = $request->bi_present_idProvince;
            $bi_present_idMunicipality = $request->bi_present_idMunicipality;
            $bi_permanent_address = $removeScript->scripttrim($request->bi_permanent_address);
            $bi_permanent_idProvince = $request->bi_permanent_idProvince;
            $bi_permanent_idMunicipality = $request->bi_permanent_idMunicipality;
            $acct_endorsedby = $removeScript->scripttrim($request->acct_endorsedby);
            $checking_array = $request->checking_array;
            $checkin_array_kind = $request->checkin_array_kind;
            $tat_type = $request->tat_type;
            $other_address = $request->other_address;
            $other_address_add = $request->other_address_add;
            $other_muni_add = $request->other_muni_add;
            $other_prov_add = $request->other_prov_add;
            $dealership = $trimmer->trims($request->accnt_dealership);
            $accnt_number = $trimmer->trims($request->accnt_number);



            $endorse = new bi_endorsement();
            $endorse->bi_account_name = $trimmer->trims($bi_account);
            $endorse->bi_id = $bi_id;
            $endorse->project = $trimmer->trims($bi_project_name);
            $endorse->lob = $bi_account_lob;
            $endorse->package = $trimmer->trims($type_package);
            $endorse->f_name = $trimmer->trims($acct_first);
            if($acct_middle != '')
            {
                $endorse->account_name = $trimmer->trims($acct_last).', '.$trimmer->trims($acct_first).' '.$trimmer->trims($acct_middle);
                $endorse->m_name = $trimmer->trims($acct_middle);
            }
            else
            {
                $endorse->account_name = $trimmer->trims($acct_last).', '.$trimmer->trims($acct_first);
                $endorse->m_name = '';
            }
            $endorse->l_name = $trimmer->trims($acct_last);
            $endorse->suffix = $trimmer->trims($acct_suffix);
            $endorse->gender = $trimmer->trims($acct_gender);
            $endorse->marital_status = $trimmer->trims($acct_marital_status);
            $endorse->birth_day = $acct_birthdate_day;
            $endorse->birth_month = $acct_birthdate_month;
            $endorse->birth_year = $acct_birthdate_year;
            $endorse->age = $acct_birthdate_age;
            $endorse->citizenship = $trimmer->trims($acct_citizenship);
            $endorse->maiden_name = $trimmer->trims($acct_maiden_last_name).', '.$trimmer->trims($acct_maiden_first_name).' '.$trimmer->trims($acct_maiden_middle_name);
            $endorse->maiden_f_name = $trimmer->trims($acct_maiden_first_name);
            $endorse->maiden_m_name = $trimmer->trims($acct_maiden_middle_name);
            $endorse->maiden_l_name = $trimmer->trims($acct_maiden_last_name);
            $endorse->present_address = $trimmer->trims($bi_present_address);
            $endorse->present_muni = $bi_present_idMunicipality;
            $endorse->present_province = $bi_present_idProvince;
            $endorse->permanent_address = $trimmer->trims($bi_permanent_address);
            $endorse->permanent_muni = $bi_permanent_idMunicipality;
            $endorse->permanent_province = $bi_permanent_idProvince;
            $endorse->endorser_poc = $trimmer->trims($acct_endorsedby);
            $endorse->type_of_tat = $tat_type;
//            $endorse->others_dealership_name = $dealership;
//            $endorse->others_account_number = $accnt_number;

//        $endorse->attach_1
//        $endorse->attach_2
//        $endorse->attach_3
//        $endorse->attach_4
            $email = new EmailQueries();
            $account4EmailName = $trimmer->trims($acct_last).', '.$trimmer->trims($acct_first).' '.$trimmer->trims($acct_middle);

            $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);
            $endorse->status = '0';
            $endorse->save();

            //concentrix
            if($request->if_direct == 'direct')
            {
                $CurDate = Carbon::now('Asia/Manila');
                $date_time = explode(' ', $CurDate);
                $date = explode('-', $date_time[0]);
                $time = explode(':', $date_time[1]);
                $randoString = $date[0].$date[1].$date[2].'-'.strtoupper(Str::random(5)).'-'.$time[0].$time[1].$time[2];

                DB::table('bi_endorsements_transaction_id')
                    ->insert([
                        'endorsement_id' => $endorse->id,
                        'transaction_id' => $randoString,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('bi_endorsements_other_informations')
                    ->insert([
                        'endorsement_id' => $endorse->id,
                        'sss' => $removeScript->scripttrim($request->accnt_sss),
                        'philhealth' => $removeScript->scripttrim($request->accnt_philhealth),
                        'pag_ibig' => $removeScript->scripttrim($request->accnt_pag_ibig),
                        'tin' => $removeScript->scripttrim($request->accnt_tin),
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }

//        $endorse->checking

            $user = User::find(Auth::user()->id);
            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorse->id;
            $endorse_user->users_id = Auth::user()->id;
            $endorse_user->position_id = $user->roles->first()->id;
            $endorse_user->save();

//        if(count($other_address) != 0)
//        {

//        }

            if($other_address[0] != 'no_other_address')
            {
                for($ctr = 0; $ctr<count($other_address_add); $ctr++)
                {
                    DB::table('bi_endorsement_other_address')
                        ->insert([
                            'bi_id' => $endorse->id,
                            'address' => $trimmer->trims($other_address_add[$ctr]),
                            'muni_id' => $other_muni_add[$ctr],
                            'province_id' => $other_prov_add[$ctr]
                        ]);
                }
            }

            $coount = 0;
            foreach ($checking_array as $check)
            {
                $endorse_checking = new bi_endorsements_checking();
                $endorse_checking->checking_name = $trimmer->trims($check);
                $endorse_checking->bi_endorsement_id = $endorse->id;

                if($checkin_array_kind[$coount] != null)
                {
                    $endorse_checking->type_check = $checkin_array_kind[$coount];
                }
                $endorse_checking->save();
                $coount++;
            }

            $logs = new bi_log();
            $logs->endorse_id = $endorse->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ENDORSED THE ACCOUNT';
            $logs->remarks = '-';
            $logs->save();

            return response()->json(['proceed_to_upload',$endorse->id]);
//        return response()->json($other_address);
        }



    }

    public function bi_submit_endorsement_files(Request $request)
    {
        $file1 = $request->file('file_1');
        $file2 = $request->file('file_2');
        $file3 = $request->file('file_3');
        $file4 = $request->file('file_4');
        $ongoing_id = $request->endorse_id;

        $endorse = new bi_endorsement();
        $endorse = $endorse::find($ongoing_id);

        $count = 1;
        if($file1 != null)
        {
            $file_name1 = $file1->getClientOriginalName();

            if($file_name1 == $endorse->attach_2)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $endorse->attach_3)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $endorse->attach_4)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            $file1->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name1);

            $endorse->attach_1 = $file_name1;

        }

        if($file2 != null)
        {
            $file_name2 = $file2->getClientOriginalName();

            if($file_name2 == $endorse->attach_1)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $endorse->attach_3)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $endorse->attach_4)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }


            $file2->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name2);

            $endorse->attach_2 = $file_name2;

        }

        if($file3 != null)
        {
            $file_name3 = $file3->getClientOriginalName();

            if($file_name3 == $endorse->attach_1)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $endorse->attach_2)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $endorse->attach_4)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            $file3->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name3);

            $endorse->attach_3 = $file_name3;

        }

        if($file4 != null)
        {
            $file_name4 = $file4->getClientOriginalName();

            if($file_name4 == $endorse->attach_1)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $endorse->attach_2)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $endorse->attach_4)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            $file4->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name4);

            $endorse->attach_4 = $file_name4;

        }
        $endorse->save();

        $getData = DB::table('bi_endorsements')
            ->select('type_of_endorsement_bank')
            ->where('id', $ongoing_id)
            ->get();

        return response()->json($getData);
    }

    public function bi_client_re_endorse(Request $request)
    {
        $email = new EmailQueries();
        $file1 = $request->file('file_1');
        $file2 = $request->file('file_2');
        $file3 = $request->file('file_3');
        $file4 = $request->file('file_4');

        $attachments_log = '';

        $account = new bi_endorsement();
        $account = $account::find($request->id);

        if($account->status == 21)
        {
            return 'already';
        }
        else if($account->status == 20)
        {

            $count = 1;

            if($file1 != null)
            {
                $file_name1 = $file1->getClientOriginalName();

                if($file_name1 == $account->attach_2)
                {
                    $count++;
                    $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                }

                if($file_name1 == $account->attach_3)
                {
                    $count++;
                    $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                }

                if($file_name1 == $account->attach_4)
                {
                    $count++;
                    $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                }

                $file1->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name1);

                $account->attach_1 = $file_name1;
                $attachments_log .= 'ATTACHMENT 1 : '.$file_name1.', ';
            }

            if($file2 != null)
            {
                $file_name2 = $file2->getClientOriginalName();

                if($file_name2 == $account->attach_1)
                {
                    $count++;
                    $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                }

                if($file_name2 == $account->attach_3)
                {
                    $count++;
                    $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                }

                if($file_name2 == $account->attach_4)
                {
                    $count++;
                    $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                }

                $file2->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name2);

                $account->attach_2 = $file_name2;
                $attachments_log .= 'ATTACHMENT 2 : '.$file_name2.', ';
            }

            if($file3 != null)
            {
                $file_name3 = $file3->getClientOriginalName();

                if($file_name3 == $account->attach_1)
                {
                    $count++;
                    $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                }

                if($file_name3 == $account->attach_2)
                {
                    $count++;
                    $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                }

                if($file_name3 == $account->attach_4)
                {
                    $count++;
                    $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                }

                $file3->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name3);

                $account->attach_3 = $file_name3;
                $attachments_log .= 'ATTACHMENT 3 : '.$file_name3.', ';
            }

            if($file4 != null)
            {
                $file_name4 = $file4->getClientOriginalName();

                if($file_name4 == $account->attach_1)
                {
                    $count++;
                    $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                }

                if($file_name4 == $account->attach_2)
                {
                    $count++;
                    $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                }

                if($file_name4 == $account->attach_3)
                {
                    $count++;
                    $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                }

                $file4->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name4);

                $account->attach_4 = $file_name4;
                $attachments_log .= 'ATTACHMENT 4 : '.$file_name4.', ';

            }

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'RE-ENDORSED ACCOUNT WITH '.$attachments_log;
            $logs->remarks = $request->remarks;
            $logs->save();

//            $email->ReportReturnToCC($request->id, $request->remarks, Auth::user()->id,$user->roles->first()->name);
            $account->status = 21;
            $account->date_time_re_endorse = Carbon::now('Asia/manila');
            $account->save();

            return 'ok';
        }
        else if($account->status == 22)
        {
            if($account->status != 3)
            {
                $data = DB::table('bi_endorsements')
                    ->select('date_time_return', 'date_time_re_endorse', 'date_time_due')
                    ->where('id', $request->id)
                    ->get();

                $dateFormatReturn = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_return);
                $dateFormatRe_endorse = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_re_endorse);
                $dateFormatDateTimeDue = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_due);

                $seconds = $dateFormatRe_endorse->diffInSeconds($dateFormatReturn);
                $dateFormatDateTimeDue->addSeconds($seconds);
                $dittaymdu = $data[0]->date_time_due;


                $count = 1;

                if($file1 != null)
                {
                    $file_name1 = $file1->getClientOriginalName();

                    if($file_name1 == $account->attach_2)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    if($file_name1 == $account->attach_3)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    if($file_name1 == $account->attach_4)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    $file1->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name1);

                    $account->attach_1 = $file_name1;
                    $attachments_log .= 'ATTACHMENT 1 : '.$file_name1.', ';
                }

                if($file2 != null)
                {
                    $file_name2 = $file2->getClientOriginalName();

                    if($file_name2 == $account->attach_1)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    if($file_name2 == $account->attach_3)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    if($file_name2 == $account->attach_4)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    $file2->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name2);

                    $account->attach_2 = $file_name2;
                    $attachments_log .= 'ATTACHMENT 2 : '.$file_name2.', ';
                }

                if($file3 != null)
                {
                    $file_name3 = $file3->getClientOriginalName();

                    if($file_name3 == $account->attach_1)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    if($file_name3 == $account->attach_2)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    if($file_name3 == $account->attach_4)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    $file3->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name3);

                    $account->attach_3 = $file_name3;
                    $attachments_log .= 'ATTACHMENT 3 : '.$file_name3.', ';
                }

                if($file4 != null)
                {
                    $file_name4 = $file4->getClientOriginalName();

                    if($file_name4 == $account->attach_1)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    if($file_name4 == $account->attach_2)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    if($file_name4 == $account->attach_3)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    $file4->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name4);

                    $account->attach_4 = $file_name4;
                    $attachments_log .= 'ATTACHMENT 4 : '.$file_name4.', ';

                }

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT RE-ENDORSED, DATE TIME DUE CHANGE TO <strong>'.$dateFormatDateTimeDue.'</strong> FROM <strong>'.$dittaymdu.'</strong> WITH '.$attachments_log;
                $logs->remarks = $request->remarks;
                $logs->save();


//                $email->ReportReturnToCC($request->id, $request->remarks, Auth::user()->id,$user->roles->first()->name);
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update([
                        'date_time_due' => $dateFormatDateTimeDue
                    ]);
                $account->status = 3;
                $account->date_time_re_endorse = Carbon::now('Asia/manila');
                $account->save();

                return 'ok';
            }
            else
            {
                return 'already';
            }
        }
        else if($account->status == 23)
        {
            if($account->status != 10)
            {

                $data = DB::table('bi_endorsements')
                    ->select('date_time_return', 'date_time_re_endorse', 'date_time_due')
                    ->where('id', $request->id)
                    ->get();

                $dateFormatReturn = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_return);
                $dateFormatRe_endorse = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_re_endorse);
                $dateFormatDateTimeDue = Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->date_time_due);

                $seconds = $dateFormatRe_endorse->diffInSeconds($dateFormatReturn);
                $dateFormatDateTimeDue->addSeconds($seconds);
                $dittaymdu = $data[0]->date_time_due;


                $count = 1;

                if($file1 != null)
                {
                    $file_name1 = $file1->getClientOriginalName();

                    if($file_name1 == $account->attach_2)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    if($file_name1 == $account->attach_3)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    if($file_name1 == $account->attach_4)
                    {
                        $count++;
                        $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
                    }

                    $file1->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name1);

                    $account->attach_1 = $file_name1;
                    $attachments_log .= 'ATTACHMENT 1 : '.$file_name1.', ';
                }

                if($file2 != null)
                {
                    $file_name2 = $file2->getClientOriginalName();

                    if($file_name2 == $account->attach_1)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    if($file_name2 == $account->attach_3)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    if($file_name2 == $account->attach_4)
                    {
                        $count++;
                        $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
                    }

                    $file2->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name2);

                    $account->attach_2 = $file_name2;
                    $attachments_log .= 'ATTACHMENT 2 : '.$file_name2.', ';
                }

                if($file3 != null)
                {
                    $file_name3 = $file3->getClientOriginalName();

                    if($file_name3 == $account->attach_1)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    if($file_name3 == $account->attach_2)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    if($file_name3 == $account->attach_4)
                    {
                        $count++;
                        $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
                    }

                    $file3->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name3);

                    $account->attach_3 = $file_name3;
                    $attachments_log .= 'ATTACHMENT 3 : '.$file_name3.', ';
                }

                if($file4 != null)
                {
                    $file_name4 = $file4->getClientOriginalName();

                    if($file_name4 == $account->attach_1)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    if($file_name4 == $account->attach_2)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    if($file_name4 == $account->attach_3)
                    {
                        $count++;
                        $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
                    }

                    $file4->move(storage_path('bi_attachments/'.$account->bi_id.'/'.$request->id.'/'),$file_name4);

                    $account->attach_4 = $file_name4;
                    $attachments_log .= 'ATTACHMENT 4 : '.$file_name4.', ';

                }

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT RE-ENORSED, DATE TIME DUE CHANGE TO <strong>'.$dateFormatDateTimeDue.'</strong> FROM <strong>'.$dittaymdu.'</strong> WITH '.$attachments_log;
                $logs->remarks = $request->remarks;
                $logs->save();



//                $email->ReportReturnToCC($request->id, $request->remarks, Auth::user()->id,$user->roles->first()->name);
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update([
                        'date_time_due' => $dateFormatDateTimeDue
                    ]);
                $account->status = 10;
                $account->date_time_re_endorse = Carbon::now('Asia/manila');
                $account->save();

                return 'ok';
            }
            else
            {
                return 'already';
            }


        }

    }

    public function bi_dl_report_file(Request $request)
    {
        $trims = new Trimmer();
        $id = base64_decode($request->id);
        $getPath = DB::table('bi_endorsements')
            ->select('report_file_path', 'tele_report_file_to_sao_path')
            ->where('id', $id)
            ->get();
        $user1 = DB::table('users')
            ->select('name')
            ->where('id', Auth::user()->id)
            ->get();

        if(Auth::user() != null)
        {
            if($getPath[0]->report_file_path == null)
            {
                return response("File not Available. Upload to profile.");
            }
            else
            {
                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'REPORT FILE DOWNLOADED BY ' . $trims->trims($user1[0]->name) ;
                $logs->remarks = '-';
                $logs->save();

                if(!File::exists(storage_path($getPath[0]->report_file_path)))
                {
                    return response()->download(storage_path('tele_encoder_report/'. $id . '/'. $getPath[0]->tele_report_file_to_sao_path));
                }
                else
                {
                    return response()->download(storage_path($getPath[0]->report_file_path));
                }

            }
        }
        else
        {
            return response('');
        }
    }

    public function bi_return_notif_get()
    {
        $getdata1 = DB::table('bi_account_to_users')
            ->select('return_stat', 'finished_stat')
            ->where('users_id',  Auth::user()->id)
            ->get();

        return response()->json($getdata1);
    }
    public function bi_client_update_return_stat()
    {
        DB::table('bi_account_to_users')
            ->where('users_id',  Auth::user()->id)
            ->update
            ([
                'return_stat' => 0
            ]);
    }
    public function bi_client_update_finished_stat()
    {
        DB::table('bi_account_to_users')
            ->where('users_id',  Auth::user()->id)
            ->update
            ([
                'finished_stat' => 0
            ]);
    }
    public function bi_client_get_message_notif()
    {
        $getAcc = DB::table('bi_account_to_users')
            ->select('bi_account_id', 'message_notif')
            ->where('users_id', Auth::user()->id)
            ->get();

        $getMess = DB::table('message_notif_bi')
            ->where('account_type', $getAcc[0]->bi_account_id)
            ->orderBy('id','desc')
            ->get();
        return response()->json([$getMess, $getAcc[0]->message_notif]);
    }
    public function bi_client_del_notif()
    {
        DB::table('bi_account_to_users')
            ->where('users_id', Auth::user()->id)
            ->update
            ([
                'message_notif' => 0
            ]);
        $getAcc = DB::table('bi_account_to_users')
            ->select('bi_account_id')
            ->where('users_id', Auth::user()->id)
            ->get();
        $getNotif = DB::table('bi_account_to_users')
            ->select('message_notif')
            ->where('bi_account_id', $getAcc[0]->bi_account_id)
            ->get();
        return response()->json($getNotif);
    }
    public function bi_client_check_notif()
    {
        $getNotif = DB::table('bi_account_to_users')
            ->select('message_notif')
            ->get();
        return response()->json($getNotif);
    }
    public function bi_client_change_mess_notif()
    {
        $getData = DB::table('bi_account_to_users')
            ->select('bi_account_id')
            ->where('users_id',  Auth::user()->id)
            ->get();
        DB::table('message_notif_bi')
            ->where('account_type', $getData[0]->bi_account_id)
            ->update
            ([
                'notif' => 0
            ]);
    }

    public function bi_client_get_dash()
    {
        $getAuth = Auth::user()->client_check;

        $getData = DB::table('bi_account_to_users')
            ->select('bi_account_id')
            ->where('users_id',  Auth::user()->id)
            ->get();

        $getEndorse = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->groupBy('bi_endorsements.id')

            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_account_to_users.users_id',Auth::user()->id)
            ->get();

        $getPending = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_account_to_users.users_id',Auth::user()->id)
            ->where(function ($query)
            {
                return $query->orWhere('bi_endorsements.status',1)
                    ->orWhere('bi_endorsements.status', 2)
                    ->orWhere('bi_endorsements.status', 24);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.type_of_endorsement_bank', '=',  null)
                    ->orwhere('bi_endorsements.type_of_endorsement_bank', '=' , '');
            })
            ->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
            ->get();

        $getFinished = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_account_to_users.users_id',Auth::user()->id)
            ->where('bi_endorsements.status', 10)
            ->get();


        $getReturned = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->groupBy('bi_endorsements.id')
            //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_account_to_users.users_id',Auth::user()->id)
            ->where('bi_endorsements_users.position_id', 14)
            ->where(function($query)
            {
                return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                    ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
            })
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.status',20)
                    ->orwhere('bi_endorsements.status',22)
                    ->orwhere('bi_endorsements.status',23);
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else
                {
                    return $query->where('users.client_check','=', '');
                }
            })
            ->get();

        $getHold = DB::table('bi_endorsements')
            ->where('bi_id', $getData[0]->bi_account_id)
            ->where(function ($query)
            {
                return $query->orwhere('status', 4)
                    ->orWhere('status', 5)
                    ->orwhere('cancel_bool', '=', 'Cancelled');
            })
            ->count();

        return response()->json([count($getEndorse), count($getPending) , count($getFinished) , count($getReturned), $getHold]);
    }

    public function bi_client_upload_bulk_excel(Request $request)
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
                    $reader->first();
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

                $countNull = 0;
                $storeNotNull = [];


                for($e = 0; $e < count($excel); $e++)
                {
                    for($z = 0; $z < 11; $z++)
                    {
                        if($excel[$e][$z] != null || $excel[$e][$z] != '')
                        {
//
                        }
                        else if($excel[$e][$z] == null || $excel[$e][$z] == '')
                        {
                            $countNull++;
                        }
                    }

                    if($countNull < 11)
                    {
                        array_push($storeNotNull, $e);
                    }

                    $countNull = 0;
                }

                for($i = 0; $i < count($storeNotNull); $i++)
                {
                    for($j = 0; $j < 11; $j++)
                    {
//                        $start = $i;
//                        $startSide = $j;
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

//                for($u = 0;$u < count($testnum); $u++)
//                {
//                    $rangetest = explode(':', $testnum[$u]);
//
//                    $valSplit1 = str_split($rangetest[0]);
//                    $valSplit2 = str_split($rangetest[1]);
//
//                    for($x = $start; $x < count($array) + $start;$x++ )
//                    {
//                        for($z = 0; $z < count($array[$x]); $z++)
//                        {
//                            $addx = $x + 1;
//                            if($rangetest[0] == $alph[$z + $startSide + 1].$addx)
//                            {
//                                $dodongVal = $array[$x][$z];
//                                $pormamo = $z;
//                                $startporma = $x;
//                            }
//                            if($rangetest[1] == $alph[$z + $startSide + 1].$addx)
//                            {
//                                $pormamo2 = $z;
//                                $porma2 = $x;
//                            }
//                        }
//                    }
//                    if($valSplit1[0][0] == $valSplit2[0][0])
//                    {
//                        for ($q = $startporma; $q <= $porma2; $q++) {
//                            $array[$q][$pormamo] = $dodongVal;
//                        }
//                    }
//                    else
//                    {
//                        for($t = $pormamo; $t <= $pormamo2; $t++)
//                        {
//                            $array[$startporma][$t] = $dodongVal;
//                        }
//                    }
//                }
                return response()->json([$array, 1, count($array)]);

//                return $array;
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

    public function bi_client_send_bulk_endorse(Request $request)
    {
        $data = json_decode($request->dataBulk);
        $packageCheckings = json_decode($request->packagesChecking);
        $count = $request->fileCountBulk;
        $counttoLoop = explode(',', $count);
        $arrayOfData = (array) $data;
        $arrayToInsert = [];
        $check_if_dup = [];
        $failed_endorsed = [];
        $failed_counter = 0;
        $countIns = 0;
        $arrayToEmail = [];
        $go_endorse ='';
        $i = 0;


        foreach($data as $info)
        {
            $arrayToInsert[$i] = [];
            foreach($info as $test1)
            {
                $arrayToInsert[$i][$countIns] = $test1;
                $countIns++;

            }
            $i++;
            $countIns = 0;
        }

//
//        for($i = 0 ; $i < count($arrayOfData); $i++)
//        {
//            $arrayToInsert[$i] = [];
//
//            foreach ($arrayOfData[$i] as $info)
//            {
////                foreach($info as $data1)
////                {
////
////                }
//                $arrayToInsert[$i][$countIns] = $info;
//                $countIns++;
//            }
//            $countIns = 0;
//        }

        $packageFinal = [];

        foreach($packageCheckings as $test1)
        {
            array_push($packageFinal, $test1);
        }

        $getAcct = DB::table('bi_account_list')
            ->join('bi_account_to_users', 'bi_account_to_users.bi_account_id', '=', 'bi_account_list.id')
            ->select
            ([
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as bi_loc',
                'bi_account_to_users.bi_account_id as bi_id',
            ])
            ->where('bi_account_to_users.users_id', Auth::user()->id)
            ->get();

        for($dupChekcer = 0; $dupChekcer < count($arrayToInsert); $dupChekcer++)
        {
            $birthdate = explode('-', $arrayToInsert[$dupChekcer][11]);

            $check_if_dup = DB::table('bi_endorsements')
                ->where('bi_account_name', '=', $getAcct[0]->bi_name. ' ' . $getAcct[0]->bi_loc)
                ->where('account_name', '=', $arrayToInsert[$dupChekcer][1])
                ->where('birth_day', $birthdate[2])
                ->where('birth_month', '=', $birthdate[1])
                ->where('birth_year', '=', $birthdate[0])
                ->get();

            if(count($check_if_dup) > 0)
            {
                $failed_endorsed[$failed_counter] = $arrayToInsert[$dupChekcer][1];
                $failed_counter++;
            }
        }
        if(count($failed_endorsed) <= 0)
        {
            $test_array = [];
            $go_endorse = 'go';
            for($v = 0; $v < count($arrayToInsert); $v++)
            {
                $birthdate = explode('-', $arrayToInsert[$v][11]);

                $pack = '';

                if ($packageFinal[0][$v][1] != '-')
                {
                    $getPack = explode('|--|--|', $packageFinal[0][$v][1]);
                    $pack = $getPack[1];

                }
                else if ($packageFinal[0][$v][1] == '-')
                {
                    $pack = '-';
                }

                $presentMuni = '';
                $presentProv = '';
                $permaMuni = '';
                $permaProv = '';

                if($arrayToInsert[$v][15] != "")
                {
                    $presentMuni = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$arrayToInsert[$v][15].'%')
                        ->take(1)
                        ->get();
                }

                if($arrayToInsert[$v][16] != "")
                {
                    $presentProv = DB::table('provinces')
                        ->select('id')
                        ->where('name','like', '%'.$arrayToInsert[$v][16].'%')
                        ->take(1)
                        ->get();
                }

                if($arrayToInsert[$v][18] != "")
                {
                    $permaMuni = DB::table('municipalities')
                        ->select('id')
                        ->where('muni_name','like', '%'.$arrayToInsert[$v][18].'%')
                        ->take(1)
                        ->get();
                }

                if($arrayToInsert[$v][19] != "")
                {
                    $permaProv = DB::table('provinces')
                        ->select('id')
                        ->where('name','like', '%'.$arrayToInsert[$v][19].'%')
                        ->take(1)
                        ->get();
                }

                // ENDORSEMENTS INFO

                $getId = DB::table('bi_endorsements')
                    ->insertGetId
                    ([
                        'bi_id' => $getAcct[0]->bi_id,
                        'bi_account_name' => $getAcct[0]->bi_name. ' ' . $getAcct[0]->bi_loc,
                        'project' => $arrayToInsert[$v][0],
                        'lob' => $arrayToInsert[$v][21],
                        'package' => $pack,
                        'account_name' => $arrayToInsert[$v][1],
                        'f_name' => $arrayToInsert[$v][3],
                        'm_name' => $arrayToInsert[$v][4],
                        'l_name' => $arrayToInsert[$v][2],
                        'gender' => $arrayToInsert[$v][5],
                        'marital_status' => $arrayToInsert[$v][6],
                        'birth_day' => $birthdate[2],
                        'birth_month' => $birthdate[1],
                        'birth_year' => $birthdate[0],
                        'age' =>  $arrayToInsert[$v][12],
                        'citizenship' => $arrayToInsert[$v][13],
                        'maiden_name' => $arrayToInsert[$v][7],
                        'maiden_f_name' => $arrayToInsert[$v][9],
                        'maiden_m_name' => $arrayToInsert[$v][10],
                        'maiden_l_name' => $arrayToInsert[$v][8],
                        'present_address' =>  $arrayToInsert[$v][14],
                        'present_muni' => isset($presentMuni[0]->id) ? $presentMuni[0]->id : '',
                        'present_province' => isset($presentProv[0]->id) ? $presentProv[0]->id : '',
                        'permanent_address' =>  $arrayToInsert[$v][17],
                        'permanent_muni' => isset($permaMuni[0]->id) ? $permaMuni[0]->id : '',
                        'permanent_province' => isset($permaProv[0]->id) ? $permaProv[0]->id : '',
                        'endorser_poc' =>  $arrayToInsert[$v][20],
                        'status' => 0,
                        'type_of_tat' => '-',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                for($e = 0; $e < count($packageFinal[0][$v][0]); $e++)
                {
                    $checksToInsert = explode('|--|--|', $packageFinal[0][$v][0][$e]);

                    DB::table('bi_endorsements_checkings')
                        ->insert
                        ([
                            'bi_endorsement_id' => $getId,
                            'checking_id' => '0',
                            'checking_name' => $checksToInsert[0],
                            'type_check' => $checksToInsert[1],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $user = User::find(Auth::user()->id);
                $endorse_user = new bi_endorsements_user();
                $endorse_user->bi_endorse_id = $getId;
                $endorse_user->users_id = Auth::user()->id;
                $endorse_user->position_id = $user->roles->first()->id;
                $endorse_user->save();

                $logs = new bi_log();
                $logs->endorse_id = $getId;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ENDORSED THE ACCOUNT';
//                $logs->activity = 'ENDORSED THE ACCOUNT';
                $logs->remarks = '-';
                $logs->save();


                //FILES INSERTING ARRAY

                if(((int)($counttoLoop[$v])) > 0)
                {
                    for($g = 0; $g < (int)($counttoLoop[$v]); $g++)
                    {
                        $file = $request->file('files_' . $v . '_' . $g);
                        if($file != null)
                        {
                            $filename = $file->getClientOriginalName();

//
                            $file->move(storage_path('bi_attachments/'.$getAcct[0]->bi_id.'/'.$getId.'/'),$filename);

                            DB::table('bi_endorsements')
                                ->where('id', $getId)
                                ->update
                                ([
                                    'attach_'.($g+1).'' =>  $filename = $file->getClientOriginalName()
                                ]);
                        }
                    }

                }
                else
                {

                }
//
                $arrayToEmail[$v] = ['acct_name' => $arrayToInsert[$v][0], 'acct_poc' => $arrayToInsert[$v][19], 'acct_site' => $getAcct[0]->bi_name. ' ' . $getAcct[0]->bi_loc, 'acct_date' => Carbon::now('Asia/Manila')];
//
            }

            $emailSend = new EmailQueries();
            $emailSend->cc_bulk_endorsement($arrayToEmail, count($arrayToInsert), Auth::user()->id);

            return response()->json([$arrayToEmail, $go_endorse]);
        }
        else if(count($failed_endorsed) >= 1)
        {
            $go_endorse = 'double';
            return response()->json([$failed_endorsed, $go_endorse]);
        }
    }

    public function bi_remove_attachment_logs(Request $request)
    {
        $id = $request->id;
        $remove_name = $request->get_attachment;
        $remarks = $request->remarks;
        $pang_ilang_attachment = $request->pang_ilang_attachment;


        $bi = new bi_endorsement();
        $bi = $bi::find($id);

        if($pang_ilang_attachment == '1')
        {
            File::delete(storage_path('bi_attachments/'.$bi->bi_id.'/'.$id.'/'.$bi->attach_1));

            $bi->attach_1 = '';
        }
        else if($pang_ilang_attachment == '2')
        {
            File::delete(storage_path('bi_attachments/'.$bi->bi_id.'/'.$id.'/'.$bi->attach_2));

            $bi->attach_2 = '';
        }
        else if($pang_ilang_attachment == '3')
        {
            File::delete(storage_path('bi_attachments/'.$bi->bi_id.'/'.$id.'/'.$bi->attach_3));

            $bi->attach_3 = '';
        }
        else if($pang_ilang_attachment == '4')
        {
            File::delete(storage_path('bi_attachments/'.$bi->bi_id.'/'.$id.'/'.$bi->attach_4));

            $bi->attach_4 = '';
        }

        $bi->save();

        $user = User::find(Auth::user()->id);
        $logs = new bi_log();
        $logs->endorse_id = $id;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'REMOVE ATTACHMENT:  ' . $remove_name;
        $logs->remarks = $remarks;
        $logs->save();
    }

    public function bi_client_cancel_table()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_cancel_table = [];

        if($getAuth == 'cc_bank')
        {
            $get_cancel_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.type_of_endorsement_bank as tor'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_endorsements_users.position_id',14)
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.status', 4)
                        ->orwhere('bi_endorsements.cancel_bool', '=', 'Cancelled')
                        ->orwhere('bi_endorsements.cancel_bool', '=', 'Pending Revoke');
                })
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '!=', '')
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '!=', null);
                });
        }
        else
        {
            $get_cancel_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->select([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.party_num as party_num',
                    'bi_endorsements.contract_num as contract_num',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.type_of_endorsement_bank as tor'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_endorsements_users.position_id',14)
                ->where('bi_account_to_users.users_id',Auth::user()->id)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.status', 4)
                        ->orwhere('bi_endorsements.cancel_bool', '=', 'Cancelled')
                        ->orwhere('bi_endorsements.cancel_bool', '=', 'Pending Revoke');
                })
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=', '')
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', null);
                });
        }

        return DataTables::of($get_cancel_table)
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->rawColumns([
                'check'
            ])
            ->make(true);
    }

    public function bi_client_hold_table() // is not using
    {
        $get_hold_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->leftjoin('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->select([

                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status'
            ])
            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where('bi_endorsements.status', 5);


        return DataTables::of($get_hold_table)
            ->editColumn('check', function ($query)
            {
                $get_check = DB::table('bi_endorsements_checkings')
                    ->select([
                        'checking_name',
                        'type_check'
                    ])
                    ->where('bi_endorsement_id',$query->endorse_id)
                    ->get();

                if(count($get_check) == 0)
                {
                    return 'NO CHECK';
                }
                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
                {
                    return 'N/A';
                }
                else
                {
                    $checkings = '';
                    $check_alacarte = false;
                    $get_alacarte_check = '';

                    foreach($get_check as $check)
                    {

                        if($check->type_check == 'package')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == '')
                        {
                            $checkings.= '* '.$check->checking_name.'. <br>';
                        }
                        else if($check->type_check == 'alacarte')
                        {
                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
                            $check_alacarte = true;
                        }
                    }

                    if($check_alacarte)
                    {
                        $checkings .= '<br>---( Additional Check )--- <br>';
                    }

                    return $checkings.$get_alacarte_check;
                }
            })
            ->rawColumns([
                'check'
            ])
            ->toJson();
    }

    public function bi_return_check_data(Request $request)
    {
        $checkData = '';

        $statusOfAcct = $request->status;

        if($statusOfAcct == 21 || $statusOfAcct == 0)
        {
            $data = DB::table('bi_return_checkings')
                ->where('id_checking_group', 20)
                ->get();

            for($ctr = 0; count($data) > $ctr; $ctr++)
            {

                $checkData .='<tr>
                            <td><div class="form-group form-check-label" aria-checked="false" aria-disabled="false"><input type="checkbox" value=" '.$data[$ctr]->check_name.'" class="test1 icheckbox_minimal-blue" name="" id="exampleCheck1-'.$ctr.'">
                            <label class="form-check-label" for="exampleCheck1-'.$ctr.'"> '.$data[$ctr]->check_name.'</label></div></td>
                        </tr>';
            }
            return $checkData . '<tr>
                                    <td><div class="form-group" aria-checked="false" aria-disabled="false"><input class="form-check-label icheckbox_minimal-blue othersCheck" type="checkbox" value=""name="">
                                    <label for="othersCheck"> OTHERS</label></div></td>
                            </tr>';
        }
        else if($statusOfAcct == 3)
        {
            $data1 = DB::table('bi_return_checkings')
                ->where('id_checking_group', 22)
                ->get();

            for($ctr1 = 0; count($data1) > $ctr1; $ctr1++)
            {
                $checkData .='<tr>
                            <td><div class="form-group form-check-label" aria-checked="false" aria-disabled="false"><input type="checkbox" value=" '.$data1[$ctr1]->check_name.'" class="test1 icheckbox_minimal-blue" name="" id="exampleCheck2-'.$ctr1.'">
                            <label class="form-check-label" for="exampleCheck2-'.$ctr1.'"> '.$data1[$ctr1]->check_name.'</label></div></td>
                        </tr>';
            }
            return $checkData . '<tr>
                                    <td><div class="form-group" aria-checked="false" aria-disabled="false"><input class="form-check-label othersCheck icheckbox_minimal-blue" type="checkbox" value="" id="othersCheck" name="">
                                    <label for="othersCheck"> OTHERS</label></div></td>
                            </tr>';
        }
        else if($statusOfAcct == 10)
        {
            $data2 = DB::table('bi_return_checkings')
                ->where('id_checking_group', 23)
                ->get();

            $chuchuchu = '<tr><td style="background-color: black; color: white;">UPLOAD ADDITIONAL FILE HERE</td></tr><tr><td><input type="file"></td></tr>';

            for($ctr2 = 0; count($data2) > $ctr2; $ctr2++)
            {
                if($data2[$ctr2]->check_name == 'Close Account')
                {


                    $checkData .='<tr>
                            <td>
                                <div class="form-group form-check-label" checked="false" aria-disabled="false">
                                <div class="row">
                                <div class="col-md-12">
                                                                    <input type="checkbox" value=" '.$data2[$ctr2]->check_name.'" class="test1 icheckbox_minimal-blue" name="'.$ctr2.'" id="off_exampleCheck">
                                    <label class="form-check-label" for="off_exampleCheck"> '.$data2[$ctr2]->check_name.'</label>
                                </div>
                                </div>
                                </div>
                            </td>
                        </tr>'
                        .'<tr id="needFileAdditional-off_exampleCheck" hidden><td><span id="uploadNow-off_exampleCheck"></span></td></tr>';
                }
                else if($data2[$ctr2]->check_name == 'Additional attachment')
                {
                    $checkData .='<tr>
                            <td>
                                <div class="form-group form-check-label" checked="false" aria-disabled="false">
                                    <input type="checkbox" value=" '.$data2[$ctr2]->check_name.'" class="test1 icheckbox_minimal-blue" name="'.$ctr2.'" id="add_exampleCheck">
                                    <label class="form-check-label" for="add_exampleCheck"> '.$data2[$ctr2]->check_name.'</label>
                                </div>
                            </td>
                        </tr>'
                        .'<tr id="needFileAdditional-add_exampleCheck" hidden><td><span id="uploadNow-add_exampleCheck"></span></td></tr>';
                }
                else
                {
                    $checkData .='<tr>
                            <td><div class="form-group form-check-label" checked="false" aria-disabled="false"><input type="checkbox" value="'.$data2[$ctr2]->check_name.'" class="test1 icheckbox_minimal-blue" name="" id="exampleCheck-'.$ctr2.'">
                            <label class="form-check-label" for="exampleCheck">'.$data2[$ctr2]->check_name.'</label></div></td>
                        </tr>';
                }

            }
            return $checkData . '<tr>
                                    <td><div class="form-group form-check-label" aria-checked="false" aria-disabled="false"><input class="form-check-label othersCheck icheckbox_minimal-blue" type="checkbox" value="" id="othersCheck" name="">
                                    <label for="othersCheck"> OTHERS</label></div></td>
                            </tr>';
        }
    }

    public function bi_get_return_checklist_return(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $email = new EmailQueries();
        $id = $request->id;
        $remarks = $request->remarks;
        $account = new bi_endorsement();
        $account = $account::find($request->id);


        if ($account->status == 2)
        {
            return 'already';
        }
        else if ($account->status == 10)
        {
            $bi_id = $account->bi_id;
            $bi_account_name = $account->account_name;


            DB::table('bi_account_to_users')
                ->where('bi_account_id', $bi_id)
                ->update
                ([
                    'return_stat' => 1,
                    'message_notif' => 1,
                ]);

            $getuser = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            if($request->count_add > 0) {
                for ($i = 0; $i < $request->count_add; $i++) {
                    $file = $request->file('uploadedFile_add_' . $i);
                    if ($file != null) {
                        $file_explode = explode('.',$file->getClientOriginalName());
                        $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
                        $code_date = explode('-',$code_date_time[0]);
                        $code_time = explode(':',$code_date_time[1]);
                        $name = $file_explode[0].'-'.$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2].'.'.$file_explode[1];
                        $file->move(storage_path('additional_files_bi/' . $request->id), $name);

                        DB::table('additional_files_from_bi')
                            ->insert(
                                [
                                    'file_names' => $name,
                                    'type_of_return' => 'add',
                                    'endorsement_id' => $request->id,
                                    'bi_id' => Auth::user()->id,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                    }
                }
            }

            if($request->count_off > 0) {
                for ($i = 0; $i < $request->count_off; $i++) {
                    $file = $request->file('uploadedFile_off_' . $i);
                    if ($file != null) {
                        $parts = explode('.', $file->getClientOriginalName());
                        $last = array_pop($parts);
                        $parts = array(implode('.', $parts), $last);
                        $file_name = $parts[0];

                        $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
                        $code_date = explode('-',$code_date_time[0]);
                        $code_time = explode(':',$code_date_time[1]);
                        $name = $file_name.'-'.$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2].'.'.$file->getClientOriginalExtension();
                        $file->move(storage_path('additional_files_bi/' . $request->id), $name);

                        DB::table('additional_files_from_bi')
                            ->insert(
                                [
                                    'file_names' => $name,
                                    'type_of_return' => 'off',
                                    'endorsement_id' => $request->id,
                                    'bi_id' => Auth::user()->id,
                                    'created_at' => Carbon::now('Asia/Manila')
                                ]);
                    }
                }
            }
//
//
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'date_time_return' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'RETURNED ACCOUNT PLEASE SEE REMARKS';
            $logs->remarks = $request->remarks;
            $logs->save();

            $messageNotif = new AuditQueries();
            $email->ReportReturnToCC($id, $remarks, Auth::user()->id, $user->roles->first()->name);

            $activity = 'Account name of ' . $bi_account_name . ' is returned with incomplete attachments by ' . $getuser[0]->name;
            $messageNotif->message_notif_bi($activity, $request->id, Auth::user()->id, $bi_id);


            $account->status = 24;
            $account->save();

            return 'ok';

        }
    }

    public function bi_get_reason_of_delay(Request $request)
    {
        $get_logs = DB::table('bi_logs')
            ->leftjoin('bi_endorsements','bi_endorsements.id','=','bi_logs.endorse_id')
            ->leftjoin('users','users.id','=','bi_logs.user_id')
            ->leftjoin('roles','roles.id','=','bi_logs.position_id')
            ->select([
                'bi_logs.activity as activity',
                'bi_logs.remarks as remarks',
            ])
            ->where('bi_endorsements.id',$request->id)
            ->orderBy('bi_logs.id', 'desc')
            ->take(1)
            ->get();

        return $get_logs;
    }
    public function bi_pdrn_endorse_submit(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $getAcctList = DB::table('bi_account_to_users')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->select
            ([
                'bi_account_to_users.bi_account_id as bi_id',
                'bi_account_list.bi_account_name as acct_name',
                'bi_account_list.account_location as loc'
            ])
            ->where('users_id', Auth::user()->id)
            ->get();

        $sitename = $removeScript->scripttrim($getAcctList[0]->acct_name) . ' ' . $removeScript->scripttrim($getAcctList[0]->loc);

//        $maidenname = $removeScript->scripttrim($request->acct_maiden_last_name) . ', ' . $removeScript->scripttrim($request->acct_maiden_first_name) . ' ' . $removeScript->scripttrim($request->acct_maiden_middle_name);

        $cob_data = $request->cob_array;

        $endorseId = DB::table('bi_endorsements')
            ->insertGetId
            ([
                'party_num' => $removeScript->scripttrim($request->party_num),
                'contract_num' => $removeScript->scripttrim($request->contract_num),
                'bi_id' => $getAcctList[0]->bi_id,
                'type_of_endorsement_bank' => 'PDRN',
                'bi_account_name' => $sitename,
                'project' => $sitename,
                'lob' => 'N/A',
                'package' => '-',
                'account_name' => $removeScript->scripttrim($request->acct_last) . ', ' . $removeScript->scripttrim($request->acct_first) . ' ' . $removeScript->scripttrim($request->acct_middle),
                'f_name' => $removeScript->scripttrim($request->acct_first),
                'm_name' => $removeScript->scripttrim($request->acct_middle),
                'l_name' => $removeScript->scripttrim($request->acct_last),
                'suffix' => '',
                'gender' => '',
                'marital_status' => '',
                'birth_day' =>'',
                'birth_month' => '',
                'birth_year' => '',
                'age' => '',
                'citizenship' => '',
                'maiden_name' => '',
                'maiden_f_name' => '',
                'maiden_m_name' => '',
                'maiden_l_name' => '',
                'present_address' => '',
                'present_muni' =>'',
                'present_province' => '',
                'permanent_address' => '',
                'permanent_muni' => '',
                'permanent_province' => '',
                'endorser_poc' => $removeScript->scripttrim($request->acct_endorsedby),
                'status' => '0',
                'created_at' => Carbon::now('Asia/Manila'),
                'client_remarks_bank' => $removeScript->scripttrim($request->client_remarks),
                'cc_bank_endorsement_type' => $request->type_endo
            ]);
//        if($cob_data != '')
//        {
//            for($i = 0 ; $i < count($cob_data) ; $i++)
//            {
//                DB::table('bi_endorsement_cob_pdrn')
//                    ->insert
//                    ([
//                        'bi_id' => $endorseId,
//                        'f_name' => $cob_data[$i][2],
//                        'm_name' => $cob_data[$i][3],
//                        'l_name' => $cob_data[$i][4],
//                        'present_address' => $cob_data[$i][5],
//                        'present_muni' => $cob_data[$i][6],
//                        'present_prov' => $cob_data[$i][7],
//                        'perma_address' => $cob_data[$i][8],
//                        'perma_muni' => $cob_data[$i][9],
//                        'perma_prov' => $cob_data[$i][10],
//                        'created_at' => Carbon::now('Asia/Manila'),
//                        'relationship_subject' => $cob_data[$i][0],
//                        'other_relationship_subject' => $cob_data[$i][1]
//                    ]);
//            }
//        }
//        else
//        {
//
//        }

        DB::table('bi_endorsements_checkings')
            ->insert
            ([
                'bi_endorsement_id' => $endorseId,
                'checking_id' => '0',
                'checking_name' => 'N/A',
                'type_check' => 'N/A',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        $user = User::find(Auth::user()->id);
        $endorse_user = new bi_endorsements_user();
        $endorse_user->bi_endorse_id = $endorseId;
        $endorse_user->users_id = Auth::user()->id;
        $endorse_user->position_id = $user->roles->first()->id;
        $endorse_user->save();

        $logs = new bi_log();
        $logs->endorse_id = $endorseId;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'ENDORSED THE ACCOUNT(PDRN)';
        $logs->remarks = '-';
        $logs->save();

        return response()->json(['proceed_to_upload', $endorseId]);
    }

    public function bi_client_bvr_endorse_submit(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $getAcctList = DB::table('bi_account_to_users')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->select
            ([
                'bi_account_to_users.bi_account_id as bi_id',
                'bi_account_list.bi_account_name as acct_name',
                'bi_account_list.account_location as loc'
            ])
            ->where('users_id', Auth::user()->id)
            ->get();
        $sitename = $getAcctList[0]->acct_name . ' ' . $getAcctList[0]->loc;
        $cob_data = $request->cob_array;

        $endorseId = DB::table('bi_endorsements')
            ->insertGetId
            ([
                'party_num' => $removeScript->scripttrim($request->party_num),
                'contract_num' => $removeScript->scripttrim($request->contract_num),
                'bi_id' => $getAcctList[0]->bi_id,
                'type_of_endorsement_bank' => 'BVR',
                'bi_account_name' => $sitename,
                'project' => $sitename,
                'lob' => 'N/A',
                'package' => '-',
                'account_name' => $removeScript->scripttrim($request->acct_lname) . ', ' . $removeScript->scripttrim($request->acct_fname) . ' ' .  $removeScript->scripttrim($request->acct_mname),
                'f_name' => $removeScript->scripttrim($request->acct_fname),
                'm_name' => $removeScript->scripttrim($request->acct_mname),
                'l_name' => $removeScript->scripttrim($request->acct_lname),
//                'suffix' => 'N/A',
//                'gender' => '',
//                'marital_status' => '',
//                'birth_day' => '',
//                'birth_month' => '',
//                'birth_year' => '',
//                'age' => '',
//                'citizenship' => '',
//                'maiden_name' => ', ',
//                'maiden_f_name' => '',
//                'maiden_m_name' => '',
//                'maiden_l_name' => '',
//                'present_address' => $removeScript->scripttrim($request->present_address),
//                'present_muni' => $removeScript->scripttrim($request->present_muni),
//                'present_province' => $request->present_prov,
//                'permanent_address' => $removeScript->scripttrim($request->perma_address),
//                'permanent_muni' => $request->perma_muni,
//                'permanent_province' => $request->perma_prov,


                'suffix' => 'N/A',
                'gender' => '',
                'marital_status' => '',
                'birth_day' => '',
                'birth_month' => '',
                'birth_year' => '',
                'age' => '',
                'citizenship' => '',
                'maiden_name' => ', ',
                'maiden_f_name' => '',
                'maiden_m_name' => '',
                'maiden_l_name' => '',
                'present_address' => '',
                'present_muni' => '',
                'present_province' => '',
                'permanent_address' => '',
                'permanent_muni' => '',
                'permanent_province' => '',

                'endorser_poc' => $removeScript->scripttrim($request->requestor_name),
                'status' => '0',
                'created_at' => Carbon::now('Asia/Manila'),
//                'loan_type_bank' => $request->loan_type,
//                'priority_type_bank' => $request->prio_type,
//                'verify_through_bank' => $request->verify_through,
                'client_remarks_bank' => $removeScript->scripttrim($request->requestor_name),
                'cc_bank_endorsement_type' => $request->type_endo
            ]);

        if($cob_data != '')
        {
            for($i = 0 ; $i < count($cob_data) ; $i++)
            {
                DB::table('bi_endorsement_bvr_business')
                    ->insert
                    ([
                        'bi_id' => $endorseId,
                        'business_name' => $cob_data[$i][0],
                        'business_address' => $cob_data[$i][1],
                        'business_muni' => $cob_data[$i][2],
                        'business_prov' => $cob_data[$i][3],
                        'created_at' => Carbon::now('Asia/Manila'),
                    ]);
            }
        }



        DB::table('bi_endorsements_checkings')
            ->insert
            ([
                'bi_endorsement_id' => $endorseId,
                'checking_id' => '0',
                'checking_name' => 'N/A',
                'type_check' => 'N/A',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        $user = User::find(Auth::user()->id);
        $endorse_user = new bi_endorsements_user();
        $endorse_user->bi_endorse_id = $endorseId;
        $endorse_user->users_id = Auth::user()->id;
        $endorse_user->position_id = $user->roles->first()->id;
        $endorse_user->save();

        $logs = new bi_log();
        $logs->endorse_id = $endorseId;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'ENDORSED THE ACCOUNT(BVR)';
        $logs->remarks = '-';
        $logs->save();

        return response()->json(['proceed_to_upload', $endorseId]);
    }

    public function bi_client_evr_submit_endorse(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $getAcctList = DB::table('bi_account_to_users')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->select
            ([
                'bi_account_to_users.bi_account_id as bi_id',
                'bi_account_list.bi_account_name as acct_name',
                'bi_account_list.account_location as loc'
            ])
            ->where('users_id', Auth::user()->id)
            ->get();
        $sitename = $getAcctList[0]->acct_name . ' ' . $getAcctList[0]->loc;
        $cob_data = $request->cob_array;

        $endorseId = DB::table('bi_endorsements')
            ->insertGetId
            ([
                'party_num' => $removeScript->scripttrim($request->party_num),
                'contract_num' => $removeScript->scripttrim($request->contract_num),
                'bi_id' => $getAcctList[0]->bi_id,
                'type_of_endorsement_bank' => 'EVR',
                'bi_account_name' => $sitename,
                'project' => $sitename,
                'lob' => 'N/A',
                'package' => '-',
                'account_name' => $removeScript->scripttrim($request->acct_lname) . ', ' . $removeScript->scripttrim($request->acct_fname) . ' ' .$removeScript->scripttrim($request->acct_mname),
                'f_name' => $removeScript->scripttrim($request->acct_fname),
                'm_name' => $removeScript->scripttrim($request->acct_mname),
                'l_name' => $removeScript->scripttrim($request->acct_lname),
//                'suffix' => 'N/A',
//                'gender' => '',
//                'marital_status' => '',
//                'birth_day' => '',
//                'birth_month' => '',
//                'birth_year' => '0',
//                'age' => '',
//                'citizenship' => '',
//                'maiden_name' => ', ',
//                'maiden_f_name' => '',
//                'maiden_m_name' => '',
//                'maiden_l_name' => '',
//                'present_address' => $removeScript->scripttrim($request->present_address) ,
//                'present_muni' => $removeScript->scripttrim($request->present_muni) ,
//                'present_province' => $request->present_prov,
//                'permanent_address' => $removeScript->scripttrim($request->perma_address) ,
//                'permanent_muni' => $removeScript->scripttrim($request->perma_muni),
//                'permanent_province' => $request->perma_prov,

                'suffix' => 'N/A',
                'gender' => '',
                'marital_status' => '',
                'birth_day' => '',
                'birth_month' => '',
                'birth_year' => '0',
                'age' => '',
                'citizenship' => '',
                'maiden_name' => ', ',
                'maiden_f_name' => '',
                'maiden_m_name' => '',
                'maiden_l_name' => '',
                'present_address' => '',
                'present_muni' => '',
                'present_province' => '',
                'permanent_address' => '',
                'permanent_muni' => '',
                'permanent_province' => '',
                'endorser_poc' => $removeScript->scripttrim($request->requestor_name) ,
                'status' => '0',
                'created_at' => Carbon::now('Asia/Manila'),
//                'loan_type_bank' => $request->loan_type,
//                'priority_type_bank' => $request->prio_type,
//                'verify_through_bank' => $request->verify_through,
                'client_remarks_bank' => $removeScript->scripttrim($request->requestor_name),
                'cc_bank_endorsement_type' => $request->type_endo
            ]);

        if($cob_data != '')
        {
            for($i = 0; $i < count($cob_data); $i++)
            {
                DB::table('bi_endorsement_evr_employer')
                    ->insert
                    ([
                        'bi_id' => $endorseId,
                        'emp_name' => $cob_data[$i][0],
                        'emp_address' => $cob_data[$i][1],
                        'emp_muni' => $cob_data[$i][2],
                        'emp_prov' => $cob_data[$i][3],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        DB::table('bi_endorsements_checkings')
            ->insert
            ([
                'bi_endorsement_id' => $endorseId,
                'checking_id' => '0',
                'checking_name' => 'N/A',
                'type_check' => 'N/A',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        $user = User::find(Auth::user()->id);
        $endorse_user = new bi_endorsements_user();
        $endorse_user->bi_endorse_id = $endorseId;
        $endorse_user->users_id = Auth::user()->id;
        $endorse_user->position_id = $user->roles->first()->id;
        $endorse_user->save();

        $logs = new bi_log();
        $logs->endorse_id = $endorseId;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'ENDORSED THE ACCOUNT(EVR)';
        $logs->remarks = '-';
        $logs->save();

        return response()->json(['proceed_to_upload', $endorseId]);
    }

    public function bi_client_additional_files_any(Request $request)
    {
        $id = $request->id;

        $file = $request->file('file');

        if ($file != null)
        {

            $parts = explode('.', $file->getClientOriginalName());
            $last = array_pop($parts);
            $parts = array(implode('.', $parts), $last);
            $file_name = $parts[0];
            $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
            $code_date = explode('-',$code_date_time[0]);
            $code_time = explode(':',$code_date_time[1]);
            $name = $file_name.'-'.$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2].'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('additional_files_bi/' . $id), $name);

            $getId = DB::table('additional_files_from_bi')
                ->insertGetId
                (
                    [
                        'file_names' => $name,
                        'type_of_return' => 'any',
                        'endorsement_id' => $id,
                        'bi_id' => Auth::user()->id,
                        'created_at' => Carbon::now('Asia/Manila'),
                        'bi_add_rem' => 'No indicated remarks'
                    ]);

            $user = User::find(Auth::user()->id);
            $getLogID = DB::table('bi_logs')
                ->insertGetId
                ([
                    'endorse_id' => $id,
                    'user_id' => Auth::user()->id,
                    'position_id' => $user->roles->first()->id,
                    'activity' => 'ADDED ADDITIONAL FILE WITH FILE NAME, ' . strtoupper($name),
                    'remarks' => '-',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return response()->json([$getId, $getLogID]);
        }
    }

    public function bi_client_add_rem_add_files_new(Request $request)
    {
        DB::table('additional_files_from_bi')
            ->where('id', $request->add_id)
            ->update
            ([
                'bi_add_rem' => $request->rem
            ]);

        DB::table('bi_logs')
            ->where('id', $request->log_id)
            ->update
            ([
                'remarks' => $request->rem,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function bi_client_multiple_dl(Request $request)
    {
        $trims = new Trimmer();
        $headers = ["Content-Type"=>"application/zip"];

        $code_date_time = explode(' ',Carbon::now('Asia/Manila'));
        $code_date = explode('-',$code_date_time[0]);
        $code_time = explode(':',$code_date_time[1]);

        $fileName = Auth::user()->id."-finished-files-".$code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2]. ".zip";

        $ids = explode(',', $request->id);


        for($i = 0; $i < count($ids); $i++)
        {
            $getID = DB::table('bi_endorsements')
                ->select('report_file_path')
                ->where('id', $ids[$i])
                ->get();

            Zipper::make(storage_path('/endorsement_client_report/'.$fileName))
                ->add(storage_path().$getID[0]->report_file_path)
                ->close();

            $user1 = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $ids[$i];
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'REPORT FILE DOWNLOADED BY ' . $trims->trims($user1[0]->name) ;
            $logs->remarks = '-';
            $logs->save();
        }

        return response()
            ->download(storage_path('/endorsement_client_report/'.$fileName),$fileName, $headers)
            ->deleteFileAfterSend(true);
    }

    public function bi_client_get_pending_applicants()
    {
//        $getBIid = DB::table('users')
//            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
//            ->select([
//                'bi_account_to_users.bi_account_id as bi_account_id'
//            ])
//            ->where('users.id', Auth::user()->id)
//            ->get();

        $get_pending_applicants = DB::table('bi_direct_pivot')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_direct_pivot.bi_id')
            ->join('bi_account_list','bi_account_list.id','=','bi_account_to_users.bi_account_id')
            ->join('users','users.id','=','bi_account_to_users.users_id')
            ->select([
                'bi_direct_pivot.id as id',
                'bi_direct_pivot.bi_id as bi_id',
                'bi_direct_pivot.created_at as created_at',
                'bi_direct_pivot.direct_status as direct_status',
                'bi_direct_pivot.direct_type as direct_type',
                'bi_direct_pivot.direct_name as direct_name',
                'bi_direct_pivot.direct_to_get_id as direct_to_get_id',
                'bi_account_list.bi_account_name as bi_account_name',
                'bi_account_list.account_location as account_location',
                'bi_direct_pivot.application_status as application_status'
            ])
//            ->where('bi_direct_pivot.bi_id',$getBIid[0]->bi_account_id)
            ->where('bi_direct_pivot.application_status', '!=', 'Cancelled')
            ->where('users.id',Auth::user()->id)
            ->where('bi_direct_pivot.direct_status', 0);

//        $get_pending_applicants = DB::table('bi_direct_encoded_data')
//            ->select([
//                'bi_direct_encoded_data.id as id',
//                'bi_direct_encoded_data.created_at as date_time_endorse',
//                'bi_direct_encoded_data.accnt_fname as accnt_fname',
//                'bi_direct_encoded_data.accnt_surname as accnt_surname',
//                'bi_direct_encoded_data.accnt_mname as accnt_mname',
//                'bi_direct_encoded_data.attach1 as attach1',
//                'bi_direct_encoded_data.attach2 as attach2',
//                'bi_direct_encoded_data.attach3 as attach3',
//                'bi_direct_encoded_data.attach4 as attach4',
//                'bi_direct_encoded_data.status as status',
//            ])
//            ->where('bi_direct_encoded_data.bi_id', $getBIid[0]->bi_id)
//            ->where('status', 0);

        return DataTables::of($get_pending_applicants)
            ->editColumn('attachments', function ($query)
            {
                if($query->direct_type == 'direct_applicant')
                {
                    $showmodAdd = '';

                    $getAttachDirect = DB::table('bi_direct_applicant_endorsement')
                        ->select
                        ([
                            'direct_attach_1',
                            'direct_attach_2',
                            'direct_attach_3',
                            'direct_attach_4'
                        ])
                        ->where('id', $query->direct_to_get_id)
                        ->get();

                    $getCountAdditional = DB::table('bi_direct_applicant_additional_files')
                        ->where('direct_id', $query->direct_to_get_id)
                        ->count();

                    if($getCountAdditional > 0)
                    {
                        $showmodAdd = '<button class="btn btn-xs btn-success btn-block btnShowAdditionalfilesDirect" name="'.base64_encode($query->id).'" ><i class="fa fa-eye"></i> Show Additional Files</button>';
                    }
                    else
                    {
                        $showmodAdd = '';
                    }



                    if(count($getAttachDirect) == 0)
                    {
                        return 'NO ATTACHMENT';
                    }
                    else
                    {
                        $downloads = '';

                        if($getAttachDirect[0]->direct_attach_1 != '')
                        {
                            $downloads .= '1. '.$getAttachDirect[0]->direct_attach_1.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="1" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_1).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>1. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_2 != '')
                        {
                            $downloads .= '2. '.$getAttachDirect[0]->direct_attach_2.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="2" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_2).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>2. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_3 != '')
                        {
                            $downloads .= '3. '.$getAttachDirect[0]->direct_attach_3.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="3" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_3).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>3. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_4 != '')
                        {
                            $downloads .= '4. '.$getAttachDirect[0]->direct_attach_4.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="4" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_4).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>4. none</p>';
                        }
                        return $downloads . $showmodAdd;
                    }
                }
                else if($query->direct_type == 'Concentrix')
                {
                    $get_attachment = DB::table('bi_direct_encoded_data')
                        ->select([
                            'bi_direct_encoded_data.attach1 as attach1',
                            'bi_direct_encoded_data.attach2 as attach2',
                            'bi_direct_encoded_data.attach3 as attach3',
                            'bi_direct_encoded_data.attach4 as attach4',
                        ])
                        ->where('id', $query->direct_to_get_id)
                        ->get();

                    if(count($get_attachment) == 0)
                    {
                        return 'NO ATTACHMENT';
                    }
                    else
                    {
                        $downloads = '';

                        if($get_attachment[0]->attach1 != '')
                        {
                            $downloads .= '1. '.$get_attachment[0]->attach1.'<br><a class="btn btn-xs btn-info btn-block"  id="'.$query->direct_to_get_id.'" name="1" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach1).'/d_concen"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>1. none</p>';
                        }

                        if($get_attachment[0]->attach2 != '')
                        {
                            $downloads .= '2. '.$get_attachment[0]->attach2.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="2" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach2).'/d_concen"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>2. none</p>';
                        }

                        if($get_attachment[0]->attach3 != '')
                        {
                            $downloads .= '3. '.$get_attachment[0]->attach3.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="3" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach3).'/d_concen"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>3. none</p>';
                        }

                        if($get_attachment[0]->attach4 != '')
                        {
                            $downloads .= '4. '.$get_attachment[0]->attach4.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="4" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach4).'d_concen"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>4. none</p>';
                        }
                        return $downloads;
                    }
                }
            })
            ->rawColumns([
                'attachments'
            ])
            ->make(true);
//            ->rawColumns([
//                'attachments'
//            ])
//            ->toJson();
    }

    public function bi_client_get_cancelled_applicants()
    {
        $getBIid = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->select([
                'bi_account_to_users.bi_account_id as bi_id'
            ])
            ->where('users.id', Auth::user()->id)
            ->where('bi_account_to_users.to_display', 'display')
            ->get();

        $get_pending_applicants = DB::table('bi_direct_pivot')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_direct_pivot.bi_id')
            ->join('bi_account_list','bi_account_list.id','=','bi_account_to_users.bi_account_id')
            ->join('users','users.id','=','bi_account_to_users.users_id')
            ->select([
                'bi_direct_pivot.id as id',
                'bi_direct_pivot.bi_id as bi_id',
                'bi_direct_pivot.created_at as created_at',
                'bi_direct_pivot.direct_status as direct_status',
                'bi_direct_pivot.direct_type as direct_type',
                'bi_direct_pivot.direct_name as direct_name',
                'bi_direct_pivot.direct_to_get_id as direct_to_get_id',
                'bi_account_list.bi_account_name as bi_account_name',
                'bi_account_list.account_location as account_location',
                'bi_direct_pivot.application_status as application_status'
            ])
//            ->where('bi_direct_pivot.bi_id',$getBIid[0]->bi_account_id)
            ->where('bi_direct_pivot.application_status', '=', 'Cancelled')
            ->where('users.id',Auth::user()->id)
            ->where('bi_direct_pivot.direct_status', 0);

//        $get_pending_applicants = DB::table('bi_direct_encoded_data')
//            ->select([
//                'bi_direct_encoded_data.id as id',
//                'bi_direct_encoded_data.created_at as date_time_endorse',
//                'bi_direct_encoded_data.accnt_fname as accnt_fname',
//                'bi_direct_encoded_data.accnt_surname as accnt_surname',
//                'bi_direct_encoded_data.accnt_mname as accnt_mname',
//                'bi_direct_encoded_data.attach1 as attach1',
//                'bi_direct_encoded_data.attach2 as attach2',
//                'bi_direct_encoded_data.attach3 as attach3',
//                'bi_direct_encoded_data.attach4 as attach4',
//                'bi_direct_encoded_data.status as status',
//            ])
//            ->where('bi_direct_encoded_data.bi_id', $getBIid[0]->bi_id)
//            ->where('status', 0);

        return DataTables::of($get_pending_applicants)
            ->editColumn('attachments', function ($query)
            {
                if($query->direct_type == 'direct_applicant')
                {
                    $getAttachDirect = DB::table('bi_direct_applicant_endorsement')
                        ->select
                        ([
                            'direct_attach_1',
                            'direct_attach_2',
                            'direct_attach_3',
                            'direct_attach_4'
                        ])
                        ->where('id', $query->direct_to_get_id)
                        ->get();

                    if(count($getAttachDirect) == 0)
                    {
                        return 'NO ATTACHMENT';
                    }
                    else
                    {
                        $downloads = '';

                        if($getAttachDirect[0]->direct_attach_1 != '')
                        {
                            $downloads .= '1. '.$getAttachDirect[0]->direct_attach_1.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="1" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_1).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>1. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_2 != '')
                        {
                            $downloads .= '2. '.$getAttachDirect[0]->direct_attach_2.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="2" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_2).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>2. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_3 != '')
                        {
                            $downloads .= '3. '.$getAttachDirect[0]->direct_attach_3.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="3" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_3).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>3. none</p>';
                        }

                        if($getAttachDirect[0]->direct_attach_4 != '')
                        {
                            $downloads .= '4. '.$getAttachDirect[0]->direct_attach_4.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="4" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($getAttachDirect[0]->direct_attach_4).'/d_direct" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
                        }
                        else
                        {
                            $downloads .='<p>4. none</p>';
                        }
                        return $downloads;
                    }
                }
                else if($query->direct_type == 'Concentrix')
                {
                    $get_attachment = DB::table('bi_direct_encoded_data')
                        ->select([
                            'bi_direct_encoded_data.attach1 as attach1',
                            'bi_direct_encoded_data.attach2 as attach2',
                            'bi_direct_encoded_data.attach3 as attach3',
                            'bi_direct_encoded_data.attach4 as attach4',
                        ])
                        ->where('id', $query->direct_to_get_id)
                        ->get();

                    if(count($get_attachment) == 0)
                    {
                        return 'NO ATTACHMENT';
                    }
                    else
                    {
                        $downloads = '';

                        if($get_attachment[0]->attach1 != '')
                        {
                            $downloads .= '1. '.$get_attachment[0]->attach1.'<br><a class="btn btn-xs btn-info btn-block"  id="'.$query->direct_to_get_id.'" name="1" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach1).'/d_concen"><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                        }
                        else
                        {
                            $downloads .='<p>1. none</p>';
                        }

                        if($get_attachment[0]->attach2 != '')
                        {
                            $downloads .= '2. '.$get_attachment[0]->attach2.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="2" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach2).'/d_concen"><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                        }
                        else
                        {
                            $downloads .='<p>2. none</p>';
                        }

                        if($get_attachment[0]->attach3 != '')
                        {
                            $downloads .= '3. '.$get_attachment[0]->attach3.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="3" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach3).'/d_concen"><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                        }
                        else
                        {
                            $downloads .='<p>3. none</p>';
                        }

                        if($get_attachment[0]->attach4 != '')
                        {
                            $downloads .= '4. '.$get_attachment[0]->attach4.'<br><a class="btn btn-xs btn-info btn-block" id="'.$query->direct_to_get_id.'" name="4" href="get_encoded_file/'.base64_encode($query->direct_to_get_id).'/'.base64_encode($get_attachment[0]->attach4).'d_concen"><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
                        }
                        else
                        {
                            $downloads .='<p>4. none</p>';
                        }
                        return $downloads;
                    }
                }
            })
            ->rawColumns([
                'attachments'
            ])
            ->make(true);
//            ->rawColumns([
//                'attachments'
//            ])
//            ->toJson();
    }

//     public function bi_endorse_encoded_account(Request $request)
//     {
//         $scripttrom = new ScriptTrimmer();
//         $trimmer = new Trimmer();

//         $getBIid = DB::table('users')
//             ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
//             ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
//             ->select
//             ([
//                 'bi_account_to_users.bi_account_id as bi_id',
//                 'bi_account_list.bi_account_name as bi_name',
//                 'bi_account_list.account_location as bi_loc',
//             ])
//             ->where('users.id', Auth::user()->id)
//             ->where('bi_account_to_users.to_display', 'display')
//             ->get();

//         $getInfo = [];

//         $getPivot = DB::table('bi_direct_pivot')
//             ->select('direct_to_get_id')
//             ->where('id', $request->id)
//             ->get();


//         if($request->type == 'Concentrix')
//         {
//             $getInfo = DB::table('bi_direct_encoded_data')
//                 ->where('id', $getPivot[0]->direct_to_get_id)
//                 ->get();

//             $splittedBday = explode('-', $getInfo[0]->accnt_bday);

//             $endorse_id = DB::table('bi_endorsements')
//                 ->insertGetId([
//                     'bi_id' => $getBIid[0]->bi_id,
//                     'bi_account_name' => $bi_name,
//                     'lob' => $request->accnt_lob,
//                     'endorser_poc' => $scripttrom->scripttrim($request->endorser_name),
//                     'package' => $request->package,
//                     'project' => $scripttrom->scripttrim($request->accnt_project_name),
//                     'account_name' => $getInfo[0]->accnt_surname. ', ' . $getInfo[0]->accnt_fname . ' ' . $getInfo[0]->accnt_mname,
//                     'f_name' => $getInfo[0]->accnt_fname,
//                     'm_name' => $getInfo[0]->accnt_mname,
//                     'l_name' => $getInfo[0]->accnt_surname,
//                     'suffix' => $getInfo[0]->accnt_suffix,
//                     'gender' => $getInfo[0]->accnt_gender,
//                     'marital_status' => $getInfo[0]->accnt_civil_status,
//                     'birth_day' => $splittedBday[2],
//                     'birth_month' => $splittedBday[1],
//                     'birth_year' => $splittedBday[0],
//                     'age' => $getInfo[0]->accnt_age,
//                     'present_address' => $getInfo[0]->accnt_present_add,
//                     'present_province' => $getInfo[0]->accnt_present_mun_id,
//                     'present_muni' => $getInfo[0]->accnt_present_prov_id,
//                     'permanent_address' => $getInfo[0]->accnt_permanent_add,
//                     'permanent_province' => $getInfo[0]->accnt_permanent_mun_id,
//                     'permanent_muni' => $getInfo[0]->accnt_permanent_prov_id,
// //                    'attach_1' => $getInfo[0]->attach1,
// //                    'attach_2' => $getInfo[0]->attach2,
// //                    'attach_3' => $getInfo[0]->attach3,
// //                    'attach_4' => $getInfo[0]->attach4,
//                     'status' => 0,
//                     'created_at' => Carbon::now('Asia/Manila')
//                 ]);

//             if(!file_exists(storage_path('bi_attachments/'.$getBIid[0]->bi_id)))
//             {
//                 File::makeDirectory(storage_path('bi_attachments/'.$getBIid[0]->bi_id));
//             }

//             if(!file_exists(storage_path('bi_attachments/'.$getBIid[0]->bi_id.'/'.$endorse_id)))
//             {
//                 File::makeDirectory(storage_path('bi_attachments/'.$getBIid[0]->bi_id.'/'.$endorse_id));
//             }

//             if($getInfo[0]->attach1 != '' || $getInfo[0]->attach1 != null)
//             {
//                 if(file_exists(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach1)))
//                 {
//                     File::move(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach1) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach1));
//                 }

//                 DB::table('bi_endorsements')
//                     ->where('id', '=', $endorse_id)
//                     ->update
//                     ([
//                         'attach_1' => $getInfo[0]->attach1
//                     ]);
//             }

//             if($getInfo[0]->attach2 != '' || $getInfo[0]->attach2 != null)
//             {
//                 if(file_exists(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach2)))
//                 {
//                     File::move(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach2) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach2));
//                 }

//                 DB::table('bi_endorsements')
//                     ->where('id', '=', $endorse_id)
//                     ->update
//                     ([
//                         'attach_2' => $getInfo[0]->attach2
//                     ]);
//             }

//             if($getInfo[0]->attach3 != '' || $getInfo[0]->attach3 != null)
//             {
//                 if(file_exists(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach3)))
//                 {
//                     File::move(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach3) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach3));
//                 }

//                 DB::table('bi_endorsements')
//                     ->where('id', '=', $endorse_id)
//                     ->update
//                     ([
//                         'attach_3' => $getInfo[0]->attach3
//                     ]);

//             }

//             if($getInfo[0]->attach4 != '' || $getInfo[0]->attach4 != null)
//             {
//                 if(file_exists(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach4)))
//                 {
//                     File::move(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach4) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'.$endorse_id.'/'.$getInfo[0]->attach4));
//                 }

//                 DB::table('bi_endorsements')
//                     ->where('id', '=', $endorse_id)
//                     ->update
//                     ([
//                         'attach_4' => $getInfo[0]->attach4
//                     ]);
//             }

//             $user = User::find(Auth::user()->id);
//             $endorse_user = new bi_endorsements_user();
//             $endorse_user->bi_endorse_id = $endorse_id;
//             $endorse_user->users_id = Auth::user()->id;
//             $endorse_user->position_id = $user->roles->first()->id;
//             $endorse_user->save();

// //            File::deleteDirectory(storage_path('bi_attachments_direct/'.$getBIid[0]->bi_id.'/'.$getPivot[0]->direct_to_get_id));

//             if(count($request->checking) != 0)
//             {
//                 $i = 0;

//                 for($i = 0; $i < count($request->checking); $i++)
//                 {
//                     DB::table('bi_endorsements_checkings')
//                         ->insert([
//                             'bi_endorsement_id' => $endorse_id,
//                             'checking_id' => 0,
//                             'checking_name' => $request->checking[$i][0],
//                             'type_check' => $request->checking[$i][1],
//                             'created_at' => Carbon::now('Asia/Manila')
//                         ]);
//                 }
//             }

//             DB::table('bi_direct_encoded_data')
//                 ->where('id',  $getPivot[0]->direct_to_get_id)
//                 ->update
//                 ([
//                     'status' => '1'
//                 ]);

//             DB::table('bi_direct_pivot')
//                 ->where('id', $request->id)
//                 ->update
//                 ([
//                     'direct_status' => '1',
//                     'endorse_id' => $endorse_id
//                 ]);

//             $email = new EmailQueries();
//             $trimmer = new Trimmer();
//             $account4EmailName = $trimmer->trims($getInfo[0]->accnt_surname).', '.$trimmer->trims($getInfo[0]->accnt_fname).' '.$trimmer->trims($getInfo[0]->accnt_mname);
//             $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);

//             $logs = new bi_log();
//             $logs->endorse_id = $endorse_id;
//             $logs->user_id = Auth::user()->id;
//             $logs->position_id = $user->roles->first()->id;
//             $logs->activity = 'ENDORSED THE ACCOUNT';
//             $logs->remarks = '-';
//             $logs->save();
//         }
//         else if($request->type == 'direct_applicant')
//         {
//             $getNIName = DB::table('bi_account_list')
//                 ->where('bi_account_list.id', $getBIid[0]->bi_id)
//                 ->select([
//                     'bi_account_list.bi_account_name as bi_name',
//                     'bi_account_list.account_location as loc'
//                 ])
//                 ->get();

//             $bi_name = $getNIName[0]->bi_name . ' ' . $getNIName[0]->loc;

//             $getInfo1 = DB::table('bi_direct_applicant_endorsement')
//                 ->where('id', $getPivot[0]->direct_to_get_id)
//                 ->get();

//             $splittedBday1 = explode('-', $getInfo1[0]->direct_birthdate);

//             $checkSame = DB::table('bi_endorsements')
//                 ->where('bi_account_name', $getBIid[0]->bi_name. ' ' . $getBIid[0]->bi_loc)
//                 ->where('bi_id', $getBIid[0]->bi_id)
//                 ->where('f_name', $trimmer->trims($getInfo1[0]->direct_first_name))
//                 ->where('m_name', $trimmer->trims($getInfo1[0]->direct_middle_name))
//                 ->where('l_name', $trimmer->trims($getInfo1[0]->direct_last_name))
//                 ->where('birth_day', $trimmer->trims($splittedBday1[2]))
//                 ->where('birth_month', $trimmer->trims($splittedBday1[1]))
//                 ->where('birth_year', $trimmer->trims($splittedBday1[0]))
//                 ->count();

//             if($checkSame > 0)
//             {
//                 return 'double';
//             }
//             else
//             {

//                 $endorse_id1 = DB::table('bi_endorsements')
//                     ->insertGetId([
//                         'bi_id' => $getBIid[0]->bi_id,
//                         'bi_account_name' => $bi_name,
//                         'lob' => $request->accnt_lob,
//                         'endorser_poc' => $scripttrom->scripttrim($request->endorser_name),
//                         'package' => $request->package,
//                         'project' => $scripttrom->scripttrim($request->accnt_project_name),
//                         'account_name' => strtoupper($getInfo1[0]->direct_last_name. ', ' . $getInfo1[0]->direct_first_name . ' ' . $getInfo1[0]->direct_middle_name),
//                         'f_name' => $getInfo1[0]->direct_first_name,
//                         'm_name' => $getInfo1[0]->direct_middle_name,
//                         'l_name' => $getInfo1[0]->direct_last_name,
//                         'suffix' => $getInfo1[0]->direct_suffix_name,
//                         'gender' => $getInfo1[0]->direct_gender,
//                         'marital_status' => $getInfo1[0]->direct_marital_status,
//                         'birth_day' => $splittedBday1[2],
//                         'birth_month' => $splittedBday1[1],
//                         'birth_year' => $splittedBday1[0],
//                         'age' => $getInfo1[0]->direct_age,
//                         'present_address' => $getInfo1[0]->direct_present_address,
//                         'present_province' => $getInfo1[0]->direct_present_prov,
//                         'present_muni' =>  $getInfo1[0]->direct_present_muni,
//                         'permanent_address' => $getInfo1[0]->direct_perma_address,
//                         'permanent_province' => $getInfo1[0]->direct_perma_prov,
//                         'permanent_muni' => $getInfo1[0]->direct_perma_muni,
// //                    'attach_1' => $getInfo1[0]->direct_attach_1,
// //                    'attach_2' => $getInfo1[0]->direct_attach_2,
// //                    'attach_3' => $getInfo1[0]->direct_attach_3,
// //                    'attach_4' => $getInfo1[0]->direct_attach_4,
//                         'status' => 0,
//                         'direct_apply_status' => 'direct',
//                         'created_at' => Carbon::now('Asia/Manila')
//                     ]);

//                 if($getInfo1[0]->direct_attach_1 != null || $getInfo1[0]->direct_attach_1 != '')
//                 {
//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update([
//                             'attach_1' => $getInfo1[0]->direct_attach_1
//                         ]);
//                 }

//                 if($getInfo1[0]->direct_attach_2 != null || $getInfo1[0]->direct_attach_2 != '')
//                 {
//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update([
//                             'attach_2' => $getInfo1[0]->direct_attach_2
//                         ]);
//                 }

//                 if($getInfo1[0]->direct_attach_3 != null || $getInfo1[0]->direct_attach_3 != '')
//                 {
//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update([
//                             'attach_3' => $getInfo1[0]->direct_attach_3
//                         ]);
//                 }

//                 if($getInfo1[0]->direct_attach_4 != null || $getInfo1[0]->direct_attach_4 != '')
//                 {
//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update([
//                             'attach_4' => $getInfo1[0]->direct_attach_4
//                         ]);
//                 }


//                 $user = User::find(Auth::user()->id);
//                 $endorse_user = new bi_endorsements_user();
//                 $endorse_user->bi_endorse_id = $endorse_id1;
//                 $endorse_user->users_id = Auth::user()->id;
//                 $endorse_user->position_id = $user->roles->first()->id;
//                 $endorse_user->save();

//                 if(!file_exists(storage_path('bi_attachments/'.$getBIid[0]->bi_id)))
//                 {
//                     File::makeDirectory(storage_path('bi_attachments/'.$getBIid[0]->bi_id));
//                 }

//                 if(!file_exists(storage_path('bi_attachments/'.$getBIid[0]->bi_id.'/'.$endorse_id1)))
//                 {
//                     File::makeDirectory(storage_path('bi_attachments/'.$getBIid[0]->bi_id.'/'.$endorse_id1));
//                 }


//                 if($getInfo1[0]->direct_attach_1 != '' || $getInfo1[0]->direct_attach_1 != null)
//                 {
//                     if(file_exists(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_1)))
//                     {
//                         File::move(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_1) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_1));
//                     }

//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update
//                         ([
//                             'attach_1' => $getInfo1[0]->direct_attach_1
//                         ]);
//                 }

//                 if($getInfo1[0]->direct_attach_2 != '' || $getInfo1[0]->direct_attach_2 != null)
//                 {
//                     if(file_exists(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo1[0]->direct_attach_2)))
//                     {
//                         File::move(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_2) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_2));
//                     }

//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update
//                         ([
//                             'attach_2' => $getInfo1[0]->direct_attach_2
//                         ]);
//                 }

//                 if($getInfo1[0]->direct_attach_3 != '' || $getInfo1[0]->direct_attach_3 != null)
//                 {
//                     if(file_exists(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_3)))
//                     {
//                         File::move(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_3) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_3));
//                     }

//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update
//                         ([
//                             'attach_3' => $getInfo1[0]->direct_attach_3
//                         ]);

//                 }

//                 if($getInfo1[0]->direct_attach_4 != '' || $getInfo1[0]->direct_attach_4 != null)
//                 {
//                     if(file_exists(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo1[0]->direct_attach_4)))
//                     {
//                         File::move(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_4) , storage_path('bi_attachments/'.$getBIid[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_4));
//                     }

//                     DB::table('bi_endorsements')
//                         ->where('id', '=', $endorse_id1)
//                         ->update
//                         ([
//                             'attach_4' => $getInfo1[0]->direct_attach_4
//                         ]);
//                 }

// //            File::deleteDirectory(storage_path('direct_bi_attachment/'.$getBIid[0]->bi_id.'/'.$getPivot[0]->direct_to_get_id));

//                 if(count($request->checking) != 0)
//                 {
//                     $i = 0;

//                     for($i = 0; $i < count($request->checking); $i++)
//                     {
//                         DB::table('bi_endorsements_checkings')
//                             ->insert([
//                                 'bi_endorsement_id' => $endorse_id1,
//                                 'checking_id' => 0,
//                                 'checking_name' => $request->checking[$i][0],
//                                 'type_check' => $request->checking[$i][1],
//                                 'created_at' => Carbon::now('Asia/Manila')
//                             ]);
//                     }
//                 }

//                 DB::table('bi_direct_pivot')
//                     ->where('id', $request->id)
//                     ->update
//                     ([
//                         'direct_status' => '1',
//                         'application_status' => 'Acknowledge',
//                         'endorse_id' => $endorse_id1
//                     ]);

//                 DB::table('bi_direct_applicant_endorsement')
//                     ->where('id', $getPivot[0]->direct_to_get_id)
//                     ->update
//                     ([
//                         'applicant_status' => 'On-Process'
//                     ]);

//                 $email = new EmailQueries();
//                 $trimmer = new Trimmer();
//                 $account4EmailName = $trimmer->trims($getInfo1[0]->direct_last_name).', '.$trimmer->trims($getInfo1[0]->direct_first_name).' '.$trimmer->trims($getInfo1[0]->direct_middle_name);
//                 $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);

//                 DB::table('bi_direct_application_logs')
//                     ->insert
//                     ([
//                         'direct_piv_id' => $request->id,
//                         'user_id' => Auth::user()->id,
//                         'activity' => 'ENDORSED THE ACCOUNT',
//                         'remarks' => '-',
//                         'created_at' => Carbon::now('Asia/Manila')
//                     ]);

//                 $logs = new bi_log();
//                 $logs->endorse_id = $endorse_id1;
//                 $logs->user_id = Auth::user()->id;
//                 $logs->position_id = $user->roles->first()->id;
//                 $logs->activity = 'ENDORSED THE ACCOUNT';
//                 $logs->remarks = '-';
//                 $logs->save();
//             }
//         }
//     }

    public function bi_endorse_encoded_account(Request $request)
    {
        $scripttrom = new ScriptTrimmer();
        $trimmer = new Trimmer();
        
        if(Auth::user() == null)
        {
            return 'login again';
        }

        $getPivot = DB::table('bi_direct_pivot')
            ->select('direct_to_get_id', 'bi_id')
            ->where('id', $request->id)
            ->get();

        $getNIName = DB::table('bi_account_list')
            ->where('bi_account_list.id', $getPivot[0]->bi_id)
            ->select
            ([
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as loc'
            ])
            ->get();

        $bi_name = $getNIName[0]->bi_name . ' ' . $getNIName[0]->loc;


        if($request->type == 'Concentrix')
        {
            $getInfo = DB::table('bi_direct_encoded_data')
                ->where('id', $getPivot[0]->direct_to_get_id)
                ->get();

            $splittedBday = explode('-', $getInfo[0]->accnt_bday);

            $endorse_id = DB::table('bi_endorsements')
                ->insertGetId([
                    'bi_id' => $getPivot[0]->bi_id,
                    'bi_account_name' => $bi_name,
                    'lob' => $request->accnt_lob,
                    'endorser_poc' => $scripttrom->scripttrim($request->endorser_name),
                    'package' => $request->package,
                    'project' => $scripttrom->scripttrim($request->accnt_project_name),
                    'account_name' => $getInfo[0]->accnt_surname. ', ' . $getInfo[0]->accnt_fname . ' ' . $getInfo[0]->accnt_mname,
                    'f_name' => $getInfo[0]->accnt_fname,
                    'm_name' => $getInfo[0]->accnt_mname,
                    'l_name' => $getInfo[0]->accnt_surname,
                    'suffix' => $getInfo[0]->accnt_suffix,
                    'gender' => $getInfo[0]->accnt_gender,
                    'marital_status' => $getInfo[0]->accnt_civil_status,
                    'birth_day' => $splittedBday[2],
                    'birth_month' => $splittedBday[1],
                    'birth_year' => $splittedBday[0],
                    'age' => $getInfo[0]->accnt_age,
                    'present_address' => $getInfo[0]->accnt_present_add,
                    'present_province' => $getInfo[0]->accnt_present_mun_id,
                    'present_muni' => $getInfo[0]->accnt_present_prov_id,
                    'permanent_address' => $getInfo[0]->accnt_permanent_add,
                    'permanent_province' => $getInfo[0]->accnt_permanent_mun_id,
                    'permanent_muni' => $getInfo[0]->accnt_permanent_prov_id,
//                    'attach_1' => $getInfo[0]->attach1,
//                    'attach_2' => $getInfo[0]->attach2,
//                    'attach_3' => $getInfo[0]->attach3,
//                    'attach_4' => $getInfo[0]->attach4,
                    'status' => 0,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            if(!file_exists(storage_path('bi_attachments/'.$getPivot[0]->bi_id)))
            {
                File::makeDirectory(storage_path('bi_attachments/'.$getPivot[0]->bi_id));
            }

            if(!file_exists(storage_path('bi_attachments/'.$getPivot[0]->bi_id.'/'.$endorse_id)))
            {
                File::makeDirectory(storage_path('bi_attachments/'.$getPivot[0]->bi_id.'/'.$endorse_id));
            }

            if($getInfo[0]->attach1 != '' || $getInfo[0]->attach1 != null)
            {
                if(file_exists(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach1)))
                {
                    File::move(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach1) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach1));
                }

                DB::table('bi_endorsements')
                    ->where('id', '=', $endorse_id)
                    ->update
                    ([
                        'attach_1' => $getInfo[0]->attach1
                    ]);
            }

            if($getInfo[0]->attach2 != '' || $getInfo[0]->attach2 != null)
            {
                if(file_exists(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach2)))
                {
                    File::move(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach2) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach2));
                }

                DB::table('bi_endorsements')
                    ->where('id', '=', $endorse_id)
                    ->update
                    ([
                        'attach_2' => $getInfo[0]->attach2
                    ]);
            }

            if($getInfo[0]->attach3 != '' || $getInfo[0]->attach3 != null)
            {
                if(file_exists(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach3)))
                {
                    File::move(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach3) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id.'/'.$getInfo[0]->attach3));
                }

                DB::table('bi_endorsements')
                    ->where('id', '=', $endorse_id)
                    ->update
                    ([
                        'attach_3' => $getInfo[0]->attach3
                    ]);

            }

            if($getInfo[0]->attach4 != '' || $getInfo[0]->attach4 != null)
            {
                if(file_exists(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo[0]->attach4)))
                {
                    File::move(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo[0]->attach4) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'.$endorse_id.'/'.$getInfo[0]->attach4));
                }

                DB::table('bi_endorsements')
                    ->where('id', '=', $endorse_id)
                    ->update
                    ([
                        'attach_4' => $getInfo[0]->attach4
                    ]);
            }

            $user = User::find(Auth::user()->id);
            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorse_id;
            $endorse_user->users_id = Auth::user()->id;
            $endorse_user->position_id = $user->roles->first()->id;
            $endorse_user->save();

//            File::deleteDirectory(storage_path('bi_attachments_direct/'.$getPivot[0]->bi_id.'/'.$getPivot[0]->direct_to_get_id));

            if(count($request->checking) != 0)
            {
                $i = 0;

                for($i = 0; $i < count($request->checking); $i++)
                {
                    DB::table('bi_endorsements_checkings')
                        ->insert([
                            'bi_endorsement_id' => $endorse_id,
                            'checking_id' => 0,
                            'checking_name' => $request->checking[$i][0],
                            'type_check' => $request->checking[$i][1],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }

            DB::table('bi_direct_encoded_data')
                ->where('id',  $getPivot[0]->direct_to_get_id)
                ->update
                ([
                    'status' => '1'
                ]);

            DB::table('bi_direct_pivot')
                ->where('id', $request->id)
                ->update
                ([
                    'direct_status' => '1',
                    'endorse_id' => $endorse_id
                ]);

            $email = new EmailQueries();
            $trimmer = new Trimmer();
            $account4EmailName = $trimmer->trims($getInfo[0]->accnt_surname).', '.$trimmer->trims($getInfo[0]->accnt_fname).' '.$trimmer->trims($getInfo[0]->accnt_mname);
            $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);

            $logs = new bi_log();
            $logs->endorse_id = $endorse_id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ENDORSED THE ACCOUNT';
            $logs->remarks = '-';
            $logs->save();
        }
        else if($request->type == 'direct_applicant')
        {


            $getInfo1 = DB::table('bi_direct_applicant_endorsement')
                ->where('id', $getPivot[0]->direct_to_get_id)
                ->get();

            $splittedBday1 = explode('-', $getInfo1[0]->direct_birthdate);

            $checkSame = DB::table('bi_endorsements')
                ->where('bi_account_name', $bi_name)
                ->where('bi_id', $getPivot[0]->bi_id)
                ->where('f_name', $trimmer->trims($getInfo1[0]->direct_first_name))
                ->where('m_name', $trimmer->trims($getInfo1[0]->direct_middle_name))
                ->where('l_name', $trimmer->trims($getInfo1[0]->direct_last_name))
                ->where('birth_day', $trimmer->trims($splittedBday1[2]))
                ->where('birth_month', $trimmer->trims($splittedBday1[1]))
                ->where('birth_year', $trimmer->trims($splittedBday1[0]))
                ->where('status', '!=', '1999')
                ->count();

            // if($checkSame > 0)
            // {
            //     return 'double';
            // }
            // else
            // {

                $endorse_id1 = DB::table('bi_endorsements')
                    ->insertGetId([
                        'bi_id' => $getPivot[0]->bi_id,
                        'bi_account_name' => $bi_name,
                        'lob' => $request->accnt_lob,
                        'endorser_poc' => $scripttrom->scripttrim($request->endorser_name),
                        'package' => $request->package,
                        'project' => $scripttrom->scripttrim($request->accnt_project_name),
                        'account_name' => strtoupper($getInfo1[0]->direct_last_name. ', ' . $getInfo1[0]->direct_first_name . ' ' . $getInfo1[0]->direct_middle_name),
                        'f_name' => $getInfo1[0]->direct_first_name,
                        'm_name' => $getInfo1[0]->direct_middle_name,
                        'l_name' => $getInfo1[0]->direct_last_name,
                        'suffix' => $getInfo1[0]->direct_suffix_name,
                        'gender' => $getInfo1[0]->direct_gender,
                        'marital_status' => $getInfo1[0]->direct_marital_status,
                        'birth_day' => $splittedBday1[2],
                        'birth_month' => $splittedBday1[1],
                        'birth_year' => $splittedBday1[0],
                        'age' => $getInfo1[0]->direct_age,
                        'present_address' => $getInfo1[0]->direct_present_address,
                        'present_province' => $getInfo1[0]->direct_present_prov,
                        'present_muni' =>  $getInfo1[0]->direct_present_muni,
                        'permanent_address' => $getInfo1[0]->direct_perma_address,
                        'permanent_province' => $getInfo1[0]->direct_perma_prov,
                        'permanent_muni' => $getInfo1[0]->direct_perma_muni,
//                    'attach_1' => $getInfo1[0]->direct_attach_1,
//                    'attach_2' => $getInfo1[0]->direct_attach_2,
//                    'attach_3' => $getInfo1[0]->direct_attach_3,
//                    'attach_4' => $getInfo1[0]->direct_attach_4,
                        'status' => 0,
                        'direct_apply_status' => 'direct',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                if($getInfo1[0]->direct_attach_1 != null || $getInfo1[0]->direct_attach_1 != '')
                {
                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update([
                            'attach_1' => $getInfo1[0]->direct_attach_1
                        ]);
                }

                if($getInfo1[0]->direct_attach_2 != null || $getInfo1[0]->direct_attach_2 != '')
                {
                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update([
                            'attach_2' => $getInfo1[0]->direct_attach_2
                        ]);
                }

                if($getInfo1[0]->direct_attach_3 != null || $getInfo1[0]->direct_attach_3 != '')
                {
                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update([
                            'attach_3' => $getInfo1[0]->direct_attach_3
                        ]);
                }

                if($getInfo1[0]->direct_attach_4 != null || $getInfo1[0]->direct_attach_4 != '')
                {
                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update([
                            'attach_4' => $getInfo1[0]->direct_attach_4
                        ]);
                }


                $user = User::find(Auth::user()->id);
                $endorse_user = new bi_endorsements_user();
                $endorse_user->bi_endorse_id = $endorse_id1;
                $endorse_user->users_id = Auth::user()->id;
                $endorse_user->position_id = $user->roles->first()->id;
                $endorse_user->save();

                if(!file_exists(storage_path('bi_attachments/'.$getPivot[0]->bi_id)))
                {
                    File::makeDirectory(storage_path('bi_attachments/'.$getPivot[0]->bi_id));
                }

                if(!file_exists(storage_path('bi_attachments/'.$getPivot[0]->bi_id.'/'.$endorse_id1)))
                {
                    File::makeDirectory(storage_path('bi_attachments/'.$getPivot[0]->bi_id.'/'.$endorse_id1));
                }


                if($getInfo1[0]->direct_attach_1 != '' || $getInfo1[0]->direct_attach_1 != null)
                {
                    if(file_exists(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_1)))
                    {
                        File::move(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_1) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_1));
                    }

                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update
                        ([
                            'attach_1' => $getInfo1[0]->direct_attach_1
                        ]);
                }

                if($getInfo1[0]->direct_attach_2 != '' || $getInfo1[0]->direct_attach_2 != null)
                {
                    if(file_exists(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo1[0]->direct_attach_2)))
                    {
                        File::move(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_2) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_2));
                    }

                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update
                        ([
                            'attach_2' => $getInfo1[0]->direct_attach_2
                        ]);
                }

                if($getInfo1[0]->direct_attach_3 != '' || $getInfo1[0]->direct_attach_3 != null)
                {
                    if(file_exists(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_3)))
                    {
                        File::move(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_3) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_3));
                    }

                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update
                        ([
                            'attach_3' => $getInfo1[0]->direct_attach_3
                        ]);

                }

                if($getInfo1[0]->direct_attach_4 != '' || $getInfo1[0]->direct_attach_4 != null)
                {
                    if(file_exists(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id. '/'. $getPivot[0]->direct_to_get_id.'/'. $getInfo1[0]->direct_attach_4)))
                    {
                        File::move(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id.'/'. $getPivot[0]->direct_to_get_id.'/'.$getInfo1[0]->direct_attach_4) , storage_path('bi_attachments/'.$getPivot[0]->bi_id. '/'. $endorse_id1.'/'.$getInfo1[0]->direct_attach_4));
                    }

                    DB::table('bi_endorsements')
                        ->where('id', '=', $endorse_id1)
                        ->update
                        ([
                            'attach_4' => $getInfo1[0]->direct_attach_4
                        ]);
                }

//            File::deleteDirectory(storage_path('direct_bi_attachment/'.$getPivot[0]->bi_id.'/'.$getPivot[0]->direct_to_get_id));

                if(count($request->checking) != 0)
                {
                    $i = 0;

                    for($i = 0; $i < count($request->checking); $i++)
                    {
                        DB::table('bi_endorsements_checkings')
                            ->insert([
                                'bi_endorsement_id' => $endorse_id1,
                                'checking_id' => 0,
                                'checking_name' => $request->checking[$i][0],
                                'type_check' => $request->checking[$i][1],
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                }

                DB::table('bi_direct_pivot')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'direct_status' => '1',
                        'application_status' => 'Acknowledge',
                        'endorse_id' => $endorse_id1
                    ]);

                DB::table('bi_direct_applicant_endorsement')
                    ->where('id', $getPivot[0]->direct_to_get_id)
                    ->update
                    ([
                        'applicant_status' => 'On-Process'
                    ]);

                $email = new EmailQueries();
                $trimmer = new Trimmer();
                $account4EmailName = $trimmer->trims($getInfo1[0]->direct_last_name).', '.$trimmer->trims($getInfo1[0]->direct_first_name).' '.$trimmer->trims($getInfo1[0]->direct_middle_name);
                $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);

                DB::table('bi_direct_application_logs')
                    ->insert
                    ([
                        'direct_piv_id' => $request->id,
                        'user_id' => Auth::user()->id,
                        'activity' => 'ENDORSED THE ACCOUNT',
                        'remarks' => '-',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                $logs = new bi_log();
                $logs->endorse_id = $endorse_id1;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ENDORSED THE ACCOUNT';
                $logs->remarks = '-';
                $logs->save();
            // }
        }
    }
    
    public function bi_client_request_cancellation(Request $request)
    {
        $email = new EmailQueries();
        $checker = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->select('cancel_bool')
            ->get();

        if(count($checker) > 0)
        {
            if($checker[0]->cancel_bool == 'Pending')
            {
                return 'already';
            }
            else
            {
                if($request->what == 'req_cancel')
                {
                    DB::table('bi_endorsements')
                        ->where('id', $request->id)
                        ->update([
                            'cancel_remarks' => $request->reason,
                            'cancel_bool' => 'Pending Cancel'
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REQUEST FOR CANCELLATION OF ACCOUNT';
                    $logs->remarks = $request->reason;
                    $logs->save();

                    $email->BICancellationRequest($request);

                    return 'success';
                }
                else
                {
                    DB::table('bi_endorsements')
                        ->where('id', $request->id)
                        ->update([
                            'cancel_remarks' => $request->reason,
                            'cancel_bool' => 'Pending Revoke'
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REQUEST FOR REVOCATION OF CANCELLATION';
                    $logs->remarks = $request->reason;
                    $logs->save();

                    $email->BICancellationRequest($request);

                    return 'success';
                }

            }
        }
        else
        {
            return 'error';
        }
    }

    public function bi_client_dl_bulk()
    {
        if(Auth::user() != null)
        {
            if(Auth::user()->hasRole('B.I Client'))
            {
                return response()->download(storage_path('/bi_final_bulk_temp/Bulk Endorsement Template Tele.xlsx'));
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

    public function bi_client_billing_information_table(Request $request)
    {
        $getBilling = DB::table('billing_invoice')
            ->join('bi_account_to_users', 'bi_account_to_users.bi_account_id', '=', 'billing_invoice.bi_id')
            ->where('bi_account_to_users.users_id', '=', Auth::user()->id)
            ->select([
                'billing_invoice.id as invoice_number',
                'billing_invoice.invoice_status as status',
            ]);

        return DataTables::of($getBilling)
            ->editcolumn('amount', function($query)
            {
                $amountHolder = [];
                $getAccounts = DB::table('billing_invoice_to_account')
                    ->where('invoice_id', '=', $query->invoice_number)
                    ->select('amount')
                    ->get();

                $getAccountsWithout = DB::table('billing_invoice_to_account_manual')
                    ->where('invoice_id', '=', $query->invoice_number)
                    ->select('amount')
                    ->get();

                if(count($getAccounts) > 0 || count($getAccountsWithout) > 0)
                {
                    if(count($getAccounts) > 0)
                    {
                        foreach($getAccounts as $account)
                        {
                            array_push($amountHolder, $account->amount);
                        }
                    }

                    if(count($getAccountsWithout) > 0)
                    {
                        foreach($getAccountsWithout as $accounts)
                        {
                            array_push($amountHolder, $accounts->amount);
                        }
                    }


                    return array_sum($amountHolder) . ' PHP';
                }
                else
                {
                    return 'No Selected Account';
                }

            })
            ->editcolumn('status', function($query)
            {
                if($query->status == 'New')
                {
                    return 'UNPAID';
                }
                else
                {
                    return 'PAID';
                }
            })
            ->editcolumn('billing_period', function($query)
            {
                $dateHolder = [];
                $dateToShow = '';
                $getDates = DB::table('bi_endorsements')
                    ->join('billing_invoice_to_account', 'billing_invoice_to_account.endorsement_id', '=', 'bi_endorsements.id')
                    ->where('billing_invoice_to_account.invoice_id', '=', $query->invoice_number)
                    ->orderByDesc('bi_endorsements.id')
                    ->select([
                        'bi_endorsements.created_at as datetime_endorse'
                    ])
                    ->get();

                $geDatesWithout = DB::table('billing_invoice_to_account_manual')
                    ->where('invoice_id', '=', $query->invoice_number)
                    ->count();

                if(count($getDates) > 0)
                {
                    foreach ($getDates as $dates)
                    {
                        array_push($dateHolder, Carbon::parse($dates->datetime_endorse)->toFormattedDateString());
                    }

                    $dateToShow .= $dateHolder[(count($dateHolder) - 1)] . ' - ' . $dateHolder[0];
                }

                if($geDatesWithout > 0)
                {
                    $dateToShow .= ' (WITH '. $geDatesWithout . ' ACCOUNT/S SENT VIA EMAIL)';
                }


                return $dateToShow;
            })
            ->rawColumns([
                'amount',
                'status',
                'billing_period'
            ])
            ->make(true);
    }

    public function bi_client_billing_selected_accounts(Request $request)
    {
        $dateHolder = [];
        $amountHolder = [];
        $dateToShow = '';
        $getAccounts = [];
        $getDates = DB::table('bi_endorsements')
            ->join('billing_invoice_to_account', 'billing_invoice_to_account.endorsement_id', '=', 'bi_endorsements.id')
            ->where('billing_invoice_to_account.invoice_id', '=', $request->invoice_id)
            ->orderByDesc('bi_endorsements.id')
            ->select([
                'bi_endorsements.created_at as datetime_endorse',
                'billing_invoice_to_account.amount as amount'
            ])
            ->get();

        $getDatesWithout = DB::table('billing_invoice')
            ->leftJoin('billing_invoice_to_account_manual', 'billing_invoice_to_account_manual.invoice_id', '=', 'billing_invoice.id')
            ->where('billing_invoice.id', '=', $request->invoice_id)
            ->select([
                'billing_invoice_to_account_manual.invoice_id as invoice_id',
                'billing_invoice_to_account_manual.account_name as account_name',
                'billing_invoice_to_account_manual.account_address as address',
                'billing_invoice_to_account_manual.amount as amount',
                'billing_invoice_to_account_manual.type_of_request as type_of_request'
            ])
            ->get();

        $getDatesWithout2 = DB::table('billing_invoice_to_account_manual')
            ->where('billing_invoice_to_account_manual.invoice_id', '=', $request->invoice_id)
            ->count();

        if(count($getDates) > 0)
        {
            foreach ($getDates as $dates)
            {
                array_push($amountHolder, $dates->amount);
                array_push($dateHolder, Carbon::parse($dates->datetime_endorse)->toFormattedDateString());
            }

            $dateToShow .= ' '.$dateHolder[(count($dateHolder) - 1)] . ' - ' . $dateHolder[0];

            $getAccounts= DB::table('bi_endorsements')
                ->join('billing_invoice_to_account', 'billing_invoice_to_account.endorsement_id', '=', 'bi_endorsements.id')
                ->join('billing_invoice', 'billing_invoice.id','=' ,'billing_invoice_to_account.invoice_id')
                ->leftjoin('municipalities', 'municipalities.id', '=', 'bi_endorsements.present_muni')
                ->leftjoin('provinces', 'provinces.id', '=', 'bi_endorsements.present_province')
                ->where('billing_invoice_to_account.invoice_id', '=', $request->invoice_id)
                ->orderByDesc('bi_endorsements.id')
                ->select([
                    'billing_invoice.id as invoice_id',
                    'billing_invoice.invoice_type as invoice_type',
                    'billing_invoice_to_account.amount as amount',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.present_address as address',
                    'municipalities.muni_name as muni_name',
                    'provinces.name as prov_name',
                ])
                ->get();
        }

        if($getDatesWithout2 > 0)
        {

            foreach($getDatesWithout as $data)
            {
                array_push($amountHolder, $data->amount);
            }
            $dateToShow .= ' (WITH '. count($getDatesWithout) . ' ACCOUNT/S SENT VIA EMAIL)';
        }


        return response()->json([$dateToShow, $getAccounts, array_sum($amountHolder), $getDatesWithout]);
    }

    public function bi_client_billing_success_payment(Request $request)
    {
        $getAccounts = DB::table('billing_invoice_to_account')
            ->where('invoice_id', '=', $request->invoice_id)
            ->select([
                'endorsement_id'
            ])
            ->get();

        if(count($getAccounts) > 0)
        {
            foreach($getAccounts as $accounts)
            {
                DB::table('bi_endorsements')
                    ->where('id', '=', $accounts->endorsement_id)
                    ->update([
                       'billing_status' => 'Settled'
                    ]);
            }
        }

        DB::table('billing_invoice')
            ->where('id', '=', $request->invoice_id)
            ->update([
                'invoice_status' => 'Settled',
                'transaction_id' => $request->transaction_id,
                'updated_at' => date("Y-m-d H:i:s", strtotime($request->timestamp))
            ]);
            
        DB::table('billing_invoice_logs')
            ->where('invoice_id', '=', $request->invoice_id)
            ->update([
                'transaction_id' => $request->transaction_id
            ]);
            
        DB::table('billing_invoice_logs')
        ->insert([
            'invoice_id' => $request->invoice_id,
            'transaction_id' => $request->transaction_id,
            'user_id' => Auth::user()->id,
            'activity' => 'PAYMENT',
            'created_at' => date("Y-m-d H:i:s", strtotime($request->timestamp))
        ]);

        return 'success';
    }
    
    public function bi_client_get_additional_files_direct(Request $request)
    {
        $getFileNames = DB::table('bi_direct_pivot')
            ->join('bi_direct_applicant_additional_files', 'bi_direct_applicant_additional_files.direct_id', '=', 'bi_direct_pivot.direct_to_get_id')
            ->select
            ([
                'bi_direct_applicant_additional_files.file_path as file'
            ])
            ->where('bi_direct_pivot.id', base64_decode($request->id))
            ->get();

        return response()->json($getFileNames);
    }
    
        public function bi_client_send_return_email_application(Request $request)
    {
        $id = base64_decode($request->id);

        $getEmail = DB::table('bi_direct_pivot')
            ->join('bi_direct_applicant_endorsement', 'bi_direct_applicant_endorsement.id', '=', 'bi_direct_pivot.direct_to_get_id')
            ->select
            ([
                'bi_direct_applicant_endorsement.direct_personal_email as email',
                'bi_direct_applicant_endorsement.direct_first_name as fname',
                'bi_direct_applicant_endorsement.direct_last_name as lname',
                'bi_direct_applicant_endorsement.generated_code as generated_code',
            ])
            ->where('bi_direct_pivot.id', $id)
            ->get();

        DB::table('bi_direct_pivot')
            ->where('id', $id)
            ->update
            ([
                'application_status' => 'Returned',
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        DB::table('bi_direct_application_logs')
            ->insert
            ([
                'direct_piv_id' => $id,
                'user_id' => strtoupper(Auth::user()->name),
                'activity' => 'RETURNED TO APPLICANT (LACKING OF DOCUMENT/S)',
                'remarks' => $request->message,
                'created_at' => Carbon::now('Asia/Manila')
            ]);


        $email = new EmailQueries();

        $name = $getEmail[0]->fname . ' ' . $getEmail[0]->lname;

        $email->sendEmailApplicatReturned($name, $request->message ,$getEmail[0]->email, $getEmail[0]->generated_code);
    }

    public function bi_cancel_direct_encode_data(Request $request)
    {
        $email = new EmailQueries();
        $removeScript = new ScriptTrimmer();

        $getStatus = DB::table('bi_direct_pivot')
            ->where('id', '=', $request->pivot_id)
            ->select('application_status')
            ->get();

        if($getStatus[0]->application_status == 'Returned')
        {
            DB::table('bi_direct_pivot')
                ->where('id', '=', $request->pivot_id)
                ->update([
                    'application_status' => 'Pending'
                ]);
        }
        else
        {
            DB::table('bi_direct_pivot')
                ->where('id', '=', $request->pivot_id)
                ->where(function($query)
                {
                    return $query->orwhere('application_status', '=', 'Pending')
                        ->orwhere('application_status', '=', 'Returned Pending');
                })
                ->update([
                    'application_status' => 'Cancelled'
                ]);
            
            DB::table('bi_direct_application_logs')
                ->insert
                ([
                    'direct_piv_id' => $request->pivot_id,
                    'user_id' => strtoupper(Auth::user()->name),
                    'activity' => 'CANCELLED THE APPLICATION',
                    'remarks' => $request->remarks,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
                    
                

            $email->DirectEncodeCancellation($removeScript->scripttrim($request->remarks), $request->pivot_id);
        }
        

        return 'ok';
    }

    public function bi_uncancel_direct_encode_data(Request $request)
    {
        DB::table('bi_direct_pivot')
            ->where('id', '=', $request->pivot_id)
            ->where('application_status', '=', 'Cancelled')
            ->update([
                'application_status' => 'Pending'
            ]);

        return 'ok';
    }
    
    
}