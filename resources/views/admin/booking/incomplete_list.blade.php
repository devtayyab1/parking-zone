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
        padding: 3px 10px;
        margin-top: 18px;
    }
</style>
    <div class="page-content">


        <div class="page-header">
            <h1>
                Incomplete Bookings
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    List
                </small>
            </h1>
        </div><!-- /.page-header -->

     <div class="row">
                <div class="col-md-12">
                       <form action="{{ route('Incomplete') }}" method="get" class="form-inline" style="margin-bottom: 10px;">
            <div class="form-group" >
                Search
                <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control input-sm" id="field-1" value=""
                       placeholder="Search By Keyword" >
            </div>
           
            
           <div class="form-group">
            All Airports
                <select name="airport" class="form-control input-sm" >					<option value="all">All Airports</option>					@foreach($airports as $airport)						<option @if(Input::get('airport')==$airport->id) {{ "selected='selected'" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>					@endforeach				</select>
            </div>
              <div class="form-group">
                            Agent
                           <select name="agentID" class="form-control input-sm" >
                                        @foreach($agentsList as $key=>$agentsList)                                
                                        @php $checked='none'; @endphp
                                        @if(in_array($key,$user_role_agents))
                                            @php $checked=true; @endphp
                                        @endif
                                        
                                    <option value="{{$key}}" @if(Input::get('agentID')==$key) {{ "selected='selected'" }}@endif style="display:{{$checked}};">{{$agentsList}}</option>  
                                @endforeach
                            </select>
                          </div>

            
   <div class="form-group">
                Filter by
                <select name="filter" class="form-control input-sm" style="padding: 6px 2px; ">
                    <option value="all">All</option>
                    <option value="created_at" @if(Input::get('filter')=='created_at') {{ "selected='selected'" }} @endif >Booked Date</option>
                    <option value="departDate" @if(Input::get('filter')=='departDate') {{ "selected='selected'" }} @endif>Departure Date</option>
                    <option value="returnDate" @if(Input::get('filter')=='returnDate') {{ "selected='selected'" }} @endif >Arrival Date</option>
                </select>
            </div>
            <div class="form-group">
                From
                <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control input-sm datepicker" placeholder="Start Date"
                       data-date-format="dd-M-yyyy" value="{{ Input::get('start_date') }}" >
            </div>
            <div class="form-group">
                To
                <input class="form-control input-sm date-picker" value="{{ Input::get('end_date') }}" autocomplete="off" id="end_date" placeholder="End Date" name="end_date" type="text"
                       data-date-format="dd-M-yyyy"/>

            </div>
           
         
            <div class="form-group">
                <input name="submit" type="submit" value="Search" class="btn btn-primary btn-sm">
                <a href='{{ route("incomplete_Booking") }}' class="btn btn-primary btn-sm">Reset</a>
            </div>
        </form>
                 
                </div>

                 
                </div>

                <br>
                <br>
                <br>


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
<div class="table table-responsive">
                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                            <tr>

                                <th>Reference No</th>
                                <th>Name</th>
                                <th>Departure Date</th>
                                <th>Return Date</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>No of Days</th>
                                <th>Action</th>


                             
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($bookings as $booking)
                                <tr style = "color:red">

     <td style="width: 14%;">
                                               {{ $booking->referenceNo }}
                                            </td>
                                    <td class="">{{ $booking->first_name." ".$booking->last_name }}</td>
                                    <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->departDate)) }}</td>
                                    <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->returnDate)) }}</td>
                                    <td class="">{{ date('d/m/Y h:i:s', strtotime($booking->created_at)) }}</td>
                                    <td class="">{{ $booking->booking_status }}</td>
                                    <td class="">{{ $booking->no_of_days }}</td>
                                    <td>
                                          @can('user_auth', ["edit"])
                                        <a id="edit" class="btn btn-success btn-xs" href="{{ route("edit_booking_form",[$booking->id]) }}" </a>
                                        
                                    <i class="fa fa-pencil"></i></td>

 @endcan

                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $bookings->appends(request()->input())->links("vendor.pagination.default") }}
                    </div><!-- /.span -->
                </div><!-- /.row -->


                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
   
