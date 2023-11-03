<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet"   type="text/css" href="{{ secure_asset('assets/front/css/datepicker.css') }}" media="all">
<!--=============INNERPAGE-WRAPPER ===========-->
<style>
	.l-listing{
	  	border: 2px solid #31124b61;
	  	border-radius: 5px;
	  	margin: 10px 0;
	}
	.l-listing:hover{
		transition: .9s;
    	transform: scale(1.05);
	}
	.l-list-content{
	  	padding: 0px 10px 10px 10px; 
	}
	.listing-head{
	    background-color: #fa9e1b3d;
	    border-radius: 0px;
	    text-align: center;
	    padding: 5px;
	    font-size: 14px;
	    color: #232323;
	    font-weight: 600;	
	}
	.list-main{
	  	color: #31124b;
	  	font-weight: 700;
	  	text-align: center;
	  	font-size: 14px;
	  	height: 30px;
	}
	.l-facility{
	    background-color: #624a8e2e;
	    padding: 3px 10px;
	    justify-content: center;
	    text-align: center;
	    border-radius: 5px;
	}
	.l-facility .fa{
	    color: #624a8e;
	    padding-left: 8px;
	    font-size: 13px;
	}
	.list-fac{
	    list-style: none;
	    padding: 0;
	    margin-top: 10px;
	}
	.list-fac .fa{
	  	color: #31124b;
	  	font-size: 13px;
	}
	.list-fac li{
	  	font-size: 12px;
        color: black;
	}
	.moreinfo{
	  	color: #232323 !important;
	  	font-size: 14px !important;
	  	font-weight: 700 !important;
	  	text-decoration: none !important;
	  	cursor: pointer;
	  	
	}
	.moreinfo2{
	  	color: #232323 !important;
	  	font-size: 11px !important;
	  	font-weight: 700 !important;
	  	text-decoration: none !important;
	  	cursor: pointer;
	  	float:right;
	}
	.l-price{
	    color: #4c256e;
	  	text-align: right;
	  	font-weight: 700;
	  	font-size: 20px;
	  	margin: 0;
	}
	.btn-info{
	    color: #fff;
	    background-color: #624a8e;
	    border-color: #624a8e;
	    float: right;
	    font-size: 13px;
	}
	.btn-info:hover{
	    color: #fff;
	    background-color: #624a8e !important;
	    border-color: #624a8e !important;
	    font-size: 13px;
	    box-shadow: none !important;
	}
	#listing-tabs .modal-dialog{
	    max-width: 800px !important;
	    margin: 1.75rem auto;
	}
	#listing-tabs .nav-tabs {
	    border-bottom: none;
	    justify-content: space-around;
	}
	#listing-tabs nav > div a.nav-item.nav-link, 
	nav > div a.nav-item.nav-link.active {
	    border: none;
	    padding: 10px 18px;
	    color: #232323;
	    background: #fa9e1b;
	    border-radius: 0;
	    font-weight: 600;
	    border-radius: 5px;
	}
	#listing-tabs 
	#main-tabs nav > div a.nav-item.nav-link, 
	nav > div a.nav-item.nav-link.active{
	    color: #ffffff !important;
	    background: #624a8e !important;
	    border-radius: 5px;
	}
	#listing-tabs .modal-title {
	    margin-bottom: 0;
	    line-height: 1.5;
	    color: #624a8e !important;
	}
	#listing-tabs .close{
	  	color: #fff;
	}
	#listing-tabs .tab-content{
	  	padding: 20px;
	  	height: 450px;
    overflow-y: auto;
	}
	.border-rr{
	  	width: 100%;
	  	height: 120px;
	  	border-radius: 5px 5px 0px 0px;
	}
	.btn-secondary {
	    color: #fff;
	    background-color: #624a8e;
	    border-color: #31124b;
	}
	@media    screen and (min-width:992px) and (max-width:1200px){
		.moreinfo{
			font-size: 13px !important;
		}
		.moreinfo2{
			font-size: 10px !important;
		}
		.list-main{
			font-size: 11px !important;
		}
		.border-rr{
			height: 100px;
		}
	}
	
.home_slider_content h1:nth-child(1) {
    font-size: 31px;
    color: #ffffff;
    margin-top: 10%;
   
    font-family: sans-serif;
}

.home_slider_content_inner h1.result {
  text-align: center;
  margin-left: 0; 
}

