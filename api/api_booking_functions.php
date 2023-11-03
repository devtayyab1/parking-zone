<?php
require "session.php";

if (isset($_POST['action']) && $_POST['action'] == 'getCompaniesForMobile') {
	global $db;
    $airport_id = $_POST['airport'];
    $dropdate = $_POST['dropdate'];
    $pickdate = $_POST['pickdate'];
    $dropoftime = $_POST['dropoftime'];
    $pickuptime = $_POST['pickuptime'];
    $no_of_days = $_POST['no_of_days'];
    $bookingfor = $_POST['bookingfor'];
    $promo = $_POST['promo'];
    $filter1 = $_POST['filter1'];
    $filter2 = ($_POST['filter2'] != '') ? $_POST['filter2'] : 'low-to-high';
    $filter3 = $_POST['filter3'];
    $search_filter = '';
    $search_filter2 = 'order by sort_by asc';
	if ($filter1 != '' && $filter1 != 'All') {
        $search_filter .= "and parking_type = '" . $filter1 . "'";
    }
    if ($filter2 == 'low-to-high') {
        $search_filter2 = "order by featured asc, recommended asc,parking_type asc, price asc";
    }
    elseif($filter2 == 'high-to-low') {
        $search_filter2 = "order by price desc";
    }
    elseif($filter2 == 'distance') {
        $search_filter2 = "order by travel_time asc";
    }
    if ($filter3 != '') {
        $search_filter3 .= "and terminal = '" . $filter3 . "'";
    }
    $html = '';
    $i = 1;
    $j = 1;
	$inactive = 0;
	$$inactiv = 0;
    $selected_date = strtotime($dropdate);
    $year = date('Y', $selected_date);
    $month = date('n', $selected_date);
    $day = date('j', $selected_date);
    if ($no_of_days > 30) {
        $total_days = '30';
    } else {
        $total_days = $no_of_days;
    }
	// Calculate Days Difference From Now 
	$dropdate1 = strtotime($dropdate);
	$c_time = date("Y-m-d");
	$dropdate1 = date("Y-m-d", $dropdate1);
	$datetime1 = new DateTime($c_time);
	$datetime2 = new DateTime($dropdate1);
	$interval = $datetime1->diff($datetime2);
	$diff_date =  $interval->format('%R%a');
	$diff_date = substr($diff_date, 1);
	////////********** END **********///////
$db->query("SET character_set_results=utf8mb4");
    $query = "SELECT  distinct fapp.id,fc.company_code as product_code, fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview, IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_" . $total_days . " >0, fapb.day_" . $total_days . "+fapp.extra, 0.00) AS price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $total_days . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and removed != 'Yes'  and airport_id = '" . $airport_id . "' and aph_id is null and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "'  $search_filter $search_filter2 $search_filter3
                ";	

				
	$html3 =  $query;

	$all_records = array();	
    $companies = $db->select($query);
	$db->query("SET character_set_results=utf8mb4");
	$airports = $db->select("SELECT * FROM " . $db->prefix . "airports WHERE id = '" . $airport_id . "'");
	
	foreach ($airports as $airport) {
		$airport_name = $airport['name'];
		$airport_code = $airport['iata_code'];
		$airport_post_code = $airport['post_code'];
		$airport_address = $airport['address'];
		$airport_town = $airport['city'];
		
	}
	//exit;
	$ArrivalDate = date('dMy', strtotime($dropdate));
	$DepartDate = date('dMy', strtotime($pickdate));
	$ArrivalTime = date("Hi",strtotime($dropoftime));
	$DepartTime = date("Hi",strtotime($pickuptime));
		
		
	if(!empty($companies)){
		//$all_records = $companies;
	}
	
/*
	$array_MG = Search_IN_ARRAY($all_records, 'parking_type', 'Meet and Greet');
	$array_PR = Search_IN_ARRAY($all_records, 'parking_type', 'Park and Ride');
	$array_OP = Search_IN_ARRAY($all_records, 'parking_type', 'On Airport');
	$all_records = array_merge($array_MG, $array_PR,$array_OP);
	*/
	
	
	if ($promo != '') {
		$promo_verify = varifyPromoCode($promo);
			
		if($promo_verify!="Verify"){
				$promo_verify_msg = $promo_verify;
				$promo_verify_msg = '<div class="alert alert-danger">
									<strong>Alert!</strong> '.$promo_verify.'</div>';
		}
	}
    
	$aph_details = GetAphDetails();
	//if($_COOKIE['traffic']!='PPC'){
		
	$xml = '<API_Request
		System="APH"
		Version="1.0"
		Product="CarPark"
		Customer="X"
		Session="000000003"
		RequestCode="11">
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
		<Location>'.$airport_code.'</Location>
		<Terminals>ALL</Terminals>
		</Itinerary>
		</API_Request>';
	

	$APHcompanies = AphBooking($xml);
	
	if(sizeof($APHcompanies)>1) {$aph_record = aph_record($APHcompanies, $airport_id, $search_filter);}

	if(!empty($aph_record)){
		$aph_record = json_decode(json_encode($aph_record)); // convert to object

        $all_records = array_merge((array) $all_records, (array) $aph_record);
	}
	
	
	
	
	array_multisort(array_column($all_records, 'price'), SORT_ASC, $all_records);
	
	
    echo json_encode(array('all_records'=>$all_records));
}





