<style>
    .phone a{
        color: #fff !important;
        font-size: 18px;
    }
        .phone a:hover{
        color: #fff !important;
        font-size: 18px;
    }
    .fa{
        
        font-size: 21px;
    margin-right: 6px;
    }
    .user_box_link a {
    font-size: 14px;
    }
    .top_bar-sticky{
        background-color: #340A4D;
    }
    @media only screen and (max-width: 600px){
        .top_bar-sticky{
            display: none;
        }
    }
    /*dl, ol, ul {
        margin-bottom: 0rem !important;
    }
    .btn-warning {
        padding-top: 1px !important;
    }
    a:hover {
        color: #340a4d !important;
        text-decoration: none !important;
    }*/
    @media only screen and (max-width: 991px){
        .hamburger{
            display: block !important;
        }  
    }   
    
    .menu_close_container{
        top: 8px;
        right: 20px;
    }
    .user_box_link a{
        line-height: 25px;
    }
   
    @media screen and (min-width:991px) and (max-width:1200px){
        .btn-white-zmd{
            margin-left: 0px;
        }
        .main_nav_item{
             margin-right: 6px;
        }
        .logo a img{
            width: 153px;
        }
    }
    .menu.active .mble-menu {
    width: 100%;
}
.menu.trans_500.active {
    margin-top: 54px;
}

@media screen and (min-device-width: 331px) and (max-device-width: 574px) { 
        .menu.trans_500.active {margin-top: 61px;}
        }
        
.menu.trans_500 {
    background:#624A8E !important
}
.menu.active {
    opacity: 5.95 !important;
}

    @media screen and (min-device-width: 371px){ 
        #myDropdown{margin-left: 32%;}
        }
    @media screen and (min-device-width: 278px) and (max-device-width: 370px) { 
        #myDropdown{margin-left: 6%;}
        }
@media only screen and (max-width: 991px) {
  .btn-white-zmd {
    display:none;
  }
  .main_nav_container{
      display:none;
  }
  .search_button{
      border-radius:0px !important;
  }
}
    .btn-white-zmd{
        /*float: right;*/
        background-color: #F79F02;
        border-radius: 10px;
        color: #ffffff !important;
        font-weight: 500;
        padding: 4px 10px;
        margin-top: -4px;
        font-size: 15px;
        margin-left: 10px;
        width:130px;
    }
    
    .btn-white-zmd:hover{
        color: #fff;
        text-decoration: none;
    }
    .main_nav_item {
        position: relative;
        display: inline-block;
        margin-right: 15px;
    }
    .btn-white-zmd:hover {
        color: #fff !important;
        text-decoration: none;
        background-color: #340a4d;
    }
    @media screen and (min-width:991px) and (max-width:1200px){
        .btn-white-zmd{
            margin-left: 0px;
        }
        .main_nav_item{
             margin-right: 6px;
        }
        .logo a img{
            width: 153px;
        }
    }
    .main_nav_col{
        height: 80px;
    }
    .main_nav_item a{
            font-weight: bold;
            font-size: 16px;
                padding-bottom: 7px;
    padding-top: 6px;
    color:black;
    }
    @media only screen and (min-width: 1400px){ 
     .margin-ul{
        margin-right: 80px;
    }
    }
     @media only screen and (min-width: 1101px){ 
     .margin-ul{
        margin-top: 21px;
    }
    }
   
    @media screen and (min-device-width: 992px) and (max-device-width: 1363px) { 
    .margin-ul{margin-right: 0px !important;}
    .main_nav_item a {font-size: 14px;}
    }
    @media screen and (min-device-width: 992px) and (max-device-width: 1363px) { 
    .main_nav_container {
    margin-right: 0px !important;
}
    }
    .logo-margin{
        margin-left: 80px ;
    }
    @media only screen and (max-width: 1363px){ 
    .logo-margin{margin-left: 0px;}
    }
     .logo-margin-img{
         width: 278px !important;
         height: 34px !important;
    }
    @media screen and (min-device-width: 992px) and (max-device-width: 1203px) { 
    .logo-margin-img{ width: 220px !important;}
    }
    @media only screen and (max-width: 312px) {
          .logo-margin-img{ width: 196px !important;}
        }
        .dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover{
            background-color:#F79F02 !important;
        }
