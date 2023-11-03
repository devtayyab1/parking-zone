@extends('layouts.main')

@section('content')
      <div class="home-container home-background">

          @include("frontend.header")


    </div><!-- end home-container -->


    <section class="section bg-grey bg-grey-margin">
        <div class="row titlehead guide-head" >
            <h1 class="text-center">Booking Summary</h1>
        </div>



        <div id="overlay"></div>
        <div class="inr-cnt  col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!------starting contact us ------->


            <!--form start---->
            <div class="row">



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
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label>Booking Reference No.<span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="ref_no" name="ref_no"
                                       placeholder="AP-XXXXXXXXX" required="" value="{{ Input::old("ref_no") }}"
                                       autofocus=""
                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label>Last Name <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       placeholder="last Name" required="" value="{{ Input::old("last_name") }}"
                                       autofocus="">
                            </div>

                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label>Email Address <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="email" name="email"
                                       placeholder="email" required="" value="{{ Input::old("email") }}"
                                       autofocus="">
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

        <div class="clearfix"></div>

    </section>

@endsection
@section("footer-script")

@endsection