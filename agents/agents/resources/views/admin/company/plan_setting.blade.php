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
                            <select class="chosen-select form-control" id="form-field-select-3"
                                    data-placeholder="Choose a Company...">
                                <option value=""></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company["id"] }}">{{ $company["name"] }}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>




                </div>


                <div class="panel-group" id="plan_setting">





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
        $("#form-field-select-3").change(function () {
            getPlanByUserID();
        });

        function getPlanByUserID() {
            var airport = $('#form-field-select-3').val();
            var data = {};
            data['id'] = airport;
            $.ajax({
                type: 'get',
                url: '../getPlanView/' + airport,
                success: function (msg) {
                   // $('#terminalSection').show();
                    $('#plan_setting').html(msg);
                }
            });

        }

        function updateProductPrices(form_id) {
            var d =$( "#"+form_id ).serialize();
            console.log(d);
            $.ajax({
                type: 'post',
                data: d,
                url: '../updateProductPrices',
                success: function (msg) {

                    if($("#action_sub").val() == "add"){
                        $("#action_sub").val("update");
                    }
                    // $('#terminalSection').show();
                    console.log(msg);
                    //var obj = JSON.parse(msg);

                    $('#message_'+form_id).html(msg.message);
                }
            });
            return false;

        }

    </script>
@endsection