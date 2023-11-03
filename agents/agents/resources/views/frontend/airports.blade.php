@extends('layouts.main')

@section("stylesheets")

    <link property="stylesheet" rel='stylesheet'

          href='{{ secure_asset("assets/page.css") }}' type='text/css'

          media='all'/>

@endsection

@section('content')





    <div class="home-container home-background">



        @include("frontend.header")

        @include("frontend.search_new_bar")



    </div><!-- end home-container -->





    <!--================ ROOMS ==============-->

    <section id="rooms" class="section-padding" style=" padding-top:130px">

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="page-heading">

                        <h2>Popular Airports</h2>

                   

                    </div><!-- end page-heading -->



                    <div class="owl-carousel owl-theme" style="display: block">





                        @foreach($airports as $airport)

                            @php

                                if ( preg_match('/\s/',$airport->name) ){

                                    $name = str_replace(" ", "-", strtolower($airport->name));

                                } else {

                                    $name = trim(strtolower($airport->name))."-";

                                }

                            $url = $name."airport-parking";

                            @endphp



                            <div class="grid col-md-3" style="min-height: 228px;">

                                <div class="room-block">

                                    <div class="room-img">

                                        <img style="height: 154px;" src="{{ config('app.image_url')."storage/app/".$airport->profile_image }}" class="img-reponsive" alt="room-image"/>

                                        <div class="room-title">

                                            <a href="{{ route("page",["slug"=>$url]) }}"><h3 style="color: #ffffff;">{{ $airport->name }}</h3></a>

                                            <div class="rating">

                                                <span><i class="fa fa-star"></i></span>

                                                <span><i class="fa fa-star"></i></span>

                                                <span><i class="fa fa-star"></i></span>

                                                <span><i class="fa fa-star"></i></span>

                                                <span><i class="fa fa-star-o"></i></span>

                                            </div><!-- end rating -->

                                        </div><!-- end room-title -->



                                    </div><!-- end room-img -->



                                    <div class="room-price">

                                        <ul class="list-unstyled" style="text-align: center">



                                            <a href="{{ route("page",["slug"=>$url]) }}" style="color: #ffffff;" class="btn btn-yellow">View Details</a>

                                        </ul>

                                    </div><!-- end room-price -->

                                </div><!-- end room-block -->

                            </div><!-- end grid -->

                        @endforeach





                    </div><!-- end item -->





                </div><!-- end columns -->

            </div><!-- end row -->

        </div><!-- end container -->

    </section><!-- end rooms -->



@endsection