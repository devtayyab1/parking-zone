<?php 
class aph_functions{
    function  AphBookingPrice($ArrivalDate,$DepartDate,$ArrivalTime,$DepartTime,$aph_company_id,$passenger,$product_code){
    	$xml = '<API_Request 
    				System="APH"
    				Version="1.0"
    				Product="CarPark"
    				Customer="X"
    				Session="000000004"
    				RequestCode="3">
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
    				<CarParkCode>'.$aph_company_id.'</CarParkCode>
    				<ProductCode>'.$product_code.'</ProductCode>
    				<NumberOfPax>'.$passenger.'</NumberOfPax>
    				</Itinerary>
    				</API_Request>';
    	$response = $this->aph_call($xml);
    	$xml_aph = simplexml_load_string($response);
    	$xml_aph = json_decode(json_encode((array)$xml_aph));
    
    	//return 50;
    
    	$booking_price = $xml_aph->Pricing->TotalPrice;
    	return $booking_price;
    }
    
    function AphBookingOrder($data){
    
    
    		$response = $this->aph_call($data);
              // 	dd($response );
    
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
    		$array = $this->array_flatten($array);
    		return $array;
    }
    
    function AphBooking($data){
    
    
    	$response = $this->aph_call($data);
    
    	$xml_aph = simplexml_load_string($response);
    	$array  = array();
    	
    	foreach($xml_aph->CarPark as $key=>$item){
    
    		/*
    		if(!preg_match('/aph/',strtolower($item->CarParkName)) && !preg_match('/silver zone/',strtolower($item->CarParkName)) && !preg_match('/bristol long/',strtolower($item->CarParkName))){
    			unset($item);
    		}
    		*/
    
    		//if(!empty($item)){
    		if(isset($item)){
    			$nested = array();
    			//$urls = "http://test.parking-quote.co.uk/APH_XML/carparkInfoXML.asp?product_code=".$item->ProductCode;
    			//$urls = "http://agents.aph.com/APH_XML/carparkInfoXML.asp?product_code=".$item->CarParkCode."_".$item->ProductCode;
    			//$urls = "http://agents.aph.com/APH_XML/carparkInfoXML.asp?product_code=".$item->ProductCode;
    			//$urls = "https://test-agents.aph.com/APH_XML/carparkInfoXML.asp?product_code=".$item->CarParkCode."_".$item->ProductCode;
    			$urls = config('app.aphurldetails')."?product_code=".$item->CarParkCode."_".$item->ProductCode;
    		
    			//agents.aph.com/APH_XML/carparkInfoXML.asp
    			$urls = "agents.aph.com/APH_XML/carparkInfoXML.asp?product_code=".$item->CarParkCode."_".$item->ProductCode;
    			$datas = $this->get_aph_data($urls);
    			$prod_info = simplexml_load_string($datas, null, LIBXML_NOCDATA);
    			file_put_contents("array_aph_products.txt","Req: ".date('Y-m-d H:i:s')."\r\n".print_r($prod_info,true),FILE_APPEND);
    			if(count($prod_info)){
    				$nested['companyID'] = $item->CarParkCode;
    				$nested['aph_id'] = $item->CarParkCode;
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
                        
    					//$nested = array_flatten($nested);
    					//$array[] = array_flatten($nested);
    
    					$nested = $this->array_flatten($nested);
    					$array[] = $this->array_flatten($nested);
    			}
    		}//
    	}
    	//file_put_contents("array_aph_companies.txt","Req: ".date('Y-m-d H:i:s')."\r\n".print_r($array,true),FILE_APPEND);
    	return $array;
    }
    
