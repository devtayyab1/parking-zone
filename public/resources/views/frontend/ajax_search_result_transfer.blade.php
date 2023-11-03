<style>
    .l-listing{
        border: 2px solid #31124b;
        border-radius: 5px;
        margin: 10px 0;
        height: 510px;
    }
    .l-list-content{
        padding: 0px 15px 15px 15px; 
    }
    .listing-head{
        background-color: #fa9e1b;
        border-radius: 0px;
        text-align: center;
        padding: 5px;
        color: #232323;
        font-weight: 600;
    }
    .list-main{
        color: #31124b;
        font-weight: 700;
        text-align: center;
        font-size: 18px;
    }
    .l-facility{
        background-color: #31124b;
        padding: 3px 10px;
        justify-content: center;
        text-align: center;
        border-radius: 5px;
    }
    .l-facility .fa{
        color: #fa9e1b;
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
        font-size: 14px;
        color: #232323;
        font-weight: 600;
    }
    .moreinfo{
        color: #31124b !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        cursor: pointer;
    }
    .l-price{
        text-align: right;
        font-weight: 700;
        font-size: 20px;
        margin: 0;
        color: #232323;
    }

    .btn-info{
        color: #fff;
        background-color: #31124b !important;
        border-color: #31124b !important;
        float: right;
    }
    .btn-info:hover{
        color: #fff;
        background-color: #31124b !important;
        border-color: #31124b !important;
    }

    #listing-tabs .modal-dialog{
        max-width: 800px !important;
        margin: 1.75rem auto;
    }
    #listing-tabs .nav-tabs {
        border-bottom: none;
        justify-content: space-around;
    }
    #listing-tabs nav > div a.nav-item.nav-link, nav > div a.nav-item.nav-link.active {
        border: none;
        padding: 10px 18px;
        color: #232323;
        background: #fa9e1b;
        border-radius: 0;
        font-weight: 600;
        border-radius: 5px;
        margin-top: 10px ;
    }
    #listing-tabs #main-tabs nav > div a.nav-item.nav-link, nav > div a.nav-item.nav-link.active{
        color: #ffffff !important;
        background: #31124b !important;
        border-radius: 5px;
    }
    #listing-tabs .modal-title {
        margin-bottom: 0;
        line-height: 1.5;
        color: #31124b !important;
    }
    #listing-tabs .close{
        color: #fff;
    }
    #listing-tabs .tab-content{
        padding: 20px;
    }
    .border-rr{
        border-radius: 0px;
    }
    .tab-content-scroll {
        overflow-y: auto;
        height: 350px;
        margin-bottom: 30px;
        margin-top: 15px;
    }
    .modal-header .close {
        padding: 15px;
        margin: -15px -15px -15px auto;
        font-size: 30px;
    }
    @media screen and (max-width:767px){
        .l-listing{
            height: auto;
        }  
    }
</style>


<div class="row justify-content-center" id="lounge-sec">

@php

$booking_fee = DB::table('settings')->where('field_name','booking_fee')->first();

$booking_fee =($booking_fee->field_value);

@endphp



@if($companies)

@else



<!--<b style="padding-bottom: 20%">No Result Found</b>-->

<img src="{{ asset('theme/images/norecord.png')  }}" style="width:auto;">

@endif



@foreach($companies as $company)

@php

$discount_amount=0;



$booking_price = number_format($company['TotalPrice'], 2, '.', '');

$booking_price = $booking_fee +  $booking_price;
$parking_total = $booking_price;
@endphp

