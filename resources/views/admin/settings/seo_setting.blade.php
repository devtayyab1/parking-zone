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

                Seo Settings

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





                        <div class="form-group">

                            {{ Form::label('Site Title', 'Site Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                            <div class="form-control-sm"></div>

                            <div class="col-sm-6">

                                {{ Form::text('setting[site_title]',  $settings["site_title"], array('class' => 'form-control')) }}







                                @if ($errors->has('setting[site_title]'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('setting[site_title]') }}</strong>

                                    </div>

                                @endif

                            </div>

                        </div>





                        <div class="form-group">

                            {{ Form::label('Meta Keyword', 'Meta Keyword', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                            <div class="form-control-sm"></div>

                            <div class="col-sm-6">



                                @php $meta_keyword = ""; @endphp

                                @if(array_key_exists("meta_keyword",$settings))

                                    @php $meta_keyword = $settings["meta_keyword"]; @endphp

                                @endif



                                {{ Form::text('setting[meta_keyword]',  $meta_keyword, array('class' => 'form-control')) }}







                                @if ($errors->has('setting[meta_keyword]'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('setting[meta_keyword]') }}</strong>

                                    </div>

                                @endif

                            </div>

                        </div>





                        <div class="form-group">

                            {{ Form::label('Meta Description', 'Meta Description', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                            <div class="form-control-sm"></div>

                            <div class="col-sm-6">

                                @php $meta_description = ""; @endphp

                                @if(array_key_exists("meta_description",$settings))

                                    @php $meta_description = $settings["meta_description"]; @endphp

                                @endif

                                {{ Form::textarea('setting[meta_description]', $meta_description , array('class' => 'form-control',"id"=>"")) }}







                                @if ($errors->has('setting[meta_description]'))



                                    <div class="alert alert-danger alert alert-danger "

                                         style="clear: both;">

                                        <strong>{{ $errors->first('setting[meta_description]') }}</strong>

                                    </div>

                                @endif

                            </div>

                        </div>









                            <div class="form-group">

                                {{ Form::label('Twitter Title', 'Twitter Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_twitter_title = ""; @endphp

                                    @if(array_key_exists("site_twitter_title",$settings))

                                        @php $site_twitter_title = $settings["site_twitter_title"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_twitter_title]', $site_twitter_title , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_twitter_title]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_twitter_title]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>





                            <div class="form-group">

                                {{ Form::label('OG Title', 'OG Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_og_title = ""; @endphp

                                    @if(array_key_exists("site_og_title",$settings))

                                        @php $site_og_title = $settings["site_og_title"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_og_title]', $site_og_title , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_og_title]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_og_title]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>









                            <div class="form-group">

                                {{ Form::label('OG URL', 'OG URL', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_og_title = ""; @endphp

                                    @if(array_key_exists("site_og_url",$settings))

                                        @php $site_og_title = $settings["site_og_url"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_og_url]', $site_og_title , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_og_url]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_og_url]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>





                            <div class="form-group">

                                {{ Form::label('OG Image', 'OG Image', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_og_title = ""; @endphp

                                    @if(array_key_exists("site_og_image",$settings))

                                        @php $site_og_title = $settings["site_og_image"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_og_image]', $site_og_title , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_og_image]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_og_image]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>





                            <div class="form-group">

                                {{ Form::label('OG Type', 'OG Type', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_og_title = ""; @endphp

                                    @if(array_key_exists("site_og_type",$settings))

                                        @php $site_og_title = $settings["site_og_type"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_og_type]', $site_og_title , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_og_type]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_og_type]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>







                            <div class="form-group">

                                {{ Form::label('author', 'Author', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_site_author = ""; @endphp

                                    @if(array_key_exists("site_author",$settings))

                                        @php $site_site_author = $settings["site_author"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_author]', $site_site_author , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_author]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_author]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>













                            <div class="form-group">

                                {{ Form::label('Site Schema', 'Site Schema', array('class' => 'col-sm-3 control-label no-padding-right')) }}



                                <div class="form-control-sm"></div>

                                <div class="col-sm-6">

                                    @php $site_schema = ""; @endphp

                                    @if(array_key_exists("site_schema",$settings))

                                        @php $site_schema = $settings["site_schema"]; @endphp

                                    @endif

                                    {{ Form::textarea('setting[site_schema]', $site_schema , array('class' => 'form-control',"id"=>"")) }}







                                    @if ($errors->has('setting[site_schema]'))



                                        <div class="alert alert-danger alert alert-danger "

                                             style="clear: both;">

                                            <strong>{{ $errors->first('setting[site_schema]') }}</strong>

                                        </div>

                                    @endif

                                </div>

                            </div>
                           <input type= "hidden" value = "{{$agent}}" id = "agent" name = "agent">




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