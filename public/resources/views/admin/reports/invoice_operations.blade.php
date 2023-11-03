@extends('admin.layout.master')

@section('stylesheets')

    @parent

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/jquery-ui.custom.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/chosen.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-datepicker3.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-timepicker.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/daterangepicker.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-datetimepicker.min.css') }}"/>

    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-colorpicker.min.css') }}"/>
	
    <!--link rel="stylesheet" href=" https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/-->

@endsection

@section('content')
<style>
.btn-group-sm>.btn, .btn-sm {
    padding: 2px 9px;
}
.table>thead>tr>th:last-child {
    border-right: 1px solid #ddd;
}
.table>thead>tr {
    color: #393939;
}
.select-wid{
        width: 200px !important;
    }
    @media screen and (max-width: 767px){
        .select-wid{
            width: 100% !important;
        }
    }


input[type=email], input[type=url], input[type=search], input[type=tel], input[type=color], input[type=text], input[type=password], input[type=datetime], input[type=datetime-local], input[type=date], input[type=month], input[type=time], input[type=week], input[type=number], textarea
{
	font-size: 13px;
}
</style>


    <div class="page-content">





        <div class="page-header">

            <ol class="breadcrumb bc-3">

                <li><a href="Dashboad">Dashboad</a></li>

                <li>Reports</li>

                <li class="active"><strong>Invoice Operations  Commission Report</strong></li>

            </ol>

        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-md-6">

                <h2>Invoice Operations  Commission Report</h2>

            </div>



        </div>

        <form action="{{ route('invoice_commission_report') }}" method="get" class="form-inline" style="margin-bottom: 10px;">

            <div class="form-group" style="padding: 6px 2px;">
                Keyword
                <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control input-sm" id="field-1" value=""

                       placeholder="Search By Keyword" style="padding: 6px 2px; width:98%;">

            </div>

            <div class="form-group">
                Airports
                <select name="airport" class="form-control input-sm" style="padding: 6px 2px;">

                    <option value="all">All Airports</option>

                    @foreach($airports as $airport)

                        <option @if(Input::get('airport')==$airport->id) {{ "selected='selected'" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>

                    @endforeach

                </select>

            </div>

           

            <div class="form-group">
                Admins
                <select name="admins" class="form-control input-sm">

                    <option value="all">All Admins</option>

                    @foreach($admins as $admin)

                        <option @if(Input::get('admins')==$admin->id) {{ "selected='selected'" }} @endif value="{{ $admin->id }}">{{ $admin->name }}</option>

                    @endforeach

                </select>

            </div>

        

            <div class="form-group" style="width: 200px;">
                Companies
                <select name="companies" class="form-control input-sm select-wid">

                    <option value="all">All Companies</option>

                    @foreach($companies_dlist as $company)

                        <option @if(Input::get('companies')==$company->id) {{ "selected='selected'" }} @endif value="{{ $company->id }}">{{ $company->name }}</option>

                    @endforeach

                </select>

            </div>



            
<!--
            <div class="form-group" style="display:none;">
                Payment Type
                <select name="payment" class="form-control input-sm">

                    <option value="all">Payment Type</option>
                    <option value="stripe" @if(Input::get('payment')=='stripe') {{ "selected='selected'" }} @endif>Stripe</option>

                    <option value="payzone" @if(Input::get('payment')=='payzone') {{ "selected='selected'" }} @endif>Payzone</option>

                </select>

            </div>
-->

            <div class="form-group">

                Status
                <select id="my_status" name="status" class="form-control input-sm" required="">

                    <option value="all">Booking Status</option>

                    <option value="Booked" @if(Input::get('status')=='Booked') {{ "selected='selected'" }} @endif>Booked</option>

                    <option value="Amend" @if(Input::get('status')=='Amend') {{ "selected='selected'" }} @endif>Amend</option>

                    <option value="Refund" @if(Input::get('status')=='Refund') {{ "selected='selected'" }} @endif>Refund</option>

                    <option value="Cancelled" @if(Input::get('status')=='Cancelled') {{ "selected='selected'" }} @endif>Cancelled</option>

                    <option value="Noshow" @if(Input::get('status')=='Noshow') {{ "selected='selected'" }} @endif>No Show</option>

                </select>

            </div>



            <div class="form-group">

                Filter by

                <select name="filter" class="form-control input-sm">

                    <option value="all">All</option>

                    <option value="created_at" @if(Input::get('filter')=='created_at') {{ "selected='selected'" }} @endif >Booked Date</option>

                    <option value="departDate" @if(Input::get('filter')=='departDate') {{ "selected='selected'" }} @endif>Departure Date</option>

                    <option value="returnDate" @if(Input::get('filter')=='returnDate') {{ "selected='selected'" }} @endif >Arrival Date</option>

                </select>

            </div>

            <div class="form-group">

                From

                <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control datepicker input-sm" placeholder="Start Date"

                       data-date-format="dd-M-yyyy" value="{{ Input::get('start_date') }}" style="padding: 6px 2px;">

            </div>

            <div class="form-group">

                To

                <input class="form-control date-picker input-sm" value="{{ Input::get('end_date') }}" autocomplete="off" id="end_date" placeholder="End Date" name="end_date" type="text"

                       data-date-format="dd-M-yyyy"/>



            </div>

            <!--div class="form-group">

                <strong style="color:green;">Previous Adjustment</strong>

                <input type="text" name="adjust" value="{{ Input::get('adjust') }}" class="form-control input-sm" placeholder="Enter Adjustment amout" value="">

            </div-->

            <div class="form-group">

                <input name="submit" type="submit" value="Search" class="btn btn-primary btn-sm">

                <a href="{{ route('invoice_commission_report') }}" class="btn btn-primary btn-sm">Reset</a>

            </div>

        </form>



        <div class="row">

            <div class="col-xs-12">

                <!-- PAGE CONTENT BEGINS -->

                <div class="row">

                    <div class="col-xs-12">



                        @if ($message = Session::get('success'))

                            <div class="alert alert-success">

                                <p>{{ $message }}</p>

                            </div>

                        @endif

                            @if($show==1)

                                <div class="row">
									<div class="col-sm-8" style="margin-bottom: 10px">
<h2 class="badge badge-info" style="padding: 10px;">
	<i class="entypo-target"></i> Total Bookings: <b id="total_booking_span"> {{$total_booking}}</b>
</h2>
<h2 class="badge badge-info" style="padding: 10px;">
	<i class="entypo-target"></i> Total Booking Amount: <b id="total_ba_span"> {{$total_list_price}}</b>
</h2>
<h2 class="badge badge-info" style="padding: 10px;">
	<i class="entypo-target"></i> Total Company Commission: <b id="total_company_span">{{round($total_amount_paid,2)}}</b>
</h2>
<h2 class="badge badge-info" style="padding: 10px;">
	<i class="entypo-target"></i> Total PZ Commission: <b id="total_pz_span"> {{round($total_pz_commission,2)}}</b>
</h2>
<!--<h2 class="badge badge-info" style="padding: 10px;">-->
<!--	<i class="entypo-target"></i> Total 20% Commission: <b id="total_20_percent_span"></b>-->
<!--</h2>-->
<!--<h2 class="badge badge-info" style="padding: 10px;">-->
<!--	<i class="entypo-target"></i> Total 80% Commission: <b id="total_80_percent_span"></b>-->
<!--</h2>-->
									</div>
									<div class="col-sm-4 text-right" style="margin-bottom: 10px; margin-top: 20px;">



										<a id="excel" class="btn btn-primary btn-sm exxl" href='{{ route("invoice_operation_report_excel") }}?filter={{ Input::get("filter") }}&search=&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::get("status") }}&admins={{ Input::get("admins") }}'><i class="fa fa-download"></i> Download Excel</a>

									</div>
                                </div>

                            @endif

                            <div class="">

                        <table class="table table-bordered table-striped table-condensed dataTable" id="table-1"

                               role="grid" aria-describedby="table-1_info">

                            <thead>



                            <tr role="row">



                                <th>Reference#</th>

                                <th>Ext Ref</th>
                                
                                <th>Name</th>

                                <th>Booking Date </th>

                                <th>Departure Date </th>

                                <th>Return Date </th>

                                <th>Days</th>

                                <th>Payment Method</th>

                                <th>Booking Amount</th>
								
                                <!--th>Client Paid</th>
								
                                <th>Booking Fee</th>
								
                                <th>Bank Amount</th-->

                                <th>Company Commission</th>

                                <th>Parkingzone Commission</th>
                                <!--th>YP Commission with Discount</th>
                                <th>20% Commission</th>
                                <th>80% Commission</th-->



                            </tr>



                            </thead>



                            <tbody>
@php
$total_list_price = 0;
$total_client_paid = 0;
$total_bank_amount = 0;
$total_booking_fee = 0;
$total_amount_paid = 0;
$total_pz_commission = 0;
$total_pz_discount_commission = 0;
$total_percent_20 = 0;
$total_percent_80 = 0;

$total_bookings = 0;
@endphp
                            @foreach($companies as $company)

                                <tr>





                                    <td> {{ $company['referenceNo'] }}</td>
                                    
                                    <td>{{ $company['ext_ref'] }}</td>
                                    

                                    <td> {{ $company['title']." ".$company['first_name']." ".$company['last_name'] }}</td>

                                    <td> {{  date("d/m/Y H:i:s", strtotime($company['createdate'])) }} </td>

                                    <td> {{ date("d/m/Y H:i:s", strtotime($company['start_date'])) }} </td>

                                    <td> {{  date("d/m/Y H:i:s", strtotime($company['end_date'])) }} </td>

                                    <td> {{ $company['no_of_days'] }} </td>



                                    <td class="">

                                        @if($company["payment_method"]=="stripe")

                                            <span class="label label-lg label-info"><i

                                                        class="fa fa-cc-stripe"></i> {{ ucwords(preg_replace('/\s/', '', $company["payment_method"]))  }}</span>





                                        @elseif($company["payment_method"]=="payzone")

                                            <span class="label label-lg label-info"><i

                                                        class="fa fa-paypal"></i> {{ ucwords(preg_replace('/\s/', '',$company["payment_method"]))  }}</span>







                                        @endif

                                    </td>

                                    <td> {{ $company['ListPrice'] }} </td>

                                    <!--td> {{ (float)number_format($company['client_paid'] ,2) }} </td>
                                    <td>{{ (float)number_format($company['booking_fee'] ,2) }}</td>
                                    <td>{{ (float)number_format($company['bank_amount'] ,2) }}</td-->
                                    <td> {{ (float)number_format($company['AmountPaid'] ,2) }} </td>

                                    <td> {{ (float)number_format($company['commission'] ,2) }} </td>
                                    <!--td> {{ (float)number_format($company['discount_commission'] ,2) }} </td-->
@php
$percent_20 = (20/100)*$company['discount_commission'];
$percent_80 = (80/100)*$company['discount_commission'];
@endphp
                                    <!--td> {{ (float)number_format($percent_20 ,2) }} </td>
                                    <td> {{ (float)number_format($percent_80 ,2) }} </td-->



                                </tr>
@php
$total_list_price = $total_list_price + $company['ListPrice'];
$total_client_paid = $total_client_paid + $company['client_paid'];
$total_booking_fee = $total_booking_fee + $company['booking_fee'];
$total_bank_amount = $total_bank_amount + $company['bank_amount'];
$total_amount_paid = $total_amount_paid + $company['AmountPaid'];
$total_pz_commission = $total_pz_commission + $company['commission'];
$total_pz_discount_commission = $total_pz_discount_commission + $company['discount_commission'];
$total_percent_20 = $total_percent_20 + $percent_20;
$total_percent_80 = $total_percent_80 + $percent_80;

$total_bookings++;
@endphp
                            @endforeach

<tr>
<td colspan=8 style="text-align:right"><b>Total:</b></td>
<td><b id="ba_total"> {{ number_format($total_list_price ,2) }} </b></td>
<!--td><b> {{ number_format($total_client_paid ,2) }} </b></td>
<td><b> {{ number_format($total_booking_fee ,2) }} </b></td>
<td><b> {{ number_format($total_bank_amount ,2) }} </b></td-->
<td><b id="company_total"> {{ number_format($total_amount_paid ,2) }} </b></td>
<td><b id="pz_total"> {{ (float)number_format($total_pz_commission ,2) }} </b></td>
<!--td><b > {{ (float)number_format($total_pz_discount_commission ,2) }} </b></td>
<td><b id="p20_total"> {{ (float)number_format($total_percent_20 ,2) }} </b></td>
<td><b id="p80_total"> {{ (float)number_format($total_percent_80 ,2) }} </b></td-->



</tr>


                            </tbody>

                        </table>

</div>

                        {{ $paginator }}

                    </div><!-- /.span -->

                </div><!-- /.row -->





                <!-- PAGE CONTENT ENDS -->

            </div><!-- /.col -->

        </div><!-- /.row -->

    </div>

    <script>
		$(document).ready(function() {
			var ba = $('#ba_total').html();
			var pz = $('#pz_total').html();
			var company_total = $('#company_total').html();
			var p80_total = $('#p80_total').html();
// 			$('#total_ba_span').html(ba);
// 			$('#total_pz_span').html(pz);
// 			$('#total_company_span').html(company_total);
// 			$('#total_booking_span').html({{$total_bookings}});
			
		});
        function validate(form) {



            // validation code here ...





            if (!valid) {

                alert('Please correct the errors in the form!');

                return false;

            }

            else {

                return confirm('Do you really want to submit the form?');

            }

        }

    </script>



@endsection

@section("footer-script")

    <script src='{{ secure_asset("assets/js/moment.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/daterangepicker.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/bootstrap-datetimepicker.min.js") }}'></script>



    <script src='{{ secure_asset("assets/js/bootstrap-datepicker.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/bootstrap-timepicker.min.js") }}'></script>





    <!-- page specific plugin scripts -->

    <!--script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script-->
    <script src='{{ secure_asset("assets/js/wizard.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/jquery.validate.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/jquery-additional-methods.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/bootbox.js") }}'></script>

    <script src='{{ secure_asset("assets/js/jquery.maskedinput.min.js") }}'></script>

    <script src='{{ secure_asset("assets/js/select2.min.js") }}'></script>

    <script type="text/javascript">
/*
		$(document).ready( function () {
			$('#table-1').DataTable();
		} );

*/

        $('#start_date').datepicker({

            autoclose: true,

            todayHighlight: true

        })

        //show datepicker when clicking on the icon

            .next().on(ace.click_event, function () {

            $(this).prev().focus();

        });





        $('#end_date').datepicker({

            autoclose: true,

            todayHighlight: true

        })

        //show datepicker when clicking on the icon

            .next().on(ace.click_event, function () {

            $(this).prev().focus();

        });



    </script>







@endsection

