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




                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => 'pages.store', 'files' => true)) }}


                        <div class="form-group">
                            {{ Form::label('Page Title', 'Page Title', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                            <div class="form-control-sm"></div>
                            <div class="col-sm-6">
                                {{ Form::text('page_title',  Input::old('page_title'), array('class' => 'form-control')) }}



                            @if ($errors->has('page_title'))

                                <div class="alert alert-danger alert alert-danger "
                                     style="clear: both;">
                                    <strong>{{ $errors->first('page_title') }}</strong>
                                </div>
                            @endif
                        </div>
                        </div>


                        <div class="form-group">
                            {{ Form::label('type', 'Page Type', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">
                                {{ Form::select('type',[""=>"All Type","AP"=>"Airport Parking","HP"=>"Hotels","AH"=>"Hotels and Parking","AL"=>"Airport Lounges","page"=>"page","post"=>"post","main"=>"Main"],null,["id"=>'type' ,"class"=>"form-control"]) }}


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
                                {{ Form::text('meta_title',  Input::old('meta_title'), array('class' => 'form-control')) }}


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
                                    {{ Form::text('meta_keyword',  Input::old('meta_keyword'), array('class' => 'form-control')) }}


                                    @if ($errors->has('meta_keyword'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('meta_keyword') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            
                             <div class="form-group" id="agentID">
                                  {{ Form::label('Select Agent', 'Select Agent', array('class' => 'col-sm-3 control-label no-padding-right')) }}
                                 
                     <div class="col-sm-6">
      <select name="agentID" style="padding: 6px 2px;height: 35px;">

                              

                             @foreach($agentsList as $key=>$agentsList)                                
                                        @php $checked='none'; @endphp
                                        @if(in_array($key,$user_role_agents))
                                            @if($key != "0")
                                            @php $checked=true; @endphp
                                            @endif
                                        @endif
                                         
                                      <option value="{{$key}}" @if(Input::get('agentID')==$key) {{ "selected='selected'" }}@endif style="display:{{$checked}};">{{$agentsList}}</option>  
                                    
                                     @endforeach

        

     

                            </select>


 </div>
  </div>
  @if (\Session::has('erroragent'))
   <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('erroragent') !!}</li>
        </ul>
    </div>
@endif
                        <div class="form-group" id="airport">
                            {{ Form::label('Select Airport', 'Select Airport', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-6">
                                {{ Form::select('airport_id',$airportsList,null,["id"=>'airport_id' ,"class"=>"form-control"]) }}

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
                                {{ Form::textarea('meta_description', Input::old('meta_description'), array('id'=>'meta_description','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('meet_and_greet', Input::old('meet_and_greet'), array('id'=>'meet_and_greet','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('park_and_ride', Input::old('park_and_ride'), array('id'=>'park_and_ride','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('alluring', Input::old('alluring'), array('id'=>'alluring','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('alluring_meetandgreet', Input::old('alluring_meetandgreet'), array('id'=>'alluring_meetandgreet','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('alluring_parkandride', Input::old('alluring_parkandride'), array('id'=>'alluring_parkandride','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
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
                                    {{ Form::textarea('alluring_onairport', Input::old('alluring_onairport'), array('id'=>'alluring_onairport','class' => 'form-control', "data-provide"=>"markdown","style='height: 60px;'")) }}
                                    @if ($errors->has('alluring_onairport'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('alluring_onairport') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group" id="main">
                                {{ Form::label('airport_parking', 'Airport Parking', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('airport_parking', Input::old('airport_parking'), array('id'=>'airport_parking','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('airport_parking'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('airport_parking') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group" id="main">
                                {{ Form::label('parking_options', 'Parking Options', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('parking_options', Input::old('parking_options'), array('id'=>'parking_options','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('parking_options'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('parking_options') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            
                            

                            <div class="form-group" id="main">
                                {{ Form::label('overview', 'OverView', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('overview', Input::old('overview'), array('id'=>'overview','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('overview'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('overview') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            

                            <div class="form-group" id="main">
                                {{ Form::label('facilities', 'Facilities', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('facilities', Input::old('facilities'), array('id'=>'facilities','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('facilities'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('facilities') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            

                            <div class="form-group" id="main">
                                {{ Form::label('topthings', 'Top Things To Do', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                                <div class="col-sm-6">
                                    {{ Form::textarea('topthings', Input::old('topthings'), array('id'=>'topthings','class' => 'form-control', "data-provide"=>"markdown")) }}
                                    @if ($errors->has('topthings'))

                                        <div class="alert alert-danger alert alert-danger"
                                             style="clear: both; margin-top: -22px;">
                                            <strong>{{ $errors->first('topthings') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
							<div class="form-group">								{{ Form::label('Upload Banner', 'Upload Banner', array('class' => 'col-sm-3 control-label no-padding-right')) }}								<div class="col-sm-6">									{{ Form::file('banner',  array('id'=>'banner','class' => 'col-xs-10 col-sm-5', "data-provide"=>"markdown")) }}								</div>							</div>











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



        $(document).ready(function () {


            $('#content').summernote({
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
            
            $('#airport_parking').summernote({
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
            $('#facilities').summernote({
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
            $('#topthings').summernote({
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
            $('#parking_options').summernote({
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
            $('#faq_desc').summernote({
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
        $('#banner').ace_file_input({            style: 'well',            btn_choose: 'Drop files here or click to choose',            btn_change: null,            no_icon: 'ace-icon fa fa-cloud-upload',            droppable: true,            thumbnail: 'small'            /**,before_change:function(files, dropped) {                        //Check an example below                        //or examples/file-upload.html                        return true;                    }*/            /**,before_remove : function() {                        return true;                    }*/            ,            preview_error: function (filename, error_code) {                            }        }).on('change', function () {        });
    </script>
    
    
    
    
    
    
    
    
@endsection