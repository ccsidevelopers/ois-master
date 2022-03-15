<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Generals\Trimmer;

class GeneralAccessController extends Controller
{
    public function generalAccesPanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1)
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

            else if (Auth::user()->hasRole('General Access'))
            {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;
                return view('general_user.general-user-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }
}
