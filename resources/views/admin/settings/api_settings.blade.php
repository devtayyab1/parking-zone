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
                API Settings
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




                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => ['settings.update-api-settings'])) }}

                        @foreach($api_settings as $api)
                            <div class="form-group">
                                {{ Form::label($api["title"], $api["title"], array('class' => 'col-sm-3 control-label no-padding-right')) }}

                                <div class="form-control-sm"></div>
                                <div class="col-sm-6">


                                    @php $socialfield = ""; @endphp
                                    @if(array_key_exists($api["fieldName"],$settings))
                                        @php $socialfield = $settings[$api["fieldName"]]; @endphp
                                    @endif
                                    
                                    @if(array_key_exists("type",$api))
                                        {{ Form::select('setting['.$api["fieldName"].']',  $api["data"],$socialfield, array('class' => 'form-control')) }}

                                    @else
                                        {{ Form::text('setting['.$api["fieldName"].']',  $socialfield, array('class' => 'form-control')) }}

                                    @endif

                                    @if ($errors->has('setting['.$api["fieldName"].']'))

                                        <div class="alert alert-danger alert alert-danger "
                                             style="clear: both;">
                                            <strong>{{ $errors->first('setting['.$api["fieldName"].']') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>
                                @if(array_key_exists("after",$api))
                                    {!! $api["after"] !!}
                                @endif
                        @endforeach


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