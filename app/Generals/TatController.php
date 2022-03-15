<?php
/**
 * Created by PhpStorm.
 * User: Dodong
 * Date: 6/14/2018
 * Time: 2:06 PM
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 1/2/2018
 * Time: 2:58 PM
 */

namespace App\Generals;


use App\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class TatController
{

    public function DateTimeDue_Tat($municipality,$need)
    {

        $timeStamp = Carbon::now('Asia/Manila');
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $tat = DB::table('tat_management')
            ->select([
                'fw_tat',
                'obw_tat',
                'agreed_tat'
            ])
            ->where('client_id',Auth::user()->id)
            ->where('muni_id',$municipality)
            ->get();

//            $get_tat = '';
        $get_tat_day_final = '0000-00-00';
        $get_tat_time_final = '00:00:00';
//
//
//            if(count($tat) != 0)
//            {
//                if($tat[0]->fw_tat == 24)
//                {
//
//                }
//            }
        if(count($tat) == 0)
        {   //default
            $get_tat = '';

            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < (4+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }


                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $days_to_add++;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }

                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY) {
                                $days_to_add++;
                            }

                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }

                if($count == 12)
                {
                    $count++;
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }

            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;
                for($ctr = 0; $ctr < 4; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;
                        $date_time_now= Carbon::now('Asia/Manila');

                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }

                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $day++;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                $get_tat_day_final = $date_tat;
                $get_tat_time_final = $time_tat;

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }

            }

        }
        else
        {
            //if indicated
            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < ($tat[0]->agreed_tat+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $days_to_add++;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }

                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY) {
                                $days_to_add++;
                            }

                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }
                if($count == 12)
                {
                    $count++;
                }
                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }
            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;
                for($ctr = 0; $ctr < $tat[0]->agreed_tat; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;
                        $date_time_now= Carbon::now('Asia/Manila');

                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }

                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $day++;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                if($need == 'date')
                {
                    return  $this->date_due($date_tat);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($time_tat);
                }
                else
                {
                    return null;
                }

            }
        }

    }

    public function DatTimeDue_internal_ci($municipality,$endo_id,$date_time_endorsed)
    {
        $timeStamp = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed);
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];

        $get_client_id = DB::table('endorsement_user')
            ->select('endorsement_id','position_id','user_id')
            ->where('endorsement_id',$endo_id)
            ->where('position_id',6)
            ->first();

        $tat = DB::table('tat_management')
            ->select([
                'fw_tat',
                'obw_tat',
                'agreed_tat'
            ])
            ->where('client_id',$get_client_id->user_id)
            ->where('muni_id',$municipality)
            ->get();


        $get_tat_day_final = '0000-00-00';
        $get_tat_time_final = '00:00:00';

        if(count($tat) == 0)
        {   //default
            $get_tat = '';

            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < (3+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);


                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);


                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }


                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }

                if($count == 12)
                {
                    $count++;
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                return  $this->date_due($get_tat_day_final).' '.$this->time_due($get_tat_time_final);

            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;
                for($ctr = 0; $ctr < 3; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;
                        $date_time_now= Carbon::now('Asia/Manila');


                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                $get_tat_day_final = $date_tat;
                $get_tat_time_final = $time_tat;

                return  $this->date_due($get_tat_day_final).' '.$this->time_due($get_tat_time_final);

            }

        }
        else
        {
            //default
            $get_tat = '';

            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < ($tat[0]->fw_tat+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);


                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);


                        if(Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }


                            if (Carbon::now('Asia/Manila')->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }

                if($count == 12)
                {
                    $count++;
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                return  $this->date_due($get_tat_day_final).' '.$this->time_due($get_tat_time_final);

            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;
                for($ctr = 0; $ctr < $tat[0]->fw_tat; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;
                        $date_time_now= Carbon::now('Asia/Manila');


                        if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::now('Asia/Manila')->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::now('Asia/Manila')->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                $get_tat_day_final = $date_tat;
                $get_tat_time_final = $time_tat;

                return  $this->date_due($get_tat_day_final).' '.$this->time_due($get_tat_time_final);

            }

        }
    }

    public function DateTimeDue_Tat_update($municipality,$need,$date_time_endorsed,$endorsement_id)
    {

        $timeStamp = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed);
        $splitDateTime = explode(" ",$timeStamp);
        $date = $splitDateTime[0];
        $time = $splitDateTime[1];


        $get_client_id = DB::table('endorsement_user')
            ->select('endorsement_id','user_id','position_id')
            ->where('endorsement_id',$endorsement_id)
            ->where('position_id',6)
            ->first();

        $tat = DB::table('tat_management')
            ->select([
                'fw_tat',
                'obw_tat',
                'agreed_tat'
            ])
            ->where('client_id',$get_client_id->user_id)
            ->where('muni_id',$municipality)
            ->get();

//            $get_tat = '';
        $get_tat_day_final = '0000-00-00';
        $get_tat_time_final = '00:00:00';
