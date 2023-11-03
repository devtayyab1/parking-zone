<?php 
function AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$parkcode,$passenger,$productcode){

	$aph_details = GetAphDetails();
	$xml = '<API_Request 

				System="APH"

				Version="1.0"

				Product="CarPark"

				Customer="X"

				Session="000000004"

				RequestCode="3">

				<Agent>

				<ABTANumber>'.$aph_details['ABTANumber'].'</ABTANumber>

				<Password>'.$aph_details['Password'].'</Password>

				<Initials>'.$aph_details['Initials'].'</Initials>

				</Agent>

				<Itinerary>

				<ArrivalDate>'.$ArrivalDate.'</ArrivalDate>

				<DepartDate>'.$DepartDate.'</DepartDate>

				<ArrivalTime>'.$ArrivalTime.'</ArrivalTime>

				<DepartTime>'.$DepartTime.'</DepartTime>

				<CarParkCode>'.$parkcode.'</CarParkCode>
				<ProductCode>'.$productcode.'</ProductCode>

				<NumberOfPax>'.$passenger.'</NumberOfPax>

				</Itinerary>

				</API_Request>';
		
	$response = aph_call($xml);  

	$xml_aph = simplexml_load_string($response);

	$xml_aph = json_decode(json_encode((array)$xml_aph));

	$booking_price = $xml_aph->Pricing->TotalPrice;

	return $booking_price;

}



function AphBookingOrder($data){

//print_r($data);exit;
		$response = aph_call($data);   

		$xml_aph = simplexml_load_string($response);

		$array  = array();

		foreach($xml_aph as $item){

			$array['BookingRef'] = $xml_aph->Booking->BookingRef;

			$array['ArrivalDate'] = $xml_aph->Itinerary->ArrivalDate;

			$array['DepartDate'] = $xml_aph->Itinerary->DepartDate;

			$array['ArrivalTime'] = $xml_aph->Itinerary->ArrivalTime;

			$array['DepartTime'] = $xml_aph->Itinerary->DepartTime;

			$array['no_of_days'] = $xml_aph->Itinerary->Duration;

			$array['CarParkCode'] = $xml_aph->Itinerary->CarParkCode;

			$array['NumberOfPax'] = $xml_aph->Itinerary->NumberOfPax;

			$array['ReturnFlight'] = $xml_aph->Itinerary->ReturnFlight;

			$array['DepTerminal'] = $xml_aph->Itinerary->DepTerminal;

			$array['OutFlight'] = $xml_aph->Itinerary->OutFlight;

			$array['RetTerminal'] = $xml_aph->Itinerary->RetTerminal;

			$array['CarReg'] = $xml_aph->CarDetails->CarReg;

			$array['CarMake'] = $xml_aph->CarDetails->CarMake;

			$array['CarModel'] = $xml_aph->CarDetails->CarModel;

			$array['CarColour'] = $xml_aph->CarDetails->CarColour;

			$array['Title'] = $xml_aph->ClientDetails->Title;

			$array['Initial'] = $xml_aph->ClientDetails->Initial;

			$array['Surname'] = $xml_aph->ClientDetails->Surname;

			$array['Telephone1'] = $xml_aph->ClientDetails->Telephone1;

			$array['Telephone2'] = $xml_aph->ClientDetails->Telephone2;

		}

		$array = json_decode(json_encode((array)$array), TRUE);

		$array = array_flatten($array);

		return $array;

}



function AphBooking($data){

	$aph_details = GetAphDetails();
	$detailurl = $aph_details['aphurldetails'];
	$response = aph_call($data);  // real call
	$xml_aph = simplexml_load_string($response);

	$array  = array();

	foreach($xml_aph->CarPark as $key=>$item){

		/*if(!preg_match('/aph/',strtolower($item->CarParkName)) && !preg_match('/silver zone/',strtolower($item->CarParkName)) && !preg_match('/bristol long/',strtolower($item->CarParkName))){
			if(substr($item->CarParkCode,0,3)!='EMA' || preg_match('/jetparks/',strtolower($item->CarParkName)))
			{
			unset($item);
			}

		}*/

		if(!empty($item)){

			$nested = array();

			//$urls = "http://test.parking-quote.co.uk/APH_XML/carparkInfoXML.asp?product_code=".$item->ProductCode;

			$urls = $detailurl."?product_code=".$item->CarParkCode."_".$item->ProductCode;

			$datas = get_aph_data($urls);

			$prod_info = simplexml_load_string($datas, null, LIBXML_NOCDATA);

			if(count($prod_info)){

				$nested['companyID'] = $item->CarParkCode;

				$nested['name'] = $item->CarParkName;

				$nested['ProductCode'] = $item->ProductCode;

				$nested['parking_type'] = $item->ProductName;

				$nested['no_of_days'] = $item->Duration;

				$nested['price'] = $item->TotalPrice;

				$nested['Terminals'] = $item->Terminals;

					foreach($prod_info->Product_Code as $info){

						$nested['desc1'] = $info->Car_Park_Type;

						$nested['desc2'] = $info->Car_Park_Summary;

						$nested['direction'] = $info->Directions;

						$nested['desc3'] = $info->Reason_To_Buy;

						$nested['miles_from_airport'] = $info->Distance_From_Airport;

						$nested['travel_time'] = $info->Transfer_To_Airport;

						//$nested['Reason_To_Buy'] = $info->Reason_To_Buy;

						$nested['arival'] = $info->Arrival_Process;

						$nested['return_proc'] = $info->Departure_Process;

						$nested['Directions'] = $info->Directions;

						$nested['awards'] = $info->Parkmark_Award;	

					}

					$nested = json_decode(json_encode((array)$nested), TRUE);

					$nested = array_flatten($nested);

				$array[] = array_flatten($nested);

			}

		}//

	}

	return $array;

}



