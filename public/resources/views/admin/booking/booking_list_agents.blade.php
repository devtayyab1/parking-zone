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
@endsection
@section('content')

<style>
	.btn-group-sm>.btn, .btn-sm {
	    padding: 2px 9px;
	    margin-top: 18px;
	}
    .form-inline .form-control {
        display: inline-block;
        width: 100%;
        vertical-align: middle;
    }
    .select-wid{
        width: 200px !important;
    }
    @media screen and (max-width: 767px){
        .select-wid{
            width: 100% !important;
        }
    }

</style>

    <div class="page-content">


        <div class="page-header">
            <h1>
                Bookings
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    List
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="col-xs-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('agent_bookings') }}" method="get" class="form-inline" style="margin-bottom: 10px;">
                        <div class="form-group" >
                            Search
                            <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control input-sm"
                                   id="field-1" value=""
                                   placeholder="Search By Keyword" style="padding: 6px 2px; width:98%;">
                        </div>
                        <div class="form-group">
                           All Airports
                            <select name="airport" class="form-control input-sm" >
                                <option value="all">All Airports</option>
                                @foreach($airports as $airport)
                                    <option @if(Input::get('airport')==$airport->id) {{ "selected='selected'" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                      
                        <div class="form-group">
                            Filter by
                            <select name="filter" class="form-control input-sm">
                                
                                <option value="created_at" selected='selected' @if(Input::get('filter')=='created_at') {{ "selected='selected'" }} @endif >
                                    Booked Date
                                </option>

                                <option value="departDate" @if(Input::get('filter')=='departDate') {{ "selected='selected'" }} @endif>
                                    Departure Date
                                </option>
                                <option value="returnDate" @if(Input::get('filter')=='returnDate') {{ "selected='selected'" }} @endif >
                                    Arrival Date
                                </option>
                                <option value="all" @if(Input::get('filter')=='all') {{ "selected='selected'" }} @endif>All</option>
                            </select>
                        </div>
                        <div class="form-group">
                            From
                            <input type="text" name="start_date" id="start_date" autocomplete="off"
                                   class="form-control input-sm datepicker" placeholder="Start Date"
                                   data-date-format="dd-M-yyyy" value="{{ Input::get('start_date') }}"
                                   >
                        </div>
                        <div class="form-group">
                            To
                            <input class="form-control input-sm date-picker" value="{{ Input::get('end_date') }}"
                                   autocomplete="off" id="end_date" placeholder="End Date" name="end_date" type="text"
                                   data-date-format="dd-M-yyyy"/>

                        </div>
                        <div class="form-group" style="display:none;">
                        	Companies<br>
                            <select name="companies" class="form-control input-sm select-wid">
                                <option value="all">All Companies</option>
                                @foreach($companies_dlist as $company)
                                    <option @if(Input::get('companies')==$company->id) {{ "selected='selected'" }} @endif value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                       
                        <div class="form-group">
                            Status
                            <select id="my_status" name="status" class="form-control input-sm"
                                    required="">
                                <option value="all">Booking Status</option>
                                <option value="Completed" @if(Input::get('status')=='Completed') {{ "selected='selected'" }} @endif>
                                    Booked
                                </option>
                                <option value="Abandon" @if(Input::get('status')=='Abandon') {{ "selected='selected'" }} @endif>
                                    Abandon
                                </option>
                                <option value="Refund" @if(Input::get('status')=='Refund') {{ "selected='selected'" }} @endif>
                                    Refund
                                </option>
                                <option value="Cancelled" @if(Input::get('status')=='Cancelled') {{ "selected='selected'" }} @endif>
                                    Cancelled
                                </option>
                            </select>
                        </div> 
                        


                        <div class="form-group">
                            Days
                            <select name="no_of_days" class="form-control input-sm" >

                                <option value="all">All</option>

                                @php
                                for ($j = 1; $j <= 30; $j++){
                                @endphp
                                <option value="{{ $j }}" @if(Input::get('no_of_days')==$j) {{ "selected='selected'" }} @endif >{{  $j }}</option>
                                @php
                                }
                                @endphp
                                <option value="30+" @if(Input::get('no_of_days')=="30+") {{ "selected='selected'" }} @endif >Over 30</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="submit" type="submit" value="Search" class="btn btn-primary btn-sm">
                            <a href="{{ route('agent_bookings') }}" class="btn btn-primary btn-sm">Reset</a>
                        </div>
                    </form>

                </div>


                <br>
                <br>
                <br>
				@if(count($bookings) > 0)
                <div class="col-md-12"
                     style="border: 1px solid #e4e4e4;    border-radius: 9px; margin-bottom: 10px;background: #f5f5f6;">
                    <div class="col-md-8">
                        @php
                            $f_share = 0;
                            $tot_rev = 0;
                            $countCompleted=0;
                              foreach($bookings_count as $booking)
                              {


                                if($booking['booking_status']=='Completed') {
                                    $countCompleted++;
                                    $share = 0;
                                    if($booking->company){ 
                                        $share = $booking->company->share_percentage; 
                                    }
                                    $fly_share = ((
                                    ($share/100)*
                                    $booking->booking_amount)-
                                    $booking->discount_amount)+
                                    $booking->booking_extra;
                                    $f_share += $fly_share;
                                    
                                    $rev = ((
                                    $booking->booking_amount)-
                                    $booking->discount_amount)+
                                    $booking->booking_extra;
                                    $tot_rev += $rev;
                                }

                              }

                              $f_share = round(($f_share),2);
                              $net_share = round(($f_share * 0.78),2);

                        @endphp
                        <!--h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total Booked
                            bookings: <span id="no_of_booking">  @php echo  $countCompleted;
                                @endphp</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total
                            Parkingzone Revenue: <span id="total_share">{{$tot_rev}}</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total
                            Parkingzone share: <span id="total_share">{{$f_share}}</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Net
                            parkingzone share: <span id="net_share">{{$net_share}}</span></h2-->




                    </div>
                    <div class="col-md-4 text-right section-right" style=" margin-bottom: 15px;">

                        <a id="excel" class="btn btn-primary  btn-sm" href='{{ route("admin_booking_report_excel_agent") }}?filter={{ Input::get("filter") }}&search={{ Input::get("search") }}&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::get("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}&no_of_days={{ Input::get("no_of_days") }}&agentID={{ Input::get("agentID") }}&booking_source={{ Input::get("booking_source") }}'><i class="fa fa-file-excel-o"></i> Download Excel</a>
                        <a id="excel" target="_blank" class="btn btn-danger  btn-sm" href='{{ route("admin_booking_report_pdf_agent") }}?filter={{ Input::get("filter") }}&search=&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::get("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}'><i class="fa fa-file-pdf-o"></i>Download PDF</a>
                    </div>

                </div>
				@endif
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
								
								<div id="sms_response"></div>
<div class="table-responsive">
                                <table id="simple-table" class="table  table-bordered table-hover">
                                    <thead>
                                    <tr>

                                        <!--<th style="width: 50px;">Reference No</th>-->
                                        <th style="width: 50px;">External Ref</th>
                                        <th>Airports</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Booking Date</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Booking status</th>
                                        <th>No of Days</th>
                                        <th>Make</th>
                                        <th>Model</th>
                                        <th>Color</th>
                                        <th>Registration</th>
                                        <th>Net Amount</th>
										

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($bookings as $booking)
                                    
                                        @php    if($booking['booking_status']=='Completed') { @endphp

                                        <tr id="expand_{{  $booking->id  }}">
                                        @php } else { @endphp
                                        <tr style="color:red;" id="expand_{{  $booking->id  }}">
                                            @php }  @endphp

											<!--td style="width: 50px;">
                                                {{ $booking->referenceNo }}
                                            </td-->
                                            <td style="width: 50px;">
                                                {{ $booking->ext_ref }}
                                            </td>
                                            <td class="">@if($booking->airport) <span
                                                        class="label label-sm label-success"><i
                                                            class="fa fa-plane"></i> {{ ucwords(preg_replace('/\s/', '', $booking->airport->name))  }}</span>  @endif
                                            </td>
                                            <td class="">{{ $booking->first_name." ".$booking->last_name }}</td>

                                            <td class="">{{ $booking->company_name }}</td>
                                            <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->created_at)) }}</td>
                                            <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->departDate)) }}</td>
                                            <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->returnDate)) }}</td>
                                            <td class="">{{ $booking->booking_status }}</td>
											<td>{{ $booking->no_of_days  }}</td>
											
                                            <td class="">{{ $booking->make }}</td>
                                            <td class="">{{ $booking->model }}</td>
                                            <td class="">{{ $booking->color }}</td>
                                            <td class="">{{ $booking->registration }}</td>
											<td><strong class="badge badge-success badge-roundless">£{{ round($booking->booking_amount,2) }}</strong></td>
											
                                        </tr>
                                        
                                    @endforeach


                                    </tbody>
                                </table>
