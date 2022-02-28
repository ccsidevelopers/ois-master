<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 12/21/2017
 * Time: 3:04 PM
 */

namespace App\Generals;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardQueries
{
    public static $endorsements = '';
    public static $dueAccounts = '';
    public static $overdueAccounts = '';
    public static $timeStamp = '';

    public function dashboardQueries()
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        // NEW ENDORSEMENTS
        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('acct_status','')
            ->count();

        // DUE ACCOUNT
        $dueAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('date_due', $date)
            ->count();

        // OVERDUE ACCOUNT
        $overdueAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('endorsement_status_external', 'OVERDUE')
            ->count();

        return [$endorsements, $dueAccounts, $overdueAccounts, $timeStamp];
    }

    public function dashboardQueriesClient()
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        // NEW ENDORSEMENTS
        $endorsements = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('province_id', Auth::user()->provinces->first()->id)
            ->where('user_id', Auth::user()->id)
            ->count();

        // DUE ACCOUNT
        $dueAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('province_id', Auth::user()->provinces->first()->id)
            ->where('user_id', Auth::user()->id)
            ->where('date_due', $date)
            ->count();

        // OVERDUE ACCOUNT
        $overdueAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('province_id', Auth::user()->provinces->first()->id)
            ->where('user_id', Auth::user()->id)
            ->where('endorsement_status_external', 'OVERDUE')
            ->count();

        // TAT ACCOUNT
        $tatAccounts = DB::table('endorsement_user')
            ->join('users', 'users.id', '=', 'endorsement_user.user_id')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->where('position_id', 6)
            ->where('province_id', Auth::user()->provinces->first()->id)
            ->where('user_id', Auth::user()->id)
            ->where('endorsement_status_external', 'TAT')
            ->count();

        return [$endorsements, $dueAccounts, $overdueAccounts, $timeStamp, $tatAccounts];
    }
}