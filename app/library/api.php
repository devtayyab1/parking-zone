<?php
//require_once("../session.php");
use App\Company;
class api
{
    function aph_record($APHcompanies, $airport_id, $search_filter)
    {
       // global $db;
        $array1 = array();
        $array = array();

        //echo "count=".count($APHcompanies);

        foreach ($APHcompanies as $APHcompany) {
            $company_details = $this->get_records($airport_id, $APHcompany['companyID'], $search_filter);

            //$airport = DB::select( DB::raw("SELECT * from airports WHERE id = $airport_id"));
            $airport =  DB::table('airports')->whereRaw("id = $airport_id")->first();
            //$airport = $airport[0];
            $airport_name = $airport->name;
            if (empty($company_details)) {
                continue;
            }

            $array['opening_time'] = $company_details['opening_time'];
            $array['closing_time'] = $company_details['closing_time'];
            $array['id'] = $company_details['companyID'];
            $array['companyID'] = $company_details['companyID'];
            $array['aph_id'] = $APHcompany['companyID'];
			$array['product_code'] = $APHcompany['ProductCode'];
            $array['name'] = $company_details['name'];
            $array['processtime'] = $company_details['processtime'];
            $array['cancelable'] = $company_details['cancelable'];
            $array['awards'] = $company_details['awards'];
            $array['featured'] = $company_details['featured'];
            $array['recommended'] = $company_details['recommended'];
            $array['share_percentage'] = $company_details['share_percentage'];
            $array['special_features'] = $company_details['special_features'];
            $array['overview'] = $company_details['overview'];
            $array['return_proc'] = $company_details['return_proc'];
            $array['arival'] = $company_details['arival'];
            $array['terms'] = $company_details['terms'];
            $array['address'] = $company_details['address'];
            $array['town'] = $company_details['town'];
            $array['post_code'] = $company_details['post_code'];
            $array['message'] = $company_details['message'];
            $array['parking_type'] = $APHcompany['parking_type'];
            $array['parking_name'] = $APHcompany['name'] . ' ' . $airport_name;
            $array['logo'] = $company_details['logo'];
            $array['travel_time'] = $company_details['travel_time'];
            $array['miles_from_airport'] = $company_details['miles_from_airport'];
            $array['editable'] = $company_details['editable'];
            $array['bookingspace'] = $company_details['bookingspace'];
            $array['price'] = $APHcompany['price'];
            $array['park_api'] = 'aph';
            $array['aphactive'] = 1;
            //$array1[] = $array;
            $array1[] = $this->array_flatten($array);
        }
        //print_r($array1);
        //die('aph');
        $array1 = json_decode(json_encode((array)$array1), TRUE);

        return $array1;
    }

    function ace_record($ACEcompanies, $airport_id, $search_filter)
    {
        global $db;
        $array1 = array();
        $array = array();
        foreach ($ACEcompanies as $ACEcompany) {
            $companyID = explode('FP', $ACEcompany['sku']);
            $company_details = get_records($airport_id, $companyID[1], $search_filter);
            if (empty($company_details)) {
                continue;
            }

            $array['opening_time'] = $company_details['opening_time'];
            $array['closing_time'] = $company_details['closing_time'];
            $array['id'] = $company_details['companyID'];
            $array['companyID'] = $company_details['companyID'];
            $array['sku'] = $ACEcompany['sku'];
            $array['name'] = $company_details['name'];
            $array['processtime'] = $company_details['processtime'];
            $array['cancelable'] = $company_details['cancelable'];
            $array['awards'] = $company_details['awards'];
            $array['featured'] = $company_details['featured'];
            $array['recommended'] = $company_details['recommended'];
            $array['special_features'] = $company_details['special_features'];
            $array['overview'] = $company_details['overview'];
            $array['return_proc'] = $company_details['return_proc'];
            $array['arival'] = $company_details['arival'];
            $array['terms'] = $company_details['terms'];
            $array['address'] = $company_details['address'];
            $array['town'] = $company_details['town'];
            $array['post_code'] = $company_details['post_code'];
            $array['message'] = $company_details['message'];
            $array['parking_type'] = $company_details['parking_type'];
            $array['parking_name'] = $company_details['name'];
            $array['logo'] = $company_details['logo'];
            $array['travel_time'] = $company_details['travel_time'];
            $array['miles_from_airport'] = $company_details['miles_from_airport'];
            $array['editable'] = $company_details['editable'];
            $array['bookingspace'] = $company_details['bookingspace'];
            $array['price'] = $ACEcompany['price'];

            //$array1[] = $array;
            $array1[] = array_flatten($array);
        }
        $array1 = json_decode(json_encode((array)$array1), TRUE);

        return $array1;
    }


