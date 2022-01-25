<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 1/2/2018
 * Time: 2:58 PM
 */

namespace App\Generals;


use App\Http\Requests\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Generals\DownloadZipLogic;
use Swift_Mailer;
use Swift_SmtpTransport;

class EmailQueries
{

    public function sendEmail($request)
    {

        // EMAIL SYSTEM START HERE
//486 - isular
//423 - yulon
//411 - BPI
//388 - Ezloan
//345 - Client test
//356 - tfs manila
//812 - ctbc manila
//950 - Orico
//1006 - Cebuana
//1500 - Prestige Fame Finance


        $check_if_client = DB::table('user_client')
            ->where('user_id','=' ,Auth::user()->id)
            ->where(function ($query)
            {
                return $query->orwhere('user_branch',423)
                    ->orwhere('user_branch',486)
                    ->orwhere('user_branch',345)
                    ->orwhere('user_branch',411)
                    ->orwhere('user_branch',356)
                    ->orwhere('user_branch',812)
                    ->orwhere('user_branch',388)
                    ->orwhere('user_branch',1006)
                    ->orwhere('user_branch',950)
                    ->orwhere('user_branch',1500);
            })
            ->count();

        if($check_if_client > 0)
        {
            $trimmer = new Trimmer();
            $rem = ($trimmer->trims($request->txtClientRemarks));
            $timeStamp = Carbon::now('Asia/Manila');

//        $file = 'https://www.ccsi-oims.com/account_zip/10.zip';

            $toradd = '';
            $manytor = '';
            $cobs =  '';
            $cobs_adds = '';
            if($request->requestType == 'BVR')
            {
                for ($b = 0; $b <= count($request->busInfo) - 1; $b++){

                    $munifetcher = DB::table('municipalities')
                        ->where('id',$request->busInfo[$b][2])
                        ->select('muni_name')
                        ->get();

                    $manytor .= ' ('.($b+1).')'.$trimmer->trims($request->busInfo[$b][0]);
                    $toradd .= '('.($b+1).')'.$request->busInfo[$b][1].', '.$munifetcher[0]->muni_name.', '.$request->busInfo[$b][3].' ';
                }

                $tor = $request->requestType.'(Business/s:'.$manytor.')';
            }
            else if($request->requestType == 'EVR')
            {
                for ($b = 0; $b <= count($request->empInfo) - 1; $b++)
                {
                    $munifetcher = DB::table('municipalities')
                        ->where('id',$request->empInfo[$b][2])
                        ->select('muni_name')
                        ->get();


                    $manytor .=' ('.($b+1).')'. $trimmer->trims($request->empInfo[$b][0]);
                    $toradd .='('.($b+1).')'. $request->empInfo[$b][1].', '.$munifetcher[0]->muni_name.', '.$request->empInfo[$b][3].' ';
                }
                $tor = $request->requestType.'(Employer/s:'.$manytor.')';
            }
            else
            {
                $munifetcher = DB::table('municipalities')
                    ->where('id',$request->municipality)
                    ->select('muni_name')
                    ->get();

                $tor = $request->requestType;
                $toradd = $request->address.' '.$munifetcher[0]->muni_name.' '.$request->provinceName;

                for($b=0;$b<=$request->countcoob-1;$b++)
                {
                    $cobs .=' / '.$trimmer->trims($request->coborInfo[$b][0]);

                    $cobs_adds .=' / '.$trimmer->trims($request->coborInfo[$b][1]).','.$trimmer->trims($request->coborInfo[$b][2]).','.$request->coborInfo[$b][3];
                }
            }

            $getemailstosend = DB::table('emails_to_send')
                ->join('users','users.id','=','emails_to_send.user_id')
                ->select('users.email as email')
                ->where('emails_to_send.email_for','ClientNotif')
                ->where('users.archive', '=', 'False')
                ->where('emails_to_send.client_id','=' , Auth::user()->id)
                ->get();

            $arraycont_email = [];
            $count_email = 0;

            foreach($getemailstosend as $getemails)
            {
                array_push($arraycont_email, $getemails->email);

            }

            $data = array
            (
                'dateTimeEndorse'=> $timeStamp,
                'acctName'=>  $trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName).$cobs,
                'coborName'=>$request->coborFName.' '.$request->coborMName.' '.$request->coborLName,
                'address'=> $trimmer->trims($toradd).$cobs_adds,
                'nameOfRequestor'=>$request->requestorName,
                'typeOfLoan'=>$request->loanType,
                'typeOfRequest'=>$tor,
                'remarks' => $rem
            );


//        // Backup your default mailer
//        $backup = Mail::getSwiftMailer();
//
//        // Setup your gmail mailer
//        $transport = (new Swift_SmtpTransport('mail.ccsi-oims.net', 465, 'ssl'));
//        $transport->setUsername('notification@ccsi-oims.net');
//        $transport->setPassword('w=Rqc=dv#yF,');
//        // Any other mailer configuration stuff needed...
//        //ccsi.notification3@gmail.com
//        //ccsipassword20181
//        $gmail = new Swift_Mailer($transport);

            // Set the mailer as gmail
//        Mail::setSwiftMailer($gmail);

            // Send your message
            Mail::send('mail', $data, function($message) use ($arraycont_email) {
                $message
                    ->to($arraycont_email, 'CCSI SAO and DISPATCHER')
                    ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsiranyll.puntanar@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                    ->subject(Auth::user()->name.' Endorsement List to C.C.S.I');

                $message
                    ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
            });
        }

    }

    public function sendEmail_for_admin($request)
    {
        $trimmer = new Trimmer();
        $rem = ($trimmer->trims($request->txtClientRemarks));

        $timeStamp = Carbon::now('Asia/Manila');

//        $file = 'https://www.ccsi-oims.com/account_zip/10.zip';

        $toradd = '';
        $manytor = '';
        $cobs =  '';
        $cobs_adds = '';
        if($request->requestType == 'BVR')
        {
            for ($b = 0; $b <= count($request->busInfo) - 1; $b++){

                $munifetcher = DB::table('municipalities')
                    ->where('id',$request->busInfo[$b][2])
                    ->select('muni_name')
                    ->get();

                $manytor .= ' ('.($b+1).')'.$trimmer->trims($request->busInfo[$b][0]);
                $toradd .= '('.($b+1).')'.$request->busInfo[$b][1].', '.$munifetcher[0]->muni_name.', '.$request->busInfo[$b][3].' ';
            }

            $tor = $request->requestType.'(Business/s:'.$manytor.')';
        }
        else if($request->requestType == 'EVR')
        {
            for ($b = 0; $b <= count($request->empInfo) - 1; $b++)
            {
                $munifetcher = DB::table('municipalities')
                    ->where('id',$request->empInfo[$b][2])
                    ->select('muni_name')
                    ->get();


                $manytor .=' ('.($b+1).')'. $trimmer->trims($request->empInfo[$b][0]);
                $toradd .='('.($b+1).')'. $request->empInfo[$b][1].', '.$munifetcher[0]->muni_name.', '.$request->empInfo[$b][3].' ';
            }
            $tor = $request->requestType.'(Employer/s:'.$manytor.')';
        }
        else
        {
            $munifetcher = DB::table('municipalities')
                ->where('id',$request->municipality)
                ->select('muni_name')
                ->get();


            $tor = $request->requestType;
            $toradd = $request->address.' '.$munifetcher[0]->muni_name.' '.$request->provinceName;

            for($b=0;$b<=$request->countcoob-1;$b++)
            {
                $cobs .=' / '.$trimmer->trims($request->coborInfo[$b][0]);

                $cobs_adds .=' / '.$trimmer->trims($request->coborInfo[$b][1]).','.$trimmer->trims($request->coborInfo[$b][2]).','.$request->coborInfo[$b][3];
            }
        }


//        $getemailstosend = DB::table('emails_to_send')
//            ->join('users','users.id','=','emails_to_send.user_id')
//            ->select('users.email as email')
//            ->where('email_for','ClientNotif')
//            ->get();
//
//        $arraycont_email = [];
//        $count_email = 0;
//        foreach($getemailstosend as $getemails)
//        {
//            $arraycont_email[$count_email] = $getemails->email;
//
//            $count_email++;
//        }

        $data = array
        (
            'dateTimeEndorse'=> $timeStamp,
            'acctName'=>  $trimmer->trims($request->acctFName.' '.$request->acctMName.' '.$request->acctLName).$cobs,
            'coborName'=>$request->coborFName.' '.$request->coborMName.' '.$request->coborLName,
            'address'=> $trimmer->trims($toradd).$cobs_adds,
            'nameOfRequestor'=>$request->requestorName,
            'typeOfLoan'=>$request->loanType,
            'typeOfRequest'=>$tor,
            'remarks' => $rem
        );


//        // Backup your default mailer
//        $backup = Mail::getSwiftMailer();
//
//        // Setup your gmail mailer
//        $transport = (new Swift_SmtpTransport('mail.ccsi-oims.net', 465, 'ssl'));
//        $transport->setUsername('notification@ccsi-oims.net');
//        $transport->setPassword('w=Rqc=dv#yF,');
//        // Any other mailer configuration stuff needed...
//
//        $gmail = new Swift_Mailer($transport);
//
//        // Set the mailer as gmail
//        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('mail', $data, function($message) {
            $message
                ->to(['ccsijf.apungan@gmail.com'], 'CCSI SAO and DISPATCHER')
                ->bcc(['oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject(Auth::user()->name.' Endorsement List to C.C.S.I');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
//
//        // Restore your original mailer
//        Mail::setSwiftMailer($backup);


    }

    public function marketingLogsEmail($request)
    {
        $getbulkmuni =  DB::table('municipalities')
            ->where('id', $request->rateMuni)
            ->get();

        $getbulkprov =  DB::table('provinces')
            ->where('id', $request->rateProv)
            ->get();

        $getAccountName = DB::table('users')
            ->where('id', $request->bankID)
            ->get();

        $data = array
        (
            'datenow'=> Carbon::now('Asia/Manila'),
            'Activity'=>'INSTERTED RATE',
            'acctName'=> Auth::user()->name,
            'BankName'=>$getAccountName[0]->name,
            'Province'=>$getbulkprov[0]->name,
            'Municipality'=>$getbulkmuni[0]->muni_name,
            'Rate'=>$request->rateBank,

        );

        Mail::send('mailMarketingBulk', $data, function($message)
        {
            $message
                ->to('oims.notifications@gmail.com', 'Management')
                ->cc(['ccsijf.apungan@gmail.com', 'ccsiranyll.puntanar@gmail.com', 'ccsijl.escoto@gmail.com', 'ccsirommel.rinos@gmail.com'], 'Administrator')
                ->subject('Marketing Logs');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
    }

    public function marketingLogsEmailBulk($request)
    {
        $getbulkprov =  DB::table('provinces')
            ->where('id', $request->provID)
            ->get();

        $getAccountName = DB::table('users')
            ->where('id', $request->bankID)
            ->get();
        $data = array
        (
            'datenow'=> Carbon::now('Asia/Manila'),
            'Activity'=>'INSERTED RATE',
            'acctName'=> Auth::user()->name,
            'BankName'=>$getAccountName[0]->name,
            'Province'=>$getbulkprov[0]->name,
            'Municipality'=>'All municipality in ('.$getbulkprov[0]->name.').',
            'Rate'=>$request->bulkRate,
        );

        Mail::send('mailMarketingBulk', $data, function($message)
        {
            $message
                ->to('oims.notifications@gmail.com', 'Management')
                ->cc(['ccsijf.apungan@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject('Marketing Logs');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
    }

    public function marketingLogsEmailUpdate($request)
    {
        $getmuni =  DB::table('rates')
            ->join('municipalities', 'municipalities.id', '=' , 'rates.municipality_id')
            ->join('provinces', 'provinces.id', '=' , 'rates.province_id')
            ->join('users', 'users.id', '=' , 'rates.user_id')
            ->where('rates.id', $request->id)
            ->select('rates.rate as FromRate', 'users.name as AcctName', 'municipalities.muni_name as Municipality', 'provinces.name as Province')
            ->get();

        $data = array
        (
            'datenow'=> Carbon::now('Asia/Manila'),
            'Activity'=>'UPDATE RATE',
            'acctName'=> Auth::user()->name,
            'BankName'=>$getmuni[0]->AcctName,
            'Province'=>$getmuni[0]->Province,
            'Municipality'=>$getmuni[0]->Municipality,
            'FromRate'=>$request->before,
            'Rate'=>$request->newrate,

        );

        Mail::send('mailMarketingUpdate', $data, function($message)
        {
            $message
                ->to('oims.notifications@gmail.com', 'Management')
                ->cc(['ccsijf.apungan@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject('Marketing Logs');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });

    }

    public function ClientIssueReport($request)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.requestor_name',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsements.id',$request->id)
            ->get();

        $data = array
        (
            'datenow'=> Carbon::now('Asia/Manila'),
            'title'=>$request->gettitle,
            'messages'=> $request->getmessage,
            'id'=>$getAccount[0]->id,
            'date_endorsed'=>$getAccount[0]->date_endorsed,
            'time_endorsed'=>$getAccount[0]->time_endorsed,
            're_ci'=>$getAccount[0]->re_ci,
            'account_name'=>$getAccount[0]->account_name,
            'type_of_request'=>$getAccount[0]->type_of_request,
            'muni_name'=>$getAccount[0]->muni_name,
            'name'=>$getAccount[0]->name,
            'address'=>$getAccount[0]->address,
            'client_remarks'=>$getAccount[0]->client_remarks,
            'provinces'=>$getAccount[0]->provinces,
            'acct_status'=>$getAccount[0]->acct_status,
            'nonotes'=>$getAccount[0]->nonotes,
            'endorsement_status_external'=>$getAccount[0]->endorsement_status_external,
            'endorsement_status_internal'=>$getAccount[0]->endorsement_status_internal,

        );

        Mail::send('EmailClientReportIssue', $data, function($message)
        {
            $message
                ->to('ccsiranyll.puntanar@gmail.com', 'Tutorials Point')
                ->cc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject('Client Report : '.Auth::user()->name);

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });

    }

    public function SaoAssignToAo($request)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.requestor_name',
                    'endorsements.assigned_by_srao',
                    'endorsements.handled_by_account_officer',
                    'endorsements.type_of_loan',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsements.id',$request->accountID)
            ->get();


        $get_emails = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->aoID)
            ->where('email_for','SraoAo')
            ->get();

        $email_to = '';

        if(count($get_emails) != 0)
        {
            $email_to = $get_emails[0]->email;
        }
        else
        {
            $email_to = 'no_email@ccsi.com';
        }

        $data = array
        (
            'saoname'=>$getAccount[0]->assigned_by_srao,
            'aoname'=>$getAccount[0]->handled_by_account_officer,
            'datenow'=> Carbon::now('Asia/Manila'),
            'date_endorsed'=>$getAccount[0]->date_endorsed,
            'time_endorsed'=>$getAccount[0]->time_endorsed,
            'id'=>$getAccount[0]->id,
            'account_name'=>$getAccount[0]->account_name,
            'address'=>$getAccount[0]->address,
            'muni_name'=>$getAccount[0]->muni_name,
            'provinces'=>$getAccount[0]->provinces,
            'requestor_name'=>$getAccount[0]->requestor_name,
            'type_of_loan'=>$getAccount[0]->type_of_loan,
            'type_of_request'=>$getAccount[0]->type_of_request,
            're_ci'=>$getAccount[0]->re_ci,
            'client_remarks'=>$getAccount[0]->client_remarks,
        );

//        Mail::send('AssignNotificationAO', $data, function($message) use ($getAccount, $email_to) {
//            $message
//                ->to($email_to, $getAccount[0]->handled_by_account_officer)
//                ->cc(['ccsijf.apungan@gmail.com','ccsijp.remobatac@gmail.com'], 'Administrator')
//                ->subject('Assign By SAO : '.Auth::user()->name);
//
//            $message
//                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
//        });


        // Backup your default mailer
        $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'));
        $transport->setUsername('ccsi.notification2@gmail.com');
        $transport->setPassword('ccsipassword2018');
        // Any other mailer configuration stuff needed...

        $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('AssignNotificationAO', $data, function($message) use ($getAccount, $email_to) {
            $message
                ->to($email_to, $getAccount[0]->handled_by_account_officer)
                ->cc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject('Assign By SAO : '.Auth::user()->name);

            $message
                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
        });


        // Restore your original mailer
        Mail::setSwiftMailer($backup);



    }

    public function SaoTransferToAo($request,$from,$to)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.requestor_name',
                    'endorsements.assigned_by_srao',
                    'endorsements.handled_by_account_officer',
                    'endorsements.type_of_loan',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();


        $get_emails_transfer = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->aoIDToTransfer)
            ->where('email_for','SraoAo')
            ->get();

        $get_emails = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->aoID)
            ->where('email_for','SraoAo')
            ->get();


        $email_to = '';

        if(count($get_emails) != 0)
        {
            $email_to = $get_emails[0]->email;
        }
        else
        {
            $email_to = 'no_email@ccsi.com';
        }

        $email_to_transfer = '';

        if(count($get_emails_transfer) != 0)
        {
            $email_to_transfer = $get_emails_transfer[0]->email;
        }
        else
        {
            $email_to_transfer = 'no_email@ccsi.com';
        }


        $data = array
        (
            'saoname'=>$getAccount[0]->assigned_by_srao,
            'from_aoname'=>$from,
            'to_aoname'=>$to,
            'datenow'=> Carbon::now('Asia/Manila'),
            'date_endorsed'=>$getAccount[0]->date_endorsed,
            'time_endorsed'=>$getAccount[0]->time_endorsed,
            'id'=>$getAccount[0]->id,
            'account_name'=>$getAccount[0]->account_name,
            'address'=>$getAccount[0]->address,
            'muni_name'=>$getAccount[0]->muni_name,
            'provinces'=>$getAccount[0]->provinces,
            'requestor_name'=>$getAccount[0]->requestor_name,
            'type_of_loan'=>$getAccount[0]->type_of_loan,
            'type_of_request'=>$getAccount[0]->type_of_request,
            're_ci'=>$getAccount[0]->re_ci,
            'client_remarks'=>$getAccount[0]->client_remarks,
        );


//        Mail::send('SAOtransferNotificationAO', $data, function($message) use ($email_to_transfer, $getAccount, $email_to) {
//            $message
//                ->to([$email_to,$email_to_transfer], $getAccount[0]->handled_by_account_officer)
//                ->cc(['ccsijf.apungan@gmail.com','ccsijp.remobatac@gmail.com'], 'Administrator')
//                ->subject('Transferred Account : '.Auth::user()->name);
//
//            $message
//                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
//        });

        // Backup your default mailer
        $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'));
        $transport->setUsername('ccsi.notification2@gmail.com');
        $transport->setPassword('ccsipassword2018');
        // Any other mailer configuration stuff needed...

        $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('SAOtransferNotificationAO', $data, function($message) use ($email_to_transfer, $getAccount, $email_to) {
            $message
                ->to([$email_to,$email_to_transfer], $getAccount[0]->handled_by_account_officer)
                ->cc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject('Transferred Account : '.Auth::user()->name);

            $message
                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
        });


        // Restore your original mailer
        Mail::setSwiftMailer($backup);

    }

    public function DispatcherDispatchedToCI($request)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.requestor_name',
                    'endorsements.handled_by_dispatcher',
                    'endorsements.handled_by_credit_investigator',
                    'endorsements.type_of_loan',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsements.id',$request->accountID)
            ->get();


        $get_emails = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->ciID)
            ->where('email_for','DispatcherCI')
            ->get();

        $email_to = '';

        if(count($get_emails) != 0)
        {
            $email_to = $get_emails[0]->email;
        }
        else
        {
            $email_to = 'no_email@ccsi.com';
        }

        $data = array
        (
            'dispa_name'=>$getAccount[0]->handled_by_dispatcher,
            'ci_name'=>$getAccount[0]->handled_by_credit_investigator,
            'datenow'=> Carbon::now('Asia/Manila'),
            'date_endorsed'=>$getAccount[0]->date_endorsed,
            'time_endorsed'=>$getAccount[0]->time_endorsed,
            'id'=>$getAccount[0]->id,
            'account_name'=>$getAccount[0]->account_name,
            'address'=>$getAccount[0]->address,
            'muni_name'=>$getAccount[0]->muni_name,
            'provinces'=>$getAccount[0]->provinces,
            'requestor_name'=>$getAccount[0]->requestor_name,
            'type_of_loan'=>$getAccount[0]->type_of_loan,
            'type_of_request'=>$getAccount[0]->type_of_request,
            're_ci'=>$getAccount[0]->re_ci,
            'client_remarks'=>$getAccount[0]->client_remarks,
        );

//        Mail::send('DispatchNotificationCI', $data, function($message) use ($getAccount, $email_to) {
//            $message
//                ->to($email_to, $getAccount[0]->handled_by_credit_investigator)
//                ->cc(['ccsijf.apungan@gmail.com','ccsijp.remobatac@gmail.com'], 'Administrator')
//                ->subject('Dispatched By Dispatcher : '.Auth::user()->name);
//
//            $message
//                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
//        });

        // Backup your default mailer
        $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'));
        $transport->setUsername('ccsi.notification2@gmail.com');
        $transport->setPassword('ccsipassword2018');
        // Any other mailer configuration stuff needed...

        $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('DispatchNotificationCI', $data, function($message) use ($getAccount, $email_to) {
            $message
                ->to($email_to, $getAccount[0]->handled_by_credit_investigator)
                ->cc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com'], 'Administrator')
                ->subject('Dispatched By Dispatcher : '.Auth::user()->name);

            $message
                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
        });


        // Restore your original mailer
        Mail::setSwiftMailer($backup);


    }

    public function DispatcherTransferredToCI($request,$from,$to)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->leftjoin('notes','notes.endorsement_id','=','endorsement_user.endorsement_id')
            ->select
            (
                [
                    'endorsements.id',
                    'endorsements.date_endorsed',
                    'endorsements.time_endorsed',
                    'endorsements.date_due',
                    'endorsements.time_due',
                    'endorsements.re_ci',
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'endorsements.requestor_name',
                    'endorsements.handled_by_dispatcher',
                    'endorsements.handled_by_credit_investigator',
                    'endorsements.type_of_loan',

                    'municipalities.muni_name as muni_name',
                    'provinces.name',

                    'endorsements.address',
                    'endorsements.client_remarks',
                    'endorsements.provinces',
                    'endorsements.acct_status',
                    'notes.endorsement_note as nonotes',
                    'endorsement_status_external',
                    'endorsement_status_internal'
                ]
            )
            ->where('endorsements.id',$request->acctID)
            ->get();


        $get_emails_transfer = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->ciIDToTransfer)
            ->where('email_for','DispatcherCI')
            ->get();

        $get_emails = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('users.id',$request->ciID)
            ->where('email_for','DispatcherCI')
            ->get();


        $email_to = '';

        if(count($get_emails) != 0)
        {
            $email_to = $get_emails[0]->email;
        }
        else
        {
            $email_to = 'no_email@ccsi.com';
        }

        $email_to_transfer = '';

        if(count($get_emails_transfer) != 0)
        {
            $email_to_transfer = $get_emails_transfer[0]->email;
        }
        else
        {
            $email_to_transfer = 'no_email@ccsi.com';
        }

        $data = array
        (
            'dispa_name'=>$getAccount[0]->handled_by_dispatcher,
            'from_ci_name'=>$from,
            'to_ci_name'=>$to,
            'datenow'=> Carbon::now('Asia/Manila'),
            'date_endorsed'=>$getAccount[0]->date_endorsed,
            'time_endorsed'=>$getAccount[0]->time_endorsed,
            'id'=>$getAccount[0]->id,
            'account_name'=>$getAccount[0]->account_name,
            'address'=>$getAccount[0]->address,
            'muni_name'=>$getAccount[0]->muni_name,
            'provinces'=>$getAccount[0]->provinces,
            'requestor_name'=>$getAccount[0]->requestor_name,
            'type_of_loan'=>$getAccount[0]->type_of_loan,
            'type_of_request'=>$getAccount[0]->type_of_request,
            're_ci'=>$getAccount[0]->re_ci,
            'client_remarks'=>$getAccount[0]->client_remarks,
        );

//        Mail::send('DISPATCHERtransferNotificationCI', $data, function($message) use ($email_to_transfer, $getAccount, $email_to) {
//            $message
//                ->to([$email_to,$email_to_transfer], $getAccount[0]->handled_by_credit_investigator)
//                ->cc(['ccsijf.apungan@gmail.com','ccsijp.remobatac@gmail.com'], 'Administrator')
//                ->subject('Transferred Account : '.Auth::user()->name);
//
//            $message
//                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
//        });


        // Backup your default mailer
        $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'));
        $transport->setUsername('ccsi.notification2@gmail.com');
        $transport->setPassword('ccsipassword2018');
        // Any other mailer configuration stuff needed...

        $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('DISPATCHERtransferNotificationCI', $data, function($message) use ($email_to_transfer, $getAccount, $email_to) {
            $message
                ->to([$email_to,$email_to_transfer], $getAccount[0]->handled_by_credit_investigator)
                ->cc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com'], 'Administrator')
                ->subject('Transferred Account : '.Auth::user()->name);

            $message
                ->from('xyz@gmail.com','Comprehensive Credit Services Inc.');
        });

        // Restore your original mailer
        Mail::setSwiftMailer($backup);

    }

    public function AOSendReport($request,$subject,$to,$cc,$remarks)
    {
        $getAccount =  DB::table('endorsement_user')
            ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->join('provinces','provinces.id','=','municipalities.province_id')
            ->join('users','users.id','=','endorsement_user.user_id')
            ->select
            (
                [
                    'endorsements.account_name',
                    'endorsements.type_of_request',
                    'municipalities.muni_name as muni_name',
                    'endorsements.address',
                    'endorsements.provinces',
                    'endorsements.dl_link',
                    'endorsements.down_email_key',
//                    'endorsements.remarks as remarksq',
                    'users.name',
                    'endorsement_user.position_id',
                    'users.email',

                ]
            )
            ->where('endorsements.id',$request)
            ->where(function ($query)
            {
                return $query->where('endorsement_user.position_id',3)
                    ->orwhere('endorsement_user.position_id',7)
                    ->orwhere('endorsement_user.position_id',6);

            })
            ->get();


        $getao = '';
        $getao_email = '';
        $getsao = '';
        $getsao_email = '';

        $get_account_name = '';
        $get_address = '';
        $get_tor = '';

        $client_email = '';
//        $subject_send = $request->subject;

//        $to = explode(', ',$request->to);
//        $cc = explode(', ',$request->cc);


        $date_time = Carbon::now('Asia/Manila');

        foreach ($getAccount as $get)
        {
            if($get->position_id == 3)
            {
                $getao = $get->name;
                $getao_email = $get->email;;
            }
            else if($get->position_id == 7)
            {
                $getsao = $get->name;
                $getsao_email = $get->email;;
            }
            else if($get->position_id == 6)
            {
                $client_email = $get->email;;
            }
            $get_account_name = $get->account_name;
            $get_address = $get->address.', '.strtoupper($get->muni_name).', '.$get->provinces;
            $get_tor = $get->type_of_request;
            $filepath = $get->dl_link;
            $dmk = $get->down_email_key;
        }

//        $file = 'https://www.ccsi-oims.com/account_zip/10.zip';
//        $file = 'https://www.ccsi-oims.com/account_zip/'.$filepath.'.zip';

        $file = $filepath.'&dmk='.$dmk;

//        if($subject_send == '')
//        {
            $subject_send = $subject;
            $remarks_to_email = $remarks;

//        }
//        else
//        {
//            $subject_send = 'CCSI OIMS - '.$subject_send;
//        }

        $user = User::find(Auth::user()->id);
//        Auth::login($user);
        if($user->roles->first()->name != 'Credit Investigator')
        {
            $data = array
            (
                'account_name'  =>  $get_account_name,
                'tor'           =>  $get_tor,
                'address'       =>  $get_address,
                'date_time'     =>  $date_time,
                'name_ao'       =>  $getao,
                'email_ao'      =>  $getao_email,
                'name_sao'      =>  $getsao,
                'email_sao'     =>  $getsao_email,
                'filepath'      =>  $file,
                'remarks'       =>  $remarks_to_email,
                'name_ci'       => 'NONE'
            );

            Mail::send('SendReportToClient', $data, function($message) use ($cc, $to, $client_email, $subject_send, $date_time, $get_tor, $get_account_name) {
                $message
                    ->to($to, 'CCSI OIMS REPORT')
                    ->cc($cc, 'Carbon Copy')
                    ->bcc(['ccsijf.apungan@gmail.com','oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
//                    ->bcc(['ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
                    //                ->subject('REPORT OF: ('.$get_account_name.')'.'/('.$get_tor.')'.'/('.$date_time.')');
                    ->subject($subject_send);

                $message
                    ->from('notification@ccsi-oims.net','OIMS Finish Account Notification');
            });
        }
        else
        {
            $file = $filepath.'&dmk='.$dmk;
            $ciCC = [];
            $ciEmail = Auth::user()->email;
            $ciTo = [];
            $getCC = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=','users.id')
                ->where(function($query)
                {
                    return $query->orwhere('role_user.role_id', 18)
                        ->orwhere('role_user.role_id', 7)
                        ->orwhere('role_user.role_id', 5);
                })
                ->where('users.archive', '!=', 'True')
                ->select([
                    'users.email'
                ])
                ->get();

            foreach ($getCC as $cc2)
            {
                array_push($ciCC, $cc2->email);
            }

            $dmk = $getAccount[0]->down_email_key;

            array_push($ciCC, $ciEmail);

            $getInfo = DB::table('endorsement_user')
                ->join('users', 'users.id', '=', 'endorsement_user.user_id')
                ->join('endorsements', 'endorsements.id', '=', 'endorsement_user.endorsement_id')
                ->where('endorsement_user.position_id', 6)
                ->where('endorsement_user.endorsement_id', $request)
                ->select([
                    'users.email'
                ])
                ->get();

            foreach ($getInfo as $to2)
            {
                array_push($ciTo, $to2->email);
            }

            $data = array
            (
                'account_name'  =>  $get_account_name,
                'tor'           =>  $get_tor,
                'address'       =>  $get_address,
                'date_time'     =>  $date_time,
                'name_ao'       =>  $getao,
                'email_ao'      =>  $getao_email,
                'name_sao'      =>  $getsao,
                'email_sao'     =>  $getsao_email,
                'filepath'      =>  $file,
                'remarks'       =>  $remarks_to_email,
                'name_ci'       => Auth::user()->name
            );

            Mail::send('SendReportToClient', $data, function($message) use ($ciEmail, $ciCC, $ciTo, $client_email, $subject_send, $date_time, $get_tor, $get_account_name) {
                $message
//                    ->to($ciTo, 'CCSI OIMS REPORT')
                    ->to($ciEmail, 'CCSI OIMS REPORT')
                    ->cc($ciCC, 'Carbon Copy')
//                    ->cc($ciEmail, 'Carbon Copy')
                    ->bcc(['ccsijf.apungan@gmail.com','oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com', 'ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
//                    ->bcc(['ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
                ->subject('CCSI OIMS - REPORT OF: ('.$get_account_name.')'.'/('.$get_tor.')'.'/('.$date_time.')');
//                    ->subject($subject_send);

                $message
                    ->from('notification@ccsi-oims.net','OIMS Finish Account Notification');
            });
        }

    }

//    public function Marketing_Send_Email_Birthday($request)
//    {
//
//        $timeStamp = Carbon::now('Asia/Manila');
//        $splitDateTime = explode(" ", $timeStamp);
//        $date = $splitDateTime[0];
//        $time = $splitDateTime[1];
//
//        $count = $request->count_them;
//
//        for($ctr = 0; $ctr<$count; $ctr++)
//        {
//            $get_id = $request->id[$ctr];
//
//            DB::table('client_birthdays')
//                ->where('id',$get_id)
//                ->update([
//                    'date_updated' => $date
//                ]);
//        }
//
//        $data = array
//        (
//            'id' => $request->id,
//            'client_name' => $request->client_name,
//            'birthdate' => $request->birthdate,
//            'days_remaining' => $request->days_remaining,
//            'contact_num' => $request->contact_num,
//            'email_add' => $request->email_add,
//            'client_position' => $request->client_position,
//            'gift_type' => $request->gift_type,
//            'bank_name' => $request->bank_name,
//            'count' => $count
//
//        );
//
//        // Send your message
//        Mail::send('Marketing_Bday_Notification', $data, function($message){
//            $message
//                ->to(['arnel.montero@ccsi.com.ph','marketing.assistant@ccsi.com','shanice.senador@ccsi.ph'], 'Marketing Manager')
////                ->cc('email', 'Carbon Copy')
//                ->bcc(['ccsijf.apungan@gmail.com','ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
//                ->subject('OIMS CLIENT BIRTHDAY NOTIFICATION');
//
//            $message
//                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
//        });
//    }
//
//    public function Marketing_Send_Email_Contract($request)
//    {
//        $timeStamp = Carbon::now('Asia/Manila');
//        $splitDateTime = explode(" ", $timeStamp);
//        $date = $splitDateTime[0];
//        $time = $splitDateTime[1];
//
//        $count = $request->count_ea;
//
//        for($ctr = 0; $ctr<$count; $ctr++)
//        {
//            $get_id = $request->id[$ctr];
//
//            DB::table('contracts')
//                ->where('id',$get_id)
//                ->update([
//                    'date_updated' => $date
//                ]);
//        }
//
//        $data1 = array
//        (
//            'id' => $request->id,
//            'client_name' => $request->client_name,
//            'start_date' => $request->start_date,
//            'end_date' => $request->end_date,
//            'contract_desc' => $request->contract_desc,
//            'contract_remarks' => $request->contract_remarks,
//            'days_remaining' => $request->days_remaining,
//            'count' => $count
//        );
//
//        // Send your message
//        Mail::send('Marketing_Contract_Notification', $data1, function($message1){
//            $message1
//                ->to(['arnel.montero@ccsi.com.ph','marketing.assistant@ccsi.com','shanice.senador@ccsi.ph'], 'Marketing Manager')
////                ->cc('email', 'Carbon Copy')
//                ->bcc(['ccsijf.apungan@gmail.com','ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
//                ->subject('OIMS CLIENT CONTRACT NOTIFICATION');
//
//            $message1
//                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
//        });
//    }

    public function Marketing_Send_Email_Birthday($request)
    {

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $count = $request->count_them;

        for($ctr = 0; $ctr<$count; $ctr++)
        {
            $get_id = $request->id[$ctr];

            DB::table('client_birthdays')
                ->where('id',$get_id)
                ->update([
                    'date_updated' => $date
                ]);
        }

        $data = array
        (
            'id' => $request->id,
            'client_name' => $request->client_name,
            'birthdate' => $request->birthdate,
            'days_remaining' => $request->days_remaining,
            'contact_num' => $request->contact_num,
            'email_add' => $request->email_add,
            'client_position' => $request->client_position,
            'gift_type' => $request->gift_type,
            'bank_name' => $request->bank_name,
            'count' => $count

        );

        // Send your message
        Mail::send('Marketing_Bday_Notification', $data, function($message){
            $message
                ->to(['arnel.montero@ccsi.com.ph','marketing.assistant@ccsi.com','shanice.senador@ccsi.ph','marketing.assistant3@ccsi.ph'], 'Marketing Manager')
//                ->cc('email', 'Carbon Copy')
                ->bcc(['ccsirommel.rinos@gmail.com','ccsiranyll.puntanar@gmail.com', 'oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                ->subject('OIMS CLIENT BIRTHDAY NOTIFICATION');

            $message
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function Marketing_Send_Email_Contract($request)
    {
        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ", $timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $count = $request->count_ea;

        for($ctr = 0; $ctr<$count; $ctr++)
        {
            $get_id = $request->id[$ctr];

            DB::table('contracts')
                ->where('id',$get_id)
                ->update([
                    'date_updated' => $date
                ]);
        }

        $data1 = array
        (
            'id' => $request->id,
            'client_name' => $request->client_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'contract_desc' => $request->contract_desc,
            'contract_remarks' => $request->contract_remarks,
            'days_remaining' => $request->days_remaining,
            'count' => $count
        );

        // Send your message
        Mail::send('Marketing_Contract_Notification', $data1, function($message1){
            $message1
                ->to(['arnel.montero@ccsi.com.ph','marketing.assistant@ccsi.com','shanice.senador@ccsi.ph','marketing.assistant3@ccsi.ph'], 'Marketing Manager')
//                ->cc('email', 'Carbon Copy')
                ->bcc(['ccsirommel.rinos@gmail.com','ccsiranyll.puntanar@gmail.com', 'oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                ->subject('OIMS CLIENT CONTRACT NOTIFICATION');

            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function ReportSendCC($id, $what_pos)
    {
        $role = '';
        $prov = '';
        $muni = '';


        if(Auth::user()->hasRole('CC Senior Account Officer'))
        {
            $role = 'Senior Account Officer';
        }
        else if(Auth::user()->hasRole('CC Account Officer'))
        {
            $role = 'Account Officer';
        }

        $getDetails = DB::table('bi_endorsements')
            ->leftjoin('provinces', 'provinces.id', '=', 'bi_endorsements.present_province')
            ->leftjoin('municipalities', 'municipalities.id', '=', 'bi_endorsements.present_muni')
            ->select([
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.present_address as present_address',
                'provinces.name as prov',
                'municipalities.muni_name as muni'
            ])
            ->where('bi_endorsements.id', $id)
            ->get();

        $getSenderInfo = DB::table('users')
            ->select('email', 'name')
            ->where('id', $what_pos)
            ->get();

        $getClient = DB::table('bi_endorsements_users')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            (
                [
                    'users.email as emailClient'
                ]
            )
            ->where('bi_endorsements_users.bi_endorse_id', $id)
            ->where('bi_endorsements_users.position_id', 14)
            ->get();

        if($getDetails[0]->prov != null)
        {
            $prov = $getDetails[0]->prov;
        }

        if($getDetails[0]->muni != null)
        {
            $muni = $getDetails[0]->muni;
        }

        $to = $getClient[0]->emailClient;

        $data = array
        (
            'account_name' => $getDetails[0]->account_name,
            'account_address' => $getDetails[0]->present_address . ' '. $muni,
            'date_time' => Carbon::now('Asia/Manila'),
            'report_sender' => $getSenderInfo[0]->name,
            'email_sender' => $getSenderInfo[0]->email,
            'sender_position' => $role
        );

        $getCC = $getSenderInfo[0]->email;

        Mail::send('SendReportToClientCC', $data, function($message1) use ($to,$getCC){
            $message1
                ->to($to)
                ->cc($getCC)
                ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsiranyll.puntanar@gmail.com', 'ccsijl.escoto@gmail.com', 'ccsirommel.rinos@gmail.com '], 'Blind Carbon Copy')
                ->subject('OIMS Account: Final Report '.'('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function ReportReturnToClient($id, $remarks, $what_pos)
    {
        $role = '';

        if(Auth::user()->hasRole('CC Senior Account Officer'))
        {
            $role = 'Senior Account Officer';
        }
        else if(Auth::user()->hasRole('CC Account Officer'))
        {
            $role = 'Account Officer';
        }

        $final = explode('<br>', $remarks);

        $getDetails = DB::table('bi_endorsements')
            ->select('account_name')
            ->where('id', $id)
            ->get();

        $getSenderInfo = DB::table('users')
            ->select('email', 'name')
            ->where('id', $what_pos)
            ->get();

        $getClient = DB::table('bi_endorsements_users')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            (
                [
                    'users.email as emailClient'
                ]
            )
            ->where('bi_endorsements_users.bi_endorse_id', $id)
            ->where('bi_endorsements_users.position_id', 14)
            ->get();

        $to = $getClient[0]->emailClient;

        $data = array
        (
            'account_name' => $getDetails[0]->account_name,
            'remarks' => $final,
            'report_sender' => $getSenderInfo[0]->name,
            'email_sender' => $getSenderInfo[0]->email,
            'sender_position' => $role
        );


        $getName = $getDetails[0]->account_name;

        Mail::send('ReportReturnToClient', $data, function($message1) use ($to, $getName){
            $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                ->to($to)
//                ->cc('email', 'Carbon Copy')
                ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                ->subject('OIMS: Return Notificaiton '.'('.Carbon::now('Asia/Manila')->toFormattedDateString().')');

            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function ReportReturnToCC($id, $remarks, $what_pos, $role)
    {
        if($role == 'B.I Client')
        {
            $role = 'POC';
        }

        $final = explode('<br>', $remarks);

        $getDetails = DB::table('bi_endorsements')
            ->select('account_name')
            ->where('id', $id)
            ->get();

        $getSenderInfo = DB::table('users')
            ->select('email', 'name')
            ->where('id', $what_pos)
            ->get();

        $getAssignCC = DB::table('bi_endorsements_users')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->select
            (
                [
                    'users.email as emailClient'
                ]
            )
            ->where('bi_endorsements_users.bi_endorse_id', $id)
            ->where(function ($query){
                return $query->orwhere('bi_endorsements_users.position_id', 15)
                    ->orwhere('bi_endorsements_users.position_id', 16);
            })
            ->get();

        $to = $getAssignCC[0]->emailClient;


        $data = array
        (
            'account_name' => $getDetails[0]->account_name,
            'remarks' => $final,
            'report_sender' => $getSenderInfo[0]->name,
            'email_sender' => $getSenderInfo[0]->email,
            'sender_position' => $role
        );

        $getName = $getDetails[0]->account_name;

        $getSiteName = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->join('bi_account_list','bi_account_list.id','=', 'bi_account_to_users.bi_account_id')
            ->select(
                [
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ]
            )
            ->where('users.id', $what_pos)
            ->get();

        $siteName = $bi_site_name = $getSiteName[0]->name. ' ' . $getSiteName[0]->loc;

        Mail::send('ReportReturnToClient', $data, function($message1) use ($to, $siteName, $getName){
            $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                ->to($to)
//                ->cc('email', 'Carbon Copy')
                ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com', 'ccsirommel.rinos@gmail.com'],  'Blind Carbon Copy')
                ->subject(''.$siteName.' Account: '.$getName.' Return Notification');

            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function CIReceiveFund($id, $type_of_fund, $fund_id)
    {
        $get_ci = DB::table('ci_contacts')
            ->join('users', 'users.id', '=', 'ci_contacts.ci_id')
            ->select(
                [
                    'ci_contacts.contact_number as ci_num',
                    'ci_contacts.ci_id as ci_num',
                    'users.id as ci_id',
                    'users.email as ci_email'
                ]
            )
            ->where('users.id', $id)
            ->get();

        if(count($get_ci) != 0)
        {
            $to = $get_ci[0]->ci_email;


            if($type_of_fund == 'remittance')
            {
                $get_remit = DB::table('remittance')
                    ->select('remittance_info', 'amount')
                    ->where('fund_id', $fund_id)
                    ->get();

                if(count($get_remit) != 0)
                {
                    $finalInfo = preg_replace("<<br>>", "\n", $get_remit[0]->remittance_info);

                    $data = array
                    (
                        'type_of_fund'=> $type_of_fund,
                        'amount' => base64_decode($get_remit[0]->amount),
                        'info' => $finalInfo
                    );

                }
            }
            else if($type_of_fund == 'atm')
            {
                $get_atm = DB::table('ci_atm_fund')
                    ->leftjoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                    ->select([
                        'ci_atms.bank_name as atm_name',
                        'ci_atms.account_number as account_number',
                        'ci_atm_fund.amount as amount'
                    ])
                    ->where('ci_atm_fund.fund_id',$fund_id)
                    ->get();

                if(count($get_atm) != 0)
                {
                    $data = array
                    (
                        'type_of_fund'=> $type_of_fund,
                        'amount' => $get_atm[0]->amount,
                        'info' => $get_atm[0]->atm_name.' : '.$get_atm[0]->account_number
                    );
                }
            }

            Mail::send('CIFundReceive', $data, function($message1) use ($to){
                $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                    ->to($to)
//                    ->cc('Normita.Carino@ccsi.ph', 'Carbon Copy')
                    ->bcc(['ccsirommel.rinos@gmail.com', 'oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                    ->subject('OIMS Fund Notification');

                $message1
                    ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
            });
        }
    }

//     public function SendEndorsementNotifToSAO($poc_id, $account_name)
//     {
//         $getSiteName = DB::table('users')
//             ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
//             ->join('bi_account_list','bi_account_list.id','=', 'bi_account_to_users.bi_account_id')
//             ->select(
//                 [
//                     'users.name as poc_name',
//                     'bi_account_list.bi_account_name as name',
//                     'bi_account_list.account_location as loc'
//                 ]
//             )
//             ->where('users.id', $poc_id)
//             ->get();

//         if(count($getSiteName) != 0)
//         {
//             $bi_site_name = $getSiteName[0]->name. ' ' . $getSiteName[0]->loc;
//             $i = 0;
//             $getALlTo = DB::table('users')
//                 ->join('role_user', 'role_user.user_id','=', 'users.id')
//                 ->select(
//                     [
//                         'users.email as email'
//                     ]
//                 )
//                 ->where('users.archive', '!=', 'True')
//                 ->where(function($query){
//                     return $query->orwhere('role_user.role_id',15)
//                         ->orwhere('role_user.role_id', 16);
//                 })
//                 ->get();

//             $to = [];
//             for($i = 0; $i < count($getALlTo); $i++)
//             {
//                 $to[$i] = $getALlTo[$i]->email;
//             }

//             $data = array
//             (
//                 'account_name' => $account_name,
//                 'bi_site_name' => $bi_site_name,
//                 'poc_name' => $getSiteName[0]->poc_name,
//                 'date_time' => Carbon::now('Asia/Manila')
//             );

//             Mail::send('EndorsementEmailNotifCC', $data, function($message1) use ($to, $bi_site_name){
//                 $message1
// //                ->to('ccsiranyll.puntanar@gmail.com')
//                     ->to($to)
// //                ->cc('email', 'Carbon Copy')
//                     ->bcc(['ccsijf.apungan@gmail.com', 'ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
//                     ->subject('OIMS: '. $bi_site_name .' Endorsement Notification');

//                 $message1
//                     ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
//             });
//         }
//     }

    public function SendEndorsementNotifToSAO($poc_id, $account_name)
    {
        $getSiteName = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->join('bi_account_list','bi_account_list.id','=', 'bi_account_to_users.bi_account_id')
            ->select(
                [
                    'users.name as poc_name',
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ]
            )
            ->where('users.id', $poc_id)
            ->get();

        if(count($getSiteName) != 0)
        {
            $bi_site_name = $getSiteName[0]->name. ' ' . $getSiteName[0]->loc;
            $getALlTo = [];

            $getClientCheck = DB::table('users')
                ->select('client_check')
                ->where('id', Auth::user()->id)
                ->get();

            if($getClientCheck[0]->client_check == 'cc_bank')
            {
                $getALlTo = DB::table('users')
                    ->join('role_user', 'role_user.user_id','=', 'users.id')
                    ->select(
                        [
                            'users.email as email'
                        ]
                    )
                    ->where('users.archive', '!=', 'True')
                    ->where(function($query){
                        return $query->orwhere('role_user.role_id',15)
                            ->orwhere('role_user.role_id', 16);
                    })
                    ->where('client_check', 'cc_bank')
                    ->get();
            }
            else if($getClientCheck[0]->client_check != 'cc_bank')
            {
                $getALlTo = DB::table('users')
                    ->join('role_user', 'role_user.user_id','=', 'users.id')
                    ->select(
                        [
                            'users.email as email'
                        ]
                    )
                    ->where('users.archive', '!=', 'True')
                    ->where(function($query){
                        return $query->orwhere('role_user.role_id',15)
                            ->orwhere('role_user.role_id', 16);
                    })
                    ->where('client_check', '!=', 'cc_bank')
                    ->get();
            }

            $to = [];
            for($i = 0; $i < count($getALlTo); $i++)
            {
                $to[$i] = $getALlTo[$i]->email;
            }

            $data = array
            (
                'account_name' => $account_name,
                'bi_site_name' => $bi_site_name,
                'poc_name' => $getSiteName[0]->poc_name,
                'date_time' => Carbon::now('Asia/Manila')
            );

            Mail::send('EndorsementEmailNotifCC', $data, function($message1) use ($to, $bi_site_name){
                $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                    ->to($to)
//                ->cc('email', 'Carbon Copy')
                    ->bcc(['ccsijf.apungan@gmail.com', 'ccsipimentel.jelene@gmail.com', 'ccsirommel.rinos@gmail.com'], 'Blind Carbon Copy')
                    ->subject('OIMS: '. $bi_site_name .' Endorsement Notification');

                $message1
                    ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
            });
        }
    }

    public function sendEmailBulk($data)
    {
        $trimmer = new Trimmer();
        $timeStamp = Carbon::now('Asia/Manila');

        $newArray = [];
        $countData = 0;
        $mailArray = [];
        $cobName = '';
        $acctName = '';
        $addressAcct = '';
        $cobAddress = '';

        $getemailstosend = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('email_for','ClientNotif')
            ->where('emails_to_send.client_id', Auth::user()->id)
            ->get();

        $arraycont_email = [];
        $count_email = 0;

        foreach($getemailstosend as $getemails)
        {
            $arraycont_email[$count_email] = $getemails->email;

            $count_email++;
        }

        $countToIns = 0;

        foreach($data as $loopData)
        {
            $newArray[$countToIns] = [];

            foreach($loopData as $key => $value)
            {
                $newArray[$countToIns][$countData] = $value;
                $countData++;
            }
            $countData = 0;
            $countToIns++;
        }
//
//        for($i = 0 ; $i < count($data) ; $i++)
//        {
//            $newArray[$i] = [];
//
//            foreach ($data[$i] as $key => $value)
//            {
//                $newArray[$i][$countData] = $value;
//                $countData++;
//            }
//            $countData = 0;
//        }

        for($j = 0; $j < count($newArray); $j++)
        {
            $cobName = '';
            $cobAddress = '';

            $name = '';

            if($newArray[$j][7] == '')
            {
                $name = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]);
            }
            else
            {
                $name = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]);
            }

            $getEndorsementId = DB::table('endorsements')
                ->select('id', 'city_muni', 'provinces')
                ->where('account_name', $name)
                ->get();

            $muniDBname = DB::table('municipalities')
                ->select('muni_name')
                ->where('id', $getEndorsementId[0]->city_muni)
                ->get()[0]->muni_name;

            if($newArray[$j][7] == '')
            {
                $getEndorsementId = DB::table('endorsements')
                    ->select('id', 'city_muni', 'provinces')
                    ->where('account_name', $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]))
                    ->get();

                $muniDBname = DB::table('municipalities')
                    ->select('muni_name')
                    ->where('id', $getEndorsementId[0]->city_muni)
                    ->get()[0]->muni_name;


                if(strtoupper($newArray[$j][3]) == 'CO-BORROWER'|| strtoupper($newArray[$j][3])== 'CO-MAKER')
                {
                    $acctName =  $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]);
                    $addressAcct = $trimmer->trims($newArray[$j][11]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                }
                else if(strtoupper($newArray[$j][3]) == 'PRINCIPAL BORROWER')
                {
                    $getCobInfo = DB::table('coborrowers')
                        ->select('coborrower_name', 'coborrower_address', 'coborrower_municipality', 'coborrower_province')
                        ->where('endorsement_id', $getEndorsementId[0]->id)
                        ->get();

                    if(count($getCobInfo) > 0)
                    {
                        for($v = 0; $v < count($getCobInfo); $v++)
                        {
                            $cobName .= ' / ' . $getCobInfo[$v]->coborrower_name;
                            $cobAddress .= ' / ' .   $getCobInfo[$v]->coborrower_address . ' ' . $getCobInfo[$v]->coborrower_municipality . ' ' . $getCobInfo[$v]->coborrower_province;
                        }

                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]) . $cobName;
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces) . $cobAddress;
                    }
                    else if(count($getCobInfo) <= 0)
                    {
                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]);
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                    }
                }
            }
            else
            {
                $getEndorsementId = DB::table('endorsements')
                    ->select('id', 'city_muni', 'provinces')
                    ->where('account_name', $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]))
                    ->get();

                $muniDBname = DB::table('municipalities')
                    ->select('muni_name')
                    ->where('id', $getEndorsementId[0]->city_muni)
                    ->get()[0]->muni_name;


                if(strtoupper($newArray[$j][3]) == 'CO-BORROWER'|| strtoupper($newArray[$j][3])== 'CO-MAKER')
                {
                    $acctName =  $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]);
                    $addressAcct = $trimmer->trims($newArray[$j][11]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                }
                else if(strtoupper($newArray[$j][3]) == 'PRINCIPAL BORROWER')
                {
                    $getCobInfo = DB::table('coborrowers')
                        ->select('coborrower_name', 'coborrower_address', 'coborrower_municipality', 'coborrower_province')
                        ->where('endorsement_id', $getEndorsementId[0]->id)
                        ->get();

                    if(count($getCobInfo) > 0)
                    {
                        for($v = 0; $v < count($getCobInfo); $v++)
                        {
                            $cobName .= ' / ' . $getCobInfo[$v]->coborrower_name;
                            $cobAddress .= ' / ' .   $getCobInfo[$v]->coborrower_address . ' ' . $getCobInfo[$v]->coborrower_municipality . ' ' . $getCobInfo[$v]->coborrower_province;
                        }

                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]) . $cobName;
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces) . $cobAddress;
                    }
                    else if(count($getCobInfo) <= 0)
                    {
                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]);
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                    }
                }

            }


            $mailArray[$j] = ['acctName' => $acctName , 'acctAddress' => $addressAcct, 'NameReq' => $trimmer->trims($newArray[$j][1]), 'LoneType' => $trimmer->trims($newArray[$j][2]) , 'tOR' => $trimmer->trims($newArray[$j][0])];

            $acctName = '';
            $addressAcct = '';
            $cobName = '';

        }
//        $objToMail = (object) $mailArray;


        $data = array('dateTimeEndorse'=> $timeStamp, 'bulkData'=>  $mailArray, 'countLoop' => count($mailArray));

        Mail::send('client_bulk_endorsement', $data, function($message) use ($arraycont_email)
        {
            $message
                ->to($arraycont_email, 'CCSI SAO and DISPATCHER')
                ->cc(['ccsirommel.rinos@gmail.com', 'oims.notifications@gmail.com', 'ccsijl.escoto@gmail.com'], 'Administrator')
                ->subject(Auth::user()->name.' Bulk Endorsement List to C.C.S.I');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
    }

    public function sendEmail_for_admin_bulk($data)
    {
        $trimmer = new Trimmer();
        $timeStamp = Carbon::now('Asia/Manila');

        $newArray = [];
        $countData = 0;
        $mailArray = [];
        $cobName = '';
        $acctName = '';
        $addressAcct = '';
        $cobAddress = '';

        $getemailstosend = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('email_for','ClientNotif')
            ->where('emails_to_send.client_id', Auth::user()->id)
            ->get();

        $arraycont_email = [];
        $count_email = 0;
        $countToIns = 0;

        foreach($getemailstosend as $getemails)
        {
            $arraycont_email[$count_email] = $getemails->email;

            $count_email++;
        }

        foreach($data as $loopData)
        {
            $newArray[$countToIns] = [];

            foreach($loopData as $key => $value)
            {
                $newArray[$countToIns][$countData] = $value;
                $countData++;
            }
            $countData = 0;
            $countToIns++;
        }

//        for($i = 0 ; $i < count($data) ; $i++)
//        {
//            $newArray[$i] = [];
//
//            foreach ($data[$i] as $key => $value)
//            {
//                $newArray[$i][$countData] = $value;
//                $countData++;
//            }
//            $countData = 0;
//        }

        for($j = 0; $j < count($newArray); $j++)
        {
            $cobName = '';
            $cobAddress = '';
            $name = '';

            if($newArray[$j][7] == '')
            {
                $getEndorsementId = DB::table('endorsements')
                    ->select('id', 'city_muni', 'provinces')
                    ->where('account_name', $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]))
                    ->get();

                $muniDBname = DB::table('municipalities')
                    ->select('muni_name')
                    ->where('id', $getEndorsementId[0]->city_muni)
                    ->get()[0]->muni_name;

                if(strtoupper($newArray[$j][3]) == 'CO-BORROWER'|| strtoupper($newArray[$j][3])== 'CO-MAKER')
                {
                    $acctName =  $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]);
                    $addressAcct = $trimmer->trims($newArray[$j][11]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                }
                else if(strtoupper($newArray[$j][3]) == 'PRINCIPAL BORROWER')
                {
                    $getCobInfo = DB::table('coborrowers')
                        ->select('coborrower_name', 'coborrower_address', 'coborrower_municipality', 'coborrower_province')
                        ->where('endorsement_id', $getEndorsementId[0]->id)
                        ->get();

                    if(count($getCobInfo) > 0)
                    {
                        for($v = 0; $v < count($getCobInfo); $v++)
                        {
                            $cobName .= ' / ' . $getCobInfo[$v]->coborrower_name;
                            $cobAddress .= ' / ' .   $getCobInfo[$v]->coborrower_address . ' ' . $getCobInfo[$v]->coborrower_municipality . ' ' . $getCobInfo[$v]->coborrower_province;
                        }

                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]) . $cobName;
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces) . $cobAddress;
                    }
                    else if(count($getCobInfo) <= 0)
                    {
                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][8]);
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                    }
                }
            }
            else
            {

                $getEndorsementId = DB::table('endorsements')
                    ->select('id', 'city_muni', 'provinces')
                    ->where('account_name', $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]))
                    ->get();

                $muniDBname = DB::table('municipalities')
                    ->select('muni_name')
                    ->where('id', $getEndorsementId[0]->city_muni)
                    ->get()[0]->muni_name;


                if(strtoupper($newArray[$j][3]) == 'CO-BORROWER'|| strtoupper($newArray[$j][3])== 'CO-MAKER')
                {
                    $acctName =  $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]);
                    $addressAcct = $trimmer->trims($newArray[$j][11]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                }
                else if(strtoupper($newArray[$j][3]) == 'PRINCIPAL BORROWER')
                {
                    $getCobInfo = DB::table('coborrowers')
                        ->select('coborrower_name', 'coborrower_address', 'coborrower_municipality', 'coborrower_province')
                        ->where('endorsement_id', $getEndorsementId[0]->id)
                        ->get();

                    if(count($getCobInfo) > 0)
                    {
                        for($v = 0; $v < count($getCobInfo); $v++)
                        {
                            $cobName .= ' / ' . $getCobInfo[$v]->coborrower_name;
                            $cobAddress .= ' / ' .   $getCobInfo[$v]->coborrower_address . ' ' . $getCobInfo[$v]->coborrower_municipality . ' ' . $getCobInfo[$v]->coborrower_province;
                        }

                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]) . $cobName;
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces) . $cobAddress;
                    }
                    else if(count($getCobInfo) <= 0)
                    {
                        $acctName = $trimmer->trims($newArray[$j][6]) .' '. $trimmer->trims($newArray[$j][7]). ' ' . $trimmer->trims($newArray[$j][8]);
                        $addressAcct = $trimmer->trims($newArray[$j][10]) . ' ' . $trimmer->trims($muniDBname) . ' ' . $trimmer->trims($getEndorsementId[0]->provinces);
                    }
                }

            }

            $mailArray[$j] = ['acctName' => $acctName , 'acctAddress' => $addressAcct, 'NameReq' => $trimmer->trims($newArray[$j][1]), 'LoneType' => $trimmer->trims($newArray[$j][2]) , 'tOR' => $trimmer->trims($newArray[$j][0])];

            $acctName = '';
            $addressAcct = '';
            $cobName = '';

        }

        $data = array('dateTimeEndorse'=> $timeStamp, 'bulkData'=>  $mailArray, 'countLoop' => count($mailArray));

        Mail::send('client_bulk_endorsement', $data, function($message) {
            $message
                ->to('ccsijf.apungan@gmail.com', 'CCSI SAO and DISPATCHER')
//                ->cc([''], 'Administrator')
                ->subject(Auth::user()->name.' Bulk Endorsement List to C.C.S.I');
            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });

