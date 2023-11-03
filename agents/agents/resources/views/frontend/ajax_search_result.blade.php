<!--=============INNERPAGE-WRAPPER ===========-->


    <div id="room-listing-blocks" class="innerpage-section-padding" style="padding-top: 10px;">
        <section id="room-listings" class="innerpage-wrapper bg" style="margin-top: -10px;">


            <div class="container" style="padding-top: 15px; width: 100% !important;background-color: #656c7d03;">

                <div class="search-bar" id="searchbar-background">


                    <form action="{{ route("searchresult") }}" method="post">
                        @csrf
                        <div class="row" id="searchbar-nav">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-5 col-lg-3-20">

                                <div class="form-group">
                                    <span><i class="fa fa-angle-down"></i></span>
                                    <select name="airport_id" class="form-control">
                                        <option selected>Airport</option>
                                        @foreach($airports as $airport)

                                            <option @if($request->input("airport_id")==$airport->id) {{ "selected" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- end columns -->


                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-5 col-lg-3-20">

                                <div class="form-group">
                                    <input type="text" autocomplete="off"
                                           value="{{ $request->input("dropoffdate") }}" name="dropoffdate"
                                           class="form-control dpd1" placeholder="Dropoff Date"
                                           required/>
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div><!-- end columns -->


                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2 padding-5 col-lg-2-10">

                                <div class="form-group">


                                    <span><i class="fa fa-clock-o"></i></span>
                                    @php
                                        $dropdown_timer = [];
                                       for ($i = 0; $i <= 23; $i++) {
                                           for ($j = 0; $j <= 45; $j += 15) {
                                               $dropdown_timer[str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT);
                                           }
                                       }
                                    //dd($request->input('dropoftime'));
                                    @endphp
                                    {{ Form::select('dropoftime',$dropdown_timer,$request->input('dropoftime'),["class"=>"form-control","id"=>"dropoftime"]) }}
                                </div>
                            </div><!-- end columns -->


                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-5 col-lg-2-10">

                                <div class="form-group">
                                    <input type="text" autocomplete="off"
                                           value='{{ $request->input("departure_date") }}' name="departure_date"
                                           class="form-control dpd2" placeholder="Departure Date"
                                           required/>
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div><!-- end columns -->


                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2 padding-5 col-lg-2-10">

                                <div class="form-group">
                                    <span><i class="fa fa-clock-o"></i></span>


                                    {{ Form::select('pickup_time',$dropdown_timer,$request->input('pickup_time'),["class"=>"form-control","id"=>"pickup_time"]) }}
                                </div>
                            </div><!-- end columns -->

                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-5 col-lg-2-10">
                                @php if($request->input("promo2")!=""){ $p2=$request->input("promo2"); }else { $p2=""; } @endphp
                                <div class="form-group">
                                    <input type="text" placeholder="Promo Code"
                                           value=' @if($p2!="") {{ $p2 }} @endif  @if($request->input("promo")) {{ $request->input("promo") }} @endif '

                                           name="promo2"
                                           class="form-control"/>
                                    @if ($promo_error_message!="")

                                        <div class="error error-massage" style="color:red">
                                            {{ $promo_error_message }}
                                        </div>
                                    @endif

                                </div>

                            </div><!-- end columns -->

                            <!-- end columns -->
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-5 col-lg-2-10">

                            <button class="btn btn-theme-dark" type="submit">
                                Search
                            </button>
                        </div>

                </div><!-- end row -->
                </form>


                <br/>
                <div class="col-md-3 left-side hidden-xs hidden-sm" id="detailbooking">
                    <div class="heading">
                        <h3>Your Quote Detail</h3>
                    </div>
                    <div class="parking-filter-option">

                        <ul class="product-summary" style="padding: 15px;font-size: 15px;">
                            <li style="    list-style: none; border-bottom: 1px dotted #a2a2a2;margin-bottom: 5px;padding-bottom: 5px;">
                                Location: <span class="pull-right"><b>{{ ucwords($airport_detail->name) }} Airport</b></span></li>
                            <li style="    list-style: none; border-bottom: 1px dotted #a2a2a2;margin-bottom: 5px;padding-bottom: 5px;">
                                Drop-Off Date: <span class="pull-right"><b>{{ date("d-m-Y",strtotime($request->input("dropoffdate"))) }}</b></span>
                            </li>
                            <li style="    list-style: none; border-bottom: 1px dotted #a2a2a2;margin-bottom: 5px;padding-bottom: 5px;">
                                Drop-Off Time: <span class="pull-right"><b>{{ $request->input("dropoftime") }}</b></span></li>
                            <li style="    list-style: none; border-bottom: 1px dotted #a2a2a2;margin-bottom: 5px;padding-bottom: 5px;">
                                Pick-Up Date: <span class="pull-right"><b><span
                                                class="text-right">{{ date("d-m-Y",strtotime($request->input("departure_date"))) }}</span></b></span></li>
                            <li style="    list-style: none; border-bottom: 1px dotted #a2a2a2;margin-bottom: 5px;padding-bottom: 5px;">
                                Pick-Up Time: <span class="pull-right"><b>{{ $request->input("pickup_time") }}</b></span></li>
                            <li style="list-style: none; margin-bottom: 5px;padding-bottom: 5px;">Promo Code: 
                                <span class="pull-right"><b>@if($request->input('promo')!="") {{  $request->input('promo') }} @elseif($request->input('promo2')!="") {{ $request->input('promo2') }} @else None @endif</b></span>
                            </li>
                        </ul>
                        <hr>
                        <div class="side-bar-heading" style="margin: 0 auto;">
                            <div class="price-match text-center">
                                <img src="our_promise.jpg" style="border-radius: 5px">
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12 col-xl-9" id="divhole">

                    @forelse($companies as $company)
                        <div class="row">

                            <ul id="room-list" class="list-unstyled">

                                <div class="row " id="Resultofsearchbar">

                                    @php
                                        $discount_amount=0;
                                            $facilities = \App\Company::find($company->companyID)->facilities;

                                           if ($no_of_days > 30) {
                                            $after30Days = $company->after_30_days;
                                            $booking_price = number_format($company->price, 2, '.', '');
                                            $booking_price = $booking_price + $after30Days * ($no_of_days - 30);
                                            $booking_price = number_format($booking_price, 2, '.', '');
                                            } else {
                                                $booking_price = number_format($company->price, 2, '.', '');
                                            }
                                             $parking_total =$booking_price;

                                             //dd($promo);
                                            if ($promo != '') {
                                             $dis = new \App\discounts();

                                            $promo_verify = $dis->varifyPromoCode($promo);

                                                if($promo_verify=="Verify"){

                                                    $discount_amount = $dis->getPromoDiscount($promo, $booking_price, $bookingfor,$company->companyID);
                                                    //$discount_amount=1;
                                                    //echo $discount_amount."==".$booking_price;
                                                   if($booking_price>$discount_amount){
                                                        $booking_price = $booking_price - $discount_amount;
                                                    }
                                                    //echo $booking_price;
                                                }

                                            }


                                    @endphp


                                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 bg-grey room-text">
                                        <div class="row border-bottom">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 room-info">
                                                <h1 class="room-name">{{ $company->name }}</h1>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <ul class="list_type">
                                                        <li><span></span><i class="fa fa-map-marker"
                                                                            aria-hidden="true"></i>{{ $company->parking_type }}
                                                        </li>
                                                        <li><span></span><i class="fa fa-blind"
                                                                            aria-hidden="true"></i>Walking
                                                            time {{ $company->travel_time }}</li>
                                                            @if($company->cancelable=="Yes")
                                                               <li><span></span><i class="fa fa-check" aria-hidden="true"></i>Cancellation Cover Available
                                                          
                            </li> @endif

                                                    </ul>
                                                </div>
                                            </div>

                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <figure class="logo-figure">
                                                    @php
                                                        $arrangeAwardList=[];
                                                        $awards = \App\companies_assign_awards::all()->where("cid",$company->companyID);
                                                        foreach($awards as $award){

                                                            $arrangeAwardList[] = $award;
                                                        }

                                                    @endphp
                                                  
                                                      <img style="height: 160px;" class="img-responsive center-block"
                                                             src="{{ config('app.image_url')."storage/app/".$company->logo  }}">
                                                  
                                                </figure>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                <div class="room-info">
                                                    <ul class="selected-room-features list-unstyled">
                                                        @foreach($facilities  as $facility)

                                                            <li class="col-md-12 col-xs-12 cp;-sm-12">
                                                                        
                                                               <p>  <i
                                                                                    class="fa fa-thumbs-up"></i> &nbsp; {{ $facility->description }}</p>
                                                            </li> 
                                                        @endforeach

                                                    </ul>
                                                </div>
                                                <!-- end room-info -->
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 room-info hidden-sm hidden-xs"
                                                 id="cctvetc">
                                                <ul class="list-inline list-unstyled room-features">
                                                    @php
                                                        $features =  explode(",",$company->special_features);

                                                    @endphp

                                                    @foreach($companies_special_features as $companies_special_feature)

                                                        @if(in_array ($companies_special_feature->name,$features))

                                                            <li><span data-toggle="tooltip" title="{{  $companies_special_feature->name }}"
                                                                      data-original-title="{{  $companies_special_feature->name }}"><i
                                                                            class="{{  $companies_special_feature->icon }}"></i></span>
                                                            </li>
                                                        @endif
                                                    @endforeach


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end columns -->
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 bg-white" id="booknow">

                                        <!-- Indicates a successful or positive action -->
                                        <div class="row destacados">

                                            <div class="box1">
                                                <h3>{{ $company->parking_type }}</h3>
                                            </div>


                                        </div>

                                        {{--<br>--}}
                                        {{--<del class="price-offer">£ 79.00</del>--}}
                                        {{--<br>--}}

                                        <center>
                                            <div class="price mar-bottom text-center">
                                                <span>£ {{ $company->price }}</span></div>


                                            <form id="bookingFrm1" method="post"
                                                  action="{{ route("addBookingForm") }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="company_id"
                                                       value="{{  $company->companyID }}">
                                                <input type="hidden" name="parking_type"
                                                       value="{{  $company->parking_type }}">
                                                <input type="hidden" name="parking_name" value="">
                                                <input type="hidden" name="aphactive" value="{{ @$company->aphactive }}">
                                                <input type="hidden" name="airport"
                                                       value="{{ $request->input("airport_id") }}">
                                                <input type="hidden" name="dropdate"
                                                       value="{{ $request->input("dropoffdate") }}">
                                                <input type="hidden" name="pickdate"
                                                       value="{{ $request->input("departure_date") }}">
                                                <input type="hidden" name="droptime"
                                                       value="{{ $request->input("dropoftime") }}">
                                                <input type="hidden" name="picktime"
                                                       value="{{ $request->input("pickup_time") }}">
                                                <input type="hidden" name="total_days"
                                                       value="{{ $no_of_days }}">
                                                <input type="hidden" name="discount_code" value="{{  $promo }}">
                                                <input type="hidden" name="discount_amount"
                                                       value="{{  $discount_amount }}">
                                                <input type="hidden" name="booking_amount"
                                                       value="{{  $booking_price }}">
                                                <input type="hidden" name="bookingfor" value="airport_parking">
                                                <input type="hidden" name="pl_id"
                                                       value="{{ @$company->pl_id }}">
                                                <input type="hidden" name="sku" value="">
                                                <input type="hidden" name="site_codename" value="">
                                                <input type="hidden" name="speed_park_active" value="">
                                                <input type="hidden" name="edin_active" value="">
                                                <input type="hidden" name="edin_search" value="">
                                                <input type="hidden" name="submitted" value="airport_parking">
                                                <input type="submit" value="Book Now"
                                                       class="btn btn-lg btn-theme-dark" id="search_button"/> <br><br>
                                            </form>


                                            <strong style="color: black; cursor: pointer" class="more-info" data-toggle="modal"
                                                    data-target="#myModal{{ $company->companyID }}">More Info <i
                                                        class="fa fa-plus orange" aria-hidden="true"></i></strong>
                                        </center>

                                        <!-- <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" id="reviewsearchresult"> -->
                                        <div class="" id="reviewsearchresult">
                                                <div class="customer-rating">
                                                    <div class="reevoo-badge">
                                                        <div class="score hidden-xs hidden-sm">

                                                            @php

                                                                //select ROUND(sum(rating)/count(*)) as totalrating,count(*) totalreviews from reviews where type_id=16
                                                        // Returns an elloquent collection

                                                        $modules = \App\reviews::where("type_id",$company->companyID)->where("status","Yes");
                                                        $avg = $modules->avg("rating");
                                                        $count_reviews = $modules->count("rating");


                                                            $avgRating =round($avg,2) * 2;
                                                            $fiverating =  $avgRating / 2;

                                                            @endphp
 
                                                    @php
                                                        $arrangeAwardList=[];
                                                        $awards = \App\companies_assign_awards::all()->where("cid",$company->companyID)->take(2);
                                                        foreach($awards as $award){

                                                            $arrangeAwardList[] = $award;
                                                        }

                                                    @endphp
                                                    @if(count($arrangeAwardList)>0)
                                                  
                                                   @foreach($arrangeAwardList as $awardimg)
                                               
<!-- 
                                                          <img src="assets/images/approvedstamp.jpg" style="height: 40px;     border-radius: 19px;" alt="gatwick-approved-operator-logo" data-toggle="tooltip" title="" data-placement="top" class="icons-tooltip" data-container="body" data-original-title="Gatwick Approved Operator" aria-describedby="tooltip800087"  > -->

                                                            <img src='{{ config('app.image_url')."storage/app/".$awardimg->award->image  }}' class="col-md-6" id="awardsimage" title="{{ $awardimg->award->awardname  }}">

                                                               


@endforeach
                                                                  @endif
                                                            {{--<div class="score-text"></div>--}}
                                                        </div>
                                                        <div class="extra-info">
                                                            <div class="score-logo">
                                                                <div class="rating">


                                                                  
                                                                </div>
                                                       
                                                                <!-- end rating -->
                                                            </div>
                                                            {{--<a href="#" target="_blank">292 Reviews</a>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<strong class="pull-right more-info">More Info <i class="fa fa-plus orange" aria-hidden="true"></i></strong>-->
                                            </div>

                                    </div>
                                </div>


                        </div>

                    @empty
                    <p class="alert alert-warning">No Results Found</p>
                    @endforelse
                </div>
            </div>
            <!-- end room-list-block -->
    </div>



    <!-- end columns -->
    </div>
    <!-- end row -->
    </div>
    <!-- end container -->
    </div>
    <!-- end room-listing-blocks -->

    </li>
    <!-- end list-item -->


    </ul>

    @foreach($companies as $company )

        <!--------model start-------->

        <div id="myModal{{ $company->companyID }}" class="modal fade" role="dialog" style="margin-top:76px">
            <div class="modal-dialog" style="z-index: 9999;">
                <div class="modal-content" style="max-width: 800px;">
                    <div class="modal-header">
                        <button type="button" style="color: #B91F76;font-size: 55px;font-weight: bold; background: unset; " class="close text-right" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title hidden-xs">{{ $company->name }} <span
                                    class="modal-price">{{  $booking_price }}</span></h4>
                        <h4 class="modal-title text-center hidden-sm hidden-md hidden-lg"></h4>
                        <h4 class="modal-title text-center hidden-sm hidden-md hidden-lg">
                            <strong>{{  $booking_price }}</strong></h4>
                        <!--<span>' . $company['address'] . ' ' . $company['town'] . '</span>-->
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 left-modal-column">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="active " id="overview{{ $company->companyID }}"><a class="apply-active" href="#tab_overview{{ $company->companyID }}" data-toggle="tab">Overview</a></li>
                                    <li data-target="#arivals{{ $company->companyID }}"  id="arivals{{ $company->companyID }}">
                                        <a  class="apply-active" href="#tab_arivals{{ $company->companyID }}"
                                                             data-toggle="tab">Arrivals</a></li>
                                    <li id="return{{ $company->companyID }}"><a  class="apply-active" href="#tab_return{{ $company->companyID }}"
                                                             data-toggle="tab">Return</a></li>


                                    @if($modules)
                                        {{--<li><a class="apply-active" href="#tab_rev{{ $company->companyID }}" data-toggle="tab">Reviews</a>--}}
                                        {{--</li>--}}
                                    @endif
                                    <li id="2" class="apply-active"><a href="#tab_map{{ $company->companyID }}" data-toggle="tab">Map</a>
                                    </li>
                                    <li ><a class="apply-active" href="#tab_imp{{ $company->companyID }}" data-toggle="tab">Note</a></li>
                                    <li ><a class="apply-active" href="#tab_termcondition{{ $company->companyID }}" data-toggle="tab">Term &
                                            Conditions</a></li>


                                </ul>
                                <div class="col-md-12 tab-content"
                                     style="max-width: 800px; height: 500px; overflow-y:scroll">
                                    <div class="tab-pane active" id="tab_overview{{ $company->companyID }}">

                                        <p>{!! $company->overview  !!}  </p>
                                    </div>

                                    <div class="tab-pane" id="tab_arivals{{ $company->companyID }}">

                                        <p> {!! $company->arival  !!}</p>
                                    </div>


                                    <div class="tab-pane" id="tab_return{{ $company->companyID }}">

                                        <p> {!! $company->return_proc  !!}</p>
                                    </div>



                                    {{--<div class="tab-pane" id="tab_rev{{ $company->companyID }}">--}}
                                        {{--<h3>Latest Reviews</h3>--}}
                                        {{--<div class="review-block" style="padding: 10px;">--}}

                                            {{--@if($modules)--}}
                                                {{--@php--}}
                                                    {{--$reviews = \App\reviews::all()->where("type_id",$company->companyID)->where("status","Yes");--}}
                                                {{--@endphp--}}
                                                {{--@foreach ($reviews as $row)--}}
                                                    {{--@php--}}
                                                        {{--$percent = $row->rating*2;--}}
                                                        {{--$added_on= date('D, j F Y', strtotime($row->created_at));--}}
                                                    {{--@endphp--}}
                                                    {{--<div class="row">--}}


                                                        {{--<div class="review-block-description"--}}
                                                             {{--style="    padding: 20px;">--}}
                                                            {{--<blockquote class="quote-card"><p>{{ $row->review }} </p>--}}
                                                            {{--</blockquote>--}}
                                                            {{--<p><strong>Rating </strong> : <span--}}
                                                                        {{--style="font-size: 20px;font-weight: 900; color:#279bc3;">{{ $percent }}</span>--}}
                                                                {{--<sub>out of 10</sub></p>--}}
                                                            {{--<p><strong>Book Again :</strong> Yes</p>--}}
                                                            {{--<p class="review-design">{{  $row->username }}--}}
                                                                {{--<small>{{ $added_on }}</small>--}}
                                                                {{--<sup style="color:red;"> <b>Verified Customer</b></sup>--}}
                                                            {{--</p>--}}
                                                        {{--</div>--}}


                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}


                                        {{--</div>--}}
                                    {{--</div>--}}

                                    @if($company->parking_type == 'Meet and Greet')
                                        <div class="tab-pane" id="tab_map{{ $company->companyID }}">
                                            <iframe max-width="100%" height="400" frameborder="0" style="border:0"
                                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAbqO8h1hqd8sQ5YR7zC10C4TQ0kbW1j_g&q={{ $company->address }}+{{ $company->town }}+{{ $company->post_code }}"
                                                    allowfullscreen></iframe>
                                        </div>
                                    @else

                                        <div class="tab-pane" id="tab_map{{ $company->companyID }}">
                                            <iframe width="100%" height="400" frameborder="0" style="border:0"
                                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAbqO8h1hqd8sQ5YR7zC10C4TQ0kbW1j_g&q={{ $company->address }}+{{ $company->town }}+{{ $company->post_code }}"
                                                    allowfullscreen></iframe>

                                        </div>
                                    @endif

                                    <div class="tab-pane" id="tab_imp{{ $company->companyID }}">

                                        <div class="text-left">
                                            <h4><strong>Important Information</strong></h4>

                                            <ul class="points"
                                                style="text-align: left;list-style: none;line-height: 25px;font-size: 15px;padding-left:0px;">

                                                @php
                                                    $features =  explode(",",$company->special_features);

                                                @endphp

                                                @foreach($companies_special_features as $companies_special_feature)

                                                    @if(in_array ($companies_special_feature->name,$features))

                                                        <li>
                                                            <i class="fa fa-chevron-right"></i>{{  $companies_special_feature->name }}</span>
                                                        </li>
                                                    @endif
                                                @endforeach

                                            </ul>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_termcondition{{ $company->companyID }}">

                                        <div class="alert alert-info text-left" style="margin-top: 10px;">
                                            <strong>Will Be provided on request</strong>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---end model-->


        @endforeach


        </section>
        <!-- end innerpage-wrapper -->

        <script type="text/javascript">
            var date1           =$('.dpd1'),
                date2           =$('.dpd2');
        
        var startdate = new Date();
        startdate.setDate(startdate.getDate()-1);

        
        date1.datepicker({startDate: startdate,todayHighlight:'TRUE',format: 'dd-mm-yyyy',})
        .on('changeDate', function(e){
            $(this).datepicker('hide');
        });

        date2.datepicker({startDate: startdate,todayHighlight:'TRUE',format: 'dd-mm-yyyy',})
        .on('changeDate', function(e){
            $(this).datepicker('hide');
        });
        </script>
