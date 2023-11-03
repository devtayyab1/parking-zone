<?php

namespace App\Http\Controllers\front;


use App\airports_bookings;
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
use aph_functions;
use App\Company;
use functions;
use settings;


class BookingController extends Controller
{

    public $_setting = [];
    public $stripeKey = "sk_live_G0saAMlNn1AOpBx5yUOG9mAF00ng3Ug5B5";
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

        if ($aphactive==1) {
            $aph_functions = new aph_functions();            
            //$api = new \api();
            $company_detail = company::where("id",$company_id)->first();
            $productcode = $company_detail->aph_id;
            $booking_amount = $aph_functions->AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$productcode,$passenger);
        }

        $extra_amount = $this->extra_amount($company_id, $pl_id);
        $booking_amount_for = $this->check_extra($company_id, $pl_id, $booking_amount);


        $customer_id = 0;
        $smsfee_charged = 0;
        $cancelfee_charged = 0;
        $discount_amount = 0;
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

        $browser_data = $_SERVER['HTTP_USER_AGENT'];
        $ip = request()->ip();
        $_current_time = date('Y-m-d H:i:s');
        $days_ago = date('d-m-Y H:i:s', strtotime('-2 days', strtotime($_current_time)));

        if ($incomplete == 'yes') {
            $data = [];
            $data["airportID"] = $airport;
            $data["customerId"] = $customer_id;
            $data["companyId"] = $company_id;
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


            //$tracking = ref_tracking::where("user_ip",$ip)->where("is_internal_url","1")->where("created_at",date("Y-m-d"))->first();

            if(isset($_SESSION['source']) && $_SESSION['source']!=""){
                $m_source = $_SESSION("source");
                $data["traffic_src"]=$m_source;
            }else {
                $data["traffic_src"]="ORG";
            }
            if(isset($_SESSION['agent']) && $_SESSION['agent']!=""){
                $data["agentID"] = $_SESSION["agent"] ;
            }

            $data["user_ip"] = $ip;

             //dd($_SESSION);

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

        if ($aphactive==1) {
            $aph_functions = new aph_functions();            
            //$api = new \api();
            $company_detail = company::where("id",$company_id)->first();
            $productcode = $company_detail->aph_id;
            $booking_amount = $aph_functions->AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$productcode,$passenger);
        }

        $booking_amount = $this->check_extra($company_id, $pl_id, $booking_amount);
        if ($promo != '') {
            $dis = new discounts();
            $discount_amount = $dis->getPromoDiscount($promo, $booking_amount, $bookingfor, $company_id);
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
        $output['total_amount'] = $this->priceFormat($total_amount, false);
        $output['booking_amount'] = $booking_amount;
        $output['discount_amount'] = $this->priceFormat($discount_amount, false);
        $output['booking_fee'] = $this->priceFormat($bookingfee, false);
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
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.manage_booking", ["airports" => $airports]);

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


        $resp = $this->createPaymentWithToken((round($alltotal) * 100), $payenttoken, "Booking Payment");


        if ($resp["success"] == 1) {
            // dd($resp["data"]->getLastResponse()->json);

            $this->update_booking_payment($request, $resp, "stripe");
            echo json_encode($this->getResponse(1, "payment successfully charged"));

        } else {
            //dd($resp);
            echo json_encode($resp);
        }


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
                    airports_bookings::where("referenceNo", $reference_no)->update($aphData['ext_ref']);
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
        $data["discount_amount"] = $discount_amount;
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
        //
        //{"Message":"AuthCode: 794684","StatusCode":0,"CrossReference":"181101084616813901461909"}
        if ($payment_type == "payzone") {
            $data["api_res"] = json_encode($paymentresponse);
            //dd($paymentresponse);
            $data["PayerID"] = $paymentresponse["CrossReference"];
        }
        if ($payment_type == "stripe") {
            $data["api_res"] = json_encode($paymentresponse["data"]);
            $data["PayerID"] = $paymentresponse["data"]->getLastResponse()->json["id"];
        }


        DB::table('airports_bookings')
            ->where('referenceNo', $request->input("reference_no"))
            ->update($data);


        //$order_detail = airports_bookings::where("referenceNo", $request->input("reference_no"))->first();


        $this->submitTranscation($request->input("reference_no"));

        $airport_detail = airport::find($request->input("airport"))->first();


        $template_data = [];
        $template_data["username"] = $request->input("firstname") . " " . $request->input("lastname");
        $template_data["email"] = $request->input("email");
        $template_data["telephone"] = $request->input("contactno");
        $template_data["carpark"] = "Car Park";
        $template_data["c_parent"] = "";
        $template_data["ptype"] = $request->input("parking_type");
        $template_data["airport"] = $airport_detail->name;//$request->input("airport");
        $template_data["terminal"] = $request->input("departterminal");
        $template_data["rterminal"] = $request->input("arrivalterminal");
        $template_data["days"] = $request->input("total_days");
        $template_data["start_date"] = $request->input("pickdate") . " " . $request->input("picktime");
        $template_data["end_date"] = $request->input("dropdate") . " " . $request->input("droptime");
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
        $email_send = new EmailController();
        //$email_send->sendEmail("Update Booking", $request->input("email"), $template_data);
        $toemails = [$request->input("email"),'bookings@parkingzone.co.uk'];
        $email_send->sendEmail("Add Booking", $toemails, $template_data);

        //send sms
        $smsfee = $request->input("smsfee");
        if ($smsfee>0) {
            $functions = new functions();
            $functions->send_sms($request->input("contactno"), $request->input("reference_no"));
        }

        return true;
        //return redirect()->route('thankyou');


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
        leftJoin('companies', 'companies.id', '=', 'airports_bookings.companyId')
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
        $order_detail = airports_bookings::where("referenceNo",$ref_no)->first();

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
        $d["payable"] = $order_detail->total_amount;
        $d["amount_type"] = "credit";
        $d["payment_method"] =$order_detail->payment_method;
        $d["payment_action"] = $order_detail->payment_status;
        $d["booking_status"] = $order_detail->booking_status;

        DB::table('booking_transaction')
            ->insert($d);
        return true;
    }

    public function bookOnAPH($request) {

        $ArrivalDate = $request->input("pickdate");
        $ArrivalTime = $request->input("picktime");
        $DepartDate = $request->input("dropdate");
        $DepartTime = $request->input("droptime");        
        $no_of_days = $request->input("total_days");

        $product_code = '';

        $passenger = $request->input("passenger");
        $returnFlight = $request->input("returnflight");

        $terminal = $request->input("departterminal");
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
                            <CarParkCode>'.$product_code.'</CarParkCode>
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
                            <Telephone2>'.$phone_number.'</Telephone2>
                        </ClientDetails>
                    </API_Request>  ';

                $aphorder = $aph_functions->AphBookingOrder($xml1);
                return $aphorder;
    }

}

?>