</style>
    <header class="header">

        <!-- Top Bar -->
        <!--    <div class="top_bar-mob">-->
        <!--    <div class="container">-->
        <!--        <div class="row">-->
        <!--            <div class="col d-flex flex-row">-->
        <!--                <div class="phone">-->
        <!--                    <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+442045114174">020 4511 4171</a>-->
        <!--                </div>-->
        <!--                <div class="user_box_register user_box_link">-->
        <!--                    <a href="{{url('manage-booking')}}">Manage Booking  &nbsp  &nbsp  &nbsp  &nbsp </a>-->
        <!--                </div>-->
        <!--                <div class="user_box ml-auto">-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>      -->
        <!--</div>-->


       <!--  <div class="top_bar-sticky">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row" style="padding-right: 0px; padding-left: 0px;">
                        <div class="user_box mr-auto">
                           
                            <div class="user_box_register user_box_link">Get Up To <b> 30% Off </b>Airport Parking</div>
                             
                        </div>

                       {{--    <form id="subscribe_user" action="{{ route("subscribe_user") }}" method="post">
                        @csrf

                        <div class="form-group"> 
                            
                            <div class="input-group">
                                
                              <div class="subscription-form">
                                <input id="subscribe_user_name" name="name" type="hidden"
                                       style=""
                                       class="form-control input-lg" value="user Email" placeholder="Enter Your Name" required/>
                                <input id="subscribe_user_email" name="email" type="email" style=""
                                       class="form-control input-lg email" style="font-size: 8px" placeholder="Your Email Address" required/>
                         

                                <span class="input-group-btn">
                                 <button id="subscribe_user" class=" order " style=" ">JOIN NOW</button></span>
                              </div>
                            </div>
                        </div>
                        
                    </form> --}}
                    <form class="form-inline" id="subscribe_user" action="{{ route("subscribe_user") }}" method="post">
                    {{-- <form class="form-inline"> --}}
                      @csrf
                      <input id="subscribe_user_name" name="name" type="hidden"
                                       style=""
                                       class="form-control input-lg" value="user Email" placeholder="Enter Your Name" required/>

                      <div class="form-group">
                        <label for="staticEmail2" class="sr-only">Email</label>
                        <input type="email" name="email" id="subscribe_user_email" placeholder="Your Email Address" class="form-control"  >
                      </div>
                      {{-- <div class="form-group mx-sm-3 mb-2">
                        <label for="inputPassword2" class="sr-only">Password</label>
                        <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
                      </div> --}}
                      <button id="subscribe_user" class="btn btn-warning order join-now-zee">JOIN NOW</button>
                      <div id="error_message"></div>
                    </form>
                    </div>
                </div>
            </div>      
        </div> -->

        <!-- Main Navigation -->

        <nav class="main_nav">
            <div class="container-fluid">
                <div class="row">
                    <div class="col main_nav_col d-flex flex-row align-items-center justify-content-start">
                        <div class="logo_container">
                            <div class="logo logo-margin"><a href="{{url('/')}}"><img class="logo-margin-img" src="{{url('theme/images/logo.webp')}}" alt="Parking zone logo"></a></div>
                        </div>
                        <div class="main_nav_container ml-auto">
                      
                             <ul class="main_nav_list margin-ul">

                    <li class="main_nav_item active"><a href="{{ route("main") }}" class="" >Home</a></li>

                    <li class="main_nav_item dropdown"><a href="#" class="dropdown-toggle airport_pages_nav" data-toggle="dropdown">Airport Parking<span></span></a> 

                    <ul class="dropdown-menu">

                    	<li class="dropdown-item"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick Airport Parking</a></li>
                    	<li class="dropdown-item"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"aberdeen-airport-parking"]) }}">Aberdeen Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham Airport Parking</a></li>
                        
                         <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"bournemouth-airport-parking"]) }}">Bournemouth Airport Parking</a></li>
                         
                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"bristol-airport-parking"]) }}">Bristol Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"cardiff-airport-parking"]) }}">Cardiff Airport Parking</a></li>
                        
                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"doncaster-airport-parking"]) }}">Doncaster Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"east-midlandsairport-parking"]) }}">East Midlands Airport Parking</a></li>

                        <li class="dropdown-item black"><a class="main_nav_item-color"  href="{{ route("page",["slug"=>"glasgow-airport-parking"]) }}">Glasgow Airport Parking</a></li>

                        <!-- @if(count($airports) > 9)

                        <li class="dropdown-item black"><a class="main_nav_item-color" style=" text-align:center" href="{{ route("airports") }}"> {{ count($airports)-9 }} More Choices </a></li>

                        @endif -->

                    </ul>
