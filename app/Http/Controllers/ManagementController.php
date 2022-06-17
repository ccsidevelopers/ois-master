<?php

namespace App\Http\Controllers;

use App\Generals\AuditFundQueries;
use App\Generals\AuditQueries;
use App\Generals\DashboardQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ManagementController extends Controller
{
    public function getManagementDashboard()
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
            } elseif (Auth::user()->hasRole('Management')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];
                //            END

                return view('management.managementmain', compact('endorsement', 'overdueAccount', 'dueAccount', 'timeStamp'))->with(["page" => "managementdashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }


    public function getManagementPanel()
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
            } elseif (Auth::user()->hasRole('Management')) {
                //            GENERAL DASHBOARD HERE
                $generalDashboard = new DashboardQueries();
                $dataDashboard = $generalDashboard->dashboardQueries();
                $endorsement = $dataDashboard[0];
                $dueAccount = $dataDashboard[1];
                $overdueAccount = $dataDashboard[2];
                $timeStamp = $dataDashboard[3];

                $credit_investigators = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 4)
                    ->get();


                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;
                //            END

                return view('management.management-master', compact('endorsement', 'overdueAccount', 'dueAccount', 'timeStamp' ,'credit_investigators','javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getManagementAccountTracker()
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
            } elseif (Auth::user()->hasRole('Management')) {
                return view('management.managementtracker')->with(["page" => "managementtracker"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getManagementAudit()
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
            } elseif (Auth::user()->hasRole('Management')) {
                return view('management.managementaudit')->with(["page" => "managementaudit"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getManagementFundAudit()
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
            } elseif (Auth::user()->hasRole('Management')) {
                return view('management.managementfundaudit')->with(["page" => "managementfundaudit"]);
            }
            return redirect()->route('privilege-error');
        }
    }


    public function getAuditTrailingList()
    {
        $endorsements = DB::table('audits');
        return DataTables::of($endorsements)
            ->make(true);
    }

    public function getFundAuditTrailingList()
    {
        $endorsements = DB::table('audits_fund');
        return DataTables::of($endorsements)
            ->make(true);
    }

    public function getManagementReport()
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
            } elseif (Auth::user()->hasRole('Management')) {
                $credit_investigators = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 4)
                    ->get();

                return view('management.management-report', compact('credit_investigators'))->with(["page" => "managementreport"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getLineChart(Request $request)
    {
        $jan = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','01')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $feb = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','02')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $mar = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','03')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $apr = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','04')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $may = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','05')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $jun = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','06')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $jul = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','07')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $aug = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','08')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $sep = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','09')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $oct = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','10')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $nov = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','11')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $dec = DB::table('endorsements')
            ->whereMonth('date_endorsed','=','12')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $all_late = DB::table('endorsements')
            ->where('endorsement_status_external', 'OVERDUE')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $all_tat = DB::table('endorsements')
            ->where('endorsement_status_external', 'TAT')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();
        $all_proc1 = DB::table('endorsements')
            ->Where('acct_status','1')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();

        $all_proc2 = DB::table('endorsements')
            ->Where('acct_status','2')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();

        $all_proc = DB::table('endorsements')
            ->Where('acct_status','')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();

        $all_hold = DB::table('endorsements')
            ->Where('acct_status','4')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();

        $all_cancel = DB::table('endorsements')
            ->Where('acct_status','5')
            ->whereYear('date_endorsed','=',$request->yr)
            ->count();



        return response()->json([$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec,$all_late,$all_tat,($all_proc+$all_proc2+$all_proc1), $all_cancel, $all_hold]);
    }

    public function managePoll(Request $request)
    {
        $getpoll = DB::table('polls')
            ->get();

        $getquestion = DB::table('options')
            ->get();

        return response()->json([$getpoll,$getquestion]);
    }

    public function managePollToggle(Request $request)
    {

        DB::table('polls')
            ->update([
                'isClosed' => 1
            ]);

        if($request->non === 'true')
        {
            DB::table('polls')
                ->where('id',$request->ida)
                ->update([
                    'isClosed' => 0
                ]);
        }


        $getpoll = DB::table('polls')
            ->get();


        return response()->json($getpoll);
    }

    public function AddPoll(Request $request)
    {
        $getques = $request->question;
        $getnum = $request->maxcheck;

        DB::table('polls')
            ->insert([
                'question' => $getques,
                'maxCheck' => $getnum,
                'isClosed' => 1
            ]);

        return response()->json('success');
    }

    public function AddPollFromQuestion(Request $request)
    {
        $getoptions = $request->options;
        $getid = $request->id;

        DB::table('options')
            ->insert([
                'name' => $getoptions,
                'poll_id' => $getid
            ]);

        return response()->json('success');
    }

    public function DeletePoll(Request $request)
    {
        DB::table('votes')
            ->where('option_id', $request->id)
            ->delete();

        DB::table('options')
            ->where('id', $request->id)
            ->delete();

        return 'success';
    }

    public function GetTableExpenses(Request $request)
    {
        $ci_expenses_table = DB::table('ci_expenses')
            ->join('endorsements','endorsements.id','=','ci_expenses.endorsement_id')
            ->join('users','users.id','=','ci_expenses.ci_id')
//            ->leftjoin('expenses','expenses.ci_expenses_id','=','ci_expenses.id')
            ->select([
                'endorsements.account_name as account_name',
                'endorsements.id as endo_id',
                'endorsements.id as endo_id_main',
                'users.name as ci_name',
                'users.id as ci_id',
//                'expenses.label as label',
//                'expenses.amount as amount',
//                'expenses.attachment as attachment',
//                'expenses.type as type',
                'ci_expenses.shell_include as shell',
                'ci_expenses.date_time_modified as date_time',
                'ci_expenses.note as note',
                'ci_expenses.id as id'
            ]);
//            ->where('ci_expenses.ci_id',Auth::user()->id);

        return DataTables::of($ci_expenses_table)
            ->editColumn('endo_id', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.subject_id')
                    ->select([
                        'asso_expenses.coob_id as endo_id',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->endo_id.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->endo_id.'/';

                }

                return $string_to_add;
            })
            ->editColumn('account_name', function ($query)
            {
                $get_labels = DB::table('asso_expenses')
                    ->leftjoin('endorsements','endorsements.id','=','asso_expenses.coob_id')
                    ->select([
                        'endorsements.account_name as account_name',
                    ])
                    ->where('asso_expenses.subject_id',$query->endo_id)
                    ->get();

                $string_to_add = $query->account_name.'/';

                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $all_label->account_name.'/';

                }

                return $string_to_add;
            })
            ->editColumn('declared', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.label as label',
                        'expenses.amount as amount',
                        'expenses.attachment as attachment',
                        'expenses.type as type',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = '';
                $count = 1;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add .= $count.'. '.$all_label->label.'/'.$all_label->amount.'/'.$all_label->type.'.<br> ';
                    $count++;
                }

                return $string_to_add;
            })
            ->editColumn('amount', function ($query)
            {
                $get_labels = DB::table('expenses')
                    ->leftjoin('ci_expenses','ci_expenses.id','=','expenses.ci_expenses_id')
                    ->select([
                        'expenses.amount as amount',
                    ])
                    ->where('ci_expenses.id',$query->id)
                    ->get();

                $string_to_add = 0;
                foreach ($get_labels as $all_label)
                {
                    $string_to_add = ($string_to_add + $all_label->amount);
                }

                return $string_to_add;
            })
            ->rawColumns(['declared','endo_id,account_name','amount'])
            ->make(true);
    }

    public function management_get_expenses_logs(Request $request)
    {
        $get_logs_expenses = DB::table('ci_logs_expenses')
            ->select([
                'user_id',
                'activity',
                'datetime',
            ])
            ->where('activity_id',$request->endo_id)
            ->get();

//        $getuser = DB::User
        $ciName = User::find($request->ci_id);

        return response()->json([$get_logs_expenses,$ciName->name,$ciName->roles->first()->name]);
    }

    public function ci_fund_table_get()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users','users.id','=','fund_requests.sao_id')
            ->leftjoin('users as user_disp', 'user_disp.id', '=', 'fund_requests.dispatcher_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'users.name as name_sao',
                    'user_disp.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.sao_remarks as remarks',
                    'fund_requests.type_of_fund_request as tor',
                    'count.type as type',
                    DB::raw('count(count.fund_id) as count'),
                    'fund_requests.sao_logs_date_time as sao_date',
                    'fund_requests.dispatcher_request_date as disp_date',
                    'fund_requests.sao_emergency_req_date_time as sao_req',
                    'fund_requests.dispatcher_remarks as disp_rem'
                ]
            )
            ->groupBy('count.fund_id')
