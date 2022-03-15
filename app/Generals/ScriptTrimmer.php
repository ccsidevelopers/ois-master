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

class ScriptTrimmer
{
    public function scripttrim($passage)
    {

        $passage = str_replace('<','',$passage);
        $passage = str_replace('>','',$passage);

        return $passage;
    }

    public function scripttrimwithbr($passage)
    {

        $passage = str_replace('<br>','|-|-|',$passage);
        $passage = str_replace('<','',$passage);
        $passage = str_replace('>','',$passage);
        $passage = str_replace('|-|-|','<br>',$passage);


        return $passage;
    }

}