</div>
                               
                                {{ $bookings->appends(request()->input())->links("vendor.pagination.default") }}
                            </div><!-- /.span -->
                        </div><!-- /.row -->


                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <br/>
            <br/>
            <br/>

@endsection

@section("footer-script")
<script src='{{ secure_asset("assets/js/moment.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/daterangepicker.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/bootstrap-datetimepicker.min.js") }}'></script>

<script src='{{ secure_asset("assets/js/bootstrap-datepicker.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/bootstrap-timepicker.min.js") }}'></script>


<!-- page specific plugin scripts -->
<script src='{{ secure_asset("assets/js/wizard.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/jquery.validate.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/jquery-additional-methods.min.js") }}'></script>
<script src='{{ secure_asset("assets/js/bootbox.js") }}'></script>
{{--<script src='{{ secure_asset("assets/js/jquery.min.js") }}'></script>--}}
<script src='{{ secure_asset("assets/js/select2.min.js") }}'></script>
<script type="text/javascript">


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



<script src='{{ secure_asset("assets/front/js/bootbox.js") }}'></script>
<script>

	function show_detal(id) {
		console.log('test');
		if ($("#show_detail_icon_" + id).hasClass("fa-plus-circle")) {
			$("#show_detail_icon_" + id).removeClass("fa-plus-circle");
			$("#show_detail_icon_" + id).addClass("fa-minus-circle");
		} else {
			$("#show_detail_icon_" + id).removeClass("fa-minus-circle");
			$("#show_detail_icon_" + id).addClass("fa-plus-circle");
		}
		console.log('test');

		$("#detail_" + id).toggle();
	}

	function sendEmailForm(id, cmpID) {
		ModelPopUp("<div id=\"resend_email\" ><div><h2>Resend Email</h2></div>\n" +
			"                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\" type=\"radio\" value=\"company\" name=\"resendEmailto\">Company</label>\n" +
			"                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\"  type=\"radio\" value=\"client\" name=\"resendEmailto\">Client</label>\n" +
			"                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\" type=\"radio\" value=\"all\" name=\"resendEmailto\" >ALL</label>\n" +
			"                        <input  onclick=\"sendEmail('" + id + "','" + cmpID + "')\" class=\"btn btn-info\" value=\"Send\" style=\"margin: 15px 5px 5px 15px;\">\n" +
			"                        </div>");
	}

	function sendEmail(id, cid) {
		var type = $('input[name=resendEmailto]:checked').val();
		$("#resend_email").html("<div id=\"resend_email\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");

		var data = {};
		data["id"] = id;
		data["cid"] = cid;
		data["type"] = type;
		data["_token"] = '{{ csrf_token() }}';
		$.post('{{ route("booking.sendEmailBooking") }}', data, function (data) {
			console.log("data===", data);
			$("#resend_email").html(data);
//                        if (data.StatusCode == 0) {
//                            window.location.href = "https://"+window.location.hostname+"/booking/thankyou";
//                        } else {
//                            $("#error_personal_detail").html(data.Message);
//                        }
		});

	}

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


	function ModelPopUp(message) {
		bootbox.dialog({
			message: message,
			size: "large",
//                                buttons:
//                                    {
//                                        "success":
//                                            {
//                                                "label": "<i class='ace-icon fa fa-check'></i> Ok",
//                                                "className": "btn-sm btn-success",
//                                                "callback": function () {
//                                                    //Example.show("great success");
//                                                }
//                                            }
//                                    }
		});
	}
</script>
@endsection
