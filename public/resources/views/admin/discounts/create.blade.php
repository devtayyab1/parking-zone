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

    </style>

@endsection



@section('content')









    <div class="page-content">





        <div class="page-header">

            <h1>

                Discounts

                <small>

                    <i class="ace-icon fa fa-angle-double-right"></i>

                    Add

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









                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => 'discounts.store')) }}





                        {{--<div class="form-group">--}}

                        {{--{{ Form::label('Title', 'Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}--}}



                        {{--<div class="form-control-sm"></div>--}}

                        {{--<div class="col-sm-6">--}}

                        {{--{{ Form::text('title',  Input::old('title'), array('class' => 'form-control')) }}--}}







                        {{--@if ($errors->has('title'))--}}



                        {{--<div class="alert alert-danger alert alert-danger "--}}

                        {{--style="clear: both;">--}}

                        {{--<strong>{{ $errors->first('title') }}</strong>--}}

                        {{--</div>--}}

                        {{--@endif--}}

                        {{--</div>--}}

                        {{--</div>--}}





                        <div class="form-group">

                            {{ Form::label('Enable discounts', 'Enable discounts', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::select('discount_status',["enable"=>"Enable"],null,["id"=>'discount_status','disabled' ,"class"=>"form-control"]) }}





                                @if ($errors->has('discount_status'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('discount_status') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            {{ Form::label('Booking Type', 'Booking Type', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::select('parking_type',["airport_parking"=>"Airport Parking","airport_hotel"=>"Airport Hotel","airport_hotel_parking"=>"Airport Hotel Parking","airport_lounges"=>"Airport Lounges"],null,["id"=>'parking_type' ,"class"=>"form-control"]) }}





                                @if ($errors->has('parking_type'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('parking_type') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            {{ Form::label('Discount For', 'Discount For', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::select('discount_for',["PPC"=>"PPC","BING"=>"BING","EM"=>"E Marketing","AF"=>"Affiliate Feature","Og"=>"Organic","FB"=>"FaceBook","Ln"=>"LinkedIn","In"=>"Instagram","G+"=>"Google+","Pi"=>"Pinterest","Tw"=>"Twiter","Yt"=>"Youtube","Blg"=>"Bloging","BK"=>"Backend"],null,["id"=>'discount_for' ,"class"=>"form-control"]) }}





                                @if ($errors->has('discount_for'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('discount_for') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            <label for="field-1" class="col-sm-3 control-label">Promo Code</label>

                            <div class="col-sm-4">

                                <div class="input-group">

							<span class="input-group-btn">

								<button id="pre_txt" class="btn" style="padding: 2px;"></button>

							</span>

                                    <input type="text" value="" data-validate="required"

                                           data-message-required="Promo Code is Required." name="promo"

                                           class="form-control" aria-required="true" aria-invalid="false">

                                    <input type="hidden" value="" name="pre_promo" id="pre_promo">

                                </div>

                            </div>

                        </div>





                        <div class="form-group">

                            {{ Form::label('status', 'Status', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::select('status', array('Yes' => 'Active', 'No' => 'Inactive'), 'active') }}



                            </div>

                        </div>





                        <div class="form-group">

                            {{ Form::label('start Date', 'Start Date', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::text('start_date',  Input::old('start_date'), array("id"=>"start_date",'class' => 'col-xs-9 col-sm-9 date-picker')) }}



                                <span class="input-group-addon">

																		<i class="fa fa-calendar"

                                                                           style="font-size: 145%!important"></i>

																	</span>

                                @if ($errors->has('start_date'))



                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"

                                         style="clear: both;">

                                        <strong>{{ $errors->first('start_date') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            {{ Form::label('End Date', 'End Date', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::text('end_date',  Input::old('end_date'), array("id"=>"end_date",'class' => 'col-xs-9 col-sm-9 date-picker')) }}



                                <span class="input-group-addon">

																		<i class="fa fa-calendar"

                                                                           style="font-size: 145%!important"></i>

																	</span>

                                @if ($errors->has('end_date'))



                                    <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"

                                         style="clear: both;">

                                        <strong>{{ $errors->first('end_date') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                            <div class="form-group">

                                {{ Form::label('Discount', 'Discount', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                                <div class="col-sm-3">

                                    {{ Form::text('discount_value',  Input::old('discount_value'), array("id"=>"discount_value",'class' => 'col-xs-12 col-sm-12')) }}





                                </div>

                                <div class="col-sm-1">

                                    {{ Form::select('discount_type', array('gbp' => 'GBP', 'percent' => '%'), '%'),array("id"=>"discount_value",'class' => 'col-xs-12 col-sm-12') }}



                                </div>

                            </div>





                        <div class="clearfix form-actions">

                            <div class="col-md-offset-3 col-md-9">

                                {{  Form::submit('Submit',array("class"=>"btn btn-info")) }}



                            </div>

                        </div>





                    </div><!-- /.span -->

                </div><!-- /.row -->





                <!-- PAGE CONTENT ENDS -->

            </div><!-- /.col -->

        </div><!-- /.row -->

    </div>





@endsection

@section('footer-script')

    <script src="{{ secure_asset("assets/js/moment.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/daterangepicker.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/bootstrap-datetimepicker.min.js") }}"></script>



    <script src="{{ secure_asset("assets/js/bootstrap-datepicker.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/bootstrap-timepicker.min.js") }}"></script>





    <!-- page specific plugin scripts -->

    <script src="{{ secure_asset("assets/js/wizard.navigation.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/jquery.validate.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/jquery-additional-methods.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/bootbox.js") }}"></script>

    <script src="{{ secure_asset("assets/js/jquery.maskedinput.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/select2.min.js") }}"></script>

    <script type="text/javascript">





        $(document).ready(function () {





            $('.date-picker').datepicker({

                autoclose: true,

                todayHighlight: true,

                //format: 'dd/mm/yyyy',
                format: 'yyyy-mm-dd',



                startDate: new Date()

            })

            //show datepicker when clicking on the icon

                .next().on(ace.click_event, function () {

                $(this).prev().focus();

            });



            var val = $('#parking_type').val();

            //alert(val);

            promo(val);

            $('#discount_for').on('change', function () {

                var dis_type = $('#parking_type').val();

                promo(dis_type);

            });

            $('#parking_type').on('change', function () {

                promo(this.value);

            });

        });



        function promo(data) {



            if (data == 'airport_parking') {

                var airport_parking_code = 'FPP';

                var src_value = 'PZ-' + $('#discount_for').val();

                $('#pre_txt').text(src_value);

                $('#pre_promo').val(src_value);



            }

            if (data == 'airport_hotel') {

                var src_value = 'AHF-' + $('#discount_for').val();

                $('#pre_txt').text(src_value);

                $('#pre_promo').val(src_value);

            }

            if (data == 'airport_hotel_parking') {

                var src_value = 'HPF-' + $('#discount_for').val();

                $('#pre_txt').text(src_value);

                $('#pre_promo').val(src_value);

            }



            if (data == 'airport_lounges') {

                var src_value = 'ALF-' + $('#discount_for').val();

                $('#pre_txt').text(src_value);

                $('#pre_promo').val(src_value);

            }

        }

    </script>

@endsection