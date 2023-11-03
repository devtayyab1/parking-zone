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
use App\pages;

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
class BookingController extends Controller
{

    public $_setting = [];
    public $stripeKey = "sk_live_G0saAMlNn1AOpBx5yUOG9mAF00ng3Ug5B5";
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

  function getPagebySlug(){
        $url =  explode("/",URL::full());
       
        $page =  pages::where("slug", $url[3])->where("type", "main")->first();
        if($page){ return $page; }
        else { $page = (object) $page;
        
             $page->meta_title = "";
             $page->meta_keyword = "";
             $page->meta_description = "";
             return $page;

        }
    }

    function checkBooking(Request $request)
    {
       
        // $validate = $request->validate(['email' => 'required|unique:customers,email,' . $request->input('email') ]);


        $title = $request->input('title');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $contactno = $request->input('contactno');
        $fulladdress = $request->input('fulladdress2');
        $address = $request->input('address');
        $address2 = $request->input('address2');
        $town = $request->input('town');
        $postcode = $request->input('postcode');
        $passenger = $request->input('passenger');
        $incomplete = $request->input('incomplete');
        $booking_id = $request->input('booking_id');
        $park_api = $request->input('park_api');


        $departterminal = $request->input('departterminal');
        if ($departterminal == '') {
            $departterminal = 'TBA';
        }


        $arrivalterminal = $request->input('arrivalterminal');
        if ($arrivalterminal == '') {
            $arrivalterminal = 'TBA';
        }


        $flightnumber = $request->input('flightnumber');
        if ($flightnumber == '') {
            $flightnumber = 'TBA';
        }


        $returnflight = $request->input('returnflight');
        if ($returnflight == '') {
            $returnflight = 'TBA';
        }


        // $flightnumber = isset($request->input('flightnumber')) ? $request->input('flightnumber') : 'TBA';
        // $returnflight = isset($request->input('returnflight')) ? $request->input('returnflight') : 'TBA';
        //$referenceNo = isset($request->input('reference_no')) ? $request->input('reference_no') : '';
        $referenceNo = $request->input('reference_no');

        $color = $request->input('color');
        if ($color == '') {
            $color = 'TBA';
        }


        $model = $request->input('model');
        if ($model == '') {
            $model = 'TBA';
        }


        $make = $request->input('make');
        if ($make == '') {
            $make = 'TBA';
        }

        $registration = $request->input('registration');
        if ($registration == '') {
            $registration = 'TBA';
        }

//        $make = isset($request->input('make')) ? $request->input('make') : 'TBA';
//        $model = isset($request->input('model')) ? $request->input('model') : 'TBA';
//        $color = isset($request->input('color')) ? $request->input('color') : 'TBA';
//        $registration = isset($request->input('registration')) ? $request->input('registration') : 'TBA';


        //$company_id = isset($request->input('company_id')) ? $request->input('company_id') : 0;
        $company_id = $request->input('company_id');
        if ($company_id == '') {
            $company_id = 0;
        }
		$product_code = $request->input('product_code');
		
        $parking_type = $request->input('parking_type');

		
        $dropdate = $request->input('dropdate');
        $pickdate = $request->input('pickdate');
        $droptime = $request->input('droptime');
        $picktime = $request->input('picktime');
        $total_days = $request->input('total_days');
        // $airport = isset($request->input('airport')) ? $request->input('airport') : 0;

        $airport = $request->input('airport');
        if ($airport == '') {
            $airport = 0;
        }

        $bookingfor = $request->input('bookingfor');
        $promo = $request->input('promo');
        $smsfee = $request->input('smsfee');
        if ($smsfee == '') {
            $smsfee = 'No';
        }

        $cancelfee = $request->input('cancelfee');
        if ($cancelfee == '') {
            $cancelfee = 'No';
        }
//        $smsfee = isset($request->input('smsfee')) ? $request->input('smsfee') : 'No';
//        $cancelfee = isset($request->input('cancelfee')) ? $request->input('cancelfee') : 'No';
        $departDate = date('Y-m-d H:i:s', strtotime($dropdate . " " . $droptime));
        $returnDate = date('Y-m-d H:i:s', strtotime($pickdate . " " . $picktime));


        //  $passenger = isset($request->input('passenger')) ? $request->input('passenger') : 1;
        $passenger = $request->input('passenger');
        if ($passenger == '') {
            $passenger = 1;
        }


        $pl_id = $request->input('pl_id');
        if ($pl_id == '') {
            $pl_id = 0;
        }


        //$pl_id = isset($request->input('pl_id')) ? $request->input('pl_id') : 0;
        $sku = $request->input('sku');
        $edin_active = $request->input('edin_active');
        $speed_park_active = $request->input('speed_park_active');
        $site_codename = $request->input('site_codename');


        $ArrivalDate = date('dMy', strtotime($dropdate));
        $DepartDate = date('dMy', strtotime($pickdate));
        $ArrivalTime = date("Hi", strtotime($droptime));
        $DepartTime = date("Hi", strtotime($picktime));


        $l_fee = $this->get_company_levy($company_id);

        //$bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;

        $bookingfee = $request->input('booking_fee');
        //dd($bookingfee);
        if ($bookingfee < 1) {
            $bookingfee = 0;
        }
//        $sms_notification = $this->_setting['sms_notification_fee'] > 0 ? $this->_setting['sms_notification_fee'] : 0;
//        $cancellation_fee = $this->_setting['cancellation_fee'] > 0 ? $this->_setting['cancellation_fee'] : 0;
        $sms_notification = $request->input('sms_notification_fee');
        //dd($sms_notification);
        if ($sms_notification < 1) {
            $sms_notification = 0;
        }

        $cancellation_fee = $request->input('cancellation_fee');
        if ($cancellation_fee < 1) {
            $cancellation_fee = 0;
        }

        $aphactive = $request->input('aphactive');

        $booking_amount = $this->APBookingPrice($company_id, $airport, $total_days, $dropdate);
		$company_detail = company::where("id",$company_id)->first();
        if ($aphactive==1) {
            $aph_functions = new aph_functions();            
            //$api = new \api();
            $companycode = $company_detail->aph_id;
            $booking_amount = $aph_functions->AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$companycode,$passenger,$product_code);
        }

        if($park_api == 'global'){
            $booking_amount = $request->input('total_amount');
        }
        if($park_api == 'Opitech'){
            $booking_amount = $request->input('total_amount');
        }
        if($park_api == 'holiday'){
            $aph_functions = new aph_functions();            
            //$api = new \api();
            
            $companycode = $company_detail->company_code;
            $booking_amount = $aph_functions->HolidayBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$companycode,$passenger,$product_code);
        }
        
        $extra_amount = $this->extra_amount($company_id, $pl_id);
        $booking_amount_for = $this->check_extra($company_id, $pl_id, $booking_amount);


        $customer_id = 0;
        $smsfee_charged = 0;
        $cancelfee_charged = 0;
        $discount_amount =  $request->input('discount');
        $total_amount = ($booking_amount * 1) + ($bookingfee * 1) + ($extra_amount * 1) - ($discount_amount * 1);

        if ($l_fee > 0) {
            $total_amount = $total_amount + ($l_fee * 1);
            $l_fee = $l_fee * 1;
        }
        if ($smsfee == 'Yes') {
            $total_amount = $total_amount + ($sms_notification * 1);
            $smsfee_charged = $sms_notification * 1;
        }
        if ($cancelfee == 'Yes') {
            $total_amount = $total_amount + ($cancellation_fee * 1);
            $cancelfee_charged = $cancellation_fee * 1;
        }
    $discount_amount =  $request->input('discount');
