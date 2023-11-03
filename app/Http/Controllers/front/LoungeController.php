<?php

namespace App\Http\Controllers\front;

use App\airports_bookings;
use App\airports_terminals;
use App\companies_set_price_plan;
use App\customers;
use App\discounts;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\modules_settings;
use App\ref_tracking;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\airport;
use App\hotel_bookings;

use App\lounges_bookings;

use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

//use App\library\stripephp\StripPayment;
//use App\library\payzone\includes\PayzoneGateway;
use App\library\payzone\includes\helpers;
use PharIo\Manifest\Email;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Refund;
use Stripe\Stripe;
use Illuminate\Support\Facades\URL;
use aph_functions;
use App\Company;
use functions;
use App\settings; 
use Illuminate\Support\Facades\Session;

class LoungeController extends Controller
{

    public $_setting = [];
    
   public $stripeKey = "sk_live_G0saAMlNn1AOpBx5yUOG9mAF00ng3Ug5B5";//sk_test_YQQlFuGMcN7VlPh3h6L96TIv00YFcOLI0z
   // public $stripeKey = "sk_test_YQQlFuGMcN7VlPh3h6L96TIv00YFcOLI0z";
    public $currency = "GBP"; 
    
    public $_mysetting = [];

    function __construct()
    {

        $modules_settings = modules_settings::all();
        foreach ($modules_settings as $setting) {
            $this->_setting[$setting->name] = $setting->value;
        }
        $my_settings = settings::all();
        foreach ($my_settings as $my_setting) {
            $this->_mysetting[$my_setting->field_name] = $my_setting->field_value;
        }
    }
    
    
    public function addBookingFormLounge(Request $request)
    {
        
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.booking_lounge", ["data" => $request, "settings" => $this->_setting, "airports" => $airports]);
    }
    
    public function checkBookingLounge(Request $request)
    {
        $lounge_data = $request->all();
        
    	$browser_data = $_SERVER['HTTP_USER_AGENT'];
	    $ip = request()->ip();
	    
        $bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;
        
        $total_amount = ($lounge_data["booking_amount"]*1) + ($bookingfee*1) - ($lounge_data["discount"]*1);
        
        $checkin_date = str_replace('/', '-', $lounge_data['checkin_date']);	
        
        $intent_id = $lounge_data["intent_id"];
        
        $data['lounge_id'] = 0;
        $data['lounge_name'] = $lounge_data["lounge_name"];
        $data['lounge_code'] = $lounge_data["product_code"];
        $data['terminal'] = $lounge_data["terminal"];
        $data['check_in'] = date('Y-m-d', strtotime($checkin_date));
        $data['check_in_time'] = $lounge_data["checkin_time"];
        $data['adults'] = $lounge_data["adults"];
        $data['airportID'] = $lounge_data["airport"];
        $data['children'] = $lounge_data["children"];
        
        $data['booking_fee'] = $bookingfee;
        
        $data['discount_amount'] = $lounge_data["discount"];
        $data['booking_amount'] = $lounge_data["booking_amount"];
        $data['total_amount'] = $total_amount;
        $data['discount_code'] = $lounge_data["promo"];
        
        
        $data['title'] = $request->title;
        $data['first_name'] = $request->firstname;
        $data['last_name'] = $request->lastname;
        $data['email'] = $request->email;
        $data['phone_number'] = $request->contactno;
        
        $data['token'] = $intent_id;
        $data['intent_id'] = $intent_id;
        $data['browser_data'] = $browser_data;
        //$data['user_ip'] = $ip;
        
            
        $data["createdate"] = date("Y-m-d H:i:s");
        $data["modifydate"] = date("Y-m-d H:i:s");
        
       // dd($data);
        $incomplete = $request->incomplete;
        
        $pass = $this->randomPassword();
        $data_cust = array();
        $data_cust['title'] = $request->title;
        $data_cust['first_name'] = $request->firstname;
        $data_cust['last_name'] = $request->lastname;
        $data_cust['email'] = $request->email;
        $data_cust['phone_number'] = $request->contactno;
        
        $data_cust["password"] = md5($pass);
        $data_cust['address'] = '';
        $data_cust['town'] = '';
        
        $data_cust["added_on"] = date("Y-m-d H:i:s");
        $data_cust["update_on"] = date("Y-m-d H:i:s");
            

        $customer_exist = customers::where('email', $request->email)->first();
        if ($customer_exist) {
            $customerData = customers::where('email', $request->email)
                ->update($data_cust);
            $customer_id = $customer_exist->id;

        } else {

            $customerData = customers::updateOrCreate($data_cust);
            $customer_id = $customerData->id;

        }
        
        
        $data['customerId'] = $customer_id;
        
        $referenceNo = $request->reference_no;
        //dd($data);
        if ($referenceNo == '') {
            
            $booking_id = DB::table("lounges_bookings")->insertGetId($data);
            $bookingref = 'PZL-';
            $bookingref .= date("y") . date("m") . date("d");
            
    
            $bookingref = $bookingref . $booking_id;
            $data2["referenceNo"] = $bookingref;
            $referenceNo = $bookingref;
            lounges_bookings::where("id", $booking_id)->update($data2);

        } else {
            $booking = lounges_bookings::where('referenceNo', $referenceNo)->first();
            if ($booking) {
                lounges_bookings::where("referenceNo", $referenceNo)->update($data);
                $booking_id = $booking->id;
            } else {
                $booking_id = 0;
            }
        }
        
        Stripe::setApiKey($this->stripeKey);
        \Stripe\PaymentIntent::update(
            $intent_id,
            [
                'amount' => ($total_amount*100),
            ]
        );
        
        
    	return json_encode(array('booking_id' => $booking_id, 'reference_no' => $referenceNo, 'available' => 'Yes'));
    }
    
