<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function timestamps()
    {
        return $this->hasOne('App\Timestamp');
    }

    public function coborrowers()
    {
        return $this->hasMany('App\Coborrower');
    }

    public function employers()
    {
        return $this->hasMany('App\Employer');
    }

    public function businesses()
    {
        return $this->hasMany('App\Business');
    }

    public function notes()
    {
        return $this->hasOne('App\Note');
    }
}