if (isset($_POST['action']) && $_POST['action'] == 'getCompanies') {
	global $db;
    $airport_id = $_POST['airport'];
    $dropdate = $_POST['dropdate'];
    $pickdate = $_POST['pickdate'];
    $dropoftime = $_POST['dropoftime'];
    $pickuptime = $_POST['pickuptime'];
    $no_of_days = $_POST['no_of_days'];
    $bookingfor = $_POST['bookingfor'];
    $promo = $_POST['promo'];
    $filter1 = $_POST['filter1'];
    //$filter2 = $_POST['filter2'];
    $filter2 = ($_POST['filter2'] != '') ? $_POST['filter2'] : 'low-to-high';
    $filter3 = $_POST['filter3'];
    $search_filter = '';
    $search_filter2 = 'order by sort_by asc';
    // $search_filter2 = 'order by parking_type asc';
    // if ($filter1 == '' && $filter1 == 'All') {
		 // $search_filter .= "order by FIELD(parking_type, 'MEET AND GREET','PARK AND RIDE'), price asc";
	// }
	if ($filter1 != '' && $filter1 != 'All') {
        $search_filter .= "and parking_type = '" . $filter1 . "'";
    }
    if ($filter2 == 'low-to-high') {
        $search_filter2 = "order by featured asc, recommended asc,parking_type asc, price asc";
		//$search_filter2 = 'ORDER BY ';
    }
    elseif($filter2 == 'high-to-low') {
        $search_filter2 = "order by price desc";
    }
    elseif($filter2 == 'distance') {
        $search_filter2 = "order by travel_time asc";
    }
    if ($filter3 != '') {
        $search_filter3 .= "and terminal = '" . $filter3 . "'";
    }
    $html = '';
    $i = 1;
    $j = 1;
	$inactive = 0;
	$$inactiv = 0;
    $selected_date = strtotime($dropdate);
    $year = date('Y', $selected_date);
    $month = date('n', $selected_date);
    $day = date('j', $selected_date);
    if ($no_of_days > 30) {
        $total_days = '30';
    } else {
        $total_days = $no_of_days;
    }
	// Calculate Days Difference From Now 
	$dropdate1 = strtotime($dropdate);
	$c_time = date("Y-m-d");
	$dropdate1 = date("Y-m-d", $dropdate1);
	$datetime1 = new DateTime($c_time);
	$datetime2 = new DateTime($dropdate1);
	$interval = $datetime1->diff($datetime2);
	$diff_date =  $interval->format('%R%a');
	$diff_date = substr($diff_date, 1);
	////////********** END **********///////
    //$_h_differance = getHoursDifference($dropoftime); 
	//IF( fapb.day_$total_days >0, fapb.day_$total_days+fapp.extra, 0.00) AS price
$db->query("SET character_set_results=utf8mb4");
    $query = "SELECT  distinct fapp.id,fc.company_code as product_code, fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview, IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_" . $total_days . " >0, fapb.day_" . $total_days . "+fapp.extra, 0.00) AS price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $total_days . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and removed != 'Yes'  and airport_id = '" . $airport_id . "' and aph_id is null and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "'  $search_filter $search_filter2 $search_filter3
                ";	

				
	$html3 =  $query;

	$all_records = array();	
    $companies = $db->select($query);
	$db->query("SET character_set_results=utf8mb4");
	$airports = $db->select("SELECT * FROM " . $db->prefix . "airports WHERE id = '" . $airport_id . "'");
	
	foreach ($airports as $airport) {
		$airport_name = $airport['name'];
		$airport_code = $airport['iata_code'];
		$airport_post_code = $airport['post_code'];
		$airport_address = $airport['address'];
		$airport_town = $airport['city'];
		
	}
	//exit;
	$ArrivalDate = date('dMy', strtotime($dropdate));
	$DepartDate = date('dMy', strtotime($pickdate));
	$ArrivalTime = date("Hi",strtotime($dropoftime));
	$DepartTime = date("Hi",strtotime($pickuptime));
		
		
	if(!empty($companies)){
		$all_records = $companies;
	}
	
/*
	$array_MG = Search_IN_ARRAY($all_records, 'parking_type', 'Meet and Greet');
	$array_PR = Search_IN_ARRAY($all_records, 'parking_type', 'Park and Ride');
	$array_OP = Search_IN_ARRAY($all_records, 'parking_type', 'On Airport');
	$all_records = array_merge($array_MG, $array_PR,$array_OP);
	*/
	
	
	if ($promo != '') {
		$promo_verify = varifyPromoCode($promo);
			
		if($promo_verify!="Verify"){
				$promo_verify_msg = $promo_verify;
				$promo_verify_msg = '<div class="alert alert-danger">
									<strong>Alert!</strong> '.$promo_verify.'</div>';
		}
	}
    
	$aph_details = GetAphDetails();
	//if($_COOKIE['traffic']!='PPC'){
		
		$xml = '<API_Request
		System="APH"
		Version="1.0"
		Product="CarPark"
		Customer="X"
		Session="000000003"
		RequestCode="11">
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
		<Location>'.$airport_code.'</Location>
		<Terminals>ALL</Terminals>
		</Itinerary>
		</API_Request>';
	
	//echo json_encode(array('all_records'=>$xml,'promo_verify'=>$promo_verify));
	//exit;
	$APHcompanies = AphBooking($xml);
	
	if(sizeof($APHcompanies)>1) {$aph_record = aph_record($APHcompanies, $airport_id, $search_filter);}
	//}
	//echo "<pre>"; print_r($APHcompanies); echo "</pre>";exit;
	if(!empty($aph_record)){
		//$all_records = array_merge($all_records, $aph_record);
		$aph_record = json_decode(json_encode($aph_record)); // convert to object

        $all_records = array_merge((array) $all_records, (array) $aph_record);
	}
	
	$globalcompanies = GlobalBooking($airport_code,$dropdate,$dropoftime,$pickdate,$pickuptime);
	
	$global_record =  global_record($globalcompanies, $airport_id, $search_filter);
	
	//echo "<pre>"; print_r($ACEcompanies); echo "</pre>"; 
	//echo "<pre>"; print_r($global_record); echo "</pre>";
    //exit;
	if(!empty($global_record)){
		//$all_records = array_merge($all_records, $global_record);
		$global_record = json_decode(json_encode($global_record));
		
        $all_records = array_merge((array) $all_records, (array) $global_record);
	}
	
	$holidaycompanies = HolidayExtraBooking($airport_code,$dropdate,$dropoftime,$pickdate,$pickuptime);
	$holiday_record =  holiday_record($holidaycompanies, $airport_id, $search_filter);
	//echo "<pre>"; print_r($holiday_record); echo "</pre>";exit;
	if(!empty($holiday_record)){
		//$all_records = array_merge($all_records, $global_record);
		$holiday_record = json_decode(json_encode($holiday_record));
		
        $all_records = array_merge((array) $all_records, (array) $holiday_record);
	}
	
	
	array_multisort(array_column($all_records, 'price'), SORT_ASC, $all_records);
	
	// $array_featured = Search_IN_ARRAY($all_records, 'featured', 'Yes');
	// $array_recommended = Search_IN_ARRAY($all_records, 'recommended', 'Yes');
	// $all_records_F_R = array_merge($array_featured, $array_recommended);
	// $array_featured_NO = Search_IN_ARRAY($all_records, 'featured', 'No');
	// $array_recommended_NO_featured = Search_IN_ARRAY($array_featured_NO, 'recommended', 'No');
	// $array_recommended_NO_featured = sort_filter($array_recommended_NO_featured,'price','asc');
	// $all_records = array_merge($all_records_F_R, $array_recommended_NO_featured);
	
    echo json_encode(array('all_records'=>$all_records,'promo_verify'=>$promo_verify));
}

