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
                Page
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




                        {{ Form::open(array('class'=>'form-horizontal','method'=>'PUT','route' => ['pages.update',$page->id])) }}



                        <div class="form-group">
                            {{ Form::label('Page Title', 'Page Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                            <div class="form-control-sm"></div>
                            <div class="col-sm-6">
                                {{ Form::text('page_title',  $page->page_title, array('class' => 'form-control')) }}



                            @if ($errors->has('page_title'))

                                <div class="alert alert-danger alert alert-danger "
                                     style="clear: both;">
                                    <strong>{{ $errors->first('page_title') }}</strong>
                                </div>
                            @endif
                        </div>
                        </div>



                            <div class="form-group">
                                {{ Form::label('Page Slug', 'Page Slug', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                                <div class="form-control-sm"></div>
                                <div class="col-sm-6">
                                    {{ Form::text('page_slug',  $page->slug, array('class' => 'form-control','disabled'=>'disabled')) }}



                                    @if ($errors->has('page_slug'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('page_slug') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>



                        <div class="form-group">
                            {{ Form::label('type', 'Page Type', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">
                                {{ Form::select('type',[""=>"All Type","AP"=>"Airport Parking","HP"=>"Hotels","AH"=>"Hotels and Parking","AL"=>"Airport Lounges","page"=>"page","post"=>"post","main"=>"Main"],$page->type,["id"=>'type' ,"class"=>"form-control"]) }}


                            @if ($errors->has('type'))

                                    <div class="alert alert-danger alert alert-danger "
                                         style="clear: both;">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                        <div class="form-group">
                            {{ Form::label('Meta Title', 'Meta Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">
                                {{ Form::text('meta_title',  $page->meta_title, array('class' => 'form-control')) }}


                                @if ($errors->has('meta_title'))

                                    <div class="alert alert-danger alert alert-danger "
                                         style="clear: both;">
                                        <strong>{{ $errors->first('meta_title') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                            <div class="form-group">
                                {{ Form::label('Meta Keywords', 'Meta Keywords', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::text('meta_keyword',  $page->meta_keyword, array('class' => 'form-control')) }}


                                    @if ($errors->has('meta_keyword'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('meta_keyword') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>





                        <div class="form-group" id="airport">
                            {{ Form::label('Select Airport', 'Select Airport', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">

                                {{ Form::select('airport_id',$airportsList,$page->typeid,["id"=>'airport_id' ,"class"=>"form-control"]) }}

                            </div>

                            @if ($errors->has('airport_id'))

                                <div class="alert alert-danger alert alert-danger "
                                     style="clear: both;">
                                    <strong>{{ $errors->first('airport_id') }}</strong>
                                </div>
                            @endif
                        </div>




                        <div class="form-group">
                            {{ Form::label('meta_description', 'Meta Description', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">
                                {{ Form::textarea('meta_description', $page->meta_description, array('id'=>'meta_description','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                @if ($errors->has('meta_description'))

                                    <div class="alert alert-danger alert alert-danger"
                                         style="clear: both; margin-top: -22px;">
                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>





                            <div class="form-group">
                                {{ Form::label('meet_and_greet', 'Meet And Greet', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('meet_and_greet',  $page->meet_and_greet, array('id'=>'meet_and_greet','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('meet_and_greet'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('meet_and_greet') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('park_and_ride', 'Park and Ride', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('park_and_ride',  $page->park_and_ride, array('id'=>'park_and_ride','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('park_and_ride'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('park_and_ride') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                {{ Form::label('alluring', 'Our Alluring', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('alluring',  $page->alluring, array('id'=>'alluring','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('alluring'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('alluring') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                {{ Form::label('alluring_meetandgreet', 'Alluring meet and greet', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('alluring_meetandgreet',  $page->alluring_meetandgreet, array('id'=>'alluring_meetandgreet','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('alluring_meetandgreet'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('alluring_meetandgreet') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                {{ Form::label('alluring_parkandride', 'Alluring Park and Ride', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('alluring_parkandride',  $page->alluring_parkandride, array('id'=>'alluring_parkandride','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('alluring_parkandride'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('alluring_parkandride') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                {{ Form::label('alluring_onairport', 'Alluring On Airport', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('alluring_onairport',  $page->alluring_onairport, array('id'=>'alluring_onairport','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('alluring_onairport'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('alluring_onairport') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>





                            <div class="form-group" id="main">
                                {{ Form::label('content', 'Content', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6" >
                                    {{ Form::textarea('content',$page->content, array('id'=>'content','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('content'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>












                        <div class="form-group">
                            {{ Form::label('status', 'Status', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-4">
                                {{ Form::select('status', array('Yes' => 'Active', 'No' => 'Inactive'), $page->status) }}

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
        $(document).ready(function () {
            $("#type").change(function () {
                var val  = $('#type').val();
                if(val =='AP' || val==='HP' || val=='AH' || val =='AL'){
                    $("#airport").show();
                }else{
                    $("#airport").hide();
                }
                if(val =='main'){
                    $("#main").hide();
                }else{
                    $("#main").show();
                }
            });
        });

    </script>
@endsection