    function aph_call($data) {
    	//$url = "http://test.parking-quote.co.uk/xmlapi/aphxml.ASP";
    	//$url = "http://agents.aph.com/xmlapi/aphxml.ASP";
    	//$url = "https://test-agents.aph.com/xmlapi/aphxml.ASP";
       	$url = config('app.aphurl');
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
    
    	file_put_contents("amir_aph_response.txt","Req: ".date('Y-m-d H:i:s')."\r\n".$data." RES: \r\n".date('Y-m-d H:i:s')."\r\n".$response."\r\n\r\n",FILE_APPEND);
    
    // 	$response = '<API_Reply 	
    // 					System="APH"
    // 					Version="1.0"
    // 					Product="CarPark"
    // 					Customer="A"
    // 					Session="000000003"
    // 					RequestCode="11"
    // 					Result="OK">
    
    // 						<CarPark c="1">
    // 							<CarParkCode>LGW8</CarParkCode>
    // 							<CarParkName>Meet + Greet LGW8</CarParkName>
    // 							<ProductCode>LGWP</ProductCode>
    // 							<ProductName>Meet and Greet Return</ProductName>
    // 							<Duration>8</Duration>
    // 							<TotalPrice>81.00</TotalPrice>
    // 							<GatePrice>85.00</GatePrice>
    // 							<Commission>8.5</Commission>
    // 							<Terminals>N,S,</Terminals>
    // 						</CarPark>
    
    // 						<CarPark c="2">
    // 							<CarParkCode>LGW8</CarParkCode>
    // 							<CarParkName>Meet + Greet LGW8</CarParkName>
    // 							<ProductCode>LGWQ</ProductCode>
    // 							<ProductName>Meet and Greet Early Bird</ProductName>
    // 							<Duration>8</Duration>
    // 							<TotalPrice>52.80</TotalPrice>
    // 							<GatePrice>56.80</GatePrice>
    // 							<Commission>5.68</Commission>
    // 							<Terminals>N,S,</Terminals>
    
    // 						</CarPark>
    
    
    // 				</API_Reply>
    // ';
    
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
    
    	file_put_contents("detail_aph_response.txt","Req2: ".date('Y-m-d H:i:s')."\r\n".$url." RES2: \r\n".date('Y-m-d H:i:s')."\r\n".$data."\r\n\r\n",FILE_APPEND);
    
    
    	return $data;
    }
        
       function GlobalBooking($airport_id,$from_date,$from_time,$to_date,$to_time,$id){
      $url = "https://live-api.opitech.co.uk/api-search.php?";
    $getString ="location_code=".$airport_id;
    $getString .="&arrival_date=".$from_date."&arrival_time=".$from_time;
    $getString .="&depart_date=".$to_date ."&depart_time=".$to_time. "&agentCode=PARZ&key=GzJew9QjhzzcOsSdq4u0jpInT5xNQSA0";
    $final = $url.$getString;
    
	$result = $this->curl_call($final);

	$result = json_decode($result, true);
	
   
     //echo "<pre>"; print_r($result['data']); echo "</pre>"; exit;
	//$result = Search_IN_ARRAY($result, 'status', 'Enabled');
	$data =  $this->global_list($result,$id);

	return $data;
    }
    
    function OpitechBooking($airport_id,$from_date,$from_time,$to_date,$to_time,$id){
      $url = "https://live-api.opitechdevelopment.com/api-search.php?";
    $getString ="location_code=".$airport_id;
    $getString .="&arrival_date=".$from_date."&arrival_time=".$from_time;
    $getString .="&depart_date=".$to_date."&depart_time=".$to_time. "&agentCode=PARZ&key=hg563hrfs4J3FyLn6n3UypQo4ZST5zNQJ";
    $final = $url.$getString;
    
	$result = $this->curl_call($final);

	$result = json_decode($result, true);

   //dd($result);
     //echo "<pre>"; print_r($result['data']); echo "</pre>"; exit;
	//$result = Search_IN_ARRAY($result, 'status', 'Enabled');
	$data =  $this->opitech_list($result,$id);
	
	return $data;
    }
    
