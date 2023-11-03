<div class="sub-serc">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane active" id="home4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="accordion"
                                     class="accordion-style1 panel-group passenger-detail">
                                    <h3 class="text-center"
                                    >ParkingZone Get
                                        Discount</h3>
                                    <div class="">
                                        <div class="panel-heading">
                                            <h4 class="panel-title maintab">
                                                <a class="accordion-toggle" href="#collapseOne"
                                                   data-parent="#accordion" data-toggle="collapse">
                                                    <i class="icon-angle-down bigger-110"
                                                       data-icon-show="icon-angle-right"
                                                       data-icon-hide="icon-angle-down"></i>
                                                    Airport Parking
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <form method="POST" class="quote-form"
                                                  action="{{ route("searchresult") }}" id="airportParkingForm12">
                                                @csrf
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <label class="title">Airport
                                                                <small> ( Select Your Airport )
                                                                </small>
                                                            </label>
                                                            <select required name="airport_id" class="form-control">
                                                                <option value="" selected>Airport</option>
                                                                @foreach($airports as $airport)
                                                                    <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                                                                @php $date = date("Y-m-d"); @endphp
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <label class="title">Departure
                                                                Date</label>
                                                            <input required class="form-control right_dpd1"
                                                                   id="dropdatepicker12"
                                                                   autocomplete="off"
                                                                   readonly
                                                                   name="dropoffdate"
                                                                   value="{{ $date }}" placeholder="MM/DD/YY" value="" style="background:white;">
                                                        </div>

                                                        <div class="col-xs-6">
                                                            <label class="title">Time</label>
                                                            @php
                                                                $dropdown_timer = [];
                                                               for ($i = 0; $i <= 23; $i++) {
                                                                   for ($j = 0; $j <= 45; $j += 15) {
                                                                       //$sel = str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT) == $opening_time ? 'selected' : '';
                                                                       //echo '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT).'"'.$sel.'>'.str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT).'</option>';
                                                                       $dropdown_timer[str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT);
                                                                   }
                                                               }
                                                            @endphp
                                                            {{ Form::select('dropoftime',$dropdown_timer,"",["class"=>"form-control","id"=>"dropoftime"]) }}


                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <label class="title">Arrival
                                                                Date</label>
                                                            <input required class="form-control right_dpd2"
                                                                   id="pickdatepicker12"
                                                                   autocomplete="off"
                                                                   readonly
                                                                   name="departure_date"
                                                                   <?php
                                                                                                               $mydate = $date;
                                                                                                               $daystosum = '2';
                                                                                                               $datesum = date('Y-m-d', strtotime($mydate . ' + ' . $daystosum . ' days'));
                                                                                                               ?>
                                                                                                               value="{{ $datesum}}"
                                                                                                               value="" placeholder="MM/DD/YY" value="" style="background: white;">
                                                        </div>

                                                        <div class="col-xs-6">
                                                            <label class="title">Time</label>
                                                            {{ Form::select('pickup_time',$dropdown_timer,"",["class"=>"form-control ","id"=>"pickup_time"]) }}


                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class=" col-md-12">
                                                            <label class="title"></label>

                                                            <button class="btn btn butn_1 center-block btn-quote-ap"
                                                                    style="color: #fff; font-size:20px;margin-bottom:10px; background:linear-gradient(to right,rgba(30, 126, 37, 0.9) 0,rgba(12, 66, 132, 0.9));"
                                                                    type="submit" name="button"
                                                                    value="Get a quote">GET A QUOTE
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--<div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title maintab">
                                                <a class="accordion-toggle collapsed" href="#collapseTwo" data-parent="#accordion" data-toggle="collapse">
                                                    <i class="icon-angle-right bigger-110" data-icon-show="icon-angle-right" data-icon-hide="icon-angle-down"></i>
                                                    Airport Hotel
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title maintab">
                                                <a class="accordion-toggle collapsed" href="#collapseThree" data-parent="#accordion" data-toggle="collapse">
                                                <i class="icon-angle-right bigger-110" data-icon-show="icon-angle-right" data-icon-hide="icon-angle-down"></i>
                                                 Airport Hotel &  Parking
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="sb-serc">
    <h5>Airport Parking</h5>
    <img src="assets/images/black.png" alt="logo" class="guide-width">
    <p>Secure, guaranteed and satisfactory. Our customers reap benefits from priority parking at
        350+ car parks on 30+ major airports across UK, while saving up to 30%.</p>
    <a href="{{ route("airports") }}" class="btn btn-submit">Learn More</a>
</div>
<div class="sb-serc">
    <h5>Airport Hotels</h5>
    <img src="assets/images/hotels.png" alt="logo" class="guide-width">
    <p>Why struggle through traffic to reach airport when you can say goodbye to stress with ParkingZone
        and book an Airport hotel in two minutes. </p>
    <a  class="btn btn-submit">Comming Soon</a>
</div>
<div class="sub-serc">
    <div class="sb-serc">
        <h5>Airport Lounges</h5>
        <img src="assets/images/ds.png" alt="logo" class="guide-width">
        <p>Take a break from all the stress and extensive traveling. Book a premium lounge with
            ParkingZone  in the price of an economy airport lounge. </p>
        <a  class="btn btn-submit">Comming Soon</a>
    </div>
</div>
<div class="sub-serc">
    <div class="sb-serc">
        <h5>Other Traveling Services</h5>
        <img src="assets/images/car.svg" alt="logo" class="guide-width">
        <p>Flying made easy. We offer unbeatable rates for car rentals, travel insurance, taxi
            services, parking, airport lounges and international hotels. Try it to believe it!</p>
        <a  class="btn btn-submit">Comming Soon</a>
    </div>
</div>
@section("footer-script")
    <script>
        $(function () {
//            var dateToday = new Date();
//
//            $("#dropdatepicker12").datepicker({
//                minDate: 0,
//
//                dateFormat: 'dd/mm/yy'
////                onSelect: function (dateText, inst) {
////
////                    var date2 = $('#dropdatepicker12').datepicker('getDate', '+1d');
////                    //date2.setDate(date2.getDate() + 7);
////                    //$('#pickdatepicker12').datepicker('setDate', date2);
////                }
//
//            });
//            $('#pickdatepicker12').datepicker({
//                    minDate: 0,
//                    dateFormat: 'dd/mm/yy'
////                    beforeShow: function () {
////                        $(this).datepicker('option', 'minDate', $('#dropdatepicker12').val());
////                        if ($('#dropdatepicker12').val() === '') $(this).datepicker('option', 'minDate', 0);
////                    }
//                });

//            $('#dropdatepicker12').datepicker(
//                { startDate: new Date(),
//                    minDate: 0,
//                    dateFormat: 'dd/mm/yy',
//                    beforeShow: function() {
//                        $(this).datepicker('option', 'maxDate', $('#pickdatepicker12').val());
//                    }
//                });
//            $('#pickdatepicker12').datepicker(
//                {
//                    startDate: new Date(),
//                    dateFormat: 'dd/mm/yy',
//                    beforeShow: function() {
//                        $(this).datepicker('option', 'minDate', $('#from').val());
//                        if ($('#from').val() === '') $(this).datepicker('option', 'minDate', 0);
//                    }
//                });


        });
    </script>
@endsection