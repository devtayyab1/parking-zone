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



$booking_price = number_format($company->price, 2, '.', '');



//$booking_price = $booking_fee +  $booking_price;



$parking_total =  $booking_fee +  $booking_price;



//dd($promo);

if ($promo != '') {

$dis = new \App\discounts();



$promo_verify = $dis->varifyPromoCode($promo);



if($promo_verify=="Verify"){



$discount_amount = $dis->getPromoDiscount($promo, $booking_price, 'airport_lounges','');

//$discount_amount=1;

//echo $discount_amount."==".$booking_price;

if($booking_price>$discount_amount){

$booking_price = $booking_price - $discount_amount;

}

//echo $booking_price;

}



}



$booking_price = $booking_fee +  $booking_price;



@endphp

<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

	<div class="l-listing">

		<div class="lounge-img"><img src="{{ $company->logo }}" class="img-fluid border-rr"></div>

		<h5 class="listing-head">Terminal {{ $company->terminal }}</h5>

		<div class="l-list-content">

			<h3 class="list-main">{{ $company->name }}</h3>

			<div class="l-facility">

				<span class="fa fa-video-camera"></span>

				<span class="fa fa-lock"></span>

				<span class="fa fa-wheelchair"></span>

				<span class="fa fa-key"></span>

				<span class="fa fa-users"></span>

			</div>

			<ul class="list-fac">

				<li><i class="fa fa-check"></i> {!! str_limit(strip_tags($company->why_bookone), 30) !!}</li>   

				<li><i class="fa fa-check"></i> {!! str_limit(strip_tags($company->why_booktwo), 30) !!}</li> 

				<li><i class="fa fa-check"></i> {!! str_limit(strip_tags($company->why_bookthree), 30) !!}</li> 

			</ul>

			<div class="row">

				<div class="col-md-5">

					<a type="button" class="moreinfo"  data-target="#exampleModal{{ $company->companyID }}" data-toggle="modal">  More Info +</a>

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

					<form id="bookingFrm1" method="post" action='{{ route("addBookingFormLounge") }}'>

                    	{{ csrf_field() }}

                    

                    	<input type="hidden" name="company_id" value="{{  $company->companyID }}">

                    	<input type="hidden" name="product_code" value="{{$company->product_code}}">

                    	<input type="hidden" name="lounge_name" value="{{  $company->name }}"> 

                    	<input type="hidden" name="terminal" value="{{  $company->terminal }}">

                    	<input type="hidden" name="airport" value='{{ $request->input("airport_id") }}'>

                    	<input type="hidden" name="checkin_date" value='{{ $request->input("checkin_date") }}'>

                    	<input type="hidden" name="checkin_time" value='{{ $request->input("checkin_time") }}'>

                    	<input type="hidden" name="adults" value='{{ $request->input("adults") }}'>

                    	<input type="hidden" name="children" value='{{ $request->input("children") }}'>

                    	<input type="hidden" name="discount_code" value="{{  $promo }}">

                    	<input type="hidden" name="discount_amount" value="{{  $discount_amount }}">

                    	<input type="hidden" name="booking_amount" value="{{  $booking_price }}">

                    	<input type="hidden" name="bookingfor" value="lounge">

                    	<input type="hidden" name="pl_id" value="">

                    	<input type="hidden" name="sku" value="{{$company->product_code}}">

                    	<input type="hidden" name="site_codename" value="">

                    	<input type="hidden" name="speed_park_active" value="">

                    	<input type="hidden" name="edin_active" value="">

                    	<input type="hidden" name="edin_search" value="">

                    	<input type="hidden" name="submitted" value="lounge">

                    	<input type="hidden" name="booking_url" value="{{ isset($company->booking_url) ? $company->booking_url : '' }}">

                    	<input type="hidden" name="park_api" value="{{ isset($company->park_api) ? $company->park_api: '' }}">

                    	

                    	<button  type="submit" class="btn btn-info" >Book Now</button>

            	    </form>

				</div>

			</div>

		</div>

	</div>

</div>

				