    function lounge_checkout(Request $request)
    {
        $airport = $request->input('airport');
        if ($airport == "") {
            $airport = 0;
        }


        $company_id = $request->input('company_id');
        if ($company_id == "") {
            $company_id = 0;
        }
		
		$product_code = $request->input('product_code');


        $total_days = $request->input('total_days');
        if ($total_days == "") {
            $total_days = 0;
        }



        $checkin_date = $request->input('checkin_date');
        $checkin_time = $request->input('checkin_time');
        
        $adult = $request->input('adults');
        $children = $request->input('children');
        
        
        $promo = $request->input('promo');

        $bookingfor = $request->input('bookingfor');
        $pl_id = $request->input('pl_id');
        $sku = $request->input('sku');
        $park_api = $request->input('park_api');

        $smsfee = $request->input('smsfee');
        if ($smsfee == "") {
            $smsfee = "No";
        }

        $canfee = $request->input('canfee');
        if ($canfee == "") {
            $canfee = "No";
        }

        $settings =
        $l_fee = 0;

        $bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;

        $sms_notification = $this->_setting['sms_notification_fee'] > 0 ? $this->_setting['sms_notification_fee'] : 0;
        $cancellation_fee = $this->_setting['cancellation_fee'] > 0 ? $this->_setting['cancellation_fee'] : 0;
        $booking_amount = 0.00;
        $discount_amount = 0.00;

        $total_amount = 0.00;

        
        if($park_api == 'holiday'){
            $aph_functions = new aph_functions();            
        
            $booking_amount = $aph_functions->HolidayBookingLoungePrice($product_code, $checkin_date, $checkin_time, $adult, $children);
        }

        //$booking_amount = $this->check_extra($company_id, $pl_id, $booking_amount);
        if ($promo != '') {
            $dis = new discounts();
            $discount_amount = $dis->getPromoDiscount($promo, $booking_amount, 'airport_lounges','');
			//dd($discount_amount);
        }

        $total_amount = ($booking_amount * 1) + ($bookingfee * 1) - ($discount_amount * 1);


        if ($smsfee == 'Yes') {
            $total_amount = $total_amount + ($sms_notification * 1);
            $output['sms_notification'] = $this->priceFormat($sms_notification * 1, false);
        }
        if ($canfee == 'Yes') {
            $total_amount = $total_amount + ($cancellation_fee * 1);
            $output['cancellation_fee'] = $this->priceFormat($cancellation_fee * 1, false);
        }
        if ($l_fee > 0) {
            $total_amount = $total_amount + ($l_fee * 1);
            $output['l_fee'] = $this->priceFormat($l_fee * 1, false);
        }
        
        $intent_secret='';
        if($intent_secret=='')
        {      
            
            Stripe::setApiKey($this->stripeKey);
            $intent = \Stripe\PaymentIntent::create([
                'amount' => ($total_amount*100),
                'currency' => 'gbp',
            ]);
            Session::put('intent_id',$intent->id);
             Session::put('intent_secret',$intent->client_secret);
    
           
            $intent_secret = $intent->client_secret;
            $intent_id = $intent->id;
        }
        else
        {
            \Stripe\PaymentIntent::update(
                $intent_id,
                [
                    'amount' => ($total_amount*100),
                ]
            );
        }

		
        $output['total_amount'] = $this->priceFormat($total_amount, false);
        $output['booking_amount'] = $booking_amount;
        $output['discount_amount'] = $this->priceFormat($discount_amount, false);
        $output['booking_fee'] = $this->priceFormat($bookingfee, false);
		$output['company_name'] = '';
        $output['intent_id'] =$intent->id;
        $output['intent_secret'] = $intent->client_secret;
        return response($output);

    }
    
    
    public function payout_lounge(Request $request)
    {

        $booking_id = $request->input("booking_id");
        $reference_no = $request->input("reference_no");
		$park_api = $request->input('park_api');
        $resp=$request->input('result');
        $resp=json_encode($resp);
        $resp=json_decode($resp);
		//$booking = lounges_bookings::where("id",$booking_id)->first();

        if($park_api == 'holiday'){
            $holidayorder = $this->bookOnHoliday($request);
            $ext_ref = isset($holidayorder['BookingRef']) ? $holidayorder['BookingRef'] : '';
            $url = isset($holidayorder['MoreInfoURL']) ? $holidayorder['MoreInfoURL'] : '';
            $aphData['referenceNo_ext'] = $ext_ref;
            $aphData['referenceLink_ext'] = $url;
            lounges_bookings::where("referenceNo", $reference_no)->update($aphData);
        }
        
        $this->update_booking_payment($request, $resp, "stripe");
        echo json_encode($this->getResponse(1, "payment successfully charged"));


    }
    