    function opitech_list($data,$id){
      
      
    	$array  = array();
    	$nested  = array();
    if ($data['status'] == 'OK'){
    	foreach($data['results'] as $item){
   
    		   //$nested['id'] = $item['id'];
    			$nested['price'] = $item['product']['price'];
    			$nested['name'] = $item['product']['name'];
    			$nested['quote'] = $item['product']['quote'];
    			$nested['token'] = $item['product']['token'];    			
    			$nested['airport'] = $id;
    		
                   $url = "https://live-api.opitechdevelopment.com/api-product.php?product_code=".$item['product']['code']."&agentCode=PARZ&key=hg563hrfs4J3FyLn6n3UypQo4ZST5zNQJ";
                   $result = $this->curl_call($url);
                   $result = json_decode($result, true);
                //   dd($result);
                   $p_code="OP-".$result['product']['product_code'];
                   $nested['sku'] = $p_code;
                   $nested['logo'] = $result['product']['logo']; 
                 
                   	 if($result['product']['meet_and_greet'] != '1')
                   	 {
                   	     $type = 'Park and Ride';
                   	 }
                   	 else
                   	 {
                   	     $type = 'Meet and Greet';
                   	 }
                   	
                   	
                   $airport = DB::table('airports')->where('iata_code' , $data['request']['location_code'])->get();
                   $airport = json_decode($airport, true);
                    // return $result['product']['meet_and_greet'];
                   $companies = DB::table('companies')->where('company_code' , $p_code)->get();
                    $companies = json_decode($companies, true);
                   //dd($companies);
                  if(empty($companies))
                  {
               $arival=  $result['product']['arrival_procedures'];
                      $arivalfront =    $result['product']['arrival_procedures'];
                      $return_proc= $result['product']['departure_procedures'];
                      $returnfront= $result['product']['departure_procedures'];
                      $arival =  str_replace("you'll","you will",$arival);
                      $arivalfront = str_replace("you'll","you will",$arivalfront);
                      $arival = str_replace("it's","it is",$arival);
                      $arivalfront = str_replace("it's","it is",$arivalfront);
                      $arival = str_replace("you're","you are",$arival);
                      $arivalfront = str_replace("you're","you are",$arivalfront);
                      $arival = str_replace("you've","you have",$arival);
                      $arivalfront = str_replace("you've","you have",$arivalfront);
                      $return_proc = str_replace("you're","you are",$return_proc);
                      $returnfront = str_replace("you're","you are",$returnfront);
                      $return_proc = str_replace("you've","you have",$return_proc);
                      $returnfront = str_replace("you've","you have",$returnfront);
                      $special_features =  $result['product']['security_measures'] ?? 'CCTV,SECURE BARRIER,DISABILITY FRIENDLY,FAMILY FRENDLY,FENCING,BUSINESS FRENDLY,24/7 Security Guards,Fencing';
                $companies = DB::insert('insert into companies (name,company_code,admin_id,company_email,airport_id,parking_type,logo,overview,arival,arivalfront,
                return_proc,returnfront,address,miles_from_airport,special_features,is_active) values (?, ?, ? , ? ,? ,? , ? ,? , ? , ? , ? , ? , ? , ?,?,?)', 
                [$result['product']['name'],$p_code,"49","opitech@parkingzone.co.uk", $airport[0]['id'],$type,
                $result['product']['logo'],$result['product']['introduction'],$arival,$arival,
                $return_proc,$return_proc,$result['product']['address'],$result['product']['distance_miles'],
                $special_features,'Yes']);
                
                 
                  }
                  //dd($result);
                    $c_id= DB::table('companies')->where('company_code' , $p_code)->get();
                    $c_id = json_decode($c_id, true);
                    $c_id =   $c_id[0]['id'];
                    $facilities = DB::table('facilities')->where('company_id' , $c_id)->get();
                    $facilities = json_decode($facilities, true);
                    $sell_point_1 = $result['product']['sell_point_1'] ?? 'Excellent value for money';
                    $sell_point_2 = $result['product']['sell_point_2'] ?? 'Fully secure with CCTV';
                    $sell_point_3 = $result['product']['sell_point_3'] ?? 'Open 24/7';
                    $sell_point_4 = $result['product']['sell_point_4'] ?? 'Automated entry and exit.';
                    
                  if(empty($facilities)){
                      $facis=array($sell_point_1,$sell_point_2,$sell_point_3,$sell_point_4);
                      
                    foreach($facis as $fac){
                        
                        $up_fac = DB::insert('insert into facilities (company_id,description,type) values (?, ?, ? )', 
                                    [$c_id,$fac,"company"]);
                        
                    }
                    
                    
                
                
                }
                  else
                  {
                     
                     
                  }
                   
    		   	$array[] = $this->array_flatten($nested);
               
    	}
    }
    	$array = json_decode(json_encode((array)$array), TRUE);
    	return $array;
    }
    
    function GlobalSingle($sku,$from_date,$from_time,$to_date,$to_time){
    	$from_date = date('Y-m-d', strtotime($from_date));
    	$to_date = date('Y-m-d', strtotime($to_date));
    	$from_time = date("H:i",strtotime($from_time));
    	$to_time = date("H:i",strtotime($to_time));
    		
    	$url = "https://maple.use-fuse.com/api/package";
    	$getString  ="?user=flyparkplus&userkey=59e6322b3885b";
    	$getString .="&sku=".$sku;
    	$getString .="&from=".$from_date."%20".$from_time;
    	$getString .="&to=".$to_date."%20".$to_time;
    	$final = $url.$getString;
    	$result =  $this->curl_call($final);
    	$result = json_decode($result, true);
    	$data = $result['DATA'][0]['price'];
    	return $data;
    }
    
   function global_list($data,$id){
      
      
    	$array  = array();
    	$nested  = array();
    if ($data['status'] == 'OK'){
    	foreach($data['results'] as $item){
   
    		   //$nested['id'] = $item['id'];
    			$nested['price'] = $item['product']['price'];
    			$nested['sku'] = $item['product']['code'];
    			$nested['name'] = $item['product']['name'];
    			$nested['quote'] = $item['product']['quote'];
    			$nested['token'] = $item['product']['token'];    			
    			$nested['airport'] = $id;
    		
                   $url = "https://live-api.opitech.co.uk/api-product.php?product_code=".$item['product']['code']."&agentCode=PARZ&key=GzJew9QjhzzcOsSdq4u0jpInT5xNQSA0";
                   $result = $this->curl_call($url);
                   $result = json_decode($result, true);
                   
                   	 if($result['product']['meet_and_greet'] != '1')
                   	 {
                   	     $type = 'Park and Ride';
                   	 }
                   	 else
                   	 {
                   	     $type = 'Meet and Greet';
                   	 }
                   	 
                   	//dd($result);
                   $airport = DB::table('airports')->where('iata_code' , $data['request']['location_code'])->get();
                   $airport = json_decode($airport, true);
                    // return $result['product']['meet_and_greet'];
                 $companies = DB::table('companies')->where('company_code' , $item['product']['code'])->get();
                    $companies = json_decode($companies, true);
                   
                  if(empty($companies))
                  {
                      $arival=  $result['product']['arrival_procedures'];
                      $arivalfront =    $result['product']['arrival_procedures'];
                      $return_proc= $result['product']['departure_procedures'];
                      $returnfront= $result['product']['departure_procedures'];
                      $arival =  str_replace("you'll","you will",$arival);
                      $arivalfront = str_replace("you'll","you will",$arivalfront);
                      $arival = str_replace("it's","it is",$arival);
                      $arivalfront = str_replace("it's","it is",$arivalfront);
                      $arival = str_replace("you're","you are",$arival);
                      $arivalfront = str_replace("you're","you are",$arivalfront);
                      $arival = str_replace("you've","you have",$arival);
                      $arivalfront = str_replace("you've","you have",$arivalfront);
                      $return_proc = str_replace("you're","you are",$return_proc);
                      $returnfront = str_replace("you're","you are",$returnfront);
                      $return_proc = str_replace("you've","you have",$return_proc);
                      $returnfront = str_replace("you've","you have",$returnfront);
                      $special_features = $result['product']['security_measures'] ?? 'CCTV,SECURE BARRIER,DISABILITY FRIENDLY,FAMILY FRENDLY,FENCING,BUSINESS FRENDLY,24/7 Security Guards,Fencing';
                $companies = DB::insert('insert into companies (name,company_code,admin_id,company_email,airport_id,parking_type,logo,overview,arival,arivalfront,
                return_proc,returnfront,address,miles_from_airport,special_features,is_active,share_percentage) values (?, ?, ? , ? ,? ,? , ? ,? , ? , ? , ? , ? , ? , ?,?,?,?)', 
                [$result['product']['name'],$result['product']['product_code'],"37","agent_bookings@opitechdevelopment.com", $airport[0]['id'],$type,
                $result['product']['logo'],$result['product']['introduction'],$arival,$arival,
                $return_proc,$return_proc,$result['product']['address'],$result['product']['distance_miles'],
                $special_features,'Yes','30']);
                  $c_id= DB::table('companies')->where('company_code' , $nested['sku'])->get();
                    $c_id = json_decode($c_id, true);
                    $c_id =   $c_id[0]['id'];
                    $facilities = DB::table('facilities')->where('company_id' , $c_id)->get();
                    $facilities = json_decode($facilities, true);
                
                    $sell_point_1 = $result['product']['sell_point_1'] ?? 'Excellent value for money';
                    $sell_point_2 = $result['product']['sell_point_2'] ?? 'Fully secure with CCTV';
                    $sell_point_3 = $result['product']['sell_point_3'] ?? 'Open 24/7';
                    $sell_point_4 = $result['product']['sell_point_4'] ?? 'Automated entry and exit.';
                    
                  if(empty($facilities)){
                      $facis=array($sell_point_1,$sell_point_2,$sell_point_3,$sell_point_4);
                      
                    foreach($facis as $fac){
                        
                        $up_fac = DB::insert('insert into facilities (company_id,description,type) values (?, ?, ? )', 
                                    [$c_id,$fac,"company"]);
                        
                    }
                      
                  }
                  }
                  else
                  {
                     
                     
                  }
                   
    		   	$array[] = $this->array_flatten($nested);
               
    	}
    }
    	$array = json_decode(json_encode((array)$array), TRUE);
    
    	return $array;
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
    	$result =  $this->curl_call($final);
    	
    	$result = json_decode($result, true);
    	$data =  $this->holiday_list($result);
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
    			$array[] = $this->array_flatten($nested);
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
    	
    
        $response = $this->curl_call($final);
    	$xml_aph = simplexml_load_string($response);
    	$xml_aph = json_decode(json_encode((array)$xml_aph));
    
    	$booking_price = $xml_aph->Pricing->TotalPrice;
    	return $booking_price;
    }
    function HolidayBookingOrder($data, $product_code){

        $url = "https://api.holidayextras.co.uk/carpark/".$product_code;
        $data = "ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491".$data;
    	$response = $this->holidaybooking_call($data,$url);		
    	
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
// 		$array = $this->array_flatten($array);
		return $array;
		
    }
    function HolidayExtraLounges($airport_code,$checkin_date,$checkin_time,$adult,$children){
    
    
    	$url = "https://api.holidayextras.co.uk/v1/lounge/".$airport_code.'.js';
    	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
    	$getString .="&ArrivalDate=".$checkin_date."&ArrivalTime=".$checkin_time;
    	$getString .="&Adults=".$adult."&Children=".$children;
    	$final = $url.$getString;
    	$result =  $this->curl_call($final);
    	$result = json_decode($result, true);
    	
    	//echo "<pre>"; print_r($result); echo "</pre>"; exit;
    	
    	$data =  $this->holiday_list_lounge($result);
    	//echo "<pre>"; print_r($data); echo "</pre>"; exit;
    	return $data;
    }
    
    function holiday_list_lounge($data){
    	$array  = array();
    	$nested  = array();
    	foreach($data['API_Reply']['Lounge'] as $item){
    			$nested['price'] = $item['Price'];
    			$nested['sku'] = $item['Code'];
    			$nested['name'] = $item['Name'];
    			$nested['booking_url'] = $item['BookingURL'];
    			$nested['moreinfo_url'] = $item['MoreInfoURL'];
    		    $nested['terminal'] = $item['terminal'];
    			$array[] = $this->array_flatten($nested);
    	}
    	$array = json_decode(json_encode((array)$array), TRUE);
    	return $array;
    }
    function HolidayBookingLoungePrice($product_code, $checkin_date, $checkin_time, $adult, $children){
    			
		$checkin_date = str_replace('/', '-', $checkin_date);
    	$checkin_date = date('Y-m-d', strtotime($checkin_date));
    	
    	$checkin_time = date('Hi', strtotime($checkin_time));
    		
    	$url = "https://api.holidayextras.co.uk/v1/lounge/".$product_code;
    	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
    	$getString .="&ArrivalDate=".$checkin_date."&ArrivalTime=".$checkin_time;
    	$getString .="&Adults=".$adult."&Children=".$children;
    	$final = $url.$getString;
    	//exit;
    
        $response = $this->curl_call($final);
    	$xml_aph = simplexml_load_string($response);
    	$xml_aph = json_decode(json_encode((array)$xml_aph));
    
    	$booking_price = $xml_aph->Pricing->TotalPrice;
    	return $booking_price;
    }
    function HolidayBookingOrderLounge($data, $product_code){

        $url = "https://api.holidayextras.co.uk/v1/lounge/HP".$product_code;
        
        $data = "ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491".$data;
        
    	$response = $this->holidaybooking_call($data,$url);		
    	
    	$xml_aph = simplexml_load_string($response);
    	
    	$xml_aph = json_decode(json_encode((array)$xml_aph));
    	
    	//echo "<pre>"; print_r($xml_aph); echo "</pre>"; exit;
		$array  = array();
		
		$array['BookingRef'] = $xml_aph->Booking->BookingRef;
		$array['MoreInfoURL'] = $xml_aph->Booking->MoreInfoURL;
		$array['AgentComm'] = $xml_aph->Booking->AgentComm;
		
// 		$array = json_decode(json_encode((array)$array), TRUE);
// 		$array = $this->array_flatten($array);
		return $array;
		
    }
    function HolidayBookingOrderTransfer($data, $booking_url){

        $url = "https://api.holidayextras.co.uk/".$booking_url;
        
        $data = "ABTANumber=AJ166&Password=PAXML&key=parkingzone&token=829152491".$data;
        //exit;
        
    	$response = $this->holidaybooking_call_transfer($data,$url);		
    	
    	
    	$result = json_decode($response, true);
    	
    	echo "<pre>"; print_r($result); echo "</pre>"; exit;
		$array  = array();
		
		$array['BookingRef'] = $xml_aph->Booking->BookingRef;
		$array['MoreInfoURL'] = $xml_aph->Booking->MoreInfoURL;
		$array['AgentComm'] = $xml_aph->Booking->AgentComm;
		
// 		$array = json_decode(json_encode((array)$array), TRUE);
// 		$array = $this->array_flatten($array);
		return $array;
		
    }
    function HolidayExtraTransfer($data){
    
    
    
		$arrival_date = str_replace('/', '-', $data['arrival_date']);	
        $arrival_date = date('Y-m-d', strtotime($arrival_date));
    	$arrival_time = date("Hi",strtotime($data['arrival_time']));
    	
		$return_date = str_replace('/', '-', $data['return_date']);	
        $return_date = date('Y-m-d', strtotime($return_date));
    	$return_time = date("Hi",strtotime($data['return_time']));
    	

    	$url = "https://api.holidayextras.co.uk/v1/transfers/search.js";
    	$getString  ="?ABTANumber=AJ166&Password=PAXML&Initials=pa&key=parkingzone&token=829152491";
    	$getString .="&PickUp=".$data['loc_code']."&PickUpType=".$data['loc_type'];
    	$getString .="&DropOff=".$data['loc_code_drop']."&DropOffType=".$data['loc_type_drop'];
    	$getString .="&FromDate=".$arrival_date."&FromTime=".$arrival_time;
    	$getString .="&ReturnDate=".$return_date."&ReturnTime=".$return_time;
    	$getString .="&Adults=".$data['adults']."&Children=".$data['children'];
        $final = $url.$getString;
    	$result =  $this->curl_call($final);
    	$result = json_decode($result, true);
	    
	    
    	//echo "<pre>"; print_r($result['API_Reply']['Transfers']); echo "</pre>"; exit;
    	
    	$resp =  $result['API_Reply']['Transfers'];
    	//echo "<pre>"; print_r($resp); echo "</pre>"; exit;
    	return $resp;
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
	
    function holidaybooking_call_transfer($data,$url) {
    	
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
    
}

?>