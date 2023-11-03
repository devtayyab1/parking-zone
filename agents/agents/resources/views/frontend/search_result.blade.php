@extends('layouts.main')
@section("stylesheets")

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/bootstrap.min.css") }}" media="all">
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/style.css") }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/PlayfairDisplay.css") }}"
          media="all">
    <!-- Font Awesome Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/font-awesome.min.css") }}"
          media="all">

    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/yellow.css") }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/responsive.css") }}" media="all">
    <!-- Owl Carousel Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/owl.carousel.css") }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/owl.theme.css") }}" media="all">
    <!-- Flex Slider Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/flexslider.css") }}" media="all"
          type="text/css"/>
    <!--Date-Picker Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/datepicker.css") }}" media="all">
    <!-- Magnific Gallery -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/magnific-popup.css") }}" media="all">
    <!-- Color Panel -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset("assets/front/css/jquery.colorpanel.css") }}"
          media="all">
@endsection

@section('content')
    <style type="text/css">
        .review-block-description {
            border: 1px solid #eee;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        /*loader*/
        .spiner_container{width: 100%; text-align: center; margin-top: 20px; margin-bottom: 20px;}
        .lds-dual-ring {
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
          border: 10px solid #1f69b1;
          border-color: #1f69b1 transparent #1f69b1 transparent;
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
        .scheme_default h3{color: #fff !important;}
        .scheme_default button{background: #15202a; }
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{background: #1690d3 !important; color: #fff;}
        .room-info .room-features li .fa{border-radius: 5px !important; background: #484848 !important;}
    </style>
    <div class="home-container home-background">

        @include("frontend.header")


    </div>
    <!-- end home-container -->

    <div id="ajax_search_results">
        <div class="spiner_container"><div class="lds-dual-ring"></div></div>
    </div>

@endsection
        <!-- </nav> -->
        @section("footer-script")

            <script type="text/javascript">

                $('#preloader').show();

                var ajdata = {};

                ajdata['airport_id'] = '{{ request()->airport_id }}';
                ajdata['dropoffdate'] = '{{ request()->dropoffdate }}';
                ajdata['dropoftime'] = '{{ request()->dropoftime }}';
                ajdata['departure_date'] = '{{ request()->departure_date }}';
                ajdata['pickup_time'] = '{{ request()->pickup_time }}';
                ajdata['promo'] = '{{ request()->promo }}';
                ajdata['promo2'] = '{{ request()->promo2 }}';

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
            @endsection