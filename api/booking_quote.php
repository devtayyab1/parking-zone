<?php
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
date_default_timezone_set('Europe/London');
require "session.php";
$action = isset($_POST['action']) ? $_POST['action'] : '';
$title       = isset($_POST['title']) ? $_POST['title'] : '';
$firstname   = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname    = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$email       = isset($_POST['email']) ? $_POST['email'] : '';
$contactno   = isset($_POST['contactno']) ? $_POST['contactno'] : '';
$fulladdress = isset($_POST['fulladdress2']) ? $_POST['fulladdress2'] : '';
$address     = isset($_POST['address']) ? $_POST['address'] : '';
$address2    = isset($_POST['address2']) ? $_POST['address2'] : '';
$town        = isset($_POST['town']) ? $_POST['town'] : '';
$postcode    = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$passenger   = isset($_POST['passenger']) ? $_POST['passenger'] : '';
$incomplete      = isset($_POST['incomplete']) ? $_POST['incomplete'] : '';
$booking_id      = (isset($_POST['booking_id']) && $_POST['booking_id']>0)? $_POST['booking_id'] : $_SESSION["booking_id"];
$departterminal  = isset($_POST['departterminal']) ? $_POST['departterminal'] : 'TBA';
$arrivalterminal = isset($_POST['arrivalterminal']) ? $_POST['arrivalterminal'] : 'TBA';
$flightnumber    = isset($_POST['flightnumber']) ? $_POST['flightnumber'] : 'TBA';
$returnflight    = isset($_POST['returnflight']) ? $_POST['returnflight'] : 'TBA';
$referenceNo    = (isset($_POST['reference_no']) && $_POST['reference_no']!='') ? $_POST['reference_no'] : $_SESSION["referenceNo"];
$make       = isset($_POST['make']) ? $_POST['make'] : 'TBA';
$model      = isset($_POST['model']) ? $_POST['model'] : 'TBA';
$color      = isset($_POST['color']) ? $_POST['color'] : 'TBA';
$registration   = isset($_POST['registration']) ? $_POST['registration'] : 'TBA';
$address = $db->real_escape($address);
$address2 = $db->real_escape($address2);
$fulladdress = $db->real_escape($fulladdress);
$town = $db->real_escape($town);


