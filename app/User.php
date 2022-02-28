<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function endorsements()
    {
        return $this->belongsToMany('App\Endorsement')->withPivot(['position_id','province_id']);
    }

    public function provinces()
    {
        return $this->belongsToMany('App\Province');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate');
    }
}