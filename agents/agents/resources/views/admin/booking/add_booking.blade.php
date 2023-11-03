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

    <style type="text/css">
        .awards-pic {
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .awards-pic img {
            width: 80px;
        }

        .leftText {
            margin-top: 10px;
        }

        .pad0 {
            padding: 0px;
        }

        .companies-listing {
            border: 1px solid #ccc;
            padding: 20px;
        }

        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 1500ms infinite linear;
            -moz-animation: spinner 1500ms infinite linear;
            -ms-animation: spinner 1500ms infinite linear;
            -o-animation: spinner 1500ms infinite linear;
            animation: spinner 1500ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .error {
            color: red;
        }
    </style>
@endsection

@section('content')

    <div class="loading" id="loading" style="display: none;">Loading&#8230;</div>


    <div class="page-content">


        <div class="page-header">
            <h1>
                Booking
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    @if($type=="add") Add  @else Update @endif
                </small>
            </h1>
        </div><!-- /.page-header -->

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

                        <div class="col-md-9">
                            <div class="panel panel-default">

                                <div class="panel-heading">  @if($type=="add") Add  @else Update @endif Booking</div>
                                <div class="panel-body">


                                    <div id="fuelux-wizard-container">
                                        <div class="steps-container">
                                            <ul class="steps">
                                                <li data-step="1" class="active">
                                                    <span class="step">1</span>
                                                    <span class="title">Booking Details</span>
                                                </li>

                                                <li data-step="2" class="active">
                                                    <span class="step">2</span>
                                                    <span class="title">Select Airport</span>
                                                </li>

                                                <li data-step="3">
                                                    <span class="step">3</span>
                                                    <span class="title">Personal Details</span>
                                                </li>

                                                <li data-step="4">
                                                    <span class="step">4</span>
                                                    <span class="title">Flight and Car Details</span>
                                                </li>

                                                <li data-step="5">
                                                    <span class="step">5</span>
                                                    <span class="title">Payment Details</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <hr/>

                                        <div class="step-content pos-rel">
                                            <div class="step-pane active" data-step="1">

                                                <form id="quote">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Airports', 'Select Airport', array('class' => 'col-sm-12')) }}

                                                            <div class="form-control-sm"></div>
                                                            <div class="col-sm-12">
                                                                {{ Form::select('airport_id',$airports,null,["class"=>"form-control","id"=>"airport_id","required"=>"required"]) }}

                                                            </div>

                                                            @if ($errors->has('airport_id'))

                                                                <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"
                                                                     style="clear: both;">
                                                                    <strong>{{ $errors->first('airport_id') }}</strong>
                                                                </div>
                                                            @endif


                                                        </div>

                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Departure Date', 'Departure Date', array('class' => 'col-sm-12')) }}


                                                            <div class="col-sm-12">
                                                                {{ Form::text('dep_date',  Input::old('dep_date'), array('class' => 'col-xs-9 col-sm-9 date-picker',"data-date-format"=>"dd-mm-yyyy","id"=>"dep_date","required"=>"required")) }}
                                                                {{--<span class="input-group-addon">--}}
                                                                {{--<i class="fa fa-calendar" style="font-size: 145%!important"></i>--}}
                                                                {{--</span>--}}

                                                                @if ($errors->has('dep_date'))

                                                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                                                         style="clear: both;">
                                                                        <strong>{{ $errors->first('dep_date') }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Departure Time', 'Departure Time', array('class' => 'col-sm-12')) }}


                                                            <div class="col-sm-12">
                                                                {{ Form::text('departure_time',  Input::old('departure_time'), array("id"=>"departure_time",'class' => 'col-xs-12 col-sm-12',"required"=>"required")) }}


                                                                @if ($errors->has('departure_time'))

                                                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                                                         style="clear: both;">
                                                                        <strong>{{ $errors->first('departure_time') }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <br>
                                                    <br>

                                                    <br>
                                                    <br>

                                                    <br>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Return Date', 'Return Date', array('class' => 'col-sm-12')) }}


                                                            <div class="col-sm-12">
                                                                {{ Form::text('return_date',  Input::old('return_date'), array("id"=>"return_date",'class' => 'col-xs-9 col-sm-9 date-picker',"required"=>"required")) }}

                                                                {{--<span class="input-group-addon">--}}
                                                                {{--<i class="fa fa-calendar" style="font-size: 145%!important"></i>--}}
                                                                {{--</span>--}}
                                                                @if ($errors->has('return_date'))

                                                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                                                         style="clear: both;">
                                                                        <strong>{{ $errors->first('return_date') }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Return Time', 'Return Time', array('class' => 'col-sm-12')) }}


                                                            <div class="col-sm-12">
                                                                {{ Form::text('return_time',  Input::old('return_time'), array("id"=>"return_time",'class' => 'col-xs-12 col-sm-12',"required"=>"required")) }}


                                                                @if ($errors->has('return_time'))

                                                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                                                         style="clear: both;">
                                                                        <strong>{{ $errors->first('return_time') }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {{ Form::label('Promo', 'Promo', array('class' => 'col-sm-12')) }}


                                                            <div class="col-sm-12">
                                                                {{ Form::text('promo',  Input::old('promo'), array("id"=>"promo",'class' => 'col-xs-12 col-sm-12')) }}


                                                                @if ($errors->has('promo'))

                                                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                                                         style="clear: both;">
                                                                        <strong>{{ $errors->first('promo') }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>


                                                </form>


                                            </div>

                                            <div class="step-pane" data-step="2" id="step_2_companies"
                                                 style="overflow-y: scroll;">


                                            </div>

                                            <div class="step-pane" data-step="3">
                                                <form id="personal_detail">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1"
                                                                   class="col-sm-12 control-label">Title</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control bf-slctfld" name="title"
                                                                        id="title">
                                                                    <option value="Mr">Mr</option>
                                                                    <option value="Mrs">Mrs</option>
                                                                    <option value="Miss">Miss</option>
                                                                    <option value="Ms">Ms</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">First
                                                                Name:</label>
                                                            <div class="col-sm-12">
                                                                <input id="first_name" required type="text" value=""
                                                                       name="first_name"
                                                                       data-validate="required"
                                                                       data-message-required="First Name is Required."
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Last
                                                                Name:</label>
                                                            <div class="col-sm-12">
                                                                <input id="last_name" required type="text" value=""
                                                                       name="last_name"
                                                                       data-validate="required"
                                                                       data-message-required="Last Name is Required."
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1"
                                                                   class="col-sm-12 control-label">Email</label>
                                                            <div class="col-sm-12">
                                                                <input id="email" required name="email" type="text"
                                                                       class="form-control"
                                                                       data-validate="required,email"
                                                                       aria-invalid="true"
                                                                       aria-describedby="email-error"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1"
                                                                   class="col-sm-12 control-label">Contact</label>
                                                            <div class="col-sm-12">
                                                                <input required name="contact" id="contact" type="text"
                                                                       value=""
                                                                       data-validate="required,number,minlength[1],maxlength[11]"
                                                                       data-message-required="Contact Number is Required."
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Find
                                                                Address</label>
                                                            <div class="col-sm-12">
                                                                <div id="postcode_lookup"></div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1"
                                                                   class="col-sm-12 control-label">Address</label>
                                                            <div class="col-sm-12">
                                                                <input required name="address" id="address" type="text"
                                                                       value=""
                                                                       data-validate="required"
                                                                       data-message-required="Address is Required."
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Address
                                                                2</label>
                                                            <div class="col-sm-12">
                                                                <input name="address2" id="address2" type="text"
                                                                       value=""
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Postal
                                                                Code</label>
                                                            <div class="col-sm-12">
                                                                <input required name="postal_code" id="post_code"
                                                                       type="text"
                                                                       value=""
                                                                       data-validate="required"
                                                                       data-message-required="Post Code is Required."
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1"
                                                                   class="col-sm-12 control-label">Town</label>
                                                            <div class="col-sm-12">
                                                                <input name="town" id="town" type="text" value=""
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{--<div class="col-sm-3" id="passenger">--}}
                                                    {{--<div class="form-group">--}}
                                                    {{--<label for="field-1" class="col-sm-12 control-label">Number of--}}
                                                    {{--passengers</label>--}}
                                                    {{--<div class="col-sm-12">--}}
                                                    {{--<select class="form-control bf-slctfld" name="passenger">--}}
                                                    {{--<option value="1">1</option>--}}
                                                    {{--<option value="2">2</option>--}}
                                                    {{--<option value="3">3</option>--}}
                                                    {{--<option value="4">4</option>--}}
                                                    {{--<option value="5">5</option>--}}
                                                    {{--<option value="6">6</option>--}}
                                                    {{--<option value="7">7</option>--}}
                                                    {{--<option value="8">8</option>--}}
                                                    {{--<option value="9">9</option>--}}
                                                    {{--<option value="10">10</option>--}}
                                                    {{--</select>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                </form>
                                            </div>

                                            <div class="step-pane" data-step="4">
                                                <div class="col-lg-12 grid-box">
                                                    <h4>Flight and Car Details</h4>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Departure
                                                                Flight
                                                                No</label>

                                                            <div class="col-sm-12">
                                                                <input name="dept_flight_no" id="dept_flight_no"
                                                                       type="text" value=""
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Return
                                                                Flight
                                                                No</label>

                                                            <div class="col-sm-12">
                                                                <input name="return_flight_no" id="return_flight_no"
                                                                       type="text" value=""
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Outbond
                                                                Terminal</label>
                                                            <div class="col-sm-12">
                                                                <select name="departure_terminal"
                                                                        id="departure_terminal" type="text"
                                                                        data-validate="required"
                                                                        data-message-required="Departure Terminal No is Required."
                                                                        class="form-control">


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="col-sm-12 control-label">Inbond
                                                                Terminal</label>
                                                            <div class="col-sm-12">
                                                                <select name="return_terminal" id="return_terminal"
                                                                        type="text" data-validate="required"
                                                                        data-message-required="Arrival Terminal is Required."
                                                                        class="form-control">


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="myflight">
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Vehicle
                                                                    Make</label>
                                                                <div class="col-sm-12">
                                                                    <input name="veh_make" id="veh_make" type="text"
                                                                           value="" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Vehicle
                                                                    Model</label>
                                                                <div class="col-sm-12">
                                                                    <input name="veh_model" id="veh_model" type="text"
                                                                           value="" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Vehicle
                                                                    Colour</label>
                                                                <div class="col-sm-12">
                                                                    <input name="veh_colour" id="veh_colour" type="text"
                                                                           value="" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Vehicle
                                                                    Registration</label>
                                                                <div class="col-sm-12">
                                                                    <input name="veh_registration" id="veh_registration"
                                                                           type="text" value="" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="step-pane" data-step="5">
                                                <form id="payment_detail">
                                                    <div class="col-lg-12 grid-box">
                                                        <h4>Payment Details</h4>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Transaction
                                                                    Id:</label>
                                                                <div class="col-sm-12">
                                                                    <input required type="text" value=""
                                                                           name="transaction_id"
                                                                           id="transaction_id"
                                                                           data-validate="required"
                                                                           data-message-required="Transaction id is Required."
                                                                           class="form-control" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label for="field-1"
                                                                       class="col-sm-12 control-label">Payzone:</label>
                                                                <div class="col-sm-12">
                                                                    <input required type="radio" value="payzone"
                                                                           name="payment_method"
                                                                           data-validate="required"
                                                                           data-message-required="Payment Method is Required."
                                                                           class="form-control" style="width: 20%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label for="field-1" class="col-sm-12 control-label">Stripe:</label>
                                                                <div class="col-sm-12">
                                                                    <input name="payment_method" type="radio"
                                                                           class="form-control" data-validate="required"
                                                                           data-message-required="Payment Method is Required."
                                                                           value="stripe" style="width: 20%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label for="field-1"
                                                                       class="col-sm-12 control-label">Cash:</label>
                                                                <div class="col-sm-12">
                                                                    <input name="payment_method" type="radio"
                                                                           value="cash"
                                                                           data-validate="required"
                                                                           data-message-required="Payment Method id is Required."
                                                                           class="form-control" style="width: 20%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="wizard-actions">
                                        <button class="btn btn-prev">
                                            <i class="ace-icon fa fa-arrow-left"></i>
                                            Prev
                                        </button>

                                        <button class="btn btn-success btn-next" data-last="Finish">
                                            Next
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>


                                    </div>


                                </div>


                            </div>

                        </div>


                        <!---sidebar right--->


                        <div class="col-md-3">

                            <div class="widget-box">
                                <div class="widget-header">
                                    <h4 class="widget-title">Booking Summary</h4>

                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>


                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th class="col-md-5">Airport</th>
                                                <td id="airport_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Departure Date</th>
                                                <td id="deptdate_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Return Date</th>
                                                <td id="returndate_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Company</th>
                                                <td id="company_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Parking Type</th>
                                                <td id="parkingtype_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th>Total Days</th>
                                                <td id="totalNoDays_txt"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Booking Price</th>
                                                <td id="booking_price_txt" class="col-md-5"
                                                    style="font-weight: bold; font-size: 16px;"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Add Extra Sys</th>
                                                <td id="add_extra_sys" class="col-md-5"></td>
                                            </tr>

                                            <tr class="tr-hide" style="display: none;">
                                                <th class="col-md-5">Discounted Booking Price</th>
                                                <td id="discounted_price_txt" class="col-md-5"
                                                    style="font-weight: bold; font-size: 16px;"></td>
                                            </tr>
                                            <tr class="tr-hide" style="display: none;">
                                                <th class="col-md-5">Discount Price</th>
                                                <td id="discount_price_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Cancel Price</th>
                                                <td id="cancel_price_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Sms Price</th>
                                                <td id="sms_price_txt" class="col-md-5"></td>
                                            </tr>
                                            {{--<tr>--}}
                                            {{--<th class="col-md-5">Postal Price</th>--}}
                                            {{--<td id="postal_price_txt" class="col-md-5"></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<th class="col-md-5">Adjustment Price</th>--}}
                                            {{--<td id="extra_price_txt" class="col-md-5"></td>--}}
                                            {{--</tr>--}}
                                            <tr>
                                                <th class="col-md-5">Booking Fee</th>
                                                <td id="booking_fee_txt" class="col-md-5"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Total Price</th>
                                                <td id="total_price_txt" class="col-md-5"
                                                    style="font-weight: bold; font-size: 16px;"></td>
                                            </tr>
                                            </tbody>


                                        </table>
                                        <form id="bookingDetails">
                                            <input type="hidden" name="company_id" id="company_id" value=""/>
                                            <input type="hidden" name="parking_type" id="parking_type" value=""/>
                                            <input type="hidden" name="discount_amount" id="discount_amount"
                                                   value=""/>
                                            <input type="hidden" name="p_booking_amount" id="p_booking_amount"
                                                   value=""/>
                                            <input type="hidden" name="cancelFEE" id="cancelFEE" value=""/>
                                            <input type="hidden" name="extraAmount" id="extraAmount" value=""/>
                                            <input type="hidden" name="smsFEE" id="smsFEE" value=""/>
                                            <input type="hidden" name="postalFEE" id="postalFEE" value=""/>
                                            <input type="hidden" name="add_extra" id="add_extra" value="0"/>
                                            <input type="hidden" name="bookingFEE" id="bookingFEE" value=""/>
                                            <input type="hidden" name="totalAMOUNT" id="totalAMOUNT" value="0"/>
                                            <input type="hidden" name="no_of_days" id="no_of_days" value="0"/>
                                            <input type="hidden" name="h_totalAMOUNT" id="h_totalAMOUNT" value="0"/>
                                            <input type="hidden" name="booking_extra_sys" id="booking_extra_sys"
                                                   value=""/>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
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

    <script src="https://getaddress.io/js/jquery.getAddress-2.0.8.min.js"></script>

    <script type="text/javascript">

        $('#postcode_lookup').getAddress({
            api_key: '{{ $settings["address_key"] }}',
//            <!--  Or use your own endpoint - api_endpoint:https://your-web-site.com/getAddress, -->
            output_fields: {
                line_1: '#line1',
                line_2: '#address',
                line_3: '#address2',
                post_town: '#town',
                county: '#county',
                postcode: '#post_code'
            },
            button_class: 'btn btn-yellow',
            input_class: 'form-control my-class',
            dropdown_class: 'form-control  my-class',

            <!--  Optionally register callbacks at specific stages -->
            onLookupSuccess: function (data) {/* Your custom code */
                $('#ad_field').hide();
            },
            onLookupError: function () {/* Your custom code */

                // $('#postcode_lookup').hide();
                $('#ad_field').hide();


                $("#postcode_lookup").append('<button id="nolist" type="button" class="btn text-center btn-yellow" >Address Not Listed</button><script>$("#nolist").bind("click",function(){$("#ad_field").show(); $("#getaddress_input").hide(); $("#getaddress_button").hide(); $("#getaddress_error_message").hide(); });<\/script>');


            },
            onAddressSelected: function (elem, index) {/* Your custom code */
                //$('#ad_field').show();
            }
        });
        var isSelected = 0;

        function get_parking_prices() {
            var departure_date = $('#dep_date').val();
            var return_date = $('#return_date').val();
            var departure_time = $('#departure_time').val();
            var return_time = $('#return_time').val();
            var airportid = $('#airport_id').val();
            var promo = $('#promo').val();
            //if (airportid == '') {

            var data = {};
            data['dropoffdate'] = departure_date;
            data['dropoftime'] = departure_time;

            data['pickup_date'] = return_date;
            data['pickup_time'] = return_time;
            data['airport_id'] = airportid;
            data['_token'] = '{{ @csrf_token() }}';
            data['promo'] = promo;
            // data['action'] = 'getbookingPrice';
            $('#loading').css("display", "block");
            $.ajax({
                type: 'post',
                data: data,
                async: false,
                url: '{{ route("getQuote") }}',
                beforeSend: function () {
                    // $('#loading').css("display","block");
                },
                complete: function () {
                    // $('#loading').hide();
                },

                success: function (msg) {
                    $("#step_2_companies").html(msg);
                    $('#loading').css("display", "none");
                    //debugger;
//                    var obj = msg;
//                    //var obj = $.parseJSON(msg);
//                    $("#no_of_days").val(obj.total_days);
//                    $("#totalNoDays_txt").text(obj.total_days);
//                    $("#airport_txt").text(obj.airport);
//                    $("#deptdate_txt").text(departure_date + ' ' + departure_time);
//                    $("#returndate_txt").text(return_date + ' ' + return_time);
//                    //$('#overlay').show();
//                    // jQuery.noConflict();
//                    $('#cdetails-modal').modal('show', {backdrop: 'static'});
//                    $('#cdetails-modal .modal-body').html(obj.html);
                }
            });
            //}
        }

        function selectCompany(id) {
            isSelected = 1;
            var x = $('#cform' + id).serializeArray();
            var obj = JSON.parse(JSON.stringify($('#cform' + id).serializeArray()));
            console.log(obj);
            //$('#cdetails-modal').modal('hide');
            $('#company_id').val(obj[0].value);  //company id

            $('#company_txt').text(obj[1].value);  //company name
            $('#parkingtype_txt').text(obj[2].value);  //parking type
            $('#parking_type').val(obj[2].value);  //parking type
            $('#booking_price_txt').text(obj[3].value); //booking price
            $('#p_booking_amount').val(obj[3].value); //booking price
            $('#discount_amount').val(obj[4].value); //discount price
            $('#cancel_price_txt').text(obj[5].value);  //cancel price
            $('#cancelFEE').val(obj[5].value);  //cancel price
            $('#booking_fee_txt').text(obj[6].value); //booking fee
            $('#bookingFEE').val(obj[6].value); //booking fee
            $('#total_price_txt').text(obj[7].value); //total price
            $('#totalAMOUNT').val(obj[7].value); //total price
            $('#h_totalAMOUNT').val(obj[7].value); //total price
            $('#extraAmount').val(0); //total price


            $('#airport_txt').text(obj[9].value);  //company id
            $('#deptdate_txt').text(obj[10].value);  //company id
            $('#returndate_txt').text(obj[11].value);  //company id
            $('#totalNoDays_txt').text(obj[15].value);  //company id
            $('#no_of_days').val(obj[15].value);  //company id
            $('#sms_price_txt').text(0);  //company id
            getTerminals($('#airport_id').val());
            get_extra_prices();
            //$('#airport_txt').text(obj[0].value);  //company id
//            if(obj[4].value > 0.00){
//                $('#discount_price_txt').text(obj[4].value); //discount price
//                $('#discounted_price_txt').text(obj[8].value); //total price
//                $('.tr-hide').show();
//            }
//            if(obj[9].value == 1){
//                $('#passenger').show();
//            }else{
//                $('#passenger').hide();
//            }
//            $('#sms_postal_box').show();
            // get_extra_prices();


        }

        function get_extra_prices() {
            var total_amount = $('#h_totalAMOUNT').val();
            var sms_amount = 0.00;
            var postal_amount = 0.00;
            var extraAmount = 0.00;
            var cancelAmount = 0.00;
            if ($('#sms_fee').is(':checked')) {
                sms_amount = parseFloat($('#sms_fee').val());
            }
            if ($('#postal_fee').is(':checked')) {
                postal_amount = parseFloat($('#postal_fee').val());
            }
            if ($('#add_extra').val() != '') {
                // extraAmount = parseFloat($('#extraAmount').val());
            }
            if ($('#cancel_fee').is(':checked')) {
                cancelAmount = parseFloat($('#cancel_fee').val());
            }
            total_amount = parseFloat(total_amount);
            var newtotal = ((total_amount) + (sms_amount) + (postal_amount) + (extraAmount) + (cancelAmount));
            var newtotal = newtotal.toFixed(2);
            var sms_amount = sms_amount.toFixed(2);
            var postal_amount = postal_amount.toFixed(2);
            var extraAmount = extraAmount.toFixed(2);
            var cancelAmount = cancelAmount.toFixed(2);
            $('#total_price_txt').text(newtotal);
            $('#totalAMOUNT').val(newtotal);
            $('#sms_price_txt').text(sms_amount);
            $('#smsFEE').val(sms_amount);
            $('#postalFEE').val(postal_amount);
            $('#postal_price_txt').text(postal_amount);
            $('#cancelFEE').val(cancelAmount);
            $('#cancel_price_txt').text(cancelAmount);
            $('#extraAmount').val(extraAmount);
            $('#extra_price_txt').text(extraAmount);
        }

        jQuery(function ($) {


            $('#add_extra').on('keyup blur', function () {
                get_extra_prices();
            });
            $('#sms_fee').click(function () {
                get_extra_prices();
            });
            $('#postal_fee').click(function () {
                get_extra_prices();
            });
            $('#cancel_fee').click(function () {
                get_extra_prices();
            });


            $('#return_time').timepicker({
                minuteStep: 15,
                showSeconds: false,
                showMeridian: false,
                disableFocus: true,
                icons: {
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down'
                }
            }).on('focus', function () {
                $('#return_time').timepicker('showWidget');
            }).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });


            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true,
                startDate: new Date()
            })
            //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
                $(this).prev().focus();
            });


            $('#departure_time').timepicker({
                minuteStep: 15,
                showSeconds: false,
                showMeridian: false,
                disableFocus: true,
                icons: {
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down'
                }
            }).on('focus', function () {
                $('#departure_time').timepicker('showWidget');
            }).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });

//            var date = new Date();
//            date.setDate(date.getDate()-1);
//            if (!ace.vars['old_ie'])
//
//                $('#dep_date').datetimepicker({
//                format: 'MM/DD/YYYY',//use this option to display seconds
//                    startDate: date,
//                icons: {
//                    time: 'fa fa-clock-o',
//                    date: 'fa fa-calendar',
//                    up: 'fa fa-chevron-up',
//                    down: 'fa fa-chevron-down',
//                    previous: 'fa fa-chevron-left',
//                    next: 'fa fa-chevron-right',
//                    today: 'fa fa-arrows ',
//                    clear: 'fa fa-trash',
//                    close: 'fa fa-times'
//                }
//            }).next().on(ace.click_event, function () {
//                $(this).prev().focus();
//            });
//
//
//            $('#return_date').datetimepicker({
//                format: 'MM/DD/YYYY',//use this option to display seconds
//                startDate: date,
//                icons: {
//                    time: 'fa fa-clock-o',
//                    date: 'fa fa-calendar',
//                    up: 'fa fa-chevron-up',
//                    down: 'fa fa-chevron-down',
//                    previous: 'fa fa-chevron-left',
//                    next: 'fa fa-chevron-right',
//                    today: 'fa fa-arrows ',
//                    clear: 'fa fa-trash',
//                    close: 'fa fa-times'
//                }
//            }).next().on(ace.click_event, function () {
//                $(this).prev().focus();
//            });

        });

        //company_email_div
        function getTerminals(airport) {

            var data = {};
            data['id'] = airport;
//data['action'] = 'getTerminals';
            $.ajax({
                type: 'get',
// data: data,
                @if($edit==1)
                    url: '{{ url("../admin/company/getTerminals") }}/' + airport,
                @else
                    url: '{{ url("admin/company/getTerminals") }}/' + airport,
                @endif

                success: function (msg) {
                    $('#departure_terminal').html(msg);
                    $('#return_terminal').html(msg);

                }
            });

        }

        var $validation = false;
        //$('#fuelux-wizard-container').wizard( get_parking_prices() );
        $('#fuelux-wizard-container')
            .ace_wizard({
                //step: 2 //optional argument. wizard will jump to step "2" at first
                //buttons: '.wizard-actions:eq(0)'
            })
            .on('actionclicked.fu.wizard', function (e, info) {
                console.log("info", info);
                //get_parking_prices();
                if (info.step == 1 && info.direction == "next") {
                    if ($('#quote').valid()) {
                        get_parking_prices();
                    } else {
                        e.preventDefault();
                    }
                }
                if (info.step == 2 && info.direction == "next") {
                    if (isSelected == 0) {
                        e.preventDefault();
                        alert("Please Select parking type.");
                    }
                }
                if (info.step == 3 && info.direction == "next") {
                    if (!$('#personal_detail').valid()) {
                        e.preventDefault();
                    }
                }


                if (info.step == 5 && info.direction == "next") {
                    if (!$('#payment_detail').valid()) {
                        e.preventDefault();
                    }
                }
            })
            //.on('changed.fu.wizard', function() {
            //})
            .on('finished.fu.wizard', function (e) {
                //data submit start
                var data = {};
                data['airport_id'] = $('#airport_id').val();
                data['dep_date'] = $('#dep_date').val();
                data['departure_time'] = $('#departure_time').val();
                data['return_date'] = $('#return_date').val();
                data['return_time'] = $('#return_time').val();
                data['promo'] = $('#promo').val();


                data['first_name'] = $('#first_name').val();
                data['last_name'] = $('#last_name').val();
                data['email'] = $('#email').val();
                data['contact'] = $('#contact').val();
                data['full_address'] = $('#getaddress_dropdown').val();
                data['address'] = $('#address').val();
                data['address2'] = $('#address2').val();
                data['post_code'] = $('#post_code').val();
                data['town'] = $('#town').val();


                data['dept_flight_no'] = $('#dept_flight_no').val();
                data['return_flight_no'] = $('#return_flight_no').val();
                data['departure_terminal'] = $('#departure_terminal').val();
                data['return_terminal'] = $('#return_terminal').val();
                data['veh_make'] = $('#veh_make').val();
                data['veh_model'] = $('#veh_model').val();
                data['veh_colour'] = $('#veh_colour').val();
                data['veh_registration'] = $('#veh_registration').val();


                data['transaction_id'] = $('#transaction_id').val();
                data['payment_method'] = $("#payment_detail input[name='payment_method']:checked").val();


                data['company_id'] = $('#bookingDetails input[name="company_id"]').val();
                data['parking_type'] = $('#bookingDetails input[name="parking_type"]').val();
                data['discount_amount'] = $('#bookingDetails input[name="discount_amount"]').val();
                data['p_booking_amount'] = $('#bookingDetails input[name="p_booking_amount"]').val();
                data['postalFEE'] = $('#bookingDetails input[name="postalFEE"]').val();
                data['bookingFEE'] = $('#bookingDetails input[name="bookingFEE"]').val();
                data['add_extra'] = $('#bookingDetails input[name="add_extra"]').val();
                data['totalAMOUNT'] = $('#bookingDetails input[name="totalAMOUNT"]').val();
                data['h_totalAMOUNT'] = $('#bookingDetails input[name="h_totalAMOUNT"]').val();

                data['no_of_days'] = $('#bookingDetails input[name="no_of_days"]').val();
                data['airport'] = $('#bookingDetails input[name="airport"]').val();
                data['_token'] = '{{ csrf_token() }}';

                data['smsFEE'] = $("#smsFEE").val();
                data['cancelFEE'] = $("#cancelFEE").val();
                data['passenger'] = 1;
                var url = '{{ route("admin_add_booking") }}';
                @if($type=="edit")
                    url = '{{ route("admin_update_booking",[$id]) }}';
                @endif


                $.post(url, data, function (data) {


                    bootbox.dialog({
                        message: "Thank you! Your information was successfully saved!",
                        buttons: {
                            "success": {
                                "label": "OK",
                                "className": "btn-sm btn-primary"
                            }
                        }
                    });

                    window.location.href = "{{ url('admin/booking') }}";


                }, 'json');
                //data submit end


            }).on('stepclick.fu.wizard', function (e) {
            //e.preventDefault();//this will prevent clicking and selecting steps
        });


    </script>

@endsection