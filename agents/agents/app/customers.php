<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    //
    protected $fillable = ["title","first_name","last_name","email","phone_number","password","postal_code","address","address2","town","status"];
}
