@extends('layouts.main')
@section("stylesheets")
    <link property="stylesheet" rel='stylesheet'
          href='{{ secure_asset("assets/page.css") }}' type='text/css'
          media='all'/>
@endsection
@section("title",$page->meta_title)
@section("meta_keyword",$page->meta_keyword )
@section("meta_description",$page->meta_description)
@section('content')
<style type="text/css">
.section-padding {margin-right: 60px;margin-left: 60px;}
@media only screen and (max-width: 575px){.section-padding {padding: 10px; margin: auto;}}
.search {top: 0px;}
#services {margin: auto;padding: 0px 10%;}
.home_slider_content {position: absolute;top: 50%;left: 50%;z-index: 11;}
.home_slider_content h1:nth-child(1) {font-size: 31px;color: #ffffff;margin-top: 116px;margin-left: 415px;font-family: sans-serif;}
@media  screen and (min-width:768px) and (max-width:991px){.sb-serc {background: #31124b !important; height: 530px !important;}}
</style>
    <div class="home-container home-background">
        @include("frontend.header")
    </div>
    <div class="home">
        <div class="home_slider_container">
            <div class="owl-carousel owl-theme home_slider">
                 @foreach($sliders as $slider)
                    <!-- Slider Item -->
                    <div class="owl-item home_slider_item">
                        <div class="home_slider_background" style="background-image:url('{{$slider}}"></div>
    
                        <div class="home_slider_content text-center">
                            <div class="home_slider_content_inner" data-animation-in="flipInX" data-animation-out="animate-out fadeOut">
                           
                                <h1>Parking Types</h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include("layouts.search_form")
        </div>
    </div>
    {!! $page->content !!}
@endsection