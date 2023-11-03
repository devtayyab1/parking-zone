<link rel="stylesheet" type="text/css" href="theme/styles/offers_styles.css">
<link rel="stylesheet" type="text/css" href="theme/styles/offers_responsive.css">
@include('layouts.header')
@include('layouts.nav')

    <!-- Search -->

    <!-- Bootstrap Stylesheet -->

    <!-- Flex Slider Stylesheet -->




    <style type="text/css">
        .review-block-description {
            border: 1px solid #eee;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        /*loader*/
        .spiner_container{width: 100%; text-align: center; margin-top: 20px; margin-bottom: 20px;}
        .lds-dual-ring {
          top:200px;
          display: inline-block;
          width: 100px;
          height: 100px;
        }
        .lds-dual-ring:after {
          content: " ";
          display: block;
          width: 100px;
          height: 100px;
          margin: 1px;
          border-radius: 50%;
          border: 10px solid#fa9e1b;
          border-color:#fa9e1b transparent #fa9e1b transparent;
          animation: lds-dual-ring 1.2s linear infinite;
        }
        
        @keyframes lds-dual-ring {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
        .selected-room-features.list-unstyled{
          padding-top: 10px;
        }
        .room-features{margin-top:0px !important;}
        ul li{margin-bottom:5px !important;}
        .logo-figure{margin-left:0px !important;}
        #Resultofsearchbar{margin-bottom: 30px !important;}
        .room-info{padding-top: 7px;}
        .score {margin-top: 20px !important;}
        .scheme_default button:hover{background-color: unset;}
        #myModal1 ul li{margin-bottom: -2px !important;}
        
        .scheme_default button{background: #15202a; }
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{background: #f8a031 !important; color: #fff;}
        .room-info .room-features li .fa{border-radius: 5px !important; background: #484848 !important;}
        .search_tabs_container {
    position: relative;
    top: -40px;
    /* width: 100%; */
  
}
.scheme_default button:hover {
  opacity: 1;
    background-color: #f99d1e;
}
.scheme_default button {
    background: #4c256e;
}
@media (min-width: 992px)
	.search_button {
	        margin-top: -33px;
	}
}
@media screen and (min-width: 1400px) {
 .search_button {
	        margin-top: -33px;
	}
}
@media screen and (min-width: 1600px) {
  .search_button {
	        margin-top: -10px;
	}
}
@media screen and (min-width: 1700px) {
  .search_button {
	        margin-top: -33px;
	}
}
@media screen and (min-width: 1900px) {
  .search_button {
	        margin-top: -33px;
	}
}
.popup1 {
		    background-color: #055988;
                border: 5px solid;
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              padding: 10px;
              z-index: 100;
            }
    </style>

    <div class="home-container home-background">


{{session()->get('bk_src')}}
    </div>

    <!-- end home-container -->

    <div id="ajax_search_results">
        <div class="spiner_container" style="margin-bottom:400px">
            <div class="popup1" style="width:500px;height:238px;">
                <ul class="list list-unstyled text-left p-5">
                    <li style="font-size: 23px;color:white"><span style="opacity: 1;"><i class="fa-sharp fa-solid fa-circle-check" style="color: rgb(246, 171, 47)"></i>
                    Contacting suppliers
                  </span></li>
                  <li style="font-size: 23px;color:white"><span style="opacity: 1;"><i class="fa-sharp fa-solid fa-circle-check" style="color: rgb(246, 171, 47)"></i>
                    Checking availability
                  </span></li>
                  <li style="font-size: 23px;color:white"><span style="opacity: 1;"><i class="fa-sharp fa-solid fa-circle-check" style="color: rgb(246, 171, 47)"></i>
                    Finding the best prices
                  </span></li>
                  <li style="font-size: 23px;color:white"><span style="opacity: 1;"><i class="fa-sharp fa-solid fa-circle-check" style="color: rgb(246, 171, 47)"></i>
                    Applying quality score
                  </span></li>
                </ul>
            </div>
            </div>
    </div>
        <!-- </nav> -->

            @include('layouts.footer')


        <script type="text/javascript"></script>

            <script type="text/javascript">

                $('#preloader').show();
                // A $( document ).ready() block.
$( document ).ready(function() {

      //     $( "body" ).click(function( event ) {
      //         var domAttr = event.target.id;
      //         if(domAttr === 'startDate' || domAttr === 'endDate'){
      //             // removeCalendar('cal');
      //             createElementWithClass('div', 'cal')
      //         } else {
      //           removeCalendar('cal');
      //         }
      // });

   


  // $(document).on('click', function(){
  //   var dom = $(this);
  //   console.log(dom);
  //   // removeCalendar('cal')
  // });

                var ajdata = {};

                ajdata['airport_id'] = '{{ request()->airport_id }}';
                ajdata['dropoffdate'] = '{{ request()->dropoffdate }}';
                ajdata['dropoftime'] = '{{ request()->dropoftime }}';
                ajdata['departure_date'] = '{{ request()->departure_date }}';
                ajdata['pickup_time'] = '{{ request()->pickup_time }}';
                ajdata['promo'] = '{{ request()->promo }}';
                ajdata['promo2'] = '{{ request()->promo2 }}';
                ajdata['src'] = '{{ request()->src }}';

                $.ajax(
                {
                    url: '{{ route("searchresult") }}',
                    type: "POST",
                    data: ajdata
                    //datatype: "html"
                }).done(function(data){
                    $("#ajax_search_results").empty().html(data);
                    $('.spiner_container').hide();
                    $('#to-top').click();
                    //location.hash = page;
                }).fail(function(jqXHR, ajaxOptions, thrownError){
                      $('.spiner_container').hide();
                      //alert('No response from server');
                      console.log('No response from server');
                });
                    console.log( "ready!" );
})

            </script>

            <script type="text/javascript">
                $("a.apply-active").on('click', function () {
                    $('li.active').removeClass('active');
                   // $(this).closest("li.active").removeClass('active');
                    $(this).closest("li").addClass('active');


                    $(".tab-pane").hide();
                    $($(this).attr("href")).show();
                });
            </script>
