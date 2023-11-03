@extends('layouts.main')
@section("stylesheets")
    <link property="stylesheet" rel='stylesheet'
          href='{{ secure_asset("assets/page.css") }}' type='text/css'
          media='all'/>
@endsection
@section('content')

    <div class="home-container home-background">

        @include("frontend.header")


    </div><!-- end home-container -->






    <section class="top-offer margintop72">


        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail">
                            <h3 class="light-weight">Frequently Ask Questions</h3>
                            <div class="well-body">


                                @foreach($faqs as $type=>$faq)
                                    <div class="accordion" id="accordion{!! $type !!}">
                                        <h3 class="light-weight">{!! $type !!}</h3>
                                        @foreach($faq as $item)


                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                                       data-parent="#accordion2" href="#collapse_{{ $item->id }}"
                                                       aria-expanded="false">
                                                        {!! $item->title !!}                </a>
                                                </div>
                                                <div id="collapse_{{ $item->id }}" class="accordion-body collapse"
                                                     aria-expanded="false" style="height: auto;">
                                                    <div class="accordion-inner">
                                                        {!! $item->content !!}                </div>
                                                </div>
                                            </div>


                                        @endforeach
                                    </div>
                                @endforeach


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
