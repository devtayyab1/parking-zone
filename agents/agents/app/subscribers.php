<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribers extends Model
{
    //
    public $timestamps=false;

    public  function airport(){
        return $this->belongsTo("App\airport","airport_id");
    }
}
