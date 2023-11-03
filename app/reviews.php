<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    //
    protected $fillable = ["type","admin_id","type_id","ref","username","email","rating","review","status","type","count","google_count"];



    public function user(){
        return $this->belongsTo("App\User","admin_id");
    }

    public function airport(){
        return $this->belongsTo("App\airport","type_id");
    }

    public function company(){
        return $this->belongsTo("App\Company","type_id");

    }

}
