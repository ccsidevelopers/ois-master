<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Generals\Trimmer;

class QAController extends Controller
{
    public function qa_panel()
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

            else if (Auth::user()->hasRole('Quality Analyst'))
            {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;
                return view('quality_analyst.qa-master', compact('javs'));
            }
            return redirect()->route('privilege-error');
        }
    }

    public function qa_get_auth_view()
    {
        return Auth::user()->authrequest;
    }
}
