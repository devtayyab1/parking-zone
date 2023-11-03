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
                Faq
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




                        {{ Form::open(array('class'=>'form-horizontal','method'=>'PUT','route' => ['faqs.update',$faq->id])) }}


                            <div class="form-group">
                                {{ Form::label('Title', 'Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                                <div class="form-control-sm"></div>
                                <div class="col-sm-6">
                                    {{ Form::text('title',  $faq->title , array('class' => 'form-control')) }}



                                    @if ($errors->has('title'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                {{ Form::label('type', 'Page Type', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::select('type',[""=>"All Type","Parking"=>"Airport Parking","Hotels"=>"Hotels","Hotels with Parking"=>"Hotels with Parking","Lounges"=>"Airport Lounges"],$faq->type,["id"=>'type' ,"class"=>"form-control"]) }}


                                    @if ($errors->has('type'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                {{ Form::label('status', 'Status', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-4">
                                    {{ Form::select('status', array('Yes' => 'Active', 'No' => 'Inactive'), $faq->status) }}

                                </div>
                            </div>





                            <div class="form-group">
                                {{ Form::label('content', 'Content', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('content', $faq->content, array('id'=>'content','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('content'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </div>
                                    @endif
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