<?php

namespace App\Http\Controllers;

use App\bi_endorsement;
use App\bi_endorsements_user;
use App\bi_log;
use App\Endorsement;
use App\Generals\AuditQueries;
use App\Generals\DashboardQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;

class CCAccountOfficerController extends Controller
{
    public function ccaopanel()
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
            } elseif (Auth::user()->hasRole('CC Account Officer')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;

                return view('cc_dept.ao.cc-ao-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function cc_ao_get_table_accounts()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.type_of_tat as tat_type',
                'bi_endorsements.type_of_endorsement_bank as t_o_e',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status'

            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function ($query)
            {
                return $query->orWhere('bi_endorsements.status',0)
                    ->orWhere('bi_endorsements.status',21);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

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
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->rawColumns([
                'attachments',
                'check',
            ])
            ->make(true);
    }

    public function cc_ao_get_table_return()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.type_of_endorsement_bank as bank'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function ($query)
            {
                return $query->orWhere('bi_endorsements.status',20)
                    ->orWhere('bi_endorsements.status',22)
                    ->orWhere('bi_endorsements.status',23);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

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
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';
            })
            ->rawColumns([
                'attachments',
                'check',
            ])
            ->make(true);
    }

    public function cc_ao_get_table_acknowledge()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;


        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements_users.position_id as pos_id',
                'bi_endorsements.sao_to_tele_file_path as sao_to_tele_file_path1',
                'bi_endorsements.type_of_endorsement_bank as bank'
            ])
            ->groupBy('bi_endorsements.id')
//            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function ($query)
            {
                return $query->orWhere('bi_endorsements.status',1)
                    ->orWhere('bi_endorsements.status',2);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });


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
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->editColumn('stat', function ($query)
            {
                if ($query->status == 1)
                {
                    return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>';
                }
                else if($query->status == 2)
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

                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>';
                }
            })
            ->rawColumns([
                'attachments',
                'check',
                'stat'
            ])
            ->make(true);
    }

    public function cc_ao_get_table_finished()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
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
                'bi_endorsements.type_of_endorsement_bank as bank',
                'users.client_check as client_access'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where('bi_endorsements.status', 10)
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

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
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->editColumn('status', function ($query)
            {
                $dateDue = Carbon::createFromFormat('Y-m-d H:i:s', $query->due);
                $dateFinished = Carbon::createFromFormat('Y-m-d H:i:s', $query->finish);
                $statusTat = '';
                $difference_min = $dateFinished->diffInMinutes($dateDue, false);

                if($difference_min >= 0)
                {
                    $statusTat = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> ON TAT</a>';
                }
                else if($difference_min < 0)
                {
                    $statusTat = '<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE</a>';
                }

                if($query->client_access == 'cc_bank')
                {
                    if($query->status == 10)
                    {
                        if($query->status_report == 'Contacted')
                        {
                            return
                                '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;
                        }
                        else if($query->status_report == 'Verified')
                        {
                            return
                                '<a class="btn btn-xs btn-success btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;
                        }
                        else if($query->status_report == 'Unverified')
                        {
                            return
                                '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;
                        }
                        
                        else
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$query->status_report.' </a>' . $statusTat;
                        }
                    }
                }
                else
                {
                    if($query->status == 10)
                    {
                        if($query->status_report == 'Complete')
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' .
                                '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;
                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-spinner"></i> Partial</a>' .
                                '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$query->status_report.' </a>' . $statusTat;
                        }
                    }
                }

            })
            ->rawColumns([
                'attachments',
                'check',
                'status'
            ])
            ->make(true);
    }

    public function cc_ao_cancel_account(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $account = new bi_endorsement();
        $account = $account::find($request->id);

        if($account->status == 0)
        {
            return 'already';
        }
        else
        {
            $account->status = 0;
            $account->save();

            $getData = DB::table('bi_endorsements')
                ->select('bi_id', 'account_name')
                ->where('id', $request->id)
                ->get();

            DB::table('bi_account_to_users')
                ->where('bi_account_id', $getData[0]->bi_id)
                ->update
                ([
                    'return_stat' => 0,
                    'message_notif' => 0
                ]);
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'date_time_return' => ''
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'CANCELLED FROM RETURNING THE ACCOUNT';
            $logs->remarks = $removeScript->scripttrim($request->remarks);
            $logs->save();

            return 'ok';
        }
    }

    public function cc_ao_acknowledge_account(Request $request)
    {
        $account = new bi_endorsement();
        $account = $account::find($request->id);
        $email = new EmailQueries();

        if($account->status == 0 || $account->status == 21)
        {
            if($request->type == 'cc')
            {
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'status' => $request->stats,
                        'date_time_due' => $request->date_due.' '.$request->time_due,
                        'type_of_tat' => $request->type_tat,
                        'date_time_approved' => Carbon::now('Asia/Manila')
                    ]);

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT HAS BEEN ACKNOWLEDGE';
                $logs->remarks = '-';
                $logs->save();

                $email->cc_client_account_acknowledge_notif($request->id, Auth::user()->email);

                return 'ok';
            }
            else if($request->type == 'cc_bank')
            {
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'status' => $request->stats,
                        'date_time_due' => $request->date_due.' '.date("H:i", strtotime($request->time_due_bank)).':00',
                        'type_of_tat' => '',
                        'date_time_approved' => Carbon::now('Asia/Manila')
                    ]);

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT HAS BEEN ACKNOWLEDGE';
                $logs->remarks = '-';
                $logs->save();

                $email->cc_client_account_acknowledge_notif($request->id, Auth::user()->email);

                return 'ok';
            }

        }
        else
        {
            return 'already';
        }
    }

    public function cc_ao_send_report(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trims = new Trimmer();
        $id = $request->endorseID;
        $email = new EmailQueries();

        $account = new bi_endorsement();
        $account = $account::find($request->endorseID);

        if($account->status == 10)
        {
            return 'already';
        }
        else
        {
            $file = $request->file('reportFile');
            if ($file != null)
            {
                $name =  $file->getClientOriginalName();
                $file->move(storage_path('/endorsement_client_report/' . $id . '/'), $name);
                $path = '/endorsement_client_report/' . $id . '/' . $name;
            }
            else
            {
                $path = '';
            }

            $getData = DB::table('bi_endorsements')
                ->select('bi_id', 'account_name')
                ->where('id', $id)
                ->get();

            DB::table('bi_account_to_users')
                ->where('bi_account_id', $getData[0]->bi_id)
                ->update
                ([
                    'finished_stat' => 1,
                    'message_notif' => 1
                ]);
            $getuser = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            $user = User::find(Auth::user()->id);
            $what_pos = $user->roles->first()->id;
            $logs = new bi_log();
            $logs->endorse_id = $id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'REPORT SENT WITH THE STATUS OF ' . $trims->trims($request->reportStat) . ' AND UPLOADED A REPORT FILE';
            $logs->remarks = $removeScript->scripttrim($trims->trims($request->reportRemarks));
            $logs->save();

            $messageNotif = new AuditQueries();

            // $email->ReportSendCC($id, Auth::user()->id);

            if($account->date_time_finished == '' || $account->date_time_finished == null)
            {
                DB::table('bi_endorsements')
                    ->where('id', $id)
                    ->update
                    ([
                        'status' => 10,
                        'report_file_path' => $path,
                        'report_remarks' => $request->reportRemarks,
                        'acct_report_status' => $request->reportStat,
                        'date_time_finished' => Carbon::now('Asia/Manila')
                    ]);
            }
            else
            {
                DB::table('bi_endorsements')
                    ->where('id', $id)
                    ->update
                    ([
                        'status' => 10,
                        'report_file_path' => $path,
                        'report_remarks' => $request->reportRemarks,
                        'acct_report_status' => $request->reportStat
                    ]);
            }

            $activity = 'Account name of ' . $getData[0]->account_name . ' is finished with uploaded report file, Approved by ' . $getuser[0]->name;
            $messageNotif->message_notif_bi($activity, $id, Auth::user()->id, $getData[0]->bi_id);

            return 'ok';
        }
    }

    public function cc_ao_dl_report(Request $request)
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

        if(Auth::user()->hasRole('CC Account Officer'))
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

                // return response()->download(storage_path($getPath[0]->report_file_path));
            }
        }
        else
        {
            return response('');
        }
    }

    public function cc_ao_proceed_acknowledge(Request $request)
    {

        $trimmer = new Trimmer();
        $account = new bi_endorsement();
        $account = $account::find($request->id);

        if($account->status == 0 || $account->status == 21)
        {
            if($request->type == 'cc')
            {
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'status' => $request->stats,
                        'date_time_due' => $request->date_due.' '.$request->time_due,
                        'type_of_tat' => $request->type_tat,
                        'date_time_approved' => Carbon::now('Asia/Manila')
                    ]);
            }
            else if($request->type == 'cc_bank')
            {
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update
                    ([
                        'status' => $request->stats,
                        'date_time_due' => $request->date_due.' '.date("H:i", strtotime($request->time_due_bank)).':00',
                        'type_of_tat' => '',
                        'date_time_approved' => Carbon::now('Asia/Manila')
                    ]);
            }

            //---------------------GETTING THE LEAST CC TELE WITH ACCOUNTS-------------------
            $new_array = [];
            $new_arrayForCount = [];
            $new_arrayForMinVal = [];
            $passArray = '';
            $randIndex2 = '';
            $randomVal2 = '';
            $oldVal = '';
            $type_holder = $request->type;

            $dataLastAssign = DB::table('bi_last_assign')
                ->select('users_id')
                ->orderBy('id', 'desc')
                ->first();