<!--                     <li class="main_nav_item"><a href="#" class="dropdown-toggle airport_types_nav" data-toggle="dropdown">Parking Types</a>
                    
                        <ul class="dropdown-menu">
    
                            <li class="dropdown-item"><a class="main_nav_item-color"  href=" {{ route("airport_types") }}">Meet & Greet</a></li>
    
                            <li class="dropdown-item black"><a class="main_nav_item-color"  href=" {{ route("airport_types") }}">Park & Ride</a></li>
    
                            <li class="dropdown-item black"><a class="main_nav_item-color"  href=" {{ route("airport_types") }}">On Airport</a></li>
                        </ul>
                    </li>

                    <li class="main_nav_item"><a href="{{ route("faqs") }}" class="" >FAQ</a></li>

                 {{--   <li class="main_nav_item "><a href="{{ route("static_page",["page"=>"terms-and-conditions"]) }}" class="" >Terms & condition</a></li> --}} -->
              
                <li class="main_nav_item"><a href="{{ url("airport-types") }}" class="" >Parking Types</a></li> 
                 
                <li class="main_nav_item active"><a href="{{ route("faqs") }}" class="" >FAQS</a></li>
                <li class="main_nav_item active"><a href="{{ route("blogs") }}" class="" >Blogs</a></li>
                <!--<li class="main_nav_item"><a href="#" class="dropdown-toggle airport_types_nav" data-toggle="dropdown">Insights</a>-->
                    
                <!--    <ul class="dropdown-menu">-->

                <!--        <li class="dropdown-item"><a class="main_nav_item-color"  href="{{ route("faqs") }}">FAQS</a></li>-->

                        

                        
                <!--    </ul>-->
                <!--</li>-->
                <!--<li class="main_nav_item"><a href="{{ url("manage-booking") }}"  class="btn-white-zmd" >My Booking</a></li> -->
                <li class="main_nav_item"><a href="{{ route("support") }}"  class="btn-white-zmd" >Customer Support</a></li>  
                  

                    </li>


                </ul>

                        </div>
                 


                        <div class="hamburger  ml-auto">
                            <i class="fa fa-bars trans_200"></i>
                        </div>
                    </div>
                </div>
            </div>  
        </nav>

    </header>
        <div class="menu trans_500">
        <div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
            <!--<div class="menu_close_container"><div class="menu_close"></div></div>-->
            
         
               <ul class="mble-menu" style="margin-top: 28px !important;margin-bottom: 28px;">

                    <li class="menu_item active" style="border-bottom: 1px solid rgba(255, 255, 255);"><a href="{{ route("main") }}" class="" style="font-size: 16px;text-transform: uppercase;font-weight: 700;padding: 10px;">Home</a></li>

                     <li> <div class="dropdown" style="border-bottom: 1px solid rgba(255, 255, 255);">
                      <a onclick="myFunction()" class="dropbtn" style="font-size: 16px;text-transform: uppercase;font-weight: 700;padding: 10px;color:white">Airport Parking <i class="fa fa-solid fa-caret-down" style="color:white"></i></a>
                       <div id="myDropdown" class="dropdown-content" style="overflow-y:scroll; height:300px;">
                        <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"gatwick-airport-parking"]) }}">Gatwick Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"heathrow-airport-parking"]) }}">Heathrow Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"stansted-airport-parking"]) }}">Stansted Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"birmingham-airport-parking"]) }}">Birmingham Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"edinburgh-airport-parking"]) }}">Edinburgh Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"southampton-airport-parking"]) }}">Southampton Airport Parking</a>

                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"liverpool-airport-parking"]) }}">Liverpool Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"aberdeen-airport-parking"]) }}">Aberdeen Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"bournemouth-airport-parking"]) }}">Bournemouth Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"bristol-airport-parking"]) }}">Bristol Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"luton-airport-parking"]) }}">Luton Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"manchester-airport-parking"]) }}">Manchester Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"cardiff-airport-parking"]) }}">Cardiff Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"doncaster-airport-parking"]) }}">Doncaster Airport Parking</a>
                       
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"east-midlandsairport-parking"]) }}">East Midlands Airport Parking</a>
                       <a class="main_nav_item-color"  href="{{ route("page",["slug"=>"glasgow-airport-parking"]) }}">Glasgow Airport Parking</a>

                       <!-- @if(count($airports) > 9)-->

                       <!--<a class="main_nav_item-color" style=" text-align:center" href="{{ route("airports") }}"> {{ count($airports)-7 }} More Choices </a>-->

                       <!-- @endif                        -->
                        </div>
                      </div>
                  
                    <li class="menu_item" style="border-bottom: 1px solid rgba(255, 255, 255);"><a href=" {{ route("airport_types") }}" class="" style="font-size: 16px;text-transform: uppercase;font-weight: 700;padding: 10px;">Parking Types</a></li>

                    <li class="menu_item" style="border-bottom: 1px solid rgba(255, 255, 255);"><a href="{{ route("faqs") }}" class="" style="font-size: 16px;text-transform: uppercase;font-weight: 700;padding: 10px;">FAQ</a></li>

                 {{--   <li class="menu_item "><a href="{{ route("static_page",["page"=>"terms-and-conditions"]) }}" class="" >Terms & condition</a></li> --}}
              
                <li class="menu_item " style="border-bottom: 1px solid rgba(255, 255, 255);"><a href="{{ route("support") }}" class="" style="font-size: 16px;text-transform: uppercase;font-weight: 700;padding: 10px;">Customer Supports</a></li>
                    </li>
                </ul>
        </div>
    </div>
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show1");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show1')) {
        openDropdown.classList.remove('show1');
      }
    }
  }
}
</script>
<script></script>