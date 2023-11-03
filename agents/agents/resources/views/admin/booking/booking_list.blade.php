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
                    <form action="{{ route('booking') }}" method="get" class="form-inline" style="margin-bottom: 10px;">
                        <div class="form-group" style="padding: 6px 2px;">
                            <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control"
                                   id="field-1" value=""
                                   placeholder="Search By Keyword" style="padding: 6px 2px; width:98%;">
                        </div>
                        <div class="form-group">
                            <select name="airport" class="form-control" style="padding: 6px 2px;">
                                <option value="all">All Airports</option>
                                @foreach($airports as $airport)
                                    <option @if(Input::get('airport')==$airport->id) {{ "selected='selected'" }} @endif value="{{ $airport->id }}">{{ $airport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        &nbsp; &nbsp;
                        <div class="form-group">
                            <select name="admins" class="form-control" style="padding: 6px 2px;">
                                <option value="all">All Admins</option>
                                @foreach($admins as $admin)
                                    <option @if(Input::get('admins')==$admin->id) {{ "selected='selected'" }} @endif value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        &nbsp; &nbsp;

                        <div class="form-group">
                            Filter by
                            <select name="filter" class="form-control" style="padding: 6px 2px; ">
                                <option value="all">All</option>
                                <option value="created_at" @if(Input::get('filter')=='created_at') {{ "selected='selected'" }} @endif >
                                    Booked Date
                                </option>
                                <option value="departDate" @if(Input::get('filter')=='departDate') {{ "selected='selected'" }} @endif>
                                    Departure Date
                                </option>
                                <option value="returnDate" @if(Input::get('filter')=='returnDate') {{ "selected='selected'" }} @endif >
                                    Arrival Date
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            From
                            <input type="text" name="start_date" id="start_date" autocomplete="off"
                                   class="form-control datepicker" placeholder="Start Date"
                                   data-date-format="dd-M-yyyy" value="{{ Input::get('start_date') }}"
                                   style="padding: 6px 2px;">
                        </div>
                        <div class="form-group">
                            To
                            <input class="form-control date-picker" value="{{ Input::get('end_date') }}"
                                   autocomplete="off" id="end_date" placeholder="End Date" name="end_date" type="text"
                                   data-date-format="dd-M-yyyy"/>

                        </div>
                        <div class="form-group">
                            <select name="companies" class="form-control" style="padding: 6px 2px;">
                                <option value="all">All Companies</option>
                                @foreach($companies_dlist as $company)
                                    <option @if(Input::get('companies')==$company->id) {{ "selected='selected'" }} @endif value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        &nbsp; &nbsp;
                        <div class="form-group">
                            <select name="payment" class="form-control" style="padding: 6px 2px;">
                                <option value="all">Payment Type</option>
                                <option value="payzone" @if(Input::get('payment')=='payzone') {{ "selected='selected'" }} @endif>
                                    Payzone
                                </option>
                            </select>
                        </div>
                        &nbsp; &nbsp;
                        <div class="form-group">
                            Status
                            <select id="my_status" name="status" class="form-control" style="padding: 6px 2px; "
                                    required="">
                                <option value="all">Booking Status</option>
                                <option value="Booked" @if(Input::get('status')=='Booked') {{ "selected='selected'" }} @endif>
                                    Booked
                                </option>
                                <option value="Amend" @if(Input::get('status')=='Amend') {{ "selected='selected'" }} @endif>
                                    Amend
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
                        </div> &nbsp;

                        <div class="form-group">
                        Source
                        <select name="booking_source" class="form-control" style="padding: 6px 2px;">
                           @if($role_name=='Marketing')
                            <option value="paid" @if(Input::get('booking_source')=='paid') {{ "selected='selected'" }} @endif>All</option>
                            <option value="PPC" @if(Input::get('booking_source')=='PPC') {{ "selected='selected'" }} @endif>PPC</option>
                            <option value="BING" @if(Input::get('booking_source')=='BING') {{ "selected='selected'" }} @endif>BING</option>';
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
                        &nbsp;  </div>

                        <div class="form-group">
                            Agent
                            <select name="agentID" class="form-control" style="padding: 6px 2px;">
                                    <option value="3" @if(Input::get('agentID')=='agentID') {{ "selected='selected'" }} @endif>Parkingzone</option>
                            </select>
                            &nbsp;  </div>

                        <div class="form-group">
                            Days
                            <select name="no_of_days" class="form-control" style="padding: 6px 2px;">

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





                            &nbsp;  </div>


                        <div class="form-group">
                            <strong style="color:green;">Previous Adjustment</strong>
                            <input type="text" name="adjust" value="{{ Input::get('adjust') }}" class="form-control"
                                   placeholder="Enter Adjustment amout" value="">
                        </div>
                        <div class="form-group">
                            <input name="submit" type="submit" value="Search" class="btn btn-primary">
                            <a href="{{ route("booking") }}" class="btn btn-primary">Reset</a>
                        </div>
                    </form>

                </div>


                <br>
                <br>
                <br>
                <div class="col-md-12"
                     style="border: 1px solid #e4e4e4;    border-radius: 9px; margin-bottom: 10px;background: #f5f5f6;">
                    <div class="col-md-6">
                        @php
                            $countCompleted=0;
                              foreach($bookings_count as $booking)
                              {


                                if($booking['booking_status']=='Completed')
                                $countCompleted++;



                              }



                        @endphp
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total Booked
                            bookings: <span id="no_of_booking">  @php echo  $countCompleted;
                                @endphp</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Total
                            Parkingzone share: <span id="total_share">0</span></h2>
                        <h2 class="badge badge-info" style="padding: 10px;"><i class="entypo-target"></i> Net
                            parkingzone share: <span id="net_share">0</span></h2>




                    </div>
                    <div class="col-md-6 text-right section-right" style="margin-top: 10px">

                        <a id="excel" class="btn btn-primary exxl" href="{{ route("admin_booking_report_excel") }}?filter={{ Input::get("filter") }}&search=&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::old("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}"><i class="entypo-download"></i>Download Excel</a>
                    </div>

                </div>

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

                                <table id="simple-table" class="table  table-bordered table-hover">
                                    <thead>
                                    <tr>

                                        <th> Reference No</th>
                                        <th>Airports</th>
                                        <th>Name</th>
                                        <th>Booking Date</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Booking status</th>
                                        <th>Discount Code</th>
                                        <th>Payment Method</th>
                                        <th>Refund</th>

                                        {{--<th>no of days</th>--}}


                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($bookings as $booking)

                                        {{--@php--}}
                                        {{--//dd($booking->airport);--}}
                                        {{--if($booking['booking_action'] == 'Booked' || $booking['booking_action'] == 'Amend'){--}}
                                        {{--$fly_share1 = (((($booking["share_percentage"]/100)*$booking["booking_amount"])-$booking['discount_amount'])+$row['booking_extra']);--}}
                                        {{--$count_bookings++;--}}
                                        {{--}--}}
                                        {{--else{--}}
                                        {{--$fly_share1 = 0;--}}

                                        {{--}--}}
                                        {{--if($booking['booking_action'] == 'cancelled'){--}}
                                        {{--$canccel_booked++;--}}
                                        {{--}--}}
                                        {{--$fly_share += $fly_share1;--}}

                                        {{--@endphp--}}
                                        @php    if($booking['booking_status']=='Completed') { @endphp

                                        <tr id="expand_{{  $booking->id  }}">
                                        @php } else { @endphp
                                        <tr style="color:red;" id="expand_{{  $booking->id  }}">
                                            @php }  @endphp

                                            <td style="width: 14%;">
                                                <i class="fa fa-plus-circle" id="show_detail_icon_{{  $booking->id  }}"
                                                   style="cursor: pointer; font-size: 20px;"
                                                   onclick="show_detal('{{  $booking->id  }}')"></i> {{ $booking->referenceNo }}
                                            </td>
                                            <td class="hidden-480">@if($booking->airport) <span
                                                        class="label label-lg label-success"><i
                                                            class="fa fa-plane"></i> {{ ucwords(preg_replace('/\s/', '', $booking->airport->name))  }}</span>  @endif
                                            </td>
                                            <td class="hidden-480">{{ $booking->first_name." ".$booking->last_name }}</td>

                                            <td class="hidden-480">{{ $booking->created_at }}</td>
                                            <td class="hidden-480">{{ $booking->departDate }}</td>
                                            <td class="hidden-480">{{ $booking->returnDate }}</td>
                                            <td class="hidden-480">{{ $booking->booking_status }}</td>
                                            <td class="hidden-480">{{ $booking->discount_code }}</td>
                                            <td class="hidden-480">
                                                @if($booking->payment_method=="stripe")
                                                    <span class="label label-lg label-info"><i
                                                                class="fa fa-cc-stripe"></i> {{ ucwords(preg_replace('/\s/', '', $booking->payment_method))  }}</span>


                                                @elseif($booking->payment_method=="payzone")
                                                    <span class="label label-lg label-info"><i
                                                                class="fa fa-paypal"></i> {{ ucwords(preg_replace('/\s/', '', $booking->payment_method))  }}</span>



                                                @endif
                                            </td>
                                            <td class="hidden-480">0</td>
                                            {{--<td class="hidden-480">{{ $booking->total_amount}}</td>--}}
                                            {{--<td class="hidden-480">{{ $booking->no_of_days}}</td>--}}
                                            @php
                                                $share = 0;
                                                    if($booking->company){ $share = $booking->company->share_percentage; }
                                                    $fly_share = ((($share/100)*$booking->booking_amount )-$booking->discount_amount)+$booking->booking_extra;
                                            @endphp

                                        </tr>
                                        <tr style="display: none" id="detail_{{  $booking->id  }}">
                                            <td colspan="11">
                                                <div class="col-md-4">
                                                    <table class="table table-bordered table-striped">

                                                        <tbody>

                                                            @if($role_name!="Marketing")
                                                        <tr>
                                                            <td colspan="2">Net Amount</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><span
                                                                        class="label label-lg col-md-12 col-xl-12 col-lg-12 label-success">£{{ $booking->booking_amount  }}</span>
                                                            </td>
                                                        </tr>
                                                        @endif

                                                        <tr>
                                                            <td colspan="2">Parkingzone Share</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><span
                                                                        class="label col-md-12 col-xl-12 col-lg-12 label-lg label-info">£{{ $fly_share  }}</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>No of Days</td>
                                                            <td>{{ $booking->no_of_days  }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Booking Src</td>
                                                            <td>{{ $booking->traffic_src  }}</td>
                                                        </tr>

 @if($role_name!="Marketing")
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>
                                                                <i onclick="sendEmailForm('{{ $booking->id  }}','{{ $booking->companyId  }}')"
                                                                   class="btn btn-minier btn-grey fa fa-envelope"></i>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Action</td>
                                                            <td>
                                                                @can('user_auth', ["view"])
                                                                <i id="view_detail"
                                                                   onclick="getDetail('{{ $booking->id  }}')"
                                                                   class="btn btn-minier btn-success fa fa-eye"
                                                                   title="View"></i>
                                                                         @endcan
                                                        @can('user_auth', ["edit"])
                                                                <a id="edit" class="btn btn-minier btn-primary"
                                                                   href="{{ route("edit_booking_form",[$booking->id]) }}"
                                                                   title="Edit"> <i class="fa fa-pencil"
                                                                                    title="Edit"></i></a>
                                                                                     @endcan

                                                                <a id="edit" class="btn btn-minier btn-inverse "
                                                                   href="{{ route("edit_booking_form",[$booking->id]) }}"
                                                                   title="Extand">
                                                                    <i class="fa fa-ellipsis-h"
                                                                       title="Extend"></i></a>
                                                                <i onclick="getTransferForm('{{ route("transferBookingForm",[$booking->id]) }}')"
                                                                   class="btn btn-minier btn-info fa fa-exchange"
                                                                   title="Transfer"></i>

                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Cancel</td>
                                                            <td>
                                                                <i onclick="getcancelForm('{{ $booking->id  }}')"
                                                                   class=" btn btn-minier btn-danger fa fa-times-circle"></i>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Refund</td>
                                                            <td><i onclick="getrefundForm('{{ $booking->id  }}')"
                                                                   class="btn btn-minier btn-pink  fa fa-reply"></i>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Sms</td>
                                                            <td>
                                                                <i class="btn btn-minier btn-warning  fa fa-commenting"></i>
                                                            </td>
                                                        </tr>
                                                        @endif

                                                        </tbody>

                                                    </table>
                                                </div>


                                                {{--<ul data-dtr-index="0" class="col-md-3">--}}
                                                {{--<li data-dtr-index="10"><span class="dtr-title">Net Amount:</span>--}}
                                                {{--<span--}}
                                                {{--class="dtr-data"><strong--}}
                                                {{--class="badge badge-success badge-roundless"--}}
                                                {{--style="width:100%;"></strong></span>--}}
                                                {{--</li>--}}
                                                {{--<li data-dtr-index="11"><span class="dtr-title">Fly Share:</span>--}}
                                                {{--<span--}}
                                                {{--class="dtr-data"><strong--}}
                                                {{--class="badge badge-info badge-roundless"--}}
                                                {{--style="width:100%;"></strong></span>--}}
                                                {{--</li>--}}
                                                {{--<li data-dtr-index="12"><span class="dtr-title">No of Days:</span>--}}
                                                {{--<span--}}
                                                {{--class="dtr-data"> </span>--}}
                                                {{--</li>--}}
                                                {{--<li data-dtr-index="13"><span class="dtr-title">Booking Src:</span>--}}
                                                {{--<span class="dtr-data"></span></li>--}}
                                                {{--<li data-dtr-index="14"><span class="dtr-title">Email:</span> <span--}}
                                                {{--class="dtr-data"><a class="btn btn-info btn-xs"--}}
                                                {{--onclick="showResendModal(904,'101');"--}}
                                                {{--title="Resend Email"><i--}}
                                                {{--class="entypo-mail"></i></a></span></li>--}}
                                                {{--<li data-dtr-index="15"><span class="dtr-title">Action:</span> <span--}}
                                                {{--class="dtr-data"><a id="view"--}}
                                                {{--class="btn btn-info btn-xs popId"--}}
                                                {{--data-toggle="modal"--}}
                                                {{--data-target="#Booking_Detail_AP-170608904"--}}
                                                {{--title="BookingHistory"--}}
                                                {{--onclick="showhistoryModal('AP-170608904');"><i--}}
                                                {{--class="entypo-book-open"></i></a>--}}

                                                {{--<a id="view" class="btn btn-info btn-xs popId" data-toggle="modal"--}}
                                                {{--data-target="#Booking_Detail_904" title="Booking Details"--}}
                                                {{--onclick="showAjaxModal(904);"><i class="entypo-eye"></i></a>--}}

                                                {{--<a id="transfer" class="btn btn-info btn-xs popId" data-toggle="modal"--}}
                                                {{--data-target="#Booking_transfer_904" title="Booking Transfer"--}}
                                                {{--onclick="showtransferModal(904);"><i class="entypo-switch"></i></a></span></li>--}}
                                                {{--<li data-dtr-index="16"><span class="dtr-title">Canc:</span> <span--}}
                                                {{--class="dtr-data"><a id="cancel"--}}
                                                {{--class="btn btn-danger btn-xs"--}}
                                                {{--data-toggle="modal"--}}
                                                {{--data-target="#Booking_Detail_904"--}}
                                                {{--title="Cancel Booking"--}}
                                                {{--onclick="cancel_refund(904,'cancel');"><i--}}
                                                {{--class="entypo-cancel"></i></a>--}}

                                                {{--<a id="cancel" class="btn btn-primary btwn-xs" title="Cancel Booking Not show"--}}
                                                {{--onclick="return confirm('Are you sure want to cancel this booking..?')"--}}
                                                {{--href="index.php?p=company_bookings&amp;mode=cancel_not_show&amp;id=904"><i--}}
                                                {{--class="entypo-cancel">Not Show</i></a></span></li>--}}
                                                {{--<li data-dtr-index="17"><span class="dtr-title">Refund:</span> <span--}}
                                                {{--class="dtr-data"><a id="refund"--}}
                                                {{--class="btn btn-warning btn-xs"--}}
                                                {{--data-toggle="modal"--}}
                                                {{--data-target="#Booking_Detail_904"--}}
                                                {{--title="Refund"--}}
                                                {{--onclick="cancel_refund(904,'refund');"><i--}}
                                                {{--class="entypo-shareable"></i></a></span></li>--}}
                                                {{--<li data-dtr-index="18"><span class="dtr-title">Sms:</span> <span--}}
                                                {{--class="dtr-data"><b><a class="btn btn-danger btn-xs"--}}
                                                {{--onclick="return confirm('Are you sure?')"><i--}}
                                                {{--class="entypo-phone"></i></a></b></span>--}}
                                                {{--</li>--}}
                                                {{--</ul>--}}
                                            </td>
                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>

                                {{ $bookings->links("vendor.pagination.default") }}
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
                {{--<script src="{{ secure_asset("assets/js/jquery.min.js") }}"></script>--}}
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
                        data["id"] = id;
                        data["_token"] = '{{ csrf_token() }}';
                        $.post('{{ route("bookingdetail.show") }}', data, function (data) {
                            console.log("data===", data);
                            $("#booking_detail_pop").html(data);
//
                        });


                    }


                    function getcancelForm(id) {
                        ModelPopUp("<div id=\"booking_detail_pop\" style=\"text-align: center;\"><img src='{{ secure_asset("assets/images/loader.gif") }}'/> </div>");
                        var data = {};
                        data["id"] = id;
                        data["_token"] = '{{ csrf_token() }}';
                        $.post('{{ route("bookingdetail.cancelForm") }}', data, function (data) {
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
                        $.post('{{ route("bookingdetail.refundForm") }}', data, function (data) {
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

                </script>
@endsection