.home_slider_container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 73%;
    z-index: 10;
    background: #31124b;
}

.home {
    width: 100%;
    height: 60vh;
}
.search {
    top: -200px;
}
@media only screen and (max-width: 991px)
{
    .search {
        height: auto;
        padding-top: 15px;
        padding-bottom: 100px;

    }
}
@media only screen and (max-width: 767px)
{
    .search {
        padding-top: 15px;
        padding-bottom: 120px;

    }
}
.modal p{
	color: #232323;
}
.modal span{
	color: #232323 !important;
}
p strong {
    color: #232323 !important;
}
.modal h1 h2 h3 h4 h5 h6{
	color: #232323;
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5;
    color: #232323;
    opacity: 1;
    font-weight: 600;
    font-size: 20px;
    margin: 0;
    padding: 0;
}
.scheme_default button {
    background: #4c256e;
    opacity: 1;
    color: #fff !important;
}
/*.modal span {
    color: #ffffff;
}*/
.modal ul li{
	color: #232323;
}
#lounge-sec{
	margin-top: -50px;
}
.search_panel{
	height: auto;
}
.btn-info.focus, .btn-info:focus {
    color: #fff;
    background-color: #4c256e !important;
    border-color: #4c256e !important;
    box-shadow: none !important;
}
@media only screen and (max-width: 991px){
	.search_tabs_container {
	    position: relative;
	    bottom: auto;
	    left: auto;
	    width: auto;
	    margin-bottom: 0px;
	}
	.search_panel form{
		 margin-top: 30px;
	}
	.search {
	    padding-top: 15px;
	    padding-bottom: 60px;
	}
	.fill_height {
	    height: auto;
	}
}
@media only screen and (max-width: 600px){
	.fill_height {
	    height: auto;
	}
	.search {
	    padding-top: 130px;
	    padding-bottom: 60px;
	}
}
@media only screen and (max-width: 331px){
	.foldpy{
		padding: 10px;
	}
}
</style>

<!-- Home -->
<div class="home">
    <!-- Home Slider -->

    <div class="home_slider_container">
        
        <div class="owl-carousel owl-theme home_slider">

            <div class="home_slider_background" style=""></div>

            <div class="home_slider_content text-center">
                <div class="home_slider_content_inner" data-animation-in="flipInX" data-animation-out="animate-out fadeOut">
                    <h1 class="result">Results</h1>
                </div>
            </div>
            <!-- Slider Item -->
        </div>
    </div>
</div>

