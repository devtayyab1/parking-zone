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

                Company

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









                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => 'store_lounge', 'files' => true)) }}





                        <div class="form-group">

                            {{ Form::label('Admin', 'Admin', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                            <div class="form-control-sm"></div>

                            <div class="col-sm-4">

                                {{ Form::select('admin_id',$users,null,["class"=>"form-control","style"=>"width: 97.5%;"]) }}





                            </div>



                            @if ($errors->has('admin_id'))



                                <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"

                                     style="clear: both;">

                                    <strong>{{ $errors->first('admin_id') }}</strong>

                                </div>

                            @endif

                        </div>





                        <div class="form-group">

                            {{ Form::label('name', 'Company Name', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-9">

                                {{ Form::text('name',  Input::old('name'), array('class' => 'col-xs-10 col-sm-5')) }}





                                @if ($errors->has('name'))



                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"

                                         style="clear: both;">

                                        <strong>{{ $errors->first('name') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>




                        <div class="form-group">

                            {{ Form::label('company Email', 'Company Email', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-9" id="company_email_div">





                                @if(Input::old('company_email')!="")

                                    @php

                                        $cmpTotal = count(Input::old('company_email'));

                                        $counter = 1;

                                    @endphp



                                    @foreach(Input::old('company_email') as $item)

                                    @if($counter==1)

                                        {{ Form::text('company_email',  Input::old('company_email'), array('class' => 'col-xs-10 col-sm-5')) }}

                                        <!--a onclick="add_fields()" class="btn btn-info btn-sm">

                                            <span class="glyphicon glyphicon-plus"></span>

                                        </a-->

                                    @else



                                    <div id="company_email_{{ $counter }}" style="clear: both; margin-top: 10px"><input class="col-xs-10 col-sm-5" data-provide="markdown" name="company_email[]" type="text" value="{{ $item }}" ><a id="del_product_{{ $counter }}"  onclick="delete_fields('{{ $counter }}')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus-sign"></span></a></div>



                                    @endif

                                            @php

                                                $counter++;

                                            @endphp



                                            @endforeach

                                @else



                                {{ Form::text('company_email',  Input::old('company_email'), array('class' => 'col-xs-10 col-sm-5')) }}

                                <!--a onclick="add_fields()" class="btn btn-info btn-sm">

                                    <span class="glyphicon glyphicon-plus"></span>

                                </a-->

                                @endif

                            </div>



                        </div>

                        <div class="form-group">

                            {{ Form::label('Share Percentage', 'Share Percentage', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-9">

                                {{ Form::text('share_percentage',  Input::old('share_percentage'), array('class' => 'col-xs-10 col-sm-5')) }}





                                @if ($errors->has('share_percentage'))



                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"

                                         style="clear: both;">

                                        <strong>{{ $errors->first('share_percentage') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            {{ Form::label('Max Discount %', 'Max Discount %', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-9">

                                {{ Form::text('max_discount',  Input::old('max_discount'), array('class' => 'col-xs-10 col-sm-5')) }}





                                @if ($errors->has('max_discount'))



                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"

                                         style="clear: both;">

                                        <strong>{{ $errors->first('max_discount') }}</strong>

                                    </div>

                                @endif

                            </div>



                        </div>





                        <div class="form-group">

                            {{ Form::label('Company Overview', 'Company Overview', array('rows'=>'10',"cols"=>"50",'class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-5">

                                {{ Form::textarea('overview', Input::old('overview'), array('class' => 'col-xs-10 col-sm-5','id'=>'overview', "data-provide"=>"markdown")) }}

                                @if ($errors->has('overview'))



                                    <div class="alert alert-danger alert alert-danger"

                                         style="clear: both; margin-top: -22px;">

                                        <strong>{{ $errors->first('overview') }}</strong>

                                    </div>

                                @endif

                            </div>

                        </div>





                        <div class="form-group">

                            {{ Form::label('Terms & Conditions', 'Terms & Conditions', array('rows'=>'10',"cols"=>"50",'class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-5">

                                {{ Form::textarea('arival', Input::old('arival'), array('id'=>'arival','class' => 'col-xs-10 col-sm-5', "data-provide"=>"markdown")) }}

                                @if ($errors->has('arival'))



                                    <div class="alert alert-danger alert alert-danger"

                                         style="clear: both; margin-top: -22px;">

                                        <strong>{{ $errors->first('arival') }}</strong>

                                    </div>

                                @endif

                            </div>

                        </div>




                        <div class="form-group">

                            {{ Form::label('status', 'Status', array('class' => 'col-sm-3 control-label no-padding-right')) }}





                            <div class="col-sm-4">

                                {{ Form::select('status', array('Yes' => 'Active', 'No' => 'Inactive'), 'active') }}



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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

    <script type="text/javascript">

        $('#airport_id').change(function () {

            getTerminals();

        });

        var i=1;

               <?php if(Input::old('product') !=""){ ?>

                var i = "<?php echo count(Input::old('product')); ?>";

        <?php } ?>



        function add_product_fields() {



            var objTo = $('#products');

//            var divtest = document.createElement("div");

            var field_name ="product_"+i;

//            divtest.innerHTML = '<div class="label">Room ' + room +':</div><div class="content"><span>Width: <input type="text" style="width:48px;" name="width[]" value="" /><small>(ft)</small> X</span><span>Length: <input type="text" style="width:48px;" namae="length[]" value="" /><small>(ft)</small></span></div>';

            var inp = '<div id="product_' + i + '" style="clear: both; margin-top: 10px"><input class="col-xs-10 col-sm-5" data-provide="markdown" name="product[]" type="text" value="" "><a id="del_product_' + i + '"  onclick="delete_product_fields(' +i + ')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus-sign"></span></a></div>';

            objTo.append(inp);

            i++;

        }



        function delete_product_fields(id) {

            $("#product_" + id).remove();

            //$("#del_terminal_"+id).remove();

        }



        var a = 1;



            <?php if(Input::old('company_email') !=""){ ?>

         a = "<?php echo count(Input::old('company_email')); ?>";

        <?php } ?>



        function add_fields() {



            var objTo = $('#company_email_div');

            //var field_name ="company_email_"+i;

//            var divtest = document.createElement("div");

//            divtest.innerHTML = '<div class="label">Room ' + room +':</div><div class="content"><span>Width: <input type="text" style="width:48px;" name="width[]" value="" /><small>(ft)</small> X</span><span>Length: <input type="text" style="width:48px;" namae="length[]" value="" /><small>(ft)</small></span></div>';

            var inp = '<div id="company_email_' + a + '" style="clear: both; margin-top: 10px"><input class="col-xs-10 col-sm-5" data-provide="markdown" name="company_email[]" type="text" value="" "><a id="del_product_' + a + '"  onclick="delete_fields('+a+')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus-sign"></span></a></div>';

            objTo.append(inp);

            a++;

        }



        function delete_fields(id) {

            $("#company_email_" + id).remove();

            $(this).parents('.li').remove();



            //$("#del_terminal_"+id).remove();

        }

//company_email_div

        function getTerminals() {

            var airport = $('#airport_id').val();

            var data = {};

            data['id'] = airport;

//data['action'] = 'getTerminals';

            $.ajax({

                type: 'get',

// data: data,

                url: 'getTerminals/' + airport,

                success: function (msg) {

                    $('#terminalSection').show();

                    $('#terminal').html(msg);

                }

            });



        }



        $(document).ready(function () {



            $("a.delete_btn").click(function(event) {

                event.preventDefault();

                $(this).unwrap();

            });



            getTerminals();

            $('#descp').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });





            $('#return').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });



            $('#return_front').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });





            $('#arival').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });





            $('#overview').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });

        });



        $('#logo').ace_file_input({

            style: 'well',

            btn_choose: 'Drop files here or click to choose',

            btn_change: null,

            no_icon: 'ace-icon fa fa-cloud-upload',

            droppable: true,

            thumbnail: 'small'//large | fit

            //,icon_remove:null//set null, to hide remove/reset button

            /**,before_change:function(files, dropped) {

                        //Check an example below

                        //or examples/file-upload.html

                        return true;

                    }*/

            /**,before_remove : function() {

                        return true;

                    }*/

            ,

            preview_error: function (filename, error_code) {

                //name of the file that failed

                //error_code values

                //1 = 'FILE_LOAD_FAILED',

                //2 = 'IMAGE_LOAD_FAILED',

                //3 = 'THUMBNAIL_FAILED'

                //alert(error_code);

            }



        }).on('change', function () {

            //console.log($(this).data('ace_input_files'));

            //console.log($(this).data('ace_input_method'));

        });

    </script>

@endsection