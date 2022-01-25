<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Generals\AuditQueries;
use App\Generals\DashboardQueries;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function viewLogin()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
        {
            return view('errors.down');
        }
        else
        {
            if(Auth::user()==null)
            {
                Auth::logout();
                return view('login');
            }
            elseif(Auth::user()!==null)
            {
                return redirect()->back()->withErrors('Someone is still logged.');
            }
        }
    }

    public function login(Request $request)
    {

        $ready_to_go = false;

        $ip = request()->ip();

        $cavite = '192.168.2.20'; // 124.83.47.123
        $davao = '192.168.2.12'; // 182.18.250.111
        $summit = '::1'; // 103.62.31.122
        $cebu = '127.0.0.1'; // 130.105.41.74

        $get_ip = DB::table('ip_login_access')
            ->select('ip','office_branch','accessibility')
            ->get();

        if(count($get_ip) != 0)
        {
            foreach ($get_ip as $ip_grant)
            {
                if($ip_grant->ip == $ip)
                {
                    if($ip_grant->accessibility == 'grant')
                    {
                        $ready_to_go = true;
                    }
                    else
                    {
                        $ready_to_go = false;
                    }
                }

            }
        }
        else
        {
            $ready_to_go = false;
        }


//
//        if($ip == $cavite)
//        {
//            $ready_to_go = true;
//        }
//        else if($ip == $davao)
//        {
//            $ready_to_go = true;
//        }
//        else if($ip == $summit)
//        {
//            $ready_to_go = true;
//        }
//        else if($ip == $cebu)
//        {
//            $ready_to_go = true;
//        }
//        else
//        {
//            $ready_to_go = false;
//        }

        $user_login_access = DB::table('roles')
            ->select('name','login_access')
            ->where('login_access','grant')
            ->get();

        $email_get = $request['email'];
        $pass_get = $request['password'];

        if($request->password_2 != null)
        {
            if($request->password_2 == 'secret_indi')
            {
                $email_get = gzinflate(base64_decode($request['email']));
                $pass_get = gzinflate(base64_decode($request['password']));
            }
        }


        if (Auth::user() !== null) //already logged in
        {
            return view('login')->withErrors('Someone is still logged in.');
        }
        else if(Auth::attempt(['email' => $email_get, 'password' => $pass_get])) //logging in /checkings
        {

            if(count($user_login_access) != 0)
            {
                foreach ($user_login_access as $user_access)
                {
                    if(Auth::user()->hasRole($user_access->name))
                    {
                        $ready_to_go = true;
                    }
                }
            }

//            if(Auth::user()->hasRole('Credit Investigator') || Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Client') || Auth::user()->hasRole('B.I Client'))
//            {
//                $ready_to_go = true;
//            }

            if(!$ready_to_go)
            {
                Auth::logout();
                return redirect()->route('/')->withErrors('Your IP doesn\'t match in our required address.');
            }
            else
            {
                $ready_to_go = true;
            }
        }
        else //failed to login
        {
            $c = 0;
            $check = DB::table('attempt')
                ->select('user_attempt', 'count')
                ->where('user_attempt', $email_get)
                ->get();


            if (count($check) > 0) {

                if ($check[0]->count >= 4) {
                    DB::table('attempt')
                        ->where('user_attempt', $check[0]->user_attempt)
                        ->update([
                            'count' => ($check[0]->count) + 1,
                            'date_time' => Carbon::now('Asia/Manila'),
                            'lock' => 'true'
                        ]);
                    $c = 5;
                } else {
                    DB::table('attempt')
                        ->where('user_attempt', $check[0]->user_attempt)
                        ->update([
                            'count' => ($check[0]->count) + 1,
                            'lock' => 'false',
                            'date_time' => Carbon::now('Asia/Manila')
                        ]);
                    $c = ($check[0]->count) + 1;
                }
            } else {
                DB::table('attempt')
                    ->insert([
                        'user_attempt' => $email_get,
                        'count' => 1,
                        'lock' => 'false',
                        'date_time' => Carbon::now('Asia/Manila')
                    ]);
                $c = 1;
            }

            $message = 'Invalid Username or Password (User: ' . $email_get . ' Attempt: ' . $c . '/5)';

            if ($c == 5) {
                $message = 'You exceed the maximum attempt for User : ' . $email_get . ', This account will not be able to login, please contact administrator.';
            }

            return redirect()->back()->withErrors($message);
        }

        if ($ready_to_go)
        {
            $lockba = false;

            $checkiflock = DB::table('attempt')
                ->select('lock')
                ->where('user_attempt', $email_get)
                ->get();

            if (count($checkiflock) > 0) {
                if ($checkiflock[0]->lock == 'true') {
                    $lockba = true;
                }
            }

            if (!$lockba) {
                DB::table('attempt')
                    ->where('user_attempt', $email_get)
                    ->delete();

                $auditLogin = new AuditQueries();
                $auditLogin->login($request);
                $checkarchive = Auth::user()->archive;

                if(Auth::user()->login_check == 'TFS')
                {
                    if ($checkarchive === 'True') {
                        Auth::logout();
                        return redirect()->route('/')->withErrors('Your account has been suspended! Please contact your Administrator');
                    }
                    elseif (Auth::user() == null) {
                        Auth::logout();
                        return redirect()->route('/');
                    }
                    elseif (Auth::user()->hasRole('B.I Client')) {
                        return redirect()->route('tfs_background-investigation-panel');
                    }
                }
                else
                {
                    if ($checkarchive === 'True') {
                        Auth::logout();
                        return redirect()->route('/')->withErrors('Your account has been suspended! Please contact your Administrator');
                    }
                    elseif (Auth::user() == null) {
                        Auth::logout();
                        return redirect()->route('/');
                    }
                    elseif (Auth::user()->hasRole('Dispatcher')) {
                        return redirect()->route('dispatcher-panel');
                    }
                    elseif (Auth::user()->hasRole('Account Officer')) {
                        return redirect()->route('ao-panel');
                    }
                    elseif (Auth::user()->hasRole('Client')) {
                        return redirect()->route('client-panel');
                    }
                    elseif (Auth::user()->hasRole('Administrator')) {
                        return redirect()->route('admin-dashboard')->with(["page" => "admindashboard"]);
                    }
                    elseif (Auth::user()->hasRole('Credit Investigator')) {
                        return redirect()->route('ci-endorse')->with(["page" => "ci-endorse"]);
                    }
                    elseif (Auth::user()->hasRole('Management')) {
                        return redirect()->route('management-panel');
                    }
                    elseif (Auth::user()->hasRole('Senior Account Officer')) {
                        return redirect()->route('sao-panel');
                    }
                    elseif (Auth::user()->hasRole('Billing')) {
                        return redirect()->route('billing-panel');
                    }
                    elseif (Auth::user()->hasRole('Marketing')) {
                        return redirect()->route('marketing-panel');
                    }
                    elseif (Auth::user()->hasRole('Audit')) {
                        return redirect()->route('audit-panel');
                    }
                    elseif (Auth::user()->hasRole('Finance')) {
                        return redirect()->route('finance-panel');
                    }
                    elseif (Auth::user()->hasRole('Admin Staff')) {
                        return redirect()->route('admin-staff-panel');
                    }
                    elseif (Auth::user()->hasRole('Human Resources')) {
                        return redirect()->route('human-resources-panel');
                    }
                    elseif (Auth::user()->hasRole('B.I Client')) {
                        return redirect()->route('background-investigation-panel');
                    }
                    elseif (Auth::user()->hasRole('CC Senior Account Officer')) {
                        return redirect()->route('cc-sao-panel');
                    }
                    elseif (Auth::user()->hasRole('CC Account Officer')) {
                        return redirect()->route('cc-ao-panel');
                    }
                    elseif (Auth::user()->hasRole('CC Tele Encoder')) {
                        return redirect()->route('cc-tele-panel');
                    }
                    elseif (Auth::user()->hasRole('C.I Supervisor')) {
                        return redirect()->route('ci-sup-panel');
                    }
                    elseif (Auth::user()->hasRole('General Access')) {
                        return redirect()->route('general-attendance-panel');
                    }
                    elseif (Auth::user()->hasRole('IT Dept')) {
                        return redirect()->route('it-dept-panel');
                    }
                    elseif (Auth::user()->hasRole('Quality Analyst')) {
                        return redirect()->route('qa-panel');
                    }
                    
                }


                return redirect()->back()->withErrors('Insufficient privilege access, please contact your system administrator - Error 500');

            } else if ($lockba)
            {
                Auth::logout();
                return redirect()->back()->withErrors('You exceed the maximum attempt for User : ' . $email_get . ', This account will not be able to login, please contact administrator.');
            }
        }

    }

    public function login_redirect()
    {
        if(Auth::user()->hasRole('Dispatcher'))
        {
            return redirect()->route('dispatcher-panel');
        }
        elseif(Auth::user()->hasRole('Account Officer'))
        {
            return redirect()->route('ao-panel');
        }
        elseif(Auth::user()->hasRole('Client'))
        {
            return redirect()->route('client-panel');
        }
        elseif(Auth::user()->hasRole('Administrator'))
        {
            return redirect()->route('admin-dashboard')->with(["page" => "admindashboard"]);
        }
        elseif(Auth::user()->hasRole('Credit Investigator'))
        {
            return redirect()->route('ci-endorse')->with(["page" => "ci-endorse"]);
        }
        elseif(Auth::user()->hasRole('Management'))
        {
            return redirect()->route('management-panel');
        }
        elseif(Auth::user()->hasRole('Senior Account Officer'))
        {
            return redirect()->route('sao-panel');
        }
        elseif(Auth::user()->hasRole('Billing'))
        {
            return redirect()->route('billing-panel');
        }
        elseif(Auth::user()->hasRole('Marketing'))
        {
            return redirect()->route('marketing-panel');
        }
        elseif(Auth::user()->hasRole('Audit'))
        {
            return redirect()->route('audit-panel');
        }
        elseif(Auth::user()->hasRole('Finance'))
        {
            return redirect()->route('finance-panel');
        }
        elseif(Auth::user()->hasRole('Admin Staff'))
        {
            return redirect()->route('admin-staff-panel');
        }
        elseif(Auth::user()->hasRole('Human Resources'))
        {
            return redirect()->route('human-resources-panel');
        }
        elseif(Auth::user()->hasRole('B.I Client'))
        {
            return redirect()->route('background-investigation-panel');
        }
        elseif(Auth::user()->hasRole('CC Senior Account Officer'))
        {
            return redirect()->route('cc-sao-panel');
        }
        elseif(Auth::user()->hasRole('CC Account Officer'))
        {
            return redirect()->route('cc-ao-panel');
        }
        elseif(Auth::user()->hasRole('CC Tele Encoder'))
        {
            return redirect()->route('cc-tele-panel');
        }
        elseif(Auth::user()->hasRole('C.I Supervisor'))
        {
            return redirect()->route('ci-sup-panel');
        }
        elseif (Auth::user()->hasRole('General Access'))
        {
            return redirect()->route('general-attendance-panel');
        }
        elseif (Auth::user()->hasRole('IT Dept'))
        {
            return redirect()->route('it-dept-panel');
        }
        elseif (Auth::user()->hasRole('Quality Analyst'))
        {
            return redirect()->route('qa-panel');
        }
        else
        {
            return view('login')->withErrors('Someone is still logged in');
        }
    }
}

