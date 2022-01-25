<?php

use App\TypeOfLoan;
use Illuminate\Database\Seeder;

class TypeOfLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfLoan::insert
        ([
            [
                'type_of_loans' => '----(Undefined)'
            ],
            [
                'type_of_loans' => 'Auto Loan'
            ],
            [
                'type_of_loans' => 'Personal Loan'
            ],
            [
                'type_of_loans' => 'House Loan'
            ]
        ]);
    }
}
