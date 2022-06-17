<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\bi_endorsement;
use App\Endorsement;
use App\Events\SAOdispatchChat;
use App\Generals\AuditQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\EmailQueries;
use App\Generals\Trimmer;
use App\User;
use Carbon\Carbon;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\Html;
use Yajra\DataTables\Facades\DaTatables;
use ZanySoft\Zip\Zip;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade as PDF;

//Kiosk loan
use App\Http\Controllers\KioskEndorsementController;

//========================================KIOSK LOAN ROUTE============================================================

Route::get('/loan-form', 'KioskEndorsementController@index');
Route::get('/show', 'KioskEndorsementController@show');

Route::post('/store-endorsement', 'KioskEndorsementController@store');
Route::post('/delete-endorsement/{id}', 'KioskEndorsementController@destroy');
Route::get('/approve-endorsement/{id}', 'KioskEndorsementController@approve');

// Route::post('kiosk_create', 'LoanFormController@kiosk_create');


//========================================GENERAL ROUTE ROUTE=========================================================

Route::get('/',
    [
        'uses' => 'LoginController@viewLogin',
        'as' => '/'
    ]);

Route::get('/login',
    [
        'uses' => 'LoginController@viewLogin',
        'as' => '/login'
    ]);

Route::get('/byp455l0g1n', function () {
    return view('login');
});


Route::post('/auth-login',
    [
        'uses' => 'LoginController@login',
        'as' => 'auth-login'
    ]);

Route::get('/dashboard-redirect',
    [
        'uses' => 'LoginController@login_redirect',
        'as' => 'dashboard-redirect'
    ]);

Route::get('/general-dashboard',
    [
        'uses' => 'GeneralController@getGeneralDashboard',
        'as' => 'general-dashboard',
    ]);

Route::get('/account-monitoring',
    [
        'uses' => 'GeneralController@getAccountMonitoring',
        'as' => 'account-monitoring'
    ]);

Route::get('/privilege-error',
    [
        'uses' => 'GeneralController@privilegeError',
        'as' => 'privilege-error'
    ]);

Route::get('/logout',
    [
        'uses' => 'GeneralController@logout',
        'as' => 'logout'
    ]);

Route::get('/list-endorsement',
    [
        'uses' => 'GeneralController@endorsementList',
        'as' => 'list-endorsement'
    ]);

Route::get('/list-endorsement-management',
    [
        'uses' => 'GeneralController@endorsementListManagement',
        'as' => 'list-endorsement-management'
    ]);

Route::get('/idle',
    [
        'uses' => 'GeneralController@idle',
        'as' => 'idle'
    ]);

Route::get('/not-idle',
    [
        'uses' => 'GeneralController@notIdle',
        'as' => 'not-idle'
    ]);

Route::get('/cicheckeroffline',
    [
        'uses' => 'CIcheckerOffline@getview',
        'as' => 'cicheckeroffline'
    ]);

Route::get('/cicheckeroffline/ok',
    [
        'uses' => 'CIcheckerOffline@offlinechecker',
        'as' => 'cicheckeroffline/ok'
    ]);

Route::get('/cicheckeroffline/off',
    [
        'uses' => 'CIcheckerOffline@offlineupdater',
        'as' => 'cicheckeroffline/off'
    ]);

Route::get('/cicheckeroffline/address',
    [
        'uses' => 'CIcheckerOffline@addressupdater',
        'as' => 'cicheckeroffline/address'
    ]);

Route::post('/user-notification-srao-dispatcher',
    [
        'uses' => 'CIcheckerOffline@getNotifSraoDispatcher',
        'as' => 'user-notification-srao-dispatcher'
    ]);

Route::get('/gen-dashboard-getdatalatlong',
    [
        'uses' => 'GeneralController@LatLongUpdate',
        'as' => 'gen-dashboard-getdatalatlong'
    ]);

Route::get('/gen-savesuggestion',
    [
        'uses' => 'GeneralController@SaveSuggestion',
        'as' => 'gen-savesuggestion'
    ]);

Route::get('/fetch-city-muni',
    [
        'uses' => 'GeneralController@fetchCityMuni',
        'as' => 'fetch-city-muni'
    ]);
Route::get('/fetch-city-muniv2',
    [
        'uses' => 'GeneralController@fetchCityMuniv2',
        'as' => 'fetch-city-muni'
    ]);

Route::get('/fetch-prov',
    [
        'uses' => 'GeneralController@fetchProvince',
        'as' => 'fetch-prov'
    ]);

//hr names

Route::get('/fetch-hr-names',
    [
        'uses' => 'GeneralController@fetchHRNames',
        'as' => 'fetch-hr-names'
    ]);

Route::get('/fetch-hr-id',
    [
        'uses' => 'GeneralController@fetchHRID',
        'as' => 'fetch-hr-id'
    ]);




Route::get('/gen-get-tor-other-evr',
    [
        'uses' => 'GeneralController@GetTorOtherEVR',
        'as' => 'gen-get-tor-other-evr'
    ]);
Route::get('/gen-get-tor-other-bvr',
    [
        'uses' => 'GeneralController@GetTorOtherBVR',
        'as' => 'gen-get-tor-other-bvr'
    ]);

Route::get('/gen-get-ci-directory',
    [
        'uses' => 'GeneralController@GetCI',
        'as' => 'gen-get-ci-directory'
    ]);

Route::get('/gen-get-ci-directory-info',
    [
        'uses' => 'GeneralController@GetCI_info',
        'as' => 'gen-get-ci-directory-info'
    ]);

Route::get('/get_ci_login_trail',
    [
        'uses' => 'GeneralController@get_ci_login_trail',
        'as' => 'get_ci_login_trail'
    ]);

Route::get('/gen-getpolls',
    [
        'uses' => 'GeneralController@Polls',
        'as' => 'gen-getpolls'
    ]);

Route::get('/gen-addpolls',
    [
        'uses' => 'GeneralController@AddPolls',
        'as' => 'gen-addpolls'
    ]);

Route::get('/gen-votepolls',
    [
        'uses' => 'GeneralController@VotePoll',
        'as' => 'gen-votepolls'
    ]);

Route::get('/gen-getexistvotes',
    [
        'uses' => 'GeneralController@checkVotes',
        'as' => 'gen-getexistvotes'
    ]);

Route::post('/gen-change-pass',
    [
        'uses' => 'GeneralController@changePass',
        'as' => 'gen-change-pass'
    ]);

Route::get('/gen-session-info',
    [
        'uses' => 'GeneralController@getSessionInfo',
        'as' => 'gen-session-info'
    ]);

Route::get('/gen-destroy-session',
    [
        'uses' => 'GeneralController@getDestroySession',
        'as' => 'gen-destroy-session'
    ]);

Route::get('/fetch-subjcoob',
    [
        'uses' => 'GeneralController@fetchSubjForCoob',
        'as' => 'fetch-subjcoob'
    ]);

Route::get('/general-checkifoffline',
    [
        'uses' => 'GeneralController@checkIfOffline',
        'as' => 'general-checkifoffline'
    ]);

Route::post('/general-send-req-item-re-rep',
    [
        'uses' => 'GeneralController@reqItReRep',
        'as' => 'general-send-req-item-re-rep'
    ]);

Route::get('/general-get-req-list-info',
    [
        'uses' => 'GeneralController@getReqListInfo',
        'as' => 'general-get-req-list-info'
    ]);

Route::post('/general-send-req-item-list',
    [
        'uses' => 'GeneralController@reqItemList',
        'as' => 'general-send-req-item-list'
    ]);

Route::get('/bi_download_files_universal',
    [
        'uses' => 'GeneralController@bi_download_files_universal',
        'as' => 'bi_download_files_universal'
    ]);

Route::get('/bi_get_view_information',
    [
        'uses' => 'GeneralController@bi_get_view_information',
        'as' => 'bi_get_view_information'
    ]);
Route::post('change-dp',
    [
        'uses' => 'GeneralController@change_dp',
        'as' => 'change_dp'
    ]);

Route::get('bi-view-info-dl',
    [
        'uses' => 'GeneralController@bi_view_info_dl',
        'as' => 'bi-view-info-dl'
    ]);

Route::get('/concentrix/view-account-transaction',
    [
        'uses' => 'GeneralController@view_account_transaction',
        'as' => '/concentrix/view-account-transaction'
    ]);

Route::get('/concentrix', function(Request $request)
{
//    $user = User::find(365); // ONLINE
    $user = User::find(355); // localhost RANYLL
    Auth::login($user);
    $ip = $request->ip();

//    if($ip == '127.0.0.1' || $ip == '::1')
//    {
        return response()->view('DirectEndorsedFormV2');
//    }
//    else
//    {
//        abort(404);
//    }
});

Route::get('view-transaction', function()
{
    return view('ViewTransactionForm');
});

Route::get('bi_direct_encoded_account',
    [
        'uses' => 'GeneralController@bi_direct_encoded_account',
        'as' => 'bi_direct_encoded_account'
    ]);

Route::post('bi_direct_encoded_account_upload',
    [
        'uses' => 'GeneralController@bi_direct_encoded_account_upload',
        'as' => 'bi_direct_encoded_account_upload'
    ]);

Route::get('view_account_transaction',
    [
        'uses' => 'GeneralController@view_account_transaction',
        'as' => 'view_account_transaction'
    ]);
    
    
Route::get('gen_monit_issuance_table',
    [
        'uses' => 'GeneralController@gen_monit_issuance_table',
        'as' => 'gen_monit_issuance_table',
        'role' => 'General'
    ]);

Route::get('gen_fetch_issuance_indiv',
    [
        'uses' => 'GeneralController@gen_fetch_issuance_indiv',
        'as' => 'gen_fetch_issuance_indiv',
        'role' => 'General'
    ]);

Route::get('dl-rep', function(Request $request)
{
    if($request->code2 != 'bankv2')
    {
        $decoded_id = gzinflate(base64_decode($request->code));
    }
    else
    {
        $decoded_id = base64_decode($request->code);
    }

    if($request->code2 == 'bi')
    {
        return 'this is bi';
    }
    else if($request->code2 == 'bank' || $request->code2 == 'bankv2')
    {

        $path_link = new DownloadZipLogic();

        $paths = $path_link->path_link($decoded_id);

        $dlLink = DB::table('endorsements')
            ->select('link_path')
            ->where('id', $decoded_id)
            ->get();

        $path = $dlLink[0]->link_path;


        if(File::exists(storage_path('/account/'.$paths)))
        {
            if (File::isDirectory(storage_path('account/' . $paths)))
            {
                Zip::create(storage_path('/account_report/'.$paths.'.zip'), true)
                    ->add(storage_path('/account/'.$paths), true)
                    ->setPath(storage_path('/account_report'))
                    ->close();
            };

            return response()->download(storage_path("/account_report/".$paths.".zip"));

        }
        else if(File::exists(storage_path('/account_client/'.$paths)))
        {
            if (File::isDirectory(storage_path('account_client/' . $paths)))
            {
                Zip::create(storage_path('/account_report/'.$paths.'.zip'), true)
                    ->add(storage_path('/account_client/'.$paths), true)
                    ->setPath(storage_path('/account_report'))
                    ->close();
            };

            return response()->download(storage_path("/account_report/".$paths.".zip"));

        }
        else if(File::exists(storage_path('/account_report/'.$paths.'.zip')))
        {
            return response()->download(storage_path("/account_report/".$paths.".zip"));
        }
        else
        {
            return 'Report Not Available at this momment';
        }
    }
});

