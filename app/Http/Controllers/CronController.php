<?php

namespace App\Http\Controllers;


//use App\Http\Controllers\Controller;


//use Illuminate\Pagination\LengthAwarePaginator as Paginator;
//use App\airport;
//use App\partners;
//use App\users_roles;
use App\airports_bookings;
//use App\booking_transaction;
//use App\Company;
//use App\User;
//use App\customers;
// use App\modules_settings;
// use App\penalty_details;
// use DateTime;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Input;
// use Illuminate\Support\Facades\Validator;
// use Elibyy\TCPDF\Facades\TCPDF;
// use PDF;
//use View;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Mail;


class CronController extends Controller
{
    public $_setting = [];

    public function __construct()
    {
        // $this->middleware('auth');
        // $modules_settings = modules_settings::all();
        // foreach ($modules_settings as $setting) {
        //     $this->_setting[$setting->name] = $setting->value;
        // }
    }

    // send email notification to incomplete bookings
    function index() {

        //die('here');
        //$bookings = airports_bookings("SELECT * FROM " . $db->prefix . "booking WHERE incomplete_email='0' AND (booking_status = 'Abandon' || booking_status = 'incompleted') AND booking_action = 'Abandon' GROUP BY email");
        $bookings = airports_bookings::all()->where("incomplete_email", "0")->whereIn('booking_status', ['Abandon','incompleted'])->where("booking_action","Abandon");

        foreach($bookings as $booking){
            //  dd($booking);
            //echo $booking['email']."<br/>";
            $bookingz = airports_bookings::all()->where("booking_status", "Completed")->where("booking_action","Booked")->where('id', '>', $booking->id)->where('email',$booking->email);
           
            //$bookingz = $db->get_row("SELECT * FROM " . $db->prefix . "booking WHERE  booking_status = 'Completed' AND booking_action = 'Booked' AND id > '".$booking['id']."' AND email = '".$booking['email']."'");
            if(isset($bookingz->id)){
                echo "<br>".$booking->email."---booked";
                // print_r($bookingz);
                // echo"###";
            }else{
                $id=$booking->id;
                $link='https://www.parkingzone.co.uk/booking/incomplete/'.$id;
                //send email to customer
                 $template_data["link"] ="<a href=".$link." >Click Here</a>";
                 $template_data["username"] ="test";
                echo "<br>".$booking->email."---send email to customer";
                $email_send = new EmailController();
                //$email_send->sendEmail("Update Booking", $request->input("email"), $template_data);
                $toemails = [$booking->email,'bookings@parkingzone.co.uk'];
                $email_send->sendEmail("incomplete booking", $toemails, $template_data);
                $bookingz = airports_bookings::where('id',  $booking->id)->update(['incomplete_email'=>1]);
                //notifications($booking['id'], 'incomplete booking', $booking['email'], '', '', '');                //echo"@@@";
            }
        }
    } // end of function

    // send email notification to incomplete bookings
    function sendmails_mailchimp() {

        $bookings = airports_bookings::all()->where("mailchip_email", "0");

        foreach($bookings as $booking){
 
            $name = $booking->first_name.' '.$booking->last_name==''?'Parkingzone Subscriber':$booking->first_name.' '.$booking->last_name;
            $email = $booking->email;
            //fiveg mailchimp
            try {
                $timeout =20;
                $name_detail = explode(" ",$name);
                //print_r($name_detail);exit;
                $email_address = trim($email);
                $api_endpoint = 'https://us17.api.mailchimp.com/3.0/lists/73d9053859/members/';
                $mailchimp_user_info = array(
                'FNAME' => $name_detail[0],
                'LNAME' => $name_detail[1]
                );
                $data = array(
                'status' => 'subscribed',
                'email_address' => $email_address,
                'merge_fields' => $mailchimp_user_info);
                    
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_endpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/vnd.api+json',
                    'Content-Type: application/vnd.api+json',
                    'Authorization: apikey 2266974a532240839066eacaac47dfc3-us17'
                ));
                curl_setopt($ch, CURLOPT_USERAGENT, 'X-Cart4');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
                //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $response['body']    = curl_exec($ch);
                $response['headers'] = curl_getinfo($ch);
                $response_array = json_decode($response['body'],true);
                if (isset($response['headers']['request_header'])) {
                    $headers = $response['headers']['request_header'];
                }
                //print_r($response_array);
                if ($response['body'] === false) {
                    $last_error = curl_error($ch);
                    //print_r($last_error);
                }

                curl_close($ch);
                //print_r($mailchimp_user_info);
            }
            catch(Exception $e)
            {
                
            }   
            //fivegmailchimp

            $bookingz = airports_bookings::where('id',  $booking->id)->update(['mailchip_email'=>1]);
            //notifications($booking['id'], 'incomplete booking', $booking['email'], '', '', '');                //echo"@@@";
        }
    } // end of function


}
