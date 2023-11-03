@include('layouts.header')
@include('layouts.nav')
<style>
    .copyright{
        height: 80px;
    padding-top: 10px;
    }
    @media only screen and (max-width: 991px) {
   .home_slider{
            display:none !important;
        }
}
@media only screen and (max-width: 767px) {
   .for-offres-intro .intro_center{
        min-height: 160px!important;
        }
}
</style>
@php
$site_settings_main=[];
$settingsAll = App\settings::all();
foreach ($settingsAll as $setting) {
$site_settings_main[$setting->field_name] = $setting->field_value;
}

$sliders = unserialize($site_settings_main['sliders']);

@endphp

<!--<div class="">-->
<!--    <div class="">-->
        <!--<div class="owl-carousel owl-theme home_slider">-->
        <!--    @foreach($sliders as $slider)-->
        <!--    <div class="owl-item home_slider_item">-->
        <!--        <div class="home_slider_background" style="background-image:url('{{$slider}}"></div>-->
        <!--        <div class="home_slider_content1">-->
        <!--            <div class="home_slider_content_inner">-->
        <!--                <p class="heading-1"><b>Your Premier Airport Parking Solution!</b></p>-->
        <!--                <p class="heading-2" style="font-size:23px"><b>  Over 100's of Airport Car Parks Across the UK.</b></p>-->
                        <!-- <p class="heading-3"> <b>Exclusive Offers </b></p> -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    @endforeach-->
        <!--</div>-->
        @include('layouts.search_form')
<!--    </div>-->
<!--</div>-->

<style type="text/css">
.for-offres-intro .offers_link {margin-top: 0px;}
.for-offres-intro div.cal{overflow: hidden !important;}

