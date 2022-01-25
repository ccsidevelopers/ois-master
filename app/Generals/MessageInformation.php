<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 10/15/2018
 * Time: 1:47 PM
 */

namespace App\Generals;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MessageInformation
{
    public function SentMessage($message,$from_user_id,$to_user_id)
    {
        DB::table('message_info')
            ->insert([
                'message'=> $message,
                'from_user_id'=>$from_user_id,
                'to_user_id'=>$to_user_id,
                'from_view'=>'false',
                'to_view'=>'false',
                'all'=>'false',
                'date_time' => Carbon::now('Asia/Manila')
            ]);
    }

    public function GetMessage()
    {

    }
}