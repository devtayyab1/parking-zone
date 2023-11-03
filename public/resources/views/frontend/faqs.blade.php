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

    <div class="home-container home-background">
      @include('layouts.nav')
    </div>

<style type="text/css">
@media (min-width: 768px){
.margintop72 .passenger-detail {
    margin-left: 0px;
    width: 100%;
    padding: 10px
}
}
.passenger-detail h3 {
    padding: 10px 20px;
    line-height: 1.6;
   background: linear-gradient(to right, #fa9e1b, #8d4fff);
    color: #fff;
}
.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
}
#faqshover a:hover{
    color: #F99F03;
}
.passenger-detail h1 {
    font-size: 25px;
    background: #624a8e !important;
     padding: 0 20px;
    line-height: 1.6;
    background: linear-gradient(to right, #fa9e1b, #8d4fff);
    color: #fff;
    font-weight: 600;
}
@media (max-width: 768px){
    .margintop72 .panel {
        margin-left: 0px;
    }
}
</style>

    <section class="top-offer margintop72" style="top:40px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail">
                            <h1 class="light-weight">Frequently Ask Questions</h1>
                            <div class="well-body">
                                @foreach($faqs as $type=>$faq)
                                    <div class="accordion" id="accordion{!! $type !!}">
                                        <h3 class="light-weight">{!! $type !!}</h3>
                                        @foreach($faq as $item)
                                            <div class="accordion-group">
                                                <div class="accordion-heading" id="faqshover">
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
@endsection
