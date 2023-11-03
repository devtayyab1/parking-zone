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

                                            with all your traveling details, Email has been sent to you in regards to

                                            your booking.

                                            If you do have any questions in the mean time please do not hesitate to

                                            contact us on bookings@parkingzone.co.uk</p>





                                        <div>

                                            <!-- Detail Content -->

                                            <div class="detail col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                <div class="sub-detail"

                                                     style="float: left; width: 100%; border: 4px solid #777777; border-right: 0px; border-left: 0px; margin: 10px 0px 10px 0px; padding: 20px 0px;">

                                                    <div class="table-responsive">

                                                        <h2 style="text-align: center; color:#dddddd;">Your Detail</h2>

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


                                                        <h2 style="text-align: center;color: #dddddd;">Vehicle Detail</h2>
                                                        <table class="table" border="0">
                                                            <tbody >
                                                            <tr>
                                                                <td width="12%"><span
                                                                            style="font-weight:bold;">Make:</span>
                                                                </td>
                                                                <td width="26%">
                                                                    <span>{{ $booking->make }}</span>
                                                                </td>
                                                                <td width="22%"><span
                                                                            style="font-weight:bold;">Color:</span>
                                                                </td>
                                                                <td width="26%"><span>{{ $booking->color }}</span></td>
                                                            </tr>


                                                            <tr>

                                                                <td>
                                                                    <span style="font-weight:bold;">Model:</span>
                                                                </td>
                                                                <td><span>{{ $booking->model }}</span></td>


                                                                <td>
                                                                    <span style="font-weight:bold;">Registration:</span>
                                                                </td>
                                                                <td><span>{{ $booking->registration }}</span></td>
                                                            </tr>

                                                            </tbody>
                                                        </table>

                                                        <h2 style="text-align: center;color: #dddddd;">Booking Detail</h2>
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



@if ($booking->traffic_src == 'POR')
<script language=JavaScript src="https://portgk.com/create-sale?client=java&MerchantID=1234&SaleID={{$booking->referenceNo}}&OrderValue={{$booking->total_amount}}"></script>
<noscript><img src="https://portgk.com/create-sale?client=img&MerchantID=1234&SaleID={{$booking->referenceNo}}&OrderValue={{$booking->total_amount}}" width="10" height="10" border="0"></noscript>
@endif

@if ($booking->traffic_src == 'PPC')
<!-- Global site tag (gtag.js) - Google Ads: 708574146 -->
<!--script async src="https://www.googletagmanager.com/gtag/js?id=AW-708574146"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-708574146');
</script-->
<!-- Event snippet for Confirm Purchase of Parking Zone conversion page -->

<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-11007667491/je72COmniIAYEKPa7oAp',
      'transaction_id': '{{$booking->referenceNo}}'
  });
</script>
@endif

@endsection
