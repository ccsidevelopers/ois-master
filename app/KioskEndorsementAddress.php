<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KioskEndorsementAddress extends Model
{
    protected $table = 'kiosk_endorsement_addresses';
    protected $fillable = [
       'endorsement_id',
       'unit_number_bld_st_subd_brgy',
       'city_municipality',
       'province',
       'address_type'
    ];
}
