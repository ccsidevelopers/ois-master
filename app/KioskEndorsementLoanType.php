<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KioskEndorsementLoanType extends Model
{
    protected $table = 'kiosk_endorsement_loan_types';
    protected $fillable = [
        'endorsement_id',
        'motorcycle_loan',
        'personal_salary_loan',
        'auto_loan',
        'home_house_loan',
    ];
}
