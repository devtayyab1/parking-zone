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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use DateTime;
use aph_functions;
use Symfony\Component\Console\Terminal;
use Illuminate\Support\Facades\URL;



class HomeController extends Controller
{


    public $_setting = [];
    public $_settings = [];
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
        // Added By Php Dev 07-08-2020
        $settings = settings::all();
        foreach ($settings as $setting) {
            $this->_settings[$setting->field_name] = $setting->field_value;
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
        return redirect()->to('https://www.dashboard.parkingzonegroup.com/admin');
        $airports = airport::all()->where("status", "Yes"); 
        $reviews= reviews::all()->where("status", "Yes")->take(4)->sortByDesc("id");
        //dd($reviews);
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
        } else{

            $name = $request->input("name")==''?'ParkingZone Subscriber ':$request->input("name");
            $email = $request->input("email");
            $timeout =53;
            //fiveg mailchimp
            try {
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

            $sub = new subscribers();
            $sub->name = $request->input("name");
            $email1=  $sub->email = $request->input("email");
            $sub->save();
            $template_data = [];
            $template_data["username"] =$request->input("name");
            $email = new  EmailController();
            $email->sendEmail("Subscription",$email1,$template_data);

            

            return response()->json(["success"=>1,'data'=>"Successfully Subscribed."]);
        }

    }
    
 
    function getPagebySlug(){
        $url =  explode("/",URL::full());
       
        $page =  pages::where("slug", $url[3])->where("type", "main")->where("status", "Yes")->first();
      
        if($page){ return $page; }
        else {
            $page = (object) $page;
        
             $page->meta_title = "";
             $page->meta_keyword = "";
             $page->meta_description = "";
             return $page;

        }
    }
    public function sitemap(){
        
        $page = $this->getPagebySlug();
       
        $airports = airport::all()->where("status", "Yes");

        return view("frontend.sitemap", ["airports" => $airports,"page"=> $page]);
    }
      public function lounges(){
          $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.lounges", ["airports" => $airports,"page"=> $page]);
    }
      public function airportsparking(){
          $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.airportsparking", ["airports" => $airports,"page"=> $page]);
    }
      public function airporttransfer(){
        $page = $this->getPagebySlug();

        $airports = airport::all()->where("status", "Yes");
        return view("frontend.airporttransfer", ["airports" => $airports,"page"=> $page]);
    }
    public function feedback(){
        $airports = airport::all()->where("status", "Yes");
        return view("frontend.feedback", ["airports" => $airports]);
    }
	
    public function blogs(){ 
        // $now = date("y-m-d");
        $daysago = $this->addDayswithdate(date("y-m-d"), '-7');
        $daysago = date('Y-m-d h:i:s',strtotime($daysago));
        // dd($daysago);
		$airports = airport::all()->where("status", "Yes");
        $posts = pages::all()->where("status", "Yes")->where("type", "post");
        $recent_posts =  pages::all()->where("status", "Yes")->where("type", "post")->sortByDesc("added_on")->take(6);
        // dd($recent_posts);
        return view("frontend.blogs", ["posts" => $posts,"airports" => $airports,"recent_posts" => $recent_posts]);
    }
	