//        return $testTae;

    }

    public function sendEmail_for_admin_api($details,$user_name,$auth_id)
    {
        $timeStamp = Carbon::now('Asia/Manila');

        $getemailstosend = DB::table('emails_to_send')
            ->join('users','users.id','=','emails_to_send.user_id')
            ->select('users.email as email')
            ->where('email_for','ClientNotif')
            ->where('emails_to_send.client_id', $auth_id)
            ->get();

        $arraycont_email = [];
        $count_email = 0;

        foreach($getemailstosend as $getemails)
        {
            $arraycont_email[$count_email] = $getemails->email;

            $count_email++;
        }

        $data = array
        (
            'dateTimeEndorse'   =>  $timeStamp,
            'acctName'          =>  $details['acctName'],
            'address'           =>  $details['address'],
            'nameOfRequestor'   =>  $details['nameOfRequestor'],
            'typeOfLoan'        =>  $details['typeOfLoan'],
            'typeOfRequest'     =>  $details['typeOfRequest'],
            'remarks'           =>  $details['remarks']
        );

//        // Backup your default mailer
//        $backup = Mail::getSwiftMailer();
//
//        // Setup your gmail mailer
//        $transport = (new Swift_SmtpTransport('mail.ccsi-oims.net', 465, 'ssl'));
//        $transport->setUsername('notification@ccsi-oims.net');
//        $transport->setPassword('w=Rqc=dv#yF,');
//        // Any other mailer configuration stuff needed...
//
//        $gmail = new Swift_Mailer($transport);
//
//        // Set the mailer as gmail
//        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('mail', $data, function($message) use ($user_name) {
            $message
                ->cc(['ccsirommel.rinos@gmail.com','oims.notifications@gmail.com'], 'Administrator')
//                ->cc([''], 'Administrator')
                ->subject($user_name.' Endorsement List to C.C.S.I Through API');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
//
//        // Restore your original mailer
//        Mail::setSwiftMailer($backup);
    }

    public function Send_Email_Individual_Client($endorseID)
    {
        $endorsement = DB::table('endorsements')
            ->leftJoin('paypal_requestor_info', 'paypal_requestor_info.endorsement_id', '=', 'endorsements.id')
            ->leftJoin('paypal_payment_info', 'paypal_payment_info.tr_id', '=', 'endorsements.paypal_tr_id')
            ->leftJoin('endorsements_transaction_tracking', 'endorsements_transaction_tracking.endorsement_id', '=', 'endorsements.id')
            ->join('municipalities', 'municipalities.id', '=', 'endorsements.city_muni')
            ->select([
                'paypal_requestor_info.email as email',
                'paypal_requestor_info.name as req_name',
                'endorsements_transaction_tracking.transaction_id as tracking_id',
                'paypal_payment_info.amount as amount',
                'paypal_payment_info.tr_id as transaction_id_paypal',
                'endorsements.created_at as date_time',
                'endorsements.account_name as accnt_name',
                'endorsements.address as address',
                'endorsements.type_of_loan as tor',
                'endorsements.type_of_request as type_of_req',
                'municipalities.muni_name as muni_name',
            ])
            ->where('endorsements.id', $endorseID)
            ->get()[0];

        $data = array
        (
            'tracking_id' => $endorsement->tracking_id,
            'amount' => $endorsement->amount,
            'date_time' => $endorsement->date_time,
            'accnt_name' => $endorsement->accnt_name,
            'muni_name' => $endorsement->muni_name,
            'address' => $endorsement->address,
            'req_name' => $endorsement->req_name,
            'tor' => $endorsement->tor,
            'type_of_req' => $endorsement->type_of_req,
            'transaction_id_paypal' => $endorsement->transaction_id_paypal
        );


        // Backup your default mailer
//        $backup = Mail::getSwiftMailer();
//
//        // Setup your gmail mailer
//        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525, 'tls'));
//        $transport->setUsername('78d98a1189fa51');
//        $transport->setPassword('07ae9a77e9ae74');
//        // Any other mailer configuration stuff needed...
//
//        $gmail = new Swift_Mailer($transport);
//
//        // Set the mailer as gmail
//        Mail::setSwiftMailer($gmail);

        // Send your message
        Mail::send('mailIndi', $data, function($message) use($endorsement) {
            $message
                ->to($endorsement->email, 'Requestor')
//                ->cc(['ccsiranyll.puntanar@gmail.com', ''], 'Administrator')
                ->bcc(['ccsirommel.rinos@gmail.com', 'oims.notifications@gmail.com'], 'Administrator')
                ->subject('CCSI Endorsement Notification');

            $message
                ->from('notification@ccsi-oims.net','Comprehensive Credit Services Inc.');
        });
//
        // Restore your original mailer
//        Mail::setSwiftMailer($backup);
    }

    public function SentNotifSaoDis($id, $type_of_fund, $fund_id, $sao)
    {
        $data = [];
        $getSaoEmail = DB::table('users')
            ->select('email')
            ->where('id', $sao)
            ->get()[0]->email;

        $getciname = DB::table('users')
            ->select('name')
            ->where('id', $id)
            ->get()[0]->name;


        $getUploadDate = DB::table('fund_requests')
            ->select('delivered_date', 'type_of_fund_request', 'dispatcher_id')
            ->where('id', $fund_id)
            ->get();

        if($type_of_fund == 'remittance')
        {
            $get_remit = DB::table('remittance')
                ->select('remittance_info', 'amount')
                ->where('fund_id', $fund_id)
                ->get();


            if(count($get_remit) != 0)
            {
                $data = array
                (
                    'type_of_fund'=> $type_of_fund,
                    'amount' => base64_decode($get_remit[0]->amount),
                    'upload_date' => $getUploadDate[0]->delivered_date,
                    'ci_name' => $getciname,
                );

            }
        }
        else if($type_of_fund == 'atm')
        {
            $get_atm = DB::table('ci_atm_fund')
                ->leftjoin('ci_atms','ci_atms.id','=','ci_atm_fund.ci_atm_id')
                ->select([
                    'ci_atms.bank_name as atm_name',
                    'ci_atms.account_number as account_number',
                    'ci_atm_fund.amount as amount'
                ])
                ->where('ci_atm_fund.fund_id',$fund_id)
                ->get();

            if(count($get_atm) != 0)
            {
                $data = array
                (
                    'type_of_fund'=> $type_of_fund,
                    'amount' => $get_atm[0]->amount,
                    'upload_date' => $getUploadDate[0]->delivered_date,
                    'ci_name' => $getciname
                );
            }
        }


        if($getUploadDate[0]->type_of_fund_request == 'NORMAL REQUEST')
        {
            if($getUploadDate[0]->dispatcher_id == 0)
            {
                Mail::send('DispatcherSaoFundNotif', $data, function($message1) use ($getSaoEmail){
                    $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                        ->to($getSaoEmail)
//                ->cc('email', 'Carbon Copy')
                        ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com'], 'Blind Carbon Copy')
                        ->subject('OIMS Fund Notification');

                    $message1
                        ->from('notification@ccsi-oims.net','OIMS FUND NOTIFICATION');
                });
            }
            else if($getUploadDate[0]->dispatcher_id != 0)
            {
                $getDispEmail = DB::table('users')
                    ->select('email')
                    ->where('id', $getUploadDate[0]->dispatcher_id)
                    ->get()[0]->email;

                Mail::send('DispatcherSaoFundNotif', $data, function($message1) use ($getSaoEmail, $getDispEmail){
                    $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                        ->to([$getDispEmail, $getSaoEmail])
//                ->cc('email', 'Carbon Copy')
                        ->bcc(['ccsirommel.rinos@gmail.com', 'oims.notifications@gmail.com'], 'Blind Carbon Copy')
                        ->subject('OIMS Fund Notification');

                    $message1
                        ->from('notification@ccsi-oims.net','OIMS FUND NOTIFICATION');
                });
            }
        }
        else if($getUploadDate[0]->type_of_fund_request == 'EMERGENCY FUND')
        {
            $getManagementList = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->select('users.email as  email')
                ->where('role_user.role_id', 5)
                ->get();

            $arrayToSendManage = [];

            foreach($getManagementList as $email)
            {
                array_push($arrayToSendManage, $email->email);
            }

            array_push($arrayToSendManage, $getSaoEmail);


            Mail::send('DispatcherSaoFundNotif', $data, function($message1) use ($arrayToSendManage){
                $message1
                    ->to($arrayToSendManage)
                    ->bcc(['ccsirommel.rinos@gmail.com', 'oims.notifications@gmail.com'], 'Blind Carbon Copy')
                    ->subject('OIMS Fund Notification');

                $message1
                    ->from('notification@ccsi-oims.net','OIMS FUND NOTIFICATION');
            });

        }
    }

    public function NotifToManagement($sao, $ci, $amt, $rem, $arch, $type)
    {
        $arrayToSend = [];

        if($arch == 1)
        {
            $arrayToSend = ['julius.santos@ccsi.com.ph', 'lovely.quijado@ccsi.com.ph'];
        }
        else if($arch == 2)
        {
            $arrayToSend = ['sheila.cahipe@ccsi.com.ph', 'eillen.mamigo@ccsi.com.ph'];
        }
        else if($arch == 3)
        {
            $arrayToSend = ['carolyn.palmares@ccsi.com.ph'];
        }

        array_push($arrayToSend, 'maan.macatuay@ccsi.com.ph');

        $data = array
        (
            'requestor_name'=> $sao,
            'ci_name' => $ci,
            'amt' => $amt,
            'rem' => $rem,
            'type' => $type
        );

        Mail::send('EmailNotifToManagementFund', $data, function($message1) use ($arrayToSend){
            $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                ->to($arrayToSend, 'CCSI Management')
                ->cc('Normita.Carino@ccsi.ph', 'Carbon Copy')
                ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com'], 'Blind Carbon Copy')
                ->subject('OIMS Fund Notification - For Approval');

            $message1
                ->from('notification@ccsi-oims.net','OIMS FUND NOTIFICATION - For Approval');
        });
    }

    public function reminders_email($reminder, $remaining)
    {
        $count = count($reminder);
        $data = array
        (
            'reminder_name' => $reminder,
            'remaining' => $remaining,
            'count' => $count
        );
        Mail::send('EmailReminderNotif', $data, function($message1){
            $message1
                ->to('ccsiranyll.puntanar@gmail.com')
                ->bcc(['ccsiranyll.puntanar@gmail.com'], 'Blind Carbon Copy')
                ->subject('OIMS Reminder Notification');
            $message1
                ->from('notification@ccsi-oims.net','OIMS REMINDER NOTIFICATION');
        });
    }

    public function cc_bulk_endorsement($send, $count, $poc_id)
    {
        $getSiteName = DB::table('users')
            ->join('bi_account_to_users', 'bi_account_to_users.users_id', '=', 'users.id')
            ->join('bi_account_list','bi_account_list.id','=', 'bi_account_to_users.bi_account_id')
            ->select(
                [
                    'users.name as poc_name',
                    'bi_account_list.bi_account_name as name',
                    'bi_account_list.account_location as loc'
                ]
            )
            ->where('users.id', $poc_id)
            ->get();

        if(count($getSiteName) != 0)
        {
            $bi_site_name = $getSiteName[0]->name . ' ' . $getSiteName[0]->loc;
            $i = 0;
            $getALlTo = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->select(
                    [
                        'users.email as email'
                    ]
                )
                ->where('users.archive', '!=', 'True')
                ->where(function ($query) {
                    return $query->orwhere('role_user.role_id', 15)
                        ->orwhere('role_user.role_id', 16);
                })
                ->get();

            $to = [];
            for ($i = 0; $i < count($getALlTo); $i++)
            {
                $to[$i] = $getALlTo[$i]->email;
            }

            $arrayData = $send;

            $arraytoAdd = ['countLoop' => $count, 'bulkData' => $arrayData];

            Mail::send('BulkEndorsementCCEmailNotif', $arraytoAdd, function($message1) use ($to, $bi_site_name)
            {
                $message1
//                ->to('ccsiranyll.puntanar@gmail.com')
                    ->to($to)
//                ->cc('email', 'Carbon Copy')
                    ->bcc(['ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                    ->subject('OIMS: '. $bi_site_name .' Bulk Endorsement Notification');

                $message1
                    ->from('notification@ccsi-oims.net','OIMS BULK NOTIFICATION');
            });
        }


    }

    public function cc_client_account_acknowledge_notif($endo_id, $sender_email)
    {
        $get_endorsement = DB::table('bi_endorsements')
            ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_endorsements.bi_id')
            ->where('bi_endorsements.id', $endo_id)
            ->where('bi_endorsements_users.position_id', 14)
            ->select([
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.bi_account_name as bi_account_name',
                'bi_endorsements.bi_id as bi_id',
                'bi_endorsements.created_at as created_at',
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as bi_loc',
                'users.name as poc_name',
                'users.email as poc_email',
            ])
            ->get();

        if(count($get_endorsement) > 0)
        {
            $to = $get_endorsement[0]->poc_email;

            $data = array
            (
                'account_name' => $get_endorsement[0]->account_name,
                'poc_name' => $get_endorsement[0]->poc_name,
                'from_site' => $get_endorsement[0]->bi_name . ' ' . $get_endorsement[0]->bi_loc,
                'datetime' => $get_endorsement[0]->created_at,
            );
            Mail::send('cc_client_acknowledge_received_email', $data, function($message1) use ($sender_email, $to)
            {
                $message1
                    ->to($to)
                    ->cc($sender_email)
                    ->bcc(['oims.notifications@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'], 'Blind Carbon Copy')
                    ->subject('OIMS: Acknowledge Account Notification ' .'('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
                $message1
                    ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
            });
        }
    }

    public function BICancellationRequest($request)
    {
        $what = '';
        $getALlTo = [];
        if($request->what == 'req_cancel')
        {
            $what = 'Cancellation';
        }
        else
        {
            $what = 'Revoke Cancellation';
        }
        $get_endorsement = DB::table('bi_endorsements')
            ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_endorsements.bi_id')
            ->where('bi_endorsements.id', $request->id)
            ->where('bi_endorsements_users.position_id', 14)
            ->select([
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.bi_account_name as bi_account_name',
                'bi_endorsements.bi_id as bi_id',
                'bi_endorsements.created_at as created_at',
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as bi_loc',
                'users.name as poc_name',
                'users.email as poc_email',
            ])
            ->get();

        $i = 0;

        if(Auth::user()->client_check == 'cc_bank')
        {
            $getALlTo = DB::table('users')
                ->join('role_user', 'role_user.user_id','=', 'users.id')
                ->select(
                    [
                        'users.email as email'
                    ]
                )
                ->where('users.archive', '!=', 'True')
                ->where(function($query){
                    return $query->orwhere('role_user.role_id',15)
                        ->orwhere('role_user.role_id', 16);
                })
                ->where('client_check', 'cc_bank')
                ->get();
        }
        else if(Auth::user()->client_check != 'cc_bank')
        {
            $getALlTo = DB::table('users')
                ->join('role_user', 'role_user.user_id','=', 'users.id')
                ->select(
                    [
                        'users.email as email'
                    ]
                )
                ->where('users.archive', '!=', 'True')
                ->where(function($query){
                    return $query->orwhere('role_user.role_id',15)
                        ->orwhere('role_user.role_id', 16);
                })
                ->where('client_check', '!=', 'cc_bank')
                ->get();
        }

        $to = [];
        for($i = 0; $i < count($getALlTo); $i++)
        {
            $to[$i] = $getALlTo[$i]->email;
        }

        if(count($get_endorsement) > 0)
        {
            $data = array
            (
                'account_name' => $get_endorsement[0]->account_name,
                'poc_name' => $get_endorsement[0]->poc_name,
                'from_site' => $get_endorsement[0]->bi_name . ' ' . $get_endorsement[0]->bi_loc,
                'datetime' => $get_endorsement[0]->created_at,
                'what' => $request->what,
                'reason' => $request->reason
            );

            Mail::send('BIClientCancellationNotif', $data, function($message1) use ($to, $what)
            {
                $message1
                    ->to($to)
//                    ->cc($sender_email)
                    ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                    ->subject('OIMS: Account '.$what.' Request ' .'('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
                $message1
                    ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
            });
        }
    }

    public function BICancellationRequestNotifSAO($request)
    {
        $what = '';
        if($request->what == 'pending')
        {
            $what = 'Cancellation';
        }
        else
        {
            $what = 'Revoke Cancellation';
        }

        $get_endorsement = DB::table('bi_endorsements')
            ->join('bi_endorsements_users', 'bi_endorsements_users.bi_endorse_id', '=', 'bi_endorsements.id')
            ->join('users', 'users.id', '=', 'bi_endorsements_users.users_id')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_endorsements.bi_id')
            ->where('bi_endorsements.id', $request->id)
            ->where('bi_endorsements_users.position_id', 14)
            ->select([
                'bi_endorsements.account_name as account_name',
                'bi_endorsements.bi_account_name as bi_account_name',
                'bi_endorsements.bi_id as bi_id',
                'bi_endorsements.created_at as created_at',
                'bi_account_list.bi_account_name as bi_name',
                'bi_account_list.account_location as bi_loc',
                'users.name as poc_name',
                'users.email as poc_email',
            ])
            ->get();

        if(count($get_endorsement) > 0)
        {
            $to = $get_endorsement[0]->poc_email;

            $data = array
            (
                'account_name' => $get_endorsement[0]->account_name,
                'poc_name' => $get_endorsement[0]->poc_name,
                'from_site' => $get_endorsement[0]->bi_name . ' ' . $get_endorsement[0]->bi_loc,
                'datetime' => $get_endorsement[0]->created_at,
                'what' => $request->what,
                'reason' => $request->reason
            );

            Mail::send('BIClientCancellationNotifFromInternal', $data, function($message1) use ($to, $what)
            {
                $message1
                    ->to($to)
//                    ->cc($sender_email)
                    ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                    ->subject('OIMS: Account '.$what .' Notification ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
                $message1
                    ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
            });
        }
    }

    public function sendNotifToSaoFromCISeen($array)
    {
        $to = [];
        $getAllSao = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('users.archive', '!=', 'True')
            ->where('role_user.role_id', 7)
            ->select([
                'email'
            ])
            ->get();

        if(count($getAllSao) > 0)
        {
            foreach ($getAllSao as $email)
            {
                array_push($to, $email->email);
            }
        }

        $data = array
        (
            'bulkData'=>  $array,
            'countLoop' => count($array),
            'now' => Carbon::now('Asia/Manila')
        );

        Mail::send('CIAccountSeenNotif', $data, function($message1) use ($to)
        {
            $message1
                ->to($to)
                ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                ->subject('OIMS NOTIFICATION ACCOUNT SEEN ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });

        return [$array];
    }

    public function sendEmailApproverManageReq($request, $sendID, $reqId, $type)
    {
        $email = [];

        foreach ($sendID as $em)
        {
            array_push($email, $em->email);
        }

        if($type == 'toManage')
        {
            $data =
                [
                    'id' => $reqId,
                    'req_reason' => $request->radioCheck,
                    'req_reason_remarks' => $request->reqRemarksReason,
                    'date_request' => $request->dateRequested,
                    'requestor_name' => $request->reqName,
                    'office_loc_dep_pos' => $request->officeLoc,
                    'date_needed' => $request->dateNeeded,
                    'requested_for_id' => $request->requestedRequiForID
                ];

            Mail::send('sendRequisitionToManage', $data, function($message1) use ($email)
            {
                $message1
                    ->to($email)
                    ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                    ->subject('For Requisition Approval - Management ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
                $message1
                    ->from('notification@ccsi-oims.net','OIMS REQUISITION NOTIFICATION');
            });

        }
        else if($type == 'toAdmin')
        {
            $data =
                [
                    'id' => $reqId,
                    'req_reason' => $request[0]->req_reason,
                    'req_reason_remarks' => $request[0]->req_reason_remarks,
                    'date_request' => $request[0]->date_request,
                    'requestor_name' => $request[0]->requestor_name,
                    'office_loc_dep_pos' => $request[0]->office_loc_dep_pos,
                    'date_needed' => $request[0]->date_needed,
                    'requested_for_id' => $request[0]->requested_for_id
                ];

            Mail::send('sendRequisitionToManage', $data, function($message1) use ($email)
            {
                $message1
                    ->to($email)
                    ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com', 'ccsirommel.rinos@gmail.com'])
                    ->subject('For Requisition Approval - Admin ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
                $message1
                    ->from('notification@ccsi-oims.net','OIMS REQUISITION NOTIFICATION');
            });

        }
    }

    public function sendRequestSupplierManager($request, $sups)
    {
        $toSendDetails =
            [
                'suppName' => $sups,
                'categ' => $request->categoryToPass,
                'eqDesc' => $request->equipmentToBuy,
                'rem' => $request->remarksComparison
            ];

        $emailAdd = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email')
            ->where('users.archive', 'false')
            ->where('role_user.role_id', 5)
            ->where('users.client_check', 'all_access')
            ->get();

        $emailtoSend = [];

        foreach ($emailAdd as $ePush)
        {
            array_push($emailtoSend, $ePush->email);
        }

        Mail::send('sendManagementRequestSuppliers', $toSendDetails, function($message1) use ($emailtoSend)
        {
            $message1
                ->to($emailtoSend)
                ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                ->subject('FOR SUPPLIER APPROVAL - ADMIN ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS SUPPLIER ACCREDITATION NOTIFICATION');
        });
    }

    public function sendToAdminApproved($app, $rem)
    {
        $toSendDetails =
            [
                'approved' => $app,
                'rem' => $rem
            ];

        $emailAdd = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select('users.email as email')
            ->where('users.archive', 'false')
            ->where('role_user.role_id', 12)
//            ->where('users.admin_access_3', 'Granted')
            ->get();

        $emailtoSend = [];

        foreach ($emailAdd as $ePush)
        {
            array_push($emailtoSend, $ePush->email);
        }

        Mail::send('sendToAdminApprovedSupFromManage', $toSendDetails, function($message1) use ($emailtoSend)
        {
            $message1
                ->to($emailtoSend)
                ->bcc(['oims.notifications@gmail.com', 'ccsijf.apungan@gmail.com'])
                ->subject('FOR SUPPLIER APPROVAL - MANAGEMENT ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS SUPPLIER ACCREDITATION NOTIFICATION');
        });

    }
    
    public function sendEmailApplicatReturned($name, $message, $email, $code)
    {

        $toSendDetails =
            [
                'name' => $name,
                'remarks' => $message,
                'code' => $code
            ];

        Mail::send('sendEmailReturnApplicant', $toSendDetails, function($message1) use ($email)
        {
            $message1
                ->to([$email])
                ->bcc(['ccsirommel.rinos@gmail.com', 'ccsijf.apungan@gmail.com', 'ccsipimentel.jelene@gmail.com'])
                ->subject('Return Notification(Online Application)('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS RETURN NOTIFICATION');
        });
    }

    public function DirectEncodeCancellation($remarks, $pivot_id)
    {
        $getTo = DB::table('bi_direct_pivot')
            ->join('bi_direct_applicant_endorsement', 'bi_direct_applicant_endorsement.id', '=', 'bi_direct_pivot.direct_to_get_id')
            ->where('bi_direct_pivot.id', '=', $pivot_id)
            ->select('bi_direct_applicant_endorsement.direct_personal_email')
            ->get()[0]->direct_personal_email;

        $getCode = DB::table('bi_direct_pivot')
            ->join('bi_direct_applicant_endorsement', 'bi_direct_applicant_endorsement.id', '=', 'bi_direct_pivot.direct_to_get_id')
            ->where('bi_direct_pivot.id', '=', $pivot_id)
            ->select('bi_direct_applicant_endorsement.generated_code')
            ->get()[0]->generated_code;

        $data = [
            'remarks' => $remarks,
            'code' => $getCode
        ];

        Mail::send('DirectEmailCancellationNotif', $data, function($message1) use ($getTo)
        {
            $message1
                ->to($getTo)
                ->bcc(['ccsijf.apungan@gmail.com', 'ccsipimentel.jelene@gmail.com', 'ccsirommel.rinos@gmail.com'])
                ->subject('OIMS APPLICATION CANCELLED NOTIFICATION ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }
    
    public function PaypalSuccessFunding($payee_email, $transaction_id, $amount)
    {
        $data = [
            'transaction_ref' => $transaction_id,
            'amount_paid' => $amount
        ];

        Mail::send('PaypalSuccessFundingNotification', $data, function($message1) use ($payee_email)
        {
            $message1
                ->to($payee_email)
                ->bcc(['ccsirommel.rinos@gmail.com', 'ccsijf.apungan@gmail.com', 'oims.notifications@gmail.com'])
                ->subject('OIMS PAYMENT NOTIFICATION ('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }
    
    public function sendEmailToClientForNewDirect($bi_categ, $name, $age, $gender, $marital, $address, $muni, $emailApp, $tracking)
    {
        $getEmails = DB::table('bi_account_to_users')
            ->join('users', 'users.id', '=', 'bi_account_to_users.users_id')
            ->join('bi_account_list', 'bi_account_list.id', '=', 'bi_account_to_users.bi_account_id')
            ->select
            ([
                'users.email as email',
                \DB::raw('CONCAT(bi_account_list.bi_account_name, " ", bi_account_list.account_location) as bi_name')
            ])
            ->where('bi_account_to_users.bi_account_id', '=', $bi_categ)
            ->where('users.archive', 'false')
            ->where('users.authrequest', 'direct_enc')
            ->get();

        $emailsToSend = [];

        if($getEmails[0]->bi_name != 'Qualfon Corporate')
        {
            foreach ($getEmails as $em)
            {
                array_push($emailsToSend, $em->email);
            }
        }
        else if($getEmails[0]->bi_name == 'Qualfon Corporate')
        {
            array_push($emailsToSend, 'liezel.anor@qualfon.com');
        }

        $getMuni = DB::table('municipalities')
            ->select('muni_name')
            ->where('id', $muni)
            ->get();


        $toSendDetails =
            [
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
                'marital' => $marital,
                'address' => $address,
                'muni' => $getMuni[0]->muni_name,
                'tracking' => $tracking
            ];

        Mail::send('sendNotifToClientForDirectApply', $toSendDetails, function($message1) use ($emailsToSend)
        {
            $message1
                ->to($emailsToSend)
                ->bcc(['ccsijf.apungan@gmail.com', 'ccsipimentel.jelene@gmail.com', 'ccsirommel.rinos@gmail.com', 'ccsijl.escoto@gmail.com'])
                ->subject('OIMS Direct Employment Application(Online)('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NEW APPLICANT NOTIFICATION');
        });
    }
    
    public function sendEmailToApplicantForNewDirect($name, $emailApp, $tracking, $site_id)
    {
        $links = DB::table('site_application_links')
            ->where('user_id', '=', $site_id)
            ->get();

        $toSendDetails =
            [
                'name' => $name,
                'track' => $tracking,
                'link' => $links[0]->link,
            ];

        Mail::send('sendEmailNotifToApplicantNew', $toSendDetails, function($message1) use ($emailApp)
        {
            $message1
                ->to($emailApp)
                ->bcc(['ccsirommel.rinos@gmail.com', 'ccsijf.apungan@gmail.com', 'ccsipimentel.jelene@gmail.com', 'ccsijl.escoto@gmail.com'])
                ->subject('OIMS Direct Employment Application(Online)('.Carbon::now('Asia/Manila')->toFormattedDateString().')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS ONLINE APPLICATION NOTIFICATION');
        });
    }
    
    public function hrIssuanceSend($request)
    {
        $emailsTOsend = [];

        if($request->receiver == 'All Employees')
        {

        }
        else if($request->receiver == 'CI Department')
        {

        }
        else if($request->receiver == 'Human Resources')
        {

        }
        else if($request->receiver == 'Admin')
        {

        }
        else if($request->receiver == 'Finance')
        {

        }
        else if($request->receiver == 'Marketing')
        {

        }
        else if($request->receiver == 'Audit')
        {

        }

        $data =
            [
                'content' => $request->content_iss,
                ];


        Mail::send('hrIssuance', $data,function($message1) use($request)
        {
            $message1
                ->to('ccsijf.apungan@gmail.com')
                ->bcc(['ccsirommel.rinos@gmail.com', 'ccsipimentel.jelene@gmail.com', 'ccsijp.remobatac@gmail.com'])
                ->subject($request->subj);
            $message1
                ->from('notification@ccsi-oims.net','HR Issuance');

            if($request->files_count > 0)
            {
                for($i = 0; $i < $request->files_count; $i++)
                {
                    $fileNow =  $request->file('file-' . $i . '');

                    $message1->attach
                    (
                        $fileNow->getRealPath(),
                        array
                        (
                            'as' => $fileNow->getClientOriginalName(),
                            'mime' => $fileNow->getMimeType()
                        )
                    );

                }
            }
        });
    }
    
    public function admin_ar_notify($form_id)
    {
        $getAr_Notif = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('users as admin_id', 'admin_id.id', '=', 'acknowledge_forms.admin_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'users.name as employee_name',
                'users.email as employee_email',
                'admin_id.name as adminName',
                'admin_id.email as adminEmail',
                'acknowledge_forms.created_at as created_at'
            ])
            ->where('acknowledge_forms.id', $form_id)
            ->get();

        $data =
        [
            'name' => $getAr_Notif[0]->employee_name
        ];

        Mail::send('send_ar_notif', $data, function($message1) use($getAr_Notif)
        {
            $message1
                ->to($getAr_Notif[0]->employee_email)
                ->cc($getAr_Notif[0]->adminEmail)
                ->bcc(['ccsijl.escoto@gmail.com', 'ccsirommel.rinos@gmail.com'])
//                ->subject('OIMS: AR Notification ('.$name.')');
                ->subject('OIMS: AR Notification ('.$getAr_Notif[0]->employee_name.')('. $getAr_Notif[0]->created_at.')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }

    public function adminReceive_ar_notify($form_id)
    {
        $getAReceive_Notif = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('users as admin_id', 'admin_id.id', '=', 'acknowledge_forms.admin_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'users.name as employee_name',
                'users.email as employee_email',
                'admin_id.name as adminName',
                'admin_id.email as adminEmail',
                'acknowledge_forms.created_at as created_at'
            ])
            ->where('acknowledge_forms.id', $form_id)
            ->get();

        $data =
            [
                'name' => $getAReceive_Notif[0]->employee_name
            ];

        Mail::send('receive_ar_notif', $data, function($message1) use($getAReceive_Notif)
        {
            $message1
                ->to($getAReceive_Notif[0]->adminEmail)
                ->cc($getAReceive_Notif[0]->employee_email)
                ->bcc(['ccsijl.escoto@gmail.com', 'ccsirommel.rinos@gmail.com'])
                ->subject('OIMS: AR Notification ('.$getAReceive_Notif[0]->employee_name.')('.$getAReceive_Notif[0]->created_at.')');
            $message1
                ->from('notification@ccsi-oims.net','OIMS NOTIFICATION');
        });
    }
}
