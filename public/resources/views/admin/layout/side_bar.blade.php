<div id="sidebar" class="sidebar                  responsive                    ace-save-state">

    <script type="text/javascript">

        try {

            ace.settings.loadState('sidebar')

        } catch (e) {
			

        }

    </script>

                            @php $role =(auth::user()->with('roles', 'roles.role')->where('id',auth::id())->first()); 
                            ( $role->roles->role->name);
                            @endphp




    <ul class="nav nav-list">





        <li class="dashboard_link @if(Route::currentRouteName()== "") {{ "active"  }} @endif">
       
            <a href="{{ url("/admin") }}">

                <i class="menu-icon fa fa-tachometer"></i>

                <span class="menu-text"> Dashboard </span>

            </a>



            <b class="arrow"></b>

        </li>

@if($role->roles->role->name != "airport_parking")

        @can('menu_auth', ["Administrators"])

            <li class="administrators_link @if(Route::currentRouteName()=="user_list") {{ "active"  }} @endif">

                <a href="{{ route('user_list') }}">

                    <i class="menu-icon fa fa-group"></i>

                    <span class="menu-text">

                               Administrators 

                            </span>



                </a>

            </li>

        @endcan





        @can('menu_auth', ["Airport Parkings"])

            <li class="@if(Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking" ||Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking"||Route::currentRouteName()=="invoice_commission_report" ||Route::currentRouteName()=="searchForm"||Route::currentRouteName()=="airport_commission_report" || Route::currentRouteName()=="company_report" || Route::currentRouteName()=="bookinghistroy" || Route::currentRouteName()=="dsp" || Route::currentRouteName()=="dspview" || Route::currentRouteName()=="company_setting" || Route::currentRouteName()=="awards.index" ||  Route::currentRouteName()=="airport.index" || Route::currentRouteName()=="plan.create" || Route::currentRouteName()=="setPlan" || Route::currentRouteName()=="viewEditPlan" || Route::currentRouteName()=="viewEditPlan" || Route::currentRouteName()=="company_departure_report" || Route::currentRouteName()=="day_wise_Booking") {{ "open"  }} @endif">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-list"></i>

                    <span class="menu-text"> Airport Parking</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>

                @can('menu_auth', ["Booking"])

                    <ul class="submenu">





                        <li class="@if(Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking" ||Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking"||Route::currentRouteName()=="invoice_commission_report" ||Route::currentRouteName()=="searchForm"||Route::currentRouteName()=="airport_commission_report" || Route::currentRouteName()=="company_report" ||Route::currentRouteName()=="bookinghistroy" || Route::currentRouteName()=="dsp" || Route::currentRouteName()=="dspview") {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Booking </span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>





                            <ul class="submenu">



                                @can('menu_auth', ["Booking List"])

                                    <li class="@if(Route::currentRouteName()=="booking") {{ "active"  }} @endif">

                                        <a href="{{ route('booking') }}">





                                            Booking List





                                        </a>



                                        <b class="arrow"></b>



                                    </li>

                                @endcan



                                @can('menu_auth', ["Operations Invoices"])
                                
                                    <li class="@if(Route::currentRouteName()=="invoice_commission_report") {{ "active"  }} @endif">

                                        <a href="{{ route('invoice_commission_report')}}">

                        

                            <span class="menu-text">

                                Invoices for Operations

                            </span>



                                        </a>

                                    </li>

                                @endcan



                                @can('menu_auth', ["Invoice All"])

                                    <li class="@if(Route::currentRouteName()=="searchForm") {{ "active"  }} @endif">

                                        <a href="{{ route('searchForm') }}">

                         

                            <span class="menu-text">

                               Invoice All

                            </span>



                                        </a>

                                    </li>

                                @endcan



                                @can('menu_auth', ["Add Booking"])

                                    <li class="@if(Route::currentRouteName()=="add-booking") {{ "active"  }} @endif">





                                        <a href="{{ route('add-booking') }}">





                                            Add Booking





                                        </a>





                                        <b class="arrow"></b>



                                    </li>

                                @endcan







                                @can('menu_auth', ["Incomplete Booking"])

                                    <li class="@if(Route::currentRouteName()=="incomplete_Booking") {{ "active"  }} @endif">



                                        <a href="{{ route('incomplete_Booking') }}">

                       

                            <span class="menu-text">

                                Incomplete Booking

                            </span>



                                        </a>



                                    </li>



                                @endcan



                                @can('menu_auth', ["Booking Histroy"])

                                    <li class="@if(Route::currentRouteName()=="bookinghistroy") {{ "active"  }} @endif">

                                        <a href="{{ route('bookinghistroy') }}">

                        

                            <span class="menu-text">

                              Booking Histroy

                            </span>



                                        </a>

                                    </li>

                                @endcan





                                @can('menu_auth', ["ParkingZone Detail Commision Reports"])

                                    <li class="@if(Route::currentRouteName()=="airport_commission_report") {{ "active"  }} @endif">

                                        <a href="{{route('airport_commission_report') }}">

                     

                            <span class="menu-text">

                           Detail All Commision Reports

                            </span>



                                        </a>

                                    </li>

                                @endcan



                                @can('menu_auth', ["Company Commision Reports"])

                                    <li class="@if(Route::currentRouteName()=="company_report") {{ "active"  }} @endif">

                                        <a href="{{ route('company_report') }}">

                       

                            <span class="menu-text">

                            Agent Commision Reports

                            </span>



                                        </a>

                                    </li>

                                @endcan





                                @can('menu_auth', ["Dsp"])

                                    <li class="@if(Route::currentRouteName()=="dsp") {{ "active"  }} @endif">

                                        <a href="{{ route('dsp') }}">

                         

                            <span class="menu-text">

                     Dsp

                            </span>



                                        </a>

                                    </li>

                                @endcan





                                @can('menu_auth', ["Dsp View"])

                                    <li class="@if(Route::currentRouteName()=="dspview") {{ "active"  }} @endif">

                                        <a href="{{ route('dspview') }}">

                       

                            <span class="menu-text">

                      Dsp View

                            </span>



                                        </a>

                                    </li>

                                @endcan





                            </ul>

                        </li>



                        @endcan









                        @can('menu_auth', ["Price Plan"])

                            <li class="@if(Route::currentRouteName()=="plan.create" || Route::currentRouteName()=="setPlan" || Route::currentRouteName()=="viewEditPlan" || Route::currentRouteName()=="viewEditPlan") {{ "open"  }} @endif"">



                                <a href="#" class="dropdown-toggle">

                                    <i class="menu-icon fa fa-list"></i>

                                    <span class="menu-text"> Price Plan</span>



                                    <b class="arrow fa fa-angle-down"></b>

                                </a>



                                <b class="arrow"></b>



                                <ul class="submenu">



                                    @can('menu_auth', ["Plan Setting"])

                                        <li class="@if(Route::currentRouteName()=="plan.create") {{ "active"  }} @endif">



                                            <a href="{{ route('plan.create') }}">

              

                    <span class="menu-text">

                                Plan Setting

                            </span>



                                            </a>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Set Plan"])

                                        <li class="@if(Route::currentRouteName()=="setPlan") {{ "active"  }} @endif">



                                            <a href="{{ route('setPlan') }}">

                

                                                <span class="menu-text">

                                                            Set Plan

                                                        </span>



                                            </a>



                                        </li>

                                    @endcan





                                        @can('menu_auth', ["viewedit Plan"])

                                            <li class="@if(Route::currentRouteName()=="viewEditPlan") {{ "active"  }} @endif">



                                                <a href="{{ route('viewEditPlan') }}">



                                                <span class="menu-text">

                                                            View / Edit Plan

                                                        </span>



                                                </a>



                                            </li>

                                        @endcan





                                </ul>

                            </li>

                        @endcan







                        @can('menu_auth', ["Airports"])

                            <li class="@if(Route::currentRouteName()=="airport.index") {{ "active"  }} @endif">

                                <a href="{{ route('airport.index') }}">

                                    <i class="menu-icon fa fa-plane"></i>

                                    <span class="menu-text">

                                Airports

                            </span>



                                </a>

                            </li>

                        @endcan

                        @can('menu_auth', ["Companies"])

                            <li class="@if(Route::currentRouteName()=="company.index") {{ "active"  }} @endif">

                                <a href="{{ route('company.index') }}">

                                    <i class="menu-icon fa fa-building"></i>

                                    <span class="menu-text">

                                Companies

                            </span>



                                </a>

                            </li>

                        @endcan

                        @can('menu_auth', ["Reports"])
                        
                        
                        
                        
                        
                        

                            <li class="reports @if(Route::currentRouteName()=="company_departure_report" || Route::currentRouteName()=="day_wise_Booking") {{ "active"  }} @endif">

                                <a href="#" class="dropdown-toggle">

                                    <i class="menu-icon fa fa-list"></i>

                                    <span class="menu-text"> Reports</span>



                                    <b class="arrow fa fa-angle-down"></b>

                                </a>



                                <b class="arrow"></b>



                                <ul class="submenu">
                                
                                
                                     @can('menu_auth', ["Departure Report"])
                                    
                                        <li class="@if(Route::currentRouteName()=="company_departure_report") {{ "active"  }} @endif">
                                    
                                            <a href="{{ route("company_departure_report") }}">                                
                                                                       
                                                Departure Report
                                            </a>
                                    
                                            <b class="arrow"></b>
                                    
                                        </li>
                                    
                                    @endcan

                                    @can('menu_auth', ["Booking List"])
                                    <li class="@if(Route::currentRouteName()=="day_wise_Booking") {{ "active"  }} @endif">
                                        <a href="{{ route('day_wise_Booking') }}">
                                            <span class="menu-text">              
                                                Day Wise Report                
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                                 
                                <!--

                                    @can('menu_auth', ["Print Card"])

                                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin")}}">





                                                Print Card





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Departure Report"])

                                        <li class="@if(Route::currentRouteName()=="") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin") }}">





                                                Departure Report





                                            </a>



                                            <b class="arrow"></b>



                                        </li>



                                    @endcan

                                    @can('menu_auth', [" Return Report"])

                                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin") }}">





                                                Return Report





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Departure and Return Report"])

                                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin") }}">





                                                Departure and Return Report





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Day Wise Report"])

                                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin") }}">





                                                Day Wise Report





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Over Night Stay Report"])

                                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                            <a href="{{ url("/admin") }}">





                                                Over Night Stay Report





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan


                                -->


                                </ul>

                            </li>
                       

                        @endcan



                        @can('menu_auth', ["Company Setting"])

                            <li class="@if(Route::currentRouteName()=="company_setting" || Route::currentRouteName()=="awards.index" ) {{ "open"  }} @endif">

                                <a href="#" class="dropdown-toggle">

                                    <i class="menu-icon fa fa-cog"></i>

                                    <span class="menu-text"> Company Setting </span>



                                    <b class="arrow fa fa-angle-down"></b>

                                </a>



                                <b class="arrow"></b>



                                <ul class="submenu">

                                    @can('menu_auth', ["Awards"])

                                        <li class="@if(Route::currentRouteName()=="awards.index") {{ "active"  }} @endif">

                                            <a href="{{ route('awards.index') }}">

                                                <i class="menu-icon fa fa-trophy"></i>



                                                Awards





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan

                                    @can('menu_auth', ["Setting"])

                                        <li class="@if(Route::currentRouteName()=="company_setting"  ) {{ "active"  }} @endif">

                                            <a href="{{ route('company_setting') }}">

                                                <i class="menu-icon fa fa-wrench"></i>



                                                Setting





                                            </a>



                                            <b class="arrow"></b>



                                        </li>

                                    @endcan





                                </ul>

                            </li>

                        @endcan





                    </ul>

            </li>

        @endcan

        @if($role->roles->role->name=="SuperAdmin")

        @can('menu_auth', ["Hotels"])
 <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-rocket"></i>

                    <span class="menu-text"> Hotels</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">

                    @can('menu_auth', ["Booking"])



                        <li class="@if(Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking" ) {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Booking </span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">



                                <li class="@if(Route::currentRouteName()=="") {{ "active"  }} @endif">

                                    <a href="{{ route('booking') }}">





                                        Hotel Traffic





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()=="add-booking") {{ "active"  }} @endif">

                                    <a href="{{ route('add-booking') }}">





                                        <span class="menu-text">Add Bookings</span>





                                    </a>





                                </li>





                                <li class="@if(Route::currentRouteName()=="incomplete_Booking") {{ "active"  }} @endif">

                                    <a href="{{ route('incomplete_Booking') }}">

                  

                            <span class="menu-text">

                                Incomplete Booking

                            </span>



                                    </a>

                                </li>



                                <li class="@if(Route::currentRouteName()=="incomplete_Booking") {{ "active"  }} @endif">

                                    <a href="{{ route('incomplete_Booking') }}">

                  

                            <span class="menu-text">

                                Booking Histroy

                            </span>



                                    </a>

                                </li>





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin")}}">

                          

                            <span class="menu-text">

                        Commission Report

                            </span>



                                    </a>

                                </li>



                            </ul>

                        </li>



                    @endcan



                    <li class="">

                        <a href="#" class="dropdown-toggle">

                            <i class="menu-icon fa fa-list"></i>

                            <span class="menu-text"> Price Plan</span>



                            <b class="arrow fa fa-angle-down"></b>

                        </a>



                        <b class="arrow"></b>



                        <ul class="submenu">





                            <li class="@if(Route::currentRouteName()=="plan.create") {{ "active"  }} @endif">

                                <a href="{{ route('plan.create') }}">

                   

                    <span class="menu-text">

                                Plan Setting

                            </span>



                                </a>

                            </li>



                            <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                <a href="{{ url("/admin") }}">

                  

                    <span class="menu-text">

                                View/Edit  Plan

                            </span>



                                </a>

                            </li>





                        </ul>

                    </li>



                    @can('menu_auth', ["Hotel List"])

                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                            <a href="{{ url("/admin")}}">

                                <i class="menu-icon fa fa-plane"></i>

                                <span class="menu-text">

                               Hotel List

                            </span>



                            </a>

                        </li>

                    @endcan

                    @can('menu_auth', ["Rooms"])

                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                            <a href="{{ url("/admin")}}">

                                <i class="menu-icon fa fa-building"></i>

                                <span class="menu-text">

                               Rooms

                            </span>



                            </a>

                        </li>

                    @endcan

                    @can('menu_auth', ["Reports"])

                        <li class="">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Reports</span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin")}}">





                                        Print Card





                                    </a>



                                    <b class="arrow"></b>



                                </li>





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin") }}">





                                        Check in Report





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin") }}">





                                        Day Wise Report





                                    </a>



                                    <b class="arrow"></b>



                                </li>





                            </ul>

                        </li>

                    @endcan



                    @can('menu_auth', ["Hotel Setting"])

                        <li class="@if(Route::currentRouteName()=="company_setting" || Route::currentRouteName()=="awards.index" ) {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-cog"></i>

                                <span class="menu-text">Hotel  Settings</span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()=="company_setting"  ) {{ "active"  }} @endif">

                                    <a href="{{ route('company_setting') }}">

                                        <i class="menu-icon fa fa-wrench"></i>



                                        Hotel Awards





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()=="awards.index") {{ "active"  }} @endif">

                                    <a href="{{ route('awards.index') }}">

                                        <i class="menu-icon fa fa-trophy"></i>



                                        Hotel Settings



                                    </a>



                                    <b class="arrow"></b>



                                </li>





                            </ul>

                        </li>

                    @endcan





                </ul>

            </li> 

        @endcan

        @can('menu_auth', ["Hotel with Parking"])

            <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-rocket"></i>

                    <span class="menu-text"> Hotel with Parking</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">

                    @can('menu_auth', ["Booking"])



                        <li class="@if(Route::currentRouteName()=="add-booking" || Route::currentRouteName()=="booking" || Route::currentRouteName()=="incomplete_Booking" ) {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Booking </span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">



                                <li class="@if(Route::currentRouteName()=="") {{ "active"  }} @endif">

                                    <a href="{{ route('booking') }}">





                                        Hotel Parking Traffic





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()=="add-booking") {{ "active"  }} @endif">

                                    <a href="{{ route('add-booking') }}">





                                        <span class="menu-text">Add Bookings</span>





                                    </a>





                                </li>



                                <li class="@if(Route::currentRouteName()=="add-booking") {{ "active"  }} @endif">

                                    <a href="{{ route('add-booking') }}">





                                        <span class="menu-text">Bookings Histroy</span>





                                    </a>





                                </li>





                                <li class="@if(Route::currentRouteName()=="incomplete_Booking") {{ "active"  }} @endif">

                                    <a href="{{ route('incomplete_Booking') }}">

                  

                            <span class="menu-text">

                                Incomplete Bookings

                            </span>



                                    </a>

                                </li>



                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin")}}">

                          

                            <span class="menu-text">

                        Commission Report

                            </span>



                                    </a>

                                </li>



                            </ul>

                        </li>



                    @endcan



                    <li class="">

                        <a href="#" class="dropdown-toggle">

                            <i class="menu-icon fa fa-list"></i>

                            <span class="menu-text"> Price Plan</span>



                            <b class="arrow fa fa-angle-down"></b>

                        </a>



                        <b class="arrow"></b>



                        <ul class="submenu">





                            <li class="@if(Route::currentRouteName()=="plan.create") {{ "active"  }} @endif">

                                <a href="{{ route('plan.create') }}">

                   

                    <span class="menu-text">

                                Plan Setting

                            </span>



                                </a>

                            </li>



                            <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                <a href="{{ url("/admin") }}">

                  

                    <span class="menu-text">

                                View/Edit  Plan

                            </span>



                                </a>

                            </li>





                        </ul>

                    </li>



                    @can('menu_auth', ["Hotel List"])

                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                            <a href="{{route('company.index') }}">

                                <i class="menu-icon fa fa-plane"></i>

                                <span class="menu-text">

                               Hotel List

                            </span>



                            </a>

                        </li>

                    @endcan

                    @can('menu_auth', ["Rooms"])

                        <li class="@if(Route::currentRouteName()=="company.index") {{ "active"  }} @endif">

                            <a href="{{ route('company.index') }}">

                                <i class="menu-icon fa fa-building"></i>

                                <span class="menu-text">

                               Rooms

                            </span>



                            </a>

                        </li>

                    @endcan

                    @can('menu_auth', ["Reports"])

                        <li class="">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Reports</span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin")}}">





                                        Print Card





                                    </a>



                                    <b class="arrow"></b>



                                </li>





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin") }}">





                                        Check in Report





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin") }}">





                                        Day Wise Report





                                    </a>



                                    <b class="arrow"></b>



                                </li>





                            </ul>

                        </li>

                    @endcan



                    @can('menu_auth', ["Hotel Parking Setting"])

                        <li class="@if(Route::currentRouteName()=="company_setting" || Route::currentRouteName()=="awards.index" ) {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-cog"></i>

                                <span class="menu-text">Hotel Parking Settings</span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()=="company_setting"  ) {{ "active"  }} @endif">

                                    <a href="{{ route('company_setting') }}">

                                        <i class="menu-icon fa fa-wrench"></i>



                                        Hotel Parking Awards





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()=="awards.index") {{ "active"  }} @endif">

                                    <a href="{{ route('awards.index') }}">

                                        <i class="menu-icon fa fa-trophy"></i>



                                        Hotel Parking Settings



                                    </a>



                                    <b class="arrow"></b>



                                </li>





                            </ul>

                        </li>

                    @endcan





                </ul>

            </li> 

        @endcan

        @can('menu_auth', ["Lounges"])
            <li class="@if(Route::currentRouteName()=="booking_lounge" || Route::currentRouteName()=="incomplete_Booking_lounge" || Route::currentRouteName()=="bookinghistory_lounge" ) {{ "open"  }} @endif">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-location-arrow"></i>

                    <span class="menu-text"> Lounges</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">

                    @can('menu_auth', ["Booking"])



                        <li class="@if(Route::currentRouteName()=="booking_lounge" || Route::currentRouteName()=="incomplete_Booking_lounge" || Route::currentRouteName()=="bookinghistory_lounge" ) {{ "open"  }} @endif">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Booking </span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()=="booking_lounge") {{ "active"  }} @endif">

                                    <a href="{{ route('booking_lounge') }}">





                                        Booking List





                                    </a>



                                    <b class="arrow"></b>



                                </li>



                                <li class="@if(Route::currentRouteName()=="add-booking") {{ "active"  }} @endif">

                                    <a href="{{ route('add-booking') }}">





                                        Add Booking





                                    </a>



                                    <b class="arrow"></b>



                                </li>





                                <li class="@if(Route::currentRouteName()=="incomplete_Booking_lounge") {{ "active"  }} @endif">

                                    <a href="{{ route('incomplete_Booking_lounge') }}">

                      

                            <span class="menu-text">

                                Incomplete Booking

                            </span>



                                    </a>

                                </li>



                                <li class="@if(Route::currentRouteName()=="bookinghistory_lounge") {{ "active"  }} @endif">

                                    <a href="{{ route("bookinghistory_lounge")}}">

                         

                                        <span class="menu-text">
            
                                            Booking History
            
                                        </span>



                                    </a>

                                </li>



                            </ul>

                        </li>



                    @endcan





                    @can('menu_auth', ["lounges Settings"])

                        <li class="">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list"></i>

                                <span class="menu-text"> Lounges Settings</span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">





                                <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                                    <a href="{{ url("/admin") }}">

                                        <i class="menu-icon fa fa-cogs"></i>

                                        <span class="menu-text">

                             Settings

                            </span>



                                    </a>

                                </li>





                            </ul>

                        </li>

                    @endcan





                </ul>

            </li>

        @endcan

        @can('menu_auth', ["Car Hire"])

       <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-car"></i>

                    <span class="menu-text"> Car Hire</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">





                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                           Bookings

                            </span>



                        </a>

                    </li>



                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                      Reports

                            </span>



                        </a>

                    </li>





                </ul>

            </li> 

        @endcan

        @can('menu_auth', ["Travels Insurance"])

         <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-car"></i>

                    <span class="menu-text"> Travels Insurance</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">





                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                           Bookings

                            </span>



                        </a>

                    </li>



                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                      Reports

                            </span>



                        </a>

                    </li>





                </ul>

            </li> 

        @endcan

        @can('menu_auth', ["Holiday Packeges"])

         <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon     fa fa-bed"></i>

                    <span class="menu-text"> Holiday Packeges</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">





                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                           Bookings

                            </span>



                        </a>

                    </li>



                    <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                        <a href="{{ url("/admin") }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                      Reports

                            </span>



                        </a>

                    </li>





                </ul>

            </li> 

        @endcan
        @endif

        @can('menu_auth', ["Settings"])



            <li class="@if(Route::currentRouteName()=="subscribers.index" || Route::currentRouteName()=="customers.index" || Route::currentRouteName()=="email_setting" ||  Route::currentRouteName()=="emails.index" ||Route::currentRouteName()=="seo_setting"|| Route::currentRouteName()=="discounts.index" || Route::currentRouteName()=="pages.index" || Route::currentRouteName()=="faqs.index" || Route::currentRouteName()=="banner_list" || Route::currentRouteName()=="social_setting" || Route::currentRouteName()=="general_setting" || Route::currentRouteName()=="homepage_setting" || Route::currentRouteName()=="services_page_setting") {{ "open"   }} @endif">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-list"></i>

                    <span class="menu-text"> Settings </span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">

                    @can('menu_auth', ["Subscribers"])



                        <li class="@if(Route::currentRouteName()=="subscribers.index") {{ "active"  }} @endif">

                            <a href="{{ route('subscribers.index') }}">

                                <i class="menu-icon fa fa-users"></i>

                                <span class="menu-text">

                                Subscribers

                            </span>

                            </a>

                        </li>
                        <li class="@if(Route::currentRouteName()=="customers.index") {{ "active"  }} @endif">

                            <a href="{{ route('customers.index') }}">

                                <i class="menu-icon fa fa-users"></i>

                                <span class="menu-text">

                                Customers

                                </span>

                            </a>

                        </li>

                    @endcan



        @if($role->roles->role->name=="SuperAdmin")


                    @can('menu_auth', ["Email  Settings"])

                        <li class="@if(Route::currentRouteName()=="email_setting") {{ "active"  }} @endif">

                            <a href="{{ route('email_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Email Settings

                            </span>



                            </a>

                        </li>

                    @endcan

