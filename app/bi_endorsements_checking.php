<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bi_endorsements_checking extends Model
{
    //
    public function bi_endorse()
    {
        return $this->belongsTo('App/bi_endorsement');
    }
}
