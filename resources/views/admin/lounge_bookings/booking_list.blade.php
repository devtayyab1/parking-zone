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
                    <form action="{{ route('booking_lounge') }}" method="get" class="form-inline" style="margin-bottom: 10px;">
                        <div class="form-group" >
                            Keywords
                            <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control input-sm"
                                   id="field-1" value=""
                                   placeholder="Search By Keyword" style="padding: 6px 2px; width:98%;">
                        </div>
                        <div class="form-group">
                            Airports
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
                                <option value="createdate" selected='selected' @if(Input::get('filter')=='createdate') {{ "selected='selected'" }} @endif >
                                    Booked Date
                                </option>
                                <option value="check_in" @if(Input::get('filter')=='check_in') {{ "selected='selected'" }} @endif>
                                    Check-in Date
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
                                <option value="Noshow" @if(Input::get('status')=='Noshow') {{ "selected='selected'" }} @endif>
                                    No Show
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                        Source
                        <select name="booking_source" class="form-control input-sm" >
                           @if($role_name=='Marketing')
                            <option value="paid" @if(Input::get('booking_source')=='paid') {{ "selected='selected'" }} @endif>All</option>
                            <option value="PPC" @if(Input::get('booking_source')=='PPC') {{ "selected='selected'" }} @endif>PPC</option>
                            <option value="BING" @if(Input::get('booking_source')=='BING') {{ "selected='selected'" }} @endif>BING</option>
                            <option value="ORG"  @if(Input::get('booking_source')=='ORG') {{ "selected='selected'" }} @endif>Organic</option>
                            <option value="EM" @if(Input::get('booking_source')=='EM') {{ "selected='selected'" }} @endif>E Marketing</option>
                            <option value="POR" @if(Input::get('booking_source')=='POR') {{ "selected='selected'" }} @endif>POR</option>
                            @else
                            <option value="all" @if(Input::get('booking_source')=='all') {{ "selected='selected'" }} @endif>All</option>
                            <option value="paid" @if(Input::get('booking_source')=='paid') {{ "selected='selected'" }} @endif>Paid</option>
                            <option value="ORG"  @if(Input::get('booking_source')=='ORG') {{ "selected='selected'" }} @endif>Organic</option>
                            <option value="PPC" @if(Input::get('booking_source')=='PPC') {{ "selected='selected'" }} @endif>PPC</option>
                            <option value="BING" @if(Input::get('booking_source')=='BING') {{ "selected='selected'" }} @endif>BING</option>
                            <option value="EM" @if(Input::get('booking_source')=='EM') {{ "selected='selected'" }} @endif>E Marketing</option>
                            <option value="POR" @if(Input::get('booking_source')=='POR') {{ "selected='selected'" }} @endif>POR</option>
                            <option value="FB" @if(Input::get('booking_source')=='FB') {{ "selected='selected'" }} @endif>FaceBook</option>
                            <option value="Ln" @if(Input::get('booking_source')=='Ln') {{ "selected='selected'" }} @endif>LinkedIn</option>
                            <option value="In" @if(Input::get('booking_source')=='In') {{ "selected='selected'" }} @endif>Instagram</option>
                            <option value="G+" @if(Input::get('booking_source')=='G+') {{ "selected='selected'" }} @endif>Google+</option>
                            <option value="Pi" @if(Input::get('booking_source')=='Pi') {{ "selected='selected'" }} @endif>Pinterest</option>
                            <option value="Tw" @if(Input::get('booking_source')=='Tw') {{ "selected='selected'" }} @endif>Twiter</option>
                            <option value="Yt" @if(Input::get('booking_source')=='Yt') {{ "selected='selected'" }} @endif>Youtube</option>
                            <option value="Blg" @if(Input::get('booking_source')=='Blg') {{ "selected='selected'" }} @endif>Bloging</option>
                            <option value="BK" @if(Input::get('booking_source')=='BK') {{ "selected='selected'" }} @endif>Backend</option>
                           @endif
                        </select>
                         
                        </div>
                        


                        <!-- <div class="form-group">
                            <strong style="color:green;">Previous Adjustment</strong>
                            <input type="text" name="adjust" value="{{ Input::get('adjust') }}" class="form-control input-sm"
                                   placeholder="Enter Adjustment amout" value="">
                        </div> -->
                        <div class="form-group" style="margin-top:22px">
                            <input name="submit" type="submit" value="Search" class="btn btn-primary btn-sm">
                            <a href="{{ route('booking_lounge') }}" class="btn btn-primary btn-sm">Reset</a>
                        </div>
                    </form>

                </div>


                <br>
                <br>
                <br>
				@if(count($bookings) > 0)
                <div class="col-md-12"
                     style="border: 1px solid #e4e4e4; border-radius: 9px; margin-bottom: 10px;background: #f5f5f6;">
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
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total Booked
                            bookings: <span id="no_of_booking">  @php echo  $countCompleted;
                                @endphp</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total
                            PZ Revenue: <span id="total_share">{{$tot_rev}}</span></h2>




                    </div>
                    <!--div class="col-md-4 text-right section-right" style="margin-top: 22px;">

                        <a id="excel" class="btn btn-primary  btn-sm" href='{{ route("admin_booking_report_excel") }}?filter={{ Input::get("filter") }}&search={{ Input::get("search") }}&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::get("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}&no_of_days={{ Input::get("no_of_days") }}&agentID={{ Input::get("agentID") }}&booking_source={{ Input::get("booking_source") }}'><i class="fa fa-file-excel-o"></i> Download Excel</a>
                        <a id="excel" target="_blank" class="btn btn-primary  btn-sm" href='{{ route("admin_booking_report_pdf") }}?filter={{ Input::get("filter") }}&search=&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::get("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}'><i class="fa fa-file-pdf-o"></i>Download PDF</a>
                    </div-->

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

                                        <th style=""> Reference No</th>
                                        <th>Ext Ref</th>
                                        <th>Lounge</th>
                                        <th>Name</th>
                                        <th>Booking Date</th>
                                        <th>Checkin Date</th>
                                        
                                        <th>Booking status</th>
                                        <th>Discount Code</th>
                                        <th style="width: 70px;">Payment Method</th>
                                        <th>Net Amount</th>
                                        @if($role_name!="Marketing")
                                            <th>Booking Src</th>
                                            <th>Email</th>
										@endif
                                        <th>Action</th>
										
										@if($role_name!="Marketing")
										<th>Cancel</th>
										<th>Refund</th>
                                        <th>SMS</th>
										@endif


                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($bookings as $booking)

                                        @php    if($booking['booking_status']=='Completed') { @endphp

                                        <tr id="expand_{{  $booking->id  }}">
                                        @php } else { @endphp
                                        <tr style="color:red;" id="expand_{{  $booking->id  }}">
                                        @php }  @endphp

											<td style="">
                                                {{ $booking->referenceNo }}
                                            </td>
                                            <td class="">{{ $booking->referenceNo_ext }}</td>
                                            <td class="">{{ $booking->lounge_name }}</td>
                                            <td class="">{{ $booking->first_name." ".$booking->last_name }}</td>

                                            <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->createdate)) }}</td>
                                            <td class="">{{ date('d/m/Y', strtotime($booking->check_in)) }}</td>
                                            
                                            <td class="">{{ $booking->booking_status }}</td>
                                            <td class="">{{ $booking->discount_code }}</td>
                                            <td class="">
                                                @if($booking->payment_method=="stripe")
                                                    <span class="label label-sm label-info"><i
                                                                class="fa fa-cc-stripe"></i> {{ ucwords(preg_replace('/\s/', '', $booking->payment_method))  }}</span>


                                                @elseif($booking->payment_method=="payzone")
                                                    <span class="label label-sm label-info"><i
                                                                class="fa fa-paypal"></i> {{ ucwords(preg_replace('/\s/', '', $booking->payment_method))  }}</span>



                                                @endif
                                            </td>
                                            <td class="">£{{ $booking->total_amount }}</td>
											@if($role_name!="Marketing")
											<td>{{ $booking->traffic_src  }}</td>
											<td><i onclick="sendEmailForm('{{ $booking->id  }}','{{ $booking->companyId  }}')"
                                                                   class="btn btn-minier btn-warning fa fa-envelope"></i></td>
											@endif
											<td>
												@can('user_auth', ["view"])
												<i id="view_detail"
												   onclick="getDetail('{{ $booking->id  }}')"
												   class="btn btn-minier btn-success fa fa-eye"
												   title="View"></i>
														 @endcan
												@can('user_auth', ["edit"])
												<a id="edit" class="btn btn-minier btn-pink"
												   href="{{ route('edit_booking_form_lounge',[$booking->id]) }}"
												   title="Edit"> <i class="fa fa-pencil"
																	title="Edit"></i></a>
																	 @endcan

												<!--a id="edit" class="btn btn-minier btn-warning "
												   href="{{ route("edit_booking_form",[$booking->id]) }}"
												   title="Extand">
													<i class="fa fa-ellipsis-h"
													   title="Extend"></i></a>
												<i onclick="getTransferForm('{{ route("transferBookingForm",[$booking->id]) }}')"
												   class="btn btn-minier btn-info fa fa-exchange"
												   title="Transfer"></i-->

											</td>
											@if($role_name!="Marketing")
											<td>
												<i onclick="getcancelForm('{{ $booking->id  }}')"
												   class=" btn btn-minier btn-danger fa fa-times-circle"></i>

												<!--a id="cancel" class="btn btn-primary btn-minier" title="Cancel Booking Not show" onclick="return confirm('Are you sure want to cancel this booking..?')" href="{{ route('cancelNotShow',['id'=>$booking->id]) }}"><i class="entypo-cancel">Not Show</i></a-->

											</td>
											<td>
												<i onclick="getrefundForm('{{ $booking->id  }}')"
												   class="btn btn-minier btn-pink  fa fa-reply"></i>

												<!--a id="cancel" class="btn btn-primary btn-minier" title="Cancel Booking Not show" onclick="return confirm('Are you sure want to cancel this booking..?')" href="{{ route('cancelNotShow',['id'=>$booking->id]) }}"><i class="entypo-cancel">Not Show</i></a-->

											</td>
											<td>
												<i class="btn btn-minier btn-warning  fa fa-commenting" onclick="sendsms('{{ $booking->phone_number  }}','{{ $booking->referenceNo  }}')" ></i>
											</td>
										@endif
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

	function sendEmailForm(id) {
		ModelPopUp("<div id=\"resend_email\" ><div><h2>Resend Email</h2></div>\n" +
			"                        <!--label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\" type=\"radio\" value=\"company\" name=\"resendEmailto\">Company</label--->\n" +
			"                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\"  type=\"radio\" value=\"client\" name=\"resendEmailto\">Client</label>\n" +
			"                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
			"<input class=\"radio-resend\" type=\"radio\" value=\"all\" name=\"resendEmailto\" >ALL</label>\n" +
			"                        <input  onclick=\"sendEmail('" + id + "')\" class=\"btn btn-info\" value=\"Send\" style=\"margin: 15px 5px 5px 15px;\">\n" +
			"                        </div>");
	}

	function sendEmail(id) {
		var type = $('input[name=resendEmailto]:checked').val();
		$("#resend_email").html("<div id=\"resend_email\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");

		var data = {};
		data["id"] = id;
		data["type"] = type;
		data["_token"] = '{{ csrf_token() }}';
		$.post('{{ route("sendEmailBookingLounge") }}', data, function (data) {
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
	
	function getDetail(id) {
		ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
		var data = {};
		data["id"] = id;
		data["_token"] = '{{ csrf_token() }}';
		$.post('{{ route("bookingdetail_lounge") }}', data, function (data) {
			console.log("data===", data);
			$("#booking_detail_pop").html(data);
//
		});


	}

    function cancelModal(id) {
		ModelPopUp("<div style='text-align:center;'><div><h2>Are you sure to cancel this booking?</h2></div>\n" +
		
		
			"<input class=\"btn btn-danger close_btn\" type=\"button\" value=\"No\" data-dismiss=\"modal\" aria-label=\"Close\"> \t" +
			"                        <input  onclick=\"cancelBooking('" + id + "')\" class=\"btn btn-info\" value=\"Yes\" type=\"button\" >\n" +
			"   <div id='booking_detail_response' style='margin-top: 12px;'></div></div>");
	}
	
	
    function getcancelForm(id) {
		ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
		var data = {};
		data["id"] = id;
		data["_token"] = '{{ csrf_token() }}';
		$.post('{{ route("bookingdetail_lounge.cancelForm") }}', data, function (data) {
			console.log("data===", data);
			$("#booking_detail_pop").html(data);
//
		});


	}       
	function getrefundForm(id) {
		ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
		var data = {};
		data["id"] = id;
		data["_token"] = '{{ csrf_token() }}';
		$.post('{{ route("bookingdetail_lounge.refundForm") }}', data, function (data) {
			console.log("data===", data);
			$("#booking_detail_pop").html(data);
//
		});


	}


	function transferSubmit(id) {
		var cid = $("#company_id_pop option:selected").val();
		var html = "<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>";
		$("#booking_detail_pop").html(html);
		var data = {};
		data["id"] = id;
		data["_token"] = '{{ csrf_token() }}';
		data["new_cid"] = cid;
		$.post('{{ route("transferBooking") }}', data, function (data) {
			console.log("data===", data);
			$("#booking_detail_pop").html(data);
//
		});


	}


	function getTransferForm(url) {
		ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
		var data = {};
		// data["id"]=id;
		data["_token"] = '{{ csrf_token() }}';
		$.get(url, data, function (data) {
			console.log("data===", data);
			$("#booking_detail_pop").html(data);
//
		});


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
	function sendsms(phone_no,ref_no){
		var data = {};
		var url ='{{ url("admin/send_sms") }}/'+phone_no+'/'+ref_no;
		
		data["_token"] = '{{ csrf_token() }}';
		$.get(url,  function (data) {
			
			if(data == 200){
				$("#sms_response").html('<div class="alert alert-success"><strong>Success!</strong> SMS Successfully sent.</div>');
			}
			else{
				$("#sms_response").html('<div class="alert alert-danger"><strong>Error!</strong> SMS sending failed.</div>');			
			}
			
		});
	}
</script>
@endsection
