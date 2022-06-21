<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 10/15/2018
 * Time: 1:47 PM
 */

namespace App\Generals;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SmsNotification
{
    public function DispatchSmsNotif($number,$message,$apicode)
    {
//        $url = 'https://www.itexmo.com/php_api/api.php';
//        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
//        $param = array(
//            'http' => array(
//                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//                'method'  => 'POST',
//                'content' => http_build_query($itexmo),
//            ),
//        );
//        $context  = stream_context_create($param);
//        return file_get_contents($url, false, $context);

        $ch = curl_init();
        $payload = [
            'Email' => 'oims.notifications@gmail.com',
            'Password' => 'JXGt6v5rpsQ3R5@',
            'Recipients' => [$number],
            'Message' => $message,
            'ApiCode' => 'PR-COMPR617657_F7ELA',
            'SenderId' =>'CCSI OIMS'
        ];

        // $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
        curl_setopt($ch, CURLOPT_URL,"https://api.itexmo.com/api/broadcast");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch);
    }

    public function FundUploadedNotif($id,$sino_ang_gagamitin,$fund_id)
    {

        $get_ci = DB::table('ci_contacts')
            ->select('contact_number','ci_id')
            ->where('ci_id',$id)
            ->get();

        $num = '';

        if(count($get_ci) != 0)
        {
            $num = $get_ci[0]->contact_number;

            if($sino_ang_gagamitin == 'remittance')
            {
                $message = 'this is remittance';

                $get_remit = DB::table('remittance')
                    ->select('remittance_info','amount')
                    ->where('fund_id', $fund_id)
                    ->get();

                if(count($get_remit) != 0)
                {
                    $get_amount = base64_decode($get_remit[0]->amount);
                    $get_remit = preg_replace("<<br>>","\n",$get_remit[0]->remittance_info);

                    $message =  "Good day!\n\n".
                        "Your Fund Request is already uploaded.\n\n".
                        "Type: Remittance\n".
                        "Amount: ".$get_amount."\n\n".
                        "Information:\n".
                        "".$get_remit."\n\n".
                        "To See Full Details, Go to your OIMS Account.";
                }
                else
                {
                    $get_remit = '';
                }
            }
            else if($sino_ang_gagamitin == 'atm')
            {
                $message = 'this is atm';

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
                    $get_amount = $get_atm[0]->amount;
                    $get_atm = $get_atm[0]->atm_name;
                }
                else
                {
                    $get_atm = '';
                }


                $message =  "Good day!\n\n".
                    "Your Fund Request is already uploaded.\n\n".
                    "Type: ATM\n".
                    "Amount: ".$get_amount."\n\n".
                    "Bank: ".$get_atm."\n\n".
                    "To See Full Details, Go to your OIMS Account.";
            }

            $ch = curl_init();
            $payload = [
                'Email' => 'oims.notifications@gmail.com',
                'Password' => 'JXGt6v5rpsQ3R5@',
                'Recipients' => [$num],
                'Message' => $message,
                'ApiCode' => 'PR-COMPR617657_F7ELA',
                'SenderId' =>'CCSI OIMS'
            ];

            // $itexmo = array('1' => $num, '2' => $message, '3' => 'PR-COMPR617657_F7ELA');
            curl_setopt($ch, CURLOPT_URL,"https://api.itexmo.com/api/broadcast");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            return curl_exec ($ch);
            curl_close ($ch);
        }
    }

    public function DispatcherSendMessageToCI($request, $messageToCi)
    {
        $ch = curl_init();
        $payload = [
            'Email' => 'oims.notifications@gmail.com',
            'Password' => 'JXGt6v5rpsQ3R5@',
            'Recipients' => [$request->contact_number],
            'Message' => $messageToCi,
            'ApiCode' => 'PR-COMPR617657_F7ELA',
            'SenderId' =>'CCSI OIMS'
        ];
        // $itexmo = array('1' => $request->contact_number, '2' => $messageToCi, '3' => 'PR-COMPR617657_F7ELA');
        curl_setopt($ch, CURLOPT_URL,"https://api.itexmo.com/api/broadcast");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec ($ch);
        curl_close ($ch);
        return json_decode($result);
    }

    public function AuditFinanceNotifToCI($request, $remarks, $fund_requested)
    {
        $getciNum = DB::table('fund_requests')
            ->join('ci_contacts', 'ci_contacts.ci_id', '=', 'fund_requests.ci_id')
            ->where('fund_requests.id', $request->fund_id)
            ->select([
                'ci_contacts.contact_number as contact_number'
            ])
            ->get();

        if(count($getciNum) > 0)
        {
            $message = '';
            if($remarks == '')
            {
                $remarks = '-';
            }

            $message = "YOU HAVE RECEIVED NOTIFICATION FROM YOUR FUND LIQUIDATION\n\n".
            "FUND ID: ". $request->fund_id . "\n".
            "FUND REQUESTED: ". $fund_requested . "\n".
            "REMARKS: ". $remarks . "\n".
            "SENDER: " . Auth::user()->roles->first()->name;

            $ch = curl_init();
            $payload = [
                'Email' => 'oims.notifications@gmail.com',
                'Password' => 'JXGt6v5rpsQ3R5@',
                'Recipients' => [$getciNum[0]->contact_number],
                'Message' => $message,
                'ApiCode' => 'PR-COMPR617657_F7ELA',
                'SenderId' =>'CCSI OIMS'
            ];
            // $itexmo = array('1' => $getciNum[0]->contact_number, '2' => $message, '3' => 'PR-COMPR617657_F7ELA');
            // curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch, CURLOPT_URL,"https://api.itexmo.com/api/broadcast");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            return curl_exec ($ch);
            curl_close ($ch);
        }
    }

    public function CheckSMSStatus()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://itexmo.com/php_api/serverstatus.php?apicode=PR-COMPR617657_F7ELA");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch);
    }

    public function CheckSMSCredits()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/apicode_info.php?apicode=PR-COMPR617657_F7ELA");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch);
    }

}
