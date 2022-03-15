<?php

namespace App\Http\Controllers;

use App\bi_log;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\User;
use Carbon\Carbon;
use Browser;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class CCTeleEncoderController extends Controller
{
    public function ccTelePanel()
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
            } elseif (Auth::user()->hasRole('CC Tele Encoder')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;

                return view('cc_dept.tele-encoder.cc-tele-encoder-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function cc_tele_encoder_table_acknowledged()
    {
//        $getAuth = DB::table('users')
//            ->select('client_check')
//            ->where('id', Auth::user()->id)
//            ->get()[0]->client_check;

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_endorsements_users as tele_user','tele_user.bi_endorse_id','=','bi_endorsements.id')
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
                'bi_endorsements.sao_to_tele_file_path as file_path',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.type_of_endorsement_bank as bank'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where(function($query)
            {
                $query->orwhere('bi_endorsements.status',2)
                    ->orwhere('bi_endorsements.status',23)
                    ->orwhere('bi_endorsements.status',25);
            })
            ->where(function($query)
            {
                $query->where('bi_endorsements_users.position_id', 17)
                    ->where('bi_endorsements_users.users_id',Auth::user()->id);
            })
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            });
//            ->where('bi_endorsements_users.position_id', 14);

        return DataTables::of($get_general_table)
            ->editColumn('attachments', function ($query)
            {
//                $get_check = DB::table('bi_endorsements_checkings')
//                    ->select([
//                        'checking_name',
//                        'type_check'
//                    ])
//                    ->where('bi_endorsement_id',$query->endorse_id)
//                    ->get();

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
//                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
//                {
//                    return 'N/A';
//                }
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

                if($get_general_table->status == 23)
                {
                    return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned</a>';
                }
                else
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

                    $trytrytry = '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Assigned</a>';

                    if($difference_days <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';
                    }
                    else if($difference_days >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>';
                    }
                    else if($difference_hours <= -1)
                    {
                        return $trytrytry.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>';

                    }
                    else if($difference_hours >= 1)
                    {
                        return $trytrytry.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>';
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
                        else if($check->type_check == 'N/A')
                        {
                            return 'N/A';
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

    public function cc_tele_send_rep_sao(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trims = new Trimmer();
        $id = base64_decode($request->id);
        $file = $request->file('file');
        $name = '';
        $contacted_details = '';
        $levelHold = '';

        $data = DB::table('bi_endorsements')
            ->select('status','verify_tele_status', 'bi_account_name', 'account_name')
            ->where('id', $id)
            ->get();


        $level2 = DB::table('cc_tele_levels')
            ->where('user_id', '=', Auth::user()->id)
            ->select('level')
            ->get();

        if(count($level2) > 0)
        {
            $levelHold = $level2[0]->level;
        }
        else
        {
            $levelHold = '1';
        }


        $strAccountName = $data[0]->account_name;
        $strAccountName = preg_replace('/[ ,]+/', '', $strAccountName);


        $strBIAccntName= $data[0]->bi_account_name;
        $strBIAccntName = preg_replace('/[ ,]+/', '', $strBIAccntName);

        $now = Carbon::now('Asia/Manila');

        $now = preg_replace('/[-: ]+/', '', $now);

        if($request->stat == 'Contacted')
        {
            DB::table('bi_endorsements')
                ->where('id', $id)
                ->update
                ([
                    'verify_tele_status_details' => $request->contacted_details
                ]);
        }
        else if($request->stat == 'Uncontacted')
        {
            DB::table('bi_endorsements')
                ->where('id', $id)
                ->update
                ([
                    'verify_tele_status_details' => $request->contacted_details
                ]);
        }

        if($file != null || $file != '')
        {
            $nameforRem =$file->getClientOriginalName();
            $toUploadFile = $strBIAccntName.$strAccountName.$id.$now.'.'.$file->getClientOriginalExtension();

        }
        else
        {
            $nameforRem = '';
            $toUploadFile = '';
        }

        if($data[0]->status == 3 || $data[0]->status == 24)
        {
            return 'already';
        }
        else if(($data[0]->status == 2 && $request->stat == 'Complete') || ($data[0]->status == 2 && $request->stat == 'Contacted'))
        {
            if($file != null)
            {
                $name = $toUploadFile;

                if($levelHold == '2')
                {
                    $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);
//                    copy(storage_path('/tele_encoder_report/'.$id.'/'.$name), storage_path('/endorsement_client_report/'.$id.'/'.$name));

                    DB::table('bi_endorsements')
                        ->where('id', $id)
                        ->update
                        ([
                            'verify_tele_status' => $request->stat,
                            'acct_report_status' => $request->stat,
                            'tele_report_file_to_sao_path' => $name,
                            'report_remarks' => $removeScript->scripttrim($request->remarks),
                            'date_time_finished' => Carbon::now('Asia/Manila'),
                            'report_file_path' => '/endorsement_client_report/'.$id.'/'.$name,
                            'status' => 10
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REPORT SENT TO THE CLIENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    DB::table('bi_endorsements_users')
                        ->where('users_id', Auth::user()->id)
                        ->where('bi_endorse_id', $id)
                        ->update(
                            [
                                'finish_status' => 0,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                    return 'ok';
                }
                else
                {
                    $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);

                    DB::table('bi_endorsements')
                        ->where('id', $id)
                        ->update
                        ([
                            'verify_tele_status' => $request->stat,
                            'tele_report_file_to_sao_path' => $name,
                            'status' => 3
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REPORT SENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    DB::table('bi_endorsements_users')
                        ->where('users_id', Auth::user()->id)
                        ->where('bi_endorse_id', $id)
                        ->update(
                            [
                                'finish_status' => 0,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                    return 'ok';
                }



            }
            else
            {
                return 'need';
            }


        }
        else if(($data[0]->status == 2 && $request->stat == 'Incomplete') || ($data[0]->status == 2 && $request->stat == 'Uncontacted'))
        {

            if($file != null)
            {
                $name = $toUploadFile;

                if($levelHold == '2')
                {
                    $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);
//                    copy(storage_path('/tele_encoder_report/'.$id.'/'.$name), storage_path('/endorsement_client_report/'.$id.'/'.$name));

                    DB::table('bi_endorsements')
                        ->where('id', $id)
                        ->update
                        ([
                            'verify_tele_status' => $request->stat,
                            'acct_report_status' => $request->stat,
                            'tele_report_file_to_sao_path' => $name,
                            'report_remarks' => $removeScript->scripttrim($request->remarks),
                            'date_time_finished' => Carbon::now('Asia/Manila'),
                            'report_file_path' => '/endorsement_client_report/'.$id.'/'.$name,
                            'status' => 10
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REPORT SENT TO THE CLIENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    DB::table('bi_endorsements_users')
                        ->where('users_id', Auth::user()->id)
                        ->where('bi_endorse_id', $id)
                        ->update(
                            [
                                'finish_status' => 0,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                    return 'ok';
                }
                else
                {
                    $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);

                    DB::table('bi_endorsements')
                        ->where('id', $id)
                        ->update
                        ([
                            'verify_tele_status' => $request->stat,
                            'tele_report_file_to_sao_path' => $name,
                            'status' => 3
                        ]);

                    $user = User::find(Auth::user()->id);
                    $logs = new bi_log();
                    $logs->endorse_id = $id;
                    $logs->user_id = Auth::user()->id;
                    $logs->position_id = $user->roles->first()->id;
                    $logs->activity = 'REPORT SENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
                    $logs->remarks = $removeScript->scripttrim($request->remarks);
                    $logs->save();

                    DB::table('bi_endorsements_users')
                        ->where('users_id', Auth::user()->id)
                        ->where('bi_endorse_id', $id)
                        ->update(
                            [
                                'finish_status' => 0,
                                'updated_at' => Carbon::now('Asia/Manila')
                            ]);

                    return 'ok';
                }



            }
            else
            {
                return 'need';
            }

        }
        else if(($data[0]->status == 25 && $request->stat == 'Complete') || ($data[0]->status == 25 && $request->stat == 'Contacted'))
        {

            if($file != null)
            {
                $name =$toUploadFile;
                $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);

                DB::table('bi_endorsements')
                    ->where('id', $id)
                    ->update
                    ([
                        'verify_tele_status' => $request->stat,
                        'tele_report_file_to_sao_path' => $name,
                        'status' => 24
                    ]);

                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'REPORT SENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
                $logs->remarks = $removeScript->scripttrim($request->remarks);
                $logs->save();

                DB::table('bi_endorsements_users')
                    ->where('users_id', Auth::user()->id)
                    ->where('bi_endorse_id', $id)
                    ->update(
                        [
                            'finish_status' => 0,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                return 'ok';

            }
            else
            {
                return 'need';
            }

        }
        else if(($data[0]->status == 25 && $request->stat == 'Incomplete') || ($data[0]->status == 25 && $request->stat == 'Uncontacted'))
        {
            if($file != null)
            {
                $name =$toUploadFile;
                $file->move(storage_path('/tele_encoder_report/'.$id.'/'), $name);
            }
            else
            {
                $name = '';
            }


            DB::table('bi_endorsements')
                ->where('id', $id)
                ->update
                ([
                    'verify_tele_status' => $request->stat,
                    'tele_report_file_to_sao_path' => $name,
                    'status' => 24
                ]);

            $user = User::find(Auth::user()->id);
            $logs = new bi_log();
            $logs->endorse_id = $id;
            $logs->user_id = Auth::user()->id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'REPORT SENT WITH THE STATUS OF <b>' .$trims->trims($request->stat).'</b> AND UPLOADED A REPORT FILE WITH ATTACHMENT NAME <b>'.$trims->trims($nameforRem). '</b> RENAMED TO <b>' .$trims->trims($toUploadFile).'</b>';
            $logs->remarks = $removeScript->scripttrim($request->remarks);
            $logs->save();

            DB::table('bi_endorsements_users')
                ->where('users_id', Auth::user()->id)
                ->where('bi_endorse_id', $id)
                ->update(
                    [
                        'finish_status' => 0,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

            return 'ok';

        }
    }

    public function cc_tele_dl_sao_report(Request $request)
    {
        $id = base64_decode($request->id);
        $dl = base64_decode($request->dl);

        if(Auth::user()->hasRole('CC Tele Encoder'))
        {
            if(!storage_path('/cc_sao_tele/'.$id.'/'.$dl))
            {
                return 'No Available Report at the Moment.';
            }
            else
            {
                $user = User::find(Auth::user()->id);
                $logs = new bi_log();
                $logs->endorse_id = $id;
                $logs->user_id = Auth::user()->id;
                $logs->position_id = $user->roles->first()->id;
                $logs->activity = 'UPLOADED SAO/AO FILE DOWNLOADED '.$dl;
                $logs->remarks = '';
                $logs->save();

                return response()->download(storage_path('/cc_sao_tele/'. $id.'/'.$dl));
            }
        }
        else
        {
            return response('');
        }
    }

    public function cc_tele_general_search(Request $request)
    {
        $getAuth = Auth::user()->client_check;
        $get_general_table = [];

        if($getAuth == 'cc_bank')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                // ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select
                ([
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1',
                    'bi_endorsements.type_of_endorsement_bank as bank',
                    'users.client_check as type_user'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_endorsements_users.position_id', 14)
                ->where('users.client_check', '=', 'cc_bank');
        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                // ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                ->select
                ([

                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as date_time_due1'.
                    'bi_endorsements.type_of_endorsement_bank as bank',
                    'users.client_check as type_user'
                ])
                ->groupBy('bi_endorsements.id')
                //                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->where('bi_endorsements_users.position_id', 14)
                ->where('users.client_check', '!=', 'cc_bank');
        }

        return DataTables::of($get_general_table)
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

    public function cc_tele_get_dash()
    {
        $getEndorse = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query)
            {
                $query->orwhere('bi_endorsements.status',2)
                    ->orwhere('bi_endorsements.status',3)
                    ->orwhere('bi_endorsements.status',10)
                    ->orwhere('bi_endorsements.status',23)
                    ->orwhere('bi_endorsements.status',25);
            })
            ->where('bi_endorsements_users.position_id', 17)
            ->where('bi_endorsements_users.users_id', Auth::user()->id)
            ->count();

        $getPending = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->where(function($query)
            {
                return $query->where('bi_endorsements.cancel_bool', '!=', 'Cancelled')
                    ->orwhere('bi_endorsements.cancel_bool', '=', null)
                    ->orwhere('bi_endorsements.cancel_bool', '=', '');
            })
            ->where(function($query)
            {
                $query->orwhere('bi_endorsements.status',2)
                    ->orwhere('bi_endorsements.status',23)
                    // ->orwhere('bi_endorsements.status',24)
                    ->orwhere('bi_endorsements.status',25);
            })
            ->where('bi_endorsements_users.position_id', 17)
            ->where('bi_endorsements_users.users_id', Auth::user()->id)
            ->count();

        $getFinish = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->where(function($query)
            {
                $query->orwhere('bi_endorsements.status',3)
                    ->orwhere('bi_endorsements.status',10);
            })
            ->where('bi_endorsements_users.position_id', 17)
            ->where('bi_endorsements_users.users_id', Auth::user()->id)
            ->count();

        $getReturned = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
            ->where(function($query)
            {
                $query->orwhere('bi_endorsements.status',23)
                    ->orwhere('bi_endorsements.status',24)
                    ->orwhere('bi_endorsements.status',25);
            })
            ->where('bi_endorsements_users.position_id', 17)
            ->where('bi_endorsements_users.users_id', Auth::user()->id)
            ->count();

        $getUser = DB::table('users')
            ->select('name')
            ->where('id', Auth::user()->id)
            ->get()[0]->name;

        return response()->json([$getEndorse, $getPending, $getFinish, $getReturned, $getUser]);
    }

    public function cc_tele_view_reason(Request $request)
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

    public function cc_tele_finished_accounts(Request $request)
    {
        $getAuth = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        $get_finished = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_endorsements_users as tele_user','tele_user.bi_endorse_id','=','bi_endorsements.id')
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
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.sao_to_tele_file_path as file_path',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.type_of_endorsement_bank as bank',
                'users.client_check as type_user',
                'users.id as id',
                'bi_endorsements.acct_report_status as rep_stat'
            ])
            ->groupBy('bi_endorsements.id')
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
            ->where('bi_endorsements_users.position_id', 17)
            ->where('bi_endorsements_users.users_id',Auth::user()->id)
//            ->where('bi_endorsements_users.position_id', 14)
            ->where(function($query)
            {
                return $query->where('bi_endorsements.status', 10)
                    ->orwhere('bi_endorsements.status', 3)
                    ->orwhere('bi_endorsements.status', 24);
            });

        return DataTables::of($get_finished)
            ->editColumn('attachments', function ($query)
            {
//                $get_check = DB::table('bi_endorsements_checkings')
//                    ->select([
//                        'checking_name',
//                        'type_check'
//                    ])
//                    ->where('bi_endorsement_id',$query->endorse_id)
//                    ->get();

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
//                else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
//                {
//                    return 'N/A';
//                }
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
            ->editColumn('due', function($get_finished)
            {
                if($get_finished->type_user == 'cc_bank')
                {
                    $additive_haha = '';
                    if($get_finished->status == 10)
                    {
                        $additive_haha = '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-check"></i> Successful Sent</a>';

                        if($get_finished->rep_stat == 'Contacted')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-ok"></i> '.$get_finished->rep_stat.'</a>' .  $additive_haha;
                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-spinner"></i> '.$get_finished->rep_stat.'</a>' .  $additive_haha;
                        }
                    }
                    else if($get_finished->status == 24 || $get_finished->status == 3)
                    {
                        $additive_haha = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-unchecked"></i> Pending for Sending</a>';

                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-ok"></i> Successful Verification</a>' .  $additive_haha;
                    }
                }
                else
                {
                    if($get_finished->status == 10)
                    {
                        $additive_haha = '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-check"></i> Successful Sent</a>';

                        return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-ok"></i> Finished</a>' .  $additive_haha;
                    }
                    else if($get_finished->status == 24 || $get_finished->status == 3)
                    {
                        $additive_haha = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-unchecked"></i> Pending for Sending</a>';
                        return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-ok"></i> Successful Verification</a>' .  $additive_haha;
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

    public function cc_tele_get_account_checking(Request $request)
    {
        $getInfo = DB::table('bi_endorsements')
            ->join('bi_endorsements_checkings', 'bi_endorsements_checkings.bi_endorsement_id', '=', 'bi_endorsements.id')
            ->join('provinces', 'provinces.id', '=', 'bi_endorsements.present_province')
            ->join('municipalities', 'municipalities.id', '=', 'bi_endorsements.present_muni')
            ->select([
                'bi_endorsements_checkings.checking_name as checking_name',
                'bi_endorsements_checkings.checking_name as checking_name',
                'bi_endorsements.account_name as endorsed_name',
                'bi_endorsements.birth_day as day',
                'bi_endorsements.birth_month as month',
                'bi_endorsements.birth_year as year',
                'bi_endorsements.present_address as present_address',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.created_at as endorsed_date',
                'provinces.name as prov',
                'municipalities.muni_name as muni'
            ])
            ->where('bi_endorsements.id', $request->id)
            ->get();

        $getLogs = DB::table('cc_tele_encoded_report_logs')
            ->where('user_id', Auth::user()->id)
            ->groupBy('bi_endorse_id')
            ->get();

        $address = $getInfo[0]->present_address . ' '. $getInfo[0]->muni. ' '. $getInfo[0]->prov;
        $bday = Carbon::parse($getInfo[0]->month.'/'.$getInfo[0]->day.'/'.$getInfo[0]->year)->format('Y-m-d');

        return response()->json([$getInfo, $bday, $address, $getLogs]);
    }

    public function insert_tele_encoded_data(Request $request)
    {
        $logId = '';
        $getLogId = DB::table('cc_tele_encoded_report_logs')
            ->where('bi_endorse_id', $request->endorsement_id)
            ->select('report_log_id')
            ->get();

        $getCount = DB::table('cc_tele_encoded_report_logs')
            ->count();

        $now = Carbon::now('Asia/Manila');
        $now = preg_replace('/[-: ]+/', '', $now);

        if(count($getLogId) > 0)
        {
            $logId = $getLogId[0]->report_log_id;
        }
        else
        {
            $logId = 'teleRep_' . $now . '_' .$getCount;
        }

        $i = 0;
        for($i = 0; $i < count($request->dataInputtedd); $i++)
        {
            DB::table('cc_tele_encoded_data')
                ->insert
                ([
                    'user_id' => Auth::user()->id,
                    'report_log_id' => $logId,
                    'bi_endorsement_id' => $request->endorsement_id,
                    'checking_name' => $request->checking_type,
                    'label' => $request->dataLabel[$i],
                    'inputted' => $request->dataInputtedd[$i],
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }

        DB::table('cc_tele_encoded_report_logs')
            ->insert([
                'report_log_id' => $logId,
                'bi_endorse_id' => $request->endorsement_id,
                'user_id' => Auth::user()->id,
                'activity' => $request->checking_type,
                'created_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function cc_tele_logs_data(Request $request)
    {
        $getData = DB::table('cc_tele_encoded_data')
            ->join('cc_tele_encoded_report_logs', 'cc_tele_encoded_report_logs.report_log_id', '=', 'cc_tele_encoded_data.report_log_id')
            ->where('cc_tele_encoded_data.report_log_id', $request->log_id)
            ->select([
                'cc_tele_encoded_data.report_log_id as report_log_id',
//                'cc_tele_encoded_data.label as label',
//                'cc_tele_encoded_data.inputted as inputted',
                'cc_tele_encoded_data.checking_name as checking_name'
            ])
            ->groupBy('cc_tele_encoded_data.checking_name')
            ->get();

        $getLogCount = DB::table('cc_tele_encoded_data')
            ->join('cc_tele_encoded_report_logs', 'cc_tele_encoded_report_logs.report_log_id', '=', 'cc_tele_encoded_data.report_log_id')
            ->where('cc_tele_encoded_data.report_log_id', $request->log_id)
            ->select([
//                'cc_tele_encoded_data.label as label',
//                'cc_tele_encoded_data.inputted as inputted',
                'cc_tele_encoded_data.checking_name as checking_name'
            ])
            ->groupBy('cc_tele_encoded_data.checking_name')
//            ->orderBy('cc_tele_encoded_data.checking_name')
            ->get();

        return response()->json([$getData, $getLogCount]);
    }

    public function tele_get_log_checkcing(Request $request)
    {
        $countingsss = '';
        $getData = DB::table('cc_tele_encoded_data')
            ->join('cc_tele_encoded_report_logs', 'cc_tele_encoded_report_logs.report_log_id', '=', 'cc_tele_encoded_data.report_log_id')
            ->where('cc_tele_encoded_data.report_log_id', $request->id)
            ->where('cc_tele_encoded_data.checking_name', $request->type)
            ->select([
                'cc_tele_encoded_data.id as id',
                'cc_tele_encoded_data.report_log_id as report_log_id',
                'cc_tele_encoded_data.label as label',
                'cc_tele_encoded_data.inputted as inputted'
//                'cc_tele_encoded_data.checking_name as checking_name'
            ])
            ->groupBy('cc_tele_encoded_data.id')
            ->get();

        if($request->type == 'Character Reference')
        {
            $countingsss = count($getData) / 6;
        }
        else if($request->type == 'Employment History')
        {
            $countingsss = count($getData) / 11;
        }


        return response()->json([$getData, $countingsss]);
    }

    public function get_cc_tele_report_logs()
    {
        $getLogs = DB::table('cc_tele_encoded_report_logs')
            ->where('user_id', Auth::user()->id)
            ->groupBy('bi_endorse_id')
            ->get();

        return response()->json([$getLogs]);
    }

    public function cc_tele_get_client_type()
    {
        $getClient = DB::table('users')
            ->select('client_check')
            ->where('id', Auth::user()->id)
            ->get()[0]->client_check;

        return response()->json($getClient);
    }

    public function cc_tele_submit_cc_bank_encoding_pdrn(Request $request)
    {

        $save_name = $request->save_file;
        $dancing = $request->dancing;
        $randoms = $request->random;

        $getId = DB::table('cc_bank_tele_save')
            ->insertGetId
            ([
                'user_id' => Auth::user()->id,
                'save_name' => $save_name,
                'save_data' => $dancing,
                'created_at' =>  Carbon::now('Asia/Manila')
            ]);

        if(count($randoms) > 0)
        {
            for($i = 0; $i < count($randoms); $i++)
            {
                DB::table('cc_bank_cobs_id')
                    ->insert
                    ([
                        'save_id'  => $getId,
                        'array_names' => $randoms[$i],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        return response()->json('success');
    }

    public function cc_tele_contact_numbers()
    {
        $getContacts = DB::table('company_contact_numbers')
            ->select([
                'company_contact_numbers.id as id',
                'company_contact_numbers.contact_name as contact_name',
                'company_contact_numbers.contact_add as contact_add',
                'company_contact_numbers.contact_num as contact_num',
                'company_contact_numbers.contact_person as contact_person',
                'company_contact_numbers.created_at as created_at',
                'company_contact_numbers.updated_at as updated_at',
            ])
            ->where('company_contact_numbers.contact_type', 'yellow_page')
            ->orderBy('company_contact_numbers.contact_name');

        return DataTables::of($getContacts)
            ->editcolumn('date_time', function($query)
            {
                if($query->updated_at == '')
                {
                    return $query->created_at;
                }
                else
                {
                    return $query->updated_at;
                }
            })
            ->make(true);
    }

    public function add_contact_number(Request $request)
    {
        DB::table('company_contact_numbers')
            ->insert([
                'contact_name' => $request->inputted_array[0][0],
                'contact_add' => $request->inputted_array[0][1],
                'contact_num' => $request->inputted_array[0][2],
                'contact_person' => $request->inputted_array[0][3],
                'contact_type' => 'yellow_page',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        return 'ok';
    }

    public function delete_comp_contact_details(Request $request)
    {
        DB::table('company_contact_numbers')
            ->where('id', $request->id)
            ->delete();

        return 'ok';
    }

    public function update_comp_contact_details(Request $request)
    {
        DB::table('company_contact_numbers')
            ->where('id', $request->id)
            ->update([
                'contact_name' => $request->update_array[0],
                'contact_add' => $request->update_array[1],
                'contact_num' => $request->update_array[2],
                'contact_person' => $request->update_array[3],
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        return 'ok';
    }

    public function tele_get_contacts()
    {
        $getContacts = DB::table('tele_contacts_grant')
            ->where('user_id', Auth::user()->id)
            ->select('access')
            ->get();

        if(count($getContacts) <= 0)
        {
            return 'No Data';
        }
        else if(count($getContacts) > 0)
        {
            if($getContacts[0]->access == 'Grant')
            {
                return 'grant';
            }
            else
            {
                return 'deny';
            }
        }
    }

    public function cc_tele_cc_bank_encoded_list()
    {
        $getData = DB::table('cc_bank_tele_save')
            ->join('users', 'users.id', '=', 'cc_bank_tele_save.user_id')
            ->select
            ([
                'cc_bank_tele_save.id as id',
                'cc_bank_tele_save.save_name as save_name',
//                'cc_bank_tele_save. as save_name',
                'cc_bank_tele_save.created_at as date'
            ])
            ->where('cc_bank_tele_save.user_id', Auth::user()->id);

        return DataTables::of($getData)
            ->make(true);
    }

    public function cc_tele_get_save_data(Request $request)
    {

        $getData = DB::table('cc_bank_tele_save')
            ->join('users', 'users.id', '=', 'cc_bank_tele_save.user_id')
            ->select
            ([
                'cc_bank_tele_save.save_data as save_data',
            ])
            ->where('cc_bank_tele_save.user_id', Auth::user()->id)
            ->where('cc_bank_tele_save.id', $request->id)
            ->get();

        $getRandoms = DB::table('cc_bank_cobs_id')
            ->select('array_names')
            ->where('save_id', $request->id)
            ->get();

        return response()->json([$getData, $getRandoms]);
    }

    public function cc_tele_get_browser_info()
    {
        $output = '';

        if (Browser::isFirefox()) {
            $output = 'firefox';
        }
        else if(Browser::isChrome())
        {
            $output = 'chrome';
        }

        return $output;
    }

    public function cc_tele_html_to_pdf (Request $request)
    {

        $code_date_time  = explode(' ',Carbon::now('Asia/Manila'));
        $code_date = explode('-',$code_date_time[0]);
        $code_time = explode(':',$code_date_time[1]);

        $datetime = $code_date[0].$code_date[1].$code_date[2].$code_time[0].$code_time[1].$code_time[2];

        $namePrint = $request->name. ' Tele-Report-'. $datetime;
        $nameHeader = $request->name. '-' . $datetime;

        $data = ['content' => $request->file, 'forTitle' => $namePrint, 'forHeader' => $nameHeader];

        $pdf = PDF::loadView('TeleTfsPDFtoPrint', $data)->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])->setPaper('letter', 'portrait');



        $pdf->save(storage_path('tele_pdf_to_print/print_'.Auth::user()->id.'_pdf_'.$datetime.'.pdf'));

        return response()->json('print_'.Auth::user()->id.'_pdf_'.$datetime.'.pdf');
    }

    public function cc_tele_delete_pdf(Request $request)
    {
        unlink(storage_path('/tele_pdf_to_print/'.$request->name));
    }
    
    public function cc_tele_encoder_copy_for_level_2(Request $request)
    {
        $id = base64_decode($request->id);
        $getFileName = DB::table('bi_endorsements')
            ->where('id', '=', $id)
            ->select('tele_report_file_to_sao_path', 'acct_report_status')
            ->get();

        $checkUser = DB::table('cc_tele_levels')
            ->where('user_id', '=', Auth::user()->id)
            ->select('level')
            ->get();

        if(count($checkUser) > 0)
        {
            if($checkUser[0]->level == '2' && $getFileName[0]->acct_report_status == '10')
            {
                $file = $request->file('file');
                $file->move(storage_path('/endorsement_client_report/'.$id), $getFileName[0]->tele_report_file_to_sao_path);
//                Storage::copy(storage_path('/tele_encoder_report/'.$id.'/'.$getFileName[0]->tele_report_file_to_sao_path), storage_path('/endorsement_client_report/'.$id.'/'.$getFileName[0]->tele_report_file_to_sao_path));

                return 'up';
            }
            else
            {
                return 'down';
            }
        }
        else
        {
            return 'down';
        }
    }
}