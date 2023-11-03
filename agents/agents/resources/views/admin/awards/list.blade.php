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
                Awards
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
                            <div class="col-md-10">
                                <form action="{{ route('awards.index') }}">
                                    <input type="text" value="{{ Input::get('name') }}" name="name"
                                           placeholder="Search here..."/>
                                    <input value="Search" type="submit" class="btn btn-sm btn-success"/>
                                </form>
                            </div>
                            @can('user_auth', ["add"])
                                <div class="col-md-2">
                                    <a style="float: right; margin-bottom: 9px;" class="btn btn-success"
                                       href="{{ route("awards.create") }}"> Add New </a>
                                    @endcan
                                </div>
                        </div>


                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                            <tr>

                                <th class="detail-col">Name</th>
                                <th>Image</th>


                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($awards as $award)
                                <tr>


                                    <td class="hidden-480">
                                        {{ $award->awardname }}
                                    </td>
                                    <td>       <img style="height: 154px;" src="{{ asset("storage/app/".$award->image) }}" class="img-reponsive" alt="room-image"/></td>


                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">


                                            @can('user_auth', ["delete"])

                                                <form method="POST" style="float: left;margin-right: 5px;"
                                                      onsubmit="return confirm('Are you sure?')"
                                                      action="{{ route('awards.destroy', [$award->id]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-xs btn-danger">
                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('user_auth', ["edit"])
                                                <a href="{{ route('awards.edit',$award->id) }}">
                                                    <button class="btn btn-xs btn-info">
                                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                    </button>
                                                </a>
                                            @endcan


                                        </div>


                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $awards->links("vendor.pagination.default") }}
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
