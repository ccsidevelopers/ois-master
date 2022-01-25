<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Generals\Trimmer;

class ITDeptController extends Controller
{

    public function itDeptPanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1)
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
            else if (Auth::user()->hasRole('IT Dept'))
            {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;
                return view('it_dept.it-department-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function it_dept_get_access()
    {
        $getAccess = DB::table('users')
            ->select('branch', 'authrequest')
            ->where('id', Auth::user()->id)
            ->get();

        return response()->json($getAccess);
    }

    public function it_dept_send_checklist(Request $request)
    {
        $arrayToInsert = $request->dataSend;

        $getID = DB::table('it_dept_checklist')
            ->insertGetId
            ([
                'location_check' => $request->loc,
                'user_id' => Auth::user()->id,
                'status' => 'Pending',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        if(count($arrayToInsert) > 0)
        {
            for($i = 0; $i < count($arrayToInsert);$i++)
            {
                DB::table('it_dept_checklist_stat_rem')
                    ->insert
                    ([
                        'check_id' => $getID,
                        'status_check' => $arrayToInsert[$i][0],
                        'remarks' => $arrayToInsert[$i][1],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }
    }

    public function it_dept_monit_table(Request $request)
    {
        $getData = [];

        if($request->loc == 'All')
        {
            $getData = DB::table('it_dept_checklist')
                ->join('users', 'users.id', '=', 'it_dept_checklist.user_id')
                ->select
                ([
                    'it_dept_checklist.id as id',
                    'it_dept_checklist.created_at as date_time',
                    'it_dept_checklist.location_check as loc',
                    'users.name as name',
                    'it_dept_checklist.status as stat'
                ]);
        }
        else
        {
            $getData = DB::table('it_dept_checklist')
                ->join('users', 'users.id', '=', 'it_dept_checklist.user_id')
                ->select
                ([
                    'it_dept_checklist.id as id',
                    'it_dept_checklist.created_at as date_time',
                    'it_dept_checklist.location_check as loc',
                    'users.name as name',
                    'it_dept_checklist.status as stat'
                ])
                ->where('it_dept_checklist.location_check', $request->loc);
        }

        return DataTables::of($getData)
            ->make(true);
    }

   public function it_dept_get_checklist_info(Request $request)
    {
        $arr = [];
        $arr_count = 0;

        $getRemStat = DB::table('it_dept_checklist')
            ->select('note_remarks', 'status', 'updated_at', 'user_id')
            ->where('id', $request->id)
            ->get();

        $getAuth = DB::table('users')
            ->select('authrequest')
            ->where('id', $getRemStat[0]->user_id)
            ->get();


        $getData = DB::table('it_dept_checklist_stat_rem')
            ->select(['status_check', 'remarks'])
            ->where('check_id', $request->id)
            ->get();

        foreach ($getData as $data)
        {
            $arr[$arr_count] = [];

            array_push($arr[$arr_count], $data->status_check);
            array_push($arr[$arr_count], $data->remarks);

            $arr_count++;
        }

        return response()->json([$arr, $getRemStat, $getAuth]);
    }

    public function it_dept_insert_remarks_checklist(Request $request)
    {
        DB::table('it_dept_checklist')
            ->where('id', $request->id)
            ->update
            ([
                'status' => 'Reviewed',
                'noted_by' => Auth::user()->id,
                'note_remarks' => $request->rem,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
    }
    
      public function it_dept_archive_yes_table()
    {
        $listusers = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('provinces','provinces.id','=','users.branch')
            ->join('roles','roles.id','=','role_user.role_id')
            ->join('certifieds','certifieds.user_id','=','users.id')
            ->select('users.id as id_of_users','users.Emp_ID as id_emp','users.name as users_name',
                'users.email as users_email','users.pix_path as picture_path','users.archive',
                'role_user.role_id as pos_id','provinces.name as pro_branch','provinces.id as pro_id',
                'roles.name as role_name','roles.id as rol_id','certifieds.cert')
        ->where('role_user.role_id', 4);

        return DataTables::of($listusers)
            ->make(true);
    }

    public function it_dept_change_archived(Request $request)
    {
        $tellme = '';

        if($request->type == 'SetArchived')
        {
            $tellme = 'True';
        }
        else if($request->type == 'RemoveArchived')
        {
            $tellme = 'False';
        }

        DB::table('users')
            ->where('id', $request->id)
            ->update
            ([
                'archive' => $tellme
            ]);
    }
}
