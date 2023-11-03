@extends('layouts.main')
@section('content')



    <div class="home-container home-background">

      @include("frontend.header")


    </div><!-- end home-container -->


    <section class="section bg-grey section-pd guide-margin">
        <div class="row titlehead guide-head" >
            <h1 class="text-center">Airport Guides</h1>
        </div>

        <div class="sm-12">
            <div class="row paddingtopbottom30" >
             <p>Airports are an essential platform for travellers to board airplanes. Not only is it a complex maze of physical structure but several other factors need to be taken into account, including shuttle services, baggage clearance, airport lounges, baggage clearance and departure terminal. So what is it that you need to do to prepare yourself to check in or check out at a new airport? Following is a list of UK's major airports that we operate on and offer services like on-site parking, meet & greet and chauffeur help. Feel free to go through them and skim the information. Maybe it won't satisfy the academic curiosity rather it will serve the purpose of contributing towards general knowledge.</p>
            </div>
        </div>




    </section>
    <section id="services" class="section section-pd guide-margin-section" >
        <div class="sb-serc col-md-3">
            <h4>Airport Parking</h4>
            <img src="assets/images/black.png" alt="Airport parking" class="guide-width">
            <p>Secure, guaranteed and satisfactory. Our customers reap benefits from priority parking at
                350+ car parks on 30+ major airports across UK, while saving up to 30%.</p>
            <a href="airports" class="btn btn-submit">Learn More</a>
        </div>
        <div class="sb-serc col-md-3">
            <h4>Airport Hotels</h4>
            <img src="assets/images/hotels.png" alt="Airport hotels" class="guide-width">
            <p>Why struggle through traffic to reach airport when you can say goodbye to stress with ParkingZone
                and book an Airport hotel in two minutes. </p>
            <a  class="btn btn-submit">Comming Soon</a>
        </div>
        <div class="sb-serc col-md-3">

                <h4>Airport Lounges</h4>
                <img src="assets/images/ds.png" alt="logo" class="guide-width">
                <p>Take a break from all the stress and extensive traveling. Book a premium lounge with
                    ParkingZone in the price of an economy airport lounge. </p>
                <a  class="btn btn-submit">Comming Soon</a>

        </div>
        <div class="sb-serc col-md-3 ">

                <h4>Other Traveling Services</h4>
                <img src="assets/images/car.svg" alt="logo" class="guide-width">
                <p>Flying made easy. We offer unbeatable rates for car rentals, travel insurance, taxi
                    services, parking, airport lounges and international hotels. Try it to believe it!</p>
                <a class="btn btn-submit">Comming Soon</a>

        </div>
<div class="clearfix"></div>
    </section>

@endsection