<div class="modal fade" id="exampleModal{{ $company->companyID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px;">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">{{ $company->name }}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body" id="listing-tabs">

        <nav>

		  <div class="nav nav-tabs" id="nav-tab" role="tablist">

		    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#info{{ $company->companyID }}" role="tab" aria-controls="info" aria-selected="true">Info</a>

		    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#images{{ $company->companyID }}" role="tab" aria-controls="images" aria-selected="false">Images</a>

		    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#menu{{ $company->companyID }}" role="tab" aria-controls="menu" aria-selected="false">Menu</a>

		    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#times{{ $company->companyID }}" role="tab" aria-controls="times" aria-selected="false">Times</a>

		    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#facilities{{ $company->companyID }}" role="tab" aria-controls="facilities" aria-selected="false">Facilities</a>

		    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#direction{{ $company->companyID }}" role="tab" aria-controls="direction" aria-selected="false">Direction</a>

		  </div>

		</nav>

		<div class="tab-content" id="nav-tabContent">

		  <div class="tab-pane fade show active" id="info{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-home-tab">

		      <div class="tab-content-scroll" style="color: black;">

    		    <p>{!! $company->introduction  !!}  </p>

    			<p>{!! $company->tripappintroduction  !!}  </p>

    			<h3>Facilities</h3>

            	<ul class="result-benefit">

        			<li class="rs-list"><i class="fa fa-check"></i> {!! $company->why_bookone !!} </li> 

        			<li class="rs-list"><i class="fa fa-check"></i> {!! $company->why_booktwo !!} </li> 

        			<li class="rs-list"><i class="fa fa-check"></i> {!! $company->why_bookthree !!} </li> 

        			<li class="rs-list"><i class="fa fa-check"></i> {!! $company->why_bookfour !!} </li> 

            	</ul>

        	    </div>  

		  </div>

		  <div class="tab-pane fade" id="images{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-profile-tab">

		        <div class="tab-content-scroll" style="color: black;">

		        @if($company->images != '')

                    <div class="row">

    	            <?php

    	                $img_array = explode(';',$company->images);

    	            ?>

    	            @foreach($img_array as $img)

    	                <div class="col-sm-4">

    	                    <img src="https://holidayextras.imgix.net/{{$img}}" style="width: 100%; margin-bottom: 12px;">

    	                </div>

    	            @endforeach

                    </div>

    	        @endif

	            </div>

	      </div>

		  <div class="tab-pane fade" id="menu{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">

		      <div class="col-sm-12 tab-content-scroll" style="color: black;">

                    <h3>Food</h3>

    				<p>{!! $company->menu_food  !!}  </p>

    				<hr class="seperator">

                    <h3>Drinks</h3>

    				<p>{!! $company->menu_drinks  !!}  </p>

    				<p>{!! $company->whats_included_drinks  !!}  </p>

    				<hr class="seperator">

                    <h3>Extras</h3>

    				<p>{!! $company->menu_extras  !!}  </p>

				</div>

	      </div>



		  <div class="tab-pane fade" id="times{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">

		      <div class="tab-content-scroll" style="color: black;">

			    <h4><strong>Time</strong></h4>

			    <p>Open from <strong>{{$company->opening_time}}</strong> to <strong>{{$company->closing_time}}</strong></p>

			    <p>{{$company->checkintime}}</p>

			</div>

	      </div>



		  <div class="tab-pane fade" id="facilities{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">

		      <div class="tab-content-scroll" style="color: black;">

    			<h4><strong>Facilities</strong></h4>

    			<p>{!! $company->facilities !!}</p>

    			<hr class="seperator">

    			<h4><strong>Entertainment</strong></h4>

    			<p>{!! $company->entertainment_facilities !!}</p>

    			<hr class="seperator">

    			<h4><strong>Business</strong></h4>

    			<p>{!! $company->businessfacilities !!}</p>

    		  </div>

	      </div>



		  <div class="tab-pane fade" id="direction{{ $company->companyID }}" role="tabpanel" aria-labelledby="nav-contact-tab">

		    <div class="tab-content-scroll" style="color: black;">

			    <h4><strong>Direction</strong></h4>

			    <p>{!! $company->directions !!}</p>

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