Route::get('testing-route', function()
{
    $existing = DB::table('equipments')
        ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
        ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
        ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
        ->leftJoin('archipelagos as emp_branch', 'emp_branch.id', '=', 'equipment_to_user.branch_id')
        ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
        ->leftJoin('archipelagos as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
        ->leftjoin('emp_position', 'emp_position.id', '=', 'equipment_to_user.position')
        ->leftjoin('assign_logs' , 'assign_logs.equipment_id', 'equipments.id')
        ->where('equipments.barcode', 'O191108-MOIAK00-S144025')
        ->select([
            'equipments.id as id',
            'equipments.barcode as barcode',
            'equipments.type as type',
            'equipments.item_price as item_price',
            'equipments.item_details_type as item_details_type',
            'equipments.item_brand as item_brand',
            'equipments.item_description as item_description',
            'equipments.item_warranty as item_warranty',
            'emp_branch.archipelago_name as emp_branch',
            'emp_branch.id as emp_branch_id',
            'equipment_to_user.employee_id as employee_id',
            'emp_position.position_name as position',
            'emp_position.id as position_id',
            'branch.archipelago_name as branch',
            'branch.id as branch_id',
            'equipments.status as status',
            'assign_logs.remarks as remarks',
            'equipments.current_status as current_status',
            'equipments.created_at as created_at',
            'equipments.updated_at as updated_at'
        ])
        ->orderByDesc('equipment_to_user.id')
        ->orderByDesc('assign_logs.id')
        ->get();

    return $existing;
});

Route::get('barcode-item', function(Request $request)
{
    $barcode = gzinflate(base64_decode($request->code));

    return redirect("/barcode-item-2?code=".$barcode);
});

Route::get('barcode-item-2', function(Request $request)
{
    $barcode = $request->code;

    $existing = DB::table('equipments')
        ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
        ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
        ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
        ->leftJoin('archipelagos as emp_branch', 'emp_branch.id', '=', 'equipment_to_user.branch_id')
        ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
        ->leftJoin('archipelagos as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
        ->leftjoin('emp_position', 'emp_position.id', '=', 'equipment_to_user.position')
        ->leftjoin('assign_logs' , 'assign_logs.equipment_id', 'equipments.id')
        ->where('equipments.barcode', $barcode)
        ->select([
            'equipments.id as id',
            'equipments.barcode as barcode',
            'equipments.type as type',
            'equipments.item_price as item_price',
            'equipments.item_details_type as item_details_type',
            'equipments.item_brand as item_brand',
            'equipments.item_description as item_description',
            'equipments.item_warranty as item_warranty',
            'emp_branch.archipelago_name as emp_branch',
            'emp_branch.id as emp_branch_id',
            'equipment_to_user.employee_id as employee_id',
            'emp_position.position_name as position',
            'emp_position.id as position_id',
            'branch.archipelago_name as branch',
            'branch.id as branch_id',
            'equipments.status as status',
            'assign_logs.remarks as remarks',
            'equipments.current_status as current_status',
            'equipments.created_at as created_at',
            'equipments.updated_at as updated_at'
        ])
        ->orderByDesc('equipment_to_user.id')
        ->orderByDesc('assign_logs.id')
        ->get();

    $get_branch = DB::table('archipelagos')
        ->select('archipelago_name', 'id')
        ->get();

    $get_position = DB::table('emp_position')
        ->select('id', 'position_name')
        ->get();

    if(count($existing) <= 0)
    {
        $selection = DB::table('item_details_admin_inventory')
            ->select('item_type', 'type')
            ->get();

        $data = array(
            'barcode' => $barcode,
            'branches' => $get_branch,
            'positions' => $get_position,
            'item_selection' => $selection
        );

        return view('ScannedBarcodeView')->with($data);
    }
    else
    {
        $data = array(
            'barcode' => $barcode,
            'branches' => $get_branch,
            'existing' => $existing,
            'positions' => $get_position
        );

        return view('ScannedBarcodeView')->with($data);
    }

});

Route::get('barcode_get_auth_user', function()
{
   $user = auth()->user();

   if($user == '' || $user == null)
   {
       return 'need to login';
   }
   else
   {
       if(Auth::user()->archive == 'False')
       {
           if(Auth::user()->hasRole('Admin Staff'))
           {
               return $user->id;
           }
           else
           {
               Auth::logout();
               return 'need to login';
           }
       }
       else
       {
           Auth::logout();
           return 'need to login';
       }

   }
});

Route::get('barcode_get_latest_pic/{index}/{prop}', function($index ,$prop)
{
    $id = base64_decode($index);
    $file_name = base64_decode($prop);


    $path = storage_path('admin_inventory/'.$id.'/'.$file_name);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

//Route::get('/delete-dir/{id}', function ($id)
//{
//    if(Auth::user()->hasRole('Admin Staff'))
//    {
//        if(!File::isDirectory(storage_path('admin_inventory/'. $id)))
//        {
//            return 'success';
//        }
//        else
//        {
//            File::deleteDirectory(storage_path('admin_inventory/'. $id));
//
//            return 'success';
//        }
//    }
//    else
//    {
//        return 'error';
//    }
//});

Route::get('/ci_checking_address_load',
    [
        'uses' => 'CIcheckerOffline@getview_address_checker',
        'as' => 'ci_checking_address_load'
    ]);

//Route::get('/ci-directory-trail-monit',
//    [
//        'uses' => 'GeneralController@ci_directory_trail_monit',
//        'as' => 'ci-directory-trail-monit'
//    ]);

Route::get('/ci-show-attendance-pic/{id}/', function($id)
{
        $idUse = base64_decode($id);

        $getPath = DB::table('ci_login_trails')
            ->select('photo_path')
            ->where('id', $idUse)
            ->get();

        $showPath = storage_path($getPath[0]->photo_path);

//        return $getPath;

        if(count($getPath) > 0)
        {
            if(!File::exists($showPath))
            {
                abort(404);
            }

            $file = File::get($showPath);
            $type = File::mimeType($showPath);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
//            $response->title('CI Attendance Photo');

            return $response;
        }
        else
        {
            return 'No available image at the moment';
        }
    });

Route::get('ci_attendance_bulk_pic/{id}/{filename}', function($id, $filename)
{
    $id = base64_decode($id);
    $filename = base64_decode($filename);

    if(Auth::user() != null)
    {
        $getInfo = DB::table('ci_login_trails')
            ->where('id', $id)
            ->select('photo_path')
            ->get();

        $path = storage_path($getInfo[0]->photo_path.'/'.$filename.'');

        if (!File::exists($path))
        {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    else
    {
        abort(404);
    }
});

Route::get('/generate-excel-attendance-ci',
    [
        'uses' => 'GeneralController@generate_excel_attendance_ci',
        'as' => 'generate-excel-attendance-ci',
        'role' => 'Credit Investigator'
    ]);

Route::get('/generate-excel-attendance-ci-2',
    [
        'uses' => 'GeneralController@generate_excel_attendance_ci_2',
        'as' => 'generate-excel-attendance-ci-2',
        'role' => 'Credit Investigator'
    ]);

Route::post('/general-send-requisition-to-admin',
    [
        'uses' => 'GeneralController@general_send_requisition_to_admin',
        'as' => 'general-send-requisition-to-admin',
        'role' => 'General'
    ]);

Route::get('/general-get-user-name',
    [
        'uses' => 'GeneralController@general_get_user_name',
        'as' => 'general-get-user-name',
        'role' => 'General'
    ]);

Route::get('/gen_approve_requi_approver',
    [
        'uses' => 'GeneralController@gen_approve_requi_approver',
        'as' => 'gen_approve_requi_approver',
        'role' => 'General'
    ]);

Route::get('/gen-requi-table',
    [
        'uses' => 'GeneralController@gen_requi_table',
        'as' => 'gen-requi-table',
        'role' => 'General'
    ]);

Route::get('/gen_requi_table_approved',
    [
        'uses' => 'GeneralController@gen_requi_table_approved',
        'as' => 'gen_requi_table_approved',
        'role' => 'General'
    ]);

Route::get('/gen_requi_table_denied',
    [
        'uses' => 'GeneralController@gen_requi_table_denied',
        'as' => 'gen_requi_table_denied',
        'role' => 'General'
    ]);

Route::get('/gen-deny-requi',
    [
        'uses' => 'GeneralController@gen_deny_requi',
        'as' => 'gen-deny-requi',
        'role' => 'General'
    ]);

Route::get('get_current_bi_note',
    [
        'uses' => 'GeneralController@get_current_bi_note',
        'as' => 'get_current_bi_note',
        'role' => 'General'
    ]);

Route::get('get_bi_reports_table',
    [
        'uses' => 'GeneralController@get_bi_reports_table',
        'as' => 'get_bi_reports_table',
        'role' => 'General'
    ]);

Route::get('/download-ci-bi-attachments', function(Request $request)
{
    if(Auth::user() != null)
    {
        $zipper = new Zipper();
        $id = base64_decode($request->id);
        $test_array = [];
        $downloadThis = '';
        $dateToday = Carbon::now('Asia/Manila');
        $splitDatev1 = explode(' ', $dateToday);
        $splitFolder1 = explode('-', $splitDatev1[0]);
        $randomizer = str_random(12);

        $getInfo = DB::table('bi_ci_report')
            ->where('id', $id)
            ->get();

//        return implode('<br>', explode('\n', json_encode($getInfo[0]->ci_note)));

        if(count($getInfo) > 0)
        {
            $files = storage_path('ci_bi_report/' . $getInfo[0]->ci_id . '/' . $getInfo[0]->id);

            if(File::exists($files))
            {
                $filee = 'report-' . implode($splitFolder1) . '-' . $getInfo[0]->ci_id . '-' . $getInfo[0]->id .'.txt';
                $data = implode("\r\n", explode('<br>', nl2br($getInfo[0]->ci_note, false)));


                if(File::exists(storage_path('ci_bi_report/' . $getInfo[0]->ci_id . '/' . $getInfo[0]->id. '/'. $filee)))
                {
                    File::delete(storage_path('ci_bi_report/' . $getInfo[0]->ci_id . '/' . $getInfo[0]->id. '/'. $filee));
                }
                File::put(storage_path('ci_bi_report/' . $getInfo[0]->ci_id . '/' . $getInfo[0]->id. '/'. $filee), $data);

                $file_count = glob("$files/*");

                for($i = 0; $i < count($file_count); $i++)
                {
                    $downloadThis = $zipper->make(storage_path('ci_bi_report/' . $getInfo[0]->ci_id . '/' . $getInfo[0]->id . '/' . $randomizer . '-' .implode($splitFolder1) . '-' . $getInfo[0]->ci_id . '-' . $getInfo[0]->id . '.zip'))
                        ->add($file_count[$i])
                        ->getFilePath();
                }
                $zipper->close();

                DB::table('bi_ci_report_logs')
                    ->insert([
                        'user_id' => Auth::user()->id,
                        'bi_report_id' => $id,
                        'activity' => 'DOWNLOADED THE ATTACHMENT/S',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                return response()->download($downloadThis)->deleteFileAfterSend();
            }
            else
            {
                echo'<script>alert(\'File not found\'); window.close();</script>';
            }
        }
        else
        {
            echo'<script>alert(\'File not found\'); window.close();</script>';
        }
    }
    else
    {
        abort(404);
    }

});

Route::get('gen_productivity_table',
    [
        'uses' => 'GeneralController@gen_productivity_table',
        'as' => 'gen_productivity_table',
        'role' => 'General'
    ]);

Route::get('gen_productivity_table',
    [
        'uses' => 'GeneralController@gen_productivity_table',
        'as' => 'gen_productivity_table',
        'role' => 'General'
    ]);

Route::get('gen_check_user_productivity',
    [
        'uses' => 'GeneralController@gen_check_user_productivity',
        'as' => 'gen_productivity_table',
        'role' => 'General'
    ]);

Route::get('gen_productivity_table_cc',
    [
        'uses' => 'GeneralController@gen_productivity_table_cc',
        'as' => 'gen_productivity_table_cc',
        'role' => 'General'
    ]);

Route::get('gen_accts_under_emp_date_table',
    [
        'uses' => 'GeneralController@gen_accts_under_emp_date_table',
        'as' => 'gen_accts_under_emp_date_table',
        'role' => 'General'
    ]);

Route::get('gen_accts_under_emp_date_table_cc',
    [
        'uses' => 'GeneralController@gen_accts_under_emp_date_table_cc',
        'as' => 'gen_accts_under_emp_date_table_cc',
        'role' => 'General'
    ]);
    
Route::get('gen_attendance_in_out_check',
    [
        'uses' => 'GeneralController@gen_attendance_in_out_check',
        'as' => 'gen_attendance_in_out_check',
        'role' => 'General'
    ]);

Route::get('gen_emp_time_in_and_time_out',
    [
        'uses' => 'GeneralController@gen_emp_time_in_and_time_out',
        'as' => 'gen_emp_time_in_and_time_out',
        'role' => 'General'
    ]);

Route::get('gen_save_daily_work_sched',
    [
        'uses' => 'GeneralController@gen_save_daily_work_sched',
        'as' => 'gen_save_daily_work_sched',
        'role' => 'General'
    ]);
    
Route::get('/{name_of_client}/applications',
    [
        'uses' => 'GeneralController@client_applicant_processing_checker',
        'as' => 'client_applicant_processing_checker',
        'role' => 'General'
    ]);

Route::get('/{name_of_client}/fetch-city-muni',
    [
        'uses' => 'GeneralController@fetchCityMuni',
        'as' => 'fetch-city-muni'
    ]);

Route::get('/{name_of_client}/fetch-city-muniv2',
    [
        'uses' => 'GeneralController@fetchCityMuniv2',
        'as' => 'fetch-city-muni'
    ]);


Route::get('/{name_of_client}/fetch-prov',
    [
        'uses' => 'GeneralController@fetchProvince2',
        'as' => 'fetch-prov'
    ]);    
    
Route::get('/fetch-admin-sendAcno',
    [
        'uses' => 'GeneralController@admin_sendAcno',
        'as' => 'fetch-admin-sendAcno',
        'role'  => 'General'
    ]);

Route::get('/fetch-admin-viewAcknow',
    [
        'uses' => 'GeneralController@admin_viewAcknow',
        'as' => 'fetch-admin-viewAcknow',
        'role' => 'General'
    ]);

Route::get('/acknowledge-form-status',
    [
        'uses' => 'GeneralController@acknowledge_form_status',
        'as' => 'acknowledge-form-status',
        'role' => 'General'
    ]);

    // Route::get('/test_mailer',
    // [
    //     'uses' => 'GeneralController@test_mailer',
    //     'as' => 'test_mailer',
    //     'role' => 'General'
    // ]);
    
Route::get('get_management_saveTime',
    [
        'uses' => 'GeneralController@get_management_saveTime',
        'as' => 'get_management_saveTime',
        'role' => 'General'
    ]);

Route::get('get_user_archipelago',
    [
        'uses' => 'GeneralController@get_user_archipelago',
        'as' => 'get_user_archipelago',
        'role' => 'General'
    ]);

Route::get('users_management_view_logs',
    [
        'uses' => 'GeneralController@users_management_view_logs',
        'as' => 'users_management_view_logs',
        'role' => 'General'
    ]);


//===================================DISPATCHERS ACCESS ROUTE==========================================================



Route::get('/dispatcher-dispatch-account',
    [
        'uses' => 'DispatcherController@getDispatcherDispatchAccount',
        'as' => 'dispatcher-dispatch-account',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-dashboard',
    [
        'uses' => 'DispatcherController@getDispatcherDashboard',
        'as' => 'dispatcher-dashboard',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-panel',
    [
        'uses' => 'DispatcherController@getDispatcherPanel',
        'as' => 'dispatcher-panel',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-endorsement',
    [
        'uses' => 'DispatcherController@getDispatcherEndorsement',
        'as' => 'dispatcher-endorsement',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-ci-management',
    [
        'uses' => 'DispatcherController@getDispatcherCiManagement',
        'as' => 'dispatcher-ci-management',
        'role' => 'Dispatcher'
    ]);

Route::post('/ci-dispatch',
    [
        'uses' => 'DispatcherController@dispatchToCI',
        'as' => 'ci-dispatch',
        'role' => 'Dispatcher'
    ]);

Route::get('/fetch-endorsement',
    [
        'uses' => 'DispatcherController@tableViewManipulation',
        'as' => 'fetch-endorsement',
        'role' => 'Dispatcher'
    ]);


Route::get('/dispatcher-ci-list-account',
    [
        'uses' => 'DispatcherController@ciListAccount',
        'as' => 'dispatcher-ci-list-account',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-ci-transfer',
    [
        'uses' => 'DispatcherController@ciTransfer',
        'as' => 'dispatcher-ci-transfer',
        'role' => 'Dispatcher'
    ]);

Route::get('/fetch-cilistaccount',
    [
        'uses' => 'DispatcherController@getCiListAccount',
        'as' => 'fetch-cilistaccount',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-generate-report',
    [
        'uses' => 'DispatcherController@getGenerateReport',
        'as' => 'dispatcher-generate-report',
        'role' => 'Dispatcher'
    ]);


Route::post('/dispatcher-remove-account',
    [
        'uses' => 'DispatcherController@removeAccount',
        'as' => 'dispatcher-remove-account',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-other-info',
    [
        'uses' => 'DispatcherController@getOtherInfo',
        'as' => 'dispatcher-get-other-info',
        'role' => 'Credit Dispatcher'
    ]);

Route::get('/dispatcher-get-time-due',
    [
        'uses' => 'DispatcherController@getTimeDue',
        'as' => 'dispatcher-get-time-due',
        'role' => 'Credit Dispatcher'
    ]);

Route::get('/dispatcher-update-get-time-due',
    [
        'uses' => 'DispatcherController@UpdateGetTimeDue',
        'as' => 'dispatcher-update-get-time-due',
        'role' => 'Credit Dispatcher'
    ]);

Route::get('/dispatcher-fund-request',
    [
        'uses' => 'DispatcherController@getFundRequest',
        'as' => 'dispatcher-fund-request',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-fund-request-table',
    [
        'uses' => 'DispatcherController@getTableFundRequest',
        'as' => 'dispatcher-get-fund-request-table',
        'role' => 'Dispatcher'
    ]);

Route::post('/dispatcher-send-request-fund',
    [
        'uses' => 'DispatcherController@sendFund',
        'as' => 'dispatcher-send-request-fund',
        'role' => 'Dispatcher'
    ]);

Route::post('/dispatcher-cancel-fund',
    [
        'uses' => 'DispatcherController@cancelFund',
        'as' => 'dispatcher-cancel-fund',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-table-fund-success',
    [
        'uses' => 'DispatcherController@getTableFundSuccess',
        'as' => 'dispatcher-table-fund-success',
        'role' => 'Dispatcher'
    ]);
    
Route::get('/dispatcher-table-fund-history',
    [
        'uses' => 'DispatcherController@getTableFundHistory',
        'as' => 'dispatcher-table-fund-history',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-fund-disapproved-table',
    [
        'uses' => 'DispatcherController@getTableFundDisapproved',
        'as' => 'dispatcher-get-fund-disapproved-table',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-fund-cancelled-table',
    [
        'uses' => 'DispatcherController@getTableFundCancelled',
        'as' => 'dispatcher-get-fund-cancelled-table',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-fund-checker-table',
    [
        'uses' => 'DispatcherController@getTableFundChecker',
        'as' => 'dispatcher-get-fund-checker-table',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-get-realtime-fund-ci',
    [
        'uses' => 'DispatcherController@dispatcher_get_realtime_fund_ci',
        'as' => 'dispatcher-get-realtime-fund-ci',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher-ci-check-endorsement-process-fund-request',
    [
        'uses' => 'DispatcherController@dispatcher_ci_check_endorsement_process_fund_request',
        'as' => 'dispatcher-ci-check-endorsement-process-fund-request',
        'role' => 'Dispatcher'
    ]);

Route::get('/dispatcher_get_real_time_and_pending',
    [
        'uses' => 'DispatcherController@dispatcher_get_real_time_and_pending',
        'as' => 'dispatcher_get_real_time_and_pending',
        'role' => 'Dispatcher'
    ]);

Route::get('/pending_fund_details_endorsements/',
    [
        'uses' => 'DispatcherController@pending_fund_details_endorsements',
        'as' => 'pending_fund_details_endorsements',
        'role' => 'Dispatcher'
    ]);

Route::get('/pending_success_details_endorsements/',
    [
        'uses' => 'DispatcherController@pending_success_details_endorsements',
        'as' => 'pending_success_details_endorsements',
        'role' => 'Dispatcher'
    ]);

Route::get('/pending_disapproved_details_endorsements/',
    [
        'uses' => 'DispatcherController@pending_disapproved_details_endorsements',
        'as' => 'pending_disapproved_details_endorsements',
        'role' => 'Dispatcher'
    ]);

Route::get('/pending_cancel_details_endorsements/',
    [
        'uses' => 'DispatcherController@pending_cancel_details_endorsements',
        'as' => 'pending_cancel_details_endorsements',
        'role' => 'Dispatcher'
    ]);

Route::post('/dispatcher-send-request-add-fund',
    [
        'uses' => 'DispatcherController@dispatcher_send_request_add_fund',
        'as' => 'dispatcher-send-request-add-fund',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher-fund-general-logs',
    [
        'uses' => 'DispatcherController@dispatcher_fund_general_logs',
        'as' => 'dispatcher-fund-general-logs',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher_get_ci_contact_number_to_text',
    [
        'uses' => 'DispatcherController@dispatcher_get_ci_contact_number_to_text',
        'as' => 'dispatcher_get_ci_contact_number_to_text',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher_send_message_to_ci',
    [
        'uses' => 'DispatcherController@dispatcher_send_message_to_ci',
        'as' => 'dispatcher_send_message_to_ci',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher_get_messages_logs',
    [
        'uses' => 'DispatcherController@dispatcher_get_messages_logs',
        'as' => 'dispatcher_get_messages_logs',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher_resend_failed_message',
    [
        'uses' => 'DispatcherController@dispatcher_resend_failed_message',
        'as' => 'dispatcher_get_messages_logs',
        'role' => 'Dispatcher'
    ]);

Route::get('dispatcher_update_ci_contact_number',
    [
        'uses' => 'DispatcherController@dispatcher_update_ci_contact_number',
        'as' => 'dispatcher_update_ci_contact_number',
        'role' => 'Dispatcher'
    ]);

//=====================================ACCOUNT OFFICER ACCESS ROUTE=====================================================

Route::get('/ao-account-process',
    [
        'uses' => 'AccountOfficerController@getAoAccountProcess',
        'as' => 'ao-account-process',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-panel',
    [
        'uses' => 'AccountOfficerController@getAOpanel',
        'as' => 'ao-panel',
        'role' => 'Account Officer'
    ]);


Route::get('/ao-dashboard',
    [
        'uses' => 'AccountOfficerController@getAoDashboard',
        'as' => 'ao-dashboard',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-endorsement',
    [
        'uses' => 'AccountOfficerController@getAoEndorsement',
        'as' => 'ao-endorsement',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-fetch-endorsement',
    [
        'uses' => 'AccountOfficerController@getAoNewEndorsement',
        'as' => 'ao-fetch-endorsement',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-download-file',
    [
        'uses' => 'AccountOfficerController@downloadFile',
        'as' => 'ao-download-file',
        'role' => 'Account Officer'
    ]);

Route::post('/ao-update-info',
    [
        'uses' => 'AccountOfficerController@accountUpdateInfo',
        'as' => 'ao-update-info',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-view-info',
    [
        'uses' => 'AccountOfficerController@viewFullInfo',
        'as' => 'ao-view-info',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-get-address',
    [
        'uses' => 'AccountOfficerController@getAddress',
        'as' => 'ao-get-address',
        'role' => 'Account Officer'
    ]);

Route::post('/uploadReportFile',
    [
        'uses' => 'AccountOfficerController@uploadReportFile',
        'as' => 'uploadReportFile',
        'role' => 'Account Officer'
    ]);

Route::get('/ao-finish-report-table',
    [
        'uses' => 'AccountOfficerController@getAoFinishEndorsement',
        'as' => 'ao-finish-report-table',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_send_email_report_to_client',
    [
        'uses' => 'AccountOfficerController@ao_send_email_report_to_client',
        'as' => 'ao_send_email_report_to_client',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_save_recipient_list',
    [
        'uses' => 'AccountOfficerController@ao_save_recipient_list',
        'as' => 'ao_save_recipient_list',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_get_recip_list_table',
    [
        'uses' => 'AccountOfficerController@ao_get_recip_list_table',
        'as' => 'ao_get_recip_list_table',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_delete_recip_list',
    [
        'uses' => 'AccountOfficerController@ao_delete_recip_list',
        'as' => 'ao_delete_recip_list',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_view_recip_list',
    [
        'uses' => 'AccountOfficerController@ao_view_recip_list',
        'as' => 'ao_view_recip_list',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_update_recip_list',
    [
        'uses' => 'AccountOfficerController@ao_update_recip_list',
        'as' => 'ao_update_recip_list',
        'role' => 'Account Officer'
    ]);

Route::get('/ao_trigger_to_get_list_recipients',
    [
        'uses' => 'AccountOfficerController@ao_trigger_to_get_list_recipients',
        'as' => 'ao_trigger_to_get_list_recipients',
        'role' => 'Account Officer'
    ]);

//==============================================CLIENT ACCESS ROUTE=====================================================

Route::get('/client-dashboard',
    [
        'uses' => 'ClientController@getClientDashboard',
        'as' => 'client-dashboard',
        'role' => 'Client'
    ]);

Route::get('/client-panel',
    [
        'uses' => 'ClientController@getClientPanel',
        'as' => 'client-panel',
        'role' => 'Client'
    ]);

Route::get('/client-endorse-account',
    [
        'uses' => 'ClientController@getEndorseAccount',
        'as' => 'client-endorse-account',
        'role' => 'Client'
    ]);

Route::post('/add-endorsement',
    [
        'uses' => 'ClientController@addEndorsement',
        'as' => 'add-endorsement',
        'role' => 'Client'
    ]);

Route::post('/add-endorsement-bvr',
    [
        'uses' => 'ClientController@addEndorsementBvr',
        'as' => 'add-endorsement-bvr',
        'role' => 'Client'
    ]);

Route::post('/add-endorsement-evr',
    [
        'uses' => 'ClientController@addEndorsementEvr',
        'as' => 'add-endorsement-evr',
        'role' => 'Client'
    ]);

Route::get('/get-list-province',
    [
        'uses' => 'ClientController@getListProvince',
        'as' => 'aget-list-province',
        'role' => 'Client'
    ]);

Route::get('/check-double-endorse',
    [
        'uses' => 'ClientController@doubleEndorseChecker',
        'as' => 'check-double-endorse',
        'role' => 'Client'
    ]);

Route::get('/get-history-account',
    [
        'uses' => 'ClientController@getHistory',
        'as' => 'get-history-account',
        'role' => 'Client'
    ]);

Route::get('/client-history-endorsement',
    [
        'uses' => 'ClientController@getHistoryEndorsement',
        'as' => 'client-history-endorsement',
        'role' => 'Client'
    ]);

Route::post('/client-save-note',
    [
        'uses' => 'ClientController@saveNote',
        'as' => 'client-save-note',
        'role' => 'Client'
    ]);

Route::post('/client-update-note',
    [
        'uses' => 'ClientController@updateNote',
        'as' => 'client-update-note',
        'role' => 'Client'
    ]);

Route::get('/client-get-note',
    [
        'uses' => 'ClientController@getNote',
        'as' => 'client-get-note',
        'role' => 'Client'
    ]);

Route::get('/client-get-finish-account',
    [
        'uses' => 'ClientController@getFinishAccount',
        'as' => 'client-get-finish-account',
        'role' => 'Client'
    ]);

Route::get('/client-audit-download-report',
    [
        'uses' => 'ClientController@auditDownloadReport',
        'as' => 'client-audit-download-report',
        'role' => 'Client'
    ]);

Route::get('/client_audit_download_report_revision',
    [
        'uses' => 'ClientController@client_audit_download_report_revision',
        'as' => 'client_audit_download_report_revision',
        'role' => 'Client'
    ]);

Route::get('/client-get-hold-account',
    [
        'uses' => 'ClientController@getHoldAccount',
        'as' => 'client-get-hold-account',
        'role' => 'Client'
    ]);

Route::get('/client-get-cancel-account',
    [
        'uses' => 'ClientController@getCancelAccount',
        'as' => 'client-get-cancel-account',
        'role' => 'Client'
    ]);

Route::get('/client-get-revised-account',
    [
        'uses' => 'ClientController@getRevisedAccount',
        'as' => 'client-get-revised-account',
        'role' => 'Client'
    ]);


Route::get('/client-check-requestor-user',
    [
        'uses' => 'ClientController@RequestorChecker',
        'as' => 'client-check-requestor-user',
        'role' => 'Client'
    ]);

Route::post('/client-upload-bulk-excel',
    [
        'uses' => 'ClientController@client_upload_bulk_excel',
        'as' => 'client-upload-bulk-excel',
        'role' => 'Client'
    ]);

Route::post('/client-bulk-endorsement-submit',
    [
        'uses' => 'ClientController@client_bulk_endorsement_submit',
        'as' => 'client-bulk-endorsement-submit',
        'role' => 'Client'
    ]);

Route::get('/client-dl-bulk-template',
    [
        'uses' => 'ClientController@client_dl_bulk_template',
        'as' => 'client-dl-bulk-template',
        'role' => 'Client'
    ]);

Route::get('client-view-file', function(Request $request)
{
    if(Auth::user() != null)
    {
        $ses = Session();
        $user = User::find(Auth::user()->id);
        $role = $user->roles->first()->name;
        $endorse_id = base64_decode($request->id);
        $path = '';
        $file_name_array = [];
        $file_name_array_final = [];
        $ctr2 = 0;
        $file = '';
        $type ='';

        if($role == 'Client')
        {
            $get_path = DB::table('endorsements')
                ->where('id', $endorse_id)
                ->select('link_path', 'account_name', 'client_status')
                ->get();

            if(count($get_path) > 0)
            {
                $zipper = new Zipper();
                $directory = storage_path('account_report/'. $get_path[0]->link_path.'.zip');
                $logFiles = $zipper->zip($directory)->listFiles();
                $files_show = '';

                for($i = 0; $i < count($logFiles); $i++)
                {
                    $explode_handler = explode('.', $logFiles[$i]);

                    if($explode_handler[1] == 'pdf')
                    {
                        $files_show = $zipper->zip($directory)->getFileContent($logFiles[$i]);
                        break;
                    }
                }

                if($files_show != '')
                {
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

                    if($get_path[0]->client_status != 'Downloaded')
                    {
                        DB::table('endorsements')
                            ->where('id', $endorse_id)
                            ->update([
                                'client_status' => 'Read'
                            ]);
                    }

                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $endorse_id,
                                'name' => strtoupper(Auth::user()->name),
                                'position' => strtoupper($ses->get('role')),
                                'branch' => strtoupper($ses->get('userBranch')),
                                'activities' => strtoupper('Viewed Report of '. $get_path[0]->account_name),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    $response = Response::make($files_show, 200);
                    $response->header("Content-Type", $type);
                    return $response;
                }
                else
                {
                    if(File::exists($directory))
                    {
                        echo'<script>alert(\'No preview available, download to view the file.\'); window.close();</script>';
                    }
                    else
                    {
                        echo'<script>alert(\'No report available.\'); window.close();</script>';
                    }
                }

            }
            else
            {
                echo'<script>alert(\'No report available.\'); window.close();</script>';
            }
        }
        else
        {
            abort(404);
        }
    }
    else
    {
        abort(404);
    }
});

Route::get('client-get-finish-account-read',
    [
        'uses'=> 'ClientController@client_get_finish_account_read',
        'as' => 'client_get_finish_account_read',
        'role' => 'Client'
    ]);

Route::get('client-get-finish-account-downloaded',
    [
        'uses'=> 'ClientController@client_get_finish_account_downloaded',
        'as' => 'client_get_finish_account_downloaded',
        'role' => 'Client'
    ]);

Route::post('client-bulk-check-double-endorse',
    [
        'uses'=> 'ClientController@client_bulk_check_double_endorse',
        'as' => 'client-bulk-check-double-endorse',
        'role' => 'Client'
    ]);

Route::post('client_endorsement_edit_route_test',
    [
        'uses'=> 'ClientController@client_endorsement_edit_route_test',
        'as' => 'client_endorsement_edit_route_test',
        'role' => 'Client'
    ]);

Route::post('client_submit_endorsement_edit_details',
    [
        'uses'=> 'ClientController@client_submit_endorsement_edit_details',
        'as' => 'client_submit_endorsement_edit_details',
        'role' => 'Client'
    ]);


//==============================================ADMINISTRATOR ROUTE=====================================================


Route::get('/admin-dashboard',
    [
        'uses' => 'AdminController@getAdminDashboard',
        'as' => 'admin-dashboard',
        'role' => 'Administrator'
    ]);


Route::get('/admin-user-management',
    [
        'uses' => 'AdminController@getUserManagement',
        'as' => 'admin-user-management',
        'role' => 'Administrator'
    ]);

Route::get('/admin-form-management',
    [
        'uses' => 'AdminController@getFormManagement',
        'as' => 'admin-form-management',
        'role' => 'Administrator'
    ]);

Route::get('/ci_contact_list_checker',
    [
        'uses' => 'AdminController@getCiInterface',
        'as' => 'ci_contact_list_checker',
        'role' => 'Administrator'
    ]);

Route::get('/admin-ci-number-table',
    [
        'uses' => 'AdminController@admin_ci_number_table',
        'as' => 'admin-ci-number-table',
        'role' => 'Administrator'
    ]);

Route::post('/add-user',
    [
        'uses' => 'AdminController@addUser',
        'as' => 'add-user',
        'role' => 'Administrator'
    ]);

Route::post('/update-user',
    [
        'uses' => 'AdminController@updateUser',
        'as' => 'update-user',
        'role' => 'Administrator'
    ]);

Route::get('/fetch-form-template',
    [
        'uses' => 'AdminController@getListForm',
        'as' => 'fetch-form-template',
        'role' => 'Administrator'
    ]);

Route::get('/admin-check-emp-id',
    [
        'uses' => 'AdminController@checkingEmpID',
        'as' => 'admin-check-emp-id',
        'role' => 'Administrator'
    ]);

Route::get('/admin-readloan',
    [
        'uses' => 'AdminController@ReadLoan',
        'as' => 'admin-readloan',
        'role' => 'Administrator'
    ]);

Route::get('/admin-addloan',
    [
        'uses' => 'AdminController@AddLoan',
        'as' => 'admin-addloan',
        'role' => 'Administrator'
    ]);

Route::get('/admin-deleteloan',
    [
        'uses' => 'AdminController@DeleteLoan',
        'as' => 'admin-deleteloan',
        'role' => 'Administrator'
    ]);

Route::get('/admin-gettickets',
    [
        'uses' => 'AdminController@GetTickets',
        'as' => 'admin-gettickets',
        'role' => 'Administrator'
    ]);

Route::get('/admin-get-user-manager',
    [
        'uses' => 'AdminController@getUsersListManager',
        'as' => 'admin-get-user-manager',
        'role' => 'Administrator'
    ]);

Route::get('/admin-disable-user',
    [
        'uses' => 'AdminController@archiveMode',
        'as' => 'admin-disable-user',
        'role' => 'Administrator'
    ]);

Route::get('/admin-enable-user',
    [
        'uses' => 'AdminController@archiveModeOff',
        'as' => 'admin-enable-user',
        'role' => 'Administrator'
    ]);

Route::get('/admin-account-management',
    [
        'uses' => 'AdminController@getAccountManagement',
        'as' => 'admin-account-management',
        'role' => 'Administrator'
    ]);
    
Route::get('/admin-users-table-manage',
[
    'uses' => 'AdminController@fetchUsersAccountManage',
    'as' => 'admin-users-table-manage',
    'role' => 'Administrator'
]);

Route::get('/admin-bank-table-manage',
    [
        'uses' => 'AdminController@fetchBankAccountManage',
        'as' => 'admin-bank-table-manage',
        'role' => 'Administrator'
    ]);

Route::get('/admin-bi-table-manage',
    [
        'uses' => 'AdminController@fetchBIAccountManage',
        'as' => 'admin-bi-table-manage',
        'role' => 'Administrator'
    ]);
    
Route::get('/file-manager',
[
    'uses' => 'AdminController@getFileManager',
    'as' => 'file-manager',
    'role' => 'Administrator'
]);

Route::get('del-cont',
    [
       'uses' => 'AdminController@del_cont',
       'as' => 'del-cont',
        'role' => 'Administrator'
    ]);

Route::get('/admin-account-table-list',
    [
        'uses' => 'AdminController@fetchDetachAccount',
        'as' => 'admin-account-table-list',
        'role' => 'Administrator'
    ]);

Route::post('/admin-remove-account',
    [
        'uses' => 'AdminController@removeAccount',
        'as' => 'admin-remove-account',
        'role' => 'Administrator'
    ]);
    
Route::get('/admin-bi-account-list',
    [
        'uses' => 'AdminController@fetchBIAccounts',
        'as' => 'admin-bi-account-list',
        'role' => 'Administrator'
    ]);

Route::get('/admin_edit_bi_time_due',
    [
        'uses' => 'AdminController@admin_edit_bi_time_due',
        'as' => 'admin_edit_bi_time_due',
        'role' => 'Administrator'
    ]);

Route::get('/admin_bi_hide_acct',
    [
        'uses' => 'AdminController@admin_bi_hide_acct',
        'as' => 'admin_bi_hide_acct',
        'role' => 'Administrator'
    ]);

Route::get('/admin-data-management',
    [
        'uses' => 'AdminController@getDataManagement',
        'as' => 'admin-data-management',
        'role' => 'Administrator'
    ]);

Route::get('/admin-get-data-audit-trail',
    [
        'uses' => 'AdminController@getDataTrail',
        'as' => 'admin-get-data-audit-trail',
        'role' => 'Administrator'
    ]);

Route::get('/admin-get-ci-contact',
    [
        'uses' => 'AdminController@getCiContact',
        'as' => 'admin-get-ci-contact',
        'role' => 'Administrator'
    ]);

Route::get('/admin-update-ci-contact',
    [
        'uses' => 'AdminController@updateCiContact',
        'as' => 'admin-update-ci-contact',
        'role' => 'Administrator'
    ]);

Route::get('/admin-delete-ci-contact',
    [
        'uses' => 'AdminController@deleteCiContact',
        'as' => 'admin-delete-ci-contact',
        'role' => 'Administrator'
    ]);

Route::get('/admin-delete-all-endorse-test',
    [
        'uses' => 'AdminController@deleteAllEndorsements',
        'as' => 'admin-delete-all-endorse-test',
        'role' => 'Administrator'
    ]);

Route::post('/admin-cert-ci',
    [
        'uses' => 'AdminController@enableCert',
        'as' => 'admin-cert-ci',
        'role' => 'Administrator'
    ]);

Route::post('/admin-dis-cert-ci',
    [
        'uses' => 'AdminController@disableCert',
        'as' => 'admin-dis-cert-ci',
        'role' => 'Administrator'
    ]);

Route::get('/back-up-file',
    [
        'uses' => 'AdminController@backUpFile',
        'as' => 'back-up-file'
    ]);

Route::get('/admin-get-email-selection',
    [
        'uses' => 'AdminController@GetEmailSelection',
        'as' => 'admin-get-email-selection',
        'role' => 'Administrator'
    ]);

Route::get('/admin-apply-emails',
    [
        'uses' => 'AdminController@ApplyEmails',
        'as' => 'admin-apply-emails',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_client_notif_emails_for_dispatcher',
    [
        'uses' => 'AdminController@admin_get_client_notif_emails_for_dispatcher',
        'as' => 'admin_get_client_notif_emails_for_dispatcher',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_client_notif_emails_for_sao',
    [
        'uses' => 'AdminController@admin_get_client_notif_emails_for_sao',
        'as' => 'admin_get_client_notif_emails_for_sao',
        'role' => 'Administrator'
    ]);

Route::get('/admin_remove_client_notif_emails_for_dispatcher',
    [
        'uses' => 'AdminController@admin_remove_client_notif_emails_for_dispatcher',
        'as' => 'admin_remove_client_notif_emails_for_dispatcher',
        'role' => 'Administrator'
    ]);

Route::get('/admin_remove_client_notif_emails_for_sao',
    [
        'uses' => 'AdminController@admin_remove_client_notif_emails_for_sao',
        'as' => 'admin_remove_client_notif_emails_for_sao',
        'role' => 'Administrator'
    ]);

Route::get('/admin_remove_client_notif_emails_for_sao_and_disp',
    [
        'uses' => 'AdminController@admin_remove_client_notif_emails_for_sao_and_disp',
        'as' => 'admin_remove_client_notif_emails_for_sao_and_disp',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_assign_transfer_for_sao',
    [
        'uses' => 'AdminController@admin_get_assign_transfer_for_sao',
        'as' => 'admin_get_assign_transfer_for_sao',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_assign_transfer_for_ao',
    [
        'uses' => 'AdminController@admin_get_assign_transfer_for_ao',
        'as' => 'admin_get_assign_transfer_for_ao',
        'role' => 'Administrator'
    ]);

Route::get('/admin_remove_assign_transfer_all',
    [
        'uses' => 'AdminController@admin_remove_assign_transfer_all',
        'as' => 'admin_remove_assign_transfer_all',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_dispatch_transfer_for_dispatcher',
    [
        'uses' => 'AdminController@admin_get_dispatch_transfer_for_dispatcher',
        'as' => 'admin_get_dispatch_transfer_for_dispatcher',
        'role' => 'Administrator'
    ]);

Route::get('/admin_get_dispatch_transfer_for_ci',
    [
        'uses' => 'AdminController@admin_get_dispatch_transfer_for_ci',
        'as' => 'admin_get_dispatch_transfer_for_ci',
        'role' => 'Administrator'
    ]);

Route::get('/admin_remove_dispatcher_transfer_all',
    [
        'uses' => 'AdminController@admin_remove_dispatcher_transfer_all',
        'as' => 'admin_remove_dispatcher_transfer_all',
        'role' => 'Administrator'
    ]);

Route::get('/admin-email-getter',
    [
        'uses' => 'AdminController@EmailGetter',
        'as' => 'admin-email-getter',
        'role' => 'Administrator'
    ]);

Route::get('/admin-email-remove-select',
    [
        'uses' => 'AdminController@EmailRemoveSelect',
        'as' => 'admin-email-remove-select',
        'role' => 'Administrator'
    ]);

Route::post('/admin-uploadForm',
    [
        'uses' => 'AdminController@uploadForm',
        'as' => 'admin-uploadForm',
        'role' => 'Administrator'
    ]);

Route::get('/admin-down-web',
    [
        'uses' => 'AdminController@downWebApp',
        'as' => 'admin-down-web',
        'role' => 'Administrator'
    ]);

Route::get('/admin-get-web-status',
    [
        'uses' => 'AdminController@getWebStatus',
        'as' => 'admin-get-web-status',
        'role' => 'Administrator'
    ]);

Route::get('/admin-delete-downloadableforms/{id}', function (Request $request, $id) {
    File::delete(glob(storage_path('DownloadableForms/' . $id)));

    return response()->json('success');
});

Route::get('admin-table-archive-accounts',
    [
        'uses' => 'AdminController@getTableArchive',
        'as' => 'admin-table-archive-accounts',
        'role' => 'Administrator'
    ]);

Route::get('admin-table-blocked-accounts',
    [
        'uses' => 'AdminController@getTableBlocked',
        'as' => 'admin-table-blocked-accounts',
        'role' => 'Administrator'
    ]);

Route::post('admin-delete-blocked-acct',
    [
        'uses' => 'AdminController@unblockedAccounts',
        'as' => 'admin-delete-blocked-acct',
        'role' => 'Administrator'
    ]);

Route::post('admin_register_bi_account',
    [
        'uses' => 'AdminController@admin_register_bi_account',
        'as' => 'admin_register_bi_account',
        'role' => 'Administrator'
    ]);

Route::post('admin_select_bi_to_user',
    [
        'uses' => 'AdminController@admin_select_bi_to_user',
        'as' => 'admin_select_bi_to_user',
        'role' => 'Administrator'
    ]);

Route::get('admin_edit_get_select_bi_account',
    [
        'uses' => 'AdminController@admin_edit_get_select_bi_account',
        'as' => 'admin_edit_get_select_bi_account',
        'role' => 'Administrator'
    ]);

Route::get('admin_select_bi_change',
    [
        'uses' => 'AdminController@admin_select_bi_change',
        'as' => 'admin_select_bi_change',
        'role' => 'Administrator'
    ]);

Route::post('admin_check_bday_notification_email',
    [
        'uses' => 'AdminController@admin_check_bday_notification_email',
        'as' => 'admin_check_bday_notification_email',
        'role' => 'Administrator'
    ]);

Route::post('admin_check_contract_notification_email',
    [
        'uses' => 'AdminController@admin_check_contract_notification_email',
        'as' => 'admin_check_contract_notification_email',
        'role' => 'Administrator'
    ]);

Route::get('admin_bday_send_email_notif',
    [
        'uses' => 'AdminController@admin_bday_send_email_notif',
        'as' => 'admin_bday_send_email_notif',
        'role' => 'Administrator'
    ]);

Route::get('admin_contract_send_email_notif',
    [
        'uses' => 'AdminController@admin_contract_send_email_notif',
        'as' => 'admin_contract_send_email_notif',
        'role' => 'Administrator'
    ]);

Route::get('admin_bday_and_contract_validate',
    [
        'uses' => 'AdminController@admin_bday_and_contract_validate',
        'as' => 'admin_bday_and_contract_validate',
        'role' => 'Administrator'
    ]);
Route::get('admin-get-all-bi-client',
    [
        'uses' => 'AdminController@admin_get_all_bi_client',
        'as' => 'admin-get-all-bi-client',
        'role' => 'Administrator'
    ]);
Route::post('admin-get-check-bi',
    [
        'uses' => 'AdminController@admin_get_check_bi',
        'as' => 'admin-get-check-bi',
        'role' => 'Administrator'
    ]);
Route::get('admin-get-checkings-data',
    [
        'uses' => 'AdminController@admin_get_checkings_data',
        'as' => 'admin-get-checkings-data',
        'role' => 'Administrator'
    ]);
Route::post('admin-add-upon-checkings',
    [
        'uses' => 'AdminController@admin_add_upon_checkings',
        'as' => 'admin-add-upon-checkings',
        'role' => 'Administrator'
    ]);
Route::post('admin-add-during-checkings',
    [
        'uses' => 'AdminController@admin_add_during_checkings',
        'as' => 'admin-add-during-checkings',
        'role' => 'Administrator'
    ]);

Route::post('admin-add-after-checkings',
    [
        'uses' => 'AdminController@admin_add_after_checkings',
        'as' => 'admin-add-after-checkings',
        'role' => 'Administrator'
    ]);

Route::get('admin-get-all-upon-checks',
    [
        'uses' => 'AdminController@admin_get_all_upon_checks',
        'as' => 'admin-get-all-upon-checks',
        'role' => 'Administrator'
    ]);

Route::get('admin-get-all-during-checks',
    [
        'uses' => 'AdminController@admin_get_all_during_checks',
        'as' => 'admin-get-all-during-checks',
        'role' => 'Administrator'
    ]);

Route::get('admin-get-all-after-checks',
    [
        'uses' => 'AdminController@admin_get_all_after_checks',
        'as' => 'admin-get-all-after-checks',
        'role' => 'Administrator'
    ]);

Route::post('admin-edit-upon-checkings',
    [
        'uses' => 'AdminController@admin_edit_upon_checkings',
        'as' => 'admin-edit-upon-checkings',
        'role' => 'Administrator'
    ]);

Route::post('admin-edit-after-checkings',
    [
        'uses' => 'AdminController@admin_edit_after_checkings',
        'as' => 'admin-edit-after-checkings',
        'role' => 'Administrator'
    ]);

Route::get('get_ip_address_data_table',
    [
        'uses' => 'AdminController@get_ip_address_data_table',
        'as' => 'get_ip_address_data_table',
        'role' => 'Administrator'
    ]);

Route::get('get_user_access_login_data_table',
    [
        'uses' => 'AdminController@get_user_access_login_data_table',
        'as' => 'get_user_access_login_data_table',
        'role' => 'Administrator'
    ]);

Route::get('ip_address_access',
    [
        'uses' => 'AdminController@ip_address_access',
        'as' => 'ip_address_access',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_ip_access',
    [
        'uses' => 'AdminController@admin_add_ip_access',
        'as' => 'admin_add_ip_access',
        'role' => 'Administrator'
    ]);

Route::get('user_accessibility',
    [
        'uses' => 'AdminController@user_accessibility',
        'as' => 'user_accessibility',
        'role' => 'Administrator'
    ]);

Route::get('admin_addOrRemove_tat_selector',
    [
        'uses' => 'AdminController@admin_addOrRemove_tat_selector',
        'as' => 'admin_addOrRemove_tat_selector',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_bi_view',
    [
        'uses' => 'AdminController@admin_get_bi_view',
        'as' => 'admin_get_bi_view',
        'role' => 'Administrator'
    ]);
Route::get('admin_bi_change_bi_view_table',
    [
        'uses' => 'AdminController@admin_bi_change_bi_view_table',
        'as' => 'admin_bi_change_bi_view_table',
        'role' => 'Administrator'
    ]);

Route::get('admin_update_bi_default_view',
    [
        'uses' => 'AdminController@admin_update_bi_default_view',
        'as' => 'admin_update_bi_default_view',
        'role' => 'Administrator'
    ]);

Route::get('admin_delete_bi_view',
    [
        'uses' => 'AdminController@admin_delete_bi_view',
        'as' => 'admin_delete_bi_view',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_viewable_to_bi',
    [
        'uses' => 'AdminController@admin_add_viewable_to_bi',
        'as' => 'admin_add_viewable_to_bi',
        'role' => 'Administrator'
    ]);

Route::get('admin_access_control',
    [
        'uses' => 'AdminController@admin_access_control',
        'as' => 'admin_access_control',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_access_of_user',
    [
        'uses' => 'AdminController@admin_get_access_of_user',
        'as' => 'admin_get_access_of_user',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_all_tele_level_table',
    [
        'uses' => 'AdminController@admin_get_all_tele_level_table',
        'as' => 'admin_get_all_tele_level_table',
        'role' => 'Administrator'
    ]);

Route::get('admin_levelup_tele',
    [
        'uses' => 'AdminController@admin_levelup_tele',
        'as' => 'admin_levelup_tele',
        'role' => 'Administrator'
    ]);

Route::get('admin_downlevel_tele',
    [
        'uses' => 'AdminController@admin_downlevel_tele',
        'as' => 'admin_downlevel_tele',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_reminder_table',
    [
        'uses' => 'AdminController@admin_get_reminder_table',
        'as' => 'admin_get_reminder_table',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_reminder',
    [
        'uses' => 'AdminController@admin_add_reminder',
        'as' => 'admin_add_reminder',
        'role' => 'Administrator'
    ]);

Route::get('admin_edit_or_remove_reminder',
    [
        'uses' => 'AdminController@admin_edit_or_remove_reminder',
        'as' => 'admin_edit_or_remove_reminder',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_to_email_user_and_client',
    [
        'uses' => 'AdminController@admin_get_to_email_user_and_client',
        'as' => 'admin_get_to_email_user_and_client',
        'role' => 'Administrator'
    ]);

Route::get('admin_endorsements_email_receiver_table',
    [
        'uses' => 'AdminController@admin_endorsements_email_receiver_table',
        'as' => 'admin_endorsements_email_receiver_table',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_user_to_email_endorsements',
    [
        'uses' => 'AdminController@admin_add_user_to_email_endorsements',
        'as' => 'admin_add_user_to_email_endorsements',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_recipient_endorsement',
    [
        'uses' => 'AdminController@admin_add_recipient_endorsement',
        'as' => 'admin_add_recipient_endorsement',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_all_defined_pos',
    [
        'uses' => 'AdminController@admin_get_all_defined_pos',
        'as' => 'admin_get_all_defined_pos',
        'role' => 'Administrator'
    ]);
    
Route::get('admin_get_all_active_client',
    [
        'uses' => 'AdminController@admin_get_all_active_client',
        'as' => 'admin_get_all_active_client',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_client_dist_list',
    [
        'uses' => 'AdminController@admin_add_client_dist_list',
        'as' => 'admin_add_client_dist_list',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_email_to_distribution_list',
    [
        'uses' => 'AdminController@admin_add_email_to_distribution_list',
        'as' => 'admin_add_email_to_distribution_list',
        'role' => 'Administrator'
    ]);

Route::get('admin_get_distribution_list_with_emails',
    [
        'uses' => 'AdminController@admin_get_distribution_list_with_emails',
        'as' => 'admin_get_distribution_list_with_emails',
        'role' => 'Administrator'
    ]);

Route::get('admin_delete_email_to_dist_list',
    [
        'uses' => 'AdminController@admin_delete_email_to_dist_list',
        'as' => 'admin_delete_email_to_dist_list',
        'role' => 'Administrator'
    ]);
    
Route::get('admin_give_access_ci',
    [
        'uses' => 'AdminController@admin_give_access_ci',
        'as' => 'admin_give_access_ci',
        'role' => 'Administrator'
    ]);
    
Route::get('admin_bi_user_loc_table_get',
[
    'uses' => 'AdminController@admin_bi_user_loc_table_get',
    'as' => 'admin_bi_user_loc_table_get',
    'role' => 'Administrator'
]);

Route::get('admin_add_loc_to_bi_user',
    [
        'uses' => 'AdminController@admin_add_loc_to_bi_user',
        'as' => 'admin_add_loc_to_bi_user',
        'role' => 'Administrator'
    ]);


Route::get('admin_delete_loc_under_bi',
    [
        'uses' => 'AdminController@admin_delete_loc_under_bi',
        'as' => 'admin_delete_loc_under_bi',
        'role' => 'Administrator'
    ]);





//===========================================CREDIT INVESTIGATOR ROUTE==================================================

Route::get('/ci-dashboard',
    [
        'uses' => 'CreditInvestigatorController@getCiDashboard',
        'as' => 'ci-dashboard',
        'role' => 'Credit Investigator'
    ]);

//Route::get('/ci-panel',
//    [
//        'uses' => 'CreditInvestigatorController@getCiPanel',
//        'as' => 'ci-panel',
//        'role' => 'Credit Investigator'
//    ]);

Route::get('/ci-endorse',
    [
        'uses' => 'CreditInvestigatorController@getCiEndorse',
        'as' => 'ci-endorse',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-fund-receive',
    [
        'uses' => 'CreditInvestigatorController@getCiFundReceive',
        'as' => 'ci-fund-receive',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-bi-report',
    [
        'uses' => 'CreditInvestigatorController@getCiBiReport',
        'as' => 'ci-bi-report',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-expense-report',
    [
        'uses' => 'CreditInvestigatorController@getCiExpensesReport',
        'as' => 'ci-expense-report',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-fund-receive-table',
    [
        'uses' => 'CreditInvestigatorController@getTableCiFund',
        'as' => 'ci-fund-receive-table',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-fund-receive-accept-table',
    [
        'uses' => 'CreditInvestigatorController@getTableCiFundAccept',
        'as' => 'ci-fund-receive-accept-table',
        'role' => 'Credit Investigator'
    ]);

Route::get('/new-ci-endorsement',
    [
        'uses' => 'CreditInvestigatorController@getCiNewEndorsement',
        'as' => 'new-ci-endorsement',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-template',
    [
        'uses' => 'CreditInvestigatorController@getCiTemplate',
        'as' => 'ci-template',
        'role' => 'Credit Investigator'
    ]);

Route::post('/attach-report',
    [
        'uses' => 'CreditInvestigatorController@attachReportFile',
        'as' => 'attach-report',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-endorse-viewitems',
    [
        'uses' => 'CreditInvestigatorController@ItemViewing',
        'as' => 'ci-endorse-viewitems',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-endorse-deleteitemqwqwqwqwqwqwqcHV0YQ==/{id}', function (Request $request, $id) {


    $path_link = new DownloadZipLogic();
    $paths = $path_link->path_link($request->AcctID);


    $certified = DB::table('certifieds')
        ->where('user_id', Auth::user()->id)
        ->select('cert')
        ->first();


    $audits = new AuditQueries();
    $audits->DeleteFromCi($request,$id);

    if ($certified->cert === 'NC') {

        File::delete(glob(storage_path('account/' . $paths . '/' . $id)));
    } else {

        File::delete(glob(storage_path('account_client/' . $paths . '/' . $id)));
    }
});


Route::get('/ci-dashboard-passdatalatlong',
    [
        'uses' => 'CreditInvestigatorController@PassDataLatLong',
        'as' => 'ci-dashboard-passdatalatlong',
        'role' => 'Credit Investigator'
    ]);

Route::post('/update-time-visit',
    [
        'uses' => 'CreditInvestigatorController@updateDateTimeVisit',
        'as' => 'update-time-visit',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-get-other-info',
    [
        'uses' => 'CreditInvestigatorController@getOtherInfo',
        'as' => 'ci-get-other-info',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-get-attach-info',
    [
        'uses' => 'CreditInvestigatorController@getInfoAttach',
        'as' => 'ci-get-attach-info',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci-save-report',
    [
        'uses' => 'CreditInvestigatorController@saveReport',
        'as' => 'ci-save-report',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci-update-report',
    [
        'uses' => 'CreditInvestigatorController@updateReport',
        'as' => 'ci-update-report',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-get-report',
    [
        'uses' => 'CreditInvestigatorController@getReport',
        'as' => 'ci-get-report',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci-upload-fine/{accountID}',
    [
        'uses' => 'CreditInvestigatorController@uploadFine',
        'as' => 'ci-upload-fine',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-get-finish-endorsement',
    [
        'uses' => 'CreditInvestigatorController@getFinishEndorsement',
        'as' => 'ci-get-finish-endorsement',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-get-files-downloadables',
    [
        'uses' => 'CreditInvestigatorController@getDownloadables',
        'as' => 'ci-get-files-downloadables',
        'role' => 'Credit Investigator'
    ]);

Route::post('/uploadReceiptExpenses',
    [
        'uses' => 'CreditInvestigatorController@uploadReceiptExpenses',
        'as' => 'uploadReceiptExpenses',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-check-expenses',
    [
        'uses' => 'CreditInvestigatorController@ci_check_expenses',
        'as' => 'ci-check-expenses',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-expense-delete-last-row',
    [
        'uses' => 'CreditInvestigatorController@ci_expense_delete_last_row',
        'as' => 'ci-expense-delete-last-row',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-expense-delete-row',
    [
        'uses' => 'CreditInvestigatorController@ci_expense_delete_row',
        'as' => 'ci-expense-delete-row',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_table_fund_accept_accounts',
    [
        'uses' => 'CreditInvestigatorController@ci_get_table_fund_accept_accounts',
        'as' => 'ci_get_table_fund_accept_accounts',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_table_fund_pending_accounts',
    [
        'uses' => 'CreditInvestigatorController@ci_get_table_fund_pending_accounts',
        'as' => 'ci_get_table_fund_pending_accounts',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_check_if_has_shell_include_and_if_asso',
    [
        'uses' => 'CreditInvestigatorController@ci_check_if_has_shell_include_and_if_asso',
        'as' => 'ci_check_if_has_shell_include_and_if_asso',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci_logs_for_shell',
    [
        'uses' => 'CreditInvestigatorController@ci_logs_for_shell',
        'as' => 'ci_logs_for_shell',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_coob_for_asso',
    [
        'uses' => 'CreditInvestigatorController@ci_get_coob_for_asso',
        'as' => 'ci_get_coob_for_asso',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_asso_saves_expenses',
    [
        'uses' => 'CreditInvestigatorController@ci_asso_saves_expenses',
        'as' => 'ci_asso_saves_expenses',
        'role' => 'Credit Investigator'
    ]);


Route::get('/ci_account_remove_select_asso',
    [
        'uses' => 'CreditInvestigatorController@ci_account_remove_select_asso',
        'as' => 'ci_account_remove_select_asso',
        'role' => 'Credit Investigator'
    ]);



Route::get('/storage/{type}/{folder}/{filename}', function($type,$folder,$filename)
{
    if(Auth::user()->hasRole('Credit Investigator'))
    {
        $path = storage_path('' . $type . '/' . $folder . '/' . $filename . '');

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }

//    echo '<image src = storage/Desert.jpg>';

});

Route::get('/download_storage/{folder}/{filename}', function($folder,$filename)
{

    if(Auth::user()->hasRole('Credit Investigator') || Auth::user()->hasRole('Administrator'))
    {
        $fder = base64_decode($folder);
//        $fname = base64_decode($filename);

        $path = storage_path('/'.$fder.'/'.$filename.'');

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }
//    echo '<image src = storage/Desert.jpg>';

});

Route::get('/get_message_info',
    [
        'uses' => 'CreditInvestigatorController@get_message_info',
        'as' => 'get_message_info',
        'role' => 'Credit Investigator'
    ]);

Route::get('/del_message_view_count',
    [
        'uses' => 'CreditInvestigatorController@del_message_view_count',
        'as' => 'del_message_view_count',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_fund_checker_receiving',
    [
        'uses' => 'CreditInvestigatorController@ci_fund_checker_receiving',
        'as' => 'ci_fund_checker_receiving',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_finish_accounts_for_expenses',
    [
        'uses' => 'CreditInvestigatorController@ci_get_finish_accounts_for_expenses',
        'as' => 'ci_get_finish_accounts_for_expenses',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci_submit_daily_expenses',
    [
        'uses' => 'CreditInvestigatorController@ci_submit_daily_expenses',
        'as' => 'ci_get_finish_accounts_for_expenses',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_expenses_report_table',
    [
        'uses' => 'CreditInvestigatorController@ci_get_expenses_report_table',
        'as' => 'ci_get_expenses_report_table',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci-liquidate-fund-amount',
    [
        'uses' => 'CreditInvestigatorController@ci_liquidate_fund_amount',
        'as' => 'ci-liquidate-fund-amount',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-fund-done-liq-table',
    [
        'uses' => 'CreditInvestigatorController@ci_fund_done_liq_table',
        'as' => 'ci-fund-done-liq-table',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci-check-login',
    [
        'uses' => 'CreditInvestigatorController@ci_check_login',
        'as' => 'ci-check-login',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci-upload-pic-daily',
    [
        'uses' => 'CreditInvestigatorController@ci_upload_pic_daily',
        'as' => 'ci-upload-pic-daily',
        'role' => 'Credit Investigator'
    ]);

Route::post('/ci_save_data_encode',
    [
        'uses' => 'CreditInvestigatorController@ci_save_data_encode',
        'as' => 'ci_save_data_encode',
        'role' => 'Credit Investigator'
    ]);

Route::get('/get_save_data_encoded',
    [
        'uses' => 'CreditInvestigatorController@get_save_data_encoded',
        'as' => 'get_save_data_encoded',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_get_select_encode_template',
    [
        'uses' => 'CreditInvestigatorController@ci_get_select_encode_template',
        'as' => 'ci_get_select_encode_template',
        'role' => 'Credit Investigator'
    ]);

Route::get('/ci_check_validation_en_attach_visit',
    [
        'uses' => 'CreditInvestigatorController@ci_check_validation_en_attach_visit',
        'as' => 'ci_check_validation_en_attach_visit',
        'role' => 'Credit Investigator'
    ]);

Route::post('ci_upload_pic_daily_fineuploader/{folderDateTime}',
    [
        'uses' => 'CreditInvestigatorController@ci_upload_pic_daily_fineuploader',
        'as' => 'ci-upload-pic-daily-fineuploader',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_update_attendace_photo',
    [
        'uses' => 'CreditInvestigatorController@ci_update_attendace_photo',
        'as' => 'ci_update_attendace_photo',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_get_attendancePhotos',
    [
        'uses' => 'CreditInvestigatorController@ci_get_attendancePhotos',
        'as' => 'ci_get_attendancePhotos',
        'role' => 'Credit Investigator'
    ]);

Route::get('/endorsement-seen-check', function(Request $request)
{
    $email = new EmailQueries();
    $infoHolder = [];
    $infoCtr = 0;

    if(Auth::user() != null)
    {
        if(Auth::user()->hasRole('Credit Investigator'))
        {
            if($request->acc_id != '')
            {
                if(count($request->acc_id) > 0)
                {
                    foreach($request->acc_id as $ids)
                    {
                        $getInfo = DB::table('endorsements')
                            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                            ->where('endorsements.id', $ids)
                            ->where(function($query)
                            {
                                return $query->where('endorsements.ci_status', '=' ,null)
                                    ->orwhere('endorsements.ci_status', '=', '')
                                    ->orwhere('endorsements.ci_status', '!=', 'Seen');
                            })
                            ->select([
                                'endorsements.id',
                                'endorsements.ci_status',
                                'endorsements.type_of_request',
                                'endorsements.created_at as date_time_endorsed',
                                \DB::raw("CONCAT(endorsements.date_due,' ',endorsements.time_due) as date_time_due"),
                                'endorsements.account_name',
                                'endorsements.address',
                                \DB::raw("UPPER(municipalities.muni_name) as muni_name"),
                            ])
                            ->get();

                        if(count($getInfo) > 0)
                        {
                            $infoHolder[$infoCtr] = [];

                            foreach($getInfo as $info)
                            {
                                DB::table('endorsements')
                                    ->where('id', $info->id)
                                    ->update([
                                        'ci_status' => 'Seen'
                                    ]);

                                $infoHolder[$infoCtr] = $info;
                            }
                            $infoCtr++;
                        }
                    }


                    if(count($infoHolder) > 0)
                    {
                        $toReturn = $email->sendNotifToSaoFromCISeen($infoHolder);
                        return response()->json(['notif sent', $toReturn]);
                    }
                    else
                    {
                        return response()->json('already seen');
                    }

                }
                else
                {
                    return 'no records found';
                }
            }
            else
            {
                return 'no records';
            }
        }
        else
        {
            abort(500);
        }
    }
    else
    {
        abort(404);
    }
});

Route::get('/ci-bi-reports-table',
    [
        'uses' => 'CreditInvestigatorController@ci_bi_reports_table',
        'as' => 'ci-bi-reports-table',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_add_bi_note',
    [
        'uses' => 'CreditInvestigatorController@ci_add_bi_note',
        'as' => 'ci_add_bi_note',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_edit_bi_note',
    [
        'uses' => 'CreditInvestigatorController@ci_edit_bi_note',
        'as' => 'ci_edit_bi_note',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_bi_note_view_logs',
    [
        'uses' => 'CreditInvestigatorController@ci_bi_note_view_logs',
        'as' => 'ci_bi_note_view_logs',
        'role' => 'Credit Investigator'
    ]);

Route::post('ci_upload_bi_report_fineuploader/{verifier}',
    [
        'uses' => 'CreditInvestigatorController@ci_upload_bi_report_fineuploader',
        'as' => 'ci_upload_bi_report_fineuploader',
        'role' => 'Credit Investigator'
    ]);

Route::post('ci_upload_bi_report_fineuploader_edit/{repo_id}',
    [
        'uses' => 'CreditInvestigatorController@ci_upload_bi_report_fineuploader_edit',
        'as' => 'ci_upload_bi_report_fineuploader_edit',
        'role' => 'Credit Investigator'
    ]);

Route::get('ci_get_update_time_details',
    [
        'uses' => 'CreditInvestigatorController@ci_get_update_time_details',
        'as' => 'ci_get_update_time_details',
        'role' => 'Credit Investigator'
    ]);    


//==============================================MANAGEMENT ROUTE=======================================================

Route::get('/management-dashboard',
    [
        'uses' => 'ManagementController@getManagementDashboard',
        'as' => 'management-dashboard',
        'role' => 'Management'
    ]);

Route::get('/management-panel',
    [
        'uses' => 'ManagementController@getManagementPanel',
        'as' => 'management-panel',
        'role' => 'Management'
    ]);

Route::get('/management-tracker-account',
    [
        'uses' => 'ManagementController@getManagementAccountTracker',
        'as' => 'management-tracker-account',
        'role' => 'Management'
    ]);

Route::get('/management-audit',
    [
        'uses' => 'ManagementController@getManagementAudit',
        'as' => 'management-audit',
        'role' => 'Management'
    ]);

Route::get('/management-fund-audit',
    [
        'uses' => 'ManagementController@getManagementFundAudit',
        'as' => 'management-fund-audit',
        'role' => 'Management'
    ]);

Route::get('/management-fetch-audit',
    [
        'uses' => 'ManagementController@getAuditTrailingList',
        'as' => 'management-fetch-audit',
        'role' => 'Management'
    ]);

Route::get('/management-fetch-fund-audit',
    [
        'uses' => 'ManagementController@getFundAuditTrailingList',
        'as' => 'management-fund-fetch-audit',
        'role' => 'Management'
    ]);

Route::get('/management-report',
    [
        'uses' => 'ManagementController@getManagementReport',
        'as' => 'management-report',
        'role' => 'Management'
    ]);

Route::get('/management-line-chart',
    [
        'uses' => 'ManagementController@getLineChart',
        'as' => 'management-line-chart',
        'role' => 'Management'
    ]);

Route::get('/management-manage-poll',
    [
        'uses' => 'ManagementController@managePoll',
        'as' => 'management-manage-poll',
        'role' => 'Management'
    ]);

Route::get('/management-manage-poll-toggle',
    [
        'uses' => 'ManagementController@managePollToggle',
        'as' => 'management-manage-poll-toggle',
        'role' => 'Management'
    ]);

Route::get('/management-manage-poll-question',
    [
        'uses' => 'ManagementController@AddPoll',
        'as' => 'management-manage-poll-question',
        'role' => 'Management'
    ]);

Route::get('/management-manage-add-poll',
    [
        'uses' => 'ManagementController@AddPollFromQuestion',
        'as' => 'management-manage-add-poll',
        'role' => 'Management'
    ]);

Route::get('/management-manage-poll-delete',
    [
        'uses' => 'ManagementController@DeletePoll',
        'as' => 'management-manage-poll-delete',
        'role' => 'Management'
    ]);

Route::get('/management-ci-expenses-table',
    [
        'uses' => 'ManagementController@GetTableExpenses',
        'as' => 'management-ci-expenses-table',
        'role' => 'Management'
    ]);

Route::get('/management_get_expenses_logs',
    [
        'uses'=>'ManagementController@management_get_expenses_logs',
        'as'=>'management_get_expenses_logs',
        'role'=>'Management'
    ]);

Route::get('/management-get-ci-fund-table',
    [
        'uses' => 'ManagementController@ci_fund_table_get',
        'as' => 'management-get-ci-fund-table',
        'role' => 'Management'
    ]);

Route::get('/management-get-ci-fund-table-approved',
    [
        'uses' => 'ManagementController@ci_fund_table_get_approved',
        'as' => 'management-get-ci-fund-table-approved',
        'role' => 'Management'
    ]);

Route::get('/management-get-ci-fund-table-declined',
    [
        'uses' => 'ManagementController@ci_fund_table_get_declined',
        'as' => 'management-get-ci-fund-table-declined',
        'role' => 'Management'
    ]);

Route::get('/management-approve-selected-supplier',
    [
        'uses' => 'ManagementController@management_approve_selected_supplier',
        'as' => 'management-approve-selected-supplier',
        'role' => 'Management'
    ]);

Route::get('/management_sup_approval_monit',
    [
        'uses' => 'ManagementController@management_sup_approval_monit',
        'as' => 'management_sup_approval_monit',
        'role' => 'Management'
    ]);


//======================================SENIOR ACCOUNT OFFICER ROUTE===========================================



Route::get('/sao-dashboard',
    [
        'uses' => 'SrAccountOfficerController@getSaoDashboard',
        'as' => 'sao-dashboard',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-panel',
    [
        'uses' => 'SrAccountOfficerController@getSaoMaster',
        'as' => 'sao-panel',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-assign-account',
    [
        'uses' => 'SrAccountOfficerController@getSaoAssignAccount',
        'as' => 'sao-assign-account',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-endorsement',
    [
        'uses' => 'SrAccountOfficerController@getSaoEndorsement',
        'as' => 'sao-endorsement',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-fetch-endorsement',
    [
        'uses' => 'SrAccountOfficerController@tableViewManipulation',
        'as' => 'srao-fetch-endorsement',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-ci-fund-request',
    [
        'uses' => 'SrAccountOfficerController@ciFundRequest',
        'as' => 'sao-ci-fund-request',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/sao-assign-to-ao',
    [
        'uses' => 'SrAccountOfficerController@assignToAo',
        'as' => 'sao-assign-to-ao',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-transfer-account',
    [
        'uses' => 'SrAccountOfficerController@aoListAccount',
        'as' => 'sao-transfer-account',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/srao-ao-transfer',
    [
        'uses' => 'SrAccountOfficerController@aoTransfer',
        'as' => 'srao-ao-transfer',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/srao-cancel-account',
    [
        'uses' => 'SrAccountOfficerController@cancelAccount',
        'as' => 'dispatcher-cancel-account',
        'role' => 'Senior Account Officer'
    ]);


Route::post('/srao-hold-account',
    [
        'uses' => 'SrAccountOfficerController@holdAccount',
        'as' => 'dispatcher-hold-account',
        'role' => 'Senior Account Officer'
    ]);


Route::post('/srao-uncancelhold-account',
    [
        'uses' => 'SrAccountOfficerController@uncancelholdAccount',
        'as' => 'dispatcher-uncancelhold-account',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-fetch-endorsementManage',
    [
        'uses' => 'SrAccountOfficerController@tableViewManipulationMnge',
        'as' => 'srao-fetch-endorsements',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-other-info',
    [
        'uses' => 'SrAccountOfficerController@getOtherInfo',
        'as' => 'srao-get-other-info',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-ao-counts',
    [
        'uses' => 'SrAccountOfficerController@getAOcounts',
        'as' => 'srao-get-ao-counts',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-updated-info',
    [
        'uses' => 'SrAccountOfficerController@getUpdatedInfo',
        'as' => 'srao-get-updated-info',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/srao-update-ao-info',
    [
        'uses' => 'SrAccountOfficerController@updateAOInfo',
        'as' => 'srao-update-ao-info',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-ci-fund-table',
    [
        'uses' => 'SrAccountOfficerController@ci_fund_table_get',
        'as' => 'srao-get-ci-fund-table',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-ci-fund-table-approved',
    [
        'uses' => 'SrAccountOfficerController@ci_fund_table_get_approved',
        'as' => 'srao-get-ci-fund-table-approved',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-ci-fund-table-declined',
    [
        'uses' => 'SrAccountOfficerController@ci_fund_table_get_declined',
        'as' => 'srao-get-ci-fund-table-declined',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-apporoved-req',
    [
        'uses' => 'SrAccountOfficerController@ApprovedReq',
        'as' => 'srao-apporoved-req',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-declined-req',
    [
        'uses' => 'SrAccountOfficerController@DeclinedReq',
        'as' => 'srao-declined-req',
        'role' => 'Senior Account Officer'
    ]);


Route::get('/sao_pending_fund_details_endorsements',
    [
        'uses' => 'SrAccountOfficerController@sao_pending_fund_details_endorsements',
        'as' => 'sao_pending_fund_details_endorsements',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao_app_fund_details_endorsements',
    [
        'uses' => 'SrAccountOfficerController@sao_app_fund_details_endorsements',
        'as' => 'sao_app_fund_details_endorsements',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao_dec_fund_details_endorsements',
    [
        'uses' => 'SrAccountOfficerController@sao_dec_fund_details_endorsements',
        'as' => 'sao_dec_fund_details_endorsements',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-table-get-revision',
    [
        'uses' => 'SrAccountOfficerController@saoGetTableRev',
        'as' => 'sao-table-get-revision',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-download-revision',
    [
        'uses' => 'SrAccountOfficerController@sraoDownloadRev',
        'as' => 'srao-download-revision',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/uploadReportFile_revision',
    [
        'uses' => 'SrAccountOfficerController@uploadReportFile_revision',
        'as' => 'uploadReportFile_revision',
        'role' => 'Senior Account Officer'
    ]);

//Route::get('/srao_download_revision_revised',
//    [
//        'uses' => 'SrAccountOfficerController@srao_download_revision_revised',
//        'as' => 'srao_download_revision_revised',
//        'role' => 'Senior Account Officer'
//    ]);

Route::get('/srao_check_revision_availability',
    [
        'uses' => 'SrAccountOfficerController@srao_check_revision_availability',
        'as' => 'srao_check_revision_availability',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao_get_info_for_assign',
    [
        'uses' => 'SrAccountOfficerController@sao_get_info_for_assign',
        'as' => 'sao_get_info_for_assign',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao_table_ci_account_reports',
    [
        'uses' => 'SrAccountOfficerController@sao_table_ci_account_reports',
        'as' => 'sao_table_ci_account_reports',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-ci-account-download-report',
    [
        'uses' => 'SrAccountOfficerController@sao_ci_account_download_report',
        'as' => 'sao_ci_account_download_report',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-download-report-audit',
    [
        'uses' => 'SrAccountOfficerController@sao_audit_download',
        'as' => 'sao-download-report-audit',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-ci-list',
    [
        'uses' => 'SrAccountOfficerController@sao_get_ci_list',
        'as' => 'sao-get-ci-list',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-ci-endorse-no-fund',
    [
        'uses' => 'SrAccountOfficerController@sao_get_ci_endorse_no_fund',
        'as' => 'sao-get-ci-endorse-no-fund',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-table-for-no-fund-accounts',
    [
        'uses' => 'SrAccountOfficerController@sao_table_for_no_fund_accounts',
        'as' => 'sao-table-for-no-fund-accounts',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/sao-submit-unliq-hold-amount',
    [
        'uses' => 'SrAccountOfficerController@sao_submit_unliq_hold_amount',
        'as' => 'sao-submit-unliq-hold-amount',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-table-unliq-fund-list-ci',
    [
        'uses' => 'SrAccountOfficerController@sao_table_unliq_fund_list_ci',
        'as' => 'sao-table-unliq-fund-list-ci',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-all-info-fund-hold',
    [
        'uses' => 'SrAccountOfficerController@sao_get_all_info_fund_hold',
        'as' => 'sao-get-all-info-fund-hold',
        'role' => 'Senior Account Officer'
    ]);

Route::post('/sao-send-emergency-req',
    [
        'uses' => 'SrAccountOfficerController@sao_send_emergency_req',
        'as' => 'sao-send-emergency-req',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/srao-get-fund-amount-to-approve',
    [
        'uses' => 'SrAccountOfficerController@srao_get_fund_amount_to_approve',
        'as' => 'srao-get-fund-amount-to-approve',
        'role' => 'Senior Account Officer'
    ]);

Route::get('srao-fund-override-logs',
    [
        'uses' => 'SrAccountOfficerController@srao_fund_override_logs',
        'as' => 'srao-fund-override-logs',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-fund-request-table',
    [
        'uses' => 'SrAccountOfficerController@getTableFundRequest',
        'as' => 'sao-get-fund-request-table',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-table-fund-success',
    [
        'uses' => 'SrAccountOfficerController@getTableFundSuccess',
        'as' => 'sao-table-fund-success',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-fund-disapproved-table',
    [
        'uses' => 'SrAccountOfficerController@getTableFundDisapproved',
        'as' => 'sao-get-fund-disapproved-table',
        'role' => 'Senior Account Officer'
    ]);

Route::get('/sao-get-fund-cancelled-table',
    [
        'uses' => 'SrAccountOfficerController@getTableFundCancelled',
        'as' => 'sao-get-fund-cancelled-table',
        'role' => 'Senior Account Officer'
    ]);

Route::get('sao_cancel_fund',
    [
        'uses' => 'SrAccountOfficerController@sao_cancel_fund',
        'as' => 'sao_cancel_fund',
        'role' => 'Senior Account Officer'
    ]);

Route::post('sao_send_request_add_fund',
    [
        'uses' => 'SrAccountOfficerController@sao_send_request_add_fund',
        'as' => 'sao_send_request_add_fund',
        'role' => 'Senior Account Officer'
    ]);




//===========================================BILLING==========================================================

Route::get('/billing-dashboard',
    [
        'uses' => 'BillingController@getBillingDashboard',
        'as' => 'billing-dashboard',
        'role' => 'Billing'
    ]);

Route::get('/billing-panel',
    [
        'uses' => 'BillingController@getBillingPanel',
        'as' => 'billing-panel',
        'role' => 'Billing'
    ]);

Route::get('/billing-rate',
    [
        'uses' => 'BillingController@getBillingRate',
        'as' => 'billing-rate',
        'role' => 'Billing'
    ]);

Route::get('/billing-table-report',
    [
        'uses' => 'BillingController@tableGetReport',
        'as' => 'billing-table-report',
        'role' => 'Billing'
    ]);

Route::get('/billing-manage',
    [
        'uses' => 'BillingController@manageBilling',
        'as' => 'billing-manage',
        'role' => 'Billing'
    ]);

Route::get('/billing-management',
    [
        'uses' => 'BillingController@tableGetBillingManage',
        'as' => 'billing-managemanagement',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-billed-unbill',
    [
        'uses' => 'BillingController@BilledUnbill',
        'as' => 'billing-management-billed-unbill',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-three-tfs',
    [
        'uses' => 'BillingController@BilledRuleThreeTFS',
        'as' => 'billing-management-rule-three-tfs',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-two-tfs',
    [
        'uses' => 'BillingController@BilledRuleTwoTFS',
        'as' => 'billing-management-rule-two-tfs',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-undo',
    [
        'uses' => 'BillingController@BilledRuleUndo',
        'as' => 'billing-management-rule-undo',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-one-tfs',
    [
        'uses' => 'BillingController@BilledRuleOneTFS',
        'as' => 'billing-management-rule-one-tfs',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-four-tfs-manila',
    [
        'uses' => 'BillingController@BilledRuleFourManila',
        'as' => 'billing-management-rule-four-tfs-manila',
        'role' => 'Billing'
    ]);

Route::get('/billing-management-rule-four-tfs-province',
    [
        'uses' => 'BillingController@BilledRuleFourProvince',
        'as' => 'billing-management-rule-four-tfs-province',
        'role' => 'Billing'
    ]);

Route::get('/management-get-ci-fund-table-declined',
    [
        'uses' => 'ManagementController@ci_fund_table_get_declined',
        'as' => 'management-get-ci-fund-table-declined',
        'role' => 'Management'
    ]);

Route::get('/management-approved-req',
    [
        'uses' => 'ManagementController@management_approved_req',
        'as' => 'management-approved-req',
        'role' => 'Management'
    ]);

Route::get('/management-declined-req',
    [
        'uses' => 'ManagementController@management_declined_req',
        'as' => 'management-declined-req',
        'role' => 'Management'
    ]);

Route::get('/management-declined-req',
    [
        'uses' => 'ManagementController@management_declined_req',
        'as' => 'management-declined-req',
        'role' => 'Management'
    ]);

Route::get('/management_sup_approval',
    [
        'uses' => 'ManagementController@management_sup_approval',
        'as' => 'management_sup_approval',
        'role' => 'Management'
    ]);

Route::get('/management_get_supplier_to_compare',
    [
        'uses' => 'ManagementController@management_get_supplier_to_compare',
        'as' => 'management_get_supplier_to_compare',
        'role' => 'Management'
    ]);
    
Route::get('management_get_general_mon_table_ccbank',
    [
        'uses' => 'ManagementController@management_get_general_mon_table_ccbank',
        'as' => 'management_get_general_mon_table_ccbank',
        'role' => 'Management'
    ]);

Route::get('management_get_general_mon_table_cc',
    [
        'uses' => 'ManagementController@management_get_general_mon_table_cc',
        'as' => 'management_get_general_mon_table_cc',
        'role' => 'Management'
    ]);

//=============================================MARKETING=========================================================


Route::get('/marketing-dashboard',
    [
        'uses' => 'MarketingController@getMarketingDashboard',
        'as' => 'marketing-dashboard',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-panel',
    [
        'uses' => 'MarketingController@getMarketingPanel',
        'as' => 'marketing-panel',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-report',
    [
        'uses' => 'MarketingController@getMarketingReport',
        'as' => 'marketing-report',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-manage',
    [
        'uses' => 'MarketingController@getMarketingManage',
        'as' => 'marketing-manage',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-manage',
    [
        'uses' => 'MarketingController@tableGetMarketingManage',
        'as' => 'marketing-table-manage',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-insert-rate',
    [
        'uses' => 'MarketingController@insertRate',
        'as' => 'marketing-insert-rate',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-bulk-rate',
    [
        'uses' => 'MarketingController@bulkRate',
        'as' => 'marketing-bulk-rate',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-rate-update',
    [
        'uses' => 'MarketingController@UpdateRate',
        'as' => 'marketing-table-rate-update',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-getcount',
    [
        'uses' => 'MarketingController@getountrates',
        'as' => 'marketing-table-getcountmarketing-table-getcount',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-contract',
    [
        'uses' => 'MarketingController@getContract',
        'as' => 'marketing-contract',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-contract-add',
    [
        'uses' => 'MarketingController@saveContract',
        'as' => 'marketing-contract-add',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-contract-table',
    [
        'uses' => 'MarketingController@getTableContracts',
        'as' => 'marketing-contract-table',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-contract-download',
    [
        'uses' => 'MarketingController@downloadCont',
        'as' => 'marketing-contract-download',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-contract-fetch-info',
    [
        'uses' => 'MarketingController@fetchInfo',
        'as' => 'marketing-contract-fetch-info',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-contract-update',
    [
        'uses' => 'MarketingController@updateContract',
        'as' => 'marketing-contract-update',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-bday',
    [
        'uses' => 'MarketingController@getBday',
        'as' => 'marketing-bday',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-clientbday',
    [
        'uses' => 'MarketingController@getTableBday',
        'as' => 'marketing-table-clientbday',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-insert-bday',
    [
        'uses' => 'MarketingController@insertClientBday',
        'as' => 'marketing-insert-bday',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-fetch-client-bday',
    [
        'uses' => 'MarketingController@fetchClientBday',
        'as' => 'marketing-fetch-client-bday',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-update-clients-bday',
    [
        'uses' => 'MarketingController@updateClientBday',
        'as' => 'marketing-update-clients-bday',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-new-client',
    [
        'uses' => 'MarketingController@getViewNewClient',
        'as' => 'marketing-new-client',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-pros-client',
    [
        'uses' => 'MarketingController@getTableProsClient',
        'as' => 'marketing-table-pros-client',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-insert-pros-client',
    [
        'uses' => 'MarketingController@insertProsClient',
        'as' => 'marketing-insert-pros-client',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-update-pros-client',
    [
        'uses' => 'MarketingController@updateProsClient',
        'as' => 'marketing-update-pros-client',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-fetchinfo-pros-client',
    [
        'uses' => 'MarketingController@fetchInfoProsClient',
        'as' => 'marketing-fetchinfo-pros-client',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-download-pros-client',
    [
        'uses' => 'MarketingController@downloadProsClient',
        'as' => 'marketing-download-pros-client',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-todolist',
    [
        'uses' => 'MarketingController@getToDoList',
        'as' => 'marketing-table-todolist',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-insert-todolist',
    [
        'uses' => 'MarketingController@insertToDoList',
        'as' => 'marketing-insert-todolist',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-update-todolist-fetch-info',
    [
        'uses' => 'MarketingController@fetchTodolistInfo',
        'as' => 'marketing-update-todolist-fetch-info',
        'role' => 'Marketing'
    ]);

Route::post('/marketing-update-todolist-info',
    [
        'uses' => 'MarketingController@updateTodolistInfo',
        'as' => 'marketing-update-todolist-info',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-done-todolist-info',
    [
        'uses' => 'MarketingController@doneTodolistInfo',
        'as' => 'marketing-done-todolist-info',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-done-todolist',
    [
        'uses' => 'MarketingController@tableDoneTodolistInfo',
        'as' => 'marketing-table-done-todolist',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-delete-todolist',
    [
        'uses' => 'MarketingController@tableDeleteTodolist',
        'as' => 'marketing-delete-todolist',
        'role' => 'Marketing'
    ]);


Route::get('/marketing-table-standard-rate',
    [
        'uses' => 'MarketingController@marketing_save_tat_prov',
        'as' => 'marketing-table-standard-rate',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-table-tat-manage-get',
    [
        'uses' => 'MarketingController@marketing_table_tat_manage_get',
        'as' => 'marketing-table-tat-manage-get',
        'role' => 'Marketing'
    ]);

Route::get('/marketing_check_tat_prov',
    [
        'uses' => 'MarketingController@marketing_check_tat_prov',
        'as' => 'marketing_check_tat_prov',
        'role' => 'Marketing'
    ]);

Route::get('/marketing_save_tat_prov',
    [
        'uses' => 'MarketingController@marketing_save_tat_prov',
        'as' => 'marketing_save_tat_prov',
        'role' => 'Marketing'
    ]);

Route::get('/marketing_check_tat_muni',
    [
        'uses' => 'MarketingController@marketing_check_tat_muni',
        'as' => 'marketing_check_tat_muni',
        'role' => 'Marketing'
    ]);

Route::get('/marketing_save_tat_muni',
    [
        'uses' => 'MarketingController@marketing_save_tat_muni',
        'as' => 'marketing_save_tat_muni',
        'role' => 'Marketing'
    ]);

Route::get('/tat_management_delete',
    [
        'uses' => 'MarketingController@tat_management_delete',
        'as' => 'tat_management_delete',
        'role' => 'Marketing'
    ]);

Route::get('/marketing_tat_update_row',
    [
        'uses' => 'MarketingController@marketing_tat_update_row',
        'as' => 'tat_management_delete',
        'role' => 'Marketing'
    ]);

//new

Route::get('/marketing-table-standard-rate',
    [
        'uses' => 'MarketingController@tableGetMarketingStandard',
        'as' => 'marketing-table-standard-rate',
        'role' => 'Marketing'
    ]);

// STANDARD RATE Insert

Route::post('/marketing-insert-standard',
    [
        'uses' => 'MarketingController@insertStandardRate',
        'as' => 'marketing-insert-standard',
        'role' => 'Marketing'
    ]);

Route::get( '/marketing-insert-bulk-standard',
    [
        'uses' => 'MarketingController@insertStandardBulk',
        'as' => 'marketing-insert-standard-bulk',
        'role' => 'Marketing'
    ]);


//standard update

Route::get('/marketing-get-info-update',
    [
        'uses' => 'MarketingController@UpdateStandardGetID',
        'as' => 'marketing-get-info-update',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-update-prov-standard',
    [
        'uses' => 'MarketingController@UpdateProvStandard',
        'as' => 'marketing-update-prov-standard',
        'role' => 'Marketing'
    ]);

Route::get('/marketing-update-muni-standard',
    [
        'uses' => 'MarketingController@tableEditStandard',
        'as' => 'marketing-update-muni-standard',
        'role' => 'Marketing'
    ]);


Route::get('/marketing-update-muni-form-standard',
    [
        'uses' => 'MarketingController@updateMuniFormStandard',
        'as' => 'marketing-update-muni-form-standard',
        'role' => 'Marketing'
    ]);


//delete
Route::get('/marketing-delete-standard',
    [
        'uses' => 'MarketingController@tableDeleteStandard',
        'as' => 'marketing-delete-standard',
        'role' => 'Marketing'
    ]);
//end

//saving holiday
Route::post('/marketing_save_holiday_event_tat',
    [
        'uses' => 'MarketingController@marketing_save_holiday_event_tat',
        'as' => 'marketing_save_holiday_event_tat',
        'role' => 'Marketing'
    ]);
//end
//get holiday
Route::post('/marketing_get_holidays',
    [
        'uses' => 'MarketingController@marketing_get_holidays',
        'as' => 'marketing_get_holidays',
        'role' => 'Marketing'
    ]);
//end
//detelet holiday
Route::post('/marketing_deletes_holiday_cal',
    [
        'uses' => 'MarketingController@marketing_deletes_holiday_cal',
        'as' => 'marketing_deletes_holiday_cal',
        'role' => 'Marketing'
    ]);
//end

//delete contract
Route::post('/marketing_delete_contract',
    [
        'uses' => 'MarketingController@marketing_delete_contract',
        'as' => 'marketing_delete_contract',
        'role' => 'Marketing'
    ]);

//delete bday
Route::post('/marketing_delete_client_bday',
    [
        'uses' => 'MarketingController@marketing_delete_client_bday',
        'as' => 'marketing_delete_client_bday',
        'role' => 'Marketing'
    ]);


//delete pros_client
Route::post('/marketing_delete_pros_client',
    [
        'uses' => 'MarketingController@marketing_delete_pros_client',
        'as' => 'marketing_delete_pros_client',
        'role' => 'Marketing'
    ]);

//delete update_accounts
Route::post('/marketing_tat_update_accounts',
    [
        'uses' => 'MarketingController@marketing_tat_update_accounts',
        'as' => 'marketing_tat_update_accounts',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_bi_clients',
    [
        'uses' => 'MarketingController@marketing_get_bi_clients',
        'as' => 'marketing_get_bi_clients',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_client_package',
    [
        'uses' => 'MarketingController@marketing_get_client_package',
        'as' => 'marketing_get_client_package',
        'role' => 'Marketing'
    ]);

Route::get('marketing_add_rate_to_bi',
    [
        'uses' => 'MarketingController@marketing_add_rate_to_bi',
        'as' => 'marketing_add_rate_to_bi',
        'role' => 'Marketing'
    ]);

Route::get('marketing_bi_rate_table',
    [
        'uses' => 'MarketingController@marketing_bi_rate_table',
        'as' => 'marketing_bi_rate_table',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_logs',
    [
        'uses' => 'MarketingController@marketing_get_logs',
        'as' => 'marketing_get_logs',
        'role' => 'Marketing'
    ]);

Route::get('marketing_update_bi_rates',
    [
        'uses' => 'MarketingController@marketing_update_bi_rates',
        'as' => 'marketing_update_bi_rates',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_all_muni_names',
    [
        'uses' => 'MarketingController@marketing_get_all_muni_names',
        'as' => 'marketing_get_all_muni_names',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_all_provinces',
    [
        'uses' => 'MarketingController@marketing_get_all_provinces',
        'as' => 'marketing_get_all_provinces',
        'role' => 'Marketing'
    ]);

Route::get('marketing_bi_rate_table_ocular',
    [
        'uses' => 'MarketingController@marketing_bi_rate_table_ocular',
        'as' => 'marketing_bi_rate_table_ocular',
        'role' => 'Marketing'
    ]);

Route::get('marketing_add_rate_to_bi_tab2',
    [
        'uses' => 'MarketingController@marketing_add_rate_to_bi_tab2',
        'as' => 'marketing_add_rate_to_bi_tab2',
        'role' => 'Marketing'
    ]);

Route::get('marketing_all_logs_table',
    [
        'uses' => 'MarketingController@marketing_all_logs_table',
        'as' => 'marketing_all_logs_table',
        'role' => 'Marketing'
    ]);

Route::get('marketing_bi_rate_table_alacarte',
    [
        'uses' => 'MarketingController@marketing_bi_rate_table_alacarte',
        'as' => 'marketing_bi_rate_table_alacarte',
        'role' => 'Marketing'
    ]);

Route::get('marketing_get_client_alacarte',
    [
        'uses' => 'MarketingController@marketing_get_client_alacarte',
        'as' => 'marketing_get_client_alacarte ',
        'role' => 'Marketing'
    ]);

Route::get('bi_rate_add_alacarte',
    [
        'uses' => 'MarketingController@bi_rate_add_alacarte',
        'as' => 'bi_rate_add_alacarte ',
        'role' => 'Marketing'
    ]);

//===========================================AUDIT=============================================================

Route::get('/audit-dashboard',
    [
        'uses' => 'AuditController@getAuditDashboard',
        'as' => 'audit-dashboard',
        'role' => 'Audit'
    ]);

Route::get('/audit-panel',
    [
        'uses' => 'AuditController@getAuditPanel',
        'as' => 'audit-panel',
        'role' => 'Audit'
    ]);

Route::get('/audit-report',
    [
        'uses' => 'AuditController@getAuditReport',
        'as' => 'audit-report',
        'role' => 'Audit'
    ]);

Route::get('/audit-fund-report',
    [
        'uses' => 'AuditController@getFundReport',
        'as' => 'audit-fund-report',
        'role' => 'Audit'
    ]);

Route::get('/audit-ci-expense-report',
    [
        'uses' => 'AuditController@getCiExpenseReport',
        'as' => 'audit-ci-expense-report',
        'role' => 'Audit'
    ]);

Route::get('/audit-table-report',
    [
        'uses'=>'AuditController@tableGetAuditReportTable',
        'as'=>'audit-table-report',
        'role'=>'Audit'
    ]);

Route::post('/audit-table-report-sao',
    [
        'uses'=>'AuditController@tableGetAuditReportTable_sao',
        'as'=>'audit-table-report-sao',
        'role'=>'Audit'
    ]);

Route::get('/audit-fund-table-report',
    [
        'uses'=>'AuditController@tableGetFundReportTable',
        'as'=>'audit-fund-table-report',
        'role'=>'Audit'
    ]);

Route::get('/audit-ci-expenses-table-report',
    [
        'uses'=>'AuditController@tableGetCiExpensesReportTable',
        'as'=>'audit-ci-expenses-table-report',
        'role'=>'Audit'
    ]);

Route::get('/audit-ci-expenses-table-report-sort',
    [
        'uses'=>'AuditController@tableGetCiExpensesReportTable_sort',
        'as'=>'audit-ci-expenses-table-report-sort',
        'role'=>'Audit'
    ]);

Route::get('/audit-download-report',
    [
        'uses'=>'AuditController@auditDownloadReport',
        'as'=>'audit-download-report',
        'role'=>'Audit'
    ]);

Route::get('/audit-download-report-ci',
    [
        'uses'=>'AuditController@auditDownloadReportCI',
        'as'=>'audit-download-report-ci',
        'role'=>'Audit'
    ]);

Route::get('/audit_get_fund_logs',
    [
        'uses'=>'AuditController@audit_get_fund_logs',
        'as'=>'audit_get_fund_logs',
        'role'=>'Audit'
    ]);

Route::get('/audit_get_expenses_logs',
    [
        'uses'=>'AuditController@audit_get_expenses_logs',
        'as'=>'audit_get_expenses_logs',
        'role'=>'Audit'
    ]);

Route::get('/audit_download_receipt',
    [
        'uses'=>'AuditController@audit_download_receipt',
        'as'=>'audit_download_receipt',
        'role'=>'Audit'
    ]);

Route::get('/audit_after_download_delete_expense_zip',
    [
        'uses'=>'AuditController@audit_after_download_delete_expense_zip',
        'as'=>'audit_after_download_delete_expense_zip',
        'role'=>'Audit'
    ]);
Route::get('/audit-get-edo-acc-details',
    [
        'uses'=>'AuditController@audit_get_edo_acc_details',
        'as'=>'audit-get-edo-acc-details',
        'role'=>'Audit'
    ]);
Route::get('/audit-update-incent-deduct',
    [
        'uses'=>'AuditController@audit_update_incent_deduct',
        'as'=>'audit-update-incent-deduct',
        'role'=>'Audit'
    ]);
Route::get('/audit-dl-ci-report',
    [
        'uses'=>'AuditController@audit_dl_ci_report',
        'as'=>'audit-dl-ci-report',
        'role'=>'Audit'
    ]);

Route::get('/audit-check-total-acc',
    [
        'uses'=>'AuditController@audit_check_total_acc',
        'as'=>'audit-check-total-acc',
        'role'=>'Audit'
    ]);
Route::get('/audit-get-files-ci',
    [
        'uses'=>'AuditController@audit_get_files_ci',
        'as'=>'audit-get-files-ci',
        'role'=>'Audit'
    ]);
Route::get('/audit-ao-file-dl',
    [
        'uses'=>'AuditController@audit_ao_file_dl',
        'as'=>'audit-ao-file-dl',
        'role'=>'Audit'
    ]);

Route::get('audit-ci-fund-request-table-fa',
    [
        'uses' => 'AuditController@audit_ci_fund_request_table_fa',
        'as' => 'audit-ci-fund-request-table-fa',
        'role' => 'Audit'
    ]);

Route::get('audit-get-liq-img',
    [
        'uses'=>'AuditController@audit_get_liq_img',
        'as'=>'audit-get-liq-img',
        'role'=>'Audit'
    ]);

Route::post('audit_liquidation_checking',
    [
        'uses'=>'AuditController@audit_liquidation_checking',
        'as'=>'audit_liquidation_checking',
        'role'=>'Audit'
    ]);

Route::get('audit_get_audit_remarks',
    [
        'uses'=>'AuditController@audit_get_audit_remarks',
        'as'=>'audit_get_audit_remarks',
        'role'=>'Finance'
    ]);

Route::get('audit_ci_report_checking_form',
    [
        'uses'=>'AuditController@audit_ci_report_checking_form',
        'as'=>'audit_ci_report_checking_form',
        'role'=>'Audit'
    ]);

Route::get('audit_get_account_info_and_details',
    [
        'uses'=>'AuditController@audit_get_account_info_and_details',
        'as'=>'audit_get_account_info_and_details',
        'role'=>'Audit'
    ]);

Route::get('audit_tab6_autocomplete',
    [
        'uses'=>'AuditController@audit_tab6_autocomplete',
        'as'=>'audit_tab6_autocomplete',
        'role'=>'Audit'
    ]);

Route::get('audit_get_logs',
    [
        'uses'=>'AuditController@audit_get_logs',
        'as'=>'audit_get_logs',
        'role'=>'Audit'
    ]);

Route::get('audit_get_logs_value_tab6',
    [
        'uses'=>'AuditController@audit_get_logs_value_tab6',
        'as'=>'audit_get_logs_value_tab6',
        'role'=>'Audit'
    ]);

Route::get('audit_get_oims_bank_id_list',
    [
        'uses'=>'AuditController@audit_get_oims_bank_id_list',
        'as'=>'audit_get_oims_bank_id_list',
        'role'=>'Finance'
    ]);

Route::get('audit_get_oims_bank_info',
    [
        'uses'=>'AuditController@audit_get_oims_bank_info',
        'as'=>'audit_get_oims_bank_info',
        'role'=>'Audit'
    ]);

Route::get('audit-insert-arf-data',
    [
        'uses'=>'AuditController@audit_insert_arf_data',
        'as'=>'audit-insert-arf-data',
        'role'=>'Audit'
    ]);

Route::get('audit-download-ci-report-arf',
    [
        'uses'=>'AuditController@audit_download_ci_report_arf',
        'as'=>'audit-download-ci-report-arf',
        'role'=>'Audit'
    ]);

Route::get('audit-fetch-suggest-endo-id',
    [
        'uses'=>'AuditController@audit_fetch_suggest_endo_id',
        'as'=>'audit-fetch-suggest-endo-id',
        'role'=>'Audit'
    ]);

Route::get('audit-get-info-id-phone-field',
    [
        'uses'=>'AuditController@audit_get_info_id_phone_field',
        'as'=>'audit-get-info-id-phone-field',
        'role'=>'Audit'
    ]);

Route::post('audit-insert-phone-field-log',
    [
        'uses'=>'AuditController@audit_insert_phone_field_log',
        'as'=>'audit-insert-phone-field-log',
        'role'=>'Audit'
    ]);

Route::get('audit-report-monitoring-table',
    [
        'uses'=>'AuditController@audit_report_monitoring_table',
        'as'=>'audit-report-monitoring-table',
        'role'=>'Audit'
    ]);

Route::get('audit-get-all-audit-log-info',
    [
        'uses'=>'AuditController@audit_get_all_audit_log_info',
        'as'=>'audit-get-all-audit-log-info',
        'role'=>'Audit'
    ]);

Route::get('audit-approve-return-log',
    [
        'uses'=>'AuditController@audit_approve_return_log',
        'as'=>'audit-approve-return-log',
        'role'=>'Audit'
    ]);

Route::get('audit-get-access-show',
    [
        'uses'=>'AuditController@audit_get_access_show',
        'as'=>'audit-get-access-show',
        'role'=>'Audit'
    ]);

Route::get('audit_general_logs_table',
    [
        'uses'=>'AuditController@audit_general_logs_table',
        'as'=>'audit_general_logs_table',
        'role'=>'Audit'
    ]);

Route::get('audit-save-update-data',
    [
        'uses'=>'AuditController@audit_save_update_data',
        'as'=>'audit-save-update-data',
        'role'=>'Audit'
    ]);

Route::post('audit-save-update-phone-field-log',
    [
        'uses'=>'AuditController@audit_save_update_phone_field_log',
        'as'=>'audit-save-update-phone-field-log',
        'role'=>'Audit'
    ]);

Route::get('audit-save-update-cssf',
    [
        'uses'=>'AuditController@audit_save_update_cssf',
        'as'=>'audit-save-update-cssf',
        'role'=>'Audit'
    ]);

Route::get('audit-get-remarks-return',
    [
        'uses'=>'AuditController@audit_get_remarks_return',
        'as'=>' audit-get-remarks-return',
        'role'=>'Audit'
    ]);

Route::post('audit_tab6_upload',
    [
        'uses'=>'AuditController@audit_tab6_upload',
        'as'=>' audit_tab6_upload',
        'role'=>'Audit'
    ]);

Route::post('audit-upload-arf',
    [
        'uses'=>'AuditController@audit_upload_arf',
        'as'=> 'audit-upload-arf',
        'role'=>'Audit'
    ]);

Route::post('audit-insert-file-pf',
    [
        'uses'=>'AuditController@audit_insert_file_pf',
        'as'=> 'audit-insert-file-pf',
        'role'=>'Audit'
    ]);

Route::get('/view_report_form/{folder}/{path_file}', function($path_file, $folder)
{
    if(Auth::user()->hasRole('Audit'))
    {
        $decoded_path = base64_decode($path_file);
        $decoded_folder = base64_decode($folder);
        $path = storage_path($decoded_path . '/'. $decoded_folder);

        if (!File::exists($path)) {
            abort(404);
        }
        else
        {
            $filecount = glob("$path/*");

            $zipper = new Zipper();
            $this_is_test = $zipper->make(storage_path($decoded_folder).'.zip')->add($filecount)->getFilePath();
            $zipper->close();


            return response()->download($this_is_test)->deleteFileAfterSend();
        }
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }
});

Route::get('audit_partial_logs_table',
    [
        'uses'=>'AuditController@audit_partial_logs_table',
        'as'=>' audit_partial_logs_table',
        'role'=>'Audit'
    ]);

Route::get('audit-get-return-notif-count',
    [
        'uses'=>'AuditController@audit_get_return_notif_count',
        'as'=> 'audit-get-return-notif-count',
        'role'=>'Audit'
    ]);

Route::get('audit-clear-return-notif',
    [
        'uses'=>'AuditController@audit_clear_return_notif',
        'as'=> 'audit-clear-return-notif',
        'role'=>'Audit'
    ]);

Route::post('audit_discrepancy_fine_uploader/{get_id}',
    [
        'uses'=>'AuditController@audit_discrepancy_fine_uploader',
        'as'=> 'audit_discrepancy_fine_uploader',
        'role'=>'Audit'
    ]);

Route::post('audit_cirep_fine_uploader/{get_id}',
    [
        'uses'=>'AuditController@audit_cirep_fine_uploader',
        'as'=> 'audit_cirep_fine_uploader',
        'role'=>'Audit'
    ]);

Route::post('audit_field_fine_uploader/{get_id}',
    [
        'uses'=>'AuditController@audit_field_fine_uploader',
        'as'=> 'audit_field_fine_uploader',
        'role'=>'Audit'
    ]);

Route::get('audit_set_fine_uploader',
    [
        'uses'=>'AuditController@audit_set_fine_uploader',
        'as'=> 'audit_discrepancy_fine_uploader',
        'role'=>'Audit'
    ]);

Route::get('audit-view-attached/{log_id}/{file_name}',
    [
        'uses'=>'AuditController@audit_view_attached',
        'as'=> 'audit_view_attached',
        'role'=>'Audit'
    ]);

Route::get('audit-view-attached-ci-rep/{log_id}/{file_name}',
    [
        'uses'=>'AuditController@audit_view_attached_ci_rep',
        'as'=> 'audit_view_attached_ci_rep',
        'role'=>'Audit'
    ]);

Route::get('audit-view-attached-field/{log_id}/{file_name}',
    [
        'uses'=>'AuditController@audit_view_attached_field',
        'as'=> 'audit_view_attached_field',
        'role'=>'Audit'
    ]);
    
Route::get('audit_get_general_mon_table_ccbank',
    [
        'uses' => 'AuditController@audit_get_general_mon_table_ccbank',
        'as' => 'audit_get_general_mon_table_ccbank',
        'role' => 'Audit'
    ]);

Route::get('audit_get_general_mon_table_cc',
    [
        'uses' => 'AuditController@audit_get_general_mon_table_cc',
        'as' => 'audit_get_general_mon_table_cc',
        'role' => 'Audit'
    ]);





//===========================================FINANCE===========================================================

Route::get('/finance-dashboard',
    [
        'uses' => 'FinanceController@getFinanceDashboard',
        'as' => 'finance-dashboard',
        'role' => 'Finance'
    ]);

Route::get('/finance-panel',
    [
        'uses' => 'FinanceController@getFinancePanel',
        'as' => 'finance-panel',
        'role' => 'Finance'
    ]);

Route::get('/finance-report',
    [
        'uses' => 'FinanceController@getFinanceReport',
        'as' => 'finance-report',
        'role' => 'Finance'
    ]);

Route::get('/finance-table-report',
    [
        'uses' => 'FinanceController@tableGetFinanceReportTable',
        'as' => 'finance-table-report',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-fund-request',
    [
        'uses' => 'FinanceController@getFinanceCIFund',
        'as' => 'finance-ci-fund-request',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-fund-request-table',
    [
        'uses' => 'FinanceController@getCiFundRequest',
        'as' => 'finance-ci-fund-request-table',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-fund-request-table-approved',
    [
        'uses' => 'FinanceController@getCiFundRequestApproved',
        'as' => 'finance-ci-fund-request-table-approved',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-fund-request-table-declined',
    [
        'uses' => 'FinanceController@getCiFundRequestDeclined',
        'as' => 'finance-ci-fund-request-table-declined',
        'role' => 'Finance'
    ]);

Route::get('/finance-apporoved-req',
    [
        'uses' => 'FinanceController@FinanceApprovedReq',
        'as' => 'finance-apporoved-req',
        'role' => 'Finance'
    ]);

Route::get('/finance-declined-req',
    [
        'uses' => 'FinanceController@FinanceDeclinedReq',
        'as' => 'finance-declined-req',
        'role' => 'Finance'
    ]);

Route::get('/finance-deliver-remit-req',
    [
        'uses' => 'FinanceController@FinanceDeliverRemitReq',
        'as' => 'finance-deliver-remit-req',
        'role' => 'Finance'
    ]);

Route::get('/finance_get_remiitance_view',
    [
        'uses' => 'FinanceController@finance_get_remiitance_view',
        'as' => 'finance_get_remiitance_view',
        'role' => 'Finance'
    ]);

Route::get('/finance_update_remittance',
    [
        'uses' => 'FinanceController@finance_update_remittance',
        'as' => 'finance_update_remittance',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-receive-fund',
    [
        'uses' => 'FinanceController@BtnAddFundToCI',
        'as' => 'finance-ci-receive-fund',
        'role' => 'Finance'
    ]);


Route::get('/finance-ci-atm-management',
    [
        'uses' => 'FinanceController@financeGetViewAtmMngt',
        'as' => 'finance-ci-atm-management',
        'role' => 'Finance'
    ]);

Route::get('/finance-get-ci-atm-info',
    [
        'uses' => 'FinanceController@financeGetATMInfo',
        'as' => 'finance-get-ci-atm-info',
        'role' => 'Finance'
    ]);

Route::post('/finance-insert-ci-atm-info',
    [
        'uses' => 'FinanceController@financeInsertATMInfo',
        'as' => 'finance-insert-ci-atm-info',
        'role' => 'Finance'
    ]);

Route::get('/finance-modal-get-ci-atm-info',
    [
        'uses' => 'FinanceController@financeGetModalATMInfo',
        'as' => 'finance-modal-get-ci-atm-info',
        'role' => 'Finance'
    ]);

Route::post('/finance-update-ci-atm-info',
    [
        'uses' => 'FinanceController@financeUpdateModalATMInfo',
        'as' => 'finance-update-ci-atm-info',
        'role' => 'Finance'
    ]);

Route::post('/finance-delete-ci-atm-info',
    [
        'uses' => 'FinanceController@financeDeleteModalATMInfo',
        'as' => 'finance-delete-ci-atm-info',
        'role' => 'Finance'
    ]);

Route::get('/finance_pending_fund_details_endorsements',
    [
        'uses' => 'FinanceController@finance_pending_fund_details_endorsements',
        'as' => 'finance_pending_fund_details_endorsements',
        'role' => 'Finance'
    ]);

Route::get('/finance_app_fund_details_endorsements',
    [
        'uses' => 'FinanceController@finance_app_fund_details_endorsements',
        'as' => 'finance_app_fund_details_endorsements',
        'role' => 'Finance'
    ]);

Route::get('/finance_dec_fund_details_endorsements',
    [
        'uses' => 'FinanceController@finance_dec_fund_details_endorsements',
        'as' => 'finance_dec_fund_details_endorsements',
        'role' => 'Finance'
    ]);

Route::get('/finance_get_atm_list',
    [
        'uses' => 'FinanceController@finance_get_atm_list',
        'as' => 'finance_get_atm_list',
        'role' => 'Finance'
    ]);

Route::get('/finance_send_atm_fund',
    [
        'uses' => 'FinanceController@finance_send_atm_fund',
        'as' => 'finance_send_atm_fund',
        'role' => 'Finance'
    ]);

Route::get('/finance_get_atm_view',
    [
        'uses' => 'FinanceController@finance_get_atm_view',
        'as' => 'finance_get_atm_view',
        'role' => 'Finance'
    ]);

Route::get('/finance_atm_update_fund',
    [
        'uses' => 'FinanceController@finance_atm_update_fund',
        'as' => 'finance_atm_update_fund',
        'role' => 'Finance'
    ]);

Route::get('/finance_shell_card_include',
    [
        'uses' => 'FinanceController@finance_shell_card_include',
        'as' => 'finance_shell_card_include',
        'role' => 'Finance'
    ]);

Route::get('/finance_update_remittance_info',
    [
        'uses' => 'FinanceController@finance_update_remittance_info',
        'as' => 'finance_update_remittance_info',
        'role' => 'Finance'
    ]);

Route::get('/finance_update_realtime_remarks',
    [
        'uses' => 'FinanceController@finance_update_realtime_remarks',
        'as' => 'finance_update_realtime_remarks',
        'role' => 'Finance'
    ]);
Route::post('/finance-insert-ci-bank-shell',
    [
        'uses' => 'FinanceController@insertCiBank',
        'as' => 'finance-insert-ci-bank-shell',
        'role' => 'Finance'
    ]);
Route::get('/finance-get-ci-list',
    [
        'uses' => 'FinanceController@getCiList',
        'as' => 'finance-get-ci-list',
        'role' => 'Finance'
    ]);
Route::get('/finance-table-ci-bank',
    [
        'uses' => 'FinanceController@ciBankTable',
        'as' => 'finance-table-ci-bank',
        'role' => 'Finance'
    ]);

Route::get('/table_for_online_upload',
    [
        'uses' => 'FinanceController@table_for_online_upload',
        'as' => 'table_for_online_upload',
        'role' => 'Finance'
    ]);

Route::post('/finance_get_expenses_report_table',
    [
        'uses' => 'FinanceController@finance_get_expenses_report_table',
        'as' => 'finance_get_expenses_report_table',
        'role' => 'Finance'
    ]);

Route::post('/finance_btn_delete_this_atm',
    [
        'uses' => 'FinanceController@finance_btn_delete_this_atm',
        'as' => 'finance_btn_delete_this_atm',
        'role' => 'Finance'
    ]);

Route::get('/finance_download_file_expenses',
    [
        'uses' => 'FinanceController@finance_download_file_expenses',
        'as' => 'finance_download_file_expenses',
        'role' => 'Finance'
    ]);
Route::get('/finance-check-shell-ci',
    [
        'uses' => 'FinanceController@finance_check_shell_ci',
        'as' => 'finance-check-shell-ci',
        'role' => 'Finance'
    ]);
Route::get('/finance-check-shell-ci',
    [
        'uses' => 'FinanceController@finance_check_shell_ci',
        'as' => 'finance-check-shell-ci',
        'role' => 'Finance'
    ]);
Route::get('/finance-overall-fund-rem-atm',
    [
        'uses' => 'FinanceController@finance_overall_fund_rem_atm',
        'as' => 'finance-overall-fund-rem-atm',
        'role' => 'Finance'
    ]);
Route::get('/finance-get-all-bank',
    [
        'uses' => 'FinanceController@finance_get_all_bank',
        'as' => 'finance-get-all-bank',
        'role' => 'Finance'
    ]);
Route::get('/finance-get-access',
    [
        'uses' => 'FinanceController@finance_get_access',
        'as' => 'finance-get-access',
        'role' => 'Finance'
    ]);
Route::get('/finance-ci-fund-request-table-success',
    [
        'uses' => 'FinanceController@getFundSuccessReq',
        'as' => 'finance-ci-fund-request-table-success',
        'role' => 'Finance'
    ]);
Route::get('/finance-get-incident-rem',
    [
        'uses' => 'FinanceController@finance_get_incident_rem',
        'as' => 'finance-get-incident-rem',
        'role' => 'Finance'
    ]);
Route::get('/finance-send-re-approve-req',
    [
        'uses' => 'FinanceController@finance_send_re_approve_req',
        'as' => 'finance-send-re-approve-req',
        'role' => 'Finance'
    ]);
Route::get('/finance-set-done-approve-req',
    [
        'uses' => 'FinanceController@finance_set_done_approve_req',
        'as' => 'finance-set-done-approve-req',
        'role' => 'Finance'
    ]);

Route::get('/finance-ci-fund-request-table-fa',
    [
        'uses' => 'FinanceController@finance_ci_fund_request_table_fa',
        'as' => 'finance-ci-fund-request-table-fa',
        'role' => 'Finance'
    ]);

Route::get('/finance-get-img-liq-fund',
    [
        'uses' => 'FinanceController@finance_get_img_liq_fund',
        'as' => 'finance-get-img-liq-fund',
        'role' => 'Finance'
    ]);

Route::get('/getuploaded/{encodedfile}/{path}', function($encodedfile, $path)
{
//    if(Auth::user()->hasRole('Finance') || Auth::user()->hasRole('C.I Supervisor') || Auth::user()->hasRole('Dispatcher') || Auth::user()->hasRole('Senior Account Officer'))
    if(Auth::user() != null)
    {
        $decPath = base64_decode($encodedfile);
        $newPath = utf8_encode(base64_decode($path));

        $path = storage_path($newPath);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
//    else if(Auth::user()->hasRole('Audit'))
//    {
//        $decPath = base64_decode($encodedfile);
//        $newPath = base64_decode($path);
//
//        $path = storage_path($newPath);
//
//        if (!File::exists($path)) {
//            abort(404);
//        }
//
//        $file = File::get($path);
//        $type = File::mimeType($path);
//
//        $response = Response::make($file, 200);
//        $response->header("Content-Type", $type);
//
//        return $response;
//    }
    else
    {
        return 'bro you are in a wrong way.....';
    }

//    echo '<image src = storage/Desert.jpg>';
});

Route::get('/getuploaded-2/{encodedfile}/{path}', function($encodedfile, $path)
{
    if(Auth::user() != null)
    {
        $decPath = base64_decode($encodedfile);
        $newPath = base64_decode($path);

        $path = storage_path(utf8_encode($newPath));

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }

//    echo '<image src = storage/Desert.jpg>';
});

Route::get('/finance-done-online-fund',
    [
        'uses' => 'FinanceController@finance_done_online_fund',
        'as' => 'finance-done-online-fund',
        'role' => 'Finance'
    ]);

Route::post('/finance-done-all-fund-selected',
    [
        'uses' => 'FinanceController@finance_done_all_fund_selected',
        'as' => 'finance-done-all-fund-selected',
        'role' => 'Finance'
    ]);

Route::get('/finance-get-fund-count',
    [
        'uses' => 'FinanceController@finance_get_fund_count',
        'as' => 'finance-get-fund-count',
        'role' => 'Finance'
    ]);

Route::post('finance-upload-bulk-excel',
    [
        'uses' => 'FinanceController@finance_upload_bulk_excel',
        'as' => 'finance-upload-bulk-excel',
        'role' => 'Finance'
    ]);

Route::get('/finance-hold-ci-fund',
    [
        'uses' => 'FinanceController@finance_hold_ci_fund',
        'as' => 'finance-hold-ci-fund',
        'role' => 'Finance'
    ]);

Route::get('/finance-cancel-ci-fund',
    [
        'uses' => 'FinanceController@finance_cancel_ci_fund',
        'as' => 'finance-cancel-ci-fund',
        'role' => 'Finance'
    ]);

Route::get('/finance-unhold-ci-fund',
    [
        'uses' => 'FinanceController@finance_unhold_ci_fund',
        'as' => 'finance-unhold-ci-fund',
        'role' => 'Finance'
    ]);

Route::get('/finance-revise-fund-request',
    [
        'uses' => 'FinanceController@finance_revise_fund_request',
        'as' => 'finance-revise-fund-request',
        'role' => 'Finance'
    ]);

Route::get('/finance_billing_coborrower_same_add_checker',
    [
        'uses' => 'FinanceController@finance_billing_coborrower_same_add_checker',
        'as' => 'finance_billing_coborrower_same_add_checker',
        'role' => 'Finance'
    ]);


//Route::get('finance_get_audit_remarks',
//    [
//        'uses'=>'FinanceController@finance_get_audit_remarks',
//        'as'=>'finance_get_audit_remarks',
//        'role'=>'Finance'
//    ]);

Route::get('/finance-get-manage-list',
    [
        'uses' => 'FinanceController@finance_get_manage_list',
        'as' => 'ffinance-get-manage-list',
        'role' => 'Finance'
    ]);

Route::get('/finance_fund_get_requestor_remarks',
    [
        'uses' => 'FinanceController@finance_fund_get_requestor_remarks',
        'as' => 'finance_fund_get_requestor_remarks',
        'role' => 'Finance'
    ]);

Route::get('finance_edit_ci_expenses',
    [
        'uses' => 'FinanceController@finance_edit_ci_expenses',
        'as' => 'finance_edit_ci_expenses',
        'role' => 'Finance'
    ]);

Route::get('finance_cancel_fund_request',
    [
        'uses' => 'FinanceController@finance_cancel_fund_request',
        'as' => 'finance_cancel_fund_request',
        'role' => 'Finance'
    ]);

Route::get('finance_get_audit_remarks',
    [
        'uses' => 'FinanceController@finance_get_audit_remarks',
        'as' => 'finance_get_audit_remarks',
        'role' => 'Finance'
    ]);

Route::get('finance_get_audit_remarks',
    [
        'uses' => 'FinanceController@finance_get_audit_remarks',
        'as' => 'finance_get_audit_remarks',
        'role' => 'Finance'
    ]);

Route::get('finance_eq_proc_pending_table',
    [
        'uses' => 'FinanceController@finance_eq_proc_pending_table',
        'as' => 'finance_eq_proc_pending_table',
        'role' => 'Finance'
    ]);

Route::get('finance_get_po_details',
    [
        'uses' => 'FinanceController@finance_get_po_details',
        'as' => 'finance_get_po_details',
        'role' => 'Finance'
    ]);

Route::post('finance_requisition_add_instruction',
    [
        'uses' => 'FinanceController@finance_requisition_add_instruction',
        'as' => 'finance_requisition_add_instruction',
        'role' => 'Finance'
    ]);

Route::get('finance_eq_proc_done_table',
    [
        'uses' => 'FinanceController@finance_eq_proc_done_table',
        'as' => 'finance_eq_proc_done_table',
        'role' => 'Finance'
    ]);
    
Route::get('/finance-billing-management',
    [
        'uses' => 'FinanceController@tableGetBillingManage',
        'as' => 'billing-management',
        'role' => 'Finance'
    ]);
    
Route::get('cc_billing_report_table',
    [
        'uses' => 'FinanceController@cc_billing_report_table',
        'as' => 'cc_billing_report_table',
        'role' => 'Finance'
    ]);

Route::get('cc_bank_billing_report_table',
    [
        'uses' => 'FinanceController@cc_bank_billing_report_table',
        'as' => 'cc_bank_billing_report_table',
        'role' => 'Finance'
    ]);

Route::get('finance_create_billing_invoice',
    [
        'uses' => 'FinanceController@finance_create_billing_invoice',
        'as' => 'finance_create_billing_invoice',
        'role' => 'Finance'
    ]);




//========================================ADMIN STAFF==========================================================



Route::get('/admin-staff-panel',
    [
        'uses' => 'AdminStaffController@getAdminStaffPanel',
        'as' => 'admin-staff-panel',
        'role' => 'Admin Staff'
    ]);

// admin staff table

Route::get('/admin-staff-table-reports',
    [
        'uses' => 'AdminStaffController@adminStaffTable',
        'as' => 'admin-staff-table-reports',
        'role' => 'Admin Staff'
    ]);

Route::get('/admin-staff-submit-request',
    [
        'uses' => 'AdminStaffController@adminStaffSubmit',
        'as' => 'admin-staff-submit-request',
        'role' => 'Admin Staff'
    ]);


Route::get('/admin-staff-hold-request',
    [
        'uses' => 'AdminStaffController@adminStaffHold',
        'as' => 'admin-staff-hold-request',
        'role' => 'Admin Staff'
    ]);

Route::get('/admin-staff-cancel-request',
    [
        'uses' => 'AdminStaffController@adminStaffCancel',
        'as' => 'admin-staff-cancel-request',
        'role' => 'Admin Staff'
    ]);


Route::get('/admin-staff-table-submitted-status',
    [
        'uses' => 'AdminStaffController@adminStaffSubmitStatusTable',
        'as' => 'admin-staff-table-submitted',
        'role' => 'Admin Staff'
    ]);


Route::get('/admin-staff-table-hold-status',
    [
        'uses' => 'AdminStaffController@adminStaffHoldStatusTable',
        'as' => 'admin-staff-table-hold-status',
        'role' => 'Admin Staff'
    ]);

Route::get('/admin-staff-table-cancel-status',
    [
        'uses' => 'AdminStaffController@adminStaffCancelStatusTable',
        'as' => 'admin-staff-table-cancel-status',
        'role' => 'Admin Staff'
    ]);

Route::post('admin-staff-add-supplier-existing-category',
    [
        'uses' => 'AdminStaffController@adminStaffAddSupplierExistingCategory',
        'as' => 'admin-staff-add-supplier-existing-category',
        'role' => 'Admin Staff'
    ]);

Route::post('admin-staff-add-supplier-new-category',
    [
        'uses' => 'AdminStaffController@adminStaffAddSupplierNewCategory',
        'as' => 'admin-staff-add-supplier-new-category',
        'role' => 'Admin Staff'
    ]);


Route::get('admin-staff-supplier-table',
    [
        'uses' => 'AdminStaffController@adminStaffSupplierTable',
        'as' => 'admin-staff-supplier-table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-get-category',
    [
        'uses' => 'AdminStaffController@adminStaffGetCategory',
        'as' => 'admin-staff-get-category',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-check-existing',
    [
        'uses' => 'AdminStaffController@adminStaffCheckCategory',
        'as' => 'admin-staff-check-existing',
        'role' => 'Admin Staff'
    ]);

Route::post('admin-staff-create-item-profile',
    [
        'uses' => 'AdminStaffController@AddItemProfile',
        'as' => 'admin-staff-create-item-profile',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-item-profile',
    [
        'uses' => 'AdminStaffController@showItemProfile',
        'as' => 'admin-staff-item-profile',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-fetch-item',
    [
        'uses' => 'AdminStaffController@fetchItemDetails',
        'as' => 'admin-staff-fetch-item',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-available-item',
    [
        'uses' => 'AdminStaffController@showAvailable',
        'as' => 'admin-staff-available-item',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-emp-item',
    [
        'uses' => 'AdminStaffController@fetchItemsEmp',
        'as' => 'admin-staff-emp-item',
        'role' => 'Admin Staff'
    ]);
Route::get('admin_staff_assign_to_emp',
    [
        'uses' => 'AdminStaffController@assigntoEmp',
        'as' => 'admin_staff_assign_to_emp',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-remove-assigned',
    [
        'uses' => 'AdminStaffController@removeAssign',
        'as' => 'admin-staff-remove-assigned',
        'role' => 'Admin Staff'
    ]);

Route::post('admin_staff_ar_upload',
    [
        'uses' => 'AdminStaffController@admin_staff_ar_upload',
        'as' => 'admin_staff_ar_upload',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-ar-table',
    [
        'uses' => 'AdminStaffController@admin_staff_ar_table',
        'as' => 'admin_staff_ar_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_get_ar_description',
    [
        'uses' => 'AdminStaffController@admin_get_ar_description',
        'as' => 'admin_get_ar_description',
        'role' => 'Admin Staff'
    ]);

Route::get('/view_ar/{path_file}', function($path_file)
{
    if(Auth::user()->hasRole('Admin Staff'))
    {
        $decoded = base64_decode($path_file);

        $path = storage_path('' . $decoded .'');

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type_a = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type_a);

        return $response;
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }

//    echo '<image src = storage/Desert.jpg>';

});

Route::get('admin-staff-item-history',
    [
        'uses' => 'AdminStaffController@itemHistory',
        'as' => 'admin-staff-item-history',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-ar-logs',
    [
        'uses' => 'AdminStaffController@ArLogs',
        'as' => 'admin-staff-ar-logs',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-file-download',
    [
        'uses' => 'AdminStaffController@PoDownload',
        'as' => 'admin-staff-file-download',
        'role' => 'Admin Staff'
    ]);
Route::post('admin-staff-update-item-profile',
    [
        'uses' => 'AdminStaffController@updateItem',
        'as' => 'admin-staff-update-item-profile',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-view-ar-assigned',
    [
        'uses' => 'AdminStaffController@arAssigned',
        'as' => 'admin-staff-view-ar-assigned',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-assign-to-ar',
    [
        'uses' => 'AdminStaffController@arTableItem',
        'as' => 'admin-staff-assign-to-ar',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-fund-request',
    [
        'uses' => 'AdminStaffController@fundRequest',
        'as' => 'admin-staff-fund-request',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-fund-table',
    [
        'uses' => 'AdminStaffController@fundTable',
        'as' => 'admin-staff-fund-table',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-get-fund',
    [
        'uses' => 'AdminStaffController@fundGet',
        'as' => 'admin-staff-get-fund',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-update-fund',
    [
        'uses' => 'AdminStaffController@fundUpdate',
        'as' => 'admin-staff-update-fund',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-delete-fund',
    [
        'uses' => 'AdminStaffController@fundRemove',
        'as' => 'admin-staff-delete-fund',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-outgoing-emp',
    [
        'uses' => 'AdminStaffController@outgoingEmpItems',
        'as' => 'admin-staff-outgoing-emp',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-auth-view',
    [
        'uses' => 'AdminStaffController@getAuth',
        'as' => 'admin-staff-auth-view',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-update-specs-stat',
    [
        'uses' => 'AdminStaffController@updateSpecStat',
        'as' => 'admin-staff-update-specs-stat',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-update-specs-stat',
    [
        'uses' => 'AdminStaffController@updateSpecStat',
        'as' => 'admin-staff-update-specs-stat',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-general-request',
    [
        'uses' => 'AdminStaffController@generalRequestTable',
        'as' => 'admin-staff-general-request',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-get-details-item',
    [
        'uses' => 'AdminStaffController@getItemDetails',
        'as' => 'admin-staff-get-details-item',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-po-view',
    [
        'uses' => 'AdminStaffController@poTable',
        'as' => 'admin-staff-po-view',
        'role' => 'Admin Staff'
    ]);
Route::get('/view_po/{path_file}', function($path_file)
{
    if(Auth::user()->hasRole('Admin Staff'))
    {

        if (!File::exists($path_file)) {
            abort(404);
        }

        $file = File::get($path_file);
        $type_a = File::mimeType($path_file);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type_a);

        return $response;
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }

//    echo '<image src = storage/Desert.jpg>';

});
Route::get('admin-staff-warranty-download',
    [
        'uses' => 'AdminStaffController@dlWarranty',
        'as' => 'admin-staff-warranty-download',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-quot-download',
    [
        'uses' => 'AdminStaffController@dlQuote',
        'as' => 'admin-staff-quot-download',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-supp-download',
    [
        'uses' => 'AdminStaffController@dlSupp',
        'as' => 'admin-staff-supp-download',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-total-req',
    [
        'uses' => 'AdminStaffController@totalReq',
        'as' => 'admin-staff-total-req',
        'role' => 'Admin Staff'
    ]);
Route::get('admin-staff-doc-format',
    [
        'uses' => 'AdminStaffController@dlFormat',
        'as' => 'admin-staff-doc-format',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_bi_change_bi_view_table',
    [
        'uses' => 'AdminController@admin_bi_change_bi_view_table',
        'as' => 'admin_bi_change_bi_view_table',
        'role' => 'Administrator'
    ]);

Route::get('admin_update_bi_default_view',
    [
        'uses' => 'AdminController@admin_update_bi_default_view',
        'as' => 'admin_update_bi_default_view',
        'role' => 'Administrator'
    ]);

Route::get('admin_delete_bi_view',
    [
        'uses' => 'AdminController@admin_delete_bi_view',
        'as' => 'admin_delete_bi_view',
        'role' => 'Administrator'
    ]);

Route::get('admin_add_viewable_to_bi',
    [
        'uses' => 'AdminController@admin_add_viewable_to_bi',
        'as' => 'admin_add_viewable_to_bi',
        'role' => 'Administrator'
    ]);

Route::post('admin-staff-general-upload-mult',
    [
        'uses' => 'AdminStaffController@admin_staff_general_upload_mult',
        'as' => 'admin-staff-general-upload-mult',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-employee-table',
    [
        'uses' => 'AdminStaffController@admin_staff_employee_table',
        'as' => 'admin-staff-employee-table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-get-employees-not-approve',
    [
        'uses' => 'AdminStaffController@admin_staff_get_employees_not_approve',
        'as' => 'admin-staff-get-employees-not-approve',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-employee-appprove-table',
    [
        'uses' => 'AdminStaffController@admin_staff_employee_appprove_table',
        'as' => 'admin-staff-employee-appprove-table',
        'role' => 'Admin Staff'
    ]);
    
Route::get('admin_staff_archive_general_files',
    [
        'uses' => 'AdminStaffController@admin_staff_archive_general_files',
        'as' => 'admin_staff_archive_general_files',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_archieved_general_forms_table',
    [
        'uses' => 'AdminStaffController@admin_staff_archieved_general_forms_table',
        'as' => 'admin_staff_archieved_general_forms_table',
        'role' => 'Admin Staff'
    ]);

Route::post('monitoring_generate_barcodes',
    [
        'uses' => 'AdminStaffController@monitoring_generate_barcodes',
        'as' => 'monitoring_generate_barcodes',
        'role' => 'Admin Staff'
    ]);

Route::get('qr-code/{barcode}', function ($barcode ,Request $request)
{
//    return QRCode::text('Please click the link below: <br><br><br> http://www.ccsi-oims.net/suresend/public_html/confirm_barcode_linker?code='.base64_encode($barcode))->png();
    $image = QrCode::format('png')
        ->merge(public_path('dist/img/ccsi-icon.png'), 0.4, true)
        ->size(500)->errorCorrection('H')
//        ->generate('http://192.168.1.7/barcode-item?code='.base64_encode(gzdeflate($barcode)));
        ->generate($request->root().'/barcode-item?code='.base64_encode(gzdeflate($barcode)));

    if(Auth::user() != null)
    {
        return response($image)->header('Content-type','image/png');
    }
    else
    {
        return abort(404);
    }
    
});

Route::get('admin_staff_encode_item_login',
    [
        'uses' => 'AdminStaffController@admin_staff_encode_item_login',
        'as' => 'admin_staff_encode_item_login',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_submit_item_to_inventory',
    [
        'uses' => 'AdminStaffController@admin_staff_submit_item_to_inventory',
        'as' => 'admin_staff_submit_item_to_inventory',
        'role' => 'Admin Staff'
    ]);

Route::post('/admin_staff_upload_pictures_fine/{bar_code}',
    [
        'uses' => 'AdminStaffController@admin_staff_upload_pictures_fine',
        'as' => 'admin_staff_upload_pictures_fine'
    ]);

Route::get('admin_staff_get_item_history',
    [
        'uses' => 'AdminStaffController@admin_staff_get_item_history',
        'as' => 'admin_staff_get_item_history',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_update_item_to_inventory',
    [
        'uses' => 'AdminStaffController@admin_staff_update_item_to_inventory',
        'as' => 'admin_staff_update_item_to_inventory',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_nation_wide_inventory',
    [
        'uses' => 'AdminStaffController@admin_staff_nation_wide_inventory',
        'as' => 'admin_staff_nation_wide_inventory',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_getProv',
    [
        'uses' => 'AdminStaffController@admin_staff_getProv',
        'as' => 'admin_staff_getProv',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_get_all_latest_item_pic',
    [
        'uses' => 'AdminStaffController@admin_get_all_latest_item_pic',
        'as' => 'admin_get_all_latest_item_pic',
        'role' => 'Admin Staff'
    ]);

Route::post('admin_staff_update_item_status',
    [
        'uses' => 'AdminStaffController@admin_staff_update_item_status',
        'as' => 'admin_staff_update_item_status',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_get_logs_invent',
    [
        'uses' => 'AdminStaffController@admin_staff_get_logs_invent',
        'as' => 'admin_staff_get_logs_invent',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_quantity_mon_table',
    [
        'uses' => 'AdminStaffController@admin_staff_quantity_mon_table',
        'as' => 'admin_staff_quantity_mon_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_availability_mon_table',
    [
        'uses' => 'AdminStaffController@admin_staff_availability_mon_table',
        'as' => 'admin_staff_availability_mon_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_view_items_to_remove_table',
    [
        'uses' => 'AdminStaffController@admin_staff_view_items_to_remove_table',
        'as' => 'admin_staff_view_items_to_remove_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_delete_item_name',
    [
        'uses' => 'AdminStaffController@admin_staff_delete_item_name',
        'as' => 'admin_staff_delete_item_name',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_add_item_to_nationwide_names',
    [
        'uses' => 'AdminStaffController@admin_staff_add_item_to_nationwide_names',
        'as' => 'admin_staff_add_item_to_nationwide_names',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-requi-table',
    [
        'uses' => 'AdminStaffController@admin_staff_requi_table',
        'as' => 'admin-staff-requi-table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-get-details-requisition',
    [
        'uses' => 'AdminStaffController@admin_staff_get_details_requisition',
        'as' => 'admin-staff-get-details-requisition',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_approve_requi',
    [
        'uses' => 'AdminStaffController@admin_staff_approve_requi',
        'as' => 'admin_staff_approve_requi',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-requi-table-approved',
    [
        'uses' => 'AdminStaffController@admin_staff_requi_table_approved',
        'as' => 'admin-staff-requi-table-approved',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-requi-table-denied',
    [
        'uses' => 'AdminStaffController@admin_staff_requi_table_denied',
        'as' => 'admin-staff-requi-table-denied',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-deny-requi',
    [
        'uses' => 'AdminStaffController@admin_staff_deny_requi',
        'as' => 'admin-staff-deny-requi',
        'role' => 'Admin Staff'
    ]);

Route::post('admin-staff-submit-accred-sup',
    [
        'uses' => 'AdminStaffController@admin_staff_submit_accred_sup',
        'as' => 'admin-staff-submit-accred-sup',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-accred-sup-table',
    [
        'uses' => 'AdminStaffController@admin_staff_accred_sup_table',
        'as' => 'admin-staff-accred-sup-table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-get-indiv-accred',
    [
        'uses' => 'AdminStaffController@admin_staff_get_indiv_accred',
        'as' => 'admin-staff-get-indiv-accred',
        'role' => 'Admin Staff'
    ]);

Route::get('view-accredited-sup-file', function(Request $request)
{
    $id = base64_decode($request->id);
    $filename = base64_decode($request->n);
    $path_file = storage_path('accredited_suppliers/' . $id . '/' . $filename);

//    $fileChecker = explode('.', $filename);

    if(Auth::user()->hasRole('Admin Staff') || Auth::user()->hasRole('Management'))
    {
        return response()->download($path_file);

//        if(array_pop($fileChecker) == 'pdf' || array_pop($fileChecker) == 'jpeg' || array_pop($fileChecker) == 'jpg' || array_pop($fileChecker) == 'png')
//        {
//            if (!File::exists($path_file)) {
//                abort(404);
//            }
//
//            $file = File::get($path_file);
//            $type_a = File::mimeType($path_file);
//
//            $response = Response::make($file, 200);
//            $response->header("Content-Type", $type_a);
//
//            return $response;
//        }
//        else
//        {
//            echo '<script>alert(\'No preview available.\'); window.close();</script>';
//        }

    }
    else
    {
        return 'bro you are in a wrong way.....';
    }
});

Route::get('admin_staff_remove_selected_supplier_file',
    [
        'uses' => 'AdminStaffController@admin_staff_remove_selected_supplier_file',
        'as' => 'admin_staff_remove_selected_supplier_file',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_eq_proc_table',
    [
        'uses' => 'AdminStaffController@admin_staff_eq_proc_table',
        'as' => 'admin_staff_eq_proc_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-sup-list-for-po',
    [
        'uses' => 'AdminStaffController@admin_staff_sup_list_for_po',
        'as' => 'admin-staff-sup-list-for-po',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-get-info-accred-to-po',
    [
        'uses' => 'AdminStaffController@admin_staff_get_info_accred_to_po',
        'as' => 'admin-staff-get-info-accred-to-po',
        'role' => 'Admin Staff'
    ]);


Route::post('admin-staff-insert-po-final',
    [
        'uses' => 'AdminStaffController@admin_staff_insert_po_final',
        'as' => 'admin-staff-insert-po-final',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_eq_proc_table_finance',
    [
        'uses' => 'AdminStaffController@admin_staff_eq_proc_table_finance',
        'as' => 'admin_staff_eq_proc_table_finance',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_get_attach_rem_fin',
    [
        'uses' => 'AdminStaffController@admin_staff_get_attach_rem_fin',
        'as' => 'admin_staff_get_attach_rem_fin',
        'role' => 'Admin Staff'
    ]);

Route::get('view-requi-file', function(Request $request)
{
    $id = base64_decode($request->id);
    $filename = base64_decode($request->n);
    $path_file = storage_path('admin_requi_finance_files/' . $id . '/' . $filename);

//    $fileChecker = explode('.', $filename);

    if(Auth::user()->hasRole('Admin Staff') || Auth::user()->hasRole('Finance'))
    {
        return response()->download($path_file);

//        if(array_pop($fileChecker) == 'pdf' || array_pop($fileChecker) == 'jpeg' || array_pop($fileChecker) == 'jpg' || array_pop($fileChecker) == 'png')
//        {
//            if (!File::exists($path_file)) {
//                abort(404);
//            }
//
//            $file = File::get($path_file);
//            $type_a = File::mimeType($path_file);
//
//            $response = Response::make($file, 200);
//            $response->header("Content-Type", $type_a);
//
//            return $response;
//        }
//        else
//        {
//            echo '<script>alert(\'No preview available.\'); window.close();</script>';
//        }

    }
    else
    {
        return 'bro you are in a wrong way.....';
    }
});

Route::get('admin_staff_change_to_done_requi',
    [
        'uses' => 'AdminStaffController@admin_staff_change_to_done_requi',
        'as' => 'admin_staff_change_to_done_requi',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_gen_requi_table',
    [
        'uses' => 'AdminStaffController@admin_staff_gen_requi_table',
        'as' => 'admin_staff_gen_requi_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_eq_proc_done_table',
    [
        'uses' => 'AdminStaffController@admin_staff_eq_proc_done_table',
        'as' => 'admin_staff_eq_proc_done_table',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-accred-for-compa-table',
    [
        'uses' => 'AdminStaffController@admin_staff_accred_for_compa_table',
        'as' => 'admin-staff-accred-for-compa-table',
        'role' => 'Admin Staff'
    ]);

Route::post('admin_staff_submit_management_approval',
    [
        'uses' => 'AdminStaffController@admin_staff_submit_management_approval',
        'as' => 'admin_staff_submit_management_approval',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_monit_sup_approval',
    [
        'uses' => 'AdminStaffController@admin_staff_monit_sup_approval',
        'as' => 'admin_staff_monit_sup_approval',
        'role' => 'Admin Staff'
    ]);

Route::get('admin-staff-accred-sup-table-denied',
    [
        'uses' => 'AdminStaffController@admin_staff_accred_sup_table_denied',
        'as' => 'admin-staff-accred-sup-table-denied',
        'role' => 'Admin Staff'
    ]);

Route::get('admin_staff_get_management_info_app',
    [
        'uses' => 'AdminStaffController@admin_staff_get_management_info_app',
        'as' => 'admin_staff_get_management_info_app',
        'role' => 'Admin Staff'
    ]);

Route::post('admin_send_ar_notif',
    [
        'uses' => 'AdminStaffController@admin_send_ar_notif',
        'as' => 'admin_send_ar_notif',
        'role' => 'Admin Staff'
    ]);

Route::get('/fetch-acknowledge-names',
    [
        'uses' => 'AdminStaffController@acknowledge_names',
        'as' => 'fetch-acknowledge-names',
        'role'  => 'AdminStaff'
    ]);

Route::get('get_ar_monitoring',
    [
        'uses' => 'AdminStaffController@get_ar_monitoring',
        'as' => 'get_ar_monitoring',
        'role' => 'AdminStaff'
    ]);

Route::get('get_ar_monitoring_table',
    [
        'uses' => 'AdminStaffController@get_ar_monitoring_table',
        'as' => 'get_ar_monitoring_table',
        'role' => 'AdminStaff'
    ]);

Route::get('fetch-ar-monitoring',
    [
        'uses' => 'AdminStaffController@fetch_ar_monitoring',
        'as' => 'fetch-ar-monitoring',
        'role' => 'AdminStaff'
    ]);
    
//===========================================MAIL ROUTE========================================================

Route::get('sendhtmlemail', 'MailController@html_email');
Route::get('sendattachmentemail', 'MailController@attachment_email');


//===========================================HUMAN RESOURCES ROUTE=============================================


Route::get('human-resources-panel',
    [
        'uses' => 'HumanResourcesController@humanResourcesPanel',
        'as' => 'human-resources-panel',
        'role' => 'HumanResources'
    ]);

Route::post('human-resources-create-profile',
    [
        'uses' => 'HumanResourcesController@createProfile',
        'as' => 'human-resources-create-profile',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-branch',
    [
        'uses' => 'HumanResourcesController@getBranch',
        'as' => 'human-resources-get-branch',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-employees',
    [
        'uses' => 'HumanResourcesController@getEmployees',
        'as' => 'human-resources-get-employees',
        'role' => 'HumanResources'
    ]);

Route::post('human-resources-add-work-exp',
    [
        'uses' => 'HumanResourcesController@addExperience',
        'as' => 'human-resources-add-work-exp',
        'role' => 'HumanResources'
    ]);

Route::post('human-resources-add-educ',
    [
        'uses' => 'HumanResourcesController@AddEduc',
        'as' => 'human-resources-add-educ',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-add-ref',
    [
        'uses' => 'HumanResourcesController@AddRef',
        'as' => 'human-resources-add-ref',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-employee-table',
    [
        'uses' => 'HumanResourcesController@showEmployee',
        'as' => 'human-resources-employee-table',
        'role' => 'HumanResources'
    ]);

Route::get('human_resources_show_profile',
    [
        'uses' => 'HumanResourcesController@showProfile',
        'as' => 'human_resources_show_profile',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-show-exp',
    [
        'uses' => 'HumanResourcesController@showExp',
        'as' => 'human-resources-employee-show-exp',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-employee-show-educ',
    [
        'uses' => 'HumanResourcesController@showEduc',
        'as' => 'human-resources-employee-show-educ',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-show-char',
    [
        'uses' => 'HumanResourcesController@showChar',
        'as' => 'human-resources-employee-show-char',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-delete-exp',
    [
        'uses' => 'HumanResourcesController@deleteExp',
        'as' => 'human-resources-delete-exp',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-delete-educ',
    [
        'uses' => 'HumanResourcesController@deleteEduc',
        'as' => 'human-resources-delete-educ',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-delete-char',
    [
        'uses' => 'HumanResourcesController@deleteChar',
        'as' => 'human-resources-delete-char',
        'role' => 'HumanResources'
    ]);
Route::get('human_resources_update_profile',
    [
        'uses' => 'HumanResourcesController@UpdateShow',
        'as' => 'human_resources_update_profile',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-update-profile',
    [
        'uses' => 'HumanResourcesController@updateProfile',
        'as' => 'human-resources-update-profile',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-edit-exp',
    [
        'uses' => 'HumanResourcesController@updateExp',
        'as' => 'human-resources-edit-exp',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-edit-educ',
    [
        'uses' => 'HumanResourcesController@updateEduc',
        'as' => 'human-resources-edit-educ',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-edit-ref',
    [
        'uses' => 'HumanResourcesController@updateRef',
        'as' => 'human-resources-edit-ref',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-contract',
    [
        'uses' => 'HumanResourcesController@getContract',
        'as' => 'human-resources-get-contract',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-update-con-stat',
    [
        'uses' => 'HumanResourcesController@contractStat',
        'as' => 'human-resources-update-con-stat',
        'role' => 'HumanResources'
    ]);
Route::get('human_resources_get_branch_sched',
    [
        'uses' => 'HumanResourcesController@getSchedBranch',
        'as' => 'human_resources_get_branch_sched',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-file-download',
    [
        'uses' => 'HumanResourcesController@fileDownload',
        'as' => 'human_resources-file-download',
        'role' => 'HumanResources'
    ]);
Route::get('human_resources-dash-data',
    [
        'uses' => 'HumanResourcesController@dashData',
        'as' => 'human_resources-dash-data',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-items',
    [
        'uses' => 'HumanResourcesController@assignedItems',
        'as' => 'human-resources-employee-items',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-position',
    [
        'uses' => 'HumanResourcesController@getPos',
        'as' => 'human-resources-get-position',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-prov',
    [
        'uses' => 'HumanResourcesController@getProv',
        'as' => 'human-resources-get-prov',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-logs',
    [
        'uses' => 'HumanResourcesController@profLogs',
        'as' => 'human-resources-logs',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-motor',
    [
        'uses' => 'HumanResourcesController@motorAdd',
        'as' => 'human-resources-motor',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-motor-list',
    [
        'uses' => 'HumanResourcesController@motorList',
        'as' => 'human-resources-motor-list',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-motor-edit',
    [
        'uses' => 'HumanResourcesController@motorEdit',
        'as' => 'human-resources-motor-edit',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-update-motor',
    [
        'uses' => 'HumanResourcesController@motorUpdate',
        'as' => 'human-resources-update-motor',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-motor-delete',
    [
        'uses' => 'HumanResourcesController@motorDelete',
        'as' => 'human-resources-motor-delete',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-atm',
    [
        'uses' => 'HumanResourcesController@atmGet',
        'as' => 'human-resources-get-atm',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-update-atm',
    [
        'uses' => 'HumanResourcesController@atmUpdate',
        'as' => 'human-resources-update-atm',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-atm-table',
    [
        'uses' => 'HumanResourcesController@atmTable',
        'as' => 'human-resources-atm-table',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-supp-doc-desc',
    [
        'uses' => 'HumanResourcesController@posDocDesc',
        'as' => 'human-resources-supp-doc-desc',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-pos-cancel',
    [
        'uses' => 'HumanResourcesController@cancelPos',
        'as' => 'human-resources-pos-cancel',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-get-oims',
    [
        'uses' => 'HumanResourcesController@getOims',
        'as' => 'human-resources-get-oims',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-update-access',
    [
        'uses' => 'HumanResourcesController@updateOims',
        'as' => 'human-resources-update-access',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-oims-table',
    [
        'uses' => 'HumanResourcesController@showOims',
        'as' => 'human-resources-oims-table',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-table-promotion',
    [
        'uses' => 'HumanResourcesController@showPromotion',
        'as' => 'human-resources-table-promotion',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-pos-doc-download',
    [
        'uses' => 'HumanResourcesController@downloadPromotion',
        'as' => 'human-resources-pos-doc-download',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-present',
    [
        'uses' => 'HumanResourcesController@getPresentEmp',
        'as' => 'human-resources-employee-present',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-past',
    [
        'uses' => 'HumanResourcesController@getPastEmp',
        'as' => 'human-resources-employee-past',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-con-stat-table',
    [
        'uses' => 'HumanResourcesController@tableContract',
        'as' => 'human-resources-con-stat-table',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-upload-form-format',
    [
        'uses' => 'HumanResourcesController@uploadFormFile',
        'as' => 'human-resources-upload-form-format',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-file-format-table',
    [
        'uses' => 'HumanResourcesController@tableGeneralForms',
        'as' => 'human-resources-file-format-table',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-format-doc-download',
    [
        'uses' => 'HumanResourcesController@dlFormat',
        'as' => 'human-resources-format-doc-download',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-contract-emp-download',
    [
        'uses' => 'HumanResourcesController@dlContract',
        'as' => 'human-resources-contract-emp-download',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-motor-download',
    [
        'uses' => 'HumanResourcesController@dlMotor',
        'as' => 'human-resources-motor-download',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-emp-req-checklist',
    [
        'uses' => 'HumanResourcesController@insertEmpReqCheck',
        'as' => 'human-resources-emp-req-checklist',
        'role' => 'HumanResources'
    ]);
Route::post('human-resources-update-check-emp',
    [
        'uses' => 'HumanResourcesController@updateEmpReqCheck',
        'as' => 'human-resources-update-check-emp',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-pending',
    [
        'uses' => 'HumanResourcesController@tablePendingEmp',
        'as' => 'human-resources-employee-pending',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-approve-emp',
    [
        'uses' => 'HumanResourcesController@empApprove',
        'as' => 'human-resources-approve-emp',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-partial-emp',
    [
        'uses' => 'HumanResourcesController@empPartial',
        'as' => 'human-resources-partial-emp',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-deny-emp-rey',
    [
        'uses' => 'HumanResourcesController@empDenyRey',
        'as' => 'human-resources-deny-emp',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-deny-emp',
    [
        'uses' => 'HumanResourcesController@empDeny',
        'as' => 'hhuman-resources-deny-emp',
        'role' => 'HumanResources'
    ]);


Route::get('human-resources-get-partial',
    [
        'uses' => 'HumanResourcesController@getPartial',
        'as' => 'human-resources-get-partial',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-pending-rec',
    [
        'uses' => 'HumanResourcesController@getReqRec',
        'as' => 'human-resources-employee-pending-rec',
        'role' => 'HumanResources'
    ]);
Route::get('human-resources-employee-excel-dl',
    [
        'uses' => 'HumanResourcesController@downloadEmpExcel',
        'as' => 'human-resources-employee-excel-dl',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-ci',
    [
        'uses' => 'HumanResourcesController@human_resources_get_ci',
        'as' => 'human-resources-get-ci',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-employee-pending-rey',
    [
        'uses' => 'HumanResourcesController@human_resources_employee_pending_rey',
        'as' => 'human-resources-employee-pending-rey',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-pre-approve-prof',
    [
        'uses' => 'HumanResourcesController@human_resources_pre_approve_prof',
        'as' => 'human-resources-pre-approve-prof',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-employees-active',
    [
        'uses' => 'HumanResourcesController@human_resources_get_employees_active',
        'as' => 'human-resources-get-employees-active',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-view-denial-remarks',
    [
        'uses' => 'HumanResourcesController@human_resources_view_denial_remarks',
        'as' => 'human-resources-view-denial-remarks',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-submit-to-head',
    [
        'uses' => 'HumanResourcesController@human_resources_submit_to_head',
        'as' => 'human-resources-submit-to-head',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-tag-incomplete',
    [
        'uses' => 'HumanResourcesController@human_resources_tag_incomplete',
        'as' => 'human-resources-tag-incomplete',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-incomplete-remarks',
    [
        'uses' => 'HumanResourcesController@human_resources_get_incomplete_remarks',
        'as' => 'human-resources-get-incomplete-remarks',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-return-remarks',
    [
        'uses' => 'HumanResourcesController@human_resources_get_return_remarks',
        'as' => 'human-resources-get-return-remarks',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-overall-monitoring',
    [
        'uses' => 'HumanResourcesController@human_resources_overall_monitoring',
        'as' => 'human-resources-overall-monitoring',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-reject-remarks',
    [
        'uses' => 'HumanResourcesController@human_resources_get_reject_remarks',
        'as' => 'human-resources-get-reject-remarks',
        'role' => 'HumanResources'
    ]);

Route::get('human-resources-get-prom-rem',
    [
        'uses' => 'HumanResourcesController@human_resources_get_prom_rem',
        'as' => 'human-resources-get-prom-rem',
        'role' => 'HumanResources'
    ]);
    
Route::get('human-resources-generate-employee-attendance',
    [
        'uses' => 'HumanResourcesController@human_resources_generate_employee_attendance',
        'as' => 'human_resources_generate_employee_attendance',
        'role' => 'HumanResources'
    ]);
    
Route::post('human_resources_submit_issuance',
    [
        'uses' => 'HumanResourcesController@human_resources_submit_issuance',
        'as' => 'human_resources_submit_issuance',
        'role' => 'HumanResources'
    ]);

Route::get('human_resources_sent_monit_issuance',
    [
        'uses' => 'HumanResourcesController@human_resources_sent_monit_issuance',
        'as' => 'human_resources_sent_monit_issuance',
        'role' => 'HumanResources'
    ]);

Route::get('human_resources_delete_sent_issuance',
    [
        'uses' => 'HumanResourcesController@human_resources_delete_sent_issuance',
        'as' => 'human_resources_delete_sent_issuance',
        'role' => 'HumanResources'
    ]);

Route::get('human_resources_drafts_monit_issuance',
    [
        'uses' => 'HumanResourcesController@human_resources_drafts_monit_issuance',
        'as' => 'human_resources_drafts_monit_issuance',
        'role' => 'HumanResources'
    ]);

Route::get('human_resources_get_info_iss',
    [
        'uses' => 'HumanResourcesController@human_resources_get_info_iss',
        'as' => 'human_resources_get_info_iss',
        'role' => 'HumanResources'
    ]);

Route::get('getHrIssuanceFiles/{id}/{file_id}', function($id, $file_id)
{
    if(Auth::user()->hasRole('Human Resources'))
    {
        $getPath = DB::table('hr_issuance_files')
            ->select('file_path')
            ->where('id', base64_decode($file_id))
            ->where('issuance_id', base64_decode($id))
            ->get();

        return response()->download(storage_path($getPath[0]->file_path));
    }
    else
    {
        abort(404);
    }
});

Route::get('getHrIssuanceFilesGeneral/{id}/{file_id}', function($id, $file_id)
{
    $getPath = DB::table('hr_issuance_files')
        ->select('file_path')
        ->where('id', base64_decode($file_id))
        ->where('issuance_id', base64_decode($id))
        ->get();

    return response()->download(storage_path($getPath[0]->file_path));

});

//===========================================B.I Client========================================================

Route::get('background-investigation-panel',
    [
        'uses' => 'BiController@BiPanel',
        'as' => 'background-investigation-panel',
        'role' => 'B.I Client'
    ]);

Route::get('bi_get_bi_account_name',
    [
        'uses' => 'BiController@bi_get_bi_account_name',
        'as' => 'bi_get_bi_account_name',
        'role' => 'B.I Client'
    ]);

Route::get('bi_get_change_package_check',
    [
        'uses' => 'BiController@bi_get_change_package_check',
        'as' => 'bi_get_change_package_check',
        'role' => 'B.I Client'
    ]);

Route::get('bi_check_user',
    [
        'uses' => 'BiController@bi_check_user',
        'as' => 'bi_check_user',
        'role' => 'B.I Client'
    ]);


Route::post('bi_submit_endorsement',
    [
        'uses' => 'BiController@bi_submit_endorsement',
        'as' => 'bi_submit_endorsement',
        'role' => 'B.I Client'
    ]);

Route::post('bi_submit_endorsement_files',
    [
        'uses' => 'BiController@bi_submit_endorsement_files',
        'as' => 'bi_submit_endorsement_files',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_get_general_table',
    [
        'uses' => 'BiController@bi_client_get_general_table',
        'as' => 'bi_client_get_general_table',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_get_return_table',
    [
        'uses' => 'BiController@bi_client_get_return_table',
        'as' => 'bi_client_get_return_table',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_get_pending_table',
    [
        'uses' => 'BiController@bi_client_get_pending_table',
        'as' => 'bi_client_get_pending_table',
        'role' => 'B.I Client'
    ]);

Route::post('bi_client_re_endorse',
    [
        'uses' => 'BiController@bi_client_re_endorse',
        'as' => 'bi_client_re_endorse',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-table-finished',
    [
        'uses' => 'BiController@bi_client_table_finished',
        'as' => 'bi-client-table-finished',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-dl-report-file',
    [
        'uses' => 'BiController@bi_dl_report_file',
        'as' => 'bi-client-dl-report-file',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-return-notif',
    [
        'uses' => 'BiController@bi_return_notif_get',
        'as' => 'bi-client-return-notif',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-update-return-stat',
    [
        'uses' => 'BiController@bi_client_update_return_stat',
        'as' => 'bi-client-update-return-stat',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-update-finished-stat',
    [
        'uses' => 'BiController@bi_client_update_finished_stat',
        'as' => 'bi-client-update-finished-stat',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-get-message-notif',
    [
        'uses' => 'BiController@bi_client_get_message_notif',
        'as' => 'bi-client-get-message-notif',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-del-notif',
    [
        'uses' => 'BiController@bi_client_del_notif',
        'as' => 'bi-client-del-notif',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-check-notif',
    [
        'uses' => 'BiController@bi_client_check_notif',
        'as' => 'bi-client-check-notif',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-change-mess-notif',
    [
        'uses' => 'BiController@bi_client_change_mess_notif',
        'as' => 'bi-client-change-mess-notif',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-get-dash',
    [
        'uses' => 'BiController@bi_client_get_dash',
        'as' => 'bi-client-get-dash',
        'role' => 'B.I Client'
    ]);

Route::post('bi-client-upload-bulk-excel',
    [
        'uses' => 'BiController@bi_client_upload_bulk_excel',
        'as' => 'bi-client-upload-bulk-excel',
        'role' => 'B.I Client'
    ]);

Route::post('bi_remove_attachment_logs',
    [
        'uses' => 'BiController@bi_remove_attachment_logs',
        'as' => 'bi_remove_attachment_logs',
        'role' => 'B.I Client'
    ]);

Route::post('bi-client-send-bulk-endorse',
    [
        'uses' => 'BiController@bi_client_send_bulk_endorse',
        'as' => 'bi-client-send-bulk-endorse',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-cancel-table',
    [
        'uses' => 'BiController@bi_client_cancel_table',
        'as' => 'bi-client-cancel-table',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-hold-table',
    [
        'uses' => 'BiController@bi_client_hold_table',
        'as' => 'bi-client-hold-table',
        'role' => 'B.I Client'
    ]);

Route::post('bi-return-check-data',
    [
        'uses' => 'BiController@bi_return_check_data',
        'as' => 'bi-return-check-data',
        'role' => 'B.I Client'
    ]);

Route::post('bi-get-return-checklist-return',
    [
        'uses' => 'BiController@bi_get_return_checklist_return',
        'as' => 'bi-get-return-checklist-return',
        'role' => 'B.I Client'
    ]);

Route::get('bi-get-reason-of-delay',
    [
        'uses' => 'BiController@bi_get_reason_of_delay',
        'as' => 'bi-get-reason-of-delay',
        'role' => 'B.I Client'
    ]);

Route::post('bi-pdrn-endorse-submit',
    [
        'uses' => 'BiController@bi_pdrn_endorse_submit',
        'as' => 'bi-pdrn-endorse-submit',
        'role' => 'B.I Client'
    ]);

Route::post('bi-client-bvr-endorse-submit',
    [
        'uses' => 'BiController@bi_client_bvr_endorse_submit',
        'as' => 'bi-client-bvr-endorse-submit',
        'role' => 'B.I Client'
    ]);

Route::post('bi-client-evr-submit-endorse',
    [
        'uses' => 'BiController@bi_client_evr_submit_endorse',
        'as' => 'bi-client-evr-submit-endorse',
        'role' => 'B.I Client'
    ]);

Route::post('bi-client-additional-files-any',
    [
        'uses' => 'BiController@bi_client_additional_files_any',
        'as' => 'bi-client-additional-files-any',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-add-rem-add-files-new',
    [
        'uses' => 'BiController@bi_client_add_rem_add_files_new',
        'as' => 'bi-client-add-rem-add-files-new',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-multiple-dl',
    [
        'uses' => 'BiController@bi_client_multiple_dl',
        'as' => 'bi-client-multiple-dl',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_get_pending_applicants',
    [
        'uses' => 'BiController@bi_client_get_pending_applicants',
        'as' => 'bi_client_get_pending_applicants',
        'role' => 'B.I Client'
    ]);

// Route::get('get_encoded_file/{id}/{name}', function($id, $name)
// {
//     if(Auth::user() != null)
//     {
//         if(Auth::user()->hasRole('B.I Client'))
//         {
//             $getBIid = DB::table('users')
//                 ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
//                 ->select([
//                     'bi_account_to_users.bi_account_id as bi_id'
//                 ])
//                 ->where('users.id', Auth::user()->id)
//                 ->where('bi_account_to_users.to_display', 'display')
//                 ->get();
// //
// //            $user = User::find(Auth::user()->id);
// //            DB::table('bi_logs')
// //                ->insert
// //                ([
// //                    'endorse_id' => $id,
// //                    'user_id' => Auth::user()->id,
// //                    'position_id' => $user->roles->first()->id,
// //                    'activity' => 'FILE '.strtoupper(base64_decode($name)). ' DOWNLOADED',
// //                    'remarks' => '-',
// //                    'created_at' => Carbon::now('Asia/Manila')
// //                ]);

//             return response()->download(storage_path('bi_attachments_direct/' .$getBIid[0]->bi_id. '/'. base64_decode($id). '/' .base64_decode($name)));
//         }
//         else
//         {
//             abort(404);
//         }
//     }
//     else
//     {
//         abort(404);
//     }
// });

Route::get('get_encoded_file/{id}/{name}/{type}', function($id, $name, $type)
{
    if(Auth::user() != null)
    {
        if(Auth::user()->hasRole('B.I Client'))
        {
            $getBIid = DB::table('users')
                ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
                ->select([
                    'bi_account_to_users.bi_account_id as bi_id'
                ])
                ->where('users.id', Auth::user()->id)
                ->where('bi_account_to_users.to_display', 'display')
                ->get();


            if($type == 'd_direct')
            {

                $path = utf8_encode(storage_path('direct_bi_attachment/' .$getBIid[0]->bi_id. '/'. base64_decode($id). '/' .base64_decode($name)));
                // $path = utf8_encode(storage_path('direct_bi_attachment/'. base64_decode($id). '/' .base64_decode($name)));

                $file = File::get($path);
                $type1 = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type1);

                if(explode("/" ,$type1)[0] == 'image' || $type1 == 'application/pdf')
                {
                    return $response;
                }
                else
                {
                    // return $response;
                    $path = utf8_encode(storage_path('direct_bi_attachment/' .$getBIid[0]->bi_id. '/'. base64_decode($id). '/' .base64_decode($name)));
                    return response()->download($path);
                }
            }
            else if($type == 'd_concen')
            {
                return response()->download(storage_path('bi_attachments_direct/' .$getBIid[0]->bi_id. '/'. base64_decode($id). '/' .base64_decode($name)));
            }


//
//            $user = User::find(Auth::user()->id);
//            DB::table('bi_logs')
//                ->insert
//                ([
//                    'endorse_id' => $id,
//                    'user_id' => Auth::user()->id,
//                    'position_id' => $user->roles->first()->id,
//                    'activity' => 'FILE '.strtoupper(base64_decode($name)). ' DOWNLOADED',
//                    'remarks' => '-',
//                    'created_at' => Carbon::now('Asia/Manila')
//                ]);



        }
        else
        {
            abort(404);
        }
    }
    else
    {
        abort(404);
    }
});

Route::get('bi_endorse_encoded_account',
    [
        'uses' => 'BiController@bi_endorse_encoded_account',
        'as' => 'bi_endorse_encoded_account',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_request_cancellation',
    [
        'uses' => 'BiController@bi_client_request_cancellation',
        'as' => 'bi_client_request_cancellation',
        'role' => 'B.I Client'
    ]);

Route::get('bi-client-dl-bulk',
    [
        'uses' => 'BiController@bi_client_dl_bulk',
        'as' => 'bi-client-dl-bulk',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_view_finished_file', function(Request $request)
{
    if(Auth::user() != null)
    {
        $user = User::find(Auth::user()->id);
        $role = $user->roles->first()->name;
        $endorse_id = base64_decode($request->id);
        $path = '';

        if($role == 'B.I Client')
        {
            $get_path = DB::table('bi_endorsements')
                ->where('id', $endorse_id)
                ->select([
                    'report_file_path'
                ])
                ->get();

            if(count($get_path) > 0)
            {
                $path = storage_path($get_path[0]->report_file_path);

                $file = File::get($path);
                $type = File::mimeType($path);

                if($type == 'application/pdf')
                {
                    $response = Response::make($file, 200);
                    $response->header("Content-Type", $type);

                    return $response;
                }
                else
                {
                    return 'Report file is not viewable or file is not PDF file. Download the report to view';
                }

            }
            else
            {
                return 'Report is not available';
            }
        }
        else
        {
            abort(404);
        }
    }
    else
    {
        abort(404);
    }

});

Route::get('bi_client_get_additional_files_direct',
    [
        'uses' => 'BiController@bi_client_get_additional_files_direct',
        'as' => 'bi_client_get_additional_files_direct',
        'role' => 'B.I Client'
    ]);

Route::get('getAddFilesDl/{id}/{name}', function($id, $name)
{
    if(Auth::user()->authrequest == 'direct_enc')
    {
        if(Auth::user()->hasRole('B.I Client'))
        {
            $getBIid = DB::table('users')
                ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
                ->select([
                    'bi_account_to_users.bi_account_id as bi_id'
                ])
                ->where('users.id', Auth::user()->id)
                ->where('bi_account_to_users.to_display', 'display')
                ->get();

            $getDirect_id = DB::table('bi_direct_pivot')
                ->select('direct_to_get_id')
                ->where('id', base64_decode($id))
                ->get()[0]->direct_to_get_id;

            $path = utf8_encode(storage_path('direct_additional_files/' . $getBIid[0]->bi_id . '/' . $getDirect_id . '/' . base64_decode($name)));
            // $path = utf8_encode(storage_path('direct_additional_files/' . $getDirect_id . '/' . base64_decode($name)));

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            if(explode("/" ,$type)[0] == 'image' || $type == 'application/pdf')
            {
                return $response;
            }
            else
            {
                $path2 = storage_path('direct_additional_files/' . $getBIid[0]->bi_id . '/' . $getDirect_id . '/' . base64_decode($name));

                return response()->download($path2);
            }
        }
        else
        {
            abort(404);
        }
    }
    else
    {
        abort(404);
    }
});

Route::get('bi_client_billing_information_table',
    [
        'uses' => 'BiController@bi_client_billing_information_table',
        'as' => 'bi_client_billing_information_table',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_billing_selected_accounts',
    [
        'uses' => 'BiController@bi_client_billing_selected_accounts',
        'as' => 'bi_client_billing_selected_accounts',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_billing_success_payment',
    [
        'uses' => 'BiController@bi_client_billing_success_payment',
        'as' => 'bi_client_billing_success_payment',
        'role' => 'B.I Client'
    ]);


Route::get('bi_client_send_return_email_application',
    [
        'uses' => 'BiController@bi_client_send_return_email_application',
        'as' => 'bi_client_send_return_email_application',
        'role' => 'B.I Client'
    ]);

Route::get('bi_cancel_direct_encode_data',
    [
        'uses' => 'BiController@bi_cancel_direct_encode_data',
        'as' => 'bi_cancel_direct_encode_data',
        'role' => 'B.I Client'
    ]);

Route::get('bi_uncancel_direct_encode_data',
    [
        'uses' => 'BiController@bi_uncancel_direct_encode_data',
        'as' => 'bi_cancel_direct_encode_data',
        'role' => 'B.I Client'
    ]);

Route::get('bi_client_get_cancelled_applicants',
    [
        'uses' => 'BiController@bi_client_get_cancelled_applicants',
        'as' => 'bi_client_get_cancelled_applicants',
        'role' => 'B.I Client'
    ]); 

//===========================================B.I Client (TFS)==================================================
Route::get('tfs_background-investigation-panel',
    [
        'uses' => 'BiControllerTFS@BiPanel',
        'as' => 'tfs_background-investigation-panel',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_get_bi_account_name',
    [
        'uses' => 'BiControllerTFS@bi_get_bi_account_name',
        'as' => 'bi_get_bi_account_name',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_get_change_package_check',
    [
        'uses' => 'BiControllerTFS@bi_get_change_package_check',
        'as' => 'bi_get_change_package_check',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_check_user',
    [
        'uses' => 'BiControllerTFS@bi_check_user',
        'as' => 'bi_check_user',
        'role' => 'B.I Client'
    ]);


Route::post('tfs_bi_submit_endorsement',
    [
        'uses' => 'BiControllerTFS@bi_submit_endorsement',
        'as' => 'bi_submit_endorsement',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi_submit_endorsement_files',
    [
        'uses' => 'BiControllerTFS@bi_submit_endorsement_files',
        'as' => 'bi_submit_endorsement_files',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_get_general_table',
    [
        'uses' => 'BiControllerTFS@bi_client_get_general_table',
        'as' => 'bi_client_get_general_table',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_get_return_table',
    [
        'uses' => 'BiControllerTFS@bi_client_get_return_table',
        'as' => 'bi_client_get_return_table',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_get_pending_table',
    [
        'uses' => 'BiControllerTFS@bi_client_get_pending_table',
        'as' => 'bi_client_get_pending_table',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi_client_re_endorse',
    [
        'uses' => 'BiControllerTFS@bi_client_re_endorse',
        'as' => 'bi_client_re_endorse',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-table-finished',
    [
        'uses' => 'BiControllerTFS@bi_client_table_finished',
        'as' => 'bi-client-table-finished',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-dl-report-file',
    [
        'uses' => 'BiControllerTFS@bi_dl_report_file',
        'as' => 'bi-client-dl-report-file',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-return-notif',
    [
        'uses' => 'BiControllerTFS@bi_return_notif_get',
        'as' => 'bi-client-return-notif',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-update-return-stat',
    [
        'uses' => 'BiControllerTFS@bi_client_update_return_stat',
        'as' => 'bi-client-update-return-stat',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-update-finished-stat',
    [
        'uses' => 'BiControllerTFS@bi_client_update_finished_stat',
        'as' => 'bi-client-update-finished-stat',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-get-message-notif',
    [
        'uses' => 'BiControllerTFS@bi_client_get_message_notif',
        'as' => 'bi-client-get-message-notif',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-del-notif',
    [
        'uses' => 'BiControllerTFS@bi_client_del_notif',
        'as' => 'bi-client-del-notif',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-check-notif',
    [
        'uses' => 'BiControllerTFS@bi_client_check_notif',
        'as' => 'bi-client-check-notif',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-change-mess-notif',
    [
        'uses' => 'BiControllerTFS@bi_client_change_mess_notif',
        'as' => 'bi-client-change-mess-notif',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-get-dash',
    [
        'uses' => 'BiControllerTFS@bi_client_get_dash',
        'as' => 'bi-client-get-dash',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-client-upload-bulk-excel',
    [
        'uses' => 'BiControllerTFS@bi_client_upload_bulk_excel',
        'as' => 'bi-client-upload-bulk-excel',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi_remove_attachment_logs',
    [
        'uses' => 'BiControllerTFS@bi_remove_attachment_logs',
        'as' => 'bi_remove_attachment_logs',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-client-send-bulk-endorse',
    [
        'uses' => 'BiControllerTFS@bi_client_send_bulk_endorse',
        'as' => 'bi-client-send-bulk-endorse',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-cancel-table',
    [
        'uses' => 'BiControllerTFS@bi_client_cancel_table',
        'as' => 'bi-client-cancel-table',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-hold-table',
    [
        'uses' => 'BiControllerTFS@bi_client_hold_table',
        'as' => 'bi-client-hold-table',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-return-check-data',
    [
        'uses' => 'BiControllerTFS@bi_return_check_data',
        'as' => 'bi-return-check-data',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-get-return-checklist-return',
    [
        'uses' => 'BiControllerTFS@bi_get_return_checklist_return',
        'as' => 'bi-get-return-checklist-return',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-get-reason-of-delay',
    [
        'uses' => 'BiControllerTFS@bi_get_reason_of_delay',
        'as' => 'bi-get-reason-of-delay',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-pdrn-endorse-submit',
    [
        'uses' => 'BiControllerTFS@bi_pdrn_endorse_submit',
        'as' => 'bi-pdrn-endorse-submit',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-client-bvr-endorse-submit',
    [
        'uses' => 'BiControllerTFS@bi_client_bvr_endorse_submit',
        'as' => 'bi-client-bvr-endorse-submit',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-client-evr-submit-endorse',
    [
        'uses' => 'BiControllerTFS@bi_client_evr_submit_endorse',
        'as' => 'bi-client-evr-submit-endorse',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi-client-additional-files-any',
    [
        'uses' => 'BiControllerTFS@bi_client_additional_files_any',
        'as' => 'bi-client-additional-files-any',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-add-rem-add-files-new',
    [
        'uses' => 'BiControllerTFS@bi_client_add_rem_add_files_new',
        'as' => 'bi-client-add-rem-add-files-new',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-multiple-dl',
    [
        'uses' => 'BiControllerTFS@bi_client_multiple_dl',
        'as' => 'bi-client-multiple-dl',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_get_pending_applicants',
    [
        'uses' => 'BiControllerTFS@bi_client_get_pending_applicants',
        'as' => 'bi_client_get_pending_applicants',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_endorse_encoded_account',
    [
        'uses' => 'BiControllerTFS@bi_endorse_encoded_account',
        'as' => 'bi_endorse_encoded_account',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_request_cancellation',
    [
        'uses' => 'BiControllerTFS@bi_client_request_cancellation',
        'as' => 'bi_client_request_cancellation',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi-client-dl-bulk',
    [
        'uses' => 'BiControllerTFS@bi_client_dl_bulk',
        'as' => 'bi-client-dl-bulk',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_client_check_endorse_time',
    [
        'uses' => 'BiControllerTFS@tfs_bi_client_check_endorse_time',
        'as' => 'tfs_bi_client_check_endorse_time',
        'role' => 'B.I Client'
    ]);

Route::get('tfs_bi_edit_endorsement',
    [
        'uses' => 'BiControllerTFS@tfs_bi_edit_endorsement',
        'as' => 'tfs_bi_edit_endorsement',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi_upload_edited_endo_file',
    [
        'uses' => 'BiControllerTFS@tfs_bi_upload_edited_endo_file',
        'as' => 'tfs_bi_upload_edited_endo_file',
        'role' => 'B.I Client'
    ]);
    
Route::get('tfs_bi_get_name_user',
    [
        'uses' => 'BiControllerTFS@tfs_bi_get_name_user',
        'as' => 'tfs_bi_get_name_user',
        'role' => 'B.I Client'
    ]);

Route::post('tfs_bi_client_fullci_submit_endorse',
    [
        'uses' => 'BiControllerTFS@tfs_bi_client_fullci_submit_endorse',
        'as' => 'tfs_bi_client_fullci_submit_endorse',
        'role' => 'B.I Client'
    ]);
    
Route::get('tfs_bi_check_double_endorse',
    [
        'uses' => 'BiControllerTFS@tfs_bi_check_double_endorse',
        'as' => 'tfs_bi_client_fullci_submit_endorse',
        'role' => 'B.I Client'
    ]);


//===========================================CC SENIOR ACCOUNT OFFICER========================================================

Route::get('cc-sao-panel',
    [
        'uses' => 'CCSrAccountOfficerController@ccsaopanel',
        'as' => 'cc-sao-panel',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_get_table_accounts',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_table_accounts',
        'as' => 'cc_sao_get_table_accounts',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_get_table_acknowledge',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_table_acknowledge',
        'as' => 'cc_sao_get_table_acknowledge',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_get_table_return',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_table_return',
        'as' => 'cc_sao_get_table_return',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_return_account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_return_account',
        'as' => 'cc_sao_return_account',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_cancel_account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_cancel_account',
        'as' => 'cc_sao_cancel_account',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_acknowledge_account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_acknowledge_account',
        'as' => 'cc_sao_acknowledge_account',
        'role' => 'CC Senior Account Officer'
    ]);

Route::post('cc-sao-send-report',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_send_report',
        'as' => 'cc-sao-send-report',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-table-finished',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_table_finished',
        'as' => 'cc-sao-table-finished',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-view-remarks',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_view_remarks',
        'as' => 'cc-sao-view-remarks',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-dl-report',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_dl_report',
        'as' => 'cc-sao-dl-report',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-proceed-acknowledge',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_proceed_acknowledge',
        'as' => 'cc-sao-proceed-acknowledge',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-get-tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_tele',
        'as' => 'cc-sao-get-tele',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-assign-tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_assign_tele',
        'as' => 'cc-sao-assign-tele',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-tele-success-accounts',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_tele_success_accounts',
        'as' => 'cc-sao-tele-success-accounts',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-tele-dl-report',
    [
        'uses' => 'CCSrAccountOfficerController@cc_tele_dl_report',
        'as' => 'cc-sao-tele-dl-report',
        'role' => 'CC Senior Account Officer'
    ]);

Route::post('cc-sao-file-to-tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_file_to_tele',
        'as' => 'cc-sao-file-to-tele',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-generaltbl-search',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_general_search',
        'as' => 'cc-sao-generaltbl-search',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-get-dash',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_dash',
        'as' => 'cc-sao-get-dash',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-dl-ack',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_dl_ack',
        'as' => 'cc-sao-dl-ack',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-get-assigned-table',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_assigned_table',
        'as' => 'cc-sao-get-assigned-table',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-get-assigned-to-acct',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_assigned_to_acct',
        'as' => 'cc-sao-get-assigned-to-acct',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-transfer-to-tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_transfer_to_tele',
        'as' => 'cc-sao-transfer-to-tele',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-cancel-table',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_cancel_table',
        'as' => 'cc-sao-cancel-table',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-pending-cancel-table',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_pending_cancel_table',
        'as' => 'cc-pending-cancel-table',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-cancel-new-account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_cancel_new_account',
        'as' => 'cc-sao-cancel-new-account',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-hold-new-account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_hold_new_account',
        'as' => 'cc-sao-hold-new-account',
        'role' => 'CC Senior Account Officer'
    ]);
Route::post('cc-sao-return-check-data-upon',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_return_check_data_upon',
        'as' => 'cc-sao-return-check-data-upon',
        'role' => 'CC Senior Account Officer'
    ]);
Route::post('cc-sao-get-return-checklist-return-upon',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_return_checklist_return_upon',
        'as' => 'cc-sao-get-return-checklist-return-upon',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-get-reason-of-delay',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_reason_of_delay',
        'as' => 'cc-sao-get-reason-of-delay',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-return-to-tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_return_to_tele',
        'as' => 'cc-sao-return-to-tele',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-uncancel-account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_uncancel_account',
        'as' => 'cc-sao-uncancel-account',
        'role' => 'CC Senior Account Officer'
    ]);
Route::get('cc-sao-unhold-account',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_unhold_account',
        'as' => 'cc-sao-unhold-account',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-check-if-sitel',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_check_if_sitel',
        'as' => 'cc-sao-check-if-sitel',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('notify_required_docs',
    [
        'uses' => 'CCSrAccountOfficerController@notify_required_docs',
        'as' => 'notify_required_docs',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-get-client-type',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_client_type',
        'as' => 'cc-sao-get-client-type',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('get_tele_grant_table',
    [
        'uses' => 'CCSrAccountOfficerController@get_tele_grant_table',
        'as' => 'get_tele_grant_table',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_granting_tele',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_granting_tele',
        'as' => 'cc_sao_granting_tele',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc-sao-get-general-mon-table',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_general_mon_table',
        'as' => 'cc-sao-get-general-mon-table',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_get_bi_checkings',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_bi_checkings',
        'as' => 'cc_sao_get_bi_checkings',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_get_selected_packages_checkings',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_get_selected_packages_checkings',
        'as' => 'cc_sao_get_selected_packages_checkings',
        'role' => 'CC Senior Account Officer'
    ]);

Route::get('cc_sao_add_checking_packages_api_endo',
    [
        'uses' => 'CCSrAccountOfficerController@cc_sao_add_checking_packages_api_endo',
        'as' => 'cc_sao_add_checking_packages_api_endo',
        'role' => 'CC Senior Account Officer'
    ]);



//===========================================CC ACCOUNT OFFICER========================================================

Route::get('cc-ao-panel',
    [
        'uses' => 'CCAccountOfficerController@ccaopanel',
        'as' => 'cc-ao-panel',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_table_accounts',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_table_accounts',
        'as' => 'cc_ao_get_table_accounts',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_table_acknowledge',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_table_acknowledge',
        'as' => 'cc_ao_get_table_acknowledge',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_table_finished',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_table_finished',
        'as' => 'cc_ao_get_table_finished',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_table_return',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_table_return',
        'as' => 'cc_ao_get_table_return',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_return_account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_return_account',
        'as' => 'cc_ao_return_account',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_cancel_account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_cancel_account',
        'as' => 'cc_ao_cancel_account',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_acknowledge_account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_acknowledge_account',
        'as' => 'cc_ao_acknowledge_account',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-send-report',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_send_report',
        'as' => 'cc-ao-send-report',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-dl-report',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_dl_report',
        'as' => 'cc-ao-dl-report',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-proceed-acknowledge',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_proceed_acknowledge',
        'as' => 'cc-ao-proceed-acknowledge',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-tele-success-accounts',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_tele_success_accounts',
        'as' => 'cc-ao-tele-success-accounts',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-tele-dl-report',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_tele_dl_report',
        'as' => 'cc-ao-tele-dl-report',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-file-to-tele',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_file_to_tele',
        'as' => 'cc-ao-file-to-tele',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-assign-tele',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_assign_tele',
        'as' => 'cc-ao-assign-tele',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-generaltbl-search',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_general_search',
        'as' => 'cc-ao-generaltbl-search',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-get-dash',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_dash',
        'as' => 'cc-ao-get-dash',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-dl-ack',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_dl_ack',
        'as' => 'cc-ao-dl-ack',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-get-assigned-table',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_assigned_table',
        'as' => 'cc-ao-get-assigned-table',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-get-assigned-to-acct',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_assigned_to_acct',
        'as' => 'cc-ao-get-assigned-to-acct',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-get-assigned-to-acct',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_assigned_to_acct',
        'as' => 'cc-ao-get-assigned-to-acct',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-transfer-to-tele',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_transfer_to_tele',
        'as' => 'cc-ao-transfer-to-tele',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-cancel-table',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_cancel_table',
        'as' => 'cc-ao-cancel-table',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_pending_cancel_table',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_pending_cancel_table',
        'as' => 'cc_ao_pending_cancel_table',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc-ao-cancel-new-account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_cancel_new_account',
        'as' => 'cc-ao-cancel-new-account',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-hold-new-account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_hold_new_account',
        'as' => 'cc-ao-hold-new-account',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-return-check-data',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_return_check_data',
        'as' => 'cc-ao-return-check-data',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-get-return-checklist',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_return_checklist',
        'as' => 'cc-ao-get-return-checklist',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-return-check-data-upon',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_return_check_data_upon',
        'as' => 'cc-ao-return-check-data-upon',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-get-return-checklist-return-upon',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_return_checklist_return_upon',
        'as' => 'cc-ao-get-return-checklist-return-upon',
        'role' => 'CC Account Officer'
    ]);
Route::post('cc-ao-get-reason-of-delay',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_reason_of_delay',
        'as' => 'cc-ao-get-reason-of-delay',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-uncancel-account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_uncancel_account',
        'as' => 'cc-ao-uncancel-account',
        'role' => 'CC Account Officer'
    ]);
Route::get('cc-ao-unhold-account',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_unhold_account',
        'as' => 'cc-ao-unhold-account',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc-ao-check-type-tat',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_check_type_tat',
        'as' => 'cc-ao-check-type-tat',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc-ao-check-if-sitel',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_check_if_sitel',
        'as' => 'cc-ao-check-if-sitel',
        'role' => 'CC Account Officer'
    ]);

Route::get('notify_required_docs',
    [
        'uses' => 'CCAccountOfficerController@notify_required_docs',
        'as' => 'notify_required_docs',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc-ao-get-client-type',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_client_type',
        'as' => 'cc-ao-get-client-type',
        'role' => 'CC Account Officer'
    ]);

Route::get('get_tele_grant_table',
    [
        'uses' => 'CCAccountOfficerController@get_tele_grant_table',
        'as' => 'get_tele_grant_table',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_granting_tele',
    [
        'uses' => 'CCAccountOfficerController@cc_sao_granting_tele',
        'as' => 'cc_sao_granting_tele',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc-ao-get-general-mon-table',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_general_mon_table',
        'as' => 'cc-ao-get-general-mon-table',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_bi_checkings',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_bi_checkings',
        'as' => 'cc_ao_get_bi_checkings',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_get_selected_packages_checkings',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_get_selected_packages_checkings',
        'as' => 'cc_ao_get_selected_packages_checkings',
        'role' => 'CC Account Officer'
    ]);

Route::get('cc_ao_add_checking_packages_api_endo',
    [
        'uses' => 'CCAccountOfficerController@cc_ao_add_checking_packages_api_endo',
        'as' => 'cc_ao_add_checking_packages_api_endo',
        'role' => 'CC Account Officer'
    ]);


//===========================================CC TELE PANEL========================================================

Route::get('cc-tele-panel',
    [
        'uses' => 'CCTeleEncoderController@ccTelePanel',
        'as' => 'cc-tele-panel',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-encoder-table-acknowledged',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_encoder_table_acknowledged',
        'as' => 'cc-tele-encoder-table-acknowledged',
        'role' => 'CC Tele Encoder'
    ]);

Route::post('cc-tele-send-rep-sao',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_send_rep_sao',
        'as' => 'cc-tele-send-rep-sao',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-dl-sao-report',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_dl_sao_report',
        'as' => 'cc-tele-dl-sao-report',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc_tele_generaltbl_search',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_general_search',
        'as' => 'cc_tele_generaltbl_search',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-get-dash',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_get_dash',
        'as' => 'cc-tele-get-dash',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-view-reason',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_view_reason',
        'as' => 'cc-tele-view-reason',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-finished-accounts',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_finished_accounts',
        'as' => 'cc-tele-finished-accounts',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc_tele_get_account_checking',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_get_account_checking',
        'as' => 'cc_tele_get_account_checking',
        'role' => 'CC Tele Encoder'
    ]);

Route::post('insert_tele_encoded_data',
    [
        'uses' => 'CCTeleEncoderController@insert_tele_encoded_data',
        'as' => 'insert_tele_encoded_data',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc_tele_logs_data',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_logs_data',
        'as' => 'cc_tele_logs_data',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('tele_get_log_checkcing',
    [
        'uses' => 'CCTeleEncoderController@tele_get_log_checkcing',
        'as' => 'tele_get_log_checkcing',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('get_cc_tele_report_logs',
    [
        'uses' => 'CCTeleEncoderController@get_cc_tele_report_logs',
        'as' => 'get_cc_tele_report_logs',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-get-client-type',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_get_client_type',
        'as' => 'cc-tele-get-client-type',
        'role' => 'CC Tele Encoder'
    ]);

Route::post('cc-tele-submit-cc-bank-encoding-pdrn',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_submit_cc_bank_encoding_pdrn',
        'as' => 'cc-tele-submit-cc-bank-encoding-pdrn',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc_tele_contact_numbers',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_contact_numbers',
        'as' => 'cc_tele_contact_numbers',
        'role' => 'CC Tele Encoder'
    ]);

Route::post('add_contact_number',
    [
        'uses' => 'CCTeleEncoderController@add_contact_number',
        'as' => 'add_contact_number',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('delete_comp_contact_details',
    [
        'uses' => 'CCTeleEncoderController@delete_comp_contact_details',
        'as' => 'delete_comp_contact_details',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('update_comp_contact_details',
    [
        'uses' => 'CCTeleEncoderController@update_comp_contact_details',
        'as' => 'update_comp_contact_details',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('tele_get_contacts',
    [
        'uses' => 'CCTeleEncoderController@tele_get_contacts',
        'as' => 'tele_get_contacts',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-cc-bank-encoded-list',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_cc_bank_encoded_list',
        'as' => 'cc-tele-cc-bank-encoded-list',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc_tele_get_save_data',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_get_save_data',
        'as' => 'cc_tele_get_save_data',
        'role' => 'CC Tele Encoder'
    ]);

Route::get('cc-tele-get-browser-info',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_get_browser_info',
        'as' => 'cc-tele-get-browser-info',
        'role' => 'CC Tele Encoder'
    ]);

Route::post('cc-tele-html-to-pdf',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_html_to_pdf',
        'as' => 'cc-tele-html-to-pdf',
        'role' => 'CC Tele Encoder'
    ]);


Route::get('/cc-tele-show-pdf/{filename}', function($filename)
{

    if(Auth::user()->hasRole('CC Tele Encoder'))
    {
        $path = storage_path('tele_pdf_to_print/'.$filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    else
    {
        return 'bro you are in a wrong way.....';
    }
});

Route::get('cc-tele-delete-pdf',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_delete_pdf',
        'as' => 'cc-tele-delete-pdf',
        'role' => 'CC Tele Encoder'
    ]);
    
Route::post('cc_tele_encoder_copy_for_level_2',
    [
        'uses' => 'CCTeleEncoderController@cc_tele_encoder_copy_for_level_2',
        'as' => 'cc_tele_encoder_copy_for_level_2',
        'role' => 'CC Tele Encoder'
    ]);




//===========================================C.I SUPERVISOR PANEL====================================================

Route::get('ci-sup-panel',
    [
        'uses' => 'CISupervisorController@ci_sup_panel',
        'as' => 'ci-sup-panel',
        'role' => 'C.I Supervisor'
    ]);

Route::get('get-all-ci',
    [
        'uses' => 'CISupervisorController@getCiList',
        'as' => 'get-all-ci',
        'role' => 'C.I Supervisor'
    ]);

Route::get('ci-sup-get-all-realtime',
    [
        'uses' => 'CISupervisorController@getAllRealtime',
        'as' => 'ci-sup-get-all-realtime',
        'role' => 'C.I Supervisor'
    ]);

Route::get('get-all-pending',
    [
        'uses' => 'CISupervisorController@get_all_pending',
        'as' => 'get-all-pending',
        'role' => 'C.I Supervisor'
    ]);

Route::get('get-all-finished',
    [
        'uses' => 'CISupervisorController@get_all_finished',
        'as' => 'get-all-finished',
        'role' => 'C.I Supervisor'
    ]);

Route::get('ci-sup-get-all-realtimeFund',
    [
        'uses' => 'CISupervisorController@ci_sup_get_all_realtimeFund',
        'as' => 'ci-sup-get-all-realtimeFund',
        'role' => 'C.I Supervisor'
    ]);

Route::get('ci-supp-get-ci-list',
    [
        'uses' => 'CISupervisorController@ci_supp_get_ci_list',
        'as' => 'ci-supp-get-ci-list',
        'role' => 'C.I Supervisor'
    ]);

//===========================================INDIVIDUAL CLIENT ROUTE========================================================

Route::get('in-client-panel',
    [
        'uses' => 'IndividualClientController@getIndiClientPanel',
        'as' => 'in-client-panel'
    ]);

//===========================================API ROUTE========================================================

//ci bank
Route::get('/api/endorsements','APIoimsController@endorsement_get');
Route::get('/api/download_account_link','APIoimsController@down_func');
Route::post('/api/endorse/pdrn','APIoimsController@endorsement_submit_pdrn');
Route::post('/api/endorse/evr','APIoimsController@endorsement_submit_evr');
Route::post('/api/endorse/bvr','APIoimsController@endorsement_submit_bvr');
Route::post('/api/endorse/coborrower','APIoimsController@endorsement_submit_coborrower');

//bank tele
Route::get('/api/fetch/tele/endorsements','APIoimsController@bi_endorsement_get');
Route::get('/api/download_attachment_link','APIoimsController@bi_download_files_universal_api');
Route::get('/api/download_success_attachment_link','APIoimsController@bi_download_finish_account');
Route::post('/api/enodrse/tele/pdrn','APIoimsController@bi_endorse_submit_pdrn');
Route::post('/api/enodrse/tele/evr','APIoimsController@bi_endorse_submit_evr');
Route::post('/api/enodrse/tele/bvr','APIoimsController@bi_endorse_submit_bvr');

//cc tele
Route::get('/api/fetch/cc/package_check','APIoimsController@cc_check_package_check_available');
Route::get('/api/fetch/cc/endorsements','APIoimsController@cc_endorsement_get');
Route::post('/api/endorse/cc/accounts','APIoimsController@cc_endorse_account');

//generate api
Route::get('/create_api/generate_api/id/{id}',function($id){

    $token = Str::random(60);

    $check_ = DB::table('users')
        ->where('id',$id)
        ->count();

    if($check_ == 0)
    {
        return response()->json(
            [
                'message' => "Error"
            ]
        );
    }
    else
    {
        DB::table('users')
            ->where('id',$id)
            ->update([
                'api_token' => hash('sha256', $token),
            ]);

        return response()->json(
            [
                'message' => "Success Creating api",
                'token' => $token ,
                'secret_id' => hash('sha256', $id)
            ]
        );
    }

});

Route::get('/create_api/generate_email_key/',function(){

    $token = Str::random(25).Carbon::now('Asia/Manila');
    $dmk = hash('sha256', $token);

    return response()->json(
        [
            'message' => "Success Creating Download Email Key",
            'down_email_key' => $dmk
        ]
    );

});


//===========================================PAYPAL ROUTE========================================================

Route::post('paypal_pay_confirm',
    [
        'uses' => 'IndividualClientController@paypal_pay_confirm',
        'as' => 'paypal_pay_confirm',
        'role' => 'Client'
    ]);
    
Route::get('paypal-url-test', function(Request $request)
{
    $token = $request->token;
    $javs = DB::table('javascript_magic')
        ->select('unique')
        ->where('id','1')
        ->get()[0]->unique;

    $random =  Str::random(25).Carbon::now('Asia/Manila');

    return view('paypal-url-checking',compact('javs', 'token', 'random'));
});


Route::post('paypal-token-redirect', function(Request $request)
{
    if(Hash::check('dodongpogi', base64_decode($request->token)))
    {
        return response()->json(['success', base64_encode(Hash::make('dodongpogi'))]);
    }
    else
    {
        return response()->json(['deny', Hash::make('dodongpogi')]);
    }
});

Route::post('paypal-gateway',
    [
        'uses' => 'DirectEncodeController@paypal_gateway_con',
        'as' => 'paypal_gateway'
    ]);

//===========================================PAYPAL ROUTE========================================================


//===========================================GENERAL ATTENDANCE ROUTE========================================================



Route::get('general-attendance-panel',
    [
        'uses' => 'GeneralAccessController@generalAccesPanel',
        'as' => 'general-attendance-panel',
        'role' => 'General Access'
    ]);




//===========================================IT ROUTE========================================================

Route::get('it-dept-panel',
    [
        'uses' => 'ITDeptController@itDeptPanel',
        'as' => 'it-dept-panel',
        'role' => 'IT Dept'
    ]);

Route::get('it-dept-get-access',
    [
        'uses' => 'ITDeptController@it_dept_get_access',
        'as' => 'it-dept-get-access',
        'role' => 'IT Dept'
    ]);

Route::post('it-dept-send-checklist',
    [
        'uses' => 'ITDeptController@it_dept_send_checklist',
        'as' => 'it-dept-send-checklist',
        'role' => 'IT Dept'
    ]);

Route::get('it-dept-monit-table',
    [
        'uses' => 'ITDeptController@it_dept_monit_table',
        'as' => 'it-dept-monit-table',
        'role' => 'IT Dept'
    ]);

Route::get('it-dept-get-checklist-info',
    [
        'uses' => 'ITDeptController@it_dept_get_checklist_info',
        'as' => 'it-dept-get-checklist-info',
        'role' => 'IT Dept'
    ]);

Route::get('it-dept-insert-remarks-checklist',
    [
        'uses' => 'ITDeptController@it_dept_insert_remarks_checklist',
        'as' => 'it-dept-insert-remarks-checklist',
        'role' => 'IT Dept'
    ]);

Route::get('it-dept-insert-remarks-checklist',
    [
        'uses' => 'ITDeptController@it_dept_insert_remarks_checklist',
        'as' => 'it-dept-insert-remarks-checklist',
        'role' => 'IT Dept'
    ]);

Route::get('it_dept_archive_yes_table',
    [
        'uses' => 'ITDeptController@it_dept_archive_yes_table',
        'as' => 'it_dept_archive_yes_table',
        'role' => 'IT Dept'
    ]);

Route::get('it_dept_change_archived',
    [
        'uses' => 'ITDeptController@it_dept_change_archived',
        'as' => 'it_dept_change_archived',
        'role' => 'IT Dept'
    ]);
    
//===========================================DIRECT ENCODE ROUTE========================================================

Route::post('direct_encode_inputs',
    [
        'uses' => 'DirectEncodeController@direct_encode_inputs',
        'as' => 'direct_encode_inputs',
        'role' => 'Direct Encode'
    ]);

Route::get('direct_applicant_search_application_tracking',
    [
        'uses' => 'DirectEncodeController@direct_applicant_search_application_tracking',
        'as' => 'direct_applicant_search_application_tracking',
        'role' => 'Direct Encode'
    ]);

Route::get('/getuploadedDirectApply/{id}', function($id)
{
    if(Auth::user()->hasRole('CC Senior Account Officer') || Auth::user()->hasRole('CC Account Officer') || Auth::user()->hasRole('CC Tele Encoder' || Auth::user()->hasRole('B.I Client')))
    {

        $idToShow = base64_decode($id);

        $getPath = DB::table('bi_direct_applicant_endorsement')
            ->select('direct_profile_pic')
            ->where('id', $idToShow)
            ->get();

        $path = storage_path('direct_applicant_prof_pic/' . $getPath[0]->direct_profile_pic);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

            return $response;
    }
    else
    {
        return 'Access Denied';
    }




//    echo '<image src = storage/Desert.jpg>';
});
    
Route::get('direct_applicant_get_user_list',
    [
        'uses' => 'DirectEncodeController@direct_applicant_get_user_list',
        'as' => 'direct_applicant_get_user_list',
        'role' => 'Direct Encode'
    ]);
    
Route::post('bi_direct_upload_additional_from_return',
    [
        'uses' => 'DirectEncodeController@bi_direct_upload_additional_from_return',
        'as' => 'bi_direct_upload_additional_from_return',
        'role' => 'Direct Encode'
    ]);

Route::get('paypal-success-payment-func',
    [
        'uses' => 'DirectEncodeController@paypal_success_payment_func',
        'as' => 'paypal_success_payment_func',
        'role' => 'Direct Encode'
    ]);

Route::get('/dlALDirectApply/{id_encoded}', function($id_encoded)
{
    $id = base64_decode($id_encoded);

    $getDetails = DB::table('bi_direct_pivot')
        ->select('bi_id', 'id', 'declaration_path')
        ->where('endorse_id', $id)
        ->get();

    $pathToDL = storage_path('/direct_applicant_auth_letter/' .$getDetails[0]->bi_id . '/'.  $getDetails[0]->id . '/' .  $getDetails[0]->declaration_path);

    if(Auth::user()->hasRole('CC Senior Account Officer') || Auth::user()->hasRole('CC Account Officer') || Auth::user()->hasRole('CC Tele Encoder'))
    {
        if (!File::exists($pathToDL))
        {
            return 'Cannot locate file.';
        }
        else
        {
            return response()->download($pathToDL);
        }
    }
    else
    {
        return 'Wrong role, not accessible';
    }
});


//===========================================QUALITY ANALYST ROUTE========================================================


Route::get('qa-panel',
    [
        'uses' => 'QAController@qa_panel',
        'as' => 'qa-panel',
        'role' => 'Quality Analyst'
    ]);

Route::get('qa_get_auth_view',
    [
        'uses' => 'QAController@qa_get_auth_view',
        'as' => 'qa_get_auth_view',
        'role' => 'Quality Analyst'
    ]);
    
//===========================================TEST ROUTE========================================================



Route::get('ci-detach', function () {
    User::find(5)
        ->endorsements()
        ->wherePivot('endorsement_id', 585)
        ->detach();
});

Route::get('getRoleId', function () {
    $user = User::find(3);
    $position = $user->roles->first()->id;
    return $position;
});

Route::get('/download', function () {
    
    abort(404);
    // $user = Endorsement::find(485);
    // $path = $user->file_link;
    // return response()->download($path);
});

Route::get('/deleteFile', function () {
    $file = Endorsement::find(501);
    $filePath = $file->file_link;
    File::delete($filePath);
    $file->file_link = '';
    $file->save();
});

Route::get('dateDiff', function () {
//    $endorsements = Endorsement::find(503);
//    $date = Carbon::createFromFormat('Y-m-d H:s:i', $endorsements->date_endorsed.' '.$endorsements->time_endorsed);
//    $now = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now('Asia/Manila'));
//
//    return $date->diffInMinutes($now);
//    return Carbon::now('Asia/Manila');

    $endorsements = Endorsement::find(504);
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $endorsements->date_endorsed . ' ' . $endorsements->time_endorsed);
    $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Manila'));
    return $now->diffInMinutes($date, false);

});

Route::get('ci-list', function () {
    $credit_investigators = DB::table('role_user')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select(['users.name'])
        ->where('role_id', 4)
        ->Where('branch', Auth::user()->provinces->first()->id)
        ->get();
    return $credit_investigators;
});

Route::get('ci-account-count', function () {

    $timeStamp = Carbon::now('Asia/Manila');
    $splitDateTime = explode(" ", $timeStamp);
    $date = $splitDateTime[0];
    $time = $splitDateTime[1];

    $ci = DB::table('endorsement_user')
        ->join('users', 'users.id', '=', 'endorsement_user.user_id')
        ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
        ->where('endorsements.date_due', $date)
        ->where('user_id', 8)
        ->count();

    return $ci;
});

Route::get('online-user', function () {
    $onlineUser = DB::table('online_user')
        ->pluck('user_name');

    foreach ($onlineUser as $online) {
        echo $online . '<br>';
    }
});

Route::get('/generate-report', function (Request $request) {
    $report = DB::table('endorsements')
        ->select(['account_name', 'address'])
        ->where('date_due', $request->dateNow);

    return Datatables::of($report)
        ->make(true);
});

Route::get('/timestamp', function () {


    $dateEndorsed = Endorsement::find(8);
    $dateEndo = $dateEndorsed->date_endorsed;
    $timeEndorsed = Endorsement::find(8);
    $timeEndo = $timeEndorsed->time_endorsed;

    $timeStampNoww = Carbon::now('Asia/Manila');

    $dateEndorses = Carbon::parse($dateEndo . ' ' . $timeEndo);

    $timeLoss = $timeStampNoww->diffForHumans($dateEndorses);

    return $timeLoss;
});

Route::get('/print',
    [
        'uses' => 'PrintingController@GenReport',
        'as' => 'print'
    ]);

//Route::get('/broadcast', function () {
//
//
//    $userID = Auth::user()->id;
//
//    $getInfoMess = DB::table('chat_messages')
//        ->where('user_level', 'srao_dispatch_chat')
//        ->get();
//
//    return response()->json([$userID, $getInfoMess]);
//});


//Route::get('/pusher', function (Request $request) {
//
//
//    $timeStamp = Carbon::now('Asia/Manila');
//    $splitDateTime = explode(" ", $timeStamp);
//    $date = $splitDateTime[0];
//    $time = $splitDateTime[1];
//
//    $userID = Auth::user()->id;
//    $userName = Auth::user()->name;
//    $pix = Auth::user()->pix_path;
//
//    $getBranchofID = DB::table('provinces')
//        ->join('province_user', 'province_user.province_id', '=', 'provinces.id')
//        ->select('provinces.name as branch')
//        ->where('province_user.user_id', '=', $userID)
//        ->get();
//
//    $getPosofID = DB::table('roles')
//        ->join('role_user', 'role_user.role_id', '=', 'roles.id')
//        ->select('roles.name as pos')
//        ->where('role_user.user_id', '=', $userID)
//        ->get();
//
//
//    $countmess = DB::table('chat_messages')
//        ->where('user_level', 'srao_dispatch_chat')
//        ->count();
//
//
//    if ($countmess === 200) {
//        DB::table('chat_messages')
//            ->where('user_level', 'srao_dispatch_chat')
//            ->delete();
//
//    }
//
//    DB::table('chat_messages')
//        ->insert([
//            'user_id' => $userID,
//            'user_name' => $userName,
//            'posistion' => $getPosofID[0]->pos,
//            'branch' => $getBranchofID[0]->branch,
//            'message' => $request->message,
//            'pix_path' => $pix,
//            'date' => $date,
//            'time' => $time,
//            'user_level' => 'srao_dispatch_chat',
//            'count' => $countmess + 1
//        ]);
//
//
//    event(new SAOdispatchChat($userID, $request->message, $userName, $pix, $date, $time));
//});

//Route::get('/test', function () {
//    $getStatusAcct = DB::table('endorsements')
//        ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
//        ->join('provinces', 'provinces.id', '=', 'municipalities.province_id')
//        ->join('regions', 'regions.id', '=', 'provinces.region_id')
//        ->join('archipelagos', 'archipelagos.id', '=', 'regions.archipelago_id')
//        ->get();
//
//    return $getStatusAcct;
//});
//
//Route::get('/test1', function () {
//    DB::table('municipalities')
//        ->truncate();
//});
//
//Route::get('/testvote', function () {
//    $option = DB::table('options')
//        ->select('id', 'name')
//        ->get();
//
//    foreach ($option as $op_each) {
//        $count = DB::table('votes')
//            ->where('option_id', $op_each->id)
//            ->count();
//
//        echo '(' . $op_each->id . ')' . $op_each->name . ':' . $count . '<br>';
//    }
//});

Route::get('/down/{request}', function ()
{

    $webStatus = DB::table('downs')
        ->select(['web_status'])
        ->first();

    return $webStatus->web_status;

});

//Route::get('/endorsementfix69', function () {
//
//    $qq = DB::table('endorsement_user')
//        ->whereNull('client_id')
//        ->select('id', 'user_id')
//        ->get();
//
//    foreach ($qq as $q) {
//        DB::table('endorsement_user')
//            ->where('id', $q->id)
//            ->update([
//                'client_id' => $q->user_id
//            ]);
//    }
//
//    echo 'finish';
//});
//
//Route::get('/trytrim', function () {
//
//
//    $trimmer = new Trimmer();
//    echo($trimmer->trims('                    john patrick'.'            '.'        cabanero          '.' '.'          remobatac            !'));
//
//});
//
//Route::get('/corpchecker', function ()
//{
//
//    $dispStatus = DB::table('fund_requests')
//        ->select
//        (
//            'dispatcher_status'
//        )
//        ->where('id',27)
//        ->first();
//
//    return $dispStatus;
//});

Route::get('/testing', function ()
{
      return response()->json(
          [
              base64_encode(gzdeflate('indiclient@ccsi.com')),
              base64_encode(gzdeflate('indiclient'))
          ]
      );
});

//Clear migrate:
Route::get('/artisan/{command}', function($command) {
    $exitCode = Artisan::call($command);
    return '<h1>Php artisan: '.$command.' <br>'.$exitCode.'</h1>';
});


Route::get('/test_fund_remit', function ()
{
    $arratToDone = DB::table('fund_requests')
        ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
        ->leftjoin('users as dispatcher_id','dispatcher_id.id','=','fund_requests.dispatcher_id')
        ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
        ->select
        (
            [
                'fund_requests  .id as id',
                'ci_id.name as name_ci',
                'dispatcher_id.name as name_disp',
                'fund_requests.fund_amount as amount',
                'fund_requests.dispatcher_remarks as remarks',
                'fund_requests.type_of_fund_request',
                'count.type as type',
                DB::raw('count(count.fund_id) as count'),
            ]
        )
        ->groupBy('count.fund_id')
//            ->where('fund_requests.sao_id',Auth::user()->id)
        ->where('count.type','Processing','Transferred')
        ->where('fund_requests.sao_approved_date',null)
        ->where('fund_requests.dispatcher_status','ON-PROCESS')
        ->where('fund_requests.sao_status','')
        ->where('type_of_fund_request', 'NORMAL REQUEST')
//        ->get();
        ->count();

    return $arratToDone;
});

Route::get('/test_fund_atm', function ()
{
    $arratToDone = DB::table('fund_requests')
        ->join('users as ci_id','ci_id.id','=','fund_requests.ci_id')
        ->leftjoin('remittance','remittance.fund_id','=','fund_requests.id')
        ->leftjoin('ci_atm_fund','ci_atm_fund.fund_id','=','fund_requests.id')
        ->leftjoin('ci_shell_include_fund','ci_shell_include_fund.fund_id','=','fund_requests.id')
        ->leftjoin('ci_fund_remittances','ci_fund_remittances.fund_id','=','fund_requests.id')
        ->leftJoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
        ->leftJoin('fund_request_endorsements as count','count.fund_id','=','fund_requests.id')
        ->leftJoin('ci_shell_card_info','ci_shell_card_info.atm_id','=','ci_shell_include_fund.shell_id')
        ->leftJoin('ci_atms as if_shell','if_shell.id','=','ci_shell_card_info.atm_id')
        ->select(
            [
                'fund_requests.id as id',
            ]
        )
        ->groupBy('count.fund_id')
        ->where('fund_requests.sao_status','APPROVED')
        ->where('ci_fund_remittances.ci_atm_fund_id', '!=', 0)
        ->where('ci_atms.bank_name', 'BDO')
        ->where('fund_requests.approved_request_done', 'Pending')
        ->get();

    return count($arratToDone);
});


//Route::get('/clearfund_requests', function()
//{
//
//    $check =  DB::table('endorsements')
//        ->where('fund_request','!=','')
//        ->update([
//            'fund_request' => ''
//        ]);
//
//    return $check;
//
//});


Route::get('/encryption-save-this', function (Request $request)
{
    $str = base64_encode(gzdeflate($request->code));
    $str2 = gzinflate(base64_decode($str));
    echo $str;
});

Route::get('/test-excel', function(Request $request)
{

   $val_id = $request->val_id;
   $temp_name = $request->temp_name;
   $temp_name_file = $request->temp_name_file;
   $sheet_name_template = $request->sheet_name_template;
//   $temp_col_count = $request->temp_col_count;
//   $sheet_name_validation = $request->sheet_name_validation;
//   $validation_col_start = $request->validation_col_start;
//   $validation_col_end = $request->validation_col_end;

    //    $excel = Excel::selectSheets('BVRTEMP')->load(storage_path().'/BDO BVR.xlsx', function($reader)

    //for template
    $alph = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I' , 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
                'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
//    $file->move(storage_path('/bulk_excel_bi/'), $name);

    $template_excel_name = $temp_name_file;
    $template_excel_sheet = $sheet_name_template;
//    $template_col_count = $temp_col_count;
//    $template_excel_name = 'PNB BVR.xlsx';
//    $template_excel_sheet = 'BVRTEMP';

    $excel = Excel::selectSheets($template_excel_sheet)->load((storage_path().'/EncodableFormForCI/'.$template_excel_name), function ($reader) {
        $reader->toArray();
        $reader->noHeading();
//        $reader->getSheet(0);
    })->get();

    $temo_row = 0;
    for($i = 0; $i < count($excel); $i++)
    {
        $newArray = [];
        $temp_col = 0;
        for($j = 0; $j < count($excel[$i]); $j++)
        {
            if($excel[$i][$j] !== null)
            {
                $newArray[$temp_col] = [
                    'LABEL' => $excel[$i][$j],
                    "POINT" => $alph[$j].''.($i+1),
                ];
                $temp_col++;
            }
        }

        if(count($newArray) !== 0)
        {
            $newArray_row[$temo_row] = [
                'ROW' => $newArray,
            ];
            $temo_row++;
        }
    }

//    put if else if the selection is in another sheet

    $template_excel_name_selection = $temp_name_file;
//    $template_excel_sheet_selection = $sheet_name_validation;
//    $starting_col = $validation_col_start;
//    $ending_col = $validation_col_end;

//    $template_excel_name_selection = 'MITSUBISHI EVR.xlsx';
//    $template_excel_sheet_selection = 'EVR2';
//    $starting_col = 7;
//    $ending_col = 34;

    $excel_selection = Excel::selectSheets('DROPDOWN LIST')->load((storage_path().'/EncodableFormForCI/'.$template_excel_name_selection), function ($reader) {
        $reader->toArray();
        $reader->noHeading();
        $reader->getSheet(0);
    })->get();

    $col_counter = 0;
    $newArray_row_selection = [];
    for($row = 0; $row < count($excel_selection); $row++)
    {
        $newArray_selection = [];
        $row_counter = 0;

        for($col = 0; $col < count($excel_selection[$row]); $col++)
        {
            if(strpos($excel_selection[$row][$col],'SELECT||pt') !== false)
            {
                $newArray_selection[$row_counter] =
                    [
                        'SELECT' => $excel_selection[$row][$col],
                        'POINT' => $alph[$col].''.($row+1)
                    ];
                $row_counter++;
            }
        }

        if(count($newArray_selection) !== 0)
        {
            $newArray_row_selection[$col_counter] =
                [
                    'COL_SELECT' => $newArray_selection,
                ];
            $col_counter++;
        }
    }


    return response()->json([
        'TEMPLATE' => $newArray_row,
        'VALIDATION' => $newArray_row_selection
        ]);
});

Route::get('/insert_access', function ()
{
    $getAdminId = DB::table('role_user')
        ->select('user_id')
        ->where('role_id', 12)
        ->get();

    $getManageID = DB::table('role_user')
        ->select('user_id')
        ->where('role_id', 5)
        ->get();

    $getSaoID = DB::table('role_user')
        ->select('user_id')
        ->where('role_id', 7)
        ->get();

    foreach($getAdminId as $id1)
    {
        DB::table('users')
            ->where('id', $id1->user_id)
            ->update
            ([
                'admin_access_1' => 'Granted',
                'admin_access_2' => 'Granted',
                'admin_access_3' => 'Granted'
            ]);
    }

    foreach($getManageID as $id2)
    {
        DB::table('users')
            ->where('id', $id2->user_id)
            ->update
            ([
                'requi_check' => 'Granted',
            ]);
    }

    foreach($getSaoID as $id3)
    {
        DB::table('users')
            ->where('id', $id3->user_id)
            ->update
            ([
                'mrf_check' => 'Granted',
            ]);
    }

    return 'done';
});

Route::get('/add-created-add-fund-requests', function()
{
    $b = DB::table('fund_requests')
        ->select
        ([
            'fund_requests.id as id',
            // 'ci_id.name as name_ci',
//            \DB::raw("UPPER(ci_id.name) as name_ci"),
//            'sao_id.name as name_sao',
            'fund_requests.fund_amount as amount',
            'fund_requests.dispatcher_remarks as dispatcher_remarks',
            'fund_requests.sao_remarks as sao_remarks',
            'fund_requests.finance_remarks as finance_remarks',
            'fund_requests.date_time_remarks as date_time_remarks',
            'fund_requests.dispatcher_request_date as dispatcher_request_date',
            'fund_requests.sao_approved_date as sao_approved_date',
            'fund_requests.finance_approved_date as finance_approved_date',
            'fund_requests.delivered_date as delivered_date',
            'fund_requests.type_of_fund_request as tor',
            'fund_requests.ci_id as ci_id',
//            'count.fund_id as fund_id',
            'fund_requests.approved_incident_remarks as incident',
            'fund_requests.approved_request_done as done',
            'fund_requests.liquidated_amount as liq',
            'fund_requests.unliquidated_amount as unliq',
            'fund_requests.audit_remarks as audit_remarks',
            'fund_requests.sao_emergency_req_date_time as sao_date',
//            'archipelagos.archipelago_name as archi',
//            'manage_approved_id.name as manage_name',
            'fund_requests.management_remarks_approved as rem_manage',
            'fund_requests.sao_emergency_req_date_time as sao_time_req'
        ])
        ->get();


    for($r = 0; $r < count($b); $r++)
    {
        if($b[$r]->dispatcher_request_date == '0000-00-00 00:00:00' || $b[$r]->dispatcher_request_date == null)
        {
            DB::table('fund_requests')
                ->where('id',$b[$r]->id)
                ->update
                ([
                    'created_at' => $b[$r]->sao_date
                ]);
        }
        else if($b[$r]->sao_date == '0000-00-00 00:00:00' || $b[$r]->sao_date == null)
        {
            DB::table('fund_requests')
                ->where('id',$b[$r]->id)
                ->update
                ([
                    'created_at' => $b[$r]->dispatcher_request_date
                ]);
        }
    }

    return 'done';
});

Route::post('/word-test', function (Request $request)
{
    $data = json_decode($request->to_send,true);
    $titles = $request->titles_array;
    $test = [];
    $test_holder = [];
    $to_count = $data['encode'];

    $wordTest = new \PhpOffice\PhpWord\PhpWord();
    $newSection = $wordTest->addSection();

    for($master = 0; $master < count($to_count); $master++)
    {
        $test[$master] = [];
        for($i = 0; $i < count($to_count[$titles[$master]]); $i++)
        {
            array_push($test[$master], $to_count[$titles[$master]][$i]);
        }
        $test_holder[$master] = implode(' | ', $test[$master]);

        $newSection->addText($test_holder[$master]);
//        $newSection->addText('');
    }

    $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');

    try
    {
        $objectWriter->save(storage_path('testfile.docx'));
    }
    catch (Exception $e)
    {

    }

    return response()->download(storage_path('testfile.docx'));

//    return response()->download(storage_path('testfile.docx'));
});

Route::get('/bi-finished-test', function()
{
    $user = User::find(665); // localhost RANYLL
    Auth::login($user);

    $get_general_table = DB::table('bi_endorsements')
        ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
        ->leftjoin('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
        ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
        ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
        ->select
        ([
            'bi_endorsements.id as endorse_id',
            'bi_endorsements.bi_account_name as site',
            'bi_endorsements.created_at as date_time_endorsed',
            'bi_endorsements.project as project',
            'bi_endorsements.account_name as account_name',
            'bi_endorsements.package as package',
            'bi_endorsements_checkings.checking_name as check',
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
        ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
        ->where('bi_account_to_users.users_id',Auth::user()->id)
        ->where('bi_endorsements.status', 10)
        ->where(function($query)
        {
            return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
        })
        ->get();

    return $get_general_table;

//    return DataTables::of($get_general_table)
//        ->editColumn('attachments', function ($query)
//        {
//            $get_attachment = DB::table('bi_endorsements')
//                ->select([
//                    'bi_endorsements.attach_1 as attach_1',
//                    'bi_endorsements.attach_2 as attach_2',
//                    'bi_endorsements.attach_3 as attach_3',
//                    'bi_endorsements.attach_4 as attach_4',
//                ])
//                ->where('bi_endorsements.id',$query->endorse_id)
//                ->get();
//
//            if(count($get_attachment) == 0)
//            {
//                return 'NO ATTACHMENT';
//            }
//            else
//            {
//                $downloads = '';
//
//                if($get_attachment[0]->attach_1 != '')
//                {
//                    $downloads .= '1. '.$get_attachment[0]->attach_1.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="1" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
//                }
//                else
//                {
//                    $downloads .='<p>1. none</p>';
//                }
//
//                if($get_attachment[0]->attach_2 != '')
//                {
//                    $downloads .= '2. '.$get_attachment[0]->attach_2.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="2" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
//                }
//                else
//                {
//                    $downloads .='<p>2. none</p>';
//                }
//
//                if($get_attachment[0]->attach_3 != '')
//                {
//                    $downloads .= '3. '.$get_attachment[0]->attach_3.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="3" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
//                }
//                else
//                {
//                    $downloads .='<p>3. none</p>';
//                }
//
//                if($get_attachment[0]->attach_4 != '')
//                {
//                    $downloads .= '4. '.$get_attachment[0]->attach_4.'<br><a class="btn_download_bi_files btn btn-xs btn-info btn-block" id="'.$query->endorse_id.'" name="4" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-download-alt"></i> Download</a>';
//                }
//                else
//                {
//                    $downloads .='<p>4. none</p>';
//                }
//
//
//                return $downloads;
//            }
//        })
//        ->editColumn('check', function ($query)
//        {
//            $get_check = DB::table('bi_endorsements_checkings')
//                ->select([
//                    'checking_name',
//                    'type_check'
//                ])
//                ->where('bi_endorsement_id',$query->endorse_id)
//                ->get();
//
//            if(count($get_check) == 0)
//            {
//                return 'NO CHECK';
//            }
//            else if($get_check[0]->checking_name == 'N/A' || $get_check[0]->type_check == 'N.A')
//            {
//                return 'N/A';
//            }
//            else
//            {
//                $checkings = '';
//                $check_alacarte = false;
//                $get_alacarte_check = '';
//
//                foreach($get_check as $check)
//                {
//
//                    if($check->type_check == 'package')
//                    {
//                        $checkings.= '* '.$check->checking_name.'. <br>';
//                    }
//                    else if($check->type_check == '')
//                    {
//                        $checkings.= '* '.$check->checking_name.'. <br>';
//                    }
//                    else if($check->type_check == 'alacarte')
//                    {
//                        $get_alacarte_check.= '* '.$check->checking_name.'. <br>';
//                        $check_alacarte = true;
//                    }
//                }
//
//                if($check_alacarte)
//                {
//                    $checkings .= '<br>---( Additional Check )--- <br>';
//                }
//
//                return $checkings.$get_alacarte_check;
//            }
//        })
//        ->editColumn('status', function ($query)
//        {
//            $dateDue = Carbon::createFromFormat('Y-m-d H:i:s', $query->due);
//            $dateFinished = Carbon::createFromFormat('Y-m-d H:i:s', $query->finish);
//            $statusTat = '';
//            $difference_min = $dateFinished->diffInMinutes($dateDue, false);
//            $dateTimeSent = '<br>Date and Time Sent : <br><br>'. $query->finish;
//
//            if($difference_min >= 0)
//            {
//                $statusTat = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> WITHIN TAT</a>';
//            }
//            else if($difference_min < 0)
//            {
//                $statusTat = '<a class="btn btn-xs bg-black btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> LATE</a>';
//            }
//
////                if($query->status_report == 'Complete')
////                {
////                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' .
////                        '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '.$query->status_report.'</a>' . $statusTat;
//
//            return $statusTat . $dateTimeSent;
////                }
////                else
////                {
////                return $statusTat;
//
////                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' .
////                        '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> '.$query->status_report.' </a>' . $statusTat;
////                }
//        })
//        ->rawColumns([
//            'attachments',
//            'check',
//            'status'
//        ])
//        ->make(true);
});

Route::get('/compare_ci', function ()
{
    $compPlus = 0;
    $compCi = 0;
    $ciNames = '';

    $countall = 0;

    $getCIids = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->select('users.Emp_ID as emp_id', 'users.name as name')
        ->where('role_user.role_id', 4)
        ->where('users.archive', 'false')
        ->get();

    $getIdHr = DB::table('users_atm')
        ->select('emp_id_no')
        ->get();

    foreach($getCIids as $ci)
    {
        $ciCheckBool = false;
        $test = str_replace('-', '', $ci->emp_id);
        $test2 = '';


        foreach ($getIdHr as $emp)
        {
            $test2 = str_replace('-', '', $emp->emp_id_no);

            if ($ci->emp_id == $test2 || $ci->emp_id == $emp->emp_id_no)
            {
                $ciCheckBool = true;
            }
        }

        if($ciCheckBool == false)
        {
            $ciNames .= $ci->name . '<br>';
            $compCi++;
        }
        else
        {
            $compPlus++;
        }

        $countall++;
    }

    return $ciNames;
});

Route::get('check-email-test', function()
{
    $check_if_client = DB::table('user_client')
        ->where('user_id','=' ,828)
        ->where(function ($query)
        {
            return $query->orwhere('user_branch',423)
                    ->orwhere('user_branch',486)
                    ->orwhere('user_branch',345)
                    ->orwhere('user_branch',411)
                    ->orwhere('user_branch',356)
                    ->orwhere('user_branch',812)
                    ->orwhere('user_branch',388)
                    ->orwhere('user_branch',950);
        })
        ->count();
        
        return $check_if_client;
});

Route::get('test-routeee',function()
{
    $type_holder = 'cc_bank';

    $data = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->leftjoin('attendance_all_employee', 'attendance_all_employee.user_id', '=', 'users.id')
        ->where('attendance_all_employee.created_at', '<=', Carbon::now('Asia/Manila'))
        ->where('attendance_all_employee.created_at', '>=', Carbon::now('Asia/Manila')->subDay(1))
        ->where('role_user.role_id', '=', 17)
        ->where('users.archive', '!=', 'True')
        ->groupBy('users.id')
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

    return $data;

});

Route::get('user-agent-test-routee', function(Request $request)
{
    $impre['useragent'] = $request->userAgent();
    $input['ip'] = $request->ip();
    return response()->json([$impre, $input]);
});

Route::get('value_testing', function()
{
    $bi_client_bank = DB::table('bi_account_to_users')
        ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
        ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
        ->groupBy('bi_account_to_users.bi_account_id')
        ->orderBy('bi_account_to_users.id', 'desc')
        ->where(function($query)
        {
            return $query->orwhere('users.client_check', '=', 'tat_selector')
                ->orwhere('users.client_check', '=', '')
                ->orwhere('users.client_check', '=', null)
                ->orwhere('users.client_check', '!=', 'cc_bank');
        })
        ->where('bi_account_to_users.to_display', '=', 'display')
        // ->where('users.client_check', '!=', 'cc_bank')
        ->select([
            'bi_account_to_users.bi_account_id',
            DB::raw('CONCAT(bi_account_list.bi_account_name, " ", bi_account_list.account_location) AS site_name'),
            'users.client_check as client_check'
        ])
        ->get();

    return $bi_client_bank;
});

Route::get('get-all-tfs',function()
{
    $array_val_holder = [];
    $to_insert = [];

    //    $getAllView = DB::table('users')
//        ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
//        ->where('bi_account_to_users.bi_account_id', '=', 35)
//        ->select('users.id as users_id', 'bi_account_to_users.bi_account_id')
//        ->get();

//    foreach($getAllView as $already_added)
//    {
        $whareStr = '@toyotafinancial.ph';
        $getVal = DB::table('users')
            ->join('bi_account_to_users','bi_account_to_users.users_id', '=', 'users.id')
            ->where('users.login_check', '=', 'TFS')
//            ->where('users.id', $already_added->users_id)
            ->where('users.email', 'LIKE', '%'.$whareStr.'%')
            ->where(function($query)
            {
                return $query->where('bi_account_to_users.bi_account_id', '=', 67)
                    ->orwhere('bi_account_to_users.bi_account_id', '!=', 22);
            })
            ->where('bi_account_to_users.to_display', '!=', 'display')
            ->select('bi_account_to_users.bi_account_id')
            ->get();

        if(count($getVal) > 0)
        {
            array_push($array_val_holder, $getVal[0]->bi_account_id);
        }
//    }

    $getAllTFS = DB::table('users')
        ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
        ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
        ->where('users.login_check', '=', 'TFS')
        ->where('bi_account_to_users.to_display', '=', 'display')
        ->select([
            'users.id as user_id',
            'bi_account_to_users.bi_account_id as bi_id',
            \DB::raw("CONCAT(bi_account_list.bi_account_name,' ',bi_account_list.account_location) as bi_name")
        ])
        ->groupBy('bi_account_list.id')
        ->get();

    if(count($getAllTFS) > 0)
    {
        foreach($getAllTFS as $user)
        {
            if(count($getVal) > 0)
            {
                if(in_array($user->bi_id, $array_val_holder))
                {
                    array_push($to_insert, $user->bi_id);
                }
            }
        }
    }

    //   foreach($to_insert as $adding_bi_account)
    //   {
    //       DB::table('bi_account_to_users')
    //           ->insert([
    //               'users_id' => 865,
    //               'bi_account_id' => $adding_bi_account,
    //               'created_at' => Carbon::now('Asia/Manila')

    //       ]);
    //   }



    return response()->json(['all_accounts'=> $getVal, 'all_user' =>$getAllTFS, 'to_be_added' => $to_insert]);


});

Route::get('get-all-tfsph/{id}', function($id)
{
    $chunk_existing_array = [];
    $to_add = [];
    $getAllBiLoc = DB::table('bi_account_list')
        ->where('account_location', '=', 'TFSPH')
        ->select('id')
        ->get();

    $getExisting = DB::table('bi_account_to_users')
        ->where('users_id', '=', $id)
        ->select('bi_account_id')
        ->get();

    foreach($getExisting as $chunk_existing)
    {
        array_push($chunk_existing_array, $chunk_existing->bi_account_id);
    }

    foreach($getAllBiLoc as $chunk_to_add)
    {
        if(!in_array($chunk_to_add->id, $chunk_existing_array))
        {
            array_push($to_add, $chunk_to_add->id);
            DB::table('bi_account_to_users')
                ->insert([
                    'users_id' => $id,
                    'bi_account_id' => $chunk_to_add->id,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
    }

    return response()->json(['to_add' => $to_add, 'existing'=> $getExisting]);
});

Route::get('bank_endo_no_action', function(Request $request)
{
    $endo = Endorsement::find($request->id);
    $endo->type_of_sending_report = 'TEMPLATE';
    $endo->save();

    return 'SET VALUE = ' . $endo->type_of_sending_report;
});

Route::get('check_if_existing_ip_attendance', function(Request $request)
{
    $to_return = '';
    $getData = DB::table('attendance_all_employee')
        ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
        ->where('ip_address', '=', $request->ipAddress)
        ->select([
            'users.name as employee_name',
            'attendance_all_employee.ip_address as ip'
        ])
        ->get();

    foreach($getData as $chunks)
    {
        $to_return .= '<p>Name='.$chunks->employee_name .' IP='. $chunks->ip .'</p>';
    }

    return $to_return;
});

Route::get('get_user_attendance',function(Request $request) {

    $from = Carbon::parse(explode(' ', Carbon::parse($request->from))[0]);
    $to = Carbon::parse(explode(' ', Carbon::parse($request->to))[0]);
    $get_data = [];
    $data_index = 0;
    $data_index_2 = 0;
    $time_now  = explode(' ', Carbon::  now('Asia/Manila'))[1];
    $getdiff = $from->diffInDays($to);
    $remarks= "";
    $user_name = User::find($request->id)->name;
    $position_role = User::find($request->id)->roles()->first()->name;
    $branch = User::find($request->id)->provinces()->first()->name;
    $work_start = User::find($request->id)->work_start;
    $work_end = User::find($request->id)->work_end;

    $sched = '';
    $remarks = '';


    $first_report_var_holder_ao = [];
    $first_report_var_holder_dispatcher = [];
    $first_report_var_holder_ccao = [];
    $first_report_var_holder_tele = [];


    for ($i = 0; $i <= $getdiff; $i++)
    {
        if ($i == 0) {
            $now = $from;
        }
        else
        {
            $now = $from->addDay(1);
        }
//         $getTimeFinishedAO = DB::table('endorsements')
//             ->join('endorsement_user', 'endorsement_user.endorsement_id', '=', 'endorsements.id')
//             ->where('endorsement_user.user_id', $request->id)
//             ->where('endorsement_user.position_id', 3)
//             ->where('endorsements.date_endorsed', '<=', Carbon::parse($now))
//             ->where('endorsements.date_endorsed', '>', Carbon::parse($now)->subDay(1))
//             ->select([
//                 'endorsements.date_forwarded_to_client as date_finished',
//                 'endorsements.time_forwarded_to_client as time_finished'
//             ])
//             ->orderBy('endorsements.id', 'asc')
//             ->get();

//         if(count($getTimeFinishedAO) > 0)
//         {
//             array_push($first_report_var_holder_ao, $getTimeFinishedAO[0]->date_finished . ' ' . $getTimeFinishedAO[0]->time_finished);
//         }
//         else
//         {
//             array_push($first_report_var_holder_ao, '-');
//         }

// //                        ==============Dispatcher=======================
//         $getTimeFinishedDispatcher = DB::table('endorsements')
//             ->join('endorsement_user', 'endorsement_user.endorsement_id', '=', 'endorsements.id')
//             ->where('endorsement_user.user_id', $request->id)
//             ->where('endorsement_user.position_id', 2)
//             ->where('endorsements.date_endorsed', '<=', Carbon::parse($now))
//             ->where('endorsements.date_endorsed', '>', Carbon::parse($now)->subDay(1))
//             ->select([
//                 'endorsements.date_dispatched as date_finished',
//                 'endorsements.time_dispatched as date_finished'
//             ])
//             ->orderBy('endorsements.id', 'asc')
//             ->get();

//         if(count($getTimeFinishedDispatcher) > 0)
//         {
//             array_push($first_report_var_holder_dispatcher, $getTimeFinishedDispatcher[0]->date_finished . ' ' . $getTimeFinishedDispatcher[0]->date_finished);
//         }
//         else
//         {
//             array_push($first_report_var_holder_dispatcher, '-');
//         }

// //                        ------------------CC AccountOfficer------------------

//         $getTimeFinishedCCAO = DB::table('bi_endorsements')
//             ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
//             ->where('bi_endorsements_users.users_id', $request->id)
//             ->where('bi_endorsements_users.position_id', 16)
//             ->where('bi_endorsements.created_at', '<=', Carbon::parse($now))
//             ->where('bi_endorsements.updated_at', '>', Carbon::parse($now)->subDay(1))
//             ->select([
//                 'bi_endorsements.date_time_approved as date_finished',
//             ])
//             ->orderBy('bi_endorsements.id', 'asc')
//             ->get();

//         if(count($getTimeFinishedCCAO) > 0)
//         {
//             array_push($first_report_var_holder_ccao, $getTimeFinishedCCAO[0]->date_finished);
//         }
//         else
//         {
//             array_push($first_report_var_holder_ccao, '-');
//         }

//         //------------------CC TELE------------------


//         $getTimeFinishedtele = DB::table('bi_endorsements')
//             ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
//             ->where('bi_endorsements_users.users_id', $request->id)
//             ->where('bi_endorsements_users.position_id', 17)
//             ->where('bi_endorsements.created_at', '<=', Carbon::parse($now))
//             ->where('bi_endorsements.updated_at', '>', Carbon::parse($now)->subDay(1))
//             ->select([
//                 'bi_endorsements.updated_at as date_finished',
//             ])
//             ->orderBy('bi_endorsements.id', 'asc')
//             ->get();

//         if(count($getTimeFinishedtele) > 0)
//         {
//             array_push($first_report_var_holder_tele, $getTimeFinishedtele[0]->date_finished);
//         }
//         else
//         {
//             array_push($first_report_var_holder_tele, '-');
//         }

        $getAttendance_in = DB::table('attendance_all_employee')
            ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
            ->join('roles', 'roles.id', '=', 'attendance_all_employee.pos_id')
            ->whereDate('attendance_all_employee.created_at', '<=', Carbon::parse($now))
            ->whereDate('attendance_all_employee.created_at', '>', Carbon::parse($now)->subDay(1))
            ->where('attendance_all_employee.user_id', '=', $request->id)
            ->where('attendance_all_employee.type', '=', 'TIME-IN')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.work_start as work_start',
                'users.work_end as work_end',
                'attendance_all_employee.time_in as time_in',
                'attendance_all_employee.type as type',
                'attendance_all_employee.ip_address as ip',
                // 'attendance_all_employee.user_agent as user_agent'
            ])
            ->orderBy('attendance_all_employee.id', 'asc')
            ->get();

        $getAttendance_out = DB::table('attendance_all_employee')
            ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
            ->join('roles', 'roles.id', '=', 'attendance_all_employee.pos_id')
            ->whereDate('attendance_all_employee.created_at', '<=', Carbon::parse($now))
            ->whereDate('attendance_all_employee.created_at', '>', Carbon::parse($now)->subDay(1))
            ->where('attendance_all_employee.user_id', '=', $request->id)
            ->where('attendance_all_employee.type', '=', 'TIME-OUT')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.work_start as work_start',
                'users.work_end as work_end',
                'attendance_all_employee.time_in as time_in',
                'attendance_all_employee.type as type',
                'attendance_all_employee.ip_address as ip',
            ])
            ->orderBy('attendance_all_employee.id', 'asc')
            ->get();
            
             $getAttendance_break_in = DB::table('attendance_all_employee')
            ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
            ->join('roles', 'roles.id', '=', 'attendance_all_employee.pos_id')
            ->whereDate('attendance_all_employee.created_at', '<=', Carbon::parse($now))
            ->whereDate('attendance_all_employee.created_at', '>', Carbon::parse($now)->subDay(1))
            ->where('attendance_all_employee.user_id', '=', $request->id)
            ->where('attendance_all_employee.type', '=', 'BREAKTIME-IN')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.work_start as work_start',
                'users.work_end as work_end',
                'attendance_all_employee.time_in as break_in',
                'attendance_all_employee.type as type',
                'attendance_all_employee.ip_address as ip',
            ])
            ->orderBy('attendance_all_employee.id', 'asc')
            ->get();

        $getAttendance_break_out = DB::table('attendance_all_employee')
            ->join('users', 'users.id', '=', 'attendance_all_employee.user_id')
            ->join('roles', 'roles.id', '=', 'attendance_all_employee.pos_id')
            ->whereDate('attendance_all_employee.created_at', '<=', Carbon::parse($now))
            ->whereDate('attendance_all_employee.created_at', '>', Carbon::parse($now)->subDay(1))
            ->where('attendance_all_employee.user_id', '=', $request->id)
            ->where('attendance_all_employee.type', '=', 'BREAKTIME-OUT')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.work_start as work_start',
                'users.work_end as work_end',
                'attendance_all_employee.time_in as break_out',
                'attendance_all_employee.type as type',
                'attendance_all_employee.ip_address as ip',
            ])
            ->orderBy('attendance_all_employee.id', 'asc')
            ->get();

        $get_data[$i]['name'] = $user_name;
        $get_data[$i]['position'] = $position_role;
        $get_data[$i]['branch'] = $branch;
        $get_data[$i]['work_start'] = $work_start;
        $get_data[$i]['work_end'] = $work_end;

        if (count($getAttendance_in) > 0) {
            $data_index_2++;
            $get_data[$i]['time_in'] = $getAttendance_in[0]->time_in;
        } else {
            $get_data[$i]['time_in'] = '-';
        }

        if (count($getAttendance_out) > 0) {
            $data_index_2++;
            $get_data[$i]['time_out'] = $getAttendance_out[0]->time_in;
        } else {
            $get_data[$i]['time_out'] = '-';
        }
        
         if (count($getAttendance_break_in) > 0) {
            $data_index_2++;
            $get_data[$i]['break_in'] = $getAttendance_break_in[0]->break_in;
        } else {
            $get_data[$i]['break_in'] = '-';
        }

        if (count($getAttendance_break_out) > 0) {
            $data_index_2++;
            $get_data[$i]['break_out'] = $getAttendance_break_out[0]->break_out;
        } else {
            $get_data[$i]['break_out'] = '-';
        }

        if (count($getAttendance_in) > 0) {
            $data_index_2++;
            $get_data[$i]['ip_address'] = $getAttendance_in[0]->ip;
        } else {
            $get_data[$i]['ip_address'] = '-';
        }

    }

    if($data_index_2 > 0)
    {
        $generated_date = $request->from . ' to ' . $request->to;

        $from2 = Carbon::parse(explode(' ', Carbon::parse($request->from))[0]);
        Excel::load(storage_path().'/Generated Attendance Form1.xlsx', function($doc) use($get_data, $generated_date, $data_index, $from2, $first_report_var_holder_ao,  $first_report_var_holder_dispatcher, $first_report_var_holder_ccao, $first_report_var_holder_tele) {
            $sheet = $doc->setActiveSheetIndex(0);
            $sheet->setCellValue('A1', $get_data[$data_index]['name'].'  '.'GENERATED DATE:  ' .$generated_date);
//            $sheet->setCellValue('A1' . $get_data[$data_index]['name']);

            for ($iii = 4; $iii < (count($get_data) + 4); $iii++) {

                if ($data_index == 0) {
                    $now = $from2;
                } else

                {
                    $now = $from2->addDay(1);
                }


                $sheet->setCellValue('B' . $iii, $get_data[$data_index]['position']);
                $sheet->setCellValue('G' . $iii, $get_data[$data_index]['branch']);
                $sheet->setCellValue('F' . $iii, $get_data[$data_index]['ip_address']);
                // $sheet->setCellValue('K' . $iii, $get_data[$data_index]['user_agent']);
                $sheet->setCellValue('H' . $iii, $get_data[$data_index]['work_start'] . ' - ' . $get_data[$data_index]['work_end']);

                // if ($get_data[$data_index]["position"] == 'Account Officer') {
                //     $sheet->setCellValue('L' . $iii, $first_report_var_holder_ao[$data_index]);
                // } else if ($get_data[$data_index]["position"] == 'Dispatcher') {
                //     $sheet->setCellValue('L' . $iii, $first_report_var_holder_dispatcher[$data_index]);
                // } else if ($get_data[$data_index]["position"] == 'CC Account Officer') {
                //     $sheet->setCellValue('L' . $iii, $first_report_var_holder_ccao[$data_index]);
                // } else if ($get_data[$data_index]["position"] == 'CC Tele Encoder') {
                //     $sheet->setCellValue('L' . $iii, $first_report_var_holder_tele[$data_index]);
                // }

                if($get_data[$data_index]['time_in'] != '-' )
                {
                    $sheet->setCellValue('A' . $iii, date('F j, ', strtotime($get_data[$data_index]["time_in"])));
                    $sheet->setCellValue('B' . $iii, date('g:i A', strtotime($get_data[$data_index]["time_in"])));
                }
                else
                {
                   $sheet->setCellValue('A' . $iii, ('-'));
                   $sheet->setCellValue('B' . $iii, ('-'));
                }
                if($get_data[$data_index]['time_out'] != '-' )
                {
                    $sheet->setCellValue('C' . $iii, date('g:i A', strtotime($get_data[$data_index]["time_out"])));
                }
                else
                {
                    $sheet->setCellValue('C' . $iii, ('-'));
                }
                
                 if ($get_data[$data_index]['break_in'] != '-') {
                    $sheet->setCellValue('D' . $iii, date('g:i A', strtotime($get_data[$data_index]["break_in"])));
                } else {
                    $sheet->setCellValue('D' . $iii, '-');
                }

                if ($get_data[$data_index]['break_out'] != '-') {
                    $sheet->setCellValue('E' . $iii, date('g:i A', strtotime($get_data[$data_index]["break_out"])));
                } else {
                    $sheet->setCellValue('E' . $iii, '-');
                }

                $data_index++;
            }

        })
            ->setFilename('Employee Attendance Dated '. $generated_date)
            ->store('xlsx', storage_path('attendance_specific_employee/'. $generated_date));

        return response()->download(storage_path('attendance_specific_employee/'. $generated_date. '/'. 'Employee Attendance Dated '. $generated_date. '.xlsx'));
    }
    else
    {
        return "<script>alert('NO RECORDS FOUND');window.close();</script>";
    }

});

Route::get('check_sms_status', function()
{
    $smsCheck = new \App\Generals\SmsNotification();
    $iTexmoResult = json_decode($smsCheck->CheckSMSStatus());

    return response()->json($iTexmoResult->result);
});


Route::get('check_sms_credits', function()
{
    $smsCheck = new \App\Generals\SmsNotification();
    $iTexmoResult = json_decode($smsCheck->CheckSMSCredits());

    return response()->json($iTexmoResult);
 });

Route::get('bi_add_checking_route', function()
{
    
    return abort(404);
//    set_time_limit(5000);
    $packageArray = [];
    $checkingArray = [];
    $checkingCtr = 0;
    $checkingCtr2 = 0;
    $package_id = '';
    $get_pivot_id_package_bi = '';

    $excel = Excel::load(storage_path('Packages3.xlsx'), function ($reader) {
        $reader->toArray();
        $reader->noHeading();
        $reader->first();
    })->get();

    for($i = 0; $i < count($excel); $i++) {
        for ($o = 0; $o < count($excel[$i]); $o++) {
            if ($excel[$i][$o] != null) {
                if ($o == 0) {
                    $trimmer = preg_replace("/\n/", ' ', $excel[$i][$o]);

//                    array_push($packageArray, $excel[$i][$o]);
                    array_push($packageArray, $trimmer);
                    $checkingCtr2 = 0;

                    if ($i == 0) {

                    } else {
                        $checkingCtr++;
                    }
                } else {
                    $checkingArray[$checkingCtr][$checkingCtr2] = $excel[$i][$o];
                    $checkingCtr2++;
                }
            }

        }
    }

    for($ii = 0; $ii < count($packageArray); $ii++)
    {
        $package_id = DB::table('package_list')
            ->insertGetId([
                'package' => $packageArray[$ii]
            ]);

        $get_pivot_id_package_bi = DB::table('package_to_account')
            ->insertGetId([
                'bi_account_id' => 155,
                'package_id' => $package_id
            ]);

        for($hehe = 0; $hehe < count($checkingArray[$ii]); $hehe++)
        {

            $checking_id = DB::table('checking_list')
                ->insertGetId([
                    'checking_name' => $checkingArray[$ii][$hehe],
                    'information' => $checkingArray[$ii][$hehe],
                    'ocular' => 'false'
                ]);

            $get_pivot_id_checking = DB::table('checking_to_package')
                ->insertGetId([
                    'package_to_account_id' => $get_pivot_id_package_bi,
                    'checking_id' => $checking_id
                ]);
        }
    }

    return response()->json([$packageArray, $checkingArray]);
});