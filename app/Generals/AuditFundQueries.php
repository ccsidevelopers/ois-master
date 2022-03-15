<?php

namespace App\Generals;

//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuditFundQueries{

    public function fund_logs($str,$id)
    {
        $ses = Session();

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

        DB::table('audits_fund')
            ->insert
            (
                [
                    'fund_id' => $id,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper($str),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

}