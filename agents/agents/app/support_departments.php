<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class support_departments extends Model
{
    //
    protected $fillable = ["id","name","email"];

    public function tickets()
    {
        return $this->hasMany('App\tickets','id','department');
    }
}
