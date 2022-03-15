<?php

namespace App\Http\Controllers;

use App\bi_endorsement;
use App\bi_endorsements_user;
use App\bi_log;
use App\Business;
use App\Employer;
use App\Endorsement;
use App\Generals\AuditQueries;
use App\Generals\DownloadZipLogic;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\Generals\Trimmer;
use App\Municipality;
use App\Province;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ZanySoft\Zip\Zip;

class APIoimsController extends Controller
{
    //start bank c.i
    public function endorsement_get(Request $request)
    {

        $request->validate([

//            'id' => 'required',
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ]);


        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.id as id')
            ->where('users.email', $request->email)
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->where('roles.name', 'Client')
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result'=> false
                ]);
        }

        $id = $get_details[0]->id;

        $checkifclient = DB::table('user_client')
            ->where('user_id',$id)
            ->select('user_branch','id')
            ->get();
        $authing = '';

        if(sizeof($checkifclient) <= 0)
        {
            $authing = $id;
        }
        else
        {
            $authing = $checkifclient[0]->user_branch;
        }


        if($request->pagelength != null)
        {
            $length = $request->pagelength;
            $page_length_str = '&pagelength='.$length;
        }
        else
        {
            $length = 10;
            $page_length_str = '';
        }

        if(!is_numeric($length))
        {
            $length = 10;
        }

        if($request->downloadable == true)
        {

        }
        else
        {
            //donothing
        }

        if($request->search != null)
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
                ->leftjoin('businesses','businesses.endorsement_id','=','endorsements.id')
                ->leftjoin('employers','employers.endorsement_id','=','endorsements.id')
                ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsements.id')
                ->select
                (
                    [
                        'endorsements.id as endorse_id',
                        'endorsements.account_name as account_name',
                        'type_of_subjects.type_of_subject_name as subject_type',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.address as address',
                        'municipalities.muni_name as municipality',
                        'provinces.name as province',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.client_remarks as special_remarks',
                        'endorsements.re_ci as entry_as',
                        'endorsements.type_of_loan as type_of_loan',
                        'endorsements.verify_through as verify_through',
                        'endorsements.assigned_by_srao as senior_officer_handler',
                        'endorsements.handled_by_dispatcher as dispatcher_handler',
                        'endorsements.handled_by_credit_investigator as credit_investigator_handler',
                        'endorsements.assigned_by_srao as account_officer_handler',
                        'endorsements.date_ci_visit as ci_date_visit',
                        'endorsements.time_ci_visit as ci_time_visit',
                        'endorsements.date_forwarded_to_client as ao_date_forwarded_to_client',
                        'endorsements.time_forwarded_to_client as ao_time_forwarded_to_client',
                        'endorsements.link_path as download_link'

                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->where('endorsements.account_name','LIKE','%'.$request->search.'%')
                ->orderBy('endorsements.id','desc')
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.'&search='.$request->search.$page_length_str.'');
        }
        else
        {
            $endorsements = DB::table('endorsement_user')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
                ->join('provinces','provinces.id','=','municipalities.province_id')
                ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
                ->leftjoin('businesses','businesses.endorsement_id','=','endorsements.id')
                ->leftjoin('employers','employers.endorsement_id','=','endorsements.id')
                ->join('type_of_subjects','type_of_subjects.endorsement_id','=','endorsements.id')
                ->select
                (
                    [
                        'endorsements.id as endorse_id',
                        'endorsements.account_name as account_name',
                        'type_of_subjects.type_of_subject_name as subject_type',
                        'endorsements.date_endorsed as date_endorsed',
                        'endorsements.time_endorsed as time_endorsed',
                        'endorsements.date_due as date_due',
                        'endorsements.time_due as time_due',
                        'endorsements.address as address',
                        'municipalities.muni_name as municipality',
                        'provinces.name as province',
                        'endorsements.type_of_request as type_of_request',
                        'endorsements.requestor_name as requestor_name',
                        'endorsements.client_remarks as special_remarks',
                        'endorsements.re_ci as entry_as',
                        'endorsements.type_of_loan as type_of_loan',
                        'endorsements.verify_through as verify_through',
                        'endorsements.assigned_by_srao as senior_officer_handler',
                        'endorsements.handled_by_dispatcher as dispatcher_handler',
                        'endorsements.handled_by_credit_investigator as credit_investigator_handler',
                        'endorsements.assigned_by_srao as account_officer_handler',
                        'endorsements.date_ci_visit as ci_date_visit',
                        'endorsements.time_ci_visit as ci_time_visit',
                        'endorsements.date_forwarded_to_client as ao_date_forwarded_to_client',
                        'endorsements.time_forwarded_to_client as ao_time_forwarded_to_client',
                        'endorsements.link_path as download_link'
                    ]
                )
                ->where('endorsement_user.client_id',$authing)
                ->orderBy('endorsements.id','desc')
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'');
        }

        function get_attachment_bank($data,$id,$req)
        {
            if ($data != '')
            {
                $encrypted_id = base64_encode(gzdeflate($id));
                $encrypted_file_name = base64_encode(gzdeflate($data));

                return [
                    'file_name' => $data,
                    'download_link' => $req->root().'/api/download_account_link?dl='.$encrypted_id.'&dll='.$encrypted_file_name.'&email='.$req->email.'&api_key='.$req->api_key.'&secret_id='.$req->secret_id
                ];
            }
            else
            {
                return 'no file attached.';
            }
        }

        $get_linker = $request;

        $itemsTransformed = $endorsements
            ->getCollection()
            ->map(function($item) use ($get_linker) {
                return [
                    'endorse_id'    =>  $item->endorse_id,
                    'account_name'  =>  $item->account_name,
                    'subject_type'  =>  $item->subject_type,
                    'date_endorsed' =>  $item->date_endorsed,
                    'time_endorsed' =>  $item->time_endorsed,
                    'date_due'      =>  $item->date_due,
                    'time_due'      =>  $item->time_due,
                    'address'       =>  $item->address,
                    'municipality'  =>  $item->municipality,
                    'province'      =>  $item->province,
                    'type_of_request'   =>  $item->type_of_request,
                    'requestor_name'    =>  $item->requestor_name,
                    'special_remarks'   =>  $item->special_remarks,
                    'entry_as'      =>  $item->entry_as,
                    'type_of_loan'  => $item->type_of_loan,
                    'verify_through'    =>  $item->verify_through,
                    'senior_officer_handler'    =>  $item->senior_officer_handler,
                    'dispatcher_handler'    =>  $item->dispatcher_handler,
                    'credit_investigator_handler'   =>  $item->credit_investigator_handler,
                    'account_officer_handler'   =>  $item->account_officer_handler,
                    'ci_date_visit' =>  $item->ci_date_visit,
                    'ci_time_visit' =>  $item->ci_time_visit,
                    'ao_date_forwarded_to_client'   =>  $item->ao_date_forwarded_to_client,
                    'ao_time_forwarded_to_client'   =>  $item->ao_time_forwarded_to_client,
                    'download_link' =>  get_attachment_bank($item->download_link,$item->endorse_id,$get_linker),
                ];
            })->toArray();

        $endorsement_pagenated_transform = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $endorsements->total(),
            $endorsements->perPage(),
            $endorsements->currentPage(), [
                'path' => \Request::url().'?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.'&search='.$request->search.$page_length_str,
                'query' => [
                    'page' => $endorsements->currentPage()
                ]
            ]
        );

        return response()->json(
            [
                'message' => ['success'],
                'endorsement' => $endorsement_pagenated_transform,
                'result' => true
            ]
        );
    }

    public function endorsement_submit_pdrn(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.id as id','users.name as name','roles.name as role_name')
            ->where('users.email', $request->email)
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->where('roles.name', 'Client')
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=> ['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'municipality' => 'required',
                'province' => 'required',
                'address' => 'required',
//                'clientName' => 'required',
                'requestor_name' => 'required',
                'remarks' => 'required',
//                'requestType' => 'required',
                'verify_type' => 'required',
                'priority_type' => 'required',
                'entry_as' => 'required',
                'loan_type' => 'required',
//                'etar' => 'required',

            ]);

        if($validator->fails())
        {
            return response()->json(['message' => $validator->errors(),'result'=>false]);
        }
        else {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $endorse = new Endorsement;
            $endorse->date_endorsed = $date;
            $endorse->time_endorsed = $time;


            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $muni = $removeScript->scripttrim($request->municipality);
            $prov = $removeScript->scripttrim($request->province);
            $address = $removeScript->scripttrim($request->address);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $type_of_request = 'PDRN';//direct

            $client_name = $removeScript->scripttrim($get_details[0]->name);

            $verifythrough = strtoupper($removeScript->scripttrim($request->verify_type));//validation
            $prio = strtoupper($removeScript->scripttrim($request->priority_type));//validation
            $type_of_endorsement = strtoupper($removeScript->scripttrim($request->entry_as));//validation
            $loan_type = strtoupper($removeScript->scripttrim($request->loan_type));//validation

            $error_check = false;

            if ($verifythrough == 'NON DISCREET' || $verifythrough == 'DISCREET')
            {
                $verifythrough_err = 'Success';
            }
            else
            {
                //give error
                $verifythrough_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Non Discreet',
                        'data_2'    =>  'Discreet'
                    ],
                    "inputted_data" => $verifythrough
                ];
                $error_check = true;
            }

            if ($prio == 'REGULAR' || $prio == 'PRIORITY DISCREET')
            {
                $prio_err = 'Success';

            }
            else
            {
                //give error
                $prio_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Regular',
                        'data_2'    =>  'Priority Discreet'
                    ],
                    "inputted_data" => $prio
                ];
                $error_check = true;
            }

            if ($type_of_endorsement == 'RE-VISIT')
            {
                $type_of_endorsement_err = 'Success';
                $type_of_endorsement = 'Re-Visit(RE C.I)';
            }
            else if($type_of_endorsement == 'OTHER ADDRESS' || $type_of_endorsement == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-Visit',
                        'data_3'    =>  'Other Address'
                    ],
                    "inputted_data" => $type_of_endorsement
                ];
                $error_check = true;
            }

            if($loan_type == '----(UNDEFINED)' || $loan_type == 'AUTO LOAN' || $loan_type == 'PERSONAL LOAN' || $loan_type == 'HOUSING LOAN' || $loan_type == 'SMALL BUSINESS LOAN' || $loan_type == 'MORTGAGE LOAN')
            {
                $loan_type_err = 'Success';
            }
            else
            {
                //give error
                $loan_type_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  '----(Undefined)',
                        'data_2'    =>  'Auto Loan',
                        'data_3'    =>  'Personal Loan',
                        'data_4'    =>  'Housing Loan',
                        'data_5'    =>  'Small Business Loan',
                        'data_6'    =>  'Mortgage Loan'
                    ],
                    "inputted_data" =>  $loan_type
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'verify_type' => $verifythrough_err,
                            'priority_type' => $prio_err,
                            'entry_as' => $type_of_endorsement_err,
                            'loan_type' => $loan_type_err,
                        ],
                        'result'=>false
                    ]);
            }


            $getStrMuni = Municipality::where('muni_name','like','%'.$muni.'%')
                ->select('id','province_id','muni_name')
                ->get();

            $getProvID = Province::where('name','like','%'.$prov.'%')
                ->select('id','name')
                ->get();

            $full_account_name = $trimmer->trims($f_name . ' ' . $m_name . ' ' . $l_name);

            $check_double_endorse = DB::table('endorsements')
                ->select('id')
                ->where('account_name', $full_account_name)
                ->where('type_of_request', strtoupper($type_of_request))
                ->get();

            $double_endorse = false;
            $different_entry = false;

            if (count($check_double_endorse) >= 1) {

                $double_endorse = true;
            }

            if ($type_of_endorsement == "NEW ENDORSEMENT")
            {
                $different_entry = true;
            }

            if($double_endorse == true && $different_entry == true)
            {
                return response()->json(
                    [
                        'message' => ['This account is already endorsed. Please try different account or change loan type and endorsement type.'],
                        'result' => false
                    ]);
            }

            //start inserting things
            //account
            $endorse->account_name = $full_account_name;
            //address
            $endorse->address = ($trimmer->trims($address));
            $endorse->city_muni = strtoupper($getStrMuni[0]->id);
            $endorse->provinces = strtoupper($getProvID[0]->name);
            $endorse->client_name = strtoupper($client_name);
            //requestor name
            $endorse->requestor_name =  ($trimmer->trims($requestor_name));
            $endorse->type_of_loan = strtoupper($loan_type);
            $endorse->type_of_request = strtoupper($type_of_request);
            //remarks
            $endorse->client_remarks =  ($trimmer->trims($remarks));
            $endorse->verify_through = strtoupper($verifythrough);
            $endorse->prioritize = strtoupper($prio);
            $endorse->re_ci = strtoupper($type_of_endorsement);

            $auth_id = $get_details[0]->id; //AUTH ID

            $user = User::find($auth_id);
            $endorse->acct_branch = $user->provinces->first()->id;

            //make function that will get the rate depending on the address/muni/prov and client
            $get_client_user_rate = DB::table('rates')
                ->select('rate')
                ->where('municipality_id',$getStrMuni[0]->id)
                ->where('province_id',$getProvID[0]->id)
                ->where('user_id',$auth_id)
                ->get();

            if(count($get_client_user_rate) == 0)
            {
                $endorse->rate = 'No Rate at this Address';
            }
            else
            {
                $endorse->rate = $get_client_user_rate[0]->rate;
            }

            $endorse->save();

            $authing = '';

            $checkifclient = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->get();

            if(sizeof($checkifclient) <= 0)
            {
                $authing = $auth_id;
            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }


            $user->endorsements()->attach($endorse->id,
                [
                    'position_id'   =>  $user->roles->first()->id,
                    'province_id'   =>  $user->provinces->first()->id,
                    'client_id'     =>  $authing
                ]
            );

            $endorseID = $endorse->id;
            $endorse_account_name = $endorse->account_name;
            //INSERT TIMESTAMP ID
            DB::table('timestamps')
                ->insert
                ([
                    'endorsement_id' => $endorseID
                ]);
            //END OF TIMESTAMP ID

            // INSERT TYPE OF SUBJECT AND SUBJECT NAME
            DB::table('type_of_subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'type_of_subject_name' => strtoupper('SUBJECT')
                    ]
                );

            DB::table('subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'subject_name' => 'NONE'
                    ]
                );
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->auth_api_submit($auth_id,$endorseID,$endorse_account_name);
            //END OF AUDIT


            // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila

            $array_pass_to_email = [
                'acctName'          =>  $endorse->account_name,
                'address'           =>  $endorse->address.' '.$getStrMuni[0]->muni_name.' '.$getProvID[0]->name,
                'nameOfRequestor'   =>  $endorse->requestor_name,
                'typeOfLoan'        =>  $endorse->type_of_loan,
                'typeOfRequest'     =>  $endorse->type_of_request,
                'remarks'           =>  $endorse->client_remarks
            ];

            $check_if_client = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->where(function ($query)
                {
                    return $query->orwhere('user_branch',423)
                        ->orwhere('user_branch',486)
                        ->orwhere('user_branch',345)
                        ->orwhere('user_branch',411)
                        ->orwhere('user_branch',356)
                        ->orwhere('user_branch',388);
                })
                ->count();

            if($check_if_client > 0)
            {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_api($array_pass_to_email,$user->name);
            }
            $emailSend = new EmailQueries();
            $emailSend->sendEmail_for_admin_api($array_pass_to_email,$user->name,$auth_id);
            // END OF EMAIL

            return response()->json(['message'=>['success'],'result'=>true]);
        }
    }

    public function endorsement_submit_evr(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.id as id','users.name as name')
            ->where('users.email', $request->email)
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->where('roles.name', 'Client')
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'employer' => 'required',
                'municipality' => 'required',
                'province' => 'required',
                'address' => 'required',
//                'clientName' => 'required',
                'requestor_name' => 'required',
                'remarks' => 'required',
//                'requestType' => 'required',
                'verify_type' => 'required',
                'priority_type' => 'required',
                'entry_as' => 'required',
                'loan_type' => 'required',
//                'etar' => 'required',

            ]);

        if($validator->fails())
        {
            return response()->json(['message' => $validator->errors(),'result'=>false]);
        }
        else {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $endorse = new Endorsement;
            $endorse->date_endorsed = $date;
            $endorse->time_endorsed = $time;


            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $employer = $removeScript->scripttrim($request->employer);
            $muni = $removeScript->scripttrim($request->municipality);
            $prov = $removeScript->scripttrim($request->province);
            $address = $removeScript->scripttrim($request->address);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $type_of_request = 'EVR';//direct

            $client_name = $removeScript->scripttrim($get_details[0]->name);

            $verifythrough = strtoupper($removeScript->scripttrim($request->verify_type));//validation
            $prio = strtoupper($removeScript->scripttrim($request->priority_type));//validation
            $type_of_endorsement = strtoupper($removeScript->scripttrim($request->entry_as));//validation
            $loan_type = strtoupper($removeScript->scripttrim($request->loan_type));//validation

            $error_check = false;

            if ($verifythrough == 'NON DISCREET' || $verifythrough == 'DISCREET')
            {
                $verifythrough_err = 'Success';
            }
            else
            {
                //give error
                $verifythrough_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Non Discreet',
                        'data_2'    =>  'Discreet'
                    ],
                    "inputted_data" => $verifythrough
                ];
                $error_check = true;
            }

            if ($prio == 'REGULAR' || $prio == 'PRIORITY DISCREET')
            {
                $prio_err = 'Success';

            }
            else
            {
                //give error
                $prio_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Regular',
                        'data_2'    =>  'Priority Discreet'
                    ],
                    "inputted_data" => $prio
                ];
                $error_check = true;
            }

            if ($type_of_endorsement == 'RE-VISIT')
            {
                $type_of_endorsement_err = 'Success';
                $type_of_endorsement = 'Re-Visit(RE C.I)';
            }
            else if($type_of_endorsement == 'OTHER ADDRESS' || $type_of_endorsement == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-Visit',
                        'data_3'    =>  'Other Address'
                    ],
                    "inputted_data" => $type_of_endorsement
                ];
                $error_check = true;
            }

            if($loan_type == '----(UNDEFINED)' || $loan_type == 'AUTO LOAN' || $loan_type == 'PERSONAL LOAN' || $loan_type == 'HOUSING LOAN' || $loan_type == 'SMALL BUSINESS LOAN' || $loan_type == 'MORTGAGE LOAN')
            {
                $loan_type_err = 'Success';
            }
            else
            {
                //give error
                $loan_type_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  '----(Undefined)',
                        'data_2'    =>  'Auto Loan',
                        'data_3'    =>  'Personal Loan',
                        'data_4'    =>  'Housing Loan',
                        'data_5'    =>  'Small Business Loan',
                        'data_6'    =>  'Mortgage Loan'
                    ],
                    "inputted_data" =>  $loan_type
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'verify_type' => $verifythrough_err,
                            'priority_type' => $prio_err,
                            'entry_as' => $type_of_endorsement_err,
                            'loan_type' => $loan_type_err,
                        ],
                        'result'=>false
                    ]);
            }


            $getStrMuni = Municipality::where('muni_name','like','%'.$muni.'%')
                ->select('id','province_id','muni_name')
                ->get();

            $getProvID = Province::where('name','like','%'.$prov.'%')
                ->select('id','name')
                ->get();

            $full_account_name = ($trimmer->trims($f_name . ' ' . $m_name . ' ' . $l_name));

            $check_double_endorse = DB::table('endorsements')
                ->select('id')
                ->where('account_name', $full_account_name)
                ->where('type_of_request', strtoupper($type_of_request))
                ->get();

            $double_endorse = false;
            $different_entry = false;

            if (count($check_double_endorse) >= 1) {

                $double_endorse = true;
            }

            if ($type_of_endorsement == "NEW ENDORSEMENT")
            {
                $different_entry = true;
            }

            if($double_endorse == true && $different_entry == true)
            {
                return response()->json(
                    [
                        'message' => ['This account is already endorsed. Please try different account or change loan type and endorsement type.'],
                        'result' => false
                    ]);
            }

            //start inserting things
            //account
            $endorse->account_name = $full_account_name;
            //address
            $endorse->address = ($trimmer->trims($address));
            $endorse->city_muni = strtoupper($getStrMuni[0]->id);
            $endorse->provinces = strtoupper($getProvID[0]->name);
            $endorse->client_name = strtoupper($client_name);
            //requestor name
            $endorse->requestor_name =  ($trimmer->trims($requestor_name));
            $endorse->type_of_loan = strtoupper($loan_type);
            $endorse->type_of_request = strtoupper($type_of_request);
            //remarks
            $endorse->client_remarks =  ($trimmer->trims($remarks));
            $endorse->verify_through = strtoupper($verifythrough);
            $endorse->prioritize = strtoupper($prio);
            $endorse->re_ci = strtoupper($type_of_endorsement);

            $auth_id = $get_details[0]->id; //AUTH ID

            $user = User::find($auth_id);
            $endorse->acct_branch = $user->provinces->first()->id;

            //make function that will get the rate depending on the address/muni/prov and client
            $get_client_user_rate = DB::table('rates')
                ->select('rate')
                ->where('municipality_id',$getStrMuni[0]->id)
                ->where('province_id',$getProvID[0]->id)
                ->where('user_id',$auth_id)
                ->get();

            if(count($get_client_user_rate) == 0)
            {
                $endorse->rate = 'No Rate at this Address';
            }
            else
            {
                $endorse->rate = $get_client_user_rate[0]->rate;
            }

            $endorse->save();

            $empArr = new Employer
            (
                [
                    'employer_name'=> $trimmer->trims($employer),
                ]
            );
            $endorse->employers()->save($empArr);

            $authing = '';

            $checkifclient = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->get();

            if(sizeof($checkifclient) <= 0)
            {
                $authing = $auth_id;
            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }


            $user->endorsements()->attach($endorse->id,
                [
                    'position_id'   =>  $user->roles->first()->id,
                    'province_id'   =>  $user->provinces->first()->id,
                    'client_id'     =>  $authing
                ]
            );

            $endorseID = $endorse->id;
            $endorse_account_name = $endorse->account_name;
            //INSERT TIMESTAMP ID
            DB::table('timestamps')
                ->insert
                ([
                    'endorsement_id' => $endorseID
                ]);
            //END OF TIMESTAMP ID

            // INSERT TYPE OF SUBJECT AND SUBJECT NAME
            DB::table('type_of_subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'type_of_subject_name' => strtoupper('SUBJECT')
                    ]
                );

            DB::table('subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'subject_name' => 'NONE'
                    ]
                );
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->auth_api_submit($auth_id,$endorseID,$endorse_account_name);
            //END OF AUDIT


            // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila

            $array_pass_to_email = [
                'acctName'          =>  $endorse->account_name,
                'address'           =>  $endorse->address.' '.$getStrMuni[0]->muni_name.' '.$getProvID[0]->name,
                'nameOfRequestor'   =>  $endorse->requestor_name,
                'typeOfLoan'        =>  $endorse->type_of_loan,
                'typeOfRequest'     =>  $endorse->type_of_request,
                'remarks'           =>  $endorse->client_remarks
            ];

            $check_if_client = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->where(function ($query)
                {
                    return $query->orwhere('user_branch',423)
                        ->orwhere('user_branch',486)
                        ->orwhere('user_branch',345)
                        ->orwhere('user_branch',411)
                        ->orwhere('user_branch',356)
                        ->orwhere('user_branch',388);
                })
                ->count();

            if($check_if_client > 0)
            {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_api($array_pass_to_email,$user->name);
            }
            $emailSend = new EmailQueries();
            $emailSend->sendEmail_for_admin_api($array_pass_to_email,$user->name);
            // END OF EMAIL

            return response()->json(['message'=>['success'],'result'=>true]);
        }
    }

    public function endorsement_submit_bvr(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.id as id','users.name as name')
            ->where('users.email', $request->email)
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->where('roles.name', 'Client')
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'business' => 'required',
                'municipality' => 'required',
                'province' => 'required',
                'address' => 'required',
//                'clientName' => 'required',
                'requestor_name' => 'required',
                'remarks' => 'required',
//                'requestType' => 'required',
                'verify_type' => 'required',
                'priority_type' => 'required',
                'entry_as' => 'required',
                'loan_type' => 'required',
//                'etar' => 'required',

            ]);

        if($validator->fails())
        {
            return response()->json(['message' => $validator->errors(),'result'=>false]);
        }
        else {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $endorse = new Endorsement;
            $endorse->date_endorsed = $date;
            $endorse->time_endorsed = $time;


            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $business = $removeScript->scripttrim($request->business);
            $muni = $removeScript->scripttrim($request->municipality);
            $prov = $removeScript->scripttrim($request->province);
            $address = $removeScript->scripttrim($request->address);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $type_of_request = 'BVR';//direct

            $client_name = $removeScript->scripttrim($get_details[0]->name);

            $verifythrough = strtoupper($removeScript->scripttrim($request->verify_type));//validation
            $prio = strtoupper($removeScript->scripttrim($request->priority_type));//validation
            $type_of_endorsement = strtoupper($removeScript->scripttrim($request->entry_as));//validation
            $loan_type = strtoupper($removeScript->scripttrim($request->loan_type));//validation

            $error_check = false;

            if ($verifythrough == 'NON DISCREET' || $verifythrough == 'DISCREET')
            {
                $verifythrough_err = 'Success';
            }
            else
            {
                //give error
                $verifythrough_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Non Discreet',
                        'data_2'    =>  'Discreet'
                    ],
                    "inputted_data" => $verifythrough
                ];
                $error_check = true;
            }

            if ($prio == 'REGULAR' || $prio == 'PRIORITY DISCREET')
            {
                $prio_err = 'Success';

            }
            else
            {
                //give error
                $prio_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'Regular',
                        'data_2'    =>  'Priority Discreet'
                    ],
                    "inputted_data" => $prio
                ];
                $error_check = true;
            }

            if ($type_of_endorsement == 'RE-VISIT')
            {
                $type_of_endorsement_err = 'Success';
                $type_of_endorsement = 'Re-Visit(RE C.I)';
            }
            else if($type_of_endorsement == 'OTHER ADDRESS' || $type_of_endorsement == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-Visit',
                        'data_3'    =>  'Other Address'
                    ],
                    "inputted_data" => $type_of_endorsement
                ];
                $error_check = true;
            }

            if($loan_type == '----(UNDEFINED)' || $loan_type == 'AUTO LOAN' || $loan_type == 'PERSONAL LOAN' || $loan_type == 'HOUSING LOAN' || $loan_type == 'SMALL BUSINESS LOAN' || $loan_type == 'MORTGAGE LOAN')
            {
                $loan_type_err = 'Success';
            }
            else
            {
                //give error
                $loan_type_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  '----(Undefined)',
                        'data_2'    =>  'Auto Loan',
                        'data_3'    =>  'Personal Loan',
                        'data_4'    =>  'Housing Loan',
                        'data_5'    =>  'Small Business Loan',
                        'data_6'    =>  'Mortgage Loan'
                    ],
                    "inputted_data" =>  $loan_type
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'verify_type' => $verifythrough_err,
                            'priority_type' => $prio_err,
                            'entry_as' => $type_of_endorsement_err,
                            'loan_type' => $loan_type_err,
                        ],
                        'result' => false
                    ]);
            }


            $getStrMuni = Municipality::where('muni_name','like','%'.$muni.'%')
                ->select('id','province_id','muni_name')
                ->get();

            $getProvID = Province::where('name','like','%'.$prov.'%')
                ->select('id','name')
                ->get();

            $full_account_name = ($trimmer->trims($f_name . ' ' . $m_name . ' ' . $l_name));

            $check_double_endorse = DB::table('endorsements')
                ->select('id')
                ->where('account_name', $full_account_name)
                ->where('type_of_request', strtoupper($type_of_request))
                ->get();

            $double_endorse = false;
            $different_entry = false;

            if (count($check_double_endorse) >= 1) {

                $double_endorse = true;
            }

            if ($type_of_endorsement == "NEW ENDORSEMENT")
            {
                $different_entry = true;
            }

            if($double_endorse == true && $different_entry == true)
            {
                return response()->json(
                    [
                        'message' => ['This account is already endorsed. Please try different account or change loan type and endorsement type.'],
                        'result' => false
                    ]);
            }

            //start inserting things
            //account
            $endorse->account_name = $full_account_name;
            //address
            $endorse->address = ($trimmer->trims($address));
            $endorse->city_muni = strtoupper($getStrMuni[0]->id);
            $endorse->provinces = strtoupper($getProvID[0]->name);
            $endorse->client_name = strtoupper($client_name);
            //requestor name
            $endorse->requestor_name =  ($trimmer->trims($requestor_name));
            $endorse->type_of_loan = strtoupper($loan_type);
            $endorse->type_of_request = strtoupper($type_of_request);
            //remarks
            $endorse->client_remarks =  ($trimmer->trims($remarks));
            $endorse->verify_through = strtoupper($verifythrough);
            $endorse->prioritize = strtoupper($prio);
            $endorse->re_ci = strtoupper($type_of_endorsement);

            $auth_id = $get_details[0]->id; //AUTH ID

            $user = User::find($auth_id);
            $endorse->acct_branch = $user->provinces->first()->id;

            //make function that will get the rate depending on the address/muni/prov and client
            $get_client_user_rate = DB::table('rates')
                ->select('rate')
                ->where('municipality_id',$getStrMuni[0]->id)
                ->where('province_id',$getProvID[0]->id)
                ->where('user_id',$auth_id)
                ->get();

            if(count($get_client_user_rate) == 0)
            {
                $endorse->rate = 'No Rate at this Address';
            }
            else
            {
                $endorse->rate = $get_client_user_rate[0]->rate;
            }

            $endorse->save();

            //business info
            $busArr = new Business
            (
                [
                    'business_name'=> $trimmer->trims($business)
                ]
            );
            $endorse->businesses()->save($busArr);

            $authing = '';

            $checkifclient = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->get();

            if(sizeof($checkifclient) <= 0)
            {
                $authing = $auth_id;
            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }


            $user->endorsements()->attach($endorse->id,
                [
                    'position_id'   =>  $user->roles->first()->id,
                    'province_id'   =>  $user->provinces->first()->id,
                    'client_id'     =>  $authing
                ]
            );

            $endorseID = $endorse->id;
            $endorse_account_name = $endorse->account_name;
            //INSERT TIMESTAMP ID
            DB::table('timestamps')
                ->insert
                ([
                    'endorsement_id' => $endorseID
                ]);
            //END OF TIMESTAMP ID

            // INSERT TYPE OF SUBJECT AND SUBJECT NAME
            DB::table('type_of_subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'type_of_subject_name' => strtoupper('SUBJECT')
                    ]
                );

            DB::table('subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'subject_name' => 'NONE'
                    ]
                );
            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->auth_api_submit($auth_id,$endorseID,$endorse_account_name);
            //END OF AUDIT


            // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila

            $array_pass_to_email = [
                'acctName'          =>  $endorse->account_name,
                'address'           =>  $endorse->address.' '.$getStrMuni[0]->muni_name.' '.$getProvID[0]->name,
                'nameOfRequestor'   =>  $endorse->requestor_name,
                'typeOfLoan'        =>  $endorse->type_of_loan,
                'typeOfRequest'     =>  $endorse->type_of_request,
                'remarks'           =>  $endorse->client_remarks
            ];

            $check_if_client = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->where(function ($query)
                {
                    return $query->orwhere('user_branch',423)
                        ->orwhere('user_branch',486)
                        ->orwhere('user_branch',345)
                        ->orwhere('user_branch',411)
                        ->orwhere('user_branch',356)
                        ->orwhere('user_branch',388);
                })
                ->count();

            if($check_if_client > 0)
            {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_api($array_pass_to_email,$user->name);
            }
            $emailSend = new EmailQueries();
            $emailSend->sendEmail_for_admin_api($array_pass_to_email,$user->name);
            // END OF EMAIL

            return response()->json(['message'=>['success'],'result'=>true]);
        }
    }

    public function endorsement_submit_coborrower(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.id as id','users.name as name')
            ->where('users.email', $request->email)
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->where('roles.name', 'Client')
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        $validator = Validator::make($request->all(),
            [
                'co_f_name' => 'required',
                'co_m_name' => 'required',
                'co_l_name' => 'required',
                'main_f_name' => 'required',
                'main_m_name' => 'required',
                'main_l_name' => 'required',
                'municipality' => 'required',
                'province' => 'required',
                'address' => 'required',
//                'clientName' => 'required',
                'requestor_name' => 'required',
                'remarks' => 'required',
//                'requestType' => 'required',

//                'verify_type' => 'required', ->get from main borrower
//                'priority_type' => 'required', ->get from main borrower
                'entry_as' => 'required',
//                'loan_type' => 'required', ->get from main borrower

//                'etar' => 'required',

            ]);

        if($validator->fails())
        {
            return response()->json(['message' => $validator->errors(),'result' => false]);
        }
        else {
            $timeStamp = Carbon::now('Asia/Manila');
            $splitDateTime = explode(" ", $timeStamp);
            $date = $splitDateTime[0];
            $time = $splitDateTime[1];

            $endorse = new Endorsement;
            $endorse->date_endorsed = $date;
            $endorse->time_endorsed = $time;


            $co_f_name = $removeScript->scripttrim($request->co_f_name);
            $co_m_name = $removeScript->scripttrim($request->co_m_name);
            $co_l_name = $removeScript->scripttrim($request->co_l_name);

            $main_f_name = $removeScript->scripttrim($request->main_f_name);
            $main_m_name = $removeScript->scripttrim($request->main_m_name);
            $main_l_name = $removeScript->scripttrim($request->main_l_name);

            $muni = $removeScript->scripttrim($request->municipality);
            $prov = $removeScript->scripttrim($request->province);
            $address = $removeScript->scripttrim($request->address);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $type_of_request = 'PDRN';//direct

            $type_of_endorsement = strtoupper($removeScript->scripttrim($request->entry_as));

            $client_name = $removeScript->scripttrim($get_details[0]->name);

//            $verifythrough = $removeScript->scripttrim($request->verify_type);//validation
//            $prio = $removeScript->scripttrim($request->priority_type);//validation
//            $type_of_endorsement = $removeScript->scripttrim($request->entry_as);//validation
//            $loan_type = $removeScript->scripttrim($request->loan_type);//validation

            $main_borrower_name = ($trimmer->trims($main_f_name . ' ' . $main_m_name . ' ' . $main_l_name));

            $check_main_borrower = DB::table('endorsements')
                ->join('type_of_subjects', 'type_of_subjects.endorsement_id', '=', 'endorsements.id')
                ->select(
                    [
                        'endorsements.id as id',
                        'endorsements.type_of_loan as type_of_loan',
                        'endorsements.verify_through as verify_through',
                        'endorsements.prioritize as prioritize',
                        'endorsements.re_ci as re_ci'
                    ])
                ->where('endorsements.account_name', $main_borrower_name)
                ->where('endorsements.client_name', $get_details[0]->name)
                ->where('type_of_subjects.type_of_subject_name', 'SUBJECT')
                ->where('endorsements.type_of_request', 'PDRN')
                ->orderBy('endorsements.id', 'desc')
                ->get();

            $error_check = false;
            $error_check_entry_as = false;

            if ($type_of_endorsement == 'RE-VISIT') {
                $type_of_endorsement_err = 'Success';
                $type_of_endorsement = 'Re-Visit(RE C.I)';
            } else if ($type_of_endorsement == 'OTHER ADDRESS' || $type_of_endorsement == 'NEW ENDORSEMENT') {
                $type_of_endorsement_err = 'Success';
            } else {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only" => [
                        'data_1' => 'New Endorsement',
                        'data_2' => 'Re-Visit',
                        'data_3' => 'Other Address'
                    ],
                    "inputted_data" => $type_of_endorsement
                ];
                $error_check_entry_as = true;
            }

            if (count($check_main_borrower) != 0) {
                $loan_type = $check_main_borrower[0]->type_of_loan;
                $verifythrough = $check_main_borrower[0]->verify_through;
                $prio = $check_main_borrower[0]->prioritize;
            } else {
                $check_main_borrower = DB::table('endorsements')
                    ->join('type_of_subjects', 'type_of_subjects.endorsement_id', '=', 'endorsements.id')
                    ->select(
                        [
                            'endorsements.id as id',
                            'endorsements.type_of_loan as type_of_loan',
                            'endorsements.verify_through as verify_through',
                            'endorsements.prioritize as prioritize',
                            'endorsements.re_ci as re_ci'
                        ])
                    ->where('endorsements.account_name', $main_borrower_name)
                    ->where('endorsements.client_name', $get_details[0]->name)
                    ->where('type_of_subjects.type_of_subject_name', 'SUBJECT')
                    ->orderBy('endorsements.id', 'desc')
                    ->get();

                if (count($check_main_borrower) != 0) {
                    $loan_type = $check_main_borrower[0]->type_of_loan;
                    $verifythrough = $check_main_borrower[0]->verify_through;
                    $prio = $check_main_borrower[0]->prioritize;
                    $type_of_endorsement = $check_main_borrower[0]->re_ci;
                } else {
                    $error_check = true;
                }
            }

            if ($error_check) {
                return response()->json(
                    [
                        'message' => ['No main borrower match on the given data.'],
                        'data' => [
                            'main_f_name' => $main_f_name,
                            'main_m_name' => $main_m_name,
                            'main_l_name' => $main_l_name
                        ],
                        'result' => false
                    ]);
            }

            if ($error_check_entry_as) {
                return response()->json(
                    [
                        'message' => ['Wrong data input.'],
                        'data' => [
                            'entry_as' => $type_of_endorsement_err,
                        ],
                        'result' => false
                    ]);
            }


            $getStrMuni = Municipality::where('muni_name', 'like', '%' . $muni . '%')
                ->select('id', 'province_id', 'muni_name')
                ->get();

            $getProvID = Province::where('name', 'like', '%' . $prov . '%')
                ->select('id', 'name')
                ->get();


            $full_account_name = ($trimmer->trims($co_f_name . ' ' . $co_m_name . ' ' . $co_l_name));

            $check_double_endorse = DB::table('endorsements')
                ->select('id')
                ->where('account_name', $full_account_name)
                ->where('type_of_request', strtoupper($type_of_request))
                ->get();

            $double_endorse = false;
            $different_entry = false;

            if (count($check_double_endorse) >= 1) {

                $double_endorse = true;
            }

            if ($type_of_endorsement == "NEW ENDORSEMENT")
            {
                $different_entry = true;
            }

            if($double_endorse == true && $different_entry == true)
            {
                return response()->json(
                    [
                        'message' => ['This account is already endorsed. Please try different account or change loan type and endorsement type.'],
                        'result' => false
                    ]);
            }


            //start inserting things
            //account
            $endorse->account_name = $full_account_name;
            //address
            $endorse->address = ($trimmer->trims($address));
            $endorse->city_muni = strtoupper($getStrMuni[0]->id);
            $endorse->provinces = strtoupper($getProvID[0]->name);
            $endorse->client_name = strtoupper($client_name);
            //requestor name
            $endorse->requestor_name =  ($trimmer->trims($requestor_name));
            $endorse->type_of_request = strtoupper($type_of_request);
            //remarks
            $endorse->client_remarks =  ($trimmer->trims($remarks));

            $endorse->type_of_loan = strtoupper($loan_type);
            $endorse->verify_through = strtoupper($verifythrough);
            $endorse->prioritize = strtoupper($prio);
            $endorse->re_ci = strtoupper($type_of_endorsement);

            $auth_id = $get_details[0]->id; //AUTH ID

            $user = User::find($auth_id);
            $endorse->acct_branch = $user->provinces->first()->id;

            //make function that will get the rate depending on the address/muni/prov and client
            $get_client_user_rate = DB::table('rates')
                ->select('rate')
                ->where('municipality_id',$getStrMuni[0]->id)
                ->where('province_id',$getProvID[0]->id)
                ->where('user_id',$auth_id)
                ->get();

            if(count($get_client_user_rate) == 0)
            {
                $endorse->rate = 'No Rate at this Address';
            }
            else
            {
                $endorse->rate = $get_client_user_rate[0]->rate;
            }

            $endorse->save();

            $authing = '';

            $checkifclient = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->get();

            if(sizeof($checkifclient) <= 0)
            {
                $authing = $auth_id;
            }
            else
            {
                $authing = $checkifclient[0]->user_branch;
            }


            $user->endorsements()->attach($endorse->id,
                [
                    'position_id'   =>  $user->roles->first()->id,
                    'province_id'   =>  $user->provinces->first()->id,
                    'client_id'     =>  $authing
                ]
            );

            $endorseID = $endorse->id;
            $endorse_account_name = $endorse->account_name;
            //INSERT TIMESTAMP ID
            DB::table('timestamps')
                ->insert
                ([
                    'endorsement_id' => $endorseID
                ]);
            //END OF TIMESTAMP ID

            // INSERT TYPE OF SUBJECT AND SUBJECT NAME
            DB::table('type_of_subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'type_of_subject_name' => strtoupper('COBORROWER')
                    ]
                );

            DB::table('subjects')
                ->insert
                (
                    [
                        'endorsement_id' => $endorseID,
                        'subject_name' => $main_borrower_name
                    ]
                );

            DB::table('coborrowers')
                ->insert([
                    'endorsement_id'            =>  $check_main_borrower[0]->id,
                    'coborrower_name'           =>  $endorse_account_name,
                    'coborrower_address'        =>  $endorse->address,
                    'coborrower_municipality'   =>  $getStrMuni[0]->muni_name,
                    'coborrower_province'       =>  $getProvID[0]->name
                ]);

            //AUDIT START HERE
            $auditRemove = new AuditQueries();
            $auditRemove->auth_api_submit($auth_id,$endorseID,$endorse_account_name);
            //END OF AUDIT


            // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila

            $array_pass_to_email = [
                'acctName'          =>  $endorse->account_name,
                'address'           =>  $endorse->address.' '.$getStrMuni[0]->muni_name.' '.$getProvID[0]->name,
                'nameOfRequestor'   =>  $endorse->requestor_name,
                'typeOfLoan'        =>  $endorse->type_of_loan,
                'typeOfRequest'     =>  $endorse->type_of_request,
                'remarks'           =>  $endorse->client_remarks
            ];

            $check_if_client = DB::table('user_client')
                ->where('user_id',$auth_id)
                ->where(function ($query)
                {
                    return $query->orwhere('user_branch',423)
                        ->orwhere('user_branch',486)
                        ->orwhere('user_branch',345)
                        ->orwhere('user_branch',411)
                        ->orwhere('user_branch',356)
                        ->orwhere('user_branch',388);
                })
                ->count();

            if($check_if_client > 0)
            {
                $emailSend = new EmailQueries();
                $emailSend->sendEmail_api($array_pass_to_email,$user->name);
            }
            $emailSend = new EmailQueries();
            $emailSend->sendEmail_for_admin_api($array_pass_to_email,$user->name);
            // END OF EMAIL

            return response()->json(['message' => ['success'],'result' => true]);
        }
    }

    public function down_func(Request $request)
    {

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        if($request->dmk != null) //download through email
        {
            $account_id = (base64_decode($request->dl));

            $account_info = DB::table('endorsements')
                ->select([
                    'endorsements.account_name as account_name',
                    'endorsements.link_path as link_path',
                    'endorsements.down_email_key as key',
                ])
                ->where('endorsements.id', $account_id)
                ->first();

            if(  hash('sha256',$account_info->key) ==  hash('sha256',$request->dmk) )
            {

                $paths = $account_info->link_path;
                $ip = request()->ip();

                if(File::exists(storage_path('/account_client/'.$paths)))
                {
                    if (File::isDirectory(storage_path('account_client/' . $paths)))
                    {
                        Zip::create(storage_path('/account_report/'.$paths.'.zip'), true)
                            ->add(storage_path('/account_client/'.$paths), true)
                            ->setPath(storage_path('/account_report'))
                            ->close();
                    };
                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $account_id,
                                'name' => $ip,
                                'position' => '',
                                'branch' => '',
                                'activities' => strtoupper('Downloaded Report of '. $account_info->account_name.' Through EMAIL'),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    return response()->download(storage_path("/account_report/".$paths.".zip"));

                }
                else if(File::exists(storage_path('/account_report/'.$paths.'.zip')))
                {
                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $account_id,
                                'name' => $ip,
                                'position' => '',
                                'branch' => '',
                                'activities' => strtoupper('Downloaded Report of '. $account_info->account_name.' Through EMAIL'),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    return response()->download(storage_path("/account_report/".$paths.".zip"));
                }
                else
                {
                    return 'Report Not Available at this momment';
                }
            }
            else
            {
                return 'Invalid';
            }

        }
        else
        {
            $request->validate([
                'email' => 'required',
                'secret_id' => 'required',
                'api_key' => 'required',
                'dl' => 'required',
                'dll' => 'required'
            ]);

            $get_details = DB::table('users')
                ->join('role_user','role_user.user_id','=','users.id')
                ->join('roles','roles.id','=','role_user.role_id')
                ->join('municipalities','municipalities.id','=','users.branch')
                ->select([
                    'users.id as id',
                    'users.name as name',
                    'users.client_check as client_check',
                    'role_user.role_id as role_id',
                    'roles.name as pos_name',
                    'municipalities.muni_name as branch_name'
                ])
                ->where('users.email', $request->email)
                ->where('users.api_token', hash('sha256', $request->api_key))
                ->where('roles.name', 'Client')
                ->get();


            if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
            {
                return response()->json(
                    [
                        'message'=>['Wrong Credentials'],
                        'data'=> [
                            'email'=>$request->email,
                            'secret_id'=>$request->secret_id,
                            'api_key'=>$request->api_key,
                            'dl'=>$request->dl,
                            'dll'=>$request->dll
                        ],
                        'result' => false
                    ]);
            }

//        $account_id = $request->id;
            $account_id = gzinflate(base64_decode($request->dl));
            $dl_path = gzinflate(base64_decode($request->dll));

            $acctName = DB::table('endorsements')
                ->join('endorsement_user','endorsement_user.endorsement_id','=','endorsements.id')
                ->select([
                    'endorsements.account_name as account_name',
                    'endorsements.link_path as link_path',
                    'endorsement_user.client_id as client_id'
                ])
                ->where('endorsements.id', $account_id)
                ->where('endorsement_user.position_id', 6)
                ->first();

            $path_link = new DownloadZipLogic();
            $paths = $path_link->path_link($account_id);

            if($paths == $dl_path)
            {
                if(File::exists(storage_path('/account_client/'.$paths)))
                {
                    if (File::isDirectory(storage_path('account_client/' . $paths)))
                    {
                        Zip::create(storage_path('/account_report/'.$paths.'.zip'), true)
                            ->add(storage_path('/account_client/'.$paths), true)
                            ->setPath(storage_path('/account_report'))
                            ->close();
                    };
                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $account_id,
                                'name' => $get_details[0]->name,
                                'position' => $get_details[0]->pos_name,
                                'branch' => $get_details[0]->branch_name,
                                'activities' => strtoupper('Downloaded Report of '. $acctName->account_name.' Through API'),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    return response()->download(storage_path("/account_report/".$paths.".zip"));

                }
                else if(File::exists(storage_path('/account_report/'.$paths.'.zip')))
                {
                    DB::table('audits')
                        ->insert
                        (
                            [
                                'endorsement_id' => $account_id,
                                'name' => $get_details[0]->name,
                                'position' => $get_details[0]->pos_name,
                                'branch' => $get_details[0]->branch_name,
                                'activities' => strtoupper('Downloaded Report of '. $acctName->account_name.' Through API'),
                                'date_occured' => $date,
                                'time_occured' => $time
                            ]
                        );

                    return response()->download(storage_path("/account_report/".$paths.".zip"));
                }
                else
                {
                    return 'Report Not Available at this momment';
                }
            }
            else
            {
                return response()->json(
                    [
                        'message'=>['Invalid download link'],
                        'result' => false
                    ]);
            }

        }
    }
    //end bank c.i

    //start bank tele
    public function bi_endorsement_get(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->select('id','client_check')
            ->where('email', $request->email)
            ->where('client_check','=','cc_bank' )
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        if($request->pagelength != null)
        {
            $length = $request->pagelength;
            $page_length_str = '&pagelength='.$length;
        }
        else
        {
            $length = 10;
            $page_length_str = '';
        }

        if(!is_numeric($length))
        {
            $length = 10;
        }

        if($request->search != null || $request->search != '')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.f_name as f_name',
                    'bi_endorsements.m_name as m_name',
                    'bi_endorsements.l_name as l_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.client_remarks_bank as client_remark',
                    'bi_endorsements.cc_bank_endorsement_type as cc_bank_endorsement_type',
                    'bi_endorsements.endorser_poc as endorser_poc',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->orderBy('bi_endorsements.id','desc')
                ->where('bi_endorsements.account_name','LIKE','%'.$request->search.'%')
                ->where('bi_account_to_users.users_id',$get_details[0]->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '!=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '!=', '');
                })
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'&search='.$request->search);
        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.f_name as f_name',
                    'bi_endorsements.m_name as m_name',
                    'bi_endorsements.l_name as l_name',
                    'bi_endorsements.package as package',
                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.client_remarks_bank as client_remark',
                    'bi_endorsements.cc_bank_endorsement_type as cc_bank_endorsement_type',
                    'bi_endorsements.endorser_poc as endorser_poc',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements_checkings.bi_endorsement_id')
                ->orderBy('bi_endorsements.id','desc')
                ->where('bi_account_to_users.users_id',$get_details[0]->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '!=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '!=', '');
                })
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'');
        }


        function get_attachment($data,$id,$req)
        {
            if ($data != '')
            {
                $encrypted_id = base64_encode(gzdeflate($id));
                $encrypted_file_name = base64_encode(gzdeflate($data));

                return [
                    'file_name' => $data,
                    'download_link' => $req->root().'/api/download_attachment_link?dl='.$encrypted_id.'&dll='.$encrypted_file_name.'&email='.$req->email.'&api_key='.$req->api_key.'&secret_id='.$req->secret_id
                ];
            }
            else
            {
                return 'no file attached.';
            }
        }

        function status_check($status,$id,$req)
        {

            if($status == 0)
            {
                return ['text'=>'New Endorsement'];
            }
            else if ($status == 20)
            {
                return ['text'=>'Returned Upon Endorsement'];
            }
            else if ($status == 22)
            {
                return ['text'=>'Returned During Endorsement'];
            }
            else if ($status == 23)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 24)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 25)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 5)
            {
                return ['text'=>'On-Hold Account'];
            }
            else if ($status == 4)
            {
                return ['text'=>'Cancelled Account'];
            }
            else if ($status == 21)
            {
                return ['text'=>'Re-Endorsed Account'];
            }
            else if ($status == 1)
            {
                return ['text'=>'Acknowledged'];
            }
            else if ($status == 10)
            {
                $encrypted_id = base64_encode(gzdeflate($id));
//                $encrypted_file_name = base64_encode(gzdeflate($data));
                return [
                    'text'=>'Complete/Success',
                    'download_link' => $req->root().'/api/download_success_attachment_link?dl='.$encrypted_id.'&email='.$req->email.'&api_key='.$req->api_key.'&secret_id='.$req->secret_id
                ];
            }
            else if ($status == 2)
            {
                return ['text'=>'Assigned'];
            }
            else if ($status == 3)
            {
                return ['text'=>'Successful Verification'];
            }
            else
            {
                return ['text'=>''];
            }
        }

        $get_linker = $request;

        $itemsTransformed = $get_general_table
            ->getCollection()
            ->map(function($item) use ($get_linker) {
                return [
                    'endorse_id' => $item->endorse_id,
//                    'location' => $item->site,
                    'date_time_endorsed' => $item->date_time_endorsed,
//                    'project' => $item->project,
                    'account_name' => $item->account_name,
                    'f_name' => $item->f_name,
                    'm_name' => $item->m_name,
                    'l_name' => $item->l_name,
                    'attach_1' => get_attachment($item->attach_1,$item->endorse_id,$get_linker),
                    'attach_2' => get_attachment($item->attach_2,$item->endorse_id,$get_linker),
                    'attach_3' => get_attachment($item->attach_3,$item->endorse_id,$get_linker),
                    'attach_4' => get_attachment($item->attach_4,$item->endorse_id,$get_linker),
                    'status' => status_check($item->status,$item->endorse_id,$get_linker),
                    'remarks' => $item->client_remark,
                    'entry_as' => $item->cc_bank_endorsement_type,
                    'requestor_name' => $item->endorser_poc,
                ];
            })->toArray();

        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $get_general_table->total(),
            $get_general_table->perPage(),
            $get_general_table->currentPage(), [
                'path' => \Request::url().'?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'&search='.$request->search,
                'query' => [
                    'page' => $get_general_table->currentPage()
                ]
            ]
        );

        return response()->json([
            'message' => ['success'],
            'endorsements' => $itemsTransformedAndPaginated,
            'result' => true
        ]);
    }

    public function bi_download_files_universal_api(Request $request)
    {
        $request->validate([

//            'id' => 'required',
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required',
            'dl' => 'required',
            'dll' => 'required'
        ]);


        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select([
                'users.id as id',
                'users.client_check as client_check',
                'role_user.role_id as role_id'
            ])
            ->where('users.email', $request->email)
            ->where('users.client_check','=','cc_bank')
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key,
                        'dl'=>$request->dl,
                        'dll'=>$request->dll
                    ],
                    'result' => false,
                ]);
        }

        $get_id = gzinflate(base64_decode($request->dl));

        $account = new bi_endorsement();
        $account = $account::find($get_id);

        $attachment_place = gzinflate(base64_decode($request->dll));