    public function payout_failed_lounge(Request $request)
    {

        $booking_id = $request->input("booking_id");
        $reference_no = $request->input("reference_no");
		$park_api = $request->input('park_api');
        $resp=$request->input('result');
        $resp=json_encode($resp);
        $resp=json_decode($resp);
		$booking = lounges_bookings::where("id",$booking_id)->first();

        if($park_api == 'holiday'){
            $holidayorder = $this->bookOnHoliday($request);
            $ext_ref = isset($holidayorder['BookingRef']) ? $holidayorder['BookingRef'] : '';
            $url = isset($holidayorder['MoreInfoURL']) ? $holidayorder['MoreInfoURL'] : '';
            $aphData['referenceNo_ext'] = $ext_ref;
            $aphData['referenceLink_ext'] = $url;
            lounges_bookings::where("referenceNo", $reference_no)->update($aphData);
        }
        
        $this->update_booking_payment($request, $resp, "stripe");
        echo json_encode($this->getResponse(1, "payment successfully charged"));
    }
    
    public function update_booking_payment($request, $paymentresponse, $payment_type)
    {
        $data = [];

        $bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;

        $data["booking_fee"] = $bookingfee;
        $data["discount_code"] = $request->input("promo");


        $data["cancelfee"] = $request->input("cancelfee");
        $data["smsfee"] = $request->input("smsfee");
        $data["payment_status"] = "success";
        $data["payment_method"] = $payment_type;
        
        $data["booking_status"] = "completed";
        $data["booking_action"] = "Booked";
         
        if ($payment_type == "stripe") {
            $data["api_res"] =json_encode($paymentresponse);
            $data["PayerID"] = $paymentresponse->paymentIntent->id;
        }

        DB::table('lounges_bookings')
            ->where('referenceNo', $request->input("reference_no"))
            ->update($data);

        $this->submitTransaction($request->input("reference_no"));
        
		$row = DB::table('lounges_bookings')->where('referenceNo', $request->input("reference_no"))->first();
       
        $airport_detail = airport::where("id",$request->input("airport"))->first();
        
						

        $template_data = [];
		//$template_data["guidence"] = $directions;
        $template_data["username"] = $request->input("firstname") . " " . $request->input("lastname");
        $template_data["email"] = $request->input("email");
        $template_data["telephone"] = $request->input("contactno");
        $template_data["lounge_name"] = $request->input("lounge_name");
        $template_data["company"] = 'Holiday Extra';
        $template_data["airport"] = $airport_detail->name;
        
        $template_data["start_date"] = $request->input("checkin_date") . " " . $request->input("checkin_time");
        $template_data["booktime"] = date("Y-m-d H:i:s");
        $template_data["terminal"] = 'Terminal '.$request->input("terminal");
        $template_data["ext_ref"] = $request->input("registration");
        $template_data["model"] = $request->input("model");
        $template_data["make"] = $request->input("make");
        $template_data["color"] = $request->input("color");
        $template_data["payment_gatway"] = $payment_type;
        $template_data["payment_status"] = "success";
        $template_data["price"] = $row->total_amount;
        $template_data["addtionalprice"] = 0;
        $template_data["ref"] = $request->input("reference_no");
        
        $template_data["ext_ref"] = $row->referenceNo_ext;
        
        $email_send = new EmailController(); 
        $toemails = [$request->input("email"),'bookings@parkingzone.co.uk'];  
        
        $email_send->sendEmail("Client Lounge booking", $toemails, $template_data);
            
        //$email_send->sendEmail("Admin Lounge Booking",'bookings@parkingzone.co.uk', $template_data);
		
        //$email_send->sendEmail("Add Booking Company", $company_data->company_email, $template_data);  
        
        
        $smsfee = $request->input("smsfee");
        
        //if ($smsfee>0) {
           //$functions = new functions();
           //$functions->send_sms($request->input("contactno"), $request->input("reference_no"));
         //}

        return true;
        //return redirect()->route('thankyou');


    }
    public function submitTransaction($ref_no)
    {
       // echo $ref_no;
        $order_detail = lounges_bookings::where("referenceNo",$ref_no)->first();
        //dd($order_detail);
        $d = [];
        $d["orderID"] = $order_detail->id;
        $d["token"] = $order_detail->PayerID;
        $d["referenceNo"] = $ref_no;
        $d["loungeID"] = 0;
        $d["booking_amount"] =$order_detail->booking_amount;
        $d["extra_amount"]=$order_detail->extra_amount;
        $d["discount_amount"] = $order_detail->discount_amount;
        $d["smsfee"] = $order_detail->smsfee;
        $d["booking_fee"] = $order_detail->booking_fee;
        $d["cancelfee"] = $order_detail->cancelfee;
        $d["total_amount"] = $order_detail->total_amount;
        $d["payable"] = 0;
        $d["amount_type"] = "credit";
        $d["payment_method"] =$order_detail->payment_method;
        $d["payment_action"] = $order_detail->payment_status;
        $d["booking_status"] = $order_detail->booking_status;

        DB::table('lounges_transaction')
            ->insert($d);
        return true;
    }
    function priceFormat($price, $symbol = true)
    {
        $formated_price = '';
        if ($symbol) {
            $formated_price .= '&pound;';
        }
        $formated_price .= number_format(((float)$price * 1), 2);
        return $formated_price;
    }
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public function thankyou($id)
    {
        $airports = airport::all()->where("status", "Yes");

        $booking =  lounges_bookings::where("referenceNo",$id)->first();
        
        $airport_detail = airport::where("id", $booking->airportID)->first();

        return view("frontend.thankyou_lounge", ["airports" => $airports, "booking"=>$booking, "airport_detail"=>$airport_detail]);

    }
    public function bookOnHoliday($request) {

        $reference_no = $request->input("reference_no");
        //dd($reference_no);
        $booking =  lounges_bookings::where("referenceNo",$reference_no)->first();
        
		$product_code = $request->input("product_code");
        
        $booking_amount = $booking->booking_amount;


        $ArrivalDate = date('Y-m-d', strtotime($booking->check_in));
        $ArrivalTime = date("Hi",strtotime($booking->check_in_time)); 

        $adults = $booking->adults;
        $children = $booking->children;
        

        $title = $request->input("title");
        $first_name = $request->input("firstname");
        $last_name = $request->input("lastname");
        $phone_number = $request->input("contactno");
        $email = $request->input("email");

        $aph_functions = new aph_functions();

        $string = "&ArrivalDate=".$ArrivalDate."&ArrivalTime=".$ArrivalTime."&Adults=".$adults."&Children=".$children."&Infants=0";
        $string .= "&Title=".$title."&Initial=".$first_name."&Surname=".$last_name."&Address=NA&Town=NA&County=NA&PostCode=NA";
                
        $string .= "&Email=".$email."&MobileNum=".$phone_number."&PriceCheckFlag=Y&PriceCheckPrice=".$booking_amount;
        
        $aphorder = $aph_functions->HolidayBookingOrderLounge($string, $product_code);
        return $aphorder;
    }
    public function getResponse($success, $data)
    {
        $res = array();
        $res['success'] = $success;
        $res['data'] = $data;
        return $res;
    }
}

?>