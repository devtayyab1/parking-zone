
<div id="hero-main">
    <div class="hero-content">
        <div class="text-align">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3 id="welcome">Welcome To ParkingZone</h3>
                        <h3 id="tagline">Enjoy Your Life With Us!</h3>
                        <div class="hero-text">
                            
                         <ul id="tabs-0" class="nav nav-pills nav-tabs responsive hidden-xs hidden-sm">
  <li  class="active" style="width: 200px;background-color: #1087ecad;border-radius: 20px;" ><a href="#">Airports</a></li>
  
  
</ul>
<nav  class="navbar navbar-default"     style="background-color:#171919a6;padding: 22px">
                            <form action="{{ route("searchresult") }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                                        <label>Airport</label>
                                        <div class="form-group">
                                            <span><i class="fa fa-angle-down"></i></span>
                                            <select required="" name="airport_id"  class="form-control">
                                                <option  selected value="">Airport</option>
                                                @foreach($airports as $airport)
                                                    <option  value="{{ $airport->id }}">{{ $airport->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                                        <label>Drop of Date</label>
                                        <div class="form-group">
                                            <input autocomplete="off" name="dropoffdate" type="text"
                                                   class="form-control dpd1" style="" placeholder="Dropoff Date"
                                                   readonly
                                                   required/>
                                            <span><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                                        <label>Drop of time</label>
                                        <div class="form-group">


                                            <span><i class="fa fa-angle-down"></i></span>
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
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                        <label>Pick Up Date</label>
                                        <div class="form-group">
                                            <input type="text" readonly autocomplete="off" name="departure_date"
                                                   class="form-control dpd2" placeholder="Departure Date"
                                                   required/>
                                            <span><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                        <label>Pickup time</label>
                                        <div class="form-group">
                                            <span><i class="fa fa-angle-down"></i></span>
                                            {{ Form::select('pickup_time',$dropdown_timer,"",["class"=>"form-control","id"=>"pickup_time"]) }}

                                        </div>
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                        <label>Promo Code</label>
                                        <div class="form-group">
                                            <input type="text" name="promo" class="form-control"
                                                   placeholder="Promo Code"/>

                                        </div>
                                    </div><!-- end columns -->


                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 text-center">
                                        <button type="submit"
                                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 btn btn-default btn-lg btn-padding">
                                            GET A QUOTE
                                        </button>
                                    </div><!-- end columns -->

                                </div><!-- end row -->
                            </form>
                         
                          
                        </div><!-- end hero text -->
                    </div><!-- end col-sm-12 -->
                </div><!-- end row -->

            </div><!-- end container -->
        </div><!-- end text align -->
    </div><!-- end hero content -->

</div><!-- end hero main -->
  </nav>