//        $user = User::find(Auth::user()->id);
        $logs = new bi_log();
        $logs->endorse_id = $get_id;
        $logs->user_id = $get_details[0]->id;
        $logs->position_id = $get_details[0]->role_id;
        $logs->activity = 'DOWNLOADED ATTACHMENT '.$attachment_place;
        $logs->remarks = 'Attachment downloaded through API.';
        $logs->save();

        return response()->download(storage_path("bi_attachments/" . $account->bi_id .'/'.$get_id.'/'.$attachment_place));
    }

    public function bi_download_finish_account(Request $request)
    {
        $request->validate([

//            'id' => 'required',
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required',
            'dl' => 'required'
        ]);


        $get_details = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.client_check as client_check',
                'role_user.role_id as role_id'
            ])
            ->where('users.email', $request->email)
            ->where('users.client_check','=','cc_bank')
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key,
                        'dl'=>$request->dl
                    ],
                    'result' => false,
                ]);
        }

        $get_id = gzinflate(base64_decode($request->dl));
        $user_id = $get_details[0]->id;
        $trims = new Trimmer();
        $id = $get_id;

        $getPath = DB::table('bi_endorsements')
            ->select('report_file_path')
            ->where('id', $id)
            ->get();


        if($getPath[0]->report_file_path == null)
        {
            return response()->json(
                [
                    'message'=>['File Not Available'],
                    'result' => false,
                ]);
        }
        else
        {
            $logs = new bi_log();
            $logs->endorse_id = $id;
            $logs->user_id = $user_id;
            $logs->position_id = $get_details[0]->role_id;
            $logs->activity = 'REPORT FILE DOWNLOADED BY ' . $trims->trims($get_details[0]->name) ;
            $logs->remarks = '-';
            $logs->save();

            return response()->download(storage_path($getPath[0]->report_file_path));
        }

    }

    public function bi_endorse_submit_pdrn(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->select('id','client_check')
            ->where('email', $request->email)
            ->where('client_check', 'cc_bank')
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong credentials or this account does not have the access to perform this action.'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false,
                ]);
        }

        $user_id = $get_details[0]->id;

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'entry_as' => 'required',
                'remarks' => 'required',
                'requestor_name' => 'required',