//            if($dataLastAssign == null)
//            {
//                $dataFornull = DB::table('users')
//                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
//                    ->where('role_user.role_id', '=', 17)
//                    ->where('users.archive', '!=', 'True')
//                    ->select([
//                        'users.id as user_id'
//                    ])
//                    ->first();
//            }
//            else
//            {
            $oldVal = $dataLastAssign->users_id;
//            }

            $data = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('attendance_all_employee', 'attendance_all_employee.user_id', '=', 'users.id')
                ->where('attendance_all_employee.created_at', '<=', Carbon::now('Asia/Manila'))
                ->where('attendance_all_employee.created_at', '>=', Carbon::now('Asia/Manila')->subDay(1))
                ->where('role_user.role_id', '=', 17)
                ->where('users.archive', '!=', 'True')
                ->where(function($query) use ($type_holder)
                {
                    if($type_holder == 'cc_bank')
                    {
                        return $query->where('users.client_check', '=', $type_holder);
                    }
                    else
                    {
                        return $query->where('users.client_check', '=', '')
                            ->orwhere('users.client_check', '=', null)
                            ->orwhere('users.client_check', '=', 'tat_selector');
                    }
                })
                ->where('attendance_all_employee.type', '=', 'TIME-IN')
                ->select([
                    'users.id as user_id',
                ])
                ->get();

            if(count($data) <= 0)
            {
                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT HAS BEEN ACKNOWLEDGED';
                $logs->remarks = '-';
                $logs->save();

                $email = new EmailQueries();
                $email->cc_client_account_acknowledge_notif($request->id, Auth::user()->email);


                return 'ok';
            }
            else
            {
                for($i = 0; $i < count($data); $i++)
                {
                    $hello = DB::table('bi_endorsements_users')
                        ->where('users_id', $data[$i]->user_id)
                        ->where('finish_status', 1)
                        ->where('position_id', 17)
                        ->select('users_id')
                        ->get();

                    $new_array[$i] = $data[$i]->user_id;
                    $new_arrayForCount[$i] = count($hello);
                }

                $minVal = min($new_arrayForCount);

                for($k = 0; $k < count($new_arrayForCount); $k++)
                {
                    $new_array[$k];
                    if($new_arrayForCount[$k] == $minVal)
                    {
                        $new_arrayForMinVal[$k] = $new_array[$k];
                    }

                }

                $randIndex = array_random($new_arrayForMinVal);

                if(sizeof($new_arrayForMinVal) > 1)
                {
                    $passArray = $randIndex;
                }
                else
                {
                    for($k = 0; $k < count($new_arrayForCount); $k++)
                    {
                        if($new_arrayForCount[$k] == $minVal)
                        {
                            $passArray = $new_array[$k];
                            break;
                        }

                    }
                }

                do
                {
                    $randomIndex2 = array_random($new_arrayForMinVal);

                    $passArray = $randomIndex2;
                }
                while($passArray == $oldVal);

                DB::table('bi_last_assign')
                    ->insert(
                        [
                            'bi_endorsement_id' => $request->id,
                            'users_id' => $passArray,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                /// ASSIGNING THE SELECTED LEAST ASSIGN ACCOUNT TELE


                $dataUSER = DB::table('users')
                    ->where('id', $passArray)
                    ->select('name')
                    ->get();

                $getEndoUser = DB::table('bi_endorsements')
                    ->join('bi_account_to_users', 'bi_account_to_users.bi_account_id', '=', 'bi_endorsements.bi_id')
                    ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select
                    ([
                        'bi_account_to_users.users_id as user_id',
                        'roles.id as position'
                    ])
                    ->where('bi_endorsements.id', $request->id)
                    ->get();

                $user = User::find(Auth::user()->id);

                $endorse_user = new bi_endorsements_user();
                $endorse_user->bi_endorse_id = $request->id;
                $endorse_user->users_id = $getEndoUser[0]->user_id;
                $endorse_user->position_id = 14;
                $endorse_user->finish_status = 1;
                $endorse_user->save();

                $endorse_user = new bi_endorsements_user();
                $endorse_user->bi_endorse_id = $request->id;
                $endorse_user->users_id = Auth::user()->id;
                $endorse_user->position_id = $user->roles->first()->id;
                $endorse_user->finish_status = 1;
                $endorse_user->save();

                $endorse_user = new bi_endorsements_user();
                $endorse_user->bi_endorse_id = $request->id;
                $endorse_user->users_id = $passArray;
                $endorse_user->position_id = 17;
                $endorse_user->finish_status = 1;
                $endorse_user->save();

                $account = new bi_endorsement();
                $account = $account::find($request->id);
                $account->status = 2;
                $account->save();


                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT HAS BEEN ACKNOWLEDGED';
                $logs->remarks = '-';
                $logs->save();


                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = '-';
                $logs->position_id = 999;
                $logs->activity = 'AUTOMATICALLY ASSIGNED TO <b>'.$trimmer->trims($dataUSER[0]->name).'</b> FOR VERIFICATION';
                $logs->remarks = '-';
                $logs->save();

                $email = new EmailQueries();
                $email->cc_client_account_acknowledge_notif($request->id, Auth::user()->email);


                return 'okay';
            }
        }
        else
        {
            return 'already';
        }

    }

    public function cc_ao_tele_success_accounts()
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_tele_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', 'bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.tele_report_file_to_sao_path as path',
                'bi_endorsements.type_of_endorsement_bank as bank',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check as type_user'
            ])
            ->groupBy('bi_endorsements.id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function ($query)
            {
                return $query->orWhere('bi_endorsements.status', 3)
                    ->orWhere('bi_endorsements.status', 24);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

        return DataTables::of($get_tele_table)
            ->editColumn('due', function($get_tele_table)
            {
                if($get_tele_table->status == 24)
                {
                    return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-share-alt"></i> Returned By Client</a>';
                }
                else
                {
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $get_tele_table->due);

                    $now = Carbon::now('Asia/Manila');
                    $datenowexplode = explode(" ",$now);
                    $hoursexplode = explode(":", $datenowexplode[1]);
                    $arrayExpHoursnow = $hoursexplode[0];
                    $arrayExpMinutesnow = $hoursexplode[1];

                    $datenowexplode1 = explode(" ",$get_tele_table->due);
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

                    $difference_days = $now->diffInDays($date, false);

                    $trytrytry = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';

                    if($difference_days <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                    }
                    else if($difference_days >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days</a>';
                    }
                    else if($difference_hours <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                    }
                    else if($difference_hours >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours</a>';
                    }
                    else if($difference_mins <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                    }
                    else if($difference_mins >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                    }
                }
            })
            ->rawColumns([
                'due'
            ])
            ->make(true);
    }

    public function cc_ao_tele_dl_report(Request $request)
    {
        $id = base64_decode($request->id);

        $getData = DB::table('bi_endorsements')
            ->select('tele_report_file_to_sao_path')
            ->where('id', $id)
            ->get();

        if(Auth::user()->hasRole('CC Senior Account Officer') || Auth::user()->hasRole('CC Account Officer'))
        {
            if($getData[0]->tele_report_file_to_sao_path == null)
            {
                return response("File not Available.");
            }
            else
            {
                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'TELE ENCODER REPORT FILE DOWNLOADED';
                $logs->remarks = '';
                $logs->save();
                return response()->download(storage_path('/tele_encoder_report/'.$id.'/' . $getData[0]->tele_report_file_to_sao_path));
            }
        }
        else
        {
            return response('Wrong move.');
        }
    }

    public function cc_ao_file_to_tele(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $id = base64_decode($request->id);
        $file = $request->file('file');
        $name = '';

        if($file != null)
        {
            $name =$file->getClientOriginalName();

            $file->move(storage_path('/cc_sao_tele/'.$id.'/'), $name);

            $path = '/cc_sao_tele/'.$name;
        }
        else
        {
            $path = '';
        }

        DB::table('bi_endorsements')
            ->where('id', $id)
            ->update
            ([
                'sao_to_tele_file_path' => $name
            ]);

        $user = User::find(Auth::user()->id);
        $logs = new bi_log();
        $logs->endorse_id = $id;
        $logs->user_id = Auth::user()->id;
        $logs->position_id = $user->roles->first()->id;
        $logs->activity = 'UPLOADED AND UPDATED FILE FOR TELE ENCODER';
        $logs->remarks = $removeScript->scripttrim($request->remarks);
        $logs->save();
    }

    public function cc_ao_assign_tele(Request $request)
    {
        $trimmer = new Trimmer();
        $account = new bi_endorsement();
        $account = $account::find($request->acc_id);

        if($account->status == 2)
        {
            return 'already';
        }
        else if($account->status == 1)
        {
            $getEndoUser = DB::table('bi_endorsements')
                ->join('bi_account_to_users', 'bi_account_to_users.bi_account_id', '=', 'bi_endorsements.bi_id')
                ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select
                ([
                    'bi_account_to_users.users_id as user_id',
                    'roles.id as position'
                ])
                ->where('bi_endorsements.id', $request->acc_id)
                ->get();

            $getRoleSao = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('roles.id as id')
                ->where('users.id', Auth::user()->id)
                ->get();

            $getRole = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select
                ([
                    'roles.id as id',
                    'users.name as name'
                ])
                ->where('users.id', $request->tele_id)
                ->get();


            User::find(Auth::user()->id);
            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $request->acc_id;
            $endorse_user->users_id = $getEndoUser[0]->user_id;
            $endorse_user->position_id = $getEndoUser[0]->position;
            $endorse_user->save();

            User::find(Auth::user()->id);
            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $request->acc_id;
            $endorse_user->users_id = Auth::user()->id;
            $endorse_user->position_id = $getRoleSao[0]->id;
            $endorse_user->save();

            User::find(Auth::user()->id);
            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $request->acc_id;
            $endorse_user->users_id = $request->tele_id;
            $endorse_user->position_id = $getRole[0]->id;
            $endorse_user->save();

            $account->status = 2;
            $account->save();

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->acc_id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ASSIGNED TO TELE-ENCODER ' . $trimmer->trims($getRole[0]->name).  ' FOR VERIFICATION';
            $logs->remarks = '';
            $logs->save();

            return 'ok';
        }
        else
        {
            return 'invalid';
        }
    }

    public function cc_ao_general_search(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;
        $search_type = $request->search_methodd;
        $from = $request->min_date_endorsed;
        $to = $request->max_date_endorsed;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->join('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select([

                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.acct_report_status as status_report',
                'bi_endorsements.date_time_due as date_time_due1',
                'bi_endorsements.date_time_due as date_time_due',
                'bi_endorsements.date_time_finished as date_time_finished',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'bi_endorsements.verify_tele_status as tele_stat',
                'users.client_check as type_user'
            ])
            ->groupBy('bi_endorsements.id')
            ->where('bi_endorsements_users.position_id', 14)
            ->where(function($query) use ($search_type, $from, $to)
            {
                if($search_type != 'all')
                {
                    return $query->whereDate('bi_endorsements.created_at', '<=', $to)
                        ->whereDate('bi_endorsements.created_at', '>=', $from);
                }
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
            })
            ->where('bi_endorsements.status', '!=', 1999);

        return DataTables::of($get_general_table)
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';
//                $get_check = DB::table('bi_endorsements_checkings')
//                    ->select([
//                        'checking_name',
//                        'type_check'
//                    ])
//                    ->where('bi_endorsement_id',$query->endorse_id)
//                    ->get();
//
//                if(count($get_check) == 0)
//                {
//                    return 'NO CHECK';
//                }
//                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
//                {
//                    return 'N/A';
//                }
//                else
//                {
//                    $checkings = '';
//                    $check_alacarte = false;
//                    $get_alacarte_check = '';
//
//                    foreach($get_check as $check)
//                    {
//
//                        if($check->type_check == 'package')
//                        {
//                            $checkings.= '* '.$check->checking_name.'. <br>';
//                        }
//                        else if($check->type_check == '')
//                        {
//                            $checkings.= '* '.$check->checking_name.'. <br>';
//                        }
//                        else if($check->type_check == 'alacarte')
//                        {
//                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
//                            $check_alacarte = true;
//                        }
//                    }
//
//                    if($check_alacarte)
//                    {
//                        $checkings .= '<br>---( Additional Check )--- <br>';
//                    }
//
//                    return $checkings.$get_alacarte_check;
//                }
            })
            ->editColumn('due', function($get_general_table) use($getAuth)
            {
                $status = '';
                if($get_general_table->status != 10)
                {
                    $status = 'N/A';
                }
                else
                {
                    $dt_finish = Carbon::parse($get_general_table->date_time_finished);
                    $dt_due = Carbon::parse($get_general_table->date_time_due);

                    $answer = $dt_finish->diffInSeconds($dt_due, false);

                    if($answer <= 0)
                    {
                        $status = '<button class="btn btn-xs btn-block btn-danger" disabled>BREACH</button>';
                    }
                    else
                    {
                        $status = '<button class="btn btn-xs btn-block btn-success" disabled>TAT</button>';
                    }
                }

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

                        if($getAuth == 'cc_bank')
                        {
                            if($get_general_table->status_report == 'Contacted')
                            {
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>' . $status;
                            }
                            else
                            {
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>' . $status;
                            }
                        }
                        else
                        {
                            if($get_general_table->status_report == 'Complete')
                            {
                                return  '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>' . $status;
                            }
                            else {
                                return  '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_general_table->status_report.' </a>' . $status;
                            }
                        }


                    }
                    else if($get_general_table->status == 2)
                    {
                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>';

                        return $assigned;
                    }
                    else if($get_general_table->status == 3)
                    {
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';

                        return $succveri;
                    }
                }

            })
            ->rawColumns([
                'check',
                'due'
            ])
            ->make(true);
    }

    public function cc_ao_get_dash()
    {
        $getEndorse = DB::table('bi_endorsements')
            ->count();

        $getFinished = DB::table('bi_endorsements')
            ->where('status', 10)
            ->count();


//        $getFinished = DB::table('bi_endorsements')
//            ->where('status', 10)
//            ->count();

        $getPending = DB::table('bi_endorsements')
            ->where(function ($query)
            {
                return $query->orWhere('status',1)
                    ->orWhere('status',2)
                    ->orwhere('status', 3)
                    ->orwhere('status', 24);
            })
            ->where('cancel_bool', '!=', 'Cancelled')
            ->count();

//        $getPending = DB::table('bi_endorsements')
//            ->where(function ($query)
//            {
//                return $query->orWhere('status',0)
//                    ->orWhere('status', 21)
//                    ->orWhere('status', 2)
//                    ->orWhere('status', 3)
//                    ->orWhere('status', 1);
//            })
//            ->count();


        $getReturned = DB::table('bi_endorsements')
            ->where('status',20)
            ->orwhere('status',22)
            ->orwhere('status',23)
            ->where('cancel_bool', '!=', 'Cancelled')
            ->count();


//        $getReturned = DB::table('bi_endorsements')
//            ->where('status', 20)
//            ->orWhere('status', 22)
//            ->orWhere('status', 23)
//            ->count();

        $getHold = DB::table('bi_endorsements')
            ->where(function($query)
            {
                return $query->where('status', 4)
                    ->where('status', '!=', 4)
                    ->orwhere('cancel_bool', '=' , 'Cancelled');
            })
            ->count();

        return response()->json([$getEndorse, $getFinished , $getPending , $getReturned, $getHold]);
    }

    public function cc_ao_dl_ack(Request $request)
    {

        $id = base64_decode($request->id);
        $dl = base64_decode($request->dl);

        if(Auth::user()->hasRole('CC Account Officer'))
        {
            if(!storage_path('/cc_sao_tele/' . $id.'/'.$dl))
            {
                return 'No Available Report at the Moment.';
            }
            else
            {
                return response()->download(storage_path('/cc_sao_tele/' . $id.'/'.$dl));
            }
        }
        else
        {
            return response('');
        }
    }

    public function cc_ao_get_assigned_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements_users.position_id as pos_id',
                'bi_endorsements.sao_to_tele_file_path as sao_to_tele_file_path1',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.type_of_endorsement_bank as bank'
            ])
            ->groupBy('bi_endorsements.id')