if ($action == "airportParkingBooking") {
    $company_id     = isset($_POST['company_id']) ? $_POST['company_id'] : 0;
	$product_code     = isset($_POST['product_code']) ? $_POST['product_code'] : 0;
	$intent_id   = isset($_POST['intent_id']) ? $_POST['intent_id'] : '';
    $parking_type   = isset($_POST['parking_type']) ? $_POST['parking_type'] : '';
   
    $pickdate       = isset($_POST['pickdate']) ? $_POST['pickdate'] : '';
    $dropdate       = isset($_POST['dropdate']) ? $_POST['dropdate'] : '';
    $droptime       = isset($_POST['droptime']) ? $_POST['droptime'] : '';
    $picktime       = isset($_POST['picktime']) ? $_POST['picktime'] : '';
    $total_days     = isset($_POST['total_days']) ? $_POST['total_days'] : '';
    $airport        = isset($_POST['airport']) ? $_POST['airport'] : 0;
    $bookingfor     = isset($_POST['bookingfor']) ? $_POST['bookingfor'] : '';
    $promo          = isset($_POST['promo']) ? $_POST['promo'] : '';
    $smsfee         = isset($_POST['smsfee']) ? $_POST['smsfee'] : 'No';
    $cancelfee      = isset($_POST['cancelfee']) ? $_POST['cancelfee'] : 'No';
    $departDate     = date('Y-m-d H:i:s',strtotime($dropdate." ".$droptime));
    $returnDate     = date('Y-m-d H:i:s',strtotime($pickdate." ".$picktime));
	$passenger = isset($_POST['passenger']) ? $_POST['passenger'] : 1;
	$pl_id = isset($_POST['pl_id']) ? $_POST['pl_id'] : 0;
	$sku = isset($_POST['sku']) ? $_POST['sku'] : '';
	$edin_active = isset($_POST['edin_active']) ? $_POST['edin_active'] : '';
	$speed_park_active = isset($_POST['speed_park_active']) ? $_POST['speed_park_active'] : '';
	$site_codename = isset($_POST['site_codename']) ? $_POST['site_codename'] : '';

	$ArrivalDate = date('dMy', strtotime($dropdate));
	$DepartDate = date('dMy', strtotime($pickdate));
	$ArrivalTime = date("Hi",strtotime($droptime));
	$DepartTime = date("Hi",strtotime($picktime));	
	
    $customer_id    = 0;
    $smsfee_charged = 0;
    $cancelfee_charged = 0;
    $discount_amount = 0;
	$l_fee = get_company_levy($company_id);

    $bookingfee         = $moduleSettings['booking_fee'] > 0 ? $moduleSettings['booking_fee'] : 0;
    $sms_notification   = $moduleSettings['sms_notification_fee'] > 0 ? $moduleSettings['sms_notification_fee'] : 0;
    $cancellation_fee   = $moduleSettings['cancellation_fee'] > 0 ? $moduleSettings['cancellation_fee'] : 0;

    $booking_amount = APBookingPrice($company_id, $airport, $total_days, $dropdate);
	if(empty($booking_amount)){
		$booking_amount = AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$company_id,$passenger,$product_code);
	}
	if(!empty($edin_active)){
		$edinArrivalDate = date('Y-m-d', strtotime($dropdate));
		$edinDepartDate = date('Y-m-d', strtotime($pickdate));
		$edinArrivalTime = date("H:i",strtotime($droptime));
		$edinDepartTime = date("H:i",strtotime($picktime));
		$edin_dropdate = $edinArrivalDate." ".$edinArrivalTime;
		$edin_pickdate = $edinDepartDate." ".$edinDepartTime;
		$edin_result = edinburghairport_companies_call($edin_dropdate,$edin_pickdate);
		$edin_companies = get_edin_companies($edin_result);
		$company = Search_IN_ARRAY($edin_companies, 'edin_code', $edin_active);
		$booking_amount = $company[0]['price'];
		//$booking_amount = get_edin_company_price($dropdate,$pickdate,$droptime,$picktime,$edin_active);
		//$booking_amount = '37.99';
		
	}
	if(!empty($sku)){
		$booking_amount = ACESingle($sku,$dropdate,$droptime,$pickdate,$picktime);
	}
	if(!empty($speed_park_active)){
		$booking_amount = get_speed_single($site_codename,$dropdate,$pickdate,$droptime,$picktime);
		//$booking_amount = '106.00';
	}
	
	$extra_amount = extra_amount($company_id, $pl_id);
	$booking_amount_for = check_extra($company_id, $pl_id, $booking_amount);
	
    if ($promo != '') {
        $discount_amount = getPromoDiscount($promo,$booking_amount_for,$bookingfor,$company_id);
    }
    $total_amount = ($booking_amount*1) + ($bookingfee*1) + ($extra_amount*1) - ($discount_amount*1);
	if ($l_fee >0) {
        $total_amount = $total_amount + ($l_fee*1);
        $l_fee = $l_fee*1;
    }
    if ($smsfee == 'Yes') {
        $total_amount = $total_amount + ($sms_notification*1);
        $smsfee_charged = $sms_notification*1;
    }
    if ($cancelfee == 'Yes') {
        $total_amount = $total_amount + ($cancellation_fee*1);
        $cancelfee_charged = $cancellation_fee*1;
    }
	if($intent_id!='')
	{
		\Stripe\PaymentIntent::update(
			$intent_id,
			[
				'amount' => ($total_amount*100),
			]
		);
	}

    if (isset($_SESSION['is_login']) && $_SESSION['is_login'] == 'Yes' && isset($_SESSION['login_id']) && $_SESSION['login_id'] > 0) {
        $customer_id = $_SESSION['login_id'];
    }
	else{
		if($incomplete =='yes' && $_SESSION["referenceNo"]==''){
			
			$pass = randomPassword();
			$referenceNo ="";
			$userID = $db->get_row("SELECT * FROM " . $db->prefix . "customer WHERE  email = '".$email."'");
			if($userID['id']){
				//$user_query="UPDATE ";
				//$where="where id = '".$userID['id']."'";
				$customer_id = $db->update("UPDATE " . $db->prefix . "customer SET
							title      ='". $title."',
							first_name = '".$firstname."', 
							last_name = '".$lastname."', 
							phone_number = '".$contactno."', 
							password = '".md5($pass)."',
							postal_code = '".$postcode."',
							address = '".$address."', 
							address2 = '".$address2."', 
							town = '".$town."',
							added_on = '".$db->php_now()."',
							update_on = '".$db->php_now()."',
							email = '".$email."' where id = '".$userID['id']."'");
			}
			else{
				//$user_query="INSERT INTO  ";
				$where='';
				$customer_id = $db->insert("INSERT INTO  " . $db->prefix . "customer SET
							title      ='". $title."',
							first_name = '".$firstname."', 
							last_name = '".$lastname."', 
							phone_number = '".$contactno."', 
							password = '".md5($pass)."',
							postal_code = '".$postcode."',
							address = '".$address."', 
							address2 = '".$address2."', 
							town = '".$town."',
							added_on = '".$db->php_now()."',
							update_on = '".$db->php_now()."',
							email = '".$email."'");
			}

			if($userID['id']){
				$customer_id = $userID['id'];
			}
			//email_signUP($customer_id,$pass);
		}
	}

    $browser_data = $_SERVER['HTTP_USER_AGENT'];
    if($incomplete =='yes' && $_SESSION["referenceNo"]==''){
		if($refr ==''){
			$query = "INSERT INTO ";
			
		}
		else{
			$referenceNo = $refr;
			$query = "UPDATE ";
			$where = "WHERE referenceNo='".$refr."'";
			$_bookID_reff = $db->get_row("SELECT id FROM ".$db->prefix."booking WHERE referenceNo = '".$refr."'");
		}
		$_current_time = $db->php_now();
		//$days_ago = date('d-m-Y H:i:s', strtotime('-2 days', strtotime($_current_time)));
		$ip = get_client_ip();
		//$booking_src = $db->get_row("SELECT * FROM ".$db->prefix."booking WHERE email = '".$email."' && createdate > '".$days_ago."' order by id DESC");
		$booking_src = $db->get_row("SELECT * FROM ".$db->prefix."tracking WHERE ip = '".$ip."' order by id DESC");
		//$booking_src = $db->get_row("SELECT * FROM ".$db->prefix."tracking WHERE ip = '".$ip."' && date > '".$days_ago."' order by id DESC");
		if($booking_src){
			if($booking_src['ref_src'] ==''){
				$booking_src1 = $db->get_row("SELECT *,STR_TO_DATE(date,'%d-%m-%Y %h:%i:%s') as date_time FROM ".$db->prefix."tracking WHERE ip = '".$ip."' && ref_src !='' order by id DESC");
				if($booking_src1){
					$_traffic_src = $booking_src1['ref_src'];
                    //check if that source already have been booked
                    $get_booking = $db->get_row("SELECT * from " . $db->prefix . "booking where traffic_src = '" . $booking_src1['ref_src'] . "' and user_ip='".$ip."' and createdate > '" . $booking_src1['date_time'] . "' and booking_status != 'Abandon' order by id DESC limit 1");
                    if($get_booking)
                    {
                        
                        $_traffic_src = ''; //keep organic
                    }
				}
				else{
					$_traffic_src = $booking_src['ref_src'];
				}
			}
			else{
			$_traffic_src = $booking_src['ref_src'];
			}
		}
		else{
			$_traffic_src = 'BL';
		}
		
    $_bookID = $db->insert("INSERT INTO " . $db->prefix . "booking SET
                        airportID       ='". $airport."',
                        companyId       ='".$company_id."',
						product_code       ='".$product_code."',
						intent_id       ='".$intent_id."',
                        customerId      ='".$customer_id."',
                        title           = '".$title."', 
                        first_name      = '".$firstname."', 
                        last_name       = '".$lastname."', 
                        email           = '".$email."', 
                        phone_number    = '".$contactno."', 
                        fulladdress = '".$fulladdress."', 
                        address         = '".$address."', 
                        address2        = '".$address2."', 
                        town            = '".$town."', 
                        postal_code     = '".$postcode."',
                        passenger     = '".$passenger."',
                        departDate      = '".$departDate."',
                        deprTerminal    = '".$departterminal."',
                        deptFlight      = '".$flightnumber."',
                        returnDate      = '".$returnDate."',
                        returnTerminal  = '".$arrivalterminal."',
                        returnFlight    = '".$returnflight."',
                        no_of_days      = '".$total_days."',
                        discount_code   = '".$promo."',
                        discount_amount = '".$discount_amount."',
                        booking_amount  = '".$booking_amount."',
                        booking_extra  = '".$extra_amount."',
                        smsfee          = '".$smsfee_charged."',
                        booking_fee     = '".$bookingfee."',
                        cancelfee       = '".$cancelfee_charged."',
                        total_amount    = '".$total_amount."',
						leavy_fee      = '".$l_fee."',
                        booked_type     = '".$parking_type."',
                        browser_data    = '".$browser_data."',
                        createdate      = '".$db->php_now()."',
                        traffic_src      = '".$_traffic_src."',
                        user_ip      = '".$ip."',
                        modifydate      = '".$db->php_now()."' $where");
						$test = "1";
						
	 $_SubsID = $db->insert("INSERT INTO " . $db->prefix . "subscribers SET
                        airport      ='". $airport."',
						name = '".$firstname." ".$lastname."',
						removed = 'No',
						subs_date='".$db->mysql_now()."',
						email = '".$email."'");
	
    }else{
        $_bookID = $db->update("update " . $db->prefix . "booking SET
                        airportID       ='". $airport."',
                        companyId       ='".$company_id."',
                       	product_code       ='".$product_code."',
						intent_id       ='".$intent_id."',
                        title           = '".$title."', 
                        first_name      = '".$firstname."', 
                        last_name       = '".$lastname."', 
                        email           = '".$email."', 
                        phone_number    = '".$contactno."', 
                        fulladdress = '".$fulladdress."', 
                        address         = '".$address."', 
                        address2        = '".$address2."', 
                        town            = '".$town."', 
                        postal_code     = '".$postcode."',
                        passenger       = '".$passenger."',
                        departDate      = '".$departDate."',
                        deprTerminal    = '".$departterminal."',
                        deptFlight      = '".$flightnumber."',
                        returnDate      = '".$returnDate."',
                        returnTerminal  = '".$arrivalterminal."',
                        returnFlight    = '".$returnflight."',
                        no_of_days      = '".$total_days."',
                        discount_code   = '".$promo."',
                        discount_amount = '".$discount_amount."',
                        booking_amount  = '".$booking_amount."',
						booking_extra  = '".$extra_amount."',
                        smsfee          = '".$smsfee_charged."',
                        booking_fee     = '".$bookingfee."',
                        cancelfee       = '".$cancelfee_charged."',
                        total_amount    = '".$total_amount."',
                        booked_type     = '".$parking_type."',
                        browser_data    = '".$browser_data."',
                        createdate      = '".$db->php_now()."',
                        modifydate      = '".$db->php_now()."' WHERE referenceNo='".$referenceNo."'");
						
						$test = "2";					
						
						
    }
	
	if($refr !=''){
			$_bookID = $_bookID_reff;
			
		}
    if($referenceNo ==""){
    $bookingref = 'TP-';
    $bookingref .= date("y").date("m").date("d");
    //$bookingref = $bookingref.substr($_bookID, -3);
    $bookingref = $bookingref.$_bookID;
	$_SESSION["referenceNo"] = $bookingref; // set session to avoid duplicate incomplete after page refresh
	$_SESSION["booking_id"] = $_bookID;
    $query = $db->insert("insert into " . $db->prefix . "vehicle set
                bookingId ='".$_bookID."',
                make ='".$make."',
                model ='".$model."',
                color ='".$color."',
                registration ='".$registration."'");
				
    }else{
       $bookingref =  $referenceNo;
       $_bookID =  $booking_id;
       $query = $db->update("UPDATE " . $db->prefix . "vehicle set
                bookingId ='".$_bookID."',
                make ='".$make."',
                model ='".$model."',
                color ='".$color."',
                registration ='".$registration."' WHERE bookingId='".$_bookID."'");
    }
    //$_SESSION['referenceNo'] = base64_encode($bookingref);
    $db->update("UPDATE " . $db->prefix . "booking SET referenceNo ='".$bookingref."' WHERE id='".$_bookID."'");
	
	//fiveg mailchimp
		try {
				/*$email_address = trim($email);
				$api_endpoint = 'https://us3.api.mailchimp.com/3.0/lists/825f079da1/members/';
				$mailchimp_user_info = array(
				'FNAME' => $firstname,
				'LNAME' => $lastname,
				'PHONE' => $contactno
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
					'Authorization: apikey 2f3bdd8901f9a0e6ddfbc09171ca1d60-us3'
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
		
				if ($response['body'] === false) {
					$last_error = curl_error($ch);
					//print_r($last_error);
				}
		
				curl_close($ch);
				if($response_array["status"]=='subscribed' || $response_array["title"]=='Member Exists')
				{
					$db->update("update " . $db->prefix . "booking SET
                        mailchimp  = 1  WHERE id='".$_bookID."'");
				}*/
		}
		catch(Exception $e)
		{
			
		}
	
	//fivegmailchimp
	
    echo json_encode(array('booking_id' => $_bookID, 'reference_no' => $bookingref,'available'=>"Yes"));
				
    exit;
}
?>