//                'attachments' => 'required',
            ]);

        $removeScript = new ScriptTrimmer();

        if($validator->fails())
        {
            return response()->json(
                [
                    'message' => $validator->errors(),
                    'result' => false,
                ]
            );
        }
        else
        {

            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $entry_as = $removeScript->scripttrim($request->entry_as);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);

            if (strtoupper($entry_as) == 'RE-CALL')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'Re-call';
                $error_check = false;
            }
            else if(strtoupper($entry_as) == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'New Endorsement';
                $error_check = false;
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-call',
                    ],
                    "inputted_data" => $entry_as
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'entry_as' => $type_of_endorsement_err,
                        ],
                        'result' => false,
                    ]);
            }


            $getAcctList = DB::table('bi_account_to_users')
                ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                ->select
                ([
                    'bi_account_to_users.bi_account_id as bi_id',
                    'bi_account_list.bi_account_name as acct_name',
                    'bi_account_list.account_location as loc'
                ])
                ->where('users_id', $user_id)
                ->get();

            $checkSame = DB::table('bi_endorsements')
                ->where('bi_id', $getAcctList[0]->bi_id)
                ->where('f_name', $f_name)
                ->where('m_name', $m_name)
                ->where('l_name', $l_name)
                ->count();

            if($checkSame > 0)
            {
                if($entry_as != 'Re-call')
                {
                    return response()->json(
                        [
                            'message' => ['This account is already endorsed. Please try different account or change the "entry as".'],
                            'result' => false,
                        ]);
                }
            }

            $file1 = $request->file('attach_1');
            $file2 = $request->file('attach_2');
            $file3 = $request->file('attach_3');
            $file4 = $request->file('attach_4');

            $check_siz_file = false;
            $count_file = 0;
            if($file1 != null)
            {
                $count_file += 1;
//                if($file1->getSize() > 500000)
                if($file1->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file1 = $file1->getClientOriginalName().' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file1 = 'success';
                }
            }
            else
            {
                $size_file1 = 'no attached file';
            }

            if($file2 != null)
            {
                $count_file += 1;
                if ($file2->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file2 = $file2->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file2 = 'success';
                }
            }
            else
            {
                $size_file2 = 'no attached file';
            }

            if($file3 != null)
            {
                $count_file += 1;
                if ($file3->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file3 = $file3->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file3 = 'success';
                }
            }
            else
            {
                $size_file3 = 'no attached file';
            }

            if($file4 != null)
            {
                $count_file += 1;
                if ($file4->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file4 = $file4->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file4 = 'success';
                }
            }
            else
            {
                $size_file4 = 'no attached file';
            }

            if($count_file == 0)
            {
                return response()->json(
                    [
                        'message' => [
                            'attach_1' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_2' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_3' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_4' => [
                                'Atleast (1)one attachment is required'
                            ]
                        ],
                        'result' => false,
                    ]);
            }

            if($check_siz_file)
            {
                return response()->json(
                    [
                        'message'=> ['File should not exceed 25mb.'],
                        'data'=> [
                            'attach_1' => $size_file1,
                            'attach_2' => $size_file2,
                            'attach_3' => $size_file3,
                            'attach_4' => $size_file4,
                        ],
                        'result' => false,
                    ]);
            }

            $sitename = $removeScript->scripttrim($getAcctList[0]->acct_name) . ' ' . $removeScript->scripttrim($getAcctList[0]->loc);

            $endorseId = DB::table('bi_endorsements')
                ->insertGetId
                ([
                    'bi_id' => $getAcctList[0]->bi_id,
                    'type_of_endorsement_bank' => 'PDRN',
                    'bi_account_name' => $sitename,
                    'project' => $sitename,
                    'lob' => 'N/A',
                    'package' => '-',
                    'account_name' => $f_name . ', ' .$m_name . ' ' . $l_name,
                    'f_name' => $f_name,
                    'm_name' => $m_name,
                    'l_name' => $l_name,
                    'suffix' => '',
                    'gender' => '',
                    'marital_status' => '',
                    'birth_day' =>'',
                    'birth_month' => '',
                    'birth_year' => '',
                    'age' => '',
                    'citizenship' => '',
                    'maiden_name' => '',
                    'maiden_f_name' => '',
                    'maiden_m_name' => '',
                    'maiden_l_name' => '',
                    'present_address' => '',
                    'present_muni' =>'',
                    'present_province' => '',
                    'permanent_address' => '',
                    'permanent_muni' => '',
                    'permanent_province' => '',

                    'endorser_poc' => $requestor_name,
                    'status' => '0',
                    'created_at' => Carbon::now('Asia/Manila'),
                    'client_remarks_bank' => $remarks,
                    'cc_bank_endorsement_type' => $entry_as
                ]);

            DB::table('bi_endorsements_checkings')
                ->insert
                ([
                    'bi_endorsement_id' => $endorseId,
                    'checking_id' => '0',
                    'checking_name' => 'N/A',
                    'type_check' => 'N/A',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find($user_id);

            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorseId;
            $endorse_user->users_id = $user_id;
            $endorse_user->position_id = $user->roles->first()->id;
            $endorse_user->save();

            $logs = new bi_log();
            $logs->endorse_id = $endorseId;
            $logs->user_id = $user_id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ENDORSED THE ACCOUNT(PDRN)';
            $logs->remarks = '-';
            $logs->save();

            $this->bi_upload_file($file1,$file2,$file3,$file4,$endorseId);

            return response()->json([
                    'message' => ['success'],
                    'result' => true,
                ]
            );
        }

    }

    public function bi_endorse_submit_evr(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->select('id','client_check')
            ->where('email', $request->email)
            ->where('client_check', 'cc_bank')
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong credentials or this account does not have the access to perform this action.'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false,
                ]);
        }

        $user_id = $get_details[0]->id;

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'entry_as' => 'required',
                'remarks' => 'required',
                'requestor_name' => 'required',
