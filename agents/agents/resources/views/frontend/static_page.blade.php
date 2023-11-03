@extends('layouts.main')

@section('content')

    <div class="home-container home-background">

        @include("frontend.header")



    </div><!-- end home-container -->






    <section class="top-offer margintop80">



        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail bgbanner">
                            <h3 class="light-weight">{{ $page->page_title  }}</h3>
                            <div class="well-body myclass1">
                                {!! $page->content; !!}
                            </div>
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

