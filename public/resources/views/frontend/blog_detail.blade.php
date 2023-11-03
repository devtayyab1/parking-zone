@extends('layouts.main')
@section("title",$post->meta_title)
@section("meta_keyword",$post->meta_keyword )
@section("meta_description",$post->meta_description)
@section('content')

    <div class="home-container home-background">

        @include("frontend.header")



    </div><!-- end home-container -->


<style type="text/css">

.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    }
</style>



    <section class="top-offer margintop80" style="top:40px">



        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div class="panel passenger-detail bgbanner" style="padding: 20px">
						<h3 class="light-weight">{{ $post->page_title  }}</h3>
						@if(isset($post->banner))
							<img src='{{ asset("storage/app/".$post->banner) }}' alt="..." class="img-fluid">
						@endif
						<div class="well-body myclass1">
							{!! $post->content; !!}
						</div>
					</div>


                </div>


                <div class="hidden-xs hidden-sm col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    @include("frontend.right_searchbar")


                </div>
            </div>
        </div>


    </section>
    <!-- end innerpage-wrapper -->


@endsection

