   @php
        $site_settings_main=[];
            $settingsAll = App\settings::all();
                    foreach ($settingsAll as $setting) {
                        $site_settings_main[$setting->field_name] = $setting->field_value;
                    }

    @endphp

    <style>
 #widget_socials_453929481_widget .fa:hover {
    opacity: 1;
    color: #fff;
    background-color: #f99f03;
}
.copyright .textwidget {
    margin-top: -18px;
    color: #fff;
}
.copyright p {
    color: black;
    font-size:15px;
    font-family: 'Poppins',sans-serif !important;
}
.contact_info_text, .contact_info_text a{
    line-height: 1.14;
}
p a{
    border:none;
}
.copyright{background: #F79F02;}
.footer{ background: #4D2375;}
@media only screen and (min-width: 372px) {
  .row-pa{margin-left: 20px;margin-right: 20px;}
}
    </style>

      <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #f7a311;color: white;">
        
         <centers > <h4 class="modal-title" style=" color: white">You Can Follow Us & Get Discount Code By E Mail</h4>
        </center></div>
        <div class="modal-body">
         <center> <h3 id="modal-text"></h3></center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" style="    color: #fff;background-color: #f7a311;border-color:#ffffff;" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>
@if(Route::currentRouteName()!= "addBookingForm")
    <!--============== NEWSLETTER ===============-->
    <!--<section id="newsletter" class="banner-padding row" style="-->
    <!--background-color: #dcdcdc;-->
    <!--padding: 6%;">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="color: #350a4e">-->
    <!--                <h2>{!! $site_settings_main["homepage_joinus_heading"]  !!}</h2>-->
    <!--                <h3 style="color: black !important;">{!! $site_settings_main["homepage_joinus_subheading"]  !!}</h3>-->
    <!--                <p>{!! $site_settings_main["homepage_joinus_text"]  !!}</p>-->
    <!--                <form id="subscribe_user" action="{{ route("subscribe_user") }}" method="post">-->
    <!--                    @csrf-->

    <!--                    <div class="form-group">-->

    <!--                        <div class="input-group">-->
    <!--                            <input id="subscribe_user_name" name="name" type="text"-->
    <!--                                   style=""-->
    <!--                                   class="form-control input-lg" placeholder="Enter Your Name" required/>-->
    <!--                               </div><br>-->
    <!--                               <div class="input-group"> -->
    <!--                            <input id="subscribe_user_email" name="email" type="email" -->
    <!--                                   class="form-control input-lg" placeholder="Your Email Address" required/>-->
    <!--                            </div><br>-->
    <!--                               <center> <span class="input-group-btn">-->

    <!--                            <button id="subscribe_user" class="btn btn-lg" style="background: #f99f03;"><i-->
    <!--                                            class="fa fa-paper-plane"></i> Submit</button></span></center>-->

    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div id="error_message"></div>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
@endif
    <footer class="footer">
        <div class="container">
            <div class="row">

                <!-- Footer Column -->
                 <div class="col-lg-3 col-md-6 footer_column">
                    <div class="footer_col">
                        <div class="footer_content footer_about">
                            <div class="logo_container footer_logo">
                                <div class="logo"><a href="#"><img style="width: 175px; height: 74px;" src="{{url('theme/images/logo1.webp')}}" loading="lazy" alt="Parking Zone White Logo"></a></div>
                            </div>
                            <p class="footer_about_text" style="font-size:16px">{{$site_settings_main["footer_catch_line"]}}</p>
                                
                        </div>
                    </div>
                </div>

                <!-- Footer Column -->
                <div class="col-lg-3 col-md-6 footer_column">
                    <div class="footer_col">
                        <div class="footer_title">AIRPORTS</div>
                        <br>
                             <div class="menu-navigation-container">
                                                        <ul >
                                                         	<li id=""
                                                                class=" contact_info_text  menu-item-332">
                                                                <a href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  ">
                                                                <a href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow
                                                                    Airport Parking</a>
                                                            </li>
                                                           <li id=""
                                                                class=" contact_info_text  menu-item-334">
                                                                <a href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted
                                                                    Airport Parking</a>
                                                            </li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-334">
                                                                <a href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham
                                                                    Airport Parking</a>
                                                            </li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-621">
                                                                <a href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"glasgow-airport-parking"]) }}">Glasgow
                                                                    Airport Parking</a></li>
                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"bristol-airport-parking"]) }}">Bristol
                                                                    Airport Parking</a></li>

                                                            <li id=""
                                                                class=" contact_info_text  menu-item-622">
                                                                <a href="{{ route("page",["slug"=>"east-midlandsairport-parking"]) }}">East Midlands Airport Parking</a></li>
                                                        </ul>
                                                    </div>
                    </div>
                </div>

                <!-- Footer Column -->
                <div class="col-lg-3 col-md-6 footer_column">
                    <div class="footer_col">
                        <div class="footer_title"> Navigation</div>
                             <br>
                             <div class="menu-navigation-container">
                                                          <ul >
                                                            <li id="menu-item-332"
                                                                class="contact_info_text menu-item-332">
                                                                <a href="{{ route("main") }}">Home</a></li>
                                                                <li id=""
                                                                class="contact_info_text menu-item-340">
                                                                <a href="{{ url("about-us") }}">About Us</a></li>
                                                                 <li id=""
                                                                class="contact_info_text menu-item-340">
                                                                <a href="{{ route("faqs") }}">FAQs</a></li>
                                                            <li id="menu-item-333"
                                                                class="contact_info_text menu-item-333">
                                                                <a href="{{ route("airportsparking") }}">Airport Parking</a>
                                                            </li>
                                                            <li id="menu-item-333"
                                                                class="contact_info_text menu-item-333">
                                                                <a href="{{ route("contact-us") }}">Contact Us</a>
                                                            </li>
                                                            <li id="menu-item-334"
                                                                class="contact_info_text menu-item-334">
                                                                <a href="{{ route("support") }}">Help Desk</a>
                                                            </li>
                                                            <li id="menu-item-621"
                                                                class="contact_info_text menu-item-621">
                                                                <a href="{{ route("static_page",["page"=>"privacy-policy"]) }}">Privacy
                                                                    Policy</a></li>
                                                            <li id="menu-item-622"
                                                                class="contact_info_text menu-item-622">
                                                                <a href="{{ route("static_page",["page"=>"site-security"]) }}">Site
                                                                    Security</a></li>


                                                            <li id="menu-item-621"
                                                                class="contact_info_text menu-item-621">
                                                                <a href="{{ route("airports") }}">All Airports</a></li>
                                                                
                                                                
                                                              {{-- <li id="menu-item-621"
                                                                class="contact_info_text menu-item-621">
                                                                <a>Rate Us</a></li> --}}
                                                            <!--<li id="menu-item-622"-->
                                                            <!--    class="contact_info_text menu-item-622">-->
                                                            <!--    <a href="https://www.parkingzone.co.uk/blog">Blog</a>-->
                                                            <!--</li>-->
                                                        </ul>
                                                        <div class="row copy-right-main"> 
                                            <a href="//www.dmca.com/Protection/Status.aspx?ID=00d7fa62-cad9-46d5-a753-ca722bb5c731" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/_dmca_premi_badge_5.png?ID=00d7fa62-cad9-46d5-a753-ca722bb5c731" loading="lazy" alt="DMCA.com Protection Status"  defer /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js" defer> </script>
                                          
                                            <a href="https://www.dmca.com/compliance/www.parkingzone.co.uk" title="DMCA Compliance information for www.parkingzone.co.uk"><img width="80" alt="dmca" style="    margin-left: 8px;" src="{{ secure_asset("public/assets/dmca.png") }}" /></a>
                                        
                                </div>
                                                    </div>
                                           
                    </div>
                </div>

                <!-- Footer Column -->
                <div class="col-lg-3 col-md-6 footer_column">
                    <div class="footer_col">
                        <div class="footer_title">Other Pages</div>
                             <br>
                             <div class="menu-navigation-container">
                                                         <ul >
                                                            <li id=""
                                                                class="contact_info_text menu-item-339">
                                                                <a href="{{ route("static_page",["page"=>"affiliates"]) }}">Affiliate </a>
                                                            </li>
                                                            <li id=""
                                                                class="contact_info_text menu-item-338">
                                                                <a href="{{ route("static_page",["page"=>"cookies"]) }}">Cookies</a>
                                                            </li>
                                                           
                                                            <li id=""
                                                                class="contact_info_text menu-item-339">
                                                                <a href="{{ route("sitemap") }}">Site Map </a></li>

                                                            {{--<li id=""--}}
                                                            {{--class="contact_info_text menu-item-340">--}}
                                                            {{--<a href="{{ route("reviews") }}">Reviews</a></li>--}}
                                                            <li id=""
                                                                class="contact_info_text menu-item-340">
                                                                <a href="{{ route("airport_guide") }}">Airport Guide</a>
                                                            </li>
                                                            <li id=""
                                                                class="contact_info_text menu-item-340">
                                                                <a href="{{ route("static_page",["page"=>"terms-and-conditions"]) }}">Terms
                                                                    & Conditions</a></li>

                                                        </ul>
                                                    </div>
                                                    
                                                    
                            
                            <p class="footer_title" style="font-weight: 500; text-transform: none;"><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:bookings@parkingzone.co.uk">bookings@parkingzone.co.uk</a></p> 
                            <p class="footer_title" style="font-weight: 500; text-transform: none;"><i class="fa fa-phone" aria-hidden="true"></i>  <a href="tel:020 4511 4171"> 020 4511 4171</a></p> 
                            
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- Copyright -->

    <div class="copyright">
          <div class="container" style="text-align: center;"> 
              
                 <div class="row">
                  <div class="col-sm-8">
                      <div class="textwidget">
                    <span>
                        <!--@if($site_settings_main["footer_address"] != "")-->
                        <!--  <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp{{$site_settings_main["footer_address"]}}-->
                        <!--@endif -->
                        @if($site_settings_main["footer_email"] != "")
                             <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp{{$site_settings_main["footer_email"]}}
                        @endif
                        &nbsp 
                      <!--   @if($site_settings_main["footer_phone_no"] != "")
                             <i class="fa fa-phone" aria-hidden="true"></i>&nbsp{{$site_settings_main["footer_phone_no"]}}
                        @endif -->
                    </span>
                    <p><a href="{{ route('main') }}">ParkingZone</a> {{$site_settings_main["footer_copyright"]}} <span class=""> {{$site_settings_main["footer_company_reg_no"]}}</span> 
                    
                    </p>
                </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="social-icons">
                               <aside id="widget_socials_453929481_widget"
                                  class="widget widget_socials">
                                  <div class="socials_wrap sc_align_left">  
                                     @if(array_key_exists("twitter",$site_settings_main) && $site_settings_main["twitter"] !="" && $site_settings_main["twitter_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["twitter"] }}" class="fa fa-twitter"></a>
                                     @endif
                                     @if(array_key_exists("google_plus",$site_settings_main) && $site_settings_main["google_plus"] !="" && $site_settings_main["google_plus_status"] =="active" )
                                     <a target="_blank"
                                     href="{{ $site_settings_main["google_plus"] }}" class="fa fa-google_plus"></a>
                                     @endif
                                     @if(array_key_exists("instagram",$site_settings_main) && $site_settings_main["instagram"] !="" && $site_settings_main["instagram_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["instagram"] }}" class="fa fa-instagram"></a>
                                     @endif
                                     @if(array_key_exists("youtube",$site_settings_main) && $site_settings_main["youtube"] !="" && $site_settings_main["youtube_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["youtube"] }}" class="fa fa-youtube"></a>
                                     @endif
                                     @if(array_key_exists("pinterest",$site_settings_main) && $site_settings_main["pinterest"] !="" && $site_settings_main["pinterest_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["pinterest"] }}" class="fa fa-pinterest"></a>
                                     @endif
                                     @if(array_key_exists("linkedin",$site_settings_main) && $site_settings_main["linkedin"] !="" && $site_settings_main["linkedin_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["linkedin"] }}" class="fa fa-linkedin"></a>
                                     @endif
                                     @if(array_key_exists("facebook",$site_settings_main) && $site_settings_main["facebook"] !="" && $site_settings_main["facebook_status"] =="active")
                                     <a target="_blank"
                                     href="{{ $site_settings_main["facebook"] }}" class="fa fa-facebook"></a> 
                                     @endif
                                  </div>
                               </aside>
                            </div>
                  </div>
              </div>
           
        </div>
    </div>

</div>
<style>
.rChev, .lChev{
	z-index: 10000 !important;
}
</style>
<link href="{{url('theme/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}"  rel="stylesheet" type="text/css">
<link rel="stylesheet"   type="text/css" href="{{url('theme/styles/responsive.css')}}">


<script async src="{{url('theme/js/jquery-3.2.1.min.js')}}" ></script>
<script defer src="{{url('theme/styles/bootstrap4/popper.js')}}" ></script>
<script defer src="{{url('theme/styles/bootstrap4/bootstrap.min.js')}}"></script>
<script async src="{{url('theme/plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{url('theme/plugins/easing/easing.js')}}" ></script>
<script async src="{{url('theme/js/custom.js')}}"></script>
<script async src="{{ secure_asset('assets/front/js/bootstrap-datepicker.js') }}"></script>
<script async src="{{ secure_asset('assets/front/js/custom-date-picker.js') }}"></script>


<!--script type='text/javascript'>
window.__lo_site_id = 248579;

	(function() {
		var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
		wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
	  })();
</script-->



<!--<script async type="text/javascript" src="{{ secure_asset("assets/front/parkingzone/js/trx_addons.js") }}"></script>-->


<script src="{{url('theme/tinyCalender/index.js')}}"></script>
@if(substr(strrchr(url()->current(),"/"),1)!='result')
<script>
    var startdate = new Date();
    startdate.setDate(startdate.getDate()+ 1);
	var enddate = new Date();
    enddate.setDate(enddate.getDate()+ 8);
	new TinyPicker({ 
	format: 'dd-mm-yyyy',
	firstBox:document.getElementById('startDate'), // Required -- Overrides us finding the first input box
	lastBox: document.getElementById('endDate'), // Required -- Overrides us finding the last input box
	startDate: startdate, // Needs to be a valid instance of Date   
    endDate: enddate, // Needs to be a valid instance of Date
	allowPast: false, // If you want the user to be able to select past dates
	useCache: true, 
	orientation: "top auto",
	 horizontal: 'auto',
    vertical: 'auto',
}).init();
</script>
@else
@php

$dropdate = str_replace('/', '-', request()->dropoffdate);		
$pickdate = str_replace('/', '-', request()->departure_date);

$dropofdate = date('m/d/Y', strtotime($dropdate));
$pickupdate = date('m/d/Y', strtotime($pickdate));

@endphp
<script>
$(document).ajaxStop(function () {
    //var dropDate = '{{ request()->dropoffdate }}';
    //var departureDate = '{{ request()->departure_date }}';

    
    var dropDate = '{{ $dropofdate }}';
    var departureDate = '{{ $pickupdate }}';


	var enddate = new Date(departureDate);
    // enddate.setDate(enddate);
	new TinyPicker({ 
	firstBox:document.getElementById('startDate'), // Required -- Overrides us finding the first input box
	lastBox: document.getElementById('endDate'), // Required -- Overrides us finding the last input box
	startDate: new Date(dropDate), // Needs to be a valid instance of Date   
    endDate: enddate, // Needs to be a valid instance of Date
	allowPast: false, // If you want the user to be able to select past dates
	useCache: true, 
	orientation: "top auto",
	 horizontal: 'auto',
	 success: function(startDate, endDate){}, // callback function when user inputs dates,
    vertical: 'auto',

}).init();
});
</script> 
@endif

<script async type="text/javascript">

    $(document).ready(function () {
       

 
        // process the form
        $('#subscribe_user').submit(function (event) {

            var formData = {
                'name': $('#subscribe_user_name').val(),
                'email': $('#subscribe_user_email').val(),
                '_token': '{{ @csrf_token() }}'
            };

            // process the form
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{{ route("subscribe_user") }}', // the url where we want to POST
                data: formData, // our data object
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
            // using the done promise callback
                .done(function (data) {


                    // log data to the console so we can see
                    console.log(data);
                     if (data.success == 0) {
                        if(data.errors=='validation.unique'){


                       $("#modal-text").html('This email already subscribed');
                       $("#modal-text").css("color", "red");
                       $('#myModal').modal('show'); 
                        }else
                        {

                       $("#modal-text").html(data.errors);
                       $("#modal-text").css("color", "red");
                       $('#myModal').modal('show'); 
                   }
                      //  $("#error_message").html(data.errors);
                       // $("#error_message").css("color", "red");
                    } else {
                        $("#modal-text").html(data.data);
                       // alert(data.data);
                        $('#myModal').modal('show'); 
                    }

                    // here we will handle errors and validation messages
                });

            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
        });

    });

</script>

<script async  type="text/javascript">
    $(".accordion-toggle").on('click', function (e) {
        e.preventDefault();
        $($(this).attr("href")).toggleClass('collapse');
        var condition = false;
        if ($($(this).attr("href")).attr("aria-expanded") == false) {
            condition = true;
        } 
    });

    // $(function() {
    //     $("#startDate").datepicker({
    //         numberOfMonths: 1
    //     });
    // });
$(document).mouseleave(function () {
    console.log('out');
});
</script>

@section("footer-script")

@show


<!-- paid on result -->
<script language="JavaScript" src="//porjs.com/1747.js"></script>

<script >
	jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};
</script>
<script>
$(document).ready(function(){
// 	$('#search-box').on('keyup', function () {
// 		var given_name = $(this).val();
// 		$.ajax({
// 			url: '{{url("get_location_suggestion")}}',
// 			type: 'POST',
// 			dataType: 'html',
// 			data:'keyword='+given_name
// 		}).success(function (data) {
// 		   $("#suggesstion-box").show();
// 			$("#suggesstion-box").html(data);
// 			$("#search-box").css("background","transparent");
// 		});
// 	})
    $("#search-box").keyup(function (e){
        setTimeout(getSuggestion($(this).val()), 500);
    });
    function getSuggestion(keyword){
        $("#loc_type").val('');
        $("#loc_code").val('');
        $("#loc_name").val('');
        $("#loc_lat").val('');
        $("#loc_long").val('');
        $("#loc_country").val('');
        $("#loc_id").val('');
        
        var formData = {
            'keyword': keyword
        };
    	$.ajax({
    	type: "POST",
    	url: '{{url("get_location_suggestion")}}',
    	data: formData,
    	beforeSend: function(){
    		$("#search-box").css("background","#FFF url(https://zmdtravel.com/theme/images/LoaderIcon.gif) no-repeat 110px");
    	},
    	success: function(data){
    		$("#suggesstion-box").show();
    		$("#suggesstion-box").html(data);
    		$("#search-box").css("background","#FFF");
    	}
    	});
    }
    
    $("#search-box-dropoff").keyup(function (e){
        setTimeout(getSuggestionDropoff($(this).val()), 500);
    });
    function getSuggestionDropoff(keyword){
        $("#loc_type_drop").val('');
        $("#loc_code_drop").val('');
        $("#loc_name_drop").val('');
        $("#loc_lat_drop").val('');
        $("#loc_long_drop").val('');
        $("#loc_country_drop").val('');
        $("#loc_id_drop").val('');
        
        var formData = {
            'keyword': keyword,
            'loc_type': $("#loc_type").val()
        };
    	$.ajax({
    	type: "POST",
    	url: '{{url("get_location_suggestion_drop")}}',
    	data: formData,
    	beforeSend: function(){
    		$("#search-box-drop").css("background","#FFF url(https://zmdtravel.com/theme/images/LoaderIcon.gif) no-repeat 110px");
    	},
    	success: function(data){
    		$("#suggesstion-box-drop").show();
    		$("#suggesstion-box-drop").html(data);
    		$("#search-box-drop").css("background","#FFF");
    	}
    	});
    }
});
function selectRegion(loc_type,loc_name,loc_code, loc_lat, loc_long, loc_country, loc_id) {
    $("#search-box").val(loc_name);
    $("#loc_type").val(loc_type);
    $("#loc_code").val(loc_code);
    $("#loc_name").val(loc_name);
    $("#loc_lat").val(loc_lat);
    $("#loc_long").val(loc_long);
    $("#loc_country").val(loc_country);
    $("#loc_id").val(loc_id);
    
    $("#suggesstion-box").hide();
}

function selectHotel(loc_type,loc_name,loc_code, loc_lat, loc_long) {
    $("#search-box").val(loc_name);
    $("#loc_type").val(loc_type);
    $("#loc_code").val(loc_code);
    $("#loc_name").val(loc_name);
    $("#loc_lat").val(loc_lat);
    $("#loc_long").val(loc_long);
    $("#loc_country").val('');
    $("#loc_id").val('');
    
    $("#suggesstion-box").hide();
}

function selectRegionDrop(loc_type,loc_name,loc_code, loc_lat, loc_long, loc_country, loc_id) {
    $("#search-box-dropoff").val(loc_name);
    $("#loc_type_drop").val(loc_type);
    $("#loc_code_drop").val(loc_code);
    $("#loc_name_drop").val(loc_name);
    $("#loc_lat_drop").val(loc_lat);
    $("#loc_long_drop").val(loc_long);
    $("#loc_country_drop").val(loc_country);
    $("#loc_id_drop").val(loc_id);
    
    $("#suggesstion-box-drop").hide();
}

function selectHotelDrop(loc_type,loc_name,loc_code, loc_lat, loc_long) {
    $("#search-box-dropoff").val(loc_name);
    $("#loc_type_drop").val(loc_type);
    $("#loc_code_drop").val(loc_code);
    $("#loc_name_drop").val(loc_name);
    $("#loc_lat_drop").val(loc_lat);
    $("#loc_long_drop").val(loc_long);
    $("#loc_country_drop").val('');
    $("#loc_id_drop").val('');
    
    $("#suggesstion-box-drop").hide();
}
</script>
            

</body>

</html>