@if(request()->get('src') != '')
{{ session()->put('bk_src', request()->get('src') )}}
@endif

@if(request()->get('utm_source') == 'ppc')
{{ session()->put('bk_src', 'PPC' )}}
@endif

@if(request()->get('utm_source') == 'bing')
{{ session()->put('bk_src', 'BING' )}}
@endif

@if(request()->get('utm_source') == 'EMAIL')
{{ session()->put('bk_src', 'EM' )}}
@endif

@php
$discount = request()->get('discount')
@endphp
<style>
    @media only screen and (max-width: 600px) {
  .search {
    height: 1024px;
  }
}
</style>
<div style="display:none;" id="notification"></div>
    <div class="search">
        

        <!-- Search Contents -->
        
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="col fill_height">

                    <!-- Search Tabs -->

                    <div class="search_tabs_container">
                        <div class="search_tabs d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                            <div class="search_tab active d-flex flex-row align-items-center justify-content-lg-center justify-content-start"><!-- <i class="nav-icon  fa fa-car" style="font-size: 25px;margin-right: 7px;"> --></i><img src="{{url('theme/images/suitcase.webp')}}" alt=""><span> Airport Parking</span></div>
                            <div class="search_tab d-flex flex-row align-items-center justify-content-lg-center justify-content-start"><img src="{{url('theme/images/bus.webp')}}" alt="">Lounges</div>
                            <div class="search_tab d-flex flex-row align-items-center justify-content-lg-center justify-content-start"><img src="{{url('theme/images/departure.webp')}}" alt="">Transfer</div>
                        
                        </div>      
                    </div>

                    <!-- Search Panel -->
                   

                    <div id="home_search_form" class=" search_panel active">
                        <form method="get" action="{{ route("searchresult") }}" id="search_form_1" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                               <div class="search_item">
                                <div>Airport</div>
                                <div class="form-group">
                               <select required name="airport_id"   class="dropdown_item_select search_input" required="required" style="border-radius: 18px 0px 0px 18px;"> 
                                                
                                                <option value="" disabled selected>Select</option>
                                                @foreach($airports as $airport)

                                                    <option value="{{ $airport->id }}">{{ $airport->name }}</option>

                                                @endforeach

                                 </select>
                             </div>
                                </div>
                            <div class="search_item" >
                                <div>Drop off Date</div>
                            
                                     <div class="form-group">

                                            <input autocomplete="off" name="dropoffdate" type="text"
                                            id="startDate"

                                                   class="check_in search_input \ dpd1" style="" placeholder="Dropoff Date"

                                                   readonly

                                                   required/>


                                        </div>

                            </div>

                                   
                            <div class="search_item">

                                <div>Drop off time</div>
                               
                                      <div class="form-group">
                                     
                                          @php
                                           
                                            $dropdown_timer = [];
                                               for ($i = 0; $i <= 23; $i++) {
                                                   for ($j = 0; $j <= 45; $j += 15) {
                                                      //$sel = str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT) == $opening_time ? 'selected' : '';
                                                          //echo '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT).'"'.$sel.'>'.str_pad($i, 2, "0", STR_PAD_LEFT).':'.str_pad($j, 2, "0", STR_PAD_LEFT).'</option>';
                                                            $dropdown_timer[str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT);
                                                            //print_r($dropdown_timer);
                                                           
                                                         }
                                                        }

                                            @endphp

                                            {{-- {{ Form::select('dropoftime',$dropdown_timer,"",["class"=>"check_in search_input","id"=>"dropoftime"]) }} --}}

                                            <select class="check_in search_input" id="dropoftime" name="dropoftime">
                                              @php
                                                foreach ($dropdown_timer as $key => $value) {
                                                  $selected ='';
                                                  if($value == '09:00'){
                                                    $selected ='selected';
                                                  }
                                              @endphp
                                                 <option {{$selected}} value="{{ $value }}">{{ $value }}</option> 
                                              @php
                                              }
                                              @endphp
                                            </select>
                                            
                                        </div>
                            </div>
                            <div class="search_item" style="width: 20%">
                             <div>Pick Up Date</div>
                             

                                        <div class="form-group">

                                            <input type="text" readonly autocomplete="off" name="departure_date"
                                            id="endDate"

                                                   class="check_in search_input dpd2" placeholder="Departure Date"

                                                   required/>

                                            

                                        </div>

                            </div>
                            <div class="search_item">
                                <div>Pickup time</div>

                              

                                        <div class="form-group">

                                         
                                           <select class="dropdown_item_select search_input" id="pickup_time" name="pickup_time">
                                              @php
                                                foreach ($dropdown_timer as $key => $value) {
                                                  $selected ='';
                                                  if($value == '09:00'){
                                                    $selected ='selected';
                                                  }
                                              @endphp
                                                 <option {{$selected}} value="{{ $value }}">{{ $value }}</option> 
                                              @php
                                              }
                                              @endphp
                                            </select>
                                            
                                            {{-- {{ Form::select('pickup_time',$dropdown_timer,"",["class"=>"dropdown_item_select search_input","id"=>"pickup_time"]) }} --}}



                                        </div>

                            
                               
                            </div>
                            @if($discount != null)
                            <div class="alert alert-success" style = 'margin-right:10px ; margin-top:33px ; width:250px'>
                        <strong>Success!</strong> Discount Applied.
                            </div>
                            <div class="search_item" style = 'display:none'>
                                <div>Promo Code</div>
                               

                                        <div class="form-group">

                                            <input type="hidden" name="promo" class="check_in search_input"

                                                   placeholder="Promo Code" value="{{ request()->get('discount') }}" />


                                     </div>
                            </div>
                            @else
                            <div class="search_item">
                                <div>Promo Code</div>
                               

                                        <div class="form-group">

                                            <input type="text" name="promo" class="check_in search_input"

                                                   placeholder="Promo Code" value="{{ request()->get('promo') }}" />


                                     </div>
                            </div>
                            @endif
                            <input type="hidden" value="{{ (request()->get('promo') != null) ? 'EM' : 'ORG' }}" name='src'>
                            <button class="button form-button search_button">Get A Quote<span></span><span></span></button>
                        </form>
                    </div>

                    <!-- Search Panel -->

                    <div class="search_panel">
                        <form action="#" id="search_form_2" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                    
                         
                       
                        <center>    <button type="button" class="button search_button">Coming Soon<span></span><span></span><span></span></button> </center>
                        </form>
                    </div>

                    <!-- Search Panel -->

                    <div class="search_panel">
                    <form action="#" id="search_form_2" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                    
                         
                       
                           <center> <button type="button" class="button search_button">Coming Soon<span></span><span></span><span></span></button></center>
                        </form>
                    </div>

                    <!-- Search Panel -->


                    <!-- Search Panel -->

                    <!-- Search Panel -->

                 
                </div>
            </div>
        </div>      
    </div>