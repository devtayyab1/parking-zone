<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pages extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ["page_title","meet_and_greet","park_and_ride","alluring","alluring_onairport","alluring_meetandgreet","alluring_parkandride","slug","type","typeid","meta_title","meta_keyword","meta_description","status","content"];



    public function airport(){
        return $this->belongsTo("App\airport","typeid");
    }
}