@endsection
@section("footer-script")
    <script src="{{ secure_asset("assets/js/moment.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/daterangepicker.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/bootstrap-datetimepicker.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/bootstrap-timepicker.min.js") }}"></script>


    <!-- page specific plugin scripts -->
    <script src="{{ secure_asset("assets/js/wizard.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/jquery.validate.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/jquery-additional-methods.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/bootbox.js") }}"></script>
    <script src="{{ secure_asset("assets/js/jquery.maskedinput.min.js") }}"></script>
    <script src="{{ secure_asset("assets/js/select2.min.js") }}"></script>
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
                    <script src="{{ secure_asset("assets/front/js/bootbox.js") }}"></script>
                    <script>

                        function show_detal(id) {
                            if ($("#show_detail_icon_" + id).hasClass("fa-plus-circle")) {
                                $("#show_detail_icon_" + id).removeClass("fa-plus-circle");
                                $("#show_detail_icon_" + id).addClass("fa-minus-circle");
                            } else {
                                $("#show_detail_icon_" + id).removeClass("fa-minus-circle");
                                $("#show_detail_icon_" + id).addClass("fa-plus-circle");
                            }

                            $("#detail_" + id).toggle();
                        }
                        function sendEmailForm(id,cmpID){
                            ModelPopUp("<div id=\"resend_email\" ><div><h2>Resend Email</h2></div>\n" +
                                "                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
                                "<input class=\"radio-resend\" type=\"radio\" value=\"company\" name=\"resendEmailto\">Company</label>\n" +
                                "                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
                                "<input class=\"radio-resend\"  type=\"radio\" value=\"client\" name=\"resendEmailto\">Client</label>\n" +
                                "                        <label class=\"radio-inline\" style=\"font-size: 16px;\">" +
                                "<input class=\"radio-resend\" type=\"radio\" value=\"all\" name=\"resendEmailto\" >ALL</label>\n" +
                                "                        <input  onclick=\"sendEmail('"+id+"','"+cmpID+"')\" class=\"btn btn-info\" value=\"Send\" style=\"margin: 15px 5px 5px 15px;\">\n" +
                                "                        </div>");
                        }
                        function sendEmail(id,cid) {
                            $("#resend_email").html("<div id=\"resend_email\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");

                            var data = {};
                            data["id"]=id;
                            data["cid"]=cid;
                            data["type"]=$('input[name=resendEmailto]:checked').val();
                            data["_token"]='{{ csrf_token() }}';
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

//                        jQuery(function($) {
//                            $("#view_detail").on(ace.click_event, function () {
//
//
//
//                                ModelPopUp('');
//                            });
//
//
//
//                        });


                        function getDetail(id) {
                            ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
                            var data = {};
                            data["id"]=id;
                            data["_token"]='{{ csrf_token() }}';
                            $.post('{{ route("bookingdetail.show") }}', data, function (data) {
                                console.log("data===", data);
                                $("#booking_detail_pop").html(data);
//
                            });



                        }


                        function getcancelForm(id) {
                            ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
                            var data = {};
                            data["id"]=id;
                            data["_token"]='{{ csrf_token() }}';
                            $.post('{{ route("bookingdetail.cancelForm") }}', data, function (data) {
                                console.log("data===", data);
                                $("#booking_detail_pop").html(data);
//
                            });



                        }

                        function getrefundForm(id) {
                            ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
                            var data = {};
                            data["id"]=id;
                            data["_token"]='{{ csrf_token() }}';
                            $.post('{{ route("bookingdetail.refundForm") }}', data, function (data) {
                                console.log("data===", data);
                                $("#booking_detail_pop").html(data);
//
                            });



                        }


                        function transferSubmit(id) {
                           var html = "<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>";
                            $("#booking_detail_pop").html(html);
                            var data = {};
                            data["id"]=id;
                            data["_token"]='{{ csrf_token() }}';
                            data["new_cid"]=$("#company_id_pop option:selected").val();
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
                            data["_token"]='{{ csrf_token() }}';
                            $.get(url, data, function (data) {
                                console.log("data===", data);
                                $("#booking_detail_pop").html(data);
//
                            });



                        }
                        
                        function ModelPopUp(message) {
                            bootbox.dialog({
                                message: message,
                                size : "large",
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

