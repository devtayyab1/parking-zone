@extends('layouts.main')
@section("title",$page->meta_title)
@section("meta_keyword",$page->meta_keyword )
@section("meta_description",$page->meta_description)
@section('content')
<style>
.sb-serc a {
    width: 100%;
    margin-left: 0;
}
.sb-serc h4{
        font-size: 20x !important;
}
.sb-serc p{
    font-size: 13px !important;
    line-height: 20px !important;
}
.sb-serc a{
        margin-top: 20px !important;
}
.btn-submit{
    display: none;
}
</style>


    <div class="home-container home-background">

      @include("frontend.header")


    </div>
    <div class="container">
    	<!-- end home-container -->
    	{!! $page->content !!} 
    </div>
    

@endsection