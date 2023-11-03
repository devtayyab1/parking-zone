@include('layouts.header')
@include('layouts.nav')

@php
$site_settings_main=[];
$settingsAll = App\settings::all();
foreach ($settingsAll as $setting) {
$site_settings_main[$setting->field_name] = $setting->field_value;
}

$sliders = unserialize($site_settings_main['sliders']);

@endphp

<div class="home">
    <div class="home_slider_container">
        <div class="owl-carousel owl-theme home_slider">
            @foreach($sliders as $slider)
            <div class="owl-item home_slider_item">
                <div class="home_slider_background" style="background-image:url('{{$slider}}"></div>
                <div class="home_slider_content1">
                    <div class="home_slider_content_inner">
                        <p class="heading-1"><b>Most reputable services provide</b></p>
                        <p class="heading-2"><b> Along with complete customer insurance</b></p>
                        <!-- <p class="heading-3"> <b>Exclusive Offers </b></p> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @include('layouts.search_form')
    </div>
</div>

<style type="text/css">
.for-offres-intro .offers_link {margin-top: 0px;}
.for-offres-intro div.cal{overflow: hidden !important;}
.for-offres-intro .offers_item{padding: 5%;}
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
.BOOKING-PROCEE{text-align: center!important;color: #333;font-family: 'Open Sans', sans-serif;text-shadow: rgb(0 0 0 / 1%) 0 0 1px;font-size: 36px;margin-bottom: 0.5rem;font-weight: 500;margin-top: 0px;}
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
</style>
<div class="for-offres-intro">
<div class="offers">
        <div class="container">
            <div class="row">
    <div class="wrapper gray-wrapper">
    <div class="" style="    padding-bottom: 47px; padding-bottom: 20px;">
      <h1 class="section-title text-center BOOKING-PROCEE"><strong>{{$site_settings_main['homepage_work_heading']}}</strong></h1>
      <p class="lead text-center">You can reserve your parking slot in advance. <br class="d-none d-xl-block">
         Please follow these four simple steps to book your parking slot.</p>
      <div class="space30"></div>
      <div class="row gutter-50 gutter-md-30 process-wrapper line text-center">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> <span class="icon icon-bg bg-default mb-20"><span class="number">01</span></span>
          <h5 style="font-size: 18px;">{!! $site_settings_main["homepage_howitwork_grid1_heading"] !!}</h5>
          <p> {!! $site_settings_main["homepage_howitwork_grid1_descp"]  !!}</p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> <span class="icon icon-bg bg-default mb-20"><span class="number">02</span></span>
          <h5 style="font-size: 18px;">{!! $site_settings_main["homepage_howitwork_grid2_heading"] !!}</h5>
          <p> {!! $site_settings_main["homepage_howitwork_grid2_descp"]  !!}</p>
        </div>
        <div class="space20 d-md-none clearfix"></div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> <span class="icon icon-bg bg-default mb-20"><span class="number">03</span></span>
          <h5 style="font-size: 18px;">{!! $site_settings_main["homepage_howitwork_grid3_heading"] !!}</h5>
          <p> {!! $site_settings_main["homepage_howitwork_grid3_descp"]  !!}</p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> <span class="icon icon-bg bg-default mb-20"><span class="number">04</span></span>
          <h5 style="font-size: 18px;">{!!  $site_settings_main["homepage_howitwork_grid4_heading"] !!}</h5>
          <p> {!! $site_settings_main["homepage_howitwork_grid4_descp"]  !!}</p>
        </div>
      </div>
      <div class="space30"></div>
      <br>
      <p class="lead text-center">All travel industry services are available on our platform at discounted rates.<br class="d-none d-xl-block">Providing quality services is our benchmark.</p>
    </div>
  </div>
</div>
</div>
</div>

<div class="intro">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2 class="simple-steps">Parkingzone Offers you</h2>
            </div>
        </div>
        {{-- <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="intro_text text-center">
                        <p></p>
                    </div>
                </div>
            </div> --}}
        <div class="row intro_items">
            <div class="col-lg-3 col-md-6 intro_col">
                <div class="intro_item">
                    <div class="intro_item_content ">
                        <div class="box">
                            <center><i class="fa fa-search"></i>Quality Control</center>
                        </div>
                        <div class="intro_center text-center">
                            <p style="text-align:justify; color: #fff;"> Our customers are our valuable assets and we believe in providing them with the best quality in the market for their satisfaction and ease. For this, we ensure that all of our parking services providing contractors/companies must fulfil our quality check lists. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 intro_col">
                <div class="intro_item">
                    <div class="intro_item_content ">
                        <div class="box">
                            <center><i class=" fa fa-hand-pointer-o"></i>For our loyal customers</center>
                        </div>
                        <div class="intro_center text-center">
                            <p style="text-align:justify; color: #fff;">If you are a regular and loyal customer of parkingzone, then you are privileged to receive special discounts on your upcoming parking bookings. All you have to do is to provide your reference number or email to receive your special discount deals.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 intro_col">
                <div class="intro_item">
                    <div class="intro_item_content ">
                        <div class="box">
                            <center><i class="sc_services_item_icon fa fa-money"></i>Secure user-friendly site</center>
                        </div>
                        <div class="intro_center text-center">
                            <p style="text-align: justify; color: #fff;">Book a car parking was never that much easy before parkingzone. On our website you can easily book airport car parking slots of your choice within few minutes by doing secure online payments.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 intro_col">
                <div class="intro_item">
                    <div class="intro_item_content ">
                        <div class="box">
                            <center> <i class="sc_services_item_icon fa fa-thumbs-o-up"></i>Our customer support</center>
                        </div>
                        <div class="intro_center text-center">
                            <p style="text-align:justify; color: #fff;"> On parkingzone, you are backed with a large and quick network of customer support. In case of any query or change of booking details, you can simply contact our customer support during office hours and they will reach you in no time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="offers">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2 class="simple-steps">{{$site_settings_main['homepage_airport_heading']}}</h2>
            </div>
        </div>
        <div class="row offers_items">
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
                <div class="offers_item">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="offers_image_container" style="height: 200px;">
                                <!-- Image by https://unsplash.com/@kensuarez -->
                                <div class="offers_image_background"
                                    style="background-image:url('{{ asset("storage/app/".$airport->profile_image) }}')">
                                </div>
                                <div class="offer_name">
                                    <a href="{{ route("page",["slug"=>$url]) }}">{{ $airport->name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="offers_content">
                                <br>
                                <div class="offers_price"> <span>Price Starting From </span>£ @php echo(rand(25,30));
                                    @endphp</div>
                                <div class="rating_r rating_r_4 offers_rating">
                                    <span class="fa fa-star checked" ></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star unchecked"></span>
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
                            <div class="offers_link"><a href="{{ route("page",["slug"=>$url]) }}">read more</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $price = $price+2; @endphp
        @endforeach
    </div>
</div>
</div>
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


