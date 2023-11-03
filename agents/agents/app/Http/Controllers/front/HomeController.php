<?php



namespace App\Http\Controllers\front;



use App\airport;

use App\airports_bookings;

use App\airports_terminals;

use App\companies_assign_awards;

use App\companies_special_features;

use App\Company;

use App\discounts;

use App\faqs;

use App\Http\Controllers\EmailController;

use App\modules_settings;

use App\pages;

use App\reviews;

use App\settings;

use App\subscribers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;



use Illuminate\Support\Facades\Validator;



use DateTime;

use aph_functions;

use Symfony\Component\Console\Terminal;





class HomeController extends Controller

{





    public $_setting = [];

    public $_module_setting = [];



    function __construct()

    {

        $modules_settings = modules_settings::all();

        foreach ($modules_settings as $setting) {

            $this->_setting[$setting->name] = $setting->value;

        }



        //module settings

        $modules_settings = modules_settings::all();

        foreach ($modules_settings as $setting) {

            $this->_module_setting[$setting->name] = $setting->value;

        }





    }





    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //



        $airports = airport::all()->where("status", "Yes");

        $reviews= reviews::all()->where("status", "Yes")->take(4)->sortByDesc("id");

        //dd($airports);

        return view("home", ["airports" => $airports,"reviews"=>$reviews]);

    }



    public function subscribe_user(Request $request)

    {



        $messages = [

            'required' => 'This field is required.',

        ];

//        $validatedData = $request->validate([

//            'name' => 'required|string',

//            'email' => 'required|string|unique:subscribers,email'

//        ], $messages);



        $validatedData = Validator::make(Input::all(), [

            'name' => 'required|string|regex:/^[\pL\s\-]+$/u|min:4',

            'email' => 'required|string|unique:subscribers,email'



        ], $messages);





        if ($validatedData->fails()) {



            //pass validator errors as errors object for ajax response

            $d = "";

            foreach ($validatedData->messages()->getMessages() as $field_name => $messages)

            {

               $d .=$messages[0];// messages are retrieved (publicly)

            }





            return response()->json(["success"=>0,'errors'=>$d]);

        }



        else{



            $sub = new subscribers();

            $sub->name = $request->input("name");

            $sub->email = $request->input("email");

            $sub->save();

            return response()->json(["success"=>1,'data'=>"Successfully Subscribed."]);

        }



    }

    public function sitemap(){

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.sitemap", ["airports" => $airports]);

    }

      public function lounges(){

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.lounges", ["airports" => $airports]);

    }

      public function airportsparking(){

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.airportsparking", ["airports" => $airports]);

    }

      public function airporttransfer(){

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.airporttransfer", ["airports" => $airports]);

    }

    public function feedback(){

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.feedback", ["airports" => $airports]);

    }

     public function store(Request $request){

  $bookings = new airports_bookings();



     $review = new reviews();



       $review->type = "3";

            $review->type ="3";

            $review->admin_id = "1";

            $review->type_id = "77";

            $review->ref = "3";



            $review->username =$request->input("name");

            $review->email =$bookings->email;

            $review->rating = $request->input("rating");

            $review->review = $request->input("message");

            $review->status = date("Y-m-d h:i:s");

            $review->count = "open";

            $review->google_count="message";

          $review->save();



        $airports = airport::all()->where("status", "Yes");

        return view("frontend.feedback", ["airports" => $airports]);

    }

     public function contact(){

         $settings=[];

         $settingsAll = settings::all();

         foreach ($settingsAll as $setting) {

             $settings[$setting->field_name] = $setting->field_value;

         }

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.contact-us", ["airports" => $airports,"settings"=>$settings]);

    }

    public function contactus_post(Request $request){

        $subject  = $request->input("subject");

        $title  = $request->input("title");

        $firstname  = $request->input("firstname");

        $lastname  = $request->input("lastname");

        $email  = $request->input("email");

        $phone  = $request->input("phone");

        $message  = $request->input("message");



        $email_c = new EmailController();





    }





    public function airport_guide()

    {

        //



        $airports = airport::all()->where("status", "Yes");

        //dd($airports);

        return view("frontend.airport_guide", ["airports" => $airports]);

    }

    public function airport_types()

    {

        //



        $airports = airport::all()->where("status", "Yes");

        //dd($airports);

        return view("frontend.airports_types", ["airports" => $airports]);

    }



    function static_page($page)

    {

        $airports = airport::all()->where("status", "Yes");

        $page = pages::where("slug", $page)->first();

        $total_airports = airports_bookings::all()->count();

        if($page){
        
            return view("frontend.static_page", ["airports" => $airports,"page"=>$page]);
        } else {
            return view("frontend.404", ["airports" => $airports]);
        }

        //return view("frontend.static_page", ["airports" => $airports,"page"=>$page]);

    }



    function faqs()

    {

        $airports = airport::all()->where("status", "Yes");

        $total_airports = airports_bookings::all()->count();

        //WHERE removed='No' group by type order by id asc

        $faqs = faqs::all()->where("removed","No")->groupBy("type");





        return view("frontend.faqs", ["airports" => $airports,"faqs"=>$faqs]);

    }







    function page($slug)

    {

        $airports = airport::all()->where("status", "Yes");

        $page = pages::where("slug", $slug)->first();

        $total_airports = airports_bookings::all()->count();



        $dropdate = date("m/d/Y");

        $dropdate1 = $this->addDayswithdate($dropdate, '7');

        //echo $dropdate1; die();

        $no_of_days = 8;

        $i = 1;

        $j = 1;

        $selected_date = strtotime($dropdate1);

        $year = date('Y', $selected_date);

        $month = date('n', $selected_date);

        //$month = 9;

        $day = date('j', $selected_date);

        if ($no_of_days > 30) {

            $total_days = '30';

        } else {

            $total_days = $no_of_days;

        }

        $dropoftime = date("h:i");

        $pickuptime = "09:00";



        $pickdate = $this->addDayswithdate($dropdate1, '8');





        if ($page) {

            $airports_Detail = airport::where("id", $page->typeid)->first();





            $query = "SELECT fc.id as companyID,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview,IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace,

	        fapp.id, fasb.brand_name, fapb.after_30_days, IF( fapb.day_$total_days >0, fapb.day_$total_days, 0.00) AS price FROM companies as fc

	        left join companies_set_price_plans as fapp on fc.id = fapp.cid

	        left join companies_set_assign_price_plans as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $day . "'

	        left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name

	        WHERE is_active = 'Yes' and fc.name not LIKE '%Paige %' and airport_id = '" . $page->typeid . "' and fapp.cmp_month = '" . $month . "' and fapp.cmp_year = '" . $year . "' order by price asc";





            $companies = DB::select(DB::raw($query));

            $companies = collect($companies)->map(function ($x) {

                return (array)$x;

            })->toArray();



            $all_records = array();

            if (!empty($companies)) {

                $all_records = (array)$companies;

            }





            $all_records_md = $this->Search_IN_ARRAY($all_records, 'parking_type', 'Meet and Greet');



            $all_records_pd = $this->Search_IN_ARRAY($all_records, 'parking_type', 'Park and Ride');





            $reviews = reviews::all()->where("type_id",$page->typeid)->where("status","Yes");





            return view("frontend.page", ["airports" => $airports, "page" => $page, "total_airports" => $total_airports, "airports_Detail" => $airports_Detail, "companies" => $companies, "all_records_md" => $all_records_md, "all_records_pd" => $all_records_pd,"reviews"=>$reviews]);

        } else {

            return view("frontend.404", ["airports" => $airports]);

        }





    }





    function airports()

    {

        $airports = airport::all()->where("status", "Yes");

        return view("frontend.airports", ["airports" => $airports]);



    }





    function Search_IN_ARRAY($array, $key, $value)

    {

        $results = array();



        if (is_array($array)) {

            if (isset($array[$key]) && $array[$key] == $value) {

                $results[] = $array;

            }



            foreach ($array as $subarray) {

                $results = array_merge($results, $this->Search_IN_ARRAY($subarray, $key, $value));

            }

        }



        return $results;

    }



    function addDayswithdate($date, $days)

    {

        $date = strtotime("+" . $days . " days", strtotime($date));

        return date("m/d/Y", $date);

    }







    function reviews()

    {



        $query = "SELECT b.id, b.username, b.count,b.google_count,b.review,b.rating,b.status,b.created_at, c.id as c_id,c.name as c_name,d.id as d_id,d.name as d_airport_name,s.id as s_id

			FROM reviews as b

			join companies as c ON b.type_id=c.id OR type_id = c.aph_id

			join airports as d ON c.airport_id = d.id

			join users as s ON c.admin_id = s.id where b.id !='' && b.status='Yes'

			 ORDER BY b.id desc limit 12";





        $reviews = DB::select(DB::raw($query));

        $reviews = collect($reviews)->map(function ($x) {

            return (array)$x;

        })->toArray();





        $airports = airport::all()->where("status", "Yes");

        //dd($reviews);

        return view("frontend.review", ["airports" => $airports,"reviews"=>$reviews]);

    }





    public function addBookingForm(Request $request)

    {

        //dd("i m in booking");

        $aid = $request->input("airport");

        $airports = airport::all()->where("status", "Yes");





        $terminals = airports_terminals::all()->where("aid", "=", $aid);



        return view("frontend.booking", ["data" => $request, "settings" => $this->_setting, "airports" => $airports, "terminals" => $terminals]);

    }



    //this function is used for post resl
    public function getSearchResult(Request $request)
    {

        if($request->ajax()){
            return $this->ajaxSearchResults($request);
        } else {
            $airports = airport::all()->where("status", "Yes");
            //dd($reviews);
            return view("frontend.search_result" , ["airports" => $airports]);
        }


    } // end of function

    public function ajaxSearchResults($request) {

        // dd($request);
        $promo_error_message="";
//        $returnData = [];
//        $returnData["airport_id"] = $request->input('airport_id');
//        $returnData["dropoffdate"] = $request->input('dropoffdate');
//        $returnData["departure_date"] = $request->input('departure_date');
//        $returnData["dropoftime"] = $request->input('dropoftime');
//        $returnData["pickup_time"] = $request->input('pickup_time');
//        //$returnData["_token"] = csrf_token();
//        $returnData["promo"] = $request->input('promo');
//
//        $_SESSION["search_data"]=$returnData;


        $messages = [
            'required' => 'This field is required.'
        ];
        $validatedData = Validator::make(Input::all(), [
            'airport_id' => 'required',
            'dropoffdate' => 'required',
            'departure_date' => 'required'

        ], $messages);

        $airport_id = $request->input('airport_id');

        $dropdate = $request->input('dropoffdate');
        $pickdate = $request->input('departure_date');
        $dropoftime = $request->input('dropoftime');
        $pickuptime = $request->input('pickup_time');
        $no_of_days = $request->input('no_of_days') + 1;

        //$bookingfor = $request->input('bookingfor');
        $bookingfor = "airport_parking";
        $promo = $request->input('promo');
        $promo2 = $request->input('promo2');
        $filter1 = $request->input('filter1');
        //$filter2 = $_POST['filter2'];
        $filter2 = ($request->input('filter2') != '') ? $request->input('filter2') : 'low-to-high';
        $filter3 = $request->input('filter3');
        $search_filter = '';
        $search_filter3 = '';
        $search_filter2 = 'order by sort_by asc';
        // $search_filter2 = 'order by parking_type asc';
        if ($filter1 != '' && $filter1 != 'All') {
            $search_filter .= "and parking_type = '" . $filter1 . "'";
        }
        if ($filter2 == 'low-to-high') {
            $search_filter2 = "order by featured asc, recommended asc,parking_type asc, price asc";
            //$search_filter2 = 'ORDER BY ';
        } elseif ($filter2 == 'high-to-low') {
            $search_filter2 = "order by price desc";
        } elseif ($filter2 == 'distance') {
            $search_filter2 = "order by travel_time asc";
        }
        if ($filter3 != '') {
            $search_filter3 .= "and terminal = '" . $filter3 . "'";
        }

        if ($promo != '') {
            $discount = new discounts();
            $promo_verify = $discount->varifyPromoCode($promo);

            if($promo_verify!="Verify"){
                    $validatedData->getMessageBag()->add('promo', $promo_verify);

                    return redirect()->back()->withErrors($validatedData)->withInput();

            }


        }

        if ($promo2 != '') {
            $discount = new discounts();
            $promo_verify = $discount->varifyPromoCode($promo2);

            if($promo_verify!="Verify"){
               // $validatedData->getMessageBag()->add('promo', $promo_verify);

               // $promo_error=1;
                $promo_error_message=$promo_verify;


            }
            $promo=$promo2;

        }

//dd($promo);
        $html = '';
        $i = 1;
        $j = 1;
        $inactive = 0;
        $inactiv = 0;

        $selected_date = strtotime($dropdate);
        $year = date('Y', $selected_date);
        $month = date('n', $selected_date);
        $day = date('j', $selected_date);


        $dropofdate = date('Y-m-d', strtotime($dropdate));
        $pickupdate = date('Y-m-d', strtotime($pickdate));
        $dStart = new DateTime($dropofdate);
        $dEnd = new DateTime($pickupdate);
        $dDiff = $dStart->diff($dEnd);
        $dDiff->format('%R');
        $no_of_days = $dDiff->days;
        $totals_days = $no_of_days + 1;

        if ($no_of_days > 30) {
            $total_days = '30';
        } else {
            $total_days = $no_of_days;
        }
        if($total_days<=0){ $total_days=1;}
        // Calculate Days Difference From Now
        $dropdate1 = strtotime($dropdate);
        $c_time = date("Y-m-d");
        $dropdate1 = date("Y-m-d", $dropdate1);
        $datetime1 = new DateTime($c_time);
        $datetime2 = new DateTime($dropdate1);
        $interval = $datetime1->diff($datetime2);
        $diff_date = $interval->format('%R%a');
        $diff_date = substr($diff_date, 1);
        ////////********** END **********///////


        $query = "SELECT fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview,IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace,   fapp.id, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_" . $total_days . " >0, fapb.day_" . $total_days . "+fapp.extra, 0.00) AS price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $total_days . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and removed != 'Yes'  and airport_id = '" . $airport_id . "' and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "'  $search_filter $search_filter2 $search_filter3
                ";


        $companies = DB::select(DB::raw($query));

//        if ($promo != '') {
//            $discount_amount = getPromoDiscount($promo, $price);
//            $price = $price - $discount_amount;
//        }


        //return view("frontend.ajax.result", []);
        $airports = airport::all()->where("status", "Yes");
        $companies_special_features = companies_special_features::all();


        $airport_detail = airport::where("id",$airport_id)->first();


        //////////////////////////////////////////////
        //////////api working start//////////////////
        /////////////////////////////////////////////


        $apiairports = airport::all()->where("id", $airport_id)->toArray();

       foreach ($apiairports as $apiairport) {
           $airport_name = $apiairport['name'];
           $airport_code = $apiairport['iata_code'];
           $airport_post_code = $apiairport['post_code'];
           $airport_address = $apiairport['address'];
           $airport_town = $apiairport['city'];
       }
       $ArrivalDate = date('dMy', strtotime($dropdate));
       $DepartDate = date('dMy', strtotime($pickdate));
       $ArrivalTime = date("Hi", strtotime($dropoftime));
       $DepartTime = date("Hi", strtotime($pickuptime));


    $xml = '<API_Request
     System="APH"
     Version="1.0"
     Product="CarPark"
     Customer="X"
     Session="000000003"
     RequestCode="11">
     <Agent>
     <ABTANumber>'.config('app.ABTANumber').'</ABTANumber>
     <Password>'.config('app.Password').'</Password>
     <Initials>'.config('app.Initials').'</Initials>
     </Agent>
     <Itinerary>
     <ArrivalDate>' . $ArrivalDate . '</ArrivalDate>
     <DepartDate>' . $DepartDate . '</DepartDate>
     <ArrivalTime>' . $ArrivalTime . '</ArrivalTime>
     <DepartTime>' . $DepartTime . '</DepartTime>
     <Location>' . $airport_code . '</Location>
     <Terminals>ALL</Terminals>
     </Itinerary>
     </API_Request>';

       $aph_functions = new aph_functions();
       $api = new \api();
       $APHcompanies = @$aph_functions->AphBooking($xml);

       $aph_record = @$api->aph_record($APHcompanies, $airport_id, $search_filter); 

       if (count($aph_record) > 0) {    

            $aph_record = json_decode(json_encode($aph_record)); // convert to object

            $companies = array_merge((array) $companies, (array) $aph_record);
       }


       ///$ACEcompanies = ACEBooking($airport_code, $dropdate, $dropoftime, $pickdate, $pickuptime);


       ////////view start////////////////////


        return view("frontend.ajax_search_result", ["airports" => $airports, "companies" => $companies, "companies_special_features" => $companies_special_features, "request" => $request, "no_of_days" => $no_of_days, "promo" => $promo,"bookingfor"=>$bookingfor,"airport_detail"=>$airport_detail,"promo_error_message"=>$promo_error_message]);

    }











}