<div class="search">
    <!-- Search Contents -->
    <div class="container fill_height">
        <div class="row fill_height">
            <div class="col fill_height">
                <!-- Search Tabs -->
                <div class="search_tabs_container">
                    <div class="search_tabs d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                        <div class="search_tab active d-flex flex-row align-items-center justify-content-lg-center justify-content-start"></i><img src="{{url('theme/images/suitcase.png')}}" alt=""><span>Parking</span></div>
                        <div class="search_tab d-flex flex-row align-items-center justify-content-lg-center justify-content-start"><!-- <img src="" alt=""> --><span>No of Days : </span
                            ><span class="pull-right"> {{$no_of_days}}</span></div>
                    </div>      
                </div>

                <div class="search_panel active">
                    <form method="get" action="{{ route("searchresult") }}" id="search_form_1" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                           <div class="search_item">
                            <div>Airport</div>
                            <div class="form-group">
                           <select required name="airport_id"   class="dropdown_item_select search_input" required="required"> 
                                    <option value="" disabled selected>Select</option>
                                
                                    @foreach($airports as $airport)

                                        <option @if($request->input("airport_id")==$airport->id) {{ "selected" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>
                                    @endforeach

                             </select>
                         </div>
                            </div>
                        <div class="search_item" >
                            <div>Drop of Date</div>
                                 <div class="form-group">
                                        <input autocomplete="off" name="dropoffdate" type="text" id="startDate"
                                               class="check_in search_input \ dpd1" style="" placeholder="Dropoff Date" value="{{ $request->input('dropoffdate') }}" 
                                               readonly
                                               required/>
                                    </div>
                                 <!--<div class="form-group">-->
                                 <!--       <input autocomplete="off" name="dropoffdate" type="text" id="startDate"-->
                                 <!--              class="check_in search_input \ dpd1" style="" placeholder="Dropoff Date" value="{{ $request->input('dropoffdate') }}" -->
                                 <!--              readonly-->
                                 <!--              required/>-->
                                 <!--   </div>-->

                        </div>

                               
                        <div class="search_item">

                            <div>Drop of time</div>
                           
                                  <div class="form-group">
                                 
                            
                                    @php
                                    $dropdown_timer = [];
                                   for ($i = 0; $i <= 23; $i++) {
                                       for ($j = 0; $j <= 45; $j += 15) {
                                           $dropdown_timer[str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT);
                                       }
                                   }
                                //dd($request->input('dropoftime'));
                                @endphp
                                {{ Form::select('dropoftime',$dropdown_timer,$request->input('dropoftime'),["class"=>"check_in search_input","id"=>"dropoftime"]) }}
                                    </div>
                        </div>
                        <div class="search_item">
                        <div>Pick Up Date</div>
                         

                                    <div class="form-group">

                                        <input type="text" readonly autocomplete="off"  value='{{ $request->input("departure_date") }}' name="departure_date" id="endDate"

                                               class="check_in search_input dpd2" placeholder="Departure Date"

                                               required/>

                                        

                                    </div>
                                    <!--<div class="form-group">-->

                                    <!--    <input type="text" readonly autocomplete="off"  value='{{ $request->input("departure_date") }}' name="departure_date" id="endDate"-->

                                    <!--           class="check_in search_input dpd21" placeholder="Departure Date"-->

                                    <!--           required/>-->

                                        

                                    <!--</div>-->

                        </div>
                        <div class="search_item">
                            <div>Pickup time</div>

                          

                                    <div class="form-group">

                                     
                                        {{ Form::select('pickup_time',$dropdown_timer,$request->input('pickup_time'),["class"=>"search_input","id"=>"pickup_time"]) }}
                                      



                                    </div>

                        
                           
                        </div>
                        <div class="search_item">
                            <div>Promo Code</div>
                                      @php if($request->input("promo2")!=""){ $p2=$request->input("promo2"); }else { $p2=""; } @endphp
                                    <div class="form-group">

                                        <input type="text" name="promo" class="check_in search_input"

                                           value='@if($p2!="") {{ $p2 }} @elseif($request->input("promo")) {{ $request->input("promo") }} @endif'

                                       name="promo2"    placeholder="Promo Code"/>
                                        @if ($promo_error_message!="")

                                    <div class="error error-massage" style="color:red">
                                        {{ $promo_error_message }}
                                    </div>
                                @endif


                                 </div>
                        </div>
                        <button class="button form-button search_button">Search<span></span><span></span><span></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>      
</div>

<section id="lounge-sec">
	<div class="container">
		<div class="row">
			@php
			$booking_fee = DB::table('settings')->where('field_name','booking_fee')->first();
			$booking_fee =($booking_fee->field_value);
			@endphp

			@if($companies)
			@else
			<b style="padding-bottom: 20%">No Result Found</b>
			@endif
			@foreach($companies as $company)
			@php
			
				$discount_amount=0;
				$facilities = \App\Company::find($company->companyID)->facilities->take(3);
				// dd($facilities); for 30 days .. we add 3000 for own aph
				if ($no_of_days > 30000) {
					$after30Days = $company->after_30_days;
					$booking_price = number_format($company->price, 2, '.', '');
					$booking_price = $booking_price + $after30Days * ($no_of_days - 30);
					$booking_price = number_format($booking_price, 2, '.', '');
				} else {
					$booking_price = number_format($company->price, 2, '.', '');
				}
				$booking_price = $booking_fee +  $booking_price;

				$parking_total = $booking_price;

				//dd($promo);
				if ($promo != '') {
					$dis = new \App\discounts();

					$promo_verify = $dis->varifyPromoCode($promo);

					if($promo_verify=="Verify"){

						$discount_amount = $dis->getPromoDiscount($promo, $booking_price, $bookingfor,$company->companyID);
						//$discount_amount=1;
						//echo $discount_amount."==".$booking_price;
						if($booking_price>$discount_amount){
							$booking_price = $booking_price - $discount_amount;
						}
						//echo $booking_price;
					}
				}
			@endphp
			<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
				<div class="l-listing">
					<div class="lounge-img">
					@if($company->aph_id=="")
						@if(isset($company->park_api) && $company->park_api == 'holiday')
							<img class="img-fluid border-rr" src='{{ $company->logo  }}'>
						@elseif(isset($company->park_api) && $company->park_api == 'global')
								<img class="img-fluid border-rr" src='{{ $company->logo  }}'>
						@elseif(isset($company->park_api) && $company->park_api == 'Opitech')
								<img class="img-fluid border-rr" src='{{ $company->logo  }}'>
						@else
						<img class="img-fluid border-rr" src='{{ asset("storage/app/".$company->logo)  }}'>
						@endif
					@else
						 @if($company->logo=="")
						  <img style="" class="img-fluid border-rr" src='{{ asset("storage/app/companies/aph_company_logo.png")  }}'>
						 
						 @else
						 <img style="" class="img-fluid border-rr" src='{{ asset("storage/app/".$company->logo)  }}'>
						
						 @endif
					@endif
					</div>
					@if(session()->get('bk_src') == 'PPC' || session()->get('bk_src') == 'BING')
						@php 
						$parking_dis = ($parking_total * 10 ) / 100 ;
						$parking_total = $parking_total + $parking_dis;
						@endphp
					@endif
					@php  
						$b_price=round($booking_price,2);	
						$company_price= round($parking_total,2);
					@endphp
					
					@php
                    if ($company->parking_type == "Meet and Greet") {
                       $color = "#FBE4A0";
                    }elseif ($company->parking_type == "Park and Ride" ) {
                       $color = "#f9e3ff";
                    }else{
                       $color = "#c9f293";
                    }
                    @endphp
					<h5 class="listing-head" style="background-color:{{$color}}">{{ $company->parking_type }}</h5>
					<div class="l-list-content">
						<h3 class="list-main">{{ $company->name }}</h3>
						<ul class="list-fac">
							@foreach($facilities  as $facility)
							@php
                                if ($facility->description == "Excellent value for money") {
                                   $icon = "fa fa-money";
                                }elseif ($facility->description == "Fully secure with CCTV" ) {
                                   $icon = "fa fa-video-camera";
                                }elseif ($facility->description == "Electric Charging Facility Available " ) {
                                   $icon = "fa-solid fa-charging-station";
                                }elseif ($facility->description == "Experienced, friendly staff" ) {
                                   $icon = "fa-solid fa-handshake";
                                }elseif ($facility->description == "Fast transfer to airport" ) {
                                   $icon = "fa-solid fa-shuffle";
                                }elseif ($facility->description == "24/7 security guarded car park" ) {
                                   $icon = "fa-solid fa-shield-halved";
                                }elseif ($facility->description == "Secured by CCTV and regular patrols." ) {
                                   $icon = "fa fa-video-camera";
                                }elseif ($facility->description == "Short 2-minute walk to departures." ) {
                                   $icon = "fa-solid fa-person-walking"; 
                                }elseif ($facility->description == "Car is parked for you." ) {
                                   $icon = "fa-solid fa-car";
                                }elseif ($facility->description == "Luxury service - have your car parked for your by a uniformed chauffeur." ) {
                                   $icon = "fa-solid fa-square-parking";
                                }elseif ($facility->description == "You won't need to transfer - just head straight to check-in." ) {
                                   $icon = "fa-solid fa-shuffle";
                                }elseif ($facility->description == "All drivers are fully insured, trained and wear a uniform." ) {
                                   $icon = "fa-solid fa-id-card";
                                }elseif ($facility->description == "Open 24/7" ) {
                                   $icon = "fa-solid fa-door-open";
                                }elseif ($facility->description == "Buses every 10 minutes" ) {
                                   $icon = "fa-solid fa-bus";
                                }elseif ($facility->description == "CCTV 24/7 Security Guard Multistory building" ) {
                                   $icon = "fa fa-video-camera";
                                }elseif ($facility->description == "Travellers love Airparks and now the car park offers free wifi on site and on their buses." ) {
                                   $icon = "fa-solid fa-wifi";
                                }elseif ($facility->description == "98 per cent of customers would book again." ) {
                                   $icon = "fa-solid fa-person-military-pointing";
                                }elseif ($facility->description == "Award-winning security, including CCTV, floodlighting, regular patrols, a fence and entry and exit barriers." ) {
                                   $icon = "fa fa-video-camera";
                                }elseif ($facility->description == "Travellers love APH and now the car park offers free wifi on site and on their buses." ) {
                                   $icon = "fa-solid fa-wifi";
                                }elseif ($facility->description == "The car park has CCTV, entrance and exit barriers, fencing, 24-hour security patrols and the Park Mark award." ) {
                                   $icon = "fa fa-video-camera";
                                }elseif ($facility->description == "Buses to the airport run on demand and you won't have to pay extra." ) {
                                   $icon = "fa-solid fa-bus";
                                }elseif ($facility->description == "The terminal is only a short walk away." ) {
                                   $icon = "fa-solid fa-person-walking";
                                }elseif ($facility->description == "Everything is done automatically at the barrier." ) {
                                   $icon = "fa-solid fa-road-barrier";
                                }elseif ($facility->description == "Choose your own space, park yourself and keep your own keys." ) {
                                   $icon = "fa-solid fa-question";
                                }elseif ($facility->description == "A two to four-minute walk to the terminal." ) {
                                   $icon = "fa-solid fa-person-walking";
                                }elseif ($facility->description == "Park your own car and keep your keys." ) {
                                   $icon = "fa-solid fa-car-side";
                                }elseif ($facility->description == "Automated entry and exit." ) {
                                   $icon = "fa-solid fa-arrows-to-circle";
                                }elseif ($facility->description == "Perfect location for the airport" ) {
                                   $icon = "fa-solid fa-location-dot";
                                }elseif ($facility->description == "Top-rated parking by our customers" ) {
                                   $icon = "fa-solid fa-percent";
                                }elseif ($facility->description == "24-hour service on Birmingham airport" ) {
                                   $icon = "fa-solid fa-clock";
                                }elseif ($facility->description == "We are providing Valet parking" ) {
                                   $icon = "fa-solid fa-square-parking";
                                }elseif ($facility->description == "Park Mark Award (Police Approved)" ) {
                                   $icon = "fa-solid fa-user-police";
                                }elseif ($facility->description == "Transfer time 15 minutes from parking" ) {
                                   $icon = "fa-sharp fa-solid fa-people-arrows";
                                }elseif ($facility->description == "24-hour service on Birmingham airport" ) {
                                   $icon = "fa-solid fa-clock";
                                }else{
                                   $icon = "fa-solid fa-location-question";
                                }
                            @endphp
								<li> <span class="{{$icon}}"></span> {!! str_limit(strip_tags($facility->description), 30) !!}</li>									
							@endforeach
						</ul>
						<a type="button" class="moreinfo my-3" data-toggle="modal" data-target="#exampleModalCenter{{ $company->companyID }}">  More Info <i class="fa fa-info-circle"></i>
								</a> 
						<div class="l-facility mb-2"> 
						
						@php
							$features =  explode(",",$company->special_features);
						@endphp

						@foreach($companies_special_features as $companies_special_feature)
							@if(in_array ($companies_special_feature->name,$features))
								<span data-toggle="tooltip" title="{{  $companies_special_feature->name }}"
								data-original-title="{{  $companies_special_feature->name }}"
								class="{{  $companies_special_feature->icon }} "></span>									  
							@endif
						@endforeach
						</div>
						<div class="row foldpy">
							<div class="col-md-6"> 
								<!--<a type="button" class="moreinfo" data-toggle="modal" data-target="#exampleModalCenter{{ $company->companyID }}">  More Info <i class="fa fa-info-circle"></i>-->
								<!--</a> -->
								<h3 class="l-price">£ {{ $b_price }}
								@if($request->input('promo')!="") 
									<br><small style="font-size:18px;color: #fe9600;font-weight: 600;"><strike>{{($company_price)}}</strike></small> 
								@elseif($request->input('promo2')!="") 
									<br><small style="font-size: 18px;color: #fe9600;font-weight: 600;"><strike>{{($company_price)}}</strike></small> 
								@else  
								@endif
								</h3> 
							</div>
							<div class="col-md-6">
								
								<form id="bookingFrm1" method="post" action='{{ route("addBookingForm") }}'>
									{{ csrf_field() }}										
									<input type="hidden" name="company_id" value="{{  $company->companyID }}">
									<input type="hidden" name="product_code" value="{{$company->product_code}}">
									<input type="hidden" name="parking_type" value="{{  $company->parking_type }}">
									<input type="hidden" name="parking_name" value="">
									<input type="hidden" name="aphactive" value="{{ @$company->aphactive }}">
									<input type="hidden" name="airport" value='{{ $request->input("airport_id") }}'>
									<input type="hidden" name="dropdate" value='{{ $request->input("dropoffdate") }}'>
									<input type="hidden" name="pickdate" value='{{ $request->input("departure_date") }}'>
									<input type="hidden" name="droptime" value='{{ $request->input("dropoftime") }}'>
									<input type="hidden" name="picktime" value='{{ $request->input("pickup_time") }}'>
									<input type="hidden" name="total_days" value="{{ $no_of_days }}">
									<input type="hidden" name="discount_code" value="{{  $promo }}">
									<input type="hidden" name="discount_amount" value="{{  $discount_amount }}">
									<input type="hidden" name="booking_amount" value="{{  $booking_price }}">
									<input type="hidden" name="bookingfor" value="airport_parking">
									<input type="hidden" name="pl_id" value="{{ @$company->pl_id }}">
									<input type="hidden" name="sku" value="">
									<input type="hidden" name="site_codename" value="">
									<input type="hidden" name="speed_park_active" value="">
									<input type="hidden" name="edin_active" value="">
									<input type="hidden" name="edin_search" value="">
									<input type="hidden" name="submitted" value="airport_parking">
									<input type="hidden" name="park_api" value="{{ isset($company->park_api) ? $company->park_api: '' }}">
									<input type="hidden" name="g_quote" value="{{ isset($company->g_quote) ? $company->g_quote: '' }}">
									<input type="hidden" name="g_token" value="{{ isset($company->g_token) ? $company->g_token: '' }}">
									<input type="hidden" name="src" value="{{ isset($request->src) ? $request->src: 'ORG' }}">
									<button  type="submit" class="btn btn-info" ><span class="icon-tag"></span> Book Now</button>
								</form>
								<a type="button" class="moreinfo2" data-toggle="modal" data-target="#exampleModalCenter{{ $company->companyID }}" >  More Info <i class="fa fa-info-circle"></i>
								</a> 
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="exampleModalCenter{{ $company->companyID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px;">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">{{ $company->name }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body" id="listing-tabs">
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist"> 
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#overview{{ $company->companyID }}" role="tab" aria-controls="overview" aria-selected="true">Overview</a> 
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#arrival{{ $company->companyID }}" role="tab" aria-controls="arrival" aria-selected="false">Arrival</a> 
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#return{{ $company->companyID }}" role="tab" aria-controls="return" aria-selected="false">Return</a> 
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#map{{ $company->companyID }}" role="tab" aria-controls="map" aria-selected="false">Map</a> 
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#note{{ $company->companyID }}" role="tab" aria-controls="note" aria-selected="false">Note</a> 
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#terms{{ $company->companyID }}" role="tab" aria-controls="terms" aria-selected="false">Terms & Condition</a> 
								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="overview{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-home-tab">
									<p>{!! $company->overview  !!}  </p>
								</div>
								<div class="tab-pane fade" id="arrival{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-profile-tab">
									<p> {!! $company->arival  !!}</p>
								</div>
								<div class="tab-pane fade" id="return{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">
									<p> {!! $company->return_proc  !!}</p>
								</div>
								<div class="tab-pane fade" id="map{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">
									@if($company->parking_type == 'Meet and Greet')
										<div class="tab-pane" id="tab_map{{ $company->companyID }}">
											<iframe max-width="100%" height="400" frameborder="0" style="border:0"
													src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAbqO8h1hqd8sQ5YR7zC10C4TQ0kbW1j_g&q={{ $company->address }}+{{ $company->town }}+{{ $company->post_code }}"
													allowfullscreen></iframe>
										</div>
									@else

										<div class="tab-pane" id="tab_map{{ $company->companyID }}">
											<iframe width="100%" height="400" frameborder="0" style="border:0"
													src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAbqO8h1hqd8sQ5YR7zC10C4TQ0kbW1j_g&q={{ $company->address }}+{{ $company->town }}+{{ $company->post_code }}"
													allowfullscreen></iframe>

										</div>
									@endif
								</div>
								<div class="tab-pane fade" id="note{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">
									<h4><strong>Important Information</strong></h4>

									<ul class="points"
										style="text-align: left;list-style: none;line-height: 25px;font-size: 15px;padding-left:0px;     color: #000;">

										@php
											$features =  explode(",",$company->special_features);

										@endphp

										@foreach($companies_special_features as $companies_special_feature)

											@if(in_array ($companies_special_feature->name,$features))

												<li>
													<i class="fa fa-chevron-right"></i>{{  $companies_special_feature->name }}</span>
												</li>
											@endif
										@endforeach

									</ul>
								</div>
								<div class="tab-pane fade" id="terms{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">										
									<div class="alert alert-info text-left" style="margin-top: 10px;">
										<strong>Will Be provided on request</strong>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
	
            @endforeach
		</div>
	</div>
</section>
<script type="text/javascript">
     (function($) {
    
    "use strict";
$(function(){
  $('body').on('click', '.modal-body ul li', function(){
    $('.modal-body ul li').removeClass('active');
    $(this).closest('.modal-body ul li').addClass('active');
  });
});
    // Cache Selectors
    var date1           =$('.dpd1'),
        date2           =$('.dpd2');
    
    
    //Date Picker//
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     
    var checkin = date1.datepicker({        format: 'dd-mm-yyyy',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 7);
            checkout.setValue(newDate);
            console.log(newDate);

        }
            if (ev.date.valueOf() < checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 7);
            checkout.setValue(newDate);
            console.log(newDate);
            
        }
        
        checkin.hide();
        //date2[0].focus();
        
    }).data('datepicker');
    
    var checkout = date2.datepicker({       format: 'dd-mm-yyyy',
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
        
    }).on('changeDate', function(ev) {
        checkout.hide();
    })
    .data('datepicker');

    

})(jQuery);


