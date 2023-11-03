<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class companies_assign_awards extends Model
{
    //




    public function company()
    {
        return $this->belongsTo(\App\Company::class,"cid","id");

    }

    public function award()
    {
        return $this->hasOne(\App\Awards::class,"id","award_id");

    }
}