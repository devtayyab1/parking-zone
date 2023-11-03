@include('layouts.header')
@include('layouts.nav')
    

    <!-- Home -->

    <div class="home">
        
        <!-- Home Slider -->

        <div class="home_slider_container">
            
            <div class="owl-carousel owl-theme home_slider">

                <!-- Slider Item -->
                <div class="owl-item home_slider_item">
                    <!-- Image by https://unsplash.com/@anikindimitry -->
                    <div class="home_slider_background" style="background-image:url('{{url('theme/images/home_slider.webp')}}"></div>

                    <div class="home_slider_content text-center">
                        <div class="home_slider_content_inner" data-animation-in="flipInX" data-animation-out="animate-out fadeOut">
                       
                            <h1><!--bestairport parking--></h1>
                        </div>
                    </div>
                </div>

     

                <!-- Slider Item -->
             

            </div>
            
            <!-- Home Slider Nav - Prev -->

            


            <!-- Home Slider Dots -->

         
            
        </div>

    </div>

    <!-- Search -->
@include('layouts.search_form')
 
<style type="text/css">
    .offers_item
    {
        padding: 5%;
        height: 480px;
        box-shadow: 1px -1px 19px 0px;
        border: 1px solid #4f2672;
        border-radius: 5px;
    }

     .offers_item:hover{
        transform: scale(1.05);
        transition: all .5s;
        z-index: 10;
     }

    .offers {
    /*top: -420px;*/
    width: 100%;
    /*padding-top: 90px;*/
    padding-bottom: 43px;
    background: #f3f6f9;
}
    .checked{
    color: #fa9e1b;
    font-size: 13px;
    }
    .unchecked{
    font-size: 13px;
    } 
    .offers_price h3{
        color: #000;
        font-weight: 600;
        font-size: 21px;
    }
</style>
    <div class="offers">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2 class="section_title">Blogs </h2>
                </div>
            </div>
            <div class="row offers_items">

                <!-- Offers Item --> 
                 @foreach($posts as $post)				
				  
				<div class="col-lg-4 col-md-6 offers_col">
					<div class="offers_item">
						<div class="row">
							<div class="col-lg-12">
								<div class="offers_image_container" style="height: 200px;">
									<a href='{{ url("blog/".$post->slug) }}'><div class="offers_image_background" style="background-image:url('{{ asset("storage/app/".$post->banner) }}')">
									</div></a>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="offers_content">
									<br>
									<div class="offers_price"><a href='{{ url("blog/".$post->slug) }}'><h3>{{ $post->page_title }}</h3></a></div>
									<p>{{$post->meta_description}}</p>
										
									<div class="offers_link"><a href='{{ url("blog/".$post->slug) }}'>read more</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
                 @endforeach
                <!-- Offers Item -->
            

            </div>
        </div>
    </div>
  
@include('layouts.footer')