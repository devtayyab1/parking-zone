@extends('layouts.main')

@section('content')

    <style>
        .th_class {
            background: #ffcb05;
        }

        .inner-section {
            background-color: #eff2f3;
            padding: 5px 0;
        }

        .passenger-detail h3 {
          
            padding: 10px 20px;
            line-height: 1.6;
            background:linear-gradient(to right,rgba(38, 154, 46, 0.9) 0,rgba(19, 111, 224, 0.9));
            color: #fff;
            border-radius: 5px;
        }

        #menu-tabs li {
            width: 100%;
            border: 1px solid #ccc;
        }

        .nav-tabs {
            border: 1px solid #ddd;
        }

        a:active {
            background: #1d9cbc;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {

            border: none !important;
            border-bottom-color: inherit !important;
            background: #16bbbb;

        }

        .bhoechie-tab-container {
            border: 1px solid #ccc;
            /* margin: -9px; */
            margin-top: 0px;
            margin-right: -9px;
            /* margin-bottom: -9px; */
            margin-left: -9px;
            padding: 0px;
        }

        .ap_page_content {
            padding-left: 19px;
        }

        .bhoechie-tab-menu {
            padding: 0px !important;
        }

        .inner-step i {
            border-radius: 50%;
            background: #ffcb05;
            color: #fff;
            padding: 23px;
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .inner-step i path {
            fill: #fff;
        }

        .inner-step i svg {
            width: 60px;
            display: table-cell;
            vertical-align: middle;
            height: 60px;
        }

        .inner-step h5 {
            font-weight: 800;
            margin: 30px 0px 10px;
            text-transform: uppercase;
            color: #ffcb05;
            font-size: 34px;
        }

        .hxComment li {
            list-style-type: none;
        }

        .sb-serc {
            text-align: center;
            background: url(assets/images/banner16.jpg);
            border: 4px solid #fff;
            float: left;
            width: 100%;
            margin: 0px 0px 20px 0px;
            /*   min-height: 305px;
            max-height: 305px;*/
            overflow: hidden;
            padding-top: 15px;
            border-radius: 15px;

        }

        .sb-serc a {
            margin: 5px 0px;
            float: left;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(to right,rgba(72, 205, 82, 0.9) 0,rgba(7, 33, 215, 0.9));
            /*color: #0e4060;*/
            color: #fff;
            margin-bottom: 20px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            border-radius: 4px;
        }

        .sb-serc p {
            font-size: 15px;
            line-height: 21px;
            overflow: hidden;
            padding: 0 10px;
            text-align: center;
            min-height: 127px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .accordion-style1 {

            background: url(assets/images/banner16.jpg);
        }

        .sub-serc .sb-serc p {
            min-height: 150px
        }

        .col-right-norm h2, h3, h4, h5 {
            font-size: 22px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 700;
        }

    </style>
    <div class="home-container home-background">

       @include("frontend.header")


    </div><!-- end home-container -->






    <section class="top-offer " style="margin-top: 93px;">


        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="panel passenger-detail">
                            <h3 class="light-weight">Contact Us</h3>
                            <div class="well-body">

                                <!--form start---->
                                <div class="row">
                                    <div class="col-sm-12" id="parent">

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Message subject*</label>
                                                <select class="form-control valid" name="subject" required="">
                                                    <option value="">Please select your message main subject</option>
                                                    <option value="Amend or cancel a booking">Amend or cancel a
                                                        booking
                                                    </option>
                                                    <option value="Re-send booking confirmation">Re-send booking
                                                        confirmation
                                                    </option>
                                                    <option value="New booking enquiry">New booking enquiry</option>
                                                    <option value="General enquiry">General enquiry</option>
                                                    <option value="Change email or postal address details">Change email
                                                        or postal address details
                                                    </option>
                                                    <option value="Marketing/PR enquiry">Marketing/PR enquiry</option>
                                                    <option value="Make a complaint">Make a complaint</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>

                                        </div>
                                        <div class="col-xs-12 col-md-2">
                                            <div class="form-group">
                                                <label>Title</label>
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
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="" placeholder="Name"
                                                       required="" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-5">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="" placeholder="Last Name"
                                                       required="" autofocus="">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group form_left">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="" placeholder="Email"
                                                       required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <label>Phone no.</label>
                                                <input type="text" class="form-control"
                                                       onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                       maxlength="10" placeholder="Mobile No." required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea class="form-control textarea-contact" rows="5" id="comment"
                                                          name="" placeholder="Type Your Message/Feedback here..."
                                                          required=""></textarea>
                                                <br>
                                                <button class="btn btn-default btn-send" style="    background-color: #30a2c7;
    border-radius: 4%;
    width: 15%;"> Send
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!----end-->
                                <h1>How Can We Help You?</h1>
                                <p>We are here to help you to make your Booking as simple as possible. <br> To Amend or
                                    cancel your reservation please  email us, or call Customer Service.<br> Answers to most of your questions can
                                    be found on the F.A.Q. page.</p>
                                <h2>Customer Service Hours</h2>
                                <p>Monday-Friday  (9AM-5PM)<br> <strong>Phone</strong>: {{ $settings["footer_phone_no"] }}<br>
                                    <strong>Email</strong>: <a href="mailto:{{ $settings["footer_email"] }}">{{ $settings["footer_email"] }}</a><br>
                                    <strong>Address</strong>: {{ $settings["footer_address"] }}</p>
                                <p><strong>Company Registration Number</strong>: {{ $settings["footer_company_reg_no"] }}</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
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

