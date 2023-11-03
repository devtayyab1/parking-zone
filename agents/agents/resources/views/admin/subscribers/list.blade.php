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
                Subscribers
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    List
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

                        <div class="row">

                                {{ Form::open(array('route' => 'subscribers.index', 'method' => 'get')) }}


                                {{ Form::select('airport_id',$airportsList,Input::get("airport_id")) }}


                                {{ Form::label('has_downloaded', 'Has Downloaded') }}

                                {{ Form::select('downloaded',["all"=>"All","Yes"=>"Yes","No"=>"No"],Input::get("downloaded")) }}

                                <input value="Search" type="submit" class="btn btn-sm btn-success"/>
                                {{ Form::close() }}



                        </div>
                    </div>

                    {{--<a style="float: right; margin-bottom: 9px;" class="btn btn-success"--}}
                    {{--href="{{ route("pages.create") }}"> Add New</a>--}}

                    <table id="simple-table" class="table  table-bordered table-hover">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Email</th>
                            <th>Airport</th>
                            <th>Has Download</th>
                            <th></th>


                        </tr>
                        </thead>

                        <tbody>
                        @foreach($subscribers as $sub)
                            <tr>


                                <td class="hidden-480">{{ $sub->name }}</td>
                                <td class="hidden-480">{{ $sub->email }}</td>
                                <td class="hidden-480">@if($sub->airport) {{ $sub->airport->name }} @endif</td>
                                <td class="hidden-480">{{ $sub->download }}</td>


                                <td>
                                    <div class="hidden-sm hidden-xs btn-group">
  @can('user_auth', ["edit"])

                                        <form method="POST" style="margin-right: 5px; float: left"
                                              onsubmit="return confirm('Are you sure?')"
                                              action="{{ route('subscribers.destroy', [$sub->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </button>
                                        </form>
                                        @endcan


                                        </a>


                                    </div>


                                </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                    {{ $subscribers->links("vendor.pagination.default") }}
                </div><!-- /.span -->
            </div><!-- /.row -->


            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div>
    <script>
        function validate(form) {

            // validation code here ...


            if (!valid) {
                alert('Please correct the errors in the form!');
                return false;
            }
            else {
                return confirm('Do you really want to submit the form?');
            }
        }
    </script>
@endsection
