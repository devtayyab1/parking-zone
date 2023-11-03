<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



use Illuminate\Support\Facades\DB;


use App\airport;



class lounges_bookings extends Model

{
    //

    //protected $fillable = ["airportID","companyId","customerId","edit_by","title","first_name","last_name","email","phone_number","fulladdress","address","address2","town","postal_code","passenger","referenceNo","departDate","deprTerminal","deptFlight","returnDate","returnTerminal","returnFlight","no_of_days","discount_code","created_at","booking_status","payment_status","removed","status","","","","","","","",""];
    public $timestamps = false;



    public function admin(){

        return $this->belongsTo("App\User","admin_id");

    }

    public function airport(){

       return $this->belongsTo("App\airport","airportID");

    }



    public static function getSingleRowById($id){

        return lounges_bookings::where("id",$id)->first();

    }






}

