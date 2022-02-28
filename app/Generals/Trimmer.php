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

class Trimmer
{

    public function trims($totrim)
    {
        $stringacct = strtoupper($totrim);
        $stringaccttrimmed = "";
        for($ctr = 0; $ctr < strlen($stringacct); $ctr++)
        {
            if(substr($stringacct,strlen($stringacct)-$ctr,0)!=" ")
            {
                $stringaccttrimmed = ltrim(substr($stringacct,0,strlen($stringacct)-$ctr));
                $ctr = strlen($stringacct);
            }
        }
        return preg_replace('/\s+/', ' ',rtrim($stringaccttrimmed));
    }

    public function trim_not_big($totrim)
    {
        $stringacct = $totrim;
        $stringaccttrimmed = "";
        for($ctr = 0; $ctr < strlen($stringacct); $ctr++)
        {
            if(substr($stringacct,strlen($stringacct)-$ctr,0)!=" ")
            {
                $stringaccttrimmed = ltrim(substr($stringacct,0,strlen($stringacct)-$ctr));
                $ctr = strlen($stringacct);
            }
        }
        return preg_replace('/\s+/', ' ',rtrim($stringaccttrimmed));
    }

}