    function blog_detail($slug)
    {
		$airports = airport::all()->where("status", "Yes");
        /*$posts = pages::all()->where("status", "Yes")->where("type", "post")->where("slug",'!=', $slug)->take(3)->sortByDesc("id");*/
        $post = pages::where("slug", $slug)->first();
       
        if($post){

            $total_airports = airports_bookings::all()->count();
        

            return view("frontend.blog_detail", ["post"=>$post,"airports" => $airports]);
        }else
        {
            return view("frontend.404", ["airports" => $airports]);
        }
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

    public function contactUsSubmit(Request $request){
        // dd($request->all());
        $data = $request->all();
        $body = "Name: ".$data['title']." ".$data['firstname']." ".$data['lastname']."<br>";
        $body .="Email: ".$data['email']."<br>";
        $body .="Phone: ".$data['phone']."<br>";
        $body .="Subject: ".$data['phone']."<br>";
        $body .="Message: ".$data['message']."<br>";

        $data['body'] = $body;

        $email = "mzt646@seedanalytica.com";
        Mail::send([], [], function ($message) use ($data, $email) {
            $message->from($data["email"]);
            $message->to($email);
            $message->subject($data['subject']);
            $message->setBody($data['body'], 'text/html');
        });

        return redirect()->back()->with("success_message","Email send successfully");
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
        $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
        //dd($airports);
        return view("frontend.airport_guide", ["airports" => $airports,"page"=> $page]);
    }
    public function airport_types()
    {
        //
        $page = $this->getPagebySlug();

        $sliders = unserialize( $this->_settings['sliders']);
        $airports = airport::all()->where("status", "Yes");
     
        return view("frontend.airports_types", ["airports" => $airports,"page"=> $page , "sliders" => $sliders]);
    }

    function static_page($page)
    {
       $airports = airport::all()->where("status", "Yes");
        $page = pages::where("slug", $page)->where("status", "Yes")->first();
        //dd($page);
        if($page){

            $total_airports = airports_bookings::all()->count();
        

            return view("frontend.static_page", ["airports" => $airports,"page"=>$page]);
        }else
        {
            return view("frontend.404", ["airports" => $airports]);
        }
    }

    function faqs()
    {
        $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
        $total_airports = airports_bookings::all()->count();
        //WHERE removed='No' group by type order by id asc
        $faqs = faqs::all()->where("removed","No")->groupBy("type");

        if ($page->meta_title == "") {
            return view("frontend.404", ["airports" => $airports]);
        } else {
            return view("frontend.faqs", ["airports" => $airports,"faqs"=>$faqs,"page"=> $page]);
        }
       
    }
    function faqs_pages()
    {
        return view("frontend.faqs_pages");
    }



    function page($slug)
    {
        $airports = airport::all()->where("status", "Yes");
        $reviews= reviews::all()->where("status", "Yes")->take(4)->sortByDesc("id");
        $page = pages::where("slug", $slug)->where("status", "Yes")->first();
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


            $reviews = reviews::all()->where("status","Yes")->take(4);
            $faqs = ['title'=>$page->faq_title,'desc'=>$page->faq_desc];
            // dd($faqs);
            // $faq_desc = $page->faq_desc;


            return view("frontend.page", ["id"=> $page->typeid,"faqs" => $faqs,"airports" => $airports,"reviews" => $reviews, "page" => $page, "total_airports" => $total_airports, "airports_Detail" => $airports_Detail, "companies" => $companies, "all_records_md" => $all_records_md, "all_records_pd" => $all_records_pd,"reviews"=>$reviews]);
        } else {
            return view("frontend.404", ["airports" => $airports]);
        }


    }


