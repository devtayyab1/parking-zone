@extends('layouts.main')
@section("title",$page->meta_title)
@section("meta_keyword",$page->meta_keyword )
@section("meta_description",$page->meta_description)
@section('content')
<style type="text/css">
    .bg-grey-margin {
    margin-top: 57px;
    margin-right: 63px;
    margin-bottom: 63px;
    padding: 40px;
    margin-left: 63px;
    background-color: white;
    box-shadow: 2px 2px 14px 6px #5f5f5f42;
}
 @media (max-width: 768px)
{
.bg-grey-margin {
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    padding: 10%;
    margin-left: 0px;
}
}
.intro{
	margin-top: 100px;
}
</style>

    <style type="text/css">
        @media only screen and (max-width: 575px){
            .intro {
                width: 100%;
                padding-top: 15px;
                padding-bottom: 15px;
            }
        }
        .manage_boking{
            margin-top: 10px; color:#000; font-weight: 600;    font-size: 35px;
            padding-bottom: 10px;
        }
    </style>

      <div class="home-container home-background">

          @include("frontend.header")


    </div><!-- end home-container -->

    <div class="intro">
    <div class="container ">
        <div class="row" >
         
            
      

 
        
        <div class="inr-cnt  col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <!------starting contact us ------->


            <!--form start---->
            <div class="">

                <h1 class="text-left manage_boking">Booking Summary</h1>

                    @if (!$errors->isEmpty())

                           <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                    @endif


                <div id="parent">
                    <form id="js_contact-form" action="{{ route("booking_search") }}" class="contact-form" method="post"
                          enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label style="color:#000;">Booking Reference No.<span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="ref_no" name="ref_no"
                                       placeholder="PZ-XXXXXXXXX" required="" value="{{ Input::old("ref_no") }}"
                                       autofocus=""
                                       style="/*background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;)*/; background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; border:1px solid #000">
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label style="color:#000;">Last Name <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       placeholder="last Name" required="" value="{{ Input::old("last_name") }}"
                                       autofocus="" style="border: 1px solid #000">
                            </div>

                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label style="color:#000;">Email Address <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="email" name="email"
                                       placeholder="email" required="" value="{{ Input::old("email") }}"
                                       autofocus="" style="border: 1px solid #000">
                            </div>

                        </div>
</div>


                        <div class="col-xs-12">
                            <button type="submit" name="submit" class="btn btn-yellow"> Submit </button>
                        </div>

                    </form>

                </div>


            </div>
            <!----end-->

        </div>
          <div class="hidden-xs hidden-sm col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    @include("frontend.right_searchbar")


                </div>
            </div>

        <div class="clearfix"></div>


    </div>
</div>
<script type="text/javascript">
window.scroll({
 top: 0, 
 left: 0
});
	

</script>
@endsection
@section("footer-script")

@endsection