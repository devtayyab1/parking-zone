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
        .panel-heading .accordion-toggle:after {
            /* symbol for "opening" panels */
            font-family: 'Glyphicons Halflings'; /* essential for enabling glyphicon */
            content: "\e114"; /* adjust as needed, taken from bootstrap.css */
            float: right; /* adjust as needed */
            color: grey; /* adjust as needed */
        }

        .panel-heading .accordion-toggle.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\e080"; /* adjust as needed, taken from bootstrap.css */
        }

    </style>
@endsection
@section('content')

    <div class="page-content">


        <div class="page-header">
            <h1>
                Plan
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Plan Setting
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-md-3" style="text-align: right;">
                        <label for="form-field-select-2">Select Company</label>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <select class="chosen-select form-control" id="company"
                                    data-placeholder="Choose a Company...">
                                <option value=""></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company["id"] }}">{{ $company["name"] }}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-md-3" style="text-align: right;">
                        <label for="form-field-select-2">Year</label>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <select class="chosen-select form-control" id="year"
                                    data-placeholder="Choose a Year...">
                                <option value=""></option>

                                @php
                                    $years = [];
                                    $y = date('Y') * 1;
                                    for ($i=$y; $i < $y + 3 ; $i++) {
                                        $years[$i]=$i;
                                    }
                                @endphp
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year}}</option>

                                @endforeach


                            </select>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-md-3" style="text-align: right;">
                        <label for="form-field-select-2">Month</label>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <select class="chosen-select form-control" id="month"
                                    data-placeholder="Choose a Month...">
                                <option value=""></option>


                                @php
                                    $months =[];
                                       
                                     

                                         for ($i=1; $i < 13; $i++) {
                                             $dt = DateTime::createFromFormat('!m', $i);
                                             $months[$i] = $dt->format('F');
                                           
                                        
                                             
                                         }



                                @endphp
                                @foreach($months as $month)
                                    <option value="{{ date("m", strtotime($month)) }}">{{ $month}}</option>

                                @endforeach
                            </select>

                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-md-3" style="text-align: right;">
                        <label for="form-field-select-2">Add Extra</label>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <input type="text" name="extra" id="extra" class="form-control" value=""/>

                        </div>
                    </div>


                </div>
                <hr/>

                <div class="panel-group" id="set_plan">


                </div>


                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

@endsection
@section("footer-script")
    <script src="{{ secure_asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
        $('.chosen-select').chosen({allow_single_deselect: true});
        $("#company,#year,#month").change(function () {
            getPlanByUserID();
        });


        function getPlanByUserID() {
            var airport = $('#company').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var data = {};
            data['id'] = airport;

            console.log("airport" + airport);
            console.log("year" + year);
            console.log("month" + month);
            if (airport != "" && year != "" && month != "") {

                $.ajax({
                    type: 'get',
                    url: 'getCompanySetPlanView/' + airport + "/" + year + "/" + month,
                    success: function (msg) {
                        // $('#terminalSection').show();
                        $('#set_plan').html(msg);
                    }
                });
            }

        }

        function updateProductPrices(form_id) {
            var d = $("#" + form_id).serialize();
            console.log(d);
            d = d+"&extra="+$("#extra").val();
            $.ajax({
                type: 'post',
                data: d,
                url: 'setCompanyPlanPrices',
                success: function (msg) {
                    // $('#terminalSection').show();
                    //console.log(msg.message);
                    //var obj = JSON.parse(msg);
                    if(msg.success==true){
                        getPlanByUserID();
                    }

                    $('#message_' + form_id).html(msg.message);
                }
            });
            return false;

        }

    </script>
@endsection