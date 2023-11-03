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


@endsection
@section('content')
    <div class="page-content">


        <div class="page-header">
            <h1>
                Users
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Create
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

                        {{ Form::open(array('class'=>'form-horizontal','method'=>'post','route' => 'registerstore')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Name', array('class' => 'col-sm-3 control-label no-padding-right')) }}


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
                            {{ Form::label('Email', 'Email', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-9">
                                {{ Form::text('email',  Input::old('email'), array('class' => 'col-xs-10 col-sm-5')) }}


                                @if ($errors->has('email'))

                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"
                                         style="clear: both;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                        <div class="form-group">
                            {{ Form::label('Password', 'Password', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-9">
                                {{ Form::password('password', array('class' => 'col-xs-10 col-sm-5')) }}


                                @if ($errors->has('password'))

                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"
                                         style="clear: both;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                        <div class="form-group">
                            {{ Form::label('Confirm', 'Confirm Password', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-9">
                                {{ Form::password('confirm_password', array('class' => 'col-xs-10 col-sm-5')) }}


                                @if ($errors->has('confirm_password'))

                                    <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5"
                                         style="clear: both;">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                        <div class="form-group">
                            {{ Form::label('Roles', 'Roles', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                            <div class="form-control-sm"></div>
                            <div class="col-sm-4">
                                {{ Form::select('role_id',$rolesList,Input::old('role_id'),["onchange"=>'getPermissions()',"id"=>"role_id","class"=>"form-control","style"=>"width: 97.5%;"]) }}


                            @if ($errors->has('role_id'))

                                <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12"
                                     style="clear: both;">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </div>
                            @endif
                            </div>

                        </div>


                        <div class="form-group">
                            {{ Form::label('Permissions', 'Permissions', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                            <div class="form-control-sm"></div>
                            <div class="col-sm-4" id="permission_list">
                                @foreach($permissions as $key=>$permission)
                                    {{Form::checkbox('permissions[]', $permission, null)}} {{ ucfirst($permission) }}
                                    <br/>
                                @endforeach


                            </div>


                        </div>


                        <div class="form-group">
                            {{ Form::label('Pages to hide', 'Pages to hide', array('class' => 'col-sm-3 control-label no-padding-right')) }}

                            <div class="form-control-sm"></div>
                            <div class="col-sm-4" id="pages_list" style="height: 250px;overflow: scroll;">
                                @foreach($pages as $key=>$page)
                                    {{Form::checkbox('pages[]', $page, null)}} {{ ucfirst($page) }}
                                    <br/>
                                @endforeach


                            </div>


                        </div>


                        <div class="form-group">
                            {{ Form::label('status', 'Status', array('class' => 'col-sm-3 control-label no-padding-right')) }}


                            <div class="col-sm-4">
                                {{ Form::select('status', array('1' => 'Active', '0' => 'Inactive'), 'active') }}

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
<script>
    function getPermissions() {
        var role_id = $("#role_id :selected").text();

        $.ajax({
            type: 'get',
            url: '../users/getPermissions/'+role_id,
            success: function (msg) {
                // $('#terminalSection').show();
                $('#permission_list').html(msg);
            }
        });

    }
</script>
@endsection
