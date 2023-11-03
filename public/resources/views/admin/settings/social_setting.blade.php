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

        .form-horizontal .form-group {
            margin-right: 78px;
            margin-left: -40px;
        }


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

                Social Settings

                <small>

                    <i class="ace-icon fa fa-angle-double-right"></i>

                    Update

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









                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => ['settings.update'])) }}



                        @foreach($social_sites as $social)

                            <div class="form-group">

                                {{ Form::label($social["title"], $social["title"], array('class' => 'col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6">





                                    @php $socialfield = ""; @endphp

                                    @if(array_key_exists($social["fieldName"],$settings))

                                        @php $socialfield = $settings[$social["fieldName"]]; @endphp

                                    @endif



                                    {{ Form::text('setting['.$social["fieldName"].']',  $socialfield, array('class' => 'form-control')) }}







                                    @if ($errors->has('setting['.$social["fieldName"].']'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting['.$social["fieldName"].']') }}</strong>

                                        </div>

                                    @endif

                                </div>

                                <div class="col-sm-4">







 @php $socialfieldstatus = ""; 

                                    if(array_key_exists($social["fieldName"]."_status",$settings))

                                    {

                                       $socialfieldstatus = $settings[$social["fieldName"]."_status"]; 

                                    }

                                  



$statusfieldname = $social["fieldName"].'_status';



@endphp

 {{ Form::select('setting['.$statusfieldname.']',["active"=>"Active","inactive"=>"In-active"],$socialfieldstatus,["class"=>"form-control"]) }}



                                    

                                </div>

                            </div>







                        @endforeach

@can('user_auth', ["edit"])



                        <div class="clearfix form-actions">

                            <div class="col-md-offset-3 col-md-9">

                                {{  Form::submit('Submit',array("class"=>"btn btn-info")) }}



                            </div>

                        </div>

@endcan



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





        $(document).ready(function () {





            $('#content').summernote({

                height: 150,

                disableDragAndDrop: true,

                toolbar: [

// [groupName, [list of button]]

                    ['codeview'],

                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['font', ['strikethrough', 'superscript', 'subscript']],

                    ['fontsize', ['fontsize']],

                    ['color', ['color']],

                    ['para', ['ul', 'ol', 'paragraph']],

                    ['height', ['height']]

                ]

            });





        });



    </script>

@endsection