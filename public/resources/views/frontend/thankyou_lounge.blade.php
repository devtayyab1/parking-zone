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

                                <div id="thankyou" class="main-area border-box"

                                     style="

    float: left;

    width: 100%;

    border-radius: 23px; ">

                                    <!-- top area -->

                                    <div class="top-bar">



                                        <div class="top-bar-right col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                            <h1 style="text-align: center;color: black;">Payment has now been confirmed</h1>

                                        </div>

                                    </div>

                                    <div class="confirm col-xs-12 col-sm-12 col-md-12 col-lg-12">



                                        <p>

                                            Thank you for completing booking this is your booking confirmation

                                            with all your booking details, Email has been sent to you in regards to

                                            your booking.

                                            If you do have any questions in the mean time please do not hesitate to

                                            contact us on bookings@parkingzone.co.uk</p>





                                        <div>

                                            <!-- Detail Content -->

                                            <div class="detail col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                <div class="sub-detail"

                                                     style="float: left; width: 100%; border: 4px solid #0885cf; border-right: 0px; border-left: 0px; margin: 10px 0px 10px 0px; padding: 20px 0px;color: black;">

                                                    <div class="table-responsive">

                                                        <h2 style="text-align: center;">Your Detail</h2>

                                                        <table class="table" border="0">

                                                            <tbody >

                                                            <tr>

                                                                <td width="12%"><span

                                                                            style="font-weight:bold;">Name:</span>

                                                                </td>

                                                                <td width="26%">

                                                                    <span>{{ $booking->first_name." ".$booking->last_name }}</span>

                                                                </td>

                                                                <td width="22%">
                                                                    <span style="font-weight:bold;">Phone:</span>

                                                                </td>

                                                                <td width="26%">
                                                                    <span>
                                                                   {{ $booking->phone_number }}
                                                                    </span></td>

                                                            </tr>





                                                            <tr>
                                                                

                                                                <td>

                                                                    <span style="font-weight:bold;">Email:</span>

                                                                </td>

                                                                <td><span>{{ $booking->email }}</span></td>



                                                                <td>

                                                                    <span style="font-weight:bold;"></span>

                                                                </td>

                                                                <td></td>





                                                            </tr>



                                                            </tbody>

                                                        </table>


                                                        <h2 style="text-align: center;">Lounge Detail</h2>
                                                        <table class="table" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="50%"><span
                                                                            style="font-weight:bold;">Lounge Name:</span>
                                                                </td>
                                                                <td width="50%">
                                                                    <span>{{ $booking->lounge_name }}</span>
                                                                </td>
                                                                
                                                            </tr>

                                                            <tr>
                                                                <td width="50%"><span style="font-weight:bold;">Airport:</span>
                                                                </td>
                                                                <td width="50%"><span>{{ $airport_detail->name }}</span></td>
                                                            </tr>

                                                            <tr>

                                                                <td>
                                                                    <span style="font-weight:bold;">Terminal:</span>
                                                                </td>
                                                                <td><span>T-{{ $booking->terminal }}</span></td>

                                                            </tr>

                                                            </tbody>
                                                        </table>

                                                        <h2 style="text-align: center;">Booking Detail</h2>
                                                        <table class="table" border="0">

                                                            <tbody>

                                                            <tr>

                                                                <td width="50%"><span style="font-weight:bold;">Booking Refrence</span></td>

                                                                <td width="50%"><span>{{ $booking->referenceNo }}</span>

                                                                </td>

                                                            </tr>
                                                            <tr>

                                                                <td width="50%"><span style="font-weight:bold;">Lounge entry</span></td>

                                                                <td width="50%"><span>{{ date('l, d M Y', strtotime($booking->check_in)) }} at {{ date('H:i', strtotime($booking->check_in_time)) }}</span>

                                                                </td>

                                                            </tr>
                                                            <tr>

                                                                <td width="50%"><span style="font-weight:bold;">Passengers</span></td>

                                                                <td width="50%"><span>{{ $booking->adults }} adults, {{ $booking->chilren }} children</span></td>

                                                            </tr>
                                                            <tr>
                                                                <td><span style="font-weight:bold;">Price</span></td>

                                                                <td><span>{{ $booking->total_amount }}</span>

                                                                </td>
                                                            </tr>

                                                            <tr>

                                                                <td><span style="font-weight:bold;">Total Price:</span>

                                                                </td>

                                                                <td><span style="font-weight:bold;">£{{ $booking->total_amount }}</span>

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