    function airports()
    {
        $page = $this->getPagebySlug();
        $airports = airport::all()->where("status", "Yes");
               return view("frontend.airports", ["airports" => $airports,"page"=> $page]);

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

        $query = "SELECT b.id, b.username, b.review,b.rating,b.status,b.created_at, c.id as c_id,c.name as c_name,d.id as d_id,d.name as d_airport_name,s.id as s_id
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
    
    // function reviews2()
    // {

    //     // $query = "SELECT b.id, b.username, b.review,b.rating,b.status,b.created_at, c.id as c_id,c.name as c_name,d.id as d_id,d.name as d_airport_name,s.id as s_id
    //     //     FROM reviews as b
    //     //     join companies as c ON b.type_id=c.id OR type_id = c.aph_id
    //     //     join airports as d ON c.airport_id = d.id
    //     //     join users as s ON c.admin_id = s.id where b.id !='' && b.status='Yes'
    //     //      ORDER BY b.id desc limit 4";
    //   $reviews2 = reviews::all()->where("status", "Yes")->take(4);
      
      
    //     // $reviews = DB::select(DB::raw($query));
    //     // $reviews = collect($reviews)->map(function ($x) {
    //     //     return (array)$x;
    //     // })->toArray();


    //     // $airports = airport::all()->where("status", "Yes");
    //     // dd($reviews);
    //     return view("frontend.page", ["reviews"=>$reviews2]);
    // } 


    public function addBookingForm(Request $request)
    {
        //dd("i m in booking");
        $aid = $request->input("airport");
        $airports = airport::all()->where("status", "Yes");


        $terminals = airports_terminals::all()->where("aid", "=", $aid);
		
		$dropdate = str_replace('/', '-', $request['dropdate']);		
		$pickdate = str_replace('/', '-', $request['pickdate']);
		
        $request['dropdate'] = date('m/d/Y', strtotime($dropdate));
        $request['pickdate'] = date('m/d/Y', strtotime($pickdate));
     // dd($request);

        return view("frontend.booking1", ["data" => $request, "settings" => $this->_setting, "airports" => $airports, "terminals" => $terminals]);
    }
          

           public function addBookingFormincomplete($id)
    {     

        $airport_booking = airports_bookings::find($id);
        //dd($airport_booking);
        //dd("i m in booking");
        $DepartDatetemp = explode(' ',$airport_booking->departDate);
        $returnDatatemp = explode(' ',$airport_booking->returnDate);
        $company_id =$airport_booking->companyId;
        $product_code =$airport_booking->product_code;
        //dd($product_code);
        $aphactive = 0;
        if($airport_booking->park_api == 'aph'){
            $aphactive = 1;
        }
        $parking_type ="";
        $_token ="5kZQnmKV9unuKObedug3dDWK3R6ScEFrnXQUG34X";
        $parking_name =null;
        
        
        $airport =$airport_booking->airportID;
        $dropdate = $DepartDatetemp[0];
        $pickdate =$returnDatatemp[0];
        $droptime = $DepartDatetemp[1];
        $picktime =$returnDatatemp[1];
        $total_days =$airport_booking->no_of_days;
        $discount_code =$airport_booking->discount_code;
        $discount_amount =$airport_booking->discount_amount;
        $booking_amount =$airport_booking->booking_amount;
        //dd(  $company_id);
        $request=["_token" =>"5kZQnmKV9unuKObedug3dDWK3R6ScEFrnXQUG34X",
        "title"=> $airport_booking->title,
        "firstname"=>$airport_booking->first_name,
        "lastname"=>$airport_booking->last_name,
        "email"=>$airport_booking->email,
        "company_id" =>$company_id,
        "fulladdress"=>$airport_booking->fulladdress,
        "postal_code"=> $airport_booking->postal_code,
        "product_code" =>$product_code,
        "phone_number"=>$airport_booking->phone_number,
        "parking_type" =>"Maple Parking Meet Greet Flex",
        "parking_name" =>null,
        "aphactive" =>$aphactive,
        "airport" =>$airport,
        "dropdate" =>$dropdate,
        "pickdate" => $pickdate,
        "droptime" => $droptime,
        "picktime" => $picktime ,
        "total_days" =>$total_days,
        "discount_code" =>null,
        "discount_amount" => $discount_amount,
        "booking_amount" =>  $booking_amount,
        "bookingfor" =>"airport_parking",
        "pl_id" =>null,
        "sku" =>null,
        "site_codename" =>null,
        "speed_park_active" =>null,
        "edin_active" =>null,
        "edin_search" =>null,
        "park_api"=>$airport_booking->park_api,
        "submitted" =>"airport_parking"];
        //$request1 = json_encode($request);
        
        //dd($request[dropdate']);
        $aid = $airport_booking->airportID;
        $airports = airport::all()->where("status", "Yes");


        $terminals = airports_terminals::all()->where("aid", "=", $aid);

        return view("frontend.booking-incomplete", ["data" =>$request, "settings" => $this->_setting, "airports" => $airports, "terminals" => $terminals]);
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
	
	//config('app.ABTANumber')
	
	public function getAphInfo()
		{
			//dd($request);exit;
			return array('ABTANumber'=> config('app.ABTANumber'), 'Password'=> config('app.Password'), 'Initials'=> config('app.Initials'), 'aphurl'=> config('app.aphurl'), 'aphurldetails'=>config('app.aphurldetails'));
			//echo "reached";exit;
	
		}
	
	 public function getSearchResultForTravelez(Request $request)
		{
			//dd($request);exit;
			return $this->ajaxSearchResults($request);
			//echo "reached";exit;
	
	
		}

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

		$dropdate = str_replace('/', '-', $dropdate);		
		$pickdate = str_replace('/', '-', $pickdate);
		
// new way to calculate number of days

  //       $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', '1-5-2015');
  // $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', '10-5-2015');
  // $different_days = $start_date->diffInDays($end_date);

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

                    //return redirect()->back()->withErrors($validatedData)->withInput();

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
        $total_days = $no_of_days + 1;

        if ($no_of_days > 30) {
            $total_days = '30';
        } else {
            $total_days = $no_of_days + 1;
        }
        if($total_days<=0){ $total_days=1;}
        // Calculate Days Difference From Now
        $dropdate1 = strtotime($dropdate.' '.$dropoftime);
        $c_time = date("Y-m-d H:i");
        $dropdate1 = date("Y-m-d H:i", $dropdate1);
        $datetime1 = new DateTime($c_time);
        $datetime2 = new DateTime($dropdate1);
        $interval = $datetime1->diff($datetime2);
        //$diff_date = $interval->format('%a%h');
        $hours = $interval->h;
        $hours = $hours + ($interval->days*24);
        
        //echo $hours; 
        //$search_filter .= "and fc.processtime  > '" . $hours . "'";
        //$diff_date = substr($diff_date, 1);
        ////////********** END **********///////
       $percent_filter = '';
         if(session()->get('bk_src') == 'EM'  || session()->get('bk_src') == 'BING'){
            $percent_filter = 'and share_percentage >= 12';
        }
        elseif(session()->get('bk_src') == 'PPC')
        {
            $percent_filter = 'and share_percentage >= 20';
        }
        $search_filter = $percent_filter.' '.$search_filter;
        $query = "SELECT  distinct fapp.id,fc.company_code as product_code, fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.share_percentage,fc.special_features,fc.overview, IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_" . $total_days . " >0, fapb.day_" . $total_days . "+fapp.extra, 0.00) AS price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $total_days . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and removed != 'Yes'  and airport_id = '" . $airport_id . "' and aph_id is null and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "' and fc.processtime  < " . $hours . "
                $search_filter $search_filter2 $search_filter3 
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
// 		dd($APHcompanies);
// return $APHcompanies;

		//echo "<pre>"; print_r($APHcompanies);echo "</pre>";
		//exit;
		
		$search_filter .= "and fc.processtime  < " . $hours;
		
       $aph_record = @$api->aph_record($APHcompanies, $airport_id, $search_filter); 

       //print_r($aph_record);

       if (count($aph_record) > 0) {    

            $aph_record = json_decode(json_encode($aph_record)); // convert to object

            $companies = array_merge((array) $companies, (array) $aph_record);
       } 

  
		$globalcompanies = @$aph_functions->GlobalBooking($airport_code,$dropofdate,$dropoftime,$pickupdate,$dropoftime,$airport_name);
    	$global_record =  @$api->global_record($globalcompanies, $airport_id, $search_filter);
    	$opitechcompanies = @$aph_functions->OpitechBooking($airport_code,$dropofdate,$dropoftime,$pickupdate,$dropoftime,$airport_name);
    	$opitech_record =  @$api->opitech_record($opitechcompanies, $airport_id, $search_filter);
    	
    	
    	if(!empty($global_record)){
    		
    		$global_record = json_decode(json_encode($global_record));
    		
            $companies = array_merge((array) $companies, (array) $global_record);
    	}
    	if(!empty($opitech_record)){
    		$opitech_record = json_decode(json_encode($opitech_record));
            $companies = array_merge((array) $companies, (array) $opitech_record);
    	}
		///$ACEcompanies = ACEBooking($airport_code, $dropdate, $dropoftime, $pickdate, $pickuptime);
        if(session()->get('bk_src') != 'PPC' && session()->get('bk_src') != 'BING'){
            
            $holidaycompanies = @$aph_functions->HolidayExtraBooking($airport_code,$dropdate,$dropoftime,$pickdate,$pickuptime);
        	$holiday_record =  @$api->holiday_record($holidaycompanies, $airport_id, $search_filter);
            //echo "<pre>"; print_r($holiday_record); echo "</pre>";
            //exit;
            if(!empty($holiday_record)){
        		$holiday_record = json_decode(json_encode($holiday_record));
                $companies = array_merge((array) $companies, (array) $holiday_record);
        	}
        }
       array_multisort(array_column($companies, 'share_percentage'),  SORT_DESC,
                array_column($companies, 'price'), SORT_ASC,
                $companies);
		////////view start////////////////////
		   if($airport_id == '20')
            {
            if(('00:00' <= $dropoftime ) && ($dropoftime <= '04:45'))
            {
                $companies = [];
            }
             if(('00:00' <= $pickuptime ) && ($pickuptime <= '04:45'))
            {
                 $companies = [];
            }
            }
        //   dd($companies);
		if($request->input('return_json')!='Yes')
		{
        return view("frontend.ajax_search_result", ["airports" => $airports, "companies" => $companies, "companies_special_features" => $companies_special_features, "request" => $request, "no_of_days" => $total_days, "promo" => $promo,"bookingfor"=>$bookingfor,"airport_detail"=>$airport_detail,"promo_error_message"=>$promo_error_message, 'request' => $request]);
		}
		else
		{
			return response()->json(["airports" => $airports, "companies" => $companies, "companies_special_features" => $companies_special_features, "request" => $request, "no_of_days" => $total_days, "promo" => $promo,"bookingfor"=>$bookingfor,"airport_detail"=>$airport_detail,"promo_error_message"=>$promo_error_message, 'request' => $request]);
		}

    }
    public function loadinfo(Request $request)
    {
        $id  = $request->input("id");
       
        $query = "SELECT comp.overview,comp.arival,comp.return_proc,rev.rating,rev.username,rev.title,rev.review FROM companies as comp left join reviews as rev on comp.id = rev.type_id where comp.id = ".$id."  ";
        $companies = DB::select(DB::raw($query));
        ///$reviews= reviews::all()->where("type_id", $id)->take(4)->sortByDesc("id");
        
        return json_encode($companies);
       
    }
    public function getSearchResultLounge(Request $request)
    {

        if($request->ajax()){
            return $this->ajaxSearchResultsLounge($request);
        } else {
            $airports = airport::all()->where("status", "Yes");
            //dd($reviews);
            return view("frontend.search_result_lounge" , ["airports" => $airports]);
        }


    } // end of function
    public function ajaxSearchResultsLounge($request) {

        //dd($request->all());
        $promo_error_message="";
        

        $messages = [
            'required' => 'This field is required.'
        ];
        $validatedData = Validator::make(Input::all(), [
            'airport_id' => 'required',
            'checkin_date' => 'required',
            'checkin_time' => 'required'

        ], $messages);

        $airport_id = $request->input('airport_id');

        $checkin_date = $request->input('checkin_date');
        $checkin_time = $request->input('checkin_time');
        $adults = $request->input('adults');
        $children = $request->input('children');

		$checkin_date = str_replace('/', '-', $checkin_date);	
        $checkin_date = date('Y-m-d', strtotime($checkin_date));
    	$checkin_time = date("Hi",strtotime($checkin_time));
    	
        $bookingfor = "lounges";
        $promo = $request->input('promo');
        
        
        // $filter1 = $request->input('filter1');
        
        // $filter2 = ($request->input('filter2') != '') ? $request->input('filter2') : 'low-to-high';
        // $filter3 = $request->input('filter3');
        // $search_filter = '';
        // $search_filter3 = '';
        // $search_filter2 = 'order by sort_by asc';
        // // $search_filter2 = 'order by parking_type asc';
        // if ($filter1 != '' && $filter1 != 'All') {
        //     $search_filter .= "and parking_type = '" . $filter1 . "'";
        // }
        // if ($filter2 == 'low-to-high') {
        //     $search_filter2 = "order by featured asc, recommended asc,parking_type asc, price asc";
        //     //$search_filter2 = 'ORDER BY ';
        // } elseif ($filter2 == 'high-to-low') {
        //     $search_filter2 = "order by price desc";
        // } elseif ($filter2 == 'distance') {
        //     $search_filter2 = "order by travel_time asc";
        // }
        // if ($filter3 != '') {
        //     $search_filter3 .= "and terminal = '" . $filter3 . "'";
        // }

        if ($promo != '') {
            $discount = new discounts();
            $promo_verify = $discount->varifyPromoCode($promo);

            if($promo_verify!="Verify"){
                    $validatedData->getMessageBag()->add('promo', $promo_verify);

                    //return redirect()->back()->withErrors($validatedData)->withInput();

            }


        }
        

        //return view("frontend.ajax.result", []);
        $airports = airport::all()->where("status", "Yes");

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
       
        $aph_functions = new aph_functions();
        $api = new \api();      
		
        $holidaycompanies = @$aph_functions->HolidayExtraLounges($airport_code,$checkin_date,$checkin_time,$adults,$children);
    	$holiday_record =  @$api->holiday_lounge_record($holidaycompanies, $airport_id, $search_filter);
        //  echo "<pre>"; print_r($holidaycompanies); echo "</pre>";
        // exit;
        $companies = '';
        if(!empty($holiday_record)){
    		//$all_records = array_merge($all_records, $global_record);
    		$holiday_record = json_decode(json_encode($holiday_record));
    		
            $companies = $holiday_record;
    	}
		
	    $companies= Arr::sort($companies, function($company)
        {
            // Sort the student's scores by their test score.
            return $company->price;
        });
		
		if($request->input('return_json')!='Yes')
		{
        return view("frontend.ajax_search_result_lounges", ["airports" => $airports, "companies" => $companies, "request" => $request, "promo" => $promo,"bookingfor"=>$bookingfor, "airport_detail"=>$airport_detail]);
		}
		else
		{
			return response()->json(["airports" => $airports, "companies" => $companies, "request" => $request, "promo" => $promo,"bookingfor"=>$bookingfor,"airport_detail"=>$airport_detail]);
		}

    }
    
    public function getSearchResultTransfer(Request $request)
    {

        if($request->ajax()){
            return $this->ajaxSearchResultTransfer($request);
        } else {
            $airports = airport::all()->where("status", "Yes");
            //dd($reviews);
            return view("frontend.search_result_transfer" , ["airports" => $airports]);
        }


    } // end of function
    public function ajaxSearchResultTransfer($request) {

        //dd($request->all());
        $promo_error_message="";
        


        $bookingfor = "transfer";
        
        $data = $request->all();
        
       
        $aph_functions = new aph_functions();
        $api = new \api();      
		
        $holidaycompanies = @$aph_functions->HolidayExtraTransfer($data);
    	//$holiday_record =  @$api->holiday_lounge_record($holidaycompanies, $airport_id, $search_filter);
        //echo "<pre>"; print_r($holidaycompanies); echo "</pre>";
        //exit;
        $companies = '';
        if(!empty($holidaycompanies)){
    		
            $companies = $holidaycompanies;
    	}
		//echo "<pre>"; print_r($companies); echo "</pre>";
        //exit;
	   // $companies= Arr::sort($companies, function($company)
    //     {
    //         // Sort the student's scores by their test score.
    //         return $company->price;
    //     });
		
		if($request->input('return_json')!='Yes')
		{
        return view("frontend.ajax_search_result_transfer", ["companies" => $companies, "request" => $request, "bookingfor"=>$bookingfor]);
		}
		else
		{
			return response()->json(["companies" => $companies, "request" => $request, "bookingfor"=>$bookingfor]);
		}

    }
    
    
    
}