//            ->where('fund_requests.sao_id',Auth::user()->id)
            ->where('count.type','Processing','Transferred')
            ->where('fund_requests.sao_approved_date', '0000-00-00 00:00:00')
            ->where('fund_requests.dispatcher_status','ON-PROCESS')
            ->where('fund_requests.sao_status','')


        ;

        return DataTables::of($b)
            ->addColumn('details_url', function($b) {
                return url('sao_pending_fund_details_endorsements/' . $b->id);
            })
            ->make(true);
    }

    public function ci_fund_table_get_approved()
    {
                $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users','users.id','=','fund_requests.sao_id')
            ->leftjoin('users as user_disp', 'user_disp.id', '=', 'fund_requests.dispatcher_id')
//            ->join('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'users.name as sao_name',
                    'user_disp.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.sao_remarks as remarks',
                    'fund_requests.type_of_fund_request as tor',
//                    'count.type as type',
//                    DB::raw('count(count.fund_id) as count'),
                    'fund_requests.sao_logs_date_time as sao_date',
                    'fund_requests.dispatcher_request_date as disp_date',
                    'fund_requests.sao_emergency_req_date_time as sao_req',
                    'fund_requests.dispatcher_remarks as disp_rem'
                ]
            )
//            ->groupBy('count.fund_id')
//            ->where('count.type','Processing','Transferred')
//            ->where('fund_requests.sao_id',Auth::user()->id)
            ->where('fund_requests.sao_status','APPROVED');
            // ->where('approved_request_done', '!=', 'Assigned');

        return DataTables::of($b)
            ->editColumn('count',function ($data)
            {
                $get_count = DB::table('fund_request_endorsements')
                    ->where('fund_id',$data->id)
                    ->count();

                return $get_count;
            })
            ->addColumn('details_url', function($b) {
                return url('sao_app_fund_details_endorsements/' . $b->id);
            })
            ->rawColumns(['count'])
            ->make(true);
    }

    public function ci_fund_table_get_declined()
    {
        $b = DB::table('fund_requests')
            ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
            ->leftjoin('users','users.id','=','fund_requests.sao_id')
            ->leftjoin('users as user_disp', 'user_disp.id', '=', 'fund_requests.dispatcher_id')
            ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
            ->select
            (
                [
                    'fund_requests.id as id',
                    'ci_id.name as name_ci',
                    'users.name as name_sao',
                    'user_disp.name as name_disp',
                    'fund_requests.fund_amount as amount',
                    'fund_requests.sao_remarks as remarks',
                    'fund_requests.type_of_fund_request as tor',
                    'count.type as type',
                    DB::raw('count(count.fund_id) as count'),
                    'fund_requests.sao_logs_date_time as sao_date',
                    'fund_requests.dispatcher_request_date as disp_date',
                    'fund_requests.sao_emergency_req_date_time as sao_req',
                    'fund_requests.dispatcher_remarks as disp_rem'
                ]
            )
            ->groupBy('count.fund_id')
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
                ->where('id',$id)
                ->update([
                    'sao_approved_date' => $timeStamp,
                    'sao_remarks' => strtoupper($remarks),
                    'sao_status' => 'APPROVED'
                ]);

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($dispStatus->ci_id);
            $fund_audit->fund_logs('APPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

            return response()->json('success');
        }
    }

    public function DeclinedReq(Request $request)
    {
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
                     'disapprove_remarks' => $request->rem
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

    public function management_approved_req(Request $request)
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
                ->update
                ([
                    'fund_amount' => base64_encode($request->newAmount),
                    'sao_approved_date' => $timeStamp,
                    'sao_status' => 'APPROVED',
                    'management_approved_date' => $timeStamp,
                    'manage_approved_id' => Auth::user()->id,
                    'management_remarks_approved' => $remarks
                ]);

            $fund_audit = new AuditFundQueries();
            $get_name = User::find($dispStatus->ci_id);
            $fund_audit->fund_logs('APPROVED FUND REQUEST OF: '.$get_name->name.'',$id);

            return response()->json('success');
        }
    }

    public function management_declined_req(Request $request)
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

    public function management_sup_approval()
    {
        $getData = DB::table('admin_accredited_supplier_management_app')
            ->join('users', 'users.id', '=', 'admin_accredited_supplier_management_app.pass_id')
            ->select
            ([
                'admin_accredited_supplier_management_app.id as id',
                'admin_accredited_supplier_management_app.created_at as dt',
                'users.name as pass_name',
                'admin_accredited_supplier_management_app.categ_sup as categ',
                'admin_accredited_supplier_management_app.eq_desc_sup as equi',
                'admin_accredited_supplier_management_app.sup_rem as rem',
            ])
        ->where('admin_accredited_supplier_management_app.req_stat', 'Pending');

        return DataTables::of($getData)
            ->make(true);
    }

    public function management_get_supplier_to_compare(Request $request)
    {
        $arrayToSend1 = [];
        $arrayToSend2 = [];
        $arrayToSend3 = [];
        $count = 0;

        $getSup =DB::table('admin_accredited_suppliers')
            ->where('pivot_request', $request->id)
            ->get();

        $getReq = DB::table('admin_accredited_supplier_management_app')
            ->where('id', $request->id)
            ->get();



        if(count($getSup))
        {
            for($f = 0; $f < count($getSup); $f++)
            {
                array_push($arrayToSend1, $getSup[$f]);

                $arrayToSend2[$count] = [];
                $arrayToSend3[$count] = [];


                $getTerms = DB::table('admin_accredited_suppliers_terms')
                    ->where('supp_id', $getSup[$f]->id)
                    ->get();

                $getFiles = DB::table('admin_accredited_suppliers_files')
                    ->where('supplier_id', $getSup[$f]->id)
                    ->get();

                if(count($getTerms) > 0)
                {
                    for($t = 0; $t < count($getTerms); $t++)
                    {
                        array_push($arrayToSend2[$count], $getTerms[$t]);
                    }
                }
                
                if(count($getFiles))
                {
                    for($e = 0; $e < count($getFiles);$e++ )
                    {
                        array_push($arrayToSend3[$count], $getFiles[$e]);
                    }
                }

                $count++;
            }
        }

        return response()->json([$arrayToSend1, $arrayToSend2, $arrayToSend3, $getReq]);
    }

    public function management_approve_selected_supplier(Request $request)
    {
        $getSups = DB::table('admin_accredited_suppliers')
            ->select('id')
            ->where('pivot_request', $request->idReq)
            ->get();

        $supApp = '';
        $supDec = '';

        if(count($getSups) > 0)
        {
            for($i = 0; $i < count($getSups); $i++)
            {
                if($getSups[$i]->id == $request->idSelected)
                {
                    DB::table('admin_accredited_suppliers')
                        ->where('id', $getSups[$i]->id )
                        ->update
                        ([
                            'approval_status' => 'Management Approved',
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }
                else if($getSups[$i]->id != $request->idSelected)
                {
                    DB::table('admin_accredited_suppliers')
                        ->where('id',$getSups[$i]->id )
                        ->update
                        ([
                            'approval_status' => 'Management Denied',
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }
        }

        DB::table('admin_accredited_supplier_management_app')
            ->where('id', $request->idReq)
            ->update
            ([
                'req_stat'=> 'Reviewed',
                'approver_remarks' => $request->rem,
                'app_id' => Auth::user()->id,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $getSupp = DB::table('admin_accredited_suppliers')
            ->select('supp_name')
            ->where('id', $request->idSelected)
            ->get()[0]->supp_name;

        $logs = new AuditQueries();
        $logs->assign_items('Approved supplier, '.$getSupp.' for accreditation by Management', '','',Auth::user()->id, $request->rem);

        $emailSend = new EmailQueries();
        $emailSend->sendToAdminApproved($getSupp, $request->rem);
    }

    public function management_sup_approval_monit()
    {
        $getData = DB::table('admin_accredited_supplier_management_app')
            ->join('users', 'users.id', '=', 'admin_accredited_supplier_management_app.pass_id')
            ->select
            ([
                'admin_accredited_supplier_management_app.id as id',
                'admin_accredited_supplier_management_app.created_at as dt',
                'users.name as pass_name',
                'admin_accredited_supplier_management_app.categ_sup as categ',
                'admin_accredited_supplier_management_app.eq_desc_sup as equi',
                'admin_accredited_supplier_management_app.sup_rem as rem',
            ])
            ->where('admin_accredited_supplier_management_app.req_stat', 'Reviewed');

        return DataTables::of($getData)
            ->make(true);
    }
    
    public function management_get_general_mon_table_ccbank(Request $request)
    {

        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
            ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
            ->select([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.acct_report_status as status_report',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.date_time_finished as date_time_finished',
                'bi_endorsements.date_time_due as date_time_due',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status',
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check',
                'users.id'
            ])
            ->groupBy('bi_endorsements.id')
            ->where('bi_endorsements_users.position_id',14)
            ->whereDate('bi_endorsements.created_at', '<=', $request->max_date_endorsed)
            ->whereDate('bi_endorsements.created_at', '>=', $request->min_date_endorsed)
            ->where('users.client_check','=', 'cc_bank')
            ->where('bi_endorsements.type_of_endorsement_bank','!=', '')
            ->where('bi_endorsements.status', '!=', 1999);

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

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' .$thisShow ;
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
                                return  '<a class="btn btn-xs btn-success btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$get_general_table->status_report.' </a>';
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
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);

                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>' . $thisShow;

                        return $assigned;
//                        if($difference_days <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                    else if($get_general_table->status == 3)
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
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>' . $thisShow;

                        return $succveri;

//                        if($difference_days <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                }

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
                'assigned_tele'
            ])
            ->make(true);
    }

    public function management_get_general_mon_table_cc(Request $request)
    {
        $get_general_table = DB::table('bi_endorsements')
            ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
//            ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
            ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
            ->select([
                'bi_endorsements.id as endorse_id',
                'bi_endorsements.bi_account_name as site',
                'bi_endorsements.created_at as date_time_endorsed',
                'bi_endorsements.project as project',
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.package as package',
                'bi_endorsements.endorser_poc as poc',
                'bi_endorsements.status as status',
                'bi_endorsements.attach_1 as attach_1',
                'bi_endorsements.attach_2 as attach_2',
                'bi_endorsements.attach_3 as attach_3',
                'bi_endorsements.attach_4 as attach_4',
                'bi_endorsements.acct_report_status as status_report',
                'bi_endorsements.date_time_due as due',
                'bi_endorsements.date_time_finished as date_time_finished',
                'bi_endorsements.date_time_due as date_time_due',
                'bi_endorsements.type_of_endorsement_bank as tor',
                'bi_endorsements.cancel_bool as cancel_status',
                'bi_endorsements.verify_tele_status as tele_stat',
                'bi_endorsements.verify_tele_status_details as contact_details',
                'users.client_check',
                'users.id'
            ])
            ->groupBy('bi_endorsements.id')
            ->where('bi_endorsements_users.position_id',14)
            ->whereDate('bi_endorsements.created_at', '<=', $request->max_date_endorsed)
            ->whereDate('bi_endorsements.created_at', '>=', $request->min_date_endorsed)
            ->where('users.client_check','!=', 'cc_bank')
            ->where(function($query)
            {
                return $query->where('bi_endorsements.type_of_endorsement_bank','=', '')
                    ->orwhere('bi_endorsements.type_of_endorsement_bank','=', null);
            })
            ->where('bi_endorsements.status', '!=', 1999);

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

                        return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>' .$thisShow ;
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
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);

                        $getTeleName = DB::table('bi_endorsements_users')
                            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
                            ->select
                            ([
                                'users.name as user'
                            ])
                            ->where('bi_endorsements_users.position_id', 17)
                            ->where('bi_endorsements_users.bi_endorse_id', $get_general_table->endorse_id)
                            ->get();

                        $assigned = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned to '.$getTeleName[0]->user.'</a>' . $thisShow;

                        return $assigned;
//                        if($difference_days <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days </a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $assigned.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $assigned.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                    else if($get_general_table->status == 3)
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
//                        $difference_hours = $now->diffInHours($date, false);
//                        $difference_mins = $now->diffInMinutes($date, false);
//
//                        $difference_days = $now->diffInDays($date. false);
                        $succveri = '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>' . $thisShow;

                        return $succveri;
//                        if($difference_days <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//                        }
//                        else if($difference_days >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_days.' Days '.$remaininghour.' Hrs & '.$getminute.' Mins</a>' .$thisShow;
//                        }
//                        else if($difference_hours <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_hours >= 1)
//                        {
////                            return $succveri.'<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_hours.' Hours and '.$getminute.' Minutes Left </a>' .$thisShow;
//                        }
//                        else if($difference_mins <= -1)
//                        {
//                            return $succveri.'<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE </a>' .$thisShow;
//
//                        }
//                        else if($difference_mins >= 1)
//                        {
//                            return $succveri.'<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> '.$difference_mins.' Minutes Left </a>' .$thisShow;
//                        }
                    }
                }

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
                'assigned_tele'
            ])
            ->make(true);
    }
}
