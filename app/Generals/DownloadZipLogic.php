<?php
/**
 * Created by PhpStorm.
 * User: Dodong
 * Date: 6/20/2018
 * Time: 2:58 PM
 */

namespace App\Generals;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DownloadZipLogic
{
    public function path_link($id)
    {

        $random = '';

        $ifnull = DB::table('endorsements')
            ->whereNull('link_path')
            ->orwhere('link_path','')
            ->where('id',$id)
            ->count();

        $getLink = DB::table('endorsements')
            ->select(['link_path'])
            ->where('id',$id)
            ->first();

        $acctNme = DB::table('endorsements')
            ->select(['account_name'])
            ->where('id',$id)
            ->first();

        $path = '(Report of ' . $acctNme->account_name . ')-' . Str::random(64) . $id;

        if(File::isDirectory(storage_path('account/'.$id)) || File::isDirectory(storage_path('account_client/'.$id)))
        {
            $random = $id;
        }
        else if($ifnull == 1)
        {
            $replace_slash = str_replace("/",",",$path);

            DB::table('endorsements')
                ->where('id',$id)
                ->update
                ([
                    'link_path' => $replace_slash
                ]);

            $random = $replace_slash;
        }
        else if(strpos($getLink->link_path, "(") !== false)
        {
            $random = $getLink->link_path;
        }
//        else
//        {
//            $random = 'dodong';
//        }

        return $random;

    }
}