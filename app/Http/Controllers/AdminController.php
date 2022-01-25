<?php

namespace App\Http\Controllers;

use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Province;
use App\Role;
use App\TypeOfRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
use Yajra\DataTables\DataTables;
use ZanySoft\Zip\Zip;

class AdminController extends Controller
{
    public function getAdminDashboard()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            return view('admin.admin-dashboard')->with(["page" => "admindashboard"]);
        }
        return redirect()->route('privilege-error');
    }

    public function getUserManagement()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            $users = User::all()->where('archive','False');
            $roles = Role::all();
            $provinces = Province::all();
            $client_branches = User::all()->where('client_check','client_branch');

            $bi_clients = DB::table('bi_account_list')
                ->get();

            return view('admin.user-management', compact('users','roles','provinces','client_branches','bi_clients'))->with(["page" => "usermanagement"]);
        }
        return redirect()->route('privilege-error');

    }

    public function getUsersListManager()
    {

        $listusers = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('provinces','provinces.id','=','users.branch')
            ->join('roles','roles.id','=','role_user.role_id')
            ->join('certifieds','certifieds.user_id','=','users.id')
            ->select(
                'users.id as id_of_users',
                'users.Emp_ID as id_emp',
                'users.name as users_name',
                'users.email as users_email',
                'users.pix_path as picture_path',
                'users.archive',
                'users.client_type',
                'users.client_check',
                'role_user.role_id as pos_id',
                'provinces.name as pro_branch',
                'provinces.id as pro_id',
                'roles.name as role_name',
                'roles.id as rol_id','certifieds.cert',
                'users.ci_update_date_permission as perm'
            );

        return DataTables::of($listusers)
            ->make(true);
    }

    public function getFormManagement()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            $forms = DB::table('role_user')
                ->join('users','users.id','=','role_user.user_id')
                ->select(['id','name'])
                ->where('role_id',6)
                ->get();


            $tors = TypeOfRequest::all();
            return view('admin.form-management', compact('forms','tors'))->with(["page" => "formmanagement"]);
        }
        return redirect()->route('privilege-error');
    }

    public function getAccountManagement()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            return view('admin.admin-manage-account')->with(["page" => "accountmanagement"]);
        }
        return redirect()->route('privilege-error');
    }
    
    public function getFileManager()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            return view('admin.file-manager')->with(["page" => "filemanager"]);
        }
        return redirect()->route('privilege-error');
    }

    public function getDataManagement()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            return view('admin.data-management')->with(["page" => "datamanagement"]);
        }
        return redirect()->route('privilege-error');
    }

    public function getCiInterface()
    {
        if(Auth::user()==null)
        {
            return redirect()->route('/');
        }
        elseif (Auth::user()->hasRole('Administrator'))
        {
            $users = User::all()->where('archive','False');
            $roles = Role::all();
            $provinces = Province::all();
            $client_branches = User::all()->where('client_check','client_branch');

            $bi_clients = DB::table('bi_account_list')
                ->get();

            return view('admin.admin-ci-contacts', compact('users','roles','provinces','client_branches','bi_clients'))->with(["page" => "ci_contacts"]);
        }
        return redirect()->route('privilege-error');

    }

    public function admin_ci_number_table()
    {
        $ci_numb = DB::table('users')
            ->leftjoin('ci_contacts','ci_contacts.ci_id','=','users.id')
            ->leftjoin('change_password_token','change_password_token.user_id','=','users.id')
            ->join('role_user','role_user.user_id','users.id')
            ->join('roles','roles.id','role_user.role_id')
            ->join('provinces','provinces.id','users.branch')
            ->join('regions','regions.id','provinces.region_id')
            ->join('archipelagos','archipelagos.id','regions.archipelago_id')
            ->select([
                'users.id as id',
                'users.Emp_id as emp_id',
                'users.name as name',
                'users.email as email',
                'ci_contacts.contact_number as num',
                'provinces.name as branch',
                'regions.region_name as region',
                'archipelagos.archipelago_name as archi',
                'change_password_token.pass as change_pass',
                'change_password_token.one_password as one_pass',
                'change_password_token.two_password as two_pass',
                'change_password_token.three_password as three_pass',
                'change_password_token.four_password as four_pass'
            ])
//            ->orderBy('users.id','desc')
            ->where('users.archive','False')
            ->where('roles.id','4');

        return DataTables::of($ci_numb)
            ->make(true);
    }

    public function addUser(Request $request)
    {
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = $request['email'].'.'.$file->getClientOriginalExtension();

            Image::make(file_get_contents($file).($file->getClientOriginalName()))->resize(215, 215)->save(public_path('avatar/'.$name));

            $gg = 0;
            $client_branch = '';
            if($request->position == '6' && $request->client_branch_id != 'userclient')
            {
                $gg = 1;

            }
            if($request->client_branch_id == 'userclient')
            {
                $client_branch = 'client_branch';
            }
            // $file->move('avatar', $name);

            $user = new User;
            $user->name = $request->name;
            $user->Emp_ID = $request->Emp_ID;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->branch = $request->branch;
            $user->pix_path = 'avatar/'.$name;
            $user->archive = 'False';
            $user->client_check = $client_branch;
            if($request->position == '14')
            {
                $user->client_type = 'BI';
            }
            else
            {
                $user->client_type = '';
            }
            $user->save();
            $user->roles()->attach($request->position);
            $user->provinces()->attach($request->branch);




            DB::table('certifieds')
                ->insert([
                    'user_id' => $user->id,
                    'cert' => 'NC'
                ]);

            if($gg === 1)
            {
                DB::table('user_client')
                    ->insert([
                        'user_id' => $user->id,
                        'user_branch' => $request->client_branch_id,
                        'user_level' => $request->client_branch_grant
                    ]);
            }
        }
    }

    public function updateUser(Request $request)
    {
        if($request->hasFile('image'))
        {
            $userID = User::find($request->id);
            $file = $request->file('image');
            $name = $request['email'].'.'.$file->getClientOriginalExtension();
            File::delete(public_path($userID->pix_path));
            Image::make(file_get_contents($file).($file->getClientOriginalName()))->resize(215, 215)->save(public_path('avatar/'.$name));
//            $file->move('avatar', $name);
            $userID->pix_path = 'avatar/'.$name;
            $userID->save();

        }

        $userID = User::find($request->id);

        if(!empty($request->password))
        {
//            $userID->password = bcrypt($request->password);
            $userID->password = bcrypt($request->password);
            $userID->save();

        }

        $userID->name = $request->name;
        $userID->Emp_ID = $request->Emp_ID;
        $userID->email = $request->email;
        $userID->branch = $request->branch;
        if($request->position == '14')
        {
            $userID->client_type = 'BI';
        }
        else
        {
            $userID->client_type = '';
        }
        $userID->save();
        $userID->roles()->detach();
        $userID->roles()->attach($request->position);
        $userID->provinces()->detach();
        $userID->provinces()->attach($request->branch);

    }

    public function getListForm()
    {
        $listFormTemplate = DB::table('templates')->select('*');

        return DataTables::of($listFormTemplate)
            ->make(true);
    }

    public function checkingEmpID(Request $request)
    {
        $getid = $request->checkid;

        $getcount = DB::table('users')
            ->select('Emp_ID')
            ->where('Emp_ID',$getid)
            ->count();
        return response()->json($getcount);
    }

    public function ReadLoan(Request $request){

        $loanshow = DB::table('type_of_loans')
            ->select('type_of_loans')
            ->where('id','!=', 1)
            ->get();

        return response()->json($loanshow);
    }

    public function AddLoan(Request $request){

        DB::table('type_of_loans')
            ->insert(
                [
                    'type_of_loans' => $request->addnewloan
                ]
            );

        return response()->json('done');
    }

    public function DeleteLoan(Request $request){

        DB::table('type_of_loans')
            ->where('type_of_loans', $request->deleteloan)
            ->delete();

        return response()->json('done');
    }

    public function GetTickets()
    {

        $getinfosugges = DB::table('suggestions')
            ->join('users', 'users.id', '=', 'suggestions.user_id')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.name','users.email','users.email','suggestions.title','suggestions.message','suggestions.id','suggestions.created_at','roles.name as position')
            ->orderBy('suggestions.id','desc')
            ->get();

        return response()->json($getinfosugges);

    }

    public function archiveMode(Request $request)
    {
        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'archive' => 'True'
            ]);

    }

    public function archiveModeOff(Request $request)
    {
        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'archive' => 'False'
            ]);
    }

    public function removeAccount(Request $request)
    {
        DB::table('endorsements')
            ->where('endorsements.id',$request->acctID)
            ->update
            ([
                'endorsements.date_due' => '',
                'endorsements.time_due' => '',
                'endorsements.type_of_sending_report' => '',
                'endorsements.endorsement_status_internal' => '',
                'endorsements.endorsement_status_external' => '',
                'endorsements.picture_status' => '',
                'endorsements.handled_by_dispatcher' => '',
                'endorsements.assigned_by_srao' => '',
                'endorsements.handled_by_account_officer' => '',
                'endorsements.handled_by_credit_investigator' => '',
                'endorsements.acct_status' => '',
                'endorsements.remarks' => '',
                'endorsements.add_verification' => '',
                'endorsements.bill' => '',

//                CLEARED INFORMATION TIMESTAMPSl

                'endorsements.date_dispatched' => '',
                'endorsements.time_dispatched' => '',
                'endorsements.date_srao_assigned' => '',
                'endorsements.time_srao_assigned' => '',
                'endorsements.date_ci_visit' => '',
                'endorsements.time_ci_visit' => '',
                'endorsements.date_ci_forwarded' => '',
                'endorsements.time_ci_forwarded' => '',
                'endorsements.date_ao_download' => '',
                'endorsements.time_ao_download' => '',
                'endorsements.date_forwarded_to_client' => '',
                'endorsements.time_forwarded_to_client' => '',
                'endorsements.ci_cert' => ''
            ]);

        DB::table('timestamps')
            ->where('endorsement_id',$request->acctID)
            ->update
            ([
                'time_dispatcher' => '',
                'time_srao' => '',
                'time_ci' => '',
                'time_ao' => ''
            ]);

        DB::table('endorsement_user')
            ->orwhere('position_id',2)
            ->where('endorsement_id', $request->acctID)
            ->delete();

        DB::table('endorsement_user')
            ->orWhere('position_id',3)
            ->where('endorsement_id', $request->acctID)
            ->delete();

        DB::table('endorsement_user')
            ->orWhere('position_id',4)
            ->where('endorsement_id', $request->acctID)
            ->delete();

        DB::table('endorsement_user')
            ->orWhere('position_id',7)
            ->where('endorsement_id', $request->acctID)
            ->delete();

//        DB::table('audits')
//            ->where('endorsement_id',$request->acctID)
//            ->where('position','DISPATCHER')
//            ->delete();
//
//        DB::table('audits')
//            ->where('endorsement_id',$request->acctID)
//            ->where('position','SENIOR ACCOUNT OFFICER')
//            ->delete();
//
//        DB::table('audits')
//            ->where('endorsement_id',$request->acctID)
//            ->where('position','CREDIT INVESTIGATOR')
//            ->delete();
//
//        DB::table('audits')
//            ->where('endorsement_id',$request->acctID)
//            ->where('position','ACCOUNT OFFICER')
//            ->delete();

        $auditRemove = new AuditQueries();
        $auditRemove->auditRemove($request);

    }

    public function fetchDetachAccount(Request $request)
    {
        $endorsementsw = DB::table('endorsements');

        return DataTables::of($endorsementsw)
            ->make(true);
    }

    public function getDataTrail()
    {

        $get = DB::table('audits')
            ->get();


        return response()->json($get);

    }

    public function getCiContact(Request $request)
    {

        $getCiCont = DB::table('ci_contacts')
            ->where('ci_id', $request->id)
            ->get();


        return response()->json($getCiCont);

    }

    public function updateCiContact(Request $request)
    {

        $count = count($request->number);
        $getnumberarray = $request->number;
        $contact_id_count = $request->contact_id;
        for($ctr = 0; $ctr<$count; $ctr++){

            $checkforupdate = DB::table('ci_contacts')
                ->where('id', $contact_id_count[$ctr])
                ->count();

            if($checkforupdate >= 1)
            {
                //update
                DB::table('ci_contacts')
                    ->where('id', $contact_id_count[$ctr])
                    ->update([
                        'contact_number' => $getnumberarray[$ctr]
                    ]);
            }
            else {
                //add
                DB::table('ci_contacts')
                    ->insert([
                        'ci_id' => $request->id,
                        'contact_number' => $getnumberarray[$ctr]
                    ]);

            }
        }

        return $request->contact_id;
    }

    public function deleteCiContact(Request $request)
    {

        $cont_id = $request->id;

        DB::table('ci_contacts')
            ->where('id', $cont_id)
            ->delete();


        return 'success';
    }

    public function deleteAllEndorsements(Request $request)
    {
//        DB::table('businesses')
//            ->truncate();
//
//        DB::table('audits')
//            ->truncate();
//
//        DB::table('coborrowers')
//            ->truncate();
//
//        DB::table('employers')
//            ->truncate();
//
//        DB::table('endorsements')
//            ->truncate();
//
//        DB::table('endorsement_user')
//            ->truncate();
//
//        DB::table('timestamps')
//            ->truncate();
//
//        DB::table('notes')
//            ->truncate();
//
//        DB::table('reports')
//            ->truncate();
//
//        DB::table('subjects')
//            ->truncate();
//
//        DB::table('type_of_subjects')
//            ->truncate();

        return 'success';
    }

    public function enableCert(Request $request)
    {

        DB::table('certifieds')
            ->where('user_id',$request->userID)
            ->update
            (
                [
                    'cert'=>'C'
                ]
            );

        return \response()->json('success');
    }

    public function disableCert(Request $request)
    {
        DB::table('certifieds')
            ->where('user_id',$request->userID)
            ->update
            (
                [
                    'cert'=>'NC'
                ]
            );

        return \response()->json('success');
    }

    public function backUpFile()
    {
        $dateOnly = Carbon::now();
        $dateO = $dateOnly->toDateString();

        Zip::create(storage_path('account_backup/backup-'.str_replace(array(':','-',' '), '',$dateO).'.zip'), true)
            ->add(storage_path('account_report/'), true)
            ->setPath(storage_path('account_backup'))
            ->close();


        return \response()->json('backup-'.str_replace(array(':','-',' '), '',$dateO).'.zip');
    }

    public function uploadForm(Request $request)
    {
        if(Input::hasFile('file'))
        {
            $file = $request->file('file');

            //you also need to keep file extension as well
            $name =  $file->getClientOriginalName();

            //using array instead of object
            $file->move(storage_path('/DownloadableForms/'), $name);


            return response()->json('success');
        }
    }

    public function GetEmailSelection()
    {

        $users = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('provinces', 'provinces.id', '=', 'users.branch')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id as ids', 'users.email as useremail', 'roles.name as rolename', 'users.name as username')
            ->where('role_user.role_id', '!=', '6')
            ->get();

        return \response()->json($users);

    }

    public function ApplyEmails(Request $request)
    {
        $getemails1 = $request->listemails1;
        $getemails2 = $request->listemails2;
        $getemails3 = $request->listemails3;
        $getemails4 = $request->listemails4;
        $getemails5 = $request->listemails5;


        if(sizeof($getemails1) !== 0)
        {
            foreach ($getemails1 as $getemail1) {

                $check = DB::table('emails_to_send')
                    ->where('user_id', $getemail1)
                    ->where('email_for', 'ClientNotif')
                    ->count();

                if ($check >= 1) {
                    //do nothing
                } else {

                    DB::table('emails_to_send')
                        ->insert([
                            'user_id' => $getemail1,
                            'email_for' => 'ClientNotif'
                        ]);
                }
            }
        }

        if(sizeof($getemails2) !== 0)
        {
            foreach ($getemails2 as $getemail2) {

                $check = DB::table('emails_to_send')
                    ->where('user_id', $getemail2)
                    ->where('email_for', 'SraoAo')
                    ->count();

                if ($check >= 1) {
                    //do nothing
                } else {

                    DB::table('emails_to_send')
                        ->insert([
                            'user_id' => $getemail2,
                            'email_for' => 'SraoAo'
                        ]);
                }
            }
        }

        if(sizeof($getemails3) !== 0)
        {
            foreach ($getemails3 as $getemail3) {

                $check = DB::table('emails_to_send')
                    ->where('user_id', $getemail3)
                    ->where('email_for', 'DispatcherCI')
                    ->count();

                if ($check >= 1) {
                    //do nothing
                } else {

                    DB::table('emails_to_send')
                        ->insert([
                            'user_id' => $getemail3,
                            'email_for' => 'DispatcherCI'
                        ]);
                }
            }
        }

        if(sizeof($getemails4) !== 0)
        {
            foreach ($getemails4 as $getemail4) {

                $check = DB::table('emails_to_send')
                    ->where('user_id', $getemail4)
                    ->where('email_for', 'FinishAcc')
                    ->count();

                if ($check >= 1) {
                    //do nothing
                } else {

                    DB::table('emails_to_send')
                        ->insert([
                            'user_id' => $getemail4,
                            'email_for' => 'FinishAcc'
                        ]);
                }
            }
        }

        if(sizeof($getemails5) !== 0)
        {

            foreach ($getemails5 as $getemail5) {

                $check = DB::table('emails_to_send')
                    ->where('user_id', $getemail5)
                    ->where('email_for', 'Marketing')
                    ->count();

                if ($check >= 1) {
                    //do nothing
                } else {

                    DB::table('emails_to_send')
                        ->insert([
                            'user_id' => $getemail5,
                            'email_for' => 'Marketing'
                        ]);
                }
            }
        }
    }

    public function admin_get_client_notif_emails_for_dispatcher(Request $request)
    {


        $getalldispatcher = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','2')
            ->get();


        foreach ($getalldispatcher as $dispatcheremail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $dispatcheremail->id)
                ->where('email_for', 'ClientNotif')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $dispatcheremail->id,
                        'email_for' => 'ClientNotif'
                    ]);

            }
        }
    }

    public function admin_get_client_notif_emails_for_sao(Request $request)
    {

        $getallsao = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','7')
            ->get();

        foreach ($getallsao as $saoemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saoemail->id)
                ->where('email_for', 'ClientNotif')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $saoemail->id,
                        'email_for' => 'ClientNotif'
                    ]);

            }
        }
    }


    public function admin_remove_client_notif_emails_for_dispatcher(Request $request)
    {
        $getalldispatcher = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email', 'users.id as id')
            ->where('role_user.role_id', '2')
            ->get();


        foreach ($getalldispatcher as $dispatcheremail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $dispatcheremail->id)
                ->where('email_for', 'ClientNotif')
                ->count();

            if ($check >= 1) {

                DB::table('emails_to_send')
                    ->where('user_id', $dispatcheremail->id)
                    ->where('email_for', 'ClientNotif')
                    ->delete();
            } else {
                //do nothing
            }
        }
    }

    public function admin_remove_client_notif_emails_for_sao(Request $request)
    {
        $getallsao = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email', 'users.id as id')
            ->where('role_user.role_id', '7')
            ->get();


        foreach ($getallsao as $saoemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saoemail->id)
                ->where('email_for', 'ClientNotif')
                ->count();

            if ($check >= 1) {

                DB::table('emails_to_send')
                    ->where('user_id', $saoemail->id)
                    ->where('email_for', 'ClientNotif')
                    ->delete();
            } else {
                //do nothing
            }
        }
    }

    public function admin_remove_client_notif_emails_for_sao_and_disp(Request $request)
    {
        $getallsaodisp = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email', 'users.id as id')
            ->where(function ($query) {
                $query->where('role_user.role_id', '=', '7')
                    ->orWhere('role_user.role_id', '=', '2');
            })
            ->get();


        foreach ($getallsaodisp as $saodispemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saodispemail->id)
                ->where('email_for', 'ClientNotif')
                ->count();

            if ($check >= 1) {

                DB::table('emails_to_send')
                    ->where('user_id', $saodispemail->id)
                    ->where('email_for', 'ClientNotif')
                    ->delete();
            } else {
                //do nothing
            }
        }
    }

    public function admin_get_assign_transfer_for_sao(Request $request)
    {
        $getallsao = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','7')
            ->get();

        foreach ($getallsao as $saoemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saoemail->id)
                ->where('email_for', 'SraoAo')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $saoemail->id,
                        'email_for' => 'SraoAo'
                    ]);

            }
        }
    }

    public function admin_get_assign_transfer_for_ao(Request $request)
    {
        $getallao = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','3')
            ->get();

        foreach ($getallao as $aoemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $aoemail->id)
                ->where('email_for', 'SraoAo')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $aoemail->id,
                        'email_for' => 'SraoAo'
                    ]);

            }
        }
    }

    public function admin_remove_assign_transfer_all(Request $request)
    {
        $getallsaoao = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email', 'users.id as id')
            ->where(function ($query) {
                $query->where('role_user.role_id', '=', '7')
                    ->orWhere('role_user.role_id', '=', '3');
            })
            ->get();


        foreach ($getallsaoao as $saoaopemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saoaopemail->id)
                ->where('email_for', 'SraoAo')
                ->count();

            if ($check >= 1) {

                DB::table('emails_to_send')
                    ->where('user_id', $saoaopemail->id)
                    ->where('email_for', 'SraoAo')
                    ->delete();
            } else {
                //do nothing
            }
        }
    }

    public function admin_get_dispatch_transfer_for_dispatcher(Request $request)
    {
        $getalldisp = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','2')
            ->get();

        foreach ($getalldisp as $dispemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $dispemail->id)
                ->where('email_for', 'DispatcherCI')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $dispemail->id,
                        'email_for' => 'DispatcherCI'
                    ]);

            }
        }
    }

    public function admin_get_dispatch_transfer_for_ci(Request $request)
    {
        $getallci = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.email as email','users.id as id')
            ->where('role_user.role_id','4')
            ->get();

        foreach ($getallci as $ciemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $ciemail->id)
                ->where('email_for', 'DispatcherCI')
                ->count();

            if ($check >= 1) {
                //do nothing
            } else {

                DB::table('emails_to_send')
                    ->insert([
                        'user_id' => $ciemail->id,
                        'email_for' => 'DispatcherCI'
                    ]);

            }
        }
    }

    public function admin_remove_dispatcher_transfer_all(Request $request)
    {
        $getallsaoao = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email', 'users.id as id')
            ->where(function ($query) {
                $query->where('role_user.role_id', '=', '2')
                    ->orWhere('role_user.role_id', '=', '4');
            })
            ->get();


        foreach ($getallsaoao as $saoaopemail) {

            $check = DB::table('emails_to_send')
                ->where('user_id', $saoaopemail->id)
                ->where('email_for', 'DispatcherCI')
                ->count();

            if ($check >= 1) {

                DB::table('emails_to_send')
                    ->where('user_id', $saoaopemail->id)
                    ->where('email_for', 'DispatcherCI')
                    ->delete();
            } else {
                //do nothing
            }
        }
    }

    public function EmailGetter(Request $request)
    {

        $getemail = '';

        if($request->seeemail === '1')
        {
            $getemail = DB::table('emails_to_send')
                ->join('users', 'users.id', '=', 'emails_to_send.user_id')
                ->where('emails_to_send.email_for','ClientNotif')
                ->select('users.email as email','emails_to_send.user_id as id')
                ->get();
        }
        else if($request->seeemail === '2')
        {
            $getemail = DB::table('emails_to_send')
                ->join('users', 'users.id', '=', 'emails_to_send.user_id')
                ->where('emails_to_send.email_for','SraoAo')
                ->select('users.email as email','emails_to_send.user_id as id')
                ->get();
        }
        else if($request->seeemail === '3')
        {
            $getemail = DB::table('emails_to_send')
                ->join('users', 'users.id', '=', 'emails_to_send.user_id')
                ->where('emails_to_send.email_for','DispatcherCI')
                ->select('users.email as email','emails_to_send.user_id as id')
                ->get();
        }
        else if($request->seeemail === '4')
        {
            $getemail = DB::table('emails_to_send')
                ->join('users', 'users.id', '=', 'emails_to_send.user_id')
                ->where('emails_to_send.email_for','FinishAcc')
                ->select('users.email as email','emails_to_send.user_id as id')
                ->get();
        }
        else if($request->seeemail === '5')
        {
            $getemail = DB::table('emails_to_send')
                ->join('users', 'users.id', '=', 'emails_to_send.user_id')
                ->where('emails_to_send.email_for','Marketing')
                ->select('users.email as email','emails_to_send.user_id as id')
                ->get();
        }
        return \response()->json($getemail);

    }

    public function EmailRemoveSelect(Request $request){

        return  DB::table('emails_to_send')
            ->where('user_id', $request->id)
            ->where('email_for', $request->for)
            ->delete();
    }

    public function getWebStatus()
    {
        $webstat = DB::table('downs')
            ->select('web_status')
            ->first();

        return response()->json($webstat->web_status);
    }

    public function downWebApp(Request $request)
    {
        if($request->tag=='disable')
        {
            DB::table('downs')
                ->update
                (
                    [
                        'web_status'=>0
                    ]
                );
        }
        else
        {
            DB::table('downs')
                ->update
                (
                    [
                        'web_status'=>1
                    ]
                );
        }
    }

    public function getTableArchive()
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
            ->where('archive','True');

        return DataTables::of($listusers)
            ->make(true);
    }

    public function getTableBlocked()
    {
        $listBlocked = DB::table('attempt');
        return DataTables::of($listBlocked)
            ->make(true);
    }

    public function unblockedAccounts(Request $request)
    {
        DB::table('attempt')
            ->where('id',$request->blckID)
            ->delete();
    }

    public function admin_register_bi_account(Request $request)
    {
        $dual_array = $request->packages_checkings;
        $dual_array_info = $request->packages_checkings_info;
        $dual_array_ocular = $request->packages_checkings_ocular;

        $other_checking = $request->other_checking;
        $other_checking_info = $request->other_checking_info;
        $other_checking_ocular = $request->other_checking_ocular;

        $account_name = $request->account_name;
        $account_location = $request->account_location;
        $what_to_do = $request->what_to_do;

        $date_time = Carbon::now('Asia/Manila');


        if($what_to_do == 'add')
        {
            //ADD
            $get_same = DB::table('bi_account_list')
                ->select('bi_account_name','account_location')
                ->where('bi_account_name',$account_name)
                ->where('account_location',$account_location)
                ->count();

            if($get_same > 0)
            {
                return 'same';
            }
            else
            {

                if(is_array($other_checking))
                {
                    $bi_account_id = DB::table('bi_account_list')
                        ->insertGetId([
                            'bi_account_name' => $account_name,
                            'account_location' => $account_location,
                            'created_at' => $date_time
                        ]);
                    //loop for other checking
                    for($p = 0; $p<count($other_checking); $p++)
                    {

                        //other checking
                        DB::table('other_checking_list')
                            ->insert([
                                'bi_account_id' => $bi_account_id,
                                'checking_name' => $other_checking[$p],
                                'ocular' => $other_checking_ocular[$p],
                                'information' => $other_checking_info[$p]
                            ]);
                    }
                }
                else
                {
                    $bi_account_id = DB::table('bi_account_list')
                        ->insertGetId([
                            'bi_account_name' => $account_name,
                            'account_location' => $account_location,
                            'created_at' => $date_time
                        ]);
                }
                if(is_array($dual_array))
                {
                    //loop for packages and checking
                    for($ctr = 0; $ctr<count($dual_array); $ctr++)
                    {
                        $package_name = '';
                        $checking_name = '';
                        $get_pivot_id_package_bi = '';
                        for($i = 0; $i<count($dual_array[$ctr]); $i++)
                        {
                            if($i == 0)
                            {
                                //saving package
                                $package_name = $dual_array[$ctr][$i];

                                $package_id = DB::table('package_list')
                                    ->insertGetId([
                                        'package' => $package_name
                                    ]);

                                $get_pivot_id_package_bi = DB::table('package_to_account')
                                    ->insertGetId([
                                        'bi_account_id' => $bi_account_id,
                                        'package_id' => $package_id
                                    ]);
                            }
                            else
                            {

                                //saving checking
//                                $checking_name = $dual_array[$ctr][$i];

                                $checking_id = DB::table('checking_list')
                                    ->insertGetId([
                                        'checking_name' => $dual_array[$ctr][$i],
                                        'information' => $dual_array_info[$ctr][$i],
                                        'ocular' => $dual_array_ocular[$ctr][$i]
                                    ]);

                                $get_pivot_id_checking = DB::table('checking_to_package')
                                    ->insertGetId([
                                        'package_to_account_id' => $get_pivot_id_package_bi,
                                        'checking_id' => $checking_id
                                    ]);
                            }
                        }
                    }
                }


                return 'a';
            }
        }
        else if($what_to_do == 'edit')
        {
            //EDIT
            $global_bi_id = $request->global_bi_id;

            DB::table('checking_list')
                ->join('checking_to_package','checking_to_package.checking_id','=','checking_list.id')
                ->join('package_to_account','package_to_account.id','=','checking_to_package.package_to_account_id')
                ->where('package_to_account.bi_account_id',$global_bi_id)
                ->delete();

            DB::table('checking_to_package')
                ->join('package_to_account','package_to_account.id','=','checking_to_package.package_to_account_id')
                ->where('package_to_account.bi_account_id',$global_bi_id)
                ->delete();

            DB::table('package_list')
                ->join('package_to_account','package_to_account.package_id','=','package_list.id')
                ->where('package_to_account.bi_account_id',$global_bi_id)
                ->delete();

            DB::table('package_to_account')
                ->where('package_to_account.bi_account_id',$global_bi_id)
                ->delete();

            DB::table('other_checking_list')
                ->leftjoin('bi_account_list','bi_account_list.id','=','other_checking_list.bi_account_id')
                ->where('bi_account_list.id',$global_bi_id)
                ->delete();


            if(is_array($other_checking))
            {
                //loop for other checking
                for($p = 0; $p<count($other_checking); $p++)
                {

                    //other checking
                    DB::table('other_checking_list')
                        ->insert([
                            'bi_account_id' => $global_bi_id,
                            'checking_name' => $other_checking[$p],
                            'ocular' => $other_checking_ocular[$p],
                            'information' => $other_checking_info[$p]
                        ]);
                }
            }

            if(is_array($dual_array))
            {
                //loop for packages and checking
                for($ctr = 0; $ctr<count($dual_array); $ctr++)
                {
                    $package_name = '';
                    $checking_name = '';
                    $get_pivot_id_package_bi = '';
                    for($i = 0; $i<count($dual_array[$ctr]); $i++)
                    {
                        if($i == 0)
                        {
                            //saving package
                            $package_name = $dual_array[$ctr][$i];

                            $package_id = DB::table('package_list')
                                ->insertGetId([
                                    'package' => $package_name
                                ]);

                            $get_pivot_id_package_bi = DB::table('package_to_account')
                                ->insertGetId([
                                    'bi_account_id' => $global_bi_id,
                                    'package_id' => $package_id
                                ]);
                        }
                        else
                        {

                            //saving checking
//                            $checking_name = $dual_array[$ctr][$i];

                            $checking_id = DB::table('checking_list')
                                ->insertGetId([
                                    'checking_name' => $dual_array[$ctr][$i],
                                    'information' => $dual_array_info[$ctr][$i],
                                    'ocular' => $dual_array_ocular[$ctr][$i]
                                ]);

                            $get_pivot_id_checking = DB::table('checking_to_package')
                                ->insertGetId([
                                    'package_to_account_id' => $get_pivot_id_package_bi,
                                    'checking_id' => $checking_id
                                ]);
                        }
                    }
                }
            }


            return 'b';
        }
        else
        {
            return 'c';
        }
    }

    public function admin_select_bi_to_user(Request $request)
    {
        $user_id = $request->user_id;
        $bi_id = $request->bi_id;
        $date_time = Carbon::now('Asia/Manila');

        $check = DB::table('bi_account_to_users')
            ->where('users_id',$user_id)
            ->get();

        if(count($check) == 0)
        {
            DB::table('bi_account_to_users')
                ->insert([
                    'users_id' => $user_id,
                    'bi_account_id' => $bi_id,
                    'created_at' => $date_time
                ]);
        }
        else
        {
            DB::table('bi_account_to_users')
                ->where('id',$check[0]->id)
                ->update([
                    'bi_account_id' => $bi_id,
                    'updated_at' => $date_time
                ]);
        }

    }

    public function admin_edit_get_select_bi_account()
    {

        $get_shit = DB::table('bi_account_list')
            ->get();

        if(count($get_shit) == 0)
        {
            $get_shit = 'none';
        }

        return response()->json($get_shit);
    }

    public function admin_select_bi_change(Request $request)
    {

        $bi_id = $request->bi_id;

        $get_shit_package = DB::table('package_list')
            ->leftjoin('package_to_account','package_to_account.package_id','=','package_list.id')
            ->select([
                'package_list.package as package',
                'package_list.id as id'
            ])
            ->where('package_to_account.bi_account_id',$bi_id)
            ->get();

        $get_shit_checking = DB::table('bi_account_list')
            ->leftjoin('package_to_account','package_to_account.bi_account_id','=','bi_account_list.id')
            ->leftjoin('package_list','package_list.id','=','package_to_account.package_id')
            ->leftjoin('checking_to_package','checking_to_package.package_to_account_id','=','package_to_account.id')
            ->leftjoin('checking_list','checking_list.id','=','checking_to_package.checking_id')
            ->select([
                'package_list.id as package_id',
                'checking_list.checking_name as checking',
                'checking_list.id as checking_id',
                'checking_list.information as information',
                'checking_list.ocular as ocular',
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as location'
            ])
            ->where('package_to_account.bi_account_id',$bi_id)
            ->get();

        $get_other_checking = DB::table('other_checking_list')
            ->leftjoin('bi_account_list','bi_account_list.id','=','other_checking_list.bi_account_id')
            ->select([
                'other_checking_list.checking_name as other_check',
                'other_checking_list.information as information',
                'other_checking_list.ocular as ocular'
            ])
            ->where('bi_account_list.id',$bi_id)
            ->get();

        if(count($get_shit_package) == 0)
        {
            $get_shit_package = 'none';
        }

        if(count($get_other_checking) == 0)
        {
            $get_other_checking = 'none';
        }

        return response()->json([$get_shit_package,$get_shit_checking,$get_other_checking]);
    }

    public function admin_check_bday_notification_email()
    {

        $get_bday = DB::table('client_birthdays')
            ->get();

        if(count($get_bday) != 0)
        {
            return $get_bday;
        }
        else
        {
            return 'no records';
        }

    }

    public function admin_bday_send_email_notif(Request $request)
    {

        $email = new EmailQueries();

        $email->Marketing_Send_Email_Birthday($request);

        return 'success';

    }

    public function admin_check_contract_notification_email()
    {

        $get_contract = DB::table('contracts')
            ->get();

        if(count($get_contract) != 0)
        {
            return $get_contract;
        }
        else
        {
            return 'no records';
        }
    }

    public function admin_contract_send_email_notif(Request $request)
    {
        $email = new EmailQueries();

        $email->Marketing_Send_Email_Contract($request);

        return 'success';
    }

    public function admin_bday_and_contract_validate(Request $request)
    {
        $raw1 = 'true';
        $raw2 = 'true';

        $data1 = DB::table('contracts')
            ->select('date_updated')
            ->where('date_updated', $request->date_updated)
            ->get();

        $data2 = DB::table('client_birthdays')
            ->select('date_updated')
            ->where('date_updated', $request->date_updated)
            ->get();

        if(count($data1) > 0) {
            $raw1 = 'false';
        }
        if(count($data2) > 0){
            $raw2 = 'false';
        }


//        $email = new EmailQueries();
//        $now = Carbon::now('Asia/Manila');
//        $now2 = explode(' ', $now);
//        $currentDate = explode('-', $now2[0]);
//        $comparing = (int)$currentDate[2] + 3; // magiging 16
//        $reminder_name= [];
//        $reminder_remaining = [];
//        $reminder_counter = 0;
//        $remaining = 0;
//
//        $getReminders = DB::table('reminder_list')
//            ->select('day_of_reminder', 'reminder_name')
//            ->get();
//
//        if(count($getReminders) > 0)
//        {
//            for($i = 0; $i < count($getReminders); $i++)
//            {
//                if($getReminders[$i]->day_of_reminder != $currentDate[2] && $getReminders[$i]->day_of_reminder > $currentDate[2])
//                {
//                    if($getReminders[$i]->day_of_reminder < $comparing)
//                    {
//                        array_push($reminder_name, $getReminders[$i]->reminder_name);
//                        array_push($reminder_remaining, (int)$getReminders[$i]->day_of_reminder - (int)$currentDate[2]);
//                    }
//                }
//            }
//        }
//        if(count($reminder_name) > 0)
//        {
//            $email->reminders_email($reminder_name, $reminder_remaining );
//        }

//        return response()->json([$reminder_name, $reminder_remaining]);

        return response()->json([$raw1, $raw2]);
    }

    public function admin_get_all_bi_client(Request $request)
    {
        $data = DB::table('bi_account_list')
            ->get();

        return response()->json($data);
    }

    public function admin_get_check_bi(Request $request)
    {
        $checks = $request->myData;

        if($request->myData !== null)
        {
            foreach ($checks as $key)
            {
                DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
        }
    }

    public function admin_get_checkings_data()
    {
        $data = DB::table('bi_return_checkings')
            ->get();

        return response()->json($data);
    }

    public function admin_add_upon_checkings(Request $request)
    {
        $checks = $request->my_array;

        if($request->my_array !== null)
        {
            foreach($checks as $key)
            {
                $data = DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 20,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }

    public function admin_add_during_checkings(Request $request)
    {
        $checks = $request->my_array;

        if($request->my_array !== null)
        {
            foreach($checks as $key)
            {
                $data = DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 22,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }

    public function admin_add_after_checkings(Request $request)
    {
        $checks = $request->my_array;

        if($request->my_array !== null)
        {
            foreach($checks as $key)
            {
                $data = DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 23,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }

    public function admin_get_all_upon_checks()
    {
        $data = DB::table('bi_return_checkings')
            ->where('id_checking_group', 20)
            ->get();

        return $data;
    }

    public function admin_get_all_during_checks()
    {
        $data = DB::table('bi_return_checkings')
            ->where('id_checking_group', 22)
            ->get();

        return $data;
    }

    public function admin_get_all_after_checks()
    {
        $data = DB::table('bi_return_checkings')
            ->where('id_checking_group', 23)
            ->get();

        return $data;
    }

    public function admin_edit_upon_checkings(Request $request)
    {
        DB::table('bi_return_checkings')
            ->where('id_checking_group', 20)
            ->delete();

        $checks = $request->edit_array;

        if($request->edit_array !== null)
        {
            foreach($checks as $key)
            {
                DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 20,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }


    public function admin_edit_during_checkings(Request $request)
    {
        DB::table('bi_return_checkings')
            ->where('id_checking_group', 22)
            ->delete();

        $checks = $request->edit_array;

        if($request->edit_array !== null)
        {
            foreach($checks as $key)
            {
                DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 22,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }


    public function admin_edit_after_checkings(Request $request)
    {
        DB::table('bi_return_checkings')
            ->where('id_checking_group', 23)
            ->delete();

        $checks = $request->edit_array;

        if($request->edit_array !== null)
        {
            foreach($checks as $key)
            {
                DB::table('bi_return_checkings')
                    ->insert(
                        [
                            'id_checking_group' => 23,
                            'check_name' => $key,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]
                    );
            }
            return 'ok';
        }
        else
        {
            return 'error!';
        }
    }

    public function get_ip_address_data_table()
    {
        $get_ip = DB::table('ip_login_access')
            ->select('id','ip','office_branch','accessibility');

        return DataTables::of($get_ip)
            ->make(true);
    }

    public function get_user_access_login_data_table()
    {

        $user_login_access = DB::table('roles')
            ->select('id','name','login_access');

        return DataTables::of($user_login_access)
            ->make(true);
    }

    public function ip_address_access(Request $request)
    {

        $id = $request->id;
        $mode = $request->mode;

        if ($mode == 'granting')
        {
            DB::table('ip_login_access')
                ->where('id',$id)
                ->update([
                    'accessibility' => 'grant'
                ]);
        }
        else if ($mode == 'denying')
        {
            DB::table('ip_login_access')
                ->where('id',$id)
                ->update([
                    'accessibility' => 'deny'
                ]);
        }
        else if($mode == 'deleting')
        {
            DB::table('ip_login_access')
                ->where('id',$id)
                ->delete();
        }
        else
        {
            return 'nothing to do here';
        }

    }

    public function user_accessibility(Request $request)
    {

        $id = $request->id;
        $mode = $request->mode;

        if ($mode == 'granting')
        {
            DB::table('roles')
                ->where('id',$id)
                ->update([
                    'login_access' => 'grant'
                ]);
        }
        else if ($mode == 'denying')
        {
            DB::table('roles')
                ->where('id',$id)
                ->update([
                    'login_access' => 'deny'
                ]);
        }
        else
        {
            return 'nothing to do here';
        }

    }

    public function admin_add_ip_access(Request $request)
    {
        $ip = $request->ip;
        $branch_name = $request->branch_name;
        $access = $request->access;

        DB::table('ip_login_access')
            ->insert([
                'ip' => $ip,
                'office_branch' => $branch_name,
                'accessibility' => $access,
            ]);
    }
    public function admin_addOrRemove_tat_selector(Request $request)
    {
        if($request->check_if_sitel == 'yes')
        {
            DB::table('users')
                ->where('id', $request->id)
                ->update(
                    [
                        'client_check' => 'tat_selector'
                    ]
                );

            return 'Successfully added tat selection';
        }
        else
        {
            DB::table('users')
                ->where('id', $request->id)
                ->update(
                    [
                        'client_check' => ''
                    ]
                );

            return 'Successfully removed tat selection';
        }
    }

    public function admin_get_bi_view()
    {
        $getbiAcc = DB::table('bi_account_to_users')
            ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
            ->select([
                'bi_account_to_users.users_id as id',
                'users.name as name',
                'bi_account_to_users.id as id_del'
            ])
            ->groupBy('id')
            ->get();

        $getAllBiID = DB::table('bi_account_list')
            ->select('id', 'bi_account_name','account_location')
            ->get();

        return response()->json([$getbiAcc, $getAllBiID]);
    }

    public function admin_bi_change_bi_view_table(Request $request)
    {
        $getInfo = DB::table('bi_account_to_users')
            ->join('bi_account_list', 'bi_account_list.id', 'bi_account_to_users.bi_account_id')
            ->select([
                'bi_account_to_users.users_id as id',
                'bi_account_to_users.id as org_id',
                'bi_account_list.bi_account_name as name',
                'bi_account_list.account_location as loc',
                'bi_account_to_users.to_display as display'
            ])
            ->where('bi_account_to_users.users_id', $request->id);

        return DataTables::of($getInfo)
            ->make(true);
    }

    public function admin_update_bi_default_view(Request $request)
    {
        $getCount = DB::table('bi_account_to_users')
            ->select('id')
            ->where('users_id', $request->id)
            ->get();

        for($i = 0; $i < count($getCount); $i++)
        {
            DB::table('bi_account_to_users')
                ->where('id', $getCount[$i]->id)
                ->update([
                    'to_display' => ''
                ]);
        }
//
        DB::table('bi_account_to_users')
            ->where('users_id', $request->id)
            ->where('id', $request->orig_id)
            ->update([
                'to_display' => 'display'
            ]);

//        return 'BI default view is successfully changed';
    }

    public function admin_delete_bi_view(Request $request)
    {
        DB::table('bi_account_to_users')
            ->where('id', $request->id)
            ->delete();

        return 'Successfully deleted';
    }

    public function admin_add_viewable_to_bi(Request $request)
    {
        $validate = DB::table('bi_account_to_users')
            ->where('users_id', $request->user_id)
            ->where('bi_account_id', $request->bi_accnt_id)
            ->count();

        if($validate > 0)
        {
            return 'Account already has the access';
        }
        else
        {
            DB::table('bi_account_to_users')
                ->insert([
                    'users_id' => $request->user_id,
                    'bi_account_id' => $request->bi_accnt_id,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'Access successfully added';
        }
    }

    public function admin_access_control(Request $request)
    {
        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'client_type' => $request->client_type,
                'client_check' => $request->client_check,
                'authrequest' => $request->authrequest
            ]);
    }

    public function admin_get_access_of_user(Request $request)
    {
        $getInfo = DB::table('users')
            ->select('client_type', 'client_check', 'authrequest')
            ->where('id', $request->id)
            ->get();

        return $getInfo;
    }

    public function admin_get_all_tele_level_table()
    {
        $getTele = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('cc_tele_levels', 'cc_tele_levels.user_id', '=', 'users.id')
            ->select([
                'users.id as id',
                'users.name as name',
                'cc_tele_levels.level as status',
                'cc_tele_levels.id as table_id',
            ])
            ->where('role_user.role_id', 17)
            ->where('users.archive', 'False');

        return DataTables::of($getTele)
            ->make(true);
    }

    public function admin_levelup_tele(Request $req)
    {
        $check = DB::table('cc_tele_levels')
            ->where('user_id', $req->id)
            ->get();

        if(count($check) > 0)
        {
            DB::table('cc_tele_levels')
                ->where('user_id', $req->id)
                ->update([
                    'level' => 2,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else
        {
            DB::table('cc_tele_levels')
                ->insert([
                    'user_id' => $req->id,
                    'level' => 2,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
    }

    public function admin_downlevel_tele(Request $req)
    {
        $check = DB::table('cc_tele_levels')
            ->where('user_id', $req->id)
            ->get();

        if(count($check) > 0)
        {
            DB::table('cc_tele_levels')
                ->where('user_id', $req->id)
                ->update([
                    'level' => 1,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else
        {
            DB::table('cc_tele_levels')
                ->insert([
                    'user_id' => $req->id,
                    'level' => 1,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
    }

    public function admin_get_reminder_table()
    {
        $reminder = DB::table('reminder_list')
            ->select([
                'reminder_list.id as id',
                'reminder_list.reminder_name as name',
                'reminder_list.day_of_reminder as day',
                'reminder_list.created_at as datetime'
            ]);

        return DataTables::of($reminder)
            ->make(true);
    }

    public function admin_add_reminder(Request $request)
    {
        DB::table('reminder_list')
            ->insert([
                'reminder_name' => $request->reminder_name,
                'day_of_reminder' => $request->rem_day,
                'created_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function admin_edit_or_remove_reminder(Request $request)
    {
        if($request->type == 'remove')
        {
            DB::table('reminder_list')
                ->where('id', $request->id)
                ->delete();

            return 'Record Successfully Deleted';
        }
        else if($request->type == 'edit')
        {
            DB::table('reminder_list')
                ->where('id', $request->id)
                ->update([
                    'reminder_name' => $request->reminder_name,
                    'day_of_reminder' => $request->reminder_day,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            return 'Record Successfully Modified';
        }
    }

    public function admin_get_to_email_user_and_client()
    {
        $users = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.email as email',
            ])
            ->where('archive', 'False')
            ->where(function($query)
            {
                return $query->where('role_id', '!=', 6)
                    ->where('role_id', '!=', 14);
            })
            ->orderBy('users.name', 'asc')
            ->get();

        $clients = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select([
                'users.id as id',
                'users.name as name',
            ])
            ->where('archive', 'False')
            ->where('role_id', 6)
            ->orderBy('users.name', 'asc')
            ->get();

        $positions = DB::table('roles')
            ->select([
                'id',
                'name'
            ])
            ->get();

        return response()->json([$users, $clients, $positions]);
    }

    public function admin_endorsements_email_receiver_table(Request $request)
    {
        $getTable = DB::table('emails_to_send')
            ->join('users as user', 'user.id', '=', 'emails_to_send.user_id')
            ->join('users as client', 'client.id', '=', 'emails_to_send.client_id')
            ->where('client.id', $request->client_name)
            ->select([
                'emails_to_send.id as id',
                'user.name as name',
            ]);

        return DataTables::of($getTable)
            ->make(true);
    }

    public function admin_add_user_to_email_endorsements(Request $request)
    {
        $id = base64_decode($request->id);

        DB::table('emails_to_send')
            ->where('id', $id)
            ->delete();

        return 'success';
    }

    public function admin_add_recipient_endorsement(Request $request)
    {
        $check_if_exist = DB::table('emails_to_send')
            ->where('user_id', $request->user_id)
            ->where('client_id', $request->client_id)
            ->where('email_for', 'ClientNotif')
            ->count();

        if($check_if_exist > 0)
        {
            return 'already existing';
        }
        else
        {
            DB::table('emails_to_send')
                ->insert([
                    'user_id' => $request->user_id,
                    'client_id' => $request->client_id,
                    'email_for' => 'ClientNotif'
                ]);

            return 'success';
        }
    }

    public function admin_get_all_defined_pos(Request $request)
    {
        $pos_id = $request->pos_id;

        $getNamewitPos = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
//            ->where('role_id', $request->pos_id)
            ->where(function($query) use ($pos_id)
            {
                if($pos_id != '')
                {
                    return $query->where('role_id', $pos_id);
                }
            })
            ->where('archive', 'False')
            ->select([
                'users.name as name',
                'users.id as id'
            ])
            ->orderBy('users.name', 'asc')
            ->get();

        return response()->json($getNamewitPos);
    }
    
    public function admin_get_all_active_client(Request $request)
    {
        $getUserClient = DB::table('users')
            ->where('client_check', '=', 'client_branch')
            ->where('archive', '=', 'False')
            ->select(
                'users.id as id',
                'users.name as name'
            )
            ->get();

        return $getUserClient;
    }

    public function admin_add_client_dist_list(Request $request)
    {
//        return response()->json([$request->branch_id, $request->app_bool]);

        $check = DB::table('email_dist_client')
            ->where('client_branch_id', '=', $request->branch_id)
//            ->where('applicable_bool', '=', $request->app_bool)
            ->count();

        if($check <= 0)
        {
            DB::table('email_dist_client')
                ->insert([
                    'client_branch_id' => $request->branch_id,
                    'applicable_bool' => $request->app_bool,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'added';
        }
        else
        {
            DB::table('email_dist_client')
                ->where('client_branch_id', '=', $request->branch_id)
                ->update([
                    'client_branch_id' => $request->branch_id,
                    'applicable_bool' => $request->app_bool,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            return 'updated';
        }
    }

    public function admin_add_email_to_distribution_list(Request $request)
    {
        $check = '';
        $brach_check = DB::table('email_dist_client')
            ->where('client_branch_id', '=', $request->branch_id)
            ->select('applicable_bool')
            ->get();



        if($brach_check[0]->applicable_bool == 'false')
        {
            $check = DB::table('email_dist_client_to_users')
                ->where('client_branch_id', '=', $request->branch_id)
                ->where('user_email', '=', $request->user_email)
//                ->where('type', '!=', $request->archi)
                ->count();
        }
        else
        {
            $check = DB::table('email_dist_client_to_users')
                ->where('client_branch_id', '=', $request->branch_id)
                ->where('user_email', '=', $request->user_email)
                ->where('type', '==', $request->archi)
                ->count();
        }


        if($check > 0)
        {

            return 'already';
            //ALREADY

//            if(count($brach_check) > 0)
//            {
//                if($brach_check[0]->applicable_bool == 'false')
//                {
//                    DB::table('email_dist_client_to_users')
//                        ->insert([
//                            'client_branch_id' => $request->branch_id,
//                            'user_email' => $request->user_email,
//                            'type' => '-',
//                            'created_at' => Carbon::now('Asia/Manila')
//                        ]);
//                }
//                else
//                {
//
//                    DB::table('email_dist_client_to_users')
//                        ->insert([
//                            'client_branch_id' => $request->branch_id,
//                            'user_email' => $request->user_email,
//                            'type' => $request->archi,
//                            'created_at' => Carbon::now('Asia/Manila')
//                        ]);
//                }
//
//                return 'updaed';
//            }
        }
        else
        {

            //TO ADD


            if(count($brach_check) > 0)
            {
                if($brach_check[0]->applicable_bool == 'false')
                {
                    DB::table('email_dist_client_to_users')
                        ->insert([
                            'client_branch_id' => $request->branch_id,
                            'user_email' => $request->user_email,
                            'type' => '-',
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
                else
                {
                    DB::table('email_dist_client_to_users')
                        ->insert([
                            'client_branch_id' => $request->branch_id,
                            'user_email' => $request->user_email,
                            'type' => $request->archi,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
//
                return 'added';
            }


        }
    }

    public function admin_get_distribution_list_with_emails(Request $request)
    {
        $getBranchList = '';
        $brach_check = DB::table('email_dist_client')
            ->where('client_branch_id', '=', $request->branch_id)
            ->select('applicable_bool')
            ->get();

        if(count($brach_check) > 0)
        {
            if($brach_check[0]->applicable_bool == 'true')
            {
                $getBranchList = DB::table('email_dist_client_to_users')
                    ->where('client_branch_id', '=', $request->branch_id)
                    ->where('type', '=', $request->archi)
                    ->select(
                        'id',
                        'user_email',
                        'type as archipelago'
                    )
                    ->get();
            }
            else
            {
                $getBranchList = DB::table('email_dist_client_to_users')
                    ->where('client_branch_id', '=', $request->branch_id)
//                    ->where('type', '=', $request->archi)
                    ->select(
                        'id',
                        'user_email',
                        'type as archipelago'
                    )
                    ->get();
            }
        }



        return response()->json([$getBranchList, $brach_check]);
    }

    public function admin_delete_email_to_dist_list(Request $request)
    {
        DB::table('email_dist_client_to_users')
            ->where('id', $request->id)
            ->delete();
    }
    
    public function admin_give_access_ci(Request $request)
    {
        $perm = '';

        if($request->type == 'add')
        {
            $perm = 'Yes';
        }
        else if($request->type == 'remove')
        {
            $perm = '';
        }

        DB::table('users')
            ->where('id', $request->id)
            ->update
            ([
                'ci_update_date_permission' => $perm
            ]);
    }
   public function fetchBIAccounts()
    {
      $get_general_table = DB::table('bi_endorsements')
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
            ])
            ->groupBy('bi_endorsements.id');
            //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')


        return DataTables::of($get_general_table)
            ->make(true);
    }

    public function admin_edit_bi_time_due(Request $request)
    {
        DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->update
            ([
                'date_time_due' => $request->date.' '.$request->time,
            ]);
    }

    public function admin_bi_hide_acct(Request $request)
    {
        DB::table('bi_endorsements')
            ->where('id', $request->id)
            ->update
            ([
                'status' => 1999,
            ]);
    }
    
       public function admin_bi_user_loc_table_get(Request $request)
    {

        $getInfoList = DB::table('bi_users_under_location')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_users_under_location.bi_site')
            ->select
            ([
                'bi_users_under_location.id as id',
                'bi_account_list.bi_account_name as name',
                'bi_account_list.account_location as loc',
            ])
            ->where('bi_users_under_location.bi_id', $request->id);

        return DataTables::of($getInfoList)
            ->make(true);
    }

    public function admin_add_loc_to_bi_user(Request $request)
    {
        $checkIfExist = DB::table('bi_users_under_location')
            ->where('bi_site', $request->loc)
            ->where('bi_id', $request->id)
            ->count();

        if($checkIfExist > 0)
        {
            return 'exist';
        }
        else
        {
            DB::table('bi_users_under_location')
                ->insert
                ([
                    'bi_id' => $request->id,
                    'bi_site' => $request->loc,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'ok';
        }
    }

    public function admin_delete_loc_under_bi(Request $request)
    {
        DB::table('bi_users_under_location')
            ->where('id', $request->id)
            ->delete();
    }
    
     public function fetchUsersAccountManage(Request $request)
    {
        $file_users_bank = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('provinces','provinces.id','=','users.branch')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select([
                'users.id as id',//1
                'users.Emp_ID as Emp_ID',//2
                'users.name as name',//3
                'users.email as email',//4
                'role_user.role_id as pos_id',
                'provinces.name as pro_branch',
                'provinces.id as pro_id',
                'roles.name as role_name',
            ]);
//            ->get();
//        return $file_manager_bank;
//
//        $endorsementsw = DB::table('endorsements');
//
        return DataTables::of($file_users_bank)
            ->make(true);
    }



    public function del_cont(Request $request)
    {
        $userID = User::find($request->id);
        File::delete(public_path($userID->pix_path));

        $users = DB::table('users')
            ->where('id', $request->id)
            ->delete();
        return $users;
    }
    
    public function fetchBankAccountManage(Request $request)
    {
        $file_manager_bank = DB::table('endorsements')
            ->select([
                'endorsements.id as id',//1
                'endorsements.date_endorsed as date_endorsed',//2
                'endorsements.time_endorsed as time_endorsed',//3
                'endorsements.account_name as account_name',//4
                'endorsements.address as address',//5
                'endorsements.requestor_name as requestor_name',//6
                'endorsements.type_of_request as type_of_request',//7
                'endorsements.provinces as provinces',//8
                'endorsements.client_name as client_name',//9
                'endorsements.link_path as link_path',//10
            ]);
//            ->get();
//        return $file_manager_bank;
//
//        $endorsementsw = DB::table('endorsements');
//
        return DataTables::of($file_manager_bank)
            ->make(true);
    }

    public function fetchBIAccountManage(Request $request)
    {
//        $biendorse = DB::table('bi_endorsements');
//
//        return DataTables::of($biendorse)
//            ->make(true);

        $get_general_table = DB::table('bi_endorsements')
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
            ])
            ->groupBy('bi_endorsements.id');
        //            ->groupBy('bi_endorsements_checkings.bi_endorsement_id')


        return DataTables::of($get_general_table)
            ->make(true);
    }
}