(function($) {


    // Cache Selectors
    var date1           =$('.right_dpd1'),
        date2           =$('.right_dpd2');


    //Date Picker//
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = date1.datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 7);
            checkout.setValue(newDate);
        }

        checkin.hide();
        date2[0].focus();

    }).data('datepicker');

    var checkout = date2.datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }

    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');


})(jQuery);
            var date1           =$('.dpd1'),
                date2           =$('.dpd2');
        
        var startdate = new Date();
        startdate.setDate(startdate.getDate()-1);

        
        date1.datepicker({startDate: startdate,todayHighlight:'TRUE',format: 'dd-mm-yyyy',})
        .on('changeDate', function(e){
            $(this).datepicker('hide');
        });

        date2.datepicker({startDate: startdate,todayHighlight:'TRUE',format: 'dd-mm-yyyy',})
        .on('changeDate', function(e){
            $(this).datepicker('hide');
        });

        
        
        $('.moreinfo').click(function() {
          $('#infoModal').modal('toggle');
          $.ajax({
              type: 'POST',
              data: {id:$(this).data('id')},
              dataType: 'json',
              url: '{{ route("loadinfo") }}',
              success: function(res) {
                //var parsed_data = JSON.stringify(res);
                  //console.log(res[0].overview);
                  var len = res.length;
                  var revhtml ='';
                  for(var i=0; i<len; i++){
                    if(res[i].username != null){
                      var rat =res[i].rating;
                      revhtml +=` <div class="card" >
                        <div class="card-body">
                          <h4 class="card-title" style="margin-top:0">`+res[i].username+` | `+res[i].title+` </h4>`;
                            
                          for($x=1;$x<=res[i].rating;$x++) {
                              revhtml +=`<span class="fa fa-star checked"></span>`;
                          }
                          // if (rat.indexOf(".") > -1) {
                          //     revhtml +=`<span class="fa fa-star"></span>`;
                          //     $x++;
                          // }
                          while ($x<=5) {
                              revhtml +=` <span class="fa fa-star"></span>`;
                              $x++;
                          } 

                          revhtml +=`<p class="card-text">`+res[i].review+`</p>  </div>
                      </div>`;
                    } 
                  }
                  $(".reviews-result").html(revhtml);
                  $(".info-overview").html(res[0].overview);
                  $(".info-arrivals").html(res[0].arival);
                  $(".info-return").html(res[0].return_proc);
              }
          })
      });

   </script>
   <script async src="{{ secure_asset('assets/front/js/bootstrap-datepicker.js') }}"></script>
<script async src="{{ secure_asset('assets/front/js/custom-date-picker.js') }}"></script>