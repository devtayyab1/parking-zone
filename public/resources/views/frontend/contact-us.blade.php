@extends('layouts.main')



@section('content')



<style>
    .customers{
        color: #fff;
        font-weight: 700;
        font-size: 35px;
        text-align: center;
        z-index: 10 !important;
        padding: 50px 0px;
    }
    .top-listitem li{
        color: #000;
        font-size: 15px;
        list-style: none;
    }
    .alert-info {
        color: #ffffff !important;
        background-color: #1773b9 !important;
        border-color: #1773b9 !important;
    }
    #js_contact-form{
        /* border: 2px solid #1773b9; */
        padding: 25px;
        border-radius: 15px;
        /* box-shadow: 1px 1px 20px 0px; */
    }
    label {
        display: inline-block;
        color: #000;
        padding-top: 15px;
    }
    .anchr-links a{
        text-decoration: none;
        color: #000;
        font-weight: 600;
    }
    .btn-warning {
        color: #fff !important;
        background-color: #1773b9 !important;
        border-color: #06a0ff !important;
    }
    .btn-warning:hover {
        color: #fff  !important;
        background-color: #06a0ff !important;
        border-color: #06a0ff !important;
    }
    .btn-yellow{
        color: #fff !important;
        background-color: #1773b9 !important;
        border-color: #06a0ff !important;  
    }
     .btn-yellow:hover{
        color: #fff  !important;
        background-color: #06a0ff !important;
        border-color: #06a0ff !important; 
    }
    .sidebar-style{
        background-color: #1773b9;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid #000;
    }
    .sidebar-style strong p{
        color: #fff;
        text-align: center;
        font-weight: 600;
    }
    .white-text{
        color: #fff;
        padding-top: 15px;
    }
    .btn-yellow2{
        color: #fff !important;
        background-color: #000 !important;
        border-color: #06a0ff !important;
        margin-top: 20px !important;
        display: block;  
        margin: auto;
    }
     .btn-yellow2:hover{
        color: #fff !important;
        background-color: #000 !important;
        border-color: #06a0ff !important; 
        transform: scale(1.1);
        transition: .8s;
    }

    .panel{
        box-shadow:none;
    }
</style>

    <div class="home-container home-background">



       @include("frontend.header")





    </div><!-- end home-container -->


    <section class="top-offer " style="margin-top: 93px;">
        <div class="container">
                <br>
                <br>
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail">
                            <div class="well-body">
                                <!--form start---->
                                <div class="row">
                                        <div id="parent">
                                            @if(session()->has('success_message'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('success_message') }}
                                                </div>
                                            @endif
                                                <form id="js_contact-form" action="{{route('contact-us-submit')}}" class="contact-form" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                                        
                                                    <div class="row">

                                                    <div class="col-xs-12 col-md-2">
                                                        <div class="form-group">
                                                            <label>Title<span class="required-field">*</span></label>
                                                            <select class="form-control" id="name-title" name="title">

                                                            <option value="Mr">Mr</option>

                                                            <option value="Ms">Ms</option>

                                                            <option value="Miss">Miss</option>

                                                            <option value="Mrs">Mrs</option>

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="col-xs-12 col-md-5">
                                                        <div class="form-group">
                                                            <label>First Name<span class="required-field">*</span></label>
                                                            <input type="text" class="form-control" name="firstname" placeholder="Name" required="" autofocus="">
                                                        </div>

                                                    </div>
                                                    <div class="col-xs-12 col-md-5">
                                                        <div class="form-group">
                                                            <label>Last Name <span class="required-field">*</span></label>
                                                            <input type="text" class="form-control" name="lastname" placeholder="Last Name" required="" autofocus="">
                                                        </div>

                                                    </div>
                                                </div>
                                                    <div class="row marginrightleft0">
                                                        <div class="col-xs-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Email<span class="required-field">*</span></label>
                                                                <input type="email" class="form-control" name="email" placeholder="Email" required="">

                                                            </div>

                                                        </div>

                                                        <div class="col-xs-12 col-md-6">
                                                            <div class="form-group">
                                                                <label> Phone no. <span class="required-field">*</span></label>

                                                                <input type="text" class="form-control" name="phone" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" maxlength="10" placeholder="Mobile No." required="">

                                                            </div>

                                                        </div>

                                                    
                                                        <div class="clearfix"></div>
                                                    </div>
                                                
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Message subject*</label>
                                                            <select class="form-control valid" name="subject" required="">
                                                                <option value="">Please select your message main subject</option>
                                                                <option value="Amend or cancel a booking">Amend or cancel a booking</option>
                                                                <option value="Re-send booking confirmation">Re-send booking confirmation</option>
                                                                <option value="New booking enquiry">New booking enquiry</option>
                                                                <option value="General enquiry">General enquiry</option>
                                                                <option value="Change email or postal address details">Change email or postal address details</option>
                                                                <option value="Marketing/PR enquiry">Marketing/PR enquiry</option>
                                                                <option value="Make a complaint">Make a complaint</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Message <span class="required-field">*</span></label>
                                                            <textarea class="form-control textarea-contact ckeditor" required="" rows="10" id="comment" name="message" value="" style="height: 100px;" placeholder="Type Your Message/Feedback here..."></textarea>

                                                        
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="clearfix"></div>

                                                    <div class="col-xs-12 ">
                                                        <br>

                                                        <button type="submit" class="btn btn-yellow btn-font-size">Send</button>
                                                    </div>

                                                </form>
                                                
                                            </div>                                                   

                                        </div>
                                <!----end-->
                                </div>
                                <div class="row">
                                       
                                                <h3 style="margin-top: 15px;">How Can We Help You?</h3>

                                                <p style="text-align: justify; padding-right: 14%;">We are here to help you to make your Booking as simple as possible. <br> To Amend or

                                                    cancel your reservation please  email us, or call Customer Service.<br> Answers to most of your questions can

                                                    be found on the F.A.Q. page.</p>

                                                <h3>Customer Service Hours</h3>
                                                <br>
                                                <p style="text-align: justify; padding-right: 14%;">Monday-Friday  (9AM-5PM)<br> 
                                                <strong>Phone</strong>: {{ $settings["footer_phone_no"] }}<br>

                                                    <strong>Email</strong>: <a href="mailto:{{ $settings["footer_email"] }}">{{ $settings["footer_email"] }}</a><br>

                                                    <strong>Address</strong>: {{ $settings["footer_address"] }}</p>

                                                <p><strong>Company Registration Number</strong>: {{ $settings["footer_company_reg_no"] }}</p>

                                                <p>&nbsp;</p>

                                                <p>&nbsp;</p>

                                                <p>&nbsp;</p>
                                        
                                <!----end-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="hidden-xs hidden-sm col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        @include("frontend.right_searchbar")
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- end innerpage-wrapper -->

@endsection



