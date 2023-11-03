<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class airports_terminals extends Model
{
    //
    protected $fillable = ["name","aid"];

    public function bookings()
    {
        return $this->hasMany("App\airports_bookings","airportID");
    }
}