elseif (isset($_POST['action']) && $_POST['action'] == 'getParkingPagePrice') { 
	$airport_id = $_POST['airport_id'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
	$total_days = $_POST['total_days'];
$companies = $db->select("SELECT fc.id as companyID,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview,IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace,
	fapp.id, fasb.brand, fapb.after_30_days, IF( fapb.day_$total_days >0, fapb.day_$total_days, 0.00) AS price FROM " . $db->prefix . "companies as fc
	 left join " . $db->prefix . "airport_price_plan as fapp on fc.id = fapp.company_id
	 left join " . $db->prefix . "airport_select_brand as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $day . "'
	 left join " . $db->prefix . "airport_price_brands as fapb on fapb.companyId = fc.id and fapb.brand = fasb.brand
	 WHERE is_active = 'Yes' and fc.name not LIKE '%Paige %' and airport_id = '" . $airport_id . "' and fapp.month = '" . $month . "' and fapp.year = '" . $year . "' order by price asc");
	 echo json_encode($companies);
}

elseif (isset($_POST['action']) && $_POST['action'] == 'getCompany') { 
	
	$companies_closing = $db->select("Select * from " . $db->prefix . "companies_closed where company_id = '".$_POST["companyID"]."' && closing_date = '".$_POST["p_day"]."'  && closing_month	= '".$_POST["p_month"]."'  && closing_year	= '".$_POST["p_year"]."'  ");
	
	if($companies_closing){
		
				echo "blur";exit;
			}
	$companies_closing1 = $db->select("Select * from " . $db->prefix . "companies_closed where company_id = '".$_POST["companyID"]."' && closing_date = '".$_POST["d_day"]."'  && closing_month	= '".$_POST["d_month"]."'  && closing_year	= '".$_POST["d_year"]."'  ");
	
	if($companies_closing1){
		
				echo "blur";exit;
			}
} //Awards
elseif (isset($_POST['action']) && $_POST['action'] == 'getAwards') { 
	$html = '';
	$awards = $db->select("SELECT * FROM " . $db->prefix . "companies_assign_awards WHERE cid = '" . $_POST['company_id'] . "'");
	foreach($awards as $keys){
		$award = $db->select("SELECT * FROM " . $db->prefix . "awards WHERE id = '" . $keys['award_id'] . "'");
		if ( $award[0]['image'] != '' ) {

			$html .= '<img src="https://www.parkingzone.co.uk/storage/app/'.$award[0]['image'].'" alt="'.$award[0]['awardname'].'" class="img-responsive awards">';
			
		}
	}
	echo json_encode($html);
} //Facilities
elseif (isset($_POST['action']) && $_POST['action'] == 'getCompanyFacilities') { 
	$html = '';
	$db->query("SET character_set_results=utf8mb4");
	 $facilities = $db->select("SELECT * FROM " . $db->prefix . "facilities WHERE company_id = '" . $_POST['company_id'] . "' and type = 'company' limit 0,3 ");
            
	echo json_encode($facilities);
}//Get All Airports
elseif (isset($_POST['action']) && $_POST['action'] == 'get_all_airports') { 
	$db->query("SET character_set_results=utf8mb4");
	$all_airports = $db->get_airports();
	echo json_encode($all_airports);
}//Get Airports
elseif (isset($_POST['action']) && $_POST['action'] == 'get_airports') { 
$db->query("SET character_set_results=utf8mb4");
	$airports = $db->select("SELECT * FROM " . $db->prefix . "airports WHERE status = 'Yes' ORDER BY name ASC");
	echo json_encode($airports);
} //Verify Promo
elseif (isset($_POST['action']) && $_POST['action'] == 'varifyPromoCode') { 
	$promo_verify = varifyPromoCode($_POST['promoCode']);
	echo json_encode($promo_verify);
} //Company Levy
elseif (isset($_POST['action']) && $_POST['action'] == 'get_company_levy') { 
	$l_fee = get_company_levy($_POST["company_id"]);
	echo json_encode($l_fee);
} //Booking Price
elseif (isset($_POST['action']) && $_POST['action'] == 'get_booking_price') { 
	$booking_amount = APBookingPrice($_POST["company_id"], $_POST["aid"], $_POST["no_of_days"], $_POST["checkindate"]);
	echo json_encode($booking_amount);
} //Check Extra Price
elseif (isset($_POST['action']) && $_POST['action'] == 'get_total_with_extra') { 
	$booking_amount = check_extra($_POST["company_id"], $_POST["pl_id"], $_POST["booking_amount"]);
	echo json_encode($booking_amount);
} //Check Extra Price
elseif (isset($_POST['action']) && $_POST['action'] == 'get_extra_amount') { 
	$extra_amount = extra_amount($_POST["company_id"], $_POST["pl_id"]);
	echo json_encode($extra_amount);
} //Check Maximum Promo Discount
elseif (isset($_POST['action']) && $_POST['action'] == 'get_max_discount') { 
	$max_disc = $db->get_row("SELECT * FROM " . $db->prefix . "companies WHERE (id = '".$_POST['company_id']."' OR aph_id = '".$_POST['company_id']."')");
	echo json_encode($max_disc);
}  //Get Price Plan
elseif (isset($_POST['action']) && $_POST['action'] == 'get_price_plan') { 
	$pl_id  = $db->get_row ("SELECT * FROM " . $db->prefix ."airport_price_plan  WHERE company_id = '".$_POST['company_id']."'");
	echo json_encode($pl_id);
}//Get company by id
elseif (isset($_POST['action']) && $_POST['action'] == 'get_company_byid') { 
	$db->query("SET character_set_results=utf8mb4");
	$company = $db->get_row("Select * from " . $db->prefix . "companies where id='".$_POST['company_id']."' OR aph_id='".$_POST['company_id']."'");
	echo json_encode($company);
}//Get API Module Settings
elseif (isset($_POST['action']) && $_POST['action'] == 'getApiModuleSettings') { 
	$db->query("SET character_set_results=utf8mb4");
	$settings = $db->select("SELECT * FROM " . $db->prefix . "settings");
        foreach ($settings as $setting) {
            $_settings[$setting['field_name']] = $setting['field_value'];
        }
	echo json_encode($_settings);
}//Get companies
elseif (isset($_POST['action']) && $_POST['action'] == 'get_companies') { 
	$companies = $db->get_companies();
	echo json_encode($companies);
}//Get admins
elseif (isset($_POST['action']) && $_POST['action'] == 'get_admins') { 
	$admins = $db->get_users();
	echo json_encode($admins);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'AP_notifications') {
	$email_notify = notifications($_POST['BookID'], $_POST['email_type'], $_POST['email']);
	echo json_encode($email_notify);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'AP_sms') {
	$sms_notify = send_sms($_POST['phone_no'], $_POST['book_ref']);
	echo json_encode($sms_notify);
}//Get Airport 
elseif (isset($_POST['action']) && $_POST['action'] == 'get_airport_byid') { 
$db->query("SET character_set_results=utf8mb4");
	$airport = $db->get_row("SELECT * FROM " . $db->prefix . "airports WHERE status = 'Yes' and id=".$_POST['airport_id']." ORDER BY name ASC");
	//$airport = $db->get_airports($_POST['airport_id']);
	echo json_encode($airport);
}//Get Airport terminals
elseif (isset($_POST['action']) && $_POST['action'] == 'get_airport_terminals') { 
	$terminals = $db->select("select * from " . $db->prefix . "airports_terminals where aid = '" . $_POST['airport_id'] . "'");
	echo json_encode($terminals);
}//Get All Airport terminals
elseif (isset($_POST['action']) && $_POST['action'] == 'get_all_airport_terminals') { 
	$terminals = $db->get_terminals();
	echo json_encode($terminals);
} //Get aph company info
elseif (isset($_POST['action']) && $_POST['action'] == 'get_aph_company') { 
	$aph_company = $db->get_row ("SELECT * FROM " . $db->prefix ."companies  WHERE aph_id = '".$_POST['company_id']."'");
	echo json_encode($aph_company);
} //Get Terminal by ID
elseif (isset($_POST['action']) && $_POST['action'] == 'get_terminal_byid') { 
	$terminal_byid = $db->get_row("select name from ".$db->prefix."airports_terminals where id = '".$_POST['terminal_id']."'");
	echo json_encode($terminal_byid);
}   //Get Update Price for admin amend booking
elseif (isset($_POST['action']) && $_POST['action'] == 'getbookingPriceupdate') { 
	$updated_price_companies = $db->select($_POST['query']);
	echo json_encode($updated_price_companies);
}  
elseif(isset($_POST['action']) && $_POST['action'] == 'getbookingFee')
{
	$db->query("SET character_set_results=utf8mb4");
	$booking = $db->select("SELECT field_value FROM " . $db->prefix . "settings WHERE id = 48");
    echo json_encode($booking[0]['field_value']);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getReviews')
{
	$db->query("SET character_set_results=utf8mb4");
	 $reviews = $db->select("SELECT * FROM " . $db->prefix . "reviews where status= 'Yes' && type_id = '".$_POST['company_id']."' ORDER BY id desc");
    echo json_encode($reviews);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getRandomReviews')
{
	$db->query("SET character_set_results=utf8mb4");
	 $reviews = $db->select("SELECT * FROM " . $db->prefix . "reviews where status= 'Yes' and rating>3 ORDER BY RAND() limit ".$_POST['limit_val']);
    echo json_encode($reviews);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'AddApBooking')
{
	$booking_data = $_POST;
	$_bookID = $db->insert("INSERT INTO " . $db->prefix . "airports_bookings SET
                        airportID       ='". $booking_data['airport']."',
                        companyId       ='". $booking_data['company_id']."',
						product_code    ='". $booking_data['product_code']."',
						PayerID         ='". $booking_data['intent_id']."',
                        customerId      ='". $booking_data['customer_id']."',
                        title           ='". $booking_data['title']."',
                        first_name      ='". $booking_data['firstname']."',
                        last_name       ='". $booking_data['lastname']."',
                        email           ='". $booking_data['email']."',
                        phone_number    ='". $booking_data['contactno']."',
                        fulladdress     ='". $booking_data['fulladdress']."',
                        address         ='". $booking_data['address']."',
                        address2        ='". $booking_data['address2']."',
                        town            ='". $booking_data['town']."',
                        postal_code     ='". $booking_data['postcode']."',
                        passenger       ='". $booking_data['passenger']."',
                        departDate      ='". $booking_data['departDate']."',
                        deprTerminal    ='". $booking_data['departterminal']."',
                        deptFlight      ='". $booking_data['flightnumber']."',
                        returnDate      ='". $booking_data['returnDate']."',
                        returnTerminal  ='". $booking_data['arrivalterminal']."',
                        returnFlight    ='". $booking_data['returnflight']."',
                        no_of_days      ='". $booking_data['total_days']."',
                        discount_code   ='". $booking_data['promo']."',
                        discount_amount ='". $booking_data['discount_amount']."',
                        booking_amount  ='". $booking_data['booking_amount']."',
                        booking_extra   ='". $booking_data['extra_amount']."',
                        smsfee          ='". $booking_data['smsfee_charged']."',
                        booking_fee     ='". $booking_data['bookingfee']."',
                        cancelfee       ='". $booking_data['cancelfee_charged']."',
                        total_amount    ='". $booking_data['total_amount']."',
						leavy_fee       ='". $booking_data['l_fee']."',
                        booked_type     ='". $booking_data['parking_type']."',
                        browser_data    ='". $booking_data['browser_data']."',
                        createdate      ='".$db->php_now()."',
                        traffic_src     ='". $booking_data['traffic_src']."',
                        user_ip         ='". $booking_data['ip']."',
						make         	='". $booking_data['make']."',
						model           ='". $booking_data['model']."',
						color           ='". $booking_data['color']."',
						registration    ='". $booking_data['registration']."',
						agentID			='". $booking_data['agent_id']."',
                        modifydate      = '".$db->php_now()."' ");
						
    echo json_encode($_bookID);exit;
}
elseif(isset($_POST['action']) && $_POST['action'] == 'UpdateApBooking')
{
	$booking_data = $_POST;
	$_bookID = $db->insert("UPDATE " . $db->prefix . "airports_bookings SET
                        airportID       ='". $booking_data['airport']."',
                        companyId       ='". $booking_data['company_id']."',
						product_code    ='". $booking_data['product_code']."',
						PayerID         ='". $booking_data['intent_id']."',
                        customerId      ='". $booking_data['customer_id']."',
                        title           ='". $booking_data['title']."',
                        first_name      ='". $booking_data['firstname']."',
                        last_name       ='". $booking_data['lastname']."',
                        email           ='". $booking_data['email']."',
                        phone_number    ='". $booking_data['contactno']."',
                        fulladdress     ='". $booking_data['fulladdress']."',
                        address         ='". $booking_data['address']."',
                        address2        ='". $booking_data['address2']."',
                        town            ='". $booking_data['town']."',
                        postal_code     ='". $booking_data['postcode']."',
                        passenger       ='". $booking_data['passenger']."',
                        departDate      ='". $booking_data['departDate']."',
                        deprTerminal    ='". $booking_data['departterminal']."',
                        deptFlight      ='". $booking_data['flightnumber']."',
                        returnDate      ='". $booking_data['returnDate']."',
                        returnTerminal  ='". $booking_data['arrivalterminal']."',
                        returnFlight    ='". $booking_data['returnflight']."',
                        no_of_days      ='". $booking_data['total_days']."',
                        discount_code   ='". $booking_data['promo']."',
                        discount_amount ='". $booking_data['discount_amount']."',
                        booking_amount  ='". $booking_data['booking_amount']."',
                        booking_extra   ='". $booking_data['extra_amount']."',
                        smsfee          ='". $booking_data['smsfee_charged']."',
                        booking_fee     ='". $booking_data['bookingfee']."',
                        cancelfee       ='". $booking_data['cancelfee_charged']."',
                        total_amount    ='". $booking_data['total_amount']."',
						leavy_fee       ='". $booking_data['l_fee']."',
                        booked_type     ='". $booking_data['parking_type']."',
                        browser_data    ='". $booking_data['browser_data']."',
                        createdate      ='".$db->php_now()."',
                        traffic_src     ='". $booking_data['traffic_src']."',
                        user_ip         ='". $booking_data['ip']."',
						make         	='". $booking_data['make']."',
						model           ='". $booking_data['model']."',
						color           ='". $booking_data['color']."',
						registration    ='". $booking_data['registration']."',
                        modifydate      = '".$db->php_now()."' 
						WHERE referenceNo='".$booking_data['referenceNo']."'
						");
						
    echo json_encode($_bookID);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'UpdateBookingByQuery')
{
	$_bookID = $db->insert($_POST['query']);
						
    echo json_encode($_bookID);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'UpdateApBookingReference')
{
	
	$_bookID = $db->insert("UPDATE " . $db->prefix . "airports_bookings SET
                        referenceNo       ='". $_POST['referenceNo']."'
						WHERE id='".$_POST['id']."'
						");
				
    echo json_encode($_bookID);

}
elseif(isset($_POST['action']) && $_POST['action'] == 'getBookIdByRef')
{
	$db->query("SET character_set_results=utf8mb4");
	$_bookID_reff = $db->get_row("SELECT * FROM ".$db->prefix."airports_bookings WHERE referenceNo = '".$_POST['refr']."'");
    echo json_encode($_bookID_reff);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getApBookById')
{
	$db->query("SET character_set_results=utf8mb4");
	$_bookID = $db->get_row("SELECT * FROM ".$db->prefix."airports_bookings WHERE id = '".$_POST['id']."'");
    echo json_encode($_bookID);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getTableRow')
{
	$db->query("SET character_set_results=utf8mb4");
	$_single_record = $db->get_row("SELECT * FROM ".$db->prefix.$_POST['table_name']." '".$_POST['where']."' '".$_POST['orderby']."'");
    echo json_encode($_single_record);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getApBookings')
{
	$db->query("SET character_set_results=utf8mb4");
	$BookingRecords = $db->select("SELECT * FROM ".$db->prefix."airports_bookings '".$_POST['where']."' '".$_POST['orderby']."'");
    echo json_encode($BookingRecords);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getCustomer')
{
	$db->query("SET character_set_results=utf8mb4");
	$customer = $db->get_row("SELECT * FROM " . $db->prefix . "customers WHERE  email = '".$_POST['email']."'");
    echo json_encode($customer);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'update_customer')
{
	$customer_id = $db->update("UPDATE " . $db->prefix . "customers SET title='". $_POST['title']."',	first_name = '".$_POST['firstname']."', last_name = '".$_POST['lastname']."', phone_number = '".$_POST['contactno']."', password = '".md5($_POST['pass'])."', postal_code = '".$_POST['postcode']."', address = '".$_POST['address']."', address2 = '".$_POST['address2']."', town = '".$_POST['town']."', added_on = '".$db->php_now()."', update_on = '".$db->php_now()."', email = '".$_POST['email']."' where id = '".$_POST['userID']."'");
    echo json_encode($customer_id);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'insert_customer')
{
	$customer_id = $db->insert("INSERT INTO " . $db->prefix . "customers SET title='". $_POST['title']."',	first_name = '".$_POST['firstname']."', last_name = '".$_POST['lastname']."', phone_number = '".$_POST['contactno']."', password = '".md5($_POST['pass'])."', postal_code = '".$_POST['postcode']."', address = '".$_POST['address']."', address2 = '".$_POST['address2']."', town = '".$_POST['town']."', added_on = '".$db->php_now()."', update_on = '".$db->php_now()."', email = '".$_POST['email']."'");
    echo json_encode($customer_id);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'AphBookingPrice')
{
	$aph_booking_amount = AphBookingPrice($_POST['ArrivalDate'],$_POST['DepartDate'],$_POST['ArrivalTime'],$_POST['DepartTime'],$_POST['parkcode'],$_POST['passenger'],$_POST['productcode']);
    echo json_encode($aph_booking_amount);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'HolidayBookingPrice')
{
	$booking_amount = HolidayBookingPrice($_POST['ArrivalDate'],$_POST['DepartDate'],$_POST['ArrivalTime'],$_POST['DepartTime'],$_POST['parkcode'],$_POST['passenger'],$_POST['productcode']);
    echo json_encode($booking_amount);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'HolidayBookingOrder')
{
    //print_r($_POST['data']);exit;
	$aph_booking_order = HolidayBookingOrder($_POST['data'], $_POST['product_code']);
    echo json_encode($aph_booking_order);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'AphBookingOrder')
{
    //print_r($_POST['data']);exit;
	$aph_booking_order = AphBookingOrder($_POST['data']);
    echo json_encode($aph_booking_order);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'AphBooking')
{
	$aph_booking = AphBooking($_POST['data']);
    echo json_encode($aph_booking);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'AphBookingOrderMobile')
{
    $data = '<API_Request 
						System="APH"
						Version="1.0"
						Product="CarPark"
						Customer="X"
						Session="000000006"
						RequestCode="5">
						<Agent>
							<ABTANumber>PZINV</ABTANumber>

							<Password>KDHSY</Password>
			
							<Initials>PZ</Initials>
						</Agent>
						<Itinerary>
							<ArrivalDate>'.$_POST['ArrivalDate'].'</ArrivalDate>
							<DepartDate>'.$_POST['DepartDate'].'</DepartDate>
							<ArrivalTime>'.$_POST['ArrivalTime'].'</ArrivalTime>
							<DepartTime>'.$_POST['DepartTime'].'</DepartTime>
							<Duration>'.$_POST['no_of_days'].'</Duration>
							<CarParkCode>'.$_POST['companycode'].'</CarParkCode>
							<ProductCode>'.$_POST['product_code'].'</ProductCode>
							<NumberOfPax>'.$_POST['passenger'].'</NumberOfPax>
							<ReturnFlight>'.$_POST['returnFlight'].'</ReturnFlight>
							<DepTerminal>'.$_POST['terminal'].'</DepTerminal>
							<OutFlight>NA</OutFlight>
							<RetTerminal>'.$_POST['rterminal'].'</RetTerminal>
						</Itinerary>
						<CarDetails>
							<CarReg>'.$_POST['registration'].'</CarReg>
							<CarMake>'.$_POST['make'].'</CarMake>
							<CarModel>'.$_POST['model'].'</CarModel>
							<CarColour>'.$_POST['color'].'</CarColour>
						</CarDetails>
						<ClientDetails>
							<Title>'.$_POST['title'].'</Title>
							<Initial>'.$_POST['first_name'].'</Initial>
							<Surname>'.$_POST['last_name'].'</Surname>
							<Telephone1>'.$_POST['phone_number'].'</Telephone1>
							<Telephone2></Telephone2>
						</ClientDetails>
					</API_Request>	';
	
    //print_r($data);exit;
				
	$aph_booking_order = AphBookingOrder($data);
    echo json_encode($aph_booking_order);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getPromoDiscount')
{
	$promoCode = $_POST['promoCode'];
	$booking_price = $_POST['booking_price'];
	$type = $_POST['type']!=''?$_POST['type']:'airport_parking';
	$company_id = $_POST['company_id'];
	$client_ip = $_POST['client_ip'];
	$_traffic_src = $_POST['traffic_src'];
	if ($promoCode == '' || $promoCode == 'BLFRIDAY10') {
            return 0.00;
        }
		$book_type = "";

		if($type=='airport_parking'){
			$book_type = 'airport_parking';
		}
		
		// if(!$_COOKIE['traffic']){
			// $discount_for = 'Og';
		// }
		// else{
			$Discount_filter='';
		
		// $discount_for = 'FB';
		// }
		
		$promoDetails = $db->get_row("SELECT * FROM " . $db->prefix . "discounts
                            WHERE promo = '".$promoCode."' AND status = 'Yes' AND parking_type = '".$book_type."' 
							$Discount_filter  AND start_date <= '".date("Y-m-d")."' AND end_date >= '".date("Y-m-d")."'");
							
		if($_traffic_src == "PPC"){
			if ($promoDetails['discount_for'] == 'PPC') {
				$promoDetails['discount_value'] = $promoDetails['discount_value'];
			}
			else{
				$promoDetails['discount_value'] = '2.00';
			}
		}
													   
        if ($promoDetails['discount_type'] == 'percent' && $_SESSION["por_src"]!='Active' && $_COOKIE['traffic']!='POR') {
			if($company_id!=''){
				$max_disc = $db->get_row("SELECT * FROM " . $db->prefix . "companies WHERE (id = '".$company_id."' OR aph_id = '".$company_id."')");
				
				if($max_disc['max_discount']!=''){
					if($max_disc['max_discount'] < $promoDetails['discount_value']){
						$promoDetails['discount_value'] = $max_disc['max_discount'];
					}
				}
			}
            $discount_amount = ($booking_price / 100) * $promoDetails['discount_value'];
			//file_put_contents("library/discount_query.txt",$discount_amount);
			echo json_encode(round($discount_amount,2));
        }
        if ($promoDetails['discount_type'] == 'gdp') {
			echo json_encode($promoDetails['discount_value']);
        }
		
		if($promoDetails['discount_value']=='' || $_SESSION["por_src"]=='Active' || $_COOKIE['traffic']=='POR')
		{
			//$discount_amount = ($booking_price / 100)*1;
           // return round($discount_amount,2);
		   echo json_encode($promoDetails['discount_value']); 
		}
}
elseif(isset($_POST['action']) && $_POST['action'] == 'getHotelInfo')
{
    $hotelid = $_POST['hotelid'];
	$hotel_detail = '';
    if($hotelid != ''){
        $api_url = "https://api.worldota.net/api/b2b/v3/hotel/info/";
        
        $json_data = '{"id":"'.$hotelid.'","language":"en"}';
        $ch = curl_init(); 
    	curl_setopt($ch, CURLOPT_URL, $api_url);    
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
    	curl_setopt($ch, CURLOPT_POST, true);                                                                   
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                  
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    	curl_setopt($ch, CURLOPT_USERPWD, '3456:4efff8ef-608b-466b-90ce-c1941189e07f');
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
    		'Accept: application/json',
    		'Content-Type: application/json')                                                           
    	);                                                                                                 
    																											   
    	$result = curl_exec($ch);
    	if (curl_errno($ch)) {
    		$error_msg = curl_error($ch);
    	}
    	curl_close($ch);
    	
    	if (isset($error_msg)) {
    		return $error_msg;
    	}
    	$hotel_detail = json_decode($result,true);
    	//return $hotel;
    }
    echo json_encode($hotel_detail);
}
?>