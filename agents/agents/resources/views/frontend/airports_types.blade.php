@extends('layouts.main')
@section("stylesheets")
    <link property="stylesheet" rel='stylesheet'
          href='{{ secure_asset("assets/page.css") }}' type='text/css'
          media='all'/>
@endsection
@section('content')
    <div class="home-container home-background">

        @include("frontend.header")


    </div><!-- end home-container -->


    <section class="section bg-grey section-pd guide-margin">
        <div class="row titlehead guide-head">
            <h1 class="text-center">Types Of Airports</h1>
        </div>

        <div class="sm-12">
            <div class="row paddingtopbottom30">
                <p>We have some strict security policies and we only choose those parking lots which fulfill our security criteria. The airport parking rates we are providing starts from £4 per day and the rates are a lot less if you book the parking slot for a whole week. You can find the following car parking options from our website: 
                    .</p>
            </div>
        </div>


    </section>
    <section id="services" class="section section-pd guide-margin-section">
        <div class="sb-serc col-md-4">
            <h4>Meet & Greet</h4>
            <img src="assets/images/meet.jpg" class="img-circle airporttype_img" alt="Meet & Greet">
            <p>Meet and Greet is one of the easiest way to find the parking lot from the airport. All you have to do is to pre-book this package and reach the airport. The rest of the work is ours! The driver will receive you from the terminal and he will drive your car at the secure and monitored parking area. </p>

        </div>
        <div class="sb-serc col-md-4">
            <h4>Park & Ride</h4>
            <img src="assets/images/pandr.png" class="img-circle airporttype_img" alt="Park & Ride">
            <p>If you do not want to drive your car by a chauffeur, you can drive your car yourself at the parking place and take the car keys with you. You can reach the terminal on the free shuttle bus service by the airport within 10 to 15 minutes. 
                <br>
                <br></p>

        </div>
        <div class="sb-serc col-md-4">

            <h4>On Airport</h4>
            <img src="assets/images/onairport.jpg" class="img-circle airporttype_img" alt="On Airport">
            <p>Our customers are not restricted to use only above two services. You can also choose On Airport service in which you can park your vehicle at a parking lot nearest to the terminal and reach the terminal by walking. Avail this offer and get up to 50% discount now!

                <br></p>


        </div>

        <div class="clearfix"></div>
    </section>

@endsection