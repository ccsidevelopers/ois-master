<?php

namespace App\Http\Controllers;

use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\TatController;
use App\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;
use App\Generals\AuditQueries;


class MarketingController extends Controller
{
    public function getMarketingDashboard()
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
            } elseif (Auth::user()->hasRole('Marketing'))
            {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

//                THIS BLOCK OF LINE IS FOR TO DO LIST CALENDAR
                $events = [];
                $data = Event::all();
                if($data->count()) {
                    foreach ($data as $key => $value)
                    {
                        $events[] = Calendar::event
                        (
                            $value->title,
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.' +1 day'),
                            null,
                            // Add color and link on event
                            [
                                'color' => '#ff0000',
//                                'url' => 'pass here url and any route',
                            ]
                        );
                    }
                }
                $calendar = Calendar::addEvents($events);
//                END OF TO DO LIST CALENDAR

                return view('marketing.marketing-dashboard', compact('timeStamp','calendar'))->with(["page" => "marketing-dashboard"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getMarketingPanel()
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
            } elseif (Auth::user()->hasRole('Marketing'))
            {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $dateNow = $timeStamp;
                $time = $splitDateTime[1];



//                THIS BLOCK OF LINE IS FOR TO DO LIST CALENDAR
                $events = [];
                $data = Event::all();
                if($data->count()) {
                    foreach ($data as $key => $value)
                    {
                        $events[] = Calendar::event
                        (
                            $value->title,
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.' +1 day'),
                            null,
                            // Add color and link on event
                            [
                                'color' => '#ff0000',
//                                'url' => 'pass here url and any route',
                            ]
                        );
                    }
                }
                $calendar = Calendar::addEvents($events);
//                END OF TO DO LIST CALENDAR



                $banks = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 6)
                    ->where('users.archive', 'False')
                    ->where('users.client_check', 'client_branch')
                    ->get();

                $banks_users = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 6)
                    ->where('users.archive', 'False')
                    ->get();


                $provinces = Province::all();


                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id','1')
                    ->get()[0]->unique;

                return view('marketing.marketing-master', compact('timeStamp','calendar','banks', 'provinces','dateNow','javs','banks_users'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getMarketingReport()
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
            } elseif (Auth::user()->hasRole('Marketing')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                return view('marketing.marketing-report', compact('timeStamp'))->with(["page" => "marketing-report"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getMarketingManage()
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
            if (Auth::user() == null)
            {
                return redirect()->route('/');
            } elseif (Auth::user()->hasRole('Marketing')) {
                $timeStamp = Carbon::now('Asia/Manila');
                $splitDateTime = explode(" ", $timeStamp);
                $date = $splitDateTime[0];
                $time = $splitDateTime[1];

                $banks = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select(['users.id', 'users.name'])
                    ->where('role_id', 6)
                    ->where('users.archive', 'False')
                    ->where('users.client_check', 'client_branch')
                    ->get();

                $provinces = Province::all();

                return view('marketing.marketing-manage', compact('timeStamp', 'banks', 'provinces'))->with(["page" => "marketing-manage"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getBday()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
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
            elseif (Auth::user()->hasRole('Marketing'))
            {
                return view('marketing.marketing-bday')->with(["page" => "marketing-bday"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function getViewNewClient()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
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
            elseif (Auth::user()->hasRole('Marketing'))
            {
                return view('marketing.marketing-new-client')->with(["page" => "marketing-new-client"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function tableGetMarketingManage()
    {
        $rateTable = DB::table('rates')
            ->join('municipalities','municipalities.id','=','rates.municipality_id')
            ->join('provinces','provinces.id','=','rates.province_id')
            ->join('users','users.id','=','rates.user_id')
            ->select(['municipalities.muni_name','provinces.name as prov_name','users.name','rates.rate','rates.id']);

        return DataTables::of($rateTable)
            ->make(true);
    }

    public function insertRate(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'rateMuni' => 'required',
                'rateProv' => 'required',
                'bankID' => 'required',
                'rateBank' => 'required',
            ]);

        $existing = DB::table('rates')
            ->where('municipality_id',$request->rateMuni)
            ->where('province_id',$request->rateProv)
            ->where('user_id',$request->bankID)
            ->count();

        $getAccountName = DB::table('users')
            ->where('id', $request->bankID)
            ->get();

        if($validator->fails())
        {
            return \response()->json(['error'=>'required']);
        }
        else
        {
            if($existing>0)
            {
                return \response()->json(['exist'=>'exist']);
            }
            else
            {

                $bankIds = DB::table('user_client')
                    ->where('user_branch', $request->bankID)
                    ->select('user_id')
                    ->get();

                //for user_client
                foreach ($bankIds as $bankId)
                {
                    //for updating
                    $getID = DB::table('rates')
                        ->insertGetId
                        (
                            [
                                'municipality_id'=>$request->rateMuni,
                                'province_id'=>$request->rateProv,
                                'user_id'=>$bankId->user_id,
                                'rate'=>$request->rateBank,
                            ]
                        );

                    DB::table('marketing_logs')
                        ->insert([
                            'bi_rate_id' => $getID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Added Rate to ' . $getAccountName[0]->name,
                            'type' => 'bank_rate',
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }

                $get1IDDB = DB::table('rates')
                    ->insertGetId
                    (
                        [
                            'municipality_id'=>$request->rateMuni,
                            'province_id'=>$request->rateProv,
                            'user_id'=>$request->bankID,
                            'rate'=>$request->rateBank,
                        ]
                    );

//                $log_insert = new AuditQueries();
//                $log_insert->marketing_log_insert($request->rateBank,$request->rateMuni,$request->rateProv);

                DB::table('marketing_logs')
                    ->insert([
                        'bi_rate_id' => $get1IDDB,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Added Rate to '. $getAccountName[0]->name,
                        'type' => 'bank_rate',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                $emailSend = new EmailQueries();
                $emailSend->marketingLogsEmail($request);

                return \response()->json(['success'=>'success']);
            }
        }
    }

    public function bulkRate(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'provID' => 'required',
                'bankID' => 'required',
                'bulkRate' => 'required',
            ]);

        if($validator->fails())
        {
            return \response()->json(['error'=>'required']);
        }
        else
        {

            DB::table('rates')
                ->where('province_id',$request->provID)
                ->where('user_id',$request->bankID)
                ->delete();

            $bulkRates = DB::table('municipalities')
                ->where('province_id',$request->provID)
                ->select('id')
                ->get();

            $bankIds = DB::table('user_client')
                ->where('user_branch', $request->bankID)
                ->select('user_id')
                ->get();

            //for user_client
            foreach ($bankIds as $bankId)
            {
                //for updating
                DB::table('rates')
                    ->where('province_id',$request->provID)
                    ->where('user_id',$bankId->user_id)
                    ->delete();

                foreach ($bulkRates as $bulkRate)
                {
                    DB::table('rates')
                        ->insert
                        ([
                            'municipality_id'=>$bulkRate->id,
                            'province_id'=>$request->provID,
                            'user_id'=>$bankId->user_id,
                            'rate'=>$request->bulkRate
                        ]);
                }
            }

            //for client_branch
            foreach ($bulkRates as $bulkRate)
            {
                DB::table('rates')
                    ->insert
                    ([
                        'municipality_id'=>$bulkRate->id,
                        'province_id'=>$request->provID,
                        'user_id'=>$request->bankID,
                        'rate'=>$request->bulkRate
                    ]);
            }

            $emailSend = new EmailQueries();
            $emailSend->marketingLogsEmailBulk($request);

            return \response()->json(['success'=>'success']);
        }
    }

    public function UpdateRate(Request $request)
    {
        DB::table('rates')
            ->where('id', $request->id)
            ->update([
                'rate'=>$request->newrate
            ]);


        $getnewrate = DB::table('rates')
            ->where('id', $request->id)
            ->get();

        $emailSend = new EmailQueries();
        $emailSend->marketingLogsEmailUpdate($request);

        return response()->json($getnewrate);
    }

    public function getountrates(Request $request)
    {
        $count = DB::table('rates')
            ->join('municipalities','municipalities.id','=','rates.municipality_id')
            ->join('provinces','provinces.id','=','rates.province_id')
            ->join('users','users.id','=','rates.user_id')
            ->select(['municipalities.muni_name','provinces.name as prov_name','users.name','rates.rate','rates.id'])
            ->count();

        return response()->json($count);

    }

    public function getContract()
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
            if (Auth::user() == null)
            {
                return redirect()->route('/');
            }
            elseif (Auth::user()->hasRole('Marketing'))
            {
                $dateNow = Carbon::now('Asia/Manila');
                return view('marketing.marketing-contract',compact('dateNow'))->with(["page" => "marketing-contract"]);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function saveContract(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $validator = Validator::make($request->all(),
            [
                'clientName' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'txtContDesc' => 'required',
                'txtContRemarks' => 'required',
                'fileContract' => 'required',
            ]);

        $now = Carbon::now('Asia/Manila');
        $hashDL = Str::random(32).''.str_replace("-", "", $now->format('Y-m-d')).''.Str::random(32);

        if($validator->fails())
        {
            return response()->json('error');
        }
        else
        {
            $file = $request->file('fileContract');

            if($file->getClientOriginalExtension()!='zip')
            {
                return \response()->json('error');
            }
            else
            {
                //you also need to keep file extension as well
                $name = $hashDL.'.'.$file->getClientOriginalExtension();

                //using array instead of object
                $file->move(public_path() . '/file_contracts/', $name);

                $contID = DB::table('contracts')
                    ->insertGetId
                    (
                        [
                            'client_name'=>$removeScript->scripttrim(strtoupper($request->clientName)),
                            'start_date'=>$removeScript->scripttrim(strtoupper($request->startDate)),
                            'end_date'=>strtoupper($request->endDate),
                            'contract_desc'=>$removeScript->scripttrim(strtoupper($request->txtContDesc)),
                            'contract_remarks'=>$removeScript->scripttrim(strtoupper($request->txtContRemarks)),
                            'hash_contracts'=>$hashDL.'.zip'
                        ]
                    );

                //AUDIT START HERE
                $auditRemove = new AuditQueries();
                $auditRemove->insertContracts($contID);
                //END OF AUDIT

                DB::table('marketing_logs')
                    ->insert([
                        'bi_rate_id' => $contID,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Added an contract to '. $removeScript->scripttrim(strtoupper($request->clientName)) ,
                        'type' => 'marketing_contract',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                return \response()->json('success');
            }
        }
    }

    public function getTableContracts(Request $request)
    {
        $contractsTbl = DB::table('contracts')
            ->select
            (
                [
                    'id',
                    'client_name',
                    'start_date',
                    'end_date',
                    'contract_desc',
                    'contract_remarks',
                ]
            );

        return DataTables::of($contractsTbl)
            ->make(true);
    }

    public function downloadCont(Request $request)
    {
        $contHash = DB::table('contracts')
            ->select
            (
                [
                    'hash_contracts'
                ]
            )
            ->where('id',$request->contracID)
            ->first();

        if(File::exists(public_path('/file_contracts/'.$contHash->hash_contracts)))
        {
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->downloadContracts($request);
            //END OF AUDIT

            return \response()->json('/file_contracts/'.$contHash->hash_contracts);
        }
        else
        {
            return response()->json('error');
        }
    }

    public function updateContract(Request $request)
    {
        $file = $request->file('fileContractUpdate');

        if($file)
        {
            $contFile = DB::table('contracts')
                ->where('id', $request->contracID)
                ->select('hash_contracts')
                ->first();

            File::delete(glob('file_contracts/'.$contFile->hash_contracts));

            $now = Carbon::now('Asia/Manila');
            $hashDL = Str::random(32).''.str_replace("-", "", $now->format('Y-m-d')).''.Str::random(32);

            $file = $request->file('fileContractUpdate');
            $name = $hashDL.'.'.$file->getClientOriginalExtension();
            $file->move(public_path() . '/file_contracts/', $name);

            DB::table('contracts')
                ->where('id',$request->contracID)
                ->update
                (
                    [
                        'client_name'=>strtoupper($request->clientName),
                        'start_date'=>$request->startDate,
                        'end_date'=>$request->endDate,
                        'contract_desc'=>strtoupper($request->txtContDesc),
                        'contract_remarks'=>strtoupper($request->txtContRemarks),
                        'hash_contracts'=>$name,
                    ]
                );
        }
        else
        {
            DB::table('contracts')
                ->where('id',$request->contracID)
                ->update
                (
                    [
                        'client_name'=>strtoupper($request->clientName),
                        'start_date'=>$request->startDate,
                        'end_date'=>$request->endDate,
                        'contract_desc'=>strtoupper($request->txtContDesc),
                        'contract_remarks'=>strtoupper($request->txtContRemarks),
                    ]
                );
        }

        //AUDIT START HERE
        $auditRemove = new AuditQueries();
        $auditRemove->updateContracts($request);
        //END OF AUDIT

        return response()->json('success');
    }

    public function fetchInfo(Request $request)
    {
        $contInfo = DB::table('contracts')
            ->where('id',$request->contracID)
            ->get();

        return response()->json($contInfo);
    }

    public function getTableBday(Request $request)
    {
        $clientBdayTable = DB::table('client_birthdays')
            ->select
            (
                [
                    'id',
                    'client_name',
                    'birthdate',
                    'contact_num',
                    'email_add',
                    'client_position',
                    'gift_type',
                    'bank_name',
                ]
            );

        return DataTables::of($clientBdayTable)
            ->make(true);
    }

    public function insertClientBday(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $clntBdy = DB::table('client_birthdays')
            ->insertGetId
            (
                [
                    'client_name'=> $removeScript->scripttrim($request->clientName),
                    'birthdate'=>$request->birthdate,
                    'contact_num'=>$removeScript->scripttrim($request->contactno),
                    'email_add'=>$removeScript->scripttrim($request->email),
                    'client_position'=>$removeScript->scripttrim($request->position),
                    'gift_type'=>$request->gifttype,
                    'bank_name'=>$removeScript->scripttrim($request->employerNamee),
                ]
            );

        if($clntBdy)
        {
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->insertBirthday($clntBdy);
            //END OF AUDIT

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $clntBdy,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Added Birthday to '. $removeScript->scripttrim($request->clientName),
                    'type' => 'client_birthday',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return response()->json('success');
        }
        else
        {
            return response()->json('error');
        }
    }

    public function fetchClientBday(Request $request)
    {
        $clntFetchBday = DB::table('client_birthdays')
            ->where('id',$request->clientBdayID)
            ->get();

        return response()->json($clntFetchBday);
    }

    public function updateClientBday(Request $request)
    {
        $clientBday = DB::table('client_birthdays')
            ->where('id',$request->clientBdayID)
            ->update
            (
                [
                    'client_name'=>strtoupper($request->clientName),
                    'birthdate'=>strtoupper($request->birthdate),
                    'contact_num'=>strtoupper($request->contactno),
                    'email_add'=>strtoupper($request->email),
                    'client_position'=>strtoupper($request->position),
                    'gift_type'=>strtoupper($request->gifttype),
                    'bank_name'=>strtoupper($request->employerName)
                ]
            );
        if($clientBday)
        {
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->updateBirthday($request);
            //END OF AUDIT

            return response()->json('success');
        }
        else
        {
            return response()->json('error');
        }
    }

    public function getTableProsClient()
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
            if (Auth::user() == null)
            {
                return redirect()->route('/');
            }
            elseif (Auth::user()->hasRole('Marketing'))
            {
                $newClients = DB::table('new_clients')
                    ->select
                    (
                        [
                            'id',
                            'client_name',
                            'date_inquiry',
                            'address',
                            'contact_person',
                            'contact_position',
                            'contact_number',
                            'contact_email',
                            'require_check'
                        ]
                    );

                return DataTables::of($newClients)
                    ->make(true);
            }
            return redirect()->route('privilege-error');
        }
    }

    public function insertProsClient(Request $request)
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        $removeScript = new ScriptTrimmer();

        if($webStatus->web_status===1)
        {
            Auth::logout();
            return view('errors.down');
        }
        else {
            if (Auth::user() == null)
            {
                return redirect()->route('/');
            }
            elseif (Auth::user()->hasRole('Marketing'))
            {
                $now = Carbon::now('Asia/Manila');
                $hashDL = Str::random(32).''.str_replace("-", "", $now->format('Y-m-d')).''.Str::random(32);

                $file = $request->file('clientFile');
                if($file)
                {
                    if($file->getClientOriginalExtension()!='zip')
                    {
                        return \response()->json('error');
                    }
                    else
                    {
                        //you also need to keep file extension as well
                        $name = $hashDL.'.'.$file->getClientOriginalExtension();

                        //using array instead of object
                        $file->move(public_path() . '/new_clients/', $name);

                        $contID = DB::table('new_clients')
                            ->insertGetId
                            (
                                [
                                    'client_name'=>$removeScript->scripttrim(strtoupper($request->txtClientNamePros)),
                                    'date_inquiry'=>strtoupper($request->clientDateInquiry),
                                    'address'=>$removeScript->scripttrim(strtoupper($request->txtComAdd)),
                                    'contact_person'=>$removeScript->scripttrim(strtoupper($request->txtContactPerson)),
                                    'contact_position'=>$removeScript->scripttrim(strtoupper($request->txtContactPosition)),
                                    'contact_number'=>$removeScript->scripttrim(strtoupper($request->txtContactNumber)),
                                    'contact_email'=>$removeScript->scripttrim(strtoupper($request->txtContactEmail)),
                                    'require_check'=>$removeScript->scripttrim(strtoupper($request->txtReqCheck)),
                                    'hash_bi'=>$name
                                ]
                            );

                        //AUDIT START HERE
                        $auditRemove = new AuditQueries();
                        $auditRemove->insertProsClients($contID);
                        //END OF AUDIT

                        DB::table('marketing_logs')
                            ->insert([
                                'bi_rate_id' => $contID,
                                'user_id' => Auth::user()->id,
                                'activity' => 'Added Client '. $removeScript->scripttrim($request->txtClientNamePros),
                                'type' => 'add_client',
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);

                        return \response()->json('success');
                    }
                }
                else
                {
                    $contID = DB::table('new_clients')
                        ->insertGetId
                        (
                            [
                                'client_name'=>strtoupper($request->txtClientNamePros),
                                'date_inquiry'=>strtoupper($request->clientDateInquiry),
                                'address'=>strtoupper($request->txtComAdd),
                                'contact_person'=>strtoupper($request->txtContactPerson),
                                'contact_position'=>strtoupper($request->txtContactPosition),
                                'contact_number'=>strtoupper($request->txtContactNumber),
                                'contact_email'=>strtoupper($request->txtContactEmail),
                                'require_check'=>strtoupper($request->txtReqCheck),
                            ]
                        );

                    //AUDIT START HERE
                    $auditRemove = new AuditQueries();
                    $auditRemove->insertProsClients($contID);
                    //END OF AUDIT

                    DB::table('marketing_logs')
                        ->insert([
                            'bi_rate_id' => $contID,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Added Client '. $removeScript->scripttrim($request->txtClientNamePros),
                            'type' => 'add_client',
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    return \response()->json('success');
                }


            }
            return redirect()->route('privilege-error');
        }
    }

    public function updateProsClient(Request $request)
    {

        $now = Carbon::now('Asia/Manila');
        $hashDL = Str::random(32).''.str_replace("-", "", $now->format('Y-m-d')).''.Str::random(32);

        $file = $request->file('clientFile');

        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if($webStatus->web_status===1)
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
            elseif (Auth::user()->hasRole('Marketing'))
            {
                if($file)
                {

                    if($file->getClientOriginalExtension()!='zip')
                    {
                        return \response()->json('error');
                    }
                    else
                    {
                        $name = $hashDL.'.'.$file->getClientOriginalExtension();
                        $prosFile = DB::table('new_clients')
                            ->where('id', $request->clientProsID)
                            ->select('hash_bi')
                            ->first();

                        File::delete(glob('new_clients/'.$prosFile->hash_bi));

                        $file->move(public_path() . '/new_clients/', $name);

                        DB::table('new_clients')
                            ->where('id',$request->clientProsID)
                            ->update
                            (
                                [
                                    'client_name'=>strtoupper($request->txtClientNamePros),
                                    'date_inquiry'=>strtoupper($request->clientDateInquiry),
                                    'address'=>strtoupper($request->txtComAdd),
                                    'contact_person'=>strtoupper($request->txtContactPerson),
                                    'contact_position'=>strtoupper($request->txtContactPosition),
                                    'contact_number'=>strtoupper($request->txtContactNumber),
                                    'contact_email'=>strtoupper($request->txtContactEmail),
                                    'require_check'=>strtoupper($request->txtReqCheck),
                                    'hash_bi'=>$name,
                                ]
                            );

                        //AUDIT START HERE
                        $auditRemove = new AuditQueries();
                        $auditRemove->insertProsClients($request->clientProsID);
                        //END OF AUDIT

                        return \response()->json('success');
                    }
                }
                else
                {
                    DB::table('new_clients')
                        ->where('id',$request->clientProsID)
                        ->update
                        (
                            [
                                'client_name'=>strtoupper($request->txtClientNamePros),
                                'date_inquiry'=>strtoupper($request->clientDateInquiry),
                                'address'=>strtoupper($request->txtComAdd),
                                'contact_person'=>strtoupper($request->txtContactPerson),
                                'contact_position'=>strtoupper($request->txtContactPosition),
                                'contact_number'=>strtoupper($request->txtContactNumber),
                                'contact_email'=>strtoupper($request->txtContactEmail),
                                'require_check'=>strtoupper($request->txtReqCheck),
                            ]
                        );

                    //AUDIT START HERE
                    $auditRemove = new AuditQueries();
                    $auditRemove->updateProsClients($request->clientProsID);
                    //END OF AUDIT

                    return \response()->json('success');
                }
            }
        }
    }

    public function fetchInfoProsClient(Request $request)
    {
        $clntFetchProsInfo = DB::table('new_clients')
            ->where('id',$request->clientProsID)
            ->get();

        return response()->json($clntFetchProsInfo);
    }

    public function downloadProsClient(Request $request)
    {
        $biHash = DB::table('new_clients')
            ->select
            (
                [
                    'hash_bi'
                ]
            )
            ->where('id',$request->clientDownloadProsID)
            ->first();

        if($biHash)
        {
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->downloadBi($request);
            //END OF AUDIT

            return \response()->json('/new_clients/'.$biHash->hash_bi);
        }
        else
        {
            return response()->json('error');
        }
    }

    public function getToDoList()
    {
        $toDoList = DB::table('events')
            ->select
            (
                [
                    'id',
                    'title',
                    'event_description',
                    'start_date',
                    'end_date',
                ]
            )
            ->where('event_status','ACTIVE');

        return DataTables::of($toDoList)
            ->make(true);
    }

    public function insertToDoList(Request $request)
    {
        $removeScript = new ScriptTrimmer();

        $eventID = DB::table('events')
            ->insertGetId
            (
                [
                    'title'=>$removeScript->scripttrim(strtoupper($request->event_title)),
                    'event_description'=>$removeScript->scripttrim(strtoupper($request->event_description)),
                    'event_status'=>'ACTIVE',
                    'start_date'=>strtoupper($request->event_startdate),
                    'end_date'=>strtoupper($request->event_enddate)
                ]
            );

        if($eventID)
        {
            $auditInsertEvent = new AuditQueries();
            $auditInsertEvent->marketingInsertToDoList($eventID);

            return response()->json('success');
        }
        return response()->json('error');

    }

    public function fetchTodolistInfo(Request $request)
    {
        $fetchTodo = DB::table('events')
            ->select
            (
                [
                    'title',
                    'event_description',
                    'start_date',
                    'end_date',
                ]
            )
            ->where('id',$request->todolistID)
            ->first();

        return response()->json($fetchTodo);
    }

    public function updateTodolistInfo(Request $request)
    {
        if($request->todolistID!='' || $request->todolistID!=null)
        {
            DB::table('events')
                ->where('id',$request->todolistID)
                ->update
                (
                    [
                        'title'=>strtoupper($request->event_title_update),
                        'event_description'=>strtoupper($request->event_description_update),
                        'event_status'=>'ACTIVE',
                        'start_date'=>strtoupper($request->event_startdate_update),
                        'end_date'=>strtoupper($request->event_enddate_update),
                    ]
                );

            return response()->json('success');
        }
    }

    public function doneTodolistInfo(Request $request)
    {
        if($request->todolistID!='' || $request->todolistID!=null)
        {
            DB::table('events')
                ->where('id',$request->todolistID)
                ->update
                (
                    [
                        'event_status'=>'INACTIVE',
                    ]
                );
            return response()->json('success');
        }
        return response()->json('error');
    }

    public function tableDoneTodolistInfo()
    {
        $doneToDoList = DB::table('events')
            ->select
            (
                [
                    'id',
                    'title',
                    'event_description',
                    'start_date',
                    'end_date',
                ]
            )
            ->where('event_status','INACTIVE');

        return DataTables::of($doneToDoList)
            ->make(true);
    }

    public function tableDeleteTodolist(Request $request)
    {
        if($request->todolistID!= null || $request->todolistID!='')
        {
            DB::table('events')
                ->where('id',$request->todolistID)
                ->delete();

            return response()->json('success');
        }
        return response()->json('error');
    }

    public function marketing_table_tat_manage_get()
    {
        $tattable = DB::table('tat_management')
            ->join('municipalities','municipalities.id','=','tat_management.muni_id')
            ->join('provinces','provinces.id','=','tat_management.prov_id')
            ->join('users','users.id','=','tat_management.client_id')
            ->select(
                [
                    'municipalities.muni_name as muni_name',
                    'provinces.name as prov_name',
                    'users.name as client_name',
                    'tat_management.fw_tat as fw',
                    'tat_management.obw_tat as obw',
                    'tat_management.agreed_tat as agreed',
                    'tat_management.date as date',
                    'tat_management.time as time',
                    'tat_management.id as id'
                ]
            );

        return DataTables::of($tattable)
            ->make(true);
    }

    public function marketing_check_tat_prov(Request $request)
    {
        $prov_id = $request->prov_id;
        $client_id = $request->client_id;

        $get_all_muni = DB::table('municipalities')
            ->select('id')
            ->where('province_id',$prov_id)
            ->get();

        $user_client = DB::table('user_client')
            ->where('user_branch', $client_id)
            ->select('user_id')
            ->get();

        $get_all_id_muni = '';
        $count_data = 0;
        if(count($get_all_muni) == 0)
        {
            $get_all_muni = '';
        }
        else
        {
            $get_all_id_muni = $get_all_muni;
        }

        foreach ($get_all_id_muni as $muni_id)
        {
            foreach($user_client as $client)
            {
                $count_user = DB::table('tat_management')
                    ->where('muni_id',$muni_id->id)
                    ->where('prov_id',$prov_id)
                    ->where('client_id',$client->user_id)
                    ->count();

                if($count_user > 0)
                {
                    $count_data++;
                }
            }
            $count = DB::table('tat_management')
                ->where('muni_id',$muni_id->id)
                ->where('prov_id',$prov_id)
                ->where('client_id',$client_id)
                ->count();

            if($count > 0)
            {
                $count_data++;
            }
        }
        return $count_data;
    }

    public function marketing_save_tat_prov(Request $request)
    {
        $prov_id = $request->prov_id;
        $client_id = $request->client_id;
        $fw_tat = $request->fw_tat;
        $obw_tat = $request->obw_tat;
        $agreed_tat = $request->agreed_tat;
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];
        $if_update = $request->if_update;

        $get_all_muni = DB::table('municipalities')
            ->select('id')
            ->where('province_id',$prov_id)
            ->get();

        $get_all_id_muni = '';

        $user_client = DB::table('user_client')
            ->where('user_branch', $client_id)
            ->select('user_id')
            ->get();

        if(count($get_all_muni) == 0)
        {
            $get_all_muni = '';
        }
        else
        {
            $get_all_id_muni = $get_all_muni;
        }

        foreach ($get_all_id_muni as $muni_id)
        {
            if($if_update == 'not')
            {
                foreach($user_client as $client)
                {
                    DB::table('tat_management')
                        ->insert([
                            'muni_id' => $muni_id->id,
                            'prov_id' => $prov_id,
                            'client_id' => $client->user_id,
                            'fw_tat' => $fw_tat,
                            'obw_tat' => $obw_tat,
                            'agreed_tat' =>$agreed_tat,
                            'date' => $date,
                            'time' => $time
                        ]);
                }

                DB::table('tat_management')
                    ->insert([
                        'muni_id' => $muni_id->id,
                        'prov_id' => $prov_id,
                        'client_id' => $client_id,
                        'fw_tat' => $fw_tat,
                        'obw_tat' => $obw_tat,
                        'agreed_tat' =>$agreed_tat,
                        'date' => $date,
                        'time' => $time
                    ]);
            }
            else if($if_update == 'update')
            {

                foreach($user_client as $client)
                {
                    DB::table('tat_management')
                        ->where('muni_id',$muni_id->id)
                        ->where('prov_id',$prov_id)
                        ->where('client_id',$client->user_id)
                        ->update([
                            'fw_tat' => $fw_tat,
                            'obw_tat' => $obw_tat,
                            'agreed_tat' =>$agreed_tat,
                            'date' => $date,
                            'time' => $time
                        ]);
                }

                DB::table('tat_management')
                    ->where('muni_id',$muni_id->id)
                    ->where('prov_id',$prov_id)
                    ->where('client_id',$client_id)
                    ->update([
                        'fw_tat' => $fw_tat,
                        'obw_tat' => $obw_tat,
                        'agreed_tat' =>$agreed_tat,
                        'date' => $date,
                        'time' => $time
                    ]);
            }
        }

//        DB::table('tat_management')
//            ->insert('')
//
    }

    public function marketing_check_tat_muni(Request $request)
    {
        $muni_id = $request->muni_id;
        $prov_id = $request->prov_id;
        $bank_id = $request->client_id;

        $count = DB::table('tat_management')
            ->where('muni_id',$muni_id)
            ->where('prov_id',$prov_id)
            ->where('client_id',$bank_id)
            ->count();

        return $count;

    }

    public function marketing_save_tat_muni(Request $request)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $muni_id = $request->muni_id;
        $prov_id = $request->prov_id;
        $bank_id = $request->client_id;
        $fw_tat = $request->fw_tat;
        $obw_tat = $request->obw_tat;
        $agreed_tat = $request->agreed_tat;

        DB::table('tat_management')
            ->insert([
                'muni_id' => $muni_id,
                'prov_id' => $prov_id,
                'client_id' => $bank_id,
                'fw_tat' => $fw_tat,
                'obw_tat' => $obw_tat,
                'agreed_tat' =>$agreed_tat,
                'date' => $date,
                'time' => $time
            ]);

    }

    public function tat_management_delete(Request $request)
    {
        $id = $request->id;

        DB::table('tat_management')
            ->where('id',$id)
            ->delete();
    }

    public function marketing_tat_update_row(Request $request)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        DB::table('tat_management')
            ->where('id',$request->tat_id)
            ->update([
                'fw_tat'=>$request->fw_tat,
                'obw_tat'=>$request->obw_tat,
                'agreed_tat'=>$request->agree_tat,
                'date' => $date,
                'time' => $time
            ]);
    }


    //floyd

    //FLOYD



    //STANDARD RATE

    public function insertStandardRate(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'rateMuni' => 'required',
                'rateProv' => 'required',
                'rateBank' => 'required',
                'vatRate' => 'required',
                'muniTat' => 'required',
                'totRate' => 'required'
            ]);
        $existing = DB::table('standard_rate')
            ->where('municipalities',$request->rateMuni)
            ->count();

        if($validator->fails())
        {
            return \response()->json(['error'=>'required']);
        }
        else
        {
            if($existing > 0)
            {
                return \response()->json(['exist'=>'exist']);
            }
            else
            {
                DB::table('standard_rate')
                    ->insert
                    (
                        [
                            'municipalities'=>$request->rateMuni,
                            'provinces'=>$request->rateProv,
                            'rate'=>$request->rateBank,
                            'vat'=>$request->vatRate,
                            'tat'=>$request->muniTat,
                            'total_rate'=>$request->totRate
                        ]
                    );

//                $emailSend = new EmailQueries();
//                $emailSend->marketingLogsEmail($request);
                return \response()->json(['success'=>'success']);
            }
        }
    }
    //insertStandardBulk
    public function insertStandardBulk(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'provID2' => 'required',
                'bulkRate2'=> 'required',
                'vatProvRate2' => 'required',
                'totProvRate2' => 'required',
                'provTat2' => 'required'
            ]);

        $existing = DB::table('standard_rate')
            ->where('provinces', $request->provID2)
            ->count();

        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        }
        else
        {
            if ($existing > 0)
            {
                return \response()->json(['exist' => 'exist']);
            }
            else
            {
                $bulkRates = DB::table('municipalities')
                    ->where('province_id', $request->provID2)
                    ->select('id')
                    ->get();

                foreach($bulkRates as $bulkRate)
                {
                    DB::table('standard_rate')
                        ->insert
                        (
                            [
                                'municipalities'=>$bulkRate->id,
                                'provinces'=>$request->provID2,
                                'rate'=>$request->bulkRate2,
                                'vat'=>$request->vatProvRate2,
                                'tat'=>$request->provTat2,
                                'total_rate'=>$request->totProvRate2
                            ]);
                }

//            $emailSend = new EmailQueries();
//            $emailSend->marketingLogsEmailBulk($request);

                return \response()->json(['success' => 'success']);
            }
        }
    }
    //STANDARD UPDATE
    public function UpdateStandardGetID(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'acctID2'=>'required'
            ]);
        if($validator->fails())
        {
            return \response()->json(['error'=>'required']);
        }
        else
        {
            $getdata = DB::table('standard_rate')
                ->join(
                    'municipalities',
                    'municipalities.id',
                    '=',
                    'standard_rate.municipalities'
                )
                ->join(
                    'provinces',
                    'provinces.id',
                    '=',
                    'standard_rate.provinces'
                )
                ->select(
                    [
                        'municipalities.muni_name as muni',
                        'provinces.name as provinces',
                        'standard_rate.rate as rate',
                        'standard_rate.tat as tat',
                        'standard_rate.vat as vat',
                        'standard_rate.total_rate as total_rate'
                    ]
                )
                ->where('standard_rate.id', $request->acctID2)
                ->get();

            return \response()->json($getdata);
        }
    }
    public function UpdateProvStandard(Request $request)
    {
        $bulkRates = DB::table('standard_rate')
            ->where('provinces', $request->provID2)
            ->select('id')
            ->get();

        foreach ($bulkRates as $bulkRate) {

            DB::table('standard_rate')
                ->where('id', $bulkRate->id)
                ->update
                (
                    [
                        'rate' => $request->rateNew,
                        'vat' => $request->vatNew,
                        'total_rate' => $request->totalNew,
                        'tat' => $request->tatNew

                    ]);
        }
    }
    //update municipality in form
    public function updateMuniFormStandard(Request $request)
    {
        $update = DB::table('standard_rate')
            ->select('id')
            ->where('municipalities', $request->rateMuni)
            ->get();

        DB::table('standard_rate')
            ->where('id', $update[0]->id)
            ->update
            (
                [
                    'rate' => $request->rateNew,
                    'vat' => $request->vatNew,
                    'total_rate' => $request->totalNew,
                    'tat' => $request->tatNew
                ]
            );
    }

//table standard
    public function tableGetMarketingStandard(Request $request)
    {
        $rateTable = DB::table('standard_rate')
            ->join
            (
                'municipalities',
                'municipalities.id',
                '=',
                'standard_rate.municipalities'
            )//location = location
            ->join
            (
                'provinces',
                'provinces.id',
                '=',
                'standard_rate.provinces'
            ) //provinces = (selected) province
            ->select(
                [
                    'standard_rate.id as id',
                    'municipalities.muni_name as muni_name',
                    'provinces.name as prov_name',
                    'standard_rate.rate as rate',
                    'standard_rate.vat as vat',
                    'standard_rate.tat as tat',
                    'standard_rate.total_rate as total_rate'
                ]
            )
            ->get();

        return DataTables::of($rateTable)
            ->make(true);
    }
    public function tableEditStandard(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'acctID2' => 'required',
                'Rate' => 'required',
                'Vat' => 'required',
                'totalRate' => 'required',
                'Tat' => 'required'
            ]);

        if ($validator->fails())
        {
            return \response()->json(['error' => 'required']);
        }
        else
        {
            DB::table('standard_rate')
                ->where('id', $request->acctID2)
                ->update
                ([
                    'rate' => $request->Rate,
                    'vat' => $request->Vat,
                    'total_rate' => $request->totalRate,
                    'tat' => $request->Tat
                ]);
        }
    }

    public function tableDeleteStandard(Request $request) {

        DB::table('standard_rate')
            ->where('id', $request->acctID3)
            ->delete();
    }

    public function cancelUpdate(Request $request){

        $getValue = DB::table('standard_rate')
            ->select('rate', 'vat', 'total_rate')
            ->where('id', $request->acctID2)
            ->get();

        return response()->json($getValue);
    }


//end FLOYD

    public function marketing_save_holiday_event_tat(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $title = $request->title;
        $descript = $request->descript;
        $repeat = $request->repeat;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $end_date_converted =  Carbon::createFromFormat('Y-m-d',$end_date);
        $start_date_converted =  Carbon::createFromFormat('Y-m-d',$start_date);

        $difference = $end_date_converted->diffInDays($start_date_converted);

        DB::table('holidays')
            ->insert([
                'title' => $removeScript->scripttrim($title),
                'description' => $removeScript->scripttrim($descript),
                'repeat' => $repeat,
                'start_date' => $start_date,
                'start_year' => explode('-',$start_date)[0],
                'start_month' => explode('-',$start_date)[1].'-'.explode('-',$start_date)[2],
                'day_difference' => $difference,
                'end_date' => $end_date.' 23:59:59'
            ]);


    }

    public function marketing_get_holidays(Request $request)
    {
        $holiday = DB::table('holidays')
            ->get();

        return response()->json($holiday);
    }

    public function marketing_deletes_holiday_cal(Request $request)
    {
        DB::table('holidays')
            ->where('id',$request->event_id)
            ->delete();
    }

    public function marketing_delete_contract(Request $request)
    {

        $get_info = DB::table('contracts')
            ->select('hash_contracts')
            ->where('id',$request->cont_id)
            ->first();

        File::delete(glob('file_contracts/'.$get_info->hash_contracts));


        //AUDIT START HERE
        $auditRemove = new AuditQueries();
        $auditRemove->deleteContracts($request->cont_id);
        //END OF AUDIT

        DB::table('contracts')
            ->where('id',$request->cont_id)
            ->delete();
    }

    public function marketing_delete_client_bday(Request $request)
    {

        //AUDIT START HERE
        $auditRemove = new AuditQueries();
        $auditRemove->deleteBday($request->bday_id);
        //END OF AUDIT

        DB::table('client_birthdays')
            ->where('id',$request->bday_id)
            ->delete();
    }

    public function marketing_delete_pros_client(Request $request)
    {
        $get_info = DB::table('new_clients')
            ->select('hash_bi')
            ->where('id',$request->client_id)
            ->first();

        File::delete(glob('new_clients/'.$get_info->hash_bi));

        //AUDIT START HERE
        $auditRemove = new AuditQueries();
        $auditRemove->deleteProsClient($request->client_id);
        //END OF AUDIT

        DB::table('new_clients')
            ->where('id',$request->client_id)
            ->delete();
    }

    public function marketing_tat_update_accounts(Request $request)
    {

        $timeStamp =  Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from.' 00:00:00');;
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];


        $getyear = explode("-",$date)[0];

        //for

        $accounts = DB::table('endorsements')
            ->select([
                'id',
                'city_muni',
                'date_endorsed',
                'time_endorsed',
                'acct_status'
            ])
            ->where('date_endorsed','>=',$date)
            ->get();



        if(count($accounts) != 0)
        {
            foreach($accounts as $account)
            {
                if($account->acct_status != 3)
                {
                    $tat_manage = new TatController();
                    $date_due = 'id: '.$account->id.' date: '.$tat_manage->DateTimeDue_Tat_update($account->city_muni,'date',$account->date_endorsed.' '.$account->time_endorsed,$account->id);
                    $time_due = ' time: '.$tat_manage->DateTimeDue_Tat_update($account->city_muni,'time',$account->date_endorsed.' '.$account->time_endorsed,$account->id);

                    DB::table('test_date_due')
                        ->insert([
                            'test' => $date_due.$time_due
                        ]);
                }
            }
        }
    }

    public function marketing_get_bi_clients()
    {
        $getBiClient = DB::table('bi_account_list')
            ->select('bi_account_name', 'account_location', 'id')
            ->get();

        return $getBiClient;
    }

    public function marketing_get_client_package(Request $request)
    {
        $getCheck = DB::table('package_list')
            ->join('package_to_account', 'package_to_account.package_id', '=', 'package_list.id')
            ->where('package_to_account.bi_account_id', $request->id)
            ->select('package_list.id','package_list.package')
            ->get();

        return $getCheck;
    }

    public function marketing_bi_rate_table()
    {
        $ratesTable = DB::table('bi_rates')
            ->select([
                'bi_rates.id as id',
                'bi_rates.package_id as package_id',
                'bi_rates.package as package',
                'bi_rates.client_name as client_name',
                'bi_rates.rate as rate',
                'bi_rates.created_at as created_at',
                'bi_rates.created_at as date_time',
                'bi_rates.updated_at as updated_at',
            ]);
        return DataTables::of($ratesTable)
            ->editcolumn('rates', function($query)
            {
                return 'PHP '.$query->rate;
            })
            ->editcolumn('date_time' , function($query)
            {
                if($query->updated_at != '')
                {
                    return $query->updated_at;
                }
                else
                {
                    return $query->created_at;
                }
            })
            ->make(true);
    }

    public function marketing_add_rate_to_bi(Request $request)
    {
        $getPackage = DB::table('package_list')
            ->join('package_to_account', 'package_to_account.package_id', '=', 'package_list.id')
            ->where('package_list.id', $request->package_id)
            ->select('package_list.package')
            ->get();

        $getClient = DB::table('bi_account_list')
            ->where('id', $request->bi_id)
            ->select('bi_account_name', 'account_location')
            ->get();

        $clientName = $getClient[0]->bi_account_name. ' ' .$getClient[0]->account_location;

        $checking = DB::table('bi_rates')
            ->where('package', $getPackage[0]->package)
            ->where('client_name', $clientName)
            ->get();

        if(count($checking) <= 0)
        {
            $getID = DB::table('bi_rates')
                ->insertGetId([
                    'package_id' => $request->package_id,
                    'package' => $getPackage[0]->package,
                    'client_name' => $clientName,
                    'rate' => $request->rate_inputted,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' =>$getID,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Added '. $getPackage[0]->package.' rate to ' . $clientName,
                    'type' => 'bi_rates',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'Rate Successfully Added';
        }
        else
        {
            return 'Rate is already Added check the table to edit';
        }


    }

    public function marketing_get_logs(Request $request)
    {
        if($request->type == 'all')
        {
            $getLogs = DB::table('marketing_logs')
                ->join('users', 'users.id', '=', 'marketing_logs.user_id')
                ->select([
                    'users.name as name',
                    'marketing_logs.activity as act',
                    'marketing_logs.type as type',
                    'marketing_logs.bi_rate_id as bi_rate_id',
                    'marketing_logs.created_at'
                ])
//                ->orderByDesc('marketing_logs.id')
                ->get();

            return response()->json([$getLogs]);
        }
        else
        {
            $getLogs = DB::table('marketing_logs')
                ->join('users', 'users.id', '=', 'marketing_logs.user_id')
                ->select([
                    'users.name as name',
                    'marketing_logs.activity as act',
                    'marketing_logs.created_at'
                ])
                ->where('marketing_logs.bi_rate_id', $request->id)
                ->where('marketing_logs.type', $request->type)
//                ->orderByDesc('marketing_logs.id')
                ->get();

            return response()->json([$getLogs]);
        }

    }

    public function marketing_update_bi_rates(Request $request)
    {
        if($request->type == 'rate')
        {
            $getOld = DB::table('bi_rates')
                ->where('id', $request->id)
                ->select('rate', 'client_name')
                ->get();


            DB::table('bi_rates')
                ->where('id', $request->id)
                ->update([
                    'rate' => $request->amount,
                    'updated_at' => Carbon::now('Asia/manila')
                ]);

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Update '. $getOld[0]->client_name .' rate from PHP '. $getOld[0]->rate .' to PHP '. $request->amount,
                    'type' => 'bi_rates',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else if($request->type == 'bank_rate')
        {
            $getold = DB::table('rates')
                ->join('users', 'users.id', '=', 'rates.user_id')
                ->where('rates.id', $request->id)
                ->select([
                    'rates.rate as rate',
                    'users.name as name'
                ])
                ->get();

            DB::table('rates')
                ->where('id', $request->id)
                ->update([
                    'rate' => $request->amount,
                    'updated_at' => Carbon::now('Asia/manila')
                ]);

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Update '. $getold[0]->name .' rate from PHP '. $getold[0]->rate .' to PHP '. $request->amount,
                    'type' => 'bank_rate',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else if($request->type == 'ocular')
        {
            $getOld = DB::table('bi_rates_ocular')
                ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_rates_ocular.bi_id')
                ->where('bi_rates_ocular.id', $request->id)
                ->select([
                    'bi_rates_ocular.rate as rates',
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ])
                ->get();


            DB::table('bi_rates_ocular')
                ->where('id', $request->id)
                ->update([
                    'rate' => $request->amount,
                    'updated_at' => Carbon::now('Asia/manila')
                ]);

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Update '. $getOld[0]->name.'  '. $getOld[0]->loc .' rate from PHP '. $getOld[0]->rates .' to PHP '. $request->amount ,
                    'type' => 'bi_rates_ocular',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        else if($request->type == 'rate_alacarte')
        {
            $getOld = DB::table('bi_rates_alacarte')
                ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_rates_alacarte.bi_id')
                ->where('bi_rates_alacarte.id', $request->id)
                ->select([
                    'bi_rates_alacarte.rate as rates',
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ])
                ->get();

            DB::table('bi_rates_alacarte')
                ->where('id', $request->id)
                ->update([
                    'rate' => $request->amount,
                    'updated_at' => Carbon::now('Asia/manila')
                ]);

            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Update '. $getOld[0]->name.'  '. $getOld[0]->loc .' rate from PHP '. $getOld[0]->rates .' to PHP '. $request->amount ,
                    'type' => 'bi_rates_alacarte',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
    }

    public function marketing_get_all_muni_names(Request $request)
    {
        $resultTags = [];
        $searchLetter = $request->term;
        $resultQs = DB::table('endorsements')
            ->where('id', 'like', '%'.$searchLetter.'%')
            ->select('id')
            ->take(10)
            ->get();

        if(count($resultQs)==0)
        {
            $resultTags[] = 'NO ITEM FOUND';
        }
        else
        {
            foreach($resultQs as $resultQ)
            {
                $resultTags[] =
                    [
                        'label' => $resultQ->id,
                        'id' => $resultQ->id
                    ];
            }
        }
        return response()->json([$resultTags]);
    }

    public function marketing_get_all_provinces(Request $request)
    {
        $getprov = DB::table('provinces')
            ->get();

        return response()->json([$getprov]);
    }

    public function marketing_add_rate_to_bi_tab2(Request $request)
    {
        $what = $request->type;

        if ($what == 'province')
        {
            $getClientName = DB::table('bi_account_list')
                ->where('id', $request->id)
                ->select([
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ])
                ->get();

            $biName = $getClientName[0]->name . ' ' . $getClientName[0]->loc;

            $allMun = DB::table('provinces')
                ->join('municipalities', 'municipalities.province_id', '=', 'provinces.id')
                ->where('provinces.id', $request->prov_id)
                ->select([
                    'municipalities.id as mun_id',
                    'provinces.id as prov_id'
                ])
                ->get();

            for ($i = 0; $i < count($allMun); $i++) {
                $validate = DB::table('bi_rates_ocular')
                    ->where('bi_id', $request->id)
                    ->where('municipality', $allMun[$i]->mun_id)
                    ->where('province', $allMun[$i]->prov_id)
                    ->count();

                if ($validate <= 0) {
                    $idForLogs = DB::table('bi_rates_ocular')
                        ->insertGetId([
                            'bi_id' => $request->id,
                            'municipality' => $allMun[$i]->mun_id,
                            'province' => $allMun[$i]->prov_id,
                            'rate' => $request->entered_amount,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('marketing_logs')
                        ->insert([
                            'bi_rate_id' => $idForLogs,
                            'user_id' => Auth::user()->id,
                            'activity' => 'Added rate to '. $biName,
                            'type' => 'bi_rates_ocular',
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }
            return 'Rates Successfully Added';
        }
        else if ($what == 'municipality')
        {
            $getClientName = DB::table('bi_account_list')
                ->where('id', $request->id)
                ->select([
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ])
                ->get();

            $biName = $getClientName[0]->name . ' ' . $getClientName[0]->loc;

            $validate = DB::table('bi_rates_ocular')
                ->where('bi_id', $request->id)
                ->where('municipality', $request->mun_id)
                ->where('province', $request->prov_id)
                ->count();

            if ($validate <= 0)
            {
                $getidForLog = DB::table('bi_rates_ocular')
                    ->insertGetId([
                        'bi_id' => $request->id,
                        'municipality' => $request->mun_id,
                        'province' => $request->prov_id,
                        'rate' => $request->entered_amount,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('marketing_logs')
                    ->insert([
                        'bi_rate_id' => $getidForLog,
                        'user_id' => Auth::user()->id,
                        'activity' => 'Added rate to '. $biName,
                        'type' => 'bi_rates_ocular',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                return 'Rate Successfully Added';
            }
            else if ($validate >= 1)
            {
                return 'already';
            }
        }
    }

    public function marketing_bi_rate_table_ocular()
    {
        $ocularTable = DB::table('bi_rates_ocular')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_rates_ocular.bi_id')
            ->join('municipalities', 'municipalities.id', '=', 'bi_rates_ocular.municipality')
            ->join('provinces', 'provinces.id', '=', 'bi_rates_ocular.province')
            ->select([
                'bi_rates_ocular.id as id',
                'bi_account_list.bi_account_name as name',
                'bi_account_list.account_location as loc',
                'municipalities.muni_name as muni',
                'provinces.name as prov',
                'bi_rates_ocular.rate as rate',
                'bi_rates_ocular.created_at as created_at',
                'bi_rates_ocular.updated_at as updated_at'
            ])
            ->groupBy('bi_rates_ocular.id');
        return DataTables::of($ocularTable)
            ->editcolumn('client_name', function($query)
            {
                return $query->name . ' ' . $query->loc;
            })
            ->rawColumns([
                'client_name'
            ])
            ->make(true);
    }

    public function marketing_all_logs_table()
    {
        $getAllLogs = DB::table('marketing_logs')
            ->join('users', 'users.id', '=', 'marketing_logs.user_id')
            ->select([
                'marketing_logs.id as id',
                'users.name as name',
                'marketing_logs.activity as act',
                'marketing_logs.type as type',
                'marketing_logs.created_at as date_time'
            ])
            ->groupBy('marketing_logs.id');
        return DataTables::of($getAllLogs)
            ->make(true);
    }

    public function marketing_get_client_alacarte()
    {
        $getCheckings = DB::table('checking_list')
            ->get();

        return $getCheckings;
    }

    public function marketing_bi_rate_table_alacarte()
    {
        $getAlacarteRatesTable = DB::table('bi_rates_alacarte')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_rates_alacarte.bi_id')
            ->join('checking_list', 'checking_list.id', 'bi_rates_alacarte.checking')
            ->select([
                'bi_rates_alacarte.id as id',
                'bi_account_list.bi_account_name as name',
                'bi_account_list.account_location as loc',
                'checking_list.checking_name as checking',
                'bi_rates_alacarte.ocular as ocular',
                'bi_rates_alacarte.rate as rates',
                'bi_rates_alacarte.created_at as created_at',
                'bi_rates_alacarte.updated_at as updated_at'
            ])
            ->groupBy('bi_rates_alacarte.id');

        return DataTables::of($getAlacarteRatesTable)
            ->editcolumn('client_name', function($query)
            {
                return $query->name . ' ' . $query->loc;
            })
            ->editcolumn('date_time' , function($query)
            {
                if($query->updated_at != '')
                {
                    return $query->updated_at;
                }
                else
                {
                    return $query->created_at;
                }
            })
            ->rawColumns([
                'client_name',
                'date_time'
            ])
            ->make(true);
    }

    public function bi_rate_add_alacarte(Request $request)
    {
        $checking = DB::table('bi_rates_alacarte')
            ->where('bi_id', $request->client_id)
            ->where('checking', $request->checking_id)
            ->where('ocular', $request->ocular_bool)
            ->get();

        if(count($checking) <= 0)
        {
            $bi_name = '';
            $getbiName = DB::table('bi_account_list')
                ->where('id' , $request->client_id)
                ->select([
                    'bi_account_name',
                    'account_location'
                ])
                ->get();

            $bi_name = $getbiName[0]->bi_account_name . ' ' . $getbiName[0]->account_location;

            $getInsertId = DB::table('bi_rates_alacarte')
                ->insertGetId([
                    'checking' => $request->checking_id,
                    'ocular' => $request->ocular_bool,
                    'bi_id' => $request->client_id,
                    'rate' => $request->rate,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);


            DB::table('marketing_logs')
                ->insert([
                    'bi_rate_id' => $getInsertId,
                    'user_id' => Auth::user()->id,
                    'activity' => 'Added rate to '. $bi_name,
                    'type' => 'bi_rates_alacarte',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'ok';
        }
        else
        {
            return 'double';
        }

    }
}
