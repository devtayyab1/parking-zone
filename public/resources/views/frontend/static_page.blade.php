@extends('layouts.main')
@section("title",$page->meta_title)
@section("meta_keyword",$page->meta_keyword )
@section("meta_description",$page->meta_description)
@section('content')

    <div class="home-container home-background">
        @include("frontend.header")
    </div>
<style type="text/css">
.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
}
@media    screen and (max-width: 768px){
    .well{
        padding: 0px;
    }
    .top-offer img{
        display: none !important;
    }
}
.passenger-detail h1 {
    font-size: 21px;
    background: #624a8e !important;
     padding: 0 20px;
    line-height: 1.6;
    background: linear-gradient(to right, #fa9e1b, #8d4fff);
    color: #fff;
    font-weight: 600;
}
.passenger-detail h3{
        font-size: 20px;
        border-radius: 0;
}
</style>
    <section class="top-offer margintop80" style="top:40px">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail bgbanner" style="padding: 20px">
                            <h1 class="light-weight">{{ $page->page_title  }}</h1>
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
@endsection

