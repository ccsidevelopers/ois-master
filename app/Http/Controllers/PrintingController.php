<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Jimmyjs\ReportGenerator\ReportMedia\ExcelReport;
use Jimmyjs\ReportGenerator\ReportMedia\PdfReport;

class PrintingController extends Controller
{
    public function GenReport()
    {

        $fromDate = '2017-11-20 02:12:38';
        $toDate = '2018-03-01 00:47:32';
//        $sortBy = 'DESC';

        // Report title
        $title = 'Endorsement Account';

        // For displaying filters description on header
        $meta = [
            'Created on' => $fromDate,
            'To' => $toDate
        ];

        // Do some querying..
        $queryBuilder = DB::table('endorsements')
            ->join('timestamps','timestamps.endorsement_id','=','endorsements.id')
            ->select('account_name','address','citY_muni','provinces','type_of_loan','date_endorsed','time_endorsed','time_dispatcher','time_srao','time_ci','time_ao','date_endorsed')
            ->where('type_of_request','PDRN');
//            User::select(['name', 'email', 'type_of_user']);



        // Set Column to be displayed
        $columns =
            [
                'Date Endorsed' => 'date_endorsed',
                'Account Name' => 'account_name',
                'Address' => 'address',
                'City/Municipality' => 'citY_muni',
                'Province' => 'provinces',
                'Time Dispatcher' => 'time_dispatcher',
                'Time Senior Account Officer' => 'time_srao',
                'Time Credit Investigator' => 'time_ci',
                'Time Account Officer' => 'time_ao',
            ];

        /*
            Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).

            - of()         : Init the title, meta (filters description to show), query, column (to be shown)
            - editColumn() : To Change column class or manipulate its data for displaying to report
            - editColumns(): Mass edit column
            - showTotal()  : Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
            - groupBy()    : Show total of value on specific group. Used with showTotal() enabled.
            - limit()      : Limit record to be showed
            - make()       : Will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        */
        $pdfreport = new ExcelReport();
//        $pdfreport = new PdfReport();

        return $pdfreport->of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Date Endorsed', [
                'class' => 'left bold',
                'displayAs' => function ($result) {
                    return $result->date_endorsed;
                }
            ])
            ->editColumn('Account Name', [
                'class' => 'left bold',
                'displayAs' => function ($result) {
                    return $result->account_name;
                }
            ])
            ->editColumn('Address', [
                'displayAs' => function ($result) {
                    return $result->address;
                }
            ])
            ->editColumn('City/Municipality', [
                'displayAs' => function ($result) {
                    return $result->citY_muni;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->editColumn('Province', [
                'displayAs' => function ($result) {
                    return $result->provinces;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->editColumn('Time Dispatcher', [
                'displayAs' => function ($result) {
                    return $result->time_dispatcher;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->editColumn('Time Senior Account Officer', [
                'displayAs' => function ($result) {
                    return $result->time_srao;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->editColumn('Time Credit Investigator', [
                'displayAs' => function ($result) {
                    return $result->time_ci;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->editColumn('Time Account Officer', [
                'displayAs' => function ($result) {
                    return $result->time_ao;
                }// if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->setCss([
                '.head-content' => 'border-width: 1px',
            ])
            ->setOrientation('landscape')

//            ->make()
//            ->getDomPDF()
//            ->output_html();
//            ->stream();
            ->download('dodong'); // or download('filename here..') to download pdf
    }

}
