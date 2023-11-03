@extends('layouts.main')

@section('content')
    <div class="home-container home-background">

        @include("frontend.header")


    </div>

    <section id="error-page" class="innerpage-wrapper" style="/*margin-top: 110px;*/">
<img src="{{ secure_asset("assets/images/404.jpg") }}" class="img-responsive">
        <!-- <div id="error-text" class="innerpage-section-padding">
            
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <h1 id="code">4<span><i class="fa fa-frown-o"></i></span>4</h1>
                        <p>Page Not Found</p>

                        <div class="butn text-center">
                            <a href="{{ route("main") }}" class="btn btn-padding btn-yellow">Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </section>
@endsection
