@extends('layouts.main')



@section('content')







    <div class="home-container home-background">



        @include("frontend.header")





    </div><!-- end home-container -->



    <section class="section" style="margin-top: 44px;padding: 40px;">



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



                <div class="booking-result">





                    <div id="print" style="margin: 0px; padding: 0px;">

                        <div class="col-md-6" id="myfont" style="float: unset;

    margin: 0 auto;">

                            <div class="row">

                                <div id="thankyou" class="main-area"

                                     style="

    border: 1px solid #777777;

    float: left;

    width: 100%;

    border-radius: 23px; ">

                                    <!-- top area -->

                                    <div class="top-bar">



                                        <div class="top-bar-right col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                            <h1 style="text-align: center;">Payment has now been confirmed</h1>

                                        </div>

                                    </div>

                                    <div class="confirm col-xs-12 col-sm-12 col-md-12 col-lg-12">



                                        <p>

                                            Thank you for completing booking this is your booking confirmation

                                            with all your traveling details, We will contact you shortly in regards to

                                            your booking.

                                            If you do have any questions in the mean time please do not hesitate to

                                            contact us on parkingzone@gmail.com</p>





                                        <div>

                                            <!-- Detail Content -->

                                            <div class="detail col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                <div class="sub-detail"

                                                     style="float: left; width: 100%; border: 4px solid #777777; border-right: 0px; border-left: 0px; margin: 10px 0px 10px 0px; padding: 20px 0px;">

                                                    <div class="table-responsive">

                                                        <h1 style="text-align: center;">Your Detail</h1>

                                                        <table class="table" border="0">

                                                            <tbody >

                                                            <tr>

                                                                <td width="12%"><span

                                                                            style="font-weight:bold;">Name:</span>

                                                                </td>

                                                                <td width="26%">

                                                                    <span>{{ $booking->first_name." ".$booking->last_name }}</span>

                                                                </td>

                                                                <td width="22%"><span

                                                                            style="font-weight:bold;">Address:</span>

                                                                </td>

                                                                <td width="26%">
                                                                <span>
                                                                    @if($booking->fulladdress=='')
                                                                        {{ $booking->address }} {{ $booking->address2}}, {{ $booking->town }}
                                                                    @else
                                                                        {{ $booking->fulladdress }}
                                                                    @endif
                                                                </span></td>

                                                            </tr>





                                                            <tr>



                                                                <td>

                                                                    <span style="font-weight:bold;">Phone:</span>

                                                                </td>

                                                                <td><span>{{ $booking->phone_number }}</span></td>





                                                                <td>

                                                                    <span style="font-weight:bold;">Email:</span>

                                                                </td>

                                                                <td><span>{{ $booking->email }}</span></td>

                                                            </tr>



                                                            </tbody>

                                                        </table>



                                                        <table class="table" border="0">

                                                            <tbody>

                                                            <tr>

                                                                <td width="12%"><span

                                                                            style="font-weight:bold;">Booking Refrence </span>

                                                                </td>



                                                                <td width="22%"><span

                                                                            style="font-weight:bold;">Description </span>

                                                                </td>



                                                                <td width="12%"><span

                                                                            style="font-weight:bold;">Price</span>

                                                                </td>



                                                            </tr>





                                                            <tr>



                                                                <td><span>{{ $booking->referenceNo }}</span>

                                                                </td>





                                                                <td><span>{{ $booking->airport->name }} airport parking {{ $booking->no_of_days }} Days</span>

                                                                </td>

                                                                <td><span>{{ $booking->total_amount }}</span>

                                                                </td>



                                                            </tr>

                                                            <tr>



                                                                <td><span style="font-weight:bold;  "></span>

                                                                </td>





                                                                <td><span style="font-weight:bold;  ">Total Price:</span>

                                                                </td>

                                                                <td><span style="font-weight:bold;  ">{{ $booking->total_amount }}</span>

                                                                </td>



                                                            </tr>



                                                            </tbody>

                                                        </table>

                                                    </div>







                                                </div>

                                            </div>



                                        </div>

                                    </div>



                                    <!-- /detail content -->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>





            </div>

        </div>

        </div>



    </section>







@endsection

