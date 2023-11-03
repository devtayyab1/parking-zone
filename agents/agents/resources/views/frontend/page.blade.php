@extends('layouts.main')

@section("title",$page->meta_title)
@section("meta_keyword",$page->meta_keyword )
@section("meta_description",$page->meta_description)
@section('content')

    <div class="home-container home-background">

        @include("frontend.header")

        @include("frontend.search_new_bar")



    </div><!-- end home-container -->

    <section class="section-padding" >
        <div class="row">

            <ul id="room-list" class="list-unstyled">
                <li id="room-list-1">


                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="h1-inner-section">{{ ucwords($airports_Detail->name) }} Airport Information</h2>


                                {!! $airports_Detail->description !!}

    <!--                            <iframe-->
    <!--                                    class="hidden-sm hidden-xs col-md-12"-->
    <!--                                    height="450"-->
    <!--                                    frameborder="0" style="border:0"-->
    <!--                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAnsyYF47DRTiHesG4yNB_eGzszKSpynfY-->
    <!--&q={{ $airports_Detail->address }}+{{ $airports_Detail->city }}+{{ $airports_Detail->post_code }}">-->
    <!--                            </iframe>-->
                             



                            </div>

                        </div>
                        @if(count($all_records_md)>0)
                        <div class="row">

                            <div class="col-xs-12"><br>
                                <h2 class="h1-inner-section text-center">{{ ucwords($airports_Detail->name) }} Airport Meet &amp; Greet
                                    Airport Parking</h2>
                                <p class="text-center">
                                    {!!  $page->meet_and_greet !!}
                                </p>
                            </div>


                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="th_class">Car Park</th>
                                                <th class="th_class hidden-sm hidden-xs">
                                                    <div class="table-sort">
                                                        <div class="table-sort-text">Customer Rating</div>
                                                    </div>
                                                </th>
                                                <th class="th_class">Transfer Time</th>
                                                <th class="th_class hidden-sm hidden-xs">Awards</th>
                                                <th class="th_class">
                                                    <div class="table-sort">
                                                        <div class="table-sort-text">
                                                            Price
                                                            <small> (per week)</small>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($all_records_md as $company)

                                                <tr class="gtmSiteItem own-product-row"
                                                    @if($company["price"]=='0.00') style="display: none" @endif >
                                                    <td class="car-park"
                                                        style="vertical-align: middle;text-align: center;">
                                                        {{ $company['name'] }}

                                                    </td>
                                                    <td class="fpp-customer-reviews hidden-sm hidden-xs"
                                                        style="vertical-align: middle;text-align: center;">
                                                        <div class="reevoo-badge with-background block-mobile ">

                                                            @php
                                                                $modules = \App\reviews::where("type_id",$company["companyID"])->where("status","Yes");
                                                                $avg = $modules->avg("rating");
                                                                $count_reviews = $modules->count("rating");


                                                                $avgRating =round($avg,2) * 2;
                                                                $fiverating =  $avgRating / 2;

                                                            @endphp

                                                            @if($avgRating>0)
                                                                <div class="ape-badge">
                                                                    <div class="score">
                                                                        <div class="score">{{ $avgRating }}</div>
                                                                        <div class="score-text"></div>
                                                                    </div>
                                                                    <div class="extra-info">
                                                                        <div class="score-logo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td class="fpp-airport-distance"
                                                        style="vertical-align: middle;text-align: center;">
										<span style="font-size: 13px;" class="dist-text">
										<br>
											Chauffeur will Pick Car ON Airport
									</span></td>
                                                    <td class="fpp-award hidden-sm hidden-xs"
                                                        style="vertical-align: middle;text-align: center;">


                                                        @php
                                                            $arrangeAwardList=[];
                                                            $awards = \App\companies_assign_awards::all()->where("cid",$company["companyID"]);
                                                            foreach($awards as $award){

                                                                $arrangeAwardList[] = $award;
                                                            }

                                                        @endphp
                                                        @if(count($arrangeAwardList)>0)
                                                            <img class="awards-img"
                                                                 src="{{ asset("storage/app/".$arrangeAwardList[0]->award->image)  }}">
                                                        @endif


                                                    </td>
                                                    <td class="product-price"
                                                        style="vertical-align: middle;text-align: center;">
                                                        <div class="price">
											<span style="cursor:pointer;" class="target_book value">
											£{{ $company["price"] }}
                                            <!--<span class="glyphicon btn-glyphicon glyphicon-info-sign img-circle" style="font-size: 17px;position: relative;top: -22px;;"></span>-->
											</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                        @endif
                        @if(count($all_records_pd)>0)
                        <div class="row">

                            <div class="col-xs-12"><br>
                                <h2 class="h1-inner-section text-center">{{ ucwords($airports_Detail->name) }} Airport Park & Ride Parking</h2>
                                <p class="text-center">
                                    {!!  $page->park_and_ride !!}
                                </p>
                            </div>


                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="th_class">Car Park</th>
                                                <th class="th_class hidden-sm hidden-xs">
                                                    <div class="table-sort">
                                                        <div class="table-sort-text">Customer Rating</div>
                                                    </div>
                                                </th>
                                                <th class="th_class">Transfer Time</th>
                                                <th class="th_class hidden-sm hidden-xs">Awards</th>
                                                <th class="th_class">
                                                    <div class="table-sort">
                                                        <div class="table-sort-text">
                                                            Price
                                                            <small> (per week)</small>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($all_records_pd as $company)

                                                <tr class="gtmSiteItem own-product-row"
                                                    @if($company["price"]=='0.00') style="display: none" @endif >
                                                    <td class="car-park"
                                                        style="vertical-align: middle;text-align: center;">
                                                        {{ $company['name'] }}

                                                    </td>
                                                    <td class="fpp-customer-reviews hidden-sm hidden-xs"
                                                        style="vertical-align: middle;text-align: center;">
                                                        <div class="reevoo-badge with-background block-mobile ">

                                                            @php
                                                                $modules = \App\reviews::where("type_id",$company["companyID"])->where("status","Yes");
                                                                $avg = $modules->avg("rating");
                                                                $count_reviews = $modules->count("rating");


                                                                $avgRating =round($avg,2) * 2;
                                                                $fiverating =  $avgRating / 2;

                                                            @endphp

                                                            @if($avgRating>0)
                                                                <div class="ape-badge">
                                                                    <div class="score">
                                                                        <div class="score">{{ $avgRating }}</div>
                                                                        <div class="score-text"></div>
                                                                    </div>
                                                                    <div class="extra-info">
                                                                        <div class="score-logo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td class="fpp-airport-distance"
                                                        style="vertical-align: middle;text-align: center;">
										<span style="font-size: 13px;" class="dist-text">
										<br>
											Chauffeur will Pick Car ON Airport
									</span></td>
                                                    <td class="fpp-award hidden-sm hidden-xs"
                                                        style="vertical-align: middle;text-align: center;">


                                                        @php
                                                            $arrangeAwardList=[];
                                                            $awards = \App\companies_assign_awards::all()->where("cid",$company["companyID"]);
                                                            foreach($awards as $award){

                                                                $arrangeAwardList[] = $award;
                                                            }

                                                        @endphp
                                                        @if(count($arrangeAwardList)>0)
                                                            <img class="awards-img"
                                                                 src="{{ asset("storage/app/".$arrangeAwardList[0]->award->image)  }}">
                                                        @endif


                                                    </td>
                                                    <td class="product-price"
                                                        style="vertical-align: middle;text-align: center;">
                                                        <div class="price">
											<span style="cursor:pointer;" class="target_book value">
											£{{ $company["price"] }}
                                            <!--<span class="glyphicon btn-glyphicon glyphicon-info-sign img-circle" style="font-size: 17px;position: relative;top: -22px;;"></span>-->
											</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    @endif

                    </div>

                    @php
                        $txt_about = "Here at Parking Zone Limited, we only prefer those parking fields for our clients which satisfy our rigorous security standards. We deliver three types of cool parking services at the reasonable rates of £4 per day or £28 per week. Our goal is to avail you what is soundest. Below is the list of our parking services: .