@endif

                    @can('menu_auth', ["Email Templates"])

                        <li class="@if(Route::currentRouteName()=="emails.index") {{ "active"  }} @endif">

                            <a href="{{ route('emails.index') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Email Templates

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Seo Settings"])



                        <li class="@if(Route::currentRouteName()=="seo_setting") {{ "active"  }} @endif">

                            <a href="{{ route('seo_setting') }}">

                                <i class="menu-icon fa fa-list"></i>



                                Seo Settings





                            </a>



                            <b class="arrow"></b>



                        </li>

                    @endcan

                    @can('menu_auth', ["Discounts Codes"])

                        <li class="@if(Route::currentRouteName()=="discounts.index") {{ "active"  }} @endif manage_discount">

                            <a href="{{ route('discounts.index')}}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Discounts Codes

                            </span>



                            </a>

                        </li>

                    @endcan







                    @can('menu_auth', ["Pages"])

                        <li class="@if(Route::currentRouteName()=="pages.index"){{ "active"  }} @endif">

                            <a href="{{ route('pages.index') }}">

                                <i class="menu-icon fa fa-cogs"></i>

                                <span class="menu-text">

                               Text Pages

                            </span>



                            </a>

                        </li>

                    @endcan

                    @can('menu_auth', ["Faqs"])

                        <li class="@if(Route::currentRouteName()=="faqs.index") {{ "active"  }} @endif">

                            <a href="{{ route('faqs.index') }}">

                                <i class="menu-icon fa fa-cogs"></i>

                                <span class="menu-text">

                              Frequently Ask Questions

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Banners"])

                        <li class="@if(Route::currentRouteName()=="banner_list") {{ "active"  }} @endif">

                            <a href="{{ route('banner_list')  }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                            Banners

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Reviews"])



                        <li class="@if(Route::currentRouteName()=="reviews ") {{ "active"  }} @endif">

                            <a href="{{ route('reviews.index') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                          Reviews

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Analytics Settings"])

                        <li class="@if(Route::currentRouteName()==" ") {{ "active"  }} @endif">

                            <a href="{{ route("analytics_setting") }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                    Site Analytics

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Social Settings"])

                        <li class="@if(Route::currentRouteName()=="social_setting") {{ "active"  }} @endif">

                            <a href="{{ route('social_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Social Settings

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Supportticket"])

                     <!--   <li class="@if(Route::currentRouteName()=="myticket") {{ "active"  }} @endif">

                            <a href="{{ route('myticket') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                          Supportticket

                            </span>



                            </a>

                        </li>-->

                    @endcan





                    @can('menu_auth', ["General Settings"])

                        <li class="@if(Route::currentRouteName()=="general_setting") {{ "active"  }} @endif">

                            <a href="{{ route('general_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                General Settings

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Footer Settings"])

                        <li class="@if(Route::currentRouteName()=="footer_setting") {{ "active"  }} @endif">

                            <a href="{{ route('footer_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Footer Settings

                            </span>



                            </a>

                        </li>

                    @endcan





                    @can('menu_auth', ["Homepage Settings"])

                        <li class="@if(Route::currentRouteName()=="homepage_setting") {{ "active"  }} @endif">

                            <a href="{{ route('homepage_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Homepage Settings

                            </span>



                            </a>

                        </li>

                    @endcan



                    @can('menu_auth', ["Service Pages Settings"])

                        <li class="@if(Route::currentRouteName()=="services_page_setting") {{ "active"  }} @endif">

                            <a href="{{ route('services_page_setting') }}">

                                <i class="menu-icon fa fa-clipboard-list"></i>

                                <span class="menu-text">

                                Service Pages Settings

                            </span>



                            </a>

                        </li>

                    @endcan



                </ul>

            </li>

        @endcan



        @can('menu_auth', ["Bussiness Portal"])

          <!--  <li class="">

                <a href="#" class="dropdown-toggle">

                    <i class="menu-icon fa fa-building"></i>

                    <span class="menu-text"> Bussiness Portal</span>



                    <b class="arrow fa fa-angle-down"></b>

                </a>



                <b class="arrow"></b>



                <ul class="submenu">





                    <li class="@if(Route::currentRouteName()=="agent.index") {{ "active"  }} @endif">

                        <a href="{{ route('agent.index') }}">

                            <i class="menu-icon fa fa-cogs"></i>

                            <span class="menu-text">

                         Supplier Agents

                            </span>



                        </a>

                    </li>





                </ul>

            </li>-->

        @endcan

        @can('menu_auth', ["Ticektting System Support"])
            <li class="@if(Route::currentRouteName()=="myticket") {{ "open"  }} @endif ticketing_link">
                <a href="" class="dropdown-toggle">
                    <i class="menu-icon fa fa-newspaper-o"></i>
                    <span class="menu-text">Ticketing System </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="@if(Route::currentRouteName()=="myticket") {{ "active"  }} @endif">
                        <a href="{{ route('myticket') }}">
                            <i class="menu-icon fa fa-cogs"></i>
                            <span class="menu-text">
                                View Ticket
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @if($role->roles->role->name=="SuperAdmin")

        @can('menu_auth', ["Agents Booking"])

            <li class="@if(Route::currentRouteName()=="") {{ "active"  }} @endif">

                <a href="{{ url("/admin")}}">

                    <i class="menu-icon fa fa-plane"></i>

                    <span class="menu-text">

                            Agents Bookings

                            </span>



                </a>

            </li>

        @endcan

        @endif
@else
    <li class="@if(Route::currentRouteName()=="agent_bookings") {{ "active"  }} @endif">
    
        <a href="{{ url("/admin/agent_bookings")}}">

            <i class="menu-icon fa fa-plane"></i>

            <span class="menu-text">

                    Agents Bookings

                    </span>



        </a>

    </li>
@endif


    </ul><!-- /.nav-list -->



    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">

        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"

           data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>

    </div>

</div>