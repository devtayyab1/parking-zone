<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    //
    /**
     * The role that belong to the user.
     */
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function role()
    {
        return $this->hasMany('App\user_roles');
    }
}