//
//
//            if(count($tat) != 0)
//            {
//                if($tat[0]->fw_tat == 24)
//                {
//
//                }
//            }
        if(count($tat) == 0)
        {   //default
            $get_tat = '';

            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < (4+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }


                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::now('Asia/Manila')->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $days_to_add++;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }

                            if (Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY) {
                                $days_to_add++;
                            }

                            if (Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }

                if($count == 12)
                {
                    $count++;
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }

            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;
                for($ctr = 0; $ctr < 4; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;
                        $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed);

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day);
                        }

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $day++;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::now('Asia/Manila')->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                $get_tat_day_final = $date_tat;
                $get_tat_time_final = $time_tat;

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }

            }

        }
        else
        {
            //if indicated
            $static = '14:00:59';
            $day = 0;

            if($static < $time)
            {
                //greater than 2pm
                $days_to_add = 1;
                $count = 0;
                for($hour = 0; $hour < ($tat[0]->agreed_tat+8); $hour++)
                {
                    $count++;

                    if($count == 24)
                    {
                        $days_to_add++;
                        $count -= 24;
                        $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $days_to_add++;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $days_to_add++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                    else
                    {
                        $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $days_to_add++;
                            $date_time_now = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                        }

                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0) {
                            if ($check_date_holiday[0]->repeat == 'false') {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0]) {
                                    $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                                }
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;

//                                    return 'no action';
                            } else if ($check_date_holiday[0]->repeat == 'true') {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $days_to_add += ($check_date_holiday[0]->day_difference) + 1;
                            }

                            if (Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SATURDAY) {
                                $days_to_add++;
                            }

                            if (Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add)->dayOfWeek == Carbon::SUNDAY) {
                                $days_to_add++;
                            }
                        }
                    }
                }
                if($count == 12)
                {
                    $count++;
                }
                $timeStamp_tat = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($days_to_add);
                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
//                    $time_tat = $splitDateTime_tat[1];

                $get_tat_day_final = $date_tat;

                $get_tat_time_final = $count.':00:00';

                if($need == 'date')
                {
                    return  $this->date_due($get_tat_day_final);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($get_tat_time_final);
                }
                else
                {
                    return null;
                }
            }
            else if($static >= $time)
            {
                //less than 2pm
                $hour = explode(":",$time)[0];
                $day = 0;

                $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed);

                $explode = explode(' ',$date_time_now);
                $explode_month = explode('-',$explode[0]);

                $check_date_holiday = DB::table('holidays')
                    ->select('repeat','day_difference','start_year')
                    ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                    ->get();

                if(count($check_date_holiday) != 0)
                {
                    if($check_date_holiday[0]->repeat == 'false')
                    {
                        //1 time
                        if($check_date_holiday[0]->start_year == $explode_month[0])
                        {
                            $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                        }
//                                    return 'no action';
                    }
                    else if($check_date_holiday[0]->repeat == 'true')
                    {
                        //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                        $day += ($check_date_holiday[0]->day_difference)+1;
                    }

                    if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                    {
                        $day++;
                    }

                    if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                    {
                        $day++;
                    }
                }


                for($ctr = 0; $ctr < $tat[0]->agreed_tat; $ctr++)
                {
                    $hour++;
                    if($hour == 24)
                    {
                        $hour = 0;
                        $day++;

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day);
                        }

                        if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                        {
                            $day++;
                            $date_time_now= Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day);
                        }
                        //holiday

                        $explode = explode(' ',$date_time_now);
                        $explode_month = explode('-',$explode[0]);

                        $check_date_holiday = DB::table('holidays')
                            ->select('repeat','day_difference','start_year')
                            ->where('start_month','=',$explode_month[1].'-'.$explode_month[2])
                            ->get();

                        if(count($check_date_holiday) != 0)
                        {
                            if($check_date_holiday[0]->repeat == 'false')
                            {
                                //1 time
                                if($check_date_holiday[0]->start_year == $explode_month[0])
                                {
                                    $day +=($check_date_holiday[0]->day_difference)+1;
//                                        return '1 time and add day:'.$check_date_holiday[0]->day_difference;
                                }
//                                    return 'no action';
                            }
                            else if($check_date_holiday[0]->repeat == 'true')
                            {
                                //yearly
//                                    return 'yearly  and add day:'.$check_date_holiday[0]->day_difference;
                                $day += ($check_date_holiday[0]->day_difference)+1;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SATURDAY)
                            {
                                $day++;
                            }

                            if(Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day)->dayOfWeek == Carbon::SUNDAY)
                            {
                                $day++;
                            }
                        }
                        else
                        {
                            //no action
                        }
                    }
                }
                $check_hour = explode(":",$time);
                $save_time = '00:00:00';
                if($check_hour[0] == 12)
                {
                    if($hour == 12)
                    {
                        $save_time = "13:00:00";
                    }
                    else
                    {
                        $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                    }

                }
                else
                {
                    $save_time = $hour.':'.$check_hour[1].':'.$check_hour[2];
                }

                $timeStamp_tat = Carbon::createFromFormat('Y-m-d H:i:s', $date_time_endorsed)->addDay($day);

                $splitDateTime_tat = explode(" ",$timeStamp_tat);
                $date_tat = $splitDateTime_tat[0];
                $time_tat = $save_time;

                if($need == 'date')
                {
                    return  $this->date_due($date_tat);
                }
                else if ($need == 'time')
                {
                    return $this->time_due($time_tat);
                }
                else
                {
                    return null;
                }

            }
        }

    }


    function date_due($date)
    {
        return  $date;
    }

    function time_due($time)
    {
        return  $time;
    }

}