.for-offres-intro .offers {top: 20px;width: 100%;padding-top: 49px;padding-bottom: 0px;background: #f3f6f9;}
.for-offres-intro .intro {width: 100%;padding-top: 2px;padding-bottom: 105px;top: 0px;position: relative;}
.for-offres-intro .offers_col {margin-bottom: 15px;}
.for-offres-intro .offers_price {display: inline-block;font-size: 20px;font-weight: 700;color: #eda84a;line-height: 25px;}
.for-offres-intro .offers_items {margin-top: 10px;}
.for-offres-intro .intro_items { margin-top: 10px;}
.for-offres-intro .intro_center {margin-top: 0;padding: 10px 15px;;min-height:260px;}
.for-offres-intro .intro_item_content {width: 100%;height: 100%;z-index: 3;box-shadow: 2px 2px 20px 7px #00000038;}
.for-offres-intro .testimonials {width: 100%;padding-top: 0px;padding-bottom: 105px;background: #FFFFFF;}
.for-offres-intro .testimonials {width: 100%;top: 70px;padding-top: 0px;padding-bottom: 10px;background: #FFFFFF;}
.for-offres-intro .search {top: 0px;}
/*.search_tabs {.for-offres-intro height: 71px;}*/
.for-offres-intro .home {width: 100%;height: 580px;position: relative;}
.for-offres-intro .home_slider_container {position: absolute;top: 0;left: 0;width: 100%;height: 90%;z-index: 10;background: #31124b;}
.for-offres-intro .intro {width: 100%;padding-top: 2px;padding-bottom: 105px;top: 40px;}
.for-offres-intro .trending {width: 100%;padding-top: 50px;top: -100px;}
@media only screen and (max-width: 360px){.for-offres-intro    .intro {width: 100%;padding-top: 2px;padding-bottom: 76px;top: 0px;}}
.for-offres-intro .icon-bg {color: #FFF;width: 66px;height: 66px;max-width: 66px;max-height: 66px;border-radius: 50%;display: table;}
.for-offres-intro .text-center .icon-border,.for-offres-intro  .text-center .icon-bg {margin: 0 auto;}
.for-offres-intro .bg-default {background-color: #522c73 !important;}
.for-offres-intro .text-center {text-align: center!important;}
.for-offres-intro .icon .number {font-weight: 700;font-size: 24px;}
.for-offres-intro .icon-bg i,.for-offres-intro  .icon .number {display: table-cell;text-align: center;margin: 0 auto;vertical-align: middle;}
.checked{color: #fa9e1b;font-size: 13px;}
.unchecked{font-size: 13px;}
@media(min-width: 768px) {.for-offres-intro   .process-wrapper.line [class*="col-"] {position: relative;}
 .for-offres-intro    .process-wrapper.line [class*="col-"]:before,
 .for-offres-intro    .process-wrapper.line [class*="col-"]:after {width: calc(50% - 66px);position: absolute;content: "";height: 1px;background: rgba(21, 21, 21, 0.15);top: 33px;z-index: 1;left: 0;margin-left: 0;}
.for-offres-intro .process-wrapper.line [class*="col-"]:after {right: 0;left: auto;margin-right: 0;margin-left: 0;}
 .for-offres-intro .process-wrapper.line [class*="col-"]:first-child:before,
 .for-offres-intro .process-wrapper.line [class*="col-"]:last-child:after { display: none;}}
.for-offres-intro .intro_item .box {font-size: 14px;padding: 15px 10px;font-weight: 600;}
.for-offres-intro .intro_item .box i {font-size:22px; padding-right: 10px;}
.for-offres-intro h5 {color:#333; margin:15px 0px;}
.for-offres-intro h2,h3,h4,h6{color:#333;}
.BOOKING-PROCEE{text-align: center!important;color: #31124b;font-family:'Source Sans Pro',Arial,Helvetica,sans-serif;text-shadow: rgb(0 0 0 / 1%) 0 0 1px;font-size: 36px;margin-bottom: 0.5rem;font-weight: 500;margin-top: 0px;}
.heading-1{
    font-size: 29px;
    color: #fff;
}
.intro_item .box {
    background: #624a8e !important;
    border-bottom: 2px solid #fa9e1b;
    border-radius: 10px 10px 0px 0px;
}
.for-offres-intro .intro_center {
    margin-top: 0;
    padding: 10px 15px;
    min-height: 260px;
    background-color: #624a8e;
    border-radius: 0px 0px 10px 10px;
}
.for-offres-intro .intro_item_content{
    box-shadow: none !important;
}
.associate_area {
    /*padding: 79px 0 16px;*/
    overflow: hidden;
    background: #fff;
}
.h2tag {
    /*margin: 0 0 75px;*/
    padding-top: 60px;
    font-size: 40px;
    font-weight: bolder;
    text-align: center;
}
.comparetag {
    padding-top: 60px;
    font-size: 40px;
    font-weight: bolder;
    text-align:left;
     padding:0px;
}
.h2tag-p{
    font-size:20px;
    color:black;
    text-align:center;
        /*padding-left: 145px;*/
    /*padding-right: 145px;*/
}
@media only screen and (min-width: 1266px) {
  .h2tag-p{
        padding-left: 145px;
    padding-right: 145px;
}
}
.compare-p{
    font-size:20px;
    color:black;
    text-align:left;
   
}
.post_wrap {
    position: relative;
    text-align: center;
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    padding: 0 10px;
    height: 100%;
}
.wrap2 {
    font-size: 16px;
    line-height: 25px;
    position: relative;
    /*padding: 0 0 24px;*/
    flex-grow: 1;
}
.icon-holder {
    margin: 0;
    /*min-height: 123px;*/
    float: none;
    min-width: 100%;
    display: block;
}
.text-holder {
    overflow: hidden;
    font-size: 14px;
    line-height: 25px;
    font-weight: 400;
    color: black;
    /*width: 245px;*/
}
@media only screen and (max-width: 1199px) {
  .text-holder {
    overflow: hidden;
    font-size: 14px;
    line-height: 25px;
    font-weight: 400;
    color: black;
    width: 100%;
}
}

.h3tag2{
    margin: 0 0 5px;
    font-size: 20px;
    font-weight: 600;
    color: black;
    text-align: center;
    text-transform: uppercase;
    height:66px;
    margin-top:22px;
}
.h3tag3{
    margin: 0 0 5px;
    font-size: 20px;
    font-weight: 600;
    color: black;
    text-align: center;
    text-transform: uppercase;
    height:66px;
    margin-top:22px;
}
.h3tag {
    margin: 0 0 5px;
    font-size: 22px;
    font-weight: 600;
    color: black;
    text-align: center;
    text-transform: uppercase;
    height:66px;
}
.h3tag1 {
    margin: 0 0 5px;
    font-size: 20px;
    font-weight: 600;
    color: black;
    text-align: center;
    text-transform: uppercase;
    height:66px;
    margin-top:22px;
    /*width:295px;*/
}
.view-more {
    position: relative;
    color: #31124b;
    font-weight: 700;
    transition: all .4s linear;
}
@media only screen and (min-width: 1300px) {
  .cont {
    max-width: 1266px;
  }
}
.card-cor{
   border-radius:24px;
   border:1px solid #F79F02;
   box-shadow: 0px 1px 5px 1px #F79F02;
   max-width:300px;
   height: 420px;
       border-radius: 24px !important;
}
.card-row{
    margin-right:80px;
    margin-left:80px;
}
.card-h4{
    font-size: 18px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 600;
}
.card-text1{
    font-size: 14px;
    padding-top:27px;
}
.datepicker{
    display:none !important;
}
@media only screen and (min-width: 1200px) { 
        .for-offres-intro .intro_center{min-height: 250px;}
            
        }
        @media screen and (min-device-width: 993px) and (max-device-width: 1199px) { 
        .intro_center{height: 260px !important;}
        .cen{height:34px;}
        }
         @media screen and (min-device-width: 273px) and (max-device-width: 1273px) { 
        .p1{    font-size: 18px;}
        }
        @media screen and (min-device-width: 993px) and (max-device-width: 1199px) { 
        .for-offres-intro .intro_center{min-height: 306px;}
        }
        @media screen and (min-device-width: 768px) and (max-device-width: 991px) { 
        .intro_center .text-center{min-height: 211px !important;}
        }
        @media screen and (min-device-width: 992px) and (max-device-width: 1199px) { 
        .card-text1{min-height: 200px !important;}
        }
        
        .p12{
            font-size:16px;
        }
        @media screen and (min-device-width: 992px) and (max-device-width: 1199px) { 
        .h3tag3 {height: 93px;}
        .h3tag1 {height: 93px;}
        .h3tag2 {height: 93px;}
        }
        @media only screen and (min-width:992px){
            .f-l{
            text-align:right;
        }
        }
        @media only screen and (max-width:991px){
            .f-l{text-align:center;}
        .compare-p{ padding:0px !important;}
        }
        .row-compare{
            margin-left: 80px;
            margin-right: 80px;
        }
        @media only screen and (max-width:600px){
           .row-compare{margin-left: 30px;margin-right: 30px;}
        }
        .compare-con{
            margin-top: 20px;
            margin-bottom: 84px;
        }
        .compare-img{
            width: 496px; height: 359.69px;
        }
        @media only screen and (min-width:1108px){
             .compare-img { width: 496px; height: 294.69px;}
        }
        @media screen and (min-device-width: 992px) and (max-device-width: 1032px) { 
        .compare-img { width: 471px; height: 354.69px;}
        }
        @media screen and (min-device-width: 460px) and (max-device-width: 618px) { 
        .compare-img { width: 369px; height: 272.69px;}
        }
        @media screen and (min-device-width: 350px) and (max-device-width: 459px) { 
        .compare-img { width: 246px; height: 195px;}
        }
        @media screen and (min-device-width: 300px) and (max-device-width: 349px) { 
        .compare-img { width: 218px; height: 179px;}
        }
        @media only screen and (max-width:299px){
             .compare-img { width: 175px; height: 204px;}
        }
        .img-circle{
            margin-top:33.85px;
            /*margin-left:115px;*/
            /*margin-right:115px;*/
            margin-bottom:33.15px;
        }
         @media only screen and (max-width:992px){
             .card-cor {max-width: 100%;  height:100%; }
        }
        @media only screen and (max-width:712px){
             .card-row { margin-right: 10px; margin-left: 10px;}
        }
        .tipsh2{
            padding-top: 60px;
    font-size: 40px;
    font-weight: bolder;
    text-align: center;
    padding-bottom: 60px;
        }
        .offers_item{
            border-radius:24px;
            padding:0px;
            border:none;
        }
        .airport-h{
            font-size:16px;
            font-weight:600;
            color:#000000;
        }
        .offers_price span{
            color:#4D2375;
            font-size:16px;
             font-weight: 600;
        }
        .offers_price1 span{
            color:#F79F02;
            font-size:16px;
             font-weight: 600;
        }
        .offers_link{
            background-color:#F79F02;
            border:none;
            color:black;
            border-radius:5px;
        }
        .offers_link a:hover{
           color:white;
        }
        @media only screen and (max-width:330px){
             .offers_item {padding: 20px; }
             .row-a{
                margin-top: -20px;
        }
        }
        .sectt{
            padding:10px;
        }
        @media only screen and (min-width:1300px){
             .compare-p {
                /*max-width: 600px;*/
            }
            /*.sectt {*/
            /*    padding-left: 80px;*/
            /*    padding-right: 80px;*/
            /*}*/
        }
       .connt{
           max-width: 1419px;
       }
       
       @media only screen and (min-width: 516px) {
    /*      .offers_items{*/
    /*            margin-left: 45px !important;*/
    /*margin-right: 45px !important;*/
    /*    }*/
        .div { display:none; }
        @media only screen and (min-width:1588px){
             .row-compare {    margin-left: -200px !important;margin-right: -200px !important; }
        }
         @media screen and (min-device-width: 1465px) and (max-device-width: 1587px) { 
        .row-compare {    margin-left: -166px !important;margin-right: -166px !important; }
        }
        @media screen and (min-device-width: 1360px) and (max-device-width: 1464px) { 
        .row-compare {    margin-left: -110px !important;margin-right: -110px !important; }
        }
        
        @media only screen and (min-width:1588px){
            .offers_items {    margin-left: -200px !important;margin-right: -200px !important; }
        }
         @media screen and (min-device-width: 1465px) and (max-device-width: 1587px) { 
        .offers_items {    margin-left: -166px !important;margin-right: -166px !important; }
        }
        @media screen and (min-device-width: 1360px) and (max-device-width: 1464px) { 
        .offers_items {    margin-left: -110px !important;margin-right: -110px !important; }
        }
</style>
<section>
    <div class="container-fluid connt">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="associate_area">
                    <h2 class="h2tag">Finding Your <span style="color:#F79F02">Premier Deals</span> on Airport Parking</h2>
                    <p class="h2tag-p">Your years of trust have established us as the UK's most reliable airport parking provider. As the leading parking brand, we have unparalleled expertise in Airport Parking.Choose the best with us and enjoy up to 60% discount on pre-booking. With an exceptional average customer review core of 96%, we deliver top-notch airport parking solutions tailored to your needs.</p>
                        <div class="row" style="margin-top: 60px;">
                            <div class="col-lg-3  col-md-6 mb-5 mb-lg-6">
                                <div class="post_wrap">
                                    <div class="wrap wrap2">
                                        <div class="icon-holder">
                                            <img src="{{url('public/assets/images/Group 279.webp')}}" alt="SATISFIED CUSTOMERS" style="width: 96px; height: 81px;">
                                        </div>
                                        <div class="text-holder">
                                            <h3 class="h3tag2">1000's Satisfied Customers  </h3>
                                            <p class="text-holder">Parking Zone prides itself on a 94% customer satisfaction rating from 1000's reviews. We welcome feedback on every car park and openly display reviews to help you make the most informed decision.</p>
                                        </div>
                                    </div>
                                <!--<a href="#" class="view-more" ><span style="border-top:1px solid #31124b">VIEW MORE</span></a>-->
                                </div>
                            </div>
                            <div class="col-lg-3  col-md-6 mb-5 mb-lg-6">
                                <div class="post_wrap">
                                    <div class="wrap wrap2">
                                        <div class="icon-holder">
                                            <img src="{{url('public/assets/images/update_adobe_express 1.webp')}}" alt="EASY CANCELLATION AND AMENDMENTS" style="width: 90px; height: 82px;">
                                        </div>
                                        <div class="text-holder">
                                            <h3 class="h3tag3">Easy Cancellation and Amendments</h3>
                                            <p class="text-holder">No worry if your travelling plan got cancelled!  We have a free cancellation policy on our flexible deals. You can cancel, amend and re-book whenever you want in case of a plan change. </p>
                                        </div>
                                    </div>
                                <!--<a href="#" class="view-more"><span style="border-top:1px solid #31124b">VIEW MORE</span></a>-->
                                </div>
                            </div>
                            <div class="col-lg-3  col-md-6 mb-5 mb-lg-6">
                                <div class="post_wrap">
                                    <div class="wrap wrap2">
                                        <div class="icon-holder">
                                            <img src="{{url('public/assets/images/business_adobe_express 1.webp')}}" alt="YEARS OF PROFESSIONAL EXPERIENCE" style="width: 80px; height: 80px;">
                                        </div>
                                        <div class="text-holder">
                                            <h3 class="h3tag1">YEARS OF PROFESSIONAL EXPERIENCE</h3>
                                            <p class="text-holder">Years of experience have established us as the leading parking providers across the UK. Your trust, reliance and confidence have made us what we are today.</p>
                                        </div>
                                    </div>
                                <!--<a href="#" class="view-more"><span style="border-top:1px solid #31124b">VIEW MORE</span></a>-->
                                </div>
                            </div>
                            <div class="col-lg-3  col-md-6 mb-5 mb-lg-6">
                                <div class="post_wrap">
                                    <div class="wrap wrap2">
                                        <div class="icon-holder">
                                            <img src="{{url('public/assets/images/secure-payment-_2_ 1.webp')}}" alt="NEVER BEATEN ON PRICE" style="width: 96px; height: 75.73px;">
                                        </div>
                                        <div class="text-holder">
                                            <h3 class="h3tag3">Never Beaten on Price</h3>
                                            <p class="text-holder">We guarantee unbeatable prices on our top-notch airport parking services, allowing you to get state-of-the-art car park security at the lowest possible price.</p>
                                        </div>
                                    </div>
                                <!--<a href="#" class="view-more"><span style="border-top:1px solid #31124b">VIEW MORE</span></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

<section class="sectt">
    <div class="container compare-con">
        <div class="row row-compare">
            <div class="col-lg-6">
                 <h2 class="comparetag">COMPARE <span style="color:#F79F02">AIRPORT</span> PARKING</h2>
                 <p class="compare-p">We assist you in locating the best parking spot for your car. Leverage our reliable airport parking comparison to discover the most favorable parking options. With access to hundreds of car parks at all major airports across the UK, we find you the top deals. We sell secure car parks, offering state-of-the-art security features, all at budget-friendly prices.</p>
            </div>
            <div class="col-lg-6 f-l">
                <img src="{{url('public/assets/images/Rectangle 782.webp')}}" alt="Rectangle 782" class="compare-img" loading="lazy">
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container mb-4">
        <div class="row card-row">
            <div class="col-lg-4 mb-2">
                <div class="card card-cor">
                  <div class="card-body">
                    
                    <div class="text-center">
                        <img src="public/assets/images/customer-loyalty-_1_ 1.webp" class="img-circle" style="width:70px;height:70px;" alt="customer-loyalty-_1_ 1" loading="lazy">
                    </div>
                    <h4 class="card-h4 text-center">Meet &amp; Greet</h4>
                    <p class="card-text card-text1">It is the fastest and most convenient solution for parking your car. Just drive to the terminal, meet the driver, grab your luggage, and head towards the plane. On return, call the driver; he will be waiting with your car at the terminal.</p>
                    
                  </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-2">
                <div class="card card-cor">
                  <div class="card-body">
                    
                    <div class="text-center">
                    <img src="public/assets/images/car-parking-_1_ 1.webp" class="img-circle" style="width:66.98px;height:68.31px;" alt="car-parking-_1_ 1" loading="lazy">
                    </div>
                    <h4 class="card-h4 text-center">Park &amp; Ride</h4>
                    <p class="card-text card-text1">Park & Ride is the most efficient parking choice. With a short 5 to 10-minute shuttle transfer, reach the airport terminal from the secure parking facility. Park and Ride offer state-of-the-art security with effective customer service.</p>
                    
                  </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-2">
                <div class="card card-cor">
                  <div class="card-body">
                    
                    <div class="text-center">
                    <img src="public/assets/images/Group.webp" class="img-circle" style="width:70px;height:69.97px;" alt="Group" loading="lazy">
                    </div>
                    <h4 class="card-h4 text-center">On-Site</h4>
                    <p class="card-text card-text1">On-Site is the parking nearest the airport, usually within the premises. On-site features long-stay car parking, involving free shuttle service. It also features short-stay parking, generally at walking distance from the terminal. </p>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="tipsh2"><span style="color:#F79F02">Top Tips </span>By Experts!</h2>
                @include('frontend.top-tips')
            </div>
        </div>
    </div>
</section>


<div class="offers">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2 class="tipsh2">WE ARE OPERATING AT THE <span style="color:#F79F02">FOLLOWING AIRPORTS</span></h2>
                <!--<h2 class="simple-steps" style="color:#31124b">{{$site_settings_main['homepage_airport_heading']}}</h2>-->
            </div>
        </div>
        <div class="row offers_items" style="font-family: 'Open Sans', sans-serif;">
            @php $airports=app\airport::where('status','yes')->orderBy('priority','asc')->get();
            $price = 28;
            @endphp
            @foreach($airports as $airport)

            @php
            if ( preg_match('/\s/',$airport->name) ){
            $name = str_replace(" ", "-", strtolower($airport->name));
            } else {
            $name = trim(strtolower($airport->name));
            }
            $url = str_replace(" ", "-", $name);
            $url = $url."-".'airport-parking';
            @endphp
            <div class="col-lg-4 col-md-6 offers_col">
                <div class="offers_item div" style="box-shadow: 1px 1px 20px 1px #90809e;">
                    <div class="row row-a">
                        <div class="col-lg-12" style="">
                            <div class="offers_image_container" style="height: 200px;">
                                <!-- Image by https://unsplash.com/@kensuarez -->
                                <img class="offers_image_background" src="{{ asset("storage/app/".$airport->profile_image) }}" style="background-repeat: no-repeat;background-size: cover;border-top-left-radius: 24px;border-top-right-radius: 24px;" loading="lazy">
                                
                                <!--<img class="offers_image_background" src="{{ asset("storage/app/".$airport->profile_image) }}" loading="lazy" alt="{{ $airport->name }}">-->
                                <!--<div class="offer_name">-->
                                <!--    <a href="{{ route("page",["slug"=>$url]) }}">{{ $airport->name }}</a>-->
                                <!--</div>-->
                                </div>
                                </div>
                        <div class="col-lg-12">
                            <div class="offers_content">
                                <div class="row" style="padding: 12px;">
                                    <div class="col-sm-6" >
                                        <div class="airport-h">
                                            <a href="{{ route("page",["slug"=>$url]) }}" style="color:#000000;">{{ $airport->name }}</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" style="    text-align: right;">
                                        <div class="offers_price"> <span>Starting from</span></div>
                                        <div class="offers_price1"><span>£ @php echo(rand(25,30)); @endphp</span></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row" style="padding: 12px;">
                                    <div class="col-sm-6" >
                                         <div >
                                           <i class="fa fa-map-marker" aria-hidden="true" style="display: inline;"></i> <p style="display: inline;">{{ $airport->name }}</p>
                                        </div>
                                        <div class="rating_r rating_r_4 offers_rating">
                                            <span class="fa fa-star checked" ></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star unchecked"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" style="    text-align: right;">
                                       <div class="offers_link"><a href="{{ route("page",["slug"=>$url]) }}">read more</a></div>
                                    </div>
                                </div>
                                
                                @php $companies = DB::table('companies')->where('airport_id',$airport->id)->get();
                                @endphp

                                {{--<p class="offers_text"> </p>
                                     <div class="offers_icons">
                                        <ul class="offers_icons_list">
                                            <li class="offers_icons_item"><img style="height: 27px" src="{{url('theme/images/post.png')}}"
                                alt=""></li>
                                <li class="offers_icons_item"><img style="height: 27px"
                                        src="{{url('theme/images/compass.png')}}" alt=""></li>
                                <li class="offers_icons_item"><img style="height: 27px"
                                        src="{{url('theme/images/bicycle.png')}}" alt=""></li>
                                <li class="offers_icons_item"><img style="height: 27px"
                                        src="{{url('theme/images/sailboat.png')}}" alt=""></li>
                                </ul>
                            </div> --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $price = $price+2; @endphp
        @endforeach
    </div>
    <div class="text-center">
         <a href="#" id="load" class="btn" style="background: #F79F02;padding-left: 22px;padding-right: 22px;padding-top: 9px;padding-bottom: 9px;color: black;font-size: 20px;font-weight: 500;">Load More</a>
    </div>
</div>
</div>

@include('frontend.slider-main')
@include('layouts.footer')

<script>
//display datepicker on top side if page is not scrolled down
	function getVisible() {    
    var $el = $('#home_search_form'),
    scrollTop = $(this).scrollTop();
	var top_height =  $(window).height() - ( $('#home_search_form').offset().top + $('#home_search_form').height() );
    $('#notification').text(top_height-scrollTop);
	if((top_height-scrollTop)>(-300))
	{
		$('div.cal').addClass('calendor_top');
	}
	else
	{
		$('div.cal').removeClass('calendor_top');
	}

}
</script>

<script>
    $(function(){
    $(".div").slice(0, 6).show(); // select the first ten
    $("#load").click(function(e){ // click event for load more
        e.preventDefault();
        $(".div:hidden").slice(0, 15).show(); // select next 10 hidden divs and show them
       
    });
});
</script>

