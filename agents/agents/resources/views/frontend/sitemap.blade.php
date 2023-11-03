@extends('layouts.main')

@section('content')

    <div class="home-container home-background">

        @include("frontend.header")


    </div><!-- end home-container -->






    <section class="top-offer marginto73" >


        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail">
                            <h3 class="light-weight">Site Map</h3>
                            <div class="well-body">


                                <div class="inr-cnt  col-xs-12 col-sm-12 col-md-9 col-lg-9 mainsitemap" >

                                    <div class="nrm-cont  col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">

                                            <h3>&nbsp; &nbsp; Airport Parking</h3>
                                            <ul>
                                                <li><a href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick
                                                        Airport Parking</a></li>
                                                <li><a href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow
                                                        Airport Parking</a></li>
                                                <li><a href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted
                                                        Airport Parking</a></li>
                                                <li>
                                                    <a href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham
                                                        Airport Parking</a></li>
                                                <li><a href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh
                                                        Airport Parking</a></li>
                                                <li>
                                                    <a href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton
                                                        Airport Parking</a></li>
                                                <li><a href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool
                                                        Airport Parking</a></li>
                                                <li><a href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton
                                                        Airport Parking</a></li>
                                                <li>
                                                    <a href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester
                                                        Airport Parking</a></li>
                                            </ul>

                                            <h3>&nbsp; &nbsp; Serving Airports</h3>
                                            <ul>
                                                <li><a href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton
                                                        Airport</a></li>
                                                <li>
                                                    <a href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted
                                                        Airport</a></li>

                                                <li><a href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"exeter-airport-parking"]) }}">Exeter
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"bristol-airport-parking"]) }}">Bristol
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"glasgow-airport-parking"]) }}">Glassgow
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"aberdeen-airport-parking"]) }}">Aberdeen
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"newcastle-airport-parking"]) }}">Newcastle
                                                        Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"belfast-airport-parking"]) }}">Belfast
                                                        Int Airport</a></li>
                                                <li><a href="{{ route("page",["slug"=>"cardiff-airport-parking"]) }}">Cardiff
                                                        Airport</a></li>


                                                <li><a href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool
                                                        Airport</a></li>
                                                <li>
                                                    <a href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester
                                                        Airport</a></li>

                                            </ul>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                                            <h3>&nbsp; &nbsp; Other Pages</h3>
                                            <ul>


                                                <li><a href="{{ route("static_page",["page"=>"about-us"]) }}">About
                                                        Us</a></li>

                                                <li>
                                                    <a href="{{ route("static_page",["page"=>"terms-and-conditions"]) }}">Terms
                                                        & condition</a></li>
                                                <li><a href="{{ route("static_page",["page"=>"privacy-policy"]) }}">Privacy
                                                        Policy</a></li>
                                                <li><a href="{{ route("static_page",["page"=>"Site-security"]) }}">Site
                                                        Security</a></li>
                                                <li><a href="{{ route("sitemap") }}">Site Map</a></li>
                                                <li><a href="{{ route("static_page",["page"=>"affiliates"]) }}">Affiliates</a>
                                                </li>
                                                <li><a href="{{ route("static_page",["page"=>"cookies"]) }}">Cookies</a>
                                                </li>
                                                <li><a href="{{ route("airport_guide") }}">Airport Guide</a></li>
                                                <li><a href="{{ route("faqs") }}" class="dropdown-toggle">FAQ</a></li>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="hidden-xs hidden-sm col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    @include("frontend.right_searchbar")


                </div>
            </div>
        </div>


    </section>
    <!-- end innerpage-wrapper -->


@endsection