    function get_records($a_id, $cid, $search_filter)
    {
        //global $db;
        $details = '';

        if (!empty($cid) && !empty($a_id)) {
            $cid = is_numeric($cid) ? "and fc.id = '" . $cid . "'" : "and fc.aph_id = '" . $cid . "'";

//echo "<br>".$cid."<br>";

            $details = \DB::table('companies as fc')
            ->selectRaw('fc.opening_time,
                fc.closing_time,
                fc.id as companyID,
                fc.aph_id,
                fc.name,
                fc.processtime,
                fc.awards,
                fc.featured,
                fc.recommended,
                fc.share_percentage,
                fc.special_features,
                fc.overview,
                IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,
                IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,
                fc.terms,
                fc.address,
                fc.town,
                fc.post_code,
                fc.message,
                fc.parking_type,
                fc.logo,
                fc.travel_time,
                fc.miles_from_airport, 
                fc.cancelable, 
                fc.editable, 
                fc.bookingspace')
            ->whereRaw("is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter")
            //;
            //->get();
            ->first();

            //$sql = str_replace_array('?', $details->getBindings(), $details->toSql()); 
            //dd($sql);

            // $details = DB::select( DB::raw("SELECT 
            //     fc.opening_time,
            //     fc.closing_time,
            //     fc.id as companyID,
            //     fc.aph_id,
            //     fc.name,
            //     fc.processtime,
            //     fc.awards,
            //     fc.featured,
            //     fc.recommended,
            //     fc.special_features,
            //     fc.overview,
            //     IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,
            //     IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,
            //     fc.terms,
            //     fc.address,
            //     fc.town,
            //     fc.post_code,
            //     fc.message,
            //     fc.parking_type,
            //     fc.logo,
            //     fc.travel_time,
            //     fc.miles_from_airport, 
            //     fc.cancelable, 
            //     fc.editable, 
            //     fc.bookingspace
            //     FROM companies as fc WHERE is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter"
            // ));

        } //end if

        $details = json_decode(json_encode((array)$details), TRUE);
        //$details = $this->array_flatten($details);
        //$details = $details[0];

        return $details;
    }

    function global_record($globalcompanies, $airport_id, $search_filter)
    {	
    	global $db;
    	$array1 = array();
    	$array = array();
    	foreach ($globalcompanies as $globalcompany) {
    		$companyID = explode('FPP', $globalcompany['sku']);
    		
    		$company_details = $this->get_records_global($airport_id, $globalcompany['sku'], $search_filter);
       
            $airport =  DB::table('airports')->whereRaw("id = $airport_id")->first();
            
            $airport_name = $airport->name;
            if (empty($company_details)) {
                continue;
            }
    	
    		$array['opening_time'] = $company_details['opening_time'];
    		$array['closing_time'] = $company_details['closing_time'];
    		$array['id'] = $company_details['companyID'];
    		$array['aph_id'] = $company_details['aph_id'];
    		$array['companyID'] = $company_details['companyID'];
    		$array['g_quote'] = $globalcompany['quote'];
    		$array['g_token'] = $globalcompany['token'];
    		$array['sku'] = $globalcompany['sku'];
			$array['product_code'] = $globalcompany['sku'];
    		$array['name'] = $company_details['name'];
    		$array['processtime'] = $company_details['processtime'];
    		$array['cancelable'] = $company_details['cancelable'];
    		$array['awards'] = $company_details['awards'];
    		$array['featured'] = $company_details['featured'];
    		$array['recommended'] = $company_details['recommended'];
    		$array['share_percentage'] = $company_details['share_percentage'];
    		$array['special_features'] = $company_details['special_features'];
    		$array['overview'] = $company_details['overview'];
    		$array['return_proc'] = $company_details['return_proc'];
    		$array['arival'] = $company_details['arival'];
    		$array['terms'] = $company_details['terms'];
    		$array['address'] = $company_details['address'];
    		$array['town'] = $company_details['town'];
    		$array['post_code'] = $company_details['post_code'];
    		$array['message'] = $company_details['message'];
    		$array['parking_type'] = $company_details['parking_type'];
    		$array['parking_name'] = $company_details['name'];
    		$array['logo'] = $company_details['logo'];
    		$array['travel_time'] = $company_details['travel_time'];
    		$array['miles_from_airport'] = $company_details['miles_from_airport'];
    		$array['editable'] = $company_details['editable'];
    		$array['bookingspace'] = $company_details['bookingspace'];
    		$array['price'] = $globalcompany['price'];
    		$array['park_api'] = 'global';
    		
    		//$array1[] = $array;
    		$array1[] = $this->array_flatten($array);
    	}
    	$array1 = json_decode(json_encode((array)$array1), TRUE);
    
    	return $array1;
    }
    
    function opitech_record($opitechcompanies, $airport_id, $search_filter)
    {	
    	global $db;
    	$array1 = array();
    	$array = array();
    	foreach ($opitechcompanies as $opitechcompany) {
    		$company_details = $this->get_records_opitech($airport_id, $opitechcompany['sku'], $search_filter);

            $airport =  DB::table('airports')->whereRaw("id = $airport_id")->first();
            
            $airport_name = $airport->name;
            if (empty($company_details)) {
                continue;
            }
    	
    		$array['opening_time'] = $company_details['opening_time'];
    		$array['closing_time'] = $company_details['closing_time'];
    		$array['id'] = $company_details['companyID'];
    		$array['aph_id'] = $company_details['aph_id'];
    		$array['companyID'] = $company_details['companyID'];
    		$array['sku'] = $opitechcompany['sku'];
			$array['product_code'] = $opitechcompany['sku'];
			$array['g_quote'] = $opitechcompany['quote'];
			$array['g_token'] = $opitechcompany['token'];
    		$array['name'] = $company_details['name'];
    		$array['processtime'] = $company_details['processtime'];
    		$array['cancelable'] = $company_details['cancelable'];
    		$array['awards'] = $company_details['awards'];
    		$array['featured'] = $company_details['featured'];
    		$array['recommended'] = $company_details['recommended'];
    		$array['share_percentage'] = $company_details['share_percentage'];
    		$array['special_features'] = $company_details['special_features'];
    		$array['overview'] = $company_details['overview'];
    		$array['return_proc'] = $company_details['return_proc'];
    		$array['arival'] = $company_details['arival'];
    		$array['terms'] = $company_details['terms'];
    		$array['address'] = $company_details['address'];
    		$array['town'] = $company_details['town'];
    		$array['post_code'] = $company_details['post_code'];
    		$array['message'] = $company_details['message'];
    		$array['parking_type'] = $company_details['parking_type'];
    		$array['parking_name'] = $company_details['name'];
    		$array['logo'] = $company_details['logo'];
    		$array['travel_time'] = $company_details['travel_time'];
    		$array['miles_from_airport'] = $company_details['miles_from_airport'];
    		$array['editable'] = $company_details['editable'];
    		$array['bookingspace'] = $company_details['bookingspace'];
    		$array['price'] = $opitechcompany['price'];
    		$array['park_api'] = 'Opitech';
    		
    		//$array1[] = $array;
    		$array1[] = $this->array_flatten($array);
    	}
    	$array1 = json_decode(json_encode((array)$array1), TRUE);
    	//dd($array1);
    	return $array1;
    }
    
    function get_records_opitech($a_id, $cid, $search_filter)
    {
        //global $db;
        $details = '';

        if (!empty($cid) && !empty($a_id)) {
            $cid = "and fc.company_code = '" . $cid . "'";

            //echo "<br>".$cid."<br>";

            $details = \DB::table('companies as fc')
            ->selectRaw('fc.opening_time,
                fc.closing_time,
                fc.id as companyID,
                fc.aph_id,
                fc.name,
                fc.processtime,
                fc.awards,
                fc.featured,
                fc.recommended,
                fc.share_percentage,
                fc.special_features,
                fc.overview,
                IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,
                IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,
                fc.terms,
                fc.address,
                fc.town,
                fc.post_code,
                fc.message,
                fc.parking_type,
                fc.logo,
                fc.travel_time,
                fc.miles_from_airport, 
                fc.cancelable, 
                fc.editable, 
                fc.bookingspace')
            ->whereRaw("is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter")
            //;
            //->get();
            ->first();

            
            
        } //end if

        $details = json_decode(json_encode((array)$details), TRUE);
        //$details = $this->array_flatten($details);
        //$details = $details[0];

        return $details;
    }


    function get_records_global($a_id, $cid, $search_filter)
    {
        //global $db;
        $details = '';

        if (!empty($cid) && !empty($a_id)) {
            $cid = "and fc.company_code = '" . $cid . "'";

            //echo "<br>".$cid."<br>";

            $details = \DB::table('companies as fc')
            ->selectRaw('fc.opening_time,
                fc.closing_time,
                fc.id as companyID,
                fc.aph_id,
                fc.name,
                fc.processtime,
                fc.awards,
                fc.featured,
                fc.recommended,
                fc.share_percentage,
                fc.special_features,
                fc.overview,
                IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,
                IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,
                fc.terms,
                fc.address,
                fc.town,
                fc.post_code,
                fc.message,
                fc.parking_type,
                fc.logo,
                fc.travel_time,
                fc.miles_from_airport, 
                fc.cancelable, 
                fc.editable, 
                fc.bookingspace')
            ->whereRaw("is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter")
            //;
            //->get();
            ->first();

            
            
        } //end if

        $details = json_decode(json_encode((array)$details), TRUE);
        //$details = $this->array_flatten($details);
        //$details = $details[0];

        return $details;
    }
    
    function array_flatten($array) {
      if (!is_array($array)) { 
        return FALSE; 
      } 
      $result = array(); 
      foreach ($array as $key => $value) { 
        if (is_array($value)) { 
          $arrayList=array_flatten($value);
          foreach ($arrayList as $listItem) {
            $result[$key] = $listItem; 
          }
        } 
       else { 
        $result[$key] = $value; 
       } 
      } 
      return $result; 
    }
    
    function holiday_record($holidaycompanies, $airport_id, $search_filter)
    {	
    	global $db;
    	$array1 = array();
    	$array = array();
    	
    	foreach ($holidaycompanies as $holidaycompany) {
    		//$companyID = explode('FPP', $holidaycompany['sku']);
    	
    		$company_details = $this->get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);

            if (empty($company_details)) {
                
		        $company_details_api = $this->get_records_holiday($airport_id, $holidaycompany['sku'], $search_filter);
    		    $company_insert = $this->insert_holiday_record($company_details_api, $airport_id, $holidaycompany['sku']);
    		    
    	    	$company_details = $this->get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);
                //continue;
            }
    	
    		$array['opening_time'] = $company_details['opening_time'];
    		$array['closing_time'] = $company_details['closing_time'];
    		$array['id'] = $company_details['companyID'];
    		$array['aph_id'] = $company_details['aph_id'];
    		$array['companyID'] = $company_details['companyID'];
    		$array['sku'] = $holidaycompany['sku'];
			$array['product_code'] = $holidaycompany['sku'];
    		$array['name'] = $company_details['name'];
    		$array['processtime'] = $company_details['processtime'];
    		$array['cancelable'] = $company_details['cancelable'];
    		$array['awards'] = $company_details['awards'];
    		$array['featured'] = $company_details['featured'];
    		$array['recommended'] = $company_details['recommended'];
    		$array['share_percentage'] = $company_details['share_percentage'];
    		$array['special_features'] = $company_details['special_features'];
    		$array['overview'] = $company_details['overview'];
    		$array['return_proc'] = $company_details['return_proc'];
    		$array['arival'] = $company_details['arival'];
    		$array['terms'] = $company_details['terms'];
    		$array['address'] = $company_details['address'];
    		$array['town'] = $company_details['town'];
    		$array['post_code'] = $company_details['post_code'];
    		$array['message'] = $company_details['message'];
    		$array['parking_type'] = $company_details['parking_type'];
    		$array['parking_name'] = $company_details['name'];
    		$array['logo'] = $company_details['logo'];
    		$array['travel_time'] = $company_details['travel_time'];
    		$array['miles_from_airport'] = $company_details['miles_from_airport'];
    		$array['editable'] = $company_details['editable'];
    		$array['bookingspace'] = $company_details['bookingspace'];
    		$array['price'] = $holidaycompany['price'];
    		$array['park_api'] = 'holiday';
    		
    		
    		
    		
    		//$array1[] = $array;
    		$array1[] = $this->array_flatten($array);
    	}
    	$array1 = json_decode(json_encode((array)$array1), TRUE);
    	//echo "<pre>"; print_r($holidaycompanies); echo "</pre>"; exit;
    	return $array1;
    }
    function get_records_holiday_db($a_id, $cid, $search_filter)
    {
        //global $db;
        $details = '';

        if (!empty($cid) && !empty($a_id)) {
            $cid = "and fc.company_code = '" . $cid . "'";

            //echo "<br>".$cid."<br>";

            $details = \DB::table('companies as fc')
            ->selectRaw('fc.opening_time,
                fc.closing_time,
                fc.id as companyID,
                fc.aph_id,
                fc.name,
                fc.processtime,
                fc.awards,
                fc.featured,
                fc.recommended,
                fc.share_percentage,
                fc.special_features,
                fc.overview,
                IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,
                IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,
                fc.terms,
                fc.address,
                fc.town,
                fc.post_code,
                fc.message,
                fc.parking_type,
                fc.logo,
                fc.travel_time,
                fc.miles_from_airport, 
                fc.cancelable, 
                fc.editable, 
                fc.bookingspace')
            ->whereRaw("is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter")
            //;
            //->get();
            ->first();

            
            
        } //end if

        $details = json_decode(json_encode((array)$details), TRUE);
        //$details = $this->array_flatten($details);
        //$details = $details[0];

        return $details;
    }
    function get_records_holiday($a_id, $cid, $search_filter)
    {
        
        $details = '';
        $url = "https://api.holidayextras.co.uk/v1/product/".$cid.'.js';
    	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
    	$final = $url.$getString;
    	//echo $final;exit;
    	$result =  $this->curl_call($final);
    	
    	$result = json_decode($result, true);
    	
    	//echo "<pre>"; print_r($result['API_Reply']['Product'][0]); echo "</pre>"; 

        $details = $result['API_Reply']['Product'][0];
            
        return $details;
    }
    
    function insert_holiday_record($company_details, $airport_id, $holidaycompay)
    {	
    	global $db;    	
		$company = [];
        $company["name"] = $company_details['name'];
        $company["admin_id"] = 38;
        $company["company_code"] = $holidaycompay;
        $company["aph_id"] = '';
        $company["company_email"] = '';
        $company["airport_id"] = $airport_id;
        $company["terminal"] = '';

        $company["address"] = $company_details['address'];
        $company["address2"] = '';
        $company["town"] = '';
        $company["post_code"] = $company_details['postcode'];
        if($company_details['meet_and_greet'] == 1){
            $parking_type='Meet and Greet'; 
        }else{
            $parking_type='Park and Ride'; 
        }
        $company["parking_type"] = $parking_type;
        $company["closing_time"] = '00:00';
        $company["opening_time"] = '00:00';
        $company["share_percentage"] = 12;
        $company["max_discount"] = 2;
        $company["overview"] = $company_details['tripappintroduction'];

        $company["arival"] = $company_details['arrival_procedures'].'<br>'.$company_details['directions'].'<br> Phone:'.$company_details['telephone'];
        $company["return_proc"] = $company_details['departure_procedures'].'<br>'.$company_details['car_park_terms'];
        $company["returnfront"] = $company_details['departure_procedures'];
        $company["is_active"] = 'Yes';
        $company["message"] = '';
        $company["processtime"] = '';
        $recommended = '';
        if($company_details['recommended'] == 1){
            $recommended='Yes';
        }
        $company["recommended"] = $recommended;
        $company["featured"] = '';
        $company['logo'] = 'https://holidayextras.imgix.net/'.str_replace("imageLibrary","libraryimages",$company_details['logo']);
        //$company['logo'] = 'companies/bstVSos42N24S48c2W0e6MdaLr9bvUK1MIyW0x5k.png';
        // $company->levy_checked =$request->input("levy_checked");
        $company["cancelable"] = '';
        $company["editable"] = '';
        
        if($company_details['security_barrier'] == 1){
            $facility[] = 'SECURE BARRIER'; 
        }
        if($company_details['security_cctv'] == 1){
            $facility[] = 'CCTV'; 
        }
        if($company_details['security_lighting'] == 1){
            $facility[] = 'SECURITY LIGHTING'; 
        }
        if($company_details['security_patrols'] == 1){
            $facility[] = 'PATROLLED'; 
        }
        if($company_details['security_fencing'] == 1){
            $facility[] = 'FENCING'; 
        }
        if($company_details['keep_keys'] == 1){
            $facility[] = 'KEEP YOUR KEYS'; 
        }
        $facility[] = 'FAMILY FRENDLY';
        $company["special_features"] = implode(",", $facility);
        //$saveData = Company::create($company);
        
        if ($saveData = Company::create($company)) {

            $cid = $saveData->id;
            
            if($company_details['why_bookone'] != ''){
                $data1 = array("company_id" => $cid, "description" => $company_details['why_bookone'], 'type' => "company");
                DB::table('facilities')->insert($data1);
            }
            if($company_details['why_booktwo'] != ''){
                $data2 = array("company_id" => $cid, "description" => $company_details['why_booktwo'], 'type' => "company");
                DB::table('facilities')->insert($data2);
            }
            if($company_details['why_bookthree'] != ''){
                $data3 = array("company_id" => $cid, "description" => $company_details['why_bookthree'], 'type' => "company");
                DB::table('facilities')->insert($data3);
            }
            if($company_details['why_bookfour'] != ''){
                $data4 = array("company_id" => $cid, "description" => $company_details['why_bookfour'], 'type' => "company");
                DB::table('facilities')->insert($data4);
            }
        }  
    		
    }
    
    function holiday_lounge_record($holidaycompanies, $airport_id, $search_filter)
    {	
    	global $db;
    	$array1 = array();
    	$array = array();
    	foreach ($holidaycompanies as $holidaycompany) {
    		//$companyID = explode('FPP', $holidaycompany['sku']);
    		
    	
		    $company_details = $this->get_records_holiday($airport_id, $holidaycompany['sku'], $search_filter);
            //echo "<pre>"; print_r($company_details); echo "</pre>"; exit;
            if (empty($company_details)) {
                
    		    //$company_insert = $this->insert_holiday_record($company_details_api, $airport_id, $holidaycompany['sku']);
    		    
    	    	//$company_details = $this->get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);
                continue;
            }
    	
    		$array['opening_time'] = $company_details['openingtime'];
    		$array['closing_time'] = $company_details['closingtime'];
    		$array['companyID'] = $holidaycompany['sku'];
    		$array['sku'] = $holidaycompany['sku'];
			$array['product_code'] = $holidaycompany['sku'];
    		$array['name'] = $company_details['name'];
    		
    		$array['facilities'] = $company_details['facilities'];
    		$array['entertainment_facilities'] = $company_details['entertainment_facilities'];
    		$array['introduction'] = $company_details['introduction'];
    		$array['why_bookone'] = $company_details['why_bookone'];
    		$array['why_booktwo'] = $company_details['why_booktwo'];
    		$array['why_bookthree'] = $company_details['why_bookthree'];
    		$array['why_bookfour'] = $company_details['why_bookfour'];
    		$array['menu_drinks'] = $company_details['menu_drinks'];
    		$array['menu_extras'] = $company_details['menu_extras'];
    		$array['menu_food'] = $company_details['menu_food'];
    		$array['whats_included_drinks'] = $company_details['whats_included_drinks'];
    		$array['whats_included_extras'] = $company_details['whats_included_extras'];
    		$array['address'] = $company_details['address'];
    		$array['businessfacilities'] = $company_details['businessfacilities'];
    		$array['flightannouncements'] = $company_details['flightannouncements'];
    		$array['tripappintroduction'] = $company_details['tripappintroduction'];
    		$array['features'] = $company_details['_a_facilities'];
    		$array['logo'] = 'https://holidayextras.imgix.net/'.str_replace("imageLibrary","libraryimages",$company_details['logo']);
    		$array['images'] = str_replace("imageLibrary","libraryimages",$company_details['tripappimages']);
    		$array['checkintime'] = $company_details['checkintime'];
    		$array['directions'] = $company_details['directions'];
    		$array['price'] = $holidaycompany['price'];
    		$array['terminal'] = $holidaycompany['terminal'];
    		$array['booking_url'] = $holidaycompany['booking_url'];
    		$array['park_api'] = 'holiday';
    		
    		
    		
    		
    		//$array1[] = $array;
    		$array1[] = $this->array_flatten($array);
    	}
    	$array1 = json_decode(json_encode((array)$array1), TRUE);
    	//echo "<pre>"; print_r($array1); echo "</pre>"; exit;
    	return $array1;
    }
    
    
    function curl_call($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
?>