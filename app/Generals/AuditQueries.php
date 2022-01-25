<?php

namespace App\Generals;


//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuditQueries
{

    public function auditRemove(Request $request)
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

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('ACCOUNT RESET BY ADMINISTRATOR'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function login()
    {
        $ses = Session();

        $userID = Auth::user()->id;
        $userName = Auth::user()->name;

        DB::table('online_user')
            ->insert(['user_id' => $userID, 'user_name' => $userName]);

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
                    'activities' => strtoupper('Logged In'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function endorseAccount($endorseID,$request)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $endorseID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Endorsed Account '. $request->acctFName.' '.$request->acctMName.' '.$request->acctLName.''.$request->busName.''.$request->evrEmpName),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function auditDownload($request)
    {
        $ses = Session();


        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $acctInfo = DB::table('endorsements')
            ->select
            (
                [
                    'account_name'
                ]
            )
            ->where('id',$request->acctID)
            ->first();

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->acctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Downloaded Report of '. $acctInfo->account_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function insertContracts($contID)
    {
        $ses = Session();


        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('contracts')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Insert Contract of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function updateContracts($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('contracts')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID->contracID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID->contracID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Updated Contract of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function downloadContracts($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('contracts')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID->contracID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID->contracID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Downloaded Contract of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function deleteContracts($contID)
    {
        $ses = Session();


        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('contracts')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Deleted Contract of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function insertBirthday($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $clientBday = DB::table('client_birthdays')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insertGetId
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Insert Client Birthdate  of '. $clientBday->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function updateBirthday($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('client_birthdays')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID->clientBdayID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID->clientBdayID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Updated Birthdate info of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function deleteBday($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('client_birthdays')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Deleted Birthdate info of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function insertProsClients ($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $clientBday = DB::table('new_clients')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insertGetId
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Insert '. $clientBday->client_name.' new Prospect Client'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function updateProsClients($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $clientBday = DB::table('new_clients')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insertGetId
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Update '. $clientBday->client_name.' new Prospect Client'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function deleteProsClient($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $clientBday = DB::table('new_clients')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID)
            ->first();

        DB::table('contract_audits')
            ->insertGetId
            (
                [
                    'contract_id' => $contID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Deleted '. $clientBday->client_name.' Prospect Client'),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function downloadBi($contID)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $contName = DB::table('new_clients')
            ->select
            (
                [
                    'client_name'
                ]
            )
            ->where('id',$contID->clientDownloadProsID)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $contID->clientDownloadProsID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Downloaded B.I Report of '. $contName->client_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function DeleteFromCi($request,$filename)
    {
        $ses = Session();


        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $acctInfo = DB::table('endorsements')
            ->select
            (
                [
                    'account_name'
                ]
            )
            ->where('id',$request->AcctID)
            ->first();

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $request->AcctID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('File: '.$filename.' was deleted from '. $acctInfo->account_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function marketingInsertToDoList($request)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        $acctInfo = DB::table('events')
            ->select
            (
                [
                    'title'
                ]
            )
            ->where('id',$request)
            ->first();

        DB::table('contract_audits')
            ->insert
            (
                [
                    'contract_id' => $request,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Inserted event: '. $acctInfo->title),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function Item_log($activity,$item_id,$id_to,$id_from,$remarks)
    {
        $datetme = Carbon::now('Asia/Manila');

        DB::table('item_logs')
            ->insert([
                'user_id' => $id_from,
                'item_id' => $item_id,
                'user_id_to' => $id_to,
                'activities' => $activity,
                'activity_remarks' => $remarks,
                'created_at' => $datetme
            ]);
    }

    public function assign_items($activity,$ar_desc,$user_id,$id_from,$remarks)
    {
        $datetme = Carbon::now('Asia/Manila');

        DB::table('assign_logs')
            ->insert
            ([
                'user_id' => $id_from,
                'ar_desc' => $ar_desc,
                'emp_id' => $user_id,
                'activities' => $activity,
                'remarks' => $remarks,
                'created_at' => $datetme
            ]);
    }

    public function create_profile_log($activity,$user_id,$id_from)
    {
        $datetme = Carbon::now('Asia/Manila');

        DB::table('profile_log')
            ->insert([
                'user_id' => $id_from,
                'emp_id' => $user_id,
                'activities' => $activity,
                'created_at' => $datetme
            ]);
    }

    public function Profile_Logs($activity,$id_to,$id_from){

    }

    public function message_notif_bi($activity, $endo_id, $assigned_by, $account_type)
    {
        $datetime = Carbon::now('Asia/Manila');

        DB::table('message_notif_bi')
            ->insert
            ([
                'message' => $activity,
                'endorse_id' => $endo_id,
                'sao_ao_id' => $assigned_by,
                'account_type' => $account_type,
                'notif' => 1,
                'created_at' => $datetime
            ]);

    }

//    public function marketing_log_insert($rate,$muni,$province)
//    {
//        $timeStamp = Carbon::now('Asia/Manila');
//        $splitDateTime = explode(" ", $timeStamp);
//        $date = $splitDateTime[0];
//        $time = $splitDateTime[1];
//
//        $users = User::find(Auth::user()->id);
//
//        DB::table('audits')
//            ->insert
//            (
//                [
//                    'endorsement_id' => '',
//                    'name' => strtoupper(Auth::user()->name),
//                    'position' => 'MARKETING',
//                    'branch' => '',
//                    'activities' => strtoupper('Logged In'),
//                    'date_occured' => $date,
//                    'time_occured' => $time
//                ]
//            );
//    }


    public function endorseAccountBulk($endorseID,$bulkReq)
    {
        $ses = Session();

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find(Auth::user()->id);
        foreach ($users->roles as $user)
        {
            $role = $user->name;
            $ses->put('role', $role);
        }
        foreach ($users->provinces as $branch)
        {
            $userBranch = $branch->name;
            $ses->put('userBranch', $userBranch);
        }

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $endorseID,
                    'name' => strtoupper(Auth::user()->name),
                    'position' => strtoupper($ses->get('role')),
                    'branch' => strtoupper($ses->get('userBranch')),
                    'activities' => strtoupper('Endorsed Account '. $bulkReq[7].' '.$bulkReq[9]. ' '. $bulkReq[9]),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

    public function auth_api_submit($user_id,$account_id,$account_name)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $users = User::find($user_id);

        DB::table('audits')
            ->insert
            (
                [
                    'endorsement_id' => $account_id,
                    'name' => strtoupper($users->name),
                    'position' => strtoupper($users->roles[0]->name),
                    'branch' => strtoupper($users->provinces[0]->name),
                    'activities' => strtoupper('Endorsed Account '. $account_name),
                    'date_occured' => $date,
                    'time_occured' => $time
                ]
            );
    }

}