<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\airport;


class airports_bookings extends Model
{
    //
    protected $fillable = ["airportID","companyId","customerId","edit_by","title","first_name","last_name","email","phone_number","fulladdress","address","address2","town","postal_code","passenger","referenceNo","departDate","deprTerminal","deptFlight","returnDate","returnTerminal","returnFlight","no_of_days","discount_code","","","","","","","","","","","","","",];

    public function company(){
        return $this->belongsTo("App\Company","companyId");
    }
    public function airport(){
       return $this->belongsTo("App\airport","airportID");
    }

    public function admin(){
        return $this->belongsTo("App\User","admin_id");
    }



    public function rterminal(){
        return $this->belongsTo("App\airports_terminals","returnTerminal");
    }

    public function dterminal(){
        return $this->belongsTo("App\airports_terminals","deprTerminal");
    }

    public static function getSingleRowById($id){
        return airports_bookings::where("id",$id)->first();
    }


    public  function getTranscation(){
       // return booking_transaction::where("id",$id)->first();
        return $this->belongsTo("App\booking_transaction","id");

    }
}