function aph_call($data) {

	//$url = "http://test.parking-quote.co.uk/xmlapi/aphxml.ASP";
	$aph_details = GetAphDetails();
	$url = $aph_details['aphurl'];

	set_time_limit(120);

	$output = array();

	$curlSession = curl_init();

	curl_setopt($curlSession, CURLOPT_URL, $url);

	curl_setopt($curlSession, CURLOPT_HEADER, 0);

	curl_setopt($curlSession, CURLOPT_POST, 1);

	curl_setopt($curlSession, CURLOPT_POSTFIELDS, "Request=".$data);

	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($curlSession, CURLOPT_TIMEOUT, 60);

	#$response = split(chr(10),curl_exec ($curlSession));

	$response = curl_exec($curlSession);

	if(curl_errno($curlSession)) {

		print curl_error($curlSession);  

	}

	curl_close($curlSession);
	file_put_contents("aph_resp.txt",json_encode($response));
	return $response;

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

function get_aph_data($url) {

	$ch = curl_init();

	$timeout = 5;

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$data = curl_exec($ch);

	curl_close($ch);

	return $data;

}

function aph_record($APHcompanies, $airport_id, $search_filter){	
//file_put_contents("library/aph_companies.txt","Req: ".date('Y-m-d H:i:s')."\r\n".print_r($APHcompanies,true)." \r\n\r\n",FILE_APPEND);
	global $db;
	$array1 = array();
	$array = array();
	foreach ($APHcompanies as $APHcompany) {
		$company_details = get_records($airport_id, $APHcompany['companyID'], $search_filter);
		if(empty($company_details)){
			continue;
		}
	
		$array['opening_time'] = $company_details['opening_time'];
		$array['closing_time'] = $company_details['closing_time'];
		$array['id'] = $company_details['companyID'];
		$array['companyID'] = $APHcompany['companyID'];
		$array['aph_id'] = $company_details['companyID'];
		$array['ProductCode'] = $APHcompany['ProductCode'];
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
		$array['parking_type'] = $APHcompany['parking_type'];
		$array['parking_name'] = $APHcompany['name'] . ' '.$airport_name;
		$array['logo'] = $company_details['logo'];
		$array['travel_time'] = $company_details['travel_time'];
		$array['miles_from_airport'] = $company_details['miles_from_airport'];
		$array['editable'] = $company_details['editable'];
		$array['bookingspace'] = $company_details['bookingspace'];
		$array['price'] = $APHcompany['price'];
		$array['aphactive'] = 1;
		$array['park_api'] = 'APH';
		//$array1[] = $array;
		$array1[] = array_flatten($array);
	}
	$array1 = json_decode(json_encode((array)$array1), TRUE);
	
	return $array1;
}


function get_records($a_id, $cid, $search_filter){
	global $db;
	$details = '';
	
	if(!empty($cid) && !empty($a_id)){
		$cid = is_numeric($cid) ?  "and fc.id = '".$cid."'" : "and fc.aph_id = '".$cid."'";
		$details =  $db->get_row("SELECT 
		fc.opening_time,
		fc.closing_time,
		fc.id as companyID,
		fc.aph_id,
		fc.name,
		fc.processtime,
		fc.awards,
		fc.featured,
		fc.recommended,
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
		fc.bookingspace
		FROM " . $db->prefix . "companies as fc WHERE is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter");
	}

	return $details;
}	



function GlobalBooking($airport_id,$from_date,$from_time,$to_date,$to_time){

	$from_date = date('Y-m-d', strtotime($from_date));
	
	$to_date = date('Y-m-d', strtotime($to_date));
	$from_time = date("H:i",strtotime($from_time));
	$to_time = date("H:i",strtotime($to_time));
		
        $url = "https://live-api.opitech.co.uk/api-search.php?";
    	$getString ="location_code=".$airport_id;
    	$getString .="&arrival_date=".$to_date."&arrival_time=".$to_time;
    	$getString .="&depart_date=".$from_date."&depart_time=".$from_time . "&agentCode=PARZ&key=GzJew9QjhzzcOsSdq4u0jpInT5xNQSA0";
    	$final = $url.$getString;
	
	$result =  curl_call($final);
	$result = json_decode($result, true);
    //echo "<pre>"; print_r($result['data']); echo "</pre>"; exit;
	//$result = Search_IN_ARRAY($result, 'status', 'Enabled');
	$data =  global_list($result);
	
	return $data;
}

function global_list($data){
	$array  = array();
	$nested  = array();
	foreach($data['data'] as $item){
		if($item['status'] == 'enabled'){
		    //$nested['id'] = $item['id'];
			$nested['price'] = $item['price'];
			$nested['sku'] = $item['sku'];
			$nested['name'] = $item['name'];
			$nested['airport'] = $item['airport'];
			$array[] = array_flatten($nested);
		}
	}
	$array = json_decode(json_encode((array)$array), TRUE);
	return $array;
}

function global_record($globalcompanies, $airport_id, $search_filter)
{	
	global $db;
	$array1 = array();
	$array = array();
	foreach ($globalcompanies as $globalcompany) {
		
		$company_details = get_records_global($airport_id, $globalcompany['sku'], $search_filter);

        if (empty($company_details)) {
            continue;
        }
	
		$array['opening_time'] = $company_details['opening_time'];
		$array['closing_time'] = $company_details['closing_time'];
		$array['id'] = $company_details['companyID'];
		$array['aph_id'] = $company_details['aph_id'];
		$array['companyID'] = $company_details['companyID'];
		$array['sku'] = $globalcompany['sku'];
		$array['product_code'] = $globalcompany['sku'];
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
		$array['price'] = $globalcompany['price'];
		$array['park_api'] = 'global';
		
		//$array1[] = $array;
		$array1[] = array_flatten($array);
	}
	$array1 = json_decode(json_encode((array)$array1), TRUE);
	
	return $array1;
}


function get_records_global($a_id, $cid, $search_filter)
{
    
    global $db;
	$details = '';
	
	if(!empty($cid) && !empty($a_id)){
	    
		$cid = "and fc.company_code = '" . $cid . "'";
		$details =  $db->get_row("SELECT 
		fc.opening_time,
		fc.closing_time,
		fc.id as companyID,
		fc.aph_id,
		fc.name,
		fc.processtime,
		fc.awards,
		fc.featured,
		fc.recommended,
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
		fc.bookingspace
		FROM " . $db->prefix . "companies as fc WHERE is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter");
	}

	return $details;
}


function HolidayExtraBooking($airport_code,$from_date,$from_time,$to_date,$to_time){
    
	$from_date = date('Y-m-d', strtotime($from_date));
	
	$to_date = date('Y-m-d', strtotime($to_date));
	$from_time = date("Hi",strtotime($from_time));
	$to_time = date("Hi",strtotime($to_time));
		
	$url = "https://api.holidayextras.co.uk/v1/carpark/".$airport_code.'.js';
	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
	$getString .="&ArrivalDate=".$from_date."&ArrivalTime=".$from_time;
	$getString .="&DepartDate=".$to_date."&DepartTime=".$to_time;
	$final = $url.$getString;
	$result = curl_call($final);
	
	$result = json_decode($result, true);
	$data = holiday_list($result);
	//echo "<pre>"; print_r($data); echo "</pre>"; exit;
	return $data;
}
function holiday_list($data){
	$array  = array();
	$nested  = array();
	foreach($data['API_Reply']['CarPark'] as $item){
		    //$nested['id'] = $item['id'];
			$nested['price'] = $item['TotalPrice'];
			$nested['sku'] = $item['Code'];
			$nested['name'] = $item['Name'];
			$nested['booking_url'] = $item['BookingURL'];
			$nested['moreinfo_url'] = $item['MoreInfoURL'];
			$array[] =array_flatten($nested);
	}
	$array = json_decode(json_encode((array)$array), TRUE);
	return $array;
}
function HolidayBookingPrice($from_date,$to_date,$from_time,$to_time,$company_id,$passenger,$product_code){
	
	$from_date = date('Y-m-d', strtotime($from_date));
	
	$to_date = date('Y-m-d', strtotime($to_date));
	$from_time = date("Hi",strtotime($from_time));
	$to_time = date("Hi",strtotime($to_time));
		
	$url = "https://api.holidayextras.co.uk/v1/carpark/".$product_code;
	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
	$getString .="&ArrivalDate=".$from_date."&ArrivalTime=".$from_time;
	$getString .="&DepartDate=".$to_date."&DepartTime=".$to_time."&NumberOfPax=".$passenger;
	$final = $url.$getString;
	

    $response =curl_call($final);
	$xml_aph = simplexml_load_string($response);
	$xml_aph = json_decode(json_encode((array)$xml_aph));

	$booking_price = $xml_aph->Pricing->TotalPrice;
	return $booking_price;
}
function HolidayBookingOrder($data, $product_code){

    $url = "https://api.holidayextras.co.uk/carpark/".$product_code;
    $data = "ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491".$data;
	$response =holidaybooking_call($data,$url);		
	
	$xml_aph = simplexml_load_string($response);
	
	$xml_aph = json_decode(json_encode((array)$xml_aph));
	
	$array  = array();
	
	$array['BookingRef'] = $xml_aph->Booking->BookingRef;
	$array['ArrivalDate'] = $xml_aph->CarPark->ArrivalDate;
	$array['DepartDate'] = $xml_aph->CarPark->DepartDate;
	$array['ArrivalTime'] = $xml_aph->CarPark->ArrivalTime;
	$array['DepartTime'] = $xml_aph->CarPark->DepartTime;
	$array['no_of_days'] = $xml_aph->CarPark->Duration;
	$array['CarParkCode'] = $xml_aph->CarPark->Code;
	$array['NumberOfPax'] = $xml_aph->CarPark->NumberOfPax;
	$array['CarReg'] = $xml_aph->CarDetails->Registration;
	$array['CarMake'] = $xml_aph->CarDetails->CarMake;
	$array['CarModel'] = $xml_aph->CarDetails->CarModel;
	$array['CarColour'] = $xml_aph->CarDetails->CarColour;
	$array['Title'] = $xml_aph->ClientDetails->Title;
	$array['Initial'] = $xml_aph->ClientDetails->Initial;
	$array['Surname'] = $xml_aph->ClientDetails->Surname;
	$array['Email'] = $xml_aph->ClientDetails->Email;
	$array['MoreInfoURL'] = $xml_aph->MoreInfoURL;
	
// 		$array = json_decode(json_encode((array)$array), TRUE);
// 		$array =array_flatten($array);
	return $array;
	
}
function holidaybooking_call($data,$url) {
    	
	set_time_limit(120);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $response = curl_exec($ch);


	file_put_contents("holiday_booking_response.txt","Req: ".date('Y-m-d H:i:s')."\r\n".$data." RES: \r\n".date('Y-m-d H:i:s')."\r\n".$response."\r\n\r\n",FILE_APPEND);

	return $response;
}    

function holiday_record($holidaycompanies, $airport_id, $search_filter)
{	
	global $db;
	$array1 = array();
	$array = array();
	
	foreach ($holidaycompanies as $holidaycompany) {
		//$companyID = explode('FPP', $holidaycompany['sku']);
	
		$company_details = get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);

        if (empty($company_details)) {
            
	        $company_details_api = get_records_holiday($airport_id, $holidaycompany['sku'], $search_filter);
		    $company_insert = insert_holiday_record($company_details_api, $airport_id, $holidaycompany['sku']);
		    
	    	$company_details = get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);
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
		$array1[] = array_flatten($array);
	}
	$array1 = json_decode(json_encode((array)$array1), TRUE);
	//echo "<pre>"; print_r($holidaycompanies); echo "</pre>"; exit;
	return $array1;
}
function get_records_holiday_db($a_id, $cid, $search_filter)
{
   
   
    global $db;
	$details = '';
	
	if(!empty($cid) && !empty($a_id)){
	    
		$cid = "and fc.company_code = '" . $cid . "'";
		$details =  $db->get_row("SELECT 
		fc.opening_time,
		fc.closing_time,
		fc.id as companyID,
		fc.aph_id,
		fc.name,
		fc.processtime,
		fc.awards,
		fc.featured,
		fc.recommended,
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
		fc.bookingspace
		FROM " . $db->prefix . "companies as fc WHERE is_active = 'Yes' and airport_id = '" . $a_id . "' $cid $search_filter");
	}

    $details = json_decode(json_encode((array)$details), TRUE);
    //$details = array_flatten($details);
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
	$result =  curl_call($final);
	
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
		
	
	    $company_details = get_records_holiday($airport_id, $holidaycompany['sku'], $search_filter);
        //echo "<pre>"; print_r($company_details); echo "</pre>"; exit;
        if (empty($company_details)) {
            
		    //$company_insert = insert_holiday_record($company_details_api, $airport_id, $holidaycompany['sku']);
		    
	    	//$company_details = get_records_holiday_db($airport_id, $holidaycompany['sku'], $search_filter);
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
		$array1[] = array_flatten($array);
	}
	$array1 = json_decode(json_encode((array)$array1), TRUE);
	//echo "<pre>"; print_r($array1); echo "</pre>"; exit;
	return $array1;
}
    
?>