";
                       $txt_mg = "Save money and enjoy freedom vibes! Park your car at our protected parking lot yourself. You do not need to entrust your car keys, anyone, at all. Your car will be watched over well till your arrival..";
                       $txt_pr = "Simple, easy and comfortable! Just pre-book the offer and reach the terminal in tempo. The rest of the work is ours! You will meet our chauffeur who will park your car at our secure and monitored parking area.";
                       $txt_airport = "Feel uncaged! For the parking fields closer to the terminal, we do not restrict our customers for only two services. Use our On-Airport service by parking your car at our safe parking lot. Reach the terminal by walking. Pre-book now and avail 50% discount now! !";

                    @endphp

                    <div style="border-bottom:5px solid #fff" class="inner-section">
                        <div class="container text-center">
                            <section class="section-title text-center">
                                <h2 class="text-center">Our Alluring  Parking Services</h2>
                                <p class="text-center"> {!!  $page->alluring !!}</p>
                            <section id="services" class="section section-pd" style="padding: 10px 0 0 0">
        <div class="sb-serc col-md-4">
            <h4>Meet &amp; Greet</h4>
            <img src="../assets/images/meet.jpg" class="img-circle" style="width:80px;height:80px" alt="logo">
            <p>{!!  $page->alluring_meetandgreet !!} </p>
         
        </div>
        <div class="sb-serc col-md-4">
            <h4>Park &amp; Ride</h4>
            <img src="../assets/images/pandr.png" class="img-circle" style="width:80px;height:80px" alt="logo">
            <p>{!!  $page->alluring_parkandride !!}</p>
         
        </div>
        <div class="sb-serc col-md-4">

                <h4>On Airport</h4>
               <img src="../assets/images/onairport.jpg" class="img-circle" style="width:80px;height:80px" alt="logo">
            <p>{!!  $page->alluring_onairport !!}</p>
             

        </div>
      
