@extends('layouts.main')

@section("stylesheets")

    <link property="stylesheet" rel='stylesheet'

          href='{{ secure_asset("assets/page.css") }}' type='text/css'

          media='all'/>


    <link rel="stylesheet" href='{{  secure_asset("assets/payzone/payzone_gateway.css?v=1.2") }}' />
   
  

@endsection
@include("layouts.nav")
   
@section('content')

<style type="text/css">


.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fde4e4;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>


<section id="lounge-sec224">
	<div class="container" id="booking-loung">
		<div class="row">
			<div class="col-md-12">
				<h1 class="booking-heading">Booking Detail Form</h1> 
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 box-div">
				<form id="personal_details_form">
					<h2 class="personal">Personal Information</h2>
					<div class="form-row">
						<div class="form-group col-md-2">
							<label>Title</label>
							<select  class="form-control" name="title" id="title">
                                <option value="Mr">Mr</option>

                                <option value="Mrs">Mrs</option>

                                <option value="Miss">Miss</option>

                                <option value="Ms">Ms</option>
							</select>
						</div>
						<div class="form-group col-md-5">
							<label>First Name</label>
							<input type="text" class="form-control" required placeholder="First Name" name="firstname" id="firstname" value=""> 
						</div>
						<div class="form-group col-md-5">
							<label>Last Name</label>
							<input type="text" class="form-control"placeholder="Last Name" name="lastname" required id="lastname" value=""> 
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label>Email</label>
							<input type="email" class="form-control" placeholder="info@gmail.com" name="email" id="email" required value=""> </div>
						<div class="form-group col-md-4">
							<label>Confirm Email</label>
							<input type="email" class="form-control"  placeholder="Confirm Email" email="true" equalTo="#email" name="c_email" id="c_email" required value=""> </div>
						<div class="form-group col-md-4">
							<label>Phone Number</label>
							<input type="number" class="form-control" placeholder="542 853 6584" name="contactno" id="contactno" required value=""> </div>
				    </div>
				</form>
				<hr class="hr">
				
				<img class="img-responsive" style="display: block;  max-width: 50%; margin-bottom: 12px !important; height: auto; margin: auto;" src="{{ secure_asset('assets/payzone/images/payzone_cards_accepted.png') }}">

                <div class="paymentFrm" id="paymentFrm">

                    <form method="post">

                        {{ csrf_field() }}

                        <div id="creditDiv">
                            <a class="reset" href="#"></a>

                            <div class="col-lg-12 margin15">

                                <div class="col-lg-6" style="display: none;">

                                    <label>Card Number </label>

                                    <span class="required-field">*</span>

                                    <div class="form-control bf-inptfld empty" type="text" id="cc_card_no" name="card_no" style=""></div>

                                    <div class="baseline"></div>

                                </div>

                                <div class="col-lg-6" style="display: none;">

                                    <label>Card Holder Name </label>

                                    <span class="required-field">*</span>

                                    <input class="form-control empty" type="text" id="cc_card_title"  name="card_title"> </input>

                                    <div class="baseline"></div>

                                </div>

                            </div>

                            <div class="col-lg-12 margin15" style="display: none;">

                                <div class="col-lg-6">

                                    <label>Expiry Month / Year</label>

                                    <span class="required-field">*</span> 
                                    
                                    <div class="form-control empty bf-inptfld" id="expiry_year">Expiration</div>

                                    <div class="baseline"></div>

                                </div>

                                <div class="col-lg-6">

                                    <label>Security Code</label>

                                    <span class="required-field">*</span>

                                    <div class="form-control bf-inptfld empty" type="text" id="cc_security_code" name="security_code"></div>

                                    <small>Enter the last 3 digit code on the back of your card </small>

                                    <div class="baseline"></div>

                                </div>

                            </div>

                            <div class="card_chrge">

                                <input type="hidden" value="airportParkingBooking" name="action" id="action">

                                <input type="hidden" id="bookID" name="booking_id" value="0">

                                <input type="hidden" id="referenceNo" name="reference_no" value="">

                                <input type="hidden" id="aphactivestripe" name="aphactive" value="{{ $data['aphactive'] }}">

                                <input type="hidden" id="speed_park_active" name="speed_park_active" value="">

                                <input type="hidden" id="site_codename" name="site_codename" value="">

                                <input type="hidden" id="edinactive" name="edinactive" value="">

                                <input type="hidden" id="edin_search" name="edin_search" value="">

                            </div>

                            <div class="col-lg-12">

                                <div class="alert alert-danger" id="c_error" style="display: none; margin-top: 10px; font-weight: bold;">

                                    Could not submit your request this time, please check your Card details and try again.

                                </div>

                            </div>
                        </div><!--#creditDiv-->

                        <div class="card_chrge">
                            <input type="hidden" id="intent_id" name="intent_id" value="" >
                            <input type="hidden" id="intent_secret" name="intent_secret" value="" >
                            <!-- placeholder for Elements -->
                            <div id="card-element"></div>
                            <center>  
                                <h4 style="margin-top:10px;">
                                    <span class="badge badge-warning" style="background-color: #31124b;" >Your Card Will Be Charged</span> 
                                    <span class="badge badge-danger" style="background-color: #1773b9; color: white;" > 
                                        <strong>£<span id="ccPrice">0</span></strong>
                                    </span>
                                </h4> 
                            </center>
                        </div>
                        <br>
						<div id="imgloader" style="display:none; text-align:center; margin:5px;">
                        	<img src="theme/images/timeloader.gif" style="width:50px;">
                        </div>
                        <center> 
                            <button class="btn btn-info" type="submit" id="bookingButton">Confirm Booking</button>
                        </center>

                        <div class="error" role="alert">
                            <span class="message"></span>
                        </div>
                        <div id="error_personal_detail" style="color:#f20; font-weight:bold; text-align:center;"></div>
                        
                        <div class="col-md-12">
                            <div class="styledpadding"></div>
                        </div>
                    </form>
                </div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="booking-info">
					<div class="booking-detail">
						<h3>Booking Detail</h3>
					</div>
					<table class="table">
						<h6 class="lounge-name">{{ $data["lounge_name"] }}</h6>
					  <tbody>
					    <tr>
					      <td class="bold">Check-in Date</td>
					      <td class="text-right">{{ $data["checkin_date"] }} at {{ $data["checkin_time"] }}</td>
					    </tr>
					    <tr>
					      <td class="bold">No of Days</td>
					      <td class="text-right">5</td>
					    </tr>
					    <tr>
					      <td class="bold">Booking Price</td>
					      <td class="text-right">£{{ $data["booking_amount"]+$data["discount_amount"] }}</td>
					    </tr>
					    @if($data["discount_amount"]>0)
    
					    <tr>
					      <td class="bold">Discount Price</td>
					      <td class="text-right">- £$data["discount_amount"] }}</td>
					    </tr>
					    @endif
					    <tr>
					      <td class="bold">Booking Fee</td>
					      <td class="text-right">£{{ $settings['booking_fee'] }}</td>
					    </tr>
					  </tbody>
					</table>
					<div class="booking-detail" id="bookingDetails">
						<h3>Total Pay : £ <span id="totalPrice">0</span></h3>
						<input type="hidden" id="bookingprice" value="{{ $data["booking_amount"] }}"/>
    
                        <input type="hidden" id="alltotal" value="{{ $data["booking_amount"] }}"/>

                        <input type="hidden" id="disAmount" name="discount_amount" value="{{ $data["discount_amount"] }}">

                        <input type="hidden" name="company_id" value="{{ $data["company_id"] }}">
                        <input type="hidden" name="product_code" value="{{ $data["product_code"] }}">

                        <input type="hidden" name="lounge_name" value="{{ $data["lounge_name"] }}">
                        <input type="hidden" name="terminal" value="{{ $data["terminal"] }}">

                        <input type="hidden" name="checkin_date" value="{{ $data["checkin_date"] }}">

                        <input type="hidden" name="checkin_time" value="{{ $data["checkin_time"] }}">


                        <input type="hidden" name="adults" value="{{ $data["adults"] }}">
                        
                        <input type="hidden" name="children" value="{{ $data["children"] }}">

                        <input type="hidden" name="airport" value="{{ $data["airport"] }}">

                        <input type="hidden" name="promo" value="{{ $data["discount_code"] }}">

                        <input type="hidden" name="pl_id" value="{{ $data["pl_id"] }}">


                        <input type="hidden" name="site_codename" value="">

	                    <input type="hidden" name="park_api" value="{{ $data['park_api'] }}">
	                    
                        <input type="hidden" name="bookingfor" value="lounge">

                        <input type="hidden" name="incomplete" id="incomplete" value="yes">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>