//                'attachments' => 'required',
            ]);

        $removeScript = new ScriptTrimmer();

        if($validator->fails())
        {
            return response()->json(
                [
                    'message' => $validator->errors(),
                    'result' => false,
                ]
            );
        }
        else
        {

            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $entry_as = $removeScript->scripttrim($request->entry_as);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);

            if (strtoupper($entry_as) == 'RE-CALL')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'Re-call';
                $error_check = false;
            }
            else if(strtoupper($entry_as) == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'New Endorsement';
                $error_check = false;
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-call',
                    ],
                    "inputted_data" => $entry_as
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'entry_as' => $type_of_endorsement_err,
                        ],
                        'result' => false,
                    ]);
            }


            $getAcctList = DB::table('bi_account_to_users')
                ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                ->select
                ([
                    'bi_account_to_users.bi_account_id as bi_id',
                    'bi_account_list.bi_account_name as acct_name',
                    'bi_account_list.account_location as loc'
                ])
                ->where('users_id', $user_id)
                ->get();

            $checkSame = DB::table('bi_endorsements')
                ->where('bi_id', $getAcctList[0]->bi_id)
                ->where('f_name', $f_name)
                ->where('m_name', $m_name)
                ->where('l_name', $l_name)
                ->count();

            if($checkSame > 0)
            {
                if($entry_as != 'Re-call')
                {
                    return response()->json(
                        [
                            'message' => ['This account is already endorsed. Please try different account or change the "entry as".'],
                            'result' => false,
                        ]);
                }
            }

            $file1 = $request->file('attach_1');
            $file2 = $request->file('attach_2');
            $file3 = $request->file('attach_3');
            $file4 = $request->file('attach_4');

            $check_siz_file = false;
            $count_file = 0;
            if($file1 != null)
            {
                $count_file += 1;
//                if($file1->getSize() > 500000)
                if($file1->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file1 = $file1->getClientOriginalName().' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file1 = 'success';
                }
            }
            else
            {
                $size_file1 = 'no attached file';
            }

            if($file2 != null)
            {
                $count_file += 1;
                if ($file2->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file2 = $file2->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file2 = 'success';
                }
            }
            else
            {
                $size_file2 = 'no attached file';
            }

            if($file3 != null)
            {
                $count_file += 1;
                if ($file3->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file3 = $file3->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file3 = 'success';
                }
            }
            else
            {
                $size_file3 = 'no attached file';
            }

            if($file4 != null)
            {
                $count_file += 1;
                if ($file4->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file4 = $file4->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file4 = 'success';
                }
            }
            else
            {
                $size_file4 = 'no attached file';
            }

            if($count_file == 0)
            {
                return response()->json(
                    [
                        'message' => [
                            'attach_1' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_2' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_3' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_4' => [
                                'Atleast (1)one attachment is required'
                            ]
                        ],
                        'result' => false,
                    ]);
            }

            if($check_siz_file)
            {
                return response()->json(
                    [
                        'message'=> ['File should not exceed 25mb.'],
                        'data'=> [
                            'attach_1' => $size_file1,
                            'attach_2' => $size_file2,
                            'attach_3' => $size_file3,
                            'attach_4' => $size_file4,
                        ],
                        'result' => false,
                    ]);
            }

            $sitename = $removeScript->scripttrim($getAcctList[0]->acct_name) . ' ' . $removeScript->scripttrim($getAcctList[0]->loc);

            $endorseId = DB::table('bi_endorsements')
                ->insertGetId
                ([
                    'bi_id' => $getAcctList[0]->bi_id,
                    'type_of_endorsement_bank' => 'EVR',
                    'bi_account_name' => $sitename,
                    'project' => $sitename,
                    'lob' => 'N/A',
                    'package' => '-',
                    'account_name' => $f_name . ', ' .$m_name . ' ' . $l_name,
                    'f_name' => $f_name,
                    'm_name' => $m_name,
                    'l_name' => $l_name,
                    'suffix' => '',
                    'gender' => '',
                    'marital_status' => '',
                    'birth_day' =>'',
                    'birth_month' => '',
                    'birth_year' => '',
                    'age' => '',
                    'citizenship' => '',
                    'maiden_name' => '',
                    'maiden_f_name' => '',
                    'maiden_m_name' => '',
                    'maiden_l_name' => '',
                    'present_address' => '',
                    'present_muni' =>'',
                    'present_province' => '',
                    'permanent_address' => '',
                    'permanent_muni' => '',
                    'permanent_province' => '',

                    'endorser_poc' => $requestor_name,
                    'status' => '0',
                    'created_at' => Carbon::now('Asia/Manila'),
                    'client_remarks_bank' => $remarks,
                    'cc_bank_endorsement_type' => $entry_as
                ]);

            DB::table('bi_endorsements_checkings')
                ->insert
                ([
                    'bi_endorsement_id' => $endorseId,
                    'checking_id' => '0',
                    'checking_name' => 'N/A',
                    'type_check' => 'N/A',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find($user_id);

            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorseId;
            $endorse_user->users_id = $user_id;
            $endorse_user->position_id = $user->roles->first()->id;
            $endorse_user->save();

            $logs = new bi_log();
            $logs->endorse_id = $endorseId;
            $logs->user_id = $user_id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ENDORSED THE ACCOUNT(PDRN)';
            $logs->remarks = '-';
            $logs->save();

            $this->bi_upload_file($file1,$file2,$file3,$file4,$endorseId);

            return response()->json([
                    'message' => ['success'],
                    'result' => true,
                ]
            );
        }

    }

    public function bi_endorse_submit_bvr(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->select('id','client_check')
            ->where('email', $request->email)
            ->where('client_check', 'cc_bank')
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong credentials or this account does not have the access to perform this action.'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false,
                ]);
        }

        $user_id = $get_details[0]->id;

        $validator = Validator::make($request->all(),
            [
                'f_name' => 'required',
                'm_name' => 'required',
                'l_name' => 'required',
                'entry_as' => 'required',
                'remarks' => 'required',
                'requestor_name' => 'required',
//                'attachments' => 'required',
            ]);

        $removeScript = new ScriptTrimmer();

        if($validator->fails())
        {
            return response()->json(
                [
                    'message' => $validator->errors(),
                    'result' => false,
                ]
            );
        }
        else
        {

            $f_name = $removeScript->scripttrim($request->f_name);
            $m_name = $removeScript->scripttrim($request->m_name);
            $l_name = $removeScript->scripttrim($request->l_name);
            $remarks = $removeScript->scripttrim($request->remarks);
            $entry_as = $removeScript->scripttrim($request->entry_as);
            $requestor_name = $removeScript->scripttrim($request->requestor_name);

            if (strtoupper($entry_as) == 'RE-CALL')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'Re-call';
                $error_check = false;
            }
            else if(strtoupper($entry_as) == 'NEW ENDORSEMENT')
            {
                $type_of_endorsement_err = 'Success';
                $entry_as = 'New Endorsement';
                $error_check = false;
            }
            else
            {
                //give error
                $type_of_endorsement_err = [
                    "accept_data_only"  =>  [
                        'data_1'    =>  'New Endorsement',
                        'data_2'    =>  'Re-call',
                    ],
                    "inputted_data" => $entry_as
                ];
                $error_check = true;
            }

            if($error_check)
            {
                return response()->json(
                    [
                        'message'=>['Wrong data input.'],
                        'data'=> [
                            'entry_as' => $type_of_endorsement_err,
                        ],
                        'result' => false,
                    ]);
            }


            $getAcctList = DB::table('bi_account_to_users')
                ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
                ->select
                ([
                    'bi_account_to_users.bi_account_id as bi_id',
                    'bi_account_list.bi_account_name as acct_name',
                    'bi_account_list.account_location as loc'
                ])
                ->where('users_id', $user_id)
                ->get();

            $checkSame = DB::table('bi_endorsements')
                ->where('bi_id', $getAcctList[0]->bi_id)
                ->where('f_name', $f_name)
                ->where('m_name', $m_name)
                ->where('l_name', $l_name)
                ->count();

            if($checkSame > 0)
            {
                if($entry_as != 'Re-call')
                {
                    return response()->json(
                        [
                            'message' => ['This account is already endorsed. Please try different account or change the "entry as".'],
                            'result' => false,
                        ]);
                }
            }

            $file1 = $request->file('attach_1');
            $file2 = $request->file('attach_2');
            $file3 = $request->file('attach_3');
            $file4 = $request->file('attach_4');

            $check_siz_file = false;
            $count_file = 0;
            if($file1 != null)
            {
                $count_file += 1;
//                if($file1->getSize() > 500000)
                if($file1->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file1 = $file1->getClientOriginalName().' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file1 = 'success';
                }
            }
            else
            {
                $size_file1 = 'no attached file';
            }

            if($file2 != null)
            {
                $count_file += 1;
                if ($file2->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file2 = $file2->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file2 = 'success';
                }
            }
            else
            {
                $size_file2 = 'no attached file';
            }

            if($file3 != null)
            {
                $count_file += 1;
                if ($file3->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file3 = $file3->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file3 = 'success';
                }
            }
            else
            {
                $size_file3 = 'no attached file';
            }

            if($file4 != null)
            {
                $count_file += 1;
                if ($file4->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file4 = $file4->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file4 = 'success';
                }
            }
            else
            {
                $size_file4 = 'no attached file';
            }

            if($count_file == 0)
            {
                return response()->json(
                    [
                        'message' => [
                            'attach_1' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_2' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_3' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_4' => [
                                'Atleast (1)one attachment is required'
                            ]
                        ],
                        'result' => false,
                    ]);
            }

            if($check_siz_file)
            {
                return response()->json(
                    [
                        'message'=> ['File should not exceed 25mb.'],
                        'data'=> [
                            'attach_1' => $size_file1,
                            'attach_2' => $size_file2,
                            'attach_3' => $size_file3,
                            'attach_4' => $size_file4,
                        ],
                        'result' => false,
                    ]);
            }

            $sitename = $removeScript->scripttrim($getAcctList[0]->acct_name) . ' ' . $removeScript->scripttrim($getAcctList[0]->loc);

            $endorseId = DB::table('bi_endorsements')
                ->insertGetId
                ([
                    'bi_id' => $getAcctList[0]->bi_id,
                    'type_of_endorsement_bank' => 'BVR',
                    'bi_account_name' => $sitename,
                    'project' => $sitename,
                    'lob' => 'N/A',
                    'package' => '-',
                    'account_name' => $f_name . ', ' .$m_name . ' ' . $l_name,
                    'f_name' => $f_name,
                    'm_name' => $m_name,
                    'l_name' => $l_name,
                    'suffix' => '',
                    'gender' => '',
                    'marital_status' => '',
                    'birth_day' =>'',
                    'birth_month' => '',
                    'birth_year' => '',
                    'age' => '',
                    'citizenship' => '',
                    'maiden_name' => '',
                    'maiden_f_name' => '',
                    'maiden_m_name' => '',
                    'maiden_l_name' => '',
                    'present_address' => '',
                    'present_muni' =>'',
                    'present_province' => '',
                    'permanent_address' => '',
                    'permanent_muni' => '',
                    'permanent_province' => '',

                    'endorser_poc' => $requestor_name,
                    'status' => '0',
                    'created_at' => Carbon::now('Asia/Manila'),
                    'client_remarks_bank' => $remarks,
                    'cc_bank_endorsement_type' => $entry_as
                ]);

            DB::table('bi_endorsements_checkings')
                ->insert
                ([
                    'bi_endorsement_id' => $endorseId,
                    'checking_id' => '0',
                    'checking_name' => 'N/A',
                    'type_check' => 'N/A',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $user = User::find($user_id);

            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorseId;
            $endorse_user->users_id = $user_id;
            $endorse_user->position_id = $user->roles->first()->id;
            $endorse_user->save();

            $logs = new bi_log();
            $logs->endorse_id = $endorseId;
            $logs->user_id = $user_id;
            $logs->position_id = $user->roles->first()->id;
            $logs->activity = 'ENDORSED THE ACCOUNT(PDRN)';
            $logs->remarks = '-';
            $logs->save();

            $this->bi_upload_file($file1,$file2,$file3,$file4,$endorseId);

            return response()->json([
                    'message' => ['success'],
                    'result' => true,
                ]
            );
        }

    }
    //end bank tele

    //upload both tele and cc
    public function bi_upload_file($file1,$file2,$file3,$file4,$endorsement_id)
    {

        $ongoing_id = $endorsement_id;

        $endorse = new bi_endorsement();
        $endorse = $endorse::find($ongoing_id);

        $count = 1;
        if($file1 != null)
        {
            $file_name1 = $file1->getClientOriginalName();

            if($file_name1 == $endorse->attach_2)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $endorse->attach_3)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            if($file_name1 == $endorse->attach_4)
            {
                $count++;
                $file_name1 = explode('.',$file1->getClientOriginalName())[0].'('.$count.').'.$file1->getClientOriginalExtension();
            }

            $file1->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name1);

            $endorse->attach_1 = $file_name1;

        }

        if($file2 != null)
        {
            $file_name2 = $file2->getClientOriginalName();

            if($file_name2 == $endorse->attach_1)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $endorse->attach_3)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }

            if($file_name2 == $endorse->attach_4)
            {
                $count++;
                $file_name2 = explode('.',$file2->getClientOriginalName())[0].'('.$count.').'.$file2->getClientOriginalExtension();
            }


            $file2->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name2);

            $endorse->attach_2 = $file_name2;

        }

        if($file3 != null)
        {
            $file_name3 = $file3->getClientOriginalName();

            if($file_name3 == $endorse->attach_1)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $endorse->attach_2)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            if($file_name3 == $endorse->attach_4)
            {
                $count++;
                $file_name3 = explode('.',$file3->getClientOriginalName())[0].'('.$count.').'.$file3->getClientOriginalExtension();
            }

            $file3->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name3);

            $endorse->attach_3 = $file_name3;

        }

        if($file4 != null)
        {
            $file_name4 = $file4->getClientOriginalName();

            if($file_name4 == $endorse->attach_1)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $endorse->attach_2)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            if($file_name4 == $endorse->attach_4)
            {
                $count++;
                $file_name4 = explode('.',$file4->getClientOriginalName())[0].'('.$count.').'.$file4->getClientOriginalExtension();
            }

            $file4->move(storage_path('bi_attachments/'.$endorse->bi_id.'/'.$ongoing_id.'/'),$file_name4);

            $endorse->attach_4 = $file_name4;

        }

        $endorse->save();

    }

    //start cc tele
    public function cc_check_package_check_available(Request $request)
    {
        $request->validate([

//            'id' => 'required',
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ]);


        $get_details = DB::table('users')
            ->select('id')
            ->where('email', $request->email)
            ->where('client_check','!=','cc_bank')
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if (count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id) {
            return response()->json(
                [
                    'message' => ['Wrong Credentials'],
                    'data' => [
                        'email' => $request->email,
                        'secret_id' => $request->secret_id,
                        'api_key' => $request->api_key
                    ],
                    'result' => false
                ]);
        }

        $id = $get_details[0]->id;

        $get_account = DB::table('bi_account_to_users')
            ->leftjoin('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->leftjoin('package_to_account', 'package_to_account.bi_account_id', '=', 'bi_account_list.id')
            ->leftjoin('package_list', 'package_list.id', '=', 'package_to_account.package_id')
            ->leftjoin('checking_to_package', 'checking_to_package.package_to_account_id', '=', 'package_to_account.id')
            ->leftjoin('checking_list', 'checking_list.id', '=', 'checking_to_package.checking_id')
            ->select([
                'bi_account_list.bi_account_name as bi_account_name',
                'bi_account_list.id as bi_id',
                'bi_account_list.account_location as account_location',
                'package_list.package as package',
                'package_list.id as package_id',
                'checking_list.checking_name as checking',
                'checking_list.id as checking_id',
                'checking_list.information as information',
                'checking_list.ocular as ocular'
            ])
            ->where('bi_account_to_users.users_id', $id)
            ->where('bi_account_to_users.to_display', 'display')
            ->orderBy('checking_list.checking_name', 'asc')
            ->get();

        $get_other_package_check = DB::table('other_checking_list')
            ->leftjoin('bi_account_list', 'bi_account_list.id', '=', 'other_checking_list.bi_account_id')
            ->select(
                [
                    'other_checking_list.checking_name as other_check',
                    'other_checking_list.information as information',
                    'other_checking_list.ocular as ocular'
                ])
            ->where('bi_account_list.id', $get_account[0]->bi_id)
            ->get();


        $get_bi_account = $get_account[0]->bi_account_name;
        $get_bi_location = $get_account[0]->account_location;

        //get_checking and package and make it unique
        $get_package_array = array();
        $get_check_array = array();
        $get_other_check_array = array();

        //check and package
        foreach ($get_account as $accounts) {

            $package_check = false;
            $check_check = false;

            for ($ctr = 0; $ctr < count($get_package_array); $ctr++)
            {
                if ($accounts->package == $get_package_array[$ctr])
                {
                    $package_check = true;
                }
            }

            for ($i = 0; $i < count($get_check_array);$i++)
            {
                if ($accounts->checking == $get_check_array[$i])
                {
                    $check_check = true;
                }
            }

            if ($package_check == false)
            {
                array_push($get_package_array, $accounts->package);
            }

            if ($check_check == false)
            {
                array_push($get_check_array,$accounts->checking);
            }

        }

        //other checking
        foreach ($get_other_package_check as $other_check)
        {
            $other_check_check = false;

            for ($ctr = 0; $ctr < count($get_other_check_array); $ctr++)
            {
                if ($other_check->other_check == $get_other_check_array[$ctr])
                {
                    $other_check_check = true;
                }
            }

            if($other_check_check == false)
            {
                array_push($get_other_check_array,$other_check->other_check);
            }
        }

        return response()->json(
            [
                'message' => ['Success.'],
                'data' => [
                    'bi_account' => $get_bi_account,
                    'bi_location' => $get_bi_location,
                    'available_packages' => $get_package_array,
                    'available_checkings' => $get_check_array,
                    'available_other_checkings' => $get_other_check_array
                ],
                'result' => true
            ]
        );
    }

    public function cc_endorsement_get(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ], [
            'email.required' => 'Please indicate correct credential.',
            'secret_id.required' => 'Please indicate correct credential.',
            'api_key.required' => 'Please indicate correct credential.',
        ]);

        $get_details = DB::table('users')
            ->select('id','client_check')
            ->where('email', $request->email)
            ->where('client_check','!=','cc_bank' )
            ->where('api_token', hash('sha256', $request->api_key))
            ->get();


        if(count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id)
        {
            return response()->json(
                [
                    'message'=>['Wrong Credentials'],
                    'data'=> [
                        'email'=>$request->email,
                        'secret_id'=>$request->secret_id,
                        'api_key'=>$request->api_key
                    ],
                    'result' => false
                ]);
        }

        if($request->pagelength != null)
        {
            $length = $request->pagelength;
            $page_length_str = '&pagelength='.$length;
        }
        else
        {
            $length = 10;
            $page_length_str = '';
        }

        if(!is_numeric($length))
        {
            $length = 10;
        }

        if($request->search != null || $request->search != '')
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.f_name as f_name',
                    'bi_endorsements.m_name as m_name',
                    'bi_endorsements.l_name as l_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.client_remarks_bank as client_remark',
                    'bi_endorsements.cc_bank_endorsement_type as cc_bank_endorsement_type',
                    'bi_endorsements.endorser_poc as endorser_poc',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements.id')
                ->orderBy('bi_endorsements.id','desc')
                ->where('bi_endorsements.account_name','LIKE','%'.$request->search.'%')
                ->where('bi_account_to_users.users_id',$get_details[0]->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
                })
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'&search='.$request->search);
        }
        else
        {
            $get_general_table = DB::table('bi_endorsements')
                ->join('bi_endorsements_users','bi_endorsements_users.bi_endorse_id','=','bi_endorsements.id')
                ->join('bi_account_to_users','bi_account_to_users.bi_account_id','=','bi_endorsements.bi_id')
//                ->leftjoin('bi_endorsements_checkings','bi_endorsements_checkings.bi_endorsement_id','=','bi_endorsements.id')
                ->join('users', 'users.id', '=' , 'bi_endorsements_users.users_id')
                ->select([
//            \DB::raw('count(count.bi_endorsement_id) as count'),
                    'bi_endorsements.id as endorse_id',
                    'bi_endorsements.bi_account_name as site',
                    'bi_endorsements.created_at as date_time_endorsed',
                    'bi_endorsements.project as project',
                    'bi_endorsements.account_name as account_name',
                    'bi_endorsements.f_name as f_name',
                    'bi_endorsements.m_name as m_name',
                    'bi_endorsements.l_name as l_name',
                    'bi_endorsements.package as package',
//                    'bi_endorsements_checkings.checking_name as check',
                    'bi_endorsements.endorser_poc as poc',
                    'bi_endorsements.status as status',
                    'bi_endorsements.attach_1 as attach_1',
                    'bi_endorsements.attach_2 as attach_2',
                    'bi_endorsements.attach_3 as attach_3',
                    'bi_endorsements.attach_4 as attach_4',
                    'bi_endorsements.acct_report_status as status_report',
                    'bi_endorsements.date_time_due as due',
                    'bi_endorsements.type_of_endorsement_bank as tor',
                    'bi_endorsements.client_remarks_bank as client_remark',
                    'bi_endorsements.cc_bank_endorsement_type as cc_bank_endorsement_type',
                    'bi_endorsements.endorser_poc as endorser_poc',
                    'users.client_check',
                    'users.id'
                ])
                ->groupBy('bi_endorsements.id')
                ->orderBy('bi_endorsements.id','desc')
                ->where('bi_account_to_users.users_id',$get_details[0]->id)
                ->where('bi_endorsements_users.position_id', 14)
                ->where(function($query)
                {
                    return $query->where('bi_endorsements.type_of_endorsement_bank', '=', null)
                        ->orwhere('bi_endorsements.type_of_endorsement_bank', '=', '');
                })
                ->paginate($length);
//                ->withPath($request->root().'/api/endorsements?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'');
        }


        function get_attachment($data,$id,$req)
        {
            if ($data != '')
            {
                $encrypted_id = base64_encode(gzdeflate($id));
                $encrypted_file_name = base64_encode(gzdeflate($data));

                return [
                    'file_name' => $data,
                    'download_link' => $req->root().'/api/download_attachment_link?dl='.$encrypted_id.'&dll='.$encrypted_file_name.'&email='.$req->email.'&api_key='.$req->api_key.'&secret_id='.$req->secret_id
                ];
            }
            else
            {
                return 'no file attached.';
            }
        }

        function status_check($status,$id,$req)
        {

            if($status == 0)
            {
                return ['text'=>'New Endorsement'];
            }
            else if ($status == 20)
            {
                return ['text'=>'Returned Upon Endorsement'];
            }
            else if ($status == 22)
            {
                return ['text'=>'Returned During Endorsement'];
            }
            else if ($status == 23)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 24)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 25)
            {
                return ['text'=>'Returned After Endorsement'];
            }
            else if ($status == 5)
            {
                return ['text'=>'On-Hold Account'];
            }
            else if ($status == 4)
            {
                return ['text'=>'Cancelled Account'];
            }
            else if ($status == 21)
            {
                return ['text'=>'Re-Endorsed Account'];
            }
            else if ($status == 1)
            {
                return ['text'=>'Acknowledged'];
            }
            else if ($status == 10)
            {
                $encrypted_id = base64_encode(gzdeflate($id));
//                $encrypted_file_name = base64_encode(gzdeflate($data));
                return [
                    'text'=>'Complete/Success',
                    'download_link' => $req->root().'/api/download_success_attachment_link?dl='.$encrypted_id.'&email='.$req->email.'&api_key='.$req->api_key.'&secret_id='.$req->secret_id
                ];
            }
            else if ($status == 2)
            {
                return ['text'=>'Assigned'];
            }
            else if ($status == 3)
            {
                return ['text'=>'Successful Verification'];
            }
            else
            {
                return ['text'=>''];
            }
        }

        $get_linker = $request;

        $itemsTransformed = $get_general_table
            ->getCollection()
            ->map(function($item) use ($get_linker) {
                return [
                    'endorse_id' => $item->endorse_id,
//                    'location' => $item->site,
                    'date_time_endorsed' => $item->date_time_endorsed,
//                    'project' => $item->project,
                    'account_name' => $item->account_name,
                    'f_name' => $item->f_name,
                    'm_name' => $item->m_name,
                    'l_name' => $item->l_name,
                    'attach_1' => get_attachment($item->attach_1,$item->endorse_id,$get_linker),
                    'attach_2' => get_attachment($item->attach_2,$item->endorse_id,$get_linker),
                    'attach_3' => get_attachment($item->attach_3,$item->endorse_id,$get_linker),
                    'attach_4' => get_attachment($item->attach_4,$item->endorse_id,$get_linker),
                    'status' => status_check($item->status,$item->endorse_id,$get_linker),
                    'remarks' => $item->client_remark,
                    'entry_as' => $item->cc_bank_endorsement_type,
                    'requestor_name' => $item->endorser_poc,
                ];
            })->toArray();

        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $get_general_table->total(),
            $get_general_table->perPage(),
            $get_general_table->currentPage(), [
                'path' => \Request::url().'?email='.$request->email.'&secret_id='.$request->secret_id.'&api_key='.$request->api_key.$page_length_str.'&search='.$request->search,
                'query' => [
                    'page' => $get_general_table->currentPage()
                ]
            ]
        );

        return response()->json([
            'message' => ['success'],
            'endorsements' => $itemsTransformedAndPaginated,
            'result' => true
        ]);
    }

    public function cc_endorse_account(Request $request)
    {
        $request->validate([

//            'id' => 'required',
            'email' => 'required',
            'secret_id' => 'required',
            'api_key' => 'required'
        ]);


        $get_details = DB::table('users')
            ->join('bi_account_to_users','bi_account_to_users.users_id','=','users.id')
            ->join('bi_account_list','bi_account_list.id','=','bi_account_to_users.bi_account_id')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select([
                'users.id as id',
                'users.authrequest as auth_req',
                'bi_account_list.bi_account_name as bi_account_name',
                'bi_account_list.account_location as bi_location_name',
                'bi_account_to_users.bi_account_id as bi_id',
                'users.client_check as client_check',
                'role_user.role_id as role_id'
            ])
            ->where('users.email', $request->email)
            ->where('users.client_check', '!=', 'cc_bank')
            ->where('bi_account_to_users.to_display', 'display')
            ->where('users.api_token', hash('sha256', $request->api_key))
            ->get();


        if (count($get_details) == 0 || hash('sha256', $get_details[0]->id) != $request->secret_id) {
            return response()->json(
                [
                    'message' => ['Wrong Credentials'],
                    'data' => [
                        'email' => $request->email,
                        'secret_id' => $request->secret_id,
                        'api_key' => $request->api_key
                    ],
                    'result' => false
                ]);
        }


        if($get_details[0]->auth_req == 'direct_enc')
        {
            //for cnx

            $request->validate([
                'l_name' => 'required',
                'f_name' => 'required',
//                'm_name' => 'required',
                'b_day' => 'required',
                'b_month' => 'required',
                'b_year' => 'required',
//                'pres_address' => 'required',
//                'pres_city_muni' => 'required',
//                'pres_province' => 'required',
//                'perma_address' => 'required',
//                'perma_city_muni' => 'required',
//                'perma_province' => 'required',
//                'requestor_name' => 'required',
                'remarks' => 'required',
            ], [
//            'l_name.required' => 'Please indicate correct credential.',
//            'f_name.required' => 'Please indicate correct credential.',
//            'm_name.required' => 'Please indicate correct credential.',
                'b_day.required' => 'required input = DD (day : example: "01")',
                'b_month.required' => 'required input = MM (month : example: "03")',
                'b_year.required' => 'required input = YYYY (year : example: "1996")',
//            'pres_address.required' => 'Please indicate correct credential.',
//            'pres_city_muni.required' => 'Please indicate correct credential.',
//            'pres_province.required' => 'Please indicate correct credential.',
//            'perma_address.required' => 'Please indicate correct credential.',
//            'perma_city_muni.required' => 'Please indicate correct credential.',
//            'perma_province.required' => 'Please indicate correct credential.',
//            'requestor_name.required' => 'Please indicate correct credential.',
                'remarks.required' => 'Please indicate the package or checking you want to use for this endorsement. To check your available packages and checkings, please see: '.$request->root().'/api/fetch/cc/package_check?email='.$request->email.'&api_key='.$request->api_key.'&secret_id='.$request->secret_id,
            ]);
        }
        else
        {
            $request->validate([
                'l_name' => 'required',
                'f_name' => 'required',
                'm_name' => 'required',
                'b_day' => 'required',
                'b_month' => 'required',
                'b_year' => 'required',
                'pres_address' => 'required',
                'pres_city_muni' => 'required',
                'pres_province' => 'required',
                'perma_address' => 'required',
                'perma_city_muni' => 'required',
                'perma_province' => 'required',
                'requestor_name' => 'required',
                'remarks' => 'required',
            ], [
//            'l_name.required' => 'Please indicate correct credential.',
//            'f_name.required' => 'Please indicate correct credential.',
//            'm_name.required' => 'Please indicate correct credential.',
                'b_day.required' => 'required input = DD (day : example: "01")',
                'b_month.required' => 'required input = MM (month : example: "03")',
                'b_year.required' => 'required input = YYYY (year : example: "1996")',
//            'pres_address.required' => 'Please indicate correct credential.',
//            'pres_city_muni.required' => 'Please indicate correct credential.',
//            'pres_province.required' => 'Please indicate correct credential.',
//            'perma_address.required' => 'Please indicate correct credential.',
//            'perma_city_muni.required' => 'Please indicate correct credential.',
//            'perma_province.required' => 'Please indicate correct credential.',
//            'requestor_name.required' => 'Please indicate correct credential.',
                'remarks.required' => 'Please indicate the package or checking you want to use for this endorsement. To check your available packages and checkings, please see: '.$request->root().'/api/fetch/cc/package_check?email='.$request->email.'&api_key='.$request->api_key.'&secret_id='.$request->secret_id,
            ]);
        }





        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $checkSame = DB::table('bi_endorsements')
            ->where('bi_account_name', $get_details[0]->bi_account_name)
            ->where('bi_id', $get_details[0]->bi_id)
            ->where('f_name', $trimmer->trims($request->l_name))
            ->where('m_name', $trimmer->trims($request->m_name))
            ->where('l_name', $trimmer->trims($request->f_name))
            ->where('birth_day', $trimmer->trims($request->b_day))
            ->where('birth_month', $trimmer->trims($request->b_month))
            ->where('birth_year', $trimmer->trims($request->b_year))
            ->count();

        if ($checkSame > 0) {
            return response()->json(
                [
                    'message' => ['This account is already endorsed. Please try different account.'],
                    'result' => false,
                ]);

        } else {
            $bi_account = $get_details[0]->bi_account_name.' '.$get_details[0]->bi_location_name;
            $bi_id = $get_details[0]->bi_id;

            $bi_project_name = '-';
            $bi_account_lob = '-';
            $acct_citizenship = '-';
            $acct_maiden_last_name = '-';
            $acct_maiden_first_name = '-';
            $acct_maiden_middle_name = '-';
            $acct_suffix = '-';
            $tat_type = '-';
            $type_package = '-';

            $acct_last = $removeScript->scripttrim($request->l_name); //request
            $acct_first = $removeScript->scripttrim($request->f_name); //request
            $acct_middle = $removeScript->scripttrim($request->m_name); //request
            $acct_gender = $removeScript->scripttrim($request->gender); // request not required
            $acct_marital_status = $removeScript->scripttrim($request->marital_status); // request not required
            $acct_birthdate_day = $removeScript->scripttrim($request->b_day); //request
            $acct_birthdate_month = $removeScript->scripttrim($request->b_month); //request
            $acct_birthdate_year = $removeScript->scripttrim($request->b_year); //request

            $dateOfBirth = $acct_birthdate_day.'-'.$acct_birthdate_month.'-'.$acct_birthdate_year;

            if (!is_numeric($acct_birthdate_day) || !is_numeric($acct_birthdate_month) || !is_numeric($acct_birthdate_year)) {

                if(strlen($acct_birthdate_day) > 2 || strlen($acct_birthdate_month) > 2  || strlen($acct_birthdate_year) > 4)
                {
                    return response()->json(
                        [
                            'message' => ['Wrong Input'],
                            'data' => [
                                'b_day' => 'required input = DD (day : example: "01")',
                                'b_month' => 'required input = MM (month : example: "03")',
                                'b_year' => 'required input = YYYY (year : example: "1996")',
                            ],
                            'result' => false
                        ]);
                }
            }
            else
            {
                if(strlen($acct_birthdate_day) > 2 || strlen($acct_birthdate_month) > 2  || strlen($acct_birthdate_year) > 4)
                {
                    return response()->json(
                        [
                            'message' => ['Wrong Input'],
                            'data' => [
                                'b_day' => 'required input = DD (day : example: "01")',
                                'b_month' => 'required input = MM (month : example: "03")',
                                'b_year' => 'required input = YYYY (year : example: "1996")',
                            ],
                            'result' => false
                        ]);
                }
            }

            //explode the date to get month, day and year
            $birthDate = explode("-", $dateOfBirth);
            //get age from date or birthdate
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));

            $acct_birthdate_age = $removeScript->scripttrim($age); //auto compute

            function get_muni_id($muni)
            {
                $getStrMuni = Municipality::where('muni_name','like','%'.$muni.'%')
                    ->select('id','province_id','muni_name')
                    ->get();

                if(count($getStrMuni) == 0)
                {
                    return 'failed';
                }
                else
                {
                    return $getStrMuni[0]->id;
                }
            }

            function get_prov_id($prov)
            {
                $getProvID = Province::where('name','like','%'.$prov.'%')
                    ->select('id','name')
                    ->get();

                if(count($getProvID) == 0)
                {
                    return 'failed';
                }
                else
                {
                    return $getProvID[0]->id;
                }
            }

            $bi_present_address = $removeScript->scripttrim($request->pres_address); //request
            $bi_present_idMunicipality = get_muni_id($request->pres_city_muni); //request
            $bi_present_idProvince = get_prov_id($request->pres_province); //request

            $bi_permanent_address = $removeScript->scripttrim($request->perma_address); //request
            $bi_permanent_idMunicipality = get_muni_id($request->perma_city_muni); //request
            $bi_permanent_idProvince = get_prov_id($request->perma_province); //request

            if($bi_present_idMunicipality == 'failed' || $bi_present_idProvince == 'failed' || $bi_permanent_idMunicipality == 'failed' || $bi_permanent_idProvince == 'failed')
            {
                return response()->json(
                    [
                        'message' => ['Wrong Input'],
                        'data' => [
                            'pres_city_muni' => 'Input should be a valid city/municipality.',
                            'perma_city_muni' => 'Input should be a valid city/municipality.',
                            'pres_province' => 'Input should be a valid province.',
                            'perma_province' => 'Input should be a valid province.',
                        ],
                        'result' => false
                    ]);

            }

            $acct_endorsedby = $removeScript->scripttrim($request->requestor_name);//request
            $client_remarks_bank = $request->remarks; //request

            $file1 = $request->file('attach_1');
            $file2 = $request->file('attach_2');
            $file3 = $request->file('attach_3');
            $file4 = $request->file('attach_4');

            $check_siz_file = false;
            $count_file = 0;
            if($file1 != null)
            {
                $count_file += 1;
//                if($file1->getSize() > 500000)
                if($file1->getSize() > 26214400) //25mb
                {
                    $check_siz_file = true;
                    $size_file1 = $file1->getClientOriginalName().' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file1 = 'success';
                }
            }
            else
            {
                $size_file1 = 'no attached file';
            }

            if($file2 != null)
            {
                $count_file += 1;
                if ($file2->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file2 = $file2->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file2 = 'success';
                }
            }
            else
            {
                $size_file2 = 'no attached file';
            }

            if($file3 != null)
            {
                $count_file += 1;
                if ($file3->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file3 = $file3->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file3 = 'success';
                }
            }
            else
            {
                $size_file3 = 'no attached file';
            }

            if($file4 != null)
            {
                $count_file += 1;
                if ($file4->getSize() > 26214400)
                {
                    $check_siz_file = true;
                    $size_file4 = $file4->getClientOriginalName() . ' size is too big, maximum upload is 25mb';
                }
                else
                {
                    $size_file4 = 'success';
                }
            }
            else
            {
                $size_file4 = 'no attached file';
            }

            if($count_file == 0)
            {
                return response()->json(
                    [
                        'message' => [
                            'attach_1' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_2' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_3' => [
                                'Atleast (1)one attachment is required'
                            ],
                            'attach_4' => [
                                'Atleast (1)one attachment is required'
                            ]
                        ],
                        'result' => false,
                    ]);
            }

            if($check_siz_file)
            {
                return response()->json(
                    [
                        'message'=> ['File should not exceed 25mb.'],
                        'data'=> [
                            'attach_1' => $size_file1,
                            'attach_2' => $size_file2,
                            'attach_3' => $size_file3,
                            'attach_4' => $size_file4,
                        ],
                        'result' => false,
                    ]);
            }

            $endorse = new bi_endorsement();
            $endorse->bi_account_name = $trimmer->trims($bi_account);
            $endorse->bi_id = $bi_id;
            $endorse->project = $trimmer->trims($bi_project_name);
            $endorse->lob = $bi_account_lob;
            $endorse->package = $trimmer->trims($type_package);
            $endorse->account_name = $trimmer->trims($acct_last) . ', ' . $trimmer->trims($acct_first) . ' ' . $trimmer->trims($acct_middle);
            $endorse->f_name = $trimmer->trims($acct_first);
            $endorse->m_name = $trimmer->trims($acct_middle);
            $endorse->l_name = $trimmer->trims($acct_last);
            $endorse->suffix = $trimmer->trims($acct_suffix);
            $endorse->gender = $trimmer->trims($acct_gender);
            $endorse->marital_status = $trimmer->trims($acct_marital_status);
            $endorse->birth_day = $acct_birthdate_day;
            $endorse->birth_month = $acct_birthdate_month;
            $endorse->birth_year = $acct_birthdate_year;
            $endorse->age = $acct_birthdate_age;
            $endorse->citizenship = $trimmer->trims($acct_citizenship);
            $endorse->maiden_name = $trimmer->trims($acct_maiden_last_name) . ', ' . $trimmer->trims($acct_maiden_first_name) . ' ' . $trimmer->trims($acct_maiden_middle_name);
            $endorse->maiden_f_name = $trimmer->trims($acct_maiden_first_name);
            $endorse->maiden_m_name = $trimmer->trims($acct_maiden_middle_name);
            $endorse->maiden_l_name = $trimmer->trims($acct_maiden_last_name);
            $endorse->present_address = $trimmer->trims($bi_present_address);
            $endorse->present_muni = $bi_present_idMunicipality;
            $endorse->present_province = $bi_present_idProvince;
            $endorse->permanent_address = $trimmer->trims($bi_permanent_address);
            $endorse->permanent_muni = $bi_permanent_idMunicipality;
            $endorse->permanent_province = $bi_permanent_idProvince;
            $endorse->endorser_poc = $trimmer->trims($acct_endorsedby);
            $endorse->type_of_tat = $tat_type;
            $endorse->client_remarks_bank = $client_remarks_bank;
            $endorse->where_send = 'through_api';


