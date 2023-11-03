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

            <ol class="breadcrumb bc-3">

                <li><a href="Dashboad">Dashboad</a></li>

                <li>Reports</li>

                <li class="active"><strong>Company Commission Report</strong></li>

            </ol>

        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-md-6">

                <h2>Company Commission Report</h2>

            </div>



        </div>

        <form action="{{ route("company_report") }}" method="get" class="form-inline" style="margin-bottom: 10px;">

            <div class="form-group" style="padding: 6px 2px;">

                <input type="text" value="{{ Input::get('search') }}" name="search" class="form-control" id="field-1" value=""

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

                    <option value="payzone" @if(Input::get('payment')=='payzone') {{ "selected='selected'" }} @endif>Payzone</option>

                </select>

            </div>

            &nbsp; &nbsp;

            <div class="form-group">

                Status

                <select id="my_status" name="status" class="form-control" style="padding: 6px 2px; " required="">

                    <option value="all">Booking Status</option>

                    <option value="Booked" @if(Input::get('status')=='Booked') {{ "selected='selected'" }} @endif>Booked</option>

                    <option value="Amend" @if(Input::get('status')=='Amend') {{ "selected='selected'" }} @endif>Amend</option>

                    <option value="Refund" @if(Input::get('status')=='Refund') {{ "selected='selected'" }} @endif>Refund</option>

                    <option value="Cancelled" @if(Input::get('status')=='Cancelled') {{ "selected='selected'" }} @endif>Cancelled</option>

                    <option value="Noshow" @if(Input::get('status')=='Noshow') {{ "selected='selected'" }} @endif>No Show</option>

                </select>

            </div> &nbsp; &nbsp;



            <div class="form-group">

                Filter by

                <select name="filter" class="form-control" style="padding: 6px 2px; ">

                    <option value="all">All</option>

                    <option value="created_at" @if(Input::get('filter')=='created_at') {{ "selected='selected'" }} @endif >Booked Date</option>

                    <option value="departDate" @if(Input::get('filter')=='departDate') {{ "selected='selected'" }} @endif>Departure Date</option>

                    <option value="returnDate" @if(Input::get('filter')=='returnDate') {{ "selected='selected'" }} @endif >Arrival Date</option>

                </select>

            </div>

            <div class="form-group">

                From

                <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control datepicker" placeholder="Start Date"

                       data-date-format="dd-M-yyyy" value="{{ Input::get('start_date') }}" style="padding: 6px 2px;">

            </div>

            <div class="form-group">

                To

                <input class="form-control date-picker" value="{{ Input::get('end_date') }}" autocomplete="off" id="end_date" placeholder="End Date" name="end_date" type="text"

                       data-date-format="dd-M-yyyy"/>



            </div>

            <div class="form-group">

                <strong style="color:green;">Previous Adjustment</strong>

                <input type="text" name="adjust" value="{{ Input::get('adjust') }}" class="form-control" placeholder="Enter Adjustment amout" value="">

            </div>

            <div class="form-group">

                <input name="submit" type="submit" value="Search" class="btn btn-primary">

                <a href="{{ route("company_report") }}" class="btn btn-primary">Reset</a>

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

                                <div class="col-md-12 text-right section-right" style="margin-top: 10px">



                                    <a id="excel" class="btn btn-primary exxl" href="{{ route("company_report_excel") }}?filter={{ Input::get("filter") }}&search=&start_date={{ Input::get("start_date") }}&end_date={{ Input::get("end_date") }}&companies={{ Input::get("companies") }}&airport={{ Input::get("airport") }}&status={{ Input::old("status") }}&admins={{ Input::get("admins") }}&payment={{ Input::get("payment") }}&refund_via={{ Input::get("refund_via") }}&palenty_to={{ Input::get("palenty_to") }}"><i class="entypo-download"></i>Download Excel</a>

                                </div>

                            @endif

                            <div class="">

                        <table class="table table-bordered table-striped table-condensed dataTable" id="table-1"

                               role="grid" aria-describedby="table-1_info">

                            <thead>



                            <tr role="row">



                                <th>Reference#</th>

                                <th>Name</th>

                                <th>Booking Date </th>

                                <th>Departure Date </th>

                                <th>Return Date </th>

                                <th>Days</th>

                                <th>Payment Method</th>

                                <th>Booking Amount</th>

                                <th>Company Commission</th>

                                <th>Parkingzone Commission</th>



                            </tr>



                            </thead>



                            <tbody>

                            @foreach($companies as $company)

                                <tr>





                                    <td> {{ $company['referenceNo'] }}</td>

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

                                    <td> {{ (float)number_format($company['AmountPaid'] ,3) }} </td>

                                    <td> {{ (float)number_format($company['commission'] ,3) }} </td>





                                </tr>

                            @endforeach





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







@endsection

