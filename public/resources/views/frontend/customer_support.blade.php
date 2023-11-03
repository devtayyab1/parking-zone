<style>
    .txtcolorblack{
        color: #000;
        text-align: left !important;
        font-weight: 500;
        float: left;
    }
    .customer-hding{
        font-size: 2rem;
        font-weight: 600;
    }
    .existing-ticket{
        color:  #000;
        font-weight: 600;
    }
    .sec_customer_support_title{
        padding: 0 !important;
    }
    @media screen and (max-width:768px){
         .sec_customer_support{
            margin:  0px !important;
        }
        .sec_customer_support_title {
            padding: 13px 20px;
            margin-top: 7rem;
        }
    }
   .required-field{
    color: red;
   }
</style>

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

          
        @include("frontend.header")


    </div><!-- end home-container -->


    <section class="section bg-grey sec_customer_support" >
        <div class="row titlehead sec_customer_support_title">
            <h1 class="text-center customer-hding">Customer Support Help Desk</h1>
        </div>

        <div class="container">
            <div class="row">
				<div class="col-sm-12">
					<br>
					<ul class="feature-list-item">
						<li>In order to streamline support requests and better serve you, we utilize a support ticket
							system.
						</li>
						<li>Every support request is assigned a unique ticket number which you can use to track the progress
							and responses online.
						</li>
						<li>For your reference we provide complete archives and history of all your support requests.</li>
						<li>A valid <b>Email Address &amp; Booking Reference</b> is required to submit a support ticket.
						</li>
					</ul>

					<div class="alert alert-info text-center txt_alert">
						<strong>Important:</strong> ParkingZone  is a booking agent for the advertised car park. We do
						not collect, store or drive customers vehicle and we do not own a car park.
					</div>
					<div style="display:none;" class="alert alert-danger text-center">
						<strong>Alert!</strong></div>
				</div>
            </div>
        </div>

        <div id="overlay"></div>
        <div class="container">
        <div class="row">
        <div class="inr-cnt  col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <!------starting contact us ------->


            <!--form start---->
            <div class="">


                @if (!$errors->ticket_store->isEmpty())

                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->ticket_store->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif


                <div id="parent">
                    <form id="js_contact-form" action='{{ route("submit-ticket") }}' class="contact-form" method="post"
                          enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Booking Reference No.<span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="ref_no" name="ref_no"
                                       placeholder="AP-XXXXXXXXX" required="" value='{{ Input::old("ref_no") }}'
                                       autofocus=""
                                       >
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Full Name <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                       placeholder="Full Name" required="" value='{{ Input::old("full_name") }}'
                                       autofocus="">
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Email <span class="required-field">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                       required="" value='{{ Input::old("email") }}' autofocus="">
                            </div>

                        </div>
                    </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label>Contact No.<span class="required-field">*</span></label>
                                    <input type="number" class="form-control" id="contact" name="contact"
                                           value='{{ Input::old("contact") }}' placeholder="XXXXXXXXX" required=""
                                           autofocus="">


                                </div>

                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label>Support Department <span class="required-field">*</span></label>

                                    {{ Form::select('department',$departements_list,Input::old("department"),["class"=>"form-control","style"=>"width: 100%;font-size: 14px;", "Required"=>"required"]) }}


                                </div>

                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label>Ticket Priority <span class="required-field">*</span></label>

                                    {{ Form::select('priority',[""=>" Ticket Priority","Low"=>"Low","Medium"=>"Medium","High"=>"High"],Input::old("priority"),["class"=>"form-control","Required"=>"required","style"=>"width: 100%;font-size: 14px;"]) }}

                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group form_left">
                                    <label>Ticket Subject <span class="required-field">*</span> </label>
                                    <input type="text" class="form-control" id="subject" name="subject"
                                           placeholder="Subject" value='{{ Input::old("subject") }}' required="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>


                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Ticket Message <span class="required-field">*</span></label>
                                <textarea class="form-control textarea-contact ckeditor" required rows="10" id="message"
                                          name="message" value='{{ Input::old("message") }}'
                                          placeholder="Type Your Message/Feedback here..."
                                >{{ Input::old("message") }}</textarea>

                                <input type="hidden" name="ticket_submit" value="yes">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-12">

                            <div class="form-group">
                            <div class="input-file" name="Fichier1">

				<span class="input-group-btn hidden">
					<button  class="btn btn-default btn-success bookingselect_height" type="button">Choose</button>
				</span>
                                <input  type="file" class="form-control borderrediusinput"
                                       name="attatchment" placeholder="Choose a file...">
                                <span class="input-group-btn hidden">
					 <button  class="bookingselect_height btn btn-warning btn-reset" type="button">Reset</button>
				</span>
                            </div>
                        </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12">
                            <label>
                                <span><input class="margin0" type="checkbox"
                                             name="supportdeskpolicy"
                                             id="supportdeskpolicy" value="1" required=""
                                             @if(Input::old("supportdeskpolicy")) {{ "checked" }} @endif aria-required="true"/>
                                </span><span>I agree to the ParkingZone <a href="{{ route("static_page",["page"=>"terms-and-conditions"]) }}">Support Policy &amp; Terms of
                                        Service</a></span></label>


                        </div>

                        <div class="col-xs-12 pull-right">
                            <br>

                            <button style="background-color: #f99f03;" type="submit" name="submit" class="btn btn-yellow btn-font-size" > Create
                                New Support Ticket
                            </button>
                        </div>

                    </form>
                </div>

            </div>
            <!----end-->

        </div>

        <div id="customer_support_new" class="col-xs-12 col-sm-12 col-md-11 col-lg-4 customer_support_heading_new" >   <!-- style="max-height: initial;" -->

            <div class="">
                <div class="col-md-12 form-group"> 
                 <p class="existing-ticket">Existing Ticket</p>
                  @if (!$errors->search_ticket->isEmpty())
                    <div class="clearfix"></div>
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->search_ticket->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif
                </div>
               
                <form action="{{ route("search_ticket") }}" method="post"  class="support-form">
                    @csrf
                    <div class="col-md-12 form-group">
                        <label class="txtcolorblack">Email Address <span class="required-field">*</span></label>
                        <input type="email" value="{{ Input::old("email") }}" name="email" id="tickrt_email" placeholder="Email"
                               class="form-control" required/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="txtcolorblack">Ticket Reference <span class="required-field">*</span></label>
                        <input type="text" name="ref_no" value="{{ Input::old("ref_no") }}" id="ticket_reference" placeholder="Ticket Ref"
                               class="form-control" required="required"
                        />
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit"  style="background-color: #f99f03;" id="search_ticket" class="btn btn-yellow sub_btn"><i class="fa fa-ticket"></i>
                            Search Support Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
       </div>
        <div class="clearfix"></div>

    </section>

@endsection
@section("footer-script")
    <script>
        $(function () {
            $("#dropdatepicker12").datepicker({
                minDate: 0,
                dateFormat: 'dd/mm/yy',
                onSelect: function (dateText, inst) {

                    var date2 = $('#dropdatepicker12').datepicker('getDate', '+1d');
                    date2.setDate(date2.getDate() + 7);
                    $('#pickdatepicker12').datepicker('setDate', date2);
                }

            });
            $('#pickdatepicker12').datepicker(
                {
                    defaultDate: "+1w",
                    dateFormat: 'dd/mm/yy',
                    beforeShow: function () {
                        $(this).datepicker('option', 'minDate', $('#dropdatepicker12').val());
                        if ($('#dropdatepicker12').val() === '') $(this).datepicker('option', 'minDate', 0);
                    }
                });
        });
    </script>
@endsection