@php
    $total_amount = $data["booking_amount"]+$data["discount_amount"];
@endphp


@endsection
<div class="overlay" style="display: none;"></div>
@section("footer-script")



<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>







<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js" data-autoinit='true'></script>



<script src="https://getaddress.io/js/jquery.getAddress-2.0.8.min.js"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>--}}

<script type="text/javascript">
    $("#bookingButton1").click(function (event) {
        //$("#personal_details_form").valid();
        if ($("#personal_details_form").valid() && $("#vechile_detail").valid()  && $("#travel_detail").valid() ) {
            $('.error').html('<div class="alert alert-success" style=" width: 40%; margin: auto;text-align: center;padding: 10px;margin-top: 16px;"><strong>Success!</strong> This is test booking.</div>');
        }
    });


    $(":input").inputmask();
   
   
    $(".feeinput").click(function (event) {

        ap_processCheckout();

    });

    function showErrorMsg(obj) {

        obj.addClass('border-red');

        obj.after('<span class="error error-massage">Required</span>');

        //$(obj).scrollintoview();

    }

    function hideErrorMsg(obj) {

        obj.find('.border-red').removeClass('border-red');

        obj.find('span.error').remove();

    }

    $(document).ready(function () {

        ap_processCheckout();

        


         $('#contactno').change(function(){
            //hideMsgDiv($("#checkoutPageError"));

            if ($("#personal_details_form").valid()) {

                var data = {};
                
                data['title'] = $('#title').val();

                data['firstname'] = $('#firstname').val();

                data['lastname'] = $('#lastname').val();

                data['email'] = $('#email').val();

                data['contactno'] = $('#contactno').val();

                data['action'] = $('#action').val();

                data['reference_no'] = $('#referenceNo').val();

                data['booking_fee'] ="{{ $settings['booking_fee'] }}";

                data['_token'] = "{{ csrf_token() }}";

                data['refr'] = $('#refr').val();

                data['booking_id'] = $('#bookID').val();


                data['booking_amount'] = $('#bookingprice').val();
                
                data['park_api'] = $('#bookingDetails input[name="park_api"]').val();
         
                data['discount'] = $('#disAmount').val();
                
                data['company_id'] = $('#bookingDetails input[name="company_id"]').val(),
                data['product_code'] = $('#bookingDetails input[name="product_code"]').val(),
                data['lounge_name'] = $('#bookingDetails input[name="lounge_name"]').val(),
                data['terminal'] = $('#bookingDetails input[name="terminal"]').val(),
                
                
                data['checkin_date'] = $('#bookingDetails input[name="checkin_date"]').val(),
                
                data['checkin_time'] = $('#bookingDetails input[name="checkin_time"]').val(),
                
                data['adults'] = $('#bookingDetails input[name="adults"]').val(),
                data['children'] = $('#bookingDetails input[name="children"]').val(),
               
                
                data['airport'] = $('#bookingDetails input[name="airport"]').val(),
                
                data['bookingfor'] = $('#bookingDetails input[name="bookingfor"]').val(),
                
                data['promo'] = $('#bookingDetails input[name="promo"]').val(),
                
                data['smsfee'] = $("#smsfee").is(':checked') ? 'Yes' : 'No',
                
                data['cancelfee'] = $("#cancelfee").is(':checked') ? 'Yes' : 'No',
                
                
                data['incomplete'] = $('#bookingDetails input[name="incomplete"]').val(),
                
                data['pl_id'] = $('#bookingDetails input[name="pl_id"]').val(),
                
                data['speed_park_active'] = $('#bookingDetails input[name="speed_park_active"]').val(),
                
                data['site_codename'] = $('#bookingDetails input[name="site_codename"]').val(),
                
                
                data['sku'] = $('#bookingDetails input[name="sku"]').val();
                
                data['intent_id'] = $('#intent_id').val();
                
                data['edin_active'] = $('#bookingDetails input[name="edin_active"]').val()
                  

                $.post('checkBookingLounge', data, function (data) {

                    //console.log("data===", data);

                    if (data.booking_id > 0) {

                        if (data.available == "Yes") {

                            $("#bookID").val(data.booking_id);

                            $("#referenceNo").val(data.reference_no);

                            $("#incomplete").val('no');

                        }

                        else {

                        }
                    }
                }, 'json');

            }

        });
    });

	
	function showSpinner() {
        $(".overlay").show();
    	$("#imgloader").show();
    }

    function hideSpinner() {
            $(".overlay").hide();
    		$("#imgloader").hide();
    }

    function ap_processCheckout(argument) {

        var smsfee = $("#smsfee").is(':checked') ? 'Yes' : 'No';

        var canfee = $("#cancelfee").is(':checked') ? 'Yes' : 'No';

        CheckoutData(smsfee, canfee);

        //$('[data-toggle="tooltip"]').tooltip();

    }

   function CheckoutData(smsfee, canfee) {

            showSpinner();

            var data = {
                 discount : 1,
                discount : $('#disamount input[name="discount_amount"]').val(),
                airport: $('#bookingDetails input[name="airport"]').val(),

                company_id: $('#bookingDetails input[name="company_id"]').val(),
				
				product_code: $('#bookingDetails input[name="product_code"]').val(),

                checkin_date: $('#bookingDetails input[name="checkin_date"]').val(),

                checkin_time: $('#bookingDetails input[name="checkin_time"]').val(),

                adults: $('#bookingDetails input[name="adults"]').val(),
                children: $('#bookingDetails input[name="children"]').val(),
                
                pl_id: $('#bookingDetails input[name="pl_id"]').val(),

                sku: $('#bookingDetails input[name="sku"]').val(),

                edin_active: $('#bookingDetails input[name="edin_active"]').val(),

                speed_park_active: $('#bookingDetails input[name="speed_park_active"]').val(),

                site_codename: $('#bookingDetails input[name="site_codename"]').val(),

                passenger: $('#passenger').val(),

                promo: $('#bookingDetails input[name="promo"]').val(),

                bookingfor: $('#bookingDetails input[name="bookingfor"]').val(),

                aphactive: $('#bookingDetails input[name="aphactive"]').val(),
                
                total_amount : {{$total_amount}},
                park_api : $('#bookingDetails input[name="park_api"]').val(),
                
                smsfee: smsfee,

                canfee: canfee,

                action: 'booking_checkout'

            };

            data['_token'] = "{{ csrf_token() }}";

            //setProcessBar(75);

            $.post('lounge_checkout', data, function (data) {

                //console.log(data);

                $("#totalPrice").text(data.total_amount);

                $("#ccPrice").text(data.total_amount);

                $("#ddPrice").val(data.total_amount);

                $("#alltotal").val(data.total_amount);

                $("#disAmount").val(data.discount_amount);
				$("#company_name").text(data.company_name);
                 $("#intent_secret").val(data.intent_secret);
                 $("#intent_id").val(data.intent_id);



                if (data.booking_amount > 0) {

                    $("#bookingPriceDiv").text('£'+data.booking_amount);

                    $("#bookingprice").val(data.booking_amount);

                } else {

                    //  showalert();

                }

                if (data.discount_amount > 0) {

                    $("#disfeeprice").text(data.discount_amount);

                    $("#disfee").show();

                    $(".promodiscont").hide();

                } else {

                    $("#disfee").hide();

                }

                if (data.booking_fee > 0) {

                    $("#bookfeeprice").text('£'+data.booking_fee);

                    $("#bookfee").show();

                } else {

                    $("#bookfee").hide();

                }

                if (data.sms_notification > 0) {

                    $("#smsNotificationprice").text(data.sms_notification);

                    $("#smsNotification").show();

                } else {

                    $("#smsNotification").hide();

                }

                if (data.cancellation_fee > 0) {

                    $("#canfeeprice").text(data.cancellation_fee);

                    $("#canfee").show();

                } else {

                    $("#canfee").hide();

                }

                hideSpinner();

            }, 'json');

        }

    function validate_vechiledetail() {

        var html = '<label class="error error-vech" >This field is required.</label>';

        var id = $('input[name=vehdetails]:checked').attr('id');



        $(".error-vech").remove();

        if (id == 'yes') {

            if ($("#registration").val() == "") {

                $("#registration").after(html);

                return false;

            }

            if ($("#make").val() == "") {

                $("#make").after(html);

                return false;

            }

            if ($("#color").val() == "") {

                $("#color").after(html);

                return false;

            }

            if ($("#model").val() == "") {

                $("#model").after(html);

                return false;

            }
        }

        var id2 = $('input[name=flightdetails]:checked').attr('id');

        if (id2 == 'yes') {

            if ($("#departterminal").val() == "") {

                $("#departterminal").after(html);

                return false;

            }

            if ($("#arrivalterminal").val() == "") {

                $("#arrivalterminal").after(html);

                return false;

            }
        }

        return true;
    }

    function valid_address() {
        var html = '<label class="error error-vech" >This field is required.</label>';

        $(".error-vech").remove();

        if ($("#town").val() == "") {

            $("#ad_field").after(html);

            return false;

        }

        if ($("#post_code").val() == "") {

            $("#ad_field").after(html);

            return false;

        }

        return true;

    }

</script>


@if($settings["payment_type"]=='stripe')

    <script src="https://js.stripe.com/v3/"></script>

    <script src="{{ secure_asset('assets/stripe/checkout_lounge.js?123') }}"></script>

    <script src="{{ secure_asset('assets/stripe/example2.js') }}"></script>

    <script src="{{ secure_asset('assets/stripe/l10n.js') }}"></script>

@endif



@endsection

<style type="text/css">
   .menu_item a {
    display: inline-block;
    position: relative;
     font-family: sans-serif!important;
    font-size: 36px;
    color: #FFFFFF;
    font-weight: 400;
}
</style>