<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

	<div class="l-listing">

		<div class="lounge-img"><img src="{{ $company['Images'][0]['Src'] }}" class="img-fluid border-rr"></div>

		<h5 class="listing-head"></h5>

		<div class="l-list-content">

			<h3 class="list-main">{{ $company['Name'] }}</h3>

			<div class="l-facility">

				<span class="fa fa-video-camera"></span>

				<span class="fa fa-lock"></span>

				<span class="fa fa-wheelchair"></span>

				<span class="fa fa-key"></span>

				<span class="fa fa-users"></span>

			</div>

			<ul class="list-fac">

				<li><i class="fa fa-user"></i> {{ $company['VehicleDetails']['MaxCapacity'] }} people max</li>   

				<li><i class="fa fa-suitcase"></i> {{ $company['VehicleDetails']['Bags'] }} suitcases per vehicle</li> 

				<li><i class="fa fa-check"></i> 
				@if($company['VehicleDetails']['IsPrivate'])
				    Available for private accommodation
				@endif
				</li> 

			</ul>

			<div class="row">

				<div class="col-md-5">

					<!--a type="button" class="moreinfo"  data-target="#exampleModal" data-toggle="modal">  More Info +</a-->

				</div>

				<div class="col-md-7">

					<h3 class="l-price">

        				@php  

        			    $b_price=round($booking_price,2);

                    	@endphp

        			    <span>£ {{ $b_price }} </span>@if($request->input('promo')!="") <small style="font-size: 15px;

                        color: #f3832b;"><strike>{{($parking_total)}}</strike></small> @elseif($request->input('promo2')!="") <small style="font-size: 15px;

                        color: #f3832b;"><strike>{{($parking_total)}}</strike></small> @else  @endif

				    </h3>

					<form id="bookingFrm1" method="post" action='{{ route("addBookingFormTransfer") }}'>

                    	{{ csrf_field() }}
                        
                        <input type="hidden" name="company_id" value="{{  $company['Code'] }}">

                    	<input type="hidden" name="product_code" value="{{ $company['Code'] }}">

                    	<input type="hidden" name="transfer_name" value="{{  $company['Name'] }}"> 

                    	<input type="hidden" name="logo" value="{{ $company['Images'][0]['Src'] }}">

                    	<input type="hidden" name="booking_amount" value="{{  $company['TotalPrice'] }}">
                    	
                    	<input type="hidden" name="sku" value="{{ $company['Code'] }}">

                    	<input type="hidden" name="booking_url" value="{{ isset($company['BookingURL']) ? $company['BookingURL'] : '' }}">




                    	<input type="hidden" name="loc_type" value='{{ $request->input("loc_type") }}'>

                    	<input type="hidden" name="loc_code" value='{{ $request->input("loc_code") }}'>

                    	<input type="hidden" name="loc_name" value='{{ $request->input("loc_name") }}'>

                    	<input type="hidden" name="loc_lat" value='{{ $request->input("loc_lat") }}'>
                    	
                    	<input type="hidden" name="loc_long" value='{{ $request->input("loc_long") }}'>

                    	<input type="hidden" name="loc_id" value='{{ $request->input("loc_id") }}'>

                    	<input type="hidden" name="loc_country" value='{{ $request->input("loc_country") }}'>
                    	

                    	<input type="hidden" name="loc_type_drop" value='{{ $request->input("loc_type_drop") }}'>

                    	<input type="hidden" name="loc_code_drop" value='{{ $request->input("loc_code_drop") }}'>

                    	<input type="hidden" name="loc_name_drop" value='{{ $request->input("loc_name_drop") }}'>

                    	<input type="hidden" name="loc_lat_drop" value='{{ $request->input("loc_lat_drop") }}'>
                    	
                    	<input type="hidden" name="loc_long_drop" value='{{ $request->input("loc_long_drop") }}'>

                    	<input type="hidden" name="loc_id_drop" value='{{ $request->input("loc_id_drop") }}'>

                    	<input type="hidden" name="loc_country_drop" value='{{ $request->input("loc_country_drop") }}'>
                    	
                    	

                    	<input type="hidden" name="arrival_date" value='{{ $request->input("arrival_date") }}'>

                    	<input type="hidden" name="arrival_time" value='{{ $request->input("arrival_time") }}'>

                    	<input type="hidden" name="return_date" value='{{ $request->input("return_date") }}'>
                    	
                    	<input type="hidden" name="return_time" value='{{ $request->input("return_time") }}'>

                    	<input type="hidden" name="adults" value='{{ $request->input("adults") }}'>

                    	<input type="hidden" name="children" value='{{ $request->input("children") }}'>

                    	<input type="hidden" name="infants" value='{{ $request->input("infants") }}'>
                    	
                    	
                    	<input type="hidden" name="submitted" value="transfer">
                    	<input type="hidden" name="bookingfor" value="transfer">
                    	<input type="hidden" name="park_api" value="holiday">
                    
                    	<button  type="submit" class="btn btn-info" >Book Now</button>

            	    </form>

				</div>

			</div>

		</div>

	</div>

</div>



@endforeach

</div>



<style>

        

    @media screen and (min-device-width: 1100px) and (max-device-width: 1200px){

        .top-img {

            width: 100% !important;

            height: 120px !important;

        }

        .content-body {

            padding: 10px !important;

        }

    }

</style>

</section>