<div class="clearfix"></div>
    </section>
                            </section>
                        </div>
                    </div>


                </li>
                <!-- end list-item -->


            </ul>


            <!-- end columns -->
        </div>

    </section>


    <section class="top-offer ">
        <div class="container padding0 hidden-xs hidden-sm">
            <div class="col-md-8 ">
                <div class="section-title text-left   passenger-detail">
                    <h3 style="    width: 102%;
    margin-left: -12px;" class="margin10left text-center">Best Available {{ $page->page_title }} Deals</h3>
                    <div class="margin10left ap_page_content text-left ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-menu">
                                <div class="list-group">


                                    <ul class="nav nav-tabs" id="menu-tabs">
                                        <li class="active col-lg-3 col-md-3 col-sm-6 col-xs-6" id="liofairports" ><a data-toggle="tab" aria-expanded="false" href="#parking"
                                                        class="list-group-item text-center" id="rounded" >
                                                <h4 class="fa  fa-plane"></h4><br>Airport Paking
                                            </a></li>
                                        <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="liofairports" ><a data-toggle="tab" aria-expanded="false" href="#overview"
                                                        class="list-group-item text-center" id="rounded">
                                                <h4 class="fa fa-road"></h4><br>Airport Overview
                                            </a></li>
                                        <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="liofairports"><a data-toggle="tab" aria-expanded="false" href="#fac"
                                                              class="list-group-item text-center" id="rounded">
                                                <h4 class="fa  fa-home"></h4><br>Airport facilities
                                            </a></li>

                                        <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="liofairports"><a data-toggle="tab" aria-expanded="false" href="#top_things"
                                                        class="list-group-item text-center" id="rounded">
                                                <h4 class="fa fa-child"></h4><br>Top things to do
                                                at </a></li>
                                        {{--<li class=""><a data-toggle="tab" aria-expanded="false" href="#map"--}}
                                        {{--class="list-group-item text-center">--}}
                                        {{--<h4><i class="fa fa-map-marker" aria-hidden="true"></i></h4>Map--}}
                                        {{--</a></li>--}}
                                    </ul>


                                </div>
                            </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container" style="    border-top-right-radius: 5px;">






                        
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-content ">
                                {!! $page->content !!}                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title passenger-detail">
                    <h3 class="text-center ">Other Airport Options</h3>
                    <div class="col-xs-12 text-center">
                        @php $i=0; @endphp
                        @foreach($airports as $airport)
                            @if($page->typeid!=$airport->id)
                                <a class="other-airports"
                                   href="{{ route("page",["slug"=>$airport->name."-airport-parking"]) }}">
                                    <img class="img-responsive" style="width: 100%" alt="{{  $airport->name }} airport"
                                         src="{{ asset("storage/app/".$airport->profile_image) }}">
                                    <strong> {{  $airport->name }} airport </strong>
                                </a>
                                @if($i>4)  @break @endif

                                @php $i++; @endphp
                            @endif



                        @endforeach


                    </div>
                </div>

            </div>
        </div>

        <div class="clearfix"></div>




    </section>
    <!-- end innerpage-wrapper -->


@endsection
@section("footer-script")
    <script>
        $(function () {
            $("#dropdatepicker12").datepicker({
                minDate: 0,
                dateFormat: 'dd/mm/yy',
                onSelect: function (dateText, inst) {

                    var date2 = $('#dropdatepicker12').datepicker('getDate', '+1d');
                    date2.setDate(date2.getDate() + 7);
                    $('#pickdatepicker12').datepicker('setDate', date2);
                }

            });
            $('#pickdatepicker12').datepicker(
                {
                    defaultDate: "+1w",
                    dateFormat: 'dd/mm/yy',
                    beforeShow: function () {
                        $(this).datepicker('option', 'minDate', $('#dropdatepicker12').val());
                        if ($('#dropdatepicker12').val() === '') $(this).datepicker('option', 'minDate', 0);
                    }
                });

            $("a.list-group-item").on('click', function () {
                $('li.active').removeClass('fade');
                $('li.active').removeClass('in');
                $('li.active').removeClass('active');
                // $(this).closest("li.active").removeClass('active');
                $(this).closest("li").addClass('active');
                $(this).closest("li").addClass('fade');
                $(this).closest("li").addClass('in');


                $(".tab-pane").hide();
                $($(this).attr("href")).show();
            });

        });
    </script>


@endsection