//            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            // ->where('bi_endorsements.status', 2)
            ->where(function($query)
            {
                return $query->orwhere('bi_endorsements.status', 2)
                    ->orwhere('bi_endorsements.status', 3)
                    ->orwhere('bi_endorsements.status', 22)
                    ->orwhere('bi_endorsements.status', 24)
                    ->orwhere('bi_endorsements.status', 25);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

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

                $difference_days = $now->diffInDays($date, false);

                $getTeleName = DB::table('bi_endorsements_users')
                    ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                    ->select
                    ([
                        'users.name as user'
                    ])
                    ->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                    ->get();

                $trytrytry = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>';

                if($get_general_table->status == 24)
                {
                    return $trytrytry;
                }
                else
                {
                    if($difference_days <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                    }
                    else if($difference_days >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days</a>';
                    }
                    else if($difference_hours <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                    }
                    else if($difference_hours >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours</a>';
                    }
                    else if($difference_mins <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                    }
                    else if($difference_mins >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>';
                    }
                }
            })
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->rawColumns([
                'attachments',
                'due',
                'check',
            ])
            ->make(true);
    }

    public function cc_ao_get_assigned_to_acct(Request $request)
    {
        $getData1 = DB::table('bi_endorsements')
            ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id' , '=', 'bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            ([
                'users.name as name',
                'users.id as id'
            ])
            ->where('bi_endorsements.id', $request->id)
            ->where('bi_endorsements_users.position_id', 17)
            ->get();

        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get();

        $getData = [];

        if($getAuth[0]->client_check == 'cc_bank')
        {
            $getData = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.name as name', 'users.id as id', 'users.archive as archive')
                ->where('users.archive', '=', 'False')
                ->where('roles.name', 'CC Tele Encoder')
                ->where('users.client_check', '=','cc_bank')
                ->get();
        }
        else if($getAuth[0]->client_check != 'cc_bank')
        {
            $getData = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.name as name', 'users.id as id', 'users.archive as archive')
                ->where('users.archive', '=', 'False')
                ->where('roles.name', 'CC Tele Encoder')
                ->where('users.client_check', '!=','cc_bank')
                ->get();
        }

        $arrayToSend = [];

        for($i = 0;$i <  count($getData); $i++)
        {
            $getCountTele = DB::table('bi_endorsements_users')
                ->join('bi_endorsements', 'bi_endorsements.id', '=', 'bi_endorsements_users.bi_endorse_id')
                ->where('bi_endorsements_users.users_id', $getData[$i]->id)
                ->where('bi_endorsements.status', '!=' ,'10')
                ->count();

            $arrayToSend[$i][0] = $getData[$i]->id;
            $arrayToSend[$i][1] = $getData[$i]->name;
            $arrayToSend[$i][2] = $getCountTele;
        }

        return response()->json([$getData1, $arrayToSend]);
    }

    public function cc_ao_transfer_to_tele(Request $request)
    {
        $trimmer = new Trimmer();

        $getAttachment = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->select([
                'attach_1',
                'attach_2',
                'attach_3',
                'attach_4',
            ])
            ->get();

//        $checkDownloaded = DB::table('bi_logs')
//            ->where('endorse_id', '=', $request->id)
//            ->where('position_id', '=', 17)
//            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 1 : '. $getAttachment[0]->attach_1)
//            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 2 : '. $getAttachment[0]->attach_2)
//            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 3 : '. $getAttachment[0]->attach_3)
//            ->orwhere('activity', '=', 'DOWNLOADED ATTACHMENT 4 : '. $getAttachment[0]->attach_4)
//            ->get();
//
//        if(count($checkDownloaded) > 0)
//        {
//            return 'Downloaded';
//        }
//        else
//        {
            DB::table('bi_endorsements_users')
                ->where('bi_endorse_id', $request->id)
                ->where('position_id', 17)
                ->update
                ([
                    'users_id' => $request->newAssigned,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            $getName = DB::table('users')
                ->select('name')
                ->where('id', $request->newAssigned)
                ->get();

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT TRANSFERRED FOR VERIFICATION TO <b>' . $trimmer->trims($getName[0]->name). '</b>';
            $logs->remarks = '' ;
            $logs->save();
            
            return 'ok';
//        }


    }

    public function cc_ao_cancel_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_cancel_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select([

                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.type_of_endorsement_bank as bank'
            ])
//            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->groupBy('bi_endorsements.id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function($query)
            {
                return $query->where('bi_endorsements.status', 4)
                    ->orwhere('bi_endorsements.cancel_bool', 'Cancelled');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });

        return DataTables::of($get_cancel_table)
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->rawColumns([
                'check'
            ])
            ->make(true);
    }

    public function cc_ao_pending_cancel_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_hold_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.type_of_endorsement_bank as bank',
                'bi_endorsements.cancel_remarks as cancel_rem',
                'bi_endorsements.cancel_bool as cancel_status'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', 'Pending Cancel')
                    ->orwhere('bi_endorsements.cancel_bool', 'Pending Revoke');
            })
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            });;


        return DataTables::of($get_hold_table)
            ->editColumn('check', function ($query)
            {
                return 'Please "View Information" to see checkings';

            })
            ->rawColumns([
                'check'
            ])
            ->make(true);
    }

    public function cc_ao_cancel_new_account(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $account = new bi_endorsement();
        $account = $account::find($request->id);
        $email = new EmailQueries();

        if($account->cancel_bool == 'Cancelled')
        {
            return 'already';
        }
        else
        {
            if($account->status == 4)
            {
                DB::table('bi_endorsements')
                    ->where('id', $request->id)
                    ->update([
                        'status' => 0,
                        'cancel_bool' => ''
                    ]);

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $request->id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'ACCOUNT CANCELLED';
                $logs->remarks = $removeScript->scripttrim($request->remarks);
                $logs->save();

                $email->BICancellationRequestNotifSAO($request);

                return 'ok';
            }
            else
            {
                if($request->what == 'pending')
                {
                    DB::table('bi_endorsements')
                        ->where('id', $request->id)
                        ->update([
                            'cancel_bool'=> 'Cancelled'
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'ACCOUNT CANCELLED';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    $email->BICancellationRequestNotifSAO($request);

                    return 'ok';
                }
                else if($request->what == 'new')
                {
                    DB::table('bi_endorsements')
                        ->where('id', $request->id)
                        ->update([
                            'cancel_bool'=> 'Cancelled'
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'ACCOUNT CANCELLED';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

//                    $email->BICancellationRequestNotifSAO($request);

                    return 'ok';
                }
                else if($request->what == 'deny')
                {
                    $holderVal = '';
                    if($account->cancel_bool == 'Pending Cancel')
                    {
                        $holderVal = 'CANCELLATION';
                    }
                    else
                    {
                        $holderVal = 'REVOKE CANCELLATION';
                    }

                    $account->cancel_bool = '';
                    $account->cancel_remarks = '';
                    $account->save();

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'ACCOUNT REQUEST FOR '.$holderVal.' DENIED';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    return 'ok';
                }
                else
                {
                    DB::table('bi_endorsements')
                        ->where('id', $request->id)
                        ->update([
                            'cancel_bool'=> ''
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $request->id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'ACCOUNT UNCANCELLED';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    $email->BICancellationRequestNotifSAO($request);

                    return 'ok';
                }
            }
        }
    }

    public function cc_ao_hold_new_account(Request $request)
    {

        $account = new bi_endorsement();
        $account = $account::find($request->id);

        if($account->status == 5)
        {
            return 'already';
        }
        else
        {
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'status'=> 5
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT HOLD BY '.$user->name;
            $logs->remarks = '-' ;
            $logs->save();

            return 'ok';
        }
    }

    public function cc_ao_return_check_data_upon(Request $request)
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
    }

    public function cc_ao_get_return_checklist_return_upon(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $id = $request->id;
        $remarks = $request->remarks;
        $account = new bi_endorsement();
        $account = $account::find($request->id);
        $email = new EmailQueries();


        if($account->status == 20)
        {
            return 'already';
        }
        else if($account->status == 0)
        {
            $account->status = 20;
            $account->save();

            $getData = DB::table('bi_endorsements')
                ->select('bi_id', 'account_name')
                ->where('id', $request->id)
                ->get();

            DB::table('bi_account_to_users')
                ->where('bi_account_id', $getData[0]->bi_id)
                ->update
                ([
                    'return_stat' => 1,
                    'message_notif' => 1,
                ]);
            $getuser = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'date_time_return' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find(Auth::user()->id);
            $what_pos = Auth::user()->id;
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'RETURNED ACCOUNT PLEASE SEE REMARKS';
            $logs->remarks = $remarks;
            $logs->save();

            $messageNotif = new AuditQueries();
            $email->ReportReturnToClient($id, $remarks,$what_pos, $user->roles->first()->name);

            $activity = 'Account name of ' . $getData[0]->account_name . ' is returned with incomplete attachments by ' . $getuser[0]->name;
            $messageNotif->message_notif_bi($activity, $request->id, Auth::user()->id, $getData[0]->bi_id);
        }
        else if($account->status == 21)
        {
            $account->status = 20;
            $account->save();

            $getData = DB::table('bi_endorsements')
                ->select('bi_id', 'account_name')
                ->where('id', $request->id)
                ->get();

            DB::table('bi_account_to_users')
                ->where('bi_account_id', $getData[0]->bi_id)
                ->update
                ([
                    'return_stat' => 1,
                    'message_notif' => 1,
                ]);
            $getuser = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'date_time_return' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find(Auth::user()->id);
            $what_pos = Auth::user()->id;
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'RETURNED ACCOUNT PLEASE SEE REMARKS';
            $logs->remarks = $remarks;
            $logs->save();


            $messageNotif = new AuditQueries();
            $email->ReportReturnToClient($id, $remarks,$what_pos, $user->roles->first()->name);

            $activity = 'Account name of ' . $getData[0]->account_name . ' is returned with incomplete attachments by ' . $getuser[0]->name;
            $messageNotif->message_notif_bi($activity, $request->id, Auth::user()->id, $getData[0]->bi_id);
        }
        else if($account->status == 3)
        {
            $account->status = 22;
            $account->save();

            $getData = DB::table('bi_endorsements')
                ->select('bi_id', 'account_name')
                ->where('id', $request->id)
                ->get();

            DB::table('bi_account_to_users')
                ->where('bi_account_id', $getData[0]->bi_id)
                ->update
                ([
                    'return_stat' => 1,
                    'message_notif' => 1,
                ]);
            $getuser = DB::table('users')
                ->select('name')
                ->where('id', Auth::user()->id)
                ->get();

            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update
                ([
                    'date_time_return' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find(Auth::user()->id);
            $what_pos = Auth::user()->id;
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'RETURNED ACCOUNT PLEASE SEE REMARKS';
            $logs->remarks = $remarks;
            $logs->save();


            $messageNotif = new AuditQueries();
            $email->ReportReturnToClient($id, $remarks,$what_pos, $user->roles->first()->name);

            $activity = 'Account name of ' . $getData[0]->account_name . ' is returned with incomplete attachments by ' . $getuser[0]->name;
            $messageNotif->message_notif_bi($activity, $request->id, Auth::user()->id, $getData[0]->bi_id);
        }
    }

    public function cc_ao_get_reason_of_delay(Request $request)
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

    public function cc_ao_return_to_tele(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $data = DB::table('bi_endorsements')
            ->select('status')
            ->where('id', $request->id)
            ->get();

        $status = $data[0]->status;

        if($status == 23 || $status == 2)
        {
            return 'already';
        }
        else if($status == 3)
        {
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update([
                    'status' => 2
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT RETURNED TO TELE';
            $logs->remarks = $removeScript->scripttrim($trimmer->trims($request->remarks));
            $logs->save();
        }
        else if($status == 24 || $status == 10)
        {
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update([
                    'status' => 25
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT RETURNED TO TELE';
            $logs->remarks = $removeScript->scripttrim($trimmer->trims($request->remarks));
            $logs->save();
        }
    }

    public function cc_ao_uncancel_account(Request $request)
    {
        $data = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->select('cancel_bool')
            ->get();

        if($data[0]->cancel_bool == '')
        {
            return 'already';
        }
        else if($data[0]->cancel_bool == 'Cancelled')
        {
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update([
                    'cancel_bool' => ''
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT UNCANCELLED, PLEASE SEE REMARKS FOR DETAILS';
            $logs->remarks = '-' ;
            $logs->save();

            return 'ok';
        }
    }

    public function cc_ao_unhold_account(Request $request)
    {
        $data = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->get();

        if($data[0]->status == 5)
        {
            DB::table('bi_endorsements')
                ->where('id', $request->id)
                ->update([
                    'status' => 0
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $request->id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ACCOUNT UNHOLD, PLEASE SEE REMARKS FOR DETAILS';
            $logs->remarks = '-' ;
            $logs->save();

            return 'ok';
        }
        else if($data[0]->status == 0)
        {
            return 'already';
        }
    }

    public function cc_ao_check_type_tat(Request $request)
    {
        $data = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->get();

        if($data[0]->type_of_tat == 'Regular')
        {
            $dayToAdd = 7;
        }
        else
        {
            $dayToAdd = 3;
        }

        $now = Carbon::now('Asia/Manila');

        $final_date = $now->addDays($dayToAdd);

        return response()->json([$data,$final_date]);
    }

    public function cc_ao_check_if_sitel(Request $request)
    {
        $daysToAdd = 0;
        $type_of_tat = '';
        $ito_return = '';
        $final_date = '';
        $date_due = '';

        $checkType = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->select('type_of_endorsement_bank', 'where_send', 'created_at')
            ->get();


        if($request->tat_type == 'Regular 7')
        {
            $daysToAdd = 7;
            $ito_return = $request->tat_type;
            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'Regular')
        {
            $daysToAdd = 7;
            $ito_return = $request->tat_type;
            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'Regular 5')
        {
            $daysToAdd = 5;
            $ito_return = $request->tat_type;
            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'Interim Report 3')
        {
            $daysToAdd = 3;
            $ito_return = $request->tat_type;
            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'Special B.I 1')
        {
            $daysToAdd = 1;
            $ito_return = $request->tat_type;
            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'Expedite')
        {
            $daysToAdd = 3;
            $ito_return = $request->tat_type;

            $now = Carbon::now('Asia/Manila');
            $final_date = $now->addDays($daysToAdd);
        }
        else if($request->tat_type == 'PDRN' || $request->tat_type == 'BVR' || $request->tat_type == 'EVR' || $request->tat_type != '' || $request->tat_type != null)
        {
            $ito_return = '-';
            $datePhase = Carbon::parse($checkType[0]->created_at)->toTimeString();
            $formatToInt = (int)explode(':', $datePhase)[0];
            $formatToInt2 = (int)explode(':', $datePhase)[1];

            if($formatToInt <= 7)
            {
                $date_due = '11:30 AM';
                $final_date = Carbon::parse($checkType[0]->created_at);
            }
            else if($formatToInt <= 8)
            {
                $date_due = Carbon::parse($checkType[0]->created_at)->addHours(3)->addMinutes(30)->format('g:i A');
                $final_date = Carbon::parse($checkType[0]->created_at);
            }
            else if($formatToInt <= 12)
            {
                $date_due = Carbon::parse($checkType[0]->created_at)->addHours(4)->addMinutes(30)->format('g:i A');
                $final_date = Carbon::parse($checkType[0]->created_at);
            }
            else if($formatToInt <= 15)
            {
                $date_due = Carbon::parse($checkType[0]->created_at)->addHours(3)->addMinutes(30)->format('g:i A');
                $final_date = Carbon::parse($checkType[0]->created_at);
            }
            else if($formatToInt >= 16)
            {
                if($formatToInt == 16 && $formatToInt2 == 0)
                {
                    $date_due = Carbon::parse($checkType[0]->created_at)->addHours(3)->addMinutes(30)->format('g:i A');
                    $final_date = Carbon::parse($checkType[0]->created_at);
                }
                else
                {
                    $date_due = Carbon::tomorrow('Asia/Manila')->addHours(11)->addMinutes(30)->format('g:i A');
                    $final_date = Carbon::parse($checkType[0]->created_at)->addDay(1);
                }
            }
        }

        if(!$final_date->isWeekday())
        {
            do{
                $date_due = '11:30 AM';
                $final_date->addDay(1);
            }
            while($final_date->dayOfWeek == Carbon::SATURDAY || $final_date->dayOfWeek == Carbon::SUNDAY);
        }



        return response()->json([$ito_return, $final_date, $checkType[0]->type_of_endorsement_bank, $checkType[0]->where_send, $date_due]);
    }

    public function notify_required_docs(Request $request)
    {
        $removScript = new ScriptTrimmer();
        DB::table('bi_logs')
            ->insert([
                'endorse_id' => $request->id,
                'user_id' => Auth::user()->id,
                'position_id' => 16,
                'type' => 'require_doc',
                'remarks' => $removScript->scripttrim($request->remarks),
                'activity' => 'NOTIFIED THE CLIENT FOR REQUIRED DOCUEMENTS',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $getData = DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->get();

        $messageNotif = new AuditQueries();

        $activity = Auth::user()->name. ' is requesting a required documents for the account of ' . $getData[0]->account_name;
        $messageNotif->message_notif_bi($activity, $request->id, Auth::user()->id, $getData[0]->bi_id);

        return 'Successfully Notified the Client';
    }

    public function cc_ao_get_client_type()
    {
        $getClient = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        return response()->json($getClient);
    }

    public function get_tele_grant_table()
    {
        $info = DB::table('users')
            ->leftJoin('tele_contacts_grant', 'tele_contacts_grant.user_id', '=', 'users.id')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 17)
            ->select([
                'users.id as id',
                'users.name as name',
                'tele_contacts_grant.created_at as created_at',
                'tele_contacts_grant.access as access',
            ]);


        return DataTables::of($info)
            ->make(true);
    }

    public function cc_ao_granting_tele(Request $request)
    {
        $checkRec = DB::table('tele_contacts_grant')
            ->where('user_id', $request->id)
            ->select('id')
            ->get();

        if($request->type == 'grant')
        {
            if(count($checkRec) != 0)
            {
                DB::table('tele_contacts_grant')
                    ->where('id', $checkRec[0]->id)
                    ->update([
                        'access' => 'Deny',
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                return 'asdasd';
            }
            else if(count($checkRec) == 0)
            {
                DB::table('tele_contacts_grant')
                    ->insert([
                        'user_id' => $request->id,
                        'access' => 'Deny',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }
        else if($request->type =='deny')
        {
            if(count($checkRec) != 0)
            {
                DB::table('tele_contacts_grant')
                    ->where('id', $checkRec[0]->id)
                    ->update([
                        'access' => 'Grant',
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                return 'asdasd';
            }
            else if(count($checkRec) > 0)
            {
                DB::table('tele_contacts_grant')
                    ->insert([
                        'user_id' => $request->id,
                        'access' => 'Grant',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }
    }

    public function cc_ao_get_general_mon_table(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//            ->join('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
            ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
            ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
//                'bi_endorsements_checkings.checking_name as check',
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
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check',
                'users.id'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id',14)
            ->whereDate('bi_endorsements.created_at', '<=', $request->max_date_endorsed)
            ->whereDate('bi_endorsements.created_at', '>=', $request->min_date_endorsed)
            ->where(function($query) use($getAuth)
            {
                if($getAuth == 'tat_selector')
                {
                    return $query->orwhere('users.client_check','=', $getAuth)
                        ->orwhere('users.client_check', '=', '');
                }
                else if($getAuth == 'cc_bank')
                {
                    return $query->where('users.client_check','=', $getAuth);
                }
//                else
//                {
//                    return $query->where('users.client_check','=', '');
//                }
            })
            ->where('bi_endorsements.status', '!=',1999);


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

                        $difference_days = $now->diffInDays($date. false);

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' .$thisShow ;
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

                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>';

                        if($difference_days <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
                        }
                        else if($difference_days >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>' .$thisShow;
                        }
                        else if($difference_hours <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;

                        }
                        else if($difference_hours >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>' .$thisShow;
                        }
                        else if($difference_mins <= -1)
                        {
                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;

                        }
                        else if($difference_mins >= 1)
                        {
                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
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
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
                        }
                        else if($difference_days >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>' .$thisShow;
                        }
                        else if($difference_hours <= -1)
                        {
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;

                        }
                        else if($difference_hours >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>' .$thisShow;
                        }
                        else if($difference_mins <= -1)
                        {
                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;

                        }
                        else if($difference_mins >= 1)
                        {
                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
                        }
                    }
                }

            })
            ->editColumn('check', function ($query)
            {

                return 'Please "View Information" to see checkings';

//                $get_check = DB::table('bi_endorsements_checkings')
//                    ->select([
//                        'checking_name',
//                        'type_check'
//                    ])
//                    ->where('bi_endorsement_id',$query->endorse_id)
//                    ->get();
//
//                if(count($get_check) == 0)
//                {
//                    return 'NO CHECK';
//                }
//                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
//                {
//                    return 'N/A';
//                }
//                else
//                {
//                    $checkings = '';
//                    $check_alacarte = false;
//                    $get_alacarte_check = '';
//
//                    foreach($get_check as $check)
//                    {
//
//                        if($check->type_check == 'package')
//                        {
//                            $checkings.= '* '.$check->checking_name.'. <br>';
//                        }
//                        else if($check->type_check == '')
//                        {
//                            $checkings.= '* '.$check->checking_name.'. <br>';
//                        }
//                        else if($check->type_check == 'alacarte')
//                        {
//                            $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
//                            $check_alacarte = true;
//                        }
//                    }
//
//                    if($check_alacarte)
//                    {
//                        $checkings .= '<br>---( Additional Check )--- <br>';
//                    }
//
//                    return $checkings.$get_alacarte_check;
//                }
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
            ->rawColumns([
                'attachments',
                'due',
                'check',
                'assigned_tele',
            ])
            ->toJson();
    }

    public function cc_ao_get_bi_checkings(Request $request)
    {
        $package = DB::table('bi_endorsements')
            ->join('package_to_account', 'package_to_account.bi_account_id', '=', 'bi_endorsements.bi_id')
            ->join('package_list', 'package_list.id', '=', 'package_to_account.package_id')
            ->select([
                'package_list.package as pck_name',
                'package_list.id as id',
                'bi_endorsements.client_remarks_bank as rem'
            ])
            ->where('bi_endorsements.id', $request->id)
            ->get();

        $check = DB::table('bi_endorsements')
            ->join('package_to_account', 'package_to_account.bi_account_id', '=', 'bi_endorsements.bi_id')
            ->join('package_list', 'package_list.id', '=', 'package_to_account.package_id')
            ->join('checking_to_package', 'checking_to_package.package_to_account_id', '=', 'package_to_account.package_id')
            ->join('checking_list', 'checking_list.id', '=', 'checking_to_package.checking_id')
            ->select([
                'checking_to_package.checking_id as chck_id',
                'checking_list.checking_name as chck_name',
                'checking_to_package.package_to_account_id as pck_id',
                'package_list.package as pck_name'
            ])
            ->where('bi_endorsements.id', $request->id)
            ->get();

        return response()->json([$package, $check]);
    }

    public function cc_ao_get_selected_packages_checkings(Request $request)
    {
        $getChecks = DB::table('checking_list')
            ->join('checking_to_package', 'checking_to_package.checking_id', '=', 'checking_list.id')
            ->where('checking_to_package.package_to_account_id', $request->id)
            ->select([
                'checking_list.checking_name as chk_name'
            ])
            ->get();

        return response()->json([$getChecks]);
    }

    public function cc_ao_add_checking_packages_api_endo(Request $request)
    {
        DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->update([
//                'status' => 1,
                'package' => $request->package,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        for($i = 0; $i < count($request->check_array); $i++)
        {
            DB::table('bi_endorsements_checkings')
                ->insert([
                    'bi_endorsement_id' => $request->id,
                    'checking_id' => '0',
                    'checking_name' => $request->check_array[$i][0],
                    'type_check' => $request->check_array[$i][1],
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }

//        $user = User::find(Auth::user()->id);
//        $logs = new bi_log();
//        $logs->endorse_id = $request->id;
//        $logs->user_id = Auth::user()->id;
//        $logs->position_id = $user->roles->first()->id;
//        $logs->activity = 'ACCOUNT HAS BEEN ACKNOWLEDGE';
//        $logs->remarks = 'ADDED A CHECK/PACKAGE' ;
//        $logs->save();

        return 'ok';
    }
}