//        if (Auth::check()) {
//            $customer_id = Auth::user()->id();
//        } else {
        if ($incomplete == 'yes') {
            $pass = $this->randomPassword();
            $data = array();
            $data["title"] = $title;
            $data["first_name"] = $firstname;
            $data["last_name"] = $lastname;
            $data["phone_number"] = $contactno;
            $data["password"] = md5($pass);
            $data["address"] = $address;
            $data["address2"] = $address2;
            $data["town"] = $town;
            $data["added_on"] = date("Y-m-d H:i:s");
            $data["update_on"] = date("Y-m-d H:i:s");
            $data["email"] = $email;

            $customer_exist = customers::where('email', $request->input('email'))->first();
            if ($customer_exist) {
                $customerData = customers::where('email', $email)
                    ->update($data);
                $customer_id = $customer_exist->id;
                

            } else {

                $customerData = customers::updateOrCreate($data);
                $customer_id = $customerData->id;

            }
        }
        //}
      //dd($discount_amount);
        $browser_data = $_SERVER['HTTP_USER_AGENT'];
        $ip = request()->ip();
        $_current_time = date('Y-m-d H:i:s');
        $days_ago = date('Y-m-d H:i:s', strtotime('-1 days', strtotime($_current_time)));

        if ($incomplete == 'yes') {
            $data = [];
            $data["airportID"] = $airport;
            $data["customerId"] = $customer_id;
            $data["companyId"] = $company_id;
			$data["product_code"] = $product_code;
            $data["title"] = $title;
            $data["first_name"] = $firstname;
            $data["last_name"] = $lastname;
            $data["email"] = $email;
            $data["phone_number"] = $contactno;
            $data["fulladdress"] = $fulladdress;
            $data["address"] = $address;
            $data["address2"] = $address2;
            $data["town"] = $town;
            $data["postal_code"] = $postcode;
            $data["passenger"] = $passenger;
            $data["departDate"] = $departDate;
            $data["deprTerminal"] = $departterminal;
            $data["deptFlight"] = $flightnumber;
            $data["returnDate"] = $returnDate;
            $data["returnFlight"] = $returnflight;
            $data["returnTerminal"] = $arrivalterminal;
            $data["no_of_days"] = $total_days;
            $data["discount_code"] = $promo;
            $data["discount_amount"] = $discount_amount;
            $data["booking_amount"] = $booking_amount;
            $data["booking_extra"] = $extra_amount;
            $data["smsfee"] = $smsfee_charged;

            $data["booking_fee"] = $bookingfee;
            $data["cancelfee"] = $cancelfee_charged;
            $data["total_amount"] = $total_amount;
            $data["leavy_fee"] = $l_fee;
            $data["booked_type"] = $parking_type;

            $data["make"] = $make;
            $data["model"] = $model;
            $data["color"] = $color;
            $data["registration"] = $registration;
            $data["park_api"] = $park_api;

            // $tracking = ref_tracking::where("user_ip",$ip)->where("is_internal_url","1")->where("created_at",date("Y-m-d"))->first();

            // if($tracking){
            //     $m_source = $tracking->m_source;
            //     $data["traffic_src"]=$m_source;
            // }else {
            //     $data["traffic_src"]="ORG";
            // }
            // $data["traffic_src"] = isset($request->src) ? $request->src: 'ORG';
            if(session()->get('bk_src') != ''){
                
                $data["traffic_src"] = session()->get('bk_src');
            }else {
                $data["traffic_src"]="ORG";
            }
            $data["user_ip"] = $ip;
            // $today_incomplete = airports_bookings::where('email', $request->input('email'))->first();
            // $today_incomplete = $today_incomplete->created_at;
            // $today_incomplete = date("Y-m-d", strtotime($today_incomplete));
            
            $referenceNo = airports_bookings::where('email', $request->input('email'))->where('booking_action','Abandon')->where('created_at','>',$days_ago)->first();
            $referenceNo = $referenceNo['referenceNo'];
    
            if ($referenceNo == '') {
                //$booking = airports_bookings::create($data)->toSql();
                $booking_id = DB::table("airports_bookings")->insertGetId($data);

//                $booking_id = $booking->id;
            } else {
                $booking = airports_bookings::where('referenceNo', $referenceNo)->first();
                if ($booking) {
                    airports_bookings::where("referenceNo", $referenceNo)->update($data);
                    $booking_id = $booking->id;
                } else {
                    $booking_id = 0;
                }
            }
            $bookingref = 'PZ-';
            $bookingref .= date("y") . date("m") . date("d");
            //$bookingref = $bookingref.substr($_bookID, -3);

            $bookingref = $bookingref . $booking_id;
            $data = [];
            $data["referenceNo"] = $bookingref;
            airports_bookings::where("id", $booking_id)->update($data);
        }

        $data = [];
        $data["booking_id"] = $booking_id;
        if ($referenceNo == "") {
            $data["referenceNo"] = $bookingref;
        } else {
            $data["referenceNo"] = $referenceNo;
        }
        $data["available"] = "Yes";
        return response($data);


        //dd($customer_exist);

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



    function checkout(Request $request)
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


        $dropdate = $request->input('dropdate');

        $pickdate = $request->input('pickdate');
        $droptime = $request->input('droptime');
        $picktime = $request->input('picktime');
        $passenger = $request->input('passenger');
        if ($passenger == "") {
            $passenger = 1;
        }

        $cars = $request->input('cars');
        if ($cars == "") {
            $cars = 1;
        }
        $promo = $request->input('promo');

        $bookingfor = $request->input('bookingfor');
        $pl_id = $request->input('pl_id');
        $sku = $request->input('sku');


        $ArrivalDate = date('dMy', strtotime($dropdate));
        $DepartDate = date('dMy', strtotime($pickdate));
        $ArrivalTime = date("Hi", strtotime($droptime));
        $DepartTime = date("Hi", strtotime($picktime));

        $smsfee = $request->input('smsfee');
        if ($smsfee == "") {
            $smsfee = "No";
        }

        $canfee = $request->input('canfee');
        if ($canfee == "") {
            $canfee = "No";
        }

        $settings =
        $l_fee = $this->get_company_levy($company_id);

        $bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;

        $sms_notification = $this->_setting['sms_notification_fee'] > 0 ? $this->_setting['sms_notification_fee'] : 0;
        $cancellation_fee = $this->_setting['cancellation_fee'] > 0 ? $this->_setting['cancellation_fee'] : 0;
        $booking_amount = 0.00;
        $discount_amount = 0.00;

        $total_amount = 0.00;

        $aphactive = $request->input('aphactive');

        $booking_amount = $this->APBookingPrice($company_id, $airport, $total_days, $dropdate);
		$company_detail = company::where("id",$company_id)->first();
        if ($aphactive==1) {
            $aph_functions = new aph_functions();            
            //$api = new \api();
            
            $companycode = $company_detail->aph_id;
            $booking_amount = $aph_functions->AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$companycode,$passenger,$product_code);
        }
        
        $park_api = $request->input('park_api');
        if($park_api == 'global'){
            $booking_amount = $request->input('total_amount') - $bookingfee;
        }
        if($park_api == 'Opitech'){
            $booking_amount = $request->input('total_amount') - $bookingfee;
        }
        if($park_api == 'holiday'){
            $aph_functions = new aph_functions();    
            $companycode = $company_detail->company_code;
            $booking_amount = $aph_functions->HolidayBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$companycode,$passenger,$product_code);
        }

        $booking_amount = $this->check_extra($company_id, $pl_id, $booking_amount);
        if ($promo != '') {
            $dis = new discounts();
            $discount_amount = $dis->getPromoDiscount($promo, $booking_amount, $bookingfor, $company_id);
			//dd($discount_amount);
        }

        $total_amount = ($booking_amount * 1) + ($bookingfee * 1) - ($discount_amount * 1);

        //$total_amount = ($bookingfee*1) - ($discount_amount*1);
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
        // \Stripe\Stripe::setApiKey('sk_test_YQQlFuGMcN7VlPh3h6L96TIv00YFcOLI0z');
         
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
		$output['company_name'] = $company_detail->name;
        $output['intent_id'] =$intent->id;
        $output['intent_secret'] = $intent->client_secret;
        return response($output);

    }


    function extra_amount($cid, $pid = '')
    {
        if ($pid != "") {
            $plain_price = DB::table('companies_set_price_plans')->where('cid', $cid)->where("id", $pid)->first();
        } else {
            $plain_price = DB::table('companies_set_price_plans')->where('cid', $cid)->first();
        }


        $extra = 0.00;
        if ($plain_price) {
            return $plain_price->extra;
        } else {
            return $extra;
        }


//        global $db;
//        $extra = $db->get_row("SELECT extra from " . $db->prefix . "airport_price_plan where id = '".$pid."' and company_id = '".$cid."'");
//        $extra = ($extra['extra']*1);
//        $extra = number_format($extra, 2, '.', '');
//        return $extra;
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


    function check_extra($cid, $pid, $amount)
    {
//        global $db;
//        $amount_total = $db->get_row("SELECT extra from " . $db->prefix . "airport_price_plan where id = '".$pid."' and company_id = '".$cid."'");
//        $amount_total = ($amount_total['extra']*1)+($amount*1);
//        $amount_total = number_format($amount_total, 2, '.', '');
//        return $amount_total;


        $plain_price = DB::table('companies_set_price_plans')->where('cid', $cid)->where("id", $pid)->first();
        if ($plain_price) {
            $amount_total = ($plain_price->extra * 1) + ($amount * 1);
            $amount_total = number_format($amount_total, 2, '.', '');
            return $amount_total;
        } else {
            return $amount;
        }

        //dd($plain_price);

    }

    function get_company_levy($company_id)
    {
        $company_levy = DB::table('companies')->where('id', $company_id)->first();
        return $company_levy->extra_charges;
    }


    function APBookingPrice($cid, $aid, $no_of_days, $checkindate)
    {
        global $db;
        $booking_price = 0;
        $checkindate = strtotime($checkindate);
        $year = date('Y', $checkindate);
        $month = date('n', $checkindate);
        $day = date('j', $checkindate);
        //$no_of_days = $no_of_days+1;
        if ($no_of_days > 30) {
            $total_days = '30';
        } else {
            $total_days = $no_of_days;
        }

        if (is_numeric($cid)) {


            $query = "SELECT fc.id as companyID,fapp.id, fasb.brand_name, fapb.after_30_days,IF( fapb.day_$total_days >0, fapb.day_" . $total_days . ", fc.parking_per_day_price * $total_days) as price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $day . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and removed != 'Yes' and fc.id = $cid   and airport_id = '" . $aid . "' and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "'  
                ";


            $companies = DB::select(DB::raw($query));

//            $companies = $db->select("SELECT fc.id as companyID,
//			fapp.id, fasb.brand, fapb.after_30_days, IF( fapb.day_$total_days >0, fapb.day_$total_days, fc.parking_per_day_price * $total_days) AS price FROM " . $db->prefix . "companies as fc
//			join " . $db->prefix . "airport_price_plan as fapp on fc.id = fapp.company_id
//			join " . $db->prefix . "airport_select_brand as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $day . "'
//			join " . $db->prefix . "airport_price_brands as fapb on fapb.companyId = fc.id and fapb.brand = fasb.brand
//			WHERE is_active = 'Yes' and fc.id = $cid and fc.airport_id = '" . $aid . "' and fapp.month = '" . $month . "' and fapp.year = '" . $year . "'");
//
            if ($companies !== false) {
                foreach ($companies as $company) {
                    //$price = number_format($company['price'], 2, '.', '');
                    $company = (array)$company;
                    if ($no_of_days > 30) {
                        $after30Days = $company['after_30_days'];
                        $booking_price = number_format($company['price'], 2, '.', '');
                        $booking_price = $booking_price + $after30Days * ($no_of_days - 30);
                        $booking_price = number_format($booking_price, 2, '.', '');
                    } else {
                        $booking_price = number_format($company['price'], 2, '.', '');
                    }
                }
            }
        } else {
            $booking_price = 0.00;
        }


        return $booking_price;
    }


    public function manage_booking()
    {
         $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.manage_booking", ["airports" => $airports,"page"=>$page]);

    }

    /*
       * RESPONSE MANAGEMENT
       */
    public function getResponse($success, $data)
    {
        $res = array();
        $res['success'] = $success;
        $res['data'] = $data;
        return $res;
    }

//stripe payment token method
    public function createPaymentWithToken($amount, $token, $descp)
    {
       
        Stripe::setApiKey($this->stripeKey);
        // Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
        //$token = $_POST['stripeToken'];
        try {
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $this->currency,
                'description' => $descp,
                'source' => $token,
            ]);
            return $this->getResponse(1, $charge);
        } catch (Exception $e) {

            return $this->getResponse(0, $e->getMessage());
        } catch (Card $e) {
            return $this->getResponse(0, $e->getMessage());
        }
    }


    //Refund payment with Stripe
    public function PaymentRefundWithStripe($amount, $charge_id)
    {
        Stripe::setApiKey($this->stripeKey);
        try {
            $refund = Refund::create([
                'charge' => $charge_id,
                'amount' => $amount,
            ]);
            return $this->getResponse(1, $refund);
        } catch (Exception $e) {
            return $this->getResponse(0, $e->getMessage());
        } catch (Card $e) {
            return $this->getResponse(0, $e->getMessage());
        }
    }

    /*
     * payment with stripe
     */

    public function paymentwithstripe(Request $request)
    {

         
        $departterminal = $request->input("departterminal");
        $arrivalterminal = $request->input("arrivalterminal");
        $returnflight = $request->input("returnflight");
        $model = $request->input("model");
        $color = $request->input("color");
        $make = $request->input("make");
        $registration = $request->input("registration");
        $cancelfee = $request->input("cancelfee");
        $smsfee = $request->input("smsfee");
        $subscribe = $request->input("subscribe");
        $booking_id = $request->input("booking_id");
        $reference_no = $request->input("reference_no");
        $payenttoken = $request->input("token");
        $alltotal = $request->input("alltotal");
		$aphactive = $request->input('aphactive');
		$park_api = $request->input('park_api');
        $resp=$request->input('result');
        $resp=json_encode($resp);
        $resp=json_decode($resp);
		$booking = airports_bookings::where("id",$booking_id)->first();
        //$discount= $booking->booking_amount-$alltotal;
		//dd($discount);
		//$dis = new discounts();

          //  $discount_amount = $dis->getPromoDiscount($request->input("promo"), $request->input("total_amount"), "airport_parking");
			//dd($alltotal);
       


        //if ($resp["success"] == 1) 
        {
            // dd($resp["data"]->getLastResponse()->json);
			
			if ($aphactive==1) {
                    $aphorder = $this->bookOnAPH($request);
                    $ext_ref = isset($aphorder['BookingRef']) ? $aphorder['BookingRef'] : '';
                    $aphData['ext_ref'] = $ext_ref;
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
            }
            if ($park_api == 'global') {
              
                // return $globalorder;
              
                    // New Booking Request Start
                    $booking =  airports_bookings::where("referenceNo", $request->input("reference_no"))->first();
                  
                    $curlReqs = curl_init();
                    curl_setopt_array($curlReqs, array(
                        CURLOPT_URL => 'https://live-api.opitech.co.uk/api-booking.php',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'quote' => $request->input("g_quote"),
                            'token' => $request->input("g_token"),
                            'firstName' => $request->input("firstname"),
                            'surname' => $request->input("lastname"),
                            'email' => $request->input("email"),
                            'contactNumber' => $request->input("contactno"),
                            'carReg' => $request->input("registration"),
                            'carMake' => $request->input("make"),
                            'carModel' => $request->input("model"),
                            'carColour' => $request->input("color"),
                            'NumberOfPax' => $booking->passenger,
                            'OutFltNo' => '',
                            'InFltNo' => $request->input("returnflight"),
                            'OutTerminal' => $request->input("departterminal"),
                            'RetTerminal' => $request->input("arrivalterminal"),
                            'OutFltTime' => $request->input("droptime"),
                            'InFltTime' => $request->input("picktime"),
                            'title' => $request->input("title"),
                            'agentCode' => 'PARZ',
                            'key' => 'GzJew9QjhzzcOsSdq4u0jpInT5xNQSA0'
                        )
                    ));
                    $curlresp = curl_exec($curlReqs);
                    curl_close($curlReqs);
                    // New Booking Request End


                    // dd('Token : '.$request->input("token") .' : '. 'Quote : '.$request->input("quote") .' : '.  $curlresp);
                    $curlresp = json_decode($curlresp, true);

                    $aphData['ext_ref'] = $curlresp['booking_ref'];
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                }
                
                $opitechorder = '';
            if ($park_api == 'Opitech') {
                    $curlReqs = curl_init();
                    curl_setopt_array($curlReqs, array(
                        CURLOPT_URL => 'https://live-api.opitechdevelopment.com/api-booking.php',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'quote' => $request->input("g_quote"),
                            'token' => $request->input("g_token"),
                            'firstName' => $request->input("firstname"),
                            'surname' => $request->input("lastname"),
                            'email' => $request->input("email"),
                            'contactNumber' => $request->input("contactno"),
                            'carReg' => $request->input("registration"),
                            'carMake' => $request->input("make"),
                            'carModel' => $request->input("model"),
                            'carColour' => $request->input("color"),
                            'NumberOfPax' => '1',
                            'OutFltTime' => $request->input("droptime"),
                            'InFltTime' => $request->input("picktime"),
                            'title' => $request->input("title"),
                            'agentCode' => 'PARZ',
                            'key' => 'hg563hrfs4J3FyLn6n3UypQo4ZST5zNQJ'
                        )
                    ));
                    
                   
                    $curlresp = curl_exec($curlReqs);
                    curl_close($curlReqs);
                    
                    // New Booking Request End


                    // dd('Token : '.$request->input("token") .' : '. 'Quote : '.$request->input("quote") .' : '.  $curlresp);
                    $curlresp = json_decode($curlresp, true);
                    
                    $aphData['ext_ref'] = $curlresp['booking_ref'];
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                
            }
            
            if($park_api == 'holiday'){
                $holidayorder = $this->bookOnHoliday($request);
                $ext_ref = isset($holidayorder['BookingRef']) ? $holidayorder['BookingRef'] : '';
                $aphData['ext_ref'] = $ext_ref;
                airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                
            }
            $this->update_booking_payment($request, $resp, "stripe");
            echo json_encode($this->getResponse(1, "payment successfully charged"));

        } //else {
            //dd($resp);
           // echo json_encode($resp);
       //}


    }

    /*
     * payment with payzone
     */
    public function paymentwithPayzone(Request $request)
    {
        
        $departterminal = $request->input("departterminal");
        $arrivalterminal = $request->input("arrivalterminal");
        $returnflight = $request->input("returnflight");
        $model = $request->input("model");
        $color = $request->input("color");
        $make = $request->input("make");
        $registration = $request->input("registration");
        $cancelfee = $request->input("cancelfee");
        $smsfee = $request->input("smsfee");
        $subscribe = $request->input("subscribe");
        $booking_id = $request->input("booking_id");
        $reference_no = $request->input("reference_no");
        $payenttoken = $request->input("token");
        $alltotal = $request->input("alltotal");
        $card_no = $request->input("CardNumber");
        $ccv = $request->input("CV2");
        $exp_year = $request->input("ExpiryDateYear");
        $exp_month = $request->input("ExpiryDateMonth");
        $customer_name = $request->input("CardName");
        $address = $request->input("address");
        $city = $request->input("city");
        $state = $request->input("state");
        $post_code = $request->input("post_code");

        $email = $request->input("email");
        $aphactive = $request->input('aphactive');


        // global $PayzoneHelper;
        require_once(app_path('library/payzone/includes/payzone_gateway_new.php'));
        $SuppressDebug = true;

        $action = "process";
        $IntegrationType = $PayzoneGateway->getIntegrationType();
        $SecretKey = $PayzoneGateway->getSecretKey();
        $HashMethod = $PayzoneGateway->getHashMethod();


        $CurrencyCode = $PayzoneGateway->getCurrencyCode();
        $respobj = array();
        $queryObj = array();
        $queryObj["Amount"] = $alltotal;
        $queryObj["CurrencyCode"] = $CurrencyCode;
        $queryObj["OrderID"] = $reference_no;
        $queryObj["OrderDescription"] = "this is direct testing";
        $queryObj["HashMethod"] = $HashMethod;
        $queryObj["CrossReferenceTransaction"] = false;
        $StringToHash = $PayzoneHelper->generateStringToHashDirect($queryObj["Amount"], $CurrencyCode, $queryObj["OrderID"], $queryObj["OrderDescription"], $SecretKey);
        $ShoppingCartHashDigest = $PayzoneHelper->calculateHashDigest($StringToHash, $SecretKey, $HashMethod);
        $ShoppingCartValidation = $PayzoneHelper->checkIntegrityOfIncomingVariablesDirect("SHOPPING_CART_CHECKOUT", $queryObj, $ShoppingCartHashDigest, $SecretKey);
        $respobj["ShoppingCartHashDigest"] = $ShoppingCartHashDigest;
        if ($ShoppingCartValidation) {
            $data = [];

            $data["Country"] = "UK";
            $data["FullAmount"] = $alltotal;
            $data["OrderID"] = $reference_no;
            $data["TransactionDateTime"] = date("Y-m-d H:i:s");
            $data["OrderDescription"] = "Booking Payment";
            $data["CardNumber"] = $card_no;
            $data["CV2"] = $ccv;
            $data["IssueNumber"] = "";
            $data["ExpiryDateMonth"] = $exp_month;
            $data["ExpiryDateYear"] = $exp_year;
            $data["CustomerName"] = $customer_name;
            $data["Address1"] = $address;

            $data["City"] = $city;
            $data["State"] = $state;
            $data["PostCode"] = $post_code;
            $data["EmailAddress"] = $email;

            $PayzoneGateway->setDebugMode(true);
            $queryObj = $PayzoneGateway->buildXHRequest($data);
            //Process the transaction
            // require_once(__DIR__ . "/includes/gateway/direct_process.php");
            require_once(app_path('library/payzone/includes//gateway/direct_process.php'));


            // echo json_encode($paymentResponse);//pass the response object back to the JS handler to process
            if ($paymentResponse["StatusCode"] == 0) {

                //send booking on aph by xml
                if ($aphactive==1) {
                    $aphorder = $this->bookOnAPH($request);
                    $ext_ref = isset($aphorder['BookingRef']) ? $aphorder['BookingRef'] : '';
                    $aphData['ext_ref'] = $ext_ref;
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                }  
                

                $this->update_booking_payment($request, $paymentResponse, "payzone");
            }


            $paymentResponse = $this->HandleErrorMessagePayzone($paymentResponse);
            return response()->json($paymentResponse);

        } else {
            $paymentResponse["ErrorMessage"] = 'Hash mismatch validation failure';
            $paymentResponse["ErrorMessages"] = true;
            //echo json_encode($paymentResponse);
            return response()->json($paymentResponse);
        }
        // echo "----";

    }

    /* refund payzone
     * $data is array e.g $data["amount"=>29,"order_id"=>10001,"CrossReference"=>123456455]
     */
    public function PaymentRefundWithPayzone($data)
    {
        require_once(app_path('library/payzone/includes/payzone_gateway_new.php'));
        $action = "refund";

        $IntegrationType = $PayzoneGateway->getIntegrationType();
        $SecretKey = $PayzoneGateway->getSecretKey();
        $HashMethod = $PayzoneGateway->getHashMethod();


        $CurrencyCode = $PayzoneGateway->getCurrencyCode();
        $respobj = array();
        $queryObj = array();
        $queryObj["Amount"] = $data["amount"];
        $queryObj["CurrencyCode"] = $CurrencyCode;
        $queryObj["OrderID"] = $data["order_id"];
        $queryObj["CrossReference"] = $data["payerID"];
        $queryObj["OrderDescription"] = "Refund order";
        $queryObj["HashMethod"] = $HashMethod;
        $StringToHash = $PayzoneHelper->generateStringToHashDirect($queryObj["Amount"], $CurrencyCode, $queryObj["OrderID"], $queryObj["OrderDescription"], $SecretKey);
        $ShoppingCartHashDigest = $PayzoneHelper->calculateHashDigest($StringToHash, $SecretKey, $HashMethod);
        $ShoppingCartValidation = $PayzoneHelper->checkIntegrityOfIncomingVariablesDirect("SHOPPING_CART_CHECKOUT", $queryObj, $ShoppingCartHashDigest, $SecretKey);
        $respobj["ShoppingCartHashDigest"] = $ShoppingCartHashDigest;
        if ($ShoppingCartValidation) {
            $queryObj = $PayzoneGateway->buildXHRefund($queryObj["Amount"], $queryObj["OrderID"], $queryObj["CrossReference"]);
            //Process the transaction


            require_once(app_path('library/payzone/includes//gateway/refund_process.php'));


            // echo json_encode($paymentResponse);//pass the response object back to the JS handler to process
            $paymentResponse = $this->HandleErrorMessagePayzone($paymentResponse);
            return response()->json($paymentResponse);
        } else {
            $paymentResponse["ErrorMessage"] = 'Hash mismatch validation failure';
            $paymentResponse["ErrorMessages"] = true;
            return response()->json($paymentResponse);
        }
    }

    public function HandleErrorMessagePayzone($paymentResponse)
    {
        // dd($paymentResponse);
        if ($paymentResponse["Message"] == "Card declined: AVS policy") {
            $paymentResponse["Message"] = "Please Check Your Address and postal code";
        }
        if ($paymentResponse["Message"] == "Card declined: AVS+CV2 policy") {
            $paymentResponse["Message"] = "Please check your card no or Address or postal code";
        }
        if ($paymentResponse["Message"] == "Card declined: CV2 policy") {
            $paymentResponse["Message"] = "CV2 is invalid";
        }
        if ($paymentResponse["Message"] == "Input variable errors") {
            //dd($paymentResponse);
            $paymentResponse["Message"] = "Card Details is invalid";
        }


        return $paymentResponse;

    }

    public function update_booking_payment($request, $paymentresponse, $payment_type)
    {
        $discount_amount = 0;
        if ($request->input("promo") != '') {
            $dis = new discounts();
            $discount_amount = $dis->getPromoDiscount($request->input("promo"), $request->input("alltotal"), "airport_parking");
        }
		
		

        $data = [];


        $data["deprTerminal"] = $request->input("departterminal");

        $bookingfee = $this->_setting['booking_fee'] > 0 ? $this->_setting['booking_fee'] : 0;

        $data["returnTerminal"] = $request->input("arrivalterminal");
        $data["returnFlight"] = $request->input("returnflight");
        $data["model"] = $request->input("model");
        $data["booking_fee"] = $bookingfee;
        $data["color"] = $request->input("color");
        $data["make"] = $request->input("make");
        $data["discount_code"] = $request->input("promo");
      //  $data["discount_amount"] = $discount_amount;
        $data["registration"] = $request->input("registration");
        $data["cancelfee"] = $request->input("cancelfee");
        $data["smsfee"] = $request->input("smsfee");
        $data["payment_status"] = "success";
        $data["payment_method"] = $payment_type;
//        $data["payment_status"] = $request->input("subscribe");
        //$data[""] = $request->input("booking_id");
        $data["total_amount"] = $request->input("alltotal");
        $data["address"] = $request->input("address");
        $data["address2"] = $request->input("address2");
        $data["town"] = $request->input("town");
        $data["fulladdress"] = $request->input("fulladdress");
        $data["postal_code"] = $request->input("post_code");
        $data["booking_status"] = "completed";
         $data["booking_action"] = "Booked";
        //
        //{"Message":"AuthCode: 794684","StatusCode":0,"CrossReference":"181101084616813901461909"}
        if ($payment_type == "payzone") {
            $data["api_res"] = json_encode($paymentresponse);
            //dd($paymentresponse);
            $data["PayerID"] = $paymentresponse["CrossReference"];
        }
        if ($payment_type == "stripe") {
            $data["api_res"] =json_encode($paymentresponse);
            $data["PayerID"] = $paymentresponse->paymentIntent->id;
        }


        DB::table('airports_bookings')
            ->where('referenceNo', $request->input("reference_no"))
            ->update($data);


        //$order_detail = airports_bookings::where("referenceNo", $request->input("reference_no"))->first();


        $this->submitTranscation($request->input("reference_no"));
		$row = DB::table('airports_bookings')->where('referenceNo', $request->input("reference_no"))->first();
        $airport_detail = airport::where("id",$request->input("airport"))->first();
		$company_data = DB::table('companies')->where('id', $row->companyId)->first();
		$overview = $company_data->overview."<br>";
		$companyemail = $company_data->company_email;
		$directions = "<strong>Arrival:</strong><br>".$company_data->arival."<br>".
						"<strong>Return:</strong><br>".$company_data->return_proc."<br>";
						

        $template_data = [];
		$template_data["guidence"] = $overview.' '.$directions;
        $template_data["username"] = $request->input("firstname") . " " . $request->input("lastname");
        $template_data["email"] = $request->input("email");
        $template_data["telephone"] = $request->input("contactno");
        $template_data["carpark"] = "Car Park";
        $template_data["c_parent"] = $company_data->name;
        $template_data["ptype"] = $request->input("parking_type");
        $template_data["airport"] = $airport_detail->name;

        if($request->input("departterminal")!="TBA" && $request->input("departterminal")!="") {
            $terminal = airports_terminals::where("id",$request->input("departterminal"))->first();
            $template_data["terminal"] = $terminal->name;
        } else {
            $template_data["terminal"] ="TBA";
        }

        if($request->input("arrivalterminal")!="TBA" && $request->input("arrivalterminal")!="") {
            $terminal = airports_terminals::where("id",$request->input("arrivalterminal"))->first();
            $template_data["rterminal"] = $terminal->name;
        } else {
            $template_data["rterminal"] ="TBA";
        }


        $template_data["days"] = $request->input("total_days");
        $template_data["end_date"] = $request->input("pickdate") . " " . $request->input("picktime");
        $template_data["start_date"] = $request->input("dropdate") . " " . $request->input("droptime");
        $template_data["booktime"] = date("Y-m-d H:i:s");
        $template_data["r_flight_no"] = $request->input("returnflight");
        $template_data["reg"] = $request->input("registration");
        $template_data["model"] = $request->input("model");
        $template_data["make"] = $request->input("make");
        $template_data["color"] = $request->input("color");
        $template_data["payment_gatway"] = $payment_type;
        $template_data["payment_status"] = "success";
        $template_data["price"] = $request->input("alltotal");
        $template_data["addtionalprice"] = 0;
        $template_data["ref"] = $request->input("reference_no");
        $template_data["company"] = $company_data->name;
        $template_data["c_code"] = $request->input("product_code");
        
        $email_send = new EmailController(); 
        $toemails = [$request->input("email"),'bookings@parkingzone.co.uk'];  
        $email_send->sendEmail("Add Booking", $toemails, $template_data);

            
        $emailcheck =  $email_send->sendEmail("Add Booking Admin",'bookings@parkingzone.co.uk', $template_data);
		if($emailcheck == '0')
        {
            $data['email_check'] = '0';
            DB::table('airports_bookings')
            ->where('referenceNo', $request->input("reference_no"))
            ->update($data);
        }
        else
        {
            $data['email_check'] = '1';
            DB::table('airports_bookings')
            ->where('referenceNo', $request->input("reference_no"))
            ->update($data);
        }
		if(is_null($company_data->aph_id)){ 
            $filePath = $this->create_csv($row->id, 'Next');
            $email_send->sendEmailWithFile("Add Booking Company",$company_data->company_email, $template_data, $filePath);
        }
        else{ 
            if($company_data->company_email != ''){
                $email_send->sendEmail("Add Booking Company", $company_data->company_email, $template_data); 
            }
        }
            //$email_send->sendEmail("Add Booking Company", $company_data->company_email, $template_data);  
            $smsfee = $request->input("smsfee");
        
        //if ($smsfee>0) {
            $functions = new functions();
           $functions->send_sms($request->input("contactno"), $request->input("reference_no"));
         //}

        return true;
        //return redirect()->route('thankyou');


    }


    public function reSendEmailBooking(Request $request)
    {
        $id = $request->input("id");


        $row = airports_bookings::getSingleRowById($id);
     //dd($row);
       
        //$row = DB::table('airports_bookings')->where('referenceNo', $row->reference_no)->first();
        $airport_detail = airport::where("id",$row->airportID)->first();
        $company_data = DB::table('companies')->where('id', $row->companyId)->first();
        $directions = "<strong>Arrival:</strong><br>".$company_data->arival."<br>".
                        "<strong>Return:</strong><br>".$company_data->return_proc."<br>";
                

        $template_data = [];
        $template_data["guidence"] = $directions;
        $template_data["username"] = $row->first_name . " " . $row->last_name;
        $template_data["email"] = $row->email;
        $template_data["telephone"] = $row->phone_number;
        $template_data["carpark"] = "Car Park";
        //$template_data["c_parent"] = "";
        if ($row->company) {
            $template_data["c_parent"] = $row->company->name;
        }
        $template_data["ptype"] = $row->booked_type;

        if ($row->airport) {
            $template_data["airport"] = $row->airport->name;
        }

        if ($row->dterminal) {
            $template_data["terminal"] = $row->dterminal->name;
        }

        if ($row->rterminal) {
            $template_data["rterminal"] = $row->rterminal->name;
        }


        $template_data["days"] = $row->no_of_days;
        $template_data["start_date"] = $row->departDate;
        $template_data["end_date"] = $row->returnDate;
        $template_data["booktime"] = $row->created_at;
        $template_data["r_flight_no"] = $row->returnFlight;
        $template_data["reg"] = $row->registration;
        $template_data["model"] = $row->model;
        $template_data["make"] = $row->make;
        $template_data["color"] = $row->color;
        $template_data["payment_gatway"] = $row->payment_method;
        $template_data["payment_status"] = "success";
        $template_data["price"] = $row->total_amount;
        $template_data["addtionalprice"] = 0;
        $template_data["ref"] = $row->referenceNo;
		file_put_contents("book_email_data.txt",print_r($template_data,true));
        $email_send = new EmailController();
        $email_send->sendEmail("Update Booking", $row->email, $template_data);

        return "success";


    }

    public function thanyou($id)
    {
        $airports = airport::all()->where("status", "Yes");

        $booking =  airports_bookings::where("referenceNo",$id)->first();

        return view("frontend.thankyou", ["airports" => $airports,"booking"=>$booking]);

    }

    public function booking_search(Request $request)
    {

//
        $messages = [
            'required' => 'This field is required.'
        ];
        $validatedData = Validator::make(Input::all(), [
            'ref_no' => 'required|string|max:255',
            'last_name' => 'required|string',
            'email' => 'required|string|email'

        ], $messages);

//


        $booking = airports_bookings::
            select(DB::raw("airports_bookings.*,companies.*,airports_bookings.id as bookingid"))
            ->leftJoin('companies', 'companies.id', '=', 'airports_bookings.companyId')
            ->where("airports_bookings.email", $request->input("email"))
            ->where("airports_bookings.last_name", $request->input("last_name"))
            ->where("referenceNo", $request->input("ref_no"))
            ->first();


        if ($booking) {


            // "select b.id as booking_id,b.email,b.ext_ref,b.booked_type,b.companyId,b.referenceNo,DATE_FORMAT(b.departDate, '%D %b %Y at %H:%i') AS departDate, DATE_FORMAT(b.createdate, '%D %b %Y at %H:%i') AS createdate,DATE_FORMAT(b.returnDate, '%D %b %Y at %H:%i') AS returnDate,b.no_of_days,b.title,b.first_name,b.last_name,b.payment_status,b.token,
            //b.payment_method,b.booking_status,b.booking_action,b.total_amount,b.cancelfee,b.address,b.address2,b.town,b.postal_code,b.booking_amount,b.phone_number,b.deptFlight,b.returnFlight,b.deprTerminal,b.returnTerminal,b.airportID, v.make, v.model,v.color, v.registration, IF(c.name IS NULL , b.booked_type, c.name) As cname, c.arival, c.return_proc,c.terms,c.admin_id,c.company_email,c.company_code
            //from ".$db->prefix."booking as b
            // left join " . $db->prefix . "vehicle as v on v.bookingId = b.id
            //left join " . $db->prefix . "companies as c on c.id = b.companyId or c.aph_id = b.companyId
            // where b.referenceNo = '".$_GET['reff']."'"
            $airports = airport::all()->where("status", "Yes");
            $airport_detail = airport::find($booking->airportID)->first();
            return view("frontend.manage_booking_detail", ["airports" => $airports, "booking" => $booking, "airport_detail" => $airport_detail]);
        } else {

            $validatedData->getMessageBag()->add('ref_no', 'Invalid Data Entered');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


    }

    public function submitTranscation($ref_no)
    {
       // echo $ref_no;
        $order_detail = airports_bookings::where("referenceNo",$ref_no)->first();
        //dd($order_detail);
        $d = [];
        $d["orderID"] = $order_detail->id;
        $d["token"] = $order_detail->PayerID;
        $d["referenceNo"] = $ref_no;
        $d["companyId"] = $order_detail->companyId;
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

        DB::table('booking_transaction')
            ->insert($d);
        return true;
    }

    public function bookOnAPH($request) {

        $reference_no = $request->input("reference_no");
        $booking =  airports_bookings::where("referenceNo",$reference_no)->first();
        $company_detail = company::where("id",$booking->companyId)->first();
        $companycode = $company_detail->aph_id;
		$product_code = $request->input("product_code");
        $passenger = $booking->passenger;

        $Arrival_Date = $request->input("dropdate"); // drop/arrival date on car park
        $Arrival_Time = $request->input("droptime");

        $Depart_Date = $request->input("pickdate"); // pick/depart date from car park
        $Depart_Time = $request->input("picktime");
           

        $ArrivalDate = date('dMy', strtotime($Arrival_Date));
        $DepartDate = date('dMy', strtotime($Depart_Date));
        $ArrivalTime = date("Hi",strtotime($Arrival_Time));
        $DepartTime = date("Hi",strtotime($Depart_Time)); 

        $no_of_days = $request->input("total_days");

        //$product_code = $productcode;

        //$passenger = $request->input("passenger");
        $returnFlight = $request->input("returnflight");

        $terminal = $request->input("departterminal");
        $rterminal = $request->input("arrivalterminal");

        if($request->input("departterminal")!="TBA" && $request->input("departterminal")!="") {
            $terminaldb = airports_terminals::where("id",$request->input("departterminal"))->first();
            $terminal = $terminaldb->name;
        }

        if($request->input("arrivalterminal")!="TBA" && $request->input("arrivalterminal")!="") {
            $rterminaldb = airports_terminals::where("id",$request->input("arrivalterminal"))->first();
            $rterminal = $rterminaldb->name;
        }
        
        //deptFlight
        $registration = $request->input("registration");
        $make = $request->input("make");
        $model = $request->input("model");
        $color = $request->input("color");

        $title = $request->input("title");
        $first_name = $request->input("firstname");
        $last_name = $request->input("lastname");
        $phone_number = $request->input("contactno");

        $aph_functions = new aph_functions();

        $xml1 = '<API_Request 
                        System="APH"
                        Version="1.0"
                        Product="CarPark"
                        Customer="X"
                        Session="000000006"
                        RequestCode="5">
                        <Agent>
                            <ABTANumber>'.config('app.ABTANumber').'</ABTANumber>
                            <Password>'.config('app.Password').'</Password>
                            <Initials>'.config('app.Initials').'</Initials>
                        </Agent>
                        <Itinerary>
                            <ArrivalDate>'.$ArrivalDate.'</ArrivalDate>
                            <DepartDate>'.$DepartDate.'</DepartDate>
                            <ArrivalTime>'.$ArrivalTime.'</ArrivalTime>
                            <DepartTime>'.$DepartTime.'</DepartTime>
                            <Duration>'.$no_of_days.'</Duration>
                            <CarParkCode>'.$companycode.'</CarParkCode>
							<ProductCode>'.$product_code.'</ProductCode>
                            <NumberOfPax>'.$passenger.'</NumberOfPax>
                            <ReturnFlight>'.$returnFlight.'</ReturnFlight>
                            <DepTerminal>'.$terminal.'</DepTerminal>
                            <OutFlight></OutFlight>
                            <RetTerminal>'.$rterminal.'</RetTerminal>
                        </Itinerary>
                        <CarDetails>
                            <CarReg>'.$registration.'</CarReg>
                            <CarMake>'.$make.'</CarMake>
                            <CarModel>'.$model.'</CarModel>
                            <CarColour>'.$color.'</CarColour>
                        </CarDetails>
                        <ClientDetails>
                            <Title>'.$title.'</Title>
                            <Initial>'.$first_name.'</Initial>
                            <Surname>'.$last_name.'</Surname>
                            <Telephone1>'.$phone_number.'</Telephone1>
                        </ClientDetails>
                    </API_Request>  ';

                $aphorder = $aph_functions->AphBookingOrder($xml1);
                return $aphorder;
    }
    
    
    public function create_csv($token, $status)
		{   
		 $query = "select 
					c.company_code AS ProductCode,
					b.referenceNo AS Refno,
					ap.name AS Airport,
					DATE_FORMAT(b.created_at, '%Y-%m-%d') AS BookingDate,
					TIME_FORMAT(b.created_at, '%H:%i:%s') AS BookingTime, 
					DATE_FORMAT(b.departDate, '%Y-%m-%d') AS DepartureDate,
					TIME_FORMAT(b.departDate, '%H:%i:%s') AS DepartureTime, 
					DATE_FORMAT(b.returnDate, '%Y-%m-%d') AS ReturnDate,
					TIME_FORMAT(b.returnDate, '%H:%i:%s') AS ReturnTime, 
					IF(b.deprTerminal > 0, (select airports_terminals.name from airports_terminals where airports_terminals.id= b.deprTerminal), 'TBA') As DepartureTerminal, 
					IF(b.returnTerminal > 0, (select airports_terminals.name from airports_terminals where airports_terminals.id= b.returnTerminal), 'TBA') As ReturnTerminal,
					b.no_of_days AS TotalDays,
					b.title AS Title,
					b.first_name AS FirstName,
					b.last_name AS LastName,
					b.phone_number AS Telephone,
					b.booking_amount AS BookingPrice,
					(b.booking_amount - (c.share_percentage/100*(b.booking_amount)) ) As CompanyShare,
				    (c.share_percentage/100*(b.booking_amount)) As AgentShare,
					b.deptFlight AS DeptFlight,
					b.returnFlight AS ReturnFlight,
					b.leavy_fee AS  AirportLevyFee,
					b.make AS CarMake, 
					b.model AS CarModel,
					b.color AS CarColor,
					b.registration AS CarRegistration
        			from airports_bookings as b
        			join companies as c on c.id = b.companyId
        			join airports as ap on ap.id = b.airportID 
        			left join airports_terminals as tr on tr.id = b.deprTerminal
                    WHERE b.id =".$token;
 
            $results = DB::select(DB::raw($query));
		   
			if($results>0){
				$datenow = date("dmYhms");
				$name = "FPP_$datenow.csv";
				$csvpath = public_path('csv/');
				$filepath = $csvpath.$name;
				$outstream = fopen($filepath, "w");   
				if($status != ""){
				 	$results[0]->BookingStatus = 'BookingStatus';	
				}				
				  fputcsv($outstream, array_keys((array) $results[0]));

				foreach($results as $result)
				{
					if($status != ""){
				       	$result->BookingStatus = $status;
					}
					fputcsv($outstream, (array) $result);
				}

			   // fclose($outstream);
				rewind($outstream);
				fclose($outstream);
			}
			return $filepath;
	}
	public function bookOnGlobal($request)
    {
            
        $reference_no = $request->input("reference_no");
        $booking =  airports_bookings::where("referenceNo", $reference_no)->first();
        $company_detail = company::where("id", $booking->companyId)->first();
        $code =  airport::where("id", $booking->airportID)->first();
        $companycode = $company_detail->aph_id;
        $product_code = $request->input("product_code");
        $passenger = $booking->passenger;

        $dropdate = $request->input("dropdate"); // drop/arrival date on car park

        $pickdate = $request->input("pickdate"); // pick/depart date from car park

        $dropDate = date('Y-m-d', strtotime($dropdate));
        $pickDate = date('Y-m-d', strtotime($pickdate));

        $no_of_days = $request->input("total_days");
        $returnFlight = $request->input("returnflight");

        $terminal = $request->input("departterminal");
        $rterminal = $request->input("arrivalterminal");

        if ($request->input("departterminal") != "TBA" && $request->input("departterminal") != "") {
            $terminaldb = airports_terminals::where("id", $request->input("departterminal"))->first();
            $terminal = $terminaldb->name;
        }

        if ($request->input("arrivalterminal") != "TBA" && $request->input("arrivalterminal") != "") {
            $rterminaldb = airports_terminals::where("id", $request->input("arrivalterminal"))->first();
            $rterminal = $rterminaldb->name;
        }

        $data['key'] = '8ghzs9qe4252t2eg';
        $data['sku'] = $request->input("product_code");
        /* ======= Vehicle Details ======= */
        $data['payment_type'] = 'stripe';
        $data['amount'] = $booking->booking_amount;
        $data['discount'] = $booking->discount_amount;
        $data['extra_charges'] = $booking->extra_amount;
        $data['levy_charges'] = $booking->levy_fee;
        $data['transaction_id'] = $booking->id;

        /* ======= Vehicle Details ======= */
        $data['make'] = $request->input("make");
        $data['model'] = $request->input("model");
        $data['color'] = $request->input("color");
        $data['registration'] = $request->input("registration");

        /* ======= Customer Details ======= */
        $title = $request->input("title");
        $first_name = $request->input("firstname");
        $last_name = $request->input("lastname");

        $data['name'] = $title . ' ' . $first_name . ' ' . $last_name;
        $data['email'] = $request->input("email");
        $data['contact_no'] = $request->input("contactno");

        /* ======= Booking Details ======= */
        $data['reference'] = $request->input("reference_no");
        $data['status'] = 1;

        $data['departure_date'] = date('Y-m-d', strtotime($dropdate));
        $data['departure_time'] = $request->input("droptime");
        $data['departure_terminal'] = $terminal;
        $data['departure_flight_no'] = '';

        $data['arrival_date'] = date('Y-m-d', strtotime($pickdate));
        $data['arrival_time'] = $request->input("picktime");
        $data['arrival_terminal'] = $rterminal;
        $data['arrival_flight_no'] = $request->input("returnflight");
        $data['num_people'] = $passenger;
        //echo "<pre>"; print_r($data); echo "</pre>"; exit;

        $url = "https://live-api.opitech.co.uk/api-search.php?";
        $getString = "location_code=" . $code->iata_code;
        $getString .= "&arrival_date=" . $pickdate . "&arrival_time=" . $request->input('picktime');
        $getString .= "&depart_date=" . $dropdate . "&depart_time=" . $request->input('droptime') . "&agentCode=PARZ&key=GzJew9QjhzzcOsSdq4u0jpInT5xNQSA0";
        $final = $url . $getString;
        $ch = curl_init($final);
        $timeout = 5;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curlresp = curl_exec($ch);
        $curlresp = json_decode($curlresp, true);
        curl_close($ch);

        return $curlresp;
    }
    public function bookOnHoliday($request) {

        $reference_no = $request->input("reference_no");
        $booking =  airports_bookings::where("referenceNo",$reference_no)->first();
        $company_detail = company::where("id",$booking->companyId)->first();
        $companycode = $company_detail->product_code;
		$product_code = $request->input("product_code");
        $passenger = $booking->passenger;
        $booking_amount = $booking->booking_amount;

        $Arrival_Date = $request->input("dropdate"); // drop/arrival date on car park
        $Arrival_Time = $request->input("droptime");

        $Depart_Date = $request->input("pickdate"); // pick/depart date from car park
        $Depart_Time = $request->input("picktime");
           

        $ArrivalDate = date('Y-m-d', strtotime($Arrival_Date));
        $DepartDate = date('Y-m-d', strtotime($Depart_Date));
        $ArrivalTime = date("Hi",strtotime($Arrival_Time));
        $DepartTime = date("Hi",strtotime($Depart_Time)); 

        $no_of_days = $request->input("total_days");

        //$product_code = $productcode;

        //$passenger = $request->input("passenger");
        $returnFlight = $request->input("returnflight");

        $terminal = $request->input("departterminal");
        $rterminal = $request->input("arrivalterminal");

        if($request->input("departterminal")!="TBA" && $request->input("departterminal")!="") {
            $terminaldb = airports_terminals::where("id",$request->input("departterminal"))->first();
            $terminal = $terminaldb->name;
        }else{
            $terminal = 'NA';
        }

        if($request->input("arrivalterminal")!="TBA" && $request->input("arrivalterminal")!="") {
            $rterminaldb = airports_terminals::where("id",$request->input("arrivalterminal"))->first();
            $rterminal = $rterminaldb->name;
        }else{
            $rterminal = 'NA';
        }
        
        //deptFlight
        $registration = $request->input("registration");
        $make = $request->input("make");
        $model = $request->input("model");
        $color = $request->input("color");

        $title = $request->input("title");
        $first_name = $request->input("firstname");
        $last_name = $request->input("lastname");
        $phone_number = $request->input("contactno");
        $email = $request->input("email");

        $aph_functions = new aph_functions();

        $string = "&ArrivalDate=".$ArrivalDate."&ArrivalTime=".$ArrivalTime."&DepartDate=".$DepartDate."&DepartTime=".$DepartTime."&NumberOfPax=".$passenger;
        $string .= "&Title=".$title."&Initial=".$first_name."&Surname=".$last_name."&Address=NA&Town=NA&County=NA&PostCode=NA";
                
        $string .= "&Email=".$email."&PriceCheckFlag=Y&PriceCheckPrice=".$booking_amount."&CarColour=".$color."&CarMake=".$make."&CarModel=".$model."&Registration=".$registration;
        $string .= "&Destination=NA&OutFlight=NA&OutTerminal=".$terminal."&ReturnFlight=".$returnFlight."&ReturnTerminal=".$rterminal."&MobileNum=".$phone_number;
        
        $aphorder = $aph_functions->HolidayBookingOrder($string, $product_code);
        return $aphorder;
    }
    
    
    public function payout_failed(Request $request)
    {


        $departterminal = $request->input("departterminal");
        $arrivalterminal = $request->input("arrivalterminal");
        $returnflight = $request->input("returnflight");
        $model = $request->input("model");
        $color = $request->input("color");
        $make = $request->input("make");
        $registration = $request->input("registration");
        $cancelfee = $request->input("cancelfee");
        $smsfee = $request->input("smsfee");
        $subscribe = $request->input("subscribe");
        $booking_id = $request->input("booking_id");
        $reference_no = $request->input("reference_no");
        $payenttoken = $request->input("token");
        $alltotal = $request->input("alltotal");
		$aphactive = $request->input('aphactive');
		$park_api = $request->input('park_api');
        $resp=$request->input('result');
        $resp=json_encode($resp);
        $resp=json_decode($resp);
		$booking = airports_bookings::where("id",$booking_id)->first();
        //$discount= $booking->booking_amount-$alltotal;
		//dd($discount);
		//$dis = new discounts();

          //  $discount_amount = $dis->getPromoDiscount($request->input("promo"), $request->input("total_amount"), "airport_parking");
			//dd($alltotal);
       


        //if ($resp["success"] == 1) 
        {
            // dd($resp["data"]->getLastResponse()->json);
			
			if ($aphactive==1) {
                    $aphorder = $this->bookOnAPH($request);
                    $ext_ref = isset($aphorder['BookingRef']) ? $aphorder['BookingRef'] : '';
                    $aphData['ext_ref'] = $ext_ref;
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
            }
            if ($park_api == 'global') {
                $globalorder = $this->bookOnGlobal($request);
                if ($globalorder['status'] == "OK") {
                    $aphData['ext_ref'] = $reference_no;
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                }
            }
            if($park_api == 'holiday'){
                $holidayorder = $this->bookOnHoliday($request);
                $ext_ref = isset($holidayorder['BookingRef']) ? $holidayorder['BookingRef'] : '';
                $aphData['ext_ref'] = $ext_ref;
                airports_bookings::where("referenceNo", $reference_no)->update($aphData);
                
            }
            
            
            //$this->update_booking_payment($request, $resp, "stripe");
            //echo json_encode($this->getResponse(1, "payment successfully charged"));

        } //else {
            //dd($resp);
           // echo json_encode($resp);
       //}


    }
    
}

?>