//            $email = new EmailQueries();
//            $account4EmailName = $trimmer->trims($acct_last) . ', ' . $trimmer->trims($acct_first) . ' ' . $trimmer->trims($acct_middle);

//            $email->SendEndorsementNotifToSAO(Auth::user()->id, $account4EmailName);
            $endorse->status = '0';
            $endorse->save();

            $date_tamps = Carbon::now('Asia/Manila');

            DB::table('bi_endorsements_checkings')
                ->insert([
                    'bi_endorsement_id' => $endorse->id,
                    'checking_id' => 0,
                    'checking_name' => 'Not selected yet',
                    'type_check' => 'Not selected yet',
                    'created_at' => $date_tamps,
                    'updated_at' => $date_tamps
                ]);

            $user = $get_details[0]->id;
            $user_pos = $get_details[0]->role_id;

            $endorse_user = new bi_endorsements_user();
            $endorse_user->bi_endorse_id = $endorse->id;
            $endorse_user->users_id =$user;
            $endorse_user->position_id = $user_pos;
            $endorse_user->save();

            $logs = new bi_log();
            $logs->endorse_id = $endorse->id;
            $logs->user_id = $user;
            $logs->position_id = $user_pos;
            $logs->activity = 'ENDORSED THE ACCOUNT THROUGH API';
            $logs->remarks = $client_remarks_bank;
            $logs->save();


            $this->bi_upload_file($file1,$file2,$file3,$file4,$endorse->id);

            return response()->json(['message'=>['success'],'result'=>true]);
        }

    }
    //end cc tele
}
